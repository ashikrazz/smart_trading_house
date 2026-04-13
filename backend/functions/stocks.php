<?php
include("../../backend/config/my_class_for_web.php");
$obj = new my_class();
extract($_POST);

$product_id = $_POST['product_id'] ?? 0;

echo '<option value="">-- Select Variant --</option>';

if ($product_id > 0) {
    foreach ($obj->View_All_By_Cond("variant", "product_ref='$product_id' AND active_flag=1") as $row) {
        echo "<option value='{$row['id']}'>{$row['variant_name']}</option>";
    }
}

if($operation=='save'){
    $date=date('Y-m-d H:i:s');
    $values = [
        'product_ref'=>$product_id,
        'variant_ref'=>$variant_id,
        'stock_in'=>$stocks_amount,
        'min_stock'=>$stocks_min,
        'stock_flag'=>0,
        'active_flag'=>1,
        'create_by'=>1,
        'create_date'=>$date

    ];
    echo $obj->Insert_Data("product_stocks",$values) ? "Success" : "Fail";
}
else if($operation=='update'){
    $date=date('Y-m-d H:i:s');
    $values = [
        'product_ref'=>$product_id,
        'variant_ref'=>$variant_id,
        'stock_in'=>$stocks_amount,
        'min_stock'=>$stocks_min,
        'stock_flag'=>0,
        'active_flag'=>1,
        'last_update_by'=>1,
        'last_update_date'=>$date
    ];
    echo $obj->Update_Data("product_stocks",$values,"variant_ref='$variant_id'") ? "Success" : "Fail";
}
?>
