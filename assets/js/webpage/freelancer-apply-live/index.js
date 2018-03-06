app.controller('freeapplypostController', function ($scope, $http) {
//    $scope.title = title;
    $scope.freelancerapplypost = {};
    $scope.freelancerCategory = {};

    function freelancerapplypost() {
        $http.get(base_url + "freelancer_apply_live/freelancer_apply_live_post").then(function (success) {
            $scope.freepostapply = success.data;
        }, function (error) {});
    }

    freelancerapplypost();

    function freelancerCategory() {alert(222);
        $http.get(base_url + "freelancer_apply_live/freelancerCategory?limit=25").then(function (success) {
            $scope.freelancerCategory = success.data;
        }, function (error) {});
    }
    freelancerCategory();

});



$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});