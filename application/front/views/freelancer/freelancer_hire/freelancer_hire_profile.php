<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>
        <?php if (IS_HIRE_CSS_MINIFY == '0') { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/freelancer-hire.css?ver=' . time()); ?>">
        <?php } else { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/freelancer-hire.css?ver=' . time()); ?>">
        <?php } ?>
        <?php if (!$this->session->userdata('aileenuser')) { ?>
         <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css'); ?>">
        <?php } ?>
    </head>
    <?php if (!$this->session->userdata('aileenuser')) { ?>
     <body class="page-container-bg-solid page-boxed pushmenu-push botton_footer no-login">
    <?php } ?>
    <body class="page-container-bg-solid page-boxed pushmenu-push botton_footer">

        <?php
        if ($this->session->userdata('aileenuser')) {
            echo $header;
        } else {
            ?>
            <header>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-3 left-header text-center fw-479">
                       <div class="logo">  <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png?ver=' . time()) ?>" alt="logo"></a></div>
                        </div>
                        <div class="col-md-8 col-sm-9 right-header fw-479 text-center">
                            <div class="btn-right pull-right">
                                <a title="Login" href="javascript:void(0);" onclick="login_profile();" class="btn2">Login</a>
                                <a title="Create an account" href="javascript:void(0);" onclick="create_profile();" class="btn3">Create an account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        <?php }
        ?>
        <?php
        if ($this->session->userdata('aileenuser')) {
            if ($freelancerhiredata[0]['user_id'] != $this->session->userdata('aileenuser')) {
                echo $freelancer_post_header2_border;
            } else {
                echo $freelancer_hire_header2_border;
            }
        }
        ?>
        <section class="custom-row">
            <div class="container" id="paddingtop_fixed">
                <div class="row" id="row1" style="display:none;">
                    <div class="col-md-12 text-center">
                        <div id="upload-demo" ></div>
                    </div>
                    <div class="col-md-12 cover-pic" >
                        <button class="btn btn-success  cancel-result" onclick="" ><?php echo $this->lang->line("cancel"); ?></button>
                        <button class="btn btn-success set-btn upload-result "><?php echo $this->lang->line("save"); ?></button>
                        <div id="message1" style="display:none;">
                            <div id="floatBarsG">
                                <div id="floatBarsG_1" class="floatBarsG"></div>
                                <div id="floatBarsG_2" class="floatBarsG"></div>
                                <div id="floatBarsG_3" class="floatBarsG"></div>
                                <div id="floatBarsG_4" class="floatBarsG"></div>
                                <div id="floatBarsG_5" class="floatBarsG"></div>
                                <div id="floatBarsG_6" class="floatBarsG"></div>
                                <div id="floatBarsG_7" class="floatBarsG"></div>
                                <div id="floatBarsG_8" class="floatBarsG"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12"  style="visibility: hidden; ">
                        <div id="upload-demo-i" ></div>
                    </div>
                </div>
                <div class="">
                    <div class="" id="row2">
                        <?php
                        $userid = $this->session->userdata('aileenuser');
                        if ($this->uri->segment(3) == $userid) {
                            $user_id = $userid;
                        } elseif ($this->uri->segment(3) == "") {
                            $user_id = $userid;
                        } else {
                            $user_id = $this->uri->segment(3);
                        }
                        $contition_array = array('user_id' => $user_id, 'is_delete' => '0', 'status' => '1');
                        $image = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'profile_background', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                        $image_ori = $image[0]['profile_background'];
                        if ($image_ori) {
                            if (IMAGEPATHFROM == 'upload') {
                                if (!file_exists($this->config->item('free_hire_bg_main_upload_path') . $freelancerhiredata[0]['freelancer_hire_user_image'])) {
                                    ?>
                                    <img alt="No Image" src="<?php echo base_url(WHITEIMAGE); ?>" name="image_src" id="image_src" />
                                <?php } else { ?>
                                    <img alt="<?php echo $freelancerhiredata[0]['fullname'] . " " . $freelancerhiredata[0]['username']; ?>" src="<?php echo FREE_HIRE_BG_MAIN_UPLOAD_URL . $image[0]['profile_background']; ?>" name="image_src" id="image_src" / >
                                    <?php
                                }
                            } else {
                                $filename = $this->config->item('free_hire_profile_main_upload_path') . $freelancerhiredata[0]['freelancer_hire_user_image'];
                                $s3 = new S3(awsAccessKey, awsSecretKey);
                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                if ($info) {
                                    ?>
                                         <img alt="<?php echo $freelancerhiredata[0]['fullname'] . " " . $freelancerhiredata[0]['username']; ?>" src="<?php echo FREE_HIRE_BG_MAIN_UPLOAD_URL . $image[0]['profile_background']; ?>" name="image_src" id="image_src" / >
                                     <?php } else { ?>
                                         <img alt="No Image" src="<?php echo base_url(WHITEIMAGE); ?>" name="image_src" id="image_src" />

                                    <?php
                                }
                            }
                        } else {
                            ?>
                            <div class="bg-images no-cover-upload">
                                <img alt="No Image" src="<?php echo base_url(WHITEIMAGE); ?>" name="image_src" id="image_src" />
                            </div>
                        <?php }
                        ?>
                    </div>
                </div>
            </div>
            <div class="container tablate-container  art-profile">    

                <?php if ($freelancerhiredata[0]['user_id'] == $this->session->userdata('aileenuser')) { ?>
                    <div class="upload-img">
                        <label class="cameraButton"><span class="tooltiptext"><?php echo $this->lang->line("upload_cover_photo"); ?></span><i class="fa fa-camera" aria-hidden="true"></i>
                            <input type="file" id="upload" name="upload" accept="image/*;capture=camera" onclick="showDiv()">
                        </label>
                    </div>
                <?php } ?>



                <div class="profile-photo">
                    <div class="profile-pho">
                        <div class="user-pic padd_img">
                            <?php
                            $fname = $freelancerhiredata[0]['fullname'];
                            $lname = $freelancerhiredata[0]['username'];
                            $sub_fname = substr($fname, 0, 1);
                            $sub_lname = substr($lname, 0, 1);
                            if ($freelancerhiredata[0]['freelancer_hire_user_image']) {
                                if (IMAGEPATHFROM == 'upload') {
                                    if (!file_exists($this->config->item('free_hire_profile_main_upload_path') . $freelancerhiredata[0]['freelancer_hire_user_image'])) {
                                        ?>
                                        <div class="post-img-user">
                                            <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>
                                        </div>
                                    <?php } else { ?>
                                        <img src="<?php echo FREE_HIRE_PROFILE_MAIN_UPLOAD_URL . $freelancerhiredata[0]['freelancer_hire_user_image']; ?>" alt="<?php echo $freelancerhiredata[0]['fullname'] . " " . $freelancerhiredata[0]['username']; ?>" >
                                        <?php
                                    }
                                } else {
                                    $filename = $this->config->item('free_hire_profile_main_upload_path') . $freelancerhiredata[0]['freelancer_hire_user_image'];
                                    $s3 = new S3(awsAccessKey, awsSecretKey);
                                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                    if ($info) {
                                        ?>
                                        <img src="<?php echo FREE_HIRE_PROFILE_MAIN_UPLOAD_URL . $freelancerhiredata[0]['freelancer_hire_user_image']; ?>" alt="<?php echo $freelancerhiredata[0]['fullname'] . " " . $freelancerhiredata[0]['username']; ?>" >
                                    <?php } else {
                                        ?>
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
                            <?php if ($freelancerhiredata[0]['user_id'] == $this->session->userdata('aileenuser')) { ?>
                                <a title="Update Profile Picture" href="javascript:void(0);"  class="cusome_upload" onclick="updateprofilepopup();"><img alt="Update Profile Picture"  src="<?php echo base_url('assets/img/cam.png'); ?>"><?php echo $this->lang->line("update_profile_picture"); ?></a>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="job-menu-profile mob-block">
                        <a title="<?php echo ucwords($freelancerhiredata[0]['fullname']) . ' ' . ucwords($freelancerhiredata[0]['username']); ?>" href="javascript:void(0);">
                            <h3> <?php echo ucwords($freelancerhiredata[0]['fullname']) . ' ' . ucwords($freelancerhiredata[0]['username']); ?></h3>
                        </a>
                        <div class="profile-text">

                            <?php
                            if ($freelancerhiredata[0]['user_id'] == $this->session->userdata('aileenuser')) {
                                if ($freelancerhiredata[0]['designation'] == '') {
                                    ?>
                                    <a title="<?php echo $this->lang->line("designation"); ?>" id="designation" href="javascript:void(0);" class="designation" title="Designation"><?php echo $this->lang->line("designation"); ?></a>

                                <?php } else { ?> 
                                    <a id="designation" href="javascript:void(0);" class="designation" title="<?php echo ucwords($freelancerhiredata[0]['designation']); ?>"><?php echo ucwords($freelancerhiredata[0]['designation']); ?></a>
                                    <?php
                                }
                            } else {
                                if ($freelancerhiredata[0]['designation'] == '') {
                                    ?>
                                    <?php echo $this->lang->line("designation"); ?>
                                <?php } else {
                                    ?>
                                    <a id="designation" style="cursor: default;" class="designation" title="<?php echo ucwords($freelancerhiredata[0]['designation']); ?>"><?php echo ucwords($freelancerhiredata[0]['designation']); ?></a>
                                    <?php
                                }
                            }
                            ?>
                        </div>

                    </div>

                    <div class="profile-main-rec-box-menu profile-box-art col-md-12 padding_les">
                        <div class=" right-side-menu art-side-menu padding_less_right  right-menu-jr">  
                            <?php
                            $userid = $this->session->userdata('aileenuser');
                            if(is_numeric($this->uri->segment(3))){
                                $slug= $this->db->select('freelancer_hire_slug')->get_where('freelancer_hire_reg', array('user_id' => $this->uri->segment(3)))->row()->freelancer_hire_slug;
                            }else{
                                $slug= $this->uri->segment(3);
                            }
                            if ($freelancerhiredata[0]['user_id'] == $userid) {
                                ?>     
                                <ul class="current-user pro-fw">

                                <?php } else { ?>
                                    <ul class="pro-fw4">
                                    <?php } ?>  
                                    <li <?php if (($this->uri->segment(1) == 'freelance-hire') && ($this->uri->segment(2) == 'employer-details')) { ?> class="active" <?php } ?>>
                                        <?php if ($freelancerhiredata[0]['user_id'] != $this->session->userdata('aileenuser')) { ?><a title="Employer Details" href="<?php echo base_url('freelance-hire/employer-details/' . $slug); ?>"><?php echo $this->lang->line("employer_details"); ?></a> <?php } else { ?> <a title="Employer Details" href="<?php echo base_url('freelance-hire/employer-details'); ?>"><?php echo $this->lang->line("employer_details"); ?></a> <?php } ?>
                                    </li>
                                    <li <?php if (($this->uri->segment(1) == 'freelance-hire') && ($this->uri->segment(2) == 'freelancer-save')) { ?> class="active" <?php } ?>> 
                                        <?php if($this->session->userdata('aileenuser')){ ?>
                                        <?php if ($freelancerhiredata[0]['user_id'] != $this->session->userdata('aileenuser')) { ?><a title="Projects"  href="<?php echo base_url('freelance-hire/projects/' . $slug); ?>"><?php echo $this->lang->line("Projects"); ?></a><?php } else { ?><a title="Projects" href="<?php echo base_url('freelance-hire/projects'); ?>"><?php echo $this->lang->line("Projects"); ?></a><?php } ?>
                                        <?php }else{ ?>
                                        <a title="Projects"  href="javascript:void(0);"><?php echo $this->lang->line("Projects"); ?></a>
                                        <?php } ?>
                                    </li>
                                    <?php
                                    if (($this->uri->segment(1) == 'freelance-hire') && ($this->uri->segment(2) == 'projects' || $this->uri->segment(2) == 'employer-details' || $this->uri->segment(2) == 'add-projects' || $this->uri->segment(2) == 'freelancer-save') && ($this->uri->segment(3) == $this->session->userdata('aileenuser') || $this->uri->segment(3) == '')) {
                                        ?>
                                        <li <?php if (($this->uri->segment(1) == 'freelance-hire') && ($this->uri->segment(2) == 'freelancer-save')) { ?> class="active" <?php } ?>><a title="Saved Freelancer" href="<?php echo base_url('freelance-hire/freelancer-save'); ?>"><?php echo $this->lang->line("saved_freelancer"); ?></a>
                                        </li>
                                    <?php } ?>
                                </ul>                          
                                <?php
                                $userid = $this->session->userdata('aileenuser');
                                if ($userid != $this->uri->segment(3)) {
                                    if ($this->uri->segment(3) != "") {
                                        if (is_numeric($this->uri->segment(3))) {
                                            $id = $this->uri->segment(3);
                                        } else {
                                            $id = $this->db->get_where('freelancer_hire_reg', array('freelancer_hire_slug' => $this->uri->segment(3), 'status' => '1'))->row()->user_id;
                                        }
                                        ?>
                                        <div class="flw_msg_btn fr">
                                            <ul> <li>
                                                    <?php
                                                    if($this->session->userdata('aileenuser')){
                                                    if ($freelancerhiredata[0]['user_id'] != $this->session->userdata('aileenuser')) {
                                                        ?>
                                                        <a title="Message" href="<?php echo base_url('chat/abc/4/3/' . $id); ?>"><?php echo $this->lang->line("message"); ?></a>
                                                    <?php } else { ?>
                                                        <a title="Message" href="<?php echo base_url('chat/abc/3/4/' . $id); ?>"><?php echo $this->lang->line("message"); ?></a>
                                                    <?php }
                                                    }
                                                    ?>
                                                </li>
                                            </ul>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>


                <?php if ($freelancerhiredata[0]['user_id'] == $this->session->userdata('aileenuser')) { ?>
                    <div  class="add-post-button mob-block">
                        <a title="Post Projects" class="btn btn-3 btn-3b" href="<?php echo base_url('freelance-hire/add-projects'); ?>"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo $this->lang->line("post_project"); ?></a>

                    </div>
                <?php } ?>
                <div class="middle-part">          
                    <div class="job-menu-profile mob-none pt20">
                        <a title="<?php echo ucwords($freelancerhiredata[0]['fullname']) . ' ' . ucwords($freelancerhiredata[0]['username']); ?>" href="javascript:void(0);">
                            <h3> <?php echo ucwords($freelancerhiredata[0]['fullname']) . ' ' . ucwords($freelancerhiredata[0]['username']); ?></h3>
                        </a>
                        <div class="profile-text">

                            <?php
                            if ($freelancerhiredata[0]['user_id'] == $this->session->userdata('aileenuser')) {
                                if ($freelancerhiredata[0]['designation'] == '') {
                                    ?>
                                    <a title="<?php echo $this->lang->line("designation"); ?>" id="designation" class="designation" title="Designation"><?php echo $this->lang->line("designation"); ?></a>

                                <?php } else { ?> 
                                    <a id="designation" class="designation" title="<?php echo ucwords($freelancerhiredata[0]['designation']); ?>"><?php echo ucwords($freelancerhiredata[0]['designation']); ?></a>
                                    <?php
                                }
                            } else {
                                if ($freelancerhiredata[0]['designation'] == '') {
                                    ?>
                                    <?php echo $this->lang->line("designation"); ?>
                                <?php } else {
                                    ?>
                                    <a style="cursor: default;"  title=" <?php echo ucwords($freelancerhiredata[0]['designation']); ?>">
                                        <?php echo ucwords($freelancerhiredata[0]['designation']); ?> </a>
                                    <?php
                                }
                            }
                            ?>
                        </div>

                        <div  class="add-post-button">
                            <?php if ($freelancerhiredata[0]['user_id'] == $this->session->userdata('aileenuser')) { ?>
                                <a title="Post Projects" class="btn btn-3 btn-3b" href="<?php echo base_url('freelance-hire/add-projects'); ?>"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo $this->lang->line("post_project"); ?></a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-12 mob-clear">
                        <div class="common-form">
                            <div class="job-saved-box">
                                <h3><?php echo $this->lang->line("employer_details"); ?></h3>
                                <?php

                                function text2link($text) {
                                    $text = preg_replace('/(((f|ht){1}t(p|ps){1}:\/\/)[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '<a href="\\1" target="_blank" rel="nofollow">\\1</a>', $text);
                                    $text = preg_replace('/([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '\\1<a href="http://\\2" target="_blank" rel="nofollow">\\2</a>', $text);
                                    $text = preg_replace('/([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})/i', '<a href="mailto:\\1" rel="nofollow" target="_blank">\\1</a>', $text);
                                    return $text;
                                }
                                ?>                              
                                <div class="contact-frnd-post">
                                    <div class="job-contact-frnd ">
                                        <div class="profile-job-post-detail clearfix">
                                            <div class="profile-job-post-title clearfix">
                                                <div class="profile-job-profile-button clearfix">
                                                    <div class="profile-job-details">
                                                        <ul>
                                                            <li> <p class="details_all_tital "> <?php echo $this->lang->line("basic_info"); ?></p> </li>

                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="profile-job-profile-menu">
                                                    <ul class="clearfix">
                                                        <li> <b><?php echo $this->lang->line("name"); ?></b> <span <?php if(!$this->session->userdata('aileenuser')){?> class="text_blur" <?php }?>> <?php echo $freelancerhiredata[0]['fullname'] . ' ' . $freelancerhiredata[0]['username']; ?> </span>
                                                        </li>

                                                        <li> <b><?php echo $this->lang->line("email"); ?> </b><span <?php if(!$this->session->userdata('aileenuser')){?> class="text_blur" <?php }?>> <?php echo $freelancerhiredata[0]['email']; ?></span>
                                                        </li>



                                                        <?php
                                                        if ($freelancerhiredata[0]['user_id'] != $this->session->userdata('aileenuser')) {
                                                            if ($freelancerhiredata['skyupid']) {
                                                                ?>
                                                                <li> <b><?php echo $this->lang->line("skype_id"); ?></b> <span <?php if(!$this->session->userdata('aileenuser')){?> class="text_blur" <?php }?>> <?php echo $freelancerhiredata[0]['skyupid']; ?> </span>
                                                                </li> 
                                                                <?php
                                                            } else {
                                                                echo "";
                                                            }
                                                        } else {
                                                            if ($freelancerhiredata[0]['skyupid']) {
                                                                ?>
                                                                <li> <b><?php echo $this->lang->line("skype_id"); ?></b> <span <?php if(!$this->session->userdata('aileenuser')){?> class="text_blur" <?php }?>> <?php echo $freelancerhiredata[0]['skyupid']; ?> </span>
                                                                </li> 
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <li><b><?php echo $this->lang->line("skype_id"); ?></b> <span>
                                                                        <?php echo PROFILENA; ?></span>
                                                                </li>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                        <?php
                                                        if ($freelancerhiredata[0]['user_id'] != $this->session->userdata('aileenuser')) {
                                                            if ($freelancerhiredata[0]['phone']) {
                                                                ?>
                                                                <li><b><?php echo $this->lang->line("phone_number"); ?></b> <span <?php if(!$this->session->userdata('aileenuser')){?> class="text_blur" <?php }?>><?php echo $freelancerhiredata[0]['phone']; ?></span> </li>
                                                                <?php
                                                            } else {
                                                                echo "";
                                                            }
                                                        } else {
                                                            if ($freelancerhiredata[0]['phone']) {
                                                                ?>
                                                                <li><b><?php echo $this->lang->line("phone_number"); ?></b> <span <?php if(!$this->session->userdata('aileenuser')){?> class="text_blur" <?php }?>><?php echo $freelancerhiredata[0]['phone']; ?></span> </li>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <li><b><?php echo $this->lang->line("phone_number"); ?></b> <span>
                                                                        <?php echo PROFILENA; ?></span>
                                                                </li>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                    </ul>
                                                </div>
                                                <div class="profile-job-post-title clearfix">
                                                    <div class="profile-job-profile-button clearfix">
                                                        <div class="profile-job-details">
                                                            <ul>
                                                                <li> <p class="details_all_tital "><?php echo $this->lang->line("address"); ?></p> </li>

                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="profile-job-profile-menu">
                                                        <ul class="clearfix">
                                                            <li> <b><?php echo $this->lang->line("country"); ?></b> <span> <?php echo $this->db->get_where('countries', array('country_id' => $freelancerhiredata[0]['country']))->row()->country_name; ?> </span>
                                                            </li>

                                                            <li> <b><?php echo $this->lang->line("state"); ?></b><span><?php
                                                                    echo
                                                                    $this->db->get_where('states', array('state_id' => $freelancerhiredata[0]['state']))->row()->state_name;
                                                                    ?> </span>
                                                            </li>

                                                            <?php
                                                            if ($freelancerhiredata[0]['user_id'] != $this->session->userdata('aileenuser')) {
                                                                if ($freelancerhiredata[0]['city']) {
                                                                    ?>
                                                                    <li><b><?php echo $this->lang->line("city"); ?></b> <span><?php
                                                                            echo
                                                                            $this->db->get_where('cities', array('city_id' => $freelancerhiredata[0]['city']))->row()->city_name;
                                                                            ?></span> </li>
                                                                        <?php
                                                                    } else {
                                                                        echo "";
                                                                    }
                                                                } else {
                                                                    if ($freelancerhiredata[0]['city']) {
                                                                        ?>
                                                                    <li><b><?php echo $this->lang->line("city"); ?></b> <span><?php
                                                                            echo
                                                                            $this->db->get_where('cities', array('city_id' => $freelancerhiredata[0]['city']))->row()->city_name;
                                                                            ?></span> </li>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                    <li><b><?php echo $this->lang->line("city"); ?></b> <span>
                                                                            <?php echo PROFILENA; ?></span>
                                                                    </li>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>

                                                            <?php
                                                            if ($freelancerhiredata[0]['user_id'] != $this->session->userdata('aileenuser')) {
                                                                if ($freelancerhiredata[0]['pincode']) {
                                                                    ?>
                                                                    <li> <b><?php echo $this->lang->line("pincode"); ?></b><span><?php echo $freelancerhiredata[0]['pincode']; ?></span>
                                                                    </li>
                                                                    <?php
                                                                } else {
                                                                    echo "";
                                                                }
                                                            } else {
                                                                if ($freelancerhiredata[0]['pincode']) {
                                                                    ?>
                                                                    <li> <b><?php echo $this->lang->line("pincode"); ?></b><span><?php echo $freelancerhiredata[0]['pincode']; ?></span>
                                                                    </li>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <li><b><?php echo $this->lang->line("pincode"); ?></b> <span>
                                                                            <?php echo PROFILENA; ?></span>
                                                                    </li>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>

                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="profile-job-post-title clearfix">
                                                    <div class="profile-job-profile-button clearfix">
                                                        <div class="profile-job-details">
                                                            <ul>
                                                                <li><p class="details_all_tital "><?php echo $this->lang->line("professional_information"); ?></p></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="profile-job-profile-menu">
                                                        <ul class="clearfix">
                                                            <li> <b><?php echo $this->lang->line("professional_information"); ?> </b> <span>
                                                                    <?php if ($freelancerhiredata[0]['professional_info']) { ?>

                                                                        <pre>  <?php echo $this->common->make_links($freelancerhiredata[0]['professional_info']); ?> 
                                                                        </pre>
                                                                        <?php
                                                                    } else {
                                                                        echo PROFILENA;
                                                                    }
                                                                    ?>
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div> 
                                                <div class="profile-job-post-title clearfix">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <?php echo $login_footer ?>
        <?php echo $footer; ?>
        <!-- model for popup start -->
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
        <!-- model for popup -->
        <!-- Bid-modal-2  -->
        <div class="modal fade message-box" id="bidmodal-2" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                            <div id="popup-form">
                                <div class="fw" id="profi_loader"  style="display:none;" style="text-align:center;" ><img alt="loader" src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" /></div>
                                <form id ="userimage" name ="userimage" class ="clearfix" enctype="multipart/form-data" method="post">
                                    <div class="fw">
                                        <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="upload-one">
                                    </div>
                                    <div class="col-md-7 text-center">
                                        <div id="upload-demo-one" style="width:350px; display: none"></div>
                                    </div>
                                    <input type="submit" class="upload-result-one" name="profilepicsubmit" id="profilepicsubmit" value="Save" >
                                </form>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Model Popup Close -->
        <!-- register -->

        <div class="modal fade register-model login" data-backdrop="static" data-keyboard="false" id="register" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content inner-form1">
                    <!--<button type="button" class="modal-close" data-dismiss="modal">&times;</button>-->       
                    <div class="modal-body">
                        <div class="clearfix">
                            <div class="">
                                <div class="title"><h1 class="tlh1">Sign up First and Register in Employer Profile</h1></div>
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
                                            <select tabindex="108" class="gender"  onchange="changeMe(this)" name="selgen" id="selgen">
                                                <option value="" disabled selected value>Gender</option>
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                            </select>
                                        </div>

                                        <p class="form-text" style="margin-bottom: 10px;">
                                            By Clicking on create an account button you agree our
                                            <a tabindex="109" title="Terms and Condition" href="<?php echo base_url('terms-and-condition'); ?>">Terms and Condition</a> and <a tabindex="110" title="Privacy policy" href="<?php echo base_url('privacy-policy'); ?>">Privacy policy</a>.
                                        </p>
                                        <p>
                                            <button tabindex="111" class="btn1">Create an account</button>
                                                                                        <!--<p class="next">Next</p>-->
                                        </p>
                                        <div class="sign_in pt10">
                                            <p>
                                                Already have an account ? <a title="Log In" tabindex="112" onClick="login_profile();" href="javascript:void(0);"> Log In </a>
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

        <!-- Login  -->
        <div class="modal fade login" id="login" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content login-frm">
                    <!--<button type="button" class="modal-close" data-dismiss="modal">&times;</button>-->       
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
                                            <a title="Forgot Password" href="javascript:void(0)" data-toggle="modal" onclick="forgot_profile();" id="myBtn">Forgot Password ?</a>
                                        </p>

                                        <p class="pt15 text-center">
                                            Don't have an account? <a title="Create an account" class="db-479" href="javascript:void(0);" data-toggle="modal" onclick="create_profile();">Create an account</a>
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
                    <button type="button" class="modal-close" data-dismiss="modal" onclick="login_profile1();">&times;</button>       
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


        <?php if (IS_HIRE_JS_MINIFY == '0') { ?>
            <script  src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
            <script  src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script>
            <script  type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>

        <?php } else { ?>
            <script  src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
            <script  src="<?php echo base_url('assets/js_min/croppie.js?ver=' . time()); ?>"></script>
            <script  type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()); ?>"></script>

        <?php } ?>


        <script>
                                                var base_url = '<?php echo base_url(); ?>';
                                                var user_session = '<?php echo $this->session->userdata('aileenuser'); ?>';
                                                var segment3 = '<?php echo $this->uri->segment(3); ?>'
        </script>
        <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/freelancer_hire_profile.js?ver=' . time()); ?>"></script>
        <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/freelancer_hire_common.js?ver=' . time()); ?>"></script>
        <?php if (IS_HIRE_JS_MINIFY == '0') { ?>
            <!--<script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/freelancer_hire_profile.js?ver=' . time()); ?>"></script>-->
            <!--<script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/freelancer_hire_common.js?ver=' . time()); ?>"></script>-->
        <?php } else { ?>
            <!--<script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-hire/freelancer_hire_profile.js?ver=' . time()); ?>"></script>-->
            <!--<script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-hire/freelancer_hire_common.js?ver=' . time()); ?>"></script>-->
        <?php } ?>

    </body>
</html>