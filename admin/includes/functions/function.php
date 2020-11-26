<?php 


    function pageTitle(){
        global $title;
        echo $title;
    }


/*
** Get All Function v1.0
** Function To Get Any Table From Database
*/

function getAllFrom($field, $table, $where=NULL){

    global $con;
    
    $getAll = $con->prepare("SELECT $field FROM $table $where ");
    
    $getAll->execute();
    
    $all = $getAll->rowCount();
    
    return $all;
    
}

?>
