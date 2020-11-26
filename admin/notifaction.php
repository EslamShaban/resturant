<?php 
    session_start();
    if(isset($_SESSION['Username'])){
        
    include "init.php";
            
?>


    <?php include $tpl . "sidebar.php"; ?> 
    
    <div class="content">
        
        <div class="container-fluid">
            
                <span>You Notifaction</span>
                <hr>

                <div class="notifc">
                    
                    <ul class="list-unstyled">

                            <?php 
                                foreach($notifaction as $notifa){
                                    echo "<a href='vieworder.php?code=" . $notifa['Code'] . "'>";
                                        echo"<li class=";if($notifa['have_seen'] == 1){ echo 'seen'; } echo "><i class='fa fa-shopping-basket'></i> #" . $notifa['Code'] . " Order Received from ". $notifa['FullName'] . "";
                                            
                                            echo "<span style='float:right'>";if($notifa['have_seen'] == 1){ echo 'seen'; } echo"</span>";
                                            echo "<p>2h ago</p>";
                                        echo "</li>";
                                    echo "</a>";

                                }
                            ?>
                        </ul>

                </div>

                
        </div>
            
</div>
   

<?php 
        
        
        include $tpl ."footer.php";
        
    ?>

<?php
        
    }else{
        header("Location:login.php");
        exit();
    }

?>