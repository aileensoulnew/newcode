<?php
$s3 = new S3(awsAccessKey, awsSecretKey);
?>
<div class="container" id="paddingtop_fixed">
    <div class="row" id="row1" style="display:none;">
        <div class="col-md-12 text-center">
            <div id="upload-demo" ></div>
        </div>
        <div class="col-md-12 cover-pic" >
            <button class="btn btn-success cancel-result" onclick="">Cancel</button>
            <button class="btn btn-success upload-result fr" onclick="myFunction()">Save</button>
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
        <div class="col-md-12" style="visibility: hidden;">
            <div id="upload-demo-i"></div>
        </div>
    </div>
    <div class="">
        <div id="row2">
            <?php
            $segment3 = explode('-', $this->uri->segment(3));
            $slugdata = array_reverse($segment3);
            $regid = $slugdata[0];     

           $userid = $this->db->select('user_id')->get_where('art_reg', array('art_id' => $regid))->row()->user_id;
            
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $image = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'profile_background', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $image_ori = $image[0]['profile_background'];
               ?>
            <?php  
       
            if ($image_ori) { 
                ?>                                                    
                <img src="<?php echo ART_BG_MAIN_UPLOAD_URL . $image[0]['profile_background'] ?>" name="image_src" id="image_src" alt="<?php echo  $image[0]['profile_background']; ?>"/>
                <?php
            } else { 
                ?>
                <div class="bg-images no-cover-upload">
                    <img src="<?php echo base_url(WHITEIMAGE); ?>" name="image_src" id="image_src" alt="NO IMAGE"/>
                </div>
            <?php } 
            ?>
        </div>
    </div>
</div>
<div class="container tablate-container">
    <div class="profile-photo">
        
                <div class="buisness-menu other-profile-menu">
                   
                <!--PROFILE PIC START-->
                <div class="profile-pho-bui">
                    <div class="user-pic padd_img">
                    <?php 
                        if (IMAGEPATHFROM == 'upload') {
                                if($artisticdata[0]['art_user_image']){
                                    if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $artisticdata[0]['art_user_image'])) { ?>
                                       
                                        <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="NOARTIMAGE">
                                        
                                    <?php } else { ?>
                                        <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $artisticdata[0]['art_user_image']; ?>"  alt="<?php echo $artisticdata[0]['art_user_image'];?>">
                                   <?php } }else{ ?>
                                    <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="NOARTIMAGE">
                                  <?php }
                                } else{

                      $filename = $this->config->item('art_profile_thumb_upload_path') . $artisticdata[0]['art_user_image'];
                      $s3 = new S3(awsAccessKey, awsSecretKey);
                     $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);

                   if ($info) { ?>
                 <img src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $artisticdata[0]['art_user_image']; ?>" alt="<?php echo $artisticdata[0]['art_user_image']; ?>" >
                <?php
                } else { ?>

                    <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="NOARTIMAGE">
                       <?php } }?>
                    </div>
                </div>
                <!--PROFILE PIC START-->
                <div class="business-profile-right">
                    <div class="bui-menu-profile">
                        <div class="profile-left">
                            <h4 class="profile-head-text"><a href="javascript:void(0);" title="<?php echo ucfirst(strtolower($artisticdata[0]['art_name'])) . ' ' . ucfirst(strtolower($artisticdata[0]['art_lastname'])); ?>" onclick="login_profile();">
                                 <?php echo ucfirst(strtolower($artisticdata[0]['art_name'])) . ' ' . ucfirst(strtolower($artisticdata[0]['art_lastname'])); ?></a>
                            </h4>

                            <h4 class="profile-head-text_dg">
                                

                 <?php
                if ($artisticdata[0]['designation'] == '') {
                    ?>

                    <?php if ($artisticdata[0]['user_id'] == $userid) { ?>
                        <a id="designation" class="designation" title="Designation" title="Current Work">Current Work </a>

                    <?php } else{?>
                    <a title="Current Work">Current Work </a>
                    <?php }?>

                <?php } else { ?> 

                    <?php if ($artisticdata[0]['user_id'] == $userid) { ?>

                        <a id="designation" class="designation" title="<?php echo ucfirst(strtolower($artisticdata[0]['designation'])); ?>">
                            <?php echo ucfirst(strtolower($artisticdata[0]['designation'])); ?>

                        </a>

                    <?php } else { ?>
                        <a title="<?php echo ucfirst(strtolower($artisticdata[0]['designation'])); ?>"><?php echo ucfirst(strtolower($artisticdata[0]['designation'])); ?></a>
                    <?php } ?>

                <?php } ?>

                            </h4>
                        </div>
                    </div>
                    <!-- PICKUP -->
                    <!-- menubar -->
                    <div class="business-data-menu padding_less_right ">
                        <div class="profile-main-box-buis-menu">  

                           <ul class="pro-fw4">               
                    <li <?php if ($this->uri->segment(1) == 'artist' && $this->uri->segment(2) == 'dashboard') { ?> class="active" <?php } ?>><a title="Dashboard" href="javascript:void(0);" onclick="login_profile();"> Dashboard</a>
                    </li>

                    <li <?php if ($this->uri->segment(1) == 'artist' && $this->uri->segment(2) == 'details') { ?> class="active" <?php } ?>><a title="Details" href="javascript:void(0);" onclick="login_profile();"> Details</a>
                    </li>
                   <?php
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
                        <li <?php if ($this->uri->segment(1) == 'artistic' && $this->uri->segment(2) == 'followers') { ?> class="active" <?php } ?>><a  title="Followers" href="javascript:void(0);" onclick="login_profile();">Followers <br> (<?php echo ($count); ?>)</a>
                        </li>
                      <?php
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
                        <li <?php if ($this->uri->segment(1) == 'artistic' && $this->uri->segment(2) == 'following') { ?> class="active" <?php } ?>><a title="Following" href="javascript:void(0);" onclick="login_profile();">Following <br>  (<?php echo $countfo; ?>)</a>
                        </li> 
                </ul>

                    <div class="flw_msg_btn fr">
                        <ul>
                            <li class="<?php echo "fruser" . $artisticdata[0]['art_id']; ?>">
                                    <div id= "followdiv">
                                        <button id="<?php echo "follow" . $artisticdata[0]['art_id']; ?>" onclick="login_profile();">Follow</button>
                                    </div>
                            </li>
                            <li>
                                <?php
                                $userid = $this->session->userdata('aileenuser');
                                if ($userid != $artisticdata[0]['user_id']) {
                                    ?>
                                <li> <a onclick="login_profile();" title="Message">Message</a> </li>
                            <?php } ?>
                        </ul>
                    </div>
           
                        </div>
                    </div>
                </div>
                <!-- pickup -->
            </div>
        </div>
    </div>
    