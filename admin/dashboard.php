<?php 


    include "init.php";
    

    $order = $con->prepare("SELECT * FROM  orders");
    $order->execute();
    $countOrder = $order->rowCount();

   $countUser = getAllFrom("*", "users", "WHERE GroupID != 1");
   $countOrder = getAllFrom("*", "orders");
   $ConfirmedOrder = getAllFrom("*", "orders", "WHERE Status='Confirmed'");
   $beingPreparedOrder = getAllFrom("*", "orders", "WHERE Status='Food Being Prepared'");
   $PickupdOrder = getAllFrom("*", "orders", "WHERE Status='Pickup'");
   $totalFoodDeliveredOrder = getAllFrom("*", "orders", "WHERE Status='Delievred'");
   $cancelleddOrder = getAllFrom("*", "orders", "WHERE Status='Cancelled'");
   $newOrder = getAllFrom("*", "orders", "WHERE Status='NotConfirmedYet'");
?>

<div class="wrap">
    <?php include $tpl . "sidebar.php"; ?>
    <div class="content container">
        <div class="row">
            <div class="col-sm-4">
                <div class="order">
                    <div class="order-head">
                        <h2> TOTAL ORDER </h2>
                    </div>
                    
                    <div class="order-count">
                        <p><a href="orders.php"><?php echo $countOrder; ?></a></p>
                        <span> Total Order </span>
                    </div>
                </div>
            </div>            
            <div class="col-sm-4">
                <div class="order">
                    <div class="order-head">
                        <h2>NEW ORDER </h2>
                    </div>
                    
                    <div class="order-count">
                        <p><a href="orders.php?do=NotConfirmedYet"><?php echo $newOrder; ?></a></p>
                        <span> New Order </span>
                    </div>
                </div>
            </div>           
            <div class="col-sm-4">
                <div class="order">
                    <div class="order-head">
                        <h2> CONFIRMED ORDER </h2>
                    </div>
                    
                    <div class="order-count">
                        <p><a href="orders.php?do=Confirmed"><?php echo $ConfirmedOrder; ?></a></p>
                        <span> Confirmed order </span>
                    </div>
                </div>
            </div>            
            <div class="col-sm-4">
                <div class="order">
                    <div class="order-head">
                        <h2> FOOD BEING PREPARED </h2>
                    </div>
                    
                    <div class="order-count">
                        <p><a href="orders.php?do=Food Being Prepared"><?php echo $beingPreparedOrder; ?></a></p>
                        <span>  Food Being Prepred</span>
                    </div>
                </div>
            </div>            
            <div class="col-sm-4">
                <div class="order">
                    <div class="order-head">
                        <h2>FOOD PICKUP</h2>
                    </div>
                    
                    <div class="order-count">
                        <p><a href="orders.php?do=Pickup"><?php echo $PickupdOrder; ?></a></p>
                        <span> Food Pickup</span>
                    </div>
                </div>
            </div>            
            <div class="col-sm-4">
                <div class="order">
                    <div class="order-head">
                        <h2>TOTAL FOOD DELIVERED</h2>
                    </div>
                    
                    <div class="order-count">
                        <p><a href="orders.php?do=Delievred"><?php echo $totalFoodDeliveredOrder; ?></a></p>
                        <span> Total Food Delivered</span>
                    </div>
                </div>
            </div>            
            <div class="col-sm-4">
                <div class="order">
                    <div class="order-head">
                        <h2>CANCELLED ORDER</h2>
                    </div>
                    
                    <div class="order-count">
                        <p><a href="orders.php?do=Cancelled"><?php echo $cancelleddOrder; ?></a></p>
                        <span>Cancelled Order</span>
                    </div>
                </div>
            </div>            
            <div class="col-sm-4">
                <div class="order">
                    <div class="order-head">
                        <h2>TOTAL REG. USER</h2>
                    </div>
                    
                    <div class="order-count">
                        <p><a href="members.php"><?php echo $countUser; ?></a></p>
                        <span>Total Reg. User</span>
                    </div>
                </div>
            </div>

            
        </div>
    </div>

    
</div>

<?php 

  include $tpl . "footer.php";

?>

<!--



    <script type="text/javascript" charset="utf-8">
    function addmsg(msg){
        /* Simple helper to add a div.
        type is the name of a CSS class (old/new/error).
        msg is the contents of the div */
        $("#messages").html(msg);
    }

    function waitForMsg(){
        /* This requests the url "msgsrv.php"
        When it complete (or errors)*/
        $.ajax({
            type: "GET",
            url: "msgsrv.php",

            async: true, /* If set to non-async, browser shows page as "Loading.."*/
            cache: false,
            timeout:50000, /* Timeout in ms */

            success: function(data){ /* called when request to barge.php completes */
                addmsg(data);
                           /* Add response to a .msg div (with the "new" class)*/
                setTimeout(
                    waitForMsg, /* Request next message */
                    1000 /* ..after 1 seconds */
                );
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                setTimeout(
                    waitForMsg, /* Try again after.. */
                    15000); /* milliseconds (15seconds) */
            }
        });
    };

    $(document).ready(function(){
        waitForMsg(); /* Start the inital request */
    });
    </script>

-->