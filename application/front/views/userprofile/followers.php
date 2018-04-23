<div class="container pt20 mobp0 followers-page">
    <div class="custom-user-list">
        <div class="list-box-custom">
            <h3>Followers</h3>
            <div class="p15 fw mobp0">
                <!-- <input name="page_number" class="page_number"  ng-model="page_number" ng-value="pagecntctData.pagedata.page">
                <input name="total_record" class="total_record"  ng-model="total_record" ng-value="pagecntctData.pagedata.total_record">
                <input name="perpage_record" class="perpage_record"  ng-model="perpage_record" ng-value="pagecntctData.pagedata.perpage_record"> -->
                
                <div class="custom-user-box" ng-if="pagecntctData.pagedata.total_record != '0'" ng-repeat="follow in followersData">
                    <div class="post-img" ng-if="follow.user_image != '' && follow.user_image != null">
                        <a href="<?php echo base_url();?>{{follow.user_slug}}" target="_self">
                            <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{follow.user_image}}">
                        </a>
                    </div>

                    <div class="post-img" ng-if="follow.user_image == '' || follow.user_image == null">
                        <a href="<?php echo base_url();?>{{follow.user_slug}}" target="_self">
                            <img ng-if="follow.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                            <img ng-if="follow.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                        </a>
                    </div>
                    <div class="custom-user-detail">
                        <h4>
                            <a href="<?php echo base_url();?>{{follow.user_slug}}" target="_self" ng-bind="(follow.first_name | limitTo:1 | uppercase) + (follow.first_name.substr(1) | lowercase) + ' ' + (follow.last_name | limitTo:1 | uppercase) + (follow.last_name.substr(1) | lowercase)"></a>
                        </h4>
                        <p ng-if="follow.degree_name != ''">{{follow.title_name}}</p>
                        <p ng-if="follow.degree_name == ''">{{follow.degree_name}}</p>
                        <p ng-if="follow.degree_name == null && follow.title_name == null">Current work</p>

                    </div>
                    <div ng-if="follow.user_id != user_id" class="custom-user-btn" id="{{follow.user_id}}">
                        <a class="btn3 following"  ng-if="follow.follow_user_id != null" ng-click="unfollow_user(follow.user_id)">Following</a>
                        <a class="btn3 follow" ng-if="follow.follow_user_id == null"  ng-click="follow_user(follow.user_id)">Follow</a>

                        <!-- <a ng-if="follow.follow_status == 1" class="btn3 following" ng-click="unfollow_user(follow.user_id)">Following</a>
                        <a ng-if="follow.follow_status == 0" class="btn3 follow" ng-click="follow_user(follow.user_id)">Follow</a> -->
                    </div>

                </div>
                <div class="custom-user-box no-data-available"  ng-if="pagecntctData.pagedata.total_record == '0'">
                    <div class='art-img-nn'>
                        <div class='art_no_post_img'>
                            <img src="<?php echo base_url('assets/img/no-follow.png'); ?>" alt="No Follower">
                        </div>
                        <div class='art_no_post_text'>No Follower Available. </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="right-add">
        <div class="custom-user-add">
            <img ng-src="<?php echo base_url('assets/n-images/add.jpg') ?>">
        </div>
    </div>
</div>


