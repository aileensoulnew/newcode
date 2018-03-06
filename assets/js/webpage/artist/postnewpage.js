$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {

        if (document.getElementById('myModal1').style.display = 'block') {
            document.getElementById('myModal1').style.display = 'none';
        }
        $("#myModal1").hide();
    }
});



$('.editpost').on('click', function () {
    var abc = $(this).attr('id');
    var editposttitle = $('#editpostval' + abc).html();
    var editpostdesc = $('#khyatii' + abc).html();

    //alert(editposttitle);
    // alert(editpostdesc);

    var n = editposttitle.length;
    //alert(id);
    document.getElementById('text_num').value = 50 - n;

    document.getElementById('editpostbox' + abc).style.display = 'block';
    document.getElementById('editpostdetailbox' + abc).style.display = 'block';
    document.getElementById('editpostsubmit' + abc).style.display = 'block';
    $('#editpostname' + abc).val(editposttitle);
    $('#editpostdesc' + abc).html(editpostdesc);
});

// for cursor pointer starts script
$(document).ready(function () {
    var input = $(".editable_text");
    var len = input.val().length;
    input[0].focus();
    input[0].setSelectionRange(len, len);
});

$('#postedit').on('click', function () {
    $(".my_text").prop("readonly", false);
    $('.editable_text').attr('contentEditable', true);
    $('.fr').attr('disabled', false);
});


$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        //$( "#bidmodal" ).hide();
        $('#postedit').modal('hide');
        $('.my_text').attr('readonly', false);
        $('.editable_text').attr('contentEditable', true);
        $('.fr').attr('disabled', false);
        // $('.my_text').attr('readonly', false);

        //$('.modal-post').show();

    }
});

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


//SCRIPT FOR AUTOFILL OF SEARCH KEYWORD START
$(function () {
    function split(val) {
        return val.split(/,\s*/);
    }
    function extractLast(term) {
        return split(term).pop();
    }
    $("#tags").bind("keydown", function (event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
                $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    })
            .autocomplete({

                minLength: 2,
                source: function (request, response) {
                    // delegate back to autocomplete, but extract the last term
                    $.getJSON(base_url + "artist/artistic_search_keyword", {term: extractLast(request.term)}, response);
                },
                focus: function () {
                    // prevent value inserted on focus
                    return false;
                },
                select: function (event, ui) {

                    var terms = split(this.value);
                    if (terms.length <= 1) {
                        // remove the current input
                        terms.pop();
                        // add the selected item
                        terms.push(ui.item.value);
                        // add placeholder to get the comma-and-space at the end
                        terms.push("");
                        this.value = terms.join("");
                        return false;
                    } else {

                        var last = terms.pop();
                        $(this).val(this.value.substr(0, this.value.length - last.length - 2)); // removes text from input
                        $(this).effect("highlight", {}, 1000);
                        $(this).attr("style", "border: solid 1px red;");
                        return false;
                    }
                }
            });
});

//SCRIPT FOR AUTOFILL OF SEARCH KEYWORD END


//SCRIPT FOR CITY AUTOFILL OF SEARCH START

$(function () {
    function split(val) {
        return val.split(/,\s*/);
    }
    function extractLast(term) {
        return split(term).pop();
    }
    $("#searchplace").bind("keydown", function (event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
                $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    })
            .autocomplete({
                minLength: 2,
                source: function (request, response) {
                    // delegate back to autocomplete, but extract the last term
                    $.getJSON(base_url + "artist/artistic_search_city", {term: extractLast(request.term)}, response);
                },
                focus: function () {
                    // prevent value inserted on focus
                    return false;
                },
                select: function (event, ui) {

                    var terms = split(this.value);
                    if (terms.length <= 1) {
                        // remove the current input
                        terms.pop();
                        // add the selected item
                        terms.push(ui.item.value);
                        // add placeholder to get the comma-and-space at the end
                        terms.push("");
                        this.value = terms.join("");
                        return false;
                    } else {
                        var last = terms.pop();
                        $(this).val(this.value.substr(0, this.value.length - last.length - 2)); // removes text from input
                        $(this).effect("highlight", {}, 1000);
                        $(this).attr("style", "border: solid 1px red;");
                        return false;
                    }
                }
            });
});

//SCRIPT FOR CITY AUTOFILL OF SEARCH END


//SCRIPT FOR AUTOFILL OF SEARCH KEYWORD START

$(function () {
    function split(val) {
        return val.split(/,\s*/);
    }
    function extractLast(term) {
        return split(term).pop();
    }
    $("#tags1").bind("keydown", function (event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
                $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    })
            .autocomplete({

                minLength: 2,
                source: function (request, response) {
                    // delegate back to autocomplete, but extract the last term
                    $.getJSON(base_url + "artist/artistic_search_keyword", {term: extractLast(request.term)}, response);
                },
                focus: function () {
                    // prevent value inserted on focus
                    return false;
                },
                select: function (event, ui) {

                    var terms = split(this.value);
                    if (terms.length <= 1) {
                        // remove the current input
                        terms.pop();
                        // add the selected item
                        terms.push(ui.item.value);
                        // add placeholder to get the comma-and-space at the end
                        terms.push("");
                        this.value = terms.join("");
                        return false;
                    } else {

                        var last = terms.pop();
                        $(this).val(this.value.substr(0, this.value.length - last.length - 2)); // removes text from input
                        $(this).effect("highlight", {}, 1000);
                        $(this).attr("style", "border: solid 1px red;");
                        return false;
                    }
                }
            });
});

//SCRIPT FOR AUTOFILL OF SEARCH KEYWORD END

//SCRIPT FOR CITY AUTOFILL OF SEARCH START

$(function () {
    function split(val) {
        return val.split(/,\s*/);
    }
    function extractLast(term) {
        return split(term).pop();
    }
    $("#searchplace1").bind("keydown", function (event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
                $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    })
            .autocomplete({
                minLength: 2,
                source: function (request, response) {
                    // delegate back to autocomplete, but extract the last term
                    $.getJSON(base_url + "artist/artistic_search_city", {term: extractLast(request.term)}, response);
                },
                focus: function () {
                    // prevent value inserted on focus
                    return false;
                },
                select: function (event, ui) {

                    var terms = split(this.value);
                    if (terms.length <= 1) {
                        // remove the current input
                        terms.pop();
                        // add the selected item
                        terms.push(ui.item.value);
                        // add placeholder to get the comma-and-space at the end
                        terms.push("");
                        this.value = terms.join("");
                        return false;
                    } else {
                        var last = terms.pop();
                        $(this).val(this.value.substr(0, this.value.length - last.length - 2)); // removes text from input
                        $(this).effect("highlight", {}, 1000);
                        $(this).attr("style", "border: solid 1px red;");
                        return false;
                    }
                }
            });
});

//SCRIPT FOR CITY AUTOFILL OF SEARCH END

$(document).ready(function ()
{
    /* Uploading Profile BackGround Image */
    $('body').on('change', '#bgphotoimg', function ()
    {
        $("#bgimageform").ajaxForm({target: '#timelineBackground',
            beforeSubmit: function () {},
            success: function () {
                $("#timelineShade").hide();
                $("#bgimageform").hide();
            },
            error: function () {
            }}).submit();
    });
    /* Banner position drag */
    $("body").on('mouseover', '.headerimage', function ()
    {
        var y1 = $('#timelineBackground').height();
        var y2 = $('.headerimage').height();
        $(this).draggable({
            scroll: false,
            axis: "y",
            drag: function (event, ui) {
                if (ui.position.top >= 0)
                {
                    ui.position.top = 0;
                } else if (ui.position.top <= y1 - y2)
                {
                    ui.position.top = y1 - y2;
                }
            },
            stop: function (event, ui)
            {
            }
        });
    });
    /* Bannert Position Save*/
    $("body").on('click', '.bgSave', function ()
    {
        var id = $(this).attr("id");
        var p = $("#timelineBGload").attr("style");
        var Y = p.split("top:");
        var Z = Y[1].split(";");
        var dataString = 'position=' + Z[0];
        $.ajax({
            type: "POST",
            url: base_url + "artist/image_saveBG_ajax",
            //url: "<?php echo base_url('artist/image_saveBG_ajax'); ?>",
            data: dataString,
            cache: false,
            beforeSend: function () { },
            success: function (html)
            {
                if (html)
                {
                    window.location.reload();
                    $(".bgImage").fadeOut('slow');
                    $(".bgSave").fadeOut('slow');
                    $("#timelineShade").fadeIn("slow");
                    $("#timelineBGload").removeClass("headerimage");
                    $("#timelineBGload").css({'margin-top': html});
                    return false;
                }
            }
        });
        return false;
    });
});

// three dot hide when click outside script
$('body').on("click", "*", function (e) {
    var classNames = $(e.target).prop("class").toString().split(' ').pop();
    if (classNames != 'fa-ellipsis-v') {
        $('div[id^=myDropdown]').hide().removeClass('show');
    }

});
// close esc using silder
$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        document.getElementById('myModal1').style.display = "none";
        $("body").removeClass("model-open");
    }
});

function openModal() {
    document.getElementById('myModal1').style.display = "block";

    $("body").addClass("model-open");
}
function closeModal() {
    document.getElementById('myModal1').style.display = "none";
    $("body").removeClass("model-open");
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

function check_perticular(input) {
    var testData = input.replace(/\s/g, '');
    var regex = /^(<br>)*$/;
    var isValid = regex.test(testData);
    return isValid;
}


$(document).ready(function () {
    $('.blocks').jMosaic({items_type: "li", margin: 0});
    $('.pictures').jMosaic({min_row_height: 150, margin: 3, is_first_big: true});
});
$(window).load(function () {
});
$(window).resize(function () {
});

var modal = document.getElementById('myModal');
var btn = document.getElementById("myBtn");
var span = document.getElementsByClassName("close")[0];
btn.onclick = function () {
    modal.style.display = "block";
}
span.onclick = function () {
    modal.style.display = "none";
}
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

$(document).ready(function () {
    $("#artpostform").validate({
        rules: {
            postname: {
                required: true,
            },
            description: {
                required: true,
            },
        },
        messages: {
            postname: {
                required: "Post name Is Required.",
            },
            description: {
                required: "Description is required",
            },
        },
    });
});

function comment_like(clicked_id)
{

    $.ajax({
        type: 'POST',
        url: base_url + "artist/like_comment",
        //url: '<?php echo base_url() . "artist/like_comment" ?>',
        data: 'post_id=' + clicked_id,
        success: function (data) {

            if (data == 'notavl') {
                $('.biderror .mes').html("<div class='pop_content'>The post that you were deleting on has been removed by its owner and this content is no longer available.</div>");
                $('#bidmodal').modal('show');
            } else {

                $('#' + 'likecomment' + clicked_id).html(data);
            }
        }
    });
}

function comment_like1(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "artist/like_comment1",
        //url: '<?php echo base_url() . "artist/like_comment1" ?>',
        data: 'post_id=' + clicked_id,
        success: function (data) {
            if (data == 'notavl') {
                $('.biderror .mes').html("<div class='pop_content'>The post that you were deleting on has been removed by its owner and this content is no longer available.</div>");
                $('#bidmodal').modal('show');
            } else {
                $('#' + 'likecomment1' + clicked_id).html(data);
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
        url: base_url + "artist/delete_comment_postnewpage",
        //url: '<?php echo base_url() . "artist/delete_comment_postnewpage" ?>',
        data: 'post_id=' + clicked_id + '&post_delete=' + post_delete.value,
        dataType: "json",
        success: function (data) {
            $('.' + 'insertcomment' + post_delete.value).html(data.comment);
            //     $('#' + 'insertcount' + post_delete.value).html(data.count);
            $('.like_count_ext' + post_delete.value).html(data.commentcount);
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
    var post_delete1 = document.getElementById("post_deletetwo");
    $.ajax({
        type: 'POST',
        url: base_url + "artist/delete_commenttwo_postnewpage",
        //url: '<?php echo base_url() . "artist/delete_commenttwo_postnewpage" ?>',
        data: 'post_id=' + clicked_id + '&post_delete=' + post_delete1.value,
        dataType: "json",
        success: function (data) {
            $('.' + 'insertcommenttwo' + post_delete1.value).html(data.comment);
            //     $('#' + 'insertcount' + post_delete.value).html(data.count);
            $('.like_count_ext' + post_delete1.value).html(data.commentcount);
            $('.post-design-commnet-box').show();
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
    txt = txt.replace(/div/gi, 'p');
    txt = txt.replace(/^(\s*<br( \/)?>)*|(<br( \/)?>\s*)*$/gm, '');



    if (txt == '' || txt == '<br>' || check_perticular(txt) == true) {
        return false;
    }
    if (/^\s+$/gi.test(txt))
    {
        return false;
    }

    $('#post_comment' + clicked_id).html("");

    var x = document.getElementById('threecomment' + clicked_id);
    var y = document.getElementById('fourcomment' + clicked_id);

    if (x.style.display === 'block' && y.style.display === 'none') {
        $.ajax({
            type: 'POST',
            url: base_url + "artist/insert_commentthree_postnewpage",
            //url: '<?php echo base_url() . "artist/insert_commentthree_postnewpage" ?>',
            data: 'post_id=' + clicked_id + '&comment=' + encodeURIComponent(txt),
            dataType: "json",
            success: function (data) {
                $('textarea').each(function () {
                    $(this).val('');
                });
                //     $('#' + 'insertcount' + clicked_id).html(data.count);
                $('.insertcomment' + clicked_id).html(data.comment);
                $('.like_count_ext' + clicked_id).html(data.commentcount);

                if (data.notification.notification_count != 0) {
                    var notification_count = data.notification.notification_count;
                    var to_id = data.notification.to_id;
                    show_header_notification(notification_count, to_id);
                }

            }
        });

    } else {

        $.ajax({
            type: 'POST',
            url: base_url + "artist/insert_comment_postnewpage",
            //url: '<?php echo base_url() . "artist/insert_comment_postnewpage" ?>',
            data: 'post_id=' + clicked_id + '&comment=' + encodeURIComponent(txt),
            dataType: "json",
            success: function (data) {
                $('textarea').each(function () {
                    $(this).val('');
                });
                //  $('#' + 'insertcount' + clicked_id).html(data.count);
                $('#' + 'fourcomment' + clicked_id).html(data.comment);
                $('.like_count_ext' + clicked_id).html(data.commentcount);

                if (data.notification.notification_count != 0) {
                    var notification_count = data.notification.notification_count;
                    var to_id = data.notification.to_id;
                    show_header_notification(notification_count, to_id);
                }
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

            txt = txt.replace(/&nbsp;/gi, " ");
            txt = txt.replace(/<br>$/, '');
            txt = txt.replace(/div/gi, 'p');
            txt = txt.replace(/^(\s*<br( \/)?>)*|(<br( \/)?>\s*)*$/gm, '');


            if (txt == '' || txt == '<br>' || check_perticular(txt) == true) {
                return false;
            }
            if (/^\s+$/gi.test(txt))
            {
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
                    url: base_url + "artist/insert_commentthree_postnewpage",
                    //url: '<?php echo base_url() . "artist/insert_commentthree_postnewpage" ?>',
                    data: 'post_id=' + clicked_id + '&comment=' + encodeURIComponent(txt),
                    dataType: "json",
                    success: function (data) {
                        $('textarea').each(function () {
                            $(this).val('');
                        });
                        //   $('#' + 'insertcount' + clicked_id).html(data.count);
                        $('.insertcomment' + clicked_id).html(data.comment);
                        $('.like_count_ext' + clicked_id).html(data.commentcount);
                        if (data.notification.notification_count != 0) {
                            var notification_count = data.notification.notification_count;
                            var to_id = data.notification.to_id;
                            show_header_notification(notification_count, to_id);
                        }
                    }
                });
            } else {
                $.ajax({
                    type: 'POST',
                    url: base_url + "artist/insert_comment_postnewpage",
                    // url: '<?php echo base_url() . "artist/insert_comment_postnewpage" ?>',
                    data: 'post_id=' + clicked_id + '&comment=' + encodeURIComponent(txt),
                    dataType: "json",
                    success: function (data) {
                        $('textarea').each(function () {
                            $(this).val('');
                        });
                        //     $('#' + 'insertcount' + clicked_id).html(data.count);
                        $('#' + 'fourcomment' + clicked_id).html(data.comment);
                        $('.like_count_ext' + clicked_id).html(data.commentcount);
                        if (data.notification.notification_count != 0) {
                            var notification_count = data.notification.notification_count;
                            var to_id = data.notification.to_id;
                            show_header_notification(notification_count, to_id);
                        }
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

function comment_editbox(clicked_id, abc) {
    document.getElementById('editcomment' + clicked_id).style.display = 'inline-block';
    document.getElementById('showcomment' + clicked_id).style.display = 'none';
    document.getElementById('editsubmit' + clicked_id).style.display = 'inline-block';
    //document.getElementById('editbox' + clicked_id).style.display = 'none';
    document.getElementById('editcommentbox' + clicked_id).style.display = 'none';
    document.getElementById('editcancle' + clicked_id).style.display = 'block';
    $($('#box_hide' + abc)).hide();
    $('.hidebottomborder').find('.all-comment-comment-box:last').css('border-bottom', '0px');

}


function comment_editcancle(clicked_id, abc) {
    document.getElementById('editcommentbox' + clicked_id).style.display = 'block';
    document.getElementById('editcancle' + clicked_id).style.display = 'none';
    document.getElementById('editcomment' + clicked_id).style.display = 'none';
    document.getElementById('showcomment' + clicked_id).style.display = 'block';
    document.getElementById('editsubmit' + clicked_id).style.display = 'none';
    $('.hidebottomborder').find('.all-comment-comment-box:last').css('border-bottom', '1px solid #d9d9d9');


    $($('#box_hide' + abc)).show();
}
function comment_editboxtwo(clicked_id, abc) {
//                            alert('editcommentboxtwo' + clicked_id);
//                            return false;
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
    $($('#box_hide' + abc)).hide();
    $('.hidebottombordertwo').find('.all-comment-comment-box:last').css('border-bottom', '0px');
    $('.hidebottomborder').find('.all-comment-comment-box:last').css('border-bottom', '0px');
}


function comment_editcancletwo(clicked_id, abc) {

    document.getElementById('editcommentboxtwo' + clicked_id).style.display = 'block';
    document.getElementById('editcancletwo' + clicked_id).style.display = 'none';

    document.getElementById('editcommenttwo' + clicked_id).style.display = 'none';
    document.getElementById('showcommenttwo' + clicked_id).style.display = 'block';
    document.getElementById('editsubmittwo' + clicked_id).style.display = 'none';
    $($('#box_hide' + abc)).show();
    $('.hidebottombordertwo').find('.all-comment-comment-box:last').css('border-bottom', '1px solid #d9d9d9');
    $('.hidebottomborder').find('.all-comment-comment-box:last').css('border-bottom', '1px solid #d9d9d9');
}

function edit_comment2(abc)
{
    var post_comment_edit = document.getElementById("editcomment2" + abc);
    $.ajax({
        type: 'POST',
        url: base_url + "artist/edit_comment_insert",
        // url: '<?php echo base_url() . "artist/edit_comment_insert" ?>',
        data: 'post_id=' + abc + '&comment=' + post_comment_edit.value,
        success: function (data) {

            document.getElementById('editcomment2' + abc).style.display = 'none';
            document.getElementById('showcomment2' + abc).style.display = 'block';
            document.getElementById('editsubmit2' + abc).style.display = 'none';
            document.getElementById('editbox2' + abc).style.display = 'block';
            document.getElementById('editcancle2' + abc).style.display = 'none';
            $('#' + 'showcomment2' + abc).html(data);
        }
    });
}

function commentedit2(abc)
{

    $(document).ready(function () {
        $('#editcomment2' + abc).keypress(function (e) {
            if (e.which == 13) {
                var val = $('#editcomment2' + abc).val();
                $.ajax({
                    type: 'POST',
                    url: base_url + "artist/edit_comment_insert",
                    //url: '<?php echo base_url() . "artist/edit_comment_insert" ?>',
                    data: 'post_id=' + abc + '&comment=' + val,
                    success: function (data) {

                        document.getElementById('editcomment2' + abc).style.display = 'none';
                        document.getElementById('showcomment2' + abc).style.display = 'block';
                        document.getElementById('editsubmit2' + abc).style.display = 'none';
                        document.getElementById('editbox2' + abc).style.display = 'block';
                        document.getElementById('editcancle2' + abc).style.display = 'none';
                        $('#' + 'showcomment2' + abc).html(data);
                    }
                });
                //alert(val);
            }
        });
    });
}

var modal = document.getElementById('myModal');
var btn = document.getElementById("myBtn");
var span = document.getElementsByClassName("close1")[0];
btn.onclick = function () {
    modal.style.display = "block";
}
span.onclick = function () {
    modal.style.display = "none";
}
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}


$(function () {
    var showTotalChar = 200, showChar = "more", hideChar = "less";
    $('.show').each(function () {
//                                var content = $(this).text();
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

var $fileUpload = $("#files"),
        $list = $('#list'),
        thumbsArray = [],
        maxUpload = 10;
function read(f) {//alert("aa");
    return function (e) {
        var base64 = e.target.result;
        var $img = $('<img/>', {
            src: base64,
            title: encodeURIComponent(f.name), //( escape() is deprecated! )
            "class": "thumb"
        });
        var $thumbParent = $("<span/>", {html: $img, "class": "thumbParent"}).append('<span class="remove_thumb"/>');
        thumbsArray.push(base64); // Push base64 image into array or whatever.
        $list.append($thumbParent);
    };
}
// HANDLE FILE/S UPLOAD
function handleFileSelect(e) {//alert("aaa");
    e.preventDefault(); // Needed?
    var files = e.target.files;
    var len = files.length;
    if (len > maxUpload || thumbsArray.length >= maxUpload) {
        return alert("Sorry you can upload only 5 images");
    }
    for (var i = 0; i < len; i++) {
        var f = files[i];
        if (!f.type.match('image.*'))
            continue; // Only images allowed    
        var reader = new FileReader();
        reader.onload = read(f); // Call read() function
        reader.readAsDataURL(f);
    }
}
$fileUpload.change(function (e) {//alert("aaaa");
    handleFileSelect(e);
});
$list.on('click', '.remove_thumb', function () {//alert("aaaaa");
    var $removeBtns = $('.remove_thumb'); // Get all of them in collection
    var idx = $removeBtns.index(this); // Exact Index-from-collection
    $(this).closest('span.thumbParent').remove(); // Remove tumbnail parent
    thumbsArray.splice(idx, 1); // Remove from array
});

$(document).ready(function () {
    $('.alert-danger').delay(3000).hide('700');
    $('.alert-success').delay(3000).hide('700');
});

function khdiv(abc) {

    $.ajax({
        type: 'POST',
        url: base_url + "artist/edit_more_insert",
        // url: '<?php echo base_url() . "artist/edit_more_insert" ?>',
        data: 'art_post_id=' + abc,
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

function cursorpointer(abc) {

    elem = document.getElementById('editpostdesc' + abc);
    elem.focus();
    setEndOfContenteditable(elem);
}

function setEndOfContenteditable(contentEditableElement)
{
    var range, selection;
    if (document.createRange)
    {
        range = document.createRange();//Create a range (a range is a like the selection but invisible)
        range.selectNodeContents(contentEditableElement);//Select the entire contents of the element with the range
        range.collapse(false);//collapse the range to the end point. false means collapse to end rather than the start
        selection = window.getSelection();//get the selection object (allows you to change selection)
        selection.removeAllRanges();//remove any selections already made
        selection.addRange(range);//make the range you have just created the visible selection
    } else if (document.selection)
    {
        range = document.body.createTextRange();//Create a range (a range is a like the selection but invisible)
        range.moveToElementText(contentEditableElement);//Select the entire contents of the element with the range
        range.collapse(false);//collapse the range to the end point. false means collapse to end rather than the start
        range.select();//Select the range (make it the visible selection
    }
}


function editpost(abc)
{

    var editposttitle = $('#editpostval' + abc).html();
    var editpostdesc = $('#khyatii' + abc).html();

    document.getElementById('editpostdata' + abc).style.display = 'none';
    document.getElementById('editpostbox' + abc).style.display = 'block';
    //document.getElementById('editpostdetails' + abc).style.display = 'none', 'display:inline !important';
    document.getElementById('editpostdetailbox' + abc).style.display = 'block';
    document.getElementById('editpostsubmit' + abc).style.display = 'block';
    document.getElementById('khyati' + abc).style.display = 'none';
    document.getElementById('khyatii' + abc).style.display = 'none';

    editposttitle = editposttitle.trim()
    editpostdesc = editpostdesc.trim()

    $('#editpostname' + abc).val(editposttitle);
    $('#editpostdesc' + abc).html(editpostdesc);

}

//alert("hii");

function edit_postinsert(abc)
{

    var editpostname = document.getElementById("editpostname" + abc);
    // var editpostdetails = document.getElementById("editpostdesc" + abc);
    // start khyati code
    var $field = $('#editpostdesc' + abc);
    //var data = $field.val();
    var editpostdetails = $('#editpostdesc' + abc).html();

    editpostdetails = editpostdetails.replace(/&nbsp;/gi, " ");
    editpostdetails = editpostdetails.replace(/<br>$/, '');
    editpostdetails = editpostdetails.replace(/div/gi, "p");
    editpostdetails = editpostdetails.replace(/^(\s*<br( \/)?>)*|(<br( \/)?>\s*)*$/gm, '');


    // end khyati code

    if ((editpostname.value.trim() == '') && (editpostdetails.trim() == '' || editpostdetails == '<br>' || check_perticular(editpostdetails) == true)) {
        $('.biderror .mes').html("<div class='pop_content'>You must either fill title or description.");
        $('button.editpost').attr('id', abc);

        $('#bidmodaleditpost').modal('show');

        // document.getElementById('editpostdata' + abc).style.display = 'block';
        // document.getElementById('editpostbox' + abc).style.display = 'none';
        // document.getElementById('khyati' + abc).style.display = 'block';
        // document.getElementById('editpostdetailbox' + abc).style.display = 'none';

        // document.getElementById('editpostsubmit' + abc).style.display = 'none';

        document.getElementById('editpostdata' + abc).style.display = 'none';
        document.getElementById('khyati' + abc).style.display = 'none';
        document.getElementById('khyatii' + abc).style.display = 'none';

    } else {
        $.ajax({
            type: 'POST',
            url: base_url + "artist/edit_post_insert",
            //url: '<?php echo base_url() . "artist/edit_post_insert" ?>',
            data: 'art_post_id=' + abc + '&art_post=' + editpostname.value + '&art_description=' + encodeURIComponent(editpostdetails),
            dataType: "json",
            success: function (data) {

                document.getElementById('editpostdata' + abc).style.display = 'block';
                document.getElementById('editpostbox' + abc).style.display = 'none';
                //  document.getElementById('editpostdetails' + abc).style.display = 'block';
                document.getElementById('editpostdetailbox' + abc).style.display = 'none';
                document.getElementById('editpostsubmit' + abc).style.display = 'none';
                //alert(data.description);
                document.getElementById('khyati' + abc).style.display = 'block';
                $('#' + 'editpostdata' + abc).html(data.title);
                // $('#' + 'editpostdetails' + abc).html(data.description);
                $('#' + 'khyati' + abc).html(data.description);

            }
        });
    }

}


function deleteownpostmodel(abc) {


    $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this post?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='remove_post(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('#bidmodal').modal('show');
}

function remove_post(abc)
{
    $.ajax({
        type: 'POST',
        url: base_url + "artist/art_deletepost",
        // url: '<?php echo base_url() . "artist/art_deletepost" ?>',
        data: 'art_post_id=' + abc,
        //alert(data);
        success: function (data) {

            $('#' + 'removepost' + abc).html(data);
            // window.location = "<?php echo base_url() ?>artist/art_post";
            window.location = base_url + "artist/home";
        }
    });
}

function deletepostmodel(abc) {


    $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this post from your profile?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='del_particular_userpost(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('#bidmodal').modal('show');
}


function del_particular_userpost(abc)
{
    $.ajax({
        type: 'POST',
        url: base_url + "artist/del_particular_userpost",
        //url: '<?php echo base_url() . "artist/del_particular_userpost" ?>',
        data: 'art_post_id=' + abc,
        //alert(data);
        success: function (data) {

            $('#' + 'removepost' + abc).html(data);
            window.location = base_url + "artist/home";

        }
    });
}


function post_like(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "artist/like_post",
        //url: '<?php echo base_url() . "artist/like_post" ?>',
        dataType: 'json',
        data: 'post_id=' + clicked_id,
        success: function (data) {
            $('.' + 'likepost' + clicked_id).html(data.like);
            $('.likeusername' + clicked_id).html(data.likeuser);

            $('.comnt_count_ext' + clicked_id).html(data.like_user_count);

            $('.likeduserlist' + clicked_id).hide();
            if (data.likecount == '0') {
                document.getElementById('likeusername' + clicked_id).style.display = "none";
            } else {
                document.getElementById('likeusername' + clicked_id).style.display = "block";
            }
            $('#likeusername' + clicked_id).addClass('likeduserlist1');
            if (data.notification.notification_count != 0) {
                var notification_count = data.notification.notification_count;
                var to_id = data.notification.to_id;
                show_header_notification(notification_count, to_id);
            }
        }
    });
}

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
            url: base_url + "artist/postnewpage_fourcomment",
            //url: '<?php echo base_url() . "artist/postnewpage_fourcomment" ?>',
            data: 'art_post_id=' + clicked_id,
            //alert(data);
            success: function (data) {
                $('#' + 'fourcomment' + clicked_id).html(data);
            }
        });
    }

}

function comment_like(clicked_id)
{
    //alert(clicked_id);
    $.ajax({
        type: 'POST',
        url: base_url + "artist/like_comment",
        // url: '<?php echo base_url() . "artist/like_comment" ?>',
        data: 'post_id=' + clicked_id,
        dataType: 'json',
        success: function (data) { //alert('.' + 'likepost' + clicked_id);
            $('#' + 'likecomment' + clicked_id).html(data.return_html);
            if (data.notification.notification_count != 0) {
                var notification_count = data.notification.notification_count;
                var to_id = data.notification.to_id;
                show_header_notification(notification_count, to_id);
                if (data.notification.notification_count != 0) {
                    var notification_count = data.notification.notification_count;
                    var to_id = data.notification.to_id;
                    show_header_notification(notification_count, to_id);
                }
            }
        }
    });
}

function comment_like1(clicked_id)
{
    //alert(clicked_id);
    $.ajax({
        type: 'POST',
        url: base_url + "artist/like_comment1",
        //url: '<?php echo base_url() . "artist/like_comment1" ?>',
        data: 'post_id=' + clicked_id,
        dataType: 'json',
        success: function (data) { //alert('.' + 'likepost' + clicked_id);
            $('#' + 'likecomment1' + clicked_id).html(data.return_html);
            if (data.notification.notification_count != 0) {
                    var notification_count = data.notification.notification_count;
                    var to_id = data.notification.to_id;
                    show_header_notification(notification_count, to_id);
                }
        }
    });
}

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

function edit_comment(abc, clicked_id)
{
    $("#editcomment" + abc).click(function () {
        $(this).prop("contentEditable", true);
    });

    var sel = $("#editcomment" + abc);
    var txt = sel.html();

    txt = txt.replace(/&nbsp;/gi, " ");
    txt = txt.replace(/<br>$/, '');
    txt = txt.replace(/^(\s*<br( \/)?>)*|(<br( \/)?>\s*)*$/gm, '');


    if (txt == '' || txt == '<br>' || check_perticular(txt) == true) {
        $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_delete(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
        $('#bidmodal').modal('show');
        return false;
    }
    if (/^\s+$/gi.test(txt)) {
        return false;
    }
    $.ajax({
        type: 'POST',
        url: base_url + "artist/edit_comment_insert",
        // url: '<?php echo base_url() . "artist/edit_comment_insert" ?>',
        data: 'post_id=' + abc + '&comment=' + encodeURIComponent(txt),
        success: function (data) {
            document.getElementById('editcomment' + abc).style.display = 'none';
            document.getElementById('showcomment' + abc).style.display = 'block';
            document.getElementById('editsubmit' + abc).style.display = 'none';
            document.getElementById('editcommentbox' + abc).style.display = 'block';
            document.getElementById('editcancle' + abc).style.display = 'none';
            $('#' + 'showcomment' + abc).html(data);
            $('#box_hide' + clicked_id).show();
            $('.hidebottomborder').find('.all-comment-comment-box:last').css('border-bottom', '1px solid #d9d9d9');

        }
    });
    $(".scroll").click(function (event) {
        event.preventDefault();
        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
    });
}

function commentedit(abc, clicked_id)
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
            txt = txt.replace(/^(\s*<br( \/)?>)*|(<br( \/)?>\s*)*$/gm, '');

            if (txt == '' || txt == '<br>' || check_perticular(txt) == true) {
                $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_delete(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                $('#bidmodal').modal('show');
                return false;
            }
            if (/^\s+$/gi.test(txt)) {
                return false;
            }

            if (window.preventDuplicateKeyPresses)
                return;
            window.preventDuplicateKeyPresses = true;
            window.setTimeout(function () {
                window.preventDuplicateKeyPresses = false;
            }, 500);
            $.ajax({
                type: 'POST',
                url: base_url + "artist/edit_comment_insert",
                //url: '<?php echo base_url() . "artist/edit_comment_insert" ?>',
                data: 'post_id=' + abc + '&comment=' + encodeURIComponent(txt),
                success: function (data) {
                    document.getElementById('editcomment' + abc).style.display = 'none';
                    document.getElementById('showcomment' + abc).style.display = 'block';
                    document.getElementById('editsubmit' + abc).style.display = 'none';
                    document.getElementById('editcommentbox' + abc).style.display = 'block';
                    document.getElementById('editcancle' + abc).style.display = 'none';
                    $('#' + 'showcomment' + abc).html(data);
                    $('#box_hide' + clicked_id).show();
                    $('.hidebottomborder').find('.all-comment-comment-box:last').css('border-bottom', '1px solid #d9d9d9');

                }
            });
        }
    });
    $(".scroll").click(function (event) {
        event.preventDefault();
        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
    });
}

function edit_commenttwo(abc, clicked_id)
{
    $("#editcommenttwo" + abc).click(function () {
        $(this).prop("contentEditable", true);
    });

    var sel = $("#editcommenttwo" + abc);
    var txt = sel.html();
    txt = txt.replace(/&nbsp;/gi, " ");
    txt = txt.replace(/<br>$/, '');
    txt = txt.replace(/^(\s*<br( \/)?>)*|(<br( \/)?>\s*)*$/gm, '');


    if (txt == '' || txt == '<br>' || check_perticular(txt) == true) {
        $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_deletetwo(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
        $('#bidmodal').modal('show');
        return false;
    }
    if (/^\s+$/gi.test(txt))
    {
        return false;
    }

    $.ajax({
        type: 'POST',
        url: base_url + "artist/edit_comment_insert",
        //url: '<?php echo base_url() . "artist/edit_comment_insert" ?>',
        data: 'post_id=' + abc + '&comment=' + encodeURIComponent(txt),
        success: function (data) {
            document.getElementById('editcommenttwo' + abc).style.display = 'none';
            document.getElementById('showcommenttwo' + abc).style.display = 'block';
            document.getElementById('editsubmittwo' + abc).style.display = 'none';
            document.getElementById('editcommentboxtwo' + abc).style.display = 'block';
            document.getElementById('editcancletwo' + abc).style.display = 'none';
            $('#' + 'showcommenttwo' + abc).html(data);
            $('#box_hide' + clicked_id).show();
            $('.hidebottomborder').find('.all-comment-comment-box:last').css('border-bottom', '1px solid #d9d9d9');
            $('.hidebottombordertwo').find('.all-comment-comment-box:last').css('border-bottom', '1px solid #d9d9d9');
        }
    });
    $(".scroll").click(function (event) {
        event.preventDefault();
        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
    });
}

function commentedittwo(abc, clicked_id)
{
    $("#editcommenttwo" + abc).click(function () {
        $(this).prop("contentEditable", true);
        //$(this).html("");
    });
    $('#editcommenttwo' + abc).keypress(function (event) {
        if (event.which == 13 && event.shiftKey != 1) {
            event.preventDefault();
            var sel = $("#editcommenttwo" + abc);
            var txt = sel.html();
            txt = txt.replace(/&nbsp;/gi, " ");
            txt = txt.replace(/<br>$/, '');
            txt = txt.replace(/^(\s*<br( \/)?>)*|(<br( \/)?>\s*)*$/gm, '');


            if (txt == '' || txt == '<br>' || check_perticular(txt) == true) {
                $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_deletetwo(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                $('#bidmodal').modal('show');
                return false;
            }

            if (/^\s+$/gi.test(txt))
            {
                return false;
            }

            if (window.preventDuplicateKeyPresses)
                return;

            window.preventDuplicateKeyPresses = true;
            window.setTimeout(function () {
                window.preventDuplicateKeyPresses = false;
            }, 500);

            $.ajax({
                type: 'POST',
                url: base_url + "artist/edit_comment_insert",
                //url: '<?php echo base_url() . "artist/edit_comment_insert" ?>',
                data: 'post_id=' + abc + '&comment=' + encodeURIComponent(txt),
                success: function (data) {
                    document.getElementById('editcommenttwo' + abc).style.display = 'none';
                    document.getElementById('showcommenttwo' + abc).style.display = 'block';
                    document.getElementById('editsubmittwo' + abc).style.display = 'none';

                    document.getElementById('editcommentboxtwo' + abc).style.display = 'block';
                    document.getElementById('editcancletwo' + abc).style.display = 'none';

                    $('#' + 'showcommenttwo' + abc).html(data);
                    $('#box_hide' + clicked_id).show();
                    $('.hidebottomborder').find('.all-comment-comment-box:last').css('border-bottom', '1px solid #d9d9d9');
                    $('.hidebottombordertwo').find('.all-comment-comment-box:last').css('border-bottom', '1px solid #d9d9d9');
                }
            });
        }
    });
    $(".scroll").click(function (event) {
        event.preventDefault();
        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
    });
}


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

function myFunction(clicked_id) {
    document.getElementById('myDropdown' + clicked_id).classList.toggle("show");
}
// // Close the dropdown if the user clicks outside of it
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
// READ FILE + CREATE IMAGE
function read(f) {//alert("aa");
    return function (e) {
        var base64 = e.target.result;
        var $img = $('<img/>', {
            src: base64,
            title: encodeURIComponent(f.name), //( escape() is deprecated! )
            "class": "thumb"
        });
        var $thumbParent = $("<span/>", {html: $img, "class": "thumbParent"}).append('<span class="remove_thumb"/>');
        thumbsArray.push(base64); // Push base64 image into array or whatever.
        $list.append($thumbParent);
    };
}
// HANDLE FILE/S UPLOAD
function handleFileSelect(e) {//alert("aaa");
    e.preventDefault(); // Needed?
    var files = e.target.files;
    var len = files.length;
    if (len > maxUpload || thumbsArray.length >= maxUpload) {
        return alert("Sorry you can upload only 5 images");
    }
    for (var i = 0; i < len; i++) {
        var f = files[i];
        if (!f.type.match('image.*'))
            continue; // Only images allowed    
        var reader = new FileReader();
        reader.onload = read(f); // Call read() function
        reader.readAsDataURL(f);
    }
}
$fileUpload.change(function (e) {
    alert("aaaa");
    handleFileSelect(e);
});
$list.on('click', '.remove_thumb', function () {//alert("aaaaa");
    var $removeBtns = $('.remove_thumb'); // Get all of them in collection
    var idx = $removeBtns.index(this); // Exact Index-from-collection
    $(this).closest('span.thumbParent').remove(); // Remove tumbnail parent
    thumbsArray.splice(idx, 1); // Remove from array
});

function mulimg_like(clicked_id)
{
    //alert(clicked_id);
    $.ajax({
        type: 'POST',
        url: base_url + "artist/mulimg_like",
        //url: '<?php echo base_url() . "artist/mulimg_like" ?>',
        data: 'post_image_id=' + clicked_id,
        success: function (data) {
            $('.' + 'likeimgpost' + clicked_id).html(data);
            if (data.notification.notification_count != 0) {
                var notification_count = data.notification.notification_count;
                var to_id = data.notification.to_id;
                show_header_notification(notification_count, to_id);
            }
        }});
}

function insert_commentimg(clicked_id)
{
    var post_comment = document.getElementById("post_imgcomment" + clicked_id);

    $.ajax({
        type: 'POST',
        url: base_url + "artist/mulimg_comment",
        //url: '<?php echo base_url() . "artist/mulimg_comment" ?>',
        data: 'post_image_id=' + clicked_id + '&comment=' + post_comment.value,
        dataType: "json",
        success: function (data) {
            $('input').each(function () {
                $(this).val('');
            });

            $('.' + 'insertimgcomment' + clicked_id).html(data.comment);
            if (data.notification.notification_count != 0) {
                var notification_count = data.notification.notification_count;
                var to_id = data.notification.to_id;
                show_header_notification(notification_count, to_id);
            }
        }
    });
}

function entercommentimg(clicked_id)
{
    $("#post_commentimg" + clicked_id).click(function () {
        $(this).prop("contentEditable", true);
    });

    $('#post_commentimg' + clicked_id).keypress(function (e) {

        if (e.keyCode == 13 && !e.shiftKey) {
            e.preventDefault();
            var sel = $("#post_commentimg" + clicked_id);
            var txt = sel.html();
            txt = txt.replace(/^(\s*<br( \/)?>)*|(<br( \/)?>\s*)*$/gm, '');

            if (txt == '' || check_perticular(txt) == true) {
                return false;
            }
            $('#post_commentimg' + clicked_id).html("");

            if (window.preventDuplicateKeyPresses)
                return;

            window.preventDuplicateKeyPresses = true;
            window.setTimeout(function () {
                window.preventDuplicateKeyPresses = false;
            }, 500);

            var x = document.getElementById('threecommentimg' + clicked_id);
            var y = document.getElementById('fourcommentimg' + clicked_id);



            if (x.style.display === 'block' && y.style.display === 'none') {
                $.ajax({
                    type: 'POST',
                    url: base_url + "artist/insert_commentthreeimg",
                    //url: '<?php echo base_url() . "artist/insert_commentthreeimg" ?>',
                    data: 'post_image_id=' + clicked_id + '&comment=' + encodeURIComponent(txt),
                    dataType: "json",
                    success: function (data) {
                        $('textarea').each(function () {
                            $(this).val('');
                        });
                        //   $('#' + 'insertcountimg' + clicked_id).html(data.count);
                        $('.insertcommentimg' + clicked_id).html(data.comment);
                        $('.like_count_ext_img' + clicked_id).html(data.commentcount);
                        if (data.notification.notification_count != 0) {
                            var notification_count = data.notification.notification_count;
                            var to_id = data.notification.to_id;
                            show_header_notification(notification_count, to_id);
                        }
                    }
                });

            } else {

                $.ajax({
                    type: 'POST',
                    url: base_url + "artist/insert_commentimg",
                    //url: '<?php echo base_url() . "artist/insert_commentimg" ?>',
                    data: 'post_image_id=' + clicked_id + '&comment=' + encodeURIComponent(txt),
                    dataType: "json",
                    success: function (data) {
                        $('textarea').each(function () {
                            $(this).val('');
                        });

                        // alert(clicked_id);
                        //   $('#' + 'insertcountimg' + clicked_id).html(data.count);
                        $('#' + 'fourcommentimg' + clicked_id).html(data.comment);
                        $('.like_count_ext_img' + clicked_id).html(data.commentcount);
                        if (data.notification.notification_count != 0) {
                            var notification_count = data.notification.notification_count;
                            var to_id = data.notification.to_id;
                            show_header_notification(notification_count, to_id);
                        }
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

function imgcommentall(clicked_id) { //alert("xyz")                                                ;

//alert('threeimgcomment' + clicked_id);
//alert('fourimgcomment' + clicked_id);
    var x = document.getElementById('threeimgcomment' + clicked_id);
    var y = document.getElementById('fourimgcomment' + clicked_id);
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
    //alert(clicked_id);
    $.ajax({
        type: 'POST',
        url: base_url + "artist/mulimg_comment_like",
        //url: '<?php echo base_url() . "artist/mulimg_comment_like" ?>',
        data: 'post_image_comment_id=' + clicked_id,
        success: function (data) { //alert(data);
            $('#' + 'imglikecomment' + clicked_id).html(data);
            if (data.notification.notification_count != 0) {
                var notification_count = data.notification.notification_count;
                var to_id = data.notification.to_id;
                show_header_notification(notification_count, to_id);
            }
        }
    });
}
function imgcomment_like1(clicked_id)
{
    //alert(clicked_id);
    $.ajax({
        type: 'POST',
        url: base_url + "artist/mulimg_comment_like1",
        // url: '<?php echo base_url() . "artist/mulimg_comment_like1" ?>',
        data: 'post_image_comment_id=' + clicked_id,
        success: function (data) { //alert(data);
            $('#' + 'imglikecomment1' + clicked_id).html(data);
            if (data.notification.notification_count != 0) {
                var notification_count = data.notification.notification_count;
                var to_id = data.notification.to_id;
                show_header_notification(notification_count, to_id);
            }
        }
    });
}

function imgcomment_editbox(clicked_id) {
    document.getElementById('imgeditcomment' + clicked_id).style.display = 'block';
    document.getElementById('imgshowcomment' + clicked_id).style.display = 'none';
    document.getElementById('imgeditsubmit' + clicked_id).style.display = 'block';
    document.getElementById('imgeditcommentbox' + clicked_id).style.display = 'none';
    document.getElementById('imgeditcancle' + clicked_id).style.display = 'block';


}
function imgcomment_editcancle(clicked_id) {
    document.getElementById('imgeditcommentbox' + clicked_id).style.display = 'block';
    document.getElementById('imgeditcancle' + clicked_id).style.display = 'none';
    document.getElementById('imgeditcomment' + clicked_id).style.display = 'none';
    document.getElementById('imgshowcomment' + clicked_id).style.display = 'block';
    document.getElementById('imgeditsubmit' + clicked_id).style.display = 'none';
}
function imgcomment_editboxtwo(clicked_id) {  //alert('editsubmit2' + clicked_id);
    document.getElementById('imgeditcommenttwo' + clicked_id).style.display = 'block';
    document.getElementById('imgshowcommenttwo' + clicked_id).style.display = 'none';
    document.getElementById('imgeditsubmittwo' + clicked_id).style.display = 'block';
    document.getElementById('imgeditcommentboxtwo' + clicked_id).style.display = 'none';
    document.getElementById('imgeditcancletwo' + clicked_id).style.display = 'block';

}
function imgcomment_editcancletwo(clicked_id) {
    document.getElementById('imgeditcommentboxtwo' + clicked_id).style.display = 'block';
    document.getElementById('imgeditcancletwo' + clicked_id).style.display = 'none';
    document.getElementById('imgeditcommenttwo' + clicked_id).style.display = 'none';
    document.getElementById('imgshowcommenttwo' + clicked_id).style.display = 'block';
    document.getElementById('imgeditsubmittwo' + clicked_id).style.display = 'none';

}

function imgedit_comment(abc)
{ //alert('editsubmit' + abc);
    var post_comment_edit = document.getElementById("imgeditcomment" + abc);
    //alert(post_comment.value);
    //alert(post_comment.value);
    $.ajax({
        type: 'POST',
        url: base_url + "artist/mul_edit_com_insert",
        //url: '<?php echo base_url() . "artist/mul_edit_com_insert" ?>',
        data: 'post_image_comment_id=' + abc + '&comment=' + post_comment_edit.value,
        success: function (data) { //alert('falguni');
            //  $('input').each(function(){
            //     $(this).val('');
            // }); 
            document.getElementById('imgeditcomment' + abc).style.display = 'none';
            document.getElementById('imgshowcomment' + abc).style.display = 'block';
            document.getElementById('imgeditsubmit' + abc).style.display = 'none';
            document.getElementById('imgeditcommentbox' + abc).style.display = 'block';
            document.getElementById('imgeditcancle' + abc).style.display = 'none';
            //alert('.' + 'showcomment' + abc);
            $('#' + 'imgshowcomment' + abc).html(data);
        }
    });
    //window.location.reload();
}

function imgcommentedit(abc)
{
    $(document).ready(function () {
        $('#imgeditcomment' + abc).keypress(function (e) {

            if (e.keyCode == 13 && !e.shiftKey) {
                var val = $('#imgeditcomment' + abc).val();
                e.preventDefault();
                if (window.preventDuplicateKeyPresses)
                    return;
                window.preventDuplicateKeyPresses = true;
                window.setTimeout(function () {
                    window.preventDuplicateKeyPresses = false;
                }, 500);

                $.ajax({
                    type: 'POST',
                    url: base_url + "artist/mul_edit_com_insert",
                    //url: '<?php echo base_url() . "artist/mul_edit_com_insert" ?>',
                    data: 'post_image_comment_id=' + abc + '&comment=' + val,
                    success: function (data) { //alert('falguni');

                        document.getElementById('imgeditcomment' + abc).style.display = 'none';
                        document.getElementById('imgshowcomment' + abc).style.display = 'block';
                        document.getElementById('imgeditsubmit' + abc).style.display = 'none';
                        document.getElementById('imgeditcommentbox' + abc).style.display = 'block';
                        document.getElementById('imgeditcancle' + abc).style.display = 'none';
                        //alert('.' + 'showcomment' + abc);
                        $('#' + 'imgshowcomment' + abc).html(data);
                    }
                });
                //alert(val);
            }
        });
    });
}

function imgedit_commenttwo(abc)
{ //alert('editsubmit' + abc);
    var post_comment_edit = document.getElementById("imgeditcommenttwo" + abc);
    //alert(post_comment.value);
    //alert(post_comment.value);
    $.ajax({
        type: 'POST',
        url: base_url + "artist/mul_edit_com_insert",
        // url: '<?php echo base_url() . "artist/mul_edit_com_insert" ?>',
        data: 'post_image_comment_id=' + abc + '&comment=' + post_comment_edit.value,
        success: function (data) { //alert('falguni');
            //  $('input').each(function(){
            //     $(this).val('');
            // }); 
            document.getElementById('imgeditcommenttwo' + abc).style.display = 'none';
            document.getElementById('imgshowcommenttwo' + abc).style.display = 'block';
            document.getElementById('imgeditsubmittwo' + abc).style.display = 'none';
            document.getElementById('imgeditcommentboxtwo' + abc).style.display = 'block';
            document.getElementById('imgeditcancletwo' + abc).style.display = 'none';
            //alert('.' + 'showcomment' + abc);
            $('#' + 'imgshowcommenttwo' + abc).html(data);
        }
    });

}

function imgcommentedittwo(abc)
{
    $(document).ready(function () {
        $('#imgeditcommenttwo' + abc).keypress(function (e) {
            if (e.keyCode == 13 && !e.shiftKey) {
                var val = $('#imgeditcommenttwo' + abc).val();
                e.preventDefault();
                if (window.preventDuplicateKeyPresses)
                    return;
                window.preventDuplicateKeyPresses = true;
                window.setTimeout(function () {
                    window.preventDuplicateKeyPresses = false;
                }, 500);
                $.ajax({
                    type: 'POST',
                    url: base_url + "artist/mul_edit_com_insert",
                    //url: '<?php echo base_url() . "artist/mul_edit_com_insert" ?>',
                    data: 'post_image_comment_id=' + abc + '&comment=' + val,
                    success: function (data) { //alert('falguni');
//  $('input').each(function(){
//     $(this).val('');
// }); 
                        document.getElementById('imgeditcommenttwo' + abc).style.display = 'none';
                        document.getElementById('imgshowcommenttwo' + abc).style.display = 'block';
                        document.getElementById('imgeditsubmittwo' + abc).style.display = 'none';
                        document.getElementById('imgeditcommentboxtwo' + abc).style.display = 'block';
                        document.getElementById('imgeditcancletwo' + abc).style.display = 'none';
//alert('.' + 'showcomment' + abc);
                        $('#' + 'imgshowcommenttwo' + abc).html(data);
                    }});

            }
        });
    });
}

function imgcomment_delete(clicked_id)
{

    var post_delete = document.getElementById("imgpost_delete");
    //alert(post_delete.value);
    $.ajax({
        type: 'POST',
        url: base_url + "artist/mul_delete_comment",
        // url: '<?php echo base_url() . "artist/mul_delete_comment" ?>',
        data: 'post_image_comment_id=' + clicked_id + '&post_delete=' + post_delete.value,
        success: function (data) { //alert('.' + 'insertcomment' + clicked_id);
            $('.' + 'insertimgcomment' + post_delete.value).html(data);
        }
    });
}
function imgcomment_delete1(clicked_id)
{

    var post_delete1 = document.getElementById("imgpost_delete1");
    //alert(post_delete.value);
    $.ajax({
        type: 'POST',
        url: base_url + "artist/mul_delete_comment1",
        //url: '<?php echo base_url() . "artist/mul_delete_comment1" ?>',
        data: 'post_image_comment_id=' + clicked_id + '&post_delete=' + post_delete1.value,
        success: function (data) { //alert('.' + 'insertcomment' + clicked_id);
            $('.' + 'insertimgcomment' + post_delete1.value).html(data);
        }
    });
}

function post_likeimg(clicked_id)
{
    $.ajax({
        type: 'POST',
        url: base_url + "artist/like_postimg",
        //url: '<?php echo base_url() . "artist/like_postimg" ?>',
        dataType: 'json',
        data: 'post_image_id=' + clicked_id,
        success: function (data) {

            $('.' + 'likepostimg' + clicked_id).html(data.like);
            $('.likeusernameimg' + clicked_id).html(data.likeuser);
            $('.comnt_count_ext_img' + clicked_id).html(data.like_user_count);

            $('.likeduserlistimg' + clicked_id).hide();
            if (data.like_user_count == '0') {
                document.getElementById('likeusernameimg' + clicked_id).style.display = "none";
            } else {
                document.getElementById('likeusernameimg' + clicked_id).style.display = "block";
            }
            if (data.notification.notification_count != 0) {
                var notification_count = data.notification.notification_count;
                var to_id = data.notification.to_id;
                show_header_notification(notification_count, to_id);
            }
            //$('#likeusernameimg' + clicked_id).addClass('likeduserlistimg1');
        }
    });
}


function comment_likeimg(clicked_id)
{
    // alert(clicked_id);
    $.ajax({
        type: 'POST',
        url: base_url + "artist/like_commentimg1",
        //url: '<?php echo base_url() . "artist/like_commentimg1" ?>',
        data: 'post_image_comment_id=' + clicked_id,
        dataType: 'json',
        success: function (data) {
            $('#' + 'likecommentimg' + clicked_id).html(data.return_html);
            if (data.notification.notification_count != 0) {
                var notification_count = data.notification.notification_count;
                var to_id = data.notification.to_id;
                show_header_notification(notification_count, to_id);
            }
        }
    });
}

function comment_likeimgtwo(clicked_id)
{// alert("hi");
    // alert(clicked_id);
    $.ajax({
        type: 'POST',
        url: base_url + "artist/like_commentimg1",
        // url: '<?php echo base_url() . "artist/like_commentimg1" ?>',
        data: 'post_image_comment_id=' + clicked_id,
        dataType: 'json',
        success: function (data) {
            $('#' + 'likecommentimg' + clicked_id).html(data.return_html);
            if (data.notification.notification_count != 0) {
                var notification_count = data.notification.notification_count;
                var to_id = data.notification.to_id;
                show_header_notification(notification_count, to_id);
            }
        }
    });
}


function comment_editboximg(clicked_id, abc) { //alert('#box_comment' + clicked_id);
    document.getElementById('editcommentimg' + clicked_id).style.display = 'inline-block';
    document.getElementById('showcommentimg' + clicked_id).style.display = 'none';
    document.getElementById('editsubmitimg' + clicked_id).style.display = 'inline-block';
    //document.getElementById('editbox' + clicked_id).style.display = 'none';
    document.getElementById('editcommentboximg' + clicked_id).style.display = 'none';
    document.getElementById('editcancleimg' + clicked_id).style.display = 'block';
    $('#box_comment' + abc).hide();
}


function comment_editcancleimg(clicked_id, abc) {
    document.getElementById('editcommentboximg' + clicked_id).style.display = 'block';
    document.getElementById('editcancleimg' + clicked_id).style.display = 'none';
    document.getElementById('editcommentimg' + clicked_id).style.display = 'none';
    document.getElementById('showcommentimg' + clicked_id).style.display = 'block';
    document.getElementById('editsubmitimg' + clicked_id).style.display = 'none';

    $('#box_comment' + abc).show();
}

function comment_editboximgtwo(clicked_id, abc) {
    //                            alert('editcommentboxtwo' + clicked_id);
    //                            return false;
    $('div[id^=editcommentimgtwo' + clicked_id + ']').css('display', 'none');
    $('div[id^=showcommentimgtwo' + clicked_id + ']').css('display', 'block');
    $('button[id^=editsubmitimgtwo' + clicked_id + ']').css('display', 'none');
    $('div[id^=editcommentboximgtwo' + clicked_id + ']').css('display', 'block');
    $('div[id^=editcancleimgtwo' + clicked_id + ']').css('display', 'none');

    document.getElementById('editcommentimgtwo' + clicked_id).style.display = 'inline-block';
    document.getElementById('showcommentimgtwo' + clicked_id).style.display = 'none';
    document.getElementById('editsubmitimgtwo' + clicked_id).style.display = 'inline-block';
    document.getElementById('editcommentboximgtwo' + clicked_id).style.display = 'none';
    document.getElementById('editcancleimgtwo' + clicked_id).style.display = 'block';
    $('#box_comment' + abc).hide();
}


function comment_editcancleimgtwo(clicked_id, abc) {

    document.getElementById('editcommentboximgtwo' + clicked_id).style.display = 'block';
    document.getElementById('editcancleimgtwo' + clicked_id).style.display = 'none';

    document.getElementById('editcommentimgtwo' + clicked_id).style.display = 'none';
    document.getElementById('showcommentimgtwo' + clicked_id).style.display = 'block';
    document.getElementById('editsubmitimgtwo' + clicked_id).style.display = 'none';
    $('#box_comment' + abc).show();
}

function comment_deleteimg(clicked_id) {
    $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='comment_deletedimg(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('#bidmodal').modal('show');
}

function comment_deletedimg(clicked_id)
{ //alert(clicked_id);
    var post_delete = document.getElementById("post_deleteimg" + clicked_id);
    //  alert(post_delete.value);
    $.ajax({
        type: 'POST',
        url: base_url + "artist/delete_commentimg",
        // url: '<?php echo base_url() . "artist/delete_commentimg" ?>',
        data: 'post_image_comment_id=' + clicked_id + '&post_delete=' + post_delete.value,
        dataType: "json",
        success: function (data) {
            //alert('.' + 'insertcomment' + clicked_id);
            $('.' + 'insertcommentimg' + post_delete.value).html(data.comment);
            //  $('#' + 'insertcountimg' + post_delete.value).html(data.count);
            $('.like_count_ext_img' + post_delete.value).html(data.commentcount);
            $('.post-design-commnet-box').show();
        }
    });
}

function insert_commentimg(clicked_id)
{
    $("#post_commentimg" + clicked_id).click(function () {
        $(this).prop("contentEditable", true);
        $(this).html("");
    });

    var sel = $("#post_commentimg" + clicked_id);
    var txt = sel.html();

    txt = txt.replace(/&nbsp;/gi, " ");
    txt = txt.replace(/<br>$/, '');
    txt = txt.replace(/div/gi, "p");
    txt = txt.replace(/^(\s*<br( \/)?>)*|(<br( \/)?>\s*)*$/gm, '');


    if (txt == '' || check_perticular(txt) == true) {
        return false;
    }

    $('#post_commentimg' + clicked_id).html("");

    var x = document.getElementById('threecommentimg' + clicked_id);
    var y = document.getElementById('fourcommentimg' + clicked_id);

    if (x.style.display === 'block' && y.style.display === 'none') {
        $.ajax({
            type: 'POST',
            url: base_url + "artist/insert_commentthreeimg",
            // url: '<?php echo base_url() . "artist/insert_commentthreeimg" ?>',
            data: 'post_image_id=' + clicked_id + '&comment=' + encodeURIComponent(txt),
            dataType: "json",
            success: function (data) {
                $('textarea').each(function () {
                    $(this).val('');
                });
                //  $('#' + 'insertcountimg' + clicked_id).html(data.count);
                $('.insertcommentimg' + clicked_id).html(data.comment);
                $('.like_count_ext_img' + clicked_id).html(data.commentcount);
                if (data.notification.notification_count != 0) {
                    var notification_count = data.notification.notification_count;
                    var to_id = data.notification.to_id;
                    show_header_notification(notification_count, to_id);
                }

            }
        });

    } else {

        $.ajax({
            type: 'POST',
            url: base_url + "artist/insert_commentimg",
            //url: '<?php echo base_url() . "artist/insert_commentimg" ?>',
            data: 'post_image_id=' + clicked_id + '&comment=' + encodeURIComponent(txt),
            dataType: "json",
            success: function (data) {
                $('textarea').each(function () {
                    $(this).val('');
                });
//                                        $('#' + 'insertcountimg' + clicked_id).html(data.count);
                $('#' + 'fourcommentimg' + clicked_id).html(data.comment);
                $('.like_count_ext_img' + clicked_id).html(data.commentcount);
                if (data.notification.notification_count != 0) {
                    var notification_count = data.notification.notification_count;
                    var to_id = data.notification.to_id;
                    show_header_notification(notification_count, to_id);
                }
            }
        });
    }
}

function edit_commentimg(abc, clicked_id)
{
    $("#editcommentimg" + abc).click(function () {
        $(this).prop("contentEditable", true);
    });

    var sel = $("#editcommentimg" + abc);
    var txt = sel.html();

    txt = txt.replace(/&nbsp;/gi, " ");
    txt = txt.replace(/<br>$/, '');
    txt = txt.replace(/div/gi, "p");
    txt = txt.replace(/^(\s*<br( \/)?>)*|(<br( \/)?>\s*)*$/gm, '');


    if (txt == '' || txt == '<br>' || check_perticular(txt) == true) {
        $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_delete(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
        $('#bidmodal').modal('show');
        return false;
    }
    if (/^\s+$/gi.test(txt)) {
        return false;
    }
    $.ajax({
        type: 'POST',
        url: base_url + "artist/edit_comment_insertimg",
        //url: '<?php echo base_url() . "artist/edit_comment_insertimg" ?>',
        data: 'post_image_comment_id=' + abc + '&comment=' + encodeURIComponent(txt),
        success: function (data) {
            document.getElementById('editcommentimg' + abc).style.display = 'none';
            document.getElementById('showcommentimg' + abc).style.display = 'block';
            document.getElementById('editsubmitimg' + abc).style.display = 'none';
            document.getElementById('editcommentboximg' + abc).style.display = 'block';
            document.getElementById('editcancleimg' + abc).style.display = 'none';
            $('#' + 'showcommentimg' + abc).html(data);
            $('#box_comment' + clicked_id).show();
        }
    });
    $(".scroll").click(function (event) {
        event.preventDefault();
        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
    });
}

function commentallimg(clicked_id) {
    var x = document.getElementById('threecommentimg' + clicked_id);
    var y = document.getElementById('fourcommentimg' + clicked_id);
    var z = document.getElementById('insertcountimg' + clicked_id);

    if (x.style.display === 'block' && y.style.display === 'none') {
        x.style.display = 'none';
        y.style.display = 'block';
        z.style.visibility = 'show';
        $.ajax({
            type: 'POST',
            url: base_url + "artist/fourcommentimg",
            //url: '<?php echo base_url() . "artist/fourcommentimg" ?>',
            data: 'art_post_id=' + clicked_id,
            //alert(data);
            success: function (data) {
                $('#' + 'fourcommentimg' + clicked_id).html(data);
            }
        });
    }
}



function likeuserlist(post_id) {

    $.ajax({
        type: 'POST',
        url: base_url + "artist/likeuserlist",
        //url: '<?php echo base_url() . "artist/likeuserlist" ?>',
        data: 'post_id=' + post_id,
        dataType: "html",
        success: function (data) {
            var html_data = data;
            $('#likeusermodal .mes').html(html_data);
            $('#likeusermodal').modal('show');
        }
    });
}


function comment_deleteimgtwo(clicked_id)
{
    $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='comment_deletedimgtwo(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('#bidmodal').modal('show');
}


function comment_deletedimgtwo(clicked_id)
{
    var post_delete1 = document.getElementById("post_deleteimgtwo");
    //  alert(post_delete1.value);
    $.ajax({
        type: 'POST',
        url: base_url + "artist/delete_commenttwoimg",
        //url: '<?php echo base_url() . "artist/delete_commenttwoimg" ?>',
        data: 'post_image_comment_id=' + clicked_id + '&post_delete=' + post_delete1.value,
        dataType: "json",
        success: function (data) {// alert(data);

            $('.' + 'insertcommentimgtwo' + post_delete1.value).html(data.comment);
            //  $('#' + 'insertcountimg' + post_delete1.value).html(data.count);
            $('.like_count_ext_img' + post_delete1.value).html(data.commentcount);

            $('.post-design-commnet-box').show();

        }
    });
}

function edit_commentimgtwo(abc, clicked_id)
{
    $("#editcommentimgtwo" + abc).click(function () {
        $(this).prop("contentEditable", true);
    });

    var sel = $("#editcommentimgtwo" + abc);
    var txt = sel.html();

    txt = txt.replace(/&nbsp;/gi, " ");
    txt = txt.replace(/<br>$/, '');
    txt = txt.replace(/div/gi, "p");
    txt = txt.replace(/^(\s*<br( \/)?>)*|(<br( \/)?>\s*)*$/gm, '');


    if (txt == '' || txt == '<br>' || check_perticular(txt) == true) {
        $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_deletetwo(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
        $('#bidmodal').modal('show');
        return false;
    }
    if (/^\s+$/gi.test(txt))
    {
        return false;
    }
    $.ajax({
        type: 'POST',
        url: base_url + "artist/edit_comment_insertimg",
        //url: '<?php echo base_url() . "artist/edit_comment_insertimg" ?>',
        data: 'post_image_comment_id=' + abc + '&comment=' + encodeURIComponent(txt),
        success: function (data) {
            document.getElementById('editcommentimgtwo' + abc).style.display = 'none';
            document.getElementById('showcommentimgtwo' + abc).style.display = 'block';
            document.getElementById('editsubmitimgtwo' + abc).style.display = 'none';
            document.getElementById('editcommentboximgtwo' + abc).style.display = 'block';
            document.getElementById('editcancleimgtwo' + abc).style.display = 'none';
            $('#' + 'showcommentimgtwo' + abc).html(data);
            $('#box_comment' + clicked_id).show();
        }
    });
    $(".scroll").click(function (event) {
        event.preventDefault();
        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
    });
}


function likeuserlistimg(post_id) {

    $.ajax({
        type: 'POST',
        url: base_url + "artist/likeuserlistimg",
        //url: '<?php echo base_url() . "artist/likeuserlistimg" ?>',
        data: 'post_id=' + post_id,
        dataType: "html",
        success: function (data) {
            var html_data = data;
            $('#likeusermodal .mes').html(html_data);
            $('#likeusermodal').modal('show');
        }
    });


}

function commenteditimg(abc, clicked_id)
{
    $("#editcommentimg" + abc).click(function () {
        $(this).prop("contentEditable", true);
    });
    $('#editcommentimg' + abc).keypress(function (event) {
        if (event.which == 13 && event.shiftKey != 1) {
            event.preventDefault();
            var sel = $("#editcommentimg" + abc);
            var txt = sel.html();

            txt = txt.replace(/&nbsp;/gi, " ");
            txt = txt.replace(/<br>$/, '');
            txt = txt.replace(/div/gi, "p");
            txt = txt.replace(/^(\s*<br( \/)?>)*|(<br( \/)?>\s*)*$/gm, '');



            if (txt == '' || txt == '<br>' || check_perticular(txt) == true) {
                $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_deleteimg(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                $('#bidmodal').modal('show');
                return false;
            }
            if (/^\s+$/gi.test(txt))
            {
                return false;
            }

            if (window.preventDuplicateKeyPresses)
                return;
            window.preventDuplicateKeyPresses = true;
            window.setTimeout(function () {
                window.preventDuplicateKeyPresses = false;
            }, 500);
            $.ajax({
                type: 'POST',
                url: base_url + "artist/edit_comment_insertimg",
                //url: '<?php echo base_url() . "artist/edit_comment_insertimg" ?>',
                data: 'post_image_comment_id=' + abc + '&comment=' + encodeURIComponent(txt),
                success: function (data) {
                    document.getElementById('editcommentimg' + abc).style.display = 'none';
                    document.getElementById('showcommentimg' + abc).style.display = 'block';
                    document.getElementById('editsubmitimg' + abc).style.display = 'none';
                    document.getElementById('editcommentboximg' + abc).style.display = 'block';
                    document.getElementById('editcancleimg' + abc).style.display = 'none';
                    $('#' + 'showcommentimg' + abc).html(data);
                    $('#box_comment' + clicked_id).show();
                }
            });
        }
    });
    $(".scroll").click(function (event) {
        event.preventDefault();
        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
    });
}

function commenteditimgtwo(abc, clicked_id)
{
    $("#editcommentimgtwo" + abc).click(function () {
        $(this).prop("contentEditable", true);
        //$(this).html("");
    });
    $('#editcommentimgtwo' + abc).keypress(function (event) {
        if (event.which == 13 && event.shiftKey != 1) {
            event.preventDefault();
            var sel = $("#editcommentimgtwo" + abc);
            var txt = sel.html();

            txt = txt.replace(/&nbsp;/gi, " ");
            txt = txt.replace(/<br>$/, '');
            txt = txt.replace(/div/gi, "p");
            txt = txt.replace(/^(\s*<br( \/)?>)*|(<br( \/)?>\s*)*$/gm, '');


            if (txt == '' || txt == '<br>' || check_perticular(txt) == true) {
                $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_deleteimgtwo(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                $('#bidmodal').modal('show');
                return false;
            }
            if (/^\s+$/gi.test(txt))
            {
                return false;
            }

            if (window.preventDuplicateKeyPresses)
                return;

            window.preventDuplicateKeyPresses = true;
            window.setTimeout(function () {
                window.preventDuplicateKeyPresses = false;
            }, 500);

            $.ajax({
                type: 'POST',
                url: base_url + "artist/edit_comment_insertimg",
                // url: '<?php echo base_url() . "artist/edit_comment_insertimg" ?>',
                data: 'post_image_comment_id=' + abc + '&comment=' + encodeURIComponent(txt),
                success: function (data) {
                    document.getElementById('editcommentimgtwo' + abc).style.display = 'none';
                    document.getElementById('showcommentimgtwo' + abc).style.display = 'block';
                    document.getElementById('editsubmitimgtwo' + abc).style.display = 'none';

                    document.getElementById('editcommentboximgtwo' + abc).style.display = 'block';
                    document.getElementById('editcancleimgtwo' + abc).style.display = 'none';

                    $('#' + 'showcommentimgtwo' + abc).html(data);
                    $('#box_comment' + clicked_id).show();

                }
            });
        }
    });
    $(".scroll").click(function (event) {
        event.preventDefault();
        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
    });
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

function seemorediv(abc) { //alert("hii");

    document.getElementById('seemore' + abc).style.display = 'block';
    document.getElementById('lessmore' + abc).style.display = 'none';

}



function check_lengthedit(abc)
{ //alert("hii");
    maxLen = 50;

    var product_name = document.getElementById("editpostname" + abc).value;

    if (product_name.length > maxLen) {
        text_num = maxLen - product_name.length;
        var msg = "You have reached your maximum limit of characters allowed";
        $("#editpostname" + abc).prop("readonly", true);
        document.getElementById("editpostdesc" + abc).contentEditable = false;
        document.getElementById("editpostsubmit" + abc).setAttribute("disabled", "disabled");

        $('#postedit .mes').html("<div class='pop_content'>" + msg + "</div>");
        $('#postedit').modal('show');

        var substrval = product_name.substring(0, maxLen);
        $('#editpostname' + abc).val(substrval);

    } else {
        text_num = maxLen - product_name.length;

        document.getElementById("text_num").value = text_num;
    }
}

