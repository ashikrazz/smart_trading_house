<?php
include("../config/my_class_for_web.php");
$obj=new my_class();
?>
<script src="functions/js/stocks.js"></script>
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Manage Product Stocks</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Manage Products Stocks</li>
                </ol>
                <button type="button" class="btn btn-info d-none d-lg-block m-l-15 text-white" onclick="window.location.href='?page=add_stock'"><i class="fa fa-plus-circle"></i> Add Product Stocks</button>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Info box Content -->
    <!-- ============================================================== -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table product-overview" id="myTable">
                            <thead>
                            <tr>
                                <th>SI.</th>
                                <th>Products</th>
                                <th>Stocks in</th>
                                <th>Stocks out</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <?php
                                    $x=1;
                                    foreach ($obj->View_All_By_Cond("product_stocks","active_flag=1") as $value){
                                        $id = $value['id'];
                                        $product_ref = $value['product_ref'];
                                        $product_info = $obj->Details_By_Cond("products","id=$product_ref");
                                        $product_name = $product_info['product_name'];
                                        $variant_ref = $value['variant_ref'];
                                        $variant_info = $obj->Details_By_Cond("variant","id=$variant_ref");
                                        $variant_name = $variant_info['variant_name'];
                                        $stocks_in = $value['stock_in'];
                                        $stocks_out = (int) ($value['stock_out'] ?? 0);
                                        $current_stocks = $stocks_in - $stocks_out;
                                        $date = date("d-M-Y", strtotime($value['create_date']));
                                        $unit_ref = $value['unit_ref'];
                                        $measurement_unit_info = $obj->Details_By_Cond("measurement_unit","id=$unit_ref");
                                        $unit_name = $measurement_unit_info['unit_name'];
                                ?>
                                    <td><?php echo $x?></td>
                                    <td><?php echo $product_name ?>-<?php echo $variant_name?></td>
                                    <td><?php echo $stocks_in?> <?php echo $unit_name ?></td>
                                    <td><?php echo $stocks_out?> <?php echo $unit_name ?></td>
                                    <td><?php echo $date?></td>
                                    <td>
                                        <a href="?page=edit_stock&id=1" class="btn btn-sm btn-info"><i class="fa fa-pen-fancy"></i>Edit</a>
                                        <a href="?page=delete_stock&id=1" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>Delete</a>
                                    </td>
                            </tr>
                            <?php $x++;} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->


<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
        $(document).ready(function() {
            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 25,
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                            last = group;
                        }
                    });
                }
            });
            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function() {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                } else {
                    table.order([2, 'asc']).draw();
                }
            });
        });
    });
</script>
