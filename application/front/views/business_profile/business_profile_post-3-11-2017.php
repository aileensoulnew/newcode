<?php
$s3 = new S3(awsAccessKey, awsSecretKey);
$mobile_agent = $this->agent->mobile;
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php if (IS_BUSINESS_CSS_MINIFY == '0') { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dragdrop/fileinput.css?ver=' . time()); ?>">
            <link href="<?php echo base_url('assets/dragdrop/themes/explorer/theme.css?ver=' . time()); ?>" media="all" rel="stylesheet" type="text/css"/>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/business.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />
        <?php } else { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/business_profile/business_profile.min.css?ver=' . time()); ?>">
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
        <!-- START HEADER -->
        <?php echo $header; ?>
        <!-- END HEADER -->
        <?php echo $business_header2_border; ?>
        <section>
            <div class="user-midd-section bui_art_left_box" id="paddingtop_fixed">
                <div class="container art_container padding-360">
                    <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt" >
                        <div class="left_fixed">
                            <?php echo $business_left; ?>
                            <div class="full-box-module_follow fw">
                                <!-- follower list start  -->  
                                <div class="common-form">
                                    <h3 class="user_list_head">User List
                                    </h3>
                                    <div class="seeall">
                                        <a href="<?php echo base_url('business-profile/userlist/' . $business_common_data[0]['business_slug']); ?>">All User
                                        </a>
                                    </div>
                                </div>
                                <!-- GET USER FOLLOE SUGESSION LIST START [AJAX DATA DISPLAY UNDER profile-boxProfileCard_follow CLASS]-->
                                <div class="profile-boxProfileCard_follow fw  module">
                                </div>
                                <!-- GET USER FOLLOE SUGESSION LIST START -->
                                <!-- follower list end  -->
                            </div>
                            
							<div class="tablate-potrat-add">
                                <div class="fw text-center pt10">
                                    <script type="text/javascript">
                                        (function () {
                                            if (window.CHITIKA === undefined) {
                                                window.CHITIKA = {'units': []};
                                            }
                                            ;
                                            var unit = {"calltype": "async[2]", "publisher": "Aileensoul", "width": 300, "height": 250, "sid": "Chitika Default"};
                                            var placement_id = window.CHITIKA.units.length;
                                            window.CHITIKA.units.push(unit);
                                            document.write('<div id="chitikaAdBlock-' + placement_id + '"></div>');
                                        }());
                                    </script>
                                    <script type="text/javascript" src="//cdn.chitika.net/getads.js" async></script>
                                </div>
                            </div>
                            <div class="custom_footer_left fw">
                                <div class="fl">
                                    <ul>
                                        <li><a href="<?php echo base_url('about-us'); ?>" target="_blank"><span class="custom_footer_dot" role="presentation" aria-hidden="true"> · </span> About Us </a></li>
                                        <li><a href="<?php echo base_url('contact-us'); ?>" target="_blank"><span class="custom_footer_dot" role="presentation" aria-hidden="true"> · </span> Contact Us</a></li>
                                        <li><a href="<?php echo base_url('blog'); ?>" target="_blank"><span class="custom_footer_dot" role="presentation" aria-hidden="true"> · </span> Blogs</a></li>
                                        <li><a href="<?php echo base_url('privacy-policy'); ?>" target="_blank"><span class="custom_footer_dot" role="presentation" aria-hidden="true"> · </span> Privacy Policy</a></li>
                                        <li><a href="<?php echo base_url('terms-and-condition'); ?>" target="_blank"><span class="custom_footer_dot" role="presentation" aria-hidden="true"> · </span> Terms &amp; Condition </a></li>

                                        <li><a href="<?php echo base_url('feedback'); ?>" target="_blank"><span class="custom_footer_dot" role="presentation" aria-hidden="true"> · </span> Send Us Feedback</a></li>
                                    </ul>
                                </div>
                                <div>

                                </div>

                            </div>
                        </div>
                        <br>
                        <div id="result"></div>   
                    </div>
                    <?php
                    if ($this->session->flashdata('error')) {
                        echo $this->session->flashdata('error');
                    }
                    ?>
                    <div class=" custom-right-art mian_middle_post_box animated fadeInUp">
                        <div class="right_side_posrt fl"> 
                            <div class="post-editor col-md-12">
                                <div class="main-text-area col-md-12">
                                    <div class="popup-img"> 
                                        <?php if ($business_common_data[0]['business_user_image']) { ?>
                                            <?php
                                            if (IMAGEPATHFROM == 'upload') {
                                                if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_common_data[0]['business_user_image'])) {
                                                    ?>
                                                    <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="">
                                                <?php } else {
                                                    ?>
                                                    <img src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_common_data[0]['business_user_image']; ?>"  alt="">
                                                    <?php
                                                }
                                            } else {
                                                $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_common_data[0]['business_user_image'];
                                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                if (!$info) {
                                                    ?>
                                                    <img src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="No Image">
                                                <?php } else {
                                                    ?>
                                                    <img  src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_common_data[0]['business_user_image']; ?>"  alt="">
                                                    <?php
                                                }
                                            }
                                        } else {
                                            ?>
                                            <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="">
                                        <?php } ?>
                                    </div>
                                    <div id="myBtn"  class="editor-content popup-text">
                                        <span> <?php echo $this->lang->line("post_your_product"); ?></span> 
                                        <div class="padding-left padding_les_left camer_h">
                                            <i class="fa fa-camera"></i> 
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
							<div class="full-box-module_follow fw">
                                <!-- follower list start  -->  
                                <div class="common-form">
                                    <h3 class="user_list_head">User List
                                    </h3>
                                    <div class="seeall">
                                        <a href="<?php echo base_url('business-profile/userlist/' . $business_common_data[0]['business_slug']); ?>">All User
                                        </a>
                                    </div>
                                </div>
                                <!-- GET USER FOLLOE SUGESSION LIST START [AJAX DATA DISPLAY UNDER profile-boxProfileCard_follow CLASS]-->
                                <div class="profile-boxProfileCard_follow fw  module">
                                </div>
                                <!-- GET USER FOLLOE SUGESSION LIST START -->
                                <!-- follower list end  -->
                            </div>
							</div>
                            <div class="business-all-post">
                                <?php
                                if ($mobile_agent) {
                                    ?>
                                    <div class="mob-add">
                                        <div class="fw text-center pt10 pb5">
                                            <script type="text/javascript">
                                            (function () {
                                                if (window.CHITIKA === undefined) {
                                                    window.CHITIKA = {'units': []};
                                                }
                                                ;
                                                var unit = {"calltype": "async[2]", "publisher": "Aileensoul", "width": 300, "height": 250, "sid": "Chitika Default"};
                                                var placement_id = window.CHITIKA.units.length;
                                                window.CHITIKA.units.push(unit);
                                                document.write('<div id="chitikaAdBlock-' + placement_id + '"></div>');
                                            }());
                                            </script>
                                            <script type="text/javascript" src="//cdn.chitika.net/getads.js" async></script>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="nofoundpost"> 
                                </div>
                            </div>
                            <div class="fw" id="loader" style="text-align:center; display: none;"><img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" /></div>
                        </div>
                    </div>
                    <div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig"> 

                        <div class="fw text-center">
                            <script type="text/javascript">
                                        (function () {
                                            if (window.CHITIKA === undefined) {
                                                window.CHITIKA = {'units': []};
                                            }
                                            ;
                                            var unit = {"calltype": "async[2]", "publisher": "Aileensoul", "width": 300, "height": 250, "sid": "Chitika Default"};
                                            var placement_id = window.CHITIKA.units.length;
                                            window.CHITIKA.units.push(unit);
                                            document.write('<div id="chitikaAdBlock-' + placement_id + '"></div>');
                                        }());
                            </script>
                            <script type="text/javascript" src="//cdn.chitika.net/getads.js" async></script>
							<div class="fw pt10">
									<a href="http://www.chitika.com/publishers/apply?refid=aileensoul"><img src="http://images.chitika.net/ref_banners/300x250_tired_of_adsense.png" /></a>
								</div>
                        </div>
                       
                    </div>
                    <div class="tablate-add">

                            <script type="text/javascript">
						  ( function() {
							if (window.CHITIKA === undefined) { window.CHITIKA = { 'units' : [] }; };
							var unit = {"calltype":"async[2]","publisher":"Aileensoul","width":160,"height":600,"sid":"Chitika Default"};
							var placement_id = window.CHITIKA.units.length;
							window.CHITIKA.units.push(unit);
							document.write('<div id="chitikaAdBlock-' + placement_id + '"></div>');
						}());
						</script>
						<script type="text/javascript" src="//cdn.chitika.net/getads.js" async></script>
                        </div>
                </div>
            </div>
        </section>
        <!-- The Modal -->
        <div id="myModal" class="modal-post">
            <!-- Modal content -->
            <div class="modal-content-post">
                <span class="close1">&times;
                </span>
                <div class="post-editor col-md-12 post-edit-popup" id="close">
                    <?php echo form_open_multipart(base_url('business-profile/bussiness-profile-post-add'), array('id' => 'artpostform', 'name' => 'artpostform', 'class' => 'clearfix upload-image-form', 'onsubmit' => "return imgval(event)")); ?>
                    <div class="main-text-area col-md-12" >
                        <div class="popup-img-in"> 
                            <?php
                            if ($business_common_data[0]['business_user_image'] != '') {
                                ?>
                                <?php
                                if (IMAGEPATHFROM == 'upload') {
                                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_common_data[0]['business_user_image'])) {
                                        ?>
                                        <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="No Image">
                                    <?php } else {
                                        ?>
                                        <img src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_common_data[0]['business_user_image']; ?>"  alt="">
                                        <?php
                                    }
                                } else {
                                    $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_common_data[0]['business_user_image'];
                                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                    if (!$info) {
                                        ?>
                                        <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="No Image">
                                    <?php } else {
                                        ?>
                                        <img src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_common_data[0]['business_user_image']; ?>"  alt="">
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
                            <textarea id="test-upload-product" placeholder="<?php echo $this->lang->line("post_your_product"); ?>"  onKeyPress=check_length(this.form); onKeyUp=check_length(this.form); onKeyDown=check_length(this.form); onblur=check_length(this.form);  name=my_text rows=4 cols=30 class="post_product_name" style=" position: relative;" tabindex="1"></textarea>
                            <div class="fifty_val">                       
                                <input size=1 value=50 name=text_num class="text_num"  disabled="disabled"> 
                            </div>
                            <div class="camera_in padding-left padding_les_left camer_h">
                                <i class=" fa fa-camera" >
                                </i> 
                            </div>
                        </div>
                    </div>
                    <div class="row"></div>
                    <div  id="text"  class="editor-content col-md-12 popup-textarea" >
                        <textarea id="test-upload-des" name="product_desc" class="description" placeholder="Enter Description" tabindex="2"></textarea>
                    </div>
                    <div class="print_privew_post"></div>
                    <div class="preview"></div>
                    <div id="data-vid" class="large-8 columns"></div>
                    <h2 id="name-vid"></h2>
                    <p id="size-vid"></p>
                    <p id="type-vid"></p>
                    <div class="popup-social-icon">
                        <ul class="editor-header">
                            <li>
                                <div class="col-md-12"> 
                                    <div class="form-group">
                                        <input id="file-1" type="file" class="file" name="postattach[]"  multiple class="file" data-overwrite-initial="false" data-min-file-count="2" style="display: none;">
                                    </div>
                                </div>
                                <label for="file-1">
                                    <i class="fa fa-camera upload_icon"><span class="upload_span_icon"> Photo </span></i>
                                    <i class="fa fa-video-camera upload_icon"><span class="upload_span_icon"> Video</span>  </i> 
                                    <i class="fa fa-music upload_icon"> <span class="upload_span_icon">  Audio </span> </i>
                                    <i class="fa fa-file-pdf-o upload_icon"><span class="upload_span_icon"> PDF </span></i>
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
        <div class="modal fade message-box biderror" id="bidmodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;
                    </button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bid-modal  -->
        <div class="modal fade message-box biderror" id="posterrormodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="posterror-modal-close" data-dismiss="modal">&times;
                    </button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Model Popup Close -->

        <!-- Bid-modal-2  -->
        <div class="modal fade message-box" id="likeusermodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close1" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Model Popup Close -->


        <!-- Bid-modal for this modal appear or not start -->
        <div class="modal fade message-box" id="post" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" id="post"data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bid-modal for this modal appear or not  Popup Close -->

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
        <!-- <footer> -->
            <?php echo $footer; ?>
        <!-- </footer> -->
        <!--<script src="<?php // echo base_url('assets/js/jquery.wallform.js?ver=' . time());              ?>"></script>-->
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script type = "text/javascript" src="<?php echo base_url('assets/js/jquery.form.3.51.js?ver=' . time()) ?>"></script> 
        <!-- POST BOX JAVASCRIPT START --> 
        <script src="<?php echo base_url('assets/dragdrop/js/plugins/sortable.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/fileinput.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/locales/fr.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/locales/es.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/themes/explorer/theme.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/demo.js?ver=' . time()); ?>"></script>
        <!-- POST BOX JAVASCRIPT END --> 
        <script>
                                var base_url = '<?php echo base_url(); ?>';
                                var no_business_post_html = '<?php echo $no_business_post_html ?>';
        </script>
        <?php if (IS_BUSINESS_JS_MINIFY == '0') { ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/home.js?ver=' . time()); ?>"></script>
        <?php } else { ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/business-profile/common.min.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/business-profile/home.min.js?ver=' . time()); ?>"></script>
        <?php } ?>
    </body>
</html>
