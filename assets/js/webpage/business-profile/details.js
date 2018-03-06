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

// END OF BUSINESS SEARCH AUTO FILL 


// follow user script start 
function followuser_two(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/follow_two",
        data: 'follow_to=' + clicked_id,
        dataType: 'json',
        success: function (data) {
            $('.' + 'fr' + clicked_id).html(data.follow_html);
            $('#' + 'countfollow').html('(' + data.following_count + ')');
            $('#' + 'countfollower').html('(' + data.follower_count + ')');
            //$('.' + 'fr' + clicked_id).html(data);
            if (data.notification.notification_count != 0) {
                var notification_count = data.notification.notification_count;
                var to_id = data.notification.to_id;
                show_header_notification(notification_count, to_id);
            }
        }
    });
}
// follow user script end 
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
            //$('.' + 'fr' + clicked_id).html(data);
        }
    });
}
// Unfollow user script end 

function openModal() {
    document.getElementById('myModal1').style.display = "block";
    $('body').addClass('modal-open');
}
function closeModal() {
    document.getElementById('myModal1').style.display = "none";
    $('body').removeClass('modal-open');
}

var n = 1;
//showSlides(slideIndex);

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("demo");
    var captionText = document.getElementById("caption");
    if (n > slides.length) {
        slideIndex = 1
    }
    if (n < 1) {
        slideIndex = slides.length
    }
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";
    captionText.innerHTML = dots[slideIndex - 1].alt;
}

$(document).ready(function () {
    $("#myBtn").click(function () {
        $("#myModal").modal();
    });
});

// scroll page script start 
//For Scroll page at perticular position js Start
$(document).ready(function () {
    $('html,body').animate({scrollTop: 330}, 500);
});
//For Scroll page at perticular position js End
// scroll page script end 


// all popup close close using esc start 
$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        closeModal();
    }
});
// all popup close close using esc end 

// all popup close close using esc start 
$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        $('#myModal').modal('hide');
    }
});
// all popup close close using esc end


$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        //$( "#bidmodal" ).hide();
        $('#query').modal('hide');
        //$('.modal-post').show();
    }
});




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




    