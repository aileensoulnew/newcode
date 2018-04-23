<!-- CLOSE ALL DROPEDOWN WHEN CLICK TO BODY OR OTHER DROPDOWN START -->
<script type="text/javascript">
    $('.all').on('click', function () {
        header_all_list_open();
    });
    function header_all_list_open() {
        $.ajax({
            url: "<?php echo base_url(); ?>dashboard/header_all_dropdown_list",
            type: "POST",
            dataType: 'json',
            beforeSend: function () {
                $(".as").html('<p style="text-align:center;"><img class="loader" src="' + base_url + 'assets/images/loading.gif" alt="Loader"/></p>');
            },
            success: function (data) {
                $('.as').html(data.return_html);
            }
        });
    }
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $('.dropbtn_common').on('click', function () {
            $('.dropbtn_common').not(this).next().removeClass('show');
            $(this).next().toggleClass('show');
        });

        $('body').on('click', function (e) {
            if (!$(e.target).closest('.dropbtn_common').length)
            {
                $('.dropbtn_common').next().removeClass('show');
            }

        });
        $(window).on('click', function (e) {
            if (!$(e.target).closest('.dropbtn_common').length)
            {
                $('.dropbtn_common').next().removeClass('show');
            }

        });
        $(document).on('keydown', function (e) {
            if (e.keyCode === 27) {
                $('.dropbtn_common').next().removeClass('show');
            }
        });
		
		$(document).ready(function(){
		  $("select").change(function(){
			if ($(this).val()=="") $(this).addClass("color-light-custom");
			else $(this).addClass("color-black-custom");
		  });
		  
		});	
    });
</script>
<!-- CLOSE ALL DROPEDOWN WHEN CLICK TO BODY OR OTHER DROPDOWN END -->
<script type="text/javascript">
    $.fn.preload = function (fn) {
        var len = this.length,
                i = 0;
        return this.each(function () {
            var tmp = new Image,
                    self = this;
            if (fn)
                tmp.onload = function () {
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
        $.ajax({
            url: "<?php echo base_url(); ?>notification/update_notification",
            type: "POST",
            success: function (data) {
                data = JSON.parse(data);
            }
        });
    }

    function notheader() {

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . "notification/not_header" ?>',
            dataType: 'json',
            data: '',
            beforeSend: function () {
                $('#gen_not_loader').show();
                $('ul.notification_data_in').html('<div class="fw" id="gen_not_loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" alt="Loader" /></div>');
            },

            complete: function () {
                $('#gen_not_loader').hide();
            },
            success: function (data) {
                $('.' + 'notification_data_in').html(data.notification);
                $('#seenot').html(data.seeall);
                $('span[id^=notification_count]').html('');
                $('span[id^=notification_count]').css({
                    "background-color": "",
                    "padding": "0px"
                });
                $('#notificationLink').removeClass('notification_available');
            }

        });

    }

    jQuery(document).ready(function ($) {
        if (screen.width <= 767) {
            $("ul.left-form-each").on("click", ".init", function () {
                console.log($(this).closest("ul").children('li:not(.init)').toggle());
            });
            var allOptions = $("ul.left-form-each").children('li:not(.init)');
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
      //  var socket = io.connect(window.location.protocol + '//' + window.location.hostname + ':3000', {secure: true});
        //var socket = io.connect();
//        socket.on('notification_count', function (data) {
//            $("#notification_count" + data.to_id).html(data.notification_count);
//            $('#notification_count' + data.to_id).css({
//                "background-color": "#FF4500",
//                "padding": "5px 6px",
//                "border-radius": "50px",
//            });
//            $('#notificationLink').addClass('notification_available');
//            document.getElementById('notification_count' + data.to_id).style.display = 'block';
//            $('#notif_audio')[0].play();
//        });


        //waitForMsg();
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

    });

//    function addmsg(type, msg) {
//        if (msg == 0) {
//            $("#notification_count").html('');
//            $('#notification_count').css({
//                "background-color": "",
//                "padding": "0px"
//            });
//            $('#notificationLink').removeClass('notification_available');
//            document.getElementById('notification_count').style.display = 'none';
//        } else {
//            $('#notification_count').html(msg);
//            $('#notification_count').css({
//                "background-color": "#FF4500",
//                "padding": "5px 6px"
//            });
//            $('#notificationLink').addClass('notification_available');
//            document.getElementById('notification_count').style.display = 'block';
//        }
//    }

//    function waitForMsg() {
//        $.ajax({
//            type: "GET",
//            url: "<?php echo base_url(); ?>notification/select_notification",
//            timeout: 50000,
//
//            success: function (data) {
//                addmsg("new", data);
//                setTimeout(
//                        waitForMsg,
//                        10000
//                        );
//            },
//        });
//    }
    // CLICK ON ESCAPE NOTIFICATION & MESSAGE DROP DOWN CLOSE END

    function show_header_notification(notification_count, to_id) {
       // var socket = io.connect(window.location.protocol + '//' + window.location.hostname + ':3000', {secure: true});
        //var socket = io.connect();
//        socket.emit('notification_count', {
//            notification_count: notification_count,
//            to_id: to_id,
//        });
    }
</script>
<script type="text/javascript">
    $('#InboxLink').on('click', function () {
        document.getElementById('message_count').style.display = "none";
    });
</script>
<!-- footer end -->
<!--SCRIPT USE FOR NOTIFICATION SCROLLBAR-->
<script type="text/javascript" src="<?php echo base_url('assets/js/scrollbar/jquery.mCustomScrollbar.concat.min.js?ver='.time()); ?>"></script>
<!--SCRIPT USE FOR NOTIFICATION SCROLLBAR-->

<!-- preload img -->
<script type="text/javascript">
//      $(document).ready(function() {
//     function preload(arrayOfImages) {
//        //  alert(arrayOfImages);
//     $(arrayOfImages).each(function(){
//         $('<img/>')[0].src = this;
//         // Alternatively you could use:
//         // (new Image()).src = this;
//     });
// }

// // Usage:

// preload([
//     'img/fi1.png',
//     'img/fi2.png',
//     'img/fi3.png',
//     'img/fi4.png',
//     'img/fi5.png',
//     'img/fi1_hover.png',
//     'img/index.png',
//     'img/h3.png',
//     'img/icon_contact_request_h.png',
//     'img/icon_contact_request.png',
//     'img/edit_profile.png',
//     'img/fi2_hover.png',
//     'img/fi3_hover.png',
//     'img/fi4_hover.png',
//     'img/fi5_hover.png']);

// });
// better image preloading @ https://perishablepress.com/press/2009/12/28/3-ways-preload-images-css-javascript-ajax/


    /*$(document).ready(function () {
     var images = new Array()
     function preload(image) {
     
     for (i = 0; i < preload.arguments.length; i++) {
     images[i] = new Image()
     images[i].src = preload.arguments[i]
     }
     }
     preload(
     '<?php echo base_url(); ?>img/fi1_hover.png',
     '<?php echo base_url(); ?>img/fi2_hover.png',
     '<?php echo base_url(); ?>img/fi3_hover.png',
     '<?php echo base_url(); ?>img/fi4_hover.png',
     '<?php echo base_url(); ?>img/fi5_hover.png',
     '<?php echo base_url(); ?>img/icon_contact_request.png',
     '<?php echo base_url(); ?>img/h3.png',
     '<?php echo base_url(); ?>img/index.png',
     '<?php echo base_url(); ?>img/edit_profile.png',
     )
     }); */
</script>
<script>
    // mcustom scroll bar
	(function($){
            $(window).on("load",function(){
		$(".custom-scroll").mCustomScrollbar({
                    autoHideScrollbar:true,
                    theme:"minimal"
		});
            });
	})(jQuery);
    </script>
<!--<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo (ENVIRONMENT === 'development') ? 'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>-->

    <script>
			var menuRight = document.getElementById( 'cbp-spmenu-s2' ),
				showRight = document.getElementById( 'showRight' ),
				body = document.body;

			showRight.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( menuRight, 'cbp-spmenu-open' );
				disableOther( 'showRight' );
			};
		
			function disableOther( button ) {
				
				if( button !== 'showRight' ) {
					classie.toggle( showRight, 'disabled' );
				}
			}
			
			$(function () {
				$('a[href="#search"]').on('click', function (event) {
					event.preventDefault();
					$('#search').addClass('open');
					$('#search > form > input[type="search"]').focus();
				});
				$('#search, #search button.close-new').on('click keyup', function (event) {
					if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
						$(this).removeClass('open');
					}
				});
			});
		</script>