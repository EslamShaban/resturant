<?php
include "connect.php";

    $notif = $con->prepare("SELECT * FROM orders WHERE have_seen=0");
    $notif->execute();
    $Countnotifaction = $notif->rowCount();
    echo $Countnotifaction;


?>