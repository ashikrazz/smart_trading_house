<?php
include ("config/my_class_for_web.php");
$obj = new my_class();
extract($_REQUEST);
?>
<script src="functions/js/stocks.js"></script>
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Add Stocks</h4>
            </div>
            <div class="col-md-7 align-self-center text-end">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Add Stocks</li>
                    </ol>
                    <button type="button" class="btn btn-info d-none d-lg-block m-l-15 text-white" onclick="window.location.href='?page=manage_stocks'"><i class="fa fa-binoculars"></i> View All Stocks</button>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <!-- Validation wizard -->
        <div class="row" id="validation">
            <div class="col-12">
                <div class="card wizard-content">
                    <div class="card-body">
                        <h4 class="card-title">Stocks Panel</h4>
                        <form id="productStockForm" name="productStockForm">

                            <div class="row">

                                <div class="col-md-6" id="product_wrapper">
                                    <div class="form-group">
                                        <label>Product</label>
                                        <select class="form-control" id="product_id" name="product_id" aria-describedby="sProduct">
                                            <option value="">-- Select Product --</option>
                                            <?php 
                                                foreach($obj->View_All_By_Cond("products","active_flag=1") as $value){
                                                    echo "<option value='".$value['id']."'>".$value['product_name']."</option>";
                                                }
                                            ?>
                                        </select>
                                        <small id="sProduct" class="form-text text-muted">Select Product from Dropdown.</small>
                                    </div>
                                </div>

                                <div class="col-md-6" id="product_wrapper">
                                    <div class="form-group">
                                        <label>Variant</label>
                                        <select class="form-control" id="variant_id" name="variant_id" aria-describedby="sProduct">
                                            <option value="">-- Select Variant --</option>
                                        </select>
                                        <small id="sProduct" class="form-text text-muted">Select Product from Dropdown.</small>
                                    </div>
                                </div>

                                <div class="col-md-6" id="stock_amount_wrapper">
                                    <div class="form-group">
                                        <label>Stocks Amount</label>
                                        <input type="number" class="form-control" id="stocks_amount" aria-describedby="stockAmount" name="stocks_amount" value="">
                                        <small id="stockAmount" class="form-text text-muted">Enter Selected Product Stock Amount.</small>
                                    </div>
                                </div>

                                <div class="col-md-6" id="min_stock_wrapper">
                                    <div class="form-group">
                                        <label>Stocks Min</label>
                                        <input type="number" class="form-control" id="stocks_min" aria-describedby="stockMin" name="stocks_min" value="">
                                        <small id="stockMin" class="form-text text-muted">Enter Minimum Stock Amount for Show Alert.</small>
                                    </div>
                                </div>

                                <div class="col-md-6" id="date_wrapper">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="date" class="form-control" id="exampleInputpurchasedate" aria-describedby="pdateHelp" value="<?=date('Y-m-d')?>">
                                        <small id="pdateHelp" class="form-text text-muted">Add Date is Auto Selected.</small>
                                    </div>
                                </div>

                            </div>

                        
                                
                                <button type="button" onclick="update_product_stocks()" class="btn btn-primary mt-3">Save Product Stocks</button>


                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->


<script>
$("#product_id").on("change", function () {
    let product_id = $(this).val();
    
    $("#variant_id").html('<option value="">Loading...</option>');
    
    if (product_id === "") {
        $("#variant_id").html('<option value="">-- Select Variant --</option>');
        return;
    }
    
    $.ajax({
        url: "functions/stocks.php",
        type: "POST",
        data: { product_id: product_id },
        success: function (res) {
            $("#variant_id").html(res);
        }
    });
});
</script>
