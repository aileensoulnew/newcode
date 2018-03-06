<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>
        <style type="text/css">
            .keyskill_border_active {
                border-radius: 5px;
            }
            #tin-error{position: relative;}
        </style>
        <?php
        if (IS_APPLY_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/freelancer-apply.css?ver=' . time()); ?>">
            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/freelancer-apply.css?ver=' . time()); ?>">
        <?php } ?>


    </head>

    <body class="botton_footer">

        <?php echo $header; ?>
        <?php
        if ($freepostdata['user_id'] && $freepostdata['free_post_step'] == '7') {
            echo $freelancer_post_header2_border;
        }
        ?>
        <section>
            <?php
            $userid = $this->session->userdata('aileenuser');
            $contition_array = array('user_id' => $userid, 'status' => '1');
            $freepostdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if ($freepostdata[0]['free_post_step'] == 7) {
                ?>
                <div class="user-midd-section" id="paddingtop_fixed">
                <?php } else { ?>
                    <div class="user-midd-section" id="paddingtop_make_fixed">
                    <?php } ?>
                    <div class="common-form1">
                        <div class="col-md-3 col-sm-4"></div>
                        <?php
                        if ($freepostdata[0]['free_post_step'] == 7) {
                            ?>

                            <div class="col-md-6 col-sm-8"><h3><?php echo $this->lang->line("apply-regi-title_update"); ?></h3></div>
                        <?php } else {
                            ?>
                            <div class="col-md-6 col-sm-8"><h3><?php echo $this->lang->line("apply-regi-title"); ?></h3></div>

                        <?php } ?>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3 col-sm-3">
                                <div class="left-side-bar">
                                    <ul class="left-form-each">
                                        <li class="custom-none"><a title="Basic Information" href="<?php echo base_url('freelance-work/basic-information'); ?>"><?php echo $this->lang->line("basic_info"); ?></a></li> 

                                        <li class="custom-none"><a title="Address Information" href="<?php echo base_url('freelance-work/address-information'); ?>"><?php echo $this->lang->line("address_info"); ?></a></li>

                                        <li <?php if ($this->uri->segment(1) == 'freelance-work') { ?> class="active init" <?php } ?>><a title="Professional Information" href="#"><?php echo $this->lang->line("professional_info"); ?></a></li>

                                        <li class="custom-none <?php
                                        if ($freepostdata[0]['free_post_step'] < '3') {
                                            echo "khyati";
                                        }
                                        ?>"><a title="Rate" href="<?php echo base_url('freelance-work/rate'); ?>"><?php echo $this->lang->line("rate"); ?></a></li>

                                        <li class="custom-none <?php
                                        if ($freepostdata[0]['free_post_step'] < '4') {
                                            echo "khyati";
                                        }
                                        ?>"><a  title="Avability" href="<?php echo base_url('freelance-work/avability'); ?>"><?php echo $this->lang->line("add_avability"); ?></a></li>
                                        <li class="custom-none <?php
                                        if ($freepostdata[0]['free_post_step'] < '5') {
                                            echo "khyati";
                                        }
                                        ?>"><a title="Education" href="<?php echo base_url('freelance-work/education'); ?>"><?php echo $this->lang->line("education"); ?></a></li>		    
                                        <li class="custom-none <?php
                                        if ($freepostdata[0]['free_post_step'] < '6') {
                                            echo "khyati";
                                        }
                                        ?>"><a title="Portfolio" href="<?php echo base_url('freelance-work/portfolio'); ?>"><?php echo $this->lang->line("portfolio"); ?></a></li>
                                    </ul>

                                </div>
                            </div>
                            <div class="col-md-6 col-sm-8">
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
                                <div class="common-form common-form_border">
                                    <h3><?php echo $this->lang->line("professional_info"); ?></h3>
                                    <?php echo form_open(base_url('freelancer/freelancer_post_professional_information_insert'), array('id' => 'freelancer_post_professional', 'name' => 'freelancer_post_professional', 'class' => 'clearfix')); ?>

                                    <?php
                                    $field = form_error('field');
                                    $area = form_error('area');
                                    $skill_description = form_error('skill_description');
                                    $experience_year = form_error('experience_year');
                                    ?>
                                    <fieldset class="full-width" <?php if ($field) { ?> class="error-msg" <?php } ?>>
                                        <?php if ($livepostid) { ?>
                                            <input type="hidden" name="livepostid" id="livepostid" tabindex="5"  value="<?php echo $livepostid; ?>">
                                        <?php }
                                        ?>
                                        <label><?php echo $this->lang->line("your_field"); ?>:<span class="red">*</span></label> 

                                        <select tabindex="1" autofocus name="field" id="field" class="field_other">
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
                                    <fieldset  <?php if ($area) { ?> class="error-msg" <?php } ?> class="full-width">
                                        <label> <?php echo $this->lang->line("your_skill"); ?>:<span class="red">*</span></label>
                                        <input id="skills1" name="skills" tabindex="2"   placeholder="Enter skills" value="<?php
                                        if ($skill_2) {
                                            echo $skill_2;
                                        }
                                        ?>">
                                               <?php echo form_error('area'); ?>
                                    </fieldset>

                                    <fieldset  class="full-width">
                                        <label><?php echo $this->lang->line("skill_brief"); ?> :<span class="red">*</span></label>

                                        <textarea name ="skill_description" tabindex="3" id="skill_description" rows="4" cols="50" placeholder="Enter skill description" style="resize: none;" onpaste="OnPaste_StripFormatting(this, event);"><?php
                                            if ($skill_description1) {
                                                echo $skill_description1;
                                            }
                                            ?></textarea>

                                        <?php echo form_error('skill_description'); ?>
                                    </fieldset>
                                    <fieldset  class="" <?php if ($experience_year) { ?> class="error-msg" <?php } ?>>
                                        <label><?php echo $this->lang->line("total_experiance"); ?> :<span class="red">*</span></label>  <select name="experience_year" placeholder="Year" tabindex="4" id="experience_year" class="experience_year col-md-5 day" onchange="return check_yearmonth();" style="margin-right: 5px;">

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


                                        <select name="experience_month" tabindex="5" id="experience_month" placeholder="Month" class="experience_month col-md-5 day" onchange="return check_yearmonth();" style="margin-right: 5px;">
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
                                        <?php echo form_error('experience_year'); ?>

                                    </fieldset>
                                    <fieldset class="hs-submit full-width">
                                       <!--  <input type="submit"  id="next" name="next" tabindex="6" value="Next"> -->

                                        <button id="next" name="next" tabindex="6" onclick="return validate();">Next<span class="ajax_load pl10" id="profilereg_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>

                                    </fieldset>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <?php echo $login_footer ?>
        <?php echo $footer; ?>

        <!-- Bid-modal  -->
        <div class="modal fade message-box biderror custom-message" id="bidmodal2" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content message">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>
                    <h2>Add Field</h2>         
                    <input type="text" name="other_field" id="other_field" onkeypress="return remove_validation()">
                    <div class="fw"><a title="Ok" id="field" class="btn">OK</a></div>

                </div>
            </div>
        </div>
        <!-- Model Popup Close -->
        <?php
        if (IS_APPLY_JS_MINIFY == '0') {
            ?>
            <script  src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
            <script  type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
            <?php
        } else {
            ?>
            <script  src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
            <script  type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()) ?>"></script>
        <?php } ?>




        <script>
                        var base_url = '<?php echo base_url(); ?>';
        </script>
        <?php
        if (IS_APPLY_JS_MINIFY == '0') {
            ?>
            <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_post_professional_information.js?ver=' . time()); ?>"></script>
            <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_apply_common.js?ver=' . time()); ?>"></script>
            <?php
        } else {
            ?>
            <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_post_professional_information.js?ver=' . time()); ?>"></script>
            <script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-apply/freelancer_apply_common.js?ver=' . time()); ?>"></script>
        <?php } ?>



        <style type="text/css">
            #experience_year-error{margin-top: 42px;margin-left: 15px;}
            #experience_month-error{margin-top: 39px;margin-left: 15px;}
        </style>


    </body>

</html>