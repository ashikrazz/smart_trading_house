<?php
// invoice.php
include("config/my_class_for_web.php");
$obj = new my_class();
$customer_count=$obj->Total_Count_By_Cond("web_user","active_flag=1 AND user_type_ref=3");
$invoice_count=$obj->Total_Count_By_Cond("customer_purchase_invoice","active_flag=1");
$total_sale =0;
$total_vat=0;
foreach ($obj->View_All_By_Cond("customer_purchase_invoice","active_flag=1")as $row) {
    $total_sale+=$row['total_payable'];
    $total_vat+=$row['total_vat'];
}
$year = date("Y");
$month = date("m");
$day = date("d");
$yearly_sale = 0;
foreach ($obj->View_All_By_Cond("customer_purchase_invoice","active_flag=1 AND YEAR(sale_date)=$year")as $row) {
    $yearly_sale+=$row['total_payable'];
}
$monthly_sale = 0;
foreach ($obj->View_All_By_Cond("customer_purchase_invoice","active_flag=1 AND MONTH(sale_date)=$month AND YEAR(sale_date)=$year")as $row) {
    $monthly_sale+=$row['total_payable'];
}
$weekly_sale = 0;
$date = date("Y-m-d", strtotime("-7 days"));
foreach ($obj->View_All_By_Cond("customer_purchase_invoice","active_flag=1 AND sale_date>='$date'")as $row) {
    $weekly_sale+=$row['total_payable'];
}
$daily_sale = 0;
$date = date("Y-m-d");
foreach ($obj->View_All_By_Cond("customer_purchase_invoice","active_flag=1 AND sale_date='$date'")as $row) {
    $daily_sale+=$row['total_payable'];
}
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
                <h4 class="text-themecolor">Sales Report</h4>
            </div>
            <div class="col-md-7 align-self-center text-end">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Sales Report</li>
                    </ol>
                    <button type="button" class="btn btn-info d-none d-lg-block m-l-15 text-white" onclick="window.location.href='?page=add_sale'"><i
                            class="fa fa-plus-circle"></i> New Sale</button>
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
                                <h4 class="card-title text-black">Total Sale</h4>
                                <h6 class="card-subtitle text-black"><b><?php echo $total_sale?> ৳</b></h6>
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
                                <h4 class="card-title text-black">Yearly Sale</h4>
                                <h6 class="card-subtitle text-black"><?php echo $yearly_sale?>৳</h6>
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
                                <h5 class="card-title text-black">Monthly Sale</h5>
                                <h6 class="card-subtitle text-black"><?php echo $monthly_sale?>৳</h6>
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
                                <h4 class="card-title text-black">Weekly Sale</h4>
                                <h6 class="card-subtitle text-black"><?php echo $weekly_sale?>৳</h6>
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
                                <h4 class="card-title text-black">Daily Sale</h4>
                                <h6 class="card-subtitle text-black"><?php echo $daily_sale?>৳</h6>
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
                        <h4 class="card-title">Sales Report Export</h4>
                        <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                        <div class="table-responsive m-t-40">
                            <table id="example23"
                                   class="display nowrap table table-hover table-striped border"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>SI.</th>
                                    <th>Invoice</th>
                                    <th>Customer</th>
                                    <th>Items</th>
                                    <th>Payments</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>SI.</th>
                                    <th>Invoice</th>
                                    <th>Customer</th>
                                    <th>Items</th>
                                    <th>Payments</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                <?php
                                    $x=1;
                                    foreach ($obj->View_All_By_Cond("customer_purchase_invoice","active_flag=1") as $value){
                                        $id = $value['id'];
                                        $date = date("Y-m-d", strtotime($value['created_at']));
                                        $invoice_no = $value['invoice_no'];
                                        $customer_ref = $value['customer_id'];
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
                                                foreach ($obj->View_All_By_Cond("customer_sale_items","invoice_id=$id")as $row) {
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
                                            <a href="contents/customer_invoice_pdf.php?id=<?php echo $id; ?>" target="_blank" class='btn btn-success btn-xs' role="button"><i class='fa fa-print'></i> Print</a>
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
