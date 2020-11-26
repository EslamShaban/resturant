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
        $hashedPass = sha1($password);
        
         // Check If The User Exist In Database
        
        $stmt = $con->prepare("SELECT UserID, Username, Password FROM users Where Username = ? And Password=? And GroupID=1 LIMIT 1");
        $stmt->execute(array($username,$hashedPass ));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        echo $count;
        if($count > 0){
            $_SESSION['Username']=$username;
            $_SESSION['ID']=$row['UserID'];
            header('Location:index.php');
            exit();
        }

    }

?>

<div class="container">
    <div class="formlogin">
                <form class="login" action="<?php echo  $_SERVER['PHP_SELF'] ?>" method="post">

                    <div class="formlogindisplayflex">
                        <div class="head">
                            <h3 class="text-center" style="color:#666"> Food Ordering System | User Login </h3>
                        </div>
                        <div class="form-group form-group-lg" style="background-color:#FFF; padding:40px 20px">
                            <input type="text" class="form-control" name="username" placeholder="Username" autocomplete="off">
                            <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="new-password">
                            <input type="submit" value="Login" class="btn btn-success btn-block">
                        </div>
                    </div>

                </form>

    </div>
</div>

<?php 
    
    include $tpl . 'footer.php';

?>