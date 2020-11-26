<?php

   include 'admin/connect.php';

    $tpl  = "includes/templates/";
    $func = "includes/functions";
    $css  = "layout/css/";
    $js   = "layout/js/";

    include $tpl . "header.php"; 

    
if($page != 'signup')
    include $tpl . "Navbar.php"; 
else
    include $tpl . "signnavbar.php";


?>