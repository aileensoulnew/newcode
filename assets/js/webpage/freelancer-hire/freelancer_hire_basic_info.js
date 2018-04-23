
// CHECK SEARCH KEYWORD AND LOCATION BLANK START
function checkvalue() {
    var searchkeyword = $.trim(document.getElementById('tags').value);
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
// CHECK SEARCH KEYWORD AND LOCATION BLANK END
// FORM FILL UP VALIDATION START
jQuery.validator.addMethod("noSpace", function (value, element) {
    return value == '' || value.trim().length != 0;
}, "No space please , don't leave it empty");

//$.validator.addMethod("regx", function (value, element, regexpr) {
//    if (!value)
//    {
//        return true;
//    } else
//    {
//        return regexpr.test(value);
//    }
//    // return regexpr.test(value);
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
    $("#basic_info").validate({
        rules: {
            fname: {
                required: true,
                noSpace:true,
//                regx: /^[^-\s][a-zA-Z_\s-]+$/,
            },
            lname: {
                required: true,
                noSpace:true,
//                regx: /^[^-\s][a-zA-Z_\s-]+$/,
            },
            email: {
                required: true,
                email: true,
                remote: {
                    url: site_url + "freelancer_hire/check_email",
                    type: "post",
                    data: {
                        email: function () {
                            return $("#email").val();
                        },
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                    },
                },
            },
            phone: {
                regx1: /^[0-9\-\+]{9,15}$/,
            },
        },

        messages: {
            fname: {
                required: "First name is required.",
            },
            lname: {
                required: "Last name is required.",
            },
            email: {
                required: "Email id is required",
                email: "Please enter valid email id",
                remote: "Email already exists"
            },
            phone: {
                minlength: "Minimum length 8 digit",
                maxlength: "Maximum length 15 digit"
            }
        },
    });
});
//FORM FILL UP VALIDATION END
//CODE FOR PRELOADER START
jQuery(document).ready(function ($) {
    // site preloader -- also uncomment the div in the header and the css style for #preloader
    $(window).load(function () {
        $('#preloader').fadeOut('slow', function () {
            $(this).remove();
        });
    });
});
//CODE FOR PRELOADER END

