<!DOCTYPE html>
<html lang="en">
    <head>
        <title>New Password - Aileensoul</title>
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png'); ?>">
        <meta name="robots" content="noindex, nofollow">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
     <?php
if(IS_OUTSIDE_CSS_MINIFY == '0'){
?>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver='.time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver='.time()); ?>">
<?php } else{ ?>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/common-style.css?ver='.time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css?ver='.time()); ?>">
<?php } ?>
       
    </head>
    <body class="contact">

        <div class="main-inner">

            <?php echo $forgetpassword_header; ?>
          <section class="middle-main">
    <div class="container">
      <div class="form-pd row">
<?php echo form_open(base_url('profile/new_forgetpassword/' . $userid), array('id' => 'newpassword','name' => 'newpassword', 'class' => 'clearfix')); ?>

 <div class="inner-form login-frm otp_lform">
          <div class="login fw">
<!-- main box -->
          <div class="main_otp_box fw">

<!-- header small -->
          <div class="main_otp_box_head">
            <h3 class="text-center">Create a new password </h3>
          </div>
<!-- header small -->

<!-- middele data -->
      <div class="main_otp_box_middle">
 Enter your new password here. It should be a combination of letter,numerical and special character


 <div class="main_otp_box_middle_submit">
   <label>New Password</label>
 <input type="password" name="new_password" id="new_password" value="" placeholder="Enter new password">
<span>
<a href="javascript:void(0);" onclick="toggle_password('new_password');" id="showhide">Show</a>
</span>
 </div>
</div>

<!-- middele data -->


<div class="otp_bottom fw">

<div class="fr otp_bottom_submit"> 
 <input type="submit" name="submitnew" id="submitnew" value="Save">
 <input type="submit" name="" id="cancel" class="cancel_password" value="Cancel">
 </div>
  
</div>

</div>
<!-- main box -->

</div>
</div>
  <?php echo form_close(); ?>
    </div>
    </div>
</div>
</section>
</div>
</body>
</html>

<?php
if(IS_OUTSIDE_JS_MINIFY == '0'){
    
?>
  <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js') ?>"></script>

<?php } else{ ?>
   <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js') ?>"></script>

<?php } ?>
<script type="text/javascript">
$(document).ready(function () { 
          /* validation */
          $("#newpassword").validate({
              rules: {
                  new_password: {
                      required: true,
                        }
                      },
            messages:  {
                    new_password: {
                    required: "Password Is Required.",
                      }
                   },
              errorPlacement: function(error, element) {
                 error.insertAfter("#showhide");
              }
                });
            /* validation */
                                    
          });
</script>

<script type="text/javascript">
  
  function toggle_password(target){
    var d = document;
    var tag = d.getElementById(target);
    var tag2 = d.getElementById("showhide");

    if (tag2.innerHTML == 'Show'){
        tag.setAttribute('type', 'text');   
        tag2.innerHTML = 'Hide';

    } else {
        tag.setAttribute('type', 'password');   
        tag2.innerHTML = 'Show';
    }
}

</script>