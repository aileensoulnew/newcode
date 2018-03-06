<div class="left-part">
    <div class="user-profile-box">
        <div class="user-cover-img">
            <a href="<?php echo base_url('profiles/'.$leftbox_data['user_slug']) ?>">
            <?php if ($leftbox_data['profile_background'] != '') { ?> 
                <img ng-src="<?php echo USER_BG_THUMB_UPLOAD_URL.$leftbox_data['profile_background'] ?>" alt="<?php echo $leftbox_data['first_name'] ?>" class="bgImage">
            <?php } else { ?>
                <img ng-src="<?php echo base_url(NOBUSIMAGE) ?>" alt="<?php echo $leftbox_data['first_name'] ?>">
            <?php } ?>
            </a>    
        </div>
        <div class="user-detail">
            <div class="user-img">
                <a href="<?php echo base_url('profiles/'.$leftbox_data['user_slug']) ?>">
                <?php if ($leftbox_data['user_image'] != '') { ?> 
                    <img ng-src="<?php echo USER_THUMB_UPLOAD_URL . $leftbox_data['user_image'] ?>" alt="<?php echo $leftbox_data['first_name'] ?>">  
                <?php } else { ?>
                    <img ng-src="<?php echo base_url(NOBUSIMAGE) ?>" alt="<?php echo $leftbox_data['first_name'] ?>">
                <?php } ?>
                </a>
            </div>
            <div class="user-detail-right">
                <div class="user-detail-top">
                    <h4><a href="<?php echo base_url('profiles/'.$leftbox_data['user_slug']) ?>" title="<?php echo ucfirst($leftbox_data['first_name']) . ' ' . ucfirst($leftbox_data['last_name']) ?>"><?php echo ucfirst($leftbox_data['first_name']) . ' ' . ucfirst($leftbox_data['last_name']) ?></a></h4>
                    <p><a href="<?php echo base_url('profiles/'.$leftbox_data['user_slug']) ?>">
                            <?php if($leftbox_data['title_name'] == ""){ echo $leftbox_data['degree_name'];
                            }else if($leftbox_data['title_name'] != ""){ echo $leftbox_data['title_name'];
                             } else{?>
                            Self Employee
                             <?php } ?>
                        </a></p>
                </div>
                <div class="user-detail-bottom">
                    <ul>
                        <li><a href="<?php echo base_url('profiles/'.$leftbox_data['user_slug']) ?>">Dashboard</a></li>
                        <li><a href="<?php echo base_url('details/'.$leftbox_data['user_slug']) ?>">Detail</a></li>
                        <li><a href="<?php echo base_url('followers/'.$leftbox_data['user_slug']) ?>">Followers</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="all-profile-box">
        <div class="all-pro-head">
            <h4>Profiles<a href="<?php echo base_url('profiles/') ?>" title="All Profile" class="pull-right">All</a></h4>
        </div>
        <ul class="all-pr-list">
            <li>
                <a href="<?php echo base_url('job/') ?>" title="Job Profile">
                    <div class="all-pr-img">
                        <img ng-src="<?php echo base_url('assets/n-images/i1.jpg?ver='.time()) ?>" alt="Job Profile">
                    </div>
                    <span>Job Profile</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('recruiter/') ?>" title="Recruiter Profile">
                    <div class="all-pr-img">
                        <img ng-src="<?php echo base_url('assets/n-images/i2.jpg?ver='.time()) ?>" alt="Recruiter Profile">
                    </div>
                    <span>Recruiter Profile</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('freelance/') ?>" title="Freelance Profile">
                    <div class="all-pr-img">
                        <img ng-src="<?php echo base_url('assets/n-images/i3.jpg?ver='.time()) ?>" alt="Freelance Profile">
                    </div>
                    <span>Freelance Profile</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('business-profile/') ?>" title="Business Profile">
                    <div class="all-pr-img">
                        <img ng-src="<?php echo base_url('assets/n-images/i4.jpg?ver='.time()) ?>" alt="Business Profile">
                    </div>
                    <span>Business Profile</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('artist/') ?>" title="Artistic Profile">
                    <div class="all-pr-img">
                        <img ng-src="<?php echo base_url('assets/n-images/i5.jpg?ver='.time()) ?>" alt="Artistic Profile">
                    </div>
                    <span>Artistic Profile</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="custom_footer_left fw">
        <div class="">
            <ul>
                <li>
                    <a href="#" target="_blank">
                        <span class="custom_footer_dot"> · </span> About Us 
                    </a>
                </li>
                <li>
                    <a href="#" target="_blank">
                        <span class="custom_footer_dot"> · </span> Contact Us
                    </a>
                </li>
                <li>
                    <a href="#" target="_blank">
                        <span class="custom_footer_dot"> · </span> Blogs 
                    </a>
                </li>
                <li>
                    <a href="#" target="_blank">
                        <span class="custom_footer_dot"> · </span> Privacy Policy 
                    </a>
                </li>
                <li>
                    <a href="#" target="_blank">
                        <span class="custom_footer_dot"> · </span> Terms &amp; Condition
                    </a>
                </li>
                <li>
                    <a href="#" target="_blank">
                        <span class="custom_footer_dot"> · </span> Send Us Feedback
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>