<?php
session_start();
include("../../backend/config/my_class_for_web.php");
$obj = new my_class();
extract($_POST);

if($operation=='check_customer_duplicacy'){
    $db_field = ($field=='customer_email') ? 'customer_email' : 'customer_user_name';
    $count = $obj->Total_Count_By_Cond("web_user","$db_field='$value' AND active_flag='1'");
    echo $count;
}

else if($operation=='customer_save'){
    $date = date('Y-m-d H:i:s');
    $values = array(
        'user_profile_name'=>$customer_profile_name,
        'user_name'=>$customer_user_name,
        'user_email'=>$customer_email,
        'user_phone'=>$customer_phone,
        'nid'=>$customer_nid,
        'user_address'=>$customer_address,
        'user_profile_pic'=>$customer_profile_pic,
        'user_password'=>md5($customer_password),
        'user_type_ref'=>$user_type,
        'active_flag'=>$customer_active_flag,
        'create_by'=>1,
        'create_date'=>$date
    );
    $sql = $obj->Insert_Data("web_user",$values);
    echo $sql ? "Success" : "Fail";
}

else if ($operation=='update'){
    $date=date('Y-m-d H:i:s');
    $dataTable = "web_user";
    $values = array(
        'user_profile_name'=>$customer_profile_name,
        'user_name'=>$customer_user_name,
        'user_email'=>$customer_email,
        'user_phone'=>$customer_phone,
        'nid'=>$customer_nid,
        'user_address'=>$customer_address,
        'user_profile_pic'=>$customer_profile_pic,
        'user_password'=>md5($customer_password),
        'user_type_ref'=>$user_type,
        'active_flag'=>$customer_active_flag,
        'last_update_by'=>1,
        'last_update_date'=>$date
    );
    $where_cond = "id='$id'";
    $sql = $obj->Update_Data($dataTable,$values,$where_cond);
    if($sql){
        echo "Success";
    } else {
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

    echo $obj->Update_Data("web_user", $values, "id=$id") ? "Success" : "Fail";
}


/* ================= UNPUBLISH ================= */
else if ($operation == 'unpublish') {

    $date = date('Y-m-d H:i:s');

    $values = array(
        'active_flag' => 2,
        'last_update_by' => 1,
        'last_update_date' => $date
    );

    echo $obj->Update_Data("web_user", $values, "id=$id") ? "Success" : "Fail";
}


/* ================= REMOVE ================= */
else if ($operation == 'remove') {

    $date = date('Y-m-d H:i:s');

    $values = array(
        'active_flag' => 3,
        'last_update_by' => 1,
        'last_update_date' => $date
    );

    echo $obj->Update_Data("web_user", $values, "id=$id") ? "Success" : "Fail";
}