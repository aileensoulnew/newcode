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
$(document).ready(function () {
    business_userlist();
    $(window).scroll(function () {
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
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($(".page_number:last").val()) + 1;
                    business_userlist(pagenum);
                }
            }
        }
    });
});
var isProcessing = false;
function business_userlist(pagenum) {
    if (isProcessing) {
        return;
    }
    isProcessing = true;
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/ajax_userlist/?page=" + pagenum,
        data: {total_record: $("#total_record").val()},
        dataType: "html",
        beforeSend: function () {
            if (pagenum == 'undefined') {
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
$(document).ready(function () {
    $('html,body').animate({scrollTop: 330}, 500);
});
function followuser(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/follow",
        dataType: 'json',
        data: 'follow_to=' + clicked_id,
        success: function (data) {
            $('.' + 'fruser' + clicked_id).html(data.follow);
            $('.left_box_following_count').html(data.count);
            if (data.notification.notification_count != 0) {
                var notification_count = data.notification.notification_count;
                var to_id = data.notification.to_id;
                show_header_notification(notification_count,to_id);
            }

        }
    });
}

function unfollowuser(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/unfollow",
        dataType: 'json',
        data: 'follow_to=' + clicked_id,
        success: function (data) {
            $('.' + 'fruser' + clicked_id).html(data.follow);
            //$('#countfollow').html(data.count);
            $('.left_box_following_count').html(data.count);
        }
    });
}