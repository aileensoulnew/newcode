<style>
li {
  height: 120px;
  border-bottom: 1px solid gray;
}

#fixed {
    height: 400px;
    overflow: auto;
}
</style>
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>

<div id="fixed" when-scrolled="loadMore()">
  <ul>
    <li ng-repeat="i in items">{{i.id}}</li>
  </ul>  
</div>
<script type='text/javascript'>
    function Main($scope) {
    $scope.items = [];
    
    var counter = 0;
    $scope.loadMore = function() {
        for (var i = 0; i < 5; i++) {
            $scope.items.push({id: counter});
            counter += 10;
        }
    };
    
    $scope.loadMore();
}

angular.module('scroll', []).directive('whenScrolled', function() { alert(13);
    return function(scope, elm, attr) {
        var raw = elm[0];
        
        elm.bind('scroll', function() {
            if (raw.scrollTop + raw.offsetHeight >= raw.scrollHeight) {
                scope.$apply(attr.whenScrolled);
            }
        });
    };
});
   </script>
