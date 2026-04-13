<?php
include ("config/my_class_for_web.php");
$obj = new my_class();
extract($_REQUEST);
?>
<script src="functions/js/products.js"></script>
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
                        <h4 class="text-themecolor">Add Product</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-end">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb justify-content-end">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                <li class="breadcrumb-item active">Add Product</li>
                            </ol>
                            <button type="button" class="btn btn-info d-none d-lg-block m-l-15 text-white" onclick="window.location.href='?page=manage_products'"><i class="fas fa-binoculars"></i> View All Products</button>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Product Panel</h4>
                                <div class="row" id="validation">
                                        <div class="col-12">
                                            <div class="card wizard-content">
                                                <div class="card-body">
                                                    <form action="#" class="validation-wizard wizard-circle" id="product_form">
                                                        <!-- Step 1 -->
                                                        <h6>Product Details</h6>
                                                        <section>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="category"> Select Product Category: <span class="danger">*</span> </label>
                                                                        <select class="select2 form-select form-control required" id="category" name="category">
                                                                            <option value="">Select Category</option>
                                                                            <?php
                                                                            foreach ($obj->View_All_By_Cond("web_product_type","active_flag=1") as $row) {
                                                                                $selected = (!empty($product_type_ref) && $product_type_ref == $row['id']) ? "selected='selected'" : "";
                                                                                echo "<option value='{$row['id']}' $selected>
                                                                                {$row['product_type_title']}
                                                                              </option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="sub_category"> Select Product Sub-Category: <span class="danger">*</span> </label>
                                                                        <select class="select2 form-select form-control required" id="sub_category" name="sub_category">

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="brand"> Select Product Brand: <span class="danger">*</span> </label>
                                                                        <select class="select2 form-select form-control required" id="brand" name="brand">
                                                                            <option value="">Select Brand</option>
                                                                            <?php
                                                                            foreach ($obj->View_All_By_Cond("brand","active_flag=1") as $row) {
                                                                                $selected = (!empty($brand_ref) && $brand_ref == $row['id']) ? "selected='selected'" : "";
                                                                                echo "<option value='{$row['id']}' $selected>
                                                                                {$row['brand_name']}
                                                                              </option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="productName"> Product Name: <span class="danger">*</span> </label>
                                                                        <input type="text" class="form-control required" id="productName" name="productName">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="description"> Product Description: </label>
                                                                        <textarea name="description" id="description" rows="6" class="form-control"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="status"> Status : </label>
                                                                        <select class="form-select form-control" id="status" name="status">
                                                                            <option value="1">Publish</option>
                                                                            <option value="2">Unpublish</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </section>
                                                        <!-- Step 2 -->
                                                        <h6>Variant / Pricing / Stocks</h6>
                                                        <section>
                                                            <input type="hidden" id="product_id" name="product_id">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="variant_type"> Select Variant Type: <span class="danger">*</span> </label>
                                                                        <select class="form-select form-control required" id="variant_type" name="variant_type">
                                                                            <option value="">Select Variant Type</option>
                                                                            <?php
                                                                            foreach($obj->View_All_By_Cond("variant_type","active_flag=1") as $v){
                                                                                echo "<option value='".$v['id']."'>".$v['variant']."</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="variant"> Enter Variant: <span class="danger">*</span> </label>
                                                                        <input type="text" class="form-control required" id="variant" name="variant">
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label for="unit_id" class="form-label">Unit.</label>
                                                                        <select class="select2 form-control form-select" style="width: 100%;" id="unit_id" name="unit_id">
                                                                            <option value="">Select</option>
                                                                            <?php
                                                                                foreach($obj->View_All_By_Cond("measurement_unit","active_flag=1") as $m){
                                                                                    echo "<option value='".$m['id']."'>".$m['unit_name']."</option>";
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="buy_price">Buy Price:</label>
                                                                        <input type="number" class="form-control required" id="buy_price" name="buy_price" step="0.50" min="1">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="sell_price">Sell Price:</label>
                                                                        <input type="number" class="form-control" id="sell_price" name="sell_price" step="0.50" min="1">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="vat">Vat % :</label>
                                                                        <input type="number" class="form-control" id="vat" name="vat" step="0.50" min="1">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="stock_in">Stocks QTY:</label>
                                                                        <input type="number" class="form-control required" id="stock_in" name="stock_in" min="1">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="min_stock">Min Stock Limit:</label>
                                                                        <input type="number" class="form-control" id="min_stock" name="min_stock" min="1">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="date">Date:</label>
                                                                        <input type="date" class="form-control required" id="date" name="date" readonly value="<?php echo date('Y-m-d'); ?>">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </section>
                                                    </form>

                                                    <!-- ================= VARIANT LIST ================= -->
                                                    <div class="row mt-4" id="variant_list_section" style="display:none;">
                                                        <div class="col-12">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Added Variants</h4>

                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered table-striped">
                                                                            <thead class="bg-light">
                                                                            <tr>
                                                                                <th>Cat</th>
                                                                                <th>Sub-Cat</th>
                                                                                <th>Brand</th>
                                                                                <th>Product</th>
                                                                                <th>Variant</th>
                                                                                <th>Buy</th>
                                                                                <th>Sell</th>
                                                                                <th>VAT</th>
                                                                                <th>Stock</th>
                                                                                <th>Action</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody id="variant_list_body">
                                                                            <tr>
                                                                                <td colspan="10" class="text-center">No variants added</td>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End Page Content -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->

        <script src="<?= BASE_URL ?>/resources/assets/node_modules/wizard/jquery.steps.min.js"></script>
        <script src="<?= BASE_URL ?>/resources/assets/node_modules/wizard/jquery.validate.min.js"></script>
        <script src="<?= BASE_URL ?>/resources/assets/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
<script>
    /* ================= TAB WIZARD (SAFE) ================= */
    $(".tab-wizard").steps({
        headerTag: "h6",
        bodyTag: "section",
        transitionEffect: "fade",
        titleTemplate: '<span class="step">#index#</span> #title#',
        labels: {
            finish: "Save Product"
        },
        onFinished: function () {
            let id = $("#product_id").val();
            update_product(id);
        }
    });


    /* ================= MAIN VALIDATION WIZARD ================= */

    var $wizardForm = $(".validation-wizard").show();

    $(".validation-wizard").steps({
        headerTag: "h6",
        bodyTag: "section",
        transitionEffect: "fade",
        titleTemplate: '<span class="step">#index#</span> #title#',
        labels: {
            finish: "Save Product"
        },

        /* ---------- STEP CHANGE ---------- */
        onStepChanging: function (event, currentIndex, newIndex) {

            // ✅ BACK STEP ALLOWED
            if (currentIndex > newIndex) {
                return true;
            }

            // ✅ SAVE ONLY WHEN MOVING FORWARD
            if (newIndex > currentIndex) {
                save_product();
            }

            // ✅ CLEAR ERRORS (ORIGINAL LOGIC SAFE)
            $wizardForm.find(".body:eq(" + newIndex + ") label.error").remove();
            $wizardForm.find(".body:eq(" + newIndex + ") .error").removeClass("error");

            // ✅ VALIDATE
            $wizardForm.validate().settings.ignore = ":disabled,:hidden";
            return $wizardForm.valid();
        },

        /* ---------- BEFORE FINISH ---------- */
        onFinishing: function () {
            $wizardForm.validate().settings.ignore = ":disabled";
            return $wizardForm.valid();
        },

        /* ---------- FINISH ---------- */
        onFinished: function () {

            let id = $("#product_id").val();

            // 🔥 UPDATE PRODUCT (VARIANT + PRICE + STOCK)
            update_product(id);
            loadProductVariants(id);

            // 🔔 ASK FOR MORE VARIANT
            setTimeout(function () {
                if (confirm("Want add more variant in this product?")) {
                    // 🔥 LOAD VARIANTS LIST
                    loadProductVariants(id);

                    // ✅ KEEP SAME PRODUCT ID
                    $("#product_id").val(id);

                    // ✅ RESET ONLY STEP-2 FIELDS
                    $("#variant_type").val("").trigger("change");
                    $("#variant").val("");
                    $("#buy_price").val("");
                    $("#sell_price").val("");
                    $("#vat").val("");
                    $("#stock_in").val("");
                    $("#min_stock").val("");

                    // ✅ GO BACK TO STEP-2 (INDEX 1)
                    $(".validation-wizard").steps("setStep", 1);

                } else {
                    // Optional redirect if needed
                    window.location.href = "?page=add_product";
                }

            }, 600);
        }

    });


    /* ================= FORM VALIDATION ================= */
    $wizardForm.validate({
        ignore: "input[type=hidden]",
        errorClass: "text-danger",
        successClass: "text-success",
        highlight: function (element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function (element, errorClass) {
            $(element).removeClass(errorClass);
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        rules: {
            email: {
                email: true
            }
        }
    });
</script>


<script>
    // CATEGORY → SUBCATEGORY LOAD
    $(document).ready(function () {

        // Make sure Select2 is initialized first
        $(".select2").select2();
        $('#category').on('select2:select', function (e) {

            console.log("Category selected");

            let category = $(this).val();
            console.log("Category id: " + category + "");
            if (!category) {
                $("#sub_category").html('<option value="">Select Sub-Category</option>');
                return;
            }

            $.ajax({
                url: "contents/product_ajax.php",
                type: "POST",
                data: {
                    action: "load_subcategory",
                    category_id: category
                },
                success: function (response) {
                    $("#sub_category").html(response).trigger("change");
                },
                error: function () {
                    alert("AJAX error loading sub-category");
                }
            });
        });
    });
</script>


<script>
    function loadProductVariants(product_id) {

        if (!product_id) return;

        $.ajax({
            url: "contents/product_ajax.php",
            type: "POST",
            data: {
                action: "load_product_variants",
                product_id: product_id
            },
            success: function (response) {
                $("#variant_list_body").html(response);
                $("#variant_list_section").slideDown();
            },
            error: function () {
                alert("Failed to load variants");
            }
        });
    }
</script>

<script>
    function editVariant(variant_id) {

        $.ajax({
            url: "contents/product_ajax.php",
            type: "POST",
            dataType: "json",
            data: {
                action: "get_variant_details",
                variant_id: variant_id
            },
            success: function (res) {

                if (!res) {
                    alert("Variant data not found");
                    return;
                }

                // 🔥 LOAD STEP-2 FIELDS
                $("#variant_type").val(res.variant_type_ref).trigger("change");
                $("#variant").val(res.variant_name);
                $("#buy_price").val(parseInt(res.buy_price, 10));
                $("#sell_price").val(parseInt(res.sell_price, 10));
                $("#vat").val(parseInt(res.vat, 10));
                $("#stock_in").val(parseInt(res.stock_in, 10));
                $("#min_stock").val(parseInt(res.min_stock, 10));


                // 🔥 STORE VARIANT ID FOR UPDATE
                $("#product_id").data("edit_variant_id", res.id);

                // 🔥 JUMP TO STEP-2
                $(".validation-wizard").steps("setStep", 1);

                // 🔔 OPTIONAL MESSAGE
                Swal.fire({
                    icon: "info",
                    title: "Edit Mode",
                    text: "You are now editing this variant"
                });
            },
            error: function () {
                alert("Failed to load variant");
            }
        });
    }
</script>
