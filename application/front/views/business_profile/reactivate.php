<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $title ?></title>
        <?php echo $head; ?>
      
   <?php if (IS_BUSINESS_JS_MINIFY == '0') { ?>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<?php } else { ?>
     <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<?php } ?>
    </head>
    <body>
        <?php echo $header; ?>
        <div class="container" id="paddingtop_fixed">
            <div class="row">
                <center> 
                    <div class="reactivatebox">
                        <div class="reactivate_header">
                            <center><h2> Are you sure you want to reactive your business profile?</h2></center>
                        </div>
                        <div class="reactivate_btn_y">
                            <a href="<?php echo base_url('business_profile/reactivate'); ?>">Yes</a>
                        </div>
                        <div class="reactivate_btn_n">
                            <a href="<?php echo base_url('profiles/') . $this->session->userdata('aileenuser_slug'); ?>">No</a>
                        </div>
                    </div>
                </center>
            </div>
        </div>
        <?php echo $footer; ?>
    </body>
</html>