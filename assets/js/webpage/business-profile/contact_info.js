function checkvalue() {
    var searchkeyword = $.trim(document.getElementById('tags').value);
    var searchplace = $.trim(document.getElementById('searchplace').value);
    if (searchkeyword == "" && searchplace == "") {
        return false;
    }
}

// end of business search auto fill 

//validation for edit email formate form
// jQuery.validator.addMethod("noSpace", function(value, element) {
//       return value == '' || value.trim().length != 0;  
//     }, "No space please and don't leave it empty");


$.validator.addMethod("regx1", function (value, element, regexpr) {
    return regexpr.test(value);
}, "Only numbers are allowed.");
$.validator.addMethod("regx", function (value, element, regexpr) {
    return regexpr.test(value);
}, "Only space and only number are not allow.");
$(document).ready(function () {
    $("#contactinfo").validate({
        rules: {
            contactname: {
                required: true,
                regx: /^[a-zA-Z\s]*[a-zA-Z]/
                        //noSpace: true
            },
            contactmobile: {
                //regx1:/^\d+(\.\d+)?$/
                required: true,
                number: true,
                minlength: 8,
                maxlength: 15
            },
            email: {
                required: true,
                email: true,
                remote: {
                    url: base_url + "business_profile/check_email",
                    type: "post",
                    data: {
                        email: function () {
                            return $("#email").val();
                        },
                        get_csrf_token_name: get_csrf_hash,
                    },
                },
            },
        },
        messages: {
            contactname: {
                required: "Person name is required.",
            },
            contactmobile: {
                required: "Mobile number is required.",
            },
            email: {
                required: "Email id is required.",
                email: "Please enter valid email id.",
                remote: "Email already exists."
            },
        },
    });
});
// footer end 
$(".alert").delay(3200).fadeOut(300);

function check() {
    var keyword = $.trim(document.getElementById('tags1').value);
    var place = $.trim(document.getElementById('searchplace1').value);
    if (keyword == "" && place == "") {
        return false;
    }
}

$(document).ready(function () {
    var input1 = $("#contactname");
    var len = input1.val().length;
    input1[0].focus();
    input1[0].setSelectionRange(len, len);
    
});