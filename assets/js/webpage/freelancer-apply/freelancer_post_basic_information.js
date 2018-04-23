//CHECK SEARCH KEYWORD AND LOCATION BLANK START
function checkvalue() {
    var searchkeyword = $.trim(document.getElementById('tags').value);
    var searchplace = $.trim(document.getElementById('searchplace').value);
    if (searchkeyword == "" && searchplace == "") {
        return  false;
    }
}
function check() {
    var keyword = $.trim(document.getElementById('tags1').value);
    var place = $.trim(document.getElementById('searchplace1').value);
    if (keyword == "" && place == "") {
        return false;
    }
}
//CHECK SEARCH KEYWORD AND LOCATION BLANK END
//FLASH MESSAGE SCRIPT START
$(".alert").delay(3200).fadeOut(300);
//FLASH MESSAGE SCRIPT END
//FORM FILL UP VALIDATION START

jQuery.validator.addMethod("noSpace", function (value, element) {
    return value == '' || value.trim().length != 0;
}, "No space please, don't leave it empty");

//$.validator.addMethod("regx", function (value, element, regexpr) {
//    if (!value)
//    {
//        return true;
//    } else
//    {
//        return regexpr.test(value);
//    }
//}, "Number, space and special character are not allowed");

$.validator.addMethod("regx1", function (value, element, regexpr) {
    if (!value)
    {
        return true;
    } else
    {
        return regexpr.test(value);
    }
}, "Enter a number between 8 to 15 digit");

$(document).ready(function () {
    $("#freelancer_post_basicinfo").validate({
        rules: {
            firstname: {
                required: true,
                noSpace:true,
//                regx: /^[^-\s][a-zA-Z_\s-]+$/,
            },

            lastname: {
                required: true,
                noSpace:true
//                regx: /^[^-\s][a-zA-Z_\s-]+$/,
            },

            email: {
                required: true,
                email: true,
                remote: {
                    url: site + "freelancer/check_email",
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
                regx1: /^[0-9\-\+]{9,15}$/,

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
                required: "Email id is required.",
                email: "Please enter valid email id.",
                remote: "Email already exists."
            },

            phoneno: {
                minlength: "Minimum length 8 digit",
                maxlength: "Maximum length 15 digit"

            }

        },

    });
});
//FORM FILL UP VALIDATION END
//FOR PREELOADER START
jQuery(document).ready(function ($) {
    $(window).load(function () {
        $('#preloader').fadeOut('slow', function () {
            $(this).remove();
        });
    });
});
//FOR PREELOADER END

