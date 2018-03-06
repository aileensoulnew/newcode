//CODE FOR COUNTRY,STATE,CITY DATA FETCH START
$(document).ready(function () {
    var name = [];
    $("#address_info").find("select").each(function (i) {
        name[i] = $(this).attr('id');
        if ($(this).val() != '') {
            $(this).addClass("color-black-custom");
        }
    });




    // $('.ajax_load').hide();


    $('#country').on('change', function () {
        var countryID = $(this).val();
        if (countryID) {
            $.ajax({
                type: 'POST',
                url: base_url + "freelancer_hire/ajax_dataforcity",
                data: 'country_id=' + countryID,
                success: function (html) {
                    $('#state').html(html);
                    $('#state').removeClass("color-black-custom");
                    $('#city').removeClass("color-black-custom");
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
                url: base_url + "freelancer_hire/ajax_dataforcity",
                data: 'state_id=' + stateID,
                success: function (html) {
                    $('#city').removeClass("color-black-custom");
                    $('#city').html(html);

                }
            });
        } else {
            $('#city').html('<option value="">Select state first</option>');
        }
    });
});
//CODE FOR COUNTRY,STATE,CITY DATA FETCH END

//CODE FOR PRELOADER START 
$(document).ready(function ($) {
    $(window).load(function () {
        $('#preloader').fadeOut('slow', function () {
            $(this).remove();
        });
    });
});
//CODE FOR PRELOADER END
function validate() {

    var form = $("#address_info");
    if (form.valid() == true) {
        //$('#profilereg_ajax_load').show();

        document.getElementById('profilereg_ajax_load').style.display = 'inline-block';

    }
}
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
//validation for edit email formate form
jQuery.validator.addMethod("noSpace", function (value, element) {
    return value == '' || value.trim().length != 0;
}, "No space please and don't leave it empty");

$.validator.addMethod("regx", function (value, element, regexpr) {
    return regexpr.test(value);
}, "Only space, only number and only specila characters are not allow");

$.validator.addMethod("regx1", function (value, element, regexpr) {
    if (!value)
    {
        return true;
    } else
    {
        return regexpr.test(value);
    }
}, "Pincode should be less than or equal 12 digit");
$(document).ready(function () {

    $("#address_info").validate({
        rules: {
            country: {
                required: true,
            },
            state: {
                required: true,
            },

            pincode: {
                regx1: /^.{0,12}$/
            },
        },

        messages: {
            country: {
                required: "Country is required.",
            },

            state: {
                required: "State is required.",
            },

        },

    });
});
//FORM FILL UP VALIDATION END

// FLASH MASSAGE DISPLAY TIMING START
$(".alert").delay(3200).fadeOut(300);
// FLASH MASSAGE DISPLAY TIMING END



