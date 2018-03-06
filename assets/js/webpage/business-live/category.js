app.controller('businessCategoryController', function ($scope, $http) {
    $scope.title = title;
    $scope.businessAllCategory = {};
    function businessAllCategory(){
        $http.get(base_url + "business_live/businessAllCategory").then(function (success) {
            $scope.businessAllCategory = success.data;
        }, function (error) {});
    }
    businessAllCategory();
    function otherCategoryCount(){
        $http.get(base_url + "business_live/otherCategoryCount").then(function (success) {
            $scope.otherCategoryCount = success.data;
        }, function (error) {});
    }
    otherCategoryCount();
});

$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});