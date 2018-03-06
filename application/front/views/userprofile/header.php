<div class="middle-section middle-section-banner">

    <div class="container-fluid bnr mob-banner">
        <div class="main-banner gradient-bg">
            <!--COVER PIC CODE START -->
            <div class="row" id="row1" style="display:none;">
                <div class="col-md-12 text-center">
                    <div id="upload-demo" style="width:100%"></div>
                </div>
                <div class="col-md-12 cover-pic" >
                    <button title="Cancel" class="btn btn-success  cancel-result" onclick="">Cancel</button>

                    <button title="Save" class="btn btn-success set-btn upload-result pull-right" onclick="myFunction()">Save</button>

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
                    $image_ori = $userdata['profile_background'];
                    $filename = $this->config->item('user_bg_main_upload_path') . $userdata['profile_background'];
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                    if ($info && $userdata['profile_background'] != '') {
                        ?>
                        <img src = "<?php echo USER_BG_MAIN_UPLOAD_URL . $userdata['profile_background']; ?>" name="image_src" id="image_src" alt="<?php echo $userdata['profile_background']; ?>"/>
                        <?php
                    } else {
                        ?>

                        <!-- <div class="bg-images no-cover-upload">
                            <img src="<?php echo base_url(WHITEIMAGE); ?>" name="image_src" id="image_src" alt="<?php echo 'NOIMAGE'; ?>" />
                        </div> -->
                    <?php }
                    ?>

                </div>
            </div>
            <div class="upload-camera" ng-if="live_slug == segment2">
                <div class="upload-img">
                    <label  class="cameraButton"><span class="tooltiptext">Upload Cover Photo</span><i class="fa fa-camera" aria-hidden="true"></i>
                        <input type="file" id="upload" name="upload" accept="image/*" capture="camera" onclick="showDiv()">
                    </label>
                </div>

            </div>
        </div>

        <!--div class="container tablate-container art-profile"-->    

        <!--COVER PIC CODE END -->
        <div class="main-user-profile">
            <div class="user-photo-name">
                <!--PROFILE PIC CODE START -->
                <div class="profile-img">

                    <?php
                    $filename = $this->config->item('user_thumb_upload_path') . $userdata['user_image'];
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                    if ($userdata['user_image'] != '' && $info) {
                        ?>

                        <img src="<?php echo USER_THUMB_UPLOAD_URL . $userdata['user_image']; ?>">
                        <?php
                    } else {
                        $a = $userdata['first_name'];
                        $acr = substr($a, 0, 1);

                        $b = $userdata['last_name'];
                        $acr1 = substr($b, 0, 1);
                        ?>
                        <div class="post-img-user">
                            <?php echo ucfirst(strtolower($acr)) . ucfirst(strtolower($acr1)); ?>

                        </div>
                    <?php } ?>
                    <a ng-if="live_slug == segment2" class="upload-profile cusome_upload"  href="javascript:void(0);" onclick="updateprofilepopup();" title="Update profile picture">
                        <img src="<?php echo base_url('assets/n-images/cam.png') ?>"  alt="<?php echo 'CAMERAIMAGE'; ?>">Update Profile Picture
                    </a>
                </div>
                <!--PROFILE PIC CODE END -->

                <h3><a href="#"><?php echo ucfirst($userdata['first_name']) . ' ' . ucfirst($userdata['last_name']); ?></a></h3>
                <?php if (count($is_userSlugBasicInfo) != 0) { ?>	
                    <p><?php echo $is_userSlugBasicInfo['Designation']; ?></p>
                <?php } else if (count($is_userSlugStudentInfo) != 0) { ?>
                    <p><?php echo $is_userSlugStudentInfo['Degree']; ?></p>
                <?php } else { ?>
                    <p>Current Work</p>
                <?php } ?>

                <?php if (count($is_userSlugBasicInfo) != 0) { ?>	
                    <p><?php echo $is_userSlugBasicInfo['City']; ?></p>
                <?php } else { ?>
                    <p><?php echo $is_userSlugStudentInfo['City']; ?></p>
                <?php } ?>
            </div>
            <div class="user-btns" ng-if="live_slug != segment2">
                <a class="btn3" ng-if="contact_value == 'new'" ng-click="contact(contact_id, 'pending', to_id)">Add to contact</a>
                <a class="btn3" ng-if="contact_value == 'confirm'" ng-click="contact(contact_id, 'cancel', to_id)">Friends</a>
                <a class="btn3" ng-if="contact_value == 'pending'" ng-click="contact(contact_id, 'cancel', to_id)">Request sent</a>
                <a class="btn3" ng-if="contact_value == 'cancel'" ng-click="contact(contact_id, 'pending', to_id)">Add to contact</a>
                <a class="btn3" ng-if="contact_value == 'reject'" ng-click="contact(contact_id, 'pending', to_id)">Add to contact</a>
                <!--<a class="btn3" ng-if="contact_value == 'cancel'" ng-click="contact(contact_id)">Add to contact3</a>-->
                <a class="btn3" ng-if="follow_value == 0" ng-click="follow(follow_id, 1, to_id)">Follow</a>
                <a class="btn3" ng-if="follow_value == 'new'" ng-click="follow(follow_id, 1, to_id)">Follow</a>
                <a class="btn3" ng-if="follow_value == 1"  ng-click="follow(follow_id, 0, to_id)">Following</a>
                <a class="btn3">Message</a>
            </div>
            <div class="main-user-option">
                <ul>
                    <li  ng-if="live_slug == segment2" ><a href="profiles/<?php echo $userdata['user_slug']; ?>"  ng-click='makeActive("profiles")' ng-class="{
                            'active': active == 'profiles'}">Profiles</a></li>
                    <li><a href="dashboard/<?php echo $userdata['user_slug']; ?>"  ng-click='makeActive("dashboard")' ng-class="{
                            'active': active == 'dashboard'}">Dashboard</a></li>
                    <li><a href="details/<?php echo $userdata['user_slug']; ?>"  ng-click='makeActive("details")' ng-class="{
                            'active': active == 'details'}">Details</a></li>
                    <li><a href="contacts/<?php echo $userdata['user_slug']; ?>" ng-click='makeActive("contacts")' ng-class="{
                            'active': active == 'contacts'}">Contacts</a></li>
                    <li><a href="followers/<?php echo $userdata['user_slug']; ?>"  ng-click='makeActive("followers")' ng-class="{
                            'active': active == 'followers'}">followers</a></li>
                    <li><a href="following/<?php echo $userdata['user_slug']; ?>"  ng-click='makeActive("following")' ng-class="{
                            'active': active == 'following'}">following</a></li>
                    <li><a href="questions/<?php echo $userdata['user_slug']; ?>"  ng-click='makeActive("questions")' ng-class="{
                            'active': active == 'questions'}">Questions</a></li>
                </ul>
            </div>
        </div>


    </div>

</div>
