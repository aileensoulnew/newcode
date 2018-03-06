<div class="container pt20">
    <div class="custom-user-list question-page">
        <div class="list-box-custom">
            <h3>Questions</h3>
        </div>
        <div class="all-post-box" ng-repeat="post in postData">
            <div class="all-post-top">
                <div class="post-head">
                    <div class="post-img" ng-if="post.post_data.post_for == 'question'">
                        <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{post.user_data.user_image}}" ng-if="post.user_data.user_image != '' && post.question_data.is_anonymously == '0'">
                        <span class="no-img-post"  ng-if="post.user_data.user_image == '' || post.question_data.is_anonymously == '1'">A</span>
                    </div>
                    <div class="post-img" ng-if="post.post_data.post_for != 'question'">
                        <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{post.user_data.user_image}}" ng-if="post.user_data.user_image != ''">
                        <span class="no-img-post" ng-bind="(post.user_data.first_name| limitTo:1 | uppercase) + (post.user_data.last_name | limitTo:1 | uppercase)"  ng-if="post.user_data.user_image == ''"></span>
                    </div>
                    <div class="post-detail">
                        <div class="fw" ng-if="post.post_data.post_for == 'question'">
                            <a href="javascript:void(0)" class="post-name" ng-if="post.question_data.is_anonymously == '1'">Anonymous</a><span class="post-time" ng-if="post.question_data.is_anonymously == '1'"></span>
                            <a ng-href="<?php echo base_url('profiles/') ?>{{post.user_data.user_slug}}" class="post-name" ng-bind="post.user_data.fullname" ng-if="post.question_data.is_anonymously == '0'"></a><span class="post-time">7 hours ago</span>
                        </div>
                        <div class="fw" ng-if="post.post_data.post_for != 'question'">
                            <a ng-href="<?php echo base_url('profiles/') ?>{{post.user_data.user_slug}}" class="post-name" ng-bind="post.user_data.fullname"></a><span class="post-time">7 hours ago</span>
                        </div>
                        <div class="fw" ng-if="post.post_data.post_for == 'question'">
                            <span class="post-designation" ng-if="post.user_data.title_name != '' && post.question_data.is_anonymously == '0'" ng-bind="post.user_data.title_name"></span>
                            <span class="post-designation" ng-if="post.user_data.title_name == '' && post.question_data.is_anonymously == '0'" ng-bind="post.user_data.degree_name"></span>
                            <span class="post-designation" ng-if="post.user_data.title_name == null && post.user_data.degree_name == null && post.question_data.is_anonymously == '0'" ng-bind="CURRENT WORK"></span>
                        </div>
                        <div class="fw" ng-if="post.post_data.post_for != 'question'">
                            <span class="post-designation" ng-if="post.user_data.title_name != ''" ng-bind="post.user_data.title_name"></span>
                            <span class="post-designation" ng-if="post.user_data.title_name == ''" ng-bind="post.user_data.degree_name"></span>
                            <span class="post-designation" ng-if="post.user_data.title_name == null && post.user_data.degree_name == null" ng-bind="CURRENT WORK"></span>
                        </div>
                    </div>
                    <div class="post-right-dropdown dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img ng-src="<?php echo base_url('assets/n-images/right-down.png') ?>" alt="Right Down"></a>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0);" ng-click="EditPost(post.post_data.id, post.post_data.post_for, $index)">Edit Question</a></li>
                            <li><a href="javascript:void(0);" ng-click="deletePost(post.post_data.id, $index)">Delete Post</a></li>
                        </ul>
                    </div>
                </div>
                <div class="post-discription">
                    <div class="post-des-detail">
                        <p class="question"><a ng-href="<?php echo base_url('questions/') ?>{{post.question_data.id}}/{{post.question_data.question| slugify}}" ng-bind="post.question_data.question" target="_self"></a></p>
                    </div>
                </div>
                <div class="post-bottom">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-5">
                            <ul class="bottom-left">
                                <li class="like-count">
                                    <a href="javascri                                        pt:void(0)" id="post-like-{{post.post_data.id}}" ng-click="post_like(post.post_data.id)" ng-if="post.is_userlikePost == '1'" class="like">Liked</a>
                                    <a                                     href="javascript:void(0)" id="post-lik                                    e-{{post.post_data.id}}" ng-click="post_like(post.post_data.id)" ng-if="post.is_userlikePost == '0'">Like</a>
                                </li>
                                <li class="comment-count"><a href="javascript:void(0)" ng-click="giveAnswer(post.post_data.id)"><span>Give Answer</span></a></li>
                            </ul>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-7">
                            <ul class="pull-right bottom-right">
                                <li class="like-count"><span id="post-like-count-{{post.post_data.id}}" ng-bind="post.post_like_count"></span><span>Like</span></li>
                                <li class="comment-count"><span class="post-comment-count-{{post.post_data.id}}" ng-bind="post.post_comment_count"></span><span>Answers</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="like-other-box">
                    <a href="#" ng-bind="post.post_like_data" id="post-other-like-{{post.post_data.id}}"></a>
                </div>
            </div>
            <div class="ans-text" id="ans-text-{{post.post_data.id}}" style="display:none;"><span>Answers</span></div>
            <div class="all-post-bottom" id="all-post-bottom-{{post.post_data.id}}" style="display:none;">
                <div class="comment-box">
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

        <div class="custom-user-box"  ng-if="pagecntctData.pagedata.total_record == '0'">
            <div class='art-img-nn'>
                <div class='art_no_post_img'>
                    <img src='assets/img/icon_notification_big.png' alt='notification image'>
                </div>
                <div class='art_no_post_text'>No Contacts Available. </div>

            </div>
        </div>
    </div>
    <div class="right-add">
        <div class="custom-user-add">
            <img ng-src="<?php echo base_url('assets/n-images/add.jpg') ?>">
        </div>
    </div>
</div>

<div class="modal fade message-box" id="delete_post_model" role="dialog">
    <div class="modal-dialog modal-lm">
        <div class="modal-content">
            <button type="button" class="modal-close" id="postedit"data-dismiss="modal">&times;</button>       
            <div class="modal-body">
                <span class="mes">
                    <div class="pop_content">Do you want to delete this post?<div class="model_ok_cancel"><a class="okbtn btn1" ng-click="deletedPost(p_d_post_id, p_d_index)" href="javascript:void(0);" data-dismiss="modal">Yes</a><a class="cnclbtn btn1" href="javascript:void(0);" data-dismiss="modal">No</a></div></div>
                </span>
            </div>
        </div>
    </div>
</div>