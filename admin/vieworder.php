<?php 

    session_start();

    if(isset($_SESSION['Username'])){
        
        include "init.php"; ?>


            <?php include $tpl . "sidebar.php"; ?>
            
            <div class="content">

                <div class="container-fluid">
                    
                

                    <?php 



                    $code = (isset($_GET['code'])) ? $_GET['code']:"0";

                    $have_seen = 1;

                    $updatee = $con->prepare("UPDATE orders set have_seen = $have_seen WHERE Code = ?");
                    $updatee->execute(array($code));

                        if($_SERVER['REQUEST_METHOD'] == 'POST'){

                            $status = $_POST['status'];
                            $code   = $_POST['code'];

                            $update = $con->prepare("UPDATE orders set Status = ? WHERE Code = ?");
                            $update->execute(array($status, $code));

                            $success = "<h4 class='text-center' style='color:#f7600e; font-size:30px; margin-bottom:-42px'>Order Has been Updated</h4>";

                        }


                    ?>

                        <h3>Order Details #<?php echo $code; ?></h3>

                        <div class="row" style="background-color:#fff">

                            <div class="col-sm-6">

                                <?php if(isset($success)) echo $success; ?>

                                <div class="panel panel-primary" style="margin-top:95px">

                                    <div class="panel-heading">                                                            

                                        <p class="text-center" style="font-size:20px">User Details</p>

                                    </div>
                                    <div class="panel-body" style="padding:0">
                                        <?php 

                                            $stmt = $con->prepare("SELECT 
                                                                      orders.*, 
                                                                      users.*
                                                                FROM 
                                                                      orders 

                                                                INNER JOIN 
                                                                      users 
                                                                ON 

                                                                       users.UserID=orders.userID

                                                                AND
                                                                      orders.code = ?

                                                                ORDER BY

                                                                      orderID ASC");
                                          $stmt->execute(array($code));
                                          $ordersFood = $stmt->fetch(); 
                                        ?>

                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td>Order Number</td>
                                                    <td><?php echo "#" . $ordersFood['Code'];?></td>
                                                </tr>                                
                                                <tr>
                                                    <td>Username</td>
                                                    <td><?php echo $ordersFood['Username'];?></td>
                                                </tr>                                
                                                <tr>
                                                    <td>Fullname</td>
                                                    <td><?php echo $ordersFood['FullName'];?></td>
                                                </tr>                                
                                                <tr>
                                                    <td>Email</td>
                                                    <td><?php echo $ordersFood['Email'];?></td>
                                                </tr>                                
                                                <tr>
                                                    <td>Mobile Number</td>
                                                    <td><?php echo $ordersFood['Mobile_Number'];?></td>
                                                </tr>                                
                                                <tr>
                                                    <td>City</td>
                                                    <td><?php echo $ordersFood['City'];?></td>
                                                </tr>                               
                                                <tr>
                                                    <td>Area</td>
                                                    <td><?php echo $ordersFood['Area'];?></td>
                                                </tr>                                
                                                <tr>
                                                    <td>Street Name</td>
                                                    <td><?php echo $ordersFood['Street_Name'];?></td>
                                                </tr>                                
                                                <tr>
                                                    <td>Flat No./Bulding No.</td>
                                                    <td><?php echo $ordersFood['Flat'];?></td>
                                                </tr>                                
                                                <tr>
                                                    <td>Landmark</td>
                                                    <td><?php echo $ordersFood['Landmark'];?> </td>
                                                </tr>                                
                                                <tr>
                                                    <td>Order Date</td>
                                                    <td><?php echo $ordersFood['Order_Date'];?></td>
                                                </tr>                                
                                                <tr>
                                                    <td>Order Final Status</td>
                                                    <td><?php echo $ordersFood['Status'];?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="col-sm-6">

                                <?php 
                                       $explodeItems = explode(',' , $ordersFood['order-items']);

                                ?>
                                <div class="panel panel-primary" style="margin-top:95px">

                                    <div class="panel-heading">                                                            

                                            <p class="text-center" style="font-size:20px">Order Details</p>

                                    </div>

                                    <div class="panel-body" style="padding:0">

                                            <div class="table-responsive">
                                            <table class="table table-bordered">                           
                                                <tr>
                                                    <td>#</td>
                                                    <td>Food</td>
                                                    <td>Food Name</td>
                                                    <td>Price</td>

                                                </tr> 
                                                <?php 
                                                    $i=1;
                                                    $totalPrice = 0;
                                                    foreach($explodeItems as $item){

                                                        $stmt = $con->prepare("SELECT * FROM items WHERE Name=?");
                                                        $stmt->execute(array($item));
                                                        $itemdetail = $stmt->fetch();

                                                        $totalPrice += $itemdetail['Price'];

                                                        echo "<tr>";
                                                            echo "<td>" . $i . "</td>";
                                                            echo "<td><img class='img-responsive' style='width:80px; height:80px' src='upload/" . $itemdetail['image'] . "' ></td>";
                                                            echo "<td>" . $itemdetail['Name']. "</td>";
                                                            echo "<td>" . $itemdetail['Price']. "</td>";
                                                        echo "</tr>";  




                                                        $i++;

                                                    }

                                                    echo "<tr>";
                                                        echo "<td colspan='3' class='text-center'>Grand Total</td>";
                                                        echo "<td>" . $totalPrice . "</td>";
                                                    echo "</tr>";
                                                ?>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>


                        <hr>

                        <form class="form-horizontal" action="?do=Update" method="post">
                            <input type="hidden" name="code" value="<?php echo $ordersFood['Code'];?>">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Resturant Status</label>
                                <div class="col-sm-10">
                                    <select name="status" class="form-control" style="width:100%">
                                        <option value="Confirmed">Order Confirmed</option>
                                        <option value="Cancelled">Order Canceled</option>
                                        <option>Food Being Prepared</option>
                                        <option value="Pickup">Food Pickup</option>
                                        <option value="Delievred">Food Delivered</option>
                                    </select>
                                </div>
                            </div>                    
                            <div class="form-group">
                                <div class="col-sm-offset-6">
                                    <input type="submit" value="Update Order" class="btn btn-success">
                                </div>
                            </div>

                        </form>
                    
                </div>
                
            </div>
        
        <?php 
                

        include $tpl ."footer.php";
        
        
    }else{
        
        header("Location: login.php");
        exit();
    }

?>