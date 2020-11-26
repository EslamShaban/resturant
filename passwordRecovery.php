<?php 

    session_start();
    if(isset($_SESSION['Username'])){
            header('Location:index.php');  // Redirect To index Page
            exit();
    }
    
    $page = 'signup';

    include 'init.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $email = $_POST['email'];
        
        if(empty($email)){
            $email = "<div style='color:red; margin-bottom:10px'>Field should not be empty</div>";
        }else{
        
            $stmt = $con->prepare("SELECT * FROM users WHERE Email=?");
            $stmt->execute(array($email));
            $fetch = $stmt->fetch();
            $count = $stmt->rowCount();

            if($count > 0){
                $toemail = $fetch['Email'];
                $code = rand(0 ,1000000000);
                $to      = $toemail;
                $subject = 'the subject';
                $message = "Hello,  To change the password click http://localhost/resturant/mail.php?code=$code";
                $headers = 'From: eshaban242@gmail.com' ;

                mail($to, $subject, $message, $headers);

                $success = "<div style='color:#080; margin:150px 0 0 40px'>Password recovery letter has been sent successfully</div>";
        
                
                $insert = $con->prepare("INSERT INTO `resetpassword` (`Code`, `Email`) VALUES (:Zcode, :Zemail)");
                $insert->execute(array(
                    
                    "Zcode"    => $code,
                    "Zemail"   => $toemail
                        
                ));
            
            }else{
                $emailnotfound = "<div style='color:red; margin-bottom:10px'>This email is not exist.</div>";
            }

    }
   
        

    }

?>


<div class="container">
    <div class="signinpage">
        <div class="row">
            <div class="col-sm-8">
                <?php if(isset($success)){ echo $success; }else {?>
                <div class="formsignin">
                    
                    <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                        
                        <div class="col-sm-8">
                            <label class="col-sm-12">Email</label>
                            <input type="email" name="email" autocomplete="off" class="form-control" placeholder="email" >   
                            <?php 
                                if(isset($email)) echo $email; 
                                if(isset($emailnotfound)) echo $emailnotfound;
                            ?>
                        </div>                       
  
                        
                        <div class="col-sm-6">
                            <input type="submit" value="Recover">
                        </div>                        
                        
                    </form>
                </div>
            <?php } ?>
            </div>
            <div class="col-sm-4">
                <div class="registerimage">
                    <h3>Registration is fast, easy, and free.</h3>
                    <img style="width:100%" src="layout/images/signinimage.jpg">
                    <h4>Contact Customer Support</h4>
                    <p>if you're looking for more help or have a question to ask, please</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6">
    
        <?php 

                 if(! empty($formErrors)){
                    foreach ($formErrors as $error) {
                        echo "<div class='alert alert-danger'>" . $error . "</div>";
                    }
                 }
        ?>
        
    </div>
</div>


<?php include $tpl . "footer.php"; ?>