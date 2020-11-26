<?php 
        
    session_start();

    if(isset($_SESSION['Username'])){
        $page = '';
        include "init.php"; 
        
        $mealID = isset($_GET['mealid']) && is_numeric($_GET['mealid']) ? intval($_GET['mealid']):0;
        
        $stmt = $con->prepare("SELECT * FROM items WHERE ItemID=?");
        $stmt->execute(array($mealID));
        $foodMeal = $stmt->fetch();

?>

                
        <div class="fooddetailslidder">
            
        </div>

        <div class="fooddetail">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <span><?php echo $foodMeal['Name'] ; ?></span>
                                <span class="pull-right">
                                    <i class="fa fa-plus"></i>
                                </span>
                            </div>
                            <div class="panel-body displayflex">
                                <div class="image">
                                    <img class="img-responsive" src="<?php echo "admin/Upload/" . $foodMeal['image']  ; ?>">
                                </div>
                                <div class="content">
                                    <h3 ><?php echo $foodMeal['Name'] ; ?></h3>
                                    <p><?php echo $foodMeal['Description'] ; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="panel panel-default">
                            <div class="panel-heading"><span class="total">Total</span></div>
                            <div class="panel-body">
                                <div class="orderingCart">
                                    <span><?php echo "RS." . $foodMeal['Price'] ; ?></span>
                                    <p>Free Shipping</p>
                                    <a class="order pull-right" href="#">Order Now</a>
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