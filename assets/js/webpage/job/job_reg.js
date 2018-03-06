
//validation start
$(document).ready(function () {
    $('.ajax_load').hide();

//for display experiancer if data is fill up  when user press back button start
    var year = $("#experience_year option:selected").val();
    var month = $("#experience_month option:selected").val();

    if (year || month) {
        document.getElementById('exp_data').style.display = 'block';
    }
//for display experiancer if data is fill up  when user press back button end
    // $.validator.addMethod("lowercase", function(value, element, regexpr) {          
    //          return regexpr.test(value);
    //      }, "email Should be in Small Character");
    if (profile_login == 'live') {

        $('#register').modal('show');
    }

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

    }, "Digit is not allow");

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

        ignore: '*:not([name])',
        ignore: ":hidden",

        rules: {

            first_name: {
                required: true,
                regx2: /^[a-zA-Z0-9-.,']*[0-9a-zA-Z][a-zA-Z]*/,
                regx_digit: /^([^0-9]*)$/,

            },

            last_name: {
                required: true,
                regx2: /^[a-zA-Z0-9-.,']*[0-9a-zA-Z][a-zA-Z]*/,
                regx_digit: /^([^0-9]*)$/,
            },

            cities: {

                required: true,
            },

            email: {

                required: true,
                email: true,
                // lowercase: /^[0-9a-z\s\r\n@!#\$\^%&*()+=_\-\[\]\\\';,\.\/\{\}\|\":<>\?]+$/,
                remote: {
                    url: base_url + "job/check_email",
                    //async is used for double click on submit avoid
                    async: false,
                    type: "post",

                },
            },

            fresher: {

                required: true,

            },

            job_title: {

                /// required: "#test2:checked",
                required: true,
                regx1: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/,

            },

            industry: {

                required: true,
            },

            cities: {

                required: true,
                regx1: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/,
            },

            skills: {

                required: true,
                regx1: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/,

            },
//            'experience_year': {
//
//                required: true
//            },
//
//            'experience_month': {
//
//                required: true
//            },

        },

        messages: {

            first_name: {

                required: "First name is required.",

            },

            last_name: {

                required: "Last name is required.",

            },

            email: {

                required: "Email address is required.",
                email: "Please enter valid email id.",
                remote: "Email already exists"
            },

            fresher: {

                required: "Fresher is required.",

            },

            industry: {

                required: "Industry is required.",

            },

            cities: {

                required: "City is required.",

            },

            job_title: {

                required: "Job title is required.",

            },

            skills: {

                required: "Skill is required.",

            },
//            'experience_year': {
//
//                required: "Experience year is required.",
//            },
//            'experience_month': {
//
//                required: "Experience month is required.",
//            },

        },

        errorPlacement: function (error, element) {
            if (element.attr("name") == "fresher") {
                $(".fresher-error").html(error);
            } else {
                error.insertAfter(element);
            }
        }
    });
});


function profile_reg() {

    var form = $("#jobseeker_regform");
    if (form.valid() == true) {
        //$('#profilereg_ajax_load').show();
        document.getElementById('profilereg_ajax_load').style.display = 'inline-block';

    }
}
function login_data() {
    $('#login').modal('show');
    $('#register').modal('hide');
    $('body').addClass('modal-open');

}

function forgot_profile() {
    $('#forgotPassword').modal('show');
    $('#login').modal('hide');
    $('body').addClass('modal-open');
}
function register_profile() {
    $('#login').modal('hide');
    $('#register').modal('show');
}

function forgot_close() {
    $('#login').modal('show');
    $('body').addClass('modal-open-other');
}


//  $( document ).on( 'keydown', function ( e ) {
//     if ( e.keyCode === 27 ) {
//         $('#forgotPassword').modal('hide');
//         $('#login').modal('show');
//     }
// });

$(document).ready(function () {

    $.validator.addMethod("lowercase", function (value, element, regexpr) {
        return regexpr.test(value);
    }, "Email Should be in Small Character");

    $("#register_form").validate({
        rules: {
            first_regname: {
                required: true,
            },
            last_regname: {
                required: true,
            },
            email_reg: {
                required: true,
                email: true,
//                lowercase: /^[0-9a-z\s\r\n@!#\$\^%&*()+=_\-\[\]\\\';,\.\/\{\}\|\":<>\?]+$/,
                remote: {
                    //url: "<?php echo site_url() . 'registration/check_email' ?>",
                    url: base_url + "registration/check_email",
                    type: "post",
                    data: {
                        email_reg: function () {
                            // alert("hi");
                            return $("#email_reg").val();
                        },
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
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
        var first_name = $("#first_regname").val();
        var last_name = $("#last_regname").val();
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
            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
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
            url: base_url + "registration/reg_insert",
            dataType: 'json',
            data: post_data,
            beforeSend: function ()
            {
                $("#register_error").fadeOut();
                $("#btn1").html('Create an account ...');
            },
            success: function (response)
            {
                if (response.okmsg == "ok") {
                    window.location = base_url + "job/registration";
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
});


function submit_forgot() {

    var x = document.getElementById("forgot_email").value;
    if (x != '') {
        $('#forgotPassword').modal('hide');
        event.preventDefault();
    }
}

$(document).ready(function () { //aletr("hii");
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
                required: "Email Address Is Required.",
            }
        },
        submitHandler: submitforgotForm
    });
    /* validation */

    function submitforgotForm()
    {

        var email_login = $("#forgot_email").val();

        var post_data = {
            'forgot_email': email_login,
            csrf_token_name: csrf_hash
        }
        $.ajax({
            type: 'POST',
            url: base_url + 'profile/forgot_live',
            data: post_data,
            dataType: "json",
            beforeSend: function ()
            {
                $("#error").fadeOut();
//                $("#forgotbuton").html('Your credential has been send in your register email id');
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

});



function login()
{
    document.getElementById('error1').style.display = 'none';
}
//validation for edit email formate form
$(document).ready(function () {
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
            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
        }
        $.ajax({
            type: 'POST',
            //url: '<?php echo base_url() ?>registration/user_check_login',
            url: base_url + "login/job_check_login",
            data: post_data,
            dataType: "json",
            beforeSend: function ()
            {
                $("#error").fadeOut();
                $("#btn1").html('Login');
            },
            success: function (response)
            {
                if (response.data == "ok") {
                    if (response.is_job == 1) {
                        window.location = base_url + "job/home";
                    } else {
                        window.location = base_url + "job/registration";
                    }
                } else if (response.is_artistic == 1) {
                    window.location = base_url + "job/registration";
                    // window.location = "<?php echo base_url() ?>artist/profile";
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
});


$("#submit").on('click', function () {
    $('#experience_error').remove();
    $('.experience_month').removeClass('error');
    $('.experience_year').removeClass('error');

    var year = $('#experience_year').val();
    var month = $('#experience_month').val();
    var checked_val = $('input[name=fresher]:checked').val();
    if (checked_val == 'Experience') {
        if (year == null && month == null) {

            $('#experience_year').addClass('error');
            $('#experience_month').addClass('error');
            $('<span class="error" id="experience_error" style="float: right;color: red; font-size: 11px;">Experiance is required</span>').insertAfter('#experience_month');
            $("#submit").addClass("register_enable-cust");
            return false;
        } else {
            if (year == '0 year' && month == null) {
                $('#experience_year').addClass('error');
                $('#experience_month').addClass('error');
                $('<span class="error" id="experience_error" style="float: right;color: red; font-size: 11px;">Experiance is required</span>').insertAfter('#experience_month');
                $("#submit").addClass("register_enable-cust");
                return false;
            } else {
                return true;
            }
        }
    }
//    $('.experience_month').append('<label for="year-month" class="year-month" style="display: block;">Experiance is required.</label>');

});
//BUTTON SUBMIT DISABLE AFTER SOME TIME START
$("#submit").on('click', function ()
{
    if ($('#jobseeker_regform').valid())
    {
        $("#submit").addClass("register_disable");
        //return false;
    }
//    if (!$('#jobseeker_regform').valid())
//    {
//        return false;
//    }
});
//BUTTON SUBMIT DISABLE AFTER SOME TIME END

//OTHER INDUSTRY INSERT START
$(document).on('change', '#industry', function (event) {

    var item = $(this);
    var industry = (item.val());

    if (industry == 288)
    {

        item.val('');

        $('.biderror .mes').html('<h2>Add Industry</h2><input type="text" name="other_indu" id="other_indu" onkeypress="return remove_validation_stream()"><a id="indus" class="btn">OK</a>');
        $('#bidmodal').modal('show');

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
                            $('#bidmodal').modal('hide');
                            $('#industry').html(response);
                        }
                    }
                });
            }
        });
    }

});
//OTHER INDUSTRY INSERT END
$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        $("#bidmodal").hide();
    }
});
function remove_validation_stream() {
    $("#other_indu").removeClass("keyskill_border_active");
    $('#field_error').remove();

}