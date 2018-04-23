<!DOCTYPE html>
<html lang="en" ng-app="jobSkillApp" ng-controller="jobSkillController">
    <head>
        <title ng-bind="title"></title>
        <meta name="robots" content="noindex, nofollow">
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
            <?php echo $search_banner ?>
            <div class="container">
                <div class="left-part">
                    <form name="job-cat-filter" id="job-cat-filter">
                        <div class="left-search-box list-type-bullet">
                            <div class="">
                                <h3>Top Skills</h3>
                            </div>
                            <ul class="search-listing custom-scroll">
                                <li ng-repeat="skill in jobSkill">
                                    <label class=""><a href="<?php echo base_url('job/skill/') ?>{{skill.skill_slug}}"><span ng-bind="skill.skill | capitalize"></span></a></label>
                                </li>
                                <input type="hidden" ng-model="skills" name="skill[]" id="filter-skill-id" value="">
                            </ul>
                        </div>
                        <div class="left-search-box">
                            <div class="">
                                <h3>Top Categories</h3>
                            </div>
                            <ul class="search-listing custom-scroll">
                                <li ng-repeat="category in jobCategory">
                                    <label class="control control--checkbox"><span ng-bind="category.industry_name | capitalize"></span>
                                        <input type="checkbox" ng-model="categories" name="category[]" ng-value="{{category.industry_id}}" ng-change="applyJobFilter()"/>
                                        <div class="control__indicator"></div>
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="left-search-box">
                            <div class="">
                                <h3>Top Cities</h3>
                            </div>
                            <ul class="search-listing custom-scroll">
                                <li ng-repeat="city in jobCity">
                                    <label class="control control--checkbox"><span ng-bind="city.city_name | capitalize"></span>
                                        <input type="checkbox" ng-model="location" name="location[]" ng-value="{{city.city_id}}" ng-change="applyJobFilter()"/>
                                        <div class="control__indicator"></div>
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="left-search-box">
                            <div class="">
                                <h3>Top Company</h3>
                            </div>
                            <ul class="search-listing custom-scroll">
                                <li ng-repeat="company in jobCompany">
                                    <label class="control control--checkbox"><span ng-bind="company.company_name | capitalize"></span>
                                        <input type="checkbox" ng-model="companies" name="company[]" ng-value="{{company.user_id}}" ng-change="applyJobFilter()"/>
                                        <div class="control__indicator"></div>
                                    </label>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="left-search-box">
                        <div class="accordion" id="accordion2">
                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <h3><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">Posting Period</a></h3>
                                </div>
                                <div id="collapseOne" class="accordion-body collapse">
                                    <ul class="search-listing">
                                        <li>
                                            <label class="control control--checkbox">Today
                                                <input type="checkbox" name="posting_period[]" value="1"/>
                                                <div class="control__indicator"></div>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="control control--checkbox">Last 7 Days
                                                <input type="checkbox" name="posting_period[]" value="2"/>
                                                <div class="control__indicator"></div>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="control control--checkbox">Last 15 Days
                                                <input type="checkbox" name="posting_period[]" value="3"/>
                                                <div class="control__indicator"></div>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="control control--checkbox">Last 45 Days
                                                <input type="checkbox" name="posting_period[]" value="4"/>
                                                <div class="control__indicator"></div>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="control control--checkbox">More than 45 Days
                                                <input type="checkbox" name="posting_period[]" value="5"/>
                                                <div class="control__indicator"></div>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="left-search-box">
                        <div class="accordion" id="accordion3">
                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <h3><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapsetwo">Experience</a></h3>
                                </div>
                                <div id="collapsetwo" class="accordion-body collapse">
                                    <div class="accordion-inner">
                                        <ul class="search-listing">
                                            <li>
                                                <label class="control control--checkbox">0 to 1 year
                                                    <input type="checkbox" name="experience[]" value="1"/>
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="control control--checkbox">1 to 2 year
                                                    <input type="checkbox" name="experience[]" value="2"/>
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="control control--checkbox">2 to 3 year
                                                    <input type="checkbox" name="experience[]" value="3"/>
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="control control--checkbox">3 to 4 year
                                                    <input type="checkbox" name="experience[]" value="4"/>
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="control control--checkbox">4 to 5 year
                                                    <input type="checkbox" name="experience[]" value="5"/>
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="control control--checkbox">More than 5 year
                                                    <input type="checkbox" name="experience[]" value="6"/>
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    </form>
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
                        <h3>Latest Job</h3>
                    </div>
                    <div class="all-job-box" ng-repeat="job in latestJob">
                        <div class="all-job-top">
                            <div class="post-img">
                                <a href="#" ng-if="job.comp_logo"><img src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL ?>{{job.comp_logo}}"></a>
                                <a href="#" ng-if="!job.comp_logo"><img src="<?php echo base_url('assets/n-images/commen-img.png') ?>"></a>
                            </div>
                            <div class="job-top-detail">
                                <h5><a href="#" ng-if="job.string_post_name" ng-bind="job.string_post_name"></a></h5>
                                <h5><a href="#" ng-if="!job.string_post_name" ng-bind="job.post_name"></a></h5>
                                <p><a href="#" ng-bind="job.re_comp_name"></a></p>
                                <p><a href="#" ng-bind="job.fullname"></a></p>
                            </div>
                        </div>
                        <div class="all-job-middle">
                            <p class="pb5">
                                <span class="location">
                                    <span><img class="pr5" src="<?php echo base_url('assets/n-images/location.png') ?>">{{job.city_name}},({{job.country_name}})</span>
                                </span>
                                <span class="exp">
                                    <span><img class="pr5" src="<?php echo base_url('assets/n-images/exp.png') ?>">{{job.min_year}} year - {{job.max_year}} year <span ng-if="job.fresher == '1'">(freshers can also apply)</span></span>
                                </span>
                            </p>
                            <p ng-bind="(job.post_description | limitTo:175) + '.....'"></p>

                        </div>
                        <div class="all-job-bottom">
                            <span class="job-post-date"><b>Posted on:</b><span ng-bind="job.created_date"></span></span>
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
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script>
                                var base_url = '<?php echo base_url(); ?>';
                                var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
                                var title = '<?php echo $title; ?>';
                                var header_all_profile = '<?php echo $header_all_profile; ?>';
                                var q = '';
                                var l = '';
                                var skill_id = '<?php echo $skill_id ?>';
                                var app = angular.module('jobSkillApp', ['ui.bootstrap']);
        </script>               
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/job-live/searchJob.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/job-live/skill.js?ver=' . time()) ?>"></script>
    </body>
</html>