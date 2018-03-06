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


        <style type="text/css">
            /* img{display: none;}*/
        </style>
    </head>
  
    <body class="botton_footer">
   
        <?php echo $header; ?>
        <?php
        if ($freepostdata['user_id'] && $freepostdata['free_post_step'] == '7') {
            echo $freelancer_post_header2_border;
        }
        ?>
        <section class="custom-row">
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
                                        <li class="custom-none"><a title="Avability" href="<?php echo base_url('freelance-work/avability'); ?>"><?php echo $this->lang->line("add_avability"); ?></a></li>
                                        <li class="custom-none"><a title="Education" href="<?php echo base_url('freelance-work/education'); ?>"><?php echo $this->lang->line("education"); ?></a></li>           
                                        <li <?php if ($this->uri->segment(1) == 'freelance-work') { ?> class="active init" <?php } ?>><a title="Portfolio" href="javascript:void(0);"><?php echo $this->lang->line("portfolio"); ?></a></li>
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
                                    <h3><?php echo $this->lang->line("portfolio"); ?></h3>
                                    <form name="freelancer_post_portfolio" method="post" id="freelancer_post_portfolio" 
                                          class="clearfix"  enctype="multipart/form-data" >
                                        <fieldset> 




                                            <label><?php echo $this->lang->line("attach"); ?>:<span class="optional">(optional)</span></label>

                                            <input type="file" name="portfolio_attachment" id="portfolio_attachment" class="portfolio_attachment" tabindex="1" autofocus placeholder="Portfolio attachment" multiple="" />&nbsp;&nbsp;&nbsp; 
                                            <span id ="filename" class="file_name_pdf"><?php echo $portfolio_attachment1; ?></span><span class="file_name"></span>
                                            <div class="portfolio_image" style="color:#f00; display: block;"></div>
                                            <?php if ($portfolio_attachment1) {  ?>
                                                <div style="visibility:show;" id ="pdffile">
                                                    <?php $userid = $this->session->userdata('aileenuser'); ?>
                                                    <a title="Pdf" href="<?php echo base_url('freelancer/pdf/' . $userid) ?>"><i class="fa fa-file-pdf-o fa-2x" style="color: red; padding-left: 8px; padding-top: 10px; padding-bottom: 10px; position: relative;" aria-hidden="true"></i></a>
                                                    <a title="Delete pdf" style="position: absolute; cursor:pointer;" onclick="delpdf();"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                </div>
                                            <?php } ?>
                                            <input type="hidden" tabindex="2" name="image_hidden_portfolio" id="image_hidden_portfolio" value="<?php
                                            if ($portfolio_attachment1) {
                                                echo $portfolio_attachment1;
                                            }
                                            ?>">
                                        </fieldset>   
                                        <fieldset class="full-width">
                                            <label><?php echo $this->lang->line("descri"); ?>:<span class="optional">(optional)</span></label>
                                            <div tabindex="2" style="width: 100%"  class="editable_text"  contenteditable="true" name ="portfolio" id="portfolio123" rows="4" cols="50" placeholder="Enter portfolio detail" style="resize: none;" onpaste="OnPaste_StripFormatting(this, event);"><?php
                                                if ($portfolio1) {
                                                    echo $portfolio1;
                                                }
                                                ?>
                                            </div>
                                            <?php echo form_error('portfolio'); ?> 
                                        </fieldset>
                                        <input type="hidden" tabindex="2" name="free_step" id="free_step" value="<?php echo $free_post_step; ?>">
                                        <fieldset class="hs-submit full-width">
                                            <!-- <input type="submit"  id="submit" tabindex="4" name="submit" value="Submit" onclick="return portfolio_form_submit(event);" > -->

                                             <button id="submit" name="submit" tabindex="4" onclick="return portfolio_form_submit(event);">Submit<span class="ajax_load pl10" id="profilereg_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>

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

    </script>
    <script>
        var base_url = '<?php echo base_url(); ?>';
        var postid = '<?php echo $livepostid; ?>';

        if (postid != '') {

            var prourl = "freelancer/freelancer_post_portfolio_insert/" + postid;
        } else {
            var prourl = "freelancer/freelancer_post_portfolio_insert";
        }

    </script>
    <?php
    if (IS_APPLY_JS_MINIFY == '0') {
        ?>
        <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_post_portfolio.js?ver=' . time()); ?>"></script>
        <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_apply_common.js?ver=' . time()); ?>"></script>
        <?php
    } else {
        ?>
        <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_post_portfolio.js?ver=' . time()); ?>"></script>
        <script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-apply/freelancer_apply_common.js?ver=' . time()); ?>"></script>
    <?php } ?>


</body>

</html>