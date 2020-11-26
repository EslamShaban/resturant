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

                        ORDER BY

                              orderID ASC");
    $stmt->execute(); 
    $notifaction = $stmt->fetchAll();   


    $notif = $con->prepare("SELECT * FROM orders WHERE have_seen=0");
    $notif->execute();
    $Countnotifaction = $notif->rowCount();
?>
    <div class="sidebar">
        
        <i class="fa fa-bars" style="color:white"></i>
        <h4 class="text-center" style="margin:0" >Online Ordering System</h4>
        
        <div class="personalinformation">
            <img src="../layout/images/avatar.png" class="img-responsive thumbnail" style="width:90px; height:90px; border-radius:45px; margin:20px auto">
            <h4 style="margin:0" class="text-center">Admin</h4>
        </div>
        
        <ul class="list-unstyled">
            <li>
                <a href="notifaction.php"><i class=" fa fa-bell fa-lg"></i> Notification </a> <span class="sp"><i style="<?php if($Countnotifaction > 0)echo 'color:#FFF'; else echo'color:#000';?>" class=" fa fa-bell fa-lg"></i><?php if($Countnotifaction > 0){echo "<span class='spno' id='messages'> $Countnotifaction </span>";}?></span>
            </li>            
            <li>
                <a href="dashboard.php"><i class=" fa fa-home fa-lg"></i> Dashboards</a><i style="color:white" class="pull-right fa fa-chevron-right"></i>
            </li>
            <li>
                <a chref="members.php"><i class="fa fa-user fa-lg"></i> Reg Users</a><i style="color:white" class="pull-right fa fa-chevron-right"></i>
            </li>
            <li><a href="categories.php"><i class="fa fa-address-card fa-lg"></i> Food Category</a><i style="color:white" class="pull-right fa fa-chevron-right"></i></li>
            <li><a href="items.php"><i class="fa fa-address-card fa-lg"></i> Food Menue</a><i style="color:white" class="pull-right fa fa-chevron-right"></i></li>
            <li class="order">
                <a href="orders.php"><i class="fa fa-address-card fa-lg"></i> Orders </a> <i style="color:white" class="pull-right fa fa-chevron-right"></i>
                <div class="orderstatus">
                    <ul class="list-unstyled">
                        <li><a href="orders.php?do=Confirmed"><i class="fa fa-address-card fa-lg"></i> Confirmed</a></li>
                        <li><a href="orders.php?do=notConfirmedYet"><i class="fa fa-address-card fa-lg"></i> Not Confirmed</a></li>
                        <li><a href="orders.php?do=Pickup"><i class="fa fa-address-card fa-lg"></i> Food Pickup</a></li>
                        <li><a href="orders.php?do=Delievred"><i class="fa fa-address-card fa-lg"></i> Food Delivered</a></li>
                        <li><a href="orders.php?do=Cancelled"><i class="fa fa-address-card fa-lg"></i> Food Cancelled</a></li>
                    </ul>
                </div>
            </li>
            <li><a  href="bwdates-report-ds.php"><i class="fa fa-address-card fa-lg"></i> Reports</a><i style="color:white" class="pull-right fa fa-chevron-right"></i></li>
            <li><a href="search.php"><i class="fa fa-map-pin fa-lg"></i> Search</a></li>
            <li style="float:right"><a href="signout.php"> LogOut <i class="fa fa-sign-out fa-lg"> </i></a></li>
        </ul>
    
    </div>



