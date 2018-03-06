
$(document).ready(function () {
    artistic_followers(slug_id);

    $(window).scroll(function () {
        //if ($(window).scrollTop() == $(document).height() - $(window).height()) {
        if ($(window).scrollTop() + $(window).height() >= $(document).height()) {

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
                    artistic_followers(slug_id, pagenum);
                }
            }
        }
    });

});
var isProcessing = false;
function artistic_followers(slug_id, pagenum)
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
        url: base_url + "artist/ajax_followers/" + slug_id + '?page=' + pagenum,
        data: {total_record: $("#total_record").val()},
        dataType: "html",
        beforeSend: function () {
            // if (pagenum == 'undefined') {
            //     $(".job-contact-frnd").prepend('<p style="text-align:center;"><img class="loader" src="' + base_url + 'images/loading.gif"/></p>');
            // } else {
            $('#loader').show();
            // }
        },
        complete: function () {
            $('#loader').hide();
        },
        success: function (data) {
            $('.loader').remove();
            $('.job-contact-frnd').append(data);
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
//select2 autocomplete start for skill
$('#searchskills').select2({
    placeholder: 'Find Your Skills',
    ajax: {
        url: base_url + "artist/keyskill",
        //url: "<?php echo base_url(); ?>artist/keyskill",
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

// follow user script start
function followuser(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "artist/follow_two",
        //url:'<?php echo base_url() . "artist/follow_two" ?>',
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
        //url:'<?php echo base_url() . "artist/unfollow_two" ?>',
        data: 'follow_to=' + clicked_id,
        success: function (data) {
            $('.' + 'fruser' + clicked_id).html(data);
        }
    });
}
function updateprofilepopup(id) {
    $('#bidmodal-2').modal('show');
}

function followuser_two(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "artist/followtwo",
        dataType: 'json',
        data: 'follow_to=' + clicked_id,
        success: function (data) {   
            $('#' + 'frfollow' + clicked_id).html(data.follow);
            $('#' + 'countfollow').html(data.count);
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
        url: base_url + "artist/unfollowtwo",
        // url: '<?php echo base_url() . "artist/unfollowtwo" ?>',
        dataType: 'json',
        data: 'follow_to=' + clicked_id,
        success: function (data) {
            $('#' + 'frfollow' + clicked_id).html(data.follow);
            $('#' + 'countfollow').html(data.count);

        }
    });
}

function picpopup() {
    $('.biderror .mes').html("<div class='pop_content'>Only Image Type Supported");
    $('#bidmodal').modal('show');
}
$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        //$( "#bidmodal" ).hide();
        $('#bidmodal-2').modal('hide');
    }
});
// followers data using ajax script start
//For Scroll page at perticular position js Start
$(document).ready(function () {
    $('html,body').animate({scrollTop: 265}, 100);
});    