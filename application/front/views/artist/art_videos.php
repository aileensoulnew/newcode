<html>
<head> 
<title><?php echo $title; ?></title> 
<?php echo $head; ?>

<?php
        if (IS_ART_CSS_MINIFY == '0') {
            ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/video.css?ver='.time()); ?>">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/artistic.css?ver='.time()); ?>">
<?php }else{?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/video.css?ver='.time()); ?>">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/artistic.css?ver='.time()); ?>">
<?php }?>

</head>
  <body   class="page-container-bg-solid page-boxed botton_footer">
  <?php echo $header; ?>
<?php echo $art_header2_border; ?>
    <section class="custom-row">
    <?php echo $artistic_common; ?>
<div class="container tablate-container art-profile">   
      <div class=" " >
    <div class="user-midd-section grybod" >
      <div  class="col-sm-12 border_tag padding_low_data padding_les" >
        <div class="padding_less main_art" >   <!-- Tab panes -->
                    <div class="top-tab">
                      <ul class="nav nav-tabs tabs-left remove_tab">
                          <li> <a href="<?php echo base_url('artist/photos/'.$get_url) ?>" title="Photos"><i class="fa fa-camera" aria-hidden="true"></i>   Photos</a></li>
                          <li class="active"> <a href="<?php echo base_url('artist/videos/'.$get_url) ?>" title="Video"><i class="fa fa-video-camera" aria-hidden="true"></i>  Video</a></li>
                          <li><a href="<?php echo base_url('artist/audios/'.$get_url) ?>" title="Audio"><i class="fa fa-music" aria-hidden="true"></i>  Audio</a></li>
                          <li>    <a href="<?php echo base_url('artist/pdf/'.$get_url) ?>" title="Pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>  Pdf</a></li>
                        </ul>
                    </div>
          <div class="tab-content">
            <div class="tab-pane active" id="home"><div class="common-form">
                           
                                                  <div class="all-box">
                                            <ul class="video"> 
                                             
                                                 <?php

          $contition_array = array('user_id' => $artisticdata[0]['user_id'], 'is_delete' => '0');
         $artvideo = $this->data['artvideo'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

         
            foreach ($artvideo as $val) {
             
            

            $contition_array = array('post_id' => $val['art_post_id'], 'is_deleted' =>'1', 'insert_profile' => '1', 'post_format' => 'video');
            $artmultivideo = $this->data['artmultivideo'] =  $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = 'post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

              $multiplevideo[] = $artmultivideo;
             } 

            $abc = array_reduce($multiplevideo, 'array_merge', array());

             ?>

               
        <?php  if(count($abc) > 0) {  

            foreach ($abc as $videov) { 
         ?>
         <li>
             <div class="vidoe_tag"> 


              <?php
                      $s3 = new S3(awsAccessKey, awsSecretKey);
                      $post_poster = $videov['file_name'];
                      $post_poster1 = explode('.', $post_poster);
                      $post_poster2 = end($post_poster1);
                      $post_poster = str_replace($post_poster2, 'png', $post_poster);

                    if (IMAGEPATHFROM == 'upload') { 
                          if (file_exists($this->config->item('art_post_main_upload_path') . $post_poster)) {
                      ?>
                      <video preload="none" poster="<?php echo base_url($this->config->item('art_post_main_upload_path') . $post_poster); ?>" controls playsinline webkit-playsinline>
                      <?php
                        } else {
                      ?>
                    <video preload="none" controls playsinline webkit-playsinline>
                     <?php
                      }
                      } else {

                      $filename = $this->config->item('art_post_main_upload_path') . $post_poster;
                      $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                      if ($info) {
                          $postposter = $this->config->item('art_post_main_upload_path') . $post_poster;
                          $this->data['postposter'] = $postposter = $s3->getObjectInfo(bucket, $postposter);
                          if($postposter){
                        ?>
                    <video  controls poster="<?php echo base_url($this->config->item('art_post_main_upload_path') . $post_poster); ?>">
                      <?php }else{ ?>

                      <video preload="none" controls playsinline webkit-playsinline>

                      <?php } } else {
                      ?>
                      <video preload="none" controls playsinline webkit-playsinline>
                      <?php
                         } } ?>
                      <source src="<?php echo base_url($this->config->item('art_post_main_upload_path') . $videov['file_name']); ?>" type="video/mp4">
                      <source src="movie.ogg" type="video/ogg">
                        Your browser does not support the video tag.
                      </video>
                
              </div>
             </li>

      <?php }  }  else{?>
 <div class="art_no_pva_avl">
         <div class="art_no_post_img">
          <img src="<?php echo base_url('assets/images/010.png'); ?>"  alt="<?php echo "010.png"; ?>">
         </div>
         <div class="art_no_post_text1">
           No video Available.
         </div>
       </div>
        <?php }?>                                         
        </ul>
        </div>
           </div>
</div>
</div>
</div></div>          
          </div>
        </div>
        <div class="clearfix"></div>
      </div>  
    </div>
</div>
</div>
</div>
</div>
</section>
 <!-- Bid-modal  -->
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
            <!-- Model Popup Close -->

<!-- Bid-modal-2  -->
                        <div class="modal fade message-box" id="bidmodal-2" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                    <div class="modal-body">
                        <span class="mes">
                            <div id="popup-form">
                             <form id ="userimage" name ="userimage" class ="clearfix" enctype="multipart/form-data" method="post">
                               <div class=" ">
                                <div class="fw" id="loaderfollow" style="text-align:center; display: none;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo "loader.gif"; ?>"/></div>

                                        <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="upload-one">
                                    </div>
                                    <div class="col-md-7 text-center">
                                        <div id="upload-demo-one" style="width:350px; display: none"></div>
                                    </div>
                                <input type="submit"  class="upload-result-one" name="profilepicsubmit" id="profilepicsubmit" value="Save">
                                </form>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
                        <!-- Model Popup Close -->

  <?php echo $login_footer ?>
<?php echo $footer; ?>

<?php
  if (IS_ART_JS_MINIFY == '0') { ?>
 <script src="<?php echo base_url('assets/js/croppie.js?ver='.time()); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js?ver='.time()); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()); ?>"></script>
  <?php }else{?>

<script src="<?php echo base_url('assets/js_min/croppie.js?ver='.time()); ?>"></script>
<script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver='.time()); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver='.time()); ?>"></script>

  <?php }?>
<script>
var base_url = '<?php echo base_url(); ?>';   
   var data = <?php echo json_encode($demo); ?>;
   var data1 = <?php echo json_encode($de); ?>;
</script>

<?php
  if (IS_ART_JS_MINIFY == '0') { ?>

<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
<script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/videos.js?ver='.time()); ?>"></script>
<?php }else{?>
<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
<script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/videos.js?ver='.time()); ?>"></script>
<?php }?>
 </body>
</html>


