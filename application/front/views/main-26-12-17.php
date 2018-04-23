<!DOCTYPE html>
<?php

if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
    // $date = $_SERVER['HTTP_IF_MODIFIED_SINCE'];
    header("HTTP/1.1 304 Not Modified");
    exit();
}

$format = 'D, d M Y H:i:s \G\M\T';
$now = time();

$date = gmdate($format, $now);
header('Date: '.$date);
header('Last-Modified: '.$date);

$date = gmdate($format, $now+30);
header('Expires: '.$date);
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
//header('Cache-Control: public, max-age=30');

?>
<html lang="en" class="custom-main">
    <head>
        <meta charset="utf-8">
        <title>Build Career in Business, Freelancing, Job & Art with Aileensoul.com</title>
        <meta name="description" content="Aileensoul provides completely free platform for career-related services, such as job, hiring, freelancing, business networking, artistic and much more.">
        <meta property="og:title" content="Build Career in Business, freelancing, Job & Art with Aileensoul.com" />
        <meta property="og:description" content="Aileensoul provides completely free platform for career-related services, such as job, hiring, freelancing, business networking, artistic and much more."/>
        <meta property="og:image" content="<?php echo base_url('assets/images/meta-icon.png'); ?>" />
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({
                google_ad_client: "ca-pub-6060111582812113",
                enable_page_level_ads: true
            });
        </script>
        <?php
        if ($_SERVER['HTTP_HOST'] != "localhost") {
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
        if (IS_OUTSIDE_CSS_MINIFY == '0') {
            ?>
           <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css?ver="<?php echo time() ?>>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
            <?php
        } else {
            ?>
         <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css?ver="<?php echo time() ?>>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/common-style.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css?ver=' . time()); ?>">
        <?php } ?>
        
        <?php
        if (IS_OUTSIDE_JS_MINIFY == '0') {
            ?>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script> 
            <?php
        } else {
            ?>
        <script src="<?php echo base_url('assets/js_min/jquery-3.2.1.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script> 
        <?php } ?>
        
       
<!--        <link rel="stylesheet" type="text/css" href="<?php //echo base_url('assets/css/cookieconsent.min.css') ?>" />
        <script src="<?php //echo base_url('assets/js/cookieconsent.min.js') ?>"></script>
        <script>
                window.addEventListener("load", function () {
                    window.cookieconsent.initialise({
                        "palette": {
                            "popup": {
                                "background": "#eaf7f7",
                                "text": "#5c7291"
                            },
                            "button": {
                                "background": "#56cbdb",
                                "text": "#ffffff"
                            }
                        },
                        "type": "opt-out",
                        "content": {
                            "href": "https://www.aileensoul.com/privacy-policy"
                        }
                    })
                });
        </script>-->
    </head>
    <body class="custom-landscape">
    <!--    <script type="application/ld+json">
            {
            "@context": "http://schema.org",
            "@type": "Organization",
            "name": "Aileensoul",
            "url": "https://www.aileensoul.com",
            "sameAs": [
            "https://www.facebook.com/aileensouldotcom/",
            "https://twitter.com/aileen_soul"
            "https://instagram.com/aileensoul_com",
            "https://in.linkedin.com/in/aileensouldotcom",
            "https://plus.google.com/+Aileensoul",
            ]
            }
        </script>-->
        <div class="main-login">
            <header>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-3 col-lg-5">
                            <a tabindex="1"  href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png?ver='.time()) ?>" alt="logo"></a>
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
                                    <button id="login-new" title="Login" tabindex="1"  class="btn1">Login</button>
                                    <a tabindex="1" id="myBtn"  class="f-pass" href="javascript:void(0)" title="Forgot Password">Forgot Password?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            <!-- model for forgot password start -->
            <!-- model for forgot password end -->
            <!--   <div id="error"></div> -->
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
                                    <form name="register_form" id="register_form" method="post">
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
                                            <input tabindex="3" type="text" name="email_reg" id="email_reg" class="form-control input-sm" placeholder="Email Address" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <input tabindex="4" type="password" name="password_reg" id="password_reg" class="form-control input-sm" placeholder="Password">
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
                                        <div class="dateerror" style="color:#f00; display: block;"></div>
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
                                            <button id="create-acc-new" title="Create an account" tabindex="11" class="btn1">Create an account</button>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="myModal" class="modal">
                    <div class="modal-content md-2">
                        <?php
                        $form_attribute = array('name' => 'forgot', 'method' => 'post', 'class' => 'forgot_password', 'id' => 'forgot_password');
                        echo form_open('profile/forgot_password', $form_attribute);
                        ?>
                        <div class="modal-header" style=" text-align: center;">
                            <span class="close">&times;</span>
                            <label style="color: #a0b3b0;">Forgot Password</label>
                        </div>
                        <div class="modal-body" style="text-align: center;">
                            <label  style="margin-bottom: 15px; color: #a0b3b0;"> Enter your e-mail address below to get your password.</label>
                            <input style="" type="text" name="forgot_email" id="forgot_email" placeholder="Email*" autocomplete="off" class="form-control placeholder-no-fix">
                        </div>
                        <div class="modal-footer ">
                            <div class="submit_btn">              
                                <input class="btn btn-theme btn1" type="submit" name="submit" value="Submit" /> 
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>


            </section>
            <?php echo $login_footer ?>
        </div>
        <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
    <!--    <script>
                                                var loader = document.getElementById('adsense-loader');
                                                document.getElementById("adsense").appendChild(loader);
        </script>-->

        <!--    <div id="adsense-loader" style="display:block;">
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <script>
                                                    (adsbygoogle = window.adsbygoogle || []).push({
                                                        google_ad_client: "ca-pub-6060111582812113",
                                                        enable_page_level_ads: true
                                                    });
                </script>
            </div>-->
        <script>
                                                    var user_slug = '<?php echo $this->session->userdata('aileenuser_slug'); ?>';
                                                    var base_url = '<?php echo base_url(); ?>';
                                                    var data = <?php echo json_encode($demo); ?>;
                                                    var data1 = <?php echo json_encode($city_data); ?>;
                                                    var get_csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
                                                    var get_csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
        </script>
          <?php
        if (IS_OUTSIDE_CSS_MINIFY == '0') {
            ?>
           <script src="<?php echo base_url('assets/js/webpage/main.js?ver=' . time()); ?>"></script>
            <?php
        } else {
            ?>
             <script src="<?php echo base_url('assets/js_min/webpage/main.js?ver=' . time()); ?>"></script>
        <?php } ?>
        
    </body>
</html>
