<!-- <!DOCTYPE html>
-->
<html class="blog_cl">
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>
        <title>Official Blog for Regular Updates , News and sharing knowledge - Ailensoul.com</title>
        <meta name="description" content="Our Aileensoul official blog will describe our free service and related news, tips and tricks - stay tuned." />
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({
                google_ad_client: "ca-pub-6060111582812113",
                enable_page_level_ads: true
            });
        </script>
        <style type="text/css">
            footer > .container{border:1px solid transparent!important;}
            .footer{border:1px solid #d9d9d9;}
        </style>

        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/blog.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()); ?>">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css?ver=' . time()); ?>">
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()); ?>" ></script>
    </head>
    <body class="blog" ng-app='myapp'>
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
                                    <a href="<?php echo base_url('blog'); ?>">
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
                                            <a title="Recent Post" href="<?php echo base_url('blog'); ?>">Recent Post </a>
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
                    <div class="container" ng-controller='fetchCtrl'>
                        <div class="post" ng-repeat='post in posts'>
                               <h1>{{ post.id}}</h1>
                            <div class="blog_main_o">
                                            <div class="date_blog_left">
                                                <div class="blog-date-change">
                                                    <div class="blog-month blog-picker">
                                                        <span class="blog_monthd">
                                                            {{ post.created_date |  toSec | date:'MMM'}}
                                                          
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span class="blog_mdate">
                                                              {{ post.created_date |  toSec | date:'dd'}}
                                                        </span>
                                                    </div>
                                                    <div class="blog-year blog-picker">
                                                        <span class="blog_moyear" >
                                                          {{ post.created_date |  toSec | date:'yyyy'}}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="blog-left-comment">
                                                    <div class="blog-comment-count">
                                                        <a>
                                                            <?php
                                                           
                                                            $condition_array1 = array('status' => 'approve', 'blog_id' => post.id);
                                                            $blog_comment = $this->common->select_data_by_condition('blog_comment', $condition_array1, $data1 = '*', $short_by1 = 'id', $order_by1 = 'desc', $limit1 = 5, $offset1, $join_str1 = array());
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
                                                                <a href="<?php echo base_url('blog') ?>{{post.blog_slug}}"> <img src="<?php echo base_url($this->config->item('blog_main_upload_path'))?>{{post.image}}" ></a>
                                                            </div>
                                                        </div>
                                                        <div class="blog_main_post_second_part">
                                                            <div class="blog_class_main_name">
                                                                <span>
                                                                    <a href="<?php echo base_url('blog') ?>{{post.blog_slug}}">
                                                                        <h1>{{post.title}} </h1>
                                                                    </a>
                                                                </span>
                                                            </div>
                                                            <div class="blog_class_main_by">
                                                                <span>
                                                                </span>
                                                            </div>
                                                            <div class="blog_class_main_desc ">
                                                                <span class="dot_span_desc">
                                                                   {{post.description}}
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

                                                                            <a class="fbk" href="<?php base_url('blog');?>{{post.blog_slug | escape}}" url_encode="<?php echo $url; ?>" url="<?php echo base_url('blog')?>{{post.slug}}" title="Facebook" summary="<?php echo $summary; ?>" image="<?php echo $image; ?>"> 
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
                                        </div>
<!--                         Post 
                        <div class="post" ng-repeat='post in posts'>
                            <h1>{{ post.title}}</h1>
                            <h1>{{ post.id}}</h1>
                            <p>
                                {{ post.shortcontent}}
                            </p>
                            <a href="{{ post.link}}" class="more" target="_blank">More</a>
                        </div>

-->                        <h1 class="load-more" ng-show="showLoadmore" ng-click='getPosts()'>{{ buttonText}}</h1>
                        <input type="hidden" id="row" ng-model='row'>
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
    var fetch = angular.module('myapp', []);
    var base_url = '<?php echo base_url(); ?>';
    fetch.controller('fetchCtrl', ['$scope', '$http', function ($scope, $http) {

            // Variables
            $scope.showLoadmore = true;
            $scope.row = 0;
            $scope.rowperpage = 3;
            $scope.buttonText = "Load More";

            // Fetch data
            $scope.getPosts = function () {

                $http({
                    method: 'post',
                    url: base_url + 'blogdata/bloglist',
                    data: {row: $scope.row, rowperpage: $scope.rowperpage}
                }).then(function successCallback(response) {

                    if (response.data != '') {

                        $scope.row += $scope.rowperpage;
                        if ($scope.posts != undefined) {
                            $scope.buttonText = "Loading ...";
                            setTimeout(function () {
                                $scope.$apply(function () {
                                    angular.forEach(response.data, function (item) {
                                        $scope.posts.push(item);
                                    });
                                    $scope.buttonText = "Load More";
                                });
                            }, 500);
                            // $scope.posts.push(response.data);

                        } else {
                            $scope.posts = response.data;
                        }
                    } else {
                        $scope.showLoadmore = false;
                    }

                });
            }

            // Call function
            $scope.getPosts();

        }]);
    
    fetch.filter('toSec', function($filter) {
  return function(input) {
      var result = new Date(input).getTime();
      return result || '';
  };
});

fetch.filter('escape', function() {
    return function(input) {
        if(input) {
            return window.encodeURIComponent(input); 
        }
        return "";
    }
});

</script>
<script>
    var base_url = '<?php echo base_url(); ?>';
</script>

<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/blog/blog.js?ver=' . time()); ?>"></script>

