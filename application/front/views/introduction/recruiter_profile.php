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
                <img src="<?php echo base_url('assets/img/rp.jpg?ver=' . time()); ?>" alt="banner-image">

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
                    <div class="prof-title" style="left:39%;">
                        <!--h1>Freelancer Profile</h1-->
                    </div>
                </div>
            </div>		
			<div class="fw pt20">
				<div class="container pt20">
                        <?php
                        if (!$this->session->userdata('aileenuser') || $is_profile['is_recruiter'] != '1') {
                            ?>
                            <div class="text-center introduce_button"><a href="<?php echo base_url('recruiter/registration') ?>" title="Create Recruiter Profile" target="_blank" class="btn-new1">Create Recruiter Profile</a></div>
                        <?php } else {
                            ?>

                            <div class="text-center introduce_button"><a href="<?php echo base_url('recruiter') ?>" title="Take me in" target="_blank" class="btn-new1">Take me in</a></div>

                        <?php } ?>
				</div>
			</div>
            <section class="middle-main bg_white">
                <div class="container">
                    <div class="profiles-details">
                        <div class="top-detail text-center">

                            <p>Aileensoul is a new-age career-oriented portal that provides a host of free services to a diverse audience in relation to job search, hiring, freelancing, business networking and a platform to showcase one’s artistic abilities and talent to the world. The highly sophisticated and tech-enabled website delivers its unique and comprehensive range of offerings through focused service profiles that include its one of a kind ‘Recruiter Profile’, which empowers recruiters to reach out to and interact with qualified and deserving candidates in a completely new and innovative way.  </p>
                        </div>

                        <div class="row dis-box">
                            <h2>Aileensoul - Helping You Fulfil Your Hiring Needs Effectively and At No Cost</h2>
                            <div class="col-md-6 col-sm-12 pb20">
                                <img style="width:100%;" src="<?php echo base_url('assets/img/rec1.jpg?ver=' . time()); ?>" alt="recruiter-image">
                            </div>
                            <div class="col-md-6 col-sm-12 pb20">
                                <p>Gone are the days when internal job postings, referrals, newspaper advertisements, recruitment agencies, college campus recruitments and walk-in interviews were the primary channels for hiring managers and recruiters to find and source talented candidates for various open positions in their companies. In today’s digital era, recruiters are increasingly resorting to online job platforms and social media to speed up their hiring process and make it more simplified, efficient and cost-effective. While job sites can serve as a means to curtail exorbitant hiring costs that are typically associated with offline recruitment channels, yet it is a known fact that many such online portals charge a fee for allowing recruiters to use their advanced features while offering them the sites’ basic features free of cost. <br>
                                    Aileensoul is a one of kind unified platform that blends the features and capabilities of multiple sites and portals under one roof. It aims to bridge the long-standing communication gap between hiring personnel and job-seekers and serve as an effective recruitment platform for start-ups and small firms who face challenge in hiring skilled people because of their lack of visibility to reliable talent sourcing avenues and their limited budget which becomes a hindrance in opting for paid recruitment services with established job boards and portals.  Aileensoul’s platform is completely free for all, including recruiters who can register themselves with the website to post their vacancies and leverage its user-friendly interface to connect with shortlisted candidates and also invite the latter for a round of interview if deemed necessary. 
                                </p>
                            </div>
                        </div>
                        <div class="row dis-box">
                            <h2>How to Register With Aileensoul’s Recruiter Profile?</h2>
                            <div class="col-md-6 col-sm-12 pb20 pull-right">
                                <img style="width:100%;" src="<?php echo base_url('assets/img/rec2.jpg?ver=' . time()); ?>" alt="recruiter-image">
                            </div>
                            <div class="col-md-6 col-sm-12 pb20 pull-left">
                                <p>As a platform user, your first step will be to register with Aileensoul to gain access to its multiple service profiles. Post successful registration, you will be able to individually list yourself with each of the service profiles to utilise their offerings to your benefit. <br>
                                    If you are a hiring executive or a recruiter, then you need to create a corresponding account for yourself by clicking on the ‘Register’ button below the ‘Recruiter Profile’. Doing so will direct you to a form where you need to populate your personal as well as your company’s details (name, email address, company profile etc.). Next, click on ‘Register’ to land on the page where you will be asked to share the job requirements that will be visible to the candidates after the job post is published on the website. Finally, click on ‘Post’ to complete the listing process. Next time you log in to the platform, you will see a ‘Take me in’ option below the ‘Recruiter Profile’. Click on that to access the next page that displays an active ‘Post a Job’ button. Clicking on this button will allow you to create and publish your job post on Aileensoul’s platform. </p>
                            </div>
                        </div>
                        <div class="row dis-box">
                            <h2>Additional Features of Aileensoul’s Recruiter Profile:</h2>
                            <div class="col-md-6 col-sm-12 pb20">
                                <img style="width:100%;" src="<?php echo base_url('assets/img/rec3.jpg?ver=' . time()); ?>" alt="recruiter-image">
                            </div>
                            <div class="col-md-6 col-sm-12 pb20">
                                <p>Other than the standard features of online job posting that include the provision to modify, delete, refresh and repost  jobs and receive system notifications regarding applications from job-seekers, Aileensoul helps recruiters shorten their screening time by suggesting them with a list of ‘best fits’ filtered by its built-in algorithm on the basis of specific words and phrases mentioned in the job description, skills, industry, experience, educational qualifications and other details provided by the recruiters in their job postings. This eliminates the need for the hiring executives to sift through loads of irrelevant applications in order to find the exact match that they are looking for, thereby saving precious time and effort on their part! <br>
                                    Moreover, instead of waiting for a response to their job postings, recruiters can exploit the platform’s exhaustive resume database to proactively identify and shortlist eligible candidates, view their profiles and use its ‘easy to use’ interface to connect with and evaluate prospects for further rounds of discussions and interviews. All in all, Aileensoul’s ‘Recruiter Profile’ is a one-stop solution for all hiring-related challenges - be it aggressive hiring timelines, cost pressures or the want of qualified and skilled resources across niche industries and sectors. 
                                </p>
                            </div>
                        </div>
						<div class="fw">
                        <?php
                        if (!$this->session->userdata('aileenuser') || $is_profile['is_recruiter'] != '1') {
                            ?>
                            <div class="text-center pb20 introduce_button"><a href="<?php echo base_url('recruiter/registration') ?>" title="Create Recruiter Profile" target="_blank" class="btn-new1">Create Recruiter Profile</a></div>
                        <?php } else {
                            ?>

                            <div class="text-center pb20 introduce_button"><a href="<?php echo base_url('recruiter') ?>" title="Take me in" target="_blank" class="btn-new1">Take me in</a></div>

                        <?php } ?>
						</div>
                    </div>
                </div>
            </section>
        </div>

        <?php echo $login_footer ?>
    </body>
</html>
