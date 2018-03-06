//Disable progress bar when 100% complete Start
  $(document).ready(function(){ 
   
   var nb = $('div.profile-job-post-title').length;
    if(nb == 0){
   $("#dropdownclass").addClass("no-post-h2");
   
    }
   });
   
    $(document).ready(function () {
   $('.complete_profile').fadeIn('fast').delay(5000).fadeOut('slow');
   $('.edit_profile_job').fadeIn('slow').delay(5000);
   $('.tr_text').fadeIn('slow').delay(500);
   $('.true_progtree img').fadeIn('slow').delay(500);
     });
//Disable progress bar when 100% complete End

//Progress bar see start
 (function($) {9
   $('.second.circle-1').circleProgress({
   value: count_profile_value
   }).on('circle-animation-progress', function(event, progress) {
   $(this).find('strong').html(Math.round(count_profile * progress) + '<i>%</i>');
   });
   
   })(jQuery);
   //Progress bar see End
   
 //all popup close close using esc start
     $( document ).on( 'keydown', function ( e ) {
   if ( e.keyCode === 27 ) {
       $('#bidmodal').modal('hide');
   }
   });  
   
   
    $( document ).on( 'keydown', function ( e ) {
   if ( e.keyCode === 27 ) {
       $('#bidmodal-2').modal('hide');
   }
   });  
   //all popup close close using esc end