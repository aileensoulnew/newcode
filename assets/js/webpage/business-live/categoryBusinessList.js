app.controller('businessListController', function ($scope, $http) {
    $scope.title = title;
    $scope.businessCategory = {};
    function businessCategory(){
        $http.get(base_url + "business_live/businessCategory?limit=24").then(function (success) {
            $scope.businessCategory = success.data;
        }, function (error) {});
    }
    businessCategory();
    function otherCategoryCount(){
        $http.get(base_url + "business_live/otherCategoryCount").then(function (success) {
            $scope.otherCategoryCount = success.data;
        }, function (error) {});
    }
    otherCategoryCount();
    function categoryBusinessList(){
        $http.get(base_url + "business_live/businessListByCategory/" + category_id).then(function (success) {
            $scope.businessList = success.data;
        }, function (error) {});
    }
    categoryBusinessList();
    
});

$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});