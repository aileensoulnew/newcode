<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>
        <?php
            if (IS_ART_CSS_MINIFY == '0') {
                ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dragdrop/fileinput.css?ver='.time()); ?>">
        <link href="<?php echo base_url('assets/dragdrop/themes/explorer/theme.css?ver='.time()); ?>" media="all" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/video.css?ver='.time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver='.time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/artistic.css?ver='.time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />
        <?php }else{?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dragdrop/fileinput.css?ver='.time()); ?>">
        <link href="<?php echo base_url('assets/dragdrop/themes/explorer/theme.css?ver='.time()); ?>" media="all" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/video.css?ver='.time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver='.time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/artistic.css?ver='.time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />
        <?php }?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
        <style type="text/css">
            .two-images, .three-image, .four-image{
            height: auto !important;
            }
            .mejs__overlay-button {
            background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
            .mejs__overlay-loading-bg-img {
            background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
            .mejs__button > button {
            background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
        </style>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push">
        <?php //echo $art_header2_border; ?>
        <?php echo $artistic_header2; ?>
        <div class="user-midd-section bui_art_left_box" id="paddingtop_fixed">
        <div class="container art_container padding-360">
        <div class="">
            <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt" >
            <div class="left_fixed">
                <?php ?>
                <?php echo $left_artistic; ?>
                <?php 
                    if(count($usercount) != count($followcount) + count($crosscount)){?>
                <div class="full-box-module_follow">
                    <div class="common-form">
                        <h3 class="user_list_head">User List</h3>
                        <div class="seeall">
                            <a href="<?php echo base_url('artist/userlist'); ?>" title="View all">View all</a>
                        </div>
                        <div class="profile-boxProfileCard_follow fw  module">
                            <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo 'LOADERIMAGE'; ?>"/></div>
                        </div>
                    </div>
                </div>
                <?php }?>
                <?php echo $left_footer; ?>
            </div>
            </div>
            <div class=" custom-right-art mian_middle_post_box animated fadeInUp">
            <div class="right_side_posrt fl">
                <div class="post-editor col-md-12">
                    <div class="main-text-area col-md-12">
                        <div class="popup-img">
                            <a href="<?php echo base_url('artist/dashboard/' .$get_url) ?>" title="<?php echo ucfirst(strtolower($artisticdata[0]['art_name'])) . ' ' . ucfirst(strtolower($artisticdata[0]['art_lastname'])); ?>">
                            <?php
                                $userimage = $this->db->select('art_user_image')->get_where('art_reg', array('user_id' => $this->session->userdata('aileenuser')))->row()->art_user_image;
                                $userimageposted = $this->db->select('art_user_image')->get_where('art_reg', array('user_id' => $this->session->userdata('aileenuser')))->row()->art_user_image;
                                ?>
                            <?php 
                                if (IMAGEPATHFROM == 'upload') {
                                
                                          if($artisticdata[0]['art_user_image']){
                                              if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $artisticdata[0]['art_user_image'])) { ?>
                            <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo 'NOARTIMAGE'; ?>">
                            <?php } else { ?>
                            <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $artisticdata[0]['art_user_image']; ?>"  alt="<?php echo $artisticdata[0]['art_user_image'];?>">
                            <?php }
                                } else{ ?>
                            <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo 'NOARTIMAGE'; ?>">
                            <?php } }else{
                                $filename = $this->config->item('art_profile_thumb_upload_path') . $artisticdata[0]['art_user_image'];
                                $s3 = new S3(awsAccessKey, awsSecretKey);
                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                
                                          if ($info) { ?>
                            <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $artisticdata[0]['art_user_image']; ?>"  alt="<?php echo $artisticdata[0]['art_user_image'];?>">
                            <?php
                                } else { ?>
                            <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo 'NOARTIMAGE'; ?>">
                            <?php } }?>
                            </a>
                        </div>
                        <div id="myBtn"  class="editor-content popup-text" onclick="return modelopen();">
                            <span > Post Your Art....</span> 
                            <div class="padding-left padding_les_left camer_h">
                                <i class=" fa fa-camera" >
                                </i> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bs-example">
                    <div class="progress progress-striped" id="progress_div">
                        <div class="progress-bar" style="width: 0%;">
                            <span class="sr-only">0%</span>
                        </div>
                    </div>
                </div>
                <div class="custom-user-list">
                    <?php 
                        if(count($usercount) != count($followcount) + count($crosscount)){?>
                    <div class="full-box-module_follow">
                        <div class="common-form">
                            <h3 class="user_list_head">User List</h3>
                            <div class="seeall">
                                <a href="<?php echo base_url('artist/userlist'); ?>" title="View all">View all</a>
                            </div>
                            <div class="profile-boxProfileCard_follow fw  module">
                                <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo 'LOADERIMAGE'; ?>"/></div>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
                <div class="art-all-post">
                </div>
                <div class="nofoundpost"> 
                </div>
                <div class="fw" id="loader_post" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo 'LOADERIMAGE'; ?>"/></div>
            </div>
            </div>
             <div class="right_middle_side_posrt animated fadeInRightBig fixed_right_display" id="hideuserlist" >
            <!-- <div class="all-profile-box">
                <div class="all-pro-head">
                    <h4>Profiles<a href="<?php echo base_url('profiles/') . $this->session->userdata('aileenuser_slug'); ?>" class="pull-right" title="All">All</a></h4>
                </div>
                <ul class="all-pr-list">
                    <li>
                        <a href="<?php echo base_url('job'); ?>" title="Job Profile">
                            <div class="all-pr-img">
                                <img src="<?php echo base_url('assets/img/i1.jpg'); ?>" alt="<?php echo 'i1.jpg';?>">
                            </div>
                            <span>Job Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('recruiter'); ?>" title="Recruiter Profile">
                            <div class="all-pr-img">
                                <img src="<?php echo base_url('assets/img/i2.jpg'); ?>" alt="<?php echo 'i2.jpg';?>">
                            </div>
                            <span>Recruiter Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('freelance'); ?>" title="Freelance Profile">
                            <div class="all-pr-img">
                                <img src="<?php echo base_url('assets/img/i3.jpg'); ?>" alt="<?php echo 'i3.jpg';?>">
                            </div>
                            <span>Freelance Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('business-profile'); ?>" title="Business Profile">
                            <div class="all-pr-img">
                                <img src="<?php echo base_url('assets/img/i4.jpg'); ?>" alt="<?php echo 'i4.jpg';?>">
                            </div>
                            <span>Business Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('artist'); ?>" title="Artistic Profile">
                            <div class="all-pr-img">
                                <img src="<?php echo base_url('assets/img/i5.jpg'); ?>" alt="<?php echo 'i5.jpg';?>">
                            </div>
                            <span>Artistic Profile</span>
                        </a>
                    </li>
                </ul>
            </div> -->
            <div class="left-search-box list-type-bullet">
                <div class="">
                    <h3>Categories</h3>
                </div>
                <ul class="search-listing">
                    <li>
                        <label class=""><a href="#">Agriculture<span class="pull-right">(50)</span></a></label>
                    </li>
                    <li>
                        <label class=""><a href="#">Agriculture<span class="pull-right">(50)</span></a></label>
                    </li>
                    <li>
                        <label class=""><a href="#">Agriculture<span class="pull-right">(50)</span></a></label>
                    </li>
                    <li>
                        <label class=""><a href="#">Agriculture<span class="pull-right">(50)</span></a></label>
                    </li>
                    <li>
                        <label class=""><a href="#">Agriculture<span class="pull-right">(50)</span></a></label>
                    </li>
                    <li>
                        <label class=""><a href="#">Agriculture<span class="pull-right">(50)</span></a></label>
                    </li>
                    <li>
                        <label class=""><a href="#">Agriculture<span class="pull-right">(50)</span></a></label>
                    </li>
                    
                </ul>
                <p class="text-right p10"><a href="#">More Categories</a></p>
            </div>
            <div class="left-search-box list-type-bullet">
                <div class="">
                    <h3>Top Cities</h3>
                </div>
                <ul class="search-listing">
                    <li>
                        <label class=""><a href="#">IT<span class="pull-right">(50)</span></a></label>
                    </li>
                    <li>
                        <label class=""><a href="#">IT<span class="pull-right">(50)</span></a></label>
                    </li>
                    <li>
                        <label class=""><a href="#">IT<span class="pull-right">(50)</span></a></label>
                    </li>
                    <li>
                        <label class=""><a href="#">IT<span class="pull-right">(50)</span></a></label>
                    </li>
                    <li>
                        <label class=""><a href="#">IT<span class="pull-right">(50)</span></a></label>
                    </li>
                    <li>
                        <label class=""><a href="#">IT<span class="pull-right">(50)</span></a></label>
                    </li>
                    <li>
                        <label class=""><a href="#">IT<span class="pull-right">(50)</span></a></label>
                    </li>
                    
                </ul>
                <p class="text-right p10"><a href="#">More Categories</a></p>
            </div>
        </div>
        <!-- Bid-modal  -->
        <div class="modal fade message-box biderror" id="bidmodal-limit" role="dialog">
            <div class="modal-dialog modal-lm deactive">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal" id="common-limit">&times;</button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Model Popup Close -->
        <!-- Bid-modal  -->
        <div class="modal fade message-box biderror" id="bidmodal" role="dialog"  >
            <div class="modal-dialog modal-lm" >
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Model Popup Close -->
        <div class="modal fade message-box biderror" id="bidmodaleditpost" role="dialog"  >
            <div class="modal-dialog modal-lm" >
                <div class="modal-content">
                    <button type="button" class="modal-close editpost" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bid-modal-2  -->
        <div class="modal fade message-box" id="likeusermodal" role="dialog" >
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Model Popup Close -->
        <!-- Bid-modal for this modal appear or not start -->
        <div class="modal fade message-box" id="post" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" id="post" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box" id="postedit" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" id="postedit" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bid-modal for this modal appear or not  Popup Close -->
        <!-- The Modal -->
        <div id="myModal" class="modal-post">
            <!-- Modal content -->
            <div class="modal-content-post">
                <span class="close1">&times;</span>
                <div class="post-editor col-md-12 post-edit-popup" id="close">
                    <?php echo form_open_multipart(base_url('artist/art_post_insert/'), array('id' => 'artpostform', 'name' => 'artpostform', 'class' => 'clearfix upload-image-form', 'onsubmit' => "return imgval(event)")); ?>
                    <div class="main-text-area " >
                        <div class="popup-img-in "> 
                            <?php 
                                if (IMAGEPATHFROM == 'upload') {
                                
                                           if($artisticdata[0]['art_user_image']){
                                               if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $artisticdata[0]['art_user_image'])) { ?>
                            <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="NOARTIMAGE">
                            <?php } else { ?>
                            <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $artisticdata[0]['art_user_image']; ?>"  alt="<?php echo $artisticdata[0]['art_user_image']; ?>">
                            <?php }
                                } else{ ?>
                            <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="NOARTIMAGE">
                            <?php } }else{
                                $filename = $this->config->item('art_profile_thumb_upload_path') . $artisticdata[0]['art_user_image'];
                                $s3 = new S3(awsAccessKey, awsSecretKey);
                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                
                                if ($info) { ?>
                            <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $artisticdata[0]['art_user_image']; ?>"  alt="<?php echo  $artisticdata[0]['art_user_image']; ?>">
                            <?php
                                } else { ?>
                            <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="NOARTIMAGE">
                            <?php } }?>
                        </div>
                        <div id="myBtn"  class="editor-content col-md-10 popup-text" >
                            <textarea id= "test-upload_product" placeholder="Post Your Art...."   onKeyPress=check_length(this.form); onKeyDown=check_length(this.form); onKeyup=check_length(this.form); onblur="check_length(this.form)" name=my_text rows=4 cols=30 class="post_product_name" style="position: relative;"></textarea>
                            <div class="fifty_val">                       
                                <input size=1 class="text_num" tabindex="-500" value=50 name=text_num disabled="disabled"> 
                            </div>
                            <div class="padding-left padding_les_left camer_h">
                                <i class=" fa fa-camera" >
                                </i> 
                            </div>
                        </div>
                    </div>
                    <div class="row"></div>
                    <div  id="text"  class="editor-content col-md-12 popup-textarea" >
                        <textarea id="test-upload_des" name="product_desc" class="description" placeholder="Enter Description"></textarea>
                        <output id="list"></output>
                    </div>
                    <div class="popup-social-icon">
                        <ul class="editor-header">
                            <li>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input id="file-1" type="file" class="file" name="postattach[]"  multiple class="file" data-overwrite-initial="false" data-min-file-count="2" style="visibility:hidden;">
                                    </div>
                                </div>
                                <label for="file-1">
                                <i class=" fa fa-camera upload_icon"  ><span class="upload_span_icon"> Photo</span></i>
                                <i class=" fa fa-video-camera upload_icon"  ><span class="upload_span_icon"> Video </span></i>
                                <i class="fa fa-music upload_icon "  ><span class="upload_span_icon"> Audio </span></i>
                                <i class=" fa fa-file-pdf-o upload_icon"  > <span class="upload_span_icon">PDF </span></i>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="fr">
                        <button type="submit"  value="Submit">Post</button>    
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
        <?php echo $footer; ?>
        <?php
            if (IS_ART_JS_MINIFY == '0') { ?>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver='.time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.form.3.51.js?ver='.time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/plugins/sortable.js?ver='.time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/fileinput.js?ver='.time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/locales/fr.js?ver='.time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/locales/es.js?ver='.time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/themes/explorer/theme.js?ver='.time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/demo.js?ver=' . time()); ?>"></script>
        <?php }else{?>
        <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver='.time()); ?>"></script>
        <script src="<?php echo base_url('assets/js_min/jquery.form.3.51.js?ver='.time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js_min/plugins/sortable.js?ver='.time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js_min/fileinput.js?ver='.time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js_min/locales/fr.js?ver='.time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/locales/es.js?ver='.time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/themes/explorer/theme.js?ver='.time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/demo.js?ver=' . time()); ?>"></script>
        <?php }?>
        <script type="text/javascript">
            var base_url = '<?php echo base_url(); ?>';   
            var data= <?php echo json_encode($demo); ?>;
            var data1 = <?php echo json_encode($city_data); ?>;
            var complex = <?php echo json_encode($selectdata); ?>;
            var textarea = document.getElementById("textarea");
             var no_artistic_post_html = '<?php echo $no_artistic_post_html ?>';
        </script>
            <script>
                 var header_all_profile = '<?php echo $header_all_profile; ?>';
            </script>
            <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <?php
            if (IS_ART_JS_MINIFY == '0') { ?>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/home.js?ver='.time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
        <?php }else{?>

        <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/home.js?ver='.time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
        <?php }?>
    </body>
</html>

