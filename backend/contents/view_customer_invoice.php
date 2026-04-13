<?php
include("../config/my_class_for_web.php");
$obj = new my_class();
$id = $_GET['id'];

// Get invoice
$invoice_info = $obj->Details_By_Cond("customer_purchase_invoice", "id='$id'");
$invoice_id = $invoice_info['id'];
$invoice_code = $invoice_info['invoice_no'];
$purchase_date = $invoice_info['sale_date'];
$supplier_id = $invoice_info['customer_id'];
$supplier_info = $obj->Details_By_Cond("web_user", "id='$supplier_id'");
$supplier = $supplier_info['user_profile_name'];
$supplier_email = $supplier_info['user_email'];
$supplier_phone = $supplier_info['user_phone'];
$supplier_address = $supplier_info['user_address'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Invoice</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { margin: 0; }
            .page {
                width: 210mm;
                min-height: 297mm;
                padding: 20mm;
                margin: auto;
            }
        }
    </style>
</head>

<body class="bg-gray-100 flex justify-center py-10">
<div class="page bg-white shadow-lg p-10">
    <!-- Header -->
    <div class="flex justify-between items-start border-b pb-4">
        <div>
            <h1 class="text-4xl font-bold text-sky-600">INVOICE</h1>
            <div class="text-sm">
                <p><span class="font-semibold">Invoice No:</span> <?php echo $invoice_code; ?></p>
                <p><span class="font-semibold">Invoice Date:</span> <?php echo date('l, F j, Y', strtotime($purchase_date)); ?></p>
            </div>

            <p class="mt-4 font-semibold">From</p>
            <p class="text-sm">Smart Trading House</p>
            <p class="text-sm">Industrial Area, Uptown-Crown</p>
            <p class="text-sm">smarttradinghouse@gmail.com</p>
            <p class="text-sm">01712345678</p>
        </div>

        <div class="text-right">
            <div class="w-20 h-20 border rounded-lg flex justify-center items-center">
                <img src="https://cdn-icons-png.flaticon.com/512/2991/2991148.png" class="w-10 opacity-70">
            </div>
        </div>
    </div>

    <!-- Billing + Invoice Info -->
    <div class="flex justify-between mt-6 border-b pb-6">
        <div>
            <p class="font-semibold">Bill To</p>
            <p class="font-bold"><?php echo $supplier;?></p>
            <p class="text-sm"><?php echo $supplier_address;?></p>
            <p class="text-sm"><?php echo $supplier_email;?></p>
            <p class="text-sm">+88<?php echo $supplier_phone;?></p>
        </div>

    </div>

    <!-- Table -->
    <div class="mt-6">
        <table class="w-full border-collapse text-sm">
            <thead class="bg-sky-100">
            <tr class="text-left">
                <th class="p-2 border">SI.</th>
                <th class="p-2 border">Product Name</th>
                <th class="p-2 border w-24">Variant</th>
                <th class="p-2 border w-20">Price</th>
                <th class="p-2 border w-12">Qty</th>
                <th class="p-2 border w-24">Sub Total</th>
                <th class="p-2 border w-16">Vat%</th>
                <th class="p-2 border w-16">Vat</th>
                <th class="p-2 border w-24">Total</th>
            </tr>
            </thead>

            <tbody>

            <?php
            $x=1;
            $grand_total = 0;
            $invoice_vat = 0;
            $total_payable = 0;
            foreach ($obj->View_All_By_Cond("customer_sale_items","invoice_id = $invoice_id") as $value){
            $purchase_items_id = $value['id'];
            $product_name = $value['product_name'];
            $variant = $value['variant'];
            $price = $value['price'];
            $qty = $value['qty'];
            $unit = $value['m_unit'];
            $subtotal = $value['subtotal'];
            $vat_p = $value['vat_percent'];
            $vat = $value['vat'];
            $total = $value['total'];
            $grand_total += $subtotal;
            $invoice_vat += $vat;
            ?>
            <tr>
                <td class="p-2 border"><?php echo $x?></td>
                <td class="p-2 border"><?php echo $product_name?></td>
                <td class="p-2 border"><?php echo $variant?></td>
                <td class="p-2 border"><?php echo $price?> ৳</td>
                <td class="p-2 border"><?php echo $qty?>    <?php echo $unit?></td>
                <td class="p-2 border"><?php echo $subtotal?> ৳</td>
                <td class="p-2 border"><?php echo $vat_p?></td>
                <td class="p-2 border text-center"><?php echo $vat?> ৳</td>
                <td class="p-2 border"><?php echo $total?> ৳</td>
                <?php $x++; }
                ?>

            </tr>
            </tbody>
        </table>
    </div>

    <!-- Footer Section -->
    <div class="flex justify-between mt-8">
        <div class="text">
            <p class="font-bold">Paid Details:</p><br>
            <table class="w-full border-collapse text-sm none-border">
                <thead class="bg-green-100 justify-center text-center">
                <tr class="text-left">
                    <th class="p-2">SI.</th>
                    <th class="p-2">Payment Method</th>
                    <th class="p-2 w-24">Amount</th>
                </tr>
                </thead>
                <tbody class="justify-center text-center">
                <?php
                $y=1;
                $total_paid = 0;
                foreach ($obj->View_All_By_Cond("customer_sale_payments","invoice_id = $invoice_id") as $value){
                $amount = $value['amount'];
                $payment_method = $value['method'];
                ?>
                <tr>
                    <td class="p-2 "><?php echo $y?></td>
                    <td class="p-2 "><?php echo $payment_method?></td>
                    <td class="p-2 "><?php echo $amount?> ৳</td>
                    <?php $y++; }
                    ?>

                </tr>
                </tbody>
            </table>
        </div>

        <div class="text-sm w-60">
            <div class="flex justify-between py-1">
                <span>Total :</span>
                <span><?php echo $grand_total?> ৳</span>
            </div>

            <div class="flex justify-between py-1">
                <span>Invoice Vat :</span>
                <span><?php echo $invoice_vat?> ৳</span>
            </div>

            <?php
            $payment_information = $obj->Details_By_Cond("customer_sale_payments","invoice_id = $invoice_id");
            $total_payable = $payment_information['total_payable'];
            $total_paid = $payment_information['total_paid'];
            $total_due = $payment_information['change'];
            ?>
            <div class="flex justify-between py-1 mt-2">
                <span>Total Payable :</span>
                <span><?php echo $total_payable?> ৳</span>
            </div>

            <div class="bg-green-500 text-white font-bold flex justify-between px-3 py-2 rounded mt-2">
                <span>Total Paid :</span>
                <span><?php echo $total_paid?> ৳</span>
            </div>

            <div class="bg-red-500 text-white font-bold flex justify-between px-3 py-2 rounded mt-2">
                <span>Change :</span>
                <span><?php echo abs($total_due)?> ৳</span>
            </div>
        </div>

    </div>

    <p class="text-center text-sm text-gray-500 mt-10">
        <?php echo date('l, F j, Y');?>
    </p>
    <a href="customer_invoice_pdf.php?id=<?php echo $invoice_id; ?>" target="_blank"
       class="bg-sky-600 text-white px-4 py-2 rounded shadow flex justify-center items-center">
        🖨️ Print Invoice
    </a>


</div>
</body>
</html>

