<!DOCTYPE html>
<html>
    <!-- start head -->
    <?php echo $head; ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/recruiter.css'); ?>">

    <!-- END HEAD -->
    <!-- start header -->
    <?php echo $header; ?>
    <?php echo $job_header2_border; ?>
    <!-- END HEADER -->

    <body class="cust-job-width">

        <!-- cover pic start -->

        <!-- cover pic end -->

        <div id="paddingtop_fixed" class="user-midd-section">
            <div class="container padding-360">
                <div class="row4">
                    <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt">
                        <div class="">
                            <div class="full-box-module">   
                                <div class="profile-boxProfileCard  module">
                                    <div class="profile-boxProfileCard-cover"> 
                                        <a title="Recruiter profile" class="profile-boxProfileCard-bg u-bgUserColor a-block" href="<?php echo base_url('recruiter/profile/' . $postdata[0]['user_id']); ?>" tabindex="-1" 
                                           aria-hidden="true" rel="noopener">
                                            <div class="bg-images no-cover-upload"> 
                                                <?php
                                                $image_ori = $postdata[0]['profile_background'];
                                                $filename = $this->config->item('rec_bg_main_upload_path') . $postdata[0]['profile_background'];
                                                $s3 = new S3(awsAccessKey, awsSecretKey);
                                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                if ($info && $postdata[0]['profile_background'] != '') {
                                                    ?>
                                                    <img src = "<?php echo REC_BG_MAIN_UPLOAD_URL . $postdata[0]['profile_background']; ?>" name="image_src" id="image_src" alt="<?php echo $postdata[0]['profile_background']; ?>"/>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <img src="<?php echo base_url(WHITEIMAGE); ?>" class="bgImage" alt="<?php echo $postdata[0]['rec_firstname'] . ' ' . $postdata[0]['rec_lastname']; ?>" >
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="profile-boxProfileCard-content clearfix">
                                        <div class="left_side_box_img buisness-profile-txext">

                                            <a title="Recruiter profile" class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock"  href="<?php echo base_url('recruiter/profile/' . $postdata[0]['user_id']); ?>" title="<?php echo $postdata[0]['rec_firstname'] . ' ' . $postdata[0]['rec_lastname']; ?>" tabindex="-1" aria-hidden="true" rel="noopener">
                                                <?php
                                                $filename = $this->config->item('rec_profile_thumb_upload_path') . $postdata[0]['recruiter_user_image'];
                                                $s3 = new S3(awsAccessKey, awsSecretKey);
                                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                if ($postdata[0]['recruiter_user_image'] != '' && $info) {
                                                    ?>
                                                    <img src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL . $postdata[0]['recruiter_user_image']; ?>" alt="<?php echo $postdata[0]['recruiter_user_image']; ?>" >
                                                    <?php
                                                } else {


                                                    $a = $postdata[0]['rec_firstname'];
                                                    $acr = substr($a, 0, 1);

                                                    $b = $postdata[0]['rec_lastname'];
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
                                                <a href="<?php echo site_url('recruiter/profile/' . $postdata[0]['user_id']); ?>" title="<?php echo ucfirst(strtolower($postdata[0]['rec_firstname'])) . ' ' . ucfirst(strtolower($postdata[0]['rec_lastname'])); ?>">   <?php echo ucfirst(strtolower($postdata[0]['rec_firstname'])) . ' ' . ucfirst(strtolower($postdata[0]['rec_lastname'])); ?></a>
                                            </span>


                                            <div class="profile-boxProfile-name">
                                                <a href="<?php echo site_url('recruiter/profile/' . $postdata[0]['user_id']); ?>" title="<?php echo ucfirst(strtolower($postdata[0]['designation'])); ?>">
                                                    <?php
                                                    if (ucfirst(strtolower($postdata[0]['designation']))) {
                                                        echo ucfirst(strtolower($postdata[0]['designation']));
                                                    } else {
                                                        echo "Designation";
                                                    }
                                                    ?></a>
                                            </div>
                                            <ul class=" left_box_menubar">
                                                <li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'profile') { ?> class="active" <?php } ?>><a class="padding_less_left" title="Details" href="<?php echo base_url('recruiter/profile/' . $postdata[0]['user_id']); ?>"> Details</a>
                                                </li>                                
                                                <li id="rec_post_home" <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'post') { ?> class="active" <?php } ?>><a title="Post" href="<?php echo base_url('recruiter/post/' . $postdata[0]['user_id']); ?>">Post</a>
                                                </li>
<!--                                                <li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'save-candidate') { ?> class="active" <?php } ?>><a title="Saved Candidate" class="padding_less_right" href="<?php echo base_url('recruiter/save-candidate/' . $postdata[0]['user_id']); ?>">Saved </a>
                                                </li>-->

                                            </ul>
                                        </div>
                                    </div>
                                </div>                             
                            </div>		
                        </div>
                        <?php echo $left_footer; ?>  
                    </div>



                    <?php
                    if (count($postdata) > 0) {
                        foreach ($postdata as $post) {
                            ?>
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
                                <div class="all-job-box job-detail">
                                    <div class="all-job-top">
                                        <div class="post-img">
                                            <a href="#">
                                                <?php
                                                $cache_time = $this->db->get_where('recruiter', array(
                                                            'user_id' => $post['user_id']
                                                        ))->row()->comp_logo;
                                                if ($cache_time) {
                                                    if (IMAGEPATHFROM == 'upload') {
                                                        if (!file_exists($this->config->item('rec_profile_thumb_upload_path') . $cache_time)) {
                                                            ?>
                                                            <img src="<?php echo base_url('assets/images/commen-img.png') ?>">
                                                        <?php } else { ?>
                                                            <img src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL . $cache_time ?>">
                                                            <?php
                                                        }
                                                    } else {
                                                        $filename = $this->config->item('rec_profile_thumb_upload_path') . $cache_time;
                                                        $s3 = new S3(awsAccessKey, awsSecretKey);
                                                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                        if ($info) {
                                                            ?>
                                                            <img src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL . $cache_time ?>">
                                                        <?php } else { ?>
                                                            <img src="<?php echo base_url('assets/images/commen-img.png') ?>">
                                                            <?php
                                                        }
                                                    }
                                                } else {
                                                    ?>
                                                    <img src="<?php echo base_url('assets/images/commen-img.png') ?>">
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
                                            <h5><a href="javascript:void(0);"><?php echo $cache_time1; ?></a></h5>
                                            <p><a href="javascript:void(0);">
                                                    <?php
                                                    $out = strlen($post['re_comp_name']) > 40 ? substr($post['re_comp_name'], 0, 40) . "..." : $post['re_comp_name'];
                                                    echo $out;
                                                    ?>
                                                </a>
                                            </p>
                                            <p><a href="javascript:void(0);"><?php echo ucfirst(strtolower($post['rec_firstname'])) . ' ' . ucfirst(strtolower($post['rec_lastname'])); ?></a></p>
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
                                                        <!--<img class="pr5" src="<?php echo base_url('assets/images/exp.png'); ?>">-->

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
        <!--                                            <p class="pull-right job-top-btn">

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
                                                                                        <a href="javascript:void(0);"  class= "applypost<?php echo $post['post_id']; ?>  btn4" onclick="applypopup(<?php echo $post['post_id'] ?>,<?php echo $post['user_id'] ?>)">Apply</a>
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
                                                    <?php
                                                }
                                            }
                                            ?>

                                                                                                    <a href="#" class="btn4">Save</a>
                                                                                                                            <a href="#" class="btn4">Apply</a>
                                            </p>-->
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
                                            <span class="job-post-date"><b>Posted on:  </b><?php echo date('d-M-Y', strtotime($post['created_date'])); ?></span>
        <!--                                            <p class="pull-right">
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
                                                                                        <a href="javascript:void(0);"  class= "applypost<?php echo $post['post_id']; ?>  btn4" onclick="applypopup(<?php echo $post['post_id'] ?>,<?php echo $post['user_id'] ?>)">Apply</a>
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
                                                    <?php
                                                }
                                            }
                                            ?>
                                                                                                    <a href="#" class="btn4">Save</a>
                                                                                                    <a href="#" class="btn4">Apply</a>
                                            </p>-->

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                    <div class="inner-right-part cust-border">
                        <div class="art-img-nn">
                            <div class="art_no_post_img">
                                <img src="<?php echo base_url('assets/img/job-no.png'); ?>">

                            </div>
                            <div class="art_no_post_text">
                                No  Post Available.
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>


    </div>
    <!-- <footer> -->
    <?php echo $login_footer ?>
    <?php echo $footer; ?>
    <!-- </footer> -->


</body>
<script>
    var base_url = '<?php echo base_url(); ?>';
</script>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/search_common.js?ver=' . time()); ?>"></script>
</html>
<!-- script for skill textbox automatic start (option 2)-->
