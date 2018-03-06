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
                <img src="<?php echo BUS_BG_MAIN_UPLOAD_URL . $image[0]['profile_background'] ?>" name="image_src" id="image_src" alt="Profile Background Image" />
                <?php
            } else {
                ?>
                <div class="bg-images no-cover-upload">
                    <img src="<?php echo base_url(WHITEIMAGE); ?>" name="image_src" id="image_src" alt="White Image"/>
                </div>
            <?php }
            ?>
        </div>
    </div>
</div>
<div class="container tablate-container">
    <div class="profile-photo">
        <?php
        $userid = $this->session->userdata('aileenuser');
        if ($business_common_data[0]['user_id'] == $userid) {
            ?>  
            <div class="buisness-menu">
                <?php
            } else {
                ?>
                <div class="buisness-menu other-profile-menu">
                    <?php
                }
                ?>
                <div class="profile-pho-bui">
                    <div class="user-pic padd_img">
                        <?php if ($business_common_data[0]['business_user_image'] != '') { ?>
                            <?php
                            if (IMAGEPATHFROM == 'upload') {
                                if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_common_data[0]['business_user_image'])) {
                                    ?>
                                    <img src="<?php echo base_url(NOBUSIMAGE); ?>" alt="No Business Image" >
                                <?php } else {
                                    ?>
                                    <img src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_common_data[0]['business_user_image']; ?>" alt="Business User Image" >
                                    <?php
                                }
                            } else {
                                $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_common_data[0]['business_user_image'];
                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                if (!$info) {
                                    ?>
                                    <img src="<?php echo base_url(NOBUSIMAGE); ?>" alt="No Business Image" >
                                <?php } else {
                                    ?>
                                    <img src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_common_data[0]['business_user_image']; ?>" alt="Business User Image" >
                                    <?php
                                }
                            }
                        } else {
                            ?>
                            <img src="<?php echo base_url(NOBUSIMAGE); ?>" alt="No Business Image" >
                        <?php } ?>
                    </div>
                </div>
                <div class="business-profile-right">
                    <div class="bui-menu-profile">
                        <div class="profile-left">
                            <h1 class="profile-head-text"><a href="<?php echo base_url('business-profile/details/' . $business_common_data[0]['business_slug'] . ''); ?>"> <?php echo ucfirst($business_common_data[0]['company_name']); ?></a></h1>
                            <h2 class="profile-head-text_dg"><a href="<?php echo base_url('business-profile/details/' . $business_common_data[0]['business_slug'] . ''); ?>"> 
                                    <?php
                                    if ($business_common_data[0]['industriyal']) {
                                        echo $industry_type = $this->db->get_where('industry_type', array('industry_id' => $business_common_data[0]['industriyal']))->row()->industry_name;
                                    }
                                    if ($business_common_data[0]['other_industrial']) {
                                        if ($industry_type == '') {
                                            echo ucfirst(strtolower($business_common_data[0]['other_industrial']));
                                        }
                                    }
                                    ?>
                                </a></h2>
                        </div>
                        <?php
                        $userid = $this->session->userdata('aileenuser');
                        if ($business_common_data[0]['user_id'] != $userid) {
                            ?> 
                            <div id="contact_per">
                                <?php
                                $userid = $this->session->userdata('aileenuser');
                                $busotherid = $this->uri->segment(3);
                                $contition_array = array('business_slug' => $busotherid, 'status' => '1');
                                $busineslug = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                $busuid = $busineslug[0]['user_id'];

                                $contition_array = array('contact_type' => '2');
                                $search_condition = "((contact_to_id = '$busuid' AND contact_from_id = ' $userid') OR (contact_from_id = '$busuid' AND contact_to_id = '$userid'))";
                                $contactperson = $this->common->select_data_by_search('contact_person', $search_condition, $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = '', $groupby = '');
                                ?>

                                <?php if ($contactperson[0]['status'] == 'cancel' || $contactperson[0]['status'] == '' || $contactperson[0]['status'] == 'reject') { ?>
                                    <a href="javascript:void(0);" onclick="open_profile();">

                                    <?php } elseif ($contactperson[0]['status'] == 'pending' || $contactperson[0]['status'] == 'confirm') { ?>   
                                        <a onclick="open_profile();" href="javascript:void(0);">
                                        <?php } ?>

                                        <?php if ($contactperson[0]['status'] == 'cancel') { ?> 
                                            <div>   
                                                <div class="add-contact">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                    <div><span class="cancel_req_busi">   <img src="<?php echo base_url('assets/img/icon_contact_add.png'); ?>" alt="Add To Contact"></span></div>

                                                </div>


                                                <div class="addtocont">
                                                    <span class="ft-13"><i class="icon-user"></i>
                                                        Add to contact </span>
                                                </div> 

                                            </div>
                                        <?php } elseif ($contactperson[0]['status'] == 'pending') {
                                            ?>
                                            <div class="cance_req_main_box">   
                                                <div class="add-contact">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                    <div>
                                                        <span class="cancel_req_busi">   <img src="<?php echo base_url('assets/img/icon_contact_cancel.png'); ?>" alt="Cancel"></span>
                                                    </div>

                                                </div>


                                                <div class="addtocont">
                                                    <span class="ft-13 cl_haed_s">
                                                        Cancel request </span>
                                                </div> 

                                            </div>
                                        <?php } elseif ($contactperson[0]['status'] == 'confirm') {
                                            ?> 
                                            <div class="fw in_mian_chng">   
                                                <div class="in_your_contact">

                                                    <div class="in_your_contact_change">
                                                        <span class="in_your_contct_img">
                                                            <img src="<?php echo base_url('assets/img/icon_contact_accept.png'); ?>" alt="Accept Contact">
                                                        </span>
                                                    </div>

                                                </div>


                                                <div class="addtocont">
                                                    <span class="ft-13 ai_text">
                                                        In contacts </span>
                                                </div> 

                                            </div>
                                        <?php } elseif ($contactperson[0]['status'] == 'reject') {
                                            ?>
                                            <div>   
                                                <div class="add-contact">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                    <div><span class="cancel_req_busi">   <img src="<?php echo base_url('assets/img/icon_contact_add.png'); ?>" alt="Add to Contact"></span></div>

                                                </div>


                                                <div class="addtocont">
                                                    <span class="ft-13"><i class="icon-user"></i>
                                                        Add to contact </span>
                                                </div> 

                                            </div>
                                        <?php } else {
                                            ?> 
                                            <div>   
                                                <div class="add-contact">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                    <div><span class="cancel_req_busi">   <img src="<?php echo base_url('assets/img/icon_contact_add.png'); ?>" alt="Add to Contact"></span></div>

                                                </div>


                                                <div class="addtocont">
                                                    <span class="ft-13"><i class="icon-user"></i>
                                                        Add to contact </span>
                                                </div> 

                                            </div>
                                        <?php } ?>                            

                                    </a>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="business-data-menu padding_less_right ">
                        <div class="profile-main-box-buis-menu">  
                            <?php
                            $userid = $this->session->userdata('aileenuser');
                            if ($business_common_data[0]['user_id'] == $userid) {
                                ?>     
                                <ul class="current-user bpro-fw6">
                                <?php } else { ?>
                                    <ul class="bpro-fw">
                                    <?php } ?>  
                                        <li <?php if ($this->uri->segment(1) == 'business-profile' && $this->uri->segment(2) == 'dashboard') { ?> class="active" <?php } ?>><a title="Dashboard" class="login_link" href="<?php echo base_url('business-profile/dashboard/' . $business_common_data[0]['business_slug']); ?>">Dashboard</a></li>
                                    <li <?php if ($this->uri->segment(1) == 'business-profile' && $this->uri->segment(2) == 'details') { ?> class="active" <?php } ?>><a title="Details" class="login_link" href="<?php echo base_url('business-profile/details/' . $business_common_data[0]['business_slug']); ?>"> Details</a></li>
                                    <li <?php if ($this->uri->segment(1) == 'business-profile' && $this->uri->segment(2) == 'contacts') { ?> class="active" <?php } ?>><a title="Contacts" href="javascript:void(0);" onclick="open_profile();"> Contacts <br>  (<span class="contactcount"><?php echo $business_user_contacts_count; ?></span>)</a></li>
                                    <li <?php if ($this->uri->segment(1) == 'business-profile' && $this->uri->segment(2) == 'followers') { ?> class="active" <?php } ?>><a title="Followers" href="javascript:void(0);" onclick="open_profile();">Followers <br>  <div id="countfollower">(<?php echo $business_user_follower_count; ?>)</div></a></li>
                                    <li <?php if ($this->uri->segment(1) == 'business-profile' && $this->uri->segment(2) == 'following') { ?> class="active" <?php } ?>><a title="Following" href="javascript:void(0);" onclick="open_profile();">Following <br> <div id="countfollow">(<?php echo $business_user_following_count; ?>)</div></a></li>
                                </ul>
                                <?php
                                $userid = $this->session->userdata('aileenuser');
                                if ($business_common_data[0]['user_id'] != $userid) {
                                    ?>
                                    <div class="flw_msg_btn fr top_follow">
                                        <ul>
                                            <li>
                                                <div class="<?php echo "fr" . $business_common_data[0]['business_profile_id']; ?>">
                                                    <?php
                                                    $userid = $this->session->userdata('aileenuser');
                                                    $contition_array = array('user_id' => $userid, 'status' => '1');
                                                    $bup_id = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                    $status = $this->db->get_where('follow', array('follow_type' => '2', 'follow_from' => $bup_id[0]['business_profile_id'], 'follow_to' => $business_common_data[0]['business_profile_id']))->row()->follow_status;
                                                    $logslug = $this->db->get_where('business_profile', array('user_id' => $userid))->row()->business_slug;
                                                    if ($logslug != $this->uri->segment(3)) {
                                                        if ($status == 0 || $status == " ") {
                                                            ?>
                                                            <div class="msg_flw_btn_1" id= "followdiv">
                                                                <button id="" onClick="open_profile();">Follow</button>
                                                            </div>
                                                        <?php } elseif ($status == 1) { ?>
                                                            <div class="msg_flw_btn_1" id= "unfollowdiv">
                                                                <button class="bg_following"  id="" onClick="open_profile();">Following </button>
                                                            </div>
                                                        <?php } ?>
                                                    </div>         
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" onclick="open_profile();" >Message</a></li>
                                            <?php } ?>
                                        </ul>   
                                    </div>
                                <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- pickup -->
            </div>
        </div>
    </div>
