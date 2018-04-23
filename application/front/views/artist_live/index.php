<!DOCTYPE html>
<html lang="en" ng-app="artistApp" ng-controller="artistController">
    <head>
        <title ng-bind="title"></title>
        <meta charset="utf-8">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/bootstrap.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">

        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
    </head>
    <body class="profile-main-page">
        <?php echo $header_profile; ?>
        <div class="middle-section middle-section-banner">
            <?php echo $search_banner; ?>
            <div class="container pt20">
                <div class="custom-width-box">
                    <div class="pt20 pb20">
                        <div class="center-title">
                            <h3>Categories</h3>
                        </div>
                        <div class="cat-box">
                            <ul>
                                <li ng-repeat="category in artistCategory">
                                    <a href="<?php echo base_url('artist/category/') ?>{{category.category_slug}}">
                                        <img src="<?php echo base_url('assets/n-images/car.png') ?>" alt="category.art_category">
                                        <p><span ng-bind="category.art_category | capitalize"></span><span ng-bind="'(' + (category.count) + ')'"></span></p>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('artist/category/other') ?>">
                                        <img src="<?php echo base_url('assets/n-images/car.png') ?>" alt="Other">
                                        <p>Other<span ng-bind="'(' + otherCategoryCount + ')'"></span></p>
                                    </a>
                                </li>
                            </ul>
                            <p class="text-center"><a href="<?php echo base_url('artist/category') ?>" class="btn-1">View More</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container pt20">
                <div class="custom-width-box">
                    <div class="pt20 pb20">
                        <div class="center-title">
                            <h3>What is Artist</h3>
                        </div>
                    </div>
                    <div class="row pt20 pb20">
                        <div class="col-md-6 col-sm-6 pull-right">
                            <div class="content-img text-center">
                                <img src="<?php echo base_url('assets/n-images/img1.jpg') ?>">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <p>Aileensoul is a new-age career-oriented portal that provides a host of free services to a diverse audience in relation to job search, hiring, freelancing, business networking and a platform to showcase one’s artistic abilities and talent to the world. The highly sophisticated and tech-enabled website delivers its unique and comprehensive range of offerings through focused service profiles that include its one of a kind ‘Recruiter Profile’, which empowers recruiters to reach out to and interact with qualified and deserving candidates in a completely new and innovative way. </p>
                            <p>
                                <br>
                                Aileensoul is a new-age career-oriented portal that provides a host of free services to a diverse audience in relation to job search, hiring, freelancing, business networking and a platform to showcase one’s artistic abilities and talent to the world. The highly sophisticated and tech-enabled website delivers its unique and comprehensive range of offerings through focused service profiles that include its one of a kind ‘Recruiter Profile’, which empowers recruiters to reach out to and interact with qualified and deserving candidates in a completely new and innovative way. </p>
                        </div>
                    </div>
                    <div class="row pt20 pb20">
                        <div class="col-md-6 col-sm-6">
                            <div class="content-img text-center">
                                <img src="<?php echo base_url('assets/n-images/img1.jpg') ?>">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <p>Aileensoul is a new-age career-oriented portal that provides a host of free services to a diverse audience in relation to job search, hiring, freelancing, business networking and a platform to showcase one’s artistic abilities and talent to the world. The highly sophisticated and tech-enabled website delivers its unique and comprehensive range of offerings through focused service profiles that include its one of a kind ‘Recruiter Profile’, which empowers recruiters to reach out to and interact with qualified and deserving candidates in a completely new and innovative way. </p>
                            <p>
                                <br>
                                Aileensoul is a new-age career-oriented portal that provides a host of free services to a diverse audience in relation to job search, hiring, freelancing, business networking and a platform to showcase one’s artistic abilities and talent to the world. The highly sophisticated and tech-enabled website delivers its unique and comprehensive range of offerings through focused service profiles that include its one of a kind ‘Recruiter Profile’, which empowers recruiters to reach out to and interact with qualified and deserving candidates in a completely new and innovative way. </p>
                        </div>
                    </div>
                    <div class="row pt20 pb20">
                        <div class="col-md-6 col-sm-6 pull-right">
                            <div class="content-img text-center">
                                <img src="<?php echo base_url('assets/n-images/img1.jpg') ?>">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <p>Aileensoul is a new-age career-oriented portal that provides a host of free services to a diverse audience in relation to job search, hiring, freelancing, business networking and a platform to showcase one’s artistic abilities and talent to the world. The highly sophisticated and tech-enabled website delivers its unique and comprehensive range of offerings through focused service profiles that include its one of a kind ‘Recruiter Profile’, which empowers recruiters to reach out to and interact with qualified and deserving candidates in a completely new and innovative way. </p>
                            <p>
                                <br>
                                Aileensoul is a new-age career-oriented portal that provides a host of free services to a diverse audience in relation to job search, hiring, freelancing, business networking and a platform to showcase one’s artistic abilities and talent to the world. The highly sophisticated and tech-enabled website delivers its unique and comprehensive range of offerings through focused service profiles that include its one of a kind ‘Recruiter Profile’, which empowers recruiters to reach out to and interact with qualified and deserving candidates in a completely new and innovative way. </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-bnr">
                <div class="bnr-box">
                    <img src="<?php echo base_url('assets/n-images/img2.jpg') ?>">
                    <div class="content-bnt-text">
                        <h1>Lorem Ipsum is a dummy text</h1>
                        <p><a href="<?php echo base_url('artist/registration') ?>" class="btn5">Create Artist Profile</a></p>
                    </div>
                </div>
            </div>
            <div class="container pt20">
                <div class="custom-width-box">
                    <div class="pt20 pb20">
                        <div class="center-title">
                            <h3>How it works </h3>
                            <p>Lorem ipsum is dummy text</p>
                        </div>
                    </div>
                    <div class="it-works-img pt20 pb20">
                        <img src="<?php echo base_url('assets/n-images/img3.jpg') ?>">
                    </div>

                    <div class="related-article pt20">
                        <div class="center-title">
                            <h3>Related Article</h3>

                        </div>
                        <div class="row pt10">
                            <div class="col-md-4">
                                <div class="rel-art-box">
                                    <img src="<?php echo base_url('assets/n-images/art-post.jpg') ?>">
                                    <div class="rel-art-name">
                                        <a href="#">Article Name</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="rel-art-box">
                                    <img src="<?php echo base_url('assets/n-images/art-post.jpg') ?>">
                                    <div class="rel-art-name">
                                        <a href="#">Article Name</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="rel-art-box">
                                    <img src="<?php echo base_url('assets/n-images/art-post.jpg') ?>">
                                    <div class="rel-art-name">
                                        <a href="#">Article Name</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script>
                                            var base_url = '<?php echo base_url(); ?>';
                                            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
                                            var title = '<?php echo $title; ?>';
                                            var header_all_profile = '<?php echo $header_all_profile; ?>';
                                            var q = '';
                                            var l = '';
                                            var app = angular.module('artistApp', ['ui.bootstrap']);
        </script>               
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/artist-live/searchArtist.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/artist-live/index.js?ver=' . time()) ?>"></script>
    </body>
</html>