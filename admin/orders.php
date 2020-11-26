<?php 

    session_start();
    
    if(isset($_SESSION['Username'])){
        
        include "init.php"; ?>

        <div class="wrap">
            
            <?php  include $tpl . "sidebar.php"; ?>
            
            <div class="content container">
                
                
                <?php 
                        
                    $do = isset($_GET['do']) ? $_GET['do'] : "Manage";
        
                    if($do == "Manage"){
                    
                           
                        echo "<h1 class='text-center'>All Orders</h1>";
                                                
                        $confirmedorder = $con->prepare("SELECT * FROM orders");
                        $confirmedorder->execute();
                        $orders = $confirmedorder->fetchAll(); ?>
                
                        <div class="table-responsive">
                            
                            <table class="main-table table table-bordered text-center">
                                <tr>
                                    <td>S.N.O</td>
                                    <td>Order Number</td>
                                    <td>Order Date</td>
                                    <td>Control</td>
                                </tr>
                                <?php
                                    $i=1;
                                    $code = array();
                                    foreach($orders as $order){  
                                        if(! in_array($order['Code'], $code)){ 
                                            $code[] = $order['Code'];
                                ?>
                                
                                        <tr>
                                            <td><?php echo $order['orderID'];?></td>
                                            <td><?php echo $order['Code'];?></td>
                                            <td><?php echo $order['Order_Date'];?></td>
                                            <td><a href="vieworder.php?code=<?php echo $order['Code'];?>">view details</a></td>
                                        </tr>
                                        
                                    <?php $i++;} }
                                ?>
                            </table>
                
                        </div>
                        
                        
                        
                    <?php 
                        
                    }else if($do == "Confirmed"){
                        
                        echo "<h1 class='text-center'>Orders Confirmed</h1>";
                                                
                        $confirmedorder = $con->prepare("SELECT * FROM orders WHERE Status = ?");
                        $confirmedorder->execute(array($do));
                        $orders = $confirmedorder->fetchAll(); ?>
                
                        <div class="table-responsive">
                            
                            <table class="main-table table table-bordered text-center">
                                <tr>
                                    <td>S.N.O</td>
                                    <td>Order Number</td>
                                    <td>Order Date</td>
                                    <td>Control</td>
                                </tr>
                                <?php
                                    foreach($orders as $order){ ?>
                                
                                        <tr>
                                            <td><?php echo $order['orderID'];?></td>
                                            <td><?php echo $order['Code'];?></td>
                                            <td><?php echo $order['Order_Date'];?></td>
                                            <td><a href="vieworder.php?code=<?php echo $order['Code'];?>">view details</a></td>
                                        </tr>
                                        
                                    <?php }
                                ?>
                            </table>
                
                        </div>
                        
                        
                        
                    <?php }else if($do == "NotConfirmedYet"){
                        
                                                
                        echo "<h1 class='text-center'>Orders Not Confirmed Yet</h1>";
                        
                        
                        $confirmedorder = $con->prepare("SELECT * FROM orders WHERE Status = ?");
                        $confirmedorder->execute(array($do));
                        $orders = $confirmedorder->fetchAll(); ?>
                
                        <div class="table-responsive">
                            
                            <table class="main-table table table-bordered text-center">
                                <tr>
                                    <td>S.N.O</td>
                                    <td>Order Number</td>
                                    <td>Order Date</td>
                                    <td>Control</td>
                                </tr>
                                <?php
                                    foreach($orders as $order){ ?>
                                
                                        <tr>
                                            <td><?php echo $order['orderID'];?></td>
                                            <td><?php echo $order['Code'];?></td>
                                            <td><?php echo $order['Order_Date'];?></td>
                                            <td><a href="vieworder.php?code=<?php echo $order['Code'];?>">view details</a></td>
                                        </tr>
                                        
                                    <?php }
                                ?>
                            </table>
                
                        </div>
                
                        
                    <?php }else if($do == "Food Being Prepared"){
                        
                                                
                        echo "<h1 class='text-center'>Orders Food Being Prepared</h1>";
                        
                        
                        $confirmedorder = $con->prepare("SELECT * FROM orders WHERE Status = ?");
                        $confirmedorder->execute(array($do));
                        $orders = $confirmedorder->fetchAll(); ?>
                
                        <div class="table-responsive">
                            
                            <table class="main-table table table-bordered text-center">
                                <tr>
                                    <td>S.N.O</td>
                                    <td>Order Number</td>
                                    <td>Order Date</td>
                                    <td>Control</td>
                                </tr>
                                <?php
                                    foreach($orders as $order){ ?>
                                
                                        <tr>
                                            <td><?php echo $order['orderID'];?></td>
                                            <td><?php echo $order['Code'];?></td>
                                            <td><?php echo $order['Order_Date'];?></td>
                                            <td><a href="vieworder.php?code=<?php echo $order['Code'];?>">view details</a></td>
                                        </tr>
                                        
                                    <?php }
                                ?>
                            </table>
                
                        </div>
                
                        
                    <?php }else if($do == "Cancelled"){
                        
                                                                        
                        echo "<h1 class='text-center'>Orders Cancelled</h1>";
                        
                        
                        $confirmedorder = $con->prepare("SELECT * FROM orders WHERE Status = ?");
                        $confirmedorder->execute(array($do));
                        $orders = $confirmedorder->fetchAll(); ?>
                
                        <div class="table-responsive">
                            
                            <table class="main-table table table-bordered text-center">
                                <tr>
                                    <td>S.N.O</td>
                                    <td>Order Number</td>
                                    <td>Order Date</td>
                                    <td>Control</td>
                                </tr>
                                <?php
                                    $i=1;
                                    $code = array();
                                    foreach($orders as $order){  
                                        if(! in_array($order['Code'], $code)){ 
                                            $code[] = $order['Code'];
                                ?>
                                        
                                        <tr>
                                            <td><?php echo  $i; ?></td>
                                            <td><?php echo $order['Code'];?></td>
                                            <td><?php echo $order['Order_Date'];?></td>
                                            <td><a href="vieworder.php?do=Manage&code=<?php echo $order['Code'];?>">view details</a></td>
                                        </tr>
                                
                                        
                                
                                    <?php $i++;} }
                                ?>
                            </table>
                
                        </div>
                
                        
                    <?php
                        
                    }else if($do == "Pickup"){
                        
                        echo "<h1 class='text-center'>Orders Pickup</h1>";
                                                
                        $confirmedorder = $con->prepare("SELECT * FROM orders WHERE Status = ?");
                        $confirmedorder->execute(array($do));
                        $orders = $confirmedorder->fetchAll(); ?>
                
                        <div class="table-responsive">
                            
                            <table class="main-table table table-bordered text-center">
                                <tr>
                                    <td>S.N.O</td>
                                    <td>Order Number</td>
                                    <td>Order Date</td>
                                    <td>Control</td>
                                </tr>
                                <?php
                                    foreach($orders as $order){ ?>
                                
                                        <tr>
                                            <td><?php echo $order['orderID'];?></td>
                                            <td><?php echo $order['Code'];?></td>
                                            <td><?php echo $order['Order_Date'];?></td>
                                            <td><a href="vieworder.php?code=<?php echo $order['Code'];?>">view details</a></td>
                                        </tr>
                                        
                                    <?php }
                                ?>
                            </table>
                
                        </div>
                        
                        
                        
                    <?php 
                    }else if($do == "Delievred"){
                                                
                        echo "<h1 class='text-center'>Orders Delievred</h1>";
                                                
                        $confirmedorder = $con->prepare("SELECT * FROM orders WHERE Status = ?");
                        $confirmedorder->execute(array($halabsa));
                        $orders = $confirmedorder->fetchAll(); ?>
                
                        <div class="table-responsive">
                            
                            <table class="main-table table table-bordered text-center">
                                <tr>
                                    <td>S.N.O</td>
                                    <td>Order Number</td>
                                    <td>Order Date</td>
                                    <td>Control</td>
                                </tr>
                                <?php
                                    foreach($orders as $order){ ?>
                                
                                        <tr>
                                            <td><?php echo $order['orderID'];?></td>
                                            <td><?php echo $order['Code'];?></td>
                                            <td><?php echo $order['Order_Date'];?></td>
                                            <td><a href="vieworder.php?do=Manage&code=<?php echo $order['Code'];?>">view details</a></td>
                                        </tr>
                                        
                                    <?php }
                                ?>
                            </table>
                
                        </div>
                        
                        
                        
                    <?php 
                    }
                
                ?>
                
            </div>

        </div>

<?php
        
        
        
        include $tpl . "footer.php"; 
        
    }

?>