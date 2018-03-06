<!DOCTYPE html>
<html lang="en" ng-app="businessSearchListApp" ng-controller="businessSearchListController">
    <head>
        <title ng-bind="title"></title>
        <meta charset="utf-8">
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
            <div class="container">
                <div class="left-part">
                    <div class="left-search-box list-type-bullet">
                        <div class="">
                            <h3>Top Categories</h3>
                        </div>
                        <ul class="search-listing custom-scroll">
                            <li ng-repeat="category in businessCategory">
                                <label class=""><a href="<?php echo base_url('business-profile/category/') ?>{{category.industry_slug}}">{{category.industry_name}}<span class="pull-right">({{category.count}})</span></a></label>
                            </li>
                            <li>
                                <label class=""><a href="<?php echo base_url('business-profile/category/other') ?>">Other<span class="pull-right">({{otherCategoryCount}})</span></a></label>
                            </li>
                        </ul>
                    </div>

                    <div class="custom_footer_left fw">
                        <div class="">
                            <ul>
                                <li>
                                    <a href="#" target="_blank">
                                        <span class="custom_footer_dot"> · </span> About Us 
                                    </a>
                                </li>
                                <li>
                                    <a href="#" target="_blank">
                                        <span class="custom_footer_dot"> · </span> Contact Us
                                    </a>
                                </li>
                                <li>
                                    <a href="#" target="_blank">
                                        <span class="custom_footer_dot"> · </span> Blogs 
                                    </a>
                                </li>
                                <li>
                                    <a href="#" target="_blank">
                                        <span class="custom_footer_dot"> · </span> Privacy Policy 
                                    </a>
                                </li>
                                <li>
                                    <a href="#" target="_blank">
                                        <span class="custom_footer_dot"> · </span> Terms &amp; Condition
                                    </a>
                                </li>
                                <li>
                                    <a href="#" target="_blank">
                                        <span class="custom_footer_dot"> · </span> Send Us Feedback
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="middle-part">
                    <div class="page-title">
                        <h3>Search Result</h3>
                    </div>
                    <div class="all-job-box search-business" ng-repeat="business in businessList">
                        <div class="search-business-top">
                            <div class="bus-cover no-cover-upload">
                                <a href="<?php echo BASEURL ?>business-profile/dashboard/{{business.business_slug}}" ng-if="business.profile_background"><img ng-src="<?php echo BUS_BG_MAIN_UPLOAD_URL ?>{{business.profile_background}}"></a>
                                <a href="<?php echo BASEURL ?>business-profile/dashboard/{{business.business_slug}}" ng-if="!business.profile_background"><img ng-src="<?php echo BASEURL.WHITEIMAGE ?>"></a>
                            </div>
                            <div class="all-job-top">
                                <div class="post-img">
                                    <a href="<?php echo BASEURL ?>business-profile/dashboard/{{business.business_slug}}" ng-if="business.business_user_image"><img ng-src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL ?>{{business.business_user_image}}"></a>
                                    <a href="<?php echo BASEURL ?>business-profile/dashboard/{{business.business_slug}}" ng-if="!business.business_user_image"><img ng-src="<?php echo BASEURL.NOBUSIMAGE ?>"></a>
                                </div>
                                <div class="job-top-detail">
                                    <h5><a href="<?php echo BASEURL ?>business-profile/dashboard/{{business.business_slug}}" ng-bind="business.company_name"></a></h5>
                                    <h5 ng-if="business.industry_name"><a href="<?php echo BASEURL ?>business-profile/dashboard/{{business.business_slug}}" ng-bind="business.industry_name"></a></h5>
                                    <h5 ng-if="!business.industry_name"><a href="<?php echo BASEURL ?>business-profile/dashboard/{{business.business_slug}}" ng-bind="business.other_industrial"></a></h5>
                                </div>
                            </div>
                        </div>
                        <div class="all-job-middle">
                            <ul class="search-detail">
                                <li ng-if="business.contact_website"><span class="img"><img class="pr10" ng-src="<?php echo base_url('assets/n-images/website.png') ?>"></span> <p class="detail-content"><a ng-href="{{business.contact_website}}" target="_self" ng-bind="business.contact_website"></a></p></li>
                                <li><span class="img"><img class="pr10" ng-src="<?php echo base_url('assets/n-images/location.png') ?>"></span> <p class="detail-content"><span ng-bind="business.city"></span><span ng-if="business.city">,(</span><span ng-bind="business.country">India</span><span ng-if="business.city">)</span></p></li>
                                <li ng-if="business.details"><span class="img"><img class="pr10" ng-src="<?php echo base_url('assets/n-images/exp.png') ?>"></span><p class="detail-content">{{business.details | limitTo:110}}...<a href="<?php echo BASEURL ?>business-profile/dashboard/{{business.business_slug}}"> Read more</a></p></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="right-part">
                    <div class="add-box">
                        <img src="<?php echo base_url('assets/n-images/add.jpg') ?>">
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
        
        <script>
                                    var base_url = '<?php echo base_url(); ?>';
                                    var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
                                    var title = '<?php echo $title; ?>';
                                    var header_all_profile = '<?php echo $header_all_profile; ?>';
                                    var category_id = '<?php echo $category_id; ?>';
                                    var q = '<?php echo $q; ?>';
                                    var l = '<?php echo $l; ?>';
                                    var app = angular.module('businessSearchListApp', ['ui.bootstrap']);
        </script>   
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/business-live/searchBusiness.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/business-live/search.js?ver=' . time()) ?>"></script>
    </body>
</html>