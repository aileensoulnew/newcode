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

header('Cache-Control: public, max-age=30');
?>
<html lang="en" class="add-wi-us">
    <head>
        <title>Advertise With Us - Aileensoul</title>
        <meta name="description" content="Promote your business with Aileensoul.com" />
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <meta charset="utf-8">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <?php
        if ($_SERVER['HTTP_HOST'] == "www.aileensoul.com") {
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
        <?php
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <link rel="canonical" href="<?php echo $actual_link ?>" />
        <meta name="google-site-verification" content="BKzvAcFYwru8LXadU4sFBBoqd0Z_zEVPOtF0dSxVyQ4" />
        <?php if (IS_OUTSIDE_CSS_MINIFY == '0') { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/bootstrap.min.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/animte.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/component.css?ver=' . time()); ?>" />
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>">
        <?php } else { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/bootstrap.min.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/animte.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/component.css?ver=' . time()); ?>" />
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>">
        <?php } ?>
    </head>
    <body class="main-db add-with-us">
        <div class="web-header">
            <header class="custom-header">
                <div class="header animated fadeInDownBig">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 left-header">
                                <h2 class="logo"><a href="<?php echo base_url() ?>"><img src="<?php echo base_url('assets/img/logo-name.png') ?>"></a></h2>
								
                                <!--form>
                                        <input type="text" name="search" placeholder="Search..">
                                </form-->
                            </div>
                            <div class="col-md-6 col-sm-6 right-header text-right">
                                <?php if (!$this->session->userdata('aileenuser')) { ?>
                                    <a href="<?php echo base_url('login'); ?>" class="btn6">Login</a>
                                    <a href="<?php echo base_url('registration'); ?>" class="btn7">Create an account</a>
                                <?php } ?>
                            </div>
                         </div>
                    </div>
                </div>

            </header>

        </div>


        <div class="middle-section">

            <div class="add-banner">
                <img src="<?php echo base_url('assets/n-images/add-with-us.jpg') ?>" alt="Advertise With Us">
                <h1>Promote Your Business With Aileensoul</h1>
            </div>
            <div class="container">
                <div class="add-content">
                    <div class="fw p20">
                        <div class="add-title">
                            <h2>How to Advertise with us?</h2>
                        </div>
                        <div class="row">
                 
                            <div class="col-md-8 col-md-push-2">
                                <img src="<?php echo base_url('assets/n-images/HowtoAdvertiseWithUs.jpg') ?>" alt="Advertise With Us">
                            </div>
                        </div>
                    </div>
                    <div class="fw p20">
                        <div class="add-title">
                            <h2>How your Advertise display?</h2>
                        </div>
                        <div class="">
                           <img src="<?php echo base_url('assets/n-images/Advertisedisplay.jpg') ?>" alt="Advertise With Us">
                        </div>
                    </div>
                    <div class="fw p20">
                        <div class="add-title">
                            <h2>Our Audience.</h2>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="audience-box">
                                    <img src="<?php echo base_url('assets/n-images/Freelnace.jpg') ?>" alt="Advertise With Us">
                                    <h3>Freelance-Employer</h3>
                                    <p>Getting leads seem difficult for you? Don't worry! We have covered your back. Our Freelance-Employer draws clients from all over the world who render projects to freelancers. Hence, advertise in this profile will be of great benefit.</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="audience-box">
                                    <img src="<?php echo base_url('assets/n-images/Business.jpg') ?>" alt="Advertise With Us">
                                    <h3>Business Profile</h3>
                                    <p>The business profile in Aileensoul consists businesses from various fields such as IT sector, Medical, Clothing or any domain you name. Advertising in this profile will yield a great exposure in several industries which will help you in enlarging your business.</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="audience-box">
                                    <img src="<?php echo base_url('assets/n-images/Artist.jpg') ?>" alt="Advertise With Us">
                                    <h3>Artistic Profile</h3>
                                    <p>The artistic profile is a very innovative and unique profile.It consists of talented people showcasing their art and talent. Ads in this profile will connect your brand to this talented person which were otherwise would have been unreachable.</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="audience-box">
                                    <img src="<?php echo base_url('assets/n-images/freelance-apply.jpg') ?>" alt="Advertise With Us">
                                    <h3>Freelance apply Profile</h3>
                                    <p>Reach more than 5000 audiences of different age group from different countrieshave different sets of skills. The core benefit for an advertiser from thefreelance profile is a massive reach and high growth for his venture.</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="audience-box">
                                    <img src="<?php echo base_url('assets/n-images/recruiter.jpg') ?>" alt="Advertise With Us">
                                    <h3>Recruiter Profile</h3>
                                    <p>Get noticed by the talent hunters who constantly look to connect with great enthusiastic peoples! The advantage of advertising in recruiter profile is that it will help you in making loyal connections and growing network.</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="audience-box">
                                    <img src="<?php echo base_url('assets/n-images/Job-Seeker-.jpg') ?>" alt="Advertise With Us">
                                    <h3>Job Profile</h3>
                                    <p>AileenSoul offers a great platform for ajob seeker to get an opportunity to grow their career. If your advertisement goal is to reach a young audience who are regular web visitors, then this profile will help to spread your message in front of them.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="add-form">
                    <div class="add-form-title">
                        <h2>Reach Us</h2>
                        <p>Drop your advertising inquiries</p>
                    </div>
                    <form name="advertise" id="advertise" method="POST">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" id="firstname" name="firstname" placeholder="First Name">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="lastname" name="lastname"  placeholder="Last Name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" id="email" name="email" placeholder="Email Address">
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <textarea id="message" name="message" placeholder="Your Requirement"></textarea>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <input type="submit" class="btn1" id="submit" name="submit" value="Submit">
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
				<p class="text-center more-support">For more support <a href="mailto:inquiry@aileensoul.com">inquiry@aileensoul.com</a>
			</div>
        </div>
        <div class="modal fade message-box biderror" id="bidmodal" role="dialog"  >
            <div class="modal-dialog modal-lm" >
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $login_footer ?>
        <script>
            var base_url = '<?php echo base_url(); ?>';

        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js?ver=<?php echo time(); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/advertise.js?ver=' . time()); ?>); ?>"></script>
    </body>
</html>