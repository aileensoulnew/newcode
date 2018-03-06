<!DOCTYPE html>
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
</head>
<body class="page-container-bg-solid page-boxed pushmenu-push">
    <?php
    echo $header;
    echo $recruiter_header2_border;
    ?>
    <div id="preloader"></div>
    <!-- START CONTAINER -->
    <section>
        <!-- MIDDLE SECTION START -->

        <div class="user-midd-section" id="paddingtop_fixed">
            <div class="container padding-360">
                <div class="">


                    <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt"><div class="">
                            <div class="full-box-module">   
                                <div class="profile-boxProfileCard  module">
                                    <div class="profile-boxProfileCard-cover"> 
                                        <a title="Recruiter Profile" class="profile-boxProfileCard-bg u-bgUserColor a-block" href="<?php echo base_url('recruiter/profile'); ?>" tabindex="-1" 
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
                                                </a>
                                            </div>
                                    </div>
                                    <div class="profile-boxProfileCard-content clearfix">
                                        <div class="left_side_box_img buisness-profile-txext">

                                            <a title="Recruiter Profile" class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock"  href="<?php echo base_url('recruiter/profile/' . $recdata['user_id']); ?>" title="<?php echo $recdata['rec_firstname'] . ' ' . $recdata['rec_lastname']; ?>" tabindex="-1" aria-hidden="true" rel="noopener">

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

        <!-- <img src="<?php //echo base_url(NOIMAGE);  ?>" alt="<?php //echo $recdata[0]['rec_firstname'] . ' ' . $recdata[0]['rec_lastname'];  ?>">
                                                    --> 

                                                    <?php
                                                }
                                                ?>
                                            </a>
                                        </div>
                                        <div class="right_left_box_design ">
                                            <span class="profile-company-name ">
                                                <a href="<?php echo site_url('recruiter/profile'); ?>" title="<?php echo ucfirst(strtolower($recdata['rec_firstname'])) . ' ' . ucfirst(strtolower($recdata['rec_lastname'])); ?>">   <?php echo ucfirst(strtolower($recdata['rec_firstname'])) . ' ' . ucfirst(strtolower($recdata['rec_lastname'])); ?></a>
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
                                                <li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'profile') { ?> class="active" <?php } ?>><a class="padding_less_left" title="Details" href="<?php echo base_url('recruiter/profile'); ?>"> Details</a>
                                                </li>                                
                                                <li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'post') { ?> class="active" <?php } ?>><a title="Post" href="<?php echo base_url('recruiter/post'); ?>">Post</a>
                                                </li>
                                                <li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'save-candidate') { ?> class="active" <?php } ?>><a title="Saved Candidate" class="padding_less_right" href="<?php echo base_url('recruiter/save-candidate'); ?>">Saved </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>                             
                            </div>

                              <?php echo $left_footer; ?>
                              
                            <div  class="add-post-button">

                                <a class="btn btn-3 btn-3b" href="<?php echo base_url('recruiter/add-post'); ?>" title="Recruiter Add Post"><i class="fa fa-plus" aria-hidden="true"></i>Post a Job</a>
                            </div>
                          
                        </div>

                    </div>


                    <!-- <?php //echo "<pre>"; print_r($postdetail);//die();  ?> -->
                    <!--- search end -->

                    <div class="custom-right-art mian_middle_post_box animated fadeInUp">
                        <div class="common-form">
                            <div class="job-saved-box">

                                <h3>
                                    Search result of 
                                    <?php
                                    if ($keyword != "" && $keyword1 == "") {
                                        echo '"' . $keyword . '"';
                                    } elseif ($keyword == "" && $keyword1 != "") {
                                        echo '"' . $keyword1 . '"';
                                    } else {
                                        echo '"' . $keyword . '"';
                                        echo " in ";
                                        echo '"' . $keyword1 . '"';
                                    }
                                    ?>
                                </h3>

                                <div class="contact-frnd-post">
                                    
                                    <div class = "job-contact-frnd">
                                        <!--AJAX DATA START FOR RECOMMAND CANDIDATE-->
                                    </div>
                                    <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" alt="<?php echo 'LOADERIAMGE'; ?>"/></div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig"> 

                           <div class="all-profile-box">
                                <div class="all-pro-head">
                                    <h4>Profiles<a href="<?php echo base_url('profiles/') . $this->session->userdata('aileenuser_slug'); ?>" class="pull-right" title="All profiles">All</a></h4>
                                </div>
                                <ul class="all-pr-list">
                                    <li>
                                        <a href="<?php echo base_url('job'); ?>" title="Job">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i1.jpg'); ?>" alt="<?php echo 'JOBIAMGE'; ?>">
                                            </div>
                                            <span>Job Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('recruiter'); ?>" title="Recruiter">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i2.jpg'); ?>" alt="<?php echo 'RECIAMGE'; ?>">
                                            </div>
                                            <span>Recruiter Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('freelance'); ?>" title="Freelancer">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i3.jpg'); ?>" alt="<?php echo 'FREELANCERIAMGE'; ?>">
                                            </div>
                                            <span>Freelance Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('business-profile'); ?>" title="Business Profile">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i4.jpg'); ?>" alt="<?php echo 'BUSIAMGE'; ?>">
                                            </div>
                                            <span>Business Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('artist'); ?>" title="Artist Profile">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i5.jpg'); ?>" alt="<?php echo 'ARTIAMGE'; ?>">
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


    <!-- Bid-modal  -->
    <div class="modal fade message-box biderror" id="bidmodal" role="dialog">
        <div class="modal-dialog modal-lm">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                <div class="modal-body">
                    <!--<img class="icon" src="images/dollar-icon.png" alt="" />-->
                    <span class="mes"></span>
                </div>
            </div>
        </div>
    </div>
    <!-- Model Popup Close -->

    <!-- BEGIN FOOTER -->
    <?php echo $footer; ?>
    <!-- END FOOTER -->
</body>

</html>



<script>
                                        var base_url = '<?php echo base_url(); ?>';
                                        var skill = '<?php echo $this->input->get('skills'); ?>';
                                        var place = '<?php echo $this->input->get('searchplace'); ?>';

</script>




<!-- FIELD VALIDATION JS END -->
<?php
if (IS_REC_JS_MINIFY == '0') {
    ?>
<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/search.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/rec_search.js'); ?>"></script>
    <?php
} else {
    ?>
<script src="<?php echo base_url('assets/js_min/bootstrap.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/recruiter/search.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/recruiter/rec_search.js'); ?>"></script>
<?php } ?>
       