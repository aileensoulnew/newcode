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
<html lang="en">
    <head>
        <title><?php echo $title; ?></title>
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <meta charset="utf-8">
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
        <?php
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <link rel="canonical" href="<?php echo $actual_link ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />    

<?php if (IS_OUTSIDE_CSS_MINIFY == '0') { ?>    
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/blog.css?ver=' . time()); ?>">
<?php } else { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" href="<?php echo base_url('assets/css_min/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/blog.css?ver=' . time()); ?>">
<?php } ?>
    </head>
    <body class="outer-page">
        <div class="main-inner">
            <div class="profile-bnr">
                <img src="<?php echo base_url('assets/img/bp.jpg?ver=' . time()); ?>" alt="banner-image">

                <header class="profile-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 col-sm-3 left-header">
                                <div class="logo"><a href="<?php echo base_url(); ?>"><img style="height:30px; width:auto;" src="<?php echo base_url('assets/img/logo2.png'); ?>" alt="logo"></a></div>
                            </div>
                            <div class="col-md-8 col-sm-9 right-header">
                                <div class="btn-right pull-right">
<?php if (!$this->session->userdata('aileenuser')) { ?>
                                        <a href="<?php echo base_url('login'); ?>" class="btn-new1">Login</a>
                                        <a href="<?php echo base_url('registration'); ?>" class="btn3-cust">Create an account</a>
<?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="container">
                    <div class="prof-title" style="left:39%;">
                        <!--h1>Freelancer Profile</h1-->
                    </div>
                </div>
            </div>		
			<div class="fw pt20">
				<div class="container pt20">
<?php
if (!$this->session->userdata('aileenuser') || $is_profile['is_business'] != '1') {
    ?>
                            <div class="text-center introduce_button"><a href="<?php echo base_url('business-profile/registration/business-information') ?>" title="Create Business Profile" target="_blank" class="btn-new1">Create Business Profile</a></div>
                            <?php } else {
                            ?>

                            <div class="text-center introduce_button"><a href="<?php echo base_url('business-profile') ?>" title="Take me in" target="_blank" class="btn-new1">Take me in</a></div>
<?php }
?>
						</div>
						</div>
            <section class="middle-main bg_white">
                <div class="container">
                    <div class="profiles-details">
                        <div class="top-detail text-center">

                            <p>In our rapidly evolving world that is characterised by dynamic and dramatic changes, the need to collaborate, ideate, network and foster new relationships has non-negotiable for one’s survival and continual success in the competitive business environment of today. Aileensoul is a sophisticated and tech-enabled platform that enables growing businesses and start-ups to magnify their business contacts and network through impactful collaboration and networking with other players in their respective fields and sectors. Providing a host of career-related opportunities that enable individuals to build, rediscover and advance their careers, the innovative platform comes with distinct service profiles, including its ‘Business Profile’ that is designed to help business owners seek advice and find solutions to everyday challenges and complexities that are unique to their type of industry and business segment.</p>
                        </div>

                        <div class="row dis-box">
                            <h2>Aileensoul - Cost-Free and Enriching Business Collaboration Is Now at Your Fingertips</h2>
                            <div class="col-md-6 col-sm-12 pb20">
                                <img style="width:100%;" src="<?php echo base_url('assets/img/bus1.jpg?ver=' . time()); ?>" alt="business-image">
                            </div>
                            <div class="col-md-6 col-sm-12 pb20">
                                <p>One of the common challenges faced by many small-sized companies and upcoming ventures is their relative unfamiliarity and unpreparedness for the typical bottlenecks of their industry, owing to their lack of adequate awareness and experience in their respective fields and domains. Often, such firms struggle to find the right channel or resources to help them manage and overcome their growth-limiting issues and obstacles. <br>
                                    Aileensoul aims to break this networking barrier by giving small firms a chance to join relevant business communities and engage with like-minded and influential people who can play a pivotal role in developing their network, equip them with referrals/leads and introduce them to prospective customers and/or partners to help them grow and expand their business. Moreover, such communities can aid start-ups in finding angel investors who can provide them with the necessary funding to solve their capital woes. The best part is that Aileensoul offers all these services completely free of cost and with the sole intent of providing ‘hope for the souls’ - a theme that exemplifies its motto and intent.
                                </p>
                            </div>
                        </div>
                        <div class="row dis-box">
                            <h2>How to Register With Aileensoul’s Business Profile?</h2>
                            <div class="col-md-6 col-sm-12 pb20 pull-right">
                                <img style="width:100%;" src="<?php echo base_url('assets/img/bus2.jpg'); ?>" alt="business-image">
                            </div>
                            <div class="col-md-6 col-sm-12 pb20 pull-left">
                                <p>After successfully registering with the platform, you need to register with Aileensoul’s ‘Business Profile’ to take advantage of the latter’s features and functionalities. The registration process is easy and self-explanatory with few basic steps that require completion. These include furnishing information about your company’s name, address and contact details, specifying the business type, category and description and uploading of appropriate business images of high quality and resolution. Once you have provided the necessary information, you need to click on the ‘Submit’ button to complete the profile creation process. 
                                </p>
                            </div>
                        </div>
                        <div class="row dis-box">
                            <h2>Additional Features of Aileensoul’s Business Profile:</h2>
                            <div class="col-md-6 col-sm-12 pb20">
                                <img style="width:100%;" src="<?php echo base_url('assets/img/bus3.jpg?ver=' . time()); ?>" alt="business-image">
                            </div>
                            <div class="col-md-6 col-sm-12 pb20">
                                <p>Other than networking, entrepreneurs, professionals and business owners can follow specific business categories of their interest and relevance to stay updated with the latest happenings in their chosen space in the form of regular and continuous newsfeed. They can even demonstrate their preference and inclination for specific type of content by liking and commenting on the posts of others. Additionally, they can promote and spread awareness about their own brands by uploading interesting and thought-provoking posts and PDF attachments along with photos, videos and audios to spark the curiosity and interest of their target audience.  

                                </p>
                            </div>
                        </div>
						<div class="fw">
<?php
if (!$this->session->userdata('aileenuser') || $is_profile['is_business'] != '1') {
    ?>
                            <div class="text-center pb20 introduce_button"><a href="<?php echo base_url('business-profile/registration/business-information') ?>" title="Create Business Profile" target="_blank" class="btn-new1">Create Business Profile</a></div>
                            <?php } else {
                            ?>

                            <div class="text-center pb20 introduce_button"><a href="<?php echo base_url('business-profile') ?>" title="Take me in" target="_blank" class="btn-new1">Take me in</a></div>
<?php }
?>
						</div>
                    </div>
                </div>
            </section>
        </div>

<?php echo $login_footer ?>
    </body>
</html>
