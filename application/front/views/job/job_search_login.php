<!DOCTYPE html>
<html>
    <head>
        <!-- start head -->
        <?php echo $head; ?>
        <!-- END HEAD -->

        <title><?php echo $title; ?></title>
        <?php
        if (IS_JOB_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver=' . time()); ?>">
        <?php } else { ?>

            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/job.css?ver=' . time()); ?>">
        <?php } ?>
    </head>
    <!-- END HEAD -->

    <body class="page-container-bg-solid page-boxed no-login botton_footer">
        <?php
        $userid = $this->session->userdata('aileenuser');
        if (!$userid) {
            ?>
            <header>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-3 col-xs-3 fw-479 left-header">
                            <div class="logo"> <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png?ver=' . time()) ?>" alt="logo"></a></div>
                        </div>
                        <div class="col-md-8 col-sm-9 col-xs-9 fw-479 right-header">
                            <div class="btn-right pull-right">
                                <a href="javascript:void(0);" onclick="login_profile();" class="btn2">Login</a>
                                <a href="javascript:void(0);" onclick="register_profile();" class="btn3">Creat an account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        <?php }else{
            echo $header;
            } ?>
       
        <section>
            <div class="user-midd-section" id="paddingtop_fixed">
                <div class="container">
                    <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt cust-block">
                        <div class="">
                            <div class="full-box-module">   
                                <div class="">
                                    <div class=""> 
                                        <div class="cust-div-h3">
                                            <h3 style="color: #5c5c5c;text-align: center;font-size: 24px;">Job by Location</h3>
                                        </div>
                                        <ul class="jobs-loca-cus" style="list-style-type: none;padding-left: 10px;">
                                            <li>
                                                <label for="City" class="lbpos fw">
                                                    <a href="<?php echo base_url("jobs"); ?>" >All Jobs</a>
                                                </label>
                                            </li>
                                            <li>
                                                <label for="City" class="lbpos fw">
                                                    <a href="<?php echo base_url("jobs-in-Ahmedabad"); ?>" <?php if ($keyword1 == 'Ahmedabad') { ?> class="job_active" <?php } ?>>Ahmedabad Jobs</a>
                                                </label>
                                            </li>
                                            <li>
                                                <label for="City" class="lbpos fw">
                                                    <a href="<?php echo base_url("jobs-in-Bengaluru"); ?>" <?php if ($keyword1 == 'Bengaluru') { ?> class="job_active" <?php } ?>>Bengaluru Jobs</a>
                                                </label>
                                            </li>
                                            <li>
                                                <label for="City" class="lbpos fw"> 
                                                    <a href="<?php echo base_url("jobs-in-Chennai"); ?>" <?php if ($keyword1 == 'Chennai') { ?> class="job_active" <?php } ?>>Chennai Jobs</a>
                                                </label>
                                            </li>
                                            <li>
                                                <label for="City" class="lbpos fw">
                                                    <a href="<?php echo base_url("jobs-in-Delhi"); ?>" <?php if ($keyword1 == 'Delhi') { ?> class="job_active" <?php } ?>>Delhi Jobs</a>
                                                </label>
                                            </li>
                                            <li>
                                                <label for="City" class="lbpos fw">
                                                    <a href="<?php echo base_url("jobs-in-Hyderabad"); ?>" <?php if ($keyword1 == 'Hyderabad') { ?> class="job_active" <?php } ?>>Hyderabad Jobs</a>
                                                </label>
                                            </li>
                                            <li>
                                                <label for="City" class="lbpos fw">
                                                    <a href="<?php echo base_url("jobs-in-Mumbai"); ?>" <?php if ($keyword1 == 'Mumbai') { ?> class="job_active" <?php } ?>>Mumbai Jobs</a>
                                                </label>
                                            </li>
                                            <li>
                                                <label for="City" class="lbpos fw">
                                                    <a href="<?php echo base_url("jobs-in-Pune"); ?>" <?php if ($keyword1 == 'Pune') { ?> class="job_active" <?php } ?>>Pune Jobs</a>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>                             




                            <?php echo $left_footer; ?>

                        </div>

                    </div>




                    <div class="custom-right-art mian_middle_post_box animated fadeInUp">
                        <!--<div class="common-form">-->

                            <div class="page-title">
                                <h3>

                                    <?php
                                    if ($keyword == "" && $keyword1 == "") {
                                        echo 'All Jobs';
                                    } elseif ($keyword != "" && $keyword1 == "") {
                                        echo $keyword;
                                        echo " Jobs";
                                    } elseif ($keyword == "" && $keyword1 != "") {
                                        echo " Jobs in ";
                                        echo $keyword1;
                                    } else {
                                        echo $keyword;
                                        echo " Jobs in ";
                                        echo $keyword1;
                                    }
                                    ?>
                                </h3>

                                <div class="contact-frnd-post">
                                    <div class="job-contact-frnd ">
                                        <!--.........AJAX DATA......-->           
                                    </div>
                                    <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" alt="loaderimage"/></div>
                                </div>

                            </div>
                        <!--</div>-->
                    </div>
                    <div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig"> 

                        <div class="all-profile-box">
                            <div class="all-pro-head">
                                <h4>Profiles<a href="<?php echo base_url('profiles/') . $this->session->userdata('aileenuser_slug'); ?>" class="pull-right">All</a></h4>
                            </div>
                            <ul class="all-pr-list">
                                <li>
                                    <a href="<?php echo base_url('job'); ?>">
                                        <div class="all-pr-img" alt="job">
                                            <img src="<?php echo base_url('assets/img/i1.jpg'); ?>" alt="job">
                                        </div>
                                        <span>Job Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('recruiter'); ?>" >
                                        <div class="all-pr-img">
                                            <img src="<?php echo base_url('assets/img/i2.jpg'); ?>" alt="recruiter">
                                        </div>
                                        <span>Recruiter Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('freelance'); ?>" >
                                        <div class="all-pr-img">
                                            <img src="<?php echo base_url('assets/img/i3.jpg'); ?>"  alt="freelancer">
                                        </div>
                                        <span>Freelance Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('business-profile'); ?>" >
                                        <div class="all-pr-img">
                                            <img src="<?php echo base_url('assets/img/i4.jpg'); ?>" alt="business profile">
                                        </div>
                                        <span>Business Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('artist'); ?>" >
                                        <div class="all-pr-img">
                                            <img src="<?php echo base_url('assets/img/i5.jpg'); ?>" alt="artist">
                                        </div>
                                        <span>Artistic Profile</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>

                </div>

            </div>
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


<?php echo $footer; ?>

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
                                        <input type="email" value="<?php echo $email; ?>" name="email_login" autofocus="" id="email_login" class="form-control input-sm" placeholder="Email Address*">
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
                                    <h1 class="ttc">Welcome To Aileensoul</h1>
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

    <!-- register -->

    <div class="modal fade register-model login" id="register" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content inner-form1">
                <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                <div class="modal-body">
                    <div class="clearfix">
                        <div class="">
                            <div class="title"><h1 class="tlh1">Sign up First and Register in Job Profile</h1></div>
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

                                            </select></span>

                                    </div>
                                    <div class="dateerror" style="color:#f00; display: block;"></div>

                                    <div class="form-group gender-custom">
                                        <span><select tabindex="108" class="gender"  onchange="changeMe(this)" name="selgen" id="selgen">
                                                <option value="" disabled selected value>Gender</option>
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                            </select></span>
                                    </div>

                                    <p class="form-text">
                                        By Clicking on create an account button you agree our
                                        <a tabindex="109" href="<?php echo base_url('terms-and-condition'); ?>">Terms and Condition</a> and <a tabindex="110" href="<?php echo base_url('privacy-policy'); ?>">Privacy policy</a>.
                                    </p>
                                    <p>
                                        <button tabindex="111" class="btn1">Create an account</button>

                                    </p>
                                    <div class="sign_in pt10">
                                        <p>
                                            Already have an account ? <a tabindex="112" id ="postid" onClick="login_profile_apply()" href="javascript:void(0);"> Log In </a>
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
                        <div class="">
                            <div class="title">
                                <h1 class="ttc tlh2">Welcome To Aileensoul</h1>
                            </div>
                            <div class="main-form">
                                <form role="form" name="register_form" id="register_form" method="post">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <input tabindex="101" type="text" name="first_name" id="first_name" class="form-control input-sm" autofocus="" placeholder="First Name">
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
                                        <select tabindex="105" class="day" name="selday" id="selday">
                                            <option value="" disabled selected value>Day</option>
                                            <?php
                                            for ($i = 1; $i <= 31; $i++) {
                                                ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
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

                                        </select>
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

                                    </div>
                                    <div class="dateerror" style="color:#f00; display: block;"></div>

                                    <div class="form-group gender-custom">
                                        <select tabindex="108" class="gender"  onchange="changeMe(this)" name="selgen" id="selgen">
                                            <option value="" disabled selected value>Gender</option>
                                            <option value="M">Male</option>
                                            <option value="F">Female</option>
                                        </select>
                                    </div>

                                    <p class="form-text">
                                        By Clicking on create an account button you agree our<br class="mob-none">
                                        <a tabindex="109" href="<?php echo base_url('terms-and-condition'); ?>">Terms and Condition</a> and <a tabindex="110" href="<?php echo base_url('privacy-policy'); ?>">Privacy policy</a>.
                                    </p>
                                    <p>
                                        <button tabindex="111" class="btn1">Create an account</button>

                                    </p>
                                    <div class="sign_in pt10">
                                        <p>
                                            Already have an account ? <a tabindex="112" onClick="login_profile_apply(<?php echo $post['post_id']; ?>)" href="javascript:void(0);"> Log In </a>
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

    <!-- script for skill textbox automatic start-->

    <?php
    if (IS_JOB_JS_MINIFY == '0') {
        ?>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
<?php } else { ?>


        <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()) ?>"></script>

<?php } ?>
    <script>
                                                var base_url = '<?php echo base_url(); ?>';

                                                var skill = '<?php echo $keyword; ?>';
                                                var skill = skill.replace('-', ' ');

                                                var place = '<?php echo $keyword1; ?>';
                                                var place = place.replace('-', ' ');

                                                var csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
                                                var csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
    </script>

    <?php
    if (IS_JOB_JS_MINIFY == '0') {
        ?>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/job_search_login.js?ver=' . time()); ?>"></script>

    <?php } else { ?>
        <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/job/job_search_login.js?ver=' . time()); ?>"></script>
<?php } ?>
</body>
</html>