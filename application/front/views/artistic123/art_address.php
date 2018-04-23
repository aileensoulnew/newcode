<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>  
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver='.time()); ?>">
        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/artistic.css?ver='.time()); ?>">
        
    </head>    
    <body class="page-container-bg-solid page-boxed">
        <?php echo $header; ?>
        <?php if ($artdata[0]['art_step'] == 4) { ?>
            <?php echo $art_header2_border; ?>
        <?php } ?>
    <!-- <div class="js">
    <div id="preloader"></div> -->
      <section>
        <div class="user-midd-section" id="paddingtop_fixed">
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
                                <li class="custom-none"><a href="<?php echo base_url('artistic/artistic-information-update'); ?>">Basic Information</a></li>
                                <li <?php if($this->uri->segment(1) == 'artistic'){?> class="active init" <?php } ?>><a href="javascript:void(0);">Address</a></li>
                                <li class="custom-none <?php if($artdata[0]['art_step'] < '2'){echo "khyati";}?>"><a href="<?php echo base_url('artistic/artistic-information'); ?>">Art Information</a></li>
                                <li class="custom-none <?php if($artdata[0]['art_step'] < '3'){echo "khyati";}?>"><a href="<?php echo base_url('artistic/artistic-portfolio'); ?>">Portfolio</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- middle section start -->
                    <div class="col-md-6 col-sm-8">
                    <div>
                        <?php
                                        if ($this->session->flashdata('error')) {
                                            echo '<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>';
                                        }
                                        if ($this->session->flashdata('success')) {
                                            echo '<div class="alert alert-success">' . $this->session->flashdata('success') . '</div>';
                                        }?>
                    </div>
                        <div class="common-form common-form_border">
                         <h3>
                           Address
                        </h3>                       
                            <?php echo form_open(base_url('artistic/art_address_insert'), array('id' => 'address','name' => 'address', 'class' => 'clearfix')); ?>
                            <?php
                             $country =  form_error('country');
                             $state =  form_error('state');                           
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
                                <fieldset>
								    <label> City<span class="optional">(optional)</span>:</label>
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
                                   <input type="submit"  id="next" name="next" tabindex="6" value="Next">      
                                   </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<footer>        
<?php echo $footer;  ?>
</footer>
</div>


<script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()); ?>"></script>
<script>
var data= <?php echo json_encode($demo); ?>;
var base_url = '<?php echo base_url(); ?>';
var data1 = <?php echo json_encode($city_data); ?>;
</script>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artistic/artistic_common.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artistic/address.js?ver='.time()); ?>"></script>
</body>
</html>

