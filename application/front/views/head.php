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
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
header('Expires: ' . $date);
//header("Cache-Control: no-cache, must-revalidate"); 
//header('Cache-Control: public, max-age=30');
?>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-control" content="no-cache">
<meta http-equiv="Expires" content="0">
<meta charset="utf-8" />
<?php
 if ($_SERVER['HTTP_HOST'] == "www.aileensoul.com") {
    ?>

    <meta name="msvalidate.01" content="41CAD663DA32C530223EE3B5338EC79E" />
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
    <?php
}
?>
<meta name="google-site-verification" content="BKzvAcFYwru8LXadU4sFBBoqd0Z_zEVPOtF0dSxVyQ4" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />

<?php if ($this->uri->segment(1) == 'business-profile' && $this->uri->segment(2) == 'details') { ?>
    <meta name="description" content="<?php echo ucfirst($business_common_data[0]['company_name']) . ' in ';
    if ($city_name) {
        echo $city_name . ', ';
    } echo $country_name . ' View full business details like address, contact number, photos and more at Aileensoul.com.'; ?>" />

<?php } else if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'jobpost') { ?>
    <meta name="description" content="Job Description for the post of <?php echo $exp_title; ?> in <?php echo ucfirst($recdata['re_comp_name']); ?> in <?php if ($city_name) {
        echo $city_name . ', ';
    }echo $state_name; ?> for <?php echo $exp_descp; ?> of experience. Apply Now!" />

<?php } else if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'profile') { ?>
    <meta name="description" content="<?php echo 'View full profile of Recruiter ' . ucfirst($recdescdata[0]['rec_firstname']) . ' ' . ucfirst($recdescdata[0]['rec_lastname']) ?> in <?php echo ucfirst($recdescdata[0]['re_comp_name']); ?> at <?php if ($citydesc_name) {
        echo $citydesc_name . ', ';
    }echo $statedesc_name; ?>." />

<?php } else if ($this->uri->segment(1) == 'job' && $this->uri->segment(2) == 'resume') { ?>
    <meta name="description" content="View full resume detail like education, work area, experience of <?php echo ucfirst($fdescname) . ' ' . ucfirst($ldescname); ?> at Aileenoul.com" />

<?php
} else if ($this->uri->segment(1) == 'freelance-hire' && $this->uri->segment(2) == 'project') {

    if ($this->data['projectdata'][0]['post_rate']) {
        $for = "for";
    } else {
        $for = '';
    }
    ?>
    <meta name="description" content="<?php echo $fieldname . " Project " . $for . " " . $currencyname . " " . $rate . " " . $this->data['projectdata'][0]['post_description']; ?>" />

<?php } else if ($this->uri->segment(1) == 'freelance-hire' && $this->uri->segment(2) == 'employer-details') { ?>
    <meta name="description" content="<?php echo 'Employer ' . ucfirst($employerdata['fullname']) . ' ' . ucfirst($employerdata['username']) . " seeking for highly skilled Freelancers. View full detail at Aileensoul.com"; ?>" />

<?php } else if ($this->uri->segment(1) == 'freelance-work' && $this->uri->segment(2) == 'freelancer-details') { ?>
    <meta name="description" content="<?php echo 'Hire ' . ucfirst($freelancerdata[0]['freelancer_post_fullname']) . ' ' . ucfirst($freelancerdata[0]['freelancer_post_username']) . " freelancer, View his/her complete " . $fieldname1 . " freelancing portfolio."; ?>" />

<?php } else if ($this->uri->segment(1) == 'artist' && $this->uri->segment(2) == 'details') { ?>

    <meta name="description" content="<?php echo ucfirst($meta_des[0]['art_name']) . ' ' . ucfirst($meta_des[0]['art_lastname']) . ' is a ' . $keyskill_meta . ' artist situated at ' . ucfirst($location_city) . ', ' . ucfirst($location_country) . '. ' . 'View full artistic detail & art portfolio at Aileensoul.com'; ?>" />

<?php } else {
    ?>
    <meta name="description" content=" " />
<?php } ?>
<meta name="keywords" content=" " />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<link rel="canonical" href="<?php echo $actual_link ?>" />
<link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
<?php
if (IS_OUTSIDE_CSS_MINIFY == '0') {
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/media.css?ver=' . time()); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/animate.css?ver=' . time()) ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/header.css?ver=' . time()); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css?ver=' . time()); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css?ver=' . time()); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/js/scrollbar/style.css?ver=' . time()) ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/js/scrollbar/jquery.mCustomScrollbar.css?ver=' . time()) ?>">
    <?php } else {
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/common-style.css?ver=' . time()); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/media.css?ver=' . time()); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/animate.css?ver=' . time()) ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/header.css?ver=' . time()); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style.css?ver=' . time()); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/font-awesome.min.css?ver=' . time()); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/js_min/scrollbar/style.css?ver=' . time()) ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/js_min/scrollbar/jquery.mCustomScrollbar.css?ver=' . time()) ?>">
<?php }
?>
<?php
if (IS_OUTSIDE_JS_MINIFY == '0') {
    ?>
    <?php
    if ($this->uri->segment(1) == 'profiles') {
        ?>
        <script src="<?php echo base_url('assets/js/jquery-2.0.3.min.js?ver=' . time()); ?>"></script> 
        <?php
    } else {
        ?>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()); ?>" ></script>
    <?php }
    ?>
    <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()); ?>"></script>  
    <?php } else {
    ?>
    <?php
    if ($this->uri->segment(1) == 'profiles') {
        ?>
        <script src="<?php echo base_url('assets/js_min/jquery-2.0.3.min.js?ver=' . time()); ?>"></script> 
        <?php
    } else {
        ?>
        <script src="<?php echo base_url('assets/js_min/jquery-3.2.1.min.js?ver=' . time()); ?>" ></script>
    <?php }
    ?>
    <script src="<?php echo base_url('assets/js_min/jquery-ui.min-1.12.1.js?ver=' . time()); ?>"></script>  
<?php }
?>

<script src="<?php echo base_url('node_modules/socket.io/node_modules/socket.io-client/socket.io.js?ver='.time());  ?>"></script>
<script src="<?php echo base_url('assets/js/classie.js?ver='.time());  ?>"></script>