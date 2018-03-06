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
    <body class="page-container-bg-solid page-boxed pushmenu-push botton_footer">
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
                        <div class="col-md-2 col-sm-1"> </div>
                        <div class="col-md-8 col-sm-10 animated fadeInLeftBig">

                            <div class="common-form custom-form">
								<h3 class="col-chang">Edit Job Post</h3>
								
								<div class="job-saved-box">
                                
                                <?php
                                if ($this->session->flashdata('error')) {
                                    echo '<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>';
                                }
                                if ($this->session->flashdata('success')) {
                                    echo '<div class="alert alert-success">' . $this->session->flashdata('success') . '</div>';
                                }
                                ?>
								
                            <div class="panel-body rec-edit-post">



                                <?php echo form_open(base_url('recruiter/update_post/' . $postdata[0]['post_id']), array('id' => 'basicinfo', 'name' => 'basicinfo', 'class' => 'clearfix ', 'onsubmit' => "return imgval()")); ?>
                                <div> <span class="required_field" >( <span style="color: red">*</span> ) Indicates required field</span></div>
                                <?php
                                $post_name = form_error('post_name');
                                $skills_12 = form_error('skills');
                                $month = form_error('month');
                                $position = form_error('position');
                                $post_desc = form_error('post_desc');
                                $last_date = form_error('last_date');
                                $location = form_error('location');
                                $country = form_error('country');
                                $state = form_error('state');
                                $city = form_error('city');
                                $minsal = form_error('minsal');
                                $maxsal = form_error('maxsal');
                                $emp_type = form_error('emp_type');

                                $salary_type = form_error('salary_type');
                                ?>
							<div class="custom-add-box">
								<h3>Job Detail</h3>
								<div class="p15 fw">
									<fieldset class="full-width">
                                    <label>Job Title:<span style="color:red">*</span></label>
                                    <input name="post_name" tabindex="1" autofocus type="text" id="post_name" placeholder="Enter Job Title" value="<?php echo $work_title; ?>" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value"/>
                                    <span id="fullname-error"></span>
                                    <?php echo form_error('post_name'); ?>
                                </fieldset>
								<fieldset  class="full-width">
                                    <label >Job Description:<span style="color:red">*</span></label>

                                    <textarea name="post_desc" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value" tabindex="2" id="varmailformat" rows="8" cols="50"  placeholder="Enter Job Description" style="resize: none;"><?php echo $postdata[0]['post_description']; ?></textarea>

<?php echo form_error('post_desc'); ?>
                                </fieldset>
								<fieldset class="full-width">
                                    <label class="control-label">Skills:<span style="color:red">*</span></label>

                                    <input id="skills2" value="<?php echo $work_skill; ?>" name="skills" placeholder="Enter SKills" class="full-width " tabindex="3">

                                    <?php echo form_error('skills'); ?>
                                </fieldset>
								<fieldset class="fw pad_right"> 
                                    <label>Industry:<span style="color:red">*</span></label>
                                    <select name="industry" id="industry" tabindex="4">
                                        <option value="" selected option disabled>Select Industry</option>

                                        <?php
                                        if (count($industry) > 0) {
                                            foreach ($industry as $indu) {

                                                if ($postdata[0]['industry_type']) {
                                                    ?>

                                                    <option value="<?php echo $indu['industry_id']; ?>" <?php if ($indu['industry_id'] == $postdata[0]['industry_type']) echo 'selected'; ?>><?php echo $indu['industry_name']; ?></option>
                                                <?php }else {
                                                    ?>
                                                    <option value="<?php echo $indu['industry_id']; ?>"><?php echo $indu['industry_name']; ?></option>
                                                <?php
                                                }
                                            }
                                        }
                                        ?>

                                        <option value="<?php echo $industry_otherdata[0]['industry_id']; ?> "><?php echo $industry_otherdata[0]['industry_name']; ?></option>   
                                    </select>


<?php echo form_error('industry'); ?>

                                </fieldset>
                                                                    
                                                                     <fieldset class="full-width">
                                      <label>Interview process:<span class="optional">(optional)</span></label>

                                    <textarea name="interview" id="interview" tabindex="5" rows="4" placeholder="Enter Interview Process" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value"><?php echo $postdata[0]['interview_process']; ?></textarea>

<?php echo form_error('interview'); ?> 
                                </fieldset>
								<fieldset <?php if ($month) { ?> class="error-msg" <?php } ?> class="">
                                    <label class="control-label">Minimum Experience:<span style="color:red">*</span></label>


                                    <select style="cursor:pointer;" tabindex="6" name="minyear" id="minyear" class="keyskil">

                                        <option value="" selected option disabled>Year</option>

                                        <option value="0" <?php if ($postdata[0]['min_year'] == "0") echo 'selected="selected"'; ?>>0 Year</option>
                                        <option value="0.5" <?php if ($postdata[0]['min_year'] == "0.5") echo 'selected="selected"'; ?>>0.5 Year</option>
                                        <option value="1" <?php if ($postdata[0]['min_year'] == "1") echo 'selected="selected"'; ?>>1 Year</option>
                                        <option value="1.5" <?php if ($postdata[0]['min_year'] == "1.5") echo 'selected="selected"'; ?>>1.5 Year</option>
                                        <option value="2" <?php if ($postdata[0]['min_year'] == "2") echo 'selected="selected"'; ?>>2 Year</option>
                                        <option value="2.5" <?php if ($postdata[0]['min_year'] == "2.5") echo 'selected="selected"'; ?>>2.5 Year</option>
                                        <option value="3" <?php if ($postdata[0]['min_year'] == "3") echo 'selected="selected"'; ?>>3 Year</option>
                                        <option value="4" <?php if ($postdata[0]['min_year'] == "4") echo 'selected="selected"'; ?>>4 Year</option>
                                        <option value="5" <?php if ($postdata[0]['min_year'] == "5") echo 'selected="selected"'; ?>>5 Year</option>
                                        <option value="6" <?php if ($postdata[0]['min_year'] == "6") echo 'selected="selected"'; ?>>6 Year</option>
                                        <option value="7" <?php if ($postdata[0]['min_year'] == "7") echo 'selected="selected"'; ?>>7 Year</option>
                                        <option value="8" <?php if ($postdata[0]['min_year'] == "8") echo 'selected="selected"'; ?>>8 Year</option>
                                        <option value="9" <?php if ($postdata[0]['min_year'] == "9") echo 'selected="selected"'; ?>>9 Year</option>
                                        <option value="10" <?php if ($postdata[0]['min_year'] == "10") echo 'selected="selected"'; ?>>10 Year</option>
                                        <option value="11" <?php if ($postdata[0]['min_year'] == "11") echo 'selected="selected"'; ?>>11 Year</option>
                                        <option value="12" <?php if ($postdata[0]['min_year'] == "12") echo 'selected="selected"'; ?>>12 Year</option>
                                        <option value="13" <?php if ($postdata[0]['min_year'] == "13") echo 'selected="selected"'; ?>>13 Year</option>
                                        <option value="14" <?php if ($postdata[0]['min_year'] == "14") echo 'selected="selected"'; ?>>14 Year</option>
                                        <option value="15" <?php if ($postdata[0]['min_year'] == "15") echo 'selected="selected"'; ?>>15 Year</option>
                                        <option value="16" <?php if ($postdata[0]['min_year'] == "16") echo 'selected="selected"'; ?>>16 Year</option>
                                        <option value="17" <?php if ($postdata[0]['min_year'] == "17") echo 'selected="selected"'; ?>>17 Year</option>
                                        <option value="18" <?php if ($postdata[0]['min_year'] == "18") echo 'selected="selected"'; ?>>18 Year</option>
                                        <option value="19" <?php if ($postdata[0]['min_year'] == "19") echo 'selected="selected"'; ?>>19 Year</option>
                                        <option value="20" <?php if ($postdata[0]['min_year'] == "20") echo 'selected="selected"'; ?>>20 Year</option>
                                    </select>



                                    <span id="fullname-error"></span>
                                    <?php echo form_error('month'); ?>  <?php echo form_error('year'); ?>

                                </fieldset>


                                <fieldset <?php if ($month) { ?> class="error-msg" <?php } ?> class="two-select-box1">
                                    <label class="control-label">Maximum Experience:<span style="color:red">*</span></label>


                                    <select style="cursor:pointer;" name="maxyear" tabindex="7"  id="maxyear" class="keyskil1">

                                        <option value="" selected option disabled>Year</option>

                                        <option value="0" <?php if ($postdata[0]['max_year'] == "0") echo 'selected="selected"'; ?>>0 Year</option>
                                        <option value="0.5" <?php if ($postdata[0]['max_year'] == "0.5") echo 'selected="selected"'; ?>>0.5 Year</option>
                                        <option value="1" <?php if ($postdata[0]['max_year'] == "1") echo 'selected="selected"'; ?>>1 Year</option>
                                        <option value="1.5" <?php if ($postdata[0]['max_year'] == "1.5") echo 'selected="selected"'; ?>>1.5 Year</option>
                                        <option value="2" <?php if ($postdata[0]['max_year'] == "2") echo 'selected="selected"'; ?>>2 Year</option>
                                        <option value="2.5" <?php if ($postdata[0]['max_year'] == "2.5") echo 'selected="selected"'; ?>>2.5 Year</option>
                                        <option value="3" <?php if ($postdata[0]['max_year'] == "3") echo 'selected="selected"'; ?>>3 Year</option>
                                        <option value="4" <?php if ($postdata[0]['max_year'] == "4") echo 'selected="selected"'; ?>>4 Year</option>
                                        <option value="5" <?php if ($postdata[0]['max_year'] == "5") echo 'selected="selected"'; ?>>5 Year</option>
                                        <option value="6" <?php if ($postdata[0]['max_year'] == "6") echo 'selected="selected"'; ?>>6 Year</option>
                                        <option value="7" <?php if ($postdata[0]['max_year'] == "7") echo 'selected="selected"'; ?>>7 Year</option>
                                        <option value="8" <?php if ($postdata[0]['max_year'] == "8") echo 'selected="selected"'; ?>>8 Year</option>
                                        <option value="9" <?php if ($postdata[0]['max_year'] == "9") echo 'selected="selected"'; ?>>9 Year</option>
                                        <option value="10" <?php if ($postdata[0]['max_year'] == "10") echo 'selected="selected"'; ?>>10 Year</option>
                                        <option value="11" <?php if ($postdata[0]['max_year'] == "11") echo 'selected="selected"'; ?>>11 Year</option>
                                        <option value="12" <?php if ($postdata[0]['max_year'] == "12") echo 'selected="selected"'; ?>>12 Year</option>
                                        <option value="13" <?php if ($postdata[0]['max_year'] == "13") echo 'selected="selected"'; ?>>13 Year</option>
                                        <option value="14" <?php if ($postdata[0]['max_year'] == "14") echo 'selected="selected"'; ?>>14 Year</option>
                                        <option value="15" <?php if ($postdata[0]['max_year'] == "15") echo 'selected="selected"'; ?>>15 Year</option>
                                        <option value="16" <?php if ($postdata[0]['max_year'] == "16") echo 'selected="selected"'; ?>>16 Year</option>
                                        <option value="17" <?php if ($postdata[0]['max_year'] == "17") echo 'selected="selected"'; ?>>17 Year</option>
                                        <option value="18" <?php if ($postdata[0]['max_year'] == "18") echo 'selected="selected"'; ?>>18 Year</option>
                                        <option value="19" <?php if ($postdata[0]['max_year'] == "19") echo 'selected="selected"'; ?>>19 Year</option>
                                        <option value="20" <?php if ($postdata[0]['max_year'] == "20") echo 'selected="selected"'; ?>>20 Year</option>
                                    </select>


                                    <span id="fullname-error"></span>
                                    <?php echo form_error('month'); ?>  <?php echo form_error('year'); ?>
                                </fieldset>
                                <fieldset class="rec_check form-group full-width" style="margin-top: 0px;
                                          margin-bottom: 2px;">
                                          <?php
                                          if ($postdata[0]['fresher']) {
                                              ?>
                                        <input type="checkbox" name="fresher" id="fresher_nme" tabindex="8" value="1" checked>
                                        <label for="fresher_nme">Fresher can also apply..!</label> 
                                        <?php
                                    } else {
                                        ?>
                                        <input type="checkbox"  name="fresher" value="1" id="fresher_nme" tabindex="9" >
                                        <label for="fresher_nme">Fresher can also apply..!</label> 
                                        <?php
                                    }
                                    ?>
                                </fieldset>
								<fieldset id="erroe_nn" class="fw" <?php if ($degree1) { ?> class="error-msg" <?php } ?>>
                                    <label>Required Education:<span class="optional">(optional)</span></label> 

                                    <input type="search" tabindex="10" autofocus id="education" name="education" value="<?php echo $degree_data; ?>" placeholder="Education" style="text-transform: capitalize;" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value" maxlength="255">
                                    <span id="fullname-error"></span>
<?php echo form_error('education'); ?>

                                </fieldset>
								<fieldset <?php if ($emp_type) { ?> class="error-msg" <?php } ?> class="two-select-box1">
                                    <label class="control-label">Employment Type:<span style="color:red">*</span></label>


                                    <select style="cursor:pointer;" tabindex="11" name="emp_type" id="emp_type" class="keyskil">

                                        <option value="" selected option disabled>Employment Type</option>

                                        <option value="Part Time" <?php if ($postdata[0]['emp_type'] == "Part Time") echo 'selected="selected"'; ?>>Part Time</option>
                                        <option value="Full Time" <?php if ($postdata[0]['emp_type'] == "Full Time") echo 'selected="selected"'; ?>>Full Time</option>
                                        <option value="Internship" <?php if ($postdata[0]['emp_type'] == "Internship") echo 'selected="selected"'; ?>>Internship</option>
                                    </select>

                                    <span id="fullname-error"></span>
<?php echo form_error('emp_type'); ?>  <?php echo form_error('emp_type'); ?>

                                </fieldset>
								<fieldset class="">
                                    <label>No Of Position:<span style="color:red">*</span></label>

                                    <input name="position" type="text" tabindex="11"  id="position" value="<?php echo $postdata[0]['post_position']; ?>" placeholder="Enter No of position" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value"/>
                                    <span id="fullname-error"></span>
                                    <?php echo form_error('position'); ?>
                                </fieldset>
								<fieldset class="fw edit-post">
                                    <label>Last date for apply: <span style="color:red">*</span></label>

                                    <input type="hidden" id="example2" tabindex="12">

<?php echo form_error('last_date'); ?> 
                                </fieldset>
								
								
								</div>
							</div>
							<div class="custom-add-box">
								<h3>Salary Information </h3>
								<div class="p15 fw">
									<fieldset <?php if ($salary_type) { ?> class="error-msg" <?php } ?> class="two-select-box1">
                                    <label class="control-label">Salary Type:<span class="optional">(optional)</span></label>


                                    <select style="cursor:pointer;" tabindex="15" name="salary_type" id="salary_type" class="keyskil">

                                        <option value="" selected option disabled>Salary Type </option>

                                        <option value="Per Year" <?php if ($postdata[0]['salary_type'] == "Per Year") echo 'selected="selected"'; ?>>Per Year</option>
                                        <option value="Per Month" <?php if ($postdata[0]['salary_type'] == "Per Month") echo 'selected="selected"'; ?>>Per Month</option>
                                        <option value="Per Week" <?php if ($postdata[0]['salary_type'] == "Per Week") echo 'selected="selected"'; ?>>Per Week</option>

                                        <option value="Per Day" <?php if ($postdata[0]['salary_type'] == "Per Day") echo 'selected="selected"'; ?>>Per Day</option>
                                    </select>
                                </fieldset>
								<fieldset class=" half-width pad_right"> 
                                    <label>Currency:<span class="optional">(optional)</span></label>
                                    <select name="currency" id="currency" tabindex="16">
                                        <option value="" selected option disabled>Select Currency</option>

                                        <?php
                                        if (count($currency) > 0) {
                                            foreach ($currency as $cur) {

                                                if ($postdata[0]['post_currency']) {
                                                    ?>

                                                    <option value="<?php echo $cur['currency_id']; ?>" <?php if ($cur['currency_id'] == $postdata[0]['post_currency']) echo 'selected'; ?>><?php echo $cur['currency_name']; ?></option>
                                                <?php }else {
                                                    ?>
                                                    <option value="<?php echo $cur['currency_id']; ?>"><?php echo $cur['currency_name']; ?></option>
                                                <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </select>


<?php echo form_error('currency'); ?>

                                </fieldset>
								<fieldset class="half-width  pad_left" <?php if ($minsal) { ?> class="error-msg" <?php } ?>>
                                          <label class="control-label">Minimum Salary:<span class="optional">(optional)</span></label>
                                    <input name="minsal" tabindex="17" type="text" id="minsal" value="<?php echo $postdata[0]['min_sal']; ?>"  placeholder="Enter Minimum Salary" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value"/><span id="fullname-error"></span>
<?php echo form_error('minsal'); ?>
                                </fieldset>
                             

                                <fieldset class="half-width " <?php if ($maxsal) { ?> class="error-msg" <?php } ?>>
                                   <label class="control-label">Maximum Salary:<span class="optional">(optional)</span></label>
                                    <input name="maxsal" type="text" tabindex="18" id="maxsal" value="<?php echo $postdata[0]['max_sal']; ?>"  placeholder="Enter Maximum Salary" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value"/><span id="fullname-error"></span>
<?php echo form_error('maxsal'); ?>
                                </fieldset>
								
								</div>
							</div>
							<div class="custom-add-box">
								<h3>Job Location</h3>
								<div class="p15 fw">
                                
                                <fieldset class="fw" <?php if ($country) { ?> class="error-msg" <?php } ?>>
                                    <label>Country:<span style="color:red">*</span></label>


<?php $countryname = $this->db->select('country_name')->get_where('countries', array('country_id' => $postdata[0]['country']))->row()->country_name; ?>

                                    <select style="cursor:pointer;" name="country" tabindex="19" id="country">



                                        <option value="" selected option disabled>Select Country</option>
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
                                    </select> 

                                <?php echo form_error('country'); ?>
                                </fieldset>

<?php $statename = $this->db->select('state_name')->get_where('states', array('state_id' => $postdata[0]['state']))->row()->state_name; ?>

                                <fieldset  class="fw" <?php if ($state) { ?> class="error-msg" <?php } ?>>
                                    <label>State:<span style="color:red">*</span></label>
                                    <select style="cursor:pointer;" name="state" id="state" tabindex="20">
                                        <?php
                                        if ($postdata[0]['state']) {
                                            foreach ($states as $cnt) {
                                                ?>

                                                <option value="<?php echo $cnt['state_id']; ?>" <?php if ($cnt['state_id'] == $postdata[0]['state']) echo 'selected'; ?>><?php echo $cnt['state_name']; ?></option>

                                                <?php
                                            }
                                        }

                                        else {
                                            ?>
                                            <option value="">Select Country First</option>
                                            <?php
                                        }
                                        ?>
                                    </select>
<?php echo form_error('state'); ?> 
                                </fieldset>


<?php $cityname = $this->db->select('city_name')->get_where('cities', array('city_id' => $postdata[0]['city']))->row()->city_name; ?>

                                <fieldset class="fw" <?php if ($city) { ?> class="error-msg" <?php } ?>>
                                    <label>City:</label>
                                    <select name="city" id="city" tabindex="21">
                                        <?php
                                        if ($postdata[0]['city']) {
                                            foreach ($cities as $cnt) {

                                                ?>

                                                <option value="<?php echo $cnt['city_id']; ?>" <?php if ($cnt['city_id'] == $postdata[0]['city']) echo 'selected'; ?>><?php echo $cnt['city_name']; ?></option>

                                                <?php
                                            }
                                        }
                                        else if ($postdata[0]['state']) {
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
                                            <option value="">Select State First</option>

                                            <?php
                                        }
                                        ?>
                                    </select>
<?php echo form_error('city'); ?>
                                </fieldset>



                                


   


                             


                                
   
                                <fieldset class="hs-submit full-width">
                                  


                                    <input type="submit" title="Save" id="submit" class="add_post_btns" tabindex="22" name="submit" value="save">                    
                                </fieldset>
								</div>
								</div>
                            </div>
								</div>
                            </div>
                            </form>
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
                                            var user_slug = '<?php echo $this->session->userdata('aileenuser_slug'); ?>';
                                            var data1 = <?php echo json_encode($de); ?>;
                                            var data = <?php echo json_encode($demo); ?>;
                                            var jobdata = <?php echo json_encode($jobtitle); ?>;
                                            var get_csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
                                            var get_csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
                                            var complex1 = <?php echo json_encode($selectdata1); ?>;
                                            var jobdata = <?php echo json_encode($jobtitle); ?>;
                                            var date_picker = '<?php echo date('Y-m-d', strtotime($postdata[0]['post_last_date'])); ?>';
       
        
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
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/edit_post.js'); ?>"></script>
            <?php
        } else {
            ?>
             <!-- FIELD VALIDATION JS START -->
        <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js_min/jquery.fancybox.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js_min/bootstrap.min.js'); ?>"></script> 
        <!--SCRIPT FOR DATE START-->
        <script src="<?php echo base_url('assets/js_min/jquery.date-dropdowns.js'); ?>"></script>
     <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/recruiter/search.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/recruiter/edit_post.js'); ?>"></script>
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