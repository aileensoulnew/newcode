<!DOCTYPE html>
<html lang="en" ng-app="freeapplypostApp" ng-controller="freeapplypostController">
    <head>
        <title>Aileensoul</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css'); ?>">

        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css'); ?>">

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
                           
                            <li ng-repeat="category in freelancerCategory">
                               <label class=""><a href="<?php echo base_url('freelance-work/category/') ?>{{category.industry_slug}}"><span ng-bind="category.industry_name | capitalize"></span><span class="pull-right" ng-bind="'(' + category.count + ')'"></span></a></label>
                            </li>
                        </ul>
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
                        <h3>Recommended Projects</h3>
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
                        <img src="<?php echo base_url('assets/n-images/add.jpg?ver=' . time()) ?>">
                    </div>
                </div>

            </div>

        </div>
        <!--  poup modal  -->
        <div style="display:none;" class="modal fade" id="post-popup1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <div class="post-popup-box">
                        <form>
                            <div class="post-box">
                                <div class="post-img">
                                    <img src="<?php echo base_url('assets/n-images/user-pic.jpg?ver=' . time()) ?>">
                                </div>
                                <div class="post-text">
                                    <textarea class="title-text-area" placeholder="Post Opportunity"></textarea>
                                </div>
                                <div class="all-upload">
                                    <label for="file-1">
                                        <i class="fa fa-camera upload_icon"><span class="upload_span_icon"> Photo </span></i>
                                        <i class="fa fa-video-camera upload_icon"><span class="upload_span_icon"> Video</span>  </i> 
                                        <i class="fa fa-music upload_icon"> <span class="upload_span_icon">  Audio </span> </i>
                                        <i class="fa fa-file-pdf-o upload_icon"><span class="upload_span_icon"> PDF </span></i>
                                    </label>
                                </div>
                                <div class="post-box-bottom">
                                    <ul>
                                        <li>
                                            <a href="" data-target="#post-popup" data-toggle="modal">
                                                <img src="<?php echo base_url('assets/n-images/post-op.png?ver=' . time()) ?>"><span>Post Opportunity</span>
                                            </a>
                                        </li>
                                        <li class="pl15">
                                            <a href="article.html">
                                                <img src="<?php echo base_url('assets/n-images/article.png?ver=' . time()) ?>"><span>Post Article</span>
                                            </a>
                                        </li>
                                        <li class="pl15">
                                            <a href="" data-target="#ask-question" data-toggle="modal">
                                                <img src="<?php echo base_url('assets/n-images/ask-qustion.png?ver=' . time()) ?>"><span>Ask Quastion</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <p class="pull-right">
                                        <button type="submit" class="btn1" value="Submit">Post</button>
                                    </p>
                                </div>

                            </div>


                        </form>
                    </div>



                </div>
            </div>

        </div>
        <div style="display:none;" class="modal fade" id="post-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <div class="post-popup-box">
                        <form>
                            <div class="post-box">
                                <div class="post-img">
                                    <img src="<?php echo base_url('assets/n-images/user-pic.jpg?ver=' . time()) ?>">
                                </div>
                                <div class="post-text">
                                    <textarea class="title-text-area" placeholder="Post Opportunity"></textarea>
                                </div>
                                <div class="all-upload">
                                    <label for="file-1">
                                        <i class="fa fa-camera upload_icon"><span class="upload_span_icon"> Photo </span></i>
                                        <i class="fa fa-video-camera upload_icon"><span class="upload_span_icon"> Video</span>  </i> 
                                        <i class="fa fa-music upload_icon"> <span class="upload_span_icon">  Audio </span> </i>
                                        <i class="fa fa-file-pdf-o upload_icon"><span class="upload_span_icon"> PDF </span></i>
                                    </label>
                                </div>

                            </div>
                            <div class="post-field">

                                <div id="content" class="form-group">
                                    <label>FOR WHOM THIS OPPORTUNITY ?<span class="pull-right"><img src="<?php echo base_url('assets/n-images/tooltip.png?ver=' . time()) ?>"></span></label>
                                    <textarea rows="1" max-rows="5" placeholder="Ex:Seeking Opportunity, CEO, Enterpreneur, Founder, Singer, Photographer, PHP Developer, HR, BDE, CA, Doctor, Freelancer.." cols="10" style="resize:none"></textarea>

                                </div>
                                <div class="form-group">
                                    <label>WHICH LOCATION?<span class="pull-right"><img src="<?php echo base_url('assets/n-images/tooltip.png?ver=' . time()) ?>"></span></label>
                                    <textarea type="text" class="" placeholder="Ex:Mumbai, Delhi, New south wels, London, New York, Captown, Sydeny, Shanghai, Moscow, Paris, Tokyo.. "></textarea>

                                </div>
                                <div class="form-group">
                                    <label>What is your field?<span class="pull-right"><img src="<?php echo base_url('assets/n-images/tooltip.png?ver=' . time()) ?>"></span></label>
                                    <select>
                                        <option>What is your field</option>
                                        <option>IT</option>
                                        <option>Teacher</option>
                                        <option>Sports</option>
                                    </select>
                                </div>





                            </div>
                            <div class="text-right fw pt10 pb20 pr15">
                                <button type="submit" class="btn1"  value="Submit">Post</button> 
                            </div>
                        </form>
                    </div>



                </div>
            </div>

        </div>
        <div style="display:none;" class="modal fade" id="ask-question" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <div class="post-popup-box">
                        <form>
                            <div class="post-box">
                                <div class="post-img">
                                    <img src="<?php echo base_url('assets/n-images/user-pic.jpg?ver=' . time()) ?>">
                                </div>
                                <div class="post-text">
                                    <textarea class="title-text-area" placeholder="Ask Quastion"></textarea>
                                </div>
                                <div class="all-upload">
                                    <label for="file-1">
                                        <i class="fa fa-camera upload_icon"><span class="upload_span_icon"> Add Screenshot </span></i>
                                        <i class="fa fa fa-link upload_icon"><span class="upload_span_icon"> Add Link</span>  </i> 

                                    </label>
                                </div>

                            </div>
                            <div class="post-field">

                                <div class="form-group">
                                    <label>Add Description<span class="pull-right"><img src="<?php echo base_url('assets/n-images/tooltip.png?ver=' . time()) ?>"></span></label>
                                    <textarea rows="1" max-rows="5" placeholder="Add Description" cols="10" style="resize:none"></textarea>

                                </div>
                                <div class="form-group">
                                    <label>Related Categories<span class="pull-right"><img src="<?php echo base_url('assets/n-images/tooltip.png?ver=' . time()) ?>"></span></label>
                                    <input type="text" class="" placeholder="Related Categories">

                                </div>
                                <div class="form-group">
                                    <label>From which field the Question asked?<span class="pull-right"><img src="<?php echo base_url('assets/n-images/tooltip.png?ver=' . time()) ?>"></span></label>
                                    <select>
                                        <option>What is your field</option>
                                        <option>IT</option>
                                        <option>Teacher</option>
                                        <option>Sports</option>
                                    </select>
                                </div>





                            </div>
                            <div class="text-right fw pt10 pb20 pr15">
                                <button type="submit" class="btn1"  value="Submit">Post</button> 
                            </div>
                        </form>
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
                                jQuery(document).ready(function ($) {
                                var owl = $('.owl-carousel');
                                owl.on('initialize.owl.carousel initialized.owl.carousel ' +
                                        'initialize.owl.carousel initialize.owl.carousel ' +
                                        'resize.owl.carousel resized.owl.carousel ' +
                                        'refresh.owl.carousel refreshed.owl.carousel ' +
                                        'update.owl.carousel updated.owl.carousel ' +
                                        'drag.owl.carousel dragged.owl.carousel ' +
                                        'translate.owl.carousel translated.owl.carousel ' +
                                        'to.owl.carousel changed.owl.carousel',
                                        function (e) {
                                        $('.' + e.type)
                                                .removeClass('secondary')
                                                .addClass('success');
                                        window.setTimeout(function () {
                                        $('.' + e.type)
                                                .removeClass('success')
                                                .addClass('secondary');
                                        }, 500);
                                        });
                                owl.owlCarousel({
                                loop: true,
                                        nav: true,
                                        lazyLoad: true,
                                        margin: 0,
                                        video: true,
                                        responsive: {
                                        0: {
                                        items: 1
                                        },
                                                600: {
                                                items: 2
                                                },
                                                960: {
                                                items: 2,
                                                },
                                                1200: {
                                                items: 2
                                                }
                                        }
                                });
                                });
                                // mcustom scroll bar
                                (function ($) {
                                $(window).on("load", function () {

                                $(".custom-scroll").mCustomScrollbar({
                                autoHideScrollbar: true,
                                        theme: "minimal"
                                });
                                });
                                })(jQuery);
                                $('#content').on('change keyup keydown paste cut', 'textarea', function () {
                                $(this).height(0).height(this.scrollHeight);
                                }).find('textarea').change();
                                var base_url = '<?php echo base_url(); ?>';
                                var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
                                var title = '<?php echo $title; ?>';
                                var header_all_profile = '<?php echo $header_all_profile; ?>';
                                var q = '';
                                var l = '';
                                var f = '';
                                var p = '';
                                var app = angular.module('freeapplypostApp', ['ui.bootstrap']);
        </script>

        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>  
        <script src="<?php echo base_url('assets/js/webpage/freelancer-apply-live/searchfreelancerApply.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/freelancer-apply-live/index.js?ver=' . time()) ?>"></script>
    </body>
</html>