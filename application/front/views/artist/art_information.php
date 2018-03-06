
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
        <style type="text/css">
          
        </style>
      
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
                                <li class="custom-none"><a href="<?php echo base_url('artist/artistic-address'); ?>" title="Address">Address</a></li>
                                <li <?php if($this->uri->segment(1) == 'artist'){?> class="active init" <?php } ?> title="Art Information"><a href="javascript:void(0);">Art Information</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- middle section start -->
 
                <div class="col-md-6 col-sm-8">

                     <div class="art-alert">
                      
                    </div>

                        <div class="common-form common-form_border">
                         <h3>
                            Art Information
                        </h3>
                        
                            <?php echo form_open_multipart(base_url('artist/art_information_insert'), array('id' => 'artinfo','name' => 'artinfo','class' => 'clearfix', 'onsubmit' => "return validation_other(event)")); ?>

                         
                          
                                <?php
                                 $artname =  form_error('artname');
                                 $othercategory =  form_error('othercategory');
                                 $skills =  form_error('skills');
                                
                                  
                                 ?>
                                    <fieldset class="full-width art-cat-custom <?php if($skills) {  ?> error-msg <?php } ?>">
                                        <label>Art category:<span style="color:red">*</span></label>

                          <select name="skills[]" id="skills" tabindex="1" autofocus multiple>
                        
                            <?php                             
                                      foreach($art_category as $cnt){ 
                                          if($art_category1)
                                            { 
                                              $category = explode(',' , $art_category1);  
                                              ?>
                                                 <option value="<?php echo $cnt['category_id']; ?>"
                                                  <?php if(in_array($cnt['category_id'], $category)) echo 'selected';?> onchange="return otherchange(<?php echo $cnt['category_id']; ?>);"><?php echo ucwords(ucfirst($cnt['art_category']));?></option>              
                                                 <?php
                                                }
                                                else
                                                {  
                                            ?>
                            <option value="<?php echo $cnt['category_id']; ?>" onchange="return otherchange(<?php echo $cnt['category_id']; ?>);"><?php echo ucwords(ucfirst($cnt['art_category']));?></option>
                                <?php    }       
                                            }
                                            ?>
                      </select>
                                  
                                        <?php echo form_error('skills'); ?>
                                    </fieldset>

                                    <?php if($othercategory1){?>
                                    <div id="other_category" class="other_category" style="display: block;">
                                      <?php }else{ ?>
                                      <div id="other_category" class="other_category" style="display: none;">
                                      <?php }?>
                                    <fieldset class="full-width <?php if($artname) {  ?> error-msg <?php } ?>">
                                    <label>Other category:<span style="color:red">*</span></label>
                                    <input name="othercategory"  type="text" id="othercategory" tabindex="2" placeholder="Other category" value="<?php if($othercategory1){ echo $othercategory1; } ?>" onkeyup= "return removevalidation();"/>
                                     <?php echo form_error('othercategory'); ?>
                                   </fieldset>
                                 </div>

                                <fieldset class="full-width <?php if($artname) {  ?> error-msg <?php } ?>">
                                    <label>Speciality in art<span class="optional">(optional)</span>:</label>
                                    <input name="artname"  type="text" id="artname" tabindex="2" placeholder="Ex:- Classical dancing, Contemporary, Zumba, Hip Hop " value="<?php if($artname1){ echo $artname1; } ?>"/>
                                     <?php echo form_error('artname'); ?>
                                </fieldset>


                                 <input type="file" value="" name="bestofmine" id="bestofmine" style="display:block;display:none;"/>

                                 <label for="bestofmine" class="optional-custom"  tabindex="1" ><i class="fa fa-plus action-buttons btn-group"  aria-hidden="true" style=" margin: 8px; cursor:pointer ; color: #fff; float: initial;"> </i> Attachment<span class="optional">(optional)</span></label> <span id="datav" class="attach-file-name"></span>   
                                 <div class="fw" id="loader" style="text-align:center; display: none;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo "loader.gif"; ?>"/> 
                                 </div> 
                                <div class="bestofmine_image" style="color:#f00; display: block;"></div>
           
                               <?php if($userdata[0]['art_bestofmine']){?>
                                <div style="visibility:show;" id ="pdffile">

                                  <a title="<?php echo ucfirst(strtolower($userdata[0]['art_bestofmine'])); ?>" href="<?php echo ART_PORTFOLIO_MAIN_UPLOAD_URL . $userdata[0]['art_bestofmine']; ?>">

                              <i class="fa fa-file-pdf-o fa-2x" style="color: red; padding-left: 8px; padding-top: 10px; padding-bottom: 10px; position: relative;" aria-hidden="true"></i></a>

                              <a style="position: absolute; cursor:pointer;" onclick="delpdf();"><i class="fa fa-times" aria-hidden="true"></i></a>
                              <span id ="filename" style="color: #8c8c8c; font-size: 17px; padding-left: 10px;visibility:show;"><?php echo $userdata[0]['art_bestofmine']; ?></span><span class="file_name"></span>
 
                              </div>
                              <?php }?>

                              <input type="hidden" name="bestmine" id="bestmine" value="<?php echo $bestofmine1; ?>"><span id="bestofmine-error"></span>

              
                                 <fieldset class="hs-submit full-width">
                                   
                             <!--  <input type="submit"  id="next" name="next" value="Submit" tabindex="6" onclick="return validate();"> -->

                              <button id="next" name="next" tabindex="6" onclick="return validate();">Next<span class="ajax_load pl10" id="profilereg_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
                                   
                                </fieldset>
                                
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


     <?php
$userid = $this->session->userdata('aileenuser');
 $contition_array = array('user_id' => $userid);
       
 $art_reg_data = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = ''); ?>


  <?php echo $login_footer ?>
  <?php echo $footer;  ?>
</div>

<?php
  if (IS_ART_JS_MINIFY == '0') { ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.multi-select.js?ver=' . time()); ?>"></script>

<?php }else{?>
<script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver='.time()); ?>"></script>
<script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
<script src="<?php echo base_url('assets/js_min/jquery.multi-select.js?ver=' . time()); ?>"></script>
<?php }?>
<script type="text/javascript">
 var base_url = '<?php echo base_url(); ?>';   
var data= <?php echo json_encode($demo); ?>;

var data1 = <?php echo json_encode($de); ?>;

var data1 = <?php echo json_encode($city_data); ?>;

var complex = <?php echo json_encode($selectdata); ?>;

var textarea = document.getElementById("textarea");
var art_step = "<?php echo $art_reg_data[0]['art_step']; ?>";
var art_id = "<?php echo $get_url; ?>";

</script>

<?php
  if (IS_ART_JS_MINIFY == '0') { ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/art_information.js?ver='.time()); ?>"></script>
<?php }else{?>
<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/art_information.js?ver='.time()); ?>"></script>
<?php }?>
</body>
</html>
   