<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>  
        <?php
        if (IS_BUSINESS_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/business.css?ver=' . time()); ?>">
            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/business.css?ver=' . time()); ?>">
        <?php } ?>

        <style type="text/css">
            [contenteditable=true]:empty:before{
                content: attr(placeholder);
                display: block;
                font-size: 14px; /* For Firefox */
                color:#616060;
            }
        </style>
    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push botton_footer">
        <?php echo $header; ?>
        <?php if ($business_common_data[0]['business_step'] == 4) { ?>
            <?php echo $business_header2_border; ?>
        <?php } ?>
        <section>
            <?php
            $userid = $this->session->userdata('aileenuser');
            $contition_array = array('user_id' => $userid, 'status' => '1');
            $busdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if ($busdata[0]['business_step'] == 4) {
                ?>
                <div class="user-midd-section" id="paddingtop_fixed">
                <?php } else {
                    ?>
                    <div class="user-midd-section" id="paddingtop_make_fixed">   
                    <?php }
                    ?>
                    <div class="common-form1">
                        <div class="col-md-3 col-sm-4"></div>
                        <?php
                        if ($busdata[0]['business_step'] == 4) {
                            ?>
                            <div class="col-md-6 col-sm-8"><h3>You are updating your Business Profile.</h3></div>
                        <?php } else {
                            ?>
                            <div class="col-md-6 col-sm-8"><h3>You are making your Business Profile.</h3></div>
                        <?php } ?>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3 col-sm-4">
                                <div class="left-side-bar">
                                    <ul class="left-form-each">
                                        <li class="custom-none"><a href="<?php echo base_url('business-profile/business-information-update'); ?>"><?php echo $this->lang->line("business_information"); ?></a></li>
                                        <li class="custom-none"><a href="<?php echo base_url('business-profile/contact-information'); ?>"><?php echo $this->lang->line("contact_information"); ?></a></li>
                                        <li class="custom-none active init"><a href="javascript:void(0);"><?php echo $this->lang->line("description"); ?></a></li>
                                        <?php if ($business_common_data[0]['business_step'] > '2' && $business_common_data[0]['business_step'] != '') { ?>    
                                            <li class="custom-none"><a href="<?php echo base_url('business-profile/image'); ?>"><?php echo $this->lang->line("business_images"); ?></a></li>
                                        <?php } else {
                                            ?>
                                            <li class="custom-none"><a href="javascript:void(0);"><?php echo $this->lang->line("business_images"); ?></a></li>
                                        <?php }
                                        ?>
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
                                    <h3>
                                        Description
                                    </h3>
                                    <?php echo form_open(base_url('business-profile/description-insert'), array('id' => 'businessdis', 'name' => 'businessdis', 'class' => 'clearfix')); ?>
                                    <?php
                                    $business_type = form_error('business_type');
                                    $industriyal = form_error('industriyal');
                                    $subindustriyal = form_error('subindustriyal');
                                    $business_details = form_error('business_details');
                                    ?> 
                                    <fieldset <?php if ($business_type) { ?> class="error-msg" <?php } ?>>
                                        <label>Business type:<span style="color:red">*</span></label>
                                        <select name="business_type" tabindex="1" autofocus id="business_type" onchange="busSelectCheck(this);">

                                            <?php
                                            if ($business_type1) {
                                                ?>
                                                <option value="" option disabled>Select Business type</option> 
                                                <?php
                                                foreach ($businesstypedata as $cnt) {
                                                    ?>
                                                    <option value="<?php echo $cnt['type_id']; ?>" <?php
                                                    if ($cnt['type_id'] == $business_type1) {
                                                        echo $selected = 'selected';
                                                    }
                                                    ?>><?php echo $cnt['business_name']; ?></option>

                                                <?php } ?>
                                                <option id="busOption" value="0" <?php
                                                if ($business_type1 == 0 && $other_business != '') {
                                                    echo "selected";
                                                }
                                                ?>>Other</option>
                                                        <?php
                                                    } else {
                                                        if (count($businesstypedata) > 0) {
                                                            ?>
                                                    <option value="" <?php
                                                    if ($business_type1 == '') {
                                                        echo "selected";
                                                    }
                                                    ?>>Select business type</option>
                                                            <?php foreach ($businesstypedata as $cnt) {
                                                                ?>

                                                        <option value="<?php echo $cnt['type_id']; ?>"><?php echo $cnt['business_name']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <option id="busOption" value="0" <?php
                                                if ($business_type1 == '0' && $other_business != '') {
                                                    echo "selected";
                                                }
                                                ?>>Other</option>
                                                    <?php }
                                                    ?>
                                        </select>
                                        <?php echo form_error('business_type'); ?>
                                    </fieldset>
                                    <fieldset <?php if ($industriyal) { ?> class="error-msg" <?php } ?>>
                                        <label>Category:<span style="color:red">*</span></label>
                                        <select name="industriyal" tabindex="2"  id="industriyal" onchange="indSelectCheck(this);">

                                            <?php
                                            if ($industriyal1) {
                                                ?>
                                                <option value="" option disabled>Select Industry type</option> 
                                                <?php
                                                foreach ($industriyaldata as $cnt) {
                                                    ?>
                                                    <option value="<?php echo $cnt['industry_id']; ?>" <?php
                                                    if ($cnt['industry_id'] == $industriyal1) {
                                                        echo $selected = "selected";
                                                    }
                                                    ?>><?php echo $cnt['industry_name']; ?></option>
                                                        <?php }
                                                        ?>
                                                <option id="indOption" value="0" <?php
                                                if ($industriyal1 == 0 && $other_industry != '') {
                                                    echo "selected";
                                                }
                                                ?>>Other</option>  
                                                        <?php
                                                    } else {
                                                        ?>
                                                <option value="" <?php
                                                if ($industriyal1 == '') {
                                                    echo "selected";
                                                }
                                                ?>>Select Category</option>
                                                        <?php
                                                        if (count($industriyaldata) > 0) {
                                                            foreach ($industriyaldata as $cnt) {
                                                                ?>

                                                        <option value="<?php echo $cnt['industry_id']; ?>"><?php echo $cnt['industry_name']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <option id="indOption" value="0" <?php
                                                if ($industriyal1 == '0' && $other_industry != '') {
                                                    echo "selected";
                                                }
                                                ?>>Other</option>

                                            <?php }
                                            ?>
                                        </select>

                                        <?php echo form_error('industriyal'); ?>
                                    </fieldset>
                                    <div id="busDivCheck" <?php if (($business_type1 != 0 || $business_type1 == '') || ($business_type1 == 0 && $other_business == '')) { ?>style="display:none" <?php } ?>>
                                        <fieldset <?php if ($subindustrial) { ?> class="error-msg" <?php } ?> class="half-width" id="other-business">
                                            <label> Other business type: <span style="color:red;" >*</span></label>
                                            <input type="text" name="bustype"  tabindex="3"  id="bustype" value="<?php echo $other_business; ?>" style="<?php
                                            if (($business_type1 != 0 || $business_type1 == '') || ($business_type1 == 0 && $other_business == '')) {
                                                echo 'display: none';
                                            }
                                            ?>" required="">
                                                   <?php echo form_error('subindustriyal'); ?>
                                        </fieldset>
                                    </div>
                                    <div id="indDivCheck" <?php if (($industriyal1 != 0 || $industriyal1 == '') || ($industriyal1 == 0 && $other_industry == '')) { ?>style="display:none" <?php } ?>>
                                        <fieldset <?php if ($subindustrial) { ?> class="error-msg" <?php } ?> class="half-width" id="other-category">
                                            <?php if ($industriyal1 == 0) { ?>    <!--  <label id="indtype">Add Here Your Other Category type:<span style="color:red">*</span></label> --> <?php } ?>
                                            <label> Other category:<span style="color:red;" >*</span></label>
                                            <input type="text" name="indtype" id="indtype" tabindex="4"  value="<?php echo $other_industry; ?>" 
                                                   style="<?php
                                                   if (($industriyal1 != 0 || $industriyal1 = '') || ($industriyal1 == 0 && $other_industry == '')) {
                                                       echo 'display: none';
                                                   }
                                                   ?>" required="">
                                                   <?php echo form_error('subindustriyal'); ?>
                                        </fieldset>
                                    </div>
                                    <fieldset <?php if ($business_details) { ?> class="error-msg" <?php } ?> class="full-width">
                                        <label>Details of your business:<span style="color:red">*</span></label>
                                        <textarea name="business_details" id="business_details" rows="4" tabindex="5"  cols="50" placeholder="Enter business detail" style="resize: none;"><?php
                                            if ($business_details1) {
                                                echo $business_details1;
                                            }
                                            ?></textarea>
                                        <?php echo form_error('business_details'); ?>
                                    </fieldset>
                                    <fieldset class="hs-submit full-width">
                                        <input type="submit"  id="next" name="next" value="Next" tabindex="6" >
                                    </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <?php echo $login_footer ?>
        <?php echo $footer; ?>
    </footer>
    <script>
        var base_url = '<?php echo base_url(); ?>';
        var slug = '<?php echo $slugid; ?>';
    </script>
    <?php if (IS_BUSINESS_JS_MINIFY == '0') { ?>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/description.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
    <?php } else { ?>
        <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()) ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/business-profile/description.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js_min/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
    <?php } ?>
</body>
</html>