//ALL POPUP CLOSE USING ESC START
$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        //$( "#bidmodal" ).hide();
        $('#bidmodal-2').modal('hide');
    }
});
//ALL POPUP CLOSE USING ESC END

//CODE FOR DESIGNATION START
function divClicked() {
    var divHtml = $(this).html();
    var editableText = $("<textarea />");
    editableText.val(divHtml);
    $(this).replaceWith(editableText);
    editableText.focus();
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
//
//$("#profilepic").change(function () {
//    // code for not supported file TYPE
//    profile = this.files;
//    if (!profile[0].name.match(/.(jpg|jpeg|png|gif)$/i)) {
//        $('#profilepic').val('');
//        picpopup();
//        return false;
//    } else {
//        readURL(this);
//    }
//    // end supported code 
//});
//CODE FOR UPLOAD PROFILE PIC END

//CODE FOR CHECK SEARCH KEYWORD AND LOCATION BLANK START
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
//CODE FOR CHECK SEARCH KEYWORD AND LOCATION BLANK END


//CODE FOR SHOW POPUP OF WHEN PROFILE PIC OR COVER PIC IMG TYPE NOT SUPPORED START
function picpopup() {
    $('.biderror .mes').html("<div class='pop_content'>Please select only Image File Type.(jpeg,jpg,png,gif)");
    $('#bidmodal').modal('show');
}
//CODE FOR SHOW POPUP OF WHEN PROFILE PIC AND COVER PIC IMG TYPE NOT DUPPORTED END


//FOR SCROLL PAGE AT PERTICULAR POSITION IS START
$(document).ready(function () {
    $('html,body').animate({scrollTop: 265}, 100);
});
//FOR SCROLL PAGE AT PERTICUKAR POSITION IS END




//UOPLOAD PROFILE PIC START
//function profile_pic() {
//    if (typeof FormData !== 'undefined') {
//        // var fd = new FormData();
//        var formData = new FormData($("#userimage")[0]);
////    fd.append("image", $("#profilepic")[0].files[0]);
////         files = this.files;
//        $.ajax({
//            // url: "<?php echo base_url(); ?>freelancer/user_image_insert",
//            url: base_url + "freelancer/user_image_insert",
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


