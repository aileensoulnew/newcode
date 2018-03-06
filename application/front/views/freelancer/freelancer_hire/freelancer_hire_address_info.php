<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>
    <?php if (IS_HIRE_CSS_MINIFY == '0') {?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/freelancer-hire.css?ver=' . time()); ?>">
        <?php } else {?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/freelancer-hire.css?ver=' . time()); ?>">
        <?php } ?>
    </head>
  
    <body class="botton_footer">
        
        <?php echo $header; ?>
        <?php
        if ($freehiredata['free_hire_step'] == '3') {
            echo $freelancer_hire_header2_border;
        }
        ?>
        <section>
            <?php
            $userid = $this->session->userdata('aileenuser');
            $contition_array = array('user_id' => $userid, 'status' => '1');
            $freehiredata = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if ($freehiredata[0]['free_hire_step'] == 3) {
                ?>
                <div class="user-midd-section" id="paddingtop_fixed">
                <?php } else { ?> 
                    <div class="user-midd-section" id="paddingtop_make_fixed">
                    <?php } ?>
                    <div class="common-form1">
                        <div class="col-md-3 col-sm-4"></div>
                        <?php
                        if ($freehiredata[0]['free_hire_step'] == 3) {
                            ?>
                            <div class="col-md-6 col-sm-6"><h3><?php echo $this->lang->line("hire-regi-title_update"); ?></h3></div>
                        <?php } else {
                            ?>
                            <div class="col-md-6 col-sm-6"><h3><?php echo $this->lang->line("hire-regi-title"); ?></h3></div>
                        <?php } ?>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3 col-sm-3">
                                <div class="left-side-bar">
                                    <ul class="left-form-each">
                                        <li class="custom-none "> <a title="Basic Information" href="<?php echo base_url('freelance-hire/basic-information'); ?>"><?php echo $this->lang->line("basic_info"); ?></a></li>
                                        <li <?php if ($this->uri->segment(1) == 'freelance-hire') { ?> class="active init" <?php } ?>><a title="Address Information" href="javascript:void(0);"><?php echo $this->lang->line("address_info"); ?></a></li>
                                        <li class="custom-none  <?php
                                        if ($freehiredata[0]['free_hire_step'] < '2') {
                                            echo "khyati";
                                        }
                                        ?>"><a title="Professional Information" href="<?php echo base_url('freelance-hire/professional-information'); ?>"><?php echo $this->lang->line("professional_info"); ?></a></li>
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
                                    <h3><?php echo $this->lang->line("address_info"); ?></h3>
                                    <?php echo form_open_multipart(base_url('freelancer_hire/freelancer_hire_address_info_insert'), array('id' => 'address_info', 'name' => 'address_info', 'class' => 'clearfix')); ?>
                                  
                                    <?php
                                    $country = form_error('country');
                                    $state = form_error('state');
                                    $address = form_error('address');
                                    ?>
                                    <fieldset <?php if ($country) { ?> class="error-msg" <?php } ?>>
                                        <label><?php echo $this->lang->line("country"); ?>:<span class="red">*</span></label>
                                        <select tabindex="1"  name="country" id="country" autofocus>
                                            <option value=""><?php echo $this->lang->line("select_country"); ?></option>
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
                                    <fieldset <?php if ($state) { ?> class="error-msg" <?php } ?>>
                                        <label><?php echo $this->lang->line("state"); ?>:<span class="red">*</span></label>
                                        <select tabindex="2" name="state" id="state">
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
                                                <option value=""><?php echo $this->lang->line("country_first"); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <?php echo form_error('state'); ?>
                                    </fieldset>
                                    <fieldset>
                                        <label><?php echo $this->lang->line("city"); ?>:<span class="optional">(optional)</span></label>
                                        <select name="city" tabindex="3" id="city">
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
                                                <option value=""><?php echo $this->lang->line("select_city"); ?></option>
                                                <?php
                                                foreach ($cities as $cnt) {
                                                    ?>
                                                    <option value="<?php echo $cnt['city_id']; ?>"><?php echo $cnt['city_name']; ?></option>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <option value=""><?php echo $this->lang->line("state_first"); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </fieldset>
                                    <?php ?>
                                    <fieldset>
                                        <label><?php echo $this->lang->line("pincode"); ?>:<span class="optional">(optional)</span></label>
                                        <input type="text" name="pincode" tabindex="4" id="pincode" placeholder="Enter pincode"  value="<?php
                                        if ($pincode1) {
                                            echo $pincode1;
                                        }
                                        ?>">
                                    </fieldset>
                                    <?php ?>

                                    <fieldset class="hs-submit full-width">
                                        <!-- <input type="submit"  id="next" tabindex="6" name="next" value="Next"> -->

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

       
         <?php if (IS_HIRE_JS_MINIFY == '0') { ?>
         <script  type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
            <?php } else {  ?>
        <script  type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()) ?>"></script>
        <?php } ?>
        <script type="text/javascript">
            var base_url = '<?php echo base_url(); ?>';
        </script>
        <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/freelancer_hire_address_info.js?ver=' . time()); ?>"></script>
         <?php if (IS_HIRE_JS_MINIFY == '0') { ?>
          <!--<script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/freelancer_hire_address_info.js?ver=' . time()); ?>"></script>-->
        <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/freelancer_hire_common.js?ver=' . time()); ?>"></script>
            <?php } else {  ?>
       <!--<script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-hire/freelancer_hire_address_info.js?ver=' . time()); ?>"></script>-->
        <script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-hire/freelancer_hire_common.js?ver=' . time()); ?>"></script>
        <?php } ?>
       
    </body>

</html>