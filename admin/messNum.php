<?php
include "connect.php";

    $contact = $con->prepare("SELECT * FROM contactus ");
    $contact->execute();
    $contactNum = $contact->rowCount();
    echo $contactNum;


?>