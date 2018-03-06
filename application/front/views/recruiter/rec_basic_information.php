<!DOCTYPE html>
<html>
    <head>
        <title><?php  echo $title; ?></title>
        <?php echo $head; ?> 
        <?php
        if (IS_REC_CSS_MINIFY == '0') {
            ?>
           <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/recruiter.css'); ?>">
            <?php
        } else {
            ?>
           <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css'); ?>">
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

            
               <?php if ($recdata['re_step'] == 3) { ?>
         
            <div class="user-midd-section" id="paddingtop_fixed" >
                    <?php }else{ ?>
                <div class="user-midd-section" id="paddingtop_make_fixed">
                    <?php } ?>
                <div class="common-form1">
                    <div class="col-md-3 col-sm-4"></div>

                    <?php
                    if ($recdata['re_step'] == 3) {
                        ?>
                        <div class="col-md-6 col-sm-8"><h3>You are updating your Recruiter Profile.</h3></div>

                    <?php } else {
                        ?>
                        <div class="col-md-6 col-sm-8"><h3>You are making your Recruiter Profile.</h3></div>

                    <?php } ?>
                </div>

                <div class="container">
                    <div class="row row4">
                        <div class="col-md-3 col-sm-4">
                            <div class="left-side-bar">
                                <ul class="left-form-each">

                                    <li <?php if ($this->uri->segment(1) == 'recruiter') { ?> class="active init" <?php } ?>><a href="#" title="Basic Information">Basic Information</a></li>

                                    <li  class="custom-none <?php
                                    if ($recdata['re_step'] < '1') {
                                        echo "khyati";
                                    }
                                    ?>"><a href="<?php echo base_url('recruiter/company-information'); ?>" title="Company Information">Company Information</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-8">

                            <div>
                                <?php
                                if ($this->session->flashdata('error')) {
                                    echo '<div class="alert alert-success">' . $this->session->flashdata('error') . '</div>';
                                }
                                if ($this->session->flashdata('success')) {
                                    echo '<div class="alert alert-success">' . $this->session->flashdata('success') . '</div>';
                                }
                                ?>
                            </div>

                            <!--- middle section start -->
                            <div class="common-form common-form_border">
                                <h3>Basic Information</h3>
                                <?php echo form_open(base_url('recruiter/basic_information'), array('id' => 'basicinfo', 'name' => 'basicinfo', 'class' => 'clearfix')); ?>



                                <div> <span class="required_field" >( <span class="red">*</span> ) Indicates required field</span></div>

                                <div class="fw">
                                    <fieldset>
                                        <label>First Name<span class="red">*</span>:</label>
                                        <input name="first_name" tabindex="1" autofocus type="text" id="first_name"  placeholder="Enter First Name" value="<?php
                                        if ($firstname) {
                                            echo trim(ucfirst(strtolower($firstname)));
                                        } else {
                                            echo trim(ucfirst(strtolower($userdata[0]['first_name'])));
                                        }
                                        ?>" onfocus="var temp_value = this.value; this.value = ''; this.value = temp_value"/><span id="fullname-error "></span>
                                               <?php echo form_error('first_name'); ?>
                                    </fieldset>


                                    <fieldset>
                                        <label>Last Name<span class="red">*</span> :</label>
                                        <input name="last_name" type="text" tabindex="2" placeholder="Enter Last Name"
                                               value="<?php
                                               if ($lastname) {
                                                   echo trim(ucfirst(strtolower($lastname)));
                                               } else {
                                                   echo trim(ucfirst(strtolower($userdata[0]['last_name'])));
                                               }
                                               ?>" id="last_name" /><span id="fullname-error" ></span>
                                               <?php echo form_error('last_name'); ?>
                                    </fieldset>
                                </div>
                                <div class="fw">

                                    <fieldset class="vali_er">
                                        <label>Email address:<span class="red">*</span></label>
                                        <input name="email"  type="text" id="email" tabindex="3" placeholder="Enter Email"  value="<?php
                                        if ($email) {
                                            echo $email;
                                        } else {
                                            echo $userdata[0]['user_email'];
                                        }
                                        ?>" />
                                    <span class="email_note"><b>Note:-</b> Related notification email will be send on provided email address kindly use regular  email address.<div></div></span>                                
                                               <?php echo form_error('email'); ?>
                                    </fieldset>

                                    <fieldset>
                                        <label>Phone number:<span class="optional">(optional)</span></label>
                                        <input name="phoneno" placeholder="Enter Phone Number" tabindex="4" value="<?php
                                        if ($phone) {
                                            echo $phone;
                                        }
                                        ?>" type="text" id="phoneno"  /><span ></span>
                                               <?php echo form_error('phoneno'); ?>
                                    </fieldset>

                                </div>
                                <fieldset class="hs-submit full-width">


                                   <!--  <input type="submit"  id="next" name="next" tabindex="5" value="Next"> -->

                                     <button id="next" name="next" tabindex="5" onclick="return reg_loader();">Submit<span class="ajax_load pl10" id="profilereg_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>

                                </fieldset>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <?php echo $login_footer ?>
        <?php echo $footer; ?>
        <!-- END FOOTER -->

        <!-- FIELD VALIDATION JS START -->
        
        
        
        
        <script>
                                        var base_url = '<?php echo base_url(); ?>';
                                        var data1 = <?php echo json_encode($de); ?>;
                                        var data = <?php echo json_encode($demo); ?>;
                                        var get_csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
                                        var get_csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
        </script>
        <!-- FIELD VALIDATION JS END -->
         <?php
        if (IS_REC_JS_MINIFY == '0') {
            ?>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js') ?>"></script>
     <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/search.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/basic_info.js'); ?>"></script>
            <?php
        } else {
            ?>
        <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js') ?>"></script>
          <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/recruiter/search.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/recruiter/basic_info.js'); ?>"></script>
        <?php } ?>
       
    </body>
</html>