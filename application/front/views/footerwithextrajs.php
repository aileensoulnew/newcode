<!-- Dropdown CLose while outside body click Start -->
<script type="text/javascript">
    $(document).ready(function () {
        $('.dropdown_hover').click(function (event) {
            event.stopPropagation();
            $(".dropdown-content_hover").fadeToggle("fast");
        });
        $(".dropdown-content_hover").on("dropdown_hover", function (event) {
            event.stopPropagation();
        });
    });

    $(document).on("dropdown_hover", function () {
        $(".dropdown-content_hover").hide();
    });

    $(document).ready(function () {
        $("body").click(function (event) {
            $(".dropdown-content_hover").hide();
          //  event.stopPropagation();
        });

    });
</script>
<!-- Dropdown CLose while outside body click End -->

<!-- IMAGE PRELOADER SCRIPT -->
<script type="text/javascript">
//  function preload(arrayOfImages) {
//     $(arrayOfImages).each(function () {
//         $('<img />').attr('src',this).appendTo('body').css('display','none');
//     });
// }

$.fn.preload = function (fn) {
    var len = this.length, i = 0;
    return this.each(function () {
        var tmp = new Image, self = this;
        if (fn) tmp.onload = function () {
            fn.call(self, 100 * ++i / len, i === len);
        };
        tmp.src = this.src;
    });
};

</script>
<!-- IMAGE PRELOADER SCRIPT -->
<!-- script for update all read notification start-->
<script type="text/javascript">
    function Notificationheader() {
        getNotification();
        notheader();
    }
    function getNotification() {
        // first click alert('here'); 
        $.ajax({
            url: "<?php echo base_url(); ?>notification/update_notification",
            type: "POST",
            success: function (data) {
                data = JSON.parse(data);
            }
        });
    }
    function notheader()
    {

        // $("#fad" + clicked_id).fadeOut(6000);


        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "notification/not_header" ?>',
            dataType: 'json',
            data: '',
            beforeSend: function () {
            
                $('#gen_not_loader').show();
           },
        
        complete: function () {
            $('#gen_not_loader').hide();
        },
            success: function (data) {
                //    alert(data);
                $('.' + 'notification_data_in').html(data.notification);
                $('#seenot').html(data.seeall);

            }


        });

    }

    jQuery(document).ready(function ($) {
        if (screen.width <= 767) {
            $("ul.left-form-each").on("click", ".init", function () {
                $(this).closest("ul").children('li:not(.init)').toggle();
            });
            var allOptions = $("ul").children('li:not(.init)');
            $("ul.left-form-each").on("click", "li:not(.init)", function () {
                allOptions.removeClass('selected');
                $(this).addClass('selected');
                $("ul.left-form-each").children('.init').html($(this).html());
                allOptions.toggle();
            });
        }
        $(function () {
            $('a[href="#search"]').on('click', function (event) {
                event.preventDefault();
                $('#search').addClass('open');
                $('#search > form > input[type="search"]').focus();
            });
            $('#search, #search button.close').on('click keyup', function (event) {
                if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
                    $(this).removeClass('open');
                }
            });
        });
    });

    $(document).ready(function () {
        // MAIN NOTIFICATION
        waitForMsg();
        $menuLeft = $('.pushmenu-left');
        $nav_list = $('#nav_list');
        $nav_list.click(function () {
            $(this).toggleClass('active');
            $('.pushmenu-push').toggleClass('pushmenu-push-toright');
            $menuLeft.toggleClass('pushmenu-open');
        });
        // CONTACT PERSON COUNT
       // waitForMsg_contact();
        $menuLeft = $('.pushmenu-left');
        $nav_list = $('#nav_list');
        $nav_list.click(function () {
            $(this).toggleClass('active');
            $('.pushmenu-push').toggleClass('pushmenu-push-toright');
            $menuLeft.toggleClass('pushmenu-open');
        });
        // CONTAINER HIDE : NOTIFICATION, PROFILEBOX, MESSAGEBOX
        $("body").click(function (event) {
            $("#notificationContainer").hide();
            $("#InboxContainer").hide();
            $(".dropdown-menu").hide();
            $("#acon").hide();
            $("#InboxContainer").fadeOut("slow");
            $(".dropdown-menu").fadeOut("slow");
        });
        // EDIT PROFILE DROPDOWN 
        $('.dropdown-user').click(function (event) {
            event.stopPropagation();
            $(".dropdown-menu").fadeToggle("fast");
        });
        $(".dropdown-menu").on("dropdown-user", function () {
            $(".dropdown-menu").hide();
            // event.stopPropagation();
        });

        //ON CLICK GENERAL NOTIFICATION ICON EVENT IN HEADER
        $("#notificationLink").click(function ()
        {
              $("#acon").hide();
            $("#InboxContainer").hide();
            $("#Inbox_count").hide();
            $(".dropdown-menu").hide();
            $("#dropdown-content_hover").hide();
            $("#addcontactContainer").hide();
            $("#Frnd_reqContainer").hide();
            $("#Frnd_req_count").hide();
            $("#notificationContainer").fadeToggle(300);
            $("#notification_count").fadeOut("slow");
            return false;
        });
        //ON CLICK MESSAGE NOTIFICATION ICON EVENT IN HEADER
        $("#InboxLink").click(function ()
        {
            $("#Frnd_reqContainer").hide();
            $("#acon").hide();
            $("#Frnd_req_count").hide();
            $(".dropdown-menu").hide();
            $("#addcontactContainer").hide();
            $("#notificationContainer").hide();
            $("#notification_count").hide();
            $("#dropdown-content_hover").hide();
            $("#InboxContainer").fadeToggle(300);
            $("#Inbox_count").fadeOut("slow");
            return false;
        });
        //ON CLICK USER PROFILE NOTIFICATION ICON EVENT IN HEADER
        $(".dropdown-user").click(function ()
        {
            $("#Frnd_reqContainer").hide();
            $("#Frnd_req_count").hide();
            $("#addcontactContainer").hide();
            $("#notificationContainer").hide();
            $("#notification_count").hide();
            $("#InboxContainer").hide();
            $("#Inbox_count").hide();
            $("#dropdown-content_hover").hide();
            return true;
        });
        //ON CLICK USER PROFILE NOTIFICATION DROPDOWN HOVER ICON EVENT IN HEADER 
        $(".dropdown_hover").click(function ()
        {
            $("#Frnd_reqContainer").hide();
            $("#Frnd_req_count").hide();
            $("#notificationContainer").hide();
            $("#notification_count").hide();
            $("#InboxContainer").hide();
            $("#Inbox_count").hide();
            $("#acon").hide();
            

            return true;
        });

        // SHOW HIDE POPOVER
        $('#menu1').click(function(){
            $("#acon").hide();
        });
    });

    function addmsg(type, msg)
    {
        if (msg == 0)
        {
            $("#notification_count").html('');
            $('#notification_count').css({"background-color": " ", "padding": "5px 6px"});
            $('#notificationLink').removeClass('notification_available');
        } else
        { 
            $('#notification_count').html(msg);
            $('#notification_count').css({"background-color": "#FF4500", "padding": "5px 6px"});
            $('#notificationLink').addClass('notification_available');
         //   document.getElementById('message_count').style.display = "none";
            document.getElementById('notification_count').style.display = 'block';
        }
    }
    function waitForMsg()
    {
        $.ajax({
            type: "GET",
            url: "<?php echo base_url(); ?>notification/select_notification",
            async: true,
            cache: false,
            timeout: 50000,
            
            success: function (data) {
                addmsg("new", data);
                setTimeout(
                        waitForMsg,
                        10000
                        );
            },
        });
    }
    
    

    // USER PROFILE DROPDOWN IN HEADER
    $(document).on("dropdown-user", function () {
        $(".dropdown-menu").hide();
    });
    // CLICK ON ESCAPE NOTIFICATION & MESSAGE DROP DOWN CLOSE START
    $(document).on('keydown', function (e) {
        if (e.keyCode === 27) {
            $("#notificationContainer").hide();
            $("#InboxContainer").hide();
            $("#acon").hide();
        }
    });

/*
    $(document).on('keydown', function (e) {
        if (e.keyCode === 27) {
            $("#InboxContainer").hide();
            $("#acon").hide();
        }
    });
    $(document).on('keydown', function (e) {
        if (e.keyCode === 27) {
            $("#acon").hide();
        }
    });
    */
    $(document).on("click", function (event) {
        var $trigger = $(".myDropdown");
        if ($trigger !== event.target && !$trigger.has(event.target).length) {
            $(".myDropdown").slideUp("slow");
        }
    });
    // CLICK ON ESCAPE NOTIFICATION & MESSAGE DROP DOWN CLOSE END

    $(document).ready(function ()
    {
        $("#alink").click(function ()
        {
      

            $("#InboxContainer").hide();
            $("#Inbox_count").hide();
            $(".dropdown-menu").hide();
            $("#dropdown-content_hover").hide();
            $("#addcontactContainer").hide();
            $("#notificationContainer").hide();
//            $("#notification_count").hide();


            $("#Frnd_reqContainer").hide();
            $("#Frnd_req_count").hide();

            $("#acon").fadeToggle(300);
            $("#acont").fadeOut("slow");

            return false;
        });

    });

</script>

<script type="text/javascript">
    $('#InboxLink').on('click', function () {
        document.getElementById('message_count').style.display = "none";
    });
</script>

<!-- footer end -->
<!--SCRIPT USE FOR NOTIFICATION SCROLLBAR-->
<script type="text/javascript" src="<?php echo base_url('assets/js/scrollbar/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>
<!--SCRIPT USE FOR NOTIFICATION SCROLLBAR-->