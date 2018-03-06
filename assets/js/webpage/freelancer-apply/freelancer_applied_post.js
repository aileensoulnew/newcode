
//VALIDATION FOR PROFILE PIC START
//$(document).ready(function () {
//    $("#userimage").validate({
//        rules: {
//            profilepic: {
//                required: true,
//            },
//        },
//        messages: {
//            profilepic: {
//                required: "Photo Required",
//            },
//        },
//        submitHandler: profile_pic
//    });
//});
//VALIDATION FOR PROFILE PIC END
//UOPLOAD PROFILE PIC START
//function profile_pic() {
//    if (typeof FormData !== 'undefined') {
//        // var fd = new FormData();
//        var formData = new FormData($("#userimage")[0]);
////    fd.append("image", $("#profilepic")[0].files[0]);
////         files = this.files;
//        $.ajax({
//            // url: "<?php echo base_url(); ?>freelancer/user_image_insert",
//            url: base_url + "freelancer/user_image_add",
//            type: "POST",
//            data: formData,
//            contentType: false,
//            cache: false,
//            processData: false,
//            success: function (data)
//            {
//                $('#bidmodal-2').modal('hide');
//                $(".user-pic").html(data);
//                document.getElementById('profilepic').value = null;
//                //document.getElementById('profilepic').value == '';
//                $('#preview').prop('src', '#');
//                $('.popup_previred').hide();
//            },
//        });
//        return false;
//    }
//}
//UOPLOAD PROFILE PIC END
//CODE FOR RESPONES OF AJAX COME FROM CONTROLLER AND LAZY LOADER START
$(document).ready(function () {

    freelancerwork_applied();

    $(window).scroll(function () {
        //if ($(window).scrollTop() == $(document).height() - $(window).height()) {
        // if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
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

                    freelancerwork_applied(pagenum);
                }
            }
        }
    });

});
var isProcessing = false;
function freelancerwork_applied(pagenum)
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
        url: base_url + "freelancer/ajax_freelancer_applied_post?page=" + pagenum,
        data: {total_record: $("#total_record").val()},
        dataType: "html",
        beforeSend: function () {
           document.getElementById("loader").style.display = "block";
        },
        complete: function () {
           document.getElementById("loader").style.display = "none";
        },
        success: function (data) {
            $('.job-contact-frnd1').append(data);
            // second header class add for scroll
            var nb = $('.post-design-box').length;
            if (nb == 0) {
                $("#dropdownclass").addClass("no-post-h2");
            } else {
                $("#dropdownclass").removeClass("no-post-h2");
            }
            var numItems = $('.job-contact-frnd1 .all-job-box').length;
            // return false;
            if (numItems == 0) {
                $('.job-contact-frnd1').addClass('cust-border');
            }
            isProcessing = false;
        }
    });
}

//CODE FOR RESPONES OF AJAX COME FROM CONTROLLER AND LAZY LOADER END

//DESIGNATION START
function divClicked() {
    var divHtml = $(this).html();
    var editableText = $("<textarea/>");
    editableText.val(divHtml);
    $(this).replaceWith(editableText);
    editableText.focus();
    editableText.blur(editableTextBlurred);
}
function capitalize(s) {
    return s[0].toUpperCase() + s.slice(1);
}
function editableTextBlurred() {
    var html = $(this).val();
    var viewableText = $("<a>");
    if (html.match(/^\s*$/) || html == '') {
        html = "Designation";
    }
    viewableText.html(capitalize(html));
    $(this).replaceWith(viewableText);
    // setup the click event for this new div
    viewableText.click(divClicked);
    $.ajax({
        url: base_url + "freelancer/designation",
        type: "POST",
        data: {"designation": html},
        success: function (response) {
        }
    });
}
$(document).ready(function () {
    $("a.designation").click(divClicked);

});

//$(window).on('load', function () {
//     var time = 400;
//      setTimeout(function() { 
//      var numItems = $('.job-contact-frnd1 .all-job-box').length;
//     // return false;
//      if(numItems == 0){
//          $('.job-contact-frnd1').addClass('cust-border');
//      }
//      },time);
//     
// });


//DESIGNATION END
////CHECK SEARCH KEYWORD AND LOCATION BLANK START
//function checkvalue() {
//    var searchkeyword = $.trim(document.getElementById('tags').value);
//    var searchplace = $.trim(document.getElementById('searchplace').value);
//    if (searchkeyword == "" && searchplace == "") {
//        return false;
//    }
//}
//function check() {
//    var keyword = $.trim(document.getElementById('tags1').value);
//    var place = $.trim(document.getElementById('searchplace1').value);
//    if (keyword == "" && place == "") {
//        return false;
//    }
//}
////CHECK SEARCH KEYWORD AND LOCATION BLANK END

//function readURL(input) {
//    if (input.files && input.files[0]) {
//        var reader = new FileReader();
//        reader.onload = function (e) {
//            document.getElementById('preview').style.display = 'block';
//            $('#preview').attr('src', e.target.result);
//            $('.popup_previred').show();
//        }
//        reader.readAsDataURL(input.files[0]);
//    }
//}
//$("#profilepic").change(function () {
//    profile = this.files;
//    if (!profile[0].name.match(/.(jpg|jpeg|png|gif)$/i)) {
//        $('#profilepic').val('');
//        picpopup();
//        return false;
//    } else {
//        readURL(this);
//    }
//});
//UPLOAD PROFILE PIC CODE END

function picpopup() {
    $('.biderror .mes').html("<div class='pop_content'>Please select only Image type File.(jpeg,jpg,png,gif)");
    $('#bidmodal').modal('show');
}

//REMOVE POST START
function remove_post(abc)
{
    $.ajax({
        type: 'POST',
        url: base_url + "freelancer/freelancer_delete_apply",
        data: 'app_id=' + abc,
        success: function (data) {
            $('#' + 'removeapply' + abc).html(data);
            $('#' + 'removeapply' + abc).remove();
            var numItems = $('.job-contact-frnd1 .all-job-box').length;
            if (numItems == '0') {
                var nodataHtml = '<div class="art-img-nn"><div class="art_no_post_img"><img src="../assets/img/free-no1.png"></div><div class="art_no_post_text">No Applied projects Found.</div></div>';

                //  var nodataHtml = "<div class='text-center rio'><h4 class='page-heading  product-listing' style='border:0px;margin-bottom: 11px;'>No Saved Freelancer Found.</h4></div>";
                $('.job-contact-frnd1').html(nodataHtml);
            }
        }
    });
}
function removepopup(id) {
    $('.biderror .mes').html("<div class='pop_content'>Do you want to remove this post?<div class='model_ok_cancel'><a class='okbtn' id=" + id + " onClick='remove_post(" + id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('#bidmodal').modal('show');
}

//REMOVE POST END

//ALL POPUP CLOSE USING ESC START
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
//ALL POPUP CLOSE USING ESC END
//FOR SCROLL PAGE AT PERTICULAR POSITION JS START
$(document).ready(function () {
    $('html,body').animate({scrollTop: 265}, 100);
});
//FOR SCROLL PAGE AT PERTICULAR POSITION JS END
