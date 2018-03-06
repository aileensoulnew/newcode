app.controller('searchArtistController', function ($scope, $window) {
    $scope.keyword = q;
    $scope.city = l;
    $scope.searchSubmit = function () {

        var keyword = $scope.keyword.toLowerCase().split(' ').join('+');
        var city = $scope.city.toLowerCase().split(' ').join('+');

        if (keyword == '' && city == '') {
            return false;
        } else if (keyword != '' && city == '') {
            $window.location.href = base_url + 'artist/search?q=' + keyword;
        } else if (keyword == '' && city != '') {
            $window.location.href = base_url + 'artist/search?l=' + city;
        } else {
            $window.location.href = base_url + 'artist/search?q=' + keyword + '&l=' + city;
        }
    }
});