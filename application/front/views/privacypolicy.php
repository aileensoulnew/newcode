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

header('Cache-Control: public, max-age=30');

?>
<html lang="en">
    <head>
        <title><?php echo $title; ?></title>
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver='.time()); ?>">
        <meta charset="utf-8">
        <?php
        if($_SERVER['HTTP_HOST'] != "localhost"){
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
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <?php
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <link rel="canonical" href="<?php echo $actual_link ?>" />
        <?php
        if (IS_OUTSIDE_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver='.time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver='.time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/blog.css?ver='.time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css?ver='.time()); ?>">
            <?php
        } else {
            ?>
              <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/common-style.css?ver='.time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css_min/style-main.css?ver='.time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/blog.css?ver='.time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/font-awesome.min.css?ver='.time()); ?>">
        <?php } ?>
        
        
    </head>
    <body class="custom-tp privacy-cust outer-page">
        <div class="main-inner">
            <div class="terms-con-cus">
            <header class="terms-con bg-none">
                <div class="overlaay">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 col-sm-3">
                                <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name-footer.png?ver='.time()) ?>" alt="logo"></a>
                            </div>
                            <div class="col-md-8 col-sm-9">
                                <div class="btn-right pull-right">
                                <?php if(!$this->session->userdata('aileenuser')) {?>
                                    <a href="<?php echo base_url('login'); ?>" class="btn2">Login</a>
                                    <a href="<?php echo base_url('registration'); ?>" class="btn3">Create an account</a>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div class="container">
                <div class="cus-about" >
            <section class="">
                <div class="main-comtai">
                    <!-- <h1>Terms and Conditions</h1> -->
                    <h2 class="about-h2">Privacy Policy</h2>
                  
                </div>
            </section>
            </div>
            </div>
        </div>
            <section class="middle-main bg_white">
                <div class="container">
                    <div class="term_desc test_py">
                        <p>This Privacy Policy applies to <a href="https://www.aileensoul.com"><b>Aileensoul.com</b></a></p>
                        <p>Aileensoul.com recognizes the importance of maintaining your privacy. We value your privacy and appreciate your trust in us. This Policy describes how we treat user information we collect on https://www.aileensoul.com and other offline sources. This Privacy Policy applies to current and former visitors to our website and to our online users. By visiting and/or using our website, you agree to this Privacy Policy.
                            Aileensoul.com is a property of Aileensoul Private Limited, an Indian Company registered under the Companies Act, 2013 having its registered office at E- 912, titanium city centre, near sachin tower, 100 ft. Anandnagar road, Satellite, Ahmedabad, Gujarat.
                        </p>
                        <div class="first_part_py">
                            <h3>1. Information we collect</h3>
                            <ol>
                                <li><h4>Contact information: </h4><p>We might collect your name, email, mobile number, phone number, street, city, state, pin code, country and IP address.</p></li>
                                <li><h4>Information you post: </h4><p>We collect information you post in a public space on our website or on a third-party social media site belonging to Aileensoul.com</p></li>
                                <li><h4>Demographic information: </h4><p>We may collect demographic information about you, events you like, events you intend to participate in, tickets you buy, or any other information provided by you during the use of our website. We might collect this as a part of a survey also.</p></li>
                                <li><h4>Other information:</h4><p>If you use our website, we may collect information about your IP address and the browser you're using. We might look at what site you came from, duration of time spent on our website, pages accessed or what site you visit when you leave us. We might also collect the type of mobile device you are using, or the version of the operating system your computer or device is running. </p></li>

                            </ol>
                        </div>

                        <div class="second_part_py">
                            <h3>2. Information Collection</h3>
                            <ol>
                                <li><h4>We collect information directly from you</h4><p>We collect information directly from you when you register for an event or buy tickets. We also collect information if you post a comment on our websites or ask us a question through phone or email.</p></li>
                                <li><h4>We collect information from you passively</h4><p>We use tracking tools like Google Analytics, Google Webmaster, browser cookies and web beacons for collecting information about your usage of our website. </p></li>
                                <li><h4>We get information about you from third parties</h4><p>For example, if you use an integrated social media feature on our websites. The third-party social media site will give us certain information about you. This could include your name and email address.</p></li>


                            </ol>
                        </div>
                        <div class="third_part_py">
                            <h3>3. Use of your personal information</h3>
                            <ol>
                                <li><h4>We use information to contact you: </h4> <p>We might use the information you provided to contact you confirmation   of or for other promotional purposes.</p></li>
                                <li><h4>We use information to respond to your requests or questions:</h4> <p>We might use your information to deliver you required services. </p></li>
                                <li><h4>We use information to improve our products and services:</h4> <p>We might use your information to customize your experience with us. This could include displaying content based upon your preferences.</p></li>
                                <li><h4>We use information to look at site trends and customer interests:</h4> <p>We may use your information to make our website and products better. We may combine information we get from you with information about you we get from third parties.</p></li>
                                <li><h4>We use information for security purposes:</h4> <p>We may use information to protect our company, our customers, or our websites.</p></li>
                                <li><h4>We use information for marketing purposes:</h4> <p>We might send you information about new features or products. These might be our own offers or products, or third-party offers or products we think you might find interesting.</p></li>
                                <li><h4>We use information as otherwise permitted by law.</h4> <p></p></li>  
                            </ol>
                        </div>
						<div class="fourth_part_py">
                            <h3>4. Cookie Policy</h3>
							<ul><li>
                            <p>Our website does not use cookies but third party vendors, including Google, use cookies to serve ads based on a user's prior visits to our website or other websites.
							</p></li><li>
							<p>Google's use of advertising cookies enables it and its partners to serve ads to users based on their visit to our sites and/or other sites on the Internet.</p></li><li>
							<p>Users may opt out of personalized advertising by visiting Ads Settings. (Alternatively, you can direct users to opt out of a third-party vendor's use of cookies for personalized advertising by visiting <a target="_blank" href="http://www.aboutads.info/">www.aboutads.info <i class="fa fa-external-link" aria-hidden="true"></i></a>.)</p></li></ul>
                        </div>
                        <div class="fourth_part_py">
                            <h3>5. Sharing of information with third-parties</h3>
                            <ol>
                                <li><h4>We will share information with our business partners</h4><p>This includes a third party who provide or sponsor an event, or who operates a venue where we hold events. Our partners use the information we give them as described in their privacy policies. </p></li>
                                <li><h4>We may share information if we think we have to in order to comply with the law or to
                                        protect ourselves</h4><p>We will share information to respond to a court order or subpoena. We may also share it if a government agency or investigatory body requests. Or, we might also share information when we are investigating potential fraud. </p></li>
                                <li><h4>We may share information with any successor to all or part of our business</h4><p>For example, if part of our business is sold we may give our customer list as part of that transaction.</p></li>
                                <li><h4>We may share your information for reasons not described in this policy</h4><p>We will let you know in such cases before we do it.</p></li>
                            </ol>
                        </div>

                        <div class="fifth_part_py">
                            <h3>6. Email Opt-Out</h3>
                            <h4>You can opt out of receiving our marketing emails</h4><p>To stop receiving our promotional emails, please email <a href="mailto:inquiry@aileensoul.com"><b>inquiry@aileensoul.com</b></a> It may take about ten days to process your request. Even if you opt out of getting marketing messages, we will still be sending you transactional messages through email and SMS about your purchases. </p>

                        </div>
                        <div class="sixthh_part_py">
                            <h3>7. Third party sites </h3>
                            <p>If you click on one of the links to third party websites, you may be taken to websites we do not control. This policy does not apply to the privacy practices of those websites. Read the privacy policy of other websites carefully. We are not responsible for these third party sites.</p>
                        </div>
                        <div class="ex_py">
                            <h3>Help Desk</h3>
                            <p>
                                In accordance with Information Technology Act 2000 and rules made there under, following is the details of our help desk.</p>
                            <div class="fw">
                                <span class="em-py3">   Email : </span>
                                <span class="em-py2">
                                    <a href="mailto:aileensoulinquiry@gmail.com"> aileensoulinquiry@gmail.com</a>
                                    <br><a href="mailto:info@aileensoul.com"> info@aileensoul.com</a>
                                    <br><a href="mailto:inquiry@aileensoul.com"> inquiry@aileensoul.com</a>
                                    <br><a href="mailto:hr@aileensoul.com"> hr@aileensoul.com</a></span>
                                <br>

                            </div>
							<p>
                            If you have any questions about this Policy or other privacy concerns, you can also email us at help desk of site

                            </p>
							<h3>
                                Consent
                            </h3>
							<p>If you use our Services, you consent to the collection, use and sharing of your personal data under this Privacy Policy (which includes usage of Cookies and other documents referenced in this Privacy Policy) and agree to our Terms & Conditions. We provide you choices that allow you to opt-out or control how we use and share your data.</p>
                            <h3>
                                Updates to this policy
                            </h3>
                            <p>
                                This Privacy Policy was last updated on 20.12.2017. From time to time we may change our privacy practices. We will notify you of any material changes to this policy as required by law. We will also post an updated copy on our website. Please check our site periodically for updates.
                            </p>
                            <h3>
                                Jurisdiction
                            </h3>
                            <p>If you choose to visit the website, your visit and any dispute over privacy is subject to this Policy and the website's terms of use. In addition to the foregoing, any disputes arising under this Policy shall be governed by the laws of Government of India. </p>
                        </div>

                    </div>
                </div>
            </section>
        </div>

        <?php
            echo $login_footer
        ?>
    </body>
</html>
