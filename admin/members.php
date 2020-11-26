<?php 
    session_start();
    if(isset($_SESSION['Username'])){
        
    include "init.php";
?>


    <?php include $tpl . "sidebar.php";?> 
    
    <div class="content">
        <div class="container-fluid">
            
           <?php 

                $do = (isset($_GET['do']))?$_GET['do']:'Manage';

                if($do == 'Manage'){
                    $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1");
                    $stmt->execute();
                    $users = $stmt->fetchAll();

                    if(! empty($users)){

            ?>

                <h3 class="text-center">User Details</h3>



                        <div class="table-responsive">

                            <table class="main-table table table-bordered text-center">

                                <tr>
                                    <td>#ID</td>
                                    <td>Username</td>
                                    <td>Email</td>
                                    <td>Full Name</td>
                                    <td>Registerd Date</td>
                                    <td>Control</td>
                                </tr>

                                <?php 

                                    foreach($users as $user){?>
                                        <tr>
                                            <td><?php echo $user["UserID"];?></td>
                                            <td><?php echo $user["Username"];?></td>
                                            <td><?php echo $user["Email"];?></td>
                                            <td><?php echo $user["FullName"];?></td>
                                            <td><?php echo $user["Date"];?></td>
                                            <td>
                                                <a href="?do=Edit&userid=<?php echo $user["UserID"];?>" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                                <a href="?do=Delete&userid=<?php echo $user["UserID"];?>" class="btn btn-danger"><i class="fa fa-close"></i> Delete</a>
                                            </td>
                                        </tr>
                                    <?php }

                                ?>



                            </table>
                        </div>

            <?php 
                    }else{

                        echo "<div class='nice-message'>There's No Users To Show</div>";
                        echo "<a href='?do=Add' class='btn btn-primary'><i class='fa fa-plus'></i> New User</a>";
                    }

                }else if($do == 'Edit'){

                    $userid = isset ($_GET['userid'] ) && is_numeric($_GET['userid']) ? intval($_GET['userid']):0;

                    $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ?");
                    $stmt->execute(array($userid));
                    $user = $stmt->fetch();

            ?>

                    <h1 class="text-center">Edit User</h1>
                    <form class="form-horizontal" action="?do=Update" method="post">

                        <input type="hidden"  name="userid" value="<?php echo $userid;?>">

                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="username" value="<?php echo $user['Username'];?>" autocomplete="off">
                            </div>
                        </div>                    
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10">
                                <input type="hidden" class="form-control" name="oldpassword" autocomplete="off" value="<?php echo $user['Password'];?>">
                                <input type="password" class="form-control" name="newpassword" autocomplete="off" placeholder="Leave Blank If You Don't Want To Change.">
                            </div>
                        </div>                    
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="email" value="<?php echo $user['Email'];?>" autocomplete="off">
                            </div>
                        </div>                    
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Full Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="fullname" value="<?php echo $user['FullName'];?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Save" class="btn btn-primary btn-lg">
                            </div>

                        </div>

                    </form>

            <?php }else if($do == 'Update'){

                   echo "<h1 class='text-center'>Update User</h1>" ;

                   if($_SERVER['REQUEST_METHOD'] == 'POST'){

                        $userid   = $_POST['userid'];
                        $username = $_POST['username'];
                        $email    = $_POST['email'];
                        $fullName = $_POST['fullname'];

                        $pass = empty($_POST['newpassword'])?$_POST['oldpassword']:sha1($_POST['oldpassword']);

                        $formError = array();

                       if(empty($username)){

                           $formError[] = "Username Cant Be <strong>Empty</strong>";
                       }                   
                       if(strlen($username)<4){

                           $formError[] = "Username Cant Be Less Than <strong>4 Characters</strong>";
                       }                   
                       if(empty($email)){

                           $formError[] = "Email Cant Be <strong>Empty</strong>";
                       }                   
                       if(empty($fullName)){

                           $formError[] = "FullName Cant Be <strong>Empty</strong>";
                       } 

                       foreach($formError as $error){

                           echo '<div class="alert alert-danger">' . $error . '</div>';

                       }

                       if(empty($formError)){

                            $stmt = $con->prepare("SELECT * FROM users WHERE Username = ? AND UserID != ?");
                            $stmt->execute(array($username, $userid));
                            $count  = $stmt->rowCount();

                            if($count == 1){

                              echo "<div class='alert alert-danger'>Sorry, This User Is Exist</div>";

                            }else{

                               $statm = $con->prepare("UPDATE users set Username=? , Password = ? , Email = ? , FullName = ? WHERE UserID = ?");
                               $statm->execute(array($username, $pass, $email, $fullName, $userid));
                               echo "<div class='alert alert-success'>". $statm->rowCount() ." Record Update</div>";

                            }

                       }

                   }else{
                       echo "<div class='alert alert-danger'>Sorry, You Cant Browse This Page Directly</div>";
                   }

                }else if($do == "Add"){ ?>

                    <div class="addform">

                        <h3 class="text-center">Add User</h3>
                        <form class="form-horizontal" action="?do=Insert" method="post">

                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="username" placeholder="Type Your Username" autocomplete="off">
                                </div>
                            </div>                    
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password" autocomplete="off" placeholder="Type Complex Password Contain on signs and num">
                                </div>
                            </div>                    
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email" placeholder="Type Your Email" autocomplete="off">
                                </div>
                            </div>                    
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Full Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="fullname" placeholder="Type Your Full Name" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">

                                <div class="col-sm-offset-2 col-sm-10">
                                    <input type="submit" value="Add User" class="btn btn-primary btn-lg">
                                </div>

                            </div>

                        </form>

                    </div>

                <?php }else if($do=="Insert"){

                    if($_SERVER['REQUEST_METHOD'] == "POST"){

                        $username = $_POST['username'];
                        $pass     = $_POST['password'];
                        $email    = $_POST['email'];
                        $fullName = $_POST['fullname'];

                        $hasedpass = sha1($_POST['password']);

                        $formError = array();

                        if(empty($username)){

                           $formError[] = "Username Cant Be <strong>Empty</strong>";
                       }                     
                        if(empty($pass)){

                           $formError[] = "Username Cant Be <strong>Empty</strong>";
                       }                   
                       if(strlen($username)<4){

                           $formError[] = "Username Cant Be Less Than <strong>4 Characters</strong>";
                       }                   
                       if(empty($email)){

                           $formError[] = "Email Cant Be <strong>Empty</strong>";
                       }                   
                       if(empty($fullName)){

                           $formError[] = "FullName Cant Be <strong>Empty</strong>";
                       } 

                       foreach($formError as $error){

                           echo '<div class="alert alert-danger">' . $error . '</div>';

                       }

                        if(empty($formError)){

                            $stmt = $con->prepare("SELECT * FROM users WHERE Username = ?");
                            $stmt->execute(array($username));
                            $count  = $stmt->rowCount();

                            if($count == 1){

                              echo "<div class='alert alert-danger'>Sorry, This User Is Exist</div>";

                            }else{

                                $insert = $con->prepare("INSERT INTO 
                                                              users(Username, Password, Email, FullName, Date) 
                                                        VALUES(:zuser, :zpass, :zemail, :zfullname, now())");
                                $insert->execute(array(

                                    "zuser"     => $username,
                                    "zpass"     => $hasedpass,
                                    "zemail"    => $email,
                                    "zfullname" => $fullName

                                ));


                                echo "<div class='alert alert-success'>". $insert->rowCount() . "Record Inserted</div>";
                            }

                        }

                    }else{
                        echo "<div class='alert alert-danger'>Sorry, You Cant Browse This Page Directly</div>";
                    }

                }else if($do == "Delete"){

                    echo "<h3 class='text-center'>Delete User</h3>";

                    $userid = (isset($_GET['userid']) && is_numeric($_GET['userid']))? intval($_GET['userid']) : 0;


                    $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ?");
                    $stmt->execute(array($userid));
                    $count  = $stmt->rowCount();

                    if($count == 1){

                      $delete = $con->prepare("DELETE FROM users WHERE UserID=:Zuser");
                      $delete->bindParam("Zuser" , $userid);
                      $delete->execute();

                    echo "<div class='alert alert-success'>" . $delete->rowCount() . "Record Deleted</div>";

                    }else{
                        echo "<div class='alert alert-danger'>Sorry, This ID Is Not Exist</div>";
                    }

                }

            ?>
        
        </div>
        
    </div>


<?php 
        
        include $tpl ."footer.php";
        
    }else{
        header("Location:login.php");
        exit();
    }

?>