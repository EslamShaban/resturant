<?php
include "connect.php";

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

?>




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

