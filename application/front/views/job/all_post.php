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
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/recruiter/rec_common_header.min.css?ver=' . time()); ?>">
        <?php } ?>

    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push freeh3">
        <?php echo $header; ?>
        <?php
        echo $job_header2_border;
        ?>
        <div id="preloader"></div>
        <!-- START CONTAINER -->
        <section>
            <div class="user-midd-section" id="paddingtop_fixed">
                <div class="container padding-360">
                    <!-- MIDDLE SECTION START -->
                    <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt">
                        <!--left bar box start-->
                        <div class="full-box-module">   
                            <div class="profile-boxProfileCard  module">
                                <div class="profile-boxProfileCard-cover <?php
                                if ($jobdata[0]['profile_background'] == '') {
                                    echo "bg-images no-cover-upload";
                                }
                                ?>">
                                    <a class="profile-boxProfileCard-bg u-bgUserColor a-block"
                                       href="<?php echo base_url('job/resume'); ?>"
                                       tabindex="-1"
                                       aria-hidden="true"
                                       rel="noopener" title="jobresume">
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
                                                <img src="<?php echo base_url(WHITEIMAGE); ?>" class="bgImage" alt="<?php echo 'NOIMAGE'; ?>">
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
                                            <a   href="<?php echo site_url('job/resume/' . $jobdata[0]['slug']); ?>">  <?php echo ucfirst($jobdata[0]['fname']) . ' ' . ucfirst($jobdata[0]['lname']); ?></a>
                                        </span>

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
                                                <a class="padding_less_left" title="Details" href="<?php echo base_url('job/resume'); ?>" title="jobresume" > Details</a>
                                            </li>
                                           
                                            <li <?php if ($this->uri->segment(1) == 'search' && $this->uri->segment(2) == 'saved-job') { ?> class="active" <?php } ?>><a title="Saved Job" href="<?php echo base_url('job/saved-job'); ?>" title="savejob">Saved </a>
                                            </li>
                                            <li <?php if ($this->uri->segment(1) == 'job' && $this->uri->segment(2) == 'applied-job') { ?> class="active" <?php } ?>><a class="padding_less_right" title="Applied Job" href="<?php echo base_url('job/applied-job'); ?>" title="applied">Applied </a>
                                            </li>
                                           
                                        </ul>

                                    </div>
                                </div>
                            </div>  


                        </div>
                        <?php echo $left_footer; ?>

                        <!--left bar box end-->
                        <div  class="add-post-button mob-block">
                            <?php if ($this->session->userdata('aileenuser') == $recliveid) { ?>
                                <a class="btn btn-3 btn-3b" id="rec_post_job2" href="<?php echo base_url('recruiter/add-post'); ?>" title="Post a job"><i class="fa fa-plus" aria-hidden="true"></i>  Post a Job</a>
                            <?php } ?>
                        </div>
                        <div class="mob-none">
                            <div  class="add-post-button">
                                <?php if ($this->session->userdata('aileenuser') == $recliveid) { ?>
                                    <a class="btn btn-3 btn-3b" id="rec_post_job1" href="<?php echo base_url('recruiter/add-post'); ?>" title="Post a job"><i class="fa fa-plus" aria-hidden="true"></i>  Post a Job</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="custom-right-art mian_middle_post_box animated fadeInUp">

                        <div class="mob-clear ">
                            <div class="common-form">
                                <div class="job-saved-box">
                                    <h3>
                                        All Jobs
                                    </h3>
                                    <div class="contact-frnd-post">
                                        
                                        <?php
                                        if (count($postdata) > 0) {
                                            foreach ($postdata as $post) {
                                                ?>
                                                <div class="job-contact-frnd ">
                                                    <div class="profile-job-post-detail clearfix" id="<?php echo "removepost" . $post['post_id']; ?>">
                                                        <!-- vishang 14-4 end -->
                                                        <div class="profile-job-post-title clearfix">
                                                            <div class="profile-job-profile-button clearfix">
                                                                <div class="profile-job-details col-md-12">
                                                                    <ul>
                                                                        <li class="fr date_re">
                                                                            Created Date : <?php echo date('d-M-Y', strtotime($post['created_date'])); ?>
                                                                        </li>
                                                                        <?php
                                                                        $cache_time = $this->db->get_where('job_title', array('title_id' => $post['post_name']))->row()->name;
                                                                        if ($cache_time) {
                                                                            $cache_time;
                                                                        } else {
                                                                            $cache_time = $post['post_name'];
                                                                        }
                                                                        ?>

                                                                        <li class="">
                                                                            <a class="post_title" href="javascript:void(0)" title="<?php echo $cache_time; ?>"><?php echo $cache_time; ?>
                                                                            </a>     
                                                                        </li>

                                                                        <li>  
                                                                            <?php
                                                                            $cityname = $this->db->get_where('cities', array('city_id' => $post['city']))->row()->city_name;
                                                                            $countryname = $this->db->get_where('countries', array('country_id' => $post['country']))->row()->country_name;
                                                                            ?> 

                                                                            <?php
                                                                            if ($cityname || $countryname) {
                                                                                ?>

                                                                                <div class="fr lction">
                                                                                    <p title="Location"><i class="fa fa-map-marker" aria-hidden="true"></i>

                                                                                        <?php
                                                                                        if ($cityname) {
                                                                                            echo $cityname . ', ';
                                                                                        }
                                                                                        ?>
                                                                                        <?php echo $countryname; ?> 
                                                                                    </p>

                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                            <a class="display_inline" title="<?php echo $post['re_comp_name'] ?>" href="javascript:void(0)">
                                                                                <?php
                                                                                $out = strlen($post['re_comp_name']) > 40 ? substr($post['re_comp_name'], 0, 40) . "..." : $post['re_comp_name'];
                                                                                echo $out;
                                                                                ?> </a>
                                                                        </li>
                                                                        <li class="fw"><a class="display_inline" title="Recruiter Name" href="javascript:void(0)"> <?php echo ucfirst(strtolower($post['rec_firstname'])) . ' ' . ucfirst(strtolower($post['rec_lastname'])); ?> </a></li>
                                                                        <!-- vishang 14-4 end -->    
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="profile-job-profile-menu">
                                                                <ul class="clearfix">
                                                                    <li> <b> Skills</b> <span> 
                                                                            <?php
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
                                                                                    $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;


                                                                                    echo $cache_time;
                                                                                    $k++;
                                                                                } echo "," . $post['other_skill'];
                                                                            }
                                                                            ?>     

                                                                        </span>
                                                                    </li>
                                                                   
                                                                    <li><b>Job Description</b><span><pre><?php echo $this->common->make_links($post['post_description']); ?></pre></span>
                                                                    </li>
                                                                    <li><b>Interview Process</b><span>


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

                                                                    <!-- vishang 14-4 start -->
                                                                    <li>
                                                                        <b>Required Experience</b>
                                                                        <span>
                                                                            <p title="Min - Max">
                                                                                <?php
                                                                                if (($post['min_year'] != '0' || $post['max_year'] != '0') && ($post['fresher'] == 1)) {


                                                                                    echo $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year' . " , " . "Fresher can also apply.";
                                                                                } else if (($post['min_year'] != '0' || $post['max_year'] != '0')) {
                                                                                    echo $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year';
                                                                                } else {
                                                                                    echo "Fresher";
                                                                                }
                                                                                ?> 

                                                                            </p>  
                                                                        </span>
                                                                    </li>


                                                                    <li><b>Salary</b><span title="Min - Max" >
                                                                            <?php
                                                                            $currency = $this->db->get_where('currency', array('currency_id' => $post['post_currency']))->row()->currency_name;

                                                                            if ($post['min_sal'] || $post['max_sal']) {
                                                                                echo $post['min_sal'] . " - " . $post['max_sal'] . ' ' . $currency . ' ' . $post['salary_type'];
                                                                            } else {
                                                                                echo PROFILENA;
                                                                            }
                                                                            ?></span>
                                                                    </li>



                                                                    <li><b>No of Position</b><span><?php echo $post['post_position'] . ' ' . 'Position'; ?></span>
                                                                    </li>

                                                                    <li><b>Industry Type</b> <span>
                                                                            <?php
                                                                            $cache_time = $this->db->get_where('job_industry', array('industry_id' => $post['industry_type']))->row()->industry_name;
                                                                            echo $cache_time;
                                                                            ?>
                                                                        </span> 
                                                                    </li>



                                                                    <?php if ($post['degree_name'] != '' || $post['other_education'] != '') { ?>

                                                                        <li> <b>Education Required</b> <span> 



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
                                                                        </li>

                                                                        <?php
                                                                    } else {
                                                                        ?>

                                                                        <li><b>Education Required</b><span>
                                                                                <?php echo PROFILENA; ?>
                                                                            </span>
                                                                        </li>
                                                                    <?php }
                                                                    ?>                   <li><b>Employment Type</b><span>


                                                                            <?php if ($post['emp_type'] != '') { ?>
                                                                                <pre>
                                                                                    <?php echo $this->common->make_links($post['emp_type']) . '  Job'; ?></pre>
                                                                                <?php
                                                                            } else {
                                                                                echo PROFILENA;
                                                                            }
                                                                            ?> 

                                                                        </span>
                                                                    </li>

                                                                    <li><b>Company Profile</b><span>


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

                                                            <div class="profile-job-profile-button clearfix">
                                                                <div class="profile-job-details col-md-12">
                                                                    <ul><li class="job_all_post ">
                                                                        <li class="job_all_post last_date">
                                                                            Last Date :
                                                                            <?php
                                                                            if ($post['post_last_date'] != "0000-00-00") {
                                                                                echo date('d-M-Y', strtotime($post['post_last_date']));
                                                                            } else {
                                                                                echo PROFILENA;
                                                                            }
                                                                            ?>
                                                                        </li>                                                   </li>
                                                                        <?php if ($this->session->userdata('aileenuser') == $recliveid) { ?>
                                                                            <li class="fr">';
                                                                                <a href="javascript:void(0);" class="button" onclick="removepopup(<?php echo $post['post_id'] ?>)" title="remove">Remove</a>
                                                                                <a href="<?php echo base_url() . 'recruiter/edit-post/' . $post['post_id'] ?>" class="button" title="edit">Edit</a>
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

                                                                                <a href="<?php echo base_url() . 'recruiter/apply-list/' . $post['post_id'] ?>" class="button" title="Applied  Candidate : <?php echo $countt ?>">Applied  Candidate : <?php echo $countt ?></a>
                                                                            </li>
                                                                        <?php } else { ?>
                                                                            <li class="fr">
                                                                                <?php
                                                                                $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
                                                                                $contition_array = array(
                                                                                    'post_id' => $post['post_id'],
                                                                                    'job_delete' => '0',
                                                                                    'user_id' => $userid
                                                                                );
                                                                                $jobsave = $this->data['jobsave'] = $this->common->select_data_by_condition('job_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                                                if ($jobsave) {
                                                                                    ?>
                                                                                <a href="javascript:void(0);" class="button applied" title="Applied">Applied</a>
                                                                                <?php } else { ?>
                                                                                <li class="fr"><a title="Apply" href="javascript:void(0);"  class= "applypost<?php echo $post['post_id']; ?>  button" onclick="applypopup(<?php echo $post['post_id'] ?>,<?php echo $post['user_id'] ?>)">Apply</a></li>
                                                                                <li class="fr">
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
                                                                                    <a class="button saved save_saved_btn" title="Saved">Saved</a>
                                                                                    <?php } else { ?>

                                                                                        <a title="Save" id="<?php echo $post['post_id']; ?>" onClick="savepopup(<?php echo $post['post_id'] ?>)" href="javascript:void(0);" class="savedpost<?php echo $post['post_id']; ?> button save_saved_btn">Save</a>
                                                                                    <?php } ?>

                                                                                </li>
                                                                            <?php } ?>
                                                                            </li>
                                                                        <?php } ?>
                                                                    </ul>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        } else {
                                            ?>

                                            <div class="art-img-nn">
                                                <div class="art_no_post_img">
                                                    <img src="' . base_url() . 'img/job-no.png" alt="JOBNOIMAGE">

                                                </div>
                                                <div class="art_no_post_text">
                                                    No  Post Available.
                                                </div>
                                            </div>
                                        <?php }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig"> 

                         <div class="all-profile-box">
                                <div class="all-pro-head">
                                    <h4>Profiles<a href="<?php echo base_url('profiles/') . $this->session->userdata('aileenuser_slug'); ?>" class="pull-right" title="all">All</a></h4>
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

        <?php echo $footer; ?>
        <!-- </footer> -->
        <!-- END FOOTER -->

 <?php
        if (IS_JOB_JS_MINIFY == '0') {
            ?>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/search_common.js?ver=' . time()); ?>"></script>

<?php }else{?>

  <script src="<?php echo base_url('assets/js_min/bootstrap.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/job/search_common.js?ver=' . time()); ?>"></script>

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
                                    $('.biderror .mes').html("<div class='pop_content'>Do you want to remove this post?<div class='model_ok_cancel'><a class='okbtn' id=" + id + " onClick='remove_post(" + id + ")' href='javascript:void(0);' data-dismiss='modal' title='Yes'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal' title='No'>No</a></div></div>");
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
                                    $('.biderror .mes').html("<div class='pop_content'>Do you want to apply this job?<div class='model_ok_cancel'><a class='okbtn' id=" + postid + " onClick='apply_post(" + postid + "," + userid + ")' href='javascript:void(0);' data-dismiss='modal' title='Yes'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal' title='No'>No</a></div></div>");
                                    $('#bidmodal').modal('show');
                                }

                                function apply_post(abc, xyz) {
                                    var alldata = 'all';
                                    var user = xyz;

                                    $.ajax({
                                        type: 'POST',
                                        url: base_url + 'job/job_apply_post',
                                        data: 'post_id=' + abc + '&allpost=' + alldata + '&userid=' + user,
                                        datatype: 'json',
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
                                    $('.biderror .mes').html("<div class='pop_content'>Job successfully saved.");
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