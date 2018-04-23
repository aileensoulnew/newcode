<header ng-controller="headerCtrl" ng-app="headerApp">
    <div class="animated fadeInDownBig">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6 left-header">
                    <!--<h2 class="logo"><a ng-click="goMainLink('<?php echo base_url('profiles/') . $this->session->userdata('aileenuser_slug'); ?>');" title="Aileensoul"><img ng-src="<?php echo base_url('assets/img/logo-name.png?ver=' . time()) ?>" alt="Aileensoul"></a></h2>-->
                    <h2 class="logo"><a ng-href="<?php echo base_url('profiles/') . $this->session->userdata('aileenuser_slug'); ?>" title="Aileensoul" target="_self"><img ng-src="<?php echo base_url('assets/img/logo-name.png?ver=' . time()) ?>" alt="Aileensoul"></a></h2>
                    <?php
                    $first_segment = $this->uri->segment(1);
                    ?>
                    <?php if (($is_userBasicInfo == '1' || $is_userStudentInfo == '1') && $first_segment != 'business-profile') { ?>
                        <form ng-submit="search_submit" action="<?php echo base_url('searchh') ?>">
                            <input type="text" name="q" placeholder="Search.." id="search">
                        </form>
                    <?php } ?>
                </div>
                <div class="col-md-6 col-sm-6 right-header">
                    <ul>
                        <?php if ($is_userBasicInfo == '1' || $is_userStudentInfo == '1') { ?>
                            
                            <li>
                                <a ng-href="<?php echo base_url('opportunities') ?>" title="Opportunity" target="_self"><img ng-src="<?php echo base_url('assets/n-images/op.png?ver=' . time()) ?>" alt="Opportunity"></a>
                            </li>
                            <li id="add-contact" class="dropdown">
                                <a href="javascript:void(0);" title="Contact Request" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" ng-click="header_contact_request()"><img ng-src="<?php echo base_url('assets/n-images/add-contact.png') ?>" alt="Contact Request">
                                    <span class="noti-box" style="display:block" ng-bind="contact_request_count" ng-if="contact_request_count != '0'"></span>
                                </a>
                                <div class="dropdown-menu">
                                    <div class="dropdown-title">
                                        Contact Request <a href="<?php echo base_url('contact-request') ?>" class="pull-right">See All</a>
                                    </div>
                                    <div class="content custom-scroll">
                                        <ul class="dropdown-data add-dropdown">
                                            <li class="" ng-repeat="contact_request in contact_request_data">
                                                <a href="#">
                                                    <div class="dropdown-database" ng-if="contact_request.status == 'pending'">
                                                        <div class="post-img">
                                                            <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{contact_request.user_image}}" alt="{{contact_request.fullname}}" ng-if="contact_request.user_image != ''">
                                                            <img ng-src="<?php echo NOBUSIMAGE2 ?>" ng-if="contact_request.user_image == ''">
                                                        </div>
                                                        <div class="dropdown-user-detail">
                                                            <div class="user-name">
                                                                <h6><b ng-bind="contact_request.fullname | capitalize"></b></h6>
                                                                <div class="msg-discription" ng-bind="contact_request.designation | capitalize" ng-if="contact_request.designation != ''"></div>
                                                                <div class="msg-discription" ng-bind="contact_request.degree | capitalize" ng-if="contact_request.designation == ''"></div>
                                                                <div class="msg-discription" ng-if="contact_request.designation == '' && contact_request.degree == ''">Current Work</div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                    <div class="dropdown-database confirm_div" ng-if="contact_request.status == 'confirm'">
                                                        <div class="post-img">
                                                            <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{contact_request.user_image}}" alt="{{contact_request.fullname}}" ng-if="contact_request.user_image != ''">
                                                            <img ng-src="<?php echo NOBUSIMAGE2 ?>" ng-if="contact_request.user_image == ''">
                                                        </div>
                                                        <div class="dropdown-user-detail">
                                                            <b ng-bind="contact_request.fullname | capitalize"></b> confirmed your contact request.
                                                            <div class="msg-discription"><span class="time_ago">2 Month Ago</span></div>
                                                        </div> 
                                                    </div>
                                                </a> 
                                                <div class="user-request" ng-if="contact_request.status == 'pending'">
                                                    <a href="javascript:void(0);" class="add-left-true" ng-click="confirmContactRequest(contact_request.from_id, $index)">
                                                        <i class="fa fa-check" aria-hidden="true"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="add-right-true" ng-click="rejectContactRequest(contact_request.from_id, $index)">
                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown">
                                <a href="#" title="Messages" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img ng-src="<?php echo base_url('assets/n-images/message.png?ver=' . time()) ?>" alt="Messages">
                                    <span class="noti-box" style="display:none;">1</span>
                                </a>
                                <div class="dropdown-menu">
                                    <div class="dropdown-title">
                                        Messages <a href="#" class="pull-right">See All</a>
                                    </div>
                                    <div class="content custom-scroll">
                                        <ul class="dropdown-data msg-dropdown">
                                            <li class="">
                                                <a href="#">
                                                    <div class="dropdown-database">
                                                        <div class="post-img">
                                                            <img ng-src="<?php echo base_url('assets/') ?>n-images/user-pic.jpg" alt="No Business Image">
                                                        </div>
                                                        <div class="dropdown-user-detail">
                                                            <h6><b>Atosa Ahmedabad</b></h6>
                                                            <div class="msg-discription">Hello how are you</div>
                                                            <span class="day-text">1 month ago</span>
                                                        </div> 
                                                    </div>
                                                </a> 
                                            </li>
                                            <li class="">
                                                <a href="#">
                                                    <div class="dropdown-database">
                                                        <div class="post-img">
                                                            <img ng-src="<?php echo base_url('assets/') ?>n-images/user-pic.jpg" alt="No Business Image">
                                                        </div>
                                                        <div class="dropdown-user-detail">
                                                            <h6><b>Atosa Ahmedabad</b></h6>
                                                            <div class="msg-discription">Hello how are you</div>

                                                            <span class="day-text">1 month ago</span>

                                                        </div> 
                                                    </div>
                                                </a> 
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown">
                                <a href="#" title="Notification" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img ng-src="<?php echo base_url('assets/n-images/noti.png?ver=' . time()) ?>" alt="Notification"></a>

                                <div class="dropdown-menu">
                                    <div class="dropdown-title">
                                        Notifications <a href="notification.html" class="pull-right">See All</a>
                                    </div>
                                    <div class="content custom-scroll">
                                        <ul class="dropdown-data noti-dropdown">
                                            <li class="">
                                                <a href="#">
                                                    <div class="dropdown-database">
                                                        <div class="post-img">
                                                            <img ng-src="<?php echo base_url('assets/') ?>n-images/user-pic.jpg" alt="No Business Image">
                                                        </div>
                                                        <div class="dropdown-user-detail">
                                                            <h6>
                                                                <b>   Atosa Ahmedabad</b> 
                                                                <span class="">Started following you in business profile.</span>
                                                            </h6>
                                                            <div>

                                                                <span class="day-text">1 month ago</span>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </a> 
                                            </li>
                                            <li class="">
                                                <a href="#">
                                                    <div class="dropdown-database">
                                                        <div class="post-img">
                                                            <img ng-src="<?php echo base_url('assets/') ?>n-images/user-pic.jpg" alt="No Business Image">
                                                        </div>
                                                        <div class="dropdown-user-detail">
                                                            <h6>
                                                                <b>   Atosa Ahmedabad</b> 
                                                                <span class="">Started following you in business profile.</span>
                                                            </h6>
                                                            <div>

                                                                <span class="day-text">1 month ago</span>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </a> 
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <?php
                        }
                        $session_user = $this->session->userdata();
                        ?>
                            <li class="dropdown business_popup" >
                                <a href="javascript:void(0);" title="All Profile" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" ng-click="header_all_profile()"><img ng-src="<?php echo base_url('assets/n-images/all.png') ?>" alt="All Profile"></a>
                                <div class="dropdown-menu"></div>
                            </li>
                        <li class="dropdown user-id">
                            <a href="#" title="<?php echo $session_user['aileenuser_firstname']; ?>" class="dropdown-toggle user-id-custom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <span class="usr-img"><?php if ($session_user['aileenuser_userimage'] != '') { ?><img ng-src="<?php echo USER_THUMB_UPLOAD_URL . $session_user['aileenuser_userimage'] ?>" alt="<?php echo $session_user['aileenuser_firstname'] ?>"><?php } else { ?><div class="custom-user"><?php echo ucfirst(strtolower(substr($session_user['aileenuser_firstname'], 0, 1))); ?></div><?php } ?></span>
                                <span class="pr-name"><?php
                                    if (isset($session_user['aileenuser_firstname'])) {
                                        echo ucfirst($session_user['aileenuser_firstname']);
                                    }
                                    ?></span>
                            </a>
                            <ul class="dropdown-menu profile-dropdown">
                                <li>Account</li>
                                <li><a href="<?php echo base_url().$this->session->userdata('aileenuser_slug'); ?>" title="Setting"><i class="fa fa-user"></i> View Profile</a></li>
                                <li><a href="<?php echo base_url('profile') ?>" title="Setting"><i class="fa fa-cog"></i> Setting</a></li>
                                <li><a href="<?php echo base_url('dashboard/logout') ?>" title="Logout"><i class="fa fa-power-off"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script>
        var app = angular.module('headerApp', []);
</script>     
<script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>