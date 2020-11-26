<?php 
    session_start();
    if(isset($_SESSION['Username'])){
            header('Location:index.php');  // Redirect To index Page
            exit();
    }

    $page = 'signup';
    include 'init.php';



    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $username       = $_POST['username'];
        $fullname       = $_POST['fullname'];
        $Email          = $_POST['email'];
        $Mobile_Number  = $_POST['mobilenumber'];
        $password       = $_POST['password'];
        $password2      = $_POST['password2'];
        
        $formErrors = array();
        
        if(isset($username)){
                 
            $filterUser = filter_var($username, FILTER_SANITIZE_STRING);  
            if(strlen($filterUser) < 4 ){
                $formErrors[] = 'Username Must Be Larger Than 4 Characters';
            }
        }        
        if(isset($fullname)){
                 
            $filterfullname = filter_var($fullname, FILTER_SANITIZE_STRING);  
            if(strlen($filterfullname) < 4 ){
                $formErrors[] = 'Fullname Must Be Larger Than 4 Characters';
            }
        }        
        if(isset($Mobile_Number)){
                 
            $filtermobile = filter_var($Mobile_Number, FILTER_SANITIZE_STRING);  
            if(strlen($filtermobile) < 11 ){
                $formErrors[] = 'Wrong Mobile Number';
            }
        }
        
        if(isset($password) && isset($password2)){
            if(empty($password)){
                $formErrors[] = "Sorry, Password Can't Be Empty";
            }
            if(SHA1($password) !== SHA1($password2)){
                $formErrors[] = 'Sorry, Password Is Not Match';
            }
        }
        if(isset($Email)){
                              
            $filterEmail = filter_var($Email, FILTER_SANITIZE_EMAIL);
                  
            if(filter_var($filterEmail, FILTER_VALIDATE_EMAIL) !=true){
                  	
                $formErrors[] = 'Email Is Not Valid';
                  
            }
        }
        
        if(empty($formErrors)){
            
            $stmt = $con->prepare("SELECT * FROM users WHERE Username = ?");
            $stmt->execute(array($username));
            $user = $stmt->fetch();
            
            if(empty($user)){

                    $insert = $con->prepare("INSERT INTO 
                                                  users(Username, Password, Email, FullName, Date, Mobile_Number) 
                                            VALUES(:zuser, :zpass, :zemail, :zfullname, now(), :ZMobile_Number)");
                    $insert->execute(array(

                        "zuser"          => $username,
                        "zpass"          => SHA1($password),
                        "zemail"         => $Email,
                        "zfullname"      => $fullname,
                        "ZMobile_Number" => $Mobile_Number

                    ));
                if($insert){
                    $success = "<div class='alert alert-success'>You have successfully registered.</div>";
                }
                
            }else{
                $formErrors[] = 'This User Is Exist';
            }
            
        }
    
    }

?>

<div class="container">
    <div class="signuppage">
        <div class="row">
            <div class="col-sm-7">	
                <div class="formsignup">
                    
                    <?php 
                        
                        if(isset($success)) echo $success;
                    ?>
                    
                    <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                        <div class="col-sm-6">
                            <label class="col-sm-12">Username</label>
                            <input type="text" pattern=".{4,}" title="Username Must Be 4 Chars" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>" autocomplete="off" class="form-control" placeholder="Username" required="required"> 

                            <label class="col-sm-12">Email Address</label>
                            <input type="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>" class="form-control" placeholder="Email" required="required">                        

                            <label class="col-sm-12">Password</label>
                            <input type="password" name="password" class="form-control" minlength="4"  autocomplete="new-password" placeholder="Password" required="required">
                        </div>
                        <div class="col-sm-6">
                            <label class="col-sm-12">Full Name</label>
                            <input type="text" name="fullname" value="<?php echo isset($_POST['fullname']) ? $_POST['fullname'] : '' ?>" class="form-control" pattern=".{4,}" title="Full Name Must Be 4 Chars" placeholder="Username" required="required"> 

                            <label class="col-sm-12">Mobile Number</label>
                            <input type="text" name="mobilenumber" value="<?php echo isset($_POST['mobilenumber']) ? $_POST['mobilenumber'] : '' ?>" class="form-control" minlength="11" placeholder="Mobile Number" required="required">                        

                            <label class="col-sm-12">Repeat Password</label>
                            <input type="password" name="password2" class="form-control" minlength="4"  autocomplete="new-password" placeholder="Repeat Password" required="required">
                        </div>
                        
                        <div class="col-xs-6">
                            <input type="submit" value="Register">
                        </div>                        
                        <div class="col-xs-6">
                            <a class='login' href="signin.php">Login</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="registerimage">
                    <h3>Registration is fast, easy, and free.</h3>
                    <img style="width:100%" src="layout/images/junk.jpg">
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

    
<?php include $tpl . "footer.php" ?>