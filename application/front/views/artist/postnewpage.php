<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>

         <?php
        if (IS_ART_CSS_MINIFY == '0') {
            ?>

        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/artistic.css?ver=' . time()); ?>">

        <?php }else{?>

        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/artistic.css?ver=' . time()); ?>">

        <?php }?>
    <body>
        <?php echo $header; ?>
        <?php echo $art_header2_border; ?>
        <div class="user-midd-section bui_art_left_box" id="paddingtop_fixed">
            <div class="container art_container">
                <div class="">

                    <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt" >
                        <div class="left_fixed"> 
                            <?php ?>
                            <?php echo $left_artistic; ?>
                            
                        </div>
                    </div>
                    <div class=" custom-right-art post_detailbox mian_middle_post_box animated fadeInUp">

                        <div class="right_side_posrt fl"> 

                            <?php if ($art_data[0]) { ?>
                                
                                <div class=" post-design-box">

                                    <div class=" ">
                                        <div class="post-design-top col-md-12" >  
                                            <div class="post-design-pro-img"> 
                                                <?php
                                                $userid = $this->session->userdata('aileenuser');

                                                $firstname = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $art_data[0]['user_id']))->row()->art_name;
                                                $lastname = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $art_data[0]['user_id']))->row()->art_lastname;

                                                $firstnameposted = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $art_data[0]['posted_user_id']))->row()->art_name;
                                                $lastnameposted = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $art_data[0]['posted_user_id']))->row()->art_lastname;


                                                $art_userimage = $this->db->select('art_user_image')->get_where('art_reg', array('user_id' => $art_data[0]['user_id'], 'status' => '1'))->row()->art_user_image;

                                                $userimageposted = $this->db->select('art_user_image')->get_where('art_reg', array('user_id' => $art_data[0]['posted_user_id']))->row()->art_user_image;

                                                $slugposted = $this->db->select('slug')->get_where('art_reg', array('user_id' => $art_data[0]['posted_user_id']))->row()->slug;
                                                $slug = $this->db->select('slug')->get_where('art_reg', array('user_id' => $art_data[0]['user_id']))->row()->slug;


                                                // url changes start
                                                $contition_array = array('user_id' => $art_data[0]['user_id'], 'status' => 1);
                                                $arturl = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_city,art_skill,other_skill,slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                                $city_url = $this->db->select('city_name')->get_where('cities', array('city_id' => $arturl[0]['art_city'], 'status' => '1'))->row()->city_name;

                                                $art_othercategory = $this->db->select('other_category')->get_where('art_other_category', array('other_category_id' => $arturl[0]['other_skill']))->row()->other_category;

                                                $category = $arturl[0]['art_skill'];
                                                $category = explode(',', $category);

                                                foreach ($category as $catkey => $catval) {
                                                    $art_category = $this->db->select('art_category')->get_where('art_category', array('category_id' => $catval))->row()->art_category;
                                                    $categorylist[] = $art_category;
                                                }

                                                $listfinal1 = array_diff($categorylist, array('other'));
                                                $listFinal = implode('-', $listfinal1);

                                                if (!in_array(26, $category)) {
                                                    $category_url = $this->common->clean($listFinal);
                                                } else if ($arturl[0]['art_skill'] && $arturl[0]['other_skill']) {

                                                    $trimdata = $this->common->clean($listFinal) . '-' . $this->common->clean($art_othercategory);
                                                    $category_url = trim($trimdata, '-');
                                                } else {
                                                    $category_url = $this->common->clean($art_othercategory);
                                                }

                                                $city_get = $this->common->clean($city_url);

                                                $url_postid = $arturl[0]['slug'] . '-' . $category_url . '-' . $city_get . '-' . $arturl[0]['art_id'];

                                                // url changes start
                                                $contition_array = array('user_id' => $art_data[0]['posted_user_id'], 'status' => '1');
                                                $arturl = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_city,art_skill,other_skill,slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                                $city_url = $this->db->select('city_name')->get_where('cities', array('city_id' => $arturl[0]['art_city'], 'status' => '1'))->row()->city_name;

                                                $art_othercategory = $this->db->select('other_category')->get_where('art_other_category', array('other_category_id' => $arturl[0]['other_skill']))->row()->other_category;

                                                $category = $arturl[0]['art_skill'];
                                                $category = explode(',', $category);

                                                foreach ($category as $catkey => $catval) {
                                                    $art_category = $this->db->select('art_category')->get_where('art_category', array('category_id' => $catval))->row()->art_category;
                                                    $categorylist[] = $art_category;
                                                }

                                                $listfinal1 = array_diff($categorylist, array('other'));
                                                $listFinal = implode('-', $listfinal1);

                                                if (!in_array(26, $category)) {
                                                    $category_url = $this->common->clean($listFinal);
                                                } else if ($arturl[0]['art_skill'] && $arturl[0]['other_skill']) {

                                                    $trimdata = $this->common->clean($listFinal) . '-' . $this->common->clean($art_othercategory);
                                                    $category_url = trim($trimdata, '-');
                                                } else {
                                                    $category_url = $this->common->clean($art_othercategory);
                                                }

                                                $city_get = $this->common->clean($city_url);

                                                $url_postwithid = $arturl[0]['slug'] . '-' . $category_url . '-' . $city_get . '-' . $arturl[0]['art_id'];
                                                ?>
                                                <?php if ($art_data[0]['posted_user_id']) { ?>
                                                    <a  class="post_dot" title="<?php echo ucfirst(strtolower($firstnameposted)) . ' ' . ucfirst(strtolower($lastnameposted)); ?>" href="<?php echo base_url('artist/dashboard/' . $url_postwithid); ?>">


                                                        <?php
                                                        if (IMAGEPATHFROM == 'upload') {
                                                            if ($userimageposted) {
                                                                if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $userimageposted)) {
                                                                    ?>

                                                                    <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo "NOARTIMAGE"; ?>">

                                                                <?php } else { ?>
                                                                    <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $userimageposted; ?>"  alt="<?php echo $userimageposted; ?>">
                                                                <?php }
                                                            } else {
                                                                ?>
                                                                <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo "NOARTIMAGE"; ?>">
                                                                <?php
                                                            }
                                                        } else {

                                                            $filename = $this->config->item('art_profile_thumb_upload_path') . $userimageposted;
                                                            $s3 = new S3(awsAccessKey, awsSecretKey);
                                                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);

                                                            if ($info) {
                                                                ?>

                                                                <img src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $userimageposted; ?>" name="image_src" id="image_src" alt="<?php echo $userimageposted; ?>" />


            <?php } else { ?>

                                                                <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo "NOARTIMAGE"; ?>">

                                                            <?php }
                                                        }
                                                        ?>


                                                    </a>

    <?php } else if ($art_data[0]['user_id']) { ?>

                                                    <a  class="post_dot" title="<?php echo ucfirst(strtolower($firstnameposted)) . ' ' . ucfirst(strtolower($lastnameposted)); ?>" href="<?php echo base_url('artist/dashboard/' . $url_postid); ?>">


                                                        <?php
                                                        if (IMAGEPATHFROM == 'upload') {
                                                            if ($art_userimage) {
                                                                if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                                                                    ?>

                                                                    <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo "NOARTIMAGE"; ?>">

                                                                <?php } else { ?>
                                                                    <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage; ?>"  alt="<?php echo $art_userimage; ?>">
                                                                <?php }
                                                            } else {
                                                                ?>
                                                                <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo "NOARTIMAGE"; ?>">
                                                                <?php
                                                            }
                                                        } else {

                                                            $filename = $this->config->item('art_profile_thumb_upload_path') . $art_userimage;
                                                            $s3 = new S3(awsAccessKey, awsSecretKey);
                                                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);

                                                            if ($info) {
                                                                ?>
                                                                <img src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage; ?>" name="image_src" id="image_src" alt="<?php echo $art_userimage; ?>" />
                                                            <?php } else { ?>

                                                                <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo "NOARTIMAGE"; ?>">
                                                        <?php } ?>
                                                        </a>

        <?php }
    }
    ?>                                            
                                            </div>
                                            <div class="post-design-name fl col-xs-8 col-md-10">
                                                <ul>
                                                    <?php
                                                    $designation = $this->db->select('designation')->get_where('art_reg', array('user_id' => $row['user_id']))->row()->designation;

                                                    $userskill = $this->db->select('art_skill')->get_where('art_reg', array('user_id' => $art_data[0]['user_id']))->row()->art_skill;
                                                    $aud = $userskill;
                                                    $aud_res = explode(',', $aud);
                                                    foreach ($aud_res as $skill) {

                                                        $cache_time = $this->db->select('skill')->get_where('skill', array('skill_id' => $skill))->row()->skill;
                                                        $skill1[] = $cache_time;
                                                    }
                                                    $listFinal = implode(', ', $skill1);
                                                    ?>

                                                    <li><div class="post-design-product"><?php if ($art_data[0]['posted_user_id']) { ?>

                                                                <div class="else_post_d">
                                                                    <a  class="post_dot" title="<?php echo ucfirst(strtolower($firstnameposted)) . ' ' . ucfirst(strtolower($lastnameposted)); ?>" href="<?php echo base_url('artist/dashboard/' . $url_postwithid); ?>"><?php echo ucfirst(strtolower($firstnameposted)) . ' ' . ucfirst(strtolower($lastnameposted)); ?> </a>
                                                                    <p class="posted_with" > Posted With </p><a class="post_dot"  title="<?php echo ucfirst(strtolower($firstname)) . ' ' . ucfirst(strtolower($lastname)); ?>" href="<?php echo base_url('artist/dashboard/' . $url_postid); ?>"><?php echo ucfirst(strtolower($firstname)) . ' ' . ucfirst(strtolower($lastname)); ?></a>
                                                                    <span role="presentation" aria-hidden="true" style="color: #91949d; font-size: 14px;"> · </span>
                                                                    <span class="ctre_date"> 
        <?php echo $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($row['created_date']))); ?>

                                                                    </span>
                                                                </div>

                                                                <!-- other user post time name end-->
    <?php } else { ?>

                                                                <a  class="post_dot" title="<?php echo ucfirst(strtolower($firstname)) . ' ' . ucfirst(strtolower($lastname)); ?>"   href="<?php echo base_url('artist/dashboard/' . $url_postid); ?>">
        <?php echo ucfirst(strtolower($firstname)) . ' ' . ucfirst(strtolower($lastname)); ?>

                                                                </a>
                                                                <span role="presentation" aria-hidden="true"> · </span>
                                                                <div class="datespan">
                                                                    <span class="ctre_date">
        <?php echo $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($art_data[0]['created_date']))); ?>
                                                                    </span></div>

                                                                <?php } ?>                 </div></li>


                                                    <li><div class="post-design-product">
                                                            <a title="<?php echo $designation; ?>"><?php
                                                                if ($designation) {
                                                                    echo $designation;
                                                                } else {
                                                                    echo "Current Work";
                                                                }
                                                                ?> </a>

                                                        </div></li>

                                                </ul> 
                                            </div>  

                                            <div class="dropdown1">
                                                <a onClick="myFunctionone(<?php echo $art_data[0]['art_post_id']; ?>)" class="dropbtn_common dropbtn1 fa fa-ellipsis-v"></a>
                                                <div id="<?php echo "myDropdown" . $art_data[0]['art_post_id']; ?>" class="dropdown-content1 dropdown2_content">


                                                    <?php
                                                    if ($art_data[0]['posted_user_id'] != 0) {

                                                        if ($this->session->userdata('aileenuser') == $art_data[0]['posted_user_id']) {
                                                            ?>
                                                            <a id="<?php echo $art_data[0]['art_post_id']; ?>" onClick="deleteownpostmodel(this.id)" title="Delete Post"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete Post</a>

                                                            <a id="<?php echo $art_data[0]['art_post_id']; ?>" onClick="editpost(this.id)" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</a>

        <?php } else {
            ?>
            <?php
        }
    } else {
        ?>  

        <?php
        $userid = $this->session->userdata('aileenuser');
        if ($art_data[0]['user_id'] == $userid) {
            ?>
                                                            <a id="<?php echo $art_data[0]['art_post_id']; ?>" onClick="deleteownpostmodel(this.id)" title="Delete Post"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete Post</a>

                                                            <a id="<?php echo $art_data[0]['art_post_id']; ?>" onClick="editpost(this.id)" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</a>
                                                        <?php } else { ?>
                                                            <a id="<?php echo $art_data[0]['art_post_id']; ?>" onClick="deletepostmodel(this.id)" title="Delete Post"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete Post</a>

            <?php
        }
    }
    ?>
                                                </div>
                                            </div>
                                            <div class="post-design-desc">
                                                <span> 

                                                    <div id="<?php echo 'editpostdata' . $art_data[0]['art_post_id']; ?>" style="display:block;">
                                                        <a class="ft-15 t_artd" id="<?php echo 'editpostval' . $art_data[0]['art_post_id']; ?>" title="<?php echo $art_data[0]['art_post']; ?>"><?php echo $this->common->make_links($art_data[0]['art_post']); ?></a>
                                                    </div>

                                                    <div id="<?php echo 'editpostbox' . $art_data[0]['art_post_id']; ?>" style="display:none; margin-bottom: 10px;">
                                                        <input type="text" class="my_text" id="<?php echo 'editpostname' . $art_data[0]['art_post_id']; ?>" name="editpostname" placeholder="Product Name" value="<?php echo $art_data[0]['art_post']; ?>" onKeyDown=check_lengthedit(<?php echo $art_data[0]['art_post_id']; ?>); onKeyup=check_lengthedit(<?php echo $art_data[0]['art_post_id']; ?>); onblur=check_lengthedit(<?php echo $art_data[0]['art_post_id']; ?>);>


                                                        <?php
                                                        if ($art_data[0]['art_post']) {
                                                            $counter = $art_data[0]['art_post'];
                                                            $a = strlen($counter);
                                                            ?>

                                                            <input size=1 id="text_num" tabindex="-500" class="text_num" value="<?php echo (50 - $a); ?>" name=text_num readonly>

    <?php } else { ?>
                                                            <input size=1 id="text_num" class="text_num" tabindex="-500" value=50 name=text_num readonly> 

    <?php } ?>


                                                    </div>

                                                    <div id="<?php echo "khyati" . $art_data[0]['art_post_id']; ?>" style="display:block;">
                                                        
                                                        <?php
                                                        $num_words = 29;
                                                        $words = array();
                                                        $words = explode(" ", $art_data[0]['art_description'], $num_words);
                                                        $shown_string = "";
                                                        if (count($words) == 29) {
                                                            $words[28] = '... <span id="kkkk" onClick="khdiv(' . $art_data[0]['art_post_id'] . ')">View More</span>';
                                                        }
                                                        $shown_string = implode(" ", $words);
                                                        echo $this->common->make_links($shown_string);
                                                        ?>
                                                    </div>
                                                    <div id="<?php echo "khyatii" . $art_data[0]['art_post_id']; ?>" style="display:none;">
    <?php
    echo $art_data[0]['art_description'];
    ?>
                                                    </div>
                                                    <div id="<?php echo 'editpostdetailbox' . $art_data[0]['art_post_id']; ?>" style="display:none;">
                                                        <div contenteditable="true" id="<?php echo 'editpostdesc' . $art_data[0]['art_post_id']; ?>" name="editpostdesc" placeholder="Description" class="editable_text" onpaste="OnPaste_StripFormatting(this, event);" onfocus="return cursorpointer(<?php echo $art_data[0]['art_post_id']; ?>)"><?php echo $art_data[0]['art_description']; ?></div> 
                                                    </div>
                                                    <button class="fr" id="<?php echo "editpostsubmit" . $art_data[0]['art_post_id']; ?>" style="display:none; " onClick="edit_postinsert(<?php echo $art_data[0]['art_post_id']; ?>)">Save</button>

                                                </span>
                                            </div> 
                                        </div>
                                        <div class="post-design-mid col-md-12" >  
                                            <!-- 13-4 multiple image code  start-->
                                            <!-- multiple image code  start-->
                                            <!-- done  start-->

                                            <div>
                                                <?php
                                                $contition_array = array('post_id' => $art_data[0]['art_post_id'], 'is_deleted' => '1', 'insert_profile' => '1');
                                                $artmultiimage = $this->data['artmultiimage'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                ?>

                                                <?php
                                                $i = 1;
                                                foreach ($artmultiimage as $data) {


                                                    $allowed = array('jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg');
                                                    $allowespdf = array('pdf');
                                                    $allowesvideo = array('mp4', '3gp');
                                                    $allowesaudio = array('mp3');
                                                    $filename = $data['file_name'];
                                                    $ext = pathinfo($filename, PATHINFO_EXTENSION);

                                                    if (in_array($ext, $allowed)) {
                                                        ?>

                                                        <div class="one-image" >

                                                            <img src = "<?php echo ART_POST_MAIN_UPLOAD_URL . $data['file_name']; ?>" onclick="openModal();
                                                                            currentSlide(<?php echo $i; ?>)" class="hover-shadow cursor" alt="<?php echo $data['file_name']; ?>">
   
                                                        </div>

        <?php } elseif (in_array($ext, $allowesvideo)) { ?>
                                                        <!-- one video start -->
                                                        <div>
                                                            <video style="height: 50%; width: 100%; margin-bottom: 10px;"controls>
                                                                <source src="<?php echo base_url($this->config->item('art_post_main_upload_path') . $data['file_name']); ?>" type="video/mp4">
                                                                <source src="movie.ogg" type="video/ogg">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        </div>
                                                        <!-- one video end -->
        <?php } elseif (in_array($ext, $allowesaudio)) { ?>
                                                        <!-- one audio start -->
                                                        <div>
                                                            <audio style="height: 50%; width: 100%; margin-bottom: 10px;" controls>
                                                                <source src="<?php echo base_url($this->config->item('art_profile_main_upload_path') . $data['file_name']); ?>" type="audio/mp3">
                                                                <source src="movie.ogg" type="audio/ogg">
                                                                Your browser does not support the audio tag.

                                                            </audio>
                                                        </div>
                                                        <!-- one audio end -->
                                                    <?php } ?>
        <?php
        $i++;
    }
    ?>
                                            </div>
                                            <!-- done  end-->





                                            <!-- data khyati end -->   
                                        </div>

                                        <div class="post-design-like-box col-md-12">
                                            <div class="post-design-menu">
                                                <ul class="col-md-6">
                                                    <li class="<?php echo 'likepost' . $art_data[0]['art_post_id']; ?>">
                                                        <a title="Like" id="<?php echo $art_data[0]['art_post_id']; ?>"  class="ripple like_h_w" onClick="post_like(this.id)">
                                                            <?php
                                                            $userid = $this->session->userdata('aileenuser');
                                                            $contition_array = array('art_post_id' => $art_data[0]['art_post_id'], 'status' => '1');
                                                            $active = $this->data['active'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                            $likeuser = $this->data['active'][0]['art_like_user'];
                                                            $likeuserarray = explode(',', $active[0]['art_like_user']);
                                                            if (!in_array($userid, $likeuserarray)) {
                                                                ?>               
                                                                <i class="fa fa-thumbs-up" style="color: #999;" aria-hidden="true"></i>
                                                                <?php } else { ?> 
                                                                <i class="fa fa-thumbs-up main_color" aria-hidden="true"></i>
                                                                <?php } ?>
                                                            <span  class="like_As_count">
                                                                
                                                            </span>
                                                        </a>
                                                    </li>
                                                    <li id="<?php echo 'insertcount' . $art_data[0]['art_post_id']; ?>" style="visibility:show">
                                                                <?php
                                                                $contition_array = array('art_post_id' => $art_data[0]['art_post_id'], 'status' => '1', 'is_delete' => '0');
                                                                $commnetcount = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                                ?>
                                                        <a class="ripple like_h_w" title="Comment"  onClick="commentall(this.id)" id="<?php echo $art_data[0]['art_post_id']; ?>"><i class="fa fa-comment-o" aria-hidden="true"> 
                                                                
                                                            </i> 
                                                        </a>
                                                    </li>
                                                </ul>
                                                <ul class="col-md-6 like_cmnt_count">

                                                    <li>
                                                        <div class="comnt_count_ext like_count_ext<?php echo $art_data[0]['art_post_id']; ?>">
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
                                                        <div class="comnt_count_ext <?php echo 'comnt_count_ext' . $art_data[0]['art_post_id']; ?>">
                                                            <span class="comment_like_count"> 
    <?php
    if ($art_data[0]['art_likes_count'] > 0) {
        echo $art_data[0]['art_likes_count'];
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
                                        <!-- like user list start -->

                                        <!-- pop up box start-->
                                            <?php
                                            if ($art_data[0]['art_likes_count'] > 0) {
                                                ?>
                                            <div class="likeduserlist<?php echo $art_data[0]['art_post_id'] ?>">
                                                <?php
                                                $contition_array = array('art_post_id' => $art_data[0]['art_post_id'], 'status' => '1', 'is_delete' => '0');
                                                $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                $likeuser = $commnetcount[0]['art_like_user'];
                                                $countlike = $commnetcount[0]['art_likes_count'] - 1;
                                                $likelistarray = explode(',', $likeuser);
                                                foreach ($likelistarray as $key => $value) {
                                                    $art_fname1 = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $value, 'status' => '1'))->row()->art_name;
                                                    $art_lname1 = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $value, 'status' => '1'))->row()->art_lastname;
                                                    ?>
                                                <?php } ?>
                                                <!-- pop up box end-->

                                                <?php
                                                $contition_array = array('art_post_id' => $art_data[0]['art_post_id'], 'status' => '1', 'is_delete' => '0');
                                                $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                                $likeuser = $commnetcount[0]['art_like_user'];
                                                $countlike = $commnetcount[0]['art_likes_count'] - 1;

                                                $likelistarray = explode(',', $likeuser);
                                                $likelistarray = array_reverse($likelistarray);
                                                $art_fname = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => '1'))->row()->art_name;
                                                $art_lname = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => '1'))->row()->art_lastname;
                                                ?>
                                                <div class="like_one_other">
                                                    <a href="javascript:void(0);" class="likeuserlist1"  onclick="likeuserlist(<?php echo $art_data[0]['art_post_id']; ?>);">
                                                        <?php
                                                        if ($userid == $likelistarray[0]) {
                                                            echo "You";
                                                        } else {
                                                            echo ucfirst(strtolower($art_fname));
                                                            echo "&nbsp;";
                                                            echo ucfirst(strtolower($art_lname));
                                                            echo "&nbsp;";
                                                        }
                                                        ?>
                                                        <?php
                                                        if (count($likelistarray) > 1) {
                                                            echo "and ";
                                                            echo $countlike;
                                                            echo "&nbsp;";
                                                            echo "others";
                                                        }
                                                        ?>
                                                    </a>
                                                </div>

                                            </div>
                                                <?php
                                            }
                                            ?>
                                        <div class="<?php echo "likeusername" . $art_data[0]['art_post_id']; ?>" id="<?php echo "likeusername" . $art_data[0]['art_post_id']; ?>" style="display:none">
                                            <?php
                                            $contition_array = array('art_post_id' => $art_data[0]['art_post_id'], 'status' => '1', 'is_delete' => '0');
                                            $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                            $likeuser = $commnetcount[0]['art_like_user'];
                                            $countlike = $commnetcount[0]['art_likes_count'] - 1;
                                            $likelistarray = explode(',', $likeuser);
                                            foreach ($likelistarray as $key => $value) {
                                                $art_fname1 = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $value, 'status' => '1'))->row()->art_name;
                                                $art_lname1 = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $value, 'status' => '1'))->row()->art_lastname;
                                                ?>
                                            <?php } ?>
                                            <!-- pop up box end-->

                                            <?php
                                            $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1', 'is_delete' => '0');
                                            $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                            $likeuser = $commnetcount[0]['art_like_user'];
                                            $countlike = $commnetcount[0]['art_likes_count'] - 1;

                                            $likelistarray = explode(',', $likeuser);
                                            $art_fname = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => '1'))->row()->art_name;
                                            $art_lname = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => '1'))->row()->art_lastname;
                                            ?>
                                            <div class="like_one_other">
                                                <a href="javascript:void(0);"  class="likeuserlist1" onclick="likeuserlist(<?php echo $art_data[0]['art_post_id']; ?>);">
                                                    <?php
                                                    echo ucfirst(strtolower($art_fname));
                                                    echo "&nbsp;";
                                                    echo ucfirst(strtolower($art_lname));
                                                    echo "&nbsp;";
                                                    ?>
                                                    <?php
                                                    if (count($likelistarray) > 1) {
                                                        echo "and ";
                                                        echo $countlike;
                                                        echo "&nbsp;";
                                                        echo "others";
                                                    }
                                                    ?>
                                                </a>
                                            </div>

                                        </div>
                                        <!-- like user list end -->
                                        <!-- 8-5 comment start -->
                                        <div class="art-all-comment col-md-12">
                                            <!-- 18-4 all comment start-->
                                            <div id="<?php echo "fourcomment" . $art_data[0]['art_post_id']; ?>" style="display:none">
                                            </div>

                                            <!-- khyati changes start -->

                                            <div  id="<?php echo "threecomment" . $art_data[0]['art_post_id']; ?>" style="display:block">
                                                <div class="hidebottomborder <?php echo 'insertcomment' . $art_data[0]['art_post_id']; ?>">
                                                    <?php
                                                    $contition_array = array('art_post_id' => $art_data[0]['art_post_id'], 'status' => '1');
                                                    $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = 'artistic_post_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');

                                                    if ($artdata) {
                                                        foreach ($artdata as $rowdata) {
                                                            $artname = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->art_name;
                                                            $artlastname = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->art_lastname;
                                                            $artslug = $this->db->select('slug')->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->slug;

                                                            $contition_array = array('user_id' => $rowdata['user_id'], 'status' => '1');
                                                            $arturl = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_city,art_skill,other_skill,slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                                            $city_url = $this->db->select('city_name')->get_where('cities', array('city_id' => $arturl[0]['art_city'], 'status' => '1'))->row()->city_name;

                                                            $art_othercategory = $this->db->select('other_category')->get_where('art_other_category', array('other_category_id' => $arturl[0]['other_skill']))->row()->other_category;

                                                            $category = $arturl[0]['art_skill'];
                                                            $category = explode(',', $category);

                                                            foreach ($category as $catkey => $catval) {
                                                                $art_category = $this->db->select('art_category')->get_where('art_category', array('category_id' => $catval))->row()->art_category;
                                                                $categorylist[] = $art_category;
                                                            }

                                                            $listfinal1 = array_diff($categorylist, array('other'));
                                                            $listFinal = implode('-', $listfinal1);

                                                            if (!in_array(26, $category)) {
                                                                $category_url = $this->common->clean($listFinal);
                                                            } else if ($arturl[0]['art_skill'] && $arturl[0]['other_skill']) {

                                                                $trimdata = $this->common->clean($listFinal) . '-' . $this->common->clean($art_othercategory);
                                                                $category_url = trim($trimdata, '-');
                                                            } else {
                                                                $category_url = $this->common->clean($art_othercategory);
                                                            }

                                                            $url_art = $arturl[0]['slug'] . '-' . $category_url . '-' . $city_url . '-' . $arturl[0]['art_id'];
                                                            ?>
                                                            <div class="all-comment-comment-box">
                                                                <div class="post-design-pro-comment-img"> 

                                                                    <a  class="post_dot" title="<?php echo ucfirst(strtolower($artname)) . ' ' . ucfirst(strtolower($artlastname)); ?>" href="<?php echo base_url('artist/dashboard/' . $url_art); ?>"> 

                                                                        <?php
                                                                        $art_userimage = $this->db->select('art_user_image')->get_where('art_reg', array('user_id' => $rowdata['user_id'], 'status' => '1'))->row()->art_user_image;
                                                                        $art_first = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $rowdata['user_id'], 'status' => '1'))->row()->art_name;
                                                                        $art_last = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $rowdata['user_id'], 'status' => '1'))->row()->art_lastname;
                                                                        ?>


                                                                        <?php
                                                                        if (IMAGEPATHFROM == 'upload') {
                                                                            if ($art_userimage) {
                                                                                if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                                                                                    ?>

                                                                                    <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo "NOARTIMAGE"; ?>">

                    <?php } else { ?>
                                                                                    <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage; ?>"  alt="<?php echo $art_userimage; ?>">
                                                                                <?php }
                                                                            } else {
                                                                                ?>
                                                                                <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo "NOARTIMAGE"; ?>">

                                                                                <?php
                                                                            }
                                                                        } else {

                                                                            $filename = $this->config->item('art_profile_thumb_upload_path') . $art_userimage;
                                                                            $s3 = new S3(awsAccessKey, awsSecretKey);
                                                                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);


                                                                            if ($info) {
                                                                                ?>
                                                                                <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage; ?>"  alt="<?php echo $art_userimage; ?>">
                <?php } else { ?>

                                                                                <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo "NOARTIMAGE"; ?>">
                <?php }
            }
            ?>
                                                                    </a>
                                                                </div>
                                                                <div class="comment-name">
                                                                    <a  class="post_dot" title="<?php echo ucfirst(strtolower($artname)) . ' ' . ucfirst(strtolower($artlastname)); ?>" href="<?php echo base_url('artist/dashboard/' . $url_art); ?>"> 
                                                                        <b title=" <?php
                                                                               echo ucfirst(strtolower($artname));
                                                                               echo "&nbsp;";
                                                                               echo ucfirst(strtolower($artlastname));
                                                                               ?>">
            <?php
            echo ucfirst(strtolower($artname));
            echo "&nbsp;";
            echo ucfirst(strtolower($artlastname));
            ?></b><?php echo '</br>'; ?></a></div>

                                                                <div class="comment-details" id= "<?php echo "showcomment" . $rowdata['artistic_post_comment_id']; ?>">
                                                                    <div id="<?php echo "lessmore" . $rowdata['artistic_post_comment_id']; ?>" style="display:block;">
                                                                        <?php
                                                                        $small = substr($rowdata['comments'], 0, 180);
                                                                        echo $this->common->make_links($small);

                                                                        if (strlen($rowdata['comments']) > 180) {
                                                                            echo '... <span id="kkkk" onClick="seemorediv(' . $rowdata['artistic_post_comment_id'] . ')">See More</span>';
                                                                        }
                                                                        ?>
                                                                    </div>

                                                                    <div id="<?php echo "seemore" . $rowdata['artistic_post_comment_id']; ?>" style="display:none;">
            <?php
            echo $this->common->make_links($rowdata['comments']);
            ?>

                                                                    </div>
                                                                </div>
                                                                <!--                                                                        <div class="col-md-12">
                                                                                                                                            <div class="col-md-10">
                                                                                                                                                <div contenteditable="true"   class="editable_text" name="<?php echo $rowdata['artistic_post_comment_id']; ?>" id="<?php echo "editcomment" . $rowdata['artistic_post_comment_id']; ?>" style="display:none;-webkit-min-height: 40px;" onClick="commentedit(<?php echo $rowdata['artistic_post_comment_id']; ?>)" style="height:50px;" ><?php echo $rowdata['comments']; ?></div>
                                                                                                                                            </div>
                                                                
                                                                                                                                            <div class="col-md-2 comment-edit-button">
                                                                                                                                                <button id="<?php echo "editsubmit" . $rowdata['artistic_post_comment_id']; ?>" style="display:none" onClick="edit_comment(<?php echo $rowdata['artistic_post_comment_id']; ?>)">Comment</button>
                                                                                                                                            </div>
                                                                
                                                                                                                                        </div>-->
                                                                <div class="edit-comment-box">
                                                                    <div class="inputtype-edit-comment">
                                                                        <div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text edit_sd" name="<?php echo $rowdata['artistic_post_comment_id']; ?>"  id="editcomment<?php echo $rowdata['artistic_post_comment_id']; ?>" placeholder="Enter Your Comment " value= ""  onkeyup="commentedit(<?php echo $rowdata['artistic_post_comment_id']; ?>,<?php echo $art_data[0]['art_post_id']; ?>)" onpaste="OnPaste_StripFormatting(this, event);"><?php echo $rowdata['comments']; ?></div>
                                                                        <span class="comment-edit-button"><button id="<?php echo "editsubmit" . $rowdata['artistic_post_comment_id']; ?>" style="display:none" onClick="edit_comment(<?php echo $rowdata['artistic_post_comment_id']; ?>,<?php echo $art_data[0]['art_post_id']; ?>)">Save</button></span>
                                                                    </div>
                                                                </div>

                                                                <div class="art-comment-menu-design"> 
                                                                    <div class="comment-details-menu" id="<?php echo 'likecomment1' . $rowdata['artistic_post_comment_id']; ?>">
                                                                        <a id="<?php echo $rowdata['artistic_post_comment_id']; ?>"   onClick="comment_like1(this.id)">

                                                                            <?php
                                                                            $userid = $this->session->userdata('aileenuser');
                                                                            $contition_array = array('artistic_post_comment_id' => $rowdata['artistic_post_comment_id'], 'status' => '1');
                                                                            $artcommentlike = $this->data['artcommentlike'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                                            $likeuserarray = explode(',', $artcommentlike[0]['artistic_comment_like_user']);

                                                                            if (!in_array($userid, $likeuserarray)) {
                                                                                ?>

                                                                                <i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i> 
                                                                                <?php } else {
                                                                                    ?>
                                                                                <i class="fa fa-thumbs-up main_color" aria-hidden="true"></i>
                                                                                <?php }
                                                                                ?>
                                                                            <span>
            <?php
            if ($rowdata['artistic_comment_likes_count'] > 0) {
                echo $rowdata['artistic_comment_likes_count'];
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
                                                                            <div id="<?php echo 'editcommentbox' . $rowdata['artistic_post_comment_id']; ?>" style="display:block;">
                                                                                <a id="<?php echo $rowdata['artistic_post_comment_id']; ?>" onClick="comment_editbox(this.id,<?php echo $art_data[0]['art_post_id']; ?>)" class="editbox" title="Edit">Edit
                                                                                </a>
                                                                            </div>
                                                                            <div id="<?php echo 'editcancle' . $rowdata['artistic_post_comment_id']; ?>" style="display:none;">
                                                                                <a id="<?php echo $rowdata['artistic_post_comment_id']; ?>" onClick="comment_editcancle(this.id,<?php echo $art_data[0]['art_post_id']; ?>)" tilte="Cancel">Cancel
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>

                                                                    <?php
                                                                    $userid = $this->session->userdata('aileenuser');

                                                                    $art_userid = $this->db->select('user_id')->get_where('art_post', array('art_post_id' => $rowdata['art_post_id'], 'status' => '1'))->row()->user_id;


                                                                    if ($rowdata['user_id'] == $userid || $art_userid == $userid) {
                                                                        ?> 
                                                                        <span role="presentation" aria-hidden="true"> · </span>
                                                                        <div class="comment-details-menu">
                                                                            <input type="hidden" name="post_delete"  id="<?php echo 'post_delete' . $rowdata['artistic_post_comment_id']; ?>" value= "<?php echo $rowdata['art_post_id']; ?>">
                                                                            <a id="<?php echo $rowdata['artistic_post_comment_id']; ?>"   onClick="comment_delete(this.id)" title="Delete"> Delete<span class="<?php echo 'insertcomment' . $rowdata['artistic_post_comment_id']; ?>">
                                                                                </span>
                                                                            </a>
                                                                        </div>
                                                                            <?php } ?>

                                                                    <span role="presentation" aria-hidden="true"> · </span>

                                                                    <div class="comment-details-menu">
                                                                        <p> <?php
                                                                            
                                                                            echo $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($rowdata['created_date'])));
                                                                            echo '</br>';
                                                                            ?>
                                                                        </p></div></div>
                                                            </div>
            <?php
        }
    }
    ?>

                                                </div>
                                            </div>
                                            <!-- khyati changes end -->

                                            <!-- all comment end-->


                                        </div>
                                        <!-- 8-5 comment end -->
                                        <div class="post-design-commnet-box col-md-12" id="<?php echo "box_hide" . $art_data[0]['art_post_id']; ?>">
                                            <?php
                                            $userid = $this->session->userdata('aileenuser');
                                            $art_userimage = $this->db->select('art_user_image')->get_where('art_reg', array('user_id' => $userid, 'status' => '1'))->row()->art_user_image;
                                            $art_first = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $userid, 'status' => '1'))->row()->art_name;
                                            $art_last = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $userid, 'status' => '1'))->row()->art_lastname;
                                            $art_slug = $this->db->select('slug')->get_where('art_reg', array('user_id' => $userid, 'status' => '1'))->row()->slug;


                                            $contition_array = array('user_id' => $userid, 'status' => '1');
                                            $arturl = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_city,art_skill,other_skill,slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                            $city_url = $this->db->select('city_name')->get_where('cities', array('city_id' => $arturl[0]['art_city'], 'status' => '1'))->row()->city_name;

                                            $art_othercategory = $this->db->select('other_category')->get_where('art_other_category', array('other_category_id' => $arturl[0]['other_skill']))->row()->other_category;

                                            $category = $arturl[0]['art_skill'];
                                            $category = explode(',', $category);

                                            foreach ($category as $catkey => $catval) {
                                                $art_category = $this->db->select('art_category')->get_where('art_category', array('category_id' => $catval))->row()->art_category;
                                                $categorylist[] = $art_category;
                                            }

                                            $listfinal1 = array_diff($categorylist, array('other'));
                                            $listFinal = implode('-', $listfinal1);

                                            if (!in_array(26, $category)) {
                                                $category_url = $this->common->clean($listFinal);
                                            } else if ($arturl[0]['art_skill'] && $arturl[0]['other_skill']) {

                                                $trimdata = $this->common->clean($listFinal) . '-' . $this->common->clean($art_othercategory);
                                                $category_url = trim($trimdata, '-');
                                            } else {
                                                $category_url = $this->common->clean($art_othercategory);
                                            }

                                            $url_get = $arturl[0]['slug'] . '-' . $category_url . '-' . $city_url . '-' . $arturl[0]['art_id'];
                                            ?>

                                            <div class="post-design-proo-img  hidden-mob">
                                                <a  class="post_dot" title="<?php echo ucfirst(strtolower($art_first)) . ' ' . ucfirst(strtolower($art_last)); ?>" href="<?php echo base_url('artist/dashboard/' . $url_get); ?>">

    <?php
    if (IMAGEPATHFROM == 'upload') {
        if ($art_userimage) {
            if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                ?>

                                                                <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo "NOARTIMAGE"; ?>">

                                                            <?php } else { ?>
                                                                <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage; ?>"  alt="<?php echo $art_userimage; ?>">
                                                            <?php }
                                                        } else {
                                                            ?>
                                                            <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo "NOARTIMAGE"; ?>">

                                                            <?php
                                                        }
                                                    } else {

                                                        $filename = $this->config->item('art_profile_thumb_upload_path') . $art_userimage;
                                                        $s3 = new S3(awsAccessKey, awsSecretKey);
                                                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);

                                                        if ($info) {
                                                            ?>
                                                            <img src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage; ?>" name="image_src" id="image_src" alt="<?php echo $art_userimage; ?>"/>
        <?php } else { ?>

                                                            <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo "NOARTIMAGE"; ?>">
        <?php }
    }
    ?>
                                                </a>
                                            </div>
                                            <div class="">
                                                <div id="content" class="col-md-12 inputtype-comment cmy_2" >
                                                    <div contenteditable="true"  class="editable_text edt_2" name="<?php echo $art_data[0]['art_post_id']; ?>"  id="<?php echo "post_comment" . $art_data[0]['art_post_id']; ?>" placeholder="Add a Comment ..." onClick="entercomment(<?php echo $art_data[0]['art_post_id']; ?>)" onpaste="OnPaste_StripFormatting(this, event);" ></div>

                                                    <div class="mob-comment">
                                                        <button id="<?php echo $art_data[0]['art_post_id']; ?>" onClick="insert_comment(this.id)"><img src="<?php echo base_url('assets/img/send.png') ?>" alt="<?php echo "send.png"; ?>"></button> 

                                                    </div>

                                                </div>
    <?php echo form_error('post_comment'); ?>


                                                <div class=" comment-edit-butn hidden-mob">   
                                                    <button id="<?php echo $art_data[0]['art_post_id']; ?>" onClick="insert_comment(this.id)">Comment</button> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>


<?php } else { ?>

                                <div class="art_no_post_avl">
                                    <h3>Artistic Post</h3>
                                    <div class="art-img-nn">
                                        <div class="art_no_post_img">

                                            <img src="<?php echo base_url('assets/img/art-no.png') ?>" alt="<?php echo "art-no.png"; ?>">

                                        </div>
                                        <div class="art_no_post_text">
                                            Sorry, this content isn't available at the moment
                                        </div>
                                    </div>
                                </div>
<?php } ?>
                        </div>
                    </div>

                    <!--                    DIV FINISH-->


                    <div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig"> 

                        <div class="all-profile-box">
                                <div class="all-pro-head">
                                    <h4>Profiles<a href="<?php echo base_url('profiles/') . $this->session->userdata('aileenuser_slug'); ?>" class="pull-right" title="All">All</a></h4>
                                </div>
                                <ul class="all-pr-list">
                                    <li>
                                        <a href="<?php echo base_url('job'); ?>" title="Job Profile">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i1.jpg'); ?>" alt="<?php echo "i1.jpg"; ?>">
                                            </div>
                                            <span>Job Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('recruiter'); ?>" title="Recruiter Profile">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i2.jpg'); ?>" alt="<?php echo "i2.jpg"; ?>">
                                            </div>
                                            <span>Recruiter Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('freelance'); ?>" title="Freelance Profile">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i3.jpg'); ?>" alt="<?php echo "i3.jpg"; ?>">
                                            </div>
                                            <span>Freelance Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('business-profile'); ?>" title="Business Profile">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i4.jpg'); ?>" alt="<?php echo "i4.jpg"; ?>">
                                            </div>
                                            <span>Business Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('artist'); ?>" title="Artistic Profile">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i5.jpg'); ?>" alt="<?php echo "i5.jpg"; ?>">
                                            </div>
                                            <span>Artistic Profile</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                    </div>
                    
                </div>
            </div>
        </div>


        <!-- silder start -->
        <div id="myModal1" class="modal2">
            <span class="close2 cursor" onclick="closeModal()">&times;</span>
            <div class="modal-content2">

                <!--  multiple image start -->
                <?php
                $i = 1;
                $allowed = array('jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg');
                foreach ($artmultiimage as $mke => $mval) {
                    $ext = pathinfo($mval['file_name'], PATHINFO_EXTENSION);
                    if (in_array($ext, $allowed)) {
                        $databus1[] = $mval;
                    }
                }

                foreach ($databus1 as $artdata) {
                    ?>
                    <div class="mySlides">
                        <div class="numbertext"><?php echo $i ?> / <?php echo count($databus1) ?></div>
                        <div class="slider_img">                        
                            <img src = "<?php echo ART_POST_MAIN_UPLOAD_URL . $artdata['file_name']; ?>" alt="<?php echo $artdata['file_name']; ?>">
                            <a class="prev" style="left: 0;" onclick="plusSlides( - 1)">&#10094;</a>
                            <a class="next" style="right:  0;" onclick="plusSlides(1)">&#10095;</a>
                        </div>
                        <!-- 9-5 like comment start -->

                                            <?php if (count($databus1) > 1) { ?>
                            <div class="post-design-like-box col-md-12">
                                <div class="post-design-menu">
                                    <!-- like comment div start -->
                                    <ul class="col-md-6">

                                        <li class="<?php echo 'likepostimg' . $artdata['post_files_id']; ?>">
                                            <a id="<?php echo $artdata['post_files_id']; ?>" class="ripple like_h_w" onClick="post_likeimg(this.id)">

                                                <?php
                                                $userid = $this->session->userdata('aileenuser');
                                                $contition_array = array('post_image_id' => $artdata['post_files_id'], 'user_id' => $userid, 'is_unlike' => '0');

                                                $activedata = $this->data['activedata'] = $this->common->select_data_by_condition('art_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                                if ($activedata) {
                                                    ?>
                                                    <i class="fa fa-thumbs-up main_color" aria-hidden="true"></i>
                                                    <?php } else { ?>
                                                    <i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>
                                                    <?php } ?>


                                                <span class="<?php echo 'likeimage' . $artdata['post_files_id']; ?>"> <?php
                                            $contition_array = array('post_image_id' => $artdata['post_files_id'], 'is_unlike' => '0');
                                            $likecount = $this->common->select_data_by_condition('art_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                                    ?>

                                                </span>
                                            </a>
                                        </li>
                                        <li id="<?php echo "insertcountimg" . $artdata['post_files_id']; ?>" style="visibility:show">

                                                    <?php
                                                    $contition_array = array('post_image_id' => $artdata['post_files_id'], 'is_delete' => '0');
                                                    $commnetcount = $this->common->select_data_by_condition('art_post_image_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                    ?>

                                            <a class="ripple like_h_w" onClick="commentallimg(this.id)" id="<?php echo $artdata['post_files_id']; ?>">
                                                <i class="fa fa-comment-o" aria-hidden="true">
       
                                                </i> 
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="col-md-6 like_cmnt_count">

                                        <li>
                                            <div class="like_cmmt_space comnt_count_ext like_count_ext_img<?php echo $artdata['post_files_id']; ?>">
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
                                            <div class=" comnt_count_ext <?php echo 'comnt_count_ext_img' . $artdata['post_files_id']; ?>">
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
                                    <!-- like comment div end -->
                                </div>
                            </div>


                            <!-- like user list start -->

                            <!-- pop up box start-->
                                <?php
                                $contition_array = array('post_image_id' => $artdata['post_files_id'], 'is_unlike' => '0');
                                $commnetlike = $this->common->select_data_by_condition('art_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                if (count($commnetlike) > 0) {
                                    ?>
                                <div class="likeduserlistimg<?php echo $artdata['post_files_id']; ?> likeduserlist1">
                                    <?php
                                    $contition_array = array('post_image_id' => $artdata['post_files_id'], 'is_unlike' => '0');
                                    $commnetcount = $this->common->select_data_by_condition('art_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                               
                                    foreach ($commnetcount as $comment) {
                                        $art_fname1 = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $comment['user_id'], 'status' => '1'))->row()->art_name;
                                        $art_lname1 = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $comment['user_id'], 'status' => '1'))->row()->art_lastname;
                                        ?>
                                    <?php } ?>
                                    <!-- pop up box end-->

            <?php
            $contition_array = array('post_image_id' => $artdata['post_files_id'], 'is_unlike' => '0');
            $commnetcount = $this->common->select_data_by_condition('art_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            $art_fname = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $commnetcount[0]['user_id'], 'status' => '1'))->row()->art_name;
            $art_lname = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $commnetcount[0]['user_id'], 'status' => '1'))->row()->art_lastname;
            ?>
                                    <div class="like_one_other" >
                                        <a href="javascript:void(0);" class="likeuserlist1"  onclick="likeuserlistimg(<?php echo $artdata['post_files_id']; ?>);">
                                            <?php
                                            if ($userid == $commnetcount[0]['user_id']) {
                                                echo "You";
                                            } else {
                                                echo ucfirst(strtolower($art_fname));
                                                echo "&nbsp;";
                                                echo ucfirst(strtolower($art_lname));
                                                echo "&nbsp;";
                                            }
                                            ?>
            <?php
            if (count($commnetcount) > 1) {
                echo "and ";
                echo '' . count($commnetcount) - 1 . '';
                echo "&nbsp;";
                echo "others";
            }
            ?>
                                        </a>
                                    </div>

                                </div>
                                    <?php
                                }
                                ?>
                            <div class="likeduserlist <?php echo "likeusernameimg" . $artdata['post_files_id']; ?>" id="<?php echo "likeusernameimg" . $artdata['post_files_id']; ?>" style="display:none">
                                <?php
                                $contition_array = array('post_image_id' => $artdata['post_files_id'], 'is_unlike' => '0');
                                $commnetcount = $this->common->select_data_by_condition('art_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                              
                                foreach ($commnetcount as $comment) {
                                    $art_fname1 = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $comment['user_id'], 'status' => '1'))->row()->art_name;
                                    $art_lname1 = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $comment['user_id'], 'status' => '1'))->row()->art_lastname;
                                    ?>
                                <?php } ?>
                                <!-- pop up box end-->

        <?php
        $contition_array = array('post_image_id' => $artdata['post_files_id'], 'is_unlike' => '0');
        $commnetcount = $this->common->select_data_by_condition('art_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        $art_fname = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $commnetcount[0]['user_id'], 'status' => '1'))->row()->art_name;
        $art_lname = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $commnetcount[0]['user_id'], 'status' => '1'))->row()->art_lastname;
        ?>
                                <div class="like_one_other" >
                                    <a href="javascript:void(0);" class="likeuserlist1" onclick="likeuserlistimg(<?php echo $artdata['post_files_id']; ?>);">
                                        <?php
                                        if ($userid == $commnetcount[0]['user_id']) {
                                            echo "You";
                                        } else {
                                            echo ucfirst(strtolower($art_fname));
                                            echo "&nbsp;";
                                            echo ucfirst(strtolower($art_lname));
                                            echo "&nbsp;";
                                        }
                                        ?>
        <?php
        if (count($commnetcount) > 1) {
            echo "and ";
            echo '' . count($commnetcount) - 1 . '';
            echo "&nbsp;";
            echo "others";
        }
        ?>
                                    </a>
                                </div>

                            </div>
                            <!-- like user list end -->



                            <div class="art-all-comment col-md-12">
                                <!-- 18-4 all comment start-->
                                <div id="<?php echo "fourcommentimg" . $artdata['post_files_id']; ?>" style="display:none">
                                </div>

                                <!-- khyati changes start -->

                                <div  id="<?php echo "threecommentimg" . $artdata['post_files_id']; ?>" style="display:block">
                                    <div class="hidebottomborder <?php echo 'insertcommentimg' . $artdata['post_files_id']; ?>">
                                        <?php
                                        $contition_array = array('post_image_id' => $artdata['post_files_id'], 'is_delete' => '0');
                                        $artmulimage = $this->common->select_data_by_condition('art_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');
                                        if ($artmulimage) {
                                            foreach ($artmulimage as $rowdata) {
                                                $companyname = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->art_name;

                                                $lastname = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->art_lastname;
                                                $slugdata = $this->db->select('slug')->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->slug;
                                                ?>
                                                <div class="all-comment-comment-box">
                                                    <div class="post-design-pro-comment-img">

                                                        <a  class="post_dot" title="<?php echo ucfirst(strtolower($companyname)) . ' ' . ucfirst(strtolower($lastname)); ?>" href="<?php echo base_url('artist/dashboard/' . $slugdata); ?>"> 

                                                            <?php
                                                            $art_userimage = $this->db->select('art_user_image')->get_where('art_reg', array('user_id' => $rowdata['user_id'], 'status' => '1'))->row()->art_user_image;
                                                            ?>

                                                            <?php
                                                            if (IMAGEPATHFROM == 'upload') {
                                                                if ($art_userimage) {
                                                                    if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                                                                        ?>

                                                                        <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo "NOARTIMAGE"; ?>">

                                                                    <?php } else { ?>
                                                                        <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage; ?>"  alt="<?php echo $art_userimage; ?>">
                                                                    <?php }
                                                                } else {
                                                                    ?>
                                                                    <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo "NOARTIMAGE"; ?>">

                                                                    <?php
                                                                }
                                                            } else {

                                                                $filename = $this->config->item('art_profile_thumb_upload_path') . $art_userimage;
                                                                $s3 = new S3(awsAccessKey, awsSecretKey);
                                                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);

                                                                if ($info) {
                                                                    ?>
                                                                    <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage; ?>"  alt="<?php echo $art_userimage; ?>">
                                                                    <?php } else { ?>

                                                                    <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo "NOARTIMAGE"; ?>">
                                                                    <?php }
                                                                }
                                                                ?>

                                                        </a>         
                                                    </div>
                                                    <div class="comment-name">
                                                        <b>  <a  class="post_dot" title="<?php echo ucfirst(strtolower($companyname)) . ' ' . ucfirst(strtolower($lastname)); ?>" href="<?php echo base_url('artist/dashboard/' . $slugdata); ?>"> <?php
                                                        echo ucfirst(strtolower($companyname)) . ' ' . ucfirst(strtolower($lastname));
                                                        echo '</br>';
                                                        ?>
                                                            </a></b>
                                                    </div>

                                                    <div class="comment-details" id= "<?php echo "showcommentimg" . $rowdata['post_image_comment_id']; ?>">


                <?php
                echo $this->common->make_links($rowdata['comment']);
                ?>


                                                    </div>

                                                    <div class="edit-comment-box">
                                                        <div class="inputtype-edit-comment">
                                                            <div contenteditable="true" style="display:none;" class="editable_text edit" name="<?php echo $rowdata['post_image_comment_id']; ?>"  id="editcommentimg<?php echo $rowdata['post_image_comment_id']; ?>" placeholder="Enter Your Comment " value= ""  onkeyup="commenteditimg(<?php echo $rowdata['post_image_comment_id']; ?>,<?php echo $artdata['post_files_id']; ?>)" onpaste="OnPaste_StripFormatting(this, event);"><?php echo $rowdata['comment']; ?></div>
                                                            <span class="comment-edit-button">
                                                                <button id="<?php echo "editsubmitimg" . $rowdata['post_image_comment_id']; ?>" style="display:none" onClick="edit_commentimg(<?php echo $rowdata['post_image_comment_id']; ?>,<?php echo $artdata['post_files_id']; ?>)">Save</button></span>
                                                        </div>
                                                    </div>



                                                    <div class="art-comment-menu-design"> 
                                                        <div class="comment-details-menu" id="<?php echo 'likecommentimg' . $rowdata['post_image_comment_id']; ?>">
                                                            <a id="<?php echo $rowdata['post_image_comment_id']; ?>"   onClick="comment_likeimg(this.id)">

                                                                <?php
                                                                $userid = $this->session->userdata('aileenuser');
                                                                $contition_array = array('post_image_comment_id' => $rowdata['post_image_comment_id'], 'user_id' => $userid, 'is_unlike' => '0');

                                                                $artcommentlike1 = $this->common->select_data_by_condition('art_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                                if (count($artcommentlike1) == 0) {
                                                                    ?>
                                                                    <i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>

                                                                    <?php } else { ?>
                                                                    <i class="fa fa-thumbs-up main_color" aria-hidden="true"></i>
                                                                    <?php } ?>
                                                                <span>

                <?php
                $contition_array = array('post_image_comment_id' => $rowdata['post_image_comment_id'], 'is_unlike' => '0');
                $mulcountlike = $this->data['mulcountlike'] = $this->common->select_data_by_condition('art_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

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

                                                            <span role="presentation" aria-hidden="true"> · </span>
                                                            <div class="comment-details-menu">
                                                                <div id="<?php echo 'editcommentboximg' . $rowdata['post_image_comment_id']; ?>" style="display:block;">

                                                                    <a id="<?php echo $rowdata['post_image_comment_id']; ?>" onClick="comment_editboximg(this.id, <?php echo $artdata['post_files_id']; ?>)" class="editbox" title="Edit">Edit
                                                                    </a>
                                                                </div>
                                                                <div id="<?php echo 'editcancleimg' . $rowdata['post_image_comment_id']; ?>" style="display:none;">
                                                                    <a id="<?php echo $rowdata['post_image_comment_id']; ?>" onClick="comment_editcancleimg(this.id, <?php echo $artdata['post_files_id']; ?>)" title="Cancel">Cancel
                                                                    </a>
                                                                </div>
                                                            </div>
                <?php } ?>

                <?php
                $userid = $this->session->userdata('aileenuser');

                $business_userid = $this->db->select('user_id')->get_where('art_post', array('art_post_id' => $rowdata['post_image_id'], 'status' => '1'))->row()->user_id;


                if ($rowdata['user_id'] == $userid || $business_userid == $userid) {
                    ?> 
                                                            <span role="presentation" aria-hidden="true"> · </span>
                                                            <div class="comment-details-menu">
                                                                <input type="hidden" name="post_deleteimg"  id="post_deleteimg<?php echo $rowdata['post_image_comment_id']; ?>" value= "<?php echo $rowdata['post_image_id']; ?>">
                                                                <a id="<?php echo $rowdata['post_image_comment_id']; ?>"   onClick="comment_deleteimg(this.id)" title="Delete"> Delete<span class="<?php echo 'insertcommentimg' . $rowdata['post_image_comment_id']; ?>">
                                                                    </span>
                                                                </a>
                                                            </div>
                                                                <?php } ?>

                                                        <span role="presentation" aria-hidden="true"> · </span>

                                                        <div class="comment-details-menu">
                                                            <p> <?php
                                               
                                                echo $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($rowdata['created_date'])));
                                                echo '</br>';
                                                ?>
                                                            </p></div></div>
                                                </div>
                <?php
            }
        }
        ?>

                                    </div>
                                </div>
                                <!-- khyati changes end -->

                                <!-- all comment end-->


                            </div>

                                    <?php //  }     ?>
                            <div class="post-design-commnet-box col-md-12" id="<?php echo "box_comment" . $artdata['post_files_id']; ?>">
                                    <?php
                                    $userid = $this->session->userdata('aileenuser');
                                    $art_userimage = $this->db->select('art_user_image')->get_where('art_reg', array('user_id' => $userid, 'status' => '1'))->row()->art_user_image;
                                    $art_firstuser = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $userid, 'status' => '1'))->row()->art_name;
                                    $art_lastuser = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $userid, 'status' => '1'))->row()->art_lastname;
                                    ?>
                                <div class="post-design-proo-img hidden-mob">

                                    <?php
                                    if (IMAGEPATHFROM == 'upload') {
                                        if ($art_userimage) {
                                            if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                                                ?>

                                                <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo "NOARTIMAGE"; ?>">

                                            <?php } else { ?>
                                                <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage; ?>"  alt="<?php echo $art_userimage; ?>">
                                            <?php }
                                        } else {
                                            ?>
                                            <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo "NOARTIMAGE"; ?>">

                                            <?php
                                        }
                                    } else {

                                        $filename = $this->config->item('art_profile_thumb_upload_path') . $art_userimage;
                                        $s3 = new S3(awsAccessKey, awsSecretKey);
                                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);

                                        if ($info) {
                                            ?>
                                            <img src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage; ?>" name="image_src" id="image_src" alt="<?php echo $art_userimage; ?>"/>
            <?php } else { ?>

                                            <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo "NOARTIMAGE"; ?>">
                                        <?php }
                                    }
                                    ?>
                                </div>
                                <div class="">
                                    <div id="content" class="col-md-12 inputtype-comment cmy_2" >
                                        <div contenteditable="true"  class="editable_text edt_2" name="<?php echo $artdata['post_files_id']; ?>"  id="<?php echo "post_commentimg" . $artdata['post_files_id']; ?>" placeholder="Add a Comment ..." onclick="entercommentimg(<?php echo $artdata['post_files_id']; ?>)" onpaste="OnPaste_StripFormatting(this, event);" ></div>
                                        <div class="mob-comment">       
                                            <button id="<?php echo $artdata['post_files_id']; ?>" onClick="insert_commentimg(this.id)"><img src=<?php echo base_url('assets/img/send.png'); ?> alt="<?php echo "send.png"; ?>">
                                            </button>
                                        </div>
                                    </div>
                        <?php echo form_error('post_commentimg'); ?>
                                    <div class="comment-edit-butn hidden-mob">   
                                        <button id="<?php echo $artdata['post_files_id']; ?>" onClick="insert_commentimg(this.id)">Comment</button> 
                                    </div>
                                </div>
                            </div>
                            <!-- 9-5 like comment end -->
        <?php
    }
    ?>
                    </div>
    <?php
    $i++;
}
?>
                <!-- slider image rotation end  -->


                <div class="caption-container">
                    <p id="caption"></p>
                </div>

            </div>
        </div>
        <!-- slider end -->

        <!-- Bid-modal  -->
        <div class="modal fade message-box biderror" id="bidmodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;
                    </button>       
                    <div class="modal-body">
                        <span class="mes">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Model Popup Close -->

        <!-- Model Popup Close -->
        <!-- Bid-modal-2  -->
        <div class="modal fade message-box" id="likeusermodal" role="dialog">
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
<?php echo $footer; ?>

    <?php
  if (IS_ART_JS_MINIFY == '0') { ?>

        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
<?php }else{?>

         <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()) ?>"></script>

<?php }?>
        <script>
                                            var base_url = '<?php echo base_url(); ?>';
                                            var data = <?php echo json_encode($demo); ?>;
                                            var data1 = <?php echo json_encode($de); ?>;</script>

     <?php
  if (IS_ART_JS_MINIFY == '0') { ?>
                                         
        <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/postnewpage.js?ver=' . time()); ?>"></script>
  <?php }else{?>
  
    <script  type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/postnewpage.js?ver=' . time()); ?>"></script>
    
  <?php }?>      
    </body>
</html>