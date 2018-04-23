//NEW SCRIPT FOR SKILL START

$(function () {

    function split(val) {
        return val.split(/,\s*/);
    }
    function extractLast(term) {
        return split(term).pop();
    }
    $("#skills2").bind("keydown", function (event) {

        if (event.keyCode === $.ui.keyCode.TAB &&
                $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    })
            .autocomplete({
                minLength: 2,
                source: function (request, response) {
                    // delegate back to autocomplete, but extract the last term
                    $.getJSON(base_url + "general/get_skill", {term: extractLast(request.term)}, response);
                },
                focus: function () {
                    // prevent value inserted on focus
                    return false;
                },
                select: function (event, ui) {
                    var text = this.value;
                    var terms = split(this.value);
                    text = text == null || text == undefined ? "" : text;
                    var checked = (text.indexOf(ui.item.value + ', ') > -1 ? 'checked' : '');
                    if (checked == 'checked') {

                        terms.push(ui.item.value);
                        this.value = terms.split(", ");
                    }//if end
                    else {
                        if (terms.length <= 20) {
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
                }
            });
});

//NEW SCRIPT FOR SKILL END

// CHECK SEARCH KEYWORD AND LOCATION BLANK START
function checkvalue() {
    var searchkeyword = $.trim(document.getElementById('tags').value);
    var searchplace = $.trim(document.getElementById('searchplace').value);
    if (searchkeyword == "" && searchplace == "") {
        alert('Please enter Keyword');
        return false;
    }
}

function checkvalue_search() {
    var searchkeyword = $.trim(document.getElementById('tags').value);
    var searchplace = $.trim(document.getElementById('searchplace').value);
    if (searchkeyword == "" && searchplace == "")
    {
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
jQuery.validator.addMethod("noSpace", function (value, element) {
    return value == '' || value.trim().length != 0;
}, "No space please and don't leave it empty");

$.validator.addMethod("regx", function (value, element, regexpr) {
    //return value == '' || value.trim().length != 0; 
    if (!value)
    {
        return true;
    } else
    {
        return regexpr.test(value);
    }
}, "Only space, only number and only special characters are not allow");

// for date validtaion start
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

    if (one >= second) {
        return one >= second;
    }

    $('.day').addClass('error');
    $('.month').addClass('error');
    $('.year').addClass('error');
}, "Last date should be grater than and equal to today date");
//date validation end
//   validation border is not show in last date start
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
}, "Last Date of apply is required.");
//   validation border is not show in last date end

$(document).ready(function () {
    $("#postinfo").validate({
        ignore: '*:not([name])',
        rules: {
            post_name: {
                required: true,
                regx: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/

            },
            skills: {
                required: true,
                regx: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
            },
            fields_req: {
                required: true,
            },
            post_desc: {
                required: true,
                regx: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
            },
            last_date: {
                required1: true,
                isValid: 'Last date should be grater than and equal to today date'
            },

            country: {
                required: true,
            },
            state: {
                required: true,
            }

        },

        messages: {

            post_name: {
                required: "Project name is required.",
            },
            skills: {
                required: "Skill is required",
            },
            fields_req: {
                required: "Please select field of requirement",
            },

            post_desc: {
                required: "Project description  is required.",
            },
            last_date: {
                required: "Last date of apply is required.",
            },

            country: {
                required: "Please select country"
            },
            state: {
                required: "Please select state"
            }
        }
    });
});
// FORM FILL UP VALIDATION END
// CODE FOR COUNTRY,STATE, CITY CODE START
$(document).ready(function () {
    $('#country').on('change', function () {
        var countryID = $(this).val();
        alert(countryID);
        if (countryID) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . "freelancer/ajax_dataforcity"; ?>',
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
                url: '<?php echo base_url() . "freelancer/ajax_dataforcity"; ?>',
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
// CODE FOR COUNTRY,STATE, CITY CODE END

////SELECT2 AUTOCOMPLETE START FOR SKILL
//$('#skills').select2({
//    placeholder: 'Find Your Skills',
//    ajax: {
//        url: base_url + "freelancer/keyskill",
//        dataType: 'json',
//        delay: 250,
//        processResults: function (data) {
//            return {
//                results: data
//            };
//        },
//        cache: true
//    }
//});
////SELECT2 AUTOCOMPLETE FOR SKILL END

// SCRIPT FOR ADD OTHER FIELD  START
$(document).on('change', '.field_other', function (event) {

    var item = $(this);
    var other_field = (item.val());

    if (other_field == 15) {
        item.val('');
        $.fancybox.open('<div class="message"><h2>Add Field</h2><input type="text" name="other_field" id="other_field"><a id="field" class="btn">OK</a></div>');
        $('.message #field').on('click', function () {
            var $textbox = $('.message').find('input[type="text"]'),
                    textVal = $textbox.val();
            $.ajax({
                type: 'POST',
                url: base_url + "freelancer/freelancer_hire_other_field",
                dataType: 'json',
                data: 'other_field=' + textVal,
                success: function (response) {

                    if (response.select == 0)
                    {
                        $.fancybox.open('<div class="message"><h2>Written field already available in Field Selection</h2><button data-fancybox-close="" class="btn">OK</button></div>');
                    } else if (response.select == 1)
                    {
                        $.fancybox.open('<div class="message"><h2>Empty Field  is not valid</h2><button data-fancybox-close="" class="btn">OK</button></div>');
                    } else
                    {
                        $.fancybox.close();

                        $('.field_other').html(response.select);
                    }
                }
            });

        });
    }

});
//SCRIPT FOR ADD OTHER FILED END
//SCRIPT FOR DATE PICKER START
$(function () {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();
    var today = yyyy;
    var date_picker = date_picker1;
    $("#example2").dateDropdowns({
        submitFieldName: 'last_date',
        submitFormat: "yyyy-mm-dd",
        minYear: today,
        maxYear: today + 1,
        defaultDate: date_picker,
        daySuffixes: false,
        monthFormat: "short",
        dayLabel: 'DD',
        monthLabel: 'MM',
        yearLabel: 'YYYY',
        //startDate: today,

    });
    $(".day").attr('tabindex', 12);
    $(".month").attr('tabindex', 13);
    $(".year").attr('tabindex', 14);

});
//SCRIPT FOR DATE PIACKER END

