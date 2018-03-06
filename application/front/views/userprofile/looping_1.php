 <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
 <script src="<?php echo base_url('assets/js/infinite-scroll.js'); ?>"></script>

<div ng-app='myApp' ng-controller='DemoController'>
  <div infinite-scroll='loadMore()' infinite-scroll-distance='2'>
      <!--<div ng-repeat='image in images'>-->
          <div ng-if="postData.length != 0" class="all-post-box" ng-repeat="post in postData">
              
                <input type="hidden" name="page_number" class="page_number" ng-class="page_number" ng-model="post.page_number" ng-value="{{post.page_data.page}}">
                <input type="hidden" name="total_record" class="total_record" ng-class="total_record" ng-model="post.total_record" ng-value="{{post.page_data.total_record}}">
                <input type="hidden" name="perpage_record" class="perpage_record" ng-class="perpage_record" ng-model="post.perpage_record" ng-value="{{post.page_data.perpage_record}}">
                <div class="all-post-top">
                    <div class="post-head">
                        <div class="post-img">
                            <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{post.user_data.user_image}}" ng-if="post.user_data.user_image != ''">
                            <img ng-src="<?php echo NOBUSIMAGE2 ?>" ng-if="post.user_data.user_image == ''">
                        </div>
                        {{post.post_data.id}}
                        <div class="post-detail">
                            <div class="fw">
                                <a ng-href="<?php echo base_url('profiles/') ?>{{post.user_data.user_slug}}" class="post-name" ng-bind="post.user_data.fullname"></a><span class="post-time">7 hours ago</span>
                            </div>
                            <div class="fw">
                                <span class="post-designation" ng-if="post.user_data.title_name != ''" ng-bind="post.user_data.title_name"></span>
                                <span class="post-designation" ng-if="post.user_data.title_name == ''" ng-bind="post.user_data.degree_name"></span>
                                <span class="post-designation" ng-if="post.user_data.title_name == null && post.user_data.degree_name == null" ng-bind="CURRENT WORK"></span>
                            </div>
                        </div>
                        <div class="post-right-dropdown dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img ng-src="<?php echo base_url('assets/n-images/right-down.png') ?>" alt="Right Down"></a>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0);" ng-click="EditPost(post.post_data.id, post.post_data.post_for, $index)">Edit Post</a></li>
                                <li><a href="javascript:void(0);" ng-click="deletePost(post.post_data.id, $index)">Delete Post</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="post-discription" ng-if="post.post_data.post_for == 'opportunity'">
                        <h5 class="post-title">
                            <p ng-if="post.opportunity_data.opportunity_for"><b>Opportunity for:</b><span ng-bind="post.opportunity_data.opportunity_for" id="opp-post-opportunity-for-{{post.post_data.id}}"></span></p>
                            <p ng-if="post.opportunity_data.location"><b>Location:</b><span ng-bind="post.opportunity_data.location" id="opp-post-location-{{post.post_data.id}}"></span></p>
                            <p ng-if="post.opportunity_data.field"><b>Field:</b><span ng-bind="post.opportunity_data.field" id="opp-post-field-{{post.post_data.id}}"></span></p>
                        </h5>
                        <div class="post-des-detail" ng-if="post.opportunity_data.opportunity"><b>Opportunity:</b><span ng-bind="post.opportunity_data.opportunity" id="opp-post-opportunity-{{post.post_data.id}}"></span></div>
                    </div>
                    <div class="post-discription" ng-if="post.post_data.post_for == 'simple'">
                        <div class="post-des-detail" ng-if="post.simple_data.description"><span ng-bind-html="post.simple_data.description" id="simple-post-description-{{post.post_data.id}}"></span></div>
                    </div>
                    <div class="post-discription" ng-if="post.post_data.post_for == 'question'">
                        <h5 class="post-title">
                            <p ng-if="post.question_data.question"><b>Question:</b><span ng-bind="post.question_data.question" id="ask-post-question-{{post.post_data.id}}"></span></p>
                            <p ng-if="post.question_data.description"><b>Description:</b><span ng-bind="post.question_data.description" id="ask-post-description-{{post.post_data.id}}"></span></p>
                            <p ng-if="post.question_data.link"><b>Link:</b><span ng-bind="post.question_data.link" id="ask-post-link-{{post.post_data.id}}"></span></p>
                            <p ng-if="post.question_data.category"><b>Category:</b><span ng-bind="post.question_data.category" id="ask-post-category-{{post.post_data.id}}"></span></p>
                            <p ng-if="post.question_data.field"><b>Field:</b><span ng-bind="post.question_data.field" id="ask-post-field-{{post.post_data.id}}"></span></p>
                        </h5>
                        <div class="post-des-detail" ng-if="post.opportunity_data.opportunity"><b>Opportunity:</b><span ng-bind="post.opportunity_data.opportunity"></span></div>
                    </div>
                    <div class="post-images" ng-if="post.post_data.total_post_files == '1'">
                        <div class="one-img" ng-repeat="post_file in post.post_file_data" ng-init="$last ? loadMediaElement() : false">
                            <a href="#" ng-if="post_file.file_type == 'image'"><img ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}" alt="{{post_file.filename}}"></a>
                            <span  ng-if="post_file.file_type == 'video'"> 
                                <video controls width = "100%" height = "350">
                                    <source ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}" type="video/mp4">
                                </video>
                                <!--<video controls poster="" class="mejs__player" ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}"></video>-->
                            </span>
                            <span  ng-if="post_file.file_type == 'audio'" >
                                <div class = "audio_main_div">
                                    <div class = "audio_img">
                                        <img src = "<?php echo base_url('assets/images/music-icon.png?ver=' . time()) ?>" alt="music-icon.png">
                                    </div>
                                    <div class = "audio_source">
                                        <audio id = "audio_player" width = "100%" height = "40" controls>
                                            <source ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}" type="audio/mp3">
                                            Your browser does not support the audio tag.
                                        </audio>
                                    </div>
                                </div>
                                <!--<audio controls ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}"></audio>-->
                            </span>
                            <a ng-href="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}" target="_blank" title="Click Here" ng-if="post_file.file_type == 'pdf'"><img ng-src="<?php echo base_url('assets/images/PDF.jpg?ver=' . time()) ?>"></a>
                        </div>
                    </div>
                    <div class="post-images" ng-if="post.post_data.total_post_files == '2'">
                        <div class="two-img" ng-repeat="post_file in post.post_file_data">
                            <a href="#"><img ng-src="<?php echo USER_POST_RESIZE1_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}"></a>
                        </div>
                    </div>
                    <div class="post-images" ng-if="post.post_data.total_post_files == '3'">
                        <span ng-repeat="post_file in post.post_file_data">
                            <div class="three-img-top" ng-if="$index == '0'">
                                <a href="#"><img ng-src="<?php echo USER_POST_RESIZE4_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}"></a>
                            </div>
                            <div class="two-img" ng-if="$index == '1'">
                                <a href="#"><img ng-src="<?php echo USER_POST_RESIZE1_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}"></a>
                            </div>
                            <div class="two-img" ng-if="$index == '2'">
                                <a href="#"><img ng-src="<?php echo USER_POST_RESIZE1_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}"></a>
                            </div>
                    </div>
                    </span>
                    <div class="post-images four-img" ng-if="post.post_data.total_post_files >= '4'">
                        <div class="two-img" ng-repeat="post_file in post.post_file_data| limitTo:4">
                            <a href="#"><img ng-src="<?php echo USER_POST_RESIZE2_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}"></a>
                            <div class="view-more-img" ng-if="$index == '3' && post.post_data.total_post_files > '4'">
                                <span><a href="javascript:void(0);">View All (+4)</a></span>
                            </div>
                        </div>
                    </div>
                    <div class="post-bottom">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <ul class="bottom-left">
                                    <li>
                                        <a href="javascript:void(0)" id="post-like-{{post.post_data.id}}" ng-click="post_like(post.post_data.id)" ng-if="post.is_userlikePost == '1'" class="like"><i class="fa fa-thumbs-up"></i></a>
                                        <a href="javascript:void(0)" id="post-like-{{post.post_data.id}}" ng-click="post_like(post.post_data.id)" ng-if="post.is_userlikePost == '0'"><i class="fa fa-thumbs-up"></i></a>
                                    </li>
                                    <li><a href="javascript:void(0);" ng-click="viewAllComment(post.post_data.id, $index, post)" ng-if="post.post_comment_data.length <= 1" id="comment-icon-{{post.post_data.id}}" class="last-comment"><i class="fa fa-comment-o"></i></a></li>
                                    <li><a href="javascript:void(0);" ng-click="viewLastComment(post.post_data.id, $index, post)" ng-if="post.post_comment_data.length > 1" id="comment-icon-{{post.post_data.id}}" class="all-comment"><i class="fa fa-comment-o"></i></a></li>
                                </ul>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <ul class="pull-right bottom-right">
                                    <li class="like-count"><span id="post-like-count-{{post.post_data.id}}" ng-bind="post.post_like_count"></span><span>Like</span></li>
                                    <li class="comment-count"><span class="post-comment-count-{{post.post_data.id}}" ng-bind="post.post_comment_count"></span><span>Comment</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="like-other-box">
                        <a href="#" ng-bind="post.post_like_data" id="post-other-like-{{post.post_data.id}}"></a>
                    </div>
                </div>
                <div class="all-post-bottom">
                    <div class="comment-box">
                        <div class="post-comment" ng-repeat="comment in post.post_comment_data">
                            <div class="post-img">
                                <div class="post-img" ng-if="comment.user_image != ''">
                                    <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{comment.user_image}}">
                                </div>
                                <div class="post-img" ng-if="comment.user_image == ''">
                                    <div class="post-img-mainuser">{{comment.first_name| limitTo:1 | uppercase}}{{comment.last_name| limitTo:1 | uppercase}}</div>
                                </div>
                            </div>
                            <div class="comment-dis">
                                <div class="comment-name"><a ng-bind="comment.username"></a></div>
                                <div class="comment-dis-inner" id="comment-dis-inner-{{comment.comment_id}}" ng-bind-html="comment.comment"></div>
                                <div class="edit-comment" id="edit-comment-{{comment.comment_id}}" style="display:none;">
                                    <div class="comment-input">
                                        <!--<div contenteditable data-directive ng-model="editComment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendEditComment({{comment.comment_id}},$index,post)" id="editCommentTaxBox-{{comment.comment_id}}" ng-focus="setFocus" focus-me="setFocus" onpaste="OnPaste_StripFormatting(event);"></div>-->
                                        <div contenteditable data-directive ng-model="editComment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendEditComment({{comment.comment_id}},$index,post)" id="editCommentTaxBox-{{comment.comment_id}}" ng-focus="setFocus" focus-me="setFocus" role="textbox" spellcheck="true" ng-paste="handlePaste($event)"></div>
                                    </div>
                                    <div class="comment-submit">
                                        <button class="btn2" ng-click="sendEditComment(comment.comment_id)">Comment</button>
                                    </div>
                                </div>
                                <ul class="comment-action">
                                    <li><a href="javascript:void(0);" ng-click="likePostComment(comment.comment_id, post.post_data.id)" ng-if="comment.is_userlikePostComment == '1'" class="like"><i class="fa fa-thumbs-up"></i><span ng-bind="comment.postCommentLikeCount" id="post-comment-like-{{comment.comment_id}}"></span></a></li>
                                    <li><a href="javascript:void(0);" ng-click="likePostComment(comment.comment_id, post.post_data.id)" ng-if="comment.is_userlikePostComment == '0'"><i class="fa fa-thumbs-up"></i><span ng-bind="comment.postCommentLikeCount" id="post-comment-like-{{comment.comment_id}}"></span></a></li>
                                    <li><a href="javascript:void(0);" ng-click="editPostComment(comment.comment_id, post.post_data.id, $parent.$index, $index)">Edit</a></li> 
                                    <li><a href="javascript:void(0);" ng-click="deletePostComment(comment.comment_id, post.post_data.id, $parent.$index, $index, post)">Delete</a></li>
                                    <li><a href="javascript:void(0);" ng-bind="comment.created_date"></a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="add-comment">
                            <div class="post-img">
                                <?php if ($leftbox_data['user_image'] != '') { ?> 
                                    <img ng-src="<?php echo USER_THUMB_UPLOAD_URL . $leftbox_data['user_image'] . '?ver=' . time() ?>" alt="<?php echo $leftbox_data['first_name'] ?>">  
                                <?php } else { ?>
                                    <img ng-src="<?php echo base_url(NOBUSIMAGE . '?ver=' . time()) ?>" alt="<?php echo $leftbox_data['first_name'] ?>">
                                <?php } ?>

                            </div>
                            <div class="comment-input">
                                <div contenteditable data-directive ng-model="comment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendComment({{post.post_data.id}},$index,post)" id="commentTaxBox-{{post.post_data.id}}" ng-focus="setFocus" focus-me="setFocus" ng-paste="handlePaste($event)"></div>
                            </div>
                            <div class="comment-submit">
                                <button class="btn2" ng-click="sendComment(post.post_data.id, $index, post)">Comment</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      <!--</div>-->
    <!--<img ng-repeat='image in images' ng-src='http://placehold.it/225x250&text={{image}}'><br>-->
  </div>
</div>
<script type='text/javascript'>
      var base_url = '<?php echo base_url(); ?>';
       var user_slug = 'dhaval-shah';
var myApp = angular.module('myApp', ['infinite-scroll']);
myApp.controller('DemoController', function($scope,$http) {
    
    getUserDashboardPost();
    
    function getUserDashboardPost(pagenum = '') { 
        $('#loader').show();
        $http.get(base_url + "user_post/getUserDashboardPost?page=" + pagenum + "&user_slug=" + user_slug).then(function (success) {
            $('#loader').hide();
            $scope.postData = success.data;
          //  check_no_post_data();
           // $('video,audio').mediaelementplayer(/* Options */);
        }, function (error) {});
    }
  //$scope.images = [1, 2, 3, 4, 5, 6, 7, 8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40];
//  $scope.images = [1, 2, 3];

  $scope.loadMore = function() { //alert(111)
    var last = $scope.postData[$scope.postData.length - 1];
    var page = $(".page_number:last").val();
            var total_record = $(".total_record").val();
            var perpage_record = $(".perpage_record").val();
          //  if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
               // if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($(".page_number:last").val()) + 1;
                    alert(pagenum);
                  //  getUserDashboardPostLoad(pagenum);
               // }
          //  }
       $http.get(base_url + "user_post/getUserDashboardPost?page=" + pagenum + "&user_slug=" + user_slug).then(function (success) {
            $('#loader').hide();
            //$scope.postData = success.data;
            $scope.postData.push(last + success.data);
          //  check_no_post_data();
           // $('video,audio').mediaelementplayer(/* Options */);
        }, function (error) {});
//    for(var i = 1; i <= 8; i++) {
//      $scope.images.push(last + i);
//    }
  };
});
</script>
