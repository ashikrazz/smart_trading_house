<?php
header('Content-Type: application/json');
include("../config/my_class_for_web.php");
$obj = new my_class();

// ========================
// GET POST DATA
// ========================
$invoice_no    = $_POST['invoice_no'] ?? '';
$note          = $_POST['note'] ?? '';
$supplier_id   = $_POST['supplier_id'] ?? 0;
$purchase_date = $_POST['purchase_date'] ?? date('Y-m-d');
$items         = json_decode($_POST['items'] ?? '[]', true);
$payments      = json_decode($_POST['payments'] ?? '[]', true);

// ========================
// BASIC VALIDATION
// ========================
if (!$invoice_no || !$supplier_id || empty($items)) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Missing required data'
    ]);
    exit;
}

// ========================
// CALCULATE TOTAL PAYABLE
// ========================
$total_payable = 0;
$total_vat = 0;
foreach ($items as $item) {
    $total_payable += (float)$item['total'];
    $total_vat += (float)$item['vat'];
}

// ========================
// CALCULATE TOTAL PAID
// ========================
$total_paid = 0;
foreach ($payments as $pay) {
    $total_paid += (float)$pay['amount'];
}

// ========================
// CALCULATE TOTAL DUE
// ========================
$total_due = $total_payable - $total_paid;

// ========================
// 1. SAVE PURCHASE INVOICE
// ========================
$invoice_data = [
    'invoice_no'    => $invoice_no,
    'supplier_id'   => $supplier_id,
    'purchase_date'     => $purchase_date,
    'note'          => $note,
    'created_at'    => date('Y-m-d H:i:s'),
    'active_flag'   => 1,
    'total_payable' => $total_payable,
    'total_vat'     => $total_vat,
    'total_paid'    => $total_paid,
    'total_due'     => $total_due
];

$invoice_id = $obj->Insert_Data('web_purchase_invoice', $invoice_data);

if (!$invoice_id) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Failed to save invoice'
    ]);
    exit;
}

// ========================
// 2. SAVE PURCHASE ITEMS
// ========================
foreach ($items as $item) {

    $item_data = [
        'invoice_id' => $invoice_id,
        'product_name' => $item['product_name'],
        'variant' => $item['variant'],
        'qty' => $item['qty'],
        'price' => $item['price'],
        'subtotal' => $item['subtotal'],
        'vat' => $item['vat'],
        'vat_percent' => $item['vat_percent'],
        'total' => $item['total'],
        'created_at' => date('Y-m-d H:i:s')
    ];

    $obj->Insert_Data('web_purchase_items', $item_data);
}

// ========================
// 3. SAVE PAYMENTS + TOTALS
// ========================
foreach ($payments as $pay) {

    $payment_data = [
        'invoice_id'    => $invoice_id,
        'method'        => $pay['method'],
        'amount'        => $pay['amount'],
        'date'          => $pay['date'],
        'notes'         => $pay['notes'],

        // REQUIRED TOTAL FIELDS
        'total_payable' => $total_payable,
        'total_paid'    => $total_paid,
        'total_due'     => $total_due,
        'active_flag'   => 1,

        'created_at'    => date('Y-m-d H:i:s'),
        'created_by'    => 1
    ];

    $obj->Insert_Data('web_purchase_payments', $payment_data);
}

// ========================
// RETURN SUCCESS RESPONSE
// ========================
echo json_encode([
    'status'     => 'success',
    'invoice_id'=> $invoice_id
]);
