<?php
$s3 = new S3(awsAccessKey, awsSecretKey);
?>
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
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />
            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/business.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />
        <?php } ?>
    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push botton_footer">
        <?php echo $header; ?>
        <?php echo $business_header2_border; ?> 
        <section>
            <?php echo $business_common; ?>
            <div class="container">
                <div class="user-midd-section">
                    <div  class="col-sm-12 border_tag padding_low_data padding_les" >
                        <div class="padding_les main_art" >
                            <?php echo $file_header; ?>
                            <div class="tab-content">
                                <div class="tab-pane active" id="home">
                                    <div class="common-form">
                                        <div class="">
                                            <div class="all-box">
                                                <ul class="video">
                                                    <?php
                                                    $join_str[0]['table'] = 'post_files';
                                                    $join_str[0]['join_table_id'] = 'post_files.post_id';
                                                    $join_str[0]['from_table_id'] = 'business_profile_post.business_profile_post_id';
                                                    $join_str[0]['join_type'] = '';

                                                    $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'business_profile_post.is_delete' => '0', 'post_files.insert_profile' => '2', 'post_format' => 'video');
                                                    $busvideo = $this->data['businessvideo'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = 'file_name', $sortby = 'post_files.created_date', $orderby = 'desc', $limit = '6', $offset = '', $join_str, $groupby = '');
                                                    ?>
                                                    <?php
                                                    if ($busvideo) {
                                                        foreach ($busvideo as $videov) {
                                                            ?>
                                                            <li>
                                                            <td class="vidoe_tag">
                                                                <?php
                                                                $post_poster = $videov['file_name'];
                                                                $post_poster1 = explode('.', $post_poster);
                                                                $post_poster2 = end($post_poster1);
                                                                $post_poster = str_replace($post_poster2, 'png', $post_poster);

                                                                if (IMAGEPATHFROM == 'upload') {
                                                                    if (file_exists($this->config->item('bus_post_main_upload_path') . $post_poster)) {
                                                                        ?>
                                                                        <video preload="none" poster="<?php echo base_url($this->config->item('bus_post_main_upload_path') . $post_poster); ?>" controls playsinline webkit-playsinline>
                                                                        <?php } else { ?>
                                                                            <video preload="none" controls playsinline webkit-playsinline>
                                                                                <?php
                                                                            }
                                                                        } else {
                                                                            $filename = $this->config->item('bus_post_main_upload_path') . $videov['file_name'];
                                                                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                                            if ($info) {
                                                                                ?>
                                                                                <video preload="none" poster="<?php echo BUS_POST_MAIN_UPLOAD_URL . $post_poster; ?>" controls playsinline webkit-playsinline>
                                                                                    <?php
                                                                                } else {
                                                                                    ?>
                                                                                    <video preload="none" controls playsinline webkit-playsinline>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                                <source src="<?php echo BUS_POST_MAIN_UPLOAD_URL . $videov['file_name']; ?>" type="video/mp4">

                                                                                <source src="movie.ogg" type="video/ogg">
                                                                                Your browser does not support the video tag.
                                                                            </video>
                                                                            </td>
                                                                            </li>
                                                                            <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <div class="art_no_pva_avl">
                                                                            <div class="art_no_post_img">
                                                                                <img src="<?php echo base_url('assets/images/010.png'); ?>"  alt="Video">
                                                                            </div>
                                                                            <div class="art_no_post_text1">
                                                                                No video Available.
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    </ul>
                                                                    </div>
                                                                    </div>
                                                                    </div>
                                                                    </div>
                                                                    <div class="tab-pane" id="profile">Profile Tab.</div>
                                                                    <div class="tab-pane" id="messages">Messages Tab.</div>
                                                                    <div class="tab-pane" id="settings">Settings Tab.</div>
                                                                    </div>
                                                                    </div>
                                                                    <div class="clearfix"></div>
                                                                    </div>
                                                                    </div>
                                                                    </div>
                                                                    </section>
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
                                                                    <div class="modal fade message-box" id="bidmodal-2" role="dialog">
                                                                        <div class="modal-dialog modal-lm" style="z-index: 9999;">
                                                                            <div class="modal-content">
                                                                                <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                                                                                <div class="modal-body">
                                                                                    <span class="mes">
                                                                                        <div id="popup-form">
                                                                                            <?php echo form_open_multipart(base_url('business_profile/user_image_insert'), array('id' => 'userimage', 'name' => 'userimage', 'class' => 'clearfix')); ?>
                                                                                            <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="profilepic">
                                                                                            <input type="hidden" name="hitext" id="hitext" value="10">
                                                                                            <div class="popup_previred">
                                                                                                <img id="preview" src="#" alt="your image"/>
                                                                                            </div>
                                                                                            <input type="submit" name="profilepicsubmit" id="profilepicsubmit" value="Save" >
                                                                                            <?php echo form_close(); ?>
                                                                                        </div>
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
                                                                        <script src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script>
                                                                        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
                                                                        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
                                                                        <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
                                                                        <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/demo.js?ver=' . time()); ?>"></script>
                                                                        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/videos.js?ver=' . time()); ?>"></script>
                                                                        <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
                                                                    <?php } else { ?>
                                                                        <script src="<?php echo base_url('assets/js_min/croppie.js?ver=' . time()); ?>"></script>
                                                                        <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
                                                                        <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()); ?>"></script>
                                                                        <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
                                                                        <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/demo.js?ver=' . time()); ?>"></script>
                                                                        <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/business-profile/videos.js?ver=' . time()); ?>"></script>
                                                                        <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js_min/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
                                                                    <?php } ?>
                                                                    </body>
                                                                    </html>

