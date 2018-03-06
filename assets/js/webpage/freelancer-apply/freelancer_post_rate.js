
//FLASH MESSAGE SCRIPT START
$(".alert").delay(3200).fadeOut(300);
//FLASH MESSAGE SCRIPT END

//FORM FILL UP VALIDATION START
 $.validator.addMethod("regx1", function (value, element, regexpr) {
                    //return value == '' || value.trim().length != 0; 
                    if (!value)
                    {
                        return true;
                    } else
                    {
                        return regexpr.test(value);
                    }
                }, "Upto 8 digit number allow");

                $(document).ready(function () {
                    $("#freelancer_post_rate").validate({
                        rules: {
                            hourly: {
                                number: true,
                                regx1: /^.{0,8}$/
                            },
                        },

                        messages: {
                        },
                    });
                });
//FORM FILL UP VALIDATION END
jQuery(document).ready(function ($) {

    $('.ajax_load').hide();
    $("#freelancer_post_rate").find("select").each(function (i) {
        if ($(this).val() != '') {
            $(this).addClass("color-black-custom");
        }
    });
});

function validate(){

     var form = $("#freelancer_post_rate");
    if(form.valid() == true ){
     //$('#profilereg_ajax_load').show();
     document.getElementById('profilereg_ajax_load').style.display = 'inline-block';
     
    }
}

