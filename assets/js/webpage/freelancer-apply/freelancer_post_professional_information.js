//SKILL VALIDATION START
function imgval() {
    var skill_main = document.getElementById("skill1").value;
    var skill_other = document.getElementById("otherskill").value;
    if (skill_main == '' && skill_other == '') {
        $($("#skill1").select2("container")).addClass("keyskill_border_active");
    }
}
//SKILL VALIDATION END
//FORM FILL UP VALIDATION START
//validation for edit email formate form

jQuery.validator.addMethod("noSpace", function (value, element) {
    return value == '' || value.trim().length != 0;
}, "No space please and don't leave it empty");

$.validator.addMethod("regx", function (value, element, regexpr) {
    return regexpr.test(value);
}, "Only space, only number and only specila characters are not allow");

$(document).ready(function () {

    $("#freelancer_post_professional").validate({
        ignore: '*:not([name])',
        //  ignore: ":hidden",
        groups: {
            experience_year: "experience_year experience_month"
        },
        errorPlacement: function (error, element) {
            if (element.attr('name') == 'experience_year' || element.attr('name') == 'experience_month')
                error.insertAfter('#experience_month');
        },
        rules: {

            field: {
                required: true,
            },
            area: {
                required: true,
            },

            'skills[]': {
                require_from_group: [1, ".keyskil"],
                regx: /^["-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
            },

            skill_description: {
                required: true,
                regx: /^["-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
            },
            experience_year: {
                require_from_group: [1, ".day"]
            },

            experience_month: {
                require_from_group: [1, ".day"],

            }

        },

        messages: {

            field: {
                required: "This field is required.",
            },

            area: {
                required: "Area is required.",
            },

            'skills[]': {
                require_from_group: "You must either fill out 'skills' or 'Other Skills'"
            },

            otherskill: {
                require_from_group: "You must either fill out 'skills' or 'Other Skills'"
            },

            skill_description: {
                required: "Skill description is required.",
            },
            experience_year: {
                require_from_group: "You must either fill out 'experience year' or 'experience month'"
            },
            experience_month: {
                require_from_group: "You must either fill out 'experience year' or 'experience month'"
            },
        }

    });
});
//FORM FILL UP VALIDATION END
//FLASH MESSAGE SCRIPT START
$(".alert").delay(3200).fadeOut(300);
//FLASH MESSAGE SCRIPT END
//CODE FOR PREELOADER START
jQuery(document).ready(function ($) {
    $(window).load(function () {
        $('#preloader').fadeOut('slow', function () {
            $(this).remove();
        });
    });
});
//CODE FOR PREELOADER END
//CHECK SEARCH KEYWORD AND LOCATION BLANK START
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
//CHECK SEARCH KEYWORD AND LOCATION BLANK END
//COPY-PASTE CODE START
var _onPaste_StripFormatting_IEPaste = false;
function OnPaste_StripFormatting(elem, e) {
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
//COPY-PASTE CODE END
////CODE FOR SKILL SELECTED START
//                if (complex != '')
//                {
//                    $("#skill1").select2({
//                        placeholder: "Select a Language",
//                    }).select2('val', complex);
//                }
//                if (complex == '')
//                {
//                    $("#skill1").select2({
//                        placeholder: "Select a Language",
//
//                    });
//                }
////CODE FOR SKILL SELECTED END
//NEW SCRIPT FOR SKILL START

$(function () {
    function split(val) {
        return val.split(/,\s*/);
    }
    function extractLast(term) {
        return split(term).pop();
    }
    $("#skills1").bind("keydown", function (event) {
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

// SCRIPT FOR ADD OTHER FIELD  START
$(document).on('change', '.field_other', function (event) {

    var item = $(this);
    var other_field = (item.val());

    if (other_field == 15) {
        item.val('');
        $.fancybox.open('<div class="message" style="width:300px;"><h2>Add Field</h2><input type="text" name="other_field" id="other_field" onkeypress="return remove_validation()"><div class="fw"><a id="field" class="btn">OK</a></div></div>');
        $('.message #field').on('click', function () {
            $("#other_field").removeClass("keyskill_border_active");
            $('#field_error').remove();
            var x = $.trim(document.getElementById("other_field").value);
            if (x == '') {
                $("#other_field").addClass("keyskill_border_active");
                $('<span class="error" id="field_error" style="float: right;color: red; font-size: 11px;">Empty Field  is not valid</span>').insertAfter('#other_field');
                return false;
            } else {
                var $textbox = $('.message').find('input[type="text"]'),
                        textVal = $textbox.val();
                $.ajax({
                    type: 'POST',
                    url: base_url + "freelancer/freelancer_other_field",
                    dataType: 'json',
                    data: 'other_field=' + textVal,
                    success: function (response) {

                        if (response.select == 0)
                        {
//                        $.fancybox.open('<div class="message"><h2>Written field already available in Field Selection</h2><button data-fancybox-close="" class="btn">OK</button></div>');
                            $("#other_field").addClass("keyskill_border_active");
                            $('<span class="error" id="field_error" style="float: right;color: red; font-size: 11px;">Written field already available in Field Selection</span>').insertAfter('#other_field');
                        } else if (response.select == 1)
                        {
                            $("#other_field").addClass("keyskill_border_active");
                            $('<span class="error" id="field_error" style="float: right;color: red; font-size: 11px;">Empty Field  is not valid</span>').insertAfter('#other_field');
//                            $.fancybox.open('<div class="message"><h2>Empty Field  is not valid</h2><button data-fancybox-close="" class="btn">OK</button></div>');
                        } else
                        {
                            $.fancybox.close();

                            $('.field_other').html(response.select);
                        }
                    }
                });
            }

        });
    }

});

function remove_validation() {

    $("#other_field").removeClass("keyskill_border_active");
    $('#field_error').remove();

}
//SCRIPT FOR ADD OTHER FILED END
