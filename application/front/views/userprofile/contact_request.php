<!DOCTYPE html>
<html lang="en" ng-app="contactRequestApp" ng-controller="contactRequestController">
    <head>
        <title ng-bind="title"></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/bootstrap.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css') ?>">

        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css') ?>">
    </head>
    <body class="">
        <?php echo $header_profile; ?>
        <div class="middle-section middle-section-banner">
            <div class="container pt20">
                <div class="custom-user-list">
                    <div class="list-box-custom">
                        <h3>Pending Contact Request</h3>
                        <div class="all-list">
                            <div class="no-data-box" ng-if="pending_contact_request_data.length == '0'">
                                <div class="no-data-content">
                                    <p><img src="<?php echo base_url('assets/img/No_Contact_Request.png') ?>"></p>
                                    <p class="pt20">No Pending Contact Request Available</p>
                                </div>
                            </div>
                            <ul id="contactlist">
                                <li ng-repeat="contact in pending_contact_request_data">
                                    <div class="list-box">
                                        <div class="profile-img">
                                            <a href="#">
                                                <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{contact.user_image}}" alt="{{contact.fullname}}" ng-if="contact.user_image != ''">
                                                <img ng-src="<?php echo NOIMAGE ?>" alt="{{contact.fullname}}" ng-if="contact.user_image == ''">
                                            </a>
                                        </div>
                                        <div class="profile-content">
                                            <a href="#">
                                                <div class="main_data_cq">   
                                                    <span title="{{contact.fullname}}" class="main_compny_name" ng-bind="contact.fullname | capitalize"></span>
                                                </div>
                                                <div class="main_data_cq">
                                                    <span class="dc_cl_m" title="{{contact.designation| capitalize}}" ng-if="contact.designation" ng-bind="contact.designation | capitalize"></span>
                                                    <span class="dc_cl_m" title="{{contact.degree| capitalize}}" ng-if="contact.degree" ng-bind="contact.degree | capitalize"></span>
                                                    <span class="dc_cl_m" title="Current Work" ng-if="contact.designation == '' && contact.degree == ''">CURRENT WORK</span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="fw">
                                            <p class="request-btn">
                                                <a href="javascript:void(0);" class="btn1 pull-left" ng-click="confirmContact(contact.from_id, $index)">
                                                    Confirm
                                                </a>
                                                <a href="javascript:void(0);" class="btn3 pull-right" ng-click="rejectContact(contact.from_id, $index)">
                                                    Decline
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="list-box-custom suggestion">
                        <h3>Suggestion</h3>
                        <div class="all-list">
                            <div class="no-data-box" ng-if="contactSuggetion.length == '0'">
                                <div class="no-data-content">
                                    <p><img src="<?php echo base_url('assets/img/No_Contact_Request.png') ?>"></p>
                                    <p class="pt20">No Suggestion Contact Request Available</p>
                                </div>
                            </div>
                            <ul id="contactlist">
                                <li ng-repeat="suggest in contactSuggetion">
                                    <div class="list-box">
                                        <div class="profile-img">
                                            <a href="#">
                                                <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{suggest.user_image}}" ng-if="suggest.user_image">
                                                <img ng-src="<?php echo NOIMAGE ?>" ng-if="!suggest.user_image">
                                            </a>
                                        </div>
                                        <div class="profile-content">
                                            <a href="#">
                                                <div class="main_data_cq">   
                                                    <span title="{{suggest.fullname| capitalize}}" class="main_compny_name" ng-bind="suggest.fullname | capitalize"></span>
                                                </div>
                                                <div class="main_data_cq">
                                                    <span class="dc_cl_m" title="Clothing" ng-if="suggest.title_name != ''">{{suggest.title_name| uppercase}}</span>
                                                    <span class="dc_cl_m" title="Clothing" ng-if="suggest.title_name == ''">{{suggest.degree_name| uppercase}}</span>
                                                    <span class="dc_cl_m" title="Clothing" ng-if="suggest.title_name == null && suggest.degree_name == null">CURRENT WORK</span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="fw" id="item-{{suggest.user_id}}">
                                            <p class="request-btn">
                                                <a href="javascript:void(0);" class="btn3" ng-click="addToContact(suggest.user_id, suggest);">
                                                    Add to contact
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="right-part">
                    <div class="request-noti">
                        <div class="right-title">
                            Contact Request Notifications
                        </div>
                        <div class="content custom-scroll">
                            <div class="no-data-box" ng-if="contactRequestNotification.length == '0'">
                                <div class="no-data-content">
                                    <p><img src="<?php echo base_url('assets/img/No_Contact_Request.png') ?>"></p>
                                    <p class="pt20">No Contact Request Notification Available</p>
                                </div>
                            </div>
                            <ul class="request-list">
                                <li ng-repeat="notification in contactRequestNotification">
                                    <a href=profiles/{{notification.user_slug}}>
                                        <div class="post-img">
                                            <img src="<?php echo USER_THUMB_UPLOAD_URL ?>{{notification.user_image}}" alt="{{notification.fullname}}" ng-if="notification.user_image">
                                                <div ng-if="!notification.user_image">{{notification.first_name| limitTo:1 | uppercase}}{{notification.last_name| limitTo:1 | uppercase}}</div>
                                        </div>
                                        <div class="request-detail">
                                            <h6 class="">
                                                <b ng-bind="notification.fullname | capitalize" ng-bind="notification.fullname | capitalize"></b> confirmed your contact request.
                                            </h6>
                                            <p>1 day ago</p>
                                        </div>
                                    </a>

                                        
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="add-box fw">
                        <div class="adv-main-view">
                            <img src="<?php echo base_url('assets/n-images/add.jpg'); ?>">
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>
        <script>
                                                    var base_url = '<?php echo base_url(); ?>';
                                                    var user_slug = '<?php echo $this->uri->segment(2); ?>';
                                                    var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
                                                    var item = '<?php echo $this->uri->segment(1); ?>';
                                                    var app = angular.module("contactRequestApp", ['ngRoute', 'ui.bootstrap', 'ngSanitize']);
        </script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/user/contact_request.js?ver=' . time()) ?>"></script>
    </body>
</html>