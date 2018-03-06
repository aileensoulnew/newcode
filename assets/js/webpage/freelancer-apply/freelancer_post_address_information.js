//CODE FOR COUNTRY,STATE, CITY START
$(document).ready(function () {

    $('.ajax_load').hide();
    $("#freelancer_post_addressinfo").find("select").each(function (i) {
        if ($(this).val() != '') {
            $(this).addClass("color-black-custom");
        }
    });
    $('#country').on('change', function () {
        var countryID = $(this).val();
        if (countryID) {
            $.ajax({
                type: 'POST',
                url: base_url + "freelancer/ajax_data",
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
                url: base_url + "freelancer/ajax_data",
                data: 'state_id=' + stateID,
                success: function (html) {
                    $('#city').html(html);
                    $('#city').removeClass("color-black-custom");
                }
            });
        } else {
            $('#city').html('<option value="">Select state first</option>');
        }
    });
});
//CODE FOR COUNTRY,STATE,CITY END


function validate() {

    var form = $("#freelancer_post_addressinfo");
    if (form.valid() == true) {
        //$('#profilereg_ajax_load').show();
        document.getElementById('profilereg_ajax_load').style.display = 'inline-block';

    }
}


////CHECK SEARCH KEYWORD AND LOCATION BLANK START
//function checkvalue() {
//    var searchkeyword = $.trim(document.getElementById('tags').value);
//    var searchplace = $.trim(document.getElementById('searchplace').value);
//    if (searchkeyword == "" && searchplace == "") {
//        return  false;
//    }
//}
//function check() {
//    var keyword = $.trim(document.getElementById('tags1').value);
//    var place = $.trim(document.getElementById('searchplace1').value);
//    if (keyword == "" && place == "") {
//        return false;
//    }
//}
////CHECK SEARCH KEYWORD AND LOCATION BLANK END
//FLASH MASSAGE SCRIPT START
$(".alert").delay(3200).fadeOut(300);
//FLASH MASSAGE SCRIPT END
//FORM FILL UP VALIDATION START
jQuery.validator.addMethod("noSpace", function (value, element) {
    return value == '' || value.trim().length != 0;
}, "No space please and don't leave it empty");
$.validator.addMethod("regx", function (value, element, regexpr) {
    return regexpr.test(value);
}, "Only space, only number and only special characters are not allow");
$(document).ready(function () {
    $("#freelancer_post_addressinfo").validate({
        rules: {
            country: {
                required: true,
            },
            state: {
                required: true,
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
//FORM FILL UP VALIADATION END
//CODE FOR PREELOADER START
jQuery(document).ready(function ($) {
    // site preloader -- also uncomment the div in the header and the css style for #preloader
    $(window).load(function () {
        $('#preloader').fadeOut('slow', function () {
            $(this).remove();
        });
    });
});
//CODE FOR PREELOADER END
