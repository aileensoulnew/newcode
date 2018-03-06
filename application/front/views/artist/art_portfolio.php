<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?> 

        <style type="text/css">
      .full-width img{display: none;}
    
    </style>

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
             
             if($artdata[0]['art_step'] == 4){  ?>

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

                                <li class="custom-none"><a href="<?php echo base_url('artist/artistic-information'); ?>" title="Art Infromation">Art Information</a></li>

                                <li <?php if($this->uri->segment(1) == 'artist'){?> class="active init" <?php } ?>><a href="javascript:void(0);" title="Portfolio">Portfolio</a></li>
  
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
                        <h3>Portfolio</h3>
                           
                  <form name="artportfolio" method="post" id="artportfolio" 
                    class="clearfix"  enctype="multipart/form-data" >

                                <?php
                                 $artportfolio =  form_error('artportfolio');
                                ?>
    
                       <input  type="file" name="bestofmine" id="bestofmine" style="display:block;display:none;"/>

 <label for="bestofmine" class="optional-custom"  tabindex="1" ><i class="fa fa-plus action-buttons btn-group"  aria-hidden="true" style=" margin: 8px; cursor:pointer ; color: #fff; float: initial;"> </i> Attachment<span class="optional">(optional)</span></label> <span id="datav" class="attach-file-name"></span>   <div class="fw" id="loader" style="text-align:center; display: none;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo "loader.gif"; ?>"/> 
  </div> 
 <div class="bestofmine_image" style="color:#f00; display: block;"></div>
           
                        <?php if($userdata[0]['art_bestofmine']){?>
                              <div style="visibility:show;" id ="pdffile">

                                 <a title="<?php echo ucfirst(strtolower($userdata[0]['art_bestofmine'])); ?>" href="<?php echo base_url($this->config->item('art_portfolio_main_upload_path') . $userdata[0]['art_bestofmine']) ?>">

                              <i class="fa fa-file-pdf-o fa-2x" style="color: red; padding-left: 8px; padding-top: 10px; padding-bottom: 10px; position: relative;" aria-hidden="true"></i></a>

                              <a style="position: absolute; cursor:pointer;" onclick="delpdf();"><i class="fa fa-times" aria-hidden="true"></i></a>
 <span id ="filename" style="color: #8c8c8c; font-size: 17px; padding-left: 10px;visibility:show;"><?php echo $userdata[0]['art_bestofmine']; ?></span><span class="file_name"></span>
 
                              </div>
                              <?php }?>

                              <input type="hidden" name="bestmine" id="bestmine" value="<?php echo $bestofmine1; ?>"><span id="bestofmine-error"></span>


                                <fieldset class="full-width">
                                 <label>Enter portfolio description<span class="optional">(optional)</span>:</label>
                              <div tabindex="2" style="min-height: 100px;"  class="editable_text"  contenteditable="true" name ="artportfolio" id="artportfolio123" rows="4" cols="50" placeholder="Enter portfolio detail" onpaste="OnPaste_StripFormatting(this, event);" onfocus="return cursorpointer(event);"><?php if($art_portfolio1){ echo $art_portfolio1; } ?></div>
                                         <?php echo form_error('artportfolio'); ?></fieldset>
                                
                                 <fieldset class="hs-submit full-width">
                                   
                                    
                <input type="button" tabindex="3"   id="submit" name="submit" value="submit" onclick="portfolio_form_submit(event);">
                                   
                                    
                                </fieldset>
                                
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

                <div class="modal fade message-box biderror" id="bidmodal" role="dialog">
                    <div class="modal-dialog modal-lm">
                        <div class="modal-content">
                            <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                            <div class="modal-body">
                                <span class="mes"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
$userid = $this->session->userdata('aileenuser');
 $contition_array = array('user_id' => $userid);
       
 $art_reg_data = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = ''); ?>



        <?php echo $login_footer ?>
<?php echo $footer;  ?>

</div>
 
  <?php
  if (IS_ART_JS_MINIFY == '0') { ?> 
<script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
<?php }else{?>
<script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
<?php }?>
<!-- script for skill textbox automatic end (option 2)-->
<script>
var base_url = '<?php echo base_url(); ?>';
var data= <?php echo json_encode($demo); ?>;
var data1 = <?php echo json_encode($de); ?>;
var data1 = <?php echo json_encode($city_data); ?>;

 var art_step = "<?php echo $art_reg_data[0]['art_step']; ?>";
 
</script>
<?php
  if (IS_ART_JS_MINIFY == '0') { ?> 
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/portfolio.js?ver='.time()); ?>"></script>

<?php }else{?>
<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/portfolio.js?ver='.time()); ?>"></script>
<?php }?>
</body>
</html>