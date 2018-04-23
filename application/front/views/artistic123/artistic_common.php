    <div class="container" id="paddingtop_fixed_art">
       <div class="row" id="row1" style="display:none;">
            <div class="col-md-12 text-center padding_less_left">
                <div id="upload-demo" ></div>
            </div>
            <div class="col-md-12 cover-pic" >
                <button class="btn btn-success cancel-result" onclick="" >Cancel</button>

                <button class="btn btn-success set-btn upload-result">Save</button>

                <div id="message1" style="display:none;">
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
            <div class="col-md-12"  style="visibility: hidden; ">
                <div id="upload-demo-i" ></div>
            </div>
        </div>


        <div class="">
            <div class="" id="row2">
                <?php
                $userid = $this->session->userdata('aileenuser');
                $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
                $slugid = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($this->uri->segment(3) == $slugid[0]['slug']) {
                    $user_id = $slugid[0]['slug'];
                } elseif ($this->uri->segment(3) == "") {
                    $user_id = $slugid[0]['slug'];
                } else {
                    $user_id = $this->uri->segment(3);
                }
                $contition_array = array('slug' => $user_id, 'is_delete' => '0', 'status' => '1');
                $image = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'profile_background', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $image_ori = $image[0]['profile_background'];
                if ($image_ori) {
                    ?>
                    <?php 

if (!file_exists($this->config->item('art_bg_main_upload_path') . $image[0]['profile_background'])) {
  ?>
        <div class="bg-images no-cover-upload">
       <img src="<?php echo base_url(WHITEIMAGE); ?>" name="image_src" id="image_src" alt="WHITE IMAGE" />  </div>            
<?php }else{?>

                   <!--  <img src="<?php echo base_url($this->config->item('art_bg_main_upload_path') . $image[0]['profile_background']); ?>" name="image_src" id="image_src" / > -->

                    <img src="<?php echo ART_BG_MAIN_UPLOAD_URL.$image[0]['profile_background']; ?>" name="image_src" id="image_src" / >
                    <?php }?>
                    
                    <?php
                } else {
                    ?>
                     <div class="bg-images no-cover-upload">
                         <img src="<?php echo base_url(WHITEIMAGE); ?>" name="image_src" id="image_src" alt="WHITE IMAGE" />
                     </div>
                     <?php }
                     ?>

            </div>
        </div>
    </div>





<div class="container tablate-container art-profile"> 

    <?php
    $userid = $this->session->userdata('aileenuser');
    if ($artisticdata[0]['user_id'] == $userid) {
        ?>   
        <div class="upload-img">
            <label class="cameraButton"> <span class="tooltiptext">Upload Cover Photo</span> <i class="fa fa-camera" aria-hidden="true"></i>
                <input type="file" id="upload" name="upload" accept="image/*;capture=camera" onclick="showDiv()">
            </label>
        </div>
    <?php } ?>

            <div class="profile-photo">
           <?php
                                $userid = $this->session->userdata('aileenuser');
                                if ($userid != $artisticdata[0]['user_id']) {
                                    ?>      
   <div class="buisness-menu other-profile-menu">
    <?php }else{?>
<div class="buisness-menu">
    <?php }?>

                    <div class="profile-pho-bui">

                        <div class="user-pic padd_img">

                 <?php 

                        if (IMAGEPATHFROM == 'upload') {


                                if($artisticdata[0]['art_user_image']){
                                    if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $artisticdata[0]['art_user_image'])) { ?>
                                       
                                        <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="">
                                        
                                    <?php } else { ?>
                                        <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $artisticdata[0]['art_user_image']; ?>"  alt="">
                                   <?php } }else{ ?>
                                    <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="">
                                  <?php }
                                } else{

                      $filename = $this->config->item('art_profile_thumb_upload_path') . $artisticdata[0]['art_user_image'];
                      $s3 = new S3(awsAccessKey, awsSecretKey);
                     $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);

                   if ($info) { ?>
                 <img src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $artisticdata[0]['art_user_image']; ?>" alt="" >
                <?php
                } else { ?>

                    <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="">
                       <?php } }?>

                <?php
                $userid = $this->session->userdata('aileenuser');
                if ($artisticdata[0]['user_id'] == $userid) {
                    ?>                                                                                                                                    
                    <a class="cusome_upload" href="javascript:void(0);" onclick="updateprofilepopup();"><img src="<?php echo base_url(); ?>assets/img/cam.png"> Update Profile Picture</a>
                <?php } ?>
               </div>

        </div>

          <div class="business-profile-right">
                        <div class="bui-menu-profile">


                            <div class="profile-left">
         <h4 class="profile-head-text"><a href="<?php echo site_url('artistic/dashboard/' . $artisticdata[0]['slug']); ?>">
                <?php echo ucfirst(strtolower($artisticdata[0]['art_name'])) . ' ' . ucfirst(strtolower($artisticdata[0]['art_lastname'])); ?></a>
</h4>
            <!-- text head start -->
              <h4 class="profile-head-text_dg">

                <?php
                if ($artisticdata[0]['designation'] == '') {
                    ?>

                    <?php if ($artisticdata[0]['user_id'] == $userid) { ?>
                        <a id="designation" class="designation" title="Designation">Current Work    </a>

                    <?php } else{?>
                    <a>Current Work </a>
                    <?php }?>

                <?php } else { ?> 

                    <?php if ($artisticdata[0]['user_id'] == $userid) { ?>

                        <a id="designation" class="designation" title="<?php echo ucfirst(strtolower($artisticdata[0]['designation'])); ?>">
                            <?php echo ucfirst(strtolower($artisticdata[0]['designation'])); ?>

                        </a>

                                        <!-- <a id="myBtn"><?php echo ucwords($artisticdata[0]['designation']); ?></a> -->
                    <?php } else { ?>
                        <a><?php echo ucfirst(strtolower($artisticdata[0]['designation'])); ?></a>
                    <?php } ?>

                <?php } ?>


            </h4>

        </div>

        </div>
             <!-- menubar -->
                        <div class="business-data-menu padding_less_right ">

                            <div class="profile-main-box-buis-menu ml0"> 
               <?php 
               $userid = $this->session->userdata('aileenuser');
               if($artisticdata[0]['user_id'] == $userid){
               
               ?>     
             <ul class="current-user pro-fw">
                   
                   <?php }else{?>
                 <ul class="pro-fw4">
                   <?php } ?>  

                    <li <?php if ($this->uri->segment(1) == 'artistic' && $this->uri->segment(2) == 'dashboard') { ?> class="active" <?php } ?>><a title="Dashboard" href="<?php echo base_url('artistic/dashboard/' . $artisticdata[0]['slug']); ?>"> Dashboard</a>
                    </li>

                    <li <?php if ($this->uri->segment(1) == 'artistic' && $this->uri->segment(2) == 'details') { ?> class="active" <?php } ?>><a title="Details" href="<?php echo base_url('artistic/details/' . $artisticdata[0]['slug']); ?>"> Details</a>
                    </li>


                    <?php
                    $userid = $this->session->userdata('aileenuser');
                    if ($artisticdata[0]['user_id'] == $userid) {
                        ?> 

                        <!-- <li <?php if ($this->uri->segment(1) == 'artistic' && $this->uri->segment(2) == 'userlist') { ?> class="active" <?php } ?>><a title="Userlist" href="<?php echo base_url('artistic/userlist'); ?>">Userlist<br> (<?php echo (count($userlistcount)); ?>)</a>
                        </li> -->
                    <?php } ?>


                    <?php
                    $userid = $this->session->userdata('aileenuser');
                    if ($artisticdata[0]['user_id'] == $userid) {
                        ?>
                        <li <?php if ($this->uri->segment(1) == 'artistic' && $this->uri->segment(2) == 'followers') { ?> class="active" <?php } ?>><a title="Followers" href="<?php echo base_url('artistic/followers'); ?>">Followers <br> (<?php echo $flucount; ?>)</a>
                        </li>
                        <?php
                    } else {

                        $artregid = $artisticdata[0]['art_id'];
                        $contition_array = array('follow_to' => $artregid, 'follow_status' => '1', 'follow_type' => '1');
                        $followerotherdata = $this->data['followerotherdata'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


                        foreach ($followerotherdata as $followkey) {

                      $contition_array = array('art_id' => $followkey['follow_from'], 'status' => '1');
                      $artaval = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                      if($artaval){

                      $countdata[] =  $artaval;
                         }
                     }
                       $count = count($countdata);


                        ?> 
                        <li <?php if ($this->uri->segment(1) == 'artistic' && $this->uri->segment(2) == 'followers') { ?> class="active" <?php } ?>><a  title="Followers" href="<?php echo base_url('artistic/followers/' . $artisticdata[0]['slug']); ?>">Followers <br> (<?php echo ($count); ?>)</a>
                        </li>

                    <?php } ?> 
                    <?php
                    if ($artisticdata[0]['user_id'] == $userid) {
                        ?>        
                        <li <?php if ($this->uri->segment(1) == 'artistic' && $this->uri->segment(2) == 'following') { ?> class="active" <?php } ?>><a title="Following" href="<?php echo base_url('artistic/following'); ?>">Following <br> <div id="countfollow">(<?php echo $countfr; ?>)</div></a>
                        </li>
                        <?php
                    } else {

                        $artregid = $artisticdata[0]['art_id'];
                        $contition_array = array('follow_from' => $artregid, 'follow_status' => '1', 'follow_type' => '1');
                        $followingotherdata = $this->data['followingotherdata'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                         foreach ($followingotherdata as $followkey) {

                      $contition_array = array('art_id' => $followkey['follow_to'], 'status' => '1');
                      $artaval = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                      if($artaval){

                      $countfo[] =  $artaval;
                         }
                     }
                       $countfo = count($countfo);

                       
                        ?>
                        <li <?php if ($this->uri->segment(1) == 'artistic' && $this->uri->segment(2) == 'following') { ?> class="active" <?php } ?>><a title="Following" href="<?php echo base_url('artistic/following/' . $artisticdata[0]['slug']); ?>">Following <br>  (<?php echo $countfo; ?>)</a>
                        </li> 
                    <?php } ?>  



                </ul>


            <?php
            $userid = $this->session->userdata('aileenuser');
            if ($artisticdata[0]['user_id'] != $userid) {
                ?>
               
                    <div class="flw_msg_btn fr">
                        <ul>

                            <li class="<?php echo "fruser" . $artisticdata[0]['art_id']; ?>">

                                <?php
                                $userid = $this->session->userdata('aileenuser');

                                $contition_array = array('user_id' => $userid, 'status' => '1');

                                $bup_id = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                $status = $this->db->select('follow_status')->get_where('follow', array('follow_type' => 1, 'follow_from' => $bup_id[0]['art_id'], 'follow_to' => $artisticdata[0]['art_id']))->row()->follow_status;
                                //echo "<pre>"; print_r($status); die();

                                if ($status == 0 || $status == " ") {
                                    ?>

                                    <div id= "followdiv">
                                        <button id="<?php echo "follow" . $artisticdata[0]['art_id']; ?>" onClick="followuser(<?php echo $artisticdata[0]['art_id']; ?>)">Follow</button>
                                    </div>
                                <?php } elseif ($status == 1) { ?>
                                    <div id= "unfollowdiv">
                                        <button class="bg_following" id="<?php echo "unfollow" . $artisticdata[0]['art_id']; ?>" onClick="unfollowuser(<?php echo $artisticdata[0]['art_id']; ?>)"> Following</button>
                                    </div>


                                <?php } ?>
                            </li>

                            <li>

                                <?php
                                $userid = $this->session->userdata('aileenuser');
                                if ($userid != $artisticdata[0]['user_id']) {
                                    ?>
                                <li> <a href="<?php echo base_url('chat/abc/6/6/' . $artisticdata[0]['user_id']); ?>">Message</a> </li>
                            <?php } ?>
                        </ul>
                    </div>
           
            <?php } ?>

        </div>  
        <!-- menubar -->      
        
    </div>
</div>
     

</div>

</div>
</div>