<!doctype html>
<html>
    <head>
     <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>

        <title>Load more pagination with AngularJS and PHP</title>
        <link href="style.css" type="text/css" rel="stylesheet">
      
    </head>
    <body ng-app='myapp'>
        <div class="container" ng-controller='fetchCtrl'>

            <!-- Post -->
            <div class="post" ng-repeat='post in posts'>
                <h1>{{ post.title }}</h1>
                <h1>{{ post.id }}</h1>
                <p>
                    {{ post.shortcontent }}
                </p>
                <a href="{{ post.link }}" class="more" target="_blank">More</a>
            </div>
          
            <h1 class="load-more" ng-show="showLoadmore" ng-click='getPosts()'>{{ buttonText }}</h1>
            <input type="hidden" id="row" ng-model='row'>

        </div>
        <!-- Script -->
        <script src="angular.min.js"></script>
        <script>
        var fetch = angular.module('myapp', []);
        var base_url = '<?php echo base_url(); ?>';
        fetch.controller('fetchCtrl', ['$scope', '$http', function ($scope, $http) {

            // Variables
            $scope.showLoadmore = true;
            $scope.row = 0;
            $scope.rowperpage = 3;
            $scope.buttonText = "Load More";
           
            // Fetch data
             $scope.getPosts = function(){
                
                $http({
                method: 'post',
                url: base_url + 'blogdata/bloglist',
                data: {row:$scope.row,rowperpage:$scope.rowperpage}
                }).then(function successCallback(response) {
               
                    if(response.data !='' ){
                      
                        $scope.row+=$scope.rowperpage;
                        if($scope.posts != undefined){
                            $scope.buttonText = "Loading ...";
                            setTimeout(function() {
                                $scope.$apply(function(){
                                angular.forEach(response.data,function(item) {
                                    $scope.posts.push(item);
                                });
                                $scope.buttonText = "Load More";
                                });
                            },500);
                            // $scope.posts.push(response.data);
                             
                        }else{
                            $scope.posts = response.data;
                        }
                    }else{
                        $scope.showLoadmore = false;
                    }

                });
             }

             // Call function
             $scope.getPosts();
      
        }]);

        </script>
    </body>
</html>
