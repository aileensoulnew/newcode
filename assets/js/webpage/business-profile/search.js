$(document).ready(function () {
    business_search_post();

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
                    business_search_post(pagenum);
                }
            }
        }
    });
});
var isProcessing = false;
function business_search_post(pagenum) {
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
        url: base_url + "search/ajax_business_search?page=" + pagenum + "&skills=" + keyword + "&searchplace=" + keyword1,
        data: {total_record: $("#total_record").val()},
        dataType: "html",
        beforeSend: function () {
            if (pagenum == 'undefined') {
                // $(".business-all-post").prepend('<p style="text-align:center;"><img class="loader" src="' + base_url + 'images/loading.gif"/></p>');
            } else {
                $('#loader').show();
            }
        },
        complete: function () {
            $('#loader').hide();
        },
        success: function (data) {
            $('.loader').remove();
            $('.job-contact-frnd').append(data);

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

function check() {
    var keyword = $.trim(document.getElementById('tags1').value);
    var place = $.trim(document.getElementById('searchplace1').value);
    if (keyword == "" && place == "") {
        return false;
    }
}



var text = document.getElementById("search").value;
$(".search").highlite({
    text: text
});
function checkvalue() {
    var searchkeyword = $.trim(document.getElementById('tags').value);
    var searchplace = $.trim(document.getElementById('searchplace').value);
    if (searchkeyword == "" && searchplace == "") {
        return false;
    }
}

//select2 autocomplete start for Location
$('#searchplace').select2({
    placeholder: 'Find Your Location',
    maximumSelectionLength: 1,
    ajax: {
        url: base_url + "business_profile/location",
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            return {
                //alert(data);
                results: data
            };
        }
        ,
        cache: true
    }
});
// like comment script start 
// post like script start 

function post_like(clicked_id)
{
    //alert(clicked_id);
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
    if (txt == '') {
        return false;
    }

    $('#post_comment' + clicked_id).html("");
    var x = document.getElementById('threecomment' + clicked_id);
    var y = document.getElementById('fourcomment' + clicked_id);
    if (x.style.display === 'block' && y.style.display === 'none') {
        $.ajax({
            type: 'POST',
            url: base_url + "business_profile/insert_commentthree",
            data: 'post_id=' + clicked_id + '&comment=' + txt,
            dataType: "json",
            success: function (data) {
                $('textarea').each(function () {
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
            data: 'post_id=' + clicked_id + '&comment=' + txt,
            dataType: "json",
            success: function (data) {
                $('textarea').each(function () {
                    $(this).val('');
                });
                $('#' + 'insertcount' + clicked_id).html(data.count);
                $('#' + 'fourcomment' + clicked_id).html(data.comment);
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
            if (txt == '') {
                return false;
            }

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
                    data: 'post_id=' + clicked_id + '&comment=' + txt,
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
                    data: 'post_id=' + clicked_id + '&comment=' + txt,
                    dataType: "json",
                    success: function (data) {
                        $('textarea').each(function () {
                            $(this).val('');
                        });
                        $('#' + 'insertcount' + clicked_id).html(data.count);
                        $('#' + 'fourcomment' + clicked_id).html(data.comment);
                        $('.' + 'comment_count' + clicked_id).html(data.comment_count);
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

//comment insert script end 
// hide and show data start

function commentall(clicked_id) {
    var x = document.getElementById('threecomment' + clicked_id);
    var y = document.getElementById('fourcomment' + clicked_id);
    var z = document.getElementById('insertcount' + clicked_id);
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

// hide and show data end
// comment like script start 

function comment_like(clicked_id)
{
//alert(clicked_id);
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/like_comment",
        data: 'post_id=' + clicked_id,
        success: function (data) {
            //alert('.' + 'likepost' + clicked_id);
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
    $('.biderror .mes').html("<div class='pop_content'>Are you sure you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='comment_deleted(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
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
            $('.' + 'comment_count' + post_delete.value).html(data.comment_count);
            $('.post-design-commnet-box').show();
        }
    });
}

function comment_deletetwo(clicked_id)
{

    $('.biderror .mes').html("<div class='pop_content'>Are you sure want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='comment_deletedtwo(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
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
            $('.comment_count' + post_delete1.value).html(data.total_comment_count + ' <span> Comment</span>');
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

function comment_editbox3(clicked_id) { //alert(clicked_id); alert('editcomment' + clicked_id); alert('showcomment' + clicked_id); alert('editsubmit' + clicked_id); 
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


//comment edit box end
// comment edit insert start 

//    function edit_comment(abc)
//    {
//        var post_comment_edit = document.getElementById("editcomment" + abc);
//        var $field = $('#editcomment' + abc);
//        var post_comment_edit = $('#editcomment' + abc).html();
//        $.ajax({
//            type: 'POST',
//            url: base_url + "business_profile/edit_comment_insert",
//            data: 'post_id=' + abc + '&comment=' + post_comment_edit,
//            success: function (data) {
//                document.getElementById('editcomment' + abc).style.display = 'none';
//                document.getElementById('showcomment' + abc).style.display = 'block';
//                document.getElementById('editsubmit' + abc).style.display = 'none';
//                document.getElementById('editcommentbox' + abc).style.display = 'block';
//                document.getElementById('editcancle' + abc).style.display = 'none';
//                $('#' + 'showcomment' + abc).html(data);
//            }
//        });
//    }

function edit_comment(abc)
{
//var post_comment_edit = document.getElementById("editcomment" + abc);

    $("#editcomment" + abc).click(function () {
        $(this).prop("contentEditable", true);
        //     $(this).html("");
    });
    var sel = $("#editcomment" + abc);
    var txt = sel.html();
    if (txt == '' || txt == '<br>') {
        return false;
    }
//                    alert(txt);
//                    return false;
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/edit_comment_insert",
        data: 'post_id=' + abc + '&comment=' + txt,
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



//    function commentedit(abc)
//    {
//        $(document).ready(function () {
//            $('#editcomment' + abc).keypress(function (e) {
//                if (e.keyCode == 13 && !e.shiftKey) {     //                    var val = $('#editcomment' + abc).val();
//                    e.preventDefault();
//                    if (window.preventDuplicateKeyPresses)
//                        return;
//                    window.preventDuplicateKeyPresses = true;
//                    window.setTimeout(function () {
//                        window.preventDuplicateKeyPresses = false;
//                    }, 500);
//                    $.ajax({
//                        type: 'POST',
//                        url: base_url + "business_profile/edit_comment_insert",
//                        data: 'post_id=' + abc + '&comment=' + val,
//                        success: function (data) {     //                            document.getElementById('editcomment' + abc).style.display = 'none';
//                            document.getElementById('showcomment' + abc).style.display = 'block';
//                            document.getElementById('editsubmit' + abc).style.display = 'none';
//                            document.getElementById('editcommentbox' + abc).style.display = 'block';
//                            document.getElementById('editcancle' + abc).style.display = 'none';
//                            $('#' + 'showcomment' + abc).html(data);
//                        }
//                    });
//                }
//            });
//        });
//    }

function commentedit(abc)
{
//                    alert(1212121);
//                    return false;
//$(document).ready(function () {

    $("#editcomment" + abc).click(function () {
        $(this).prop("contentEditable", true);
        //$(this).html("");
    });
    $('#editcomment' + abc).keypress(function (event) {
        if (event.which == 13 && event.shiftKey != 1) {
            event.preventDefault();
            var sel = $("#editcomment" + abc);
            var txt = sel.html();
            if (txt == '' || txt == '<br>') {
                return false;
            }
//$('#editcomment' + abc).html("");

            if (window.preventDuplicateKeyPresses)
                return;
            window.preventDuplicateKeyPresses = true;
            window.setTimeout(function () {
                window.preventDuplicateKeyPresses = false;
            }, 500);
            $.ajax({
                type: 'POST',
                url: base_url + "business_profile/edit_comment_insert",
                data: 'post_id=' + abc + '&comment=' + txt,
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
    //});
}



//    function edit_commenttwo(abc)
//    {
//        var post_comment_edit = document.getElementById("editcommenttwo" + abc);
//        $.ajax({
//            type: 'POST',
//            url: base_url + "business_profile/edit_comment_insert",
//            data: 'post_id=' + abc + '&comment=' + post_comment_edit.value,
//            success: function (data) {
//                document.getElementById('editcommenttwo' + abc).style.display = 'none';
//                document.getElementById('showcommenttwo' + abc).style.display = 'block';
//                document.getElementById('editsubmittwo' + abc).style.display = 'none';
//                document.getElementById('editcommentboxtwo' + abc).style.display = 'block';
//                document.getElementById('editcancletwo' + abc).style.display = 'none';
//                $('#' + 'showcommenttwo' + abc).html(data);
//            }
//        });
//    }


function edit_commenttwo(abc)
{
//var post_comment_edit = document.getElementById("editcommenttwo" + abc);

    $("#editcommenttwo" + abc).click(function () {
        $(this).prop("contentEditable", true);
        //$(this).html("");
    });
    var sel = $("#editcommenttwo" + abc);
    var txt = sel.html();
    if (txt == '' || txt == '<br>') {
        return false;
    }
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/edit_comment_insert",
        data: 'post_id=' + abc + '&comment=' + txt,
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


//                function commentedittwo(abc)
//                {
//                    $(document).ready(function () {     //                        $('#editcommenttwo' + abc).keypress(function (e) {
//                            if (e.keyCode == 13 && !e.shiftKey) {
//                                var val = $('#editcommenttwo' + abc).val();
//                                e.preventDefault();
//
//                                if (window.preventDuplicateKeyPresses)
//                                    return;
//
//                                window.preventDuplicateKeyPresses = true;
//                                window.setTimeout(function () {
//                                    window.preventDuplicateKeyPresses = false;
//                                }, 500);
//
//                                $.ajax({
//                                    type: 'POST',
//                                    url: base_url + "business_profile/edit_comment_insert",
//                                    data: 'post_id=' + abc + '&comment=' + val,
//                                    success: function (data) { //alert('falguni');
//
//
//                                        document.getElementById('editcommenttwo' + abc).style.display = 'none';
//                                        document.getElementById('showcommenttwo' + abc).style.display = 'block';
//                                        document.getElementById('editsubmittwo' + abc).style.display = 'none';
//
//                                        document.getElementById('editcommentboxtwo' + abc).style.display = 'block';
//                                        document.getElementById('editcancletwo' + abc).style.display = 'none';
//                                        //alert('.' + 'showcomment' + abc);
//
//                                        $('#' + 'showcommenttwo' + abc).html(data);
//                                        $('.post-design-commnet-box').show();
//
//
//                                    }
//                                });
//                            }
//                        });
//                    });
//
//                }

function commentedittwo(abc)
{
//$(document).ready(function () {
    $("#editcommenttwo" + abc).click(function () {
        $(this).prop("contentEditable", true);
        //$(this).html("");
    });
    $('#editcommenttwo' + abc).keypress(function (event) {
        if (event.which == 13 && event.shiftKey != 1) {
            event.preventDefault();
            var sel = $("#editcommenttwo" + abc);
            var txt = sel.html();
            if (txt == '' || txt == '<br>') {
                return false;
            }

//$('#editcommenttwo' + abc).html("");

            if (window.preventDuplicateKeyPresses)
                return;
            window.preventDuplicateKeyPresses = true;
            window.setTimeout(function () {
                window.preventDuplicateKeyPresses = false;
            }, 500);
            $.ajax({
                type: 'POST',
                url: base_url + "business_profile/edit_comment_insert",
                data: 'post_id=' + abc + '&comment=' + txt,
                success: function (data) { //alert('falguni');


                    document.getElementById('editcommenttwo' + abc).style.display = 'none';
                    document.getElementById('showcommenttwo' + abc).style.display = 'block';
                    document.getElementById('editsubmittwo' + abc).style.display = 'none';
                    document.getElementById('editcommentboxtwo' + abc).style.display = 'block';
                    document.getElementById('editcancletwo' + abc).style.display = 'none';
                    //alert('.' + 'showcomment' + abc);

                    $('#' + 'showcommenttwo' + abc).html(data);
                    $('.post-design-commnet-box').show();
                }
            });
        }
    });
    //});
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
                        //alert('falguni');
                        //  $('input').each(function(){
                        //     $(this).val('');
                        // }); 
                        document.getElementById('editcomment2' + abc).style.display = 'none';
                        document.getElementById('showcomment2' + abc).style.display = 'block';
                        document.getElementById('editsubmit2' + abc).style.display = 'none';
                        document.getElementById('editcommentbox2' + abc).style.display = 'block';
                        document.getElementById('editcancle2' + abc).style.display = 'none';
                        //alert('.' + 'showcomment' + abc);
                        $('#' + 'showcomment2' + abc).html(data);
                    }
                });
                //alert(val);
            }
        });
    });
}


function edit_comment3(abc)
{ //alert('editsubmit' + abc);

    var post_comment_edit = document.getElementById("editcomment3" + abc);
    //alert(post_comment.value);
    //alert(post_comment.value);
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/edit_comment_insert",
        data: 'post_id=' + abc + '&comment=' + post_comment_edit.value,
        success: function (data) { //alert('falguni');

            //  $('input').each(function(){
            //     $(this).val('');
            // }); 
            document.getElementById('editcomment3' + abc).style.display = 'none';
            document.getElementById('showcomment3' + abc).style.display = 'block';
            document.getElementById('editsubmit3' + abc).style.display = 'none';
            document.getElementById('editcommentbox3' + abc).style.display = 'block';
            document.getElementById('editcancle3' + abc).style.display = 'none';
            //alert('.' + 'showcomment' + abc);
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

                        //  $('input').each(function(){
                        //     $(this).val('');
                        // }); 
                        document.getElementById('editcomment3' + abc).style.display = 'none';
                        document.getElementById('showcomment3' + abc).style.display = 'block';
                        document.getElementById('editsubmit3' + abc).style.display = 'none';
                        document.getElementById('editcommentbox3' + abc).style.display = 'block';
                        document.getElementById('editcancle3' + abc).style.display = 'none';
                        //alert('.' + 'showcomment' + abc);                             $('#' + 'showcomment3' + abc).html(data);



                    }
                });
                //alert(val);
            }
        });
    });
}


function edit_comment4(abc)
{ //alert('editsubmit' + abc);

    var post_comment_edit = document.getElementById("editcomment4" + abc);
    //alert(post_comment.value);
    //alert(post_comment.value);
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/edit_comment_insert",
        data: 'post_id=' + abc + '&comment=' + post_comment_edit.value,
        success: function (data) { //alert('falguni');

            //  $('input').each(function(){
            //     $(this).val('');
            // }); 
            document.getElementById('editcomment4' + abc).style.display = 'none';
            document.getElementById('showcomment4' + abc).style.display = 'block';
            document.getElementById('editsubmit4' + abc).style.display = 'none';
            document.getElementById('editcommentbox4' + abc).style.display = 'block';
            document.getElementById('editcancle4' + abc).style.display = 'none';
            //alert('.' + 'showcomment' + abc);
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

                        //  $('input').each(function(){
                        //     $(this).val('');
                        // }); 
                        document.getElementById('editcomment4' + abc).style.display = 'none';
                        document.getElementById('showcomment4' + abc).style.display = 'block';
                        document.getElementById('editsubmit4' + abc).style.display = 'none';
                        document.getElementById('editcommentbox4' + abc).style.display = 'block';
                        document.getElementById('editcancle4' + abc).style.display = 'none';
                        //alert('.' + 'showcomment' + abc);
                        $('#' + 'showcomment4' + abc).html(data);
                    }
                });
                //alert(val);
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
var btn = document.getElementById("myBtn"); // Get the <span> element that closes the modal
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

// further and less 
//<script src="../js/jquery-1.8.2.js">

// drop down script zalak start 

/* When the user clicks on the button, 
 toggle between hiding and showing the dropdown content */
function myFunction(clicked_id) {
    document.getElementById('myDropdown' + clicked_id).classList.toggle("show");
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
        // Call read() function             reader.readAsDataURL(f);
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
    if (my_form.my_text.value.length >= maxLen) {
        // Alert message if maximum limit is reached. 
        // If required Alert can be removed. 
        var msg = "You have reached your maximum limit of characters allowed";
        alert(msg);
        // Reached the Maximum length so trim the textarea
        my_form.my_text.value = my_form.my_text.value.substring(0, maxLen);
    } else {
        // Maximum length not reached so update the value of my_text counter
        my_form.text_num.value = maxLen - my_form.my_text.value.length;
    }
}
//

//- khyati change end
// edit post start 

function editpost(abc)
{
    document.getElementById('editpostdata' + abc).style.display = 'none';
    document.getElementById('editpostbox' + abc).style.display = 'block';
    document.getElementById('editpostdetails' + abc).style.display = 'none';
    document.getElementById('editpostdetailbox' + abc).style.display = 'block';
    document.getElementById('editpostsubmit' + abc).style.display = 'block';
}


function edit_postinsert(abc)
{
    var editpostname = document.getElementById("editpostname" + abc);
    //var editpostdetails = document.getElementById("editpostdesc" + abc);
    // start khyati code
    var $field = $('#editpostdesc' + abc);
    //var data = $field.val();
    var editpostdetails = $('#editpostdesc' + abc).html(); // end khyati code


    // $('#editpostdesc' + abc).html("");
    if (editpostname.value == '' && editpostdetails == '') {
        $('.biderror .mes').html("<div class='pop_content'>You must either fill title or description.");
        $('#bidmodal').modal('show');
        document.getElementById('editpostdata' + abc).style.display = 'block';
        document.getElementById('editpostbox' + abc).style.display = 'none';
        document.getElementById('editpostdetails' + abc).style.display = 'block';
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
                document.getElementById('editpostdetails' + abc).style.display = 'block';
                document.getElementById('editpostdetailbox' + abc).style.display = 'none';
                document.getElementById('editpostsubmit' + abc).style.display = 'none';
                $('#' + 'editpostdata' + abc).html(data.title);
                $('#' + 'editpostdetails' + abc).html(data.description);
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
function remove_post(abc) {
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/business_profile_deletepost",
        data: 'business_profile_post_id=' + abc,
        //alert(data);
        success: function (data) {
            $('#' + 'removepost' + abc).html(data);
        }
    });
}

// remove save post end 
// remove particular user post start 

function del_particular_userpost(abc)
{
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/del_particular_userpost",
        data: 'business_profile_post_id=' + abc,
        //alert(data);
        success: function (data) {
            $('#' + 'removepost' + abc).html(data);
            $('#' + 'removepost' + abc).remove;
        }
    });
}

// remove particular user post end 
// follow user script start 

function followuser_two(clicked_id)
{

    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/follow_two",
        data: 'follow_to=' + clicked_id,
        success: function (data) {

            $('.' + 'fruser' + clicked_id).html(data);
        }
    });
}

//follow like script end 
// Unfollow user script start 

function unfollowuser_two(clicked_id)
{

    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/unfollow_two",
        data: 'follow_to=' + clicked_id,
        success: function (data) {

            $('.' + 'fruser' + clicked_id).html(data);
        }
    });
}


function followclose(clicked_id)
{
    $("#fad" + clicked_id).fadeOut(4000);
}

//follow like script end 
// insert post script zalak start 

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
    //allowedFileTypes: ['image','video', 'flash'],
    slugCallback: function (filename) {
        return filename.replace('(', '_').replace(']', '_');
    }
});
/*$(".file").on('fileselect', function(event, n, l) {
 alert('File Selected. Name: ' + l + ', Num: ' + n);
 });
 */
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
/*
 $('#file-4').on('fileselectnone', function() {
 alert('Huh! You selected no files.');
 });
 $('#file-4').on('filebrowse', function() {
 alert('File browse clicked for #file-4');
 });
 */
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
        initialPreview: ["http://lorempixel.com/1920/1080/nature/1",
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
    /*
     $("#test-upload").on('fileloaded', function(event, file, previewId, index) {
     alert('i = ' + index + ', id = ' + previewId + ', file = ' + file.name);
     });
     */
});
// insert post zalak script end 
// post insert developing script start 
function imgval(event) {

    var fileInput = document.getElementById("test-upload").files;
    var product_name = document.getElementById("test-upload-product").value;
    var product_description = document.getElementById("test-upload-des").value;
    var product_fileInput = document.getElementById("test-upload").value;
    if (product_fileInput == '' && product_name == '' && product_description == '')
    {

        $('.biderror .mes').html("<div class='pop_content'>This post appears to be blank. Please write or attach (photos, videos, audios, pdf) to post.");
        $('#bidmodal').modal('show');
        setInterval('window.location.reload()', 10000);
        // window.location='';
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
                    $('.biderror .mes').html("<div class='pop_content'>sorry this is not valid file for this post please try to uplode in new post.");
                    $('#bidmodal').modal('show');
                    setInterval('window.location.reload()', 10000);
                    // window.location='';
                    event.preventDefault();
                    return false;
                }
            } else if (foundPresentvideo == false) {

                $('.biderror .mes').html("<div class='pop_content'>This File Format is not supported Please Try to Upload MP4 or WebM files..");
                $('#bidmodal').modal('show');
                setInterval('window.location.reload()', 10000);
                event.preventDefault();
                return false;
            } else if (foundPresentvideo == true)
            {
                var foundPresent1 = $.inArray(ext1, allowesvideo) > -1;
                if (foundPresent1 == true && fileInput.length == 1) {
                } else {
                    $('.biderror .mes').html("<div class='pop_content'>sorry this is not valid file for this post please try to uplode in new post.");
                    $('#bidmodal').modal('show');
                    setInterval('window.location.reload()', 10000);
                    event.preventDefault();
                    return false;
                }
            } else if (foundPresentaudio == true)
            {
                var foundPresent1 = $.inArray(ext1, allowesaudio) > -1;
                if (foundPresent1 == true && fileInput.length == 1) {
                } else {
                    $('.biderror .mes').html("<div class='pop_content'>sorry this is not valid file for this post please try to uplode in new post.");
                    $('#bidmodal').modal('show');
                    setInterval('window.location.reload()', 10000);
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
                        event.preventDefault();
                        return false;
                    }
                } else {
                    $('.biderror .mes').html("<div class='pop_content'>sorry this is not valid file for this post please try to uplode in new post.");
                    $('#bidmodal').modal('show');
                    setInterval('window.location.reload()', 10000);
                    event.preventDefault();
                    return false;
                }
            }
        }
    }
}

$(document).ready(function () {
    $('.modal-close').on('click', function () {
        $('.modal-post').hide();
    });
});

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
            $('#post_comment' + clicked_id).html("");

            var x = document.getElementById('threecomment' + clicked_id);
            var y = document.getElementById('fourcomment' + clicked_id);
            if (x.style.display === 'block' && y.style.display === 'none') {
                $.ajax({
                    type: 'POST',
                    url: base_url + "business_profile/insert_commentthree",
                    data: 'post_id=' + clicked_id + '&comment=' + txt,
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
                    data: 'post_id=' + clicked_id + '&comment=' + txt,
                    // dataType: "json",
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
        type: 'POST', url: base_url + "business_profile/likeuserlist",
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

    $('.biderror .mes').html("<div class='pop_content'> Are You Sure want to delete this post?.<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='remove_post(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('#bidmodal').modal('show');
}

// post delete login user end 
// post delete particular login user script start 

function user_postdeleteparticular(clicked_id)
{

    $('.biderror .mes').html("<div class='pop_content'> Are You Sure want to delete this post from your profile?.<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='del_particular_userpost(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
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
$('body').on('touchstart', function(e) {
    var classNames = $(e.target).attr("class").toString().split(' ').pop();
    if (classNames != 'fa-ellipsis-v') {
        $('div[id^=myDropdown]').hide().removeClass('show');
    }
});


/* When the user clicks on the button, 
 toggle between hiding and showing the dropdown content */
function myFunction(clicked_id) {
    document.getElementById('myDropdown' + clicked_id).classList.toggle("show");
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

// This  script use for close dropdown in every post 
// all popup close close using esc start 

$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        $('#bidmodal').modal('hide');
    }
});


// all popup close close using esc end