//CODE FOR SAVE POST START
function savepopup(id) {
    save_post(id);
    $('.biderror .mes').html("<div class='pop_content'>Your project is successfully saved.");
    $('#bidmodal').modal('show');
}
function save_post(abc)
{
    $.ajax({
        type: 'POST',
        url: base_url + "freelancer_hire/save_user",
        data: 'post_id=' + abc,
        success: function (data) {
            $('.' + 'savedpost' + abc).html(data).addClass('saved');
        }
    });
}
//CODE FOR SAVE POST END
//CODE FOR APPLY POST START
function applypopup(postid, userid) {
   
    $('.biderror .mes').html("<div class='pop_content'>Are you sure you want to apply this project?<div class='model_ok_cancel'><a class='okbtn' id=" + postid + " onClick='apply_post(" + postid + "," + userid + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('#bidmodal').modal('show');
}
function apply_post(abc, xyz) {
    var alldata = 'all';
    var user = xyz;
    $.ajax({
        type: 'POST',
        url: base_url + "freelancer/apply_insert",
        data: 'post_id=' + abc + '&allpost=' + alldata + '&userid=' + user,
        dataType:'json',
        success: function (data) {
            
            $('.savedpost' + abc).hide();
            $('.applypost').html(data.status);
            $('.applypost').attr('disabled', 'disabled');
            $('.applypost' + abc).attr('onclick', 'myFunction()');
            $('.applypost').addClass('applied');
            
            if (data.notification.notification_count != 0) {
                            var notification_count = data.notification.notification_count;
                            var to_id = data.notification.to_id;
                            show_header_notification(notification_count, to_id);
                        }
        }
    });
}
//CODE FOR APPLY POST END
