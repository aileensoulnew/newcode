
jQuery(document).ready(function($) {  

// site preloader -- also uncomment the div in the header and the css style for #preloader
$(window).load(function(){
  $('#preloader').fadeOut('slow',function(){$(this).remove();});
});
});


$(".alert").delay(3200).fadeOut(300);

jQuery.validator.addMethod("noSpace", function(value, element) { 
      return value == '' || value.trim().length != 0;  
    }, "No space please and don't leave it empty");


//  $.validator.addMethod("regx", function(value, element, regexpr) {          
//     if(!value) 
//             {
//                 return true;
//             }
//             else
//             {
//                   return regexpr.test(value);
//             }
// }, "Number, space and special character are not allowed");


            $(document).ready(function () { 

                $("#artbasicinfo").validate({

                    rules: {

                        firstname: {

                            required: true,
                            //regx:/^[^-\s][a-zA-Z_\s-]+$/,
                            noSpace: true
                        },


                        lastname: {

                            required: true,
                            //regx:/^[^-\s][a-zA-Z_\s-]+$/,
                            noSpace: true
                        },


                        email: {
                            required: true,
                            email: true,
                            remote: {
                                url: base_url + "artistic/check_email",
                                //url: "<?php echo site_url() . 'artistic/check_email' ?>",
                                type: "post",
                                data: {
                                    email: function () {
                                        return $("#email").val();
                                    },
                                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                                },
                            },
                        },

                        phoneno: {

                            number: true,
                             minlength: 8,
                           maxlength:15
                           
                            
                        },

                    },

                    messages: {

                        firstname: {

                            required: "First name is required.",
                            
                        },

                        lastname: {

                            required: "Last name is required.",
                            
                        },

                        email: {
                            required: "Email id is required",
                            email: "Please enter valid email id",
                            remote: "Email already exists"
                        },
                        
                    },

                });
                   });


function checkvalue() {
                            
    var searchkeyword =$.trim(document.getElementById('tags').value);
    var searchplace = $.trim(document.getElementById('searchplace').value);
            
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
var input = $("#firstname");
var len = input.val().length;
input[0].focus();
input[0].setSelectionRange(len, len);
 });




