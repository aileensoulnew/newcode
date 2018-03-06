<div class="container pt20">
    <div class="custom-user-list">
        <div class="list-box-custom">
            <h3>Following</h3>
            <div class="p15 fw" id="nofollowng">
               <!--  <input name="page_number" class="page_number"  ng-model="page_number" ng-value="pagecntctData.pagedata.page">
                <input name="total_record" class="total_record"  ng-model="total_record" ng-value="pagecntctData.pagedata.total_record">
                <input name="perpage_record" class="perpage_record"  ng-model="perpage_record" ng-value="pagecntctData.pagedata.perpage_record"> -->
                <div class="custom-user-box" ng-if="follow_data != '0'" ng-repeat="follow in followingData">
                    <div class="post-img" ng-if="follow.user_image != '' && follow.user_image != null">
                        <a href="#"><img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{follow.user_image}}"></a>
                    </div>

                    <div class="post-img" ng-if="follow.user_image == '' || follow.user_image == null">
                        <div class="post-img-mainuser">{{follow.first_name| limitTo:1 | uppercase}}{{follow.last_name| limitTo:1 | uppercase}}</div>
                    </div>
                    <div class="custom-user-detail">
                        <h4>

                            <a ng-click="goUserprofile(follow.user_slug)" ng-bind="(follow.first_name | limitTo:1 | uppercase) + (follow.first_name.substr(1) | lowercase) + ' ' + (follow.last_name | limitTo:1 |uppercase) + (follow.last_name.substr(1) | lowercase)"></a>
                        </h4>
                        <p ng-if="follow.degree_name != ''">{{follow.title_name}}</p>
                        <p ng-if="follow.degree_name == ''">{{follow.degree_name}}</p>
                        <p ng-if="follow.degree_name == null && follow.title_name == null">Current work</p>

                    </div>
                    <div class="custom-user-btn"  id="{{follow.user_id}}">
                        <a class="btn3"  id="{{follow.user_id}}" ng-click="unfollow_user(follow.user_id)">Following</a>				
                    </div>

                </div>

            </div>
            
            <div class="custom-user-box"  ng-if="pagecntctData.pagedata.total_record == '0'">
                 <div class="art-img-nn">
                    <div class="art_no_post_img">

                        <img src="assets/img/icon_notification_big.png" alt="notification image">

                    </div>
                    <div class="art_no_post_text">No Notification Available. </div>
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