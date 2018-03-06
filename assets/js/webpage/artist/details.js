

$(document).ready(function () {
    $("#artdesignation").validate({
        rules: {
            designation: {
                required: true,
            },
        },
        messages: {
            designation: {
                required: "Designation Is Required.",
            },
        },
    });
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

// Get the modal
var modal = document.getElementById('myModal');
// Get the button that opens the modal
var btn = document.getElementById("myBtn");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
// When the user clicks the button, open the modal 
btn.onclick = function () {
    modal.style.display = "block";
}
// When the user clicks on <span> (x), close the modal
span.onclick = function () {
    modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

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

function updateprofilepopup(id) {
    $('#bidmodal-2').modal('show');
}
