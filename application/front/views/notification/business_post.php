<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php if (IS_BUSINESS_CSS_MINIFY == '0') { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dragdrop/fileinput.css?ver=' . time()); ?>">
            <link href="<?php echo base_url('assets/dragdrop/themes/explorer/theme.css?ver=' . time()); ?>" media="all" rel="stylesheet" type="text/css"/>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/business.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />
        <?php } else { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dragdrop/fileinput.css?ver=' . time()); ?>">
            <link href="<?php echo base_url('assets/dragdrop/themes/explorer/theme.css?ver=' . time()); ?>" media="all" rel="stylesheet" type="text/css"/>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/business.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />
        <?php } ?>
        <style type="text/css">
            .two-images, .three-image, .four-image{
                height: auto !important;
            }
        </style>
        <style type="text/css">
            .two-images, .three-image, .four-image{
                height: auto !important;
            }
            .mejs__overlay-button {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
            .mejs__overlay-loading-bg-img {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
            .mejs__button > button {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
        </style>
    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push">
        <!-- START HEADER -->
        <?php echo $header; ?>
        <!-- END HEADER -->
        <?php echo $business_header2_border; ?>
        <section>
            <div class="user-midd-section bui_art_left_box" id="paddingtop_fixed">
                <div class="container art_container">
                    <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt" >
                        <div class="left_fixed">
                            <?php echo $business_left; ?>
                            <div class="full-box-module_follow fw fixed_right_display_none ">
                                <!-- follower list start  -->  
                                <div class="common-form">
                                    <h3 class="user_list_head">User List
                                    </h3>
                                    <div class="seeall">
                                        <a href="<?php echo base_url('business-profile/userlist/' . $business_common_data[0]['business_slug']); ?>">All User
                                        </a>
                                    </div>
                                </div>
                                <!-- GET USER FOLLOE SUGESSION LIST START [AJAX DATA DISPLAY UNDER profile-boxProfileCard_follow CLASS]-->
                                <div class="profile-boxProfileCard_follow fw  module">
                                </div>
                                <!-- GET USER FOLLOE SUGESSION LIST START -->
                                <!-- follower list end  -->
                            </div>

                             <?php echo $left_footer; ?>
                        </div>
                        <br>
                        <div id="result"></div>   
                    </div>
                    <?php
                    if ($this->session->flashdata('error')) {
                        echo $this->session->flashdata('error');
                    }
                    ?>
                    <div class=" custom-right-art mian_middle_post_box animated fadeInUp">
                        <div class="right_side_posrt fl"> 

                            <div class="business-all-post">
                                <div class="nofoundpost"> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Bid-modal  -->
        <div class="modal fade message-box biderror" id="posterrormodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="posterror-modal-close" data-dismiss="modal">&times;
                    </button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Model Popup Close -->

        <!-- Bid-modal-2  -->
        <div class="modal fade message-box" id="likeusermodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close1" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Model Popup Close -->


        <!-- Bid-modal for this modal appear or not start -->
        <div class="modal fade message-box" id="post" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" id="post"data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bid-modal for this modal appear or not  Popup Close -->

        <div class="modal fade message-box" id="postedit" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" id="postedit"data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- <footer> -->
            <?php echo $footer; ?>
        <!-- </footer> -->

        <?php if(IS_NOT_JS_MINIFY == '0'){ ?>  
        <script src="<?php echo base_url('assets/js/jquery.wallform.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script type = "text/javascript" src="<?php echo base_url('assets/js/jquery.form.3.51.js?ver=' . time()) ?>"></script> 
        <!-- POST BOX JAVASCRIPT START --> 
        <script src="<?php echo base_url('assets/dragdrop/js/plugins/sortable.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/fileinput.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/locales/fr.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/locales/es.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/themes/explorer/theme.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/demo.js?ver=' . time()); ?>"></script>

        <?php }else{?>

        <script src="<?php echo base_url('assets/js_min/jquery.wallform.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script type = "text/javascript" src="<?php echo base_url('assets/js_min/jquery.form.3.51.js?ver=' . time()) ?>"></script> 
        <!-- POST BOX JAVASCRIPT START --> 
        <script src="<?php echo base_url('assets/dragdrop/js_min/plugins/sortable.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js_min/fileinput.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js_min/locales/fr.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js_min/locales/es.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/themes/explorer/theme.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/demo.js?ver=' . time()); ?>"></script>
        <?php }?>
        <!-- POST BOX JAVASCRIPT END --> 
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var no_business_post_html = '<?php echo $no_business_post_html ?>';
            var post_id = '<?php echo $this->uri->segment(3) ?>';
        </script>
        <?php if (IS_BUSINESS_JS_MINIFY == '0') { ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/notification/business_post.js?ver=' . time()); ?>"></script>
        <?php } else {
            ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/notification/business_post.js?ver=' . time()); ?>"></script>
        <?php }
        ?>
    </body>
</html>
