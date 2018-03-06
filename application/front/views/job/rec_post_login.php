<!DOCTYPE html>
<html>
    <head>
        <!-- start head -->
        <?php echo $head; ?>
        <!-- END HEAD -->

        <title><?php echo $title; ?></title>

        <?php
        if (IS_REC_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css'); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css'); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/recruiter.css'); ?>">
            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css'); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css'); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/recruiter.css'); ?>">
        <?php } ?>
    </head>
    <!-- END HEAD -->
  
    <body class="page-container-bg-solid page-boxed no-login freeh3 cust-job-width paddnone cus-error">

        <header>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-3 left-header text-center fw-479">
                     <div class="logo"> <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png?ver='.time()) ?>" alt="logo"></a></div>                    </div>
                    <div class="col-md-8 col-sm-9 right-header fw-479 text-center">
                        <div class="btn-right pull-right">
                            <a href="javascript:void(0);" onclick="login_profile();" class="btn2">Login</a>
                            <a href="javascript:void(0);" onclick="register_profile();" class="btn3">Creat an account</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <section>
            <div class="user-midd-section" id="paddingtop_fixed">
                <div class="container padding-360">
                    <div class="row4">

                        <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt" style="position: absolute !important;"><div class="">

                                <div class="full-box-module">   
                                    <div class="profile-boxProfileCard  module">
                                        <div class="profile-boxProfileCard-cover"> 
                                            <a class="profile-boxProfileCard-bg u-bgUserColor a-block" href="javascript:void(0);" onclick="register_profile();" tabindex="-1" 
                                               aria-hidden="true" rel="noopener">
                                                <div class="bg-images no-cover-upload"> 
                                                    <?php
                                                    $image_ori = $recdata[0]['profile_background'];
                                                    $filename = $this->config->item('rec_bg_main_upload_path') . $recdata[0]['profile_background'];
                                                    $s3 = new S3(awsAccessKey, awsSecretKey);
                                                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                    if ($info && $recdata[0]['profile_background'] != '') {
                                                        ?>
                                                        <img src = "<?php echo REC_BG_MAIN_UPLOAD_URL . $recdata[0]['profile_background']; ?>" name="image_src" id="image_src" alt='<?php echo $recdata[0]['profile_background']; ?>'/>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <img src="<?php echo base_url(WHITEIMAGE); ?>" class="bgImage" alt="<?php echo $recdata[0]['rec_firstname'] . ' ' . $recdata[0]['rec_lastname']; ?>" >
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="profile-boxProfileCard-content clearfix">
                                            <div class="left_side_box_img buisness-profile-txext">

                                                <a class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock"  href="javascript:void(0);" onclick="register_profile();" title="<?php echo $recdata[0]['rec_firstname'] . ' ' . $recdata[0]['rec_lastname']; ?>" tabindex="-1" aria-hidden="true" rel="noopener">
                                                    <?php
                                                    $filename = $this->config->item('rec_profile_thumb_upload_path') . $recdata[0]['recruiter_user_image'];
                                                    $s3 = new S3(awsAccessKey, awsSecretKey);
                                                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                    if ($recdata[0]['recruiter_user_image'] != '' && $info) {
                                                        ?>
                                                        <img src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL . $recdata[0]['recruiter_user_image']; ?>" alt="<?php echo $recdata[0]['recruiter_user_image']; ?>" >
                                                        <?php
                                                    } else {


                                                        $a = $recdata[0]['rec_firstname'];
                                                        $acr = substr($a, 0, 1);

                                                        $b = $recdata[0]['rec_lastname'];
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
                                                    <a href="javascript:void(0);" onclick="register_profile();" title="<?php echo ucfirst(strtolower($recdata['rec_firstname'])) . ' ' . ucfirst(strtolower($recdata['rec_lastname'])); ?>">   <?php echo ucfirst(strtolower($recdata[0]['rec_firstname'])) . ' ' . ucfirst(strtolower($recdata[0]['rec_lastname'])); ?></a>
                                                </span>

                                                <div class="profile-boxProfile-name">
                                                    <a href="javascript:void(0);" onclick="register_profile();" title="<?php echo ucfirst(strtolower($recdata[0]['designation'])); ?>">
                                                        <?php
                                                        if (ucfirst(strtolower($recdata[0]['designation']))) {
                                                            echo ucfirst(strtolower($recdata[0]['designation']));
                                                        } else {
                                                            echo "Designation";
                                                        }
                                                        ?></a>
                                                </div>
                                                <ul class=" left_box_menubar">
                                                    <li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'profile') { ?> class="active" <?php } ?>><a class="padding_less_left" title="Details" href="javascript:void(0);" onclick="register_profile();"> Details</a>
                                                    </li>                                
                                                    <li id="rec_post_home" <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'post') { ?> class="active" <?php } ?>><a title="Post" href="javascript:void(0);" onclick="register_profile();">Post</a>
                                                    </li>
                                                    <li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'save-candidate') { ?> class="active" <?php } ?>><a title="Saved Candidate" class="padding_less_right" href="javascript:void(0);" onclick="register_profile();">Saved </a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>                             
                                </div>
                                <?php if ($_GET['page'] == all_jobs) { ?>
                                    
                                <?php } ?>

                                
                                 <div id="hideuserlist" class=" fixed_right_display animated fadeInRightBig"> 

                                                                                         <div class="all-profile-box">
                                <div class="all-pro-head">
                                    <h4>Profiles<a href="<?php echo base_url('profiles/') . $this->session->userdata('aileenuser_slug'); ?>" class="pull-right">All</a></h4>
                                </div>
                                <ul class="all-pr-list">
                                    <li>
                                        <a href="<?php echo base_url('job'); ?>">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i1.jpg'); ?>" alt="job">
                                            </div>
                                            <span>Job Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('recruiter'); ?>">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i2.jpg'); ?>" alt="recruiter">
                                            </div>
                                            <span>Recruiter Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('freelance'); ?>">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i3.jpg'); ?>" alt="freelancer">
                                            </div>
                                            <span>Freelance Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('business-profile'); ?>">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i4.jpg'); ?>" alt="business-profile">
                                            </div>
                                            <span>Business Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('artist'); ?>">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i5.jpg'); ?>" alt="artist">
                                            </div>
                                            <span>Artistic Profile</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                                                                                    </div>
																					<?php echo $left_footer; ?>

                                



                            </div>

                        </div>

                       
                        <div class="inner-right-part">
                           
                            <?php
                            if($postdata){ ?>
                                 <div class="page-title">
                                <h3>
                                    <?php
                                    $cache_time = $this->db->get_where('job_title', array('title_id' => $postdata[0]['post_name']))->row()->name;
                                    if ($cache_time) {
                                        echo $cache_time;
                                    } else {
                                        echo $postdata[0]['post_name'];
                                    }
                                    ?>
                                </h3>
                            </div>
                      <?php      foreach ($postdata as $post) {
                                ?>
                                <div class="all-job-box job-detail">
                                    <div class="all-job-top">
                                        <div class="post-img">
                                            <a title="<?php echo $post['re_comp_name']; ?>">
                                                <?php
                                                $cache_time = $this->db->get_where('recruiter', array(
                                                            'user_id' => $post['user_id']
                                                        ))->row()->comp_logo;
                                                
                                               if ($cache_time) {
                                                    if (IMAGEPATHFROM == 'upload') {
                                                        if (!file_exists($this->config->item('rec_profile_thumb_upload_path') . $cache_time)) { 
                                                            ?>
                                                <img src="<?php echo  base_url('assets/images/commen-img.png') ?>" title="commonimage">
                                                   <?php     } else { ?>
                                                           <img src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL . $cache_time ?>" title="<?php echo $cache_time; ?>">
                                                       <?php  }
                                                    } else {
                                                        $filename = $this->config->item('rec_profile_thumb_upload_path') . $cache_time;
                                                        $s3 = new S3(awsAccessKey, awsSecretKey);
                                                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                        if ($info) { ?>
                                                           <img src="<?php echo  REC_PROFILE_THUMB_UPLOAD_URL . $cache_time ?>" title="<?php echo $cache_time; ?>">
                                                         <?php } else { ?>
                                                          <img src="<?php echo base_url('assets/images/commen-img.png') ?>" title="commonimage">
                                                       <?php  }
                                                    }
                                                } else { ?>
                                                    <img src="<?php echo base_url('assets/images/commen-img.png') ?>" title="commonimage">
                                                <?php } ?>
                                            </a>
                                        </div>
                                        <div class="job-top-detail">
                                            <?php
                                            $cache_time1 = $this->db->get_where('job_title', array('title_id' => $post['post_name']))->row()->name;
                                            if ($cache_time1) {
                                                $cache_time1;
                                            } else {
                                                $cache_time1 = $post['post_name'];
                                            }
                                            ?>
                                            <h5><a href="javascript:void(0);" onclick="register_profile();" title="<?php echo $cache_time1; ?>"><?php echo $cache_time1; ?></a></h5>  
                                            <p><a href="javascript:void(0);" onclick="register_profile();" title="<?php echo $post['re_comp_name']; ?>">
                                                    <?php
                                                    $out = strlen($post['re_comp_name']) > 40 ? substr($post['re_comp_name'], 0, 40) . "..." : $post['re_comp_name'];
                                                    echo $out;
                                                    ?>
                                                </a>
                                            </p>
                                            <p><a href="javascript:void(0);" onclick="register_profile();" title="<?php echo ucfirst(strtolower($post['rec_firstname'])) . ' ' . ucfirst(strtolower($post['rec_lastname'])); ?>"><?php echo ucfirst(strtolower($post['rec_firstname'])) . ' ' . ucfirst(strtolower($post['rec_lastname'])); ?></a></p>
                                            <p class="loca-exp">
                                                <span class="location">
                                                    <?php
                                                    $cityname = $this->db->get_where('cities', array('city_id' => $post['city']))->row()->city_name;
                                                    $countryname = $this->db->get_where('countries', array('country_id' => $post['country']))->row()->country_name;
                                                    ?>
                                                    <span>
                                                      
                                                        <?php
                                                        if ($cityname || $countryname) {
                                                            if ($cityname) {
                                                                echo $cityname . ', ';
                                                            }
                                                            echo $countryname . " (Location)";
                                                        }
                                                        ?>
                                                    </span>
                                                </span>
                                            </p>
                                            <p class="loca-exp">
                                                <span class="exp">
                                                    <span>
                                                        
                                                        <?php
                                                        if (($post['min_year'] != '0' || $post['max_year'] != '0') && ($post['fresher'] == 1)) {


                                                            echo $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year' . " (Required Experience) " . "(Fresher can also apply).";
                                                        } else if (($post['min_year'] != '0' || $post['max_year'] != '0')) {
                                                            echo $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year' . " (Required Experience) ";
                                                        } else {
                                                            echo "Fresher";
                                                        }
                                                        ?>
                                                    </span>
                                                </span>
                                            </p>
                                            <p class="pull-right job-top-btn">
                                                <!-- <a href="javascript:void(0);"  onClick="create_profile_apply(<?php echo $post['post_id']; ?>)" class= "applypost  btn4">Save</a> -->

                                                <a href="javascript:void(0);"  onClick="create_profile_apply(<?php echo $post['post_id']; ?>)" class= "applypost  btn4">Apply</a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="detail-discription">
                                        <div class="all-job-middle">
                                            <ul>
                                                <li>
                                                    <b>Job description</b>
                                                    <span>
                                                        <pre><?php echo $this->common->make_links($post['post_description']); ?></pre>
                                                    </span>
                                                </li>
                                                <li>
                                                    <b>Key skill</b>
                                                    <span>  <?php
                                                        $comma = ", ";
                                                        $k = 0;
                                                        $aud = $post['post_skill'];
                                                        $aud_res = explode(',', $aud);

                                                        if (!$post['post_skill']) {

                                                            echo $post['other_skill'];
                                                        } else if (!$post['other_skill']) {


                                                            foreach ($aud_res as $skill) {

                                                                $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;

                                                                if ($cache_time != " ") {
                                                                    if ($k != 0) {
                                                                        echo $comma;
                                                                    }echo $cache_time;
                                                                    $k++;
                                                                }
                                                            }
                                                        } else if ($post['post_skill'] && $post['other_skill']) {
                                                            foreach ($aud_res as $skill) {
                                                                if ($k != 0) {
                                                                    echo $comma;
                                                                }
                                                                $cache_time3 = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;


                                                                echo $cache_time3;
                                                                $k++;
                                                            } echo "," . $post['other_skill'];
                                                        }
                                                        ?>  
                                                    </span>
                                                </li>
                                                <li><b>No of openings</b>
                                                    <span><?php echo $post['post_position']; ?>
                                                    </span>
                                                </li>
                                                <li><b>Industry</b>
                                                    <span> 
                                                        <?php
                                                        $cache_time4 = $this->db->get_where('job_industry', array('industry_id' => $post['industry_type']))->row()->industry_name;
                                                        echo $cache_time4;
                                                        ?>
                                                    </span>
                                                </li>
                                                <li><b>Required education</b>
                                                    <?php if ($post['degree_name'] != '' || $post['other_education'] != '') { ?>
                                                        <span>
                                                            <?php
                                                            $comma = ", ";
                                                            $k = 0;
                                                            $edu = $post['degree_name'];
                                                            $edu_nm = explode(',', $edu);

                                                            if (!$post['degree_name']) {

                                                                echo $post['other_education'];
                                                            } else if (!$post['other_education']) {


                                                                foreach ($edu_nm as $edun) {
                                                                    if ($k != 0) {
                                                                        echo $comma;
                                                                    }
                                                                    $cache_time = $this->db->get_where('degree', array('degree_id' => $edun))->row()->degree_name;


                                                                    echo $cache_time;
                                                                    $k++;
                                                                }
                                                            } else if ($post['degree_name'] && $post['other_education']) {
                                                                foreach ($edu_nm as $edun) {
                                                                    if ($k != 0) {
                                                                        echo $comma;
                                                                    }
                                                                    $cache_time = $this->db->get_where('degree', array('degree_id' => $edun))->row()->degree_name;


                                                                    echo $cache_time;
                                                                    $k++;
                                                                } echo "," . $post['other_education'];
                                                            }
                                                            ?>     

                                                        </span>
                                                    <?php } else { ?>
                                                        <span>
                                                            <?php echo PROFILENA; ?>
                                                        </span>
                                                    <?php } ?>
                                                </li>
                                                <li><b>Sallary</b>
                                                    <span>
                                                        <?php
                                                        $currency = $this->db->get_where('currency', array('currency_id' => $post['post_currency']))->row()->currency_name;

                                                        if ($post['min_sal'] || $post['max_sal']) {
                                                            echo $post['min_sal'] . " - " . $post['max_sal'] . ' ' . $currency . ' ' . $post['salary_type'];
                                                        } else {
                                                            echo PROFILENA;
                                                        }
                                                        ?></span>
                                                </li>
                                                <li><b>Employment Type</b>
                                                    <span>
                                                        <?php if ($post['emp_type'] != '') { ?>

                                                            <?php echo $this->common->make_links($post['emp_type']) . '  Job'; ?>

                                                            <?php
                                                        } else {
                                                            echo PROFILENA;
                                                        }
                                                        ?> 
                                                    </span>
                                                </li>
                                                <li><b>Interview Process</b>
                                                    <span>
                                                        <?php if ($post['interview_process'] != '') { ?>
                                                            <pre>
                                                                <?php echo $this->common->make_links($post['interview_process']); ?></pre>
                                                            <?php
                                                        } else {
                                                            echo PROFILENA;
                                                        }
                                                        ?> 
                                                    </span>
                                                </li>
                                                <li><b>Company profile</b>
                                                    <span>
                                                        <?php if ($post['re_comp_profile'] != '') { ?>
                                                            <pre>
                                                                <?php echo $this->common->make_links($post['re_comp_profile']); ?></pre>
                                                            <?php
                                                        } else {
                                                            echo PROFILENA;
                                                        }
                                                        ?> 
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="all-job-bottom">
                                            <span class="job-post-date"><b>Posted on: </b><?php echo date('d-M-Y', strtotime($post['created_date'])); ?></span>
                                            <p class="pull-right">
                                                 <!-- <a href="javascript:void(0);"  onClick="create_profile_apply(<?php echo $post['post_id']; ?>)" class= "applypost  btn4">Save</a> -->
                                                <a href="javascript:void(0);"  onClick="create_profile_apply(<?php echo $post['post_id']; ?>)" class= "applypost  btn4">Apply</a>
                                            </p>

                                        </div>
                                    </div>
                                </div>
                                <?php
                            } } else {
                            ?>

                            
                            <div class="art_no_post_avl"><h3>Post</h3><div class="art-img-nn"><div class="art_no_post_img"><img src="<?php echo base_url() . 'assets/img/job-no.png';?>" alt="bui-no.png"></div><div class="art_no_post_text">No Post Available.</div></div></div>
                            <?php } ?>
                        </div>
						
                        
                        <!--recommen candidate start-->
                        <?php if (count($recommandedpost) > 0) { ?>
                            <div class="inner-right-part">
                                <div class="page-title">
                                    <h3>
                                        Recommended job
                                    </h3>
                                </div>
								
                                <?php
                                foreach ($recommandedpost as $post) {
                                    ?>
                                    <div class="all-job-box job-detail">
                                        <div class="all-job-top">
                                            <div class="post-img">
                                                <a title="<?php echo $post['re_comp_name']; ?>">
                                                    
                                                    <?php
                                                $cache_time = $this->db->get_where('recruiter', array(
                                                            'user_id' => $post['user_id']
                                                        ))->row()->comp_logo;
                                                
                                               if ($cache_time) {
                                                    if (IMAGEPATHFROM == 'upload') {
                                                        if (!file_exists($this->config->item('rec_profile_thumb_upload_path') . $cache_time)) { 
                                                            ?>
                                                           <img src="<?php echo  base_url('assets/images/commen-img.png') ?>" title="commonimage">
                                                   <?php     } else { ?>
                                                           <img src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL . $cache_time ?>" title="<?php echo $cache_time; ?>">
                                                       <?php  }
                                                    } else {
                                                        $filename = $this->config->item('rec_profile_thumb_upload_path') . $cache_time;
                                                        $s3 = new S3(awsAccessKey, awsSecretKey);
                                                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                        if ($info) { ?>
                                                           <img src="<?php echo  REC_PROFILE_THUMB_UPLOAD_URL . $cache_time ?>" title="<?php echo $cache_time; ?>">
                                                         <?php } else { ?>
                                                          <img src="<?php echo base_url('assets/images/commen-img.png') ?>" title="commonimage">
                                                       <?php  }
                                                    }
                                                } else { ?>
                                                    <img src="<?php echo base_url('assets/images/commen-img.png') ?>" title="commonimage">
                                                <?php } ?>
                                                    
                                                </a>
                                            </div>
                                            <div class="job-top-detail">
                                                <?php
                                                $cache_time1 = $this->db->get_where('job_title', array('title_id' => $post['post_name']))->row()->name;
                                                if ($cache_time1) {
                                                    $cache_time1;
                                                } else {
                                                    $cache_time1 = $post['post_name'];
                                                }
                                                ?>
                                                <h5><a href="javascript:void(0);" onclick="register_profile();" title="<?php echo $cache_time1; ?>"><?php echo $cache_time1; ?></a></h5> 
                                                <p><a href="javascript:void(0);" onclick="register_profile();"<?php echo $post['re_comp_name'];?>>
                                                        <?php
                                                        $out = strlen($post['re_comp_name']) > 40 ? substr($post['re_comp_name'], 0, 40) . "..." : $post['re_comp_name'];
                                                        echo $out;
                                                        ?>
                                                    </a>
                                                </p>
                                                <p><a href="javascript:void(0);" onclick="register_profile();" title="<?php echo ucfirst(strtolower($post['rec_firstname'])) . ' ' . ucfirst(strtolower($post['rec_lastname'])); ?>"><?php echo ucfirst(strtolower($post['rec_firstname'])) . ' ' . ucfirst(strtolower($post['rec_lastname'])); ?></a></p>
                                                <p class="loca-exp">
                                                    <span class="location">
                                                        <?php
                                                        $cityname = $this->db->get_where('cities', array('city_id' => $post['city']))->row()->city_name;
                                                        $countryname = $this->db->get_where('countries', array('country_id' => $post['country']))->row()->country_name;
                                                        ?>
                                                        <span><img class="pr5" src="<?php echo base_url('assets/images/location.png'); ?>" title="locationimage">
                                                            <?php
                                                            if ($cityname || $countryname) {
                                                                if ($cityname) {
                                                                    echo $cityname . ', ';
                                                                }
                                                                echo $countryname;
                                                            }
                                                            ?>
                                                        </span>
                                                    </span>
                                                </p>
                                                <p class="loca-exp">
                                                    <span class="exp">
                                                        <span><!-- <img class="pr5" src="<?php //echo base_url('assets/images/exp.png'); ?>" title="experienceimage">
 -->
                                                            <?php
                                                            if (($post['min_year'] != '0' || $post['max_year'] != '0') && ($post['fresher'] == 1)) {


                                                                echo $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year' . " , " . "(Fresher can also apply).";
                                                            } else if (($post['min_year'] != '0' || $post['max_year'] != '0')) {
                                                                echo $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year';
                                                            } else {
                                                                echo "Fresher";
                                                            }
                                                            ?>
                                                        </span>
                                                    </span>
                                                </p>
                                                <p class="pull-right job-top-btn">
                                                    <a href="javascript:void(0);"  onClick="create_profile_apply(<?php echo $post['post_id']; ?>)" class= "applypost  btn4">Apply</a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="detail-discription">
                                            <div class="all-job-middle">
                                                <ul>
                                                    <li>
                                                        <b>Job discription</b>
                                                        <span>
                                                            <pre><?php echo $this->common->make_links($post['post_description']); ?></pre>
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <b>Key skill</b>
                                                        <span>  <?php
                                                            $comma = ", ";
                                                            $k = 0;
                                                            $aud = $post['post_skill'];
                                                            $aud_res = explode(',', $aud);

                                                            if (!$post['post_skill']) {

                                                                echo $post['other_skill'];
                                                            } else if (!$post['other_skill']) {


                                                                foreach ($aud_res as $skill) {

                                                                    $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;

                                                                    if ($cache_time != " ") {
                                                                        if ($k != 0) {
                                                                            echo $comma;
                                                                        }echo $cache_time;
                                                                        $k++;
                                                                    }
                                                                }
                                                            } else if ($post['post_skill'] && $post['other_skill']) {
                                                                foreach ($aud_res as $skill) {
                                                                    if ($k != 0) {
                                                                        echo $comma;
                                                                    }
                                                                    $cache_time3 = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;


                                                                    echo $cache_time3;
                                                                    $k++;
                                                                } echo "," . $post['other_skill'];
                                                            }
                                                            ?>  
                                                        </span>
                                                    </li>
                                                    <li><b>No of openings</b>
                                                        <span><?php echo $post['post_position']; ?>
                                                        </span>
                                                    </li>
                                                    <li><b>Industry</b>
                                                        <span> 
                                                            <?php
                                                            $cache_time4 = $this->db->get_where('job_industry', array('industry_id' => $post['industry_type']))->row()->industry_name;
                                                            echo $cache_time4;
                                                            ?>
                                                        </span>
                                                    </li>
                                                    <li><b>Required education</b>
                                                        <?php if ($post['degree_name'] != '' || $post['other_education'] != '') { ?>
                                                            <span>
                                                                <?php
                                                                $comma = ", ";
                                                                $k = 0;
                                                                $edu = $post['degree_name'];
                                                                $edu_nm = explode(',', $edu);

                                                                if (!$post['degree_name']) {

                                                                    echo $post['other_education'];
                                                                } else if (!$post['other_education']) {


                                                                    foreach ($edu_nm as $edun) {
                                                                        if ($k != 0) {
                                                                            echo $comma;
                                                                        }
                                                                        $cache_time = $this->db->get_where('degree', array('degree_id' => $edun))->row()->degree_name;


                                                                        echo $cache_time;
                                                                        $k++;
                                                                    }
                                                                } else if ($post['degree_name'] && $post['other_education']) {
                                                                    foreach ($edu_nm as $edun) {
                                                                        if ($k != 0) {
                                                                            echo $comma;
                                                                        }
                                                                        $cache_time = $this->db->get_where('degree', array('degree_id' => $edun))->row()->degree_name;


                                                                        echo $cache_time;
                                                                        $k++;
                                                                    } echo "," . $post['other_education'];
                                                                }
                                                                ?>     

                                                            </span>
                                                        <?php } else { ?>
                                                            <span>
                                                                <?php echo PROFILENA; ?>
                                                            </span>
                                                        <?php } ?>
                                                    </li>
                                                    <li><b>Sallary</b>
                                                        <span>
                                                            <?php
                                                            $currency = $this->db->get_where('currency', array('currency_id' => $post['post_currency']))->row()->currency_name;

                                                            if ($post['min_sal'] || $post['max_sal']) {
                                                                echo $post['min_sal'] . " - " . $post['max_sal'] . ' ' . $currency . ' ' . $post['salary_type'];
                                                            } else {
                                                                echo PROFILENA;
                                                            }
                                                            ?></span>
                                                    </li>
                                                    <li><b>Employment Type</b>
                                                        <span>
                                                            <?php if ($post['emp_type'] != '') { ?>

                                                                <?php echo $this->common->make_links($post['emp_type']) . '  Job'; ?>

                                                                <?php
                                                            } else {
                                                                echo PROFILENA;
                                                            }
                                                            ?> 
                                                        </span>
                                                    </li>
                                                    <li><b>Interview Process</b>
                                                        <span>
                                                            <?php if ($post['interview_process'] != '') { ?>
                                                                <pre>
                                                                    <?php echo $this->common->make_links($post['interview_process']); ?></pre>
                                                                <?php
                                                            } else {
                                                                echo PROFILENA;
                                                            }
                                                            ?> 
                                                        </span>
                                                    </li>
                                                    <li><b>Company profile</b>
                                                        <span>
                                                            <?php if ($post['re_comp_profile'] != '') { ?>
                                                                <pre>
                                                                    <?php echo $this->common->make_links($post['re_comp_profile']); ?></pre>
                                                                <?php
                                                            } else {
                                                                echo PROFILENA;
                                                            }
                                                            ?> 
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="all-job-bottom">
                                                <span class="job-post-date"><b>Posted on:</b><?php echo date('d-M-Y', strtotime($post['created_date'])); ?></span>
                                                <p class="pull-right">
                                                    <a href="javascript:void(0);"  onClick="create_profile_apply(<?php echo $post['post_id']; ?>)" class= "applypost  btn4">Apply</a>
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>


                            </div>
                        <?php } ?>
                        <!--recommen candidate end-->

                    </div>
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

        <!--footer>        
        <?php //echo $footer;    ?>
        </footer-->

        <!-- Login  -->
        <div class="modal fade login" id="login" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content login-frm">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <div class="right-main">
                            <div class="right-main-inner">
                                <div class="">
                                    <div class="title">
                                        <h1 class="ttc">Welcome To Aileensoul</h1>
                                    </div>

                                    <form role="form" name="login_form" id="login_form" method="post">

                                        <div class="form-group">
                                            <input type="email" value="<?php echo $email; ?>" name="email_login" id="email_login" autofocus="" class="form-control input-sm" placeholder="Email Address*">
                                            <div id="error2" style="display:block;">
                                                <?php
                                                if ($this->session->flashdata('erroremail')) {
                                                    echo $this->session->flashdata('erroremail');
                                                }
                                                ?>
                                            </div>
                                            <div id="errorlogin"></div> 
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password_login" id="password_login" class="form-control input-sm" placeholder="Password*">
                                            <div id="error1" style="display:block;">
                                                <?php
                                                if ($this->session->flashdata('errorpass')) {
                                                    echo $this->session->flashdata('errorpass');
                                                }
                                                ?>
                                            </div>
                                            <div id="errorpass"></div> 
                                        </div>

                                        <p class="pt-20 ">
                                            <button class="btn1" onclick="login()">Login</button>
                                        </p>

                                        <p class=" text-center">
                                            <a href="javascript:void(0)" data-toggle="modal" onclick="forgot_profile();" id="myBtn">Forgot Password ?</a>
                                        </p>

                                        <p class="pt15 text-center">
                                            Don't have an account? <a class="db-479" href="javascript:void(0);" data-toggle="modal" onclick="register_profile();">Create an account</a>
                                        </p>
                                    </form>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Login -->

        <!-- Login  For Apply Post-->
        <div class="modal fade login" id="login_apply" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content login-frm">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <div class="right-main">
                            <div class="right-main-inner">
                                <div class="">
                                    <div class="title">
                                        <h1 class="ttc tlh2">Welcome To Aileensoul</h1>
                                    </div>

                                    <form role="form" name="login_form_apply" id="login_form_apply" method="post">

                                        <div class="form-group">
                                            <input type="email" value="<?php echo $email; ?>" name="email_login_apply" id="email_login_apply" autofocus="" class="form-control input-sm email_login" placeholder="Email Address*">
                                            <div id="error2" style="display:block;">
                                                <?php
                                                if ($this->session->flashdata('erroremail')) {
                                                    echo $this->session->flashdata('erroremail');
                                                }
                                                ?>
                                            </div>
                                            <div id="errorlogin_apply"></div> 
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password_login_apply" id="password_login_apply" class="form-control input-sm password_login" placeholder="Password*">
                                            <input type="hidden" name="password_login_postid" id="password_login_postid" class="form-control input-sm post_id_login">

                                            <div id="error1" style="display:block;">
                                                <?php
                                                if ($this->session->flashdata('errorpass')) {
                                                    echo $this->session->flashdata('errorpass');
                                                }
                                                ?>
                                            </div>
                                            <div id="errorpass_apply"></div> 
                                        </div>

                                        <p class="pt-20 ">
                                            <button class="btn1" onclick="login()">Login</button>
                                        </p>

                                        <p class=" text-center">
                                            <a href="javascript:void(0)" data-toggle="modal" onclick="forgot_profile();" id="myBtn">Forgot Password ?</a>
                                        </p>

                                        <p class="pt15 text-center">
                                            Don't have an account? <a class="db-479" href="javascript:void(0);" data-toggle="modal" onclick="register_profile();">Create an account</a>
                                        </p>
                                    </form>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Login -->

        <!-- model for forgot password start -->
        <div class="modal fade login" id="forgotPassword" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content login-frm">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body cus-forgot">
                        <div class="right-main">
                            <div class="right-main-inner">
                                <div class="">
                                    <div id="forgotbuton"></div> 
                                    <div class="title">
                                       <p class="ttc tlh2">Forgot Password</p>
                                    </div>
                                    <?php
                                    $form_attribute = array('name' => 'forgot', 'method' => 'post', 'class' => 'forgot_password', 'id' => 'forgot_password');
                                    echo form_open('profile/forgot_password', $form_attribute);
                                    ?>
                                    <div class="form-group">
                                        <input type="email" value="" name="forgot_email" id="forgot_email" class="form-control input-sm" placeholder="Email Address*">
                                        <div id="error2" style="display:block;">
                                            <?php
                                            if ($this->session->flashdata('erroremail')) {
                                                echo $this->session->flashdata('erroremail');
                                            }
                                            ?>
                                        </div>
                                        <div id="errorlogin"></div> 
                                    </div>

                                    <p class="pt-20 text-center">
                                        <input class="btn btn-theme btn1" type="submit" name="submit" value="Submit" style="width:105px; margin:0px auto;" /> 
                                    </p>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- model for forgot password end -->

        <!-- register -->

        <div class="modal fade register-model login" id="register" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content inner-form1">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <div class="clearfix">
                            <div class="">
                               <div class="title"><h1 class="tlh1">Sign up First and Register in Job Profile</h1></div>
                                <div class="main-form">
                                    <form role="form" name="register_form" id="register_form" method="post">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <input tabindex="101" autofocus="" type="text" name="first_name" id="first_name" class="form-control input-sm" placeholder="First Name">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <input tabindex="102" type="text" name="last_name" id="last_name" class="form-control input-sm" placeholder="Last Name">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input tabindex="103" type="text" name="email_reg" id="email_reg" class="form-control input-sm" placeholder="Email Address" autocomplete="new-email">
                                        </div>
                                        <div class="form-group">
                                            <input tabindex="104" type="password" name="password_reg" id="password_reg" class="form-control input-sm" placeholder="Password" autocomplete="new-password">
                                            <input type="hidden" name="password_login_postid" id="password_login_postid" class="form-control input-sm post_id_login">
                                        </div>
                                        <div class="form-group dob">
                                            <label class="d_o_b"> Date Of Birth :</label>
                                            <span> <select tabindex="105" class="day" name="selday" id="selday">
                                                    <option value="" disabled selected value>Day</option>
                                                    <?php
                                                    for ($i = 1; $i <= 31; $i++) {
                                                        ?>
                                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select></span>
                                            <span>
                                                <select tabindex="106" class="month" name="selmonth" id="selmonth">
                                                    <option value="" disabled selected value>Month</option>
                                                   
                                                    <option value="1">Jan</option>
                                                    <option value="2">Feb</option>
                                                    <option value="3">Mar</option>
                                                    <option value="4">Apr</option>
                                                    <option value="5">May</option>
                                                    <option value="6">Jun</option>
                                                    <option value="7">Jul</option>
                                                    <option value="8">Aug</option>
                                                    <option value="9">Sep</option>
                                                    <option value="10">Oct</option>
                                                    <option value="11">Nov</option>
                                                    <option value="12">Dec</option>
                                                   
                                                </select></span>
                                            <span>
                                                <select tabindex="107" class="year" name="selyear" id="selyear">
                                                    <option value="" disabled selected value>Year</option>
                                                    <?php
                                                    for ($i = date('Y'); $i >= 1900; $i--) {
                                                        ?>
                                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php
                                                    }
                                                    ?>

                                                </select>
                                            </span>
                                        </div>
                                        <div class="dateerror" style="color:#f00; display: block;"></div>

                                        <div class="form-group gender-custom">
                                            <span><select tabindex="108" class="gender"  onchange="changeMe(this)" name="selgen" id="selgen">
                                                    <option value="" disabled selected value>Gender</option>
                                                    <option value="M">Male</option>
                                                    <option value="F">Female</option>
                                                </select></span>
                                        </div>

                                        <p class="form-text" style="margin-bottom: 10px;">
                                            By Clicking on create an account button you agree our
                                            <a tabindex="109" href="<?php echo base_url('terms-and-condition'); ?>">Terms and Condition</a> and <a tabindex="110" href="<?php echo base_url('privacy-policy'); ?>">Privacy policy</a>.
                                        </p>
                                        <p>
                                            <button tabindex="111" class="btn1">Create an account</button>
                                                                                        <!--<p class="next">Next</p>-->
                                        </p>
                                        <div class="sign_in pt10">
                                            <p>
                                                Already have an account ? <a tabindex="112" onClick="login_profile_apply(<?php echo $post['post_id']; ?>)" href="javascript:void(0);"> Log In </a>
                                            </p>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- register -->

        <!-- register for apply start-->

        <div class="modal fade register-model login" id="register_apply" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <div class="clearfix">
                            <div class="col-md-12 col-sm-12">
                                <h4>Join Aileensoul - It's Free</h4>
                                <div class="main-form">
                                    <form role="form" name="register_form" id="register_form" method="post">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <input tabindex="5" type="text" name="first_name" id="first_name" class="form-control input-sm" placeholder="First Name">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <input tabindex="6" type="text" name="last_name" id="last_name" class="form-control input-sm" placeholder="Last Name">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input tabindex="7" type="text" name="email_reg" id="email_reg" class="form-control input-sm" placeholder="Email Address" autocomplete="new-email">
                                        </div>
                                        <div class="form-group">
                                            <input tabindex="8" type="password" name="password_reg" id="password_reg" class="form-control input-sm" placeholder="Password" autocomplete="new-password">
                                            <input type="hidden" name="password_login_postid" id="password_login_postid" class="form-control input-sm post_id_login">
                                        </div>
                                        <div class="form-group dob">
                                            <label class="d_o_b"> Date Of Birth :</label>
                                            <select tabindex="9" class="day" name="selday" id="selday">
                                                <option value="" disabled selected value>Day</option>
                                                <?php
                                                for ($i = 1; $i <= 31; $i++) {
                                                    ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <select tabindex="10" class="month" name="selmonth" id="selmonth">
                                                <option value="" disabled selected value>Month</option>
                                                
                                                <option value="1">Jan</option>
                                                <option value="2">Feb</option>
                                                <option value="3">Mar</option>
                                                <option value="4">Apr</option>
                                                <option value="5">May</option>
                                                <option value="6">Jun</option>
                                                <option value="7">Jul</option>
                                                <option value="8">Aug</option>
                                                <option value="9">Sep</option>
                                                <option value="10">Oct</option>
                                                <option value="11">Nov</option>
                                                <option value="12">Dec</option>
                                                
                                            </select>
                                            <select tabindex="11" class="year" name="selyear" id="selyear">
                                                <option value="" disabled selected value>Year</option>
                                                <?php
                                                for ($i = date('Y'); $i >= 1900; $i--) {
                                                    ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                    <?php
                                                }
                                                ?>

                                            </select>

                                        </div>
                                        <div class="dateerror" style="color:#f00; display: block;"></div>

                                        <div class="form-group gender-custom">
                                            <select tabindex="12" class="gender"  onchange="changeMe(this)" name="selgen" id="selgen">
                                                <option value="" disabled selected value>Gender</option>
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                            </select>
                                        </div>

                                        <p class="form-text">
                                            By Clicking on create an account button you agree our<br class="mob-none">
                                            <a href="<?php echo base_url('terms-and-condition'); ?>">Terms and Condition</a> and <a href="<?php echo base_url('privacy-policy'); ?>">Privacy policy</a>.
                                        </p>
                                        <p>
                                            <button tabindex="13" class="btn1">Create an account</button>
                                                                                      
                                        </p>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- register for apply end -->

        <!-- script for skill textbox automatic start-->
        <?php
        if (IS_REC_JS_MINIFY == '0') {
            ?>
            <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
            <?php
        } else {
            ?>
            <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js_min/bootstrap_validate.min.js?ver=' . time()); ?>"></script>
        <?php } ?>



        <script>

                                                var get_csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
                                                var csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
                                                var base_url = '<?php echo base_url(); ?>';
                                                var skill = '<?php echo $this->input->get('skills'); ?>';
                                                var place = '<?php echo $this->input->get('searchplace'); ?>';
                                                var postslug = '<?php echo $this->uri->segment(3); ?>';


        </script>

        <?php
        if (IS_REC_JS_MINIFY == '0') {
            ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/rec_post_login.js?ver=' . time()); ?>"></script>
            <?php
        } else {
            ?>

            <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/recruiter/rec_post_login.js?ver=' . time()); ?>"></script>
                        <!--<script type="text/javascript" defer="defer" src="<?php // echo base_url('assets/js_min/webpage/recruiter/rec_post_login.min.js?ver=' . time());      ?>"></script>-->

        <?php } ?>

        <script>

        </script>
    </body>
</html>