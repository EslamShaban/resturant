<?php 

    session_start();
    if($_SESSION['Username']){
        
        include "init.php";
    ?>

        <?php include $tpl . "sidebar.php"; ?>
        <div class="content">
            <div class="container-fluid">
                               
                <div class="dateform" style="margin-top:100px; background-color:#FFF; padding:20px 10px">
                    <p style="font-size:18px; color:#666; font-weight:bold; margin-bottom:30px">Between Dates Reports</p>
                    <form class="form-horizontal" action="bwdates-report-details.php" method="post">
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2">From Date</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="fromdate">
                            </div>
                        </div>                        
                        <div class="form-group form-group-lg">
                            <label class=" col-sm-2">To Date</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="todate">
                            </div>
                        </div>                        
                        <div class="form-group form-group-lg">
                        
                            <label class="col-sm-2">Request Type</label>
                            
                            <div class="col-sm-10">
                                
                                    <input id = "All-Orders" type="radio" name="orderStatus" value="All_Orders" checked>
                                    <label for="All-Orders" style="font-size:14px">All Orders</label>                      

                                    <input id = "NotConfirmed" type="radio" name="orderStatus" value="NotConfirmedYet">
                                    <label for="NotConfirmed" style="font-size:14px">Order NotConfirmed</label>
                                     
                                    <input id = "Cancelled-Order" type="radio" name="orderStatus" value="Cancelled"> 
                                    <label for="Cancelled-Order" style="font-size:14px">Canclled Order</label>
                                   
                                    <input id = "Confirmed" type="radio" name="orderStatus" value="Confirmed"> 
                                    <label for="Confirmed" style="font-size:14px">Order Confirmed</label>
                                
                                   <input id = "Being-Preparing" type="radio" name="orderStatus" value="Food Being Prepared">
                                    <label for="Being-Preparing" style="font-size:14px">Order Being Preparing</label>
 
                                    <input id = "Pickup" type="radio" name="orderStatus" value="Pickup">
                                    <label for="Pickup" style="font-size:14px">Order Pickup</label>
 
                                    <input id = "Deliveered" type="radio" name="orderStatus" value="Delievred">
                                    <label for="Deliveered" style="font-size:14px">Order Deliveered</label>


                                
                            </div> 
                        </div>
                        <div class="form-group form-group-lg">
                            <div class="col-sm-offset-6">
                                <input type="submit" value="Submit" class="btn btn-success btn-lg">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<?php
        
        include $tpl . "footer.php";
        
    }else{
        header("Location: login.php");
        exit();
    }

?>