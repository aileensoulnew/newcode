<!DOCTYPE html>
<html lang="en" ng-app="freelancerapplySearchListApp" ng-controller="freelancerapplySearchListController">
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
            <div class="container">
                <div class="left-part">
                     <div class="left-search-box">
                        <div class="">
                            <h3>Top Categories</h3>
                        </div>
                        <ul class="search-listing">
                            <li>
                                <label class="control control--checkbox">IT<span class="pull-right">(50)</span>
                                    <input type="checkbox"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">IT<span class="pull-right">(50)</span>
                                    <input type="checkbox"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">IT<span class="pull-right">(50)</span>
                                    <input type="checkbox"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">IT<span class="pull-right">(50)</span>
                                    <input type="checkbox"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">IT<span class="pull-right">(50)</span>
                                    <input type="checkbox"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">IT<span class="pull-right">(50)</span>
                                    <input type="checkbox"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">IT<span class="pull-right">(50)</span>
                                    <input type="checkbox"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">IT<span class="pull-right">(50)</span>
                                    <input type="checkbox"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">IT<span class="pull-right">(50)</span>
                                    <input type="checkbox"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">IT<span class="pull-right">(50)</span>
                                    <input type="checkbox"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">IT<span class="pull-right">(50)</span>
                                    <input type="checkbox"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>

                        </ul>
                        <p class="text-right p10"><a href="#">More Categories</a></p>
                    </div>
                    
                    <div class="left-search-box work-type">
                        <div class="">
                            <h3>Work Type</h3>
                        </div>
                        <ul class="search-listing pb10 fw">
                            <li>
                                <label class="control control--checkbox">Hourly
                                    <input type="checkbox"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">Fixed
                                    <input type="checkbox"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                        </ul>

                    </div>
                    
                     <div class="left-search-box">
                        <div class="">
                            <h3>Posting Period</h3>
                        </div>
                        <ul class="search-listing">
                            <li>
                                <label class="control control--checkbox">Today
                                    <input type="checkbox"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">Last 7 day
                                    <input type="checkbox"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">Last 15 day
                                    <input type="checkbox"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">Last 45 day
                                    <input type="checkbox"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">More than 45 days
                                    <input type="checkbox"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>


                        </ul>

                    </div>
                    
                      <div class="left-search-box">
                        <div class="">
                            <h3>Required Experience</h3>
                        </div>
                        <ul class="search-listing">
                            <li>
                                <label class="control control--radio">0 to 1 year
                                    <input type="radio" name="radio" checked="checked"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--radio">1 to 2 year
                                    <input type="radio" name="radio" checked="checked"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--radio">2 to 3 year
                                    <input type="radio" name="radio" checked="checked"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--radio">3 to 4 year
                                    <input type="radio" name="radio" checked="checked"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--radio">4 to 5 year
                                    <input type="radio" name="radio" checked="checked"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--radio">More than 5 year
                                    <input type="radio" name="radio" checked="checked"/>
                                    <div class="control__indicator"></div>
                                </label>
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
                    <div class="all-job-box freelance-recommended-post" ng-repeat="applypost in freepostapply">
                        <div class="all-job-top">
                            <div class="job-top-detail">
                                <h5><a href="#">{{applypost.post_name}}(project title) <span>(6 days left)</span></a></h5>
                                <p><a href="#">Vivek Panday</a></p>
                                <p>Budget : {{applypost.post_rate}} {{applypost.post_currency}} (hourly/fixed)</p>
                            </div>
                        </div>
                        <div class="all-job-middle">
                            <p class="pb5">
                                <span class="location">
                                    <span><img class="pr5" src="<?php echo base_url('assets/n-images/location.png?ver=' . time()) ?>">{{applypost.city}},({{applypost.country}})</span>
                                </span>
                                <span class="exp">
                                    <span><img class="pr5" src="<?php echo base_url('assets/n-images/exp.png?ver=' . time()) ?>">Skils: {{applypost.post_skill}} etc..</span>
                                </span>
                            </p>
                            <p>
                                {{applypost.post_description}} ...<a href="#">Read more</a>
                            </p>
                            <p>
                                Categories : <span>It software development</span>
                            </p>

                        </div>
                        <div class="all-job-bottom">
                            <span>Applied Persons:  {{applypost.ShortListedCount}}</span>
                            <span class="pl20">Shortlisted Persons:{{applypost.AppliedCount}}</span>
                            <p class="pull-right">
                                <a href="#" class="btn4">Save</a>
                                <a href="#" class="btn4">Apply</a>
                            </p>

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
                                    var q = '<?php echo $q; ?>';
                                    var l = '<?php echo $l; ?>';
                                    var f = '<?php echo $f; ?>';
                                    var p = '<?php echo $p; ?>';
                                    var app = angular.module('freelancerapplySearchListApp', ['ui.bootstrap']);
        </script>   
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/freelancer-apply-live/searchfreelancerApply.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/freelancer-apply-live/search.js?ver=' . time()) ?>"></script>
    </body>
</html>