<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?> 
        <?php
        if (IS_REC_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css'); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/recruiter.css'); ?>">
            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css'); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/recruiter.css'); ?>">
        <?php } ?>
    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push">
        <?php echo $header; ?>
        <?php if ($recdata['re_step'] == 3) { ?>
            <?php echo $recruiter_header2_border; ?>
        <?php } ?>
        <div id="preloader"></div>
        <!-- START CONTAINER -->
        <section>
            <!-- MIDDLE SECTION START -->

            <div class="user-midd-section" id="paddingtop_fixed">
                <div class="container">
                    <div class="row">


                        <div class="col-md-3 col-sm-3">


                            <div class="add-post-button">


                                <div class="back">
                                    <a href="<?php echo base_url('recruiter/post'); ?>" title="Back To Post">
                                        <div class="but1" >
                                            Back To Post
                                        </div>
                                    </a>
                                </div>


                            </div>
                        </div>

                        <div class="col-md-7 col-sm-8 all-form-content">
                            <div class="common-form">
                                <div class="job-saved-box">

                                    <h3>Applied candidate</h3>
                                    <div class="contact-frnd-post">
                                        <div class="job-contact-frnd ">

                                            <?php
                                            if ($user_data) {
                                                foreach ($user_data as $row) {
                                                    ?>
                                                    <div class="profile-job-post-detail clearfix">
                                                        <div class="profile-job-post-title-inside clearfix"> <div class="profile-job-profile-button clearfix">
                                                                <div class="profile-job-post-location-name-rec">
                                                                    <div style="display: inline-block; float: left;">
                                                                        <div  class="buisness-profile-pic-candidate">
                                                                            <a style="  font-size: 19px;
                                                                               font-weight: 600;" href="<?php echo base_url('job/resume/' . $row['slug']); ?>" title="<?php echo $row['job_user_image']; ?>">

                                                                                <?php
                                                                                $filename = $this->config->item('job_profile_thumb_upload_path') . $row['job_user_image'];
                                                                                $s3 = new S3(awsAccessKey, awsSecretKey);
                                                                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                                                if ($row['job_user_image'] != '' && $info) {
                                                                                    ?>
                                                                                    <img src="<?php echo JOB_PROFILE_THUMB_UPLOAD_URL . $row['job_user_image']; ?>" alt="<?php echo $row['job_user_image']; ?>" >



                                                                                    <?php
                                                                                } else {

                                                                                    $a = $row['fname'];
                                                                                    $acr = substr($a, 0, 1);

                                                                                    $b = $row['lname'];
                                                                                    $acr1 = substr($b, 0, 1);
                                                                                    ?>
                                                                                    <div class="post-img-profile">
            <?php echo ucfirst(strtolower($acr)) . ucfirst(strtolower($acr1)); ?>

                                                                                    </div>

                                                                                <?php }
                                                                                ?> 
                                                                            </a>
                                                                        </div>

                                                                    </div>
                                                                    <div class="designation_rec" style="float: left;">
                                                                        <ul>
                                                                            <li>
                                                                                <a style="  font-size: 19px;
                                                                                   font-weight: 600;" href="<?php echo base_url('job/resume/' . $row['slug']); ?>" title="<?php echo $row['job_user_image']; ?>">
        <?php echo ucfirst(strtolower($row['fname'])) . ' ' . ucfirst(strtolower($row['lname'])); ?></a>
                                                                            </li>
                                                                            <li class="show">
                                                                                <a  style="font-size: 13px;" href="javascript: void(0)" title="Designation">
                                                                                    <?php
                                                                                    if ($row['designation']) {
                                                                                        ?>
                                                                                        <?php echo $row['designation']; ?>
                                                                                        <?php
                                                                                    } else {
                                                                                        ?>

                                                                                        <?php echo "Designation"; ?>

                                                                                        <?php
                                                                                    }
                                                                                    ?> 
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="profile-job-post-title clearfix">

                                                            <div class="profile-job-profile-menu">

                                                                <ul class="clearfix">


                                                                    <?php
                                                                    if ($row['work_job_title']) {
                                                                        $contition_array = array('status' => 'publish', 'title_id' => $row['work_job_title']);
                                                                        $jobtitle = $this->common->select_data_by_condition('job_title', $contition_array, $data = 'name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                                                        if ($jobtitle[0]['name']) {
                                                                            ?>
                                                                            <li> <b> Job Title</b> <span>
                <?php echo $jobtitle[0]['name']; ?>
                                                                                </span>
                                                                            </li>

                                                                        <?php }
                                                                    } ?>
                                                                    <?php
                                                                    if ($row['keyskill']) {
                                                                        $jobskil = array();
                                                                        ?>

                                                                        <li> <b> Skills</b> <span>
                                                                                <?php
                                                                                $work_skill = explode(',', $row['keyskill']);
                                                                                foreach ($work_skill as $skill) {
                                                                                    $contition_array = array('skill_id' => $skill);
                                                                                    $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                                                                                    $jobskil[] = $skilldata[0]['skill'];
                                                                                } echo implode(',', $jobskil);
                                                                                ?>
                                                                            </span>
                                                                        </li>
                                                                    <?php } ?>

                                                                    <?php
                                                                    if ($row['work_job_industry']) {
                                                                        $contition_array = array('industry_id' => $row['work_job_industry']);
                                                                        $industry = $this->common->select_data_by_condition('job_industry', $contition_array, $data = 'industry_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                                        ?>
                                                                        <li> <b> Industry</b> <span>
                                                                        <?php echo $industry[0]['industry_name']; ?>
                                                                            </span>
                                                                        </li>
                                                                    <?php } ?>
                                                                    <?php
                                                                    if ($row['work_job_city']) {
                                                                        $work_city = explode(',', $row['work_job_city']);
                                                                        $cities = array();
                                                                        foreach ($work_city as $city) {
                                                                            $contition_array = array('city_id' => $city);
                                                                            $citydata = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_id,city_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                                                                            if ($citydata) {
                                                                                $cities[] = $citydata[0]['city_name'];
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <li> <b> Preferred Cites</b> <span>
                                                                        <?php echo implode(',', $cities); ?>                                                        
                                                                            </span>
                                                                        </li>
                                                                    <?php } ?> 

                                                                    <?php
                                                                    $contition_array = array('user_id' => $row['userid'], 'experience' => 'Experience', 'status' => '1');
                                                                    $experiance = $this->common->select_data_by_condition('job_add_workexp', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


                                                                    if ($experiance[0]['experience_year'] != '') {
                                                                        ?>
                                                                        <?php
                                                                        $total_work_year = 0;
                                                                        $total_work_month = 0;
                                                                        foreach ($experiance as $work1) {

                                                                            $total_work_year += $work1['experience_year'];
                                                                            $total_work_month += $work1['experience_month'];
                                                                        }
                                                                        ?>
                                                                        <li> <b> Total Experience</b>
                                                                            <span>
                                                                                <?php
                                                                                if ($total_work_month == '12 month' && $total_work_year == '0 year') {
                                                                                    echo "1 year";
                                                                                } elseif ($total_work_year != '0 year' && $total_work_month >= '12 month') {
                                                                                    $month = explode(' ', $total_work_year);

                                                                                    $year = $month[0];
                                                                                    $y = 0;
                                                                                    for ($i = 0; $i <= $y; $i++) {
                                                                                        if ($total_work_month >= 12) {
                                                                                            $year = $year + 1;
                                                                                            $total_work_month = $total_work_month - 12;
                                                                                            $y++;
                                                                                        } else {
                                                                                            $y = 0;
                                                                                        }
                                                                                    }


                                                                                    echo $year;
                                                                                    echo "&nbsp";
                                                                                    echo "Year";
                                                                                    echo "&nbsp";
                                                                                    if ($total_work_month != 0) {
                                                                                        echo $total_work_month;
                                                                                        echo "&nbsp";
                                                                                        echo "Month";
                                                                                    }
                                                                                } else {
                                                                                    echo $total_work_year;
                                                                                    echo "&nbsp";
                                                                                    echo "Year";
                                                                                    echo "&nbsp";
                                                                                    echo $total_work_month;
                                                                                    echo "&nbsp";
                                                                                    echo "Month";
                                                                                }
                                                                                ?>
                                                                            </span>
                                                                        </li>
                                                                        <?php
                                                                    } else {

                                                                        if ($row['experience'] == 'Fresher') {
                                                                            ?>
                                                                            <li> <b> Total Experience</b>
                                                                                <span><?php echo $row['experience']; ?></span>
                                                                            </li>
                                                                            <?php
                                                                        } //if complete
                                                                    }//else complete
                                                                    ?>
                                                                    <?php
                                                                    $contition_array = array('user_id' => $row['userid']);
                                                                    $graduation_data = $this->common->select_data_by_condition('job_graduation', $contition_array, $data = '*', $sortby = 'job_graduation_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');
                                                                    ?>
                                                                            <?php if ($row['board_primary'] && $row['board_secondary'] && $row['board_higher_secondary'] && $graduation_data) { ?>
                                                                        <li>
                                                                            <b>Degree</b><span>
                                                                                <?php
                                                                                $cache_time = $this->db->select('degree_name')->get_where('degree', array('degree_id' => $graduation_data[0]['degree']))->row()->degree_name;
                                                                                if ($cache_time) {
                                                                                    echo $cache_time;
                                                                                } else {
                                                                                    echo PROFILENA;
                                                                                }
                                                                                ?>

                                                                            </span>
                                                                        </li>
                                                                        <li><b>Stream</b>
                                                                            <span>
                                                                                <?php
                                                                                $cache_time = $this->db->select('stream_name')->get_where('stream', array('stream_id' => $graduation_data[0]['stream']))->row()->stream_name;
                                                                                if ($cache_time) {
                                                                                    echo $cache_time;
                                                                                } else {
                                                                                    echo PROFILENA;
                                                                                }
                                                                                ?>                                                </span>
                                                                        </li>
            <?php
        } elseif ($row['board_secondary'] && $row['board_higher_secondary'] && $graduation_data) {
            ?>
                                                                        <li>
                                                                            <b>Degree</b><span>


                                                                                <?php
                                                                                $cache_time = $this->db->select('degree_name')->get_where('degree', array('degree_id' => $graduation_data[0]['degree']))->row()->degree_name;
                                                                                if ($cache_time) {
                                                                                    echo $cache_time;
                                                                                } else {
                                                                                    echo PROFILENA;
                                                                                }
                                                                                ?>

                                                                            </span>
                                                                        </li>
                                                                        <li><b>Stream</b>
                                                                            <span>
                                                                                <?php
                                                                                $cache_time = $this->db->select('stream_name')->get_where('stream', array('stream_id' => $graduation_data[0]['stream']))->row()->stream_name;
                                                                                if ($cache_time) {
                                                                                    echo $cache_time;
                                                                                } else {
                                                                                    echo PROFILENA;
                                                                                }
                                                                                ?>
                                                                            </span>
                                                                        </li>


        <?php } elseif ($row['board_higher_secondary'] && $graduation_data) {
            ?>

                                                                        <li>
                                                                            <b>Degree</b><span>
                                                                                <?php
                                                                                $cache_time = $this->db->select('degree_name')->get_where('degree', array('degree_id' => $graduation_data[0]['degree']))->row()->degree_name;
                                                                                if ($cache_time) {
                                                                                    echo $cache_time;
                                                                                } else {
                                                                                    echo PROFILENA;
                                                                                }
                                                                                ?>

                                                                            </span>
                                                                        </li>
                                                                        <li><b>Stream</b>
                                                                            <span>
                                                                                <?php
                                                                                $cache_time = $this->db->select('stream_name')->get_where('stream', array('stream_id' => $graduation_data[0]['stream']))->row()->stream_name;
                                                                                if ($cache_time) {
                                                                                    echo $cache_time;
                                                                                } else {
                                                                                    echo PROFILENA;
                                                                                }
                                                                                ?>
                                                                            </span>
                                                                        </li>

                                                                            <?php } else if ($row['board_secondary'] && $graduation_data) {
                                                                                ?>
                                                                        <li>
                                                                            <b>Degree</b><span>
                                                                                <?php
                                                                                $cache_time = $this->db->select('degree_name')->get_where('degree', array('degree_id' => $graduation_data[0]['degree']))->row()->degree_name;
                                                                                if ($cache_time) {
                                                                                    echo $cache_time;
                                                                                } else {
                                                                                    echo PROFILENA;
                                                                                }
                                                                                ?>

                                                                            </span>
                                                                        </li>
                                                                        <li><b>Stream</b>
                                                                            <span>
                                                                                <?php
                                                                                $cache_time = $this->db->select('stream_name')->get_where('stream', array('stream_id' => $graduation_data[0]['stream']))->row()->stream_name;
                                                                                if ($cache_time) {
                                                                                    echo $cache_time;
                                                                                } else {
                                                                                    echo PROFILENA;
                                                                                }
                                                                                ?>
                                                                            </span>
                                                                        </li>

                                                                            <?php } elseif ($row['board_primary'] && $graduation_data) { ?>
                                                                        <li>
                                                                            <b>Degree</b><span>
                                                                                <?php
                                                                                $cache_time = $this->db->select('degree_name')->get_where('degree', array('degree_id' => $graduation_data[0]['degree']))->row()->degree_name;
                                                                                if ($cache_time) {
                                                                                    echo $cache_time;
                                                                                } else {
                                                                                    echo PROFILENA;
                                                                                }
                                                                                ?>

                                                                            </span>
                                                                        </li>
                                                                        <li><b>Stream</b>
                                                                            <span>
                                                                                <?php
                                                                                $cache_time = $this->db->select('stream_name')->get_where('stream', array('stream_id' => $graduation_data[0]['stream']))->row()->stream_name;
                                                                                if ($cache_time) {
                                                                                    echo $cache_time;
                                                                                } else {
                                                                                    echo PROFILENA;
                                                                                }
                                                                                ?>
                                                                            </span>
                                                                        </li>

                                                                            <?php } elseif ($row['board_primary'] && $row['board_secondary'] && $row['board_higher_secondary']) { ?>
                                                                        <li><b>Board of Higher Secondary</b>
                                                                            <span>
            <?php echo $row['board_higher_secondary']; ?>
                                                                            </span>
                                                                        </li>
                                                                        <li><b>Percentage of Higher Secondary</b>
                                                                            <span>
            <?php echo $row['percentage_higher_secondary']; ?>
                                                                            </span>
                                                                        </li>


                                                                            <?php } elseif ($row['board_secondary'] && $row['board_higher_secondary']) { ?>
                                                                        <li><b>Board of Higher Secondary</b>
                                                                            <span>
            <?php echo $row['board_higher_secondary']; ?>
                                                                            </span>
                                                                        </li>
                                                                        <li><b>Percentage of Higher Secondary</b>
                                                                            <span>
                                                                        <?php echo $row['percentage_higher_secondary']; ?>
                                                                            </span>
                                                                        </li>

        <?php } elseif ($row['board_primary'] && $row['board_higher_secondary']) { ?>


                                                                        <li><b>Board of Higher Secondary</b>
                                                                            <span>
            <?php echo $row['board_higher_secondary']; ?>
                                                                            </span>
                                                                        </li>
                                                                        <li><b>Percentage of Higher Secondary</b>
                                                                            <span>
            <?php echo $row['percentage_higher_secondary']; ?>
                                                                            </span>
                                                                        </li>


                                                                            <?php } elseif ($row['board_primary'] && $row['board_secondary']) { ?>

                                                                        <li><b>Board of Secondary</b>
                                                                            <span>
            <?php echo $row['board_secondary']; ?>
                                                                            </span>
                                                                        </li>
                                                                        <li><b>Percentage of Secondary</b>
                                                                            <span>
                                                                        <?php echo $row['percentage_secondary']; ?>
                                                                            </span>
                                                                        </li>

        <?php } elseif ($graduation_data) { ?>

                                                                        <li>
                                                                            <b>Degree</b><span>


                                                                                <?php
                                                                                $cache_time = $this->db->select('degree_name')->get_where('degree', array('degree_id' => $graduation_data[0]['degree']))->row()->degree_name;
                                                                                if ($cache_time) {
                                                                                    echo $cache_time;
                                                                                } else {
                                                                                    echo PROFILENA;
                                                                                }
                                                                                ?>

                                                                            </span>
                                                                        </li>
                                                                        <li><b>Stream</b>
                                                                            <span>
                                                                                <?php
                                                                                $cache_time = $this->db->select('stream_name')->get_where('stream', array('stream_id' => $graduation_data[0]['stream']))->row()->stream_name;
                                                                                if ($cache_time) {
                                                                                    echo $cache_time;
                                                                                } else {
                                                                                    echo PROFILENA;
                                                                                }
                                                                                ?>
                                                                            </span>
                                                                        </li>

                                                                            <?php } elseif ($row['board_higher_secondary']) { ?>

                                                                        <li><b>Board of Higher Secondary</b>
                                                                            <span>
            <?php echo $row['board_higher_secondary']; ?>
                                                                            </span>
                                                                        </li>
                                                                        <li><b>Percentage of Higher Secondary</b>
                                                                            <span>
            <?php echo $row['percentage_higher_secondary']; ?>
                                                                            </span>
                                                                        </li>


                                                                            <?php } elseif ($row['board_secondary']) { ?> 

                                                                        <li><b>Board of Secondary</b>
                                                                            <span>
            <?php echo $row['board_secondary']; ?>
                                                                            </span>
                                                                        </li>
                                                                        <li><b>Percentage of Secondary</b>
                                                                            <span>
                                                                        <?php echo $row['percentage_secondary']; ?>
                                                                            </span>
                                                                        </li>

                                                                            <?php } elseif ($row['board_primary']) { ?>

                                                                        <li><b>Board of Primary</b>
                                                                            <span>
            <?php echo $row['board_primary']; ?>
                                                                            </span>
                                                                        </li>
                                                                        <li><b>Percentage of Primary</b>
                                                                            <span>
                                                                        <?php echo $row['percentage_primary']; ?>
                                                                            </span>
                                                                        </li>

        <?php } ?>




                                                                    <li><b>E-mail</b>
                                                                        <span><?php
        echo $row['email'];
        ?></span>
                                                                    </li>

        <?php
        if ($row['phnno']) {
            ?>
                                                                        <li><b>Mobile Number</b>
                                                                            <span>

                                                                        <?php
                                                                        echo $row['phnno'];
                                                                        ?></span>
                                                                        </li>
            <?php
        }
        ?>


                                                                </ul>
                                                            </div>

                                                            <div class="profile-job-profile-button clearfix">
                                                                <div class="apply-btn fr">

                                                                    <?php
                                                                    $userid = $this->session->userdata('aileenuser');
                                                                    if ($userid != $row['userid']) {

                                                                        $contition_array = array('from_id' => $userid, 'to_id' => $row['userid'], 'save_type' => '1', 'status' => '0');
                                                                        $savedata = $this->common->select_data_by_condition('save', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                                        ?>


                                                                        <a  class="button invite_border" href="<?php echo base_url('chat/abc/2/1/' . $row['userid']); ?>" title="Message">Message</a>

                                                                        <?php
                                                                        $contition_array = array('invite_user_id' => $row['userid'], 'post_id' => $postid);
                                                                        $userdata = $this->common->select_data_by_condition('user_invite', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                                        if ($userdata) {
                                                                            ?>
                                                                            <a href="javascript:void(0);" class="button invited" id="<?php echo 'invited' . $row['userid']; ?>" style="cursor: default;" title="Invited"> Invited</a>      
                                                                        <?php } else { ?>

                                                                            <a  href="javascript:void(0);" class="button invite_border" id="<?php echo 'invited' . $row['userid']; ?>" onClick="inviteusermodel(<?php echo $row['userid']; ?>)" title="Invite"> Invite</a>

                                                                        <?php } ?>



                                                                        <?php if ($savedata) { ?> 

                                                                            <a class="saved" title="Saved">Saved </a> 

                                                                        <?php } else { ?>
                                                                            <input type="hidden" id="<?php echo 'hideenuser' . $row['userid']; ?>" value= "<?php echo $data[0]['save_id']; ?>"> 
                                                                            <a class="button invite_border saveduser<?php echo $row['userid']; ?>"  id="<?php echo $row['userid']; ?>" onClick="savepopup(<?php echo $row['userid']; ?>)" href="javascript:void(0);" class="<?php echo 'saveduser' . $row['userid']; ?>"  title="Save">Save</a>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div> </div>
                                                        </div>
                                                    </div>

                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <div class="art-img-nn">
                                                    <div class="art_no_post_img">

                                                        <img src="<?php echo base_url('assets/img/job-no1.png') ?>" alt="job-no1.png">

                                                    </div>
                                                    <div class="art_no_post_text">
                                                        No Applied Candidate  Available.
                                                    </div>
                                                </div>
    <?php
}
?>      
                                            <!-- khyati end -->
                                            <div class="col-md-1">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- MIDDLE SECTION END-->
        </section>
        <!-- END CONTAINER -->

        <!-- BID MODAL START -->
        <div class="modal fade message-box biderror" id="bidmodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- BID MODAL END -->
        <!-- BEGIN FOOTER -->
        <?php echo $footer; ?>
        <!-- END FOOTER -->
        <!-- FIELD VALIDATION JS START -->

<?php
if (IS_REC_JS_MINIFY == '0') {
    ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js') ?>"></script>
            <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script> 
            <!--SCRIPT FOR DATE START-->
            <script src="<?php echo base_url('assets/js/jquery.date-dropdowns.js'); ?>"></script>

    <?php
} else {
    ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js') ?>"></script>
            <script src="<?php echo base_url('assets/js_min/bootstrap.min.js'); ?>"></script> 
            <!--SCRIPT FOR DATE START-->
            <script src="<?php echo base_url('assets/js_min/jquery.date-dropdowns.js'); ?>"></script>

<?php } ?>



        <script>
                                                                                var base_url = '<?php echo base_url(); ?>';
                                                                                var data1 = <?php echo json_encode($de); ?>;
                                                                                var data = <?php echo json_encode($demo); ?>;
                                                                                var jobdata = <?php echo json_encode($jobtitle); ?>;
                                                                                var get_csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
                                                                                var get_csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
        </script>
        <!-- FIELD VALIDATION JS END -->
<?php
if (IS_REC_JS_MINIFY == '0') {
    ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/search.js'); ?>"></script>

    <?php
} else {
    ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/recruiter/search.js'); ?>"></script>

<?php } ?>

        <script type="text/javascript">


                                                                                function inviteusermodel(abc) {

                                                                                    $('.biderror .mes').html("<div class='pop_content'>Do you want to invite this candidate for interview?<div class='model_ok_cancel'><a class='okbtn' id=" + abc + " onClick='inviteuser(" + abc + ")' href='javascript:void(0);' data-dismiss='modal' title='Yes'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal' title='No'>No</a></div></div>");
                                                                                    $('#bidmodal').modal('show');

                                                                                }

                                                                                function inviteuser(clicked_id)
                                                                                {

                                                                                    var post_id = "<?php echo $postid; ?>";
                                                                                    var post_id = "<?php echo $postid; ?>";

                                                                                    $.ajax({
                                                                                        type: 'POST',
                                                                                        url: '<?php echo base_url() . "recruiter/invite_user" ?>',
                                                                                        data: 'post_id=' + post_id + '&invited_user=' + clicked_id,
                                                                                        dataType: 'json',
                                                                                        success: function (data) {
                                                                                            $('#' + 'invited' + clicked_id).html(data.status).addClass('invited').removeClass('invite_border').removeAttr("onclick");
                                                                                            $('#' + 'invited' + clicked_id).css('cursor', 'default');
                                                                                            if (data.notification.notification_count != 0) {
                                                                                                var notification_count = data.notification.notification_count;
                                                                                                var to_id = data.notification.to_id;
                                                                                                show_header_notification(notification_count, to_id);
                                                                                            }

                                                                                        }

                                                                                    });
                                                                                }


        </script>
        <script>
            function savepopup(id) {

                save_user(id);
                //                       
                $('.biderror .mes').html("<div class='pop_content'>Candidate successfully saved.");
                $('#bidmodal').modal('show');
            }
        </script>
        <script type="text/javascript">
            function save_user(abc)
            {

                var saveid = document.getElementById("hideenuser" + abc);

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() . "recruiter/save_search_user" ?>',
                    data: 'user_id=' + abc + '&save_id=' + saveid.value,
                    success: function (data) {

                        $('#' + abc).html(data).addClass('saved');


                    }
                });

            }
        </script>

        <style type="text/css">

            .keyskill_border_active {
                border: 3px solid #f00 !important;

            }
            #skills-error{margin-top: 40px !important;}

            #minmonth-error{    margin-top: 40px; margin-right: 9px;}
            #minyear-error{margin-top: 42px !important;margin-right: 9px;}
            #maxmonth-error{margin-top: 42px !important;margin-right: 9px;}
            #maxyear-error{margin-top: 42px !important;margin-right: 9px;}

            #minmonth-error{margin-top: 39px !important;}
            #minyear-error{margin-top: auto !important;}
            #maxmonth-error{margin-top: 39px !important;}
            #maxyear-error{margin-top: auto !important;}
            #example2-error{margin-top: 40px !important}


        </style>
    </body>
</html>