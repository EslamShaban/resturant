<?php 
        
    session_start();

    if(isset($_SESSION['Username'])){
        $page = '';
        include "init.php"; 
        
        $userID = $_SESSION['ID'];
        
        $order_code = isset($_GET['code']) && is_numeric($_GET['code']) ? intval($_GET['code']) : 0;
        
        $codeOrderDetails = $con->prepare("SELECT * FROM orders WHERE Code = ?");
        $codeOrderDetails->execute(array($order_code));
        $codeOrderDetail = $codeOrderDetails->fetch();
        
        $explodeOrders = explode(',' , $codeOrderDetail['order-items']);
   
?>

                
        <div class="fooddetailslidder">
            
        </div>

        <div class="fooddetail">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <span>Your ORDERES Delicious hot food!</span>
                                <span class="pull-right">
                                    <i class="fa fa-plus"></i>
                                </span>
                            </div>
                            <div class="panel-body">
                                
                                <?php 
                                    foreach($explodeOrders as $explodeOrder){
                                        $ordersItems = $con->prepare("SELECT * FROM items WHERE Name = ?");
                                        $ordersItems->execute(array($explodeOrder));
                                        $ordersItem = $ordersItems->fetch();

                                    
                                ?>
                                
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <span><?php echo $ordersItem['Name'] ; ?></span>
                                    </div>
                                    <div class="panel-body displayflex">
                                        <div class="image">
                                            <img class="img-responsive" src="<?php echo "admin/Upload/" . $ordersItem['image']  ; ?>">
                                        </div>
                                        <div class="content">
                                            <h3 ><?php echo $ordersItem['Name'] ; ?></h3>
                                            <p><?php echo $ordersItem['Description'] ; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="panel panel-default">
                            <div class="panel-heading"><span style="font-weight:bold">Order # <?php echo $codeOrderDetail['Code'];?> Details</span></div>
                            <div class="panel-body" >
                                <div class="clientDetail">
                                                                    
                                    <p>Order Date: <span><?php echo $codeOrderDetail['Order_Date'];?></span></p>
                                    <p>Flat No / Building No: <span><?php echo $codeOrderDetail['Flat'];?></span></p>
                                    <p>Street Name: <span><?php echo $codeOrderDetail['Street_Name'];?></span></p>
                                    <p>Area: <span><?php echo $codeOrderDetail['Area'];?></span></p>
                                    <p>Landmark: <span><?php echo $codeOrderDetail['Landmark'];?></span></p>
                                    <p>City: <span><?php echo $codeOrderDetail['City'];?></span></p>
                                    
                                </div>
                                <hr>
                                
                                <div class="clientacrion">
                                    <a class="inovice" href="#">Invoice</a>
                                    <a class='cancle' href="#">Cancle this order</a>
                                    <span>TOTAL</span>
                                    <p><?php echo $codeOrderDetail['Total_Price']; ?></p>
                                                        
                                    <?php 

                                        if($codeOrderDetail['Status'] == 'NotConfirmedYet'){

                                            echo "<span> Waiting For Resturant Confirme. <span> ";

                                        }else if($codeOrderDetail['Status'] != 'NotConfirmedYet' && $codeOrderDetail['Status'] != ''){

                                            echo  "<a class='inovice' href='#'> " . $codeOrderDetail['Status'] . " </a>";

                                        }
                                        
                                    ?>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

   
        <div class="footer"></div>
        
        <?php include $tpl . "footer.php";
        
        
    }else{
        header("Location: signin.php");
        exit();
    }


?>