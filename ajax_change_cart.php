<?php 

session_start();

include "admin/connect.php";

$userID = $_SESSION['ID'];
$cartid = $_REQUEST['cartid'];
$number = $_REQUEST['number'];

$Total_Price = 0;

$statm = $con->prepare("UPDATE cart set number=?  WHERE cartID = ?");
$statm->execute(array($number, $cartid));


$ststm = $con->prepare("SELECT * FROM cart WHERE userID = ?");
$ststm->execute(array($userID));
$cartItems = $ststm->fetchAll();

foreach($cartItems as $cartItem){

    $statment = $con->prepare("SELECT * FROM items WHERE ItemID = ?");
    $statment->execute(array($cartItem['itemID']));
    $fooditem = $statment->fetch();

    $Total_Price += $fooditem['Price'] * $cartItem['number'];
}

echo $Total_Price ;

?>

                                        

                                            

