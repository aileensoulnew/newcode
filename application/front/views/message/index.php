<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $head_message; ?>
        <meta charset="utf-8">
        <title>Chat | Aileensoul</title>
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png'); ?>">
        <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
        <?php if (IS_MSG_CSS_MINIFY == '0'){?> 
        <link href="<?php echo base_url() ?>assets/css/style-main.css" rel="stylesheet">
        <?php }else{?>
        <link href="<?php echo base_url() ?>assets/css_min/style-main.css" rel="stylesheet">
        <?php }?>

        <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">

         <?php if (IS_MSG_JS_MINIFY == '0'){?> 
        <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>

        <?php }else{?>
         <script src="<?php echo base_url() ?>assets/js_min/bootstrap.min.js"></script>
        <?php }?>
        <style type="text/css">
            .msg_right:hover .messagedelete{ visibility: visible;opacity: 1;}
            .msg_right .messagedelete{ visibility: hidden;  cursor: pointer; width:25px; float:left;}
            .msg_left_data:hover .messagedelete{ visibility: visible;opacity: 1;}
            .msg_left_data .messagedelete{ visibility: hidden;  cursor: pointer; width:25px; float:left;}
        </style>
    <body>
        <?php echo $header; ?>
        <div class="container">
            <div class="" id="paddingtop_fixed">
                <div class="chat_nobcx">
                    <div class="people-list" id="people-list" ng-app="messageApp" ng-controller="messageController">
                        <div class="search border_btm">
                            <input name="search_key" ng-model="search_key" id="search_key" placeholder="search" type="search">
                            <i class="fa fa-search" id="add_search"></i>
                        </div>
                        <ul class="list">
                            <div id="userlist">
                                <div class="userlist_repeat" ng-repeat="data in loaded_user_data| filter:search">
                                    <a href="<?php echo base_url() ?>chat/abc/5/5/{{data.user_id}}">
                                        <li class="clearfix active">
                                            <div class="chat_heae_img" ng-if="data.business_user_image">
                                                <img src="<?php echo base_url() ?>uploads/business_profile/thumbs/{{data.business_user_image}}" alt="{{data.company_name}}"/>
                                            </div>
                                            <div class="chat_heae_img" ng-if="!data.business_user_image">
                                                <img src="https://www.aileensoul.com/uploads/nobusimage.jpg" alt="Ankit"/>
                                            </div>
                                            <div class="about">
                                                <div class="name">{{data.company_name}}<br></div>
                                                <div>{{data.message}}</div>
                                            </div>
                                        </li>
                                    </a>
                                </div>
                            </div>
                        </ul>
                    </div>
                    <!-- chat start -->
                    <div class="chat" id="chat" style="display:block;">
                        <div class="chat-header clearfix border_btm">
                            <a href="#">
                                <div class="post-img-div">PV</div>
                                <div class="chat-about">
                                    <div class="chat-with">
                                        <span>parimal vasava</span>  
                                    </div>
                                    <div class="chat-num-messages"> Current Work</div>
                                </div>
                            </a>
                            <div class="chat_drop">
                                <a onclick="myFunction()" class="chatdropbtn fr"> 
                                    <img src="https://www.aileensoul.com/assets/img/t_dot.png" onclick="myFunction()">
                                </a>
                                <div id="mychat_dropdown" class="chatdropdown-content">
                                    <a href="javascript:void(0);" onclick="delete_history()">
                                        <span class="h4-img h2-srrt"></span>  Delete All
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="chat-history" id="chat-history">
                            <ul id="received" class="padding_less_right">
                                <li class="clearfix">   
                                    <div class="message-data align-right">    
                                        <span class="message-data-time">31 Oct 2017 10:07</span>&nbsp; &nbsp;    <span class="message-data-name fr">harshad patel <i class="fa fa-circle me"></i></span> 
                                    </div>   
                                    <div class="msg_right"> 
                                        <div class="messagedelete fl">
                                            <a href="javascript:void(0);">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                        </div> 
                                        <div class="message other-message float-right">hello</div>
                                    </div>
                                </li> 
                                <li class="recive-data"> 
                                    <div class="message-data">
                                        <span class="message-data-time">24 Jul 2017 07:02 </span>
                                        <span class="message-data-name fl"><i class="fa fa-circle online"></i>hexel web technology  </span> 
                                    </div>    
                                    <div class="msg_left_data">  
                                        <div class="message my-message">sdf</div>
                                        <div class="messagedelete"> 
                                            <a href="javascript:void(0);" onclick="delete_chat(2, 365)"><i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li class="clearfix">   
                                    <div class="message-data align-right">    
                                        <span class="message-data-time">31 Oct 2017 10:07</span>&nbsp; &nbsp;    <span class="message-data-name fr">harshad patel <i class="fa fa-circle me"></i></span> 
                                    </div>   
                                    <div class="msg_right"> 
                                        <div class="messagedelete fl">
                                            <a href="javascript:void(0);">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                        </div> 
                                        <div class="message other-message float-right">how are you</div>
                                    </div>
                                </li>
                                <li class="recive-data"> 
                                    <div class="message-data">
                                        <span class="message-data-time">24 Jul 2017 07:02 </span>
                                        <span class="message-data-name fl"><i class="fa fa-circle online"></i>hexel web technology  </span> 
                                    </div>    
                                    <div class="msg_left_data">  
                                        <div class="message my-message">hello</div>
                                        <div class="messagedelete"> 
                                            <a href="javascript:void(0);" onclick="delete_chat(2, 365)"><i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                        </div>

                        <div class="panel-footer">
                            <div class="">
                                <div class="" id="msg_block">
                                    <div class="input-group" id="set_input">
                                        <form name="blog">
                                            <div class="comment" name="comments" id="message" onpaste="OnPaste_StripFormatting(this, event);" placeholder="Type your message here..." style="position: relative;" contenteditable="true"></div>
                                            <div for="smily" class="smily_b">
                                                <div>
                                                    <a class="smil" href="#" id="notificationLink1">
                                                        <i class="em em-blush"></i>
                                                    </a>

                                                </div>
                                            </div>
                                        </form>
                                        <span class="input-group-btn">
                                            <button class="btn btn-warning btn-sm main_send" id="submit">Send</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var slug = '<?php echo $slugid; ?>';
        </script>
        <script>
            // Defining angularjs application.
            var messageApp = angular.module('messageApp', []);
            messageApp.controller('messageController', function ($scope, $http) {
                load_message_user();
                function load_message_user() {
                    $http.get(base_url + "message/get_user_list").success(function (data) {
                        $scope.loaded_user_data = data;
                    })
                }
            });
        </script>
    </body>
</html>

