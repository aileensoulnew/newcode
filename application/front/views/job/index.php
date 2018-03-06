<!DOCTYPE html>
<html>
    <head>
        <!-- start head -->
        <?php echo $head; ?>
        <title><?php echo $title; ?></title>
        <!-- Calender Css Start-->
        <!-- Calender Css End-->

        <?php
        if (IS_JOB_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver=' . time()); ?>">
        <?php } else { ?>

            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/job.css?ver=' . time()); ?>">
        <?php } ?>
    </head>
    <!-- END HEAD -->
    <!-- start header -->
    <?php
    echo $header;
    echo $job_header2_border;
    ?>
    <!-- END HEADER -->
    <div class="js">
        <body class="page-container-bg-solid page-boxed botton_footer">
            <section>
                <div class="user-midd-section " id="paddingtop_fixed_job">
                    <div class="common-form1 ">
                        <div class="col-md-3 col-sm-4"></div>

                        <div class="col-md-6 col-sm-12">
                            <h3>You are updating your Job Profile.</h3>
                        </div>

                    </div>

                    <div class="container">
                        <div class="row row4">

                            <!-- Job leftbar start-->
                            <?php echo $job_left; ?>
                            <!-- Job leftbar End-->

                            <!-- middle section start -->
                            <div class="col-lg-6 col-md-6 col-sm-8">
                                <div>
                                    <?php
                                    if ($this->session->flashdata('error')) {
                                        echo '<div class="alert alert-success">' . $this->session->flashdata('error') . '</div>';
                                    }
                                    if ($this->session->flashdata('success')) {
                                        echo '<div class="alert alert-success">' . $this->session->flashdata('success') . '</div>';
                                    }
                                    ?>
                                </div>
                                <div class="clearfix">
                                    <div class="common-form common-form_border">
                                        <h3>Basic Information</h3>
                                        <?php echo form_open(base_url('job/job_basicinfo_insert'), array('id' => 'jobseeker_regform', 'name' => 'jobseeker_regform', 'class' => 'clearfix')); ?>

                                        <fieldset <?php if ($fname) { ?> class="error-msg" <?php } ?>>
                                            <label>First Name :<span class="red">*</span></label>
                                            <input type="text" tabindex="1" autofocus name="fname" id="fname" placeholder="Enter First name" style="text-transform: capitalize;" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value" value="<?php
                                            if ($fname1) {
                                                echo $fname1;
                                            } else {
                                                echo $job[0]['first_name'];
                                            }
                                            ?>" maxlength="35"/> <span id="fname-error"> </span>
                                                   <?php echo form_error('fname'); ?>
                                        </fieldset>
                                        <fieldset <?php if ($lname) { ?> class="error-msg" <?php } ?>>  
                                            <label>Last Name :<span class="red">*</span> </label>
                                            <input type="text" name="lname" tabindex="2"  id="lname" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value" placeholder="Enter Last name" style="text-transform: capitalize;" value="<?php
                                            if ($lname1) {
                                                echo $lname1;
                                            } else {
                                                echo $job[0]['last_name'];
                                            }
                                            ?>" maxlength="35"/> <span id="lname-error"> </span>
                                                   <?php echo form_error('lname'); ?>
                                        </fieldset>
                                        <fieldset class="fw">
                                            <fieldset style="padding-left: 0px;" class="vali_er" <?php if ($email) { ?> class="error-msg" <?php } ?>>
                                                <label>Email Address :<span class="red">*</span> </label>
                                                <input type="email" name="email" id="email" tabindex="3" placeholder="Enter Email Address" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value" value="<?php
                                                if ($email1) {
                                                    echo $email1;
                                                } else {
                                                    echo $job[0]['user_email'];
                                                }
                                                ?>" maxlength="255"/>
                                                <span class="email_note"><b>Note:-</b> Related notification email will be send on provided email address kindly use regular  email address.<div></div></span>
                                                <?php echo form_error('email'); ?>
                                            </fieldset>
                                            <fieldset style="padding-right:0px;" <?php if ($phnno) { ?> class="error-msg" <?php } ?>>
                                                <label>Phone Number :<span class="optional">(optional)</span></label>
                                                <input type="text" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value" name="phnno" id="phnno" tabindex="4" placeholder="Enter Phone Number" value="<?php
                                                if ($phnno1) {
                                                    echo $phnno1;
                                                }
                                                ?>" maxlength="15" tabindex="4"/> <span id="phnno-error"> </span>

                                            </fieldset>
                                        </fieldset>
                                        <fieldset <?php if ($dob) { ?> class="error-msg" <?php } ?>>
                                            <label>Date of Birth:<span class="red">*</span></label>
                                            <input type="text" id="datepicker" tabindex="5" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value" >
                                            <?php echo form_error('dob'); ?>
                                        </fieldset>
                                        <fieldset class="gender-custom" <?php if ($gender) { ?> class="error-msg" <?php } ?>>
                                            <label>Gender:<span class="red">*</span></label>
                                            <input type="radio" name="gender" value="male" id="gender" tabindex="6" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value" <?php
                                            if ($gender1) {
                                                if ($gender1 == 'male') {
                                                    echo 'checked';
                                                }
                                            } else {
                                                if ($job['user_gender'] == 'M') {
                                                    echo 'checked';
                                                }
                                            }
                                            ?>><span class="radio_check_text pl5">Male</span>
                                            <input type="radio" name="gender" value="female" id="gender" tabindex="7" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value" <?php
                                            if ($gender1) {
                                                if ($gender1 == 'female') {
                                                    echo 'checked';
                                                }
                                            } else {
                                                if ($job['user_gender'] == 'F') {
                                                    echo 'checked';
                                                }
                                            }
                                            ?> ><span class="radio_check_text pl5">Female</span>
                                            <span id="gender-error"> </span>
                                            <?php echo form_error('gender'); ?>
                                        </fieldset>
                                        <fieldset id="erroe_nn" <?php if ($language) { ?> class="error-msg" <?php } ?>>
                                            <label>Languages Known:<span class="red">*</span></label> 
                                            <input id="lan" name="language"  value="<?php
                                            if ($language2) {
                                                echo $language2 . ',';
                                            }
                                            ?>" placeholder="Select a Language" style="width: 100%"  tabindex="8" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value">
<?php echo form_error('language'); ?>
                                        </fieldset>
                                        <fieldset id="erroe_nn" <?php if ($city) { ?> class="error-msg" <?php } ?>>
                                            <label>Current City:<span class="red">*</span></label> 
                                            <input id="city" name="city" value="<?php
                                                   if ($city_title) {
                                                       echo $city_title;
                                                   }
                                                   ?>" placeholder="Select City" style="width: 100%"  tabindex="9" maxlength="255" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value">
                                            <?php echo form_error('city'); ?>
                                        </fieldset>
                                        <fieldset <?php if ($pincode_error) { ?> class="error-msg" <?php } ?>>
                                            <label>Pincode :<span class="optional">(optional)</span></label>
                                            <input type="text" tabindex="10" name="pincode" id="pincode" placeholder="Enter Pincode" value="<?php
                                                   if ($pincode1) {
                                                       echo $pincode1;
                                                   }
                                                   ?>" maxlength="15" onfocus="var temp_value = this.value;
        this.value = ''; this.value = temp_value"/> <span id="pincode-error"> </span>
                                                <?php echo form_error('pincode'); ?>
                                        </fieldset>
                                        <fieldset class="full-width">
                                            <label>Postal Address:<span class="optional">(optional)</span></label>
                                            <textarea name ="address" tabindex="11" id="address" rows="4" cols="50" placeholder="Enter Address" maxlength="4000" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value" style="resize: none;" onpaste="OnPaste_StripFormatting(this, event);"><?php
                                            if ($address1) {
                                                echo $address1;
                                            }
                                            ?></textarea>
<?php echo form_error('address'); ?>
                                        </fieldset>

                                        <fieldset class="hs-submit full-width">
                                          <!--  <input title="Save" type="submit"  id="next" name="next" value="Save" tabindex="12"> -->

                                            <button id="next" name="next" class="cus_btn_sub" onclick="return profile_reg();" tabindex="12">Save<span class="ajax_load pl10" id="profilereg_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>

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
            <!-- END CONTAINER -->
            <!-- <footer>    -->
            <?php echo $login_footer ?>     
            <?php echo $footer; ?>
            <!-- </footer> -->

<?php
if (IS_JOB_JS_MINIFY == '0') {
    ?>

                <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.js?ver=' . time()); ?>"></script>
                <!-- js for modal start-->
                <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
                <!-- js for modal end-->

                <script src="<?php echo base_url('assets/js/jquery.date-dropdowns.js?ver=' . time()); ?>"></script>

<?php } else { ?>


                <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.js?ver=' . time()); ?>"></script>
                <!-- js for modal start-->
                <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
                <!-- js for modal end-->

                <script src="<?php echo base_url('assets/js_min/jquery.date-dropdowns.js?ver=' . time()); ?>"></script>

<?php } ?>
            <script>
                                                var base_url = '<?php echo base_url(); ?>';
                                                var date_picker = '<?php echo date('Y-m-d', strtotime($job['user_dob'])); ?>';
                                                var date_picker_edit = '<?php echo date('Y-m-d', strtotime($dob1)); ?>';

            </script>

<?php
if (IS_JOB_JS_MINIFY == '0') {
    ?>

                <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/index.js?ver=' . time()); ?>"></script>
                <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/search_common.js?ver=' . time()); ?>"></script>

            <?php } else { ?>

                <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/job/index.js?ver=' . time()); ?>"></script>
                <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/job/search_common.js?ver=' . time()); ?>"></script>

<?php } ?>
        </body>
</html>