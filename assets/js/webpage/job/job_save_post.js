//validation start
$(document).ready(function () {
   
       $("#jobdesignation").validate({
   
           rules: {
   
               designation: {
   
                   required: true,
   
               },
   
           },
   
           messages: {
   
               designation: {
   
                   required: "Designation is required.",
   
               },
   
           },
   
       });
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
   
                   required: "Photo required",
                   
               },
       },
    submitHandler: profile_pic
       });
    });
//Validation End

//CODE FOR RESPONES OF AJAX COME FROM CONTROLLER AND LAZY LOADER START
$(document).ready(function () {
    job_save();
 
    $(window).scroll(function () {
        if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.7) {
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
                    
                    job_save(pagenum);
                }
            }
        }
    });
    
});
var isProcessing = false;
function job_save(pagenum)
{
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
        url: base_url + "job/ajax_save_job?page=" + pagenum,
        data: {total_record:$("#total_record").val()},
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
//CODE FOR RESPONES OF AJAX COME FROM CONTROLLER AND LAZY LOADER END

   //Remove Post Start
    function removepopup(id) {
       $('.biderror .mes').html("<div class='pop_content'>Do you want to remove this job?<div class='model_ok_cancel'><a class='okbtn' id=" + id + " onClick='remove_post(" + id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
       $('#bidmodal').modal('show');
   }

    function remove_post(abc)
   {
       var savepara = 'save';
       $.ajax({
           type: 'POST',
           url: base_url +'job/job_delete_apply',
           data: 'app_id=' + abc + '&para=' + savepara,
           success: function (data) {
               $('#' + 'postdata' + abc).html(data);
               $('#' + 'postdata' + abc).removeClass();
               var numItems = $('.contact-frnd-post .job-contact-frnd .profile-job-post-detail').length;
              if (numItems == '0') {
               
                  var nodataHtml = "<div class='art-img-nn'><div class='art_no_post_img'><img src = '"+ base_url + "img/job-no.png'/></div><div class='art_no_post_text'>No  Saved Post Available.</div></div>";
                  $('.contact-frnd-post').html(nodataHtml);
               }
           }
       });
   }
   //Remove Post End

   //Apply Post Start
    function applypopup(postid, appid) {
       $('.biderror .mes').html("<div class='pop_content'>Do you want to apply this job?<div class='model_ok_cancel'><a class='okbtn' id=" + postid + " onClick='apply_post(" + postid + "," + appid + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
       $('#bidmodal').modal('show');
   }

    function apply_post(abc, xyz)
   {
   
       var alldata = 'all';
       var user = aileenuser_id;
       var appid = xyz;
   
       $.ajax({
           type: 'POST',
           url: base_url +'job/job_apply_post',
           data: 'post_id=' + abc + '&allpost=' + alldata.value + '&userid=' + user.value,
           success: function (data) {
               $('#' + 'postdata' + appid).html(data);
               $('#' + 'postdata' + appid).removeClass();
               var numItems = $('.contact-frnd-post .job-contact-frnd .profile-job-post-detail').length;
              
               if (numItems == '0') {

                   var nodataHtml = "<div class='art-img-nn'><div class='art_no_post_img'><img src='"+ base_url + "img/job-no.png'/></div><div class='art_no_post_text'>No  Saved Post Available.</div></div>";
                    $('.contact-frnd-post').html(nodataHtml);
               }
   
           }
       });
   
   }
   //Apply Post End

  

