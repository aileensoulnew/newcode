<!-- start head -->

<?php echo $head; ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/profiles/business/business.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/gyc.css'); ?>">
   <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/profiles/common/mobile.css') ;?>" />

<!--post save success pop up style strat -->

<!--post save success pop up style strat -->

<!--post save success pop up style end -->

<!-- start header -->
<?php echo $header; ?>
<script src="<?php echo base_url('js/fb_login.js'); ?>">
</script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('dragdrop/fileinput.css'); ?>">
<link href="<?php echo base_url('dragdrop/themes/explorer/theme.css'); ?>" media="all" rel="stylesheet" type="text/css"/>

<script src="<?php echo base_url('dragdrop/js/plugins/sortable.js'); ?>"></script>
<script src="<?php echo base_url('dragdrop/js/fileinput.js'); ?>"></script>
<script src="<?php echo base_url('dragdrop/js/locales/fr.js'); ?>"></script>
<script src="<?php echo base_url('dragdrop/js/locales/es.js'); ?>"></script>
<script src="<?php echo base_url('dragdrop/themes/explorer/theme.js'); ?>"></script>



<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/video.css'); ?>">
<script src="<?php echo base_url('js/mediaelement-and-player.min.js'); ?>"></script>
<!-- script for cropiee immage End-->
<link rel="stylesheet" href="<?php echo base_url('assets/css/croppie.css'); ?>">

<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" /> -->

<!-- END HEADER -->

<?php echo $business_header2 ?>

<link rel="stylesheet" href="<?php echo base_url() ?>css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/3.3.0/select2.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/timeline.css'); ?>"> 
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/1.10.3.jquery-ui.css'); ?>">

<!-- END HEAD -->



<body   class="page-container-bg-solid page-boxed">

    <section>
        <!-- coer image start-->
        <div class="container" id="paddingtop_fixed">

            <div class="row" id="row1" style="display:none;">
                <div class="col-md-12 text-center">
                    <div id="upload-demo" ></div>
                </div>
                <div class="col-md-12 cover-pic" >
                    <button class="btn btn-success  cancel-result" onclick="">Cancel</button>

                    <button class="btn btn-success upload-result fr" onclick="myFunction()">Save</button>

                    <div id="message1" style="display:none;">
                        <div class="loader">
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
                </div>
                <div class="col-md-12"  style="visibility: hidden; ">
                    <div id="upload-demo-i"></div>
                </div>
            </div>




            <div class="container">
                <div class="row" id="row2">
                    <?php
                    $userid = $this->session->userdata('aileenuser');
                    if ($this->uri->segment(3) == $userid) {
                        $user_id = $userid;
                    } elseif ($this->uri->segment(3) == "") {
                        $user_id = $userid;
                    } else {
                        $user_id = $this->db->get_where('business_profile', array('business_slug' => $this->uri->segment(3)))->row()->user_id;
                    }
                    $contition_array = array('user_id' => $user_id, 'is_deleted' => '0', 'status' => '1');
                    $image = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'profile_background', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $image_ori = $image[0]['profile_background'];
                    if ($image_ori) {
                        ?>
                        <div class="bg-images">
                            <img src="<?php echo base_url($this->config->item('bus_bg_main_upload_path') . $image_ori); ?>" name="image_src" id="image_src" / ></div>
                        <?php
                    } else {
                        ?>
                        <div class="bg-images">
                            <img src="<?php echo base_url(WHITEIMAGE); ?>" name="image_src" id="image_src" / ></div>
                         <?php }
                         ?>


                </div>
            </div>
        </div>

        <div class="container">
            <?php
            $userid = $this->session->userdata('aileenuser');
            if ($businessdata1[0]['user_id'] == $userid) {
                ?>

                <div class="upload-img">


                    <label class="cameraButton"> <span class="tooltiptext">Upload Cover Photo</span><i class="fa fa-camera" aria-hidden="true"></i>
                        <input type="file" id="upload" name="upload" accept="image/*;capture=camera" onclick="showDiv()">
                    </label>
                </div>

            <?php } ?>
            <!-- coer image end-->

            <div class="profile-photo">
                <div class="buisness-menu">
                    <div class="profile-pho-bui">

                        <div class="user-pic">
                            <?php if ($businessdata1[0]['business_user_image'] != '') { ?>
                                <img src="<?php echo base_url($this->config->item('bus_profile_thumb_upload_path') . $businessdata1[0]['business_user_image']); ?>" alt="" >
                            <?php } else { ?>
                                <img alt="" class="img-circle" src="<?php echo base_url(NOIMAGE); ?>" alt="" />
                            <?php } ?>

                            <?php
                            $userid = $this->session->userdata('aileenuser');
                            if ($businessdata1[0]['user_id'] == $userid) {
                                ?>                                                                                                                        <!-- <a href="#popup-form" class="fancybox"><i class="fa fa-camera" aria-hidden="true"></i> Update Profile Picture</a> -->

                                <a href="javascript:void(0);" onclick="updateprofilepopup();"><i class="fa fa-camera" aria-hidden="true"></i> Update Profile Picture</a>

                            <?php } ?>
                        </div>

                        <!-- <div id="popup-form">
                        <?php echo form_open_multipart(base_url('business_profile/user_image_insert'), array('id' => 'userimage', 'name' => 'userimage', 'class' => 'clearfix')); ?>
                        <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="profilepic">
                        <input type="hidden" name="hitext" id="hitext" value="5">
                        <input type="submit" name="cancel5" id="cancel5" value="Cancel">
                        <input type="submit" name="profilepicsubmit" id="profilepicsubmit" value="Save">
                        <?php echo form_close(); ?>
                </div> -->

                    </div>

                    <div class="bui-menu-profile col-md-10">



                        <h4 class="profile-head-text"><a href="<?php echo base_url('business-profile/details/' . $businessdata1[0]['business_slug'] . ''); ?>"> <?php echo ucwords($businessdata1[0]['company_name']); ?></a></h4>

                        <h4 class="profile-head-text_dg"><a href="<?php echo base_url('business-profile/details/' . $businessdata1[0]['business_slug'] . ''); ?>"> 


                                <?php
                                if ($businessdata1[0]['industriyal']) {
                                    echo
                                    $this->db->get_where('industry_type', array('industry_id' => $businessdata1[0]['industriyal']))->row()->industry_name;
                                }
                                if ($businessdata1[0]['other_industrial']) {
                                    echo ucwords($businessdata1[0]['other_industrial']);
                                }
                                ?>


                            </a></h4>

                        <?php
                        $userid = $this->session->userdata('aileenuser');
                        if ($businessdata1[0]['user_id'] != $userid) {
                            ?>
                            <!--   <div class="msg_flw_btn_2">
                                  <div  class="fr msg_flw_btn">
        
                                      <div class="<?php echo "fr" . $businessdata1[0]['business_profile_id']; ?>">
        
                            <?php
                            $userid = $this->session->userdata('aileenuser');

                            $contition_array = array('user_id' => $userid, 'status' => '1');

                            $bup_id = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                            $status = $this->db->get_where('follow', array('follow_type' => 2, 'follow_from' => $bup_id[0]['business_profile_id'], 'follow_to' => $businessdata1[0]['business_profile_id']))->row()->follow_status;
                            //echo "<pre>"; print_r($status); die();

                            if ($status == 0 || $status == " ") {
                                ?>
                                                                                                                                                                                  <div class="msg_flw_btn_1" id= "followdiv">
                                                                                                                                                                                      <button  id="<?php echo "follow" . $businessdata1[0]['business_profile_id']; ?>" onClick="followuser(<?php echo $businessdata1[0]['business_profile_id']; ?>)">Follow</button>
                                                                                                                                                                                  </div>
                            <?php } elseif ($status == 1) { ?>
                                                                                                                                                                                  <div class="msg_flw_btn_1" id= "unfollowdiv">
                                                                                                                                                                                      <button id="<?php echo "unfollow" . $businessdata1[0]['business_profile_id']; ?>" onClick="unfollowuser(<?php echo $businessdata1[0]['business_profile_id']; ?>)">Following </button>
                                                                                                                                                                                  </div>
                            <?php } ?>
                                      </div> 
                                      <a href="<?php echo base_url('chat/abc/' . $businessdata1[0]['user_id']); ?>">Message</a>
                                  </div>
        
        
        
        
                              </div> -->
                        <?php } ?>
                    </div>
                    <!-- PICKUP -->
                    <!-- menubar --><div class="business-data-menu  col-md-12 padding_less_right ">

                        <div class="left-side-menu col-md-1">   </div>

                        <div class="profile-main-box-buis-menu  col-md-7">  
                            <ul class="">



                                <li <?php if ($this->uri->segment(1) == 'business_profile' && $this->uri->segment(2) == 'business_profile_manage_post') { ?> class="active" <?php } ?>><a title="Dashboard" href="<?php echo base_url('business_profile/business_profile_manage_post/' . $businessdata1[0]['business_slug']); ?>">Dashboard</a>
                                </li>

                                <li <?php if ($this->uri->segment(1) == 'business_profile' && $this->uri->segment(2) == 'business_resume') { ?> class="active" <?php } ?>><a title="Details" href="<?php echo base_url('business-profile/details/' . $businessdata1[0]['business_slug']); ?>"> Details</a>
                                </li>

                                <?php
                                $userid = $this->session->userdata('aileenuser');
                                if ($businessdata1[0]['user_id'] == $userid) {
                                    ?> 
                                                                                                              <!--  <li <?php if ($this->uri->segment(1) == 'business_profile' && $this->uri->segment(2) == 'business_profile_save_post') { ?> class="active" <?php } ?>><a href="<?php echo base_url('business_profile/business_profile_save_post'); ?>">Saved Post</a>
                                                                                                                                                                                    </li> -->

                                    <li <?php if ($this->uri->segment(1) == 'business_profile' && $this->uri->segment(2) == 'userlist') { ?> class="active" <?php } ?>><a title="Userlist" href="<?php echo base_url('business_profile/userlist/' . $businessdata1[0]['business_slug']); ?>">Userlist</a>
                                    </li>


                                <?php } ?>

                                <?php
                                $userid = $this->session->userdata('aileenuser');
                                if ($businessdata1[0]['user_id'] == $userid) {
                                    ?> 


                                    <li <?php if ($this->uri->segment(1) == 'business_profile' && $this->uri->segment(2) == 'followers') { ?> class="active" <?php } ?>><a title="Followers" href="<?php echo base_url('business_profile/followers/' . $businessdata1[0]['business_slug']); ?>">Followers <br>  (<?php echo (count($businessfollowerdata)); ?>)</a>
                                    </li>


                                    <?php
                                } else {

                                    $businessregid = $businessdata1[0]['business_profile_id'];
                                    $contition_array = array('follow_to' => $businessregid, 'follow_status' => '1', 'follow_type' => '2');
                                    $followerotherdata = $this->data['followerotherdata'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                    ?> 
                                    <li <?php if ($this->uri->segment(1) == 'business_profile' && $this->uri->segment(2) == 'followers') { ?> class="active" <?php } ?>><a title="Followers" href="<?php echo base_url('business_profile/followers/' . $businessdata1[0]['business_slug']); ?>">Followers <br>  (<?php echo (count($followerotherdata)); ?>)</a>
                                    </li>

                                <?php } ?>

                                <?php
                                $userid = $this->session->userdata('aileenuser');
                                if ($businessdata1[0]['user_id'] == $userid) {
                                    ?>          
                                    <li <?php if ($this->uri->segment(1) == 'business_profile' && $this->uri->segment(2) == 'following') { ?> class="active" <?php } ?>><a title="Following" href="<?php echo base_url('business_profile/following/' . $businessdata1[0]['business_slug']); ?>">Following <br> (<?php echo (count($businessfollowingdata)); ?>)</a>
                                    </li>
                                    <?php
                                } else {
                                    $businessregid = $businessdata1[0]['business_profile_id'];
                                    $contition_array = array('follow_from' => $businessregid, 'follow_status' => '1', 'follow_type' => '2');
                                    $followerotherdata = $this->data['followerotherdata'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                    ?>
                                    <li <?php if ($this->uri->segment(1) == 'business_profile' && $this->uri->segment(2) == 'following') { ?> class="active" <?php } ?>><a title="Following" href="<?php echo base_url('business_profile/following/' . $businessdata1[0]['business_slug']); ?>">Following <br> (<?php echo (count($followerotherdata)); ?>)</a>
                                    </li>
                                <?php } ?>

                            </ul>

                        </div>

                        <?php
                        $userid = $this->session->userdata('aileenuser');

                        if ($businessdata1[0]['user_id'] != $userid) {
                            ?>
                            <div class="col-md-3 padding_les flw_with">
                                <div class="flw_msg_btn fr top_follow">
                                    <ul>
                                        <li>
                                            <div class="<?php echo "fr" . $businessdata1[0]['business_profile_id']; ?>">

                                                <?php
                                                $userid = $this->session->userdata('aileenuser');

                                                $contition_array = array('user_id' => $userid, 'status' => '1');

                                                $bup_id = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                                $status = $this->db->get_where('follow', array('follow_type' => 2, 'follow_from' => $bup_id[0]['business_profile_id'], 'follow_to' => $businessdata1[0]['business_profile_id']))->row()->follow_status;
                                                //echo "<pre>"; print_r($status); die();


                                                $logslug = $this->db->get_where('business_profile', array('user_id' => $userid))->row()->business_slug;
                                                if ($logslug != $this->uri->segment(3)) {
                                                    if ($status == 0 || $status == " ") {
                                                        ?>
                                                        <div class="msg_flw_btn_1" id= "followdiv">
                                                            <button id="<?php echo "follow" . $businessdata1[0]['business_profile_id']; ?>" onClick="followuser(<?php echo $businessdata1[0]['business_profile_id']; ?>)">Follow</button>
                                                        </div>
                                                    <?php } elseif ($status == 1) { ?>
                                                        <div class="msg_flw_btn_1" id= "unfollowdiv">
                                                            <button class="bg_following"  id="<?php echo "unfollow" . $businessdata1[0]['business_profile_id']; ?>" onClick="unfollowuser(<?php echo $businessdata1[0]['business_profile_id']; ?>)">Following </button>
                                                        </div>
                                                    <?php } ?>
                                                </div>         


                                            </li>

                                            <li>
                                                <a  href="<?php echo base_url('chat/abc/' . $businessdata1[0]['user_id']); ?>">Message</a></li>
                                        <?php } ?>

                                    </ul>   
                                </div>
                            </div>
                        <?php } ?>


                    </div>

                    <!-- pickup -->
                </div>
            </div>
        </div>
    </div>


</div>





<div class="user-midd-section">
    <div class="container">
        <div class="row">

            <!-- <div class="col-md-3">

<div  class="add-post-button">


<a class="btn btn-3 btn-3b" title="You Can Hire From Here"  href="<?php echo base_url('recruiter'); ?>"> <i class="fa fa-plus" aria-hidden="true"></i>  Recruitment </a>
</div>
                        
            
</div> -->



        </div>

    </div>
    <div class="user-midd-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="full-box-module business_data">
                        <div class="profile-boxProfileCard  module">

                            <div class="head_details1">
                                <span><a href="<?php echo base_url('business-profile/details/' . $businessdata1[0]['business_slug']); ?>"><h5><i class="fa fa-info-circle" aria-hidden="true"></i>Information</h5></a>
                                </span>      </div>
                            <table class="business_data_table">
                                <tr>
                                    <td class="business_data_td1"><i class="fa fa-user"></i></td>
                                    <td class="business_data_td2"><?php echo ucwords($businessdata1[0]['contact_person']); ?></td>
                                </tr>
                                <tr>
                                    <td class="business_data_td1"><i class="fa fa-mobile"></i></td>
                                    <td class="business_data_td2"><span><?php echo $businessdata1[0]['contact_mobile']; ?></span></td>
                                </tr>

                                <tr>
                                    <td class="business_data_td1"><i class="fa fa-envelope-o" aria-hidden="true"></i></td>
                                    <td class="business_data_td2"><span><?php echo $businessdata1[0]['contact_email']; ?></span></td>
                                </tr>


                                <tr>
                                    <td class="business_data_td1 detaile_map"><i class="fa fa-map-marker"></i></td>
                                    <td class="business_data_td2"><span>

                                            <?php
                                            if ($businessdata1[0]['address']) {
                                                echo $businessdata1[0]['address'];
                                                echo ",";
                                            }
                                            ?> 
                                            <?php
                                            if ($businessdata1[0]['city']) {
                                                echo $this->db->get_where('cities', array('city_id' => $businessdata1[0]['city']))->row()->city_name;
                                                echo",";
                                            }
                                            ?> 
                                            <?php
                                            if ($businessdata1[0]['country']) {
                                                echo $this->db->get_where('countries', array('country_id' => $businessdata1[0]['country']))->row()->country_name;
                                            }
                                            ?> 

                                        </span></td>
                                </tr>
                                <?php
                                if ($businessdata1[0]['contact_website']) {
                                    ?>
                                    <tr>
                                        <td class="business_data_td1"><i class="fa fa-globe"></i></td>
                                        <!--<td class="business_data_td2 website"><span><a target="_blank" href="https://<?php echo $businessdata1[0]['contact_website']; ?>"> <?php echo $this->common->make_links($businessdata1[0]['contact_website']); ?></a></span></td>-->
                                        <td class="business_data_td2 website"><span><a target="_blank" href="<?php echo $businessdata1[0]['contact_website']; ?>"> <?php echo $businessdata1[0]['contact_website']; ?></a></span></td>
                                    </tr>

                                <?php } ?>
                                <tr>
                                    <td class="business_data_td1 detaile_map"><i class="fa fa-suitcase"></i></td>
                                    <td class="business_data_td2"><span><?php echo $this->common->make_links($businessdata1[0]['details']); ?></span></td>
                                </tr>
                            </table>
                        </div>
                    </div>


                    <!-- user iamges start-->

                    <div class="full-box-module business_data">
                        <div class="profile-boxProfileCard  module buisness_he_module" >

                            <div class="head_details">
                                <a href="<?php echo base_url('business_profile/business_photos/' . $businessdata1[0]['business_slug']) ?>">   <h5><i class="fa fa-camera" aria-hidden="true"></i>   Photos</h5></a>
                            </div>

                            <?php
                            $contition_array = array('user_id' => $businessdata1[0]['user_id']);
                            $businessimage = $this->data['businessimage'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


                            foreach ($businessimage as $val) {



                                $contition_array = array('post_id' => $val['business_profile_post_id'], 'is_deleted' => '1', 'image_type' => '2');
                                $busmultiimage = $this->data['busmultiimage'] = $this->common->select_data_by_condition('post_image', $contition_array, $data = '*', $sortby = 'post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                $multipleimage[] = $busmultiimage;
                            }
                            ?>
                            <?php
                            $allowed = array('gif', 'png', 'jpg');

                            foreach ($multipleimage as $mke => $mval) {

                                foreach ($mval as $mke1 => $mval1) {
                                    $ext = pathinfo($mval1['image_name'], PATHINFO_EXTENSION);

                                    if (in_array($ext, $allowed)) {
                                        $singlearray[] = $mval1;
                                    }
                                }
                            }
                            ?>


                            <?php
                            if ($singlearray) {
                                ?>

                                <?php
                                $i = 0;
                                foreach ($singlearray as $mi) {
                                    ?>
                                    <div class="image_profile">

                                        <img src="<?php echo base_url($this->config->item('bus_post_thumb_upload_path') . $mi['image_name']) ?>" alt="img1">

                                    </div>
                                    <?php
                                    $i++;
                                    if ($i == 6)
                                        break;
                                }
                                ?>


                            <?php } else { ?>
                                Photos Not Available

                            <?php } ?>

                        </div>
                    </div>

                    <!-- user images end-->


                    <div class="full-box-module business_data">
                        <div class="profile-boxProfileCard  module">
                            <table class="business_data_table">
                                <div class="head_details">
                                    <a href="<?php echo base_url('business_profile/business_videos/' . $businessdata1[0]['business_slug']) ?>"><h5><i class="fa fa-video-camera" aria-hidden="true"></i>Video</h5></a>
                                </div>


                                <?php
                                $contition_array = array('user_id' => $businessdata1[0]['user_id']);
                                $busvideo = $this->data['busvideo'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


                                foreach ($busvideo as $val) {



                                    $contition_array = array('post_id' => $val['business_profile_post_id'], 'is_deleted' => '1', 'image_type' => '2');
                                    $busmultivideo = $this->data['busmultivideo'] = $this->common->select_data_by_condition('post_image', $contition_array, $data = '*', $sortby = 'post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                    $multiplevideo[] = $busmultivideo;
                                }
                                ?>
                                <?php
                                $allowesvideo = array('mp4', 'webm');

                                foreach ($multiplevideo as $mke => $mval) {

                                    foreach ($mval as $mke1 => $mval1) {
                                        $ext = pathinfo($mval1['image_name'], PATHINFO_EXTENSION);

                                        if (in_array($ext, $allowesvideo)) {
                                            $singlearray1[] = $mval1;
                                        }
                                    }
                                }
                                ?>

                                <?php if ($singlearray1) { ?>
                                    <tr>

                                        <?php if ($singlearray1[0]['image_name']) { ?>
                                            <td class="image_profile"> 
                                                <video controls>

                                                    <source src="<?php echo base_url($this->config->item('bus_post_main_upload_path') . $singlearray1[0]['image_name']) ?>" type="video/mp4">
                                                    <source src="movie.ogg" type="video/ogg">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </td>
                                        <?php } ?>

                                        <?php if ($singlearray1[1]['image_name']) { ?>
                                            <td class="image_profile">
                                                <video  controls>
                                                    <source src="<?php echo base_url($this->config->item('bus_post_main_upload_path') . $singlearray1[1]['image_name']) ?>" type="video/mp4">
                                                    <source src="movie.ogg" type="video/ogg">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </td>
                                        <?php } ?>
                                        <?php if ($singlearray1[2]['image_name']) { ?>
                                            <td class="image_profile">
                                                <video  controls>
                                                    <source src="<?php echo base_url($this->config->item('bus_post_main_upload_path') . $singlearray1[2]['image_name']) ?>" type="video/mp4">
                                                    <source src="movie.ogg" type="video/ogg">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                    <tr>

                                        <?php if ($singlearray1[3]['image_name']) { ?>
                                            <td class="image_profile"> 
                                                <video  controls>
                                                    <source src="<?php echo base_url($this->config->item('bus_post_main_upload_path') . $singlearray1[3]['image_name']) ?>" type="video/mp4">
                                                    <source src="movie.ogg" type="video/ogg">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </td>
                                        <?php } ?>
                                        <?php if ($singlearray1[4]['image_name']) { ?>
                                            <td class="image_profile">
                                                <video  controls>
                                                    <source src="<?php echo base_url($this->config->item('bus_post_main_upload_path') . $singlearray1[4]['image_name']) ?>" type="video/mp4">
                                                    <source src="movie.ogg" type="video/ogg">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </td>
                                        <?php } ?>
                                        <?php if ($singlearray1[5]['image_name']) { ?>
                                            <td class="image_profile">
                                                <video  controls>
                                                    <source src="<?php echo base_url($this->config->item('bus_post_main_upload_path') . $singlearray1[5]['image_name']) ?>" type="video/mp4">
                                                    <source src="movie.ogg" type="video/ogg">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } else { ?>
                                    Video Not Available
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                    <div class="full-box-module business_data">
                        <div class="profile-boxProfileCard  module">

                            <div class="head_details1">
                                <a href="<?php echo base_url('business_profile/business_audios/' . $businessdata1[0]['business_slug']) ?>"><h5><i class="fa fa-music" aria-hidden="true"></i>Audio</h5></a>
                            </div>
                            <table class="business_data_table">
                                <?php
                                $contition_array = array('user_id' => $businessdata1[0]['user_id']);
                                $busaudio = $this->data['busaudio'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


                                foreach ($busaudio as $val) {



                                    $contition_array = array('post_id' => $val['business_profile_post_id'], 'is_deleted' => '1', 'image_type' => '2');
                                    $busmultiaudio = $this->data['busmultiaudio'] = $this->common->select_data_by_condition('post_image', $contition_array, $data = '*', $sortby = 'post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                    $multipleaudio[] = $busmultiaudio;
                                }
                                ?>
                                <?php
                                $allowesaudio = array('mp3');

                                foreach ($multipleaudio as $mke => $mval) {

                                    foreach ($mval as $mke1 => $mval1) {
                                        $ext = pathinfo($mval1['image_name'], PATHINFO_EXTENSION);

                                        if (in_array($ext, $allowesaudio)) {
                                            $singlearray2[] = $mval1;
                                        }
                                    }
                                }
                                ?>

                                <?php if ($singlearray2) { ?>
                                    <tr>

                                        <?php if ($singlearray2[0]['image_name']) { ?>
                                            <td class="image_profile"> 
                                                <video  controls>

                                                    <source src="<?php echo base_url($this->config->item('bus_post_main_upload_path') . $singlearray2[0]['image_name']) ?>" type="audio/mp3">
                                                    <source src="movie.ogg" type="audio/mp3">
                                                    Your browser does not support the audio tag.
                                                </video>
                                            </td>
                                        <?php } ?>

                                        <?php if ($singlearray2[1]['image_name']) { ?>
                                            <td class="image_profile">
                                                <video  controls>
                                                    <source src="<?php echo base_url($this->config->item('bus_post_main_upload_path') . $singlearray2[1]['image_name']) ?>" type="audio/mp3">
                                                    <source src="movie.ogg" type="audio/mp3">
                                                    Your browser does not support the audio tag.
                                                </video>
                                            </td>
                                        <?php } ?>
                                        <?php if ($singlearray2[2]['image_name']) { ?>
                                            <td class="image_profile">
                                                <video  controls>
                                                    <source src="<?php echo base_url($this->config->item('bus_post_main_upload_path') . $singlearray2[2]['image_name']) ?>" type="audio/mp3">
                                                    <source src="movie.ogg" type="audio/mp3">
                                                    Your browser does not support the audio tag.
                                                </video>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                    <tr>

                                        <?php if ($singlearray2[3]['image_name']) { ?>
                                            <td class="image_profile"> 
                                                <video  controls>
                                                    <source src="<?php echo base_url($this->config->item('bus_post_main_upload_path') . $singlearray2[3]['image_name']) ?>" type="audio/mp3">
                                                    <source src="movie.ogg" type="audio/mp3">
                                                    Your browser does not support the audio tag.
                                                </video>
                                            </td>
                                        <?php } ?>
                                        <?php if ($singlearray2[4]['image_name']) { ?>
                                            <td class="image_profile">
                                                <video  controls>
                                                    <source src="<?php echo base_url($this->config->item('bus_post_main_upload_path') . $singlearray2[4]['image_name']) ?>" type="audio/mp3">
                                                    <source src="movie.ogg" type="audio/mp3">
                                                    Your browser does not support the audio tag.
                                                </video>
                                            </td>
                                        <?php } ?>
                                        <?php if ($singlearray2[5]['image_name']) { ?>
                                            <td class="image_profile">
                                                <video  controls>
                                                    <source src="<?php echo base_url($this->config->item('bus_post_main_upload_path') . $singlearray2[5]['image_name']) ?>" type="audio/mp3">
                                                    <source src="movie.ogg" type="audio/mp3">
                                                    Your browser does not support the audio tag.
                                                </video>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } else { ?>
                                    Audio Not Available
                                <?php } ?>
                            </table>

                        </div>

                    </div>

                    <div class="full-box-module business_data">
                        <div class="profile-boxProfileCard  module buisness_he_module" >

                            <div class="head_details">
                                <a href="<?php echo base_url('business_profile/business_pdf/' . $businessdata1[0]['business_slug']) ?>">   <h5><i class="fa fa-file-pdf-o" aria-hidden="true"></i>  PDF</h5></a>
                            </div>      
                            <?php
                            $contition_array = array('user_id' => $businessdata1[0]['user_id']);
                            $businessimage = $this->data['businessimage'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


                            foreach ($businessimage as $val) {



                                $contition_array = array('post_id' => $val['business_profile_post_id'], 'is_deleted' => '1', 'image_type' => '2');
                                $busmultipdf = $this->data['busmultipdf'] = $this->common->select_data_by_condition('post_image', $contition_array, $data = '*', $sortby = 'post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                $multiplepdf[] = $busmultipdf;
                            }
                            ?>
                            <?php
                            $allowed = array('pdf');

                            foreach ($multiplepdf as $mke => $mval) {

                                foreach ($mval as $mke1 => $mval1) {
                                    $ext = pathinfo($mval1['image_name'], PATHINFO_EXTENSION);

                                    if (in_array($ext, $allowed)) {
                                        $singlearray3[] = $mval1;
                                    }
                                }
                            }
                            ?>


                            <?php
                            if ($singlearray3) {
                                ?>

                                <?php
                                $i = 0;
                                foreach ($singlearray3 as $mi) {
                                    ?>
                                    <div class="image_profile">


                                        <a href="<?php echo base_url('business_profile/creat_pdf/' . $singlearray3[0]['image_id']) ?>"><div class="pdf_img">
                                                <img src="<?php echo base_url('images/PDF.jpg') ?>" style="height: 100%; width: 100%;">
                                            </div></a>

                                    </div>
                                    <?php
                                    $i++;
                                    if ($i == 6)
                                        break;
                                }
                                ?>


                            <?php } else { ?>
                                Pdf Not Available

                            <?php } ?>



                        </div>
                    </div>              
                </div>

                <!-- popup start -->
                <div class="col-md-7 col-sm-7 "  >

                    <div class="post-editor col-md-12" >
                        <div class="main-text-area col-md-12">
                            <div class="popup-img col-md-1"> 
                                <?php if ($businessdata1[0]['business_user_image']) { ?><img  src="<?php echo base_url($this->config->item('bus_profile_thumb_upload_path') . $businessdata1[0]['business_user_image']); ?>"  alt="">
                                <?php } else { ?>
                                    <img alt=""  src="<?php echo base_url(NOIMAGE); ?>" alt="" />
                                <?php } ?>
                            </div>
                            <div id="myBtn1"  class="editor-content col-md-11 popup-text"   >
                                <span>Post Your Product....</span>

                            </div>
                        </div>

                    </div>
                </div>

                <!-- The Modal -->
                <div id="myModal3" class="modal-post">

                    <!-- Modal content -->
                    <div class="modal-content-post">
                        <span class="close3">&times;</span>

                        <div class="post-editor col-md-12" id="close">

                            <?php echo form_open_multipart(base_url('business_profile/business_profile_addpost_insert/' . 'manage/' . $businessdata1[0]['user_id']), array('id' => 'artpostform', 'name' => 'artpostform', 'class' => 'clearfix', 'onsubmit' => "imgval(event)")); ?>

                            <div class="main-text-area col-md-12"  >
                                <div class="popup-img-in col-md-1"> 
                                    <?php
                                    if ($businessdata1[0]['business_user_image'] != '') {
                                        ?>
                                        <img  src="<?php echo base_url($this->config->item('bus_profile_thumb_upload_path') . $businessdata1[0]['business_user_image']); ?>"  alt="">
                                        <?php
                                    } else {
                                        ?>
                                        <img  src="<?php echo base_url(NOIMAGE); ?>"  alt="">
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div id="myBtn1"  class="editor-content col-md-10 popup-text" >
                                       <!-- <textarea name="product_title" placeholder="Post Your Product...."></textarea>  -->
                                    <textarea id= "test-upload_product" placeholder="Post Your Product...."  onKeyPress=check_length(this.form); onKeyDown=check_length(this.form); 
                                              name=my_text rows=4 cols=30 class="post_product_name" style="position: relative;" tabindex="1"></textarea>
                                              <div class="fifty_val">                   
                                        <input size=1 value=50 name=text_num class="text_num" readonly> 
                                    </div>

                                </div>

                                <div class="col-md-1 padding-left camer_h" ><i class=" fa fa-camera " ></i> </div>

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
                                <!--video will be inserted here.-->
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
                                            <i class=" fa fa-camera upload_icon"  > Photo</i>
                                            <i class=" fa fa-video-camera upload_icon"> Video </i> 
                                            <i class="fa fa-music upload_icon"> Audio </i>
                                            <i class=" fa fa-file-pdf-o upload_icon"> PDF </i>
                                        </label>



                                    </li>
                                </ul>


                            </div>
                            <div class="fr">
                                <button type="submit"  value="Submit">POST</button>    </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
                <!-- popup end -->
                <?php
                if ($this->session->flashdata('error')) {
                    echo $this->session->flashdata('error');
                }
                ?>


                <div class="col-md-7 col-sm-7 ">
                    <!-- middle section start -->

                    <?php
//echo "<pre>"; print_r($business_profile_data); die();
                    if (count($business_profile_data) > 0) {
                        foreach ($business_profile_data as $row) {
                            ?>
                            <div id="<?php echo "removeownpost" . $row['business_profile_post_id']; ?>">

                                <div class="job-post-detail clearfix">



                                    <div class=" post-design-box">
                                        <div class="post-design-top col-md-12" >  
                                            <div class="post-design-pro-img col-md-2"> 
                                                <?php
                                                $userid = $this->session->userdata('aileenuser');

                                                $userimage = $this->db->get_where('business_profile', array('user_id' => $row['user_id']))->row()->business_user_image;

                                                $userimageposted = $this->db->get_where('business_profile', array('user_id' => $row['posted_user_id']))->row()->business_user_image;
                                                ?>

                                                <?php if ($row['posted_user_id']) { ?>

                                                    <?php if ($userimageposted) { ?>
                                                        <img src="<?php echo base_url($this->config->item('bus_profile_thumb_upload_path') . $userimageposted); ?>" name="image_src" id="image_src" />
                                                    <?php } else { ?>
                                                        <img alt="" src="<?php echo base_url(NOIMAGE); ?>" alt="" />
                                                    <?php } ?>

                                                <?php } else { ?>

                                                    <?php if ($userimage) { ?>
                                                        <img src="<?php echo base_url($this->config->item('bus_profile_thumb_upload_path') . $userimage); ?>" name="image_src" id="image_src" />
                                                    <?php } else { ?>
                                                        <img alt="" src="<?php echo base_url(NOIMAGE); ?>" alt="" />
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>


                                            <div class="post-design-name fl col-md-9">
                                                <ul>

                                                    <?php
                                                    $companyname = $this->db->get_where('business_profile', array('user_id' => $row['user_id']))->row()->company_name;

                                                    $slugname = $this->db->get_where('business_profile', array('user_id' => $row['user_id'], 'status' => 1))->row()->business_slug;

                                                    $categoryid = $this->db->get_where('business_profile', array('user_id' => $row['user_id'], 'status' => 1))->row()->industriyal;


                                                    $category = $this->db->get_where('industry_type', array('industry_id' => $categoryid, 'status' => 1))->row()->industry_name;


                                                    $companynameposted = $this->db->get_where('business_profile', array('user_id' => $row['posted_user_id']))->row()->company_name;

                                                    $slugnameposted = $this->db->get_where('business_profile', array('user_id' => $row['posted_user_id'], 'status' => 1))->row()->business_slug;
                                                    ?>



                                                    <?php if ($row['posted_user_id']) { ?>
                                                        <li>
                                                            <div class="else_post_d">
                                                                <div class="post-design-product">
                                                                    <a style="max-width: 40%;" class="post_dot" title="<?php echo ucwords($companynameposted); ?>" href="<?php echo base_url('business_profile/business_profile_manage_post/' . $slugnameposted); ?>"><?php echo ucwords($companynameposted); ?></a>
                                                                    <p class="posted_with" > Posted With </p>
                                                                    <a class="other_name"  href="<?php echo base_url('business_profile/business_profile_manage_post/' . $slugname); ?>"><?php echo ucwords($companyname); ?></a>
                                                                    <span class="ctre_date"><?php echo date('d-M-Y', strtotime($row['created_date'])); ?> </span> 
                                                                </div></div></li>


                                                    <?php } else { ?>
                                                        <li><div class="post-design-product"><a class="post_dot" title="<?php echo ucwords($companyname); ?> " href="<?php echo base_url('business_profile/business_profile_manage_post/' . $slugname); ?>"><?php echo ucwords($companyname); ?> </a>

                                                                <div class="datespan"> 
                                                                  <span class="ctre_date"><?php echo date('d-M-Y', strtotime($row['created_date'])); ?> </span> 
                                                                </div>

                                                            </div></li>
                                                    <?php } ?>

                                                    <li><div class="post-design-product">   <a class="buuis_desc_a"  title="Category" > 
                                                                <?php
                                                                if ($category) {

                                                                    echo ucwords($category);
                                                                } else {
                                                                    echo ucwords($row['other_industrial']);
                                                                }
                                                                ?>

                                                            </a> </div></li>

                                                    <li>

                                                    </li> 

                                                </ul> 
                                            </div>  
                                            <div class="dropdown2">
                                                <a onClick="myFunction1(<?php echo $row['business_profile_post_id']; ?>)" class="dropbtn2 dropbtn2 fa fa-ellipsis-v"></a>
                                                <div id="<?php echo "myDropdown" . $row['business_profile_post_id']; ?>" class="dropdown-content2">



                                                    <?php
                                                    if ($row['posted_user_id'] != 0) {

                                                        if ($this->session->userdata('aileenuser') == $row['posted_user_id']) {
                                                            ?>
                                                            <a onclick="user_postdelete(<?php echo $row['business_profile_post_id']; ?>)">
                                                                <i class="fa fa-trash-o" aria-hidden="true">
                                                                </i> Delete Post
                                                            </a>
                                                            <a id="<?php echo $row['business_profile_post_id']; ?>" onClick="editpost(this.id)">
                                                                <i class="fa fa-pencil-square-o" aria-hidden="true">
                                                                </i>Edit
                                                            </a>

                                                        <?php } else {
                                                            ?>

                                                            <a onclick="user_postdelete(<?php echo $row['business_profile_post_id']; ?>)">
                                                                <i class="fa fa-trash-o" aria-hidden="true">
                                                                </i> Delete Post
                                                            </a>
                                                            <a href="<?php echo base_url('business_profile/business_profile_contactperson/' . $row['posted_user_id'] . ''); ?>">
                                                                <i class="fa fa-user" aria-hidden="true">
                                                                </i> Contact Person
                                                            </a>

                                                            <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <?php if ($this->session->userdata('aileenuser') == $row['user_id']) { ?> 


                                                            <a onclick="user_postdelete(<?php echo $row['business_profile_post_id']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete Post</a>

                                                            <a id="<?php echo $row['business_profile_post_id']; ?>" onClick="editpost(this.id)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</a>

                                                        <?php } else { ?>


                                                            <a href="<?php echo base_url('business_profile/business_profile_contactperson/' . $row['user_id'] . ''); ?>"><i class="fa fa-user" aria-hidden="true"></i> Contact Person</a>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>


  <?php if($row['product_name'] || $row['product_description']){?>

                                            <div class="post-design-desc" >
                <?php }?>                          
                                                <div id="<?php echo 'editpostdata' . $row['business_profile_post_id']; ?>" style="display:block;">
                                                    <a  ><?php echo $this->common->make_links($row['product_name']); ?></a>
                                                </div>
                                                

                                                <div id="<?php echo 'editpostbox' . $row['business_profile_post_id']; ?>" style="display:none;">
                                                    <input type="text" id="<?php echo 'editpostname' . $row['business_profile_post_id']; ?>" name="editpostname" placeholder="Product Name" value="<?php echo $row['product_name']; ?>">
                                                </div>


                                                <div id="<?php echo 'editpostdetails' . $row['business_profile_post_id']; ?>" style="display:block;">
                                                    <span class="show">  
                                                        <?php $new_product_description = $this->common->make_links($row['product_description']); ?>
                                                                <?php  echo  nl2br(htmlentities($new_product_description, ENT_QUOTES, 'UTF-8')); ?>
                                                                <?php //echo  nl2br($new_product_description); ?>
                                                    </span>
                                                </div>

                                                <div id="<?php echo 'editpostdetailbox' . $row['business_profile_post_id']; ?>" style="display:none;">

                                                                                                                                                                                                                            <!-- <textarea id="<?php echo 'editpostdesc' . $row['business_profile_post_id']; ?>" name="editpostdesc"><?php echo $row['product_description']; ?>
                                                                                                                                                                                                                            </textarea> 
                                                    -->
                                                    <div  contenteditable="true" id="<?php echo 'editpostdesc' . $row['business_profile_post_id']; ?>" placeholder="Product Description" class="textbuis  editable_text" placeholder="Description of Your Product"  name="editpostdesc" onpaste="OnPaste_StripFormatting(this, event);"><?php echo $row['product_description']; ?></div>

                                                    <!-- 
                                                    <div contenteditable="true"  id="<?php echo 'editpostdesc' . $row['business_profile_post_id']; ?>" placeholder="Product Description" class="textbuis  editable_text"  name="editpostdesc"><?php echo $row['product_description']; ?></div>  -->

                                                </div>

                                                <button class="fr" id="<?php echo "editpostsubmit" . $row['business_profile_post_id']; ?>" style="display:none;margin: 5px 0;" onClick="edit_postinsert(<?php echo $row['business_profile_post_id']; ?>)">Save</button>




                                            </div> 
                                            <?php if($row['product_name'] || $row['product_description']){?>
                                        </div>
                                       <?php } ?>
                                      


                                        <div class="post-design-mid col-md-12" >  


                                            <!-- multiple image code  start-->

                                            <div class="mange_post_image">
                                                <?php
                                                $contition_array = array('post_id' => $row['business_profile_post_id'], 'is_deleted' => '1', 'image_type' => '2');
                                                $businessmultiimage = $this->data['businessmultiimage'] = $this->common->select_data_by_condition('post_image', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                ?>

                                                <?php if (count($businessmultiimage) == 1) { ?>

                                                    <?php
                                                    $allowed = array('gif', 'png', 'jpg');
                                                    $allowespdf = array('pdf');
                                                    $allowesvideo = array('mp4', 'webm');
                                                    $allowesaudio = array('mp3');
                                                    $filename = $businessmultiimage[0]['image_name'];
                                                    $ext = pathinfo($filename, PATHINFO_EXTENSION);

                                                    if (in_array($ext, $allowed)) {
                                                        ?>

                                                        <!-- one image start -->
                                                        <div id="basic-responsive-image" >
                                                            <a href="<?php echo base_url('business_profile/postnewpage/' . $row['business_profile_post_id']) ?>"><img src="<?php echo base_url($this->config->item('bus_post_thumb_upload_path') . $businessmultiimage[0]['image_name']) ?>" style="width: 100%; height: 100%;"> </a>
                                                        </div>
                                                        <!-- one image end -->

                                                    <?php } elseif (in_array($ext, $allowespdf)) { ?>

                                                        <!-- one pdf start -->
                                                        <div>
                                                            <a href="<?php echo base_url('business_profile/creat_pdf/' . $businessmultiimage[0]['image_id']) ?>"><div class="pdf_img">
                                                                    <img src="<?php echo base_url('images/PDF.jpg') ?>" style="height: 100%; width: 100%;">
                                                                </div></a>
                                                        </div>
                                                        <!-- one pdf end -->

                                                    <?php } elseif (in_array($ext, $allowesvideo)) { ?>

                                                        <!-- one video start -->
                                                        <div>
                                                            <video class="video" width="100%" height="350" controls>
                                                                <source src="<?php echo base_url($this->config->item('bus_post_main_upload_path') . $businessmultiimage[0]['image_name']) ?>" type="video/mp4">
                                                                <source src="movie.ogg" type="video/ogg">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        </div>
                                                        <!-- one video end -->

                                                    <?php } elseif (in_array($ext, $allowesaudio)) { ?>

                                                        <!-- one audio start -->
                                                        <div class="audio_main_div">
                                                            <div class="audio_img">
                                                                <img src="<?php echo base_url('images/music-icon.png') ?> ">  
                                                            </div>
                                                            <div class="audio_source">
                                                                <audio  controls>

                                                                    <source src="<?php echo base_url($this->config->item('bus_post_main_upload_path') . $businessmultiimage[0]['image_name']) ?>" type="audio/mp3">
                                                                    <source src="movie.ogg" type="audio/ogg">
                                                                    Your browser does not support the audio tag.

                                                                </audio>
                                                            </div>
                                                            <div class="audio_mp3">
                                                                <p title="hellow this is mp3">This text will scroll from right to left</p>
                                                            </div>
                                                        </div> 
                                                        <!-- one audio end -->

                                                    <?php } ?>

                                                <?php } elseif (count($businessmultiimage) == 2) { ?>

                                                    <?php
                                                    foreach ($businessmultiimage as $multiimage) {
                                                        ?>

                                                        <!-- two image start -->
                                                        <div  id="two_manage_images_art" >
                                                            <a href="<?php echo base_url('business_profile/postnewpage/' . $row['business_profile_post_id']) ?>"><img class="two-columns" src="<?php echo base_url($this->config->item('bus_post_thumb_upload_path') . $multiimage['image_name']) ?>" style="width: 100%; height: 100%;"> </a>
                                                        </div>

                                                        <!-- two image end -->
                                                    <?php } ?>

                                                <?php } elseif (count($businessmultiimage) == 3) { ?>



                                                    <!-- three image start -->
                                                    <div id="three_images_art" >
                                                        <a href="<?php echo base_url('business_profile/postnewpage/' . $row['business_profile_post_id']) ?>"><img class="three-columns" src="<?php echo base_url($this->config->item('bus_post_main_upload_path') . $businessmultiimage[0]['image_name']) ?>" style="width: 100%; height:100%; "> </a>
                                                    </div>
                                                    <div  id="three_images_2_art">
                                                        <a href="<?php echo base_url('business_profile/postnewpage/' . $row['business_profile_post_id']) ?>"><img class="three-columns" src="<?php echo base_url($this->config->item('bus_post_thumb_upload_path') . $businessmultiimage[1]['image_name']) ?>" style="width: 100%; height:100%; "> </a>
                                                    </div>
                                                    <div  id="three_images_2_art">
                                                        <a href="<?php echo base_url('business_profile/postnewpage/' . $row['business_post_id']) ?>"><img class="three-columns" src="<?php echo base_url($this->config->item('bus_post_thumb_upload_path') . $businessmultiimage[2]['image_name']) ?>" style="width: 100%; height:100%; "> </a>
                                                    </div>

                                                    <!-- three image end -->


                                                <?php } elseif (count($businessmultiimage) == 4) { ?>


                                                    <?php
                                                    foreach ($businessmultiimage as $multiimage) {
                                                        ?>

                                                        <!-- four image start -->
                                                        <div id="responsive_manage-images-breakpoints" >
                                                            <a href="<?php echo base_url('business_profile/postnewpage/' . $row['business_profile_post_id']) ?>"><img class="breakpoint" src="<?php echo base_url($this->config->item('bus_post_thumb_upload_path') . $multiimage['image_name']) ?>" style="width: 100%; height: 100%;"> </a>

                                                        </div>

                                                        <!-- four image end -->

                                                    <?php } ?>


                                                <?php } elseif (count($businessmultiimage) > 4) { ?>



                                                    <?php
                                                    $i = 0;
                                                    foreach ($businessmultiimage as $multiimage) {
                                                        ?>

                                                        <!-- five image start -->
                                                        <div>
                                                            <div id="responsive-manage_images_2-breakpoints">
                                                                <a href="<?php echo base_url('business_profile/postnewpage/' . $row['business_profile_post_id']) ?>"><img src="<?php echo base_url($this->config->item('bus_post_thumb_upload_path') . $multiimage['image_name']) ?>" > </a>
                                                            </div>
                                                        </div>

                                                        <!-- five image end -->

                                                        <?php
                                                        $i++;
                                                        if ($i == 3)
                                                            break;
                                                    }
                                                    ?>
                                                    <!-- this div view all image start -->
                                                    <div>
                                                        <div id="responsive-manage_images_3-breakpoints" >
                                                            <a href="<?php echo base_url('business_profile/postnewpage/' . $row['business_profile_post_id']) ?>"><img src="<?php echo base_url($this->config->item('bus_post_thumb_upload_path') . $businessmultiimage[3]['image_name']) ?>" style=" width: 100%; height: 100%;"> </a></div>


                                                        <div class="manage_images_view_more" >


                                                            <a href="<?php echo base_url('business_profile/postnewpage/' . $row['business_profile_post_id']) ?>">View All (+<?php echo (count($businessmultiimage) - 4); ?>)</a>
                                                        </div>

                                                    </div>
                                                    <!-- this div view all image end -->


                                                <?php } ?>
                                                <div>


                                                </div>

                                            </div>



                                            <!-- multiple image code  end-->


                                        </div>
                                        <div class="post-design-like-box col-md-12">
                                            <div class="post-design-menu">
                                                <ul>
                                                    <li class="<?php echo 'likepost' . $row['business_profile_post_id']; ?>">
                                                        <a id="<?php echo $row['business_profile_post_id']; ?>"   onClick="post_like(this.id)">
                                                            <?php
                                                            $userid = $this->session->userdata('aileenuser');
                                                            $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1');
                                                            $active = $this->data['active'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                                            $likeuser = $this->data['active'][0]['business_like_user'];
                                                            $likeuserarray = explode(',', $active[0]['business_like_user']);

                                                            if (!in_array($userid, $likeuserarray)) {
                                                                ?>               

                                                                <!--<i class="fa fa-thumbs-o-up fa-1x" aria-hidden="true"></i>-->
                                                            <i class="fa fa-thumbs-up" style="color: #999;" aria-hidden="true"></i>

                                                            <?php } else { ?> 
                                                                <!--<i class="fa fa-thumbs-up" aria-hidden="true"></i>-->
                                                            <i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>
                                                            <?php } ?>

                                                            <span class="like_As_count">
                                                                <?php
                                                                if ($row['business_likes_count'] > 0) {
                                                                    echo $row['business_likes_count'];
                                                                }
                                                                ?>
                                                            </span>
                                                        </a>
                                                    </li>

                                                    <li id="<?php echo "insertcount" . $row['business_profile_post_id']; ?>" style="visibility:show">
                                                        <?php
                                                        $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                                                        $commnetcount = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                        ?>

                                                        <a  onClick="commentall(this.id)" id="<?php echo $row['business_profile_post_id']; ?>"><i class="fa fa-comment-o" aria-hidden="true"> 
                                                                <?php
                                                                if (count($commnetcount) > 0) {
                                                                    echo count($commnetcount);
                                                                }
                                                                ?>
                                                            </i> 
                                                        </a>
                                                    </li> 
                                                </ul>

                                            </div>
                                        </div>

                                        <!-- like user list start -->

                                        <!-- pop up box start-->
                                        <?php
                                        if ($row['business_likes_count'] > 0) {
                                            ?>
                                            <div class="likeduserlist<?php echo $row['business_profile_post_id'] ?>">
                                                <?php
                                                $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                                                $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                $likeuser = $commnetcount[0]['business_like_user'];
                                                $countlike = $commnetcount[0]['business_likes_count'] - 1;
                                                $likelistarray = explode(',', $likeuser);
                                                foreach ($likelistarray as $key => $value) {
                                                    $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
                                                }
                                                ?>
                                                <!-- pop up box end-->
                                                <a href="javascript:void(0);"  onclick="likeuserlist(<?php echo $row['business_profile_post_id']; ?>);">
                                                    <?php
                                                    $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                                                    $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                                    $likeuser = $commnetcount[0]['business_like_user'];
                                                    $countlike = $commnetcount[0]['business_likes_count'] - 1;
                                                    $likelistarray = explode(',', $likeuser);

                                                    $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
                                                    ?>
                                                    <div class="like_one_other">
                                                        <?php
                                                        if ($userid == $value) {
                                                            echo "You";
                                                            echo "&nbsp;";
                                                        } else {
                                                            echo ucwords($business_fname1);
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
                                                    </div>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <div class="<?php echo "likeusername" . $row['business_profile_post_id']; ?>" id="<?php echo "likeusername" . $row['business_profile_post_id']; ?>" style="display:none">
                                            <?php
                                            $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                                            $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                            $likeuser = $commnetcount[0]['business_like_user'];
                                            $countlike = $commnetcount[0]['business_likes_count'] - 1;
                                            $likelistarray = explode(',', $likeuser);
                                            foreach ($likelistarray as $key => $value) {
                                                $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
                                            }
                                            ?>
                                            <!-- pop up box end-->
                                            <a href="javascript:void(0);"  onclick="likeuserlist(<?php echo $row['business_profile_post_id']; ?>);">
                                                <?php
                                                $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                                                $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                                $likeuser = $commnetcount[0]['business_like_user'];
                                                $countlike = $commnetcount[0]['business_likes_count'] - 1;
                                                $likelistarray = explode(',', $likeuser);

                                                $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
                                                ?>
                                                <div class="like_one_other">
                                                    <?php
                                                    echo ucwords($business_fname1);
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
                                                </div>
                                            </a>
                                        </div>

                                        <!-- like user list end -->



                                        <!-- all comment start-->

                                        <div class="art-all-comment col-md-12">

                                            <div id="<?php echo "fourcomment" . $row['business_profile_post_id']; ?>" style="display:none;">


                                            </div>

                                            <!-- khyati changes start -->
                                            <div  id="<?php echo "threecomment" . $row['business_profile_post_id']; ?>" style="display:block">
                                                <div class="<?php echo 'insertcomment' . $row['business_profile_post_id']; ?>">

                                                    <?php
                                                    $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1');

                                                    $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = 'business_profile_post_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');

                                                    if ($businessprofiledata) {
                                                        foreach ($businessprofiledata as $rowdata) {
                                                            $companyname = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id']))->row()->company_name;
                                                            ?>
                                                            <div class="all-comment-comment-box">
                                                                <div class="post-design-pro-comment-img"> 
                                                                    <?php
                                                                    $business_userimage = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id'], 'status' => 1))->row()->business_user_image;
                                                                    ?>
                                                                    <?php if ($business_userimage) { ?>
                                                                        <img  src="<?php echo base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage); ?>"  alt="">
                                                                    <?php } else { ?>
                                                                        <img src="<?php echo base_url(NOIMAGE); ?>" alt="">
                                                                    <?php } ?>

                                                                </div>
                                                                <div class="comment-name">

                                                                    <b>  <?php
                                                                        echo ucwords($companyname);
                                                                        echo '</br>';
                                                                        ?>
                                                                    </b>
                                                                </div>
                                                                <div class="comment-details" id= "<?php echo "showcomment" . $rowdata['business_profile_post_comment_id']; ?>">
                                                                    <?php
                                                                    $new_product_comment = $this->common->make_links($rowdata['comments']);
                                                                    
                                                                //    echo  nl2br(htmlentities($new_product_comment, ENT_QUOTES, 'UTF-8')); 
                                                                    echo  nl2br(htmlspecialchars_decode(htmlentities($new_product_comment, ENT_QUOTES, 'UTF-8'))); ?>
                                                                </div>
                                                                
                                                                <div class="edit-comment-box">
                                                                    <div class="inputtype-edit-comment">

                                                                        <div contenteditable="true"  class="editable_text editav_2" name="<?php echo $rowdata['business_profile_post_comment_id']; ?>"  id="<?php echo "editcomment" . $rowdata['business_profile_post_comment_id']; ?>" placeholder="Add a Commnet Comment " value= ""  onkeyup="commentedit(<?php echo $rowdata['business_profile_post_comment_id']; ?>)" onpaste="OnPaste_StripFormatting(this, event);"><?php echo $rowdata['comments']; ?></div>
                                                                        <span class="comment-edit-button"><button id="<?php echo "editsubmit" . $rowdata['business_profile_post_comment_id']; ?>" style="display:none" onClick="edit_comment(<?php echo $rowdata['business_profile_post_comment_id']; ?>)">Save</button></span>
                                                                    </div>
                                                                </div>
                                                                <div class="art-comment-menu-design"> 
                                                                    <div class="comment-details-menu" id="<?php echo 'likecomment1' . $rowdata['business_profile_post_comment_id']; ?>">
                                                                        <a id="<?php echo $rowdata['business_profile_post_comment_id']; ?>" onClick="comment_like1(this.id)">
                                                                            <?php
                                                                            $userid = $this->session->userdata('aileenuser');
                                                                            $contition_array = array('business_profile_post_comment_id' => $rowdata['business_profile_post_comment_id'], 'status' => '1');
                                                                            $businesscommentlike = $this->data['businesscommentlike'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                                            $likeuserarray = explode(',', $businesscommentlike[0]['business_comment_like_user']);
                                                                            if (!in_array($userid, $likeuserarray)) {
                                                                                ?>
                                                                                <i class="fa fa-thumbs-o-up fa-1x" aria-hidden="true"></i> 
                                                                            <?php } else { ?>
                                                                                <i class="fa fa-thumbs-up" aria-hidden="true"></i>

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
                                                                            ?></p></div>
                                                                </div></div>


                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                                </div>
                                            </div>

                                            <!-- khyati changes end -->

                                            <!-- all comment end -->



                                        </div>
                                        <!-- comment start -->
                                        <div class="post-design-commnet-box col-md-12">

                                            <div class="post-design-proo-img"> 
                                                <?php
                                                $userid = $this->session->userdata('aileenuser');
                                                $business_userimage = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => 1))->row()->business_user_image;
                                                ?>
                                                <?php if ($business_userimage) { ?>
                                                    <img  src="<?php echo base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage); ?>"  alt="">
                                                <?php } else { ?>
                                                    <img src="<?php echo base_url(NOIMAGE); ?>" alt="">
                                                <?php } ?>
                                            </div>



                                            <div >
                                                  <div id="content" class="col-md-12  inputtype-comment cmy_2" >

                                                    <div contenteditable="true" class="editable_text edt_2" name="<?php echo $row['business_profile_post_id']; ?>"  id="<?php echo "post_comment" . $row['business_profile_post_id']; ?>" placeholder="Add a Comment... " onClick="entercomment(<?php echo $row['business_profile_post_id']; ?>)" onpaste="OnPaste_StripFormatting(this, event);"></div>
                                                </div>
                                                <?php echo form_error('post_comment'); ?> 
                                                <div class="comment-edit-butn">       
                                                    <button id="<?php echo $row['business_profile_post_id']; ?>" onClick="insert_comment(this.id)">Comment</button></div>
                                            </div>

                                        </div>
                                        <!-- comment end -->
                                    </div>

                                </div> </div>

                            <?php
                        }
                    } else {
                        ?>
                        <div class="text-center rio">
                            <h4 class="page-heading  product-listing">No Post Found.</h4>
                        </div>

                    <?php } ?>


                </div>
                <!-- business_profile _manage_post end -->

            </div>
            </section>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
            <!-- footer start -->
            <footer>

                <?php echo $footer; ?>
            </footer>


            <!-- Bid-modal  -->
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
            <!-- Model Popup Close -->



            <!-- Bid-modal-2  -->
            <div class="modal fade message-box" id="bidmodal-2" role="dialog">
                <div class="modal-dialog modal-lm">
                    <div class="modal-content">
                        <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                        <div class="modal-body">
                            <span class="mes">
                                <div id="popup-form">
                                    <?php echo form_open_multipart(base_url('business_profile/user_image_insert'), array('id' => 'userimage', 'name' => 'userimage', 'class' => 'clearfix')); ?>
                                    <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="profilepic">
                                    <input type="hidden" name="hitext" id="hitext" value="5">
                                    <!--<input type="submit" name="cancel3" id="cancel3" value="Cancel">-->
                                    <input type="submit" name="profilepicsubmit" id="profilepicsubmit" value="Save" >
                                    <div class="popup_previred">
                                        <img id="preview" src="#" alt="your image" />
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
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

            </body>

            </html>
            <script>
                $('#file-fr').fileinput({
                    language: 'fr',
                    uploadUrl: '#',
                    allowedFileExtensions: ['jpg', 'png', 'gif']
                });
                $('#file-es').fileinput({
                    language: 'es',
                    uploadUrl: '#',
                    allowedFileExtensions: ['jpg', 'png', 'gif']
                });

                $("#file-1").fileinput({
                    uploadUrl: '#', // you must set a valid URL here else you will get an error
                    allowedFileExtensions: ['jpg', 'png', 'gif'],
                    overwriteInitial: false,
                    maxFileSize: 1000,
                    maxFilesNum: 10,
                    //allowedFileTypes: ['image', 'video', 'flash'],
                    slugCallback: function (filename) {
                        return filename.replace('(', '_').replace(']', '_');
                    }
                });
                /*
                 $(".file").on('fileselect', function(event, n, l) {
                 alert('File Selected. Name: ' + l + ', Num: ' + n);
                 });
                 */

                $(".btn-warning").on('click', function () {
                    var $el = $("#file-4");
                    if ($el.attr('disabled')) {
                        $el.fileinput('enable');
                    } else {
                        $el.fileinput('disable');
                    }
                });
                // $(".btn-info").on('click', function () {
                //     $("#file-4").fileinput('refresh', {previewClass: 'bg-info'});
                // });
                /*
                 $('#file-4').on('fileselectnone', function() {
                 alert('Huh! You selected no files.');
                 });
                 $('#file-4').on('filebrowse', function() {
                 alert('File browse clicked for #file-4');
                 });
                 */
                $(document).ready(function () {
                    $("#test-upload").fileinput({
                        'showPreview': false,
                        'allowedFileExtensions': ['jpg', 'png', 'gif'],
                        'elErrorContainer': '#errorBlock'
                    });
                    $("#kv-explorer").fileinput({
                        'theme': 'explorer',
                        'uploadUrl': '#',
                        overwriteInitial: false,
                        initialPreviewAsData: true,

                    });
                    /*
                     $("#test-upload").on('fileloaded', function(event, file, previewId, index) {
                     alert('i = ' + index + ', id = ' + previewId + ', file = ' + file.name);
                     });
                     */
                });
            </script>

            <!-- tabing script start -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
            <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
            <script src="<?php echo base_url('js/jquery.wallform.js'); ?>"></script>
            <script src="<?php echo base_url('js/jquery-ui.min.js'); ?>"></script>
            <script src="<?php echo base_url('js/demo/jquery-1.9.1.js'); ?>"></script>
            <script src="<?php echo base_url('js/demo/jquery-ui-1.9.1.js'); ?>"></script>


            <!-- script for skill textbox automatic start-->
            <script src="<?php echo base_url('assets/js/croppie.js'); ?>"></script>


            <!-- script for cropiee immage start-->




            <!-- script for skill textbox automatic end-->

            <script>
                jQuery.noConflict();

                (function ($) {

                    var data = <?php echo json_encode($demo); ?>;
                    // alert(data);


                    $(function () {
                        // alert('hi');
                        $("#tags").autocomplete({
                            source: function (request, response) {
                                var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
                                response($.grep(data, function (item) {
                                    return matcher.test(item.label);
                                }));
                            },
                            minLength: 1,
                            select: function (event, ui) {
                                event.preventDefault();
                                $("#tags").val(ui.item.label);
                                $("#selected-tag").val(ui.item.label);
                                // window.location.href = ui.item.value;
                            }
                            ,
                            focus: function (event, ui) {
                                event.preventDefault();
                                $("#tags").val(ui.item.label);
                            }
                        });
                    });
                })(jQuery);
            </script>

            <script type="text/javascript">
                function checkvalue() {
                    //alert("hi");
                    var searchkeyword = $.trim(document.getElementById('tags').value);
                    var searchplace = $.trim(document.getElementById('searchplace').value);
                    // alert(searchkeyword);
                    // alert(searchplace);
                    if (searchkeyword == "" && searchplace == "") {
                        //alert('Please enter Keyword');
                        return false;
                    }
                }
            </script>

            <script>
                function updateprofilepopup(id) {
                    $('#bidmodal-2').modal('show');
                }
            </script>
            <script>
                function openCity(evt, cityName) {
                    var i, tabcontent, tablinks;
                    tabcontent = document.getElementsByClassName("tabcontent");
                    for (i = 0; i < tabcontent.length; i++) {
                        tabcontent[i].style.display = "none";
                    }
                    tablinks = document.getElementsByClassName("tablinks");
                    for (i = 0; i < tablinks.length; i++) {
                        tablinks[i].className = tablinks[i].className.replace(" active2", "");
                    }
                    document.getElementById(cityName).style.display = "block";
                    evt.currentTarget.className += " active2";

                }

                // Get the element with id="defaultOpen" and click on it
                document.getElementById("defaultOpen").click();
            </script>




            <!-- script for skill textbox automatic end (option 2)-->


            <!-- script for business autofill -->
            <!-- <script>
              $( function() {
            
                var complex = <?php echo json_encode($demo); ?>;
               
                var availableTags = complex; 
                $( "#tags" ).autocomplete({ 
                  source: availableTags
                });
              } );
              </script>  -->
            <!-- end of business search auto fill -->
            <script>

                //select2 autocomplete start for Location
                $('#searchplace').select2({

                    placeholder: 'Find Your Location',
                    maximumSelectionLength: 1,
                    ajax: {

                        url: "<?php echo base_url(); ?>business_profile/location",
                        dataType: 'json',
                        delay: 250,

                        processResults: function (data) {

                            return {

                                results: data


                            };

                        },
                        cache: true
                    }
                });
                //select2 autocomplete End for Location

            </script>

            <!-- tabing script end -->
            <!-- footer end -->

            <!-- like comment ajax data start-->

            <!-- post like script start -->

            <script type="text/javascript">
                function post_like(clicked_id)
                {
                    //alert(clicked_id);
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() . "business_profile/like_post" ?>',
                        data: 'post_id=' + clicked_id,
                        dataType: 'json',
                        success: function (data) { //alert('.' + 'likepost' + clicked_id);
                            // $('.' + 'likepost' + clicked_id).html(data);
                            $('.' + 'likepost' + clicked_id).html(data.like);
                            $('.likeusername' + clicked_id).html(data.likeuser);

                            $('.likeduserlist' + clicked_id).hide();
                            if (data.like_user_count == '0') {
                                document.getElementById('likeusername' + clicked_id).style.display = "none";
                            } else {
                                document.getElementById('likeusername' + clicked_id).style.display = "block";
                            }
                            $('#likeusername' + clicked_id).addClass('likeduserlist1');

                        }
                    });
                }
            </script>

            <!--post like script end -->

            <!-- comment insert script start -->

            <script type="text/javascript">

                function insert_comment(clicked_id)
                {

                    $("#post_comment" + clicked_id).click(function () {
                        $(this).prop("contentEditable", true);
                        $(this).html("");
                    });

                    var sel = $("#post_comment" + clicked_id);
                    var txt = sel.html();
                    txt = txt.replace(/&nbsp;/gi, " ");
                    txt = txt.replace(/<br>$/, '');
                    if (txt == '' || txt == '<br>') {
                        return false;
                    }
                    if (/^\s+$/gi.test(txt))
                    {
                        return false;
                    }
                    txt = txt.replace(/&/g,"%26");
                    $('#post_comment' + clicked_id).html("");

                    var x = document.getElementById('threecomment' + clicked_id);
                    var y = document.getElementById('fourcomment' + clicked_id);

                    if (x.style.display === 'block' && y.style.display === 'none') {
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url() . "business_profile/insert_commentthree" ?>',
                            data: 'post_id=' + clicked_id + '&comment=' + txt,
                            dataType: "json",
                            success: function (data) {
                                $('textarea').each(function () {
                                    $(this).val('');
                                });
                                $('#' + 'insertcount' + clicked_id).html(data.count);
                                $('.insertcomment' + clicked_id).html(data.comment);

                            }
                        });

                    } else {

                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url() . "business_profile/insert_comment" ?>',
                            data: 'post_id=' + clicked_id + '&comment=' + txt,
                            dataType: "json",
                            success: function (data) {
                                $('textarea').each(function () {
                                    $(this).val('');
                                });
                                $('#' + 'insertcount' + clicked_id).html(data.count);
                                $('#' + 'fourcomment' + clicked_id).html(data.comment);
                            }
                        });
                    }
                }


//                function insert_comment(clicked_id)
//                {
//                    var post_comment = document.getElementById("post_comment" + clicked_id);
//                    var x = document.getElementById('threecomment' + clicked_id);
//                    var y = document.getElementById('fourcomment' + clicked_id);
//
//                    if (x.style.display === 'block' && y.style.display === 'none') {
//                        $.ajax({
//                            type: 'POST',
//                            url: '<?php echo base_url() . "business_profile/insert_commentthree" ?>',
//                            data: 'post_id=' + clicked_id + '&comment=' + post_comment.value,
//                            dataType: "json",
//                            success: function (data) {
//                                $('textarea').each(function () {
//                                    $(this).val('');
//                                });
//                                $('#' + 'insertcount' + clicked_id).html(data.count);
//                                $('.insertcomment' + clicked_id).html(data.comment);
//
//                            }
//                        });
//
//                    } else {
//
//                        $.ajax({
//                            type: 'POST',
//                            url: '<?php echo base_url() . "business_profile/insert_comment" ?>',
//                            data: 'post_id=' + clicked_id + '&comment=' + post_comment.value,
//                            dataType: "json",
//                            success: function (data) {
//                                $('textarea').each(function () {
//                                    $(this).val('');
//                                });
//                                $('#' + 'insertcount' + clicked_id).html(data.count);
//                                $('#' + 'fourcomment' + clicked_id).html(data.comment);
//
//                            }
//                        });
//                    }
//                }
            </script>

            <!-- insert comment using enter -->
            <script type="text/javascript">

                function entercomment(clicked_id)
                {
//                    $(document).ready(function () {

                    $("#post_comment" + clicked_id).click(function () {
                        $(this).prop("contentEditable", true);
                        //$(this).html("");
                    });

                    $('#post_comment' + clicked_id).keypress(function (e) {

                        if (e.keyCode == 13 && !e.shiftKey) {
                            e.preventDefault();
                            var sel = $("#post_comment" + clicked_id);
                            var txt = sel.html();
                            //txt = txt.replace(/^(&nbsp;|<br>)+/, '');
                            txt = txt.replace(/&nbsp;/gi, " ");
                            txt = txt.replace(/<br>$/, '');
                            if (txt == '' || txt == '<br>') {
                                return false;
                            }
                            if (/^\s+$/gi.test(txt))
                            {
                                return false;
                            }
                            txt = txt.replace(/&/g,"%26");
                            $('#post_comment' + clicked_id).html("");

                            if (window.preventDuplicateKeyPresses)
                                return;

                            window.preventDuplicateKeyPresses = true;
                            window.setTimeout(function () {
                                window.preventDuplicateKeyPresses = false;
                            }, 500);

                            // khyati chnages  start

                            var x = document.getElementById('threecomment' + clicked_id);
                            var y = document.getElementById('fourcomment' + clicked_id);

                            if (x.style.display === 'block' && y.style.display === 'none') {
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo base_url() . "business_profile/insert_commentthree" ?>',
                                    data: 'post_id=' + clicked_id + '&comment=' + txt,
                                    dataType: "json",
                                    success: function (data) {
                                        $('textarea').each(function () {
                                            $(this).val('');
                                        });

                                        //  $('.insertcomment' + clicked_id).html(data);
                                        $('#' + 'insertcount' + clicked_id).html(data.count);
                                        $('.insertcomment' + clicked_id).html(data.comment);

                                    }
                                });

                            } else {
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo base_url() . "business_profile/insert_comment" ?>',
                                    data: 'post_id=' + clicked_id + '&comment=' + txt,
                                    dataType: "json",
                                    success: function (data) {
                                        $('textarea').each(function () {
                                            $(this).val('');
                                        });
                                        //$('#' + 'fourcomment' + clicked_id).html(data);
                                        $('#' + 'insertcount' + clicked_id).html(data.count);
                                        $('#' + 'fourcomment' + clicked_id).html(data.comment);

                                    }
                                });
                            }
                            // khyati chnages end
                            //alert(val);
                        }
                    });
                    $(".scroll").click(function (event) {
                        event.preventDefault();
                        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
                    });
                    //  });

                }

//                function entercomment(clicked_id)
//                {
//                    $(document).ready(function () {
//                        $('#post_comment' + clicked_id).keypress(function (e) {
//                            if (e.keyCode == 13 && !e.shiftKey) {
//                                var $field = $('#post_comment' + clicked_id);
//                                var post_comment_data = $('#post_comment' + clicked_id).html();
//                                e.preventDefault();
//
//                                if (window.preventDuplicateKeyPresses)
//                                    return;
//
//                                window.preventDuplicateKeyPresses = true;
//                                window.setTimeout(function () {
//                                    window.preventDuplicateKeyPresses = false;
//                                }, 500);
//
//                                var x = document.getElementById('threecomment' + clicked_id);
//                                var y = document.getElementById('fourcomment' + clicked_id);
//
//                                if (x.style.display === 'block' && y.style.display === 'none') {
//                                    $.ajax({
//                                        type: 'POST',
//                                        url: '<?php echo base_url() . "business_profile/insert_commentthree" ?>',
//                                        data: 'post_id=' + clicked_id + '&comment=' + post_comment_data,
//                                        dataType: "json",
//                                        success: function (data) {
//                                            $('textarea').each(function () {
//                                                $(this).val('');
//                                            });
//
//                                            $('#' + 'insertcount' + clicked_id).html(data.count);
//                                            $('.insertcomment' + clicked_id).html(data.comment);
//
//                                        }
//                                    });
//
//                                } else {
//                                    $.ajax({
//                                        type: 'POST',
//                                        url: '<?php echo base_url() . "business_profile/insert_comment" ?>',
//                                        data: 'post_id=' + clicked_id + '&comment=' + post_comment_data,
//                                        dataType: "json",
//                                        success: function (data) {
//                                            $('textarea').each(function () {
//                                                $(this).val('');
//                                            });
//                                            $('#' + 'insertcount' + clicked_id).html(data.count);
//                                            $('#' + 'fourcomment' + clicked_id).html(data.comment);
//
//                                        }
//                                    });
//                                }
//                            }
//                        });
//                    });
//
//                }  


            </script>


            <script type="text/javascript">
                function insert_comment1(clicked_id)
                {
                    var post_comment = document.getElementById("post_comment1" + clicked_id);
                    //alert(clicked_id);
                    //alert(post_comment.value);
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() . "business_profile/insert_comment1" ?>',
                        data: 'post_id=' + clicked_id + '&comment=' + post_comment.value,
                        dataType: "json",
                        success: function (data) {
                            $('textarea').each(function () {
                                $(this).val('');
                            });


                            $('.' + 'insertcount' + clicked_id).html(data.count);
                            $('.' + 'insertcomment1' + clicked_id).html(data.comment);

                        }
                    });
                }
            </script>


            <!-- insert comment using enter -->
            <script type="text/javascript">

                function entercomment1(clicked_id)
                {

                    $(document).ready(function () {
                        $('#post_comment1' + clicked_id).keypress(function (e) {

                            if (e.keyCode == 13 && !e.shiftKey) {
                                var val = $('#post_comment1' + clicked_id).val();
                                e.preventDefault();

                                if (window.preventDuplicateKeyPresses)
                                    return;

                                window.preventDuplicateKeyPresses = true;
                                window.setTimeout(function () {
                                    window.preventDuplicateKeyPresses = false;
                                }, 500);


                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo base_url() . "business_profile/insert_comment1" ?>',
                                    data: 'post_id=' + clicked_id + '&comment=' + val,
                                    dataType: "json",
                                    success: function (data) {
                                        $('textarea').each(function () {
                                            $(this).val('');
                                        });


                                        $('.' + 'insertcount' + clicked_id).html(data.count);
                                        $('.' + 'insertcomment1' + clicked_id).html(data.comment);

                                    }
                                });
                                //alert(val);
                            }
                        });
                    });

                }
            </script>


            <!--comment insert script end -->


            <!-- hide and show data start-->
            <script type="text/javascript">
                function commentall(clicked_id) {

                    var x = document.getElementById('threecomment' + clicked_id);
                    var y = document.getElementById('fourcomment' + clicked_id);
                    var z = document.getElementById('insertcount' + clicked_id);


                    $('.post-design-commnet-box').show();
                    if (x.style.display === 'block' && y.style.display === 'none') {


                        x.style.display = 'none';
                        y.style.display = 'block';
                        z.style.visibility = 'show';

                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url() . "business_profile/fourcomment" ?>',
                            data: 'bus_post_id=' + clicked_id,
                            //alert(data);
                            success: function (data) {
                                $('#' + 'fourcomment' + clicked_id).html(data);

                            }
                        });

                    }
                    // } else {
                    //      x.style.display = 'block';
                    //      y.style.display = 'block';
                    //      z.style.display = 'block';

                    //      $.ajax({ 
                    //             type:'POST',
                    //          url:'<?php echo base_url() . "business_profile/fourcomment" ?>',
                    //             data:'art_post_id='+clicked_id,
                    //             //alert(data);
                    //             success:function(data){
                    //       $('#' + 'threecomment' + clicked_id).html(data);

                    //       }
                    //         });
                    // }





                }
            </script>
            <!-- hide and show data end-->


            <!-- comment like script start -->

            <script type="text/javascript">
                function comment_like(clicked_id)
                {
                    //alert(clicked_id);
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() . "business_profile/like_comment" ?>',
                        data: 'post_id=' + clicked_id,
                        success: function (data) { //alert('.' + 'likepost' + clicked_id);
                            $('#' + 'likecomment' + clicked_id).html(data);

                        }
                    });
                }
            </script>


            <script type="text/javascript">
                function comment_like1(clicked_id)
                {
                    //alert(clicked_id);
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() . "business_profile/like_comment1" ?>',
                        data: 'post_id=' + clicked_id,
                        success: function (data) { //alert('.' + 'likepost' + clicked_id);
                            $('#' + 'likecomment1' + clicked_id).html(data);

                        }
                    });
                }
            </script>
            <!--comment like script end -->

            <script type="text/javascript">

                function comment_delete(clicked_id) {
                    $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='comment_deleted(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                    $('#bidmodal').modal('show');
                }


                function comment_deleted(clicked_id)
                {
                    var post_delete = document.getElementById("post_delete" + clicked_id);
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() . "business_profile/delete_comment" ?>',
                        data: 'post_id=' + clicked_id + '&post_delete=' + post_delete.value,
                        dataType: "json",
                        success: function (data) { //alert('.' + 'insertcomment' + clicked_id);
                            // document.getElementById('editcomment' + clicked_id).style.display='none';
                            //document.getElementById('showcomment' + clicked_id).style.display='block';
                            //document.getElementById('editsubmit' + clicked_id).style.display='none';
                            $('.' + 'insertcomment' + post_delete.value).html(data.comment);
                            $('#' + 'insertcount' + post_delete.value).html(data.count);

                            $('.post-design-commnet-box').show();
                        }
                    });
                }

                function comment_deletetwo(clicked_id)
                {

                    $('.biderror .mes').html("<div class='pop_content'>Do you want to delete this comment?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='comment_deletedtwo(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                    $('#bidmodal').modal('show');
                }

                function comment_deletedtwo(clicked_id)
                {

                    var post_delete1 = document.getElementById("post_deletetwo");

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() . "business_profile/delete_commenttwo" ?>',
                        data: 'post_id=' + clicked_id + '&post_delete=' + post_delete1.value,
                        dataType: "json",
                        success: function (data) { //alert('.' + 'insertcomment' + clicked_id);
                            $('.' + 'insertcommenttwo' + post_delete1.value).html(data.comment);
                            $('#' + 'insertcount' + post_delete1.value).html(data.count);

                            $('.post-design-commnet-box').show();
                        }
                    });
                }
            </script>
            <!--comment delete script end -->

            <!-- comment edit box start-->
            <script type="text/javascript">

                function comment_editbox(clicked_id) { //alert(clicked_id); alert('editcomment' + clicked_id); alert('showcomment' + clicked_id); alert('editsubmit' + clicked_id); 
                    document.getElementById('editcomment' + clicked_id).style.display = 'inline-block';
                    document.getElementById('showcomment' + clicked_id).style.display = 'none';
                    document.getElementById('editsubmit' + clicked_id).style.display = 'inline-block';

                    document.getElementById('editcommentbox' + clicked_id).style.display = 'none';
                    document.getElementById('editcancle' + clicked_id).style.display = 'block';

                    $('.post-design-commnet-box').hide();

                }

                function comment_editcancle(clicked_id) {

                    document.getElementById('editcommentbox' + clicked_id).style.display = 'block';
                    document.getElementById('editcancle' + clicked_id).style.display = 'none';

                    document.getElementById('editcomment' + clicked_id).style.display = 'none';
                    document.getElementById('showcomment' + clicked_id).style.display = 'block';
                    document.getElementById('editsubmit' + clicked_id).style.display = 'none';

                    $('.post-design-commnet-box').show();
                }

                function comment_editboxtwo(clicked_id) {
//                    alert(clicked_id);
//                    return false;

                    $('div[id^=editcommenttwo]').css('display', 'none');
                    $('div[id^=showcommenttwo]').css('display', 'block');
                    $('button[id^=editsubmittwo]').css('display', 'none');
                    $('div[id^=editcommentboxtwo]').css('display', 'block');
                    $('div[id^=editcancletwo]').css('display', 'none');

                    document.getElementById('editcommenttwo' + clicked_id).style.display = 'inline-block';
                    document.getElementById('showcommenttwo' + clicked_id).style.display = 'none';
                    document.getElementById('editsubmittwo' + clicked_id).style.display = 'inline-block';
                    document.getElementById('editcommentboxtwo' + clicked_id).style.display = 'none';
                    document.getElementById('editcancletwo' + clicked_id).style.display = 'block';
                    $('.post-design-commnet-box').hide();
//                    document.getElementById('editcomment' + clicked_id).style.display = 'block';
//                    document.getElementById('showcomment' + clicked_id).style.display = 'none';
//                    document.getElementById('editsubmit' + clicked_id).style.display = 'block';
//                    document.getElementById('editcommentbox' + clicked_id).style.display = 'none';
//                    document.getElementById('editcancle' + clicked_id).style.display = 'block';

                }

                function comment_editcancletwo(clicked_id) {
                    document.getElementById('editcommentboxtwo' + clicked_id).style.display = 'block';
                    document.getElementById('editcancletwo' + clicked_id).style.display = 'none';
                    document.getElementById('editcommenttwo' + clicked_id).style.display = 'none';
                    document.getElementById('showcommenttwo' + clicked_id).style.display = 'block';
                    document.getElementById('editsubmittwo' + clicked_id).style.display = 'none';
                    $('.post-design-commnet-box').show();
                }

                function comment_editbox3(clicked_id) { //alert(clicked_id); alert('editcomment' + clicked_id); alert('showcomment' + clicked_id); alert('editsubmit' + clicked_id); 
                    document.getElementById('editcomment3' + clicked_id).style.display = 'block';
                    document.getElementById('showcomment3' + clicked_id).style.display = 'none';
                    document.getElementById('editsubmit3' + clicked_id).style.display = 'block';

                    document.getElementById('editcommentbox3' + clicked_id).style.display = 'none';
                    document.getElementById('editcancle3' + clicked_id).style.display = 'block';
                    $('.post-design-commnet-box').hide();

                }

                function comment_editcancle3(clicked_id) {

                    document.getElementById('editcommentbox3' + clicked_id).style.display = 'block';
                    document.getElementById('editcancle3' + clicked_id).style.display = 'none';

                    document.getElementById('editcomment3' + clicked_id).style.display = 'none';
                    document.getElementById('showcomment3' + clicked_id).style.display = 'block';
                    document.getElementById('editsubmit3' + clicked_id).style.display = 'none';

                    $('.post-design-commnet-box').show();

                }

                function comment_editbox4(clicked_id) { //alert(clicked_id); alert('editcomment' + clicked_id); alert('showcomment' + clicked_id); alert('editsubmit' + clicked_id); 
                    document.getElementById('editcomment4' + clicked_id).style.display = 'block';
                    document.getElementById('showcomment4' + clicked_id).style.display = 'none';
                    document.getElementById('editsubmit4' + clicked_id).style.display = 'block';

                    document.getElementById('editcommentbox4' + clicked_id).style.display = 'none';
                    document.getElementById('editcancle4' + clicked_id).style.display = 'block';

                    $('.post-design-commnet-box').hide();

                }

                function comment_editcancle4(clicked_id) {

                    document.getElementById('editcommentbox4' + clicked_id).style.display = 'block';
                    document.getElementById('editcancle4' + clicked_id).style.display = 'none';

                    document.getElementById('editcomment4' + clicked_id).style.display = 'none';
                    document.getElementById('showcomment4' + clicked_id).style.display = 'block';
                    document.getElementById('editsubmit4' + clicked_id).style.display = 'none';

                    $('.post-design-commnet-box').show();

                }

            </script>

            <!--comment edit box end-->

            <!-- comment edit insert start -->

            <script type="text/javascript">
//                function edit_comment(abc)
//                { 
//                    var post_comment_edit = document.getElementById("editcomment" + abc);
//                    $.ajax({
//                        type: 'POST',
//                        url: '<?php echo base_url() . "business_profile/edit_comment_insert" ?>',
//                        data: 'post_id=' + abc + '&comment=' + post_comment_edit.value,
//                        success: function (data) { //alert('falguni');
//
//                            document.getElementById('editcomment' + abc).style.display = 'none';
//                            document.getElementById('showcomment' + abc).style.display = 'block';
//                            document.getElementById('editsubmit' + abc).style.display = 'none';
//
//                            document.getElementById('editcommentbox' + abc).style.display = 'block';
//                            document.getElementById('editcancle' + abc).style.display = 'none';
//                            $('#' + 'showcomment' + abc).html(data);
//                            $('.post-design-commnet-box').show();
//
//
//                        }
//                    });
//                }

                function edit_comment(abc)
                {
                    //var post_comment_edit = document.getElementById("editcomment" + abc);

                    $("#editcomment" + abc).click(function () {
                        $(this).prop("contentEditable", true);
                        //     $(this).html("");
                    });

                    var sel = $("#editcomment" + abc);
                    var txt = sel.html();
                    txt = txt.replace(/&nbsp;/gi, " ");
                    txt = txt.replace(/<br>$/, '');
                    if (txt == '' || txt == '<br>') {
                        return false;
                    }
                    if (/^\s+$/gi.test(txt))
                    {
                        return false;
                    }
                    txt = txt.replace(/&/g,"%26");
//                    alert(txt);
//                    return false;
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() . "business_profile/edit_comment_insert" ?>',
                        data: 'post_id=' + abc + '&comment=' + txt,
                        success: function (data) { //alert('falguni');

                            document.getElementById('editcomment' + abc).style.display = 'none';
                            document.getElementById('showcomment' + abc).style.display = 'block';
                            document.getElementById('editsubmit' + abc).style.display = 'none';

                            document.getElementById('editcommentbox' + abc).style.display = 'block';
                            document.getElementById('editcancle' + abc).style.display = 'none';
                            $('#' + 'showcomment' + abc).html(data);
                            $('.post-design-commnet-box').show();


                        }
                    });
                    $(".scroll").click(function (event) {
                        event.preventDefault();
                        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
                    });

                }
            </script>


            <script type="text/javascript">

//                function commentedit(abc)
//                {
//                    $(document).ready(function () {
//                        $('#editcomment' + abc).keypress(function (e) {
//                            if (e.keyCode == 13 && !e.shiftKey) {
//                                var val = $('#editcomment' + abc).val();
//                                e.preventDefault();
//                                if (window.preventDuplicateKeyPresses)
//                                    return;
//                                window.preventDuplicateKeyPresses = true;
//                                window.setTimeout(function () {
//                                    window.preventDuplicateKeyPresses = false;
//                                }, 500);
//                                $.ajax({
//                                    type: 'POST',
//                                    url: '<?php echo base_url() . "business_profile/edit_comment_insert" ?>',
//                                    data: 'post_id=' + abc + '&comment=' + val,
//                                    success: function (data) { //alert('falguni');
//                                        document.getElementById('editcomment' + abc).style.display = 'none';
//                                        document.getElementById('showcomment' + abc).style.display = 'block';
//                                        document.getElementById('editsubmit' + abc).style.display = 'none';
//                                        document.getElementById('editcommentbox' + abc).style.display = 'block';
//                                        document.getElementById('editcancle' + abc).style.display = 'none';
//                                        $('#' + 'showcomment' + abc).html(data);
//                                        $('.post-design-commnet-box').show();
//                                    }
//                                });
//                            }
//                        });
//                    });
//                }


                function commentedit(abc)
                {
//                    alert(1212121);
//                    return false;
                    //$(document).ready(function () {

                    $("#editcomment" + abc).click(function () {
                        $(this).prop("contentEditable", true);
                        //$(this).html("");
                    });
                    $('#editcomment' + abc).keypress(function (event) {
                        if (event.which == 13 && event.shiftKey != 1) {
                            event.preventDefault();
                            var sel = $("#editcomment" + abc);
                            var txt = sel.html();
                            txt = txt.replace(/&nbsp;/gi, " ");
                            txt = txt.replace(/<br>$/, '');
                            if (txt == '' || txt == '<br>') {
                                return false;
                            }
                            if (/^\s+$/gi.test(txt))
                            {
                                return false;
                            }
                            txt = txt.replace(/&/g,"%26");
                            //$('#editcomment' + abc).html("");

                            if (window.preventDuplicateKeyPresses)
                                return;
                            window.preventDuplicateKeyPresses = true;
                            window.setTimeout(function () {
                                window.preventDuplicateKeyPresses = false;
                            }, 500);
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo base_url() . "business_profile/edit_comment_insert" ?>',
                                data: 'post_id=' + abc + '&comment=' + txt,
                                success: function (data) { //alert('falguni');
                                    document.getElementById('editcomment' + abc).style.display = 'none';
                                    document.getElementById('showcomment' + abc).style.display = 'block';
                                    document.getElementById('editsubmit' + abc).style.display = 'none';
                                    document.getElementById('editcommentbox' + abc).style.display = 'block';
                                    document.getElementById('editcancle' + abc).style.display = 'none';
                                    $('#' + 'showcomment' + abc).html(data);
                                    $('.post-design-commnet-box').show();
                                }
                            });
                        }
                    });
                    $(".scroll").click(function (event) {
                        event.preventDefault();
                        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
                    });
                    //});
                }


            </script>

            <script type="text/javascript">
//                function edit_commenttwo(abc)
//                { 
//                    var post_comment_edit = document.getElementById("editcommenttwo" + abc);
//                    $.ajax({
//                        type: 'POST',
//                        url: '<?php echo base_url() . "business_profile/edit_comment_insert" ?>',
//                        data: 'post_id=' + abc + '&comment=' + post_comment_edit.value,
//                        success: function (data) { //alert('falguni');
//
//                            document.getElementById('editcommenttwo' + abc).style.display = 'none';
//                            document.getElementById('showcommenttwo' + abc).style.display = 'block';
//                            document.getElementById('editsubmittwo' + abc).style.display = 'none';
//
//                            document.getElementById('editcommentboxtwo' + abc).style.display = 'block';
//                            document.getElementById('editcancletwo' + abc).style.display = 'none';
//                            $('#' + 'showcommenttwo' + abc).html(data);
//                            $('.post-design-commnet-box').show();
//                        }
//                    });
//
//                }

                function edit_commenttwo(abc)
                {
                    //var post_comment_edit = document.getElementById("editcommenttwo" + abc);

                    $("#editcommenttwo" + abc).click(function () {
                        $(this).prop("contentEditable", true);
                        //$(this).html("");
                    });

                    var sel = $("#editcommenttwo" + abc);
                    var txt = sel.html();
                    txt = txt.replace(/&nbsp;/gi, " ");
                    txt = txt.replace(/<br>$/, '');
                    if (txt == '' || txt == '<br>') {
                        return false;
                    }
                    if (/^\s+$/gi.test(txt))
                    {
                        return false;
                    }
                    txt = txt.replace(/&/g,"%26");
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() . "business_profile/edit_comment_insert" ?>',
                        data: 'post_id=' + abc + '&comment=' + txt,
                        success: function (data) { //alert('falguni');

                            document.getElementById('editcommenttwo' + abc).style.display = 'none';
                            document.getElementById('showcommenttwo' + abc).style.display = 'block';
                            document.getElementById('editsubmittwo' + abc).style.display = 'none';

                            document.getElementById('editcommentboxtwo' + abc).style.display = 'block';
                            document.getElementById('editcancletwo' + abc).style.display = 'none';
                            $('#' + 'showcommenttwo' + abc).html(data);
                            $('.post-design-commnet-box').show();
                        }
                    });
                    $(".scroll").click(function (event) {
                        event.preventDefault();
                        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
                    });

                }
            </script>


            <script type="text/javascript">

//                function commentedittwo(abc)
//                {
//                    $(document).ready(function () {
//                        $('#editcommenttwo' + abc).keypress(function (e) {
//                            if (e.keyCode == 13 && !e.shiftKey) {
//                                var val = $('#editcommenttwo' + abc).val();
//                                e.preventDefault();
//
//                                if (window.preventDuplicateKeyPresses)
//                                    return;
//
//                                window.preventDuplicateKeyPresses = true;
//                                window.setTimeout(function () {
//                                    window.preventDuplicateKeyPresses = false;
//                                }, 500);
//
//                                $.ajax({
//                                    type: 'POST',
//                                    url: '<?php echo base_url() . "business_profile/edit_comment_insert" ?>',
//                                    data: 'post_id=' + abc + '&comment=' + val,
//                                    success: function (data) { //alert('falguni');
//
//
//                                        document.getElementById('editcommenttwo' + abc).style.display = 'none';
//                                        document.getElementById('showcommenttwo' + abc).style.display = 'block';
//                                        document.getElementById('editsubmittwo' + abc).style.display = 'none';
//
//                                        document.getElementById('editcommentboxtwo' + abc).style.display = 'block';
//                                        document.getElementById('editcancletwo' + abc).style.display = 'none';
//                                        //alert('.' + 'showcomment' + abc);
//
//                                        $('#' + 'showcommenttwo' + abc).html(data);
//                                        $('.post-design-commnet-box').show();
//
//
//                                    }
//                                });
//                            }
//                        });
//                    });
//
//                }

                function commentedittwo(abc)
                {
                    //$(document).ready(function () {
                    $("#editcommenttwo" + abc).click(function () {
                        $(this).prop("contentEditable", true);
                        //$(this).html("");
                    });

                    $('#editcommenttwo' + abc).keypress(function (event) {
                        if (event.which == 13 && event.shiftKey != 1) {
                            event.preventDefault();

                            var sel = $("#editcommenttwo" + abc);
                            var txt = sel.html();
                            txt = txt.replace(/&nbsp;/gi, " ");
                            txt = txt.replace(/<br>$/, '');
                            if (txt == '' || txt == '<br>') {
                                return false;
                            }
                            if (/^\s+$/gi.test(txt))
                            {
                                return false;
                            }
                            txt = txt.replace(/&/g,"%26");
                            //$('#editcommenttwo' + abc).html("");

                            if (window.preventDuplicateKeyPresses)
                                return;

                            window.preventDuplicateKeyPresses = true;
                            window.setTimeout(function () {
                                window.preventDuplicateKeyPresses = false;
                            }, 500);

                            $.ajax({
                                type: 'POST',
                                url: '<?php echo base_url() . "business_profile/edit_comment_insert" ?>',
                                data: 'post_id=' + abc + '&comment=' + txt,
                                success: function (data) { //alert('falguni');


                                    document.getElementById('editcommenttwo' + abc).style.display = 'none';
                                    document.getElementById('showcommenttwo' + abc).style.display = 'block';
                                    document.getElementById('editsubmittwo' + abc).style.display = 'none';

                                    document.getElementById('editcommentboxtwo' + abc).style.display = 'block';
                                    document.getElementById('editcancletwo' + abc).style.display = 'none';
                                    //alert('.' + 'showcomment' + abc);

                                    $('#' + 'showcommenttwo' + abc).html(data);
                                    $('.post-design-commnet-box').show();


                                }
                            });
                        }
                    });
                    //});
                    $(".scroll").click(function (event) {
                        event.preventDefault();
                        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
                    });

                }
            </script>

            <script type="text/javascript">
                function edit_comment3(abc)
                { //alert('editsubmit' + abc);

                    var post_comment_edit = document.getElementById("editcomment3" + abc);
                    //alert(post_comment.value);
                    //alert(post_comment.value);
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() . "business_profile/edit_comment_insert" ?>',
                        data: 'post_id=' + abc + '&comment=' + post_comment_edit.value,
                        success: function (data) { //alert('falguni');

                            //  $('input').each(function(){
                            //     $(this).val('');
                            // }); 
                            document.getElementById('editcomment3' + abc).style.display = 'none';
                            document.getElementById('showcomment3' + abc).style.display = 'block';
                            document.getElementById('editsubmit3' + abc).style.display = 'none';

                            document.getElementById('editcommentbox3' + abc).style.display = 'block';
                            document.getElementById('editcancle3' + abc).style.display = 'none';
                            //alert('.' + 'showcomment' + abc);
                            $('#' + 'showcomment3' + abc).html(data);
                            $('.post-design-commnet-box').show();


                        }
                    });
                    //window.location.reload();
                }
            </script>


            <script type="text/javascript">

                function commentedit3(abc)
                {
                    $(document).ready(function () {
                        $('#editcomment3' + abc).keypress(function (e) {


                            if (e.keyCode == 13 && !e.shiftKey) {
                                var val = $('#editcomment3' + clicked_id).val();
                                e.preventDefault();

                                if (window.preventDuplicateKeyPresses)
                                    return;

                                window.preventDuplicateKeyPresses = true;
                                window.setTimeout(function () {
                                    window.preventDuplicateKeyPresses = false;
                                }, 500);

                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo base_url() . "business_profile/edit_comment_insert" ?>',
                                    data: 'post_id=' + abc + '&comment=' + val,
                                    success: function (data) { //alert('falguni');

                                        //  $('input').each(function(){
                                        //     $(this).val('');
                                        // }); 
                                        document.getElementById('editcomment3' + abc).style.display = 'none';
                                        document.getElementById('showcomment3' + abc).style.display = 'block';
                                        document.getElementById('editsubmit3' + abc).style.display = 'none';

                                        document.getElementById('editcommentbox3' + abc).style.display = 'block';
                                        document.getElementById('editcancle3' + abc).style.display = 'none';
                                        //alert('.' + 'showcomment' + abc);
                                        $('#' + 'showcomment3' + abc).html(data);



                                    }
                                });

                                //alert(val);
                            }
                        });
                    });

                }
            </script>

            <script type="text/javascript">
                function edit_comment4(abc)
                { //alert('editsubmit' + abc);

                    var post_comment_edit = document.getElementById("editcomment4" + abc);
                    //alert(post_comment.value);
                    //alert(post_comment.value);
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() . "business_profile/edit_comment_insert" ?>',
                        data: 'post_id=' + abc + '&comment=' + post_comment_edit.value,
                        success: function (data) { //alert('falguni');

                            //  $('input').each(function(){
                            //     $(this).val('');
                            // }); 
                            document.getElementById('editcomment4' + abc).style.display = 'none';
                            document.getElementById('showcomment4' + abc).style.display = 'block';
                            document.getElementById('editsubmit4' + abc).style.display = 'none';

                            document.getElementById('editcommentbox4' + abc).style.display = 'block';
                            document.getElementById('editcancle4' + abc).style.display = 'none';
                            //alert('.' + 'showcomment' + abc);
                            $('#' + 'showcomment4' + abc).html(data);



                        }
                    });
                    //window.location.reload();
                }
            </script>

            <script type="text/javascript">

                function commentedit4(abc)
                {
                    $(document).ready(function () {
                        $('#editcomment4' + abc).keypress(function (e) {

                            if (e.keyCode == 13 && !e.shiftKey) {
                                var val = $('#editcomment4' + clicked_id).val();
                                e.preventDefault();

                                if (window.preventDuplicateKeyPresses)
                                    return;

                                window.preventDuplicateKeyPresses = true;
                                window.setTimeout(function () {
                                    window.preventDuplicateKeyPresses = false;
                                }, 500);

                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo base_url() . "business_profile/edit_comment_insert" ?>',
                                    data: 'post_id=' + abc + '&comment=' + val,
                                    success: function (data) { //alert('falguni');

                                        //  $('input').each(function(){
                                        //     $(this).val('');
                                        // }); 
                                        document.getElementById('editcomment4' + abc).style.display = 'none';
                                        document.getElementById('showcomment4' + abc).style.display = 'block';
                                        document.getElementById('editsubmit4' + abc).style.display = 'none';

                                        document.getElementById('editcommentbox4' + abc).style.display = 'block';
                                        document.getElementById('editcancle4' + abc).style.display = 'none';
                                        //alert('.' + 'showcomment' + abc);
                                        $('#' + 'showcomment4' + abc).html(data);



                                    }
                                });

                                //alert(val);
                            }
                        });
                    });

                }
            </script>

            <!-- hide and show data start for save post-->
            <script type="text/javascript">
                function commentall1(clicked_id) { //alert("xyz");

                    //alert(clicked_id);
                    var x = document.getElementById('threecomment1' + clicked_id);
                    var y = document.getElementById('fourcomment1' + clicked_id);
                    if (x.style.display === 'block' && y.style.display === 'none') {
                        x.style.display = 'none';
                        y.style.display = 'block';

                    } else {
                        x.style.display = 'block';
                        y.style.display = 'none';
                    }

                }
            </script>
            <!-- hide and show data end-->

            <!-- like comment ajax data end-->
            <script>
                /* When the user clicks on the button, 
                 toggle between hiding and showing the dropdown content */
                function myFunction1(clicked_id) {
                    
                    var dropDownClass = document.getElementById('myDropdown' + clicked_id).className;
                    dropDownClass = dropDownClass.split(" ").pop(-1);
                    if(dropDownClass != 'show'){
                        $('.dropdown-content2').removeClass('show');
                        $('#myDropdown' + clicked_id).addClass('show');
                    }
                    else{
                        $('.dropdown-content2').removeClass('show');
                    }
                }

                // Close the dropdown if the user clicks outside of it
                window.onclick = function (event) {
                    if (!event.target.matches('.dropbtn1')) {
                        var dropdowns = document.getElementsByClassName("dropdown-content1");
                        var i;
                        for (i = 0; i < dropdowns.length; i++) {
                            var openDropdown = dropdowns[i];
                            if (openDropdown.classList.contains('show')) {
                                openDropdown.classList.remove('show');
                            }
                        }
                    }
                }
            </script>

            <script>
                /* When the user clicks on the button, 
                 toggle between hiding and showing the dropdown content */
                function myFunction(clicked_id) {
                    document.getElementById('myDropdown' + clicked_id).classList.toggle("show");
                }

                // Close the dropdown if the user clicks outside of it
                window.onclick = function (event) {
                    if (!event.target.matches('.dropbtn2')) {

                        var dropdowns = document.getElementsByClassName("dropdown-content2");
                        var i;
                        for (i = 0; i < dropdowns.length; i++) {
                            var openDropdown = dropdowns[i];
                            if (openDropdown.classList.contains('show')) {
                                openDropdown.classList.remove('show');
                            }
                        }
                    }
                }
            </script>

            <!-- drop down script zalak end -->

            <!-- edit post start -->

            <script type="text/javascript">
                function editpost(abc)
                {
                    $("#myDropdown" + abc).removeClass('show');
                    document.getElementById('editpostdata' + abc).style.display = 'none';
                    document.getElementById('editpostbox' + abc).style.display = 'block';
                    document.getElementById('editpostdetails' + abc).style.display = 'none';
                    document.getElementById('editpostdetailbox' + abc).style.display = 'block';
                    document.getElementById('editpostsubmit' + abc).style.display = 'block';
                }
            </script>


            <script type="text/javascript">
                function edit_postinsert(abc)
                {

                    var editpostname = document.getElementById("editpostname" + abc);


                    //var editpostdetails = document.getElementById("editpostdesc" + abc);



                    // start khyati code
                    var $field = $('#editpostname' + abc);
                    //var data = $field.val();
                    var editpostdetails = $('#editpostdesc' + abc).html();
                    
                    editpostdetails = editpostdetails.replace(/&/g,"%26");


                    // $('#editpostdesc' + abc).html("");

                    if (editpostname.value == '' && editpostdetails == '') {
                        $('.biderror .mes').html("<div class='pop_content'>You must either fill title or description.");
                        $('#bidmodal').modal('show');

                        document.getElementById('editpostdata' + abc).style.display = 'block';
                        document.getElementById('editpostbox' + abc).style.display = 'none';
                        document.getElementById('editpostdetails' + abc).style.display = 'block';
                        document.getElementById('editpostdetailbox' + abc).style.display = 'none';

                        document.getElementById('editpostsubmit' + abc).style.display = 'none';

                    } else {

                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url() . "business_profile/edit_post_insert" ?>',
                            data: 'business_profile_post_id=' + abc + '&product_name=' + editpostname.value + '&product_description=' + editpostdetails,
                            dataType: "json",
                            success: function (data) {

                                document.getElementById('editpostdata' + abc).style.display = 'block';
                                document.getElementById('editpostbox' + abc).style.display = 'none';
                                document.getElementById('editpostdetails' + abc).style.display = 'block';
                                document.getElementById('editpostdetailbox' + abc).style.display = 'none';

                                document.getElementById('editpostsubmit' + abc).style.display = 'none';

                                $('#' + 'editpostdata' + abc).html(data.title);
                                $('#' + 'editpostdetails' + abc).html(data.description);
                            }
                        });
                    }
                }
            </script>
            <!-- edit post end -->
            <!-- remove save post start -->
            <script type="text/javascript">
                function remove_post(abc)
                {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() . "business_profile/business_profile_delete" ?>',
                        data: 'save_id=' + abc,
                        success: function (data) {
                            $('#' + 'removepostdata' + abc).html(data);
                        }
                    });
                }
            </script>


            <!-- remove save post start -->

            <script type="text/javascript">
                function remove_ownpost(abc)
                {

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() . "business_profile/business_profile_deletepost" ?>',
                        data: 'business_profile_post_id=' + abc,
                        success: function (data) {
                            //$('#' + 'removeownpost' + abc).html(data);
                            $('#' + 'removeownpost' + abc).remove();


                        }
                    });

                }
            </script>

            <!-- remove save post end -->

            <script>
                // Get the modal
                var modal = document.getElementById('myModal2');

                // Get the button that opens the modal
                var btn = document.getElementById("myBtn1");

                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("close")[0];

                // When the user clicks the button, open the modal 
                btn.onclick = function () {
                    modal.style.display = "block";
                }

                // When the user clicks on <span> (x), close the modal
                span.onclick = function () {
                    modal.style.display = "none";
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function (event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }
            </script>

            <script>
                // Get the modal
                var modal = document.getElementById('myModal3');

                // Get the button that opens the modal
                var btn = document.getElementById("myBtn1");

                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("close3")[0];

                // When the user clicks the button, open the modal 
                btn.onclick = function () {
                    modal.style.display = "block";
                }

                // When the user clicks on <span> (x), close the modal
                span.onclick = function () {
                    modal.style.display = "none";
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function (event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }
            </script>


            <!-- save post start -->

            <script type="text/javascript">
                function save_post(abc)
                {

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() . "business_profile/business_profile_save" ?>',
                        data: 'business_profile_post_id=' + abc,
                        success: function (data) {

                            $('.' + 'savedpost' + abc).html(data);


                        }
                    });

                }
            </script>

            <!-- save post end -->


            <!-- follow user script start -->

            <script type="text/javascript">
                function followuser(clicked_id)
                {

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() . "business_profile/follow" ?>',
                        data: 'follow_to=' + clicked_id,
                        success: function (data) {

                            $('.' + 'fr' + clicked_id).html(data);

                        }
                    });
                }
            </script>

            <!-- follow user script end -->


            <!-- Unfollow user script start -->

            <script type="text/javascript">
                function unfollowuser(clicked_id)
                {

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() . "business_profile/unfollow" ?>',
                        data: 'follow_to=' + clicked_id,
                        success: function (data) {

                            $('.' + 'fr' + clicked_id).html(data);

                        }
                    });
                }
            </script>

            <!-- Unfollow user script end -->

            <!-- post insert developing script start -->
            <script src="<?php echo base_url('js/bootstrap.min.js'); ?>"></script>
            <script type="text/javascript">

                function imgval(event) {


                    //var fileInput = document.getElementById('test-upload');

                    var fileInput = document.getElementById("file-1").files;
                    var product_name = document.getElementById("test-upload_product").value;
                    var product_description = document.getElementById("test-upload_des").value;
                    var product_fileInput = document.getElementById("file-1").value;



                    if (product_fileInput == '' && product_name == '' && product_description == '')
                    {

                        $('.biderror .mes').html("<div class='pop_content'>This post appears to be blank. Please write or attach (photos, videos, audios, pdf) to post.");
                        $('#bidmodal').modal('show');
                        setInterval('window.location.reload()', 10000);
                        // window.location='';
                        event.preventDefault();
                        return false;

                    } else {

                        for (var i = 0; i < fileInput.length; i++)
                        {
                            var vname = fileInput[i].name;
                            var vfirstname = fileInput[0].name;
                            var ext = vfirstname.split('.').pop();
                            var ext1 = vname.split('.').pop();
                            var allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                            var allowesvideo = ['mp4', 'webm'];
                            var allowesaudio = ['mp3'];
                            var allowespdf = ['pdf'];

                            var foundPresent = $.inArray(ext, allowedExtensions) > -1;
                            var foundPresentvideo = $.inArray(ext, allowesvideo) > -1;
                            var foundPresentaudio = $.inArray(ext, allowesaudio) > -1;
                            var foundPresentpdf = $.inArray(ext, allowespdf) > -1;

                            if (foundPresent == true)
                            {
                                var foundPresent1 = $.inArray(ext1, allowedExtensions) > -1;

                                if (foundPresent1 == true && fileInput.length <= 10) {
                                } else {

                                    $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf.");
                                    $('#bidmodal').modal('show');
                                    setInterval('window.location.reload()', 10000);
                                    // window.location='';
                                    event.preventDefault();
                                    return false;
                                }

                            } else if (foundPresentvideo == true)
                            {

                                var foundPresent1 = $.inArray(ext1, allowesvideo) > -1;

                                if (foundPresent1 == true && fileInput.length == 1) {
                                } else {
                                    $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf.");
                                    $('#bidmodal').modal('show');
                                    setInterval('window.location.reload()', 10000);
                                    event.preventDefault();
                                    return false;
                                }
                            } else if (foundPresentaudio == true)
                            {

                                var foundPresent1 = $.inArray(ext1, allowesaudio) > -1;

                                if (foundPresent1 == true && fileInput.length == 1) {
                                } else {
                                    $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf.");
                                    $('#bidmodal').modal('show');
                                    setInterval('window.location.reload()', 10000);
                                    event.preventDefault();
                                    return false;
                                }
                            } else if (foundPresentpdf == true)
                            {

                                var foundPresent1 = $.inArray(ext1, allowespdf) > -1;

                                if (foundPresent1 == true && fileInput.length == 1) {

                                    if (product_name == '') {
                                        $('.biderror .mes').html("<div class='pop_content'>You have to add pdf title.");
                                        $('#bidmodal').modal('show');
                                        setInterval('window.location.reload()', 10000);
                                        event.preventDefault();
                                        return false;
                                    }
                                } else {
                                    $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf.");
                                    $('#bidmodal').modal('show');
                                    setInterval('window.location.reload()', 10000);
                                    event.preventDefault();
                                    return false;
                                }
                            } else if (foundPresentvideo == false) {

                                $('.biderror .mes').html("<div class='pop_content'>This File Format is not supported Please Try to Upload MP4 or WebM files..");
                                $('#bidmodal').modal('show');
                                setInterval('window.location.reload()', 10000);
                                event.preventDefault();
                                return false;

                            }

                        }
                    }
                }

            </script>
            <script type="text/javascript">

                // $(document).ready(function () {
                //     $('.modal-close').on('click', function () {
                //         $('.modal-post').hide();
                //     });
                // });

            </script>

            <!-- post insert developing code end  -->


            <script>
                $(function () {
//                    var showTotalChar = 200, showChar = "More", hideChar = "Less";
                    var showTotalChar = 250, showChar = "More", hideChar = "";
                    $('.show').each(function () {
                        //var content = $(this).text();
                        var content = $(this).html();
                        if (content.length > showTotalChar) {
                            var con = content.substr(0, showTotalChar);
                            var hcon = content.substr(showTotalChar, content.length - showTotalChar);
                            var txt = con + '<span class="dots">...</span><span class="morectnt"><span>' + hcon + '</span>&nbsp;&nbsp;<a href="" class="showmoretxt">' + showChar + '</a></span>';
                            $(this).html(txt);
                        }
                    });
                    $(".showmoretxt").click(function () {
                        if ($(this).hasClass("sample")) {
                            $(this).removeClass("sample");
                            $(this).text(showChar);
                        } else {
                            $(this).addClass("sample");
                            $(this).text(hideChar);
                        }
                        $(this).parent().prev().toggle();
                        $(this).prev().toggle();
                        return false;
                    });
                });
            </script>

            <script language=JavaScript>
                function check_length(my_form) {
                    maxLen = 50; // max number of characters allowed
                    if (my_form.my_text.value.length > maxLen) {
                        // Alert message if maximum limit is reached. 
                        // If required Alert can be removed. 
                        var msg = "You have reached your maximum limit of characters allowed";
                        //alert(msg);

                        $('.biderror .mes').html("<div class='pop_content'>" + msg + "</div>");
                        $('#bidmodal').modal('show');

                        // Reached the Maximum length so trim the textarea
                        my_form.my_text.value = my_form.my_text.value.substring(0, maxLen);
                    } else { // Maximum length not reached so update the value of my_text counter
                        my_form.text_num.value = maxLen - my_form.my_text.value.length;
                    }
                }
            </script>
            <script type="text/javascript">
                function contentedit(clicked_id) {
                    //alert(clicked_id);

//var $field = $('#post_comment' + clicked_id);
                    //var data = $field.val();
                    // var post_comment = $('#post_comment' + clicked_id).html();

                    //$(document).ready(function($) {
                    $("#post_comment" + clicked_id).click(function () {
                        $(this).prop("contentEditable", true);
                        $(this).html("");
                    });


                    $("#post_comment" + clicked_id).keypress(function (event) { //alert(post_comment);
                        if (event.which == 13 && event.shiftKey != 1) { //alert(post_comment);
                            event.preventDefault();
                            var sel = $("#post_comment" + clicked_id);
                            var txt = sel.html();
                            txt = txt.replace(/&/g,"%26");
                            $('#post_comment' + clicked_id).html("");
                            // $("#result").html(txt);
                            // sel.html("")
                            // sel.blur();


                            var x = document.getElementById('threecomment' + clicked_id);
                            var y = document.getElementById('fourcomment' + clicked_id);
                            if (x.style.display === 'block' && y.style.display === 'none') {
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo base_url() . "business_profile/insert_commentthree" ?>',
                                    data: 'post_id=' + clicked_id + '&comment=' + txt,
                                    dataType: "json",
                                    success: function (data) {
                                        $('input').each(function () {
                                            $(this).val('');
                                        });
                                        //  $('.insertcomment' + clicked_id).html(data);
                                        $('#' + 'insertcount' + clicked_id).html(data.count);
                                        $('.insertcomment' + clicked_id).html(data.comment);
                                    }
                                });
                            } else {
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo base_url() . "business_profile/insert_comment" ?>',
                                    data: 'post_id=' + clicked_id + '&comment=' + val,
                                    // dataType: "json",
                                    success: function (data) {
                                        $('input').each(function () {
                                            $(this).val('');
                                        }
                                        );
                                        $('#' + 'fourcomment' + clicked_id).html(data);
                                        // $('#' + 'commnetpost' + clicked_id).html(data.count);
                                        //  $('#' + 'fourcomment' + clicked_id).html(data.comment);
                                    }
                                });
                            }

                        }
                    });
                    $(".scroll").click(function (event) {
                        event.preventDefault();
                        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1200);
                    });

                    // });

                }
            </script>
            <script type="text/javascript">
                function likeuserlist(post_id) {

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() . "business_profile/likeuserlist" ?>',
                        data: 'post_id=' + post_id,
                        dataType: "html",
                        success: function (data) {
                            var html_data = data;
                            $('#likeusermodal .mes').html(html_data);
                            $('#likeusermodal').modal('show');
                        }
                    });


                }
            </script>


            <style type="text/css">
                .likeduser{
                    width: 100%;
                    background-color: #1b8ab9;
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
                    /*  margin-left: 15px;
                    */  /*  margin-right: 15px;*/

                }

            </style>

            <!-- cover image start -->
            <script>
                function myFunction() {
                    document.getElementById("upload-demo").style.visibility = "hidden";
                    document.getElementById("upload-demo-i").style.visibility = "hidden";
                    document.getElementById('message1').style.display = "block";
                }


                function showDiv() {
                    document.getElementById('row1').style.display = "block";
                    document.getElementById('row2').style.display = "none";
                }
            </script>


            <script type="text/javascript">
                jQuery.noConflict();

                (function ($) {
                    $uploadCrop = $('#upload-demo').croppie({
                        enableExif: true,
                        viewport: {
                            width: 1250,
                            height: 350,
                            type: 'square'
                        },
                        boundary: {
                            width: 1250,
                            height: 350
                        }
                    });



                    $('.upload-result').on('click', function (ev) {
                        $uploadCrop.croppie('result', {
                            type: 'canvas',
                            size: 'viewport'
                        }).then(function (resp) {

                            $.ajax({
                                url: "<?php echo base_url() ?>business_profile/ajaxpro",
                                type: "POST",
                                data: {"image": resp},
                                success: function (data) {
                                    html = '<img src="' + resp + '" />';
                                    if (html)
                                    {
                                        window.location.reload();
                                    }

                                }
                            });

                        });
                    });

                    $('.cancel-result').on('click', function (ev) {
                        document.getElementById('row2').style.display = "block";
                        document.getElementById('row1').style.display = "none";
                        document.getElementById('message1').style.display = "none";
                    });

                    //aarati code start
                    $('#upload').on('change', function () {



                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $uploadCrop.croppie('bind', {
                                url: e.target.result
                            }).then(function () {
                                console.log('jQuery bind complete');
                            });

                        }
                        reader.readAsDataURL(this.files[0]);



                    });

                    $('#upload').on('change', function () {

                        var fd = new FormData();
                        fd.append("image", $("#upload")[0].files[0]);

                        files = this.files;
                        size = files[0].size;



                        if (size > 4194304)
                        {
                            //show an alert to the user
                            alert("Allowed file size exceeded. (Max. 4 MB)")

                            document.getElementById('row1').style.display = "none";
                            document.getElementById('row2').style.display = "block";


                            //reset file upload control
                            return false;
                        }

                        $.ajax({

                            url: "<?php echo base_url(); ?>business_profile/imagedata",
                            type: "POST",
                            data: fd,
                            processData: false,
                            contentType: false,
                            success: function (response) {


                            }
                        });
                    });
                })(jQuery);
                //aarati code end
            </script>
            <!-- cover image end -->

            <!-- post delete login user script start -->
            <script type="text/javascript">
                function user_postdelete(clicked_id)
                {
                    $('.biderror .mes').html("<div class='pop_content'> Do you want to delete this post?<div class='model_ok_cancel'><a class='okbtn' id=" + clicked_id + " onClick='remove_ownpost(" + clicked_id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                    $('#bidmodal').modal('show');
                }
            </script>
            <!-- post delete login user end -->
            <!-- This  script use for close dropdown in every post -->
            <script type="text/javascript">
                $('body').on("click", "*", function (e) {
                    var classNames = $(e.target).attr("class").toString().split(' ').pop();
                    if (classNames != 'fa-ellipsis-v') {
                        $('div[id^=myDropdown]').hide().removeClass('show');
                    }

                });

            </script>
            <!-- This  script use for close dropdown in every post -->

            <!-- script for profile pic strat -->
            <script type="text/javascript">


                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function (e) {

                            document.getElementById('preview').style.display = 'block';
                            $('#preview').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(input.files[0]);
                    }
                }

                $("#profilepic").change(function () {
                    readURL(this);
                });
            </script>

            <!-- script for profile pic end -->

            <script type="text/javascript" src="<?php echo base_url('js/jquery.validate.min.js'); ?>"></script>


            <script type="text/javascript">

                //validation for edit email formate form

                $(document).ready(function () {

                    $("#userimage").validate({

                        rules: {

                            profilepic: {

                                required: true,

                            },

                        },

                        messages: {

                            profilepic: {

                                required: "Photo Required",

                            },

                        },

                    });
                });
            </script>


            <script language="javascript" type="text/javascript">
//                $(document).ready(function () {
//                    $('.alert-danger1').delay(3000).hide('700');
//                });
            </script>

            <script>
                $(document).ready(function () {
                    $('.video').mediaelementplayer({
                        alwaysShowControls: false,
                        videoVolume: 'horizontal',
                        features: ['playpause', 'progress', 'volume', 'fullscreen']
                    });
                });
            </script>
            
            <script type="text/javascript">
                $(document).keydown(function (e) {
                    if (!e)
                        e = window.event;
                    if (e.keyCode == 27 || e.charCode == 27) {
                        document.getElementById('myModal3').style.display = "none";
                    }
                });


            </script>
            <script>


// pop up open & close aarati code start 
jQuery(document).mouseup(function (e) {
            //var container3 = $("#myBtn1");
             var container1 = $("#myModal3");
            //container.show();
            
                //alert('bb');
                container1.show();
                if( container1.show()) 

                {
                     jQuery(document).mouseup(function (e) {
                    var container = $("#close");

            //container.show();
            if (!container.is(e.target) // if the target of the click isn't the container...
                && container.has(e.target).length === 0) // ... nor a descendant of the container
            {
               // alert('aa');
                container1.hide();
            }
        });
                }
        
        });

// pop up open & close aarati code end

 
// $('#myModal3').click(function(event){
//      event.stopPropagation();
// });
    
            </script>
            
<script type="text/javascript">

    var _onPaste_StripFormatting_IEPaste = false;

    function OnPaste_StripFormatting(elem, e) {

        if (e.originalEvent && e.originalEvent.clipboardData && e.originalEvent.clipboardData.getData) {
            e.preventDefault();
            var text = e.originalEvent.clipboardData.getData('text/plain');
            window.document.execCommand('insertText', false, text);
        } else if (e.clipboardData && e.clipboardData.getData) {
            e.preventDefault();
            var text = e.clipboardData.getData('text/plain');
            window.document.execCommand('insertText', false, text);
        } else if (window.clipboardData && window.clipboardData.getData) {
            // Stop stack overflow
            if (!_onPaste_StripFormatting_IEPaste) {
                _onPaste_StripFormatting_IEPaste = true;
                e.preventDefault();
                window.document.execCommand('ms-pasteTextOnly', false);
            }
            _onPaste_StripFormatting_IEPaste = false;
        }

    }

</script>