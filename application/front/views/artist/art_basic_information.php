<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>  

         <?php
        if (IS_ART_CSS_MINIFY == '0') {
            ?>

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver='.time()); ?>"> 
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/artistic.css?ver='.time()); ?>">
         <?php }else{?>

         <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver='.time()); ?>"> 
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/artistic.css?ver='.time()); ?>">

         <?php }?>  
    </head>
    <body class="page-container-bg-solid page-boxed botton_footer">
    <?php echo $header; ?>
        <?php if ($artdata[0]['art_step'] == 4) { ?>
            <?php echo $art_header2_border; ?>
        <?php } ?>
      <section> 
        <?php 
                       
             if($artdata[0]['art_step'] == 4){ ?>
        <div class="user-midd-section" id="paddingtop_fixed">
          <?php }else{?>
          <div class="user-midd-section" id="paddingtop_make_fixed">
          <?php }?>

           <div class="common-form1">
           <div class="row">
             <div class="col-md-3 col-sm-4"></div>
             <?php 
                       
             if($artdata[0]['art_step'] == 4){ ?>
 <div class="col-md-6 col-sm-8"><h3>You are updating your Artistic Profile.</h3></div>
                <?php }else{
             ?>
                      <div class="col-md-6 col-sm-8"><h3>You are making your Artistic Profile.</h3></div>
                       <?php }?>
            </div>
            </div>        
            
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-4">
                        <div class="left-side-bar">
                            <ul class="left-form-each">
                                <li <?php if($this->uri->segment(1) == 'artist'){?> class="active init" <?php } ?>><a href="javascript:void(0);" title="Basic Information">Basic Information</a></li>
                                <li class="custom-none <?php if($artdata[0]['art_step'] < '1'){echo "khyati";}?>"><a href="<?php echo base_url('artist/artistic-address'); ?>" title="Address">Address</a></li>
                                <li class="custom-none <?php if($artdata[0]['art_step'] < '2'){echo "khyati";}?>"><a href="<?php echo base_url('artist/artistic-information'); ?>" title="Art Information">Art Information</a></li>
                               
                            </ul>
                        </div>
                    </div>
                    <!-- middle section start --> 
                    <div class="col-md-6 col-sm-8">
                    <div>
                        
                    </div>
                        <div class="common-form common-form common-form_border clearfix">
                         <h3>
                            Basic Information
                        </h3>                       
                           <?php echo form_open(base_url('artist/art_basic_information_insert'), array('id' => 'artbasicinfo','name' => 'artbasicinfo', 'class' => 'clearfix')); ?>
                                <?php
                                 $firstname =  form_error('firstname');
                                 $lastname = form_error('lastname');
                                 $email =  form_error('email');
                                 $phoneno =  form_error('phoneno');
                                 
                         		?>
								<div class="fw">
                               <fieldset <?php if($firstname) {  ?> class="error-msg" <?php } ?>>
                                    <label>First name:<span style="color:red">*</span></label>
                                    <input name="firstname" tabindex="1" autofocus type="text" id="firstname" placeholder="Enter first name" value="<?php if($firstname1){ echo $firstname1; } else { echo $art[0]['first_name']; }?>"/>
                                    <?php echo form_error('firstname'); ?>
                                </fieldset>                              
                                <fieldset <?php if($lastname) {  ?> class="error-msg" <?php } ?>>
                                    <label>Last name:<span style="color:red">*</span></label>
                                    <input name="lastname" type="text" id="lastname" tabindex="2" placeholder="Enter last name" value="<?php if($lastname1){ echo $lastname1; } else { echo $art[0]['last_name']; } ?>"/>
                                    <?php echo form_error('lastname'); ?>
                                </fieldset>
								</div>
								<div class="fw">
                                <fieldset  <?php if($email) {  ?> class="error-msg vali_er " <?php }else{

                                 ?> class="vali_er" <?php }?>>
                                <?php $user_email = strtolower($art[0]['user_email']); ?>
                                    <label>E-mail address:<span style="color:red">*</span></label>
                                    <input name="email"  type="text" id="email" tabindex="3" placeholder="Enter e-mail address" value="<?php if($email1){ echo $email1; } else { echo $user_email; } ?>">
                                    <span class="email_note"><b>Note:-</b> Related notification email will be send on provided email address kindly use regular  email address.<div></div></span>
                                     <?php echo form_error('email'); ?>
                                </fieldset>                             
                                <fieldset <?php if($phoneno) {  ?> class="error-msg" <?php } ?>>
                                    <label>Phone number<span class="optional">(optional)</span>:</label>
                                    <input name="phoneno"  type="text" id="phoneno" tabindex="4" placeholder="Enter phone number" value="<?php if($phoneno1){ echo $phoneno1; } ?>">
                                    <?php echo form_error('phoneno'); ?><br/>
                                </fieldset> 
								
                                <fieldset class="hs-submit full-width">                                 
                                   <!--  <input type="submit"  id="next" name="next" value="Next" tabindex="5"> -->
                                   <button id="next" name="next" tabindex="5" onclick="return reg_loader();">Next<span class="ajax_load pl10" id="profilereg_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
                                    </fieldset>
                           </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

  <?php echo $login_footer ?>
     <?php echo $footer;  ?>

    </div>

   <?php
  if (IS_ART_JS_MINIFY == '0') { ?>
  <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()) ?>"></script>
<?php }else{?>
  <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver='.time()) ?>"></script>
<?php }?>
<script>
 var base_url = '<?php echo base_url(); ?>';
var data= <?php echo json_encode($demo); ?>;
var data1 = <?php echo json_encode($de); ?>;
var data1 = <?php echo json_encode($city_data); ?>;
</script>

  <?php
  if (IS_ART_JS_MINIFY == '0') { ?>

<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/search.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/information.js?ver='.time()); ?>"></script>

<?php }else{?>

<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/search.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/information.js?ver='.time()); ?>"></script>

<?php }?>
</body>
</html>