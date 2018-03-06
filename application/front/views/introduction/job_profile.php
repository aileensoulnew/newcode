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
        <meta charset="utf-8">
        <title><?php echo $title; ?></title>
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">

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
    <body class="job-pro outer-page">
        <div class="main-inner">
            <div class="profile-bnr">
                <img src="<?php echo base_url('assets/img/jp.jpg?ver=' . time()); ?>" alt="banner-image">

                <header class="profile-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 col-sm-3 left-header">
                                <div class="logo"><a href="<?php echo base_url(); ?>"><img style="height:30px; width:auto;" src="<?php echo base_url('assets/img/logo2.png?ver=' . time()); ?>" alt="logo"></a></div>
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
                    <div class="prof-title" style="left:43%;">
                        <!--h1>Freelancer Profile</h1-->
                    </div>
                </div>
            </div>	
<div class="fw pt20">
<div class="container pt20">
<?php
if (!$this->session->userdata('aileenuser') || $is_profile['is_job'] != '1') {
    ?>
                            <div class="text-center introduce_button"><a href="<?php echo base_url('job/registration') ?>" target="_blank" title="Create Job Profile" class="btn-new1">Create Job Profile</a></div>
                            <?php } else {
                            ?>

                            <div class="text-center introduce_button"><a href="<?php echo base_url('job') ?>" target="_blank" title="Take me in" class="btn-new1">Take me in</a></div>

<?php }
?>
</div>
</div>			

            <section class="middle-main bg_white">
                <div class="container">
                    <div class="profiles-details">
                        <div class="top-detail text-center">

                            <p>Aileensoul is a free platform that offers career-related services to both freshers and experienced professionals from different fields and business sectors. The name ‘Aileensoul’ symbolises ‘light’ or ‘hope for the souls’ - a motto that underpins its very existence and initiation. What make Aileensoul a class apart from other career-oriented platforms are its boutique service profiles that address the diverse and distinct needs of job-seekers, business professionals, freelancers, artistic personalities and recruiting companies. </p>
                        </div>

                        <div class="row dis-box">
                            <h2>Aileensoul - Cutting Across the Barriers of Paid Services and Red Tape</h2>
                            <div class="col-md-6 col-sm-12 pb20">
                                <img style="width:100%;" src="<?php echo base_url('assets/img/job1.jpg?ver=' . time()); ?>" alt="job-image">
                            </div>
                            <div class="col-md-6 col-sm-12 pb20">
                                <p>Aileensoul’s ‘Job Profile’ is one among its several service profiles that have been designed to help career enthusiasts like you find the opportunity of their dreams and advance their careers. Unlike the conventional job search portals that offer paid services or free access to limited site features (freemium model), Aileensoul cuts through such layers of bureaucracy and cost to give you free and full access to every relevant feature and functionality of its platform, thus maintaining complete transparency at every step of your job search process and giving you all the freedom that you need to reach out to your prospective recruiters and engage in purposeful discussions with them to take your candidacy to the next level.   </p>
                            </div>
                        </div>
                        <div class="row dis-box">
                            <h2>How to Register With Aileensoul’s Job Profile?</h2>
                            <div class="col-md-6 col-sm-12 pb20 pull-right cus-job-img">
                                <img style="width:100%;" src="<?php echo base_url('assets/img/job2.jpg?ver=' . time()); ?>" alt="job-image">
                            </div>
                            <div class="col-md-6 col-sm-12 pb20 pull-left">
                                <p>To get started, you first need to create a master profile on the platform. Aileensoul’s registration process is quite simple and straight-forward and requires bare minimum details to grant you access to the site’s contents. Once you have successfully registered yourself with the platform, you will be able to view its five profiles, namely ‘Business’, ‘Job’, ‘Recruiter’, ‘Artistic’ and ‘Freelance’. Because each of them serves a distinct purpose, hence you need to create individual sub-profiles to seek advantage of their varied offerings. 
                                    In order to list your profile under the ‘Job’ category, click on the visible ‘Register’ button which will redirect you to the next page where you will be asked to provide mandatory details about yourself, such as your name, email address, date of birth, languages known etc. Once you have populated your basic information, you will be prompted to list your educational qualifications, project and training/internship details as well as information specific to your work area and work experience (you can choose to skip this section or mark yourself as a ‘fresher’ if you are yet to launch your career). 
                                    Even though the site will let you skip quite a few of these sections if you do not wish to populate every field, it is in your own interest that you devote some time to complete this one-time activity (unless you need to modify your details at a later stage) with thoroughness and accuracy. This is because your profile stands a greater chance of grabbing a recruiter’s attention if you are able to elaborate the key highlights of the project that you have accomplished in a comprehensive and attractive manner and/or if you can successfully emphasise your unique skills using specific keywords and industry-specific terminologies that truly demonstrate your skills and that are frequently looked up by companies and recruiters during their search for candidates with matching skill sets. 
                                    Once you have filled all the important job-related details, click on ‘Submit’ to finish the registration process of your ‘Job Profile’. Next time that you log in to Aileensoul, you will see an active ‘Take me in’ button against this service profile. Tap this button to kick-start the process of job hunting and browse through the recommended job list to shortlist and apply to roles that best complement your skills, experience, interests and salary expectations.
                                </p>
                            </div>
                        </div>
                        <div class="row dis-box">
                            <h2>Additional Features of Aileensoul’s Job Profile:</h2>
                            <div class="col-md-6 col-sm-12 pb20">
                                <img style="width:100%;" src="<?php echo base_url('assets/img/job3.jpg?ver=' . time()); ?>" alt="job-image">
                            </div>
                            <div class="col-md-6 col-sm-12 pb20">
                                <p>To promote seamless communication between you and the recruiter, Aileensoul has an in-built feature lets you view recruiter details (personal as well as company email ids, phone numbers etc. if provided by the recruiter at the time of sign up) and also initiate chat with the hiring executive to clarify doubts and seek additional information about a specific job role or company before you decide to apply for the open position. Apart from interacting with the recruiter regarding a particular job opening, you can also explore the complete list of all the job postings that have been published by him or her on the website to ensure that you do no miss out any career-propelling opportunity that could give your career the desired impetus that it was missing till now.</p>
                            </div>
                        </div>
<div class="fw">
<?php
if (!$this->session->userdata('aileenuser') || $is_profile['is_job'] != '1') {
    ?>
                            <div class="text-center pb20 introduce_button"><a href="<?php echo base_url('job/registration') ?>" target="_blank" title="Create Job Profile" class="btn-new1">Create Job Profile</a></div>
                            <?php } else {
                            ?>

                            <div class="text-center pb20 introduce_button"><a href="<?php echo base_url('job') ?>" target="_blank" title="Take me in" class="btn-new1">Take me in</a></div>

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
