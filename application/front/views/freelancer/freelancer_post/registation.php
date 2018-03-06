<!DOCTYPE html>
<html>
    <head>
        <!-- start head -->
        <?php echo $head; ?>
        <!-- Calender Css Start-->

        <title><?php echo $title; ?></title>
        <!-- Calender Css End-->
        <?php
        if (IS_APPLY_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/freelancer-apply.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver=' . time()); ?>">
            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/freelancer-apply.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/job.css?ver=' . time()); ?>">
        <?php } ?>

        <!-- This Css is used for call popup -->
        <?php if (!$this->session->userdata('aileenuser')) { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css'); ?>">

        <?php } ?>     

    </head>
    <!-- END HEAD -->

    <!-- start header -->
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
                            <a href="javascript:void(0);" onclick="login_profile();" class="btn2">Login</a>
                            <a href="javascript:void(0);" onclick="create_profile();" class="btn3">Create an account</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    <?php } ?>
    <!-- END HEADER -->
    <body class="no-login botton_footer cus-error" id="add-model-open">
        <section>
            <div class="user-midd-section " id="paddingtop_fixed">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="clearfix">
                            <div class="job_reg_page_fprm">
                                <?php
                                if ($this->uri->segment(3) == 'live-post') {
                                    echo '<div class="alert alert-success">You  will be automatically apply successfully after completing of Freelancer profile ...!</div>';
                                }
                                ?>
                                <div class="common-form job_reg_main">
                                    <h3>Welcome in Freelancer Profile</h3>
                                    <?php echo form_open(base_url('freelancer/registation_insert/' . $this->uri->segment(4)), array('id' => 'freelancer_regform', 'name' => 'freelancer_regform', 'class' => 'clearfix')); ?>
                                    <?php
                                    $fullname = form_error('firstname');
                                    $lastname = form_error('lastname');
                                    $email = form_error('email');
                                    $country = form_error('country');
                                    $state = form_error('state');
                                    $field = form_error('field');
                                    $skill = form_error('skills');
                                    $experiance = form_error('experiance');
                                    //  echo $experiance;die();
                                    ?>
                                    <fieldset>
                                        <label >First Name <font  color="red">*</font> :</label>                          
                                        <input type="text" name="firstname" id="firstname" tabindex="1" placeholder="Enter first name" style="text-transform: capitalize;" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value" value="<?php echo $userdata['first_name']; ?>" maxlength="35">
                                        <?php
                                        echo form_error('firstname');
                                        ?>
                                    </fieldset>
                                    <fieldset>
                                        <label >Last Name <font  color="red">*</font>:</label>
                                        <input type="text" name="lastname" id="lastname" tabindex="2" placeholder="Enter last name" style="text-transform: capitalize;" onfocus="this.value = this.value;" value="<?php echo $userdata['last_name']; ?>" maxlength="35">
                                        <?php
                                        echo form_error('lastname');
                                        ?>
                                    </fieldset class="vali_er">
                                    <div class="fw">
                                    <fieldset>
                                        <label >Email Address <font  color="red">*</font> :</label>
                                        <input type="email" name="email" id="email" tabindex="3" placeholder="Enter email address" value="<?php echo $userdata['email']; ?>" maxlength="255">
                                         <span class="email_note"><b>Note:-</b> Related notification email will be send on provided email address kindly use regular  email address.<div></div></span>
                                        <?php
                                        echo form_error('email');
                                        ?>
                                    </fieldset>
                                    <fieldset>
                                        <label >Phone number:<span class="optional">(optional)</span></label>
                                        <input type="text" name="phoneno" id="phoneno" tabindex="4" placeholder="Enter phone number"  maxlength="255">

                                    </fieldset>
                                </div>
                                    <fieldset <?php if ($country) { ?> class="error-msg" <?php } ?>>
                                        <label>Country:<span style="color:red">*</span></label>								
                                        <select name="country" id="country" tabindex="5">
                                            <option value="">Select country</option>
                                            <?php
                                            if (count($countries) > 0) {
                                                foreach ($countries as $cnt) {
                                                    ?>
                                                    <option value="<?php echo $cnt['country_id']; ?>"><?php echo $cnt['country_name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select><span id="country-error"></span>
                                        <?php echo form_error('country'); ?>
                                    </fieldset> 

                                    <fieldset <?php if ($state) { ?> class="error-msg" <?php } ?>>
                                        <label>state:<span style="color:red">*</span></label>
                                        <select name="state" id="state" tabindex="6">
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

                                    <fieldset class="fw" <?php if ($city) { ?> class="error-msg" <?php } ?>>
                                        <label> City:<span style="color:red">*</span></label>
                                        <select name="city" id="city" tabindex="7">
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
                                                <option value="">Select city</option>
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

                                    </fieldset>                              

                                    <fieldset  <?php if ($field) { ?> class="full-width error-msg" <?php } else { ?> class="full-width" <?php } ?>>
                                        <?php if ($livepostid) { ?>
                                            <input type="hidden" name="livepostid" id="livepostid" tabindex="8"  value="<?php echo $livepostid; ?>">
                                        <?php }
                                        ?>
                                        <label><?php echo $this->lang->line("your_field"); ?>:<span class="red">*</span></label> 

                                        <select tabindex="8" name="field" id="field" class="field_other">
                                            <option value=""><?php echo $this->lang->line("select_filed"); ?></option>
                                            <?php
                                            if (count($category_data) > 0) {
                                                foreach ($category_data as $cnt) {
                                                    if ($fields_req1) {
                                                        ?>
                                                        <option value="<?php echo $cnt['category_id']; ?>" <?php if ($cnt['category_id'] == $fields_req1) echo 'selected'; ?>><?php echo $cnt['category_name']; ?></option>

                                                        <?php
                                                    }
                                                    else {
                                                        ?>
                                                        <option value="<?php echo $cnt['category_id']; ?>"><?php echo $cnt['category_name']; ?></option> 
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                            <option value="<?php echo $category_otherdata[0]['category_id']; ?> "><?php echo $category_otherdata[0]['category_name']; ?></option>
                                        </select> 
                                        <?php echo form_error('field'); ?>
                                    </fieldset>

                                    <fieldset  <?php if ($skill) { ?> class="error-msg full-width" <?php } else { ?> class="full-width" <?php } ?>>
                                        <label> <?php echo $this->lang->line("your_skill"); ?>:<span class="red">*</span></label>
                                        <input id="skills1" name="skills" tabindex="9"   placeholder="Enter skills" value="<?php
                                        if ($skill_2) {
                                            echo $skill_2;
                                        }
                                        ?>">
                                               <?php echo form_error('skills'); ?>
                                    </fieldset>

                                    <fieldset   <?php if ($experiance) { ?> class="error-msg full-width" <?php } else { ?> class="full-width" <?php } ?>>
                                        <label><?php echo $this->lang->line("total_experiance"); ?> :<span class="red">*</span></label>  <select name="experience_year" placeholder="Year" tabindex="10" id="experience_year" class="experience_year col-md-5 day" onchange="return check_yearmonth();" style="margin-right: 4%;">

                                            <option value="" selected option disabled><?php echo $this->lang->line("year"); ?></option>
                                            <option value="0 year"  <?php if ($experience_year1 == "0 year") echo 'selected'; ?>>0 Year</option>
                                            <option value="1 year"  <?php if ($experience_year1 == "1 year") echo 'selected'; ?>>1 Year</option>
                                            <option value="2 year"  <?php if ($experience_year1 == "2 year") echo 'selected'; ?>>2 Year</option>
                                            <option value="3 year"  <?php if ($experience_year1 == "3 year") echo 'selected'; ?>>3 Year</option>
                                            <option value="4 year"  <?php if ($experience_year1 == "4 year") echo 'selected'; ?>>4 Year</option>
                                            <option value="5 year"  <?php if ($experience_year1 == "5 year") echo 'selected'; ?>>5 Year</option>
                                            <option value="6 year"  <?php if ($experience_year1 == "6 year") echo 'selected'; ?>>6 Year</option>
                                            <option value="7 year"  <?php if ($experience_year1 == "7 year") echo 'selected'; ?>>7 Year</option>  
                                            <option value="8 year"  <?php if ($experience_year1 == "8 year") echo 'selected'; ?>>8 Year</option>
                                            <option value="9 year"  <?php if ($experience_year1 == "9 year") echo 'selected'; ?>>9 Year</option> 
                                            <option value="10 year"  <?php if ($experience_year1 == "10 year") echo 'selected'; ?>>10 Year</option>
                                            <option value="11 year"  <?php if ($experience_year1 == "11 year") echo 'selected'; ?>>11 Year</option> 
                                            <option value="12 year"  <?php if ($experience_year1 == "12 year") echo 'selected'; ?>>12 Year</option>
                                            <option value="13 year"  <?php if ($experience_year1 == "13 year") echo 'selected'; ?>>13 Year</option> 
                                            <option value="14 year"  <?php if ($experience_year1 == "14 year") echo 'selected'; ?>>14 Year</option>
                                            <option value="15 year"  <?php if ($experience_year1 == "15 year") echo 'selected'; ?>>15 Year</option>
                                            <option value="16 year"  <?php if ($experience_year1 == "16 year") echo 'selected'; ?>>16 Year</option>
                                            <option value="17 year"  <?php if ($experience_year1 == "17 year") echo 'selected'; ?>>17 Year</option>
                                            <option value="18 year"  <?php if ($experience_year1 == "18 year") echo 'selected'; ?>>18 Year</option>
                                            <option value="19 year"  <?php if ($experience_year1 == "19 year") echo 'selected'; ?>>19 Year</option>
                                            <option value="20 year"  <?php if ($experience_year1 == "20 year") echo 'selected'; ?>>20 Year</option>

                                        </select>


                                        <select name="experience_month" tabindex="11" id="experience_month" placeholder="Month" class="experience_month col-md-5 day" onchange="return check_yearmonth();" >
                                            <option value="" selected option disabled><?php echo $this->lang->line("month"); ?></option>
                                            <option value="0 month"  <?php if ($experience_month1 == "0 month") echo 'selected'; ?>>0 Month</option>
                                            <option value="1 month"  <?php if ($experience_month1 == "1 month") echo 'selected'; ?>>1 Month</option>
                                            <option value="2 month"  <?php if ($experience_month1 == "2 month") echo 'selected'; ?>>2 Month</option>
                                            <option value="3 month"  <?php if ($experience_month1 == "3 month") echo 'selected'; ?>>3 Month</option>
                                            <option value="4 month"  <?php if ($experience_month1 == "4 month") echo 'selected'; ?>>4 Month</option>
                                            <option value="5 month"  <?php if ($experience_month1 == "5 month") echo 'selected'; ?>>5 Month</option>
                                            <option value="6 month"  <?php if ($experience_month1 == "6 month") echo 'selected'; ?>>6 Month</option>
                                            <option value="7 month"  <?php if ($experience_month1 == "7 month") echo 'selected'; ?>>7 Month</option>
                                            <option value="8 month"  <?php if ($experience_month1 == "8 month") echo 'selected'; ?>>8 Month</option>
                                            <option value="9 month"  <?php if ($experience_month1 == "9 month") echo 'selected'; ?>>9 Month</option>
                                            <option value="10 month"  <?php if ($experience_month1 == "10 month") echo 'selected'; ?>>10 Month</option>
                                            <option value="11 month"  <?php if ($experience_month1 == "11 month") echo 'selected'; ?>>11 Month</option>
                                            <option value="12 month"  <?php if ($experience_month1 == "12 month") echo 'selected'; ?>>12 Month</option>

                                        </select>  

                                        <?php echo form_error('experiance'); ?>
                                    </fieldset>


                                    <fieldset class=" full-width">
                                        <div class="job_reg">
                                            <!-- <input title="Register" tabindex="12" type="submit" id="submit" name="" value="Register"> -->

                                             <button id="submit" name="submit" tabindex="12" onclick="return validate();" class="cus_btn_sub">Register<span class="ajax_load pl10" id="profilereg_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>

                                        </div>
                                    </fieldset>
                                    <?php echo form_close(); ?>
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
        <!-- Bid-modal for other field start  -->
        <div class="modal fade message-box biderror custom-message" id="bidmodal2" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content message">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>
                    <h2>Add Field</h2>         
                    <input type="text" name="other_field" id="other_field" onkeypress="return remove_validation()">
                    <div class="fw"><a id="field" class="btn">OK</a></div>
                    <!--                    </div>-->
                </div>
            </div>
        </div>
        <!-- Model for other field Popup Close -->
        <!-- register -->

        <div class="modal fade register-model login" data-backdrop="static" data-keyboard="false" id="register" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content inner-form1">
                    <!--<button type="button" class="modal-close" data-dismiss="modal">&times;</button>-->       
                    <div class="modal-body">
                        <div class="clearfix">
                            <div class="">
                                <div class="title"><h1 class="tlh1">Sign up First and Register in Freelancer Profile</h1></div>
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
                                            <span><select tabindex="108" class="gender"  onchange="changeMe(this)" name="selgen" id="selgen">
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
                                                                                        <!--<p class="next">Next</p>-->
                                        </p>
                                        <div class="sign_in pt10">
                                            <p>
                                                Already have an account ? <a tabindex="112" onClick="login_profile();" href="javascript:void(0);"> Log In </a>
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
                                            <a href="javascript:void(0)" data-toggle="modal" onclick="forgot_profile();" id="myBtn">Forgot Password ?</a>
                                        </p>

                                        <p class="pt15 text-center">
                                            Don't have an account? <a class="db-479" href="javascript:void(0);" data-toggle="modal" onclick="create_profile();">Create an account</a>
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
        <?php echo $footer; ?>
        <!-- </footer> -->
        <script async type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/registation.js?ver=' . time()); ?>"></script>
        <?php
        if (IS_APPLY_JS_MINIFY == '0') {
            ?>
            <script  type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
            <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
            <!--<script async type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/registation.js?ver=' . time()); ?>"></script>-->

            <?php
        } else {
            ?>
            <script  type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()) ?>"></script>
            <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
            <!--<script async type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-apply/registation.js?ver=' . time()); ?>"></script>-->

        <?php } ?>


        <script>
                                                var base_url = '<?php echo base_url(); ?>';
                                                var site = '<?php echo base_url(); ?>';
                                                var user_session = '<?php echo $this->session->userdata('aileenuser'); ?>';
        </script>
    </body>
</html>