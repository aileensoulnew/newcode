

function checkvalue() {
    //alert("hi");
    var searchkeyword = $.trim(document.getElementById('tags').value);
    var searchplace = $.trim(document.getElementById('searchplace').value);
    // alert(searchkeyword);
    // alert(searchplace);
    if (searchkeyword == "" && searchplace == "") {
        //alert('Please enter Keyword');
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
    $('.blocks').jMosaic({items_type: "li", margin: 0});
    $('.pictures').jMosaic({min_row_height: 150, margin: 3, is_first_big: true});
    $('video, audio').mediaelementplayer();
});


function updateprofilepopup(id) {
    $('#bidmodal-2').modal('show');
}



function followuser(clicked_id)
{ //alert(clicked_id);

    $.ajax({
        type: 'POST',
        url: base_url + "artist/follow_two",
        data: 'follow_to=' + clicked_id,
        dataType: 'json',
        success: function (data) {
            $('.' + 'fruser' + clicked_id).html(data.follow_html);
            if (data.notification.notification_count != 0) {
                var notification_count = data.notification.notification_count;
                var to_id = data.notification.to_id;
                show_header_notification(notification_count, to_id);
            }
        }
    });
}



$(document).ready(function () {
    $("html,body").animate({scrollTop: 350}, 100); //100ms for example
});

function picpopup() {

    $('.biderror .mes').html("<div class='pop_content'>Only Image Type Supported");
    $('#bidmodal').modal('show');
}


$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        $('#bidmodal-2').modal('hide');
    }
});


$(document).ready(function () {
    $('html,body').animate({scrollTop: 265}, 100);
});

