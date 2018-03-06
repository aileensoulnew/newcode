app.controller('jobSearchListController', function ($scope, $http) {
    $scope.title = title;
    $scope.jobCategory = {};
    $scope.jobCity = {};
    $scope.jobCompany = {};
    $scope.jobSkill = {};
    $scope.latestJob = {};

    function jobCategory() {
        $http.get(base_url + "job_live/jobCategory?limit=25").then(function (success) {
            $scope.jobCategory = success.data;
        }, function (error) {});
    }
    jobCategory();

    function jobCity() {
        $http.get(base_url + "job_live/jobCity?limit=25").then(function (success) {
            $scope.jobCity = success.data;
        }, function (error) {});
    }
    jobCity();
    function jobCompany() {
        $http.get(base_url + "job_live/jobCompany?limit=25").then(function (success) {
            $scope.jobCompany = success.data;
        }, function (error) {});
    }
    jobCompany();
    function jobSkill() {
        $http.get(base_url + "job_live/jobSkill?limit=25").then(function (success) {
            $scope.jobSkill = success.data;
        }, function (error) {});
    }
    jobSkill();

    function searchJob() {
        var search_data_url = '';
        if (q != '' && l == '' && w == '') {
            search_data_url = base_url + 'job_live/searchJobData?q=' + q;
        } else if (q == '' && l != '' && w == '') {
            search_data_url = base_url + 'job_live/searchJobData?l=' + l;
        } else if (q == '' && l == '' && w != '') {
            search_data_url = base_url + 'job_live/searchJobData?w=' + w;
        } else {
            search_data_url = base_url + 'job_live/searchJobData?q=' + q + '&l=' + l + '&w=' + w;
        }

        $http.get(search_data_url).then(function (success) {
            $scope.latestJob = success.data;
        }, function (error) {});
    }
    searchJob();

    $scope.applyJobFilter = function () {
        var d = $("#job-filter").serialize();
        $http({
            method: 'POST',
            url: base_url + 'job_live/applyJobFilter',
            data: d,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {
                    $scope.latestJob = success.data;
                });
    }
    $('#job-filter input').change(function () {
        $scope.applyJobFilter();
    });

});

$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
    $('#q').val(q);
    $('#l').val(l);
});