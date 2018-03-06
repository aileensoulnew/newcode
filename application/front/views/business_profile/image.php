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
            .header2{border-bottom-left-radius: 4px;border-bottom-right-radius: 4px; }
            .full-width  img{display: none;}
            #imageold {display: block;}
            #preview {display: none; height:100px; width:100px; margin: 0 auto;}
        </style>
    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push botton_footer">
        <?php echo $header; ?>
        <?php if ($business_common_data[0]['business_step'] == 4) { ?>
            <?php echo $business_header2_border; ?>
        <?php } ?>
    <body class="page-container-bg-solid page-boxed botton_footer">
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
                                    <li class="custom-none"><a href="<?php echo base_url('business-profile/business-information-update'); ?>">Business Information</a></li>

                                    <li class="custom-none"><a href="<?php echo base_url('business-profile/contact-information'); ?>">Contact Information</a></li>

                                    <li class="custom-none"><a href="<?php echo base_url('business-profile/description'); ?>">Description</a></li>

                                    <li <?php if ($this->uri->segment(1) == 'business-profile') { ?> class="active init" <?php } ?>><a href="#">Business Images</a></li>


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
                                <h3>Business Images</h3>

                                <?php echo form_open_multipart(base_url('business-profile/image-insert'), array('id' => 'businessimage', 'name' => 'businessimage', 'class' => 'clearfix')); ?>


                                <fieldset class="full-width">
                                    <label>Business images<span class="optional">(optional)</span>:</label>
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
        <?php echo $login_footer ?>
        <?php echo $footer; ?>
<?php if (IS_BUSINESS_JS_MINIFY == '0') { ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
        <?php } else { ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()) ?>"></script>
        <?php } ?>
        <script>
                                                        var base_url = '<?php echo base_url(); ?>';
                                                        var slug = '<?php echo $slugid; ?>';
        </script>
        <?php if (IS_BUSINESS_JS_MINIFY == '0') { ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/image.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
        <?php } else { ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/business-profile/image.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js_min/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
        <?php } ?>
    </body>
</html>