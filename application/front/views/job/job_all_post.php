<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>

        <?php
        if (IS_JOB_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver=' . time()); ?>">

        <?php } else { ?>

            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/job.css?ver=' . time()); ?>">


        <?php } ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
    </head>

    <!-- END HEAD -->
    <!-- Start HEADER -->

    <!-- END HEADER -->
    <body class="page-container-bg-solid page-boxed pushmenu-push" style="overflow-x: hidden;">
        <?php
        //echo $header;
        echo $job_header2;//$job_header2_border;
        ?>
        <div class="user-midd-section" id="paddingtop_fixed">
            <div class="container padding-360" >
                <div class="">
                    <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt">
                        <div class="">
                            <div class="full-box-module">
                                <div class="profile-boxProfileCard  module">
                                    <div class="profile-boxProfileCard-cover <?php
                                    if ($jobdata[0]['profile_background'] == '') {
                                        echo "bg-images no-cover-upload";
                                    }
                                    ?>">
                                        <a class="profile-boxProfileCard-bg u-bgUserColor a-block"
                                           href="<?php echo base_url('job/resume/' . $jobdata[0]['slug']); ?>"
                                           tabindex="-1"
                                           aria-hidden="true"
                                           rel="noopener" title="job resume">
                                               <?php
                                               if ($jobdata[0]['profile_background'] != '') {
                                                   ?>
                                                <!-- box image start -->
                                                <img src="<?php echo JOB_BG_MAIN_UPLOAD_URL . $jobdata[0]['profile_background']; ?>" class="bgImage" alt="<?php echo $jobdata[0]['profile_background']; ?>" >
                                                <!-- box image end -->
                                                <?php
                                            } else {
                                                ?>
                                                <img src="<?php echo base_url(WHITEIMAGE); ?>" class="bgImage" alt="<?php echo 'NOIMAGE'; ?>">
                                                <?php
                                            }
                                            ?>
                                        </a>
                                    </div>
                                    <div class="profile-boxProfileCard-content clearfix">
                                        <div class="left_side_box_img buisness-profile-txext">
                                            <a class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock"  href="<?php echo base_url('job/resume/' . $jobdata[0]['slug']); ?>" title="<?php echo $jobdata[0]['fname']; ?>" tabindex="-1" aria-hidden="true" rel="noopener">
                                                <?php
                                                if ($jobdata[0]['job_user_image']) {
                                                    ?>
                                                    <div class="left_iner_img_profile"><img src="<?php echo JOB_PROFILE_THUMB_UPLOAD_URL . $jobdata[0]['job_user_image']; ?>" alt="<?php echo $jobdata[0]['fname']; ?>" ></div>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <div class="data_img_2">
                                                        <?php
                                                        $a = $jobdata[0]['fname'];
                                                        $acronym = substr($a, 0, 1);
                                                        $b = $jobdata[0]['lname'];
                                                        $acronym1 = substr($b, 0, 1);
                                                        ?>
                                                        <div class="post-img-profile">
                                                        <?php echo ucfirst(strtolower($acronym)) . ucfirst(strtolower($acronym1)); ?>
                                                        </div>
                                                    </div>
                                                        <?php
                                                    }
                                                    ?>
                                            </a>
                                        </div>
                                        <div class="right_left_box_design ">
                                            <span class="profile-company-name ">
                                                <span class="profile-company-name ">
                                                    <a   href="<?php echo site_url('job/resume/' . $jobdata[0]['slug']); ?>" title="<?php echo $jobdata[0]['slug']; ?>">  <?php echo ucfirst($jobdata[0]['fname']) . ' ' . ucfirst($jobdata[0]['lname']); ?></a>
                                                </span>
                                            </span>
                                            <?php $category = $this->db->get_where('industry_type', array('industry_id' => $businessdata[0]['industriyal'], 'status' => '1'))->row()->industry_name; ?>
                                            <div class="profile-boxProfile-name">
                                                <a  href="<?php echo base_url('job/resume/' . $jobdata[0]['slug']); ?>" title="<?php echo $jobdata[0]['slug']; ?>"><?php
                                            if (ucwords($jobdata[0]['designation'])) {
                                                echo ucwords($jobdata[0]['designation']);
                                            } else {
                                                echo "Current Work";
                                            }
                                            ?></a>
                                            </div>
                                            <ul class=" left_box_menubar">
                                                <li <?php if ($this->uri->segment(1) == 'job' && $this->uri->segment(2) == 'resume') { ?> class="active" <?php } ?>>
                                                    <a class="padding_less_left" title="Details" href="<?php echo base_url('job/resume/' . $jobdata[0]['slug']); ?>"> Details</a>
                                                </li>
                                                <?php if (($this->uri->segment(1) == 'job') && ($this->uri->segment(2) == 'home' || $this->uri->segment(2) == 'resume' || $this->uri->segment(2) == 'job_resume' || $this->uri->segment(2) == 'saved-job' || $this->uri->segment(2) == 'applied-job') && ($this->uri->segment(3) == $this->session->userdata('aileenuser') || $this->uri->segment(3) == '' || $this->uri->segment(3) == 'live-post')) { ?>
                                                    <li <?php if ($this->uri->segment(1) == 'job' && $this->uri->segment(2) == 'saved-job') { ?> class="active" <?php } ?>><a title="Saved Job" href="<?php echo base_url('job/saved-job'); ?>">Saved </a>
                                                    </li>
                                                    <li <?php if ($this->uri->segment(1) == 'job' && $this->uri->segment(2) == 'applied-job') { ?> class="active" <?php } ?>><a class="padding_less_right" title="Applied Job" href="<?php echo base_url('job/applied-job'); ?>">Applied </a>
                                                    </li>
                                                <?php } ?>
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

                            <div class="edi_origde">
                                    <?php
                                    if ($count_profile == 100) {
                                        if ($job_reg[0]['progressbar'] == 0) {
                                            ?>
                                        <div class="edit_profile_progress complete_profile">
                                            <div class="progre_bar_text">
                                                <p>Please fill up your entire profile to get better job options and so that recruiter can find you easily.</p>
                                            </div>
                                            <div class="count_main_progress">
                                                <div class="circles">
                                                    <div class="second circle-1 ">
                                                        <div class="true_progtree">
                                                            <img src="<?php echo base_url("assets/img/true.png"); ?>" alt="<?php echo 'successimage'; ?>">
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


                                                        <a href="<?php echo base_url('job/basic-information') ?>" class="edit_profile_job" title="Edit profile">Edit Profile</a>



                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>

                        <?php echo $left_footer; ?>
                        </div>
                    </div>
                    <div>

                    </div>
                    <div class="custom-right-art mian_middle_post_box animated fadeInUp">
                            <?php
                            if ($this->uri->segment(3) == 'live-post') {
                                echo '<div class="alert alert-success">Applied successfully...!</div>';
                            }
                            ?>
                        <div class="page-title">
                            <h3>Recommended Job</h3>
                        </div>

                        <div class="job-contact-frnd1">

                        </div>
                        <div id="loader" style="display: none;"><p style="text-align:center;"><img src="<?php echo base_url('assets/images/loading.gif'); ?>" alt="<?php echo 'loaderimage'; ?>"/></p></div>
                    </div>


                    <div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig" style="position: absolute;"> 
                        <div class="full-box-module">   
                            <div class="">
                                <div class=""> 
                                    <div class="cust-div-h3">
                                        <h3 style="color: #5c5c5c;text-align: center;font-size: 24px;">Job by Location</h3>
                                    </div>
                                    <ul class="jobs-loca-cus" style="list-style-type: none;padding-left: 10px;">
                                        <li>
                                            <label for="City" class="lbpos fw">
                                                <a href="<?php echo base_url("jobs"); ?>" >All Jobs</a>
                                            </label>
                                        </li>
                                        <li>
                                            <label for="City" class="lbpos fw">
                                                <a href="<?php echo base_url("jobs-in-Ahmedabad"); ?>" <?php if ($keyword1 == 'Ahmedabad') { ?> class="job_active" <?php } ?>>Ahmedabad Jobs</a>
                                            </label>
                                        </li>
                                        <li>
                                            <label for="City" class="lbpos fw">
                                                <a href="<?php echo base_url("jobs-in-Bengaluru"); ?>" <?php if ($keyword1 == 'Bengaluru') { ?> class="job_active" <?php } ?>>Bengaluru Jobs</a>
                                            </label>
                                        </li>
                                        <li>
                                            <label for="City" class="lbpos fw"> 
                                                <a href="<?php echo base_url("jobs-in-Chennai"); ?>" <?php if ($keyword1 == 'Chennai') { ?> class="job_active" <?php } ?>>Chennai Jobs</a>
                                            </label>
                                        </li>
                                        <li>
                                            <label for="City" class="lbpos fw">
                                                <a href="<?php echo base_url("jobs-in-Delhi"); ?>" <?php if ($keyword1 == 'Delhi') { ?> class="job_active" <?php } ?>>Delhi Jobs</a>
                                            </label>
                                        </li>
                                        <li>
                                            <label for="City" class="lbpos fw">
                                                <a href="<?php echo base_url("jobs-in-Hyderabad"); ?>" <?php if ($keyword1 == 'Hyderabad') { ?> class="job_active" <?php } ?>>Hyderabad Jobs</a>
                                            </label>
                                        </li>
                                        <li>
                                            <label for="City" class="lbpos fw">
                                                <a href="<?php echo base_url("jobs-in-Mumbai"); ?>" <?php if ($keyword1 == 'Mumbai') { ?> class="job_active" <?php } ?>>Mumbai Jobs</a>
                                            </label>
                                        </li>
                                        <li>
                                            <label for="City" class="lbpos fw">
                                                <a href="<?php echo base_url("jobs-in-Pune"); ?>" <?php if ($keyword1 == 'Pune') { ?> class="job_active" <?php } ?>>Pune Jobs</a>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="all-profile-box">
                            <div class="all-pro-head">
                                <h4>Profiles<a href="<?php echo base_url('profiles/') . $this->session->userdata('aileenuser_slug'); ?>" class="pull-right" title="All">All</a></h4>
                            </div>
                            <ul class="all-pr-list">
                                <li>
                                    <a href="<?php echo base_url('job'); ?>" title="job">
                                        <div class="all-pr-img">
                                            <img src="<?php echo base_url('assets/img/i1.jpg'); ?>" alt="<?php echo 'job profile'; ?>">
                                        </div>
                                        <span>Job Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('recruiter'); ?>" title="recruiter">
                                        <div class="all-pr-img">
                                            <img src="<?php echo base_url('assets/img/i2.jpg'); ?>"  alt="<?php echo 'recruiter profile'; ?>">
                                        </div>
                                        <span>Recruiter Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('freelance'); ?>" title="freelancer">
                                        <div class="all-pr-img">
                                            <img src="<?php echo base_url('assets/img/i3.jpg'); ?>" alt="<?php echo 'freelancer profile'; ?>">
                                        </div>
                                        <span>Freelance Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('business-profile'); ?>" title="business-profile">
                                        <div class="all-pr-img">
                                            <img src="<?php echo base_url('assets/img/i4.jpg'); ?>" alt="<?php echo 'business profile'; ?>">
                                        </div>
                                        <span>Business Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('artist'); ?>" title="artist">
                                        <div class="all-pr-img">
                                            <img src="<?php echo base_url('assets/img/i5.jpg'); ?>" alt="artist">
                                        </div>
                                        <span>Artistic Profile</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                       


                    </div>

                    </section>
                    <!-- Model Popup Open -->
                    <!-- Bid-modal  -->
                    <div class="modal message-box biderror" id="bidmodal" role="dialog">
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

<?php echo $footer; ?>


                    <!-- script for skill textbox automatic start-->

                    <!-- script for skill textbox automatic end -->

<?php
if (IS_JOB_JS_MINIFY == '0') {
    ?>

                        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
                        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>

                        <script type="text/javascript" src="<?php echo base_url('assets/js/progressloader.js?ver=' . time()); ?>"></script>
<?php } else { ?>
                        <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()) ?>"></script>
                        <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>

                        <script type="text/javascript" src="<?php echo base_url('assets/js_min/progressloader.js?ver=' . time()); ?>"></script>

<?php } ?>
                    <script>
                                $(".alert").delay(3200).fadeOut(300);

                                var base_url = '<?php echo base_url(); ?>';
                                var count_profile_value = '<?php echo $count_profile_value; ?>';
                                var count_profile = '<?php echo $count_profile; ?>';
                    </script>
                    <script>
                         var header_all_profile = '<?php echo $header_all_profile; ?>';
                    </script>
                    <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>

<?php
if (IS_JOB_JS_MINIFY == '0') {
    ?>
                        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/job_all_post.js?ver=' . time()); ?>"></script>
                        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/search_common.js?ver=' . time()); ?>"></script>
                        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/progressbar_common.js?ver=' . time()); ?>"></script>

<?php } else { ?>

                        <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/job/job_all_post.js?ver=' . time()); ?>"></script>
                        <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/job/search_common.js?ver=' . time()); ?>"></script>
                        <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/job/progressbar_common.js?ver=' . time()); ?>"></script>

<?php } ?>
                    </body>
                    </html>