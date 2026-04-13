function show_datatable(){
    $("#contentWrapper").load("contents/product_datatable.php");
}
function call_back(php_script_response){
    return php_script_response;
}


function save_product(){
    form = 'product_form';
    var operation = "save";
    dataStr = $('#'+form).serialize();
    var productName = $("#productName").val();
    dataStr = dataStr+"&operation="+operation;
    alert(dataStr);
    if(productName == "") {
        toastr.error("Please Enter Product Name");
        $('#productName').css('border-color', '#FF0000');
        $('#productName').focus();
        return false;
    } else {
        $.ajax({
            url: 'functions/products.php',
            dataType: 'text',
            data: dataStr,
            type: 'POST',
            success: function(res){
                //alert(php_script_response);
                if(!isNaN(res)){
                    $("#product_id").val(res);
                    toastr.success("Product Added Successfully");
                } else {
                    //alert(php_script_response);
                    toastr.error("Sorry Product Failed to Add. Please Try Again");
                }
            }
        });
    }
    //clearInput();
}

function update_product(id){
    form = 'product_form';
    var operation = "update";
    dataStr = $('#'+form).serialize();
    dataStr = dataStr+"&id="+id+"&operation="+operation;
    var variant = $("#variant").val();
    alert(dataStr);
    if(variant == "") {
        toastr.error("Please Variant");
        $('#variant').css('border-color', '#FF0000');
        $('#variant').focus();
        return false;
    } else {
        $.ajax({
            url: 'functions/products.php',
            dataType: 'text',
            data: dataStr,
            type: 'POST',
            success: function(php_script_response){
                if(php_script_response=='Success'){
                    toastr.success("Product Updated Successfully");
                } else {
                    toastr.error("Sorry Product Failed to Update. Please Try Again");
                }
            }
        });
    }
}

function publish_product(id){
    var operation = "publish";
    dataStr = "id="+id+"&operation="+operation;
    $.ajax({
        url: 'functions/user.php',
        dataType: 'text',
        data: dataStr,
        type: 'POST',
        success: function(php_script_response){
            if(php_script_response=='Success'){
                toastr.success("Product Published Successfully");
                $("#contentWrapper").load("contents/user_datatable.php");
            } else {
                toastr.error("Sorry Product Failed to Publish. Please Try Again");
            }
        }
    });
}

function unpublish_product(id){
    var operation = "unpublish";
    dataStr = "id="+id+"&operation="+operation;

    $.ajax({
        url: 'functions/user.php',
        dataType: 'text',
        data: dataStr,
        type: 'POST',
        success: function(php_script_response){
            if(php_script_response=='Success'){
                toastr.success("Product Unpublished Successfully");
                $("#contentWrapper").load("contents/user_datatable.php");
            } else {
                toastr.error("Sorry Product Failed to Unpublish. Please Try Again");
            }
        }
    });
}

function removed_product(id){
    var operation = "remove";
    dataStr = "id="+id+"&operation="+operation;
    $.ajax({
        url: 'functions/user.php',
        dataType: 'text',
        data: dataStr,
        type: 'POST',
        success: function(php_script_response){
            if(php_script_response=='Success'){
                toastr.success("Product Deleted Successfully");
                $("#contentWrapper").load("contents/user_datatable.php");
            } else {
                toastr.error("Sorry Product Failed to Delete. Please Try Again");
            }
        }
    });
}
