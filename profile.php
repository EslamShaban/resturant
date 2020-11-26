
<?php

    session_start();
    if(isset($_SESSION['Username'])){
        
        $page = '';
        
        include "init.php"; 
        
        $uid = $_SESSION['ID'];
                
        $User = $con->prepare("SELECT * FROM users WHERE UserID=?");
        $User->execute(array($uid));
        $userInfo = $User->fetch();
        
        
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $username       = $_POST['username'];
                $fullname       = $_POST['fullname'];

                $formErrors = array();

                if(isset($username)){

                    $filterUser = filter_var($username, FILTER_SANITIZE_STRING);  
                    if(strlen($filterUser) < 4 ){
                        $formErrors['username'] = "<div class='alert alert-danger'>Username Must Be Larger Than 4 Characters'</div>";;
                    }
                }        
                if(isset($fullname)){

                    $filterfullname = filter_var($fullname, FILTER_SANITIZE_STRING);  
                    if(strlen($filterfullname) < 4 ){
                        $formErrors['fullname'] = "<div class='alert alert-danger'>Fullname Must Be Larger Than 4 Characters</div>";
                    }
                }
                        
                if(empty($formErrors)){
            
                    $stmt = $con->prepare("SELECT * FROM users WHERE Username = ?");
                    $stmt->execute(array($username));
                    $user = $stmt->fetch();
                    $userDate = $userInfo['Date'];
                    
                    if(empty($user)){

                        $statm = $con->prepare("UPDATE users set  Username = ? , FullName = ? , Date = ? WHERE UserID = ?");
                        $statm->execute(array($username, $fullname, $userDate, $uid));
                        $success =  "<div class='alert alert-success'>Your Profile has been Updated</div>";
                        
                        $User = $con->prepare("SELECT * FROM users WHERE UserID=?");
                        $User->execute(array($uid));
                        $userInfo = $User->fetch();

                    }else{
                        $formErrors['exist'] = "<div class='alert alert-danger'>This User Is Exist</div>";
                    }
            
        }
            
    }
        
?>
<div class="container">
    <div class="signuppage">
        <div class="row">
            <div class="col-sm-8">	
                <div class="formsignup">
                                                
                    <?php if(isset($formErrors['exist']) && !empty($formErrors['exist'])) echo $formErrors['exist'] ; ?>
                    <?php if(isset($success) && !empty($success)) echo $success ; ?>

                    
                    <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                        <div class="col-sm-6">
                            <label class="col-sm-12">Username</label>
                            <input type="text" name="username" autocomplete="off" class="form-control" value="<?php echo $userInfo['Username']; ?>">
                            <?php if(isset($formErrors['username']) && !empty($formErrors['username'])) echo $formErrors['username'] ; ?>
                            <label class="col-sm-12">Email Address</label>
                            <input class="form-control" value="<?php echo $userInfo['Email'] ?>" readonly>                        

                            <label class="col-sm-12">Registeration Date</label>
                            <input class="form-control" value="<?php  echo $userInfo['Date']; ?>" readonly>
                        
                        </div>
                        <div class="col-sm-6">
                            <label class="col-sm-12">Full Name</label>
                            <input type="text" name="fullname" class="form-control" pattern=".{4,}" title="Full Name Must Be 4 Chars" value="<?php echo $userInfo['FullName']; ?>"> 
                            <?php if(isset($formErrors['fullname']) && !empty($formErrors['fullname'])) echo $formErrors['fullname'] ; ?>

                            <label class="col-sm-12">Mobile Number</label>
                            <input class="form-control" value="<?php echo $userInfo['Mobile_Number'];?>" readonly>                        

                        </div>
                        
                        <div class="col-sm-6">
                            <input type="submit" value="Update">
                        </div>                        
                    </form>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="registerimage">
                    <h3 style="color:#888; font-size:25px">Update Profile</h3>
                    <img style="width:100%" src="layout/images/signinimage.jpg">
                    <h4>Contact Customer Support</h4>
                    <p>if you're looking for more help or have a question to ask, please</p>
                </div>
            </div>
        </div>
    </div>

</div>

        
        
<div class="footer"></div>



       
<?php }else{

                header('Location:signin.php');  // Redirect To Login Page

                exit();
            }

        
?>



        
<?php

        include $tpl . "footer.php";
        
?>
