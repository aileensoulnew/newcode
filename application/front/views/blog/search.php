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
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<html class="blog_cl" lang="en">
    <head>
        <title>Search | Official Blog for Regular Updates, News and Sharing knowledge - Aileensoul</title>
        <meta name="description" content="Our Aileensoul official blog will describe our free service and related news, tips and tricks - stay tuned." />
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
        <?php
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <link rel="canonical" href="<?php echo $actual_link ?>" />
        <style>
            footer > .container{border:1px solid transparent!important;}
            .footer{border:1px solid #d9d9d9;}
        </style>
        <?php
        foreach ($blog_detail as $blog) {
            ?>
            <!-- Open Graph data -->
            <meta property="og:title" content="<?php echo $blog['title']; ?>" />
            <meta  property="og:type" content="Blog" />
            <meta  property="og:image" content="<?php echo base_url($this->config->item('blog_main_upload_path') . $blog['image'] . '?ver=' . time()) ?>" />
            <meta  property="og:description" content="<?php echo $blog['meta_description']; ?>" />
            <meta  property="og:url" content="<?php echo base_url('blog/' . $blog['blog_slug']) ?>" />
            <meta property="og:image:width" content="620" />
            <meta property="og:image:height" content="541" />
            <meta property="fb:app_id" content="825714887566997" />

            <!-- for twitter -->
            <meta name="twitter:card" content="summary_large_image">
            <meta name="twitter:site" content="<?php base_url('blog/' . $blog['blog_slug']) ?>">
            <meta name="twitter:title" content="<?php $blog['title']; ?>">
            <meta name="twitter:description" content="<?php $blog['meta_description']; ?>">
            <meta name="twitter:creator" content="By Aileensoul">
            <meta name="twitter:image" content="http://placekitten.com/250/250">
            <meta name="twitter:domain" content="<?php base_url('blog/' . $blog['blog_slug']) ?>">
            <?php
        }
        ?>

        <?php if (IS_OUTSIDE_CSS_MINIFY == '0') { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/blog.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css?ver=' . time()); ?>">

        <?php } else { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/blog.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/font-awesome.min.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style.css?ver=' . time()); ?>">

        <?php } ?>

        <?php if (IS_OUTSIDE_JS_MINIFY == '0') { ?>
            <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()); ?>" ></script>

        <?php } else { ?>
            <script src="<?php echo base_url('assets/js_min/jquery-3.2.1.min.js?ver=' . time()); ?>" ></script>

        <?php } ?>
    </head>
    <body class="blog">
        <div class="main-inner">
            <header>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-3">
                            <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png?ver=' . time()) ?>" alt="logo"></a>
                        </div>
                        <div class="col-md-8 col-sm-9" style="padding-top: 5px;">
                            <div class="btn-right pull-right">
                                <?php if (!$this->session->userdata('aileenuser')) { ?>
                                    <a href="<?php echo base_url('login'); ?>" class="btn2">Login</a>
                                    <a href="<?php echo base_url('registration'); ?>" class="btn3">Create an account</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div class="blog_header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-5 col-xs-3 mob-zindex">

                            <div class="logo pl20">
                                <?php
                                if ($this->input->get('q') || $this->uri->segment(2) == 'popular' || $this->uri->segment(2) == 'tag') {
                                    ?>
                                    <a href="<?php echo base_url('blog'); ?>">
                                        <h3  style="color: #1b8ab9;">Blog</h3>
                                    </a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="<?php echo base_url('blog'); ?>">
                                        <h3  style="color: #1b8ab9;">Blog</h3>
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-7 col-xs-9 header-left-menu">
                            <div class="main-menu-right">
                                <ul class="">
                                    <?php foreach ($blog_category as $category) { ?>
                                        <li class="category">
                                            <div id="category_<?php echo $cateory['id']; ?>"  onclick="return category_data(<?php echo $category['id']; ?>);">
                                                <?php echo $category['name']; ?>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <section>
                <div class="col-md-12 hidden-md hidden-lg pt20">
                    <div class="blog_search">
                        <div>
                             <form action="<?php echo base_url('blog') ?>" method="get" autocomplete="off">
                                            <div class="searc_w"><input type="text" name="p" id="p" placeholder="Search Blog Post"></div>
                                            <button type="submit" class="butn_w" onclick="return checkvalue_one();"><i class="fa fa-search"></i></button> 


                                        </form>

                        </div>
                    </div>
                </div>
                <div class="blog-mid-section user-midd-section">
                    <div class="container">
                        <div class="row">
                            <div class="blog_post_outer col-md-9 col-sm-8 pr0">
                            
                             <?php   if (count($blog_detail) == 0) {

                                        ?>

                    <div class="blog_main_o">
                            <div class="common-form">
                                        <div class="job-saved-box">

                                            
                                     <h3>Search results for 
                                        <?php
                                       
                                            echo '' . $search_keyword . '';
                                       
                                        ?></h3>

                                            <div class="contact-frnd-post">
                                                <div class="job-contact-frnd1">
                                                <div class="text-center rio">
                                                    <h1 class="page-heading  product-listing" style="border:0px;margin-bottom: 11px;">Oops No Data Found.</h1>
                                                    <p style="margin-left:4%;text-transform:none !important;border:0px;">We couldn't find what you were looking for.</p>
                                                    <ul>
                                                        <li style="text-transform:none !important; list-style: none;">Make sure you used the right keywords.</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                        <?php
                                   
                                 }//if end
                                 else {
                                    ?>

                                    <h3 style="border: 1px solid #d9d9d9;color: #5c5c5c;text-align: center;margin-bottom: 20px;">Search results for 
                                        <?php
                                       
                                            echo '' . $search_keyword . '';
                                       
                                        ?></h3>

                                    <div class="job-contact-frnd"> 

                                    </div> 

                        <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo 'LOADERIMAGE'; ?>"/></div>

                                    <ul class="load-more-blog">
                                        <li class="loadbutton"></li>
                                        <li class="loadcatbutton"></li>
                                    </ul>
                                <?php }
                                ?>
                              
                            </div>

                            <div class="col-md-3 col-sm-4 hidden-xs">
                                <div class="blog_search">
                                    <h6> Blog Search </h6>
                                    <div>

                                        <form action="<?php echo base_url('blog') ?>" method="get" autocomplete="off">
                                            <div class="searc_w"><input type="text" name="q" id="q" placeholder="Search Blog Post"></div>
                                            <button type="submit" class="butn_w" onclick="return checkvalue();"><i class="fa fa-search"></i></button> 


                                        </form>
                                    </div>
                                </div>
                                <div class="blog_latest_post">
                                    <h3>Latest Post</h3>
                                    <?php
                                    foreach ($blog_last as $blog) {
                                        ?>
                                        <div class="latest_post_posts">
                                            <ul>
                                                <li>
                                                    <a href="<?php echo base_url('blog/' . $blog['blog_slug']) ?>"> 
                                                        <div class="post_inside_data">
                                                            <div class="post_latest_left">
                                                                <div class="lateaqt_post_img">
                                                                    <img src="<?php echo base_url($this->config->item('blog_thumb_upload_path') . $blog['image'] . '?ver=' . time()) ?>" alt="<?php echo $blog['image']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="post_latest_right">
                                                                <div class="desc_post">
                                                                    <span class="rifght_fname"> <?php echo $blog['title']; ?> </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                        <!--latest_post_posts end -->
                                        <?php
                                    }//for loop end
                                    ?>
                                </div>


                            </div>


                        </div>
                    </div>
                </div>

            </section>
            <?php
            echo $login_footer
            ?>
        </div>

        <script>
            var base_url = '<?php echo base_url(); ?>';
            var keyword = '<?php echo $search_keyword; ?>';
        </script>
        <script>
            //AJAX DATA LOAD BY LAZZY LOADER START
            $(document).ready(function () {
                blog_post();
                document.getElementById("loader").classList.add("middle_loader");
                //document.getElementById("loader").className = "middle_loader";
            });

            function category_data(catid, pagenum) {
                $('.job-contact-frnd').html("");
                $('.loadbutton').html("");
                cat_post(catid, pagenum);
            }

            $('.loadcatbutton').click(function () {
                var pagenum = parseInt($(".page_number:last").val()) + 1;
                var catid = $(".catid").val();
                cat_post(catid, pagenum);
            });

            var isProcessing = false;
            function cat_post(catid, pagenum) {
                if (isProcessing) {

                    return;
                }
                isProcessing = true;
                $.ajax({
                    type: 'POST',
                    url: base_url + "blog/cat_ajax?page=" + pagenum + "&cateid=" + catid,
                    data: {total_record: $("#total_record").val()},
                    dataType: "json",
                    beforeSend: function () {
                        $('#loader').show();
                    },
                    complete: function () {
                        $('#loader').hide();
                    },
                    success: function (data) {
                        //$('.loader').remove();
                        $('.job-contact-frnd').append(data.blog_data);
                        $('.loadcatbutton').html(data.load_msg)
                        // second header class add for scroll
                        var nb = $('.post-design-box').length;
                        if (nb == 0) {
                            $("#dropdownclass").addClass("no-post-h2");
                        } else {
                            $("#dropdownclass").removeClass("no-post-h2");
                        }
                        isProcessing = false;
                    }
                });
            }


            $('.loadbutton').click(function () {
                var pagenum = parseInt($(".page_number:last").val()) + 1;
                blog_post(pagenum);
            });


            var isProcessing = false;
            function blog_post(pagenum) { 
                if (isProcessing) {
                    return;
                }
                isProcessing = true;
                $.ajax({
                    type: 'POST',
                    url: base_url + "blog/blog_ajax?page=" + pagenum + "&searchword=" + keyword,
                    data: {total_record: $("#total_record").val()},
                    dataType: "json",
                    beforeSend: function () {
                        $('#loader').show();
                    },
                    complete: function () {
                        $('#loader').hide();
                    },
                    success: function (data) {
                        // $('.loader').remove();

                      document.getElementById("loader").classList.remove("middle_loader");


                        $('.job-contact-frnd').append(data.blog_data);
                        $('.loadbutton').html(data.load_msg)
                        // second header class add for scroll
                        var nb = $('.post-design-box').length;
                        if (nb == 0) {
                            $("#dropdownclass").addClass("no-post-h2");
                        } else {
                            $("#dropdownclass").removeClass("no-post-h2");
                        }
                        isProcessing = false;
                    }
                });
            }
            //AJAX DATA LOAD BY LAZZY LOADER END
        </script>
        <?php if (IS_OUTSIDE_JS_MINIFY == '0') { ?>
            <script src="<?php echo base_url('assets/js/webpage/blog/blog.js?ver=' . time()); ?>"></script>
        <?php } else { ?>
            <script src="<?php echo base_url('assets/js_min/webpage/blog/blog.js?ver=' . time()); ?>"></script>
        <?php } ?>
    </body>
</html>
