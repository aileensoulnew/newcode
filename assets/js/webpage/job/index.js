
//javascript validation start 
$(document).ready(function () {

  $('.ajax_load').hide();
    // $.validator.addMethod("lowercase", function(value, element, regexpr) {          
    // return regexpr.test(value);
    // }, "Email should be in small character");

    $.validator.addMethod("regx", function (value, element, regexpr) {
        return regexpr.test(value);
    }, "Number, space and special character are not allowed");

    $.validator.addMethod("regx2", function (value, element, regexpr) {
        if (!value)
        {
            return true;
        } else
        {

            return regexpr.test(value);


        }
    }, "Special character and space not allow in the beginning");

    $.validator.addMethod("regx_digit", function (value, element, regexpr) {
        if (!value)
        {
            return true;
        } else
        {

            return regexpr.test(value);


        }
        // return regexpr.test(value);
    }, "Digit is not allow");



    jQuery.validator.addMethod("isValid", function (value, element) {

        var todaydate = new Date();
        var dd = todaydate.getDate();
        var mm = todaydate.getMonth() + 1; //January is 0!
        var yyyy = todaydate.getFullYear();

        if (dd < 10) {
            dd = '0' + dd
        }

        if (mm < 10) {
            mm = '0' + mm
        }

        var todaydate = yyyy + '-' + mm + '-' + dd;

        var one = new Date(value).getTime();
        var second = new Date(todaydate).getTime();

        if (one <= second)
        {
            $('.day').removeClass('error');
            $('.month').removeClass('error');
            $('.year').removeClass('error');
            return true;
        } else
        {

            $('.day').addClass('error');
            $('.month').addClass('error');
            $('.year').addClass('error');
            return false;
        }


    }, "Date Of birth should be less than Or equal to today date");

    $.validator.addMethod("required1", function (value, element, regexpr) {
        //return value == '' || value.trim().length != 0; 
        if (!value)
        {
            $('.day').addClass('error');
            $('.month').addClass('error');
            $('.year').addClass('error');
            return false;
        } else
        {
            return true;
        }

        // return regexpr.test(value);
    }, "Date of birth is required.");

    //date validation end


    //PHONE NUMBER VALIDATION FUNCTION START  
    $.validator.addMethod("matches", function (value, element, regexpr) {
        //return value == '' || value.trim().length != 0; 
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

    $("#jobseeker_regform").validate({

        ignore: ".language",
        rules: {

            fname: {

                required: true,
                regx2: /^[a-zA-Z0-9-.,']*[0-9a-zA-Z][a-zA-Z]*/,
                // regx_exp:/^([^@]*)$/,
                regx_digit: /^([^0-9]*)$/,
                // regx_exp:/\m(?:(\w)(?!\1))+\M/,

                //noSpace: true

            },

            lname: {

                required: true,
                regx2: /^[a-zA-Z0-9-.,']*[0-9a-zA-Z][a-zA-Z]*/,
                regx_digit: /^([^0-9]*)$/,
                //noSpace: true

            },

            email: {

                required: true,
                email: true,
                // lowercase: /^[0-9a-z\s\r\n@!#\$\^%&*()+=_\-\[\]\\\';,\.\/\{\}\|\":<>\?]+$/,
                remote: {
                    url: base_url + "job/check_email",
                    type: "post",
                },
            },

            phnno: {
                matches: /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/,
                minlength: 8,
                maxlength: 15,

            },

            language: {

                required: true,

            },
            city: {

                required: true,

            },
//                pincode: {
//   
//                   required: true,
//   
//               },
//                address: {
//   
//                   required: true,
//   
//               },
            dob: {

                required1: "date of birth is required.",
                isValid: 'Last date should be less than Or equal to today date',
            },
            gender: {

                required: true,

            },
        },

        messages: {

            fname: {

                required: "First name is required.",

            },

            lname: {

                required: "Last name is required.",

            },

            email: {

                required: "Email address is required.",
                email: "Please enter valid email id.",
                remote: "Email already exists"
            },
            phnno: {
                required: "Phone number is required.",
            },

            language: {

                required: "Language is required.",

            },
            city: {

                required: "City is required.",

            },
//                pincode: {
//   
//                   required: "Pincode is required.",
//   
//               },
//                address: {
//   
//                   required: "Address is required.",
//   
//               },

            gender: {

                required: "Gender is required.",

            },

        },

    });
});

// javascript validation End 
function profile_reg(){

    var form = $("#jobseeker_regform");
    if(form.valid() == true ){
     //$('#profilereg_ajax_load').show();
     document.getElementById('profilereg_ajax_load').style.display = 'inline-block';
    }
}

// FOr city data fetch start 

$(function () {
    function split(val) {
        return val.split(/,\s*/);
    }
    function extractLast(term) {
        return split(term).pop();
    }

    $("#city").bind("keydown", function (event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
                $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    })
            .autocomplete({
                minLength: 2,
                source: function (request, response) {
                    // delegate back to autocomplete, but extract the last term
                    $.getJSON(base_url + "general/get_location", {term: extractLast(request.term)}, response);
                },
                focus: function () {
                    // prevent value inserted on focus
                    return false;
                },

                select: function (event, ui) {
                    event.preventDefault();
                    $("#city").val(ui.item.label);
                    $("#selected-tag").val(ui.item.label);
                    // window.location.href = ui.item.value;
                },

            });
});


//FOr city data fetch End 
//new script for language start

$(function () {
    function split(val) {
        return val.split(/,\s*/);
    }
    function extractLast(term) {
        return split(term).pop();
    }

    $("#lan").bind("keydown", function (event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
                $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    })
            .autocomplete({
                minLength: 2,
                source: function (request, response) {
                    // delegate back to autocomplete, but extract the last term
                    $.getJSON(base_url + "general/get_language", {term: extractLast(request.term)}, response);
                },
                focus: function () {
                    // prevent value inserted on focus
                    return false;
                },
                select: function (event, ui) {

                    var terms = split(this.value);
                    if (terms.length <= 10) {
                        // remove the current input
                        terms.pop();
                        // add the selected item
                        terms.push(ui.item.value);
                        // add placeholder to get the comma-and-space at the end
                        terms.push("");
                        this.value = terms.join(", ");
                        return false;
                    } else {
                        var last = terms.pop();
                        $(this).val(this.value.substr(0, this.value.length - last.length - 2)); // removes text from input
                        $(this).effect("highlight", {}, 1000);
                        $(this).attr("style", "border: solid 1px red;");
                        return false;
                    }
                }



            });
});

//new script for language end

$(".alert").delay(3200).fadeOut(300);

$(function () {

    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();

    var today = yyyy;




    if (date_picker_edit != "1970-01-01" && date_picker_edit != "-0001-11-30") {
        $("#datepicker").dateDropdowns({
            submitFieldName: 'dob',
            submitFormat: "yyyy-mm-dd",
            minYear: 1821,
            maxYear: today,
            defaultDate: date_picker_edit,
            daySuffixes: false,
            monthFormat: "short",
            dayLabel: 'DD',
            monthLabel: 'MM',
            yearLabel: 'YYYY',
            //startDate: today,

        });
    } else
    {
        $("#datepicker").dateDropdowns({
            submitFieldName: 'dob',
            submitFormat: "yyyy-mm-dd",
            minYear: 1821,
            maxYear: today,
            defaultDate: date_picker,
            daySuffixes: false,
            monthFormat: "short",
            dayLabel: 'DD',
            monthLabel: 'MM',
            yearLabel: 'YYYY',
            //startDate: today,

        });
    }

});

$(function () {
    var input = $(".common-form input");
    var len = input.val().length;
    input[0].focus();
    input[0].setSelectionRange(len, len);
});

// THIS FUNCTION IS USED FOR PASTE SAME DESCRIPTION THAT COPIED START 

var _onPaste_StripFormatting_IEPaste = false;
function OnPaste_StripFormatting(elem, e) {
    // alert(456);
    if (e.originalEvent && e.originalEvent.clipboardData && e.originalEvent.clipboardData.getData) {
        e.preventDefault();
        var text = e.originalEvent.clipboardData.getData('text/plain');
        window.document.execCommand('insertText', false, text);
    } else if (e.clipboardData && e.clipboardData.getData) {
        e.preventDefault();
        var text = e.clipboardData.getData('text/plain');
        window.document.execCommand('insertText', false, text);
    } else if (window.clipboardData && window.clipboardData.getData) {
        // Stop stack overflow
        if (!_onPaste_StripFormatting_IEPaste) {
            _onPaste_StripFormatting_IEPaste = true;
            e.preventDefault();
            window.document.execCommand('ms-pasteTextOnly', false);
        }
        _onPaste_StripFormatting_IEPaste = false;
    }
}
