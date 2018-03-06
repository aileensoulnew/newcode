$(document).ready(function () {
    business_following(slug_id);

    $(window).scroll(function () {
        //if ($(window).scrollTop() == $(document).height() - $(window).height()) {
//        if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) {

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
                    business_following(slug_id, pagenum);
                }
            }
        }
    });

});
var isProcessing = false;
function business_following(slug_id, pagenum)
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
        url: base_url + "business_profile/ajax_following/" + slug_id + '?page=' + pagenum,
        data: {total_record: $("#total_record").val()},
        dataType: "html",
        beforeSend: function () {
            if (pagenum == 'undefined') {
                $(".contact-frnd-post").prepend('<p style="text-align:center;"><img class="loader" src="' + base_url + 'assets/images/loading.gif"/></p>');
            } else {
                $('#loader').show();
            }
        },
        complete: function () {
            $('#loader').hide();
        },
        success: function (data) {
            $('.loader').remove();
            $('.contact-frnd-post').append(data);

            // second header class add for scroll
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
// BUSUINESS SEARCH SCRIPT END

// follow user script start 
function followuser(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/follow",
        data: 'follow_to=' + clicked_id,
        success: function (data) {
            $('.' + 'fr' + clicked_id).html(data);
        }
    });
}
//follow user script end 
// Unfollow user script start 
function unfollowuser(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/unfollow",
        data: 'follow_to=' + clicked_id,
        success: function (data) {
            $('.' + 'fr' + clicked_id).html(data);
        }
    });
}
// Unfollow user script end 
// follow user script start 
function followuser_two(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/follow_two",
        data: 'follow_to=' + clicked_id + '&profile_slug=' + slug_id,
        dataType: 'json',
        success: function (data) {
            $('.' + 'fr' + clicked_id).html(data.follow_html);
            $('#' + 'countfollow').html('(' + data.following_count + ')');
            $('#' + 'countfollower').html('(' + data.follower_count + ')');
            // $('#' + 'frfollow' + clicked_id).html(data);
            if (data.notification.notification_count != 0) {
                var notification_count = data.notification.notification_count;
                var to_id = data.notification.to_id;
                show_header_notification(notification_count, to_id);
            }
        }
    });
}
// follow like script end 
// Unfollow user script start 
function unfollowuser_two(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/unfollow_two",
        data: 'follow_to=' + clicked_id,
        dataType: 'json',
        success: function (data) {
            $('.' + 'fr' + clicked_id).html(data.unfollow_html);
            $('#' + 'countfollow').html('(' + data.unfollowing_count + ')');
            $('#' + 'countfollower').html('(' + data.unfollower_count + ')');
            //            $('#' + 'frfollow' + clicked_id).html(data);
        }
    });
}
// follow like script end 

// follow user script start 
function followuser_list_two(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/follow_two",
        data: 'follow_to=' + clicked_id + '&profile_slug=' + slug_id + '&is_listing=1',
        dataType: 'json',
        success: function (data) {
            $('.' + 'follow_btn_' + clicked_id).html(data.follow_html);
            $('#' + 'countfollow').html('(' + data.following_count + ')');
            $('#' + 'countfollower').html('(' + data.follower_count + ')');
            $('.' + 'follow_btn_' + clicked_id).removeClass('user_btn');
            $('.' + 'follow_btn_' + clicked_id).addClass('user_btn_h');
            $('#' + 'unfollow' + clicked_id).html('');
            $('.' + 'fruser' + clicked_id).html(data.follow_html);
            if (data.notification.notification_count != 0) {
                var notification_count = data.notification.notification_count;
                var to_id = data.notification.to_id;
                show_header_notification(notification_count, to_id);
            }
        }
    });
}
// follow like script end 
// Unfollow user script start 
function unfollowuser_list_two(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/unfollow_two",
        data: 'follow_to=' + clicked_id + '&profile_slug=' + slug_id + '&is_listing=1',
        dataType: 'json',
        success: function (data) {
            $('.' + 'follow_btn_' + clicked_id).html(data.unfollow_html);
            $('#' + 'countfollow').html('(' + data.unfollowing_count + ')');
            $('#' + 'countfollower').html('(' + data.unfollower_count + ')');
            $('.' + 'follow_btn_' + clicked_id).removeClass('user_btn_h');
            $('.' + 'follow_btn_' + clicked_id).removeClass('user_btn_f');
            $('.' + 'follow_btn_' + clicked_id).addClass('user_btn_i');
        }
    });
}
// follow like script end 

// Unfollow own userlist user script start 
function unfollowuser_list(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/unfollow_following",
        dataType: 'json',
        data: 'follow_to=' + clicked_id,
        success: function (data) {
            $('.' + 'frusercount').html(data.unfollow);
            $('#' + 'countfollow').html('(' + data.notcount + ')');
            if (data.notcount == 0) {
                $('.' + 'contact-frnd-post').html(data.notfound);
            } else {
                $('#' + 'removefollow' + clicked_id).fadeOut(4000);
            }
        }
    });
}

$(document).ready(function () {
    $('html,body').animate({scrollTop: 330}, 500);
});
//contact person script start 
function contact_person_query(clicked_id, status) {


    $.ajax({
        type: 'POST',
        //url: '<?php echo base_url() . "business_profile/contact_person_query" ?>',
        url: base_url + "business_profile/contact_person_query",

        data: 'toid=' + clicked_id + '&status=' + status,
        success: function (data) { //alert(data);
            // return data;
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
        //url: '<?php echo base_url() . "business_profile/contact_person" ?>',
        url: base_url + "business_profile/contact_person",

        data: 'toid=' + clicked_id,
        dataType: 'json',
        success: function (data) {
            //   alert(data);
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
        //$( "#bidmodal" ).hide();
        $('#query').modal('hide');
        //$('.modal-post').show();
    }
});
