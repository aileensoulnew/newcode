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
        <script type="text/javascript">
            //For Scroll page at perticular position js Start
            $(document).ready(function () {
                $('html,body').animate({scrollTop: 330}, 500);
            });
            //For Scroll page at perticular position js End
        </script>
    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push botton_footer">
        <?php echo $header; ?>
        <?php echo $business_header2_border; ?> 
        <section>
            <?php echo $business_common; ?>
            <div class="container ">
                <div class="user-midd-section"  >
                    <div  class="col-sm-12 border_tag padding_low_data  padding_les" >
                        <div class="padding_les main_art" >
                            <?php echo $file_header; ?>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="home">
                                    <div class="common-form">
                                        <div class="">
                                            <div class="all-box">
                                                <ul class="audio-sec">
                                                    <?php
                                                    $contition_array = array('user_id' => $businessdata1[0]['user_id']);
                                                    $busaudio = $this->data['busaudio'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                    foreach ($busaudio as $val) {
                                                        $contition_array = array('post_id' => $val['business_profile_post_id'], 'is_deleted' => '1', 'insert_profile' => '2');
                                                        $busmultiaudio = $this->data['busmultiaudio'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = 'post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                        $multipleaudio[] = $busmultiaudio;
                                                    }
                                                    ?>
                                                    <?php
                                                    $allowesaudio = array('mp3');

                                                    foreach ($multipleaudio as $mke => $mval) {

                                                        foreach ($mval as $mke1 => $mval1) {
                                                            $ext = pathinfo($mval1['file_name'], PATHINFO_EXTENSION);

                                                            if (in_array($ext, $allowesaudio)) {
                                                                $singlearray2[] = $mval1;
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <?php
                                                    if ($singlearray2) {
                                                        foreach ($singlearray2 as $audiov) {
                                                            ?>
                                                            <li>
                                                                <audio controls>
                                                                    <source src="<?php echo base_url($this->config->item('bus_post_main_upload_path') . $audiov['file_name']); ?>" type="audio/ogg">
                                                                    <source src="movie.ogg" type="audio/mpeg">
                                                                    Your browser does not support the audio tag.
                                                                </audio>
                                                            </li>
                                                            <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <div class="art_no_pva_avl">
                                                            <div class="art_no_post_img">
                                                                <img src="<?php echo base_url('assets/images/color_008.png'); ?>" alt="Audio">
                                                            </div>
                                                            <div class="art_no_post_text1">
                                                                No Audio Available.
                                                            </div>
                                                        </div>
                                                    <?php } ?>             
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Bid-modal for this modal appear or not start -->
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
        <!-- Bid-modal for this modal appear or not  Popup Close -->
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
            <div class="modal-dialog modal-lm" style="z-index: 9999;">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                            <div id="popup-form">
                                <?php echo form_open_multipart(base_url('business_profile/user_image_insert'), array('id' => 'userimage', 'name' => 'userimage', 'class' => 'clearfix')); ?>
                                <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="profilepic">
                                <input type="hidden" name="hitext" id="hitext" value="11">
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


$(document).ready(function () { 
  $('video, audio').mediaelementplayer();
});


        </script>
        <?php if (IS_BUSINESS_JS_MINIFY == '0') { ?>
        <script src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
        <?php } else { ?>
            <script src="<?php echo base_url('assets/js_min/croppie.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js_min/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
        <?php } ?>
    </body>
</html>

