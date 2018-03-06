////CHECK SEARCH KEYWORD AND LOCATION BLANK START
//function checkvalue() {
//                    var searchkeyword = $.trim(document.getElementById('tags').value);
//                    var searchplace = $.trim(document.getElementById('searchplace').value);
//                    if (searchkeyword == "" && searchplace == "") {
//                        return  false;
//                    }
//                }
//                function check() {
//    var keyword = $.trim(document.getElementById('tags1').value);
//    var place = $.trim(document.getElementById('searchplace1').value);
//    if (keyword == "" && place == "") {
//        return false;
//    }
//}
////CHECK SEARCH KEYWORD AND LOCATION BLANK END
//FOR PREELOADER START
 jQuery(document).ready(function ($) {

     $('.ajax_load').hide();
     
                    $(window).load(function () {
                        $('#preloader').fadeOut('slow', function () {
                            $(this).remove();
                        });
                    });
                });
//FOR PREELOADER END

function validate(){

     var form = $("#freelancer_post_avability");
    if(form.valid() == true ){
     //$('#profilereg_ajax_load').show();
     document.getElementById('profilereg_ajax_load').style.display = 'inline-block';
     
    }
}


//FORM FILL UP VALIDATION START
$.validator.addMethod("regx", function(value, element, regexpr) {          
   if(!value) 
            {
                return true;
            }
            else
            {
                  return regexpr.test(value);
            }  
}, "Please enter valid number");
  $(document).ready(function () {

                    $("#freelancer_post_avability").validate({
                        rules: {
                            work_hour: {
                                required: false,
                                number: true,
                                max: 168,
                                regx:/^[0-9]*$/ 
                            },
                        },
                        messages: {
                            work_hour: {
                                max: "Number should be between 0-168"
                            },
                        }
                    });
                });
//FORM FILL UP VALIDATION END
//FLASH MESSAGE SCRIPT START
$(".alert").delay(3200).fadeOut(300);
//FLASH MESSAGE SCRIPT END


