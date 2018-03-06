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
?>
<html lang="en">
    <head>
        <title><?php echo $title; ?></title>
        <meta name="description" content="Contact us for any concern and query regarding Aileensoul.com platform." />
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <meta charset="utf-8">
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
        <meta name="google-site-verification" content="BKzvAcFYwru8LXadU4sFBBoqd0Z_zEVPOtF0dSxVyQ4" />
        <?php
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <link rel="canonical" href="<?php echo $actual_link ?>" />
        <?php if (IS_OUTSIDE_CSS_MINIFY == '0') { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css?ver=' . time()); ?>">
        <?php } else { ?>

            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style.css?ver=' . time()); ?>">
        <?php } ?>
    </head>
    <body class="contact outer-page">
        <div class="main-inner">
            <?php echo $login_header; ?>
            <div class="contact-banner">
                <img src="<?php echo base_url('assets/img/contactus.jpg?ver=' . time()); ?>" alt="contactus">
            </div>
            <section class="middle-main">
                <div class="container">
                    <div id="contactsucc"></div>
                    <div class="form-pd row">
                        <div class="inner-form">
                            <div class="login">
                                <div class="title">
                                    <h1>Contact us</h1>
                                </div>
                                <form name="contact_form" id="contact_form" method="post">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <input type="text" name="contact_name" id="contact_name" class="form-control input-sm" placeholder="First Name*">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <input type="text" name="contactlast_name" id="contactlast_name" class="form-control input-sm" placeholder="Last Name*">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="contact_email" id="contact_email" class="form-control input-sm" placeholder="Email Address*">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="contact_subject" id="contact_subject" class="form-control input-sm" placeholder="Subject*">
                                    </div>
                                    <div class="form-group">
                                        <textarea id="contact_message" name="contact_message" class="form-control" placeholder="Message*"></textarea>

                                    </div>
                                    <p class="pb15">
                                        <span class="red">*</span>All fields are mandatory
                                    </p>
                                    <p>
                                        <button title="Submit" class="btn1">Submit</button>
                                    </p>
                                </form>
                            </div>


                        </div>
                        <div class="mob-p15">
                            <div class="contact-add">
                                <div class="title">
                                    <h1>Reach Us</h1>
                                </div>
                                <div class="fw p20">
                                    <table style="width:100%;" class="con-address">
                                        <tr>
                                            <td><h4>Address:</h4></td>
                                            <td style="vertical-align:middle;" >
                                                <address>
                                                    Aileensoul Technologies Private Limited<br>
                                                    Satellite,
                                                    Near 100 ft road,<br> Shyamal crossroad,
                                                    Anandnagar,<br>
                                                    Ahmedabad, Gujarat<br> India (380015)</address>
                                            </td>
                                        </tr>
                                        <tr><td colspan="2" style="padding:10px;"></td></tr>
                                    </table>

                                    <table style="width:100%;" class="con-address">
                                        <tr><td colspan="2" style="padding:10px;"></td></tr>
                                        <tr>
                                            <td><h4>Mail Us:</h4></td>
                                            <td><p><a href="mailto:info@aileensoul.com">info@aileensoul.com</a></p>
                                                <p><a href="mailto:inquiry@aileensoul.com">inquiry@aileensoul.com</a></p>
                                                <p><a href="mailto:hr@aileensoul.com">hr@aileensoul.com</a></p>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </section>

            <?php echo $login_footer; ?>
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

        <script>
            var base_url = '<?php echo base_url(); ?>';
            var get_csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
            var get_csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
        </script>
        <?php if (IS_OUTSIDE_JS_MINIFY == '0') { ?>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/js/webpage/contactus.js?ver=' . time()); ?>"></script>
        <?php } else { ?>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/js_min/webpage/contactus.js?ver=' . time()); ?>"></script>
        <?php } ?>
    </body>
</html>