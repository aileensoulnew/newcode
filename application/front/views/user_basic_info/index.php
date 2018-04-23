<!DOCTYPE html>
<html lang="en" ng-app="profileBasicInfoApp" ng-controller="profileBasicInfoController">
    <head>
        <title><?php echo $title; ?></title>
        <meta name="robots" content="noindex, nofollow">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/n-commen.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/n-style.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css') ?>">
        <style>
            #searchResult{
                list-style: none;
                padding: 0px;
                width: 500px;
                position: absolute;
                margin: 0;
            }

            #searchResult li{
                background: lavender;
                padding: 4px;
                margin-bottom: 1px;
            }

            #searchResult li.active{
                background: #000000;
            }

            #searchResult li:nth-child(even){
                background: cadetblue;
                color: white;
            }

            #searchResult li:hover{
                cursor: pointer;
            }

        </style>
    </head>
    <body class="register">
        <?php echo $header_profile; ?>
        <div class="middle-section">
            <div class="container">
                <div class="form-box">
                    <h2 class="text-center">Basic Information</h3>
                        <form name="basicinfo" id="basicinfo" ng-submit="submitBasicInfoForm()" ng-validate="basicInfoValidate">
                            <div class="form-group">
                                <p class="student-or-not">If you are a student then <a data-target="#Student-info" data-toggle="modal" href="javascript:;">Click Here.</a></p>
                            </div>
                            <div class="form-group">
                                <label for="text">Who are you?</label>
                                <input type="text" name="jobTitle" id="jobTitle" class="form-control" ng-keyup="jobTitle()" ng-model="user.jobTitle" placeholder="Ex:Seeking Opportunity, CEO, Enterpreneur, Founder, Singer, Photographer, Developer, HR, BDE, CA, Doctor.." typeahead="item as item.name for item in titleSearchResult | filter:$viewValue" autocomplete="off">
                                <label ng-show="errorjobTitle" class="error">{{errorjobTitle}}</label>
                            </div>
                            <div class="form-group">
                                <label for="text">Where are you from?</label>
                                <input type="text" name="city" id="city" class="form-control" ng-keyup="cityList()" ng-model="user.cityList" placeholder="Enter your city name" typeahead="item as item.city_name for item in citySearchResult | filter:$viewValue" autocomplete="off">
                                <label ng-show="errorcityList" class="error">{{errorcityList}}</label>
                            </div>
                            <div class="form-group cus_field">
                                <label for="text">What is your field?</label>
                                <select name="field" ng-model="user.field" id="field" ng-change="other_field(this)">
                                    <option value="" selected="selected">Select your field</option>
                                    <option data-ng-repeat='fieldItem in fieldList' value='{{fieldItem.industry_id}}'>{{fieldItem.industry_name}}</option>             
                                    <option value="0">Other</option>
                                </select>
                                <label ng-show="errorfield" class="error">{{errorfield}}</label>
                            </div>
                            <div class="form-group" ng-if="user.field == '0'">
                                <label for="text">Other Field</label>
                                <input type="text" class="form-control" ng-model="user.otherField" placeholder="Enter other field" ng-required="true">
                                <label ng-show="errorotherField" class="error">{{errorotherField}}</label>
                            </div>
                            <p class="text-center submit-btn">
                                <button type="submit" id="submit" class="btn1">Submit</button>
                            </p>
                        </form>
                </div>
            </div>
        </div>
        <?php echo $login_footer; ?>
        <div style="display:none;" class="modal fade" id="Student-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <h3>Eduction Information</h3>
                    <form>
                        <div class="form-group">
                            <label for="text">What are you studying right now?</label>
                            <input type="text" class="form-control" placeholder="Pursuing: Engineering, Medicine, Desiging, MBA, Accounting, BA, 5th, 10th, 12th ..">
                        </div>
                        <div class="form-group">
                            <label for="text">Where are you from?</label>
                            <input type="text" class="form-control" ng-keyup="cityList1()" ng-model="user.cityList1" placeholder="Enter your city name">
                        </div>
                        <div class="form-group">
                            <label for="text">University / Collage / School </label>
                            <input type="text" class="form-control" placeholder="Enter your University / Collage / school ">
                        </div>
                        <p class="text-center submit-btn">
                            <button type="submit" class="btn1">Submit</button>
                        </p>
                    </form>


                </div>
            </div>

        </div>
        <script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>

        <script src="<?php echo base_url('assets/js/angular/angular.min.1.5.7.js') ?>"></script>
        <script data-semver="0.13.0" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-route.1.6.4.js') ?>"></script>
        <script>
                                var base_url = '<?php echo base_url(); ?>';
                                var slug = '<?php echo $slugid; ?>';
                                var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
        </script>
        <script>
            var profileBasicInfoApp = angular.module('profileBasicInfoApp', ['ui.bootstrap', 'ngValidate']);
            profileBasicInfoApp.controller('profileBasicInfoController', function ($scope, $http) {
                $scope.user = {};
                getFieldList();
                function getFieldList() {
                    $http.get(base_url + "general_data/getFieldList").then(function (success) {
                        $scope.fieldList = success.data;
                    }, function (error) {});
                }

                $scope.jobTitle = function () {
                    $http({
                        method: 'POST',
                        url: base_url + 'general_data/searchJobTitle',
                        data: 'q=' + $scope.user.jobTitle,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    })
                            .then(function (success) {
                                data = success.data;
                                $scope.titleSearchResult = data;
                            });
                }

                $scope.cityList = function () {
                    $http({
                        method: 'POST',
                        url: base_url + 'general_data/searchCityList',
                        data: 'q=' + $scope.user.cityList,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    })
                            .then(function (success) {
                                data = success.data;
                                $scope.citySearchResult = data;
                            });
                }

                $scope.basicInfoValidate = {
                    rules: {
                        jobTitle: {
                            required: true,
                        },
                        city: {
                            required: true,
                        },
                        field: {
                            required: true,
                        }
                    },
                    messages: {
                        jobTitle: {
                            required: "Job title is required.",
                        },
                        city: {
                            required: "City is required.",
                        },
                        field: {
                            required: "Field id is required.",
                        }
                    }
                };
                $scope.submitBasicInfoForm = function () {
                    if ($scope.basicinfo.validate()) {
                        angular.element('#basicinfo #submit').addClass("form_submit");
                        $scope.loader_show = true;
                        $http({
                            method: 'POST',
                            url: base_url + 'user_basic_info/ng_basic_info_insert',
                            data: $scope.user, 
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        })
                                .success(function (data) {
                                    if (data.errors) {
                                        $scope.errorjobTitle = data.errors.jobTitle;
                                        $scope.errorcityList = data.errors.cityList;
                                        $scope.errorfield = data.errors.field;
                                        $scope.errorotherField = data.errors.otherField;
                                    } else {
                                        if (data.is_success == '1') {
                                            angular.element('#contactinfo #next').removeClass("form_submit");
                                            $scope.loader_show = false;
                                            window.location = base_url + 'profiles/'
                                        } else {
                                            return false;
                                        }
                                    }
                                });
                    } else {
                        return false;
                    }

                };


            });
        </script>
    </body>
</html>