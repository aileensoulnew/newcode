<?php
$s3 = new S3(awsAccessKey, awsSecretKey);
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>  
         <?php
        if (IS_REC_CSS_MINIFY == '0') {
            ?>
             <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dragdrop/fileinput.css?ver=' . time()); ?>" />
            <link href="<?php echo base_url('assets/dragdrop/themes/explorer/theme.css?ver=' . time()); ?>" media="all" rel="stylesheet" type="text/css"/>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>" />
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />      
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css'); ?>">         
   <?php
        } else {
            ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_main/style-main.css'); ?>">         
              <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dragdrop/fileinput.css?ver=' . time()); ?>" />
            <link href="<?php echo base_url('assets/dragdrop/themes/explorer/theme.css?ver=' . time()); ?>" media="all" rel="stylesheet" type="text/css"/>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>" />
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/job.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />      
        <?php } ?>
         
     
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css'); ?>" />
        <style type="text/css">
            .two-images, .three-image, .four-image{
                height: auto !important;
            }
        </style>
    
    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push botton_footer no-login">

        <header>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-3 left-header text-center fw-479">
                     <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png?ver='.time()) ?>" alt="logo"></a>
                    </div>
                    <div class="col-md-8 col-sm-9 right-header fw-479 text-center">
                        <div class="btn-right pull-right">
                            <a href="javascript:void(0);" onclick="login_data();" class="btn2">Login</a>
                            <a href="javascript:void(0);" onclick="register_profile();" class="btn3">Create an account</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div id="preloader"></div>
        <!-- START CONTAINER -->
        <section>
            <!-- MIDDLE SECTION START -->
            <div class="container mt-22" id="paddingtop_fixed">

                <div class="row" id="row1" style="display:none;">
                    <div class="col-md-12 text-center">
                        <div id="upload-demo" ></div>
                    </div>
                    <div class="col-md-12 cover-pic">
                        <button class="btn btn-success  cancel-result" onclick="">Cancel</button>

                        <button class="btn btn-success  upload-result set-btn" onclick="myFunction()">Save</button>

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
                        <div id="upload-demo-i"></div>
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
                        $contition_array = array('user_id' => $user_id, 'is_delete' => '0', 're_status' => '1');
                        $image = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'profile_background', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                       $image_ori = $image[0]['profile_background'];
                         $filename = $this->config->item('rec_bg_main_upload_path') . $image[0]['profile_background'];
                         $s3 = new S3(awsAccessKey, awsSecretKey);
                         $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                        if ($info && $image[0]['profile_background'] != '') {
                            ?>
                           <img src = "<?php echo REC_BG_MAIN_UPLOAD_URL . $image[0]['profile_background']; ?>" name="image_src" id="image_src" alt="<?php echo $image[0]['profile_background']; ?>"/>
                     <?php
                        } else {
                            ?>

                             <div class="bg-images no-cover-upload">
                                 <img src="<?php echo base_url(WHITEIMAGE); ?>" name="image_src" id="image_src" alt="<?php echo 'NOIMAGE'; ?>" />
                             </div>
                             <?php }
                             ?>

                    </div>
                </div>
            </div>

            <div class="container tablate-container art-profile">




                <?php if ($this->uri->segment(3) == $userid) { ?>
                    <div class="upload-img">
                        <label class="cameraButton"><span class="tooltiptext_rec">Upload Cover Photo</span><i class="fa fa-camera" aria-hidden="true"></i>
                            <input type="file" id="upload" name="upload" accept="image/*;capture=camera" onclick="showDiv()">
                        </label>
                    </div>

                <?php } ?>

                <div class="profile-photo">
                    <!--PROFILE PIC CODE START-->
                    <div class="profile-pho">
                        <div class="user-pic padd_img">
                            
                             <?php  $filename = $this->config->item('rec_profile_thumb_upload_path') . $recdata['recruiter_user_image'];
                         $s3 = new S3(awsAccessKey, awsSecretKey);
                         $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                      if ($recdata['recruiter_user_image'] != '' && $info) { ?>
                     <img src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL . $recdata['recruiter_user_image']; ?>" alt="<?php echo $recdata['recruiter_user_image']; ?>" >
                                <?php
                            } else {
                                $a = $recdata['rec_firstname'];
                                $acr = substr($a, 0, 1);

                                $b = $recdata['rec_lastname'];
                                $acr1 = substr($b, 0, 1);
                                ?>
                                <div class="post-img-user">
                                    <?php echo ucfirst(strtolower($acr)) . ucfirst(strtolower($acr1)); ?>

                                </div>
                            <?php } ?>

                            <?php if ($this->uri->segment(3) == $userid) { ?>
                     <a class="cusome_upload" href="javascript:void(0);" onclick="updateprofilepopup();"><img src="<?php echo base_url(); ?>assets/img/cam.png" alt="cameraimage"> Update Profile Picture</a>

                            <?php } ?>
                        </div>
                    </div>
                    <!--PROFILE PIC CODE END-->
                    <div class="job-menu-profile mob-block">
                        <a href="javascript:void(0);" title="<?php echo $recdata['rec_firstname'] . ' ' . $recdata['rec_lastname']; ?>"><h3><?php echo $recdata['rec_firstname'] . ' ' . $recdata['rec_lastname']; ?></h3></a>
                        <!-- text head start -->
                        <div class="profile-text" >




                            <?php 
                            if ($this->uri->segment(3) == $userid) {
                                if ($recdata['designation'] == '') {
                                    ?>
                
                                    <a id="designation" class="designation" title="Designation">Designation</a>

                                <?php } else {
                                    ?> 
                
                                    <a id="designation" class="designation" title="<?php echo ucfirst(strtolower($recdata['designation'])); ?>"><?php echo ucfirst(strtolower($recdata['designation'])); ?></a>
                                    <?php
                                }
                            } else {


                                if ($recdata['designation'] == '') {
                                    ?>
                                   
                                    <a id="designation"  title="Designation">Designation</a>

                                <?php } else {  ?>
                                    <a id="designation"  title="<?php echo ucfirst(strtolower($recdata['designation'])); ?>"> <?php echo ucfirst(strtolower($recdata['designation'])); ?></a> <?php
                                }
                            }
                            ?>
                        </div>

                    </div>
                    <!-- menubar -->
                    <div class="profile-main-rec-box-menu profile-box-art col-md-12 padding_les">

                        <div class=" right-side-menu art-side-menu padding_less_right job_edit_pr right-menu-jr">  

                            <?php
                            $userid = $this->session->userdata('aileenuser');
                            if ($recdata['user_id'] == $userid) {
                                ?>     
                                <ul class="current-user pro-fw">

                                    <?php } else { ?>
                                    <ul class="pro-fw4">
<?php } ?>  

                                    <li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'profile') { ?> class="active" <?php } ?>>
                                        <?php if ($this->uri->segment(3) != $userid) { ?>
                                            <a title="Details" onclick="register_profile();">Details</a>
                                        <?php } else { ?>
                                            <a title="Details" onclick="register_profile();">Details</a>
<?php } ?>
                                    </li>

<?php if ($this->uri->segment(3) == $userid){?>

<?php if (($this->uri->segment(1) == 'recruiter') && ($this->uri->segment(2) == 'post' || $this->uri->segment(2) == 'profile' || $this->uri->segment(2) == 'add-post' || $this->uri->segment(2) == 'save-candidate') && ($this->uri->segment(3) == $this->session->userdata('aileenuser') || $this->uri->segment(3) == '' || $this->uri->segment(3) != '')) { ?>

                                        <li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'post') { ?> class="active" <?php } ?>>
                                            <?php if ($this->uri->segment(3) != $userid) { ?>
                                                <a title="Post" href="<?php echo base_url('recruiter/post/' . $this->uri->segment(3)); ?>">Post</a>
                                            <?php } else { ?>
                                                <a title="Post" href="<?php echo base_url('recruiter/post'); ?>">Post</a>
    <?php } ?>
                                        </li>


                                    <?php } ?>   

                                    <?php }?> 

<?php if (($this->uri->segment(1) == 'recruiter') && ($this->uri->segment(2) == 'post' || $this->uri->segment(2) == 'profile' || $this->uri->segment(2) == 'add-post' || $this->uri->segment(2) == 'save-candidate') && ($this->uri->segment(3) == $this->session->userdata('aileenuser') || $this->uri->segment(3) == '')) { ?>

                                        <li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'save-candidate') { ?> class="active" <?php } ?>><a title="Saved Candidate" href="<?php echo base_url('recruiter/save-candidate'); ?>">Saved </a>
                                        </li> 




<?php } ?>               
                                </ul>

                              
                                            <?php if ($this->uri->segment(3) != "" && $this->uri->segment(3) != $userid) { ?>
                                      <div class="flw_msg_btn fr">
                                    <ul>      
                                    <li> 
                                <a onclick="register_profile();">Message</a> 
                            </li>
   </ul>
                                </div>
 <?php } ?>  
                        </div>

                    </div>  


                </div>            
            </div>
            <div  class="add-post-button mob-block">
                <?php if ($this->uri->segment(3) == $userid) { ?>
                    <a class="btn btn-3 btn-3b" href="<?php echo base_url('recruiter/add-post'); ?>"><i class="fa fa-plus" aria-hidden="true"></i>  Post a Job</a>
<?php } ?>
            </div>
            <!-- menubar --> 
            <div class="middle-part container rec_res">
                <div class="job-menu-profile  mob-none ">
                    <a href="javascript:void(0);" title="<?php echo $recdata['rec_firstname'] . ' ' . $recdata['rec_lastname']; ?>"><h3><?php echo $recdata['rec_firstname'] . ' ' . $recdata['rec_lastname']; ?></h3></a>
                    <!-- text head start -->
                    <div class="profile-text" >

                        <?php
                       if ($this->uri->segment(3) == $userid) {
                            if ($recdata['designation'] == "") {
                                ?>

                                <a id="designation" class="designation" title="Designation">Designation</a>
                                <?php
                            } else {
                                ?> 
                                
                                <a id="designation" class="designation" title="<?php echo ucfirst(strtolower($recdata['designation'])); ?>"><?php echo ucfirst(strtolower($recdata['designation'])); ?></a>
                            <?php
                            }
                        } else {
                           if ($recdata['designation'] == '') {
                                    ?>
                                    
                                    <a id="designation"  title="Designation">Designation</a>

                                <?php } else {  ?>
                                    <a id="designation"  title="<?php echo ucfirst(strtolower($recdata['designation'])); ?>"> <?php echo ucfirst(strtolower($recdata['designation'])); ?></a> <?php
                                }
                        }
                        ?>

                    </div>

                    <div  class="add-post-button">
                        <?php if($this->uri->segment(3) == $userid) { ?>
                            <a class="btn btn-3 btn-3b" href="<?php echo base_url('recruiter/add-post'); ?>"><i class="fa fa-plus" aria-hidden="true"></i>  Post a Job</a>
<?php } ?>
                    </div>
                </div>
                <!-- text head end -->

                <div class="col-md-7 col-sm-12 mob-clear">
                    <div class="common-form">
                        <div class="job-saved-box">

                            <h3>Details  </h3>

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
                                            <div class="profile-job-post-title clearfix">
                                                <div class="profile-job-profile-button clearfix">
                                                    <div class="profile-job-details">
                                                        <ul>
                                                            <li> <p class="details_all_tital "> Basic Information</p></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="profile-job-profile-menu">
                                                    <ul class="clearfix">
                                                        <li> <b> Name</b> <span class="text_blur"> 
                                                                <?php
                                                                if ($recdata['rec_firstname'] || $recdata['rec_lastname']) {
                                                                    echo $recdata['rec_firstname'] . '  ' . $recdata['rec_lastname'];
                                                                } else {
                                                                    echo PROFILENA;
                                                                }
                                                                ?> </span>
                                                        </li>

                                                        <li> <b>Email </b><span class="text_blur"> 
                                                                <?php
                                                                if ($recdata['rec_email']) {
                                                                    echo $recdata['rec_email'];
                                                                } else {
                                                                    echo PROFILENA;
                                                                }
                                                                ?> </span>
                                                        </li>



                                                        <?php
                                                        if ($this->uri->segment(3) != $userid) {

                                                            if ($recdata['rec_phone']) {
                                                                ?>
                                                                <li><b> Phone Number</b> <span class="text_blur"><?php echo $recdata['rec_phone']; ?>

                                                                    </span> </li>

                                                                <?php
                                                            } else {
                                                                echo "";
                                                            }
                                                        } else {
                                                            if ($recdata['rec_phone']) {
                                                                ?>
                                                                <li><b> Phone Number</b> <span class="text_blur"><?php echo $recdata['rec_phone']; ?>

                                                                    </span> </li>

                                                                <?php
                                                            } else {
                                                                ?>
                                                                <li><b>Phone Number </b> <span>
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

                                                            <li><p class="details_all_tital ">Company Information</p></li>

                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="profile-job-profile-menu">
                                                    <ul class="clearfix">
                                                        <li> <b>Company Name</b><span class="text_blur"><?php
                                                                if ($recdata['re_comp_name']) {
                                                                    echo $recdata['re_comp_name'];
                                                                } else {
                                                                    echo PROFILENA;
                                                                }
                                                                ?></span>
                                                        </li>
                                                        <li><b> Company Email Address</b> <span class="text_blur"><?php
                                                                if ($recdata['re_comp_email']) {
                                                                    echo $recdata['re_comp_email'];
                                                                } else {
                                                                    echo PROFILENA;
                                                                }
                                                                ?></span> </li>
                                                        <li> <b>Company Phone Number</b><span class="text_blur"> <?php
                                                                if ($recdata['re_comp_phone']) {
                                                                    echo $recdata['re_comp_phone'];
                                                                } else {
                                                                    echo PROFILENA;
                                                                }
                                                                ?></span>
                                                        </li>




                                                        <?php
                                                        if ($this->uri->segment(3) != $userid) {

                                                            if ($recdata['re_comp_site']) {
                                                                ?>
                                                                <li> <b>Company Website</b><span class="text_blur"><a target="_blank"><?php
                                                                    echo $this->common->rec_profile_links($recdata['re_comp_site']);
                                                                ?></a></span>
                                                                </li>
                                                                <?php
                                                            } else {
                                                                echo "";
                                                            }
                                                        } else {
                                                            if ($recdata['re_comp_site']) {
                                                                ?>
                                                                <li> <b>Company Website</b><span class="text_blur"><a target="_blank"><?php
                                                                    echo $this->common->rec_profile_links($recdata['re_comp_site']);
                                                                ?></a></span>
                                                                </li>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <li><b> Company Website </b> <span class="text_blur">
                                                                <?php echo PROFILENA; ?></span>
                                                                </li>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                        <li> <b> Country</b> <span class="text_blur"><?php
                                                                $cache_time = $this->db->select('country_name')->get_where('countries', array('country_id' => $recdata['re_comp_country']))->row()->country_name;

                                                                if ($cache_time) {
                                                                    echo $cache_time;
                                                                } else {
                                                                    echo PROFILENA;
                                                                }
                                                                ?></span>
                                                        </li>

                                                        <li> <b>State </b><span class="text_blur"> <?php
                                                                $cache_time = $this->db->select('state_name')->get_where('states', array('state_id' => $recdata['re_comp_state']))->row()->state_name;
                                                                if ($cache_time) {
                                                                    echo $cache_time;
                                                                } else {
                                                                    echo PROFILENA;
                                                                }
                                                                ?> </span>
                                                        </li>

                                                        <?php
                                                        if ($this->uri->segment(3) != $userid) {
                                                            if ($recdata['re_comp_city']) {
                                                                ?>
                                                                <li><b> City</b> <span class="text_blur"><?php
                                                                        $cache_time = $this->db->select('city_name')->get_where('cities', array('city_id' => $recdata['re_comp_city']))->row()->city_name;
                                                                        if ($cache_time) {
                                                                            echo $cache_time;
                                                                        }
                                                                        ?></span> </li>
                                                                <?php
                                                            } else {
                                                                echo "";
                                                            }
                                                        } else {
                                                            if ($recdata['re_comp_city']) {
                                                                ?>
                                                                <li><b> City</b> <span class="text_blur"><?php
                                                                        $cache_time = $this->db->select('city_name')->get_where('cities', array('city_id' => $recdata['re_comp_city']))->row()->city_name;
                                                                        if ($cache_time) {
                                                                            echo $cache_time;
                                                                        }
                                                                        ?></span> </li>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <li><b>City</b> <span>
                                                                <?php echo PROFILENA; ?></span>
                                                                </li>
                                                                <?php
                                                            }
                                                        }
                                                        ?>


                                                        <?php
                                                        if ($this->uri->segment(3) != $userid) {
                                                            if ($recdata['re_comp_sector']) {
                                                                ?>
                                                                <li><b>Skill/Sector I Hire For</b><span class="text_blur"><pre><?php echo $this->common->make_links($recdata['re_comp_sector']); ?></pre></span></li>
                                                                <?php
                                                            } else {
                                                                echo "";
                                                            }
                                                        } else {
                                                            if ($recdata['re_comp_sector']) {
                                                                ?>
                                                                <li><b>Skill/Sector I Hire For</b><span class="text_blur"><pre><?php echo $this->common->make_links($recdata['re_comp_sector']); ?></pre></span></li>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <li><b>Skill/Sector I  Hire For</b> <span>
                                                                <?php echo PROFILENA; ?></span>
                                                                </li>
                                                                <?php
                                                            }
                                                        }
                                                        ?>


                                                        <?php
                                                        if ($this->uri->segment(3) != $userid) {
                                                            if ($recdata['re_comp_profile']) {
                                                                ?>
                                                                <li><b>Company Profile</b> <span class="text_blur"><pre>
                                                                            <?php
                                                                echo $this->common->make_links($recdata['re_comp_profile']);
                                                                ?></pre></span> </li>
                                                                <?php
                                                            } else {
                                                                echo "";
                                                            }
                                                        } else {
                                                            if ($recdata['re_comp_profile']) {
                                                                ?>
                                                                <li><b>Company Profile</b> <span class="text_blur"><pre>
                                                                            <?php
                                                                echo $this->common->make_links($recdata['re_comp_profile']);
                                                                ?></pre></span> </li>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <li><b>Company Profile</b> <span>
                                                                <?php echo PROFILENA; ?></span>
                                                                </li>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                        <?php
                                                        if ($this->uri->segment(3) != $userid) {
                                                            if ($recdata['comp_logo']) {
                                                                ?>
                                                                <li><b>Company Logo</b> <span class="text_blur">

                                                                       <?php if (IMAGEPATHFROM == 'upload') { ?>
                                                                        <img src="<?php echo base_url($this->config->item('rec_profile_thumb_upload_path') . $recdata['comp_logo']) ?>"  style="width:100px;height:100px;" class="job_education_certificate_img" alt="<?php echo $recdata['comp_logo']; ?>">
                                                                        <?php } else{ 

                                $filename = $this->config->item('rec_profile_thumb_upload_path') .$recdata['comp_logo'];
                                    $s3 = new S3(awsAccessKey, awsSecretKey);
                                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                    if($info){  ?>
                                <img src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL . $recdata['comp_logo']; ?>" name="image_src" id="image_src" alt="<?php echo $recdata['comp_logo']; ?>"/> 
                                <?php }else{
                                    echo PROFILENA;
                                 }?>
                                                <?php }?>

                                    </span> </li>
                                                                <?php
                                                            } else {
                                                                echo "";
                                                            }
                                                        } else {
                                                            if ($recdata['comp_logo']) {
                                                                ?>
                                                                <li><b>Company Logo</b> <span class="text_blur">

                                                                     <?php if (IMAGEPATHFROM == 'upload') { ?>
                                                                        <img src="<?php echo base_url($this->config->item('rec_profile_thumb_upload_path') . $recdata['comp_logo']) ?>"  style="width:100px;height:100px;" class="job_education_certificate_img" >

                                                                        <?php } else {  $filename = $this->config->item('rec_profile_thumb_upload_path') .$recdata['comp_logo'];
                                    $s3 = new S3(awsAccessKey, awsSecretKey);
                                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                    if($info){  ?>
                                <img src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL . $recdata['comp_logo']; ?>" name="image_src" id="image_src" alt="<?php echo $recdata['comp_logo']; ?>"/> 
                                                <?php } else{
                                    echo PROFILENA;
                                 } }?>


                                                                    </span> </li>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <li><b>Company Logo</b> <span>
                                                                <?php echo PROFILENA; ?></span>
                                                                </li>
                                                                <?php
                                                            }
                                                        }
                                                        ?>



                                                    </ul>
                                                </div>



                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="clearfix"></div>  
            </div>
			

            <!-- MIDDLE SECTION END-->
        </section>
        <!-- END CONTAINER -->

        <!--PROFILE PIC MODEL START-->
      <div class="modal fade message-box" id="bidmodal-2" role="dialog">
         <div class="modal-dialog modal-lm">
            <div class="modal-content">
               <button type="button" class="modal-close" data-dismiss="modal">&times;</button>      
               <div class="modal-body">
                  <span class="mes">
                     <div id="popup-form">

                        <div class="fw" id="profi_loader"  style="display:none;" style="text-align:center;" ><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo 'LOADERIMAGE'; ?>"/></div>
                     <form id ="userimage" name ="userimage" class ="clearfix" enctype="multipart/form-data" method="post">
                                    <div class="fw">
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
        <!-- BEGIN FOOTER -->


          <!-- Login  -->
        <div class="modal login fade" id="login" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content login-frm">        
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


          <!-- register -->

        <div class="modal fade login register-model" data-backdrop="static" data-keyboard="false" id="register" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content inner-form1">      
                    <div class="modal-body">
                        <div class="clearfix">
                            <div class="">
                              <div class="title"><h1 class="tlh1">Sign up First and Register in Recruiter Profile</h1></div>
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
                                        <span>
                                        <select tabindex="108" class="gender"  onchange="changeMe(this)" name="selgen" id="selgen">
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
                                    </p>
                                    <div class="sign_in pt10">
                                        <p>
                                            Already have an account ? <a tabindex="112" onclick="login_data();" href="javascript:void(0);"> Log In </a>
                                        </p>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<!-- Model Popup Close -->
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
                                        <input type="email" tabindex="50"  value="" name="forgot_email" id="forgot_email" class="form-control input-sm" placeholder="Email Address*" autofocus>
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
                                        <input class="btn btn-theme btn1" tabindex="51" type="submit" name="submit" value="Submit" style="width:105px; margin:0px auto;" /> 
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

        <?php echo $login_footer ?>
<?php echo $footer; ?>
        <!-- END FOOTER -->
        <!-- FIELD VALIDATION JS START -->
        
        
        <?php
        if (IS_REC_JS_MINIFY == '0') {
            ?>
         <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script> 
       <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/croppie.js?ver='.time()); ?>"></script>
            <?php
        } else {
            ?>
       <script src="<?php echo base_url('assets/js_min/bootstrap.min.js'); ?>"></script> 
       <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js_min/croppie.js?ver='.time()); ?>"></script>
        <?php } ?>
        
        <script>
                                    var base_url = '<?php echo base_url(); ?>';
                                    var jobdata = <?php echo json_encode($jobtitle); ?>;
                                    var get_csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
                                    var get_csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
                                    var reg_id = '<?php echo $reg_id; ?>';

        </script>
        <!-- FIELD VALIDATION JS END -->
        <?php
        if (IS_REC_JS_MINIFY == '0') {
         if ($this->uri->segment(3) != $userid){   ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/search_common.js?ver='.time()); ?>"></script>
<?php }else{ ?>
 <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/search.js'); ?>"></script>
<?php } ?>
 <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/rec_profile.js'); ?>"></script>
            <?php
        } else {
          
             if ($this->uri->segment(3) != $userid){   ?>
<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/job/search_common.js?ver='.time()); ?>"></script>
<?php }else{ ?>
 <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/recruiter/search.js'); ?>"></script>
<?php } ?>
 <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/recruiter/rec_profile.js'); ?>"></script>
        <?php } ?>
       
<script type="text/javascript">
    

$(document).ready(function () {
                setTimeout(function () {
                    $('#register').modal('show');
                }, 500);
            });


    function login_profile() {
                $('#register').modal('show');
                 $('body').addClass('modal-open-other');
                
            }
             function login_data() { 
                $('#login').modal('show');
                $('#register').modal('hide');
                 $('body').addClass('modal-open-other');


            }
            function register_profile() {
                $('#login').modal('hide');
                $('#register').modal('show');
            }
            function forgot_profile() {
                 $('#login').modal('hide');
                $('#forgotPassword').modal('show');
                 $('body').addClass('modal-open-other');
            }


 $(".modal-close").click(function(){
    $('#login').modal('show');
     $('body').addClass('modal-open-other');
});
</script>


 <!-- <script type="text/javascript">
    
    $( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) {
            if($('#forgotPassword').modal('show')){
         $('#forgotPassword').modal('hide');
         $('#login').modal('show');
       } 
    }
});

</script> -->
 <script type="text/javascript">
            function login()
            {
                document.getElementById('error1').style.display = 'none';
            }
            //validation for edit email formate form
            $(document).ready(function () {
                /* validation */
                $("#login_form").validate({
                    rules: {
                        email_login: {
                            required: true,
                        },
                        password_login: {
                            required: true,
                        }
                    },
                    messages:
                            {
                                email_login: {
                                    required: "Please enter email address",
                                },
                                password_login: {
                                    required: "Please enter password",
                                }
                            },
                    submitHandler: submitForm
                });
                /* validation */
                /* login submit */
                function submitForm()
                {

                    var email_login = $("#email_login").val();
                    var password_login = $("#password_login").val();
                    var post_data = {
                        'email_login': email_login,
                        'password_login': password_login,
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    }
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() ?>registration/user_check_login',
                        data: post_data,
                        dataType: "json",
                        beforeSend: function ()
                        {
                            $("#error").fadeOut();
                            $("#btn1").html('Login');
                        },
                        success: function (response)
                        {
                            if (response.data == "ok") { 
                                $("#btn1").html('<img src="<?php echo base_url() ?>assets/images/btn-ajax-loader.gif" /> &nbsp; Login');
                                if (response.is_job == '1') {
                                    window.location = "<?php echo base_url() ?>recruiter/profile/" + reg_id;
                                } else {
                                    window.location = "<?php echo base_url() ?>recruiter";
                                }
                            } else if (response.data == "password") {
                                $("#errorpass").html('<label for="email_login" class="error">Please enter a valid password.</label>');
                                document.getElementById("password_login").classList.add('error');
                                document.getElementById("password_login").classList.add('error');
                                $("#btn1").html('Login');
                            } else {
                                $("#errorlogin").html('<label for="email_login" class="error">Please enter a valid email.</label>');
                                document.getElementById("email_login").classList.add('error');
                                document.getElementById("email_login").classList.add('error');
                                $("#btn1").html('Login');
                            }
                        }
                    });
                    return false;
                }
                /* login submit */
            });



        </script>
        <script>

            $(document).ready(function () {

                $.validator.addMethod("lowercase", function (value, element, regexpr) {
                    return regexpr.test(value);
                }, "Email Should be in Small Character");

                $("#register_form").validate({
                    rules: {
                        first_name: {
                            required: true,
                        },
                        last_name: {
                            required: true,
                        },
                        email_reg: {
                            required: true,
                            email: true,
                            lowercase: /^[0-9a-z\s\r\n@!#\$\^%&*()+=_\-\[\]\\\';,\.\/\{\}\|\":<>\?]+$/,
                            remote: {
                                url: "<?php echo site_url() . 'registration/check_email' ?>",
                                type: "post",
                                data: {
                                    email_reg: function () {
                                       
                                        return $("#email_reg").val();
                                    },
                                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                                },
                            },
                        },
                        password_reg: {
                            required: true,
                        },
                        selday: {
                            required: true,
                        },
                        selmonth: {
                            required: true,
                        },
                        selyear: {
                            required: true,
                        },
                        selgen: {
                            required: true,
                        }
                    },

                    groups: {
                        selyear: "selyear selmonth selday"
                    },
                    messages:
                            {
                                first_name: {
                                    required: "Please enter first name",
                                },
                                last_name: {
                                    required: "Please enter last name",
                                },
                                email_reg: {
                                    required: "Please enter email address",
                                    remote: "Email address already exists",
                                },
                                password_reg: {
                                    required: "Please enter password",
                                },

                                selday: {
                                    required: "Please enter your birthdate",
                                },
                                selmonth: {
                                    required: "Please enter your birthdate",
                                },
                                selyear: {
                                    required: "Please enter your birthdate",
                                },
                                selgen: {
                                    required: "Please enter your gender",
                                }

                            },
                    submitHandler: submitRegisterForm
                });
                /* register submit */
                function submitRegisterForm()
                {
                    var first_name = $("#first_name").val();
                    var last_name = $("#last_name").val();
                    var email_reg = $("#email_reg").val();
                    var password_reg = $("#password_reg").val();
                    var selday = $("#selday").val();
                    var selmonth = $("#selmonth").val();
                    var selyear = $("#selyear").val();
                    var selgen = $("#selgen").val();

                    var post_data = {
                        'first_name': first_name,
                        'last_name': last_name,
                        'email_reg': email_reg,
                        'password_reg': password_reg,
                        'selday': selday,
                        'selmonth': selmonth,
                        'selyear': selyear,
                        'selgen': selgen,
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    }


                    var todaydate = new Date();
                    var dd = todaydate.getDate();
                    var mm = todaydate.getMonth() + 1; //January is 0!
                    var yyyy = todaydate.getFullYear();

                    if (dd < 10) {
                        dd = '0' + dd
                    }

                    if (mm < 10) {
                        mm = '0' + mm
                    }

                    var todaydate = yyyy + '/' + mm + '/' + dd;
                    var value = selyear + '/' + selmonth + '/' + selday;


                    var d1 = Date.parse(todaydate);
                    var d2 = Date.parse(value);
                    if (d1 < d2) {
                        $(".dateerror").html("Date of birth always less than to today's date.");
                        return false;
                    } else {
                        if ((0 == selyear % 4) && (0 != selyear % 100) || (0 == selyear % 400))
                        {
                            if (selmonth == 4 || selmonth == 6 || selmonth == 9 || selmonth == 11) {
                                if (selday == 31) {
                                    $(".dateerror").html("This month has only 30 days.");
                                    return false;
                                }
                            } else if (selmonth == 2) { 
                                if (selday == 31 || selday == 30) {
                                    $(".dateerror").html("This month has only 29 days.");
                                    return false;
                                }
                            }
                        } else {
                            if (selmonth == 4 || selmonth == 6 || selmonth == 9 || selmonth == 11) {
                                if (selday == 31) {
                                    $(".dateerror").html("This month has only 30 days.");
                                    return false;
                                }
                            } else if (selmonth == 2) {
                                if (selday == 31 || selday == 30 || selday == 29) {
                                    $(".dateerror").html("This month has only 28 days.");
                                    return false;
                                }
                            }
                        }
                    }
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() ?>registration/reg_insert',
                        data: post_data,
                        dataType: 'json',
                        beforeSend: function ()
                        {
                            $("#register_error").fadeOut();
                            $("#btn1").html('Create an account');
                        },
                        success: function (response)
                        {
                            if (response.okmsg == "ok") {
                                $("#btn-register").html('<img src="<?php echo base_url() ?>assets/images/btn-ajax-loader.gif" /> &nbsp; Sign Up ...');
                                window.location = "<?php echo base_url() ?>job";
                            } else {
                                $("#register_error").fadeIn(1000, function () {
                                    $("#register_error").html('<div class="alert alert-danger main"> <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; ' + response + ' !</div>');
                                    $("#btn1").html('Create an account');
                                });
                            }
                        }
                    });
                    return false;
                }
            });

        </script>
        <!-- forgot password script end -->
        <script type="text/javascript">
            $(document).ready(function () { 
                /* validation */
                $("#forgot_password").validate({
                    rules: {
                        forgot_email: {
                            required: true,
                            email: true,
                        }

                    },
                    messages: {
                        forgot_email: {
                            required: "Email Address Is Required.",
                        }
                    },
                     submitHandler: submitforgotForm
                });
function submitforgotForm()
 {

    var email_login = $("#forgot_email").val();

    var post_data = {
        'forgot_email': email_login,
//            csrf_token_name: csrf_hash
    }
    $.ajax({
        type: 'POST',
        url: base_url + 'profile/forgot_live',
        data: post_data,
        dataType: "json",
        beforeSend: function ()
        {
            $("#error").fadeOut();
//            $("#forgotbuton").html('Your credential has been send in your register email id');
        },
        success: function (response)
        {
            if (response.data == "success") {
                //  alert("login");
                $("#forgotbuton").html(response.message);
                setTimeout(function () {
                    $('#forgotPassword').modal('hide');
                    $('#login').modal('show');
                     $("#forgotbuton").html('');
                    document.getElementById("forgot_email").value = "";
                }, 5000); // milliseconds
                //window.location = base_url + "job/home/live-post";
            } else {
                $("#forgotbuton").html(response.message);

            }
        }
    });
    return false;
}            /* validation */

            });
        </script>


        <style type="text/css">

            .keyskill_border_active {
                border: 3px solid #f00 !important;

            }
            #skills-error{margin-top: 40px !important;}

            #minmonth-error{    margin-top: 40px; margin-right: 9px;}
            #minyear-error{margin-top: 42px !important;margin-right: 9px;}
            #maxmonth-error{margin-top: 42px !important;margin-right: 9px;}
            #maxyear-error{margin-top: 42px !important;margin-right: 9px;}

            #minmonth-error{margin-top: 39px !important;}
            #minyear-error{margin-top: auto !important;}
            #maxmonth-error{margin-top: 39px !important;}
            #maxyear-error{margin-top: auto !important;}
            #example2-error{margin-top: 40px !important}


        </style>
    </body>
</html>