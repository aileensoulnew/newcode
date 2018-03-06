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
        <div class="main-inner">
            <?php echo $sitemap_header ?>
            <section class="middle-main">
                <div class="container">
                    <!-- html code for inner page  -->
                    <div class="all-site-link">
                        <h2>Artistic Profile</h2>
                        <div class="linkbox full_page">
                            <div class="smap-catbox">
                                <ul class="catbox-right artist-sitemap">
                                    <li style="list-style-type: circle;font-size: 20px; width: 100%;">Login/Register</li>
                                    <li style="padding-bottom: 30px;"><a href="<?php echo base_url('artist/registration') ?>">Register/Takeme in</a></li>
                                </ul>
                            </div>
                        </div>
                        <h3>Profiles</h3>
                        <div class="linkbox">
                            <div class="smap-catbox">
                                <ul class="catbox-right artist-sitemap">
                                    <?php foreach ($getArtistDataByCategory as $artistic) { ?>
                                        <li><a href = "<?php echo base_url('artist/dashboard/' . $artistic['get_url']) ?>" target = "_blank"><?php
                                                echo $artistic['art_name'] . ' ' . $artistic['art_lastname'];
                                                if ($artistic['art_skill'] != '' && $artistic['other_skill'] != '') {
                                                    echo ' <span class="art_category">(' . trim($artistic['art_skill']) .', '. trim($artistic['other_skill']) . ')</span>';
                                                } else {
                                                    if ($artistic['art_skill'] != '') {
                                                        echo ' <span class="art_category">(' . trim($artistic['art_skill']) . ')</span>';
                                                    }
                                                    if ($artistic['other_skill'] != '') {
                                                        echo ' <span class="art_category">(' . trim($artistic['other_skill']) . ')</span>';
                                                    }
                                                }
                                                ?></a></li>    
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