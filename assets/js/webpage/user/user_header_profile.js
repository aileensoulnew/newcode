//app.filter('capitalize', function() {
//    return function(input) {
//      return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
//    }
//});
app.filter('capitalize', function () {
    return function (str) {
        if (str === undefined) {
            return false;
        }
        return str.split(" ").map(function (input) {
            return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : ''
        }).join(" ");

    }
});
app.controller('headerCtrl', function ($scope, $http) {
    contactRequestCount();
    
    function contactRequestCount(){
        $http({
            method: 'POST',
            url: base_url + 'userprofile/contactRequestCount',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            contact_request = success.data;
            $scope.contact_request_count = contact_request.total;
        });
    }

    $scope.header_all_profile = function () {
        $('.all .dropdown-menu').html(header_all_profile);
        $(document).find('.business_popup .dropdown-menu').html(header_all_profile);
    }

    $scope.header_contact_request = function () {
        
        $("#contact_loader").show();
        $http({
            method: 'POST',
            url: base_url + 'userprofile/contact_request',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            $("#contact_loader").hide();
            contact_request = success.data;
            $scope.contact_request_data = contact_request;
            $scope.contact_request_count = '0';
        });
    }

    $scope.confirmContactRequest = function (from_id,index) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile/contactRequestAction',
            data: 'from_id=' + from_id + '&action=confirm',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            $scope.contact_request_data.splice(index, 1);
        });
    }

    $scope.rejectContactRequest = function (from_id,index) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile/contactRequestAction',
            data: 'from_id=' + from_id + '&action=reject',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            $scope.contact_request_data.splice(index, 1);
        });
    }
});
$(".dropdown-menu").click(function (event) {
    $(this).parent('li').addClass('open');
    event.stopPropagation();
});