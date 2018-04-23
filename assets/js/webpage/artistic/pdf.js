

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

 $(document).ready(function() {
      $('.blocks').jMosaic({items_type: "li", margin: 0});
      $('.pictures').jMosaic({min_row_height: 150, margin: 3, is_first_big: true});
    });
    

    function updateprofilepopup(id) {
                                $('#bidmodal-2').modal('show');
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


$(document).ready(function() {
  $("html,body").animate({scrollTop: 350}, 100); //100ms for example
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

function divClicked() {
       var divHtml = $(this).html();
        divHtml = divHtml.trim();
       var editableText = $("<textarea />");
       editableText.val(divHtml);
       $(this).replaceWith(editableText);
       editableText.focus();
       // setup the blur event for this new textarea
       editableText.blur(editableTextBlurred);
   }
   
   function editableTextBlurred() {
      
      var html = $(this).val();
      html = html.trim();
       var viewableText = $("<a>");
      
       if (html.match(/^\s*$/) || html == '') { 
       html = "Current Work";
       } 
       
       viewableText.html(html);
       $(this).replaceWith(viewableText);
       // setup the click event for this new div
       viewableText.click(divClicked);
   
       $.ajax({
            url: base_url + "artistic/art_designation",
           //url: "<?php echo base_url(); ?>artistic/art_designation",
           type: "POST",
           data: {"designation": html},
           success: function (response) {
   
           }
       });
   }
   
   $(document).ready(function () {
   // alert("hi");
       $("a.designation").click(divClicked);
   });
