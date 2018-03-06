function checkvalue() {
    var searchkeyword = $.trim(document.getElementById('tags').value);
    var searchplace = $.trim(document.getElementById('searchplace').value);
    if (searchkeyword == "" && searchplace == "") {
        return false;
    }
}
function check() {
    var keyword = $.trim(document.getElementById('tags1').value);
    var place = $.trim(document.getElementById('searchplace1').value);
    if (keyword == "" && place == "") {
        return false;
    }
}
function followuser_two(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/follow_two",
        data: 'follow_to=' + clicked_id,
        success: function (data) {
            $('.' + 'fr' + clicked_id).html(data);
            if (data.notification.notification_count != 0) {
                var notification_count = data.notification.notification_count;
                var to_id = data.notification.to_id;
                show_header_notification(notification_count, to_id);
            }
        }
    });
}
function unfollowuser_two(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/unfollow_two",
        data: 'follow_to=' + clicked_id,
        success: function (data) {
            $('.' + 'fr' + clicked_id).html(data);
        }
    });
}
function contact_person_query(clicked_id, status) {
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/contact_person_query",
        data: 'toid=' + clicked_id + '&status=' + status,
        success: function (data) {
            contact_person_model(clicked_id, status, data);
        }
    });
}
function contact_person_model(clicked_id, status, data) {
    if (data == 1) {
        if (status == 'pending') {
            $('.biderror .mes').html("<div class='pop_content'> Do you want to cancel  contact request?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='contact_person(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
            $('#bidmodal').modal('show');
        } else if (status == 'confirm') {
            $('.biderror .mes').html("<div class='pop_content'> Do you want to remove this user from your contact list?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='contact_person(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
            $('#bidmodal').modal('show');
        } else {
            contact_person(clicked_id);
        }
    } else {
        $('#query .mes').html("<div class='pop_content'>Sorry, we can't process this request at this time.");
        $('#query').modal('show');
    }
}
function contact_person(clicked_id) {
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/contact_person",
        data: 'toid=' + clicked_id,
        dataType: 'json',
        success: function (data) {
            $('#contact_per').html(data);
            if (data.co_notification.co_notification_count != 0) {
                var co_notification_count = data.co_notification.co_notification_count;
                var co_to_id = data.co_notification.co_to_id;
                show_contact_notification(co_notification_count, co_to_id);
            }
        }
    });
}
$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        $('#query').modal('hide');
    }
});
$(document).ready(function () {
    $('.blocks').jMosaic({items_type: "li", margin: 0});
    $('.pictures').jMosaic({min_row_height: 150, margin: 3, is_first_big: true});
});
$(window).resize(function () {
});
$(document).ready(function () {
    $('html,body').animate({
        scrollTop: 330}, 500);
});


 // video user show list

 function count_videouser(file_id, post_id){ 

  var vid = document.getElementById("show_video" + file_id);

      if (vid.paused) {
         vid.play(); 
          $.ajax({
            type: 'POST',
            url: base_url + "business_profile/showuser",
            data: 'post_id=' + post_id + '&file_id=' + file_id,
            dataType: "html",
            success: function (data) { 
              $('#' + 'viewvideouser' + post_id).html(data);       
            }
        });
       }
    else {
      vid.pause(); 
    }
 }

function playtime(file_id, post_id){
               $.ajax({
                        type: 'POST',
                        url: base_url + "business_profile/showuser",
                        data: 'post_id=' + post_id + '&file_id=' + file_id,
                        dataType: "html",
                        success: function (data) { 
                          $('#' + 'viewvideouser' + post_id).html(data);       
                        }
                    });
}