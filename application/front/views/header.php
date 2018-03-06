<header class="">
    <?php if (($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'home') || ($this->uri->segment(1) == 'job' && $this->uri->segment(2) == 'home') || ($this->uri->segment(1) == 'freelance-hire' && $this->uri->segment(2) == 'home') || ($this->uri->segment(1) == 'freelance-work' && $this->uri->segment(2) == 'home') || ($this->uri->segment(1) == 'business-profile' && $this->uri->segment(2) == 'home') || ($this->uri->segment(1) == 'artistic' && $this->uri->segment(2) == 'home')) { ?>
        <div class="header animated fadeInDownBig">
            <?php
        } else {
            ?>
            <div class="header">
                <?php
            }
            ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-5 col-xs-5 mob-zindex">
                        <div class="logo">
                            <a tabindex="-200" href="<?php echo base_url('profiles/') . $this->session->userdata('aileenuser_slug'); ?>">
                                <p><img src="<?php echo base_url('assets/img/logo-name.png?ver='.time()) ?>" alt="Aileensoul"></p>
                            </a>
                        </div>
                    </div>
                    <?php
                    $userid = $this->session->userdata('aileenuser');
                    if ($userid) {
                        ?>
                        <div class="col-md-8 col-sm-7 col-xs-7 header-left-menu">
                            <div class="main-menu-right">
                                <ul class="">
                                    <li id="a_li">
                                        <a id="alink" class="action-button shadow animate dropbtn_common"  <?php if (($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'add-post') || ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'edit_post') || ($this->uri->segment(1) == 'freelance-hire' && $this->uri->segment(2) == 'add-projects') || ($this->uri->segment(1) == 'freelance-hire' && $this->uri->segment(2) == 'edit-projects')) { ?>onclick="return leave_page(5)" <?php } ?>> <span class="all"></span></a>
                                        <div id="acon"  class="dropdown2_content">
                                            <div id="atittle">Profiles <a href="<?php echo base_url('profiles/') . $this->session->userdata('aileenuser_slug'); ?>" class="fr">All</a></div>
                                            <div id="abody" class="as">
                                                <!--AJAX DATA-->
                                            </div>
                                        </div>
                                    </li>
                                    <!-- general notification start -->
                                    <li id="notification_li">
                                        <a class="action-button shadow animate dropbtn_common <?php
                                        if ($user_notification_count != '0' && $user_notification_count != '') {
                                            echo 'notification_available';
                                        }
                                        ?>" href="javascript:void(0)" id="notificationLink" onclick = "return Notificationheader();"><em class="hidden-xs"></em> <i class="header-icon-notification "></i>
                                           <?php if ($user_notification_count != '0' && $user_notification_count != '') { ?>
                                            <span id="notification_count<?php echo $userid; ?>" style="background-color:#FF4500; padding:5px 6px; border-radius:50%;"><?php echo $user_notification_count; ?></span>
                                            <?php } else { ?>
                                                <span id="notification_count<?php echo $userid; ?>"></span>
                                            <?php } ?>
                                        </a>
                                        <div id="notificationContainer"  class="dropdown2_content">
                                            <div id="InboxBody" class="Inbox">
                                                <div id="notificationTitle">Notifications <span class="see_link" id="seenot"></span></div>
                                                <div class="content mCustomScrollbar light notifications" id="notification_main_in" data-mcs-theme="minimal-dark">
                                                    <div>
                                                        <ul class="notification_data_in">
                                                            <!--AJAX DATA..-->
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- general notification end -->
                                    <!-- BEGIN USER LOGIN DROPDOWN -->
                                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                                    <li class="dropdown dropdown-user">
                                        <a class="dropbtn action-button shadow animate dropbtn_common" href="javascript:void(0)" type="button" id="menu1" data-toggle="dropdown" >
                                            <!-- <div id="hi" class="notifications"> -->
                                            <?php if ($userdata['user_image'] != '') { ?>
                                                <div id="profile-photohead" class="profile-head">
                                                    <img alt="<?php echo $userdata['first_name'] ?>" class="img-circle" src="<?php echo USER_THUMB_UPLOAD_URL . $userdata['user_image'] . '?ver='.time(); ?>" height="50" width="50" alt="Smiley face" />
                                                </div>

                                                <?php
                                            } else {

                                                $a = $userdata['first_name'];
                                                $acr = substr($a, 0, 1);
                                                ?>
                                                <div id="profile-photohead" class="profile-head">
                                                    <div class="custom-user">
                                                        <?php echo ucfirst(strtolower($acr)); ?>
                                                    </div>

                                                </div>
                                            <?php } ?>
                                            <span class="u2 username username-hide-on-mobile hidden-xs"> <?php
                                                if (isset($userdata['first_name'])) {
                                                    echo $userdata['first_name'];
                                                }
                                                ?> </span>
                                            <i class="fa fa-caret-down" aria-hidden="true"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown2_content" role="menu" aria-labelledby="menu1" id="myDropdown">
                                            <li class="my_account">
                                                <div class="my_S">Account</div>
                                            </li>
                                            <li class="Setting">
                                                <a href="<?php echo base_url('profile') ?>">
                                                    <i class="fa fa-cog" aria-hidden="true"></i> Setting</a> 
                                            </li>
                                            <li class="logout">
                                                <?php if (($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'add-post') || ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'edit_post') || ($this->uri->segment(1) == 'freelance-hire' && $this->uri->segment(2) == 'add-projects') || ($this->uri->segment(1) == 'freelance-hire' && $this->uri->segment(2) == 'edit-projects')) { ?>
                                                    <a  onclick="return leave_page(8)">
                                                        <i class="fa fa-power-off" aria-hidden="true"></i> Logodfsdfut</a> 
                                                <?php } else { ?>
                                                    <a href="<?php echo base_url('dashboard/logout') ?>">
                                                        <i class="fa fa-power-off" aria-hidden="true"></i> Loxsxsgout</a> 
                                                    <?php } ?>
                                                <!--Logout-->
                                            </li>
                                        </ul>
                                        <!--  </div> -->
                                    </li>
                                    <!-- END USER LOGIN DROPDOWN -->
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
</header>
<!-- header end -->