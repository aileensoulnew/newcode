
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?> 

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver='.time()); ?>">
      
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/artistic.css?ver='.time()); ?>">
        <style type="text/css">
          
          

        </style>
      
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

                                <li class="custom-none"><a href="<?php echo base_url('artistic/artistic-address'); ?>">Address</a></li>

                                <li <?php if($this->uri->segment(1) == 'artistic'){?> class="active init" <?php } ?>><a href="javascript:void(0);">Art Information</a></li>

                                <li class="custom-none <?php if($artdata[0]['art_step'] < '3'){echo "khyati";}?>"><a href="<?php echo base_url('artistic/artistic-portfolio'); ?>">Portfolio</a></li>

                            </ul>
                        </div>
                    </div>

                    <!-- middle section start -->
 
                <div class="col-md-6 col-sm-8">

                     <div class="art-alert">
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
                            Art Information
                        </h3>
                        
                            <?php echo form_open(base_url('artistic/art_information_insert'), array('id' => 'artinfo','name' => 'artinfo','class' => 'clearfix', 'onsubmit' => "return validation_other(event)")); ?>
                          
                                <?php
                                 $artname =  form_error('artname');
                                 $othercategory =  form_error('othercategory');
                                 $skills =  form_error('skills');
                                 //$desc_art =  form_error('desc_art');
                                  
                                 ?>

                                    <fieldset class="full-width <?php if($skills) {  ?> error-msg <?php } ?>">
                                        <label>Art category:<span style="color:red">*</span></label>

                          <select name="skills[]" id="skills" tabindex="1" autofocus multiple>
                         <!--  <option value="">Ex:- Dancer, Photographer, Writer, Singer, Actor</option> -->
                            <?php                             
                                      foreach($art_category as $cnt){ 
                                          if($art_category1)
                                            { 
                                              $category = explode(',' , $art_category1);  
                                              ?>
                                                 <option value="<?php echo $cnt['category_id']; ?>"
                                                  <?php if(in_array($cnt['category_id'], $category)) echo 'selected';?>><?php echo $cnt['art_category'];?></option>              
                                                 <?php
                                                }
                                                else
                                                {  
                                            ?>
                            <option value="<?php echo $cnt['category_id']; ?>"><?php echo $cnt['art_category'];?></option>
                                <?php    }       
                                            }
                                            ?>
                      </select>
                                    
                                      <!-- <input placeholder="Ex:- Dancing, Photography, Writing, Singing, Acting" id="skills2" value="<?php echo $work_skill; ?>" name="skills" tabindex="1" size="90"> -->

                                        <?php echo form_error('skills'); ?>
                                    </fieldset>

                                    <?php if($othercategory1){?>
                                    <div id="other_category" class="other_category" style="display: block;">
                                      <?php }else{ ?>
                                      <div id="other_category" class="other_category" style="display: none;">
                                      <?php }?>
                                    <fieldset class="full-width <?php if($artname) {  ?> error-msg <?php } ?>">
                                    <label>Other category:<span style="color:red">*</span></label>
                                    <input name="othercategory"  type="text" id="othercategory" tabindex="2" placeholder="Other category" value="<?php if($othercategory1){ echo $othercategory1; } ?>" onkeyup= "return removevalidation();"/><!-- <span id="artname-error"></span> -->
                                     <?php echo form_error('othercategory'); ?>
                                   </fieldset>
                                 </div>

                                <fieldset class="full-width <?php if($artname) {  ?> error-msg <?php } ?>">
                                    <label>Speciality in art<span class="optional">(optional)</span>:</label>
                                    <input name="artname"  type="text" id="artname" tabindex="2" placeholder="Ex:- Classical dancing, Contemporary, Zumba, Hip Hop " value="<?php if($artname1){ echo $artname1; } ?>"/><!-- <span id="artname-error"></span> -->
                                     <?php echo form_error('artname'); ?>
                                </fieldset>
              
                              
                                <fieldset  class="full-width">
                                    <label>Description of your artistic career<span class="optional">(optional)</span>:<!-- <span style="color:red">*</span> --></label>

                                 <textarea id="textarea" name ="desc_art" id="desc_art" tabindex="3" rows="4" cols="50" placeholder="Enter description of your art" style="resize: none;"><?php if($desc_art1){ echo $desc_art1; } ?></textarea>
                                   
                                  <?php echo form_error('desc_art'); ?><br/> 
                                </fieldset>
                               

                                <fieldset class="full-width">
                                    <label>How you are inspire?<span class="optional">(optional)</span>:</label>
                                
                                    <input name="inspire"  type="text" id="inspire" placeholder="Enter inspire" tabindex="4" value="<?php if($inspire1){ echo $inspire1; } ?>"/><span ></span>
                                 
                                </fieldset>

                                 <fieldset class="hs-submit full-width">
                                   
                                    <input type="submit"  id="next" name="next" value="Next" tabindex="6">
                                   
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

  

<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.multi-select.js?ver=' . time()); ?>"></script>


<script type="text/javascript">
 var base_url = '<?php echo base_url(); ?>';   
var data= <?php echo json_encode($demo); ?>;

var data1 = <?php echo json_encode($de); ?>;

var data1 = <?php echo json_encode($city_data); ?>;

var complex = <?php echo json_encode($selectdata); ?>;

var textarea = document.getElementById("textarea");

</script>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artistic/artistic_common.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artistic/art_information.js?ver='.time()); ?>"></script>
</body>
</html>
   