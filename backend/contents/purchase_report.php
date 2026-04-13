<?php
// invoice.php
include("config/my_class_for_web.php");
$obj = new my_class();
$supplier_count=$obj->Total_Count_By_Cond("web_user","active_flag=1 AND user_type_ref=2");
$invoice_count=$obj->Total_Count_By_Cond("web_purchase_invoice","active_flag=1");
$total_purchase =0;
$total_vat=0;
foreach ($obj->View_All_By_Cond("web_purchase_invoice","active_flag=1")as $row) {
    $total_purchase+=$row['total_payable'];
    $total_vat+=$row['total_vat'];
}
$year = date("Y");
$month = date("m");
$day = date("d");
$yearly_purchase = 0;
foreach ($obj->View_All_By_Cond("web_purchase_invoice","active_flag=1 AND YEAR(purchase_date)=$year")as $row) {
    $yearly_purchase+=$row['total_payable'];
}
$monthly_purchase = 0;
foreach ($obj->View_All_By_Cond("web_purchase_invoice","active_flag=1 AND MONTH(purchase_date)=$month AND YEAR(purchase_date)=$year")as $row) {
    $monthly_purchase+=$row['total_payable'];
}
$weekly_purchase = 0;
$date = date("Y-m-d", strtotime("-7 days"));
foreach ($obj->View_All_By_Cond("web_purchase_invoice","active_flag=1 AND purchase_date>='$date'")as $row) {
    $weekly_purchase+=$row['total_payable'];
}
$daily_purchase = 0;
$date = date("Y-m-d");
foreach ($obj->View_All_By_Cond("web_purchase_invoice","active_flag=1 AND purchase_date='$date'")as $row) {
    $daily_purchase+=$row['total_payable'];
}
?>
<?php
include("header.php");
?>
<?php
include("sidebar.php")
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
                <h4 class="text-themecolor">Purchase Report</h4>
            </div>
            <div class="col-md-7 align-self-center text-end">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Purchase Report</li>
                    </ol>
                    <button type="button" class="btn btn-info d-none d-lg-block m-l-15 text-white" onclick="window.location.href='?page=add_purchase'"><i
                                class="fa fa-plus-circle"></i> New Purchase</button>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <!-- Row -->
        <div class="row">
            <!-- Column -->
            <div class="col-lg-2 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div>
                                <h4 class="card-title text-black">Total Purchase</h4>
                                <h6 class="card-subtitle text-black"><b><?php echo $total_purchase?> ৳</b></h6>
                            </div>
                        </div>
                        <div id="spark4">
                            <div class="ms-auto">
                                <a href="" target="_blank" class='btn btn-success btn-xs' role="button"><i class='fa fa-info'></i>  Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-2 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div>
                                <h4 class="card-title text-black">Total Vat</h4>
                                <h6 class="card-subtitle text-black"><b><?php echo $total_vat?> ৳</b></h6>
                            </div>
                        </div><br>
                        <div id="spark4">
                            <div class="ms-auto">
                                <a href="" target="_blank" class='btn btn-success btn-xs' role="button"><i class='fa fa-info'></i>  Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-2 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div>
                                <h4 class="card-title text-black">Yearly Purchase</h4>
                                <h6 class="card-subtitle text-black"><?php echo $yearly_purchase?>৳</h6>
                            </div>
                        </div>
                        <div id="spark4">
                            <div class="ms-auto">
                                <a href="" target="_blank" class='btn btn-success btn-xs' role="button"><i class='fa fa-info'></i>  Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-2 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div>
                                <h5 class="card-title text-black">Monthly Purchase</h5>
                                <h6 class="card-subtitle text-black"><?php echo $monthly_purchase?>৳</h6>
                            </div>
                        </div>
                        <div id="spark5">
                            <div class="ms-auto">
                                <a href="" target="_blank" class='btn btn-success btn-xs' role="button"><i class='fa fa-info'></i>  Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-2 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div>
                                <h4 class="card-title text-black">Weekly Purchase</h4>
                                <h6 class="card-subtitle text-black"><?php echo $weekly_purchase?>৳</h6>
                            </div>
                        </div>
                        <div id="spark6">
                            <div class="ms-auto">
                                <a href="" target="_blank" class='btn btn-success btn-xs' role="button"><i class='fa fa-info'></i>  Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-2 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div>
                                <h4 class="card-title text-black">Daily Purchase</h4>
                                <h6 class="card-subtitle text-black"><?php echo $daily_purchase?>৳</h6>
                            </div>
                        </div>
                        <div id="spark7">
                            <div class="ms-auto">
                                <a href="" target="_blank" class='btn btn-success btn-xs' role="button"><i class='fa fa-info'></i>  Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>
        <!-- Row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Purchase Report Export</h4>
                        <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                        <div class="table-responsive m-t-40">
                            <table id="example23"
                                   class="display nowrap table table-hover table-striped border"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>SI.</th>
                                    <th>Invoice</th>
                                    <th>Supplier</th>
                                    <th>Items</th>
                                    <th>Payments</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>SI.</th>
                                    <th>Invoice</th>
                                    <th>Supplier</th>
                                    <th>Items</th>
                                    <th>Payments</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                <?php
                                $x=1;
                                foreach ($obj->View_All_By_Cond("web_purchase_invoice","active_flag=1") as $value){
                                    $id = $value['id'];
                                    $date = date("Y-m-d", strtotime($value['created_at']));
                                    $invoice_no = $value['invoice_no'];
                                    $customer_ref = $value['supplier_id'];
                                    $customer_info = $obj->Details_By_Cond("web_user","id=$customer_ref");
                                    $customer_name = $customer_info['user_profile_name'];
                                    $customer_email = $customer_info['user_email'];
                                    $customer_phone = $customer_info['user_phone'];
                                    $customer_address = $customer_info['user_address'];
                                    $amount = $value['total_payable'];
                                    $vat = $value['total_vat'];
                                    $paid_amount = $value['total_paid'];
                                    $change_amount = $value['total_due'];
                                    ?>
                                    <tr>
                                        <td><?php echo $x?>.</td>
                                        <td>
                                            <?php echo $date?>
                                            <br>
                                            <?php echo $invoice_no?>
                                        </td>
                                        <td>
                                            <?php echo $customer_name?><br>
                                            <?php echo $customer_email?><br>
                                            <?php echo $customer_phone?><br>
                                            <?php echo $customer_address?>
                                        </td>
                                        <td>
                                            <?php
                                            $y=1;
                                            foreach ($obj->View_All_By_Cond("web_purchase_items","invoice_id=$id")as $row) {
                                                echo '<b>'.$y++.'. Variant:  </b>'.$row['variant'].'<br><b> QTY: </b>';
                                                echo $row['qty'].' '.'<br><br>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <b>Amount: </b><?php echo $amount?>৳
                                            <br>
                                            <b>Vat:    </b><?php echo $vat?>৳
                                            <br>
                                            <b>Paid:   </b><?php echo $paid_amount?>৳
                                            <br>
                                            <b>Change: </b><?php echo abs($change_amount)?>৳
                                        </td>
                                        <td>
                                            <a href="contents/invoice_pdf.php?id=<?php echo $id; ?>" target="_blank" class='btn btn-success btn-xs' role="button"><i class='fa fa-print'></i> Print</a>
                                        </td>
                                    </tr>
                                    <?php $x++; } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right sidebar -->
        <!-- ============================================================== -->
        <!-- .right-sidebar -->
        <div class="right-sidebar">
            <div class="slimscrollright">
                <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span>
                </div>
                <div class="r-panel-body">
                    <ul id="themecolors" class="m-t-20">
                        <li><b>With Light sidebar</b></li>
                        <li><a href="javascript:void(0)" data-skin="skin-default"
                               class="default-theme working">1</a></li>
                        <li><a href="javascript:void(0)" data-skin="skin-green" class="green-theme">2</a></li>
                        <li><a href="javascript:void(0)" data-skin="skin-red" class="red-theme">3</a></li>
                        <li><a href="javascript:void(0)" data-skin="skin-blue" class="blue-theme">4</a></li>
                        <li><a href="javascript:void(0)" data-skin="skin-purple" class="purple-theme">5</a></li>
                        <li><a href="javascript:void(0)" data-skin="skin-megna" class="megna-theme">6</a></li>
                        <li class="d-block m-t-30"><b>With Dark sidebar</b></li>
                        <li><a href="javascript:void(0)" data-skin="skin-default-dark"
                               class="default-dark-theme ">7</a></li>
                        <li><a href="javascript:void(0)" data-skin="skin-green-dark"
                               class="green-dark-theme">8</a></li>
                        <li><a href="javascript:void(0)" data-skin="skin-red-dark" class="red-dark-theme">9</a>
                        </li>
                        <li><a href="javascript:void(0)" data-skin="skin-blue-dark"
                               class="blue-dark-theme">10</a></li>
                        <li><a href="javascript:void(0)" data-skin="skin-purple-dark"
                               class="purple-dark-theme">11</a></li>
                        <li><a href="javascript:void(0)" data-skin="skin-megna-dark"
                               class="megna-dark-theme ">12</a></li>
                    </ul>
                    <ul class="m-t-20 chatonline">
                        <li><b>Chat option</b></li>
                        <li>
                            <a href="javascript:void(0)"><img src="assets/images/users/1.jpg" alt="user-img"
                                                              class="img-circle"> <span>Varun Dhavan <small
                                            class="text-success">online</small></span></a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"><img src="assets/images/users/2.jpg" alt="user-img"
                                                              class="img-circle"> <span>Genelia Deshmukh <small
                                            class="text-warning">Away</small></span></a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"><img src="assets/images/users/3.jpg" alt="user-img"
                                                              class="img-circle"> <span>Ritesh Deshmukh <small
                                            class="text-danger">Busy</small></span></a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"><img src="assets/images/users/4.jpg" alt="user-img"
                                                              class="img-circle"> <span>Arijit Sinh <small
                                            class="text-muted">Offline</small></span></a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"><img src="assets/images/users/5.jpg" alt="user-img"
                                                              class="img-circle"> <span>Govinda Star <small
                                            class="text-success">online</small></span></a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"><img src="assets/images/users/6.jpg" alt="user-img"
                                                              class="img-circle"> <span>John Abraham<small
                                            class="text-success">online</small></span></a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"><img src="assets/images/users/7.jpg" alt="user-img"
                                                              class="img-circle"> <span>Hritik Roshan<small
                                            class="text-success">online</small></span></a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"><img src="assets/images/users/8.jpg" alt="user-img"
                                                              class="img-circle"> <span>Pwandeep rajan <small
                                            class="text-success">online</small></span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Right sidebar -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->

<!-- end - This is for export functionality only -->
<script>
    $(function () {
        $('#myTable').DataTable();
        var table = $('#example').DataTable({
            "columnDefs": [{
                "visible": false,
                "targets": 2
            }],
            "order": [
                [2, 'asc']
            ],
            "displayLength": 25,
            "drawCallback": function (settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;
                api.column(2, {
                    page: 'current'
                }).data().each(function (group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                        last = group;
                    }
                });
            }
        });
        // Order by the grouping
        $('#example tbody').on('click', 'tr.group', function () {
            var currentOrder = table.order()[0];
            if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                table.order([2, 'desc']).draw();
            } else {
                table.order([2, 'asc']).draw();
            }
        });
        // responsive table
        $('#config-table').DataTable({
            responsive: true
        });
        $('#example23').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary me-1');
    });

</script>
