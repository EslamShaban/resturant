<?php 
    session_start();
    if(isset($_SESSION['Username'])){
        $page = '';
        include "init.php"; 
        
            
        $userID = $_SESSION['ID'];
        
        $codeOfOrder = isset($_GET['code']) && is_numeric($_GET['code']) ? intval($_GET['code']) : "allorder";
        
        if($codeOfOrder != "allorder"){

            $nameOFOrderItems = array();
            $totalPrice = 0 ;

            $cartitems = $con->prepare("SELECT * FROM cart WHERE userID=?");
            $cartitems->execute(array($userID));
            $ordercartitems = $cartitems->fetchAll();


            foreach($ordercartitems as $ordercartitem){

                $nameOFItems = $con->prepare("SELECT Name,Price FROM items WHERE ItemID = ? ");
                $nameOFItems->execute(array($ordercartitem['itemID']));
                $nameOFOrderItem = $nameOFItems->fetch();
                $nameOFOrderItems[] = $nameOFOrderItem['Name'];
                $numberOFOrderItems[] = $ordercartitem['number'];
                $totalPrice += $nameOFOrderItem['Price']*$ordercartitem['number'];

            }

            $implodeOrderItems = implode(',' , $nameOFOrderItems) ;
            $implodeOrderItemsNumber = implode(',' , $numberOFOrderItems) ;


            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $code       = $_POST['code'];
                $flat       = $_POST['flat'];
                $street     = $_POST['street'];
                $area       = $_POST['area'];
                $landmark   = $_POST['landmark'];
                $city       = $_POST['city'];
                $status     = "NotConfirmedYet";
                        
                $formErrors = array();
        
                if(empty($flat)){
                        $formErrors[] = 'Flat No. should not be empty'; 
                }                
                if(empty($street)){
                        $formErrors[] = 'Street should not be empty'; 
                }                
                if(empty($area)){
                        $formErrors[] = 'Area should not be empty'; 
                }                
                if(empty($city)){
                        $formErrors[] = 'City should not be empty'; 
                }
            if(empty($formErrors)){
                
                            
                $ordercode = $con->prepare("SELECT * FROM orders WHERE Code=?");
                $ordercode->execute(array($code));
                $orderitem = $ordercode->fetch();
                
                if(empty($orderitem)){
                
                $order = $con->prepare("INSERT INTO `orders` (`Code`, `Flat`, `Street_Name`, `Area`, `Landmark`, `City`, `Status`, `Order_Date`, `userID`, `order-items`, `Total_Price`, `orderItemsNumber`) VALUES(:Zcode, :Zflat, :ZstreetName, :Zarea, :Zlandmark, :Zcity, :Zstatus, now(), :Zuserid, :Zorderitems, :Ztotalprice, :ZorderItemsNumber)");
                $order->execute(array(

                    "Zcode"             => $code, 
                    "Zflat"             => $flat, 
                    "ZstreetName"       => $street, 
                    "Zarea"             => $area, 
                    "Zlandmark"         => $landmark, 
                    "Zcity"             => $city, 
                    "Zstatus"           => $status, 
                    "Zuserid"           => $userID, 
                    "Zorderitems"       => $implodeOrderItems, 
                    "Ztotalprice"       => $totalPrice,
                    "Z orderItemsNumber"  => $implodeOrderItemsNumber
                )); 
                                                        
                if($order){

                        $delete = $con->prepare("DELETE FROM `cart` WHERE userID = :Zuser");
                        $delete->bindParam("Zuser", $userID);
                        $delete->execute();

                        $order_date = $con->prepare("SELECT * FROM orders WHERE Code = ?");
                        $order_date->execute(array($code));
                        $OrderDate = $order_date->fetch(); 

                    }
                                    
                
                }else{

                        $delete = $con->prepare("DELETE FROM `cart` WHERE userID = :Zuser");
                        $delete->bindParam("Zuser", $userID);
                        $delete->execute();

                        $order_date = $con->prepare("SELECT * FROM orders WHERE Code = ?");
                        $order_date->execute(array($code));
                        $OrderDate = $order_date->fetch(); 

                    }


            }

            }else{
                echo "no";
            }



    ?>


    <div class="orderSlider">
        <img src="layout/images/orderPicture2.png">
    </div>

    <div class="container">
        <?php if(empty($formErrors)) {?>
        
            <div class="orderdetail">
                <div class="col-sm-offset-2 col-sm-7">
                    <div class="displayflex">

                        <div class="image">
                            <img style="width:100px; height:100px" src="layout/images/order.jpg">
                        </div>
                        <div class="contentorder">
                            <a class="codeOrder" href="order_details.php?code=<?php echo $code; ?>">Order # <?php echo $code; ?></a>
                            <p>Order Date : <?php echo $OrderDate['Order_Date']; ?></p>
                            <p>
                                <i class="fa fa-check fa-lg"></i>
                                <?php 

                                    if($OrderDate['Status'] == 'NotConfirmedYet'){

                                        echo " Waiting For Resturant Confirme.  ";

                                    }else if($OrderDate['Status'] != 'NotConfirmedYet' && $OrderDate['Status'] != ''){

                                        echo $OrderDate['Status'] . "  ";

                                    }
                                ?>

                                <i class="fa fa-motorcycle fa-lg"></i> <a href="#" style="color:#f7600e">track order</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="viewdetails">
                        <a class="order" href="order_details.php?code=<?php echo $code?>">view details</a>
                    </div>
                </div>
                <hr>
            </div>
        
        <?php }else { 
            
            foreach($formErrors as $error){
                echo "<div class='alert alert-danger'>" . $error . "</div>";
            }
                
        
    } ?>
    </div>

<?php }else{
            
            
            $allorder = $con->prepare("SELECT * FROM orders WHERE userID=?");
            $allorder->execute(array($userID));
            $allorders = $allorder->fetchAll(); ?>
            
                                
            <div class="orderSlider">
                        
                <img src="layout/images/orderPicture2.png">
                    
            </div>
            
           <?php  
            if(empty($allorders)){
                echo "<div class='container'>";
                    echo "<div class='nice-message'>There's No Order</div>";
                echo "</div>";
            }else{
                
            foreach($allorders as $allorder){ ?>

                    <div class="container">
                        <div class="orderdetail">
                            <div class="row">
                                <div class="col-sm-offset-2 col-xs-8 col-sm-7">
                                    <div class="displayflex">

                                        <div class="image">
                                            <img style="width:100px; height:100px" src="layout/images/order.jpg">
                                        </div>
                                        <div class="contentorder">
                                            <a class="codeOrder" href="order_details.php?code=<?php echo $allorder['Code'];?>">Order # <?php echo $allorder['Code']; ?></a>
                                            <p>Order Date : <?php echo $allorder['Order_Date']; ?></p>
                                            <p>
                                                <i class="fa fa-check fa-lg"></i>
                                                <?php 

                                                    if($allorder['Status'] == 'NotConfirmedYet'){

                                                        echo " Waiting For Resturant Confirme.  ";

                                                    }else if($allorder['Status'] != 'NotConfirmedYet' && $allorder['Status'] != ''){

                                                        echo $allorder['Status'] . "  ";

                                                    }
                                                ?>

                                                <i class="fa fa-motorcycle fa-lg"></i> <a href="#" style="color:#f7600e">track order</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-4">
                                    <div class="viewdetails">
                                        <a class="order" href="order_details.php?code=<?php echo $allorder['Code'];?>">view details</a>
                                        <hr>
                                        <a class="order" href="cart.php?code=<?php echo $allorder['Code'];?>">Order again</a>
                                        
                                    </div>                                
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                
            <?php }
            }
            
        }
    }else{
        
        header('Location:signin.php');  // Redirect To Login Page
            
        exit();
    }

?>



<?php

include $tpl . "footer.php";
?>