<?php
include "connect.php";

    $contactUS = $con->prepare("SELECT * FROM contactus");
    $contactUS->execute();
    $contactuss = $contactUS->fetchAll(); 

?>


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