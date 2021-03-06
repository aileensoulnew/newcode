<?php //echo $this->uri->segment(2);exit; ?>
<!DOCTYPE html>
<html lang="en" ng-app="userProfileApp" ng-controller="userProfileController">
    <head>
        <base href="/" >
        <title ng-bind="title"></title>
        <meta name="robots" content="noindex, nofollow">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/bootstrap.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dragdrop/fileinput.css?ver=' . time()); ?>">
        <link href="<?php echo base_url('assets/dragdrop/themes/explorer/theme.css?ver=' . time()) ?>" media="all" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css?ver=' . time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/ng-tags-input.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css') ?>">
        <link href="<?php echo base_url('8/ninja-slider.css'); ?>" rel="stylesheet" type="text/css" />
        <style type="text/css">
            .show-more-container {
                overflow: hidden;
            }

            .show-more-collapse, .show-more-expand {
                text-align: center;
                display: none;
            }

            .show-more-expanded > .show-more-collapse {
                display: inherit;
            }

            .show-more-collapsed > .show-more-expand {
                display: inherit;
            }
        </style>

    </head>
    <?php $que_cls = "";
    if($this->uri->segment(2) && $this->uri->segment(2) == "questions")
    {
        $que_cls = "questions";
    } ?>
    <body class="main-db <?php echo $que_cls; ?>">
        <?php echo $header_profile; ?>
        <?php echo $header; ?>
        <div ng-view></div>
        <?php echo $footer; ?>
        <!--PROFILE PIC MODEL START-->
        <div class="modal fade message-box" id="bidmodal-2" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>      
                    <div class="modal-body">
                        <div class="mes">
                            <div id="popup-form">

                                <div class="fw" id="profi_loader"  style="display:none; text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" alt="<?php echo 'LOADERIMAGE'; ?>"/></div>
                                <form id ="userimage" name ="userimage" class ="clearfix" enctype="multipart/form-data" method="post">
                                    <div class="fw">
                                        <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="upload-one" >
                                    </div>

                                    <div class="col-md-7 text-center">
                                        <div id="upload-demo-one" style="display:none; width:350px"></div>
                                    </div>
                                    <input type="submit" class="upload-result-one btn1" name="profilepicsubmit" id="profilepicsubmit" value="Save" >
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box custom-popup" id="other-user-profile-img" role="dialog">
            <div class="modal-dialog modal-lm">
                <button type="button" class="modal-close" data-dismiss="modal"><img src="<?php echo base_url('assets/img/left-arrow-popup.png') ?>"></button> 
                <div class="modal-content">
                         
                    <div class="modal-body">
                        <div class="mes">
                            <?php if($userdata['user_image'] != ""){ ?>
                                <img src="<?php echo USER_MAIN_UPLOAD_URL . $userdata['user_image']; ?>">
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box custom-popup" id="view-profile-img" role="dialog">
            <div class="modal-dialog modal-lm">
                <button type="button" class="modal-close" data-dismiss="modal"><img src="<?php echo base_url('assets/img/left-arrow-popup.png') ?>"></button> 
                <div class="modal-content">
                         
                    <div class="modal-body">
                        <div class="mes">
                            <?php if ($userdata['user_image'] != ''){ ?>
                                <img src="<?php echo USER_MAIN_UPLOAD_URL . $userdata['user_image']; ?>">
                            <?php } else if (strtoupper($userdata['user_gender']) == "M"){ ?>
                                <img src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                            <?php } else{ ?>
                                <img src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box custom-popup" id="view-cover-img" role="dialog">
            <div class="modal-dialog modal-lm">
                <button type="button" class="modal-close" data-dismiss="modal"><img src="<?php echo base_url('assets/img/left-arrow-popup.png') ?>"></button> 
                <div class="modal-content">
                         
                    <div class="modal-body">
                        <div class="mes">
                            <?php if($userdata['profile_background'] != ""){ ?>
                            <img src = "<?php echo USER_BG_MAIN_UPLOAD_URL . $userdata['profile_background']; ?>" name="image_src" id="image_src" alt="<?php echo $userdata['profile_background']; ?>"/>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!--PROFILE PIC MODEL END-->
        <div class="modal fade message-box" id="remove-contact" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" id="postedit"data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                            <div class="pop_content">Do you want to delete all message?<div class="model_ok_cancel"><a class="okbtn" ng-click="delete_all_history(m_a_d_message_to_profile_id)" href="javascript:void(0);" data-dismiss="modal">Yes</a><a class="cnclbtn" href="javascript:void(0);" data-dismiss="modal">No</a></div></div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/croppie.js'); ?>"></script>  
        <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/plugins/sortable.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/fileinput.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/locales/fr.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/locales/es.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/themes/explorer/theme.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/as-videoplayer/demo.js?ver=' . time()); ?>"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>
        <script src="<?php echo base_url('8/ninja-slider.js'); ?>" type="text/javascript"></script>
        <script>
                                var base_url = '<?php echo base_url(); ?>';
                                //var user_slug = '<?php echo $this->uri->segment(2); ?>';
                                var user_slug = '<?php echo $this->uri->segment(1); ?>';//Pratik
                                var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
                                var item = '<?php echo $this->uri->segment(1); ?>';
                                var live_slug = '<?php echo $this->session->userdata('aileenuser_slug'); ?>';
                                //var segment2 = '<?php echo $this->uri->segment(2); ?>';
                                var segment2 = '<?php echo $this->uri->segment(1); ?>';//Pratik
                                var user_data_slug = '<?php echo $userdata['user_slug']; ?>';
                                var to_id = '<?php echo $to_id; ?>';
                                var contact_value = '<?php echo $contact_value; ?>';
                                var contact_status = '<?php echo $contact_status; ?>';
                                var contact_id = '<?php echo $contact_id; ?>';
                                var follow_value = '<?php echo $follow_value; ?>';
                                var follow_status = '<?php echo $follow_status; ?>';
                                var follow_id = '<?php echo $follow_id; ?>';
                                var is_userPostCount = '<?php echo $is_userPostCount; ?>';
                                var header_all_profile = '<?php echo $header_all_profile; ?>';
                                var app = angular.module("userProfileApp", ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize']);
        </script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/classie.js?ver=' . time()) ?>"></script>
        <script>
    		var menuRight = document.getElementById( 'cbp-spmenu-s2' ),
    			showRight = document.getElementById( 'showRight' ),
    			body = document.body;

    		showRight.onclick = function() {
    			classie.toggle( this, 'active' );
    			classie.toggle( menuRight, 'cbp-spmenu-open' );
    			disableOther( 'showRight' );
    		};
    	
    		function disableOther( button ) {
    			
    			if( button !== 'showRight' ) {
    				classie.toggle( showRight, 'disabled' );
    			}
    		}
    		
    		$(function () {
    			$('a[href="#search"]').on('click', function (event) {
    				event.preventDefault();
    				$('#search').addClass('open');
    				$('#search > form > input[type="search"]').focus();
    			});
    			$('#search, #search button.close-new').on('click keyup', function (event) {
    				if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
    					$(this).removeClass('open');
    				}
    			});
    		});
    	
            jQuery(document).ready(function($) {
                $("li.user-id label").click(function(e){
                    $(this).next('ul.dropdown-menu').toggle();
                    e.stopPropagation();
                    });
            });
        </script>
    </body>
</html>