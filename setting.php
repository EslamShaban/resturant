<?php

    session_start();
    if(isset($_SESSION['Username'])){
        $page = '';
        include "init.php"; 
        
        $uid = $_SESSION['ID'];
        
        $selectpass = $con->prepare("SELECT Password FROM users WHERE UserID=?");
        $selectpass->execute(array($uid));
        $passOfUser = $selectpass->fetch();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $Current    = $_POST['current'];
            $New        = $_POST['new'];
            $Confirm    = $_POST['confirm'];
            $hashedpass = SHA1($New);
            
            if(SHA1($Current) != $passOfUser['Password']){
                $currentError = "<div class='alert alert-danger'>Wrong Password</div>";
            }
            
            if(empty($currentError)){
                                    
                if(isset($New) && isset($Confirm)){
                    if(empty($New)){
                        $NewError = "<div class='alert alert-danger'>Sorry, Password Can't Be Empty</div>";
                    }
                    if(empty($NewError)){
                                            
                        if(SHA1($New) !== SHA1($Confirm)){
                        
                            $ConfirmError = "<div class='alert alert-danger'>Sorry, Password Is Not Match</div>";
                    
                        }
                    }

                }
            }
            
            if(empty($currentError) && empty($NewError) && empty($ConfirmError)){
                                           
                $statm = $con->prepare("UPDATE users set  Password = ? WHERE UserID = ?");
                $statm->execute(array($hashedpass, $uid));
                $success =  "<div class='alert alert-success'>Your password has been Updated</div>";
            }
        }
        
        
        ?>

        <div class="container">
            <div class="setting">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="formforpassword">
                            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                                <?php if(isset($success) && !empty($success)) echo $success; ?>
                                <div class="form-group form-group-lg">
                                    <div class="col-sm-12">                               
                                        <label class="control-label">Current Password</label>
                                    </div>
                                    <div class="col-sm-6">                                  
                                        <input type="password" class="form-control" name="current" autocomplete="off" required>
                                    </div>
                                </div> 
                                <?php if(isset($currentError) && !empty($currentError)) echo $currentError; ?>
                                <div class="form-group form-group-lg">
                                    <div class="col-sm-12">                               
                                        <label class="control-label">New Password</label>
                                    </div>
                                    <div class="col-sm-6">                                  
                                        <input type="password" class="form-control" name="new" autocomplete="off" required>
                                    </div>
                                </div>       
                                <?php if(isset($NewError) && !empty($NewError)) echo $NewError; ?>

                                <div class="form-group form-group-lg">
                                    <div class="col-sm-12">                               
                                        <label class="control-label">Confirm Password</label>
                                    </div>
                                    <div class="col-sm-6">                                  
                                        <input type="password" class="form-control" name="confirm" autocomplete="off" required>
                                    </div>
                                </div>  
                                <?php if(isset($ConfirmError) && !empty($ConfirmError)) echo $ConfirmError; ?>

                                
                                <div class="col-sm-6">
                                    <input type="submit" value="change">
                                </div>
                           
                            </form>
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
