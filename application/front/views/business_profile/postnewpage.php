<?php
$s3 = new S3(awsAccessKey, awsSecretKey);
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
        <script>
            $(document).ready(function ()
            {
            $('body').on('change', '#bgphotoimg', function ()
            {
            $("#bgimageform").ajaxForm({target: '#timelineBackground',
                    beforeSubmit: function () {},
                    success: function () {
                    $("#timelineShade").hide();
                    $("#bgimageform").hide();
                    },
                    error: function () {
                    }}).submit();
            });
            $("body").on('mouseover', '.headerimage', function ()
            {
            var y1 = $('#timelineBackground').height();
            var y2 = $('.headerimage').height();
            $(this).draggable({
            scroll: false,
                    axis: "y",
                    drag: function (event, ui) {
                    if (ui.position.top >= 0)
                    {
                    ui.position.top = 0;
                    } else if (ui.position.top <= y1 - y2)
                    {
                    ui.position.top = y1 - y2;
                    }
                    },
                    stop: function (event, ui)
                    {
                    }
            });
            });
            $("body").on('click', '.bgSave', function ()
            {
            var id = $(this).attr("id");
            var p = $("#timelineBGload").attr("style");
            var Y = p.split("top:");
            var Z = Y[1].split(";");
            var dataString = 'position=' + Z[0];
            $.ajax({
            type: "POST",
                    url: "<?php echo base_url('business_profile/image_saveBG_ajax'); ?>",
                    data: dataString,
                    cache: false,
                    beforeSend: function () { },
                    success: function (html)
                    {
                    if (html)
                    {
                    window.location.reload();
                    $(".bgImage").fadeOut('slow');
                    $(".bgSave").fadeOut('slow');
                    $("#timelineShade").fadeIn("slow");
                    $("#timelineBGload").removeClass("headerimage");
                    $("#timelineBGload").css({'margin-top': html});
                    return false;
                    }
                    }
            });
            return false;
            });
            });
        </script>
    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push">
        <?php echo $header; ?>
        <?php echo $business_header2_border; ?>
        <section>
            <div class="user-midd-section bui_art_left_box" id="paddingtop_fixed">
                <div class="container art_container padding-360">
                    <div class="">
                        <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt">
                            <div class="">
                                <?php echo $business_left; ?>
                                <?php echo $left_footer; ?>
                            </div>
                        </div>
                        <div class=" custom-right-art post_detailbox mian_middle_post_box animated fadeInUp" >
                            <?php if (count($busienss_data) > 0) { ?>
                                <div class="col-md-12 col-sm-12 post-design-box">
                                    <div id="popup1" class="overlay">
                                        <div class="popup">
                                            <div class="pop_content">
                                                Your Post is Successfully Saved.
                                                <p class="okk"><a class="okbtn" href="#">Ok</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div  class="">
                                        <div class="post-design-top col-md-12" >
                                            <div class="post-design-pro-img " style="padding-left: 17px;"> 
                                                <?php
                                                $companyname = $this->db->get_where('business_profile', array('user_id' => $busienss_data[0]['user_id'], 'status' => '1'))->row()->company_name;
                                                $companynameposted = $this->db->get_where('business_profile', array('user_id' => $busienss_data[0]['posted_user_id']))->row()->company_name;
                                                $business_userimage = $this->db->get_where('business_profile', array('user_id' => $busienss_data[0]['user_id'], 'status' => '1'))->row()->business_user_image;
                                                $business_slug = $this->db->get_where('business_profile', array('user_id' => $busienss_data[0]['user_id'], 'status' => '1'))->row()->business_slug;
                                                $userimageposted = $this->db->get_where('business_profile', array('user_id' => $busienss_data[0]['posted_user_id']))->row()->business_user_image;
                                                $slugname = $this->db->get_where('business_profile', array('user_id' => $busienss_data[0]['user_id'], 'status' => '1'))->row()->business_slug;
                                                $slugnameposted = $this->db->get_where('business_profile', array('user_id' => $busienss_data[0]['posted_user_id'], 'status' => '1'))->row()->business_slug;
                                                ?>
                                                <?php if ($busienss_data[0]['posted_user_id']) {
                                                    ?>
                                                    <?php if ($userimageposted) { ?>
                                                        <a href="<?php echo base_url('business-profile/dashboard/' . $slugnameposted); ?>">
                                                            <?php
                                                            if (IMAGEPATHFROM == 'upload') {
                                                                if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $userimageposted)) {
                                                                    ?>
                                                                    <img  src="<?php echo base_url(NOBUSIMAGE) ?>"  name="image_src" id="image_src" alt="12">
                                                                <?php } else { ?>
                                                                    <img src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $userimageposted ?>" name="image_src" id="image_src" alt="12" >
                                                                    <?php
                                                                }
                                                            } else {
                                                                $filename = $this->config->item('bus_profile_thumb_upload_path') . $userimageposted;
                                                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                                if (!$info) {
                                                                    ?>
                                                                    <img  src="<?php echo base_url(NOBUSIMAGE) ?>"  name="image_src" id="image_src" alt="12">
                                                                <?php } else { ?>
                                                                    <img src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $userimageposted ?>" name="image_src" id="image_src" alt="12" >
                                                                    <?php
                                                                }
                                                            }
                                                            ?>

                                                        </a>
                                                    <?php } else { ?>
                                                        <a href="<?php echo base_url('business-profile/dashboard/' . $slugnameposted); ?>">
                                                            <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="11">
                                                        </a>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <?php if ($business_userimage) { ?>
                                                        <a href="<?php echo base_url('business-profile/dashboard/' . $slugname); ?>">
                                                            <?php
                                                            if (IMAGEPATHFROM == 'upload') {
                                                                if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                                                                    ?>
                                                                    <img  src="<?php echo base_url(NOBUSIMAGE) ?>"  alt="10">
                                                                <?php } else { ?>
                                                                    <img src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage ?>" alt="10" >
                                                                    <?php
                                                                }
                                                            } else {
                                                                $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_userimage;
                                                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                                if (!$info) {
                                                                    ?>
                                                                    <img  src="<?php echo base_url(NOBUSIMAGE) ?>"  alt="10">
                                                                <?php } else { ?>
                                                                    <img src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage ?>" alt="10" >
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </a>
                                                    <?php } else { ?>
                                                        <a href="<?php echo base_url('business-profile/dashboard/' . $slugname); ?>">
                                                            <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="9">
                                                        </a>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <div class="post-design-name fl col-xs-8 col-md-10">
                                                <ul>
                                                    <?php
                                                    $slugname = $this->db->select('business_slug')->get_where('business_profile', array('user_id' => $busienss_data[0]['user_id'], 'status' => '1'))->row()->business_slug;
                                                    $categoryid = $this->db->select('industriyal')->get_where('business_profile', array('user_id' => $busienss_data[0]['user_id'], 'status' => '1'))->row()->industriyal;
                                                    $other_category = $this->db->select('other_industrial')->get_where('business_profile', array('user_id' => $busienss_data[0]['user_id'], 'status' => '1'))->row()->other_industrial;
                                                    $category = $this->db->select('industry_name')->get_where('industry_type', array('industry_id' => $categoryid, 'status' => '1'))->row()->industry_name;
                                                    $slugnameposted = $this->db->select('business_slug')->get_where('business_profile', array('user_id' => $busienss_data[0]['posted_user_id'], 'status' => '1'))->row()->business_slug;
                                                    ?>
                                                    <?php if ($busienss_data[0]['posted_user_id']) { ?>
                                                        <li>
                                                            <div class="else_post_d">
                                                                <div class="post-design-product">
                                                                    <a  class="other_name name_business post_dot" href="<?php echo base_url('business-profile/dashboard/' . $slugnameposted); ?>"><?php echo ucfirst(strtolower($companynameposted)); ?></a>
                                                                    <p class="posted_with" > Posted With </p>
                                                                    <a  class="other_name name_business post_dot" href="<?php echo base_url('business-profile/dashboard/' . $slugname); ?>"><?php echo ucfirst(strtolower($companyname)); ?></a>
                                                                    <span class="ctre_date">
                                                                        <?php echo $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($busienss_data[0]['created_date']))); ?>                     
                                                                    </span> 
                                                                </div>
                                                            </div>
                                                        </li>
                                                    <?php } else { ?>
                                                        <li>
                                                            <div class="post-design-product"><a class="post_dot" href="<?php echo base_url('business-profile/details/' . $slugname); ?>"> <span class="span_main_name">  <?php echo ucfirst(strtolower($companyname)); ?> </span> </a>
                                                                <span class="ctre_date"> 
                                                                    <?php echo $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($busienss_data[0]['created_date']))); ?>      
                                                                </span>
                                                            </div>
                                                        </li>
                                                    <?php } ?>
                                                    <li>
                                                        <div class="post-design-product"><a>
                                                                <?php
                                                                if ($category) {
                                                                    echo ucfirst(strtolower($category));
                                                                } else {
                                                                    echo ucfirst(strtolower($other_category));
                                                                }
                                                                ?>
                                                            </a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="dropdown1">
                                                <a onClick="myFunction(<?php echo $busienss_data[0]['business_profile_post_id']; ?>)" class="dropbtn_common dropbtn1 fa fa-ellipsis-v"></a>
                                                <div id="<?php echo "myDropdown" . $busienss_data[0]['business_profile_post_id']; ?>" class="dropdown-content1 dropdown2_content">
                                                    <?php
                                                    if ($busienss_data[0]['posted_user_id'] != 0) {
                                                        if ($this->session->userdata('aileenuser') == $busienss_data[0]['posted_user_id']) {
                                                            ?>
                                                            <a onclick="user_postdelete(<?php echo $busienss_data[0]['business_profile_post_id']; ?>)">
                                                                <i class="fa fa-trash-o" aria-hidden="true">
                                                                </i> Delete Post
                                                            </a>
                                                            <a id="<?php echo $busienss_data[0]['business_profile_post_id']; ?>" onClick="editpost(this.id)">
                                                                <i class="fa fa-pencil-square-o" aria-hidden="true">
                                                                </i>Edit
                                                            </a>
                                                        <?php } else {
                                                            ?>
                                                            <a onclick="user_postdelete(<?php echo $busienss_data[0]['business_profile_post_id']; ?>)">
                                                                <i class="fa fa-trash-o" aria-hidden="true">
                                                                </i> Delete Post
                                                            </a>
                                                            <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <?php if ($this->session->userdata('aileenuser') == $busienss_data[0]['user_id']) { ?> 
                                                            <a onclick="user_postdelete(<?php echo $busienss_data[0]['business_profile_post_id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete Post</a>
                                                            <a id="<?php echo $busienss_data[0]['business_profile_post_id']; ?>" onClick="editpost(this.id)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</a>
                                                        <?php } else { ?>
                                                            <a onclick="user_postdeleteparticular(<?php echo $busienss_data[0]['business_profile_post_id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete Post</a>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="post-design-desc " style="padding: 5px 17px 5px 17px;">
                                                <div class="ft-15 t_artd">
                                                    <div id="<?php echo 'editpostdata' . $busienss_data[0]['business_profile_post_id']; ?>" style="display:block;">
                                                        <a  ><?php echo $this->common->make_links($busienss_data[0]['product_name']); ?></a>
                                                    </div>
                                                    <div id="<?php echo 'editpostbox' . $busienss_data[0]['business_profile_post_id']; ?>" style="display:none;">
                                                        <input type="text" class="my_text" id="<?php echo 'editpostname' . $busienss_data[0]['business_profile_post_id']; ?>" name="editpostname" placeholder="Product Name" value="<?php echo $busienss_data[0]['product_name']; ?>" onKeyDown=check_lengthedit(<?php echo $busienss_data[0]['business_profile_post_id']; ?>); onKeyup=check_lengthedit(<?php echo $busienss_data[0]['business_profile_post_id']; ?>); onblur=check_lengthedit(<?php echo $busienss_data[0]['business_profile_post_id']; ?>);>
                                                        <?php
                                                        if ($busienss_data[0]['product_name']) {
                                                            $counter = $busienss_data[0]['product_name'];
                                                            $a = strlen($counter);
                                                            ?>
                                                            <input size=1 id="text_num" class="text_num" value="<?php echo (50 - $a); ?>" name=text_num disabled="">
                                                        <?php } else { ?>
                                                            <input size=1 id="text_num" class="text_num" value=50 name=text_num disabled=""> 
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div id="<?php echo "khyati" . $busienss_data[0]['business_profile_post_id']; ?>" style="display:block;">
                                                    <?php
                                                    $small = substr($busienss_data[0]['product_description'], 0, 180);
                                                    echo $this->common->make_links($small);
                                                    if (strlen($busienss_data[0]['product_description']) > 180) {
                                                        echo '... <span id="kkkk" onClick="khdiv(' . $busienss_data[0]['business_profile_post_id'] . ')">View More</span>';
                                                    }
                                                    ?>
                                                </div>
                                                <div id="<?php echo "khyatii" . $busienss_data[0]['business_profile_post_id']; ?>" style="display:none;">
                                                    <?php
                                                    echo $busienss_data[0]['product_description'];
                                                    ?>
                                                </div>
                                                <div id="<?php echo 'editpostdetailbox' . $busienss_data[0]['business_profile_post_id']; ?>" style="display:none;">
                                                    <div  contenteditable="true" id="<?php echo 'editpostdesc' . $busienss_data[0]['business_profile_post_id']; ?>" placeholder="Product Description" class="textbuis  editable_text" placeholder="Description of Your Product"  name="editpostdesc" onpaste="OnPaste_StripFormatting(this, event);" onfocus="cursorpointer(<?php echo $busienss_data[0]['business_profile_post_id']; ?>)"><?php echo $busienss_data[0]['product_description']; ?></div>
                                                </div>
                                                <button class="fr" id="<?php echo "editpostsubmit" . $busienss_data[0]['business_profile_post_id']; ?>" style="display:none;margin: 5px 0;" onClick="edit_postinsert(<?php echo $busienss_data[0]['business_profile_post_id']; ?>)">Save</button>
                                            </div>
                                        </div>
                                        <div class="post-design-mid col-md-12">
                                            <div>
                                                <?php
                                                $contition_array = array('post_id' => $busienss_data[0]['business_profile_post_id'], 'is_deleted' => '1', 'insert_profile' => '2');
                                                $businessmultiimage = $this->data['businessmultiimage'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                ?>
                                                <?php
                                                $i = 1;
                                                foreach ($businessmultiimage as $data) {
                                                    $allowed = array('jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg');
                                                    $allowespdf = array('pdf');
                                                    $allowesvideo = array('mp4', '3gp');
                                                    $allowesaudio = array('mp3');
                                                    $filename = $data['file_name'];
                                                    $ext = pathinfo($filename, PATHINFO_EXTENSION);

                                                    if (in_array($ext, $allowed)) {
                                                        ?>
                                                        <?php if (count($businessmultiimage) == 1) { ?>
                                                            <div class="one-image" >
                                                                <img src="<?php echo BUS_POST_MAIN_UPLOAD_URL . $data['file_name'] ?>" onclick="openModal();
                                                                    currentSlide(<?php echo $i; ?>)" class="hover-shadow cursor">
                                                            </div>
                                                        <?php } elseif (count($businessmultiimage) == 2) { ?>
                                                            <div class="one-image" >
                                                                <img src="<?php echo BUS_POST_MAIN_UPLOAD_URL . $data['file_name'] ?>" onclick="openModal();
                                                                    currentSlide(<?php echo $i; ?>)" class="hover-shadow cursor">
                                                            </div>
                                                        <?php } elseif (count($businessmultiimage) == 3) { ?>
                                                            <div class="one-image" >
                                                                <img src="<?php echo BUS_POST_MAIN_UPLOAD_URL . $data['file_name'] ?>"  onclick="openModal();
                                                                    currentSlide(<?php echo $i; ?>)" class="hover-shadow cursor">
                                                            </div>
                                                        <?php } elseif (count($businessmultiimage) == 4) { ?>
                                                            <div class="one-image" >
                                                                <img src="<?php echo BUS_POST_MAIN_UPLOAD_URL . $data['file_name'] ?>" onclick="openModal();
                                                                    currentSlide(<?php echo $i; ?>)" class="hover-shadow cursor">
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="one-image" >
                                                                <img src="<?php echo BUS_POST_MAIN_UPLOAD_URL . $data['file_name'] ?>"  onclick="openModal();
                                                                    currentSlide(<?php echo $i; ?>)" class="hover-shadow cursor">
                                                            </div>
                                                            <?php
                                                        }
                                                    } elseif (in_array($ext, $allowespdf)) {
                                                        ?>
                                                        <div>
                                                            <a href="<?php echo base_url('business_profile/creat_pdf/' . $data['post_files_id']) ?>">
                                                                <div class="pdf_img">
                                                                    <img src="<?php echo base_url('assets/images/PDF.jpg') ?>" style="height: 100%; width: 100%;">
                                                                </div>
                                                            </a>
                                                        </div>
                                                    <?php } elseif (in_array($ext, $allowesvideo)) { ?>
                                                        <div>
                                                            <video width="320" height="240" controls>
                                                                <source src="<?php echo base_url($this->config->item('bus_post_thumb_upload_path') . $data['file_name']); ?>" type="video/mp4">
                                                                <source src="movie.ogg" type="video/ogg">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        </div>
                                                    <?php } elseif (in_array($ext, $allowesaudio)) { ?>
                                                        <div>
                                                            <audio width="120" height="100" controls>
                                                                <source src="<?php echo base_url($this->config->item('bus_post_thumb_upload_path') . $data['file_name']); ?>" type="audio/mp3">
                                                                <source src="movie.ogg" type="audio/ogg">
                                                                Your browser does not support the audio tag.
                                                            </audio>
                                                        </div>
                                                    <?php } ?>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                            </div>
                                            <!-- multiple image code  end-->
                                        </div>
                                        <div class="post-design-like-box col-md-12">
                                            <div class="post-design-menu">
                                                <ul class="col-md-6">
                                                    <li class="<?php echo 'likepost' . $busienss_data[0]['business_profile_post_id']; ?>">
                                                        <a id="<?php echo $busienss_data[0]['business_profile_post_id']; ?>"   onClick="post_like(this.id)">
                                                            <?php
                                                            $userid = $this->session->userdata('aileenuser');
                                                            $contition_array = array('business_profile_post_id' => $busienss_data[0]['business_profile_post_id'], 'status' => '1');
                                                            $active = $this->data['active'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                            $likeuser = $this->data['active'][0]['business_like_user'];
                                                            $likeuserarray = explode(',', $active[0]['business_like_user']);

                                                            if (!in_array($userid, $likeuserarray)) {
                                                                ?>               
                                                                <i class="fa fa-thumbs-up fa-1x" style="color: #999;" aria-hidden="true"></i>
                                                            <?php } else { ?> 
                                                                <i class="fa fa-thumbs-up main_color" aria-hidden="true"></i>
                                                            <?php } ?>
                                                            <span class="like_As_count">
                                                                <?php
                                                                if ($busienss_data[0]['business_likes_count'] > 0) {
                                                                    echo $busienss_data[0]['business_likes_count'];
                                                                }
                                                                ?>
                                                            </span>
                                                        </a>
                                                    </li>
                                                    <li id="<?php echo 'insertcount' . $busienss_data[0]['business_profile_post_id']; ?>">
                                                        <?php
                                                        $commnetcount = $this->business_model->getBusinessPostComment($post_id = $busienss_data[0]['business_profile_post_id'], $sortby = '', $orderby = '', $limit = '');
                                                        ?>
                                                        <a  onClick="commentall(this.id)" id="<?php echo $busienss_data[0]['business_profile_post_id']; ?>"><i class="fa fa-comment-o" aria-hidden="true"> 
                                                            </i> 
                                                        </a>
                                                    </li>
                                                </ul>
                                                <ul class="col-md-6 like_cmnt_count">
                                                    <li>
                                                        <div class="like_count_ext">
                                                            <span class="comment_count<?php echo $busienss_data[0]['business_profile_post_id']; ?>" > 
                                                                <?php
                                                                if (count($commnetcount) > 0) {
                                                                    echo count($commnetcount);
                                                                    ?>
                                                                    <span> Comment</span>
                                                                <?php }
                                                                ?> 
                                                            </span> 
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="comnt_count_ext">
                                                            <span class="comment_like_count<?php echo $busienss_data[0]['business_profile_post_id']; ?>"> 
                                                                <?php
                                                                if ($busienss_data[0]['business_likes_count'] > 0) {
                                                                    echo $busienss_data[0]['business_likes_count'];
                                                                    ?>
                                                                    <span> Like</span>
                                                                <?php }
                                                                ?>
                                                            </span> 
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <?php
                                        if ($busienss_data[0]['business_likes_count'] > 0) {
                                            ?>
                                            <div class="likeduserlist<?php echo $busienss_data[0]['business_profile_post_id'] ?>">
                                                <?php
                                                $contition_array = array('business_profile_post_id' => $busienss_data[0]['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                                                $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                $likeuser = $commnetcount[0]['business_like_user'];
                                                $countlike = $commnetcount[0]['business_likes_count'] - 1;
                                                $likelistarray = explode(',', $likeuser);
                                                foreach ($likelistarray as $key => $value) {
                                                    $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => '1'))->row()->company_name;
                                                }
                                                ?>
                                                <?php
                                                $contition_array = array('business_profile_post_id' => $busienss_data[0]['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                                                $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                                $likeuser = $commnetcount[0]['business_like_user'];
                                                $countlike = $commnetcount[0]['business_likes_count'] - 1;
                                                $likelistarray = explode(',', $likeuser);

                                                $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => '1'))->row()->company_name;
                                                ?>
                                                <div class="like_one_other">
                                                    <a href="javascript:void(0);"  onclick="likeuserlist(<?php echo $busienss_data[0]['business_profile_post_id']; ?>);">
                                                        <?php
                                                        if ($userid == $value) {
                                                            echo "You";
                                                            echo "&nbsp;";
                                                        } else {
                                                            echo ucfirst(strtolower($business_fname1));
                                                            echo "&nbsp;";
                                                        }
                                                        ?>
                                                        <?php
                                                        if (count($likelistarray) > 1) {
                                                            ?>
                                                            <?php echo "and"; ?>
                                                            <?php
                                                            echo $countlike;
                                                            echo "&nbsp;";
                                                            echo "others";
                                                            ?> 
                                                        <?php } ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <div class="<?php echo "likeusername" . $busienss_data[0]['business_profile_post_id']; ?>" id="<?php echo "likeusername" . $busienss_data[0]['business_profile_post_id']; ?>" style="display:none">
                                            <?php
                                            $contition_array = array('business_profile_post_id' => $busienss_data[0]['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                                            $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                            $likeuser = $commnetcount[0]['business_like_user'];
                                            $countlike = $commnetcount[0]['business_likes_count'] - 1;
                                            $likelistarray = explode(',', $likeuser);
                                            foreach ($likelistarray as $key => $value) {
                                                $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => '1'))->row()->company_name;
                                            }
                                            ?>
                                            <?php
                                            $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                                            $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                            $likeuser = $commnetcount[0]['business_like_user'];
                                            $countlike = $commnetcount[0]['business_likes_count'] - 1;
                                            $likelistarray = explode(',', $likeuser);

                                            $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => '1'))->row()->company_name;
                                            ?>
                                            <div class="like_one_other">
                                                <a href="javascript:void(0);"  onclick="likeuserlist(<?php echo $busienss_data[0]['business_profile_post_id']; ?>);">
                                                    <?php
                                                    echo ucfirst(strtolower($business_fname1));
                                                    echo "&nbsp;";
                                                    ?>
                                                    <?php
                                                    if (count($likelistarray) > 1) {
                                                        ?>
                                                        <?php echo "and"; ?>
                                                        <?php
                                                        echo $countlike;
                                                        echo "&nbsp;";
                                                        echo "others";
                                                        ?> 
                                                    <?php } ?>
                                                </a>
                                            </div>

                                        </div>
                                        <div class="art-all-comment col-md-12">
                                            <div id="<?php echo "fourcomment" . $busienss_data[0]['business_profile_post_id']; ?>" style="display:none;">
                                            </div>
                                            <div  id="<?php echo "threecomment" . $busienss_data[0]['business_profile_post_id']; ?>" style="display:block">
                                                <div class="hidebottomborder <?php echo 'insertcomment' . $busienss_data[0]['business_profile_post_id']; ?>">
                                                    <?php
                                                    $businessprofiledata = $this->data['businessprofiledata'] = $this->business_model->getBusinessPostComment($post_id = $busienss_data[0]['business_profile_post_id'], $sortby = 'business_profile_post_comment_id', $orderby = 'DESC', $limit = '1');
                                                    if ($businessprofiledata) {
                                                        foreach ($businessprofiledata as $rowdata) {
                                                            $companyname = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id']))->row()->company_name;
                                                            ?>
                                                            <div class="all-comment-comment-box">
                                                                <div class="post-design-pro-comment-img"> 
                                                                    <?php
                                                                    $business_userimage = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id'], 'status' => '1'))->row()->business_user_image;
                                                                    if ($business_userimage != '') {
                                                                        ?>
                                                                        <?php
                                                                        if (IMAGEPATHFROM == 'upload') {
                                                                            if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                                                                                ?>
                                                                                <img  src="<?php echo base_url(NOBUSIMAGE) ?>"  alt="No Image">
                                                                            <?php } else { ?>
                                                                                <img src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage; ?>"  alt="" >
                                                                                <?php
                                                                            }
                                                                        } else {
                                                                            $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_userimage;
                                                                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                                            if (!$info) {
                                                                                ?>
                                                                                <img  src="<?php echo base_url(NOBUSIMAGE) ?>"  alt="12">
                                                                            <?php } else { ?>
                                                                                <img src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage; ?>" alt="12" >
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="">
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <div class="comment-name">
                                                                    <b> <a href="<?php echo base_url('business-profile/details/' . $business_slug) ?>">
                                                                            <?php
                                                                            echo $companyname;
                                                                            echo '</br>';
                                                                            ?>
                                                                        </a>
                                                                    </b>
                                                                </div>
                                                                <div class="comment-details" id= "<?php echo "showcomment" . $rowdata['business_profile_post_comment_id']; ?>">
                                                                    <div id="<?php echo "lessmore" . $rowdata['business_profile_post_comment_id']; ?>" style="display:block;">
                                                                        <?php
                                                                        $small = substr($rowdata['comments'], 0, 180);
                                                                        echo $this->common->make_links($small);

                                                                        if (strlen($rowdata['comments']) > 180) {
                                                                            echo '... <span id="kkkk" onClick="seemorediv(' . $rowdata['business_profile_post_comment_id'] . ')">See More</span>';
                                                                        }
                                                                        ?>
                                                                    </div>

                                                                    <div id="<?php echo "seemore" . $rowdata['business_profile_post_comment_id']; ?>" style="display:none;">
                                                                        <?php
                                                                        $new_product_comment = $this->common->make_links($rowdata['comments']);
                                                                        echo nl2br(htmlspecialchars_decode(htmlentities($new_product_comment, ENT_QUOTES, 'UTF-8')));
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <div class="edit-comment-box">
                                                                    <div class="inputtype-edit-comment">
                                                                        <div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="<?php echo $rowdata['business_profile_post_comment_id']; ?>"  id="<?php echo "editcomment" . $rowdata['business_profile_post_comment_id']; ?>" placeholder="Enter Your Comment " value= ""  onkeyup="commentedit(<?php echo $rowdata['business_profile_post_comment_id']; ?>)" onpaste="OnPaste_StripFormatting(this, event);"><?php echo $rowdata['comments']; ?></div>
                                                                        <span class="comment-edit-button"><button id="<?php echo "editsubmit" . $rowdata['business_profile_post_comment_id']; ?>" style="display:none" onClick="edit_comment(<?php echo $rowdata['business_profile_post_comment_id']; ?>)">Save</button></span>
                                                                    </div>
                                                                </div>
                                                                <div class="art-comment-menu-design">
                                                                    <div class="comment-details-menu" id="<?php echo 'likecomment1' . $rowdata['business_profile_post_comment_id']; ?>">
                                                                        <a id="<?php echo $rowdata['business_profile_post_comment_id']; ?>" onClick="comment_like1(this.id)">
                                                                            <?php
                                                                            $businesscommentlike = $this->data['businesscommentlike'] = $this->business_model->getBusinessLikeComment($post_id = $rowdata['business_profile_post_comment_id']);
                                                                            $likeuserarray = explode(',', $businesscommentlike[0]['business_comment_like_user']);

                                                                            if (!in_array($userid, $likeuserarray)) {
                                                                                ?>
                                                                                <i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i> 
                                                                            <?php } else { ?>
                                                                                <i class="fa fa-thumbs-up main_color" aria-hidden="true"></i>
                                                                            <?php } ?>
                                                                            <span>
                                                                                <?php
                                                                                if ($rowdata['business_comment_likes_count']) {
                                                                                    echo $rowdata['business_comment_likes_count'];
                                                                                }
                                                                                ?>
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                    <?php
                                                                    $userid = $this->session->userdata('aileenuser');
                                                                    if ($rowdata['user_id'] == $userid) {
                                                                        ?>                                     
                                                                        <span role="presentation" aria-hidden="true"> · </span>
                                                                        <div class="comment-details-menu">
                                                                            <div id="<?php echo 'editcommentbox' . $rowdata['business_profile_post_comment_id']; ?>" style="display:block;">
                                                                                <a id="<?php echo $rowdata['business_profile_post_comment_id']; ?>"   onClick="comment_editbox(this.id)" class="editbox">Edit
                                                                                </a>
                                                                            </div>
                                                                            <div id="<?php echo 'editcancle' . $rowdata['business_profile_post_comment_id']; ?>" style="display:none;">
                                                                                <a id="<?php echo $rowdata['business_profile_post_comment_id']; ?>" onClick="comment_editcancle(this.id)">Cancel
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <?php
                                                                    $userid = $this->session->userdata('aileenuser');
                                                                    $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $rowdata['business_profile_post_id'], 'status' => 1))->row()->user_id;
                                                                    if ($rowdata['user_id'] == $userid || $business_userid == $userid) {
                                                                        ?>      
                                                                        <span role="presentation" aria-hidden="true"> · </span>
                                                                        <div class="comment-details-menu">
                                                                            <input type="hidden" name="post_delete"  id="post_delete<?php echo $rowdata['business_profile_post_comment_id']; ?>" value= "<?php echo $rowdata['business_profile_post_id']; ?>">
                                                                            <a id="<?php echo $rowdata['business_profile_post_comment_id']; ?>"   onClick="comment_delete(this.id)"> Delete<span class="<?php echo 'insertcomment' . $rowdata['business_profile_post_comment_id']; ?>">
                                                                                </span>
                                                                            </a>
                                                                        </div>
                                                                    <?php } ?>                                       
                                                                    <span role="presentation" aria-hidden="true"> · </span>
                                                                    <div class="comment-details-menu">
                                                                        <p><?php
                                                                            echo $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($rowdata['created_date'])));
                                                                            echo '</br>';
                                                                            ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-design-commnet-box col-md-12">
                                            <div class="post-design-proo-img hidden-mob"> 
                                                <?php
                                                $userid = $this->session->userdata('aileenuser');
                                                $business_userimage = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->business_user_image;
                                                $business_user = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->company_name;
                                                if ($business_userimage) {
                                                    ?>
                                                    <?php
                                                    if (IMAGEPATHFROM == 'upload') {
                                                        if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                                                            ?>
                                                            <img  src="<?php echo base_url(NOBUSIMAGE) ?>"  alt="No Image">
                                                        <?php } else { ?>
                                                            <img src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage; ?>"  alt="" >
                                                            <?php
                                                        }
                                                    } else {
                                                        $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_userimage;
                                                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                        if (!$info) {
                                                            ?>
                                                            <img  src="<?php echo base_url(NOBUSIMAGE) ?>"  alt="12">
                                                        <?php } else { ?>
                                                            <img src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage; ?>" alt="12" >
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="">
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="col-md-12 inputtype-comment cmy_2">
                                                <div contenteditable="true" class="editable_text" name="<?php echo $busienss_data[0]['business_profile_post_id']; ?>"  id="<?php echo "post_comment" . $busienss_data[0]['business_profile_post_id']; ?>" placeholder="Add a Comment ..." value= "" onClick="entercomment(<?php echo $busienss_data[0]['business_profile_post_id']; ?>)" onpaste="OnPaste_StripFormatting(this, event);"></div>
                                                <div class="mob-comment">       
                                                    <button id="<?php echo $busienss_data[0]['business_profile_post_id']; ?>" onClick="insert_comment(this.id)"><img src=<?php echo base_url('assets/img/send.png') ?> ;">
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="comment-edit-butn hidden-mob">        
                                                <button id="<?php echo $busienss_data[0]['business_profile_post_id']; ?>" onClick="insert_comment(this.id)">Comment</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="art_no_post_avl">
                                    <h3>Business Post</h3>
                                    <div class="art-img-nn">
                                        <div class="art_no_post_img">
                                            <img src="<?php echo base_url('assets/img/bui-no.png') ?>">
                                        </div>
                                        <div class="art_no_post_text">
                                            Sorry, this content isn't available at the moment
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>


                    <div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig"> 

                        <div class="all-profile-box">
                            <div class="all-pro-head">
                                <h4>Profiles<a href="<?php echo base_url('profiles/') . $this->session->userdata('aileenuser_slug'); ?>" class="pull-right">All</a></h4>
                            </div>
                            <ul class="all-pr-list">
                                <li>
                                    <a href="<?php echo base_url('job') ?>">
                                        <div class="all-pr-img">
                                            <img src="<?php echo base_url() ?>assets/img/i1.png">
                                        </div>
                                        <span>Job Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('recruiter') ?>">
                                        <div class="all-pr-img">
                                            <img src="<?php echo base_url() ?>assets/img/i2.jpg">
                                        </div>
                                        <span>Recruiter Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('freelance') ?>">
                                        <div class="all-pr-img">
                                            <img src="<?php echo base_url() ?>assets/img/i3.jpg">
                                        </div>
                                        <span>Freelance Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('business-profile') ?>">
                                        <div class="all-pr-img">
                                            <img src="<?php echo base_url() ?>assets/img/i4.jpg">
                                        </div>
                                        <span>Business Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('artist') ?>">
                                        <div class="all-pr-img">
                                            <img src="<?php echo base_url() ?>assets/img/i5.jpg">
                                        </div>
                                        <span>Artistic Profile</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>

                </div>
            </div>
            <div id="myModal1" class="modal2">

                <div class="modal-content2">
                    <span class="close2 cursor" onclick="closeModal()">&times;</span>
                    <?php
                    $i = 1;
                    $allowed = array('jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg');
                    foreach ($businessmultiimage as $mke => $mval) {
                        $ext = pathinfo($mval['file_name'], PATHINFO_EXTENSION);
                        if (in_array($ext, $allowed)) {
                            $databus1[] = $mval;
                        }
                    }

                    foreach ($databus1 as $busdata) {
                        ?>
                        <div class="mySlides">
                            <div class="numbertext"><?php echo $i ?> / <?php echo count($databus1) ?></div>
                            <div class="slider_img">
                                <?php
                                if (IMAGEPATHFROM == 'upload') {
                                    if (!file_exists($this->config->item('bus_post_main_upload_path') . $busdata['file_name'])) {
                                        ?>
                                    <?php } else { ?>
                                        <img src="<?php echo BUS_POST_MAIN_UPLOAD_URL . $busdata['file_name']; ?>"  alt="" >
                                        <?php
                                    }
                                } else {
                                    $filename = $this->config->item('bus_post_main_upload_path') . $busdata['file_name'];
                                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                    ?>
                                    <img src="<?php echo BUS_POST_MAIN_UPLOAD_URL . $busdata['file_name']; ?>" alt="12">
                                    <?php
                                }
                                ?>
                                <a class="prev" style="left: 0px" onclick="plusSlides( - 1)">&#10094;</a>
                                <a class="next" onclick="plusSlides(1)">&#10095;</a>
                            </div>
                            <?php
                            if (count($databus1) > 1) {
                                ?>
                                <div>
                                    <div class="post-design-like-box col-md-12">
                                        <div class="post-design-menu">
                                            <ul class="col-md-6">
                                                <li class="<?php echo 'likepostimg' . $busdata['post_files_id']; ?>">
                                                    <a id="<?php echo $busdata['post_files_id']; ?>" onClick="mulimg_like(this.id)">
                                                        <?php
                                                        $userid = $this->session->userdata('aileenuser');
                                                        $contition_array = array('post_image_id' => $busdata['post_files_id'], 'user_id' => $userid, 'is_unlike' => '0');
                                                        $activedata = $this->data['activedata'] = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                        if ($activedata) {
                                                            ?>
                                                            <i class="fa fa-thumbs-up main_color" aria-hidden="true"></i>
                                                        <?php } else { ?>
                                                            <i class="fa fa-thumbs-up fa-1x " aria-hidden="true"></i>
                                                        <?php } ?>
                                                        <span class="<?php echo 'likeimage' . $busdata['post_files_id']; ?>"> <?php
                                                            $contition_array = array('post_image_id' => $busdata['post_files_id'], 'is_unlike' => '0');
                                                            $likecount = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                            if ($likecount) {
                                                                
                                                            }
                                                            ?>
                                                        </span>
                                                    </a>
                                                </li>
                                                <li id="<?php echo 'insertcountimg' . $busdata['post_files_id']; ?>">
                                                    <?php
                                                    $contition_array = array('post_image_id' => $busdata['post_files_id'], 'is_delete' => '0');
                                                    $commnetcount = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                    ?>
                                                    <a onClick="imgcommentall(this.id)" id="<?php echo $busdata['post_files_id']; ?>">
                                                        <i class="fa fa-comment-o" aria-hidden="true"></i> 
                                                    </a>
                                                </li>
                                            </ul>
                                            <ul class="col-md-6 like_cmnt_count">
                                                <li>
                                                    <div class="like_cmmt_space comnt_count_ext like_count_ext_img<?php echo $busdata['post_files_id']; ?>">
                                                        <span class="comment_count" > 
                                                            <?php
                                                            if (count($commnetcount) > 0) {
                                                                echo count($commnetcount);
                                                                ?>
                                                            </span> 
                                                            <span> Comment</span>
                                                        <?php }
                                                        ?> 
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class=" comnt_count_ext <?php echo 'comnt_count_ext_img' . $busdata['post_files_id']; ?>">
                                                        <span class="comment_like_count"> 
                                                            <?php
                                                            if (count($likecount) > 0) {
                                                                echo count($likecount);
                                                                ?>
                                                            </span> 
                                                            <span> Like</span>
                                                        <?php }
                                                        ?> 
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php
                                    $contition_array = array('post_image_id' => $busdata['post_files_id'], 'is_unlike' => '0');
                                    $commneteduser = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = 'post_image_like_id,post_image_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                    if (count($commneteduser) > 0) {
                                        ?>
                                        <div class="likeduserlist1 likeduserlistimg<?php echo $busdata['post_files_id'] ?>">
                                            <?php
                                            $contition_array = array('post_image_id' => $busdata['post_files_id'], 'is_unlike' => '0');
                                            $commneteduser = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = 'post_image_like_id,post_image_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                            $countlike = count($commneteduser) - 1;
                                            foreach ($commneteduser as $userdata) {
                                                $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $userdata['user_id'], 'status' => '1'))->row()->company_name;
                                            }
                                            ?>
                                            <?php
                                            $contition_array = array('post_image_id' => $busdata['post_files_id'], 'is_unlike' => '0');
                                            $commneteduser = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = 'post_image_like_id,post_image_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                            $countlike = count($commneteduser) - 1;
                                            $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $commneteduser[0]['user_id'], 'status' => '1'))->row()->company_name;
                                            ?>
                                            <div class="like_one_other_img">
                                                <a href="javascript:void(0);"  onclick="likeuserlistimg(<?php echo $busdata['post_files_id'] ?>);">
                                                    <?php
                                                    if ($userid == $commneteduser[0]['user_id']) {
                                                        echo "You";
                                                        echo "&nbsp;";
                                                    } else {
                                                        echo ucfirst(strtolower($business_fname1));
                                                        echo "&nbsp;";
                                                    }
                                                    ?>
                                                    <?php
                                                    if (count($commneteduser) > 1) {
                                                        ?>
                                                        <?php echo "and"; ?>
                                                        <?php
                                                        echo $countlike;
                                                        echo "&nbsp;";
                                                        echo "others";
                                                        ?> 
                                                    <?php } ?>
                                                </a>
                                            </div>

                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="<?php echo "likeusernameimg" . $busdata['post_files_id']; ?>" id="<?php echo "likeusernameimg" . $busdata['post_files_id']; ?>" style="display:none">
                                        <?php
                                        $contition_array = array('post_image_id' => $busdata['post_files_id'], 'is_unlike' => '0');
                                        $commneteduser = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = 'post_image_like_id,post_image_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                        $countlike = count($commneteduser) - 1;
                                        foreach ($commneteduser as $userdata) {
                                            $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $userdata['user_id'], 'status' => '1'))->row()->company_name;
                                        }
                                        ?>
                                        <?php
                                        $contition_array = array('post_image_id' => $busdata['post_files_id'], 'is_unlike' => '0');
                                        $commneteduser = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = 'post_image_like_id,post_image_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                        $countlike = count($commneteduser) - 1;
                                        $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $commneteduser[0]['user_id'], 'status' => '1'))->row()->company_name;
                                        ?>
                                        <div class="like_one_other_img" style="">
                                            <a href="javascript:void(0);"  onclick="likeuserlistimg(<?php echo $busdata['post_files_id'] ?>);">
                                                <?php
                                                echo ucfirst(strtolower($business_fname1));
                                                echo "&nbsp;";
                                                ?>
                                                <?php
                                                if (count($commneteduser) > 1) {
                                                    ?>
                                                    <?php echo "and"; ?>
                                                    <?php
                                                    echo $countlike;
                                                    echo "&nbsp;";
                                                    echo "others";
                                                    ?> 
                                                <?php } ?>
                                            </a>
                                        </div>

                                    </div>
                                    <div class="art-all-comment">
                                        <div  id="<?php echo "threeimgcomment" . $busdata['post_files_id']; ?>" style="display:block">
                                            <div class="<?php echo 'insertimgcomment' . $busdata['post_files_id']; ?>">
                                                <?php
                                                $contition_array = array('post_image_id' => $busdata['post_files_id'], 'is_delete' => '0');
                                                $busmulimage = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');
                                                if ($busmulimage) {
                                                    foreach ($busmulimage as $rowdata) {
                                                        $companyname = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id']))->row()->company_name;
                                                        ?>
                                                        <div class="all-comment-comment-box">
                                                            <div class="post-design-pro-comment-img"> 
                                                                <?php
                                                                $business_userimage = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id'], 'status' => '1'))->row()->business_user_image;
                                                                if ($business_userimage != '') {
                                                                    ?>
                                                                    <?php
                                                                    if (IMAGEPATHFROM == 'upload') {
                                                                        if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                                                                            ?>
                                                                            <img  src="<?php echo base_url(NOBUSIMAGE) ?>"  alt="No Image">
                                                                        <?php } else { ?>
                                                                            <img src="<?php echo BUS_POST_MAIN_UPLOAD_URL . $busdata['file_name']; ?>"  alt="" >
                                                                            <?php
                                                                        }
                                                                    } else {
                                                                        $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_userimage;
                                                                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                                        if (!$info) {
                                                                            ?>
                                                                            <img  src="<?php echo base_url(NOBUSIMAGE) ?>"  alt="12">
                                                                        <?php } else { ?>
                                                                            <img src="<?php echo BUS_POST_MAIN_UPLOAD_URL . $busdata['file_name']; ?>" alt="12" >
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <img  src="<?php echo base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage); ?>"  alt="">
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="">
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                            <div class="comment-name">
                                                                <b> <a href="<?php echo base_url('business-profile/details/' . $business_slug) ?>"> 
                                                                        <?php
                                                                        echo ucfirst(strtolower($companyname));
                                                                        echo '</br>';
                                                                        ?>
                                                                    </a>
                                                                </b>
                                                            </div>
                                                            <div class="comment-details" id= "<?php echo "imgshowcomment" . $rowdata['post_image_comment_id']; ?>">
                                                                <?php
                                                                $new_product_comment = $this->common->make_links($rowdata['comment']);
                                                                echo nl2br(htmlspecialchars_decode(htmlentities($new_product_comment, ENT_QUOTES, 'UTF-8')));
                                                                ?>
                                                            </div>
                                                            <div class="edit-comment-box">
                                                                <div class="inputtype-edit-comment">
                                                                    <div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="<?php echo $rowdata['post_image_comment_id']; ?>"  id="<?php echo "imgeditcomment" . $rowdata['post_image_comment_id']; ?>" placeholder="Add a Comment ... " value= ""  onkeyup="imgcommentedit(<?php echo $rowdata['post_image_comment_id']; ?>)" onpaste="OnPaste_StripFormatting(this, event);"><?php echo $rowdata['comment']; ?></div>
                                                                    <span class="comment-edit-button"><button id="<?php echo "imgeditsubmit" . $rowdata['post_image_comment_id']; ?>" style="display:none" onClick="imgedit_comment(<?php echo $rowdata['post_image_comment_id']; ?>)">Save</button></span>
                                                                </div>
                                                            </div>
                                                            <div class="art-comment-menu-design">
                                                                <div class="comment-details-menu"  id="<?php echo 'imglikecomment' . $rowdata['post_image_comment_id']; ?>">
                                                                    <a id="<?php echo $rowdata['post_image_comment_id']; ?>"   onClick="imgcomment_like(this.id)">
                                                                        <?php
                                                                        $userid = $this->session->userdata('aileenuser');
                                                                        $contition_array = array('post_image_comment_id' => $rowdata['post_image_comment_id'], 'user_id' => $userid, 'is_unlike' => '0');
                                                                        $businesscommentlike1 = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                                        if (count($businesscommentlike1) == 0) {
                                                                            ?>
                                                                            <i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>
                                                                        <?php } else {
                                                                            ?>
                                                                            <i class="fa fa-thumbs-up main_color" aria-hidden="true"></i>
                                                                        <?php } ?>
                                                                        <span>
                                                                            <?php
                                                                            $contition_array = array('post_image_comment_id' => $rowdata['post_image_comment_id'], 'is_unlike' => '0');
                                                                            $mulcountlike = $this->data['mulcountlike'] = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                                                            if (count($mulcountlike) > 0) {
                                                                                echo count($mulcountlike);
                                                                            }
                                                                            ?>
                                                                        </span>
                                                                    </a>
                                                                </div>
                                                                <?php
                                                                $userid = $this->session->userdata('aileenuser');
                                                                if ($rowdata['user_id'] == $userid) {
                                                                    ?>
                                                                    <div class="comment-details-menu">
                                                                        <div id="<?php echo 'imgeditcommentbox' . $rowdata['post_image_comment_id']; ?>" style="display:block;">
                                                                            <a id="<?php echo $rowdata['post_image_comment_id']; ?>"   onClick="imgcomment_editbox(this.id)" class="editbox">Edit</a>
                                                                        </div>
                                                                        <div id="<?php echo 'imgeditcancle' . $rowdata['post_image_comment_id']; ?>" style="display:none;">
                                                                            <a id="<?php echo $rowdata['post_image_comment_id']; ?>" onClick="imgcomment_editcancle(this.id)">Cancel</a>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php
                                                                $userid = $this->session->userdata('aileenuser');
                                                                $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $rowdata['post_image_id'], 'status' => '1'))->row()->user_id;
                                                                if ($rowdata['user_id'] == $userid || $business_userid == $userid) {
                                                                    ?>
                                                                    <span role="presentation" aria-hidden="true"> · </span>
                                                                    <div class="comment-details-menu">
                                                                        <input type="hidden" name="imgpost_delete"  id="imgpost_delete_<?php echo $rowdata['post_image_comment_id']; ?>" value= "<?php echo $rowdata['post_image_id']; ?>">
                                                                        <a id="<?php echo $rowdata['post_image_comment_id']; ?>"   onClick="imgcomment_delete(this.id)"> Delete<span class="<?php echo 'imginsertcomment' . $rowdata['post_image_comment_id']; ?>">
                                                                            </span> </a> 
                                                                    </div>
                                                                <?php } ?>
                                                                <span role="presentation" aria-hidden="true"> · </span>
                                                                <div class="comment-details-menu">
                                                                    <p><?php
                                                                        echo $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($rowdata['created_date'])));
                                                                        echo '</br>';
                                                                        ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div id="<?php echo "fourimgcomment" . $busdata['post_files_id']; ?>" style="display:none;"></div>
                                    </div>
                                    <div class="post-design-commnet-box col-md-12">
                                        <div class="post-design-proo-img hidden-mob"> 
                                            <?php
                                            $userid = $this->session->userdata('aileenuser');
                                            $business_userimage = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->business_user_image;
                                            $business_user = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->company_name;
                                            if ($business_userimage != '') {
                                                ?>
                                                <?php
                                                if (IMAGEPATHFROM == 'upload') {
                                                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                                                        ?>
                                                        <img  src="<?php echo base_url(NOBUSIMAGE) ?>"  alt="No Image">
                                                    <?php } else { ?>
                                                        <img src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage; ?>"  alt="" >
                                                        <?php
                                                    }
                                                } else {
                                                    $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_userimage;
                                                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                    if (!$info) {
                                                        ?>
                                                        <img  src="<?php echo base_url(NOBUSIMAGE) ?>"  alt="12">
                                                    <?php } else { ?>
                                                        <img src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage; ?>" alt="12" >
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <?php
                                            } else {
                                                ?>
                                                <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="">
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-12 inputtype-comment cmy_2">
                                            <div contenteditable="true" class="editable_text" name="<?php echo $busdata['post_files_id']; ?>" id="<?php echo "post_imgcomment" . $busdata['post_files_id']; ?>" placeholder="Add a Comment ..." onkeyup="entercommentimg(<?php echo $busdata['post_files_id']; ?>)" onpaste="OnPaste_StripFormatting(this, event);"></div>
                                            <div class="mob-comment">       
                                                <button id="<?php echo $busdata['post_files_id']; ?>" onClick="insert_commentimg(this.id)"><img src=<?php echo base_url('assets/img/send.png') ?> ;">
                                                </button>
                                            </div>
                                        </div>
                                        <div class="comment-edit-butn hidden-mob">                                      
                                            <button id="<?php echo $busdata['post_files_id']; ?>" onClick="insert_commentimg(this.id)">Comment</button>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                        $i++;
                    }
                    ?>
                    <div class="caption-container">
                        <p id="caption"></p>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal fade message-box biderror" id="bidmodal" role="dialog" style="z-index: 999999 !important;">
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
        <div class="modal fade message-box" id="likeusermodal" role="dialog" style="z-index: 999999 !important;">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close1" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box" id="postedit" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" id="postedit"data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $footer; ?>

        <?php if (IS_BUSINESS_JS_MINIFY == '0') { ?>
            <script src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
        <?php } else { ?>
            <script src="<?php echo base_url('assets/js_min/croppie.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
        <?php } ?>
        <script>
                                        var base_url = '<?php echo base_url(); ?>';
                                        var post_id = '<?php echo $post_id; ?>';
        </script>
        <?php if (IS_BUSINESS_JS_MINIFY == '0') { ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/post_detail.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
        <?php } else { ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/business-profile/post_detail.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js_min/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
        <?php } ?>
    </body>
</html>