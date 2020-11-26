<?php 

    session_start();
    $title = 'Login';
    if(isset($_SESSION['Username'])){
            header('Location:dashboard.php');  // Redirect To Dashboard Page
            exit();
    }

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
            header('Location:dashboard.php');
            exit();
        }

    }

?>

<form class="login" action="<?php echo  $_SERVER['PHP_SELF'] ?>" method="post">
    
    <h4 class="text-center">Admin Login</h4>

    <input type="text" class="form-control" name="username" placeholder="Username" autocomplete="off">
    <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="new-password">
    <input type="submit" value="Login" class="btn btn-success btn-block">

</form>

<?php 
    
    include 'includes/templates/footer.php';

?>