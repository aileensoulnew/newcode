$(document).keydown(function (e) {
    if (!e)
        e = window.event;
    if (e.keyCode == 27 || e.charCode == 27) {
        closeModal();
        $('.modal').modal('hide');
    }
});


function check() {
    var keyword = $.trim(document.getElementById('tags1').value);
    var place = $.trim(document.getElementById('searchplace1').value);
    if (keyword == "" && place == "") {
        return false;
    }
}

$(document).ready(function () {
    $('.blocks').jMosaic({items_type: "li", margin: 0});
    $('.pictures').jMosaic({min_row_height: 150, margin: 3, is_first_big: true});
    $('body').addClass('modal-open');
});

document.getElementById('myModal1').style.display = "block";
showSlides(slideIndex = count);
$("body").addClass('modal-open');

function openModal() {
    document.getElementById('myModal1').style.display = "block";
    $("body").addClass('modal-open');
}

function closeModal() {
    document.getElementById('myModal1').style.display = "none";
    $("body").removeClass('modal-open');
}

var slideIndex = 1;
//showSlides(slideIndex);
function plusSlides(n) {
    $('.post-design-commnet-box').show();
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    check_post_available(post_id);

    $('.post-design-commnet-box').show();
    showSlides(slideIndex = n);
     $("body").addClass('modal-open');
}

function showSlides(n) {
    $("body").addClass('modal-open');
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
            url: base_url + "business_profile/pninsert_commentthree",
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
            url: base_url + "business_profile/pninsert_comment",
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
            //txt = txt.replace(/^(&nbsp;|<br>)+/, '');
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
                    url: base_url + "business_profile/pninsert_commentthree",
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
                    url: base_url + "business_profile/pninsert_comment",
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
}

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
            url: base_url + "business_profile/pnfourcomment",
            data: 'bus_post_id=' + clicked_id,
            //alert(data);
            success: function (data) {
                $('#' + 'fourcomment' + clicked_id).html(data);
            }
        });
    }
}


function comment_like(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/check_post_comment_available",
        data: 'post_id=' + clicked_id,
        success: function (data) {
            if (data == 1) {
                $.ajax({
                    type: 'POST',
                    url: base_url + "business_profile/like_comment",
                    data: 'post_id=' + clicked_id,
                    success: function (data) {
                        $('#' + 'likecomment' + clicked_id).html(data);
                    }
                });
            } else {
                $('.mes').html('Sorry this content is now not available');
                $('#bidmodal').modal('show');
            }
        }
    });
}
function comment_like1(clicked_id)
{
$.ajax({
        type: 'POST',
        url: base_url + "business_profile/check_post_comment_available",
        data: 'post_id=' + clicked_id,
        success: function (data1) {
            if (data1 == 1) {
                $.ajax({
                    type: 'POST',
                    url: base_url + "business_profile/like_comment1",
                    data: 'post_id=' + clicked_id,
                    dataType: 'json',
                    success: function (data) {
                        $('#' + 'likecomment1' + clicked_id).html(data.comment_html);
                        if (data.notification.notification_count != 0) {
                            var notification_count = data.notification.notification_count;
                            var to_id = data.notification.to_id;
                            show_header_notification(notification_count, to_id);
                        }
                    }
                });
            } else {
                $('.mes').html('Sorry this content is now not available');
                $('#bidmodal').modal('show');
            }
        }
    });
}
function comment_delete(clicked_id) {
    $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='comment_deleted(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('#bidmodal').modal('show');
}


function comment_deleted(clicked_id)
{
    var post_delete = document.getElementById("post_delete" + clicked_id);
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/pndelete_comment",
        data: 'post_id=' + clicked_id + '&post_delete=' + post_delete.value,
        dataType: "json",
        success: function (data) {
            //                alert(data.comment_count);
            $('.' + 'insertcomment' + post_delete.value).html(data.comment);
            //$('#' + 'insertcount' + post_delete.value).html(data.count);
            $('.comment_count' + post_delete.value).html(data.comment_count + ' Comment');
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
        url: base_url + "business_profile/pndelete_commenttwo",
        data: 'post_id=' + clicked_id + '&post_delete=' + post_delete1.value,
        dataType: "json",
        success: function (data) {
            $('.' + 'insertcommenttwo' + post_delete1.value).html(data.comment);
            $('.comment_count' + post_delete1.value).html(data.comment_count + '<span> Comment</span>');
            $('.post-design-commnet-box').show();
        }
    });
}

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

function comment_editbox4(clicked_id) { //alert(clicked_id); alert('editcomment' + clicked_id); alert('showcomment' + clicked_id); alert('editsubmit' + clicked_id); 
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
    txt = txt.replace(/div/gi, 'p');
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
            txt = txt.replace(/div/gi, 'p');
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
                success: function (data) { //alert('falguni');
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
    txt = txt.replace(/div/gi, 'p');
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
        success: function (data) { //alert('falguni');

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
            txt = txt.replace(/div/gi, 'p');
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


$(function () {
    var showTotalChar = 180, showChar = "ReadMore", hideChar = "";
    $('.show_desc').each(function () {
        var content = $(this).html();
        content = content.replace(/ /g, '');
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
// function myFunction(clicked_id) {
//     document.getElementById('myDropdown' + clicked_id).classList.toggle("show");
//     $(document).on('keydown', function (e) {
//         if (e.keyCode === 27) {

//             document.getElementById('myDropdown' + clicked_id).classList.toggle("hide");
//             $(".dropdown-content1").removeClass('show');
//         }

//     });
// }
// window.onclick = function (event) {
//     if (!event.target.matches('.dropbtn1')) {

//         var dropdowns = document.getElementsByClassName("dropdown-content1");
//         var i;
//         for (i = 0; i < dropdowns.length; i++) {
//             var openDropdown = dropdowns[i];
//             if (openDropdown.classList.contains('show')) {
//                 openDropdown.classList.remove('show');
//             }
//         }
//     }
// }

var $fileUpload = $("#files"),
        $list = $('#list'),
        thumbsArray = [],
        maxUpload = 5;
function read(f) {
    return function (e) {
        var base64 = e.target.result;
        var $img = $('<img/>', {
            src: base64,
            title: encodeURIComponent(f.name),
            "class": "thumb"
        });
        var $thumbParent = $("<span/>", {html: $img, "class": "thumbParent"}).append('<span class="remove_thumb"/>');
        thumbsArray.push(base64);
        $list.append($thumbParent);
    };
}


function handleFileSelect(e) {
    e.preventDefault();
    var files = e.target.files;
    var len = files.length;
    if (len > maxUpload || thumbsArray.length >= maxUpload) {
        return alert("Sorry you can upload only 5 images");
    }
    for (var i = 0; i < len; i++) {
        var f = files[i];
        if (!f.type.match('image.*'))
            continue;
        var reader = new FileReader();
        reader.onload = read(f);
        reader.readAsDataURL(f);
    }
}

$fileUpload.change(function (e) {
    handleFileSelect(e);
});
$list.on('click', '.remove_thumb', function () {
    var $removeBtns = $('.remove_thumb');
    var idx = $removeBtns.index(this);
    $(this).closest('span.thumbParent').remove();
    thumbsArray.splice(idx, 1);
});
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

function remove_post(abc)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/business_profile_deletepost",
        data: 'business_profile_post_id=' + abc,
        success: function (data) {
            $('#' + 'removepost' + abc).html(data);
            window.location = base_url + "business-profile/home";
        }
    });
}
function del_particular_userpost(abc)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/del_particular_userpost",
        data: 'business_profile_post_id=' + abc,
        success: function (data) {
            $('#' + 'removepost' + abc).html(data);
            window.location = base_url + "business-profile/home";
        }
    });
}

function mulimg_like(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/mulimg_like",
        data: 'post_image_id=' + clicked_id,
        dataType: 'json',
        success: function (data) {

            $('.' + 'likepostimg' + clicked_id).html(data.like);
            $('.likeusernameimg' + clicked_id).html(data.likeuser);
            $('.comnt_count_ext_img' + clicked_id).html(data.like_user_count);
            $('.likeduserlistimg' + clicked_id).hide();
            if (data.like_user_total_count == '0') {
                document.getElementById('likeusernameimg' + clicked_id).style.display = "none";
            } else {
                document.getElementById('likeusernameimg' + clicked_id).style.display = "block";
            }
            $('#likeusernameimg' + clicked_id).addClass('likeduserlist1');
        }
    });
}
function insert_commentimg(clicked_id)
{

    $("#post_imgcomment" + clicked_id).click(function () {
        $(this).prop("contentEditable", true);
        $(this).html("");
    });
    var sel = $("#post_imgcomment" + clicked_id);
    var txt = sel.html();
    txt = txt.replace(/&nbsp;/gi, " ");
    txt = txt.replace(/<br>$/, '');
    if (txt == '' || txt == '<br>') {
        return false;
    }
    if (/^\s+$/gi.test(txt))
    {
        return false;
    }
    txt = txt.replace(/&/g, "%26");
    $('#post_imgcomment' + clicked_id).html("");
    var x = document.getElementById('threeimgcomment' + clicked_id);
    var y = document.getElementById('fourimgcomment' + clicked_id);
    if (x.style.display === 'block' && y.style.display === 'none') {
        $.ajax({
            type: 'POST',
            url: base_url + "business_profile/pnmulimgcommentthree",
            data: 'post_image_id=' + clicked_id + '&comment=' + encodeURIComponent(txt),
            dataType: "json",
            success: function (data) {
                $('textarea').each(function () {
                    $(this).val('');
                });
                $('.' + 'insertimgcomment' + clicked_id).html(data.comment);
                // $('#' + 'insertcountimg' + clicked_id).html(data.count);
                $('.like_count_ext_img' + clicked_id).html(data.comment_count);
            }
        });
    } else {

        $.ajax({
            type: 'POST',
            url: base_url + "business_profile/pnmulimg_comment",
            data: 'post_image_id=' + clicked_id + '&comment=' + encodeURIComponent(txt),
            dataType: "json",
            success: function (data) {
                $('textarea').each(function () {
                    $(this).val('');
                });
                $('#' + 'fourimgcomment' + clicked_id).html(data.comment);
                $('.like_count_ext_img' + clicked_id).html(data.comment_count);
            }
        });
    }
}

function entercommentimg(clicked_id)
{


    $("#post_imgcomment" + clicked_id).click(function () {
        $(this).prop("contentEditable", true);
    });
    $('#post_imgcomment' + clicked_id).keypress(function (e) {

        if (e.keyCode == 13 && !e.shiftKey) {
            e.preventDefault();
            var sel = $("#post_imgcomment" + clicked_id);
            var txt = sel.html();
            txt = txt.replace(/&nbsp;/gi, " ");
            txt = txt.replace(/<br>$/, '');
            if (txt == '' || txt == '<br>') {
                return false;
            }
            if (/^\s+$/gi.test(txt))
            {
                return false;
            }
            txt = txt.replace(/&/g, "%26");
            $('#post_imgcomment' + clicked_id).html("");
            if (window.preventDuplicateKeyPresses)
                return;
            window.preventDuplicateKeyPresses = true;
            window.setTimeout(function () {
                window.preventDuplicateKeyPresses = false;
            }, 500);
            var x = document.getElementById('threeimgcomment' + clicked_id);
            var y = document.getElementById('fourimgcomment' + clicked_id);
            if (x.style.display === 'block' && y.style.display === 'none') {
                $.ajax({
                    type: 'POST',
                    url: base_url + "business_profile/pnmulimgcommentthree",
                    data: 'post_image_id=' + clicked_id + '&comment=' + encodeURIComponent(txt),
                    dataType: "json",
                    success: function (data) {

                        $('.' + 'insertimgcomment' + clicked_id).html(data.comment);
                        $('.like_count_ext_img' + clicked_id).html(data.comment_count);
                    }
                });
            } else {

                $.ajax({
                    type: 'POST',
                    url: base_url + "business_profile/pnmulimg_comment",
                    data: 'post_image_id=' + clicked_id + '&comment=' + encodeURIComponent(txt),
                    success: function (data) {
                        $('#' + 'fourimgcomment' + clicked_id).html(data.comment);
                        $('.like_count_ext_img' + clicked_id).html(data.comment_count + '<span> Comment</span>');
                    }
                });
            }
        }
    });
}


function imgcommentall(clicked_id) {


    var x = document.getElementById('threeimgcomment' + clicked_id);
    var y = document.getElementById('fourimgcomment' + clicked_id);
    var z = document.getElementById('insertcountimg' + clicked_id);
    $('.post-design-commnet-box').show();
    if (x.style.display === 'block' && y.style.display === 'none') {
        x.style.display = 'none';
        y.style.display = 'block';
        z.style.visibility = 'show';
        $.ajax({
            type: 'POST',
            url: base_url + "business_profile/pnmulimagefourcomment",
            data: 'bus_img_id=' + clicked_id,
            success: function (data) {
                $('#' + 'fourimgcomment' + clicked_id).html(data);
            }
        });
    }
}


function commentall1(clicked_id) { //alert("xyz");

//alert(clicked_id);
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


function imgcommentall1(clicked_id) { //alert("xyz");

//alert(clicked_id);
    var x = document.getElementById('threeimgcomment1' + clicked_id);
    var y = document.getElementById('fourimgcomment1' + clicked_id);
    if (x.style.display === 'block' && y.style.display === 'none') {
        x.style.display = 'none';
        y.style.display = 'block';
    } else {
        x.style.display = 'block';
        y.style.display = 'none';
    }

}


function imgcomment_like(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/mulimg_comment_like",
        data: 'post_image_comment_id=' + clicked_id,
        success: function (data) {
            $('#' + 'imglikecomment' + clicked_id).html(data);
        }
    });
}
function imgcomment_liketwo(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/mulimg_comment_liketwo",
        data: 'post_image_comment_id=' + clicked_id,
        success: function (data) {
            $('#' + 'imglikecomment1' + clicked_id).html(data);
        }
    });
}


function imgcomment_editbox(clicked_id) {
    document.getElementById('imgeditcomment' + clicked_id).style.display = 'inline-block';
    document.getElementById('imgshowcomment' + clicked_id).style.display = 'none';
    document.getElementById('imgeditsubmit' + clicked_id).style.display = 'inline-block';
    document.getElementById('imgeditcommentbox' + clicked_id).style.display = 'none';
    document.getElementById('imgeditcancle' + clicked_id).style.display = 'block';
    $('.post-design-commnet-box').hide();
}

function imgcomment_editcancle(clicked_id) {

    document.getElementById('imgeditcommentbox' + clicked_id).style.display = 'block';
    document.getElementById('imgeditcancle' + clicked_id).style.display = 'none';
    document.getElementById('imgeditcomment' + clicked_id).style.display = 'none';
    document.getElementById('imgshowcomment' + clicked_id).style.display = 'block';
    document.getElementById('imgeditsubmit' + clicked_id).style.display = 'none';
    $('.post-design-commnet-box').show();
}

function imgcomment_editboxtwo(clicked_id) {

    $('div[id^=imgeditcommenttwo]').css('display', 'none');
    $('div[id^=imgshowcommenttwo]').css('display', 'block');
    $('button[id^=imgeditsubmittwo]').css('display', 'none');
    $('div[id^=imgeditcommentboxtwo]').css('display', 'block');
    $('div[id^=imgeditcancletwo]').css('display', 'none');
    document.getElementById('imgeditcommenttwo' + clicked_id).style.display = 'inline-block';
    document.getElementById('imgshowcommenttwo' + clicked_id).style.display = 'none';
    document.getElementById('imgeditsubmittwo' + clicked_id).style.display = 'inline-block';
    document.getElementById('imgeditcommentboxtwo' + clicked_id).style.display = 'none';
    document.getElementById('imgeditcancletwo' + clicked_id).style.display = 'block';
    $('.post-design-commnet-box').hide();
}

function imgcomment_editcancletwo(clicked_id) {
    document.getElementById('imgeditcommentboxtwo' + clicked_id).style.display = 'block';
    document.getElementById('imgeditcancletwo' + clicked_id).style.display = 'none';
    document.getElementById('imgeditcommenttwo' + clicked_id).style.display = 'none';
    document.getElementById('imgshowcommenttwo' + clicked_id).style.display = 'block';
    document.getElementById('imgeditsubmittwo' + clicked_id).style.display = 'none';
    $('.post-design-commnet-box').show();
}



function imgedit_comment(abc)
{
    $("#imgeditcomment" + abc).click(function () {
        $(this).prop("contentEditable", true);
    });
    var sel = $("#imgeditcomment" + abc);
    var txt = sel.html();
    txt = txt.replace(/&nbsp;/gi, " ");
    txt = txt.replace(/<br>$/, '');
    if (txt == '' || txt == '<br>') {
        $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='imgcomment_deleted(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
        $('#bidmodal').modal('show');
        return false;
    } else if (/^\s+$/gi.test(txt))
    {
        return false;
    } else {
        txt = txt.replace(/&/g, "%26");
        $.ajax({
            type: 'POST',
            url: base_url + "business_profile/mul_edit_com_insert",
            data: 'post_image_comment_id=' + abc + '&comment=' + encodeURIComponent(txt),
            success: function (data) {


                document.getElementById('imgeditcomment' + abc).style.display = 'none';
                document.getElementById('imgshowcomment' + abc).style.display = 'block';
                document.getElementById('imgeditsubmit' + abc).style.display = 'none';
                document.getElementById('imgeditcommentbox' + abc).style.display = 'block';
                document.getElementById('imgeditcancle' + abc).style.display = 'none';
                $('#' + 'imgshowcomment' + abc).html(data);
                $('.post-design-commnet-box').show();
            }
        });
    }

}




function imgcommentedit(abc)
{
    $("#imgeditcomment" + abc).click(function () {
        $(this).prop("contentEditable", true);
    });
    $('#imgeditcomment' + abc).keypress(function (event) {

        if (event.which == 13 && event.shiftKey != 1) {
            event.preventDefault();
            var sel = $("#imgeditcomment" + abc);
            var txt = sel.html();
            txt = txt.replace(/&nbsp;/gi, " ");
            txt = txt.replace(/<br>$/, '');
            if (txt == '' || txt == '<br>') {
                $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='imgcomment_deleted(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                $('#bidmodal').modal('show');
                return false;
            } else if (/^\s+$/gi.test(txt))
            {
                return false;
            } else {
                txt = txt.replace(/&/g, "%26");
                if (window.preventDuplicateKeyPresses)
                    return;
                window.preventDuplicateKeyPresses = true;
                window.setTimeout(function () {
                    window.preventDuplicateKeyPresses = false;
                }, 500);
                $.ajax({
                    type: 'POST',
                    url: base_url + "business_profile/mul_edit_com_insert",
                    data: 'post_image_comment_id=' + abc + '&comment=' + encodeURIComponent(txt),
                    success: function (data) {


                        document.getElementById('imgeditcomment' + abc).style.display = 'none';
                        document.getElementById('imgshowcomment' + abc).style.display = 'block';
                        document.getElementById('imgeditsubmit' + abc).style.display = 'none';
                        document.getElementById('imgeditcommentbox' + abc).style.display = 'block';
                        document.getElementById('imgeditcancle' + abc).style.display = 'none';
                        $('#' + 'imgshowcomment' + abc).html(data);
                        $('.post-design-commnet-box').show();
                    }
                });
            }

        }
    });
}


function imgedit_commenttwo(abc)
{

    $("#imgeditcommenttwo" + abc).click(function () {
        $(this).prop("contentEditable", true);
    });
    var sel = $("#imgeditcommenttwo" + abc);
    var txt = sel.html();
    txt = txt.replace(/&nbsp;/gi, " ");
    txt = txt.replace(/<br>$/, '');
    if (txt == '' || txt == '<br>') {
        $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='imgcomment_deletedtwo(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
        $('#bidmodal').modal('show');
        return false;
    }
    if (/^\s+$/gi.test(txt))
    {
        return false;
    }
    txt = txt.replace(/&/g, "%26");
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/mul_edit_com_insert",
        data: 'post_image_comment_id=' + abc + '&comment=' + encodeURIComponent(txt),
        success: function (data) {
            //alert(data);
            document.getElementById('imgeditcommenttwo' + abc).style.display = 'none';
            document.getElementById('imgshowcommenttwo' + abc).style.display = 'block';
            document.getElementById('imgeditsubmittwo' + abc).style.display = 'none';
            document.getElementById('imgeditcommentboxtwo' + abc).style.display = 'block';
            document.getElementById('imgeditcancletwo' + abc).style.display = 'none';
            $('#' + 'imgshowcommenttwo' + abc).html(data);
            $('.post-design-commnet-box').show();
        }
    });
    $(".scroll").click(function (event) {
        event.preventDefault();
        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
    });
}


function imgcommentedittwo(abc)
{

    $("#imgeditcommenttwo" + abc).click(function () {
        $(this).prop("contentEditable", true);
    });
    $('#imgeditcommenttwo' + abc).keypress(function (event) {
        if (event.which == 13 && event.shiftKey != 1) {
            event.preventDefault();
            var sel = $("#imgeditcommenttwo" + abc);
            var txt = sel.html();
            txt = txt.replace(/&nbsp;/gi, " ");
            txt = txt.replace(/<br>$/, '');
            if (txt == '' || txt == '<br>') {
                $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='imgcomment_deletedtwo(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                $('#bidmodal').modal('show');
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
                url: base_url + "business_profile/mul_edit_com_insert",
                data: 'post_image_comment_id=' + abc + '&comment=' + encodeURIComponent(txt),
                success: function (data) {


                    document.getElementById('imgeditcommenttwo' + abc).style.display = 'none';
                    document.getElementById('imgshowcommenttwo' + abc).style.display = 'block';
                    document.getElementById('imgeditsubmittwo' + abc).style.display = 'none';
                    document.getElementById('imgeditcommentboxtwo' + abc).style.display = 'block';
                    document.getElementById('imgeditcancletwo' + abc).style.display = 'none';
                    $('#' + 'imgshowcommenttwo' + abc).html(data);
                    $('.post-design-commnet-box').show();
                }
            });
        }
    });
}


function imgcomment_delete(clicked_id) {
    $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='imgcomment_deleted(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('#bidmodal').modal('show');
}

function imgcomment_deleted(clicked_id)
{
    var post_delete = document.getElementById("imgpost_delete_" + clicked_id);
    //alert(post_delete.value);
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/mul_delete_comment",
        dataType: 'json',
        data: 'post_image_comment_id=' + clicked_id + '&post_delete=' + post_delete.value,
        success: function (data) {
            //$('#' + 'insertimgcount' + post_delete.value).html(data.count);
            //                $('#' + 'insertcountimg' + post_delete.value).html(data.count);
            $('.' + 'insertimgcomment' + post_delete.value).html(data.comment);
            //   $('.comment_count_img' + post_delete.value).html(data.comment_count);
            $('.like_count_ext_img' + post_delete.value).html(data.comment_count);
            $('.post-design-commnet-box').show();
        }
    });
}


function imgcomment_deletetwo(clicked_id)
{
    $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='imgcomment_deletedtwo(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('#bidmodal').modal('show');
}


function imgcomment_deletedtwo(clicked_id)
{
    var post_delete1 = document.getElementById("imgpost_deletetwo_" + clicked_id);
    //        alert(post_delete1.value);
    //        return false;
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/mul_delete_commenttwo",
        data: 'post_image_comment_id=' + clicked_id + '&post_delete=' + post_delete1.value,
        dataType: "json",
        success: function (data) {
            //$('.' + 'insertcommenttwo' + post_delete1.value).html(data);
            $('.' + 'insertimgcommenttwo' + post_delete1.value).html(data.comment);
            $('#' + 'insertimgcount' + post_delete1.value).html(data.count);
            $('.like_count_ext_img' + post_delete1.value).html(data.comment_count);
            $('.post-design-commnet-box').show();
        }
    });
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
        document.getElementById('khyati' + abc).style.display = 'block';
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
                //                    document.getElementById('editpostdetails' + abc).style.display = 'block';
                document.getElementById('editpostdetailbox' + abc).style.display = 'none';
                document.getElementById('editpostsubmit' + abc).style.display = 'none';
                document.getElementById('khyati' + abc).style.display = 'block';
                $('#' + 'editpostdata' + abc).html(data.title);
                //                    $('#' + 'editpostdetails' + abc).html(data.description);
                $('#' + 'khyati' + abc).html(data.description);
            }
        });
    }
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
function likeuserlistimg(post_id) {

    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/imglikeuserlist",
        data: 'post_id=' + post_id,
        dataType: "html",
        success: function (data) {
            var html_data = data;
            $('#likeusermodal .mes').html(html_data);
            $('#likeusermodal').modal('show');
        }
    });
}

// post delete login user script start 

function user_postdelete(clicked_id)
{

    $('.biderror .mes').html("<div class='pop_content'> Do you want to delete this post?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='remove_post(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('#bidmodal').modal('show');
}

// post delete login user end 
// post delete particular login user script start 

function user_postdeleteparticular(clicked_id)
{

    $('.biderror .mes').html("<div class='pop_content'> Do You want to delete this post from your profile?.<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='del_particular_userpost(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('#bidmodal').modal('show');
}

// post delete particular login user end 
// This  script use for close dropdown in every post 

$('body').on("click", "*", function (e) {
    var classNames = $(e.target).prop("class").toString().split(' ').pop();
    if (classNames != 'fa-ellipsis-v') {
        $('div[id^=myDropdown]').hide().removeClass('show');
    }
});

$('body').on('touchstart', function (e) {
    var classNames = $(e.target).prop("class").toString().split(' ').pop();
    if (classNames != 'fa-ellipsis-v') {
        $('div[id^=myDropdown]').hide().removeClass('show');
    }
});

$(document).keydown(function (e) {
    if (!e)
        e = window.event;
    if (e.keyCode == 27 || e.charCode == 27) {
        closeModal();
    }
});
// This  script use for close dropdown in every post 

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


// all popup close close using esc start 

$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
//$( "#bidmodal" ).hide();
        $('#bidmodal').modal('hide');
    }
});
$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
//$( "#bidmodal" ).hide();
        $('#likeusermodal').modal('hide');
    }
});
// all popup close close using esc end

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
            //  document.getElementById('editpostdetails' + abc).style.display = 'block';
            document.getElementById('editpostdetailbox' + abc).style.display = 'none';
            document.getElementById('editpostsubmit' + abc).style.display = 'none';
            document.getElementById('khyati' + abc).style.display = 'none';
            document.getElementById('khyatii' + abc).style.display = 'block';
            //alert(data.description);
            $('#' + 'editpostdata' + abc).html(data.title);
            // $('#' + 'editpostdetails' + abc).html(data.description);
            $('#' + 'khyatii' + abc).html(data.description);
        }
    });
}


// edit post start 


// 180 words more than script start 



function seemorediv(abc) { //alert("hii");

    document.getElementById('seemore' + abc).style.display = 'block';
    document.getElementById('lessmore' + abc).style.display = 'none';
}

$('#postedit').on('click', function () {
// $('.my_text').attr('readonly', false);
});
$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
//$( "#bidmodal" ).hide();
        $('#postedit').modal('hide');
        // $('.my_text').attr('readonly', false);

        //$('.modal-post').show();

    }
});
// 180 words more than script end


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

function check_post_available(post_id) {
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/check_post_available",
        data: 'post_id=' + post_id,
        dataType: "json",
        success: function (data) {
            if (data == 0) {
                return false;
            }
        }
    });
}



function cursorpointer(abc) {

    elem = document.getElementById('editpostdesc' + abc);
    elem.focus();
    setEndOfContenteditable(elem);
}

function setEndOfContenteditable(contentEditableElement)
{
    var range, selection;
    if (document.createRange)//Firefox, Chrome, Opera, Safari, IE 9+
    {
        range = document.createRange();//Create a range (a range is a like the selection but invisible)
        range.selectNodeContents(contentEditableElement);//Select the entire contents of the element with the range
        range.collapse(false);//collapse the range to the end point. false means collapse to end rather than the start
        selection = window.getSelection();//get the selection object (allows you to change selection)
        selection.removeAllRanges();//remove any selections already made
        selection.addRange(range);//make the range you have just created the visible selection
    } else if (document.selection)//IE 8 and lower
    {
        range = document.body.createTextRange();//Create a range (a range is a like the selection but invisible)
        range.moveToElementText(contentEditableElement);//Select the entire contents of the element with the range
        range.collapse(false);//collapse the range to the end point. false means collapse to end rather than the start
        range.select();//Select the range (make it the visible selection
    }
}

