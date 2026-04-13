<?php
include("../config/my_class_for_web.php");
$obj=new my_class();
?>
<script src="functions/js/customer.js"></script>
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Manage Customer</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Manage Customer</li>
                </ol>
                <button type="button" class="btn btn-info d-none d-lg-block m-l-15 text-white" onclick="window.location.href='?page=add_customer'"><i
                        class="fa fa-plus-circle"></i> Create New Customer
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
                                    <h4 class="card-title m-t-10">Customer List </h4>
                                </div>
                                <div class="ms-auto">
                                    <input type="text" id="demo-input-search2" placeholder="search contacts" class="form-control"> </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="demo-foo-addrow-1" class="table no-wrap table-bordered m-t-30 table-hover contact-list footable footable-1 footable-paging footable-paging-center breakpoint-lg" data-paging="true" data-paging-size="7" style="">
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
                                foreach ($obj->View_All_By_Cond("web_user","(active_flag = 1 OR active_flag = 2) AND user_type_ref = 3") as $value){
                                    $id = $value['id'];
                                    $name = $value['user_profile_name'];
                                    $email = $value['user_email'];
                                    $phone = $value['user_phone'];
                                    $profile_pic = $value['user_profile_pic'];
                                    $status = $value['active_flag'];

                                    ?>
                                    <tr>
                                        <td class="footable-first-visible" style="display: table-cell;"><?php echo $s;?>.</td>
                                        <td style="display: table-cell;"><a href="javascript:void(0)"><img src="../resources/customer/profile_pic/<?php echo $profile_pic;?>" alt="user" width="40" height="35" class="img-circle"> <?php echo $name;?></a></td>
                                        <td style="display: table-cell;"><?php echo $email;?></td>
                                        <td style="display: table-cell;">+88 <?php echo $phone;?></td>
                                        <td style="display: table-cell;">
                                            <?php if($status==2){?>
                                                <span class="label label-danger font-weight-100">Inactive</span>
                                            <?php }else{?>
                                                <span class="label label-success font-weight-100">Active</span>
                                            <?php }?>
                                        </td>
                                        <td style="display: table-cell;">
                                            <a href='' class='btn btn-info btn-xs' role="button"><i class='fa fa-eye'></i> Reset Pass</a>
                                            <a href="?page=add_customer&id=<?php echo $id; ?>" class='btn btn-success btn-xs' role="button"><i class='fa fa-pen-square'></i> Edit</a>
                                            <?php
                                            if($value['active_flag']==1){
                                                echo "<button onclick='unpublish_customer($id)' class='btn btn-primary btn-xs'><i class='fa fa-window-close'></i> Hide</button>";
                                            } else if($value['active_flag']==2){
                                                echo "<button onclick='publish_customer($id)' class='btn btn-success btn-xs'><i class='fa fa-check-circle'></i> Show</button>";
                                            }
                                            ?>
                                            <button onclick="customer_removed(<?php echo $value['id'];?>)" class='btn btn-danger btn-xs'><i class='fa fa-trash'></i> Delete</button>
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
        $('#demo-foo-addrow-1').footable();
    });
</script>
