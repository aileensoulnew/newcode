<?php
$userid = $this->session->userdata('aileenuser');
?>
<div class="web-header">
    <?php echo $header_inner_profile ?>
    <div class="sub-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mob-p0">
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url('artist/home'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Job Profile</a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-envelope" aria-hidden="true"></i> Message
                                <span class="noti-box">1</span>
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
                                                        <img src="<?php echo base_url('assets/img/user-pic.jpg?ver=' . time()) ?>" alt="No Business Image">
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
                                                        <img src="<?php echo base_url('assets/img/user-pic.jpg?ver=' . time()) ?>" alt="No Business Image">
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
                                                        <img src="<?php echo base_url('assets/img/user-pic.jpg?ver=' . time()) ?>" alt="No Business Image">
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
                                                        <img src="<?php echo base_url('assets/img/user-pic.jpg?ver=' . time()) ?>" alt="No Business Image">
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
                                                        <img src="<?php echo base_url('assets/img/user-pic.jpg?ver=' . time()) ?>" alt="No Business Image">
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
                                                        <img src="<?php echo base_url('assets/img/user-pic.jpg?ver=' . time()) ?>" alt="No Business Image">
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
                                                        <img src="<?php echo base_url('assets/img/user-pic.jpg?ver=' . time()) ?>" alt="No Business Image">
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
                        <li class="dropdown user-id">
                            <a href="#" class="dropdown-toggle user-id-custom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle-o" aria-hidden="true"></i><span class="pr-name">Account</span></a>

                            <ul class="dropdown-menu account">
                                <li>Account</li>
                                <li><a href="<?php echo base_url('job/resume/'.$slugdata[0]['slug']); ?>"><span class="icon-view-profile edit_data"></span>  View Profile </a></li>
                                <li><a href="<?php echo base_url('job/basic-information'); ?>"><span class="icon-edit-profile edit_data"></span>  Edit Profile </a></li>
                                 <li><a href="#"><span class="icon-delete edit_data"></span> Deactive Profile</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6 col-md-6 col-xs-6 hidden-mob">
                    <div class="job-search-box1 clearfix">
                        <form action="https://www.aileensoul.com/search/business_search" method="get">
                            <fieldset class="sec_h2">
                                <input id="tags" class="tags ui-autocomplete-input" name="skills" placeholder="Companies, Category, Products" autocomplete="off" type="text">
                            </fieldset>
                            <fieldset class="sec_h2">
                                <input id="searchplace" class="searchplace ui-autocomplete-input" name="searchplace" placeholder="Find Location" autocomplete="off" type="text">
                            </fieldset>
                            <fieldset class="new-search-btn">
                                <label for="search_btn" id="search_f"><i class="fa fa-search" aria-hidden="true"></i></label>
                                <input id="search_btn" style="display: none;" name="search_submit" value="Search" onclick="return checkvalue()" type="submit">
                            </fieldset>
                        </form>    
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="mobile-header">
    <header class="">
        <div class="animated fadeInDownBig">
            <div class="container">

                <div class="left-header">
                    <h2 class="logo"><a href="#"><img src="<?php echo base_url('assets/n-images/mob-logo.png?ver=' . time()) ?>"></a></h2>
                    <div class="search-mob-block">
                        
                            <a href="#search">
                                <input type="search" id="tags1" class="tags" name="skills" value="" placeholder="Job Title,Skill,Company" />
                            </a>
                        
                        <div id="search">
                            
                            <form method="get">
                                <div class="new-search-input">
                                    <input type="search" id="tags1" class="tags" name="skills" value="" placeholder="Job Title,Skill,Company" />
                                    <input type="search" id="searchplace1" class="searchplace" name="searchplace" value="" placeholder="Find Location" />
                                </div>
				<div class="new-search-btn">
                                    <button type="button" class="close-new btn">Cancel</button>
                                    <button type="submit" id="search_btn" class="btn btn-primary" onclick="return check();">Search</button>
				</div>
                            </form>
                        </div>
                    </div>
                    <div class="right-header">
                        <ul>
                            <li class="dropdown user-id">
                                <a href="#" class="dropdown-toggle user-id-custom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="usr-img"><img src="<?php echo base_url('assets/img/user-pic.jpg?ver=' . time()) ?>"></span><span class="pr-name"></span></a>

                                <ul class="dropdown-menu profile-dropdown">
                                    <li>Account</li>
                                    <li><a href="#"><i class="fa fa-cog"></i> Setting</a></li>
                                    <li><a href="#"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>


            </div>
        </div>

    </header>


    <div class="sub-header bus-only">
        <div class="container">
            <div class="row">

                <ul class="sub-menu">

                    <li>
                        <a href="#"><i class="fa fa-home" aria-hidden="true"></i> Artistic Profile</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-envelope" aria-hidden="true"></i><span class="none-sub-menu"> Message</span>
                            <span class="noti-box">1</span>
                        </a>

                    </li>

                    <li id="add-contact" class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-users" aria-hidden="true"></i> <span class="none-sub-menu">Contact</span>
                            <span class="noti-box">1</span>
                        </a>


                    </li>
                    <li class="dropdown user-id">
                        <a href="#" class="dropdown-toggle user-id-custom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle-o" aria-hidden="true"></i><span class="pr-name"><span class="none-sub-menu"> Account</span></span></a>

                        <ul class="dropdown-menu account">
                            <li>Account</li>
                            <li><a href="#"><i class="fa fa-cog"></i> Setting</a></li>
                            <li><a href="#"><i class="fa fa-power-off"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>


            </div>
        </div>

    </div>




    <div class="mob-bottom-menu">
        <ul>
            <li>
                <a href="opportunities.html"><img src="<?php echo base_url('assets/n-images/op-bottom.png?ver=' . time()) ?>"></a>
            </li>
            <li id="add-contact" class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url('assets/n-images/add-contact-bottom.png?ver=' . time()) ?>">
                    <span class="noti-box">1</span>
                </a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url('assets/n-images/message-bottom.png?ver=' . time()) ?>">
                    <span class="noti-box">1</span>
                </a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url('assets/n-images/noti-bottom.png?ver=' . time()) ?>">
                    <span class="noti-box">1</span>
                </a>
            </li>
            <li>
                <button id="showRight"><img src="<?php echo base_url('assets/n-images/mob-menu.png?ver=' . time()) ?>"></button>
            </li>


        </ul>
    </div>
</div>