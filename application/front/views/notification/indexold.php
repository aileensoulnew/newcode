<!-- start head -->
<?php echo $head; ?>
<!-- END HEAD -->
<!-- start header -->
<?php echo $header; ?>
<!-- END HEADER -->

<body class="page-container-bg-solid page-boxed">

    <?php echo $dash_header; ?>
    <!-- BEGIN HEADER MENU -->
    <?php echo $dash_header_menu; ?>

    <!-- END HEADER MENU -->
</div>
<!-- END HEADER -->
<style type="text/css">
    #noti_pc{ margin-bottom: 5px;
    border-radius: 50%;
    margin-left: 10px;
    display: inline-block;
    
    margin-top: 5px;   }
    .job-saved-box .notification-box ul li{display: flex!important;}
    #notification_inside{ margin-left: 0px; margin-top: 0px;   padding: 5px 10px 9px 10px;
    margin-left: 11px;
    display: inline-block;}
    #noti_pc img{border-radius: none;}
      #notification_inside h6{font-size: 17px;}
</style>
<div class="user-midd-section" id="paddingtop_fixed">
    <div class="container">
        <div class="row">
            <div class="col-md-1 col-sm-1">
            </div>
            <div class="col-md-10 col-sm-10">
                <div class="common-form">

                    <div class="job-saved-box" style="border: 1px solid #d9d9d9;">
                        <h3 style="    -webkit-box-shadow: inset 0px 1px 0px 0px #ffffff;
    box-shadow: inset 0px 1px 0px 0px #ffffff;
    border-bottom: 1px solid #d9d9d9;
    padding-left: 24px;
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0.05, #f9f9f9), color-stop(1, #e9e9e9));
    background: -moz-linear-gradient(top, #f9f9f9 5%, #e9e9e9 100%);
    background: -webkit-linear-gradient(top, #f9f9f9 5%, #e9e9e9 100%);
    background: -o-linear-gradient(top, #f9f9f9 5%, #e9e9e9 100%);
    background: -ms-linear-gradient(top, #f9f9f9 5%, #e9e9e9 100%);
    background: linear-gradient(to bottom, #f9f9f9 5%, #e9e9e9 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f9f9f9', endColorstr='#e9e9e9',GradientType=0);
    background-color: #f9f9f9;font-weight: 600;
    color: #000033;">Notification</h3>

                        <!-- BEGIN CONTAINER -->
                        <!--  <div class="page-container">
                        -->     <!-- BEGIN CONTENT -->
                        <!--  <div class="page-content-wrapper">
                        -->     <!-- BEGIN CONTENT BODY -->
                        <!-- BEGIN PAGE HEAD-->
                        <!-- <div class="page-head">
                        --> <!--        <div class="container">
                        -->           <!-- BEGIN PAGE TITLE -->
                        <!--                 <div class="page-title">
                        -->                  <!--   <h1>Notification List</h1>
                        -->
                        <!--         <div id="notificationsBody" class="notifications">
        <div class="notification-data">
          <ul> -->

                        <div class="notification-box">

                            <ul>
                                <?php
                                foreach ($job_not as $job) { 
                                    if ($job['not_from'] == 1) {
                                        ?> 
                                        <li> 
                                            <div class="notification-pic" id="noti_pc" >
                                                <img src="<?php echo base_url(USERIMAGE . $job['user_image']); ?>" >
                                            </div>
                                            <div class="notification-data-inside" id="notification_inside">
                                                <a href="<?php echo base_url('notification/recruiter_post/' . $job['post_id']); ?>"><h6><?php echo "HI.. !  <font color='#4e6db1'><b><i> Recruiter</i></font></b><b>" . "  " . $job['first_name'] . ' ' . $job['last_name'] . "</b> invited you for an interview"; ?></h6></a>
                                                <div ><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i>
                                                    <?php echo $this->common->time_elapsed_string($job['not_created_date'], $full = false); ?>
                                                </div>
                                            </div>

                                        </li>
                                        <?php
                                    }
                                }
                                ?>

                                <?php
                                foreach ($artfollow as $art) {
                                    if ($art['not_from'] == 3) {
                                        ?>
                                        <li> 
                                            <div class="notification-pic" id="noti_pc">
                                                <img src="<?php echo base_url(USERIMAGE . $art['user_image']); ?>" >
                                            </div>
                                            <div class="notification-data-inside" id="notification_inside">
                                                <a href="<?php echo base_url('artist/artistic_profile/' . $art['user_id']); ?>"><h6><?php echo "HI.. !  <font color='#4e6db1'><b><i> Artistic</i></font></b><b>" . "  " . $art['first_name'] . ' ' . $art['last_name'] . "</b> started to following you"; ?></h6></a>
                                                <div ><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i>
                                                    <?php echo $this->common->time_elapsed_string($art['not_created_date'], $full = false); ?>
                                                </div>
                                            </div>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>

                                <?php
                                foreach ($artcommnet as $art) {
                                    if ($art['not_from'] == 3) {
                                        if ($art['not_img'] == 1) {
                                            ?>
                                            <li> 
                                                <div class="notification-pic" id="noti_pc">
                                                    <img src="<?php echo base_url(USERIMAGE . $art['user_image']); ?>" >
                                                </div>
                                                <div class="notification-data-inside" id="notification_inside">
                                                    <a href="<?php echo base_url('notification/art_post/' . $art['art_post_id']); ?>"><h6><?php echo "HI.. !  <font color='#4e6db1'><b><i> Artistic</i></font></b><b>" . "  " . $art['first_name'] . ' ' . $art['last_name'] . "</b> commneted on your post"; ?></h6></a>
                                                    <div ><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i>
                                                        <?php echo $this->common->time_elapsed_string($art['not_created_date'], $full = false); ?>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php } 
                                            
                                       
                                    }
                                }
                                ?>

                                <?php
                                foreach ($artlike as $art) { //echo '<pre>'; print_r($artlike); 
                                    if ($art['not_from'] == 3) {
                                        if ($art['not_img'] == 2) {
                                            ?>
                                            <li> 
                                                <div class="notification-pic" id="noti_pc" >
                                                    <img src="<?php echo base_url(USERIMAGE . $art['user_image']); ?>" >
                                                </div>
                                                <div class="notification-data-inside" id="notification_inside">
                                                    <a href="<?php echo base_url('notification/art_post/' . $art['art_post_id']); ?>"><h6><?php echo "HI.. !  <font color='#4e6db1'><b><i> Artistic</i></font></b><b>" . "  " . $art['first_name'] . ' ' . $art['last_name'] . "</b> liked on your post"; ?></h6></a>
                                                    <div ><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i>
                                                        <?php  echo $this->common->time_elapsed_string($art['not_created_date'], $full = false); ?>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php // } elseif ($art['not_img'] == 5) { ?>
<!--                                            <li> 
                                                <div class="notification-pic" >
                                                    <img src="<?php echo base_url(USERIMAGE . $art['user_image']); ?>" >
                                                </div>
                                                <div class="notification-data-inside">
                                                    <a href="<?php echo base_url('notification/art_post_img/' . $art['art_post_id']); ?>"><h6><?php echo "HI.. !  <font color='#4e6db1'><b><i> Artistic</i></font></b><b>" . "  " . $art['first_name'] . ' ' . $art['last_name'] . "</b> liked on your image"; ?></h6></a>
                                                    <div ><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i>
                                                        <?php echo $this->common->time_elapsed_string($art['not_created_date'], $full = false); ?>
                                                    </div>
                                                </div>
                                            </li>-->
                                        <?php //} 
                                        }  
                                       }
                                }
                                ?> 
                                            
                                            <?php
                                foreach ($artcmtlike as $art) {
                                    if ($art['not_from'] == 3) {
                                        if ($art['not_img'] == 3) {
                                            ?>
                                            <li> 
                                                <div class="notification-pic" id="noti_pc" >
                                                    <img src="<?php echo base_url(USERIMAGE . $art['user_image']); ?>" >
                                                </div>
                                                <div class="notification-data-inside" id="notification_inside">
                                                    <a href="<?php echo base_url('notification/art_post/' . $art['art_post_id']); ?>"><h6><?php echo "HI.. !  <font color='#4e6db1'><b><i> Artistic</i></font></b><b>" . "  " . $art['first_name'] . ' ' . $art['last_name'] . "</b> liked on your comment"; ?></h6></a>
                                                    <div ><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i>
                                                        <?php echo $this->common->time_elapsed_string($art['not_created_date'], $full = false); ?>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php }
                                    }
                                } ?>
                                            
                                            <?php
                                foreach ($artimglike as $bus) {
                                    if ($bus['not_from'] == 3) {
                                      if ($bus['not_img'] == 5) {   ?>
                                            <li> 
                                                <div class="notification-pic"  id="noti_pc">
                                                    <img src="<?php echo base_url(USERIMAGE . $bus['user_image']); ?>" >
                                                </div>
                                                <div class="notification-data-inside" id="notification_inside">
                                                    <a href="<?php echo base_url('notification/art_post_img/' . $bus['post_id'] . '/' . $bus['image_id']); ?>"><h6><?php echo "HI.. !  <font color='#4e6db1'><b><i> Artistic</i></font></b><b>" . "  " . $bus['first_name'] . ' ' . $bus['last_name'] . "</b> liked on your image"; ?></h6></a>
                                                    <div ><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i>
                                                        <?php echo $this->common->time_elapsed_string($bus['not_created_date'], $full = false); ?>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php
                                      }
                                    }
                                }
                                ?>
                                            
                                            <?php
                                foreach ($artimgcommnet as $bus) {
                                    if ($bus['not_from'] == 3) {
                                        if ($bus['not_img'] == 4) {
         $postid = $this->db->get_where('post_image', array('image_id' => $bus['post_image_id']))->row()->post_id; ?>
                                            <li>
                                            <div class="notification-pic" id="noti_pc" >
                                                <img src="<?php echo base_url(USERIMAGE . $bus['user_image']); ?>" >
                                            </div>
                                            <div class="notification-data-inside" id="notification_inside">
                                                <a href="<?php echo base_url('notification/art_post_img/' . $postid . '/' . $bus['post_image_id']); ?>"><h6><?php echo "HI.. !  <font color='#4e6db1'><b><i> Artistic</i></font></b><b>" . "  " . $bus['first_name'] . ' ' . $bus['last_name'] . "</b> commneted on your image"; ?></h6></a>
                                                <div ><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i>
                                                    <?php echo $this->common->time_elapsed_string($bus['not_created_date'], $full = false); ?>
                                                </div>
                                            </div>
                                        </li>
                                        <?php }  ?>
                                            
                                        <?php  
                                    }
                                }
                                ?>
                                        
                                        
                                        <?php
                                foreach ($artimgcmtlike as $bus) { 
                                    if ($bus['not_from'] == 3) {
                                        if ($bus['not_img'] == 6) {
       $postid = $this->db->get_where('post_image', array('image_id' => $bus['post_image_id']))->row()->post_id; ?>
                                            <li>
                                            <div class="notification-pic" id="noti_pc">
                                                <img src="<?php echo base_url(USERIMAGE . $bus['user_image']); ?>" >
                                            </div>
                                            <div class="notification-data-inside" id="notification_inside">
                                                <a href="<?php echo base_url('notification/art_post_img/' . $postid . '/' . $bus['post_image_id']); ?>"><h6><?php echo "HI.. !  <font color='#4e6db1'><b><i> Artistic</i></font></b><b>" . "  " . $bus['first_name'] . ' ' . $bus['last_name'] . "</b> liked on your comment"; ?></h6></a>
                                                <div ><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i>
                                                    <?php echo $this->common->time_elapsed_string($bus['not_created_date'], $full = false); ?>
                                                </div>
                                            </div>
                                        </li>
                                        <?php }  ?>
                                            
                                        <?php  
                                    }
                                }
                                ?>
                                
                 

                                <?php
                                foreach ($buscommnet as $bus) {
                                    echo $bus_from1 = $bus['not_from'];
                                    echo $bus_img1 = $bus['not_img'];

                                    if ($bus_from1 == '6' && $bus_img1 == '1') {
                                        ?>

                                        <li>
                                            <div class="notification-pic" id="noti_pc" >
                                                <img src="<?php echo base_url(USERIMAGE . $bus['user_image']); ?>" >
                                            </div>
                                            <div class="notification-data-inside" id="notification_inside">
                                                <a href="<?php echo base_url('notification/business_post/' . $bus['business_profile_post_id']); ?>"><h6><?php echo "HI.. !  <font color='#4e6db1'><b><i> Business</i></font></b><b>" . "  " . $bus['first_name'] . ' ' . $bus['last_name'] . "</b> commneted on your post"; ?></h6></a>
                                                <div><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i>
                                                    <?php echo $this->common->time_elapsed_string($bus['not_created_date'], $full = false); ?>
                                                </div>
                                            </div>
                                        </li>
                                        <?php
                                    } 
                                        ?>
                                        
                                        <?php
                                   
                                }
                                ?>
                                        
                                        <?php
                                foreach ($busimgcommnet as $bus) {
                                    if ($bus['not_from'] == 6) {
                                        if ($bus['not_img'] == 4) {
         $postid = $this->db->get_where('post_image', array('image_id' => $bus['post_image_id']))->row()->post_id; ?>
                                            <li>
                                            <div class="notification-pic" id="noti_pc" >
                                                <img src="<?php echo base_url(USERIMAGE . $bus['user_image']); ?>" >
                                            </div>
                                            <div class="notification-data-inside" id="notification_inside">
                                                <a href="<?php echo base_url('notification/bus_post_img/' . $postid . '/' . $bus['post_image_id']); ?>"><h6><?php echo "HI.. !  <font color='#4e6db1'><b><i> Business</i></font></b><b>" . "  " . $bus['first_name'] . ' ' . $bus['last_name'] . "</b> commneted on your image"; ?></h6></a>
                                                <div ><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i>
                                                    <?php echo $this->common->time_elapsed_string($bus['not_created_date'], $full = false); ?>
                                                </div>
                                            </div>
                                        </li>
                                        <?php }  ?>
                                            
                                        <?php  
                                    }
                                }
                                ?>
                                        
                                        <?php
                                foreach ($busimgcmtlike as $bus) {
                                    if ($bus['not_from'] == 6) {
                                        if ($bus['not_img'] == 6) {
         $postid = $this->db->get_where('post_image', array('image_id' => $bus['post_image_id']))->row()->post_id; ?>
                                            <li>
                                            <div class="notification-pic" id="noti_pc" >
                                                <img src="<?php echo base_url(USERIMAGE . $bus['user_image']); ?>" >
                                            </div>
                                            <div class="notification-data-inside" id="notification_inside">
                                                <a href="<?php echo base_url('notification/bus_post_img/' . $postid . '/' . $bus['post_image_id']); ?>"><h6><?php echo "HI.. !  <font color='#4e6db1'><b><i> Business</i></font></b><b>" . "  " . $bus['first_name'] . ' ' . $bus['last_name'] . "</b> liked on your comment"; ?></h6></a>
                                                <div ><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i>
                                                    <?php echo $this->common->time_elapsed_string($bus['not_created_date'], $full = false); ?>
                                                </div>
                                            </div>
                                        </li>
                                        <?php }  ?>
                                            
                                        <?php  
                                    }
                                }
                                ?>

                 
                                <?php
                                foreach ($busifollow as $bus) {
                                    if ($bus['not_from'] == 6) {
                                        $id = $this->db->get_where('business_profile', array('user_id' => $bus['not_from_id']))->row()->business_slug;
                                        if ($id) {
                                            ?>
                                            <li> 
                                                <div class="notification-pic" id="noti_pc" >
                                                    <img src="<?php echo base_url(USERIMAGE . $bus['user_image']); ?>" >
                                                </div>
                                                <div class="notification-data-inside" id="notification_inside">
                                                    <a href="<?php echo base_url('business_profile/business_resume/' . $id); ?>"><h6><?php echo "HI.. !  <font color='#4e6db1'><b><i> Businessman</i></font></b><b>" . "  " . $bus['first_name'] . ' ' . $bus['last_name'] . "</b> started to following you"; ?></h6></a>
                                                    <div ><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i>
                                                        <?php echo $this->common->time_elapsed_string($bus['not_created_date'], $full = false); ?>
                                                    </div>
                                                </div> 
                                            </li>
                                            <?php
                                        }
                                    }
                                }
                                ?>

                                <?php
                                foreach ($buslike as $bus) {
                                    if ($bus['not_from'] == 6) {
                                        if ($bus['not_img'] == 2) {
                                            ?>
                                            <li>
                                                <div class="notification-pic" id="noti_pc" >
                                                    <img src="<?php echo base_url(USERIMAGE . $bus['user_image']); ?>" >
                                                </div>
                                                <div class="notification-data-inside" id="notification_inside">
                                                    <a href="<?php echo base_url('notification/business_post/' . $bus['business_profile_post_id']); ?>"><h6><?php echo "HI.. !  <font color='#4e6db1'><b><i> Businessman</i></font></b><b>" . "  " . $bus['first_name'] . ' ' . $bus['last_name'] . "</b> liked on your post"; ?></h6></a>
                                                    <div ><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i>
                                                        <?php echo $this->common->time_elapsed_string($bus['not_created_date'], $full = false); ?>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php }  ?>
                                            
                                        <?php  
                                    }
                                }
                                ?>
                                 <?php
                                foreach ($buscmtlike as $bus) {
                                    if ($bus['not_from'] == 6) {
                                      if ($bus['not_img'] == 3) {   ?>
                                            <li> 
                                                <div class="notification-pic" id="noti_pc" >
                                                    <img src="<?php echo base_url(USERIMAGE . $bus['user_image']); ?>" >
                                                </div>
                                                <div class="notification-data-inside" id="notification_inside">
                                                    <a href="<?php echo base_url('notification/business_post/' . $bus['business_profile_post_id']); ?>"><h6><?php echo "HI.. !  <font color='#4e6db1'><b><i> Businessman</i></font></b><b>" . "  " . $bus['first_name'] . ' ' . $bus['last_name'] . "</b> liked on your comment"; ?></h6></a>
                                                    <div ><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i>
                                                        <?php echo $this->common->time_elapsed_string($bus['not_created_date'], $full = false); ?>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php
                                      }
                                    }
                                }
                                ?>
                                            
                                            <?php
                                foreach ($busimglike as $bus) {
                                    if ($bus['not_from'] == 6) {
                                      if ($bus['not_img'] == 5) {   ?>
                                            <li> 
                                                <div class="notification-pic" id="noti_pc" >
                                                    <img src="<?php echo base_url(USERIMAGE . $bus['user_image']); ?>" >
                                                </div>
                                                <div class="notification-data-inside" id="notification_inside">
                                                    <a href="<?php echo base_url('notification/bus_post_img/' . $bus['post_id'] . '/' . $bus['image_id']); ?>"><h6><?php echo "HI.. !  <font color='#4e6db1'><b><i> Businessman</i></font></b><b>" . "  " . $bus['first_name'] . ' ' . $bus['last_name'] . "</b> liked on your image"; ?></h6></a>
                                                    <div ><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i>
                                                        <?php echo $this->common->time_elapsed_string($bus['not_created_date'], $full = false); ?>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php
                                      }
                                    }
                                }
                                ?>
                                <?php
                                foreach ($rec_not as $art) {
                                    if ($art['not_from'] == 2) {

                                        $id = $this->db->get_where('job_reg', array('user_id' => $art['not_to_id']))->row()->job_id;
                                        if ($id) {
                                            ?>
                                            <li> 
                                                <div class="notification-pic" id="noti_pc" >
                                                    <img src="<?php echo base_url(USERIMAGE . $art['user_image']); ?>" >
                                                </div>
                                                <div class="notification-data-inside" id="notification_inside">
                                                    <a href="<?php echo base_url('job/job_printpreview/' . $art['not_from_id']); ?>"><h6><?php echo "HI.. !  <font color='#4e6db1'><b><i> Job seeker</i></font></b><b>" . "  " . $art['first_name'] . ' ' . $art['last_name'] . "</b> Aplied on your post"; ?></h6></a>
                                                    <div ><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i>
                                                        <?php echo $this->common->time_elapsed_string($art['not_created_date'], $full = false); ?>
                                                    </div>
                                                </div>

                                            </li>
                                            <?php
                                        }
                                    }
                                }
                                ?>

                                <?php
                                foreach ($hire_not as $art) {
                                    if ($art['not_from'] == 6) {

                                        $id = $this->db->get_where('freelancer_post_reg', array('user_id' => $art['user_id']))->row()->freelancer_post_reg_id;
                                        if ($id) {
                                            ?>
                                            <li> 
                                                <div class="notification-pic" id="noti_pc" >
                                                    <img src="<?php echo base_url(USERIMAGE . $art['user_image']); ?>" >
                                                </div>
                                                <div class="notification-data-inside" id="notification_inside">
                                                    <a href="<?php echo base_url('freelancer/freelancer_post_profile/' . $art['not_from_id']); ?>"><h6><?php echo "HI.. !  <font color='yellow'><b><i>Freelancer work</i></font></b><b>" . "  " . $art['first_name'] . ' ' . $art['last_name'] . "</b> Aplied on your post"; ?></h6></a>
                                                    <div ><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i>
                                                        <?php echo $this->common->time_elapsed_string($art['not_created_date'], $full = false); ?>
                                                    </div>
                                                </div>

                                            </li>
                                            <?php
                                        }
                                    }
                                }
                                ?>

                                <?php
                                foreach ($work_not as $art) {
                                    if ($art['not_from'] == 5) {
                                        $id = $this->db->get_where('job_reg', array('user_id' => $art['user_id']))->row()->job_id;
                                        if ($id) {
                                            ?>
                                            <li> 
                                                <div class="notification-pic" id="noti_pc" >
                                                    <img src="<?php echo base_url(USERIMAGE . $art['user_image']); ?>" >
                                                </div>
                                                <div class="notification-data-inside" id="notification_inside">
                                                    <a href="<?php echo base_url('job/job_printpreview/' . $id); ?>"><h6><?php echo "HI.. !  <font color='black'><b><i>Freelance Hire</i></font></b><b>" . "  " . $art['first_name'] . ' ' . $art['last_name'] . "</b> Aplied on your post"; ?></h6></a>
                                                    <div><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i>
                                                        <?php echo $this->common->time_elapsed_string($art['not_created_date'], $full = false); ?>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php
                                        }
                                    }
                                }
                                ?>

                                <?php
                                foreach ($work_post as $work) {
                                    if ($work['not_from'] == 4) {
                                        ?> 
                                        <li> 
                                            <div class="notification-pic" id="noti_pc" >
                                                <img src="<?php echo base_url(USERIMAGE . $work['user_image']); ?>" >
                                            </div>
                                            <div class="notification-data-inside" id="notification_inside">
                                                <a href="<?php echo base_url('notification/freelancer_hire_post/' . $work['post_id']); ?>"><h6><?php echo "HI.. !  <font color='#4e6db1'><b><i> Freelancer hire</i></font></b><b>" . "  " . $work['first_name'] . ' ' . $work['last_name'] . "</b> invited you for an interview"; ?></h6></a>
                                                <div ><i class="fa fa-comment" aria-hidden="true" style="margin-right:8px;"></i>
                                                    <?php echo $this->common->time_elapsed_string($work['not_created_date'], $full = false); ?>
                                                </div>
                                            </div>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>  

                    </div>
                </div>  

            </div>           </div>
        <!-- END PAGE TITLE -->
    </div>
</div>
<!-- END PAGE HEAD-->
<!-- BEGIN PAGE CONTENT BODY -->
<div class="page-content">
    <div class="container">
        <!-- BEGIN PAGE BREADCRUMBS -->
        <!-- <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="index.html">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Layouts</span>
            </li>
        </ul> -->
        <!-- END PAGE BREADCRUMBS -->
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content">
            <div class="container">
                <!-- BEGIN PAGE CONTENT INNER -->
                <div class="page-content-inner">
                    <div class="row">
                        <div class="col-md-12">

                        </div>
                    </div>
                </div>
                <!-- END PAGE CONTENT INNER -->
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT BODY -->
<!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<!-- BEGIN INNER FOOTER -->
<?php echo $footer; ?>
    