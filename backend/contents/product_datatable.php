<?php
include("../config/my_class_for_web.php");
$obj=new my_class();
?>

<script src="functions/js/products.js"></script>

<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Manage Products</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Manage Products</li>
                </ol>
                <button type="button" class="btn btn-info d-none d-lg-block m-l-15 text-white" onclick="window.location.href='?page=add_product'"><i class="fa fa-plus-circle"></i> Add Product</button>
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
                                <th>Sl.</th>
                                <th>Details</th>
                                <th>Product</th>
                                <th>Variant</th>
                                <th>Stock</th>
                                <th>Buy</th>
                                <th>Sell</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $y=1;
                                foreach ($obj->View_All_By_Cond("variant","active_flag=1") as $value){
                                    $id = $value['id'];
                                    $variant_name = $value['variant_name'];
                                    $product_ref = $value['product_ref'];
                                    $unit_ref = $value['unit_ref'];
                                    $product_info = $obj->Details_By_Cond("products","id=$product_ref");
                                    $product_name = $product_info['product_name'];
                                    $brand_ref = $product_info['brand_ref'];
                                    $brand_info = $obj->Details_By_Cond("brand","id=$brand_ref");
                                    $brand_name = $brand_info['brand_name'];
                                    $type_ref = $product_info['type_ref'];
                                    $type_info = $obj->Details_By_Cond("web_product_type","id=$type_ref");
                                    $type_name = $type_info['product_type_title'];
                                    $sub_type_ref = $product_info['sub_type_ref'];
                                    $sub_type_info = $obj->Details_By_Cond("web_product_subtype","id=$sub_type_ref");
                                    $sub_type_name = $sub_type_info['name'];
                                    $product_stock_info = $obj->Details_By_Cond("product_stocks","product_ref=$product_ref AND variant_ref=$id");
                                    $product_stock_in = $product_stock_info['stock_in'];
                                    $product_stock_out = $product_stock_info['stock_out'];
                                    if ($product_stock_out==""){
                                        $product_stock_out=0;
                                    }
                                    $current_stock = $product_stock_in-$product_stock_out;
                                    $product_price_info = $obj->Details_By_Cond("product_price","variant_ref=$id AND product_ref=$product_ref");
                                    $buy_price = $product_price_info['buy_price'];
                                    $sell_price = $product_price_info['sell_price'];
                                    $measurement_unit_info = $obj->Details_By_Cond("measurement_unit","id=$unit_ref");
                                    $unit = $measurement_unit_info['unit_name'];

                            ?>
                                <tr>
                                    <td><?php echo $y?></td>
                                    <td><?php echo $type_name?> -   <?php echo $sub_type_name?> -   <?php echo $brand_name?></td>
                                    <td><?php echo $product_name?></td>
                                    <td><?php echo $variant_name?></td>
                                    <td><?php echo $current_stock?> <?php echo $unit ?></td>
                                    <td><?php echo $buy_price?>৳ / <?php echo $unit ?></td>
                                    <td><?php echo $sell_price?>৳ / <?php echo $unit ?></td>
                                    <td>
                                        <a href="?page=add_brand&id=<?php echo $id; ?>" class="text-inverse p-r-10 btn btn-success btn-xs" data-bs-toggle="tooltip" title="Edit"><i class="ti-marker-alt"></i>Edit</a>
                                        <a href="javascript:removed(<?php echo $id;?>)" class="text-inverse btn btn-danger btn-xs" title="Delete" data-bs-toggle="tooltip"><i class="ti-trash"></i>Delete</a>
                                    </td>
                                </tr>
                            <?php $y++;} ?>
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
