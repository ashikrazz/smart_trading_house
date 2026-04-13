<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
include("../config/my_class_for_web.php");
$obj = new my_class();

/* ================= INPUT ================= */
$invoice_no    = $_POST['invoice_no'] ?? '';
$note          = $_POST['note'] ?? '';
$supplier_id   = (int)($_POST['supplier_id'] ?? 0);
$purchase_date = $_POST['purchase_date'] ?? date('Y-m-d');
$items         = json_decode($_POST['items'] ?? '[]', true);
$payments      = json_decode($_POST['payments'] ?? '[]', true);

/* ================= VALIDATION ================= */
if (!$invoice_no || !$supplier_id || empty($items)) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required data']);
    exit;
}

/* ================= TOTALS ================= */
$total_payable = 0;
$total_vat = 0;

foreach ($items as $item) {
    $total_payable += (float)$item['total'];
    $total_vat     += (float)$item['vat'];
}

$total_paid = 0;
foreach ($payments as $pay) {
    $total_paid += (float)$pay['amount'];
}

$total_due = $total_payable - $total_paid;

/* ================= INVOICE ================= */
$invoice_id = $obj->Insert_Data('customer_purchase_invoice', [
    'invoice_no'    => $invoice_no,
    'customer_id'   => $supplier_id,
    'sale_date'     => $purchase_date,
    'note'          => $note,
    'total_payable' => $total_payable,
    'total_vat'     => $total_vat,
    'total_paid'    => $total_paid,
    'change'        => abs($total_due),
                                'active_flag'   => 1,
                                'created_at'    => date('Y-m-d H:i:s')
]);

if (!$invoice_id) {
    echo json_encode(['status' => 'error', 'message' => 'Invoice insert failed']);
    exit;
}

/* ================= ITEMS + STOCK ================= */
foreach ($items as $item) {
    
    $variant_id = (int)($item['variant_id'] ?? 0);
    if ($variant_id <= 0) continue;
    
    $obj->Insert_Data('customer_sale_items', [
        'invoice_id'  => $invoice_id,
        'product_id'  => $item['product_id'],
        'product_name'=> $item['product_name'],
        'variant'     => $item['variant'],
        'qty'         => $item['qty'],
        'm_unit'      => $item['unit'],
        'price'       => $item['price'],
        'subtotal'    => $item['subtotal'],
        'vat'         => $item['vat'],
        'vat_percent' => $item['vat_percent'],
        'total'       => $item['total'],
        'created_at'  => date('Y-m-d H:i:s')
    ]);
    
    $stock = $obj->View_All_By_Cond("product_stocks", "variant_ref=$variant_id");
    if (empty($stock)) continue;
    
    $stock_out = (float)$stock[0]['stock_out'] + (float)$item['qty'];
    $stock_in  = (float)$stock[0]['stock_in'] - (float)$item['qty'];
    
    $obj->Update_Data(
        "product_stocks",
        [
            'stock_in' => $stock_in,
            'stock_out'=> $stock_out,
            'last_update_date' => date('Y-m-d H:i:s')
        ],
        "variant_ref=$variant_id"
    );
}

/* ================= PAYMENTS ================= */
foreach ($payments as $pay) {
    $obj->Insert_Data('customer_sale_payments', [
        'invoice_id' => $invoice_id,
        'method'     => $pay['method'],
        'amount'     => $pay['amount'],
        'date'       => $pay['date'],
        'notes'      => $pay['notes'],
        'active_flag'=> 1,
        'created_at' => date('Y-m-d H:i:s')
    ]);
}

echo json_encode(['status' => 'success', 'invoice_id' => $invoice_id]);
exit;
