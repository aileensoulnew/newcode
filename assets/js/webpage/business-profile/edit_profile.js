$(document).ready(function () {
    $('.business-info-form-edit').css('display', 'block');
    $('.contact-info-form-edit').css('display', 'none');
    $('.description-form-edit').css('display', 'none');
    $('.bus-image-form-edit').css('display', 'none');
    $('ul.left-form-each li').removeClass('active init');
    $('li.business_info_li').addClass('active init');
});

$('.business_info_li').on('click', function () {
    $('.business-info-form-edit').css('display', 'block');
    $('.contact-info-form-edit').css('display', 'none');
    $('.description-form-edit').css('display', 'none');
    $('.bus-image-form-edit').css('display', 'none');
    $('ul.left-form-each li').removeClass('active init');
    $('li.business_info_li').addClass('active init');
});

$('.contact_info_li').on('click', function () {
    $('.business-info-form-edit').css('display', 'none');
    $('.contact-info-form-edit').css('display', 'block');
    $('.description-form-edit').css('display', 'none');
    $('.bus-image-form-edit').css('display', 'none');
    $('ul.left-form-each li').removeClass('active init');
    $('li.contact_info_li').addClass('active init');
});

$('.description_li').on('click', function () {
    $('.business-info-form-edit').css('display', 'none');
    $('.contact-info-form-edit').css('display', 'none');
    $('.description-form-edit').css('display', 'block');
    $('.bus-image-form-edit').css('display', 'none');
    $('ul.left-form-each li').removeClass('active init');
    $('li.description_li').addClass('active init');
});

$('.bus_image_li').on('click', function () {
    $('.business-info-form-edit').css('display', 'none');
    $('.contact-info-form-edit').css('display', 'none');
    $('.description-form-edit').css('display', 'none');
    $('.bus-image-form-edit').css('display', 'block');
    $('ul.left-form-each li').removeClass('active init');
    $('li.bus_image_li').addClass('active init');
});

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
    var input1 = $("#business_address");
    var len = input1.val().length;
    input1[0].focus();
    input1[0].setSelectionRange(len, len);

    var input = $("#companyname");
    var len = input.val().length;
    input[0].focus();
    input[0].setSelectionRange(len, len);

});

$(document).ready(function () {
    var input1 = $("#contactname");
    var len = input1.val().length;
    input1[0].focus();
    input1[0].setSelectionRange(len, len);

});


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


$(document).ready(function () {
    var input = $("#business_details");
    var len = input.val().length;
    input[0].focus();
    input[0].setSelectionRange(len, len);
});



// end of business search auto fill 
$(".alert").delay(3200).fadeOut(300);
function delete_job_exp(grade_id) {
    $.ajax({
        type: 'POST',
        url: base_url + "business_profile/bus_img_delete",
        data: 'grade_id=' + grade_id,
        success: function (data) {
            if (data) {

                $('.job_work_edit_' + grade_id).remove();
            }
        }
    });
}

// footer end 
$("#image1").change(function () {
    readURL(this);
});
// only iamge upload validation strat


function validate(event) {


    var fileInput = document.getElementById("image1").files;
    if (fileInput != '')
    {
        for (var i = 0; i < fileInput.length; i++)
        {

            var vname = fileInput[i].name;
            var ext = vname.split('.').pop();
            var allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'PNG'];
            var foundPresent = $.inArray(ext, allowedExtensions) > -1;
            // alert(foundPresent);

            if (foundPresent == true)
            {
            } else {
                $(".bus_image").html("Please select only Image File.");
                event.preventDefault();
                //return false; 
            }
        }
    }
}
function removemsg() {
    $(".bus_image").html(" ");
    document.getElementById("image1").value = null;
}





jQuery(document).ready(function ($) {
    var options = {
        beforeSend: function () {
        },
        uploadProgress: function (event, position, total, percentComplete) {
        },
        success: function () {
        },
        complete: function (response) {
            $('.business-info-form-edit').css('display', 'none');
            $('.contact-info-form-edit').css('display', 'block');
            $('.description-form-edit').css('display', 'none');
            $('.bus-image-form-edit').css('display', 'none');
            $('ul.left-form-each li').removeClass('active init');
            $('li.contact_info_li').addClass('active init');
        }
    };
    // Submit the form
    $("#businessinfo").ajaxForm(options);
    return false;
});



jQuery(document).ready(function ($) {
    var options = {
        beforeSend: function () {
        },
        uploadProgress: function (event, position, total, percentComplete) {
        },
        success: function () {
        },
        complete: function (response) {
            $('.business-info-form-edit').css('display', 'none');
            $('.contact-info-form-edit').css('display', 'none');
            $('.description-form-edit').css('display', 'block');
            $('.bus-image-form-edit').css('display', 'none');
            $('ul.left-form-each li').removeClass('active init');
            $('li.description_li').addClass('active init');
        }
    };
    // Submit the form
    $("#contactinfo").ajaxForm(options);
    return false;
});



jQuery(document).ready(function ($) {
    var options = {
        beforeSend: function () {
        },
        uploadProgress: function (event, position, total, percentComplete) {
        },
        success: function () {
        },
        complete: function (response) {
            $('.business-info-form-edit').css('display', 'none');
            $('.contact-info-form-edit').css('display', 'none');
            $('.description-form-edit').css('display', 'none');
            $('.bus-image-form-edit').css('display', 'block');
            $('ul.left-form-each li').removeClass('active init');
            $('li.bus_image_li').addClass('active init');
        }
    };
    // Submit the form
    $("#businessdis").ajaxForm(options);
    return false;
});



jQuery(document).ready(function ($) {
    var options = {
        beforeSend: function () {
        },
        uploadProgress: function (event, position, total, percentComplete) {
        },
        success: function () {
        },
        complete: function (response) {
            window.location = base_url + "business-profile/home";
        }
    };
    // Submit the form
    $("#businessimage").ajaxForm(options);
    return false;
});

