<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?> 

         <?php
        if (IS_JOB_CSS_MINIFY == '0') {
            ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-3.min.css'); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css'); ?>">
        <?php }else{?>

        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css_min/bootstrap-3.min.css'); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/job.css'); ?>">

        <?php }?>
       
    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push botton_footer">
        <?php echo $header; ?>
        <?php echo $job_header2_border; ?>

        <div id="preloader"></div>
        <!-- START CONTAINER -->
        <section>
            <!-- MIDDLE SECTION START -->
            <div class="container mt-22" id="paddingtop_fixed">
                <div class="row" id="row1" style="display:none;">
                    <div class="col-md-12 text-center">
                        <div id="upload-demo" style="width:100%"></div>
                    </div>
                    <div class="col-md-12 cover-pic" >
                        <button class="btn btn-success  cancel-result" onclick="">Cancel</button>

                        <button class="btn btn-success set-btn upload-result " onclick="myFunction()">Save</button>

                        <div id="message1" style="display:none;">
                            <div id="floatBarsG">
                                <div id="floatBarsG_1" class="floatBarsG"></div>
                                <div id="floatBarsG_2" class="floatBarsG"></div>
                                <div id="floatBarsG_3" class="floatBarsG"></div>
                                <div id="floatBarsG_4" class="floatBarsG"></div>
                                <div id="floatBarsG_5" class="floatBarsG"></div>
                                <div id="floatBarsG_6" class="floatBarsG"></div>
                                <div id="floatBarsG_7" class="floatBarsG"></div>
                                <div id="floatBarsG_8" class="floatBarsG"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12"  style="visibility: hidden; ">
                        <div id="upload-demo-i" ></div>
                    </div>
                </div>
                <div class="">
                    <div class="" id="row2">
                        <?php 
                        $userid = $this->session->userdata('aileenuser');
                        if ($this->uri->segment(3) == $userid) {
                            $user_id = $userid;
                        } elseif ($this->uri->segment(3) == "") {
                            $user_id = $userid;
                        } else {
                            $user_id = $this->uri->segment(3);
                        }
                       
                        $image_ori = $this->config->item('rec_bg_main_upload_path') . $rec_data[0]['profile_background'];
                        if (file_exists($image_ori) && $rec_data[0]['profile_background'] != '') {
                            ?>

                            <img src="<?php echo base_url($this->config->item('rec_bg_main_upload_path') . $rec_data[0]['profile_background']); ?>" name="image_src" id="image_src" alt="<?php echo $rec_data[0]['profile_background']; ?>"/>
                            <?php
                        } else {
                            ?>

                             <div class="bg-images no-cover-upload">
                                 <img src="<?php echo base_url(WHITEIMAGE); ?>" name="image_src" id="image_src" alt="NOIMAGE"/>
                             </div>
                             <?php }
                             ?>

                    </div>
                </div>
            </div>
            <div class="container tablate-container art-profile">    
                <div class="profile-photo">
                 <!--PROFILE PIC CODE START-->
                   
                       <div class="profile-pho">
                        <div class="user-pic padd_img">
                            <?php
                            $imageee = $this->config->item('rec_profile_thumb_upload_path') . $rec_data[0]['recruiter_user_image'];
                            if (file_exists($imageee) && $rec_data[0]['recruiter_user_image'] != '') {
                                ?>
                                <img src="<?php echo base_url($this->config->item('rec_profile_thumb_upload_path') . $rec_data[0]['recruiter_user_image']); ?>" alt="<?php echo $rec_data[0]['recruiter_user_image']; ?>" >
                                <?php
                            } else {
                                $a = $rec_data[0]['rec_firstname'];
                                $acr = substr($a, 0, 1);

                                $b = $rec_data[0]['rec_lastname'];
                                $acr1 = substr($b, 0, 1);
                                ?>
                                <div class="post-img-user">
                                    <?php echo ucfirst(strtolower($acr)) . ucfirst(strtolower($acr1)); ?>

                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    
                    <!--PROFILE PIC CODE END-->
                    <div class="job-menu-profile mob-block">
                        <a href="javascript:void(0);" title="<?php echo $rec_data[0]['rec_firstname'] . ' ' . $rec_data[0]['rec_lastname']; ?>"><h3><?php echo $rec_data[0]['rec_firstname'] . ' ' . $rec_data[0]['rec_lastname']; ?></h3></a>
                        <div class="profile-text" >
                            <?php
                                if ($rec_data[0]['designation'] == '') {
                                
                                    ?>
                                    <a class="designation" title="Designation">Designation</a>
                                <?php } else {
                                	
                                    ?> 
    
                                    <a  class="designation" title="<?php echo ucfirst(strtolower($rec_data[0]['designation'])); ?>"><?php echo ucfirst(strtolower($rec_data[0]['designation'])); ?></a> 
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                    <!-- menubar -->
                    <div class="profile-main-rec-box-menu profile-box-art col-md-12 padding_les">
                        <div class=" right-side-menu art-side-menu padding_less_right right-menu-jr">  
                                <?php
                                $userid = $this->session->userdata('aileenuser');
                                if ($rec_data[0]['user_id'] == $userid) {
                                    ?>     
                                <ul class="current-user pro-fw4">
                                        <?php } else { ?>
                                    <ul class="pro-fw">
                                        <?php } ?>  
                                    <li >
                                       
                                            <a title="Details" href="<?php echo base_url('job/recruiter-profile/' . $rec_post[0]['post_id']); ?>">Details</a>
                                        
                                    </li>
                                    <li class="active">
                                       
                                            <a title="Post" href="<?php echo base_url('job/post-' . $rec_post[0]['post_id'] . '/'. $text.'-vacancy-in-'.$cityname); ?>">Post</a>
                                    </li>
 
                                </ul>
                                <div class="flw_msg_btn fr">
                                    <ul>
                                            
                                            <li>
                                                    <a href="<?php echo base_url('chat/abc/1/2/' . $rec_data[0]['user_id']); ?>">Message</a>
                           
                                            </li>  
                                    </ul>
                                </div>
                        </div>
                    </div>  
                    <!-- menubar -->    
                </div>                       
            </div> 

            <div class="middle-part container rec_res">
                <div class="job-menu-profile mob-none  ">
                    <a href="javascript:void(0);" title="<?php echo $rec_data[0]['rec_firstname'] . ' ' . $rec_data[0]['rec_lastname']; ?>"><h3><?php echo $rec_data[0]['rec_firstname'] . ' ' . $rec_data[0]['rec_lastname']; ?></h3></a>
                    <!-- text head start -->
                    <div class="profile-text" >
                        <?php
                       
                            if ($rec_data[0]['designation'] == "") {
                                ?>
                                <a id="designation" class="designation" title="Designation">Designation</a>
                                <?php
                            } else {
                                ?> 
                                <a id="designation" class="designation" title="<?php echo ucfirst(strtolower($rec_data[0]['designation'])); ?>"><?php echo ucfirst(strtolower($rec_data[0]['designation'])); ?></a>
                                <?php
                            }
                        
                        ?>
                    </div>
                    
                </div>

                <div class="col-md-7 col-sm-12 mob-clear ">
                    <div class="common-form">
                        <div class="job-saved-box">
                            <h3>Post</h3>
                            <div class="contact-frnd-post">
                                         <div class = "job-contact-frnd">
                                       <!--AJAX DATA START FOR RECOMMAND CANDIDATE-->
                                         </div>
                                       <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt='loaderimage'/></div>
                                    </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MIDDLE SECTION END -->
        </section>
        <!-- END CONTAINER -->

        <!-- BEGIN FOOTER -->
         <!--PROFILE PIC MODEL START-->
      <div class="modal fade message-box" id="bidmodal-2" role="dialog">
         <div class="modal-dialog modal-lm">
            <div class="modal-content">
               <button type="button" class="modal-close" data-dismiss="modal">&times;</button>      
               <div class="modal-body">
                  <span class="mes">
                     <div id="popup-form">

                        <div class="fw" id="profi_loader"  style="display:none;" style="text-align:center;" ><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt='loaderimage'/></div>
                     <form id ="userimage" name ="userimage" class ="clearfix" enctype="multipart/form-data" method="post">
                                    <div class="col-md-5">
                                        <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="upload-one" >
                                    </div>
                                    
                                    <div class="col-md-7 text-center">
                                        <div id="upload-demo-one" style="display:none;" style="width:350px"></div>
                                    </div>
                                    <input type="submit" class="upload-result-one" name="profilepicsubmit" id="profilepicsubmit" value="Save" >
                                </form>
                        
                     </div>
                  </span>
               </div>
            </div>
         </div>
      </div>
     <!--PROFILE PIC MODEL END-->
        <!-- START FOOTER -->
        <!-- <footer> -->
            <?php echo $login_footer ?> 
<?php echo $footer; ?>
        <!-- </footer> -->
        <!-- END FOOTER -->


        <!-- FIELD VALIDATION JS START -->
        
        
        <?php
        if (IS_JOB_JS_MINIFY == '0') {
            ?>
          
        <script src="<?php echo base_url('assets/js/croppie.js'); ?>"></script>  
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
       <?php }else{?>
        <script src="<?php echo base_url('assets/js_min/croppie.js'); ?>"></script>  
        <script src="<?php echo base_url('assets/js_min/bootstrap.min.js'); ?>"></script>

       <?php }?>
        <script>
                  var base_url = '<?php echo base_url(); ?>';
                  var id = '<?php echo $rec_data[0]['user_id'];?>';
                  var postid = '<?php echo $rec_post[0]['post_id']; ?>';
        </script>

        <!-- FIELD VALIDATION JS END -->

          <?php
        if (IS_JOB_JS_MINIFY == '0') {
            ?>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/search_common.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/recruiter_post.js'); ?>"></script>
        <?php }else{?>

        <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/job/search_common.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/job/recruiter_post.js'); ?>"></script>
        <?php }?>
    </body>
</html>