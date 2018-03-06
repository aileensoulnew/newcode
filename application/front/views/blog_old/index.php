<!-- <!DOCTYPE html>
-->
<html class="blog_cl">
    <head>
        <title>Official Blog for Regular Updates , News and sharing knowledge - Ailensoul.com</title>
        <meta name="description" content="Our Aileensoul official blog will describe our free service and related news, tips and tricks - stay tuned." />
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
        <style type="text/css">
            footer > .container{border:1px solid transparent!important;}
            .footer{border:1px solid #d9d9d9;}
        </style>
        <?php
        foreach ($blog_detail as $blog) {
            ?>
            <!-- Open Graph data -->
            <meta property="og:title" content="<?php echo $blog['title']; ?>" />
            <meta  property="og:type" content="Blog" />
            <meta  property="og:image" content="<?php echo base_url($this->config->item('blog_main_upload_path') . $blog['image']) ?>" />
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

        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/blog.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()); ?>">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css?ver=' . time()); ?>">
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()); ?>" ></script>
    </head>
    <body class="blog">
        <div class="main-inner">
            <header>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-3">
                          <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png?ver='.time()) ?>" alt="logo"></a>
                        </div>
                        <div class="col-md-8 col-sm-9 pt10">
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
                                    <a href="<?php echo base_url('blog/'); ?>">
                                        <h3  style="color: #1b8ab9;">Blog</h3>
                                    </a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="javascript:void(0)">
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
                                    <li>
                                        <?php
                                        if ($this->input->get('q') || $this->uri->segment(2) == 'popular' || $this->uri->segment(2) == 'tag') {
                                            ?>
                                            <a title="Recent Post" href="<?php echo base_url('blog/'); ?>">Recent Post </a>
                                            <?php
                                        } else {
                                            ?>
                                            <a title="Recent Post" href="javascript:void(0)">Recent Post </a>
                                            <?php
                                        }
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        if ($this->uri->segment(3) == 'popular') {
                                            ?>
                                            <a title="Most Popular" href="javascript:void(0)">Most Popular</a>
                                            <?php
                                        } else {
                                            ?>
                                            <a title="Most Popular" href="<?php echo base_url('blog/popular'); ?>">Most Popular</a>
                                            <?php
                                        }
                                        ?>
                                    </li>
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
                            <div class="searc_w"><input type="" name="" placeholder="Search Blog Post"></div>
                            <div class="butn_w"><a href=""><i class="fa fa-search" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="blog-mid-section user-midd-section">
                    <div class="container">
                        <div class="row">
                            <div class="blog_post_outer col-md-9 col-sm-8 pr0">
                                <?php
                                if ($this->input->get('q')) {
                                    ?>
                                    <div class="blog-tag">
                                        <div class="tag-line"><span>Search results for</span> <?php echo $search_keyword; ?></div>
                                    </div>
                                    <?php
                                }//if end  
                                if ($this->uri->segment(2) == 'tag') {
                                    ?>
                                    <div class="blog-tag">
                                        <div class="tag-line"><span>Tag:</span> <?php echo $search_keyword; ?></div>
                                    </div>
                                    <?php
                                }//if end  

                                if (count($blog_detail) == 0) {

                                    if ($this->input->get('q') || $this->uri->segment(2) == 'tag') {
                                        ?>
                                        <div class="job-saved-box">
                                            <div class="blog-tag" style="margin-bottom: 0px;">

                                            </div>
                                            <div class="contact-frnd-post">
                                                <div class="text-center rio">
                                                    <h1 class="page-heading  product-listing" style="border:0px;margin-bottom: 11px;">Oops No Data Found.</h1>
                                                    <p style="margin-left:4%;text-transform:none !important;border:0px;">We couldn't find what you were looking for.</p>
                                                    <ul>
                                                        <li style="text-transform:none !important; list-style: none;">Make sure you used the right keywords.</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    if ($this->uri->segment(3) == 'popular') {
                                        echo "Not Any Popular Blog";
                                    }
                                }//if end
                                else {

                                    foreach ($blog_detail as $blog) {
                                        ?>
                                        <div class="blog_main_o">
                                            <div class="date_blog_left">
                                                <div class="blog-date-change">
                                                    <div class="blog-month blog-picker">
                                                        <span class="blog_monthd">
                                                            <?php
                                                            $date_time = new DateTime($blog['created_date']);
                                                            $month = $date_time->format('M') . PHP_EOL;
                                                            echo $month;
                                                            ?>
                                                        </span>
                                                    </div class="blog-date blog-picker">
                                                    <div>
                                                        <span class="blog_mdate">
                                                            <?php
                                                            $date = new DateTime($blog['created_date']);
                                                            echo $date->format('d') . PHP_EOL;
                                                            ?>
                                                        </span>
                                                    </div>
                                                    <div class="blog-year blog-picker">
                                                        <span class="blog_moyear" >
                                                            <?php
                                                            $year = new DateTime($blog['created_date']);
                                                            echo $year->format('Y') . PHP_EOL;
                                                            ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="blog-left-comment">
                                                    <div class="blog-comment-count">
                                                        <a>
                                                            <?php
                                                            $condition_array = array('status' => 'approve', 'blog_id' => $blog['id']);
                                                            $blog_comment = $this->common->select_data_by_condition('blog_comment', $condition_array, $data = '*', $short_by = 'id', $order_by = 'desc', $limit = 5, $offset, $join_str = array());
                                                            echo count($blog_comment);
                                                            ?>
                                                        </a>
                                                    </div>
                                                    <div class="blog-comment">
                                                        <a>Comments</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="date_blog_right">
                                                <div class="blog_post_main">
                                                    <div class="blog_inside_post_main">
                                                        <div class="blog_main_post_first_part">
                                                            <div class="blog_main_post_img">
                                                                <a href="<?php echo base_url('blog/' . $blog['blog_slug']) ?>"> <img src="<?php echo base_url($this->config->item('blog_main_upload_path') . $blog['image']) ?>" ></a>
                                                            </div>
                                                        </div>
                                                        <div class="blog_main_post_second_part">
                                                            <div class="blog_class_main_name">
                                                                <span>
                                                                    <a href="<?php echo base_url('blog/' . $blog['blog_slug']) ?>">
                                                                        <h1> <?php echo $blog['title']; ?> </h1>
                                                                    </a>
                                                                </span>
                                                            </div>
                                                            <div class="blog_class_main_by">
                                                                <span>
                                                                </span>
                                                            </div>
                                                            <div class="blog_class_main_desc ">
                                                                <span class="dot_span_desc">
                                                                    <?php
                                                                    $num_words = 75;
                                                                    $words = array();
                                                                    $words = explode(" ", $blog['description'], $num_words);
                                                                    $shown_string = "";

                                                                    if (count($words) == 75) {
                                                                        $words[74] = " ...... ";
                                                                    }

                                                                    $shown_string = implode(" ", $words);
                                                                    echo $shown_string;
                                                                    ?>
                                                                </span>
                                                            </div>
                                                            <div class="blog_class_main_social">
                                                                <div class="left_blog_icon fl">
                                                                    <ul class="social_icon_bloag fl">
                                                                        <li>
                                                                            <?php
                                                                            $title = urlencode('"' . $blog['title'] . '"');
                                                                            $url = urlencode(base_url('blog/' . $blog['blog_slug']));
                                                                            $summary = urlencode('"' . $blog['description'] . '"');
                                                                            $image = urlencode(base_url($this->config->item('blog_main_upload_path') . $blog['image']));
                                                                            ?>

                                                                            <a class="fbk" url_encode="<?php echo $url; ?>" url="<?php echo base_url('blog/' . $blog['blog_slug']); ?>" title="Facebook" summary="<?php echo $summary; ?>" image="<?php echo $image; ?>"> 
                                                                                <span  class="social_fb"></span>
                                                                            </a>
                                                                        </li>
                                                                        <li>

                                                                            <a href="https://plus.google.com/share?url=<?php echo $url; ?>" title="Google +" onclick="javascript:window.open('https://plus.google.com/share?url=<?php echo $url; ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                                                                                <span  class="social_gp"></span>
                                                                            </a>
                                                                        </li>
                                                                        <li>

                                                                            <a href="https://www.linkedin.com/cws/share?url=<?php echo $url; ?>" title="linkedin"  onclick="javascript:window.open('https://www.linkedin.com/cws/share?url=<?php echo $url; ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><span  class="social_lk"></span></a>
                                                                        </li>
                                                                        <li>

                                                                            <a href="https://twitter.com/intent/tweet?url=<?php echo $url; ?>"  title="twitter" onclick="javascript:window.open('https://twitter.com/intent/tweet?url=<?php echo $url; ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><span  class="social_tw"></span></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="fr blog_view_link">
                                                                    <a title="Read more" onclick="read_more('<?php echo $blog['id']; ?>', '<?php echo $blog['blog_slug']; ?>')"> Read more <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }//for loop end
                                }//else end
                                ?>
                            </div>

                            <div class="col-md-3 col-sm-4 hidden-xs">
                                <div class="blog_search">
                                    <h6> Blog Search </h6>
                                    <div>

                                        <form action=<?php echo base_url('blog/') ?> method="get" autocomplete="off">
                                            <div class="searc_w"><input type="text" name="q" id="q" placeholder="Search Blog Post"></div>
                                            <button type="submit" class="butn_w" onclick="return checkvalue();"><i class="fa fa-search"></i></button> 

                                            <?php echo form_close(); ?>
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
                                                                    <img src="<?php echo base_url($this->config->item('blog_main_upload_path') . $blog['image']) ?>" alt="">
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

                                <div class="fw text-center pt15 none-1279">
                                    <script type="text/javascript">
                                        (function () {
                                            if (window.CHITIKA === undefined) {
                                                window.CHITIKA = {'units': []};
                                            }
                                            ;
                                            var unit = {"calltype": "async[2]", "publisher": "Aileensoul", "width": 300, "height": 250, "sid": "Chitika Default"};
                                            var placement_id = window.CHITIKA.units.length;
                                            window.CHITIKA.units.push(unit);
                                            document.write('<div id="chitikaAdBlock-' + placement_id + '"></div>');
                                        }());
                                    </script>
                                    <script type="text/javascript" src="//cdn.chitika.net/getads.js" async></script>
                                    <div class="fw pt10">
                                        <a href="https://www.chitika.com/publishers/apply?refid=aileensoul"><img src="https://images.chitika.net/ref_banners/300x250_hidden_ad.png" /></a>
                                    </div>
                                </div>
								<div class="fw text-center pt15 block-1279 main-none">
									<script type="text/javascript">
									(function () {
										if (window.CHITIKA === undefined) {
											window.CHITIKA = {'units': []}; };
										var unit = {"calltype": "async[2]", "publisher": "Aileensoul", "width": 160, "height": 600, "sid": "Chitika Default"};
										var placement_id = window.CHITIKA.units.length;
										window.CHITIKA.units.push(unit);
										document.write('<div id="chitikaAdBlock-' + placement_id + '"></div>');
									}());
									</script>
									<script type="text/javascript" src="//cdn.chitika.net/getads.js" async></script>
								</div>

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
</body>
</html>
<script>
                            var base_url = '<?php echo base_url(); ?>';
</script>

<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/blog/blog.js?ver=' . time()); ?>"></script>

