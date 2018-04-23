$('#file-1').on('click', function () {
    var a = document.getElementById('test-upload-product').value;
    var b = document.getElementById('test-upload-des').value;
    document.getElementById("artpostform").reset();
    document.getElementById('test-upload-product').value = a;
    document.getElementById('test-upload-des').value = b;
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

$(document).ready(function () {
    ajax_business_home_post();
    ajax_business_home_three_user_list()

    $(window).on('scroll', function () {
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
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($(".page_number:last").val()) + 1;
                    ajax_business_home_post(pagenum);
                }
            }
        }
    });
});
var isProcessing = false;
function ajax_business_home_post(pagenum) {
    if (isProcessing) {
        return;
    }
    isProcessing = true;
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/ajax_business_home_post?page=" + pagenum,
        data: {total_record: $("#total_record").val()},
        dataType: "html",
        beforeSend: function () {
            if (pagenum == 'undefined') {
            } else {
            }
        },
        complete: function () {
        },
        success: function (data) {
            $('.business-all-post').append(data);
            var nb = $('.post-design-box').length;
            if (nb == 0) {
                $("#dropdownclass").addClass("no-post-h2");
            } else {
                $("#dropdownclass").removeClass("no-post-h2");
            }
            isProcessing = false;
            check_no_post_data();

            $('video, audio').mediaelementplayer();

        }
    });
}

function ajax_business_home_three_user_list() {
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/ajax_business_home_three_user_list/",
        data: '',
        dataType: "html",
        beforeSend: function () {
        },
        success: function (data) {
            $('.profile-boxProfileCard_follow').html(data);
            var liCount = $(data).find("li.follow_box_ul_li").length;
            if (liCount == 0) {
                $('.full-box-module_follow').hide();
            }
        }
    });
}

$('#content').on('change keyup keydown paste cut', 'textarea', function () {
    $(this).height(0).height(this.scrollHeight);
}).find('textarea').change();


/* POST LIKE SCRIPT START */
function post_like(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/check_post_available",
        data: 'post_id=' + clicked_id,
        success: function (data) {
            if (data == 1) {
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
            } else {
                $('.mes').html('Sorry this content is now not available');
                $('#bidmodal').modal('show');
            }
        }
    });
}
/* POST LIKE SCRIPT END */

/* COMMENT INSERT SCRIPT START */

function insert_comment(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/check_post_available",
        data: 'post_id=' + clicked_id,
        success: function (data) {
            if (data == 1) {
                $("#post_comment" + clicked_id).click(function () {
                    $(this).prop("contentEditable", true);
                    $(this).html("");
                });

                var sel = $("#post_comment" + clicked_id);
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
            } else {
                $('.mes').html('Sorry this content is now not available');
                $('#bidmodal').modal('show');
            }
        }
    });
}

/* COMMENT INSERT SCRIPT END */

/* INSERT COMMENT USING ENTER START */
function entercomment(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/check_post_available",
        data: 'post_id=' + clicked_id,
        success: function (data) {
            if (data == 1) {
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
                        txt = txt.replace(/div/gi, "p");
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
            } else {
                $('.mes').html('Sorry this content is now not available');
                $('#bidmodal').modal('show');
            }

        }
    });
}
/* INSERT COMMENT USING ENTER END */

/* HIDE AND SHOW DATA START */
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
            //alert(data);
            success: function (data) {
                $('#' + 'fourcomment' + clicked_id).html(data);
            }
        });
    }
}
/* HIDE AND SHOW DATA END */

/* COMMENT LIKE SCRIPT START */
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
        success: function (data) {
            if (data == 1) {
                $.ajax({
                    type: 'POST',
                    url: base_url + "business_profile/like_comment1",
                    data: 'post_id=' + clicked_id,
                    success: function (data) {
                        $('#' + 'likecomment1' + clicked_id).html(data);
                    }
                });
            } else {
                $('.mes').html('Sorry this content is now not available');
                $('#bidmodal').modal('show');
            }
        }
    });

}
/* COMMENT LIKE SCRIPT END */

/* COMMENT DELETE SCRIPT START */
function comment_delete(clicked_id) {
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/check_post_comment_available",
        data: 'post_id=' + clicked_id,
        success: function (data) {
            if (data == 1) {
                $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='comment_deleted(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                $('#bidmodal').modal('show');
            } else {
                $('.mes').html('This comment was already deleted.');
                $('#bidmodal').modal('show');
            }
        }
    });
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
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/check_post_comment_available",
        data: 'post_id=' + clicked_id,
        success: function (data) {
            if (data == 1) {
                $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='comment_deletedtwo(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                $('#bidmodal').modal('show');
            } else {
                $('.mes').html('Sorry this content is now not available');
                $('#bidmodal').modal('show');
            }
        }
    });

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
/* COMMENT DELETE SCRIPT END */

/* COMMENT EDIT BOX START */
function comment_editbox(clicked_id) {

    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/check_post_comment_available",
        data: 'post_id=' + clicked_id,
        success: function (data) {
            if (data == 1) {
                document.getElementById('editcomment' + clicked_id).style.display = 'inline-block';
                document.getElementById('showcomment' + clicked_id).style.display = 'none';
                document.getElementById('editsubmit' + clicked_id).style.display = 'inline-block';
                document.getElementById('editcommentbox' + clicked_id).style.display = 'none';
                document.getElementById('editcancle' + clicked_id).style.display = 'block';

                $('.post-design-commnet-box').hide();
            } else {
                $('.mes').html('Sorry this content is now not available');
                $('#bidmodal').modal('show');
            }
        }
    });
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

    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/check_post_comment_available",
        data: 'post_id=' + clicked_id,
        success: function (data) {
            if (data == 1) {
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
            } else {
                $('.mes').html('Sorry this content is now not available');
                $('#bidmodal').modal('show');
            }
        }
    });
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
/* COMMENT EDIT BOX END */

/* COMMENT EDIT INSERT START */
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
    $(".scroll").click(function (event) {
        event.preventDefault();
        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
    });
}

function commentedit(abc)
{
    $('#editcomment' + abc).keypress(function (event) {
        if (event.which == 13 && event.shiftKey != 1) {
            event.preventDefault();

            if (window.preventDuplicateKeyPresses)
                return;
            window.preventDuplicateKeyPresses = true;
            window.setTimeout(function () {
                window.preventDuplicateKeyPresses = false;
            }, 500);
            edit_comment(abc);
        }
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
    $('#editcommenttwo' + abc).keypress(function (event) {
        if (event.which == 13 && event.shiftKey != 1) {
            event.preventDefault();

            if (window.preventDuplicateKeyPresses)
                return;

            window.preventDuplicateKeyPresses = true;
            window.setTimeout(function () {
                window.preventDuplicateKeyPresses = false;
            }, 500);

            edit_commenttwo(abc);
        }
    });

}
function commentedit2(abc)
{
    $(document).ready(function () {
        $('#editcomment2' + abc).keypress(function (e) {
            if (e.keyCode == 13 && !e.shiftKey) {
                var val = $('#editcomment2' + abc).val();
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
                        document.getElementById('editcomment2' + abc).style.display = 'none';
                        document.getElementById('showcomment2' + abc).style.display = 'block';
                        document.getElementById('editsubmit2' + abc).style.display = 'none';
                        document.getElementById('editcommentbox2' + abc).style.display = 'block';
                        document.getElementById('editcancle2' + abc).style.display = 'none';
                        $('#' + 'showcomment2' + abc).html(data);
                    }
                });
            }
        });
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
}
function commentedit3(abc)
{
    $(document).ready(function () {
        $('#editcomment3' + abc).keypress(function (e) {
            if (e.keyCode == 13 && !e.shiftKey) {
                var val = $('#editcomment3' + clicked_id).val();
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
}
function commentedit4(abc)
{
    $(document).ready(function () {
        $('#editcomment4' + abc).keypress(function (e) {

            if (e.keyCode == 13 && !e.shiftKey) {
                var val = $('#editcomment4' + clicked_id).val();
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
/* COMMENT EDIT INSERT END */
/* POST BOX 50 CHARACTER LIMITATION CHECK START */
function check_length(my_form)
{
    maxLen = 50;
    // max number of characters allowed
    if (my_form.my_text.value.length > maxLen) {
        // Alert message if maximum limit is reached. 
        // If required Alert can be removed. 
        var msg = "You have reached your maximum limit of characters allowed";
        $("#test-upload-product").prop("readonly", true);
//        document.getElementById("test-upload-product").readOnly = true;
        $('.biderror .mes').html("<div class='pop_content'>" + msg + "</div>");
        $('#posterrormodal').modal('show');

        // Reached the Maximum length so trim the textarea
        my_form.my_text.value = my_form.my_text.value.substring(0, maxLen);
    } else {
//        $("#test-upload-product").prop("readonly", false);
        //document.getElementById("test-upload-product").readOnly = false;
        // Maximum length not reached so update the value of my_text counter
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
        $("#test-upload-product").prop("readonly", true);
        $('#postedit .mes').html("<div class='pop_content'>" + msg + "</div>");
        $('#postedit').modal('show');
        var substrval = product_name.substring(0, maxLen);
        $('#editpostname' + abc).val(substrval);
    } else {
        text_num = maxLen - product_name.length;
        $('#text_num_' + abc).val(parseInt(text_num));
//        document.getElementById("text_num").value = text_num;
    }
}
/* POST BOX 50 CHARACTER LIMITATION CHECK END */
/* SAVEPOST START */
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
/* SAVEPOST END */
/* FOLLOW USER SCRIPT START */
function followuser(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/home_three_follow",
        data: 'follow_to=' + clicked_id,
        dataType: 'json',
        success: function (data) {
            $('.' + 'fr' + clicked_id).html(data.follow);
            $('ul.home_three_follow_ul').append(data.third_user);

            $('.left_box_following_count').html('(' + data.following_count + ')')
            $.when($('.fad' + clicked_id).fadeOut(2000))
                    .done(function () {
                        $('.fad' + clicked_id).remove();
                        var liCount = $("ul.home_three_follow_ul li.follow_box_ul_li").length;
                        if (liCount == 0) {
                            $('.full-box-module_follow').hide();
                        }
                    });

        }
    });
}

function followclose(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/business_home_follow_ignore",
        data: 'follow_to=' + clicked_id,
        success: function (data) {
            if (data) {
                $.ajax({
                    type: 'POST',
                    url: base_url + "business_profile/third_follow_ignore_user_data",
                    dataType: 'html',
                    success: function (data) {
                        $('ul.home_three_follow_ul').append(data);
                        $.when($('.fad' + clicked_id).fadeOut(1500))
                                .done(function () {
                                    $('.fad' + clicked_id).remove();
                                    var liCount = $("ul.home_three_follow_ul li.follow_box_ul_li").length;
                                    if (liCount == 0) {
                                        $('.full-box-module_follow').hide();
                                    }
                                });
                    }
                });
            }
        }
    });
}
//function followclose(clicked_id)
//{
//    $.when($('.fad' + clicked_id).fadeOut(3000))
//            .done(function () {
//                business_home_follow_ignore(clicked_id);
//                ajax_business_home_three_user_list();
//            });
//}

function business_home_follow_ignore(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/business_home_follow_ignore",
        data: 'follow_to=' + clicked_id,
        success: function (data) {
            if (data) {
                return true;
            } else {
                return false;
            }
            var liCount = $("ul.home_three_follow_ul li.follow_box_ul_li").length;
            if (liCount == 1) {
                $('.full-box-module_follow').hide();
            }
        }
    });
}
/* FOLLOW USER SCRIPT END */

// POPUP BOX FOR POST START 

// Get the modal
var modal = document.getElementById('myModal');
// Get the button that opens the modal
var btn = document.getElementById("myBtn");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close1")[0];
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

// POPUP BOX FOR POST START 
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
// MULTI IMAGE ADD POST START 

var $fileUpload = $("#files"),
        $list = $('#list'),
        thumbsArray = [],
        maxUpload = 5;
// READ FILE + CREATE IMAGE
function read(f) {
    return function (e) {
        var base64 = e.target.result;
        var $img = $('<img/>', {
            src: base64,
            title: encodeURIComponent(f.name), //( escape() is deprecated! )
            "class": "thumb"
        });
        var $thumbParent = $("<span/>", {
            html: $img, "class": "thumbParent"}
        ).append('<span class="remove_thumb"/>');
        thumbsArray.push(base64);
        // Push base64 image into array or whatever.
        $list.append($thumbParent);
    };
}
// HANDLE FILE/S UPLOAD
function handleFileSelect(e) {
    e.preventDefault();
    // Needed?
    var files = e.target.files;
    var len = files.length;
    if (len > maxUpload || thumbsArray.length >= maxUpload) {
        return alert("Sorry you can upload only 5 images");
    }
    for (var i = 0; i < len; i++) {
        var f = files[i];
        if (!f.type.match('image.*'))
            continue;
        // Only images allowed    
        var reader = new FileReader();
        reader.onload = read(f);
        // Call read() function
        reader.readAsDataURL(f);
    }
}
$fileUpload.change(function (e) {
    handleFileSelect(e);
});
$list.on('click', '.remove_thumb', function () {
    var $removeBtns = $('.remove_thumb');
    // Get all of them in collection
    var idx = $removeBtns.index(this);
    // Exact Index-from-collection
    $(this).closest('span.thumbParent').remove();
    // Remove tumbnail parent
    thumbsArray.splice(idx, 1);
    // Remove from array
});


$('#file-fr').fileinput({
    language: 'fr',
    uploadUrl: '#',
    allowedFileExtensions: ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg', 'mp4', 'mp3', 'pdf']
});
$('#file-es').fileinput({
    language: 'es',
    uploadUrl: '#',
    allowedFileExtensions: ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg', 'mp4', 'mp3', 'pdf']
});
$("#file-0").fileinput({
    'allowedFileExtensions': ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg', 'mp4', 'mp3', 'pdf']
});
$("#file-1").fileinput({
    uploadUrl: '#', // you must set a valid URL here else you will get an error
    allowedFileExtensions: ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg', 'mp4', 'mp3', 'pdf'],
    overwriteInitial: false,
    maxFileSize: 1000000,
    maxFilesNum: 10,
    //allowedFileTypes: ['image','video', 'flash'],
    slugCallback: function (filename) {
        return filename.replace('(', '_').replace(']', '_');
    }
});
$("#file-3").fileinput({
    showUpload: false,
    showCaption: false,
    browseClass: "btn btn-primary btn-lg",
    fileType: "any",
    previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
    overwriteInitial: false,
    initialPreviewAsData: true,
    initialPreview: [
        "http://lorempixel.com/1920/1080/transport/1",
        "http://lorempixel.com/1920/1080/transport/2",
        "http://lorempixel.com/1920/1080/transport/3",
    ],
    initialPreviewConfig: [
        {
            caption: "transport-1.jpg", size: 329892, width: "120px", url: "{$url}", key: 1}
        ,
        {
            caption: "transport-2.jpg", size: 872378, width: "120px", url: "{$url}", key: 2}
        ,
        {
            caption: "transport-3.jpg", size: 632762, width: "120px", url: "{$url}", key: 3}
        ,
    ],
});
$("#file-4").fileinput({
    uploadExtraData: {
        kvId: '10'}
});
$(".btn-warning").on('click', function () {
    var $el = $("#file-4");
    if ($el.attr('disabled')) {
        $el.fileinput('enable');
    } else {
        $el.fileinput('disable');
    }
});
$(".btn-info").on('click', function () {
    $("#file-4").fileinput('refresh', {
        previewClass: 'bg-info'});
});
$(document).ready(function () {
    $("#test-upload").fileinput({
        'showPreview': false,
        'allowedFileExtensions': ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg', 'mp4', 'mp3', 'pdf'],
        'elErrorContainer': '#errorBlock'
    });
    $("#kv-explorer").fileinput({
        'theme': 'explorer',
        'uploadUrl': '#',
        overwriteInitial: false,
        initialPreviewAsData: true,
        initialPreview: [
            "http://lorempixel.com/1920/1080/nature/1",
            "http://lorempixel.com/1920/1080/nature/2",
            "http://lorempixel.com/1920/1080/nature/3",
        ],
        initialPreviewConfig: [
            {
                caption: "nature-1.jpg", size: 329892, width: "120px", url: "{$url}", key: 1}
            ,
            {
                caption: "nature-2.jpg", size: 872378, width: "120px", url: "{$url}", key: 2}
            ,
            {
                caption: "nature-3.jpg", size: 632762, width: "120px", url: "{$url}", key: 3}
            ,
        ]
    });
});

// MULTI IMAGE ADD POST START 
// POST DEVELOPING SCRIPT START 

function imgval(event) {
    var fileInput = document.getElementById("file-1").files;
    var product_name = document.getElementById("test-upload-product").value;
    var product_trim = product_name.trim();
    var product_description = document.getElementById("test-upload-des").value;
    var des_trim = product_description.trim();
    var product_fileInput = document.getElementById("file-1").value;
    if (product_fileInput == '' && product_trim == '' && des_trim == '')
    {
        $('#post .mes').html("<div class='pop_content'>This post appears to be blank. Please write or attach (photos, videos, audios, pdf) to post.");
        $('#post').modal('show');
        $(document).on('keydown', function (e) {
            if (e.keyCode === 27) {
                $('#posterrormodal').modal('hide');
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
            var allowedExtensions = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg'];
            var allowesvideo = ['mp4', 'webm', 'mov', 'MP4'];
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
                    $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf.");
                    $('#posterrormodal').modal('show');
                    setInterval('window.location.reload()', 10000);
                    $(document).on('keydown', function (e) {
                        if (e.keyCode === 27) {
                            $('#posterrormodal').modal('hide');
                            $('.modal-post').show();
                        }
                    });
                    event.preventDefault();
                    return false;
                }
            } else if (foundPresentvideo == true)
            {
                var foundPresent1 = $.inArray(ext1, allowesvideo) > -1;
                if (foundPresent1 == true && fileInput.length == 1) {
                } else {
                    $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf.");
                    $('#posterrormodal').modal('show');
                    setInterval('window.location.reload()', 10000);

                    $(document).on('keydown', function (e) {
                        if (e.keyCode === 27) {
                            $('#posterrormodal').modal('hide');
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
                        $('#posterrormodal').modal('show');
                        //setInterval('window.location.reload()', 10000);

                        $(document).on('keydown', function (e) {
                            if (e.keyCode === 27) {
                                //$( "#bidmodal" ).hide();
                                $('#posterrormodal').modal('hide');
                                $('.modal-post').show();
                            }
                        });
                        event.preventDefault();
                        return false;
                    }

                } else {
                    $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf.");
                    $('#posterrormodal').modal('show');
                    setInterval('window.location.reload()', 10000);

                    $(document).on('keydown', function (e) {
                        if (e.keyCode === 27) {
                            $('#posterrormodal').modal('hide');
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
                        $('#posterrormodal').modal('show');
                        setInterval('window.location.reload()', 10000);

                        $(document).on('keydown', function (e) {
                            if (e.keyCode === 27) {
                                $('#posterrormodal').modal('hide');
                                $('.modal-post').show();
                            }
                        });
                        event.preventDefault();
                        return false;
                    }
                } else {
                    if (fileInput.length > 10) {
                        $('.biderror .mes').html("<div class='pop_content'>You can not upload more than 10 files at a time.");
                    } else {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf.");
                    }
                    $('#posterrormodal').modal('show');
                    setInterval('window.location.reload()', 10000);

                    $(document).on('keydown', function (e) {
                        if (e.keyCode === 27) {
                            $('#posterrormodal').modal('hide');
                            $('.modal-post').show();

                        }
                    });
                    event.preventDefault();
                    return false;
                }
            } else if (foundPresentvideo == false) {

                $('.biderror .mes').html("<div class='pop_content'>This File Format is not supported Please Try to Upload MP4 or WebM files..");
                $('#posterrormodal').modal('show');
                setInterval('window.location.reload()', 10000);

                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
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
    });
});
//This script is used for "This post appears to be blank. Please write or attach (photos, videos, audios, pdf) to post." comment click close then post add popup open end  

// POST DEVELOPING SCRIPT END 

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
                        $('.comment_count' + clicked_id).html(data.comment_count);
                    }
                });
            } else {
                $.ajax({
                    type: 'POST',
                    url: base_url + "business_profile/insert_comment",
                    data: 'post_id=' + clicked_id + '&comment=' + encodeURIComponent(txt),
                    success: function (data) {
                        $('input').each(function () {
                            $(this).val('');
                        }
                        );
                        $('#' + 'fourcomment' + clicked_id).html(data);
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


function remove_post(abc)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/business_profile_deleteforpost",
        dataType: 'json',
        data: 'business_profile_post_id=' + abc,
        success: function (data) {
            $('#' + 'removepost' + abc).remove();
//            if (data.notcount == 'count') {
//                $('.' + 'nofoundpost').html(data.notfound);
//            }
            var nb = $('.post-design-box').length;
            if (nb == 0) {
                $("#dropdownclass").addClass("no-post-h2");
            } else {
                $("#dropdownclass").removeClass("no-post-h2");
            }

//            var total_post = $('.post-design-box').length;
//            if (total_post == 0) {
//                $('.art_no_post_avl').show();
//            }

            check_no_post_data();
        }
    });
}

// remove particular user post start 

function del_particular_userpost(abc)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/del_particular_userpost",
        dataType: 'json',
        data: 'business_profile_post_id=' + abc,
        success: function (data) {
            $('#' + 'removepost' + abc).remove();
            /*if (data.notcount == 'count') {
             $('.' + 'nofoundpost').html(data.notfound);
             }*/
            check_no_post_data();
        }
    });
}

// remove particular user post end 
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
    $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this post from your profile?.<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='del_particular_userpost(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('#bidmodal').modal('show');
}

// post delete particular login user end 
// This  script use for close dropdown in every post 

$('body').on("click", "*", function (e) {
    //var classNames = $(e.target).attr("class").toString().split(' ').pop();
    var classNames = $(e.target).prop("class").toString().split(' ').pop();
    if (classNames != 'fa-ellipsis-v') {
        $('div[id^=myDropdown]').hide().removeClass('show');
    }
});

$('body').on('touchstart', function (e) {
    //var classNames = $(e.target).attr("class").toString().split(' ').pop();
    var classNames = $(e.target).prop("class").toString().split(' ').pop();
    if (classNames != 'fa-ellipsis-v') {
        $('div[id^=myDropdown]').hide().removeClass('show');
    }
});

// This  script use for close dropdown in every post 

$(".like_ripple").click(function (e) {
    // Remove any old one
    $(".ripple").remove();
    // Setup
    var posX = $(this).offset().left,
            posY = $(this).offset().top,
            buttonWidth = $(this).width(),
            buttonHeight = $(this).height();
    // Add the element
    $(this).prepend("<span class='ripple'></span>");
    // Make it round!
    if (buttonWidth >= buttonHeight) {
        buttonHeight = buttonWidth;
    } else {
        buttonWidth = buttonHeight;
    }
    // Get the center of the element
    var x = e.pageX - posX - buttonWidth / 2;
    var y = e.pageY - posY - buttonHeight / 2;
    // Add the ripples CSS and start the animation
    $(".ripple").css({
        width: buttonWidth,
        height: buttonHeight,
        top: y + 'px',
        left: x + 'px'
    }).addClass("rippleEffect");
});


$(document).ready(function () {
    $('video').mediaelementplayer({
        alwaysShowControls: false,
        videoVolume: 'horizontal',
        features: ['playpause', 'progress', 'volume', 'fullscreen']
    });
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
        document.getElementById('myModal').style.display = "none";
    }
});


// Get the modal
var modal = document.getElementById('myModal');
// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}


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
    var container1 = $("#myModal");
    jQuery(document).mouseup(function (e)
    {
        var container = $("#close");
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
        //$( "#bidmodal" ).hide();
        $('#likeusermodal').modal('hide');
        $("#test-upload-product").prop("readonly", false);
    }
});

$('.posterror-modal-close').on('click', function () {
//    $('#myModal').modal('show');
    document.getElementById('myModal').style.display = 'block';
    $("#test-upload-product").prop("readonly", false);

});


// all popup close close using esc end

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

// edit post start 

function editpost(abc)
{
//    $("#myDropdown" + abc).removeClass('show');
//    document.getElementById('editpostdata' + abc).style.display = 'none';
//    document.getElementById('editpostbox' + abc).style.display = 'block';
//    document.getElementById('editpostdetailbox' + abc).style.display = 'block';
//    document.getElementById('editpostsubmit' + abc).style.display = 'block';
//    document.getElementById('khyatii' + abc).style.display = 'none';
//    document.getElementById('khyati' + abc).style.display = 'none';

    var editposttitle = $('#editpostdata' + abc + ' a').html();
    var editpostdesc = $('#khyatii' + abc).html();
    $("#myDropdown" + abc).removeClass('show');
    document.getElementById('editpostdata' + abc).style.display = 'none';
    document.getElementById('editpostbox' + abc).style.display = 'block';
    //    document.getElementById('editpostdetails' + abc).style.display = 'none';
    document.getElementById('editpostdetailbox' + abc).style.display = 'block';
    document.getElementById('editpostsubmit' + abc).style.display = 'block';
    document.getElementById('khyatii' + abc).style.display = 'none';
    document.getElementById('khyati' + abc).style.display = 'none';

    editposttitle = editposttitle.trim();
    editpostdesc = editpostdesc.trim();

    $('#editpostname' + abc).val(editposttitle);
    $('#editpostdesc' + abc).html(nl2br(editpostdesc));

    var input = $("#editpostdesc" + abc);
    var len = input.text().length;
    input.text().focus();
    input.text().setSelectionRange(len, len);
}

function edit_postinsert(abc)
{
    var editpostname = document.getElementById("editpostname" + abc);
    var $field = $('#editpostdesc' + abc);
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

jQuery(document).ready(function ($) {
//    var bar = $('#bar');
//    var percent = $('#percent');
    var bar = $('.progress-bar');
    var percent = $('.sr-only');
    var options = {
        beforeSend: function () {
            $('body').removeClass('modal-open');
            // Replace this with your loading gif image
            document.getElementById("progress_div").style.display = "block";
            var percentVal = '0%';
            bar.width(percentVal)
            percent.html(percentVal);
            document.getElementById("myModal").style.display = "none";
        },
        uploadProgress: function (event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal)
            percent.html(percentVal);
        },
        success: function () {
//            var percentVal = '100%';
//            bar.width(percentVal)
//            percent.html(percentVal);
        },
        complete: function (response) {

            var percentVal = '100%';
            bar.width(percentVal)
            percent.html(percentVal);

            $('.art_no_post_avl').hide();
            // Output AJAX response to the div container
            document.getElementById('test-upload-product').value = '';
            document.getElementById('test-upload-des').value = '';
            document.getElementById('file-1').value = '';
            $("input[name='text_num']").val(50);
            $(".file-preview-frame").hide();
            document.getElementById("progress_div").style.display = "none";
            // $('.business-all-post').find('.post-design-box:first').parent().remove();
            $(".business-all-post").prepend(response.responseText);
            $('video, audio').mediaelementplayer();
            // second header class add for scroll
            var nb = $('.post-design-box').length;
            if (nb == 0) {
                $("#dropdownclass").addClass("no-post-h2");
            } else {
                document.getElementById("art_no_post_avl").style.display = "none";
                $("#dropdownclass").removeClass("no-post-h2");
            }
            $('html, body').animate({scrollTop: $(".upload-image-messages").offset().top - 100}, 150);
            check_no_post_data();

        }
    };
    // Submit the form
    $(".upload-image-form").ajaxForm(options);
    return false;
});


// 180 words more than script start 

function seemorediv(abc) {
    document.getElementById('seemore' + abc).style.display = 'block';
    document.getElementById('lessmore' + abc).style.display = 'none';
}

// 180 words more than script end
//$(window).load(function () {
$(window).on('load', function () {
    var nb = $('.post-design-box').length;
    if (nb == 0) {
        $("#dropdownclass").addClass("no-post-h2");
    }
});

$('#postedit').on('click', function () {
});
$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        $('#postedit').modal('hide');
    }
});
$(document).keydown(function (e) {
    if (!e)
        e = window.event;
    if (e.keyCode == 27 || e.charCode == 27) {
        $('.modal').modal('hide');
    }
});


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

function check_no_post_data() {
    var numberPost = $('[id^="removepost"]').length;
    if (numberPost == 0) {
        $('.business-all-post').html(no_business_post_html);
    }
}

$('.editor-content').click(function () {
    $('body').addClass('modal-open');
});

$('.close1').click(function () {
    $('body').removeClass('modal-open');
});


function removeimage() {
    var fileInput = document.getElementById("file-1").files;
    var ab = $(this).index();
    alert(ab);
    for (var i = 0; i < fileInput.length; i++)
    {
        var vname = fileInput[i].name;
        
    }
}