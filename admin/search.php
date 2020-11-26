<?php 

    session_start();
    
    if(isset($_SESSION['Username'])){
        
        include "init.php";
        
?>


                    
    <?php include $tpl . "sidebar.php"; ?>
            
    <div class="content">
        
        <div class="container-fluid">
            <h3>Search Order</h3>
            
            <div class="SearchForm" style="background-color:#FFF; padding:30px 0">
                <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                    <div class="form-group form-group-lg" style="margin:120px 300px 30px">
                        <span style="font-size:20px; color:#666; font-weight:bold">Search By Order Number: </span>
                        <input type="text" name='orderCode'> 
                        
                    </div>                    
                    <div class="form-group form-group-lg">
                        <div class="col-sm-offset-5 ">
                            <input type="submit" value="Search" class="btn btn-info btn-lg">
                        </div>
                    </div>  
                </form>
                
            <?php 
            
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    
                    $orderCode = $_POST['orderCode'];
                    
                    
                    
                    $orderdetail = $con->prepare("SELECT * FROM orders WHERE Code=?");
                    $orderdetail->execute(array($orderCode));
                    $orderdetails = $orderdetail->fetch(); 
                
                    if(! empty($orderdetails)){
                        echo "<h5 class='text-center'>Result For Code \" # " . $orderCode  .  "\"</h5>";
                ?>
            
                    <div class="table-responsive">
                        <table class="main-table table table-bordered text-center">
                            <tr>
                                <td>S.NO</td>
                                <td>Order Number</td>
                                <td>Order Date</td>
                                <td>Action</td>
                            </tr>                            
                            <tr>
                                <td>1</td>
                                <td><?php echo $orderdetails['Code']; ?></td>
                                <td><?php echo $orderdetails['Order_Date']; ?></td>
                                <td><a href="vieworder.php?code=<?php echo $orderdetails['Code']; ?>">view details</a></td>
                            </tr>
                        </table>
                    </div>
                    
                <?php } }
            
            ?>
                
            </div>
            
        </div>
        
    </div>
    
<?php 
    
    
        include $tpl . "footer.php";
        
    }else{
             
        header("Location: login.php");
        exit();
        
    }?>