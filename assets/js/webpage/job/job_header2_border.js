 
//Deactivate Job Profile Start
 function deactivate(clicked_id) { 
       $('.biderror .mes').html("<div class='pop_content'> Are you sure you want to deactive your job profile?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='deactivate_profile(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
           $('#bidmodal').modal('show');
   }
   
   function deactivate_profile(clicked_id){
                   $.ajax({
                       type: 'POST',
                       url: base_url +'job/deactivate',
                       data: 'id=' + clicked_id,
                         success: function (data) {
                           window.location= base_url +"dashboard";
                                     
                                 }
                             });
   }
//Deactivate Job Profile End

//all popup close close using esc start 
    $( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) {
        $('#bidmodal').modal('hide');
        $.fancybox.close();
        $( "#dropdown-content_hover" ).hide();
    }
   });  
 //all popup close close using esc End

 //script for fetch all unread message notification Start
function addmsg1(type, msg)
    {
        if (msg == 0)
        { //alert(1234);
            $("#message_count").html('');
            $("#message_count").removeAttr("style");
            $('#InboxLink').removeClass('msg_notification_available');
            document.getElementById('message_count').style.display = "none";
        } else
        {
            $('#message_count').html(msg);
            //     $('#message_count').css({"background-color": "#FF4500", "height": "16px", "width": "16px", "padding": "3px 4px"});
            $('#InboxLink').addClass('msg_notification_available');
            $('#message_count').addClass('count_add');
            document.getElementById('message_count').style.display = "block";
            //alert("welcome");
        }
    }
   
   function waitForMsg1()
   {
       $.ajax({
           type: "GET",
           url: base_url +"notification/select_msg_noti/1",
   
           async: true,
           cache: false,
           timeout: 50000,
   
           success: function (data) {
               addmsg1("new", data);
               setTimeout(
                       waitForMsg1,
                       10000
                       );
           },
           error: function (XMLHttpRequest, textStatus, errorThrown) {
   
           }
       });
   }
   ;
   
   $(document).ready(function () {
   
       waitForMsg1();
   
   });
   $(document).ready(function () {
       $menuLeft = $('.pushmenu-left');
       $nav_list = $('#nav_list');
   
       $nav_list.click(function () {
           $(this).toggleClass('active');
           $('.pushmenu-push').toggleClass('pushmenu-push-toright');
           $menuLeft.toggleClass('pushmenu-open');
       });
   });
   
 //script for fetch all unread message notification end

 //script for update all read notification start
$(document).ready(function () {
     
   if(segment != "chat"){ chatmsg(); };
          });  
   function chatmsg()
   {             
            
           $.ajax({
               type: 'POST',
               url: base_url +'chat/userajax/1/2',
               dataType: 'json',
               data: '',
               beforeSend: function () {
            
                $('#msg_not_loader').show();
           },
        
        complete: function () {
            $('#msg_not_loader').show();
        },
               success: function (data) { //alert(data);
   
                   $('#userlist').html(data.leftbar);
                   $('.notification_data_in_h2').html(data.headertwo);
                   $('#seemsg').html(data.seeall);
                setTimeout(
                       chatmsg,
                      100000
                       );
               },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
           }           
           });
         
           };
   
   function getmsgNotification() {
       msgNotification();
   }
   
   function msgNotification() {
       $.ajax({
           url: base_url + "notification/update_msg_noti/1",
           type: "POST",
           success: function (data) {
               data = JSON.parse(data);
           }
       });
   }
   function msgheader()
   {
       $.ajax({
           type: 'POST',
           url: base_url +'notification/msg_header/' +seg,
           data: 'message_from_profile=1&message_to_profile=2',
           success: function (data) {
               $('.' + 'notification_data_in_h2').html(data);
           }
       });
   
   }
 //script for update all read notification End
  