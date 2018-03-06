<!DOCTYPE html>
<html>
   <head>
      <!-- start head -->
      <?php  echo $head; ?>
      <!-- END HEAD -->

      <title><?php echo $title; ?></title>

       <?php
        if (IS_JOB_CSS_MINIFY == '0') {
            ?>
      <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver='.time()); ?>">
      <!-- This Css is used for call popup -->
      <link rel="stylesheet" href="<?php echo base_url('assets/css/jquery.fancybox.css?ver='.time()); ?>" />
	  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver='.time()); ?>">

    <?php }else{?>

  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver='.time()); ?>">
      <!-- This Css is used for call popup -->
      <link rel="stylesheet" href="<?php echo base_url('assets/css_min/jquery.fancybox.css?ver='.time()); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/job.css?ver='.time()); ?>">
    <?php }?>
   </head>
   <!-- END HEAD -->
   <!-- Start HEADER -->
   <?php 
      echo $header; 
      echo $job_header2_border;  
      ?>
   <!-- END HEADER -->
   <body class="page-container-bg-solid page-boxed botton_footer">
      <section>
         <div class="user-midd-section" id="paddingtop_fixed_job">
         <div class="common-form1">
            <div class="col-md-3 col-sm-4"></div>
            <div class="col-md-6 col-sm-8">
               <h3>You are updating your Job Profile.</h3>
            </div>
            
         </div>
         <br>
         <div class="container">
         <div class="row">
            <!-- Job leftbar start-->
            <?php echo $job_left; ?>
            <!-- Job leftbar End-->
            <!-- middle section start -->
            <div class="col-md-6 col-sm-8">
               <div>
                  <?php
                     if ($this->session->flashdata('error')) {
                         echo '<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>';
                     }
                     if ($this->session->flashdata('success')) {
                         echo '<div class="alert alert-success">' . $this->session->flashdata('success') . '</div>';
                     }
                     ?>
               </div>
               <div class="clearfix">
                  <div class="col-md-12 col-sm-12 ">
                     <div class="clearfix">
                        <div class="common-form common-form_border">
                           <h3>Work Experience </h3>
                           <div class="work_exp fw">
                              <div class="">
                                 <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="panel-group wrap" id="bs-collapse">
                                      
                                      
                                           <?php  if($userdata[0]['experience'] == 'Experience' && ($userdata[0]['exp_y'] != "")){ ?>
                                   <div class="profile-job-post-title clearfix">
                                    <div class="profile-job-profile-button clearfix">
                                       <div class="profile-job-details">
                                        <div class="profile-job-profile-menu">                          
                                        <ul class="clearfix">
                                          <li> <b> Total Experience</b> <span><?php  if($userdata[0]['exp_y'] != " " && $userdata[0]['exp_m'] != " "){ 
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
                                             } ?> </span>
                                          </li>
                                       </ul>
                                     </div>
                                   </div>
                                 </div>
                               </div>
                                         <?php } ?>
                                       <div class="panel">
                                          <div  id="panel-heading" <?php if($userdata[0]['experience'] == 'Fresher'){ ?> class="panel-heading active" <?php } else if($userdata[0]['experience'] == ''){?> class="panel-heading" <?php }else{?> class="panel-heading" <?php } ?>>
                                             <h4 class="panel-title">
                                                <a data-toggle="collapse" tabindex="1" data-parent="#bs-collapse" href="#one" id="toggle" >
                                                Fresher
                                                </a>
                                             </h4>
                                          </div>
                                          <div id="one"  <?php if($userdata[0]['experience'] == 'Experience'){ ?> class="panel-collapse collapse" <?php }else if($userdata[0]['experience'] == ''){?> class="panel-collapse collapse" <?php }else{?> class="panel-collapse collapse in" <?php } ?>>
                                             <div class="panel-body">
                                                <?php echo form_open_multipart(base_url('job/job_work_exp_insert'), array('id' => 'jobseeker_regform', 'name' => 'jobseeker_regform', 'class' => 'clearfix')); ?>
                                
                                                <label for="Fresher" class="lbpos">
                                                <input type="checkbox" id="fresher" tabindex="1" name="radio" value="Fresher" <?php echo ($userdata[0]['experience'] == 'Fresher') ? 'checked' : '' ?>>
                                                Fresher&nbsp;&nbsp;
                                                </label>
                                                <fieldset class="hs-submit full-width left_nest">
                                                   <!-- <input title="Submit" type="submit" id="next" tabindex="2" name="next" value="Submit"> -->
                                                   <button  id="next" tabindex="2" name="next"  onclick="return profile_reg();">Submit<span class="ajax_load pl10" id="fre_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
                                                </fieldset>
                                                <?php echo form_close(); ?>
                                             </div>
                                          </div>
                                       </div>
                                       <!-- end of panel -->
                                       <div class="panel">
                                          <div  id="panel-heading1"  <?php if($userdata[0]['experience'] == 'Experience'){ ?> class="panel-heading active" <?php } else if($userdata[0]['experience'] == ''){?>  class="panel-heading" <?php }else{?> class="panel-heading" <?php } ?>>
                                             <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#bs-collapse" href="#two" id="toggle1" >
                                                Experience
                                                </a>
                                             </h4>
                                          </div>
                                           <input type="hidden" name="exp_year" id="exp_year" value="">
                                                <input type="hidden" name="exp_month" id="exp_month" value="">
                                          <div id="two"   <?php if($userdata[0]['experience'] == 'Fresher'){ ?> class="panel-collapse collapse" <?php } else if($userdata[0]['experience'] == ''){?> class="panel-collapse collapse"<?php }else{?> class="panel-collapse collapse in" <?php } ?>>
                                             <div class="panel-body">
                                                <?php echo form_open_multipart(base_url('job/job_work_exp_insert'), array('id' => 'jobseeker_regform1', 'name' => 'jobseeker_regform1', 'class' => 'clearfix')); ?>       
                                  
                                                <!--UPDATE TIME-->
                                                <?php
                                                   $clone_mathod_count = 1;
                                                   if ($workdata) {
                                                   
                                                       $count = count($workdata);
                                                   
                                                       if ($count == 0) {
                                                           // this is use for javascript
                                                           $clone_mathod_count = 1;
                                                       } else {
                                                           $clone_mathod_count = $count;
                                                       }
                                                   
                                                       for ($x = 0; $x < $count; $x++) {
                                                   
                                                           $experience_year1 = $workdata[$x]['experience_year'];
                                                           $experience_month1 = $workdata[$x]['experience_month'];
                                                           $jobtitle1 = $workdata[$x]['jobtitle'];
                                                           $companyname1 = $workdata[$x]['companyname'];
                                                           $companyemail1 = $workdata[$x]['companyemail'];
                                                           $companyphn1 = $workdata[$x]['companyphn'];
                                                   
                                                           $work_certificate1 = $workdata[$x]['work_certificate'];
                                                           $y = $x + 1;
                                                   
                                                           ?>
                                                
                                                <input type="hidden" name="exp_data[]" value="old" class="exp_data" id="exp_data<?php echo $y; ?>">
                                                <div id="input<?php echo $y; ?>" style="margin-bottom:4px;position: relative;" class="job_work_experience_main_div clonedInput job_work_edit_<?php echo $workdata[$x]['work_id']?>">
                                                   
                                                      <label>Experience:<span class="red">*</span></label>
                                                      <select style="width: 47%; margin-right: 4%; float: left;" tabindex="1" autofocus name="experience_year[]" id="experience_year" tabindex="1" class="experience_year keyskil" onchange="expyear_change_edittime();">
                                                         <option value="" selected option disabled>Year</option>
                                                         <option value="0 year"  <?php if ($experience_year1 == "0 year") echo 'selected'; ?>>0 year</option>
                                                         <option value="1 year"  <?php if ($experience_year1 == "1 year") echo 'selected'; ?>>1 year</option>
                                                         <option value="2 year"  <?php if ($experience_year1 == "2 year") echo 'selected'; ?>>2 year</option>
                                                         <option value="3 year"  <?php if ($experience_year1 == "3 year") echo 'selected'; ?>>3 year</option>
                                                         <option value="4 year"  <?php if ($experience_year1 == "4 year") echo 'selected'; ?>>4 year</option>
                                                         <option value="5 year"  <?php if ($experience_year1 == "5 year") echo 'selected'; ?>>5 year</option>
                                                         <option value="6 year"  <?php if ($experience_year1 == "6 year") echo 'selected'; ?>>6 year</option>
                                                         <option value="7 year"  <?php if ($experience_year1 == "7 year") echo 'selected'; ?>>7 year</option>
                                                         <option value="8 year"  <?php if ($experience_year1 == "8 year") echo 'selected'; ?>>8 year</option>
                                                         <option value="9 year"  <?php if ($experience_year1 == "9 year") echo 'selected'; ?>>9 year</option>
                                                         <option value="10 year"  <?php if ($experience_year1 == "10 year") echo 'selected'; ?>>10 year</option>
                                                         <option value="11 year"  <?php if ($experience_year1 == "11 year") echo 'selected'; ?>>11 year</option>
                                                         <option value="12 year"  <?php if ($experience_year1 == "12 year") echo 'selected'; ?>>12 year</option>
                                                         <option value="13 year"  <?php if ($experience_year1 == "13 year") echo 'selected'; ?>>13 year</option>
                                                         <option value="14 year"  <?php if ($experience_year1 == "14 year") echo 'selected'; ?>>14 year</option>
                                                         <option value="15 year"  <?php if ($experience_year1 == "15 year") echo 'selected'; ?>>15 year</option>
                                                         <option value="16 year"  <?php if ($experience_year1 == "16 year") echo 'selected'; ?>>16 year</option>
                                                         <option value="17 year"  <?php if ($experience_year1 == "17 year") echo 'selected'; ?>>17 year</option>
                                                         <option value="18 year"  <?php if ($experience_year1 == "18 year") echo 'selected'; ?>>18 year</option>
                                                         <option value="19 year"  <?php if ($experience_year1 == "19 year") echo 'selected'; ?>>19 year</option>
                                                         <option value="20 year"  <?php if ($experience_year1 == "20 year") echo 'selected'; ?>>20 year</option>
                                                      </select>
                                                      <?php echo form_error('experience_year[]'); ?>
                                                      <select style="width: 45%;" name="experience_month[]" tabindex="2"   id="experience_month" class="experience_month keyskil">
                                                         <option value="" selected option disabled>Month</option>
                                                         <option value="0 month"  <?php if ($experience_month1 == "0 month") echo 'selected'; if ($experience_year1 == "0 year") echo 'selected option disabled'; ?>>0 month</option>
                                                         <option value="1 month"  <?php if ($experience_month1 == "1 month") echo 'selected'; ?>>1 month</option>
                                                         <option value="2 month"  <?php if ($experience_month1 == "2 month") echo 'selected'; ?>>2 month</option>
                                                         <option value="3 month"  <?php if ($experience_month1 == "3 month") echo 'selected'; ?>>3 month</option>
                                                         <option value="4 month"  <?php if ($experience_month1 == "4 month") echo 'selected'; ?>>4 month</option>
                                                         <option value="5 month"  <?php if ($experience_month1 == "5 month") echo 'selected'; ?>>5 month</option>
                                                         <option value="6 month"  <?php if ($experience_month1 == "6 month") echo 'selected'; ?>>6 month</option>
                                                         <option value="7 month"  <?php if ($experience_month1 == "7 month") echo 'selected'; ?>>7 month</option>
                                                         <option value="8 month"  <?php if ($experience_month1 == "8 month") echo 'selected'; ?>>8 month</option>
                                                         <option value="9 month"  <?php if ($experience_month1 == "9 month") echo 'selected'; ?>>9 month</option>
                                                         <option value="10 month"  <?php if ($experience_month1 == "10 month") echo 'selected'; ?>>10 month</option>
                                                         <option value="11 month"  <?php if ($experience_month1 == "11 month") echo 'selected'; ?>>11 month</option>
                                                         <option value="12 month"  <?php if ($experience_month1 == "12 month") echo 'selected'; ?>>12 month</option>
                                                      </select>
                                                      <?php echo form_error('experience_month[]'); ?>
                                                      <label  style="   margin-top: 25px;
    display: inline-block;">Job Title:<span class="red">*</span></label>
                                                      <input type="text" name="jobtitle[]" tabindex="3"  class="jobtitle" id="jobtitle"  placeholder="Enter Job Title" value="<?php
                                                         if ($jobtitle1) {
                                                             echo $jobtitle1;
                                                         }
                                                         ?>" maxlength="255" onfocus="var temp_value=this.value; this.value=''; this.value=temp_value"/>&nbsp;&nbsp;&nbsp;
                                                      <?php echo form_error('jobtitle[]'); ?>
                                                      </span>
                                                      <label style="   margin-top: 6px; ">Organization Name:<span class="red">*</span></label>
                                                      <input type="text" name="companyname[]" id="companyname"  class="companyname" tabindex="4"placeholder="Enter Organization Name" value="<?php
                                                         if ($companyname1) {
                                                             echo $companyname1;
                                                         }
                                                         ?>" maxlength="255"/>&nbsp;&nbsp;&nbsp; 
                                                      <?php echo form_error('companyname'); ?>
                                                      <label style="  margin-top: 6px;  ">Organization Email:<span class="optional">(optional)</span></label>
                                                      <input type="text" name="companyemail[]" tabindex="5" id="companyemail" class="companyemail" placeholder="Enter Organization Email" value="<?php
                                                         if ($companyemail1) {
                                                             echo $companyemail1;
                                                         }
                                                         ?>" maxlength="255"/>&nbsp;&nbsp;&nbsp; 
                                                      <label style="  margin-top: 6px;  ">Organization Phone:<span class="optional">(optional)</span></label>
                                                      <input type="text" name="companyphn[]" id="companyphn" class="companyphn" placeholder="Enter Organization Phone" tabindex="6" value="<?php
                                                         if ($companyphn1) {
                                                             echo $companyphn1;
                                                         }
                                                         ?>"  maxlength="15" />&nbsp;&nbsp;&nbsp; <span id="companyphn-error"> </span>
                                                      <?php echo form_error('companyphn[]'); ?>
                                                      <label style="  display: block;">Experience Certificate:</label>
                                                      <input style="width:100%;  margin-bottom: 30px; display: inline-block;" type="file" name="certificate[]" id="certificate" tabindex="6" class="certificate fl" placeholder="CERTIFICATE"  tabindex="7" />
                                                      <div class="bestofmine_image_degree" style="color:#f00; display: block;"></div>
                                                      &nbsp;&nbsp;&nbsp; 
                                                      <?php
                                                         if ($work_certificate1) {
                                                             ?>
                                                      <div class="img_work_exp fl" style=" " >
                                                         <?php
                                                            $ext = explode('.',$work_certificate1);
                                                            if($ext[1] == 'pdf')
                                                               { 
                                                            ?>
                                                        
                                                         <a title="open pdf" href="<?php echo JOB_WORK_MAIN_UPLOAD_URL . $work_certificate1 ?>"><i class="fa fa-file-pdf-o fa-2x" style="color: red; padding-left: 8px; padding-top: 10px; padding-bottom: 10px; position: relative;" aria-hidden="true"></i></a>
                                                         <?php
                                                            }
                                                            else
                                                            {
                                                            ?>
                                                         <img src="<?php echo JOB_WORK_MAIN_UPLOAD_URL . $work_certificate1 ?>" style="width:100px;height:100px;" alt="<?php echo $work_certificate1; ?>">
                                                         <?php
                                                            }//else end
                                                            ?>
                                                      </div>
                                                      <?php
                                                         }//if $work_certificate1 end
                                                         ?>
                                                      <?php if($work_certificate1)
                                                         {
                                                         ?>
                                                      <div style="float: left;" id="work_certi">
                                                         <div class="hs-submit full-width fl">
                                                           
                                                            <button type="button" class="cust-modal-close delete_graduation"  onClick="delete_workexp('<?php echo $workdata[$x]['work_id']; ?>','<?php echo $work_certificate1; ?>')" data-dismiss="modal">×</button>
                                                         </div>
                                                      </div>
                                                      <?php
                                                         }
                                                         ?>
                                                      <span id="certificate-error"> </span>
                                                      <?php echo form_error('certificate'); ?>
                                                      <input type="hidden" name="image_hidden_certificate[]" value="<?php
                                                         if ($work_certificate1) {
                                                             echo $work_certificate1;
                                                         }
                                                         ?>">
                                                      <?php if ($y != 1) {
                                                         ?>
                                                      <div class="hs-submit full-width fl " style="margin-top: 29px;">
                                                         <input class="delete_btn" style="min-width: 70px;" type="button" value="Delete" onclick="delete_job_work('<?php echo $workdata[$x]['work_id']; ?>','<?php echo $work_certificate1; ?>')">
                                                      </div>
                                                      <?php } ?>
                                                   <!--</div>-->
                                                </div>
                                                <?php
                                                   }
                                                   ?>
                                                <div class="hs-submit full-width fl"  style=" width: 100%; text-align: center;">
                                                   <input type="button" tabindex="6" id="btnAdd" value=" + ">
                                                   <input type="button" tabindex="7" id="btnRemove" value=" - " disabled="disabled">
                                                </div>
                                             
                                                <fieldset class="hs-submit full-width"> 
                                                   <!-- <input title="Submit" style="" type="submit"  tabindex="8" id="next" name="next" value="Submit"  > -->

                                                   <button tabindex="8" id="next" name="next" onclick="return profile_reg();">Submit<span class="ajax_load pl10" id="fre_ajax_load"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
                                                </fieldset>
                                               
                                                <?php
                                                   }
                                                   //INSERT TIME
                                                    else {
                                                       ?>
                                                <!--clone div start-->              
                                                <div id="input1" style="margin-bottom:4px;position: relative;" class="clonedInput job_work_experience_main_div">
                                                  
                                                   <label>Experience:<span class="red">*</span></label>
                                                   <select style="width:45%; float: left; margin-right: 4%;" name="experience_year[]" id="experience_year" class="experience_year keyskil" onchange="expyear_change();">
                                                      <option value="" selected option disabled>Year</option>
                                                      <option value="0 year"  <?php if ($experience_year1 == "0 year") echo 'selected'; ?>>0 year</option>
                                                      <option value="1 year"  <?php if ($experience_year1 == "1 year") echo 'selected'; ?>>1 year</option>
                                                      <option value="2 year"  <?php if ($experience_year1 == "2 year") echo 'selected'; ?>>2 year</option>
                                                      <option value="3 year"  <?php if ($experience_year1 == "3 year") echo 'selected'; ?>>3 year</option>
                                                      <option value="4 year"  <?php if ($experience_year1 == "4 year") echo 'selected'; ?>>4 year</option>
                                                      <option value="5 year"  <?php if ($experience_year1 == "5 year") echo 'selected'; ?>>5 year</option>
                                                      <option value="6 year"  <?php if ($experience_year1 == "6 year") echo 'selected'; ?>>6 year</option>
                                                      <option value="7 year"  <?php if ($experience_year1 == "7 year") echo 'selected'; ?>>7 year</option>
                                                      <option value="8 year"  <?php if ($experience_year1 == "8 year") echo 'selected'; ?>>8 year</option>
                                                      <option value="9 year"  <?php if ($experience_year1 == "9 year") echo 'selected'; ?>>9 year</option>
                                                      <option value="10 year"  <?php if ($experience_year1 == "10 year") echo 'selected'; ?>>10 year</option>
                                                      <option value="11 year"  <?php if ($experience_year1 == "11 year") echo 'selected'; ?>>11 year</option>
                                                      <option value="12 year"  <?php if ($experience_year1 == "12 year") echo 'selected'; ?>>12 year</option>
                                                      <option value="13 year"  <?php if ($experience_year1 == "13 year") echo 'selected'; ?>>13 year</option>
                                                      <option value="14 year"  <?php if ($experience_year1 == "14 year") echo 'selected'; ?>>14 year</option>
                                                      <option value="15 year"  <?php if ($experience_year1 == "15 year") echo 'selected'; ?>>15 year</option>
                                                      <option value="16 year"  <?php if ($experience_year1 == "16 year") echo 'selected'; ?>>16 year</option>
                                                      <option value="17 year"  <?php if ($experience_year1 == "17 year") echo 'selected'; ?>>17 year</option>
                                                      <option value="18 year"  <?php if ($experience_year1 == "18 year") echo 'selected'; ?>>18 year</option>
                                                      <option value="19 year"  <?php if ($experience_year1 == "19 year") echo 'selected'; ?>>19 year</option>
                                                      <option value="20 year"  <?php if ($experience_year1 == "20 year") echo 'selected'; ?>>20 year</option>
                                                   </select>
                                                    <?php echo form_error('experience_year[]'); ?>
                                                   <select style="width:46%;" name="experience_month[]" id="experience_month" class="experience_month keyskil" disabled>
                                                      <option value="" selected option disabled>Month</option>
                                                      <option value="0 month"  <?php if ($experience_month1 == "0 month") echo 'selected'; ?>>0 month</option>
                                                      <option value="1 month"  <?php if ($experience_month1 == "1 month") echo 'selected'; ?>>1 month</option>
                                                      <option value="2 month"  <?php if ($experience_month1 == "2 month") echo 'selected'; ?>>2 month</option>
                                                      <option value="3 month"  <?php if ($experience_month1 == "3 month") echo 'selected'; ?>>3 month</option>
                                                      <option value="4 month"  <?php if ($experience_month1 == "4 month") echo 'selected'; ?>>4 month</option>
                                                      <option value="5 month"  <?php if ($experience_month1 == "5 month") echo 'selected'; ?>>5 month</option>
                                                      <option value="6 month"  <?php if ($experience_month1 == "6 month") echo 'selected'; ?>>6 month</option>
                                                      <option value="7 month"  <?php if ($experience_month1 == "7 month") echo 'selected'; ?>>7 month</option>
                                                      <option value="8 month"  <?php if ($experience_month1 == "8 month") echo 'selected'; ?>>8 month</option>
                                                      <option value="9 month"  <?php if ($experience_month1 == "9 month") echo 'selected'; ?>>9 month</option>
                                                      <option value="10 month"  <?php if ($experience_month1 == "10 month") echo 'selected'; ?>>10 month</option>
                                                      <option value="11 month"  <?php if ($experience_month1 == "11 month") echo 'selected'; ?>>11 month</option>
                                                      <option value="12 month"  <?php if ($experience_month1 == "12 month") echo 'selected'; ?>>12 month</option>
                                                   </select>
                                                  
                                                   <?php echo form_error('experience_month[]'); ?>&nbsp;&nbsp; 
                                                   <label style="    margin-top: 6px; width:100%; float:left;">Job Title:<span class="red">*</span></label>
                                                   <input type="text" name="jobtitle[]"  class="jobtitle" id="jobtitle"  placeholder="Enter Job Title" value="<?php
                                                      if ($jobtitle1) {
                                                          echo $jobtitle1;
                                                      }
                                                      ?>" maxlength="255"/>&nbsp;&nbsp; 
                                                   <?php echo form_error('jobtitle[]'); ?>
                                                   </span>
                                                   <label style=" margin-top: 6px;  ">Organization Name:<span class="red">*</span></label>
                                                   <input type="text" name="companyname[]" id="companyname"  class="companyname" placeholder="Enter Organization Name" value="<?php
                                                      if ($companyname1) {
                                                          echo $companyname1;
                                                      }
                                                      ?>" maxlength="255"/>&nbsp;&nbsp;
                                                   <?php echo form_error('companyname[]'); ?>
                                                   <label style="   margin-top: 6px; ">Organization Email:<span class="optional">(optional)</span></label>
                                                   <input type="text" name="companyemail[]" id="companyemail" class="companyemail" placeholder="Enter Organization Email" value="<?php
                                                      if ($companyemail1) {
                                                          echo $companyemail1;
                                                      }
                                                      ?>" maxlength="255"/>&nbsp;&nbsp; <span id="companyemail-error"> </span>
                                                  
                                                   <label style="  margin-top: 6px; ">Organization Phone:<span class="optional">(optional)</span></label>
                                                   <input type="text" name="companyphn[]" id="companyphn" class="companyphn" placeholder="Enter Organization Phone" value="<?php
                                                      if ($companyphn1) {
                                                          echo $companyphn1;
                                                      }
                                                      ?>"   maxlength="15"/>&nbsp;&nbsp; <span id="companyphn-error"> </span>
                                                   <?php echo form_error('companyphn'); ?>&nbsp;&nbsp;
                                                 
                                                   <label style="      display: block;">Experience Certificate:</label>
                                                   <input style="display: inline-block;" type="file" name="certificate[]" id="certificate" class="certificate" placeholder="CERTIFICATE" />
                                                    <div class="bestofmine_image_degree" style="color:#f00; display: block;"></div>&nbsp;&nbsp;

                                                   <?php
                                                      if ($work_certificate1) {
                                                          ?>
                                                   <div class="img_work_exp" style="">
                                                      <?php
                                                         $ext = explode('.',$work_certificate1);
                                                         if($ext[1] == 'pdf')
                                                            { 
                                                         ?>
                                                     
                                                      <a title="open pdf" href="<?php echo JOB_WORK_MAIN_UPLOAD_URL . $work_certificate1 ?>"><i class="fa fa-file-pdf-o fa-2x" style="color: red; padding-left: 8px; padding-top: 10px; padding-bottom: 10px; position: relative;" aria-hidden="true"></i></a>
                                                      <?php
                                                         }
                                                         else
                                                         {
                                                         ?>
                                                      <img src="<?php echo JOB_WORK_MAIN_UPLOAD_URL . $work_certificate1 ?>" style="width:100px;height:100px;" alt="<?php echo $work_certificate1; ?>">
                                                      <?php
                                                         }
                                                         ?>
                                                   </div>
                                                   <?php
                                                      }
                                                      ?>
                                                   <span id="certificate-error"> </span>
                                                   <?php echo form_error('certificate'); ?>
                                               
                                                </div>
                                               
                                                <div class="hs-submit full-width fl" style="width: 100%; text-align: center;">
                                                   <input title="Add more Experience" type="button" id="btnAdd" value=" + ">
                                                   <input title="Remove Experience" type="button" id="btnRemove" value=" - " disabled="disabled">
                                                </div>
                                                <fieldset class="hs-submit full-width"> 
                                                   <!-- <input title="Submit" style="" type="submit" id="next" name="next" value="Submit"> -->

                                                    <button tabindex="8" id="next" name="next" onclick="return profile_reg1();">Submit<span class="ajax_load pl10" id="exp_ajax_load"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>

                                                </fieldset>
                                                <?php echo form_close(); ?> 
                                             </div>
                                          </div>
                                       </div>
                                       <!-- end of panel -->
                                    </div>
                                    <!-- end of #bs-collapse  -->
                                 </div>
                              </div>
                              <!-- end of container -->
                           </div>                             
                           <?php
                              }
                              ?>
                        </div>
                     </div>
                  </div>
                  <!-- middle section end -->
               </div>
            </div>
         </div>
      </section>
      <!-- END CONTAINER -->

         <!-- Bid-modal  -->
      <div class="modal fade message-box biderror custom-message in" id="bidmodal" role="dialog"  >
         <div class="modal-dialog modal-lm" >
            <div class="modal-content message">
               <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
               <div class="modal-body">
                  <span class="mes"></span>
               </div>
            </div>
         </div>
      </div>
      <!-- Model Popup Close -->


<?php echo $login_footer ?>  
<?php echo $footer;  ?>


<!-- This Js is used for call popup -->

<?php
        if (IS_JOB_JS_MINIFY == '0') {
            ?>
<script src="<?php echo base_url('assets/js/jquery.fancybox.js?ver='.time()); ?>"></script>
<!-- duplicate div end -->
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()) ?>"></script>
<script type="text/javascript" src="<?php  echo base_url('assets/js/jquery.validate.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php  echo base_url('assets/js/additional-methods1.15.0.min.js?ver='.time()); ?>"></script> 
<!-- This Js is used for call popup -->
<script src="<?php echo base_url('assets/js/bootstrap.min.js?ver='.time()); ?>"></script> 

<?php }else{?>


<script src="<?php echo base_url('assets/js_min/jquery.fancybox.js?ver='.time()); ?>"></script>
<!-- duplicate div end -->
<script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver='.time()) ?>"></script>
<script type="text/javascript" src="<?php  echo base_url('assets/js_min/jquery.validate.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php  echo base_url('assets/js_min/additional-methods1.15.0.min.js?ver='.time()); ?>"></script> 
<!-- This Js is used for call popup -->
<script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver='.time()); ?>"></script> 

<?php }?>
<script>
    var base_url = '<?php echo base_url(); ?>';
    var clone_mathod_count='<?php echo $clone_mathod_count; ?>';
</script>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/job_work_exp.js?ver='.time()); ?>"></script>
<?php
        if (IS_JOB_JS_MINIFY == '0') {
            ?>
<!--<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/job/job_work_exp.js?ver='.time()); ?>"></script>-->
<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/job/search_common.js?ver='.time()); ?>"></script>
<?php }else{?>
<!--<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/job/job_work_exp.js?ver='.time()); ?>"></script>-->
<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/job/search_common.js?ver='.time()); ?>"></script>
<?php }?>
 </body>
</html>

