function show_datatable(){
    $("#contentWrapper").load("contents/user_datatable.php");
}

/* ---------------- Profile Picture Upload ---------------- */
function user_pic_upload() {
    var file = $("#user_profile_pic").prop("files")[0];
    if (!file) return;

    var fd = new FormData();
    fd.append("file", file);
    fd.append("path", "../../../resources/user/profile_pic/");

    var allowed = /(\.jpg|\.jpeg|\.png)$/i;
    if (!allowed.exec(file.name)) {
        alert("Upload jpg/jpeg/png only");
        return;
    }

    $.ajax({
        url: "functions/lib/web_upload_file.php",
        type: "POST",
        data: fd,
        contentType: false,
        processData: false,
        success: function(res) {
            $("#hidden_user_profile_pic").val(res);
            $("#uploaded_user_profile_pic").html(
                '<img src="../resources/user/profile_pic/' + res + '" style="width:100px;">'
            );
        }
    });
}

/* ---------------- Email / Username Duplicacy Check ---------------- */
async function check_user_duplicacy(field, value) {
    if(!value.trim()) return false;
    try {
        let res = await $.ajax({
            type: "POST",
            url: "functions/user.php",
            data: { operation: "check_user_duplicacy", field: field, value: value },
            dataType: "text"
        });
        return parseInt(res) > 0;
    } catch(e) {
        console.error(e);
        return false;
    }
}

/* ---------------- Save User ---------------- */
async function save_user() {
    $(".error-msg").remove();
    $(".form-group").css('border','');

    let user_full_name   = $("#user_full_name").val().trim();
    let user_user_name   = $("#user_user_name").val().trim();
    let user_email       = $("#user_email").val().trim();
    let user_phone       = $("#user_phone").val().trim();
    let user_nid         = $("#user_nid").val().trim();
    let user_address     = $("#user_address").val().trim();
    let user_type        = $("#user_type").val();
    let user_role        = $("#user_role").val();
    let user_password    = $("#user_password").val().trim();
    let confirm_password = $("#confirm_user_password").val().trim();
    let user_profile_pic = $("#hidden_user_profile_pic").val();

    let hasError = false;

    function showError(id, msg){
        let $wrapper = $("#" + id + "_wrapper");
        $wrapper.append(
            '<small class="error-msg" style="color:red;display:block;margin-top:3px;">'+msg+'</small>'
        );
        hasError = true;
    }

    if(user_full_name==="") showError("user_full_name","Full Name Required");

    if(user_user_name==="") showError("user_user_name","Username Required");
    else if(await check_user_duplicacy("user_name", user_user_name))
        showError("user_user_name","Username Already Exists");

    if(user_email==="") showError("user_email","Email Required");
    else if (!/^[a-zA-Z0-9]+([._%+-]?[a-zA-Z0-9]+)*@[a-zA-Z0-9]+(-?[a-zA-Z0-9]+)*(\.[a-zA-Z]{2,})+$/.test(user_email)) {
        showError("user_email", "Invalid Email Format");
    }
    else if(await check_user_duplicacy("user_email", user_email)) {
        showError("user_email", "Email Already Exists");
    }
    if(user_phone==="") showError("user_phone","Phone Required");
    else if (!/^01[3-9]\d{8}$/.test(user_phone)) {
        showError("user_phone", "Invalid Phone Number");
    }

    if(user_nid==="") showError("user_nid","NID Required");
    else if(!/^[0-9]{10,17}$/.test(user_nid))
        showError("user_nid","Invalid NID Number");

    if(user_address==="") showError("user_address","Address Required");
    if(user_type==="") showError("user_type","Type Required");
    if(user_role==="") showError("user_role","Role Required");

    if(user_password==="") showError("user_password","Password Required");
    else if(user_password.length < 8 || user_password.length > 20) {
        showError("user_password", "Password must be 8-20 characters long");
    }
    else if(!/(?=.*[a-z])/.test(user_password)) {
        showError("user_password", "Password must contain at least one lowercase letter");
    }
    else if(!/(?=.*[A-Z])/.test(user_password)) {
        showError("user_password", "Password must contain at least one uppercase letter");
    }
    else if(!/(?=.*\d)/.test(user_password)) {
        showError("user_password", "Password must contain at least one number");
    }
    else if(!/(?=.*[!@#$%^&*])/.test(user_password)) {
        showError("user_password", "Password must contain at least one special character (!@#$%^&*)");
    }
    if(confirm_password==="") showError("confirm_user_password","Confirm Password Required");
    else if(user_password !== confirm_password)
        showError("confirm_user_password","Passwords do not match");

    if(user_profile_pic==="") showError("user_profile_pic","Profile Picture Required");

    if(hasError) return false;

    let dataStr = $("#userForm").serialize() + "&operation=user_save";

    $.ajax({
        url:"functions/user.php",
        type:"POST",
        data:dataStr,
        dataType:"text",
        success:function(res){
            if(res.trim()==="Success"){
                toastr.success("User Added Successfully");
                $("#userForm")[0].reset();
                $("#uploaded_user_profile_pic").html("");
                setTimeout(()=>{
                    window.location.href="?page=manage_user";
                },1000);
            } else {
                toastr.error("Failed to Add User");
            }
        },
        error:function(){
            toastr.error("AJAX Error Occurred");
        }
    });
}

/* ---------------- Live Error Removal ---------------- */
$(document).ready(function(){
    $("#user_full_name,#user_user_name,#user_email,#user_phone,#user_nid,#user_password,#confirm_user_password,#user_address,#user_type,#user_role,#user_profile_pic")
        .on("input change", function(){
            let id = this.id;
            $("#" + id + "_wrapper").css('border','');
            $(this).siblings(".error-msg").remove();

            if(id==="confirm_user_password"){
                if($("#user_password").val() === $("#confirm_user_password").val()){
                    $("#confirm_user_password_wrapper").find(".error-msg").remove();
                }
            }
        });
});

/* ---------------- Update User ---------------- */
function update_user(id){
    var dataStr = $("#userForm").serialize();
    dataStr += "&id=" + id + "&operation=update";
    //alert( dataStr);
    $.ajax({
        url: "functions/user.php",
        type: "POST",
        data: dataStr,
        success: function (res) {
            res = res.trim();
            //alert(res);
            if (res === "Success") {
                toastr.success("User Updated Successfully");
                setTimeout(function () {
                    window.location.href = "?page=manage_user";
                }, 1000);
            } else {
                toastr.error("User Update Failed");
            }
        }
    });
}

/* ---------------- PUBLISH ---------------- */
function publish_user(id) {
    $.post("functions/user.php", { id, operation: "publish" }, function (res) {
        res = res.trim();
        if (res === "Success") {
            toastr.success("User Published Successfully");
            $("#contentWrapper").load("contents/user_datatable.php");
        } else {
            toastr.error("User Publish Failed");
        }
    });
}

/* ---------------- UNPUBLISH ---------------- */
function unpublish_user(id) {
    $.post("functions/user.php", { id, operation: "unpublish" }, function (res) {
        res = res.trim();
        if (res === "Success") {
            toastr.success("User Unpublished Successfully");
            $("#contentWrapper").load("contents/user_datatable.php");
        } else {
            toastr.error("User Unpublish Failed");
        }
    });
}

/* ---------------- REMOVE ---------------- */
function user_removed(id) {
    $.post("functions/user.php", { id, operation: "remove" }, function (res) {
        res = res.trim();
        if (res === "Success") {
            toastr.success("User Removed Successfully");
            $("#contentWrapper").load("contents/user_datatable.php");
        } else {
            toastr.error("User Remove Failed");
        }
    });
}
