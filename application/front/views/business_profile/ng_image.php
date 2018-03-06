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
    <body class="page-container-bg-solid page-boxed pushmenu-push botton_footer" ng-app="busImageApp" ng-controller="busImageController">
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
                                        <li class="custom-none"><a href="<?php echo base_url('business-profile/business-information-update'); ?>">Business Information</a></li>
                                        <li class="custom-none"><a href="<?php echo base_url('business-profile/contact-information'); ?>">Contact Information</a></li>
                                        <li class="custom-none"><a href="<?php echo base_url('business-profile/description'); ?>">Description</a></li>
                                        <li <?php if ($this->uri->segment(1) == 'business-profile') { ?> class="active init" <?php } ?>><a href="#">Business Images</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-8">
                                <div class="common-form common-form_border"> 
                                    <h3>Business Images</h3>
                                    <form name="businessimage" ng-submit="submitForm()" id="businessimage" class="clearfix">
                                        <fieldset class="full-width">
                                            <label>Business images<span class="optional">(optional)</span>:</label>
                                            <input type="file" file-input="files" ng-file-model="user.image1" tabindex="1" name="image1[]" accept="image/*" id="image1" multiple/> 
                                            <span ng-show="errorImage" class="error">{{errorImage}}</span>                                                                        
                                        </fieldset>
                                        <fieldset class="hs-submit full-width">
                                            <input type="submit"  id="submit" name="submit" tabindex="2"  value="Submit">
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

                    var busImageApp = angular.module('busImageApp', []);
                    busImageApp.directive("fileInput", function ($parse) {
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
                    busImageApp.controller("busImageController", function ($scope, $http) {
                        $scope.user = {};
                        $scope.submitForm = function () {
                            var form_data = new FormData();
                            angular.forEach($scope.files, function (file) {
//                                console.log(file);
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
                                        window.location.href = base_url + 'business-profile/home';
                                    } else {
                                        return false;
                                    }
                                    //$scope.message = data.message;
                                }

                                //alert(response);
                                //$scope.show_images();
                            });
                        }
                        /*$scope.show_images = function () {
                         $http.get("show_images.php")
                         .success(function (data) {
                         $scope.uploaded_images = data;
                         });
                         } */
                    });

        </script>
        <?php if (IS_BUSINESS_JS_MINIFY == '0') { ?>
                                                                <!--            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/image.js?ver=' . time()); ?>"></script>
                                                                            <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>-->
        <?php } else { ?>
                                                                <!--            <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/business-profile/image.min.js?ver=' . time()); ?>"></script>
                                                                            <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js_min/webpage/business-profile/common.min.js?ver=' . time()); ?>"></script>-->
        <?php } ?>
    </body>
</html>

