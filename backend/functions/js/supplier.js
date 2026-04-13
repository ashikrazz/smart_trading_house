function show_datatable(){
    $("#contentWrapper").load("contents/supplier_datatable.php");
}

function supplier_pic_upload() {
    var file = $("#supplier_profile_pic").prop("files")[0];
    if (!file) return;
    var fd = new FormData();
    fd.append("file", file);
    fd.append("path", "../../../resources/supplier/profile_pic/");

    var allowed = /(\.jpg|\.jpeg|\.png)$/i;
    if (!allowed.exec(file.name)) { alert("Upload jpg/jpeg/png only"); return; }

    $.ajax({
        url: "functions/lib/web_upload_file.php",
        type: "POST",
        data: fd,
        contentType: false,
        processData: false,
        success: function(res) {
            $("#hidden_profile_pic").val(res);
            $("#uploaded_profile_pic").html('<img src="../resources/supplier/profile_pic/' + res + '" style="width:100px;">');
        }
    });
}

function call_back(php_script_response){
    return php_script_response;
}


// Email/username duplicacy check
async function check_duplicacy(field, value) {
    if(!value.trim()) return false;
    try {
        let res = await $.ajax({
            type: "POST",
            url: "functions/supplier.php",
            data: { operation: "check_duplicacy", field: field, value: value },
            dataType: "text"
        });
        return parseInt(res) > 0;
    } catch(e) {
        console.error(e);
        return false;
    }
}

async function save_supplier() {
    $(".error-msg").remove();
    $(".form-group").css('border','');

    let full_name = $("#full_name").val().trim();
    let user_name = $("#user_name").val().trim();
    let email = $("#email").val().trim();
    let phone = $("#phone").val().trim();
    let nid = $("#nid").val().trim();
    let address = $("#address").val().trim();
    let password = $("#password").val();
    let confirm_password = $("#confirm_password").val();
    let profile_pic = $("#hidden_profile_pic").val();

    let hasError = false;

    function showError(id,msg){
        let $wrapper = $("#" + id + "_wrapper");
        $wrapper.append('<small class="error-msg" style="color:red;display:block;margin-top:3px;">'+msg+'</small>');
        hasError = true;
    }

    if(full_name=="") showError("full_name","Full Name Required");
    if(user_name=="") showError("user_name","Username Required");
    else if(await check_duplicacy("username", user_name)) showError("user_name","Username Already Exists");
    if(email=="") showError("email","Email Required");
    else if(!/^[a-zA-Z0-9]+([._%+-]?[a-zA-Z0-9]+)*@[a-zA-Z0-9]+(-?[a-zA-Z0-9]+)*(\.[a-zA-Z]{2,})+$/.test(email)) showError("email","Invalid Email Format");
    else if(await check_duplicacy("email", email)) showError("email","Email Already Exists");
    if(phone=="") showError("phone","Phone Required");
    else if(!/^01[3-9]\d{8}$/.test(phone)) showError("phone","Invalid Phone Number");
    if(nid=="") showError("nid","NID Required");
    else if(!/^[0-9]{10,17}$/.test(nid)) showError("nid","Invalid NID Number");
    if(address=="") showError("address","Address Required");
    if(password=="") showError("password","Password Required");
    else if(password.length < 8 || password.length > 20) {
        showError("password", "Password must be 8-20 characters long");
    }
    else if(!/(?=.*[a-z])/.test(password)) {
        showError("password", "Password must contain at least one lowercase letter");
    }
    else if(!/(?=.*[A-Z])/.test(password)) {
        showError("password", "Password must contain at least one uppercase letter");
    }
    else if(!/(?=.*\d)/.test(password)) {
        showError("password", "Password must contain at least one number");
    }
    else if(!/(?=.*[!@#$%^&*])/.test(password)) {
        showError("password", "Password must contain at least one special character (!@#$%^&*)");
    }
    if(confirm_password=="") showError("confirm_password","Confirm Password Required");
    else if(password!=confirm_password) showError("confirm_password","Passwords do not match");
    if(profile_pic=="") showError("profile_pic","Profile Picture Required");

    if(hasError) return false;

    let dataStr = $("#supplierForm").serialize() + "&operation=save";

    $.ajax({
        url:"functions/supplier.php",
        type:"POST",
        data:dataStr,
        dataType:"text",
        success:function(res){
            if(res.trim()=="Success"){
                toastr.success("Supplier Added Successfully");
                $("#supplierForm")[0].reset();
                $("#uploaded_profile_pic").html("");
                setTimeout(()=>{ window.location.href="?page=manage_supplier"; },1000);
            } else {
                toastr.error("Failed to Add Supplier");
            }
        },
        error:function(){ toastr.error("AJAX Error Occurred"); }
    });
}

// ---------------- Live Error Removal ----------------
$(document).ready(function(){
    $("#full_name,#user_name,#email,#phone,#nid,#password,#confirm_password,#address,#supplier_profile_pic")
        .on("input change", function(){
            let id = this.id;
            $("#" + id + "_wrapper").css('border','');
            $(this).siblings(".error-msg").remove();
            if(id==="confirm_password"){
                if($("#password").val() === $("#confirm_password").val()){
                    $("#confirm_password_wrapper").css('border','');
                    $("#confirm_password_wrapper").find(".error-msg").remove();
                }
            }
        });
});

function update(id){
    var dataStr = $("#supplierForm").serialize();
    dataStr += "&id=" + id + "&operation=update";
    $.ajax({
        url: "functions/supplier.php",
        type: "POST",
        data: dataStr,
        success: function (res) {
            res = res.trim();
            if (res === "Success") {
                toastr.success("Supplier Updated Successfully");
                setTimeout(function () {
                    window.location.href = "?page=manage_supplier";
                }, 1000); // 1.0 seconds
            } else {
                toastr.error("Supplier Update Failed");
            }
        }
    });
}

function change_password(id){
    form = 'userForm';
    var operation = "change_password";
    dataStr = $('#'+form).serialize();
    dataStr = dataStr+"&id="+id+"&operation="+operation;
    var password = $("#password").val();
    var confirm_password = $("#confirm_password").val();
    if(password == "") {
        toastr.error("New Password Cannot be Blank");
        $('#password').css('border-color', '#FF0000');
        $('#password').focus();
        return false;
    } else if(confirm_password == "") {
        toastr.error("Confirm Password Cannot be Blank");
        $('#confirm_password').css('border-color', '#FF0000');
        $('#confirm_password').focus();
        return false;
    } else if (confirm_password.length < 6) {
        toastr.error("Password must be at least 6 characters long ");
        $("#confirm_password").css("border-color", "#FF0000");
        $("#confirm_password").focus();
        return false;
    } else if(password!=confirm_password){
        toastr.error("Password Did not matched. Please Try with another.");
        $("#confirm_password").css("border-color", "#FF0000");
        $("#confirm_password").focus();
        return false;
    } else {
        $("div#divLoading3").addClass('show');
        $.ajax({
            url: 'functions/supplier.php',
            dataType: 'text',
            data: dataStr,
            type: 'POST',
            success: function(php_script_response){
                if(php_script_response=='Success'){
                    $("div#divLoading3").removeClass('show');
                    toastr.success("New Password Set Successfully");
                } else {
                    toastr.error("Sorry User Password Failed to Change. Please Try Again");
                }
            }
        });
    }
}

/* PUBLISH */
function publish(id) {
    $.post("functions/supplier.php", { id, operation: "publish" }, function (res) {
        res = res.trim();
        if (res === "Success") {
            toastr.success("Supplier Published Successfully");
            $("#contentWrapper").load("contents/supplier_datatable.php");
        } else {
            toastr.error("Supplier Publish Failed");
        }
    });
}


/* UNPUBLISH */
function unpublish(id) {
    $.post("functions/supplier.php", { id, operation: "unpublish" }, function (res) {
        res = res.trim();
        if (res === "Success") {
            toastr.success("Supplier Unpublished Successfully");
            $("#contentWrapper").load("contents/supplier_datatable.php");
        } else {
            toastr.error("Supplier Unpublish Failed");
        }
    });
}


/* REMOVE */
function removed(id) {
    $.post("functions/supplier.php", { id, operation: "remove" }, function (res) {
        res = res.trim();
        if (res === "Success") {
            toastr.success("Supplier Removed Successfully");
            $("#contentWrapper").load("contents/supplier_datatable.php");
        } else {
            toastr.error("Supplier Removed Failed");
        }
    });
}
