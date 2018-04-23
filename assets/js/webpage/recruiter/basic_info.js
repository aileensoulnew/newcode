//validation for edit email formate form

//          jQuery.validator.addMethod("noSpace", function(value, element) {
//   return value == '' || value.trim().length != 0;  
// }, "No space please and don't leave it empty");


$.validator.addMethod("regx", function (value, element, regexpr) {
    return regexpr.test(value);
}, "Number, space and special character are not allowed.");

$(document).ready(function () {

    $("#basicinfo").validate({

        rules: {

            first_name: {

                required: true,
                regx: /^[a-zA-Z]+$/,
                //noSpace: true

            },

            last_name: {

                required: true,
                regx: /^[a-zA-Z]+$/,
                //noSpace: true

            },

            email: {
                required: true,
                email: true,
                remote: {
                    url: base_url + "recruiter/check_email",
                    type: "post",
                    data: {
                        email: function () {
                            return $("#email").val();
                        },
                        get_csrf_token_name: get_csrf_hash,
                    },
                },
            },

            phoneno: {

                number: true,
                minlength: 8,
                maxlength: 15


            },

        },

        messages: {

            first_name: {

                required: "First name is required.",
            },

            last_name: {

                required: "Last name is required.",
            },

            email: {
                required: "Email id is required.",
                email: "Please enter valid email id.",
                remote: "Email already exists."
            },

            phoneno: {

                required: "Phone number is required.",
                //phoneno: "Enter valid number.",
            },

        },

    });
});



jQuery(document).ready(function ($) {

// site preloader -- also uncomment the div in the header and the css style for #preloader
    $(window).load(function () {
        $('#preloader').fadeOut('slow', function () {
            $(this).remove();
        });
    });
});

