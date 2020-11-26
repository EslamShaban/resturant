<?php 

include "admin/connect.php";

$cartid = $_REQUEST['cartID'];
$userID = $_REQUEST['UserID'];

        
$Total_Price = 0;

$deleteCart = $con->prepare("DELETE FROM cart WHERE cartID = :Zcartid");
$deleteCart->bindParam("Zcartid", $cartid );
$deleteCart->execute();

$ststm = $con->prepare("SELECT * FROM cart WHERE userID = ?");
$ststm->execute(array($userID));
$cartItems = $ststm->fetchAll();

?>

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
                                    if(empty($cartItems)){ ?>


                                        <div class='nice-message'>Your Cart Is Empty</div>

                                   <?php  }else{
                                    foreach($cartItems as $cartItem){

                                        $statment = $con->prepare("SELECT * FROM items WHERE ItemID = ?");
                                        $statment->execute(array($cartItem['itemID']));
                                        $fooditem = $statment->fetch();

                                        $Total_Price += $fooditem['Price'];

                                    ?>

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <span><?php echo $fooditem['Name'] ; ?></span>
                                        </div>
                                        <div class="panel-body displayflex">
                                            <div class="image">
                                                <img class="img-responsive" src="<?php echo "admin/Upload/" . $fooditem['image']  ; ?>">
                                            </div>
                                            <div class="content">
                                                <h3 ><?php echo $fooditem['Name'] ; ?></h3>
                                                <p><?php echo $fooditem['Description'] ; ?></p>
                                            </div>
                                            <div class="pull-right">
                                                <a href="javascript:void(0)" style="color:black" onclick="deletOrder('<?php echo $cartItem['cartID']; ?>' , '<?php echo $userID;?>')"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                    <?php }  } ?>


                                </div>
                            </div>
                    </div>
                    
                    
                    
                    
                    
                    <div class="col-sm-4">
                        <div class="panel panel-default">
                            <div class="panel-heading"><span class="total">Your Shopping Cart</span></div>
                            <div class="panel-body" >
                                <?php $code = rand(0,1000000000); ?>
                                <form class="form-horizontal" action="my-order.php?code=<?php echo $code;?>" method='post'>                         
                                                                                    
                                    <input type="hidden"  name="code" value="<?php echo $code;?>">

                                    <div class="orderForm">
                                        <input type="text"  name="flat" autocomplete="off" placeholder="Flat or Building Number">
                                        <input type="text"  name="street" autocomplete="off" placeholder="Street Name">
                                        <input type="text"  name="area" autocomplete="off" placeholder="Area">
                                        <input type="text"  name="landmark" autocomplete="off" placeholder="Landmark if any">
                                        <input type="text"  name="city" autocomplete="off" placeholder="City"> 
                                    </div>
                                    
                                    <hr>
                                   
                                    <div class="orderingCart">
                                        <p>TOTAL</p>
                                        <span><?php echo $Total_Price ; ?></span>
                                        <p>Free Shipping</p>
                                        <input type="<?php if(empty($cartItems)){echo "button";}else{echo "submit";}?>" class="ordernow" value="Place Order">

                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>