<!DOCTYPE html>
<html>
    <head><title><?php echo $title; ?></title>
        <?php echo $head; ?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <?php
        if (IS_APPLY_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/freelancer-apply.css?ver=' . time()); ?>">
            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/freelancer-apply.css?ver=' . time()); ?>">
        <?php } ?>



  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css'); ?>">
    </head>
    <body class="no-login cus-left-project">
        <?php
        $userid = $this->session->userdata('aileenuser');
        if (!$userid) {
            ?>
            <header>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-3 left-header text-center fw-479">
                          <div class="logo">  <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png?ver=' . time()) ?>" alt="logo"></a></div>
                        </div>
                        <div class="col-md-8 col-sm-9 right-header fw-479 text-center">
                            <div class="btn-right pull-right">
                                <a title="Login" href="javascript:void(0);" onclick="login_profile();" class="btn2">Login</a>
                                <a title="Create an account" href="javascript:void(0);" onclick="register_profile();" class="btn3">Create an account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <?php
        } else {
            echo $header;
        }
        ?>
        <section>
            <div class="user-midd-section" id="paddingtop_fixed">
                <div class="container">
                    <div class="">
                        <!--COVER PIC START-->
                        <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt cust-block">
                            <div class="full-box-module">   
                                <div class="profile-boxProfileCard  module">
                                    <div class="profile-boxProfileCard-cover" style="padding-left: 0px;"> 
                                        <div class="cust-div-h3">
                                            <h3 style="color: #5c5c5c;text-align: center;font-size: 24px;">Projects by Fields</h3>
                                        </div>
                                        <ul style="list-style-type: none;text-align: justify;">
                                            <li>
                                                <label for="City" class="lbpos fw">

                                                    <a title="All Projects" href="<?php echo base_url("projects"); ?>" >All Projects</a>
                                                </label>
                                            </li>
                                            <li>
                                                <label for="City" class="lbpos fw">
                                                    <a title="Accounting & Consulting Projects" href="<?php echo base_url("Accounting-Consulting-project"); ?>" <?php if ($keyword == 'Accounting-Consulting') { ?> class="job_active" <?php } ?>>Accounting & Consulting Projects</a>
                                                </label>
                                            </li>
                                            <li>
                                                <label for="City" class="lbpos fw">
                                                    <a title="Admin Support Projects" href="<?php echo base_url("Admin-Support-project"); ?>" <?php if ($keyword == 'Admin-Support') { ?> class="job_active" <?php } ?>>Admin Support Projects</a>
                                                </label>
                                            </li>
                                            <li>
                                                <label for="City" class="lbpos fw"> 
                                                    <a title="Customer Service Projects" href="<?php echo base_url("Customer-Service-project"); ?>" <?php if ($keyword == 'Customer-Service') { ?> class="job_active" <?php } ?>>Customer Service Projects</a>
                                                </label>
                                            </li>
                                            <li>
                                                <label for="City" class="lbpos fw">
                                                    <a title="Data Science & Analytics Projects" href="<?php echo base_url("Data-Science-Analytics-project"); ?>" <?php if ($keyword == 'Data-Science-Analytics') { ?> class="job_active" <?php } ?>>Data Science & Analytics Projects</a>
                                                </label>
                                            </li>
                                            <li>
                                                <label for="City" class="lbpos fw">
                                                    <a title="Design & Creative  Projects" href="<?php echo base_url("Design-Creative-project"); ?>" <?php if ($keyword == 'Design-Creative') { ?> class="job_active" <?php } ?>>Design & Creative  Projects</a>
                                                </label>
                                            </li>
                                            <li>
                                                <label for="City" class="lbpos fw">
                                                    <a title="Engineering & Architecture Projects" href="<?php echo base_url("Engineering-Architecture-project"); ?>" <?php if ($keyword == 'Engineering-Architecture') { ?> class="job_active" <?php } ?>>Engineering & Architecture Projects</a>
                                                </label>
                                            </li>
                                            <li>
                                                <label for="City" class="lbpos fw">
                                                    <a title="Legal Projects" href="<?php echo base_url("Legal-project"); ?>" <?php if ($keyword == 'Legal') { ?> class="job_active" <?php } ?>>Legal Projects</a>
                                                </label>
                                            </li>
                                            <li>
                                                <label for="City" class="lbpos fw">
                                                    <a title="Sales & Marketing Projects" href="<?php echo base_url("Sales-Marketing-project"); ?>" <?php if ($keyword == 'Sales-Marketing') { ?> class="job_active" <?php } ?>>Sales & Marketing Projects</a>
                                                </label>
                                            </li>
                                            <li>
                                                <label for="City" class="lbpos fw">
                                                    <a title="Translation Projects" href="<?php echo base_url("Translation-project"); ?>" <?php if ($keyword == 'Pune') { ?> class="job_active" <?php } ?>>Translation Projects</a>
                                                </label>
                                            </li>
                                            <li>
                                                <label for="City" class="lbpos fw">
                                                    <a title="Website,Mobile,Software Development,IT & Networking Projects" href="<?php echo base_url("WebsiteMobileSoftware-DevelopmentIT-Networking-project"); ?>" <?php if ($keyword == 'Pune') { ?> class="job_active" <?php } ?>>Website,Mobile,Software Development,IT & Networking Projects</a>
                                                </label>
                                            </li>
                                            <li>
                                                <label for="City" class="lbpos fw">
                                                    <a title="Writing & Content Projects" href="<?php echo base_url("Writing-Content-project"); ?>" <?php if ($keyword == 'Pune') { ?> class="job_active" <?php } ?>>Writing & Content Projects</a>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                            </div> 

                        </div>
                        <!--COVER PIC END-->
                        <div class="custom-right-art mian_middle_post_box animated fadeInUp">
                            <div class="page-title">

                                <h3> <?php
                                    if ($keyword == "" && $keyword1 == "") {
                                        echo "Freelance Projects";
                                    } else {
                                        ?>

                                        <?php
                                        if ($keyword != "" && $keyword1 == "") {
                                            echo ucfirst($keyword) . " Projects";
                                        } elseif ($keyword == "" && $keyword1 != "") {
                                            echo "Projects In ";
                                            echo ucfirst($keyword1);
                                        } else {
                                            echo ucfirst($keyword) . " Projects";
                                            echo " In ";
                                            echo ucfirst($keyword1);
                                        }
                                    }
                                    ?>
                                </h3>
                            </div>
                            <div class="contact-frnd-post">
                            <div class="job-contact-frnd1 fw">


                            </div>
                            <div id="loader" style="display: none;"><p style="text-align:center;"><img  alt="loader" class="loader" src="<?php echo base_url('assets/images/loading.gif'); ?>"/></p></div>
                        </div>
                    </div>
                    </div>
                    <div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig"> 



                    </div>

                </div>
            </div>
        </section>

        <div class="modal fade message-box biderror" id="bidmodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content ">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Model Popup Close -->
        <!-- Login  -->
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
                                            <a title="Forgot Password ?" href="javascript:void(0)" data-toggle="modal" onclick="forgot_profile();" id="myBtn">Forgot Password ?</a>
                                        </p>

                                        <p class="pt15 text-center">
                                            Don't have an account? <a title="Create an account" href="javascript:void(0);" data-toggle="modal" onclick="register_profile();">Create an account</a>
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
        <!-- Login  For Apply Post-->
        <div class="modal fade login" id="login_apply" role="dialog">
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

                                    <form role="form" name="login_form_apply" id="login_form_apply" method="post">

                                        <div class="form-group">
                                            <input type="email" value="<?php echo $email; ?>" name="email_login_apply" id="email_login_apply" autofocus="" class="form-control input-sm email_login" placeholder="Email Address*">
                                            <div id="error2" style="display:block;">
                                                <?php
                                                if ($this->session->flashdata('erroremail')) {
                                                    echo $this->session->flashdata('erroremail');
                                                }
                                                ?>
                                            </div>
                                            <div id="errorlogin_apply"></div> 
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password_login_apply" id="password_login_apply" class="form-control input-sm password_login" placeholder="Password*">
                                            <input type="hidden" name="password_login_postid" id="password_login_postid" class="form-control input-sm post_id_login">

                                            <div id="error1" style="display:block;">
                                                <?php
                                                if ($this->session->flashdata('errorpass')) {
                                                    echo $this->session->flashdata('errorpass');
                                                }
                                                ?>
                                            </div>
                                            <div id="errorpass_apply"></div> 
                                        </div>

                                        <p class="pt-20 ">
                                            <button class="btn1" >Login</button>
                                        </p>

                                        <p class=" text-center">
                                            <a title="Forgot Password ?" href="javascript:void(0)" data-toggle="modal" onclick="forgot_profile();" id="myBtn">Forgot Password ?</a>
                                        </p>

                                        <p class="pt15 text-center">
                                            Don't have an account? <a title="Create an account" class="db-479" href="javascript:void(0);" data-toggle="modal" onclick="register_profile();">Create an account</a>
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
                                        <input class="btn btn-theme btn1" type="submit" name="submit" value="Submit" style="width:105px; margin-top:15px;" /> 
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

        <?php echo $footer; ?>
        <!-- script for skill textbox automatic start (option 2)-->
        <script  type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
        <script  src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>

        <!-- forgot password script end -->
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
        <!-- register -->

        <div class="modal fade register-model login" id="register" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content inner-form1">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
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
                                            <input type="hidden" name="password_login_postid" id="password_login_postid" class="form-control input-sm post_id_login">
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
                                            </select>
                                            </span>
                                        </div>

                                        <p class="form-text" style="margin-bottom: 10px;">
                                            By Clicking on create an account button you agree our
                                            <a tabindex="109" title="Terms and Condition" href="<?php echo base_url('terms-and-condition'); ?>">Terms and Condition</a> and <a tabindex="110" title="Privacy policy" href="<?php echo base_url('privacy-policy'); ?>">Privacy policy</a>.
                                        </p>
                                        <p>
                                            <button tabindex="111" class="btn1">Create an account</button>

                                        </p>
                                        <div class="sign_in pt10">
                                            <p>
                                                Already have an account ? <a title="Log In" tabindex="112" id ="postid" onClick="login_profile_apply(<?php echo $post['post_id']; ?>)" href="javascript:void(0);"> Log In </a>
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
        <!-- register for apply start-->

        <div class="modal fade register-model login" id="register_apply" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <div class="clearfix">
                            <div class=" ">
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
                                            <input type="hidden" name="password_login_postid" id="password_login_postid" class="form-control input-sm post_id_login">
                                        </div>
                                        <div class="form-group dob">
                                            <label class="d_o_b"> Date Of Birth :</label>
                                            <span>
                                            <select tabindex="105" class="day" name="selday" id="selday">
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
                                            <a class="109" title="Terms and Condition" href="<?php echo base_url('terms-and-condition'); ?>">Terms and Condition</a> and <a class="110" title="Privacy policy" href="<?php echo base_url('privacy-policy'); ?>">Privacy policy</a>.
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
        <!-- register for apply end -->

        <script>
            $(document).on('click', '[data-toggle*=modal]', function () {
                $('[role*=dialog]').each(function () {
                    switch ($(this).css('display')) {
                        case('block'):
                        {
                            $('#' + $(this).attr('id')).modal('hide');
                            break;
                        }
                    }
                });
            });
        </script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var skill = '<?php echo $keyword; ?>';
            var place = '<?php echo $keyword1; ?>';
            var csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
            var csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';

        </script>
        <!-- script for skill textbox automatic end -->
        <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/apply_search.js?ver=' . time()); ?>"></script>
        <?php
        if (IS_APPLY_JS_MINIFY == '0') {
            ?>
            <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_apply_search_result.js?ver=' . time()); ?>"></script>
            <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_apply_common.js?ver=' . time()); ?>"></script>
            <!--<script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/apply_search.js?ver=' . time()); ?>"></script>-->
            <?php
        } else {
            ?>
            <script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-apply/freelancer_apply_search_result.js?ver=' . time()); ?>"></script>
            <script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-apply/freelancer_apply_common.js?ver=' . time()); ?>"></script>
            <!--<script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-apply/apply_search.js?ver=' . time()); ?>"></script>-->
        <?php } ?>


    </body>
</html>



