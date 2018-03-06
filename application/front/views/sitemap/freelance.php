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
        <style type="text/css">
            .full_page ul li{
                width: 100% !important;
            }
        </style>
         <?php
if(IS_OUTSIDE_JS_MINIFY == '0'){
?>
 <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
 <link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()) ?>">
<?php } else{ ?>
 <link rel="stylesheet" href="<?php echo base_url('assets/css_min/common-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css_min/style-main.css?ver=' . time()) ?>">
<?php } ?>
       
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
    </head>
    <body class="site-map outer-page" >
        <div class="main-inner ">
            <?php echo $sitemap_header ?>
            <section class="middle-main">
                <div class="container">
                    <!-- html code for inner page  -->
                    <div class="all-site-link">
                        <h2 style="margin-left: -2px;">Freelance Profile</h2>
                        <h3>Freelance Hire</h3>
                        <div class="linkbox full_page">
                            <div class="smap-catbox">
                                <ul class="catbox-right artist-sitemap">
                                    <li style="list-style-type: circle;font-size: 20px;">Login/Register</li>
                                    <li style="padding-bottom: 30px;"><a href="<?php echo base_url('freelance-hire/registration') ?>">Register/Takeme in</a></li>
                                    <!--<li><a href="<?php echo base_url() ?>freelance-hire/add-projects" target="_blank">Post a Project</a></li>-->
                                    <li style="margin-left: -20px;padding-left: 38px;font-size: 20px;cursor: text;"><a style="text-transform: none;color: #333;" href="<?php echo base_url('freelance-hire/add-projects'); ?>"> Post a Project </a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="all-site-link">
                        <h4>Freelancers</h4>
                        <div class="linkbox">
                            <?php
                            
                            foreach ($getFreelancers as $key => $value) {
                                ?>
                                <div class="smap-catbox">
                                    <div class="catbox-left">
                                        <h5><?php echo $key ?></h5>
                                    </div>
                                    <ul class="catbox-right">
                                        <?php foreach ($value as $freelancers) { ?>
                                        <li><a href="<?php echo base_url('freelance-work/freelancer-details/' . $freelancers['freelancer_apply_slug']) ?>" target="_blank"><?php echo $freelancers['freelancer_post_fullname'] . ' ' .$freelancers['freelancer_post_username'] ; ?></a></li>    
                                        <?php } ?>
                                    </ul>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>    
                    <div class="all-site-link cust-link">
                        <h3>Freelance Apply</h3>
                        <div class="linkbox full_page">
                            <div class="smap-catbox">
                                <ul class="catbox-right artist-sitemap">
                                    <li style="list-style-type: circle;font-size: 20px;">Login/Register</li>
                                    <li style="padding-bottom: 30px;"><a href="<?php echo base_url('freelance-work/registration') ?>">Register/Takeme in</a></li>
                                </ul>
                            </div>
                        </div>
                        <ul>
                            <li style="margin-bottom: 35px;list-style-type: none;margin-left: -15px;"><a href="https://www.aileensoul.com/projects">All Freelance Projects</a></li>
                            <li style="list-style-type: none;margin-left: -13px;margin-bottom: 30px;"><h4>Projects by Field</h4></li>

                        </ul>
                        <div class="linkbox">
                            <?php foreach ($getFreepostDataByCategory as $key => $value) { ?>
                                <div class="smap-catbox">

                                    <div class="catbox-left">
                                        <h5><?php echo $key; ?></h5>
                                    </div>
                                    <ul class="catbox-right">
                                        <?php
                                        foreach ($value as $projects) {

                                            if ($projects['post_name'] != '') {
                                                $text = strtolower($this->common->clean($projects['post_name']));
                                            } else {
                                                $text = '';
                                            }
                                            if ($projects['city_name'] != '') {
                                                $cityname = '-vacancy-in-' . strtolower($this->common->clean($projects['city_name']));
                                            } else {
                                                $cityname = '';
                                            }
                                            ?>
                                            <li><a href="<?php echo base_url('freelance-hire/project/' . $text . $cityname . '-' . $projects['user_id'] . '-' . $projects['post_id']) ?>"><?php echo $projects['post_name'] . '(' . $projects['fullname'] . ' ' . $projects['username'] . ')'; ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                    <div class="all-site-link ">
                        <h4>Employers</h4>
                        <div class="linkbox">
                            <div class="smap-catbox">
                                <ul class="catbox-right artist-sitemap">
                                    <?php 
                                    foreach ($getEmployees as $employees) { ?>
                                    <li><a href="<?php echo base_url('freelance-hire/employer-details/' . $employees['freelancer_hire_slug']) ?>" target="_blank"><?php echo $employees['username'] . ' ' . $employees['fullname']; ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>

            </section>
            <?php
            echo $login_footer
            ?>
        </div>
        
        <?php
if(IS_OUTSIDE_JS_MINIFY == '0'){
?>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()); ?>" ></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/aboutus.js?ver='.time()); ?>"></script>
<?php } else{ ?>
  <script src="<?php echo base_url('assets/js_min/jquery-3.2.1.min.js?ver=' . time()); ?>" ></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/aboutus.js?ver='.time()); ?>"></script>
<?php } ?>
       
    </body>
</html>