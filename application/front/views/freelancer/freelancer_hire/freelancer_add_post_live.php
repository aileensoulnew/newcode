<!DOCTYPE html>
<html>
    <head>
        <?php echo $head; ?>
        <title><?php echo $title; ?></title>

        <?php if (IS_HIRE_CSS_MINIFY == '0') { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css'); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/freelancer-hire.css?ver=' . time()); ?>">

        <?php } else { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css'); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/freelancer-hire.css?ver=' . time()); ?>">

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
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css'); ?>">
    <body class="page-container-bg-solid page-boxed no-login freeh3 cust-add-live botton_footer ">
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
        <section>
            <!-- MIDDLE SECTION START -->
            <div class="user-midd-section" id="paddingtop_fixed">
                <div class="container">
                    <div class="row">
                        <h3 class="col-chang cus-chang text-center">Please Post your requirement of the work that you need, we will recommend the freelancers accordingly.</h3>
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

                                    <form id="postinfo" name="postinfo" class="clearfix">
                                        <?php
                                        $post_name = form_error('post_name');
                                        $skills = form_error('skills');
                                        $post_desc = form_error('post_desc');
                                        ?>
                                        <div class="custom-add-box">
                                            <h3 class="freelancer_editpost_title"><?php echo $this->lang->line("project_description"); ?></h3>
                                            <div class="p15 fw">
                                                <fieldset class="full-width" <?php if ($post_name) { ?> class="error-msg" <?php } ?>>
                                                    <label ><?php echo $this->lang->line("project_title"); ?>:<span style="color:red">*</span></label>                 
                                                    <input name="post_name" type="text" maxlength="100" id="post_name" autofocus tabindex="1" placeholder="Enter project name"/>
                                                    <span id="fullname-error"></span>
                                                    <?php echo form_error('post_name'); ?>
                                                </fieldset>
                                                <fieldset class="full-width">
                                                    <label><?php echo $this->lang->line("project_description"); ?> :<span style="color:red">*</span></label>
                                                    <textarea class="add-post-textarea" name="post_desc" id="post_desc" placeholder="Enter description" tabindex="2" onpaste="OnPaste_StripFormatting(this, event);"></textarea>
                                                    <?php echo form_error('post_desc'); ?>
                                                </fieldset>
                                                <fieldset class="full-width" <?php if ($skills) { ?> class="error-msg" <?php } ?>>
                                                    <label><?php echo $this->lang->line("skill_of_requirement"); ?>:<span style="color:red">*</span></label>
                                                    <input id="skills2" name="skills" tabindex="3" size="90" placeholder="Enter skills">
                                                    <span id="fullname-error"></span>
                                                    <?php echo form_error('skills'); ?>
                                                </fieldset>
                                                <fieldset class="full-width" <?php if ($fields_req) { ?> class="error-msg" <?php } ?>>
                                                    <label><?php echo $this->lang->line("field_of_requirement"); ?>:<span style="color:red">*</span></label>
                                                    <select tabindex="4" name="fields_req" id="fields_req" class="field_other">
                                                        <option  value="" selected option disabled><?php echo $this->lang->line("select_filed"); ?></option>
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
                                                    <?php echo form_error('fields_req'); ?>
                                                </fieldset>

                                                <fieldset class="full-width two-select-box fullwidth_experience" <?php if ($month) { ?> class="error-msg" <?php } ?> class="two-select-box"> 
                                                    <label><?php echo $this->lang->line("required_experiance"); ?>:<span class="optional">(optional)</span></label>
                                                    <select tabindex="5" name="year" id="year">
                                                        <option value="" selected option disabled><?php echo $this->lang->line("year"); ?></option>
                                                        <option value="0">0 Year</option>
                                                        <option value="1">1 Year</option>
                                                        <option value="2">2 Year</option>
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
                                                    <?php echo form_error('year'); ?>

                                                    <select class="margin-month " tabindex="6" name="month" id="month">
                                                        <option value="" selected option disabled><?php echo $this->lang->line("month"); ?></option>
                                                        <option value="0">0 Month</option>
                                                        <option value="1">1 Month</option>
                                                        <option value="2">2 Month</option>
                                                        <option value="3">3 Month</option>
                                                        <option value="4">4 Month</option>
                                                        <option value="5">5 Month</option>
                                                        <option value="6">6 Month</option>
                                                    </select>
                                                    <?php echo form_error('month'); ?>
                                                </fieldset>
                                                <fieldset class="col-md-6 pl10" <?php if ($est_time) { ?> class="error-msg" <?php } ?>>
                                                    <label><?php echo $this->lang->line("time_of_project"); ?>:<span class="optional">(optional)</span></label>
                                                    <input tabindex="7" name="est_time" type="text" id="est_time" placeholder="Enter estimated time in month/year" /><span id="fullname-error"></span>
                                                    <?php echo form_error('est_time'); ?>
                                                </fieldset>           
                                                <fieldset <?php if ($last_date) { ?> class="error-msg" <?php } ?>>
                                                    <label><?php echo $this->lang->line("last_date_apply"); ?>:<span style="color:red">*</span></label>
                                                    <input type="hidden" id="example2">
                                                    <?php echo form_error('last_date'); ?> 
                                                </fieldset>


                                            </div>
                                        </div>
                                        <div class="custom-add-box">
                                            <h3 class="freelancer_editpost_title"><?php echo $this->lang->line("payment"); ?></h3>
                                            <div class="p15 fw">
                                                <fieldset class="col-md-12  pl10 work_type_custom">
                                                    <label class=""><?php echo $this->lang->line("work_type"); ?>:<span style="color:red">*</span></label>
                                                    <div class="cus_work">
                                                        <input type="radio" tabindex="11" class="worktype_minheight" name="rating"  value="0"> Hourly
                                                        <input type="radio" tabindex="12"  name="rating" value="1"> Fixed
                                                        <input type="radio" tabindex="13" class="worktype"  name="rating" value="2"> Not Fixed
                                                    </div>
                                                    <?php echo form_error('rating'); ?>
                                                </fieldset>

                                                <fieldset  class="half-width pl10" <?php if ($rate) { ?> class="error-msg" <?php } ?> >
                                                    <label  class="control-label"><?php echo $this->lang->line("rate"); ?>:</label>
                                                    <input tabindex="14" name="rate" type="text" id="rate" placeholder="Enter your rate"/>
                                                    <span id="fullname-error"></span>
                                                    <?php echo form_error('rate'); ?>
                                                </fieldset>
                                                <fieldset class="half-width" <?php if ($csurrency) { ?> class="error-msg" <?php } ?> class="two-select-box"> 
                                                    <label><?php echo $this->lang->line("currency"); ?>:</label>
                                                    <select tabindex="15" name="currency" id="currency">
                                                        <option  value="" selected option disabled><?php echo $this->lang->line("select_currency"); ?></option>
                                                        <?php foreach ($currency as $cur) { ?>
                                                            <option value="<?php echo $cur['currency_id']; ?>"><?php echo $cur['currency_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <?php echo form_error('currency'); ?>
                                                </fieldset>
                                                <fieldset class="hs-submit full-width">
                                                    <input type="hidden" value="<?php echo $pages; ?>" name="page" id="page">
                                                    <input type="submit" title="Post" id="submit"  class="add_post_btns" tabindex="16" name="submit" value="Post">

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
        <div class="modal fade message-box biderror custom-message" id="bidmodal2" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content message">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>
                    <h2>Add Field</h2>         
                    <input type="text" name="other_field" id="other_field" onkeypress="return remove_validation()">
                    <div class="fw"><a title="OK" id="field" class="btn">OK</a></div>
                </div>
            </div>
        </div>
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
        <div class="modal fade register-model login" id="register_profile" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content inner-form1">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <div class="clearfix">
                            <div class="">
                                <div class="title"><h1 class="tlh1">Sign up First and Register in Employer Profile</h1></div>
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
                                            <a tabindex="109" title="Terms and Condition" href="<?php echo base_url('terms-and-condition'); ?>">Terms and Condition</a> and <a tabindex="110" title="Privacy policy" href="<?php echo base_url('privacy-policy'); ?>">Privacy policy</a>.
                                        </p>
                                        <p>
                                            <button tabindex="111" class="btn1">Create an account</button>
                                                                                        <!--<p class="next">Next</p>-->
                                        </p>
                                        <div class="sign_in pt10">
                                            <p>
                                                Already have an account ? <a title="Log In" tabindex="112" onClick="login_profile();" href="javascript:void(0);"> Log In </a>
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
        <!-- Login -->

        <!-- register -->


        <!-- register -->
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


        <?php if (IS_HIRE_JS_MINIFY == '0') { ?>

            <script src="<?php echo base_url('assets/js/jquery.date-dropdowns.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
        <?php } else { ?>
            <script src="<?php echo base_url('assets/js_min/jquery.date-dropdowns.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()) ?>"></script>
        <?php } ?>

        <script>
                                                    var user_slug = '<?php echo $this->session->userdata('aileenuser_slug'); ?>';
                                                    var base_url = '<?php echo base_url(); ?>';
                                                    var postslug = '<?php echo $this->uri->segment(3); ?>';



        </script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/add_post_live.js?ver=' . time()); ?>"></script>
        <?php if (IS_HIRE_JS_MINIFY == '0') { ?>

                   <!--<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/add_post_live.js?ver=' . time()); ?>"></script>-->

                    <!--<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/add_post_live.js?ver=' . time()); ?>"></script>-->

        <?php } else { ?>

                     <!--<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-hire/add_post_live.js?ver=' . time()); ?>"></script>-->

                    <!--<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-hire/add_post_live.js?ver=' . time()); ?>"></script>-->

        <?php } ?>


    </body>
</html>