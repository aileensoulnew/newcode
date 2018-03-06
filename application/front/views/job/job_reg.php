
<!DOCTYPE html>
<html>
   <head>
<!-- start head -->
<?php echo $head; ?>
<!-- Calender Css Start-->

 <title><?php echo $title; ?></title>

<!-- Calender Css End-->

<?php
        if (IS_JOB_CSS_MINIFY == '0') {
            ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver='.time()); ?>">

<?php }else{?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/job.css?ver='.time()); ?>">
<?php }?>
<!-- This Css is used for call popup -->
    

</head>
<!-- END HEAD -->
</head>
<!-- END HEAD -->

<!-- start header -->
<?php echo $header; ?>
<!-- END HEADER -->
<?php if(!$userid){ ?>
<body class="cus-login botton_footer cus-error no-login">
<?php }else{ ?>
<body class="cus-login botton_footer cus-error">
<?php } ?>

  <?php 
      $userid = $this->session->userdata('aileenuser');
      if(!$userid){
?>
   <header>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-3 left-header text-center fw-479">
                        <div class="logo"> <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png?ver='.time()) ?>" alt="logo"></a></div>
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
                      <?php
                                if ($this->uri->segment(3) == 'live-post') {
                                    echo '<div class="alert alert-success">Your post will be automatically apply successfully after completing this step...!</div>';
                                }
                                ?>
                     <div class="common-form job_reg_main">
                        <h3>Welcome in Job Profile</h3>
                        <?php echo form_open(base_url('job/job_insert'), array('id' => 'jobseeker_regform', 'name' => 'jobseeker_regform', 'class' => 'clearfix')); ?>
                        <fieldset>
                           <label >First Name <font  color="red">*</font> :</label>
                             <?php     if ($livepost) { ?>
                                         <input type="hidden" name="livepost" id="livepost" tabindex="5"  value="<?php echo $livepost;?>">
                                    <?php    }
                                        ?>
                           <input type="text" name="first_name" id="first_name" tabindex="1" placeholder="Enter your First Name" style="text-transform: capitalize;" onfocus="var temp_value=this.value; this.value=''; this.value=temp_value" value="<?php echo $userdata['first_name'];?>" maxlength="35">
                           <?php echo form_error('first_name');; ?>
                        </fieldset>
                        <fieldset>
                           <label >Last Name <font  color="red">*</font>:</label>
                           <input type="text" name="last_name" id="last_name" tabindex="2" placeholder="Enter your Last Name" style="text-transform: capitalize;" onfocus="this.value = this.value;" value="<?php echo $userdata['last_name'];?>" maxlength="35">
                           <?php echo form_error('last_name');; ?>
                        </fieldset>
                        <fieldset class="full-width vali_er">
                           <label >Email Address <font  color="red">*</font> :</label>
                           <input type="email" name="email" id="email" tabindex="3" placeholder="Enter your Email Address" value="<?php echo $userdata['email'];?>" maxlength="255">
                            <span class="email_note"><b>Note:-</b> Related notification email will be send on provided email address kindly use regular  email address.<div></div></span>
                           <?php echo form_error('email');; ?>
                        </fieldset>
                        <fieldset class="fresher_radio col-xs-12" >
                           <label>Fresher <font  color="red">*</font> : </label>
                           <div class="main_raio">
                              <input type="radio" value="Fresher" tabindex="4" id="test1" name="fresher" class="radio_job" id="fresher" onclick="not_experience()">
                              <label for="test1" class="point_radio" >Yes</label>
                           </div>

                           <div class="main_raio">
                              <input type="radio"  value="Experience" tabindex="5" id="test2" class="radio_job" name="fresher" id="fresher" onclick="experience()">
                              <label for="test2" class="point_radio">No</label>
                           </div>
                           <div class="fresher-error"><?php echo form_error('fresher'); ?></div>
                        </fieldset>
                        <fieldset class="full-width">
                            <div id="exp_data" style="display:none;">
                               <label>Total Experience<span class="red">*</span>:</label>
                                                      <select style="width: 45%; margin-right: 4%; float: left;" tabindex="6" autofocus name="experience_year" id="experience_year" tabindex="1" class="experience_year keyskil" onchange="expyear_change();">
                                                         <option value="" selected option disabled>Year</option>
                                                         <option value="0 year">0 year</option>
                                                         <option value="1 year">1 year</option>
                                                         <option value="2 year" >2 year</option>
                                                         <option value="3 year" >3 year</option>
                                                         <option value="4 year">4 year</option>
                                                         <option value="5 year">5 year</option>
                                                         <option value="6 year">6 year</option>
                                                         <option value="7 year">7 year</option>
                                                         <option value="8 year">8 year</option>
                                                         <option value="9 year">9 year</option>
                                                         <option value="10 year">10 year</option>
                                                         <option value="11 year" >11 year</option>
                                                         <option value="12 year">12 year</option>
                                                         <option value="13 year">13 year</option>
                                                         <option value="14 year">14 year</option>
                                                         <option value="15 year">15 year</option>
                                                         <option value="16 year">16 year</option>
                                                         <option value="17 year">17 year</option>
                                                         <option value="18 year">18 year</option>
                                                         <option value="19 year">19 year</option>
                                                         <option value="20 year">20 year</option>
                                                      </select>
                                                  
                                                      <select style="width: 45%;" name="experience_month" tabindex="7"   id="experience_month" class="experience_month keyskil" onclick="expmonth_click();">
                                                         <option value="" selected option disabled>Month</option>
                                                         <option value="0 month">0 month</option>
                                                         <option value="1 month">1 month</option>
                                                         <option value="2 month">2 month</option>
                                                         <option value="3 month">3 month</option>
                                                         <option value="4 month">4 month</option>
                                                         <option value="5 month">5 month</option>
                                                         <option value="6 month">6 month</option>
                                                         <option value="7 month">7 month</option>
                                                         <option value="8 month">8 month</option>
                                                         <option value="9 month">9 month</option>
                                                         <option value="10 month">10 month</option>
                                                         <option value="11 month">11 month</option>
                                                         <option value="12 month">12 month</option>
                                                      </select>
                                                      <?php echo form_error('experience_month'); ?>
                            </div>
                        </fieldset>
                        <fieldset class="full-width">
                           <label >Job Title<font  color="red">*</font> :</label>
                           <input type="search" tabindex="8" id="job_title" name="job_title" value="" placeholder="Ex:- Sr. Engineer, Jr. Engineer, Software Developer, Account Manager" style="text-transform: capitalize;" onfocus="this.value = this.value;" maxlength="255">
                           <?php echo form_error('job_title'); ?>
                        </fieldset>
                        <fieldset class="full-width fresher_select main_select_data" >
                           <label for="skills"> Skills<font  color="red">*</font> : </label>
                           <input id="skills2" style="text-transform: capitalize;" name="skills" tabindex="9"  size="90" placeholder="Enter SKills">
                           <?php echo form_error('skills'); ?>
                        </fieldset>
                        <fieldset class="full-width main_select_data">
                           <label>Industry <font  color="red">*</font> :</label>
                           <span>
                           <select name="industry" id="industry" tabindex="10">
                              <option value="" selected="selected">Select industry</option>
                              <?php foreach ($industry as $indu) { ?>
                              <option value="<?php echo $indu['industry_id']; ?>"><?php echo $indu['industry_name']; ?></option>
                              <?php } ?>
                               <option value="<?php echo $other_industry[0]['industry_id']; ?>"><?php echo $other_industry[0]['industry_name']; ?></option>
                           </select>
                         </span>
                           <?php echo form_error('industry');; ?>
                        </fieldset>
                        <fieldset class="full-width fresher_select main_select_data" >
                           <label for="cities">Preffered location for job<font  color="red">*</font> : </label>
                           <input id="cities2" name="cities"  style="text-transform: capitalize;" size="90" tabindex="11" placeholder="Enter Preferred Cites">
                           <?php echo form_error('cities');; ?>
                        </fieldset>
                        <fieldset class=" full-width">
                           <div class="job_reg">
                        
                              <!-- <input title="Register" type="submit" id="submit" name="" value="Register" tabindex="12"> -->
                              <button id="submit" name="" class="cus_btn_sub" onclick="return profile_reg();" tabindex="12">Register<span class="ajax_load pl10" id="profilereg_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
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

        <div class="modal fade login register-model" data-backdrop="static" data-keyboard="false" id="register" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content inner-form1">
                   
                    <div class="modal-body">
                        <div class="clearfix">
                            <div class=" ">
                              <div class="title"><h1 class="tlh1">Sign up First and Register in Job Profile</h1></div>
                                <form role="form" name="register_form" id="register_form" method="post">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <input tabindex="101" autofocus="" type="text" name="first_regname" id="first_regname" class="form-control input-sm" placeholder="First Name">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <input tabindex="102" type="text" name="last_regname" id="last_regname" class="form-control input-sm" placeholder="Last Name">
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


<?php echo $login_footer ?> 
<?php echo $footer;  ?>

 <?php
        if (IS_JOB_JS_MINIFY == '0') {
            ?>
   <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()) ?>"></script>
   <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver='.time()); ?>"></script>
  
<?php }else{?>
<script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver='.time()) ?>"></script>
   <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver='.time()); ?>"></script>

<?php }?>  
<!-- This Js is used for call popup -->

<!-- This Js is used for call popup -->
 

   <script>
       function experience(){
         document.getElementById('exp_data').style.display = 'block';
       }
       
       function not_experience(){
           var melement = document.getElementById('exp_data');
               
               if(melement.style.display == 'block'){
                   melement.style.display = 'none';
                   //value none if user have press yes button start
                $("#experience_year").val("");
                $("#experience_month").val("");
               }
       
       }
       function expyear_change() {
        var experience_year = document.querySelector("#experience_year").value;
        if (experience_year)
        {   $('#experience_month').attr('disabled', false);
            var experience_year = document.getElementById('experience_year').value;
            if (experience_year === '0 year') {
                $("#experience_month option[value='0 month']").attr('disabled', true);
            } else {
                $("#experience_month option[value='0 month']").attr('disabled', false);
            }
        } else
        {
            $('#experience_month').attr('disabled', 'disabled');
        }

        // var element = document.getElementById("experience_year");
        // element.classList.add("valuechangecolor");
}

function expmonth_click(){

// var element = document.getElementById("experience_month");
//         element.classList.add("valuechangecolor");
  
}

       $(".alert").delay(3200).fadeOut(300);
     var base_url = '<?php echo base_url(); ?>';
      var profile_login = '<?php echo $profile_login; ?>';
     var user_id = '<?php echo $this->session->userdata('aileenuser');?>';
  </script>
  <script src="<?php echo base_url('assets/js/backdetect.jquery.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/job_reg.js?ver='.time()); ?>"></script>
<?php
        if (IS_JOB_JS_MINIFY == '0') {
            ?>
  <!--<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/job_reg.js?ver='.time()); ?>"></script>-->
  <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/search_job_reg&skill.js?ver='.time()); ?>"></script>
<?php }else{?>


 <!--<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/job/job_reg.js?ver='.time()); ?>"></script>-->
  <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/job/search_job_reg&skill.js?ver='.time()); ?>"></script>
  
<?php }?>
</body>
</html>