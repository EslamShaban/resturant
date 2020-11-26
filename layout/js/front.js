/*global $, document */
$(document).ready(function () {


    $('.up').on('click', function(){

        var num = Number( $(this).closest('.orderItemsNumber').find('.counter').html());
        var cartID = $(this).closest('.orderItemsNumber').data('cartid');

        num+=1

        $(this).closest('.orderItemsNumber').find('.counter').html(num);


        $.ajax({
            url:"ajax_change_cart.php",
            type:"GET",
            data:{cartid:cartID, number:num},
            success:function(data){
                $('.totalPrice').html(data);
            }
        });

        
    });

    $('.down').on('click', function(){

        var num = Number( $(this).closest('.orderItemsNumber').find('.counter').html());
        var cartID = $(this).closest('.orderItemsNumber').data('cartid');

        if(num != 1)
            num-=1;

        $(this).closest('.orderItemsNumber').find('.counter').html(num);

        $.ajax({
            url:"ajax_change_cart.php",
            type:"GET",
            data:{cartid:cartID, number:num},
            success:function(data){
                $('.totalPrice').html(data);
            }
        });

    });

});