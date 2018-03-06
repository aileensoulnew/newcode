
$(document).ready(function () {

     $('.ajax_load').hide();
     
     var name = [];
    $("#basicinfo").find("select").each(function (i) {
        name[i] = $(this).attr('id');
        if ($(this).val() != '') {
            $(this).addClass("color-black-custom");
        }
    });
     
    $('#country').on('change', function () {
        var countryID = $(this).val();
        
        if (countryID) {
            $.ajax({
                type: 'POST',
                url: base_url + "job_profile/ajax_data",
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
                url: base_url + "job_profile/ajax_data",
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

//validation for edit email formate form


function reg_loader(){

      var form = $("#basicinfo");
    if(form.valid() == true ){

     document.getElementById('profilereg_ajax_load').style.display = 'inline-block';
        
     //$('#profilereg_ajax_load').show();
    }

}

jQuery.validator.addMethod("noSpace", function (value, element) {
    return value == '' || value.trim().length != 0;
}, "No space please and don't leave it empty");


$.validator.addMethod("regx", function (value, element, regexpr) {
    return regexpr.test(value);
}, "Number, space and special character are not allowed");


$(document).ready(function () {

    $("#basicinfo").validate({

        rules: {

            comp_name: {

                required: true,
                regx: /^[a-zA-Z0-9\s]*[a-zA-Z][a-zA-Z0-9]*[-@./#&+,\w\s]/
                        //noSpace: true

            },

            comp_email: {

                required: true,
                email: true,
                remote: {
                    url: base_url + "recruiter/check_email_com",
                    type: "post",
                    data: {
                        email: function () {
                            return $("#comp_email").val();
                        },
                         get_csrf_token_name: get_csrf_hash,
                    },
                },
            },

            comp_num: {

                minlength: 8,
                maxlength: 15,
                number: true
            },

            comp_sector: {

                maxlength: 2500

            },
            comp_profile: {

                maxlength: 2500

            },

            other_activities: {

                maxlength: 2500

            },

            country: {

                required: true,

            },

            state: {

                required: true,

            },

        },

        messages: {

            comp_name: {

                required: "Company name is required.",

            },

            comp_email: {

                required: "Email address is required.",
                email: "Please enter valid email id.",
                remote: "Email already exists."
            },

            comp_num: {

                required: "Phone no is required.",

            },
            country: {

                required: "Country is required.",

            },

            state: {

                required: "State is required.",

            },

        },
 
    });
});



$(".alert").delay(3200).fadeOut(300);

//jQuery(document).ready(function ($) {
//
//// site preloader -- also uncomment the div in the header and the css style for #preloader
//    $(window).load(function () {
//        $('#preloader').fadeOut('slow', function () {
//            $(this).remove();
//        });
//    });
//});


function comlogo(event) {

    var comp_logo = document.getElementById("comp_logo").value;

    var complogo_ext = comp_logo.split('.').pop();

    var allowes = ['jpg', 'jpeg', 'png'];
    var foundPresent = $.inArray(complogo_ext, allowes) > -1;

    if (comp_logo == '') {

    } else {

        if (foundPresent == false)
        { //alert("hh");
            $(".com_logo").html("Please select only image file.");
            document.getElementById('com_logo').style.display = "block"
            event.preventDefault();
            return false;

        } else {

            document.getElementById('com_logo').style.display = "none"
        }
    }

}

//DELETE LOGO START
function delete_logo(id, logo) {

    $('.biderror .mes').html('<div class="message"><div class="pop_content">Are you sure you want to Remove this Logo?<div class="model_ok_cancel"><a class="okbtn" id="delete"  href="javascript:void(0);" data-dismiss="modal">Ok</a><a class="cnclbtn" href="javascript:void(0);" data-dismiss="modal">Cancel</a></div></div></div>');
    $('#bidmodal').modal('show');
    //$.fancybox.open('<div class="message"><h2>Are you sure you want to Remove this Logo?</h2><a id="delete" class="mesg_link btn" >OK</a><button data-fancybox-close="" class="btn">Cancel</button></div>');

    $('.message #delete').on('click', function () {
        $.ajax({
            type: 'POST',
            url: base_url + "recruiter/delete_logo",
            data: 'id=' + id + '&logo=' + logo,
            success: function (data) {

                if (data == 1)
                {
                    //$.fancybox.close();
                    $('#bidmodal').modal('hide');
                    $('#logo_remove a').remove();
                    $('#logo_remove img').remove();
                    $('#logo').remove();
                }

            }
        });

    });
}
//DELETE LOGO END


