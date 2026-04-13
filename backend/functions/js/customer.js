function show_datatable(){
    $("#contentWrapper").load("contents/customer_datatable.php");
}

function customer_pic_upload() {
    var file = $("#customer_profile_pic").prop("files")[0];
    if (!file) return;
    var fd = new FormData();
    fd.append("file", file);
    fd.append("path", "../../../resources/customer/profile_pic/");

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
            $("#uploaded_customer_profile_pic").html('<img src="../resources/customer/profile_pic/' + res + '" style="width:100px;">');
        }
    });
}

// Email/username duplicacy check
async function check_customer_duplicacy(field, value) {
    if(!value.trim()) return false;
    try {
        let res = await $.ajax({
            type: "POST",
            url: "functions/customer.php",
            data: { operation: "check_customer_duplicacy", field: field, value: value },
            dataType: "text"
        });
        return parseInt(res) > 0;
    } catch(e) {
        console.error(e);
        return false;
    }
}

async function save_customer() {
    //console.log("Save Function Entered");
    $(".error-msg").remove();
    $(".form-group").css('border','');

    let customer_full_name = $("#customer_full_name").val().trim();
    let customer_user_name = $("#customer_user_name").val().trim();
    let customer_email = $("#customer_email").val().trim();
    let customer_phone = $("#customer_phone").val().trim();
    let customer_nid = $("#customer_nid").val().trim();
    let customer_address = $("#customer_address").val().trim();
    let customer_password = $("#customer_password").val();
    let confirm_customer_password = $("#confirm_customer_password").val();
    let customer_profile_pic = $("#hidden_profile_pic").val();
    let user_type = $("#user_type").val();

    let hasError = false;

    function showError(id,msg){
        let $wrapper = $("#" + id + "_wrapper");
        $wrapper.append('<small class="error-msg" style="color:red;display:block;margin-top:3px;">'+msg+'</small>');
        hasError = true;
    }

    if(customer_full_name=="") showError("customer_full_name","Full Name Required");
    if(customer_user_name=="") showError("customer_user_name","Username Required");
    else if(await check_customer_duplicacy("customer_username", customer_user_name)) showError("customer_user_name","Username Already Exists");
    if(customer_email=="") showError("customer_email","Email Required");
    else if (!/^[a-zA-Z0-9]+([._%+-]?[a-zA-Z0-9]+)*@[a-zA-Z0-9]+(-?[a-zA-Z0-9]+)*(\.[a-zA-Z]{2,})+$/.test(customer_email)) {
        showError("customer_email", "Invalid Email Format");
    }
    else if(await check_customer_duplicacy("customer_email", customer_email)) showError("customer_email","Email Already Exists");
    if(customer_phone=="") showError("customer_phone","Phone Required");
    else if (!/^01[3-9]\d{8}$/.test(customer_phone)) {
        showError("customer_phone", "Invalid Phone Number");
    }
    if(customer_nid=="") showError("customer_nid","NID Required");
    else if(!/^[0-9]{10,17}$/.test(customer_nid)) showError("customer_nid","Invalid NID Number");
    if(customer_address=="") showError("customer_address","Address Required");
    if(user_type=="") showError("user_type","User Type Required");
    if(customer_password=="") showError("customer_password","Password Required");
    else if(customer_password.length < 8 || customer_password.length > 20) {
        showError("user_password", "Password must be 8-20 characters long");
    }
    else if(!/(?=.*[a-z])/.test(customer_password)) {
        showError("customer_password", "Password must contain at least one lowercase letter");
    }
    else if(!/(?=.*[A-Z])/.test(customer_password)) {
        showError("customer_password", "Password must contain at least one uppercase letter");
    }
    else if(!/(?=.*\d)/.test(customer_password)) {
        showError("customer_password", "Password must contain at least one number");
    }
    else if(!/(?=.*[!@#$%^&*])/.test(customer_password)) {
        showError("customer_password", "Password must contain at least one special character (!@#$%^&*)");
    }
    if(confirm_customer_password=="") showError("confirm_customer_password","Confirm Password Required");
    else if(customer_password!=confirm_customer_password) showError("confirm_customer_password","Passwords do not match");
    if(customer_profile_pic=="") showError("customer_profile_pic","Profile Picture Required");

    if(hasError) return false;

    let dataStr = $("#customerForm").serialize() + "&operation=customer_save";
    //console.log(dataStr);
    //alert(dataStr);

    $.ajax({
        url:"functions/customer.php",
        type:"POST",
        data:dataStr,
        dataType:"text",
        success:function(res){
            //alert(res);
            if(res.trim()=="Success"){
                toastr.success("Customer Added Successfully");
                $("#customerForm")[0].reset();
                $("#uploaded_customer_profile_pic").html("");
                setTimeout(()=>{ window.location.href="?page=manage_customer"; },1000);
            } else {
                toastr.error("Failed to Add Customer");
            }
        },
        error:function(){ toastr.error("AJAX Error Occurred"); }
    });
}

// ---------------- Live Error Removal ----------------
$(document).ready(function(){
    $("#customer_full_name,#customer_user_name,#customer_email,#customer_phone,#customer_nid,#customer_password,#confirm_customer_password,#customer_address,#user_type,#customer_profile_pic")
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


function update_customer(id){
    var dataStr = $("#customerForm").serialize();
    dataStr += "&id=" + id + "&operation=update";
    $.ajax({
        url: "functions/customer.php",
        type: "POST",
        data: dataStr,
        success: function (res) {
            res = res.trim();
            if (res === "Success") {
                toastr.success("Customer Updated Successfully");
                setTimeout(function () {
                    window.location.href = "?page=manage_customer";
                }, 1000); // 1.0 seconds
            } else {
                toastr.error("Customer Update Failed");
            }
        }
    });
}


/* PUBLISH */
function publish_customer(id) {
    $.post("functions/customer.php", { id, operation: "publish" }, function (res) {
        res = res.trim();
        if (res === "Success") {
            toastr.success("Customer Published Successfully");
            $("#contentWrapper").load("contents/customer_datatable.php");
        } else {
            toastr.error("Customer Publish Failed");
        }
    });
}


/* UNPUBLISH */
function unpublish_customer(id) {
    $.post("functions/customer.php", { id, operation: "unpublish" }, function (res) {
        res = res.trim();
        if (res === "Success") {
            toastr.success("Customer Unpublished Successfully");
            $("#contentWrapper").load("contents/customer_datatable.php");
        } else {
            toastr.error("Customer Unpublish Failed");
        }
    });
}


/* REMOVE */
function customer_removed(id) {
    $.post("functions/customer.php", { id, operation: "remove" }, function (res) {
        res = res.trim();
        if (res === "Success") {
            toastr.success("Customer Removed Successfully");
            $("#contentWrapper").load("contents/customer_datatable.php");
        } else {
            toastr.error("Customer Removed Failed");
        }
    });
}