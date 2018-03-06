

<?php echo $head; ?>

<?php echo $header; ?>


<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
	<title><?php echo $artistic_name; ?> | Reactive |  Artistic Profile - Aileensoul</title>

	  <?php
        if (IS_ART_CSS_MINIFY == '0') {
            ?>

<link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver='.time()); ?>">
<!-- CSS START -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style_harshad.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/media.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/animate.css?ver='.time()) ?>" />

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/header.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css?ver='.time()); ?>">

<?php }else{?>


<link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver='.time()); ?>">
<!-- CSS START -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/common-style.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style_harshad.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/media.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/animate.css?ver='.time()) ?>" />

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/header.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/font-awesome.min.css?ver='.time()); ?>">

<?php } ?>

<?php
  if (IS_ART_JS_MINIFY == '0') { ?>
<script type="text/javascript" src="<?php  echo base_url('assets/js/jquery-3.2.1.min.js?ver='.time()); ?>"></script>
<?php }else{?>
<script type="text/javascript" src="<?php  echo base_url('assets/js_min/jquery-3.2.1.min.js?ver='.time()); ?>"></script>
<?php }?>

   
</head>
<body>


<div class="container" id="paddingtop_fixed">
  <div class="row">
          
          <center> 
		<div class="reactivatebox">
			
		<div class="reactivate_header">
		 <center><h2>Are you sure you want to reactive your artistic profile?</h2></center>
		</div>
		<div class="reactivate_btn_y">
		 <a href="<?php echo base_url('artist/reactivate'); ?>" title="Yes">Yes</a>

		</div>
		<div class="reactivate_btn_n">
		  <a href="<?php echo base_url('dashboard'); ?>" title="No">No</a>
        </div>

        <?php
  if (IS_ART_JS_MINIFY == '0') { ?>
          <script src="<?php echo base_url('assets/js/fb_login.js'); ?>"></script>

          <?php }else{?>
           <script src="<?php echo base_url('assets/js_min/fb_login.js'); ?>"></script>
          <?php }?>

		</div>
           </center>
  </div>

</div>

</body>
</html>



