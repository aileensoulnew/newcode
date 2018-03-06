<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>
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
                        <div style="width: 74%;text-align: center;margin: 0 auto;"> <?php
                            if ($this->uri->segment(3) == 'live-post') {
                                echo '<div class="alert alert-success">You  will be automatically apply successfully after completing of Freelancer profile ...!</div>';
                            }
                            ?></div>
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
                                    <ul  class="left-form-each">
                                        <li <?php if ($this->uri->segment(1) == 'freelance-work') { ?> class="active init" <?php } ?>><a title="Basic Information"  href="javascript:void(0);"><?php echo $this->lang->line("basic_info"); ?></a></li>

                                        <li class="custom-none  <?php
                                        if ($freepostdata[0]['free_post_step'] < '1') {
                                            echo "khyati";
                                        }
                                        ?>"><a title="Address Information" href="<?php echo base_url('freelance-work/address-information'); ?>"><?php echo $this->lang->line("address_info"); ?></a></li>

                                        <li class="custom-none  <?php
                                        if ($freepostdata[0]['free_post_step'] < '2') {
                                            echo "khyati";
                                        }
                                        ?>"><a title="Professional Information" href="<?php echo base_url('freelance-work/professional-information'); ?>"><?php echo $this->lang->line("professional_info"); ?></a></li>

                                        <li class="custom-none  <?php
                                        if ($freepostdata[0]['free_post_step'] < '3') {
                                            echo "khyati";
                                        }
                                        ?>"><a title="Rate" href="<?php echo base_url('freelance-work/rate'); ?>"><?php echo $this->lang->line("rate"); ?></a></li>

                                        <li class="custom-none  <?php
                                        if ($freepostdata[0]['free_post_step'] < '4') {
                                            echo "khyati";
                                        }
                                        ?>"><a title="Avability" href="<?php echo base_url('freelance-work/avability'); ?>"><?php echo $this->lang->line("add_avability"); ?></a></li>

                                        <li class="custom-none  <?php
                                        if ($freepostdata[0]['free_post_step'] < '5') {
                                            echo "khyati";
                                        }
                                        ?>"><a title="Education" href="<?php echo base_url('freelance-work/education'); ?>"><?php echo $this->lang->line("education"); ?></a></li>		    
                                        <li class="custom-none  <?php
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
                                    <h3><?php echo $this->lang->line("basic_info"); ?></h3>
                                    <?php echo form_open(base_url('freelancer/freelancer_post_basic_information_insert'), array('id' => 'freelancer_post_basicinfo', 'name' => 'freelancer_post_basicinfo', 'class' => 'clearfix')); ?>
                                    <?php
                                    $fullname = form_error('fullname');
                                    $lastname = form_error('lastname');
                                    $email = form_error('email');
                                    $phoneno = form_error('phoneno');
                                    ?>
                                    <fieldset <?php if ($firstname) { ?> class="error-msg" <?php } ?>>
                                        <label><?php echo $this->lang->line("first_name"); ?>:<span class="red">*</span></label>
                                        <?php if ($livepostid) { ?>
                                            <input type="hidden" name="livepostid" id="livepostid" tabindex="5"  value="<?php echo $livepostid; ?>">
                                        <?php }
                                        ?>
                                        <input tabindex="1" autofocus type="text" name="firstname" id="firstname" placeholder="Enter full name" value="<?php
                                        if ($firstname1) {
                                            echo $firstname1;
                                        } else {
                                            echo $userdata[0]['first_name'];
                                        }
                                        ?>"onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value">
                                               <?php echo form_error('firstname'); ?>
                                    </fieldset>
                                    <fieldset <?php if ($lastname) { ?> class="error-msg" <?php } ?>>
                                        <label><?php echo $this->lang->line("last_name"); ?>:<span class="red">*</span></label>
                                        <input type="text" name="lastname" tabindex="2" id="lastname" placeholder="Enter last name" value="<?php
                                        if ($lastname1) {
                                            echo $lastname1;
                                        } else {
                                            echo $userdata[0]['last_name'];
                                        }
                                        ?>">
                                               <?php echo form_error('lastname'); ?>
                                    </fieldset>
                                    <fieldset class="vali_er" <?php if ($email) { ?> class="error-msg" <?php } ?>>
                                        <label><?php echo $this->lang->line("email"); ?>:<span class="red">*</span></label>
                                        <input type="text" name="email" id="email" tabindex="3" placeholder="Enter email address" value="<?php
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
                                        <input type="text" name="skypeid" placeholder="Enter skype id" tabindex="4" value="<?php
                                        if ($skypeid1) {
                                            echo $skypeid1;
                                        }
                                        ?>">
                                               <?php ?>
                                    </fieldset>
                                    <fieldset <?php if ($phoneno) { ?> class="error-msg " <?php } ?> class="full-width">
                                        <label><?php echo $this->lang->line("phone_number"); ?>:<span class="optional">(optional)</span></label>
                                        <input type="text" name="phoneno" id="phoneno" tabindex="5" placeholder="Enter phone number" value="<?php
                                        if ($phoneno1) {
                                            echo $phoneno1;
                                        }
                                        ?>">
                                               <?php echo form_error('phoneno'); ?>
                                    </fieldset>
                                    <fieldset class="hs-submit full-width">
                                        <!-- <input type="submit"  id="next" name="next" value="Next" tabindex="6"> -->

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
        <?php
        if (IS_APPLY_JS_MINIFY == '0') {
            ?>
            <script  type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
            <?php
        } else {
            ?>
            <script  type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()) ?>"></script>
        <?php } ?>



        <script>
                                            var base_url = '<?php echo base_url(); ?>';
                                            var site = '<?php echo site_url(); ?>';

        </script>
        <?php
        if (IS_APPLY_JS_MINIFY == '0') {
            ?>
            <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_post_basic_information.js?ver=' . time()); ?>"></script>    
            <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_apply_common.js?ver=' . time()); ?>"></script>
            <?php
        } else {
            ?>
            <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_post_basic_information.js?ver=' . time()); ?>"></script>    
            <script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-apply/freelancer_apply_common.js?ver=' . time()); ?>"></script>
        <?php } ?>


    </body>

</html>