<div>
    <div class="container" id="paddingtop_fixed">
        <div class="profile-banner">
        </div>
        <div class="profile-photo">
            <div class="profile-pho">
                <div class="user-pic">
                    <?php if ($freelancerpostdata[0]['freelancer_post_user_image'] != '') { ?>
                        <img src="<?php echo base_url(USERIMAGE . $freelancerpostdata[0]['freelancer_post_user_image']); ?>" alt="<?php echo ucwords($userdata[0]['first_name']) . ' ' . ucwords($userdata[0]['last_name']); ?>" >
                    <?php } else { ?>
                        <img class="img-circle" src="<?php echo base_url(NOIMAGE); ?>" alt="No Image" />
                    <?php } ?>
                        <a title="Update Profile Pic" href="#popup-form" class="fancybox"><i class="fa fa-camera" aria-hidden="true"></i><?php echo $this->lang->line("update_profile_picture"); ?></a>
                </div>
                <div id="popup-form">
                    <?php echo form_open_multipart(base_url('freelancer/user_image_add'), array('id' => 'userimage', 'name' => 'userimage', 'class' => 'clearfix')); ?>
                    <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="profilepic">
                    <input type="hidden" name="hitext" id="hitext" value="3">
                    <input type="submit" name="cancel3" id="cancel3" value="Cancel">
                    <input type="submit" name="profilepicsubmit" id="profilepicsubmit" value="Save">
                    <?php echo form_close(); ?>
                </div>
            </div>
            <div class="col-md-2 col-sm-2"></div>
            <div class="job-menu-profile">
                <h5 > <?php echo ucwords($userdata[0]['first_name']) . ' ' . ucwords($userdata[0]['last_name']); ?></h5>
                <div class="profile-text" >
                    <p >Jr. Owner</p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>