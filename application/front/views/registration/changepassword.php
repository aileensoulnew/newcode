<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>  
         <?php
if(IS_OUTSIDE_CSS_MINIFY == '0'){
?>
     <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver='.time()); ?>">
<?php } else{ ?>
      <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver='.time()); ?>">
<?php } ?>
    
       
    </head>
    <style type="text/css">
          .common-form fieldset select:focus{ border: 1px solid #1b8ab9 !important;
color: #1b8ab9 !important;}
    </style>
    <!-- start header -->
    <?php echo $header; ?>
    <!-- END HEADER -->
    <body>
        <div class="padd_set">
            <div class="container">
                <div class="row">
                    <div class=" ">
                        <div class="col-lg-3 col-md-4 col-sm-4">
                            <div class="padd_set">
                                <div class="left-side-bar">
                                    <ul class="left-form-each">
                                        <li>  <a href="<?php echo base_url() . 'profile' ?>">Edit Profile</a></li>
                                        <li  <?php if ($this->uri->segment(2) == 'changepassword') { ?> class="active init" <?php } ?>> <a href="<?php echo base_url('registration/changepassword') ?>">Change Password </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-8">
                              <div class="common-form">
                            <div class="change-password">
                                <div class="change-password-box">
                                    <h4>Change Password</h4>
                                    <?php echo form_open(base_url('registration/changepassword_insert'), array('id' => 'regform', 'name' => 'regform', 'class' => 'clearfix')); ?>
                                    <fieldset class="full-width">
                                        <label>Old Password <span style="color:red">*</span></label>
                                        <input tabindex="1" type="password" name="oldpassword"  id="oldpassword" placeholder="Old Password" /> <span id="password1-error"> </span>
                                        <?php
                                        if (isset($error_message1)) {
                                            echo $error_message1;
                                        }
                                        echo form_error('oldpassword');
                                        ?>
                                    </fieldset>
                                    <fieldset class="full-width">
                                        <label>New Password <span style="color:red">*</span></label>
                                        <input type="password" tabindex="2" name="password1"  id="password1" placeholder="New Password" /> <span id="password1-error"> </span>
                                        <?php echo form_error('password1'); ?>
                                    </fieldset>
                                    <fieldset class="full-width">
                                        <label>Confirm Password<span style="color:red">*</span></label>
                                        <input type="password" tabindex="3" name="password2"  id="password2" placeholder="Confirm Password" /> <span id="password2-error"> </span>
                                        <?php echo form_error('password2'); ?>
                                    </fieldset>
                                    <fieldset class="hs-submit full-width">
                                        <!-- <input type="reset"  value="Cancel" name="cancel"> -->
                                        <input type="submit" tabindex="4"  value="Save" name="submit">
                                    </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $login_footer ?>
        <?php echo $footer; ?>
  <?php
if(IS_OUTSIDE_JS_MINIFY == '0'){
?>
   <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()); ?>"></script>
<?php } else{ ?>
     <script src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver='.time()); ?>"></script>
<?php } ?>
       
<!-- validation for edit email formate form strat -->

<script>
                            $(document).ready(function () { 
                                $("#regform").validate({ 
                                    rules: {
                                        oldpassword: {
                                            required: true,
                                            remote: {
                                               url: "<?php echo site_url() . 'registration/check_password' ?>",
                                             type: "post",
                                              data: {
                                               oldpassword: function () {
                                                   return $("#oldpassword").val();
                                                },
                                            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                                              },
                                        },

                                        },
                                        password1: {
                                            required: true,
                                        },
                                        password2: {
                                            required: true,
                                            equalTo: "#password1"
                                        }
                                    },

                                    messages:
                                            {
                                                oldpassword: {
                                                    required: "Please enter old password",
                                                    remote: "Old password does not match"
                                                },
                                                password1: {
                                                    required: "Please enter new password",
                                                },
                                                password2: {
                                                    required: "Please enter confirm password",
                                                    equalTo: "Please enter the same password as above"
                                                },
                                        
                                            },
                                    
                                }); });
                                </script>
    </body>
</html>
