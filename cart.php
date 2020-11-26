<?php 
        
    session_start();

    if(isset($_SESSION['Username'])){
        $page = '';
        include "init.php"; 
        
        $userID = $_SESSION['ID'];
        
        
        $code = isset ($_GET['code'] ) && is_numeric($_GET['code']) ? intval($_GET['code']):0;
        
        $Total_Price = 0;

        $ststm = $con->prepare("SELECT * FROM cart WHERE userID = ?");
        $ststm->execute(array($userID));
        $cartItems = $ststm->fetchAll();
?>

                
        <div class="fooddetailslidder">
            
        </div>

        <div class="fooddetail">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        
                        <?php if(isset($code) && $code > 0){ 
                            
                            $delete = $con->prepare("DELETE FROM cart");
                            $delete->execute();
                            
                            ?>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <span>Your ORDERES Delicious hot food!</span>
                                        <span class="pull-right">
                                            <i class="fa fa-plus"></i>
                                        </span>
                                    </div>
                                    <div class="panel-body">
                                        
                                       <?php 

                                            $statment = $con->prepare("SELECT * FROM orders WHERE Code = ?");
                                            $statment->execute(array($code));
                                            $fooditem = $statment->fetch();
                                            $explodeItems = explode(',' , $fooditem['order-items']);
                                                                                                                   
                                            foreach($explodeItems as $item){

                                                    $stmt = $con->prepare("SELECT * FROM items WHERE Name=?");
                                                    $stmt->execute(array($item));
                                                    $itemdetail = $stmt->fetch();

                                                    $statm = $con->prepare("INSERT INTO cart(itemID, userID) VALUES(:Zitemid, :Zuserid)");
                                                    $statm->execute(array(
                                                    
                                                        "Zitemid"   => $itemdetail['ItemID'],
                                                        "Zuserid"   => $userID
                                                            
                                                    
                                                    ));
                                                
                                                    $Total_Price += $itemdetail['Price'];
                                        ?>

                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <span><?php echo $itemdetail['Name'] ; ?></span>
                                            </div>
                                            <div class="panel-body displayflex">
                                                <div class="image">
                                                    <img class="img-responsive" src="<?php echo "admin/Upload/" . $itemdetail['image']  ; ?>">
                                                </div>
                                                <div class="content">
                                                    <h3 ><?php echo $itemdetail['Name'] ; ?></h3>
                                                    <p><?php echo $itemdetail['Description'] ; ?></p>
                                                </div>

                                            </div>

                                        </div>

                                        <?php } ?>


                                    </div>
                            </div>
                        
                        
                        <?php }else{?>
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

                                        $Total_Price += $fooditem['Price'] * $cartItem['number'];

                                    ?>

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <span><?php echo $fooditem['Name'] ; ?></span>
                                            
                                            <div class="pull-right">
                                                <a href="javascript:void(0)" style="color:black" onclick="deletOrder('<?php echo $cartItem['cartID']; ?>' , '<?php echo $userID;?>')" ><i class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                        <div class="panel-body displayflex">
                                            <div class="image">
                                                <img class="img-responsive" src="<?php echo "admin/Upload/" . $fooditem['image']  ; ?>">
                                            </div>
                                            <div class="content">
                                                <h3 ><?php echo $fooditem['Name'] ; ?></h3>
                                                <p><?php echo $fooditem['Description'] ; ?></p>
                                            </div>


                                            <div class="orderItemsNumber" data-cartid ="<?php echo $cartItem['cartID'];?>" style="overflow:hidden; margin:0">
                                                <p style="float:left"> Number <span class="counter"><?php echo $cartItem['number']; ?></span></p>
                                                <p style="float:right">
                                                    <span class="up"  style="display:inline-block;"><i style="width:20px; height:20px; text-align:center; border-radius:50%; line-height:20px" class="btn-success fa fa-plus"></i></span>
                                                    <span class="down" style="display:inline-block;"><i style="width:20px; height:20px; border-radius:50%; text-align:center; line-height:20px" class="btn-danger fa fa-minus"></i></span>
                                                </p>
                                            </div>
                                            
                                        </div>

                                    </div>

                                    <?php }  } ?>


                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    
                    
                    
                    
                    
                    <div class="col-sm-4">
                        <?php if(isset($code) && $code > 0){?>
                            <div class="panel panel-default">
                                <div class="panel-heading"><span class="total">Your Shopping Cart</span></div>
                                <div class="panel-body" >
                                    <?php $code = rand(0,1000000000); ?>
                                    <form class="form-horizontal" action="my-order.php?code=<?php echo $code;?>" method='post'>                         

                                        <input type="hidden"  name="code" value="<?php echo $code;?>">

                                        <div class="orderForm">
                                            <input type="text"  name="flat" autocomplete="off" placeholder="Flat or Building Number" value="<?php echo $fooditem['Flat'];?>" required>
                                            <input type="text"  name="street" autocomplete="off" placeholder="Street Name" value="<?php echo $fooditem['Street_Name'];?>" required>
                                            <input type="text"  name="area" autocomplete="off" placeholder="Area"  value="<?php echo $fooditem['Area'];?>" required>
                                            <input type="text"  name="landmark" autocomplete="off" placeholder="Landmark if any" value="<?php echo $fooditem['Landmark'];?>">
                                            <input type="text"  name="city" autocomplete="off" placeholder="City" value="<?php echo $fooditem['City'];?>" required> 
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
                        <?php }else{ ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading"><span class="total">Your Shopping Cart</span></div>
                                    <div class="panel-body" >
                                        <?php $code = rand(0,1000000000); ?>
                                        <form class="form-horizontal" action="my-order.php?code=<?php echo $code;?>" method='post'>                         

                                            <input type="hidden"  name="code" value="<?php echo $code;?>">

                                            <div class="orderForm">
                                                <input type="text"  name="flat" autocomplete="off" placeholder="Flat or Building Number" required>
                                                <input type="text"  name="street" autocomplete="off" placeholder="Street Name" required>
                                                <input type="text"  name="area" autocomplete="off" placeholder="Area"  required>
                                                <input type="text"  name="landmark" autocomplete="off" placeholder="Landmark if any">
                                                <input type="text"  name="city" autocomplete="off" placeholder="City" required> 
                                            </div>

                                            <hr>

                                            <div class="orderingCart">
                                                <p>TOTAL</p>
                                                <span class="totalPrice"><?php echo $Total_Price ; ?></span>
                                                <p>Free Shipping</p>
                                                <input type="<?php if(empty($cartItems)){echo "button";}else{echo "submit";}?>" class="ordernow" value="Place Order">

                                            </div>
                                        </form>

                                    </div>
                                </div>
                        
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer"></div>

        
        <?php include $tpl . "footer.php"; ?>
        <script>

   
            function deletOrder(id, userid){

                var s = window.confirm('Are You Sure?');

                if(s){
                        $.ajax({

                            url:"ajax-delete-order-cart.php",

                            type:"POST",

                            data:{cartID:id, UserID: userid},

                            success:function(data){

                                $("div.fooddetail").html(data);

                            }

                        });
                    }

                }



       </script>
        
        
   <?php  }else{
        header("Location: signin.php");
        exit();
    }


?>