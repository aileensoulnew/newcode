
//Validation Start
$(document).ready(function () {

    $('.ajax_load').hide();
    var name = [];
    $("#jobseeker_regform1").find("select").each(function (i) {
        name[i] = $(this).attr('id');
        if ($(this).val() != null) {
            $(this).addClass("color-black-custom");
        }
    });
    $.validator.addMethod("regx1", function (value, element, regexpr) {

        if (!value)
        {
            return true;
        } else
        {
            return regexpr.test(value);
        }
    }, "Only space, only number and only special characters are not allow");

    //PHONE NUMBER VALIDATION FUNCTION   
    $.validator.addMethod("matches", function (value, element, regexpr) {
        if (!value)
        {
            return true;
        } else
        {
            return regexpr.test(value);
        }
        // return regexpr.test(value);
    }, "Phone number is not in proper format");
    //PHONE NUMBER VALIDATION FUNCTION END



    $("#jobseeker_regform1").validate({

        //  ignore: ":hidden",
        ignore: [],

        rules: {

            'jobtitle[]': {
                required: true,
                regx1: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
            },
            'companyname[]': {

                required: true,
                regx1: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
            },

            'experience_year[]': {

                required: true
            },

            'experience_month[]': {

                required: true
            },

            'companyemail[]': {
                email: true,
            },
            'companyphn[]': {

                minlength: 8,
                maxlength: 15,
                matches: /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/,
            },

        },
//        groups: {
//            expyear: "experience_year[] experience_month[]"
//        },
        messages: {

            'jobtitle[]': {

                required: "Job title is required.",
            },
            'companyname[]': {

                required: "Company name is required.",
            },
            'experience_year[]': {

                required: "Experience is required.",
            },
            'experience_month[]': {

                required: "Experience is required.",
            },
            'companyemail[]': {

                email: "Please enter valid email id.",
            },

        }

    });
});


function profile_reg() {

    var form = $("#jobseeker_regform");
    if (form.valid() == true) {
        //$('#fre_ajax_load').show();
        document.getElementById('fre_ajax_load').style.display = 'inline-block';
    }
}

function profile_reg1() {

    var form = $("#jobseeker_regform1");
    if (form.valid() == true) {
        //$('#exp_ajax_load').show();
        document.getElementById('exp_ajax_load').style.display = 'inline-block';
    }
}

$(document).ready(function () {

    $.validator.addMethod("regx", function (value, element, regexpr) {
        return regexpr.test(value);
    }, "Only space, only number and only special characters are not allow");

    $("#jobseeker_regform").validate({

        ignore: ":hidden",

        rules: {

            'radio': {
                required: true,
            }

        },
        messages: {

            'radio': {

                required: "Please tick mark fresher or fill experience",
            },

        }

    });
});

//Validation End

//for 0 year select disable 0 month start
function expyear_change() {

    var num = $('.clonedInput').length;

    if (num == 1)
    {

        var experience_year = document.getElementById('experience_year').value;
        //first if is used for disble exp_month disable
        if (experience_year)
        {
            $('#experience_month').attr('disabled', false);
            //this if is used for disable 0 month disable
            if (experience_year === '0 year') {
                $("#experience_month option[value='0 month']").attr('disabled', true);
            } else {
                $("#experience_month option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#experience_month').attr('disabled', 'disabled');
        }
    }

    if (num == 2)
    {

        var experience_year = document.getElementById('experience_year').value;
        var experience_year2 = document.getElementById('experience_year2').value;

        if (experience_year)
        {
            $('#experience_month').attr('disabled', false);

            if (experience_year === '0 year') {
                $("#experience_month option[value='0 month']").attr('disabled', true);
            } else {
                $("#experience_month option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#experience_month').attr('disabled', 'disabled');
        }

        if (experience_year2)
        {
            $('#experience_month2').attr('disabled', false);

            if (experience_year2 === '0 year') {
                $("#experience_month2 option[value='0 month']").attr('disabled', true);
            } else {
                $("#experience_month2 option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#experience_month2').attr('disabled', 'disabled');
        }
    }

    if (num == 3)
    {
        var experience_year = document.getElementById('experience_year').value;
        var experience_year2 = document.getElementById('experience_year2').value;
        var experience_year3 = document.getElementById('experience_year3').value;
        if (experience_year)
        {
            $('#experience_month').attr('disabled', false);

            if (experience_year === '0 year') {
                $("#experience_month option[value='0 month']").attr('disabled', true);
            } else {
                $("#experience_month option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#experience_month').attr('disabled', 'disabled');
        }

        if (experience_year2)
        {
            $('#experience_month2').attr('disabled', false);

            if (experience_year2 === '0 year') {
                $("#experience_month2 option[value='0 month']").attr('disabled', true);
            } else {
                $("#experience_month2 option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#experience_month2').attr('disabled', 'disabled');
        }

        if (experience_year3)
        {
            $('#experience_month3').attr('disabled', false);

            if (experience_year3 === '0 year') {
                $("#experience_month3 option[value='0 month']").attr('disabled', true);
            } else {
                $("#experience_month3 option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#experience_month3').attr('disabled', 'disabled');
        }
    }

    if (num == 4)
    {
        var experience_year = document.getElementById('experience_year').value;
        var experience_year2 = document.getElementById('experience_year2').value;
        var experience_year3 = document.getElementById('experience_year3').value;
        var experience_year4 = document.getElementById('experience_year4').value;

        if (experience_year)
        {
            $('#experience_month').attr('disabled', false);

            if (experience_year === '0 year') {
                $("#experience_month option[value='0 month']").attr('disabled', true);
            } else {
                $("#experience_month option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#experience_month').attr('disabled', 'disabled');
        }

        if (experience_year2)
        {
            $('#experience_month2').attr('disabled', false);

            if (experience_year2 === '0 year') {
                $("#experience_month2 option[value='0 month']").attr('disabled', true);
            } else {
                $("#experience_month2 option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#experience_month2').attr('disabled', 'disabled');
        }

        if (experience_year3)
        {
            $('#experience_month3').attr('disabled', false);

            if (experience_year3 === '0 year') {
                $("#experience_month3 option[value='0 month']").attr('disabled', true);
            } else {
                $("#experience_month3 option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#experience_month3').attr('disabled', 'disabled');
        }

        if (experience_year4)
        {
            $('#experience_month4').attr('disabled', false);

            if (experience_year4 === '0 year') {
                $("#experience_month4 option[value='0 month']").attr('disabled', true);
            } else {
                $("#experience_month4 option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#experience_month4').attr('disabled', 'disabled');
        }
    }

    if (num == 5)
    {
        var experience_year = document.getElementById('experience_year').value;
        var experience_year2 = document.getElementById('experience_year2').value;
        var experience_year3 = document.getElementById('experience_year3').value;
        var experience_year4 = document.getElementById('experience_year4').value;
        var experience_year5 = document.getElementById('experience_year5').value;

        if (experience_year)
        {
            $('#experience_month').attr('disabled', false);

            if (experience_year === '0 year') {
                $("#experience_month option[value='0 month']").attr('disabled', true);
            } else {
                $("#experience_month option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#experience_month').attr('disabled', 'disabled');
        }

        if (experience_year2)
        {
            $('#experience_month2').attr('disabled', false);

            if (experience_year2 === '0 year') {
                $("#experience_month2 option[value='0 month']").attr('disabled', true);
            } else {
                $("#experience_month2 option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#experience_month2').attr('disabled', 'disabled');
        }

        if (experience_year3)
        {
            $('#experience_month3').attr('disabled', false);

            if (experience_year3 === '0 year') {
                $("#experience_month3 option[value='0 month']").attr('disabled', true);
            } else {
                $("#experience_month3 option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#experience_month3').attr('disabled', 'disabled');
        }

        if (experience_year4)
        {
            $('#experience_month4').attr('disabled', false);

            if (experience_year4 === '0 year') {
                $("#experience_month4 option[value='0 month']").attr('disabled', true);
            } else {
                $("#experience_month4 option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#experience_month4').attr('disabled', 'disabled');
        }

        if (experience_year5)
        {
            $('#experience_month5').attr('disabled', false);

            if (experience_year5 === '0 year') {
                $("#experience_month5 option[value='0 month']").attr('disabled', true);
            } else {
                $("#experience_month5 option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#experience_month5').attr('disabled', 'disabled');
        }

    }

}


function expyear_change_edittime() {

    var num = $('.clonedInput').length;

    if (num == 1)
    {
        var experience_year = document.querySelector("#input1 #experience_year").value;

        if (experience_year)
        {
            $('#input1 #experience_month').attr('disabled', false);

            var experience_year = document.getElementById('experience_year').value;
            if (experience_year === '0 year') {
                $("#input1 #experience_month option[value='0 month']").attr('disabled', true);
            } else {
                $("#input1 #experience_month option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#input1 #experience_month').attr('disabled', 'disabled');
        }
    }

    if (num == 2)
    {

        var experience_year = document.querySelector("#input1 #experience_year").value;
        var experience_year2 = document.querySelector("#input2 #experience_year2").value;

        if (experience_year)
        {
            $('#input1 #experience_month').attr('disabled', false);

            if (experience_year === '0 year') {
                $("#input1 #experience_month option[value='0 month']").attr('disabled', true);
            } else {
                $("#input1 #experience_month option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#input1 #experience_month').attr('disabled', 'disabled');
        }

        if (experience_year2)
        {
            $('#input2 #experience_month2').attr('disabled', false);
            if (experience_year2 === '0 year') {
                $("#input2 #experience_month2 option[value='0 month']").attr('disabled', true);
            } else {
                $("#input2 #experience_month2 option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#input2 #experience_month2').attr('disabled', 'disabled');
        }
    }

    if (num == 3)
    {
        var experience_year = document.querySelector("#input1 #experience_year").value;
        var experience_year2 = document.querySelector("#input2 #experience_year2").value;
        var experience_year3 = document.querySelector("#input3 #experience_year3").value;

        if (experience_year)
        {

            $('#input1 #experience_month').attr('disabled', false);

            if (experience_year === '0 year') {

                $("#input1 #experience_month option[value='0 month']").attr('disabled', true);
            } else {

                $("#input1 #experience_month option[value='0 month']").attr('disabled', false);
            }
        } else
        {

            $('#input1 #experience_month').attr('disabled', 'disabled');
        }

        if (experience_year2)
        {

            $('#input2 #experience_month2').attr('disabled', false);

            if (experience_year2 === '0 year') {

                $("#input2 #experience_month2 option[value='0 month']").attr('disabled', true);
            } else {

                $("#input2 #experience_month2 option[value='0 month']").attr('disabled', false);
            }
        } else
        {

            $('#input2 #experience_month2').attr('disabled', 'disabled');
        }

        if (experience_year3)
        {
            $('#input3 #experience_month3').attr('disabled', false);

            if (experience_year3 === '0 year') {
                $("#input3 #experience_month3 option[value='0 month']").attr('disabled', true);
            } else {
                $("#input3 #experience_month3 option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#input3 #experience_month3').attr('disabled', 'disabled');
        }
    }

    if (num == 4)
    {
        var experience_year = document.querySelector("#input1 #experience_year").value;
        var experience_year2 = document.querySelector("#input2 #experience_year2").value;
        var experience_year3 = document.querySelector("#input3 #experience_year3").value;
        var experience_year4 = document.querySelector("#input4 #experience_year4").value;

        if (experience_year)
        {
            $('#input1 #experience_month').attr('disabled', false);

            if (experience_year === '0 year') {
                $("#input1 #experience_month option[value='0 month']").attr('disabled', true);
            } else {
                $("#input1 #experience_month option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#input1 #experience_month').attr('disabled', 'disabled');
        }

        if (experience_year2)
        {
            $('#input2 #experience_month2').attr('disabled', false);
            if (experience_year2 === '0 year') {
                $("#input2 #experience_month2 option[value='0 month']").attr('disabled', true);
            } else {
                $("#input2 #experience_month2 option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#input2 #experience_month2').attr('disabled', 'disabled');
        }

        if (experience_year3)
        {
            $('#input3 #experience_month3').attr('disabled', false);
            if (experience_year3 === '0 year') {
                $("#input3 #experience_month3 option[value='0 month']").attr('disabled', true);
            } else {
                $("#input3 #experience_month3 option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#input3 #experience_month3').attr('disabled', 'disabled');
        }

        if (experience_year4)
        {
            $('#input4 #experience_month4').attr('disabled', false);

            if (experience_year4 === '0 year') {
                $("#input4 #experience_month4 option[value='0 month']").attr('disabled', true);
            } else {
                $("#input4 #experience_month4 option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#input4 #experience_month4').attr('disabled', 'disabled');
        }
    }

    if (num == 5)
    {
        var experience_year = document.querySelector("#input1 #experience_year").value;
        var experience_year2 = document.querySelector("#input2 #experience_year2").value;
        var experience_year3 = document.querySelector("#input3 #experience_year3").value;
        var experience_year4 = document.querySelector("#input4 #experience_year4").value;
        var experience_year5 = document.querySelector("#input5 #experience_year5").value;

        if (experience_year)
        {
            $('#input1 #experience_month').attr('disabled', false);

            if (experience_year === '0 year') {
                $("#input1 #experience_month option[value='0 month']").attr('disabled', true);
            } else {
                $("#input1 #experience_month option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#input1 #experience_month').attr('disabled', 'disabled');
        }

        if (experience_year2)
        {
            $('#input2 #experience_month2').attr('disabled', false);

            if (experience_year2 === '0 year') {
                $("#input2 #experience_month2 option[value='0 month']").attr('disabled', true);
            } else {
                $("#input2 #experience_month2 option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#input2 #experience_month2').attr('disabled', 'disabled');
        }

        if (experience_year3)
        {
            $('#input3 #experience_month3').attr('disabled', false);

            if (experience_year3 === '0 year') {
                $("#input3 #experience_month3 option[value='0 month']").attr('disabled', true);
            } else {
                $("#input3 #experience_month3 option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#input3 #experience_month3').attr('disabled', 'disabled');
        }

        if (experience_year4)
        {
            $('#input4 #experience_month4').attr('disabled', false);

            if (experience_year4 === '0 year') {
                $("#input4 #experience_month4 option[value='0 month']").attr('disabled', true);
            } else {
                $("#input4 #experience_month4 option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#input4 #experience_month4').attr('disabled', 'disabled');
        }

        if (experience_year5)
        {
            $('#input5 #experience_month5').attr('disabled', false);
            if (experience_year5 === '0 year') {
                $("#input5 #experience_month5 option[value='0 month']").attr('disabled', true);
            } else {
                $("#input5 #experience_month5 option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#input5 #experience_month5').attr('disabled', 'disabled');
        }
    }
}
//for 0 year select disable 0 month end

//Clone input type start
$('#btnRemove').attr('disabled', 'disabled');
$('#btnAdd').click(function () {
    $('#btnAdd').removeAttr('disabled', 'disabled');
    var num = $('.clonedInput').length;

    var newNum = new Number(num + 1);

    if (newNum > 5)
    {
        $('#btnAdd').attr('disabled', 'disabled');
        alert("You Can add only 5 fields");
        return false;
    }

    // new code end
    var newElem = $('#input' + num).clone().attr('id', 'input' + newNum);

    newElem.children('.exp_data').attr('id', 'exp_data' + newNum).attr('name', 'exp_data[]').attr('value', 'new');
    newElem.children('.experience_year').attr('id', 'experience_year' + newNum).attr('name', 'experience_year[]').val();
    newElem.children('.experience_month').attr('id', 'experience_month' + newNum).attr('name', 'experience_month[]').val();
    newElem.children('.jobtitle').attr('id', 'jobtitle' + newNum).attr('name', 'jobtitle[]');
    newElem.children('.companyname').attr('id', 'companyname' + newNum).attr('name', 'companyname[]');
    newElem.children('.companyemail').attr('id', 'companyemail' + newNum).attr('name', 'companyemail[]');
    newElem.children('.companyphn').attr('id', 'companyphn' + newNum).attr('name', 'companyphn[]');
    newElem.children('.certificate').attr('id', 'certificate' + newNum).attr('name', 'certificate[]').val();
    $('#input' + num).after(newElem);
    $('#btnRemove').removeAttr('disabled', 'disabled');
    $('#input' + newNum + ' .experience_year').val('');
    $('#input' + newNum + ' .experience_month').val('');
    $('#input' + newNum + ' .experience_month').attr("disabled", "disabled");
    $('#input' + newNum + ' .certificate').val('');

    $('#input' + newNum + ' .hs-submit').remove();
    $("#input" + newNum + ' img').remove();
    $("#input" + newNum + ' i').remove();
    $("#input" + newNum + ' .img_work_exp').remove();


});

$('#btnRemove').on('click', function () {
    $('#btnAdd').removeAttr('disabled', 'disabled');
    var num = $('.clonedInput').length;
    if (num - 1 == clone_mathod_count)
    {

        $('#btnRemove').attr('disabled', 'disabled');
    }
    $('.clonedInput').last().remove();
});
$('#btnAdd').on('click', function () {

    $('.clonedInput').last().add().find("input:text").val("");
});
// Clone input type End

//Get the element with id="defaultOpen" and click on it start
function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent1");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active2", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active2";
}
//Get the element with id="defaultOpen" and click on it end

//DELETE JOB WORK EXP CLONE START
function delete_job_work(work_id, certificate) {

    $('.biderror .mes').html('<div class="message"><h2>Are you sure you want to delete this work experience?</h2><a id="delete" class="mesg_link btn" >OK</a><button data-fancybox-close="" class="btn">Cancel</button></div>');
    $('#bidmodal').modal('show');
    //$.fancybox.open('<div class="message"><h2>Are you sure you want to delete this work experience?</h2><a id="delete" class="mesg_link btn" >OK</a><button data-fancybox-close="" class="btn">Cancel</button></div>');

    $('.message #delete').on('click', function () {

        $.ajax({
            type: 'POST',
            url: base_url + 'job/job_work_delete',
            data: 'work_id=' + work_id + '&certificate=' + certificate,
            success: function (data) {
                if (data == 1)
                {
                    //$.fancybox.close();
                    $('#bidmodal').modal('hide');
                    $('.job_work_edit_' + work_id).remove();

                }

            }
        });//$.ajax end
    });
}
//DELETE JOB WORK EXP CLONE END

//script for click on - change to + Start
$(document).ready(function () {

    $('#toggle').on('click', function () {

        if ($('#panel-heading').hasClass('active')) {

            $('#panel-heading').removeClass('active');

        } else {

            $('#panel-heading').addClass('active');

            $('#panel-heading1').removeClass('active');
        }
    });

    $('#toggle1').on('click', function () {

        if ($('#panel-heading1').hasClass('active')) {
            $('#panel-heading1').removeClass('active');
        } else {
            $('#panel-heading1').addClass('active');
            $('#panel-heading').removeClass('active');
        }
    });

});
//script for click on - change to + End

//for  Work Experience  certificate start
$(document).ready(function () {
    $(document).on('change', '#input1 .certificate', function () {

        var image = document.querySelector("#input1 .certificate").value;

        if (image != '')
        {
            var image_ext = image.split('.').pop();
            var allowesimage = ['jpg', 'png', 'jpeg', 'gif', 'pdf'];
            var foundPresentImage = $.inArray(image_ext, allowesimage) > -1;
            if (foundPresentImage == false)
            {
                $("#input1 .bestofmine_image_degree").html("Please select only image file & pdf file.");
                return false;
            } else
            {

                $("#input1 .bestofmine_image_degree").html(" ");
                return true;
            }
        }
    });
    $("#jobseeker_regform1").submit(function () {
        var text = $('#input1 .bestofmine_image_degree').text();
        if (text == "Please select only image file & pdf file.")
        {
            return false;
        } else
        {
            return true;
        }

    });

    $(document).on('change', '#input2 .certificate', function () {

        var image = document.querySelector("#input2 .certificate").value;
        if (image != '')
        {
            var image_ext = image.split('.').pop();
            var allowesimage = ['jpg', 'png', 'jpeg', 'gif', 'pdf'];
            var foundPresentImage = $.inArray(image_ext, allowesimage) > -1;
            if (foundPresentImage == false)
            {
                $("#input2 .bestofmine_image_degree").html("Please select only image file & pdf file.");
                return false;
            } else
            {
                $("#input2 .bestofmine_image_degree").html(" ");
                return true;
            }
        }
    });
    $("#jobseeker_regform1").submit(function () {
        var text = $('#input2 .bestofmine_image_degree').text();
        if (text == "Please select only image file & pdf file.")
        {
            return false;
        } else
        {
            return true;
        }

    });



    $(document).on('change', '#input3 .certificate', function () {
        var image = document.querySelector("#input3 .certificate").value;


        if (image != '')
        {
            var image_ext = image.split('.').pop();
            var allowesimage = ['jpg', 'png', 'jpeg', 'gif', 'pdf'];
            var foundPresentImage = $.inArray(image_ext, allowesimage) > -1;
            if (foundPresentImage == false)
            {
                $("#input3 .bestofmine_image_degree").html("Please select only image file & pdf file.");
                return false;
            } else
            {
                $("#input3 .bestofmine_image_degree").html(" ");
                return true;
            }
        }
    });
    $("#jobseeker_regform1").submit(function () {
        var text = $('#input3 .bestofmine_image_degree').text();
        if (text == "Please select only image file & pdf file.")
        {
            return false;
        } else
        {
            return true;
        }

    });

    $(document).on('change', '#input4 .certificate', function () {

        var image = document.querySelector("#input4 .certificate").value;

        if (image != '')
        {
            var image_ext = image.split('.').pop();
            var allowesimage = ['jpg', 'png', 'jpeg', 'gif', 'pdf'];
            var foundPresentImage = $.inArray(image_ext, allowesimage) > -1;
            if (foundPresentImage == false)
            {
                $("#input4 .bestofmine_image_degree").html("Please select only image file & pdf file.");
                return false;
            } else
            {
                $("#input4 .bestofmine_image_degree").html(" ");
                return true;
            }
        }
    });
    $("#jobseeker_regform1").submit(function () {
        var text = $('#input4 .bestofmine_image_degree').text();
        if (text == "Please select only image file & pdf file.")
        {
            return false;
        } else
        {
            return true;
        }

    });

    $(document).on('change', '#input5 .certificate', function () {

        var image = document.querySelector("#input5 .certificate").value;

        if (image != '')
        {
            var image_ext = image.split('.').pop();
            var allowesimage = ['jpg', 'png', 'jpeg', 'gif', 'pdf'];
            var foundPresentImage = $.inArray(image_ext, allowesimage) > -1;
            if (foundPresentImage == false)
            {
                $("#input5 .bestofmine_image_degree").html("Please select only image file & pdf file.");
                return false;
            } else
            {
                $("#input5 .bestofmine_image_degree").html(" ");
                return true;
            }
        }
    });
    $("#jobseeker_regform1").submit(function () {
        var text = $('#input5 .bestofmine_image_degree').text();
        if (text == "Please select only image file & pdf file.")
        {
            return false;
        } else
        {
            return true;
        }

    });
});
//for Work Experience certificate End


//DELETE WORK EXPERIENCE CERTIFICATE START
function delete_workexp(work_id, certificate) {


    $('.biderror .mes').html('<div class="message"><h2>Are you sure you want to delete this experience certificate?</h2><a id="delete" class="mesg_link btn" >OK</a><button data-fancybox-close="" class="btn">Cancel</button></div>');
    $('#bidmodal').modal('show');

    //$.fancybox.open('<div class="message"><h2>Are you sure you want to delete this experience certificate?</h2><a id="delete" class="mesg_link btn" >OK</a><button data-fancybox-close="" class="btn">Cancel</button></div>');

    $('.message #delete').on('click', function () {
        $.ajax({
            type: 'POST',
            url: base_url + 'job/delete_workexp',
            data: 'work_id=' + work_id + '&certificate=' + certificate,
            success: function (data) {

                if (data == 1)
                {
                    //$.fancybox.close(); 
                    $('#bidmodal').modal('hide');
                    $('.job_work_edit_' + work_id + ' .img_work_exp a').remove();
                    $('.job_work_edit_' + work_id + ' .img_work_exp img').remove();
                    $('.job_work_edit_' + work_id + '  #work_certi').remove();
                }

            }
        });

    });
}
//DELETE WORK EXPERIENCE CERTIFICATE END

$(".alert").delay(3200).fadeOut(300);
// //FOR EXPERINACE NUMBER 1 START
//$(document).on('change', '#experience_year', function (event) {
//    var year = document.getElementById("experience_year").value;
//     $('#exp_year').val(year);
//     });
// $(document).on('change', '#experience_month', function (event) {
//    var month = document.getElementById("experience_month").value;
//     $('#exp_month').val(month);
//     });
//  //FOR EXPERINACE NUMBER 1 END
//     //FOR EXPERINACE NUMBER 2 START
//   $(document).on('change', '#experience_year2', function (event) {
//    var year1= document.getElementById("experience_year").value.split(' ');
//    var year2= document.getElementById("experience_year2").value.split(' ');
//     var year = parseInt(year1[0]) + parseInt(year2[0]) + ' year';
//     $('#exp_year').val(year);
//     });
//     $(document).on('change','#experience_month2',function(event){
//    var year1= document.getElementById("experience_year").value.split(' ');
//    var year2= document.getElementById("experience_year2").value.split(' ');
//    
//    var month1= document.getElementById("experience_month").value.split(' ');
//    var month2= document.getElementById("experience_month2").value.split(' ');
//    
//    var year = parseInt(year1[0]) + parseInt(year2[0]);
//    var month =  parseInt(month1[0]) + parseInt(month2[0]);
//    
//    if(month > 12){
//      var month =  month - 12 + ' month';
//      var year = year + 1 + ' year';
//    }
//    $('#exp_year').val(year);
//    $('#exp_month').val(month);
//    
//     });
//     //FOR EXPERIANCE NUMBER 2 END
//     //for experiance number 3 start
//     
//      $(document).on('change','#experience_year3',function(event){
//          var year1= document.getElementById("experience_year").value.split(' ');
//          var year2= document.getElementById("experience_year2").value.split(' ');
//          var year3= document.getElementById("experience_year3").value.split(' ');
//         
//      });
//    var year1= document.getElementById("experience_year").value.split(' ');
//    var month1= document.getElementById("experience_month").value.split(' ');
//    
//    if(yeart1[0] != '' )
//   
//    var year2= document.getElementById("experience_year2").value.split(' ');
//    var month2= document.getElementById("experience_month2").value.split(' ');
//    
//    var year3= document.getElementById("experience_year3").value.split(' ');
//    var month3= document.getElementById("experience_month3").value.split(' ');
//    
//    var year4= document.getElementById("experience_year4").value.split(' ');
//    var month4= document.getElementById("experience_month4").value.split(' ');
//   
//    var year5= document.getElementById("experience_year5").value.split(' ');
//    var month5= document.getElementById("experience_month5").value.split(' ');
//    
//    var month = parseInt(month1[0]) + parseInt(month2[0]) + parseInt(month3[0]) + parseInt(month4[0]) + parseInt(month5[0]);
//    
//    $('#exp_year').val(year1);
//    $('#exp_month').val(month1);

