<!DOCTYPE html>
<html>
    <head>
        <title>
            <?php echo $title; ?>
        </title>
        <?php echo $head; ?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php
        if (IS_HIRE_CSS_MINIFY == '0') {?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/freelancer-hire.css?ver=' . time()); ?>">
        <?php } else {?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/freelancer-hire.css?ver=' . time()); ?>">
        <?php } ?>
    </head>  
    <body>
        <?php echo $header; ?>
        <?php echo $freelancer_hire_header2_border; ?>
        <section>
            <div class="user-midd-section" id="paddingtop_fixed">
                <div class="container padding-360">
                    <div class="">
                        <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt"><div class="">
                                <div class="full-box-module">   
                                    <div class="profile-boxProfileCard  module">
                                        <div class="profile-boxProfileCard-cover"> 
                                            <a class="profile-boxProfileCard-bg u-bgUserColor a-block"
                                               href="<?php echo base_url('freelance-hire/employer-details'); ?>"  tabindex="-1" aria-hidden="true" rel="noopener" 
                                               title="<?php echo $freehiredata[0]['fullname'] . " " . $freehiredata[0]['username']; ?>">
                                                   <?php
                                                   if ($freehiredata[0]['profile_background'] != '') {
                                                       ?>
                                                    <div class="data_img">
                                                        <img src="<?php echo FREE_HIRE_BG_THUMB_UPLOAD_URL . $freehiredata[0]['profile_background']; ?>" class="bgImage" alt="<?php echo $freehiredata[0]['fullname'] . " " . $freehiredata[0]['username']; ?>" >
                                                    </div>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <div class="data_img bg-images no-cover-upload">
                                                        <img src="<?php echo base_url(WHITEIMAGE); ?>" class="bgImage" alt="<?php echo $freehiredata[0]['fullname'] . " " . $freehiredata[0]['username']; ?>"  >
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </a>
                                        </div>
                                        <div class="profile-boxProfileCard-content clearfix">
                                            <div class="left_side_box_img buisness-profile-txext">
                                                <a class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock" href="<?php echo base_url('freelance-hire/employer-details'); ?>"  tabindex="-1" aria-hidden="true" rel="noopener" title="<?php echo $freehiredata[0]['fullname'] . " " . $freehiredata[0]['username']; ?>">
                                                    <?php
                                                    $fname = $freehiredata[0]['fullname'];
                                                    $lname = $freehiredata[0]['username'];
                                                    $sub_fname = substr($fname, 0, 1);
                                                    $sub_lname = substr($lname, 0, 1);
                                                    if ($freehiredata[0]['freelancer_hire_user_image']) {
                                                        if (IMAGEPATHFROM == 'upload') {
                                                            if (!file_exists($this->config->item('free_hire_profile_main_upload_path') . $freehiredata[0]['freelancer_hire_user_image'])) {
                                                                ?>
                                                                <div class="post-img-profile">
                                                                    <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>
                                                                </div>
                                                            <?php } else {
                                                                ?>
                                                                <img src="<?php echo FREE_HIRE_PROFILE_MAIN_UPLOAD_URL . $freehiredata[0]['freelancer_hire_user_image']; ?>" alt="<?php echo $freehiredata[0]['fullname'] . " " . $freehiredata[0]['username']; ?>" >
                                                                <?php
                                                            }
                                                        } else {
                                                            $filename = $this->config->item('free_hire_profile_main_upload_path') . $freehiredata[0]['freelancer_hire_user_image'];
                                                            $s3 = new S3(awsAccessKey, awsSecretKey);
                                                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                            if ($info) {
                                                                ?>
                                                                <img src="<?php echo FREE_HIRE_PROFILE_MAIN_UPLOAD_URL . $freehiredata[0]['freelancer_hire_user_image']; ?>" alt="<?php echo $freehiredata[0]['fullname'] . " " . $freehiredata[0]['username']; ?>" >
                                                            <?php } else { ?>
                                                                <div class="post-img-profile">
                                                                    <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                    } else {
                                                        ?>
                                                        <div class="post-img-profile">
                                                            <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </a>
                                            </div>
                                            <div class="right_left_box_design ">
                                                <span class="profile-company-name ">
                                                    <a href="<?php echo base_url('freelance-hire/employer-details'); ?>" title="<?php echo $freehiredata[0]['fullname'] . " " . $freehiredata[0]['username']; ?>"> <?php echo ucwords($freehiredata[0]['fullname']) . ' ' . ucwords($freehiredata[0]['username']); ?></a>  
                                                </span>
                                                <?php $category = $this->db->get_where('industry_type', array('industry_id' => $businessdata[0]['industriyal'], 'status' => '1'))->row()->industry_name; ?>
                                                <div class="profile-boxProfile-name">
                                                    <a href="<?php echo base_url('freelance-hire/employer-details'); ?>" title="<?php echo $freehiredata[0]['fullname'] . " " . $freehiredata[0]['username']; ?>"><?php
                                                        if ($freehiredata[0]['designation']) {
                                                            echo $freehiredata[0]['designation'];
                                                        } else {
                                                            echo "Designation";
                                                        }
                                                        ?></a>
                                                </div>
                                                <ul class=" left_box_menubar">
                                                    <li <?php if (($this->uri->segment(1) == 'freelance-hire') && ($this->uri->segment(2) == 'employer-details')) { ?> class="active" <?php } ?>><a title="Employer Details"  class="padding_less_left" href="<?php echo base_url('freelance-hire/employer-details'); ?>" > Details</a></li>
                                                    <li><a title="Projects" href="<?php echo base_url('freelance-hire/projects'); ?>">Projects</a></li>
                                                    <li <?php if (($this->uri->segment(1) == 'freelance-hire') && ($this->uri->segment(2) == 'freelancer-save')) { ?> class="active" <?php } ?>><a title="Saved Freelancer"  class="padding_less_right" href="<?php echo base_url('freelance-hire/freelancer-save'); ?>">Saved</a></li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>                             
                                </div>
                                
                               
                                <?php echo $left_footer; ?>
                                <div  class="add-post-button">
                                    <a title="Post Project" class="btn btn-3 btn-3b" href="<?php echo base_url('freelance-hire/add-projects'); ?>"><i class="fa fa-plus" aria-hidden="true"></i>  Add Project</a>
                                </div>

                            </div>
                        </div>

                        <div class="custom-right-art mian_middle_post_box animated fadeInUp">
                            <div class="common-form">
                                <div class="job-saved-box">
                                    <h3>Search result of 
                                        <?php
                                        if ($keyword != "" && ($keyword1 == "" || $keyword1 == '0')) {
                                            echo '"' . $keyword . '"';
                                        } elseif (($keyword == "" || $keyword == '0') && $keyword1 != "") {
                                            echo '"' . $keyword1 . '"';
                                        } else {
                                            echo '"' . $keyword . '"';
                                            echo " In ";
                                            echo '"' . $keyword1 . '"';
                                        }
                                        ?></h3>
                                    <div class="contact-frnd-post">
                                        
                                        <div class="job-contact-frnd ">
                                            <!--.........AJAX DATA......-->

                                        </div>
                                        <div class="fw" id="loader" style="text-align:center;"><img alt="loader" src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>"</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig"> 

                       <div class="all-profile-box">
                                <div class="all-pro-head">
                                    <h4>Profiles<a title="All" href="<?php echo base_url('profiles/') . $this->session->userdata('aileenuser_slug'); ?>" class="pull-right">All</a></h4>
                                </div>
                                <ul class="all-pr-list">
                                    <li>
                                        <a title="Job Profile" href="<?php echo base_url('job'); ?>">
                                            <div class="all-pr-img">
                                                <img alt="Job Profile" src="<?php echo base_url('assets/img/i1.jpg'); ?>">
                                            </div>
                                            <span>Job Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a title="Recruiter Profile" href="<?php echo base_url('recruiter'); ?>">
                                            <div class="all-pr-img">
                                                <img alt="Recruiter Profile" src="<?php echo base_url('assets/img/i2.jpg'); ?>">
                                            </div>
                                            <span>Recruiter Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a title="Freelance Profile" href="<?php echo base_url('freelance'); ?>">
                                            <div class="all-pr-img">
                                                <img alt="Freelance Profile" src="<?php echo base_url('assets/img/i3.jpg'); ?>">
                                            </div>
                                            <span>Freelance Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a title="Business Profile" href="<?php echo base_url('business-profile'); ?>">
                                            <div class="all-pr-img">
                                                <img alt="Business Profile" src="<?php echo base_url('assets/img/i4.jpg'); ?>">
                                            </div>
                                            <span>Business Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a title="Artistic Profile" href="<?php echo base_url('artist'); ?>">
                                            <div class="all-pr-img">
                                                <img alt="Artistic Profile" src="<?php echo base_url('assets/img/i5.jpg'); ?>">
                                            </div>
                                            <span>Artistic Profile</span>
                                        </a>
                                    </li>
                                </ul>
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

        <!-- script for skill textbox automatic end (option 2)-->

        <script>
                                            var base_url = '<?php echo base_url(); ?>';


                                            //LEAVE PAGE AT ADD AND EDIT FREELANCER PAGE THEN PROBLEM SO BELOW CODE START
                                            var seg3 = '<?php echo $this->uri->segment(3); ?>';
                                            var seg4 = '<?php echo $this->uri->segment(4); ?>';

                                            if (seg3 == 0 && seg4 != "")
                                            {
                                                var skill = "";
                                                var place = seg4;
                                            } else if (seg4 == 0 && seg3 != "")
                                            {
                                                var skill = seg3;
                                                var place = "";
                                            } else if (seg3 != "" && seg4 != "")
                                            {
                                                var skill = seg3;
                                                var place = seg4;
                                            } else
                                            {
                                                var skill = '<?php echo $this->input->get('skills'); ?>';
                                                var place = '<?php echo $this->input->get('searchplace'); ?>';
                                            }
                                            //LEAVE PAGE AT ADD AND EDIT FREELANCER PAGE THEN PROBLEM SO BELOW CODE END

        </script>
          <?php if (IS_HIRE_JS_MINIFY == '0') { ?>
            <script async type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/freelancer_hire_search_result.js?ver=' . time()); ?>"></script>
        <script async type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/freelancer_hire_common.js?ver=' . time()); ?>"></script>
            <?php } else {  ?>
            <script async type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-hire/freelancer_hire_search_result.js?ver=' . time()); ?>"></script>
        <script async type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-hire/freelancer_hire_common.js?ver=' . time()); ?>"></script>
        <?php } ?>
       
    </body>
</html>
