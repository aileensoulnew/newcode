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
                        if ($freepostdata[0]['free_post_step'] == 7) { ?>
                <div class="user-midd-section" id="paddingtop_fixed">
                        <?php }else { ?>
                     <div class="user-midd-section" id="paddingtop_make_fixed">
                        <?php }?>
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
                                        <li <?php if ($this->uri->segment(1) == 'freelance-work') { ?> class="active init" <?php } ?>><a title="Address Information" href="javascript:void(0);"><?php echo $this->lang->line("address_info"); ?></a></li>
                                        <li class="custom-none <?php
                                        if ($freepostdata[0]['free_post_step'] < '2') {
                                            echo "khyati";
                                        }
                                        ?>"><a href="<?php echo base_url('freelance-work/professional-information'); ?>"><?php echo $this->lang->line("professional_info"); ?></a></li>

                                        <li class="custom-none <?php
                                        if ($freepostdata[0]['free_post_step'] < '3') {
                                            echo "khyati";
                                        }
                                        ?>"><a title="Rate" href="<?php echo base_url('freelance-work/rate'); ?>"><?php echo $this->lang->line("rate"); ?></a></li>

                                        <li class="custom-none <?php
                                        if ($freepostdata[0]['free_post_step'] < '4') {
                                            echo "khyati";
                                        }
                                        ?>"><a title="Avability" href="<?php echo base_url('freelance-work/avability'); ?>"><?php echo $this->lang->line("add_avability"); ?></a></li>

                                        <li class="custom-none <?php
                                        if ($freepostdata[0]['free_post_step'] < '5') {
                                            echo "khyati";
                                        }
                                        ?>"><a title="Education" href="<?php echo base_url('freelance-work/education'); ?>"><?php echo $this->lang->line("education"); ?></a></li>		    
                                        <li class="custom-none <?php
                                        if ($freepostdata[0]['free_post_step'] < '6') {
                                            echo "khyati";
                                        }
                                        ?>"><a title="Portfolio" href="<?php echo base_url('freelance-work/portfolio'); ?>" class="custom-none"><?php echo $this->lang->line("portfolio"); ?></a></li>
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
                                    <?php echo form_open(base_url('freelancer/freelancer_post_address_information_insert'), array('id' => 'freelancer_post_addressinfo', 'name' => 'freelancer_post_addressinfo', 'class' => 'clearfix')); ?>
                                    
                                    <?php
                                    $country = form_error('country');
                                    $state = form_error('state');
                                    $city = form_error('city');
                                    $pincode = form_error('pincode');
                                    ?> 
                                    <fieldset <?php if ($country) { ?> class="error-msg" <?php } ?>>
                                        <?php     if ($livepostid) { ?>
                                         <input type="hidden" name="livepostid" id="livepostid" tabindex="5"  value="<?php echo $livepostid;?>">
                                    <?php    }
                                        ?>
                                        <label><?php echo $this->lang->line("country"); ?>:<span class="red">*</span></label>
                                        <select tabindex="1" autofocus name="country" id="country">
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
                                    <fieldset>
                                        <label><?php echo $this->lang->line("pincode"); ?>:<span class="optional">(optional)</span></label>
                                        <input type="text" name="pincode" tabindex="4" placeholder="Enter pincode" value="<?php
                                        if ($pincode1) {
                                            echo $pincode1;
                                        }
                                        ?>">
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
            <script  type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()) ?>"></script>
            <?php
        } else {
            ?>
           <script  type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver='.time()) ?>"></script>
        <?php } ?>

            <script>
                var base_url = '<?php echo base_url(); ?>';
              
            </script>
            <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_post_address_information.js?ver='.time()); ?>"></script>
            <?php
        if (IS_APPLY_JS_MINIFY == '0') {
            ?>
            <!--<script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_post_address_information.js?ver='.time()); ?>"></script>-->
             <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_apply_common.js?ver='.time()); ?>"></script>
            <?php
        } else {
            ?>
            <!--<script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-apply/freelancer_post_address_information.js?ver='.time()); ?>"></script>-->
             <script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-apply/freelancer_apply_common.js?ver='.time()); ?>"></script>
        <?php } ?>

        </body>
  
</html>