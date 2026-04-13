<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("../config/my_class_for_web.php");
$obj=new my_class();
?>
<script src="functions/js/variant.js"></script>
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Manage Variant</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Manage Variant</li>
                </ol>
                <button type="button" class="btn btn-info d-none d-lg-block m-l-15 text-white" onclick="window.location.href='?page=add_variant'"><i class="fa fa-plus-circle"></i> Add Variant</button>
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
                                <th>Product</th>
                                <th>Variant Type</th>
                                <th>Variant</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $s=1;
                            foreach ($obj->View_All_By_Cond("variant","active_flag=1 OR active_flag=2") as $value){
                                $id = $value['id'];
                                $variant_name = $value['variant_name'];
                                $variant_type_ref = $value['variant_type_ref'];
                                $variant_type_info = $obj->Details_By_Cond("variant_type","id=$variant_type_ref");
                                $variant_type_name = $variant_type_info['variant'];
                                $product_ref = $value['product_ref'];
                                $product_info = $obj->Details_By_Cond("products","id = $product_ref");
                                $product_name = $product_info['product_name'];
                                $date = date("d-M-Y", strtotime($value['create_date']));
                                $status = $value['active_flag'];
                                ?>
                                <tr>
                                    <td><?php echo $s;?>.</td>
                                    <td><?php echo $product_name;?>  </td>
                                    <td><?php echo $variant_type_name;?></td>
                                    <td><?php echo $variant_name;?></td>
                                    <td><?php echo $date;?></td>
                                    <td>
                                        <?php if($status==2){?>
                                            <span class="label label-danger font-weight-100">Unpublish</span>
                                        <?php }else{?>
                                            <span class="label label-success font-weight-100">Publish</span>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <?php if($status==2){?>
                                            <a href="javascript:publish(<?php echo $id;?>)" class="text-inverse p-r-10 btn btn-success btn-xs" data-bs-toggle="tooltip" title="Show"><i class="ti-eye"></i>Show</a>
                                        <?php } else{?>
                                            <a href="javascript:unpublish(<?php echo $id;?>)" class="text-inverse p-r-10 btn btn-primary btn-xs" data-bs-toggle="tooltip" title="Hide"><i class="fas fa-eye-slash"></i>Hide</a>
                                        <?php }?>
                                        <a href="?page=add_product_subtype&id=<?php echo $id; ?>" class="text-inverse p-r-10 btn btn-info btn-xs" data-bs-toggle="tooltip" title="Edit"><i class="ti-marker-alt"></i>Edit</a>
                                        <a href="javascript:removed(<?php echo $id;?>)" class="text-inverse btn btn-danger btn-xs" title="Delete" data-bs-toggle="tooltip"><i class="ti-trash"></i>Delete</a></td>
                                </tr>
                                <?php $s++; } ?>
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
