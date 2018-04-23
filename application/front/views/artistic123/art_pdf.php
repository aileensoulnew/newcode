<html>
<head> 
<title><?php echo $title; ?></title> 
<?php echo $head; ?>



<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/artistic.css?ver='.time()); ?>">

</head> 
  <body   class="page-container-bg-solid page-boxed">
<?php echo $header; ?>
<?php echo $art_header2_border; ?>
<section class="custom-row">
<?php echo $artistic_common; ?>
<div class="container tablate-container art-profile">         
     <div class="">
    <div class="user-midd-section grybod" >
      <div  class="col-sm-12 border_tag padding_low_data padding_les" >
        <div class="padding_less main_art" >
                        <div class="top-tab">
                            <ul class="nav nav-tabs tabs-left remove_tab">
                                <li> <a href="<?php echo base_url('artistic/photos/'.$artisticdata[0]['slug']) ?>"><i class="fa fa-camera" aria-hidden="true"></i>   Photos</a></li>
                                <li> <a href="<?php echo base_url('artistic/videos/'.$artisticdata[0]['slug']) ?>"><i class="fa fa-video-camera" aria-hidden="true"></i>  Video</a></li>
                                <li><a href="<?php echo base_url('artistic/audios/'.$artisticdata[0]['slug']) ?>"><i class="fa fa-music" aria-hidden="true"></i>  Audio</a></li>
                                <li class="active">    <a href="<?php echo base_url('artistic/pdf/'.$artisticdata[0]['slug']) ?>"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>  Pdf</a></li>
                              </ul>
                        </div>
          <!-- Tab panes -->
          <div class="tab-content">
            <div class="tab-pane active" id="home"><div class="common-form">
                            <div class="">

                                                    <div class="all-box">
                                            <ul> 
                                               <!-- <li>
                                                    <img src="http://localhost/aileensoul/uploads/business_post/thumbs/file_1496664178_jh179.jpg">
                                                </li>
                                                <li>
                                                    <img src="http://localhost/aileensoul/uploads/business_post/thumbs/file_1496664178_jh179.jpg">
                                                </li>
                                                <li>
                                                    <img src="http://localhost/aileensoul/uploads/business_post/thumbs/file_1496664178_jh179.jpg">
                                                </li>
                                                <li>
                                                    <img src="http://localhost/aileensoul/uploads/business_post/thumbs/file_1496664178_jh179.jpg">
                                                </li>
                                                <li>
                                                    <img src="http://localhost/aileensoul/uploads/business_post/thumbs/file_1496664178_jh179.jpg">
                                                </li>
                                                <li>
                                                    <img src="http://localhost/aileensoul/uploads/business_post/thumbs/file_1496664178_jh179.jpg">
                                                </li>

                                                <li>
                                                    <img src="http://localhost/aileensoul/uploads/business_post/thumbs/file_1496664178_jh179.jpg">
                                                </li> -->

                                                                                <?php

          $contition_array = array('user_id' => $artisticdata[0]['user_id']);
         $artisticimage = $this->data['artisticimage'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

           
            foreach ($artisticimage as $val) {
             
            

              $contition_array = array('post_id' => $val['art_post_id'], 'is_deleted' =>'1', 'insert_profile' => '1');
            $artmultipdf = $this->data['artmultipdf'] =  $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = 'post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

              $multiplepdf[] = $artmultipdf;
             }

                  ?>
              <?php   

                $allowed =  array('pdf');
              
                foreach ($multiplepdf as $mke => $mval) {
                  
                  foreach ($mval as $mke1 => $mval1) {
                      $ext = pathinfo($mval1['file_name'], PATHINFO_EXTENSION);

                     if(in_array($ext,$allowed)){
                   $singlearray3[] = $mval1;
                     }
                  }
                } 
                ?>


              <?php 
               if($singlearray3) {

                foreach ($singlearray3 as $pdfv) {
                  
              ?>

  <li>
  <div class="main_box_pdf">
<div class="main_box_img">

  <?php 
              $contition_array = array('art_post_id' => $pdfv['post_id']);
             $artistictitle = $this->data['artistictitle'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
              ?>

        <!-- <a href="<?php //echo base_url('artistic/creat_pdf/'.$pdfv['post_files_id']) ?>"> -->
        <a title="<?php echo ucfirst(strtolower($artistictitle[0]['art_post'])); ?>" href="<?php echo base_url($this->config->item('art_post_main_upload_path') . $pdfv['file_name']) ?>">

        <div class="margin_less" >
              <img src="<?php echo base_url('assets/images/PDF.jpg')?>" style="height: 100%; width: 100%;"> 
              <!-- <embed src="<?php echo ART_POST_MAIN_UPLOAD_URL . $pdfv['file_name'] ?>" width="100%" height="450px" /> -->
                                                              
              </div></a> </div> 

              
        <div class="pdf_name">
        <a title="<?php echo ucfirst(strtolower($artistictitle[0]['art_post'])); ?>" href="<?php echo base_url($this->config->item('art_post_main_upload_path') . $pdfv['file_name']) ?>"><?php echo ucfirst(strtolower($artistictitle[0]['art_post'])); ?>
          
        </a> </div>
</div>
</li>
        <!-- <a href="<?php echo base_url('artistic/creat_pdf/'.$pdfv['post_files_id']) ?>">
        <div class="pdf_name"><a title="Zalak infotech .in pdf" href="">Zalak infotech .in pdf</a> </div></a> -->

        <?php } } else{?>
                                         
                               <div class="art_no_pva_avl">
         <div class="art_no_post_img">
          <img src="<?php echo base_url('assets/images/020.png'); ?>"  >
         </div>
         <div class="art_no_post_text1">
           No Pdf Available.
         </div>
       </div>
        <?php }?>
      
     </ul>
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
                            <!--<img class="icon" src="images/dollar-icon.png" alt="" />-->
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
                               <div class="col-md-5">

                                <div class="fw" id="loaderfollow" style="text-align:center; display: none;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" /></div>
                                
                                        <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="upload-one">
                                    </div>
                                    <div class="col-md-7 text-center">
                                        <div id="upload-demo-one" style="width:350px"></div>
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
<footer>
<?php echo $footer; ?>
</footer>

 <script src="<?php echo base_url('assets/js/croppie.js?ver='.time()); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js?ver='.time()); ?>"></script>

<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()); ?>"></script>
 
<script>
var base_url = '<?php echo base_url(); ?>';   
var data= <?php echo json_encode($demo); ?>;
var data1 = <?php echo json_encode($de); ?>;
</script>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artistic/artistic_common.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artistic/pdf.js?ver='.time()); ?>"></script>
</body>
</html>