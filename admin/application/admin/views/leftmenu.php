<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo base_url('admin/images/logo.png') ?>" class="" alt="Dollarbid">
            </div>
        </div>

        <ul class="sidebar-menu">
            <!--<li class="header">MAIN NAVIGATION</li>-->

            <!-- Start Dashboard -->
            <li <?php if ($this->uri->segment(1) == 'dashboard' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?> >
                <a href="<?php echo base_url('dashboard'); ?>">
                    <i class="fa fa-dashboard margin-r-5"></i> <span>Dashboard</span> 
                </a>
            </li>
            <!-- End Dashboard -->
          <!--Start user Management-->
            <li <?php if ($this->uri->segment(1) == 'user_manage' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-briefcase margin-r-5"></i> <span>User Management</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('user_manage/user'); ?>"><i class="fa fa-users"></i>List ALL User</a></li>
                </ul>
            </li>
            <!--End user Management-->
             <!--Start user Management-->
            <li <?php if ($this->uri->segment(1) == 'pages' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-briefcase margin-r-5"></i> <span>Page Management</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Pages/page'); ?>"><i class="fa fa-users"></i>List ALL Pages</a></li>
                </ul>
            </li>
            <!--End user Management-->


             <!--Start Job Management-->
            <li <?php if ($this->uri->segment(1) == 'job' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-briefcase margin-r-5"></i> <span>Job Management</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('job/user'); ?>"><i class="fa fa-users"></i>List Job User</a></li>
                </ul>
            </li>
            <!--End Job Management-->

             <!--Start Recruiter Management-->
            <li <?php if ($this->uri->segment(1) == 'recruiter' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-handshake-o margin-r-5"></i> <span>Recruiter Management</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">     

                    <li><a href="<?php echo base_url('recruiter/user'); ?>"><i class="fa fa-users"></i>List Recruiter User</a></li>

                    <li><a href="<?php echo base_url('recruiter/post'); ?>"><i class="fa fa-vcard"></i>Post Recruiter User</a></li>
                </ul>
            </li>
            <!--End Recruiter Management-->
            
             <!--Start Freelancer hire Management-->
            <li <?php if ($this->uri->segment(1) == 'freelancer_hire' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-briefcase margin-r-5"></i> <span>Freelancer Hire</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('freelancer_hire/user'); ?>"><i class="fa fa-users"></i>List Freelancer Hire User</a></li>
                    <li><a href="<?php echo base_url('freelancer_hire/project'); ?>"><i class="fa fa-users"></i>List Projects</a></li>
                </ul>
            </li>
            <!--End Freelancer Hire Management-->
            
              <!--Start Freelancer hire Management-->
            <li <?php if ($this->uri->segment(1) == 'freelancer_apply' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-briefcase margin-r-5"></i> <span>Freelancer Apply</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('freelancer_apply/user'); ?>"><i class="fa fa-users"></i>List Freelancer Apply User</a></li>
<!--                    <li><a href="<?php //echo base_url('freelancer_hire/project'); ?>"><i class="fa fa-users"></i>List Projects</a></li>-->
                </ul>
            </li>
            <!--End Freelancer Hire Management-->

            <!--Start Business Management-->
            <li <?php if ($this->uri->segment(1) == 'business' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-briefcase margin-r-5"></i> <span>Business Management</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('business/user'); ?>"><i class="fa fa-users"></i>List Business User</a></li>
                </ul>
            </li>
            <!--End Business Management-->

            <!--Start Artistic Management-->
            <li <?php if ($this->uri->segment(1) == 'artistic' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-briefcase margin-r-5"></i> <span>Artistic Management</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('artist/user'); ?>"><i class="fa fa-users"></i>List Artistic User</a></li>
                </ul>
            </li>
            <!--End Artistic Management-->

              <!--Start CSV Management-->
            <li <?php if ($this->uri->segment(1) == 'csv_file' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-briefcase margin-r-5"></i> <span>CSV Upload</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('csv_file/index'); ?>"><i class="fa fa-users"></i>Upload CSV</a></li>
                </ul>
            </li>
            <!--End CSV Management-->
            
             <!--Start search keyword  Management-->
            <li <?php if ($this->uri->segment(1) == 'search_keyword' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-briefcase margin-r-5"></i> <span>Search Keyword Display</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('search_keyword/job'); ?>"><i class="fa fa-users"></i>Job Module keyword</a></li>
                    <li><a href="<?php echo base_url('search_keyword/rec'); ?>"><i class="fa fa-users"></i>Recruiter  keyword</a></li>
                    <li><a href="<?php echo base_url('search_keyword/freelancer_hire'); ?>"><i class="fa fa-users"></i>Freelancer Hire keyword</a></li>
                    <li><a href="<?php echo base_url('search_keyword/freelancer_apply'); ?>"><i class="fa fa-users"></i>Freelancer Apply keyword</a></li>
                    <li><a href="<?php echo base_url('search_keyword/business'); ?>"><i class="fa fa-users"></i>Business keyword</a></li>
                    <li><a href="<?php echo base_url('search_keyword/artistic'); ?>"><i class="fa fa-users"></i>Artistic keyword</a></li>
                </ul>
            </li>
            <!--End search keyword Management-->


            <!--Start Blog-->
            <li <?php if ($this->uri->segment(1) == 'blog' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-rss" aria-hidden="true"></i><span>Blog</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">     

                 <!--    <li><a href="<?php //echo base_url('blog_tag/blog_list'); ?>"><i class="fa fa-tag" aria-hidden="true"></i></i>Tag List</a></li>
 -->
                    <li><a href="<?php echo base_url('blog/blog_list'); ?>"><i class="fa fa-plus" aria-hidden="true"></i>Blog List</a></li>
                </ul>
            </li>
           <!--End Blog-->


           <!--Start Goverment job-->
            <li <?php if ($this->uri->segment(1) == 'goverment' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-rss" aria-hidden="true"></i><span>Goverment</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">     
                    <li><a href="<?php echo base_url('goverment/add_gov_category'); ?>"><i class="fa fa-plus" aria-hidden="true"></i>Add Goverment category</a></li>

                     <li><a href="<?php echo base_url('goverment/view_gov_category'); ?>"><i class="fa fa-plus" aria-hidden="true"></i>View Goverment category</a></li>


                     <li><a href="<?php echo base_url('goverment/add_gov_post'); ?>"><i class="fa fa-plus" aria-hidden="true"></i>Add Goverment post</a></li>

                     <li><a href="<?php echo base_url('goverment/view_gov_post'); ?>"><i class="fa fa-plus" aria-hidden="true"></i>View Goverment post</a></li>

                </ul>
            </li>
           <!--End Goverment job -->


            <!--Start Feedback-->
            <li <?php if ($this->uri->segment(1) == 'feedback' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-rss" aria-hidden="true"></i><span>Feedback</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">     

                 <!--    <li><a href="<?php //echo base_url('blog_tag/blog_list'); ?>"><i class="fa fa-tag" aria-hidden="true"></i></i>Tag List</a></li>
 -->
                    <li><a href="<?php echo base_url('feedback/user'); ?>"><i class="fa fa-plus" aria-hidden="true"></i>Feedback List</a></li>
                </ul>
            </li>
           <!--End Feedback-->
           
           <!--Start Advertise With us-->
            <li <?php if ($this->uri->segment(1) == 'advertise_with_us' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-rss" aria-hidden="true"></i><span>Advertise With Us</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">     
                   <li><a href="<?php echo base_url('advertise_with_us/'); ?>"><i class="fa fa-plus" aria-hidden="true"></i>Advertise With Us List</a></li>
                </ul>
            </li>
           <!--End Advertise With us-->


           <!--Start Contact us-->
            <li <?php if ($this->uri->segment(1) == 'contact_us' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-rss" aria-hidden="true"></i><span>Contact Us</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">     

                 <!--    <li><a href="<?php //echo base_url('blog_tag/blog_list'); ?>"><i class="fa fa-tag" aria-hidden="true"></i></i>Tag List</a></li>
 -->
                    <li><a href="<?php echo base_url('contact_us/user'); ?>"><i class="fa fa-plus" aria-hidden="true"></i>Contact Us List</a></li>
                </ul>
            </li>
           <!--End contact us-->


           <!--Start Blog-->
            <li <?php if ($this->uri->segment(1) == 'email' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?>>
                <a href="#">
                    <i class="fa fa-envelope" aria-hidden="true"></i><span>Mailbox</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">     

                 <!--    <li><a href="<?php //echo base_url('blog_tag/blog_list'); ?>"><i class="fa fa-tag" aria-hidden="true"></i></i>Tag List</a></li>
 -->
                    <li><a href="<?php echo base_url('email/compose/job'); ?>"><i class="fa fa-plus" aria-hidden="true"></i>Compose Mail</a></li>
                </ul>
            </li>
           <!--End Blog-->
           
           <!--Start Change Password-->
            <li <?php if ($this->uri->segment(1) == 'change_password' || $this->uri->segment(1) == '') { ?> class="active treeview" <?php } else { ?> class="treeview"   <?php } ?> >
               <a href="<?php echo base_url('dashboard/change_password'); ?>">
                   <i class="fa fa-lock"></i> <span>Change Password</span>
               </a>
           </li>
           <!--End Change Password-->
            

            <!--End of my code-->

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>