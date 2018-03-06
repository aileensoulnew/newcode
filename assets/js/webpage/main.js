$(document).ready(function () {
    $('.ajax_load').hide();
    function getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
    $(".text-effect p").each(function () {
        var text = $(this).html();
        var words = text.split(" ");
        var spanSentence = "";
        for (var i = 0; i < words.length; i++) {
            spanSentence += "<span>" + words[i] + "</span> ";
        }
        $(this).html(spanSentence);
    })
    $(".text-effect p span").each(function () {
        $(this)
                .css({
                    "transform": "translate(" + getRandomInt(-100, 100) + "px, " + getRandomInt(-100, 100) + "px)"
                })
    });
    setTimeout(function () {
        $(".text-effect p span").css({
            "transform": "translate(0, 0)",
            "opacity": 1
        });
    }, 50);
});

// script for login  user valoidtaion start 
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
            'aileensoulnewfrontcsrf': get_csrf_hash,
        }

        $(".btn1").addClass("btn1active");
        $.ajax({
            type: 'POST',
            url: base_url + 'login/check_login',
            data: post_data,
            dataType: "json",
            beforeSend: function ()
            {
                $("#error").fadeOut();
                $('#login_ajax_load').show();
            },
            success: function (response)
            {
              
                if (response.data == "ok") {
                    $("#btn-login").html('<img src="' + base_url + 'images/btn-ajax-loader.gif" /> &nbsp; Login ...');
                    if(response.is_userBasicInfo==1 || response.is_userStudentInfo==1){
                        window.location = base_url + "profiles/" + response.user_slug;
                    } else {
                        window.location = base_url + "basic-information";//"profiles/" + response.user_slug;    
                    }
                    
                } else if (response.data == "password") {
                    var id = response.id;
                    window.location = base_url + "login?error_msg=2&lwc=" + id;
                } else {
                    window.location = base_url + "login?error_msg=1";
                }
                $('#login_ajax_load').hide();
            }
        });
        return false;
    }
    /* login submit */
});

// login validtaion and submit end 
// validation for edit email formate form strat 

$(document).ready(function () {
    $("#register_form")[0].reset();
    $("#register_form #email_reg").val('');
    $("#register_form #password_reg").val('');

    /*$.validator.addMethod("lowercase", function (value, element, regexpr) {
     return regexpr.test(value);
     }, "Email Should be in Small Character");
     */
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
//                email: true,
                //lowercase: /^[0-9a-z\s\r\n@!#\$\^%&*()+=_\-\[\]\\\';,\.\/\{\}\|\":<>\?]+$/,
                remote: {
                    url: base_url + "registration/check_email",
                    type: "post",
                    data: {
                        email_reg: function () {
                            return $("#email_reg").val();
                        },
                        'aileensoulnewfrontcsrf': get_csrf_hash,
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
            'aileensoulnewfrontcsrf': get_csrf_hash,
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
                $("#btn-register").html('Sign Up');
                $('#registration_ajax_load').show();
            },
            success: function (response)
            { 
                var userid = response.userid;
                if (response.okmsg == "ok") {
                    $("#btn-register").html('<img src="' + base_url + 'images/btn-ajax-loader.gif" /> &nbsp; Sign Up ...');
                   // window.location = base_url + "profiles/" + response.userslug;
                    //window.location = base_url + "profiles/basic-information/" + response.userslug;

                    if(response.is_userBasicInfo==1 || response.is_userStudentInfo==1){
                        window.location = base_url + "profiles/" + response.user_slug;
                    } else {
                        window.location = base_url + "basic-information";//"profiles/" + response.user_slug;    
                    }
                    sendmail(userid);
                } else {
                    $("#register_error").fadeIn(1000, function () {
                        $("#register_error").html('<div class="alert alert-danger main"> <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; ' + response + ' !</div>');
                        $("#btn-register").html('Sign Up');
                    });
                }
                $('#registration_ajax_load').hide();
            }
        });
        return false;
    }
});

// forgot password script start 
function sendmail(userid) {


    var post_data = {
        'userid': userid,
    }

    $.ajax({
        type: 'POST',
        url: base_url + 'registration/sendmail',
        data: post_data,
        success: function (response)
        {
        }
    });
    return false;
}

// Get the modal
//var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
//var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function () {
   $('#forgotPassword').modal('show');
}

// When the user clicks on <span> (x), close the modal
//span.onclick = function () {
//    modal.style.display = "none";
//}

// When the user clicks anywhere outside of the modal, close it
//window.onclick = function (event) {
//    if (event.target == modal) {
//        modal.style.display = "none";
//    }
//}
// forgot password script end 
$(document).ready(function () {
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


// disable spacebar js start
$(document).ready(function () {
    $("#email_reg").on("keydown", function (e) {
        return e.which !== 32;
    });
});

$(document).ready(function () {
    $("#password_reg").on("keydown", function (e) {
        return e.which !== 32;
    });
});

jQuery('.carousel').carousel({
    interval: 4000
});
// disable spacebar js end

$(document).on('keydown', function (e) {
    if (e.keyCode === 27) {
        $("#myModal").hide();
    }
});

function changeMe(sel)
{
    sel.style.color = "#000";
}
