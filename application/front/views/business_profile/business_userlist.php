<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>
        <?php
        if (IS_BUSINESS_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/business.css?ver=' . time()); ?>">
            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/business.css?ver=' . time()); ?>">
        <?php } ?>
    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push user-list">
        <?php echo $header; ?>
        <?php echo $business_header2_border; ?>
        <section>
            <div class="container" id="paddingtop_fixed">
            </div>
            <div class="user-midd-section bui_art_left_box">
                <div class="container art_container padding-360">
                    <div class="">
                        <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt" >
                            <div class="left_fixed">
                                <?php echo $business_left ?>
                            </div>
                            <?php echo $left_footer; ?>
                        </div>
                        <div class="custom-right-art mian_middle_post_box animated fadeInUp">
                            <div class="">  
                                <div class="right_side_posrt fl"> 
                                    <div class="common-form">
                                        <div class="job-saved-box">
                                            <h3>User list</h3>
                                            <div class="contact-frnd-post">
                                                <!-- AJAX DATA... -->

                                                 <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" alt="Loader" /></div>
                                            </div>
                                           
                                            <div class="col-md-1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig"> 

                            <div class="all-profile-box">
                                <div class="all-pro-head">
                                    <h4>Profiles<a href="<?php echo base_url('profiles/') . $this->session->userdata('aileenuser_slug'); ?>" class="pull-right">All</a></h4>
                                </div>
                                <ul class="all-pr-list">
                                    <li>
                                        <a href="<?php echo base_url('job') ?>">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i1.png?ver=' . time()) ?>" alt="Job Profile">
                                            </div>
                                            <span>Job Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('recruiter') ?>">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i2.jpg?ver=' . time()) ?>" alt="Recruiter Profile">
                                            </div>
                                            <span>Recruiter Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('freelance') ?>">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i3.jpg?ver=' . time()) ?>" alt="Freelance Profile"> 
                                            </div>
                                            <span>Freelance Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('business-profile') ?>">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i4.jpg?ver=' . time()) ?>" alt="Business Profile">
                                            </div>
                                            <span>Business Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('artist') ?>">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i5.jpg?ver=' . time()) ?>" alt="Artistic Profile">
                                            </div>
                                            <span>Artistic Profile</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <?php echo $footer; ?>
        <div class="modal fade message-box biderror" id="bidmodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box" id="bidmodal-2" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                            <div id="popup-form">
                                <?php echo form_open_multipart(base_url('business_profile/user_image_insert'), array('id' => 'userimage', 'name' => 'userimage', 'class' => 'clearfix')); ?>
                                <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="profilepic">
                                <input type="hidden" name="hitext" id="hitext" value="6">
                                <div class="popup_previred">
                                    <img id="preview" src="#" alt="your image" /></div>
                                <input type="submit" name="profilepicsubmit" id="profilepicsubmit" value="Save" >
                                <?php echo form_close(); ?>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var base_url = '<?php echo base_url(); ?>';
        </script>

        <?php if (IS_BUSINESS_JS_MINIFY == '0') { ?>
            <script src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/userlist.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
        <?php } else { ?>
            <script src="<?php echo base_url('assets/js_min/croppie.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/business-profile/userlist.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js_min/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
        <?php } ?>
    </body>
</html>