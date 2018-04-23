//ALL POPUP CLOSE BY ESC START
$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        $('#bidmodal').modal('hide');
    }
});
$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        $('#bidmodal-2').modal('hide');
    }
});
//ALL POPUP CLOSE BY ESC END


//CODE FOR RESPONES OF AJAX COME FROM CONTROLLER AND LAZY LOADER START
$(document).ready(function () {
    freelancerhire_save();
    $(window).scroll(function () {
        //if ($(window).scrollTop() == $(document).height() - $(window).height()) {
       // if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
        if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.7){
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

                    freelancerhire_save(pagenum);
                }
            }
        }
    });

});
var isProcessing = false;
function freelancerhire_save(pagenum)
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
        url: base_url + "freelancer/ajax_freelancer_save?page=" + pagenum,
        data: {total_record: $("#total_record").val()},
        dataType: "html",
        beforeSend: function () {
            if (pagenum == 'undefined') {
                $(".contact-frnd-post").prepend('<p style="text-align:center;"><img class="loader" src="' + base_url + 'images/loading.gif"/></p>');
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
//CODE FOR RESPONES OF AJAX COME FROM CONTROLLER AND LAZY LOADER END

//CODE FOR DESIGNATION START
function divClicked() {
    var divHtml = $(this).html();
    var editableText = $("<textarea />");
    editableText.val(divHtml);
    $(this).replaceWith(editableText);
    editableText.focus();
    // setup the blur event for this new textarea
    editableText.blur(editableTextBlurred);
}

function editableTextBlurred() {
    var html = $(this).val();
    var viewableText = $("<a>");
    if (html.match(/^\s*$/) || html == '') {
        html = "Current Work";
    }
    viewableText.html(html);
    $(this).replaceWith(viewableText);
    // setup the click event for this new div
    viewableText.click(divClicked);

    $.ajax({
        url: base_url + "freelancer/hire_designation",
        type: "POST",
        data: {"designation": html},
        success: function (response) {

        }
    });
}

$(document).ready(function () {
    $("a.designation").click(divClicked);
});

//CODE FOR DESIGNATION END

//CHECK FOR SEAH KEYWORD AND LOCATION BLANK START
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
//CHECK FOR SEAH KEYWORD AND LOCATION BLANK END

//REMOVE USER START
function remove_user(abc)
{
    $.ajax({
        type: 'POST',
        url: base_url + "freelancer/remove_save",
        data: 'save_id=' + abc,
        success: function (data) {
            $('#' + 'removeapply' + abc).html(data);
            $('#' + 'removeapply' + abc).parent().removeClass();
            var numItems = $('.contact-frnd-post .job-contact-frnd').length;
            if (numItems == '0') {
                var nodataHtml = '<div class="art-img-nn"><div class="art_no_post_img"><img src="../img/free-no1.png"></div><div class="art_no_post_text">No Saved Freelancer Found</div></div>';
                $('.contact-frnd-post').html(nodataHtml);
            }
        }
    });
}

function removepopup(id) {
    $('.biderror .mes').html("<div class='pop_content'>Do you want to remove this freelancer?<div class='model_ok_cancel'><a class='okbtn' id=" + id + " onClick='remove_user(" + id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('#bidmodal').modal('show');
}
//REMOVE USER END
//CODE FOR PROFILE PIC AND COVERPIC IMG TYPE POPUP START
function picpopup() {
    $('.biderror .mes').html("<div class='pop_content'>Please select only Image type File.(jpeg,jpg,png,gif)");
    $('#bidmodal').modal('show');
}
//CODE FOR PROFILE PIC AND COVERPIC IMG TYPE POPUP END

//FOR SCROLL PAGE AT PERTICULAR POSITION JS START
$(document).ready(function () {
    $('html,body').animate({scrollTop: 265}, 100);
});
//FOR SCROLL PAGE AT PERTICULAR POSITION JS END
//UOPLOAD PROFILE PIC START
function profile_pic() {
    if (typeof FormData !== 'undefined') {
        // var fd = new FormData();
        var formData = new FormData($("#userimage")[0]);
//    fd.append("image", $("#profilepic")[0].files[0]);
//         files = this.files;
        $.ajax({
            // url: "<?php echo base_url(); ?>freelancer/user_image_insert",
            url: base_url + "freelancer/user_image_insert",
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data)
            {
                $('#bidmodal-2').modal('hide');
                $(".user-pic").html(data);
                document.getElementById('profilepic').value = null;
                //document.getElementById('profilepic').value == '';
                $('#preview').prop('src', '#');
                $('.popup_previred').hide();
            },
        });
        return false;
    }
}
//UOPLOAD PROFILE PIC END



