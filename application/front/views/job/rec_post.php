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

         <?php
        if (IS_JOB_CSS_MINIFY == '0') {
            ?>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver='.time()); ?>">
        <?php }else{?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/job.css?ver='.time()); ?>">

        <?php }?>

    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push freeh3 cust-job-width paddnone">
        <?php echo $header; ?>
        <?php
        $returnpage = $_GET['page'];
        if ($this->session->userdata('aileenuser') != $recliveid) {
            echo $job_header2_border;
        } elseif ($recdata[0]['re_step'] == 3) {
            echo $recruiter_header2_border;
        } elseif ($returnpage == 'notification') {
            
        }
        ?>
        <div id="preloader"></div>
        <!-- START CONTAINER -->
        <section>
            <div class="user-midd-section" id="paddingtop_fixed">
                <div class="container padding-360">
                    <!-- MIDDLE SECTION START -->
                    <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt" style="position: absolute !important;">
                        <!--left bar box start-->
                        <div class="full-box-module">   
                            <div class="profile-boxProfileCard  module">
                                <div class="profile-boxProfileCard-cover"> 
                                    <?php if ($this->session->userdata('aileenuser') == $recliveid) { ?>
                                        <a class="profile-boxProfileCard-bg u-bgUserColor a-block" href="<?php echo base_url('recruiter/profile'); ?>" tabindex="-1" 
                                           aria-hidden="true" rel="noopener">
                                           <?php } else { ?>
                                            <a class="profile-boxProfileCard-bg u-bgUserColor a-block" href="<?php echo base_url('recruiter/profile/' . $recliveid) ?>" title="<?php echo $recdata[0]['rec_firstname'] . ' ' . $recdata[0]['rec_lastname']; ?>" tabindex="-1" 
                                               aria-hidden="true" rel="noopener">
                                               <?php } ?>
                                            <div class="bg-images no-cover-upload"> 
                                                <?php
                                                $image_ori = $recdata[0]['profile_background'];
                                                $filename = $this->config->item('rec_bg_main_upload_path') . $recdata[0]['profile_background'];
                                                $s3 = new S3(awsAccessKey, awsSecretKey);
                                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                if ($info && $recdata[0]['profile_background'] != '') {
                                                    ?>
                                                    <img src = "<?php echo REC_BG_MAIN_UPLOAD_URL . $recdata[0]['profile_background']; ?>" name="image_src" id="image_src" alt="<?php echo $recdata[0]['profile_background']; ?>"/>
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
                                        <?php if ($this->session->userdata('aileenuser') == $recliveid) { ?>
                                            <a class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock"  href="<?php echo base_url('recruiter/profile/'. $recliveid); ?>" title="<?php echo $recdata[0]['rec_firstname'] . ' ' . $recdata[0]['rec_lastname']; ?>" tabindex="-1" aria-hidden="true" rel="noopener">
                                            <?php } else { ?>
                                                <a class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock"  href="<?php echo base_url('recruiter/profile/' . $recliveid); ?>" title="<?php echo $recdata[0]['rec_firstname'] . ' ' . $recdata[0]['rec_lastname']; ?>" tabindex="-1" aria-hidden="true" rel="noopener">                                               
                                                <?php } ?>
                                                <?php
                                                $filename = $this->config->item('rec_profile_thumb_upload_path') . $recdata[0]['recruiter_user_image'];
                                                $s3 = new S3(awsAccessKey, awsSecretKey);
                                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                if ($recdata[0]['recruiter_user_image'] != '' && $info) {
                                                    ?>
                                                    <div class="left_iner_img_profile">
                                                        <img src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL . $recdata[0]['recruiter_user_image']; ?>" alt="<?php echo $recdata[0]['recruiter_user_image']; ?>" >
                                                    </div>
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
                                            <?php if ($this->session->userdata('aileenuser') == $recliveid) { ?>
                                                <a href="<?php echo site_url('recruiter/profile'); ?>" title="<?php echo ucfirst(strtolower($recdata['rec_firstname'])) . ' ' . ucfirst(strtolower($recdata['rec_lastname'])); ?>">   <?php echo ucfirst(strtolower($recdata[0]['rec_firstname'])) . ' ' . ucfirst(strtolower($recdata[0]['rec_lastname'])); ?></a>
                                            <?php } else { ?>
                                                <a href="<?php echo site_url('recruiter/profile/' . $recliveid); ?>" title="<?php echo ucfirst(strtolower($recdata['rec_firstname'])) . ' ' . ucfirst(strtolower($recdata['rec_lastname'])); ?>">   <?php echo ucfirst(strtolower($recdata[0]['rec_firstname'])) . ' ' . ucfirst(strtolower($recdata[0]['rec_lastname'])); ?></a>
                                            <?php } ?>
                                        </span>

                                    
                                        <div class="profile-boxProfile-name">
                                            <?php if ($this->session->userdata('aileenuser') == $recliveid) { ?>
                                                <a href="<?php echo site_url('recruiter/profile/' . $recdata[0]['user_id']); ?>" title="<?php echo ucfirst(strtolower($recdata[0]['designation'])); ?>">
                                                <?php } else { ?>
                                                    <a href="<?php echo site_url('recruiter/profile/' . $recliveid); ?>" title="<?php echo ucfirst(strtolower($recdata[0]['designation'])); ?>">    
                                                    <?php } ?>
                                                    <?php
                                                    if (ucfirst(strtolower($recdata[0]['designation']))) {
                                                        echo ucfirst(strtolower($recdata[0]['designation']));
                                                    } else {
                                                        echo "Designation";
                                                    }
                                                    ?></a>
                                        </div>
                                        <?php if ($this->session->userdata('aileenuser') == $recliveid) { ?>
                                            <ul class=" left_box_menubar">
                                                <li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'profile') { ?> class="active" <?php } ?>><a class="padding_less_left" title="Details" href="<?php echo base_url('recruiter/profile'); ?>"> Details</a>
                                                </li>                                
                                                <li id="rec_post_home" <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'post') { ?> class="active" <?php } ?>><a title="Post" href="<?php echo base_url('recruiter/post'); ?>">Post</a>
                                                </li>
                                                <li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'save-candidate') { ?> class="active" <?php } ?>><a title="Saved Candidate" class="padding_less_right" href="<?php echo base_url('recruiter/save-candidate'); ?>">Saved </a>
                                                </li>

                                            </ul>
                                        <?php } else { ?>
                                            <ul class=" left_box_menubar">
                                                <li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'profile') { ?> class="active" <?php } ?>><a class="padding_less_left" title="Details" href="<?php echo base_url('recruiter/profile/' . $recliveid); ?>"> Details</a>
                                                </li>                                
                                                <li id="rec_post_home" <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'post') { ?> class="active" <?php } ?>><a title="Post" href="<?php echo base_url('recruiter/post/' . $recliveid); ?>">Post</a>
                                                </li>

                                            </ul>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>  


                        </div>
                       
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
                                        <a href="<?php echo base_url('business-profile'); ?>" alt="business-profile">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i4.jpg'); ?>">
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
																					
                        <!--left bar box end-->
                        <div  class="add-post-button mob-block">
                            <?php if ($this->session->userdata('aileenuser') == $recliveid) { ?>
                                <a class="btn btn-3 btn-3b" id="rec_post_job2" href="<?php echo base_url('recruiter/add-post'); ?>"><i class="fa fa-plus" aria-hidden="true"></i>  Post a Job</a>
                            <?php } ?>
                        </div>
                        <div class="mob-none">
                            <div  class="add-post-button">
                                <?php if ($this->session->userdata('aileenuser') == $recliveid) { ?>
                                    <a class="btn btn-3 btn-3b" id="rec_post_job1" href="<?php echo base_url('recruiter/add-post'); ?>"><i class="fa fa-plus" aria-hidden="true"></i>  Post a Job</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>


                    <div class="inner-right-part">
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
						
                        <?php
                        if (count($postdata) > 0) {
                            foreach ($postdata as $post) {  
                                ?>
                                <div class="all-job-box job-detail">
                                    <div class="all-job-top">
                                        <div class="post-img">
                                            <a title="<?php echo $post['re_comp_name']; ?>" href="<?php echo base_url('recruiter/profile/' . $post['user_id']); ?>">
                                                <?php
                                                $cache_time = $this->db->get_where('recruiter', array(
                                                            'user_id' => $post['user_id']
                                                        ))->row()->comp_logo;
                                                if ($cache_time) {
                                                    if (IMAGEPATHFROM == 'upload') {
                                                        if (!file_exists($this->config->item('rec_profile_thumb_upload_path') . $cache_time)) { 
                                                            ?>
                                                <img src="<?php echo base_url('assets/images/commen-img.png') ?>" alt="commonimage">
                                                   <?php     } else { ?>
                                                            <img src="<?php echo  REC_PROFILE_THUMB_UPLOAD_URL . $cache_time ?>" alt="<?php echo $cache_time; ?>">
                                                       <?php  }
                                                    } else { ?>
                                                        <!--<img src="<?php echo base_url($this->config->item('rec_profile_thumb_upload_path') . $cache_time);  ?>" alt="<?php echo $cache_time; ?>">-->
                                                    <?php    $filename = $this->config->item('rec_profile_thumb_upload_path') . $cache_time;
                                                        $s3 = new S3(awsAccessKey, awsSecretKey);
                                                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename); 
                                                         if ($info) { ?>
                                                           <img src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL . $cache_time  ?>" alt="<?php echo $cache_time; ?>">
                                                         <?php } else { ?>
                                                          <img src="<?php echo  base_url('assets/images/commen-img.png') ?>" alt="commonimage">
                                                       <?php  }
                                                    }
                                                } else { ?>
                                                    <img src="<?php echo  base_url('assets/images/commen-img.png') ?>" alt="commonimage">
                                               <?php  } ?>
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
                                            <h5><a title="<?php echo $cache_time1; ?>"><?php echo $cache_time1; ?></a></h5>
                                            <p><a href="<?php echo base_url('recruiter/profile/' . $post['user_id']); ?>" title="<?php echo $post['re_comp_name']; ?>">
                                                    <?php
                                                    $out = strlen($post['re_comp_name']) > 40 ? substr($post['re_comp_name'], 0, 40) . "..." : $post['re_comp_name'];
                                                    echo $out;
                                                    ?>
                                                </a>
                                            </p>
                                            <p><a href="<?php echo base_url('recruiter/profile/' . $post['user_id']); ?>" title="<?php echo ucfirst(strtolower($post['rec_firstname'])) . ' ' . ucfirst(strtolower($post['rec_lastname'])); ?>"><?php echo ucfirst(strtolower($post['rec_firstname'])) . ' ' . ucfirst(strtolower($post['rec_lastname'])); ?></a></p>
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
                                                            echo $countryname.' '.'(Location)';
                                                        }
                                                        ?>
                                                    </span>
                                                </span>
                                            </p>
                                            <p class="loca-exp">
                                                <span class="exp">
                                                    <span>
                                                        <!-- <img class="pr5" src="<?php //echo base_url('assets/images/exp.png'); ?>"> -->

                                                        <?php
                                                        if (($post['min_year'] != '0' || $post['max_year'] != '0') && ($post['fresher'] == 1)) {


                                                            echo $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year' . " (Required Experience) " . "(Fresher can also apply).";
                                                        } else if (($post['min_year'] != '0' || $post['max_year'] != '0')) {
                                                            echo $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year'. " (Required Experience) ";
                                                        } else {
                                                            echo "Fresher";
                                                        }
                                                        ?>
                                                    </span>
                                                </span>
                                            </p>
                                            <p class="pull-right job-top-btn">

                                                <?php if ($this->session->userdata('aileenuser') == $recliveid) { ?>
           
                                                    <?php
                                                } else {
                                                    $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
                                                    $contition_array = array(
                                                        'post_id' => $post['post_id'],
                                                        'job_delete' => '0',
                                                        'user_id' => $userid
                                                    );
                                                    $jobsave = $this->data['jobsave'] = $this->common->select_data_by_condition('job_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                    if ($jobsave) {
                                                        ?>
                                                        <a href="javascript:void(0);" class="btn4 applied">Applied</a>
                                                    <?php } else { ?>
                                                       
                                                        <?php
                                                        $userid = $this->session->userdata('aileenuser');
                                                        $contition_array = array(
                                                            'user_id' => $userid,
                                                            'job_save' => '2',
                                                            'post_id ' => $post['post_id'],
                                                            'job_delete' => '1'
                                                        );
                                                        $jobsave = $this->data['jobsave'] = $this->common->select_data_by_condition('job_apply', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                        if ($jobsave) {
                                                            ?>
                                                            <a class="btn4 saved save_saved_btn">Saved</a>
                                                        <?php } else { ?>
                                                            <a title="Save" id="<?php echo $post['post_id']; ?>" onClick="savepopup(<?php echo $post['post_id'] ?>)" href="javascript:void(0);" class="savedpost<?php echo $post['post_id']; ?> btn4 save_saved_btn">Save</a>
                                                        <?php } ?>
                                                         <a href="javascript:void(0);"  class= "applypost<?php echo $post['post_id']; ?>  btn4" onclick="applypopup(<?php echo $post['post_id'] ?>,<?php echo $post['user_id'] ?>)">Apply</a>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                               
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
                                                            <?php echo JOBDATANA; ?>
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
                                                            echo JOBDATANA;
                                                        }
                                                        ?></span>
                                                </li>
                                                <li><b>Employment Type</b>
                                                    <span>
                                                        <?php if ($post['emp_type'] != '') { ?>

                                                            <?php echo $this->common->make_links($post['emp_type']) . '  Job'; ?>

                                                            <?php
                                                        } else {
                                                            echo JOBDATANA;
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
                                                            echo JOBDATANA;
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
                                                            echo JOBDATANA;
                                                        }
                                                        ?> 
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="all-job-bottom">
                                            <span class="job-post-date"><b>Posted on:  </b><?php echo date('d-M-Y', strtotime($post['created_date'])); ?></span>
                                            <p class="pull-right">
                                                <?php if ($this->session->userdata('aileenuser') == $recliveid) { ?>
                                                    <a href="javascript:void(0);" class="btn4" onclick="removepopup(<?php echo $post['post_id'] ?>)">Remove</a>
                                                    <a href="<?php echo base_url() . 'recruiter/edit-post/' . $post['post_id'] ?>" class="btn4">Edit</a>
                                                    <?php
                                                    $join_str[0]['table'] = 'job_reg';
                                                    $join_str[0]['join_table_id'] = 'job_reg.user_id';
                                                    $join_str[0]['from_table_id'] = 'job_apply.user_id';
                                                    $join_str[0]['join_type'] = '';

                                                    $condition_array = array('post_id' => $post['post_id'], 'job_apply.job_delete' => '0', 'job_reg.status' => '1', 'job_reg.is_delete' => '0', 'job_reg.job_step' => '10');
                                                    $data = "job_apply.*,job_reg.job_id";
                                                    $apply_candida = $this->common->select_data_by_condition('job_apply', $condition_array, $data, $short_by = '', $order_by = '', $limit, $offset, $join_str, $groupby = '');
                                                    $countt = count($apply_candida);
                                                    ?>
                                                    <a href="<?php echo base_url() . 'recruiter/apply-list/' . $post['post_id'] ?>" class="btn4">Applied  Candidate : <?php echo $countt ?></a>
                                                    <?php
                                                } else {
                                                    $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
                                                    $contition_array = array(
                                                        'post_id' => $post['post_id'],
                                                        'job_delete' => '0',
                                                        'user_id' => $userid
                                                    );
                                                    $jobsave = $this->data['jobsave'] = $this->common->select_data_by_condition('job_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                    if ($jobsave) {
                                                        ?>
                                                        <a href="javascript:void(0);" class="btn4 applied">Applied</a>
                                                    <?php } else { ?>
                                                        
                                                        <?php
                                                        $userid = $this->session->userdata('aileenuser');
                                                        $contition_array = array(
                                                            'user_id' => $userid,
                                                            'job_save' => '2',
                                                            'post_id ' => $post['post_id'],
                                                            'job_delete' => '1'
                                                        );
                                                        $jobsave = $this->data['jobsave'] = $this->common->select_data_by_condition('job_apply', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                        if ($jobsave) {
                                                            ?>
                                                            <a class="btn4 saved save_saved_btn">Saved</a>
                                                        <?php } else { ?>
                                                            <a title="Save" id="<?php echo $post['post_id']; ?>" onClick="savepopup(<?php echo $post['post_id'] ?>)" href="javascript:void(0);" class="savedpost<?php echo $post['post_id']; ?> btn4 save_saved_btn">Save</a>
                                                        <?php } ?>
                                                        <a href="javascript:void(0);"  class= "applypost<?php echo $post['post_id']; ?>  btn4" onclick="applypopup(<?php echo $post['post_id'] ?>,<?php echo $post['user_id'] ?>)">Apply</a>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                
                                            </p>

                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="art-img-nn">
                                <div class="art_no_post_img">
                                    <img src="<?php echo base_url() . 'assets/img/job-no.png'; ?>" alt="nojobimage">
                                </div>
                                <div class="art_no_post_text">
                                    No  Post Available.
                                </div>
                            </div>
                        <?php } ?>
                    </div>
					
					

                </div>
            </div>
            <!-- MIDDLE SECTION END -->
        </section>
        <!-- END CONTAINER -->

        <!-- BEGIN FOOTER -->
        <!--PROFILE PIC MODEL START-->
        <div class="modal fade message-box" id="bidmodal-2" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>      
                    <div class="modal-body">
                        <span class="mes">
                            <div id="popup-form">

                                <div class="fw" id="profi_loader"  style="display:none;" style="text-align:center;" ><img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" alt="loaderimage"/></div>
                                <form id ="userimage" name ="userimage" class ="clearfix" enctype="multipart/form-data" method="post">
                                    <div class="col-md-5">
                                        <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="upload-one" >
                                    </div>

                                    <div class="col-md-7 text-center">
                                        <div id="upload-demo-one" style="display:none;" style="width:350px"></div>
                                    </div>
                                    <input type="submit" class="upload-result-one" name="profilepicsubmit" id="profilepicsubmit" value="Save" >
                                </form>

                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>

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
        <!--PROFILE PIC MODEL END-->
        <!-- START FOOTER -->
        <!-- <footer> -->
        <?php echo $login_footer ?>
        <?php echo $footer; ?>
        <!-- </footer> -->
        <!-- END FOOTER -->


        <!-- FIELD VALIDATION JS START -->
        <?php
        if (IS_REC_JS_MINIFY == '0') {
            ?>
            <script src="<?php echo base_url('assets/js/croppie.js'); ?>"></script>  
            <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
            <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
            <?php
        } else {
            ?>
              <script src="<?php echo base_url('assets/js_min/croppie.js'); ?>"></script>  
            <script src="<?php echo base_url('assets/js_min/bootstrap.min.js'); ?>"></script>
            <script src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <?php } ?>

        <?php
        if (IS_JOB_JS_MINIFY == '0') {
            ?>

        <?php if ($this->session->userdata('aileenuser') == $recliveid) { ?>
            <script src="<?php echo base_url('assets/js/webpage/recruiter/search.js'); ?>"></script>
        <?php } else { ?>
            <script src="<?php echo base_url('assets/js/webpage/job/search_common.js?ver=' . time()); ?>"></script>
        <?php } ?>

        <?php }else{?>


        <?php if ($this->session->userdata('aileenuser') == $recliveid) { ?>
            <script src="<?php echo base_url('assets/js_min/webpage/recruiter/search.js'); ?>"></script>
        <?php } else { ?>
            <script src="<?php echo base_url('assets/js_min/webpage/job/search_common.js?ver=' . time()); ?>"></script>
        <?php } ?>
        
        <?php }?>
        <script>
                                                                    var base_url = '<?php echo base_url(); ?>';
                                                                    var data1 = <?php echo json_encode($de); ?>;
                                                                    var data = <?php echo json_encode($demo); ?>;
                                                                    var get_csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
                                                                    var get_csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
                                                                    var id = '<?php echo $this->uri->segment(3); ?>';
                                                                    var return_page = '<?php echo $_GET['page']; ?>';




                                                                    function removepopup(id)
                                                                    {
                                                                        $('.biderror .mes').html("<div class='pop_content'>Do you want to remove this post?<div class='model_ok_cancel'><a class='okbtn' id=" + id + " onClick='remove_post(" + id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                                                                        $('#bidmodal').modal('show');
                                                                    }

//remove post start


                                                                    function remove_post(abc)
                                                                    {


                                                                        $.ajax({
                                                                            type: 'POST',
                                                                            url: base_url + 'recruiter/remove_post',
                                                                            data: 'post_id=' + abc,
                                                                            success: function (data) {

                                                                                $('#' + 'removepost' + abc).html(data);
                                                                                $('#' + 'removepost' + abc).removeClass();
                                                                                var numItems = $('.contact-frnd-post .job-contact-frnd .profile-job-post-detail').length;

                                                                                if (numItems == '0') {

                                                                                    var nodataHtml = "<div class='art-img-nn'><div class='art_no_post_img'><img src='" + base_url + "img/job-no.png' alt='nojobimage'/></div><div class='art_no_post_text'> No Post Available.</div></div>";
                                                                                    $('.contact-frnd-post').html(nodataHtml);
                                                                                }

                                                                            }
                                                                        });

                                                                    }


                                                                    //apply post start
                                                                    function applypopup(postid, userid)
                                                                    {
                                                                        $('.biderror .mes').html("<div class='pop_content'>Are you sure want to apply this  jobpost?<div class='model_ok_cancel'><a class='okbtn' id=" + postid + " onClick='apply_post(" + postid + "," + userid + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                                                                        $('#bidmodal').modal('show');
                                                                    }

                                                                    function apply_post(abc, xyz) {
                                                                        var alldata = 'all';
                                                                        var user = xyz;

                                                                        $.ajax({
                                                                            type: 'POST',
                                                                            url: base_url + 'job/job_apply_post',
                                                                            data: 'post_id=' + abc + '&allpost=' + alldata + '&userid=' + user,
                                                                            dataType: 'json',
                                                                            success: function (data) { 
                                                                                $('.savedpost' + abc).hide();
                                                                                $('.applypost' + abc).html(data.status);
                                                                                $('.applypost' + abc).attr('disabled', 'disabled');
                                                                                $('.applypost' + abc).attr('onclick', 'myFunction()');
                                                                                $('.applypost' + abc).addClass('applied');

                                                                                if (data.notification.notification_count != 0) {
                                                                                    var notification_count = data.notification.notification_count;
                                                                                    var to_id = data.notification.to_id;
                                                                                    show_header_notification(notification_count, to_id);
                                                                                }

                                                                            }
                                                                        });
                                                                    }
//apply post end

//save post start 
                                                                    function savepopup(id) {
                                                                        save_post(id);
                                                                        $('.biderror .mes').html("<div class='pop_content cus-pop-mes'>Jobpost successfully saved.");
                                                                        $('#bidmodal').modal('show');
                                                                    }

                                                                    function save_post(abc)
                                                                    {
                                                                        $.ajax({
                                                                            type: 'POST',
                                                                            url: base_url + 'job/job_save',
                                                                            data: 'post_id=' + abc,
                                                                            success: function (data) {
                                                                                $('.' + 'savedpost' + abc).html(data).addClass('saved');
                                                                            }
                                                                        });

                                                                    }
//save post End
        </script>



    </body>
</html>