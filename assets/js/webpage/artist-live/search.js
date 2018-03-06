app.controller('artistSearchListController', function ($scope, $http) {
    $scope.title = title;
    $scope.artistCategory = {};
    function artistCategory() {
        $http.get(base_url + "artist_live/artistCategory?limit=24").then(function (success) {
            $scope.artistCategory = success.data;
        }, function (error) {});
    }
    artistCategory();
    function otherCategoryCount() {
        $http.get(base_url + "artist_live/otherCategoryCount").then(function (success) {
            $scope.otherCategoryCount = success.data;
        }, function (error) {});
    }
    otherCategoryCount();
    function searchArtist() {
        var search_data_url = '';
        if (q != '' && l == '') {
            search_data_url = base_url + 'artist_live/searchArtistData?q=' + q;
        } else if (q == '' && l != '') {
            search_data_url = base_url + 'artist_live/searchArtistData?l=' + l;
        } else {
            search_data_url = base_url + 'artist_live/searchArtistData?q=' + q + '&l=' + l;
        }
        
        $http.get(search_data_url).then(function (success) {
            $scope.artistList = success.data;
        }, function (error) {});
    }
    searchArtist();

});

$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
    $('#q').val(q);
    $('#l').val(l);
});