<?php 

    session_start();
    if(isset($_SESSION['Username'])){
            header('Location:index.php');  // Redirect To index Page
            exit();
    }
    
    $page = 'signup';

    include 'init.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashedPass = SHA1($password);
        
        if(empty($username)){
            $name = "<div style='color:red; margin-bottom:10px'>Username can't be empty.</div>";
        }     
        if(empty($password)){
            $pass = "<div style='color:red; margin-bottom:10px'>Password can't be empty.</div>";
        }
             // Check If The User Exist In Database
            if(! empty($username) && ! empty($password)){

                $stmt = $con->prepare("SELECT UserID, Username, Password FROM users Where Username = ? And Password=? LIMIT 1");
                $stmt->execute(array($username,$hashedPass ));
                $row = $stmt->fetch();
                $count = $stmt->rowCount();

            if($count > 0){
                $_SESSION['Username']=$username;
                $_SESSION['ID']=$row['UserID'];
                header('Location:index.php');
                exit();
            }else{
                $error = "<div style='color:red; margin-bottom:10px'>Invalid Usernme or Password</div>";
            }
            
        }

    }

?>


<div class="container">
    <div class="signinpage">
        <div class="row">
            <div class="col-sm-7">	
                <div class="formsignin">
                    
                    <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                        
                        <div class="col-sm-8">
                            <label class="col-sm-12">Username</label>
                            <input type="text" pattern=".{4,}" title="Username Must Be 4 Chars" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>" autocomplete="off" class="form-control" placeholder="Username" required="required"> 
                            <?php if(isset($name)) echo $name; ?>
                            <label class="col-sm-12">Password</label>
                            <input type="password" name="password" class="form-control" minlength="4"  autocomplete="new-password" placeholder="Password" required="required">  
                            
                            <?php 
                            
                                if(isset($pass)) echo $pass;
                                if(isset($error)) echo $error;
                            
                            ?>
                        </div>                       
  
                        
                        <div class="col-xs-6">
                            <input type="submit" value="Login">
                        </div>                        
                        <div class="col-xs-6">
                            <a class='login' href="signup.php">Register</a>
                        </div>
                        
                        <div class="col-xs-12" style="margin-bottom:20px">
                            <a href="passwordRecovery.php">Forget Your Password?</a>
                        </div>
                        
                    </form>
                </div>
            </div>
            <div class="col-sm-5">
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