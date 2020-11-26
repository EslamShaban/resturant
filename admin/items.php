<?php 

    session_start();
    
    if(isset($_SESSION['Username'])){
        
        include "init.php"; ?>
        
            <?php include $tpl . "sidebar.php"; ?>
            <div class="content">
                <div class="container-fluid">
                    <?php 


                        $do = (isset($_GET['do'])) ? $_GET['do']:"Manage";

                        if($do == "Manage"){ 


                            $page = (isset($_GET['page'])) ? $_GET['page'] : '1';


                            $num_per_page = 5;
                            $from = ($page-1)*$num_per_page;


                            $stmt = $con->prepare("SELECT 
                                                      items.*, 
                                                      categories.Name As Ctaegory_Name
                                                FROM 
                                                      items 
                                                INNER JOIN 
                                                      categories 
                                                ON 
                                                      categories.CatID=items.catid 
                                                ORDER BY

                                                      ItemID DESC LIMIT $from,$num_per_page");
                          $stmt->execute();
                          $items= $stmt->fetchAll(); 

                            if(!empty($items)){ 

                            ?>

                            <h3 class="text-center">Manage Food Items</h3>
                            <div class="table-responsive">

                                <table class="main-table table table-bordered text-center">

                                    <tr>
                                        <td>#ID</td>
                                        <td>Image</td>
                                        <td>Name</td>
                                        <td>Category</td>
                                        <td>Price</td>
                                        <td>Control</td>
                                    </tr>

                                    <?php 

                                        foreach($items as $item){ $from++; ?>
                                            <tr>
                                                <td><?php echo $from; ?></td>
                                                <td><img style="height:50px; width:50px" class="img-responsive img-thumbnail" src="<?php echo "Upload/" . $item['image']?>" alt="avatar" ></td>
                                                <td><?php echo $item['Name']?></td>
                                                <td><?php echo $item['Ctaegory_Name']?></td>
                                                <td><?php echo $item['Price']?></td>
                                                <td>
                                                    <a href="?do=Edit&itemid=<?php echo $item["ItemID"];?>" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                                    <a href="?do=Delete&itemid=<?php echo $item["ItemID"];?>" class="btn btn-danger"><i class="fa fa-close"></i> Delete</a>
                                                </td>                                       
                                            </tr>
                                       <?php }
                                    ?>

                                </table>

                            </div>


                            <?php 
                                    $stmt = $con->prepare("SELECT * from items");
                                    $stmt->execute();
                                    $numOfItems = $stmt->rowCount();

                                    if($numOfItems > $num_per_page){

                            ?>

                         <nav aria-label="Page navigation" class="nav-center" id="pagnit">
                          <ul class="pagination">
                            <li>
                              <a href="?page=<?php if(($page-1)  > 0) echo $page-1; else  echo '1';?>#pagnit" aria-label="Previous">
                                <span aria-hidden="true">Previous</span>
                              </a>
                            </li>
                              <?php
                              $totalpage = ceil($numOfItems/$num_per_page);
                              for($i=1; $i<=$totalpage ; $i++){?>
                                    <li><a href="?page=<?php echo $i;?>#pagnit"><?php echo $i;?></a></li>
                              <?php } ?>
                            <li>
                              <a href="?page=<?php if(($page+1) < $totalpage) echo $page+1; else echo $totalpage;?>#pagnit" aria-label="Next">
                                <span aria-hidden="true">Next</span>
                              </a>
                            </li>
                          </ul>
                        </nav>

            <?php } ?>


                        <?php }else{

                                echo "<div class='nice-message'>Ther's No Item To Show</div>";
                                echo "<a href='?do=Add' class='btn btn-primary'><i class='fa fa-plus'></i> Add New Item</a>";

                            }
                        }else if($do == "Edit"){ 

                            $itemid = (isset($_GET['itemid']) && is_numeric($_GET['itemid']))? intval($_GET['itemid']) : 0;

                            $stmt = $con->prepare("SELECT * FROM items WHERE ItemID = ?");
                            $stmt->execute(array($itemid));
                            $item = $stmt->fetch();

                            if(! empty($item)){
                        ?>

                            <h3 class="text-center">Edit Items</h3>
                            <form name="foo" class="form-horizontal" action='?do=Update' method='post' enctype="multipart/form-data">
                                <input type="hidden" name="itemid" value="<?php echo $item['ItemID']; ?>">
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Category Name</label>
                                    <div class="col-sm-10">

                                        <select name="CatID" class="form-control">

                                           <?php 

                                              $stmt = $con->prepare("SELECT * FROM categories");
                                              $stmt->execute();
                                              $cats = $stmt->fetchAll();

                                              foreach($cats as $cat){

                                                  echo "<option value='" . $cat['CatID'] . "'";
                                                  if($item['catid']==$cat['CatID']){echo "selected";}
                                                  echo " >" . $cat['Name'] .  "</option>";
                                              }


                                            ?>

                                        </select>                               
                                    </div>
                                </div>                               
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Item Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="itemname" value="<?php echo $item['Name']; ?>" autocomplete="off">
                                    </div>
                                </div>                               
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Description</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="Desc" value="<?php echo $item['Description']; ?>" autocomplete="off">
                                    </div>
                                </div>                               
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Price</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="price" value="<?php echo $item['Price']; ?>" autocomplete="off">
                                    </div>
                                </div>                              
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Image</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" name="image" value="<?php echo "Upload/" . $item['image']; ?>">
                                    </div>
                                </div>                              
                                <div class="form-group form-group-lg">
                                    <div class="col-sm-offset-6 ">
                                        <input type="submit" value="Update" class="btn btn-success btn-lg">
                                    </div>
                                </div>                            

                            </form>

                        <?php }else{

                                echo "<div class='alert alert-danger'>There's No Such ID</div>";
                            } 

                        }else if($do == 'Update'){

                            echo "<h3 class='text-center'>Update Category</h3>";

                            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                                $itemid     = $_POST['itemid'];
                                $CatID      = $_POST['CatID'];
                                $itemname   = $_POST['itemname'];
                                $Desc       = $_POST['Desc'];
                                $price      = $_POST['price'];

                                $formError = array();

                                if(empty($CatID)){
                                    $formError[] = "Category Name Cant Be <strong> Empty </strong>";
                                }                            
                                if(empty($itemname)){
                                    $formError[] = "Item Name Cant Be <strong> Empty </strong>";
                                }                            
                                if(empty($Desc)){
                                    $formError[] = "Desc Cant Be <strong> Empty </strong>";
                                }                            
                                if(empty($price)){
                                    $formError[] = "Price Name Cant Be <strong> Empty </strong>";
                                }

                                foreach($formError as $error){
                                        echo "<div class='alert alert-danger'>".$error."</div>";
                                    }

                                if(empty($formError)) {                  
                                    $stmt = $con->prepare("SELECT * FROM items WHERE Name = ? And ItemID != ?");
                                    $stmt->execute(array($itemname, $itemid));
                                    $count = $stmt->rowCount();

                                    if($count == 1){

                                        echo "<div class='alert alert-danger'>Sorry, This Item Is Exist</div>";

                                    }else{
                                        $update = $con->prepare("UPDATE items set Name = ?, Description = ?, Price=? , catid = ? WHERE ItemID = ?");
                                        $update->execute(array($itemname, $Desc, $price, $CatID, $itemid));
                                        echo "<div class='alert alert-success'>". $update->rowCount() ."Record Update</div>";

                                    }
                                }




                            }else{
                                echo "<div class='alert alert-danger'>Sorry, You Cant Browse This Page Directly</div>";
                            }

                        }else if($do == 'Add'){ ?>

                            <h3 class="text-center">Add Item</h3>
                            <form class="form-horizontal" action='?do=Insert' method='post' enctype="multipart/form-data">
                                <input type="hidden" name="itemid" value="<?php echo $item['ItemID']; ?>">
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Category Name</label>
                                    <div class="col-sm-10">

                                        <select name="Catname" class="form-control">

                                           <?php 

                                              $stmt = $con->prepare("SELECT * FROM categories");
                                              $stmt->execute();
                                              $cats = $stmt->fetchAll();

                                              foreach($cats as $cat){

                                                  echo "<option value='" . $cat['CatID'] . "'";
                                                  echo " >" . $cat['Name'] .  "</option>";
                                              }


                                            ?>

                                        </select>                               
                                    </div>
                                </div>                             
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Item Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="itemname"  autocomplete="off">
                                    </div>
                                </div>                               
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Description</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="Desc"  autocomplete="off">
                                    </div>
                                </div>                               
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Price</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="price"  autocomplete="off">
                                    </div>
                                </div>                               
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Image</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" name="image">
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

                                $itemid     = $_POST['itemid'];
                                $Catname    = $_POST['Catname'];
                                $itemname   = $_POST['itemname'];
                                $Desc       = $_POST['Desc'];
                                $price      = $_POST['price'];
                                $image      = $_FILES['image'];


                                $image_name = $image['name'];
                                $image_type = $image['type'];
                                $image_temp = $image['tmp_name'];
                                $image_size = $image['size'];
                                $error      = $image['error'];

                                $allowed_extension = array('jpg', 'png', 'jpeg', 'gif');

                                $image_extension = strtolower(end(explode('.', $image['name'])));




                                $formError = array();

                                if(empty($Catname)){
                                    $formError[] = "Category Name Cant Be <strong> Empty </strong>";
                                }                            
                                if(empty($itemname)){
                                    $formError[] = "Item Name Cant Be <strong> Empty </strong>";
                                }                            
                                if(empty($Desc)){
                                    $formError[] = "Desc Cant Be <strong> Empty </strong>";
                                }                            
                                if(empty($price)){
                                    $formError[] = "Price Name Cant Be <strong> Empty </strong>";
                                }
                                if($error == 4){
                                    $formError[] = "You can't upload Image";
                                }else{
                                    if(! in_array($image_extension, $allowed_extension)){
                                        $formError[] = "This Type Not Supported Please Upload Image";
                                    }
                                    if($image_size > 900000){
                                        $formError[] = "This Is Big Size";
                                    }
                                    else{
                                        $newName = rand(0,100000) . '_' . $image_name;                           
                                        move_uploaded_file($image_temp, $_SERVER['DOCUMENT_ROOT'] . '\resturant\admin\upload\\' . $newName);

                                    }
                                }

                                foreach($formError as $error){
                                        echo "<div class='alert alert-danger'>".$error."</div>";
                                    }

                                if(empty($formError)) {  

                                    $stmt = $con->prepare("SELECT * FROM items WHERE Name = ?");
                                    $stmt->execute(array($itemname));
                                    $count = $stmt->rowCount();

                                    if($count == 1){

                                        echo "<div class='alert alert-danger'>Sorry, This Item Is Exist</div>";

                                    }else{
                                        $insertItem = $con->prepare("INSERT INTO items(Name, Description, Add_date, Price, catid, image) VALUES(:Zname, :Zdesc, now(), :Zprice, :Zcatname, :Zimage)");
                                        $insertItem->execute(array(
                                            "Zname"         => $itemname,
                                            "Zdesc"         => $Desc,
                                            "Zprice"        => $price,
                                            "Zimage"        => $newName,
                                            "Zcatname"      => $Catname

                                        ));
                                        echo "<div class='alert alert-success'>". $insertItem->rowCount() ."Record Inserted</div>";

                                    }
                                }



                            }else{

                                echo "<div class='alert alert-danger'>Sorry, You Cant Browse This Page Directly</div>";

                            }


                        }else if($do == "Delete"){

                            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

                            $stmt = $con->prepare("SELECT * FROM items WHERE ItemID = ?");
                            $stmt->execute(array($itemid));
                            $count  = $stmt->rowCount();

                            if($count == 1){

                              $delete = $con->prepare("DELETE FROM items WHERE ItemID = :Zitem");
                              $delete->bindParam("Zitem" , $itemid);
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
        header("Location: login.php");
        exit();
    }


?>