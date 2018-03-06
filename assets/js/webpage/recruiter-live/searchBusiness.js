app.controller('searchBusinessController', function ($scope, $window) {
    $scope.keyword = q;
    $scope.city = l;
    $scope.searchSubmit = function () {

        var keyword = $scope.keyword.toLowerCase().split(' ').join('+');
        var city = $scope.city.toLowerCase().split(' ').join('+');

        if (keyword == '' && city == '') {
            return false;
        } else if (keyword != '' && city == '') {
            $window.location.href = base_url + 'business-profile/search?q=' + keyword;
        } else if (keyword == '' && city != '') {
            $window.location.href = base_url + 'business-profile/search?l=' + city;
        } else {
            $window.location.href = base_url + 'business-profile/search?q=' + keyword + '&l=' + city;
        }
    }
});