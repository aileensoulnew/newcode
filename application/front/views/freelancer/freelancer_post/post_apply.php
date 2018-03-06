<!DOCTYPE html>
<html>
    <head>
        <title> <?php echo $title; ?></title>
        <?php echo $head; ?> 
        <?php
        if (IS_APPLY_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/freelancer-apply.css?ver=' . time()); ?>">
            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/freelancer-apply.css?ver=' . time()); ?>">
        <?php } ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
         <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body class="">
        <?php //echo $header; ?>
        <?php echo $freelancer_post_header2; ?>
        <section>
            <div class="user-midd-section " id="paddingtop_fixed">
                <div class="container padding-360">
                    <div class="row4">
                        <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt">
                            <div class="">
                                <div class="full-box-module">   
                                    <div class="profile-boxProfileCard  module">
                                        <div class="profile-boxProfileCard-cover"> 
                                            <a class="profile-boxProfileCard-bg u-bgUserColor a-block"
                                               href="<?php echo base_url('freelance-work/freelancer-details'); ?>"
                                               tabindex="-1"
                                               aria-hidden="true"
                                               rel="noopener">
                                                   <?php
                                                   if ($freelancerdata[0]['profile_background'] != '') {
                                                       ?>
                                                    <div class="data_img">
                                                        <img src="<?php echo FREE_POST_BG_THUMB_UPLOAD_URL . $freelancerdata[0]['profile_background']; ?>" class="bgImage" alt="<?php echo $freelancerdata[0]['freelancer_post_fullname'] . "" . $freelancerdata[0]['freelancer_post_username']; ?>" >
                                                    </div>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <div class="data_img bg-images no-cover-upload">
                                                        <img src="<?php echo base_url(WHITEIMAGE); ?>" class="bgImage" alt="No Image"  >
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </a>
                                        </div>
                                        <div class="profile-boxProfileCard-content clearfix">
                                            <div class="left_side_box_img buisness-profile-txext">
                                                <a class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock" 
                                                   href="<?php echo base_url('freelance-work/freelancer-details'); ?>" title="<?php echo $freelancerdata[0]['freelancer_post_fullname'] . ' ' . $freelancerdata[0]['freelancer_post_username']; ?>" tabindex="-1" aria-hidden="true" rel="noopener">
                                                       <?php
                                                       $filename = $this->config->item('free_post_profile_main_upload_path') . $freelancerdata[0]['freelancer_post_user_image'];
                                                       $s3 = new S3(awsAccessKey, awsSecretKey);
                                                       $info = $s3->getObjectInfo(bucket, $filename);
                                                       if ($info) {
                                                           ?>
                                                        <img src="<?php echo FREE_POST_PROFILE_MAIN_UPLOAD_URL . $freelancerdata[0]['freelancer_post_user_image']; ?>" alt="<?php echo $freelancerdata[0]['freelancer_post_fullname'] . ' ' . $freelancerdata[0]['freelancer_post_username']; ?>" >
                                                        <?php
                                                    } else {
                                                        $fname = $freelancerdata[0]['freelancer_post_fullname'];
                                                        $lname = $freelancerdata[0]['freelancer_post_username'];
                                                        $sub_fname = substr($fname, 0, 1);
                                                        $sub_lname = substr($lname, 0, 1);
                                                        ?>
                                                        <div class="post-img-profile">
                                                            <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </a>
                                            </div>
                                            <div class="right_left_box_design">
                                                <span class="profile-company-name">
                                                    <a href="<?php echo base_url('freelance-work/freelancer-details'); ?>"><?php echo ucwords($freelancerdata[0]['freelancer_post_fullname']) . ' ' . ucwords($freelancerdata[0]['freelancer_post_username']); ?></a>
                                                </span>
                                                <?php $category = $this->db->get_where('industry_type', array('industry_id' => $businessdata[0]['industriyal'], 'status' => '1'))->row()->industry_name; ?>
                                                <div class="profile-boxProfile-name">
                                                    <a  href="<?php echo base_url('freelance-work/freelancer-details'); ?>"><?php
                                                        if ($freepostdata['designation']) {
                                                            echo ucwords($freepostdata['designation']);
                                                        } else {
                                                            echo $this->lang->line("designation");
                                                        }
                                                        ?></a>
                                                </div>
                                                <ul class=" left_box_menubar">
                                                    <li <?php if (($this->uri->segment(1) == 'freelance-work') && ($this->uri->segment(2) == 'freelancer-details')) { ?> class="active" <?php } ?>><a  class="padding_less_left"  title="freelancer Details" href="<?php echo base_url('freelance-work/freelancer-details'); ?>"><?php echo $this->lang->line("details"); ?></a>
                                                    </li>
                                                    <li <?php if (($this->uri->segment(1) == 'freelance-work') && ($this->uri->segment(2) == 'saved-projects')) { ?> class="active" <?php } ?>><a title="Saved Post" href="<?php echo base_url('freelance-work/saved-projects'); ?>"><?php echo $this->lang->line("saved"); ?></a>
                                                    </li>
                                                    <li <?php if (($this->uri->segment(1) == 'freelance-work') && ($this->uri->segment(2) == 'applied-projects')) { ?> class="active" <?php } ?>><a title="Applied Post"  class="padding_less_right"  href="<?php echo base_url('freelance-work/applied-projects'); ?>"><?php echo $this->lang->line("applied"); ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>                             
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
                                 <div class="left-search-box">
                                    <div class="accordion" id="accordion2">
                                        <div class="accordion-group">
                                            <div class="accordion-heading">
                                                <h3><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" aria-expanded="true">Work Type</a></h3>
                                            </div>
                                            <div id="collapseOne" class="accordion-body collapse in" aria-expanded="true" style="">
                                                <ul class="search-listing">
                                                    <li>
                                                        <label class="control control--checkbox">Hourly
                                                            <input type="checkbox">
                                                            <div class="control__indicator"></div>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="control control--checkbox">Fixed
                                                            <input type="checkbox">
                                                            <div class="control__indicator"></div>
                                                        </label>
                                                    </li>
                                                    
                                                </ul>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="left-search-box">
                                    <div class="accordion" id="accordion2">
                                        <div class="accordion-group">
                                            <div class="accordion-heading">
                                                <h3><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" aria-expanded="true">Posting Period</a></h3>
                                            </div>
                                            <div id="collapseOne" class="accordion-body collapse in" aria-expanded="true" style="">
                                                <ul class="search-listing">
                                                    <li>
                                                        <label class="control control--checkbox">Today
                                                            <input type="checkbox">
                                                            <div class="control__indicator"></div>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="control control--checkbox">Last 7 Days
                                                            <input type="checkbox">
                                                            <div class="control__indicator"></div>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="control control--checkbox">Last 15 Days
                                                            <input type="checkbox">
                                                            <div class="control__indicator"></div>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="control control--checkbox">Last 45 Days
                                                            <input type="checkbox">
                                                            <div class="control__indicator"></div>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="control control--checkbox">More than 45 Days
                                                            <input type="checkbox">
                                                            <div class="control__indicator"></div>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                    </div>
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
                            </div>
                        </div>
                        <!-- cover pic end -->
                        <div class="custom-right-art mian_middle_post_box animated fadeInUp cust-inner-part">
                            <?php if ($this->uri->segment(3) == 'live-post') { ?>

                                <div>
                                    <?php
                                    if ($this->session->flashdata('error')) {

                                        echo '<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>';
                                    }
                                    if ($this->session->flashdata('success')) {

                                        echo '<div class="alert alert-success">' . $this->session->flashdata('success') . '</div>';
                                    }
                                    ?>
                                </div>

                                <?php
                            }
                            ?>
                            <div class="page-title">
                                <h3>Recommended Projects</h3>
                            </div>

                            <div class="job-contact-frnd1">


                            </div>
                            <div id="loader" style="display:none;"><p style="text-align:center;"><img alt="loader" src="<?php echo base_url('assets/images/loading.gif'); ?>"/></p></div>
                        </div>

                        <div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig"> 

                            <!-- <div class="all-profile-box">
                                <div class="all-pro-head">
                                    <h4>Profiles<a href="<?php echo base_url('profiles/') . $this->session->userdata('aileenuser_slug'); ?>" class="pull-right">All</a></h4>
                                </div>
                                <ul class="all-pr-list">
                                    <li>
                                        <a href="<?php echo base_url('job'); ?>">
                                            <div class="all-pr-img">
                                                <img alt="Job Profile" src="<?php echo base_url('assets/img/i1.jpg'); ?>">
                                            </div>
                                            <span>Job Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('recruiter'); ?>">
                                            <div class="all-pr-img">
                                                <img alt="Recruiter Profile" src="<?php echo base_url('assets/img/i2.jpg'); ?>">
                                            </div>
                                            <span>Recruiter Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('freelance'); ?>">
                                            <div class="all-pr-img">
                                                <img alt="Freelance Profile" src="<?php echo base_url('assets/img/i3.jpg'); ?>">
                                            </div>
                                            <span>Freelance Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('business-profile'); ?>">
                                            <div class="all-pr-img">
                                                <img alt="Business Profile" src="<?php echo base_url('assets/img/i4.jpg'); ?>">
                                            </div>
                                            <span>Business Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('artist'); ?>">
                                            <div class="all-pr-img">
                                                <img alt="Artistic Profile" src="<?php echo base_url('assets/img/i5.jpg'); ?>">
                                            </div>
                                            <span>Artistic Profile</span>
                                        </a>
                                    </li>
                                </ul>
                            </div> -->
                            <div class="edi_origde">
                                    <?php
                                    
                                    if ($count_profile == 100) {
                                        if ($freepostdata[0]['progressbar'] == 0) {
                                            ?>
                                            <div class="edit_profile_progress complete_profile">
                                                <div class="progre_bar_text">
                                                    <p>Please fill up your entire profile to get better job options and so that recruiter can find you easily.</p>
                                                </div>
                                                <div class="count_main_progress">
                                                    <div class="circles">
                                                        <div class="second circle-1 ">
                                                            <div class="true_progtree">
                                                                <img alt="Completed" src="<?php echo base_url("assets/img/true.png"); ?>">
                                                            </div>
                                                            <div class="tr_text">
                                                                Successfully Completed
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <div class="edit_profile_progress">
                                            <div class="progre_bar_text">
                                                <p>Please fill up your entire profile to get better job options and so that recruiter can find you easily.</p>
                                            </div>
                                            <div class="count_main_progress">
                                                <div class="circles">
                                                    <div class="second circle-1">
                                                        <div>
                                                            <strong></strong>

                                                            <a href="<?php echo base_url('freelance-work/basic-information') ?>" class="edit_profile_job">Edit Profile</a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            

                        </div>

                    </div>
                </div>
            </div>
        </section>
        <?php echo $footer; ?>

        <!-- Bid-modal  -->
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
        <!-- Model Popup Close -->
        <?php
        if (IS_APPLY_JS_MINIFY == '0') {
            ?>
            <script async src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/progressloader.js?ver=' . time()); ?>"></script>
            <?php
        } else {
            ?>
            <script async src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/progressloader.js?ver=' . time()); ?>"></script>
        <?php } ?>



        <script type="text/javascript">
            $(".alert").delay(3200).fadeOut(300);
            var base_url = '<?php echo base_url(); ?>';
            var count_profile_value = '<?php echo $count_profile_value; ?>';
            var count_profile = '<?php echo $count_profile; ?>';
        </script>
        <?php
        if (IS_APPLY_JS_MINIFY == '0') {
            ?>
            <script async type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/post_apply.js?ver=' . time()); ?>"></script>
            <script async type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_apply_common.js?ver=' . time()); ?>"></script>
            <script async type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/progressbar.js?ver=' . time()); ?>"></script>
            <?php
        } else {
            ?>
            <script async type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-apply/post_apply.js?ver=' . time()); ?>"></script>
            <script async type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-apply/freelancer_apply_common.js?ver=' . time()); ?>"></script>
            <script async type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-apply/progressbar.js?ver=' . time()); ?>"></script>
        <?php } ?>

        <script>
             var header_all_profile = '<?php echo $header_all_profile; ?>';
        </script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
    </body>               
</html>