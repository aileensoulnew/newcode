<!DOCTYPE html>
<html>
    <head>
        <style>
            .virtualRepeatdemoInfiniteScroll #vertical-container {
                height: 292px;
                width: 400px;
            }

            .virtualRepeatdemoInfiniteScroll .repeated-item {
                border-bottom: 1px solid #ddd;
                box-sizing: border-box;
                height: 40px;
                padding-top: 10px;
            }

            .virtualRepeatdemoInfiniteScroll md-content {
                margin: 16px;
            }

            .virtualRepeatdemoInfiniteScroll md-virtual-repeat-container {
                border: solid 1px grey;
            }

            .virtualRepeatdemoInfiniteScroll .md-virtual-repeat-container .md-virtual-repeat-offsetter {
                padding-left: 16px;
            }
        </style>
        <title></title>
        <meta name="robots" content="noindex, nofollow">
        <meta charset="utf-8" />
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/1.0.0-rc1/angular-material.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=RobotoDraft:300,400,500,700,400italic">
        <link rel="stylesheet" href="style.css" />

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular-animate.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular-aria.min.js"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/angular_material/1.0.0-rc1/angular-material.min.js"></script>

        <script src="script.js"></script>

    </head>
    <body ng-app="infiniteScrolling" class="virtualRepeatdemoInfiniteScroll">

        <div ng-controller="AppCtrl as ctrl" ng-cloak>
            <md-content layout="column">
                <md-virtual-repeat-container id="vertical-container" flex>
                    <md-list>  
                        <md-list-item md-virtual-repeat="item in ctrl.infiniteItems" md-on-demand
                                      class="repeated-item" flex>
                            {{item.id}}
                            {{item.name}}
                        </md-list-item>
                    </md-list>
                </md-virtual-repeat-container>
            </md-content>
        </div>


        <script>
            var base_url = '<?php echo base_url(); ?>';
            (function () {
            'use strict';
            angular
                    .module('infiniteScrolling', ['ngMaterial'])
                    .controller('AppCtrl', function ($timeout, $scope, $http) {
                    // In this example, we set up our model using a plain object.
                    // Using a class works too. All that matters is that we implement
                    // getItemAtIndex and getLength.
                    var vm = this;
                    var abc = 1;
                    if (abc == 1) {
                    vm.infiniteItems = {
                    numLoaded_: 0,
                            toLoad_: 0,
                            khyati: 6,
                            items: [],
                            // Required.
                            getItemAtIndex: function (index) {
                            // var index = 11;
                            if (index > this.numLoaded_) {
                            this.fetchMoreItems_(index);
                            return null;
                            }
                            return this.items[index];
                            },
                            // Required.
                            getLength: function () {
                            return this.numLoaded_ + 5;
                            },
                            fetchMoreItems_: function (index) {
                            //      alert(index);                 
                            //alert(this.khyati);
                            // if (this.khyati >= index) {
                            if (index == this.khyati - 5) {
                            //   alert("success");
                            //  alert(this.khyati);
                            //  alert(index);
                            this.khyati += 5;
                            this.toLoad_ += 5;
                            $http({
                            method: 'POST',
                                    url: 'http://localhost/aileensoul-new/userprofile_page/vsrepeat_data'
                            })
                                    .then(angular.bind(this, function (obj) {
                                    this.items = this.items.concat(obj.data);
                                    this.numLoaded_ = this.toLoad_;
                                    }));
                            }
                            }
                    };
                    }
                    });
            })();
        </script>
    </body>
</html>
