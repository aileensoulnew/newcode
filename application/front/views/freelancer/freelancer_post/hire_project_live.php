<!DOCTYPE html>
<html>
    <head>
        <!-- start head -->
        <?php echo $head; ?>
        <!-- END HEAD -->

        <title><?php echo $title; ?></title>
        <?php
        if (IS_APPLY_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/freelancer-hire.css?ver=' . time()); ?>">

            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/freelancer-hire.css?ver=' . time()); ?>">

        <?php } ?>


    </head>
    <!-- END HEAD -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css'); ?>">
    <body class="page-container-bg-solid page-boxed no-login freeh3">

        <header>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-3 left-header text-center fw-479">
                     <div class="logo">  <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png?ver=' . time()) ?>" alt="logo"></a></div>
                    </div>
                    <div class="col-md-8 col-sm-9 right-header fw-479 text-center">
                        <div class="btn-right pull-right">
                            <a href="javascript:void(0);" onclick="login_profile();" class="btn2">Login</a>
                            <a href="javascript:void(0);" onclick="register_profile();" class="btn3">Create an account</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <section>
            <div class="user-midd-section" id="paddingtop_fixed">
                <div class="container padding-360">
                    <div class="row4">

                        <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt"><div class="">

                                <div class="full-box-module">   
                                    <div class="profile-boxProfileCard  module">
                                        <div class="profile-boxProfileCard-cover"> 
                                            <a class="profile-boxProfileCard-bg u-bgUserColor a-block" href="javascript:void(0);" onclick="register_profile();" tabindex="-1" 
                                               aria-hidden="true" rel="noopener">
                                                <div class="bg-images no-cover-upload"> 
                                                    <?php
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

                                                <a class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock"  href="javascript:void(0);" onclick="register_profile();" title="<?php echo $freelancr_user_data[0]['rec_firstname'] . ' ' . $freelancr_user_data[0]['rec_lastname']; ?>" tabindex="-1" aria-hidden="true" rel="noopener">
                                                    <?php
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
                                                    <a href="javascript:void(0);" onclick="register_profile();" title="<?php echo ucfirst(strtolower($freelancr_user_data['fullname'])) . ' ' . ucfirst(strtolower($freelancr_user_data['username'])); ?>">   <?php echo ucfirst(strtolower($freelancr_user_data[0]['fullname'])) . ' ' . ucfirst(strtolower($freelancr_user_data[0]['username'])); ?></a>
                                                </span>


                                                <div class="profile-boxProfile-name">
                                                    <a href="javascript:void(0);" onclick="register_profile();" title="<?php echo ucfirst(strtolower($freelancr_user_data[0]['designation'])); ?>">
                                                        <?php
                                                        if (ucfirst(strtolower($freelancr_user_data[0]['designation']))) {
                                                            echo ucfirst(strtolower($freelancr_user_data[0]['designation']));
                                                        } else {
                                                            echo "Designation";
                                                        }
                                                        ?></a>
                                                </div>
                                                <ul class=" left_box_menubar">
                                                    <li <?php if ($this->uri->segment(1) == 'freelance-hire' && $this->uri->segment(2) == 'employer-details') { ?> class="active" <?php } ?>><a class="padding_less_left" title="Details" href="javascript:void(0);" onclick="register_profile();"> <?php echo $this->lang->line("details"); ?></a>
                                                    </li>                                
                                                    <li id="rec_post_home" <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'post') { ?> class="active" <?php } ?>><a title="Projects" href="javascript:void(0);" onclick="register_profile();"><?php echo $this->lang->line("Projects"); ?></a>
                                                    </li>
                                                    <li <?php if ($this->uri->segment(1) == 'freelance-hire' && $this->uri->segment(2) == 'freelancer-save') { ?> class="active" <?php } ?>><a title="Saved Freelancer" class="padding_less_right" href="javascript:void(0);" onclick="register_profile();">Saved</a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>      
                                </div>

                                <div id="hideuserlist" class=" fixed_right_display animated fadeInRightBig"> 



                                </div>
                                <?php echo $left_footer; ?>
                            </div>

                        </div>
                        <?php

                        function text2link($text) {
                            $text = preg_replace('/(((f|ht){1}t(p|ps){1}:\/\/)[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '<a href="\\1" target="_blank" rel="nofollow">\\1</a>', $text);
                            $text = preg_replace('/([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '\\1<a href="http://\\2" target="_blank" rel="nofollow">\\2</a>', $text);
                            $text = preg_replace('/([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})/i', '<a href="mailto:\\1" rel="nofollow" target="_blank">\\1</a>', $text);
                            return $text;
                        }
                        ?>      



                        <?php
                        if (count($postdata) > 0) {
                            foreach ($postdata as $post) {
                                ?>
                                <div class="inner-right-part">
                                    <div class="page-title">
                                        <h3>
                                            <?php
                                            echo $postdata[0]['post_name'];
                                            ?>
                                        </h3>
                                    </div>
                                    <div class="all-job-box job-detail">
                                        <div class="all-job-top">
                                            <div class="job-top-detail">
                                                <h5><a href="javascript:void(0);" onclick="register_profile();"><?php echo $post['post_name']; ?></a></h5>

                                                <?php
                                                $firstname = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->fullname;
                                                $lastname = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->username;
                                                ?>
                                                <p>
                                                    <a href="javascript:void(0);" onclick="register_profile();"><?php echo ucfirst(strtolower($firstname)) . ' ' . ucfirst(strtolower($lastname)); ?></a></a></p>
                                                <p class="loca-exp">
                                                    <span class="location">
                                                        <?php $city = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->city; ?>
                                                        <?php $country = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->country; ?>

                                                        <?php
                                                        $cityname = $this->db->get_where('cities', array('city_id' => $city))->row()->city_name;
                                                        $countryname = $this->db->get_where('countries', array('country_id' => $country))->row()->country_name;
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
                                                                echo " Year" . " (Required Experience)";
                                                            }
                                                            ?> 
                                                        </span>
                                                    </span>
                                                </p>
                                                <p class="pull-right job-top-btn">
                                                    <a href="javascript:void(0);" onClick="create_profile_apply(<?php echo $post['post_id']; ?>)" class= "applypost  btn4"> Apply</a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="detail-discription">
                                            <div class="all-job-middle">
                                                <ul>
                                                    <li>
                                                        <b>Project description</b>
                                                        <span>
                                                            <pre><?php echo $this->common->make_links($post['post_description']); ?></pre>
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <b>Key skill</b>
                                                        <span>  <?php
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
                                                    <li><b>Field of Requirements</b>
                                                        <span> 
                                                            <?php echo $this->db->get_where('category', array('category_id' => $post['post_field_req']))->row()->category_name; ?>
                                                        </span>
                                                    </li>
                                                    <li><b>Rate</b>
                                                        <span>  <?php
                                                            if ($post['post_rate']) {
                                                                echo $post['post_rate'];
                                                                echo "&nbsp";
                                                                echo $this->db->get_where('currency', array('currency_id' => $post['post_currency']))->row()->currency_name;
                                                                echo "&nbsp";
                                                                if ($post['post_rating_type'] == '0') {
                                                                    echo "Hourly";
                                                                } else if ($post['post_rating_type'] == '1') {
                                                                    echo "Fixed";
                                                                }
                                                            } else {
                                                                echo PROFILENA;
                                                            }
                                                            ?>
                                                        </span>
                                                    </li>

                                                    <li><b>Estimated Time</b>
                                                        <span>
                                                            <?php
                                                            if ($post['post_est_time']) {
                                                                echo $post['post_est_time'];
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
                                                <p class="pull-right">
                                                    <a href="javascript:void(0);" onClick="create_profile_apply(<?php echo $post['post_id']; ?>)" class= "applypost btn4"> Apply</a>
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- sortlisted employe -->

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
                                                                        <div class="post-img-user">
                                                                            <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <img src="<?php echo FREE_POST_PROFILE_THUMB_UPLOAD_URL . $user['freelancer_post_user_image']; ?>" alt="<?php echo $user['freelancer_post_fullname'] . " " . $user['freelancer_post_username']; ?>" >
                                                                    <?php
                                                                } else {
                                                                    $filename = $this->config->item('free_post_profile_main_upload_path') . $user['freelancer_post_user_image'];
                                                                    $s3 = new S3(awsAccessKey, awsSecretKey);
                                                                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                                    if ($info) {
                                                                        ?>
                                                                        <img src="<?php echo FREE_POST_PROFILE_THUMB_UPLOAD_URL . $user['freelancer_post_user_image']; ?>" alt="<?php echo $user['freelancer_post_fullname'] . " " . $user['freelancer_post_username']; ?>" >
                                                                    <?php } else { ?>
                                                                        <div class="post-img-user">
                                                                            <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                }
                                                            } else {
                                                                ?>
                                                                <div class="post-img-user">
                                                                    <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="sort-emp-detail">
                                                            <div><a><?php echo $user['freelancer_post_fullname'] . " " . $user['freelancer_post_username']; ?></a></div>
                                                            <p><?php
                                                                if ($user['designation']) {
                                                                    echo $user['designation'];
                                                                } else {
                                                                    echo "Designation";
                                                                }
                                                                ?></p>
                                                        </div>
                                                        <!--                                                        <div class="sort-emp-msg">
                                                                                                                    <a href="javascript:void(0);" class="">Message</a>
                                                                                                                </div>-->
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- end sortlisted employe -->

                                <?php
                            }
                        } else {
                            ?>
                            <div class="inner-right-part cust-border">
                                <div class="art-img-nn">
                                    <div class="art_no_post_img">
                                        <img alt="No Projects" src="<?php echo base_url() . 'assets/img/job-no.png' ?>">

                                    </div>
                                    <div class="art_no_post_text">
                                        No  Projects Available.
                                    </div>
                                </div>
                            </div>
                        <?php } ?>





                        <!--recommen candidate start-->
                        <?php if (count($recommandedpost) > 0) { ?>
                            <div class="inner-right-part">
                                <div class="page-title">
                                    <h3>
                                        Recommended Project
                                    </h3>
                                </div>

                                <?php
                                foreach ($recommandedpost as $post) {
                                    ?>
                                    <div class="all-job-box job-detail">
                                        <div class="all-job-top">
                                            <div class="job-top-detail">
                                                <h5><a href="javascript:void(0);" onclick="register_profile();"><?php echo $post['post_name']; ?></a></h5>

                                                <?php
                                                $firstname = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->fullname;
                                                $lastname = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->username;
                                                ?>
                                                <p>
                                                    <a href="javascript:void(0);" onclick="register_profile();"><?php echo ucfirst(strtolower($firstname)) . ' ' . ucfirst(strtolower($lastname)); ?></a>

                                                </p>
                                                <p class="loca-exp">
                                                    <span class="location">
                                                        <?php $city = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->city; ?>
                                                        <?php $country = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->country; ?>

                                                        <?php
                                                        $cityname = $this->db->get_where('cities', array('city_id' => $city))->row()->city_name;
                                                        $countryname = $this->db->get_where('countries', array('country_id' => $country))->row()->country_name;
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
                                                                echo " Year" . " (Required Experience)";
                                                            }
                                                            ?> 
                                                        </span>
                                                    </span>
                                                </p>
                                                <p class="pull-right job-top-btn">
                                                    <a href="javascript:void(0);" onClick="create_profile_apply(<?php echo $post['post_id']; ?>)" class= "applypost  btn4"> Apply</a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="detail-discription">
                                            <div class="all-job-middle">
                                                <ul>
                                                    <li>
                                                        <b>Project description</b>
                                                        <span>
                                                            <pre><?php echo $this->common->make_links($post['post_description']); ?></pre>
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <b>Key skill</b>
                                                        <span>  <?php
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
                                                    <li><b>Field of Requirements</b>
                                                        <span> 
                                                            <?php echo $this->db->get_where('category', array('category_id' => $post['post_field_req']))->row()->category_name; ?>
                                                        </span>
                                                    </li>
                                                    <li><b>Rate</b>
                                                        <span>  <?php
                                                            if ($post['post_rate']) {
                                                                echo $post['post_rate'];
                                                                echo "&nbsp";
                                                                echo $this->db->get_where('currency', array('currency_id' => $post['post_currency']))->row()->currency_name;
                                                                echo "&nbsp";

                                                                if ($post['post_rating_type'] == '0') {
                                                                    echo "Hourly";
                                                                } else if ($post['post_rating_type'] == '1') {
                                                                    echo "Fixed";
                                                                }
                                                            } else {
                                                                echo PROFILENA;
                                                            }
                                                            ?>
                                                        </span>
                                                    </li>

                                                    <li><b>Estimated Time</b>
                                                        <span>
                                                            <?php
                                                            if ($post['post_est_time']) {
                                                                echo $post['post_est_time'];
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
                                                <p class="pull-right">
                                                    <a href="javascript:void(0);" onClick="create_profile_apply(<?php echo $post['post_id']; ?>)" class= "applypost  button"> Apply</a>
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                <?php }
                                ?>

                            </div>

                        <?php } ?>

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
        <?php //echo $footer;     ?>
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
                                        <h1 class="ttc tlh2">Welcome To Aileensoul</h1>
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
                    <div class="modal-body">
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
                                <div class="title"><h1 class="tlh1">Sign up First and Register in Freelancer Profile</h1></div>
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
                                            <span><select tabindex="105" class="day" name="selday" id="selday">
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
                                                    //<?php
//                  for($i = 1; $i <= 12; $i++){
//                  
                                                    ?>
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
                                                    //<?php
//                  }
//                  
                                                    ?>
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
                                            <span> <select tabindex="108" class="gender"  onchange="changeMe(this)" name="selgen" id="selgen">
                                                    <option value="" disabled selected value>Gender</option>
                                                    <option value="M">Male</option>
                                                    <option value="F">Female</option>
                                                </select>
                                            </span>
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
                            <div class=" ">
                                <div class="title"><h1 class="tlh1">Sign up First and Register in Freelancer Profile</h1></div>
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
                                            <select tabindex="105" class="day" name="selday" id="selday">
                                                <option value="" disabled selected value>Day</option>
                                                <?php
                                                for ($i = 1; $i <= 31; $i++) {
                                                    ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <select tabindex="106" class="month" name="selmonth" id="selmonth">
                                                <option value="" disabled selected value>Month</option>
                                                //<?php
//                  for($i = 1; $i <= 12; $i++){
//                  
                                                ?>
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
                                                //<?php
//                  }
//                  
                                                ?>
                                            </select>
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

                                        </div>
                                        <div class="dateerror" style="color:#f00; display: block;"></div>

                                        <div class="form-group gender-custom">
                                            <select tabindex="108" class="gender"  onchange="changeMe(this)" name="selgen" id="selgen">
                                                <option value="" disabled selected value>Gender</option>
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                            </select>
                                        </div>

                                        <p class="form-text" style="margin-bottom: 10px;">
                                            By Clicking on create an account button you agree our
                                            <a tabindex="109" href="<?php echo base_url('terms-and-condition'); ?>">Terms and Condition</a> and <a tabindex="110" href="<?php echo base_url('privacy-policy'); ?>">Privacy policy</a>.
                                        </p>
                                        <p>
                                            <button tabindex="111" class="btn1">Create an account</button>
                                        </p>
                                        <div class="sign_in pt10">
                                            <p>
                                                Already have an account ? <a tabindex="112" onClick="login_profile();" href="javascript:void(0);"> Log In </a>
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

        </script>
        <?php
        if (IS_APPLY_JS_MINIFY == '0') {
            ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/project_live_login.js?ver=' . time()); ?>"></script>
            <?php
        } else {
            ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-hire/project_live_login.js?ver=' . time()); ?>"></script>
        <?php } ?>



        <script>

        </script>
    </body>
</html>