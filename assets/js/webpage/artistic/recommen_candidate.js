
$(document).ready(function () { 
    artistic_search_post();

    $(window).scroll(function () {
        //if ($(window).scrollTop() == $(document).height() - $(window).height()) {
        if ($(window).scrollTop() + $(window).height() >= $(document).height()) {

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
                    artistic_search_post(pagenum);
                }
            }
        }
    });
});
var isProcessing = false;
function artistic_search_post(pagenum) { 
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
        url: base_url + "artistic/ajax_artistic_search?page=" + pagenum + "&skills=" + keyword + "&searchplace=" + keyword1,
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




$( document ).on( 'keydown', function ( e ) {
       if ( e.keyCode === 27 ) {
           //$( "#bidmodal" ).hide();
           $('#postedit').modal('hide');
         $('.my_text').attr('readonly', false);
         $('.editable_text').attr('contentEditable', true);
         $('.fr').attr('disabled', false);

       }
   });  


$('#postedit').on('click', function () {
   // $('#myModal').modal('show');
    $(".my_text").prop("readonly", false);
     $('.editable_text').attr('contentEditable', true);
         $('.fr').attr('disabled', false);
    });
  

function check_lengthedit(abc)
   { //alert("hii");
       maxLen = 50;
   

       var product_name = document.getElementById("editpostname" +abc).value;
       //alert(product_name);
      
 
       if (product_name.length > maxLen) { 

           
           text_num = maxLen - product_name.length;
           var msg = "You have reached your maximum limit of characters allowed";

            $("#editpostname" + abc).prop("readonly", true);
             document.getElementById("editpostdesc" + abc).contentEditable = false;
           document.getElementById("editpostsubmit"+abc).setAttribute("disabled","disabled");
              
           $('#postedit .mes').html("<div class='pop_content'>" + msg + "</div>");
           $('#postedit').modal('show');
           
           var substrval = product_name.substring(0, maxLen);
           $('#editpostname' + abc).val(substrval);
         
       } else { 
           text_num = maxLen - product_name.length;

           document.getElementById("text_num_").value = text_num;
       }
   }


 function checkvalue() {
                            //alert("hi");
                            var searchkeyword =$.trim(document.getElementById('tags').value);
                            var searchplace =$.trim(document.getElementById('searchplace').value);
                            // alert(searchkeyword);
                            // alert(searchplace);
                            if (searchkeyword == "" && searchplace == "") {
                                //alert('Please enter Keyword');
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

 
function post_like(clicked_id)
                        {
                            $.ajax({
                                type: 'POST',
                                url: base_url + "artistic/like_post",
                                //url: '<?php echo base_url() . "artistic/like_post" ?>',
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
                                }
                            });
                        }

 function comment_like(clicked_id)
                        {

                            $.ajax({
                                type: 'POST',
                                url: base_url + "artistic/like_comment",
                                //url: '<?php echo base_url() . "artistic/like_comment" ?>',
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
                                url: base_url + "artistic/like_comment1",
                                //url: '<?php echo base_url() . "artistic/like_comment1" ?>',
                                data: 'post_id=' + clicked_id,
                                success: function (data) {
                                    $('#' + 'likecomment1' + clicked_id).html(data);

                                }
                            });
                        }
 function comment_delete(clicked_id) {
                            $('.biderror .mes').html("<div class='pop_content'>Are you sure you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='comment_deleted(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                            $('#bidmodal').modal('show');
                        }

                        function comment_deleted(clicked_id)
                        {
                            var post_delete = document.getElementById("post_delete" + clicked_id);
                            //alert(post_delete.value);
                            $.ajax({
                                type: 'POST',
                                url: base_url + "artistic/delete_comment",
                                //url: '<?php echo base_url() . "artistic/delete_comment" ?>',
                                data: 'post_id=' + clicked_id + '&post_delete=' + post_delete.value,
                                dataType: "json",
                                success: function (data) {
                                    //alert('.' + 'insertcomment' + clicked_id);
                                    $('.' + 'insertcomment' + post_delete.value).html(data.comment);
                                  //  $('#' + 'insertcount' + post_delete.value).html(data.count);
                                     $('.comment_count' + post_delete.value).html(data.commentcount);
                                        $('.post-design-commnet-box').show();
                                }
                            });
                        }

                        function comment_deletetwo(clicked_id)
                        {
                            $('.biderror .mes').html("<div class='pop_content'>Are you sure you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='comment_deletedtwo(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                            $('#bidmodal').modal('show');
                        }

function comment_deletedtwo(clicked_id)
                        {
                            var post_delete1 = document.getElementById("post_deletetwo");
                            $.ajax({
                                type: 'POST',
                                url: base_url + "artistic/delete_commenttwo",
                                //url: '<?php echo base_url() . "artistic/delete_commenttwo" ?>',
                                data: 'post_id=' + clicked_id + '&post_delete=' + post_delete1.value,
                                dataType: "json",
                                success: function (data) {

                                    // $('.' + 'insertcomment' + post_delete.value).html(data);
                                    $('.' + 'insertcommenttwo' + post_delete1.value).html(data.comment);
                                //    $('#' + 'insertcount' + post_delete1.value).html(data.count);
                                       $('.comment_count' + post_delete1.value).html(data.commentcount);
                                      $('.post-design-commnet-box').show();

                                }
                            });
                        }

function check_perticular(input) {
                        var testData = input.replace(/\s/g, '');
                        var regex = /^(<br>)*$/;
                        var isValid = regex.test(testData);
                        return isValid;
                    }

function insert_comment(clicked_id)
                        {
                            $("#post_comment" + clicked_id).click(function () {
                                $(this).prop("contentEditable", true);
                                $(this).html("");
                            });

                            var sel = $("#post_comment" + clicked_id);
                            var txt = sel.html();
                            txt = txt.replace(/^(\s*<br( \/)?>)*|(<br( \/)?>\s*)*$/gm, '');

                            if (txt == '' || txt == '<br>' || check_perticular(txt) == true) {
                                return false;
                            }

                            $('#post_comment' + clicked_id).html("");

                            var x = document.getElementById('threecomment' + clicked_id);
                            var y = document.getElementById('fourcomment' + clicked_id);

                            if (x.style.display === 'block' && y.style.display === 'none') {
                                $.ajax({
                                    type: 'POST',
                                    url: base_url + "artistic/insert_commentthree",
                                    //url: '<?php echo base_url() . "artistic/insert_commentthree" ?>',
                                    data: 'post_id=' + clicked_id + '&comment=' + txt,
                                    dataType: "json",
                                    success: function (data) {
                                        $('textarea').each(function () {
                                            $(this).val('');
                                        });
                                  //      $('#' + 'insertcount' + clicked_id).html(data.count);
                                        $('.insertcomment' + clicked_id).html(data.comment);
                                        $('.comment_count' + clicked_id).html(data.commentcount);

                                    }
                                });

                            } else {

                                $.ajax({
                                    type: 'POST',
                                    url: base_url + "artistic/insert_comment",
                                    //url: '<?php echo base_url() . "artistic/insert_comment" ?>',
                                    data: 'post_id=' + clicked_id + '&comment=' + txt,
                                    dataType: "json",
                                    success: function (data) {
                                        $('textarea').each(function () {
                                            $(this).val('');
                                        });
                              //   $('#' + 'insertcount' + clicked_id).html(data.count);
                                        $('#' + 'fourcomment' + clicked_id).html(data.comment);
                                        $('.comment_count' + clicked_id).html(data.commentcount);
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
                                    txt = txt.replace(/^(\s*<br( \/)?>)*|(<br( \/)?>\s*)*$/gm, '');


                                    if (txt == '' || txt == '<br>' || check_perticular(txt) == true) {
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
                                            url: base_url + "artistic/insert_commentthree",
                                            //url: '<?php echo base_url() . "artistic/insert_commentthree" ?>',
                                            data: 'post_id=' + clicked_id + '&comment=' + txt,
                                            dataType: "json",
                                            success: function (data) {
                                                $('textarea').each(function () {
                                                    $(this).val('');
                                                });
                                              //  $('#' + 'insertcount' + clicked_id).html(data.count);
                                                $('.insertcomment' + clicked_id).html(data.comment);
                                               $('.comment_count' + clicked_id).html(data.commentcount);
                                       }
                                        });
                                    } else {
                                        $.ajax({
                                            type: 'POST',
                                            url: base_url + "artistic/insert_comment",
                                            //url: '<?php echo base_url() . "artistic/insert_comment" ?>',
                                            data: 'post_id=' + clicked_id + '&comment=' + txt,
                                            dataType: "json",
                                            success: function (data) {
                                                $('textarea').each(function () {
                                                    $(this).val('');
                                                });
                                             //   $('#' + 'insertcount' + clicked_id).html(data.count);
                                                $('#' + 'fourcomment' + clicked_id).html(data.comment);
                                                $('.comment_count' + clicked_id).html(data.commentcount);
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

 function comment_editbox(clicked_id) {
                            document.getElementById('editcomment' + clicked_id).style.display = 'inline-block';
                            document.getElementById('showcomment' + clicked_id).style.display = 'none';
                            document.getElementById('editsubmit' + clicked_id).style.display = 'inline-block';
                            //document.getElementById('editbox' + clicked_id).style.display = 'none';
                            document.getElementById('editcommentbox' + clicked_id).style.display = 'none';
                            document.getElementById('editcancle' + clicked_id).style.display = 'block';
                            $('.post-design-commnet-box').hide();
                            $('.hidebottomborder').find('.all-comment-comment-box:last').css('border-bottom','0px');

                        }


                        function comment_editcancle(clicked_id) {
                            document.getElementById('editcommentbox' + clicked_id).style.display = 'block';
                            document.getElementById('editcancle' + clicked_id).style.display = 'none';
                            document.getElementById('editcomment' + clicked_id).style.display = 'none';
                            document.getElementById('showcomment' + clicked_id).style.display = 'block';
                            document.getElementById('editsubmit' + clicked_id).style.display = 'none';

                            $('.post-design-commnet-box').show();
                            $('.hidebottomborder').find('.all-comment-comment-box:last').css('border-bottom','1px solid #d9d9d9');

                        }

                        function comment_editboxtwo(clicked_id) {
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
                            $('.post-design-commnet-box').hide();
                            $('.hidebottombordertwo').find('.all-comment-comment-box:last').css('border-bottom','0px');

                        }


                        function comment_editcancletwo(clicked_id) {

                            document.getElementById('editcommentboxtwo' + clicked_id).style.display = 'block';
                            document.getElementById('editcancletwo' + clicked_id).style.display = 'none';

                            document.getElementById('editcommenttwo' + clicked_id).style.display = 'none';
                            document.getElementById('showcommenttwo' + clicked_id).style.display = 'block';
                            document.getElementById('editsubmittwo' + clicked_id).style.display = 'none';
                            $('.hidebottombordertwo').find('.all-comment-comment-box:last').css('border-bottom','1px solid #d9d9d9');

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

function edit_comment(abc)
                        {
                            $("#editcomment" + abc).click(function () {
                                $(this).prop("contentEditable", true);
                            });

                            var sel = $("#editcomment" + abc);
                            var txt = sel.html();
                            txt = txt.replace(/^(\s*<br( \/)?>)*|(<br( \/)?>\s*)*$/gm, '');


                            if (txt == '' || txt == '<br>' || check_perticular(txt) == true) {
                                $('.biderror .mes').html("<div class='pop_content'>Are you sure you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_delete(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                                $('#bidmodal').modal('show');
                                return false;
                            }
                            $.ajax({
                                type: 'POST',
                                url: base_url + "artistic/edit_comment_insert",
                                //url: '<?php echo base_url() . "artistic/edit_comment_insert" ?>',
                                data: 'post_id=' + abc + '&comment=' + txt,
                                success: function (data) {
                                    document.getElementById('editcomment' + abc).style.display = 'none';
                                    document.getElementById('showcomment' + abc).style.display = 'block';
                                    document.getElementById('editsubmit' + abc).style.display = 'none';
                                    document.getElementById('editcommentbox' + abc).style.display = 'block';
                                    document.getElementById('editcancle' + abc).style.display = 'none';
                                    $('#' + 'showcomment' + abc).html(data);
                                    $('.post-design-commnet-box').show();
                                    $('.hidebottomborder').find('.all-comment-comment-box:last').css('border-bottom','1px solid #d9d9d9');

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
                                    txt = txt.replace(/^(\s*<br( \/)?>)*|(<br( \/)?>\s*)*$/gm, '');


                                    if (txt == '' || txt == '<br>' || check_perticular(txt) == true) {
                                        $('.biderror .mes').html("<div class='pop_content'>Are you sure you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_delete(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                                        $('#bidmodal').modal('show');
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
                                        url: base_url + "artistic/edit_comment_insert",
                                        //url: '<?php echo base_url() . "artistic/edit_comment_insert" ?>',
                                        data: 'post_id=' + abc + '&comment=' + txt,
                                        success: function (data) {
                                            document.getElementById('editcomment' + abc).style.display = 'none';
                                            document.getElementById('showcomment' + abc).style.display = 'block';
                                            document.getElementById('editsubmit' + abc).style.display = 'none';
                                            document.getElementById('editcommentbox' + abc).style.display = 'block';
                                            document.getElementById('editcancle' + abc).style.display = 'none';
                                            $('#' + 'showcomment' + abc).html(data);
                                            $('.post-design-commnet-box').show();
                                    $('.hidebottomborder').find('.all-comment-comment-box:last').css('border-bottom','1px solid #d9d9d9');

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
                            txt = txt.replace(/^(\s*<br( \/)?>)*|(<br( \/)?>\s*)*$/gm, '');

                            if (txt == '' || txt == '<br>' || check_perticular(txt) == true) {
                                $('.biderror .mes').html("<div class='pop_content'>Are you sure you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_deletetwo(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                                $('#bidmodal').modal('show');
                                return false;
                            }
                            $.ajax({
                                type: 'POST',
                                url: base_url + "artistic/edit_comment_insert",
                                //url: '<?php echo base_url() . "artistic/edit_comment_insert" ?>',
                                data: 'post_id=' + abc + '&comment=' + txt,
                                success: function (data) {
                                    document.getElementById('editcommenttwo' + abc).style.display = 'none';
                                    document.getElementById('showcommenttwo' + abc).style.display = 'block';
                                    document.getElementById('editsubmittwo' + abc).style.display = 'none';
                                    document.getElementById('editcommentboxtwo' + abc).style.display = 'block';
                                    document.getElementById('editcancletwo' + abc).style.display = 'none';
                                    $('#' + 'showcommenttwo' + abc).html(data);
                                    $('.post-design-commnet-box').show();
                                    $('.hidebottombordertwo').find('.all-comment-comment-box:last').css('border-bottom','1px solid #d9d9d9');

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
                                //$(this).html("");
                            });
                            $('#editcommenttwo' + abc).keypress(function (event) {
                                if (event.which == 13 && event.shiftKey != 1) {
                                    event.preventDefault();
                                    var sel = $("#editcommenttwo" + abc);
                                    var txt = sel.html();
                                    txt = txt.replace(/^(\s*<br( \/)?>)*|(<br( \/)?>\s*)*$/gm, '');

                                    if (txt == '' || txt == '<br>' || check_perticular(txt) == true) {
                                        $('.biderror .mes').html("<div class='pop_content'>Are you sure you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_deletetwo(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                                        $('#bidmodal').modal('show');
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
                                        url: base_url + "artistic/edit_comment_insert",
                                        //url: '<?php echo base_url() . "artistic/edit_comment_insert" ?>',
                                        data: 'post_id=' + abc + '&comment=' + txt,
                                        success: function (data) {
                                            document.getElementById('editcommenttwo' + abc).style.display = 'none';
                                            document.getElementById('showcommenttwo' + abc).style.display = 'block';
                                            document.getElementById('editsubmittwo' + abc).style.display = 'none';

                                            document.getElementById('editcommentboxtwo' + abc).style.display = 'block';
                                            document.getElementById('editcancletwo' + abc).style.display = 'none';

                                            $('#' + 'showcommenttwo' + abc).html(data);
                                            $('.post-design-commnet-box').show();
                                    $('.hidebottombordertwo').find('.all-comment-comment-box:last').css('border-bottom','1px solid #d9d9d9');
                                            

                                        }
                                    });
                                }
                            });
                            $(".scroll").click(function (event) {
                                event.preventDefault();
                                $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
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
                                    url: base_url + "artistic/fourcomment",
                                   // url: '<?php echo base_url() . "artistic/fourcomment" ?>',
                                    data: 'art_post_id=' + clicked_id,
                                    //alert(data);
                                    success: function (data) {
                                        $('#' + 'fourcomment' + clicked_id).html(data);
                                    }
                                });
                            }
                           
                        }

    function myFunction(clicked_id) {
                            document.getElementById('myDropdown' + clicked_id).classList.toggle("show");


                            $( document ).on( 'keydown', function ( e ) {
                     if ( e.keyCode === 27 ) { 

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
                        
$(function () {
                            var showTotalChar = 200, showChar = "More", hideChar = "less";
                            $('.show').each(function () {
                                //var content = $(this).text();
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

                        $fileUpload.change(function (e) {//alert("aaaa");
                            handleFileSelect(e);
                        });

                        $list.on('click', '.remove_thumb', function () {//alert("aaaaa");
                            var $removeBtns = $('.remove_thumb'); // Get all of them in collection
                            var idx = $removeBtns.index(this);   // Exact Index-from-collection
                            $(this).closest('span.thumbParent').remove(); // Remove tumbnail parent
                            thumbsArray.splice(idx, 1); // Remove from array
                        });



$(document).ready(function () {

                            $('.alert-danger').delay(3000).hide('700');

                            $('.alert-success').delay(3000).hide('700');

                        });

function khdiv(abc) { 


      document.getElementById('khyati' + abc).style.display = 'none';
      document.getElementById('khyatii' + abc).style.display = 'block';//alert(abc);
         
         $.ajax({
               type: 'POST',
               url: base_url + "artistic/edit_more_insert",
               //url: '<?php echo base_url() . "artistic/edit_more_insert" ?>',
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


function cursorpointer(abc){

   elem = document.getElementById('editpostdesc' + abc);
   elem.focus();
  setEndOfContenteditable(elem);
}

function setEndOfContenteditable(contentEditableElement)
{
    var range,selection;
    if(document.createRange)
    {
        range = document.createRange();//Create a range (a range is a like the selection but invisible)
        range.selectNodeContents(contentEditableElement);//Select the entire contents of the element with the range
        range.collapse(false);//collapse the range to the end point. false means collapse to end rather than the start
        selection = window.getSelection();//get the selection object (allows you to change selection)
        selection.removeAllRanges();//remove any selections already made
        selection.addRange(range);//make the range you have just created the visible selection
    }
    else if(document.selection)
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

                            $("#myDropdown" + abc).removeClass('show');

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

   function edit_postinsert(abc)
   {
   
       var editpostname = document.getElementById("editpostname" + abc);
       var editpostname = document.getElementById("editpostname" + abc);
                        // var editpostdetails = document.getElementById("editpostdesc" + abc);
                        // start khyati code
                        var $field = $('#editpostdesc' + abc);
                        //var data = $field.val();
                        var editpostdetails = $('#editpostdesc' + abc).html();
                        editpostdetails = editpostdetails.replace(/&gt;/gi, ">");
                        editpostdetails = editpostdetails.replace(/&nbsp;/gi, " ");
                        // end khyati code
                        //alert(editpostdetails);
                        if ((editpostname.value == '') && (editpostdetails == '' || editpostdetails == '<br>')) {
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
                            url: base_url + "artistic/edit_post_insert",
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
                                $('#' + 'postname' + abc).html(data.postname);
                                }
                        });
                        }
    }

   function save_post(abc)
                        {

                            $.ajax({
                                type: 'POST',
                                url: base_url + "artistic/artistic_save",
                                //url: '<?php echo base_url() . "artistic/artistic_save" ?>',
                                data: 'art_post_id=' + abc,
                                success: function (data) {

                                    $('.' + 'savedpost' + abc).html(data);
                                    //window.setTimeout(update, 10000);

                                }
                            });

                        }

function deleteownpostmodel(abc) {


                            $('.biderror .mes').html("<div class='pop_content'>Are you sure want to Delete Your post?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='remove_post(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                            $('#bidmodal').modal('show');
                        }

 function remove_post(abc)
                        {

                            $.ajax({
                                type: 'POST',
                                url: base_url + "artistic/art_delete_post",
                                //url: '<?php echo base_url() . "artistic/art_deletepost" ?>',
                                dataType: 'json',
                                data: 'art_post_id=' + abc,
                                //alert(data);
                                success: function (data) {

                                    $('#' + 'removepost' + abc).html(data);



                                }
                            });

                        }

function deletepostmodel(abc) {


                            $('.biderror .mes').html("<div class='pop_content'>Are you sure want to Delete this post From Your Profile?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='del_particular_userpost(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                            $('#bidmodal').modal('show');
                        }

function del_particular_userpost(abc)
                        {
                            $.ajax({
                                type: 'POST',
                                url: base_url + "artistic/del_particular_userpost",
                                //url: '<?php echo base_url() . "artistic/del_particular_userpost" ?>',
                                dataType: 'json',
                                data: 'art_post_id=' + abc,
                                //alert(data);
                                success: function (data) {

                                    $('#' + 'removepost' + abc).html(data);
                                    //window.location = base_url + "artistic/home";



                                }
                            });

                        }

function followuser(clicked_id)
    {
      //alert(clicked_id);
        $.ajax({
            type: 'POST',
            url: base_url + "artistic/follow",
            //url: '<?php echo base_url() . "artistic/follow_two" ?>',
            dataType: 'json',
            data: 'follow_to=' + clicked_id,
            success: function (data) {

                $('.' + 'fruser' + clicked_id).html(data.follow);
                $('#countfollow').html(data.count);

            }
        });
    }

    function unfollowuser(clicked_id)
    {

        $.ajax({
            type: 'POST',
            url: base_url + "artistic/unfollow",
            //url: '<?php echo base_url() . "artistic/unfollow_two" ?>',
            dataType: 'json',
            data: 'follow_to=' + clicked_id,
            success: function (data) {

                $('#countfollow').html(data.count);
                $('.' + 'fruser' + clicked_id).html(data.follow);

            }
        });
    }

    function followclose(clicked_id)
                        {
                            $("#fad" + clicked_id).fadeOut(3000);
                        }
function imgval(event) {
                            //var fileInput = document.getElementById('test-upload');
                            var fileInput = document.getElementById("test-upload").files;
                            var product_name = document.getElementById("test-upload_product").value;
                            var product_description = document.getElementById("test-upload_des").value;
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

 function contentedit(clicked_id) {
                            
                            $("#post_comment" + clicked_id).click(function () {
                                $(this).prop("contentEditable", true);
                                $(this).html("");
                            });
                            $("#post_comment" + clicked_id).keypress(function (event) { //alert(post_comment);
                                if (event.which == 13 && event.shiftKey != 1) { //alert(post_comment);
                                    event.preventDefault();
                                    var sel = $("#post_comment" + clicked_id);
                                    var txt = sel.html();

                                    $('#post_comment' + clicked_id).html("");
                                    // $("#result").html(txt);
                                    // sel.html("")
                                    // sel.blur();
                                    //alert('.insertcomment' + clicked_id);
                                    var x = document.getElementById('threecomment' + clicked_id);
                                    var y = document.getElementById('fourcomment' + clicked_id);
                                    if (txt == '') {
                                        event.preventDefault();
                                        return false;
                                    } else {
                                        if (x.style.display === 'block' && y.style.display === 'none') {
                                            $.ajax({
                                                type: 'POST',
                                                url: base_url + "artistic/insert_commentthree",
                                                //url: '<?php echo base_url() . "artistic/insert_commentthree" ?>',
                                                data: 'post_id=' + clicked_id + '&comment=' + txt,
                                                dataType: "json",
                                                success: function (data) {

                                                    //  $('.insertcomment' + clicked_id).html(data);
                                                    $('#' + 'insertcount' + clicked_id).html(data.count);
                                                    $('.insertcomment' + clicked_id).html(data.comment);

                                                }
                                            });

                                        } else {

                                            $.ajax({
                                                type: 'POST',
                                                url: base_url + "artistic/insert_comment",
                                                //url: '<?php echo base_url() . "artistic/insert_comment" ?>',
                                                data: 'post_id=' + clicked_id + '&comment=' + txt,
                                                // dataType: "json",
                                                success: function (data) {
                                                    $('#' + 'fourcomment' + clicked_id).html(data);
                                                    // $('#' + 'insertcount' + clicked_id).html(data.count);
                                                    //  $('#' + 'fourcomment' + clicked_id).html(data.comment);

                                                }
                                            });
                                        }
                                    }

                                }
                            });
                            $(".scroll").click(function (event) {
                                event.preventDefault();
                                $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
                            });

                            // });

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
                            //allowedFileTypes: ['image', 'video', 'flash'],
                            slugCallback: function (filename) {
                                return filename.replace('(', '_').replace(']', '_');
                            }
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
                                    {caption: "nature-1.jpg", size: 329892, width: "120px", url: "{$url}", key: 1},
                                    {caption: "nature-2.jpg", size: 872378, width: "120px", url: "{$url}", key: 2},
                                    {caption: "nature-3.jpg", size: 632762, width: "120px", url: "{$url}", key: 3},
                                ]
                            });

                        });

function likeuserlist(post_id) {

                            $.ajax({
                                type: 'POST',
                                url: base_url + "artistic/likeuserlist",
                                //url: '<?php echo base_url() . "artistic/likeuserlist" ?>',
                                data: 'post_id=' + post_id,
                                dataType: "html",
                                success: function (data) {
                                    var html_data = data;
                                    $('#likeusermodal .mes').html(html_data);
                                    $('#likeusermodal').modal('show');
                                }
                            });


                        }

    $( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) {
        //$( "#bidmodal" ).hide();
        $('#bidmodal').modal('hide');
    }
});  

