//FLASH MESSAGE SCRIPT START
$(".alert").delay(3200).fadeOut(300);
//FLASH MESSAGE SCRIPT END
//CODE FOR COUNTRY,STATE, CITY START
$(document).ready(function () {
    if (!user_session) {
        $('#register').modal('show');
    }
    // for registation of main profile start
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
                lowercase: /^[0-9a-z\s\r\n@!#\$\^%&*()+=_\-\[\]\\\';,\.\/\{\}\|\":<>\?]+$/,
                remote: {
                    url: base_url + "registration/check_email",
                    type: "post",
                    data: {
                        email_reg: function () {
                            // alert("hi");
                            return $("#email_reg").val();
                        },

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
    /* register submit */
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

        var post_data = {
            'first_name': first_name,
            'last_name': last_name,
            'email_reg': email_reg,
            'password_reg': password_reg,
            'selday': selday,
            'selmonth': selmonth,
            'selyear': selyear,
            'selgen': selgen,

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
            data: post_data,
            beforeSend: function ()
            {
                $("#register_error").fadeOut();
                $("#btn1").html('Create an account ...');
            },
            success: function (response)
            { //alert("ksjkskjds");
                //alert(postid);
                var userid = response.userid;
                if (response.okmsg == "ok") {
                    window.location = base_url + "freelance-work/registration";
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
// for registation of main profile end

    $('#country').on('change', function () {
        var countryID = $(this).val();
        if (countryID) {
            $.ajax({
                type: 'POST',
                url: base_url + "freelancer/ajax_data",
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
                url: base_url + "freelancer/ajax_data",
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
//CODE FOR COUNTRY,STATE,CITY END
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
                        if (terms.length <= 15) {
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
$.validator.addMethod("regx", function (value, element, regexpr) {
    return regexpr.test(value);
}, "Only space, only number and only special characters are not allow");
$.validator.addMethod("regx1", function (value, element, regexpr) {
    if (!value)
    {
        return true;
    } else
    {
        return regexpr.test(value);
    }
}, "Enter a number between 8 to 15 digit");
$(document).ready(function () {

    $("#freelancer_regform").validate({
        rules: {
            firstname: {
                required: true
            },
            lastname: {
                required: true,
                regx: /^["-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
            },
            email: {
                required: true,
                email: true,
                remote: {
                    url: site + "freelancer/check_email",
                    type: "post",
                    data: {
                        email: function () {
                            return $("#email").val();
                        },
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                    },
                },

            },
            phoneno: {
                regx1: /^[0-9\-\+]{9,15}$/,
            },
            country: {
                required: true,
            },
            state: {
                required: true,
            },
            city: {
                required: true,
            },
            field: {
                required: true
            },

            skills: {
                required: true,
                regx: /^["-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
            }


        },

        messages: {
            firstname: {
                required: "First name is required."
            },
            lastname: {
                required: "Last name is required."
            },
            email: {
                required: "Email id is required.",
                email: "Please enter valid email id.",
                remote: "Email already exists."
            },
            phoneno: {
                minlength: "Minimum length 8 digit",
                maxlength: "Maximum length 15 digit"
            },
            country: {
                required: "Country is required.",
            },
            state: {
                required: "State is required.",
            },
            city: {
                required: "City is required.",
            },
            field: {
                required: "Field is required",
            },
            skills: {
                required: "Skill is required"
            }
        },
    });

});
//FORM FILL UP VALIDATION END

function remove_validation() {

    $("#other_field").removeClass("keyskill_border_active");
    $('#field_error').remove();

}
$("#freelancer_regform").submit(function () {


    $('#experience_error').remove();
    $('.experience_month').removeClass('error');
    $('.experience_year').removeClass('error');

    var year = $('.experience_year').val();
    var month = $('.experience_month').val();

    if (year == null && month == null) {

        $('.experience_year').addClass('error');
        $('.experience_month').addClass('error');
        $('<span class="error" id="experience_error" style="float: right;color: red; font-size: 11px;">Experiance is required</span>').insertAfter('#experience_month');
        return false;
    } else {
      //  consol.log();
        return true;
    }
//    $('.experience_month').append('<label for="year-month" class="year-month" style="display: block;">Experiance is required.</label>');

});
function check_yearmonth() {
    var year = $('.experience_year').val();
    var month = $('.experience_month').val();
    if (year != null || month != null) {
        $('#experience_error').remove();
        $('.experience_month').removeClass('error');
        $('.experience_year').removeClass('error');
        return true;
    }

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
                    url: base_url + "freelancer/freelancer_other_field",
                    dataType: 'json',
                    data: 'other_field=' + textVal,
                    success: function (response) {
                        $("#other_field").removeClass("keyskill_border_active");
                        $('#field_error').remove();
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
//                            $.fancybox.close();


                        }
                    }
                });
            }

        });
    }

});
//CLOSE MODEL ON ESC KEY START
$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        $('#bidmodal2').modal('hide');
    }
});
//CLOSE MODEL ON ESC KEY END
//DISABLE BUTTON ON ONE TIME CLICK START
$("#submit").on('click', function ()
{
    if ($('#freelancer_regform').valid())
    {
        $("#submit").addClass("register_disable");
        return true;
    }

});
//DISABLE CUTTON ON ONE TIME CLICK END
//login pop up open start
function login_profile() {
    $('#register').modal('hide');
    $('#login').modal('show');
}
//login pop up open end
function forgot_profile() {
    $('#login').modal('hide');
    $('#forgotPassword').modal('show');
}
function create_profile() {
    $('#login').modal('hide');
    $('#register').modal('show');
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
/* validation */
/* login submit */
function submitForm()
{

    var email_login = $("#email_login").val();
    var password_login = $("#password_login").val();
    var post_data = {
        'email_login': email_login,
        'password_login': password_login,
//            csrf_token_name: csrf_hash
    }
    $.ajax({
        type: 'POST',
        url: base_url + 'registration/check_login',
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
                $("#btn1").html('<img src="' + base_url + 'images/btn-ajax-loader.gif" /> &nbsp; Login ...');
                window.location = base_url + "freelance-Work/home";
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
/* login submit */
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
            $("#forgotbuton").html('Your credential has been send in your register email id');
        },
        success: function (response)
        {
            if (response.data == "success") {
                //  alert("login");
                $("#forgotbuton").html(response.data);
                //window.location = base_url + "job/home/live-post";
            } else {
                $("#forgotbuton").html(response.message);

            }
        }
    });
    return false;
}
