        
//AJAX DATA LOAD BY LAZZY LOADER START
$(document).ready(function () {
    recommen_candidate_post();
    
    $(window).scroll(function () {
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
                    recommen_candidate_post(pagenum);
                }
            }
        }
    });
});
var isProcessing = false;
function recommen_candidate_post(pagenum) {
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
         url: base_url + "recruiter/recruiter_search_candidate?page=" + pagenum + "&skill="  + encodeURIComponent(skill) + "&place=" + place,
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
  

                        function check() {
                            var keyword = $.trim(document.getElementById('tags1').value);
                            var place = $.trim(document.getElementById('searchplace1').value);
                            if (keyword == "" && place == "") {
                                return false;
                            }
                        }
                   
    function checkvalue() {
//alert("hi");
  var searchkeyword =$.trim(document.getElementById('rec_search_title').value);
var searchplace = $.trim(document.getElementById('rec_search_loc').value);
        
// alert(searchkeyword);
// alert(searchplace);
        if (searchkeyword == "" && searchplace == "") {
       //     alert('Please enter Keyword');
            return false;
        }
    }

      function checkvalue_search() {
       
       
        var searchkeyword =$.trim(document.getElementById('tags').value);
        var searchplace = $.trim(document.getElementById('searchplace').value);
        
        if (searchkeyword == "" && searchplace == "") 
        {
          //  alert('Please enter Keyword');
            return false;
        }
    }

   
           function save_user(abc,jobid)
                        {

           var saveid = document.getElementById("hideenuser"+jobid);
         
                $.ajax({
        type: 'POST',
        url: base_url +'recruiter/save_search_user',
        data: 'user_id=' + abc + '&save_id=' + saveid.value,
        success: function (data) {

                $('.'+'saveduser'+jobid).html(data).addClass('saved');
                                }
                            });
                        }
                 
// save post end

                        function savepopup(id,jobid) {
                       
                            save_user(id,jobid);
                      
            $('.biderror .mes').html("<div class='pop_content'>Candidate successfully saved.");
            $('#bidmodal').modal('show');
                        }
                    


// all popup close close using esc start 

    $( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) {
        //$( "#bidmodal" ).hide();
        $('#bidmodal').modal('hide');
    }
});  
 

// all popup close close using esc end
    // recruiter search header 2  start
