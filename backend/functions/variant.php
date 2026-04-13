<?php
session_start();
include("../../backend/config/my_class_for_web.php");
$obj = new my_class();
extract($_POST);

if($operation=="save"){
    $date = date("Y-m-d H:i:s");

    $values = [
        "product_ref"=>$product_id,
        "variant_type_ref"=>$variant_type_id,
        "variant_name"=>$variant,
        "active_flag"=>$active_flag,
        "create_by"=>1,
        "create_date"=>$date
    ];

    echo $obj->Insert_Data("variant",$values) ? "Success" : "Fail";
}

else if($operation=="update"){
    $date = date("Y-m-d H:i:s");

    $values = [
        "product_type_ref"=>$product_type_id,
        "name"=>$product_subtype,
        "short_desc"=>$short_desc,
        "long_desc"=>$full_desc,
        "active_flag"=>$active_flag,
        "last_update_by"=>1,
        "last_update_date"=>$date
    ];

    echo $obj->Update_Data("web_product_subtype",$values,"id='$id'") ? "Success" : "Fail";
}

else if($operation=="publish"){
    echo $obj->Update_Data("web_product_subtype",
        ["active_flag"=>1],"id=$id") ? "Success" : "Fail";
}

else if($operation=="unpublish"){
    echo $obj->Update_Data("web_product_subtype",
        ["active_flag"=>2],"id=$id") ? "Success" : "Fail";
}

else if($operation=="remove"){
    echo $obj->Update_Data("web_product_subtype",
        ["active_flag"=>3],"id=$id") ? "Success" : "Fail";
}
