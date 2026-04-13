<?php
session_start();
//include ("config/db_conn.php");
//include ("config/my_class_for_web.php");
error_reporting(1);
ini_set('display_errors', 1);
/* ===============================
   PATH & URL DEFINITIONS
================================ */
define('BASE_PATH', __DIR__);
define('BASE_URL', 'https://inventory.winkytech.com');
$themeUrl = BASE_URL."/backend/theme";

include (BASE_PATH ."/backend/config/my_class_for_web.php");

$user_role_ref =1;
//$obj=new my_class();
$page_name = $_REQUEST["page"];
if(isset($_REQUEST["page"]) && $_REQUEST["page"]!=""){
    $page="contents/".$page_name;
} else {
    $page="contents/dashboard";
}
?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Smart Trading House</title>
        <style>
            h3.card-title{
                width: 95%;
            }
        </style>
        <?php
        include('layout/headerScript.php');
        ?>
    </head>
    <?php
    include('layout/siteHeader.php');
    include('layout/sidebar.php');
    include($page.'.php');
    include('layout/siteFooter.php');
    include('layout/footerScript.php');
    ?>

