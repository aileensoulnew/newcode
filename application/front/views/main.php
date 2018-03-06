<!DOCTYPE html>
<?php
if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
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
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<html lang="en" class="custom-main">
    <head>
        <meta charset="utf-8">
        <title>Build Career in Business, Freelancing, Job & Art with Aileensoul.com</title>
        <meta name="description" content="Aileensoul provides completely free platform for career-related services, such as job, hiring, freelancing, business networking, artistic and much more.">
        <meta property="og:title" content="Build Career in Business, freelancing, Job & Art with Aileensoul.com" />
        <meta property="og:description" content="Aileensoul provides completely free platform for career-related services, such as job, hiring, freelancing, business networking, artistic and much more."/>
        <meta property="og:image" content="<?php echo base_url('assets/images/meta-icon.png'); ?>" />
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
        <meta name="p:domain_verify" content="d0a13cf7576745459dc0ca6027df5513"/>
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
        <?php
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <link rel="canonical" href="<?php echo $actual_link ?>" />
        <?php
        if (IS_OUTSIDE_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css?ver=' . time()); ?>">
        <?php } ?>

        <?php
        if (IS_OUTSIDE_JS_MINIFY == '0') {
            ?>
            <script data-pagespeed-no-defer src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()); ?>"></script>
            <script data-pagespeed-no-defer src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script> 
            <?php
        } else {
            ?>
            <script data-pagespeed-no-defer src="<?php echo base_url('assets/js_min/jquery-3.2.1.min.js?ver=' . time()); ?>"></script>
            <script data-pagespeed-no-defer src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script> 
        <?php } ?>
    </head>
    <body class="custom-landscape">
        <div class="main-login">
            <header>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-3 col-lg-5">
                            <a tabindex="1"  href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png?ver=' . time()) ?>" alt="logo"></a>
                        </div>
                        <div class="col-lg-1"></div>
                        <div class="col-md-8 col-sm-9 col-lg-6">
                            <form class="header-login" name="login_form" id="login_form" method="post">
                                <div class="input">
                                    <input type="email" tabindex="1"  name="email_login" id="email_login" class="form-control input-sm" placeholder="Email Address">
                                </div>
                                <div class="input">
                                    <input type="password" tabindex="1"  name="password_login" id="password_login" class="form-control input-sm" placeholder="Password">
                                </div>
                                <div class="btn-right">
                                    <button id="login-new" title="Login" tabindex="1"  class="btn1">Login <span class="ajax_load" id="login_ajax_load"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
                                    <a tabindex="1" id="myBtn"  class="f-pass" href="javascript:void(0)" title="Forgot Password">Forgot Password?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            <section class="middle-main">
                <div class="container">
                    <div class="mid-trns">
                        <div class="">
                            <div class="col-md-7 col-sm-6">
                                <div class="top-middle">
                                    <div class="text-effect"><p>We provide platform & opportunities to</p><p>every person in the world to make their career.</p></div>
                                </div>
                                <div class="bottom-middle">
                                    <div id="carouselFade" class="carousel slide carousel-fade" data-ride="carousel">
                                        <!-- Wrapper for slides -->
                                        <div class="carousel-inner" role="listbox">
                                            <div class="item active">  
                                                <div class="carousel-caption">
                                                    <img src="<?php echo base_url('assets/img/job1.png?ver=' . time()); ?>" alt="Job Profile">
                                                    <div class="carousel-text">
                                                        <h3>Job Profile</h3>
                                                        <p>Find best job options and connect with recruiters.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item"> 
                                                <div class="carousel-caption">
                                                    <img src="<?php echo base_url('assets/img/rec.png?ver=' . time()); ?>" alt="Recruiter">
                                                    <div class="carousel-text">
                                                        <h3>Recruiter Profile</h3>
                                                        <p>Hire quality employees here.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item"> 
                                                <div class="carousel-caption">
                                                    <img src="<?php echo base_url('assets/img/freelancer.png?ver=' . time()); ?>" alt="Freelancer">
                                                    <div class="carousel-text">
                                                        <h3>Freelance Profile</h3>
                                                        <p>Hire freelancers and also find freelance work.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item"> 
                                                <div class="carousel-caption">
                                                    <img src="<?php echo base_url('assets/img/business.png?ver=' . time()); ?>" alt="Business">
                                                    <div class="carousel-text">
                                                        <h3>Business Profile</h3>
                                                        <p>Grow your business network.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item"> 
                                                <div class="carousel-caption">
                                                    <img src="<?php echo base_url('assets/img/art.png?ver=' . time()); ?>" alt="Artistic">
                                                    <div class="carousel-text">
                                                        <h3>Artistic Profile</h3>
                                                        <p> Show your art & talent to the world.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-6 custom-padd">
                                <div class="login">
                                    <h4>Join Aileensoul - It's Free</h4>
                                    <form name="register_form" id="register_form" method="post" autocomplete="off">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <input tabindex="1" autofocus type="text" name="first_name" id="first_name" class="form-control input-sm" placeholder="First Name">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <input tabindex="2" type="text" name="last_name" id="last_name" class="form-control input-sm" placeholder="Last Name">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input tabindex="3" type="email" name="email_reg" id="email_reg" class="form-control input-sm" placeholder="Email Address" autocomplete="new-email">
                                        </div>
                                        <div class="form-group">
                                            <input tabindex="4" type="password" name="password_reg" id="password_reg" class="form-control input-sm" placeholder="Password" autocomplete="new-password">
                                        </div>
                                        <div class="form-group dob">
                                            <label class="d_o_b"> Date Of Birth :</label>
                                            <span>
                                                <select tabindex="5" class="day" name="selday" id="selday">
                                                    <option value="" disabled selected>Day</option>
                                                    <?php
                                                    for ($i = 1; $i <= 31; $i++) {
                                                        ?>
                                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </span>
                                            <span>
                                                <select tabindex="6" class="month" name="selmonth" id="selmonth">
                                                    <option value="" disabled selected>Month</option>
                                                    <option value="1">Jan</option>
                                                    <option value="2">Feb</option>
                                                    <option value="3">Mar</option>
                                                    <option value="4">Apr</option>
                                                    <option value="5">May</option>
                                                    <option value="6">Jun</option>
                                                    <option value="7">Jul</option>
                                                    <option value="8">Aug</option>
                                                    <option value="9">Sep</option>
                                                    <option value="10">Oct</option>
                                                    <option value="11">Nov</option>
                                                    <option value="12">Dec</option>
                                                </select>
                                            </span>
                                            <span>
                                                <select tabindex="7" class="year" name="selyear" id="selyear">
                                                    <option value="" disabled selected>Year</option>
                                                    <?php
                                                    for ($i = date('Y'); $i >= 1900; $i--) {
                                                        ?>
                                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select></span>
                                        </div>
                                        <div class="dateerror"></div>
                                        <div class="form-group gender-custom">
                                            <span>
                                                <select tabindex="8" class="gender"  onchange="changeMe(this)" name="selgen" id="selgen">
                                                    <option value="" disabled selected>Gender</option>
                                                    <option value="M">Male</option>
                                                    <option value="F">Female</option>
                                                </select>
                                            </span>
                                        </div>
                                        <p class="form-text">
                                            By Clicking on create an account button you agree our<br class="mob-none">
                                            <a href="<?php echo base_url('terms-and-condition'); ?>" title="Terms and Condition" tabindex="9" target="_blank">Terms and Condition</a> and <a tabindex="10" href="<?php echo base_url('privacy-policy'); ?>" title="Privacy policy" target="_blank">Privacy policy</a>.
                                        </p>
                                        <p>
                                            <button id="create-acc-new" title="Create an account" tabindex="11" class="btn1">Create an account<span class="ajax_load pl10" id="registration_ajax_load"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
        <!-- model for forgot password start -->
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
                                        <p class="ttc tlh2">Forgot Password</p>
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

            </section>
            <?php echo $login_footer ?>
        </div>
        <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script>
                var user_slug = '<?php echo $this->session->userdata('aileenuser_slug'); ?>';
                var base_url = '<?php echo base_url(); ?>';
                var data = <?php echo json_encode($demo); ?>;
                var data1 = <?php echo json_encode($city_data); ?>;
                var get_csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
                var get_csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
        </script>
        <script src="<?php echo base_url('assets/js/webpage/main.js?ver=' . time()); ?>"></script>
        <?php
        if (IS_OUTSIDE_JS_MINIFY == '0') {
            ?>
            <!--<script src="<?php echo base_url('assets/js/webpage/main.js?ver=' . time()); ?>"></script>-->
            <?php
        } else {
            ?>
            <!--<script src="<?php echo base_url('assets/js_min/webpage/main.js?ver=' . time()); ?>"></script>-->
        <?php } ?>
    </body>
</html>
