
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Change Password - Aileensoul</title>
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png'); ?>">
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

 
<?php  
                                       if ($this->session->flashdata('error')) {
                                           echo '<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>';
                                       }
                                      
                                       
                                ?>

<?php echo form_open(base_url('profile/newpassword/'. $user_changeid), array('id' => 'codecheck','name' => 'codecheck', 'class' => 'clearfix')); ?>
 <div class="inner-form login-frm otp_lform">
          <div class="login fw">
<!-- main box -->
          <div class="main_otp_box fw">

<!-- header small -->
          <div class="main_otp_box_head">
            <h3 class="text-center">Enter Verification Code </h3>
          </div>
<!-- header small -->

<!-- middele data -->
      <div class="main_otp_box_middle">
  Please check your email for the verification code.Your verification code has been sent to 
  <a class="cus_em"><?php echo $emailid[0]['user_email'] ?></a>
 Please enter verification code here to verify your account.


 <div class="main_otp_box_middle_submit">
   
 <input type="text" name="code" id="code" value="" placeholder="Enter Code">
 </div>
</div>

<!-- middele data -->


<div class="otp_bottom fw">
<div class="fr otp_bottom_submit">  
<input type="submit" name="sublitcode" value="Continue" id="submitcode">
 <input type="reset" name="" id="cancel" class="cancel_password" value="Cancel">
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
          $("#codecheck").validate({
              rules: {
                  code: {
                      required: true,
                      minlength: 6,
                      maxlength: 6,
                      remote: {
                                      url: "<?php echo site_url() . 'profile/code_check/' . $user_changeid ?>",
                                      type: "post",
                                      data: {
                                     email_reg: function () {
                                        return $("#code").val();
                                    },
                                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                                },
                              },
                        }
                  
                        },
            messages:  {
                    code: {
                    required: "Code Is Required.",
                    minlength: "Your code is 6 character long",
                    maxlength: "Your code is 6 character long",
                    remote: "You enter some text doesn't match your code.Please try right code.",
                      }

                    
                   },
                });
            /* validation */
                                    
          });
</script>