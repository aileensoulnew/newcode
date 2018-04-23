

<?php echo $head; ?>

<?php echo $header; ?>


<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
	<title>Reactivate</title>
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

<script type="text/javascript" src="<?php  echo base_url('assets/js/jquery-3.2.1.min.js?ver='.time()); ?>"></script>


   
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
		 <a href="<?php echo base_url('artistic/reactivate'); ?>">Yes</a>

		</div>
		<div class="reactivate_btn_n">
		  <a href="<?php echo base_url('dashboard'); ?>">No</a>
        </div>
          <script src="<?php echo base_url('assets/js/fb_login.js'); ?>"></script>

		</div>
           </center>
  </div>

</div>

</body>
</html>



