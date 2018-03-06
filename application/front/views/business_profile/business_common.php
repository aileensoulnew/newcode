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
                                                                                                <!--<img src="<?php echo base_url($this->config->item('bus_bg_main_upload_path') . $image[0]['profile_background']); ?>" name="image_src" id="image_src" />-->
            <img src="<?php echo BUS_BG_MAIN_UPLOAD_URL . $image[0]['profile_background'] ?>" name="image_src" id="image_src" alt="<?php echo BUS_BG_MAIN_UPLOAD_URL . $image[0]['profile_background'] ?>" />
                <?php
            } else {
                ?>
                <div class="bg-images no-cover-upload">
                    <img src="<?php echo base_url(WHITEIMAGE); ?>" name="image_src" id="image_src" alt="White Image" />
                </div>
            <?php }
            ?>
        </div>
    </div>
</div>
<div class="container tablate-container">
    <?php
    if ($business_common_data[0]['user_id'] == $userid) {
        ?>
        <div class="upload-img">
            <label class="cameraButton"> <span class="tooltiptext">Upload Cover Photo</span><i class="fa fa-camera" aria-hidden="true"></i>
                <input type="file" id="upload" name="upload" accept="image/*;capture=camera" onclick="showDiv()">
            </label>
        </div>
    <?php } ?>
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
                                    <img src="<?php echo base_url(NOBUSIMAGE); ?>" alt="Bo Business Image" >
                                <?php } else {
                                    ?>
                                    <img src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_common_data[0]['business_user_image']; ?>" alt="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_common_data[0]['business_user_image']; ?>" >
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
                                    <img src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_common_data[0]['business_user_image']; ?>" alt="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_common_data[0]['business_user_image']; ?>" >
                                    <?php
                                }
                            }
                        } else {
                            ?>
                            <img src="<?php echo base_url(NOBUSIMAGE); ?>" alt="No Business Image" >
                        <?php } ?>
                        <?php
                        $userid = $this->session->userdata('aileenuser');
                        if ($business_common_data[0]['user_id'] == $userid) {
                            ?>                                                                                                                        <!-- <a href="#popup-form" class="fancybox"><i class="fa fa-camera" aria-hidden="true"></i> Update Profile Picture</a> -->
                            <a class="cusome_upload" href="javascript:void(0);" onclick="updateprofilepopup();"><img src="<?php echo base_url(); ?>assets/img/cam.png" alt="Update Profile Picture"> Update Profile Picture</a>
                        <?php } ?>
                    </div>
                </div>
                <div class="business-profile-right">
                    <div class="bui-menu-profile">
                        <div class="profile-left">
                            <h1 class="profile-head-text"><a href="<?php echo base_url('business-profile/details/' . $business_common_data[0]['business_slug'] . ''); ?>"> <?php echo ucfirst($business_common_data[0]['company_name']); ?></a></h1>

                            <?php if ($business_common_data[0]['industriyal']) { ?>

                                <h2 class="profile-head-text_dg" title=" <?php echo $industry_type = $this->db->get_where('industry_type', array('industry_id' => $business_common_data[0]['industriyal']))->row()->industry_name; ?>"><a href="<?php echo base_url('business-profile/details/' . $business_common_data[0]['business_slug'] . ''); ?>"> 

                                        <?php echo $industry_type = $this->db->get_where('industry_type', array('industry_id' => $business_common_data[0]['industriyal']))->row()->industry_name; ?>

                                    </a></h2>
                                <?php
                            }
                            if ($business_common_data[0]['other_industrial']) {
                                ?>

                                <h2 class="profile-head-text_dg" title="<?php echo ucfirst(strtolower($business_common_data[0]['other_industrial'])); ?>"><a href="<?php echo base_url('business-profile/details/' . $business_common_data[0]['business_slug'] . ''); ?>"> 

                                        <?php
                                        if ($industry_type == '') {

                                            $num_words = 9;
                                            $words = array();
                                            $words = explode(" ", $business_common_data[0]['other_industrial'], $num_words);
                                            $shown_string = "";
                                            if (count($words) == 9) {
                                                $words[8] = '....';
                                            }
                                            $shown_string = implode(" ", $words);
                                            echo ucfirst(strtolower($shown_string));
                                        }
                                        ?>
                                    </a></h2>
                            <?php }
                            ?>



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
                                    <a href="javascript:void(0);" onclick="return contact_person_query(<?php echo $business_common_data[0]['user_id']; ?>,<?php echo "'" . $contactperson[0]['status'] . "'"; ?>);" >

                                    <?php } elseif ($contactperson[0]['status'] == 'pending' || $contactperson[0]['status'] == 'confirm') { ?>   
                                        <a href="javascript:void(0);" onclick="return contact_person_query(<?php echo $business_common_data[0]['user_id']; ?>,<?php echo "'" . $contactperson[0]['status'] . "'"; ?>)" >
                                        <?php } ?>

                                        <?php if ($contactperson[0]['status'] == 'cancel') { ?> 
                                            <div>   
                                                <div class="add-contact">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                    <div><span class="cancel_req_busi">   <img src="<?php echo base_url('assets/img/icon_contact_add.png'); ?>" alt="Add Contact"></span></div>

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

                                                    <div class="in_your_contact_change" style="cursor: pointer;">
                                                        <span class="in_your_contct_img">
                                                            <img src="<?php echo base_url('assets/img/icon_contact_accept.png'); ?>" alt="Contact Accept">
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
                                                    <div><span class="cancel_req_busi">   <img src="<?php echo base_url('assets/img/icon_contact_add.png'); ?>" alt="Add Contact"></span></div>

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
                                    <li <?php if ($this->uri->segment(1) == 'business-profile' && $this->uri->segment(2) == 'dashboard') { ?> class="active" <?php } ?>><a title="Dashboard" href="<?php echo base_url('business-profile/dashboard/' . $business_common_data[0]['business_slug']); ?>">Dashboard</a></li>
                                    <li <?php if ($this->uri->segment(1) == 'business-profile' && $this->uri->segment(2) == 'details') { ?> class="active" <?php } ?>><a title="Details" href="<?php echo base_url('business-profile/details/' . $business_common_data[0]['business_slug']); ?>"> Details</a></li>
                                    <li <?php if ($this->uri->segment(1) == 'business-profile' && $this->uri->segment(2) == 'contacts') { ?> class="active" <?php } ?>><a title="Contacts" href="<?php echo base_url('business-profile/contacts/' . $business_common_data[0]['business_slug']); ?>"> Contacts <br>  (<span class="contactcount"><?php echo $business_user_contacts_count; ?></span>)</a></li>
                                    <li <?php if ($this->uri->segment(1) == 'business-profile' && $this->uri->segment(2) == 'followers') { ?> class="active" <?php } ?>><a title="Followers" href="<?php echo base_url('business-profile/followers/' . $business_common_data[0]['business_slug']); ?>">Followers <br>  <div id="countfollower">(<?php echo $business_user_follower_count; ?>)</div></a></li>
                                    <li <?php if ($this->uri->segment(1) == 'business-profile' && $this->uri->segment(2) == 'following') { ?> class="active" <?php } ?>><a title="Following" href="<?php echo base_url('business-profile/following/' . $business_common_data[0]['business_slug']); ?>">Following <br> <div id="countfollow">(<?php echo $business_user_following_count; ?>)</div></a></li>
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
                                                                <button id="<?php echo "follow" . $business_common_data[0]['business_profile_id']; ?>" onClick="followuser_two(<?php echo $business_common_data[0]['business_profile_id']; ?>)">Follow</button>
                                                            </div>
                                                        <?php } elseif ($status == 1) { ?>
                                                            <div class="msg_flw_btn_1" id= "unfollowdiv">
                                                                <button class="bg_following"  id="<?php echo "unfollow" . $business_common_data[0]['business_profile_id']; ?>" onClick="unfollowuser_two(<?php echo $business_common_data[0]['business_profile_id']; ?>)">Following </button>
                                                            </div>
                                                        <?php } ?>
                                                    </div>         
                                                </li>
                                                <li>
                                                    <a href="<?php echo base_url('chat/abc/5/5/' . $business_common_data[0]['user_id']); ?>">Message</a></li>
                                            <?php } ?>
                                        </ul>   
                                    </div>
                                <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--PROFILE PIC MODEL START-->
    <div class="modal fade message-box" id="bidmodal-2" role="dialog">
        <div class="modal-dialog modal-lm">
            <div class="modal-content">
                <button type="button" class="profile-modal-close" data-dismiss="modal">&times;</button>       
                <div class="modal-body">
                    <span class="mes">
                        <div id="popup-form">
                            <div class="fw" id="profile_loader"  style="display:none;" style="text-align:center;" ><img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" alt="Loader" /></div>
                            <form id ="userimage" name ="userimage" class ="clearfix" enctype="multipart/form-data" method="post">
                                <div class="fw">
                                    <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="upload-one" >
                                </div>

                                <div class="col-md-7 text-center">
                                    <div id="upload-demo-one" style="display:none;" style="width:350px"></div>
                                </div>
                                <input type="submit" class="upload-result-one" name="profilepicsubmit" id="profilepicsubmit" value="Save" >
                            </form>
                        </div>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade message-box biderror" id="messageModel" role="dialog">
        <div class="modal-dialog modal-lm deactive">
            <div class="modal-content">
                <button type="button" class="modal-close1" data-dismiss="modal">&times;</button>       
                <div class="modal-body">
                    <span class="mes">
                    </span>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        
        var business_slug = '<?php echo $business_common_data[0]['business_slug'] ?>';
        
        function send_message(user_id, business_profile_id) {
            $('#messageModel .mes').html("<h5 class='modal-title'>Send Message</h5><hr><div class='form-group'><div class='col-md-12'><div class='post-design-proo-img hidden-mob'><img src='<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_login_user_image ?>' alt='<?php echo $business_login_company_name; ?>'></div><div id='content' class='col-md-12  inputtype-comment cmy_2'><div contenteditable='true' class='edt_2 editable_text' name='message' id='message' placeholder='Enter Message ...' onclick='enterMessage(" + user_id + "," + business_profile_id + ");' onpaste='OnPaste_StripFormatting(this, event);' style='text-align: left;'></div></div><div class='comment-edit-butn hidden-mob'><button id='enterMessage' onclick='enterMessage(" + user_id + "," + business_profile_id + ");' style='padding:10px 20px; margin: -10px;'>Send</button></div></div></div>");
            $('#messageModel').modal('show');
        }

        function enterMessage(user_id, business_profile_id) {

            $("#message").click(function () {
                $(this).prop("contentEditable", true);
                $(this).html("");
            });

            var sel = $("#message");
            var txt = sel.html();
            txt = txt.replace(/&nbsp;/gi, " ");
            txt = txt.replace(/<br>$/, '');
            txt = txt.replace(/&gt;/gi, ">");
            txt = txt.replace(/div/gi, "p");
            if (txt == '' || txt == '<br>') {
                return false;
            }
            if (/^\s+$/gi.test(txt))
            {
                return false;
            }
            txt = txt.replace(/&/g, "%26");
            $('#message').html("");

            $.ajax({
                type: 'POST',
                url: base_url + "message/businessSingleMessageInsert",
                data: 'user_id=' + user_id + '&business_profile_id=' + business_profile_id + '&message=' + encodeURIComponent(txt),
                dataType: "json",
                success: function (data) {
                    if (data.result == 'success') {
                        window.location = "<?php echo base_url() ?>message/b/" + business_slug;
                    }else{
                        $('#messageModel').modal('hide');
                    }
                }
            });
        }
    </script>
    <!--PROFILE PIC MODEL END-->