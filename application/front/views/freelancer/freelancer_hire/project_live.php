<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?> 
<?php if (IS_HIRE_CSS_MINIFY == '0') {?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/freelancer-hire.css?ver=' . time()); ?>">
        <?php } else {?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/freelancer-hire.css?ver=' . time()); ?>">
        <?php } ?>
    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push freeh3">
        <?php echo $header; ?>
        <?php
        $returnpage = $_GET['page'];
        //echo $returnpage;die();
        if ($this->session->userdata('aileenuser') != $recliveid) {
            echo $freelancer_post_header2_border;
        } elseif ($freelancr_user_data[0]['free_hire_step'] == 3) {
            echo $freelancer_hire_header2_border;
        } elseif ($this->session->userdata('aileenuser') == $recliveid) {
            echo $freelancer_hire_header2_border;
        } else {
            
        }
        ?>

        <!-- START CONTAINER -->
        <section>
            <!-- MIDDLE SECTION START -->
            <div class="user-midd-section" id="paddingtop_fixed">
                <div class="container padding-360">
                    <div class="row4">
                        <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt"><div class="">
                                <div class="full-box-module">   
                                    <div class="profile-boxProfileCard  module">
                                        <div class="profile-boxProfileCard-cover"> 
                                             <?php $hire_user = $this->common->select_data_by_id('freelancer_hire_reg', 'user_id', $this->session->userdata('aileenuser'), $data = 'user_id', $join_str = array()); 
                                                   $post_user = $this->common->select_data_by_id('freelancer_post', 'post_id', $postid, $data = 'user_id', $join_str = array()); ?>
                                            <?php if ($this->session->userdata('aileenuser') == $post_user[0]['user_id']) { ?>
                                                <a class="profile-boxProfileCard-bg u-bgUserColor a-block" href="<?php echo base_url('freelance-hire/employer-details'); ?>"  aria-hidden="true" rel="noopener">
                                                   <?php } else if($hire_user) { ?>
                                                    <a class="profile-boxProfileCard-bg u-bgUserColor a-block" href="javascript:void(0);" aria-hidden="true" rel="noopener">
                                                   <?php } else { ?>
                                                    <a class="profile-boxProfileCard-bg u-bgUserColor a-block" href="<?php echo base_url('freelance-hire/employer-details/' . $recliveid . '?page=freelancer_post'); ?>" onclick="login_profile();" tabindex="-1" 
                                                       aria-hidden="true" rel="noopener">
                                                       <?php } ?>
                                                    <div class="bg-images no-cover-upload"> 
                                                        <?php
                                                        // $image_ori = $this->config->item('rec_bg_thumb_upload_path') . $freelancr_user_data[0]['profile_background'];

                                                        if ($freelancr_user_data[0]['profile_background'] != '') {
                                                            ?>
                                                            <!-- box image start -->
                                                            <img src="<?php echo FREE_HIRE_BG_THUMB_UPLOAD_URL . $freelancr_user_data[0]['profile_background']; ?>" class="bgImage" alt="<?php echo $freelancr_user_data[0]['fullname'] . ' ' . $freelancr_user_data[0]['username']; ?>">
                                                            <!-- box image end -->
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <img src="<?php echo base_url(WHITEIMAGE); ?>" class="bgImage" alt="<?php echo $freelancr_user_data[0]['fullname'] . ' ' . $freelancr_user_data[0]['username']; ?>" >
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </a>
                                        </div>
                                        <div class="profile-boxProfileCard-content clearfix">
                                            <div class="left_side_box_img buisness-profile-txext">
                                                <?php if ($this->session->userdata('aileenuser') == $post_user[0]['user_id']) { ?>
                                                    <a class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock" href="<?php echo base_url('freelance-hire/employer-details'); ?>"  title="<?php echo $freelancr_user_data[0]['fullname'] . ' ' . $freelancr_user_data[0]['username']; ?>" tabindex="-1" aria-hidden="true" rel="noopener">
                                                    <?php } else if($hire_user) { ?>
                                                        <a class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock" href="javascript:void(0);"  title="<?php echo $freelancr_user_data[0]['fullname'] . ' ' . $freelancr_user_data[0]['username']; ?>" tabindex="-1" aria-hidden="true" rel="noopener">
                                                            <?php
                                                        } else { ?>
                                                            <a class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock" href="<?php echo base_url('freelance-hire/employer-details/' . $recliveid . '?page=freelancer_post'); ?>"  title="<?php echo $freelancr_user_data[0]['fullname'] . ' ' . $freelancr_user_data[0]['username']; ?>" tabindex="-1" aria-hidden="true" rel="noopener">
                                                       <?php  } 
                                                        $fname = $freelancr_user_data[0]['fullname'];
                                                        $lname = $freelancr_user_data[0]['username'];
                                                        $sub_fname = substr($fname, 0, 1);
                                                        $sub_lname = substr($lname, 0, 1);

                                                        if ($freelancr_user_data[0]['freelancer_hire_user_image']) {
                                                            if (IMAGEPATHFROM == 'upload') {
                                                                if (!file_exists($this->config->item('free_hire_profile_main_upload_path') . $freelancr_user_data[0]['freelancer_hire_user_image'])) {
                                                                    ?>
                                                                    <div class="post-img-profile">
                                                                        <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>
                                                                    </div>
                                                                <?php } else {
                                                                    ?>
                                                                    <img src="<?php echo FREE_HIRE_PROFILE_MAIN_UPLOAD_URL . $freelancr_user_data[0]['freelancer_hire_user_image']; ?>" alt="<?php echo $freelancr_user_data[0]['fullname'] . " " . $freelancr_user_data[0]['username']; ?>" > 
                                                                    <?php
                                                                }
                                                            } else {
                                                                $filename = $this->config->item('free_hire_profile_main_upload_path') . $freelancr_user_data[0]['freelancer_hire_user_image'];
                                                                $s3 = new S3(awsAccessKey, awsSecretKey);
                                                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                                if ($info) {
                                                                    ?>
                                                                    <img src="<?php echo FREE_HIRE_PROFILE_MAIN_UPLOAD_URL . $freelancr_user_data[0]['freelancer_hire_user_image']; ?>" alt="<?php echo $freelancr_user_data[0]['fullname'] . " " . $freelancr_user_data[0]['username']; ?>" >
                                                                <?php } else {
                                                                    ?>
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
                                                    <?php if ($this->session->userdata('aileenuser') == $post_user[0]['user_id']) { ?>
                                                        <a href="<?php echo base_url('freelance-hire/employer-details'); ?>"  title="<?php echo ucfirst(strtolower($freelancr_user_data['fullname'])) . ' ' . ucfirst(strtolower($freelancr_user_data['username'])); ?>">   <?php echo ucfirst(strtolower($freelancr_user_data[0]['fullname'])) . ' ' . ucfirst(strtolower($freelancr_user_data[0]['username'])); ?></a>
                                                    <?php } else if($hire_user) { ?>
                                                        <a href="javascript:void(0);"  title="<?php echo ucfirst(strtolower($freelancr_user_data['fullname'])) . ' ' . ucfirst(strtolower($freelancr_user_data['username'])); ?>">   <?php echo ucfirst(strtolower($freelancr_user_data[0]['fullname'])) . ' ' . ucfirst(strtolower($freelancr_user_data[0]['username'])); ?></a>
                                                    <?php } else{ ?>
                                                        <a href="<?php echo base_url('freelance-hire/employer-details/' . $recliveid . '?page=freelancer_post'); ?>"  title="<?php echo ucfirst(strtolower($freelancr_user_data['fullname'])) . ' ' . ucfirst(strtolower($freelancr_user_data['username'])); ?>">   <?php echo ucfirst(strtolower($freelancr_user_data[0]['fullname'])) . ' ' . ucfirst(strtolower($freelancr_user_data[0]['username'])); ?></a>
                                                    <?php } ?>
                                                </span>

                                                <?php //$category = $this->db->get_where('industry_type', array('industry_id' => $businessdata[0]['industriyal'], 'status' => 1))->row()->industry_name;   ?>
                                                <div class="profile-boxProfile-name">
                                                    <?php if ($this->session->userdata('aileenuser') == $post_user[0]['user_id']) { ?>
                                                        <a href="<?php echo base_url('freelance-hire/employer-details'); ?>"  title="<?php echo ucfirst(strtolower($freelancr_user_data[0]['designation'])); ?>">
                                                        <?php } else if($hire_user) { ?>
                                                            <a href="javascript:void(0);"  title="<?php echo ucfirst(strtolower($freelancr_user_data[0]['designation'])); ?>">
                                                            <?php } else{ ?>
                                                                <a href="<?php echo base_url('freelance-hire/employer-details/' . $recliveid . '?page=freelancer_post'); ?>"  title="<?php echo ucfirst(strtolower($freelancr_user_data[0]['designation'])); ?>">
                                                            <?php } ?>
                                                            <?php
                                                            if (ucfirst(strtolower($freelancr_user_data[0]['designation']))) {
                                                                echo ucfirst(strtolower($freelancr_user_data[0]['designation']));
                                                            } else {
                                                                echo "Designation";
                                                            }
                                                            ?></a>
                                                </div>
                                                <ul class=" left_box_menubar">
                                                    
                                                    <?php if ($this->session->userdata('aileenuser') == $post_user[0]['user_id']) { ?>
                                                        <li <?php if (($this->uri->segment(1) == 'freelance-hire') && ($this->uri->segment(2) == 'employer-details')) { ?> class="active" <?php } ?>><a title="Employer Details"  class="padding_less_left" href="<?php echo base_url('freelance-hire/employer-details'); ?>" ><?php echo $this->lang->line("details"); ?></a></li>
                                                    <?php } else if($hire_user) { ?>
                                                        <li <?php if (($this->uri->segment(1) == 'freelance-hire') && ($this->uri->segment(2) == 'employer-details')) { ?> class="active" <?php } ?>><a title="Employer Details"  class="padding_less_left" href="javascript:void(0);" ><?php echo $this->lang->line("details"); ?></a></li>
                                                    <?php } else { ?>
                                                        <li <?php if (($this->uri->segment(1) == 'freelance-hire') && ($this->uri->segment(2) == 'employer-details')) { ?> class="active" <?php } ?>><a title="Employer Details"  class="padding_less_left" href="<?php echo base_url('freelance-hire/employer-details/' . $recliveid . '?page=freelancer_post'); ?>" ><?php echo $this->lang->line("details"); ?></a></li>
                                                    <?php } ?>
                                                    <?php if ($this->session->userdata('aileenuser') == $post_user[0]['user_id']) { ?>
                                                        <li><a title="Projects" href="<?php echo base_url('freelance-hire/projects'); ?>"><?php echo $this->lang->line("Projects"); ?></a></li>
                                                    <?php } else if($hire_user) { ?>
                                                        <li><a title="Projects" href="javascript:void(0);"><?php echo $this->lang->line("Projects"); ?></a></li>
                                                    <?php } else{ ?>
                                                        <li><a title="Projects" href="<?php echo base_url('freelance-hire/projects/' . $recliveid . '?page=freelancer_post'); ?>"><?php echo $this->lang->line("Projects"); ?></a></li>
                                                    <?php }?>
                                                    <?php if ($this->session->userdata('aileenuser') == $recliveid) { ?>
                                                        <li <?php if (($this->uri->segment(1) == 'freelance-hire') && ($this->uri->segment(2) == 'freelancer-save')) { ?> class="active" <?php } ?>><a title="Saved Freelancer"  class="padding_less_right" href="<?php echo base_url('freelance-hire/freelancer-save'); ?>"><?php echo $this->lang->line("saved"); ?></a></li>
                                                    <?php } ?>

                                                </ul>
                                            </div>

                                        </div>
                                    </div>                             
                                </div>
                                
                            </div>
                        </div>
                        <div class="custom-right-art mian_middle_post_box animated fadeInUp">
                            <div class="common-form">
                                <?php
                                $applyuser = $this->common->select_data_by_id('freelancer_post_reg', 'user_id', $this->session->userdata('aileenuser'), $data = 'user_id', $join_str = array());
                                if ($applyuser) {
                                    ?>
                                    <div class="job-saved-box">
                                        <h3>
                                            <?php echo $postdata[0]['post_name']; ?>
                                        </h3>
                                        <?php

                                        function text2link($text) {
                                            $text = preg_replace('/(((f|ht){1}t(p|ps){1}:\/\/)[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '<a href="\\1" target="_blank" rel="nofollow">\\1</a>', $text);
                                            $text = preg_replace('/([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '\\1<a href="http://\\2" target="_blank" rel="nofollow">\\2</a>', $text);
                                            $text = preg_replace('/([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})/i', '<a href="mailto:\\1" rel="nofollow" target="_blank">\\1</a>', $text);
                                            return $text;
                                        }
                                        ?>

                                        <div class="contact-frnd-post">
                                            <?php
                                            foreach ($postdata as $post) {
                                                ?>
                                                <div class="job-contact-frnd">
                                                    <div class="profile-job-post-detail clearfix" id="<?php echo "removeapply" . $post['post_id']; ?>">
                                                        <div class="profile-job-post-title-inside clearfix">
                                                            <div class="profile-job-post-title clearfix margin_btm" >
                                                                <div class="profile-job-profile-button clearfix">
                                                                    <div class="profile-job-details col-md-12">
                                                                        <ul>
                                                                            <li class="fr">
                                                                                Created Date : <?php
                                                                                echo trim(date('d-M-Y', strtotime($post['created_date'])));
                                                                                ?>
                                                                            </li>
                                                                            <li>
                                                                                <a href="javascript:void(0);" title="<?php echo ucwords(text2link($post['post_name'])); ?>" class="post_title ">
                                                                                    <?php echo ucwords($post['post_name']); ?> </a>  
                                                                            </li>


                                                                            <?php
                                                                            $firstname = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->fullname;
                                                                            $lastname = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->username;
                                                                            ?>
                                                                            <?php $cityname = $this->db->get_where('cities', array('city_id' => $post['city']))->row()->city_name; ?>
                                                                            <?php $countryname = $this->db->get_where('countries', array('country_id' => $post['country']))->row()->country_name; ?>

                                                                            <li>
                                                                                <?php
                                                                                $postuser = $this->common->select_data_by_id('freelancer_post', 'post_id', $post['post_id'], $data = 'user_id', $join_str = array());
                                                                                $hireuser = $this->common->select_data_by_id('freelancer_hire_reg', 'user_id', $this->session->userdata('aileenuser'), $data = 'user_id', $join_str = array());
                                                                                if ($postuser[0]['user_id'] == $this->session->userdata('aileenuser')) {
                                                                                    ?>
                                                                                    <a class="display_inline" title="<?php echo ucwords($firstname); ?>&nbsp;<?php echo ucwords($lastname); ?>" href="<?php echo base_url('freelance-hire/employer-details/' . $post['user_id']); ?>"><?php echo ucwords($firstname); ?>&nbsp;<?php echo ucwords($lastname); ?>
                                                                                    </a>

                                                                                    <?php if ($cityname || $countryname) { ?>
                                                                                        <div class="fr lction display_inline">

                                                                                            <p title="Location"><i class="fa fa-map-marker" aria-hidden="true"></i>
                                                                                                <?php if ($cityname) { ?> 
                                                                                                    <?php echo $cityname . ","; ?>
                                                                                                <?php } ?>
                                                                                                <?php echo $countryname; ?></p>
                                                                                        </div>
                                                                                    <?php } ?>
                                                                                <?php } else if ($hireuser) {
                                                                                    ?>
                                                                                    <a class="display_inline" title="<?php echo ucwords($firstname); ?>&nbsp;<?php echo ucwords($lastname); ?>" href="javascript:void(0);"><?php echo ucwords($firstname); ?>&nbsp;<?php echo ucwords($lastname); ?>
                                                                                    </a>

                                                                                    <?php if ($cityname || $countryname) { ?>
                                                                                        <div class="fr lction display_inline">

                                                                                            <p title="Location"><i class="fa fa-map-marker" aria-hidden="true"></i>
                                                                                                <?php if ($cityname) { ?> 
                                                                                                    <?php echo $cityname . ","; ?>
                                                                                                <?php } ?>
                                                                                                <?php echo $countryname; ?></p>
                                                                                        </div>
                                                                                    <?php } ?>
                                                                                <?php } else { ?>
                                                                                    <a class="display_inline" title="<?php echo ucwords($firstname); ?>&nbsp;<?php echo ucwords($lastname); ?>" href="<?php echo base_url('freelance-hire/employer-details/' . $post['user_id'] . '?page=freelancer_post'); ?>"><?php echo ucwords($firstname); ?>&nbsp;<?php echo ucwords($lastname); ?>
                                                                                    </a> 
                                                                                    <?php if ($cityname || $countryname) { ?>
                                                                                        <div class="fr lction display_inline">

                                                                                            <p title="Location"><i class="fa fa-map-marker" aria-hidden="true"> </i><?php if ($cityname) { ?>
                                                                                                    <?php echo $cityname . ","; ?>
                                                                                                <?php } ?>
                                                                                                <?php echo $countryname; ?></p>
                                                                                        </div>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </li>

                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="profile-job-profile-menu">
                                                                    <ul class="clearfix">
                                                                        <li> <b> Field</b> <span><?php echo $this->db->get_where('category', array('category_id' => $post['post_field_req']))->row()->category_name; ?>

                                                                            </span>
                                                                        </li>
                                                                        <li> <b> Skills</b> <span> 
                                                                                <?php
                                                                                $comma = " , ";
                                                                                $k = 0;
                                                                                $aud = $post['post_skill'];
                                                                                $aud_res = explode(',', $aud);

                                                                                if (!$post['post_skill']) {

                                                                                    echo $post['post_other_skill'];
                                                                                } else if (!$post['post_other_skill']) {
                                                                                    foreach ($aud_res as $skill) {
                                                                                        if ($k != 0) {
                                                                                            echo $comma;
                                                                                        }
                                                                                        $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;
                                                                                        echo $cache_time;
                                                                                        $k++;
                                                                                    }
                                                                                } else if ($post['post_skill'] && $post['post_other_skill']) {

                                                                                    foreach ($aud_res as $skill) {
                                                                                        if ($k != 0) {
                                                                                            echo $comma;
                                                                                        }
                                                                                        $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;
                                                                                        echo $cache_time;
                                                                                        $k++;
                                                                                    } echo "," . $post['post_other_skill'];
                                                                                }
                                                                                ?>     

                                                                            </span>
                                                                        </li>


                                                                        <!--  <?php if ($post['post_other_skill']) { ?>
                                                                                                                                                                                                                 <li><b>Other Skill</b><span><?php echo $post['post_other_skill']; ?></span>
                                                                                                                                                                                                                 </li>
                                                                        <?php } else { ?>
                                                                                                                                                                                                                 <li><b>Other Skill</b><span><?php echo "-"; ?></span></li><?php } ?> -->

                                                                        <li><b>Post Description</b><span><pre>
                                                                                    <?php
                                                                                    if ($post['post_description']) {
                                                                                        echo $this->common->make_links($post['post_description']);
                                                                                    } else {
                                                                                        echo PROFILENA;
                                                                                    }
                                                                                    ?></pre></span>
                                                                        </li>
                                                                        <li><b>Rate</b><span>
                                                                                <?php
                                                                                if ($post['post_rate']) {
                                                                                    echo $post['post_rate'];
                                                                                    echo "&nbsp";
                                                                                    echo $this->db->get_where('currency', array('currency_id' => $post['post_currency']))->row()->currency_name;
                                                                                    echo "&nbsp";
                                                                                    if ($post['post_rating_type'] == 0) {
                                                                                        echo "Hourly";
                                                                                    } else {
                                                                                        echo "Fixed";
                                                                                    }
                                                                                } else {
                                                                                    echo PROFILENA;
                                                                                }
                                                                                ?></span>
                                                                        </li>

                                                                        <li>
                                                                            <b>Required Experience</b>
                                                                            <span>
                                                                                <?php
                                                                                if ($post['post_exp_month'] || $post['post_exp_year']) {
                                                                                    if ($post['post_exp_year']) {
                                                                                        echo $post['post_exp_year'];
                                                                                    }
                                                                                    if ($post['post_exp_month']) {
                                                                                        if ($post['post_exp_year'] == '' || $post['post_exp_year'] == '0') {
                                                                                            echo 0;
                                                                                        }
                                                                                        echo ".";
                                                                                        echo $post['post_exp_month'];
                                                                                    }
                                                                                    echo " Year";
                                                                                    // echo $post['post_exp_year'].".".$post['post_exp_month'];
                                                                                } else {
                                                                                    echo PROFILENA;
                                                                                }
                                                                                ?> 
                                                                            </span>
                                                                        </li>
                                                                        <li><b>Estimated Time</b><span> <?php
                                                                                if ($post['post_est_time']) {
                                                                                    echo $post['post_est_time'];
                                                                                } else {
                                                                                    echo PROFILENA;
                                                                                }
                                                                                ?></span>
                                                                        </li>

                                                                    </ul>
                                                                </div>
                                                                <?php
                                                               // $postuser = $this->common->select_data_by_id('freelancer_post', 'post_id', $post['post_id'], $data = 'user_id', $join_str = array());
                                                                if ($postuser[0]['user_id'] != $this->session->userdata('aileenuser')) {
                                                                    ?>
                                                                    <div class="profile-job-profile-button clearfix">

                                                                        <div class="profile-job-details col-md-12">
                                                                            <ul><li class="fr">
                                                                                    <?php
                                                                                    $contition_array = array('post_id' => $post['post_id'], 'job_delete' => '0', 'user_id' => $this->session->userdata('aileenuser'));
                                                                                    $freelancerapply1 = $this->data['freelancerapply'] = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                                                    if ($freelancerapply1) {
                                                                                        ?>
                                                                                        <a href="javascript:void(0);" class="button applied">Applied</a>
                                                                                    <?php } else if ($applyuser) { ?>
                                                                                        <a href="javascript:void(0);"  class= "applypost  button"  onClick="applypopup(<?php echo $post['post_id'] ?>,<?php echo $post['user_id']; ?>)"> Apply</a>
                                                                                    <?php } else { ?> 
                                                                                        <a href="<?php echo base_url('freelance-work/profile/live-post/' . $post['post_id']); ?>"  class= "applypost  button"> Apply</a>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                    </div>
                                                                                    </div>
                                                                                <?php } ?>
                                                                                </div>
                                                                                </div>
                                                                                </div>

                                                                                <?php
                                                                            }
                                                                            ?>
                                                                            </div>
                                                                            </div>
                                                                            </div>
                                                                        <?php } else { ?>
            <div class="col-md- col-sm-12 mob-clear">
                <div class="common-form">
                    <div class="job-saved-box">
                        <h3>Freelancer</h3>
                        <div class="contact-frnd-post">
                          <div class="art-img-nn">
                         <div class="art_no_post_img">
                             <img alt="No project available" src="/assets/img/free-no.png">
                        </div>
                  <div class="art_no_post_text">   You must have a freelancer  profile for applying to this post </div>
                                            </div>
                            
                        </div>
                    </div>
                </div>
            </div><!-- 
                                                                            <div class="text-center rio">
                                                                                You must have a freelancer  profile for applying to this post
                                                                            </div> -->
                                                                        <?php } ?>
                                                                        <!-- sortlisted employe -->
                                                                        <?php if ($postuser[0]['user_id'] == $this->session->userdata('aileenuser') || $applyuser) { ?>
                                                                            <?php if ($shortlist) {
                                                                                ?>
                                                                                <div class="sort-emp-mainbox">
                                                                                    <h3>
                                                                                        Shortlisted Freelancer
                                                                                    </h3>

                                                                                    <div class="sort-emp">
                                                                                        <?php foreach ($shortlist as $user) { ?>
                                                                                            <div class="sort-emp-box">
                                                                                                <div class="sort-emp-img">
                                                                                                    <?php
                                                                                                    $fname = $user['freelancer_post_fullname'];
                                                                                                    $lname = $user['freelancer_post_username'];
                                                                                                    $sub_fname = substr($fname, 0, 1);
                                                                                                    $sub_lname = substr($lname, 0, 1);
                                                                                                    if ($user['freelancer_post_user_image']) {
                                                                                                        if (IMAGEPATHFROM == 'upload') {
                                                                                                            if (!file_exists($this->config->item('free_post_profile_main_upload_path') . $user['freelancer_post_user_image'])) {
                                                                                                                ?>
                                                                                                                <?php if ($postuser[0]['user_id'] == $this->session->userdata('aileenuser')) { ?>
                                                                                                                    <a href="<?php echo base_url('freelance-work/freelancer-details/' . $user['freelancer_apply_slug'] . '?page=freelancer_hire'); ?>">
                                                                                                                        <div class="post-img-user">
                                                                                                                            <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>
                                                                                                                        </div>
                                                                                                                    </a>
                                                                                                                <?php } else { ?>
                                                                                                                    <div class="post-img-user">
                                                                                                                        <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>
                                                                                                                    </div>
                                                                                                                <?php } ?>
                                                                                                            <?php } ?>
                                                                                                            <?php if ($postuser[0]['user_id'] == $this->session->userdata('aileenuser')) { ?>
                                                                                                                <a href="<?php echo base_url('freelance-work/freelancer-details/' . $user['freelancer_apply_slug']); ?>">
                                                                                                                    <img src="<?php echo FREE_POST_PROFILE_THUMB_UPLOAD_URL . $user['freelancer_post_user_image']; ?>" alt="<?php echo $user['freelancer_post_fullname']." ".$user['freelancer_post_username'];  ?>" > </a>
                                                                                                            <?php } else { ?>
                                                                                                                <a href="javascript: void(0);">
                                                                                                                    <img src="<?php echo FREE_POST_PROFILE_THUMB_UPLOAD_URL . $user['freelancer_post_user_image']; ?>" alt="<?php echo $user['freelancer_post_fullname']." ".$user['freelancer_post_username'];  ?>" > </a>
                                                                                                            <?php } ?>
                                                                                                            <?php
                                                                                                        } else {
                                                                                                            $filename = $this->config->item('free_post_profile_main_upload_path') . $user['freelancer_post_user_image'];
                                                                                                            $s3 = new S3(awsAccessKey, awsSecretKey);
                                                                                                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                                                                            if ($info) {
                                                                                                                ?>
                                                                                                                <?php if ($postuser[0]['user_id'] == $this->session->userdata('aileenuser')) { ?>
                                                                                                                    <a href="<?php echo base_url('freelance-work/freelancer-details/' . $user['freelancer_apply_slug']); ?>">
                                                                                                                        <img src="<?php echo FREE_POST_PROFILE_THUMB_UPLOAD_URL . $user['freelancer_post_user_image']; ?>" alt="<?php echo $user['freelancer_post_fullname']." ".$user['freelancer_post_username'];  ?>" > </a>
                                                                                                                <?php } else { ?>
                                                                                                                    <a href="javascript:void(0);">
                                                                                                                        <img src="<?php echo FREE_POST_PROFILE_THUMB_UPLOAD_URL . $user['freelancer_post_user_image']; ?>" alt="<?php echo $user['freelancer_post_fullname']." ".$user['freelancer_post_username'];  ?>" > </a>
                                                                                                                <?php } ?>
                                                                                                            <?php } else { ?>
                                                                                                                <?php if ($postuser[0]['user_id'] == $this->session->userdata('aileenuser')) { ?>
                                                                                                                    <a href="<?php echo base_url('freelance-work/freelancer-details/' . $user['freelancer_apply_slug']); ?>" >
                                                                                                                        <div class="post-img-user">
                                                                                                                            <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>

                                                                                                                        </div>
                                                                                                                    </a>
                                                                                                                <?php } else { ?>
                                                                                                                    <div class="post-img-user">
                                                                                                                        <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>

                                                                                                                    </div>
                                                                                                                <?php } ?>
                                                                                                                <?php
                                                                                                            }
                                                                                                        }
                                                                                                    } else {
                                                                                                        ?>
                                                                                                        <?php if ($postuser[0]['user_id'] == $this->session->userdata('aileenuser')) { ?>
                                                                                                            <a href="<?php echo base_url('freelance-work/freelancer-details/' . $user['user_id'] . '?page=freelancer_hire'); ?>">
                                                                                                                <div class="post-img-user">
                                                                                                                    <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?> 
                                                                                                                </div>
                                                                                                            </a>
                                                                                                        <?php } else { ?>
                                                                                                            <div class="post-img-user">
                                                                                                                <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?> 
                                                                                                            </div>
                                                                                                        <?php } ?>
                                                                                                    <?php } ?>
            <!--<img src="https://aileensoulimages.s3.amazonaws.com/uploads/business_profile/thumbs/1505729142.png">-->
                                                                                                </div>
                                                                                                <div class="sort-emp-detail">
                                                                                                    <h4>
                                                                                                        <?php if ($postuser[0]['user_id'] == $this->session->userdata('aileenuser')) { ?>
                                                                                                            <a href="<?php echo base_url('freelance-work/freelancer-details/' . $user['user_id'] . '?page=freelancer_hire'); ?>"><?php echo $user['freelancer_post_fullname'] . " " . $user['freelancer_post_username']; ?></a>
                                                                                                        <?php } else { ?>
                                                                                                            <a href="javascript:void(0);"><?php echo $user['freelancer_post_fullname'] . " " . $user['freelancer_post_username']; ?></a>
                                                                                                        <?php } ?>
                                                                                                    </h4>
                                                                                                    <p><?php
                                                                                                        if ($user['designation']) {
                                                                                                            echo $user['designation'];
                                                                                                        } else {
                                                                                                            echo "Designation";
                                                                                                        }
                                                                                                        ?></p>
                                                                                                </div>
                                                                                                <div class="sort-emp-msg">
                                                                                                    <?php
                                                                                                    $login_id = $this->session->userdata('aileenuser');
                                                                                                    $user_data = $this->common->select_data_by_id('freelancer_hire_reg', 'user_id', $login_id, $data = 'user_id', $join_str = array());
                                                                                                    if ($postuser[0]['user_id'] == $this->session->userdata('aileenuser')) {
                                                                                                        ?>
                                                                                                        <a class="btn1" href = "<?php echo base_url('chat/abc/3/4/' . $user['user_id']); ?>">
                                                                                                            Message
                                                                                                        </a>
                                                                                                    <?php } ?>
                                                                                                    <!--                                                                                                <a href="#" class="btn1">Message</a>-->
                                                                                                </div>
                                                                                            </div>
                                                                                        <?php } ?>
                                                                                    </div>
                                                                                <?php } ?>
                                                                            </div>
                                                                        <?php } ?> 
                                                                        <!-- end sortlisted employe -->
                                                                        </div>
                                                                        </div>


                                                                        <div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig"> 

                                                                           

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

                                                                                                <div class="fw" id="profi_loader"  style="display:none;" style="text-align:center;" ><img alt="loader" src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" /></div>
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
                                                                        <!--PROFILE PIC MODEL END-->
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
                                                                        <!-- START FOOTER -->
                                                                        <?php echo $footer; ?>
                                                                        </body>

                                                                        <!-- END FOOTER -->
                        
                                                                            
                                                                            <?php if (IS_HIRE_JS_MINIFY == '0') { ?>

                                                                        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
                                                                        <!-- FIELD VALIDATION JS START -->
                                                                        <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/project_live.js?ver=' . time()); ?>"></script>
                                                                        <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/freelancer_hire_common.js?ver=' . time()); ?>"></script>
                                                                            <script src="<?php echo base_url('assets/js/croppie.js'); ?>"></script>  
                                                                            <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
                                                                            <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
                 
            <?php } else {  ?>

                                                                        <script src="<?php echo base_url('assets/js_min/bootstrap.min.js'); ?>"></script>
                                                                        <!-- FIELD VALIDATION JS START -->
                                                                        <script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-hire/project_live.js?ver=' . time()); ?>"></script>
                                                                        <script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-hire/freelancer_hire_common.js?ver=' . time()); ?>"></script>
                                                                            <script src="<?php echo base_url('assets/js_min/croppie.js'); ?>"></script>  
                                                                            <script src="<?php echo base_url('assets/js_min/bootstrap.min.js'); ?>"></script>
                                                                            <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()); ?>"></script>
                 
        <?php } ?>

                                                                        <script>
                                                                                    var base_url = '<?php echo base_url(); ?>';
                                                                                    var data1 = <?php echo json_encode($de); ?>;
                                                                                    var data = <?php echo json_encode($demo); ?>;
                                                                                    var get_csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
                                                                                    var get_csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
                                                                                    var id = '<?php echo $this->uri->segment(3); ?>';
                                                                                    var return_page = '<?php echo $_GET['page']; ?>';



                                                                                    function removepopup(id) {

                                                                                        $('.biderror .mes').html("<div class='pop_content'>Do you want to remove this project?<div class='model_ok_cancel'><a class='okbtn' id=" + id + " onClick='remove_post(" + id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                                                                                        $('#bidmodal').modal('show');
                                                                                    }

                                                                                    //remove post start

                                                                                    function remove_post(abc)
                                                                                    {

                                                                                        $.ajax({
                                                                                            type: 'POST',
                                                                                            url: '<?php echo base_url() . "freelancer/remove_post" ?>',
                                                                                            data: 'post_id=' + abc,
                                                                                            success: function (data) {
                                                                                                $('#' + 'removeapply' + abc).html(data);
                                                                                                $('#' + 'removeapply' + abc).parent().removeClass();

                                                                                                var numItems = $('.contact-frnd-post .job-contact-frnd').length;
                                                                                                if (numItems == '0') {
                                                                                                    // var nodataHtml = "<div class='text-center rio'><h4 class='page-heading  product-listing' style='border:0px;margin-bottom: 11px;'>No Project Found.</h4></div>";
                                                                                                    var nodataHtml = '<div class="art-img-nn"><div class="art_no_post_img"><img alt="No Project" src="../img/free-no1.png"></div><div class="art_no_post_text">No Project Found</div></div>';
                                                                                                    $('.contact-frnd-post').html(nodataHtml);

                                                                                                }


                                                                                            }
                                                                                        });

                                                                                    }
                                                                        </script>

                                                                        </html>    