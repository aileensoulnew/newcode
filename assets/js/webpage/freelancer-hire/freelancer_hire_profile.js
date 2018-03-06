

//CODE FOR DESIGNATION START
function divClicked() {
    var divHtml = $(this).html();
    var editableText = $("<textarea />");
    editableText.val(divHtml);
    $(this).replaceWith(editableText);
    editableText.focus();
    editableText.blur(editableTextBlurred);
}
function capitalize(s) {
    return s[0].toUpperCase() + s.slice(1);
}
function editableTextBlurred() {
    var html = $(this).val();
    var viewableText = $("<a>");
    if (html.match(/^\s*$/) || html == '') {
        html = "Designation";
    }
    viewableText.html(capitalize(html));
    $(this).replaceWith(viewableText);
    // setup the click event for this new div
    viewableText.click(divClicked);

    $.ajax({
        url: base_url + "freelancer_hire/hire_designation",
        type: "POST",
        data: {"designation": html},
        success: function (response) {

        }
    });
}
$(document).ready(function () {
    $("a.designation").click(divClicked);
    if (!user_session) {
        $('#register').modal('show');
   
//        $('#register').modal({
//            show: true,
//            keyboard: false,
//            backdrop: 'static'
//        });

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
});
//CODE FOR DESIGNATION END


//CODE FOR CHECK SEARCH KEYWORD AND LOCATION BLANK START
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
//CODE FOR CHECK SEARCH KEYWORD AND LOCATION BLANK END


//CODE FOR SHOW POPUP OF WHEN PROFILE PIC OR COVER PIC IMG TYPE NOT SUPPORED START
function picpopup() {
    $('.biderror .mes').html("<div class='pop_content'>Please select only Image File Type.(jpeg,jpg,png,gif)");
    $('#bidmodal').modal('show');
}
//CODE FOR SHOW POPUP OF WHEN PROFILE PIC AND COVER PIC IMG TYPE NOT DUPPORTED END


//FOR SCROLL PAGE AT PERTICULAR POSITION IS START
$(document).ready(function () {
    $('html,body').animate({scrollTop: 265}, 100);
});
//FOR SCROLL PAGE AT PERTICUKAR POSITION IS END
//login pop up open start
function login_profile() {
    $('#register').modal('hide');
    $('#login').modal('show');
}
//login pop up open end
function login_profile1() {
    $('#forgotPassword').modal('hide');
    $('#login').modal('show');
}
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
        url: base_url + 'login/freelancer_apply_login',
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
                if (response.freelancerapply == 0) {
                    window.location = base_url + "freelance-work/registration";
                } else {
                    $("#btn1").html('<img src="' + base_url + 'images/btn-ajax-loader.gif" /> &nbsp; Login ...');
                    window.location = base_url + "freelance-hire/employer-details/" + segment3;
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
//ALL POPUP CLOSE USING ESC START
$(document).on('keydown', function (e) {
    if (e.keyCode == 27) {
      //  alert(111);
        //$( "#bidmodal" ).hide();
        $('#bidmodal-2').modal('hide');
    }
});
//ALL POPUP CLOSE USING ESC END
