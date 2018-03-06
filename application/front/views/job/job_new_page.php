<!DOCTYPE html>
<html>
    <head>
        <!-- start head -->
        <?php echo $head; ?>
        <!-- END HEAD -->

        <title><?php echo $title; ?></title>
<?php
        if (IS_JOB_CSS_MINIFY == '0') {
            ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver=' . time()); ?>">

        <?php }else{?>

           <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/job.css?ver=' . time()); ?>">

        <?php }?>
    </head>
    <!-- END HEAD -->
    <!-- Start HEADER -->
    <?php
    echo $header;
    echo $job_header2_border;
    ?>
    <!-- END HEADER -->
    <body class="page-container-bg-solid page-boxed">
        <div class="user-midd-section" id="paddingtop_fixed">
            <div class="container padding-360" >
                <div class="">
                    <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt">
                        <div class="">
                            <div class="full-box-module">
                                <div class="profile-boxProfileCard  module">
                                    <div class="profile-boxProfileCard-cover <?php
                                    if ($jobdata[0]['profile_background'] == '') {
                                        echo "bg-images no-cover-upload";
                                    }
                                    ?>">
                                        <a class="profile-boxProfileCard-bg u-bgUserColor a-block"
                                           href="<?php echo base_url('job/resume'); ?>"
                                           tabindex="-1"
                                           aria-hidden="true"
                                           rel="noopener">
                                               <?php
                                               if ($jobdata[0]['profile_background'] != '') {
                                                   ?>
                                                <!-- box image start -->
                                                <img src="<?php echo JOB_BG_MAIN_UPLOAD_URL . $jobdata[0]['profile_background']; ?>" class="bgImage" alt="<?php echo $jobdata[0]['profile_background']; ?>" >
                                                <!-- box image end -->
                                                <?php
                                            } else {
                                                ?>
                                                <img src="<?php echo base_url(WHITEIMAGE); ?>" class="bgImage" alt="noimage">
                                                <?php
                                            }
                                            ?>
                                        </a>
                                    </div>
                                    <div class="profile-boxProfileCard-content clearfix">
                                        <div class="left_side_box_img buisness-profile-txext">
                                            <a class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock"  href="<?php echo base_url('job/resume/' . $jobdata[0]['slug']); ?>" title="<?php echo $jobdata[0]['fname']; ?>" tabindex="-1" aria-hidden="true" rel="noopener">
                                                <?php
                                                if ($jobdata[0]['job_user_image']) {
                                                    ?>
                                                    <div class="left_iner_img_profile"><img src="<?php echo JOB_PROFILE_THUMB_UPLOAD_URL . $jobdata[0]['job_user_image']; ?>" alt="<?php echo $jobdata[0]['fname']; ?> " ></div>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <div class="data_img_2">
                                                        <?php
                                                        
                                                        $a = $jobdata[0]['fname'];
                                                        $acronym = substr($a, 0, 1);
                                                        $b = $jobdata[0]['lname'];
                                                        $acronym1 = substr($b, 0, 1);

                                                        ?>
                                                        <div class="post-img-profile">
                                                            <?php echo ucfirst(strtolower($acronym)) . ucfirst(strtolower($acronym1)); ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </a>
                                        </div>
                                        <div class="right_left_box_design ">
                                            <span class="profile-company-name ">
                                                <span class="profile-company-name ">
                                                    <a   href="<?php echo site_url('job/resume/' . $jobdata[0]['slug']); ?>">  <?php echo ucfirst($jobdata[0]['fname']) . ' ' . ucfirst($jobdata[0]['lname']); ?></a>
                                                </span>
                                            </span>
                                            <?php $category = $this->db->get_where('industry_type', array('industry_id' => $businessdata[0]['industriyal'], 'status' => '1'))->row()->industry_name; ?>
                                            <div class="profile-boxProfile-name">
                                                <a  href="<?php echo base_url('job/resume/' . $jobdata[0]['slug']); ?>"><?php
                                                    if (ucwords($jobdata[0]['designation'])) {
                                                        echo ucwords($jobdata[0]['designation']);
                                                    } else {
                                                        echo "Current Work";
                                                    }
                                                    ?></a>
                                            </div>
                                            <ul class=" left_box_menubar">
                                                <li <?php if ($this->uri->segment(1) == 'job' && $this->uri->segment(2) == 'resume') { ?> class="active" <?php } ?>>
                                                    <a class="padding_less_left" title="Details" href="<?php echo base_url('job/resume'); ?>"> Details</a>
                                                </li>
                                                <?php if (($this->uri->segment(1) == 'job') && ($this->uri->segment(2) == 'home' || $this->uri->segment(2) == 'resume' || $this->uri->segment(2) == 'job_resume' || $this->uri->segment(2) == 'saved-job' || $this->uri->segment(2) == 'applied-job') && ($this->uri->segment(3) == $this->session->userdata('aileenuser') || $this->uri->segment(3) == '' || $this->uri->segment(3) == 'live-post')) { ?>
                                                    <li <?php if ($this->uri->segment(1) == 'job' && $this->uri->segment(2) == 'saved-job') { ?> class="active" <?php } ?>><a title="Saved Job" href="<?php echo base_url('job/saved-job'); ?>">Saved </a>
                                                    </li>
                                                    <li <?php if ($this->uri->segment(1) == 'job' && $this->uri->segment(2) == 'applied-job') { ?> class="active" <?php } ?>><a class="padding_less_right" title="Applied Job" href="<?php echo base_url('job/applied-job'); ?>">Applied </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="edi_origde">
                                <?php
                                if ($count_profile == 100) {
                                    if ($job_reg[0]['progressbar'] == 0) {
                                        ?>
                                        <div class="edit_profile_progress complete_profile">
                                            <div class="progre_bar_text">
                                                <p>Please fill up your entire profile to get better job options and so that recruiter can find you easily.</p>
                                            </div>
                                            <div class="count_main_progress">
                                                <div class="circles">
                                                    <div class="second circle-1 ">
                                                        <div class="true_progtree">
                                                            <img src="<?php echo base_url("assets/img/true.png"); ?>" alt="success image">
                                                        </div>
                                                        <div class="tr_text">
                                                            Successfully Completed
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <div class="edit_profile_progress">
                                        <div class="progre_bar_text">
                                            <p>Please fill up your entire profile to get better job options and so that recruiter can find you easily.</p>
                                        </div>
                                        <div class="count_main_progress">
                                            <div class="circles">
                                                <div class="second circle-1">
                                                    <div>
                                                        <strong></strong>


                                                        <a href="<?php echo base_url('job/basic-information') ?>" class="edit_profile_job">Edit Profile</a>



                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            
                            <?php echo $left_footer; ?>
                        </div>
                    </div>
                    <div>

                    </div>
                    <div class="custom-right-art mian_middle_post_box animated fadeInUp">
                        <?php
                        if ($this->uri->segment(3) == 'live-post') {
                            echo '<div class="alert alert-success">Applied successfully...!</div>';
                        }
                        ?>
                        <div class="page-title">
                            <h3>Recommended Job</h3>
                        </div>
                        <?php
                        if ($postdetail) {
                            foreach ($postdetail as $post) {
                                ?>
                                <div class="all-job-box" id="applypost' . $post['app_id'] . '">
                                    <div class="all-job-top">
                                        <?php
                                        $cache_time = $this->db->get_where('recruiter', array(
                                                    'user_id' => $post['user_id']
                                                ))->row()->comp_logo;
                                        ?>
                                        <div class="post-img">
                                            <a href="#">
                                                <?php if ($cache_time) { ?>
                                                    <img src="<?php echo base_url($this->config->item('rec_profile_thumb_upload_path') . $cache_time) ?>" alt="<?php echo $cache_time;?>">
                                                <?php } else { ?> 
                                                    <img src="<?php echo base_url('assets/images/commen-img.png'); ?>" alt="common image">
                                                <?php } ?>
                                            </a>
                                        </div>
                                        <?php
                                        $cache_time = $this->db->get_where('job_title', array(
                                                    'title_id' => $post['post_name']
                                                ))->row()->name;
                                        if ($cache_time) {
                                            $post_name = $cache_time;
                                        } else {
                                            $post_name = $post['post_name'];
                                        }
                                        $cache_time1 = $this->db->get_where('recruiter', array(
                                                    'user_id' => $post['user_id']
                                                ))->row()->re_comp_name;

                                        $cache_time2 = $this->db->get_where('recruiter', array(
                                                    'user_id' => $post['user_id']
                                                ))->row()->rec_firstname;
                                        $cache_time3 = $this->db->get_where('recruiter', array(
                                                    'user_id' => $post['user_id']
                                                ))->row()->rec_lastname;
                                        ?>
                                        <div class="job-top-detail">
                                            <h5><a href="#"><?php echo $post_name; ?></a></h5>
                                            <p><a href="#"><?php echo $cache_time1; ?></a></p>
                                            <p><a href="#"><?php echo ucwords($cache_time2) . " " . ucfirst($cache_time3); ?></a></p>
                                        </div>
                                    </div>
                                    <div class="all-job-middle">
                                        <p class="pb5">
                                            <span class="location">
                                                <span><img class="pr5" src="<?php echo base_url('assets/images/location.png'); ?>" alt="Ahmedabad,(India)">Ahmedabad,(India)</span>
                                            </span>
                                            <span class="exp">
                                                <span><img class="pr5" src="<?php echo base_url('assets/images/exp.png'); ?>" alt="experience">
                                                    <?php
                                                    if (($post['min_year'] != '0' || $post['max_year'] != '0') && ($post['fresher'] == 1)) {
                                                        echo $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year' . " " . "(Fresher can also apply)";
                                                        ?>

                                                        <?php
                                                    } else {
                                                        if (($post['min_year'] != '0' || $post['max_year'] != '0')) {
                                                            echo $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year';
                                                        } else {
                                                            echo "Fresher";
                                                        }
                                                    }
                                                    ?>
                                                    <!--3 year - 7 year (freshers can also apply)-->
                                                </span>
                                            </span>
                                        </p>
                                        <p>
                                            <?php echo $post['post_description']; ?>
                                        </p>

                                    </div>
                                    <div class="all-job-bottom">
                                        <span class="job-post-date"><b>Posted on:</b><?php echo date('d-M-Y', strtotime($post['created_date'])); ?></span>
                                        <p class="pull-right">
                                            <?php
                                            $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

                                            $contition_array = array('post_id' => $post['post_id'], 'job_delete' => '0', 'user_id' => $userid);
                                            $jobsave = $this->data['jobsave'] = $this->common->select_data_by_condition('job_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                            ?>
                                            <?php if ($jobsave[0]['job_save'] == 1) { ?>
                                                <a href="javascript:void(0);" class="btn4 disabled">Applied</a>
                                            <?php } else { ?>
                                                <a href="javascript:void(0);" id="<?php echo $post['post_id']; ?>" onClick="savepopup(<?php echo $post['post_id']; ?>)" class="btn4 savedpost<?php echo $post['post_id']; ?>">Save</a>
                                                <a href="javascript:void(0);"  class= "btn4 applypost<?php echo $post['post_id']; ?>" onclick="applypopup(<?php echo $post['post_id'] . ',' . $post['user_id'] ?>)">Apply</a>
                                            <?php } ?>
                                        </p>

                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            
                        }
                        ?>

                    </div>


                    <div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig"> 

                        <div class="all-profile-box">
                                <div class="all-pro-head">
                                    <h4>Profiles<a href="<?php echo base_url('profiles/') . $this->session->userdata('aileenuser_slug'); ?>" class="pull-right">All</a></h4>
                                </div>
                                <ul class="all-pr-list">
                                    <li>
                                        <a href="<?php echo base_url('job'); ?>">
                                            <div class="all-pr-img" >
                                                <img src="<?php echo base_url('assets/img/i1.jpg'); ?>" alt="job">
                                            </div>
                                            <span>Job Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('recruiter'); ?>">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i2.jpg'); ?>" alt="recruiter">
                                            </div>
                                            <span>Recruiter Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('freelance'); ?>">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i3.jpg'); ?>" alt="freelancer">
                                            </div>
                                            <span>Freelance Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('business-profile'); ?>">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i4.jpg'); ?>" alt="business-profile">
                                            </div>
                                            <span>Business Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('artist'); ?>">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i5.jpg'); ?>" alt="artist">
                                            </div>
                                            <span>Artistic Profile</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                    </div>

                    </section>
                    <!-- Model Popup Open -->
                    <!-- Bid-modal  -->
                    <div class="modal message-box biderror" id="bidmodal" role="dialog">
                        <div class="modal-dialog modal-lm">
                            <div class="modal-content">
                                <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                                <div class="modal-body">
                                    <span class="mes"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Model Popup Close -->

                    <?php echo $footer; ?>


                    <!-- script for skill textbox automatic start-->

                    <!-- script for skill textbox automatic end -->
<?php
        if (IS_JOB_JS_MINIFY == '0') {
            ?>
                    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
                    <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
                    
                    <script type="text/javascript" src="<?php echo base_url('assets/js/progressloader.js?ver=' . time()); ?>"></script>
<?php }else{?>


<script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()) ?>"></script>
                    <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
                    <script type="text/javascript" src="<?php echo base_url('assets/js_min/progressloader.js?ver=' . time()); ?>"></script>

<?php }?>
                    <script>
                                $(".alert").delay(3200).fadeOut(300);

                                var base_url = '<?php echo base_url(); ?>';
                                var count_profile_value = '<?php echo $count_profile_value; ?>';
                                var count_profile = '<?php echo $count_profile; ?>';
                    </script>
<?php
        if (IS_JOB_JS_MINIFY == '0') {
            ?>
                    <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/job_all_post.js?ver=' . time()); ?>"></script>
                    <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/search_common.js?ver=' . time()); ?>"></script>
                    <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/progressbar_common.js?ver=' . time()); ?>"></script>
<?php }else{?>


 <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/job/job_all_post.js?ver=' . time()); ?>"></script>
                    <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/job/search_common.js?ver=' . time()); ?>"></script>
                    <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/job/progressbar_common.js?ver=' . time()); ?>"></script>

<?php }?>
                    </body>
                    </html>