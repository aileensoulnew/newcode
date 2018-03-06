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
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />
<?php }else{?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/artistic.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />
<?php }?>

</head>
<body   class="page-container-bg-solid page-boxed botton_footer">
<?php echo $header; ?>
<?php echo $art_header2_border; ?>
<section class="custom-row">
<?php echo $artistic_common; ?>
<div class="container tablate-container art-profile">    
      <div class=" " >
    <div class="user-midd-section grybod">
      <div  class="col-sm-12 border_tag padding_low_data padding_les" >
                    <div class="padding_less main_art" >
                    <div class="top-tab">
                      <ul class="nav nav-tabs tabs-left remove_tab">
                          <li> <a href="<?php echo base_url('artist/photos/'.$get_url) ?>" ><i class="fa fa-camera" aria-hidden="true"></i>   Photos</a></li>
                          <li> <a href="<?php echo base_url('artist/videos/'.$get_url) ?>" ><i class="fa fa-video-camera" aria-hidden="true"></i>  Video</a></li>
                          <li class="active"><a href="<?php echo base_url('artist/audios/'.$get_url) ?>"><i class="fa fa-music" aria-hidden="true"></i>  Audio</a></li>
                          <li>    <a href="<?php echo base_url('artist/pdf/'.$get_url) ?>" ><i class="fa fa-file-pdf-o" aria-hidden="true"></i>  Pdf</a></li>
                        </ul>
                    </div>
          <!-- Tab panes -->
          <div class="tab-content">
            <div class="tab-pane active" id="home"><div class="common-form">
                            <div class="">
                                            <div class="all-box">
                                            <ul class="audio-sec">                                              
                                        <?php
          $contition_array = array('user_id' => $artisticdata[0]['user_id']);
         $artaudio = $this->data['artaudio'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');         
            foreach ($artaudio as $val) {
            $contition_array = array('post_id' => $val['art_post_id'], 'is_deleted' =>'1', 'insert_profile' => '1');
            $artmultiaudio = $this->data['artmultiaudio'] =  $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = 'post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
              $multipleaudio[] = $artmultiaudio;
             }  
                  ?>
              <?php   
                $allowesaudio = array('mp3');             
                foreach ($multipleaudio as $mke => $mval) {                
                  foreach ($mval as $mke1 => $mval1) {
                      $ext = pathinfo($mval1['file_name'], PATHINFO_EXTENSION);                   
                     if(in_array($ext,$allowesaudio)){ 
                   $singlearray2[] = $mval1;
                     }
                  }
                } 
                ?>
               <?php  if($singlearray2) { 
                foreach ($singlearray2 as $audiov) {                  
                 ?>
                 <li>
                            <audio controls>
                            <source src = "<?php echo ART_POST_MAIN_UPLOAD_URL . $audiov['file_name']; ?>" type = "audio/mp3">
                            <source src="movie.ogg" type="audio/mpeg">
                           Your browser does not support the audio tag.
                            </audio>
                            </li>
               <?php } } else{?>
             <div class="art_no_pva_avl">
         <div class="art_no_post_img">
              <img src="<?php echo base_url('assets/images/color_008.png'); ?>"  alt="<?php echo "color_008.png"; ?>">                              
         </div>
         <div class="art_no_post_text1">
           No Audio Available.
         </div>
       </div>                                    
               <?php }?>             
                </ul>
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
var data= <?php echo json_encode($demo); ?>;
var data1 = <?php echo json_encode($de); ?>;
$(document).ready(function () { 
  $('video, audio').mediaelementplayer();
});

</script>

 <?php
  if (IS_ART_JS_MINIFY == '0') { ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/audios.js?ver='.time()); ?>"></script>
 <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
<?php }else{?>

<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/audios.js?ver='.time()); ?>"></script>
 <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
<?php }?>
</body>
</html>