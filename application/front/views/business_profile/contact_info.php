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
                    <?php
                } else {
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
                                        <li class="custom-none active init"><a href="javascript:void(0);"><?php echo $this->lang->line("contact_information"); ?></a></li>
                                        <?php if ($business_common_data[0]['business_step'] > '1' && $business_common_data[0]['business_step'] != '') { ?>
                                            <li class="custom-none"><a href="<?php echo base_url('business-profile/description'); ?>"><?php echo $this->lang->line("description"); ?></a></li>
                                        <?php } else { ?>
                                            <li class="custom-none"><a href="javascript:void(0);"><?php echo $this->lang->line("description"); ?></a></li>
                                        <?php } ?>
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
                                        Contact Information
                                    </h3>
                                    <?php echo form_open(base_url('business-profile/contact-information-insert'), array('id' => 'contactinfo', 'name' => 'contactinfo', 'class' => 'clearfix')); ?>
                                    <?php
                                    $contactname = form_error('contactname');
                                    $contactmobile = form_error('contactmobile');
                                    $contactemail = form_error('email');
                                    $contactwebsite = form_error('contactwebsite');
                                    ?>
                                    <fieldset <?php if ($contactname) { ?> class="error-msg" <?php } ?>>
                                        <label>Contact person:<span style="color:red">*</span></label>
                                        <input name="contactname" tabindex="1" autofocus type="text" id="contactname" placeholder="Enter contact name" value="<?php
                                        if ($contactname1) {
                                            echo $contactname1;
                                        }
                                        ?>"/>
                                               <?php echo form_error('contactname'); ?>
                                    </fieldset>
                                    <fieldset <?php if ($contactmobile) { ?> class="error-msg" <?php } ?>>
                                        <label>Contact mobile:<span style="color:red">*</span></label>
                                        <input name="contactmobile" type="text" tabindex="2"  id="contactmobile" placeholder="Enter contact mobile" value="<?php
                                        if ($contactmobile1) {
                                            echo $contactmobile1;
                                        }
                                        ?>"/>
                                               <?php echo form_error('contactmobile'); ?> 
                                    </fieldset>
                                    <fieldset <?php if ($contactemail) { ?> class="error-msg" <?php } ?>>
                                        <label>Contact email:<span style="color:red">*</span></label>
                                        <input name="email" type="text" id="email" tabindex="3"  placeholder="Enter contact email" value="<?php
                                        if ($contactemail1) {
                                            echo $contactemail1;
                                        }
                                        ?>"/>
                                               <?php echo form_error('email'); ?>
                                    </fieldset>
                                    <fieldset>
                                        <label>Contact website<span class="optional">(optional)</span>:</label>
                                        <input name="contactwebsite" type="url" id="contactwebsite" tabindex="4"  placeholder="Enter contact website" value="<?php
                                        if ($contactwebsite1) {
                                            echo $contactwebsite1;
                                        }
                                        ?>"/>
                                        <span class="website_hint" style="font-size: 13px; color: #1b8ab9;">Note : <i>Enter website url with http or https</i></span>                                 
                                    </fieldset>
                                    <fieldset class="hs-submit full-width">
                                        <input tabindex="5"  type="submit"  id="next" name="next" value="Next">
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
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var slug = '<?php echo $slugid; ?>';
            var get_csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
            var get_csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
        </script>
        <?php if (IS_BUSINESS_JS_MINIFY == '0') { ?>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/contact_info.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
        <?php } else { ?>
 <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()) ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/business-profile/contact_info.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js_min/webpage/business-profile/common.js?ver=' . time()); ?>"></script>        <?php } ?>
    </body>
</html>
