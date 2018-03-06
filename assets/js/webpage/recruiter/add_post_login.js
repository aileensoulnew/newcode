//$(document).ready(function () { 
//
//
//     $('#register_profile').modal('show');
// });

function login_profile() {

    $('#register_profile').modal('hide');
    $('#login').modal('show');
}
function register_profile() {
    $('#login').modal('hide');
    $('#register_profile').modal('show');
}
function forgot_profile() {
    $('#login').modal('hide');
    $('#forgotPassword').modal('show');

}
function forgot_close() {
       // $('#login').modal('show');
       // $('body').addClass('modal-open');
       // $('body').addClass('no-login');
}


$( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) {
        $('#register_profile').modal('hide');
        $('#login').modal('hide');
        $('#forgotPassword').modal('hide');
    }
});

//function login_profile1(){
//    $('#register_apply').modal('hide');
//    $('#login1').modal('show');
//}
//function register_profile1() {
//    $('#login1').modal('hide');
//    $('#register_apply').modal('show');
//}
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
    $(".day").attr('tabindex', 12);
    $(".day").attr('onChange', 'check_datevalidation();');
    $(".month").attr('tabindex', 13);
    $(".month").attr('onChange', 'check_datevalidation();');
    $(".year").attr('tabindex', 14);
    $(".year").attr('onChange', 'check_datevalidation();');

});



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

        if (parseInt(todaydate_in_str) > parseInt(selected_date_in_str)) { alert("ggg");
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
        $('.date-dropdowns').append('<label for="example2" class="last_date_error" style="display: block;">Last Date of apply is required.</label>');
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
            $('.date-dropdowns').append('<label for="example2" class="error last_date_error">Last date should be grater than and equal to today date</label>');
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


$(function () {
    $("#post_name").autocomplete({
        source: function (request, response) {
            var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
            response($.grep(jobdata, function (item) {
                return matcher.test(item.label);
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
                    $.getJSON(base_url + "recruiter/get_degree", {term: extractLast(request.term)}, response);
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
// $.validator.addMethod("required1", function (value, element, regexpr) {
//     //return value == '' || value.trim().length != 0; 

//     if (!value)
//     {
//         $('.day').addClass('error');
//         $('.month').addClass('error');
//         $('.year').addClass('error');
//         return false;
//     } else
//     {
//         return true;
//     }

//     // return regexpr.test(value);
// }, "Last date of apply is required.");

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

    if (lastdata_new_one >= todaydate_new_one) {
//        $('.day').addClass('error');
//        $('.month').addClass('error');
//        $('.year').addClass('error');
        return true;
    } else {
        $('.day').addClass('error');
        $('.month').addClass('error');
        $('.year').addClass('error');
        return false;
    }

    //return lastdata_new_one >= todaydate_new_one;
}, "Last date should be grater than or equal to today date.");

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
                //return parseInt(value) > parseInt($min.val());
                //return (value) > ($min.val());

                return parseFloat(value) > parseFloat($min.val());
            }
        }, "Maximum experience must be greater than minimum experience.");

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

$.validator.addMethod("reg_candidate", function (value, element, regexpr) {
    return regexpr.test(value);
}, "Float Number Is Not Allowed");

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

    $("#artpost").validate({

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

        },
        submitHandler: submitaddpostForm
    });

});
function submitaddpostForm() {
    register_profile();
}
$(document).ready(function () {
    $("#login_form").validate({

        rules: {
            email_login: {
                required: true,
            },
            password_login: {
                required: true,
            }
        },
        messages:
                {
                    email_login: {
                        required: "Please enter email address",
                    },
                    password_login: {
                        required: "Please enter password",
                    }
                },
        submitHandler: submitForm
    });
    /* login submit */
    function submitForm()
    {
        var email_login = $("#email_login").val();
        var password_login = $("#password_login").val();
        var post_data = {
            'email_login': email_login,
            'password_login': password_login,
            csrf_token_name: csrf_hash
        }
        $.ajax({
            type: 'POST',
            url: base_url + 'login/rec_check_login',
            data: post_data,
            dataType: "json",
            beforeSend: function ()
            {
                $("#error").fadeOut();
                $("#btn1").html('Login ...');
            },
            success: function (response)
            {
                if (response.data == "ok") {
                     
                    
                    if(response.is_rec == 1){
                       
                    $("#btn1").html('<img src="' + base_url + 'images/btn-ajax-loader.gif" /> &nbsp; Login ...');
                    // 8-11   window.location = base_url + "job/home";
                    var post_name = $("#post_name").val();
                    var skills = $("#skills2").val();
                    var position = $("#position").val();
                    var minyear = $("#minyear").val();
                    var maxyear = $("#maxyear").val();
               var fresher =  $("#fresher_nme").is(':checked') ? 1 : 0;
                  //  var fresher = $("#fresher_nme").val();
                    var industry = $("#industry").val();
                    var emp_type = $("#emp_type").val();
                    var education = $("#education").val();
                    var post_desc = $("#post_desc").val();
                    var interview = $("#post_desc").val();
                    var country = $("#country").val();
                    var state = $("#state").val();
                    var city = $("#city").val();
                    var salary_type = $("#salary_type").val();
                    var datepicker = $("#example2").val();
                    var minsal = $("#minsal").val();
                    var maxsal = $("#maxsal").val();
                    var currency = $("#currency").val();

                    var post_data1 = {
                        'post_name': post_name,
                        'skills': skills,
                        'position': position,
                        'minyear': minyear,
                        'maxyear': maxyear,
                        'fresher': fresher,
                        'industry': industry,
                        'emp_type': emp_type,
                        'education': education,
                        'post_desc': post_desc,
                        'interview': interview,
                        'country': country,
                        'state': state,
                        'city': city,
                        'salary_type': salary_type,
                        'datepicker': datepicker,
                        'minsal': minsal,
                        'maxsal': maxsal,
                        'currency': currency,
                        csrf_token_name: csrf_hash
                    }
                    $.ajax({
                        type: 'POST',
                        url: base_url + 'recruiter/add_post_insert',
                        data: post_data1,
                        dataType: "json",
                        success: function (response) {
                            if (response.data == "ok") {
                                window.location = base_url + "recruiter/home";
                            }
                        }
                    });
                }else{
                   
                      var post_name = $("#post_name").val();
                    var skills = $("#skills2").val();
                    var position = $("#position").val();
                    var minyear = $("#minyear").val();
                    var maxyear = $("#maxyear").val();
                    var fresher =  $("#fresher_nme").is(':checked') ? 1 : 0;
                  //  var fresher = $("#fresher_nme").val();
                    var industry = $("#industry").val();
                    var emp_type = $("#emp_type").val();
                    var education = $("#education").val();
                    var post_desc = $("#post_desc").val();
                    var interview = $("#post_desc").val();
                    var country = $("#country").val();
                    var state = $("#state").val();
                    var city = $("#city").val();
                    var salary_type = $("#salary_type").val();
                    var datepicker = $("#example2").val();
                    var minsal = $("#minsal").val();
                    var maxsal = $("#maxsal").val();
                    var currency = $("#currency").val();

                    var post_data1 = {
                        'post_name': post_name,
                        'skills': skills,
                        'position': position,
                        'minyear': minyear,
                        'maxyear': maxyear,
                        'fresher': fresher,
                        'industry': industry,
                        'emp_type': emp_type,
                        'education': education,
                        'post_desc': post_desc,
                        'interview': interview,
                        'country': country,
                        'state': state,
                        'city': city,
                        'salary_type': salary_type,
                        'datepicker': datepicker,
                        'minsal': minsal,
                        'maxsal': maxsal,
                        'currency': currency,
                        csrf_token_name: csrf_hash
                    }
                    if(post_name != ''){
                               $.ajax({
                        type: 'POST',
                        url: base_url + 'recruiter/add_post_added',
                        data: post_data1,
                        dataType: "json",
                        success: function (response) {
                            if (response.data == "ok") {
                                window.location = base_url + "recruiter/registration/live-post";
                            }
                        }
                    });
                    }else{
                        window.location = base_url + "profiles/" + user_slug;
                    }
             
                }
                } else if (response.data == "password") {
                    $("#errorpass").html('<label for="email_login" class="error">Please enter a valid password.</label>');
                    document.getElementById("password_login").classList.add('error');
                    document.getElementById("password_login").classList.add('error');
                    $("#btn1").html('Login');
                } else {
                    $("#errorlogin").html('<label for="email_login" class="error">Please enter a valid email.</label>');
                    document.getElementById("email_login").classList.add('error');
                    document.getElementById("email_login").classList.add('error');
                    $("#btn1").html('Login');
                }
            }
        });
        return false;
    }

    $.validator.addMethod("lowercase", function (value, element, regexpr) {
        return regexpr.test(value);
    }, "Email should be in small character");

    $("#register_form").validate({
        rules: {
            first_name: {
                required: true,
            },
            last_name: {
                required: true,
            },
           email_reg: {
               required: true,
               email: true,
             //  lowercase: /^[0-9a-z\s\r\n@!#\$\^%&*()+=_\-\[\]\\\';,\.\/\{\}\|\":<>\?]+$/,
               remote: {
                   url: base_url + "registration/check_email",
                   type: "post",
                   data: {
                       email_reg: function () {
                           // alert("hi");
                           return $("#email_reg").val();
                       },
                       csrf_token_name: csrf_hash,
                   },
               },
           },
            password_reg: {
                required: true,
            },
            selday: {
                required: true,
            },
            selmonth: {
                required: true,
            },
            selyear: {
                required: true,
            },
            selgen: {
                required: true,
            }
        },

        groups: {
            selyear: "selyear selmonth selday"
        },
        messages:
                {
                    first_name: {
                        required: "Please enter first name",
                    },
                    last_name: {
                        required: "Please enter last name",
                    },
                   email_reg: {
                       required: "Please enter email address",
                       remote: "Email address already exists",
                   },
                    password_reg: {
                        required: "Please enter password",
                    },

                    selday: {
                        required: "Please enter your birthdate",
                    },
                    selmonth: {
                        required: "Please enter your birthdate",
                    },
                    selyear: {
                        required: "Please enter your birthdate",
                    },
                    selgen: {
                        required: "Please enter your gender",
                    }

                },
        submitHandler: submitRegisterForm
    });

    function submitRegisterForm()
    {
      
        var postid = '';
        var first_name = $("#first_name").val();
        var last_name = $("#last_name").val();
        var email_reg = $("#email_reg").val();
        var password_reg = $("#password_reg").val();
        var selday = $("#selday").val();
        var selmonth = $("#selmonth").val();
        var selyear = $("#selyear").val();
        var selgen = $("#selgen").val();
        var postid = $(".post_id_login").val();
//alert(postid);
        var post_data2 = {
            'first_name': first_name,
            'last_name': last_name,
            'email_reg': email_reg,
            'password_reg': password_reg,
            'selday': selday,
            'selmonth': selmonth,
            'selyear': selyear,
            'selgen': selgen,
            csrf_token_name: csrf_hash
        }


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

        var todaydate = yyyy + '/' + mm + '/' + dd;
        var value = selyear + '/' + selmonth + '/' + selday;


        var d1 = Date.parse(todaydate);
        var d2 = Date.parse(value);
        if (d1 < d2) {
            $(".dateerror").html("Date of birth always less than to today's date.");
            return false;
        } else {
            if ((0 == selyear % 4) && (0 != selyear % 100) || (0 == selyear % 400))
            {
                if (selmonth == 4 || selmonth == 6 || selmonth == 9 || selmonth == 11) {
                    if (selday == 31) {
                        $(".dateerror").html("This month has only 30 days.");
                        return false;
                    }
                } else if (selmonth == 2) { //alert("hii");
                    if (selday == 31 || selday == 30) {
                        $(".dateerror").html("This month has only 29 days.");
                        return false;
                    }
                }
            } else {
                if (selmonth == 4 || selmonth == 6 || selmonth == 9 || selmonth == 11) {
                    if (selday == 31) {
                        $(".dateerror").html("This month has only 30 days.");
                        return false;
                    }
                } else if (selmonth == 2) {
                    if (selday == 31 || selday == 30 || selday == 29) {
                        $(".dateerror").html("This month has only 28 days.");
                        return false;
                    }
                }
            }
        }
        $.ajax({
            type: 'POST',
            url: base_url + 'registration/reg_insert',
            dataType: 'json',
            data: post_data2,
            beforeSend: function ()
            {
                $("#register_error").fadeOut();
                $("#btn1").html('Create an account ...');
            },
            success: function (response)
            {

                var userid = response.userid;
                if (response.okmsg == "ok") {
                    var post_name = $("#post_name").val();
                  //  alert(post_name);
                    var skills = $("#skills2").val();
                    var position = $("#position").val();
                    var minyear = $("#minyear").val();
                    var maxyear = $("#maxyear").val();
                    var fresher =  $("#fresher_nme").is(':checked') ? 1 : 0;
                  //  var fresher = $("#fresher_nme").val();
                    var industry = $("#industry").val();
                    var emp_type = $("#emp_type").val();
                    var education = $("#education").val();
                    var post_desc = $("#post_desc").val();
                    var interview = $("#interview").val();
                    var country = $("#country").val();
                    var state = $("#state").val();
                    var city = $("#city").val();
                    var salary_type = $("#salary_type").val();
                    var datepicker = $("#example2").val();
                    var minsal = $("#minsal").val();
                    var maxsal = $("#maxsal").val();
                    var currency = $("#currency").val();

                    var post_data1 = {
                        'post_name': post_name,
                        'skills': skills,
                        'position': position,
                        'minyear': minyear,
                        'maxyear': maxyear,
                        'fresher': fresher,
                        'industry': industry,
                        'emp_type': emp_type,
                        'education': education,
                        'post_desc': post_desc,
                        'interview': interview,
                        'country': country,
                        'state': state,
                        'city': city,
                        'salary_type': salary_type,
                        'datepicker': datepicker,
                        'minsal': minsal,
                        'maxsal': maxsal,
                        'currency': currency,
                        csrf_token_name: csrf_hash
                    }
                    if(post_name != ''){
                          $.ajax({
                        type: 'POST',
                        url: base_url + 'recruiter/add_post_added',
                        data: post_data1,
                        dataType: "json",
                        success: function (response) {
                            if (response.data == "ok") {
                                window.location = base_url + "recruiter/registration/live-post";
                            }
                        }
                    });
                    }else{
                        window.location = base_url + "profiles/" + user_slug;
                    }
                  

                    return false;

                } else {
                    $("#register_error").fadeIn(1000, function () {
                        $("#register_error").html('<div class="alert alert-danger main"> <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; ' + response + ' !</div>');
                        $("#btn1").html('Create an account');
                    });
                }

            }
        });
        return false;
    }
     /* validation */
    $("#forgot_password").validate({
        rules: {
            forgot_email: {
                required: true,
                email: true,
            }

        },
        messages: {
            forgot_email: {
                required: "Email address is required.",
            }
        },
        submitHandler: submitforgotForm
    });
function submitforgotForm()
 {

    var email_login = $("#forgot_email").val();

    var post_data = {
        'forgot_email': email_login,
//            csrf_token_name: csrf_hash
    }
    $.ajax({
        type: 'POST',
        url: base_url + 'profile/forgot_live',
        data: post_data,
        dataType: "json",
        beforeSend: function ()
        {
            $("#error").fadeOut();
//            $("#forgotbuton").html('Your credential has been send in your register email id');
        },
        success: function (response)
        {
            if (response.data == "success") {
                //  alert("login");
                $("#forgotbuton").html(response.message);
                setTimeout(function () {
                    $('#forgotPassword').modal('hide');
                    $('#login').modal('show');
                     $("#forgotbuton").html('');
                    document.getElementById("forgot_email").value = "";
                }, 5000); // milliseconds
                //window.location = base_url + "job/home/live-post";
            } else {
                $("#forgotbuton").html(response.message);

            }
        }
    });
    return false;
}            /* validation */


});
//$('#submit').on('click', function () {
//
//    if ($('#freelancer_regform').valid())
//    {
//        register_profile();
//
//    }
//
//
//});

//OTHER INDUSTRY INSERT START
$(document).on('change', '#industry', function (event) {

    var item = $(this);
    var industry = (item.val());

    if (industry == 288)
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
                        textVal = $textbox.val();
                $.ajax({
                    type: 'POST',
                    url: base_url + 'recruiter/other_industry_live',
                    dataType: 'json',
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
