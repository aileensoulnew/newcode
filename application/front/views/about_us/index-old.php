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
        <title>About Us - Aileensoul</title>
        <meta name="description" content="Aileensoul.com have something to give this world, Know about us." />
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
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
        <?php if (IS_OUTSIDE_CSS_MINIFY == '0') { ?>
            <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
            <link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()) ?>">
        <?php } else { ?>
            <link rel="stylesheet" href="<?php echo base_url('assets/css_min/common-style.css?ver=' . time()) ?>">
            <link rel="stylesheet" href="<?php echo base_url('assets/css_min/style-main.css?ver=' . time()) ?>">
        <?php } ?>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    </head>

    <body class="about-us" >
        <div class="main-inner">
            <div class=terms-con-cus><header class="bg-none terms-con"><div class=overlaay><div class=container><div class=row><div class="col-md-4 col-sm-3"><a href="<?php echo base_url(); ?>"><img alt=logo src="<?php echo base_url('assets/img/logo-name.png?ver=' . time()) ?>"></a></div><div class="col-md-8 col-sm-9"><div class="btn-right pull-right"><?php if (!$this->session->userdata('aileenuser')) { ?><a href="<?php echo base_url('login'); ?>"class=btn2>Login</a> <a href="<?php echo base_url('registration'); ?>"class=btn3>Create an account</a><?php } ?></div></div></div></div></div></header><div class=container><div class=cus-about><section><div class=main-comtai><h2 class=about-h2>About Us</h2><p class=about-para>We provide platform & opportunities to every person in the world to make their career.</div></section></div></div></div><section class=middle-main><div class=container><div class=pt10><div class=titlea><h1 class=pb20>About Aileensoul</h1></div><div class=about-content><p>Founded in 2017, Aileensoul is a new age portal that amalgamates a variety of career-oriented services into a single unified platform with an aim to address the needs of jobseekers, recruiters, business professionals, freelancers and artists - all under one roof! Introduced to fulfil one of the most fundamental and important aspects of an individual’s life - one’s desire to land a rewarding and successful career for himself or herself - Aileensoul’s futuristic platform serves to launch and advance the careers of first-time jobseekers, experienced business professionals/consultants and upcoming/veteran artists.<p>Whether you are looking to grow your business network or searching for a reliable job portal to explore vacancies in leading companies and reputed firms, Aileensoul caters to all your needs. We celebrate talent in every form and continue to innovate features and offerings that help individuals like you showcase their unique capabilities, talent and art to the global community that exists on our platform.<p>All our niche profiles have been thoughtfully designed to touch upon every possible aspect that can influence your career progression - be it full-time/freelance job search, networking, real-time collaboration with recruiters or a platform to showcase your skills and arouse the interest of potential clients or companies.</div></div></div><div class=container><div class=pt10><div class=titlea><h1 class=pb20>Our Mission</h1></div><div class=about-content><p>Social and economic upliftment of people is a key contributor to the all-round progress of a nation. Aileensoul endeavours to impact this very aspect of socio-economic development through creation of employment opportunities for the country’s youth and helping eradicate unemployment and poverty, not just from India but also from the world.<p>We believe that every individual has the right to a better tomorrow and a prospering career is one its founding stones. At Aileensoul, we strive to remove the man-made barriers of bureaucracy by enabling individuals and professionals to connect and collaborate in a transparent and independent manner.</div></div></div><div class=container><div class=pt10><div class=titlea><h1 class=pb20>Our Vision</h1></div><div class="about-content text-center">We aspire to become a one-stop destination for career enthusiasts from various walks of life and with diverse experience and educational backgrounds.</div></div></div><div class=container><div class=pt10><div class=titlea><h1 class=pb20>Our Team</h1></div><div class="about-content text-center">Coming together is a beginning, staying together is progress, and working together is success.<br>-Henry Ford</div><div class=all-tem><ul><li class=img-custom><div class=team-1><img alt=nisharaj src="<?php echo base_url('assets/img/NishaRaj.jpg?ver=' . time()) ?>" oncontextmenu=return!1></div><div class=text-custom><h4>Nisha Raj</h4><p>Content Head</div><li class=img-custom><div class=team-1 oncontextmenu=return!1><img alt=yatinbelani src="<?php echo base_url('assets/img/yatinbelani.jpg?ver=' . time()) ?>"></div><div class=text-custom><h4>Yatin Belani</h4><p>Project Manager</div><li class=img-custom><div class=team-1 oncontextmenu=return!1><img alt=Shashvat src="<?php echo base_url('assets/img/Shashvat.jpg') ?>"></div><div class=text-custom><h4>Shashwat Barbhaya</h4><p>Business Manager</div><li class=img-custom><div class=team-1 oncontextmenu=return!1><img alt=himanshuSadadiya src="<?php echo base_url('assets/img/himanshuSadadiya.jpg?ver=' . time()) ?>"></div><div class=text-custom><h4>Himanshu Sadadiya</h4><p>AWS Architect/Devops Expert</div><li class=img-custom><div class=team-1 oncontextmenu=return!1><img alt=AnkitMakadiya src="<?php echo base_url('assets/img/AnkitMakadiya.jpg') ?>"></div><div class=text-custom><h4>Ankit Makadiya</h4><p>Technical Head</div><li class=img-custom><div class=team-1 oncontextmenu=return!1><img alt=KhyatiRaval src="<?php echo base_url('assets/img/KhyatiRaval.jpg?ver=' . time()) ?>"></div><div class=text-custom><h4>Khyati Raval</h4><p>Sr. Web Developer</div><li class=img-custom><div class=team-1 oncontextmenu=return!1><img alt=nikunj src="<?php echo base_url('assets/img/nikunj.jpg?ver=' . time()) ?>"></div><div class=text-custom><h4>Nikunj Bhalodiya</h4><p>Software Tester</div><li class=img-custom><div class=team-1 oncontextmenu=return!1><img alt=Harshad src="<?php echo base_url('assets/img/Harshad.jpg?ver=' . time()) ?>"></div><div class=text-custom><h4>Harshad Patoliya</h4><p>Sr. Web Designer</div><li class=img-custom><div class=team-1 oncontextmenu=return!1><img alt=PRASHANT src="<?php echo base_url('assets/img/PRASHANT.jpg') ?>"></div><div class=text-custom><h4>Prashant Dadhaniya</h4><p>Sr. SEO Executive</div><li class=img-custom><div class=team-1 oncontextmenu=return!1><img alt=JayPatel src=<?php echo base_url('assets/img/JayPatel.jpg?ver=' . time()) ?>></div><div class=text-custom><h4>Jay Patel</h4><p>Jr. SEO Executive</div><li class=img-custom><div class=team-1 oncontextmenu=return!1><img alt=PallaviPanalia src="<?php echo base_url('assets/img/PallaviPanalia.jpg?ver=' . time()) ?>"></div><div class=text-custom><h4>Pallavi Panaliya</h4><p>Jr. Web Developer</div></ul><ul><li class=img-custom><div class=team-1 oncontextmenu=return!1><img alt=Dhaval12 src="<?php echo base_url('assets/img/Dhaval12.jpg?ver=' . time()) ?>"></div><div class=text-custom><h4>Dhaval Shah</h4><p>Jr. Web Designer</div><li class=img-custom><div class=team-1 oncontextmenu=return!1><img alt=FalguniTank src="<?php echo base_url('assets/img/FalguniTank.jpg?ver=' . time()) ?>"></div><div class=text-custom><h4>Falguni Tank</h4><p>Jr. Web Developer</div></ul><ul class=Main-im><li class=img-custom><div class=team-1 oncontextmenu=return!1><img alt=ShahDhaval src="<?php echo base_url('assets/img/ShahDhaval.jpg?ver=' . time()) ?>"></div><div class=text-custom><h4>Dhaval Shah</h4><p>CEO</div></ul></div></div></div></section>
                                        <?php echo $login_footer ?>
        </div>

        <?php if (IS_OUTSIDE_JS_MINIFY == '0') { ?>
            <script src="<?php echo base_url('assets/js/webpage/aboutus.js?ver=' . time()); ?>"></script>
        <?php } else { ?>
            <script src="<?php echo base_url('assets/js_min/webpage/aboutus.js?ver=' . time()); ?>"></script>
        <?php } ?>
    </body>
</html>