$(document).ready(function () {

    // $('.ajax_load').hide();
     
    
    $("#address").find("select").each(function (i) {
        if ($(this).val() != '') {
            $(this).addClass("color-black-custom");
        }
    });
     
    $('#country').on('change', function () {
        var countryID = $(this).val();
        if (countryID) {
            $.ajax({
                type: 'POST',
                url: base_url + "artist/ajax_data",
                //url:'<?php echo base_url() . "artist/ajax_data"; ?>',
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
                url: base_url + "artist/ajax_data",
                //url:'<?php echo base_url() . "artist/ajax_data"; ?>',
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


function reg_loader(){

      var form = $("#address");
    if(form.valid() == true ){
      //$('#profilereg_ajax_load').show();
     document.getElementById('profilereg_ajax_load').style.display = 'inline-block';
    }

}

$(document).ready(function () {

    $("#address").validate({

        rules: {

            country: {

                required: true,

            },

            state: {

                required: true,

            },
            city: {

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
            city: {

                required: "City is required.",

            },

        },

    });
});


// $(".alert").delay(3200).fadeOut(300);


jQuery(document).ready(function ($) {
    $(window).load(function () {
        $('#preloader').fadeOut('slow', function () {
            $(this).remove();
        });
    });
});



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


$(document).ready(function () {
    var input = $("#pincode");
    var len = input.val().length;
    input[0].focus();
    input[0].setSelectionRange(len, len);
});