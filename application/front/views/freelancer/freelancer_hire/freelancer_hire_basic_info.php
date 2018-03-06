<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>
        <?php if (IS_HIRE_CSS_MINIFY == '0') { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/freelancer-hire.css?ver=' . time()); ?>">
        <?php } else { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/freelancer-hire.css?ver=' . time()); ?>">
        <?php } ?>
    </head>

    <body class="pushmenu-push botton_footer">

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
                <div class="user-midd-section" id="paddingtop_fixed" >
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
                                        <li <?php if ($this->uri->segment(1) == 'freelance-hire') { ?> class="active init" <?php } ?>><a title="Basic Information" href="javascript:void(0);"><?php echo $this->lang->line("basic_info"); ?></a></li>
                                        <li class="custom-none <?php
                                        if ($freehiredata[0]['free_hire_step'] < '1') {
                                            echo "khyati";
                                        }
                                        ?>"><a title="Address Information" href="<?php echo base_url('freelance-hire/address-information'); ?>"><?php echo $this->lang->line("address_info"); ?></a></li>
                                        <li class="custom-none <?php
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
                                    <h3><?php echo $this->lang->line("basic_info"); ?></h3>
                                    <?php echo form_open_multipart(base_url('freelancer_hire/freelancer_hire_basic_info_insert'), array('id' => 'basic_info', 'name' => 'basic_info', 'class' => 'clearfix')); ?>

                                    <?php
                                    $fname = form_error('fname');
                                    $lname = form_error('lname');
                                    $email = form_error('email');
                                    $phone = form_error('phone');
                                    ?>
                                    <fieldset <?php if ($fname) { ?> class="error-msg" <?php } ?>>
                                        <label><?php echo $this->lang->line("first_name"); ?><span class="red">*</span>:</label>
                                        <input type="text" tabindex="1" autofocus name="fname" id="fname" placeholder="Enter first name" value="<?php
                                        if ($firstname1) {
                                            echo $firstname1;
                                        } else {
                                            echo $userdata[0]['first_name'];
                                        }
                                        ?>" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value">
                                               <?php echo form_error('fname'); ?>
                                    </fieldset>
                                    <fieldset <?php if ($lname) { ?> class="error-msg" <?php } ?>>
                                        <label><?php echo $this->lang->line("last_name"); ?><span class="red">*</span>:</label>
                                        <input type="text" tabindex="2" name="lname" id="lname" placeholder="Enter last name" value="<?php
                                        if ($lastname1) {
                                            echo $lastname1;
                                        } else {
                                            echo $userdata[0]['last_name'];
                                        }
                                        ?>">
                                               <?php echo form_error('lname'); ?>
                                    </fieldset>
                                    <fieldset class="vali_er" <?php if ($email) { ?> class="error-msg" <?php } ?>>
                                        <label><?php echo $this->lang->line("email"); ?><span class="red">*</span>:</label>
                                        <input type="text" name="email" tabindex="3" id="email" placeholder="Enter email" value="<?php
                                        if ($email1) {
                                            echo $email1;
                                        } else {
                                            echo $userdata[0]['user_email'];
                                        }
                                        ?>">
                                        <span class="email_note"><b>Note:-</b> Related notification email will be send on provided email address kindly use regular  email address.<div></div></span>
                                        <?php echo form_error('email'); ?>
                                    </fieldset>
                                    <fieldset>
                                        <label><?php echo $this->lang->line("skype_id"); ?>:<span class="optional">(optional)</span></label>
                                        <input type="text" name="skyupid" id="skyupid"  tabindex="4" placeholder="Enter skypeId" value="<?php
                                        if ($skypeid1) {
                                            echo $skypeid1;
                                        }
                                        ?>">

                                    </fieldset>
                                    <fieldset <?php if ($phone) { ?> class="error-msg" <?php } ?> class="full-width">
                                        <label><?php echo $this->lang->line("phone_no"); ?>:<span class="optional">(optional)</span></label>
                                        <input type="text" tabindex="5" name="phone" id="phone" placeholder="Enter phone number" value="<?php
                                        if ($phoneno1) {
                                            echo $phoneno1;
                                        }
                                        ?>">
                                               <?php echo form_error('phone'); ?>
                                    </fieldset>
                                    <fieldset class="hs-submit full-width">
                                        <!-- <input type="submit" tabindex="6" id="next" name="next" value="Next"> -->

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

        <?php } else { ?>
            <script  type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()) ?>"></script>

        <?php } ?>
        <script>
                                        var site_url = '<?php echo site_url(); ?>';
                                        var base_url = '<?php echo base_url(); ?>';
        </script>

        <?php if (IS_HIRE_JS_MINIFY == '0') { ?>
            <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/freelancer_hire_basic_info.js?ver=' . time()); ?>"></script>
            <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/freelancer_hire_common.js?ver=' . time()); ?>"></script>
        <?php } else { ?>
            <script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-hire/freelancer_hire_basic_info.js?ver=' . time()); ?>"></script>
            <script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-hire/freelancer_hire_common.js?ver=' . time()); ?>"></script>
        <?php } ?>

    </body>

</html>