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
    <body class="page-container-bg-solid page-boxed pushmenu-push">
        <?php echo $header; ?>
        <?php if ($business_common_data[0]['business_step'] == 4) { ?>
            <?php echo $business_header2_border; ?>
        <?php } ?>
        <section>
            <div class="user-midd-section" id="paddingtop_fixed">
                <div class="common-form1">
                    <div class="col-md-3 col-sm-4"></div>
                    <?php
                    $userid = $this->session->userdata('aileenuser');

                    $contition_array = array('user_id' => $userid, 'status' => '1');
                    $busdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    if ($busdata[0]['business_step'] == 4) {
                        ?>
                        <div class="col-md-6 col-sm-8"><h3><?php echo $this->lang->line("bus_reg_edit_title"); ?></h3></div>
                    <?php } else {
                        ?>
                        <div class="col-md-6 col-sm-8"><h3><?php echo $this->lang->line("bus_reg_title"); ?></h3></div>
                    <?php } ?>

                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-4">
                            <div class="left-side-bar">
                                <ul class="left-form-each">
                                    <li <?php if ($this->uri->segment(1) == 'business_profile') { ?> class="active init business_info_li" <?php } ?>><a href="javascrit:void(0);"><?php echo $this->lang->line("business_information"); ?></a></li>
                                    <li class="custom-none contact_info_li <?php
                                    if ($business_common_data[0]['business_step'] < '1') {
                                        echo "active";
                                    }
                                    ?>"><a href="javascript:void(0);"><?php echo $this->lang->line("contact_information"); ?></a></li>

                                    <li class="custom-none description_li <?php
                                    if ($business_common_data[0]['business_step'] < '2') {
                                        echo "active";
                                    }
                                    ?>"><a href="javascript:void(0);"><?php echo $this->lang->line("description"); ?></a></li>

                                    <li class="custom-none bus_image_li <?php
                                    if ($business_common_data[0]['business_step'] < '3') {
                                        echo "active";
                                    }
                                    ?>"><a href="javascript:void(0);"><?php echo $this->lang->line("business_images"); ?></a></li>

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
                            <div class="common-form common-form_border business-info-form-edit">
                                <h3>
                                    <?php echo $this->lang->line("business_information"); ?>
                                </h3>
                                <?php echo form_open(base_url('business-profile/business-information-insert'), array('id' => 'businessinfo', 'name' => 'businessinfo', 'class' => 'clearfix')); ?>
                                <div>
                                    <span style="color:#7f7f7e;padding-left: 8px;">( </span><span style="color:red">*</span><span style="color:#7f7f7e"> )</span> <span style="color:#7f7f7e">Indicates required field</span>
                                </div>
                                <?php
                                $companyname = form_error('companyname');
                                $country = form_error('country');
                                $state = form_error('state');

                                $business_address = form_error('business_address');
                                ?>
                                <fieldset class="full-width" <?php if ($companyname) { ?> class="error-msg" <?php } ?>>
                                    <label><?php echo $this->lang->line("company_name"); ?>:<span style="color:red">*</span></label>
                                    <input name="companyname" tabindex="1" autofocus type="text" id="companyname" placeholder="<?php echo $this->lang->line("enter_company_name"); ?>" value="<?php
                                    if ($business_data[0]['company_name']) {
                                        echo $business_data[0]['company_name'];
                                    }
                                    ?>"/>
                                           <?php echo form_error('companyname'); ?>
                                </fieldset>
                                <fieldset <?php if ($country) { ?> class="error-msg" <?php } ?>>
                                    <label><?php echo $this->lang->line("country"); ?>:<span style="color:red">*</span></label>
                                    <select name="country" id="country" tabindex="2" >
                                        <option value=""><?php echo $this->lang->line("country"); ?></option>
                                        <?php
                                        if (count($countries) > 0) {
                                            foreach ($countries as $cnt) {

                                                if ($business_data[0]['country']) {
                                                    ?>
                                                    <option value="<?php echo $cnt['country_id']; ?>" <?php if ($cnt['country_id'] == $business_data[0]['country']) echo 'selected'; ?>><?php echo $cnt['country_name']; ?></option>

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
                                    </select><span id="country-error"></span>
                                    <?php echo form_error('country'); ?> 
                                </fieldset>

                                <fieldset <?php if ($state) { ?> class="error-msg" <?php } ?>>
                                    <label><?php echo $this->lang->line("state"); ?>:<span style="color:red">*</span></label>
                                    <select name="state" id="state" tabindex="3" >
                                        <?php
                                        foreach ($states as $cnt) {
                                            if ($business_data[0]['state']) {
                                                ?>
                                                <option value="<?php echo $cnt['state_id']; ?>" <?php if ($cnt['state_id'] == $business_data[0]['state']) echo 'selected'; ?>><?php echo $cnt['state_name']; ?></option>
                                                <?php
                                            }
                                            else {
                                                ?>
                                                <option value=""><?php echo $this->lang->line("select_country_first"); ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select><span id="state-error"></span>
                                    <?php echo form_error('state'); ?>
                                </fieldset>
                                <fieldset>
                                    <label> <?php echo $this->lang->line("city"); ?>:</label>
                                    <select name="city" id="city" tabindex="4" >
                                        <?php
                                        if ($business_data[0]['city']) {
                                            foreach ($cities as $cnt) {
                                                ?>

                                                <option value="<?php echo $cnt['city_id']; ?>" <?php if ($cnt['city_id'] == $business_data[0]['city']) echo 'selected'; ?>><?php echo $cnt['city_name']; ?></option>

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
                                            <option value=""><?php echo $this->lang->line("select_state_first"); ?></option>

                                        <?php }
                                        ?>
                                    </select><span id="city-error"></span>

                                </fieldset>
                                <fieldset>
                                    <label><?php echo $this->lang->line("pincode"); ?>:</label>
                                    <input name="pincode" tabindex="5"   type="text" id="pincode" placeholder="<?php echo $this->lang->line("enter_pincode"); ?>" value="<?php
                                    if ($business_data[0]['pincode']) {
                                        echo $business_data[0]['pincode'];
                                    }
                                    ?>">

                                </fieldset>


                                <fieldset <?php if ($business_address) { ?> class="error-msg" <?php } ?> class="full-width">
                                    <label><?php echo $this->lang->line("postal_address"); ?>:<span style="color:red">*</span></label>
                                    <textarea name ="business_address" tabindex="6"  id="business_address" rows="4" cols="50" placeholder="<?php echo $this->lang->line("enter_address"); ?>" style="resize: none;"><?php
                                        if ($business_data[0]['address']) {
                                            echo $business_data[0]['address'];
                                        }
                                        ?></textarea>
                                    <?php echo form_error('business_address'); ?>
                                </fieldset>
                                <fieldset class="hs-submit full-width">
                                    <input type="submit"  id="next" name="next" tabindex="7"  value="<?php echo $this->lang->line("next"); ?>">
                                </fieldset>
                                </form>
                            </div>

                            <div class="common-form common-form_border contact-info-form-edit">
                                <h3>
                                    Contact Information
                                </h3>

                                <?php echo form_open(base_url('business-profile/contact-information-insert'), array('id' => 'contactinfo', 'name' => 'contactinfo', 'class' => 'clearfix')); ?>

                                <div>
                                    <span style="color:#7f7f7e;padding-left: 8px;">( </span><span style="color:red">*</span><span style="color:#7f7f7e"> )</span> <span style="color:#7f7f7e">Indicates required field</span>
                                </div>

                                <?php
                                $contactname = form_error('contactname');
                                $contactmobile = form_error('contactmobile');
                                $contactemail = form_error('email');
                                $contactwebsite = form_error('contactwebsite');
                                ?>
                                <fieldset <?php if ($contactname) { ?> class="error-msg" <?php } ?>>
                                    <label>Contact Person:<span style="color:red">*</span></label>
                                    <input name="contactname" tabindex="1" autofocus type="text" id="contactname" placeholder="Enter Contact Name" value="<?php
                                    if ($business_data[0]['contact_person']) {
                                        echo $business_data[0]['contact_person'];
                                    }
                                    ?>"/>
                                           <?php echo form_error('contactname'); ?>
                                </fieldset>


                                <fieldset <?php if ($contactmobile) { ?> class="error-msg" <?php } ?>>
                                    <label>Contact Mobile:<span style="color:red">*</span></label>
                                    <input name="contactmobile" type="text" tabindex="2"  id="contactmobile" placeholder="Enter Contact Mobile" value="<?php
                                    if ($business_data[0]['contact_mobile']) {
                                        echo $business_data[0]['contact_mobile'];
                                    }
                                    ?>"/>
                                           <?php echo form_error('contactmobile'); ?> 
                                </fieldset>



                                <fieldset <?php if ($contactemail) { ?> class="error-msg" <?php } ?>>
                                    <label>Contact Email:<span style="color:red">*</span></label>
                                    <input name="email" type="text" id="email" tabindex="3"  placeholder="Enter Contact Email" value="<?php
                                    if ($business_data[0]['contact_email']) {
                                        echo $business_data[0]['contact_email'];
                                    }
                                    ?>"/>
                                           <?php echo form_error('email'); ?>
                                </fieldset>


                                <fieldset>
                                    <label>Contact Website:</label>
                                    <input name="contactwebsite" type="url" id="contactwebsite" tabindex="4"  placeholder="Enter Contact website" value="<?php
                                    if ($business_data[0]['contact_website']) {
                                        echo $business_data[0]['contact_website'];
                                    }
                                    ?>"/>
                                    <span class="website_hint" style="font-size: 13px; color: #1b8ab9;">Note : <i>Enter website url with http or https</i></span>                                 
                                </fieldset>


                                <fieldset class="hs-submit full-width">



                                    <input tabindex="5"  type="submit"  id="next" name="next" value="Next">


                                </fieldset>

                                </form>
                            </div>

                            <div class="common-form common-form_border description-form-edit">
                                <h3>
                                    Description
                                </h3>
                                <?php echo form_open(base_url('business-profile/description-insert'), array('id' => 'businessdis', 'name' => 'businessdis', 'class' => 'clearfix')); ?>
                                <div>
                                    <span style="color:#7f7f7e;padding-left: 8px;">( </span><span style="color:red">*</span><span style="color:#7f7f7e"> )</span> <span style="color:#7f7f7e">Indicates required field</span>
                                </div>
                                <?php
                                $business_type = form_error('business_type');
                                $industriyal = form_error('industriyal');
                                $subindustriyal = form_error('subindustriyal');
                                $business_details = form_error('business_details');
                                ?> 
                                <fieldset <?php if ($business_type) { ?> class="error-msg" <?php } ?>>
                                    <label>Business Type:<span style="color:red">*</span></label>
                                    <select name="business_type" tabindex="1" autofocus id="business_type" onchange="busSelectCheck(this);">
                                        <?php
                                        if ($business_data[0]['business_type']) {
                                            $businessname = $this->db->get_where('business_type', array('type_id' => $business_data[0]['business_type']))->row()->business_name;
                                            ?>
                                            <option value="<?php echo $business_type1; ?>"><?php echo $businessname; ?></option>
                                            <?php
                                            foreach ($businesstypedata as $cnt) {
                                                ?>
                                                <option value="<?php echo $cnt['type_id']; ?>"><?php echo $cnt['business_name']; ?></option>

                                            <?php } ?>
                                            <option id="busOption" value="0" <?php
                                            if ($business_data[0]['business_type'] == 0) {
                                                echo "selected";
                                            }
                                            ?>>Other</option>
                                                    <?php
                                                } else {
                                                    if (count($businesstypedata) > 0) {
                                                        ?>
                                                <option value="" <?php
                                                if ($business_data[0]['business_type'] == '') {
                                                    echo "selected";
                                                }
                                                ?>>Select Business Type</option>
                                                        <?php foreach ($businesstypedata as $cnt) {
                                                            ?>

                                                    <option value="<?php echo $cnt['type_id']; ?>"><?php echo $cnt['business_name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <option id="busOption" value="0" <?php
                                            if ($business_data[0]['business_type'] == '0') {
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
                                        <!-- <option id="indOption" value="0" <?php
                                        if ($business_data[0]['industriyal'] == 0) {
                                            echo "selected";
                                        }
                                        ?>>Any Other</option> -->  
                                        <?php
                                        if ($business_data[0]['industriyal']) {
                                            $industryname = $this->db->get_where('industry_type', array('industry_id' => $business_data[0]['industriyal']))->row()->industry_name;
                                            ?>
                                            <option value="<?php echo $business_data[0]['industriyal']; ?>"><?php echo $industryname; ?></option>
                                            <?php
                                            foreach ($industriyaldata as $cnt) {
                                                ?>
                                                <option value="<?php echo $cnt['industry_id']; ?>"><?php echo $cnt['industry_name']; ?></option>
                                            <?php }
                                            ?>
                                            <option id="indOption" value="0" <?php
                                            if ($business_data[0]['industriyal'] == 0) {
                                                echo "selected";
                                            }
                                            ?>>Other</option>  
                                                    <?php
                                                } else {
                                                    ?>
                                            <option value="" <?php
                                            if ($business_data[0]['industriyal'] == '') {
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
                                            if ($business_data[0]['industriyal'] == '0') {
                                                echo "selected";
                                            }
                                            ?>>Other</option>

                                        <?php }
                                        ?>
                                    </select>

                                    <?php echo form_error('industriyal'); ?>
                                </fieldset>
                                <div id="busDivCheck" <?php if ($business_type1 != 0 || $business_type1 == '') { ?>style="display:none" <?php } ?>>
                                    <fieldset <?php if ($subindustrial) { ?> class="error-msg" <?php } ?> class="half-width" id="other-business">
                                        <label> Other Business Type: <span style="color:red;" >*</span></label>
                                        <input type="text" name="bustype"  tabindex="3"  id="bustype" value="<?php echo $other_business; ?>" style="<?php
                                        if ($business_type1 != 0 && $business_type1 == '') {
                                            echo 'display: none';
                                        }
                                        ?>" required="">
                                               <?php echo form_error('subindustriyal'); ?>
                                    </fieldset>
                                </div>
                                <div id="indDivCheck" <?php if ($business_data[0]['industriyal'] != 0 || $business_data[0]['industriyal'] == '') { ?>style="display:none" <?php } ?>>
                                    <fieldset <?php if ($subindustrial) { ?> class="error-msg" <?php } ?> class="half-width" id="other-category">
                                        <?php if ($business_data[0]['industriyal'] == 0) { ?>    <!--  <label id="indtype">Add Here Your Other Category type:<span style="color:red">*</span></label> --> <?php } ?>
                                        <label> Other Category:<span style="color:red;" >*</span></label>
                                        <input type="text" name="indtype" id="indtype" tabindex="4"  value="<?php echo $other_industry; ?>" 
                                               style="<?php
                                               if ($business_data[0]['industriyal'] != 0) {
                                                   echo 'display: none';
                                               }
                                               ?>" required="">
                                               <?php echo form_error('subindustriyal'); ?>
                                    </fieldset>
                                </div>
                                <fieldset <?php if ($business_details) { ?> class="error-msg" <?php } ?> class="full-width">
                                    <label>Details of your business:<span style="color:red">*</span></label>
                                    <textarea name="business_details" id="business_details" rows="4" tabindex="5"  cols="50" placeholder="Enter Business Detail" style="resize: none;"><?php
                                        if ($business_data[0]['details']) {
                                            echo $business_data[0]['details'];
                                        }
                                        ?></textarea>
                                    <?php echo form_error('business_details'); ?>
                                </fieldset>
                                <fieldset class="hs-submit full-width">
                                    <input type="submit"  id="next" name="next" value="Next" tabindex="6" >
                                </fieldset>
                                </form>
                            </div>
                            <div class="common-form common-form_border bus-image-form-edit"> 
                                <h3>Business Images</h3>
                                <?php echo form_open_multipart(base_url('business-profile/image-insert'), array('id' => 'businessimage', 'name' => 'businessimage', 'class' => 'clearfix')); ?>
                                <fieldset class="full-width">
                                    <label>Business Images:</label>
                                    <input type="file" tabindex="1" onclick = "removemsg()" onchange="validate(event)" autofocus name="image1[]" id="image1" multiple/> 
                                    <div class="bus_image" style="color:#f00; display: block;"></div> 
                                    <?php
                                    if (count($busimage) > 0) {
                                        $y = 0;
                                        foreach ($busimage as $image) {
                                            $y = $y + 1;
                                            ?>
                                            <div class="job_work_edit_<?php echo $image['bus_image_id'] ?>" id="image_main">
                                                <input type="hidden" name="filedata[]" id="filename" value="old">
                                                <input type="hidden" name="filename[]" id="filename" value="<?php echo $image['image_name']; ?>">
                                                <input type="hidden" name="imageid[]" id="filename" value="<?php echo $image['bus_image_id']; ?>">

                                                <div class="img_bui_data"> 
                                                    <div class="edit_bui_img">
                                                        <img id="imageold" src="<?php echo BUS_DETAIL_THUMB_UPLOAD_URL . $image['image_name'] ?>" >
                                                    </div>

                                                    <?php
                                                    ?>
                                                    <div style="float: left;">
                                                        <div class="hs-submit full-width fl">
                                                            <a href="javascript:void(0);" class="click_close_icon" onclick="delete_job_exp(<?php echo $image['bus_image_id']; ?>);">
                                                                <div class="bui_close">
                                                                    <label for="bui_img_delete"><i class="fa fa-times" aria-hidden="true"></i></label>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </fieldset>
                                <fieldset class="hs-submit full-width">
                                    <input type="submit"  id="submit" name="submit" tabindex="2"  value="Submit">
                                </fieldset>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <?php echo $footer; ?>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var slug = '<?php echo $slugid; ?>';

            var company_name_validation = '<?php echo $this->lang->line('company_name_validation') ?>';
            var country_validation = '<?php echo $this->lang->line('country_validation') ?>';
            var state_validation = '<?php echo $this->lang->line('state_validation') ?>';
            var address_validation = '<?php echo $this->lang->line('address_validation') ?>';
        </script>
        <?php if (IS_BUSINESS_JS_MINIFY == '0') { ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
            <script type = "text/javascript" src="<?php echo base_url('assets/js/jquery.form.3.51.js?ver=' . time()) ?>"></script> 
            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/edit_profile.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
        <?php } else { ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()) ?>"></script>
            <script type = "text/javascript" src="<?php echo base_url('assets/js_min/jquery.form.3.51.js?ver=' . time()) ?>"></script> 
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/business-profile/edit_profile.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js_min/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
        <?php } ?>
    </body>
</html>
