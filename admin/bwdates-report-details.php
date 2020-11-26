<?php 

    session_start();
    if($_SESSION['Username']){
        
        include "init.php";
    ?>

        <?php include $tpl . "sidebar.php"; ?>
        <div class="content">
            <div class="container-fluid">
                            
                <?php if($_SERVER['REQUEST_METHOD'] == 'POST'){

                        $fromdate = $_POST['fromdate'];
                        $todate = $_POST['todate'];
                        $status = $_POST['orderStatus'];

                            $query = '';
                        if($status != "All_Orders"){
                            $query = "AND Status = '$status'"; 
                        }

                        $bwdatesReport = $con->prepare("SELECT * FROM orders WHERE Order_Date BETWEEN '$fromdate' AND '$todate' $query");
                        $bwdatesReport->execute();
                        $bwdatesReports = $bwdatesReport->fetchAll();

                            ?>

                            <div class="" style="margin:100px 0; background-color:#FFF; padding:10px 5px">
                                <h3>Between Dates Reports</h3>
                                <p class="text-center" style="color:blue">Between <?php echo $fromdate; ?> to <?php echo $todate; ?></p>
                                <div class="table-responsive">

                                    <table class="main-table table table-bordered text-center">
                                        <tr>
                                            <td>S.NO</td>
                                            <td>Code</td>
                                            <td>Order Date</td>
                                            <td>Action</td>
                                        </tr>

                                        <?php $i=0; foreach($bwdatesReports as $bwdatesreport){ $i++; ?>

                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td><?php echo $bwdatesreport['Code']; ?></td>
                                                            <td><?php echo $bwdatesreport['Order_Date']; ?></td>
                                                            <td><a href="vieworder.php?code=<?php echo $bwdatesreport['Code']; ?>">view details</a></td>
                                                        </tr>

                                        <?php } ?>

                                    </table>

                                </div>
                            </div>

                        <?php 

                }else{

                echo "<div class='alert alert-danger'>You Can't Browse This Page Directly .</div>";
        }?>
        
            </div>
        </div>


<?php 
    
    
        include $tpl . "footer.php";
        
    }else{
        
        header("Location: login.php");
        exit();
        
    }?>