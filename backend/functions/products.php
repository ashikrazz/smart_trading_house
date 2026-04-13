<?php
session_start();
include("../../backend/config/my_class_for_web.php");
$obj = new my_class();

extract($_POST);


/* ================= SAVE ================= */
if ($operation == 'save') {

    $date = date('Y-m-d H:i:s');

    // 🔐 IMPORTANT FIX
    $name        = addslashes($productName);
    $description = addslashes($description);

    $values = array(
        'type_ref'          => $category,
        'sub_type_ref'      => $sub_category,
        'brand_ref'         => $brand,
        'product_name'      => $name,
        'description'       => $description,
        'active_flag'       => $status,
        'create_by'         => 1,
        'create_date'       => $date
    );

    $product_id = $obj->Insert_Data("products", $values);
    echo $product_id ? $product_id : "Fail";
}


/* ================= UPDATE ================= */
else if ($operation == 'update') {

    $date = date('Y-m-d H:i:s');

    // 🔐 IMPORTANT FIX
    $values_1 = array(
        'product_ref'           => $product_id,
        'unit_ref'              => $unit_id,
        'variant_type_ref'      => $variant_type,
        'variant_name'          => $variant,
        'active_flag'           => $status,
        'create_by'             => 1,
        'create_date'           => $date
    );
    $sql_1 = $obj->Insert_Data("variant",$values_1);
    if($sql_1){
        $values_2 = array(
            'product_ref'       => $product_id,
            'variant_ref'       => $sql_1,
            'unit_ref'          => $unit_id,
            'buy_price'         => $buy_price,
            'sell_price'        => $sell_price,
            'vat'               => $vat,
            'active_flag'       => $status,
            'from_date'         => $date,
            'create_by'         => 1,
            'create_date'       => $date
        );
        $sql_2 = $obj->Insert_Data("product_price",$values_2);
        if($sql_2){
            $values_3 = array(
                'product_ref'   => $product_id,
                'variant_ref'   => $sql_1,
                'unit_ref'      => $unit_id,
                'stock_in'      => $stock_in,
                'min_stock'     => $min_stock,
                'stock_flag'    => 1,
                'active_flag'   => $status,
                'create_by'     => 1,
                'create_date'   => $date
            );
            $sql_3 = $obj->Insert_Data("product_stocks",$values_3);
            echo $sql_3 ? "Success" : "Fail";
        } else{
            echo "Fail";
        }
    } else{
        echo "Fail";
    }
}


/* ================= PUBLISH ================= */
else if ($operation == 'publish') {

    $date = date('Y-m-d H:i:s');

    $values = array(
        'active_flag' => 1,
        'last_update_by' => 1,
        'last_update_date' => $date
    );

    echo $obj->Update_Data("brand", $values, "id=$id") ? "Success" : "Fail";
}


/* ================= UNPUBLISH ================= */
else if ($operation == 'unpublish') {

    $date = date('Y-m-d H:i:s');

    $values = array(
        'active_flag' => 2,
        'last_update_by' => 1,
        'last_update_date' => $date
    );

    echo $obj->Update_Data("brand", $values, "id=$id") ? "Success" : "Fail";
}


/* ================= REMOVE ================= */
else if ($operation == 'remove') {

    $date = date('Y-m-d H:i:s');

    $values = array(
        'active_flag' => 3,
        'last_update_by' => 1,
        'last_update_date' => $date
    );

    echo $obj->Update_Data("brand", $values, "id=$id") ? "Success" : "Fail";
}
?>
