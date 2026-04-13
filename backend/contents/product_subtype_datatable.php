<?php
include("../config/my_class_for_web.php");
$obj=new my_class();
?>
<script src="functions/js/product_subtype.js"></script>
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Manage Products Subtype</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Manage Products Subtype</li>
                </ol>
                <button type="button" class="btn btn-info d-none d-lg-block m-l-15 text-white" onclick="window.location.href='?page=add_product_subtype'"><i class="fa fa-plus-circle"></i> Add Product Subtype</button>
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
                                <th>Type</th>
                                <th>Sub-Type</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $s=1;
                            foreach ($obj->View_All_By_Cond("web_product_subtype","active_flag=1 OR active_flag=2") as $value){
                                $id = $value['id'];
                                $name = $value['name'];
                                $description = $value['short_desc'];
                                $product_type_ref = $value['product_type_ref'];
                                $product_type_info = $obj->Details_By_Cond("web_product_type","id=$product_type_ref");
                                $product_type_name = $product_type_info['product_type_title'];
                                $date = date("Y-m-d", strtotime($value['create_date']));
                                $status = $value['active_flag'];
                                ?>
                                <tr>
                                    <td><?php echo $s;?>.</td>
                                    <td><?php echo $product_type_name;?>  </td>
                                    <td><?php echo $name;?></td>
                                    <td><?php echo $description;?></td>
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