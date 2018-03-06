app.controller('artistListController', function ($scope, $http) {
    $scope.title = title;
    $scope.artistCategory = {};
    function artistCategory(){
        $http.get(base_url + "artist_live/artistCategory?limit=24").then(function (success) {
            $scope.artistCategory = success.data;
        }, function (error) {});
    }
    artistCategory();
    function otherCategoryCount(){
        $http.get(base_url + "artist_live/otherCategoryCount").then(function (success) {
            $scope.otherCategoryCount = success.data;
        }, function (error) {});
    }
    otherCategoryCount();
    function categoryArtistList(){
        $http.get(base_url + "artist_live/artistListByCategory/" + category_id).then(function (success) {
            $scope.ArtistList = success.data;
        }, function (error) {});
    }
    categoryArtistList();
    
});

$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});