app.controller('businessSearchListController', function ($scope, $http) {
    $scope.title = title;
    $scope.businessCategory = {};
    function businessCategory() {
        $http.get(base_url + "business_live/businessCategory?limit=24").then(function (success) {
            $scope.businessCategory = success.data;
        }, function (error) {});
    }
    businessCategory();
    function otherCategoryCount() {
        $http.get(base_url + "business_live/otherCategoryCount").then(function (success) {
            $scope.otherCategoryCount = success.data;
        }, function (error) {});
    }
    otherCategoryCount();
    function searchBusiness() {
        var search_data_url = '';
        if (q != '' && l == '') {
            search_data_url = base_url + 'business_live/searchBusinessData?q=' + q;
        } else if (q == '' && l != '') {
            search_data_url = base_url + 'business_live/searchBusinessData?l=' + l;
        } else {
            search_data_url = base_url + 'business_live/searchBusinessData?q=' + q + '&l=' + l;
        }
        
        $http.get(search_data_url).then(function (success) {
            $scope.businessList = success.data;
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