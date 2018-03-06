<!DOCTYPE html>
<html>
    <head>
        <!-- start head -->
        <?php echo $head; ?>
        <!-- END HEAD -->

        <title><?php echo $title; ?></title>

<?php
        if (IS_JOB_CSS_MINIFY == '0') {
            ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver=' . time()); ?>">

        <?php }else{?>

         <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/job.css?ver=' . time()); ?>">
        <?php }?>
    </head>
    <!-- END HEAD -->
    <!-- Start HEADER -->
    <?php
    echo $header;
    echo $job_header2_border;
    ?>
    <!-- END HEADER -->
    <body class="page-container-bg-solid page-boxed">
        <div class="user-midd-section" id="paddingtop_fixed">
            <div class="container padding-360">
                <div class="row4">
                    <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt">
                        <div class="">
                            <div class="full-box-module">
                                <div class="profile-boxProfileCard  module">
                                    <div class="profile-boxProfileCard-cover <?php if ($jobdata[0]['profile_background'] == '') {
        echo "bg-images no-cover-upload";
    } ?>">
                                        <a class="profile-boxProfileCard-bg u-bgUserColor a-block"
                                           href="<?php echo base_url('job/resume/'.$jobdata[0]['slug']); ?>"
                                           tabindex="-1"
                                           aria-hidden="true"
                                           rel="noopener" title="job resume">
                                            <div class="bg-images no-cover-upload"> 
                                                <?php
                                                if ($jobdata[0]['profile_background'] != '') {
                                                    ?>
                                                    <!-- box image start -->
                                                    <img src="<?php echo JOB_BG_MAIN_UPLOAD_URL . $jobdata[0]['profile_background']; ?>" class="bgImage" alt="<?php echo $jobdata[0]['profile_background']; ?>" >
                                                    <!-- box image end -->
                                                    <?php
                                                } else {
                                                    ?>
                                                    <img src="<?php echo base_url(WHITEIMAGE); ?>" class="bgImage" alt="NOIMAGE">
                                                    <?php
                                                }
                                                ?>
                                                </a>
                                            </div>
                                    </div>
                                    <div class="profile-boxProfileCard-content clearfix">
                                        <div class="left_side_box_img buisness-profile-txext">
                                            <a class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock"  href="<?php echo base_url('job/resume/' . $jobdata[0]['slug']); ?>" title="<?php echo $jobdata[0]['fname']; ?>" tabindex="-1" aria-hidden="true" rel="noopener">
                                                <?php
                                                if ($jobdata[0]['job_user_image']) {
                                                    ?>
                                                    <div class="left_iner_img_profile"><img src="<?php echo JOB_PROFILE_THUMB_UPLOAD_URL . $jobdata[0]['job_user_image']; ?>" alt="<?php echo $jobdata[0]['fname']; ?> " ></div>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <div class="data_img_2">
                                                        <?php
                                                        $a = $jobdata[0]['fname'];
                                                        $words = explode(" ", $a);
                                                        foreach ($words as $w) {
                                                            $acronym .= $w[0];
                                                        }
                                                        ?>
                                                        <?php
                                                        $b = $jobdata[0]['lname'];
                                                        $words = explode(" ", $b);
                                                        foreach ($words as $w) {
                                                            $acronym1 .= $w[0];
                                                        }
                                                        ?>
                                                        <div>
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
                                                    <a   href="<?php echo site_url('job/resume/'.$jobdata[0]['slug']); ?>" title="<?php echo ucfirst($jobdata[0]['fname']) . ' ' . ucfirst($jobdata[0]['lname']); ?>">  <?php echo ucfirst($jobdata[0]['fname']) . ' ' . ucfirst($jobdata[0]['lname']); ?></a>
                                                </span>
                                            </span>
                                                    <?php $category = $this->db->get_where('industry_type', array('industry_id' => $businessdata[0]['industriyal'], 'status' => '1'))->row()->industry_name; ?>
                                            <div class="profile-boxProfile-name">
                                                <a  href="<?php echo base_url('job/resume/'.$jobdata[0]['slug']); ?>" title="designation"><?php
                                                    if (ucwords($jobdata[0]['designation'])) {
                                                        echo ucwords($jobdata[0]['designation']);
                                                    } else {
                                                        echo "Current Work";
                                                    }
                                                    ?></a>
                                            </div>
                                            <ul class=" left_box_menubar">
                                                <li <?php if ($this->uri->segment(1) == 'job' && $this->uri->segment(2) == 'resume') { ?> class="active" <?php } ?>>
                                                    <a class="padding_less_left" title="Details" href="<?php echo base_url('job/resume/'.$jobdata[0]['slug']); ?>" title="job resume"> Details</a>
                                                </li>
                                                
                                                <li <?php if ($this->uri->segment(1) == 'search' && $this->uri->segment(2) == 'saved-job') { ?> class="active" <?php } ?>><a title="Saved Job" href="<?php echo base_url('job/saved-job'); ?>" title="Saved">Saved </a>
                                                </li>
                                                <li <?php if ($this->uri->segment(1) == 'job' && $this->uri->segment(2) == 'applied-job') { ?> class="active" <?php } ?>><a class="padding_less_right" title="Applied Job" href="<?php echo base_url('job/applied-job'); ?>" title="Applied">Applied </a>
                                                </li>
<?php // }  ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <?php echo $left_footer; ?>
                        </div>
                    </div>
                    <div class="custom-right-art mian_middle_post_box animated fadeInUp">
                        <div class="common-form">
                            <div class="job-saved-box">
                            <h3>
                                Search result of 
                                <?php
                                if ($keyword == "" && $keyword1 == "") {
                                    echo "All Jobs";
                                } elseif ($keyword != "" && $keyword1 == "") {

                                    echo '"' . str_replace('-', ' ', $keyword) . '"';
                                } elseif ($keyword == "" && $keyword1 != "") {

                                    echo '"' . $keyword1 . '"';
                                } else {
                                    echo '"' . str_replace('-', ' ', $keyword) . '"';
                                    echo " in ";
                                    echo '"' . $keyword1 . '"';
                                }
                                ?>
                            </h3>
                            
                        
                     <div class="contact-frnd-post">
                        <div class="job-contact-frnd1">

                            <div id="loader"><p style="text-align:center;"><img class="loader" src="<?php echo base_url('assets/images/loading.gif'); ?>" alt="LOADERIMAGE"/></p></div>
                        </div>
                        </div>
                        </div>
                    </div>
                    </div>
                    <div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig"> 
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
                                                <img src="<?php echo base_url('assets/img/i1.jpg'); ?>" alt="JOBPROFILE">
                                            </div>
                                            <span>Job Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('recruiter'); ?>" title="recruiter">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i2.jpg'); ?>" alt="RECRUITERPROFILE">
                                            </div>
                                            <span>Recruiter Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('freelance'); ?>" title="freelancer">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i3.jpg'); ?>" alt="FREELANCERPROFILE">
                                            </div>
                                            <span>Freelance Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('business-profile'); ?>" title="business-profile">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i4.jpg'); ?>" alt="BUSINESSPROFILE">
                                            </div>
                                            <span>Business Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('artist'); ?>" title="artist">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i5.jpg'); ?>" alt="ARTISTPROFILE">
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


<?php echo $footer; ?>


                    <!-- script for skill textbox automatic start-->
<?php
        if (IS_JOB_JS_MINIFY == '0') {
            ?>
                    <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
<?php }else{?>

  <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>

<?php }?>
                    <script>
                                                                                                var base_url = '<?php echo base_url(); ?>';
                                                                                                var skill = '<?php echo $keyword; ?>';
                                                                                                
                                                                                                var place = '<?php echo $keyword1; ?>';
                                                                                             

                                                                                                var csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
                                                                                                var csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
                    </script>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/job_search.js?ver=' . time()); ?>"></script>
<?php
        if (IS_JOB_JS_MINIFY == '0') {
            ?>
                    <!--<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/job_search.js?ver=' . time()); ?>"></script>-->
                    <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/search_common.js?ver=' . time()); ?>"></script>
<?php }else{?>


<!--<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/job/job_search.js?ver=' . time()); ?>"></script>-->
<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/job/search_common.js?ver=' . time()); ?>"></script>

<?php }?>
                    </body>
                    </html>