<?php
include("../../backend/config/my_class_for_web.php");
$obj = new my_class();
extract($_POST);

if($operation=='save'){
    $date=date('Y-m-d H:i:s');
    $values = [
        'product_type_title'=>$product_type,
        'product_type_short_desc'=>$product_type_short_desc,
        'product_type_long_desc'=>$product_type_full_desc,
        'product_type_icon'=>$product_type_icon,
        'active_flag'=>$active_flag,
        'create_by'=>1,
        'create_date'=>$date
    ];
    echo $obj->Insert_Data("web_product_type",$values) ? "Success" : "Fail";
}
else if($operation=='update'){
    $date=date('Y-m-d H:i:s');
    $values = [
        'product_type_title'=>$product_type,
        'product_type_short_desc'=>$product_type_short_desc,
        'product_type_long_desc'=>$product_type_full_desc,
        'product_type_icon'=>$product_type_icon,
        'active_flag'=>$active_flag,
        'last_update_by'=>1,
        'last_update_date'=>$date
    ];
    echo $obj->Update_Data("web_product_type",$values,"id='$id'") ? "Success" : "Fail";
}
else if($operation=='publish'){
    echo $obj->Update_Data("web_product_type",['active_flag'=>1],'id='.$id) ? "Success" : "Fail"; }
else if($operation=='unpublish'){
    echo $obj->Update_Data("web_product_type",['active_flag'=>2],'id='.$id) ? "Success" : "Fail"; }
else if($operation=='remove'){
    echo $obj->Update_Data("web_product_type",['active_flag'=>3],'id='.$id) ? "Success" : "Fail"; }
?>
