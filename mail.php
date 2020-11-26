<?php 


    $page = 'signup';

    include 'init.php';

    $code =  $_GET['code'];


    $selectstatm = $con->prepare("SELECT * FROM resetpassword WHERE Code = ? ");
    $selectstatm->execute(array($code));
    $fetchemail = $selectstatm->fetch();
    $count = $selectstatm->rowCount();


    if($count > 0){
        
         if($fetchemail['Status'] == '1'){
             
                    $used = "<div style='margin:150px 0 0 40px'>This password recovery link has been already used</div>";
                    
         }else if($fetchemail['Status'] == '0'){
            
                if($_SERVER['REQUEST_METHOD'] == 'POST'){  

                    $password1=$_POST['password'];
                    $password2=$_POST['confirmpassword'];

                    $hasedpass = sha1($_POST['password']);


                        if(isset($password1) && isset($password2)){
                            if(empty($password1)){
                                $empty1 = "<div style='color:red; margin-bottom:10px'>Sorry, Password Can't Be Empty</div>";
                            }
                            if(sha1($password1) !== sha1($password2)){
                                $notMatch = "<div style='color:red; margin-bottom:10px'>Sorry, Password Is Not Match</div>";
                            }
                    }

                    if(empty($empty1) && empty($notMatch)){


                                $statm = $con->prepare("UPDATE users set  Password = ? WHERE Email = ? ");
                                $statm->execute(array($hasedpass, $fetchemail['Email']));
                                echo "<div class='alert alert-success'>". $statm->rowCount() ." Record Update</div>";

                               if($statm){
                                    $statm = $con->prepare("UPDATE resetpassword set  Status =1 WHERE Email = ? ");
                                    $statm->execute(array($fetchemail['Email']));

                                    header("Location:index.php");
                                    exit();
                               }




                }

            }
         
         }
        
    }else{
        
         $error = "<div style='color:#F00; margin:150px 0 0 40px'>This password recovery link was not found</div>";
    }


?>


<div class="container">
    <div class="signinpage">
        <div class="row">
            <div class="col-sm-8">
                <?php if (isset($used) || isset($error)){ 
                    
                    if(isset($used) && !empty($used)) echo $used;
                    if(isset($error) && !empty($error)) echo $error;
                
                ?>
                
                        
                
                <?php }else {  ?>
                
                    <div class="formsignin">

                        <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] . "?code=" . $code; ?>" method="POST">

                            <div class="col-sm-8">
                                <label class="col-sm-12">New Password</label>
                                <input type="password" name="password" class="form-control" minlength="5"  autocomplete="new-password" placeholder="Password" >  
                                <?php if(isset($empty1)) echo $empty1; ?>
                                <label class="col-sm-12">Confirm New Password</label>
                                <input type="password" name="confirmpassword" class="form-control" minlength="5"  autocomplete="new-password" placeholder="Password" >
                                <?php if(isset($notMatch)) echo $notMatch; ?>
                            </div>                       


                            <div class="col-sm-offset-3 col-sm-6">
                                <input type="submit" value="Change">
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
</div>


<?php include $tpl . "footer.php"; ?>