<?php
$s3 = new S3(awsAccessKey, awsSecretKey);
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>  

         <?php
        if (IS_JOB_CSS_MINIFY == '1') {
            ?>

            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dragdrop/fileinput.css?ver=' . time()); ?>" />
            <link href="<?php echo base_url('assets/dragdrop/themes/explorer/theme.css?ver=' . time()); ?>" media="all" rel="stylesheet" type="text/css"/>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css'); ?>" />
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />

            <?php }else{?>
             <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dragdrop/fileinput.css?ver=' . time()); ?>" />
            <link href="<?php echo base_url('assets/dragdrop/themes/explorer/theme.css?ver=' . time()); ?>" media="all" rel="stylesheet" type="text/css"/>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>" />
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/job.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css'); ?>" />

            <?php }?>      
        <style type="text/css">
            .two-images, .three-image, .four-image{
                height: auto !important;
            }
            .mejs__overlay-button {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
            .mejs__overlay-loading-bg-img {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
            .mejs__button > button {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
        </style>
        <style type="text/css">
            .two-images, .three-image, .four-image{
                height: auto !important;
            }
        </style>
      
    </head>
   <body   class="page-container-bg-solid page-boxed botton_footer no-login" id="add-model-open">

     <header>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-3 left-header text-center fw-479">
                     <div class="logo"> <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png?ver='.time()) ?>" alt="logo"></a></div>
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

      <section class="custom-row">
         <div class="container  " id="paddingtop_fixed">
            <div class="row" id="row1" style="display:none;">
               <div class="col-md-12 text-center">
                  <div id="upload-demo"></div>
               </div>
               <div class="col-md-12 cover-pic" >
                  <button class="btn btn-success  cancel-result" onclick="" >Cancel</button>
                  <button class="btn btn-success set-btn upload-result " onclick="myFunction()">Save</button>
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
               <div class="">
                  <div class="" id="row2">
                   
                     <?php
                        $userid = $this->session->userdata('aileenuser');

                        $id = $this->db->get_where('job_reg', array('slug' =>$this->uri->segment(3)))->row()->user_id;
                       
                       if ($userid == $id)
                        {
                            $user_id=$userid;
                        } else 
                        {
                            $user_id=$id;
                        }
                        $contition_array = array('user_id' => $user_id, 'is_delete' => '0', 'status' => '1');
                        $image = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'profile_background', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                        
                        $image_ori = $image[0]['profile_background'];
                        
                         $filename = $this->config->item('job_bg_main_upload_path') . $image[0]['profile_background'];
                         $s3 = new S3(awsAccessKey, awsSecretKey);
                         $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                        if ($info && $image[0]['profile_background'] != '') {
                            ?>
                           <img src = "<?php echo JOB_BG_MAIN_UPLOAD_URL . $image[0]['profile_background']; ?>" name="image_src" id="image_src" alt="<?php echo $image[0]['profile_background']; ?>"/>
                   
                     <?php
                        } else {
                            ?>
                    <div class="bg-images no-cover-upload">
                     <img src="<?php echo base_url(WHITEIMAGE); ?>" name="image_src" id="image_src" title="NOIMAGE" />
                    </div>
                     <?php }
                        ?>
                  </div>
               </div>
            </div>
         </div>
         <div class="container tablate-container art-profile  ">
            <?php 

            $userid = $this->session->userdata('aileenuser');

            $id = $this->db->get_where('job_reg', array('slug' =>$this->uri->segment(3)))->row()->user_id;

            if ($userid == $id) { ?>
            <div class="upload-img ">
               <label class="cameraButton"> <span class="tooltiptext">Upload Cover Photo</span><i class="fa fa-camera" aria-hidden="true"></i>
               <input type="file" id="upload" name="upload" accept="image/*;capture=camera" onclick="showDiv()">
               </label>
            </div>
            <?php } ?>
            <div class="profile-photo">
               <div class="profile-pho">
                  <div class="user-pic padd_img">
                     <?php  $filename = $this->config->item('job_profile_thumb_upload_path') . $job[0]['job_user_image'];
                         $s3 = new S3(awsAccessKey, awsSecretKey);
                         $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                      if ($job[0]['job_user_image'] != '' && $info) { ?>
                     <img src="<?php echo JOB_PROFILE_THUMB_UPLOAD_URL . $job[0]['job_user_image']; ?>" alt="<?php echo $job[0]['job_user_image']; ?>" >
                     <?php } else { ?>
                     <?php
                        
                        $a = $job[0]['fname'];
                        $acronym = substr($a, 0, 1);
                        $b = $job[0]['lname'];
                        $acronym1 = substr($b, 0, 1);

                        ?>
                     <div class="post-img-user">
                        <?php echo ucfirst(strtolower($acronym)) . ucfirst(strtolower($acronym1)); ?>
                     </div>
                     <?php } ?>
                     <?php if ($userid == $id) { ?>
                     <a href="javascript:void(0);" class="cusome_upload" onclick="updateprofilepopup();"><img  src="<?php echo base_url(); ?>assets/img/cam.png" alt="Update Profile Picture"> Update Profile Picture</a>
                     <?php } ?>
                  </div>
               </div>
               <div class="job-menu-profile  mob-block">
                  <a  href="javascript: void(0);">
                     <h5 class="profile-head-text"> <?php echo $job[0]['fname'] . ' ' . $job[0]['lname']; ?></h5>
                  </a>
                  <!-- text head start -->
                  <div class="profile-text" >
                     <?php
                        if ($userid == $id) {
                            if ($job[0]['designation'] == '') {
                                ?>
                     <a id="designation" class="designation" title="Designation">Current Work</a>
                     <?php } else {
                        ?> 
                     <a id="designation" class="designation" title="<?php echo ucwords($job[0]['designation']); ?>"><?php echo ucwords($job[0]['designation']); ?></a>
                     <?php
                        }
                        } else {
                        
                        
                        if ($job[0]['designation'] == '') {
                            ?>
                     <a id="designation"> <?php echo "Current Work"; ?> </a> 
                     <?php } else { ?>
                     <a id="designation"> <?php echo ucwords($job[0]['designation']); ?> </a> <?php }
                        }
                        ?>
                  </div>
               </div>
               <?php echo $job_menubar; ?>   
            </div>
         </div>
         <div class="middle-part container res-job-print  ">
         <div class="job-menu-profile job_edit_menu mob-none">
            <a  href="javascript: void(0);" title="<?php echo $job[0]['fname'] . ' ' . $job[0]['lname']; ?>">
               <h3 class="profile-head-text">
                  <?php echo ucfirst($job[0]['fname']) . ' ' . ucfirst($job[0]['lname']); ?> 
               </h3>
            </a>
            <div class="profile-text" >
               <?php
                  if ($userid == $id) {
                      if ($job[0]['designation'] == '') {
                          ?>
               <a id="designation" class="designation" title="Designation">Current Work</a>
               <?php } else {
                  ?> 
               <a id="designation" class="designation" title="<?php echo ucwords($job[0]['designation']); ?>"><?php echo ucwords($job[0]['designation']); ?></a>
               <?php
                  }
                  } else {                  
                  if ($job[0]['designation'] == '') {
                      ?>
               <a id="designation"> <?php echo "Current Work"; ?> </a> 
               <?php } else { ?>
               <a id="designation"> <?php echo ucwords($job[0]['designation']); ?> </a> <?php }
                  }
                  ?>
            </div>
         </div>
        
         <div class="col-md-7 col-sm-12 mob-clear">
          <?php if($userid == $id)
                {
                  if($count_profile == 100)
                  {
                    if($job_reg[0]['progressbar']==0)
                    {
          ?>

          <div class="mob-progressbar" >
               <p>Please fill up your entire profile to get better job options and so that recruiter can find you easily.</p>
               <p class="mob-edit-pro">
                 
                  <a href="javascript:void(0);"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Successfully Completed</a>      
                  
                 
               </p>
               <div class="progress skill-bar ">
                  <div class="progress-bar progress-bar-custom" role="progressbar" aria-valuenow="<?php echo($count_profile);?>" aria-valuemin="0" aria-valuemax="100">
                     <span class="skill"><i class="val"><?php echo(round($count_profile));?>%</i></span>
                  </div>
               </div>
            </div>
            <?php
          }
        }else{

            ?>
            <div class="mob-progressbar" >
               <p>Please fill up your entire profile to get better job options and so that recruiter can find you easily.</p>
               <p class="mob-edit-pro">
                  
                    
                  <a href="<?php echo base_url('job/basic-information')?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Profile</a>
                  
                    
               </p>
               <div class="progress skill-bar ">
                  <div class="progress-bar progress-bar-custom" role="progressbar" aria-valuenow="<?php echo($count_profile);?>" aria-valuemin="0" aria-valuemax="100">
                     <span class="skill"><i class="val"><?php echo(round($count_profile));?>%</i></span>
                  </div>
               </div>
            </div>

            <?php
          }}
          ?>
            <div class="">
               <div class="common-form">
                  <div class="job-saved-box">
                     <h3>Details</h3>
                     <div class=" fr rec-edit-pro">
                        <ul>
                        </ul>
                     </div>
                     <div class="contact-frnd-post">
                        <div class="job-contact-frnd ">
                           <div class="profile-job-post-detail clearfix">
                              <div class="profile-job-post-title-inside clearfix">
                              </div>
                              <div class="profile-job-post-title clearfix">
                                 <div class="profile-job-profile-button clearfix">
                                    <div class="profile-job-details">
                                       <ul>
                                          <li>
                                             <p class="details_all_tital"> Basic Information</p>
                                          </li>
                                       </ul>
                                    </div>
                                 </div>
                                 <div class="profile-job-profile-menu">
                                    <ul class="clearfix " >
                                       <li> <b> Name </b> <span class="text_blur"> <?php echo ucfirst($job[0]['fname']); ?> <?php echo ucfirst($job[0]['lname']); ?></span>
                                       </li>
                                       <li> <b>Email </b><span class="text_blur"> <?php echo $job[0]['email']; ?> </span>
                                       </li>
                                       <?php
                                          if ($userid != $id) {
                                          
                                              if ($job[0]['phnno']) {
                                                  ?>
                                       <li><b> Phone Number</b> <span class="text_blur"><?php echo $job[0]['phnno']; ?></span> </li>
                                       <?php
                                          } else {
                                              echo "";
                                          }
                                          } else {
                                          if ($job[0]['phnno']) {
                                              ?>
                                       <li><b> Phone Number</b> <span class="text_blur"><?php echo $job[0]['phnno']; ?></span> </li>
                                       <?php
                                          } else {
                                              ?>
                                       <li><b> Phone Number</b> <span>
                                          <?php
                                             echo PROFILENA;
                                             }
                                             }
                                             ?>
                                          </span>
                                       </li>
                                       <?php
                                          if ($userid != $id) {
                                          
                                              if ($job[0]['language']) 
                                              {
                                          ?>
                                       <li> <b>Language </b><span class="text_blur">  
                                          <?php
                                             $aud = $job[0]['language'];
                                             
                                             $aud_res = explode(',', $aud);
                                             foreach ($aud_res as $lan) {
                                             
                                                 $cache_time = $this->db->get_where('language', array('language_id' => $lan))->row()->language_name;
                                                 $language1[] = $cache_time;
                                             }
                                             $listFinal = implode(', ', $language1);
                                             echo $listFinal;
                                             ?>
                                          </span>
                                       </li>
                                       <?php
                                          }else {
                                              echo "";
                                          }
                                          } 
                                          
                                          else
                                          {
                                          
                                          ?>
                                       <li> <b>Language</b>
                                          <span class="text_blur"> 
                                          <?php 
                                             if($job[0]['language'])
                                             {
                                                 $aud = $job[0]['language'];
                                             
                                                 $aud_res = explode(',', $aud);
                                                 foreach ($aud_res as $lan) {
                                             
                                                     $cache_time = $this->db->get_where('language', array('language_id' => $lan))->row()->language_name;
                                                     $language1[] = $cache_time;
                                                 }
                                                 $listFinal = implode(', ', $language1);
                                                 echo $listFinal;
                                             }
                                             else
                                              echo PROFILENA;
                                             
                                             }
                                             ?>
                                          </span>                                               
                                       </li>
                                       <?php
                                          if ($userid != $id) {
                                          
                                              if ($job[0]['dob'] != '0000-00-00') 
                                              {
                                          ?>
                                       <li> <b>Date Of Birth</b><span class="text_blur">  
                                          <?php echo date('d/m/Y', strtotime($job[0]['dob'])); 
                                             ?>
                                          </span>
                                       </li>
                                       <?php
                                          }else {
                                              echo "";
                                          }
                                          } 
                                          
                                          else
                                          {
                                          
                                          ?>
                                       <li> <b>Date Of Birth</b>
                                          <span class="text_blur"> 
                                          <?php 
                                             if($job[0]['dob'] != '0000-00-00')
                                             {
                                                  echo date('d/m/Y', strtotime($job[0]['dob'])); 
                                             }
                                             else
                                              echo PROFILENA;
                                             
                                             }
                                             ?>
                                          </span>                                               
                                       </li>
                                       <?php
                                          if ($userid != $id) {
                                          
                                              if ($job[0]['gender']) 
                                              {
                                          ?>
                                       <li> <b>Gender</b><span class="text_blur">  
                                          <?php echo ucfirst($job[0]['gender']); ?>
                                          </span>
                                       </li>
                                       <?php
                                          }else {
                                              echo "";
                                          }
                                          } 
                                          
                                          else
                                          {
                                          
                                          ?>
                                       <li> <b>Gender</b>
                                          <span class="text_blur"> 
                                          <?php 
                                             if($job[0]['gender'])
                                             {
                                                   echo ucfirst($job[0]['gender']); 
                                             }
                                             else
                                              echo PROFILENA;
                                             
                                             }
                                             ?>
                                          </span>                                               
                                       </li>
                                       <?php
                                          if ($userid != $id) {
                                          
                                              if ($job[0]['city_id']) {
                                                  ?>
                                       <li><b> City</b> <span class="text_blur"><?php
                                          $cache_time = $this->db->get_where('cities', array('city_id' => $job[0]['city_id']))->row()->city_name;
                                          echo $cache_time;
                                                  ?></span> </li>
                                       <?php
                                          } else {
                                              echo "";
                                          }
                                          } else {
                                          if ($job[0]['city_id']) {
                                              ?>
                                       <li><b> City</b> <span class="text_blur"><?php
                                          $cache_time = $this->db->get_where('cities', array('city_id' => $job[0]['city_id']))->row()->city_name;
                                          echo $cache_time;
                                          ?></span> </li>
                                       <?php
                                          } else {
                                              ?>
                                       <li><b> City</b> <span>
                                          <?php
                                             echo PROFILENA;
                                             }
                                             }
                                             ?>
                                          <?php
                                             if ($userid != $id) {
                                             
                                                 if ($job[0]['pincode']) {
                                                     ?></span>
                                       </li>
                                       <li> <b>Pincode </b><span class="text_blur"><?php echo $job[0]['pincode']; ?></span>
                                       </li>
                                       <?php
                                          } else {
                                              echo "";
                                          }
                                          } else {
                                          if ($job[0]['pincode']) {
                                              ?>
                                       <li> <b>Pincode </b><span class="text_blur"><?php echo $job[0]['pincode']; ?></span>
                                       </li>
                                       <?php
                                          } else {
                                              ?>
                                       <li> <b>Pincode </b><span>
                                          <?php
                                             echo PROFILENA;
                                             }
                                             }
                                             ?>
                                          </span>
                                       </li>
                                       <?php
                                          if ($userid != $id) {
                                          
                                              if ($job[0]['address']) {
                                          ?>
                                       <li>
                                          <b>Address </b>
                                          <span class="text_blur">
                                             <pre><?php echo $job[0]['address']; ?></pre>
                                          </span>
                                       </li>
                                       <?php
                                          } else {
                                              echo "";
                                          }
                                          } 
                                          else 
                                          {
                                          if ($job[0]['address']) {
                                              ?>
                                       <li>
                                          <b>Address </b>
                                          <span class="text_blur">
                                             <pre><?php echo $job[0]['address']; ?></pre>
                                          </span>
                                       </li>
                                       <?php
                                          }else {
                                          ?>
                                       <li> <b>Address </b><span>
                                          <?php
                                             echo PROFILENA;
                                             }
                                             }
                                             ?>
                                          </span>
                                       </li>
                                    </ul>
                                 </div>
                              </div>
                              <?php
                                 if($userid == $id && ($job_add_edu[0]['board_primary'] == "" && $job_add_edu[0]['board_secondary'] == "" && $job_add_edu[0]['board_higher_secondary'] == "" && $jobgrad[0]['degree'] == "" ))
                                 {
                                 ?>
                              <div class="profile-job-post-title clearfix">
                                 <div class="profile-job-profile-button clearfix">
                                    <div class="profile-job-details">
                                       <ul>
                                          <li>
                                             <p class="details_all_tital"> Education
                                             </p>
                                          </li>
                                       </ul>
                                    </div>
                                 </div>
                                 <div class="profile-job-profile-menu">
                                    <ul class="clearfix">
                                       <div class="text-center">
                                          <a href="<?php echo base_url('job/qualification');?>">Click Here To fill Up Education Detail</a>
                                       </div>
                                    </ul>
                                 </div>
                              </div>
                              <?php 
                                 } else
                                  {
                                 if(($job_add_edu || $jobgrad) || ($userid != $id && ($job_add_edu || $jobgrad)))
                                 {
                                 ?>
                              <div class="profile-job-post-title clearfix">
                                 <div class="profile-job-profile-button clearfix">
                                    <div class="profile-job-details">
                                       <ul>
                                          <li>
                                             <p class="details_all_tital"> Education
                                             </p>
                                          </li>
                                       </ul>
                                    </div>
                                 </div>
                                 <div class="profile-job-profile-menu " id="job_add_education">
                                    <ul class="clearfix">
                                       <!--Primary Start-->
                                       <?php
                                          if ($job_add_edu) {
                                              if ($job_add_edu[0]['board_primary']) {
                                          ?>
                                       <div class="text-center">
                                          <h5 class="head_title">Primary Education</h5>
                                       </div>
                                       <li> <b>Board </b><span class="text_blur"> <?php echo $job_add_edu[0]['board_primary']; ?></span>
                                       </li>
                                       <li> <b>School </b><span class="text_blur"> <?php echo $job_add_edu[0]['school_primary']; ?></span>
                                       </li>
                                       <li> <b>Percentage </b><span class="text_blur"> <?php echo $job_add_edu[0]['percentage_primary']; ?>%</span>
                                       </li>
                                       <li> <b>Year of Passing </b><span class="text_blur"> <?php echo $job_add_edu[0]['pass_year_primary']; ?></span>
                                       </li>
                                       <?php
                                          if ($job_add_edu[0]['edu_certificate_primary'] != "") {
                                          ?>
                                       <li>
                                          <b>Education Certificate </b>
                                          <span>
                                          <?php
                                             if ($job_add_edu[0]['edu_certificate_primary']) {
                                             $ext = explode('.', $job_add_edu[0]['edu_certificate_primary']);
                                             if ($ext[1] == 'pdf') {
                                             ?>
                                          <a title="open pdf" href="<?php echo JOB_EDU_MAIN_UPLOAD_URL . $job_add_edu[0]['edu_certificate_primary'] ?>"><i class="fa fa-file-pdf-o fa-2x" style="color: red; padding-left: 8px; padding-top: 10px; padding-bottom: 10px; position: relative;" aria-hidden="true"></i></a>
                                          <?php
                                             } else {
                                             ?>
                                          <a class="example-image-link" href="<?php echo JOB_EDU_MAIN_UPLOAD_URL . $job_add_edu[0]['edu_certificate_primary'] ?>" data-lightbox="example-1">certificate </a>
                                          <?php
                                             }//else complete
                                             }
                                             ?>
                                          </span>
                                       </li>
                                       <div id="fade" onClick="lightbox_close();"></div>
                                       <?php
                                          }//if($job_add_edu[0]['edu_certificate_primary']) end
                                          ?>
                                       <?php
                                          }//if($job_add_edu[0]['board_primary']) end
                                          }//if($job_add_edu) end
                                          ?>
                                       <!--Primary End-->
                                       <!--Secondary Start-->
                                       <?php
                                          if ($job_add_edu[0]['board_secondary']) {
                                          ?>
                                       <div class="text-center">
                                          <h5 class="head_title">Secondary Education</h5>
                                       </div>
                                       <li> <b>Board </b><span class="text_blur"> <?php echo $job_add_edu[0]['board_secondary']; ?></span>
                                       </li>
                                       <li> <b>School </b><span class="text_blur"> <?php echo $job_add_edu[0]['school_secondary']; ?></span>
                                       </li>
                                       <li> <b>Percentage </b><span class="text_blur"> <?php echo $job_add_edu[0]['percentage_secondary']; ?>%</span>
                                       </li>
                                       <li> <b>Year of Passing </b><span class="text_blur"> <?php echo $job_add_edu[0]['pass_year_secondary']; ?></span>
                                       </li>
                                       <?php
                                          if ($job_add_edu[0]['edu_certificate_secondary'] != "") {
                                          ?>
                                       <li>
                                          <b>Education Certificate </b>
                                          <span>
                                          <?php
                                             if ($job_add_edu[0]['edu_certificate_secondary']) {
                                              $ext = explode('.', $job_add_edu[0]['edu_certificate_secondary']);
                                              if ($ext[1] == 'pdf') {
                                             ?>
                                          <a title="open pdf" href="<?php echo JOB_EDU_MAIN_UPLOAD_URL . $job_add_edu[0]['edu_certificate_secondary'] ?>"><i class="fa fa-file-pdf-o fa-2x" style="color: red; padding-left: 8px; padding-top: 10px; padding-bottom: 10px; position: relative;" aria-hidden="true"></i></a>
                                          <?php
                                             } else {
                                             ?>
                                          <a class="example-image-link" href="<?php echo JOB_EDU_MAIN_UPLOAD_URL . $job_add_edu[0]['edu_certificate_secondary'] ?>" data-lightbox="example-1">certificate </a>
                                          <?php
                                             }
                                             }
                                                                                 ?>
                                          </span>
                                       </li>
                                       <?php
                                          }// if ($job_add_edu[0]['edu_certificate_secondary'] != "")end
                                          ?>
                                       <?php
                                          }//if($job_add_edu[0]['board_secondary']) end
                                          ?>
                                       <!--Secondary End-->
                                       <!-- Higher Secondary Start-->
                                       <?php
                                          if($job_add_edu[0]['board_higher_secondary']) {
                                          ?>
                                       <div class="text-center">
                                          <h5 class="head_title">Higher secondary Education</h5>
                                       </div>
                                       <li> <b>Board </b><span class="text_blur"> <?php echo $job_add_edu[0]['board_higher_secondary']; ?></span>
                                       </li>
                                       <li> <b>Stream</b><span class="text_blur"> <?php echo $job_add_edu[0]['stream_higher_secondary']; ?></span>
                                       </li>
                                       <li> <b>School </b><span class="text_blur"> <?php echo $job_add_edu[0]['school_higher_secondary']; ?></span>
                                       </li>
                                       <li> <b>Percentage </b><span class="text_blur"> <?php echo $job_add_edu[0]['percentage_higher_secondary']; ?>%</span>
                                       </li>
                                       <li> <b>Year of Passing </b><span class="text_blur"> <?php echo $job_add_edu[0]['pass_year_higher_secondary']; ?></span>
                                       </li>
                                       <?php
                                          if ($job_add_edu[0]['edu_certificate_higher_secondary'] != "") {
                                          ?>
                                       <li>
                                          <b>Education Certificate </b>
                                          <span>
                                          <?php
                                             if ($job_add_edu[0]['edu_certificate_higher_secondary']) 
                                             {
                                                 $ext = explode('.', $job_add_edu[0]['edu_certificate_higher_secondary']);
                                                 if ($ext[1] == 'pdf') {
                                             ?>
                                          <a title="open pdf" href="<?php echo JOB_EDU_MAIN_UPLOAD_URL . $job_add_edu[0]['edu_certificate_higher_secondary'] ?>"><i class="fa fa-file-pdf-o fa-2x" style="color: red; padding-left: 8px; padding-top: 10px; padding-bottom: 10px; position: relative;" aria-hidden="true"></i></a>
                                          <?php
                                             } else {
                                             ?>
                                          <a class="example-image-link" href="<?php echo JOB_EDU_MAIN_UPLOAD_URL . $job_add_edu[0]['edu_certificate_higher_secondary'] ?>" data-lightbox="example-1">certificate </a>
                                          <?php
                                             }
                                             }
                                             ?>
                                          </span>
                                       </li>
                                       <li>
                                          <div>
                                             <a class="example-image-link" style="width: 200px; height: 200px;" href="http://lokeshdhakar.com/projects/lightbox2/images/image-1.jpg" data-lightbox="example-1"></a>
                                             <a class="example-image-link" style="width: 200px; height: 200px;" href="http://localhost/aileensoul/uploads/user_bg/main/16711487_1337552009638693_3483784836973951976_n.jpg" data-lightbox="example-1"></a>
                                          </div>
                                       </li>
                                       <?php
                                          }// if ($job_add_edu[0]['edu_certificate_higher_secondary'] != "") end
                                          ?>
                                       <?php
                                          }//if($job_add_edu[0]['board_higher_secondary']) End
                                          ?>
                                       <!-- Higher Secondary End-->
                                       <!-- Degree Start -->
                                       <?php if ($jobgrad) 
                                          { 
                                          ?>
                                       <div class="text-center">
                                          <h5 class="head_title">Graduation</h5>
                                       </div>
                                       <?php
                                          $i = 1;
                                          foreach ($jobgrad as $graduation) {
                                          if ($graduation['degree']) {
                                          ?>
                                       <div id="gra<?php echo $i; ?>" class="tabcontent data_exp">
                                          <li> <b> Degree</b> 
                                             <span class="text_blur">
                                             <?php
                                                $cache_time = $this->db->get_where('degree', array('degree_id' => $graduation['degree']))->row()->degree_name;
                                                echo $cache_time;
                                                ?> 
                                             </span>
                                          </li>
                                          <li> <b>Stream </b>
                                             <span class="text_blur">
                                             <?php
                                                $cache_time = $this->db->get_where('stream', array('stream_id' => $graduation['stream']))->row()->stream_name;
                                                echo $cache_time;
                                                ?>
                                             </span>
                                          </li>
                                          <li><b> University</b> 
                                             <span class="text_blur">
                                             <?php
                                                $cache_time = $this->db->get_where('university', array('university_id' => $graduation['university']))->row()->university_name;
                                                echo $cache_time;
                                                ?>
                                             </span> 
                                          </li>
                                          <li> <b>College  </b><span class="text_blur"><?php echo $graduation['college']; ?></span>
                                          </li>
                                          <?php
                                             if ($userid != $id) 
                                             {
                                             
                                                 if ($graduation['grade']) 
                                             {
                                             ?>
                                          <li> <b>Grade </b><span class="text_blur"><?php echo ucwords($graduation['grade']); ?></span>
                                          </li>
                                          <?php
                                             } else   {
                                                          echo "";
                                                     }
                                             } 
                                             else 
                                             {
                                             if ($graduation['grade'])
                                             {
                                             ?>
                                          <li> <b>Grade </b><span class="text_blur"><?php echo ucwords($graduation['grade']); ?></span>
                                          </li>
                                          <?php
                                             } 
                                             else 
                                             {
                                             ?>
                                          <li><b> Grade</b> 
                                             <span>
                                             <?php
                                                echo ucwords(PROFILENA);
                                                    }
                                                }//else complete
                                                ?>
                                             </span>
                                          </li>
                                          <li> <b>Percentage </b><span class="text_blur"><?php echo $graduation['percentage']; ?>%</span>
                                          </li>
                                          <li> <b>Year Of Passing </b><span class="text_blur"><?php echo $graduation['pass_year']; ?></span>
                                          </li>
                                          <?php
                                             if ($graduation['edu_certificate'] != "") 
                                             {
                                             ?>
                                          <li><b>Education Certificate </b> 
                                             <span>  
                                             <?php
                                                $ext = explode('.', $graduation['edu_certificate']);
                                                                                          if ($ext[1] == 'pdf') {
                                                                                      ?>
                                             <a title="open pdf" href="<?php echo JOB_EDU_MAIN_UPLOAD_URL . $graduation['edu_certificate'] ?>"><i class="fa fa-file-pdf-o fa-2x" style="color: red; padding-left: 8px; padding-top: 10px; padding-bottom: 10px; position: relative;" aria-hidden="true"></i></a>
                                             <?php
                                                } else {
                                                ?>
                                             <a class="example-image-link" href="<?php echo JOB_EDU_MAIN_UPLOAD_URL . $graduation['edu_certificate'] ?>" data-lightbox="example-1">certificate <?php echo $new; ?></a>
                                             <?php
                                                }
                                                ?>
                                             </span>
                                          </li>
                                          <?php
                                             }//if($graduation['edu_certificate'] != "")end
                                             ?>
                                       </div>
                                       <?php
                                          }
                                          $i++;
                                          }//For loop end
                                          ?> 
                                       <div class="tab pagi_exp" onload="openCity(event, 'gra1')">
                                          <?php   if (count($jobgrad) > 1) 
                                             { 
                                             ?>
                                          <button class="tablinks  " onclick="openCity(event, 'gra1')">1</button>
                                          <?php   } ?>
                                          <?php if (count($jobgrad) >= 2) 
                                             { 
                                             ?>
                                          <button class="tablinks" onclick="openCity(event, 'gra2')">2</button>
                                          <?php   } 
                                             if (count($jobgrad) >= 3) 
                                             { 
                                             ?>
                                          <button class="tablinks" onclick="openCity(event, 'gra3')">3</button>
                                          <?php   } 
                                             ?>
                                          <?php   if (count($jobgrad) >= 4) 
                                             { 
                                             ?>
                                          <button class="tablinks" onclick="openCity(event, 'gra4')">4</button>
                                          <?php   } 
                                             ?>
                                          <?php   if (count($jobgrad) >= 5) 
                                             {
                                             ?>
                                          <button class="tablinks" onclick="openCity(event, 'gra5')">5</button>
                                          <?php   } 
                                             ?>
                                       </div>
                                       <?php
                                          }//if ($jobgrad) end
                                          ?>
                                       <!-- Degree End -->
                                    </ul>
                                    <!-- Above all data put -->
                                 </div>
                                 <!-- profile-job-profile-menu primary-->
                              </div>
                              <!-- profile-job-post-title clearfix -->
                              <?php
                                 }
                                  }//education else part end
                                 if($userid == $id && ($job[0]['project_name'] == "" && $job[0]['project_duration'] == "" && $job[0]['project_description'] == "" && $job[0]['training_as'] == "" && $job[0]['training_duration'] == "" && $job[0]['training_organization'] == "" ))
                                        
                                 {
                                      ?>
                              <div class="profile-job-post-title-inside clearfix">
                              </div>
                              <div class="profile-job-post-title clearfix">
                                 <div class="profile-job-profile-button clearfix">
                                    <div class="profile-job-details">
                                       <ul>
                                          <li>
                                             <p class="details_all_tital"> Project And Training / Internship
                                             </p>
                                          </li>
                                       </ul>
                                    </div>
                                 </div>
                                 <div class="profile-job-profile-menu">
                                    <ul class="clearfix">
                                       <div class="text-center">
                                          <a href="<?php echo base_url('job/project');?>">Click Here To fill Up Project And Training / Internship Detail</a>
                                       </div>
                                    </ul>
                                 </div>
                              </div>
                              <?php 
                                 }
                                     else
                                     {
                                         if(($job[0]['project_name'] != "" || $job[0]['project_duration'] != "" || $job[0]['project_description'] != "" || $job[0]['training_as'] != "" || $job[0]['training_duration'] != "" || $job[0]['training_organization'] != "") || ($userid != $id && ($job[0]['project_name'] != "" || $job[0]['project_duration'] != "" || $job[0]['project_description'] != "" || $job[0]['training_as'] != "" || $job[0]['training_duration'] != "" || $job[0]['training_organization'] != "")))
                                         {
                                 ?>
                             
                              <?php
                                 if ($userid != $id) {
                                 
                                 
                                     if ($job[0]['project_name'] != "" || $job[0]['project_duration'] != "" || $job[0]['project_description'] != "" || $job[0]['training_as'] != "" || $job[0]['training_duration'] != "" || $job[0]['training_organization'] != "") {
                                         ?>
                              <div class="profile-job-post-title clearfix">
                                 <div class="profile-job-profile-button clearfix">
                                    <div class="profile-job-details">
                                       <ul>
                                          <li>
                                             <p class="details_all_tital">Project And Training / Internship</p>
                                          </li>
                                       </ul>
                                    </div>
                                 </div>
                                 <div class="profile-job-profile-menu">
                                    <ul class="clearfix">
                                       <?php if($job[0]['project_name'] != "" || $job[0]['project_duration'] != "" || $job[0]['project_description'] != "")
                                          {
                                          ?>
                                       <li>
                                          <div class="text-center">
                                             <h5 class="head_title">Project</h5>
                                          </div>
                                       </li>
                                       <?php
                                          }
                                          ?>
                                       <?php
                                          if ($job[0]['project_name']) {
                                              ?>
                                       <li> <b> Project Name (Title)</b> <span class="text_blur"><?php echo $job[0]['project_name']; ?></span>
                                       </li>
                                       <?php
                                          } else {
                                              echo "";
                                          }
                                          ?>
                                       <?php
                                          if ($job[0]['project_duration']) {
                                              ?>
                                       <li> <b>Duration</b><span class="text_blur"><?php echo $job[0]['project_duration']; ?> month</span>
                                       </li>
                                       <?php
                                          } else {
                                              echo "";
                                          }
                                          ?>
                                       <?php
                                          if ($job[0]['project_description']) {
                                              ?>
                                       <li>
                                          <b>Project Description</b> 
                                          <span class="text_blur">
                                             <pre class="text_blur"><?php echo $this->common->make_links($job[0]['project_description']); ?></pre>
                                          </span>
                                       </li>
                                       <?php
                                          } else {
                                              echo "";
                                          }
                                          ?><br>
                                       <?php if($job[0]['training_as'] != "" || $job[0]['training_duration'] != "" || $job[0]['training_organization'] != "")
                                          {
                                          ?>
                                       <li>
                                          <div class="text-center">
                                             <h5 class="head_title">Training / Internship</h5>
                                          </div>
                                       </li>
                                       <?php } ?>
                                       <?php
                                          if ($job[0]['training_as']) {
                                              ?>
                                       <li> <b>Intern / Trainee As </b><span class="text_blur"><?php echo $this->common->make_links($job[0]['training_as']); ?></span>
                                       </li>
                                       <?php
                                          } else {
                                              echo "";
                                          }
                                          ?>
                                       <?php
                                          if ($job[0]['training_duration']) {
                                              ?>
                                       <li> <b>Duration</b><span class="text_blur"> <?php echo $job[0]['training_duration']; ?> month</span>
                                       </li>
                                       <?php
                                          } else {
                                              echo "";
                                          }
                                          ?>
                                       <?php
                                          if ($job[0]['training_organization']) {
                                              ?>
                                       <li> <b>Name of Organization</b><span class="text_blur"> <?php echo $this->common->make_links($job[0]['training_organization']); ?></span>
                                       </li>
                                       <?php
                                          } else {
                                              echo "";
                                          }
                                          ?>
                                    </ul>
                                 </div>
                                 <?php
                                    }
                                    } else {
                                    
                                    if ($job[0]['project_name'] != "" || $job[0]['project_duration'] != "" || $job[0]['project_description'] != "" || $job[0]['training_as'] != "" || $job[0]['training_duration'] != "" || $job[0]['training_organization'] != "") {
                                        ?>
                                 <div class="profile-job-post-title clearfix">
                                    <div class="profile-job-profile-button clearfix">
                                       <div class="profile-job-details">
                                          <ul>
                                             <li>
                                                <p class="details_all_tital">Project And Training / Internship</p>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                    <div class="profile-job-profile-menu">
                                       <ul class="clearfix">
                                          <li>
                                             <div class="text-center">
                                                <h5 class="head_title">Project</h5>
                                             </div>
                                          </li>
                                          <?php
                                             if ($job[0]['project_name']) {
                                                 ?>
                                          <li> <b> Project Name (Title)</b> <span class="text_blur"><?php echo $job[0]['project_name']; ?></span>
                                          </li>
                                          <?php
                                             } else {
                                                 ?>
                                          <li><b> Project Name (Title)</b> <span>
                                             <?php
                                                echo PROFILENA;
                                                }
                                                ?>
                                             <?php
                                                if ($job[0]['project_duration']) {
                                                    ?>
                                             </span>
                                          </li>
                                          <li> <b>Duration</b><span class="text_blur"><?php echo $job[0]['project_duration']; ?> month</span>
                                          </li>
                                          <?php
                                             } else {
                                                 ?>
                                          <li><b> Duration</b> <span>
                                             <?php
                                                echo PROFILENA;
                                                }
                                                ?>
                                             <?php
                                                if ($job[0]['project_description']) {
                                                    ?>
                                             </span>
                                          </li>
                                          <li>
                                             <b>Project Description</b> 
                                             <span class="text_blur">
                                                <pre><?php echo $this->common->make_links($job[0]['project_description']); ?></pre>
                                             </span>
                                          </li>
                                          <?php
                                             } else {
                                                 ?>
                                          <li><b> Project Description</b> <span>
                                             <?php
                                                echo PROFILENA;
                                                }
                                                ?>
                                             <br>
                                             </span>
                                          </li>
                                          <li>
                                             <div class="text-center">
                                                <h5 class="head_title">Training / Internship</h5>
                                             </div>
                                          </li>
                                          <?php
                                             if ($job[0]['training_as']) {
                                                 ?>
                                          <li> <b>Intern / Trainee As </b><span class="text_blur"><?php echo $this->common->make_links($job[0]['training_as']); ?></span>
                                          </li>
                                          <?php
                                             } else {
                                                 ?>
                                          <li><b>Intern / Trainee As</b> <span>
                                             <?php
                                                echo PROFILENA;
                                                }
                                                ?>
                                             <?php
                                                if ($job[0]['training_duration']) {
                                                    ?></span>
                                          </li>
                                          <li> <b>Duration</b><span class="text_blur"> <?php echo $job[0]['training_duration']; ?> month</span>
                                          </li>
                                          <?php
                                             } else {
                                                 ?>
                                          <li><b>Duration</b> <span class="text_blur">
                                             <?php
                                                echo PROFILENA;
                                                }
                                                ?>
                                             <?php
                                                if ($job[0]['training_organization']) {
                                                    ?>
                                             </span>
                                          </li>
                                          <li> <b>Name of Organization</b><span class="text_blur"> <?php echo $this->common->make_links($job[0]['training_organization']); ?></span>
                                          </li>
                                          <?php
                                             } else {
                                                 ?>
                                          <li><b>Name of Organization</b> <span>
                                             <?php
                                                echo PROFILENA;
                                                }
                                                ?>
                                             </span>
                                          </li>
                                       </ul>
                                    </div>
                                 </div>
                                 <!-- profile-job-post-title clearfix -->
                                 <?php
                                    }
                                    }
                                    }
                                    }
                                    ?>
                                 <div class="profile-job-post-title clearfix">
                                    <div class="profile-job-profile-button clearfix">
                                       <div class="profile-job-details">
                                          <ul>
                                             <li>
                                                <p class="details_all_tital"> Work Area</p>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                    <div class="profile-job-profile-menu">
                                       <ul class="clearfix">
                                          <?php
                                             if ($job[0]['work_job_title']) {
                                                 $contition_array = array('title_id' => $job[0]['work_job_title']);
                                                 $jobtitle = $this->common->select_data_by_condition('job_title', $contition_array, $data = 'name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                 ?>
                                          <li> <b> Job Title</b> <span class="text_blur">
                                             <?php echo $jobtitle[0]['name']; ?>
                                             </span>
                                          </li>
                                          <?php } ?>
                                          <?php
                                             if ($job[0]['keyskill']) {
                                             
                                                 ?>
                                          <li> <b> Skills</b> <span class="text_blur">
                                             <?php
                                                $comma = ", ";
                                                $k = 0;
                                                $aud = $job[0]['keyskill'];
                                                $aud_res = explode(',', $aud);
                                                foreach ($aud_res as $skill) {
                                                    if ($k != 0) 
                                                    {
                                                             echo $comma;
                                                
                                                    }
                                                
                                                    $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;
                                                     
                                                      echo $cache_time;
                                                      $k++;
                                                   
                                                }
                                                
                                                ?>
                                             </span>
                                          </li>
                                          <?php } ?>
                                          <?php
                                             if ($job[0]['work_job_industry']) {
                                                 $contition_array = array('industry_id' => $job[0]['work_job_industry']);
                                                 $industry = $this->common->select_data_by_condition('job_industry', $contition_array, $data = 'industry_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                 ?>
                                          <li> <b> Industry</b> <span class="text_blur">
                                             <?php echo $industry[0]['industry_name']; ?>
                                             </span>
                                          </li>
                                          <?php } ?>
                                          <?php
                                             if ($job[0]['work_job_city']) {
                                                
                                                 ?>
                                          <li> <b> Preferred Cites</b> <span class="text_blur">                                      
                                             <?php
                                                $comma = ", ";
                                                $k = 0;
                                                $aud = $job[0]['work_job_city'];
                                                $aud_res = explode(',', $aud);
                                                $count= 0;
                                                
                                                foreach ($aud_res as $city) 
                                                {
                                                    
                                                if ($k != 0 && $count != count($aud_res)) 
                                                {
                                                        echo $comma;
                                                       
                                                }
                                                
                                                $cache_time = $this->db->get_where('cities', array('city_id' => $city))->row()->city_name;
                                                                                             
                                                echo $cache_time;
                                                $count=  $k++; 
                                                $k++;      
                                                                                
                                                }
                                                
                                                ?>               
                                             </span>
                                          </li>
                                          <?php } ?> 
                                       </ul>
                                    </div>
                                 </div>
                                 <!-- profile-job-post-title clearfix -->
                                 <!-- Experience Part Start-->
                                 <?php if ($job[0]['experience'] == "Experience" ) 
                                    { 
                                            ?>
                                 <div class="profile-job-post-title clearfix">
                                    <?php
                                       if($job[0]['experience'] == "Experience" && $job_work[0]['jobtitle'] == "")
                                       {
                                       ?>
                                    <div class="profile-job-post-title-inside clearfix">
                                    </div>
                                    <div class="profile-job-post-title clearfix">
                                       <div class="profile-job-profile-button clearfix">
                                          <div class="profile-job-details">
                                             <ul>
                                                <li>
                                                   <p class="details_all_tital">Work Experience
                                                   </p>
                                                </li>
                                             </ul>
                                          </div>
                                       </div>
                                         <div class="profile-job-profile-menu">                          
                                        <ul class="clearfix">
                                          

                                        <ul class="clearfix">
                                           <?php   if($job[0]['experience'] == 'Experience'){  ?>
                                          <li> <b> Total Experience</b> <span class="text_blur">

                                            <?php  if($job[0]['exp_y'] != " " && $job[0]['exp_m'] != " "){ 

                       if ($job[0]['exp_m'] == '12 month' && $job[0]['exp_y'] == '0 year') {
                                                    echo "1 year";
                                                } else {
                                                if($job[0]['exp_y'] != '0 year'){
                                                    echo $job[0]['exp_y'];
                                                }
                                                    if ($job[0]['exp_m'] != '0 month') {
                                                        echo ' ' . $job[0]['exp_m'];
                                                    } 
                                                }
                                             } ?> </span>
                                          </li>
                                         <?php } ?>
                                       </ul>
                                       
                                       </ul>
                                     </div>





  <?php if($userid == $id) { ?>
                                       <div class="profile-job-profile-menu">
                                          <ul class="clearfix">
                                             <div class="text-center">
                                                <a href="<?php echo base_url('job/work-experience');?>">Click Here To fill Up Work Experience Detail</a>
                                             </div>
                                          </ul>
                                       </div>
                                       <?php } ?>
                                    </div>
                                    <?php
                                       }
                                       else
                                       {
                                       
                                       
                                       ?>
                                    <?php if ($job_work) {   ?>
                                    <div class="profile-job-profile-button clearfix">
                                       <div class="profile-job-details">
                                          <ul>
                                             <li>
                                                <p class="details_all_tital"> Work Experience</p>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                    <div class="profile-job-profile-menu" id="job_workexp">
                                       <ul>
                                          <li>
                                             <b> Total Experience </b>
                                             <span class="text_blur">
                                             <?php
                                             
                                             if($job[0]['exp_y'] != " " && $job[0]['exp_m'] != " "){ 
                                                $total_work_year = 0;
                                                $total_work_month = 0;
                                                foreach ($job_work as $work1) {
                                                
                                                    $total_work_year += $work1['experience_year'];
                                                    $total_work_month += $work1['experience_month'];
                                                }
                                                
                                                if ($total_work_month == '12 month' && $total_work_year == '0 year') {
                                                    echo "1 year";
                                                } else {
                                                    $month = explode(' ', $total_work_year);
                                                    //print_r($month);
                                                    $year = $month[0];
                                                    $y = 0;
                                                    for ($i = 0; $i <= $y; $i++) {
                                                        if ($total_work_month >= 12) {
                                                            $year = $year + 1;
                                                            $total_work_month = $total_work_month - 12;
                                                            $y++;
                                                        } else {
                                                            $y = 0;
                                                        }
                                                    }
                                                
                                                
                                                    echo $year;
                                                    echo "&nbsp";
                                                    echo "Year";
                                                    echo "&nbsp";
                                                    if ($total_work_month != 0) {
                                                        echo $total_work_month;
                                                        echo "&nbsp";
                                                        echo "Month";
                                                    }
                                                } 
                                                }
                                    }else{  
                                        if ($userdata[0]['exp_m'] == '12 month' && $userdata[0]['exp_y'] == '0 year') {
                                                    echo "1 year";
                                                } else {
                                                  
                                                if($userdata[0]['exp_y'] != '0 year'){
                                                    echo $userdata[0]['exp_y'];
                                                }
                                                    if ($userdata[0]['exp_m'] != '0 month') {
                                                        echo ' ' . $userdata[0]['exp_m'];
                                                        
                                                    } 
                                                }
                                    }
                                                ?> 
                                             </span>
                                          </li>
                                       </ul>
                                    </div>
                                    <?php
                                       }
                                           $total_work_year = 0;
                                           $total_work_month = 0;
                                           $i = 6;
                                       
                                           foreach ($job_work as $work) {
                                               ?>
                                    <div id="work<?php echo $i; ?>" class="tabcontent1 data_exp">
                                       <div class="profile-job-profile-menu" id="job_workexp">
                                          <ul class="clearfix job_paddtop">
                                             <?php
                                                if ($work['experience'] == "Experience") {
                                                    ?>           
                                             <li> <b> Job Title </b> <span class="text_blur"> <?php echo $work['jobtitle']; ?> </span>
                                             </li>
                                             <?php
                                                }
                                                if ($work['experience'] == "Experience") {
                                                    ?> 
                                             <li> <b>Company Name </b><span class="text_blur"><?php echo $work['companyname']; ?></span>
                                             </li>
                                             <?php
                                                }
                                                
                                                
                                                if ($userid != $id) {
                                                
                                                    if ($work['experience'] == "Experience" && $work['companyemail']) {
                                                        ?>
                                             <li><b> Company Email Address </b> <span class="text_blur"><?php echo $work['companyemail']; ?></span> </li>
                                             <?php
                                                } else {
                                                    echo "";
                                                }
                                                } else {
                                                if ($work['experience'] == "Experience" && $work['companyemail']) {
                                                    ?>
                                             <li><b> Company Email Address </b> <span class="text_blur"><?php echo $work['companyemail']; ?></span> </li>
                                             <?php
                                                } else if ($job_work[0]['experience'] == "Fresher") {
                                                    echo "";
                                                } else {
                                                    ?>
                                             <li><b> Company Email Address</b> <span class="text_blur">
                                                <?php
                                                   echo PROFILENA;
                                                   }
                                                   }
                                                   
                                                   
                                                   
                                                   if ($userid != $id) {
                                                   
                                                   if ($work['experience'] == "Experience" && $work['companyphn']) {
                                                   ?>
                                                </span>
                                             </li>
                                             <li> <b>Company Phone Number </b><span class="text_blur"> <?php echo $work['companyphn']; ?></span>
                                             </li>
                                             <?php
                                                } else {
                                                    echo "";
                                                }
                                                } else {
                                                if ($work['experience'] == "Experience" && $work['companyphn']) {
                                                    ?>
                                             <li> <b>Company Phone Number </b><span class="text_blur"> <?php echo $work['companyphn']; ?></span>
                                             </li>
                                             <?php
                                                } else if ($job_work[0]['experience'] == "Fresher") {
                                                    echo "";
                                                } else {
                                                    ?>
                                             <li><b>Company Phone Number</b> <span>
                                                <?php
                                                   echo PROFILENA;
                                                   }
                                                   }
                                                   ?>
                                                <?php if ($job_work[0]['experience'] != "Fresher") {
                                                   ?>
                                                </span>
                                             </li>
                                             <li> <b>Experience </b><span class="text_blur">
                                                <?php
                                                   if ($work['experience_year'] == "0 year" && $work['experience_month'] == "12 month") {
                                                       echo "1 Year";
                                                   } elseif ($work['experience_year'] != "0 year" && $work['experience_month'] == "12 month") {
                                                   
                                                       $month1 = explode(' ', $work['experience_year']);
                                                       $year1 = $month1[0];
                                                       $years1 = $year1 + 1;
                                                       echo $years1 . " Years";
                                                   } else {
                                                       echo $work['experience_year'];
                                                       echo "&nbsp";
                                                       echo $work['experience_month'];
                                                   }
                                                   }
                                                   ?></span>
                                             </li>
                                             <?php
                                                if ($work['work_certificate'] != "") {
                                                    ?>
                                             <li><b>Experience Certificate </b> 
                                                <span class="text_blur">
                                                <?php
                                                   $ext = explode('.', $work['work_certificate']);
                                                   if ($ext[1] == 'pdf') {
                                                       ?>
                                                <a title="open pdf" href="<?php echo JOB_WORK_MAIN_UPLOAD_URL . $work['work_certificate'] ?>"><i class="fa fa-file-pdf-o fa-2x" style="color: red; padding-left: 8px; padding-top: 10px; padding-bottom: 10px; position: relative;" aria-hidden="true"></i></a>
                                                <?php
                                                   } else {
                                                       ?>
                                                <a class="example-image-link" href="<?php echo JOB_EDU_MAIN_UPLOAD_URL . $work['work_certificate'] ?>" data-lightbox="example-1">certificate</a>
                                                <?php
                                                   }
                                                   ?>
                                                </span>
                                             </li>
                                             <?php
                                                }
                                                ?>
                                          </ul>
                                          <?php
                                             $total_work_year += $work['experience_year'];
                                             $total_work_month += $work['experience_month'];
                                             ?>
                                       </div>
                                    </div>
                                    <?php
                                       $i++;
                                       }
                                       ?>
                                    
                                    <?php if ($job_work[0]['experience'] != "Fresher") {
                                       ?>                                  
                                    <div class="tab pagi_exp" onload="opengrad(event, 'work6')">
                                       <?php if (count($job_work) > 1) { ?>   
                                       <button class="tablinks1" onclick="opengrad(event, 'work6')">1</button>
                                       <?php } if (count($job_work) >= 2) { ?>
                                       <button class="tablinks1" onclick="opengrad(event, 'work7')">2</button>
                                       <?php } if (count($job_work) >= 3) { ?>
                                       <button class="tablinks1" onclick="opengrad(event, 'work8')">3</button>
                                       <?php } if (count($job_work) >= 4) { ?>
                                       <button class="tablinks1" onclick="opengrad(event, 'work9')">4</button>
                                       <?php } if (count($job_work) >= 5) { ?>
                                       <button class="tablinks1" onclick="opengrad(event, 'work10')">5</button>
                                       <?php } ?>
                                    </div>
                                    <?php } ?>
                                 </div>
                                 <!--profile-job-post-title clearfix -->
                                
                                 <?php
                                    }
                                     else {
                                    
                                                                                                                  if($job[0]['experience'] == 'Fresher')
                                                                                                                  {
                                    ?>
                                 <div class="profile-job-post-title clearfix">
                                    <div class="profile-job-profile-button clearfix">
                                       <div class="profile-job-details">
                                          <ul>
                                             <li>
                                                <p class="details_all_tital"> Work Experience</p>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                    <div class="profile-job-profile-menu">
                                       <ul class="clearfix">
                                          <li> <b> Work Experience</b><span>Fresher</span>
                                          </li>
                                       </ul>
                                    </div>
                                 </div>
                                 <!--profile-job-post-title clearfix -->
                                 <?php
                                    }
                                    }
                                    ?>
                                 <!-- test -->
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <?php 
               if ($userid == $id)
                       {
                           if($count_profile == 100)
                           {
                            if($job_reg[0]['progressbar']==0)
                            {
                             
               ?>
            <div class="edit_profile_progress edit_pr_bar complete_profile">
               <div class="progre_bar_text">
                  <p>Please fill up your entire profile to get better job options and so that recruiter can find you easily.</p>
               </div>
               <div class="count_main_progress">
                  <div class="circles">
                     <div class="second circle-1 ">
                        <div class="true_progtree">
                           <img src="<?php echo base_url("img/true.png"); ?>" alt="Successimage">
                        </div>
                        <div class="tr_text">
                           Successfully Completed
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <?php
               }
                  }
               else
               {
                   ?>
            <div class="edit_profile_progress edit_pr_bar">
               <div class="progre_bar_text">
                  <p>Please fill up your entire profile to get better job options and so that recruiter can find you easily.</p>
               </div>
               <div class="count_main_progress">
                  <div class="circles">
                     <div class="second circle-1">
                        <div>
                           <strong></strong>
                           <a href="<?php echo base_url('job/basic-information')?>" class="edit_profile_job">Edit Profile
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <?php
               }
               ?>
            <?php
               }
               ?>
         </div>
         <div class="clearfix"></div>
      </section>
      <!-- Bid-modal-2  -->
      <div class="modal fade message-box" id="bidmodal-2" role="dialog">
         <div class="modal-dialog modal-lm">
            <div class="modal-content">
               <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
               <div class="modal-body">
                  <span class="mes">
                     <div id="popup-form">

                     <div class="fw" id="loader_popup"  style="text-align:center; display:none;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="Loaderimage"/></div>

                     <form id ="userimage" name ="userimage" class ="clearfix" enctype="multipart/form-data" method="post">

                        <div class="fw">
                                 <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="upload-one">
                        </div>

                        <div class="col-md-7 text-center">
                              <div id="upload-demo-one" style="width:350px; display:none;"></div>
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


      <!-- Login  -->
        <div class="modal login fade" id="login" role="dialog">
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
                    <!--<button type="button" class="modal-close" data-dismiss="modal">&times;</button>-->         
                    <div class="modal-body">
                        <div class="clearfix">
                            <div class="">
                                <div class="title"><h1 class="tlh1">Sign up First and Register in Job Profile</h1></div>
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

<!-- <footer>   -->   
<?php echo $login_footer ?>   
<?php echo $footer;  ?>
<!-- </footer> -->

      <!-- script for skill textbox automatic start-->
    
      <script src="<?php echo base_url('assets/js/croppie.js?ver='.time()); ?>"></script> 
      <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()) ?>"></script>
      <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver='.time()); ?>"></script>
      <script type="text/javascript" src="<?php echo base_url('assets/js/progressloader.js?ver='.time()); ?>"></script>

      <script>
         var base_url = '<?php echo base_url(); ?>';
         var count_profile_value='<?php echo $count_profile_value;?>';
         var count_profile='<?php echo $count_profile;?>';
         var site_url = '<?php echo $get_url; ?>';
      </script>

      <script>


        $(document).ready(function () {
                // setTimeout(function () {
                    $('#register').modal('show');
                // }, 2000);
            });

            function login_profile() {
                $('#register').modal('show');
               // $('body').addClass('modal-open');
            }
             function login_data() { 
                $('#login').modal('show');
                $('#register').modal('hide');
                $('body').addClass('modal-open');

            }
            function register_profile() {
                $('#login').modal('hide');
                $('#register').modal('show');
            }
            function forgot_profile() {
                $('#forgotPassword').modal('show');
                $('#login').modal('hide');
                $('body').addClass('modal-open');

            }


$('.modal-close').click(function(e){ 
    $('#login').modal('show');
    //$('body').addClass('modal-open');
    document.getElementById("add-model-open").classList.add("modal-open-other");
});


   </script>

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
                        url: '<?php echo base_url() ?>login/job_check_login',
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
                                $("#btn1").html('<img src="<?php echo base_url() ?>assets/images/btn-ajax-loader.gif" alt="loaderimage"/> &nbsp; Login');
                                if (response.is_job == '1') {
                                    window.location = "<?php echo base_url() ?>job/resume/" + site_url;
                                } else {
                                    window.location = "<?php echo base_url() ?>job";
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
                                $("#btn-register").html('<img src="<?php echo base_url() ?>assets/images/btn-ajax-loader.gif" alt="loaderimage"/> &nbsp; Sign Up ...');
                                window.location = "<?php echo base_url() ?>recruiter";
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
                });
                /* validation */

            });
        </script>

<?php
        if (IS_JOB_JS_MINIFY == '1') {
            ?>

      <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/progressbar_common.js?ver='.time()); ?>"></script>

      <?php }else{?>
      <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/job/progressbar_common.js?ver='.time()); ?>"></script>


      <?php }?>
      
   </body>
</html>