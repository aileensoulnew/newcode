$(document).ready(function () {
    business_dashboard_post(slug);
    GetBusPhotos();
    GetBusVideos();
    GetBusAudios();
    GetBusPdf();

    $(window).scroll(function () {
        //if ($(window).scrollTop() == $(document).height() - $(window).height()) {
//        if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
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
                    business_dashboard_post(slug, pagenum);
                }
            }
        }
    });
})(jQuery);
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


// Upload Post start
jQuery(document).ready(function ($) {
    var bar = $('#bar');
    var percent = $('#percent');
    var options = {
        beforeSend: function () {
            document.getElementById("myModal3").style.display = "none";
            document.getElementById("progress_div").style.display = "block";
            var percentVal = '0%';
            bar.width(percentVal)
            percent.html(percentVal);
        },
        uploadProgress: function (event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal)
            percent.html(percentVal);
        },
        success: function () {
            var percentVal = '100%';
            bar.width(percentVal)
            percent.html(percentVal);
        },
        complete: function (response) { //alert(response.responseText);

            document.getElementById('test-upload_product').value = '';
            document.getElementById('test-upload_des').value = '';
            document.getElementById('file-1').value = '';
            $("input[name='text_num']").val(50);
            $(".file-preview-frame").hide();
            // Output AJAX response to the div container

//                    $('#progress_div').fadeOut('5000').remove();
            document.getElementById("progress_div").style.display = "none";
            $(".business-all-post").prepend(response.responseText);

            GetBusPhotos();
            GetBusVideos();
            GetBusAudios();
            GetBusPdf();

            // second header class add for scroll
            var nb = $('.post-design-box').length;
            if (nb == 0) {
                $("#dropdownclass").addClass("no-post-h2");
            } else {
                $("#dropdownclass").removeClass("no-post-h2");
            }
            $('html, body').animate({scrollTop: $(".upload-image-messages").offset().top - 100}, 150);

        }
    };
    // Submit the form
    $(".dashboard-upload-image-form").ajaxForm(options);

    return false;
});

function business_dashboard_post(slug) {
    $.ajax({
        type: 'POST',
        url: base_url + "business_userprofile/business_user_dashboard_post/" + slug,
        data: '',
        dataType: "html",
        beforeSend: function () {
            $(".business-all-post").prepend('<p style="text-align:center;"><img class="loader" src="' + base_url + 'assets/images/loading.gif"/></p>');
        },
        success: function (data) {
            $('.loader').remove();
            $('.business-all-post').html(data);

            // second header class add for scroll
            var nb = $('.post-design-box').length;
            if (nb == 0) {
                $("#dropdownclass").addClass("no-post-h2");
            } else {
                $("#dropdownclass").removeClass("no-post-h2");
            }
        }
    });
}

function GetBusPhotos() {

    $.ajax({
        type: 'POST',
        url: base_url + "business_userprofile/bus_user_photos",
        data: 'bus_slug=' + slug,
        beforeSend: function () {
            $(".bus_photos").html('<p style="text-align:center;"><img class="loader" src="' + base_url + 'assets/images/loading.gif"/></p>');
        },
        success: function (data) {
//            alert(data);
            $('.loader').remove();
            $('.bus_photos').html(data);
        }
    });
}

function GetBusVideos() {
    $.ajax({
        type: 'POST',
        url: base_url + "business_userprofile/bus_user_videos",
        data: 'bus_slug=' + slug,
        beforeSend: function () {
            $(".bus_videos").html('<p style="text-align:center;"><img class="loader" src="' + base_url + 'assets/images/loading.gif"/></p>');
        },
        success: function (data) {
            $('.loader').remove();
            $('.bus_videos').html(data);
        }
    });
}

function GetBusAudios() {
    $.ajax({
        type: 'POST',
        url: base_url + "business_userprofile/bus_user_audio",
        data: 'bus_slug=' + slug,
        beforeSend: function () {
            $(".bus_audios").html('<p style="text-align:center;"><img class="loader" src="' + base_url + 'assets/images/loading.gif"/></p>');
        },
        success: function (data) {
            $('.loader').remove();
            $('.bus_audios').html(data);
        }
    });
}

function GetBusPdf() {
    $.ajax({
        type: 'POST',
        url: base_url + "business_userprofile/bus_user_pdf",
        data: 'bus_slug=' + slug,
        beforeSend: function () {
            $(".bus_pdf").html('<p style="text-align:center;"><img class="loader" src="' + base_url + 'assets/images/loading.gif"/></p>');
        },
        success: function (data) {
            $('.loader').remove();
            $('.bus_pdf').html(data);
        }
    });
}


$('#file-fr').fileinput({
    language: 'fr',
    uploadUrl: '#',
    allowedFileExtensions: ['jpg', 'jpeg', 'PNG', 'gif', 'png', 'psd', 'bmp', 'tiff', 'iff', 'xbm', 'webp', 'mp4', 'mp3', 'pdf']
});
$('#file-es').fileinput({
    language: 'es',
    uploadUrl: '#',
    allowedFileExtensions: ['jpg', 'jpeg', 'PNG', 'gif', 'png', 'psd', 'bmp', 'tiff', 'iff', 'xbm', 'webp', 'mp4', 'mp3', 'pdf']
});
$("#file-1").fileinput({
    uploadUrl: '#',
    allowedFileExtensions: ['jpg', 'jpeg', 'PNG', 'gif', 'png', 'psd', 'bmp', 'tiff', 'iff', 'xbm', 'webp', 'mp4', 'mp3', 'pdf'],
    overwriteInitial: false,
    maxFileSize: 1000000,
    maxFilesNum: 10,
    slugCallback: function (filename) {
        return filename.replace('(', '_').replace(']', '_');
    }
});
$(".btn-warning").on('click', function () {
    var $el = $("#file-4");
    if ($el.attr('disabled')) {
        $el.fileinput('enable');
    } else {
        $el.fileinput('disable');
    }
});
$(document).ready(function () {
    $("#test-upload").fileinput({
        'showPreview': false,
        'allowedFileExtensions': ['jpg', 'jpeg', 'PNG', 'gif', 'png', 'psd', 'bmp', 'tiff', 'iff', 'xbm', 'webp', 'mp4', 'mp3', 'pdf'],
        'elErrorContainer': '#errorBlock'
    });
    $("#kv-explorer").fileinput({
        'theme': 'explorer',
        'uploadUrl': '#',
        overwriteInitial: false,
        initialPreviewAsData: true,
    });
});

function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active2", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active2";
}

// Get the element with id="defaultOpen" and click on it
//document.getElementById("defaultOpen").click();
// like comment ajax data start

// post like script start 
function post_like(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/like_post",
        data: 'post_id=' + clicked_id,
        dataType: 'json',
        success: function (data) {
            $('.' + 'likepost' + clicked_id).html(data.like);
            $('.likeusername' + clicked_id).html(data.likeuser);
            $('.comment_like_count' + clicked_id).html(data.like_user_count);
            $('.likeduserlist' + clicked_id).hide();
            if (data.like_user_total_count == '0') {
                document.getElementById('likeusername' + clicked_id).style.display = "none";
            } else {
                document.getElementById('likeusername' + clicked_id).style.display = "block";
            }
            $('#likeusername' + clicked_id).addClass('likeduserlist1');
        }
    });
}
//post like script end 

// comment insert script start 
function insert_comment(clicked_id)
{
    $("#post_comment" + clicked_id).click(function () {
        $(this).prop("contentEditable", true);
        $(this).html("");
    });
    var sel = $("#post_comment" + clicked_id);
    var txt = sel.html();
    txt = txt.replace(/&nbsp;/gi, " ");
    txt = txt.replace(/<br>$/, '');
    txt = txt.replace(/&gt;/gi, ">");
    txt = txt.replace(/div/gi, 'p');
    if (txt == '' || txt == '<br>') {
        return false;
    }
    if (/^\s+$/gi.test(txt))
    {
        return false;
    }
    txt = txt.replace(/&/g, "%26");
    $('#post_comment' + clicked_id).html("");
    var x = document.getElementById('threecomment' + clicked_id);
    var y = document.getElementById('fourcomment' + clicked_id);
    if (x.style.display === 'block' && y.style.display === 'none') {
        $.ajax({
            type: 'POST',
            url: base_url + "business_profile/insert_commentthree",
            data: 'post_id=' + clicked_id + '&comment=' + encodeURIComponent(txt),
            dataType: "json",
            success: function (data) {
                $('textarea').each(function () {
                    $(this).val('');
                });
                $('.insertcomment' + clicked_id).html(data.comment);
                $('.comment_count' + clicked_id).html(data.comment_count);
            }
        });
    } else {
        $.ajax({
            type: 'POST',
            url: base_url + "business_profile/insert_comment",
            data: 'post_id=' + clicked_id + '&comment=' + encodeURIComponent(txt),
            dataType: "json",
            success: function (data) {
                $('textarea').each(function () {
                    $(this).val('');
                });
                $('#' + 'fourcomment' + clicked_id).html(data.comment);
                $('.comment_count' + clicked_id).html(data.comment_count);
            }
        });
    }
}

// insert comment using enter 
function entercomment(clicked_id)
{
    $("#post_comment" + clicked_id).click(function () {
        $(this).prop("contentEditable", true);
    });
    $('#post_comment' + clicked_id).keypress(function (e) {
        if (e.keyCode == 13 && !e.shiftKey) {
            e.preventDefault();
            var sel = $("#post_comment" + clicked_id);
            var txt = sel.html();
            txt = txt.replace(/&nbsp;/gi, " ");
            txt = txt.replace(/<br>$/, '');
            txt = txt.replace(/&gt;/gi, ">");
            txt = txt.replace(/div/gi, 'p');
            if (txt == '' || txt == '<br>') {
                return false;
            }
            if (/^\s+$/gi.test(txt))
            {
                return false;
            }
            txt = txt.replace(/&/g, "%26");
            $('#post_comment' + clicked_id).html("");
            if (window.preventDuplicateKeyPresses)
                return;
            window.preventDuplicateKeyPresses = true;
            window.setTimeout(function () {
                window.preventDuplicateKeyPresses = false;
            }, 500);
            var x = document.getElementById('threecomment' + clicked_id);
            var y = document.getElementById('fourcomment' + clicked_id);
            if (x.style.display === 'block' && y.style.display === 'none') {
                $.ajax({
                    type: 'POST',
                    url: base_url + "business_profile/insert_commentthree",
                    data: 'post_id=' + clicked_id + '&comment=' + encodeURIComponent(txt),
                    dataType: "json",
                    success: function (data) {
                        $('textarea').each(function () {
                            $(this).val('');
                        });
                        $('.insertcomment' + clicked_id).html(data.comment);
                        $('.comment_count' + clicked_id).html(data.comment_count);
                    }
                });
            } else {
                $.ajax({
                    type: 'POST',
                    url: base_url + "business_profile/insert_comment",
                    data: 'post_id=' + clicked_id + '&comment=' + encodeURIComponent(txt),
                    dataType: "json",
                    success: function (data) {
                        $('textarea').each(function () {
                            $(this).val('');
                        });
                        $('#' + 'fourcomment' + clicked_id).html(data.comment);
                        $('.comment_count' + clicked_id).html(data.comment_count);
                    }
                });
            }
        }
    });
    $(".scroll").click(function (event) {
        event.preventDefault();
        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
    });
}

function insert_comment1(clicked_id)
{
    var post_comment = document.getElementById("post_comment1" + clicked_id);
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/insert_comment1",
        data: 'post_id=' + clicked_id + '&comment=' + post_comment.value,
        dataType: "json",
        success: function (data) {
            $('textarea').each(function () {
                $(this).val('');
            });
            $('.' + 'insertcomment1' + clicked_id).html(data.comment);
            $('.comment_count' + clicked_id).html(data.comment_count);
        }
    });
}

// insert comment using enter 

function entercomment1(clicked_id)
{
    $(document).ready(function () {
        $('#post_comment1' + clicked_id).keypress(function (e) {
            if (e.keyCode == 13 && !e.shiftKey) {
                var val = $('#post_comment1' + clicked_id).val();
                e.preventDefault();
                if (window.preventDuplicateKeyPresses)
                    return;
                window.preventDuplicateKeyPresses = true;
                window.setTimeout(function () {
                    window.preventDuplicateKeyPresses = false;
                }, 500);
                $.ajax({
                    type: 'POST',
                    url: base_url + "business_profile/insert_comment1",
                    data: 'post_id=' + clicked_id + '&comment=' + val,
                    dataType: "json",
                    success: function (data) {
                        $('textarea').each(function () {
                            $(this).val('');
                        });
                        $('.' + 'insertcomment1' + clicked_id).html(data.comment);
                        $('.comment_count' + clicked_id).html(data.comment_count);
                    }
                });
            }
        });
    });
}
//comment insert script end 

// hide and show data start
function commentall(clicked_id) {
    var x = document.getElementById('threecomment' + clicked_id);
    var y = document.getElementById('fourcomment' + clicked_id);
    var z = document.getElementById('insertcount' + clicked_id);
    $('.post-design-commnet-box').show();
    if (x.style.display === 'block' && y.style.display === 'none') {
        x.style.display = 'none';
        y.style.display = 'block';
        z.style.visibility = 'show';
        $.ajax({
            type: 'POST',
            url: base_url + "business_profile/fourcomment",
            data: 'bus_post_id=' + clicked_id,
            success: function (data) {
                $('#' + 'fourcomment' + clicked_id).html(data);
            }
        });
    }
}
// hide and show data end

// comment like script start 
function comment_like(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/like_comment",
        data: 'post_id=' + clicked_id,
        success: function (data) {
            $('#' + 'likecomment' + clicked_id).html(data);
        }
    });
}

function comment_like1(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/like_comment1",
        data: 'post_id=' + clicked_id,
        success: function (data) {
            $('#' + 'likecomment1' + clicked_id).html(data);
        }
    });
}
//comment like script end 

function comment_delete(clicked_id) {
    $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='comment_deleted(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('#bidmodal').modal('show');
}

function comment_deleted(clicked_id)
{
    var post_delete = document.getElementById("post_delete" + clicked_id);
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/delete_comment",
        data: 'post_id=' + clicked_id + '&post_delete=' + post_delete.value,
        dataType: "json",
        success: function (data) {
            $('.' + 'insertcomment' + post_delete.value).html(data.comment);
            $('.comment_count' + post_delete.value).html(data.comment_count);
            $('.post-design-commnet-box').show();
        }
    });
}

function comment_deletetwo(clicked_id)
{
    $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='comment_deletedtwo(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('#bidmodal').modal('show');
}

function comment_deletedtwo(clicked_id)
{

    var post_delete1 = document.getElementById("post_deletetwo" + clicked_id);
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/delete_commenttwo",
        data: 'post_id=' + clicked_id + '&post_delete=' + post_delete1.value,
        dataType: "json",
        success: function (data) {
            $('.' + 'insertcommenttwo' + post_delete1.value).html(data.comment);
            $('.comment_count' + post_delete1.value).html(data.comment_count);
            $('.post-design-commnet-box').show();
        }
    });
}
//comment delete script end 
// comment edit box start
function comment_editbox(clicked_id) {
    document.getElementById('editcomment' + clicked_id).style.display = 'inline-block';
    document.getElementById('showcomment' + clicked_id).style.display = 'none';
    document.getElementById('editsubmit' + clicked_id).style.display = 'inline-block';
    document.getElementById('editcommentbox' + clicked_id).style.display = 'none';
    document.getElementById('editcancle' + clicked_id).style.display = 'block';
    $('.post-design-commnet-box').hide();
}

function comment_editcancle(clicked_id) {
    document.getElementById('editcommentbox' + clicked_id).style.display = 'block';
    document.getElementById('editcancle' + clicked_id).style.display = 'none';
    document.getElementById('editcomment' + clicked_id).style.display = 'none';
    document.getElementById('showcomment' + clicked_id).style.display = 'block';
    document.getElementById('editsubmit' + clicked_id).style.display = 'none';
    $('.post-design-commnet-box').show();
}

function comment_editboxtwo(clicked_id) {
    $('div[id^=editcommenttwo]').css('display', 'none');
    $('div[id^=showcommenttwo]').css('display', 'block');
    $('button[id^=editsubmittwo]').css('display', 'none');
    $('div[id^=editcommentboxtwo]').css('display', 'block');
    $('div[id^=editcancletwo]').css('display', 'none');
    document.getElementById('editcommenttwo' + clicked_id).style.display = 'inline-block';
    document.getElementById('showcommenttwo' + clicked_id).style.display = 'none';
    document.getElementById('editsubmittwo' + clicked_id).style.display = 'inline-block';
    document.getElementById('editcommentboxtwo' + clicked_id).style.display = 'none';
    document.getElementById('editcancletwo' + clicked_id).style.display = 'block';
    $('.post-design-commnet-box').hide();
}

function comment_editcancletwo(clicked_id) {
    document.getElementById('editcommentboxtwo' + clicked_id).style.display = 'block';
    document.getElementById('editcancletwo' + clicked_id).style.display = 'none';
    document.getElementById('editcommenttwo' + clicked_id).style.display = 'none';
    document.getElementById('showcommenttwo' + clicked_id).style.display = 'block';
    document.getElementById('editsubmittwo' + clicked_id).style.display = 'none';
    $('.post-design-commnet-box').show();
}

function comment_editbox3(clicked_id) {
    document.getElementById('editcomment3' + clicked_id).style.display = 'block';
    document.getElementById('showcomment3' + clicked_id).style.display = 'none';
    document.getElementById('editsubmit3' + clicked_id).style.display = 'block';
    document.getElementById('editcommentbox3' + clicked_id).style.display = 'none';
    document.getElementById('editcancle3' + clicked_id).style.display = 'block';
    $('.post-design-commnet-box').hide();
}

function comment_editcancle3(clicked_id) {

    document.getElementById('editcommentbox3' + clicked_id).style.display = 'block';
    document.getElementById('editcancle3' + clicked_id).style.display = 'none';
    document.getElementById('editcomment3' + clicked_id).style.display = 'none';
    document.getElementById('showcomment3' + clicked_id).style.display = 'block';
    document.getElementById('editsubmit3' + clicked_id).style.display = 'none';
    $('.post-design-commnet-box').show();
}

function comment_editbox4(clicked_id) {
    document.getElementById('editcomment4' + clicked_id).style.display = 'block';
    document.getElementById('showcomment4' + clicked_id).style.display = 'none';
    document.getElementById('editsubmit4' + clicked_id).style.display = 'block';
    document.getElementById('editcommentbox4' + clicked_id).style.display = 'none';
    document.getElementById('editcancle4' + clicked_id).style.display = 'block';
    $('.post-design-commnet-box').hide();
}

function comment_editcancle4(clicked_id) {

    document.getElementById('editcommentbox4' + clicked_id).style.display = 'block';
    document.getElementById('editcancle4' + clicked_id).style.display = 'none';
    document.getElementById('editcomment4' + clicked_id).style.display = 'none';
    document.getElementById('showcomment4' + clicked_id).style.display = 'block';
    document.getElementById('editsubmit4' + clicked_id).style.display = 'none';
    $('.post-design-commnet-box').show();
}
//comment edit box end

// comment edit insert start 
function edit_comment(abc)
{

    $("#editcomment" + abc).click(function () {
        $(this).prop("contentEditable", true);
    });
    var sel = $("#editcomment" + abc);
    var txt = sel.html();
    txt = txt.replace(/&nbsp;/gi, " ");
    txt = txt.replace(/<br>$/, '');
    txt = txt.replace(/&gt;/gi, ">");
    txt = txt.replace(/div/gi, "p");
    if (txt == '' || txt == '<br>') {
        return false;
    }
    if (/^\s+$/gi.test(txt))
    {
        return false;
    }
    txt = txt.replace(/&/g, "%26");
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/edit_comment_insert",
        data: 'post_id=' + abc + '&comment=' + encodeURIComponent(txt),
        success: function (data) {

            document.getElementById('editcomment' + abc).style.display = 'none';
            document.getElementById('showcomment' + abc).style.display = 'block';
            document.getElementById('editsubmit' + abc).style.display = 'none';
            document.getElementById('editcommentbox' + abc).style.display = 'block';
            document.getElementById('editcancle' + abc).style.display = 'none';
            $('#' + 'showcomment' + abc).html(data);
            $('.post-design-commnet-box').show();
        }
    });
    $(".scroll").click(function (event) {
        event.preventDefault();
        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
    });
}
function commentedit(abc)
{
    $("#editcomment" + abc).click(function () {
        $(this).prop("contentEditable", true);
    });
    $('#editcomment' + abc).keypress(function (event) {
        if (event.which == 13 && event.shiftKey != 1) {
            event.preventDefault();
            var sel = $("#editcomment" + abc);
            var txt = sel.html();
            txt = txt.replace(/&nbsp;/gi, " ");
            txt = txt.replace(/<br>$/, '');
            txt = txt.replace(/&gt;/gi, ">");
            txt = txt.replace(/div/gi, "p");
            if (txt == '' || txt == '<br>') {
                return false;
            }
            if (/^\s+$/gi.test(txt))
            {
                return false;
            }
            txt = txt.replace(/&/g, "%26");
            if (window.preventDuplicateKeyPresses)
                return;
            window.preventDuplicateKeyPresses = true;
            window.setTimeout(function () {
                window.preventDuplicateKeyPresses = false;
            }, 500);
            $.ajax({
                type: 'POST',
                url: base_url + "business_profile/edit_comment_insert",
                data: 'post_id=' + abc + '&comment=' + encodeURIComponent(txt),
                success: function (data) {
                    document.getElementById('editcomment' + abc).style.display = 'none';
                    document.getElementById('showcomment' + abc).style.display = 'block';
                    document.getElementById('editsubmit' + abc).style.display = 'none';
                    document.getElementById('editcommentbox' + abc).style.display = 'block';
                    document.getElementById('editcancle' + abc).style.display = 'none';
                    $('#' + 'showcomment' + abc).html(data);
                    $('.post-design-commnet-box').show();
                }
            });
        }
    });
    $(".scroll").click(function (event) {
        event.preventDefault();
        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
    });
}

function edit_commenttwo(abc)
{
    $("#editcommenttwo" + abc).click(function () {
        $(this).prop("contentEditable", true);
    });
    var sel = $("#editcommenttwo" + abc);
    var txt = sel.html();
    txt = txt.replace(/&nbsp;/gi, " ");
    txt = txt.replace(/<br>$/, '');
    txt = txt.replace(/&gt;/gi, ">");
    txt = txt.replace(/div/gi, "p");
    if (txt == '' || txt == '<br>') {
        return false;
    }
    if (/^\s+$/gi.test(txt))
    {
        return false;
    }
    txt = txt.replace(/&/g, "%26");
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/edit_comment_insert",
        data: 'post_id=' + abc + '&comment=' + encodeURIComponent(txt),
        success: function (data) {
            document.getElementById('editcommenttwo' + abc).style.display = 'none';
            document.getElementById('showcommenttwo' + abc).style.display = 'block';
            document.getElementById('editsubmittwo' + abc).style.display = 'none';
            document.getElementById('editcommentboxtwo' + abc).style.display = 'block';
            document.getElementById('editcancletwo' + abc).style.display = 'none';
            $('#' + 'showcommenttwo' + abc).html(data);
            $('.post-design-commnet-box').show();
        }
    });
    $(".scroll").click(function (event) {
        event.preventDefault();
        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
    });
}

function commentedittwo(abc)
{
    $("#editcommenttwo" + abc).click(function () {
        $(this).prop("contentEditable", true);
    });
    $('#editcommenttwo' + abc).keypress(function (event) {
        if (event.which == 13 && event.shiftKey != 1) {
            event.preventDefault();
            var sel = $("#editcommenttwo" + abc);
            var txt = sel.html();
            txt = txt.replace(/&nbsp;/gi, " ");
            txt = txt.replace(/<br>$/, '');
            txt = txt.replace(/&gt;/gi, ">");
            txt = txt.replace(/div/gi, "p");
            if (txt == '' || txt == '<br>') {
                return false;
            }
            if (/^\s+$/gi.test(txt))
            {
                return false;
            }
            txt = txt.replace(/&/g, "%26");
            if (window.preventDuplicateKeyPresses)
                return;
            window.preventDuplicateKeyPresses = true;
            window.setTimeout(function () {
                window.preventDuplicateKeyPresses = false;
            }, 500);
            $.ajax({
                type: 'POST',
                url: base_url + "business_profile/edit_comment_insert",
                data: 'post_id=' + abc + '&comment=' + encodeURIComponent(txt),
                success: function (data) {
                    document.getElementById('editcommenttwo' + abc).style.display = 'none';
                    document.getElementById('showcommenttwo' + abc).style.display = 'block';
                    document.getElementById('editsubmittwo' + abc).style.display = 'none';
                    document.getElementById('editcommentboxtwo' + abc).style.display = 'block';
                    document.getElementById('editcancletwo' + abc).style.display = 'none';
                    $('#' + 'showcommenttwo' + abc).html(data);
                    $('.post-design-commnet-box').show();
                }
            });
        }
    });
    $(".scroll").click(function (event) {
        event.preventDefault();
        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
    });
}


function edit_comment3(abc)
{

    var post_comment_edit = document.getElementById("editcomment3" + abc);
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/edit_comment_insert",
        data: 'post_id=' + abc + '&comment=' + post_comment_edit.value,
        success: function (data) {

            document.getElementById('editcomment3' + abc).style.display = 'none';
            document.getElementById('showcomment3' + abc).style.display = 'block';
            document.getElementById('editsubmit3' + abc).style.display = 'none';
            document.getElementById('editcommentbox3' + abc).style.display = 'block';
            document.getElementById('editcancle3' + abc).style.display = 'none';
            $('#' + 'showcomment3' + abc).html(data);
            $('.post-design-commnet-box').show();
        }
    });
//window.location.reload();
}

function commentedit3(abc)
{
    $(document).ready(function () {
        $('#editcomment3' + abc).keypress(function (e) {


            if (e.keyCode == 13 && !e.shiftKey) {
                var val = $('#editcomment3' + clicked_id).val();
                val = val.replace(/&gt;/gi, ">");
                val = val.replace(/&nbsp;/gi, " ");
                val = val.replace(/div/gi, "p");
                e.preventDefault();
                if (window.preventDuplicateKeyPresses)
                    return;
                window.preventDuplicateKeyPresses = true;
                window.setTimeout(function () {
                    window.preventDuplicateKeyPresses = false;
                }, 500);
                $.ajax({
                    type: 'POST',
                    url: base_url + "business_profile/edit_comment_insert",
                    data: 'post_id=' + abc + '&comment=' + val,
                    success: function (data) {

                        document.getElementById('editcomment3' + abc).style.display = 'none';
                        document.getElementById('showcomment3' + abc).style.display = 'block';
                        document.getElementById('editsubmit3' + abc).style.display = 'none';
                        document.getElementById('editcommentbox3' + abc).style.display = 'block';
                        document.getElementById('editcancle3' + abc).style.display = 'none';
                        $('#' + 'showcomment3' + abc).html(data);
                    }
                });
            }
        });
    });
}


function edit_comment4(abc)
{
    var post_comment_edit = document.getElementById("editcomment4" + abc);
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/edit_comment_insert",
        data: 'post_id=' + abc + '&comment=' + post_comment_edit.value,
        success: function (data) {

            document.getElementById('editcomment4' + abc).style.display = 'none';
            document.getElementById('showcomment4' + abc).style.display = 'block';
            document.getElementById('editsubmit4' + abc).style.display = 'none';
            document.getElementById('editcommentbox4' + abc).style.display = 'block';
            document.getElementById('editcancle4' + abc).style.display = 'none';
            $('#' + 'showcomment4' + abc).html(data);
        }
    });
//window.location.reload();
}

function commentedit4(abc)
{
    $(document).ready(function () {
        $('#editcomment4' + abc).keypress(function (e) {

            if (e.keyCode == 13 && !e.shiftKey) {
                var val = $('#editcomment4' + clicked_id).val();
                val = val.replace(/&gt;/gi, ">");
                val = val.replace(/&nbsp;/gi, " ");
                val = val.replace(/div/gi, "p");
                e.preventDefault();
                if (window.preventDuplicateKeyPresses)
                    return;
                window.preventDuplicateKeyPresses = true;
                window.setTimeout(function () {
                    window.preventDuplicateKeyPresses = false;
                }, 500);
                $.ajax({
                    type: 'POST',
                    url: base_url + "business_profile/edit_comment_insert",
                    data: 'post_id=' + abc + '&comment=' + val,
                    success: function (data) {

                        document.getElementById('editcomment4' + abc).style.display = 'none';
                        document.getElementById('showcomment4' + abc).style.display = 'block';
                        document.getElementById('editsubmit4' + abc).style.display = 'none';
                        document.getElementById('editcommentbox4' + abc).style.display = 'block';
                        document.getElementById('editcancle4' + abc).style.display = 'none';
                        $('#' + 'showcomment4' + abc).html(data);
                    }
                });
            }
        });
    });
}


// hide and show data start for save post

function commentall1(clicked_id) {

    var x = document.getElementById('threecomment1' + clicked_id);
    var y = document.getElementById('fourcomment1' + clicked_id);
    if (x.style.display === 'block' && y.style.display === 'none') {
        x.style.display = 'none';
        y.style.display = 'block';
    } else {
        x.style.display = 'block';
        y.style.display = 'none';
    }
}
// hide and show data end
// like comment ajax data end

/* When the user clicks on the button, 
 toggle between hiding and showing the dropdown content */
function myFunction1(clicked_id) {

    var dropDownClass = document.getElementById('myDropdown' + clicked_id).className;
    dropDownClass = dropDownClass.split(" ").pop(-1);
    if (dropDownClass != 'show') {
        $('.dropdown-content2').removeClass('show');
        $('#myDropdown' + clicked_id).addClass('show');
    } else {
        $('.dropdown-content2').removeClass('show');
    }


    $(document).on('keydown', function (e) {
        if (e.keyCode === 27) {

            document.getElementById('myDropdown' + clicked_id).classList.toggle("hide");
            $(".dropdown-content2").removeClass('show');
        }

    });
}

// Close the dropdown if the user clicks outside of it
window.onclick = function (event) {
    if (!event.target.matches('.dropbtn1')) {
        var dropdowns = document.getElementsByClassName("dropdown-content1");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}



/* When the user clicks on the button, 
 toggle between hiding and showing the dropdown content */
function myFunction(clicked_id) {
    document.getElementById('myDropdown' + clicked_id).classList.toggle("show");
    $(document).on('keydown', function (e) {
        if (e.keyCode === 27) {

            document.getElementById('myDropdown' + clicked_id).classList.toggle("hide");
            $(".dropdown-content2").removeClass('show');
        }

    });
}

// Close the dropdown if the user clicks outside of it
window.onclick = function (event) {
    if (!event.target.matches('.dropbtn2')) {

        var dropdowns = document.getElementsByClassName("dropdown-content2");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}


// drop down script zalak end 

// edit post start 


function editpost(abc)
{
    $("#myDropdown" + abc).removeClass('show');
    document.getElementById('editpostdata' + abc).style.display = 'none';
    document.getElementById('editpostbox' + abc).style.display = 'block';
    document.getElementById('editpostdetailbox' + abc).style.display = 'block';
    document.getElementById('editpostsubmit' + abc).style.display = 'block';
    document.getElementById('khyatii' + abc).style.display = 'none';
    document.getElementById('khyati' + abc).style.display = 'none';
}



function edit_postinsert(abc)
{

    var editpostname = document.getElementById("editpostname" + abc);
    // start khyati code
    var $field = $('#editpostname' + abc);
    var editpostdetails = $('#editpostdesc' + abc).html();
    editpostdetails = editpostdetails.replace(/&/g, "%26");
    editpostdetails = editpostdetails.replace(/&gt;/gi, ">");
    editpostdetails = editpostdetails.replace(/&nbsp;/gi, " ");
    editpostdetails = editpostdetails.replace(/div/gi, "p");
    if (editpostname.value == '' && editpostdetails == '') {
        $('.biderror .mes').html("<div class='pop_content'>You must either fill title or description.");
        $('#bidmodal').modal('show');
        document.getElementById('editpostdata' + abc).style.display = 'block';
        document.getElementById('editpostbox' + abc).style.display = 'none';
        document.getElementById('editpostdetailbox' + abc).style.display = 'none';
        document.getElementById('editpostsubmit' + abc).style.display = 'none';
    } else {
        $.ajax({
            type: 'POST',
            url: base_url + "business_profile/edit_post_insert",
            data: 'business_profile_post_id=' + abc + '&product_name=' + editpostname.value + '&product_description=' + editpostdetails,
            dataType: "json",
            success: function (data) {
                document.getElementById('editpostdata' + abc).style.display = 'block';
                document.getElementById('editpostbox' + abc).style.display = 'none';
                document.getElementById('editpostdetailbox' + abc).style.display = 'none';
                document.getElementById('editpostsubmit' + abc).style.display = 'none';
                document.getElementById('khyati' + abc).style.display = 'block';
                $('#' + 'editpostdata' + abc).html(data.title);
                $('#' + 'khyati' + abc).html(data.description);
                $('#' + 'postname' + abc).html(data.postname);
            }
        });
    }
}

// edit post end 
// remove save post start 

function remove_post(abc)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/business_profile_delete",
        data: 'save_id=' + abc,
        success: function (data) {
            $('#' + 'removepostdata' + abc).html(data);
        }
    });
}



// remove save post start 


function remove_ownpost(abc)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/business_profile_deletepost",
        dataType: 'json',
        data: 'business_profile_post_id=' + abc,
        success: function (data) {
            $('#' + 'removepost' + abc).remove();
            GetBusPhotos();
            GetBusVideos();
            GetBusAudios();
            GetBusPdf();
            if (data.notcount == 0) {
                $('.' + 'nofoundpost').html(data.notfound);
                $('.' + 'not_available').remove();
                $('.' + 'image_profile').remove();
                $('.' + 'dataconpdf').html(data.notpdf);
                $('.' + 'dataconvideo').html(data.notvideo);
                $('.' + 'dataconaudio').html(data.notaudio);
                $('.' + 'dataconphoto').html(data.notphoto);
            }
        }
    });
}


// remove save post end 


// Get the modal
var modal = document.getElementById('myModal2');
// Get the button that opens the modal
var btn = document.getElementById("myBtn1");
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



// Get the modal
var modal = document.getElementById('myModal3');
// Get the button that opens the modal
var btn = document.getElementById("myBtn1");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close3")[0];
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

// save post start 

function save_post(abc)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/business_profile_save",
        data: 'business_profile_post_id=' + abc,
        success: function (data) {
            $('.' + 'savedpost' + abc).html(data);
        }
    });
}


// save post end 


// follow user script start 


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


// follow user script end 

// Unfollow user script start 


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


// Unfollow user script end 

// post insert developing script start 


function imgval(event) {

    var fileInput = document.getElementById("file-1").files;
    var product_name = document.getElementById("test-upload_product").value;
    var product_trim = product_name.trim();
    var product_description = document.getElementById("test-upload_des").value;
    var des_trim = product_description.trim();
    var product_fileInput = document.getElementById("file-1").value;
    if (product_fileInput == '' && product_trim == '' && des_trim == '')
    {

        $('#post .mes').html("<div class='pop_content'>This post appears to be blank. Please write or attach (photos, videos, audios, pdf) to post.");
        $('#post').modal('show');
        //setInterval('window.location.reload()', 10000);
        // window.location='';

        $(document).on('keydown', function (e) {
            if (e.keyCode === 27) {
                $('#bidmodal').modal('hide');
                $('.modal-post').show();
            }
        });
        event.preventDefault();
        return false;
    } else {

        for (var i = 0; i < fileInput.length; i++)
        {
            var vname = fileInput[i].name;
            var vfirstname = fileInput[0].name;
            var ext = vfirstname.split('.').pop();
            var ext1 = vname.split('.').pop();
            var allowedExtensions = ['jpg', 'jpeg', 'PNG', 'gif', 'png', 'psd', 'bmp', 'tiff', 'iff', 'xbm', 'webp'];
            var allowesvideo = ['mp4', 'webm', 'qt', 'mov'];
            var allowesaudio = ['mp3'];
            var allowespdf = ['pdf'];
            var foundPresent = $.inArray(ext, allowedExtensions) > -1;
            var foundPresentvideo = $.inArray(ext, allowesvideo) > -1;
            var foundPresentaudio = $.inArray(ext, allowesaudio) > -1;
            var foundPresentpdf = $.inArray(ext, allowespdf) > -1;
            if (foundPresent == true)
            {
                var foundPresent1 = $.inArray(ext1, allowedExtensions) > -1;
                if (foundPresent1 == true && fileInput.length <= 10) {
                } else {
                    if (fileInput.length > 10) {
                        $('.biderror .mes').html("<div class='pop_content'>You can not upload more than 10 files at a time.");
                    } else {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf.");
                    }
                    $('#bidmodal').modal('show');
                    setInterval('window.location.reload()', 10000);
                    $(document).on('keydown', function (e) {
                        if (e.keyCode === 27) {
                            $('#bidmodal').modal('hide');
                            $('.modal-post').show();
                        }
                    });
                    // window.location='';
                    event.preventDefault();
                    return false;
                }

            } else if (foundPresentvideo == true)
            {

                var foundPresent1 = $.inArray(ext1, allowesvideo) > -1;
                if (foundPresent1 == true && fileInput.length == 1) {
                } else {
                    $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf.");
                    $('#bidmodal').modal('show');
                    setInterval('window.location.reload()', 10000);
                    $(document).on('keydown', function (e) {
                        if (e.keyCode === 27) {
//$( "#bidmodal" ).hide();
                            $('#bidmodal').modal('hide');
                            $('.modal-post').show();
                        }
                    });
                    event.preventDefault();
                    return false;
                }
            } else if (foundPresentaudio == true)
            {

                var foundPresent1 = $.inArray(ext1, allowesaudio) > -1;
                if (foundPresent1 == true && fileInput.length == 1) {

                    if (product_name == '') {
                        $('.biderror .mes').html("<div class='pop_content'>You have to add audio title.");
                        $('#bidmodal').modal('show');
                        //setInterval('window.location.reload()', 10000);

                        $(document).on('keydown', function (e) {
                            if (e.keyCode === 27) {
//$( "#bidmodal" ).hide();
                                $('#bidmodal').modal('hide');
                                $('.modal-post').show();
                            }
                        });
                        event.preventDefault();
                        return false;
                    }

                } else {
                    $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf.");
                    $('#bidmodal').modal('show');
                    setInterval('window.location.reload()', 10000);
                    $(document).on('keydown', function (e) {
                        if (e.keyCode === 27) {
//$( "#bidmodal" ).hide();
                            $('#bidmodal').modal('hide');
                            $('.modal-post').show();
                        }
                    });
                    event.preventDefault();
                    return false;
                }
            } else if (foundPresentpdf == true)
            {

                var foundPresent1 = $.inArray(ext1, allowespdf) > -1;
                if (foundPresent1 == true && fileInput.length == 1) {

                    if (product_name == '') {
                        $('.biderror .mes').html("<div class='pop_content'>You have to add pdf title.");
                        $('#bidmodal').modal('show');
                        setInterval('window.location.reload()', 10000);
                        $(document).on('keydown', function (e) {
                            if (e.keyCode === 27) {
//$( "#bidmodal" ).hide();
                                $('#bidmodal').modal('hide');
                                $('.modal-post').show();
                            }
                        });
                        event.preventDefault();
                        return false;
                    }
                } else {
                    $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf.");
                    $('#bidmodal').modal('show');
                    setInterval('window.location.reload()', 10000);
                    $(document).on('keydown', function (e) {
                        if (e.keyCode === 27) {
//$( "#bidmodal" ).hide();
                            $('#bidmodal').modal('hide');
                            $('.modal-post').show();
                        }
                    });
                    event.preventDefault();
                    return false;
                }
            } else if (foundPresentvideo == false) {

                $('.biderror .mes').html("<div class='pop_content'>This File Format is not supported Please Try to Upload MP4 or WebM files..");
                $('#bidmodal').modal('show');
                setInterval('window.location.reload()', 10000);
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
//$( "#bidmodal" ).hide();
                        $('#bidmodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                event.preventDefault();
                return false;
            }

        }
    }
}



//This script is used for "This post appears to be blank. Please write or attach (photos, videos, audios, pdf) to post." comment click close then post add popup open start
$(document).ready(function () {
    $('#post').on('click', function () {

        $('.modal-post').show();
        //  location.reload(false);
    });
});
//This script is used for "This post appears to be blank. Please write or attach (photos, videos, audios, pdf) to post." comment click close then post add popup open end  



$(function () {
    var showTotalChar = 250, showChar = "ReadMore", hideChar = "";
    $('.show').each(function () {
        var content = $(this).html();
        if (content.length > showTotalChar) {
            var con = content.substr(0, showTotalChar);
            var hcon = content.substr(showTotalChar, content.length - showTotalChar);
            var txt = con + '<span class="dots">...</span><span class="morectnt"><span>' + hcon + '</span>&nbsp;&nbsp;<a href="" class="showmoretxt">' + showChar + '</a></span>';
            $(this).html(txt);
        }
    });
    $(".showmoretxt").click(function () {
        if ($(this).hasClass("sample")) {
            $(this).removeClass("sample");
            $(this).text(showChar);
        } else {
            $(this).addClass("sample");
            $(this).text(hideChar);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
});
function check_length(my_form) {
    maxLen = 50; // max number of characters allowed
    if (my_form.my_text.value.length > maxLen) {
        // Alert message if maximum limit is reached. 
        // If required Alert can be removed. 
        var msg = "You have reached your maximum limit of characters allowed";
        $('.biderror .mes').html("<div class='pop_content'>" + msg + "</div>");
        $('#bidmodal').modal('show');
        // Reached the Maximum length so trim the textarea
        my_form.my_text.value = my_form.my_text.value.substring(0, maxLen);
    } else { // Maximum length not reached so update the value of my_text counter
        my_form.text_num.value = maxLen - my_form.my_text.value.length;
    }
}


function check_lengthedit(abc)
{
    maxLen = 50;
    var product_name = document.getElementById("editpostname" + abc).value;
    if (product_name.length > maxLen) {
        text_num = maxLen - product_name.length;
        var msg = "You have reached your maximum limit of characters allowed";
        $('#postedit .mes').html("<div class='pop_content'>" + msg + "</div>");
        $('#postedit').modal('show');
        var substrval = product_name.substring(0, maxLen);
        $('#editpostname' + abc).val(substrval);
    } else {
        text_num = maxLen - product_name.length;
        document.getElementById("text_num").value = text_num;
    }
}


function contentedit(clicked_id) {
    $("#post_comment" + clicked_id).click(function () {
        $(this).prop("contentEditable", true);
        $(this).html("");
    });
    $("#post_comment" + clicked_id).keypress(function (event) {
        if (event.which == 13 && event.shiftKey != 1) {
            event.preventDefault();
            var sel = $("#post_comment" + clicked_id);
            var txt = sel.html();
            txt = txt.replace(/&/g, "%26");
            $('#post_comment' + clicked_id).html("");
            var x = document.getElementById('threecomment' + clicked_id);
            var y = document.getElementById('fourcomment' + clicked_id);
            if (x.style.display === 'block' && y.style.display === 'none') {
                $.ajax({
                    type: 'POST',
                    url: base_url + "business_profile/insert_commentthree",
                    data: 'post_id=' + clicked_id + '&comment=' + encodeURIComponent(txt),
                    dataType: "json",
                    success: function (data) {
                        $('input').each(function () {
                            $(this).val('');
                        });
                        $('#' + 'insertcount' + clicked_id).html(data.count);
                        $('.insertcomment' + clicked_id).html(data.comment);
                    }
                });
            } else {
                $.ajax({
                    type: 'POST',
                    url: base_url + "business_profile/insert_comment",
                    data: 'post_id=' + clicked_id + '&comment=' + encodeURIComponent(val),
                    success: function (data) {
                        $('input').each(function () {
                            $(this).val('');
                        }
                        );
                        $('#' + 'fourcomment' + clicked_id).html(data);
                    }
                });
            }

        }
    });
    $(".scroll").click(function (event) {
        event.preventDefault();
        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
    });
}


function likeuserlist(post_id) {

    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/likeuserlist",
        data: 'post_id=' + post_id,
        dataType: "html",
        success: function (data) {
            var html_data = data;
            $('#likeusermodal .mes').html(html_data);
            $('#likeusermodal').modal('show');
        }
    });
}


// cover image start 

function myFunction() {
    document.getElementById("upload-demo").style.visibility = "hidden";
    document.getElementById("upload-demo-i").style.visibility = "hidden";
    document.getElementById('message1').style.display = "block";
}

function showDiv() {
    document.getElementById('row1').style.display = "block";
    document.getElementById('row2').style.display = "none";
}



jQuery.noConflict();
(function ($) {
    $uploadCrop = $('#upload-demo').croppie({
        enableExif: true,
        viewport: {
            width: 1250,
            height: 350,
            type: 'square'
        },
        boundary: {
            width: 1250,
            height: 350
        }
    });
    $('.upload-result').on('click', function (ev) {

        document.getElementById("upload-demo").style.visibility = "hidden";
        document.getElementById("upload-demo-i").style.visibility = "hidden";
        document.getElementById('message1').style.display = "block";

        $uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {

            $.ajax({
                url: base_url + "business_profile/ajaxpro",
                type: "POST",
                data: {"image": resp},
                success: function (data) {
                    $("#row2").html(data);
                    document.getElementById('row2').style.display = "block";
                    document.getElementById('row1').style.display = "none";
                    document.getElementById('message1').style.display = "none";
                    document.getElementById("upload-demo").style.visibility = "visible";
                    document.getElementById("upload-demo-i").style.visibility = "visible";
                }
            });
        });
    });
    $('.cancel-result').on('click', function (ev) {
        document.getElementById('row2').style.display = "block";
        document.getElementById('row1').style.display = "none";
        document.getElementById('message1').style.display = "none";
    });
    $('#upload').on('change', function () {

        var reader = new FileReader();
        reader.onload = function (e) {
            $uploadCrop.croppie('bind', {
                url: e.target.result
            }).then(function () {
                console.log('jQuery bind complete');
            });
        }
        reader.readAsDataURL(this.files[0]);
    });
    $('#upload').on('change', function () {

        var fd = new FormData();
        fd.append("image", $("#upload")[0].files[0]);
        files = this.files;
        size = files[0].size;
        if (!files[0].name.match(/.(jpg|jpeg|png|gif)$/i)) {
            picpopup();
            document.getElementById('row1').style.display = "none";
            document.getElementById('row2').style.display = "block";
            $("#upload").val('');
            return false;
        }
        // file type code end

        if (size > 4194304)
        {
            //show an alert to the user
            alert("Allowed file size exceeded. (Max. 4 MB)")

            document.getElementById('row1').style.display = "none";
            document.getElementById('row2').style.display = "block";
            //reset file upload control
            return false;
        }

        $.ajax({

            url: base_url + "business_profile/imagedata",
            type: "POST",
            data: fd,
            processData: false,
            contentType: false,
            success: function (response) {


            }
        });
    });
})(jQuery);
//aarati code end

// cover image end 

// post delete login user script start 

function user_postdelete(clicked_id)
{
    $('.biderror .mes').html("<div class='pop_content'> Do you want to delete this post?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='remove_ownpost(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('#bidmodal').modal('show');
}

// post delete login user end 
// This  script use for close dropdown in every post 

$('body').on("click", "*", function (e) {
//    var classNames = $(e.target).attr("class").toString().split(' ').pop();
    var classNames = $(e.target).attr("class");
    if (classNames != '' && classNames != 'undefined') {
        classNames = classNames.toString().split(' ').pop();
        if (classNames != 'fa-ellipsis-v') {
            $('div[id^=myDropdown]').hide().removeClass('show');
        }
    }
});

$('body').on('touchstart', function(e) {
    var classNames = $(e.target).attr("class");
    if (classNames != '' && classNames != 'undefined') {
        classNames = classNames.toString().split(' ').pop();
        if (classNames != 'fa-ellipsis-v') {
            $('div[id^=myDropdown]').hide().removeClass('show');
        }
    }
});
// This  script use for close dropdown in every post 

// script for profile pic strat 

$(document).ready(function () {
    $('.video').mediaelementplayer({
        alwaysShowControls: false,
        videoVolume: 'horizontal',
        features: ['playpause', 'progress', 'volume', 'fullscreen']
    });
});
$(document).keydown(function (e) {
    if (!e)
        e = window.event;
    if (e.keyCode == 27 || e.charCode == 27) {
        document.getElementById('myModal3').style.display = "none";
    }
});
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




// pop up open & close aarati code start 
jQuery(document).mouseup(function (e) {

    var container1 = $("#myModal3");
    jQuery(document).mouseup(function (e)
    {
        var container = $("#close");
        //container.show();
        if (!container.is(e.target) // if the target of the click isn't the container...
                && container.has(e.target).length === 0) // ... nor a descendant of the container
        {

            container1.hide();
        }
    });
});
// pop up open & close aarati code end

// all popup close close using esc start 
$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        $('#bidmodal').modal('hide');
        $('#likeusermodal').modal('hide');
    }
});
$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        if ($('.modal-post').show()) {
            $(document).on('keydown', function (e) {
                if (e.keyCode === 27) {
                    $('.modal-post').hide();
                }
            });
        }
        document.getElementById('myModal3').style.display = "none";
    }
});
// contact person script start 

function contact_person(clicked_id) {
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/contact_person",
        data: 'toid=' + clicked_id,
        dataType: 'json',
        success: function (data) {
            $('#contact_per').html(data);
            if (data.co_notification.co_notification_count != 0) {
                var co_notification_count = data.co_notification.co_notification_count;
                var co_to_id = data.co_notification.co_to_id;
                show_contact_notification(co_notification_count, co_to_id);
            }
        }
    });
}


// contact person script end 


function contact_person_model(clicked_id, status) {
    if (status == 'pending') {
        $('.biderror .mes').html("<div class='pop_content'> Do you want to cancel  contact request?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='contact_person(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
        $('#bidmodal').modal('show');
    } else if (status == 'confirm') {

        $('.biderror .mes').html("<div class='pop_content'> Do you want to remove this user from your contact list?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='contact_person(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
        $('#bidmodal').modal('show');
    }

}



// scroll page script start 

//For Scroll page at perticular position js Start
$(document).ready(function () {
    $('html,body').animate({scrollTop: 330}, 500);
});
//For Scroll page at perticular position js End


// scroll page script end 



// all popup close close using esc start 


$('.modal-close').on('click', function () {
    $('#myModal').modal('show');
});
//<khyati chnages 24-4 start


function khdiv(abc) {

    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/edit_more_insert",
        data: 'business_profile_post_id=' + abc,
        dataType: "json",
        success: function (data) {

            document.getElementById('editpostdata' + abc).style.display = 'block';
            document.getElementById('editpostbox' + abc).style.display = 'none';
            document.getElementById('editpostdetailbox' + abc).style.display = 'none';
            document.getElementById('editpostsubmit' + abc).style.display = 'none';
            document.getElementById('khyati' + abc).style.display = 'none';
            document.getElementById('khyatii' + abc).style.display = 'block';
            $('#' + 'editpostdata' + abc).html(data.title);
            $('#' + 'khyatii' + abc).html(data.description);
        }
    });
}
// edit post end 


// 180 words more than script start 

function seemorediv(abc) {
    document.getElementById('seemore' + abc).style.display = 'block';
    document.getElementById('lessmore' + abc).style.display = 'none';
}

$('#postedit').on('click', function () {
    // $('.my_text').attr('readonly', false);
});
$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        $('#postedit').modal('hide');
    }
});

// DROP DOWN SCRIPT START 

/* When the user clicks on the button, 
 toggle between hiding and showing the dropdown content */
function myFunction(clicked_id) {
    var dropDownClass = document.getElementById('myDropdown' + clicked_id).className;
    dropDownClass = dropDownClass.split(" ").pop(-1);
    if (dropDownClass != 'show') {
        $('.dropdown-content1').removeClass('show');
        $('#myDropdown' + clicked_id).addClass('show');
    } else {
        $('.dropdown-content1').removeClass('show');
    }
    $(document).on('keydown', function (e) {
        if (e.keyCode === 27) {
            document.getElementById('myDropdown' + clicked_id).classList.toggle("hide");
            $(".dropdown-content1").removeClass('show');
        }
    });
}
// Close the dropdown if the user clicks outside of it
window.onclick = function (event) {
    if (!event.target.matches('.dropbtn1')) {
        var dropdowns = document.getElementsByClassName("dropdown-content1");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}




// DROP DOWN SCRIPT END 