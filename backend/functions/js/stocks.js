function show_stocks_datatable(){
    $("#contentWrapper").load("contents/product_stocks_datatable.php");
}

// ================= SAVE PRODUCT STOCKS =================
async function save_product_stocks(){
    $(".error-msg").remove();
    $(".form-control").removeClass("border-danger");

    let product_id      = $("#product_id").val();
    let stocks_amount   = $("#stocks_amount").val().trim();
    let stocks_min      = $("#stocks_min").val().trim();
    let purchase_date   = $("#exampleInputpurchasedate").val();

    let hasError = false;

    function showError(id, msg){
        let $wrapper = $("#" + id + "_wrapper");
        let $input   = $wrapper.find(".form-control");

        // red border
        $input.addClass("border-danger");

        // error message
        $wrapper.append(
            '<small class="error-msg text-danger d-block mt-1">'+msg+'</small>'
        );

        hasError = true;
    }

    // ================= VALIDATION =================
    if(product_id === "") showError("product", "Product is required");

    if(stocks_amount === "") {
        showError("stock_amount", "Stock Amount is required");
    } else if(stocks_amount <= 0) {
        showError("stock_amount", "Stock Amount must be greater than 0");
    }

    if(stocks_min === "") {
        showError("min_stock", "Minimum Stock is required");
    } else if(stocks_min < 0) {
        showError("min_stock", "Minimum Stock cannot be negative");
    }

    if(purchase_date === "") showError("date", "Date is required");

    if(hasError) return false;

    // ================= SAVE =================
    let dataStr = $("#productStockForm").serialize() + "&operation=save";
    alert( dataStr);

    $.ajax({
        url: "functions/stocks.php",
        type: "POST",
        data: dataStr,
        dataType: "text",
        success: function(res){
            if(res.trim() === "Success"){
                toastr.success("Product Stock Added Successfully");
                $("#productStockForm")[0].reset();
                $(".form-control").removeClass("border-danger");
                setTimeout(()=>{
                    window.location.href = "?page=manage_stocks";
                },1000);
            } else {
                toastr.error("Failed to Add Product Stock");
            }
        },
        error: function(){
            toastr.error("AJAX Error Occurred");
        }
    });
}


// ================= LIVE ERROR REMOVAL =================
$(document).ready(function(){

    $("#product_id,#stocks_amount,#stocks_min,#exampleInputpurchasedate")
        .on("input change", function(){

            let id = this.id;
            let wrapperId = "";

            if(id === "product_id") wrapperId = "product_wrapper";
            else if(id === "stocks_amount") wrapperId = "stock_amount_wrapper";
            else if(id === "stocks_min") wrapperId = "min_stock_wrapper";
            else if(id === "exampleInputpurchasedate") wrapperId = "date_wrapper";

            // remove border
            $(this).removeClass("border-danger");

            // remove error message
            $("#" + wrapperId).find(".error-msg").remove();
        });
});

function update_product_stocks(){
    form = 'productStockForm';
    var operation = "update";
    dataStr = $('#'+form).serialize();
    
    var variant_id = $("#variant_id").val();
    dataStr = dataStr+"&operation="+operation;
    alert(dataStr);
        $.ajax({
            url: 'functions/stocks.php',
            dataType: 'text',
            data: dataStr,
            type: 'POST',
            success: function(php_script_response){
                if(php_script_response=='Success'){
                    toastr.success("Product Stocks Updated Successfully");
                } else {
                    toastr.error("Sorry Product Stocks Failed to Update. Please Try Again");
                }
            }
        });

}
