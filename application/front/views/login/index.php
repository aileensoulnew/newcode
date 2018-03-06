<!DOCTYPE html>
<?php
if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
    // $date = $_SERVER['HTTP_IF_MODIFIED_SINCE'];
    header("HTTP/1.1 304 Not Modified");
    exit();
}

$format = 'D, d M Y H:i:s \G\M\T';
$now = time();

$date = gmdate($format, $now);
header('Date: ' . $date);
header('Last-Modified: ' . $date);

$date = gmdate($format, $now + 30);
header('Expires: ' . $date);

//header('Cache-Control: public, max-age=30');
?>
<html lang="en" class="login-custom">
    <head>
        <meta charset="utf-8">
        <title>Login - Aileensoul</title>
        <meta name="description" content="Login to Aileensoul.com dashboard and get updates on your profiles." />
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <meta name="keywords" content="Hire Freelancers, Freelance Jobs Online, Find Freelance Work, Freelance Jobs, Get Online Work, online freelance jobs, freelance websites, freelance portal, online freelance work, freelance job sites, freelance consulting jobs, hire freelancers online, best freelancing sites, online writing jobs for beginners, top freelance websites, freelance marketplace, jobs, Job search, job vacancies, Job Opportunities in India, jobs in India, job openings, Jobs Recruitment, Apply For Jobs, Find the right Job, online job applications, apply for jobs online, online job search, online jobs india, job posting sites, job seeking sites, job search websites, job websites in india, job listing websites, jobs hiring, how to find a job, employment agency, employment websites, employment vacancies, application for employment, employment in india, searching for a job, job search companies, job search in india, best jobs in india, job agency, job placement agencies, how to apply for a job, jobs for freshers, job vacancies for freshers, recruitment agencies, employment agencies, job recruitment, hiring agencies, hiring websites, recruitment sites, corporate recruiter, career recruitment, online recruitment, executive recruiters, job recruiting companies, online job recruitment, job recruitment agencies, it, recruitment agencies, recruitment websites, executive search firms, sales recruitment agencies, top executive search firms, recruitment services, technical recruiter, recruitment services, job recruitment agency, recruitment career" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <?php
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <link rel="canonical" href="<?php echo $actual_link ?>" />
        <?php
        if (IS_OUTSIDE_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">

            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css?ver=' . time()); ?>">

        <?php } ?>
        <?php
        if (base_url() == "https://www.aileensoul.com/") {
            ?>

            <script>
                (function (i, s, o, g, r, a, m) {
                    i['GoogleAnalyticsObject'] = r;
                    i[r] = i[r] || function () {
                        (i[r].q = i[r].q || []).push(arguments)
                    }, i[r].l = 1 * new Date();
                    a = s.createElement(o),
                            m = s.getElementsByTagName(o)[0];
                    a.async = 1;
                    a.src = g;
                    m.parentNode.insertBefore(a, m)
                })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

                ga('create', 'UA-91486853-1', 'auto');
                ga('send', 'pageview');

            </script>
            <meta name="msvalidate.01" content="41CAD663DA32C530223EE3B5338EC79E" />
            <?php
        }
        ?>
        <meta name="google-site-verification" content="BKzvAcFYwru8LXadU4sFBBoqd0Z_zEVPOtF0dSxVyQ4" />
    </head>

    <body class="outer-page">
        <div class="main-inner">
            <header>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-3">
                            <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png?ver=' . time()) ?>" alt="logo"></a>
                        </div>
                        <div class="col-md-8 col-sm-9">
                            <div class="btn-right pull-right">

                                <a href="<?php echo base_url('registration'); ?>" class="btn3">Create an account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <section class="middle-main">
                <div class="container">
                    <div class="form-pd row">
                        <div id="error1">
                            <?php
                            if ($this->session->flashdata('error')) {
                                echo '<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>';
                            }
                            if ($this->session->flashdata('success')) {
                                echo '<div class="alert alert-success">' . $this->session->flashdata('success') . '</div>';
                            }
                            ?>
                        </div>
                        <div class="inner-form login-frm">
                            <div class="login">
                                <div class="title">
                                    <h1 class="ttc">Welcome To Aileensoul</h1>
                                </div>
                                <form name="login_form" id="login_form" method="post">
                                    <div class="form-group">
                                        <input type="email" value="<?php echo $email; ?>" name="email_login" id="email_login" class="form-control input-sm" placeholder="Email Address*">
                                        <div id="error2">
                                            <?php
                                            if ($this->session->flashdata('erroremail')) {
                                                echo $this->session->flashdata('erroremail');
                                            }
                                            ?>
                                        </div>
                                        <div id="errorlogin"></div> 
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password_login" id="password_login" class="form-control input-sm" placeholder="Password*">
                                        <div id="error1">
                                            <?php
                                            if ($this->session->flashdata('errorpass')) {
                                                echo $this->session->flashdata('errorpass');
                                            }
                                            ?>
                                        </div>
                                        <div id="errorpass"></div> 
                                    </div>
                                    <p class="pt-20 ">
                                        <button class="btn1" onclick="login()">Login</button>
                                    </p>
                                    <p class=" text-center">
                                        <a href="javascript:void(0)" id="myBtn">Forgot Password ?</a>
                                    </p>
                                    <p class="pt15 text-center">
                                        Don't have an account? <a href="<?php echo base_url('registration'); ?>">Create an account</a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="modal fade login" id="forgotPassword" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content login-frm">
                        <button type="button" class="modal-close" data-dismiss="modal" onclick="login_profile();">&times;</button>       
                        <div class="modal-body">
                            <div class="right-main">
                                <div class="right-main-inner">
                                    <div class="">
                                        <div id="forgotbuton"></div> 
                                        <div class="title">
                                            <h1 class="ttc tlh2">Forgot Password</h1>
                                        </div>
                                        <?php
                                        $form_attribute = array('name' => 'forgot', 'method' => 'post', 'class' => 'forgot_password', 'id' => 'forgot_password');
                                        echo form_open('profile/forgot_live', $form_attribute);
                                        ?>
                                        <div class="form-group">
                                            <input type="email" value="" name="forgot_email" id="forgot_email" class="form-control input-sm" placeholder="Email Address*">
                                            <div id="error2" style="display:block;">
                                                <?php
                                                if ($this->session->flashdata('erroremail')) {
                                                    echo $this->session->flashdata('erroremail');
                                                }
                                                ?>
                                            </div>
                                            <div id="errorlogin"></div> 
                                        </div>

                                        <p class="pt-20 text-center">
                                            <input class="btn btn-theme btn1" type="submit" name="submit" value="Submit" style="width:105px; margin:0px auto;" /> 
                                        </p>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo $login_footer ?>
        </div>
        
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script>
                        $(document).ready(function () {

                            // text animation effect 
                            var $lines = $('.top-middle h3.text-effect');
                            $lines.hide();
                            var lineContents = new Array();

                            var terminal = function () {

                                var skip = 0;
                                typeLine = function (idx) {
                                    idx == null && (idx = 0);
                                    var element = $lines.eq(idx);
                                    var content = lineContents[idx];
                                    if (typeof content == "undefined") {
                                        $('.skip').hide();
                                        return;
                                    }
                                    var charIdx = 0;

                                    var typeChar = function () {
                                        var rand = Math.round(Math.random() * 150) + 25;

                                        setTimeout(function () {
                                            var char = content[charIdx++];
                                            element.append(char);
                                            if (typeof char !== "undefined")
                                                typeChar();
                                            else {
                                                element.append('<br/><span class="output">' + element.text().slice(9, -1) + '</span>');
                                                element.removeClass('active');
                                                typeLine(++idx);
                                            }
                                        }, skip ? 0 : rand);
                                    }
                                    content = '' + content + '';
                                    element.append(' ').addClass('active');
                                    typeChar();
                                }

                                $lines.each(function (i) {
                                    lineContents[i] = $(this).text();
                                    $(this).text('').show();
                                });

                                typeLine();
                            }

                            terminal();
                        });
        </script>


        <!-- script for login  user valoidtaion start -->
        <?php
        if (IS_OUTSIDE_JS_MINIFY == '0') {
            ?>
            <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
            <?php
        } else {
            ?>
            <script src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <?php } ?>

        <script>
                        var btn = document.getElementById("myBtn");
                        btn.onclick = function () {
                            $('#forgotPassword').modal('show');
                         
                        }
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
                                var redirect_url = '<?php echo $redirect_url; ?>';
                                var post_data = {
                                    'email_login': email_login,
                                    'password_login': password_login,
                                    'redirect_url': redirect_url,
                                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                                }
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo base_url() ?>login/check_login',
                                    data: post_data,
                                    dataType: "json",
                                    beforeSend: function ()
                                    {
                                        $("#error").fadeOut();
                                        $("#btn-login").html('Login ...');
                                    },
                                    success: function (response)
                                    {
                                        if (response.data == "ok") {
                                            $("#btn-login").html('<img src="<?php echo base_url() ?>images/btn-ajax-loader.gif" /> &nbsp; Login ...');
                                            if (redirect_url == '') {
                                                window.location = "<?php echo base_url() ?>profiles/" + response.user_slug;
                                            } else {
                                                window.location = redirect_url;
                                            }
                                        } else if (response.data == "password") {
                                            $("#errorpass").html('<label for="email_login" class="error">Please enter a valid password.</label>');
                                            document.getElementById("password_login").classList.add('error');
                                            document.getElementById("password_login").classList.add('error');
                                            $("#btn-login").html('Login');
                                        } else {
                                            $("#errorlogin").html('<label for="email_login" class="error">Please enter a valid email.</label>');
                                            document.getElementById("email_login").classList.add('error');
                                            document.getElementById("email_login").classList.add('error');
                                            $("#btn-login").html('Login');
                                        }
                                    }
                                });
                                return false;
                            }
                            /* login submit */
                        });



        </script>


        <!-- login validtaion and submit end -->



        <!-- forgot password script start -->


        <script>
            // Get the modal
//            var modal = document.getElementById('myModal');

            // Get the button that opens the modal


            // Get the <span> element that closes the modal
//            var span = document.getElementsByClassName("close")[0];

            // When the user clicks the button, open the modal 


            // When the user clicks on <span> (x), close the modal
//            span.onclick = function () {
//                modal.style.display = "none";
//            }

            // When the user clicks anywhere outside of the modal, close it
//            window.onclick = function (event) {
//                if (event.target == modal) {
//                    modal.style.display = "none";
//                }
//            }
        </script>

        <!-- forgot password script end -->
        <script>
            $(document).ready(function () { //aletr("hii");
                /* validation */
                $("#forgot_password").validate({
                    rules: {
                        forgot_email: {
                            required: true,
                            email: true,
                            remote: {
                                url: "<?php echo site_url() . 'profile/check_emailforget' ?>",
                                type: "post",
                                data: {
                                    email_reg: function () {
                                        // alert("hi");
                                        return $("#forgot_email").val();
                                    },
                                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                                },
                            },

                        }

                    },
                    messages: {
                        forgot_email: {
                            required: "Email Address Is Required.",
                            remote: "Email address not exists",

                        }


                    },

                    submitHandler: submitforgotForm
                });



function submitforgotForm()
{

    var email_login = $("#forgot_email").val();

    var post_data = {
        'forgot_email': email_login,
    }
    $.ajax({
        type: 'POST',
        url: "<?php echo site_url() . 'profile/forgot_live' ?>",
        //url: base_url + 'profile/forgot_live',
        data: post_data,
        dataType: "json",
        beforeSend: function ()
        {
            $("#error").fadeOut();
        },
        success: function (response)
        { 
            if (response.data == "success") {
                $("#forgotbuton").html(response.message);
                setTimeout(function () {
                    $('#forgotPassword').modal('hide');
                    $("#forgotbuton").html('');
                    document.getElementById("forgot_email").value = "";
                }, 5000); 
            } else {
                $("#forgotbuton").html(response.message);
            }
        }
    });
    return false;
}            /* validation */
});
        </script>

        <script>
            $(".alert").delay(3200).fadeOut(300);
        </script>

        <script>
            $(document).on('keydown', function (e) {
                if (e.keyCode === 27) {
                    $("#myModal").hide();
                }
            });
        </script>

    </body>
</html>