<?php
include("../config/my_class_for_web.php");
$obj=new my_class();
?>
<script src="functions/js/supplier.js"></script>
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Manage Supplier</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Manage Supplier</li>
                </ol>
                <button type="button" class="btn btn-info d-none d-lg-block m-l-15 text-white" onclick="window.location.href='?page=add_supplier'"><i
                        class="fa fa-plus-circle"></i> Create New Supplier
                </button>
                <button type="button" class="btn btn-success d-none d-lg-block m-l-15 text-white" onclick="window.location.href='?page=add_purchase'"><i
                            class="fa fa-plus-circle"></i> Purchase Panel
                </button>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- .left-right-aside-column-->
                <div class="contact-page-aside">
                    <div class="card-body">
                        <div class="right-page-header">
                            <div class="d-flex">
                                <div class="align-self-center">
                                    <h4 class="card-title m-t-10">Supplier List </h4>
                                </div>
                                <div class="ms-auto">
                                    <input type="text" id="demo-input-search2" placeholder="search contacts" class="form-control"> </div>
                            </div>
                        </div>

                        <!-- Add Contact Popup Model -->
                        <div id="add-contact" class="modal fade in" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Add New Contact</h4>
                                        <button type="button" class="btn-close me-1 p-0" data-bs-dismiss="modal" aria-hidden="true"></button>
                                    </div>
                                    <div class="modal-body">
                                        <from class="form-horizontal form-material">
                                            <div class="form-group">
                                                <div class="col-md-12 m-b-20">
                                                    <input type="text" class="form-control" placeholder="Type name"> </div>
                                                <div class="col-md-12 m-b-20">
                                                    <input type="text" class="form-control" placeholder="Email"> </div>
                                                <div class="col-md-12 m-b-20">
                                                    <input type="text" class="form-control" placeholder="Phone"> </div>
                                                <div class="col-md-12 m-b-20">
                                                    <input type="text" class="form-control" placeholder="Designation"> </div>
                                                <div class="col-md-12 m-b-20">
                                                    <input type="text" class="form-control" placeholder="Age"> </div>
                                                <div class="col-md-12 m-b-20">
                                                    <input type="text" class="form-control" placeholder="Date of joining"> </div>
                                                <div class="col-md-12 m-b-20">
                                                    <input type="text" class="form-control" placeholder="Salary"> </div>
                                                <div class="col-md-12 m-b-20">
                                                    <div class="fileupload btn btn-primary btn-rounded waves-effect waves-light">
                                                                    <span><i class="ion-upload m-r-5"></i>Upload Contact
                                                                        Image</span>
                                                        <input type="file" class="upload"> </div>
                                                </div>
                                            </div>
                                        </from>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-info waves-effect" data-bs-dismiss="modal">Save</button>
                                        <button type="button" class="btn btn-default waves-effect" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <div class="table-responsive">
                            <table id="demo-foo-addrow" class="table no-wrap table-bordered m-t-30 table-hover contact-list footable footable-1 footable-paging footable-paging-center breakpoint-lg" data-paging="true" data-paging-size="7" style="">
                                <thead>
                                <tr class="footable-header">
                                    <th class="footable-first-visible" style="display: table-cell;">No</th>
                                    <th style="display: table-cell;">Name</th>
                                    <th style="display: table-cell;">Email</th>
                                    <th style="display: table-cell;">Phone</th>
                                    <th style="display: table-cell;">Status</th>
                                    <th style="display: table-cell;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $s=1;
                                    foreach ($obj->View_All_By_Cond("web_user","(active_flag = 1 OR active_flag = 2) AND user_type_ref = 2") as $value){
                                        $id = $value['id'];
                                        $name = $value['user_profile_name'];
                                        $email = $value['user_email'];
                                        $phone = $value['user_phone'];
                                        $profile_pic = $value['user_profile_pic'];
                                        $status = $value['active_flag'];

                                    ?>
                                        <tr>
                                            <td class="footable-first-visible" style="display: table-cell;"><?php echo $s;?>.</td>
                                            <td ><a href="javascript:void(0)"><img src="../resources/supplier/profile_pic/<?php echo $profile_pic;?>" width="35" height="35" class="img-circle"> <?php echo $name;?></a></td>
                                            <td ><?php echo $email;?></td>
                                            <td ><?php echo $phone;?></td>
                                            <td>
                                                <?php if($status==2){?>
                                                    <span class="label label-danger font-weight-100">Inactive</span>
                                                <?php }else{?>
                                                    <span class="label label-success font-weight-100">Active</span>
                                                <?php }?>
                                            </td>
                                            <td style="display: table-cell;">
                                                <a href='' class='btn btn-info btn-xs' role="button"><i class='fa fa-eye'></i> Reset Pass</a>
                                                <a href="?page=add_supplier&id=<?php echo $id; ?>" class='btn btn-success btn-xs' role="button"><i class='fa fa-pen-square'></i> Edit</a>
                                                <?php
                                                if($value['active_flag']==1){
                                                    echo "<button onclick='unpublish($id)' class='btn btn-primary btn-xs'><i class='fa fa-window-close'></i> Hide</button>";
                                                } else if($value['active_flag']==2){
                                                    echo "<button onclick='publish($id)' class='btn btn-success btn-xs'><i class='fa fa-check-circle'></i> Show</button>";
                                                }
                                                ?>
                                                <button onclick="removed(<?php echo $value['id'];?>)" class='btn btn-danger btn-xs'><i class='fa fa-trash'></i> Delete</button>
                                            </td>
                                        </tr>
                                    <?php $s++;} ?>
                                </tbody>
                        </div>
                        <!-- .left-aside-column-->
                    </div>
                    <!-- /.left-right-aside-column-->
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
<!--FooTable init-->
<script>
    $(function () {
        $('#demo-foo-addrow').footable();
    });
</script>
