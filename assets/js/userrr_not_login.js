var User = function () {
    var Fblogin = function () {
        window.fbAsyncInit = function () {
            FB.init({
                appId: '733552333461096',
                xfbml: true,
                version: 'v2.8'
            });
        };

        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        $('.facebook_ac').on('click', function () {
            
            FB.login(function (response) {
                if (response.authResponse) {
                    FB.api('/me?fields=id,name,email,permissions,first_name,gender,last_name', function (response) {
                        console.log(response);

                       

                        $.ajax({
                            url: 'https://www.aileensoul.com/login/fblogin', // form action url
                            type: 'POST', // form submit method get/post
                            dataType: 'JSON', // request type html/json/xml
                            data: response, // serialize form data
                            beforeSend: function () {
                                //on CLick after Call
                                //btn_dis.attr('disabled', 'disabled');
                            },
                            success: function (data) {
                            // Success Data
                                if (data['status'] == true) {
                                    $userid = data['userid'];
                                    window.location = "https://www.aileensoul.com/registration/index/" + $userid;
                                } else {
                                    alert("Sorry, please try again");
                                }
                            },
                            error: function (e) {// Error data
                                console.log(e);
                            }
                        });

                    });
                } else {
                    alert('User cancelled login or did not fully authorize.');
                }
            });
        });
    }

    var GoogleLogin = function () {
        // login Google
        $('.google_ac_l').live('click', function () {
            gapi.load('auth2', function () {
                // Retrieve the singleton for the GoogleAuth library and set up the client.
                auth2 = gapi.auth2.init({
                    client_id: '915145699322-ufhclpk3k90bvt2v5u31s2ai35jg8j9j.apps.googleusercontent.com',
                    cookiepolicy: 'single_host_origin',
                    // Request scopes in addition to 'profile' and 'email'
                    //scope: 'additional_scope'
                });
                Google_attachSignin(document.getElementById('google_ac_l'));
            });
        });

        // register Signup
        $('.google_ac_r').live('click', function () {
            gapi.load('auth2', function () {
                // Retrieve the singleton for the GoogleAuth library and set up the client.
                auth2 = gapi.auth2.init({
                    client_id: '915145699322-ufhclpk3k90bvt2v5u31s2ai35jg8j9j.apps.googleusercontent.com',
                    cookiepolicy: 'single_host_origin',
                    // Request scopes in addition to 'profile' and 'email'
                    //scope: 'additional_scope'
                });
                Google_attachSignin(document.getElementById('google_ac_r'));
            });
        });
    }

    var Google_attachSignin = function (element) {
        auth2.attachClickHandler(element, {},
            function (googleUser) {
                var ginfo = googleUser.getBasicProfile(),
                    Userinfo = {
                        'name': ginfo.getName(),
                        'givename': ginfo.getGivenName(),
                        'familyname': ginfo.getFamilyName(),
                        'image': ginfo.getImageUrl(),
                        'email': ginfo.getEmail(),
                        'id': ginfo.getId()
                    };

                $.ajax({
                    url: base_url, // form action url
                    type: 'POST', // form submit method get/post
                    dataType: 'JSON', // request type html/json/xml
                    data: Userinfo, // serialize form data
                    beforeSend: function () {
                        //on CLick after Call
                        //btn_dis.attr('disabled', 'disabled');
                    },
                    success: function (data) {// Success Data
                        if (data['status'] == true) {
                            location.reload();
                        } else {
                            alert("Sorry, please try again");
                        }
                    },
                    error: function (e) {// Error data
                        console.log(e);
                    }
                });
                //console.log(Userinfo);
            }, function (error) {
                alert(JSON.stringify(error, undefined, 2));
            });
    }

    return {
        //main function to initiate the module
        init: function () {
            Fblogin();
            GoogleLogin();
        }
    };

}();
jQuery(document).ready(function () {
    User.init();
});