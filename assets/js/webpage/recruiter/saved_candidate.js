
        

    function removepopup(id) {
     
        $('.biderror .mes').html("<div class='pop_content'>Do you want to remove this candidate?<div class='model_ok_cancel'><a class='okbtn' id=" + id + " onClick='remove_user(" + id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
        $('#bidmodal').modal('show');
    }
    function updateprofilepopup(id) {
        $('#bidmodal-2').modal('show');
    }

// Get the modal
    var modal = document.getElementById('myModal');

// Get the button that opens the modal
    var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
//    btn.onclick = function () {
//        modal.style.display = "block";
//    }

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

    function myFunction() {
        document.getElementById("upload-demo").style.visibility = "hidden";
        document.getElementById("upload-demo-i").style.visibility = "hidden";
        document.getElementById('message1').style.display = "block";

        //setTimeout(function () { location.reload(1); }, 5000);

    }

   function showDiv() {
        //alert(hi);
        document.getElementById('row1').style.display = "block";
        document.getElementById('row2').style.display = "none";
        $(".cr-image").attr("src","");
         $("#upload").val('');
    }

    $uploadCrop = $('#upload-demo').croppie({
        enableExif: true,
        viewport: {
            width: 1250,
            height: 350,
            type: 'square'
        },
        boundary: {
            width: 1250,
            height: 350
        }
    });



    $('.upload-result').on('click', function (ev) {
        $uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {

            $.ajax({
                url: base_url + "recruiter/ajaxpro",
                type: "POST",
                data: {"image": resp},
                success: function (data) {

                  if (data) {
                    $("#row2").html(data);
                    document.getElementById('row2').style.display = "block";
                    document.getElementById('row1').style.display = "none";
                    document.getElementById('message1').style.display = "none";
                    document.getElementById("upload-demo").style.visibility = "visible";
                    document.getElementById("upload-demo-i").style.visibility = "visible";

                }
                }
            });

        });
    });

    $('.cancel-result').on('click', function (ev) {

        document.getElementById('row2').style.display = "block";
        document.getElementById('row1').style.display = "none";
        document.getElementById('message1').style.display = "none";
        $(".cr-image").attr("src","");

    });

//aarati code start
    $('#upload').on('change', function () {
           //alert("hello");


        var reader = new FileReader();
        reader.onload = function (e) {
            $uploadCrop.croppie('bind', {
                url: e.target.result
            }).then(function () {
                console.log('jQuery bind complete');
            });

        }
        reader.readAsDataURL(this.files[0]);



    });

    $('#upload').on('change', function () {

        var fd = new FormData();
        fd.append("image", $("#upload")[0].files[0]);

        files = this.files;
        size = files[0].size;
 // pallavi code start for file type support
if (!files[0].name.match(/.(jpg|jpeg|png|gif)$/i)){
    //alert('not an image');
    picpopup();

    document.getElementById('row1').style.display = "none";
    document.getElementById('row2').style.display = "block";
    return false;
  }
  // file type code end


        if (size > 26214400)
        {
            //show an alert to the user
            alert("Allowed file size exceeded. (Max. 25 MB)")

            document.getElementById('row1').style.display = "none";
            document.getElementById('row2').style.display = "block";

            return false;
        }


        $.ajax({

            url: base_url + "recruiter/image",
            type: "POST",
            data: fd,
            processData: false,
            contentType: false,
            success: function (response) {

            }
        });
    });



     function remove_user(abc)
                {

                    $.ajax({
                        type: 'POST',
                        url: base_url + "recruiter/remove_candidate",
                        data: 'save_id=' + abc,
                        success: function (data) {

                            $('#' + 'removeuser' + abc).html(data);
                            $('#' + 'removeuser' + abc).removeClass();
                            var numItems = $('.contact-frnd-post .job-contact-frnd .profile-job-post-detail').length;

                            if (numItems == '0') {
                              
                                var nodataHtml = "<div class='art-img-nn'><div class='art_no_post_img'><img src='"+ base_url + "assets/img/job-no1.png'/></div><div class='art_no_post_text'>No Saved Candidate  Available.</div></div>";
                                $('.contact-frnd-post').html(nodataHtml);
                            }

                        }
                    });

                }



                            function divClicked() {
                                var divHtml = $(this).html();
                                var editableText = $("<textarea/>");
                                editableText.val(divHtml);
                                $(this).replaceWith(editableText);
                                editableText.focus();
                                // setup the blur event for this new textarea
                                editableText.blur(editableTextBlurred);
                            }

                            function editableTextBlurred() {
                                var html = $(this).val();
                                var viewableText = $("<a>");
                                if (html.match(/^\s*$/) || html == '') { 
                                html = "Designation";
                                }
                                viewableText.html(html);
                                $(this).replaceWith(viewableText);
                                // setup the click event for this new div
                                viewableText.click(divClicked);

                                $.ajax({
                                    url: base_url + "recruiter/ajax_designation",
                                    type: "POST",
                                    data: {"designation": html},
                                    success: function (response) {

                                    }
                                });
                            }

                            $(document).ready(function () {
                                $("a.designation").click(divClicked);
                            });
  

     function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
            
            document.getElementById('preview').style.display = 'block';
                $('#preview').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
//    $("#profilepic").change(function(){
//       // pallavi code for not supported file type 10/06/2017
//      profile = this.files;
//      //alert(profile);
//      if (!profile[0].name.match(/.(jpg|jpeg|png|gif)$/i)){
//       //alert('not an image');
//        $('#profilepic').val('');
//         picpopup();
//         return false;
//          }else{
//          readURL(this);}
//
//          // end supported code 
//    });
          //validation for edit email formate form

//            $(document).ready(function () { 
//
//                $("#userimage").validate({
//
//                    rules: {
//
//                        profilepic: {
//
//                            required: true,
//                         
//                        },
//  
//
//                    },
//
//                    messages: {
//
//                        profilepic: {
//
//                            required: "Photo Required",
//                            
//                        },
//
//                },
//                 submitHandler: profile_pic
//                });
//                   });
 
                        function picpopup() {
                            
                      
            $('.biderror .mes').html("<div class='pop_content'>Only image Type is Supported");
            $('#bidmodal').modal('show');
                        }
                 

   
    $( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) {
        //$( "#bidmodal" ).hide();
        $('#bidmodal').modal('hide');
    }
});  


$( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) {
        //$( "#bidmodal" ).hide();
        $('#bidmodal-2').modal('hide');
    }
});
 
//For Scroll page at perticular position js Start
$(document).ready(function(){
 
//  $(document).load().scrollTop(1000);
     
    $('html,body').animate({scrollTop:265}, 100);

});
//For Scroll page at perticular position js End
//AJAX DATA LOAD BY LAZZY LOADER START
$(document).ready(function () {  
    save_candidate();
    
    $(window).scroll(function () {
      //  if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
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
                    save_candidate(pagenum);
                }
            }
        }
    });
});
var isProcessing = false;
function save_candidate(pagenum) {
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
        url: base_url + "recruiter/ajax_saved_candidate?page=" + pagenum,
        data: {total_record: $("#total_record").val()},
        dataType: "html",
        beforeSend: function () {
            if (pagenum == 'undefined') {
                 $(".job-contact-frnd").prepend('<p style="text-align:center;"><img class="loader" src="' + base_url + 'images/loading.gif"/></p>');
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
//AJAX DATA LOAD BY LAZZY LOADER END
function checkvalue(){
  
  var searchkeyword=$.trim(document.getElementById('rec_search_title').value);
  var searchplace=$.trim(document.getElementById('rec_search_loc').value);
 
  if(searchkeyword == "" && searchplace == ""){
    return false;
  }
}
 
  function check() 
  {
        var keyword = $.trim(document.getElementById('tags1').value);
        var place = $.trim(document.getElementById('searchplace1').value);
                  if (keyword == "" && place == "") 
                  {
                                return false;
                            
                    }
  }
//UPLOAD PROFILE PIC START
//function profile_pic() {
//    if (typeof FormData !== 'undefined') {
//        
//        var formData = new FormData($("#userimage")[0]);
//        $.ajax({
//          
//            url: base_url + "recruiter/user_image_insert",
//            type: "POST",
//            data: formData,
//            contentType: false,
//            cache: false,
//            processData: false,
//            success: function (data)
//            {
//                $('#bidmodal-2').modal('hide');
//                $(".user-pic").html(data);
//                document.getElementById('profilepic').value = null;
//                $('#preview').prop('src', '#');
//                 $('#preview').hide();
//                $('.popup_previred').hide();
//            },
//        });
//        return false;
//    }
//}
//UPLOAD PROFILE PIC END
//CODE FOR PROFILE PIC UPLOAD WITH CROP START
$uploadCrop1 = $('#upload-demo-one').croppie({
    enableExif: true,
    viewport: {
        width: 200,
        height: 200,
        type: 'square'
    },
    boundary: {
        width: 300,
        height: 300
    }
});

$('#upload-one').on('change', function () {
    document.getElementById('upload-demo-one').style.display = 'block';
    var reader = new FileReader();
    reader.onload = function (e) {
        $uploadCrop1.croppie('bind', {
            url: e.target.result
        }).then(function () {
            console.log('jQuery bind complete');
        });

    }
    reader.readAsDataURL(this.files[0]);
});
$(document).ready(function () {
    $("#userimage").validate({
        rules: {
            profilepic: {
                required: true,
            },
        },
        messages: {
            profilepic: {
                required: "Photo Required",
            },
        },
        submitHandler: profile_pic
    });
    function profile_pic() {
//    $('.upload-result-one').on('click', function (ev) {
        $uploadCrop1.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {
            $.ajax({
                //url: "/ajaxpro.php", user_image_insert
                // url: "<?php echo base_url(); ?>freelancer/ajaxpro_test",
                url: base_url + "recruiter/user_image_insert1",
                type: "POST",
                data: {"image": resp},
                beforeSend: function () {  
                    $('#profi_loader').show();
                   // document.getElementById('profi_loader').style.display = 'block';
                },
                complete: function () {
                //    document.getElementById('profi_loader').style.display = 'none';
                },
                success: function (data) {
                  $('#profi_loader').hide();
                    $('#bidmodal-2').modal('hide');
                    $(".user-pic").html(data);
                    document.getElementById('upload-one').value = null;
                    document.getElementById('upload-demo-one').value = '';
//                    html = '<img src="' + resp + '" />';
//                    $("#upload-demo-i").html(html);
                }
            });
        });
//    });
    }
});

function updateprofilepopup(id) {
    document.getElementById('upload-demo-one').style.display = 'none';
    document.getElementById('profi_loader').style.display = 'none';
    document.getElementById('upload-one').value = null;
    $('#bidmodal-2').modal('show');
}

//CODE FOR PROFILE PIC UPLOAD WITH CROP END