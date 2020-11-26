<?php include "init.php"; 




$stmt = $con->prepare("SELECT * FROM orders");
$stmt->execute();
$fetch = $stmt->fetch();

echo $fetch['order-items'] . "<br>";

$ex = explode(',' , $fetch['order-items']);


foreach($ex as $it){
    $stmt = $con->prepare("SELECT Price FROM items WHERE Name=?");
    $stmt->execute(array($it));
    $fetchprice = $stmt->fetch();
    
    echo $fetchprice['Price'] . "<br>";
    
   
    
    
}
 $xx = implode(',', $ex);
echo $xx . "<br>";

include $tpl . "footer.php"; ?>