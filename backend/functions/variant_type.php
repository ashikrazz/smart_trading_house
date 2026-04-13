<?php
session_start();
include("../../backend/config/my_class_for_web.php");
$obj = new my_class();

extract($_POST);

/* ================= SAVE ================= */
if ($operation == 'save') {

    $date = date('Y-m-d H:i:s');

    // 🔐 IMPORTANT FIX
    $name        = addslashes($variant_type_name);
    $description = addslashes($description);

    $values = array(
        'variant'           => $variant_type_name,
        'description'       => $description,
        'active_flag'       => $status,
        'create_by'         => 1,
        'create_date'       => $date
    );

    $sql = $obj->Insert_Data("variant_type", $values);
    echo $sql ? "Success" : "Fail";
}


/* ================= UPDATE ================= */
else if ($operation == 'update') {

    $date = date('Y-m-d H:i:s');

    // 🔐 IMPORTANT FIX
    $name        = addslashes($variant_type_name);
    $description = addslashes($description);

    $values = array(
        'variant'           => $variant_type_name,
        'description'       => $description,
        'active_flag'       => $status,
        'last_update_by'    => 1,
        'last_update_date'  => $date
    );

    $where_cond = "id='$id'";
    $sql = $obj->Update_Data("variant_type", $values, $where_cond);

    echo $sql ? "Success" : "Fail";
}


/* ================= PUBLISH ================= */
else if ($operation == 'publish') {

    $date = date('Y-m-d H:i:s');

    $values = array(
        'active_flag' => 1,
        'last_update_by' => 1,
        'last_update_date' => $date
    );

    echo $obj->Update_Data("variant_type", $values, "id=$id") ? "Success" : "Fail";
}


/* ================= UNPUBLISH ================= */
else if ($operation == 'unpublish') {

    $date = date('Y-m-d H:i:s');

    $values = array(
        'active_flag' => 2,
        'last_update_by' => 1,
        'last_update_date' => $date
    );

    echo $obj->Update_Data("variant_type", $values, "id=$id") ? "Success" : "Fail";
}


/* ================= REMOVE ================= */
else if ($operation == 'remove') {

    $date = date('Y-m-d H:i:s');

    $values = array(
        'active_flag' => 3,
        'last_update_by' => 1,
        'last_update_date' => $date
    );

    echo $obj->Update_Data("variant_type", $values, "id=$id") ? "Success" : "Fail";
}
?>

