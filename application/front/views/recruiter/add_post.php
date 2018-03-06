<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?> 
        <?php
        if (IS_REC_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css'); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.fancybox.css'); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/recruiter.css'); ?>">
            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css'); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/jquery.fancybox.css'); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/recruiter.css'); ?>">
        <?php } ?>
    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push botton_footer freeh3">
        <?php echo $header; ?>
        <?php if ($recdata['re_step'] == 3) { ?>
            <?php echo $recruiter_header2_border; ?>
        <?php } ?>
        <div id="preloader"></div>
        <!-- START CONTAINER -->
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


                                    <?php echo form_open(base_url('recruiter/add_post_store'), array('id' => 'artpost', 'name' => 'artpost', 'class' => 'clearfix form_addedit', 'onsubmit' => "return imgval()")); ?>

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
                                                <input type="search" tabindex="3" autofocus id="post_name" name="post_name" value="" placeholder="Enter Job Title" style="text-transform: capitalize;" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value" maxlength="255">
                                                <span id="fullname-error"></span>
                                                <?php echo form_error('post_name'); ?>
                                            </fieldset>
                                            <fieldset class="form-group full-width">
                                                <label class="control-label">Job Description:<span style="color:red">*</span></label>
                                                <textarea name="post_desc" id="post_desc" tabindex="4" rows="8" cols="50"  placeholder="Enter Job Description" style="resize: none;"></textarea>

                                                <?php echo form_error('post_desc'); ?>
                                            </fieldset>
                                            <fieldset class="full-width" <?php if ($skills) { ?> class="error-msg" <?php } ?>>
                                                <label class="control-label">Skills: <span style="color:red">*</span></label>

                                                <input id="skills2" name="skills" tabindex="5" size="90" placeholder="Enter Skills">

                                                <?php echo form_error('skills'); ?>
                                            </fieldset>
                                            <fieldset class="full-width" <?php if ($industry) { ?> class="error-msg" <?php } ?> class="two-select-box"> 
                                                <label>Industry:<span style="color:red">*</span></label>
                                                <select name="industry" id="industry" tabindex="6" class="industry1">

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



                                                <textarea name="interview" id="interview" rows="4" tabindex="7" cols="50"  placeholder="Enter Interview Process" style="resize: none;"></textarea>

                                               
                                            </fieldset>
                                            <fieldset <?php if ($month) { ?> class="error-msg" <?php } ?> class="two-select-box1">

                                                <label style="cursor:pointer;" class="control-label">Minimum Experience:<span style="color:red">*</span></label>


                                                <select name="minyear" style="cursor:pointer;" class="keyskil" id="minyear" tabindex="8">
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


                                                <select tabindex="9" name="maxyear" style="cursor:pointer;" class="keyskil1" id="maxyear">
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
                                                <input  type="checkbox" tabindex="10" id="fresher_nme" name="fresher" value="1"><label for="fresher_nme">Fresher can also apply..!   </label> 
                                            </fieldset>
                                            <fieldset id="erroe_nn" class="full-width" <?php if ($degree1) { ?> class="error-msg" <?php } ?>>
                                                <label>Required Education:<span class="optional">(optional)</span></label> 

                                                <input type="search" tabindex="11" autofocus id="education" name="education" value="" placeholder="Education" style="text-transform: capitalize;" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value" maxlength="255">
                                                <span id="fullname-error"></span>
                                                <?php echo form_error('education'); ?>
                                            </fieldset>
                                            <fieldset <?php if ($emp_type) { ?> class="error-msg" <?php } ?> class="two-select-box1">

                                                <label style="cursor:pointer;" class="control-label">Employment Type:<span style="color:red">*</span></label>


                                                <select name="emp_type" style="cursor:pointer;" class="keyskil" tabindex="12" id="emp_type">
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
                                                <input name="position_no" type="text"  id="position" value="1" tabindex="13" placeholder="Enter No of position"/>
                                                <span id="fullname-error"></span>
                                                <?php echo form_error('position'); ?>        
                                            </fieldset>
                                            <fieldset class="form-group fw">
                                                <label class="control-label">Last Date For Apply:<span style="color:red">*</span></label>

                                                <input type="hidden" id="example2" tabindex="14">

                                                <?php echo form_error('last_date'); ?> 
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="custom-add-box">
                                        <h3>Salary Information</h3>
                                        <div class="p15 fw">
                                            <fieldset <?php if ($salary_type) { ?> class="error-msg" <?php } ?> class="two-select-box1">

                                                <label style="cursor:pointer;" class="control-label">Salary Type:<span class="optional">(optional)</span></label>


                                                <select name="salary_type" style="cursor:pointer;" class="keyskil" id="salary_type" tabindex="17">
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
                                                <select name="currency" id="currency" tabindex="18">

                                                    <option value="" selected option disabled>Select Currency</option>

                                                    <?php foreach ($currency as $cur) { ?>
                                                        <option value="<?php echo $cur['currency_id']; ?>"><?php echo $cur['currency_name']; ?></option>
                                                    <?php } ?>
                                                </select>


                                                <?php echo form_error('currency'); ?>
                                            </fieldset>
                                            <fieldset class=" " <?php if ($minsal) { ?> class="error-msg" <?php } ?>>
                                                <label class="control-label">Minimum Salary:<span class="optional">(optional)</span></label>
                                                <input name="minsal" type="text" id="minsal" placeholder="Enter Minimum Salary" tabindex="19" /><span id="fullname-error"></span>
                                                <?php echo form_error('minsal'); ?>
                                            </fieldset>

                                            <fieldset class="" <?php if ($maxsal) { ?> class="error-msg " <?php } ?>>
                                                <label class="control-label">Maximum Salary:<span class="optional">(optional)</span></label>
                                                <input name="maxsal" type="text" id="maxsal" tabindex="20" placeholder="Enter Maximum Salary" /><span id="fullname-error"></span>
                                                <?php echo form_error('maxsal'); ?>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="custom-add-box">
                                        <h3>Job Location</h3>
                                        <div class="p15 fw">
                                            <fieldset class="fw" <?php if ($country) { ?> class="error-msg" <?php } ?>>
                                                <label >Country:<span style="color:red">*</span></label>
                                                <select style="cursor:pointer;" name="country" id="country" tabindex="21">
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
                                                <select style="cursor:pointer;" name="state" id="state" tabindex="22">
                                                    <option value="">Select Country First</option>
                                                </select>
                                                <?php echo form_error('state'); ?> 
                                            </fieldset>

                                            <fieldset class="fw" <?php if ($city) { ?> class="error-msg" <?php } ?>>
                                                <label>City:</label>
                                                <select style="cursor:pointer;" name="city" id="city" tabindex="23">
                                                    <option value="">Select State First</option>
                                                </select>

                                            </fieldset>













<!--   <fieldset class="full-width" <?php //if ($other_skill) {          ?> class="error-msg" <?php //}          ?> >
    <label class="control-label">Other Skill: --><!-- <span style="color:red">*</span> --><!-- </label>
    <input name="other_skill" type="text" class="skill_other" tabindex="3" id="other_skill" placeholder="Enter Your Skill" />
    <span id="fullname-error"></span>
                                            <?php //echo form_error('other_skill');  ?> 
                                    </fieldset>-->
                                            <!--  </div> -->






























                                            <input type="hidden" id="tagSelect" tabindex="24" value="brown,red,green" style="width:300px;" />



                                            <fieldset  class="hs-submit full-width">


                                                <input type="submit" title="Post" id="submit" class="add_post_btns" tabindex="25" name="submit" value="Post">

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
        <!-- BEGIN FOOTER -->
        <?php echo $login_footer ?>
        <?php echo $footer; ?>
        <!-- END FOOTER -->

      

        <script>
                                            var base_url = '<?php echo base_url(); ?>';
                                            var data1 = <?php echo json_encode($de); ?>;
                                            var data = <?php echo json_encode($demo); ?>;
                                            var jobdata = <?php echo json_encode($jobtitle); ?>;
                                            var get_csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
                                            var get_csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
        </script>
        <!-- FIELD VALIDATION JS END -->
        <?php
        if (IS_REC_JS_MINIFY == '0') {
            ?>
         <!-- FIELD VALIDATION JS START -->
            <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js') ?>"></script>
            <script src="<?php echo base_url('assets/js/jquery.fancybox.js'); ?>"></script>
            <!-- THIS SCRIPT ALWAYS PUT UNDER FANCYBOX JS-->
            <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script> 
            <!--SCRIPT FOR DATE START-->
            <script src="<?php echo base_url('assets/js/jquery.date-dropdowns.js'); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/search.js'); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/add_post.js'); ?>"></script>
            <?php
        } else {
            ?>
           <!-- FIELD VALIDATION JS START -->
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js') ?>"></script>
            <script src="<?php echo base_url('assets/js_min/jquery.fancybox.js'); ?>"></script>
            <!-- THIS SCRIPT ALWAYS PUT UNDER FANCYBOX JS-->
            <script src="<?php echo base_url('assets/js_min/bootstrap.min.js'); ?>"></script> 
            <!--SCRIPT FOR DATE START-->
            <script src="<?php echo base_url('assets/js_min/jquery.date-dropdowns.js'); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/recruiter/search.js'); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/recruiter/add_post.js'); ?>"></script>
        <?php } ?>



        <style type="text/css">

            .keyskill_border_active {
                border: 1px solid #f00 !important;

            }
            #skills-error{margin-top: 40px !important;}

            #minmonth-error{    margin-top: 40px; margin-right: 9px;}
            #minyear-error{margin-top: 42px !important;margin-right: 9px;}
            #maxmonth-error{margin-top: 42px !important;margin-right: 9px;}
            #maxyear-error{margin-top: 42px !important;margin-right: 9px;}

            #minmonth-error{margin-top: 39px !important;}
            #minyear-error{margin-top: auto !important;}
            #maxmonth-error{margin-top: 39px !important;}
            #maxyear-error{margin-top: auto !important;}
            #example2-error{margin-top: 40px !important}


        </style>
    </body>
</html>