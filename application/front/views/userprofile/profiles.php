<div class="container pt15">
    <div class="sticky-container right-profile">
        <ul class="sticky-right">
            <li>
                <a title="Artistic Profile" href="#art-scroll" class="right-menu-box art-r" onclick="return tabindexart();"> <span>Artistic Profile</span></a>
            </li>
            <li>
                <a title="Business Profile" href="#bus-scroll" class="right-menu-box bus-r" onclick="return tabindexbus();"> <span>Business Profile</span></a>
            </li>
            <li>
                <a title="Job Profile" href="#job-scroll" class="right-menu-box job-r" onclick="return tabindexjob();"><span>Job Profile</span></a>
            </li>
            <li>
                <a title="Recruiter Profile" href="#rec-scroll" class="right-menu-box rec-r" onclick="return tabindexrec();"> <span>Recruiter Profile</span></a>
            </li>
            <li>
                <a title="freelancer Profile" href="#free-scroll" class="right-menu-box free-r" onclick="return tabindexfree();"> <span>Freelance Profile</span></a>
            </li>
        </ul>
    </div>
    <section class="all-profile-custom">
        <div id="bus-scroll" class="custom-box odd">
            <div class="custom-width">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="left-box">
                            <a ng-if="details_data.bp_step == '4'" ng-href="<?php echo base_url('business-profile/home'); ?>" target="_self">
                                <img title="Business Profile" src="<?php echo base_url() . "assets/n-images/i4.jpg"; ?>">
                            </a>
                            <a target="_self" ng-if="details_data.bp_status == '0' && details_data.rp_step == '3'"  ng-href="<?php echo base_url('business-profile/home'); ?>">
                                <img title="Business Profile" src="<?php echo base_url() . "assets/n-images/i4.jpg"; ?>">
                            </a>
                            <a href="<?php echo base_url('business-profile'); ?>"  ng-if="details_data.bp_step == null" class="btn-4" ng-href="<?php echo base_url('business-profile'); ?>">
                                <img title="Business Profile" src="<?php echo base_url() . "assets/n-images/i4.jpg"; ?>">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <div class="right-box">
                            <h1>
                                <a title="Business Profile"  ng-if="details_data.bp_step == '4'" ng-href="<?php echo base_url('business-profile/home'); ?>" target="_self">Business Profile</a> 
                                <a title="Business Profile" ng-if="details_data.bp_status == '0' && details_data.rp_step == '3'"  ng-href="<?php echo base_url('business-profile/home'); ?>" target="_self">Business Profile</a> 
                                <a title="Business Profile" ng-if="details_data.bp_step == null" ng-href="<?php echo base_url('business-profile'); ?>" target="_self">Business Profile</a> 
                            </h1>
                            <p>Grow your business network.</p>
                            <div class="btns">
                                <a title="Take me in"  ng-if="details_data.bp_step == '4'" class="btn-4" ng-href="<?php echo base_url('business-profile/home'); ?>" target="_self">Take me in</a> 
                                <a title="Active" ng-if="details_data.bp_status == '0' && details_data.rp_step == '3'" class="btn-4" ng-href="<?php echo base_url('business-profile/home'); ?>" target="_self">Active</a> 
                                <a title="Register" ng-if="details_data.bp_step == null" class="btn-4" ng-href="<?php echo base_url('business-profile'); ?>" target="_self">Register</a> 
                                <a title="How it works" data-target="#bus-popup" data-toggle="modal" href="javascript:;" class="pl20 ml20 hew">How it works?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="job-scroll" class="custom-box odd">
            <div class="custom-width">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <div class="left-box">
                            <a ng-if="details_data.jp_step == '10'"  ng-href="<?php echo base_url('job/home'); ?>" target="_self">
                                <img title="Job Profile" src="<?php echo base_url() . "assets/n-images/i1.jpg"; ?>">
                            </a>
                            <a ng-if="details_data.jp_status == '0' && details_data.jp_step == '10'"  ng-href="<?php echo base_url('job/home'); ?>" target="_self">
                                <img title="Job Profile" src="<?php echo base_url() . "assets/n-images/i1.jpg"; ?>">
                            </a>
                            <a  ng-if="details_data.jp_step == null"  ng-href="<?php echo base_url('job'); ?>" target="_self">
                                <img title="Job Profile" src="<?php echo base_url() . "assets/n-images/i1.jpg"; ?>">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <div class="right-box">
                            <h1>
                                <a title="Job Profile"  ng-if="details_data.jp_step == '10'"  ng-href="<?php echo base_url('job/home'); ?>" target="_self">Job Profile</a> 
                                <a title="Job Profile" ng-if="details_data.jp_status == '0' && details_data.jp_step == '10'"  ng-href="<?php echo base_url('job/home'); ?>" target="_self">Job Profile</a> 
                                <a title="Job Profile" ng-if="details_data.jp_step == null"  ng-href="<?php echo base_url('job'); ?>" target="_self">Job Profile</a> 
                            </h1>
                            <p>Find best job options and connect with recruiters.</p>
                            <div class="btns">
                                <a title="Take me in"  ng-if="details_data.jp_step == '10'" class="btn-4" ng-href="<?php echo base_url('job/home'); ?>" target="_self">Take me in</a> 
                                <a title="Take me in" ng-if="details_data.jp_status == '0' && details_data.jp_step == '10'" class="btn-4" ng-href="<?php echo base_url('job/home'); ?>" target="_self">Active</a> 
                                <a title="Take me in" ng-if="details_data.jp_step == null" class="btn-4" ng-href="<?php echo base_url('job'); ?>" target="_self">Register</a> 
                                <a title="How it works" data-target="#jop-popup" data-toggle="modal" href="javascript:;" class="pl20 ml20 hew">How it works?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="rec-scroll" class="custom-box odd">
            <div class="custom-width">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="left-box">
                            <a ng-if="details_data.rp_step == '3'" ng-href="<?php echo base_url('recruiter/home'); ?>" target="_self">
                                <img title="Recruiter Profile" src="<?php echo base_url() . "assets/n-images/i2.jpg"; ?>">
                            </a>
                            <a ng-if="details_data.rp_status == '0' && details_data.rp_step == '3'" ng-href="<?php echo base_url('recruiter/home'); ?>" target="_self">
                                <img title="Recruiter Profile" src="<?php echo base_url() . "assets/n-images/i2.jpg"; ?>">
                            </a>
                            <a ng-if="details_data.rp_step == null" ng-href="<?php echo base_url('recruiter'); ?>" target="_self>
                                <img title="Recruiter Profile" src="<?php echo base_url() . "assets/n-images/i2.jpg"; ?>">
                            </a>

                             
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <div class="right-box">
                            <h1>
                                <a title="Recruiter Profile" ng-if="details_data.rp_step == '3'" ng-href="<?php echo base_url('recruiter/home'); ?>" target="_self">Recruiter Profile</a>
                                <a title="Recruiter Profile" ng-if="details_data.rp_status == '0' && details_data.rp_step == '3'" ng-href="<?php echo base_url('recruiter/home'); ?>" target="_self">Recruiter Profile</a>
                                <a title="Recruiter Profile" ng-if="details_data.rp_step == null" ng-href="<?php echo base_url('recruiter'); ?>" target="_self">Recruiter Profile</a>
                            
                            </h1>
                            <p>Hire quality employees here.</p>
                            <div class="btns">
                                <a title="Take me in"  ng-if="details_data.rp_step == '3'" class="btn-4" ng-href="<?php echo base_url('recruiter/home'); ?>" target="_self" >Take me in</a> 
                                <a title="Take me in" ng-if="details_data.rp_status == '0' && details_data.rp_step == '3'" class="btn-4" ng-href="<?php echo base_url('recruiter/home'); ?>" target="_self">Active</a> 
                                <a title="Take me in" ng-if="details_data.rp_step == null" class="btn-4" ng-href="<?php echo base_url('recruiter'); ?>" target="_self">Register</a> 
                                <a title="How it works" data-target="#rec-popup" data-toggle="modal" href="javascript:;" class="pl20 ml20 hew">How it works?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="art-scroll" class="custom-box odd">
            <div class="custom-width">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <div class="left-box">
                            <a ng-if="details_data.ap_step == '4'" ng-href="<?php echo base_url('artist/home'); ?>" target="_self">
                                <img title="Artistic Profile" src="<?php echo base_url() . "assets/n-images/i5.jpg"; ?>">
                            </a>
                            <a ng-if="details_data.ap_status == '0' && details_data.ap_step == '4'" ng-href="<?php echo base_url('artist/home'); ?>" target="_self">
                                <img title="Artistic Profile" src="<?php echo base_url() . "assets/n-images/i5.jpg"; ?>">
                            </a>
                            <a ng-if="details_data.ap_step == null && details_data.ap_step == null" ng-href="<?php echo base_url('artist'); ?>" target="_self">
                                <img title="Artistic Profile" src="<?php echo base_url() . "assets/n-images/i5.jpg"; ?>">
                            </a>
                         
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <div class="right-box">
                            <h1>
                                <a title="Artistic Profile" ng-if="details_data.ap_step == '4'" ng-href="<?php echo base_url('artist/home'); ?>" target="_self">Artistic Profile</a>
                                <a title="Artistic Profile" ng-if="details_data.ap_status == '0' && details_data.ap_step == '4'" ng-href="<?php echo base_url('artist/home'); ?>" target="_self">Artistic Profile</a>
                                <a title="Artistic Profile" ng-if="details_data.ap_step == null && details_data.ap_step == null" ng-href="<?php echo base_url('artist'); ?>" target="_self">Artistic Profile</a>
                            </h1>
                            <p>Show your art &amp; talent to the world.</p>
                            <div class="btns">
                                <a title="Take me in"  ng-if="details_data.ap_step == '4'" class="btn-4" ng-href="<?php echo base_url('artist/home'); ?>" target="_self">Take me in</a> 
                                <a title="Take me in" ng-if="details_data.ap_status == '0' && details_data.ap_step == '4'" class="btn-4" ng-href="<?php echo base_url('artist/home'); ?>" target="_self">Active</a> 
                                <a title="Take me in" ng-if="details_data.ap_step == null && details_data.ap_step == null" class="btn-4" ng-href="<?php echo base_url('artist'); ?>" target="_self">Register</a> 
                                <a title="How it Works" data-target="#art-popup" data-toggle="modal" href="javascript:;" class="pl20 ml20 hew">How it works?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="free-scroll" class="custom-box odd">
            <div class="custom-width">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <div class="left-box">
                            <a  ng-if="(details_data.fh_step == '3' && details_data.fh_status == '1') || (details_data.fh_step == '7' && details_data.fp_status == '1')"  ng-href="<?php echo base_url('freelancer/home'); ?>" target="_self">
                                <img title="Freelance Profile" src="<?php echo base_url() . "assets/n-images/i3.jpg"; ?>">
                            </a>
                            <a   ng-if="(details_data.fh_status == '0' && details_data.fh_step == '3') || (details_data.fp_status == '0' && details_data.fp_step == '7')" ng-href="<?php echo base_url('freelancer/home'); ?>" target="_self">
                                <img title="Freelance Profile" src="<?php echo base_url() . "assets/n-images/i3.jpg"; ?>">
                            </a>
                            <a  ng-if="details_data.fh_step == null || details_data.fp_step == null" ng-href="<?php echo base_url('freelancer'); ?>" target="_self">
                                <img title="Freelance Profile" src="<?php echo base_url() . "assets/n-images/i3.jpg"; ?>">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <div class="right-box">
                            <h1>
                                <a title="Freelance Profile" ng-if="(details_data.fh_step == '3' && details_data.fh_status == '1') || (details_data.fh_step == '7' && details_data.fp_status == '1')"  ng-href="<?php echo base_url('freelancer/home'); ?>" target="_self">Freelance Profile</a>
                                 <a title="Freelance Profile"  ng-if="(details_data.fh_status == '0' && details_data.fh_step == '3') || (details_data.fp_status == '0' && details_data.fp_step == '7')" ng-href="<?php echo base_url('freelancer/home'); ?>" target="_self">Freelance Profile</a>
                                  <a title="Freelance Profile" ng-if="details_data.fh_step == null || details_data.fp_step == null" ng-href="<?php echo base_url('freelancer'); ?>" target="_self">Freelance Profile</a>
                            </h1>
                            <p>Hire freelancers and also find freelance work.</p>
                            <div class="btns">
                                <a title="Take me in"  ng-if="(details_data.fh_step == '3' && details_data.fh_status == '1') || (details_data.fh_step == '7' && details_data.fp_status == '1')" class="btn-4"  ng-href="<?php echo base_url('freelancer/home'); ?>" target="_self">Take me in</a> 
                                <a title="Take me in" ng-if="(details_data.fh_status == '0' && details_data.fh_step == '3') || (details_data.fp_status == '0' && details_data.fp_step == '7')" class="btn-4" ng-href="<?php echo base_url('freelancer/home'); ?>" target="_self">Active</a> 
                                <a title="Take me in" ng-if="details_data.fh_step == null || details_data.fp_step == null" class="btn-4" ng-href="<?php echo base_url('freelancer'); ?>" target="_self">Register</a> 
                                <a title="How it works" data-target="#fre-popup" data-toggle="modal" href="javascript:;" class="pl20 ml20 hew">How it works?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!--  how it work popup start -->
<div style="display:none;" class="modal fade how-it-popup" id="jop-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <div class="modal-header">
                <h1 class="modal-title">How It Works ?</h1>
            </div>
            <div class="modal-body">
                <div class=""> 
                    <div class="col-md-6 col-sm-6 pro_img">
                        <h3>Job Profile</h3>
                        <img src="<?php echo base_url(); ?>assets/img/how-it.png" alt="How It Works">
                    </div>
                    <div class="col-md-6 col-sm-6 por_content">
                        <ul>
                            <li><img src="<?php echo base_url(); ?>assets/img/p1.png" alt="Register"><span class="pro-text"><span class="count">1.</span><span class="text">Register</span></span></li>
                            <li><img src="<?php echo base_url(); ?>assets/img/p2.png" alt="Get job recommendation as per your skills"><span class="pro-text"><span class="count">2.</span><span class="text">Get job recommendation as per your skills</span></span></li>
                            <li><img src="<?php echo base_url(); ?>assets/img/p3.png" alt="Shortlist - Save - Apply for the job"><span class="pro-text"><span class="count">3.</span><span class="text">Shortlist - Save - Apply for the job</span></span></li>
                            <li><img src="<?php echo base_url(); ?>assets/img/p4.png" alt="Connect with the recruiter and view recruiter's profile."><span class="pro-text"><span class="count">4.</span><span class="text">Connect with the recruiter and view recruiter's profile.</span></span></li>
                        </ul>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a title="Take me in"  ng-if="details_data.jp_step == '10'" class="btn-4" ng-href="<?php echo base_url('job'); ?>" target="_self">Take me in</a> 
                <a title="Take me in" ng-if="details_data.jp_status == '0' && details_data.jp_step == '10'" class="btn-4" ng-href="<?php echo base_url('job'); ?>" target="_self">Active</a> 
                <a title="Take me in" ng-if="details_data.jp_step == null" class="btn-4" ng-href="<?php echo base_url('job'); ?>" target="_self">Register</a> 
            </div>
        </div>
    </div>

</div>
<div style="display:none;" class="modal fade how-it-popup" id="rec-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <div class="modal-header">
                <h1 class="modal-title">How It Works ?</h1>
            </div>
            <div class="modal-body">
                <div class=""> 
                    <div class="col-md-6 col-sm-6 pro_img">
                        <h3>Recruiter Profile</h3>
                        <img src="<?php echo base_url(); ?>assets/img/how-it.png" alt="How It Is work">
                    </div>
                    <div class="col-md-6 col-sm-6 por_content">
                        <ul>
                            <li><img src="<?php echo base_url(); ?>assets/img/p1.png" alt="Register"><span class="pro-text"><span class="count">1.</span><span class="text">Register</span></span></li>
                            <li><img src="<?php echo base_url(); ?>assets/img/p5.png" alt="Post job and see recommended candidates"><span class="pro-text"><span class="count">2.</span><span class="text">Post job and see recommended candidates</span></span></li>
                            <li><img src="<?php echo base_url(); ?>assets/img/p6.png" alt="Invite from applied candidates for an interview"><span class="pro-text"><span class="count">3.</span><span class="text">Invite from applied candidates for an interview</span></span></li>
                            <li><img src="<?php echo base_url(); ?>assets/img/p4.png" alt="Connect with job seekers and view their profiles"><span class="pro-text"><span class="count">4.</span><span class="text">Connect with job seekers and view their profiles.</span></span></li>
                        </ul>

                    </div>
                </div>
            </div>
            <div class="modal-footer">

                <a title="Take me in"  ng-if="details_data.rp_step == '3'" class="btn-4" ng-href="<?php echo base_url('recruiter'); ?>" target="_self" >Take me in</a> 
                <a title="Take me in" ng-if="details_data.rp_status == '0' && details_data.rp_step == '3'" class="btn-4" ng-href="<?php echo base_url('recruiter'); ?>" target="_self">Active</a> 
                <a title="Take me in" ng-if="details_data.rp_step == null" class="btn-4" ng-href="<?php echo base_url('recruiter'); ?>" target="_self">Register</a> 

            </div>
        </div>
    </div>
</div>

<div style="display:none;" class="modal fade how-it-popup" id="fre-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <div class="modal-header">

                <h1 class="modal-title">How It Works ?</h1>
            </div>
            <div class="modal-body">
                <div class=""> 
                    <div class="col-md-6 col-sm-6 pro_img">
                        <h3>Freelance Profile</h3>
                        <img src="<?php echo base_url(); ?>assets/img/how-it.png" alt="How It Is Work">
                    </div>
                    <div class="col-md-6 col-sm-6 por_content">
                        <div class="card">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a title="home" data-target="#home"  href="javascript:;" role="tab" class="pl20 ml20 hew" data-toggle="tab">Apply</a>
                                <li role="presentation"><a title="profile" data-target="#profile"  href="javascript:;" role="tab" class="pl20 ml20 hew" data-toggle="tab">Hire</a>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="home">
                                    <ul>
                                        <li><img src="<?php echo base_url(); ?>assets/img/p1.png" alt="Register"><span class="pro-text"><span class="count">1.</span><span class="text">Register</span></span></li>
                                        <li><img src="<?php echo base_url(); ?>assets/img/p7.png" alt="Get freelance work as per your skills"><span class="pro-text"><span class="count">2.</span><span class="text">Get freelance work as per your skills</span></span></li>
                                        <li><img src="<?php echo base_url(); ?>assets/img/p3.png" alt="Shortlist - save - apply for freelance work"><span class="pro-text"><span class="count">3.</span><span class="text">Shortlist - save - apply for freelance work </span></span></li>
                                        <li><img src="<?php echo base_url(); ?>assets/img/p8.png" alt="Chat with the employer"><span class="pro-text"><span class="count">4.</span><span class="text">Chat with the employer.</span></span></li>
                                    </ul>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="profile">
                                    <ul>
                                        <li><img src="<?php echo base_url(); ?>assets/img/p1.png" alt="Register"><span class="pro-text"><span class="count">1.</span><span class="text">Register</span></span></li>
                                        <li><img src="<?php echo base_url(); ?>assets/img/p10.png" alt="Post a project and see recommended freelancers"><span class="pro-text"><span class="count">2.</span><span class="text">Post a project and see recommended freelancers. </span></span></li>
                                        <li><img src="<?php echo base_url(); ?>assets/img/p3.png" alt="Select from applied freelancers for your project"><span class="pro-text"><span class="count">3.</span><span class="text">Select from applied freelancers for your project </span></span></li>
                                        <li><img src="<?php echo base_url(); ?>assets/img/p8.png" alt="Chat with freelancer"><span class="pro-text"><span class="count">4.</span><span class="text">Chat with freelancer.</span></span></li>
                                    </ul>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a title="Take me in"  ng-if="(details_data.fh_step == '3' && details_data.fh_status == '1') || (details_data.fh_step == '7' && details_data.fp_status == '1')" class="btn-4"  ng-href="<?php echo base_url('freelancer'); ?>" target="_self">Take me in</a> 
                <a title="Take me in" ng-if="(details_data.fh_status == '0' && details_data.fh_step == '3') || (details_data.fp_status == '0' && details_data.fp_step == '7')" class="btn-4" ng-href="<?php echo base_url('freelancer'); ?>" target="_self">Active</a> 
                <a title="Take me in" ng-if="details_data.fh_step == null && details_data.fp_step == null" class="btn-4" ng-href="<?php echo base_url('freelancer'); ?>" target="_self">Register</a> 
            </div>
        </div>
    </div>
</div>

<div style="display:none;" class="modal fade how-it-popup" id="bus-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <div class="modal-header">

                <h1 class="modal-title">How It Works ?</h1>
            </div>
            <div class="modal-body">
                <div class=""> 
                    <div class="col-md-6 col-sm-6 pro_img">
                        <h3>Business Profile</h3>
                        <img src="<?php echo base_url(); ?>assets/img/how-it.png" alt="How It Is Work">
                    </div>
                    <div class="col-md-6 col-sm-6 por_content">
                        <ul>
                            <li><img src="<?php echo base_url(); ?>assets/img/p1.png" alt="Register"><span class="pro-text"><span class="count">1.</span><span class="text">Register</span></span></li>
                            <li><img src="<?php echo base_url(); ?>assets/img/p4.png" alt="Build business network"><span class="pro-text"><span class="count">2.</span><span class="text">Build business network.</span></span>
                            </li>
                        </ul>
                        <div class="sub-text">
                            <p>Get all news feed about your business category and of business you follow</p>
                            <p>You can add to your contacts and grow your business network</p>
                            <p>You can upload your products photos and also like and comment on other photos</p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">

                <a title="Take me in"  ng-if="details_data.bp_step == '4'" class="btn-4" ng-href="<?php echo base_url('business-profile'); ?>" target="_self">Take me in</a> 
                <a title="Take me in" ng-if="details_data.bp_status == '0' && details_data.rp_step == '3'" class="btn-4" ng-href="<?php echo base_url('business-profile'); ?>" target="_self">Active</a> 
                <a title="Take me in" ng-if="details_data.bp_step == null" class="btn-4" ng-href="<?php echo base_url('business-profile'); ?>" target="_self">Register</a> 

            </div>
        </div>
    </div>
</div>

<div style="display:none;" class="modal fade how-it-popup" id="art-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <div class="modal-header">

                <h1 class="modal-title">How It Works ?</h1>
            </div>
            <div class="modal-body">
                <div class=""> 
                    <div class="col-md-6 col-sm-6 pro_img">
                        <h3>Artistic Profile</h3>
                        <img src="<?php echo base_url(); ?>assets/img/how-it.png" alt="How It Is Work">
                    </div>
                    <div class="col-md-6 col-sm-6 por_content">
                        <ul>
                            <li><img src="<?php echo base_url(); ?>assets/img/p1.png" alt="Register"><span class="pro-text"><span class="count">1.</span><span class="text">Register</span></span></li>
                            <li><img src="<?php echo base_url(); ?>assets/img/p9.png" alt="You can upload photos/videos/audios and pdf of your art/talent"><span class="pro-text"><span class="count">2.</span><span class="text">You can upload photos/videos/audios and pdf of your art/talent.</span></span>
                            </li>
                        </ul>
                        <div class="sub-text">
                            <p>Get all news feed about your artistic category and of the various arts you follow</p>

                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a title="Take me in"  ng-if="details_data.ap_step == '4'" class="btn-4" ng-href="<?php echo base_url('artist'); ?>" target="_self">Take me in</a> 
                <a title="Take me in" ng-if="details_data.ap_status == '0' && details_data.ap_step == '4'" class="btn-4" ng-href="<?php echo base_url('artist'); ?>" target="_self">Active</a> 
                <a title="Take me in" ng-if="details_data.ap_step == null && details_data.ap_step == null" class="btn-4" ng-href="<?php echo base_url('artist'); ?>" target="_self">Register</a> 

            </div>
        </div>
    </div>
</div>

<!--  how it work popup end -->

