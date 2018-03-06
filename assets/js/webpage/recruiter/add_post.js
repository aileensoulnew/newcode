$(function () {


    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();

    var today = yyyy;


    $("#example2").dateDropdowns({
        submitFieldName: 'last_date',
        submitFormat: "dd/mm/yyyy",
        minYear: today,
        maxYear: today + 1,
        daySuffixes: false,
        monthFormat: "short",
        dayLabel: 'DD',
        monthLabel: 'MM',
        yearLabel: 'YYYY',

        //startDate: today,

    });
    $(".day").attr('tabindex', 13);
    $(".day").attr('onChange', 'check_datevalidation();');
    $(".month").attr('tabindex', 14);
    $(".month").attr('onChange', 'check_datevalidation();');
    $(".year").attr('tabindex', 15);
    $(".year").attr('onChange', 'check_datevalidation();');

});



$("#post_name").blur(function(){
   $( "#ui-id-6 " ).addClass( "autoposition" );
});


function imgval() {
//
//    var skill_main = document.getElementById("skills").value;
//    var skill_other = document.getElementById("other_skill").value;
//
//
//    if (skill_main == '' && skill_other == '') {
//
//        $('#artpost .select2-selection').addClass("keyskill_border_active").style('border', '1px solid #f00');
//    }
}

$.validator.addMethod("regx", function (value, element, regexpr) {
    //return value == '' || value.trim().length != 0; 
    if (!value)
    {
        return true;
    } else
    {
        return regexpr.test(value);
    }
    // return regexpr.test(value);
}, "Only space, only number and only special characters are not allow.");

jQuery.validator.addMethod("noSpace", function (value, element) {
    return value == '' || value.trim().length != 0;
}, "No space please and don't leave it empty");

$.validator.addMethod("reg_candidate", function (value, element, regexpr) {
    return regexpr.test(value);
}, "Float Number Is Not Allowed");

//for min max value validator start

// $.validator.addMethod("greaterThan",
//     function (value, element, param) {


$.validator.addMethod("greaterThan",
        function (value, element, param) {
            var $otherElement = $(param);
            if (!value)
            {
                return true;
            } else
            {
                return parseInt(value, 10) > parseInt($otherElement.val(), 10);
            }
        });

$.validator.addMethod("greaterThan1",
        function (value, element, param) {
            var $min = $(param);
            if (this.settings.onfocusout) {
                $min.off(".validate-greaterThan").on("blur.validate-greaterThan", function () {
                    $(element).valid();
                });
            }
            if (!value)
            {
                return true;
            } else
            {
                return parseInt(value) > parseInt($min.val());
                //return (value) > ($min.val());
            }
        }, "Maximum experience must be greater than minimum experience.");



$.validator.addMethod("greaterThanmonth",
        function (value, element, param) {
            //alert(value); alert(element); alert(param);alert("#maxyear");
            var $maxyear = $('#maxyear');
            var maxyear = parseInt($maxyear.val());

            var $minyear = $('#minyear');
            var minyear = parseInt($minyear.val());

            var $min = $(param);
            if (this.settings.onfocusout) {
                $min.off(".validate-greaterThan").on("blur.validate-greaterThan", function () {
                    $(element).valid();
                });
            }
            if (!value)
            {
                return true;
            } else if ((maxyear == minyear))
            {
                //if((maxyear == minyear) ){// alert("gaai");
                return parseInt(value) >= parseInt($min.val());
            } else
            {
                return true;
            }

        }, "Max month must be greater than min month.");



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

    var todaydate = dd + '/' + mm + '/' + yyyy;

    var lastDate = $("input[name=last_date]").val();
    //alert(lastDate); alert(todaydate);

    lastDate = lastDate.split("/");
    var lastdata_new = lastDate[1] + "/" + lastDate[0] + "/" + lastDate[2];
    var lastdata_new_one = new Date(lastdata_new).getTime();

    todaydate = todaydate.split("/");
    var todaydate_new = todaydate[1] + "/" + todaydate[0] + "/" + todaydate[2];
    var todaydate_new_one = new Date(todaydate_new).getTime();

    if (lastdata_new_one > todaydate_new_one) {
       // $('.day').addClass('error');
        //$('.month').addClass('error');
       // $('.year').addClass('error');
        return true;
    } else { 
        $('.day').addClass('error');
        $('.month').addClass('error');
        $('.year').addClass('error');
        return false;
    }

    //return lastdata_new_one >= todaydate_new_one;
}, "Last date should be grater than or equal to today date.");

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
}, "Last date of apply is required.");
//   validation border is not show in last date end  
//pattern validation at salary start//
$.validator.addMethod("patternn", function (value, element, param) {
    if (this.optional(element)) {
        return true;
    }
    if (typeof param === "string") {
        param = new RegExp("^(?:" + param + ")$");
    }
    return param.test(value);
}, "Salary is not in correct format.");

//pattern validation at salary end//

$(document).ready(function () {

    $.validator.addMethod("regnum", function (value, element, regexpr) {
        return regexpr.test(value);
    }, "Please enter a valid pasword.");

    $("#artpost").validate({
        //ignore: [],

        ignore: '*:not([name])',
        rules: {

            post_name: {

                required: true,
                regx: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/,
//                minlength: 10,
                maxlength: 100

            },
            skills: {

                required: true,
                regx: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
            },

            position_no: {
                required: true,
                number: true,
                min: 1,
                reg_candidate: /^-?(([0-9]{0,1000}))$/,
                maxlength: 4,
                range: [1, 1000]
            },

            minyear: {

                required: true
            },

            post_desc: {

                required: true,
                maxlength: 2500

            },

            interview: {

                maxlength: 2500

            },

            country: {

                required: true

            },
            state: {

                required: true

            },
            maxyear: {

                required: true,
                greaterThan1: "#minyear"
                        //required:true 
            },

            emp_type: {

                required: true


            },
            industry: {

                required: true


            },

            // last_date: {

            //     required1: "Last date of apply is required.",
            //     isValid: 'Last date should be grater than and equal to today date.'

            // },
            minsal: {
//                // required: true,
//                //number:true,
               maxlength: 11,
                patternn: /^([0-9]\d*)(\\d+)?$/
//
            },
            maxsal: {
                // required: true,
             //   number: true,
                patternn: /^([0-9]\d*)(\\d+)?$/,
                min: 0,
                greaterThan: "#minsal",
                maxlength: 11
            },

        },

        messages: {

            post_name: {

                required: "Job title  is required."
            },
            skills: {

                required: "Skill  is required."
            },

            position_no: {
                required: "You have to select minimum 1 position."
            },
            minyear: {

                required: "Minimum experience is required."
            },

            post_desc: {

                required: "Post description is required."

            },
            country: {

                required: "Country is required."

            },
            state: {

                required: "State is required."

            },
            maxyear: {

                required: "Maximum experience is required."
                        // greaterThan1:"Maximum Year Experience should be grater than Minimum Year"

            },

            industry: {

                required: "Industry is required."
                        // greaterThan1:"Maximum Year Experience should be grater than Minimum Year"

            },

            emp_type: {

                required: "Employment type is required."
                        // greaterThan1:"Maximum Year Experience should be grater than Minimum Year"

            },

            // last_date: {

            //     required: "Last date for apply required."
            // },

            maxsal: {
                required: "Maximum salary is required.",
                greaterThan: "Maximum salary should be grater than minimum salary."
            },

            minsal: {
                required: "Minimum salary is required."
            },

        }

    });


});

//alert(data);



function check_datevalidation() {
    var day = $('.day').val();
    var month = $('.month').val();
    var year = $('.year').val();
    if (day == '' || month == '' || year == '') {
        if (day == '') {
            $('.day').addClass('error');
        }
        if (month == '') {
            $('.month').addClass('error');
        }
        if (year == '') {
            $('.year').addClass('error');
        }
        $('.date-dropdowns .last_date_error').remove();
        $('.date-dropdowns').append('<label for="example2" class="error last_date_error">Last Date of apply is required.</label>');
        return false;
        //<label for="example2" class="error">Last Date of apply is required.</label>
    } else {
        var todaydate = new Date();
        var dd = todaydate.getDate();
        var mm = todaydate.getMonth() + 1; //January is 0!
        var yyyy = todaydate.getFullYear();
        if (mm <= 9) { mm = 0 + mm.toString(); }
        var todaydate_in_str = yyyy.toString() + mm.toString() + dd.toString();


        var selected_date_in_str = "" + year + month + day;

        if (parseInt(todaydate_in_str) > parseInt(selected_date_in_str)) {
            $('.day').addClass('error');
            $('.month').addClass('error');
            $('.year').addClass('error');

            $('.date-dropdowns .last_date_error').remove();
            $('.date-dropdowns').append('<label for="example2" class="error last_date_error">Last date should be grater than and equal to today date</label>');
            return false;
        } else {
            $('.day').removeClass('error');
            $('.month').removeClass('error');
            $('.year').removeClass('error');
            $('.date-dropdowns .last_date_error').remove();
            return true;
        }
    }
}



$("form").submit(function () {

    var day = $('.day').val();
    var month = $('.month').val();
    var year = $('.year').val();
    if (day == '' || month == '' || year == '') {
        if (day == '') {
            $('.day').addClass('error');
        }
        if (month == '') {
            $('.month').addClass('error');
        }
        if (year == '') {
            $('.year').addClass('error');
        }
        $('.date-dropdowns .last_date_error').remove();
        $('.date-dropdowns').append('<label for="example2" class="last_date_error error-other" style="display: block;">Last Date of apply is required.</label>');
        return false;

    } else {
        var todaydate = new Date();
        var dd = todaydate.getDate();
        var mm = todaydate.getMonth() + 1; //January is 0!
        var yyyy = todaydate.getFullYear();

          if (mm <= 9) { mm = 0 + mm.toString(); }
          
        var todaydate_in_str = yyyy.toString() + mm.toString() + dd.toString();


        var selected_date_in_str = "" + year + month + day;

        if (parseInt(todaydate_in_str) > parseInt(selected_date_in_str)) {
            $('.day').addClass('error');
            $('.month').addClass('error');
            $('.year').addClass('error');

            $('.date-dropdowns .error').show();
            $('.date-dropdowns').append('<label for="example2" class="error last_date_error error-other">Last date should be grater than and equal to today date</label>');
            $('.date-dropdowns .last_date_error').removeAttr('style');
            return false;
        } else {
            $('.day').removeClass('error');
            $('.month').removeClass('error');
            $('.year').removeClass('error');
            $('.date-dropdowns .last_date_error').remove();
            return true;
        }
    }

});

// EDUCATION AUTOCOMPLETE DATA START

$(function () {
    function split(val) {
        return val.split(/,\s*/);
    }
    function extractLast(term) {
        return split(term).pop();
    }

    $("#education").bind("keydown", function (event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
                $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    })
            .autocomplete({
                minLength: 0,
                source: function (request, response) {
                    // delegate back to autocomplete, but extract the last term
                    $.getJSON(base_url + "general/get_degree", {term: extractLast(request.term)}, response);
                },
                focus: function () {
                    // prevent value inserted on focus
                    return false;
                },
                select: function (event, ui) {

                    var terms = split(this.value);
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



            });
});

// EDUCATION AUTOCOMPLETE DATA END


//$(function () {
//    // alert('hi');
//    $("#tags").autocomplete({
//        source: function (request, response) {
//            var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
//            response($.grep(data, function (item) {
//                return matcher.test(item.label);
//            }));
//        },
//        minLength: 1,
//        select: function (event, ui) {
//            event.preventDefault();
//            $("#tags").val(ui.item.label);
//            $("#selected-tag").val(ui.item.label);
//            // window.location.href = ui.item.value;
//        }
//        ,
//        focus: function (event, ui) {
//            event.preventDefault();
//            $("#tags").val(ui.item.label);
//        }
//    });
//});


//$(function () {
//    // alert('hi');
//    $("#searchplace").autocomplete({
//        source: function (request, response) {
//            var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
//            response($.grep(data1, function (item) {
//                return matcher.test(item.label);
//            }));
//        },
//        minLength: 1,
//        select: function (event, ui) {
//            event.preventDefault();
//            $("#searchplace").val(ui.item.label);
//            $("#selected-tag").val(ui.item.label);
//            // window.location.href = ui.item.value;
//        }
//        ,
//        focus: function (event, ui) {
//            event.preventDefault();
//            $("#searchplace").val(ui.item.label);
//        }
//    });
//});

//$(function () {
//    // alert('hi');
//    $("#tags1").autocomplete({
//        source: function (request, response) {
//            var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
//            response($.grep(data, function (item) {
//                return matcher.test(item.label);
//            }));
//        },
//        minLength: 1,
//        select: function (event, ui) {
//            event.preventDefault();
//            $("#tags1").val(ui.item.label);
//            $("#selected-tag").val(ui.item.label);
//            // window.location.href = ui.item.value;
//        }
//        ,
//        focus: function (event, ui) {
//            event.preventDefault();
//            $("#tags1").val(ui.item.label);
//        }
//    });
//});

//$(function () {
//    // alert('hi');
//    $("#searchplace1").autocomplete({
//        source: function (request, response) {
//            var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
//            response($.grep(data1, function (item) {
//                return matcher.test(item.label);
//            }));
//        },
//        minLength: 1,
//        select: function (event, ui) {
//            event.preventDefault();
//            $("#searchplace1").val(ui.item.label);
//            $("#selected-tag").val(ui.item.label);
//            // window.location.href = ui.item.value;
//        }
//        ,
//        focus: function (event, ui) {
//            event.preventDefault();
//            $("#searchplace1").val(ui.item.label);
//        }
//    });
//});

$(function () {

    $("#post_name").autocomplete({
        source: function (request, response) {
            var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
            response($.grep(jobdata, function (item) { 
                return matcher.test(item.label);
                $("#ui-id-1").addClass("autoposition");
            }));
        },
        minLength: 1,
        select: function (event, ui) {
            event.preventDefault();
            $("#post_name").val(ui.item.label);
            $("#selected-tag").val(ui.item.label);
            // window.location.href = ui.item.value;
        }
        ,
        focus: function (event, ui) {
            event.preventDefault();
            $("#post_name").val(ui.item.label);
        }
    });
});

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
                     $("#ui-id-7").addClass("autoposition");
                     $("#ui-id-1").addClass("autoposition");
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
                }//end else


            });
});

//function check() {
//    var keyword = $.trim(document.getElementById('tags1').value);
//    var place = $.trim(document.getElementById('searchplace1').value);
//    if (keyword == "" && place == "") {
//        return false;
//    }
//}

//function checkvalue() {
//alert("hi");

//    var searchkeyword = $.trim(document.getElementById('rec_search_title').value);
//    var searchplace = $.trim(document.getElementById('rec_search_loc').value);
// alert(searchkeyword);
// alert(searchplace);
//    if (searchkeyword == "" && searchplace == "") {
//alert('Please enter Keyword');
//        return false;
//    }
//}

//function checkvalue_search() {
//
//    var searchkeyword = $.trim(document.getElementById('tags').value);
//    var searchplace = $.trim(document.getElementById('searchplace').value);
//    // alert(searchkeyword);
//
//    if (searchkeyword == "" && searchplace == "")
//    {
//        //  alert('Please enter Keyword');
//        return false;
//    }
//}
//Leave Page on add and edit post page start

function home(clicked_id, searchkeyword, searchplace) {
    $('.biderror .mes').html("<div class='pop_content'> Do you want to leave this page?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='home_profile(" + clicked_id + ',' + '"' + searchkeyword + '"' + ',' + '"' + searchplace + '"' + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('#bidmodal').modal('show');
    document.getElementById('acon').style.display = 'block !important';
}

function home1(link) {
//        $('.biderror .mes').html("<div class='pop_content'> Do you want to leave this page?<div class='model_ok_cancel'><a class='okbtn' id='' onClick='window.location=" + link + "' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('.biderror .mes').html("<div class='pop_content'> Do you want to leave this page?<div class='model_ok_cancel'>Yes<a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
    $('#bidmodal').modal('show');

    document.getElementById('acon').style.display = 'block !important';
    return false;
}

function home_profile(clicked_id, searchkeyword, searchplace) {

    var url, data;


    if (clicked_id == 4) {
        url = base_url + "search/recruiter_search";


        data = 'id=' + clicked_id + '&skills=' + searchkeyword + '&searchplace=' + searchplace;

    }


    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function (data) {
            if (clicked_id == 1)
            {
                // alert("hsjdh");

                window.location = base_url + "recruiter/home";
            } else if (clicked_id == 2)
            {
                window.location = base_url + "recruiter/profile";
            } else if (clicked_id == 3)
            {
                window.location = base_url + "recruiter/basic-information";
            } else if (clicked_id == 4)
            {
                if (searchkeyword == "")
                {

                    window.location = base_url + "search/recruiter_search/" + 0 + "/" + searchplace;

                } else if (searchplace == "")
                {

                    window.location = base_url + "search/recruiter_search/" + searchkeyword + "/" + 0;
                } else
                {
                    window.location = base_url + "search/recruiter_search/" + searchkeyword + "/" + searchplace;
                }

            } else if (clicked_id == 5)
            {

                document.getElementById('acon').style.display = 'block';

            } else if (clicked_id == 6)
            {
                window.location = base_url + "profile";
            } else if (clicked_id == 7)
            {
                window.location = base_url + "registration/changepassword";
            } else if (clicked_id == 8)
            {
                window.location = base_url + "dashboard/logout";
            } else if (clicked_id == 9)
            {
                location.href = 'javascript:history.back()';
            } else
            {
                alert("edit profilw");
            }

        }
    });


}

var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
//    btn.onclick = function () {
//        modal.style.display = "block";
//    }

// When the user clicks on <span> (x), close the modal
//span.onclick = function () {
//    modal.style.display = "none";
//}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

function checkvalue(val)
{

    if (val == 1308)
    {
        document.getElementById("other_skill1").hidden = false;

        $('#other_skill').prop('required', true);
    } else
    {
        document.getElementById("other_skill1").hidden = true;

        $('#other_skill').prop('required', false);
    }


}


$(document).ready(function () {
    $('#country').on('change', function () {
        var countryID = $(this).val();

        if (countryID) {
            $.ajax({
                type: 'POST',
                url: base_url + "job_profile/ajax_data",
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
                url: base_url + "job_profile/ajax_data",
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

//$(document).ready(function () {

//Transforms the listbox visually into a Select2.
//    $("#lstColors").select2({
//        placeholder: "Select a Color",
//        width: "200px"
//    });

//Initialize the validation object which will be called on form submit.
//    var validobj = $("#frm").validate({
//        onkeyup: false,
//        errorClass: "myErrorClass",
//
//        //put error message behind each form element
//        errorPlacement: function (error, element) {
//            var elem = $(element);
//            error.insertAfter(element);
//        },
//
//        highlight: function (element, errorClass, validClass) {
//            var elem = $(element);
//            if (elem.hasClass("select2-offscreen")) {
//                $("#s2id_" + elem.attr("id") + " ul").addClass(errorClass);
//            } else {
//                elem.addClass(errorClass);
//            }
//        },

//When removing make the same adjustments as when adding
//        unhighlight: function (element, errorClass, validClass) {
//            var elem = $(element);
//            if (elem.hasClass("select2-offscreen")) {
//                $("#s2id_" + elem.attr("id") + " ul").removeClass(errorClass);
//            } else {
//                elem.removeClass(errorClass);
//            }
//        }
//    });

//If the change event fires we want to see if the form validates.
//But we don't want to check before the form has been submitted by the user
//initially.
//    $(document).on("change", ".select2-offscreen", function () {
//        if (!$.isEmptyObject(validobj.submitted)) {
//            validobj.form();
//        }
//    });

//A select2 visually resembles a textbox and a dropdown.  A textbox when
//unselected (or searching) and a dropdown when selecting. This code makes
//the dropdown portion reflect an error if the textbox portion has the
//error class. If no error then it cleans itself up.
//    $(document).on("select2-opening", function (arg) {
//        var elem = $(arg.target);
//        if ($("#s2id_" + elem.attr("id") + " ul").hasClass("myErrorClass")) {
//            //jquery checks if the class exists before adding.
//            $(".select2-drop ul").addClass("myErrorClass");
//        } else {
//            $(".select2-drop ul").removeClass("myErrorClass");
//        }
//    });
//});

//OTHER INDUSTRY INSERT START
$(document).on('change', '#industry', function (event) {
   
      var item=$(this);
      var industry=(item.val());
     
      if(industry == 288)
      {
       
            item.val('');

             $('.biderror .mes').html('<h2>Add Industry</h2><input tabindex="1" type="text" name="other_indu" id="other_indu"><a id="indus" tabindex="2" class="btn">OK</a>');
            $('#bidmodal').modal('show');
           // $.fancybox.open('<div class="message" style="width:300px;"><h2>Add Industry</h2><input type="text" name="other_indu" id="other_indu"><a id="indus" class="btn">OK</a></div>');
   
             $('.message #indus').off('click').on('click', function () {

                $("#other_indu").removeClass("keyskill_border_active");
                $('#field_error').remove();
 var x = $.trim(document.getElementById("other_indu").value);
            if (x == '') {
                $("#other_indu").addClass("keyskill_border_active");
                $('<span class="error" id="field_error" style="float: right;color: red; font-size: 11px;">Empty Field  is not valid</span>').insertAfter('#other_indu');
                return false;
            } else {
      var $textbox = $('.message').find('input[type="text"]'),
      textVal  = $textbox.val();
      $.ajax({
                          type: 'POST',
                          url: base_url + 'recruiter/recruiter_other_industry',
                          dataType: 'json',
                          data: 'other_industry=' + textVal,
                          success: function (response) {
                      
                               if(response == 0)
                              {
                                $("#other_indu").addClass("keyskill_border_active");
                                $('<span class="error" id="field_error" style="float: right;color: red; font-size: 11px;">Written industry already available in industry Selection</span>').insertAfter('#other_indu');
                              }
                              else if(response == 1)
                              {
                               
                                $("#other_indu").addClass("keyskill_border_active");
                                $('<span class="error" id="field_error" style="float: right;color: red; font-size: 11px;">Empty industry  is not valid</span>').insertAfter('#other_indu');
                              }  
                              else
                              {
                                
                                   //$.fancybox.close();
                                   $('#bidmodal').modal('hide');
                                   $('.industry1').html(response.select);
                              }
                          }
                      });
      }
                  });
      }
     
   });
//OTHER INDUSTRY INSERT END

//Click on University other option process Start 
// $(document).on('change', '#industry', function (event) {

//     //alert(111);
//     var item = $(this);
//     var industry = (item.val());
//     if (industry == 288)
//     {
//         $.fancybox.open('<div class="message"><h2>Add Industry</h2><input type="text" name="other_indu" id="other_indu"><a id="indus" class="btn">OK</a></div>');

//         $('.message #indus').on('click', function () {
//             var $textbox = $('.message').find('input[type="text"]'),
//                     textVal = $textbox.val();
//             $.ajax({
//                 type: 'POST',
//                 url: base_url + "recruiter/recruiter_other_industry",
//                 dataType: 'json',
//                 data: 'other_industry=' + textVal,
//                 success: function (response) {

//                     if (response.select == 0)
//                     {
//                         $.fancybox.open('<div class="message"><h2>Written industry already available in industry Selection</h2><button data-fancybox-close="" class="btn">OK</button></div>');
//                     } else if (response.select == 1)
//                     {
//                         $.fancybox.open('<div class="message"><h2>Empty industry is not valid</h2><button data-fancybox-close="" class="btn">OK</button></div>');
//                     } else
//                     {
//                         $.fancybox.close();
//                         $('#industry').html(response.select1);
//                         $('#industry').html(response.select);
//                     }
//                 }
//             });

//         });
//     }

// });

function leave_page(clicked_id)
{
//alert(clicked_id);

    var post_name = document.getElementById('post_name').value;
    var skills = document.getElementById('skills2').value;
    var position = document.getElementById('position').value;
    var minyear = document.getElementById('minyear').value;
    var maxyear = document.getElementById('maxyear').value;
    var industry = document.getElementById('industry').value;
    var emp_type = document.getElementById('emp_type').value;
    var education = document.getElementById('education').value;
    var post_desc = document.getElementById('post_desc').value;
    var interview = document.getElementById('interview').value;
    var country = document.getElementById('country').value;
    var state = document.getElementById('state').value;
    var city = document.getElementById('city').value;
    var salary_type = document.getElementById('salary_type').value;
    var datepicker = document.getElementById('example2').value;
    var minsal = document.getElementById('minsal').value;
    var maxsal = document.getElementById('maxsal').value;
    var currency = document.getElementById('currency').value;

    var searchkeyword = $.trim(document.getElementById('rec_search_title').value);
    var searchplace = $.trim(document.getElementById('rec_search_loc').value);
    //   alert(datepicker);

    if (post_name == "" && skills == "" && minyear == "" && maxyear == "" && industry == "" && emp_type == "" && education == "" && post_desc == "" && interview == "" && country == "" && state == "" && salary_type == "" && datepicker == "" && minsal == "" && maxsal == "" && currency == "" && searchkeyword == "" && searchplace == "")
    {
        //alert("hi");
        if (clicked_id == 1)
        {
            location.href = base_url + "recruiter/home";
        }
        if (clicked_id == 2)
        {
            location.href = base_url + "recruiter/profile";
        }
        if (clicked_id == 3)
        {
            location.href = base_url + "recruiter/basic-information";
        }
        if (clicked_id == 4)

        {


            if (searchkeyword == "" && searchplace == "")
            {
                return checkvalue_search;
            } else
            {
                if (searchkeyword == "")
                {
                    location.href = base_url + 'recruiter_search/' + 0 + '/' + searchplace;

                } else if (searchplace == "")
                {
                    location.href = base_url + 'search/recruiter_search/' + searchkeyword + '/' + 0;
                } else
                {
                    location.href = base_url + 'search/recruiter_search/' + searchkeyword + '/' + searchplace;
                }


            }
        }
        if (clicked_id == 5)
        {





            document.getElementById('acon').style.display = 'block !important';


        }
        if (clicked_id == 6)
        {
            location.href = base_url + "profile";
        }
        if (clicked_id == 7)
        {
            location.href = base_url + "registration/changepassword";
        }
        if (clicked_id == 8)
        {
            location.href = base_url + "dashboard/logout";
        }
        if (clicked_id == 9)
        {
            location.href = 'javascript:history.back()';

        }

    } else
    {
        return home(clicked_id, searchkeyword, searchplace);

    }

}

$('.header ul li #abody ul li a').click(function () {
    var post_name = document.getElementById('post_name').value;
    var skills = document.getElementById('skills2').value;
    var position = document.getElementById('position').value;
    var minyear = document.getElementById('minyear').value;
    var maxyear = document.getElementById('maxyear').value;
    var industry = document.getElementById('industry').value;
    var emp_type = document.getElementById('emp_type').value;
    var education = document.getElementById('education').value;
    var post_desc = document.getElementById('post_desc').value;
    var interview = document.getElementById('interview').value;
    var country = document.getElementById('country').value;
    var state = document.getElementById('state').value;
    var city = document.getElementById('city').value;
    var salary_type = document.getElementById('salary_type').value;
    var datepicker = document.getElementById('example2').value;
    var minsal = document.getElementById('minsal').value;
    var maxsal = document.getElementById('maxsal').value;
    var currency = document.getElementById('currency').value;

    var searchkeyword = $.trim(document.getElementById('rec_search_title').value);
    var searchplace = $.trim(document.getElementById('rec_search_loc').value);
    //  alert(datepicker);
    var all_clicked_href = $(this).attr('href');

    if (post_name == "" && skills == "" && minyear == "" && maxyear == "" && industry == "" && emp_type == "" && education == "" && post_desc == "" && interview == "" && country == "" && state == "" && salary_type == "" && datepicker == "" && minsal == "" && maxsal == "" && currency == "" && searchkeyword == "" && searchplace == "")
    {
        location.href = all_clicked_href;
    } else
    {
        home1(all_clicked_href);
    }
});

//all popup close close using esc start 
$(document).ready(function () {
 $( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) {
        $('#bidmodal').modal('hide');
        //$.fancybox.close();
        $( "#dropdown-content_hover" ).hide();
    }
   });  
});
//all popup close close using esc end 

