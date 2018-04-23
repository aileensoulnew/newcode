
$(document).ready(function () {  
    artistic_following(slug_id);

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
                    artistic_following(slug_id, pagenum);
                }
            }
        }
    });

});
var isProcessing = false;
function artistic_following(slug_id, pagenum)
{//alert(slug_id);
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
       
        url: base_url + "artistic/ajax_following/" + slug_id + '?page=' + pagenum,
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

function updateprofilepopup(id) {
        $('#bidmodal-2').modal('show');
    }
var modal = document.getElementById('myModal');
// Get the button that opens the modal
var btn = document.getElementById("myBtn");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

 //validation for edit email formate form
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

function followuser(clicked_id)
{ //alert(clicked_id); 
   $.ajax({
                type:'POST',
                url: base_url + "artistic/follow_two",
                //url:'<?php echo base_url() . "artistic/follow_two" ?>',
                 data:'follow_to='+clicked_id,
                success:function(data){ 
               $('.' + 'fruser' + clicked_id).html(data);                    
                }
            }); 
}

function unfollowuser(clicked_id)
{  
   $.ajax({
                type:'POST',
                url: base_url + "artistic/unfollow_two",
                //url:'<?php echo base_url() . "artistic/unfollow_two" ?>',
                 data:'follow_to='+clicked_id,
                success:function(data){ 
               $('.' + 'fruser' + clicked_id).html(data);                   
                }
            }); 
}

function followuser_two(clicked_id)
{ 
   $.ajax({
                type:'POST',
                url: base_url + "artistic/followtwo",
                //url:'<?php echo base_url() . "artistic/followtwo" ?>',
                dataType: 'json',
                 data:'follow_to='+clicked_id,
                success:function(data){ 
               $('#' + 'frfollow' + clicked_id).html(data.follow);                   
                }
            }); 
}

 function unfollowuser_two(clicked_id)
    {
        $.ajax({
            type: 'POST',
            url: base_url + "artistic/unfollowtwo",
            //url: '<?php echo base_url() . "artistic/unfollowtwo" ?>',
            dataType: 'json',
            data: 'follow_to=' + clicked_id,
            success: function (data) { 
                $('#' + 'frfollow' + clicked_id).html(data.follow);  
              // $('#unfollowdiv').html('');
            }
        });
    }

function unfollowuser_list(clicked_id)
{ 
   $.ajax({
                type:'POST',
                url: base_url + "artistic/unfollow_following",
                //url:'<?php echo base_url() . "artistic/unfollow_following" ?>',
                dataType: 'json',
                 data:'follow_to='+clicked_id,
                success:function(data){ //alert(data.unfollow);
               $('.' + 'frusercount').html(data.unfollow);
               if(data.notcount == 0){ 
                 $('.' + 'job-contact-frnd').html(data.notfound);
               $('#countfollow').html(data.unfollow);

               }else{ 
              $('#' + 'removefollow' + clicked_id).fadeOut(4000);
               $('#countfollow').html(data.unfollow);

                 }   
                }
            }); 
}

 
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
   //  $(document).load().scrollTop(1000);       
       $('html,body').animate({scrollTop:265}, 100);  
   });