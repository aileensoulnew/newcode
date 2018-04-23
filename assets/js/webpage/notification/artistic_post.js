var modal = document.getElementById('myModal');

                        // Get the button that opens the modal
                        var btn = document.getElementById("myBtn");

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


 //validation for edit email formate form

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
                        url: base_url + "artistic/image_saveBG_ajax",
                        //url: "<?php echo base_url('artistic/image_saveBG_ajax'); ?>",
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


 $(document).ready(function () {
                $('video').mediaelementplayer({
                    alwaysShowControls: false,
                    videoVolume: 'horizontal',
                    features: ['playpause', 'progress', 'volume', 'fullscreen']
                });
            });

 $(function () {
                var showTotalChar = 200, showChar = "Read More", hideChar = "";
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
                                'allowedFileExtensions': ['jpg', 'png', 'gif'],
                                'elErrorContainer': '#errorBlock'
                            });
                            $("#kv-explorer").fileinput({
                                'theme': 'explorer',
                                'uploadUrl': '#',
                                overwriteInitial: false,
                                initialPreviewAsData: true,

                            });
                        });

function checkvalue() {
                            var searchkeyword =$.trim(document.getElementById('tags').value);
                            var searchplace =$.trim(document.getElementById('searchplace').value);
                            if (searchkeyword == "" && searchplace == "") {
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

                                    if(data.notavlpost == 'notavl'){
               $('.biderror .mes').html("<div class='pop_content'>The post that you were deleting on has been removed by its owner and this content is no longer available.</div>");
       $('#bidmodal').modal('show');
            }else{
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

                                    if(data == 'notavl'){
               $('.biderror .mes').html("<div class='pop_content'>The post that you were deleting on has been removed by its owner and this content is no longer available.</div>");
       $('#bidmodal').modal('show');
            }else{
                                    $('#' + 'likecomment' + clicked_id).html(data);
                                       } 
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
                                     if(data == 'notavl'){
               $('.biderror .mes').html("<div class='pop_content'>The post that you were deleting on has been removed by its owner and this content is no longer available.</div>");
       $('#bidmodal').modal('show');
            }else{
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
                            //alert(post_delete.value);
                            $.ajax({
                                type: 'POST',
                                url: base_url + "artistic/delete_comment",
                                //url: '<?php echo base_url() . "artistic/delete_comment" ?>',
                                data: 'post_id=' + clicked_id + '&post_delete=' + post_delete.value,
                                dataType: "json",
                                success: function (data) {
                                    if(data.notavlpost == 'notavl'){
               $('.biderror .mes').html("<div class='pop_content'>The post that you were deleting on has been removed by its owner and this content is no longer available.</div>");
       $('#bidmodal').modal('show');
            }else{
                                    //alert('.' + 'insertcomment' + clicked_id);
                                    $('.' + 'insertcomment' + post_delete.value).html(data.comment);
                                    //$('#' + 'insertcount' + post_delete.value).html(data.count);
                                     $('.like_count_ext' + post_delete.value).html(data.commentcount);
                                    $('.post-design-commnet-box').show();
                                }
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
                                url: base_url + "artistic/delete_commenttwo",
                                //url: '<?php echo base_url() . "artistic/delete_commenttwo" ?>',
                                data: 'post_id=' + clicked_id + '&post_delete=' + post_delete1.value,
                                dataType: "json",
                                success: function (data) {

                                    if(data.notavlpost == 'notavl'){
               $('.biderror .mes').html("<div class='pop_content'>The post that you were deleting on has been removed by its owner and this content is no longer available.</div>");
       $('#bidmodal').modal('show');
            }else{
                                    // $('.' + 'insertcomment' + post_delete.value).html(data);
                                    $('.' + 'insertcommenttwo' + post_delete1.value).html(data.comment);
                                 //   $('#' + 'insertcount' + post_delete1.value).html(data.count);
                                  $('.like_count_ext' + post_delete1.value).html(data.commentcount);
                                    $('.post-design-commnet-box').show();
                                   }
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

                            $('#post_comment' + clicked_id).html("");

                            var x = document.getElementById('threecomment' + clicked_id);
                            var y = document.getElementById('fourcomment' + clicked_id);

                            if (x.style.display === 'block' && y.style.display === 'none') {
                                $.ajax({
                                    type: 'POST',
                                    url: base_url + "artistic/insert_commentthree",
                                    //url: '<?php echo base_url() . "artistic/insert_commentthree" ?>',
                                    data: 'post_id=' + clicked_id + '&comment=' + encodeURIComponent(txt),
                                    dataType: "json",
                                    success: function (data) {

                                        if(data.notavlpost == 'notavl'){
               $('.biderror .mes').html("<div class='pop_content'>The post that you were deleting on has been removed by its owner and this content is no longer available.</div>");
       $('#bidmodal').modal('show');
            }else{

                                        $('textarea').each(function () {
                                            $(this).val('');
                                        });
                                       // $('#' + 'insertcount' + clicked_id).html(data.count);
                                        $('.insertcomment' + clicked_id).html(data.comment);
                                        $('.like_count_ext' + clicked_id).html(data.commentcount);
                                      }
                                    }
                                });

                            } else {

                                $.ajax({
                                    type: 'POST',
                                    url: base_url + "artistic/insert_comment",
                                    //url: '<?php echo base_url() . "artistic/insert_comment" ?>',
                                    data: 'post_id=' + clicked_id + '&comment=' + encodeURIComponent(txt),
                                    dataType: "json",
                                    success: function (data) {

                                        if(data.notavlpost == 'notavl'){
               $('.biderror .mes').html("<div class='pop_content'>The post that you were deleting on has been removed by its owner and this content is no longer available.</div>");
       $('#bidmodal').modal('show');
            }else{

                                        $('textarea').each(function () {
                                            $(this).val('');
                                        });
                                   //     $('#' + 'insertcount' + clicked_id).html(data.count);
                                        $('#' + 'fourcomment' + clicked_id).html(data.comment);
                                        $('.like_count_ext' + clicked_id).html(data.commentcount);
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
                                    if (txt == '' || txt == '<br>') {
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
                                            url: base_url + "artistic/insert_commentthree",
                                            //url: '<?php echo base_url() . "artistic/insert_commentthree" ?>',
                                            data: 'post_id=' + clicked_id + '&comment=' + encodeURIComponent(txt),
                                            dataType: "json",
                                            success: function (data) { //alert(123); alert(data.commentcount);
                                                if(data.notavlpost == 'notavl'){
                      $('.biderror .mes').html("<div class='pop_content'>The post that you were deleting on has been removed by its owner and this content is no longer available.</div>");
                       $('#bidmodal').modal('show');
                      }else{

                                                $('textarea').each(function () {
                                                    $(this).val('');
                                                });
                                              //  $('#' + 'insertcount' + clicked_id).html(data.count);
                                                $('.insertcomment' + clicked_id).html(data.comment);
                                                $('.like_count_ext' + clicked_id).html(data.commentcount);
                                            }
                                           }
                                        });
                                    } else {
                                        $.ajax({
                                            type: 'POST',
                                            url: base_url + "artistic/insert_comment",
                                            //url: '<?php echo base_url() . "artistic/insert_comment" ?>',
                                            data: 'post_id=' + clicked_id + '&comment=' + encodeURIComponent(txt),
                                            dataType: "json",
                                            success: function (data) {

                                                if(data.notavlpost == 'notavl'){
                      $('.biderror .mes').html("<div class='pop_content'>The post that you were deleting on has been removed by its owner and this content is no longer available.</div>");
                       $('#bidmodal').modal('show');
                      }else{

                                                $('textarea').each(function () {
                                                    $(this).val('');
                                                });
                                             //   $('#' + 'insertcount' + clicked_id).html(data.count);
                                                $('#' + 'fourcomment' + clicked_id).html(data.comment);
                                                $('.like_count_ext' + clicked_id).html(data.commentcount);
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

function comment_editbox(clicked_id) {
                            document.getElementById('editcomment' + clicked_id).style.display = 'inline-block';
                            document.getElementById('showcomment' + clicked_id).style.display = 'none';
                            document.getElementById('editsubmit' + clicked_id).style.display = 'inline-block';
                            //document.getElementById('editbox' + clicked_id).style.display = 'none';
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
                                $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_delete(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                                $('#bidmodal').modal('show');
                                return false;
                            }
                            if (/^\s+$/gi.test(txt))
                            {
                                return false;
                            }

                            $.ajax({
                                type: 'POST',
                                url: base_url + "artistic/edit_comment_insert",
                                //url: '<?php echo base_url() . "artistic/edit_comment_insert" ?>',
                                data: 'post_id=' + abc + '&comment=' + encodeURIComponent(txt),
                                success: function (data) {
                                    if(data == 'notavl'){
               $('.biderror .mes').html("<div class='pop_content'>The post that you were deleting on has been removed by its owner and this content is no longer available.</div>");
       $('#bidmodal').modal('show');
            }else{
                                    document.getElementById('editcomment' + abc).style.display = 'none';
                                    document.getElementById('showcomment' + abc).style.display = 'block';
                                    document.getElementById('editsubmit' + abc).style.display = 'none';
                                    document.getElementById('editcommentbox' + abc).style.display = 'block';
                                    document.getElementById('editcancle' + abc).style.display = 'none';
                                    $('#' + 'showcomment' + abc).html(data);
                                    $('.post-design-commnet-box').show();
                                }
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
                                        $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_delete(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                                        $('#bidmodal').modal('show');
                                        return false;
                                    }
                                    if (/^\s+$/gi.test(txt))
                                    {
                                        return false;
                                    }
//                                       

                                    if (window.preventDuplicateKeyPresses)
                                        return;
                                    window.preventDuplicateKeyPresses = true;
                                    window.setTimeout(function () {
                                        window.preventDuplicateKeyPresses = false;
                                    }, 500);
                                    $.ajax({
                                        type: 'POST',
                                        url: base_url + "artistic/edit_comment_insert",
                                       // url: '<?php echo base_url() . "artistic/edit_comment_insert" ?>',
                                        data: 'post_id=' + abc + '&comment=' + encodeURIComponent(txt),
                                        success: function (data) {

                                            if(data == 'notavl'){
               $('.biderror .mes').html("<div class='pop_content'>The post that you were deleting on has been removed by its owner and this content is no longer available.</div>");
       $('#bidmodal').modal('show');
            }else{

                                            document.getElementById('editcomment' + abc).style.display = 'none';
                                            document.getElementById('showcomment' + abc).style.display = 'block';
                                            document.getElementById('editsubmit' + abc).style.display = 'none';
                                            document.getElementById('editcommentbox' + abc).style.display = 'block';
                                            document.getElementById('editcancle' + abc).style.display = 'none';
                                            $('#' + 'showcomment' + abc).html(data);
                                            $('.post-design-commnet-box').show();
                                        }
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
                                url: base_url + "artistic/edit_comment_insert",
                               // url: '<?php echo base_url() . "artistic/edit_comment_insert" ?>',
                                data: 'post_id=' + abc + '&comment=' + encodeURIComponent(txt),
                                success: function (data) {
                                    if(data == 'notavl'){
               $('.biderror .mes').html("<div class='pop_content'>The post that you were deleting on has been removed by its owner and this content is no longer available.</div>");
       $('#bidmodal').modal('show');
            }else{
                                    document.getElementById('editcommenttwo' + abc).style.display = 'none';
                                    document.getElementById('showcommenttwo' + abc).style.display = 'block';
                                    document.getElementById('editsubmittwo' + abc).style.display = 'none';
                                    document.getElementById('editcommentboxtwo' + abc).style.display = 'block';
                                    document.getElementById('editcancletwo' + abc).style.display = 'none';
                                    $('#' + 'showcommenttwo' + abc).html(data);
                                    $('.post-design-commnet-box').show();
                                }
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

                                    txt = txt.replace(/&nbsp;/gi, " ");
                                    txt = txt.replace(/<br>$/, '');
                                    if (txt == '' || txt == '<br>') {
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
                                        url: base_url + "artistic/edit_comment_insert",
                                        //url: '<?php echo base_url() . "artistic/edit_comment_insert" ?>',
                                        data: 'post_id=' + abc + '&comment=' + encodeURIComponent(txt),
                                        success: function (data) {


                     if(data == 'notavl'){
               $('.biderror .mes').html("<div class='pop_content'>The post that you were deleting on has been removed by its owner and this content is no longer available.</div>");
       $('#bidmodal').modal('show');
            }else{

                                            document.getElementById('editcommenttwo' + abc).style.display = 'none';
                                            document.getElementById('showcommenttwo' + abc).style.display = 'block';
                                            document.getElementById('editsubmittwo' + abc).style.display = 'none';

                                            document.getElementById('editcommentboxtwo' + abc).style.display = 'block';
                                            document.getElementById('editcancletwo' + abc).style.display = 'none';

                                            $('#' + 'showcommenttwo' + abc).html(data);
                                            $('.post-design-commnet-box').show();
                                          }
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
                               
                                $.ajax({
                                    type: 'POST',
                                    url: base_url + "artistic/fourcomment",
                                    //url: '<?php echo base_url() . "artistic/fourcomment" ?>',
                                    data: 'art_post_id=' + clicked_id,
                                    //alert(data);
                                    success: function (data) {

                                        if(data == 'notavl'){
               $('.biderror .mes').html("<div class='pop_content'>The post that you were deleting on has been removed by its owner and this content is no longer available.</div>");
       $('#bidmodal').modal('show');
            }else{              
                                         x.style.display = 'none';
                                y.style.display = 'block';
                                z.style.visibility = 'show';
                                        $('#' + 'fourcomment' + clicked_id).html(data);

                                      }
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

   function editpost(abc)
   {
       document.getElementById('editpostdata' + abc).style.display = 'none';
       document.getElementById('editpostbox' + abc).style.display = 'block';
       //document.getElementById('editpostdetails' + abc).style.display = 'none', 'display:inline !important';
       document.getElementById('editpostdetailbox' + abc).style.display = 'block';
       document.getElementById('editpostsubmit' + abc).style.display = 'block';
       document.getElementById('khyati' + abc).style.display = 'none';
       document.getElementById('khyatii' + abc).style.display = 'none';

   }

    function edit_postinsert(abc)
   {
   
       var editpostname = document.getElementById("editpostname" + abc);
       // var editpostdetails = document.getElementById("editpostdesc" + abc);
       // start khyati code
       var $field = $('#editpostdesc' + abc);
       //var data = $field.val();
       var editpostdetails = $('#editpostdesc' + abc).html();
       // end khyati code
   
       if ((editpostname.value == '') && (editpostdetails == '' || editpostdetails == '<br>')) {
           $('.biderror .mes').html("<div class='pop_content'>You must either fill title or description.");
           $('#bidmodal').modal('show');
   
           document.getElementById('editpostdata' + abc).style.display = 'block';
           document.getElementById('editpostbox' + abc).style.display = 'none';
         //  document.getElementById('editpostdetails' + abc).style.display = 'block';
           document.getElementById('editpostdetailbox' + abc).style.display = 'none';
   
           document.getElementById('editpostsubmit' + abc).style.display = 'none';
       } else {
           $.ajax({
               type: 'POST',
               url: base_url + "artistic/edit_post_insert",
               //url: '<?php echo base_url() . "artistic/edit_post_insert" ?>',
               data: 'art_post_id=' + abc + '&art_post=' + editpostname.value + '&art_description=' + editpostdetails,
               dataType: "json",
               success: function (data) {
                    if(data.notavlpost == 'notavl'){
               $('.biderror .mes').html("<div class='pop_content'>The post that you were deleting on has been removed by its owner and this content is no longer available.</div>");
               $('#bidmodal').modal('show');
            }else{
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


                            $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this post?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='remove_post(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                            $('#bidmodal').modal('show');
                        }

 function remove_post(abc)
                         { 
   
       $.ajax({
           type: 'POST',
           url: base_url + "artistic/art_delete_post",
           //url: '<?php echo base_url() . "artistic/art_delete_post" ?>',
           dataType: 'json',
           data: 'art_post_id=' + abc,
           //alert(data);
           success: function (data) { 
   
               $('#' + 'removepost' + abc).remove();
               if(data.notcount == 'count'){
                    $('.' + 'nofoundpost').html(data.notfound);
                   }

   
   
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
           url: base_url + "artistic/del_particular_userpost",
           //url: '<?php echo base_url() . "artistic/del_particular_userpost" ?>',
           dataType: 'json',
           data: 'art_post_id=' + abc,
           //alert(data);
           success: function (data) {
   
               $('#' + 'removepost' + abc).remove();
               if(data.notcount == 'count'){
                    $('.' + 'nofoundpost').html(data.notfound);
                   }

   
   
           }
       });
   
   }

   function followuser(clicked_id)
                        {

                            $("#fad" + clicked_id).fadeOut(6000);


                            $.ajax({
                                type: 'POST',
                                url: base_url + "artistic/follow",
                                //url: '<?php echo base_url() . "artistic/follow" ?>',
                                data: 'follow_to=' + clicked_id,
                                success: function (data) {

                                    $('.' + 'fr' + clicked_id).html(data);

                                }


                            });

                        }

function followclose(clicked_id)
                        {
                            $("#fad" + clicked_id).fadeOut(3000);
                        }

function imgval(event) {
                            //var fileInput = document.getElementById('test-upload');
                            var fileInput = document.getElementById("file-1").files;
                            var product_name = document.getElementById("test-upload_product").value;
                            var product_description = document.getElementById("test-upload_des").value;
                            var product_fileInput = document.getElementById("file-1").value;


                            if (product_fileInput == '' && product_name == '' && product_description == '')
                            {

                                $('.biderror .mes').html("<div class='pop_content'>This post appears to be blank. Please write or attach (photos, videos, audios, pdf) to post.");
                                $('#bidmodal').modal('show');
                                // setInterval('window.location.reload()', 10000);
                                // window.location='';

                                 $( document ).on( 'keydown', function ( e ) {
                                          if ( e.keyCode === 27 ) {
                                        //$( "#bidmodal" ).hide();
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
                                             $( document ).on( 'keydown', function ( e ) {
                                          if ( e.keyCode === 27 ) {
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

                                             $( document ).on( 'keydown', function ( e ) {
                                          if ( e.keyCode === 27 ) {
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

                                             $( document ).on( 'keydown', function ( e ) {
                                          if ( e.keyCode === 27 ) {
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
                                                 $( document ).on( 'keydown', function ( e ) {
                                          if ( e.keyCode === 27 ) {
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

                                             $( document ).on( 'keydown', function ( e ) {
                                          if ( e.keyCode === 27 ) {
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

                                         $( document ).on( 'keydown', function ( e ) {
                                          if ( e.keyCode === 27 ) {
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

 $(document).ready(function () {
                            $('.modal-close').on('click', function () {
                                $('.modal-post').show();
                            });
                        });

  function contentedit(clicked_id) {
                            //var $field = $('#post_comment' + clicked_id);
                            //var data = $field.val();
                            // var post_comment = $('#post_comment' + clicked_id).html();
                            //$(document).ready(function($) {
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
                                                data: 'post_id=' + clicked_id + '&comment=' + encodeURIComponent(txt),
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
                                                data: 'post_id=' + clicked_id + '&comment=' + encodeURIComponent(txt),
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

function likeuserlist(post_id) {

                            $.ajax({
                                type: 'POST',
                                url: base_url + "artistic/likeuserlist",
                               // url: '<?php echo base_url() . "artistic/likeuserlist" ?>',
                                data: 'post_id=' + post_id,
                                dataType: "html",
                                success: function (data) {
                                    var html_data = data;
                                    $('#likeusermodal .mes').html(html_data);
                                    $('#likeusermodal').modal('show');
                                }
                            });


                        }

 $('body').on("click", "*", function (e) {
                            var classNames = $(e.target).attr("class").toString().split(' ').pop();
                            if (classNames != 'fa-ellipsis-v') {
                                $('div[id^=myDropdown]').hide().removeClass('show');
                            }

                        });

function check_length(my_form)
                        {
                            maxLen = 50;

                            // max number of characters allowed
                            if (my_form.my_text.value.length >= maxLen) {
                                // Alert message if maximum limit is reached. 
                                // If required Alert can be removed. 
                                var msg = "You have reached your maximum limit of characters allowed";
                                //    alert(msg);
                                my_form.text_num.value = maxLen - my_form.my_text.value.length;
                                $('.biderror .mes').html("<div class='pop_content'>" + msg + "</div>");
                                $('#bidmodal').modal('show');
                                // Reached the Maximum length so trim the textarea
                                my_form.my_text.value = my_form.my_text.value.substring(0, maxLen);
                            } else { //alert("1");
                                // Maximum length not reached so update the value of my_text counter
                                my_form.text_num.value = maxLen - my_form.my_text.value.length;
                            }
                        }

$( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) {
        //$( "#bidmodal" ).hide();
        $('#likeusermodal').modal('hide');
    }
});  
   
$(document).on('keydown', function (e) { 
    if (e.keyCode === 27) {
        if($('.modal-post').show()){

          $( document ).on( 'keydown', function ( e ) {
          if ( e.keyCode === 27 ) {
        //$( "#bidmodal" ).hide();
       $('.modal-post').hide();
        }
       });  
     

        }
         document.getElementById('myModal').style.display = "none";
         }
 });

//all popup close close using esc end

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

 (function ($) {

                            $(function () {
                                // alert('hi');
                                $("#tags").autocomplete({
                                    source: function (request, response) {
                                        var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
                                        response($.grep(data, function (item) {
                                            return matcher.test(item.label);
                                        }));
                                    },
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
                            });

                        })(jQuery);


(function ($) {

                        
                            $(function () {
                                // alert('hi');
                                $("#searchplace").autocomplete({
                                    source: function (request, response) {
                                        var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
                                        response($.grep(data1, function (item) {
                                            return matcher.test(item.label);
                                        }));
                                    },
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
                            });

                        })(jQuery);