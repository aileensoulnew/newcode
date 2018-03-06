app.controller('searchJobController', function ($scope, $window) {
    $scope.keyword = q;
    $scope.city = l;
    $scope.fulltime = w.split('+')[0];
    $scope.parttime = w.split('+')[1];
    $scope.internship = w.split('+')[2];
    
    $scope.searchSubmit = function () {

        var keyword = $scope.keyword.toLowerCase().split(' ').join('+');
        var city = $scope.city.toLowerCase().split(' ').join('+');
        var fulltime = $scope.fulltime;
        var parttime = $scope.parttime;
        var internship = $scope.internship;

        var work_type = '';
        fulltime1 = '';
        if (fulltime == '1') {
            var fulltime1 = 'fulltime+';
        }
        parttime1 = '';
        if (parttime == '1') {
            var parttime1 = 'parttime+';
        }
        internship1 = '';
        if (internship == '1') {
            var internship1 = 'internship+';
        }
        var work_type = work_type.concat(fulltime1, parttime1, internship1);
        var n = work_type.lastIndexOf("+");
        var work_type = work_type.substring(0, n);
        
        if (keyword == '' && city == '' && work_type == '') {
            return false;
        } else if (keyword != '' && city == '' && work_type == '') {
            $window.location.href = base_url + 'job/search?q=' + keyword;
        } else if (keyword == '' && city != '' && work_type == '') {
            $window.location.href = base_url + 'job/search?l=' + city;
        } else if (keyword == '' && city == '' && work_type != '') {
            $window.location.href = base_url + 'job/search?w=' + work_type;
        } else {
            $window.location.href = base_url + 'job/search?q=' + keyword + '&l=' + city + '&w=' + work_type;
        }
    }
    
    
    
});