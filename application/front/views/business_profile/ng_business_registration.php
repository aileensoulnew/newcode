<!DOCTYPE html>
<html ng-app="busRegApp" ng-controller="busRegController">
    <head>
        <title ng-bind="title"></title>
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
            .tabs-left > .nav-tabs {
                border-bottom: 0;
            }

            .tab-content > .tab-pane,
            .pill-content > .pill-pane {
                display: none;
            }

            .tab-content > .active,
            .pill-content > .active {
                display: block;
            }

            .tabs-left > .nav-tabs > li {
                float: none;
            }
            .form_submit{
                opacity: 0.5 !important;
                pointer-events: none !important;
            }
        </style>
    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push reg-form botton_footer">
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
                ?> <div class="user-midd-section" id="paddingtop_fixed">
            <?php } else { ?>
                    <div class="user-midd-section" id="paddingtop_make_fixed">
                    <?php } ?>
                    <div class="common-form1">
                        <div class="col-md-3 col-sm-4"></div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 fw">
                                <div class="all-edit-profile-box business-profile">
                                    <div class="all-edit-tab">
                                        <div class="edit-progress-box">
                                            <div class="progress-line"></div>
                                            <div class="progress-line-filled"></div>
                                        </div>
                                        <ul class="left-form-each-ul">
                                            <input ng-model="busRegStep" type="hidden" value="" id="busRegStep">
                                            <li id="left-form-each-li-1">
                                                <a href="#business_information" ng-click="tab_active(1)" data-toggle="tab">
                                                    <span class="edit-pro-box"><img src="<?php echo base_url('assets/img/basic-info.png'); ?>" alt="Business Information"></span><span class="edit-form-name">Business Information</span>
                                                </a>
                                            </li>
                                            <?php if ($business_common_data[0]['business_step'] >= '1' && $business_common_data[0]['business_step'] != '') { ?>
                                                <li id="left-form-each-li-2">
                                                    <a href="#contact_information" ng-click="tab_active(2);" data-toggle="tab">
                                                        <span class="edit-pro-box"><img src="<?php echo base_url('assets/img/contact-info.png'); ?>" alt="Contact Information"></span><span class="edit-form-name">Contact Information</span>
                                                    </a>
                                                </li>
                                            <?php } else { ?>
                                                <li id="left-form-each-li-2"><a href="javascript:void(0);">
                                                        <span class="edit-pro-box"><img src="<?php echo base_url('assets/img/contact-info.png'); ?>" alt="Contact Information"></span><span class="edit-form-name">Contact Information</span>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <?php if ($business_common_data[0]['business_step'] > '1' && $business_common_data[0]['business_step'] != '') { ?>
                                                <li id="left-form-each-li-3">
                                                    <a href="#description" ng-click="tab_active(3)" data-toggle="tab">
                                                        <span class="edit-pro-box"><img src="<?php echo base_url('assets/img/discription.png'); ?>" alt="Description"></span><span class="edit-form-name">Description</span>
                                                    </a>
                                                </li>
                                            <?php } else { ?>
                                                <li id="left-form-each-li-3">
                                                    <a href="javascript:void(0);">
                                                        <span class="edit-pro-box"><img src="<?php echo base_url('assets/img/discription.png'); ?>" alt="Description"></span><span class="edit-form-name">Description</span>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <?php if ($business_common_data[0]['business_step'] > '2' && $business_common_data[0]['business_step'] != '') { ?>    
                                                <li id="left-form-each-li-4">
                                                    <a href="#business_image" ng-click="tab_active(4)" data-toggle="tab">
                                                        <span class="edit-pro-box"><img src="<?php echo base_url('assets/img/upload-img.png'); ?>" alt="Business Images"></span><span class="edit-form-name">Business Images</span>
                                                    </a>
                                                </li>
                                            <?php } else { ?>
                                                <li id="left-form-each-li-4">
                                                    <a href="javascript:void(0);">
                                                        <span class="edit-pro-box"><img src="<?php echo base_url('assets/img/upload-img.png'); ?>" alt="Business Images"></span><span class="edit-form-name">Business Images</span>
                                                    </a>
                                                </li>
                                            <?php } ?> 
                                        </ul>
                                    </div>
                                    <div class="all-edit-form">
                                        <div class="common-form common-form_border">
                                            <div class="tab-content">
                                                <div class="tab-pane" id="business_information">                
                                                    <div class="">
                                                        <h3>
                                                            <?php echo $this->lang->line("business_information"); ?>
                                                        </h3>
                                                        <form name="businessinfo" id="businessinfo" class="clearfix" ng-submit="submitbusinessinfoForm()" ng-validate="busInfoValidate">
                                                            <fieldset class="full-width ">
                                                                <label>Company name:<span style="color:red">*</span></label>
                                                                <input name="companyname"  ng-model="user.companyname" tabindex="1" autofocus type="text" id="companyname" placeholder="Enter company name" value="" />
                                                                <span ng-show="errorCompanyName" class="error">{{errorCompanyName}}</span>
                                                            </fieldset>
                                                            <fieldset>
                                                                <label>Country:<span style="color:red">*</span></label>
                                                                <select name="country" ng-model="user.country_id" ng-change="onCountryChange()" id="country" tabindex="2">
                                                                    <option value="" selected="selected">Country</option>
                                                                    <option data-ng-repeat='countryItem in countryList' value='{{countryItem.country_id}}'>{{countryItem.country_name}}</option>             
                                                                </select>
                                                                <span ng-show="errorCountry" class="error">{{errorCountry}}</span>
                                                            </fieldset>
                                                            <fieldset>
                                                                <label>State:<span style="color:red">*</span></label>
                                                                <select name="state" ng-model="user.state_id" ng-change="onStateChange()" id="state" tabindex="3" ng-init="user.state_id = stateList[0].state_id">
                                                                    <option value="">Select State</option>
                                                                    <option data-ng-repeat='stateItem in stateList' value='{{stateItem.state_id}}' ng-selected="user.state_id == stateItem.state_id">{{stateItem.state_name}}</option>             
                                                                </select>
                                                                <span ng-show="errorState" class="error">{{errorState}}</span>
                                                            </fieldset>
                                                            <fieldset>
                                                                <label> City<span class="optional">(optional)</span>:</label>
                                                                <select name="city" ng-model="user.city_id" id="city" tabindex="4">
                                                                    <option value="">Select City</option>
                                                                    <option data-ng-repeat='cityItem in cityList' value='{{cityItem.city_id}}'>{{cityItem.city_name}}</option>             
                                                                </select>
                                                                <span ng-show="errorCity" class="error">{{errorCity}}</span>
                                                            </fieldset>
                                                            <fieldset>
                                                                <label>Pincode<span class="optional">(optional)</span>:</label>
                                                                <input name="pincode" ng-model="user.pincode" tabindex="5"   type="text" id="pincode" placeholder="Enter pincode" value="">
                                                                <span ng-show="errorPincode" class="error">{{errorPincode}}</span>
                                                            </fieldset>
                                                            <fieldset class="full-width ">
                                                                <label>Postal address:<span style="color:red">*</span></label>
                                                                <input name="business_address" ng-model="user.business_address" tabindex="6" autofocus type="text" id="business_address" placeholder="Enter address" style="resize: none;" value=""/>
                                                                <span ng-show="errorPostalAddress" class="error">{{errorPostalAddress}}</span>                                                                        
                                                            </fieldset>
                                                            <input type="hidden" name="busreg_step" ng-model="user.busreg_step" id="busreg_step" tabindex="4"  value="">
                                                            <fieldset class="hs-submit full-width" style="position: relative;">
                                                                <input type="submit"  id="next" name="next" tabindex="7" value="Next" >
                                                                <div class="loader-cust" ng-show="loader_show"> </div>
                                                            </fieldset>
                                                        </form>
                                                    </div>
                                                </div> 
                                                <div class="tab-pane" id="contact_information"> 
                                                    <div class="">
                                                        <h3>
                                                            Contact Information
                                                        </h3>
                                                        <form name="contactinfo" ng-submit="submitcontactinfoForm()" id="contactinfo" class="clearfix" ng-validate="conInfoValidate">
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
                                                            <fieldset class="vali_er">
                                                                <label>Contact email:<span style="color:red">*</span></label>
                                                                <input name="email" ng-model="user.email" tabindex="3" autofocus type="text" id="email" placeholder="Enter contact email" value=""/>
                                                                 <span class="email_note"><b>Note:-</b> Related notification email will be send on provided email address kindly use regular  email address.<div></div></span>
                                                                <span ng-show="errorEmail" class="error">{{errorEmail}}</span>                                                                        
                                                            </fieldset>
                                                            <fieldset class="vali_er">
                                                                <label>Contact website<span class="optional">(optional)</span>:</label>
                                                                <input name="contactwebsite" ng-model="user.contactwebsite" tabindex="4" autofocus type="url" id="contactwebsite" placeholder="Enter contact website" value=""/>
                                                                <span class="website_hint" style="font-size: 13px; color: #1b8ab9;">Note : <i>Enter website url with http or https</i></span>                                 
                                                                <span ng-show="errorContactWebsite" class="error">{{errorContactWebsite}}</span>                      
                                                            </fieldset>
                                                            <input type="hidden" name="busreg_step" ng-model="user.busreg_step" id="busreg_step" tabindex="4"  value="">
                                                            <fieldset class="hs-submit full-width" style="position: relative;">
                                                                <input type="submit"  id="next" name="next" tabindex="5"  value="Next">
                                                                <div class="loader-cust" ng-show="loader_show"> </div>
                                                            </fieldset>
                                                        </form>
                                                    </div>
                                                </div>

                                                <div class="tab-pane" id="description"> 
                                                    <div class="">
                                                        <h3>
                                                            Description
                                                        </h3>
                                                        <form name="businessdis" ng-submit="submitdescriptionForm()" id="businessdis" class="clearfix" ng-validate="desValidate">
                                                            <div class="fw">
                                                                <fieldset>
                                                                    <label>Business type:<span style="color:red">*</span></label>
                                                                    <select name="business_type" ng-model="user.business_type" ng-change="busSelectCheck(this)" id="business_type" tabindex="1">
                                                                        <option value="" selected="selected">Select Business type</option>
                                                                        <option ng-repeat='businessType in business_type' value='{{businessType.type_id}}'>{{businessType.business_name}}</option>             
                                                                        <option ng-option value="0" id="busOption">Other</option>    
                                                                    </select>
                                                                    <span ng-show="errorBusinessType" class="error">{{errorBusinessType}}</span>
                                                                </fieldset>  
                                                                <div id="busDivCheck" ng-if="user.business_type == '0'">
                                                                    <fieldset class="half-width" id="other-business">
                                                                        <label> Other business type: <span style="color:red;" >*</span></label>
                                                                        <input type="text" name="bustype" ng-model="user.bustype"  tabindex="3"  id="bustype" value="<?php echo $other_business; ?>" ng-required="true">
                                                                        <span ng-show="errorOtherBusinessType" class="error">{{errorOtherBusinessType}}</span>
                                                                    </fieldset>
                                                                </div>
                                                            </div>
                                                            <div class="fw">
                                                                <fieldset>
                                                                    <label>Category:<span style="color:red">*</span></label>
                                                                    <select name="industriyal" ng-model="user.industriyal" ng-change="indSelectCheck(this)" id="industriyal" tabindex="2">
                                                                        <option ng-option value="" selected="selected">Select Industry type</option>
                                                                        <option ng-repeat='caegoryType in industry_type' value='{{caegoryType.industry_id}}'>{{caegoryType.industry_name}}</option>             
                                                                        <option ng-option value="0" id="indOption">Other</option>
                                                                    </select>
                                                                    <span ng-show="errorCategory" class="error">{{errorCategory}}</span>
                                                                </fieldset>  

                                                                <div id="indDivCheck" ng-if="user.industriyal == '0'">
                                                                    <fieldset class="half-width" id="other-category">
                                                                        <label> Other category:<span style="color:red;" >*</span></label>
                                                                        <input type="text" name="indtype" ng-model="user.indtype" id="indtype" tabindex="4"  value="<?php echo $other_industry; ?>" ng-required="true">
                                                                        <span ng-show="errorOtherCategory" class="error">{{errorOtherCategory}}</span>
                                                                    </fieldset>
                                                                </div>
                                                            </div>
                                                            <fieldset class="full-width">
                                                                <label>Details of your business:<span style="color:red">*</span></label>
                                                                <textarea name="business_details" ng-model="user.business_details" id="business_details" rows="4" tabindex="5"  cols="50" placeholder="Enter business detail" style="resize: none;"></textarea>
                                                                <span ng-show="errorBusinessDetails" class="error">{{errorBusinessDetails}}</span>
                                                            </fieldset>
                                                            <input type="hidden" name="busreg_step" ng-model="user.busreg_step" id="busreg_step" tabindex="4"  value="">
                                                            <fieldset class="hs-submit full-width" style="position: relative;">
                                                                <input type="submit"  id="next" name="next" value="Next" tabindex="6" >
                                                                <div class="loader-cust" ng-show="loader_show"> </div>
                                                            </fieldset>
                                                        </form>
                                                    </div>
                                                </div>

                                                <div class="tab-pane" id="business_image"> 
                                                    <div class="">
                                                        <h3>Business Images</h3>
                                                        <form name="businessimage" ng-submit="submitbusImageForm()" id="businessimage" class="clearfix" ng-validate="imageValidate">
                                                            <fieldset class="full-width">
                                                                <label>Business images<span class="optional">(optional)</span>:</label>
                                                                <input type="file" file-input="files" ng-file-model="user.image1" tabindex="1" name="image1[]" accept="image/*" id="image1" multiple/> 
                                                                <span ng-show="errorImage" class="error">{{errorImage}}</span>                                                                        
                                                            </fieldset>
                                                            <input type="hidden" name="busreg_step" ng-model="user.busreg_step" id="busreg_step" tabindex="4"  value="">
                                                            <fieldset class="full-width">
                                                                <div class="bus_image" style="color:#f00; display: block;"></div> 
                                                                <div class="bus_image_prev"></div> 
                                                            </fieldset>
                                                            <fieldset class = "hs-submit full-width">
                                                                <input type = "submit" id = "submit" name = "submit" tabindex = "2" value = "Submit">
                                                                <div class="loader-cust" ng-show="loader_show"> </div>
                                                            </fieldset>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <?php echo $login_footer ?>
        <?php echo $footer; ?>
        <?php
        if (IS_BUSINESS_JS_MINIFY == '0') {
            ?>
            <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>                                                                                                                                    <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
        <?php } else {
            ?>
            <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()) ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/angular-validate.min.js?ver=' . time()) ?>"></script>
        <?php }
        ?>
        <script>
                                                                            var base_url = '<?php echo base_url(); ?>';
                                                                            var slug = '<?php echo $slugid; ?>';
                                                                            var reg_uri = '<?php echo $reg_uri ?>';
                                                                            var company_name_validation = '<?php echo $this->lang->line('company_name_validation') ?>';
                                                                            var country_validation = '<?php echo $this->lang->line('country_validation') ?>';
                                                                            var state_validation = '<?php echo $this->lang->line('state_validation') ?>';
                                                                            var address_validation = '<?php echo $this->lang->line('address_validation') ?>';
                                                                            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
                                                                            var profile_login = '<?php echo $profile_login; ?>';
        </script>
        <script>
                    // Defining angularjs application.
                    var busRegApp = angular.module('busRegApp', ['ngValidate']);
                    busRegApp.directive("fileInput", function ($parse) {
                        return{
                            link: function ($scope, element, attrs) {
                                element.on("change", function (event) {
                                    var files = event.target.files;
                                    $parse(attrs.fileInput).assign($scope, element[0].files);
                                    $scope.$apply();
                                });
                            }
                        }
                    });
                    busRegApp.controller('busRegController', function ($scope, $http) {
                        $scope.user = {};
                        $scope.countryList = undefined;
                        $scope.stateList = undefined;
                        $scope.cityList = undefined;
                        $scope.loader_show = false;
                        $scope.tab_active = function (data) {
                            var title;
                            var url;
                            if (data == 1) {
                                history.pushState('Business information', 'Business information', 'business-information');
                                activeBusinessInformation();
                            } else if (data == 2) {
                                history.pushState('Contact information', 'Contact information', 'contact-information');
                                activeContactInformation();
                            } else if (data == 3) {
                                history.pushState('Description', 'Description', 'description');
                                activeDescription();
                            } else if (data == 4) {
                                history.pushState('Business image', 'Business image', 'image');
                                activeImage();
                            }
                            if (typeof (history.pushState) != "undefined") {
                                var obj = {Title: title, Url: url};
                                history.pushState(obj, obj.Title, obj.Url);
                                $(".common-form_border").load(url);
                            } else {
                                alert("Browser does not support HTML5.");
                            }
                        }

                        function activeBusinessInformation() {
                            $('.progress-line-filled').removeClass('step1 step2 step3 step4');
                            $('.progress-line-filled').addClass('step1');
                            $('ul.left-form-each-ul li').removeClass('active filled-box');
                            $('ul.left-form-each-ul li#left-form-each-li-1').addClass('active filled-box');
                            $('.tab-content .tab-pane').removeClass('active');
                            $('.tab-content .tab-pane:nth-child(1)').addClass('active');
                            $scope.title = 'Business Information | Business Profile - Aileensoul';
                            getCountry();
                            getBusinessInformation();
                        }
                        function activeContactInformation() {
                            $('.progress-line-filled').removeClass('step1 step2 step3 step4');
                            $('.progress-line-filled').addClass('step2');
                            $('ul.left-form-each-ul li').removeClass('active filled-box');
                            $('ul.left-form-each-ul li#left-form-each-li-1').addClass('filled-box');
                            $('ul.left-form-each-ul li#left-form-each-li-2').addClass('active filled-box');
                            $('.tab-content .tab-pane').removeClass('active');
                            $('.tab-content .tab-pane:nth-child(2)').addClass('active');
                            $scope.title = 'Contact Information | Business profile - Aileensoul';
                            getContactInformation();
                        }
                        function activeDescription() {
                            $('.progress-line-filled').removeClass('step1 step2 step3 step4');
                            $('.progress-line-filled').addClass('step3');
                            $('ul.left-form-each-ul li').removeClass('active filled-box');
                            $('ul.left-form-each-ul li#left-form-each-li-3').addClass('active filled-box');
                            $('ul.left-form-each-ul li#left-form-each-li-1').addClass('filled-box');
                            $('ul.left-form-each-ul li#left-form-each-li-2').addClass('filled-box');
                            $('.tab-content .tab-pane').removeClass('active');
                            $('.tab-content .tab-pane:nth-child(3)').addClass('active');
                            $scope.title = 'Description | Business profile - Aileensoul';
                            getDescription();
                        }
                        function activeImage() {
                            $('.progress-line-filled').removeClass('step1 step2 step3 step4');
                            $('.progress-line-filled').addClass('step4');
                            $('ul.left-form-each-ul li').removeClass('active filled-box');
                            $('ul.left-form-each-ul li#left-form-each-li-4').addClass('active filled-box');
                            $('ul.left-form-each-ul li#left-form-each-li-1').addClass('filled-box');
                            $('ul.left-form-each-ul li#left-form-each-li-2').addClass('filled-box');
                            $('ul.left-form-each-ul li#left-form-each-li-3').addClass('filled-box');
                            $('.tab-content .tab-pane').removeClass('active');
                            $('.tab-content .tab-pane:nth-child(4)').addClass('active');
                            $scope.title = 'Business Image | Business Profile - Aileensoul';
                            getImage();
                        }
                        if (reg_uri == 'business-information') {
                            activeBusinessInformation();
                        } else if (reg_uri == 'contact-information') {
                            activeContactInformation();
                        } else if (reg_uri == 'description') {
                            activeDescription();
                        } else if (reg_uri == 'image') {
                            activeImage();
                        }
                        $(window).bind('popstate', function () {
                            window.location.href = window.location.href;
                        });
                        function getCountry() {
                            $http({
                                method: 'GET',
                                url: base_url + 'business_profile_registration/getCountry',
                                headers: {'Content-Type': 'application/json'},
                            }).success(function (data) {
                                $scope.countryList = data;
                            });
                        }
                        $scope.getCountry = function () {
                            getCountry();
                        };
                        function select_color_change() {
                            var selected_val = $('select').val();
                            if (selected_val == '') {
                                $('select').css('color', '#acacac');
                            } else {
                                $('select').css('color', 'black');
                            }
                        }

                        function onCountryChange(country_id = '') {
                            $http({
                                method: 'POST',
                                url: base_url + 'business_profile_registration/getStateByCountryId',
                                data: {countryId: country_id}
                            }).success(function (data) {
                                $scope.stateList = data;
                                $("#state").find("option").eq(0).remove();
                                select_color_change();
                            });
                        }
                        function onCountryChange1(country_id = '') {
                            $http({
                                method: 'POST',
                                url: base_url + 'business_profile_registration/getStateByCountryId',
                                data: {countryId: country_id}
                            }).success(function (data) {
                                if (angular.isDefined($scope.user.state_id)) {
                                    delete $scope.user.state_id;
                                }
                                $scope.user.state_id = "";
                                $scope.stateList = data;
                                select_color_change();
                            });
                        }

                        $scope.onCountryChange = function () {
                            $scope.countryIdVal = $scope.user.country_id;
                            onCountryChange1($scope.countryIdVal);
                            $scope.user.city_id = "";
                        };
                        function onStateChange(state_id = '') {
                            $http({
                                method: 'POST',
                                url: base_url + 'business_profile_registration/getCityByStateId',
                                data: {stateId: state_id}
                            }).success(function (data) {
                                $scope.cityList = data;
                            });
                        }
                        function onStateChange1(state_id = '') {
                            $http({
                                method: 'POST',
                                url: base_url + 'business_profile_registration/getCityByStateId',
                                data: {stateId: state_id}
                            }).success(function (data) {
                                if (angular.isDefined($scope.user.city_id)) {
                                    delete $scope.user.city_id;
                                }
                                $scope.cityList = data;
                            });
                        }

                        $scope.onStateChange = function () {
                            $scope.stateIdVal = $scope.user.state_id;
                            onStateChange1($scope.stateIdVal);
                        };
                        function getBusinessInformation() {
                            $http({
                                method: 'POST',
                                url: base_url + 'business_profile_registration/getBusinessInformation',
                                headers: {'Content-Type': 'application/json'},
                            }).success(function (data) {
                                if (data[0]) {
                                    onCountryChange(data[0].country);
                                    onStateChange(data[0].state);
                                    $scope.user.companyname = data[0].company_name;
                                    $scope.user.country_id = data[0].country;
                                    $scope.user.state_id = data[0].state;
                                    $scope.user.city_id = data[0].city;
                                    $scope.user.pincode = data[0].pincode;
                                    $scope.user.business_address = data[0].address;
                                    $scope.user.busreg_step = data[0].business_step;
                                    $scope.busRegStep = data[0].business_step;
                                }
                            });
                        }
                        $scope.getBusinessInformation = function () {
                            getBusinessInformation();
                        };
                        function getContactInformation() {
                            $http({
                                method: 'POST',
                                url: base_url + 'business_profile_registration/getContactInformation',
                                headers: {'Content-Type': 'application/json'},
                            }).success(function (data) {
                                if (data[0]) {
                                    $scope.user.contactname = data[0].contact_person;
                                    $scope.user.contactmobile = data[0].contact_mobile;
                                    $scope.user.email = data[0].contact_email;
                                    $scope.user.contactwebsite = data[0].contact_website;
                                    $scope.user.busreg_step = data[0].business_step;
                                } else {
                                    $scope.tab_active(1);
                                    activeBusinessInformation();
                                }
                            });
                        }
                        ;
                        $scope.getContactInformation = function () {
                            getContactInformation();
                        };
                        function getDescription() {
                            $http({
                                method: 'POST',
                                url: base_url + 'business_profile_registration/getDescription',
                                headers: {'Content-Type': 'application/json'},
                            }).success(function (data) {
                                if (data['userdata'][0]) {
                                    if (data['userdata'][0].business_step >= '2') {
                                        $scope.user.business_type = data['userdata'][0].business_type;
                                        $scope.user.industriyal = data['userdata'][0].industriyal;
                                        $scope.user.business_details = data['userdata'][0].details;
                                        $scope.user.bustype = data['userdata'][0].other_business_type;
                                        $scope.user.indtype = data['userdata'][0].other_industrial;
                                        $scope.user.busreg_step = data['userdata'][0].business_step;
                                        $scope.business_type = data['business_type'];
                                        $scope.industry_type = data['industriyaldata'];
                                    } else if (data['userdata'][0].business_step == '1') {
                                        $scope.tab_active(2);
                                        activeContactInformation();
                                    } else {
                                        $scope.tab_active(1);
                                        activeBusinessInformation();
                                    }
                                } else {
                                    $scope.tab_active(1);
                                    activeBusinessInformation();
                                }
                            });
                        }
                        ;
                        $scope.getDescription = function () {
                            getDescription();
                        };
                        function getImage() {
                            $http({
                                method: 'POST',
                                url: base_url + 'business_profile_registration/getImage',
                            }).success(function (data) {
                                if (data.business_step >= '3') {
                                    $('.bus_image_prev').html(data['busImageDetail']);
                                } else if (data.business_step == '2') {
                                    $scope.tab_active(3);
                                    activeDescription();
                                } else if (data.business_step == '1') {
                                    $scope.tab_active(2);
                                    activeContactInformation();
                                } else {
                                    $scope.tab_active(1);
                                    activeBusinessInformation();
                                }
                            });
                        }
                        ;
                        $scope.getImage = function () {
                            getImage();
                        };
                        $.validator.addMethod("regx", function (value, element, regexpr) {
                            if (!value)
                            {
                                return true;
                            } else
                            {
                                return regexpr.test(value);
                            }
                        }, "Only space, only number and only special characters are not allow");
                        $.validator.addMethod("regx1", function (value, element, regexpr) {
                            if (!value)
                            {
                                return true;
                            } else
                            {
                                return regexpr.test(value);
                            }
                        }, "You can use letters(a-z), numbers, and periods.");
                        $scope.busInfoValidate = {
                            rules: {
                                companyname: {
                                    required: true,
                                    regx: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
                                },
                                country: {
                                    required: true,
                                },
                                state: {
                                    required: true,
                                },
                                business_address: {
                                    required: true,
                                    regx: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
                                }
                            },
                            messages: {
                                companyname: {
                                    required: company_name_validation,
                                },
                                country: {
                                    required: country_validation,
                                },
                                state: {
                                    required: state_validation,
                                },
                                business_address: {
                                    required: address_validation,
                                }
                            }
                        };
                        $scope.submitbusinessinfoForm = function () {
                            if ($scope.businessinfo.validate()) {
                                angular.element('#businessinfo #next').addClass("form_submit");
                                $scope.loader_show = true;
                                $http({
                                    method: 'POST',
                                    url: base_url + 'business_profile_registration/ng_bus_info_insert',
                                    data: $scope.user, //forms user object
                                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                                })
                                        .success(function (data) {
                                            if (data.errors) {
                                                // Showing errors.
                                                $scope.errorCompanyName = data.errors.companyname;
                                                $scope.errorCountry = data.errors.country;
                                                $scope.errorState = data.errors.state;
                                                $scope.errorCity = data.errors.city;
                                                $scope.errorPincode = data.errors.pincode;
                                                $scope.errorPostalAddress = data.errors.business_address;
                                            } else {
                                                if (data.is_success == '1') {
                                                    angular.element('#businessinfo #next').removeClass("form_submit");
                                                    $scope.loader_show = false;
                                                    activeContactInformation();
                                                    $scope.tab_active(2);
                                                    $("li#left-form-each-li-2 a").attr({
                                                        href: "#contact_information",
                                                        'data-toggle': "tab",
                                                        'ng-click': "getContactInformation(); tab_active(2);"
                                                    });
                                                } else {
                                                    return false;
                                                }
                                            }
                                        });
                            } else {
                                return false;
                            }

                        };
                        $.validator.addMethod("regx2", function (value, element, regexpr) {
                            if (!value)
                            {
                                return true;
                            } else
                            {
                                return regexpr.test(value);
                            }
                        }, "please enter valid mobile number.");
                        $scope.conInfoValidate = {
                            rules: {
                                contactname: {
                                    required: true,
                                    regx: /^[a-zA-Z\s]*[a-zA-Z]/
                                },
                                contactmobile: {
                                    required: true,
                                    number: true,
                                    minlength: 8,
                                    maxlength: 15,
                                    regx2: /^[0-9][0-9]*/
                                },
                                email: {
                                    required: true,
                                    email: true,
                                }
                            },
                            messages: {
                                contactname: {
                                    required: "Person name is required.",
                                },
                                contactmobile: {
                                    required: "Mobile number is required.",
                                },
                                email: {
                                    required: "Email id is required.",
                                    email: "Please enter valid email id.",
                                }
                            }
                        };
                        $scope.submitcontactinfoForm = function () {
                            if ($scope.contactinfo.validate()) {
                                angular.element('#contactinfo #next').addClass("form_submit");
                                $scope.loader_show = true;
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
                                                if (data.is_success == '1') {
                                                    angular.element('#contactinfo #next').removeClass("form_submit");
                                                    $scope.loader_show = false;
                                                    activeDescription();
                                                    $scope.tab_active(3);
                                                    $("li#left-form-each-li-3 a").attr({
                                                        href: "#description",
                                                        'data-toggle': "tab",
                                                        'ng-click': "getDescription(); tab_active(3)"
                                                    });
                                                } else {
                                                    return false;
                                                }
                                            }
                                        });
                            } else {
                                return false;
                            }

                        };
                        $scope.desValidate = {
                            rules: {
                                business_type: {
                                    required: true,
                                },
                                industriyal: {
                                    required: true,
                                },
                                business_details: {
                                    required: true,
                                    regx: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
                                },
                            },
                            messages: {
                                business_type: {
                                    required: "Business type is required.",
                                },
                                industriyal: {
                                    required: "Industrial is required.",
                                },
                                business_details: {
                                    required: "Business details is required.",
                                },
                            }
                        };
                        $scope.submitdescriptionForm = function () {
                            if ($scope.businessdis.validate()) {
                                angular.element('#businessdis #next').addClass("form_submit");
                                $scope.loader_show = true;
                                $http({
                                    method: 'POST',
                                    url: base_url + 'business_profile_registration/ng_description_insert',
                                    data: $scope.user, //forms user object
                                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                                })
                                        .success(function (data) {
                                            if (data.errors) {
                                                $scope.errorBusinessType = data.errors.business_type;
                                                $scope.errorCategory = data.errors.industriyal;
                                                $scope.errorOtherBusinessType = data.errors.bustype;
                                                $scope.errorOtherCategory = data.errors.indtype;
                                                $scope.errorBusinessDetails = data.errors.business_details;
                                            } else {
                                                if (data.is_success == '1') {
                                                    angular.element('#businessdis #next').removeClass("form_submit");
                                                    $scope.loader_show = false;
                                                    activeImage();
                                                    $scope.tab_active(4);
                                                    $("li#left-form-each-li-4 a").attr({
                                                        href: "#business_image",
                                                        'data-toggle': "tab",
                                                        'ng-click': "getImage(); tab_active(4)"
                                                    });
                                                } else {
                                                    return false;
                                                }
                                            }
                                        });
                            } else {
                                return false;
                            }

                        };
                        $scope.submitbusImageForm = function () {
                            var form_data = new FormData();
                            angular.element('#businessimage #next').addClass("form_submit");
                            $scope.loader_show = true;
                            angular.forEach($scope.files, function (file) {
                                form_data.append('image1[]', file);
                            });
                            $http.post(base_url + 'business_profile_registration/ng_image_insert', form_data,
                                    {
                                        transformRequest: angular.identity,
                                        headers: {'Content-Type': undefined, 'Process-Data': false}
                                    }).success(function (data) {
                                if (data.errors) {
                                    // Showing errors.
                                    $scope.errorImage = data.errors.image1;
                                } else {
                                    if (data.is_success == '1') {
                                        angular.element('#businessimage #next').removeClass("form_submit");
                                        $scope.loader_show = false;
                                        window.location.href = base_url + 'business-profile/home';
                                    } else {
                                        return false;
                                    }
                                }
                            });
                        }
                    });
                    function delete_bus_image(image_id) {
                        $.ajax({
                            type: 'POST',
                            url: base_url + "business_profile_registration/bus_img_delete",
                            data: 'image_id=' + image_id,
                            success: function (data) {
                                if (data) {
                                    $('.job_work_edit_' + image_id).remove();
                                }
                            }
                        });
                    }
                    $('select').on('change', function () {
                        if ($(this).val()) {
                            $(this).css('color', 'black');
                        } else {
                            $(this).css('color', '#acacac');
                        }
                    });
                    $(document).ready(function () {
                        var selected_val = $('select').val();
                        if (selected_val == '') {
                            $('select').css('color', '#acacac');
                        } else {
                            $('select').css('color', 'black');
                        }
                    });
        </script>
        <?php
        if (IS_BUSINESS_JS_MINIFY == '0') {
            ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/information.js?ver=' . time()); ?>"></script>
             <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>                                                                                                                                                                                                                                                                                                                                                                                                                           <!--            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/information.js?ver=' . time()); ?>"></script>
                                                                                                                                                                                                            <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>-->
        <?php } else {
            ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/business-profile/information.min.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js_min/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
        <?php }
        ?>
    </body>
</html>
