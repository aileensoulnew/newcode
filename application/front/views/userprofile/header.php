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
                    if ($userdata['profile_background'] != '') {
                        $filename = $this->config->item('user_bg_main_upload_path') . $userdata['profile_background'];
                        $s3 = new S3(awsAccessKey, awsSecretKey);
                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                        ?>
                    <a data-toggle="modal" data-target="#view-cover-img" class="cusome_upload"  href="#">
                        <img src = "<?php echo USER_BG_MAIN_UPLOAD_URL . $userdata['profile_background']; ?>" name="image_src" id="image_src" alt="<?php echo $userdata['profile_background']; ?>"/>
                        </a>
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
                    <label  class="cameraButton"><i class="fa fa-camera" aria-hidden="true"></i>
                        <input type="file" id="upload" name="upload" accept="image/*" onclick="showDiv()">
                    </label>
                </div>

            </div>
        </div>

        <!--div class="container tablate-container art-profile"-->    

        <!--COVER PIC CODE END -->
        <div class="main-user-profile">
            <div class="user-photo-name">
                <!--PROFILE PIC CODE START -->
                <div id="user-profile" class="profile-img">

                    <?php
                    if ($userdata['user_image'] != '') {
                        $filename = $this->config->item('user_thumb_upload_path') . $userdata['user_image'];
                        $s3 = new S3(awsAccessKey, awsSecretKey);
                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                        ?>

                    <a class="other-user-profile" hrerf="#" data-toggle="modal" data-target="#other-user-profile-img"><img src="<?php echo USER_MAIN_UPLOAD_URL . $userdata['user_image']; ?>"></a>
                        <?php
                    } else {
                        $a = $userdata['first_name'];
                        $acr = substr($a, 0, 1);

                        $b = $userdata['last_name'];
                        $acr1 = substr($b, 0, 1);
                        ?>
                        <!-- <div class="post-img-user"> -->
                            <?php 
                            // strtoupper($userdata['user_gender']) == "M"
                            // strtoupper($userdata['user_gender']) == "F"
                            //echo ucfirst(strtolower($acr)) . ucfirst(strtolower($acr1)); ?>
                            <a class="other-user-profile" hrerf="#">
                                <?php if(strtoupper($userdata['user_gender']) == "M"): ?>
                                    <img src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                <?php else: ?>
                                    <img src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                <?php endif; ?>
                            </a>

                        <!-- </div> -->
                    <?php } ?>
                    <div ng-if="live_slug == segment2" class="upload-profile">
                        <a class="cusome_upload"  href="" onclick="updateprofilepopup();" title="Update profile picture">
                            <img src="<?php echo base_url('assets/n-images/cam.png') ?>"  alt="<?php echo 'CAMERAIMAGE'; ?>">Update Profile Picture
                        </a>
                        <a data-toggle="modal" data-target="#view-profile-img" class="cusome_upload"  href="">
                            <img src="<?php echo base_url('assets/img/v-pic.png') ?>"  alt="<?php echo 'CAMERAIMAGE'; ?>">View
                        </a>
                    </div>
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
            <div class="user-btns {{to_id}}" ng-if="live_slug != segment2" ng-init="from_id=<?php echo $from_id;?>">
                <a class="btn3" ng-if="contact_value == 'new'" ng-click="contact(contact_id, 'pending', to_id)">Add to contact</a>
                <a class="btn3" ng-if="contact_value == 'confirm'" ng-click="contact(contact_id, 'cancel', to_id)">In Contacts</a>
                <a class="btn3" ng-if="contact_value == 'pending' && from_id != to_id" ng-click="contact(contact_id, 'cancel', to_id)">Request sent</a>
                <a class="btn3" ng-if="contact_value == 'pending' && from_id == to_id" ng-click="confirmContactRequestInnerHeader(to_id)">Confirm Request</a>
                <a class="btn3" ng-if="contact_value == 'cancel'" ng-click="contact(contact_id, 'pending', to_id)">Add to contact</a>
                <a class="btn3" ng-if="contact_value == 'reject'" ng-click="contact(contact_id, 'pending', to_id)">Add to contact</a>
                <!--<a class="btn3" ng-if="contact_value == 'cancel'" ng-click="contact(contact_id)">Add to contact3</a>-->
                <a class="btn3" ng-if="follow_value == 0" ng-click="follow(follow_id, 1, to_id)">Follow</a>
                <a class="btn3" ng-if="follow_value == 'new'" ng-click="follow(follow_id, 1, to_id)">Follow</a>
                <a class="btn3" ng-if="follow_value == 1"  ng-click="follow(follow_id, 0, to_id)">Following</a>
                <a class="btn3">Message</a>
            </div>
            <div class="main-user-option-scroll">
                <div class="table-responsive content horizontal-images">
                    <table class="table" ng-class="{'other-user': live_slug != segment2}">
                        <tr>
                            <td ng-if="live_slug == segment2" ><a href="<?php echo $userdata['user_slug']; ?>/profiles"  ng-click='makeActive("profiles")' ng-class="{'active': active == 'profiles'}">Profiles</a></td>
                            <td><a href="<?php echo $userdata['user_slug']; ?>" ng-click='makeActive("<?php echo $userdata['user_slug']; ?>")' ng-class="{'active': active == '<?php echo $userdata['user_slug']; ?>' || active == 'dashboard' || active == 'article' || active == 'photos' || active == 'videos' || active == 'audios' || active == 'pdf'}">Dashboard</a></td>
                            <td><a href="<?php echo $userdata['user_slug']; ?>/details"  ng-click='makeActive("details")' ng-class="{
                                    'active': active == 'details'}">Details</a></td>
                            <td><a href="<?php echo $userdata['user_slug']; ?>/contacts" ng-click='makeActive("contacts")' ng-class="{
                                    'active': active == 'contacts'}">Contacts</a></td>
                            <td><a href="<?php echo $userdata['user_slug']; ?>/followers"  ng-click='makeActive("followers")' ng-class="{
                                    'active': active == 'followers'}">followers</a></td>
                            <td><a href="<?php echo $userdata['user_slug']; ?>/following"  ng-click='makeActive("following")' ng-class="{
                                    'active': active == 'following'}">following</a></td>
                            <td><a href="<?php echo $userdata['user_slug']; ?>/questions"  ng-click='makeActive("questions")' ng-class="{
                                    'active': active == 'questions'}">Questions</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>


    </div>

</div>
