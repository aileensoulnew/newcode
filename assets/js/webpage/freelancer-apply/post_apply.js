//CODE FOR RESPONES OF AJAX COME FROM CONTROLLER AND LAZY LOADER START
$(document).ready(function () {
  
    freelancerwork_home();

    $(window).scroll(function () {
        //if ($(window).scrollTop() == $(document).height() - $(window).height()) {
       // if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
        if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.7){
            var page = $(".page_number:last").val();
            var total_record = $(".total_record").val();
            var perpage_record = $(".perpage_record").val();
            if (parseInt(perpage_record) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                //if ($(".page_number:last").val() <= $(".total_record").val()) {
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($(".page_number:last").val()) + 1;
                    
                    freelancerwork_home(pagenum);
                }
            }
        }
    });
    
});
var isProcessing = false;
function freelancerwork_home(pagenum)
{
    
    if (isProcessing) {
        /*
         *This won't go past this condition while
         *isProcessing is true.
         *You could even display a message.
         **/
        return;
    }
    isProcessing = true;
    $.ajax({
        type: 'POST',
        url: base_url + "freelancer/ajax_freelancer_apply_post?page=" + pagenum,
        data: {total_record:$("#total_record").val()},
        dataType: "html",
        beforeSend: function () {
          document.getElementById("loader").style.display = "block";
        },
        complete: function () {
          document.getElementById("loader").style.display = "none";
        },
        success: function (data) {
            $('.job-contact-frnd1').append(data);
            // second header class add for scroll
            //display border for no projects available start
            var numItems = $('.job-contact-frnd1 .all-job-box').length;
            // return false;
            if (numItems == 0) {
                $('.job-contact-frnd1').addClass('cust-border');
            }
            //display border for no projects available end
            var nb = $('.post-design-box').length;
            if (nb == 0) {
                $("#dropdownclass").addClass("no-post-h2");
            } else {
                $("#dropdownclass").removeClass("no-post-h2");
            }
            isProcessing = false;
        }
    });
}

//CODE FOR RESPONES OF AJAX COME FROM CONTROLLER AND LAZY LOADER END
//CODE FOR SAVE USER START            
            function save_post(abc)
            {
                $.ajax({
                    type: 'POST',
                    url:  base_url + "freelancer/save_user",
                    data: 'post_id=' + abc,
                    success: function (data) {
                        $('.' + 'savedpost' + abc).html(data).addClass('saved');
                    }
                });

            }
            function savepopup(id) {
                save_post(id);
                $('.biderror .mes').html("<div class='pop_content'>Your Project is successfully saved.");
                $('#bidmodal').modal('show');
            }
//CODE FOR SAVE USER END             

////CODE FOR CHECK SEARCH KEYWORD AND LOCATION BLANK START
//            function checkvalue() {
//                var searchkeyword = $.trim(document.getElementById('tags').value);
//                var searchplace = $.trim(document.getElementById('searchplace').value);
//                if (searchkeyword == "" && searchplace == "") {
//                    return false;
//                }
//            }
//            function check() {
//    var keyword = $.trim(document.getElementById('tags1').value);
//    var place = $.trim(document.getElementById('searchplace1').value);
//    if (keyword == "" && place == "") {
//        return false;
//    }
//}
////CODE FOR CHECK SEARCH KEYWORD AND LOCATION BLANK END
//CODE FOR APPLY POST START
            function apply_post(abc, xyz) {
                var alldata = 'all';
                var user = xyz;
                $.ajax({
                    type: 'POST',
                    url:  base_url + "freelancer/apply_insert",
                    data: 'post_id=' + abc + '&allpost=' + alldata + '&userid=' + user,
                      dataType: 'json',
                    success: function (data) {
                       
                        $('.savedpost' + abc).hide();
                        $('.applypost' + abc).html(data.status);
                        $('.applypost' + abc).attr('disabled', 'disabled');
                        $('.applypost' + abc).attr('onclick', 'myFunction()');
                        $('.applypost' + abc).addClass('applied');
                        
                        if (data.notification.notification_count != 0) {
                            var notification_count = data.notification.notification_count;
                            var to_id = data.notification.to_id;
                            show_header_notification(notification_count, to_id);
                        }
                    }
                });
            }
            function applypopup(postid, userid) {
                $('.biderror .mes').html("<div class='pop_content'>Do you want to apply for this work?<div class='model_ok_cancel'><a class='okbtn' id=" + postid + " onClick='apply_post(" + postid + "," + userid + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                $('#bidmodal').modal('show');
            }
//CODE FOR APPLY POST END 
//ALL POPUP CLOSE USING ESC START
$(document).on('keydown', function (e) {
                if (e.keyCode === 27) {
                    $('#bidmodal').modal('hide');
                }
            });
//ALL POPUP CLOSE USING ESC END

//SCRIPT FOR NO POST ADD CLASS DESIGNER RELATED HEADER2 START
$(document).ready(function () {
                var nb = $('div.job-post-detail').length;
                if (nb == 0) {
                    $("#dropdownclass").addClass("no-post-h2");
                }
            });
//SCRIPT FOR NO POST ADD CLASS DESIGNER RELATED HEADER2 END 


