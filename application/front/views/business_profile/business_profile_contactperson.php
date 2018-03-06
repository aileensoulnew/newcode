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
    <body class="page-container-bg-solid page-boxed">
        <?php echo $header; ?>
        <?php echo $business_header2_border; ?>
        <section>
            <div class="user-midd-section" id="paddingtop_fixed">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-4">
                        </div> 
                        <div class="5col-md-6 col-sm-8">
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
                            <div>
                                <div>
                                </div> 
                                <div>
                                    <div class="business_pf_ct_person_form clearfix">
                                        <h3>Contact Person</h3> 
                                        <?php echo form_open_multipart(base_url('business_profile/business_profile_contactperson_query/' . $contactperson[0]['user_id']), array('id' => 'contactperson', 'name' => 'contactperson', 'class' => 'clearfix')); ?>
                                        <ul class="business_pf_ct_person_detail">
                                            <li><b>Comapny Name </b> <span><?php echo $contactperson[0]['company_name']; ?></span></li>
                                            <li><b>Contact Person </b><span><?php echo $contactperson[0]['contact_person']; ?></span></li>
                                            <li><b >Phone No </b><span><?php echo $contactperson[0]['contact_mobile']; ?></span></li>
                                            <li><b>WebSite </b><span><?php echo $contactperson[0]['contact_website']; ?></span></li>
                                            <li><b>Email Id </b><span> <?php echo $contactperson[0]['contact_email']; ?></span></li>
                                        </ul>
                                        <div class="business_pf_ct_ clearfix">
                                            <div class="buisness-contact-head"> <h2>Inquiry</h2></div>
                                            <fieldset >
                                                <label>Email Address</label>
                                                <input name="email"  type="text" id="email" placeholder="Enter Your Email Address" value="<?php echo $userdata[0]['user_email']; ?>">
                                                <input name="toemail"  type="hidden" id="toemail" placeholder="Enter Your Email Address" value="<?php echo $contactperson[0]['contact_email']; ?>">
                                                <?php echo form_error('email'); ?>
                                            </fieldset>
                                            <fieldset class="full-width">
                                                <label>Details</label>
                                                <textarea name="msg" id="msg" placeholder="Enter Query"></textarea>
                                                <?php echo form_error('msg'); ?>
                                            </fieldset>
                                            <fieldset class="hs-submit full-width">
                                                <input type="submit"  id="submitcontact" name="submitcontact" value="send">
                                            </fieldset>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <?php echo $footer; ?>
    </body>
</html>
<?php if (IS_BUSINESS_JS_MINIFY == '0') { ?>
    <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
<?php } else { ?>
    <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js_min/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
<?php } ?>