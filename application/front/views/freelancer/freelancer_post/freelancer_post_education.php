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


        <!-- This Css is used for call popup -->

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
                        <?php } else { ?>
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

                                        <li class="custom-none"><a title="Avability" href="<?php echo base_url('freelance-work/avability'); ?>"><?php echo $this->lang->line("add_avability"); ?></a></li>
                                        <li <?php if ($this->uri->segment(1) == 'freelance-work') { ?> class="active init" <?php } ?>><a title="Education" href="javascript:void(0);"><?php echo $this->lang->line("education"); ?></a></li>	

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
                                    <h3><?php echo $this->lang->line("education_info"); ?></h3>
                                    <?php echo form_open(base_url('freelancer/freelancer_post_education_insert'), array('id' => 'freelancer_post_education', 'name' => 'freelancer_post_education', 'class' => 'clearfix')); ?>
                                    <?php
                                    $degree = form_error('degree');
                                    $stream = form_error('stream');
                                    $univercity = form_error('univercity');
                                    $collage = form_error('collage');
                                    $percentage = form_error('percentage');
                                    $passingyear = form_error('passingyear');
                                    $address = form_error('address');
                                    ?>
                                    <fieldset <?php if ($degree) { ?> class="error-msg" <?php } ?>>


                                        <?php if ($livepostid) { ?>
                                            <input type="hidden" name="livepostid" id="livepostid" tabindex="5"  value="<?php echo $livepostid; ?>">
                                        <?php }
                                        ?>

                                        <label><?php echo $this->lang->line("higher_degree"); ?>:<span class="optional">(optional)</span></label>

                                        <select name="degree" tabindex="1" autofocus id="degree">
                                            <option value="">Select your degree</option>
                                            <?php
                                            if (count($degree_data) > 0) {
                                                foreach ($degree_data as $cnt) {
                                                    if ($degree1) {
                                                        ?>
                                                        <option value="<?php echo $cnt['degree_id']; ?>" <?php if ($cnt['degree_id'] == $degree1) echo 'selected'; ?>><?php echo $cnt['degree_name']; ?></option>

                                                        <?php
                                                    }
                                                    else {
                                                        ?>
                                                        <option value="<?php echo $cnt['degree_id']; ?>"><?php echo $cnt['degree_name']; ?></option>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                            <option value="<?php echo $degree_otherdata[0]['degree_id']; ?> "><?php echo $degree_otherdata[0]['degree_name']; ?></option>
                                        </select>
                                        <?php echo form_error('degree'); ?>
                                    </fieldset>
                                    <?php
                                    $contition_array = array('is_delete' => '0', 'degree_id' => $degree1);
                                    $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
                                    $stream_data = $this->data['$stream_data'] = $this->common->select_data_by_search('stream', $search_condition, $contition_array, $data = '*', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = 'stream_name');
                                    ?>
                                    <fieldset <?php if ($stream) { ?> class="error-msg" <?php } ?>>
                                        <label><?php echo $this->lang->line("stream"); ?>:<span class="optional">(optional)</span></label>
                                        <select name="stream" id="stream" tabindex="2">
                                            <?php
                                            if ($stream1) {
                                                foreach ($stream_data as $cnt) {
                                                    ?>
                                                    <option value="<?php echo $cnt['stream_id']; ?>" <?php if ($cnt['stream_id'] == $stream1) echo 'selected'; ?>><?php echo $cnt['stream_name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            else {
                                                ?>
                                                <option value=""><?php echo $this->lang->line("select_degree"); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <?php echo form_error('stream'); ?>  
                                    </fieldset>
                                    <fieldset <?php if ($univercity) { ?> class="error-msg" <?php } ?>>
                                        <label><?php echo $this->lang->line("university"); ?>:<span class="optional">(optional)</span></label>
                                        <select name="university" id="university" tabindex="3" class="university_1">
                                            <option value="" selected option disabled>Select your University</option>
                                            <?php
                                            if (count($university_data) > 0) {
                                                foreach ($university_data as $cnt) {
                                                    if ($university1) {
                                                        ?>
                                                        <option value="<?php echo $cnt['university_id']; ?>" <?php if ($cnt['university_id'] == $university1) echo 'selected'; ?>><?php echo $cnt['university_name']; ?></option>
                                                        <?php
                                                    }
                                                    else {
                                                        ?>
                                                        <option value="<?php echo $cnt['university_id']; ?>"><?php echo $cnt['university_name']; ?></option>

                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                            <option value="<?php echo $university_otherdata[0]['university_id']; ?> "><?php echo $university_otherdata[0]['university_name']; ?></option>
                                        </select>
                                        <?php echo form_error('university'); ?> 
                                    </fieldset>
                                    <fieldset <?php if ($college) { ?> class="error-msg" <?php } ?>>
                                        <label><?php echo $this->lang->line("college"); ?>:<span class="optional">(optional)</span></label>
                                        <input type="text" name="college" id="college" tabindex="4" placeholder="Enter college"  value="<?php
                                        if ($college1) {
                                            echo $college1;
                                        }
                                        ?>">
                                               <?php echo form_error('college'); ?> 
                                    </fieldset>
                                    <fieldset <?php if ($percentage) { ?> class="error-msg" <?php } ?>>
                                        <label><?php echo $this->lang->line("percentage"); ?>:<span class="optional">(optional)</span></label>
                                        <input type="text" name="percentage" placeholder="Enter percentage" tabindex="5" value="<?php
                                        if ($percentage1) {
                                            echo $percentage1;
                                        }
                                        ?>">
                                               <?php echo form_error('percentage'); ?>
                                    </fieldset>
                                    <fieldset <?php if ($passingyear) { ?> class="error-msg" <?php } ?>>
                                        <label><?php echo $this->lang->line("year_passing"); ?>:<span class="optional">(optional)</span></label>
                                        <select name="passingyear" tabindex="6">
                                            <option value="" selected option disabled><?php echo $this->lang->line("year_passing"); ?></option>
                                            <?php
                                            $curYear = date('Y');
                                            for ($i = $curYear; $i >= 1900; $i--) {
                                                if ($pass_year1) {
                                                    ?>
                                                    <option value="<?php echo $i ?>" <?php if ($i == $pass_year1) echo 'selected'; ?>><?php echo $i ?></option>
                                                    <?php
                                                }
                                                else {
                                                    ?>
                                                    <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                                    <?php
                                                }
                                            }
                                            ?> 
                                        </select> 
                                        <?php echo form_error('passingyear'); ?>
                                    </fieldset>
                                    <fieldset class="hs-submit full-width">
                                       <!--  <input type="submit"  tabindex="7" id="next" name="next" value="Next"> -->
                                        <button id="next" name="next" tabindex="7" onclick="return validate();">Next<span class="ajax_load pl10" id="profilereg_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
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
                    <h2>Add University</h2> 
                    <input type="text" name="other_uni" id="other_uni" onkeypress="return remove_validation()">
                    <div class="fw"><a title="Ok" id="univer" class="btn">OK</a></div>
                    <!--                    </div>-->
                </div>
            </div>
        </div>
        <!-- Model Popup Close -->
        <!-- Bid-modal  -->
        <div class="modal fade message-box biderror custom-message cus-sel-col" id="bidmodal_degree" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content message2">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>
                    <h2>Add Degree</h2>         
                    <input type="text" name="other_degree" id="other_degree" onkeypress="return remove_validation()">
                    <h2>Add Stream</h2>
                    <select name="other_stream" id="other_stream" class="other_stream" onchange="return remove_validation1()">  <option value="" Selected option disabled>Select your Stream</option><?php foreach ($stream_alldata as $stream) { ?><option value="<?php echo $stream['stream_id']; ?>"><?php echo $stream['stream_name']; ?></option><?php } ?>  <option value="<?php echo $stream_otherdata[0]['stream_id']; ?> "><?php echo $stream_otherdata[0]['stream_name']; ?></option> </select>
                    <div class="fw text-center"><a title="Ok" id="univer2" class="btn">OK</a></div>
                </div>
            </div>
        </div>
        <!-- Model Popup Close -->
        <!-- Bid-modal  -->
        <div class="modal fade message-box biderror custom-message" id="bidmodal_stream" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content message1">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>
                    <h2>Add stream</h2> 
                    <input type="text" name="other_degree1" id="other_degree1" onkeypress="return remove_validation_stream()">
                    <div class="fw"><a title="Ok" id="univer1" class="btn">OK</a></div>
                </div>
            </div>
        </div>
        <!-- Model Popup Close -->
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
        <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_post_education.js?ver=' . time()); ?>"></script>
        <?php
        if (IS_APPLY_JS_MINIFY == '0') {
            ?>
            <!--<script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_post_education.js?ver=' . time()); ?>"></script>-->
            <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_apply_common.js?ver=' . time()); ?>"></script>
            <script  src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
            <?php
        } else {
            ?>
            <!--<script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-apply/freelancer_post_education.js?ver=' . time()); ?>"></script>-->
            <script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-apply/freelancer_apply_common.js?ver=' . time()); ?>"></script>
            <script  src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
        <?php } ?>


    </body>
</html>