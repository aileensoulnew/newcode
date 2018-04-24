<?php
$session_user = $this->session->userdata();
$userData = $this->user_model->getUserData($session_user['aileenuser']);
$browser = $this->agent->browser();
$browserVersion = $this->agent->version();
if($browser == "Internet Explorer")
{
    if(explode(".", $browserVersion)[0] < 12)
    {
        echo "<div class='update-browser'>For a better experience, update your browser.</div>";
    }
}
if($browser == "Chrome")
{            
    if(explode(".", $browserVersion)[0] < 70)
    {
        echo "<div class='update-browser'>For a better experience, update your browser.</div>";
    }
}
if($browser == "Firefox")
{            
    if(explode(".", $browserVersion)[0] < 60)
    {
        echo "<div class='update-browser'>For a better experience, update your browser.</div>";
    }
}
?>
<div class="web-header">
    <header class="custom-header" ng-controller="headerCtrl">
    <div class="header animated fadeInDownBig">
        <div class="container">
            <div class="row">

                <div class="col-md-6 col-sm-6 left-header">
                    <!--<h2 class="logo"><a ng-click="goMainLink('<?php echo base_url('profiles/') . $this->session->userdata('aileenuser_slug'); ?>');" title="Aileensoul"><img ng-src="<?php echo base_url('assets/img/logo-name.png?ver=' . time()) ?>" alt="Aileensoul"></a></h2>-->
                    <h2 class="logo"><a ng-href="<?php echo base_url(); ?>" title="Aileensoul" target="_self"><img ng-src="<?php echo base_url('assets/img/logo-name.png?ver=' . time()) ?>" alt="Aileensoul"></a></h2>
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
                                <a ng-href="<?php echo base_url() ?>" title="Opportunity" target="_self"><img ng-src="<?php echo base_url('assets/n-images/op.png?ver=' . time()) ?>" alt="Opportunity"></a>
                            </li>
                            <li id="add-contact" class="dropdown">
                                <a href="javascript:void(0);" title="Contact Request" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" ng-click="header_contact_request()"><img ng-src="<?php echo base_url('assets/n-images/add-contact.png') ?>" alt="Contact Request">
                                    <span class="noti-box" style="display:block" ng-bind="contact_request_count" ng-if="contact_request_count != '0'"></span>
                                </a>
                                <div class="dropdown-menu">
                                    <div class="dropdown-title">
                                        Contact Request <a href="<?php echo base_url('contact-request') ?>" class="pull-right">See All</a>
                                    </div>
                                    <div class="fw" id="contact_loader"  style="display:none; text-align:center;">
                                        <img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" alt="<?php echo 'LOADERIMAGE'; ?>"/>
                                    </div>
                                    <div class="content custom-scroll">
                                        <ul class="dropdown-data add-dropdown">
                                            <li class="" ng-repeat="contact_request in contact_request_data">
                                                <a href="<?php echo base_url(); ?>{{contact_request.user_slug}}" target="_self">
                                                    <div class="dropdown-database" ng-if="contact_request.status == 'pending'">
                                                        <div class="post-img" ng-if="contact_request.user_image != ''">
                                                            <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{contact_request.user_image}}" alt="{{contact_request.fullname}}">
                                                        </div>
                                                        <div class="post-img" ng-if="contact_request.user_image == ''">
                                                            <img ng-if="contact_request.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                            <img ng-if="contact_request.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                                        </div>
                                                        <div class="dropdown-user-detail">
                                                            <div class="user-name">
                                                                <h6><b ng-bind="contact_request.fullname | capitalize"></b></h6>
                                                                <div class="msg-discription" ng-bind="contact_request.designation | capitalize" ng-if="contact_request.designation != ''"></div>
                                                                <div class="msg-discription" ng-bind="contact_request.degree | capitalize" ng-if="contact_request.designation == ''"></div>
                                                                <div class="msg-discription" ng-if="contact_request.designation == '' && contact_request.degree == ''">Current Work</div>
                                                                <div class="msg-discription"><span class="time_ago">{{contact_request.time_string}}</span></div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </a>
                                                <a href="<?php echo base_url(); ?>{{contact_request.user_slug}}" target="_self">
                                                    <div class="dropdown-database confirm_div" ng-if="contact_request.status == 'confirm'">
                                                        <div class="post-img" ng-if="contact_request.user_image != ''">
                                                            <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{contact_request.user_image}}" alt="{{contact_request.fullname}}">
                                                        </div>
                                                        <div class="post-img" ng-if="contact_request.user_image == ''">
                                                            <img ng-if="contact_request.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                            <img ng-if="contact_request.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                                        </div>
                                                        <div class="dropdown-user-detail">
                                                            <b ng-bind="contact_request.fullname | capitalize"></b> confirmed your contact request.
                                                            <div class="msg-discription"><span class="time_ago">{{contact_request.time_string}}</span></div>
                                                        </div> 
                                                    </div>
                                                </a> 
                                                <div class="user-request" ng-if="contact_request.status == 'pending'">
                                                    <a href="javascript:void(0);" class="add-left-true" ng-click="confirmContactRequest(contact_request.from_id,$index)">
                                                        <i class="fa fa-check" aria-hidden="true"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="add-right-true" ng-click="rejectContactRequest(contact_request.from_id,$index)">
                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                            </li>
                                            <li ng-if="contact_request_data.length == 0">
                                                <div class="no-data-content">
                                                    <p><img src="<?php echo base_url('assets/img/No_Contact_Request.png');?>"></p>
                                                    <p class="pt20">No Contact Notification</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown">
                                <a href="javascript:void(0);" title="Messages" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img ng-src="<?php echo base_url('assets/n-images/message.png?ver=' . time()) ?>" alt="Messages">
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
                                <a href="javascript:void(0);" title="Notification" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img ng-src="<?php echo base_url('assets/n-images/noti.png?ver=' . time()) ?>" alt="Notification"></a>

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
                                                                <b>Atosa Ahmedabad</b> 
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
                        ?>
                            <li class="dropdown all">
                                <a href="javascript:void(0);" title="All Profile" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" ng-click="header_all_profile()"><img ng-src="<?php echo base_url('assets/n-images/all.png') ?>" alt="All Profile"></a>
                                <div class="dropdown-menu"></div>
                            </li>
                        <li class="dropdown user-id">
                            <label title="<?php echo $session_user['aileenuser_firstname']; ?>" class="dropdown-toggle user-id-custom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <span class="usr-img" id="header-main-profile-pic">
                                    <?php
                                    if ($session_user['aileenuser_userimage'] != '')
                                    {?>
                                        <img ng-src="<?php echo USER_THUMB_UPLOAD_URL . $session_user['aileenuser_userimage'] ?>" alt="<?php echo $session_user['aileenuser_firstname'] ?>">
                                    <?php
                                    }
                                    else
                                    {
                                        if($userData['user_gender'] == "M")
                                        {?>
                                            <img ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                        <?php
                                        }
                                        if($userData['user_gender'] == "F")
                                        {
                                        ?>
                                            <img ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                        <?php
                                        }
                                    } ?>
                                </span>
                                <span class="pr-name"><?php
                                    if (isset($session_user['aileenuser_firstname'])) {
                                        echo ucfirst($session_user['aileenuser_firstname']);
                                    }
                                    ?></span>
                            </label>
                            <ul class="dropdown-menu profile-dropdown">
                                <li>Account</li>
                                <li><a ng-href="<?php echo base_url().$this->session->userdata('aileenuser_slug'); ?>" href="<?php echo base_url().$this->session->userdata('aileenuser_slug'); ?>" title="Setting"><i class="fa fa-user"></i> View Profile</a></li>
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
</div>
<div class="mobile-header">
    <header class="">
		<div class="header animated fadeInDownBig">
            <div class="container">
                <div class="left-header">
                    <h2 class="logo"><a href="#"><img ng-src="<?php echo base_url('assets/n-images/mob-logo.png?ver=' . time()) ?>"></a></h2>
					<div class="search-mob-block">
						<div class="">
							<a href="#search">
								<input type="search" id="tags1" class="tags" name="skills" value="" placeholder="Job Title,Skill,Company" />
							 </a>
						</div>
						<div id="search">
							<form method="get">
								<div class="new-search-input">
								   <input type="search" id="tags1" class="tags" name="skills" value="" placeholder="Job Title,Skill,Company" />
								   <input type="search" id="searchplace1" class="searchplace" name="searchplace" value="" placeholder="Find Location" />
								   
								</div>
								<div class="new-search-btn">
									<button type="button" class="close-new btn">Cancel</button>
									<button type="submit"  id="search_btn" class="btn btn-primary" onclick="return check();">Search</button>
								</div>
							</form>
						</div>
					</div>
					<div class="right-header">
						<ul>
							<li class="dropdown user-id">
								<label class="dropdown-toggle user-id-custom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <span class="usr-img">
                                        <?php
                                        if ($session_user['aileenuser_userimage'] != '')
                                        { ?>
                                            <img ng-src="<?php echo USER_THUMB_UPLOAD_URL . $session_user['aileenuser_userimage'] ?>" alt="<?php echo $session_user['aileenuser_firstname'] ?>">
                                        <?php
                                        }
                                        else
                                        { 
                                            if($userData['user_gender'] == "M")
                                            {?>
                                                <img ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                            <?php
                                            }
                                            if($userData['user_gender'] == "F")
                                            {
                                            ?>
                                                <img ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                            <?php
                                            }
                                        } ?>
                                    </span>
                                    <span class="pr-name">
                                        <?php
                                        /*if (isset($session_user['aileenuser_firstname'])) {
                                            echo ucfirst($session_user['aileenuser_firstname']);
                                        }*/ ?>                                            
                                    </span>                                    
                                </label>								
								<ul class="dropdown-menu profile-dropdown">
                                    <li>Account</li>
                                    <li><a  href="<?php echo base_url().$this->session->userdata('aileenuser_slug'); ?>" title="Setting"><i class="fa fa-user"></i> View Profile</a></li>
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
    <div class="mob-bottom-menu">
		<ul>
			<li>
				<a href="<?php echo base_url() ?>" title="Opportunity" target="_self""><img ng-src="<?php echo base_url('assets/n-images/op-bottom.png?ver=' . time()) ?>" ></a>
			</li>
			<li id="add-contact" class="dropdown">
				<a href="<?php echo base_url('contact-request') ?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img ng-src="<?php echo base_url('assets/n-images/add-contact-bottom.png?ver=' . time()) ?>">
					<span class="noti-box">1</span>
				</a>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img ng-src="<?php echo base_url('assets/n-images/message-bottom.png?ver=' . time()) ?>" >
					<span class="noti-box">1</span>
				</a>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img ng-src="<?php echo base_url('assets/n-images/noti-bottom.png?ver=' . time()) ?>" >
					<span class="noti-box">1</span>
				</a>
			</li>
			<li>
				<button id="showRight"><img ng-src="<?php echo base_url('assets/n-images/mob-menu.png?ver=' . time()) ?>"></button>
			</li>
		</ul>
	</div>
    <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right mob-side-menu" id="cbp-spmenu-s2">
		<div class="all-profile-box content custom-scroll">
			<ul class="all-pr-list">
				<li>
					<a href="#">
						<div class="all-pr-img">
							<img src="https://www.aileensoul.com/assets/img/i1.png?ver=1517557803" alt="Job Profile">
						</div>
						<span>Job Profile</span>
					</a>
				</li>
				<li>
					<a href="#">
						<div class="all-pr-img">
							<img src="https://www.aileensoul.com/assets/img/i2.jpg?ver=1517557803" alt="Recruiter Profile">
						</div>
						<span>Recruiter Profile</span>
					</a>
				</li>
				<li>
					<a href="#">
						<div class="all-pr-img">
							<img src="https://www.aileensoul.com/assets/img/i3.jpg?ver=1517557803" alt="Freelance Profile">
						</div>
						<span>Freelance Profile</span>
					</a>
				</li>
				<li>
					<a href="#">
						<div class="all-pr-img">
							<img src="https://www.aileensoul.com/assets/img/i4.jpg?ver=1517557803" alt="Business Profile">
						</div>
						<span>Business Profile</span>
					</a>
				</li>
				<li>
					<a href="#">
						<div class="all-pr-img">
							<img src="https://www.aileensoul.com/assets/img/i5.jpg?ver=1517557803" alt="Artistic Profile">
						</div>
						<span>Artistic Profile</span>
					</a>
				</li>
				<li>
					<a href="#">
						<div class="all-pr-img">
							<img src="https://www.aileensoul.com/assets/img/i5.jpg?ver=1517557803" alt="Artistic Profile">
						</div>
						<span>Artistic Profile</span>
					</a>
				</li>
				<li>
					<a href="#">
						<div class="all-pr-img">
							<img src="https://www.aileensoul.com/assets/img/i5.jpg?ver=1517557803" alt="Artistic Profile">
						</div>
						<span>Artistic Profile</span>
					</a>
				</li>
				<li>
					<a href="#">
						<div class="all-pr-img">
							<img src="https://www.aileensoul.com/assets/img/i5.jpg?ver=1517557803" alt="Artistic Profile">
						</div>
						<span>Artistic Profile</span>
					</a>
				</li>
				<li>
					<a href="#">
						<div class="all-pr-img">
							<img src="https://www.aileensoul.com/assets/img/i5.jpg?ver=1517557803" alt="Artistic Profile">
						</div>
						<span>Artistic Profile</span>
					</a>
				</li>
				<li>
					<a href="#">
						<div class="all-pr-img">
							<img src="https://www.aileensoul.com/assets/img/i5.jpg?ver=1517557803" alt="Artistic Profile">
						</div>
						<span>Artistic Profile</span>
					</a>
				</li>
				<li>
					<a href="#">
						<div class="all-pr-img">
							<img src="https://www.aileensoul.com/assets/img/i5.jpg?ver=1517557803" alt="Artistic Profile">
						</div>
						<span>Artistic Profile</span>
					</a>
				</li>
				<li>
					<a href="#">
						<div class="all-pr-img">
							<img src="https://www.aileensoul.com/assets/img/i5.jpg?ver=1517557803" alt="Artistic Profile">
						</div>
						<span>Artistic Profile</span>
					</a>
				</li>
			</ul>
		</div>
	</nav>
</div>
