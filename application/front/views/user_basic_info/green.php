<body ng-app="myApp">

<p><a href="">Main</a></p>

<a href="red">Red</a>
<a href="green">Green</a>
<a href="blue">Blue</a>

<div ng-view></div>

<script>
var app = angular.module("myApp", ["ngRoute"]);
app.config(function($routeProvider) {
    $routeProvider
    .when("/", {
        templateUrl : "main.htm"
    })
    .when("/red", {
        templateUrl : "red.htm"
    })
    .when("/green", {
        templateUrl : "green.htm"
    })
    .when("/blue", {
        templateUrl : "blue.htm"
    });
});
</script>

<p>Click on the links to navigate to "red.htm", "green.htm", "blue.htm", or back to "main.htm"</p>
</body>
</html>


<h1>green</h1>
<h3>Paris is the capital city of France.</h3>
<p>The Paris area is one of the largest population centers in Europe, with more than 12 million inhabitants.</p>
<!--<p>{{msg}}</p>-->