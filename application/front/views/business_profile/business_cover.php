<div>
            <div class="container" id="paddingtop_fixed">
                <div class="profile-banner">

                </div>
                <div class="profile-photo">
                    <div class="profile-pho">

                        <div class="user-pic">
                        <?php if($businessdata[0]['business_user_image'] != ''){ ?>
                           <img src="<?php echo base_url(USERIMAGE . $businessdata[0]['business_user_image']);?>" alt="" >
                            <?php } else { ?>
                            <img alt="" class="img-circle" src="<?php echo base_url(NOIMAGE); ?>" alt="" />
                            <?php } ?>
                            <a href="#popup-form" class="fancybox"><i class="fa fa-camera" aria-hidden="true"></i> Update Profile Picture</a>

                        </div>

                        <div id="popup-form">
                       <?php echo form_open_multipart(base_url('business_profile/user_image_insert'), array('id' => 'userimage','name' => 'userimage', 'class' => 'clearfix')); ?>
                        <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="profilepic">
                        <input type="hidden" name="hitext" id="hitext" value="4">
                        <input type="submit" name="cancel4" id="cancel4" value="Cancel">
                        <input type="submit" name="profilepicsubmit" id="profilepicsubmit" value="Save">
                    </form>
                    </div>

                    </div>
                    <div class="col-md-2 col-sm-2"></div>
                      <div class="job-menu-profile">
                          <h4 align="center" > <?php echo ucfirst(strtolower($userdata[0]['first_name'])) .' '. ucfirst(strtolower($userdata[0]['last_name'])); ?></h4>
                        <div class="profile-text" >
                        <p align="center">Jr. Owner</p>
                      </div>
                      </div>
                </div>
            </div>
        </div>