
 


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
   $(document).on('keydown', function (e) {
       if (e.keyCode === 27) {
           $("#myModal1").hide();
           $("body").removeClass("model-open");
       }
   });
  
  function checkvalue() {
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
$(document).ready(function () {
       $('.blocks').jMosaic({items_type: "li", margin: 0});
       $('.pictures').jMosaic({min_row_height: 150, margin: 3, is_first_big: true});
   });
   
    function mulimg_like(clicked_id)
   {  
       $.ajax({
           type: 'POST',
           url: base_url + "artistic/mulimg_like",
           //url: '<?php echo base_url() . "artistic/mulimg_like" ?>',
           data: 'post_image_id=' + clicked_id,
           success: function (data) {
               $('.' + 'likepost' + clicked_id).html(data); 
           }
       });
   }

function commentall(clicked_id) { 
       var x = document.getElementById('threecomment' + clicked_id);
       var y = document.getElementById('fourcomment' + clicked_id);
       var z = document.getElementById('insertcountimg' + clicked_id);
       if (x.style.display === 'block' && y.style.display === 'none') { 
           x.style.display = 'none';
           y.style.display = 'block';
           z.style.display = 'none';
           $.ajax({
               type: 'POST',
               url: base_url + "artistic/multifourcomment",
               //url: '<?php echo base_url() . "artistic/multifourcomment" ?>',
               data: 'art_post_id=' + clicked_id,
               //alert(data);
               success: function (data) {
                   $('#' + 'fourcomment' + clicked_id).html(data); 
               }
           }); 
       }  
   }

function insert_commentimg(clicked_id)
   {
       var $field = $('#post_commentimg' + clicked_id);
       var post_commentimg = $('#post_commentimg' + clicked_id).html();
       var x = document.getElementById('threecomment' + clicked_id);
       var y = document.getElementById('fourcomment' + clicked_id);
       if (post_commentimg == '') {
           event.preventDefault();
           return false;
       } else {
           if (x.style.display === 'block' && y.style.display === 'none') {
               $.ajax({
                   type: 'POST',
                   url: base_url + "artistic/mulimg_commentthree",
                   //url: '<?php echo base_url() . "artistic/mulimg_commentthree" ?>',
                   data: 'post_image_id=' + clicked_id + '&comment=' + post_comment,
                   dataType: "json",
                   success: function (data) {
                       $('#post_comment' + clicked_id).html("");
                       //  $('.insertcomment' + clicked_id).html(data);
                       $('#' + 'insertcountimg' + clicked_id).html(data.count);
                       $('.insertcomment' + clicked_id).html(data.comment);
                   }
               });
   
           } else {
               $.ajax({
                   type: 'POST',
                   url: base_url + "artistic/mulimg_comment",
                   //url: '<?php echo base_url() . "artistic/mulimg_comment" ?>',
                   data: 'post_image_id=' + clicked_id + '&comment=' + post_comment,
                   // dataType: "json",
                   success: function (data) {
   
                       $('#post_comment' + clicked_id).html("");
   
                       $('#' + 'fourcomment' + clicked_id).html(data);
                   }
               });
           }
       }
   }

function entercomment(clicked_id) {
       $("#post_commentimg" + clicked_id).click(function () {
           $(this).prop("contentEditable", true);
           $(this).html("");
       });
       $("#post_commentimg" + clicked_id).keypress(function (event) { //alert(post_comment);
           if (event.which == 13 && event.shiftKey != 1) { //alert(post_comment);
               event.preventDefault();
               var sel = $("#post_commentimg" + clicked_id);
               var txt = sel.html();  
               $('#post_commentimg' + clicked_id).html("");  
               var x = document.getElementById('threecomment' + clicked_id);
               var y = document.getElementById('fourcomment' + clicked_id); 
               if (txt == '') { 
                   event.preventDefault();
                   return false;
               } else {
                   if (x.style.display === 'block' && y.style.display === 'none') {
                       $.ajax({
                           type: 'POST',
                           url: base_url + "artistic/mulimg_commentthree",
                          // url: '<?php echo base_url() . "artistic/mulimg_commentthree" ?>',
                           data: 'post_image_id=' + clicked_id + '&comment=' + txt,
                           dataType: "json",
                           success: function (data) {   
                               //  $('.insertcomment' + clicked_id).html(data);
                               $('#' + 'insertcountimg' + clicked_id).html(data.count);
                               $('.insertcomment' + clicked_id).html(data.comment);   
                           }
                       });   
                   } else {  
                      $.ajax({
                           type: 'POST',
                           url: base_url + "artistic/mulimg_comment",
                          // url: '<?php echo base_url() . "artistic/mulimg_comment" ?>',
                           data: 'post_id=' + clicked_id + '&comment=' + txt,
                           // dataType: "json",
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

  function comment_like(clicked_id)
   {
       $.ajax({
           type: 'POST',
          url: base_url + "artistic/mulimg_comment_like",
           //url: '<?php echo base_url() . "artistic/mulimg_comment_like" ?>',
           data: 'post_image_comment_id=' + clicked_id,
           success: function (data) { //alert(data);
               $('#' + 'likecomment' + clicked_id).html(data);
           }
       });
   }
    
   function comment_liketwo(clicked_id)
   {
       $.ajax({
           type: 'POST',
          url: base_url + "artistic/mulimg_comment_like1",
           //url: '<?php echo base_url() . "artistic/mulimg_comment_like1" ?>',
           data: 'post_image_comment_id=' + clicked_id,
           success: function (data) { //alert(data);
               $('#' + 'likecommentone' + clicked_id).html(data);  
           }
       });
   }

     function edit_comment(abc)
   { 
       var $field = $('#editcomment' + abc);
       var post_comment_edit = $('#editcomment' + abc).html();   
       if (post_comment_edit == '') {
           $('.biderror .mes').html("<div class='pop_content'>Are you sure want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_delete(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
           $('#bidmodal').modal('show'); 
       } else {
           $.ajax({
               type: 'POST',
               url: base_url + "artistic/mul_edit_com_insert",
               //url: '<?php echo base_url() . "artistic/mul_edit_com_insert" ?>',
               data: 'post_image_comment_id=' + abc + '&comment=' + post_comment_edit,
               success: function (data) { //alert('falguni');                 
                   document.getElementById('editcomment' + abc).style.display = 'none';
                   document.getElementById('showcomment' + abc).style.display = 'block';
                   document.getElementById('editsubmit' + abc).style.display = 'none';   
                   document.getElementById('editcommentbox' + abc).style.display = 'block';
                   document.getElementById('editcancle' + abc).style.display = 'none';                 
                   $('#' + 'showcomment' + abc).html(data);  
               }
           });
       }
   }

   function commentedit(abc) { 
       $("#editcomment" + abc).click(function () {
           $(this).prop("contentEditable", true);
           $(this).html("");
       });
       $("#editcomment" + abc).keypress(function (event) { 
           if (event.which == 13 && event.shiftKey != 1) { 
               event.preventDefault();
               var sel = $("#editcomment" + abc);
               var txt = sel.html();
               if (txt == '') {
                   $('.biderror .mes').html("<div class='pop_content'>Are you sure want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_delete(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                   $('#bidmodal').modal('show');  
               } else {  
                   $.ajax({
                       type: 'POST',
                       url: base_url + "artistic/mul_edit_com_insert",
                      // url: '<?php echo base_url() . "artistic/mul_edit_com_insert" ?>',
                       data: 'post_image_comment_id=' + abc + '&comment=' + txt,
                       // dataType: "json",
                       success: function (data) {  
                           $('#editcomment' + abc).html("");  
                           document.getElementById('editcomment' + abc).style.display = 'none';
                           document.getElementById('showcomment' + abc).style.display = 'block';
                           document.getElementById('editsubmit' + abc).style.display = 'none';  
                           document.getElementById('editcommentbox' + abc).style.display = 'block';
                           document.getElementById('editcancle' + abc).style.display = 'none';                         
                           $('#' + 'showcomment' + abc).html(data);
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

  function edit_commenttwo(abc)
   {        
       var $field = $('#editcommenttwo' + abc);  
       var post_comment_edit = $('#editcommenttwo' + abc).html();
       if (post_comment_edit == '') {
           $('.biderror .mes').html("<div class='pop_content'>Are you sure want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_deletetwo(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
           $('#bidmodal').modal('show');  
       } else {  
           $.ajax({
               type: 'POST',
               url: base_url + "artistic/mul_edit_com_insert",
               //url: '<?php echo base_url() . "artistic/mul_edit_com_insert" ?>',
               data: 'post_image_comment_id=' + abc + '&comment=' + post_comment_edit,
               success: function (data) { //alert('falguni');
                   document.getElementById('editcommenttwo' + abc).style.display = 'none';
                   document.getElementById('showcommenttwo' + abc).style.display = 'block';
                   document.getElementById('editsubmittwo' + abc).style.display = 'none';   
                   document.getElementById('editcommentboxtwo' + abc).style.display = 'block';
                   document.getElementById('editcancletwo' + abc).style.display = 'none';                 
                   $('#' + 'showcommenttwo' + abc).html(data);  
               }
           });
       }
   }

   function commentedittwo(abc)
   {
       $("#editcommenttwo" + abc).click(function () {
           $(this).prop("contentEditable", true);
           $(this).html("");
       });
       $('#editcommenttwo' + abc).keypress(function (event) {
           if (event.which == 13 && event.shiftKey != 1) {
               e.preventDefault();
               var sel = $("#editcomment" + abc);
               var txt = sel.html();
               $('#editcommenttwo' + abc).html("");  
               if (txt == '') {
                   $('.biderror .mes').html("<div class='pop_content'>Are you sure want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_deletetwo(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                   $('#bidmodal').modal('show'); 
               } else { 
                   $.ajax({
                       type: 'POST',
                       url: base_url + "artistic/mul_edit_com_insert",
                       //url: '<?php echo base_url() . "artistic/mul_edit_com_insert" ?>',
                       data: 'post_image_comment_id=' + abc + '&comment=' + val,
                       success: function (data) { //alert('falguni');   
                           document.getElementById('editcommenttwo' + abc).style.display = 'none';
                           document.getElementById('showcommenttwo' + abc).style.display = 'block';
                           document.getElementById('editsubmittwo' + abc).style.display = 'none';  
                           document.getElementById('editcommentboxtwo' + abc).style.display = 'block';
                           document.getElementById('editcancletwo' + abc).style.display = 'none';                       
                           $('#' + 'showcommenttwo' + abc).html(data);   
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
       document.getElementById('editcomment' + clicked_id).style.display = 'block';
       document.getElementById('showcomment' + clicked_id).style.display = 'none';
       document.getElementById('editsubmit' + clicked_id).style.display = 'block';
       document.getElementById('editcommentbox' + clicked_id).style.display = 'none';
       document.getElementById('editcancle' + clicked_id).style.display = 'block';
   }
   
   
   function comment_editcancle(clicked_id) {
       document.getElementById('editcommentbox' + clicked_id).style.display = 'block';
       document.getElementById('editcancle' + clicked_id).style.display = 'none';
       document.getElementById('editcomment' + clicked_id).style.display = 'none';
       document.getElementById('showcomment' + clicked_id).style.display = 'block';
       document.getElementById('editsubmit' + clicked_id).style.display = 'none';
   }
   
   function comment_editboxtwo(clicked_id) {  //alert('editsubmit2' + clicked_id);
       document.getElementById('editcommenttwo' + clicked_id).style.display = 'block';
       document.getElementById('showcommenttwo' + clicked_id).style.display = 'none';
       document.getElementById('editsubmittwo' + clicked_id).style.display = 'block';
       document.getElementById('editcommentboxtwo' + clicked_id).style.display = 'none';
       document.getElementById('editcancletwo' + clicked_id).style.display = 'block';
   }
   
   function comment_editcancletwo(clicked_id) {
       document.getElementById('editcommentboxtwo' + clicked_id).style.display = 'block';
       document.getElementById('editcancletwo' + clicked_id).style.display = 'none';
       document.getElementById('editcommenttwo' + clicked_id).style.display = 'none';
       document.getElementById('showcommenttwo' + clicked_id).style.display = 'block';
       document.getElementById('editsubmittwo' + clicked_id).style.display = 'none';
   }

     function comment_deletemodel(abc) {
       $('.biderror .mes').html("<div class='pop_content'>Are you sure want to Delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_delete(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
       $('#bidmodal').modal('show');
   }


    function comment_deletetwomodel(abc) {
       $('.biderror .mes').html("<div class='pop_content'>Are you sure want to Delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_deletetwo(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
       $('#bidmodal').modal('show');
   }

   function comment_delete(clicked_id)
   {
       var post_delete = document.getElementById("post_delete" + clicked_id);
       //alert('.insertcomment' + post_delete.value);
       $.ajax({
           type: 'POST',
           url: base_url + "artistic/mul_delete_comment",
          // url: '<?php echo base_url() . "artistic/mul_delete_comment" ?>',
           dataType: "json",
           data: 'post_image_comment_id=' + clicked_id + '&post_delete=' + post_delete.value,
           success: function (data) {
   
               $('#' + 'insertcountimg' + post_delete.value).html(data.count);
               $('.insertcomment' + post_delete.value).html(data.comment);
           }
       });
   }
   
   function comment_deletetwo(clicked_id)
   {  
       var post_deleteone = document.getElementById("post_deletetwo" + clicked_id); 
       $.ajax({
           type: 'POST',
           url: base_url + "artistic/mul_delete_commenttwo",
           //url: '<?php echo base_url() . "artistic/mul_delete_commenttwo" ?>',
           data: 'post_image_comment_id=' + clicked_id + '&post_delete=' + post_deleteone.value,
           success: function (data) {   
               $('#' + 'fourcomment' + post_deleteone.value).html(data);   
           }
       });
   }

   function updateprofilepopup(id) {
       $('#bidmodal-2').modal('show');
   }

   function post_likeimg(clicked_id)
   {
       $.ajax({
           type: 'POST',
           url: base_url + "artistic/like_postimg",
          // url: '<?php echo base_url() . "artistic/like_postimg" ?>',
           dataType: 'json',
           data: 'post_image_id=' + clicked_id,
           success: function (data) {
               $('.' + 'likepostimg' + clicked_id).html(data.like);
               $('.likeusernameimg' + clicked_id).html(data.likeuser);
   
               $('.likeduserlistimg' + clicked_id).hide();
               if (data.like_user_count == '0') {
                   document.getElementById('likeusernameimg' + clicked_id).style.display = "none";
               } else {
                   document.getElementById('likeusernameimg' + clicked_id).style.display = "block";
               }
               $('#likeusernameimg' + clicked_id).addClass('likeduserlistimg1');
           }
       });
   }
   
   
   function comment_likeimg(clicked_id)
   {
       $.ajax({
           type: 'POST',
           url: base_url + "artistic/like_commentimg1",
           //url: '<?php echo base_url() . "artistic/like_commentimg1" ?>',
           data: 'post_image_comment_id=' + clicked_id,
           success: function (data) {
               $('#' + 'likecommentimg' + clicked_id).html(data); 
           }
       });
   }
   function comment_likeimgtwo(clicked_id)
   {
       $.ajax({
           type: 'POST',
           url: base_url + "artistic/like_commentimg1",
           //url: '<?php echo base_url() . "artistic/like_commentimg1" ?>',
           data: 'post_image_comment_id=' + clicked_id,
           success: function (data) {
               $('#' + 'likecommentimg' + clicked_id).html(data); 
           }
       });
   }
   
   function comment_editboximg(clicked_id) {
       document.getElementById('editcommentimg' + clicked_id).style.display = 'inline-block';
       document.getElementById('showcommentimg' + clicked_id).style.display = 'none';
       document.getElementById('editsubmitimg' + clicked_id).style.display = 'inline-block';
       document.getElementById('editcommentboximg' + clicked_id).style.display = 'none';
       document.getElementById('editcancleimg' + clicked_id).style.display = 'block';
       $('.post-design-commnet-box').hide();
   }  
   function comment_editcancleimg(clicked_id) {
       document.getElementById('editcommentboximg' + clicked_id).style.display = 'block';
       document.getElementById('editcancleimg' + clicked_id).style.display = 'none';
       document.getElementById('editcommentimg' + clicked_id).style.display = 'none';
       document.getElementById('showcommentimg' + clicked_id).style.display = 'block';
       document.getElementById('editsubmitimg' + clicked_id).style.display = 'none';  
       $('.post-design-commnet-box').show();
   }
   
   function comment_editboximgtwo(clicked_id) {
       $('div[id^=editcommentimgtwo]').css('display', 'none');
       $('div[id^=showcommentimgtwo]').css('display', 'block');
       $('button[id^=editsubmitimgtwo]').css('display', 'none');
       $('div[id^=editcommentboximgtwo]').css('display', 'block');
       $('div[id^=editcancleimgtwo]').css('display', 'none');
       document.getElementById('editcommentimgtwo' + clicked_id).style.display = 'inline-block';
       document.getElementById('showcommentimgtwo' + clicked_id).style.display = 'none';
       document.getElementById('editsubmitimgtwo' + clicked_id).style.display = 'inline-block';
       document.getElementById('editcommentboximgtwo' + clicked_id).style.display = 'none';
       document.getElementById('editcancleimgtwo' + clicked_id).style.display = 'block';
       $('.post-design-commnet-box').hide();
   }
   
   
   function comment_editcancleimgtwo(clicked_id) {
       document.getElementById('editcommentboximgtwo' + clicked_id).style.display = 'block';
       document.getElementById('editcancleimgtwo' + clicked_id).style.display = 'none';
       document.getElementById('editcommentimgtwo' + clicked_id).style.display = 'none';
       document.getElementById('showcommentimgtwo' + clicked_id).style.display = 'block';
       document.getElementById('editsubmitimgtwo' + clicked_id).style.display = 'none';
       $('.post-design-commnet-box').show();
   }
   
   function comment_deleteimg(clicked_id) {
       $('.biderror .mes').html("<div class='pop_content'>Are you sure you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='comment_deletedimg(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
       $('#bidmodal').modal('show');
   }
   
   function comment_deletedimg(clicked_id)
   {
       var post_delete = document.getElementById("post_deleteimg");
       alert(post_delete.value);
       $.ajax({
           type: 'POST',
           url: base_url + "artistic/delete_commentimg",
           //url: '<?php echo base_url() . "artistic/delete_commentimg" ?>',
           data: 'post_image_comment_id=' + clicked_id + '&post_delete=' + post_delete.value,
           dataType: "json",
           success: function (data) {
               //alert('.' + 'insertcomment' + clicked_id);
               $('.' + 'insertcommentimg' + post_delete.value).html(data.comment);
            //   $('#' + 'insertcountimg' + post_delete.value).html(data.count);
                 $('.like_count_ext_img' + post_delete.value).html(data.commentcount);
               $('.post-design-commnet-box').show();
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
               if (txt == '') {
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
                       url: base_url + "artistic/insert_commentthreeimg",
                       //url: '<?php echo base_url() . "artistic/insert_commentthreeimg" ?>',
                       data: 'post_image_id=' + clicked_id + '&comment=' + txt,
                       dataType: "json",
                       success: function (data) {
                           $('textarea').each(function () {
                               $(this).val('');
                           });
                     //      $('#' + 'insertcountimg' + clicked_id).html(data.count);
                           $('.insertcommentimg' + clicked_id).html(data.comment);
                           $('.like_count_ext_img' + clicked_id).html(data.commentcount);   
                       }
                   });   
               } else {  
                   $.ajax({
                       type: 'POST',
                       url: base_url + "artistic/insert_commentimg",
                       //url: '<?php echo base_url() . "artistic/insert_commentimg" ?>',
                       data: 'post_image_id=' + clicked_id + '&comment=' + txt,
                       dataType: "json",
                       success: function (data) {
                           $('textarea').each(function () {
                               $(this).val('');
                           });
                         //  $('#' + 'insertcountimg' + clicked_id).html(data.count);
                           $('#' + 'fourcommentimg' + clicked_id).html(data.comment);
                           $('.like_count_ext_img' + clicked_id).html(data.commentcount);   
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
   
   function insert_commentimg(clicked_id)
   {
       $("#post_commentimg" + clicked_id).click(function () {
           $(this).prop("contentEditable", true);
           $(this).html("");
       });   
       var sel = $("#post_commentimg" + clicked_id);
       var txt = sel.html();
       if (txt == '') {
           return false;
       }  
       $('#post_commentimg' + clicked_id).html("");   
       var x = document.getElementById('threecommentimg' + clicked_id);
       var y = document.getElementById('fourcommentimg' + clicked_id);  
       if (x.style.display === 'block' && y.style.display === 'none') {
           $.ajax({
               type: 'POST',
               url: base_url + "artistic/insert_commentthreeimg",
               //url: '<?php echo base_url() . "artistic/insert_commentthreeimg" ?>',
               data: 'post_image_id=' + clicked_id + '&comment=' + txt,
               dataType: "json",
               success: function (data) {
                   $('textarea').each(function () {
                       $(this).val('');
                   });
               //    $('#' + 'insertcountimg' + clicked_id).html(data.count);
                   $('.insertcommentimg' + clicked_id).html(data.comment);
                   $('.like_count_ext_img' + clicked_id).html(data.commentcount);  
               }
           });  
       } else {   
           $.ajax({
               type: 'POST',
               url: base_url + "artistic/insert_commentimg",
               //url: '<?php echo base_url() . "artistic/insert_commentimg" ?>',
               data: 'post_image_id=' + clicked_id + '&comment=' + txt,
               dataType: "json",
               success: function (data) {
                   $('textarea').each(function () {
                       $(this).val('');
                   });
                 //  $('#' + 'insertcountimg' + clicked_id).html(data.count);
                   $('#' + 'fourcommentimg' + clicked_id).html(data.comment);
                   $('.like_count_ext_img' + clicked_id).html(data.commentcount);
               }
           });
       }
   }
   
   function edit_commentimg(abc)
   {
       $("#editcommentimg" + abc).click(function () {
           $(this).prop("contentEditable", true);
       });  
       var sel = $("#editcommentimg" + abc);
       var txt = sel.html();
       if (txt == '' || txt == '<br>') {
           $('.biderror .mes').html("<div class='pop_content'>Are you sure you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_delete(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
           $('#bidmodal').modal('show');
           return false;
       }
       $.ajax({
           type: 'POST',
           url: base_url + "artistic/edit_comment_insertimg",
           //url: '<?php echo base_url() . "artistic/edit_comment_insertimg" ?>',
           data: 'post_image_comment_id=' + abc + '&comment=' + txt,
           success: function (data) {
               document.getElementById('editcommentimg' + abc).style.display = 'none';
               document.getElementById('showcommentimg' + abc).style.display = 'block';
               document.getElementById('editsubmitimg' + abc).style.display = 'none';
               document.getElementById('editcommentboximg' + abc).style.display = 'block';
               document.getElementById('editcancleimg' + abc).style.display = 'none';
               $('#' + 'showcommentimg' + abc).html(data);
               $('.post-design-commnet-box').show();
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
               url: base_url + "artistic/fourcommentimg",
              // url: '<?php echo base_url() . "artistic/fourcommentimg" ?>',
               data: 'art_post_id=' + clicked_id,
               //alert(data);
               success: function (data) {
                   $('#' + 'fourcommentimg' + clicked_id).html(data);
               }
           });
       }
   }
   
   function comment_deleteimgtwo(clicked_id)
   {
       $('.biderror .mes').html("<div class='pop_content'>Are you sure you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='comment_deletedimgtwo(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
       $('#bidmodal').modal('show');
   }
   
   
   function comment_deletedimgtwo(clicked_id)
   {
       var post_delete1 = document.getElementById("post_deleteimgtwo");
       $.ajax({
           type: 'POST',
           url: base_url + "artistic/delete_commenttwoimg",
          // url: '<?php echo base_url() . "artistic/delete_commenttwoimg" ?>',
           data: 'post_image_comment_id=' + clicked_id + '&post_delete=' + post_delete1.value,
           dataType: "json",
           success: function (data) {
   
               $('.' + 'insertcommentimgtwo' + post_delete1.value).html(data.comment);
              // $('#' + 'insertcountimg' + post_delete1.value).html(data.count);
                $('.like_count_ext_img' + post_delete1.value).html(data.commentcount);
               $('.post-design-commnet-box').show();
           }
       });
   }
   
   function edit_commentimgtwo(abc)
   {
       $("#editcommentimgtwo" + abc).click(function () {
           $(this).prop("contentEditable", true);
       });  
       var sel = $("#editcommentimgtwo" + abc);
       var txt = sel.html();
       if (txt == '' || txt == '<br>') {
           $('.biderror .mes').html("<div class='pop_content'>Are you sure you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_deletetwo(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
           $('#bidmodal').modal('show');
           return false;
       }
       $.ajax({
           type: 'POST',
           url: base_url + "artistic/edit_comment_insertimg",
          // url: '<?php echo base_url() . "artistic/edit_comment_insertimg" ?>',
           data: 'post_image_comment_id=' + abc + '&comment=' + txt,
           success: function (data) {
               document.getElementById('editcommentimgtwo' + abc).style.display = 'none';
               document.getElementById('showcommentimgtwo' + abc).style.display = 'block';
               document.getElementById('editsubmitimgtwo' + abc).style.display = 'none';
               document.getElementById('editcommentboximgtwo' + abc).style.display = 'block';
               document.getElementById('editcancleimgtwo' + abc).style.display = 'none';
               $('#' + 'showcommentimgtwo' + abc).html(data);
               $('.post-design-commnet-box').show();
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
           url: base_url + "artistic/likeuserlistimg",
           //url: '<?php echo base_url() . "artistic/likeuserlistimg" ?>',
           data: 'post_id=' + post_id,
           dataType: "html",
           success: function (data) {
               var html_data = data;
               $('#likeusermodal .mes').html(html_data);
               $('#likeusermodal').modal('show');
           }
       });  
   }
   
   
   function commenteditimg(abc)
   {
       $("#editcommentimg" + abc).click(function () {
           $(this).prop("contentEditable", true);
       });
       $('#editcommentimg' + abc).keypress(function (event) {
           if (event.which == 13 && event.shiftKey != 1) {
               event.preventDefault();
               var sel = $("#editcommentimg" + abc);
               var txt = sel.html();
               if (txt == '' || txt == '<br>') {
                   $('.biderror .mes').html("<div class='pop_content'>Are you sure you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_deleteimg(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
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
                   url: base_url + "artistic/edit_comment_insertimg",
                   //url: '<?php echo base_url() . "artistic/edit_comment_insertimg" ?>',
                   data: 'post_image_comment_id=' + abc + '&comment=' + txt,
                   success: function (data) {
                       document.getElementById('editcommentimg' + abc).style.display = 'none';
                       document.getElementById('showcommentimg' + abc).style.display = 'block';
                       document.getElementById('editsubmitimg' + abc).style.display = 'none';
                       document.getElementById('editcommentboximg' + abc).style.display = 'block';
                       document.getElementById('editcancleimg' + abc).style.display = 'none';
                       $('#' + 'showcommentimg' + abc).html(data);
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
   
   function commenteditimgtwo(abc)
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
               if (txt == '' || txt == '<br>') {
                   $('.biderror .mes').html("<div class='pop_content'>Are you sure you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_deleteimgtwo(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
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
                   url: base_url + "artistic/edit_comment_insertimg",
                   //url: '<?php echo base_url() . "artistic/edit_comment_insertimg" ?>',
                   data: 'post_image_comment_id=' + abc + '&comment=' + txt,
                   success: function (data) {
                       document.getElementById('editcommentimgtwo' + abc).style.display = 'none';
                       document.getElementById('showcommentimgtwo' + abc).style.display = 'block';
                       document.getElementById('editsubmitimgtwo' + abc).style.display = 'none';
   
                       document.getElementById('editcommentboximgtwo' + abc).style.display = 'block';
                       document.getElementById('editcancleimgtwo' + abc).style.display = 'none';
   
                       $('#' + 'showcommentimgtwo' + abc).html(data);
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


   function followuser(clicked_id)
   {   
       $.ajax({
           type: 'POST',
           url: base_url + "artistic/follow_two",
           //url: '<?php echo base_url() . "artistic/follow_two" ?>',
           data: 'follow_to=' + clicked_id,
           success: function (data) {
               $('.' + 'fruser' + clicked_id).html(data);
           }
       });
   }

   function unfollowuser(clicked_id)
   {
       $.ajax({
           type: 'POST',
           url: base_url + "artistic/unfollow_two",
           //url: '<?php echo base_url() . "artistic/unfollow_two" ?>',
           data: 'follow_to=' + clicked_id,
           success: function (data) { 
               $('.' + 'fruser' + clicked_id).html(data);  
           }
       });
   }

    $(document).ready(function () {
       $("html,body").animate({scrollTop: 350}, 100); //100ms for example
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

    $(document).ready(function() {
     //alert("The paragraph was clicked.");
     $("html,body").animate({scrollTop: 500}, 100); //100ms for example
     });


     function picpopup() {
   
          $('.biderror .mes').html("<div class='pop_content'>Only Image Type Supported");
          $('#bidmodal').modal('show');
                      }
  
    $( document ).on( 'keydown', function ( e ) {
   if ( e.keyCode === 27 ) {
       //$( "#bidmodal" ).hide();
       $('#bidmodal-2').modal('hide');
   }
   });  

  $(document).ready(function(){    
       $('html,body').animate({scrollTop:265}, 100);
   });
