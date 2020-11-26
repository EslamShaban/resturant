<?php 

    session_start();
    
    if(isset($_SESSION['Username'])){
        
        include "init.php";
        
        ?>
        
       
            <?php include $tpl . "sidebar.php"; ?>
            <div class="content">
                <div class="container-fluid">
                    <?php 

                        $do = (isset($_GET['do'])) ? $_GET['do']:"Manage";

                        if($do == "Manage"){ 

                            $stmt = $con->prepare("SELECT * FROM categories");
                            $stmt->execute();
                            $cats = $stmt->fetchAll();

                            if(!empty($cats)){
                            ?>

                            <h3 class="text-center">Manage Food Categories</h3>
                            <div class="table-responsive ">

                                <table class="main-table table table-bordered text-center">

                                    <tr>
                                        <td>#ID</td>
                                        <td>Name</td>
                                        <td>Creation Date</td>
                                        <td>Control</td>
                                    </tr>

                                    <?php 
                                        foreach($cats as $cat){ ?>
                                            <tr>
                                                <td><?php echo $cat['CatID']?></td>
                                                <td><?php echo $cat['Name']?></td>
                                                <td><?php echo $cat['Creation_Date']?></td>
                                                <td>
                                                    <a href="?do=Edit&catid=<?php echo $cat["CatID"];?>" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                                    <a href="?do=Delete&catid=<?php echo $cat["CatID"];?>" class="btn btn-danger"><i class="fa fa-close"></i> Delete</a>
                                                </td>                                       
                                            </tr>
                                       <?php }
                                    ?>

                                </table>

                            </div>


                        <?php }else{

                                echo "<div class='nice-message'>Ther's No Category To Show</div>";
                                echo "<a href='?do=Add' class='btn btn-primary'><i class='fa fa-plus'></i> Add New Category</a>";

                            }
                        }else if($do == "Edit"){ 

                            $catid = (isset($_GET['catid']) && is_numeric($_GET['catid']))? intval($_GET['catid']) : 0;

                            $stmt = $con->prepare("SELECT * FROM categories WHERE CatID = ?");
                            $stmt->execute(array($catid));
                            $cat = $stmt->fetch();

                            if(! empty($cat)){
                        ?>

                            <h3 class="text-center">Edit categories</h3>
                            <form class="form-horizontal" action='?do=Update' method='post'>
                                <input type="hidden" name="catid" value="<?php echo $cat['CatID']; ?>">
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Category Name</label>
                                    <div class="col-sm-10">
                                        <input style="border:2px solid #080" type="text" class="form-control" name="name" value="<?php echo $cat['Name']; ?>" autocomplete="off">
                                    </div>
                                </div>                              
                                <div class="form-group form-group-lg">
                                    <div class="col-sm-offset-6 ">
                                        <input type="submit" value="Save" class="btn btn-success btn-lg">
                                    </div>
                                </div>                            

                            </form>

                        <?php }else{

                                echo "<div class='alert alert-danger'>There's No Such ID</div>";
                            } 

                        }else if($do == 'Update'){

                            echo "<h3 class='text-center'>Update Category</h3>";

                            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                                $catid = $_POST['catid'];
                                $name  = $_POST['name'];

                                $formError = array();

                                if(empty($name)){
                                    $formError[] = "Category Name Cant Be <strong> Empty </strong>";
                                }

                                foreach($formError as $error){
                                        echo "<div class='alert alert-danger'>".$error."</div>";
                                    }

                                if(empty($formError)) {                  
                                    $stmt = $con->prepare("SELECT * FROM categories WHERE Name = ? And CatID != ?");
                                    $stmt->execute(array($name, $catid));
                                    $count = $stmt->rowCount();

                                    if($count == 1){

                                        echo "<div class='alert alert-danger'>Sorry, This Category Is Exist</div>";

                                    }else{
                                        $update = $con->prepare("UPDATE categories set Name = ? WHERE CatID = ?");
                                        $update->execute(array($name, $catid));
                                        echo "<div class='alert alert-success'>". $update->rowCount() ."Record Update</div>";

                                    }
                                }




                            }else{
                                echo "<div class='alert alert-danger'>Sorry, You Cant Browse This Page Directly</div>";
                            }

                        }else if($do == 'Add'){ ?>

                            <h3 class="text-center">Add categories</h3>
                            <form class="form-horizontal" action='?do=Insert' method='post'>
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Category Name</label>
                                    <div class="col-sm-10">
                                        <input style="border:2px solid #080" type="text" class="form-control" name="name" autocomplete="off">
                                    </div>
                                </div>                              
                                <div class="form-group form-group-lg">
                                    <div class="col-sm-offset-6 ">
                                        <input type="submit" value="Add" class="btn btn-success btn-lg">
                                    </div>
                                </div>                            

                            </form>

                        <?php }else if($do == 'Insert'){

                            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                                $name  = $_POST['name'];

                                $formError = array();

                                if(empty($name)){
                                    $formError[] = "Category Name Cant Be <strong> Empty </strong>";
                                }

                                foreach($formError as $error){
                                        echo "<div class='alert alert-danger'>".$error."</div>";
                                    }

                                if(empty($formError)) {  

                                    $stmt = $con->prepare("SELECT * FROM categories WHERE Name = ?");
                                    $stmt->execute(array($name));
                                    $count = $stmt->rowCount();

                                    if($count == 1){

                                        echo "<div class='alert alert-danger'>Sorry, This Category Is Exist</div>";

                                    }else{
                                        $insertCat = $con->prepare("INSERT INTO categories(Name, Creation_Date) VALUES(:Zname, now())");
                                        $insertCat->execute(array("Zname" => $name));
                                        echo "<div class='alert alert-success'>". $insertCat->rowCount() ."Record Inserted</div>";

                                    }
                                }



                            }else{

                                echo "<div class='alert alert-danger'>Sorry, You Cant Browse This Page Directly</div>";

                            }

                        }else if($do == "Delete"){

                            $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

                            $stmt = $con->prepare("SELECT * FROM categories WHERE CatID = ?");
                            $stmt->execute(array($catid));
                            $count  = $stmt->rowCount();

                            if($count == 1){

                              $delete = $con->prepare("DELETE FROM categories WHERE CatID = :Zcat");
                              $delete->bindParam("Zcat" , $catid);
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
        
        include $tpl . "footer.php";
        
    }else{
        
        header("Location: login.php");
        exit();
    }

?>