<!DOCTYPE html>
<html>
<head>
<title><?php echo $title; ?></title>
<?php echo $head; ?>

<?php if(IS_NOT_CSS_MINIFY == '0'){ ?> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/artistic.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/profiles/common/mobile.css?ver='.time()) ;?>" />
<?php }else{?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/artistic.css?ver='.time()); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/profiles/common/mobile.css?ver='.time()) ;?>" />
<?php }?>
<style type="text/css">
                        .likeduser{
                            width: 100%;
                            background-color: #00002D;
                        }
                        .likeduser-title{
                            color: #fff;
                            margin-bottom: 5px;
                            padding: 7px;
                        }
                        .likeuser_list{
                            background-color: #ccc;
                            float: left;
                            margin: 0px 6px 5px 9px;
                            padding: 5px;
                            width: 47%;
                            font-size: 14px;
                        }
                        .likeduserlist, .likeduserlist1 {
                            float: left;
                            /*        margin-left: 15px;
                                    margin-right: 15px;*/
                            width: 96%;
                            background-color: #fff !important;
                        }
                        div[class^="likeduserlist"]{
                            width: 100% !important;
                            background-color: #fff !important;
                        }
                        .like_one_other{
                            /* margin-left: 15px;
                            */    /*  margin-right: 15px;*/

                        }

                    </style>
                   
    <body>
    <?php echo $header; ?>
<?php echo $art_header2_border; ?>
        <div class="user-midd-section bui_art_left_box" id="paddingtop_fixed">
            <div class="container">
                <div class="row">

                    <div class="profile-box profile-box-custom col-md-4 animated fadeInLeftBig left_side_posrt">
                         <?php ?>
<?php echo $left_artistic; ?>

                    </div>
                    <!-- cover pic end -->
                     <div class="col-md-7 col-sm-12  fixed_middle_side custom-right-art">


    <div class="col-md-12 col-sm-12 post-design-box">

                            <div class=" ">
                                <div class="post-design-top col-md-12" >  
                                    <div class="post-design-pro-img"> 
                                        <?php
                                        $art_userimage = $this->db->get_where('art_reg', array('user_id' => $art_data[0]['user_id'], 'status' => '1'))->row()->art_user_image;

                                        $userimageposted = $this->db->get_where('art_reg', array('user_id' => $art_data[0]['posted_user_id']))->row()->art_user_image;


               $contition_array = array('user_id' => $art_data[0]['posted_user_id'], 'status' => '1');
              $arturl = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_city,art_skill,other_skill,slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

               $city_url = $this->db->select('city_name')->get_where('cities', array('city_id' => $arturl[0]['art_city'], 'status' => '1'))->row()->city_name;

                $art_othercategory = $this->db->select('other_category')->get_where('art_other_category', array('other_category_id' => $arturl[0]['other_skill']))->row()->other_category;

                                    $category = $arturl[0]['art_skill'];
                                    $category = explode(',' , $category);

                                    foreach ($category as $catkey => $catval) {
                                       $art_category = $this->db->select('art_category')->get_where('art_category', array('category_id' => $catval))->row()->art_category;
                                       $categorylist[] = $art_category;
                                     } 

                                    $listfinal1 = array_diff($categorylist, array('other'));
                                    $listFinal = implode('-', $listfinal1);

                                    if(!in_array(26, $category)){
                                     $category_url =  $this->common->clean($listFinal);
                                   }else if($arturl[0]['art_skill'] && $arturl[0]['other_skill']){

                                    $trimdata = $this->common->clean($listFinal) .'-'.$this->common->clean($art_othercategory);
                                    $category_url = trim($trimdata, '-');
                                   }
                                   else{
                                     $category_url = $this->common->clean($art_othercategory);  
                                  }

                                   $city_get =  $this->common->clean($city_url);

                 $url_post_id = $arturl[0]['slug'] .'-' . $category_url . '-'. $city_get.'-'.$arturl[0]['art_id'];


              $contition_array = array('user_id' => $art_data[0]['user_id'], 'status' => '1');
              $arturl = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_city,art_skill,other_skill,slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

               $city_url = $this->db->select('city_name')->get_where('cities', array('city_id' => $arturl[0]['art_city'], 'status' => '1'))->row()->city_name;

                $art_othercategory = $this->db->select('other_category')->get_where('art_other_category', array('other_category_id' => $arturl[0]['other_skill']))->row()->other_category;

                                    $category = $arturl[0]['art_skill'];
                                    $category = explode(',' , $category);

                                    foreach ($category as $catkey => $catval) {
                                       $art_category = $this->db->select('art_category')->get_where('art_category', array('category_id' => $catval))->row()->art_category;
                                       $categorylist[] = $art_category;
                                     } 

                                    $listfinal1 = array_diff($categorylist, array('other'));
                                    $listFinal = implode('-', $listfinal1);

                                    if(!in_array(26, $category)){
                                     $category_url =  $this->common->clean($listFinal);
                                   }else if($arturl[0]['art_skill'] && $arturl[0]['other_skill']){

                                    $trimdata = $this->common->clean($listFinal) .'-'.$this->common->clean($art_othercategory);
                                    $category_url = trim($trimdata, '-');
                                   }
                                   else{
                                     $category_url = $this->common->clean($art_othercategory);  
                                  }

                                   $city_get =  $this->common->clean($city_url);

                 $url_id = $arturl[0]['slug'] .'-' . $category_url . '-'. $city_get.'-'.$arturl[0]['art_id'];

                                        ?>
                                        <?php if ($art_data[0]['posted_user_id']) { ?>
                                            <a  class="post_dot" title="<?php echo ucwords($firstnameposted) . ' ' . ucwords($lastnameposted); ?>" href="<?php echo base_url('artist/dashboard/' . $url_post_id); ?>">

                                                <?php 

                                                 if (IMAGEPATHFROM == 'upload') {
                                                  if($userimageposted){
                                    if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $userimageposted)) { ?>
                                       
                                        <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="">
                                        
                                    <?php } else { ?>
                                        <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $userimageposted; ?>"  alt="">
                                   <?php } }else{?>
                                   <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="">
                               <?php } }else{

                      $filename = $this->config->item('art_profile_thumb_upload_path') . $userimageposted;
                      $s3 = new S3(awsAccessKey, awsSecretKey);
                     $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);

                                                if ($info) { ?>

                                                <img src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $userimageposted; ?>" name="image_src" id="image_src" />

                                              
                                <?php }else{?>

                                                  <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="">

                                                <?php } }?>

                                            </a>

                                        <?php } else { ?>
                                            <a class="post_dot"  href="<?php echo base_url('artist/dashboard/' . $url_id); ?>">

                                                <?php 
                                                 if (IMAGEPATHFROM == 'upload') {
                                                  if($userimageposted){
                                    if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $userimageposted)) { ?>
                                       
                                        <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="">
                                        
                                    <?php } else { ?>
                                        <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $userimageposted; ?>"  alt="">
                                   <?php } }else{?>
                                   <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="">
                               <?php } }else{

                      $filename = $this->config->item('art_profile_thumb_upload_path') . $art_userimage;
                      $s3 = new S3(awsAccessKey, awsSecretKey);
                     $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);

                                                if ($info) { ?>

                                                <img src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage; ?>" name="image_src" id="image_src" />
                                              
                                <?php }else{?>
                                                  <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="">
                                                <?php } }?>

                                               </a>

                                        <?php } ?>
                                    </div>
                                    <div class="post-design-name fl col-md-10">
                                        <ul>
                                            <?php
                                            $firstname = $this->db->get_where('art_reg', array('user_id' => $art_data[0]['user_id']))->row()->art_name;
                                            $lastname = $this->db->get_where('art_reg', array('user_id' => $art_data[0]['user_id']))->row()->art_lastname;

                                            $firstnameposted = $this->db->get_where('art_reg', array('user_id' => $art_data[0]['posted_user_id']))->row()->art_name;
                                            $lastnameposted = $this->db->get_where('art_reg', array('user_id' => $art_data[0]['posted_user_id']))->row()->art_lastname;

                                            $designation = $this->db->get_where('art_reg', array('user_id' => $row['user_id']))->row()->designation;
                                            
                                            $userskill = $this->db->get_where('art_reg', array('user_id' => $art_data[0]['user_id']))->row()->art_skill;
                                            $aud = $userskill;
                                            $aud_res = explode(',', $aud);
                                            foreach ($aud_res as $skill) {

                                                $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;
                                                $skill1[] = $cache_time;
                                            }
                                            $listFinal = implode(', ', $skill1);
                                            ?>

                                            <li><?php if ($art_data[0]['posted_user_id']) { ?>

                                                    <div class="else_post_d">
                                                        <a  class="post_dot" title="<?php echo ucwords($firstnameposted) . ' ' . ucwords($lastnameposted); ?>" href="<?php echo base_url('artist/dashboard/' . $url_post_id); ?>"><?php echo ucwords($firstnameposted) . ' ' . ucwords($lastnameposted); ?> </a>
                                                        <p class="posted_with" > Posted With </p><a class="post_dot"  href="<?php echo base_url('artist/dashboard/' . $url_id); ?>"><?php echo ucwords($firstname) . ' ' . ucwords($lastname); ?></a>
                                                        <span role="presentation" aria-hidden="true" style="color: #91949d; font-size: 14px;"> · </span>
                                                        <span class="ctre_date"> 
         <?php echo $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($row['created_date']))); ?>

                                                        </span>
                                                    </div>

                                                    <!-- other user post time name end-->
                                                <?php } else { ?>

                                                    <a  class="post_dot" title="<?php echo ucwords($firstname) . ' ' . ucwords($lastname); ?>"   href="<?php echo base_url('artist/dashboard/' . $url_id); ?>">
                                                        <?php echo ucwords($firstname) . ' ' . ucwords($lastname); ?>

                                                    </a>
                                                     <span role="presentation" aria-hidden="true"> · </span>
                                                    <div class="datespan">
                                                        <span class="ctre_date">
  <?php echo $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($art_data[0]['created_date']))); ?>
 </span></div>

                                                <?php } ?>                 </li>
                                           
                                            
                                            <li><div class="post-design-product">
                                                                <a><?php if($designation)
                                                                    {echo $designation;
                                                                    
                                                                    }else{
                                                                        echo "Current Work.";
                                                                       }?> </a>
                                                                
                                                            </div></li>

                                        </ul> 
                                    </div>  

                                    <div class="dropdown1">
                                        <a onClick="myFunctionone(<?php echo $art_data[0]['art_post_id']; ?>)" class="dropbtn1 dropbtn1 fa fa-ellipsis-v"></a>
                                        <div id="<?php echo "myDropdown" . $art_data[0]['art_post_id']; ?>" class="dropdown-content1">


                                            <?php
                                            if ($art_data[0]['posted_user_id'] != 0) {

                                                if ($this->session->userdata('aileenuser') == $art_data[0]['posted_user_id']) {
                                                    ?>
                                                    <a id="<?php echo $art_data[0]['art_post_id']; ?>" onClick="deleteownpostmodel(this.id)"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete Post</a>

                                                    <a id="<?php echo $art_data[0]['art_post_id']; ?>" onClick="editpost(this.id)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</a>

                                                <?php } else {
                                                    ?>
                                                    <a href="<?php echo base_url('artist/artistic_contactperson/' . $art_data[0]['user_id'] . ''); ?>"><i class="fa fa-user" aria-hidden="true"></i> Contact Person</a>

                                                    <?php
                                                }
                                            } else {
                                                ?>  



                                                <?php
                                                $userid = $this->session->userdata('aileenuser');
                                                if ($art_data[0]['user_id'] == $userid) {
                                                    ?>
                                                    <a id="<?php echo $art_data[0]['art_post_id']; ?>" onClick="deleteownpostmodel(this.id)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete Post</a>

                                                    <a id="<?php echo $art_data[0]['art_post_id']; ?>" onClick="editpost(this.id)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</a>
                                                <?php } else { ?>
                                                    

                                                    <a href="<?php echo base_url('artist/artistic_contactperson/' . $art_data[0]['user_id'] . ''); ?>"><i class="fa fa-user" aria-hidden="true"></i> Contact Person</a>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="post-design-desc">
                                        <span> 
                                            
                                             <div id="<?php echo 'editpostdata' . $art_data[0]['art_post_id']; ?>" style="display:block;">
                                                            <a class="ft-15 t_artd"><?php echo $this->common->make_links($art_data[0]['art_post']); ?></a>
                                                        </div>

                                                        <div id="<?php echo 'editpostbox' . $art_data[0]['art_post_id']; ?>" style="display:none; margin-bottom: 10px;">
                                                            <input type="text" class="my_text" id="<?php echo 'editpostname' . $art_data[0]['art_post_id']; ?>" name="editpostname" placeholder="Product name" value="<?php echo $art_data[0]['art_post']; ?>" onKeyDown=check_lengthedit(<?php echo $art_data[0]['art_post_id']; ?>); onKeyup=check_lengthedit(<?php echo $art_data[0]['art_post_id']; ?>); onblur=check_lengthedit(<?php echo $art_data[0]['art_post_id']; ?>);>


                            <?php 
                              if($art_data[0]['art_post']){ 
                                $counter = $art_data[0]['art_post'];
                                $a = strlen($counter);

                                ?>

                            <input size=1 id="text_num" tabindex="-500" class="text_num" value="<?php echo (50 - $a);?>" name=text_num readonly>

                           <?php }else{?>
                           <input size=1 id="text_num" class="text_num" tabindex="-500" value=50 name=text_num readonly> 

                            <?php }?>

                                                        </div>
                                            
                                            <div class="margin_btm" id="<?php echo 'editpostdetails' . $art_data[0]['art_post_id']; ?>" style="display:block;"><span class="show">
                                                    <?php print $this->common->make_links($art_data[0]['art_description']); ?></span>
                                            </div>
                                            <div id="<?php echo 'editpostdetailbox' . $art_data[0]['art_post_id']; ?>" style="display:none;">
                                                <div palceholder ="Description" contenteditable="true" id="<?php echo 'editpostdesc' . $art_data[0]['art_post_id']; ?>" name="editpostdesc" class="editable_text" onpaste="OnPaste_StripFormatting(this, event);"><?php echo $art_data[0]['art_description']; ?>
                                                </div> 
                                            </div>
                                            <button class="fr" id="<?php echo "editpostsubmit" . $art_data[0]['art_post_id']; ?>" style="display:none; " onClick="edit_postinsert(<?php echo $art_data[0]['art_post_id']; ?>)">Save</button>

                                        </span>
                                    </div> 
                                </div>
                                <div class="post-design-mid col-md-12" >  
                                    <!-- 13-4 multiple image code  start-->
                                    <!-- multiple image code  start-->
                                    <!-- done  start-->

                                    
                                        <?php
                                        $contition_array = array('post_id' => $art_data[0]['art_post_id'], 'is_deleted' => '1', 'insert_profile' => '1');
                                        $artmultiimage = $this->data['artmultiimage'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                        ?>

                                        <?php
                                        $i = 1;
                                        foreach ($artmultiimage as $data) {


                                            $allowed = array('gif', 'png', 'jpg');
                                            $allowespdf = array('pdf');
                                            $allowesvideo = array('mp4', '3gp');
                                            $allowesaudio = array('mp3');
                                            $filename = $data['file_name'];
                                            $ext = pathinfo($filename, PATHINFO_EXTENSION);

                                            if (in_array($ext, $allowed)) {
                                                ?>

                                                <div class="one-image">
                                                
                                                    <img src = "<?php echo  ART_POST_MAIN_UPLOAD_URL.$data['file_name'];?>" onclick="openModal();
                                                            currentSlide(<?php echo $i; ?>)" class="hover-shadow cursor">

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

                                    <!-- silder start -->
                                    <div id="myModal1" class="modal2">
                                     
                                        <div class="modal-content2">
                                           <span class="close2 cursor" onclick="closeModal()">&times;</span>
                                            <!--  multiple image start -->
                                            <?php
                                            $i = 1;
                                            $allowed = array('gif', 'png', 'jpg');
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
                                                        <img src = "<?php echo  ART_POST_MAIN_UPLOAD_URL.$artdata['file_name'];?>">
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

//                                                                               
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
                                                                            echo count($commnetcount); ?>
                                                                             
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
                                                                            echo count($likecount); ?>
                                                                   </span> 
                                                                    <span> Like</span>
                                                                <?php   }
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
                                                            <div class="likeduserlistimg<?php echo $artdata['post_files_id']; ?>">
                                                                <?php
                                                                $contition_array = array('post_image_id' => $artdata['post_files_id'], 'is_unlike' => '0');
                                                                $commnetcount = $this->common->select_data_by_condition('art_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                                // echo '<pre>'; print_r($commnetcount);
                                                                foreach ($commnetcount as $comment) {
                                                                    $art_fname1 = $this->db->get_where('art_reg', array('user_id' => $comment['user_id'], 'status' => '1'))->row()->art_name;
                                                                    $art_lname1 = $this->db->get_where('art_reg', array('user_id' => $comment['user_id'], 'status' => '1'))->row()->art_lastname;
                                                                    ?>
                                                                <?php } ?>
                                                                <!-- pop up box end-->
                                                                <a href="javascript:void(0);"  onclick="likeuserlistimg(<?php echo $artdata['post_files_id']; ?>);">
                                                                    <?php
                                                                    $contition_array = array('post_image_id' => $artdata['post_files_id'], 'is_unlike' => '0');
                                                                    $commnetcount = $this->common->select_data_by_condition('art_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


                                                                    $art_fname = $this->db->get_where('art_reg', array('user_id' => $commnetcount[0]['user_id'], 'status' => '1'))->row()->art_name;
                                                                    $art_lname = $this->db->get_where('art_reg', array('user_id' => $commnetcount[0]['user_id'], 'status' => '1'))->row()->art_lastname;
                                                                    ?>
                                                                    <div class="like_one_other" >
                                                                        <?php 
                                                                        if ($userid == $commnetcount[0]['user_id']) {
                                                                            echo "You";
                                                                        } else {
                                                                            echo ucwords($art_fname);
                                                                            echo "&nbsp;";
                                                                            echo ucwords($art_lname);
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
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                        <div class="<?php echo "likeusernameimg" . $artdata['post_files_id']; ?>" id="<?php echo "likeusernameimg" . $artdata['post_files_id']; ?>" style="display:none">
                                                            <?php
                                                            $contition_array = array('post_image_id' => $artdata['post_files_id'], 'is_unlike' => '0');
                                                            $commnetcount = $this->common->select_data_by_condition('art_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                           
                                                            foreach ($commnetcount as $comment) {
                                                                $art_fname1 = $this->db->get_where('art_reg', array('user_id' => $comment['user_id'], 'status' => '1'))->row()->art_name;
                                                                $art_lname1 = $this->db->get_where('art_reg', array('user_id' => $comment['user_id'], 'status' => '1'))->row()->art_lastname;
                                                                ?>
                                                            <?php } ?>
                                                            <!-- pop up box end-->
                                                            <a href="javascript:void(0);"  onclick="likeuserlistimg(<?php echo $artdata['post_files_id']; ?>);">
                                                                <?php
                                                                $contition_array = array('post_image_id' => $artdata['post_files_id'], 'is_unlike' => '0');
                                                                $commnetcount = $this->common->select_data_by_condition('art_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


                                                                $art_fname = $this->db->get_where('art_reg', array('user_id' => $commnetcount[0]['user_id'], 'status' => '1'))->row()->art_name;
                                                                $art_lname = $this->db->get_where('art_reg', array('user_id' => $commnetcount[0]['user_id'], 'status' => '1'))->row()->art_lastname;
                                                                ?>
                                                                <div class="like_one_other" >
                                                                    <?php
                                                                    if ($userid == $commnetcount[0]['user_id']) {
                                                                        echo "You";
                                                                    } else {
                                                                        echo ucwords($art_fname);
                                                                        echo "&nbsp;";
                                                                        echo ucwords($art_lname);
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
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <!-- like user list end -->



                                                        <div class="art-all-comment col-md-12">
                                                            <!-- 18-4 all comment start-->
                                                            <div id="<?php echo "fourcommentimg" . $artdata['post_files_id']; ?>" style="display:none">
                                                            </div>

                                                            <!-- khyati changes start -->

            <div  id="<?php echo "threecommentimg" . $artdata['post_files_id']; ?>" style="display:block">
                <div class="<?php echo 'insertcommentimg' . $artdata['post_files_id']; ?>">
                <?php
                    $contition_array = array('post_image_id' => $artdata['post_files_id'], 'is_delete' => '0');
                    $artmulimage = $this->common->select_data_by_condition('art_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');
                                if ($artmulimage) {
                                            foreach ($artmulimage as $rowdata) {
                                              $firstname = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->art_name;

                                              $lastname = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->art_lastname;
                        ?>
                            <div class="all-comment-comment-box">
                                <div class="post-design-pro-comment-img"> 
                                    <?php
                                        $art_userimage = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id'], 'status' => '1'))->row()->art_user_image;


              $contition_array = array('user_id' => $rowdata['user_id'], 'status' => '1');
              $arturl = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_city,art_skill,other_skill,slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

               $city_url = $this->db->select('city_name')->get_where('cities', array('city_id' => $arturl[0]['art_city'], 'status' => '1'))->row()->city_name;

                $art_othercategory = $this->db->select('other_category')->get_where('art_other_category', array('other_category_id' => $arturl[0]['other_skill']))->row()->other_category;

                                    $category = $arturl[0]['art_skill'];
                                    $category = explode(',' , $category);

                                    foreach ($category as $catkey => $catval) {
                                       $art_category = $this->db->select('art_category')->get_where('art_category', array('category_id' => $catval))->row()->art_category;
                                       $categorylist[] = $art_category;
                                     } 

                                    $listfinal1 = array_diff($categorylist, array('other'));
                                    $listFinal = implode('-', $listfinal1);

                                    if(!in_array(26, $category)){
                                     $category_url =  $this->common->clean($listFinal);
                                   }else if($arturl[0]['art_skill'] && $arturl[0]['other_skill']){

                                    $trimdata = $this->common->clean($listFinal) .'-'.$this->common->clean($art_othercategory);
                                    $category_url = trim($trimdata, '-');
                                   }
                                   else{
                                     $category_url = $this->common->clean($art_othercategory);  
                                  }

                                   $city_get =  $this->common->clean($city_url);


                 $url_id = $arturl[0]['slug'] .'-' . $category_url . '-'. $city_get.'-'.$arturl[0]['art_id'];

                ?>

                          <?php 

                          if (IMAGEPATHFROM == 'upload') { 
                                          if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {  ?>
                                       
                                        <a class="post_dot" title="<?php echo ucfirst(strtolower($firstname)) . ' ' . ucfirst(strtolower($lastname)); ?>" href="<?php echo base_url('artist/dashboard/' . $url_id); ?>">
                                        <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="">
                                      </a>
                                        
                                    <?php } else { ?>
                                     <a class="post_dot" title="<?php echo ucfirst(strtolower($firstname)) . ' ' . ucfirst(strtolower($lastname)); ?>" href="<?php echo base_url('artist/dashboard/' . $url_id); ?>">
                                        <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage; ?>"  alt="">
                                      </a>
                                   <?php }
                                } else{ 

                            $filename = $this->config->item('art_profile_thumb_upload_path') . $art_userimage;
                            $s3 = new S3(awsAccessKey, awsSecretKey);
                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                            if ($info) { ?>

                                                 <a class="post_dot" title="<?php echo ucfirst(strtolower($firstname)) . ' ' . ucfirst(strtolower($lastname)); ?>" href="<?php echo base_url('artist/dashboard/' . $url_id); ?>">

                                                <img src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage; ?>" name="image_src" id="image_src" />
                                              </a>
                          <?php }else{?>

                          <a class="post_dot" title="<?php echo ucfirst(strtolower($firstname)) . ' ' . ucfirst(strtolower($lastname)); ?>" href="<?php echo base_url('artist/dashboard/' . $url_id); ?>">

                         <img src="<?php echo base_url(NOARTIMAGE); ?>" alt="<?php echo ucfirst(strtolower($firstname)) . ' ' . ucfirst(strtolower($lastname)); ?>">  

                          </a>

                          <?php } }?>


                             

                                    </div>
                            <div class="comment-name">
                            <b> 
                                <a class="post_dot" title="<?php echo ucfirst(strtolower($firstname)) . ' ' . ucfirst(strtolower($lastname)); ?>" href="<?php echo base_url('artist/dashboard/' . $url_id); ?>">

                             <?php
                                 echo ucfirst(strtolower($firstname)).' '. ucfirst(strtolower($lastname));
                                  echo '</br>'; ?>

                              </a>
                            </b>
                            </div>

                            <div class="comment-details" id= "<?php echo "showcommentimg" . $rowdata['post_image_comment_id']; ?>">
                                <?php
                                    echo $this->common->make_links($rowdata['comment']);
                                    echo '</br>';
                                ?>
                            </div>

                        <div class="edit-comment-box">
                        <div class="inputtype-edit-comment">
                        <div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="<?php echo $rowdata['post_image_comment_id']; ?>"  id="editcommentimg<?php echo $rowdata['post_image_comment_id']; ?>" placeholder="Enter Your Comment " value= ""  onkeyup="commenteditimg(<?php echo $rowdata['post_image_comment_id']; ?>)" onpaste="OnPaste_StripFormatting(this, event);"><?php echo $rowdata['comment']; ?></div>
                        <span class="comment-edit-button"><button id="<?php echo "editsubmitimg" . $rowdata['post_image_comment_id']; ?>" style="display:none" onClick="edit_commentimg(<?php echo $rowdata['post_image_comment_id']; ?>)">Save</button></span>
                        </div></div>

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
                                                                                                <a id="<?php echo $rowdata['post_image_comment_id']; ?>" onClick="comment_editboximg(this.id)" class="editbox">Edit
                                                                                                </a>
                                                                                            </div>
                                                                                            <div id="<?php echo 'editcancleimg' . $rowdata['post_image_comment_id']; ?>" style="display:none;">
                                                                                                <a id="<?php echo $rowdata['post_image_comment_id']; ?>" onClick="comment_editcancleimg(this.id)">Cancel
                                                                                                </a>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php } ?>

                                                                                    <?php
                                                                                    $userid = $this->session->userdata('aileenuser');

                                                                                    $business_userid = $this->db->get_where('art_post', array('art_post_id' => $rowdata['post_image_id'], 'status' => 1))->row()->user_id;


                                                                                    if ($rowdata['user_id'] == $userid || $business_userid == $userid) {
                                                                                        ?> 
                                                                                        <span role="presentation" aria-hidden="true"> · </span>
                                                                                        <div class="comment-details-menu">
                                                                                            <input type="hidden" name="post_deleteimg"  id="post_deleteimg<?php echo $rowdata['post_image_comment_id']; ?>" value= "<?php echo $rowdata['post_image_id']; ?>">
                                                                                            <a id="<?php echo $rowdata['post_image_comment_id']; ?>"   onClick="comment_deleteimg(this.id)"> Delete<span class="<?php echo 'insertcommentimg' . $rowdata['post_image_comment_id']; ?>">
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

                                                        
                                                        <div class="post-design-commnet-box col-md-12">
                                                            <?php
                                                            $userid = $this->session->userdata('aileenuser');
                                                            $art_userimage = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => '1'))->row()->art_user_image;
                                                            ?>
                                                            <div class="post-design-proo-img">

                                                                 <?php 

                                if (IMAGEPATHFROM == 'upload') {
                                                  if($art_userimage){
                                    if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) { ?>
                                       
                                        <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="">
                                        
                                    <?php } else { ?>
                                        <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage; ?>"  alt="">
                                   <?php } }else{?>
                                   <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="">
                               <?php } }else{

                      $filename = $this->config->item('art_profile_thumb_upload_path') . $art_userimage;
                      $s3 = new S3(awsAccessKey, awsSecretKey);
                     $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);

                                                if ($info) { ?>

                                                <img src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage; ?>" name="image_src" id="image_src" />
                                              
                                <?php }else{?>
                                                  <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="">

                                                <?php } }?>  
                                                            </div>
                                                            <div class="">
                                                                <div id="content" class="col-md-12 inputtype-comment cmy_2" >
                                                                    <div contenteditable="true"  class="editable_text edt_2" name="<?php echo $artdata['post_files_id']; ?>"  id="<?php echo "post_commentimg" . $artdata['post_files_id']; ?>" placeholder="Add a Comment ..." onclick="entercommentimg(<?php echo $artdata['post_files_id']; ?>)" onpaste="OnPaste_StripFormatting(this, event);" ></div>
                                                                </div>
                                                                <?php echo form_error('post_commentimg'); ?>
                                                                <div class="comment-edit-butn">   
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

                                            <a class="prev" style="left: 0;" onclick="plusSlides(-1)">&#10094;</a>
                                            <a class="next" style="right:  0;" onclick="plusSlides(1)">&#10095;</a>
                                            <div class="caption-container">
                                                <p id="caption"></p>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- slider end -->
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
                                                                            echo count($commnetcount); ?>
                                                                             
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
                                                                            echo $art_data[0]['art_likes_count']; ?>
                                                                   </span> 
                                                                    <span> Like</span>
                                                                <?php   }
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
                                            $art_fname1 = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => '1'))->row()->art_name;
                                            $art_lname1 = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => '1'))->row()->art_lastname;
                                            ?>
                                        <?php } ?>
                                        <!-- pop up box end-->
                                        <a href="javascript:void(0);"  onclick="likeuserlist(<?php echo $row['art_post_id']; ?>);">
                                            <?php
                                            $contition_array = array('art_post_id' => $art_data[0]['art_post_id'], 'status' => '1', 'is_delete' => '0');
                                            $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                            $likeuser = $commnetcount[0]['art_like_user'];
                                            $countlike = $commnetcount[0]['art_likes_count'] - 1;

                                            $likelistarray = explode(',', $likeuser);
                                            $likelistarray = array_reverse($likelistarray);
                                            $art_fname = $this->db->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => '1'))->row()->art_name;
                                            $art_lname = $this->db->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => '1'))->row()->art_lastname;
                                            ?>
                                            <div class="like_one_other">
                                                <?php 
                                                if ($userid == $likelistarray[0]) {
                                                    echo "You";
                                                } else {
                                                    echo ucwords($art_fname);
                                                    echo "&nbsp;";
                                                    echo ucwords($art_lname);
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
                                            </div>
                                        </a>
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
                                        $art_fname1 = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => '1'))->row()->art_name;
                                        $art_lname1 = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => '1'))->row()->art_lastname;
                                        ?>
                                    <?php } ?>
                                    <!-- pop up box end-->
                                    <a href="javascript:void(0);"  onclick="likeuserlist(<?php echo $art_data[0]['art_post_id']; ?>);">
                                        <?php
                                        $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1', 'is_delete' => '0');
                                        $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                        $likeuser = $commnetcount[0]['art_like_user'];
                                        $countlike = $commnetcount[0]['art_likes_count'] - 1;

                                        $likelistarray = explode(',', $likeuser);
                                        $art_fname = $this->db->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => '1'))->row()->art_name;
                                        $art_lname = $this->db->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => '1'))->row()->art_lastname;
                                        ?>
                                        <div class="like_one_other">
                                            <?php
                                            echo ucwords($art_fname);
                                            echo "&nbsp;";
                                            echo ucwords($art_lname);
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
                                        </div>
                                    </a>
                                </div>
                                <!-- like user list end -->
                                <!-- 8-5 comment start -->
                                <div class="art-all-comment col-md-12">
                                    <!-- 18-4 all comment start-->
                                    <div id="<?php echo "fourcomment" . $art_data[0]['art_post_id']; ?>" style="display:none">
                                    </div>

                                    <!-- khyati changes start -->

                                    <div  id="<?php echo "threecomment" . $art_data[0]['art_post_id']; ?>" style="display:block">
                                        <div class="<?php echo 'insertcomment' . $art_data[0]['art_post_id']; ?>">
                                            <?php
                                            $contition_array = array('art_post_id' => $art_data[0]['art_post_id'], 'status' => '1');
                                            $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = 'artistic_post_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');

                                            if ($artdata) {
                                                foreach ($artdata as $rowdata) {
                                                    $artname = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->art_name;
                                                    $artlastname = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->art_lastname;
                                                    ?>
                                                    <div class="all-comment-comment-box">
                                                        <div class="post-design-pro-comment-img"> 
                                                            <?php
                                                            $art_userimage = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id'], 'status' => '1'))->row()->art_user_image;
                                                            ?>

                                            <?php 

                                if (IMAGEPATHFROM == 'upload') {
                                                  if($art_userimage){
                                    if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) { ?>
                                       
                                        <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="">
                                        
                                    <?php } else { ?>
                                        <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage; ?>"  alt="">
                                   <?php } }else{?>
                                   <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="">
                               <?php } }else{

                      $filename = $this->config->item('art_profile_thumb_upload_path') . $art_userimage;
                      $s3 = new S3(awsAccessKey, awsSecretKey);
                     $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);

                                                if ($info) { ?>

                                                <img src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage; ?>" name="image_src" id="image_src" />
                                              
                                <?php }else{?>
                                                  <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="">

                                                <?php } }?>                                                          
                                                        </div>
                                                        <div class="comment-name">
                                                            <b title=" <?php
                                                            echo ucwords($artname);
                                                            echo "&nbsp;";
                                                            echo ucwords($artlastname);
                                                            ?>">
                                                                   <?php
                                                                   echo ucwords($artname);
                                                                   echo "&nbsp;";
                                                                   echo ucwords($artlastname);
                                                                   ?></b><?php echo '</br>'; ?></div>

                                                        <div class="comment-details" id= "<?php echo "showcomment" . $rowdata['artistic_post_comment_id']; ?>">
                                                            <?php
                                                            echo $this->common->make_links($rowdata['comments']);
                                                            ?>
                                                        </div>
                                                       
                                                        <div class="edit-comment-box">
                                                            <div class="inputtype-edit-comment">
                                                                <div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="<?php echo $rowdata['artistic_post_comment_id']; ?>"  id="editcomment<?php echo $rowdata['artistic_post_comment_id']; ?>" placeholder="Enter Your Comment " value= ""  onkeyup="commentedit(<?php echo $rowdata['artistic_post_comment_id']; ?>)" onpaste="OnPaste_StripFormatting(this, event);"><?php echo $rowdata['comments']; ?></div>
                                                                <span class="comment-edit-button"><button id="<?php echo "editsubmit" . $rowdata['artistic_post_comment_id']; ?>" style="display:none" onClick="edit_comment(<?php echo $rowdata['artistic_post_comment_id']; ?>)">Save</button></span>
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
                                                                        <a id="<?php echo $rowdata['artistic_post_comment_id']; ?>" onClick="comment_editbox(this.id)" class="editbox">Edit
                                                                        </a>
                                                                    </div>
                                                                    <div id="<?php echo 'editcancle' . $rowdata['artistic_post_comment_id']; ?>" style="display:none;">
                                                                        <a id="<?php echo $rowdata['artistic_post_comment_id']; ?>" onClick="comment_editcancle(this.id)">Cancel
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>

                                                            <?php
                                                            $userid = $this->session->userdata('aileenuser');

                                                            $art_userid = $this->db->get_where('art_post', array('art_post_id' => $rowdata['art_post_id'], 'status' => '1'))->row()->user_id;


                                                            if ($rowdata['user_id'] == $userid || $art_userid == $userid) {
                                                                ?> 
                                                                <span role="presentation" aria-hidden="true"> · </span>
                                                                <div class="comment-details-menu">
                                                                    <input type="hidden" name="post_delete"  id="<?php echo 'post_delete' . $rowdata['artistic_post_comment_id']; ?>" value= "<?php echo $rowdata['art_post_id']; ?>">
                                                                    <a id="<?php echo $rowdata['artistic_post_comment_id']; ?>"   onClick="comment_delete(this.id)"> Delete<span class="<?php echo 'insertcomment' . $rowdata['artistic_post_comment_id']; ?>">
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
                                <div class="post-design-commnet-box col-md-12">
                                    <?php
                                    $userid = $this->session->userdata('aileenuser');
                                    $art_userimage = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => '1'))->row()->art_user_image;
                                    ?>
                                    <div class="post-design-proo-img">

                                         <?php 

                                if (IMAGEPATHFROM == 'upload') {
                                                  if($art_userimage){
                                    if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) { ?>
                                       
                                        <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="">
                                        
                                    <?php } else { ?>
                                        <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage; ?>"  alt="">
                                   <?php } }else{?>
                                   <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="">
                               <?php } }else{

                      $filename = $this->config->item('art_profile_thumb_upload_path') . $art_userimage;
                      $s3 = new S3(awsAccessKey, awsSecretKey);
                     $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);

                                                if ($info) { ?>

                                                <img src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage; ?>" name="image_src" id="image_src" />
                                              
                                <?php }else{?>
                                                  <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="">

                                                <?php } }?>
                                       
                                    </div>
                                    <div class="">
                                        <div id="content" class="col-md-12 inputtype-comment cmy_2" >
                                            <div contenteditable="true"  class="editable_text edt_2" name="<?php echo $art_data[0]['art_post_id']; ?>"  id="<?php echo "post_comment" . $art_data[0]['art_post_id']; ?>" placeholder="Add a Comment ..." onClick="entercomment(<?php echo $art_data[0]['art_post_id']; ?>)" onpaste="OnPaste_StripFormatting(this, event);" ></div>
                                        </div>
                                        <?php echo form_error('post_comment'); ?>
                                        <div class=" comment-edit-butn">   
                                            <button id="<?php echo $art_data[0]['art_post_id']; ?>" onClick="insert_comment(this.id)">Comment</button> 
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
         
                    </body>
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
                    <!-- Model Popup Close -->

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

            
                    </html>
                    
                    
                    
   <?php if(IS_NOT_JS_MINIFY == '0'){ ?>                  
                    
  <script src="<?php echo base_url('assets/js/jquery.jMosaic.js'); ?>"></script>                
  <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.js'); ?>"></script>
<?php }else{?>

 <script src="<?php echo base_url('assets/js_min/jquery.jMosaic.js'); ?>"></script>                
  <script src="<?php echo base_url('assets/js_min/bootstrap.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js') ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.js'); ?>"></script>

<?php }?>
<script>
var base_url = '<?php echo base_url(); ?>';   
var data = <?php echo json_encode($demo); ?>;
var data1 = <?php echo json_encode($de); ?>;
var count = '<?php echo $count; ?>';                                       
</script>

 <?php if(IS_NOT_JS_MINIFY == '0'){ ?>  
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/art_image_notification.js?ver='.time()); ?>"></script>  
<?php }else{?>

<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/artist/art_image_notification.js?ver='.time()); ?>"></script> 
<?php }?>