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
                <img src="<?php echo base_url('assets/img/fp.jpg?ver=' . time()); ?>" alt="banner-image">

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
                            if (!$this->session->userdata('aileenuser') || $is_profile['is_freelance_hire'] != '1') {
                                ?>
                                <div class="text-center mob-pb20 introduce_button col-md-6 col-sm-6"><a href="<?php echo base_url('freelance-hire/registration') ?>" class="btn-new1" title="Create Freelance Hire Profile" target="_blank">Create Freelance Hire Profile</a></div>
                                <?php } else {
                                ?>

                                <div class="text-center mob-pb20 introduce_button col-md-6 col-sm-6"><a href="<?php echo base_url('freelance-hire') ?>" class="btn-new1" title="Freelance hire Profile Take me in" target="_blank">Freelance Hire Profile Take me in</a></div>

                            <?php
                            }
                            if (!$this->session->userdata('aileenuser') || $is_profile['is_freelance_apply'] != '1') {
                                ?>
                                <div class="text-center introduce_button col-md-6 col-sm-6"><a href="<?php echo base_url('freelance-work/registration') ?>" class="btn-new1" title="Create Freelance Apply Profile" target="_blank">Create Freelance Apply Profile</a></div>
                                <?php } else {
                                ?>

                                <div class="text-center introduce_button col-md-6 col-sm-6"><a href="<?php echo base_url('freelance-work') ?>" class="btn-new1" title="Freelance Apply Profile Take me in" target="_blank">Freelance Apply Profile Take me in</a></div>
                            <?php } ?>
				</div>
            </div>

            <section class="middle-main bg_white">
                <div class="container">
                    <div class="profiles-details">
                        <div class="top-detail text-center">

                            <p>Aileensoul is a ‘free for all’ career-oriented platform that provides individuals and businesses with multifarious opportunities to collaborate with their intended audience and help them realise their personal and professional goals and objectives in a hitherto unknown way. Built with cutting-edge technology, a well-organised and easily navigable interface and user-friendly features and functionalities, the innovative platform incorporates several service profiles that fulfil the distinct needs of a diverse audience that includes job-seekers, recruiters, businesses, freelancers and artistic people. Aileensoul’s unique ‘Freelance Profile’ acts as a bridge between qualified and skilled freelancers who are willing to offer their services as independent consultants and companies who are looking to hire their services for various short-term and long-term projects across a plethora of industries and functional domains. </p>
                        </div>

                        <div class="row dis-box">
                            <h2>Aileensoul - A Dream Come True for Freelancers and Employers Alike</h2>
                            <div class="col-md-6 col-sm-12 pb20">
                                <img style="width:100%;" src="<?php echo base_url('assets/img/fre1.jpg'); ?>" alt="freelance-image">
                            </div>
                            <div class="col-md-6 col-sm-12 pb20">
                                <p>A rising trend in present times, freelancing has amassed immense popularity in India in the last few years, especially in the aftermath of renewed focus and impetus from the government to launch and implement policies that can help accelerate the growth of the country’s flourishing start-up ecosystem. Additionally, increasing globalisation of the world economy, proliferation of technology and easy access to the Internet have collectively catalysed the blurring of geographical boundaries and prepared the ground for free-flowing communication between people and companies of different nations around the world. This has encouraged the burgeoning of the freelancer community in India and across the globe. <br>
                                    Designed to help talented individuals find their dream opportunity and grow their career, Aileensoul’s transparent and collaborative platform serves as a boon for freshers and veteran professionals who have opted to look beyond the rigid rules and restrictions that are part and parcel of any full-time employment and have chosen to pursue their interests and career aspirations in an independent manner and with the support of freelance work. </p>
                            </div>
                        </div>
                        <div class="row dis-box">
                            <h2>How to Register With Aileensoul’s Freelance Profile?</h2>
                            <div class="col-md-6 col-sm-12 pb20 pull-right">
                                <img style="width:100%;" src="<?php echo base_url('assets/img/fre2.jpg?ver=' . time()); ?>" alt="freelance-image">
                            </div>
                            <div class="col-md-6 col-sm-12 pb20 pull-left">
                                <p>Depending on whether you are an individual who is exploring freelance work or an employer who is looking to hire a freelancer for his or her project, you will first have to register yourself with Aileensoul’s platform and then create your freelance profile by choosing the ‘Apply’ or ‘Hire’ option as appropriate for you.<br> 
                                    As a freelancer, you will be asked to provide basic details about yourself, your educational qualification, professional skills & experience, hourly/fixed rate and payment currency, availability (full-time or part-time) and a concise and attractive portfolio of your skills, interests and accomplishments. Once you have filled all the relevant fields, click on ‘Submit’. Your freelancer profile is now active on Aileensoul’s platform and you are ready to peruse the recommended projects that have been listed by the portal in line with your expertise and skills. You can choose to shortlist and save projects for consideration at a later stage or apply to them then and there in case they interest you and meet your remuneration expectations. <br>
                                    If you are an employer, then the profile registration process is even simpler for you as you just need to populate a one page form that will require you to provide elementary details, such as your name, email address, country, state, city and professional information. It’s that simple! Click on ‘Register’ to complete the enrolment process and follow this up by clicking on ‘Post Project’ to start creating and publishing orders on Aileensoul’s website.
                                </p>
                            </div>
                        </div>
                        <div class="row dis-box">
                            <h2>Additional Features of Aileensoul’s Freelance Profile:</h2>
                            <div class="col-md-6 col-sm-12 pb20">
                                <img style="width:100%;" src="<?php echo base_url('assets/img/fre3.jpg?ver=' . time()); ?>" alt="freelance-image">
                            </div>
                            <div class="col-md-6 col-sm-12 pb20">
                                <p>Unlike many freelance websites in India that do not allow individuals to communicate with their prospective employers unless the client chooses to initiate a chat for discussion, Aileensoul encourages free-flowing communication between the employer and the prospect by enabling either party to begin a chat as per their need and convenience. <br>
                                    Employers too can benefit from the platform’s recommended list of verified and reliable freelancers to expedite their screening process and select candidates with matching skill sets and experience at short notice. Not just that, employers also get to chat with the freelancers who have applied to their postings and those whom the employer has chosen to communicate with proactively to undertake a thorough evaluation of their skills and accomplishments before they are hired for critical projects and initiatives. 

                                </p>
                            </div>
                        </div>
                        <div class="fw">
                            <?php
                            if (!$this->session->userdata('aileenuser') || $is_profile['is_freelance_hire'] != '1') {
                                ?>
                                <div class="text-center pb20 introduce_button col-md-6 col-sm-6"><a href="<?php echo base_url('freelance-hire/registration') ?>" class="btn-new1" title="Create Freelance Hire Profile" target="_blank">Create Freelance Hire Profile</a></div>
                                <?php } else {
                                ?>

                                <div class="text-center pb20 introduce_button col-md-6 col-sm-6"><a href="<?php echo base_url('freelance-hire') ?>" class="btn-new1" title="Freelance hire Profile Take me in" target="_blank">Freelance Hire Profile Take me in</a></div>

                            <?php
                            }
                            if (!$this->session->userdata('aileenuser') || $is_profile['is_freelance_apply'] != '1') {
                                ?>
                                <div class="text-center pb20 introduce_button col-md-6 col-sm-6"><a href="<?php echo base_url('freelance-work/registration') ?>" class="btn-new1" title="Create Freelance Apply Profile" target="_blank">Create Freelance Apply Profile</a></div>
                                <?php } else {
                                ?>

                                <div class="text-center pb20 introduce_button col-md-6 col-sm-6"><a href="<?php echo base_url('freelance-work') ?>" class="btn-new1" title="Freelance Apply Profile Take me in" target="_blank">Freelance Apply Profile Take me in</a></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php echo $login_footer ?>
    </body>
</html>
