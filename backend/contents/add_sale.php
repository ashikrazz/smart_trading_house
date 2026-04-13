<?php
// invoice.php
include ("config/my_class_for_web.php");
$obj = new my_class();
//$invoice_no = "INVC-" . date('Ymd') . rand(1000, 9999);
?>
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
                <h4 class="text-themecolor">Add Sale</h4>
            </div>
            <div class="col-md-7 align-self-center text-end">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Add Sale</li>
                    </ol>
                    <button type="button" class="btn btn-info d-none d-lg-block m-l-15 text-white" onclick="window.location.href='?page=add_customer'"><i class="fa fa-plus-circle"></i> Create New Customer</button>
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
                        <h4 class="card-title">Purchase Panel</h4>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputInvoice" class="form-label">Invoice No.</label>
                                    <input type="text" class="form-control" id="exampleInputInvoice" aria-describedby="invoiceHelp" value="<?php echo $invoice_no; ?>" readonly style="background:#e9ecef; font-weight:500;">
                                    <small id="invoiceHelp" class="form-text text-muted">Invoice Number is System Genarated.</small>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputNote" class="form-label">Note.</label>
                                    <input type="text" class="form-control" id="exampleInputNote" aria-describedby="noteHelp" placeholder="Keep note here.">
                                    <small id="noteHelp" class="form-text text-muted">Keep Note Here if Any</small>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputCustomer" class="form-label">Customer.</label>
                                    <select class="select2 form-control form-select" aria-describedby="customerHelp" style="width: 100%;" id="exampleInputCustomer">
                                        <option>Select</option>
                                        <?php
                                        foreach($obj->View_All_By_Cond("web_user","active_flag=1 AND user_type_ref=3") as $value){
											$user_id = $value['id'];
											$user_name = $value['user_profile_name'];
											$user_phone = $value['user_phone'];
                                            echo "<option value='".$user_id."'>".$user_id." | ".$user_name."-".$user_phone."</option>";
                                        }
                                        ?>
                                    </select>
                                    <small id="customerHelp" class="form-text text-muted">Select Supplier From the List.</small>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputpurchasedate" class="form-label">Purchase Date.</label>
                                    <input type="date" class="form-control" id="exampleInputpurchasedate" aria-describedby="pdateHelp" value="<?php echo date('Y-m-d'); ?>">
                                    <small id="pdateHelp" class="form-text text-muted">Purchase Date is Auto Selected.</small>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="row">
                                <h4 class="card-title">Item Details</h4>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputCategory" class="form-label">Category.</label>
                                        <select class="select2 form-control form-select" style="width: 100%;" id="category_id">
                                            <option value="">Select Category</option>
                                            <?php
                                            foreach($obj->View_All_By_Cond("web_product_type","active_flag=1") as $v){
												$product_id = $v['id'];
												$product_title = $v['product_type_title'];
                                                echo "<option value='".$product_id."'>".$product_id." | ".$product_title."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputSubcategory" class="form-label">Sub-Category.</label>
                                        <select class="select2 form-control form-select" style="width: 100%;" id="subcat">

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputPname" class="form-label">Product Name.</label>
                                        <select class="select2 form-control form-select" style="width: 100%;" id="product_id">

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputVariant" class="form-label">Variant.</label>
                                        <select class="select2 form-control form-select" style="width: 100%;" id="variant_id">

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="exampleInputQuantity" class="form-label">QTY.</label>
                                        <input type="number" class="form-control" id="exampleInputQuantity" value="0" step="0.10" min="1">
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="unit_id" class="form-label">Unit.</label>
                                        <select class="select2 form-control form-select" style="width: 100%;" id="unit_id">
                                            <option value="">Select</option>
                                            <?php
                                            foreach($obj->View_All_By_Cond("measurement_unit","active_flag=1") as $m){
												$m_unit_id = $m['id'];
												$m_unit_name = $m['unit_name'];
                                                echo "<option value='".$m_unit_id."'>".$m_unit_name."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleInputPrice" class="form-label">Price.</label>
                                        <input type="number" class="form-control" id="exampleInputPrice" aria-describedby="priceHelp" readonly style="background:#e9ecef;" value="">
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="exampleInputStock" class="form-label">Stock.</label>
                                        <input type="number" class="form-control" id="exampleInputStock" aria-describedby="stockHelp" readonly style="background:#e9ecef;" value="">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleInputsubTotal" class="form-label">Sub-Total.</label>
                                        <input type="number" class="form-control" id="exampleInputsubTotal" readonly style="background:#e9ecef;" value="">
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="exampleInputVat" class="form-label">Vat%.</label>
                                        <input type="number" class="form-control" id="exampleInputVat" readonly style="background:#e9ecef;" value="">
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="exampleInputVats" class="form-label">Vat.</label>
                                        <input type="number" class="form-control" id="exampleInputVats" readonly style="background:#e9ecef;" value="">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleInputTotal" class="form-label">Total.</label>
                                        <input type="number" class="form-control" id="exampleInputTotal" value="" readonly style="background:#e9ecef;">
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <button type="button" class="btn btn-success mt-4">Add</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table color-table success-table">
                                        <thead>
                                        <tr>
                                            <th>SI.</th>
                                            <th>Name</th>
                                            <th>Variant</th>
                                            <th>QTY</th>
                                            <th>Unit</th>
                                            <th>Price</th>
                                            <th>Sub-Total</th>
                                            <th>Vat</th>
                                            <th>Vat%</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">

                            <!-- LEFT: Payments -->
                            <div class="col-md-8">
                                <h2 class="fw-bold fs-4 mb-3">Payments</h2>
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <select id="payment_name" class="form-select select2">
                                            <option value="">Select Payment Method</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Card">Card</option>
                                            <option value="Bkash">Bkash</option>
                                            <option value="Nagad">Nagad</option>
                                            <option value="Rocket">Rocket</option>
                                            <option value="Upay">Upay</option>
                                            <option value="Qcash">Qcash</option>
                                            <option value="Nexuspay">Nexuspay</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3"><input id="payment_amount" type="number" class="form-control" placeholder="Amount"></div>
                                    <div class="col-md-3"><input id="payment_date" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>"></div>
                                    <div class="col-md-3"><input id="payment_notes" class="form-control" placeholder="Notes"></div>
                                </div>
                                <button class="btn btn-primary mt-3" id="addPaymentBtn">Add</button>
                                <br>
                                <table class="table color-table info-table">
                                    <thead>
                                    <tr>
                                        <th>SI.</th>
                                        <th>Payment Method</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Notes</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>

                            <!-- RIGHT: Summary -->
                            <div class="col-md-4">
                                <div class="p-3 rounded-lg shadow" style="background:#f8fafc">
                                    <div class="d-flex justify-content-between py-1"><span>Total:</span><span id="summary_total"></span></div>
                                    <div class="d-flex justify-content-between py-1"><span>Invoice Vat:</span><span id="summary_vat"></span></div>
                                    <div class="d-flex justify-content-between fw-bold py-1"><span>Total Payable:</span><span id="summary_grand"></span></div>
                                    <div class="d-flex justify-content-between py-1"><span>Total Paid:</span><span id="summary_paid"></span></div>
                                    <div class="d-flex justify-content-between text-danger fw-bold py-1"><span>Change:</span><span id="summary_balance"></span></div>

                                    <button class="btn btn-success w-100 mt-3 fs-5" id="saveInvoiceBtn">Save Invoice</button>
                                </div>
                            </div>

                        </div>
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
    $(function () {
        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function () {
            new Switchery($(this)[0], $(this).data());
        });
        // For select 2
        $(".select2").select2();
        $('.selectpicker').selectpicker();
        //Bootstrap-TouchSpin
        $(".vertical-spin").TouchSpin({
            verticalbuttons: true
        });
        var vspinTrue = $(".vertical-spin").TouchSpin({
            verticalbuttons: true
        });
        if (vspinTrue) {
            $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
        }
        $("input[name='tch1']").TouchSpin({
            min: 0,
            max: 100,
            step: 0.1,
            decimals: 2,
            boostat: 5,
            maxboostedstep: 10,
            postfix: '%'
        });
        $("input[name='tch2']").TouchSpin({
            min: -1000000000,
            max: 1000000000,
            stepinterval: 50,
            maxboostedstep: 10000000,
            prefix: '$'
        });
        $("input[name='tch3']").TouchSpin();
        $("input[name='tch3_22']").TouchSpin({
            initval: 40
        });
        $("input[name='tch5']").TouchSpin({
            prefix: "pre",
            postfix: "post"
        });
        // For multiselect
        $('#pre-selected-options').multiSelect();
        $('#optgroup').multiSelect({
            selectableOptgroup: true
        });
        $('#public-methods').multiSelect();
        $('#select-all').click(function () {
            $('#public-methods').multiSelect('select_all');
            return false;
        });
        $('#deselect-all').click(function () {
            $('#public-methods').multiSelect('deselect_all');
            return false;
        });
        $('#refresh').on('click', function () {
            $('#public-methods').multiSelect('refresh');
            return false;
        });
        $('#add-option').on('click', function () {
            $('#public-methods').multiSelect('addOption', {
                value: 42,
                text: 'test 42',
                index: 0
            });
            return false;
        });
        $(".ajax").select2({
            ajax: {
                url: "https://api.github.com/search/repositories",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;
                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: 1,
            //templateResult: formatRepo, // omitted for brevity, see the source of this page
            //templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
        });
    });
</script>

<script>
    // CATEGORY → SUBCATEGORY LOAD
    $(document).ready(function () {

        // Make sure Select2 is initialized first
        $(".select2").select2();
        $('#category_id').on('select2:select', function (e) {

            console.log("Category selected");

            let category_id = $(this).val();
            console.log("Category id: " + category_id + "");
            if (!category_id) {
                $("#subcat").html('<option value="">Select Sub-Category</option>');
                return;
            }

            $.ajax({
                url: "contents/product_ajax.php",
                type: "POST",
                data: {
                    action: "load_subcategory",
                    category_id: category_id
                },
                success: function (response) {
                    $("#subcat").html(response).trigger("change");
                },
                error: function () {
                    alert("AJAX error loading sub-category");
                }
            });
        });

        // SUBCATEGORY → PRODUCT LOAD
        $('#subcat').on('select2:select', function () {
            let subcat_id = $(this).val();
            console.log("Subcategory id:", subcat_id);

            if (!subcat_id) {
                $("#product_id").html('<option value="">Select Product</option>');
                return;
            }

            $.ajax({
                url: "contents/product_ajax.php",
                type: "POST",
                data: {
                    action: "load_product",
                    subcat_id: subcat_id
                },
                success: function (response) {
                    console.log("Product response:", response);
                    $("#product_id").html(response).trigger("change");
                },
                error: function (xhr, status, error) {
                    console.error("AJAX error:", status, error);
                    alert("AJAX error loading product name");
                }
            });
        });

        // PRODUCT → VARIANT LOAD
        $('#product_id').on('select2:select', function () {

            let product_id = $(this).val();
            console.log("Product id:", product_id);

            if (!product_id) {
                $("#variant_id").html('<option value="">Select Variant</option>');
                return;
            }

            $.ajax({
                url: "contents/product_ajax.php",
                type: "POST",
                data: {
                    action: "load_variant",
                    product_id: product_id
                },
                success: function (response) {
                    console.log("Variant response:", response);
                    $("#variant_id").html(response).trigger("change");
                },
                error: function () {
                    alert("AJAX error loading variant");
                }
            });
        });

        // VARIANT → PRICE LOAD
        $('#variant_id').on('select2:select', function () {

            let variant_id = $(this).val();
            console.log("Variant id:", variant_id);

            if (!variant_id) {
                $("#exampleInputPrice").val('');
                return;
            }

            $.ajax({
                url: "contents/product_ajax.php",
                type: "POST",
                data: {
                    action: "load_price",
                    variant_id: variant_id
                },
                success: function (response) {
                    //alert(response);
                    console.log("Price response:", response);
                    $("#exampleInputPrice").val(response);
                },
                error: function () {
                    alert("AJAX error loading price");
                }
            });
        });

        // VARIANT → VAT%
        $('#variant_id').on('select2:select', function () {

            let variant_id = $(this).val();
            console.log("Variant id for VAT:", variant_id);

            if (!variant_id) {
                $("#exampleInputVat").val('');
                return;
            }

            $.ajax({
                url: "contents/product_ajax.php",
                type: "POST",
                data: {
                    action: "load_vat",
                    variant_id: variant_id
                },
                success: function (response) {
                    console.log("VAT response:", response);
                    $("#exampleInputVat").val(response);
                },
                error: function () {
                    alert("AJAX error loading VAT%");
                }
            });
        });

        // VARIANT → STOCK
        $('#variant_id').on('select2:select', function () {
            let variant_id = $(this).val();
            console.log("Variant id for Stock:", variant_id);

            if (!variant_id) {
                $("#exampleInputStock").val('');
                return;
            }

            $.ajax({
                url: "contents/product_ajax.php",
                type: "POST",
                data: {
                    action: "load_stock",
                    variant_id: variant_id
                },
                success: function (response) {
                    console.log("STOCK response:", response);
                    let stock = parseFloat(response) || 0;
                    $("#exampleInputStock").val(stock).data("original-stock", stock);
                },
                error: function () {
                    alert("AJAX error loading for Stock");
                }
            });
        });

    });

    function calculateItemTotals() {
        let price = parseFloat($("#exampleInputPrice").val()) || 0;
        let qty = parseFloat($("#exampleInputQuantity").val()) || 0;
        let vatPercent = parseFloat($("#exampleInputVat").val()) || 0;
        let originalStock = parseFloat($("#exampleInputStock").data("original-stock")) || 0;

        let remainingStock = originalStock - qty;
        let subtotal = price * qty;
        let vatAmount = (subtotal * vatPercent) / 100;
        let total = subtotal + vatAmount;

        $("#exampleInputsubTotal").val(subtotal.toFixed(2));
        $("#exampleInputVats").val(vatAmount.toFixed(2));
        $("#exampleInputTotal").val(total.toFixed(2));
        $("#exampleInputStock").val(remainingStock);
    }
    // Trigger calculation whenever price, quantity, or VAT changes
    $("#exampleInputPrice, #exampleInputQuantity, #exampleInputVat").on('input change', function() {
        calculateItemTotals();
    });

</script>

<script>
    $(document).ready(function(){

        let itemCounter = 1; // Track SI
        const $tableBody = $(".table.color-table.success-table tbody");

        // ADD BUTTON CLICK
        $(".btn-success.mt-4").click(function(){
            
            let productName = $("#product_id option:selected").text();
            let variantName = $("#variant_id option:selected").text();
            let qty = parseFloat($("#exampleInputQuantity").val()) || 0;
            let unit = $("#unit_id option:selected").text();
            let price = parseFloat($("#exampleInputPrice").val()) || 0;
            let subtotal = parseFloat($("#exampleInputsubTotal").val()) || 0;
            let vatPercent = parseFloat($("#exampleInputVat").val()) || 0;
            let vatAmount = parseFloat($("#exampleInputVats").val()) || 0;
            let total = parseFloat($("#exampleInputTotal").val()) || 0;
            
            let productId = $("#product_id").val();
            let variantId = $("#variant_id").val();
            
            if(!productId || !variantId || qty <= 0){
                alert("Please select product, variant and quantity.");
                return;
            }
            
            let newRow = `
            <tr data-product-id="${productId}" data-variant-id="${variantId}">
            <td>${itemCounter}</td>
            <td>${productName}</td>
            <td>${variantName}</td>
            <td>${qty.toFixed(3)}</td>
            <td>${unit}</td>
            <td>${price.toFixed(2)} ৳</td>
            <td>${subtotal.toFixed(2)} ৳</td>
            <td>${vatAmount.toFixed(2)} ৳</td>
            <td>${vatPercent}%</td>
            <td>${total.toFixed(2)} ৳</td>
            <td>
            <button type="button" class="btn btn-danger btn-sm deleteRow">
            <i class="fa fa-trash"></i>
            </button>
            </td>
            </tr>
            `;
            
            $(".table.color-table.success-table tbody").append(newRow);
            itemCounter++;
            
            // reset
            $("#category_id").val('').trigger("change");
            $("#subcat").val('').trigger("change");
            $("#product_id").val('').trigger("change");
            $("#variant_id").val('').trigger("change");
            $("#exampleInputQuantity").val(0);
            $("#unit_id").val('').trigger("change");
            $("#exampleInputsubTotal").val('');
            $("#exampleInputVats").val('');
            $("#exampleInputTotal").val('');
            
            calculateSummary();
        });
        

        // DELETE ROW
        $tableBody.on("click", ".deleteRow", function(){
            $(this).closest("tr").remove();
            itemCounter = 1; // reset SI
            $tableBody.find("tr").each(function(){
                $(this).find("td:first").text(itemCounter++);
            });

            // Recalculate summary
            calculateSummary();
        });

        // CALCULATE SUMMARY
        function calculateSummary(){
            let total = 0, totalVat = 0, grandTotal = 0;
            $tableBody.find("tr").each(function(){
                total += parseFloat($(this).find("td:eq(6)").text()) || 0; // Total column
                totalVat += parseFloat($(this).find("td:eq(7)").text()) || 0; // Vat column
                grandTotal = total + totalVat;
            });

            $("#summary_total").text(total.toFixed(2) + " ৳");
            $("#summary_vat").text(totalVat.toFixed(2) + " ৳");
            $("#summary_grand").text(grandTotal.toFixed(2) + " ৳");

            // Calculate payments
            let paid = 0;
            $(".table.color-table.info-table tbody tr").each(function(){
                paid += parseFloat($(this).find("td:eq(2)").text()) || 0; // Amount column
            });

            $("#summary_paid").text(paid.toFixed(2) + " ৳");
            $("#summary_balance").text(Math.abs(grandTotal - paid).toFixed(2) + " ৳");
        }

        // Also recalc summary on payment add (example)
        $("#addPaymentBtn").click(function(){
            let method = $("#payment_name").val();
            let amount = parseFloat($("#payment_amount").val()) || 0;
            let date = $("#payment_date").val();
            let notes = $("#payment_notes").val();

            if(!method || amount <= 0){
                alert("Select payment method and enter amount.");
                return;
            }

            let newPaymentRow = `<tr>
            <td>1</td>
            <td>${method}</td>
            <td>${amount.toFixed(2)} ৳</td>
            <td>${date}</td>
            <td>${notes}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm deletePayment"><i class="fa fa-trash"></i></button>
            </td>
        </tr>`;

            $(".table.color-table.info-table tbody").append(newPaymentRow);

            // reset
            $("#payment_name").val('').trigger('change');
            $("#payment_amount").val('');
            $("#payment_notes").val('');

            calculateSummary();
        });

        // DELETE PAYMENT
        $(".table.color-table.info-table tbody").on("click", ".deletePayment", function(){
            $(this).closest("tr").remove();
            calculateSummary();
        });

    });
</script>


<script>
$("#saveInvoiceBtn").on("click", function () {
    
    let invoice_no    = $("#exampleInputInvoice").val();
    let note          = $("#exampleInputNote").val();
    let supplier_id   = $("#exampleInputCustomer").val();
    let purchase_date = $("#exampleInputpurchasedate").val();
    
    let items = [];
    
    $(".table.color-table.success-table tbody tr").each(function () {
        let row = $(this);
        
        items.push({
            product_id: row.data("product-id"),
                   variant_id: row.data("variant-id"),
                   product_name: row.find("td:eq(1)").text().trim(),
                   variant: row.find("td:eq(2)").text().trim(),
                   qty: parseFloat(row.find("td:eq(3)").text()),
                   unit: row.find("td:eq(4)").text().trim(),
                   price: parseFloat(row.find("td:eq(5)").text().replace(/[^\d.]/g, '')),
                   subtotal: parseFloat(row.find("td:eq(6)").text().replace(/[^\d.]/g, '')),
                   vat: parseFloat(row.find("td:eq(7)").text().replace(/[^\d.]/g, '')),
                   vat_percent: parseFloat(row.find("td:eq(8)").text()),
                   total: parseFloat(row.find("td:eq(9)").text().replace(/[^\d.]/g, ''))
        });
    });
    
    if (!supplier_id || items.length === 0) {
        alert("Customer and at least one item required.");
        return;
    }
    
    let payments = [];
    $(".table.color-table.info-table tbody tr").each(function () {
        let tds = $(this).find("td");
        
        payments.push({
            method: tds.eq(1).text().trim(),
                      amount: parseFloat(tds.eq(2).text().replace(/[^\d.]/g, '')),
                      date: tds.eq(3).text().trim(),
                      notes: tds.eq(4).text().trim()
        });
    });
    
    $.ajax({
        url: "functions/save_customer_invoice.php",
        type: "POST",
        dataType: "json",
        data: {
            invoice_no,
            note,
            supplier_id,
            purchase_date,
            items: JSON.stringify(items),
           payments: JSON.stringify(payments)
        },
        success: function (res) {
            if (res.status === "success") {
                alert("Invoice saved successfully!");
                window.open("contents/view_customer_invoice.php?id=" + res.invoice_id, "_blank");
                location.reload();
            } else {
                alert(res.message || "Invoice save failed");
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            alert("Server error");
        }
    });
});



</script>




<script>
    document.addEventListener("DOMContentLoaded", function () {

        const navFields = [
            "#exampleInputInvoice",
            "#exampleInputNote",
            "#exampleInputCustomer",
            "#exampleInputpurchasedate",
            "#category_id",
            "#subcat",
            "#product_id",
            "#variant_id",
            "#exampleInputQuantity",
            "#unit_id",
            ".btn-success.mt-4",
            "#payment_name",
            "#payment_amount",
            "#payment_date",
            "#payment_notes",
            "#addPaymentBtn",
            "#saveInvoiceBtn"
        ];

        // Initial focus
        setTimeout(() => {
            document.querySelector("#exampleInputInvoice")?.focus();
        }, 300);

        // Move to next field
        function focusNext(selector) {
            const idx = navFields.indexOf(selector);
            if (idx === -1) return;
            const next = document.querySelector(navFields[idx + 1]);
            if (!next) return;

            next.focus();

            // Open select2 if it's a select2 field
            if ($(next).hasClass("select2-hidden-accessible")) {
                setTimeout(() => $(next).select2("open"), 100);
            }
        }

        function getActiveSelector(el) {
            return navFields.find(sel => document.querySelector(sel) === el) || null;
        }

        /* ===== ENTER KEY NAVIGATION ===== */
        document.addEventListener("keydown", function (e) {
            if (e.key !== "Enter") return;

            const active = document.activeElement;
            if (!active) return;

            const sel = getActiveSelector(active);
            if (!sel) return;

            e.preventDefault();

            // Buttons
            if (active.classList.contains("btn-success")) {
                active.click();
                setTimeout(() => {
                    $("#category_id").focus().select2("open");
                }, 150);
                return;
            }

            // Payment fields
            if (active.id === "payment_name") {
                $("#payment_amount").focus();
                return;
            }

            if (active.id === "payment_notes") {
                $("#addPaymentBtn").click();
                setTimeout(() => {
                    $("#payment_name").val(null).trigger("change");
                    $("#payment_name").focus().select2("open");
                }, 300);
                return;
            }

            // If active is a select2 field, ignore Enter here.
            if ($(active).hasClass("select2-hidden-accessible")) {
                return; // let select2:select handle moving focus
            }

            focusNext(sel);
        });

        /* ===== TAB KEY NAVIGATION ===== */
        document.addEventListener("keydown", function (e) {
            if (e.key === "Tab") {
                e.preventDefault();
                $("#payment_name").focus().select2("open");
            }
        });

        /* ===== SELECT2 AUTO NAVIGATION ===== */
        const select2Fields = [
            "#exampleInputCustomer",
            "#category_id",
            "#subcat",
            "#product_id",
            "#variant_id",
            "#unit_id"
        ];

        select2Fields.forEach(id => {
            $(id).on("select2:select", function () {
                const currentId = id;
                setTimeout(() => {
                    // Move to next field after Select2 closes
                    focusNext(currentId);
                }, 50); // small delay ensures focus works
            });
        });

        /* ===== ⭐ payment_name FIX ⭐ ===== */
        $("#payment_name").on("select2:select", function () {
            setTimeout(() => {
                $("#payment_amount").focus();
            }, 100);
        });

    });
</script>


















