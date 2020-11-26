<?php 

include "admin/connect.php";

$userid = $_REQUEST['userID'];
$itemid = $_REQUEST['itemID'];
$number = $_REQUEST['number'];

$statm = $con->prepare("INSERT INTO cart(itemID, userID, number) VALUES(:Zitemid, :Zuserid, :Znumber)");
$statm->execute(array(

    "Zitemid"   => $itemid,
    "Zuserid"   => $userid,
    "Znumber"   => $number  

));
echo "Order Now";
?>

                                        

                                            

