//SCRIPT FOR DATEPICKER START
$(function () {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();
    var today = yyyy;
    $("#example2").dateDropdowns({
        submitFieldName: 'last_date',
        submitFormat: "yyyy-mm-dd",
        minYear: today,
        maxYear: today + 1,
        daySuffixes: false,
        monthFormat: "short",
        dayLabel: 'DD',
        monthLabel: 'MM',
        yearLabel: 'YYYY',
        //startDate: today,
    });
    $(".day").attr('tabindex', 8);
    $(".day").attr('onChange', 'check_datevalidation();');
    //$(".day").attr('required', 'required');
    $(".month").attr('tabindex', 9);
    $(".month").attr('onChange', 'check_datevalidation();');
    //$(".month").attr('required', 'required');
    $(".year").attr('tabindex', 10);
    $(".year").attr('onChange', 'check_datevalidation();');
    //$(".year").attr('required', 'required');
});
//SCRIPT FOR DATEPICKER END 

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
}, "Only space, only number and only special characters are not allow");
$.validator.addMethod("regx_num_space", function (value, element, regexpr) {
    //return value == '' || value.trim().length != 0; 
    if (!value)
    {
        return true;
    } else
    {
        return regexpr.test(value);
    }
    // return regexpr.test(value);
}, "Please add proper Estimated time. Eg: '3 month' or '3 Year' ");
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
//            last_date: {
//                last_date_require: true,
//                isValid: true
//            },
//            currency: {
//                required: true,
//            },
            rate: {
                number: true,
            },
            country: {
                required: true,
            },
            state: {
                required: true,
            },
            est_time: {
                regx_num_space: /[0-9\s][a-zA-Z]/
            },
//            rate: {
//                required: true,
//            },
//            currency: {
//                required: true,
//            },
            rating: {
                required: true,
            }

        },
        messages: {
            post_name: {
                required: "Project name is required."
            },
            skills: {
                required: "Skill is required."
            },
            fields_req: {
                required: "Please select field of requirement."
            },
            post_desc: {
                required: "Project description  is required."
            },
//            last_date: {
//                //required: "Last Date of apply is required.",
//            },
//            currency: {
//                required: "Please select currency type",
//            },

            country: {
                required: "Please select country."
            },
            state: {
                required: "Please select state."
            },
//            rate: {
//                required: "Rate is required."
//            },
//            currency: {
//                required: "Currency is required.",
//            },
            rating: {
                required: "Work type is required.",
            }

        },
        submitHandler: submitaddpostForm
    });
});
// FORM FILL UP VALIDATION END
function submitaddpostForm() {
    register_profile();
}
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
        $('.date-dropdowns').append('<label for="example2" class="error last_date_error" style="display: block;">Last Date of apply is required.</label>');
        return false;
        //<label for="example2" class="error">Last Date of apply is required.</label>
    } else {
        var todaydate = new Date();
        var dd = todaydate.getDate();
        var mm = todaydate.getMonth() + 1; //January is 0!
        var yyyy = todaydate.getFullYear();
        if (mm <= 9) {
            mm = 0 + mm.toString();
        }
        var todaydate_in_str = yyyy.toString() + mm.toString() + dd.toString();


        var selected_date_in_str = "" + year + month + day;

        if (parseInt(todaydate_in_str) > parseInt(selected_date_in_str)) {
            $('.day').addClass('error');
            $('.month').addClass('error');
            $('.year').addClass('error');

            $('.date-dropdowns .last_date_error').remove();
            $('.date-dropdowns').append('<label for="example2" class="error last_date_error" style="display: block;">Last date should be grater than and equal to today date</label>');
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

$("#postinfo").submit(function () {

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
        $('.date-dropdowns').append('<label for="example2" class="error last_date_error" style="display: block;">Last Date of apply is required.</label>');
        return false;

    } else {
        var todaydate = new Date();
        var dd = todaydate.getDate();
        var mm = todaydate.getMonth() + 1; //January is 0!
        var yyyy = todaydate.getFullYear();
        if (mm <= 9) {
            mm = 0 + mm.toString();
        }
        var todaydate_in_str = yyyy.toString() + mm.toString() + dd.toString();


        var selected_date_in_str = "" + year + month + day;

        if (parseInt(todaydate_in_str) > parseInt(selected_date_in_str)) {
            $('.day').addClass('error');
            $('.month').addClass('error');
            $('.year').addClass('error');

            $('.date-dropdowns .error').show();
            $('.date-dropdowns').append('<label for="example2" class="error last_date_error" style="display:block;">Last date should be grater than and equal to today date</label>');
            $('.date-dropdowns .last_date_error').removeAttr('style');
            return false;
        } else {
            $('.day').removeClass('error');
            $('.month').removeClass('error');
            $('.year').removeClass('error');
            $('.date-dropdowns .last_date_error').remove();

            var rate = $('#rate').val();
            var currency = $('#currency').val();
            var worktype = $("input[name=rating]:checked").val();
            
            if (rate != '') {
                if (currency == null) {
                    $('<label for="currency" class="last_date_error" style="display: block;">You had add rate so please select currency</label>').insertAfter("#currency");
                    return false;
                }
            }

            return true;
        }
    }
});
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
//                        csrf_token_name: csrf_hash,
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
//                    email_reg: {
//                        required: "Please enter email address",
//                        remote: "Email address already exists",
//                    },
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


    var first_name = $("#first_name").val();
    var last_name = $("#last_name").val();
    var email_reg = $("#email_reg").val();
    var password_reg = $("#password_reg").val();
    var selday = $("#selday").val();
    var selmonth = $("#selmonth").val();
    var selyear = $("#selyear").val();
    var selgen = $("#selgen").val();

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
//            csrf_token_name: csrf_hash
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
                var post_desc = $("#post_desc").val();
                var skill = $("#skills2").val();
                var fields_req = $("#fields_req").val();
                var year = $("#year").val();
                var month = $("#month").val();
                var est_time = $("#est_time").val();
                var datepicker = $("#example2").val();
                var rate = $("#rate").val();
                var currency = $("#currency").val();
                var Worktype = $("input:radio[name=rating]:checked").val()

                var post_data1 = {
                    'post_name': post_name,
                    'post_desc': post_desc,
                    'skill': skill,
                    'field': fields_req,
                    'year': year,
                    'month': month,
                    'est_time': est_time,
                    'last_date': datepicker,
                    'rate': rate,
                    'currency': currency,
                    'Worktype': Worktype,
//                        csrf_token_name: csrf_hash
                }
                if (post_name != '') {
                    $.ajax({
                        type: 'POST',
                        url: base_url + 'freelancer_hire/add_post_added',
                        data: post_data1,
                        dataType: "json",
                        success: function (response) {
                            if (response.data == "ok") {

                                window.location = base_url + "freelance-hire/registration/live-post";
                            }
                        }
                    });
                } else {
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
//        csrf_token_name: csrf_hash
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
                    $('#login').modal('show');
                    $('#forgotPassword').modal('hide');
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
}

/* validation */

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
//        csrf_token_name: csrf_hash
    }
    $.ajax({
        type: 'POST',
        url: base_url + 'login/freelancer_hire_login',
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
                //  alert("login");
                if (response.freelancerhire == 1) {
                    $("#btn1").html('<img src="' + base_url + 'images/btn-ajax-loader.gif" /> &nbsp; Login ...');

                    var post_name = $("#post_name").val();
                    var post_desc = $("#post_desc").val();
                    var skill = $("#skills2").val();
                    var fields_req = $("#fields_req").val();
                    var year = $("#year").val();
                    var month = $("#month").val();
                    var est_time = $("#est_time").val();
                    var datepicker = $("#example2").val();
                    var rate = $("#rate").val();
                    var currency = $("#currency").val();
                    var Worktype = $("input:radio[name=rating]:checked").val()

                    var post_data1 = {
                        'post_name': post_name,
                        'post_desc': post_desc,
                        'skill': skill,
                        'field': fields_req,
                        'year': year,
                        'month': month,
                        'est_time': est_time,
                        'last_date': datepicker,
                        'rate': rate,
                        'currency': currency,
                        'Worktype': Worktype,
//                        csrf_token_name: csrf_hash
                    }
                    if (post_name != '') {
                        $.ajax({
                            type: 'POST',
                            url: base_url + 'freelancer_hire/add_project_login',
                            data: post_data1,
                            dataType: "json",
                            success: function (response) {
                                if (response.data == "ok") {
                                    window.location = base_url + "freelance-hire/home";
                                }
                            }
                        });
                    } else {
                        window.location = base_url + "profiles/" + user_slug;
                    }
                } else {
                    var post_name = $("#post_name").val();
                    var post_desc = $("#post_desc").val();
                    var skill = $("#skills2").val();
                    var fields_req = $("#fields_req").val();
                    var year = $("#year").val();
                    var month = $("#month").val();
                    var est_time = $("#est_time").val();
                    var datepicker = $("#example2").val();
                    var rate = $("#rate").val();
                    var currency = $("#currency").val();
                    var Worktype = $("input:radio[name=rating]:checked").val()

                    var post_data1 = {
                        'post_name': post_name,
                        'post_desc': post_desc,
                        'skill': skill,
                        'field': fields_req,
                        'year': year,
                        'month': month,
                        'est_time': est_time,
                        'last_date': datepicker,
                        'rate': rate,
                        'currency': currency,
                        'Worktype': Worktype,
//                        csrf_token_name: csrf_hash
                    }
                    if (post_name != '') {
                        $.ajax({
                            type: 'POST',
                            url: base_url + 'freelancer_hire/add_post_added',
                            data: post_data1,
                            dataType: "json",
                            success: function (response) {
                                if (response.data == "ok") {
                                    window.location = base_url + "freelance-hire/registration/live-post";
                                }
                            }
                        });
                    } else {
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
// SCRIPT FOR ADD OTHER FIELD  START
$(document).on('change', '.field_other', function (event) {

    $("#other_field").removeClass("keyskill_border_active");
    $('#field_error').remove();
    var item = $(this);
    var other_field = (item.val());
    if (other_field == 15) {
        item.val('');
        $('#bidmodal2').modal('show');
//        $.fancybox.open('<div class="message" style="width:300px;"><h2>Add Field</h2><input type="text" name="other_field" id="other_field" onkeypress="return remove_validation()"><div class="fw"><a id="field" class="btn">OK</a></div></div>');

        $('.message #field').off('click').on('click', function () {
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
                    url: base_url + "freelancer_hire/other_filed_live",
                    dataType: 'json',
                    data: 'other_field=' + textVal,
                    success: function (response) {
                        
                        if (response.select == 0)
                        {
//                            $.fancybox.open('<div class="message" ><h2>Written field already available in Field Selection</h2><button data-fancybox-close="" class="btn">OK</button></div>');
                            $("#other_field").addClass("keyskill_border_active");
                            $('<span class="error" id="field_error" style="float: right;color: red; font-size: 11px;">Written field already available in Field Selection</span>').insertAfter('#other_field');
                        } else if (response.select == 1)
                        {
                            $("#other_field").addClass("keyskill_border_active");
                            $('<span class="error" id="field_error" style="float: right;color: red; font-size: 11px;">Empty Field  is not valid</span>').insertAfter('#other_field');
//                                          $('#other_field').parent().append('<span class="error" style="float: right;color: red; font-size: 11px;">Empty Field  is not valid</span>');
//                                        $.fancybox.open('<div class="message"><h2>Empty Field  is not valid</h2><button data-fancybox-close="" class="btn">OK</button></div>');
                        } else
                        {
                            // $.fancybox.close();
                            $('#bidmodal2').modal('hide');
                            $('#other_field').val('');
                            $("#other_field").removeClass("keyskill_border_active");
                            $("#field_error").removeClass("error");
                            var ss = document.querySelectorAll("label[for]");
                            var i;
                            for (i = 0; i < ss.length; i++) {
                                var zz = ss[i].getAttribute('for');
                                if (zz == 'fields_req') {
                                    ss[i].remove();
                                }
                            }
                            $("#fields_req").removeClass("error");
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