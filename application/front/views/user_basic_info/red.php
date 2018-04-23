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


<h1>red</h1>
<h3>London is the capital city of England.</h3>
<p>It is the most populous city in the United Kingdom, with a metropolitan area of over 13 million inhabitants.</p>
<!--<p>{{msg}}</p>-->