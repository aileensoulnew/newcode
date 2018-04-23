<!DOCTYPE html>
<html>
    <base href="/" >
    <meta name="robots" content="noindex, nofollow">
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>

<body ng-app="myApp">

<p><a href="#/!">Main</a></p>

<a href="user_basic_info/red">Red</a>
<a href="user_basic_info/green">Green</a>
<a href="user_basic_info/blue">Blue</a>

<div ng-view></div>

<script>
var base_url = '<?php echo base_url(); ?>';
//alert(base_url);
var app = angular.module("myApp", ["ngRoute"]);
app.config(function($routeProvider,$locationProvider) {
    $routeProvider
    .when("/user_basic_info/autocomplete", {
        templateUrl : "main.html"
    })
    .when("/user_basic_info/red", {
//        templateUrl : "red.html"
        templateUrl : base_url + "recruiter/red"
    })
    .when("/user_basic_info/green", {
        templateUrl : base_url + "recruiter/green"
    })
    .when("/user_basic_info/blue", {
        templateUrl : base_url + "recruiter/blue"
    });
    
    $locationProvider.html5Mode(true);
});
</script>

<p>Click on the links to navigate to "red.htm", "green.htm", "blue.htm", or back to "main.htm"</p>
</body>
</html>
