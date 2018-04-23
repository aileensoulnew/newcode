<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>  
    </head>
    <Style>
    .profile_edit h3{text-align: center;}
    .common-form fieldset select:focus{ border: 1px solid #1b8ab9 !important;
color: #1b8ab9 !important;}
     </Style>
    }
    <body class="page-container-bg-solid page-boxed pushmenu-push">
        <?php echo $header; ?>
        <section>
            <div class="user-midd-section" id="paddingtop_fixed">
                <div class="container">
                    <div class="row">
                        <div class="">
                            <div class="col-lg-3 col-md-4 col-sm-4">
                                <div class="">
                                    <div class="left-side-bar" id="bs-collapse" >
                                        <ul class="left-form-each">
                                            <li  <?php if ($this->uri->segment(1) == 'profile') { ?> class="active init" <?php } ?>>  <a href="<?php echo base_url() . 'profile' ?>" data-toggle="collapse" data-parent="#bs-collapse" id="toggle">Edit Profile</a></li>
                                            <li> <a href="<?php echo base_url('registration/changepassword') ?>">Change Password</a></li>
                                             <li> <a href="#">Edit Basic Information</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7 col-sm-8">
                                <div class="common-form profile_edit main_form change-password-box">
                                    <h3>Edit Profile</h3>
                                    <?php echo form_open_multipart(base_url('profile/edit_profile'), array('id' => 'basicinfo', 'name' => 'basicinfo', 'class' => "clearfix common-form_border")); ?>
                                    <fieldset class="">
                                        <label >First Name </label>
                                        <input tabindex="1" name="first_name" type="text" placeholder="Firstname..." id="first_name" value="<?php echo $userdata['first_name'] ?>" onblur="return full_name();"/><span id="fullname-error"></span><?php echo form_error('first_name'); ?>
                                    </fieldset>
                                    <fieldset class="">
                                        <label>Last Name</label>
                                        <input tabindex="2" name="last_name" placeholder="Lastname...." type="text" id="last_name" value="<?php echo $userdata['last_name'] ?>" onblur="return full_name();"/><span id="fullname-error"></span>
                                        <?php echo form_error('last_name'); ?>
                                    </fieldset>
                                    <fieldset>           
                                        <label >E-mail Address:</label>
                                        <input name="email_profile" tabindex="4"  type="email" id="email_profile" placeholder="EmailAddress..."  value="<?php echo $userdata['email'] ?>"/><span id="email-error"></span> <?php echo form_error('email'); ?>
                                    </fieldset>
                                    <fieldset>        
                                        <label>Birthday:</label>
                                        <select tabindex="5" class="day" name="selday" id="selday">
                                            <option value="" disabled selected value>Day</option>
                                            <?php
                                            for ($i = 1; $i <= 31; $i++) {
                                                ?>
                                                <option value="<?php echo $i; ?>" <?php
                                                if ($i == $usrd) {
                                                    echo "selected";
                                                }
                                                ?>><?php echo $i; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                        </select>
                                        <select tabindex="6" class="month" name="selmonth" id="selmonth">
                                            <option value="" disabled selected value>Month</option>
                                            <option value="1" <?php
                                            if ($usrm == 1) {
                                                echo "selected";
                                            }
                                            ?>>Jan</option>
                                            <option value="2" <?php
                                            if ($usrm == 2) {
                                                echo "selected";
                                            }
                                            ?>>Feb</option>
                                            <option value="3" <?php
                                            if ($usrm == 3) {
                                                echo "selected";
                                            }
                                            ?>>Mar</option>
                                            <option value="4" <?php
                                            if ($usrm == 4) {
                                                echo "selected";
                                            }
                                            ?>>Apr</option>
                                            <option value="5" <?php
                                            if ($usrm == 5) {
                                                echo "selected";
                                            }
                                            ?>>May</option>
                                            <option value="6" <?php
                                            if ($usrm == 6) {
                                                echo "selected";
                                            }
                                            ?>>Jun</option>
                                            <option value="7" <?php
                                            if ($usrm == 7) {
                                                echo "selected";
                                            }
                                            ?>>Jul</option>
                                            <option value="8" <?php
                                            if ($usrm == 8) {
                                                echo "selected";
                                            }
                                            ?>>Aug</option>
                                            <option value="9" <?php
                                            if ($usrm == 9) {
                                                echo "selected";
                                            }
                                            ?>>Sep</option>
                                            <option value="10" <?php
                                            if ($usrm == 10) {
                                                echo "selected";
                                            }
                                            ?>>Oct</option>
                                            <option value="11" <?php
                                            if ($usrm == 11) {
                                                echo "selected";
                                            }
                                            ?>>Nov</option>
                                            <option value="12" <?php
                                            if ($usrm == 12) {
                                                echo "selected";
                                            }
                                            ?>>Dec</option>
                                            ?>
                                        </select>
                                        <select tabindex="7" class="year" name="selyear" id="selyear">
                                            <option value="" disabled selected value>Year</option>
                                            <?php
                                            for ($i = date('Y'); $i >= 1900; $i--) {
                                                ?>
                                                <option value="<?php echo $i; ?>" <?php
                                                if ($usry == $i) {
                                                    echo "selected";
                                                }
                                                ?>><?php echo $i; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                        </select>
                                        <div class="dateerror" style="color:#f00; display: block;"></div>

                                    </fieldset>

                                    <fieldset>
                                        <label>Gender</label>
                                        <input tabindex="8" type="radio" id="gen" name="gender" value="M" <?php
                                        if ($userdata['user_gender'] == M) {
                                            echo 'checked';
                                        }
                                        ?>>Male
                                        <input type="radio" id="gen" name="gender" value="F" <?php
                                        if ($userdata['user_gender'] == F) {
                                            echo 'checked';
                                        }
                                        ?>>Female

                                        <?php echo form_error('gender'); ?>
                                    </fieldset>
                                    <fieldset class="hs-submit full-width">
                                        <input type="submit" tabindex="9" value="submit" name="submit" id="submit">
                                    </fieldset>
                                </div>
                            
                                <div class="common-form profile_edit main_form change-password-box" style="margin-top:20px;">
                                    <h3>Edit Basic Information</h3>
                                    <form>
                                    <p class="student-or-not">If you are a student then <a href="educational-information">Click Here.</a></p>
                                    <fieldset class="fw">
                                        <label >Who are you?</label>
                                        <input tabindex="1" name="first_name" type="text" placeholder="Firstname..." id="first_name" value="<?php echo $userdata['first_name'] ?>" onblur="return full_name();"/><span id="fullname-error"></span><?php echo form_error('first_name'); ?>
                                    </fieldset>
                                    <fieldset class="fw">
                                        <label>Where are you from?</label>
                                        <input tabindex="2" name="last_name" placeholder="Lastname...." type="text" id="last_name" value="<?php echo $userdata['last_name'] ?>" onblur="return full_name();"/><span id="fullname-error"></span>
                                        <?php echo form_error('last_name'); ?>
                                    </fieldset>
                                    <fieldset class="fw">           
                                        <label >What is your field?</label>
                                        <select>
                                            <option>It Field</option>
                                            <option>It Field</option>
                                            <option>It Field</option>
                                            <option>It Field</option>
                                            <option>It Field</option>
                                        </select>
                                    </fieldset>
                                       </form>
                                </div>
                            </div>
                          
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Calender JS Start-->
         <footer> 
            <?php echo $login_footer ?>
            <?php echo $footer; ?>
         </footer> 
        <?php
if(IS_OUTSIDE_JS_MINIFY == '0'){
    
?>
   <script src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>
       
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.min.js"></script>
        
        </script>

<?php } else{ ?>
   <script src="<?php echo base_url('assets/js_min/jquery.js'); ?>"></script>
       
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js_min/jquery.validate.min.js"></script>
        
        </script>

<?php } ?>
       
        <!-- POST BOX JAVASCRIPT END --> 
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var get_csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
            var get_csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
        </script>
        
        <?php
if(IS_OUTSIDE_JS_MINIFY == '0'){
?>
    <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/profile/profile.js'); ?>"></script>
<?php } else{ ?>
   <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/profile/profile.js'); ?>"></script>
<?php } ?>
       
    </body>
</html>