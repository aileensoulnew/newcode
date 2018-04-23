<!DOCTYPE html>
<html>
   <head>
<!-- start head -->

<?php echo $head; ?> 

<title><?php echo $title; ?></title>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/1.10.3.jquery-ui.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/test.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/custom-job-style.css?ver='.time()); ?>">
<!-- This Css is used for call popup -->
<link rel="stylesheet" href="<?php echo base_url('css/jquery.fancybox.css?ver='.time()); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/profiles/job/job.css?ver='.time()); ?>">

</head>
<!-- END HEAD -->

<!-- Start HEADER -->
<?php 
      echo $header; 
      echo $job_header2_border;  
?>
<!-- END HEADER -->
 
<div class="js">
<body class="page-container-bg-solid page-boxed">
  <!--  <div id="preloader"></div> -->
   <section>
      <div class="user-midd-section" id="paddingtop_fixed_job">
      <div class="common-form1">
         <div class="col-md-3 col-sm-4"></div>
        
         <div class="col-md-6 col-sm-8">
            <h3>You are updating your Job Profile.</h3>
         </div>
       
      </div>
     
      <div class="container">
      <div class="row row4">

           <!-- Job leftbar start-->
              <?php echo $job_left; ?>
           <!-- Job leftbar End-->
          
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
            <div class="common-form">
               <div class="job-saved-boxe_2" >
                  <div class="edu_tab fw">
                     <h3>Educational  Qualification</h3>


                     <div class="col-md-12 col-sm-12 col-xs-12">

                        <div class="panel-group wrap" id="bs-collapse">

                           <div class="panel">
                              <div <?php if($this->uri->segment(3) =="primary"){ ?> class="panel-heading active" <?php }else{ ?> class="panel-heading" <?php } ?> id="panel-heading">
                                 <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#bs-collapse" href="#one" id="toggle">
                                    Primary
                                    </a>
                                 </h4>
                              </div>
                              <div id="one" <?php if($this->uri->segment(3) =="primary"){ ?> class="panel-collapse collapse in"<?php }else{ ?> class="panel-collapse collapse" <?php } ?>>

                                 <div class="panel-body">
                                    <section id="section1">
                                       <article class="none_aaaart">
                                          <?php echo form_open_multipart(base_url('job/job_education_primary_insert'), array('id' => 'jobseeker_regform_primary', 'name' => 'jobseeker_regform_primary', 'class' => 'clearfix')); ?>
                                          <?php
                                             $contition_array = array('user_id' => $userid, 'status' => 1);
                                             $jobdata = $this->data['jobdata'] = $this->common->select_data_by_condition('job_add_edu', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                            
                                             $board_primary1 = $jobdata[0]['board_primary'];
                                            
                                             $school_primary1 = $jobdata[0]['school_primary'];
                                             $percentage_primary1 = $jobdata[0]['percentage_primary'];
                                             $pass_year_primary1 = $jobdata[0]['pass_year_primary'];
                                             $edu_certificate_primary1 = $jobdata[0]['edu_certificate_primary'];
                                             ?>
                                          <fieldset class="full-width">
                                             <h6>Board :<span style="color:red">*</span></h6>
                                             <input type="text" tabindex="1" autofocus name="board_primary" id="board_primary" placeholder="Enter Board" value="<?php
                                                if ($board_primary1) {
                                                    echo $board_primary1;
                                                }
                                                ?>" maxlength="255" onfocus="var temp_value=this.value; this.value=''; this.value=temp_value">
                                          </fieldset>
                                          <fieldset class="full-width">
                                             <h6>School :<span class="red">*</span></h6>
                                             <input type="text" name="school_primary" tabindex="2" id="school_primary" placeholder="Enter School Name" value="<?php
                                                if ($school_primary1) {
                                                    echo $school_primary1;
                                                }
                                                ?>" maxlength="255">
                                          </fieldset>
                                          <fieldset class="full-width">
                                             <h6>Percentage :<span class="red">*</span></h6>
                                             <input type="text" name="percentage_primary" tabindex="3" id="percentage_primary" placeholder="Enter Percentage"  value="<?php
                                                if ($percentage_primary1) {
                                                    echo $percentage_primary1;
                                                }
                                                ?>" maxlength="5" />
                                          </fieldset>
                                          <fieldset class="full-width">
                                             <h6>Year Of Passing :<span style="color:red">*</span></h6>
                                             <select name="pass_year_primary" id="pass_year_primary" tabindex="4" class="pass_year_primary" >
                                                <option value="" selected option disabled>--SELECT--</option>
                                                <?php
                                                   $curYear = date('Y');
                                                   
                                                   for ($i = $curYear; $i >= 1900; $i--) {
                                                       if ($pass_year_primary1) {
                                                           ?>
                                                <option value="<?php echo $i ?>" <?php if ($i == $pass_year_primary1) echo 'selected'; ?>><?php echo $i ?></option>
                                                <?php
                                                   }
                                                   else {
                                                       ?>
                                                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                                <?php
                                                   }
                                                   }
                                                   ?> 
                                             </select>
                                          </fieldset>
                                          <fieldset class="full-width" id="primary_remove">
                                             <h6>Education Certificate:</h6>
                                             <input  type="file" name="edu_certificate_primary" tabindex="5" id="edu_certificate_primary" class="edu_certificate_primary" placeholder="CERTIFICATE" multiple="" />
                                             <div class="bestofmine_image_primary" style="color:#f00; display: block;"></div>
                                             <?php
                                                if ($edu_certificate_primary1) {
                                                   $ext = explode('.',$edu_certificate_primary1);
                                                   if($ext[1] == 'pdf')
                                                      { 
                                                   ?>
                                                    <div class="dele_highrt">
                                                       
                                                         <a title="open pdf" class="fl" href="<?php echo JOB_EDU_MAIN_UPLOAD_URL  . $edu_certificate_primary1 ?>"><i class="fa fa-file-pdf-o fa-2x" style="color: red;" aria-hidden="true"></i></a>

                                                      <div style="float: left;" id="primary_certi" class="tsecondary_certi">
                                                <div class="hs-submit full-width fl">
                                                  <label for="delete_job_edu"><i class="fa fa-times" aria-hidden="true"></i></label>
                                                   <input  type="button" id="delete_job_edu" value="Delete" style="display: none;" onClick="delete_primary('<?php echo $jobdata[0]['edu_id']; ?>','<?php echo $edu_certificate_primary1; ?>')">
                                                </div>
                                             </div>
                                             </div>

                                                      <?php
                                                      }
                                                      else
                                                      {
                                                    ?>
                                           <div class="dele_highrt">
        
                                             <img class="fl" src="<?php echo JOB_EDU_MAIN_UPLOAD_URL  . $edu_certificate_primary1 ?>"  style="width:100px;height:100px;" class="job_education_certificate_img" >
                                               <div style="float: left;" id="primary_certi" class="tsecondary_certi">
                                                <div class="hs-submit full-width fl">
                                                  <label for="delete_job_edu"><i class="fa fa-times" aria-hidden="true"></i></label>
                                                   <input  type="button" id="delete_job_edu" value="Delete" style="display: none;" onClick="delete_primary('<?php echo $jobdata[0]['edu_id']; ?>','<?php echo $edu_certificate_primary1; ?>')">
                                                </div>
                                             </div>
                                           </div> 
                                             <?php
                                                }
                                             }
                                                 ?>
                                          </fieldset>

                                          <div class="fr job_education_submitbox">
                                             <input type="hidden" name="image_hidden_primary" value="<?php
                                                if ($edu_certificate_primary1) {
                                                 echo $edu_certificate_primary1;
                                                     }
                                                     ?>">
                                             <br>

                                             <button class="submit_btn" tabindex="6">Save</button>
                                             <fieldset class="hs-submit full-width" style="">
                                              
                                             </fieldset>
                                          </div>
                                          <?php echo form_close(); ?>
                                       </article>
                                    </section>
                                 </div>
                              </div>
                           </div>
                           <!-- end of panel -->
                           <div class="panel">
                              <div  <?php if($this->uri->segment(3) =="secondary"){ ?> class="panel-heading active" <?php }else{ ?> class="panel-heading" <?php } ?>  id="panel-heading1">
                                 <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#bs-collapse" href="#two" id="toggle1">
                                    Secondary
                                    </a>
                                 </h4>
                              </div>
                              <div id="two" <?php if($this->uri->segment(3) =="secondary"){ ?> class="panel-collapse collapse in"<?php }else{ ?> class="panel-collapse collapse" <?php } ?> >
                                 <div class="panel-body">
                                    <section id="section2">
                                       <?php echo form_open_multipart(base_url('job/job_education_secondary_insert'), array('id' => 'jobseeker_regform_secondary', 'name' => 'jobseeker_regform_secondary', 'class' => 'clearfix')); ?>
                                       <?php
                                          $contition_array = array('user_id' => $userid, 'status' => 1);
                                          $jobdata = $this->data['jobdata'] = $this->common->select_data_by_condition('job_add_edu', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                          
                                          $board_secondary1 = $jobdata[0]['board_secondary'];
                                          $school_secondary1 = $jobdata[0]['school_secondary'];
                                          $percentage_secondary1 = $jobdata[0]['percentage_secondary'];
                                          $pass_year_secondary1 = $jobdata[0]['pass_year_secondary'];
                                          $edu_certificate_secondary1 = $jobdata[0]['edu_certificate_secondary'];
                                          ?>
                                       <fieldset class="full-width">
                                          <h6>Board :<span style="color:red">*</span></h6>
                                          <input type="text" tabindex="1" autofocus  name="board_secondary" id="board_secondary" placeholder="Enter Board" value="<?php
                                             if ($board_secondary1) {
                                                 echo $board_secondary1;
                                             }
                                             ?>" maxlength="255" onfocus="var temp_value=this.value; this.value=''; this.value=temp_value">
                                       </fieldset>
                                       <fieldset class="full-width">
                                          <h6>School :<span class="red">*</span></h6>
                                          <input type="text" name="school_secondary" tabindex="2" id="school_secondary" placeholder="Enter School Name" value="<?php
                                             if ($school_secondary1) {
                                                 echo $school_secondary1;
                                             }
                                             ?>" maxlength="255">
                                       </fieldset>
                                       <fieldset class="full-width">
                                          <h6>Percentage :<span class="red">*</span></h6>
                                          <input type="text" name="percentage_secondary" tabindex="3" id="percentage_secondary" placeholder="Enter Percentage"  value="<?php
                                             if ($percentage_secondary1) {
                                                 echo $percentage_secondary1;
                                             }
                                             ?>"  maxlength="5" />
                                       </fieldset>
                                       <fieldset class="full-width">
                                          <h6>Year Of Passing :<span class="red">*</span></h6>
                                          <select name="pass_year_secondary" tabindex="4" id="pass_year_secondary" class="pass_year_secondary" >
                                             <option value="" selected option disabled>--SELECT--</option>
                                             <?php
                                                $curYear = date('Y');
                                                
                                                for ($i = $curYear; $i >= 1900; $i--) {
                                                    if ($pass_year_secondary1) {
                                                        ?>
                                             <option value="<?php echo $i ?>" <?php if ($i == $pass_year_secondary1) echo 'selected'; ?>><?php echo $i ?></option>
                                             <?php
                                                }
                                                else {
                                                    ?>
                                             <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                             <?php
                                                }
                                                }
                                                ?> 
                                          </select>
                                       </fieldset>
                                       <fieldset class="full-width" id="secondary_remove">
                                          <h6>Education Certificate:</h6>
                                          <input type="file" tabindex="6" name="edu_certificate_secondary" id="edu_certificate_secondary" class="edu_certificate_secondary" placeholder="CERTIFICATE" multiple="" />
                                          <div class="bestofmine_image_secondary" style="color:#f00; display: block;"></div>

                                           <?php
                                                if ($edu_certificate_secondary1) {
                                                   $ext = explode('.',$edu_certificate_secondary1);
                                                   if($ext[1] == 'pdf')
                                                      { 
                                                   ?>
                                                   <div class="dele_highrt">
                                                         
                                                          <a title="open pdf" class="fl" href="<?php echo JOB_EDU_MAIN_UPLOAD_URL . $edu_certificate_secondary1 ?>"><i class="fa fa-file-pdf-o fa-2x" style="color: red;" aria-hidden="true"></i></a>

                                                <div style="float: left;" id="secondary_certi" class="tsecondary_certi">
                                                <div class="hs-submit full-width fl">
                                                   <label for="delete_job_edu"><i class="fa fa-times" aria-hidden="true"></i></label>
                                                   <input id="delete_job_edu"  type="button" style="display: none;" value="Delete" onClick="delete_secondary('<?php echo $jobdata[0]['edu_id']; ?>','<?php echo $edu_certificate_secondary1; ?>')">
                                                </div>
                                             </div>

                                             </div>
                                                      <?php
                                                      }
                                                      else
                                                      {
                                                    ?>
                                                     <div class="dele_highrt">
                                              <img src="<?php echo JOB_EDU_MAIN_UPLOAD_URL. $edu_certificate_secondary1 ?>" style="width:100px;height:100px;" class="job_education_certificate_img ">

                                                <div style="float: left;" id="secondary_certi" class="tsecondary_certi">
                                                <div class="hs-submit full-width fl">
                                                   <label for="delete_job_edu"><i class="fa fa-times" aria-hidden="true"></i></label>
                                                   <input id="delete_job_edu"  type="button" style="display: none;" value="Delete" onClick="delete_secondary('<?php echo $jobdata[0]['edu_id']; ?>','<?php echo $edu_certificate_secondary1; ?>')">
                                                </div>
                                             </div>
</div>

                                             <?php
                                                }
                                             }
                                          ?>

                                       </fieldset>

                                       <div class="fr job_education_submitbox">
                                          <input type="hidden" name="image_hidden_secondary" value="<?php
                                             if ($edu_certificate_secondary1) {
                                                  echo $edu_certificate_secondary1;
                                                  }
                                                 ?>">
                                          <button class="submit_btn" tabindex="7">Save</button>
                                          <br>
                                          <fieldset class="hs-submit full-width" style="">
                                           
                                          </fieldset>
                                       </div>
                                       <?php echo form_close(); ?>
                                       </article>
                                    </section>
                                 </div>
                              </div>
                           </div>
                           <!-- end of panel -->
                           <div class="panel">
                              <div <?php if($this->uri->segment(3) =="higher-secondary"){ ?> class="panel-heading active" <?php }else{ ?> class="panel-heading" <?php } ?> id="panel-heading2">
                                 <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#bs-collapse" href="#three" id="toggle2">
                                    Higher secondary
                                    </a>
                                 </h4>
                              </div>
                              <div id="three"  <?php if($this->uri->segment(3) =="higher-secondary"){ ?> class="panel-collapse collapse in" <?php }else{ ?> class="panel-collapse collapse" <?php } ?> >
                                 <div class="panel-body">
                                    <section id="section3">
                                       <?php echo form_open_multipart(base_url('job/job_education_higher_secondary_insert'), array('id' => 'jobseeker_regform_higher_secondary', 'name' => 'jobseeker_regform_higher_secondary', 'class' => 'clearfix')); ?>
                                       <?php
                                          $contition_array = array('user_id' => $userid, 'status' => 1);
                                          $jobdata = $this->data['jobdata'] = $this->common->select_data_by_condition('job_add_edu', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                          
                                          $board_higher_secondary1 = $jobdata[0]['board_higher_secondary'];
                                          $stream_higher_secondary1 = $jobdata[0]['stream_higher_secondary'];
                                          $school_higher_secondary1 = $jobdata[0]['school_higher_secondary'];
                                          $percentage_higher_secondary1 = $jobdata[0]['percentage_higher_secondary'];
                                          $pass_year_higher_secondary1 = $jobdata[0]['pass_year_higher_secondary'];
                                          $edu_certificate_higher_secondary1 = $jobdata[0]['edu_certificate_higher_secondary'];
                                          ?>
                                       <fieldset class="full-width">
                                          <h6>Board :<span class="red">*</span></h6>
                                          <input type="text" tabindex="1" autofocus name="board_higher_secondary" id="board_higher_secondary" placeholder="Enter Board" value="<?php
                                             if ($board_higher_secondary1) {
                                                 echo $board_higher_secondary1;
                                             }
                                             ?>" maxlength="255" onfocus="var temp_value=this.value; this.value=''; this.value=temp_value">
                                       </fieldset>
                                       <fieldset class="full-width">
                                          <h6>Stream :<span class="red">*</span></h6>
                                          <input type="text" name="stream_higher_secondary" tabindex="2" id="stream_higher_secondary" placeholder="Enter Stream" value="<?php
                                             if ($stream_higher_secondary1) {
                                                 echo $stream_higher_secondary1;
                                             }
                                             ?>" maxlength="255">
                                       </fieldset>
                                       <fieldset class="full-width">
                                          <h6>School :<span class="red">*</span></h6>
                                          <input type="text" name="school_higher_secondary" tabindex="3" id="school_higher_secondary" placeholder="Enter School Name" value="<?php
                                             if ($school_higher_secondary1) {
                                                 echo $school_higher_secondary1;
                                             }
                                             ?>" maxlength="255">
                                       </fieldset>
                                       <fieldset class="full-width">
                                          <h6>Percentage :<span class="red">*</span></h6>
                                          <input type="text" tabindex="4" name="percentage_higher_secondary" id="percentage_higher_secondary" placeholder="Enter Percentage"  value="<?php
                                             if ($percentage_higher_secondary1) {
                                                 echo $percentage_higher_secondary1;
                                             }
                                             ?>"  maxlength="5" />
                                       </fieldset>
                                       <fieldset class="full-width">
                                          <h6>Year Of Passing :<span class="red">*</span></h6>
                                          <select tabindex="5" name="pass_year_higher_secondary" id="pass_year_higher_secondary" class="pass_year_higher_secondary" >
                                             <option value="" selected option disabled>--SELECT--</option>
                                             <?php
                                                $curYear = date('Y');
                                                
                                                for ($i = $curYear; $i >= 1900; $i--) {
                                                    if ($pass_year_higher_secondary1) {
                                                        ?>
                                             <option value="<?php echo $i ?>" <?php if ($i == $pass_year_higher_secondary1) echo 'selected'; ?>><?php echo $i ?></option>
                                             <?php
                                                }
                                                else {
                                                    ?>
                                             <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                             <?php
                                                }
                                                }
                                                ?> 
                                          </select>
                                       </fieldset>
                                       <fieldset class="full-width" id="higher_secondary_remove">
                                          <h6>Education Certificate:</h6>
                                          <input type="file" name="edu_certificate_higher_secondary" id="edu_certificate_higher_secondary" class="edu_certificate_higher_secondary" placeholder="CERTIFICATE" multiple="" tabindex="6" />
                                          <div class="bestofmine_image_higher_secondary" style="color:#f00; display: block;"></div>
                                          <?php
                                                if ($edu_certificate_higher_secondary1) {
                                                   ?>
                                                   
                                             <?php
                                                   $ext = explode('.',$edu_certificate_higher_secondary1);
                                                   if($ext[1] == 'pdf')
                                                      { 
                                                   ?>
                                                       <div class="dele_highrt">
                                                        
                                                      <a title="open pdf" class="fl" href="<?php echo JOB_EDU_MAIN_UPLOAD_URL. $edu_certificate_higher_secondary1 ?>"><i class="fa fa-file-pdf-o fa-2x" style="color: red;" aria-hidden="true"></i></a>


                                                          <div style="float: left;" id="higher_secondary_certi" class="tsecondary_certi">
                                                <div class="hs-submit full-width fl">
                                                <label for="delete_job_edu"><i class="fa fa-times" aria-hidden="true"></i></label>
                                                   <input  type="button" style="display: none;" value="Delete" id="delete_job_edu" onClick="delete_higher_secondary('<?php echo $jobdata[0]['edu_id']; ?>','<?php echo $edu_certificate_higher_secondary1; ?>')">
                                                </div>
                                             </div>

</div>

                                                      <?php
                                                      }
                                                      else
                                                      {
                                                    ?>
                                              
                                              <div class="dele_highrt">
                                               <img src="<?php echo base_url($this->config->item('job_edu_thumb_upload_path')  . $edu_certificate_higher_secondary1) ?>" style="width:100px;height:100px;" class="job_education_certificate_img">
                                              
                                              
                                              <div style="float: left;" id="higher_secondary_certi" class="tsecondary_certi">
                                                <div class="hs-submit full-width fl">
                                                   <label for="delete_job_edu"><i class="fa fa-times" aria-hidden="true"></i></label>
                                                   <input  type="button" id="delete_job_edu" style="display: none;" value="Delete" onClick="delete_higher_secondary('<?php echo $jobdata[0]['edu_id']; ?>','<?php echo $edu_certificate_higher_secondary1; ?>')">
                                                </div>
                                             
                                             </div>
                                             </div>

                                             <?php
                                                }
                                             }
                                          ?>

                                       </fieldset>

                                   
                                       <div class="fr job_education_submitbox">
                                          <input type="hidden"  tabindex="8" name="image_hidden_higher_secondary" value="<?php
                                             if ($edu_certificate_higher_secondary1) {
                                                 echo $edu_certificate_higher_secondary1;
                                             }
                                             ?>">
                                          <button class="submit_btn" tabindex="9">Save</button>
                                          <br>
                                          <fieldset class="hs-submit full-width" style="">
                                            
                                          </fieldset>
                                       </div>
                                       <?php echo form_close(); ?>
                                       </article>
                                    </section>
                                 </div>
                              </div>
                           </div>
                           <!-- end of panel -->
                           <div class="panel">
                              <div <?php if($this->uri->segment(3) =="graduation"){ ?> class="panel-heading active" <?php }else{ ?> class="panel-heading" <?php } ?>  id="panel-heading3">
                                 <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#bs-collapse" href="#four" id="toggle3">
                                    Graduation / Post Graduation
                                    </a>
                                 </h4>
                              </div>
                              <div id="four" <?php if($this->uri->segment(3) =="graduation"){ ?> class="panel-collapse collapse in" <?php }else{ ?> class="panel-collapse collapse" <?php } ?> >
                                 <div class="panel-body">
                                    <section id="section4">
                                       <?php echo form_open_multipart(base_url('job/job_education_insert'), array('id' => 'jobseeker_regform', 'name' => 'jobseeker_regform', 'class' => 'clearfix border_none')); ?>
                                       <?php
                                          $predefine_data = 1;
                                          if ($jobgrad) {
                                              $count = count($jobgrad);
                                            //  echo"<pre>";print_r($count);die();
                                              for ($x = 0; $x < $count; $x++) {
                                          
                                                  $degree1 = $jobgrad[$x]['degree'];
                                                  $stream1 = $jobgrad[$x]['stream'];
                                                  $university1 = $jobgrad[$x]['university'];
                                                  $college1 = $jobgrad[$x]['college'];
                                                  $grade1 = $jobgrad[$x]['grade'];
                                                  $percentage1 = $jobgrad[$x]['percentage'];
                                                  $pass_year1 = $jobgrad[$x]['pass_year'];
                                                  $degree_sequence = $jobgrad[$x]['degree_sequence'];
                                                  $stream_sequence = $jobgrad[$x]['stream_sequence'];
                                                  $edu_certificate1 = $jobgrad[$x]['edu_certificate']; 
                                          
                                                  $y = $x + 1;
                                          
                                                 
                                                  if ($count == 0) {
                                                      $predefine_data = 1;
                                                  } else {
                                                      $predefine_data = $count;
                                                  }
                                                  ?>   
                                       <div id="input<?php echo $y ?>" style="margin-bottom:4px;" class="clonedInput job_work_edit_<?php echo $jobgrad[$x]['job_graduation_id']?>">
                                          <input type="hidden" name="education_data[]" value="old" class="exp_data" id="exp_data<?php echo $y; ?>">
                                          <div class="job_work_experience_main_div">
                                             <!--   <fieldset class="full-width"> -->
                                             <h6>Degree :<span class="red">*</span></h6>
                                             <select name="degree[]" id="degree1" tabindex="1" autofocus class="degree">
                                                <option value="" Selected option disabled="">Select your Degree</option>
                                                <?php
                                                  
                                                          if ($degree1) {
                                                          
                                                     foreach ($degree_data as $cnt) {
                                                             ?>
                                                <option value="<?php echo $cnt['degree_id']; ?>" <?php if ($cnt['degree_id'] == $degree1) echo 'selected'; ?>><?php echo $cnt['degree_name']; ?></option>
                                                <?php
                                                   }
                                                   }
                                                   else {
                                                  
                                                   ?>
                                                <option value="<?php echo $cnt['degree_id']; ?>"><?php echo $cnt['degree_name']; ?></option>
                                                <?php
                                                   }
                                                   ?>
        <option value="<?php echo $degree_otherdata[0]['degree_id']; ?> "><?php echo $degree_otherdata[0]['degree_name']; ?></option>  
                                             </select>
                                             <?php echo form_error('degree'); ?>
                                             <!--    </fieldset> -->
                                             <?php
                                             
           $contition_array = array('is_delete' => '0', 'degree_id' => $degree1);
          $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
           $stream_data = $this->data['$stream_data'] = $this->common->select_data_by_search('stream', $search_condition, $contition_array, $data = '*', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = 'stream_name');
                                                
                                      
                                                
                                                ?>
                                          
                                             <h6>Stream :<span class="red">*</span></h6>
                                           
                                             <select name="stream[]" id="stream1"  tabindex="2" class="stream" >
                                                <option value="" selected option disabled>Select Degree First</option>
                                                <?php
                                                   if ($stream1) {
                                                   
                                                  
                                                   foreach ($stream_data as $cnt) {  
                                                   ?>
                                                <option value="<?php echo $cnt['stream_id']; ?>" <?php if ($cnt['stream_id'] == $stream1) echo 'selected'; ?>><?php echo $cnt['stream_name'];?></option>
                                                <?php
                                                   }
                                                   }
                                                    
                                                        else {
                                                        
                                                        ?>
                                                <option value="" selected option disabled>Select Degree First</option>
                                                <?php
                                                   }
                                                   
                                                   ?>
                                                ?>
                                             </select>
                                             <?php echo form_error('stream'); ?> 
                                             
                                             <h6>University :<span class="red">*</span></h6>
                                            
                                             <select name="university[]" id="university1" tabindex="3" class="university">
                                                <option value="" selected option disabled>Select your University</option>
                                                <?php
                                                   if (count($university_data) > 0) {
                                                   foreach ($university_data as $cnt) {
                                                   if ($university1) {
                                                            ?>
                                                <option value="<?php echo $cnt['university_id']; ?>" <?php if ($cnt['university_id'] == $university1) echo 'selected'; ?>><?php echo $cnt['university_name']; ?></option>
                                                <?php
                                                   }
                                                   else {
                                                   ?>
                                                <option value="<?php echo $cnt['university_id']; ?>"><?php echo $cnt['university_name']; ?></option>
                                                <?php
                                                   }
                                                   }
                                                   }
                                                   ?>
                <option value="<?php echo $university_otherdata[0]['university_id']; ?> "><?php echo $university_otherdata[0]['university_name']; ?></option>  
                                             </select>
                                             <?php echo form_error('univercity'); ?>
                                             
                                             <h6>College :<span class="red">*</span></h6>
                                             <input type="text" name="college[]" id="college1" tabindex="4" class="college" placeholder="Enter College" value="<?php
                                                if ($college1) {
                                                 echo $college1;
                                                     }
                                                     ?>" maxlength="255" onfocus="var temp_value=this.value; this.value=''; this.value=temp_value">
                                             <?php echo form_error('college'); ?>
                                           
                                             <h6>
                                                Grade :
                                             </h6>
                                             <input type="text" name="grade[]" id="grade1" class="grade" tabindex="5" placeholder="Ex : (A+,B+,C+,D+)" style="text-transform: uppercase;" value="<?php
                                                if ($grade1) {
                                                echo $grade1;
                                                     }
                                                 ?>" maxlength="3">
                                             <?php echo form_error('grade'); ?>
                                            
                                             <h6>Percentage :<span class="red">*</span></h6>
                                             <input type="text" name="percentage[]" id="percentage1" class="percentage" tabindex="6" placeholder="Enter Percentage"  value="<?php
                                                if ($percentage1) {
                                                   echo $percentage1;
                                                  }
                                                  ?>" maxlength="5"/>
                                             <?php echo form_error('percentage'); ?>
                                             <h6>Year Of Passing :<span class="red">*</span></h6>
                                             <select name="pass_year[]" id="pass_year1" tabindex="7" class="pass_year" >
                                                <option value="" selected option disabled>--SELECT--</option>
                                                <?php
                                                   $curYear = date('Y');
                                                   for ($i = $curYear; $i >= 1900; $i--) {
                                                   if ($pass_year1) {
                                                    ?>
                                                <option value="<?php echo $i ?>" <?php if ($i == $pass_year1) echo 'selected'; ?>><?php echo $i ?></option>
                                                <?php
                                                   }
                                                   else {
                                                     ?>
                                                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                                <?php
                                                   }
                                                       }
                                                    ?> 
                                             </select>
                                             <?php echo form_error('pass_year'); ?>
                                           
                                             <h6>Education Certificate:</h6>
                                             <input style="" type="file" name="certificate[]" id="certificate1" tabindex="8" class="certificate" placeholder="CERTIFICATE" multiple="" />&nbsp;&nbsp;&nbsp; <span id="certificate-error"> </span>
                                             <div class="bestofmine_image_degree" style="color:#f00; display: block;"></div>
                                              <?php
                                                if ($edu_certificate1) {
                                                   ?>
                                          <div class="img_work_exp" style=" margin-top: 14px;" >
                                                   <?php
                                                   $ext = explode('.',$edu_certificate1);
                                                   if($ext[1] == 'pdf')
                                                      { 
                                                   ?>
                                                       
                                                         <a title="open pdf" class="fl" href="<?php echo JOB_EDU_MAIN_UPLOAD_URL . $edu_certificate1 ?>"><i class="fa fa-file-pdf-o fa-2x" style="color: red; padding-left: 8px; padding-top: 10px; padding-bottom: 10px; position: relative;" aria-hidden="true"></i></a>
                                                      <?php
                                                      }
                                                      else
                                                      {
                                                    ?>

                                                    
                                               <img class="fl" src="<?php echo JOB_EDU_MAIN_UPLOAD_URL . $edu_certificate1 ?>" style="width:100px;height:100px;" class="job_education_certificate_img">
                                             <?php
                                                }//else end
                                                ?>
                                                </div>
                                          <?php
                                             }//if ($edu_certificate1) rnd
                                          ?>

                                           <?php if($edu_certificate1)
                                                 {
                                          ?>

                                           <div style="float: left;" id="graduation_certi">
                                                <div class="hs-submit full-width fl">
                                              
                                                   <input  type="button" class="datad_delete"   value="" onClick="delete_graduation('<?php echo $jobgrad[$x]['job_graduation_id']; ?>','<?php echo $edu_certificate1; ?>')">
                                                </div>
                                             </div>

                                          <?php
                                                }
                                          ?>


                                             <?php echo form_error('certificate'); ?>
                                             <input type="hidden" name="image_hidden_degree<?php echo $jobgrad[$x]['job_graduation_id']; ?>" value="<?php
                                                if ($edu_certificate1) {
                                                echo $edu_certificate1;
                                                }
                                                ?>">
                                             <?php if ($y != 1) {
                                                ?>
                                             <div style="float: left;">
                                                <div class="hs-submit full-width fl">
                                                   <input  type="button" style="padding: 6px 18px 6px;min-width: 0;font-size: 14px" value="Delete" onclick="delete_job_exp('<?php echo $jobgrad[$x]['job_graduation_id']; ?>','<?php echo $edu_certificate1; ?>')">
                                                </div>
                                             </div>
                                             <?php } ?>
                                          </div>
                                        
                                          <hr>
                                       </div>
                                       <?php
                                          }
                                          ?>
                                       
                                       <div class="fr img_remove">
                                          <input  style="font-size: 14px;" class="job_edu_graduation_submit_btn" tabindex="8" type="Submit"  id="next" name="next" value="Save">
                                          
                                       </div>
                                       <div class="display_inline_block" >
                                          <div class="fr img_remove job_edu_graduation_removebox" >
                                             <input class="job_edu_graduation_removebtn" type="button" id="btnRemove" name="btnRemove"  value=" - "   />
                                          </div>
                                          <div class="fr img_remove" >
                                             <input type="button" id="btnAdd"  name="btnAdd" class="job_edu_graduation_addbtn"  value=" + ">
                                          </div>
                                       </div>
                                       <fieldset class="hs-submit full-width job_edu_graduation_nextbtnbox">
                                       </fieldset>
                                       <?php
                                          } else {
                                              ?>
                                       <!--clone div start-->              
                                       <div id="input1" style="margin-bottom:4px;" class="clonedInput job_work_experience_main_div">
                                          <!-- <fieldset class=""> -->
                                          <h6>Degree :<span class="red">*</span></h6>
                                          <select name="degree[]" id="degree1" class="degree">
                                             <option value="" Selected option disabled="">Select your Degree</option>
                                             <?php
                                                foreach ($degree_data as $cnt) {
                                                    if ($degree1) {
                                                        ?>
                                             <option value="<?php echo $cnt['degree_id']; ?>" <?php if ($cnt['degree_id'] == $degree1) echo 'selected'; ?>><?php echo $cnt['degree_name']; ?></option>
                                             <?php
                                                }
                                                else {
                                                    ?>
                                             <option value="<?php echo $cnt['degree_id']; ?>"><?php echo $cnt['degree_name']; ?></option>
                                             <?php
                                                }
                                               
                                                }
                                                ?>
    <option value="<?php echo $degree_otherdata[0]['degree_id']; ?> "><?php echo $degree_otherdata[0]['degree_name']; ?></option> 

                                          </select>
                                          <?php echo form_error('degree'); ?>
                                         
                                          <h6>Stream :<span class="red">*</span></h6>
                                          <select name="stream[]" id="stream1" class="stream" >
                                             
                                             <?php
                                                if ($stream1) {
                                                    foreach ($stream_data as $cnt) {
                                                        ?>
                                             <option value="<?php echo $cnt['stream_id']; ?>" <?php if ($cnt['stream_id'] == $stream1) echo 'selected'; ?>><?php echo $cnt['stream_name']; ?></option>
                                             <?php
                                                }
                                                }
                                                else {
                                                ?>
                                             <option value="" selected option disabled>Select Degree First</option>
                                             <?php
                                                }
                                                ?>
                                          </select>
                                          <?php echo form_error('stream'); ?> 
                                          
                                          <h6>University :<span class="red">*</span></h6>
                                
                                          <select name="university[]" id="university1" class="university">
                                             <option value="" selected option disabled>Select your University </option>
                                             <?php
                                                if (count($university_data) > 0) {
                                                    foreach ($university_data as $cnt) {
                                                
                                                        if ($university1) {
                                                            ?>
                                             <option value="<?php echo $cnt['university_id']; ?>" <?php if ($cnt['university_id'] == $university1) echo 'selected'; ?>><?php echo $cnt['university_name']; ?></option>
                                             <?php
                                                }
                                                else {
                                                    ?>
                                             <option value="<?php echo $cnt['university_id']; ?>"><?php echo $cnt['university_name']; ?></option>
                                             <?php
                                                }
                                                }
                                                }

                                                ?>
                        <option value="<?php echo $university_otherdata[0]['university_id']; ?> "><?php echo $university_otherdata[0]['university_name']; ?></option>    
                                          </select>
                                          <?php echo form_error('univercity'); ?> 
                                        
                                          <h6>College :<span class="red">*</span></h6>
                                          <input type="text" name="college[]" id="college1" class="college" placeholder="Enter College" value="<?php
                                             if ($college1) {
                                                 echo $college1;
                                             }
                                             ?>" maxlength="255" onfocus="var temp_value=this.value; this.value=''; this.value=temp_value">
                                          <?php echo form_error('college'); ?>    
                                         
                                          <h6>
                                             Grade :
                                          </h6>
                                          <input type="text" name="grade[]" id="grade1" class="grade" placeholder="Ex : (A+,B+,C+,D+)" style="text-transform: uppercase;"  value="<?php
                                             if ($grade1) {
                                                 echo $grade1;
                                             }
                                             ?>" maxlength="3">
                                          <?php echo form_error('grade'); ?>
                                        
                                          <h6>Percentage :<span class="red">*</span></h6>
                                          <input type="text" name="percentage[]" id="percentage1" class="percentage" placeholder="Enter Percentage"  value="<?php
                                             if ($percentage1) {
                                                 echo $percentage1;
                                             }
                                             ?>" maxlength="5"/>
                                          <?php echo form_error('percentage'); ?>
                                         
                                          <h6>Year Of Passing :<span class="red">*</span></h6>
                                          <select name="pass_year[]" id="pass_year1" class="pass_year" >
                                             <option value="" selected option disabled>--SELECT--</option>
                                             <?php
                                                $curYear = date('Y');
                                                
                                                for ($i = $curYear; $i >= 1900; $i--) {
                                                    if ($pass_year1) {
                                                        ?>
                                             <option value="<?php echo $i ?>" <?php if ($i == $pass_year1) echo 'selected'; ?>><?php echo $i ?></option>
                                             <?php
                                                }
                                                else {
                                                    ?>
                                             <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                             <?php
                                                }
                                                }
                                                ?> 
                                          </select>
                                          <?php echo form_error('pass_year'); ?>
                                     
                                          <h6>Education Certificate:</h6>
                                          <input type="file" name="certificate[]" id="certificate1" class="certificate" placeholder="CERTIFICATE" multiple="" />&nbsp;&nbsp;&nbsp; <span id="certificate-error"> </span>
                                          <div class="bestofmine_image_degree" style="color:#f00; display: block;"></div>
                                           <?php
                                                if ($edu_certificate1) {

                                                   $ext = explode('.',$edu_certificate1);
                                                   if($ext[1] == 'pdf')
                                                      { 
                                                   ?>
                                                        

                                                          <a title="open pdf" class="fl" href="<?php echo JOB_EDU_MAIN_UPLOAD_URL . $edu_certificate1 ?>"><i class="fa fa-file-pdf-o fa-2x" style="color: red; padding-left: 8px; padding-top: 10px; padding-bottom: 10px; position: relative;" aria-hidden="true"></i></a>
                                                      <?php
                                                      }
                                                      else
                                                      {
                                                    ?>
                                                <img src="<?php echo JOB_EDU_MAIN_UPLOAD_URL . $edu_certificate1 ?>" style="width:100px;height:100px;">
                                             <?php
                                                }
                                             }
                                          ?>

                                          <?php echo form_error('certificate'); ?>
                                         
                                       </div>
                                       <!--clone div End-->
                                       <div class="fl job_edu_graduation_addbtnbox" >
                                          <input type="button" id="btnAdd" class="job_edu_graduation_addbtn" value=" + " /><br>
                                       </div>
                                       <div class="fl">
                                          <input type="button" id="btnRemove" class="job_edu_graduation_removebtn" value=" - "   />
                                       </div>
                                       <div class="fr job_edu_graduation_submitposition">
                                          <input type="Submit"  id="next" name="next" value="Save" class="job_edu_graduation_submitbtn" style="padding: 5px 9px;margin-right: 0px;">
                                       </div>
                                       <br>
                                       <?php
                                          }
                                          ?>
                                       <?php echo form_close(); ?>
                                       </article>
                                    </section>
                                 </div>
                              </div>
                           </div>
                           <!-- end of panel -->
                           <fieldset class="hs-submit full-width"  style="">
                              <?php if( $jobdata || $jobgrad)
                                 {
                                 ?>
                              <input type="button" id="next" name="next" value="Next" style="font-size: 16px;min-width: 120px;margin-right: 0px;"  onclick="next_page_edit()">
                              <?php
                                 }
                                 else
                                 {
                                     ?>
                              <input type="button" id="next" name="next" value="Next" style="font-size: 16px;min-width: 120px;margin-right: 0px;" onclick="next_page()">
                              <?php } ?>
                           </fieldset>
                        </div>
                        <!-- end of #bs-collapse  -->
                     </div>
                     <!-- end of container -->        
                     <!--  xyx -->
                     <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                     </div>
                     <!-- panel-group -->
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
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

<footer>        
<?php echo $footer;  ?>
</footer>

<!-- Calender JS Start-->
<script src="<?php echo base_url('js/jquery.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/jquery-ui.js?ver='.time()) ?>"></script>
<!--<script src="<?php //echo base_url('js/jquery-ui.min.js?ver='.time()); ?>"></script>-->
<script src="<?php echo base_url('js/demo/jquery-1.9.1.js?ver='.time()); ?>"></script>
<script src="<?php echo base_url('js/demo/jquery-ui-1.9.1.js?ver='.time()); ?>"></script>
<!-- This Js is used for call popup -->
<script src="<?php echo base_url('js/jquery.fancybox.js?ver='.time()); ?>"></script>
<!-- This Js is used for call popup -->
 
<script type="text/javascript" src="<?php echo base_url('js/jquery.validate.min.js?ver='.time()) ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/jquery.validate.js?ver='.time()); ?>"></script>
<!--validation for edit email formate form-->

<!-- js for modal start-->
<script src="<?php echo base_url('js/bootstrap.min.js?ver='.time()); ?>"></script>
<!-- js for modal end-->

<script>
    var base_url = '<?php echo base_url(); ?>';
    var predefine_data =' <?php echo $predefine_data; ?>';

    var html = '<div class="message"><h2>Add Degree</h2><input type="text" name="other_degree" id="other_degree"><h2>Add Stream</h2><select name="other_stream" id="other_stream" class="other_stream">  <option value="" Selected option disabled>Select your Stream</option><?php foreach ($stream_alldata as $stream){?><option value="<?php echo $stream['stream_id']; ?>"><?php echo $stream['stream_name']; ?></option><?php } ?>  <option value="<?php echo $stream_otherdata[0]['stream_id']; ?> "><?php echo $stream_otherdata[0]['stream_name']; ?></option> </select><a id="univer" class="btn">OK</a></div>';

   
</script>

<script type="text/javascript" src="<?php echo base_url('js/webpage/job/job_education.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/webpage/job/search_common.js?ver='.time()); ?>"></script>
</body>
</html>