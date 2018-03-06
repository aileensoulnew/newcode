<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?> 
        <?php
            if (IS_REC_CSS_MINIFY == '0') {
                ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css'); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/recruiter.css'); ?>">
        <?php
            } else {
                ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css'); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/recruiter.css'); ?>">
        <?php } ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push">
        <?php echo $recruiter_header2; ?>
        <?php if ($recdata['re_step'] == 3) { ?>
        <?php// echo $recruiter_header2_border; ?>
        <?php } ?>
        <div id="preloader"></div>
        <!-- START CONTAINER -->
        <section>
            <!-- MIDDLE SECTION START -->
            <div class="user-midd-section" id="paddingtop_fixed">
                <div class="container padding-360">
                    <div class="">
                        <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt">
                            <div class="">
                                <div class="full-box-module">
                                    <div class="profile-boxProfileCard  module">
                                        <div class="profile-boxProfileCard-cover">
                                            <a title="Recruiter profile" class="profile-boxProfileCard-bg u-bgUserColor a-block" href="<?php echo base_url('recruiter/profile/' . $recdata['user_id']); ?>" tabindex="-1" 
                                                aria-hidden="true" rel="noopener">
                                                <div class="bg-images no-cover-upload"> 
                                                    <?php
                                                        $image_ori = $recdata['profile_background'];
                                                        $filename = $this->config->item('rec_bg_main_upload_path') . $recdata['profile_background'];
                                                        $s3 = new S3(awsAccessKey, awsSecretKey);
                                                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                        if ($info && $recdata['profile_background'] != '') {
                                                            ?>
                                                    <img src = "<?php echo REC_BG_MAIN_UPLOAD_URL . $recdata['profile_background']; ?>" name="image_src" id="image_src" alt="<?php echo $recdata['profile_background']; ?>"/>
                                                    <?php
                                                        } else {
                                                            ?>
                                                    <img src="<?php echo base_url(WHITEIMAGE); ?>" class="bgImage" alt="<?php echo $recdata['rec_firstname'] . ' ' . $recdata['rec_lastname']; ?>" >
                                                    <?php
                                                        }
                                                        ?>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="profile-boxProfileCard-content clearfix">
                                            <div class="left_side_box_img buisness-profile-txext">
                                                <a title="Recruiter profile" class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock"  href="<?php echo base_url('recruiter/profile/' . $recdata['user_id']); ?>" title="<?php echo $recdata['rec_firstname'] . ' ' . $recdata['rec_lastname']; ?>" tabindex="-1" aria-hidden="true" rel="noopener">
                                                    <?php
                                                        $filename = $this->config->item('rec_profile_thumb_upload_path') . $recdata['recruiter_user_image'];
                                                        $s3 = new S3(awsAccessKey, awsSecretKey);
                                                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                        if ($recdata['recruiter_user_image'] != '' && $info) {
                                                            ?>
                                                    <img src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL . $recdata['recruiter_user_image']; ?>" alt="<?php echo $recdata['recruiter_user_image']; ?>" >
                                                    <?php
                                                        } else {
                                                        
                                                        
                                                            $a = $recdata['rec_firstname'];
                                                            $acr = substr($a, 0, 1);
                                                        
                                                            $b = $recdata['rec_lastname'];
                                                            $acr1 = substr($b, 0, 1);
                                                            ?>
                                                    <div class="post-img-profile">
                                                        <?php echo ucfirst(strtolower($acr)) . ucfirst(strtolower($acr1)); ?>
                                                    </div>
                                                    <?php
                                                        }
                                                        ?>
                                                </a>
                                            </div>
                                            <div class="right_left_box_design ">
                                                <span class="profile-company-name ">
                                                <a href="<?php echo site_url('recruiter/profile/' . $recdata['user_id']); ?>" title="<?php echo ucfirst(strtolower($recdata['rec_firstname'])) . ' ' . ucfirst(strtolower($recdata['rec_lastname'])); ?>">   <?php echo ucfirst(strtolower($recdata['rec_firstname'])) . ' ' . ucfirst(strtolower($recdata['rec_lastname'])); ?></a>
                                                </span>
                                                <div class="profile-boxProfile-name">
                                                    <a href="<?php echo site_url('recruiter/profile/' . $recdata['user_id']); ?>" title="<?php echo ucfirst(strtolower($recdata['designation'])); ?>">
                                                    <?php
                                                        if (ucfirst(strtolower($recdata['designation']))) {
                                                            echo ucfirst(strtolower($recdata['designation']));
                                                        } else {
                                                            echo "Designation";
                                                        }
                                                        ?></a>
                                                </div>
                                                <ul class=" left_box_menubar">
                                                    <li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'profile') { ?> class="active" <?php } ?>><a class="padding_less_left" title="Details" href="<?php echo base_url('recruiter/profile/' . $recdata['user_id']); ?>"> Details</a>
                                                    </li>
                                                    <li id="rec_post_home" <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'post') { ?> class="active" <?php } ?>><a title="Post" href="<?php echo base_url('recruiter/post/' . $recdata['user_id']); ?>">Post</a>
                                                    </li>
                                                    <li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'save-candidate') { ?> class="active" <?php } ?>><a title="Saved Candidate" class="padding_less_right" href="<?php echo base_url('recruiter/save-candidate/' . $recdata['user_id']); ?>">Saved </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="left-search-box list-type-bullet">
                                    <div class="">
                                        <h3>Job Title</h3>
                                    </div>
                                    <ul class="search-listing">
                                        <li>
                                            <label class=""><a href="#">PHP Developer<span class="pull-right">(50)</span></a></label>
                                        </li>
                                        <li>
                                            <label class=""><a href="#">Mobile App developer<span class="pull-right">(50)</span></a></label>
                                        </li>
                                        <li>
                                            <label class=""><a href="#">Banking<span class="pull-right">(50)</span></a></label>
                                        </li>
                                        <li>
                                            <label class=""><a href="#">IT<span class="pull-right">(50)</span></a></label>
                                        </li>
                                        <li>
                                            <label class=""><a href="#">IT<span class="pull-right">(50)</span></a></label>
                                        </li>
                                        <li>
                                            <label class=""><a href="#">IT<span class="pull-right">(50)</span></a></label>
                                        </li>
                                        <li>
                                            <label class=""><a href="#">IT<span class="pull-right">(50)</span></a></label>
                                        </li>
                                        
                                    </ul>
                                    <p class="text-right p10"><a href="#">More Categories</a></p>
                                </div>
                                <div class="left-search-box list-type-bullet">
                                    <div class="">
                                        <h3>Top Categories</h3>
                                    </div>
                                    <ul class="search-listing">
                                        <li>
                                            <label class=""><a href="#">IT<span class="pull-right">(50)</span></a></label>
                                        </li>
                                        <li>
                                            <label class=""><a href="#">Admin<span class="pull-right">(50)</span></a></label>
                                        </li>
                                        <li>
                                            <label class=""><a href="#">Banking<span class="pull-right">(50)</span></a></label>
                                        </li>
                                        <li>
                                            <label class=""><a href="#">IT<span class="pull-right">(50)</span></a></label>
                                        </li>
                                        <li>
                                            <label class=""><a href="#">IT<span class="pull-right">(50)</span></a></label>
                                        </li>
                                        <li>
                                            <label class=""><a href="#">IT<span class="pull-right">(50)</span></a></label>
                                        </li>
                                        <li>
                                            <label class=""><a href="#">IT<span class="pull-right">(50)</span></a></label>
                                        </li>
                                        
                                    </ul>
                                    <p class="text-right p10"><a href="#">More Categories</a></p>
                                </div>
                                <div class="left-search-box list-type-bullet">
                                    <div class="">
                                        <h3>Top Cities</h3>
                                    </div>
                                    <ul class="search-listing">
                                        <li>
                                            <label class=""><a href="#">Ahmedabad<span class="pull-right">(50)</span></a></label>
                                        </li>
                                        <li>
                                            <label class=""><a href="#">New York<span class="pull-right">(50)</span></a></label>
                                        </li>
                                        <li>
                                            <label class=""><a href="#">Adelaide<span class="pull-right">(50)</span></a></label>
                                        </li>
                                        <li>
                                            <label class=""><a href="#">Sydney<span class="pull-right">(50)</span></a></label>
                                        </li>
                                        <li>
                                            <label class=""><a href="#">Lahore<span class="pull-right">(50)</span></a></label>
                                        </li>
                                       
                                        
                                    </ul>
                                    <p class="text-right p10"><a href="#">More Cities</a></p>
                                </div>
                                <div class="left-search-box list-type-bullet">
                                    <div class="">
                                        <h3>Skills</h3>
                                    </div>
                                    <ul class="search-listing">
                                        <li>
                                            <label class=""><a href="#">Photoshop<span class="pull-right">(50)</span></a></label>
                                        </li>
                                        <li>
                                            <label class=""><a href="#">Photoshop<span class="pull-right">(50)</span></a></label>
                                        </li>
                                        <li>
                                            <label class=""><a href="#">Photoshop<span class="pull-right">(50)</span></a></label>
                                        </li>
                                        <li>
                                            <label class=""><a href="#">Photoshop<span class="pull-right">(50)</span></a></label>
                                        </li>
                                        <li>
                                            <label class=""><a href="#">Photoshop<span class="pull-right">(50)</span></a></label>
                                        </li>
                                        <li>
                                            <label class=""><a href="#">Photoshop<span class="pull-right">(50)</span></a></label>
                                        </li>
                                        <li>
                                            <label class=""><a href="#">Photoshop<span class="pull-right">(50)</span></a></label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="left-search-box">
                                    <div class="accordion" id="accordion3">
                                        <div class="accordion-group">
                                            <div class="accordion-heading">
                                                <h3><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapsetwo" aria-expanded="true">Required Experience</a></h3>
                                            </div>
                                            <div id="collapsetwo" class="accordion-body collapse in" aria-expanded="true" style="">
                                                <div class="accordion-inner">
                                                    <ul class="search-listing">
                                                        <li>
                                                            <label class="control control--checkbox">0 to 1 year
                                                                <input type="checkbox">
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="control control--checkbox">1 to 2 year
                                                                <input type="checkbox">
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="control control--checkbox">2 to 3 year
                                                                <input type="checkbox">
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="control control--checkbox">3 to 4 year
                                                                <input type="checkbox">
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="control control--checkbox">4 to 5 year
                                                                <input type="checkbox">
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="control control--checkbox">More than 5 year
                                                                <input type="checkbox">
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    
                                    </div>
                                </div>

                                <?php echo $left_footer; ?>
                                <div  class="add-post-button">
                                    <a class="btn btn-3 btn-3b"  href="<?php echo base_url('recruiter/add-post'); ?>" title="Recruiter Add Post"><i class="fa fa-plus" aria-hidden="true"></i>  Post a Job</a>
                                </div>
                                <?php //}  ?>
                                <div id="khyati"></div>
                            </div>
                        </div>
                        <!--- search end -->
                        <div class="custom-right-art mian_middle_post_box animated fadeInUp">
                            <div class="common-form ">
                                <div class="job-saved-box">
                                    <h3>
                                        Recommended Candidate
                                    </h3>
                                    <div class="contact-frnd-post">
                                        <div class = "job-contact-frnd">
                                            <!--AJAX DATA START FOR RECOMMAND CANDIDATE-->
                                        </div>
                                        <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" alt=""<?php echo "LOADERIMAGE"?>/></div>
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
                                        <a href="<?php echo base_url('job'); ?>" title="Job Profile">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i1.jpg'); ?>" alt="<?php echo "JOABIMAGE"?>">
                                            </div>
                                            <span>Job Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('recruiter'); ?>" title="Recruiter Profile">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i2.jpg'); ?>" alt="<?php echo "RECIMAGE"?>">
                                            </div>
                                            <span>Recruiter Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('freelance'); ?>" title="Freelancer Profile">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i3.jpg'); ?>" alt="<?php echo "FREELANCERIMAGE"?>">
                                            </div>
                                            <span>Freelance Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('business-profile'); ?>" title="Business Profile">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i4.jpg'); ?>" alt="<?php echo "BUSINESSIMAGE"?>">
                                            </div>
                                            <span>Business Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('artist'); ?>" title="Artist Profile">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i5.jpg'); ?>" alt="<?php echo "ARTISTIMAGE"?>">
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
            <!-- MIDDLE SECTION END -->
        </section>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <!-- BID MODAL START -->
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
        <!-- BID MODAL END-->
        <!-- START FOOTER -->
        <?php echo $footer; ?>
        <!-- END FOOTER -->
        <!-- FIELD VALIDATION JS START -->
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var get_csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
            var get_csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
        </script>
        <script>
            var header_all_profile = '<?php echo $header_all_profile; ?>';
        </script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <!-- FIELD VALIDATION JS END -->
        <?php
            if (IS_REC_JS_MINIFY == '0') {
                ?>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/search.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/recommen_candidate.js'); ?>"></script>
        <?php
            } else {
                ?>
        <script src="<?php echo base_url('assets/js_min/bootstrap.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/recruiter/search.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/recruiter/recommen_candidate.js'); ?>"></script>
        <?php } ?>
    </body>
</html>