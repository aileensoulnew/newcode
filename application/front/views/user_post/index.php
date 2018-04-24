<!DOCTYPE html>
<html lang="en" ng-app="userOppoApp" ng-controller="userOppoController" scrollable-container>
    <head>
        <title><?php echo $title; ?></title>
        <meta charset="utf-8">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/bootstrap.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dragdrop/fileinput.css?ver=' . time()); ?>">
        <link href="<?php echo base_url('assets/dragdrop/themes/explorer/theme.css?ver=' . time()) ?>" media="all" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css?ver=' . time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/ng-tags-input.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/angular-tooltips.css?ver=' . time()) ?>">
        <style type="text/css">
            .progress-bar{
                background:linear-gradient(354deg,#1b8ab9 0,#1b8ab9 44%,#3bb0ac 100%)!important
            }
            .progress{
                position:relative;
                width:100%;
                border:1px solid #ddd;
                padding:1px;
                border-radius:3px;
                height:23px
            }
            .bar{
                background-color:#1b8ab9;
                width:0;
                height:20px;
                border-radius:3px
            }
            .percent{
                position:absolute;
                display:inline-block;
                top:3px;
                left:48%
            }
            .bs-example .sr-only{
                position:inherit;
                width:45px;
                height:20px
            }
            .mejs__overlay-button {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
            .mejs__overlay-loading-bg-img {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
            .mejs__button > button {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }

        </style>
    </head>
    <body>
        <?php echo $header_profile; ?>
        <div class="middle-section custom-mob-pd">
            <div class="container">
                <?php echo $n_leftbar; ?>
                <div class="middle-part">
                    <div class="add-post">
                        <div class="post-box">
                            <div class="post-img">
                                <?php if ($leftbox_data['user_image'] != '') { ?> 
                                    <img ng-src="<?php echo USER_THUMB_UPLOAD_URL . $leftbox_data['user_image'] ?>" alt="<?php echo $leftbox_data['first_name'] ?>">  
                                <?php } else { if($leftbox_data['user_gender'] == "M")
                                        {?>                                
                                            <img class="login-user-pro-pic" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                        <?php
                                        }
                                        if($leftbox_data['user_gender'] == "F")
                                        {
                                        ?>
                                            <img class="login-user-pro-pic" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                        <?php
                                        }
                                    } ?>
                            </div>
                            <div class="post-text" data-target="#post-popup" data-toggle="modal" onclick="void(0)">
                                Share an opportunity, Article
                            </div>
                            <!--<span class="post-cam"><i class="fa fa-camera"></i></span>-->
                        </div>
                        <div class="post-box-bottom">
                            <ul>
                                <li>
                                    <a href="#" data-target="#opportunity-popup" data-toggle="modal">
                                        <img src="<?php echo base_url('assets/n-images/post-op.png') ?>"><span><span class="none-479">Post</span> <span> Opportunity</span></span>
                                    </a>
                                </li>
                                <li class="pl15">
                                    <a href="article.html">
                                        <img src="<?php echo base_url('assets/n-images/article.png') ?>"><span><span class="none-479">Post</span> <span> Article</span></span>
                                    </a>
                                </li>
                                <li class="pl15">
                                    <a href="#" data-target="#ask-question" data-toggle="modal">
                                        <img src="<?php echo base_url('assets/n-images/ask-qustion.png') ?>"><span>Ask Question</span>
                                    </a>
                                </li>
                            </ul>
                           
                        </div>
                    </div>
                    <div class="bs-example">
                        <div class="progress progress-striped" id="progress_div" style="display: none;">
                            <div class="progress-bar" style="width: 10%;">
                                <span class="sr-only">0%</span>
                            </div>
                        </div>
                    </div>
                    <!-- Repeated Class Start -->
                    <div class="all_user_post">
                        <div class="user_no_post_avl" ng-if="postData.length == 0"><h3>Feed</h3><div class="user-img-nn">
                                <div class="user_no_post_img">
                                    <img src="<?php echo base_url('assets/img/bui-no.png?ver=' . time()); ?>" alt="bui-no.png">
                                </div>
                                <div class="art_no_post_text">No Feed Available.</div>
                            </div>
                        </div>

                        <div class="fw post_loader" style="text-align:center; display: none;">
                            <img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" />
                        </div>
                        <div ng-if="postData.length != 0" class="all-post-box" ng-repeat="post in postData">
                            <!--<input type="hidden" name="post_index" class="post_index" ng-class="post_index" ng-model="post_index" ng-value="{{$index + 1}}">-->
                            <input type="hidden" name="page_number" class="page_number" ng-class="page_number" ng-model="post.page_number" ng-value="{{post.page_data.page}}">
                            <input type="hidden" name="total_record" class="total_record" ng-class="total_record" ng-model="post.total_record" ng-value="{{post.page_data.total_record}}">
                            <input type="hidden" name="perpage_record" class="perpage_record" ng-class="perpage_record" ng-model="post.perpage_record" ng-value="{{post.page_data.perpage_record}}">
                            <div class="all-post-top">
                                <div class="post-head">
                                    <div class="post-img" ng-if="post.post_data.post_for == 'question'">
                                        <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{post.user_data.user_image}}" ng-if="post.user_data.user_image != '' && post.question_data.is_anonymously == '0'">
                                        <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.user_data.user_image == '' && post.user_data.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                        <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.user_data.user_image == '' && post.user_data.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                    </div>
                                    <div class="post-img" ng-if="post.post_data.post_for != 'question'">
                                        <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{post.user_data.user_image}}" ng-if="post.user_data.user_image != ''">
                                        <span class="no-img-post" ng-bind="(post.user_data.first_name| limitTo:1 | uppercase) + (post.user_data.last_name | limitTo:1 | uppercase)"  ng-if="post.user_data.user_image == ''"></span>
                                        <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.user_data.user_image == '' && post.user_data.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                        <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.user_data.user_image == '' && post.user_data.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                    </div>
                                    <div class="post-detail">
                                        <div class="fw" ng-if="post.post_data.post_for == 'question'">
                                            <a href="javascript:void(0)" class="post-name" ng-if="post.question_data.is_anonymously == '1'">Anonymous</a><span class="post-time" ng-if="post.question_data.is_anonymously == '1'"></span>
                                            <a ng-href="<?php echo base_url('profiles/') ?>{{post.user_data.user_slug}}" class="post-name" ng-bind="post.user_data.fullname" ng-if="post.question_data.is_anonymously == '0'"></a><span class="post-time">{{post.post_data.time_string}}</span>
                                        </div>
                                        <div class="fw" ng-if="post.post_data.post_for != 'question'">
                                            <a ng-href="<?php echo base_url('profiles/') ?>{{post.user_data.user_slug}}" class="post-name" ng-bind="post.user_data.fullname"></a><span class="post-time">{{post.post_data.time_string}}</span>
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
                                <div class="post-discription" ng-if="post.post_data.post_for == 'profile_update'">
                                    <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{post.profile_update.data_value}}">
                                </div>
                                <div class="post-discription" ng-if="post.post_data.post_for == 'cover_update'">
                                    <img ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{post.cover_update.data_value}}" ng-if="post.cover_update.data_value != ''">
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
                                            <video controls width = "100%" height = "350" preload="metadata" >
                                                <source ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}#t=0.1" type="video/mp4">
                                            </video>
                                            <!--<video controls poster="" class="mejs__player" ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}"></video>-->
                                        </span>
                                        <span  ng-if="post_file.file_type == 'audio'">
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
                                    </span>
                                </div>
                                <div class="post-images four-img" ng-if="post.post_data.total_post_files >= '4'">
                                    <div class="two-img" ng-repeat="post_file in post.post_file_data| limitTo:4">
                                        <a href="#"><img ng-src="<?php echo USER_POST_RESIZE2_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}"></a>
                                        <div class="view-more-img" ng-if="$index == '3' && post.post_data.total_post_files > '4'">
                                            <span>View All (+4)</span>
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
                                    <a href="javascript:void(0)" ng-click="like_user_list(post.post_data.id);" ng-bind="post.post_like_data" id="post-other-like-{{post.post_data.id}}"></a>
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
                                                <img ng-class="comment.commented_user_id == user_id ? 'login-user-pro-pic' : ''" ng-if=" comment.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                <img ng-class="comment.commented_user_id == user_id ? 'login-user-pro-pic' : ''" ng-if=" comment.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                            </div>
                                        </div>
                                        <div class="comment-dis">
                                            <div class="comment-name"><a ng-bind="comment.username"></a></div>
                                            <div class="comment-dis-inner" id="comment-dis-inner-{{comment.comment_id}}" ng-bind-html="comment.comment"></div>
                                            <div class="edit-comment" id="edit-comment-{{comment.comment_id}}" style="display:none;">
                                                <div class="comment-input">
                                                    <!--<div contenteditable data-directive ng-model="editComment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendEditComment({{comment.comment_id}},$index,post)" id="editCommentTaxBox-{{comment.comment_id}}" ng-focus="setFocus" focus-me="setFocus" onpaste="OnPaste_StripFormatting(event);"></div>-->
                                                    <div contenteditable="true" data-directive ng-model="editComment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendEditComment({{comment.comment_id}},$index,post)" id="editCommentTaxBox-{{comment.comment_id}}" ng-focus="setFocus" focus-me="setFocus" role="textbox" spellcheck="true" ng-paste="handlePaste($event)"></div>
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
                                                <li><a href="javascript:void(0);" ng-bind="comment.comment_time_string"></a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="add-comment">
                                        <div class="post-img">
                                            <?php if ($leftbox_data['user_image'] != '') { ?> 
                                                <img ng-src="<?php echo USER_THUMB_UPLOAD_URL . $leftbox_data['user_image'] . '?ver=' . time() ?>" alt="<?php echo $leftbox_data['first_name'] ?>">  
                                            <?php } else {

                                                    if($leftbox_data['user_gender'] == "M")
                                                    {?>                                
                                                        <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                    <?php
                                                    }
                                                    if($leftbox_data['user_gender'] == "F")
                                                    {
                                                    ?>
                                                        <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                                    <?php
                                                    }                                
                                            } ?>

                                        </div>
                                        <div class="comment-input">
                                            <div contenteditable="true" data-directive ng-model="comment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendComment({{post.post_data.id}},$index,post)" id="commentTaxBox-{{post.post_data.id}}" ng-focus="setFocus" focus-me="setFocus" ng-paste="handlePaste($event)"></div>
                                        </div>
                                        <div class="mob-comment">
                                                    <button ng-click="sendComment(post.post_data.id, $index, post)">
                                                        <img ng-src="<?php echo base_url('assets/img/send.png?ver=' . time()) ?>">
                                                    </button>
                                                </div>
                                        <div class="comment-submit hidden-mob">
                                            <button class="btn2" ng-click="sendComment(post.post_data.id, $index, post)">Comment</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Repeated Class Complete -->
                    <div class="fw" id="loader" style="text-align:center; display: block;"><img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" /></div>
                </div>

                <div class="right-part">
                    <div class="add-box">
                        <img ng-src="<?php echo base_url('assets/n-images/add.jpg') ?>">
                    </div>
                    <div class="all-contact">
                        <h4>Contacts<a href="<?php echo base_url('contact-request') ?>" class="pull-right" target="_blank">All</a></h4>
                        <div class="all-user-list">
                            <data-owl-carousel class="owl-carousel" data-options="">
                                <div owl-carousel-item="" ng-repeat="contact in contactSuggetion" class="item">
                                    <div class="item" id="item-{{contact.user_id}}">
                                        <div class="post-img" ng-if="contact.user_image != ''">
                                            <a href="profiles/{{contact.user_slug}}" >
                                                <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{contact.user_image}}">
                                            </a>
                                        </div>
                                        <a href="profiles/{{contact.user_slug}}" >
                                            <div class="post-img" ng-if="contact.user_image == ''">
                                                <div class="post-img-mainuser">
                                                    {{contact.first_name| limitTo:1 | uppercase}}{{contact.last_name| limitTo:1 | uppercase}}
                                                </div>
                                            
                                            </div>
                                        </a>
                                        <div class="user-list-detail">
                                            <p class="contact-name"><a href="profiles/{{contact.user_slug}}" ng-bind="(contact.first_name | limitTo:1 | uppercase) + (contact.first_name.substr(1) | lowercase)"></a></p>
                                            <p class="contact-designation">
                                                <a href="profiles/{{contact.user_slug}}" ng-if="contact.title_name != ''">{{contact.title_name| uppercase}}</a>
                                                <a href="profiles/{{contact.user_slug}}" ng-if="contact.title_name == ''">{{contact.degree_name| uppercase}}</a>
                                                <a href="profiles/{{contact.user_slug}}" ng-if="contact.title_name == null && contact.degree_name == null">CURRENT WORK</a>
                                            </p>
                                        </div>
                                        <button class="follow-btn" ng-click="addToContact(contact.user_id, contact)">Add to contact</button>
                                    </div>
                                </div>
                                <div owl-carousel-item="" class="item last-item-box">
                                    <a href="<?php echo base_url('contact-request') ?>">
                                        <div class="item" id="last-item">
                                            <div class="post-img" ng-if="contact.user_image != ''">
                                                <img ng-src="<?php echo base_url('assets/n-images/view-all.png?ver=' . time()) ?>">
                                            </div>
                                            <div class="user-list-detail">
                                                <p class="contact-name"><a href="#">Find More Contacts</a></p>
                                            </div>
                                            <button class="follow-btn">View More</button>
                                        </div>
                                    </a>
                                </div>
                            </data-owl-carousel>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="display:none;" class="modal fade" id="post-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <div class="post-popup-box">
                        <form  id="post_something" name="post_something" ng-submit="post_something_check(event)">
                            <div class="post-box">
                                <div class="post-img">
                                    <?php
                                    if ($leftbox_data['user_image'] != '')
                                    { ?>
                                        <img class="login-user-pro-pic" ng-src="<?php echo USER_THUMB_UPLOAD_URL . $leftbox_data['user_image'] . '?ver=' . time() ?>" alt="<?php echo $leftbox_data['first_name'] ?>">  
                                    <?php
                                    }
                                    else
                                    { 
                                        if($leftbox_data['user_gender'] == "M")
                                        {?>                                
                                            <img class="login-user-pro-pic" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                        <?php
                                        }
                                        if($leftbox_data['user_gender'] == "F")
                                        {
                                        ?>
                                            <img class="login-user-pro-pic" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                        <?php
                                        } 
                                    } ?>
                                </div>
                                <div class="post-text">
                                    <textarea name="description" ng-model="sim.description" id="description" class="title-text-area" placeholder="Write something here..."></textarea>
                                </div>
                                <div class="all-upload" ng-if="is_edit != 1">
                                    <div class="form-group">
                                        <div id="fileCountSim"></div>
                                        <div id="selectedFiles" class="file-preview">
                                        </div>
                                        <input file-input="files" ng-file-model="sim.postfiles" type="file" id="fileInput1" name="postfiles[]" data-overwrite-initial="false" data-min-file-count="2"  multiple style="display: none;">
                                    </div>
                                    <label for="fileInput1" ng-click="postFiles()">
                                        <i class="fa fa-camera upload_icon" onclick="javascript:$('#fileInput1').attr('accept','image/*');"><span class="upload_span_icon"> Photo </span></i>
                                        <i class="fa fa-video-camera upload_icon" onclick="javascript:$('#fileInput1').attr('accept','video/*');"><span class="upload_span_icon"> Video</span>  </i> 
                                        <i class="fa fa-music upload_icon" onclick="javascript:$('#fileInput1').attr('accept','audio/*');"> <span class="upload_span_icon">  Audio </span> </i>
                                        <i class="fa fa-file-pdf-o upload_icon" onclick="javascript:$('#fileInput1').attr('accept','.pdf');"><span class="upload_span_icon"> PDF </span></i>
                                    </label>
                                </div>
                                <div class="post-box-bottom" >
                                    <ul ng-if="is_edit != 1">
                                        <li>
                                            <a href="#"  class="post-opportunity-modal" data-target="#opportunity-popup" data-toggle="modal" data-dismiss="modal">
                                                <img src="<?php echo base_url('assets/n-images/post-op.png') ?>"><span><span class="none-479">Post</span> <span>Opportunity</span></span>
                                            </a>
                                        </li>
                                        <li class="pl15">
                                            <a href="article.html">
                                                <img src="<?php echo base_url('assets/n-images/article.png') ?>"><span><span class="none-479">Post</span> <span>Article</span></span>
                                            </a>
                                        </li>
                                        <li class="pl15">
                                            <a href="#" class="post-ask-question-modal"  data-target="#ask-question" data-toggle="modal">
                                                <img src="<?php echo base_url('assets/n-images/ask-qustion.png') ?>"><span>Ask Question</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <input type="hidden" name="post_for" ng-model="sim.post_for" class="form-control" value="">
                                    <input type="hidden" ng-if="is_edit == 1" id="edit_post_id" name="edit_post_id" ng-model="sim.edit_post_id" class="form-control" value="{{sim.edit_post_id}}">
                                    <p class="pull-right">
                                        <button type="submit" class="btn1" value="Submit">Post</button>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div style="display:none;" class="modal fade" id="opportunity-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <div class="post-popup-box">
                        <form id="post_opportunity" name="post_opportunity" ng-submit="post_opportunity_check(event)">
                            <div class="post-box">
                                <div class="post-img">
                                    <?php
                                    if ($leftbox_data['user_image'] != '')
                                    { ?>
                                        <img class="login-user-pro-pic" ng-src="<?php echo USER_THUMB_UPLOAD_URL . $leftbox_data['user_image'] . '?ver=' . time() ?>" alt="<?php echo $leftbox_data['first_name'] ?>">  
                                    <?php
                                    }
                                    else
                                    { 
                                        if($leftbox_data['user_gender'] == "M")
                                        {?>                                
                                            <img class="login-user-pro-pic" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                        <?php
                                        }
                                        if($leftbox_data['user_gender'] == "F")
                                        {
                                        ?>
                                            <img class="login-user-pro-pic" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                        <?php
                                        } 
                                    } ?>
                                </div>
                                <div class="post-text">
                                    <textarea name="description" ng-model="opp.description" id="description" class="title-text-area" placeholder="Post Opportunity"></textarea>
                                </div>

                                <div class="all-upload" ng-if="is_edit != 1">
                                    <div class="form-group">
                                        <div id="fileCountOpp"></div>
                                        <div id="selectedFilesOpp" class="file-preview"></div>

                                        <input file-input="files" ng-file-model="opp.postfiles" type="file" id="fileInput" name="postfiles[]" data-overwrite-initial="false" data-min-file-count="2"  multiple style="display: none;">
                                    </div>
                                    <label for="fileInput" ng-click="postFiles()">
                                        <i class="fa fa-camera upload_icon" onclick="javascript:$('#fileInput').attr('accept','image/*');"><span class="upload_span_icon"> Photo </span></i>
                                        <i class="fa fa-video-camera upload_icon" onclick="javascript:$('#fileInput').attr('accept','video/*');"><span class="upload_span_icon"> Video</span>  </i> 
                                        <i class="fa fa-music upload_icon" onclick="javascript:$('#fileInput').attr('accept','audio/*');"> <span class="upload_span_icon">  Audio </span> </i>
                                        <i class="fa fa-file-pdf-o upload_icon" onclick="javascript:$('#fileInput').attr('accept','.pdf');"><span class="upload_span_icon"> PDF </span></i>
                                    </label>
                                </div>
                            </div>
                            <div class="post-field">
                                <div id="content" class="form-group">
                                    <label>For whom this opportunity?<span class="pull-right"><img ng-src="<?php echo base_url('assets/n-images/tooltip.png') ?>" tooltips tooltip-append-to-body="true" tooltip-close-button="true" tooltip-side="right" tooltip-hide-trigger="click" tooltip-template="I'm a tooltip that is kwjnefk jnkwjenfkjnk kjwnekjn kjwnekfjn kjwenfkjnkwjnekfjnwkejnf kjwnef bounded on body!" alt="tooltip"></span></label>
                                    <tags-input id="job_title" ng-model="opp.job_title" display-property="name" placeholder="Ex: Seeking Opportunity, CEO, Enterpreneur, Founder, Singer, Photographer...." replace-spaces-with-dashes="false" template="title-template" on-tag-added="onKeyup()">
                                        <auto-complete source="loadJobTitle($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="title-autocomplete-template"></auto-complete>
                                    </tags-input>
                                    <script type="text/ng-template" id="title-template">
                                        <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                                    </script>
                                    <script type="text/ng-template" id="title-autocomplete-template">
                                        <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                                    </script>
                                </div>

                                <div class="form-group">
                                    <label>For which location?<span class="pull-right"><img ng-src="<?php echo base_url('assets/n-images/tooltip.png') ?>" alt="tooltip"></span></label>
                                    <tags-input id="location" ng-model="opp.location" display-property="city_name" placeholder="Ex: Mumbai, Delhi, New south wels, London, New York, Captown, Sydeny, Shanghai...." replace-spaces-with-dashes="false" template="location-template" on-tag-added="onKeyup()">
                                        <auto-complete source="loadLocation($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="location-autocomplete-template"></auto-complete>
                                    </tags-input>
                                    <script type="text/ng-template" id="location-template">
                                        <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                                    </script>
                                    <script type="text/ng-template" id="location-autocomplete-template">
                                        <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                                    </script>
                                </div>
                                <div class="form-group">
                                    <label>For which field?<span class="pull-right"><img ng-src="<?php echo base_url('assets/n-images/tooltip.png') ?>" alt="tooltip"></span></label>
                                    <!--<input name="field" id="field" type="text" placeholder="What is your field?" autocomplete="off">-->
                                    <span class="select-field-custom">
                                        <select name="field" ng-model="opp.field" id="field" ng-change="other_field(this)" class="post-opportunity-field">
                                            <option value="" selected="selected">Select your field</option>
                                            <option data-ng-repeat='fieldItem in fieldList' value='{{fieldItem.industry_id}}'>{{fieldItem.industry_name}}</option>             
                                            <option value="0">Other</option>
                                        </select>
                                    </span>
                                </div>
                                <div class="form-group" ng-if="field == '0'">
                                    <input type="text" class="form-control" ng-model="opp.otherField" placeholder="Enter other field" ng-required="true" autocomplete="off">
                                </div>
                                <input type="hidden" name="post_for" ng-model="opp.post_for" class="form-control" value="">
                                <input type="hidden" ng-if="is_edit == 1" id="opp_edit_post_id" name="opp_edit_post_id" ng-model="opp.edit_post_id" class="form-control" value="{{opp.edit_post_id}}">
                            </div>
                            <div class="text-right fw pt10 pb20 pr15">
                                <button type="submit" class="btn1"  value="Submit">Post</button>    
                            </div>
                            <?php // echo form_close(); ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div style="display:none;" class="modal fade" id="ask-question" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <div class="post-popup-box">
                        <form id="ask_question" name="ask_question" ng-submit="ask_question_check(event)">
                            <div class="post-box">
                                <div class="post-img">
                                    <?php
                                    if ($leftbox_data['user_image'] != '')
                                    { ?>
                                        <img class="login-user-pro-pic" ng-src="<?php echo USER_THUMB_UPLOAD_URL . $leftbox_data['user_image'] . '?ver=' . time() ?>" alt="<?php echo $leftbox_data['first_name'] ?>">  
                                    <?php
                                    }
                                    else
                                    {
                                        if($leftbox_data['user_gender'] == "M")
                                        {?>                                
                                            <img class="login-user-pro-pic" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                        <?php
                                        }
                                        if($leftbox_data['user_gender'] == "F")
                                        {
                                        ?>
                                            <img class="login-user-pro-pic" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                        <?php
                                        } 
                                    } ?>
                                </div>
                                <div class="post-text">
                                    <!--<textarea class="title-text-area" ng-keyup="questionList()" ng-model="ask.ask_que" id="ask_que" placeholder="Ask Question" typeahead="item as item.question for item in queSearchResult | filter:$viewValue" autocomplete="off"></textarea>-->
                                    <textarea class="title-text-area" ng-keyup="questionList()" ng-model="ask.ask_que" id="ask_que" placeholder="Ask Question"></textarea>
                                    <ul class="questionSuggetion custom-scroll">
                                        <li ng-repeat="que in queSearchResult">
                                            <a ng-href="<?php echo base_url('questions/') ?>{{que.id}}/{{que.question| slugify}}" ng-bind="que.question"></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="all-upload" ng-if="is_edit != 1">
                                    <div class="form-group">
                                        <div id="fileCountQue"></div>
                                        <div id="selectedFilesQue" class="file-preview"></div>
                                        <input file-input="files" ng-file-model="ask.postfiles" type="file" id="fileInput2" name="postfiles[]" data-overwrite-initial="false" data-min-file-count="2"  multiple style="display: none;">
                                    </div>
                                    <label for="fileInput2" ng-click="postFiles()">
                                        <i class="fa fa-camera upload_icon"><span class="upload_span_icon"> Add Screenshot </span></i>
                                    </label>
                                    <div class="add-link" ng-click="ShowHide()">
                                        <i class="fa fa fa-link upload_icon"><span class="upload_span_icon"> Add Link</span>  </i> 
                                    </div>
                                    <div class="form-group"  ng-show = "IsVisible">
                                        <input type="text" ng-model="ask.web_link" class="" placeholder="Add Your Web Link">
                                    </div>
                                </div>
                            </div>
                            <div class="post-field">
                                <div class="form-group">
                                    <label>Add Description<span class="pull-right"><img ng-src="<?php echo base_url('assets/n-images/tooltip.png') ?>" alt="tooltip"></span></label>
                                    <textarea rows="1" max-rows="5" ng-model="ask.ask_description" placeholder="Add Description" cols="10" style="resize:none"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Related Categories<span class="pull-right"><img ng-src="<?php echo base_url('assets/n-images/tooltip.png') ?>" alt="tooltip"></span></label>
                                    <tags-input id="ask_related_category" ng-model="ask.related_category" display-property="name"placeholder="Related Category" replace-spaces-with-dashes="false" template="category-template" on-tag-added="onKeyup()">
                                        <auto-complete source="loadCategory($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="category-autocomplete-template"></auto-complete>
                                    </tags-input>
                                    <script type="text/ng-template" id="category-template">
                                        <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                                    </script>
                                    <script type="text/ng-template" id="category-autocomplete-template">
                                        <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                                    </script>
                                </div>
                                <div class="form-group">
                                    <label>From which field the Question asked?<span class="pull-right"><img ng-src="<?php echo base_url('assets/n-images/tooltip.png') ?>" alt="tooltip"></span></label>
                                    <span class="select-field-custom">
                                        <select ng-model="ask.ask_field" id="ask_field">
                                            <option value="" selected="selected">Field</option>
                                            <option data-ng-repeat='fieldItem in fieldList' value='{{fieldItem.industry_id}}'>{{fieldItem.industry_name}}</option>             
                                            <option value="0">Other</option>
                                        </select>
                                    </span>
                                </div>

                                <div class="form-group" ng-if="ask.ask_field == '0'">
                                    <input type="text" class="form-control" ng-model="ask.otherField" placeholder="Enter other field" ng-required="true" autocomplete="off">
                                </div>
                                <input type="hidden" name="post_for" ng-model="ask.post_for" class="form-control" value="">
                                <input type="hidden" ng-if="is_edit == 1" id="ask_edit_post_id" name="ask_edit_post_id" ng-model="ask.edit_post_id" class="form-control" value="{{ask.edit_post_id}}">
                            </div>
                            <div class="text-right fw pt10 pb20 pr15">
                                <div class="add-anonymously">
                                    <label class="control control--checkbox" title="Checked this">Add Anonymously<input type="checkbox" ng-model="ask.is_anonymously" value="1"><div class="control__indicator"></div></label>
                                </div>
                                <button type="submit" class="btn1"  value="Submit">Post</button> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box biderror" id="posterrormodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="posterror-modal-close" data-dismiss="modal">&times;
                    </button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box" id="post" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" id="post" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box" id="delete_model" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" id="postedit"data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                            <div class="pop_content">Do you want to delete this comment?<div class="model_ok_cancel"><a class="okbtn btn1" ng-click="deleteComment(c_d_comment_id, c_d_post_id, c_d_parent_index, c_d_index, c_d_post)" href="javascript:void(0);" data-dismiss="modal">Yes</a><a class="cnclbtn btn1" href="javascript:void(0);" data-dismiss="modal">No</a></div></div>
                        </span>
                    </div>
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
        
        <div class="modal fade message-box like-popup" id="likeusermodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                     <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <h3>{{count_likeUser}} Likes</h3>
                    <div class="modal-body padding_less_right">
                        <div class="">
                            <ul>
                                
                                
                                <li class="like-img" ng-repeat="userlist in get_like_user_list">
                                    <a class="ripple" href="<?php echo base_url('profiles/'); ?>{{userlist.user_slug}}" ng-if="userlist.user_image != null">
                                        <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{userlist.user_image}}">
                                    </a>
                                      <a class="ripple" href="<?php echo base_url('profiles/'); ?>{{userlist.user_slug}}" ng-if="userlist.user_image == null">
                                        <div class="post-img-mainuser">{{userlist.first_name| limitTo:1 | uppercase}}{{userlist.last_name| limitTo:1 | uppercase}}</div>
                                    </a>
                                    <div class="like-detail">
                                        <h4><a href="<?php echo base_url('profiles/'); ?>{{userlist.user_slug}}">{{userlist.fullname}}</a></h4>
                                        <p ng-if="userlist.title_name == ''">{{userlist.degree_name}}</p>
                                        <p ng-if="userlist.title_name != null">{{userlist.title_name}}</p>
                                        <p ng-if="(userlist.title_name == null) && (userlist.degree_name == null)">Current work</p>
                                    </div>

                                </li>
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>

        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.form.3.51.js?ver=' . time()) ?>"></script> 
        <script src="<?php echo base_url('assets/dragdrop/js/plugins/sortable.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/fileinput.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/locales/fr.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/locales/es.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/themes/explorer/theme.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/as-videoplayer/demo.js?ver=' . time()); ?>"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>
        <script>
                                var base_url = '<?php echo base_url(); ?>';
                                var slug = '<?php echo $slugid; ?>';
                                var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
                                var title = '<?php echo $title; ?>';
                                var no_user_post_html = '<?php echo $no_user_post_html; ?>';
                                var header_all_profile = '<?php echo $header_all_profile; ?>';
                                var app = angular.module('userOppoApp', ['ui.bootstrap', 'ngTagsInput', 'ngSanitize']);
        </script>               
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_post.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/classie.js?ver=' . time()) ?>"></script>
        <script>
			var menuRight = document.getElementById( 'cbp-spmenu-s2' ),
				showRight = document.getElementById( 'showRight' ),
				body = document.body;

			showRight.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( menuRight, 'cbp-spmenu-open' );
				disableOther( 'showRight' );
			};
		
			function disableOther( button ) {
				
				if( button !== 'showRight' ) {
					classie.toggle( showRight, 'disabled' );
				}
			}
			
			$(function () {
				$('a[href="#search"]').on('click', function (event) {
					event.preventDefault();
					$('#search').addClass('open');
					$('#search > form > input[type="search"]').focus();
				});
				$('#search, #search button.close-new').on('click keyup', function (event) {
					if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
						$(this).removeClass('open');
					}
				});
			});
		</script>
                <script>
                    jQuery(document).ready(function($) {
                        $("li.user-id label").click(function(e){
                            $(this).next('ul.dropdown-menu').toggle();
                            e.stopPropagation();
                            });
                    });
                   
                </script>
    </body>
</html>