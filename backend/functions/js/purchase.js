function show_datatable(){
    $("#contentWrapper").load("contents/purchase_datatable.php");
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
                    toastr.success("Purchase Added Successfully");
                } else {
                    alert(php_script_response);
                    toastr.error("Sorry Purchase Failed to Add. Please Try Again");
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
                    toastr.success("Purchase Updated Successfully");
                } else {
                    toastr.error("Sorry Purchase Failed to Update. Please Try Again");
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
                toastr.success("Purchase Published Successfully");
                $("#contentWrapper").load("contents/user_datatable.php");
            } else {
                toastr.error("Sorry Purchase Failed to Publish. Please Try Again");
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
                toastr.error("Sorry Purchase Failed to Unpublish. Please Try Again");
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
                toastr.success("Purchase Deleted Successfully");
                $("#contentWrapper").load("contents/user_datatable.php");
            } else {
                toastr.error("Sorry Purchase Failed to Delete. Please Try Again");
            }
        }
    });
}