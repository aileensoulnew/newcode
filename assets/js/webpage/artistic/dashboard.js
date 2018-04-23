 // for cursor pointer starts script
$(document).ready(function () {
    var input = $(".editable_text");
    var len = input.val().length;
    input[0].focus();
    input[0].setSelectionRange(len, len);
});
 
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
                if (my_form.my_text.value.length > maxLen) {
                    // Alert message if maximum limit is reached. 
                    // If required Alert can be removed. 
                    var msg = "You have reached your maximum limit of characters allowed";
                    $("#test-upload-product").prop("readonly", true);
                    //    alert(msg);
                   // my_form.text_num.value = maxLen - my_form.my_text.value.length;
                    $('.biderror .mes').html("<div class='pop_content'>" + msg + "</div>");
                    $('#bidmodal-limit').modal('show');
                    // Reached the Maximum length so trim the textarea
                    my_form.my_text.value = my_form.my_text.value.substring(0, maxLen);
                } else {
                    // Maximum length not reached so update the value of my_text counter
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
           document.getElementById("text_num_" + abc).value = text_num;
       }
   }
// photos video audion pdf fatch using ajax

 $(document).ready(function () {
            artistic_dashboard_post(slug);
                GetArtPhotos();
                GetArtVideos();
                GetArtAudios();
                GetArtPdf();


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
                    artistic_dashboard_post(slug, pagenum);
                }
            }
        }
    });
});
         



    function GetArtPhotos() {
                
                $.ajax({
                    type: 'POST',
                    url: base_url + "artistic/artistic_photos",
                    //url: '<?php echo base_url() . "artistic/artistic_photos" ?>',
                    data: 'art_id=' + slug,
                    beforeSend: function () {
                        //$(".art_photos").html('<p style="text-align:center;"><img src = "<?php echo base_url('images/loading.gif?ver='.time()) ?>" class = "loader" /></p>');
                        $(".art_photos").html('<p style="text-align:center;"><img src = "'+ base_url + 'images/loading.gif" class = "loader" /></p>');
                    },
                    success: function (data) {
                        $('.loader').remove();
                        $('.art_photos').html(data);

                    }
                });

            }

            function GetArtVideos() {
                

                $.ajax({
                    type: 'POST',
                    url: base_url + "artistic/artistic_videos",
                    //url: '<?php echo base_url() . "artistic/artistic_videos" ?>',
                    data: 'art_id=' + slug,
                    beforeSend: function () {
                        $(".art_videos").html('<p style="text-align:center;"><img src = "'+ base_url + 'images/loading.gif" class = "loader" /></p>');
                    },
                    success: function (data) {
                        $('.loader').remove();
                        $('.art_videos').html(data);
                    }
                });

            }

            function GetArtAudios() {
                
                $.ajax({
                    type: 'POST',
                    url: base_url + "artistic/artistic_audio",
                    //url: '<?php echo base_url() . "artistic/artistic_audio" ?>',
                    data: 'art_id=' + slug,
                    beforeSend: function () {
                        $(".art_audios").html('<p style="text-align:center;"><img src = "'+ base_url + 'images/loading.gif" class = "loader" /></p>');
                    },
                    success: function (data) {
                        $('.loader').remove();
                        $('.art_audios').html(data);

                    }
                });

            }

            function GetArtPdf() {
                
                $.ajax({
                    type: 'POST',
                    url: base_url + "artistic/artistic_pdf",
                    //url: '<?php echo base_url() . "artistic/artistic_pdf" ?>',
                    data: 'art_id=' + slug,
                    beforeSend: function () {
                        $(".art_pdf").html('<p style="text-align:center;"><img src = "'+ base_url + 'images/loading.gif" class = "loader" /></p>');
                    },
                    success: function (data) {
                        $('.loader').remove();
                        $('.art_pdf').html(data);

                    }
                });

            }

// Get the modal


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
    document.getElementById("myModal3").style.display = "none";
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
            document.getElementById('test-upload-product').value = '';
           document.getElementById('test-upload-des').value = '';
           document.getElementById('file-1').value = '';


            var data = $('.post-design-box').length;
            //alert(data);

          if(data == 0){ 
           
            document.getElementById("no_post_avl").style.display = "none";
           }


            $("input[name='text_num']").val(50);
            $(".file-preview-frame").hide();
//            $('#progress_div').fadeOut('5000').remove();
            document.getElementById("progress_div").style.display = "none";
            GetArtPhotos();
                GetArtVideos();
                GetArtAudios();
                GetArtPdf();
        

            //$('.job-contact-frnd div:first').remove();
            $(".art-all-post").prepend(response.responseText);
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
    $(".upload-image-form").ajaxForm(options);
    return false;
    });

$('#file-1').on('click', function(e){

var a = document.getElementById('test-upload-product').value;
var b = document.getElementById('test-upload-des').value;
    document.getElementById("artpostform").reset();
    document.getElementById('test-upload-product').value = a;
    document.getElementById('test-upload-des').value = b;
    });





   
            var modal = document.getElementById('myModal3');

            // Get the button that opens the modal
            var btn = document.getElementById("myBtn3");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close3")[0];

            // When the user clicks the button, open the modal 
            btn.onclick = function () { //alert("jii");
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


            
             $(document).ready(function () {
                $('.video').mediaelementplayer({
                    alwaysShowControls: false,
                    videoVolume: 'horizontal',
                    features: ['playpause', 'progress', 'volume', 'fullscreen']
                });
            });

function check_perticular(input) {
                        var testData = input.replace(/\s/g, '');
                        var regex = /^(<br>)*$/;
                        var isValid = regex.test(testData);
                        return isValid;
                    }


$( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) {
        //$( "#bidmodal" ).hide();

if(document.getElementById('bidmodal-limit').style.display === "block"){ 
        $('#bidmodal-limit').modal('hide');
    $("#test-upload-product").prop("readonly", false);
        
        $('#myModal3').model('show');
 }else if(document.getElementById('myModal3').style.display === "block"){ 
        document.getElementById('myModal3').style.display === "none";

 }

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
            document.getElementById('myModal3').style.display = "none";
            }
    });

$( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) {
        //$( "#bidmodal" ).hide();
        $('#likeusermodal').modal('hide');
    }
});

$( document ).on( 'keydown', function ( e ) {
       if ( e.keyCode === 27 ) {
           //$( "#bidmodal" ).hide();
           $('#postedit').modal('hide');
         $('.my_text').attr('readonly', false);
         $('.editable_text').attr('contentEditable', true);
         $('.fr').attr('disabled', false);

       }
   });  

   $('#common-limit').on('click', function () {
    $('#myModal').modal('show');
    $("#test-upload-product").prop("readonly", false);
    });


$('#postedit').on('click', function () {
   // $('#myModal').modal('show');
    $(".my_text").prop("readonly", false);
     $('.editable_text').attr('contentEditable', true);
         $('.fr').attr('disabled', false);
    });
  

$(function () {
                var showTotalChar = 200, showChar = "More", hideChar = "";
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
                allowedFileExtensions: ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg','mp4','mp3','pdf','jpeg']
            });
            $('#file-es').fileinput({
                language: 'es',
                uploadUrl: '#',
                allowedFileExtensions: ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg', 'mp4','mp3','pdf','jpeg']
            });
            $("#file-0").fileinput({
                'allowedFileExtensions': ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg','mp4','mp3','pdf','jpeg']
            });
            $("#file-1").fileinput({
                uploadUrl: '#', // you must set a valid URL here else you will get an error
                allowedFileExtensions: ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg','mp4','mp3','pdf','jpeg'],
                overwriteInitial: false,
                maxFileSize: 1000000,
                maxFilesNum: 10,
                //allowedFileTypes: ['image', 'video', 'flash'],
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
                    {caption: "transport-1.jpg", size: 329892, width: "120px", url: "{$url}", key: 1},
                    {caption: "transport-2.jpg", size: 872378, width: "120px", url: "{$url}", key: 2},
                    {caption: "transport-3.jpg", size: 632762, width: "120px", url: "{$url}", key: 3},
                ],
            });
            $("#file-4").fileinput({
                uploadExtraData: {kvId: '10'}
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
                $("#file-4").fileinput('refresh', {previewClass: 'bg-info'});
            });

            $(document).ready(function () {
                $("#test-upload").fileinput({
                    'showPreview': false,
                    'allowedFileExtensions': ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg','mp4','mp3','pdf','jpeg'],
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


                    // $.ajax({

                    //     url: base_url + "artistic/image",
                    //    // url: "<?php echo base_url(); ?>artistic/image",
                    //     type: "POST",
                    //     data: fd,
                    //     processData: false,
                    //     contentType: false,
                    //     success: function (response) {


                    //     }
                    // });
               




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

 

// validation for designation script

     $(document).ready(function () {

                $("#artdesignation").validate({

                    rules: {

                        designation: {

                            required: true,

                        },

                    },

                    messages: {

                        designation: {

                            required: "Designation Is Required.",

                        },

                    },

                });
            });

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

// comment like script start

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

// delete comment script start

 function comment_delete(clicked_id) {
                $('.biderror .mes').html("<div class='pop_content'>Are you sure you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='comment_deleted(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
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

                        if(data.notavlpost == 'notavl'){
               $('.biderror .mes').html("<div class='pop_content'>The post that you were deleting on has been removed by its owner and this content is no longer available.</div>");
       $('#bidmodal').modal('show');
            }else{

                     $('.' + 'insertcomment' + post_delete.value).html(data.comment);
                     $('.like_count_ext' + post_delete.value).html(data.commentcount);
                     $('.post-design-commnet-box').show();
                    }
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

                        if(data.notavlpost == 'notavl'){
               $('.biderror .mes').html("<div class='pop_content'>The post that you were deleting on has been removed by its owner and this content is no longer available.</div>");
       $('#bidmodal').modal('show');
            }else{

                      $('.' + 'insertcommenttwo' + post_delete1.value).html(data.comment);
                      $('.like_count_ext' + post_delete1.value).html(data.commentcount);
                      $('.post-design-commnet-box').show();
                    }
                  }
                });
            }


// comment insert using ajax

function insert_comment(clicked_id)
            {
                // start khyati code
                var $field = $('#post_comment' + clicked_id);
                var post_comment = $('#post_comment' + clicked_id).html();

                // var post_comment = post_comment.html();
                post_comment = post_comment.replace(/&nbsp;/gi, " ");
                post_comment = post_comment.replace(/<br>$/, '');
                post_comment = post_comment.replace(/div>/gi, 'p>');
                post_comment = post_comment.replace(/^(\s*<br( \/)?>)*|(<br( \/)?>\s*)*$/gm, '');


               // alert(post_comment);
               // return false;

                if (post_comment == '' || post_comment == '<br>' || check_perticular(post_comment) == true) {
                    return false;
                }
                if (/^\s+$/gi.test(post_comment))
                {
                    return false;
                }

                $('#post_comment' + clicked_id).html("");

                var x = document.getElementById('threecomment' + clicked_id);
                var y = document.getElementById('fourcomment' + clicked_id);

                if (post_comment == '') {
                    event.preventDefault();
                    return false;
                } else {
                    if (x.style.display === 'block' && y.style.display === 'none') {
                        $.ajax({
                            type: 'POST',
                            url: base_url + "artistic/insert_commentthree",
                            //url: '<?php echo base_url() . "artistic/insert_commentthree" ?>',
                            data: 'post_id=' + clicked_id + '&comment=' + post_comment,
                            dataType: "json",
                            success: function (data) {
                              if(data.notavlpost == 'notavl'){
               $('.biderror .mes').html("<div class='pop_content'>The post that you were deleting on has been removed by its owner and this content is no longer available.</div>");
       $('#bidmodal').modal('show');
            }else{
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
                            data: 'post_id=' + clicked_id + '&comment=' + post_comment,
                            dataType: "json",
                            success: function (data) {
                                 if(data.notavlpost == 'notavl'){
               $('.biderror .mes').html("<div class='pop_content'>The post that you were deleting on has been removed by its owner and this content is no longer available.</div>");
       $('#bidmodal').modal('show');
            }else{
                                $('#' + 'fourcomment' + clicked_id).html(data.comment);
                                $('.like_count_ext' + clicked_id).html(data.commentcount);
                            }
                          }
                        });

                    }
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



                        //     txt = txt.replace(/^\s+|\s+$/g, "")

                        if (txt == '' || txt == '<br>' || check_perticular(txt) == true) {
                            return false;
                        }
                        if (/^\s+$/gi.test(txt))
                        {
                            return false;
                        }

                        //                if (txt == '') {
                        //                    return false;
                        //                }

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
                                success: function (data) {

                                     if(data.notavlpost == 'notavl'){
                      $('.biderror .mes').html("<div class='pop_content'>The post that you were deleting on has been removed by its owner and this content is no longer available.</div>");
                       $('#bidmodal').modal('show');
                      }else{
                                    $('textarea').each(function () {
                                        $(this).val('');
                                    });
                                 //   $('#' + 'insertcount' + clicked_id).html(data.count);
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
                                    //$('#' + 'insertcount' + clicked_id).html(data.count);
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


 // edit comment script start
 
             function comment_editbox(clicked_id) {

                document.getElementById('showcomment' + clicked_id).style.display = 'none';
               // document.getElementById('editbox' + clicked_id).style.display = 'none';
                document.getElementById('editcommentbox' + clicked_id).style.display = 'none';
                document.getElementById('editcomment' + clicked_id).style.display = 'inline-block';
                document.getElementById('editcancle' + clicked_id).style.display = 'inline-block';
               document.getElementById('editsubmit' + clicked_id).style.display = 'inline-block';

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
                document.getElementById('editcancletwo' + clicked_id).style.display = 'inline-block';
                $('.post-design-commnet-box').hide();
                $('.hidebottombordertwo').find('.all-comment-comment-box:last').css('border-bottom','0px');
                $('.hidebottomborder').find('.all-comment-comment-box:last').css('border-bottom','0px');
            }


            function comment_editcancletwo(clicked_id) {

                document.getElementById('editcommentboxtwo' + clicked_id).style.display = 'block';
                document.getElementById('editcancletwo' + clicked_id).style.display = 'none';

                document.getElementById('editcommenttwo' + clicked_id).style.display = 'none';
                document.getElementById('showcommenttwo' + clicked_id).style.display = 'block';
                document.getElementById('editsubmittwo' + clicked_id).style.display = 'none';
                $('.post-design-commnet-box').show();
                $('.hidebottombordertwo').find('.all-comment-comment-box:last').css('border-bottom','1px solid #d9d9d9');
                $('.hidebottomborder').find('.all-comment-comment-box:last').css('border-bottom','1px solid #d9d9d9');
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

                txt = txt.replace(/div>/gi, 'p>');
                txt = txt.replace(/^(\s*<br( \/)?>)*|(<br( \/)?>\s*)*$/gm, '');



                if (txt == '' || txt == '<br>' || check_perticular(txt) == true) {
                    $('.biderror .mes').html("<div class='pop_content'>Are you sure you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_delete(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                    $('#bidmodal').modal('show');
                    return false;
                }

                if (/^\s+$/gi.test(txt)) {
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
                        $('.hidebottomborder').find('.all-comment-comment-box:last').css('border-bottom','1px solid #d9d9d9');
                       } 
                    }
                });
                $(".scroll").click(function (event) {
                    event.preventDefault();
                    $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
                });
            }

function edit_comment2(abc)
            {

                var post_comment_edit = document.getElementById("editcomment2" + abc);

                $.ajax({
                    type: 'POST',
                    url: base_url + "artistic/edit_comment_insert",
                    //url: '<?php echo base_url() . "artistic/edit_comment_insert" ?>',
                    data: 'post_id=' + abc + '&comment=' + encodeURIComponent(post_comment_edit.value),
                    success: function (data) {


                        document.getElementById('editcomment2' + abc).style.display = 'none';
                        document.getElementById('showcomment2' + abc).style.display = 'block';
                        document.getElementById('editsubmit2' + abc).style.display = 'none';

                        $('#' + 'showcomment' + abc).html(data);

                    }
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
                            $('.biderror .mes').html("<div class='pop_content'>Are you sure you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_delete(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
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

                                document.getElementById('editcomment' + abc).style.display = 'none';
                                document.getElementById('showcomment' + abc).style.display = 'block';
                                document.getElementById('editsubmit' + abc).style.display = 'none';
                                document.getElementById('editcommentbox' + abc).style.display = 'block';
                                document.getElementById('editcancle' + abc).style.display = 'none';
                                $('#' + 'showcomment' + abc).html(data);
                                $('.post-design-commnet-box').show();
                                $('.hidebottomborder').find('.all-comment-comment-box:last').css('border-bottom','1px solid #d9d9d9');
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
                 txt = txt.replace(/div>/gi, 'p>');
                txt = txt.replace(/^(\s*<br( \/)?>)*|(<br( \/)?>\s*)*$/gm, '');



                if (txt == '' || txt == '<br>' || check_perticular(txt) == true) {
                    $('.biderror .mes').html("<div class='pop_content'>Are you sure you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_deletetwo(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
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
                            $('.biderror .mes').html("<div class='pop_content'>Are you sure you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='comment_deletetwo(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
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
                                $('.hidebottomborder').find('.all-comment-comment-box:last').css('border-bottom','1px solid #d9d9d9');
                                $('.hidebottombordertwo').find('.all-comment-comment-box:last').css('border-bottom','1px solid #d9d9d9');
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

 // all comment show script start

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

 $(document).ready(function () {
                $('.blocks').jMosaic({items_type: "li", margin: 0});
                $('.pictures').jMosaic({min_row_height: 150, margin: 3, is_first_big: true});
            });

            //If this image without attribute WIDTH or HEIGH, you can use $(window).load
            $(window).load(function () {
                //$('.pictures').jMosaic({min_row_height: 150, margin: 3, is_first_big: true});
            });

            //You can update on $(window).resize
            $(window).resize(function () {
                //$('.pictures').jMosaic({min_row_height: 150, margin: 3, is_first_big: true});
                //$('.blocks').jMosaic({items_type: "li", margin: 0});
            });

function openModal() {
                document.getElementById('myModal1').style.display = "block";
            }

            function closeModal() {
                document.getElementById('myModal1').style.display = "none";
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

// delete post script start

 function deleteownpostmodel(abc) {

                $('div[id^=myDropdown]').hide().removeClass('show');
                $('.biderror .mes').html("<div class='pop_content'>Are you sure want to Delete Your post?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='remove_ownpost(" + abc + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                $('#bidmodal').modal('show');
            }

function remove_ownpost(abc)
            {

                $.ajax({
                    type: 'POST',
                    url: base_url + "artistic/art_deletepost",
                    //url: '<?php echo base_url() . "artistic/art_deletepost" ?>',
                    dataType: 'json',
                    data: 'art_post_id=' + abc,
                    //alert(data);
                    success: function (data) { //alert('#' + 'removepost' + abc);

                    if(data.notavlpost == 'notavl'){
               $('.biderror .mes').html("<div class='pop_content'>The post that you were deleting on has been removed by its owner and this content is no longer available.</div>");
       $('#bidmodal').modal('show');
            }else{
                        $('#' + 'removepost' + abc).remove();
                        GetArtPhotos();
                GetArtVideos();
                GetArtAudios();
                GetArtPdf();
                        if(data.notcount == 0){ 
                            $('.' + 'nofoundpost').html(data.notfound);
                            $('.' + 'not_available').remove();
                            $('.' + 'image_profile').remove();

                            //$('.' + 'dataconpdf').html(data.notpdf);
                            //$('.' + 'dataconvideo').html(data.notvideo);
                            //$('.' + 'dataconaudio').html(data.notaudio);
                            //$('.' + 'dataconphoto').html(data.notphoto);
                        }
                    }
                  }
                });

            }

function del_particular_userpost(abc)
            {

                $.ajax({
                    type: 'POST',
                    url: base_url + "artistic/del_particular_userpost",
                    //url: '<?php echo base_url() . "artistic/del_particular_userpost" ?>',
                    data: 'art_post_id=' + abc,
                    //alert(data);
                    success: function (data) {

                        $('#' + 'removepost' + abc).html(data);


                    }
                });

            }
// edit post staet script
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
       // var editpostdetails = document.getElementById("editpostdesc" + abc);
       // start khyati code
       var $field = $('#editpostdesc' + abc);
       //var data = $field.val();
       var editpostdetails = $('#editpostdesc' + abc).html();

       editpostdetails = editpostdetails.replace(/&gt;/gi,">");
       
       editpostdetails = editpostdetails.replace(/&nbsp;/gi, " ");
       editpostdetails = editpostdetails.replace(/div/gi, "p");
       //editpostdetails = editpostdetails.replace(/"<div>"/gi, "</p>");
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
                   $('#' + 'postname' + abc).html(data.postname);

                 }
               }
           });
       }
   
   }

// save post script start

function save_post(abc)
            {
                $.ajax({
                    type: 'POST',
                    url: base_url + "artistic/artistic_save",
                    //url: '<?php echo base_url() . "artistic/artistic_save" ?>',
                    data: 'art_post_id=' + abc,
                    success: function (data) {
                        $('.' + 'savedpost' + abc).html(data);
                    }
                });

            }




function remove_post(abc)
            {

                $.ajax({
                    type: 'POST',
                    url: base_url + "artistic/art_deletepost",
                   // url: '<?php echo base_url() . "artistic/art_deletepost" ?>',
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
                    data: 'art_post_id=' + abc,
                    //alert(data);
                    success: function (data) {

                        $('#' + 'removepost' + abc).html(data);


                    }
                });

            }

 function followuser(clicked_id)
            { //alert(clicked_id);

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

function updateprofilepopup(id) {
                $('#bidmodal-2').modal('show');
            }

// upload post time validation script start

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
               var allowedExtensions = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg'];
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
                   } else if(fileInput.length > 10){


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
   
               }

               else if (foundPresentvideo == true)
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
               }

               else if (foundPresentaudio == true)
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
                else if (foundPresentpdf == true)
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
           }
       } 
   }

   function h(e) {
                $(e).css({
                    'height': '29px',
                    'overflow-y': 'hidden'
                }).height(e.scrollHeight);
            }
            $('.textarea').each(function () {
                h(this);
            }).on('input', function () {
                h(this);
});

// like suer list script start
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

 

   




 $(document).ready(function () {
                $('.video').mediaelementplayer({
                    alwaysShowControls: false,
                    videoVolume: 'horizontal',
                    features: ['playpause', 'progress', 'volume', 'fullscreen']
                });
            });

 var _onPaste_StripFormatting_IEPaste = false;

            function OnPaste_StripFormatting(elem, e) {

                if (e.originalEvent && e.originalEvent.clipboardData && e.originalEvent.clipboardData.getData) {
                   // alert(1);
                    e.preventDefault();
                    var text = e.originalEvent.clipboardData.getData('text/plain');
                    window.document.execCommand('insertText', false, text);
                } else if (e.clipboardData && e.clipboardData.getData) { 
                    //alert(2);
                   
                    e.preventDefault();
                    var text = e.clipboardData.getData('text/plain');
                    window.document.execCommand('insertText', false, text);
                } else if (window.clipboardData && window.clipboardData.getData) {

                    //alert(3);

                    // Stop stack overflow
                    if (!_onPaste_StripFormatting_IEPaste) {
                        _onPaste_StripFormatting_IEPaste = true;
                        e.preventDefault();
                        window.document.execCommand('ms-pasteTextOnly', false);
                    }
                    _onPaste_StripFormatting_IEPaste = false;
                }

            }

function picpopup() {
         $('#profileimage .mes').html("<div class='pop_content'>Only Image Type Supported");
            $('#profileimage').modal('show');
}

 

jQuery(document).mouseup(function (e) {
            
             var container1 = $("#myModal3");
            
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


 $('#post').on('click', function(){
        $('#myModal3').modal('show');
    });

  $('#common-limit').on('click', function(){
        $('#myModal3').modal('show');
    });



 $( document ).on( 'keydown', function (e) {
    if ( e.keyCode === 27 ) {
if(document.getElementById('profileimage').style.display === "block"){
 $('#profileimage').hide();
          //alert("hi");
document.getElementById('bidmodal-2').style.display = "block";
$('.modal-post').hide();
           }
           else
           {
            //alert("hi1");
                $('#bidmodal-2').modal('hide');
                $('.modal-post').hide();
           }          
    }
}); 


  function seemorediv(abc) { //alert("hii");
         
                   document.getElementById('seemore' + abc).style.display = 'block';
                   document.getElementById('lessmore' + abc).style.display = 'none';
                
   }


  
  


 // post upload using ajaax start

    
$(document).ready(function(){  
       $('html,body').animate({scrollTop:246}, 500);
   });



var isProcessing = false;
function artistic_dashboard_post(slug, pagenum) { //alert("hii"); alert(slug);
    if (isProcessing) {
        /*
         *This won't go past this condition while
         *isProcessing is true.
         *You could even display a message.
         **/
       // return;
    }
    isProcessing = true;
    $.ajax({
        type: 'POST',
        url: base_url + "artistic/artistic_dashboard_post/"+ slug + "?page=" + pagenum,
        //url: base_url + "artistic/artistic_dashboard_post/" + slug + "?page=" + pagenum,
       // data: 'slug=' + slug,
       data: {total_record: $("#total_record").val()},
        dataType: "html",
        beforeSend: function () {
            //if (pagenum == 'undefined') {
                //  $(".business-all-post").prepend('<p style="text-align:center;"><img class="loader" src="' + base_url + 'images/loading.gif"/></p>');
            //} else {
                $('#loader').show();
            //}
        },
        complete: function () {
            $('#loader').hide();
        },
        success: function (data) {
            $('.loader').remove();
            $('.art-all-post').append(data);

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


