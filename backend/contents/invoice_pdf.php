<?php
require __DIR__ . '/../../vendor/autoload.php';
include("../config/my_class_for_web.php");

use Mpdf\Mpdf;

$obj = new my_class();
$id = $_GET['id'] ?? 0;

/* =========================
   FETCH DATA
========================= */
$invoice = $obj->Details_By_Cond("web_purchase_invoice", "id='$id'");
$invoice_id   = $invoice['id'];
$invoice_no   = $invoice['invoice_no'];
$invoice_date = date('l, F j, Y', strtotime($invoice['purchase_date']));

$supplier = $obj->Details_By_Cond("web_user", "id='{$invoice['supplier_id']}'");

$payment_info = $obj->Details_By_Cond("web_purchase_payments", "invoice_id='$invoice_id'");

/* =========================
   HTML START
========================= */
ob_start();
?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">

        <style>
            body {
                font-family: sans-serif;
                font-size: 12px;
                color: #111;
            }
            .page {
                padding: 20px;
            }

            /* Header */
            .header {
                border-bottom: 1px solid #ddd;
                padding-bottom: 15px;
            }
            .header-table {
                width: 100%;
            }
            .invoice-title {
                font-size: 32px;
                font-weight: bold;
                color: #0284c7;
            }
            .small-text {
                font-size: 11px;
            }
            .logo-box {
                width: 70px;
                height: 70px;
                border: 1px solid #ddd;
                border-radius: 8px;
                text-align: center;
            }

            /* Sections */
            .section {
                margin-top: 20px;
            }
            .section-title {
                font-weight: bold;
                margin-bottom: 6px;
            }
            .divider {
                border-bottom: 1px solid #e5e7eb;
                margin: 20px 0;
            }

            /* Tables */
            .table {
                width: 100%;
                border-collapse: collapse;
                font-size: 11px;
            }
            .table th {
                background: #e0f2fe;
                border: 1px solid #cbd5e1;
                padding: 6px;
            }
            .table td {
                border: 1px solid #cbd5e1;
                padding: 6px;
            }

            /* Payment table */
            .payment th {
                background: #dcfce7;
            }

            /* Totals */
            .totals {
                width: 260px;
                font-size: 11px;
            }
            .paid {
                background: #22c55e;
                color: #fff;
                font-weight: bold;
                padding: 8px;
                border-radius: 4px;
            }
            .due {
                background: #ef4444;
                color: #fff;
                font-weight: bold;
                padding: 8px;
                border-radius: 4px;
            }

            .right { text-align: right; }
            .center { text-align: center; }

            .footer-date {
                text-align: center;
                font-size: 10px;
                color: #6b7280;
                margin-top: 30px;
            }
        </style>
    </head>

    <body>
    <div class="page">

        <!-- HEADER -->
        <div class="header">
            <table class="header-table">
                <tr>
                    <td width="70%">
                        <div class="invoice-title">INVOICE</div>
                        <div class="small-text">
                            <strong>Invoice No:</strong> <?= $invoice_no ?><br>
                            <strong>Invoice Date:</strong> <?= $invoice_date ?>
                        </div>

                        <div class="section">
                            <div class="section-title">From</div>
                            Smart Trading House<br>
                            Industrial Area, Uptown-Crown<br>
                            smarttradinghouse@gmail.com<br>
                            01712345678
                        </div>
                    </td>

                    <td width="30%" class="right">
                        <table class="logo-box">
                            <tr>

                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <!-- BILL TO -->
        <div class="section">
            <div class="section-title">Bill To</div>
            <strong><?= $supplier['user_profile_name'] ?></strong><br>
            <?= $supplier['user_address'] ?><br>
            <?= $supplier['user_email'] ?><br>
            +88<?= $supplier['user_phone'] ?>
        </div>

        <div class="divider"></div>

        <!-- ITEMS TABLE -->
        <table class="table">
            <tr>
                <th>SI.</th>
                <th>Product Name</th>
                <th>Variant</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Sub Total</th>
                <th>Vat%</th>
                <th>Vat</th>
                <th>Total</th>
            </tr>

            <?php
            $si = 1;
            $subtotal_sum = 0;
            $vat_sum = 0;

            foreach ($obj->View_All_By_Cond("web_purchase_items", "invoice_id='$invoice_id'") as $item):
                $subtotal_sum += $item['subtotal'];
                $vat_sum += $item['vat'];
                ?>
                <tr>
                    <td><?= $si++ ?></td>
                    <td><?= $item['product_name'] ?></td>
                    <td><?= $item['variant'] ?></td>
                    <td><?= number_format($item['price'],2) ?></td>
                    <td><?= $item['qty'] ?></td>
                    <td><?= number_format($item['subtotal'],2) ?></td>
                    <td><?= number_format($item['vat_percent'],2) ?></td>
                    <td><?= number_format($item['vat'],2) ?></td>
                    <td><?= number_format($item['total'],2) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <br>

        <!-- PAYMENTS + TOTALS -->
        <table width="100%">
            <tr>
                <td width="60%">
                    <div class="section-title">Paid Details:</div>
                    <table class="table payment">
                        <tr>
                            <th>SI.</th>
                            <th>Payment Method</th>
                            <th>Amount</th>
                        </tr>
                        <?php
                        $p = 1;
                        foreach ($obj->View_All_By_Cond("web_purchase_payments", "invoice_id='$invoice_id'") as $pay):
                            ?>
                            <tr>
                                <td><?= $p++ ?></td>
                                <td><?= $pay['method'] ?></td>
                                <td><?= number_format($pay['amount'],2) ?> BDT</td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </td>

                <td width="40%" class="right">
                    <div class="totals">
                        Total : <?= number_format($subtotal_sum,2) ?> BDT<br><br>
                        Invoice Vat : <?= number_format($vat_sum,2) ?> BDT<br><br>
                        <strong>Total Payable : <?= number_format($payment_info['total_payable'],2) ?> BDT</strong><br><br>

                        <div class="paid">Total Paid : <?= number_format($payment_info['total_paid'],2) ?> BDT</div><br>
                        <div class="due">Total Due : <?= number_format($payment_info['total_due'],2) ?> BDT</div>
                    </div>
                </td>
            </tr>
        </table>

        <div class="footer-date"><?= date('l, F j, Y') ?></div>

    </div>
    </body>
    </html>

<?php
$html = ob_get_clean();

/* =========================
   MPDF OUTPUT
========================= */
$mpdf = new Mpdf(['format' => 'A4']);
$mpdf->WriteHTML($html);
$mpdf->Output($invoice_no . '.pdf', 'I');
exit;
