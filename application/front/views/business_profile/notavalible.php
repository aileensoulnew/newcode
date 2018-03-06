<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php echo $head; ?>
    </head>
    <body>
        <?php echo $header; ?>
        <?php echo $business_header2_border; ?>
        <div class="user-midd-section" id="paddingtop_fixed">
            <div class="container" id="paddingtop_fixed">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text_center">
                            <div class="sory_image">
                                <img src="<?php echo base_url('assets/img/sorry_img.png?ver=' . time()); ?>">
                            </div>
                            <div class="not_founde_head">Sorry !</div>
                            <div class="not_founde_head2">we coundn’t find any matches with your input.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $footer; ?>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var no_business_post_html = '<?php echo $no_business_post_html ?>';
        </script>

        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
    </body>
</html>