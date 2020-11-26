/*global $, document */
$(document).ready(function () {
    
    
    $(".links-area > li > a").on("click", function(){
        
        $(this).children("i").toggleClass("fa-angle-right fa-angle-down");
        
        $(this).next(".child-links-area").slideToggle();
        
    });
    
    $(".bars").on("click", function(){
       
        $(".content, .sidebar, .header").toggleClass("no-sidebar");
        
    });

    
           
    $(document).mouseup(function (e) { 
            if ($(e.target).closest(".personal-inform").length === 0) { 
                    $(".personal-inform .notif").hide();
                    $(".personal-inform i").removeClass("backcolor");

            } else{

                $(".personal-inform i").on("click", function(){

                    $(".personal-inform .notif").hide();
                    $(".personal-inform i").removeClass("backcolor");

                    $(this).next(".notif").show();
                    
                    $(this).addClass("backcolor");


                }); 
            }
        }); 

    
    
    
    
        var no = 0;
    function addmsg(msg, id, innerUrl, innerID){
        
        
        $(id).html(msg);
        
        
        if(no != msg){

            function addmasg(msg,innerID){

                $(innerID).html(msg);
            }

            function waitForMasg(innerUrl, innerID){
                
                $.ajax({
                    type: "GET",
                    url: innerUrl,

                    async: true, 
                    cache: false,
                    timeout:50000, 

                    success: function(data){ 
                        addmasg(data, innerID);
                                   
                        
                        if(no != msg){
                            no = msg;
                            waitForMasg(innerUrl, innerID);
                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown){
                        setTimeout(
                            waitForMasg(innerUrl, innerID), 
                            15000); 
                    }
                });
                
                
            };

            waitForMasg(innerUrl, innerID); 
        }
        
      
        
    }

    function waitForMsg(url, id, innerUrl, innerID){
        
        $.ajax({
            type: "GET",
            url: url,

            async: true, 
            cache: false,
            timeout:50000, 

            success: function(data){
                addmsg(data, id, innerUrl, innerID);
                               
                setTimeout(
                    waitForMsg(url, id, innerUrl, innerID),
                    1000 
                );
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                setTimeout(
                    waitForMsg(url, id, innerUrl, innerID),
                    15000); 
            }
        });
        
                

        
        
    };
    
    
        waitForMsg("msgsrv.php", "#notifs", "test.php", "#notif"); 
        waitForMsg("messNum.php", "#messages", "message.php", "#message"); 

    

    
});
