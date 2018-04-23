$(function () {
    $("#tags").autocomplete({
        source: function (request, response) {
            var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
            response($.grep(data, function (item) {
                return matcher.test(item.label);
            }));
        }
        ,
        minLength: 1,
        select: function (event, ui) {
            event.preventDefault();
            $("#tags").val(ui.item.label);
            $("#selected-tag").val(ui.item.label);
            // window.location.href = ui.item.value;
        }
        ,
        focus: function (event, ui) {
            event.preventDefault();
            $("#tags").val(ui.item.label);
        }
    });
}
);
$(function () {
    
    $("#searchplace").autocomplete({
        source: function (request, response) {
            var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
            response($.grep(data1, function (item) {
                return matcher.test(item.label);
            }));
        }
        ,
        minLength: 1,
        select: function (event, ui) {
            event.preventDefault();
            $("#searchplace").val(ui.item.label);
            $("#selected-tag").val(ui.item.label);
            // window.location.href = ui.item.value;
        }
        ,
        focus: function (event, ui) {
            event.preventDefault();
            $("#searchplace").val(ui.item.label);
        }
    });
}
);
$('#content').on('change keyup keydown paste cut', 'textarea', function () {
    $(this).height(0).height(this.scrollHeight);
}).find('textarea').change();

function checkvalue() {
    var searchkeyword = document.getElementById('tags').value;
    var searchplace = document.getElementById('searchplace').value;
    if (searchkeyword == "" && searchplace == "") {
        return false;
    }
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
            if (data.like_user_count == '0') {
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
            // khyati chnages  start

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
// khyati chnages end
        }
    });
    $(".scroll").click(function (event) {
        event.preventDefault();
        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
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
                    success: function (data) { //alert('falguni');

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
                    success: function (data) { //alert('falguni');
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

//comment edit insert script end 
// like comment script end 
// popup box for post start 

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

// drop down script zalak end 
// multi image add post khyati start 

//alert("a");
var $fileUpload = $("#files"),
        $list = $('#list'),
        thumbsArray = [],
        maxUpload = 5;
// READ FILE + CREATE IMAGE
function read(f) {
    //alert("aa");
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
    //alert("aaa");
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
    alert("aaaa");
    handleFileSelect(e);
}
);
$list.on('click', '.remove_thumb', function () {
    //alert("aaaaa");
    var $removeBtns = $('.remove_thumb');
    // Get all of them in collection
    var idx = $removeBtns.index(this);
    // Exact Index-from-collection
    $(this).closest('span.thumbParent').remove();
    // Remove tumbnail parent
    thumbsArray.splice(idx, 1);
    // Remove from array
});
// multi image add post khyati end 


function check_length(my_form)
{
    maxLen = 50;
    // max number of characters allowed
    if (my_form.my_text.value.length > maxLen) {
        // Alert message if maximum limit is reached. 
        // If required Alert can be removed. 
        var msg = "You have reached your maximum limit of characters allowed";
        //alert(msg);

        $('.biderror .mes').html("<div class='pop_content'>" + msg + "</div>");
        $('#bidmodal').modal('show');
        // Reached the Maximum length so trim the textarea
        my_form.my_text.value = my_form.my_text.value.substring(0, maxLen);
    } else {
        // Maximum length not reached so update the value of my_text counter
        my_form.text_num.value = maxLen - my_form.my_text.value.length;
    }
}
//

function editpost(abc)
{
    $("#myDropdown" + abc).removeClass('show');
    document.getElementById('editpostdata' + abc).style.display = 'none';
    document.getElementById('editpostbox' + abc).style.display = 'block';
//        document.getElementById('editpostdetails' + abc).style.display = 'none';
    document.getElementById('editpostdetailbox' + abc).style.display = 'block';
    document.getElementById('editpostsubmit' + abc).style.display = 'block';
    document.getElementById('khyatii' + abc).style.display = 'none';
    document.getElementById('khyati' + abc).style.display = 'none';
}


function edit_postinsert(abc)
{
    var editpostname = document.getElementById("editpostname" + abc);
    var $field = $('#editpostdesc' + abc);
    var editpostdetails = $('#editpostdesc' + abc).html();
    editpostdetails = editpostdetails.replace(/&/g, "%26");

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
            }
        });
    }
}

// edit post end 
// savepost start 

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
// remove save post start 

// remove save post end 
// remove particular user post start 

function del_particular_userpost(abc)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/del_particular_userpost",
        data: 'business_profile_post_id=' + abc,
        success: function (data) {
            $('#' + 'removepost' + abc).html(data);
            $('#' + 'removepost' + abc).remove;
        }
    });
}

// remove particular user post end 
// follow user script start 

function followuser(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/follow",
        data: 'follow_to=' + clicked_id,
        success: function (data) {
            $('.' + 'fr' + clicked_id).html(data);
            $("#fad" + clicked_id).fadeOut(6000);
        }
    });
}

function followclose(clicked_id)
{
    $("#fad" + clicked_id).fadeOut(4000);
}

$('#file-fr').fileinput({
    language: 'fr',
    uploadUrl: '#',
    allowedFileExtensions: ['jpg', 'png', 'gif']
});
$('#file-es').fileinput({
    language: 'es',
    uploadUrl: '#',
    allowedFileExtensions: ['jpg', 'png', 'gif']
});
$("#file-0").fileinput({
    'allowedFileExtensions': ['jpg', 'png', 'gif']
});
$("#file-1").fileinput({
    uploadUrl: '#', // you must set a valid URL here else you will get an error
    allowedFileExtensions: ['jpg', 'png', 'gif'],
    overwriteInitial: false,
    maxFileSize: 1000,
    maxFilesNum: 10,
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
        'allowedFileExtensions': ['jpg', 'png', 'gif'],
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
// insert post zalak script end 
// post insert developing script start 

$(document).ready(function ($jquery) {
});
function imgval(event) {

    var fileInput = document.getElementById("file-1").files;
    var product_name = document.getElementById("test-upload-product").value;
    var product_description = document.getElementById("test-upload-des").value;
    var product_fileInput = document.getElementById("file-1").value;
    if (product_fileInput == '' && product_name == '' && product_description == '')
    {

        $('#post .mes').html("<div class='pop_content'>This post appears to be blank. Please write or attach (photos, videos, audios, pdf) to post.");
        $('#post').modal('show');
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
            var allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            var allowesvideo = ['mp4', 'webm'];
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
                    $('#bidmodal').modal('show');
                    setInterval('window.location.reload()', 10000);
                    // window.location='';

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
    });
});
//This script is used for "This post appears to be blank. Please write or attach (photos, videos, audios, pdf) to post." comment click close then post add popup open end  
// post insert developing code end  
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
        url: base_url + "business_profile/business_profile_deletepost",
        data: 'business_profile_post_id=' + abc,
        dataType: "json",
        success: function (data) {
            $('#' + 'removepost' + abc).html(data.notfound);
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
    $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this post from your profile?.<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='del_particular_userpost(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('#bidmodal').modal('show');
}

// post delete particular login user end 
// This  script use for close dropdown in every post 

$('body').on("click", "*", function (e) {
    var classNames = $(e.target).attr("class").toString().split(' ').pop();
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
//

$(document).ready(function () {
    $('.alert-danger1').delay(3000).hide('700');
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
                    //$( "#bidmodal" ).hide();
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

//
jQuery(document).mouseup(function (e) {
    var container1 = $("#myModal");
    container1.show();
    if (container1.show())
    {
        jQuery(document).mouseup(function (e) {
            var container = $("#postpopup_close");
            if (!container.is(e.target)
                    && container.has(e.target).length === 0)
            {
                container1.hide();
            }
        });
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