 $('#post').on('click', function(){
        $('#myModal').modal('show');
    });

function myFunction(clicked_id) {
   
        document.getElementById('myDropdown' + clicked_id).classList.toggle("show");
    
         $( document ).on( 'keydown', function ( e ) {
                   if ( e.keyCode === 27 ) { 
   
                   document.getElementById('myDropdown' + clicked_id).classList.toggle("hide");
                    $(".dropdown-content2").removeClass('show');
   
       }
      
   }); 
   
   }

   window.onclick = function (event) {
       if (!event.target.matches('.dropbtn1')) {
   
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
                     url: "<?php echo base_url('artistic/image_saveBG_ajax'); ?>",
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



 // follow user script start

function followuser(clicked_id)
   {
   
       $("#fad" + clicked_id).fadeOut(6000);
   
   
       $.ajax({
           type: 'POST',
           url: base_url + "artistic/follow_home",
           //url: '<?php echo base_url() . "artistic/follow_two" ?>',
            dataType: 'json',
           data: 'follow_to=' + clicked_id,
           success: function (data) {
   
               $('.' + 'fr' + clicked_id).html(data.follow);
               $('#countfollow').html(data.count);
   
           }
   
   
       });
   
   }

    function followclose(clicked_id)
   { //alert("hii");
       $("#fad" + clicked_id).fadeOut(3000);
   }


   function followusercell(clicked_id)
   {
   
       $("#fadcell" + clicked_id).fadeOut(6000);
   
   
       $.ajax({
           type: 'POST',
           url: base_url + "artistic/follow_home",
           //url: '<?php echo base_url() . "artistic/follow_two" ?>',
            dataType: 'json',
           data: 'follow_to=' + clicked_id,
           success: function (data) {
   
               $('.' + 'fr' + clicked_id).html(data.follow);
               $('#countfollow').html(data.count);
   
           }
   
   
       });
   
   }

    function followclosecell(clicked_id)
   { //alert("hii");
       $("#fadcell" + clicked_id).fadeOut(3000);
   }




$(document).ready(function () {
                
                art_home_three_user_list();
                art_home_cellphone_user_list();
            });
            function art_home_three_user_list() {
                $.ajax({
                    type: 'POST',
                    url: base_url + "artistic/art_home_three_user_list",
                    //url: '<?php echo base_url() . "artistic/art_home_three_user_list/" ?>',
                    data: '',
                    dataType: "html",
                    beforeSend: function () {
                        $(".profile-boxProfileCard_follow").html('<p style="text-align:center;"><img src = "'+ base_url + 'images/loading.gif" class = "loader" /></p>');
                    },
                    success: function (data) { //alert(data);
                        $('.loader').remove();
                        $('.profile-boxProfileCard_follow').html(data);
                        var nb = $('.follow_box_ul_li').length;
                        // alert(nb);
                         if(nb > 0){ //alert("jii");
                          document.getElementById("hideuserlist").style.display = "block";
                         }
                    }
                });
            }


             function art_home_cellphone_user_list() {
                $.ajax({
                    type: 'POST',
                    url: base_url + "artistic/art_home_cellphone_user_list",
                    //url: '<?php echo base_url() . "artistic/art_home_three_user_list/" ?>',
                    data: '',
                    dataType: "html",
                    beforeSend: function () {
                        $(".profile-boxProfileCard_follow").html('<p style="text-align:center;"><img src = "'+ base_url + 'images/loading.gif" class = "loader" /></p>');
                    },
                    success: function (data) { //alert(data);
                        $('.loader').remove();
                        $('.profile-boxProfileCard_follow_mobile').html(data);
                    }
                });
            }


 $(document).ready(function () {
       $('video').mediaelementplayer({
           alwaysShowControls: false,
           videoVolume: 'horizontal',
           features: ['playpause', 'progress', 'volume', 'fullscreen']
       });
   });


 $(function () {
       var showTotalChar = 200, showChar = "Read More", hideChar = "";
       $('.show_more').each(function () {
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

// for post upload preview script

  $('#file-fr').fileinput({
       language: 'fr',
       uploadUrl: '#',
       allowedFileExtensions: ['jpg', 'png', 'gif' , 'mp4','mp3','pdf','jpeg']
   });
   $('#file-es').fileinput({
       language: 'es',
       uploadUrl: '#',
       allowedFileExtensions: ['jpg', 'png', 'gif' , 'mp4', 'mp3', 'pdf','jpeg']
   });
   
   $("#file-1").fileinput({
       uploadUrl: '#', // you must set a valid URL here else you will get an error
       allowedFileExtensions: ['jpg', 'png', 'gif' , 'mp4' , 'mp3' ,'pdf','jpeg'],
       overwriteInitial: false,
       maxFileSize: 1000000,
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
           'allowedFileExtensions': ['jpg', 'png', 'gif', 'mp4','mp3','pdf','jpeg'],
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
       //alert("hi");
       var searchkeyword =$.trim(document.getElementById('tags').value);
       var searchplace =$.trim(document.getElementById('searchplace').value);
       
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

// post like script start

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


   // comment like script start

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


   // comment delete script start

   function comment_delete(clicked_id) {
       $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='comment_deleted(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
       $('#bidmodal').modal('show');
   }
   
   function comment_deleted(clicked_id)
   {
      var post_delete = document.getElementById("post_delete" + clicked_id);
       
       $.ajax({
           type: 'POST',
           url: base_url + "artistic/delete_comment",
           //url: '<?php echo base_url() . "artistic/delete_comment" ?>',
           data: 'post_id=' + clicked_id + '&post_delete=' + post_delete.value,
           dataType: "json",
           success: function (data) {  
               $('.' + 'insertcomment' + post_delete.value).html(data.comment);
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
           url: base_url + "artistic/delete_commenttwo",
           //url: '<?php echo base_url() . "artistic/delete_commenttwo" ?>',
           data: 'post_id=' + clicked_id + '&post_delete=' + post_delete1.value,
           dataType: "json",
           success: function (data) {
               $('.' + 'insertcommenttwo' + post_delete1.value).html(data.comment);
             $('.like_count_ext' + post_delete1.value).html(data.commentcount);
               $('.post-design-commnet-box').show();
   
           }
       });
   }


   // insert comment scrpit start
// for only br tag not valid scrtipt strat

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
       txt = txt.replace(/&nbsp;/gi, " ");
       txt = txt.replace(/<br>$/, '');

       txt = txt.replace(/div>/gi, 'p>');
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
               url: base_url + "artistic/insert_commentthree",
               //url: '<?php echo base_url() . "artistic/insert_commentthree" ?>',
               data: 'post_id=' + clicked_id + '&comment=' + encodeURIComponent(txt),
               dataType: "json",
               success: function (data) {
                   $('textarea').each(function () {
                       $(this).val('');
                   });
                   $('.insertcomment' + clicked_id).html(data.comment);
                   $('.like_count_ext' + clicked_id).html(data.commentcount);
   
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
                   $('textarea').each(function () {
                       $(this).val('');
                   });
                   $('#' + 'fourcomment' + clicked_id).html(data.comment);
                   $('.like_count_ext' + clicked_id).html(data.commentcount);
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

              txt = txt.replace(/div>/gi, 'p>');
              txt = txt.replace(/^(\s*<br( \/)?>)*|(<br( \/)?>\s*)*$/gm, '');

              //alert(txt); return false;


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
                       url: base_url + "artistic/insert_commentthree",
                      // url: '<?php echo base_url() . "artistic/insert_commentthree" ?>',
                       data: 'post_id=' + clicked_id + '&comment=' + encodeURIComponent(txt),
                       dataType: "json",
                       success: function (data) { //alert(123); alert(data.commentcount);
                           $('textarea').each(function () {
                               $(this).val('');
                           });
                           $('.insertcomment' + clicked_id).html(data.comment);
                           $('.like_count_ext' + clicked_id).html(data.commentcount);
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
                           $('textarea').each(function () {
                               $(this).val('');
                           });
                           $('#' + 'fourcomment' + clicked_id).html(data.comment);
                           $('.like_count_ext' + clicked_id).html(data.commentcount);
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

   // comment edit script start


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

       $('.hidebottomborder').find('.all-comment-comment-box:last').css('border-bottom','1px solid #d9d9d9');

       //$('div#hidebottomborder .all-comment-comment-box:last').css('border-bottom','1px solid #d9d9d9');  
      
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

       $('.hidebottombordertwo').find('.all-comment-comment-box:last').css('border-bottom','0px');
       $('.hidebottomborder').find('.all-comment-comment-box:last').css('border-bottom','0px');
      

      // $('#hidebottomborder'+ clicked_id).css({"border-bottom": "0px"});

   }

   function comment_editbox3(clicked_id) { //alert(clicked_id); alert('editcomment' + clicked_id); alert('showcomment' + clicked_id); alert('editsubmit' + clicked_id); 
       document.getElementById('editcomment3' + clicked_id).style.display = 'block';
       document.getElementById('showcomment3' + clicked_id).style.display = 'none';
       document.getElementById('editsubmit3' + clicked_id).style.display = 'block';
   
       document.getElementById('editcommentbox3' + clicked_id).style.display = 'none';
       document.getElementById('editcancle3' + clicked_id).style.display = 'block';
       $('.post-design-commnet-box').hide();
   
   }
   
   function comment_editcancletwo(clicked_id) {
   
       document.getElementById('editcommentboxtwo' + clicked_id).style.display = 'block';
       document.getElementById('editcancletwo' + clicked_id).style.display = 'none';
   
       document.getElementById('editcommenttwo' + clicked_id).style.display = 'none';
       document.getElementById('showcommenttwo' + clicked_id).style.display = 'block';
       document.getElementById('editsubmittwo' + clicked_id).style.display = 'none';

       $('.hidebottombordertwo').find('.all-comment-comment-box:last').css('border-bottom','1px solid #d9d9d9');
       $('.hidebottomborder').find('.all-comment-comment-box:last').css('border-bottom','1px solid #d9d9d9');

          
    
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
        txt = txt.replace(/div>/gi, 'p>');
        txt = txt.replace(/^(\s*<br( \/)?>)*|(<br( \/)?>\s*)*$/gm, '');


       if (txt == '' || txt == '<br>' || check_perticular(txt) == true) {
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
   
               txt = txt.replace(/&nbsp;/gi, " ");
               txt = txt.replace(/<br>$/, '');

               txt = txt.replace(/div>/gi, 'p>');
              txt = txt.replace(/^(\s*<br( \/)?>)*|(<br( \/)?>\s*)*$/gm, '');



               if (txt == '' || txt == '<br>' || check_perticular(txt) == true) {
                   $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_delete(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
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
   
       txt = txt.replace(/&nbsp;/gi, " ");
       txt = txt.replace(/<br>$/, '');
       txt = txt.replace(/div>/gi, 'p>');
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
           url: base_url + "artistic/edit_comment_insert",
           //url: '<?php echo base_url() . "artistic/edit_comment_insert" ?>',
           data: 'post_id=' + abc + '&comment=' + encodeURIComponent(txt),
           success: function (data) {
               document.getElementById('editcommenttwo' + abc).style.display = 'none';
               document.getElementById('showcommenttwo' + abc).style.display = 'block';
               document.getElementById('editsubmittwo' + abc).style.display = 'none';
               document.getElementById('editcommentboxtwo' + abc).style.display = 'block';
               document.getElementById('editcancletwo' + abc).style.display = 'none';
               $('#' + 'showcommenttwo' + abc).html(data);
               $('.post-design-commnet-box').show();
               $('.hidebottomborder').find('.all-comment-comment-box:last').css('border-bottom','1px solid #d9d9d9');
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
   
               txt = txt.replace(/&nbsp;/gi, " ");
               txt = txt.replace(/<br>$/, '');
               txt = txt.replace(/div>/gi, 'p>');
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
                   url: base_url + "artistic/edit_comment_insert",
                   //url: '<?php echo base_url() . "artistic/edit_comment_insert" ?>',
                   data: 'post_id=' + abc + '&comment=' + encodeURIComponent(txt),
                   success: function (data) {
                       document.getElementById('editcommenttwo' + abc).style.display = 'none';
                       document.getElementById('showcommenttwo' + abc).style.display = 'block';
                       document.getElementById('editsubmittwo' + abc).style.display = 'none';
   
                       document.getElementById('editcommentboxtwo' + abc).style.display = 'block';
                       document.getElementById('editcancletwo' + abc).style.display = 'none';
   
                       $('#' + 'showcommenttwo' + abc).html(data);
                       $('.post-design-commnet-box').show();
                       $('.hidebottomborder').find('.all-comment-comment-box:last').css('border-bottom','1px solid #d9d9d9');
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


// all comment show script start

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
               //url: '<?php echo base_url() . "artistic/fourcomment" ?>',
               data: 'art_post_id=' + clicked_id,
               //alert(data);
               success: function (data) {
                   $('#' + 'fourcomment' + clicked_id).html(data);
               }
           });
       }
       
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

   //  multi image add post khyati start

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
   
   // success message remove after some second start

    $(document).ready(function () {
   
       $('.alert-danger').delay(3000).hide('700');
   
       $('.alert-success').delay(3000).hide('700');
   
   });


    // save post start

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

   // delete post script start

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

   
   // insert post validation start

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
           // setInterval('window.location.reload()', 10000);
           // window.location='';
   
            $( document ).on( 'keydown', function ( e ) {
                     if ( e.keyCode === 27 ) {
                   //$( "#bidmodal" ).hide();
                   $('#post').modal('hide');
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
               var allowedExtensions = ['jpg', 'jpeg', 'PNG', 'gif', 'png'];
               var allowesvideo = ['mp4', 'webm', 'MP4'];
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
                   }  else if(fileInput.length > 10){

                    $('#post .mes').html("<div class='pop_content'>You can't upload more than 10 images at a time.");
                       $('#post').modal('show');
                       //setInterval('window.location.reload()', 10000);
                       // window.location='';
                        $( document ).on( 'keydown', function ( e ) {
                     if ( e.keyCode === 27 ) {
                   //$( "#bidmodal" ).hide();
                   $('#post').modal('hide');
                   $('.modal-post').show();
   
                  }
               });  
   
                       event.preventDefault();
                       return false;

                   }else if(foundPresent1 == false){
   
                       $('#post .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf.");
                       $('#post').modal('show');
                       //setInterval('window.location.reload()', 10000);
                       // window.location='';
                        $( document ).on( 'keydown', function ( e ) {
                     if ( e.keyCode === 27 ) {
                   //$( "#bidmodal" ).hide();
                   $('#post').modal('hide');
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
                       $('#post .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf.");
                       $('#post').modal('show');
                       //setInterval('window.location.reload()', 10000);
   
                        $( document ).on( 'keydown', function ( e ) {
                     if ( e.keyCode === 27 ) {
                   //$( "#bidmodal" ).hide();
                   $('#post').modal('hide');
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
                           $('#post .mes').html("<div class='pop_content'>You have to add audio title.");
                           $('#post').modal('show');
                           //setInterval('window.location.reload()', 10000);
                            $( document ).on( 'keydown', function ( e ) {
                     if ( e.keyCode === 27 ) {
                   //$( "#bidmodal" ).hide();
                   $('#post').modal('hide');
                   $('.modal-post').show();
   
                  }
               });  
   
                           event.preventDefault();
                           return false;
                       }


                   } else {
                       $('#post .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf.");
                       $('#post').modal('show');
                      // setInterval('window.location.reload()', 10000);
   
                        $( document ).on( 'keydown', function ( e ) {
                     if ( e.keyCode === 27 ) {
                   //$( "#bidmodal" ).hide();
                   $('#post').modal('hide');
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
                           $('#post .mes').html("<div class='pop_content'>You have to add pdf title.");
                           $('#post').modal('show');
                           //setInterval('window.location.reload()', 10000);
                            $( document ).on( 'keydown', function ( e ) {
                     if ( e.keyCode === 27 ) {
                   //$( "#bidmodal" ).hide();
                   $('#post').modal('hide');
                   $('.modal-post').show();
   
                  }
               });  
   
                           event.preventDefault();
                           return false;
                       }
                   } else {
                       $('#post .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf.");
                       $('#post').modal('show');
                       //setInterval('window.location.reload()', 10000);
   
                        $( document ).on( 'keydown', function ( e ) {
                     if ( e.keyCode === 27 ) {
                   //$( "#bidmodal" ).hide();
                   $('#post').modal('hide');
                   $('.modal-post').show();
   
                  }
               });  
   
                       event.preventDefault();
                       return false;
                   }
               } 

               else if (foundPresentvideo == false && foundPresentpdf == false && foundPresentaudio == false && foundPresent == false) {
   
                   $('#post .mes').html("<div class='pop_content'>This File Format is not supported Please Try to Upload images , video , pdf or audio..");
                   $('#post').modal('show');
                  // setInterval('window.location.reload()', 10000);
   
                    $( document ).on( 'keydown', function ( e ) {
                     if ( e.keyCode === 27 ) {
                   //$( "#bidmodal" ).hide();
                   $('#post').modal('hide');
                   $('.modal-post').show();
   
                  }
               });  
   
                   event.preventDefault();
                   return false;
   
               }


               else if (foundPresentvideo == false) {
   
                   $('#post .mes').html("<div class='pop_content'>This File Format is not supported Please Try to Upload MP4 or WebM files..");
                   $('#post').modal('show');
                   //setInterval('window.location.reload()', 10000);
   
                    $( document ).on( 'keydown', function ( e ) {
                     if ( e.keyCode === 27 ) {
                   //$( "#bidmodal" ).hide();
                   $('#post').modal('hide');
                   $('.modal-post').show();
   
                  }
               });  
   
                   event.preventDefault();
                   return false;
   
               }
   
           }
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
   
               $('#post_comment' + clicked_id).html("");
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
                         success: function (data) {
                               $('#' + 'fourcomment' + clicked_id).html(data);
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
   
   }


   // like userlist view script
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

    $('body').on("click", "*", function (e) {
       var classNames = $(e.target).attr("class").toString().split(' ').pop();
       if (classNames != 'fa-ellipsis-v') {
           $('div[id^=myDropdown]').hide().removeClass('show');
       }
   
   });


    function check_length(my_form)
   { 
       maxLen = 50;
       if (my_form.my_text.value.length > maxLen) {
           var msg = "You have reached your maximum limit of characters allowed";
           $("#test-upload_product").prop("readonly", true);
           $('.biderror .mes').html("<div class='pop_content'>" + msg + "</div>");
           $('#bidmodal-limit').modal('show');
           my_form.my_text.value = my_form.my_text.value.substring(0, maxLen);
       } else { 
           my_form.text_num.value = maxLen - my_form.my_text.value.length;
       }
   }


    function check_lengthedit(abc)
   { 
       maxLen = 50;
   

       var product_name = document.getElementById("editpostname" +abc).value;
      
 
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

           document.getElementById("text_num").value = text_num;
       }
   }


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


     

     function khdiv(abc) {
         
         $.ajax({
               type: 'POST',
               url: base_url + "artistic/edit_more_insert",
              // url: '<?php echo base_url() . "artistic/edit_more_insert" ?>',
               data: 'art_post_id=' + abc,
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


   function editpost(abc)
   {

      var editposttitle = $('#editpostval' + abc).html();
      var editpostdesc = $('#khyatii' + abc).html();

       $("#myDropdown" + abc).removeClass('show');
       document.getElementById('editpostdata' + abc).style.display = 'none';
       document.getElementById('editpostbox' + abc).style.display = 'block';
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
   { //alert("hii");
   
       var editpostname = document.getElementById("editpostname" + abc);
       //alert(editpostname);
       var $field = $('#editpostdesc' + abc);
       var editpostdetails = $('#editpostdesc' + abc).html();
       editpostdetails = editpostdetails.replace(/&gt;/gi,">");
       editpostdetails = editpostdetails.replace(/&nbsp;/gi, " ");
        editpostdetails = editpostdetails.replace(/div>/gi, 'p>');
        editpostdetails = editpostdetails.replace(/^(\s*<br( \/)?>)*|(<br( \/)?>\s*)*$/gm, '');

        //alert(editpostdetails);

      
       if ((editpostname.value.trim() == '') && (editpostdetails.trim() == '' || editpostdetails == '<br>' || check_perticular(editpostdetails) == true)) {
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
               //url: '<?php echo base_url() . "artistic/edit_post_insert" ?>',
               data: 'art_post_id=' + abc + '&art_post=' + editpostname.value + '&art_description=' + encodeURIComponent(editpostdetails),
               dataType: "json",
               success: function (data) { //alert("hii");
   
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
   

// all popup close close using esc start



    $( document ).on( 'keydown', function ( e ) {
       if ( e.keyCode === 27 ) {
           $('#likeusermodal').modal('hide');
       }
   });  

    $(document).on('keydown', function (e) { 
       if (e.keyCode === 27) {
           if($('.modal-post').show()){
   
             $( document ).on( 'keydown', function ( e ) {
             if ( e.keyCode === 27 ) {
          $('.modal-post').hide();

           }
          });  
        
           }
            }
    });

    $( document ).on( 'keydown', function ( e ) {
       if ( e.keyCode === 27 ) {
           $('#post').modal('hide');
          
       }
   });  

    $( document ).on( 'keydown', function ( e ) {
       if ( e.keyCode === 27 ) {
           $('#postedit').modal('hide');
           $('.my_text').attr('readonly', false);
         $('.editable_text').attr('contentEditable', true);
         $('.fr').attr('disabled', false);
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

                    if (!_onPaste_StripFormatting_IEPaste) {
                        _onPaste_StripFormatting_IEPaste = true;
                        e.preventDefault();
                        window.document.execCommand('ms-pasteTextOnly', false);
                    }
                    _onPaste_StripFormatting_IEPaste = false;
                }

            }


function seemorediv(abc) { 
         
                   document.getElementById('seemore' + abc).style.display = 'block';
                   document.getElementById('lessmore' + abc).style.display = 'none';
                
   }

  $(document).ready(function(){ 

  var nb = $('div.post-design-box').length;
   if(nb == 0){
 $("#dropdownclass").addClass("no-post-h2");

   }

});

     $('#file-1').on('click', function(e){
        var a = document.getElementById('test-upload_product').value;
        var b = document.getElementById('test-upload_des').value;
    document.getElementById("artpostform").reset();
    document.getElementById('test-upload_product').value = a;
    document.getElementById('test-upload_des').value = b;
    });

     $('#post').on('click', function () {
    $('#myModal').modal('show');
    $("#test-upload_product").prop("readonly", false);
    });

     $('#postedit').on('click', function () {
    $('.my_text').attr('readonly', false);
         $('.editable_text').attr('contentEditable', true);
         $('.fr').attr('disabled', false);
    });


     // post upload using ajax start
   jQuery(document).ready(function ($) {

    var bar = $('.progress-bar');
    var percent = $('.sr-only');
    var options = {
    beforeSend: function () { 
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
            var percentVal = '100%';
            bar.width(percentVal)
                    percent.html(percentVal);
            },
            complete: function (response) {
            // Output AJAX response to the div container
            document.getElementById('test-upload_product').value = '';
           document.getElementById('test-upload_des').value = '';
           document.getElementById('file-1').value = '';
            $("input[name='my_text']").val(50);
            $(".file-preview-frame").hide();
            document.getElementById("progress_div").style.display = "none";
            $('.art-all-post div:first').remove();
            $(".art-all-post").prepend(response.responseText);
            // second header class add for scroll
            var nb = $('.post-design-box').length;
            //alert(nb);
            if (nb == 0) { //alert("hii");
            $("#dropdownclass").addClass("no-post-h2");
            } else { 
            document.getElementById("no_post_avl").style.display = "none";

            $("#dropdownclass").removeClass("no-post-h2");
            }
            $('html, body').animate({scrollTop: $(".upload-image-messages").offset().top - 100}, 150);
            }
    };
    // Submit the form
    $(".upload-image-form").ajaxForm(options);
    return false;
    });


 $('#common-limit').on('click', function(){
        $('#myModal').modal('show');
    $("#test-upload_product").prop("readonly", false);

    });

 $( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) {
       
if(document.getElementById('bidmodal-limit').style.display === "block"){ 
        $('#bidmodal-limit').modal('hide');
    $("#test-upload_product").prop("readonly", false);
        
        $('#myModal').model('show');
 }
        document.getElementById('myModal').style.display === "none";

    }
});  


 

