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
        
         <?php
        } else {
            ?>

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
                                <li class="custom-none"><a href="<?php echo base_url('artist/artistic-information-update'); ?>" title="Basic Information">Basic Information</a></li>
                                <li <?php if($this->uri->segment(1) == 'artist'){?> class="active init" <?php } ?>><a href="javascript:void(0);" title="Address">Address</a></li>
                                <li class="custom-none <?php if($artdata[0]['art_step'] < '2'){echo "khyati";}?>"><a href="<?php echo base_url('artist/artistic-information'); ?>" title="Art Information">Art Information</a></li>
                              
                            </ul>
                        </div>
                    </div>
                    <!-- middle section start -->
                    <div class="col-md-6 col-sm-8">
                    <div>
                        
                    </div>
                        <div class="common-form common-form_border">
                         <h3>
                           Address
                        </h3>                       
                            <?php echo form_open(base_url('artist/art_address_insert'), array('id' => 'address','name' => 'address', 'class' => 'clearfix')); ?>
                            <?php
                             $country =  form_error('country');
                             $state =  form_error('state');
                             $city =  form_error('city');                           
                         ?>
                                <fieldset <?php if($country) {  ?> class="error-msg" <?php } ?>>
								<label>Country:<span style="color:red">*</span></label>								
        								<select name="country" id="country" tabindex="1" autofocus>
            							<option value="">Select country</option>
            							<?php
                                            if(count($countries) > 0){
                                                foreach($countries as $cnt){
                                                    if($country1)
                                            {
                                              ?>
                                                 <option value="<?php echo $cnt['country_id']; ?>" <?php if($cnt['country_id']==$country1) echo 'selected';?>><?php echo $cnt['country_name'];?></option>              
                                                 <?php
                                                }
                                                else
                                                {
                                            ?>
                            <option value="<?php echo $cnt['country_id']; ?>"><?php echo $cnt['country_name'];?></option>
                                                  <?php                                            
                                            }       
                                            }}
                                            ?>
        							</select><span id="country-error"></span>
							     <?php echo form_error('country'); ?>
    							</fieldset>                                
                                <fieldset <?php if($state) {  ?> class="error-msg" <?php } ?>>
								    <label>state:<span style="color:red">*</span></label>
    								<select name="state" id="state" tabindex="2">
        							<?php
                                          if($state1)
                                            {
                                            foreach($states as $cnt){  ?>
                                                 <option value="<?php echo $cnt['state_id']; ?>" <?php if($cnt['state_id']==$state1) echo 'selected';?>><?php echo $cnt['state_name'];?></option>
                                                <?php
                                                } }                                             
                                               else
                                                {
                                            ?>
                                                 <option value="">Select country first</option>
                                                  <?php                                            
                                            }
                                            ?>
								    </select><span id="state-error"></span>
                                     <?php echo form_error('state'); ?>
								</fieldset>
                                <fieldset <?php if($city) {  ?> class="error-msg" <?php } ?>>
								    <label> City:<span style="color:red">*</label>
									<select name="city" id="city" tabindex="3">
    								<?php
                                         if($city1)
                                            {
                                          foreach($cities as $cnt){                                              
                                              ?>
                                               <option value="<?php echo $cnt['city_id']; ?>" <?php if($cnt['city_id']==$city1) echo 'selected';?>><?php echo $cnt['city_name'];?></option>
                                                <?php
                                                } }
                                                else if($state1)
                                             {
                                            ?>
                                            <option value="">Select city</option>
                                            <?php
                                            foreach ($cities as $cnt) {
                                                ?>
                                                <option value="<?php echo $cnt['city_id']; ?>"><?php echo $cnt['city_name']; ?></option>
                                                <?php
                                            }
                                        }                                              
                                                else
                                                {
                                            ?>
                                        <option value="">Select state first</option>
                                         <?php                                          
                                            }
                                            ?>
									</select><span id="city-error"></span>
                                    <?php echo form_error('city'); ?>
								</fieldset>
                                <fieldset <?php if($pincode) {  ?> class="error-msg" <?php } ?>>
									<label>Pincode<span class="optional">(optional)</span>:</label>
									<input name="pincode"  type="text" id="pincode" tabindex="4" placeholder="Enter pincode" value="<?php if($pincode1){ echo $pincode1; } ?>"/><span id="pincode-error"></span>
                                    <?php echo form_error('pincode'); ?>
									</fieldset>								
                                <fieldset class="hs-submit full-width">                                       
                                 <!--   <input type="submit"  id="next" name="next" tabindex="6" value="Next">   -->

                                   <button id="next" name="next" tabindex="6" onclick="return reg_loader();">Next<span class="ajax_load pl10" id="profilereg_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>

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
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()); ?>"></script>

<?php }else{?>
<script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver='.time()); ?>"></script>
<?php }?>
<script>
var data= <?php echo json_encode($demo); ?>;
var base_url = '<?php echo base_url(); ?>';
var data1 = <?php echo json_encode($city_data); ?>;
</script>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/address.js?ver='.time()); ?>"></script>
<?php
  if (IS_ART_JS_MINIFY == '0') { ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
<!--<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/address.js?ver='.time()); ?>"></script>-->
<?php }else{?>
<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
<!--<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/address.js?ver='.time()); ?>"></script>-->
<?php }?>
</body>
</html>

