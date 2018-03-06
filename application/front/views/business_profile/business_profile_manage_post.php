<?php
$s3 = new S3(awsAccessKey, awsSecretKey);
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>
        <?php if (IS_BUSINESS_CSS_MINIFY == '0') { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dragdrop/fileinput.css?ver=' . time()); ?>" />
            <link href="<?php echo base_url('assets/dragdrop/themes/explorer/theme.css?ver=' . time()); ?>" media="all" rel="stylesheet" type="text/css"/>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>" />
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/business.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />
        <?php } else { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dragdrop/fileinput.css?ver=' . time()); ?>" />
            <link href="<?php echo base_url('assets/dragdrop/themes/explorer/theme.css?ver=' . time()); ?>" media="all" rel="stylesheet" type="text/css"/>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>" />
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/business.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />
        <?php } ?>
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
    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push">
        <?php echo $header; ?>
        <?php echo $business_header2_border; ?>
        <section>
            <?php echo $business_common; ?>
            <div class="text-center tab-block">
                <div class="container mob-inner-page">
                    <a href="<?php echo base_url('business-profile/photos/' . $business_common_data[0]['business_slug']) ?>">
                        Photo
                    </a>
                    <a href="<?php echo base_url('business-profile/videos/' . $business_common_data[0]['business_slug']) ?>">
                        Video
                    </a>
                    <a href="<?php echo base_url('business-profile/audios/' . $business_common_data[0]['business_slug']) ?>">
                        Audio
                    </a>
                    <a href="<?php echo base_url('business-profile/pdf/' . $business_common_data[0]['business_slug']) ?>">
                        PDf
                    </a>
                </div>
            </div>
            <div class="user-midd-section">
                <div class="container art_container padding-360 manage-post-custom">
                    <div class="profile-box-custom left_side_posrt">
                        <div class="full-box-module business_data">
                            <div class="profile-boxProfileCard  module">
                                <div class="head_details1">
                                    <span><a href="<?php echo base_url('business-profile/details/' . $business_common_data[0]['business_slug']); ?>"><h5><i class="fa fa-info-circle" aria-hidden="true"></i>Information</h5></a>
                                    </span>      
                                </div>
                                <table class="business_data_table">
                                    <tr>
                                        <td class="business_data_td1 detaile_map"><i class="fa fa-user"></i></td>
                                        <td class="business_data_td2"><?php echo ucfirst(strtolower($business_data[0]['contact_person'])); ?></td>
                                    </tr>

                                   <?php if ($business_data[0]['contact_mobile'] != '0') { ?>
                                    <tr>
                                        <td class="business_data_td1 detaile_map"><i class="fa fa-mobile"></i></td>
                                        <td class="business_data_td2"><span><?php
                                                
                                                    echo $business_data[0]['contact_mobile'];
                                               
                                                ?></span>
                                        </td>
                                    </tr>
                                    <?php }?>
                                    <tr>
                                        <td class="business_data_td1 detaile_map"><i class="fa fa-envelope-o" aria-hidden="true"></i></td>
                                        <td class="business_data_td2"><span><?php echo $business_data[0]['contact_email']; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td class="business_data_td1 detaile_map"><i class="fa fa-map-marker"></i></td>
                                        <td class="business_data_td2"><span>
                                                <?php
                                                if ($business_data[0]['address']) {
                                                    echo $business_data[0]['address'];
                                                    echo ",";
                                                }
                                                ?> 
                                                <?php
                                                if ($business_data[0]['city']) {
                                                    echo $this->db->get_where('cities', array('city_id' => $business_data[0]['city']))->row()->city_name;
                                                    echo",";
                                                }
                                                ?> 
                                                <?php
                                                if ($business_data[0]['country']) {
                                                    echo $this->db->get_where('countries', array('country_id' => $business_data[0]['country']))->row()->country_name;
                                                }
                                                ?> 
                                            </span></td>
                                    </tr>
                                    <?php
                                    if ($business_data[0]['contact_website']) {
                                        ?>
                                        <tr>
                                            <td class="business_data_td1 detaile_map"><i class="fa fa-globe"></i></td>
                                            <td class="business_data_td2 website"><span><a target="_blank" href="<?php echo $business_data[0]['contact_website']; ?>"> <?php echo $business_data[0]['contact_website']; ?></a></span></td>
                                        </tr>
                                    <?php } ?>

                                    
                                    <?php if($business_data[0]['details']){?>
                                    <tr>
                                        <td class="business_data_td1 detaile_map"><i class="fa fa-suitcase"></i></td>
                                        <?php
                                        $bus_detail = nl2br($this->common->make_links($business_data[0]['details']));
                                        $bus_detail = preg_replace('[^(<br( \/)?>)*|(<br( \/)?>)*$]', '', $bus_detail);
                                        ?>
                                        <td class="business_data_td2"><span><?php echo $bus_detail; ?></span></td>
                                    </tr>
                                    <?php }?>
                                </table>
                            </div>
                        </div>
                        <a href="<?php echo base_url('business-profile/photos/' . $business_common_data[0]['business_slug']) ?>">
                            <div class="full-box-module business_data">
                                <div class="profile-boxProfileCard  module buisness_he_module" >
                                    <div class="head_details">
                                        <h5><i class="fa fa-camera" aria-hidden="true"></i>   Photos</h5>
                                    </div>
                                    <div class="bus_photos">
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="<?php echo base_url('business-profile/videos/' . $business_common_data[0]['business_slug']) ?>">
                            <div class="full-box-module business_data">
                                <div class="profile-boxProfileCard  module">
                                    <table class="business_data_table">
                                        <div class="head_details">
                                            <h5><i class="fa fa-video-camera" aria-hidden="true"></i>Video</h5>
                                        </div>
                                        <div class="bus_videos">
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </a>
                        <div class="full-box-module business_data">
                            <div class="profile-boxProfileCard  module">
                                <a href="<?php echo base_url('business-profile/audios/' . $business_common_data[0]['business_slug']) ?>"> 
                                    <div class="head_details1">
                                        <h5><i class="fa fa-music" aria-hidden="true"></i>Audio</h5>
                                    </div>
                                </a>
                                <table class="business_data_table">
                                    <div class="bus_audios"> 
                                    </div>
                                </table>
                            </div>
                        </div>
                        <a href="<?php echo base_url('business-profile/pdf/' . $business_common_data[0]['business_slug']) ?>">
                            <div class="full-box-module business_data">
                                <div class="profile-boxProfileCard  module buisness_he_module" >
                                    <div class="head_details">
                                        <h5><i class="fa fa-file-pdf-o" aria-hidden="true"></i>  PDF</h5>
                                    </div>      
                                    <div class="bus_pdf"></div>
                                </div>
                            </div>
                        </a>
                        <?php echo $left_footer; ?>
                    </div>
                    <div class=" custom-right-art mian_middle_post_box animated fadeInUp custom-right-business">
                        <?php
                        if ($is_eligable_for_post == 1) {
                            ?>
                            <div class="post-editor col-md-12">
                                <div class="main-text-area col-md-12">
                                    <div class="popup-img"> 
                                        <?php if ($business_login_user_image) { ?>
                                            <?php
                                            if (IMAGEPATHFROM == 'upload') {
                                                if (!file_exists($this->config->item('bus_profile_main_upload_path') . $business_login_user_image)) {
                                                    ?>
                                                    <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="No Business Image">
                                                <?php } else {
                                                    ?>
                                                    <img  src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_login_user_image; ?>"  alt="Business Login User">
                                                    <?php
                                                }
                                            } else {
                                                $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_login_user_image;
                                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                if (!$info) {
                                                    ?>
                                                    <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="No Business Image">
                                                <?php } else {
                                                    ?>
                                                    <img  src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_login_user_image; ?>"  alt="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_login_user_image; ?>">
                                                    <?php
                                                }
                                            }
                                        } else {
                                            ?>
                                            <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="No Business Image">
                                        <?php } ?>
                                    </div>
                                    <div id="myBtn1"  class="editor-content popup-text" onclick="return modelopen();">
                                        <span>Post Your Product....</span>
                                        <div class="padding-left padding_les_left camer_h">
                                            <i class=" fa fa-camera">
                                            </i> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div id="myModal3" class="modal-post">
                            <div class="modal-content-post">
                                <span class="close3">&times;</span>
                                <div class="post-editor post-edit-popup" id="close">
                                    <?php echo form_open_multipart(base_url('business-profile/bussiness-profile-post-add/' . 'manage/' . $business_data[0]['user_id']), array('id' => 'artpostform', 'name' => 'artpostform', 'class' => 'clearfix dashboard-upload-image-form', 'onsubmit' => "imgval(event)")); ?>
                                    <div class="main-text-area col-md-12"  >
                                        <div class="popup-img-in"> 
                                            <?php
                                            if ($business_login_user_image != '') {
                                                ?>
                                                <?php
                                                if (IMAGEPATHFROM == 'upload') {
                                                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_login_user_image)) {
                                                        ?>
                                                        <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="No Image">
                                                    <?php } else {
                                                        ?>
                                                        <img  src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_login_user_image; ?>"  alt="Business Profile">
                                                        <?php
                                                    }
                                                } else {
                                                    $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_login_user_image;
                                                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                    if (!$info) {
                                                        ?>
                                                        <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="No Image">
                                                    <?php } else {
                                                        ?>
                                                        <img  src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_login_user_image; ?>"  alt="Business Profile">
                                                        <?php
                                                    }
                                                }
                                            } else {
                                                ?>
                                                <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="No Image">
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div id="myBtn1"  class="editor-content col-md-10 popup-text" >
                                            <textarea id= "test-upload_product" placeholder="Post Your Product...."  onKeyPress=check_length(this.form); onKeyDown=check_length(this.form); 
                                                      name=my_text rows=4 cols=30 class="post_product_name" style="position: relative;" tabindex="1"></textarea>
                                            <div class="fifty_val">                   
                                                <input size=1 value=50 name=text_num class="text_num" disabled="disabled"> 
                                            </div>
                                            <div class="padding-left camera_in camer_h" ><i class=" fa fa-camera " ></i> </div>
                                        </div>
                                    </div>
                                    <div class="row"></div>
                                    <div  id="text"  class="editor-content col-md-12 popup-textarea" >
                                        <textarea id="test-upload_des" name="product_desc" class="description" placeholder="Enter Description" tabindex="2"></textarea>
                                        <output id="list"></output>
                                    </div>
                                    <div class="print_privew_post">
                                    </div>
                                    <div class="preview"></div>
                                    <div id="data-vid" class="large-8 columns">
                                    </div>
                                    <h2 id="name-vid"></h2>
                                    <p id="size-vid"></p>
                                    <p id="type-vid"></p>
                                    <div class="popup-social-icon">
                                        <ul class="editor-header">
                                            <li>
                                                <div class="col-md-12"> <div class="form-group">
                                                        <input id="file-1" type="file" class="file" name="postattach[]"  multiple class="file" data-overwrite-initial="false" data-min-file-count="2" style="display: none;">
                                                    </div></div>
                                                <label for="file-1">
                                                    <i class=" fa fa-camera upload_icon"  ><span class="upload_span_icon"> Photo </span> </i>
                                                    <i class=" fa fa-video-camera upload_icon"> <span class="upload_span_icon">Video </span> </i> 
                                                    <i class="fa fa-music upload_icon"><span class="upload_span_icon"> Audio</span> </i>
                                                    <i class=" fa fa-file-pdf-o upload_icon"><span class="upload_span_icon"> PDF </span></i>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="fr margin_btm">
                                        <button type="submit"  value="Submit">Post</button>    
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($this->session->flashdata('error')) {
                            echo $this->session->flashdata('error');
                        }
                        ?>
                        <div class="fw">
                            <div class="bs-example">
                                <div class="progress progress-striped" id="progress_div">
                                    <div class="progress-bar" style="width: 0%;">
                                        <span class="sr-only">0%</span>
                                    </div>
                                </div>
                            </div>

                            <div class="business-all-post">
                            </div>
                            <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" alt="Loader" /></div>
                        </div>
                    </div>

                    <div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig"> 
                    </div>
                </div>
            </div>
        </section>
        <div class="modal fade message-box" id="likeusermodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close1" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box" id="post" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" id="post"data-dismiss="modal">&times;</button>       
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
                    <button type="button" class="modal-close" id="postedit"data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box" id="query" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="profile-modal-close" id="query" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade message-box" id="bidmodal-3" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="profile-modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $footer; ?>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var slug = '<?php echo $slugid; ?>';
            var no_business_post_html = '<?php echo $no_business_post_html ?>';
        </script>
        <?php if (IS_BUSINESS_JS_MINIFY == '0') { ?>
            <script src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
            <script type = "text/javascript" src="<?php echo base_url('assets/js/jquery.form.3.51.js?ver=' . time()) ?>"></script> 
            <script src="<?php echo base_url('assets/dragdrop/js/plugins/sortable.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/dragdrop/js/fileinput.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/dragdrop/js/locales/fr.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/dragdrop/js/locales/es.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/dragdrop/themes/explorer/theme.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/demo.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/dashboard.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
        <?php } else { ?>
            <script src="<?php echo base_url('assets/js_min/croppie.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()); ?>"></script>
            <script type = "text/javascript" src="<?php echo base_url('assets/js_min/jquery.form.3.51.js?ver=' . time()) ?>"></script> 
            <script src="<?php echo base_url('assets/dragdrop/js_min/plugins/sortable.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/dragdrop/js_min/fileinput.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/dragdrop/js_min/locales/fr.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/dragdrop/js_min/locales/es.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/dragdrop/themes/explorer/theme.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/demo.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/business-profile/dashboard.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js_min/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
        <?php } ?>
    </body>
</html>
