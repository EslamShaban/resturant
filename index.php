<?php 
    session_start();
    if(isset($_SESSION['Username'])){
        $page = '';
        include "init.php"; 
        
        $success = 0;
        $uid = $_SESSION['ID'];

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                
                if(isset($_SESSION['submit']) && $_SESSION['submit'] == $_POST['submit']){

                    unset($_SESSION['submit']);

                    header("location: index.php");
                    exit;
        
                }
                $_SESSION['submit'] = $_POST['submit'];

                $username   = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
                $email      = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $cellphone  = filter_var($_POST['cellphone'], FILTER_SANITIZE_STRING);
                $message    = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

                if(isset($username)){

                    if(empty($username)){
                        $wrongusername = "<div style='margin-top:5px' class='alert alert-danger'>Username Can't Be Empty.</div>";
                    }else if(strlen($username) < 4 ){
                                         
                        $wrongusername = "<div style='margin-top:5px' class='alert alert-danger'>Username Must Be Larger Than 4 Characters.</div>";
                    }else{
                        $success++;
                    }
                }
                if(isset($email)){
                                   
                    if(empty($email)){
                        $wrongemail = "<div style='margin-top:5px' class='alert alert-danger'>Email Can't Be Empty.</div>";
                    }else if(filter_var($email, FILTER_VALIDATE_EMAIL) !=true){
                              
                        $wrongemail = "<div style='margin-top:5px' class='alert alert-danger'>Email Is Not Valid</div>";
                          
                    }else{
                        $success++;
                    }
                }
                if(isset($cellphone)){
                    if(empty($cellphone)){
                        $wrongmobile = "<div style='margin-top:5px' class='alert alert-danger'>Cell Phone Can't Be Empty.</div>";
                    }else if(strlen($cellphone) < 11 ){
                        $wrongmobile ="<div style='margin-top:5px' class='alert alert-danger'>Wrong Mobile Number.</div>";;
                    }else{
                        $success++;
                    }
                }

                if(isset($message)){
                    if(empty($message)){
                        $wrongmessage = "<div style='margin-top:5px' class='alert alert-danger'>Message Can't Be Empty.</div>";
                    }else{
                        $success++;
                    }
                }

                if(isset($success) && $success == 4){
                    
                    $insert = $con->prepare("INSERT INTO 
                                                  contactus(Username, email, mobile, message, UserID) 
                                            VALUES(:zuser, :zemail, :zmobile, :zmessage, :zUserID)");
                    $insert->execute(array(

                        "zuser"             => $username,
                        "zemail"            => $email,
                        "zmobile"           => $cellphone,
                        "zmessage"          => $message,
                        "zUserID"           => $uid

                    ));
                if($insert){
                    $pass =  "<div class='success alert alert-success'>Your feedback has send successfully</div>";
                }

                }
        }
       
        $page = (isset($_GET['page'])) ? $_GET['page'] : '1';
        $category = (isset($_GET['category'])) ? $_GET['category'] : '';
        $mealname = (isset($_GET['mealname'])) ? $_GET['mealname'] : '';
        
        $query  = "";
        $query2 = "";
        
        if(!empty($category)){
            $query = "WHERE CatID = '$category'";
        }        
        
        if(!empty($mealname)){
            if(empty($category)){
                $query2 = "WHERE Name LIKE '$mealname%'";
            }else{
                $query2 = " AND Name LIKE '$mealname%'";
            }
            
        }

        $num_per_page = 9;
        $from = ($page-1)*$num_per_page;

        $items = $con->prepare("SELECT * from items $query $query2 LIMIT $from,$num_per_page");
        $items->execute();
        $meals = $items->fetchAll();        
        
        $categorie = $con->prepare("SELECT * from categories");
        $categorie->execute();
        $categories = $categorie->fetchAll();

?>

        <div class="slidder">

            <div class="overlay">
                <div class="container">
                    <div class="slidderContent">
                        <h1 class="text-center">ORdeR Delivery</h1>
                        <p class="text-center">Find your favourite delicious hot food!</p>
                        <div class="mealform">
                            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'];?>#Food">
                                <div class="form-group form-group-lg">  
                                    <div class="col-xs-6  col-xs-offset-3 col-md-4 col-md-offset-4 sear">                                    
                                        <input type="search" class="form-control" name="mealname" placeholder="I would like to eat....">
                                    </div>
                                                                    
                                    <div class="subm col-xs-2  col-md-4 ">    
                                        <input type="submit" value="Search food">
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <di class="slidderIcon">
                        <i class="fa fa-house"></i>
                        <i class="fa fa"></i>
                        <i class="fa fa"></i>
                    </di>
                </div>
            </div>
        </div>
        <div class="food" id="Food">
            <div class="container">
            
                <div class="row">
                    
                    <div class="col-sm-3 hidden-xs">
                        <div class="categories">
                            <ul>
                                    
                                <li class="first">Food Categories <i style="float:right" class="fa fa-cutlery fa-lg"></i></li>
                                
                                <?php foreach($categories as $cat) {?>

                                    <a class="colored" href="?category=<?php echo $cat['CatID'];?>#Food"><li><?php echo $cat['Name'];?></li></a>
                            
                                <?php } ?>

                            </ul>
                        </div>
                    </div>
                    
                    <div class="col-sm-9">
                                            
                    
                        <?php 


                        foreach($meals as $meal){ 

                        ?>

                                <div class="col-xs-6 col-md-4">
                                    <div class="foodItem">
                                        <div class="image">
                                            <img src="<?php echo "admin/Upload/" . $meal['image']; ?>">
                                        </div>
                                        <div class="data">                     
                                            <a href="food_detail.php?mealid=<?php echo $meal['ItemID'];?>"><?php echo $meal['Name'];?></a>
                                            <p><?php echo $meal['Description'];?></p>
                                            <div class="orderItemsNumber <?php echo $meal['ItemID'];?>" style="overflow:hidden; margin:0">
                                                <p style="float:left"> Number <span class="counter">1</span></p>
                                                <p style="float:right">
                                                    <span class="up" style="display:inline-block;"><i style="width:20px; height:20px; text-align:center; border-radius:50%; line-height:20px" class="btn-success fa fa-plus"></i></span>
                                                    <span class="down"><i style="width:20px; height:20px; border-radius:50%; text-align:center; line-height:20px" class="btn-danger fa fa-minus"></i></span>
                                                </p>
                                            </div>
                                            <span class="price"><?php echo "RS." . $meal['Price'];?></span>
                                            <a href="javascript:void(0)" class="order pull-right" id = "<?php echo $meal['ItemID'];?>" onclick="say('<?php echo $meal['ItemID'];?>', '<?php echo $uid;?>')">Order Now</a>

                                        </div>

                                    </div>
                                </div>




                        <?php } ?>
                    </div>
                                                         
                </div>
                
            </div>
        </div>

        <p class='or'></p>

 <?php 
        $stmt = $con->prepare("SELECT * from items $query");
        $stmt->execute();
        $numOfItems = $stmt->rowCount();

        if($numOfItems > $num_per_page){

    ?>

             <nav aria-label="Page navigation" class="nav-center nav-pagination">
              <ul class="pagination">
                <li>
                  <a href="?page=<?php if(($page-1)  > 0) echo $page-1; else  echo '1';?>#Food" aria-label="Previous">
                    <span aria-hidden="true">Previous</span>
                  </a>
                </li>
                  <?php
                  $totalpage = ceil($numOfItems/$num_per_page);
                  for($i=1; $i<=$totalpage ; $i++){?>
                        <li class="numpagination"><a class="<?php echo $page == $i ? 'select' : '' ; ?>" href="?page=<?php echo $i;?>#Food"><?php echo $i;?></a></li>
                  <?php } ?>
                <li>
                  <a href="?page=<?php if(($page+1) < $totalpage) echo $page+1; else echo $totalpage;?>#Food" aria-label="Next">
                    <span aria-hidden="true">Next</span>
                  </a>
                </li>
              </ul>
            </nav>

<?php } ?>


        
        <!--Start Section Contact Us-->
        
        <div class="Contact-Us text-center" id="contact">
        
            <div class="fields">
                <?php if(isset($pass) && !empty(($pass))){ echo $pass;} ?>
                <div class="container">
                    <div class="row">
                    
                        <i class="fa fa-headphones fa-5x"></i>
                        <h1>Tell Us What You Feel</h1>
                        <p class="lead">Feel Free To Contact Us Anytime</p>
                        
                        <!-- Start Contact Form -->
                        
                        <form role="form" action="<?php echo $_SERVER['PHP_SELF'];?>#contact" method="POST">
                        
                            <div class="col-lg-6">
                            
                                <div class="form-group">
                                
                                    <input type="text" name = 'username' pattern=".{4,}" title="Username Must Be 4 Chars" class="form-control input-lg" placeholder="Username" value="<?php echo (isset($_POST['username']) && (!empty($wrongusername)  || !empty($wrongemail) || !empty($wrongmobile) || !empty($wrongmessage))) ?$_POST['username']  : '' ?>" required="required">
                                    <?php if(isset($wrongusername) && !empty($wrongusername)) echo $wrongusername; ?>
                                </div>                                
                                <div class="form-group">
                                
                                    <input type="email" name='email' class="form-control input-lg" placeholder="Email" value="<?php echo (isset($_POST['email']) && (!empty($wrongusername)  || !empty($wrongemail) || !empty($wrongmobile) || !empty($wrongmessage))) ?$_POST['email']  : '' ?>" required="required">
                                    <?php if(isset($wrongemail) && !empty($wrongemail)) echo $wrongemail; ?>
                                </div>                                
                                <div class="form-group">
                                
                                    <input type="text" name = 'cellphone' minlength="11"  class="form-control input-lg" placeholder="Cell Phone" value="<?php echo (isset($_POST['cellphone']) && (!empty($wrongusername)  || !empty($wrongemail) || !empty($wrongmobile) || !empty($wrongmessage))) ?$_POST['cellphone']  : '' ?>" required="required">
                                    <?php if(isset($wrongmobile) && !empty($wrongmobile)) echo $wrongmobile; ?>
                                </div>
                                
                            </div>                            
                            <div class="col-lg-6">
                                <div class="form-group">
                                
                                    <textarea name='message' class="form-control input-lg" placeholder="Your Message" required="required"><?php echo (isset($_POST['message']) && (!empty($wrongusername)  || !empty($wrongemail) || !empty($wrongmobile) || !empty($wrongmessage))) ?$_POST['message']  : '' ?></textarea>
                                    <?php if(isset($wrongmessage) && !empty($wrongmessage)) echo $wrongmessage; ?>
                                </div> 
                                <input type="submit" name ="submit" class="submit-btn btn btn-lg btn-block" value="Contact Us">
                            </div>
                        
                        </form>
                        
                        <!-- End Contact Form -->
                    
                   </div>
                </div>
            </div>
            
                  
        </div>
        
        <!--End Section Contact Us-->

        <div class="footer">
            <div class="copyright text-center">
                
                Copyright &copy; 2019 <span>ORdeR Delivery</span>
                    
            </div>   
        </div>


<?php }else{
        
        header('Location:signin.php');  // Redirect To Login Page
            
        exit();
    }

?>



<?php

include $tpl . "footer.php";
?>


<script>
    
    
    
    function say(itemid, uid){

        var num = Number( $('.' + itemid).find('.counter').html());

        alert('Your order has been added to your cart.');
                    
        $.ajax({
           url:"ajax_cart.php",
            type:"GET",
            data:{itemID:itemid, userID:uid, number:num},
            success:function(data){
                $("#"+itemid).html(data);
            }
        });
    }


</script>