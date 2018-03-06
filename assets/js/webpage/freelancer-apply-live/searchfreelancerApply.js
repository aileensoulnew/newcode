app.controller('searchFreelancerApplyController', function ($scope, $window) {
    $scope.keyword = q;
    $scope.city = l;
    $scope.full_time = f;
    $scope.part_time = p;
    $scope.searchSubmit = function () {

        var keyword = $scope.keyword.toLowerCase().split(' ').join('+');
        var city = $scope.city.toLowerCase().split(' ').join('+');
        var full_time = $scope.full_time;
        var part_time = $scope.part_time;
        
        if(full_time == '' && part_time == ''){
            var time = "none";
        }else if (full_time == '') {
            var time = "part";
        } else if (part_time == '') {
            var time = "full";
        }else{
            var time = "both";
        }

        if (keyword == '' && city == '') {
            return false;
        } else if (keyword != '' && city == '') {
            $window.location.href = base_url + 'freelancer_apply_live/freelancer_apply_search?q=' + keyword + '&t=' +time;
        } else if (keyword == '' && city != '') {
            $window.location.href = base_url + 'freelancer_apply_live/freelancer_apply_search?l=' + city + '&t=' +time;
        } else {
            $window.location.href = base_url + 'freelancer_apply_live/freelancer_apply_search?q=' + keyword + '&l=' + city + '&t=' +time;
        }
    }
});