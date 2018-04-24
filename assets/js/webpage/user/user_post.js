
app.directive('ddTextCollapse', ['$compile', function($compile) {

    return {
        restrict: 'A',
        scope: true,
        link: function(scope, element, attrs) {

            // start collapsed
            scope.collapsed = false;

            // create the function to toggle the collapse
            scope.toggle = function() {
                scope.collapsed = !scope.collapsed;
            };

            // wait for changes on the text
            attrs.$observe('ddTextCollapseText', function(text) {

                // get the length from the attributes
                var maxLength = scope.$eval(attrs.ddTextCollapseMaxLength);
                var condition = scope.$eval(attrs.ddTextCollapseCond);
                

                if (text.length > maxLength) {
                    // split the text in two parts, the first always showing

                    if(/^\<a.*\>.*\<\/a\>/i.test(text))
                    {
                        var start = text.indexOf("<a href");
                        var end = text.indexOf('target="_blank">');
                        element.append(text);
                    }
                    else
                    {
                        var firstPart = String(text).substring(0, maxLength);                    
                        var secondPart = String(text).substring(maxLength, text.length);                    

                        // create some new html elements to hold the separate info
                        var firstSpan = $compile('<span>' + firstPart + '</span>')(scope);
                        var secondSpan = $compile('<span ng-if="collapsed">' + secondPart + '</span>')(scope);
                        var moreIndicatorSpan = $compile('<span ng-if="!collapsed">... </span>')(scope);
                        var lineBreak = $compile('<br ng-if="collapsed">')(scope);
                        if(condition == true)
                        {                        
                            var toggleButton = $compile('<span class="collapse-text-toggle" ng-click="toggle()">{{collapsed ? "" : "View more"}}</span>')(scope);//{{collapsed ? "View less" : "View more"}}
                        }
                        if(condition == false)
                        {                        
                            var toggleButton = $compile('<span class="collapse-text-toggle" ng-click="toggle()">{{collapsed ? "" : ""}}</span>')(scope);//{{collapsed ? "View less" : "View more"}}
                        }

                        // remove the current contents of the element
                        // and add the new ones we created
                        element.empty();
                        element.append(firstSpan);
                        element.append(secondSpan);
                        element.append(moreIndicatorSpan);
                        element.append(lineBreak);
                        element.append(toggleButton);

                    }                    
                }
                else {
                    element.empty();
                    element.append(text);
                }
            });
        }
    };
}]);

app.directive('pTextCollapse', ['$compile', function($compile) {

    return {
        restrict: 'A',
        scope: true,
        link: function(scope, element, attrs) {

            // start collapsed
            scope.collapsed = false;

            // create the function to toggle the collapse
            scope.toggle = function() {
                scope.collapsed = !scope.collapsed;
            };

            // wait for changes on the text
            attrs.$observe('pTextCollapseText', function(text) {

                // get the length from the attributes
                var maxLength = scope.$eval(attrs.pTextCollapseMaxLength);

                if (text.length > maxLength) {
                    // split the text in two parts, the first always showing
                    var firstPart = String(text).substring(0, maxLength);
                    var secondPart = String(text).substring(maxLength, text.length);

                    // create some new html elements to hold the separate info
                    var firstSpan = $compile('<span>' + firstPart + '</span>')(scope);
                    var secondSpan = $compile('<span ng-if="collapsed">' + secondPart + '</span>')(scope);
                    var moreIndicatorSpan = $compile('<span ng-if="!collapsed">... </span>')(scope);
                    var lineBreak = $compile('<br ng-if="collapsed">')(scope);
                    var toggleButton = $compile('<span class="collapse-text-toggle">{{collapsed ? "" : ""}}</span>')(scope);//{{collapsed ? "View less" : "View more"}}

                    // remove the current contents of the element
                    // and add the new ones we created
                    element.empty();
                    element.append(firstSpan);
                    element.append(secondSpan);
                    element.append(moreIndicatorSpan);
                    element.append(lineBreak);
                    element.append(toggleButton);
                }
                else {
                    element.empty();
                    element.append(text);
                }
            });
        }
    };
}]);
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
/*app.directive('fileInput', function ($parse) {
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
});*/

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

// app.directive('scrollableContainer', function ($window, $document, $http) {
//     return {
//         link: function ($scope, element, attrs) {
//             $(window).on('scroll', function () {
// //                if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) {
//                 if ($(window).scrollTop() == $(document).height() - $(window).height()) {
//                     //var post_index = $(".post_index:last").val();
//                     var page = $(".page_number:last").val();
//                     var total_record = $(".total_record").val();
//                     var perpage_record = $(".perpage_record").val();
//                     if (parseInt(perpage_record * page) <= parseInt(total_record)) {
//                         var available_page = total_record / perpage_record;
//                         available_page = parseInt(available_page, 10);
//                         var mod_page = total_record % perpage_record;
//                         if (mod_page > 0) {
//                             available_page = available_page + 1;
//                         }
//                         //if ($(".page_number:last").val() <= $(".total_record").val()) {
//                         if (parseInt(page) <= parseInt(available_page)) {
//                             var pagenum = parseInt($(".page_number:last").val()) + 1;
//                             getUserPost(pagenum);
//                         }
//                     }
//                 }
//             });
//             function getUserPost(pagenum = '') {
//                 $('#loader').show();
//                 $http.get(base_url + "user_post/getUserPost?page=" + pagenum).then(function (success) {
//                     $('#loader').hide();
//                     for (var i in success.data) {
//                         $scope.postData.push(success.data[i]);
//                     }
//                     $('video,audio').mediaelementplayer(/* Options */);
//                 }, function (error) {});
//             }
//         }
//     };
// });


app.controller('userOppoController', function ($scope, $http,$compile) {

    $(document).on('hidden.bs.modal', function (event) {
        if($('.modal.in').length > 0)
        {
            if ($('body').hasClass('modal-open') == false) {
                $('body').addClass('modal-open');
            };            
        }
    });

    $(document)  
      .on('show.bs.modal', '.modal', function(event) {
        $(this).appendTo($('body'));
      })
      .on('shown.bs.modal', '.modal.in', function(event) {
        setModalsAndBackdropsOrder();
      })
      .on('hidden.bs.modal', '.modal', function(event) {
        setModalsAndBackdropsOrder();
      });

    function setModalsAndBackdropsOrder() {  
      var modalZIndex = 1040;
      $('.modal.in').each(function(index) {
        var $modal = $(this);
        modalZIndex++;
        $modal.css('zIndex', modalZIndex);
        $modal.next('.modal-backdrop.in').addClass('hidden').css('zIndex', modalZIndex - 1);
    });
      $('.modal.in:visible:last').focus().next('.modal-backdrop.in').removeClass('hidden');
    }

    $(document).on('keydown', function (e) {
        if (e.keyCode === 27) {
            $('.modal-close').click();            
        }
    });

    $(document).on('focusin','#job_title .input',function () {
        if($('#job_title ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '200px');
        }
    });
    $(document).on('focusout','#job_title .input',function () {
        if($('#job_title ul li').length > 0)
        {             
            $(this).attr('placeholder', '');
            $(this).css('width', '200px');
        }
        if($('#job_title ul li').length == 0)
        {            
            $(this).attr('placeholder', 'Ex:Seeking Opportunity, CEO, Enterpreneur, Founder, Singer, Photographer....');
            $(this).css('width', '200px');
        }         
    });

    $(document).on('focusin','#location .input',function () {
        if($('#location ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '200px');
        }
    });
    $(document).on('focusout','#location .input',function () {
        if($('#location ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '200px');
        }
        if($('#location ul li').length == 0)
        {            
            $(this).attr('placeholder', 'Ex:Mumbai, Delhi, New south wels, London, New York, Captown, Sydeny, Shanghai....');
            $(this).css('width', '200px');
        }
         /*$(this).attr('placeholder', 'Ex:Seeking Opportunity, CEO, Enterpreneur, Founder, Singer, Photographer....');
         $(this).css('width', '100%');*/
    });

    $(document).on('focusin','#ask_related_category .input',function () {
        if($('#ask_related_category ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '200px');
        }
    });
    $(document).on('focusout','#ask_related_category .input',function () {
        if($('#ask_related_category ul li').length > 0)
        {             
            $(this).attr('placeholder', '');
            $(this).css('width', '200px');
        }
        if($('#ask_related_category ul li').length == 0)
        {            
            $(this).attr('placeholder', 'Related Category');
            $(this).css('width', '200px');
        }         
    });
    
    $scope.opp = {};
    $scope.sim = {};
    $scope.ask = {};
    $scope.postData = {};
    $scope.opp.post_for = 'opportunity';
    $scope.sim.post_for = 'simple';
    $scope.ask.post_for = 'question';


    var cntImgSim = 0;
    var formFileDataSim = new FormData();
    var formFileExtSim = [];
    var fileCountSim = 0;
    var fileNamesArrSim = [];

    var cntImgOpp = 0;
    var formFileDataOpp = new FormData();
    var formFileExtOpp = [];
    var fileCountOpp = 0;
    var fileNamesArrOpp = [];

    var cntImgQue = 0;
    var formFileDataQue = new FormData();
    var formFileExtQue = [];
    var fileCountQue = 0;
    var fileNamesArrQue = [];

    var isLoadingData = false;

    $(document).on('change','#fileInput1', function(e){
        $.each($('#fileInput1')[0].files, function(i, f) {
            
            if(fileNamesArrSim.indexOf(f.name) < 0)
            {
                formFileExtSim.push(f.type.split('/')[1]);
                fileNamesArrSim.push(f.name);

                if(f.type.match("image.*")) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var $el = $("<div class='img_preview' id='imgPrev_"+cntImgSim+"'><div class='i-ip'><img src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selFile' title='"+f.name+"'></div><label class='remove_img' name='remove_image' ng-click=\"removeFile('"+cntImgSim+"')\" ><i class='fa fa-trash-o' aria-hidden='true'></i></label></div>").appendTo('#selectedFiles');
                        //$("#selectedFiles").append(html);
                        $compile($el)($scope);

                        formFileDataSim.append('myfiles_'+cntImgSim, f);

                        cntImgSim++;
                        fileCountSim++;                    
                        $("#fileCountSim").text(fileCountSim);
                        if($('#fileInput1')[0].files.length - 1 == i)
                        {
                            $('#fileInput1').val("");
                        }
                    }
                    reader.readAsDataURL(f); 
                }
                else if(f.type.match("video.*")) {
                    src = URL.createObjectURL(f);
                    var $el = $('<div class="img_preview" id="imgPrev_'+cntImgSim+'"><div class="i-ip"><video width="400"><source src="'+src+'" id="video_here">Your browser does not support HTML5 video.</video></div><label class="remove_img" name="remove_image" ng-click=\'removeFile("'+cntImgSim+'")\'><i class="fa fa-trash-o" aria-hidden="true"></i></label></div>').appendTo('#selectedFiles');
                    //$("#selectedFiles").append(html);
                    $compile($el)($scope);
                    formFileDataSim.append('myfiles_'+cntImgSim, f);
                    //fileNamesArrSim.push(f.name);
                    cntImgSim++;
                    fileCountSim++;
                    $("#fileCountSim").text(fileCountSim);
                    if($('#fileInput1')[0].files.length - 1 == i)
                    {
                        $('#fileInput1').val("");
                    }
                }

                else if(f.type.match("audio.*")) {
                    src = URL.createObjectURL(f);
                    var $el =  $('<div class="img_preview" id="imgPrev_'+cntImgSim+'"><div class="i-ip i-ip-audio"><audio><source src="'+src+'" type="audio/ogg"><source src="'+src+'" type="audio/mpeg">Your browser does not support the audio element.</audio></div><label class="remove_img" name="remove_image" ng-click=\'removeFile("'+cntImgSim+'")\'><i class="fa fa-trash-o" aria-hidden="true"></i></label></div>').appendTo('#selectedFiles');
                    //$("#selectedFiles").append(html);
                    $compile($el)($scope);
                    formFileDataSim.append('myfiles_'+cntImgSim, f);
                    cntImgSim++;
                    fileCountSim++;
                    $("#fileCountSim").text(fileCountSim);
                    if($('#fileInput1')[0].files.length - 1 == i)
                    {
                        $('#fileInput1').val("");
                    }
                }

                else if(f.type == "application/pdf") {              
                    var $el =  $('<div class="img_preview" id="imgPrev_'+cntImgSim+'"><div class="i-ip"><img ng-src="'+base_url+'assets/images/PDF.jpg" class="selFile"></div><label class="remove_img" name="remove_image" ng-click=\'removeFile("'+cntImgSim+'")\'><i class="fa fa-trash-o" aria-hidden="true"></i></label></div>').appendTo('#selectedFiles');
                    //$("#selectedFiles").append(html);
                    $compile($el)($scope);
                    formFileDataSim.append('myfiles_'+cntImgSim, f);
                    cntImgSim++;
                    fileCountSim++;
                    $("#fileCountSim").text(fileCountSim);
                    if($('#fileInput1')[0].files.length - 1 == i)
                    {
                        $('#fileInput1').val("");
                    }

                    /*var reader = new FileReader();
                    reader.onload = function (e) {
                        var $el = $("<div class='img_preview' id='imgPrev_"+cntImgSim+"'><div class='i-ip'><embed width='100%' src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selFile' title='"+f.name+"'></embed></div><label class='remove_img' name='remove_image' ng-click=\"removeFile('"+cntImgSim+"')\" ><i class='fa fa-trash-o' aria-hidden='true'></i></label></div>").appendTo('#selectedFiles');
                        //$("#selectedFiles").append(html);
                        $compile($el)($scope);

                        formFileDataSim.append('myfiles_'+cntImgSim, f);

                        cntImgSim++;
                        fileCountSim++;                    
                        $("#fileCountSim").text(fileCountSim);
                        if($('#fileInput1')[0].files.length - 1 == i)
                        {
                            $('#fileInput1').val("");
                        }
                    }
                    reader.readAsDataURL(f);*/
                }
            }            
        });
    });

    $scope.removeFile = function(rmId) {        
        fileCountSim--;
        $("#fileCountSim").text(fileCountSim);
        if(fileCountSim <= 0)
        {
            $("#fileInput1").val("");
        }        
        var ext = formFileDataSim.get("myfiles_"+rmId).type.split('/')[1];
        var fileExtIndex = formFileExtSim.indexOf(ext.toString());
        formFileExtSim.splice(fileExtIndex, 1);
        
        var fileNameIndex = fileNamesArrSim.indexOf(formFileDataSim.get("myfiles_"+rmId).name);
        fileNamesArrSim.splice(fileNameIndex, 1);
        //console.log(fileNamesArrSim);
        $("#imgPrev_"+rmId).remove();
        formFileDataSim.delete("myfiles_"+rmId);

    };

    $(document).on('change','#fileInput', function(e){
        $.each($('#fileInput')[0].files, function(i, f) {
            
            if(fileNamesArrOpp.indexOf(f.name) < 0)
            {
                formFileExtOpp.push(f.type.split('/')[1]);
                fileNamesArrOpp.push(f.name);

                if(f.type.match("image.*")) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var $el = $("<div class='img_preview' id='imgPrevOpp_"+cntImgOpp+"'><div class='i-ip'><img src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selFile' title='"+f.name+"'></div><label class='remove_img' name='remove_image' ng-click=\"removeFileOpp('"+cntImgOpp+"')\" ><i class='fa fa-trash-o' aria-hidden='true'></i></label></div>").appendTo('#selectedFilesOpp');                        
                        $compile($el)($scope);

                        formFileDataOpp.append('myfiles_'+cntImgOpp, f);

                        cntImgOpp++;
                        fileCountOpp++;                    
                        $("#fileCountOpp").text(fileCountOpp);
                        if($('#fileInput')[0].files.length - 1 == i)
                        {
                            $('#fileInput').val("");
                        }
                    }
                    reader.readAsDataURL(f); 
                }
                else if(f.type.match("video.*")) {
                    src = URL.createObjectURL(f);
                    var $el = $('<div class="img_preview" id="imgPrevOpp_'+cntImgOpp+'"><div class="i-ip"><video width="400"><source src="'+src+'" id="video_here">Your browser does not support HTML5 video.</video></div><label class="remove_img" name="remove_image" ng-click=\'removeFileOpp("'+cntImgOpp+'")\'><i class="fa fa-trash-o" aria-hidden="true"></i></label></div>').appendTo('#selectedFilesOpp');                    
                    $compile($el)($scope);
                    formFileDataOpp.append('myfiles_'+cntImgOpp, f);                    
                    cntImgOpp++;
                    fileCountOpp++;
                    $("#fileCountOpp").text(fileCountOpp);
                    if($('#fileInput')[0].files.length - 1 == i)
                    {
                        $('#fileInput').val("");
                    }
                }

                else if(f.type.match("audio.*")) {
                    src = URL.createObjectURL(f);
                    var $el =  $('<div class="img_preview" id="imgPrevOpp_'+cntImgOpp+'"><div class="i-ip i-ip-audio"><audio><source src="'+src+'" type="audio/ogg"><source src="'+src+'" type="audio/mpeg">Your browser does not support the audio element.</audio></div><label class="remove_img" name="remove_image" ng-click=\'removeFileOpp("'+cntImgOpp+'")\'><i class="fa fa-trash-o" aria-hidden="true"></i></label></div>').appendTo('#selectedFilesOpp');                    
                    $compile($el)($scope);
                    formFileDataOpp.append('myfiles_'+cntImgOpp, f);
                    cntImgOpp++;
                    fileCountOpp++;
                    $("#fileCountOpp").text(fileCountOpp);
                    if($('#fileInput')[0].files.length - 1 == i)
                    {
                        $('#fileInput').val("");
                    }
                }

                else if(f.type == "application/pdf") {              
                    var $el =  $('<div class="img_preview" id="imgPrevOpp_'+cntImgOpp+'"><div class="i-ip"><img ng-src="'+base_url+'assets/images/PDF.jpg" class="selFile"></div><label class="remove_img" name="remove_image" ng-click=\'removeFileOpp("'+cntImgOpp+'")\'><i class="fa fa-trash-o" aria-hidden="true"></i></label></div>').appendTo('#selectedFilesOpp');                    
                    $compile($el)($scope);
                    formFileDataOpp.append('myfiles_'+cntImgOpp, f);
                    cntImgOpp++;
                    fileCountOpp++;
                    $("#fileCountOpp").text(fileCountOpp);
                    if($('#fileInput')[0].files.length - 1 == i)
                    {
                        $('#fileInput').val("");
                    }
                }
            }            
        });
    });

    $scope.removeFileOpp = function(rmId) {
        fileCountOpp--;
        $("#fileCountOpp").text(fileCountOpp);
        if(fileCountOpp <= 0)
        {
            $("#fileInput").val("");
        }        
        var ext = formFileDataOpp.get("myfiles_"+rmId).type.split('/')[1];
        var fileExtIndex = formFileExtOpp.indexOf(ext.toString());
        formFileExtOpp.splice(fileExtIndex, 1);
        
        var fileNameIndex = fileNamesArrOpp.indexOf(formFileDataOpp.get("myfiles_"+rmId).name);
        fileNamesArrOpp.splice(fileNameIndex, 1);
        $("#imgPrevOpp_"+rmId).remove();
        formFileDataOpp.delete("myfiles_"+rmId);
    };


    var pg="";
    var processing = false;
    getUserPost(pg);
    function getUserPost(pg) {
     
        $('#loader').show();
        $http.get(base_url + "user_post/getUserPost?page=" + pg).then(function (success) {
            $('#loader').hide();
           
            if (success.data) {
                isLoadingData = false;
                $('#progress_div').hide();
                $('.progress-bar').css("width",0);
                $('.sr-only').text(0+"%");
                $scope.postData = success.data; 
            } else {
                 
                isLoadingData = true;
            }

            $('video,audio').mediaelementplayer(/* Options */);
        }, function (error) {});
    }

    $(window).on('scroll', function () {
        if ($(window).scrollTop() == $(document).height() - $(window).height() && isLoadingData == false) {
            isLoadingData = true;
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
                    getUserPostLoadMore(pagenum);
                }
            }
        }
    });

    function getUserPostLoadMore(pg) {
     
        $('#loader').show();
        $http.get(base_url + "user_post/getUserPost?page=" + pg).then(function (success) {
            $('#loader').hide();
           
            if (success.data) {
                isLoadingData = false;
                //$scope.postData = success.data; 
                for (var i in success.data) {
                    $scope.postData.push(success.data[i]);
                }
            } else {
                 
                isLoadingData = true;
            }

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
        var b = $('job_title').val();
        var c = $('#location').val();
        var d = $('#field').val();
        //$("#post_opportunity")[0].reset();
        $('#description').val(a);
        $('#job_title').val(b);
        $('#location').val(c);
        $('#field').val(d);
    }

    $scope.post_opportunity_check = function (event,postIndex = -1) {

        if (document.getElementById("opp_edit_post_id"+postIndex)) {
            var post_id = document.getElementById("opp_edit_post_id"+postIndex).value;
        } else {
            var post_id = 0;
        }        
        if (post_id == 0) {
            var fileInput = document.getElementById("fileInput").files;
            var description = $scope.opp.description;//document.getElementById("description").value;            
            var job_title = $scope.opp.job_title;
            var location = $scope.opp.location;
            var fields = $scope.opp.field;
            
            if( (fileCountOpp == 0 && (description == '' || description == undefined)) || ((job_title == undefined || job_title == '')  || (location == undefined || location == '') || (fields == undefined || fields == '')))
            {
                $('#post .mes').html("<div class='pop_content'>This post appears to be blank. All fields are mandatory.");
                $('#post').modal('show');
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                //event.preventDefault();
                return false;
            }
            else
            {
                var allowedExtensions = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg'];
                var allowesvideo = ['mp4', 'webm', 'mov', 'MP4'];
                var allowesaudio = ['mp3'];
                var allowespdf = ['pdf'];
                var imgExt = false,videoExt = false,audioExt = false,pdfExt = false;

                if(fileCountOpp > 0 && fileCountOpp < 11)
                {
                    $.each(formFileExtOpp, function( index, value ) {
                        //console.log( index + ": " + value );
                        if($.inArray(value, allowedExtensions) > -1)
                        {
                            imgExt = true;
                        }
                        if($.inArray(value, allowesvideo) > -1)
                        {
                            videoExt = true;
                        }
                        if($.inArray(value, allowesaudio) > -1)
                        {
                            audioExt = true;
                        }
                        if($.inArray(value, allowespdf) > -1)
                        {
                            pdfExt = true;
                        }
                    });

                    if(imgExt == true && (videoExt == true || audioExt == true || pdfExt == true))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            //$("#post_opportunity")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;
                    }
                    if(videoExt == true && (imgExt == true || audioExt == true || pdfExt == true))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either video or photo or  audio or pdf. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            //$("#post_opportunity")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;                        
                    }
                    if(audioExt == true && (imgExt == true || videoExt == true || pdfExt == true))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either audio or photo or video or pdf. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            //$("#post_opportunity")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;                        
                    }
                    else
                    {
                        if(audioExt == true && (description == '' || description == undefined))
                        {
                            $('.biderror .mes').html("<div class='pop_content'>Please Enter Audio Title.");
                            $('#posterrormodal').modal('show');
                            //$("#post_opportunity")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false; 
                        }

                    }
                    if(pdfExt == true && (imgExt == true || videoExt == true || audioExt == true))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either pdf or photo or video or audio. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            //$("#post_opportunity")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;                        
                    }
                    else
                    {
                        if(pdfExt == true && (description == '' || description == undefined))
                        {
                            $('.biderror .mes').html("<div class='pop_content'>Please Enter PDF Title.");
                            $('#posterrormodal').modal('show');
                            //$("#post_opportunity")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false; 
                        }
                    }
                }
                else
                {
                    if((description == '' || description == undefined) || ((job_title == undefined || job_title == '')  || (location == undefined || location == '') || (fields.trim() == undefined || fields.trim() == '')))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>This post appears to be blank. Please write or attach (photos, videos, audios, pdf) to Post Opportunity.");
                        $('#posterrormodal').modal('show');
                        //$("#post_opportunity")[0].reset();
                        //setInterval('window.location.reload()', 10000);
                        $(document).on('keydown', function (e) {
                            if (e.keyCode === 27) {
                                $('#posterrormodal').modal('hide');
                                $('.modal-post').show();
                            }
                        });
                        //event.preventDefault();
                        return false;
                    }
                }

                for (var i = 0; i < fileCountOpp; i++)
                {
                    var vname = fileNamesArrOpp[i];
                    var vfirstname = fileNamesArrOpp[i];
                    var ext = vfirstname.split('.').pop();
                    var ext1 = vname.split('.').pop();
                    var foundPresent = $.inArray(ext, allowedExtensions) > -1;
                    var foundPresentvideo = $.inArray(ext, allowesvideo) > -1;
                    var foundPresentaudio = $.inArray(ext, allowesaudio) > -1;
                    var foundPresentpdf = $.inArray(ext, allowespdf) > -1;

                    if (foundPresent == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowedExtensions) > -1;
                        if (foundPresent1 == true && fileCountOpp >= 11) {                        
                            $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf. You cannot upload more than 10 photos at a time.");
                            $('#posterrormodal').modal('show');
                            //setInterval('window.location.reload()', 10000);
                            //$("#post_opportunity")[0].reset();
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentvideo == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowesvideo) > -1;
                        if (foundPresent1 == true && fileCountOpp == 1) {
                        } else {
                            $('.biderror .mes').html("<div class='pop_content'>Allowed to upload only single video.");
                            $('#posterrormodal').modal('show');
                            // setInterval('window.location.reload()', 10000);
                            //$("#post_opportunity")[0].reset();
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentaudio == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowesaudio) > -1;
                        if (foundPresent1 == true && fileCountOpp == 1) {
                        } else {
                            $('.biderror .mes').html("<div class='pop_content'>Allowed to upload only single audio.");
                            $('#posterrormodal').modal('show');
                            //setInterval('window.location.reload()', 10000);
                            //$("#post_opportunity")[0].reset();
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentpdf == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowespdf) > -1;
                        if (foundPresent1 == true && fileCountOpp == 1) {
                        } else {                            
                            $('.biderror .mes').html("<div class='pop_content'>Allowed to upload only single PDF.");                            
                            $('#posterrormodal').modal('show');
                            //setInterval('window.location.reload()', 10000);
                            //$("#post_opportunity")[0].reset();
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();

                                }
                            });
                            //event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentvideo == false) {

                        $('.biderror .mes').html("<div class='pop_content'>This File Format is not supported Please Try to Upload MP4 or WebM files..");
                        $('#posterrormodal').modal('show');
                        //setInterval('window.location.reload()', 10000);
                        //$("#post_opportunity")[0].reset();
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

                /*var form_data = new FormData();
                $.each($("#fileInput")[0].files, function(i, file) {
                    form_data.append('postfiles[]', file);
                });*/

                formFileDataOpp.append('description', $scope.opp.description);
                formFileDataOpp.append('field', $scope.opp.field);
                formFileDataOpp.append('job_title', JSON.stringify($scope.opp.job_title));
                formFileDataOpp.append('location', JSON.stringify($scope.opp.location));
                formFileDataOpp.append('post_for', $scope.opp.post_for);

                $('body').removeClass('modal-open');
                $("#opportunity-popup").modal('hide');

                //$('.post_loader').show();
                $('#progress_div').show();
                var bar = $('.progress-bar');
                var percent = $('.sr-only');
                $http.post(base_url + 'user_post/post_opportunity', formFileDataOpp,
                        {
                            transformRequest: angular.identity,
                            headers: {'Content-Type': undefined, 'Process-Data': false},
                            uploadEventHandlers: {
                                progress: function(e) {
                                     if (e.lengthComputable) {
                                        progress = Math.round(e.loaded * 100 / e.total);

                                        bar.width((progress - 1) +'%');
                                        percent.html((progress - 1) +'%');

                                        //console.log("progress: " + progress + "%");
                                        if (e.loaded == e.total) {
                                            /*setTimeout(function(){
                                                $('#progress_div').hide();
                                                progress = 0;
                                                bar.width(progress+'%');
                                                percent.html(progress+'%');
                                            }, 2000);*/
                                            //console.log("File upload finished!");
                                            //console.log("Server will perform extra work now...");
                                        }
                                    }
                                }
                            }
                        })
                        .then(function (success) {

                            if (success) {
                                $("#post_opportunity")[0].reset();
                                $('.post_loader').hide();
                                $scope.opp.description = ' ';
                                $scope.opp.job_title = '';
                                $scope.opp.location = '';
                                $scope.opp.field = '';
                                $scope.opp.postfiles = '';
                                document.getElementById('fileInput').value = '';

                                $('.file-preview-thumbnails').html('');
                                //$scope.postData.splice(0, 0, success.data[0]);
                                getUserPost(pg);

                                bar.width(100+'%');
                                percent.html(100+'%');
                                setTimeout(function(){                                    
                                    progress = 0;
                                    // bar.width(progress+'%');
                                    // percent.html(progress+'%');
                                }, 2000);

                                imgExt = false,videoExt = false,audioExt = false,pdfExt = false;

                                cntImgOpp = 0;
                                formFileDataOpp = new FormData();
                                fileCountOpp = 0;
                                fileNamesArrOpp = [];
                                formFileExtOpp = [];
                                $("#selectedFilesOpp").html("");
                                $("#fileCountOpp").text("");

                                $('video, audio').mediaelementplayer();
                            }
                        });
            }

        } else {
            //var description = $("#description_edit_"+post_id).val();//$scope.opp.description;//document.getElementById("description").value;
            var description = $('#description_edit_' + post_id).html();
            description = description.replace(/&nbsp;/gi, " ");
            description = description.replace(/<br>$/, '');
            description = description.replace(/&gt;/gi, ">");
            description = description.replace(/&/g, "%26");            
            description = description.trim();
            var job_title = $scope.opp.job_title_edit;
            var location = $scope.opp.location_edit;
            var fields = $("#field_edit"+post_id).val();            

            if((job_title == undefined || job_title == '')  || (location == undefined || location == '') || (fields == undefined || fields == ''))
            {
                $('#post .mes').html("<div class='pop_content'>This post appears to be blank. Please write to post.");
                $('#post').modal('show');
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                //event.preventDefault();
                return false;
            } else {


                var form_data = new FormData();

                form_data.append('description', description);
                form_data.append('field', fields);
                form_data.append('job_title', JSON.stringify(job_title));
                form_data.append('location', JSON.stringify(location));
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
                                $scope.postData[postIndex].opportunity_data.field = success.data.opp_field;
                                $scope.postData[postIndex].opportunity_data.location = success.data.opp_location;
                                $scope.postData[postIndex].opportunity_data.opportunity_for = success.data.opp_opportunity_for;
                                $scope.postData[postIndex].opportunity_data.opportunity = success.data.opportunity;
                                $("#post_opportunity_edit")[0].reset();

                                $("#edit-opp-post-"+post_id).hide();
                                $('#post-opp-detail-' + post_id).show();   
                                // $('#opp-post-opportunity-for-' + post_id).html(success.data.opp_opportunity_for);
                                // $('#opp-post-location-' + post_id).html(success.data.opp_location);
                                // $('#opp-post-field-' + post_id).html(success.data.opp_field);
                                // $('#opp-post-opportunity-' + post_id).html(success.data.opportunity);

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
                    if ($scope.queSearchResult.length > 0) {
                        $('.questionSuggetion').addClass('question-available');
                    } else {
                        $('.questionSuggetion').removeClass('question-available');
                    }
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
                // angular.forEach($scope.files, function (file) {
                //     form_data.append('postfiles[]', file);
                // });
                $.each($("#fileInput2")[0].files, function(i, file) {
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

                                $scope.ask.postfiles = '';
                                $scope.ask.ask_que = '';
                                $scope.ask.ask_description = '';
                                $scope.ask.ask_field = '';
                                $scope.ask.otherField = '';
                                $scope.ask.related_category = '';
                                $scope.ask.web_link = '';
                                $scope.ask.post_for = '';
                                $scope.ask.is_anonymously = '';
                                $('.file-preview-thumbnails').html('');
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


    // POST SOMETHING UPLOAD START

    $scope.post_something_check = function (event,postIndex = -1) {        
        //alert(postIndex);return false;
        if (document.getElementById("edit_post_id"+postIndex)) {
            var post_id = document.getElementById("edit_post_id"+postIndex).value;
        } else {
            var post_id = 0;
        }        
        if (post_id == 0) {
            var fileInput = document.getElementById("fileInput1").files;

            var description = $scope.sim.description;//document.getElementById("description").value;
            //var description = description.trim();
            var fileInput1 = document.getElementById("fileInput1").value;
            //console.log(fileInput1);

            if (fileCountSim == 0 && description == '')
            {
                $('#posterrormodal .mes').html("<div class='pop_content'>This post appears to be blank. Please write or attach (photos, videos, audios, pdf) to post.1");
                $('#posterrormodal').modal('show');
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                // $("#post_something")[0].reset();
                //event.preventDefault();
                return false;
            } else {

                var allowedExtensions = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg'];
                var allowesvideo = ['mp4', 'webm', 'mov', 'MP4'];
                var allowesaudio = ['mp3'];
                var allowespdf = ['pdf'];
                var imgExt = false,videoExt = false,audioExt = false,pdfExt = false;

                if(fileCountSim > 0 && fileCountSim < 11)
                {
                    $.each(formFileExtSim, function( index, value ) {
                        //console.log( index + ": " + value );
                        if($.inArray(value, allowedExtensions) > -1)
                        {
                            imgExt = true;
                        }
                        if($.inArray(value, allowesvideo) > -1)
                        {
                            videoExt = true;
                        }
                        if($.inArray(value, allowesaudio) > -1)
                        {
                            audioExt = true;
                        }
                        if($.inArray(value, allowespdf) > -1)
                        {
                            pdfExt = true;
                        }
                    });

                    if(imgExt == true && (videoExt == true || audioExt == true || pdfExt == true))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            //$("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;
                    }
                    if(videoExt == true && (imgExt == true || audioExt == true || pdfExt == true))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either video or photo or  audio or pdf. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            //$("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;                        
                    }
                    if(audioExt == true && (imgExt == true || videoExt == true || pdfExt == true))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either audio or photo or video or pdf. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            //$("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;                        
                    }
                    else
                    {
                        if(audioExt == true && (description == '' || description == undefined || description == ' '))
                        {
                            $('.biderror .mes').html("<div class='pop_content'>Please Enter Audio Title.");
                            $('#posterrormodal').modal('show');
                            //$("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false; 
                        }

                    }
                    if(pdfExt == true && (imgExt == true || videoExt == true || audioExt == true))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either pdf or photo or video or audio. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            //$("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;                        
                    }
                    else
                    {
                        if(pdfExt == true && description == '')
                        {
                            $('.biderror .mes').html("<div class='pop_content'>Please Enter PDF Title.");
                            $('#posterrormodal').modal('show');
                            //$("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false; 
                        }
                    }
                }
                else
                {
                    if(description == '' || description == undefined || description == ' ')
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf. You cannot upload more than 10 files at a time.2"+description);
                        $('#posterrormodal').modal('show');
                        //$("#post_something")[0].reset();
                        //setInterval('window.location.reload()', 10000);
                        $(document).on('keydown', function (e) {
                            if (e.keyCode === 27) {
                                $('#posterrormodal').modal('hide');
                                $('.modal-post').show();
                            }
                        });
                        //event.preventDefault();
                        return false;
                    }
                }



                for (var i = 0; i < fileCountSim; i++)
                {
                    var vname = fileNamesArrSim[i];
                    var vfirstname = fileNamesArrSim[i];
                    var ext = vfirstname.split('.').pop();
                    var ext1 = vname.split('.').pop();                    
                    var foundPresent = $.inArray(ext, allowedExtensions) > -1;
                    var foundPresentvideo = $.inArray(ext, allowesvideo) > -1;
                    var foundPresentaudio = $.inArray(ext, allowesaudio) > -1;
                    var foundPresentpdf = $.inArray(ext, allowespdf) > -1;

                    if (foundPresent == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowedExtensions) > -1;
                        if (foundPresent1 == true && fileCountSim >= 11) {                        
                            $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            //$("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;
                        }
                    }
                    else if (foundPresentvideo == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowesvideo) > -1;
                        if (foundPresent1 == true && fileCountSim == 1) {
                        } else {
                            $('.biderror .mes').html("<div class='pop_content'>Allowed to upload only single video.");
                            $('#posterrormodal').modal('show');
                            //setInterval('window.location.reload()', 10000);
                            //$("#post_something")[0].reset();

                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentaudio == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowesaudio) > -1;
                        if (foundPresent1 == true && fileCountSim == 1) {

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
                            $('.biderror .mes').html("<div class='pop_content'>Allowed to upload only single audio.");
                            $('#posterrormodal').modal('show');
                            //$("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);

                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentpdf == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowespdf) > -1;
                        if (foundPresent1 == true && fileCountSim == 1) {

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
                            /*if (fileInput.length > 10) {
                                $('.biderror .mes').html("<div class='pop_content'>You can not upload more than 10 files at a time.");
                            } else {
                            }*/
                            $('.biderror .mes').html("<div class='pop_content'>Allowed to upload only single PDF.");
                            $('#posterrormodal').modal('show');
                            //$("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);

                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();

                                }
                            });
                            //event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentvideo == false) {

                        $('.biderror .mes').html("<div class='pop_content'>This File Format is not supported Please Try to Upload MP4 or WebM files..");
                        $('#posterrormodal').modal('show');
                        //$("#post_something")[0].reset();
                        //setInterval('window.location.reload()', 10000);

                        $(document).on('keydown', function (e) {
                            if (e.keyCode === 27) {
                                $('#posterrormodal').modal('hide');
                                $('.modal-post').show();

                            }
                        });
                        //event.preventDefault();
                        return false;
                    }
                }

                /*var form_data = new FormData();
                $.each($("#fileInput1")[0].files, function(i, file) {
                    form_data.append('postfiles[]', file);
                });*/

               

                formFileDataSim.append('description', description);//$scope.sim.description);
                formFileDataSim.append('post_for', $scope.sim.post_for);
                //data.append('data', data);

                $('body').removeClass('modal-open');
                $("#post-popup").modal('hide');

                //$('.post_loader').show();
                $('#progress_div').show();
                var bar = $('.progress-bar');
                var percent = $('.sr-only');
                $http.post(base_url + 'user_post/post_opportunity', formFileDataSim,
                        {
                            transformRequest: angular.identity,
                            headers: {'Content-Type': undefined, 'Process-Data': false},
                            uploadEventHandlers: {
                                progress: function(e) {
                                     if (e.lengthComputable) {

                                        //document.getElementById("progress_div").style.display = "block";                                        
                                        
                                        progress = Math.round(e.loaded * 100 / e.total);

                                        bar.width((progress - 1) +'%');
                                        percent.html((progress - 1) +'%');

                                        //console.log("progress: " + progress + "%");
                                        if (e.loaded == e.total) {
                                            /*setTimeout(function(){
                                                $('#progress_div').hide();
                                                progress = 0;
                                                bar.width(progress+'%');
                                                percent.html(progress+'%');
                                            }, 2000);*/
                                            //console.log("File upload finished!");
                                            //console.log("Server will perform extra work now...");
                                        }
                                    }
                                }
                            }
                        })
                        .then(function (success) {
                            if (success) {
                                $("#post_something")[0].reset();
                                //$('.post_loader').hide();
                                $scope.sim.description = '';
                                $scope.sim.postfiles = '';
                                document.getElementById('fileInput1').value = '';
                                $('.file-preview-thumbnails').html('');
                                //$scope.postData.splice(0, 0, success.data[0]);                                
                                getUserPost(pg);

                                bar.width(100+'%');
                                percent.html(100+'%');
                                setTimeout(function(){
                                    //$('#progress_div').hide();
                                    progress = 0;
                                    // bar.width(progress+'%');
                                    // percent.html(progress+'%');
                                }, 2000);

                                imgExt = false,videoExt = false,audioExt = false,pdfExt = false;

                                cntImgSim = 0;
                                formFileDataSim = new FormData();
                                fileCountSim = 0;
                                fileNamesArrSim = [];
                                formFileExtSim = [];
                                $("#selectedFiles").html("");
                                $("#fileCountSim").text("");

                                $('video, audio').mediaelementplayer();
                            }
                        });
            }
        } else {

            var description = $('#editPostTexBox-' + post_id).html();
            description = description.replace(/&nbsp;/gi, " ");
            description = description.replace(/<br>$/, '');
            description = description.replace(/&gt;/gi, ">");
            description = description.replace(/&/g, "%26");
        

            //var description = $("#editPostTexBox-"+post_id).val();//$scope.sim.description_edit;//document.getElementById("description").value;            
            description = description.trim();
            /*if (description == '')
            {
                $('#post .mes').html("<div class='pop_content'>This post appears to be blank. Please write to post.");
                $('#post').modal('show');
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                //event.preventDefault();
                return false;
            } else {*/
                var form_data = new FormData();
                form_data.append('description', description);
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
                        $("#post_something_edit")[0].reset();
                        if (success.data.response == 1) {
                            $scope.postData[postIndex].simple_data.description = success.data.sim_description;
                            //$('#simple-post-description-' + post_id).html(success.data.sim_description);
                            //$('#simple-post-description-' + post_id).attr("dd-text-collapse-text",success.data.sim_description);
                            $('#edit-simple-post-' + post_id).hide();
                            $('#simple-post-description-' + post_id).show();
                            
                        }
                    }
                });
            //}

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

//    function check_no_post_data() {
//        var numberPost = $scope.postData.length;
//        if (numberPost == 0) {
//            $('.all_user_post').html(no_user_post_html);
//        }
//    }

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

    $scope.like_user_model_list = function (comment_id, post_id, parent_index, index, post) {
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
    
    
     $scope.lightbox = function (idx) {
                 //show the slider's wrapper: this is required when the transitionType has been set to "slide" in the ninja-slider.js
            var ninjaSldr = document.getElementById("ninja-slider");
            ninjaSldr.parentNode.style.display = "block";

            nslider.init(idx);

            var fsBtn = document.getElementById("fsBtn");
            fsBtn.click();
        alert("hiiii");
    };
    
    function fsIconClick(isFullscreen, ninjaSldr) { //fsIconClick is the default event handler of the fullscreen button
            if (isFullscreen) {
                ninjaSldr.parentNode.style.display = "none";
            }
        }

/*$(document).ready(function () {
  
   
        $(document).scroll(function(e){
          
            if (processing)
                return false;

            if ( $(window).scrollTop() >= ($(document).height() - $(window).height())*0.7 ){
                processing = true; //sets a processing AJAX request flag
                pg=parseInt(pg)+5
                getUserPost(pg)
            }
        });
    });*/
});
// $(document).on('click','.post-opportunity-modal, .post-ask-question-modal', function(){
//     $('#post-popup').modal('toggle');
// });

$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});