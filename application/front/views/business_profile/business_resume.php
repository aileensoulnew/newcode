<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>  
        <?php
        if (IS_BUSINESS_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/business.css?ver=' . time()); ?>">
            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/business.css?ver=' . time()); ?>">
        <?php } ?>
    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push botton_footer">
        <?php echo $header; ?>
        <?php echo $business_header2_border; ?>
        <section>
            <?php echo $business_common; ?>
            <div class="user-midd-section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3" style="width: 22%;"></div>
                        <div class="col-md-7 col-sm-12">
                            <div class="common-form">
                                <div class="job-saved-box">
                                    <h3>Details </h3> 
                                    <div class=" fr rec-edit-pro">
                                        <?php

                                        function text2link($text) {
                                            $text = preg_replace('/(((f|ht){1}t(p|ps){1}:\/\/)[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '<a href="\\1" target="_blank" rel="nofollow">\\1</a>', $text);
                                            $text = preg_replace('/([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '\\1<a href="http://\\2" target="_blank" rel="nofollow">\\2</a>', $text);
                                            $text = preg_replace('/([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})/i', '<a href="mailto:\\1" rel="nofollow" target="_blank">\\1</a>', $text);
                                            return $text;
                                        }
                                        ?>      
                                    </div> 
                                    <div class="contact-frnd-post">
                                        <div class="job-contact-frnd ">
                                            <div class="profile-job-post-detail clearfix">
                                                <div class="profile-job-post-title clearfix">
                                                    <div class="profile-job-profile-button clearfix">
                                                        <div class="profile-job-details">
                                                            <ul>
                                                                <li>
                                                                    <p class="details_all_tital"> Basic Information</p> 
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="profile-job-profile-menu">
                                                        <ul class="clearfix">
                                                            <li><b>Comapny Name</b> <span> <?php echo $business_data['company_name']; ?> </span></li>
                                                            <li><b>Country</b> <span> <?php echo $business_data['country_name']; ?></span></li>
                                                            <li><b>State</b><span> <?php echo $business_data['state_name']; ?> </span></li>
                                                            <li><b>City</b><span><?php echo $business_data['city_name']; ?></span></li>
                                                            <li><b>Pincode</b><span><?php echo $business_data['pincode']; ?></span> </li>
                                                            <li><b>Postal Address</b><span> <?php echo $business_data['address']; ?> </span></li>
                                                        </ul>
                                                    </div>
                                                    <div class="profile-job-post-title clearfix">
                                                        <div class="profile-job-profile-button clearfix">
                                                            <div class="profile-job-details">
                                                                <ul>
                                                                    <li>
                                                                        <p class="details_all_tital"> Contact Information</p>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="profile-job-profile-menu">
                                                            <ul class="clearfix">
                                                                <li><b>Contact Person</b><span><?php echo $business_data['contact_person']; ?> </span></li>
                                                                <li><b>Contact Mobile</b><span><?php echo $business_data['contact_mobile']; ?> </span></li>
                                                                <li><b>Contact Email</b><span><?php echo $business_data['contact_email']; ?></span> </li>
                                                                <li><b>Contact Website</b><span><a href="<?php echo $business_data['contact_website']; ?>" target="_blank"><?php echo $business_data['contact_website']; ?></a></span></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="profile-job-post-title clearfix">
                                                        <div class="profile-job-profile-button clearfix">
                                                            <div class="profile-job-details">
                                                                <ul>
                                                                    <li>
                                                                        <p class="details_all_tital">Professional Information</p>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="profile-job-profile-menu">
                                                            <ul class="clearfix">
                                                                <li><b>Business  Type</b><span><?php echo $business_data['business_type']; ?></span></li>
                                                                <li><b>Category</b><span><?php echo $business_data['industry_name']; ?></span></li>
                                                                <li><b>Details Of Your Business </b> 
                                                                    <span>
                                                                         <?php echo nl2br($this->common->make_links($business_data['details'])); ?>
                                                                    </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div> 
                                                    <div class="profile-job-post-title clearfix">
                                                        <div class="profile-job-profile-button clearfix">
                                                            <div class="profile-job-details">
                                                                <ul>
                                                                    <li><p class="details_all_tital">Business Images</p> </li>

                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="profile-job-profile-menu">
                                                            <div  class="buisness-profile-pic">
                                                                <?php
                                                                if (count($busimagedata) > 0) {
                                                                    if (count($busimagedata) > 3) {
                                                                        $i = 1;
                                                                        $k = 1;
                                                                        foreach ($busimagedata as $image) {
                                                                            if ($i <= 2) {
                                                                                ?>
                                                                                <div class="column1">
                                                                                    <div class="bui_res_i">          
                                                                                        <img src="<?php echo BUS_DETAIL_THUMB_UPLOAD_URL . $image['image_name']; ?>"  onclick="openModal(); currentSlide(<?php echo $k; ?>)" class="hover-shadow cursor">
                                                                                    </div>
                                                                                </div>
                                                                            <?php } else { ?>
                                                                                <div class="column1">
                                                                                    <div class="bui_res_i2">  
                                                                                        <img src="<?php echo BUS_DETAIL_THUMB_UPLOAD_URL . $image['image_name']; ?>"  onclick="openModal(); currentSlide(<?php echo $k; ?>)" class="hover-shadow cursor">
                                                                                        <div class="view_bui" id="myBtn"> 
                                                                                            <a id="myBtn">view all</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                            } $i++;
                                                                            $k++;
                                                                            if ($i == 4) {
                                                                                break;
                                                                            }
                                                                        }
                                                                    } else {
                                                                        $i = 1;
                                                                        $k = 1;
                                                                        foreach ($busimagedata as $image) {
                                                                            if ($i <= 2) {
                                                                                ?>
                                                                                <div class="column1">
                                                                                    <div class="bui_res_i"> <img src="<?php echo BUS_DETAIL_THUMB_UPLOAD_URL . $image['image_name']; ?>"  onclick="openModal(); currentSlide(1)" class="hover-shadow cursor">
                                                                                    </div>
                                                                                </div>
                                                                            <?php } else { ?>
                                                                                <div class="column1">
                                                                                    <div class="bui_res_i">  
                                                                                        <img src="<?php echo BUS_DETAIL_THUMB_UPLOAD_URL . $image['image_name']; ?>"  onclick="openModal(); currentSlide(<?php echo $k; ?>)" class="hover-shadow cursor">

                                                                                    </div>

                                                                                </div>



                                                                                <?php
                                                                            } $i++;
                                                                            $k++;
                                                                            if ($i == 4) {
                                                                                break;
                                                                            }
                                                                        }
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <span class="images_add_bui"><h6>No Image Available</h6> 

                                                                        <?php
                                                                        $userid = $this->session->userdata('aileenuser');

                                                                        if ($business_data['user_id'] == $userid) {
                                                                            ?>
                                                                            <a href="<?php echo base_url('business-profile/image') ?>">Add Images</a>

                                                                        <?php } ?>

                                                                    </span>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <div class="modal fade modal_popup" id="myModal" role="dialog" style="z-index: 1003">
                                                                    <div class="modal-dialog" style="width: 88%;">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="modal-close" data-dismiss="modal">&times;</button>
                                                                                <h4 class="modal-title">Business Images</h4>
                                                                            </div>
                                                                            <div class="modal-body popup-img-popup">
                                                                                <div>
                                                                                    <?php
                                                                                    $j = 1;
                                                                                    foreach ($busimagedata as $imagemul) {
                                                                                        ?>
                                                                                        <div class="bui_popup_img"> 
                                                                                            <img src="<?php echo BUS_DETAIL_THUMB_UPLOAD_URL . $imagemul['image_name']; ?>"  onclick="openModal(); currentSlide(<?php echo $j; ?>)" class="hover-shadow cursor">   </div> 
                                                                                        <?php
                                                                                        $j++;
                                                                                    }
                                                                                    ?>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div id="myModal1" class="modal2" style="padding-top: 7%;">


                                                                    <div class="modal-content2"> 
                                                                        <span class="close2 cursor" onclick="closeModal()">&times;</span>  
                                                                        <?php
                                                                        $i = 1;
                                                                        foreach ($busimagedata as $image) {
                                                                            ?>
                                                                            <div class="mySlides">
                                                                                <div class="numbertext"><?php echo $i ?> / <?php echo count($busimagedata); ?></div>
                                                                                <div class="slider_img">
                                                                                    <img src="<?php echo BUS_DETAIL_MAIN_UPLOAD_URL . $image['image_name']; ?> " >
                                                                                </div>
                                                                            </div>

                                                                            <?php
                                                                            $i++;
                                                                        }
                                                                        ?>

                                                                        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                                                                        <a class="next" onclick="plusSlides(1)">&#10095;</a>

                                                                        <div class="caption-container">
                                                                            <p id="caption"></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                            </div>
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
                                        <!--<img class="icon" src="images/dollar-icon.png" alt="" />-->
                                        <span class="mes"></span>
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
                            <?php echo $login_footer ?>
                            <?php echo $footer; ?>
                        <script>
                                                                            var base_url = '<?php echo base_url(); ?>';
                        </script>
                       
                        <?php if (IS_BUSINESS_JS_MINIFY == '0') { ?>
                        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script> 
                        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
                        <script src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script>
                            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/details.js?ver=' . time()); ?>"></script>
                            <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
                        <?php } else { ?>
                            <script src="<?php echo base_url('assets/js_min/bootstrap.min.js'); ?>"></script> 
                        <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()); ?>"></script>
                        <script src="<?php echo base_url('assets/js_min/croppie.js?ver=' . time()); ?>"></script>
                            <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/business-profile/details.js?ver=' . time()); ?>"></script>
                            <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js_min/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
                        <?php } ?>

                        </body>
                        </html>
