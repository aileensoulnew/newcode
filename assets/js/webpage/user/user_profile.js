app.filter('wordFirstCase', function () {
    return function (text) {
        return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
    };
});
app.filter('slugify', function () {
    return function (input) {
        if (!input)
            return;

        // make lower case and trim
        var slug = input.toLowerCase().trim();

        // replace invalid chars with spaces
        slug = slug.replace(/[^a-z0-9\s-]/g, ' ');

        // replace multiple spaces or hyphens with a single hyphen
        slug = slug.replace(/[\s-]+/g, '-');

        return slug;
    };
});
app.directive("owlCarousel", function () {
    return {
        restrict: 'E',
        link: function (scope) {
            scope.initCarousel = function (element) {
                // provide any default options you want
                var defaultOptions = {
                    loop: false,
                    nav: true,
                    lazyLoad: true,
                    margin: 0,
                    video: true,
                    responsive: {
                        0: {
                            items: 2
                        },
                        600: {
                            items: 2
                        },
                        960: {
                            items: 2,
                        },
                        1200: {
                            items: 2
                        }
                    }
                };
                var customOptions = scope.$eval($(element).attr('data-options'));
                // combine the two options objects
                for (var key in customOptions) {
                    defaultOptions[key] = customOptions[key];
                }
                // init carousel
                $(element).owlCarousel(defaultOptions);
            };
        }
    };
});
app.directive('owlCarouselItem', [function () {
        return {
            restrict: 'A',
            link: function (scope, element) {
                // wait for the last item in the ng-repeat then call init
                if (scope.$last) {
                    scope.initCarousel(element.parent());
                }
            }
        };
    }]);
app.directive('fileInput', function ($parse) {
    return {
        restrict: 'A',
        link: function ($scope, element, attrs) {
            $(element).fileinput({
                uploadUrl: '#',
                allowedFileExtensions: ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg', 'mp4', 'mp3', 'pdf'],
                overwriteInitial: false,
                maxFileSize: 1000000,
                maxFilesNum: 10,
                //allowedFileTypes: ['image','video', 'flash'],
                slugCallback: function (filename) {
                    return filename.replace('(', '_').replace(']', '_');
                }
            });
            element.on("change", function (event) {
                var files = event.target.files;
                $parse(attrs.fileInput).assign($scope, element[0].files);
                $scope.$apply();
            });
        }
    };
});

// AUTO SCROLL MESSAGE DIV FIRST TIME END
app.directive('ngEnter', function () {			// custom directive for sending message on enter click
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if (event.which === 13 && !event.shiftKey) {
                scope.$apply(function () {
                    scope.$eval(attrs.ngEnter);
                });
                event.preventDefault();
            }
        });
    };
});
app.directive("editableText", function () {
    return {
        controller: 'EditorController',
        restrict: 'C',
        replace: true,
        transclude: true,
    };
});
app.controller('EditorController', ['$scope', function ($scope) {
        $scope.handlePaste = function (e) {
            e.preventDefault();
            e.stopPropagation();
            var value = e.originalEvent.clipboardData.getData("Text");
            document.execCommand('inserttext', false, value);
        };
    }]);


app.controller('userProfileController', function ($scope, $http) {
    $scope.active = $scope.active == item ? '' : item;
    $scope.makeActive = function (item) {
        $scope.active = $scope.active == item ? '' : item;
    }
    $scope.live_slug = live_slug;
    $scope.segment2 = segment2;
    $scope.user_slug = user_data_slug;
    $scope.to_id = to_id;
    $scope.contact_value = contact_value;
    $scope.contact_status = contact_status;
    $scope.contact_id = contact_id;
    $scope.follow_value = follow_value;
    $scope.follow_status = follow_status;
    $scope.follow_id = follow_id;

    $scope.contact = function (id, status, to_id) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/addcontact',
            data: 'contact_id=' + id + '&status=' + status + '&to_id=' + to_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {
                    $scope.contact_value = success.data;
                });
    }
    $scope.follow = function (id, status, to_id) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/addfollow',
            data: 'follow_id=' + id + '&status=' + status + '&to_id=' + to_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {
                    $scope.follow_value = success.data;
                });
    }
});
app.config(function ($routeProvider, $locationProvider) {
    $routeProvider
            .when("/profiles/:name*", {
                templateUrl: base_url + "userprofile_page/profile",
                controller: 'profilesController'
            })
            .when("/dashboard/:name*", {
                templateUrl: base_url + "userprofile_page/dashboard",
                controller: 'dashboardController'
            })
            .when("/details/:name*", {
                templateUrl: base_url + "userprofile_page/details",
                controller: 'detailsController'
            })
            .when("/contacts/:name*", {
                templateUrl: base_url + "userprofile_page/contacts",
                controller: 'contactsController'
            })
            .when("/followers/:name*", {
                templateUrl: base_url + "userprofile_page/followers",
                controller: 'followersController'
            })
            .when("/following/:name*", {
                templateUrl: base_url + "userprofile_page/following",
                controller: 'followingController'
            })
            .when("/questions/:name*", {
                templateUrl: base_url + "userprofile_page/questions",
                controller: 'questionsController'
            })
    $locationProvider.html5Mode(true);
});
app.controller('profilesController', function ($scope, $http, $location) {
    $scope.user = {};
    // PROFEETIONAL DATA

    getFieldList();
    function getFieldList() {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/profiles_data',
            data: 'u=' + user_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            details_data = success.data;
            $scope.details_data = details_data;
        });
        
        $('footer').show();
    }
});
app.controller('dashboardController', function ($scope, $http, $location) {
    $scope.opp = {};
    $scope.sim = {};
    $scope.ask = {};
    $scope.postData = {};
    $scope.opp.post_for = 'opportunity';
    $scope.sim.post_for = 'simple';
    $scope.ask.post_for = 'question';
    getUserDashboardPost();
    getUserDashboardImage();
    getUserDashboardVideo();
    getUserDashboardInformation()
    getUserDashboardAudio();
    getUserDashboardPdf();

    $(window).on('scroll', function () {
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            var page = $(".page_number:last").val();
            var total_record = $(".total_record").val();
            var perpage_record = $(".perpage_record").val();
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($(".page_number:last").val()) + 1;
                    getUserDashboardPostLoad(pagenum);
                }
            }
        }
    });
    function getUserDashboardPost(pagenum = '') {
        $('#loader').show();
        $http.get(base_url + "user_post/getUserDashboardPost?page=" + pagenum + "&user_slug=" + user_slug).then(function (success) {
            $('#loader').hide();
            $scope.postData = success.data;
            check_no_post_data();
            $('video,audio').mediaelementplayer(/* Options */);
        }, function (error) {});
    }

    function getUserDashboardPostLoad(pagenum = '') {
        $('#loader').show();
        $http.get(base_url + "user_post/getUserDashboardPost?page=" + pagenum + "&user_slug=" + user_slug).then(function (success) {
            $('#loader').hide();
            for (var i in success.data) {
                $scope.postData.push(success.data[i]);
            }
            check_no_post_data();
            $('video,audio').mediaelementplayer(/* Options */);
        }, function (error) {});
    }

    function getUserDashboardImage(pagenum = '') {
        $('#loader').show();
        $http.get(base_url + "user_post/getUserDashboardImage?user_slug=" + user_slug).then(function (success) {
            $('#loader').hide();
            $scope.postImageData = success.data.userDashboardImage;
        }, function (error) {});
    }

    function getUserDashboardVideo(pagenum = '') {
        $('#loader').show();
        $http.get(base_url + "user_post/getUserDashboardVideo?user_slug=" + user_slug).then(function (success) {
            $('#loader').hide();
            $scope.postVideoData = success.data.userDashboardVideo;
//            $('video,audio').mediaelementplayer(/* Options */);
        }, function (error) {});
    }

     function getUserDashboardInformation() {
        $('#loader').show();
      
        $('footer').hide();
       $http({
            method: 'POST',
            url: base_url + 'userprofile_page/detail_data',
            data: 'u=' + user_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            details_data = success.data;
            $scope.details_data = details_data;
        });
    }

    function getUserDashboardAudio(pagenum = '') {
        $('#loader').show();
        $http.get(base_url + "user_post/getUserDashboardAudio?user_slug=" + user_slug).then(function (success) {
            $('#loader').hide();
            $scope.postAudioData = success.data.userDashboardAudio;
//            $('video,audio').mediaelementplayer(/* Options */);
        }, function (error) {});
    }

    function getUserDashboardPdf(pagenum = '') {
        $('#loader').show();
        $http.get(base_url + "user_post/getUserDashboardPdf?user_slug=" + user_slug).then(function (success) {
            $('#loader').hide();
            $scope.postPdfData = success.data.userDashboardPdf;
            $('video,audio').mediaelementplayer(/* Options */);
        }, function (error) {});
    }

    getFieldList();
    function getFieldList() {
        $http.get(base_url + "general_data/getFieldList").then(function (success) {
            $scope.fieldList = success.data;
        }, function (error) {});
    }
    getContactSuggetion();
    function getContactSuggetion() {
        $http.get(base_url + "user_post/getContactSuggetion").then(function (success) {
            $scope.contactSuggetion = success.data;
//            console.log($scope.contactSuggetion);
        }, function (error) {});
    }
    $scope.job_title = [];
    $scope.loadJobTitle = function ($query) {
        return $http.get(base_url + 'user_post/get_jobtitle', {cache: true}).then(function (response) {
            var job_title = response.data;
            return job_title.filter(function (title) {
                return title.name.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };
    $scope.location = [];
    $scope.loadLocation = function ($query) {
        return $http.get(base_url + 'user_post/get_location', {cache: true}).then(function (response) {
            var location_data = response.data;
            return location_data.filter(function (location) {
                return location.city_name.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };

    $scope.category = [];
    $scope.loadCategory = function ($query) {
        return $http.get(base_url + 'user_post/get_category', {cache: true}).then(function (response) {
            var category_data = response.data;
            return category_data.filter(function (category) {
                return category.name.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };


    $scope.postFiles = function () {
        var a = document.getElementById('description').value;
        var b = document.getElementById('job_title').value;
        var c = document.getElementById('location').value;
        var d = document.getElementById('field').value;
        document.getElementById("post_opportunity").reset();
        document.getElementById('description').value = a;
        document.getElementById('job_title').value = b;
        document.getElementById('location').value = c;
        document.getElementById('field').value = d;
    }

    $scope.post_opportunity_check = function (event) {

        if (document.getElementById("opp_edit_post_id")) {
            var post_id = document.getElementById("opp_edit_post_id").value;
        } else {
            var post_id = 0;
        }
        if (post_id == 0) {
            var fileInput = document.getElementById("fileInput").files;
            var description = document.getElementById("description").value;
            var description = description.trim();
            var job_title = $scope.opp.job_title;
            var location = $scope.opp.location;
            var fileInput1 = document.getElementById("fileInput").value;

            

              if ( fileInput1 == '' || description == '' ||  job_title == undefined  || location == undefined ) 
            {
                $('#post .mes').html("<div class='pop_content'>This post appears to be blank. Please write or attach (photos, videos, audios, pdf) to post.");
                $('#post').modal('show');
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                event.preventDefault();
                return false;
            } else {
                for (var i = 0; i < fileInput.length; i++)
                {
                    var vname = fileInput[i].name;
                    var vfirstname = fileInput[0].name;
                    var ext = vfirstname.split('.').pop();
                    var ext1 = vname.split('.').pop();
                    var allowedExtensions = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg'];
                    var allowesvideo = ['mp4', 'webm', 'mov', 'MP4'];
                    var allowesaudio = ['mp3'];
                    var allowespdf = ['pdf'];

                    var foundPresent = $.inArray(ext, allowedExtensions) > -1;
                    var foundPresentvideo = $.inArray(ext, allowesvideo) > -1;
                    var foundPresentaudio = $.inArray(ext, allowesaudio) > -1;
                    var foundPresentpdf = $.inArray(ext, allowespdf) > -1;

                    if (foundPresent == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowedExtensions) > -1;
                        if (foundPresent1 == true && fileInput.length <= 10) {
                        } else {
                            $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf.");
                            $('#posterrormodal').modal('show');
                            setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentvideo == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowesvideo) > -1;
                        if (foundPresent1 == true && fileInput.length == 1) {
                        } else {
                            $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf.");
                            $('#posterrormodal').modal('show');
                            setInterval('window.location.reload()', 10000);

                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentaudio == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowesaudio) > -1;
                        if (foundPresent1 == true && fileInput.length == 1) {

                            /*if (product_name == '') {
                             $('.biderror .mes').html("<div class='pop_content'>You have to add audio title.");
                             $('#posterrormodal').modal('show');
                             //setInterval('window.location.reload()', 10000);
                             
                             $(document).on('keydown', function (e) {
                             if (e.keyCode === 27) {
                             //$( "#bidmodal" ).hide();
                             $('#posterrormodal').modal('hide');
                             $('.modal-post').show();
                             }
                             });
                             event.preventDefault();
                             return false;
                             } */

                        } else {
                            $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf.");
                            $('#posterrormodal').modal('show');
                            setInterval('window.location.reload()', 10000);

                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentpdf == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowespdf) > -1;
                        if (foundPresent1 == true && fileInput.length == 1) {

                            /*if (product_name == '') {
                             $('.biderror .mes').html("<div class='pop_content'>You have to add pdf title.");
                             $('#posterrormodal').modal('show');
                             setInterval('window.location.reload()', 10000);
                             
                             $(document).on('keydown', function (e) {
                             if (e.keyCode === 27) {
                             $('#posterrormodal').modal('hide');
                             $('.modal-post').show();
                             }
                             });
                             event.preventDefault();
                             return false;
                             } */
                        } else {
                            if (fileInput.length > 10) {
                                $('.biderror .mes').html("<div class='pop_content'>You can not upload more than 10 files at a time.");
                            } else {
                                $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf.");
                            }
                            $('#posterrormodal').modal('show');
                            setInterval('window.location.reload()', 10000);

                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();

                                }
                            });
                            event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentvideo == false) {

                        $('.biderror .mes').html("<div class='pop_content'>This File Format is not supported Please Try to Upload MP4 or WebM files..");
                        $('#posterrormodal').modal('show');
                        setInterval('window.location.reload()', 10000);

                        $(document).on('keydown', function (e) {
                            if (e.keyCode === 27) {
                                $('#posterrormodal').modal('hide');
                                $('.modal-post').show();

                            }
                        });
                        event.preventDefault();
                        return false;
                    }
                }

                var form_data = new FormData();
                $.each($("#fileInput")[0].files, function(i, file) {
                    form_data.append('postfiles[]', file);
                });

                form_data.append('description', $scope.opp.description);
                form_data.append('field', $scope.opp.field);
                form_data.append('job_title', JSON.stringify($scope.opp.job_title));
                form_data.append('location', JSON.stringify($scope.opp.location));
                form_data.append('post_for', $scope.opp.post_for);

                $('body').removeClass('modal-open');
                $("#opportunity-popup").modal('hide');

                $('.post_loader').show();
                $http.post(base_url + 'user_post/post_opportunity', form_data,
                        {
                            transformRequest: angular.identity,

                            headers: {'Content-Type': undefined, 'Process-Data': false}
                        })
                        .then(function (success) {

                            if (success) {
                                  $('.post_loader').hide();
                                $scope.opp.description = '';
                                $scope.opp.job_title = '';
                                $scope.opp.location = '';
                                $scope.opp.field = '';
                                $scope.opp.postfiles = '';
                                document.getElementById('fileInput').value = '';

                                $('.file-preview-thumbnails').html('');
                                $scope.postData.splice(0, 0, success.data[0]);
                                $('video, audio').mediaelementplayer();
                            }
                        });
            }

        } else {
            var description = document.getElementById("description").value;
            var description = description.trim();
            var job_title = $scope.opp.job_title;
            var location = $scope.opp.location;

            if ((description == '' || job_title.length == '0' || location.length == '0'))
            //            if ((job_title.length == '0' || location.length == '0'))
            {
                $('#post .mes').html("<div class='pop_content'>This post appears to be blank. Please write to post.");
                $('#post').modal('show');
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                event.preventDefault();
                return false;
            } else {


                var form_data = new FormData();

                form_data.append('description', $scope.opp.description);
                form_data.append('field', $scope.opp.field);
                form_data.append('job_title', JSON.stringify($scope.opp.job_title));
                form_data.append('location', JSON.stringify($scope.opp.location));
                form_data.append('post_for', $scope.opp.post_for);
                form_data.append('post_id', post_id);

                $('body').removeClass('modal-open');
                $("#opportunity-popup").modal('hide');


                $http.post(base_url + 'user_post/edit_post_opportunity', form_data,
                        {
                            transformRequest: angular.identity,

                            headers: {'Content-Type': undefined, 'Process-Data': false}
                        })
                        .then(function (success) {

                            if (success.data.response == 1) {
                                $('#opp-post-opportunity-for-' + post_id).html(success.data.opp_opportunity_for);
                                $('#opp-post-location-' + post_id).html(success.data.opp_location);
                                $('#opp-post-field-' + post_id).html(success.data.opp_field);
                                $('#opp-post-opportunity-' + post_id).html($scope.opp.description);

                                //                                $scope.opp.description = '';
                                //                                $scope.opp.job_title = '';
                                //                                $scope.opp.location = '';
                                //                                $scope.opp.field = '';
                                //                                $scope.opp.postfiles = '';
                            }

                        });
            }

        }
    }
    $scope.IsVisible = false;
    $scope.ShowHide = function () {
        //If DIV is visible it will be hidden and vice versa.
        $scope.IsVisible = $scope.IsVisible ? false : true;
    }


    $scope.questionList = function () {
        $http({
            method: 'POST',
            url: base_url + 'general_data/searchQuestionList',
            data: 'q=' + $scope.ask.ask_que,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {
                    data = success.data;
                    $scope.queSearchResult = data;
                });
    }
    $scope.ask_question_check = function (event) {

        if (document.getElementById("ask_edit_post_id")) {
            var post_id = document.getElementById("ask_edit_post_id").value;
        } else {
            var post_id = 0;
        }
        if (post_id == 0) {
            var field = document.getElementById("ask_field").value;
            var description = document.getElementById("ask_que").value;
            var description = description.trim();
            var fileInput = document.getElementById("fileInput2").files;
            if ((field == '') || (description == ''))
            {
                $('#post .mes').html("<div class='pop_content'>Ask question and Field is required.");
                $('#post').modal('show');
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                event.preventDefault();
                return false;
            } else {
//                var length = fileInput.length;
//                var vfirstname = fileInput[0].name;
//                var ext = vfirstname.split('.').pop();
//                var ext1 = vfirstname.split('.').pop();
//                var allowedExtensions = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg'];
//                var foundPresent = $.inArray(ext, allowedExtensions) > -1;
//                if (foundPresent == true)
//                {
//                    var foundPresent1 = $.inArray(ext1, allowedExtensions) > -1;
//
//                }
                var form_data = new FormData();
                angular.forEach($scope.files, function (file) {
                    form_data.append('postfiles[]', file);
                });
                //form_data.append('postfiles',$scope.ask.postfiles);
                form_data.append('question', $scope.ask.ask_que);
                form_data.append('description', $scope.ask.ask_description);
                form_data.append('field', $scope.ask.ask_field);
                form_data.append('other_field', $scope.ask.otherField);
                form_data.append('category', JSON.stringify($scope.ask.related_category));
                form_data.append('weblink', $scope.ask.web_link);
                form_data.append('post_for', $scope.ask.post_for);
                form_data.append('is_anonymously', $scope.ask.is_anonymously);

                $('body').removeClass('modal-open');
                $("#opportunity-popup").modal('hide');
                $("#ask-question").modal('hide');
                $('.post_loader').show();

                $.each($("#fileInput2")[0].files, function(i, file) {
                    form_data.append('postfiles[]', file);
                });

                $http.post(base_url + 'user_post/post_opportunity', form_data,
                        {
                            transformRequest: angular.identity,

                            headers: {'Content-Type': undefined, 'Process-Data': false}
                        })
                        .then(function (success) {
                            if (success) {
                                $('.post_loader').hide();
                                $scope.opp.description = '';
                                $scope.opp.job_title = '';
                                $scope.opp.location = '';
                                $scope.opp.field = '';
                                $scope.opp.postfiles = '';
                                document.getElementById('fileInput2').value = '';
                                $('.file-preview-thumbnails').html('');
                                $scope.ask.postfiles = '';
                                $scope.ask.ask_que = '';
                                $scope.ask.ask_description = '';
                                $scope.ask.ask_field = '';
                                $scope.ask.otherField = '';
                                $scope.ask.related_category = '';
                                $scope.ask.web_link = '';
                                $scope.ask.post_for = '';
                                $scope.ask.is_anonymously = '';

                                $scope.postData.splice(0, 0, success.data[0]);
                                $('video, audio').mediaelementplayer();
                            }
                        });
            }

        } else {

            var field = document.getElementById("ask_field").value;
            var description = document.getElementById("ask_que").value;
            var description = description.trim();
            if ((field == '') || (description == ''))
            {
                $('#post .mes').html("<div class='pop_content'>Ask question and Field is required.");
                $('#post').modal('show');
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                event.preventDefault();
                return false;
            } else {


                var form_data = new FormData();

                form_data.append('question', $scope.ask.ask_que);
                form_data.append('description', $scope.ask.ask_description);
                form_data.append('field', $scope.ask.ask_field);
                form_data.append('other_field', $scope.ask.otherField);
                form_data.append('category', JSON.stringify($scope.ask.related_category));
                form_data.append('weblink', $scope.ask.web_link);
                form_data.append('post_for', $scope.ask.post_for);
                form_data.append('is_anonymously', $scope.ask.is_anonymously);
                form_data.append('post_id', post_id);
                $('body').removeClass('modal-open');
                $("#opportunity-popup").modal('hide');
                $("#ask-question").modal('hide');
                $http.post(base_url + 'user_post/edit_post_opportunity', form_data,
                        {
                            transformRequest: angular.identity,

                            headers: {'Content-Type': undefined, 'Process-Data': false}
                        })
                        .then(function (success) {
                            if (success) {
                                if (success.data.response == 1) {
                                    $('#ask-post-question-' + post_id).html(success.data.ask_question);
                                    $('#ask-post-description-' + post_id).html(success.data.ask_description);
                                    //   $('#ask-post-link-' + post_id).html(success.data.opp_field);
                                    $('#ask-post-category-' + post_id).html(success.data.ask_category);
                                    $('#ask-post-field-' + post_id).html(success.data.ask_field);
                                }
                                $scope.opp.description = '';
                                $scope.opp.job_title = '';
                                $scope.opp.location = '';
                                $scope.opp.field = '';
                                $scope.opp.postfiles = '';
                                document.getElementById('fileInput').value = '';

                                $scope.ask.postfiles = '';
                                $scope.ask.ask_que = '';
                                $scope.ask.ask_description = '';
                                $scope.ask.ask_field = '';
                                $scope.ask.otherField = '';
                                $scope.ask.related_category = '';
                                $scope.ask.web_link = '';
                                $scope.ask.post_for = '';
                                $scope.ask.is_anonymously = '';

                                $scope.postData.splice(0, 0, success.data[0]);
                                $('video, audio').mediaelementplayer();
                            }
                        });
            }
        }
    }
    
    
       
     $scope.lightbox = function (idx) {
                 //show the slider's wrapper: this is required when the transitionType has been set to "slide" in the ninja-slider.js
            var ninjaSldr = document.getElementById("ninja-slider");
            ninjaSldr.parentNode.style.display = "block";

            nslider.init(idx);

            var fsBtn = document.getElementById("fsBtn");
            fsBtn.click();
  
    };
    
    function fsIconClick(isFullscreen, ninjaSldr) { //fsIconClick is the default event handler of the fullscreen button
            if (isFullscreen) {
                ninjaSldr.parentNode.style.display = "none";
            }
        }


    // POST SOMETHING UPLOAD START

    $scope.post_something_check = function (event) {
        alert('test');
        if (document.getElementById("edit_post_id")) {
            var post_id = document.getElementById("edit_post_id").value;
        } else {
            var post_id = 0;
        }
        if (post_id == 0) {
            var fileInput = document.getElementById("fileInput1").files;

            var description = document.getElementById("description").value;
            var description = description.trim();
            var fileInput1 = document.getElementById("fileInput1").value;

            if (fileInput1 == '' && description == '')
            {
                $('#post .mes').html("<div class='pop_content'>This post appears to be blank. Please write or attach (photos, videos, audios, pdf) to post.");
                $('#post').modal('show');
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                event.preventDefault();
                return false;
            } else {
                for (var i = 0; i < fileInput.length; i++)
                {
                    var vname = fileInput[i].name;
                    var vfirstname = fileInput[0].name;
                    var ext = vfirstname.split('.').pop();
                    var ext1 = vname.split('.').pop();
                    var allowedExtensions = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg'];
                    var allowesvideo = ['mp4', 'webm', 'mov', 'MP4'];
                    var allowesaudio = ['mp3'];
                    var allowespdf = ['pdf'];

                    var foundPresent = $.inArray(ext, allowedExtensions) > -1;
                    var foundPresentvideo = $.inArray(ext, allowesvideo) > -1;
                    var foundPresentaudio = $.inArray(ext, allowesaudio) > -1;
                    var foundPresentpdf = $.inArray(ext, allowespdf) > -1;

                    if (foundPresent == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowedExtensions) > -1;
                        if (foundPresent1 == true && fileInput.length <= 10) {
                        } else {
                            $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf.");
                            $('#posterrormodal').modal('show');
                            setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentvideo == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowesvideo) > -1;
                        if (foundPresent1 == true && fileInput.length == 1) {
                        } else {
                            $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf.");
                            $('#posterrormodal').modal('show');
                            setInterval('window.location.reload()', 10000);

                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentaudio == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowesaudio) > -1;
                        if (foundPresent1 == true && fileInput.length == 1) {

                            /*if (product_name == '') {
                             $('.biderror .mes').html("<div class='pop_content'>You have to add audio title.");
                             $('#posterrormodal').modal('show');
                             //setInterval('window.location.reload()', 10000);
                             
                             $(document).on('keydown', function (e) {
                             if (e.keyCode === 27) {
                             //$( "#bidmodal" ).hide();
                             $('#posterrormodal').modal('hide');
                             $('.modal-post').show();
                             }
                             });
                             event.preventDefault();
                             return false;
                             } */

                        } else {
                            $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf.");
                            $('#posterrormodal').modal('show');
                            setInterval('window.location.reload()', 10000);

                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentpdf == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowespdf) > -1;
                        if (foundPresent1 == true && fileInput.length == 1) {

                            /*if (product_name == '') {
                             $('.biderror .mes').html("<div class='pop_content'>You have to add pdf title.");
                             $('#posterrormodal').modal('show');
                             setInterval('window.location.reload()', 10000);
                             
                             $(document).on('keydown', function (e) {
                             if (e.keyCode === 27) {
                             $('#posterrormodal').modal('hide');
                             $('.modal-post').show();
                             }
                             });
                             event.preventDefault();
                             return false;
                             } */
                        } else {
                            if (fileInput.length > 10) {
                                $('.biderror .mes').html("<div class='pop_content'>You can not upload more than 10 files at a time.");
                            } else {
                                $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf.");
                            }
                            $('#posterrormodal').modal('show');
                            setInterval('window.location.reload()', 10000);

                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();

                                }
                            });
                            event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentvideo == false) {

                        $('.biderror .mes').html("<div class='pop_content'>This File Format is not supported Please Try to Upload MP4 or WebM files..");
                        $('#posterrormodal').modal('show');
                        setInterval('window.location.reload()', 10000);

                        $(document).on('keydown', function (e) {
                            if (e.keyCode === 27) {
                                $('#posterrormodal').modal('hide');
                                $('.modal-post').show();

                            }
                        });
                        event.preventDefault();
                        return false;
                    }
                }

                var form_data = new FormData();
                $.each($("#fileInput1")[0].files, function(i, file) {
                    form_data.append('postfiles[]', file);
                });

                form_data.append('description', $scope.sim.description);
                form_data.append('post_for', $scope.sim.post_for);

                $('body').removeClass('modal-open');
                $("#post-popup").modal('hide');

                $('.post_loader').show();
                $http.post(base_url + 'user_post/post_opportunity', form_data,
                        {
                            transformRequest: angular.identity,
                            headers: {'Content-Type': undefined, 'Process-Data': false}
                        })
                        .then(function (success) {
                            if (success) {
                                $('.post_loader').hide();
                                $scope.sim.description = '';
                                $scope.sim.postfiles = '';
                                document.getElementById('fileInput1').value = '';
                                $('.file-preview-thumbnails').html('');
                                $scope.postData.splice(0, 0, success.data[0]);
                                $('video, audio').mediaelementplayer();
                            }
                        });
            }
        } else {
            var description = document.getElementById("description").value;
            var description = description.trim();
            if (description == '')
            {
                $('#post .mes').html("<div class='pop_content'>This post appears to be blank. Please write to post.");
                $('#post').modal('show');
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                event.preventDefault();
                return false;
            } else {
                var form_data = new FormData();
                form_data.append('description', $scope.sim.description);
                form_data.append('post_for', $scope.sim.post_for);
                form_data.append('post_id', post_id);

                $('body').removeClass('modal-open');
                $("#post-popup").modal('hide');
                $http.post(base_url + 'user_post/edit_post_opportunity', form_data,
                        {
                            transformRequest: angular.identity,
                            headers: {'Content-Type': undefined, 'Process-Data': false}
                        })
                        .then(function (success) {
                            if (success) {
                                if (success.data.response == 1) {
                                    $('#simple-post-description-' + post_id).html(success.data.sim_description);
                                }
                            }
                        });
            }

        }
    }

    $scope.loadMediaElement = function ()
    {
        $('video,audio').mediaelementplayer(/* Options */);
    };
    $scope.addToContact = function (user_id, contact) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/addToContact',
            data: 'user_id=' + user_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            if (success.data.message == 1) {
                var index = $scope.contactSuggetion.indexOf(contact);
                $('#item-' + user_id + ' button.follow-btn').html('Request Send');
//                $('.owl-carousel').trigger('next.owl.carousel');
            }
        });
    }

    $scope.post_like = function (post_id) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePost',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            if (success.data.message == 1) {
                if (success.data.is_newLike == 1) {
                    $('#post-like-' + post_id).addClass('like');
                    $('#post-like-count-' + post_id).html(success.data.likePost_count);
                    if (success.data.likePost_count == '0') {
                        $('#post-other-like-' + post_id).html('');
                    } else {
                        $('#post-other-like-' + post_id).html(success.data.post_like_data);
                    }
                } else if (success.data.is_oldLike == 1) {
                    $('#post-like-' + post_id).removeClass('like');
                    $('#post-like-count-' + post_id).html(success.data.likePost_count);
                    if (success.data.likePost_count == '0') {
                        $('#post-other-like-' + post_id).html('');
                    } else {
                        $('#post-other-like-' + post_id).html(success.data.post_like_data);
                    }
                }
            }
        });
    }

    $scope.sendComment = function (post_id, index, post) {
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        var comment = $('#commentTaxBox-' + post_id).html();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        if (comment) {
            $scope.isMsg = true;
            $http({
                method: 'POST',
                url: base_url + 'user_post/postCommentInsert',
                data: 'comment=' + comment + '&post_id=' + post_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
                    .then(function (success) {
                        data = success.data;
                        if (data.message == '1') {
                            if (commentClassName == 'last-comment') {
                                $scope.postData[index].post_comment_data.splice(0, 1);
                                $scope.postData[index].post_comment_data.push(data.comment_data[0]);
                                $('.post-comment-count-' + post_id).html(data.comment_count);
                                $('.editable_text').html('');
                            } else {
                                $scope.postData[index].post_comment_data.push(data.comment_data[0]);
                                $('.post-comment-count-' + post_id).html(data.comment_count);
                                $('.editable_text').html('');
                            }
                        }
                    });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }

    $scope.viewAllComment = function (post_id, index, post) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewAllComment',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {
                    data = success.data;
                    $scope.postData[index].post_comment_data = data.all_comment_data;
                });
    }

    $scope.viewLastComment = function (post_id, index, post) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewLastComment',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {
                    data = success.data;
                    $scope.postData[index].post_comment_data = data.comment_data;
                });
    }
    $scope.deletePostComment = function (comment_id, post_id, parent_index, index, post) {
        $scope.c_d_comment_id = comment_id;
        $scope.c_d_post_id = post_id;
        $scope.c_d_parent_index = parent_index;
        $scope.c_d_index = index;
        $scope.c_d_post = post;
        $('#delete_model').modal('show');
    }

    $scope.deleteComment = function (comment_id, post_id, parent_index, index, post) {
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePostComment',
            data: 'comment_id=' + comment_id + '&post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {
                    data = success.data;
                    if (commentClassName == 'last-comment') {
                        $scope.postData[parent_index].post_comment_data.splice(0, 1);
                        $scope.postData[parent_index].post_comment_data.push(data.comment_data[0]);
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    } else {
                        $scope.postData[parent_index].post_comment_data.splice(index, 1);
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    }
                });
    }

    $scope.likePostComment = function (comment_id, post_id) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePostComment',
            data: 'comment_id=' + comment_id + '&post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {
                    data = success.data;
                    if (data.message == '1') {
                        if (data.is_newLike == 1) {
                            $('#post-comment-like-' + comment_id).parent('a').addClass('like');
                            $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                        } else if (data.is_oldLike == 1) {
                            $('#post-comment-like-' + comment_id).parent('a').removeClass('like');
                            $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                        }

                    }
                });
    }
    $scope.editPostComment = function (comment_id, post_id, parent_index, index) {
        var editContent = $('#comment-dis-inner-' + comment_id).html();
        $('#edit-comment-' + comment_id).show();
        $('#editCommentTaxBox-' + comment_id).html(editContent);
        $('#comment-dis-inner-' + comment_id).hide();
    }

    $scope.EditPost = function (post_id, post_for, index) {
        $scope.is_edit = 1;

        $http({
            method: 'POST',
            url: base_url + 'user_post/getPostData',
            data: 'post_id=' + post_id + '&post_for=' + post_for,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {
                    $scope.is_edit = 1;
                    if (post_for == "opportunity") {
                        $scope.opp.description = success.data.opportunity;
                        $scope.opp.job_title = success.data.opportunity_for;
                        $scope.opp.location = success.data.location;
                        $scope.opp.field = success.data.field;
                        $scope.opp.edit_post_id = post_id;
                        $("#opportunity-popup").modal('show');

                    } else if (post_for == "simple") {
                        $scope.sim.description = success.data.description;
                        $scope.sim.edit_post_id = post_id;

                        $("#post-popup").modal('show');

                    } else if (post_for == "question") {
                        $scope.ask.ask_que = success.data.question;
                        $scope.ask.ask_description = success.data.description;
                        $scope.ask.related_category = success.data.tag_name;
                        $scope.ask.ask_field = success.data.field;
                        $scope.ask.edit_post_id = post_id;

                        $("#ask-question").modal('show');
                    }
                });


    }

    $scope.sendEditComment = function (comment_id) {
        var comment = $('#editCommentTaxBox-' + comment_id).html();
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        if (comment) {
            $scope.isMsg = true;
            $http({
                method: 'POST',
                url: base_url + 'user_post/postCommentUpdate',
                data: 'comment=' + comment + '&comment_id=' + comment_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
                    .then(function (success) {
                        data = success.data;
                        if (data.message == '1') {
                            $('#comment-dis-inner-' + comment_id).show();
                            $('#comment-dis-inner-' + comment_id).html(comment);
                            $('#edit-comment-' + comment_id).html();
                            $('#edit-comment-' + comment_id).hide();
                        }
                    });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }
    $scope.deletePost = function (post_id, index) {
        $scope.p_d_post_id = post_id;
        $scope.p_d_index = index;
        $('#delete_post_model').modal('show');
    }
    $scope.deletedPost = function (post_id, index) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePost',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {
                    data = success.data;
                    if (data.message == '1') {
                        $scope.postData.splice(index, 1);
                    }
                });
    }

    function check_no_post_data() {
        var numberPost = $scope.postData.length;
        if (numberPost == 0) {
            $('.all_user_post').html(no_user_post_html);
        }
    }
    
    $scope.like_user_list = function (post_id) {
        $http({
            method: 'POST',
            url: base_url + "user_post/likeuserlist",
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {
                    $scope.count_likeUser = success.data.countlike;
                    $scope.get_like_user_list = success.data.likeuserlist;
                    $('#likeusermodal').modal('show');

                });

    }

});
app.controller('detailsController', function ($scope, $http, $location) {
    $scope.user = {};
    // PROFEETIONAL DATA
    getFieldList();

    function getFieldList() {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/detail_data',
            data: 'u=' + user_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            details_data = success.data;
            $scope.details_data = details_data;
        });
        $('footer').show();
    }
    $scope.goMainLink = function (path) {
        location.href = path;
    }
    $scope.makeActive = function (item,slug) {

        $scope.active = $scope.active == item ? '' : item;
    }
});
app.controller('contactsController', function ($scope, $http, $location, $window) {
//    lazzy loader start
// Variables
    $scope.showLoadmore = true;
    $scope.row = 0;
    $scope.rowperpage = 3;
    $scope.buttonText = "Load More";

    // Fetch data
    $scope.getContacts = function (pagenum = '') {

        $http({
            method: 'post',
            url: base_url + "userprofile_page/contacts_data?page=" + pagenum+"&user_slug="+user_slug,
            data: {row: $scope.row, rowperpage: $scope.rowperpage}
        }).then(function successCallback(response) {
            if (response.data != '') {
                $scope.row += $scope.rowperpage;
                if ($scope.contactData != undefined) {
                    $scope.page_number = response.data.pagedata.page;
                    for (var i in response.data.contactrecord) {
                        $scope.contactData.push(response.data.contactrecord[i]);
                    }
                } else {
                    $scope.pagecntctData = response.data;
                    $scope.contactData = response.data.contactrecord;
                }
            } else {
                $scope.showLoadmore = false;
            }
            $('footer').show();
        });
    }
    angular.element($window).bind("scroll", function (e) {
        // console.log($(window).scrollTop());
        //    console.log($(document).height() - $(window).height());
        
        if (($(window).scrollTop()) == ($(document).height() - $(window).height())) {
          
          
            var page = $(".page_number").val();
            var total_record = $(".total_record").val();
            var perpage_record = $(".perpage_record").val();
            
           // alert(parseInt(perpage_record * page));
           // alert(total_record);
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($(".page_number").val()) + 1;
                    $scope.getContacts(pagenum);
                }
            }
        }
    });
    // Call function
    $scope.getContacts();
//    lazzy loader end

    $scope.user = {};
    var id = 1;
    $scope.remove = function (index) {
        $('#remove-contact .mes').html("<div class='pop_content'>Do you want to remove this post?<div class='model_ok_cancel'><a class='okbtn btn1' id=" + id + " onClick='remove_contacts(" + index + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn btn1' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
        $('#remove-contact').modal('show');
    }
    // PROFEETIONAL DATA
    $scope.goUserprofile = function (path) {
        location.href = base_url + 'profiles/' + path;
    }
});
app.controller('followersController', function ($scope, $http, $location, $compile, $window) {

    //    lazzy loader start
// Variables
    $scope.showLoadmore = true;
    $scope.row = 0;
    $scope.rowperpage = 3;
    $scope.buttonText = "Load More";
    // Fetch data
    $scope.getFollowers = function (pagenum = '') {

        $http({
            method: 'post',
            url: base_url + "userprofile_page/followers_data?page=" + pagenum,
            data: {row: $scope.row, rowperpage: $scope.rowperpage}
        }).then(function successCallback(response) {
            if (response.data != '') {
                $scope.row += $scope.rowperpage;
                if ($scope.contactData != undefined) {
                    $scope.page_number = response.data.pagedata.page;
                    for (var i in response.data.contactrecord) {
                        $scope.followersData.push(response.data.followerrecord[i]);
                    }
                } else {
                    $scope.pagecntctData = response.data;
                    $scope.followersData = response.data.followerrecord;
                }
            } else {
                $scope.showLoadmore = false;
            }
            $('footer').show();
        });
    }
    angular.element($window).bind("scroll", function (e) {
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            var page = $(".page_number").val();
            var total_record = $(".total_record").val();
            var perpage_record = $(".perpage_record").val();
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($(".page_number").val()) + 1;
                    // alert(pagenum);
                    $scope.getFollowers(pagenum);
                }
            }
        }
    });
    // Call function
    $scope.getFollowers();
//    lazzy loader end

    $scope.user = {};
    var id = 1;
    $scope.follow = function (index) { }

    // PROFEETIONAL DATA
    $scope.follow_user = function (id) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/follow_user',
            data: 'to_id=' + id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {

                    $("#" + id).html($compile(success.data)($scope));
                });
    }
    $scope.unfollow_user = function (id) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/unfollow_user',
            data: 'to_id=' + id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {

                    $("#" + id).html($compile(success.data)($scope));
                });
    }
    $scope.goUserprofile = function (path) {
        location.href = base_url + 'profiles/' + path;
    }
});
app.controller('followingController', function ($scope, $http, $location, $compile, $window) {
    //    lazzy loader start
// Variables
    $scope.showLoadmore = true;
    $scope.row = 0;
    $scope.rowperpage = 3;
    $scope.buttonText = "Load More";
    // Fetch data
    $scope.getFollowing = function (pagenum = '') {

        $http({
            method: 'post',
            url: base_url + "userprofile_page/following_data?page=" + pagenum,
            data: {row: $scope.row, rowperpage: $scope.rowperpage}
        }).then(function successCallback(response) {
            if (response.data != '') {
                $scope.row += $scope.rowperpage;
                if ($scope.contactData != undefined) {
                    $scope.page_number = response.data.pagedata.page;
                    for (var i in response.data.followingrecord) {
                        $scope.followingData.push(response.data.followingrecord[i]);
                    }
                } else {
                    $scope.pagecntctData = response.data;
                    $scope.followingData = response.data.followingrecord;
                }
            } else {
                $scope.showLoadmore = false;
            }
            $('footer').show();
        });
    }
    angular.element($window).bind("scroll", function (e) {
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            var page = $(".page_number").val();
            var total_record = $(".total_record").val();
            var perpage_record = $(".perpage_record").val();
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($(".page_number").val()) + 1;
                    $scope.getFollowing(pagenum);
                }
            }
        }
    });
    // Call function
    $scope.getFollowing();
//    lazzy loader end
    $scope.user = {};
    var id = 1;
    $scope.follow = function (index) {
    }
    // PROFEETIONAL DATA
    $scope.unfollow_user = function (id) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/unfollowingContacts',
            dataType: 'json',
            data: 'to_id=' + id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {
                    if (success.data.response == 1) {
                        $('#' + id).closest('.custom-user-box').fadeToggle();
                        if (success.data.unfollowingcount == '0') {
                            $("#nofollowng").html("<div class='art-img-nn'><div class='art_no_post_img'><img src='assets/img/icon_notification_big.png' alt='notification image'></div><div class='art_no_post_text'>No Following Contacts Available. </div></div>");
                        }
                    }
                });
    }
    $scope.goUserprofile = function (path) {
        location.href = base_url + 'profiles/' + path;
    }
});

app.controller('questionsController', function ($scope, $http, $location, $compile, $window) {
    //    lazzy loader start
    $scope.showLoadmore = true;
    $scope.row = 0;
    $scope.rowperpage = 3;
    $scope.buttonText = "Load More";

    $scope.getQuestions = function (pagenum = '') {
        $http({
            method: 'post',
            url: base_url + "userprofile_page/questions_list?page=" + pagenum,
            data: {row: $scope.row, rowperpage: $scope.rowperpage}
        }).then(function successCallback(response) {
            if (response.data != '') {
                $scope.row += $scope.rowperpage;
                if ($scope.contactData != undefined) {
                    $scope.page_number = response.data.pagedata.page;
                    for (var i in response.data.questionsrecord) {
                        $scope.questionsData.push(response.data.questionsrecord[i]);
                    }
                } else {
                    $scope.pagecntctData = response.data;
                    $scope.postData = response.data;
                }
            } else {
                $scope.showLoadmore = false;
            }
            $('footer').show();
        });
    }
    angular.element($window).bind("scroll", function (e) {
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            var page = $(".page_number").val();
            var total_record = $(".total_record").val();
            var perpage_record = $(".perpage_record").val();
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($(".page_number").val()) + 1;
                    $scope.getQuestions(pagenum);
                }
            }
        }
    });
    $scope.getQuestions();
    $scope.goUserprofile = function (path) {
        location.href = base_url + 'profiles/' + path;
    }

    $scope.post_like = function (post_id) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePost',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            if (success.data.message == 1) {
                if (success.data.is_newLike == 1) {
                    $('#post-like-' + post_id).addClass('like');
                    $('#post-like-' + post_id).html('Liked');
                    $('#post-like-count-' + post_id).html(success.data.likePost_count);
                    if (success.data.likePost_count == '0') {
                        $('#post-other-like-' + post_id).html('');
                    } else {
                        $('#post-other-like-' + post_id).html(success.data.post_like_data);
                    }
                } else if (success.data.is_oldLike == 1) {
                    $('#post-like-' + post_id).removeClass('like');
                    $('#post-like-' + post_id).html('Like');
                    $('#post-like-count-' + post_id).html(success.data.likePost_count);
                    if (success.data.likePost_count == '0') {
                        $('#post-other-like-' + post_id).html('');
                    } else {
                        $('#post-other-like-' + post_id).html(success.data.post_like_data);
                    }
                }
            }
        });
    }

    $scope.giveAnswer = function (user_id) {
        var ans_text_class = document.getElementById('ans-text-' + user_id).className.split(' ').pop();
        if (ans_text_class == 'open') {
            $('#ans-text-' + user_id).removeClass('open');
            $('#ans-text-' + user_id).css('display', 'none');
            $('#all-post-bottom-' + user_id).css('display', 'none');
        } else {
            $('#ans-text-' + user_id).addClass('open');
            $('#ans-text-' + user_id).css('display', 'block');
            $('#all-post-bottom-' + user_id).css('display', 'block');
        }
    }

    $scope.sendComment = function (post_id, index, post) {
        //var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        var comment = $('#commentTaxBox-' + post_id).html();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        if (comment) {
            $scope.isMsg = true;
            $http({
                method: 'POST',
                url: base_url + 'user_post/postCommentInsert',
                data: 'comment=' + comment + '&post_id=' + post_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
                    .then(function (success) {
                        data = success.data;
                        if (data.message == '1') {
                            $('.post-comment-count-' + post_id).html(data.comment_count);
                            $('.editable_text').html('');
                        }
                    });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }

    $scope.EditPost = function (post_id, post_for, index) {
        $scope.is_edit = 1;


        $http({
            method: 'POST',
            url: base_url + 'user_post/getPostData',
            data: 'post_id=' + post_id + '&post_for=' + post_for,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {
                    $scope.is_edit = 1;
                    if (post_for == "opportunity") {
                        $scope.opp.description = success.data.opportunity;
                        $scope.opp.job_title = success.data.opportunity_for;
                        $scope.opp.location = success.data.location;
                        $scope.opp.field = success.data.field;
                        $scope.opp.edit_post_id = post_id;
                        $("#opportunity-popup").modal('show');

                    } else if (post_for == "simple") {
                        $scope.sim.description = success.data.description;
                        $scope.sim.edit_post_id = post_id;

                        $("#post-popup").modal('show');

                    } else if (post_for == "question") {
                        $scope.ask.ask_que = success.data.question;
                        $scope.ask.ask_description = success.data.description;
                        $scope.ask.related_category = success.data.tag_name;
                        $scope.ask.ask_field = success.data.field;
                        $scope.ask.edit_post_id = post_id;

                        $("#ask-question").modal('show');
                    }
                });
    }

    $scope.deletePost = function (post_id, index) {
        $scope.p_d_post_id = post_id;
        $scope.p_d_index = index;

        $('#delete_post_model').modal('show');
    }
    $scope.deletedPost = function (post_id, index) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePost',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {
                    data = success.data;
                    if (data.message == '1') {
                        $scope.postData.splice(index, 1);
                    }
                });
    }

});
function remove_contacts(index) {
    $.ajax({
        url: base_url + "userprofile_page/removeContacts",
        dataType: 'json',
        type: "POST",
        data: {"id": index},
        success: function (data) {
            if (data.response == 1) {
                $('#' + index).closest('.custom-user-box').fadeToggle();
                if (data.contactcount == '1') {
                    $("#nocontact").html("<div class='art-img-nn'><div class='art_no_post_img'><img src='assets/img/icon_notification_big.png' alt='notification image'></div><div class='art_no_post_text'>No Contacts Available. </div></div>");
                }
            }
        }
    });
}
function unfollowing_contacts(index) {
    $.ajax({
        url: base_url + "userprofile_page/unfollowingContacts",
        dataType: 'json',
        type: "POST",
        data: {"id": index},
        success: function (data) {
            if (data.response == 1) {
                $('#' + index).closest('.custom-user-box').fadeToggle();

            }
        }
    });
}
$uploadCrop1 = $('#upload-demo-one').croppie({
    enableExif: true,
    viewport: {
        width: 200,
        height: 200,
        type: 'square'
    },
    boundary: {
        width: 300,
        height: 300
    }
});
$('#upload-one').on('change', function () {
    document.getElementById('upload-demo-one').style.display = 'block';
    var reader = new FileReader();
    reader.onload = function (e) {
        $uploadCrop1.croppie('bind', {
            url: e.target.result
        }).then(function () {
            console.log('jQuery bind complete');
        });
    }
    reader.readAsDataURL(this.files[0]);
});
$("#userimage").validate({
    rules: {
        profilepic: {
            required: true,
        },
    },
    messages: {
        profilepic: {
            required: "Photo Required",
        },
    },
    submitHandler: profile_pic
});
function profile_pic() {
    $uploadCrop1.croppie('result', {
        type: 'canvas',
        size: 'viewport'
    }).then(function (resp) {
        $.ajax({
            url: base_url + "userprofile_page/user_image_insert1",
            type: "POST",
            data: {"image": resp},
            beforeSend: function () {
                $('#profi_loader').show();
            },
            complete: function () {
            },
            success: function (data) {
                $('#profi_loader').hide();
                $('#bidmodal-2').modal('hide');
                $(".profile-img").html(data);
                document.getElementById('upload-one').value = null;
                document.getElementById('upload-demo-one').value = '';
            }
        });
    });
}

function updateprofilepopup(id) {
    document.getElementById('upload-demo-one').style.display = 'none';
    document.getElementById('profi_loader').style.display = 'none';
    document.getElementById('upload-one').value = null;
    $('#bidmodal-2').modal('show');
}
function myFunction() {

    document.getElementById("upload-demo").style.visibility = "hidden";
    document.getElementById("upload-demo-i").style.visibility = "hidden";
    document.getElementById('message1').style.display = "block";
}
function showDiv() {

    document.getElementById('row1').style.display = "block";
    document.getElementById('row2').style.display = "none";
    $(".cr-image").attr("src", "");
    $("#upload").val('');
}

function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('.cr-image').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}
 $uploadCrop = $('#upload-demo').croppie({
    enableExif: true,
    viewport: {
        width: 1250,
        height: 350,
        type: 'square'
    },
    boundary: {
        width: 1250,
        height: 350
    }
});
   
$('.upload-result').on('click', function (ev) {

    $uploadCrop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
    }).then(function (resp) {

        $.ajax({
            url: base_url + "userprofile_page/ajaxpro",
            type: "POST",
            data: {"image": resp},
            success: function (data) {
                if (data) {
                    $("#row2").html(data);
                    document.getElementById('row2').style.display = "block";
                    document.getElementById('row1').style.display = "none";
                    document.getElementById('message1').style.display = "none";
                    document.getElementById("upload-demo").style.visibility = "visible";
                    document.getElementById("upload-demo-i").style.visibility = "visible";
                }
            }
        });
    });
});
$('.cancel-result').on('click', function (ev) {

    document.getElementById('row2').style.display = "block";
    document.getElementById('row1').style.display = "none";
    document.getElementById('message1').style.display = "none";
    $(".cr-image").attr("src", "");
});
$(document).on('change','#upload', function(){

    var reader = new FileReader();
    reader.onload = function (e) {
        $uploadCrop.croppie('bind', {
            url: e.target.result
        }).then(function () {
            console.log('jQuery bind complete');
        });
    }
    reader.readAsDataURL(this.files[0]);
});
//$('#upload').on('change', function () {
$(document).on('change','#upload', function(){

    var fd = new FormData();
    fd.append("image", $("#upload")[0].files[0]);
    files = this.files;
    size = files[0].size;
    if (!files[0].name.match(/.(jpg|jpeg|png|gif)$/i)) {
        picpopup();
        document.getElementById('row1').style.display = "none";
        document.getElementById('row2').style.display = "block";
        return false;
    }
    if (size > 26214400)
    {
        alert("Allowed file size exceeded. (Max. 25 MB)")
        document.getElementById('row1').style.display = "none";
        document.getElementById('row2').style.display = "block";
        return false;
    }
    $.ajax({

            url: base_url + "dashboard/image",
            //url: "<?php echo base_url(); ?>artist/image",
            type: "POST",
            data: fd,
            processData: false,
            contentType: false,
            success: function (response) {
            }
        });
});
$(document).on('click','.post-opportunity-modal, .post-ask-question-modal', function(){
    $('#post-popup').modal('toggle');
});
$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});