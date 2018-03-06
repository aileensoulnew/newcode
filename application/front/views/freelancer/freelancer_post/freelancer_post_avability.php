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

                                        <li class="custom-none"><a title="Professional Information" href="<?php echo base_url('freelance-work/professional-information'); ?>"><?php echo $this->lang->line("professional_info"); ?></a></li>

                                        <li class="custom-none"><a title="Rate" href="<?php echo base_url('freelance-work/rate'); ?>"><?php echo $this->lang->line("rate"); ?></a></li>

                                        <li <?php if ($this->uri->segment(1) == 'freelance-work') { ?> class="active init" <?php } ?>><a title="Avability" href="javascript:void(0);"><?php echo $this->lang->line("add_avability"); ?></a></li>

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
                                    <h3><?php echo $this->lang->line("add_avability"); ?></h3>
                                    <?php echo form_open(base_url('freelancer/freelancer_post_avability_insert'), array('id' => 'freelancer_post_avability', 'name' => 'freelancer_post_avability', 'class' => 'clearfix')); ?>
                                    <?php
                                    $job_type = form_error('job_type');
                                    $work_hour = form_error('work_hour');
                                    ?>
                                    <fieldset class="col-md-6" <?php if ($inweek) { ?> class="error-msg" <?php } ?>>


                                        <?php if ($livepostid) { ?>
                                            <input type="hidden" name="livepostid" id="livepostid" tabindex="5"  value="<?php echo $livepostid; ?>">
                                        <?php }
                                        ?>

                                        <label class="custom-opt"><?php echo $this->lang->line("work_as"); ?><span class="optional">(optional)</span></label>

                                        <input type="radio" tabindex="1" autofocus name="job_type" id="job_type" checked="checked" value="Full Time" <?php
                                        if ($job_type1 == 'Full Time') {
                                            echo 'checked';
                                        }
                                        ?>><?php echo $this->lang->line("full_time"); ?>
                                        <input type="radio" tabindex="1" name="job_type" id="job_type" value="Part Time" <?php
                                        if ($job_type1 == 'Part Time') {
                                            echo 'checked';
                                        }
                                        ?>><?php echo $this->lang->line("part_time"); ?>
                                               <?php echo form_error('job_type'); ?>
                                    </fieldset>
                                    <fieldset class=""<?php if ($work_hour) { ?> class="error-msg" <?php } ?>>
                                        <label><?php echo $this->lang->line("working_hours_week"); ?>:<span class="optional">(optional)</span></label>
                                        <input type="text" name="work_hour" tabindex="2" placeholder="Enter working hour" value="<?php
                                        if ($work_hour1) {
                                            echo $work_hour1;
                                        }
                                        ?>">
                                               <?php echo form_error('work_hour'); ?>
                                    </fieldset>
                                    <fieldset class="hs-submit full-width">
                                      <!--   <input type="submit"  id="next" name="next" value="Next" tabindex="3"> -->

                                       <button id="next" name="next" tabindex="3" onclick="return validate();">Next<span class="ajax_load pl10" id="profilereg_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>

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

        </script>
        <?php
        if (IS_APPLY_JS_MINIFY == '0') {
            ?>
            <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_post_avability.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_apply_common.js?ver=' . time()); ?>"></script>
            <?php
        } else {
            ?>
            <script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-apply/freelancer_post_avability.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-apply/freelancer_apply_common.js?ver=' . time()); ?>"></script>
        <?php } ?>


    </body>

</html>