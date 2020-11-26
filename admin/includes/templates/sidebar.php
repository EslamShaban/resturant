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

                              orderID DESC");
    $stmt->execute(); 
    $notifaction = $stmt->fetchAll();   


    $notif = $con->prepare("SELECT * FROM orders WHERE have_seen=0");
    $notif->execute();
    $Countnotifaction = $notif->rowCount();

    $contactUS = $con->prepare("SELECT * FROM contactus");
    $contactUS->execute();
    $contactuss = $contactUS->fetchAll(); 
    $CountcontactUS = $contactUS->rowCount();
?>


    <div class="header">
            <h3 class="text-center"><i class="fa fa-cart-arrow-down"></i> Ordering</h3>
            <div class="header-content">
        
                <i class="fa fa-bars bars" style="color:white"></i>

                <div class="pull-right user-tools">

                    <div class="personal-inform">

                        <span class="numberMess <?php if($CountcontactUS == 0) echo 'spannone'?>" id="messages" ><?php if($CountcontactUS > 0) echo $CountcontactUS;?></span>

                        <i class="fa fa-envelope-o"></i>
                        
                        <div class="envelope notif">
                                                                            
                            <span class="head">You have 4 messages</span>
                            <div id="message">
                                <ul class="list-unstyled">

                                        <?php 
                                            foreach($contactuss as $contact){
                                                echo "<a href='vieworder.php?'>";
                                                    echo"<li><i class='fa fa-envelope-o'></i> You have Message From  ". $contact['Username'] . "";
                                                        echo "<p>2h ago</p>";
                                                    echo "</li>";
                                                echo "</a>";

                                            }
                                        ?>
                                </ul>
                            </div>
                            <span class="foot"><a href="#">See All Messages</a></span>
                        </div>
                        <span class="numberNotif <?php if($Countnotifaction == 0) echo 'spannone'?>" id='notifs'><?php if($Countnotifaction > 0) echo $Countnotifaction;?></span>
                        <i class="fa fa-bell-o"></i>
                        
                        <div class="notif">
                                                                            
                            <span class="head">You have 10 notifications</span>
                            <div id="notif">
                                <ul class="list-unstyled">

                                        <?php 
                                            foreach($notifaction as $notifa){
                                                echo "<a href='vieworder.php?code=" . $notifa['Code'] . "'>";
                                                    echo"<li class=";if($notifa['have_seen'] == 1){ echo 'seen'; } echo "><i class='fa fa-shopping-basket'></i> #" . $notifa['Code'] . " Order Received from ". $notifa['Username'] . "";
                                                        echo "<p>2h ago</p>";
                                                    echo "</li>";
                                                echo "</a>";

                                            }
                                        ?>
                                </ul>
                            
                            </div>
                            
                            <span class="foot"><a href="notifaction.php">view all</a></span>
                        </div>
                        <span class="numberTask">4</span>
                        <i class="fa fa-flag-o"></i>
                                                
                        <div class="flag notif">
                                                                            
                            <span class="head">You have 4 tasks</span>
            
                            <ul class="list-unstyled ">
                                    <li><a><i class="fa fa-users fa-xs"></i> 5 New members joined today</a></li>
                                    <li><a><i class="fa fa-users fa-xs"></i> 5 New members joined today</a></li>
                                    <li><a><i class="fa fa-users fa-xs"></i> 5 New members joined today</a></li>
                                    <li><a><i class="fa fa-users fa-xs"></i> 5 New members joined today</a></li>                                   
                            </ul>
                            
                            <span class="foot"><a href="#">view all</a></span>
                        </div>
                        <img src="../layout/images/user.jpg"  style="width:30px; height:30px; border-radius:50%;">
                        <span class="yourname" style="color:white" class="name">Eslam Shaban</span>

                    </div>
        </div>
            </div>
    </div>
    
    <div class="sidebar">      
        <div class="personalinformation">
            <img src="../layout/images/user.jpg" style="width:50px; height:50px; border-radius:50%;">
            <span>Eslam Shaban</span>
            
            <div class="Searchform">
                <form class="form-horizontal">
                    <input type="search" class="form-control" placeholder="Search...">
                    <span><i class="fa fa-search"></i></span>
                </form>
            </div>
        </div>
        <span class="mainspan">MAIN NAVIGATION</span>
        <ul class="list-unstyled links-area">
            <li><i class="icon fa fa-tachometer"></i> <a href="dashboard.php">Dashboard</a></li>
            <li>
                <i class="icon fa fa-users"></i> <a href="#">Reg Users <i class="fa fa-angle-left"></i></a> 
                <ul class="list-unstyled child-links-area">
                    <li><a href="members.php">Manage User</a></li>
                    <li><a href="members.php?do=Add">Add User</a></li>
                </ul>
            </li>
            <li><i class="icon fa fa-pencil-square-o"></i><a href="#">Food Category <i class="fa fa-angle-left"></i></a>
                <ul class="list-unstyled child-links-area">
                    <li><a href="categories.php">Manage Category</a></li>
                    <li><a href="categories.php?do=Add">Add Category</a></li>
                </ul>
           </li>
            <li><i class="icon fa fa-pencil-square-o"></i><a href="#">Food Menue <i class="fa fa-angle-left"></i></a>
                <ul class="list-unstyled child-links-area">
                    <li><a href="items.php">Manage Food</a></li>
                    <li><a href="items.php?do=Add">Add Food</a></li>
                </ul>
            </li>
            <li><i class="icon fa fa-table"></i><a href="#">Orders <i class="fa fa-angle-left"></i></a>
                <ul class="list-unstyled child-links-area">
                        <li><a href="orders.php?do=Confirmed">Confirmed</a></li>
                        <li><a href="orders.php?do=notConfirmedYet">Not Confirmed</a></li>
                        <li><a href="orders.php?do=Pickup">Food Pickup</a></li>
                        <li><a href="orders.php?do=Delievred">Food Delivered</a></li>
                        <li><a href="orders.php?do=Cancelled">Food Cancelled</a></li>
                        <li><a href="orders.php">All Order</a></li>
                </ul>
            </li>
            <li><i class="icon fa fa-file"></i><a href="#">Reports <i class="fa fa-angle-left"></i></a>
                <ul class="list-unstyled child-links-area">
                    <li><a href="bwdates-report-ds.php">B/W Dates</a></li>
                    <li><a href="">Count Order</a></li>
                    <li><a href="">Sales Reports</a></li>
                </ul>
            </li>             
            <li><i class="icon fa fa-table"></i><a href="search.php">Search <i class="fa fa-angle-left"></i></a></li>            

            
        </ul>

</div>

