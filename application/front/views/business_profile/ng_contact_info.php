<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head_profile_reg; ?>  
        <?php
        if (IS_BUSINESS_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/business.css?ver=' . time()); ?>">
            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/business.css?ver=' . time()); ?>">
        <?php } ?>
        <style type="text/css">
            span.error{
                background: none;
                color: red !important;
                padding: 0px 10px !important;
                position: absolute;
                right: 8px;
                z-index: 8;
                line-height: 15px;
                padding-right: 0px!important;
                font-size: 11px!important;
            }
        </style>
    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push botton_footer" ng-app="contactInfoApp" ng-controller="contactInfoController">
        <?php echo $header; ?>
        <?php if ($business_common_data[0]['business_step'] == 4) { ?>
            <?php echo $business_header2_border; ?>
        <?php } ?>
        <section>
            <?php
            $userid = $this->session->userdata('aileenuser');

            $contition_array = array('user_id' => $userid, 'status' => '1');
            $busdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if ($busdata[0]['business_step'] == 4) {
                ?>
                <div class="user-midd-section" id="paddingtop_fixed">
                <?php } else { ?>
                    <div class="user-midd-section" id="paddingtop_make_fixed">
                    <?php } ?>
                    <div class="common-form1">
                        <div class="col-md-3 col-sm-4"></div>
                        <?php if ($busdata[0]['business_step'] == 4) { ?>
                            <div class="col-md-6 col-sm-8"><h3>You are updating your Business Profile.</h3></div>
                        <?php } else { ?>
                            <div class="col-md-6 col-sm-8"><h3>You are making your Business Profile.</h3></div>
                        <?php } ?>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3 col-sm-4">
                                <div class="left-side-bar">
                                    <ul class="left-form-each">
                                        <li class="custom-none"><a href="<?php echo base_url('business-profile/business-information-update'); ?>"><?php echo $this->lang->line("business_information"); ?></a></li>
                                        <li class="custom-none active init"><a href="javascript:void(0);"><?php echo $this->lang->line("contact_information"); ?></a></li>
                                        <?php if ($business_common_data[0]['business_step'] > '1' && $business_common_data[0]['business_step'] != '') { ?>
                                            <li class="custom-none"><a href="<?php echo base_url('business-profile/description'); ?>"><?php echo $this->lang->line("description"); ?></a></li>
                                        <?php } else { ?>
                                            <li class="custom-none"><a href="javascript:void(0);"><?php echo $this->lang->line("description"); ?></a></li>
                                        <?php } ?>
                                        <?php if ($business_common_data[0]['business_step'] > '2' && $business_common_data[0]['business_step'] != '') { ?>    
                                            <li class="custom-none"><a href="<?php echo base_url('business-profile/image'); ?>"><?php echo $this->lang->line("business_images"); ?></a></li>
                                        <?php } else { ?>
                                            <li class="custom-none"><a href="javascript:void(0);"><?php echo $this->lang->line("business_images"); ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>

                            <!-- middle section start -->

                            <div class="col-md-6 col-sm-8">
                                <div class="common-form common-form_border">
                                    <h3>
                                        Contact Information
                                    </h3>
                                    <form name="contactinfo" ng-submit="submitForm()" id="contactinfo" class="clearfix">
                                        <fieldset>
                                            <label>Contact person:<span style="color:red">*</span></label>
                                            <input name="contactname" ng-model="user.contactname" tabindex="1" autofocus type="text" id="contactname" placeholder="Enter contact name" value=""/>
                                            <span ng-show="errorContactName" class="error">{{errorContactName}}</span>
                                        </fieldset>
                                        <fieldset>
                                            <label>Contact mobile:<span style="color:red">*</span></label>
                                            <input name="contactmobile" ng-model="user.contactmobile" tabindex="2" autofocus type="text" id="contactmobile" placeholder="Enter contact mobile" value=""/>
                                            <span ng-show="errorContactMobile" class="error">{{errorContactMobile}}</span>
                                        </fieldset>
                                        <fieldset>
                                            <label>Contact email:<span style="color:red">*</span></label>
                                            <input name="email" ng-model="user.email" tabindex="3" autofocus type="text" id="email" placeholder="Enter contact email" value=""/>
                                            <span ng-show="errorEmail" class="error">{{errorEmail}}</span>                                                                        
                                        </fieldset>
                                        <fieldset>
                                            <label>Contact website<span class="optional">(optional)</span>:</label>
                                            <input name="contactwebsite" ng-model="user.contactwebsite" tabindex="4" autofocus type="text" id="contactwebsite" placeholder="Enter contact email" value=""/>
                                            <span class="website_hint" style="font-size: 13px; color: #1b8ab9;">Note : <i>Enter website url with http or https</i></span>                                 
                                            <span ng-show="errorContactWebsite" class="error">{{errorContactWebsite}}</span>                      
                                        </fieldset>
                                        <fieldset class="hs-submit full-width">
                                            <input type="submit"  id="next" name="next" tabindex="5"  value="Next">
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <?php echo $login_footer ?>
        <?php echo $footer; ?>
        <script>
                    var base_url = '<?php echo base_url(); ?>';
                    var slug = '<?php echo $slugid; ?>';
                    var get_csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
                    var get_csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
        </script>
        <script>
                    // Defining angularjs application.
                    var contactInfoApp = angular.module('contactInfoApp', []);
                    // Controller function and passing $http service and $scope var.
                    contactInfoApp.controller('contactInfoController', function ($scope, $http) {
                        // create a blank object to handle form data.
                        $scope.user = {};

                        // calling our submit function.
                        $scope.submitForm = function () {
                            // Posting data to php file
                            $http({
                                method: 'POST',
                                url: base_url + 'business_profile_registration/ng_contact_info_insert',
                                data: $scope.user, //forms user object
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                            })
                                    .success(function (data) {
                                        if (data.errors) {
                                            // Showing errors.
                                            $scope.errorContactName = data.errors.contactname;
                                            $scope.errorContactMobile = data.errors.contactmobile;
                                            $scope.errorEmail = data.errors.email;
                                            $scope.errorCity = data.errors.city;
                                            $scope.errorContactWebsite = data.errors.contactwebsite;
                                        } else {
                                            if(data.is_success == '1'){
                                                window.location.href = base_url + 'business-profile/signup/description';
                                            }else{
                                                return false;
                                            }
                                            //$scope.message = data.message;
                                        }
                                    });
                        };
                    });
        </script>
        <?php if (IS_BUSINESS_JS_MINIFY == '0') { ?>
<!--            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/contact_info.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>-->
        <?php } else { ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/business-profile/contact_info.min.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js_min/webpage/business-profile/common.min.js?ver=' . time()); ?>"></script>
        <?php } ?>
    </body>
</html>
