function checkvalue() {

    var searchkeyword = $.trim(document.getElementById('tags').value);
    var searchplace = $.trim(document.getElementById('searchplace').value);
    if (searchkeyword == "" && searchplace == "") {
        return false;
    }
}
// end of business search auto fill 
function busSelectCheck(nameSelect)
{
    var industriyal = document.getElementById("industriyal").value;
    var business_type = document.getElementById("business_type").value;
    if (nameSelect) {
        var busOptionValue = document.getElementById("busOption").value;
        if (busOptionValue == nameSelect.value) {
            document.getElementById("busDivCheck").style.display = "block";
            document.getElementById("bustype").style.display = "block";
            document.getElementById("other-business").style.display = "block";
            $("#busDivCheck .half-width label").html('Other Business Type:<span style="color:red;" >*</span>');
        } else {
            document.getElementById("busDivCheck").style.display = "none";
//            document.getElementById("bustype").style.display = "none";
            if (industriyal == 0 && business_type == 0) {
                $("#busDivCheck .half-width label").text('');
                $("#bustype-error").remove();
            }
            if (industriyal == 0 && business_type != 0) {
                $("#busDivCheck .half-width label").text('');
                $("#bustype-error").remove();
            }
        }
    } else {
        document.getElementById("bustype").style.display = "none";
        $("#busDivCheck .half-width label").text('');
    }
}

function indSelectCheck(nameSelect)
{
    if (nameSelect) {
        indOptionValue = document.getElementById("indOption").value;
        if (indOptionValue == nameSelect.value) {
            document.getElementById("indDivCheck").style.display = "block";
            document.getElementById("indtype").style.display = "block";
            document.getElementById("other-category").style.display = "block";
        } else {
            document.getElementById("indDivCheck").style.display = "none";
        }
    } else {
        document.getElementById("indDivCheck").style.display = "none";
    }
}

$(document).ready(function () {
    $('#industriyal').on('change', function () {
        var industriyalID = $(this).val();
        if (industriyalID) {
            $.ajax({
                type: 'POST',
                url: base_url + "business_profile/ajax_data",
                data: 'industry_id=' + industriyalID,
                success: function (html) {
                    $('#subindustriyal').html(html);
                }
            });
        } else {
            $('#subindustriyal').html('<option value="">Select industriyal first</option>');
        }
    });
});
//validation for edit email formate form


jQuery.validator.addMethod("noSpace", function (value, element) {
    return value == '' || value.trim().length != 0;
}, "No space please and don't leave it empty");
$.validator.addMethod("regx", function (value, element, regexpr) {
    if (!value)
    {
        return true;
    } else
    {
        return regexpr.test(value);
    }
    // return regexpr.test(value);
}, "Only space, only number and only special characters are not allow");
$(document).ready(function () {

    $("#businessdis").validate({

        rules: {

            business_type: {

                required: true,
            },
            industriyal: {

                required: true,
            },
            subindustriyal: {

                required: true,
            },
            business_details: {

                required: true,
                regx: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
                        //noSpace: true

            },
        },
        messages: {

            business_type: {

                required: "Business type is required.",
            },
            industriyal: {

                required: "Industrial is required.",
            },
            subindustriyal: {

                required: "Subindustrial is required.",
            },
            business_details: {

                required: "Business details is required.",
            },
        },
    });
});
$(".alert").delay(3200).fadeOut(300);


function check() {
    var keyword = $.trim(document.getElementById('tags1').value);
    var place = $.trim(document.getElementById('searchplace1').value);
    if (keyword == "" && place == "") {
        return false;
    }
}
$(document).ready(function () {
    var input = $("#business_details");
    var len = input.val().length;
    input[0].focus();
    input[0].setSelectionRange(len, len);
});