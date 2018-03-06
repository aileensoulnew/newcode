

function updateprofilepopup(id) {
    $('#bidmodal-2').modal('show');
}


function divClicked() {
    var divHtml = $(this).html();
    divHtml = divHtml.trim();
    var editableText = $("<textarea />");
    editableText.val(divHtml);
    $(this).replaceWith(editableText);
    editableText.focus();
    editableText.blur(editableTextBlurred);
}

function editableTextBlurred() {
    var html = $(this).val();
    html = html.trim();
    var viewableText = $("<a>");
    if (html.match(/^\s*$/) || html == '') {
        html = "Current Work";
    }
    viewableText.html(html);
    $(this).replaceWith(viewableText);
    viewableText.click(divClicked);
    $.ajax({
        url: base_url + "artist/art_designation",
        //url: "<?php echo base_url(); ?>artist/art_designation",
        type: "POST",
        data: {"designation": html},
        success: function (response) {
        }
    });
}

$(document).ready(function () {
    $("a.designation").click(divClicked);
});



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

$('#searchplace').select2({

    placeholder: 'Find Your Location',
    maximumSelectionLength: 1,
    ajax: {

        url: base_url + "artist/location",
        // url: "<?php echo base_url(); ?>artist/location",
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: true
    }
});
$(document).ready(function () {
    $('.blocks').jMosaic({items_type: "li", margin: 0});
    $('.pictures').jMosaic({min_row_height: 150, margin: 3, is_first_big: true});
});

function followuser(clicked_id)
{
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
function unfollowuser(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "artist/unfollow_two",
        //url: '<?php echo base_url() . "artist/unfollow_two" ?>',
        data: 'follow_to=' + clicked_id,
        success: function (data) {
            $('.' + 'fruser' + clicked_id).html(data);
        }
    });
}


$(document).ready(function () {
    $('video').mediaelementplayer({
        alwaysShowControls: false,
        videoVolume: 'horizontal',
        features: ['playpause', 'progress', 'volume', 'fullscreen']
    });
});

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