<?php
$s3 = new S3(awsAccessKey, awsSecretKey);

$userid = $this->session->userdata('aileenuser');
        
$contition_array = array('user_id' => $userid, 'status' => '1', 'is_deleted' => '0');
$data = "business_profile_id,user_id,business_user_image,business_slug,industriyal,other_industrial,company_name,profile_background,city,state,business_type,business_step";
$business_common_data = $this->data['business_common_data'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
       

?>
<div class="full-box-module">   
    <div class="profile-boxProfileCard  module">
        <div class="profile-boxProfileCard-cover"> 
            <a class="profile-boxProfileCard-bg u-bgUserColor a-block"
               href="<?php echo base_url('business-profile/dashboard/' . $business_common_data[0]['business_slug']); ?>"
               tabindex="-1" aria-hidden="true" rel="noopener" title="<?php echo $business_common_data[0]['company_name']; ?>">
                   <?php
                   $filename = $this->config->item('bus_bg_thumb_upload_path') . $business_common_data[0]['profile_background'];
                   $s3 = new S3(awsAccessKey, awsSecretKey);
                   $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                   if ($info && $business_common_data[0]['profile_background'] != '') {
                       ?>
                    <img src = "<?php echo BUS_BG_MAIN_UPLOAD_URL . $business_common_data[0]['profile_background']; ?>" name="image_src" id="image_src" alt="<?php echo $business_common_data[0]['company_name']; ?>" />
                    <?php
                } else {
                    ?>
                    <div class="bg-images no-cover-upload"> 
                        <img src="<?php echo base_url(WHITEIMAGE); ?>" class="bgImage" alt="<?php echo $business_common_data[0]['company_name']; ?>" >
                    </div> <?php } ?>
            </a>
        </div>
        <div class="profile-boxProfileCard-content clearfix">
            <div class="left_side_box_img buisness-profile-txext">

                <a class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock" href="<?php echo base_url('business-profile/dashboard/' . $businessdata[0]['business_slug']); ?>" title="<?php echo $businessdata[0]['company_name']; ?>" tabindex="-1" aria-hidden="true" rel="noopener" >
                    <?php
                    if ($business_common_data[0]['business_user_image']) {
                        ?>
                        <div class="left_iner_img_profile"> 
                            <?php
                            if (IMAGEPATHFROM == 'upload') {
                                if (!file_exists($this->config->item('bus_profile_main_upload_path') . $business_common_data[0]['business_user_image'])) {
                                    ?>
                                    <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt=""No Image>
                                <?php } else {
                                    ?>
                                    <img  src="<?php echo base_url($this->config->item('bus_profile_main_upload_path') . $business_common_data[0]['business_user_image']); ?>"  alt="<?php echo $business_common_data[0]['company_name']; ?>" >
                                    <?php
                                }
                            } else {
                                $filename = $this->config->item('bus_profile_main_upload_path') . $business_common_data[0]['business_user_image'];
                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                if (!$info) {
                                    ?>
                                    <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="No Image">
                                <?php } else {
                                    ?>

                                    <img src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_common_data[0]['business_user_image']; ?>" alt="<?php echo $business_common_data[0]['company_name']; ?>" >
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    <?php } else { ?>
                        <div class="left_iner_img_profile">  

                            <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="No Image">
                        </div>  <?php } ?>                           
                </a>
            </div>
            <div class="right_left_box_design ">
                <span class="profile-company-name ">
                    <a  href="<?php echo base_url('business-profile/dashboard/' . $business_common_data[0]['business_slug']); ?> " title="<?php echo ucwords($business_common_data[0]['company_name']); ?>"> 
                        <?php echo ucwords($business_common_data[0]['company_name']); ?>
                    </a> 
                </span>

                <?php $category = $this->db->get_where('industry_type', array('industry_id' => $business_common_data[0]['industriyal'], 'status' => '1'))->row()->industry_name; ?>
                <div class="profile-boxProfile-name">
                    <a  href="<?php echo base_url('business-profile/dashboard/' . $business_common_data[0]['business_slug']); ?> " title="<?php echo ucwords($business_common_data[0]['company_name']); ?>" >
                        <?php
                        if ($category) {
                            echo $category;
                        } else {
                            echo $business_common_data[0]['other_industrial'];
                        }
                        ?>
                    </a>
                </div>
                <ul class=" left_box_menubar">
                    <li
                        <?php if ($this->uri->segment(1) == 'business-profile' && $this->uri->segment(2) == 'dashboard') { ?> class="active" 
                        <?php } ?>>
                        <a  class="padding_less_left" title="Dashboard" href="<?php echo base_url('business-profile/dashboard/' . $business_common_data[0]['business_slug']); ?>">Dashboard
                        </a>
                    </li>
                    <li 
                        <?php if ($this->uri->segment(1) == 'business-profile' && $this->uri->segment(2) == 'followers') { ?> class="active" 
                        <?php } ?>>
                        <a title="Followers" href="<?php echo base_url('business-profile/followers/' . $business_common_data[0]['business_slug']); ?>">Followers 
                            <br> <span class="left_box_follower_count">(<?php echo ($business_user_follower_count); ?>)</span>
                        </a>
                    </li>
                    <li  
                        <?php if ($this->uri->segment(1) == 'business-profile' && $this->uri->segment(2) == 'following') { ?> class="active" 
                        <?php } ?>>
                        <a  class="padding_less_right" title="Following" href="<?php echo base_url('business-profile/following/' . $business_common_data[0]['business_slug']); ?>">Following 
                            <br> <span class="left_box_following_count">(<?php echo ($business_user_following_count); ?>) </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>                             
</div>