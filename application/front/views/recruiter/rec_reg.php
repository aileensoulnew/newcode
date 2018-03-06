
<!DOCTYPE html>
<html>
     <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?> 
        <?php
        if (IS_REC_CSS_MINIFY == '0') {
            ?>
           <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css'); ?>">
          <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver='.time()); ?>">
  <?php
        } else {
            ?>
          <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css?ver='.time()); ?>">
          <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/job.css'); ?>">
        <?php } ?>
            
        
            
            
    </head>
   <head>
<!-- start head -->

</head>
<!-- END HEAD -->

<!-- start header -->
<!-- END HEADER -->
<?php if(!$userid){ ?>
<body class="botton_footer cus-error no-login">
<?php } else{?>
<body class="botton_footer cus-error">
<?php } ?>
    <?php echo $header; ?>

    <?php  $userid = $this->session->userdata('aileenuser');

    if(!$userid){
    ?> 
      
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
                     <?php if($this->uri->segment(3) == 'live-post'){
                         echo '<div class="alert alert-success">Your Post is automatically Post after completing recruiter registation...!</div>';
                     } ?>
                                 
                     <div class="common-form job_reg_main">
                        <h3>Welcome in Recruiter Profile</h3>
                         
                        <form id="basicinfo" name="basicinfo" class="clearfix">
                        <fieldset>
                                        <label>First Name<span class="red">*</span>:</label>
                                        <input name="first_name" tabindex="1" autofocus type="text" id="first_name"  placeholder="Enter First Name" value="<?php
                                        if ($firstname) {
                                            echo trim(ucfirst(strtolower($firstname)));
                                        } else {
                                            echo trim(ucfirst(strtolower($userdata['first_name'])));
                                        }
                                        ?>" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value"/><span id="fullname-error "></span>
                                               <?php echo form_error('first_name'); ?>
                                    </fieldset>
                        <fieldset>
                                        <label>Last Name<span class="red">*</span> :</label>
                                        <input name="last_name" type="text" tabindex="2" id="last_name" placeholder="Enter Last Name"
                                               value="<?php
                                               if ($lastname) {
                                                   echo trim(ucfirst(strtolower($lastname)));
                                               } else {
                                                   echo trim(ucfirst(strtolower($userdata['last_name'])));
                                               }
                                               ?>" id="last_name" /><span id="fullname-error" ></span>
                                               <?php echo form_error('last_name'); ?>
                                    </fieldset>
                        <fieldset class="full-width vali_er">
                                        <label>Email address:<span class="red">*</span></label>
                                        <input name="email"  type="text" id="email" tabindex="3" placeholder="Enter Email"  value="<?php
                                        if ($email) {
                                            echo $email;
                                        } else {
                                            echo $userdata['email'];
                                        }
                                        ?>" /><span id="email-error" ></span>
                                        <span class="email_note"><b>Note:-</b> Related notification email will be send on provided email address kindly use regular  email address.<div></div></span>
                                               <?php echo form_error('email'); ?>
                                    </fieldset>
                        <fieldset class="full-width">
                         <h4>Company Information</h4>
                         </fieldset>
                         <fieldset <?php if ($comp_name) { ?> class="error-msg" <?php } ?>>
                                    <label>Company Name :<span class="red">*</span> </label>
                                    <input name="comp_name" tabindex="4" autofocus type="text" id="comp_name" placeholder="Enter Company Name"  value="<?php
                                    if ($compname) {
                                        echo $compname;
                                    }
                                    ?>" onfocus="var temp_value=this.value; this.value=''; this.value=temp_value"/><span id="fullname-error"></span>
                                </fieldset>
                                <?php echo form_error('comp_name'); ?>
                                    <fieldset <?php if ($comp_email) { ?> class="error-msg" <?php } ?>>
                                    <label>Company Email:<span class="red">* </span></label>
                                    <input name="comp_email" type="text" tabindex="5" id="comp_email" placeholder="Enter Company Email" value="<?php
                                    if ($compemail) {
                                        echo $compemail;
                                    }
                                    ?>" /><span id="fullname-error"></span>
                                </fieldset>
                                <?php echo form_error('comp_email'); ?>
                       
                        <fieldset class="full-width <?php if ($comp_num) { ?> error-msg <?php } ?>">
                                    <label>Company Number:<span class="optional">(optional)</span></label>
                                    <input name="comp_num"  type="text" id="comp_num" tabindex="6" placeholder="Enter Comapny Number" value="<?php
                                    if ($compnum) {
                                        echo $compnum;
                                    }
                                    ?>"/><span id="email-error"></span>
                                </fieldset>
                                <?php echo form_error('comp_num'); ?>
                        <fieldset <?php if ($country) { ?> class="error-msg" <?php } ?>>
                                    <label>Country:<span class="red">*</span></label>

                                    <select tabindex="7" autofocus name="country" id="country">
                                        <option value="">Select Country</option>
                                        <?php
                                        if (count($countries) > 0) {
                                            foreach ($countries as $cnt) {

                                                if ($country1) {
                                                    ?>
                                                    <option value="<?php echo $cnt['country_id']; ?>" <?php if ($cnt['country_id'] == $country1) echo 'selected'; ?>><?php echo $cnt['country_name']; ?></option>

                                                    <?php
                                                }
                                                else {
                                                    ?>
                                                    <option value="<?php echo $cnt['country_id']; ?>"><?php echo $cnt['country_name']; ?></option>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </select><span id="country-error"></span>
                                    <?php echo form_error('country'); ?>
                                </fieldset>
                       
 <fieldset <?php if ($state) { ?> class="error-msg" <?php } ?>>
                                    <label>State:<span class="red">*</span> </label>
                                    <select name="state" id="state" tabindex="8">
                                        <?php
                                        if ($state1) {
                                            foreach ($states as $cnt) {
                                                ?>

                                                <option value="<?php echo $cnt['state_id']; ?>" <?php if ($cnt['state_id'] == $state1) echo 'selected'; ?>><?php echo $cnt['state_name']; ?></option>

                                                <?php
                                            }
                                        }
                                        else {
                                            ?>
                                            <option value="">Select country first</option>
                                            <?php
                                        }
                                        ?>

                                    </select><span id="state-error"></span>
                                    <?php echo form_error('state'); ?>
                                </fieldset>
                                <fieldset <?php if ($city) { ?> class="error-msg" <?php } ?> class="full-width">
                                    <label> City:<span class="optional">(optional)</span></label>
                                    <select name="city" id="city" tabindex="9">
                                        <?php
                                        if ($city1) {
                                            foreach ($cities as $cnt) {
                                                ?>

                                                <option value="<?php echo $cnt['city_id']; ?>" <?php if ($cnt['city_id'] == $city1) echo 'selected'; ?>><?php echo $cnt['city_name']; ?></option>

                                                <?php
                                            }
                                        }
                                        else if ($state1) {
                                            ?>
                                            <option value="">Select City</option>
                                            <?php
                                            foreach ($cities as $cnt) {
                                                ?>

                                                <option value="<?php echo $cnt['city_id']; ?>"><?php echo $cnt['city_name']; ?></option>

                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <option value="">Select state first</option>

                                            <?php
                                        }
                                        ?>
                                    </select><span id="city-error"></span>
                                    <?php echo form_error('city'); ?> 
                                </fieldset>

                               
                         
                         <fieldset <?php if ($comp_profile) { ?> class="error-msg" <?php } ?> class="full-width">
                                    <label>Company Profile:<span class="optional">(optional)</span><!-- <span style="color:red">*</span> -->

                                        <textarea tabindex="10" name ="comp_profile" id="comp_profile" rows="4" cols="50" placeholder="Enter Company Profile" style="resize: none;"><?php
                                            if ($comp_profile1) {
                                                echo $comp_profile1;
                                            }
                                            ?></textarea>
                                        
                                </fieldset>
                         <input type="hidden" id="segment" value="<?php echo  $this->uri->segment(3); ?>">
                         
                         
                         
                        <fieldset class=" full-width">
                           <div class="job_reg">
                             <!--  <input title="Register" type="submit" id="submit" name="" value="Register" tabindex="11"> -->

                              <button id="submit" name="submit" tabindex="11" onclick="return reg_loader();" class="cus_btn_sub">Register<span class="ajax_load pl10" id="profilereg_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>

                           </div>
                        </fieldset>
    </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- END CONTAINER -->
 <!-- BEGIN FOOTER -->
        <?php echo $login_footer ?>
        <?php echo $footer; ?>
        <!-- END FOOTER -->
        
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

        <div class="modal fade register-model login" data-backdrop="static" data-keyboard="false" id="register" role="dialog">
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
                                                    <input tabindex="101" autofocus="" type="text" name="first_name1" id="first_name1" class="form-control input-sm" placeholder="First Name">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <input tabindex="102" type="text" name="last_name1" id="last_name1" class="form-control input-sm" placeholder="Last Name">
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
                                            </select>
                                            </span>
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
                                                Already have an account ? <a tabindex="112" onClick="login_profile();" href="javascript:void(0);" title="Log In"> Log In </a>
                                            </p>
                                        </div>
                                    </form>
                               

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
                                            <a href="javascript:void(0)" data-toggle="modal" onclick="forgot_profile();" id="myBtn" title="Forgot Password ?">Forgot Password ?</a>
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

  
        
  <script>
                                        var base_url = '<?php echo base_url(); ?>';
                                        var data1 = <?php echo json_encode($de); ?>;
                                        var data = <?php echo json_encode($demo); ?>;
                                        var user_session = '<?php echo $this->session->userdata('aileenuser'); ?>';
        
  </script>
        <!-- FIELD VALIDATION JS END -->
   <?php
        if (IS_REC_JS_MINIFY == '0') {
            ?>
              <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js') ?>"></script>
              <script src="<?php echo base_url('assets/js/jquery.fancybox.js'); ?>"></script>
              <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver='.time()); ?>"></script>
              <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/search.js'); ?>"></script>
              <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/rec_reg.js'); ?>"></script>
            <?php
        } else {
            ?>
              <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js') ?>"></script>
              <script src="<?php echo base_url('assets/js_min/jquery.fancybox.js'); ?>"></script>
              <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver='.time()); ?>"></script>
              <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/recruiter/search.js'); ?>"></script>
              <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/recruiter/rec_reg.js'); ?>"></script>
        <?php } ?>
</body>
</html>