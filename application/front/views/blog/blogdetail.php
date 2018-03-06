<!DOCTYPE html>
<?php
if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
    header("HTTP/1.1 304 Not Modified");
    exit();
}

$format = 'D, d M Y H:i:s \G\M\T';
$now = time();

$date = gmdate($format, $now + 30);
header('Expires: ' . $date);
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<html lang="en">
    <head>
        <title><?php echo $blog_detail[0]['title']; ?> - Aileensoul</title>
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

            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({
                    google_ad_client: "ca-pub-6060111582812113",
                    enable_page_level_ads: true
                });
            </script>
            <meta name="msvalidate.01" content="41CAD663DA32C530223EE3B5338EC79E" />
            <?php
        }
        ?>
        <meta name="google-site-verification" content="BKzvAcFYwru8LXadU4sFBBoqd0Z_zEVPOtF0dSxVyQ4" />
        <!-- Open Graph data -->
        <meta property="og:title" content="<?php echo $blog_detail[0]['title']; ?>" />
        <meta  property="og:type" content="Blog" />
        <meta  property="og:image" content="<?php echo base_url($this->config->item('blog_main_upload_path') . $blog_detail[0]['image']) ?>" />
        <meta  property="og:description" content="<?php echo $blog_detail[0]['meta_description']; ?>" />
        <meta  property="og:url" content="<?php echo base_url('blog/' . $blog_detail[0]['blog_slug']) ?>" />
        <meta property="fb:app_id" content="825714887566997" />

        <!-- for twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="<?php base_url('blog/' . $blog_detail[0]['blog_slug']) ?>">
        <meta name="twitter:title" content="<?php $blog_detail[0]['title']; ?>">
        <meta name="twitter:description" content="<?php $blog_detail[0]['meta_description']; ?>">
        <meta name="twitter:creator" content="By Aileensoul">
        <meta name="twitter:image" content="http://placekitten.com/250/250">
        <meta name="twitter:domain" content="<?php base_url('blog/' . $blog_detail[0]['blog_slug']) ?>">
        <?php
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <link rel="canonical" href="<?php echo $actual_link ?>" />

        <?php if (IS_OUTSIDE_CSS_MINIFY == '0') {
            ?>

            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/blog.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css?ver=' . time()); ?>">
        <?php } else { ?>

            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/blog.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/font-awesome.min.css?ver=' . time()); ?>">
        <?php } ?>
    </head>
    <body class="blog-detail blog">
        <div class="main-inner">
            <header>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-3 ">
                            <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png?ver=' . time()) ?>" alt="logo"></a>
                        </div>
                        <div class="col-md-8 col-sm-9  pt-10">
                            <div class="btn-right pull-right pt10">
                                <?php if (!$this->session->userdata('aileenuser')) { ?>
                                    <a href="<?php echo base_url('login'); ?>" class="btn2">Login</a>
                                    <a href="<?php echo base_url('registration'); ?>" class="btn3">Create an account</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        </div>
        <div class="blog_header">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-5 col-xs-3 mob-zindex">
                        <div class="logo pl20">
                            <a href="<?php echo base_url('blog'); ?>">
                                <h3  style="color: #1b8ab9;">Blog</h3>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-7 col-xs-9 header-left-menu">
                        <div class="main-menu-right">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section>
            <div class="blog-mid-section user-midd-section">
                <div class="container">
                    <div class="row">
                        <div class="blog_post_outer col-md-9 col-sm-8 pr0">
                            <div class="job-contact-frnd">
                                <?php
                                if (count($blog_detail) > 0) {
                                    ?>
                                    <div class="date_blog_right2">
                                        <div class="blog_post_main">
                                            <div class="blog_inside_post_main">
                                                <div class="blog_main_post_first_part">
                                                    <div class="blog_main_post_img">
                                                        <img src="<?php echo base_url($this->config->item('blog_main_upload_path') . $blog_detail[0]['image'] . '?ver=' . time()) ?>"  alt="Blog">
                                                    </div>
                                                </div>
                                                <div class="blog_main_post_second_part">
                                                    <div class="blog_class_main_name">
                                                        <h1><?php echo $blog_detail[0]['title']; ?></h1>
                                                    </div>
                                                    <div class="blog_class_main_by">
                                                    </div>
                                                    <div class="blog_class_main_desc">
                                                        <?php echo $blog_detail[0]['description']; ?>
                                                    </div>
                                                    <div class="blog_class_main_social">
                                                        <div class="left_blog_icon fl">
                                                            <ul class="social_icon_bloag fl">
                                                                <li>
                                                                    <?php
                                                                    $title = urlencode('"' . $blog_detail[0]['title'] . '"');
                                                                    $url = urlencode(base_url('blog/' . $blog_detail[0]['blog_slug']));
                                                                    $summary = urlencode('"' . $blog_detail[0]['description'] . '"');
                                                                    $image = urlencode(base_url($this->config->item('blog_main_upload_path') . $blog_detail[0]['image']));
                                                                    ?>
                                                                    <a onclick="window.open('http://www.facebook.com/sharer.php?p[url]=<?php echo $url; ?>', 'sharer', 'toolbar=0,status=0,width=620,height=280');" href="javascript: void(0)"> 
                                                                        <span  class="social_fb"></span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="https://plus.google.com/share?url=<?php echo $url; ?>" onclick="javascript:window.open('https://plus.google.com/share?url=<?php echo $url; ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                                                                        <span  class="social_gp"></span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="https://www.linkedin.com/cws/share?url=<?php echo $url; ?>"  onclick="javascript:window.open('https://www.linkedin.com/cws/share?url=<?php echo $url; ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><span  class="social_lk"></span></a>
                                                                </li>
                                                                <li>
                                                                    <a href="https://twitter.com/intent/tweet?url=<?php echo $url; ?>"  onclick="javascript:window.open('https://twitter.com/intent/tweet?url=<?php echo $url; ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><span  class="social_tw"></span></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="fr blog_view_link2">
                                                            <?php
                                                            if (count($blog_all) != 0) {
                                                                foreach ($blog_all as $key => $blog) {
                                                                    if ($blog['id'] == $blog_detail[0]['id'] && ($key + 1) != 1) {
                                                                        ?>
                                                                        <a href="<?php echo base_url('blog/' . $blog_all[$key - 1]['blog_slug']); ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                            <span>
                                                                <?php
                                                                if (count($blog_all) != 0) {

                                                                    foreach ($blog_all as $key => $blog) {

                                                                        if ($blog['id'] == $blog_detail[0]['id']) {
                                                                            echo $key + 1;
                                                                            echo '/';
                                                                            echo count($blog_all);
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            </span>
                                                            <?php
                                                            if (count($blog_all) != 0) {

                                                                foreach ($blog_all as $key => $blog) {

                                                                    if ($blog['id'] == $blog_detail[0]['id'] && ($key + 1) != count($blog_all)) {
                                                                        ?>
                                                                        <a href="<?php echo base_url('blog/' . $blog_all[$key + 1]['blog_slug']); ?>"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    //FOR GETTING USER COMMENT
                                                    $condition_array = array('status' => 'approve', 'blog_id' => $blog_detail[0]['id']);
                                                    $blog_comment = $this->common->select_data_by_condition('blog_comment', $condition_array, $data = '*', $short_by = 'id', $order_by = 'desc', $limit ="", $offset="", $join_str = array());


                                                    foreach ($blog_comment as $comment) { 
                                                        ?>  
                                                        <div class="all-comments">
                                                            <ul>
                                                                <li class="comment-list">
                                                                    <div class="c-user-img">
                                                                        <img src="<?php echo base_url(NOIMAGE) . '?ver=' . time(); ?>" alt="Noimage">
                                                                    </div>
                                                                    <div class="c-user-comments">
                                                                        <h5><?php echo ucfirst($comment['name']); ?></h5>
                                                                        <p><?php echo $comment['message']; ?></p>
                                                                        <p class="pt5"><span class="comment-time">
                                                                                <?php
                                                                                $date = new DateTime($comment['comment_date']);
                                                                                echo $date->format('d') . PHP_EOL;
                                                                                echo "-";

                                                                                $date = new DateTime($comment['comment_date']);
                                                                                echo $date->format('M') . PHP_EOL;
                                                                                echo "-";

                                                                                $date = new DateTime($comment['comment_date']);
                                                                                echo $date->format('Y') . PHP_EOL;
                                                                                ?>
                                                                            </span>
                                                                        </p>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <?php
                                                    }//for loop end
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="comment_box">
                                        <h3>Give Comment</h3>
                                        <form name="comment" id="comment" method="post" autocomplete="off">
                                            <fieldset class="full-width comment_foem">
                                                <label>Name </label>
                                                <input type="text" name="name" id="name" placeholder="Enter your name">
                                            </fieldset>
                                            <fieldset class="full-width comment_foem">
                                                <label>Email Address </label>
                                                <input type="text" name="email" id="email" placeholder="Enter your email address">
                                            </fieldset>
                                            <fieldset class="full-width comment_foem">
                                                <label>Message </label>
                                                <textarea name="message" id="message" placeholder="Enter Your message"></textarea>
                                            </fieldset>
                                            <input type="hidden" value="<?php echo $blog_detail[0]['id']; ?>" name="blog_id" id="blog_id">
                                            <fieldset class="comment_foem">
                                                <button>Send a Comment</button>
                                            </fieldset>
                                        </form>
                                    </div>
                                    <?php if (count($rand_blog) > 0) { ?>
                                        <div class="related-blog">
                                            <h3>Related Blogs</h3>
                                            <div class="row">
                                                <?php foreach ($rand_blog as $random) { ?>
                                                    <div class="col-md-4 col-sm-12">
                                                        <div class="rel-blog-box">
                                                            <a href="<?php echo base_url('blog/' . $random['blog_slug']) ?>"><div class="rel-blog-img">
                                                                    <img src="<?php echo base_url($this->config->item('blog_related_upload_path') . $random['image'] . '?ver=' . time()) ?>" alt="<?php echo $random['image']; ?>">
                                                                </div></a>
                                                            <h5> <a href="<?php echo base_url('blog/' . $random['blog_slug']) ?>"><?php echo $random['title']; ?> </a> </h5>
                                                        </div>
                                                    </div>

                                                <?php } ?>

                                            </div>
                                        </div>
                                    <?php } ?>

                                <?php } else {
                                    ?>

                                    <div class="art_no_post_avl">
                                        <div class="art-img-nn">
                                            <div class="art_no_post_img">
                                                <img src="<?php echo base_url('assets/img/bui-no.png?ver=' . time()) ?>" alt="Noimage">
                                            </div>
                                            <div class="art_no_post_text">
                                                Sorry, this content isn't available at the moment
                                            </div>
                                        </div>
                                    </div>

                                <?php }
                                ?>
                            </div> 

                            <ul class="load-more-blog">
                                <li class="loadcatbutton"></li>
                            </ul>
                        </div>
                        <div class="col-md-3 col-sm-4 hidden-xs">
                            <div class="blog_latest_post" >
                                <h3>Latest Post</h3>
                                <?php
                                foreach ($blog_last as $blog) {
                                    ?>
                                    <div class="latest_post_posts">
                                        <ul>
                                            <li>
                                                <div class="post_inside_data">
                                                    <div class="post_latest_left">
                                                        <div class="lateaqt_post_img">
                                                            <a href="<?php echo base_url('blog/' . $blog['blog_slug']) ?>"> <img src="<?php echo base_url($this->config->item('blog_thumb_upload_path') . $blog['image'] . '?ver=' . time()) ?>" alt="<?php echo $blog['image']; ?>"></a>
                                                        </div>
                                                    </div>
                                                    <div class="post_latest_right">
                                                        <div class="desc_post">
                                                            <a href="<?php echo base_url('blog/' . $blog['blog_slug']) ?>"><span class="rifght_fname"> <?php echo $blog['title']; ?> </span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li></li>
                                        </ul>
                                    </div>
                                    <!--latest_post_posts end -->
                                    <?php
                                }//for loop end
                                ?>
                            </div>
                            
                            
                            <!--blog_latest_post end -->

                        </div>
                    </div>
                </div>

            </div>


            <!-- Bid-modal  -->
            <div class="modal fade message-box biderror" id="bidmodal" role="dialog"  >
                <div class="modal-dialog modal-lm" >
                    <div class="modal-content message">
                        <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                        <div class="modal-body">
                            <span class="mes"></span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Model Popup Close -->

        </section>

        <?php if (IS_OUTSIDE_JS_MINIFY == '0') { ?>
            <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()); ?>" ></script>
            <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>

        <?php } else { ?>

            <script src="<?php echo base_url('assets/js_min/jquery-3.2.1.min.js?ver=' . time()); ?>" ></script>
            <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
        <?php } ?>
        <?php
        echo $login_footer
        ?>

        <?php if (IS_OUTSIDE_JS_MINIFY == '0') { ?>
            <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
            <script src="<?php echo base_url('assets/js/jquery.validate.js?ver=' . time()); ?>"></script>
        <?php } else { ?>

            <script src="<?php echo base_url('assets/js_min/jquery.validate.min.js') ?>"></script>
            <script src="<?php echo base_url('assets/js_min/jquery.validate.js?ver=' . time()); ?>"></script>
        <?php } ?>
        <!-- This Js is used for call popup -->

        <script>
                                                                    var base_url = '<?php echo base_url(); ?>';
        </script>
        <script>

            //AJAX DATA LOAD BY LAZZY LOADER END
        </script>
        <?php if (IS_OUTSIDE_JS_MINIFY == '0') { ?>
            <script src="<?php echo base_url('assets/js/webpage/blog/blog_detail.js?ver=' . time()); ?>"></script>
        <?php } else { ?>
            <script src="<?php echo base_url('assets/js_min/webpage/blog/blog_detail.js?ver=' . time()); ?>"></script>

        <?php } ?>
    </body>
</html>