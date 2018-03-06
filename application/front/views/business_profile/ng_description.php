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
            [contenteditable=true]:empty:before{
                content: attr(placeholder);
                display: block;
                font-size: 14px; /* For Firefox */
                color:#616060;
            }
        </style>
    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push botton_footer" ng-app="descriptionApp" ng-controller="descriptionController">
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
                <?php } else {
                    ?>
                    <div class="user-midd-section" id="paddingtop_make_fixed">   
                    <?php }
                    ?>
                    <div class="common-form1">
                        <div class="col-md-3 col-sm-4"></div>
                        <?php
                        if ($busdata[0]['business_step'] == 4) {
                            ?>
                            <div class="col-md-6 col-sm-8"><h3>You are updating your Business Profile.</h3></div>
                        <?php } else {
                            ?>
                            <div class="col-md-6 col-sm-8"><h3>You are making your Business Profile.</h3></div>
                        <?php } ?>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3 col-sm-4">
                                <div class="left-side-bar">
                                    <ul class="left-form-each">
                                        <li class="custom-none"><a href="<?php echo base_url('business-profile/business-information-update'); ?>"><?php echo $this->lang->line("business_information"); ?></a></li>
                                        <li class="custom-none"><a href="<?php echo base_url('business-profile/contact-information'); ?>"><?php echo $this->lang->line("contact_information"); ?></a></li>
                                        <li class="custom-none active init"><a href="javascript:void(0);"><?php echo $this->lang->line("description"); ?></a></li>
                                        <?php if ($business_common_data[0]['business_step'] > '2' && $business_common_data[0]['business_step'] != '') { ?>    
                                            <li class="custom-none"><a href="<?php echo base_url('business-profile/image'); ?>"><?php echo $this->lang->line("business_images"); ?></a></li>
                                        <?php } else {
                                            ?>
                                            <li class="custom-none"><a href="javascript:void(0);"><?php echo $this->lang->line("business_images"); ?></a></li>
                                        <?php }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-8">
                                <div class="common-form common-form_border">
                                    <h3>
                                        Description
                                    </h3>
                                    <form name="businessdis" ng-submit="submitForm()" id="businessdis" class="clearfix">
                                        <fieldset>
                                            <label>Business type:<span style="color:red">*</span></label>
                                            <select name="business_type" ng-model="user.business_type" ng-change="busSelectCheck(this)" id="business_type" tabindex="1">
                                                <option ng-option value="" selected="selected">Select Business type</option>
                                                <?php foreach ($business_type as $key => $type) { ?>
                                                    <option ng-option value="<?php echo $type->type_id; ?>"><?php echo $type->business_name; ?></option>
                                                <?php } ?>
                                                <option ng-option value="0" id="busOption">Other</option>    
                                            </select>
                                            <span ng-show="errorBusinessType" class="error">{{errorBusinessType}}</span>
                                        </fieldset>  
                                        <fieldset>
                                            <label>Category:<span style="color:red">*</span></label>
                                            <select name="industriyal" ng-model="user.industriyal" ng-change="indSelectCheck(this)" id="industriyal" tabindex="2">
                                                <option ng-option value="" selected="selected">Select Industry type</option>
                                                <?php foreach ($category_list as $key => $category) { ?>
                                                    <option ng-option value="<?php echo $category->industry_id; ?>"><?php echo $category->industry_name; ?></option>
                                                <?php } ?>
                                                <option ng-option value="0" id="indOption">Other</option>
                                            </select>
                                            <span ng-show="errorCategory" class="error">{{errorCategory}}</span>
                                        </fieldset>  
                                        <div id="busDivCheck" ng-if="user.business_type == '0'">
                                            <fieldset class="half-width" id="other-business">
                                                <label> Other business type: <span style="color:red;" >*</span></label>
                                                <input type="text" name="bustype" ng-model="user.bustype"  tabindex="3"  id="bustype" value="<?php echo $other_business; ?>">
                                                <span ng-show="errorOtherBusinessType" class="error">{{errorOtherBusinessType}}</span>
                                            </fieldset>
                                        </div>
                                        <div id="indDivCheck" ng-if="user.industriyal == '0'">
                                            <fieldset class="half-width" id="other-category">
                                                <label> Other category:<span style="color:red;" >*</span></label>
                                                <input type="text" name="indtype" ng-model="user.indtype" id="indtype" tabindex="4"  value="<?php echo $other_industry; ?>">
                                                <span ng-show="errorOtherCategory" class="error">{{errorOtherCategory}}</span>
                                            </fieldset>
                                        </div>
                                        <fieldset class="full-width">
                                            <label>Details of your business:<span style="color:red">*</span></label>
                                            <textarea name="business_details" ng-model="user.business_details" id="business_details" rows="4" tabindex="5"  cols="50" placeholder="Enter business detail" style="resize: none;"></textarea>
                                            <span ng-show="errorBusinessDetails" class="error">{{errorBusinessDetails}}</span>
                                        </fieldset>
                                        <fieldset class="hs-submit full-width">
                                            <input type="submit"  id="next" name="next" value="Next" tabindex="6" >
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
        </script>
        <script>
                    // Defining angularjs application.
                    var descriptionApp = angular.module('descriptionApp', []);
                    // Controller function and passing $http service and $scope var.
                    descriptionApp.controller('descriptionController', function ($scope, $http) {
                        // create a blank object to handle form data.
                        $scope.user = {};

                        // calling our submit function.
                        $scope.submitForm = function () {
                            // Posting data to php file
                            $http({
                                method: 'POST',
                                url: base_url + 'business_profile_registration/ng_description_insert',
                                data: $scope.user, //forms user object
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                            })
                                    .success(function (data) {
                                        if (data.errors) {
                                            // Showing errors.
                                            $scope.errorBusinessType = data.errors.business_type;
                                            $scope.errorCategory = data.errors.industriyal;
                                            $scope.errorOtherBusinessType = data.errors.bustype;
                                            $scope.errorOtherCategory = data.errors.indtype;
                                            $scope.errorBusinessDetails = data.errors.business_details;
                                        } else {
                                            if (data.is_success == '1') {
                                                window.location.href = base_url + 'business-profile/signup/image';
                                            } else {
                                                return false;
                                            }
                                            //$scope.message = data.message;
                                        }
                                    });
                        };
                    });
        </script>
        <?php if (IS_BUSINESS_JS_MINIFY == '0') { ?>
                                        <!--        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/description.js?ver=' . time()); ?>"></script>
                                                <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>-->
        <?php } else { ?>
        <!--            <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/business-profile/description.min.js?ver=' . time()); ?>"></script>
                    <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js_min/webpage/business-profile/common.min.js?ver=' . time()); ?>"></script>-->
        <?php } ?>
    </body>
</html>

