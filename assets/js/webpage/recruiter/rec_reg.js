$(document).ready(function () {

     $('.ajax_load').hide();

  });
  
function reg_loader(){

      var form = $("#basicinfo");
    if(form.valid() == true ){
     //$('#profilereg_ajax_load').show();
    // document.getElementById('profilereg_ajax_load').style.display = 'inline-block';
     
    }

}   


$.validator.addMethod("regx", function (value, element, regexpr) {
    return regexpr.test(value);
}, "Number, space and special character are not allowed.");

// compnay info start
jQuery.validator.addMethod("noSpace", function (value, element) {
    return value == '' || value.trim().length != 0;
}, "No space please and don't leave it empty");

$(".alert").delay(3200).fadeOut(300);
// compnay info end
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
            first_name1: {
                required: true,
            },
            last_name1: {
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
                    first_name1: {
                        required: "Please enter first name",
                    },
                    last_name1: {
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
        var first_name = $("#first_name1").val();
        var last_name = $("#last_name1").val();
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
            { 
                //alert(postid);
                var userid = response.userid;
                if (response.okmsg == "ok") {
                   
                    window.location = base_url + "recruiter/registration";
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

    $("#basicinfo").validate({

        rules: {

            first_name: {

                required: true,
                regx: /^[a-zA-Z]+$/,
                //noSpace: true

            },

            last_name: {

                required: true,
                regx: /^[a-zA-Z]+$/,
                //noSpace: true

            },

            email: {
                required: true,
                email: true,
                remote: {
                    url: base_url + "recruiter/check_email",
                    type: "post",
                    data: {
                        email: function () {
                            return $("#email").val();
                        },
//                        get_csrf_token_name: get_csrf_hash,
                    },
                },
            },
            
            comp_name: {

                required: true,
                regx: /^[a-zA-Z0-9\s]*[a-zA-Z][a-zA-Z0-9]*[-@./#&+,\w\s]/
                        //noSpace: true

            },

            comp_email: {

                required: true,
                email: true,
                remote: {
                    url: base_url + "recruiter/check_email_com",
                    type: "post",
                    data: {
                        email: function () {
                            return $("#comp_email").val();
                        },
//                         get_csrf_token_name: get_csrf_hash,
                    },
                },
            },

            comp_num: {

                number: true,
                minlength: 8,
                maxlength: 15
            },
            
             comp_profile: {

                maxlength: 2500

            },
            
            
             country: {

                required: true,

            },

            state: {

                required: true,

            },

            

        },

        messages: {

            first_name: {

                required: "First name is required.",
            },

            last_name: {

                required: "Last name is required.",
            },

            email: {
                required: "Email id is required.",
                email: "Please enter valid email id.",
                remote: "Email already exists."
            },
            
            comp_name: {

                required: "Company name is required.",

            },

            comp_email: {

                required: "Email address is required.",
                email: "Please enter valid email id.",
                remote: "Email already exists."
            },

            comp_num: {

                required: "Phone no is required.",

            },
            
             country: {

                required: "Country is required.",

            },

            state: {

                required: "State is required.",

            },

            
        },
        submitHandler: submitrecruiterForm
    });
});



function submitrecruiterForm()
    {

      var first_name = $("#first_name").val();
      var last_name = $("#last_name").val();
      var email = $("#email").val();
      var comp_name = $("#comp_name").val();
      var comp_email = $("#comp_email").val();
      var comp_num = $("#comp_num").val();
      var country = $("#country").val();
      var state = $("#state").val();
      var city = $("#city").val();
      var comp_profile = $("#comp_profile").val();
      var segment =$('#segment').val();
     
      var post_data = {
            'first_name': first_name,
            'last_name': last_name,
            'email': email,
            'comp_name': comp_name,
            'comp_email': comp_email,
            'comp_num': comp_num,
            'country': country,
            'state': state,
            'city': city,
            'comp_profile': comp_profile,
            'segment': segment
          //  'aileensoulnewfrontcsrf': get_csrf_hash,
        }
        
        $.ajax({
            type: 'POST',
            url: base_url + 'recruiter/reg_insert',
            dataType: 'json',
            data: post_data,
            beforeSend: function ()
            {
//                $("#register_error").fadeOut();
//                $("#btn-register").html('Sign Up');
            },
            success: function (response)
            {
              
                if (response.okmsg == "ok") {
                    // if(response.segment == 'live-post') {
                    //     window.location = base_url + "recruiter/post";
                    // }else{
                    //     window.location = base_url + "recruiter/add-post";
                    // }
                       window.location = base_url + "recruiter/home";
                } else {
                    window.location = base_url + "recruiter/";
                }
            }
        });
         return false;
    }
// country state start


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

////DISABLE BUTTON ON ONE TIME CLICK START
$("#submit").on('click', function ()
{
    if ($('#basicinfo').valid())
    {
        $("#submit").addClass("register_disable");
        return true;
    }

});
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
function create_profile(){
    $('#login').modal('hide');
    $('#register').modal('show');
}
  /* validation */

 $( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) {
            if($('#forgotPassword').modal('show')){
         $('#forgotPassword').modal('hide');
         $('#login').modal('show');
       }
    }
});

function forgot_close() {
                $('#login').modal('show');
}

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
                  //  alert("login");
                    $("#btn1").html('<img src="' + base_url + 'images/btn-ajax-loader.gif" /> &nbsp; Login ...');
                    window.location = base_url + "recruiter/home";
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