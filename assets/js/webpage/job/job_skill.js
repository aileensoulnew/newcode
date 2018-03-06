$(document).ready(function () {
     $('.ajax_load').hide();
      var name = [];
    $("#jobseeker_regform").find("select").each(function (i) {
        name[i] = $(this).attr('id');
        if ($(this).val() != '') {
            $(this).addClass("color-black-custom");
        }
    });
 });

function profile_reg(){

    var form = $("#jobseeker_regform");
    if(form.valid() == true ){
     //$('#profilereg_ajax_load').show();
     document.getElementById('profilereg_ajax_load').style.display = 'inline-block';
     
    }
}

//Validation Start
$.validator.addMethod("regx1", function (value, element, regexpr) {
    if (!value)
    {
        return true;
    } else
    {
        return regexpr.test(value);
    }
}, "Only space, only number and only special characters are not allow");

$("#jobseeker_regform").validate({

    rules: {

        industry: {

            required: true,

        },
        job_title: {

            required: true,
            regx1: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/,
        },

        skills: {
            required: true,
            regx1: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/,

        },
        cities: {

            required: true,
            regx1: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/,

        },
    },

    messages: {

        industry: {

            required: "Industry is required.",

        },

        job_title: {

            required: "Job title is required.",

        },

        skills: {

            required: "Skill is required.",

        },

        cities: {

            required: "City is required.",

        },
    },

});
//Validation End

//OTHER INDUSTRY INSERT START
$(document).on('change', '#industry', function (event) {

    var item = $(this);
    var industry = (item.val());

    if (industry == 288)
    {

        item.val('');

        $('.biderror1 .mes').html('<h2>Add Industry</h2><input type="text" name="other_indu" id="other_indu" onclick="return remove_validation();"><a id="indus" class="btn">OK</a>');
        $('#bidmodaladdin').modal('show');
        //$.fancybox.open('<div class="message" style="width:300px;"><h2>Add Industry</h2><input type="text" name="other_indu" id="other_indu"><a id="indus" class="btn">OK</a></div>');

        $('.message #indus').on('click', function () {

            $("#other_indu").removeClass("keyskill_border_active");
            $('#field_error').remove();
            var x = $.trim(document.getElementById("other_indu").value);
            if (x == '') {
                $("#other_indu").addClass("keyskill_border_active");
                $('<span class="error" id="field_error" style="float: right;color: red; font-size: 11px;">Empty Field  is not valid</span>').insertAfter('#other_indu');
                return false;
            } else {
                var $textbox = $('.message').find('input[type="text"]'),
                        textVal = $textbox.val();
                $.ajax({
                    type: 'POST',
                    url: base_url + 'job/job_other_industry',
                    data: 'other_industry=' + textVal,
                    success: function (response) {

                        if (response == 0)
                        {
                            $("#other_indu").addClass("keyskill_border_active");
                            $('<span class="error" id="field_error" style="float: right;color: red; font-size: 11px;">Written industry already available in industry Selection</span>').insertAfter('#other_indu');
                        } else if (response == 1)
                        {

                            $("#other_indu").addClass("keyskill_border_active");
                            $('<span class="error" id="field_error" style="float: right;color: red; font-size: 11px;">Empty industry  is not valid</span>').insertAfter('#other_indu');
                        } else
                        {
                            //$.fancybox.close();
                            $('#bidmodaladdin').modal('hide');
                            $('#industry').html(response);
                        }
                    }
                });
            }
        });
    }

});
//OTHER INDUSTRY INSERT END

function remove_validation() {
    $("#other_indu").removeClass("keyskill_border_active");
    $('#field_error').remove();

}
    $(document).on('keydown', function (e) {
                if (e.keyCode === 27) {
                    $('#bidmodaladdin').modal('hide');
            }
            });  
