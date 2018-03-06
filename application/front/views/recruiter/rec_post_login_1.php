<!DOCTYPE html>
<html>
   <head>
      <!-- start head -->
      <?php  echo $head; ?>
      <!-- END HEAD -->

      <title><?php echo $title; ?></title>

    <?php
        if (IS_REC_CSS_MINIFY == '0') {
            ?>
           <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/recruiter.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver='.time()); ?>">          
  <?php
        } else {
            ?>
           <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/recruiter.css'); ?>">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_main/style-main.css?ver='.time()); ?>">
        <?php } ?>
   </head>
   <!-- END HEAD -->
   
   <body class="page-container-bg-solid page-boxed">

     <header>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-3">
                        <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png?ver='.time()) ?>" alt="logo"></a>
                    </div>
                    <div class="col-md-8 col-sm-9">
                        <div class="btn-right pull-right">
                            <a href="javascript:void(0);" onclick="login_profile();" class="btn2" title="Login">Login</a>
                            <a href="javascript:void(0);" onclick="register_profile();" class="btn3" title="Creat an account">Creat an account</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

      <div class="user-midd-section" id="paddingtop_fixed">
      <div class="container">
      <div class="row row4">
          
           <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt"><div class="">

                                <div class="full-box-module">   
                                    <div class="profile-boxProfileCard  module">
                                        <div class="profile-boxProfileCard-cover"> 
                                            <a title="Recruiter profile" class="profile-boxProfileCard-bg u-bgUserColor a-block" href="<?php echo base_url('recruiter/profile'); ?>" tabindex="-1" 
                                               aria-hidden="true" rel="noopener">
<div class="bg-images no-cover-upload"> 
                                                <?php
                                                $image_ori = $this->config->item('rec_bg_thumb_upload_path') . $recdata[0]['profile_background'];

                                                if ($recdata[0]['profile_background'] != '' && file_exists($image_ori)) {
                                                    ?>

                                                    <!-- box image start -->
                                                    <img src="<?php echo base_url($this->config->item('rec_bg_thumb_upload_path') . $recdata[0]['profile_background']); ?>" class="bgImage" alt="<?php echo $recdata[0]['rec_firstname'] . ' ' . $recdata[0]['rec_lastname']; ?>">
                                                    <!-- box image end -->
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

                                                <a class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock"  title="Recruiter profile" href="<?php echo base_url('recruiter/profile/' . $recdata[0]['user_id']); ?>" title="<?php echo $recdata[0]['rec_firstname'] . ' ' . $recdata[0]['rec_lastname']; ?>" tabindex="-1" aria-hidden="true" rel="noopener">
                                                    <?php
                                                    $image_profile = $this->config->item('rec_profile_thumb_upload_path') . $recdata[0]['recruiter_user_image'];

                                                    if ($recdata[0]['recruiter_user_image'] != '' && file_exists($image_profile)) {
                                                        ?>
                                                        <img src="<?php echo base_url($this->config->item('rec_profile_thumb_upload_path') . $recdata[0]['recruiter_user_image']); ?>" alt="<?php echo $recdata[0]['rec_firstname'] . ' ' . $recdata[0]['rec_lastname']; ?>" >
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
                                                    <a href="<?php echo site_url('recruiter/rec_profile'); ?>" title="<?php echo ucfirst(strtolower($recdata['rec_firstname'])) . ' ' . ucfirst(strtolower($recdata['rec_lastname'])); ?>">   <?php echo ucfirst(strtolower($recdata[0]['rec_firstname'])) . ' ' . ucfirst(strtolower($recdata[0]['rec_lastname'])); ?></a>
                                                </span>

                                                <?php //$category = $this->db->get_where('industry_type', array('industry_id' => $businessdata[0]['industriyal'], 'status' => 1))->row()->industry_name;  ?>
                                                <div class="profile-boxProfile-name">
                                                    <a href="<?php echo site_url('recruiter/rec_profile/' . $recdata[0]['user_id']); ?>" title="<?php echo ucfirst(strtolower($recdata[0]['designation'])); ?>">
                                                        <?php
                                                        if (ucfirst(strtolower($recdata[0]['designation']))) {
                                                            echo ucfirst(strtolower($recdata[0]['designation']));
                                                        } else {
                                                            echo "Designation";
                                                        }
                                                        ?></a>
                                                </div>
                                                <ul class=" left_box_menubar">
                                                    <li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'profile') { ?> class="active" <?php } ?>><a class="padding_less_left" title="Details" href="<?php echo base_url('recruiter/profile'); ?>"> Details</a>
                                                    </li>                                
                                                    <li id="rec_post_home" <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'post') { ?> class="active" <?php } ?>><a title="Post" href="<?php echo base_url('recruiter/post'); ?>">Post</a>
                                                    </li>
                                                    <li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'save-candidate') { ?> class="active" <?php } ?>><a title="Saved Candidate" class="padding_less_right" href="<?php echo base_url('recruiter/save-candidate'); ?>">Saved </a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>                             
                                </div>
							
                                
                               
                               
                            </div>

                        </div>
     
      <div class="custom-right-art mian_middle_post_box animated fadeInUp">
         <div class="common-form">
            <div class="job-saved-box">
               <h3>
                 Web developer
               </h3>

               <div class="contact-frnd-post">
                              <!--.........AJAX DATA START......-->  
                              <?php
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
                  Created Date : <?php echo date('d-M-Y',strtotime($post['created_date'])); ?>
               </li>
     
              <li class="">
              <a class="post_title" href="javascript:void(0)" title="Post Title">
               <?php 
                                              $cache_time = $this->db->get_where('job_title', array('title_id' => $post['post_name']))->row()->name;
                                              if($cache_time)
                                              {
                                                  echo  $cache_time;
                                              }
                                              else
                                              {
                                                echo $post['post_name'];
                                              }
                                           ?>  </a>     
              </li>
     
             <li>  
             <?php $cityname = $this->db->get_where('cities', array('city_id' => $post['city']))->row()->city_name;
            $countryname = $this->db->get_where('countries', array('country_id' => $post['country']))->row()->country_name; ?> 

            <?php  
             if($cityname || $countryname)
               { 
                ?>

            <div class="fr lction">
            <p title="Location"><i class="fa fa-map-marker" aria-hidden="true"></i>

            <?php if($cityname){
            echo $cityname .', ';}?>
            <?php 
             echo $countryname; ?> 
            </p>
                  
            </div>
             <?php
             }




            ?>
           <a class="display_inline" title="<?php echo $post['re_comp_name']?>" href="javascript:void(0)">
            <?php   $out = strlen($post['re_comp_name']) > 40 ? substr($post['re_comp_name'],0,40)."..." : $post['re_comp_name'];
             echo $out;?> </a>
              </li>
              <li class="fw"><a class="display_inline" title="Recruiter Name" href="javascript:void(0)"> <?php echo ucfirst(strtolower($post['rec_firstname'])).' '. ucfirst(strtolower($post['rec_lastname'])); ?> </a></li>
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

                            if(!$post['post_skill']){

                                echo $post['other_skill'];

                            }else if(!$post['other_skill']){


                                foreach ($aud_res as $skill) {
                            
                            $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;

                            if($cache_time != " "){                                                                                                                                                                                                                                              
                                if ($k != 0) {
                                echo $comma;
                                 
                            }echo $cache_time;
                             $k++;  }
                            }


                            }else if($post['post_skill'] && $post['other_skill']){
                            foreach ($aud_res as $skill) {
                             if ($k != 0) {
                                echo $comma;
                            }
                            $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;


                            echo $cache_time;
                                $k++;
                            } echo ",". $post['other_skill']; }
                        ?>     
                                                
                                                </span>
                                            </li>
                                            <!-- <li><b>Other Skill</b><span> <?php if($post['other_skill'] != ''){ echo $post['other_skill']; } else{ echo PROFILENA;} ?></span>
                                            </li> -->
                                            <li><b>Job Description</b><span><pre><?php echo $this->common->make_links($post['post_description']); ?></pre></span>
                                            </li>
                                            <li><b>Interview Process</b><span>
                                            

                                            <?php if($post['interview_process'] != ''){?>
                                            <pre>
                                            <?php echo $this->common->make_links($post['interview_process']); ?></pre>
                                               <?php }else{ echo PROFILENA; }?> 

                                            </span>
                                            </li>

                                            <!-- vishang 14-4 start -->
                                              <li>
                                                <b>Required Experience</b>
                                                 <span>
                                                   <p title="Min - Max">
                                                       <?php 


                                                           if(($post['min_year'] !='0' || $post['max_year'] !='0') && ($post['fresher'] == 1))
                                                          { 
 

                                                               echo $post['min_year'].' Year - '.$post['max_year'] .' Year'." , ".   "Fresher can also apply.";
                                                                 } 
                                                             else if(($post['min_year'] !='0' || $post['max_year'] !='0'))
                                                                  {
                                                               echo $post['min_year'].' Year - '.$post['max_year'] . ' Year';
                                                                   }
                                                                  else
                                                                {
                                                                  echo "Fresher";
         
                                                                  }

                                                                  ?> 
    
                                                                  </p>  
                                                                  </span>
                                                                  </li>


                                             <li><b>Salary</b><span title="Min - Max" >
                                         <?php


            $currency = $this->db->get_where('currency', array('currency_id' => $post['post_currency']))->row()->currency_name;

          if($post['min_sal'] || $post['max_sal']) {
          echo $post['min_sal']." - ".$post['max_sal'].' '. $currency . ' '. $post['salary_type']; } 
          else { echo PROFILENA;} ?></span>
                                            </li>
                                          


                   <li><b>No of Position</b><span><?php echo $post['post_position'].' '. 'Position'; ?></span>
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

                            if(!$post['degree_name']){

                                echo $post['other_education'];

                            }else if(!$post['other_education']){


                                foreach ($edu_nm as $edun) {
                             if ($k != 0) {
                                echo $comma;
                            }
                            $cache_time = $this->db->get_where('degree', array('degree_id' => $edun))->row()->degree_name;


                            echo $cache_time;
                                $k++;
                            }


                            }else if($post['degree_name'] && $post['other_education']){
                            foreach ($edu_nm as $edun) {
                             if ($k != 0) {
                                echo $comma;
                            }
                            $cache_time = $this->db->get_where('degree', array('degree_id' => $edun))->row()->degree_name;


                            echo $cache_time;
                                $k++;
                            } echo ",". $post['other_education']; }
                        ?>     
                                                
                                                </span>
                                            </li>

                                            <?php }

                                            else
                                            { ?>

                                            <li><b>Education Required</b><span>
                                            <?php
                                              echo PROFILENA; ?>
                                              </span>
                                            </li>
                                      <?php      }
                                            ?>                   <li><b>Employment Type</b><span>
                                            

                                            <?php if($post['emp_type'] != ''){?>
                                            <pre>
                                            <?php echo $this->common->make_links($post['emp_type']).'  Job'; ?></pre>
                                               <?php }else{ echo PROFILENA; }?> 

                                            </span>
                                            </li>

                                            <li><b>Company Profile</b><span>
                                            

                                            <?php if($post['re_comp_profile'] != ''){?>
                                            <pre>
                                            <?php echo $this->common->make_links($post['re_comp_profile']); ?></pre>
                                               <?php }else{ echo PROFILENA; }?> 

                                            </span>
                                            </li>
                                          

                 </ul>
                 </div>
                                    
                                     <div class="profile-job-profile-button clearfix">
                                                                    <div class="profile-job-details col-md-12">
                                                                        <ul><li class="job_all_post ">
                                                                                                                                          </li>
                                                                            <li class=fr>
                                                                                
                                                                                  
                                                                                    <a href="" title="Apply" class= "applypost  button"> Apply</a>
                                                                                </li> 
                                                                                <li>
                                                                                        <a  class="savedpost button" title="Save">Save</a>

                                                                            </li>                        
                                                                        </ul>
                                                                    </div>

                                                                </div>
                            
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                              <!--.........AJAX DATA END......-->           
                         <!--<div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" /></div>-->
              </div>

            </div>
         </div>
      
         <!--recommen candidate start-->
             <div class="common-form">
            <div class="job-saved-box">
               <h3>
                 Recommended from aileensoul
               </h3>

               <div class="contact-frnd-post">
                            <div class="job-contact-frnd ">
                              <!--.........AJAX DATA START......-->  
                               <div class="job-post-detail clearfix">
                                         <?php
          foreach ($recommandedpost as $post) {
                        ?>
                        <div class="job-contact-frnd ">
                            <div class="profile-job-post-detail clearfix" id="<?php echo "removepost" . $post['post_id']; ?>">
                                <!-- vishang 14-4 end -->
                                <div class="profile-job-post-title clearfix">
                                    <div class="profile-job-profile-button clearfix">
       <div class="profile-job-details col-md-12">
          <ul>
              <li class="fr date_re">
                  Created Date : <?php echo date('d-M-Y',strtotime($post['created_date'])); ?>
               </li>
     
              <li class="">
              <a class="post_title" href="javascript:void(0)" title="Post Title">
               <?php 
                                              $cache_time = $this->db->get_where('job_title', array('title_id' => $post['post_name']))->row()->name;
                                              if($cache_time)
                                              {
                                                  echo  $cache_time;
                                              }
                                              else
                                              {
                                                echo $post['post_name'];
                                              }
                                           ?>  </a>     
              </li>
     
             <li>  
             <?php $cityname = $this->db->get_where('cities', array('city_id' => $post['city']))->row()->city_name;
            $countryname = $this->db->get_where('countries', array('country_id' => $post['country']))->row()->country_name; ?> 

            <?php  
             if($cityname || $countryname)
               { 
                ?>

            <div class="fr lction">
            <p title="Location"><i class="fa fa-map-marker" aria-hidden="true"></i>

            <?php if($cityname){
            echo $cityname .', ';}?>
            <?php 
             echo $countryname; ?> 
            </p>
                  
            </div>
             <?php
             }




            ?>
           <a class="display_inline" title="<?php echo $post['re_comp_name']?>" href="javascript:void(0)">
            <?php   $out = strlen($post['re_comp_name']) > 40 ? substr($post['re_comp_name'],0,40)."..." : $post['re_comp_name'];
             echo $out;?> </a>
              </li>
              <li class="fw"><a class="display_inline" title="Recruiter Name" href="javascript:void(0)"> <?php echo ucfirst(strtolower($post['rec_firstname'])).' '. ucfirst(strtolower($post['rec_lastname'])); ?> </a></li>
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

                            if(!$post['post_skill']){

                                echo $post['other_skill'];

                            }else if(!$post['other_skill']){


                                foreach ($aud_res as $skill) {
                            
                            $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;

                            if($cache_time != " "){                                                                                                                                                                                                                                              
                                if ($k != 0) {
                                echo $comma;
                                 
                            }echo $cache_time;
                             $k++;  }
                            }


                            }else if($post['post_skill'] && $post['other_skill']){
                            foreach ($aud_res as $skill) {
                             if ($k != 0) {
                                echo $comma;
                            }
                            $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;


                            echo $cache_time;
                                $k++;
                            } echo ",". $post['other_skill']; }
                        ?>     
                                                
                                                </span>
                                            </li>
                                            <!-- <li><b>Other Skill</b><span> <?php if($post['other_skill'] != ''){ echo $post['other_skill']; } else{ echo PROFILENA;} ?></span>
                                            </li> -->
                                            <li><b>Job Description</b><span><pre><?php echo $this->common->make_links($post['post_description']); ?></pre></span>
                                            </li>
                                            <li><b>Interview Process</b><span>
                                            

                                            <?php if($post['interview_process'] != ''){?>
                                            <pre>
                                            <?php echo $this->common->make_links($post['interview_process']); ?></pre>
                                               <?php }else{ echo PROFILENA; }?> 

                                            </span>
                                            </li>

                                            <!-- vishang 14-4 start -->
                                              <li>
                                                <b>Required Experience</b>
                                                 <span>
                                                   <p title="Min - Max">
                                                       <?php 


                                                           if(($post['min_year'] !='0' || $post['max_year'] !='0') && ($post['fresher'] == 1))
                                                          { 
 

                                                               echo $post['min_year'].' Year - '.$post['max_year'] .' Year'." , ".   "Fresher can also apply.";
                                                                 } 
                                                             else if(($post['min_year'] !='0' || $post['max_year'] !='0'))
                                                                  {
                                                               echo $post['min_year'].' Year - '.$post['max_year'] . ' Year';
                                                                   }
                                                                  else
                                                                {
                                                                  echo "Fresher";
         
                                                                  }

                                                                  ?> 
    
                                                                  </p>  
                                                                  </span>
                                                                  </li>


                                             <li><b>Salary</b><span title="Min - Max" >
                                         <?php


            $currency = $this->db->get_where('currency', array('currency_id' => $post['post_currency']))->row()->currency_name;

          if($post['min_sal'] || $post['max_sal']) {
          echo $post['min_sal']." - ".$post['max_sal'].' '. $currency . ' '. $post['salary_type']; } 
          else { echo PROFILENA;} ?></span>
                                            </li>
                                          


                   <li><b>No of Position</b><span><?php echo $post['post_position'].' '. 'Position'; ?></span>
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

                            if(!$post['degree_name']){

                                echo $post['other_education'];

                            }else if(!$post['other_education']){


                                foreach ($edu_nm as $edun) {
                             if ($k != 0) {
                                echo $comma;
                            }
                            $cache_time = $this->db->get_where('degree', array('degree_id' => $edun))->row()->degree_name;


                            echo $cache_time;
                                $k++;
                            }


                            }else if($post['degree_name'] && $post['other_education']){
                            foreach ($edu_nm as $edun) {
                             if ($k != 0) {
                                echo $comma;
                            }
                            $cache_time = $this->db->get_where('degree', array('degree_id' => $edun))->row()->degree_name;


                            echo $cache_time;
                                $k++;
                            } echo ",". $post['other_education']; }
                        ?>     
                                                
                                                </span>
                                            </li>

                                            <?php }

                                            else
                                            { ?>

                                            <li><b>Education Required</b><span>
                                            <?php
                                              echo PROFILENA; ?>
                                              </span>
                                            </li>
                                      <?php      }
                                            ?>                   <li><b>Employment Type</b><span>
                                            

                                            <?php if($post['emp_type'] != ''){?>
                                            <pre>
                                            <?php echo $this->common->make_links($post['emp_type']).'  Job'; ?></pre>
                                               <?php }else{ echo PROFILENA; }?> 

                                            </span>
                                            </li>

                                            <li><b>Company Profile</b><span>
                                            

                                            <?php if($post['re_comp_profile'] != ''){?>
                                            <pre>
                                            <?php echo $this->common->make_links($post['re_comp_profile']); ?></pre>
                                               <?php }else{ echo PROFILENA; }?> 

                                            </span>
                                            </li>
                                          

                 </ul>
                 </div>
                                    
                                     <div class="profile-job-profile-button clearfix">
                                                                    <div class="profile-job-details col-md-12">
                                                                        <ul><li class="job_all_post ">
                                                                                                                                          </li>
                                                                            <li class=fr>
                                                                                
                                                                                  
                                                                                    <a href="" class= "applypost  button" title="Apply"> Apply</a>
                                                                                </li> 
                                                                                <li>
                                                                                        <a  class="savedpost button" title="Save">Save</a>

                                                                            </li>                        
                                                                        </ul>
                                                                    </div>

                                                                </div>
                            
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                              <!--.........AJAX DATA END......-->           
                         <!--<div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" /></div>-->
              </div>

            </div>
         </div>
      </div>
      </div>
         <!--recommen candidate end-->
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
      
<!-- <footer>         -->
<?php echo $footer;  ?>
<!-- </footer> -->

<!-- Login  -->
        <div class="modal fade login" id="login" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <div class="col-sm-12 right-main">
                            <div class="right-main-inner">
                                <div class="login-frm">
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
                                                <a href="javascript:void(0)" data-toggle="modal" onclick="forgot_profile();" id="myBtn" title="Forgot Password ?">Forgot Password ?</a>
                                            </p>

                                            <p class="pt15 text-center">
                                                Don't have an account? <a href="javascript:void(0);" data-toggle="modal" onclick="register_profile();" title="Create an account">Create an account</a>
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
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <div class="col-sm-12 right-main">
                            <div class="right-main-inner">
                                <div class="login-frm">
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
                                        
                                        <p class="pt-20 ">
                                            <input class="btn btn-theme btn1" type="submit" name="submit" value="Submit" style="width:200px; margin-top:15px;" /> 
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
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <div class="clearfix">
                            <div class="">
                                 <div class="title"><h1 style="font-size: 24px;text-transform: none;">Sign up First and Register in Recruiter Profile</h1></div>
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
                                            <a href="<?php echo base_url('terms-and-condition'); ?>" title="Terms and Condition">Terms and Condition</a> and <a href="<?php echo base_url('privacy-policy'); ?>">Privacy policy</a>.
                                        </p>
                                        <p>
                                            <button tabindex="13" class="btn1" title="Create an account">Create an account</button>
                                        </p>
                                    </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- register -->

<!-- script for skill textbox automatic start-->


 <script>
          var base_url = '<?php echo base_url(); ?>';
          var skill = '<?php echo  $this->input->get('skills'); ?>';
          var place = '<?php echo  $this->input->get('searchplace'); ?>';
                                              
</script>

 <?php if (IS_REC_JS_MINIFY == '0') {  ?>
<script src="<?php echo base_url('assets/js/bootstrap.min.js?ver='.time()); ?>"></script>
 <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/rec_post_login.js?ver='.time()); ?>"></script>
            <?php } else { ?>
<script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver='.time()); ?>"></script>
 <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/recruiter/rec_post_login.js?ver='.time()); ?>"></script>
        <?php } ?>
</body>
</html>