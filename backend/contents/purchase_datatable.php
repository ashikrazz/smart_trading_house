<?php
	include("../config/my_class_for_web.php");
	$obj=new my_class();
?>
<script src="functions/js/purchase.js"></script>
<div class="container-fluid">    
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Manage Purchase</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Manage Purchase</li>
                </ol>
                <button type="button" class="btn btn-info d-none d-lg-block m-l-15 text-white" onclick="window.location.href='?page=add_purchase'"><i
                        class="fa fa-plus-circle"></i> New Purchase
                </button>
                <button type="button" class="btn btn-success d-none d-lg-block m-l-15 text-white" onclick="window.location.href='?page=purchase_report'"><i
                        class="fa fa-binoculars"></i> View Purchase Report
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- .left-right-aside-column-->
                <div class="contact-page-aside">
                    <div class="card-body">
                        <div class="right-page-header">
                            <div class="d-flex">
                                <div class="align-self-center">
                                    <h4 class="card-title m-t-10">Purchase History </h4>
                                </div>
                                <div class="ms-auto">
                                    <input type="text" id="demo-input-search2" placeholder="search contacts" class="form-control"> </div>
                            </div>
                        </div>
                        <div class="table-responsive m-t-30">
                            <table class="table product-overview" id="salesTable">
                                <thead>
                                <tr>
                                    <th>SI.</th>
                                    <th>Supplier</th>
                                    <th>Invoice ID</th>
                                    <th>Product</th>
                                    <th>QTY</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
									$x=1;
									foreach ($obj->View_All(" web_purchase_items") as $value){
										$id = $value['id'];
										$invoice_id = $value['invoice_id'];
										$invoice_info = $obj->Details_By_Cond("web_purchase_invoice","id='$invoice_id'");
										$invoice_no = $invoice_info['invoice_no'];
										$supplier_ref = $invoice_info['supplier_id'];
										$supplier_info = $obj->Details_By_Cond("web_user","id='$supplier_ref'");
										$supplier_name = $supplier_info['user_profile_name'];
										$product_name = $value['product_name'];
										$qty = $value['qty'];
										$date = date("Y-m-d", strtotime($value['created_at']));
										$total_amount = $value['total'];
                                ?>
                                    <tr>
                                        <td><?php echo $x; ?></td>
                                        <td><?php echo $supplier_name; ?></td>
                                        <td><?php echo $invoice_no; ?></td>
                                        <td><?php echo $product_name; ?></td>
                                        <td><?php echo $qty; ?></td>
                                        <td><?php echo $total_amount; ?>৳</td>
                                        <td><?php echo $date; ?></td>
                                        <td>
                                            <div class="ms-auto">
                                                <a href="contents/view_invoice.php?id=<?php echo $invoice_id; ?>" target="_blank" class='btn btn-success btn-xs' role="button"><i class='fa fa-binoculars'></i>  View Details</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $x++; 
									} ?>
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <button class="btn btn-secondary btn-sm" id="prevBtn">Prev</button>
                                <span>Page <b id="pageNum">1</b> of <b id="pageCount">1</b></span>
                                <button class="btn btn-secondary btn-sm" id="nextBtn">Next</button>
                            </div>
                        </div>
                        <!-- .left-aside-column-->
                    </div>
                    <!-- /.left-right-aside-column-->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    (function () {

        const rowsPerPage = 6;
        let currentPage = 1;
        let allRows = [];
        let filteredRows = [];

        function initTable() {
            const searchInput = document.getElementById("demo-input-search2");
            const table = document.querySelector(".product-overview");
            if (!table) return;

            const tbody = table.querySelector("tbody");
            allRows = Array.from(tbody.querySelectorAll("tr"));
            filteredRows = [...allRows];

            function render() {
                allRows.forEach(r => r.style.display = "none");

                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;

                filteredRows.slice(start, end).forEach(r => {
                    r.style.display = "";
                });

                document.getElementById("pageNum").innerText = currentPage;
                document.getElementById("pageCount").innerText =
                    Math.max(1, Math.ceil(filteredRows.length / rowsPerPage));
            }

            function applySearch() {
                const val = searchInput.value.toLowerCase().trim();
                filteredRows = allRows.filter(row =>
                    row.textContent.toLowerCase().includes(val)
                );
                currentPage = 1;
                render();
            }

            document.getElementById("nextBtn").onclick = function () {
                const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    render();
                }
            };

            document.getElementById("prevBtn").onclick = function () {
                if (currentPage > 1) {
                    currentPage--;
                    render();
                }
            };

            searchInput.addEventListener("input", applySearch);

            render();
        }

        if (document.readyState === "loading") {
            document.addEventListener("DOMContentLoaded", initTable);
        } else {
            initTable();
        }

    })();
</script>

