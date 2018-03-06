<!DOCTYPE html>
<html>
   <head>

      <?php  echo $head; ?>


      <title><?php echo $title; ?></title>

 <?php
        if (IS_JOB_CSS_MINIFY == '0') {
            ?>
      <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver='.time()); ?>">
	  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver='.time()); ?>">

 <?php }else{?>
 <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver='.time()); ?>">
     <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/job.css?ver='.time()); ?>">

 <?php }?>    
   </head>

   <body class="page-container-bg-solid page-boxed botton_footer">
     <?php 
      echo $header; 
      echo $job_header2_border;  
      ?>
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
                        <div class="common-form common-form_border">
                           <h3>Project And Training / Internship</h3>
                           <?php echo form_open(base_url('job/job_project_insert'), array('id' => 'jobseeker_regform','name' => 'jobseeker_regform','class'=>'clearfix')); ?>
                           <div class="text-center">
                              <h5 class="head_title">Project</h5>
                           </div>
                           <fieldset class="full-width">
                              <label>Project Name (Title):<span class="optional">(optional)</span></label>
                              <input type="text" tabindex="1" autofocus name="project_name"  id="project_name" placeholder="Enter Project Name" value="<?php if($project_name1){ echo $project_name1; } else { echo $job[0]['project_name']; }?>" maxlength="255" onfocus="var temp_value=this.value; this.value=''; this.value=temp_value"/>
                           </fieldset>
                           <fieldset class="full-width">
                              <label>Duration (in Month):<span class="optional">(optional)</span></label>
                              <input type="text" name="project_duration" tabindex="2"  id="project_duration" placeholder="Enter Duration" maxlength="2"   value="<?php if($project_duration1){ echo $project_duration1; } else { echo $job[0]['project_duration']; }?>" />
                           </fieldset>
                           <fieldset class="full-width">
                              <label>Project Description:<span class="optional">(optional)</span></label>
                              <textarea name="project_description"  onfocus="var temp_value=this.value; this.value=''; this.value=temp_value" id="project_description" tabindex="3" onpaste="OnPaste_StripFormatting(this, event);" style="resize: none;" placeholder="Enter Project Description" maxlength="4000"><?php if($project_description1){ echo $project_description1; } else { echo $job[0]['project_description']; }?></textarea>
                           </fieldset>
                           <div class="text-center">
                              <h5 class="head_title">Training / Internship</h5>
                           </div>
                           <fieldset class="full-width">
                              <label>Intern / Trainee as:<span class="optional">(optional)</span></label>
                              <input type="text" tabindex="4" name="training_as"  id="training_as" placeholder="Intern / Trainee as" value="<?php if($training_as1){ echo $training_as1; } else { echo $job[0]['training_as']; }?>" maxlength="255"/>
                           </fieldset>
                           <fieldset class="full-width">
                              <label>Duration (in Month):<span class="optional">(optional)</span></label>
                              <input type="text" name="training_duration" tabindex="5"  id="training_duration" placeholder="Enter Duration"   value="<?php if($training_duration1){ echo $training_duration1; } else { echo $job[0]['training_duration']; }?>" maxlength="2"/>
                           </fieldset>
                           <fieldset class="full-width">
                              <label>Name of Organization:<span class="optional">(optional)</span> </label>
                              <input type="text" name="training_organization" tabindex="6"  id="training_organization" placeholder="Enter Name of Organization" value="<?php if($training_organization1){ echo $training_organization1; } else { echo $job[0]['training_organization']; }?>" maxlength="255"/>
                           </fieldset>
                           <fieldset class="hs-submit full-width">
                             <!--  <input title="Save" type="submit"  id="next" name="next" value="Save" tabindex="7"> -->
                             <button id="next" name="next" onclick="return profile_reg();" tabindex="7">Save<span class="ajax_load pl10" id="profilereg_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
                           </fieldset>
                           </form>
                        </div>
                     </div>
                  </div>
                  <!-- middle section end -->
               </div>
            </div>
         </div>
      </section>
   
         <?php echo $login_footer ?>
         <?php echo $footer;  ?>

   

<!-- Calender JS Start-->

<?php
        if (IS_JOB_JS_MINIFY == '0') {
            ?>
 <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js') ?>"></script>
<!-- js for modal start-->
<script src="<?php echo base_url('assets/js/bootstrap.min.js?ver='.time()); ?>"></script>
<!-- js for modal end-->
<?php }else{?>

<script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js') ?>"></script>
<!-- js for modal start-->
<script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver='.time()); ?>"></script>
<?php }?>
<script>
    var base_url = '<?php echo base_url(); ?>';
</script>

<?php
        if (IS_JOB_JS_MINIFY == '0') {
            ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/job_project.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/search_common.js?ver='.time()); ?>"></script>

<?php }else{?>

<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/job/job_project.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/job/search_common.js?ver='.time()); ?>"></script>

<?php }?>
</body>
</html>