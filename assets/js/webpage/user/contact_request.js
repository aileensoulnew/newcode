app.controller('contactRequestController', function ($scope, $http) {
    pending_contact_request();
    var offset="40";
    var processing = false;
    getContactSuggetion(offset);
    contactRequestNotification();
    function getContactSuggetion(start) {

        // $http.get(base_url + "user_post/getContactAllSuggetion").then(function (success) {
        //     $scope.contactSuggetion = success.data;
        // }, function (error) {});
        $http({
            method: 'POST',
            url: base_url + 'user_post/getContactAllSuggetion',
            //data: 'from_id=' + from_id + '&action=confirm',
            data:'offset='+start,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {

            if (success.data) {
 
                offset=parseInt(offset)+40;
                processing = false;
                $scope.contactSuggetion = success.data;
               
            } else {
                 console.log('processing true')
                processing = true;
            }
        });
    }
    function pending_contact_request() {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/pending_contact_request',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            pending_contact_request = success.data;
            $scope.pending_contact_request_data = pending_contact_request;
        });
    }
    function contactRequestNotification() {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/contactRequestNotification',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            contactRequestNotification = success.data;
            $scope.contactRequestNotification = contactRequestNotification;
        });
    }
    $scope.confirmContact = function (from_id, index) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile/contactRequestAction',
            data: 'from_id=' + from_id + '&action=confirm',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            if (success.data) {
                $scope.pending_contact_request_data.splice(index, 1);
            }
        });
    }

    $scope.rejectContact = function (from_id, index) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile/contactRequestAction',
            data: 'from_id=' + from_id + '&action=reject',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            if (success.data) {
                $scope.pending_contact_request_data.splice(index, 1);
            }
        });
    }
    $scope.addToContact = function (user_id, suggest) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/addToContact',
            data: 'user_id=' + user_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            if (success.data.message == 1) {
                $('#item-' + user_id + ' a.btn3').html('Request Send');
//                $('.owl-carousel').trigger('next.owl.carousel');
            }
        });
    }

    $(document).ready(function () {
  
        $(document).scroll(function(e){
          
            if (processing)
                return false;

            if ( $(window).scrollTop() >= ($(document).height() - $(window).height())*0.7 ){
                processing = true; //sets a processing AJAX request flag
                
                getContactSuggetion(offset)
            }
        });
    });
});
$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});

