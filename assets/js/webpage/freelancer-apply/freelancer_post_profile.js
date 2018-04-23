
function profile_pic() {
    if (typeof FormData !== 'undefined') {
        // var fd = new FormData();
        var formData = new FormData($("#userimage")[0]);
//    fd.append("image", $("#profilepic")[0].files[0]);
//         files = this.files;
        $.ajax({
            // url: "<?php echo base_url(); ?>freelancer/user_image_insert",
            url: base_url + "freelancer/user_image_add",
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
//DESIGNATION START
function divClicked() {
    var divHtml = $(this).html();
    var editableText = $("<textarea/>");
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
//DESIGNATION END



//CHECK SEARCH KEYWORD AND LOCATION BLANK START
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
//CHECK SEARCH KEYWORD AND LOCATION BLANK END
//SAVE USER START
function savepopup(id) {
    save_user(id);
    $('.biderror .mes').html("<div class='pop_content'>Freelancer is successfully saved.");
    $('#bidmodal').modal('show');
}
function save_user(abc)
{
    $.ajax({
        type: 'POST',
        url: base_url + "freelancer/save_user1",
        data: 'user_id=' + abc,
        success: function (data) {
            $('.' + 'saveduser' + abc).html(data).addClass('butt_rec');
        }
    });

}
//SAVE USER END

function picpopup() {
    $('.biderror .mes').html("<div class='pop_content'>Please select only Image type File.(jpeg,jpg,png,gif)");
    $('#bidmodal').modal('show');
}

//ALL POPUP CLOSE USING ESC START
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


