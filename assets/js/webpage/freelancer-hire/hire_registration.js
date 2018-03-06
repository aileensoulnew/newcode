//CODE FOR COUNTRY,STATE, CITY START
$('#country').on('change', function () {
    var countryID = $(this).val();
    if (countryID) {
        $.ajax({
            type: 'POST',
            url: base_url + "freelancer_hire/ajax_data",
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
            url: base_url + "freelancer_hire/ajax_data",
            data: 'state_id=' + stateID,
            success: function (html) {
                $('#city').html(html);
            }
        });
    } else {
        $('#city').html('<option value="">Select state first</option>');
    }
});
//CODE FOR COUNTRY,STATE, CITY END
$(document).ready(function () {
    if (!user_session) {
        $('#register').modal('show');
    }

    $('.ajax_load').hide();
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
//                lowercase: /^[0-9a-z\s\r\n@!#\$\^%&*()+=_\-\[\]\\\';,\.\/\{\}\|\":<>\?]+$/,
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
                    window.location = base_url + "freelance-hire/registration";
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

// country statre and city ajax data for freelancer profile start

});
//CODE FOR COUNTRY,STATE,CITY END


function validate(){

     var form = $("#freelancerhire_regform");
    if(form.valid() == true ){
     //$('#profilereg_ajax_load').show();
     document.getElementById('profilereg_ajax_load').style.display = 'inline-block';
     
    }
}


$.validator.addMethod("regx", function (value, element, regexpr) {
    if (!value) {
        return true;
    } else {

        return regexpr.test(value);
    }
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

    $("#freelancerhire_regform").validate({
        rules: {
            firstname: {
                required: true
            },
            lastname: {
                required: true,
                regx: /^["-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
            },
            email_reg1: {
                required: true,
                email: true,
                remote: {
                    url: site + "freelancer_hire/check_email",
                    type: "post",
                    data: {
                        email_reg1: function () {
                            return $("#email_reg1").val();
                        },
//                        'aileensoulnewfrontcsrf': get_csrf_hash,
                    }, async: false
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
            }



        },

        messages: {
            firstname: {
                required: "First name is required."
            },
            lastname: {
                required: "Last name is required."
            },
            email1: {
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
            }
        },
    });

});
//FORM FILL UP VALIDATION END

//CODE FOR COPY-PASTE START
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
//CODE FOR COPY-PASTE END
//
////DISABLE BUTTON ON ONE TIME CLICK START
//$("#submit").on('click', function ()
//{
//    if ($('#freelancerhire_regform').valid())
//    {
//        $("#submit").addClass("register_disable");
//        return true;
//    }
//
//});
////DISABLE CUTTON ON ONE TIME CLICK END
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


$('.modal-close').click(function(e){ 
    $('#login').modal('show');
    //$('body').addClass('modal-open');
    document.getElementById("add-model-open").classList.add("modal-open-other");
});

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
                if (response.freelancerhire == 0) {
                    window.location = base_url + "freelance-hire/registration";
                } else {
                    $("#btn1").html('<img src="' + base_url + 'images/btn-ajax-loader.gif" /> &nbsp; Login ...');
                    window.location = base_url + "freelance-hire/home";
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
