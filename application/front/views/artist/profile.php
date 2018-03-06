
<!DOCTYPE html>
<html>
   <head>
<!-- start head -->
<?php echo $head; ?>
<!-- Calender Css Start-->

 <title>Registration | Artistic Profile - Aileensoul</title>

<!-- Calender Css End-->

         <?php
        if (IS_ART_CSS_MINIFY == '0') {
            ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver='.time()); ?>">
 <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/artistic.css?ver='.time()); ?>">

 <?php }else{?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/job.css?ver='.time()); ?>">
 <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/artistic.css?ver='.time()); ?>">

 <?php }?>
<!-- This Css is used for call popup -->


 
</head>
<!-- END HEAD -->

<!-- start header -->
<?php echo $header; ?>
<!-- END HEADER -->

<?php 
        $userid = $this->session->userdata('aileenuser');
        if($userid){
?>
<body class="cus-no-login botton_footer">
  <?php }else{?>
 <body class="cus-no-login botton_footer model-open no-login">

   <header>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-3 left-header text-center fw-479">
                        <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png?ver='.time()) ?>" alt="logo"></a>
                    </div>
                    <div class="col-md-8 col-sm-9 right-header fw-479 text-center">
                        <div class="btn-right pull-right">
                            <a href="javascript:void(0);" onclick="login_data();" class="btn2" title="Login">Login</a>
                            <a href="javascript:void(0);" onclick="register_profile();" class="btn3" title="Create an account">Create an account</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
  <?php }?>
   <section>
      <div class="user-midd-section " id="paddingtop_fixed">
         <div class="container">
            <div class="row">
               <div class="col-md-3"></div>
               <div class="clearfix">
                  <div class="job_reg_page_fprm">
                      
                     <div class="common-form job_reg_main">
                        <h3>Welcome in Artistic Profile</h3>

                        <?php echo form_open(base_url('artist/profile_insert'), array('id' => 'artinfo','name' => 'artinfo','class' => 'clearfix', 'onsubmit' => "return validation_other(event)")); ?>

                        <?php
                                 $firstname =  form_error('firstname');
                                 $lastname = form_error('lastname');
                                 $email =  form_error('email');
                                 $phoneno =  form_error('phoneno');
                                 $skills =  form_error('skills');
                                 $country = form_error('country');
                                 $state = form_error('state');
                                 $city = form_error('city');
                                 
                            ?>

                        <fieldset>
                           <label >First Name <font  color="red">*</font> :</label>                          
                           <input type="text" name="firstname" id="firstname" tabindex="1" placeholder="Enter first name" style="text-transform: capitalize;" onfocus="var temp_value=this.value; this.value=''; this.value=temp_value" value="<?php echo $userdata['first_name']; ?>" maxlength="35">
                           <?php echo form_error('firstname');; ?>
                        </fieldset>
                        <fieldset>
                           <label >Last Name <font  color="red">*</font>:</label>
                           <input type="text" name="lastname" id="lastname" tabindex="2" placeholder="Enter last name" style="text-transform: capitalize;" onfocus="this.value = this.value;" value="<?php echo $userdata['last_name']; ?>" maxlength="35">
                           <?php echo form_error('lastname');; ?>
                        </fieldset>
                        <fieldset class="vali_er">
                           <label >Email Address <font  color="red">*</font> :</label>
                           <input type="email" name="email" id="email" tabindex="3" placeholder="Enter email address" value="<?php echo $userdata['email'];?>" maxlength="255">
                            <span class="email_note"><b>Note:-</b> Related notification email will be send on provided email address kindly use regular  email address.<div></div></span>
                           <?php echo form_error('email');; ?>
                        </fieldset>
                        <fieldset>
                           <label >Phone number:</label>
                           <input type="text" name="phoneno" id="phoneno" tabindex="4" placeholder="Enter phone number" value="<?php echo $job[0]['user_email'];?>" maxlength="255">
                           <?php echo form_error('phoneno');; ?>
                        </fieldset>


                         <fieldset class="full-width art-cat-custom <?php if($skills) {  ?> error-msg <?php } ?>">
                                        <label>Art category:<span style="color:red">*</span></label>

                          <select name="skills[]" id="skills" multiple>
                        
                            <?php                             
                                      foreach($art_category as $cnt){ 
                                          if($art_category1)
                                            { 
                                              $category = explode(',' , $art_category1);  
                                              ?>
                                                 <option value="<?php echo $cnt['category_id']; ?>"
                                                  <?php if(in_array($cnt['category_id'], $category)) echo 'selected';?> onchange="return otherchange(<?php echo $cnt['category_id']; ?>);"><?php echo ucwords(ucfirst($cnt['art_category']));?></option>              
                                                 <?php
                                                }
                                                else
                                                {  
                                            ?>
                            <option value="<?php echo $cnt['category_id']; ?>" onchange="return otherchange(<?php echo $cnt['category_id']; ?>);"><?php echo ucwords(ucfirst($cnt['art_category']));?></option>
                                <?php    }       
                                            }
                                            ?>
                      </select>
                                    
                                        <?php echo form_error('skills'); ?>
                         </fieldset>
                                    <?php if($othercategory1){?>
                                    <div id="other_category" class="other_category" style="display: block;">
                                      <?php }else{ ?>
                                      <div id="other_category" class="other_category" style="display: none;">
                                      <?php }?>
                                    <fieldset class="full-width <?php if($artname) {  ?> error-msg <?php } ?>">
                                    <label>Other category:<span style="color:red">*</span></label>
                                    <input name="othercategory"  type="text" id="othercategory" tabindex="2" placeholder="Other category" value="<?php if($othercategory1){ echo $othercategory1; } ?>" onkeyup= "return removevalidation();"/>
                                     <?php echo form_error('othercategory'); ?>
                                 </div>
                                   </fieldset>


                        <fieldset <?php if($country) {  ?> class="error-msg" <?php } ?>>
                <label>Country:<span style="color:red">*</span></label>               
                        <select name="country" id="country" tabindex="5">
                          <option value="">Select country</option>
                          <?php
                                            if(count($countries) > 0){
                                                foreach($countries as $cnt){  ?>
                            <option value="<?php echo $cnt['country_id']; ?>"><?php echo $cnt['country_name'];?></option>
                                    <?php                                            
                                          }       
                                            }
                                            ?>
                      </select><span id="country-error"></span>
                   <?php echo form_error('country'); ?>
              </fieldset> 

              <fieldset <?php if($state) {  ?> class="error-msg" <?php } ?>>
                    <label>state:<span style="color:red">*</span></label>
                    <select name="state" id="state" tabindex="6">
                      <?php
                                          if($state1)
                                            {
                                            foreach($states as $cnt){  ?>
                                                 <option value="<?php echo $cnt['state_id']; ?>" <?php if($cnt['state_id']==$state1) echo 'selected';?>><?php echo $cnt['state_name'];?></option>
                                                <?php
                                                } }                                             
                                               else
                                                {
                                            ?>
                                                 <option value="">Select country first</option>
                                                  <?php                                            
                                            }
                                            ?>
                    </select><span id="state-error"></span>
                                     <?php echo form_error('state'); ?>
            </fieldset> 

            <fieldset class="full-width" <?php if($city) {  ?> class="error-msg" <?php } ?>>
                    <label> City:<span style="color:red">*</label>
                  <select name="city" id="city" tabindex="7">
                    <?php
                                         if($city1)
                                            {
                                          foreach($cities as $cnt){                                              
                                              ?>
                                               <option value="<?php echo $cnt['city_id']; ?>" <?php if($cnt['city_id']==$city1) echo 'selected';?>><?php echo $cnt['city_name'];?></option>
                                                <?php
                                                } }
                                                else if($state1)
                                             {
                                            ?>
                                            <option value="">Select city</option>
                                            <?php
                                            foreach ($cities as $cnt) {
                                                ?>
                                                <option value="<?php echo $cnt['city_id']; ?>"><?php echo $cnt['city_name']; ?></option>
                                                <?php
                                            }
                                        }                                              
                                                else
                                                {
                                            ?>
                                        <option value="">Select state first</option>
                                         <?php                                          
                                            }
                                            ?>
                  </select><span id="city-error"></span>
                                    <?php echo form_error('city'); ?>
                </fieldset>                              
                
                         

                        <fieldset class=" full-width">
                           <div class="job_reg">
                            
                                  <!--   <input type="submit"  id="next" name="next" value="Register" tabindex="9" onclick="return validate();"> -->
                                    <button id="next" name="next" tabindex="9" onclick="return validate();" class="cus_btn_sub">Register<span class="ajax_load pl10" id="profilereg_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>

                           </div>
                        </fieldset>
                        <?php echo form_close();?>
                     </div>
                  </div>
               </div>
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

          <!-- register -->

        <div class="modal fade login register-model" id="register" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content inner-form1">
                    <div class="modal-body">
                        <div class="clearfix">
                            <div class=" ">
                                <div class="title"><h1 class="tlh1">Sign up First and Register in Artistic Profile</h1></div>
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
                                        <a tabindex="109" href="<?php echo base_url('terms-and-condition'); ?>" title="Terms and Condition">Terms and Condition</a> and <a tabindex="110" href="<?php echo base_url('privacy-policy'); ?>" title="Privacy policy">Privacy policy</a>.
                                    </p>
                                    <p>
                                        <button tabindex="111" class="btn1">Create an account</button>
                                    </p>
                                    <div class="sign_in pt10">
                                        <p>
                                            Already have an account ? <a tabindex="112" onclick="login_data();" href="javascript:void(0);" title="Log In"> Log In </a>
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
                                            <a href="javascript:void(0)" data-toggle="modal" onclick="forgot_profile();" id="myBtn" title="Forgot Password">Forgot Password ?</a>
                                        </p>

                                        <p class="pt15 text-center">
                                            Don't have an account? <a class="db-479" href="javascript:void(0);" data-toggle="modal" onclick="register_profile();" title="Create an account">Create an account</a>
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
                    <button type="button" class="modal-close" data-dismiss="modal" onclick="forgot_close();">&times;</button>       
                    <div class="modal-body cus-forgot">
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

<!-- <footer>        -->
<?php echo $login_footer ?> 
<?php echo $footer;  ?>
<!-- </footer> -->

 <?php
  if (IS_ART_JS_MINIFY == '0') { ?>

<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()) ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js?ver='.time()); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.multi-select.js?ver=' . time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/profile.js?ver='.time()); ?>"></script>

<?php }else{?>

<script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver='.time()) ?>"></script>
<script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver='.time()); ?>"></script>
<script src="<?php echo base_url('assets/js_min/jquery.multi-select.js?ver=' . time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/profile.js?ver='.time()); ?>"></script>

<?php }?>
 <script>
     var base_url = '<?php echo base_url(); ?>';  
     var profile_login = '<?php echo $profile_login; ?>';
     var user_id = '<?php echo $this->session->userdata('aileenuser');?>';
 </script>
</body>
</html>