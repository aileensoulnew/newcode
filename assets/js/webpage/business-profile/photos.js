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


/* FOLLOW USER START */
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
/* FOLLOW USER END */

/* UNFOLLOW USER START */
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
/* UNFOLLOW USER END */

$(document).keydown(function (e) {
    if (!e)
        e = window.event;
    if (e.keyCode == 27 || e.charCode == 27) {
        closeModal();
    }
});
// contact person script start 
function contact_person_query(clicked_id, status) {
//alert("hii");

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


//For blocks or images of size, you can use $(document).ready
$(document).ready(function () {
    $('.blocks').jMosaic({items_type: "li", margin: 0});
    $('.pictures').jMosaic({min_row_height: 150, margin: 3, is_first_big: true});
});


function openModal() {
    document.getElementById('myModal1').style.display = "block";
    $('body').addClass('modal-open');
}

function closeModal() {
    document.getElementById('myModal1').style.display = "none";
    $('body').removeClass('modal-open');
}

var slideIndex = 1;
showSlides(slideIndex);

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

function h(e) {
    $(e).css({'height': '29px', 'overflow-y': 'hidden'}).height(e.scrollHeight);
}
$('.textarea').each(function ()
{
    h(this);
}).on('input', function () {
    h(this);
});


$(document).keydown(function (e) {
    if (!e)
        e = window.event;
    if (e.keyCode == 27 || e.charCode == 27) {
        closeModal();
    }
});


j$('#myModal').modal({backdrop: 'true'});


var _onPaste_StripFormatting_IEPaste = false;

function OnPaste_StripFormatting(elem, e) {

    if (e.originalEvent && e.originalEvent.clipboardData && e.originalEvent.clipboardData.getData) {
        e.preventDefault();
        var text = e.originalEvent.clipboardData.getData('text/plain');
        window.document.execCommand('insertText', false, text);
    } else if (e.clipboardData && e.clipboardData.getData) {
        e.preventDefault();
        var text = e.clipboardData.getData('text/plain');
        window.document.execCommand('insertText', false, text);
    } else if (window.clipboardData && window.clipboardData.getData) {
        // Stop stack overflow
        if (!_onPaste_StripFormatting_IEPaste) {
            _onPaste_StripFormatting_IEPaste = true;
            e.preventDefault();
            window.document.execCommand('ms-pasteTextOnly', false);
        }
        _onPaste_StripFormatting_IEPaste = false;
    }

}
