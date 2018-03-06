<!DOCTYPE html>
<html>
    <head>
        <?php echo $head; ?>
        <title><?php echo $title; ?></title>
        <?php
        if (IS_REC_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css'); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/recruiter.css'); ?>">
            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css'); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/recruiter.css'); ?>">
        <?php } ?>


        <style type="text/css">
            .last_date_error{
                background: none;
                color: red !important;
                padding: 0px 10px !important;
                position: absolute;
                right: 8px;
                z-index: 8;
                line-height: 15px;
                padding-right: 0px!important;
                font-size: 11px!important;
            }

        </style>

    </head>

    <body class="page-container-bg-solid page-boxed freeh3 cust-add-live botton_footer no-login">
        <header>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-3 left-header text-center fw-479">
                        <div class="logo"><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png?ver=' . time()) ?>" alt="logo"></a></div>
                    </div>
                    <div class="col-md-8 col-sm-9 right-header fw-479 text-center">
                        <div class="btn-right pull-right">
                            <a href="javascript:void(0);" onclick="login_profile();" title="Login" class="btn2">Login</a>
                            <a href="javascript:void(0);" onclick="register_profile();" title="Creat an account" class="btn3">Creat an account</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <section>
            <!-- MIDDLE SECTION START -->
            <div class="user-midd-section" id="paddingtop_fixed">
                <div class="container">
                    <div class="row">
                        <h3 class="col-chang cus-chang text-center" style="color: #1b8ab9 !important;">Please post your requirement, so that we can recommend you the candidates</h3>
                        <div class="col-md-2 col-sm-1"> 
                            <div  class="add-post-button">


                            </div></div>
                        <div class="col-md-8 col-sm-10">

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

                            <div class="common-form custom-form">


                                <div class="job-saved-box">

                                    <form id="artpost" name="artpost" class="clearfix">
                                        <?php
                                        $postname = form_error('postname');
                                        $skills1 = form_error('skills1');
                                        $description = form_error('description');
                                        $postattach = form_error('postattach');
                                        $degree1 = form_error('education1');
                                        ?>
                                        <div class="custom-add-box">

                                            <h3>Job Detail</h3>
                                            <div class="p15 fw">
                                                <fieldset class="full-width"<?php if ($post_name) { ?> class=" error-msg" <?php } ?> >
                                                    <label class="control-label">Job Title:<span style="color:red">*</span></label>
                                                    <input type="search" tabindex="1"  id="post_name" name="post_name" value=""  placeholder="Enter Job Title" style="text-transform: capitalize;"  maxlength="255">
                                                    <span id="fullname-error"></span>
                                                    <?php echo form_error('post_name'); ?>
                                                </fieldset>
                                                <fieldset class="form-group full-width">
                                                    <label class="control-label">Job Description:<span style="color:red">*</span></label>
                                                    <textarea name="post_desc" id="post_desc" tabindex="2" rows="8" cols="50"  placeholder="Enter Job Description" style="resize: none;"></textarea>

                                                    <?php echo form_error('post_desc'); ?>
                                                </fieldset>
                                                <fieldset class="full-width" <?php if ($skills) { ?> class="error-msg" <?php } ?>>
                                                    <label class="control-label">Skills: <span style="color:red">*</span></label>

                                                    <input id="skills2" name="skills" tabindex="3" size="90" placeholder="Enter Skills">

                                                    <?php echo form_error('skills'); ?>
                                                </fieldset>
                                                <fieldset class="full-width" <?php if ($industry) { ?> class="error-msg" <?php } ?> class="two-select-box"> 
                                                    <label>Industry:<span style="color:red">*</span></label>
                                                    <select name="industry" id="industry" tabindex="4"  class="industry1">

                                                        <option value="" selected option disabled>Select Industry</option>

                                                        <?php foreach ($industry as $indu) { ?>
                                                            <option value="<?php echo $indu['industry_id']; ?>"><?php echo $indu['industry_name']; ?></option>
                                                        <?php } ?>

                                                        <option value="<?php echo $industry_otherdata[0]['industry_id']; ?> "><?php echo $industry_otherdata[0]['industry_name']; ?></option>    
                                                    </select>


                                                    <?php echo form_error('industry'); ?>
                                                </fieldset>

                                                <fieldset class="form-group full-width">
                                                    <label class="control-label">Interview process:<span class="optional">(optional)</span></label>



                                                    <textarea name="interview" id="interview" rows="4" tabindex="5" cols="50"  placeholder="Enter Interview Process" style="resize: none;"></textarea>


                                                </fieldset>
                                                <fieldset <?php if ($month) { ?> class="error-msg" <?php } ?> class="two-select-box1">

                                                    <label style="cursor:pointer;" class="control-label">Minimum Experience:<span style="color:red">*</span></label>


                                                    <select name="minyear" style="cursor:pointer;" class="keyskil" id="minyear" tabindex="6">
                                                        <option value="" selected option disabled>Year</option>

                                                        <option value="0">0 Year</option>
                                                        <option value="0.5">0.5 Year</option>
                                                        <option value="1">1 Year</option>
                                                        <option value="1.5">1.5 Year</option>
                                                        <option value="2">2 Year</option>
                                                        <option value="2.5"> 2.5 Year</option>
                                                        <option value="3">3 Year</option>
                                                        <option value="4">4 Year</option>
                                                        <option value="5">5 Year</option>
                                                        <option value="6">6 Year</option>
                                                        <option value="7">7 Year</option>
                                                        <option value="8">8 Year</option>
                                                        <option value="9">9 Year</option>
                                                        <option value="10">10 Year</option>
                                                        <option value="11">11 Year</option>
                                                        <option value="12">12 Year</option>
                                                        <option value="13">13 Year</option>
                                                        <option value="14">14 Year</option>
                                                        <option value="15">15 Year</option>
                                                        <option value="16">16 Year</option>
                                                        <option value="17">17 Year</option>
                                                        <option value="18">18 Year</option>
                                                        <option value="19">19 Year</option>
                                                        <option value="20">20 Year</option>
                                                    </select>

                                                    <span id="fullname-error"></span>
                                                    <?php echo form_error('month'); ?>  <?php echo form_error('year'); ?>

                                                </fieldset>


                                                <fieldset <?php if ($month) { ?> class="error-msg" <?php } ?> class="two-select-box1">
                                                    <label style="cursor:pointer;" class="control-label">Maximum Experience:<span style="color:red">*</span></label>

                                                    <select tabindex="7" name="maxyear" style="cursor:pointer;" class="keyskil1" id="maxyear">
                                                        <option value="" selected option disabled>Year</option>
                                                        <option value="0">0 Year</option>
                                                        <option value="0.5">0.5 Year</option>
                                                        <option value="1">1 Year</option>
                                                        <option value="1.5">1.5 Year</option>
                                                        <option value="2">2 Year</option>
                                                        <option value="2.5"> 2.5 Year</option>
                                                        <option value="3">3 Year</option>
                                                        <option value="4">4 Year</option>
                                                        <option value="5">5 Year</option>
                                                        <option value="6">6 Year</option>
                                                        <option value="7">7 Year</option>
                                                        <option value="8">8 Year</option>
                                                        <option value="9">9 Year</option>
                                                        <option value="10">10 Year</option>
                                                        <option value="11">11 Year </option>
                                                        <option value="12">12 Year </option>
                                                        <option value="13">13 Year </option>
                                                        <option value="14">14 Year </option>
                                                        <option value="15">15 Year </option>
                                                        <option value="16">16 Year </option>
                                                        <option value="17">17 Year </option>
                                                        <option value="18">18 Year </option>
                                                        <option value="19">19 Year </option>
                                                        <option value="20">20 Year </option>
                                                    </select>

                                                    <span id="fullname-error"></span>
                                                    <?php echo form_error('month'); ?>  <?php echo form_error('year'); ?>
                                                </fieldset>

                                                <fieldset class="rec_check form-group full-width">
                                                    <input  type="checkbox" tabindex="8" id="fresher_nme" name="fresher" value="1"><label for="fresher_nme">Fresher can also apply..!   </label> 
                                                </fieldset>
                                                <fieldset id="erroe_nn" class="full-width" <?php if ($degree1) { ?> class="error-msg" <?php } ?>>
                                                    <label>Required Education:<span class="optional">(optional)</span></label> 

                                                    <input type="search" tabindex="9" id="education" name="education" value="" placeholder="Education" style="text-transform: capitalize;" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value" maxlength="255">
                                                    <span id="fullname-error"></span>
                                                    <?php echo form_error('education'); ?>
                                                </fieldset>
                                                <fieldset <?php if ($emp_type) { ?> class="error-msg" <?php } ?> class="two-select-box1">

                                                    <label style="cursor:pointer;" class="control-label">Employment Type:<span style="color:red">*</span></label>


                                                    <select name="emp_type" style="cursor:pointer;" class="keyskil" tabindex="10" id="emp_type">
                                                        <option value="" selected option disabled>Employment Type</option>
                                                        <option value="Part Time">Part Time</option>
                                                        <option value="Full Time">Full Time</option>
                                                        <option value="Internship">Internship</option>
                                                    </select>
                                                    <span id="fullname-error"></span>
                                                    <?php echo form_error('emp_type'); ?>  <?php echo form_error('emp_type'); ?>
                                                </fieldset>

                                                <fieldset class="" <?php if ($position) { ?> class="error-msg" <?php } ?>>
                                                    <label class="control-label">No Of Position:<span style="color:red">*</span> </label>
                                                    <input name="position_no" type="text"  id="position" value="1" tabindex="11" placeholder="Enter No of position"/>
                                                    <span id="fullname-error"></span>
                                                    <?php echo form_error('position'); ?>        
                                                </fieldset>
                                                <fieldset class="form-group fw">
                                                    <label class="control-label">Last Date For Apply:<span style="color:red">*</span></label>

                                                    <input type="hidden" id="example2" tabindex="12">

                                                    <?php echo form_error('last_date'); ?> 
                                                </fieldset>
                                            </div>
                                        </div>

                                        <div class="custom-add-box">
                                            <h3>Salary Information</h3>
                                            <div class="p15 fw">
                                                <fieldset <?php if ($salary_type) { ?> class="error-msg" <?php } ?> class="two-select-box1">

                                                    <label style="cursor:pointer;" class="control-label">Salary Type:<span class="optional">(optional)</span></label>


                                                    <select name="salary_type" style="cursor:pointer;" class="keyskil" id="salary_type" tabindex="16">
                                                        <option value="" selected option disabled>Salary Type</option>
                                                        <option value="Per Year"> Per Year</option>
                                                        <option value="Per Month">Per Month</option>
                                                        <option value="Per Week">Per Week</option>
                                                        <option value="Per Day">Per Day</option>

                                                    </select>


                                                    <span id="fullname-error"></span>
                                                    <?php echo form_error('salary_type'); ?>  <?php echo form_error('salary_type'); ?>

                                                </fieldset>
                                                <fieldset class="" <?php if ($currency) { ?> class="error-msg" <?php } ?> class="two-select-box"> 
                                                    <label>Currency:<span class="optional">(optional)</span></label>
                                                    <select name="currency" id="currency" tabindex="17">

                                                        <option value="" selected option disabled>Select Currency</option>

                                                        <?php foreach ($currency as $cur) { ?>
                                                            <option value="<?php echo $cur['currency_id']; ?>"><?php echo $cur['currency_name']; ?></option>
                                                        <?php } ?>
                                                    </select>


                                                    <?php echo form_error('currency'); ?>
                                                </fieldset>
                                                <fieldset class=" " <?php if ($minsal) { ?> class="error-msg" <?php } ?>>
                                                    <label class="control-label">Minimum Salary:<span class="optional">(optional)</span></label>
                                                    <input name="minsal" type="text" id="minsal" placeholder="Enter Minimum Salary" tabindex="18" /><span id="fullname-error"></span>
                                                    <?php echo form_error('minsal'); ?>
                                                </fieldset>

                                                <fieldset class="" <?php if ($maxsal) { ?> class="error-msg " <?php } ?>>
                                                    <label class="control-label">Maximum Salary:<span class="optional">(optional)</span></label>
                                                    <input name="maxsal" type="text" id="maxsal" tabindex="19" placeholder="Enter Maximum Salary" /><span id="fullname-error"></span>
                                                    <?php echo form_error('maxsal'); ?>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="custom-add-box">
                                            <h3>Job Location</h3>
                                            <div class="p15 fw">
                                                <fieldset class="fw" <?php if ($country) { ?> class="error-msg" <?php } ?>>
                                                    <label >Country:<span style="color:red">*</span></label>
                                                    <select style="cursor:pointer;" name="country" id="country" tabindex="20">
                                                        <option value="" selected option disabled>Select Country</option>
                                                        <?php
                                                        if (count($countries) > 0) {
                                                            foreach ($countries as $cnt) {
                                                                ?>
                                                                <option value="<?php echo $cnt['country_id']; ?>"><?php echo $cnt['country_name']; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select> 
                                                    <?php echo form_error('country'); ?>
                                                </fieldset>

                                                <fieldset class="fw" <?php if ($state) { ?> class="error-msg" <?php } ?>>
                                                    <label>State:<span style="color:red">*</span></label>
                                                    <select style="cursor:pointer;" name="state" id="state" tabindex="21">
                                                        <option value="">Select Country First</option>
                                                    </select>
                                                    <?php echo form_error('state'); ?> 
                                                </fieldset>

                                                <fieldset class="fw" <?php if ($city) { ?> class="error-msg" <?php } ?>>
                                                    <label>City:</label>
                                                    <select style="cursor:pointer;" name="city" id="city" tabindex="22">
                                                        <option value="">Select State First</option>
                                                    </select>

                                                </fieldset>













<!--   <fieldset class="full-width" <?php //if ($other_skill) {           ?> class="error-msg" <?php //}           ?> >
    <label class="control-label">Other Skill: --><!-- <span style="color:red">*</span> --><!-- </label>
    <input name="other_skill" type="text" class="skill_other" tabindex="3" id="other_skill" placeholder="Enter Your Skill" />
    <span id="fullname-error"></span>
                                                <?php //echo form_error('other_skill');  ?> 
                                    </fieldset>-->
                                                <!--  </div> -->






























                                                <input type="hidden" id="tagSelect" tabindex="23" value="brown,red,green" style="width:300px;" />



                                                <fieldset  class="hs-submit full-width">


                                                    <input type="submit" title="Post" id="submit"  class="add_post_btns" tabindex="24" name="submit" value="Post">

                                                </fieldset>
                                            </div>
                                        </div>      
                                    </form>

                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- MIDDLE SECTION END-->
        </section>
        <?php echo $login_footer ?>
        <?php echo $footer; ?>


        <!-- Login for submit post data -->
        <div class="modal fade login" id="login" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content login-frm">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <div class="right-main">
                            <div class="right-main-inner">
                                <div class="">
                                    <div class="title">
                                        <h1 class="ttc tlh2">Welcome To Aileensoul</h1>
                                    </div>

                                    <form role="form" name="login_form" id="login_form" method="post">

                                        <div class="form-group">
                                            <input type="email" value="<?php echo $email; ?>" tabindex="40" autofocus="" name="email_login" id="email_login" class="form-control input-sm" placeholder="Email Address*">
                                            <div id="error2" style="display:block;">
                                                <?php
                                                if ($this->session->flashdata('erroremail')) {
                                                    echo $this->session->flashdata('erroremail');
                                                }
                                                ?>
                                            </div>
                                            <div id="errorlogin"></div> 
                                        </div>
                                        <div class="form-group pt10">
                                            <input type="password" tabindex="41" name="password_login" id="password_login" class="form-control input-sm" placeholder="Password*">
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
                                            <button class="btn1" tabindex="42" onclick="login()">Login</button>
                                        </p>

                                        <p class=" text-center">
                                            <a href="javascript:void(0)" tabindex="43" data-toggle="modal" onclick="forgot_profile();" title="Forgot Password" id="myBtn">Forgot Password ?</a>
                                        </p>

                                        <p class="pt15 text-center">
                                            Don't have an account? <a class="db-479" href="javascript:void(0);" tabindex="44" data-toggle="modal" title="Create an account" onclick="register_profile();">Create an account</a>
                                        </p>
                                    </form>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade register-model login" id="register_profile" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content inner-form1">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
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
                                        <input type="hidden" name="password_login_postid" id="password_login_postid" class="form-control input-sm post_id_login">
                                    </div>
                                    <div class="form-group dob">
                                        <label class="d_o_b"> Date Of Birth :</label>
                                        <span> <select tabindex="105" class="day1" name="selday" id="selday">
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
                                            <select tabindex="106" class="month1" name="selmonth" id="selmonth">
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
                                            <select tabindex="107" class="year1" name="selyear" id="selyear">
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
        <!-- Login -->

        <!-- register -->


        <!-- register -->
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

        <script>
            var user_slug = '<?php echo $this->session->userdata('aileenuser_slug'); ?>';
            var get_csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
            var csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
            var base_url = '<?php echo base_url(); ?>';
            var postslug = '<?php echo $this->uri->segment(3); ?>';
            var jobdata = <?php echo json_encode($jobtitle); ?>;


        </script>
        
        <?php
        if (IS_REC_JS_MINIFY == '0') {
            ?>
            <script src="<?php echo base_url('assets/js/jquery.date-dropdowns.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
            <!--<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/add_post_login.js?ver=' . time()); ?>"></script>-->
            <?php
        } else {
            ?>
            <script src="<?php echo base_url('assets/js_min/jquery.date-dropdowns.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()) ?>"></script>
            <!--<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/recruiter/add_post_login.js?ver=' . time()); ?>"></script>-->
        <?php } ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/add_post_login.js?ver=' . time()); ?>"></script>
    </body>
</html>