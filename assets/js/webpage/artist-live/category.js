app.controller('artistCategoryController', function ($scope, $http) {
    $scope.title = title;
    $scope.artistAllCategory = {};
    function artistAllCategory(){
        $http.get(base_url + "artist_live/artistAllCategory").then(function (success) {
            $scope.artistAllCategory = success.data;
        }, function (error) {});
    }
    artistAllCategory();
    function otherCategoryCount(){
        $http.get(base_url + "artist_live/otherCategoryCount").then(function (success) {
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