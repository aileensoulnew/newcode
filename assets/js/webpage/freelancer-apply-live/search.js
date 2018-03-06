app.controller('freelancerapplySearchListController', function ($scope, $http) {
    $scope.title = title;
//    $scope.businessCategory = {};
//    function businessCategory() {
//        $http.get(base_url + "business_live/businessCategory?limit=24").then(function (success) {
//            $scope.businessCategory = success.data;
//        }, function (error) {});
//    }
//    businessCategory();
//    function otherCategoryCount() {
//        $http.get(base_url + "business_live/otherCategoryCount").then(function (success) {
//            $scope.otherCategoryCount = success.data;
//        }, function (error) {});
//    }
//    otherCategoryCount();
    function searchBusiness() {
        var search_data_url = '';
        
         if(f == '' && p == ''){
            var time = "none";
        }else if (f == '') {
            var time = "part";
        } else if (p == '') {
            var time = "full";
        }else{
            var time = "both";
        }
        if (q != '' && l == '') {
            search_data_url = base_url + 'freelancer_apply_live/searchFreelancerApplyData?q=' + q+ '&t=' +time;
        } else if (q == '' && l != '') {
            search_data_url = base_url + 'freelancer_apply_live/searchFreelancerApplyData?l=' + l+ '&t=' +time;;
        } else {
            search_data_url = base_url + 'freelancer_apply_live/searchFreelancerApplyData?q=' + q + '&l=' + l+ '&t=' +time;;
        }
        
        $http.get(search_data_url).then(function (success) {
            $scope.freepostapply = success.data;
        }, function (error) {});
    }
    searchBusiness();

});

$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
    $('#q').val(q);
    $('#l').val(l);
});