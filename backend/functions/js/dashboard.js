function profile_pic_upload(){
    $("div#divLoading2").addClass('show');
    var file_data = $('#profile_pic').prop('files')[0];
    var fd = new FormData();
    fd.append('file', file_data);
    var file_path = "../../../resources/user/profile_pic/";
    fd.append('path', file_path);
    //var file_name;
    var file_name = null;
    var fileInput =  document.getElementById('profile_pic');
    var filePath = fileInput.value;
    var file_name = null;
    var allowedExtensions =  /(\.jpg|\.jpef|\.png)$/i;
    if (!allowedExtensions.exec(filePath)) {
        toastr.error('Please Upload File in jpg/jpeg/png Format');
        document.value = '';
        return false;
    } else {
        $("div#divLoading2").addClass('show');
        $.ajax({
            url: 'functions/lib/web_upload_file.php', // point to server-side PHP script
            //dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: fd,
            type: 'POST',
            success: function(php_script_response){
                file_name = php_script_response;
                $("#hidden_profile_pic").val(php_script_response);
                $("div#divLoading2").removeClass('show');
                var img = document.createElement("IMG");
                img.src = "../resources/user/profile_pic/"+file_name;
                img.style ="width: 100px";
                $('#uploaded_profile_pic').html(img);
            }
        });
    }
}

function call_back(php_script_response){
    return php_script_response;
}


function save(){
    form = 'userForm';
    var operation = "save";
    dataStr = $('#'+form).serialize();
    var name = $("#name").val();
    dataStr = dataStr+"&operation="+operation;
    //alert(dataStr);
    if(name == "") {
        toastr.error("Please Enter Full Name");
        $('#name').css('border-color', '#FF0000');
        $('#name').focus();
        return false;
    } else {
        $("div#divLoading3").addClass('show');
        $.ajax({
            url: 'functions/user.php',
            dataType: 'text',
            data: dataStr,
            type: 'POST',
            success: function(php_script_response){
                if(php_script_response=='Success'){
                    $("div#divLoading3").removeClass('show');
                    toastr.success("User Added Successfully");
                } else {
                    alert(php_script_response);
                    toastr.error("Sorry User Failed to Add. Please Try Again");
                }
            }
        });
    }
    //clearInput();
}

function update(id){
    form = 'userForm';
    var operation = "update";
    dataStr = $('#'+form).serialize();
    dataStr = dataStr+"&id="+id+"&operation="+operation;
    var name = $("#name").val();
    if(name == "") {
        toastr.error("Please Enter Full Name");
        $('#name').css('border-color', '#FF0000');
        $('#name').focus();
        return false;
    } else {
        $("div#divLoading3").addClass('show');
        $.ajax({
            url: 'functions/user.php',
            dataType: 'text',
            data: dataStr,
            type: 'POST',
            success: function(php_script_response){
                if(php_script_response=='Success'){
                    $("div#divLoading3").removeClass('show');
                    toastr.success("User Updated Successfully");
                } else {
                    toastr.error("Sorry User Failed to Update. Please Try Again");
                }
            }
        });
    }
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
            url: 'functions/user.php',
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

function publish(id){
    var operation = "publish";
    dataStr = "id="+id+"&operation="+operation;
    $.ajax({
        url: 'functions/user.php',
        dataType: 'text',
        data: dataStr,
        type: 'POST',
        success: function(php_script_response){
            if(php_script_response=='Success'){
                toastr.success("User Published Successfully");
                $("#contentWrapper").load("contents/user_datatable.php");
            } else {
                toastr.error("Sorry User Failed to Publish. Please Try Again");
            }
        }
    });
}

function unpublish(id){
    var operation = "unpublish";
    dataStr = "id="+id+"&operation="+operation;

    $.ajax({
        url: 'functions/user.php',
        dataType: 'text',
        data: dataStr,
        type: 'POST',
        success: function(php_script_response){
            if(php_script_response=='Success'){
                toastr.success("User Unpublished Successfully");
                $("#contentWrapper").load("contents/user_datatable.php");
            } else {
                toastr.error("Sorry User Failed to Unpublish. Please Try Again");
            }
        }
    });
}

function removed(id){
    var operation = "remove";
    dataStr = "id="+id+"&operation="+operation;
    $.ajax({
        url: 'functions/user.php',
        dataType: 'text',
        data: dataStr,
        type: 'POST',
        success: function(php_script_response){
            if(php_script_response=='Success'){
                toastr.success("User Deleted Successfully");
                $("#contentWrapper").load("contents/user_datatable.php");
            } else {
                toastr.error("Sorry User Failed to Delete. Please Try Again");
            }
        }
    });
}