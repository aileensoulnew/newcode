function checkvalue() {
    var searchkeyword = $.trim(document.getElementById('tags').value);
    var searchplace = $.trim(document.getElementById('searchplace').value);
    if (searchkeyword == "" && searchplace == "") {
        return false;
    }
}
// end of business search auto fill 

//validation for edit email formate form
$.validator.addMethod("regx", function (value, element, regexpr) {
    if (!value)
    {
        return true;
    } else
    {
        return regexpr.test(value);
    }
}, "Only space, only number and only special characters are not allow");

$(document).ready(function () {
    $("#businessinfo").validate({
        rules: {
            companyname: {
                required: true,
                regx: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
            },
            country: {
                required: true,
            },
            state: {
                required: true,
            },
            business_address: {
                required: true,
                regx: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
            },
        },
        messages: {
            companyname: {
                required: company_name_validation,
            },
            country: {
                required: country_validation,
            },
            state: {
                required: state_validation,
            },
            business_address: {
                required: address_validation,
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
    $('#country').on('change', function () {
        var countryID = $(this).val();
        if (countryID) {
            $.ajax({
                type: 'POST',
                url: base_url + "business_profile/ajax_data",
                data: 'country_id=' + countryID,
                success: function (html) {
                    $('#state').html(html);
                    $('#city').html('<option value="">Select state first</option>');
                }
            });
        } else {
            $('#state').html('<option value="">Select country first</option>');
            $('#city').html('<option value="">Select state first</option>');
        }
    });

    $('#state').on('change', function () {
        var stateID = $(this).val();
        if (stateID) {
            $.ajax({
                type: 'POST',
                url: base_url + "business_profile/ajax_data",
                data: 'state_id=' + stateID,
                success: function (html) {
                    $('#city').html(html);
                }
            });
        } else {
            $('#city').html('<option value="">Select state first</option>');
        }
    });
});
$(document).ready(function () {
    var input1 = $("#business_address");
    var len = input1.val().length;
    input1[0].focus();
    input1[0].setSelectionRange(len, len);
    
    var input = $("#companyname");
    var len = input.val().length;
    input[0].focus();
    input[0].setSelectionRange(len, len);
    
    
});