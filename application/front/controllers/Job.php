<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Job extends MY_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('job_model');
        $this->load->model('recruiter_model');
        $this->load->library('S3');
        $this->load->library('upload');

        //   This function is there only one time users slug created after remove it start
//         $this->db->select('job_id,fname,lname');
//         $res = $this->db->get('job_reg')->result();
//         foreach ($res as $k => $v) {
//             $data = array('slug' => $this->setcategory_slug($v->fname."-". $v->lname, 'slug', 'job_reg'));
//             $this->db->where('job_id', $v->job_id);
//             $this->db->update('job_reg', $data);
//         }
        // This function is there only one time users slug created after remove it End
        include ('include.php');
          include ('main_profile_link.php');
        include ('job_include.php');
        $this->data['aileenuser_id'] = $this->session->userdata('aileenuser');
    }

    //job seeker basic info controller start

    public function index() {

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');
        $jobdata = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($jobdata[0]['total'] != 0) {
            $this->load->view('job/reactivate', $this->data);
        } else {
            $this->job_apply_check();
            $contition_array = array('user_id' => $userid, 'status' => '1', 'is_delete' => '0');
            $job = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($job[0]['job_step'] == 10) {
                redirect('job/home', refresh);
            } else {
                redirect('job/registration', refresh);
            }
        }
    }

    public function job_basicinfo_update() {

        $this->job_apply_check();
        $this->job_deactive_profile();

        $userid = $this->session->userdata('aileenuser');

        //Retrieve Data from main user registartion table start
        $this->data['job'] = $this->user_model->getUserSelectedData($userid, $select_data = 'u.first_name,u.last_name,ul.email,u.user_gender,u.user_dob');
        //Retrieve Data from main user registartion table end
        $data = 'fname,lname,email,phnno,pincode,address,dob,gender,job_step,city_id,language,count(*) as total';
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->data['userdata'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $contition_array = array('status' => '1');
        $this->data['language1'] = $this->common->select_data_by_condition('language', $contition_array, $data = '*', $sortby = 'language_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userdata[0]['total'] != 0) {
            $step = $userdata[0]['job_step'];

            if ($step == 1 || $step > 1) {
                $this->data['fname1'] = $userdata[0]['fname'];
                $this->data['lname1'] = $userdata[0]['lname'];
                $this->data['email1'] = $userdata[0]['email'];
                $this->data['phnno1'] = $userdata[0]['phnno'];
                $this->data['pincode1'] = $userdata[0]['pincode'];
                $this->data['address1'] = $userdata[0]['address'];
                $this->data['dob1'] = $userdata[0]['dob'];
                $this->data['gender1'] = $userdata[0]['gender'];
            }
        }

        //Retrieve City data Start   
        $contition_array = array('status' => '1', 'city_id' => $userdata[0]['city_id']);
        $citytitle = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->data['city_title'] = $citytitle[0]['city_name'];
        //Retrieve City data End
        //Retrieve Language data Start 
        $language_know = explode(',', $userdata[0]['language']);
        foreach ($language_know as $lan) {
            $contition_array = array('language_id' => $lan, 'status' => '1');
            $languagedata = $this->common->select_data_by_condition('language', $contition_array, $data = 'language_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
            $detailes[] = $languagedata[0]['language_name'];
        }

        $this->data['language2'] = implode(',', $detailes);
        //Retrieve Language data End

        $skildata = explode(',', $userdata[0]['language']);
        $this->data['selectdata'] = $skildata;

        $this->data['title'] = 'Basic Information | Edit Profile -  Job Profile' . TITLEPOSTFIX;

        $this->load->view('job/index', $this->data);
    }

    public function job_basicinfo_insert() {

        $this->job_deactive_profile();
        $userid = $this->session->userdata('aileenuser');

        $this->form_validation->set_rules('fname', 'Firstname', 'required');
        $this->form_validation->set_rules('lname', 'Lastname', 'required');
        $this->form_validation->set_rules('email', 'Store  email', 'required|valid_email');
        $this->form_validation->set_rules('language', 'Language', 'required');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'required');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        // Language  start   
        $language = $this->input->post('language');
        $language = explode(',', $language);


        if (count($language) > 0) {
            foreach ($language as $lan) {

                $contition_array = array('language_name' => trim($lan), 'status' => '1');
                $languagedata = $this->common->select_data_by_condition('language', $contition_array, $data = 'language_id,count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                if ($languagedata[0]['total'] != 0) {
                    $language_know[] = $languagedata[0]['language_id'];
                }
            }
            $language1 = implode(',', $language_know);
        }
        // Language  End   
        // City  start   
        $city = $this->input->post('city');
        if ($city != " ") {
            $contition_array = array('city_name' => $city, 'status' => '1');
            $citydata = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_id,count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
            if ($citydata[0]['total'] != 0) {
                $citytitle = $citydata[0]['city_id'];
            }
        }
        // City  End   

        $bod = $this->input->post('dob');
        $bod = str_replace('/', '-', $bod);

        if ($this->form_validation->run() == FALSE) {

            $this->load->view('job/index', $this->data);
        } else {
            $data = array(
                'fname' => ucfirst($this->input->post('fname')),
                'lname' => ucfirst($this->input->post('lname')),
                'email' => $this->input->post('email'),
                'phnno' => $this->input->post('phnno'),
                'language' => $language1,
                'dob' => date('Y-m-d', strtotime($bod)),
                'gender' => $this->input->post('gender'),
                'city_id' => $citytitle,
                'pincode' => $this->input->post('pincode'),
                'address' => $this->input->post('address'),
                'slug' => $this->setcategory_slug($this->input->post('fname') . '-' . $this->input->post('lname'), 'slug', 'job_reg'),
                'modified_date' => date('Y-m-d h:i:s', time())
            );


            $updatedata = $this->common->update_data($data, 'job_reg', 'user_id', $userid);
            if ($updatedata) {
                redirect('job/qualification', refresh);
            } else {
                redirect('job/basic-information', refresh);
            }
        }
    }

//job seeker basic info controller end
//job seeker email already exist checking controller start

    public function check_email() {

        $email = $_POST['email'];

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'email', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $email1 = $userdata[0]['email'];


        if ($email1) {
            $condition_array = array('is_delete' => '0', 'user_id !=' => $userid, 'status' => '1', 'job_step' => 10);

            $check_result = $this->common->check_unique_avalibility('job_reg', 'email', $email, '', '', $condition_array);
        } else {

            $condition_array = array('is_delete' => '0', 'status' => '1');

            $check_result = $this->common->check_unique_avalibility('job_reg', 'email', $email, '', '', $condition_array);
        }

        if ($check_result) {
            echo 'true';
            die();
        } else {
            echo 'false';
            die();
        }
    }

//job seeker email already exist checking controller End
    //job seeker EDUCATION controller start
    public function job_education_update($postid = " ") {

        $this->job_apply_check();
        $this->job_deactive_profile();

        $this->data['postid'] = $postid;

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');

        //for getting degree data Strat
        $contition_array = array('is_delete' => '0', 'degree_name !=' => "Other");
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
        $degree_data = $this->data['degree_data'] = $this->common->select_data_by_search('degree', $search_condition, $contition_array, $data = 'degree_id,degree_name', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('status' => '1', 'is_delete' => '0', 'degree_name' => "Other");
        $this->data['degree_otherdata'] = $this->common->select_data_by_condition('degree', $contition_array, $data = 'degree_id,degree_name', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        //for getting degree data End
        //for getting univesity data Start
        $contition_array = array('is_delete' => '0', 'university_name !=' => "Other");
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
        $university_data = $this->data['university_data'] = $this->common->select_data_by_search('university', $search_condition, $contition_array, $data = 'university_id,university_name', $sortby = 'university_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('is_delete' => '0', 'status' => '1', 'university_name' => "Other");
        $this->data['university_otherdata'] = $this->common->select_data_by_condition('university', $contition_array, $data = 'university_id,university_name', $sortby = 'university_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //for getting univesity data End
        //For getting all Stream Strat
        $contition_array = array('is_delete' => '0', 'stream_name !=' => "Other");
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
        $stream_alldata = $this->data['stream_alldata'] = $this->common->select_data_by_search('stream', $search_condition, $contition_array, $data = 'stream_id,stream_name', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = 'stream_name');

        $contition_array = array('is_delete' => '0', 'stream_name !=' => "Other");
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1') AND (stream_name != 'Others'))";
        $stream_alldata1 = $this->data['stream_alldata1'] = $this->common->select_data_by_search('stream', $search_condition, $contition_array, $data = 'stream_id,stream_name', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = 'stream_name');

        $contition_array = array('status' => '1', 'is_delete' => '0', 'stream_name' => "Other");
        $stream_otherdata = $this->data['stream_otherdata'] = $this->common->select_data_by_condition('stream', $contition_array, $data = 'stream_id,stream_name', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = 'stream_name');
        //For getting all Stream End

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'count(*) as total,job_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userdata[0]['total'] != 0) {
            $step = $userdata[0]['job_step'];

            if ($step == 3 || ($step >= 1 && $step <= 3) || $step > 3) {

                $userid = $this->session->userdata('aileenuser');

                $data = 'edu_id,board_primary,school_primary,percentage_primary,pass_year_primary,edu_certificate_primary,board_secondary,school_secondary,percentage_secondary,pass_year_secondary,edu_certificate_secondary,board_higher_secondary,stream_higher_secondary,school_higher_secondary,percentage_higher_secondary,pass_year_higher_secondary,edu_certificate_higher_secondary';
                $contition_array = array('user_id' => $userid, 'status' => '1');
                $jobdata = $this->data['jobdata'] = $this->common->select_data_by_condition('job_add_edu', $contition_array, $data, $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $data = 'job_graduation_id,degree,stream,university,college,grade,percentage,pass_year,edu_certificate';
                $contition_array = array('user_id' => $userid);
                $jobgrad = $this->data['jobgrad'] = $this->common->select_data_by_condition('job_graduation', $contition_array, $data, $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            }
        }

        $this->data['title'] = 'Qualification | Edit Profile - Job Profile' . TITLEPOSTFIX;
        $this->load->view('job/job_education', $this->data);
    }

//Insert Primary Education Data End


    public function job_education_primary_insert() {

        $this->job_deactive_profile();

        $userid = $this->session->userdata('aileenuser');

        //S3 BUCKET ACCESS START
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
        //S3 BUCKET ACCESS START

        $error = '';
        if ($_FILES['edu_certificate_primary']['name'] != '') {

            //Configuring Main Image Start
            $job['upload_path'] = $this->config->item('job_edu_main_upload_path');
            $job['allowed_types'] = $this->config->item('job_edu_main_allowed_types');
            $this->upload->initialize($job);

            if ($this->upload->do_upload('edu_certificate_primary')) {

                $imgdata = $this->upload->data();
                $main_image_size = $_FILES['edu_certificate_primary']['size'];

                if ($main_image_size > '1000000') {
                    $quality = "50%";
                } elseif ($main_image_size > '50000' && $main_image_size < '1000000') {
                    $quality = "55%";
                } elseif ($main_image_size > '5000' && $main_image_size < '50000') {
                    $quality = "60%";
                } elseif ($main_image_size > '100' && $main_image_size < '5000') {
                    $quality = "65%";
                } elseif ($main_image_size > '1' && $main_image_size < '100') {
                    $quality = "70%";
                } else {
                    $quality = "100%";
                }

                /* RESIZE */

                $job['image_library'] = 'gd2';
                $job['source_image'] = $this->config->item('job_edu_main_upload_path') . $imgdata['file_name'];
                $job['new_image'] = $this->config->item('job_edu_main_upload_path') . $imgdata['file_name'];
                $job['quality'] = $quality;
                $instanse10 = "image10";
                $this->load->library('image_lib', $job, $instanse10);
                $this->$instanse10->watermark();
                /* RESIZE */

                //S3 BUCKET STORE MAIN IMAGE START
                $main_image = $job['new_image'];
                $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);
                //S3 BUCKET STORE MAIN IMAGE END


                $main_file = $this->config->item('job_edu_main_upload_path') . $imgdata['file_name'];
            }
            //Configuring Main Image End
            //Configuring Thumbnail Start
            $job_thumb['image_library'] = 'gd2';
            $job_thumb['source_image'] = $this->config->item('job_edu_main_upload_path') . $imgdata['file_name'];
            $job_thumb['new_image'] = $this->config->item('job_edu_thumb_upload_path') . $imgdata['file_name'];
            $job_thumb['create_thumb'] = TRUE;
            $job_thumb['maintain_ratio'] = TRUE;
            $job_thumb['thumb_marker'] = '';
            $job_thumb['width'] = $this->config->item('job_edu_thumb_width');
            $job_thumb['height'] = 2;
            $job_thumb['master_dim'] = 'width';
            $job_thumb['quality'] = "100%";
            $job_thumb['x_axis'] = '0';
            $job_thumb['y_axis'] = '0';
            //Loading Image Library

            $instanse = "image";
            $this->load->library('image_lib', $job_thumb, $instanse);
            $dataimage = $imgdata['file_name'];

            //Creating Thumbnail
            $this->$instanse->resize();
            $thumberror = $this->$instanse->display_errors();
            //echo "<pre>";print_r($thumberror);die();
            $thumberror = '';
            //Configuring Thumbnail End
            //S3 BUCKET STORE THUMB IMAGE START
            $thumb_image = $job_thumb['new_image'];
            $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);
            //S3 BUCKET STORE THUMB IMAGE END

            $thumb_file = $this->config->item('job_edu_thumb_upload_path') . $imgdata['file_name'];
        }


        if ($_SERVER['HTTP_HOST'] != "localhost") {
            if (isset($main_file)) {
                unlink($main_file);
            }
            if (isset($thumb_file)) {
                unlink($thumb_file);
            }
        }

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $job_reg_data = $this->common->select_data_by_condition('job_add_edu', $contition_array, $data = 'edu_certificate_primary', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $job_reg_prev_image = $job_reg_data[0]['edu_certificate_primary'];
        $edu_certificate_primary = $_FILES['edu_certificate_primary']['name'];


        $image_hidden_primary = $this->input->post('image_hidden_primary');

        if ($job_reg_prev_image != '') {
            $job_image_main_path = $this->config->item('job_edu_main_upload_path');
            $job_bg_full_image = $job_image_main_path . $job_reg_prev_image;
            if (isset($job_bg_full_image)) {
                //delete image from folder when user change image start
                if ($image_hidden_primary == $job_reg_prev_image && $edu_certificate_primary != "") {

                    unlink($job_bg_full_image);
                }
                //delete image from folder when user change image End
            }

            $job_image_thumb_path = $this->config->item('job_edu_thumb_upload_path');
            $job_bg_thumb_image = $job_image_thumb_path . $job_reg_prev_image;
            if (isset($job_bg_thumb_image)) {
                //delete image from folder when user change image Start
                if ($image_hidden_primary == $job_reg_prev_image && $edu_certificate_primary != "") {
                    unlink($job_bg_thumb_image);
                }
                //delete image from folder when user change image End
            }
        }

        $job_certificate = $imgdata['file_name'];



        $contition_array = array('user_id' => $userid);
        $userdata = $this->common->select_data_by_condition('job_add_edu', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        if ($userdata[0]['total'] != 0) {
            $edu_certificate_primary = $_FILES['edu_certificate_primary']['name'];

            if ($edu_certificate_primary == "") {
                $data = array(
                    'edu_certificate_primary' => str_replace(' ', '_', $this->input->post('image_hidden_primary'))
                );
            } else {
                $data = array(
                    'edu_certificate_primary' => str_replace(' ', '_', $job_certificate)
                );
            }
            $updatedata = $this->common->update_data($data, 'job_add_edu', 'user_id', $userid);

            $data = array(
                'user_id' => $userid,
                'board_primary' => $this->input->post('board_primary'),
                'school_primary' => $this->input->post('school_primary'),
                'percentage_primary' => $this->input->post('percentage_primary'),
                'pass_year_primary' => $this->input->post('pass_year_primary')
            );

            $updatedata = $this->common->update_data($data, 'job_add_edu', 'user_id', $userid);


            //Update only one field into database End 

            if ($updatedata) {
                redirect('job/qualification/secondary');
            } else {
                redirect('job/qualification', refresh);
            }
        } else {
            $data = array(
                'user_id' => $userid,
                'board_primary' => $this->input->post('board_primary'),
                'school_primary' => $this->input->post('school_primary'),
                'percentage_primary' => $this->input->post('percentage_primary'),
                'pass_year_primary' => $this->input->post('pass_year_primary'),
                'edu_certificate_primary' => str_replace(' ', '_', $job_certificate),
                'status' => '1'
            );
            $insert_id = $this->common->insert_data_getid($data, 'job_add_edu');

            if ($insert_id) {

                redirect('job/qualification/secondary');
            } else {

                redirect('job/qualification', refresh);
            }
        }
    }

//Insert Secondary Education Data start
    public function job_education_secondary_insert() {
        $this->job_deactive_profile();

        $userid = $this->session->userdata('aileenuser');

        //S3 BUCKET ACCESS START
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
        //S3 BUCKET ACCESS START

        $error = '';
        if ($_FILES['edu_certificate_secondary']['name'] != '') {

            //Configuring Main Image Start
            $job['upload_path'] = $this->config->item('job_edu_main_upload_path');
            $job['allowed_types'] = $this->config->item('job_edu_main_allowed_types');
            $this->upload->initialize($job);

            if ($this->upload->do_upload('edu_certificate_secondary')) {

                $imgdata = $this->upload->data();
                $main_image_size = $_FILES['edu_certificate_secondary']['size'];

                if ($main_image_size > '1000000') {
                    $quality = "50%";
                } elseif ($main_image_size > '50000' && $main_image_size < '1000000') {
                    $quality = "55%";
                } elseif ($main_image_size > '5000' && $main_image_size < '50000') {
                    $quality = "60%";
                } elseif ($main_image_size > '100' && $main_image_size < '5000') {
                    $quality = "65%";
                } elseif ($main_image_size > '1' && $main_image_size < '100') {
                    $quality = "70%";
                } else {
                    $quality = "100%";
                }

                /* RESIZE */

                $job['image_library'] = 'gd2';
                $job['source_image'] = $this->config->item('job_edu_main_upload_path') . $imgdata['file_name'];
                $job['new_image'] = $this->config->item('job_edu_main_upload_path') . $imgdata['file_name'];
                $job['quality'] = $quality;
                $instanse10 = "image10";
                $this->load->library('image_lib', $job, $instanse10);
                $this->$instanse10->watermark();
                /* RESIZE */

                //S3 BUCKET STORE MAIN IMAGE START
                $main_image = $job['new_image'];
                $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);
                //S3 BUCKET STORE MAIN IMAGE END
            }
            //Configuring Main Image End
            //Configuring Thumbnail Start
            $job_thumb['image_library'] = 'gd2';
            $job_thumb['source_image'] = $this->config->item('job_edu_main_upload_path') . $imgdata['file_name'];
            $job_thumb['new_image'] = $this->config->item('job_edu_thumb_upload_path') . $imgdata['file_name'];
            $job_thumb['create_thumb'] = TRUE;
            $job_thumb['maintain_ratio'] = TRUE;
            $job_thumb['thumb_marker'] = '';
            $job_thumb['width'] = $this->config->item('job_edu_thumb_width');
            $job_thumb['height'] = 2;
            $job_thumb['master_dim'] = 'width';
            $job_thumb['quality'] = "100%";
            $job_thumb['x_axis'] = '0';
            $job_thumb['y_axis'] = '0';
            //Loading Image Library

            $instanse = "image";
            $this->load->library('image_lib', $job_thumb, $instanse);
            $dataimage = $imgdata['file_name'];

            //Creating Thumbnail
            $this->$instanse->resize();
            $thumberror = $this->$instanse->display_errors();
            $thumberror = '';
            //Configuring Thumbnail End
            //S3 BUCKET STORE THUMB IMAGE START
            $thumb_image = $job_thumb['new_image'];
            $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);
            //S3 BUCKET STORE THUMB IMAGE END
            $thumb_file = $this->config->item('job_edu_thumb_upload_path') . $imgdata['file_name'];
            $main_file = $this->config->item('job_edu_main_upload_path') . $imgdata['file_name'];
        }


        if ($_SERVER['HTTP_HOST'] != "localhost") {
            if (isset($main_file)) {
                unlink($main_file);
            }
            if (isset($thumb_file)) {
                unlink($thumb_file);
            }
        }


        $contition_array = array('user_id' => $userid);
        $job_reg_data = $this->common->select_data_by_condition('job_add_edu', $contition_array, $data = 'edu_certificate_secondary', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $job_reg_prev_image = $job_reg_data[0]['edu_certificate_secondary'];

        $image_hidden_secondary = $this->input->post('image_hidden_secondary');

        $edu_certificate_secondary = $_FILES['edu_certificate_secondary']['name'];

        if ($job_reg_prev_image != '') {
            $job_image_main_path = $this->config->item('job_edu_main_upload_path');
            $job_bg_full_image = $job_image_main_path . $job_reg_prev_image;
            if (isset($job_bg_full_image)) {

                //delete image from folder when user change image start
                if ($image_hidden_secondary == $job_reg_prev_image && $edu_certificate_secondary != "") {

                    unlink($job_bg_full_image);
                }
                //delete image from folder when user change image End
            }

            $job_image_thumb_path = $this->config->item('job_edu_thumb_upload_path');
            $job_bg_thumb_image = $job_image_thumb_path . $job_reg_prev_image;
            if (isset($job_bg_thumb_image)) {

                //delete image from folder when user change image Start
                if ($image_hidden_secondary == $job_reg_prev_image && $edu_certificate_secondary != "") {
                    unlink($job_bg_thumb_image);
                }
                //delete image from folder when user change image End
            }
        }

        $job_certificate = $imgdata['file_name'];

        $contition_array = array('user_id' => $userid);
        $userdata = $this->common->select_data_by_condition('job_add_edu', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userdata[0]['total'] != 0) {
            $edu_certificate_secondary = $_FILES['edu_certificate_secondary']['name'];

            if ($edu_certificate_secondary == "") {
                $data = array(
                    'edu_certificate_secondary' => str_replace(' ', '_', $this->input->post('image_hidden_secondary'))
                );
            } else {
                $data = array(
                    'edu_certificate_secondary' => str_replace(' ', '_', $job_certificate)
                );
            }
            $updatedata = $this->common->update_data($data, 'job_add_edu', 'user_id', $userid);

            $data = array(
                'user_id' => $userid,
                'board_secondary' => $this->input->post('board_secondary'),
                'school_secondary' => $this->input->post('school_secondary'),
                'percentage_secondary' => $this->input->post('percentage_secondary'),
                'pass_year_secondary' => $this->input->post('pass_year_secondary')
            );

            $updatedata = $this->common->update_data($data, 'job_add_edu', 'user_id', $userid);


            //Update only one field into database End 

            if ($updatedata) {
                redirect('job/qualification/higher-secondary');
            } else {

                redirect('job/qualification', refresh);
            }
        } else {
            $data = array(
                'user_id' => $userid,
                'board_secondary' => $this->input->post('board_secondary'),
                'school_secondary' => $this->input->post('school_secondary'),
                'percentage_secondary' => $this->input->post('percentage_secondary'),
                'pass_year_secondary' => $this->input->post('pass_year_secondary'),
                'edu_certificate_secondary' => str_replace(' ', '_', $job_certificate),
                'status' => 1
            );
            $insert_id = $this->common->insert_data_getid($data, 'job_add_edu');

            if ($insert_id) {
                redirect('job/qualification/higher-secondary');
            } else {
                redirect('job/qualification', refresh);
            }
        }
    }

//Insert Secondary Education Data End
//Insert Higher Secondary Education Data start
    public function job_education_higher_secondary_insert() {

        $this->job_deactive_profile();
        $userid = $this->session->userdata('aileenuser');

        $error = '';

        //S3 BUCKET ACCESS START
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
        //S3 BUCKET ACCESS START

        if ($_FILES['edu_certificate_higher_secondary']['name'] != '') {

            //Configuring Main Image Start
            $job['upload_path'] = $this->config->item('job_edu_main_upload_path');
            $job['allowed_types'] = $this->config->item('job_edu_main_allowed_types');
            $this->upload->initialize($job);

            if ($this->upload->do_upload('edu_certificate_higher_secondary')) {

                $imgdata = $this->upload->data();
                $main_image_size = $_FILES['edu_certificate_higher_secondary']['size'];

                if ($main_image_size > '1000000') {
                    $quality = "50%";
                } elseif ($main_image_size > '50000' && $main_image_size < '1000000') {
                    $quality = "55%";
                } elseif ($main_image_size > '5000' && $main_image_size < '50000') {
                    $quality = "60%";
                } elseif ($main_image_size > '100' && $main_image_size < '5000') {
                    $quality = "65%";
                } elseif ($main_image_size > '1' && $main_image_size < '100') {
                    $quality = "70%";
                } else {
                    $quality = "100%";
                }

                /* RESIZE */

                $job['image_library'] = 'gd2';
                $job['source_image'] = $this->config->item('job_edu_main_upload_path') . $imgdata['file_name'];
                $job['new_image'] = $this->config->item('job_edu_main_upload_path') . $imgdata['file_name'];
                $job['quality'] = $quality;
                $instanse10 = "image10";
                $this->load->library('image_lib', $job, $instanse10);
                $this->$instanse10->watermark();
                /* RESIZE */

                //S3 BUCKET STORE MAIN IMAGE START
                $main_image = $job['new_image'];
                $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);
                //S3 BUCKET STORE MAIN IMAGE END
            }
            //Configuring Main Image End
            //Configuring Thumbnail Start
            $job_thumb['image_library'] = 'gd2';
            $job_thumb['source_image'] = $this->config->item('job_edu_main_upload_path') . $imgdata['file_name'];
            $job_thumb['new_image'] = $this->config->item('job_edu_thumb_upload_path') . $imgdata['file_name'];
            $job_thumb['create_thumb'] = TRUE;
            $job_thumb['maintain_ratio'] = TRUE;
            $job_thumb['thumb_marker'] = '';
            $job_thumb['width'] = $this->config->item('job_edu_thumb_width');
            $job_thumb['height'] = 2;
            $job_thumb['master_dim'] = 'width';
            $job_thumb['quality'] = "100%";
            $job_thumb['x_axis'] = '0';
            $job_thumb['y_axis'] = '0';
            //Loading Image Library

            $instanse = "image";
            $this->load->library('image_lib', $job_thumb, $instanse);
            $dataimage = $imgdata['file_name'];

            //Creating Thumbnail
            $this->$instanse->resize();
            $thumberror = $this->$instanse->display_errors();
            $thumberror = '';
            //Configuring Thumbnail End
            //S3 BUCKET STORE THUMB IMAGE START
            $thumb_image = $job_thumb['new_image'];
            $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);
            //S3 BUCKET STORE THUMB IMAGE END

            $main_file = $this->config->item('job_edu_main_upload_path') . $imgdata['file_name'];
            $thumb_file = $this->config->item('job_edu_thumb_upload_path') . $imgdata['file_name'];
        }


        if ($_SERVER['HTTP_HOST'] != "localhost") {
            if (isset($main_file)) {
                unlink($main_file);
            }
            if (isset($thumb_file)) {
                unlink($thumb_file);
            }
        }

        $contition_array = array('user_id' => $userid);
        $job_reg_data = $this->common->select_data_by_condition('job_add_edu', $contition_array, $data = 'edu_certificate_higher_secondary', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $job_reg_prev_image = $job_reg_data[0]['edu_certificate_higher_secondary'];

        $image_hidden_higher_secondary = $this->input->post('image_hidden_higher_secondary');
        $edu_certificate_higher_secondary = $_FILES['edu_certificate_higher_secondary']['name'];


        if ($job_reg_prev_image != '') {
            $job_image_main_path = $this->config->item('job_edu_main_upload_path');
            $job_bg_full_image = $job_image_main_path . $job_reg_prev_image;
            if (isset($job_bg_full_image)) {
                //delete image from folder when user change image start
                if ($image_hidden_higher_secondary == $job_reg_prev_image && $edu_certificate_higher_secondary != "") {

                    unlink($job_bg_full_image);
                }
                //delete image from folder when user change image End
            }


            $job_image_thumb_path = $this->config->item('job_edu_thumb_upload_path');
            $job_bg_thumb_image = $job_image_thumb_path . $job_reg_prev_image;
            if (isset($job_bg_thumb_image)) {
                //delete image from folder when user change image Start
                if ($image_hidden_higher_secondary == $job_reg_prev_image && $edu_certificate_higher_secondary != "") {
                    unlink($job_bg_thumb_image);
                }
                //delete image from folder when user change image End
            }
        }

        $job_certificate = $imgdata['file_name'];
        $contition_array = array('user_id' => $userid);
        $userdata = $this->common->select_data_by_condition('job_add_edu', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userdata[0]['total'] != 0) {

            $edu_certificate_higher_secondary = $_FILES['edu_certificate_higher_secondary']['name'];

            if ($edu_certificate_higher_secondary == "") {
                $data = array(
                    'edu_certificate_higher_secondary' => str_replace(' ', '_', $this->input->post('image_hidden_higher_secondary'))
                );
            } else {
                $data = array(
                    'edu_certificate_higher_secondary' => str_replace(' ', '_', $job_certificate)
                );
            }

            $updatedata = $this->common->update_data($data, 'job_add_edu', 'user_id', $userid);

            $data = array(
                'user_id' => $userid,
                'board_higher_secondary' => $this->input->post('board_higher_secondary'),
                'stream_higher_secondary' => $this->input->post('stream_higher_secondary'),
                'school_higher_secondary' => $this->input->post('school_higher_secondary'),
                'percentage_higher_secondary' => $this->input->post('percentage_higher_secondary'),
                'pass_year_higher_secondary' => $this->input->post('pass_year_higher_secondary')
            );


            $updatedata = $this->common->update_data($data, 'job_add_edu', 'user_id', $userid);


            if ($updatedata) {
                redirect('job/qualification/graduation');
            } else {

                redirect('job/qualification', refresh);
            }
        } else {
            $data = array(
                'user_id' => $userid,
                'board_higher_secondary' => $this->input->post('board_higher_secondary'),
                'stream_higher_secondary' => $this->input->post('stream_higher_secondary'),
                'school_higher_secondary' => $this->input->post('school_higher_secondary'),
                'percentage_higher_secondary' => $this->input->post('percentage_higher_secondary'),
                'pass_year_higher_secondary' => $this->input->post('pass_year_higher_secondary'),
                'edu_certificate_higher_secondary' => str_replace(' ', '_', $job_certificate),
                'status' => '1'
            );

            $insert_id = $this->common->insert_data_getid($data, 'job_add_edu');

            if ($insert_id) {
                redirect('job/qualification/graduation');
            } else {
                redirect('job/qualification', refresh);
            }
        }
    }

//Insert Higher Secondary Education Data End
//Insert Degree Education Data start
    public function job_education_insert() {

        $this->job_deactive_profile();

        $userid = $this->session->userdata('aileenuser');

        if ($this->input->post('previous')) {
            redirect('job/job_address_update', refresh);
        }

//Click on Add_More_Education Process start
        if ($this->input->post('add_edu')) {


            $contition_array = array('user_id' => $userid);
            $jobdata = $this->data['jobdata'] = $this->common->select_data_by_condition('job_graduation', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $count = $jobdata[0]['total'];

            if ($count != 5) {

                redirect('job/job_add_education', refresh);
            } else {
                echo "<script>alert('You Can only add 5 Education field');</script>";
                redirect('job/qualification', refresh);
            }
        }
//Click on Add_More_Education Process End
        //Add Multiple field into database start   
        $userdata[] = $_POST;
        $count1 = count($userdata[0]['degree']);
        // Multiple Image insert code start

        $config = array(
            'upload_path' => $this->config->item('job_edu_main_upload_path'),
            'allowed_types' => $this->config->item('job_edu_main_allowed_types'),
            'max_size' => $this->config->item('job_edu_main_max_size')
        );
        $images = array();
        $this->load->library('upload');

        $files = $_FILES;
        $count = count($_FILES['certificate']['name']);

        //S3 BUCKET ACCESS START
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
        //S3 BUCKET ACCESS START

        for ($i = 0; $i < $count; $i++) {

            $_FILES['certificate']['name'] = $files['certificate']['name'][$i];
            $_FILES['certificate']['type'] = $files['certificate']['type'][$i];
            $_FILES['certificate']['tmp_name'] = $files['certificate']['tmp_name'][$i];
            $_FILES['certificate']['error'] = $files['certificate']['error'][$i];
            $_FILES['certificate']['size'] = $files['certificate']['size'][$i];

            $fileName = $_FILES['certificate']['name'];
            $images[] = $fileName;
            $config['file_name'] = $fileName;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('certificate')) {

                $response['result'][] = $this->upload->data();

                $main_image_size = $_FILES['certificate']['size'];

                if ($main_image_size > '1000000') {
                    $quality = "50%";
                } elseif ($main_image_size > '50000' && $main_image_size < '1000000') {
                    $quality = "55%";
                } elseif ($main_image_size > '5000' && $main_image_size < '50000') {
                    $quality = "60%";
                } elseif ($main_image_size > '100' && $main_image_size < '5000') {
                    $quality = "65%";
                } elseif ($main_image_size > '1' && $main_image_size < '100') {
                    $quality = "70%";
                } else {
                    $quality = "100%";
                }

                /* RESIZE */

                $job[$i]['image_library'] = 'gd2';
                $job[$i]['source_image'] = $this->config->item('job_edu_main_upload_path') . $response['result'][$i]['file_name'];
                $job[$i]['new_image'] = $this->config->item('job_edu_main_upload_path') . $response['result'][$i]['file_name'];
                $job[$i]['quality'] = $quality;
                $instanse10 = "image10_$i";
                $this->load->library('image_lib', $job[$i], $instanse10);
                $this->$instanse10->watermark();

                /* RESIZE */

                //S3 BUCKET STORE MAIN IMAGE START
                $main_image = $job[$i]['new_image'];
                $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);
                //S3 BUCKET STORE MAIN IMAGE END

                $job_profile_post_thumb[$i]['image_library'] = 'gd2';
                $job_profile_post_thumb[$i]['source_image'] = $this->config->item('job_edu_main_upload_path') . $response['result'][$i]['file_name'];
                $job_profile_post_thumb[$i]['new_image'] = $this->config->item('job_edu_thumb_upload_path') . $response['result'][$i]['file_name'];
                $job_profile_post_thumb[$i]['create_thumb'] = TRUE;
                $job_profile_post_thumb[$i]['maintain_ratio'] = TRUE;
                $job_profile_post_thumb[$i]['thumb_marker'] = '';
                $job_profile_post_thumb[$i]['width'] = $this->config->item('job_edu_thumb_width');
                $job_profile_post_thumb[$i]['height'] = 2;
                $job_profile_post_thumb[$i]['master_dim'] = 'width';
                $job_profile_post_thumb[$i]['quality'] = "100%";
                $job_profile_post_thumb[$i]['x_axis'] = '0';
                $job_profile_post_thumb[$i]['y_axis'] = '0';
                $instanse = "image_$i";
                //Loading Image Library
                $this->load->library('image_lib', $job_profile_post_thumb[$i], $instanse);
                $dataimage = $response['result'][$i]['file_name'];
                //Creating Thumbnail
                $this->$instanse->resize();
                $response['error'][] = $thumberror = $this->$instanse->display_errors();
                $return['data'][] = $imgdata;
                $return['status'] = "success";
                $return['msg'] = sprintf($this->lang->line('success_item_added'), "Image", "uploaded");

                //S3 BUCKET STORE THUMB IMAGE START
                $thumb_image = $job_profile_post_thumb[$i]['new_image'];
                $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);
                //S3 BUCKET STORE THUMB IMAGE END

                $main_file = $this->config->item('job_edu_main_upload_path') . $response['result'][$i]['file_name'];
                $thumb_file = $this->config->item('job_edu_thumb_upload_path') . $response['result'][$i]['file_name'];


                if ($_SERVER['HTTP_HOST'] != "localhost") {
                    if (isset($main_file)) {
                        unlink($main_file);
                    }
                    if (isset($thumb_file)) {
                        unlink($thumb_file);
                    }
                }

                $contition_array = array('user_id' => $userid);
                $job_reg_data = $this->common->select_data_by_condition('job_graduation', $contition_array, $data = 'count(*) as total,edu_certificate,job_graduation_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                $count_data = $job_reg_data[0]['total'];

                for ($x = 0; $x < $count_data; $x++) {
                    $job_reg_prev_image = $job_reg_data[$x]['edu_certificate'];


                    $image_hidden_degree = $this->input->post('image_hidden_degree' . $job_reg_data[$x]['job_graduation_id']);
                    $edu_certificate = $files['certificate']['name'][$x];

                    if ($job_reg_prev_image != '') {
                        $job_image_main_path = $this->config->item('job_edu_main_upload_path');
                        $job_bg_full_image = $job_image_main_path . $job_reg_prev_image;
                        if (isset($job_bg_full_image)) {
                            //delete image from folder when user change image start
                            if ($image_hidden_degree == $job_reg_prev_image && $edu_certificate != "") {

                                unlink($job_bg_full_image);
                            }
                            //delete image from folder when user change image End
                        }

                        $job_image_thumb_path = $this->config->item('job_edu_thumb_upload_path');
                        $job_bg_thumb_image = $job_image_thumb_path . $job_reg_prev_image;
                        if (isset($job_bg_thumb_image)) {
                            //delete image from folder when user change image Start
                            if ($image_hidden_degree == $job_reg_prev_image && $edu_certificate != "") {
                                unlink($job_bg_thumb_image);
                            }
                            //delete image from folder when user change image End
                        }
                    }
                }
            } else {

                $dataimage = '';
            }
        }

        // Multiple Image insert code End

        $contition_array = array('user_id' => $userid);
        $jobdata = $this->data['jobdata'] = $this->common->select_data_by_condition('job_graduation', $contition_array, $data = 'count(*) as total,job_graduation_id', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($jobdata[0]['total'] != 0) {


            //Edit Multiple field into database Start 
            for ($x = 0; $x < $count1; $x++) {

                $files[] = $_FILES;
                $edu_certificate = $files['certificate']['name'][$x];

                if ($edu_certificate == "") {

                    $edu_certificate1 = $this->input->post('image_hidden_degree' . $jobdata[$x]['job_graduation_id']);
                } else {


                    $edu_certificate1 = $edu_certificate;
                }

                $i = $x + 1;
                if ($userdata[0]['education_data'][$x] == 'old') {
                    $data = array(
                        'user_id' => $userid,
                        'degree' => $userdata[0]['degree'][$x],
                        'stream' => $userdata[0]['stream'][$x],
                        'university' => $userdata[0]['university'][$x],
                        'college' => $userdata[0]['college'][$x],
                        'grade' => $userdata[0]['grade'][$x],
                        'percentage' => $userdata[0]['percentage'][$x],
                        'pass_year' => $userdata[0]['pass_year'][$x],
                        'edu_certificate' => str_replace(' ', '_', $edu_certificate1),
                        'degree_count' => $i
                    );

                    $updatedata1 = $this->common->update_data($data, 'job_graduation', 'job_graduation_id', $jobdata[$x]['job_graduation_id']);
                } else {
                    $data = array(
                        'user_id' => $userid,
                        'degree' => $userdata[0]['degree'][$x],
                        'stream' => $userdata[0]['stream'][$x],
                        'university' => $userdata[0]['university'][$x],
                        'college' => $userdata[0]['college'][$x],
                        'grade' => $userdata[0]['grade'][$x],
                        'percentage' => $userdata[0]['percentage'][$x],
                        'pass_year' => $userdata[0]['pass_year'][$x],
                        'edu_certificate' => str_replace(' ', '_', $edu_certificate),
                        'degree_count' => $i
                    );
                    $insert_id = $this->common->insert_data_getid($data, 'job_graduation');
                }
            }
            //Edit Multiple field into database End 
        } else {

            //Add Multiple field into database Start 
            for ($x = 0; $x < $count1; $x++) {

                $i = $x + 1;
                $edu_certificate = $files['certificate']['name'][$x];

                $data = array(
                    'user_id' => $userid,
                    'degree' => $userdata[0]['degree'][$x],
                    'stream' => $userdata[0]['stream'][$x],
                    'university' => $userdata[0]['university'][$x],
                    'college' => $userdata[0]['college'][$x],
                    'grade' => $userdata[0]['grade'][$x],
                    'percentage' => $userdata[0]['percentage'][$x],
                    'pass_year' => $userdata[0]['pass_year'][$x],
                    'edu_certificate' => str_replace(' ', '_', $edu_certificate),
                    'degree_count' => $i
                );
                $insert_id = $this->common->insert_data_getid($data, 'job_graduation');
                $i++;
            }

            //Add Multiple field into database End 
        }

        if ($insert_id || $updatedata1) {

            redirect('job/project');
        } else {

            redirect('job/qualification', 'refresh');
        }
    }

//End first time insert and update
//Insert Degree Education Data End
//job seeker EDUCATION controller end
//job seeker Project And Training / Internship controller start
    public function job_project_update() {

        $this->job_apply_check();
        $this->job_deactive_profile();

        $userid = $this->session->userdata('aileenuser');

        $data = 'count(*) as total,project_name,project_duration,project_description,training_as,training_duration,training_organization,job_step';
        $contition_array = array('user_id' => $userid, 'is_delete' => 0, 'status' => 1);
        $userdata = $this->common->select_data_by_condition('job_reg', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        if ($userdata[0]['total'] != 0) {
            $step = $userdata[0]['job_step'];

            if ($step == 4 || ($step >= 1 && $step <= 4) || $step > 4) {
                $this->data['project_name1'] = $userdata[0]['project_name'];
                $this->data['project_duration1'] = $userdata[0]['project_duration'];
                $this->data['project_description1'] = $userdata[0]['project_description'];
                $this->data['training_as1'] = $userdata[0]['training_as'];
                $this->data['training_duration1'] = $userdata[0]['training_duration'];
                $this->data['training_organization1'] = $userdata[0]['training_organization'];
            }
        }

        $this->data['title'] = 'Project And Training Internship  |  Edit Profile - Job Profile - Aileensoul';

        $this->load->view('job/job_project', $this->data);
    }

    public function job_project_insert() {

        $this->job_deactive_profile();

        $userid = $this->session->userdata('aileenuser');

        if ($this->input->post('previous')) {
            redirect('job/qualification', refresh);
        }
        //if ($this->input->post('next')) { 

        $data = array(
            'project_name' => trim($this->input->post('project_name')),
            'project_duration' => $this->input->post('project_duration'),
            'project_description' => trim($this->input->post('project_description')),
            'training_as' => trim($this->input->post('training_as')),
            'training_duration' => $this->input->post('training_duration'),
            'training_organization' => trim($this->input->post('training_organization')),
            'modified_date' => date('Y-m-d h:i:s', time())
        );


        $updatedata = $this->common->update_data($data, 'job_reg', 'user_id', $userid);


        if ($updatedata) {
            redirect('job/work-area');
        } else {

            redirect('job/project', 'refresh');
        }
        //}
    }

//job seeker Project And Training / Internship controller end 
//job seeker skill controller start
    public function job_skill_update() {

        $this->job_apply_check();
        $this->job_deactive_profile();

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('is_delete' => '0', 'status' => '1', 'industry_name !=' => "Others");
        $search_condition = "((is_other = '1' AND user_id = $userid) OR (is_other = '0'))";
        $university_data = $this->data['industry'] = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = 'industry_id,industry_name', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('is_delete' => '0', 'industry_name' => "Others");
        $search_condition = "((status = '1'))";
        $this->data['other_industry'] = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = 'industry_id,industry_name', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('is_delete' => '0', 'is_other' => '0', 'industry_name !=' => "Others");
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";


        $contition_array = array('is_delete' => '0', 'status' => '1', 'industry_name' => "Others");
        $this->data['industry_otherdata'] = $this->common->select_data_by_condition('job_industry', $contition_array, $data = '*', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('status' => '1', 'is_delete' => '0', 'user_id' => $userid);
        $post = $this->data['postdata'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_id,work_job_title,work_job_industry,work_job_city,keyskill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('title_id' => $post[0]['work_job_title']);
        $jobtitle = $this->common->select_data_by_condition('job_title', $contition_array, $data = 'name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->data['work_title'] = $jobtitle[0]['name'];

        //Job title data fetch start
        $contition_array = array('status' => 'publish');
        $jobtitle = $this->common->select_data_by_condition('job_title', $contition_array, $data = 'name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = 'name');

        foreach ($jobtitle as $key1 => $value1) {
            foreach ($value1 as $ke1 => $val1) {
                $title[] = $val1;
            }
        }
        foreach ($title as $key => $value) {
            $result1[$key]['label'] = $value;
            $result1[$key]['value'] = $value;
        }
        $this->data['jobtitle'] = array_values($result1);
        //Job title data fetch ENd

        $this->data['work_industry'] = $post[0]['work_job_industry'];
        $work_skill = explode(',', $post[0]['keyskill']);
        $work_city = explode(',', $post[0]['work_job_city']);

        foreach ($work_skill as $skill) {
            $contition_array = array('skill_id' => $skill);
            $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
            $detailes[] = $skilldata[0]['skill'];
        }

        $this->data['work_skill'] = implode(',', $detailes);

        foreach ($work_city as $city) {
            $contition_array = array('city_id' => $city);
            $citydata = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_id,city_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
            if ($citydata) {
                $cities[] = $citydata[0]['city_name'];
            }
        }

        $this->data['work_skill'] = implode(',', $detailes);
        $this->data['work_city'] = implode(',', $cities);

        $this->data['title'] = 'Work Area | Edit Profile - Job Profile' . TITLEPOSTFIX;

        $this->load->view('job/job_skill', $this->data);
    }

    public function job_skill_insert() {

        $this->job_deactive_profile();

        $userid = $this->session->userdata('aileenuser');

        $industry = $this->input->post('industry');

        $jobtitle = $this->input->post('job_title');

        $skills = $this->input->post('skills');
        $skills = explode(',', $skills);

        $cities = $this->input->post('cities');
        $cities = explode(',', $cities);

        if ($this->input->post('previous')) {
            redirect('job/project', refresh);
        }
        // if ($this->input->post('next')) {
        // job title start   
        if ($jobtitle != " ") {
            $contition_array = array('name' => $jobtitle);
            $jobdata = $this->common->select_data_by_condition('job_title', $contition_array, $data = 'title_id,name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
            if ($jobdata) {
                $jobtitle = $jobdata[0]['title_id'];
            } else {
                $forslug = $this->input->post('job_title');
                $data = array(
                    'name' => ucfirst($this->input->post('job_title')),
                    'slug' => $this->common->clean($forslug),
                    'status' => 'draft',
                );
                $jobtitle = $this->common->insert_data_getid($data, 'job_title');
            }
        }

        // skills  start   
        if (count($skills) > 0) {

            foreach ($skills as $ski) {
                $contition_array = array('skill' => trim($ski), 'type' => '1');
                $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');

                if (!$skilldata) {

                    $contition_array = array('skill' => trim($ski), 'type' => '4');
                    $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                }
                if ($skilldata) {

                    $skill[] = $skilldata[0]['skill_id'];
                } else {

                    $data = array(
                        'skill' => $ski,
                        'status' => '1',
                        'type' => '4',
                        'user_id' => $userid,
                    );
                    $skill[] = $this->common->insert_data_getid($data, 'skill');
                }
            }

            $skills = implode(',', $skill);
        }

        // city  start   

        if (count($cities) > 0) {

            foreach ($cities as $cit) {
                $contition_array = array('city_name' => $cit);
                $citydata = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_id,city_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                if ($citydata) {
                    $city[] = $citydata[0]['city_id'];
                } else {
                    $data = array(
                        'city_name' => $cit,
                        'status' => '1',
                    );
                    $city[] = $this->common->insert_data_getid($data, 'cities');
                }
            }

            $city = implode(',', $city);
        }

        //update data in table start

        $data = array(
            'keyskill' => $skills,
            'work_job_title' => $jobtitle,
            'work_job_industry' => $this->input->post('industry'),
            'work_job_city' => $city,
        );

        $updatedata = $this->common->update_data($data, 'job_reg', 'user_id', $userid);

        if ($updatedata) {
            redirect('job/work-experience');
        } else {
            redirect('job/work-area', 'refresh');
        }
        //}
    }

//job seeker skill controller end
//job seeker WORK EXPERIENCE controller start
    public function job_work_exp_update() {

        $this->job_apply_check();
        $this->job_deactive_profile();

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'is_delete' => 0, 'status' => 1);


        $userdata = $this->data['userdata'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'count(*) as total,job_step,experience,exp_m,exp_y', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userdata[0]['total'] != 0) {
            $step = $userdata[0]['job_step'];

            if ($step == 7 || ($step >= 1 && $step <= 7) || $step > 7) {

                $data = 'work_id,experience_year,experience_month,jobtitle,companyname,companyemail,companyphn,work_certificate';
                $contition_array = array('user_id' => $userid, 'experience !=' => 'Fresher', 'status' => 1);
                $workdata = $this->data['workdata'] = $this->common->select_data_by_condition('job_add_workexp', $contition_array, $data, $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            }
        }

        $this->data['title'] = 'Work Experiance | Edit Profile - Job Profile' . TITLEPOSTFIX;

        $this->load->view('job/job_work_exp', $this->data);
    }

    public function job_work_exp_insert() {

        $this->job_deactive_profile();

        $userid = $this->session->userdata('aileenuser');

        $userdata[] = $_POST;
        $count1 = count($userdata[0]['jobtitle']);

        if ($this->input->post('previous')) {
            redirect('job/work-area', refresh);
        }
        $post_data = $this->input->post();


//Click on Add_More_WorkExp Process End
        //if ($this->input->post('next')) {

        $exp = $this->input->post('radio');


        if ($exp == "Fresher") {

            $exp = $this->input->post('radio');
            $exp_year = '';
            $exp_month = '';
            $job_title = '';
            $companyname = '';
            $companyemail = '';
            $companyphn = '';
            $certificate1 = '';

            //upload work certificate process end


            $contition_array = array('user_id' => $userid, 'status' => '1');
            $jobdata = $this->data['jobdata'] = $this->common->select_data_by_condition('job_add_workexp', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            //update data at job_add_workexp for fresher table start
            if ($jobdata[0]['total'] != 0) {

                $data1 = array(
                    'experience' => $exp,
                    'experience_year' => '',
                    'experience_month' => '',
                    'jobtitle' => '',
                    'companyname' => '',
                    'companyemail' => '',
                    'companyphn' => '',
                    'work_certificate' => '',
                    'status' => '1'
                );


                $updatedata1 = $this->common->update_data($data1, 'job_add_workexp', 'user_id', $userid);

                $data = array(
                    'experience' => $exp,
                    'modified_date' => date('Y-m-d h:i:s', time())
                );

                $updatedata = $this->common->update_data($data, 'job_reg', 'user_id', $userid);
            }
            //update data at job_add_workexp for fresher table end
            //Insert data at first time job_add_workexp for fresher table start        
            else {

                $data1 = array(
                    'experience' => $exp,
                    'user_id' => $userid,
                    'status' => '1'
                );

                $insertid = $this->common->insert_data_getid($data1, 'job_add_workexp');

                $data = array(
                    'experience' => $exp,
                    'modified_date' => date('Y-m-d h:i:s', time())
                );


                $updatedata = $this->common->update_data($data, 'job_reg', 'user_id', $userid);
            }
            //Insert data at first time job_add_workexp for fresher table end


            if ($updatedata && $updatedata1 || $updatedata && $insertid) {
                redirect('job/home');
            } else {
                redirect('job/work-experience', 'refresh');
            }
        } else {

            $exp = 'Experience';


// Multiple Image insert code start
            $config = array(
                'upload_path' => $this->config->item('job_work_main_upload_path'),
                'allowed_types' => $this->config->item('job_work_main_allowed_types'),
                'max_size' => $this->config->item('job_work_main_max_size')
            );

            $images = array();
            $this->load->library('upload');

            $files = $_FILES;
            $count = count($_FILES['certificate']['name']);

            //S3 BUCKET ACCESS START
            $s3 = new S3(awsAccessKey, awsSecretKey);
            $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
            //S3 BUCKET ACCESS START


            for ($i = 0; $i < $count; $i++) {

                $_FILES['certificate']['name'] = $files['certificate']['name'][$i];
                $_FILES['certificate']['type'] = $files['certificate']['type'][$i];
                $_FILES['certificate']['tmp_name'] = $files['certificate']['tmp_name'][$i];
                $_FILES['certificate']['error'] = $files['certificate']['error'][$i];
                $_FILES['certificate']['size'] = $files['certificate']['size'][$i];

                $fileName = $_FILES['certificate']['name'];
                $images[] = $fileName;
                $config['file_name'] = $fileName;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('certificate')) {
                    $response['result'][] = $this->upload->data();


                    $main_image_size = $_FILES['certificate']['size'];

                    if ($main_image_size > '1000000') {
                        $quality = "50%";
                    } elseif ($main_image_size > '50000' && $main_image_size < '1000000') {
                        $quality = "55%";
                    } elseif ($main_image_size > '5000' && $main_image_size < '50000') {
                        $quality = "60%";
                    } elseif ($main_image_size > '100' && $main_image_size < '5000') {
                        $quality = "65%";
                    } elseif ($main_image_size > '1' && $main_image_size < '100') {
                        $quality = "70%";
                    } else {
                        $quality = "100%";
                    }

                    /* RESIZE */

                    $job[$i]['image_library'] = 'gd2';
                    $job[$i]['source_image'] = $this->config->item('job_work_main_upload_path') . $response['result'][$i]['file_name'];
                    $job[$i]['new_image'] = $this->config->item('job_work_main_upload_path') . $response['result'][$i]['file_name'];
                    $job[$i]['quality'] = $quality;
                    $instanse10 = "image10_$i";
                    $this->load->library('image_lib', $job[$i], $instanse10);
                    $this->$instanse10->watermark();

                    /* RESIZE */

                    //S3 BUCKET STORE MAIN IMAGE START
                    $main_image = $job[$i]['new_image'];
                    $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);
                    //S3 BUCKET STORE MAIN IMAGE END

                    $job_profile_post_thumb[$i]['image_library'] = 'gd2';
                    $job_profile_post_thumb[$i]['source_image'] = $this->config->item('job_work_main_upload_path') . $response['result'][$i]['file_name'];
                    $job_profile_post_thumb[$i]['new_image'] = $this->config->item('job_work_thumb_upload_path') . $response['result'][$i]['file_name'];
                    $job_profile_post_thumb[$i]['create_thumb'] = TRUE;
                    $job_profile_post_thumb[$i]['maintain_ratio'] = TRUE;
                    $job_profile_post_thumb[$i]['thumb_marker'] = '';
                    $job_profile_post_thumb[$i]['width'] = $this->config->item('job_work_thumb_width');
                    $job_profile_post_thumb[$i]['height'] = 2;
                    $job_profile_post_thumb[$i]['master_dim'] = 'width';
                    $job_profile_post_thumb[$i]['quality'] = "100%";
                    $job_profile_post_thumb[$i]['x_axis'] = '0';
                    $job_profile_post_thumb[$i]['y_axis'] = '0';
                    $instanse = "image_$i";
                    //Loading Image Library
                    $this->load->library('image_lib', $job_profile_post_thumb[$i], $instanse);
                    $dataimage = $response['result'][$i]['file_name'];
                    //Creating Thumbnail
                    $this->$instanse->resize();
                    $response['error'][] = $thumberror = $this->$instanse->display_errors();
                    $return['data'][] = $imgdata;
                    $return['status'] = "success";
                    $return['msg'] = sprintf($this->lang->line('success_item_added'), "Image", "uploaded");

                    //S3 BUCKET STORE THUMB IMAGE START
                    $thumb_image = $job_profile_post_thumb[$i]['new_image'];
                    $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);
                    //S3 BUCKET STORE THUMB IMAGE END

                    $main_file = $this->config->item('job_work_main_upload_path') . $response['result'][$i]['file_name'];

                    $thumb_file = $this->config->item('job_work_thumb_upload_path') . $response['result'][$i]['file_name'];

                    if ($_SERVER['HTTP_HOST'] != "localhost") {
                        if (isset($main_file)) {
                            unlink($main_file);
                        }
                        if (isset($thumb_file)) {
                            unlink($thumb_file);
                        }
                    }

                    $contition_array = array('user_id' => $userid);
                    $job_reg_data = $this->common->select_data_by_condition('job_add_workexp', $contition_array, $data = 'work_certificate', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $count_data = count($job_reg_data);

                    for ($x = 0; $x < $count_data; $x++) {

                        $job_reg_prev_image = $job_reg_data[$x]['work_certificate'];


                        $image_hidden_certificate = $userdata[0]['image_hidden_certificate'][$x];
                        $work_certificate = $files['certificate']['name'][$x];


                        if ($job_reg_prev_image != '') {

                            $job_image_main_path = $this->config->item('job_work_main_upload_path');
                            $job_bg_full_image = $job_image_main_path . $job_reg_prev_image;
                            if (isset($job_bg_full_image)) {
                                if ($image_hidden_certificate == $job_reg_prev_image && $work_certificate != "") {
                                    unlink($job_bg_full_image);
                                }
                            }

                            $job_image_thumb_path = $this->config->item('job_work_thumb_upload_path');
                            $job_bg_thumb_image = $job_image_thumb_path . $job_reg_prev_image;
                            if (isset($job_bg_thumb_image)) {
                                if ($image_hidden_certificate == $job_reg_prev_image && $work_certificate != "") {
                                    unlink($job_bg_thumb_image);
                                }
                            }
                        }
                    }//for loop end
                } else {

                    $dataimage = '';
                }
            }
            // Multiple Image insert code End

            $contition_array = array('user_id' => $userid, 'status' => 1);
            $jobdata = $this->data['jobdata'] = $this->common->select_data_by_condition('job_add_workexp', $contition_array, $data = 'count(*) as total,work_id', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            //update data at job_add_workexp for Experience table start
            if ($jobdata[0]['total'] != 0) {

                //Edit Multiple field into database Start 
                for ($x = 0; $x < $count1; $x++) {

                    $exp_data = $userdata[0]['exp_data'][$x];
                    if ($exp_data == 'old') {

                        $files[] = $_FILES;

                        $work_certificate = $files['certificate']['name'][$x];


                        if ($work_certificate == "") {

                            $work_certificate1 = $userdata[0]['image_hidden_certificate'][$x];
                        } else {

                            $work_certificate1 = $work_certificate;
                        }


                        $data = array(
                            'user_id' => $userid,
                            'experience' => $exp,
                            'experience_year' => $userdata[0]['experience_year'][$x],
                            'experience_month' => $userdata[0]['experience_month'][$x],
                            'jobtitle' => $userdata[0]['jobtitle'][$x],
                            'companyname' => $userdata[0]['companyname'][$x],
                            'companyemail' => $userdata[0]['companyemail'][$x],
                            'companyphn' => $userdata[0]['companyphn'][$x],
                            'work_certificate' => str_replace(' ', '_', $work_certificate1),
                        );

                        $updatedata1 = $this->common->update_data($data, 'job_add_workexp', 'work_id', $jobdata[$x]['work_id']);
                    }


                    //update data at job_add_workexp for Experience table End
                    //Insert data at job_add_workexp for Experience table start
                    else {

                        $files[] = $_FILES;

                        $work_certificate = $files['certificate']['name'][$x];

                        $data = array(
                            'user_id' => $userid,
                            'experience' => $exp,
                            'experience_year' => $userdata[0]['experience_year'][$x],
                            'experience_month' => $userdata[0]['experience_month'][$x],
                            'jobtitle' => $userdata[0]['jobtitle'][$x],
                            'companyname' => $userdata[0]['companyname'][$x],
                            'companyemail' => $userdata[0]['companyemail'][$x],
                            'companyphn' => $userdata[0]['companyphn'][$x],
                            'work_certificate' => str_replace(' ', '_', $work_certificate),
                            'status' => '1'
                        );

                        $insert_id = $this->common->insert_data_getid($data, 'job_add_workexp');
                    }
                }
                //Edit Multiple field into database End 
                // for deleete fresher data when candidate is experience start
                $contition_array = array('user_id' => $userid, 'experience' => 'Fresher', 'status' => '1');
                $jobdata = $this->common->select_data_by_condition('job_add_workexp', $contition_array, $data = 'count(*) as total,work_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $countdata = $jobdata[0]['total'];

                for ($x = 0; $x < $countdata; $x++) {


                    $delete_data = $this->common->delete_data('job_add_workexp', 'work_id', $jobdata[$x]['work_id']);
                }
                // for deleete fresher data when candidate is experience ENd
            }

//Insert data at job_add_workexp for Experience table End
//when insert and update data both same time Insert data at job_add_workexp for Experience table start
            else {

                //Add Multiple field into database Start 
                for ($x = 0; $x < $count1; $x++) {

                    $files[] = $_FILES;
                    $work_certificate = $files['certificate']['name'][$x];

                    $data = array(
                        'user_id' => $userid,
                        'experience' => $exp,
                        'experience_year' => $userdata[0]['experience_year'][$x],
                        'experience_month' => $userdata[0]['experience_month'][$x],
                        'jobtitle' => $userdata[0]['jobtitle'][$x],
                        'companyname' => $userdata[0]['companyname'][$x],
                        'companyemail' => $userdata[0]['companyemail'][$x],
                        'companyphn' => $userdata[0]['companyphn'][$x],
                        'work_certificate' => str_replace(' ', '_', $work_certificate),
                        'status' => '1'
                    );

                    $insert_id = $this->common->insert_data_getid($data, 'job_add_workexp');
                    $i++;
                }

                //Add Multiple field into database End 
                // for deleete fresher data when candidate is experience start
                $contition_array = array('user_id' => $userid, 'experience' => 'Fresher', 'status' => '1');
                $jobdata = $this->common->select_data_by_condition('job_add_workexp', $contition_array, $data = 'count(*) as total,work_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $countdata = $jobdata[0]['total'];

                for ($x = 0; $x < $countdata; $x++) {


                    $delete_data = $this->common->delete_data('job_add_workexp', 'work_id', $jobdata[$x]['work_id']);
                }
                // for deleete fresher data when candidate is experience ENd
            }
//when insert and update data both same time Insert data at job_add_workexp for Experience table End
            //Update only one field into database start
            $data = array(
                'experience' => $exp,
                'modified_date' => date('Y-m-d h:i:s', time())
            );

            $updatedata = $this->common->update_data($data, 'job_reg', 'user_id', $userid);
            //Update only one field into database End



            if ($insert_id && $updatedata || $updatedata1 && $updatedata) {
                redirect('job/home');
            } else {
                redirect('job/work-experience', 'refresh');
            }
        }
        //}
    }

    //End first time insert and update
//job seeker WORK EXPERIENCE controller end
    //job seeker PRINTDATA controller Start
    public function job_printpreview($slug = "") {

        $this->job_deactive_profile();

        $userid = $this->session->userdata('aileenuser');

        $id = $this->db->get_where('job_reg', array('slug' => $slug, 'is_delete' => '0', 'status' => '1'))->row()->user_id;

        $slug_user = $this->db->get_where('job_reg', array('slug' => $slug, 'user_id !=' => $userid, 'is_delete' => '0', 'status' => '1'))->row()->slug;

        $this->data['get_url'] = $slug;

        if ($slug != $slug_user || $slug == '') {

            if ($slug == '') {
                $this->job_apply_check();
            }
            $this->progressbar();

            //for getting data job_reg table
            $contition_array = array('job_reg.user_id' => $userid, 'job_reg.is_delete' => '0', 'job_reg.status' => '1');

            $data = '*';

            $job_details = $this->data['job'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str, $groupby);

            //for getting data job_add_workexp table
            $contition_array = array('user_id' => $userid, 'status' => '1');

            $data = '*';

            $this->data['job_work'] = $this->common->select_data_by_condition('job_add_workexp', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str, $groupby);

            //for getting other skill data
            $contition_array = array('user_id' => $userid, 'type' => '4', 'status' => '1');

            $this->data['other_skill'] = $this->common->select_data_by_condition('skill', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {

            //for getting data job_reg table
            $contition_array = array('job_reg.user_id' => $id, 'job_reg.is_delete' => '0', 'job_reg.status' => '1');

            $data = '*';

            $job_details = $this->data['job'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str, $groupby);


            $contition_array = array('user_id' => $id, 'status' => '1');
            $this->data['job_add_edu'] = $this->common->select_data_by_condition('job_add_edu', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('user_id' => $id);

            $data = '*';

            $this->data['jobgrad'] = $this->common->select_data_by_condition('job_graduation', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str, $groupby);

            //for getting data job_add_workexp table
            $contition_array = array('user_id' => $id, 'experience' => 'Experience', 'status' => '1');

            $data = '*';

            $this->data['job_work'] = $this->common->select_data_by_condition('job_add_workexp', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str, $groupby);

            //for getting other skill data
            $contition_array = array('user_id' => $id, 'type' => '4', 'status' => '1');

            $this->data['other_skill'] = $this->common->select_data_by_condition('skill', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }
//For Counting Profile data start
//For Counting Profile data END

        $this->data['title'] = "Resume of " . $job_details[0]['fname'] . " " . $job_details[0]['lname'] . " | Details | Job Profile" . TITLEPOSTFIX;

//for deactive profile and slug not found then see page start

        $id_deactiveuser = $this->db->get_where('job_reg', array('slug' => $slug, 'is_delete' => '0', 'status' => '0'))->row()->user_id;
        $contition_array = array('user_id' => $id_deactiveuser, 'is_delete' => '0', 'status' => '0');
        $availuser = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if (($availuser[0]['total'] > 0 || count($id) == 0) && $slug != '') {
            $this->load->view('job/notavalible');
        } else {
            if ($userid) {
                $this->load->view('job/job_printpreview', $this->data);
            } else {
                $this->load->view('job/job_liveprintpreview', $this->data);
            }
        }
//for deactive profile and slug not found then see page end 
    }

    //job seeker PRINTDATA controller end
    //job seeker Job All Post Start
    public function job_all_post() {

        $this->job_apply_check();
        $this->job_deactive_profile();

        $this->progressbar();

        $this->data['title'] = 'Home | Job Profile' . TITLEPOSTFIX;
        // echo "<pre>";print_r($this->data['job_reg'][0]['progressbar']);die();
        $contition_array = array('status' => '1', 'is_delete' => '0');
        $this->data['govjob_category'] = $govjob_category = $this->common->select_data_by_condition('gov_category', $contition_array, $data = 'id,name', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->load->view('job/job_all_post', $this->data);
    }

    //job seeker Job All Post controller end
    //job seeker Apply post at all post page & save post page controller Start
    public function job_apply_post() {

        $this->job_apply_check();
        $this->job_deactive_profile();

        $id = $_POST['post_id'];
        $para = $_POST['allpost'];
        $notid = $_POST['userid'];



        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('post_id' => $id, 'user_id' => $userid, 'is_delete' => '0');
        $userdata = $this->common->select_data_by_condition('job_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $app_id = $userdata[0]['app_id'];

        if ($userdata) {

            $contition_array = array('job_delete' => '1');
            $jobdata = $this->common->select_data_by_condition('job_apply', $contition_array, $data = 'app_id', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $data = array(
                'job_delete' => '0',
                'job_save' => '3',
                'modify_date' => date('Y-m-d h:i:s', time()),
            );


            $updatedata = $this->common->update_data($data, 'job_apply', 'app_id', $app_id);


            // insert notification

            $data = array(
                'not_type' => '3',
                'not_from_id' => $userid,
                'not_to_id' => $notid,
                'not_read' => '2',
                'not_from' => '2',
                'not_product_id' => $app_id,
                'not_active' => '1'
            );

            $updatedata = $this->common->insert_data_getid($data, 'notification');
            // end notoification

            if ($updatedata) {

                if ($para == 'all') {
                    $applypost = 'Applied';
                }
            }
            // GET NOTIFICATION COUNT
            $not_count = $this->job_notification_count($notid);

            echo json_encode(
                    array(
                        "status" => 'Applied',
                        "notification" => array('notification_count' => $not_count, 'to_id' => $notid),
            ));
        } else {


            $data = array(
                'post_id' => $id,
                'user_id' => $userid,
                'status' => '1',
                'created_date' => date('Y-m-d h:i:s', time()),
                'modify_date' => date('Y-m-d h:i:s', time()),
                'is_delete' => '0',
                'job_delete' => '0',
                'job_save' => '3'
            );


            $insert_id = $this->common->insert_data_getid($data, 'job_apply');


            // insert notification

            $data = array(
                'not_type' => '3',
                'not_from_id' => $userid,
                'not_to_id' => $notid,
                'not_read' => '2',
                'not_from' => '2',
                'not_product_id' => $insert_id,
                'not_active' => '1',
                'not_created_date' => date('Y-m-d H:i:s')
            );

            $updatedata = $this->common->insert_data_getid($data, 'notification');
            // end notoification


            if ($insert_id) {
                $this->apply_email($notid);
                $applypost = 'Applied';
            }

            // GET NOTIFICATION COUNT
            $not_count = $this->job_notification_count($notid);

            echo json_encode(
                    array(
                        "status" => 'Applied',
                        "notification" => array('notification_count' => $not_count, 'to_id' => $notid),
            ));
        }
    }

    public function job_applied_post() {

        $this->job_apply_check();
        $this->job_deactive_profile();

        //For Counting Profile data start
        $this->progressbar();
        //For Counting Profile data End

        $jobseeker_name = $this->get_jobseeker_name($id);
        $this->data['title'] = $jobseeker_name . " | Applied Job | Job Profile" . TITLEPOSTFIX;

        $this->load->view('job/job_applied_post', $this->data);
    }

    //job seeker view all applied post controller End
//job seeker Delete all Applied & Save post controller Start
    public function job_delete_apply() {

        $this->job_deactive_profile();

        $id = $_POST['app_id'];
        $para = $_POST['para'];
        $userid = $this->session->userdata('aileenuser');

        $data = array(
            'job_delete' => '1',
            'job_save' => '3',
            'modify_date' => date('Y-m-d h:i:s', time())
        );

        $updatedata = $this->common->update_data($data, 'job_apply', 'app_id', $id);
    }

    //job seeker Delete all Applied & Save post controller End
//job seeker Save post controller Start

    public function job_save() {

        $this->job_deactive_profile();

        $id = $_POST['post_id'];


        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('post_id' => $id, 'user_id' => $userid, 'is_delete' => '0');
        $userdata = $this->common->select_data_by_condition('job_apply', $contition_array, $data = 'count(*) as total,app_id', $sortby = 'post_id', $orderby = 'asc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $app_id = $userdata[0]['app_id'];

        if ($userdata[0]['total'] != 0) {

            $contition_array = array('job_delete' => '0');
            $jobdata = $this->common->select_data_by_condition('job_apply', $contition_array = array(), $data = '*', $sortby = 'post_id', $orderby = 'asc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $data = array(
                'job_delete' => '1',
                'job_save' => '2'
            );

            $updatedata = $this->common->update_data($data, 'job_apply', 'app_id', $app_id);


            if ($updatedata) {

                $savepost = 'Saved';
            }
            echo $savepost;
        } else {

            $data = array(
                'post_id' => $id,
                'user_id' => $userid,
                'status' => '1',
                'created_date' => date('Y-m-d h:i:s', time()),
                'modify_date' => date('Y-m-d h:i:s', time()),
                'is_delete' => '0',
                'job_delete' => '1',
                'job_save' => '2'
            );

            $insert_id = $this->common->insert_data_getid($data, 'job_apply');
            if ($insert_id) {

                $savepost = 'Saved';
            } echo $savepost;
            die();
        }
    }

//job seeker Save post controller End
//job seeker view all Saved post controller Start
    public function job_save_post() {
        $this->job_apply_check();
        $this->job_deactive_profile();

        //For Counting Profile data start
        $this->progressbar();
        //For Counting Profile data End


        $jobseeker_name = $this->get_jobseeker_name($id);
        $this->data['title'] = $jobseeker_name . " | Saved Job | Job Profile" . TITLEPOSTFIX;

        $this->load->view('job/job_save_post', $this->data);
    }

    //job seeker view all Saved post controller End
//for pop up image

    public function user_image_insert() {

        $this->job_deactive_profile();

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $user_reg_data = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $user_reg_prev_image = $user_reg_data[0]['job_user_image'];

        if ($user_reg_prev_image != '') {
            $user_image_main_path = $this->config->item('job_profile_main_upload_path');
            $user_bg_full_image = $user_image_main_path . $user_reg_prev_image;
            if (isset($user_bg_full_image)) {
                unlink($user_bg_full_image);
            }

            $user_image_thumb_path = $this->config->item('job_profile_thumb_upload_path');
            $user_bg_thumb_image = $user_image_thumb_path . $user_reg_prev_image;
            if (isset($user_bg_thumb_image)) {
                unlink($user_bg_thumb_image);
            }
        }

        $data = $_POST['image'];
        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);
        $user_bg_path = $this->config->item('job_profile_main_upload_path');
        $imageName = time() . '.png';
        $data = base64_decode($data);
        $file = $user_bg_path . $imageName;
        file_put_contents($user_bg_path . $imageName, $data);
        $success = file_put_contents($file, $data);
        $main_image = $user_bg_path . $imageName;
        $main_image_size = filesize($main_image);

        if ($main_image_size > '1000000') {
            $quality = "50%";
        } elseif ($main_image_size > '50000' && $main_image_size < '1000000') {
            $quality = "55%";
        } elseif ($main_image_size > '5000' && $main_image_size < '50000') {
            $quality = "60%";
        } elseif ($main_image_size > '100' && $main_image_size < '5000') {
            $quality = "65%";
        } elseif ($main_image_size > '1' && $main_image_size < '100') {
            $quality = "70%";
        } else {
            $quality = "100%";
        }

        /* RESIZE */
        $job['image_library'] = 'gd2';
        $job['source_image'] = $main_image;
        $job['new_image'] = $main_image;
        $job['quality'] = $quality;
        $instanse10 = "image10";
        $this->load->library('image_lib', $job, $instanse10);
        //  $this->$instanse10->watermark();
        /* RESIZE */

        //S3 BUCKET ACCESS START
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
        //S3 BUCKET ACCESS END
        //S3 BUCKET STORE MAIN IMAGE START
        $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);
        //S3 BUCKET STORE MAIN IMAGE END

        $user_thumb_path = $this->config->item('job_profile_thumb_upload_path');
        $user_thumb_width = $this->config->item('job_profile_thumb_width');
        $user_thumb_height = $this->config->item('job_profile_thumb_height');

        $upload_image = $user_bg_path . $imageName;

        $thumb_image_uplode = $this->thumb_img_uplode($upload_image, $imageName, $user_thumb_path, $user_thumb_width, $user_thumb_height);

        //S3 BUCKET STORE THUMB IMAGE START
        $thumb_image = $user_thumb_path . $imageName;
        $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);
        //S3 BUCKET STORE THUMB IMAGE END

        $data = array(
            'job_user_image' => $imageName,
            'modified_date' => date('Y-m-d', time())
        );

        $update = $this->common->update_data($data, 'job_reg', 'user_id', $userid);

        if ($update) {
            $contition_array = array('user_id' => $userid, 'status' => '1', 'is_delete' => '0');
            $job_reg_data = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

            $userimage .= '<img src="' . JOB_PROFILE_THUMB_UPLOAD_URL . $job_reg_data[0]['job_user_image'] . '" alt="' . $job_reg_data[0]['job_user_image'] . '" >';
            $userimage .= '<a href="javascript:void(0);" onclick="updateprofilepopup();" class="cusome_upload"><img  src="' . base_url('../assets/img/cam.png') . '">';
            $userimage .= 'Update Profile Picture';
            $userimage .= '</a>';
            echo $userimage;
        } else {

            $this->session->flashdata('error', 'Your data not inserted');
            redirect('job/home', refresh);
        }
    }

// pop image end
//job serach user for recruiter start 

    public function job_user($id = "") {

        $this->job_deactive_profile();

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('job_reg.user_id' => $id, 'job_reg.is_delete' => '0');

        $data = '*';

        $this->jobdata['job'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str, $groupby);



        $this->load->view('job/job_printpreview', $this->jobdata);
    }

//job user end
    //deactivate user start
    public function deactivate() {

        $id = $_POST['id'];

        $data = array(
            'status' => '0'
        );

        $update = $this->common->update_data($data, 'job_reg', 'user_id', $id);
    }

// deactivate user end
// cover pic controller

    public function ajaxpro() {

        $this->job_deactive_profile();

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid);
        $job_reg_data = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'profile_background', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $job_reg_prev_image = $job_reg_data[0]['profile_background'];
        $job_reg_prev_main_image = $job_reg_data[0]['profile_background_main'];

        if ($job_reg_prev_image != '') {
            $job_image_main_path = $this->config->item('job_bg_main_upload_path');
            $job_bg_full_image = $job_image_main_path . $job_reg_prev_image;
            if (isset($job_bg_full_image)) {
                unlink($job_bg_full_image);
            }

            $job_image_thumb_path = $this->config->item('job_bg_thumb_upload_path');
            $job_bg_thumb_image = $job_image_thumb_path . $job_reg_prev_image;
            if (isset($job_bg_thumb_image)) {
                unlink($job_bg_thumb_image);
            }
        }
        if ($job_reg_prev_main_image != '') {
            $job_image_original_path = $this->config->item('job_bg_original_upload_path');
            $job_bg_origin_image = $job_image_original_path . $user_reg_prev_main_image;
            if (isset($job_bg_origin_image)) {
                unlink($job_bg_origin_image);
            }
        }

        $data = $_POST['image'];
        $data = str_replace('data:image/png;base64,', '', $data);
        $data = str_replace(' ', '+', $data);

        $job_bg_path = $this->config->item('job_bg_main_upload_path');
        $imageName = time() . '.png';

        $data = base64_decode($data);
        $file = $job_bg_path . $imageName;
        $success = file_put_contents($file, $data);
        $main_image = $job_bg_path . $imageName;
        $main_image_size = filesize($main_image);

        if ($main_image_size > '1000000') {
            $quality = "50%";
        } elseif ($main_image_size > '50000' && $main_image_size < '1000000') {
            $quality = "55%";
        } elseif ($main_image_size > '5000' && $main_image_size < '50000') {
            $quality = "60%";
        } elseif ($main_image_size > '100' && $main_image_size < '5000') {
            $quality = "65%";
        } elseif ($main_image_size > '1' && $main_image_size < '100') {
            $quality = "70%";
        } else {
            $quality = "100%";
        }

        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
        $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);

        $job_thumb_path = $this->config->item('job_bg_thumb_upload_path');
        $job_thumb_width = $this->config->item('job_bg_thumb_width');
        $job_thumb_height = $this->config->item('job_bg_thumb_height');

        $upload_image = $job_bg_path . $imageName;

        $thumb_image_uplode = $this->thumb_img_uplode($upload_image, $imageName, $job_thumb_path, $job_thumb_width, $job_thumb_height);

        $thumb_image = $job_thumb_path . $imageName;
        $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);

        $data = array(
            'profile_background' => $imageName
        );


        $update = $this->common->update_data($data, 'job_reg', 'user_id', $userid);
        if ($update) {
            if ($_SERVER['HTTP_HOST'] != "localhost") {
                if (isset($main_image)) {
                    unlink($main_image);
                }
                if (isset($thumb_image)) {
                    unlink($thumb_image);
                }
            }
        }
        $this->data['jobdata'] = $this->common->select_data_by_id('job_reg', 'user_id', $userid, $data = 'profile_background', $join_str = array());

        $coverpic = '<img src = "' . JOB_BG_MAIN_UPLOAD_URL . $this->data['jobdata'][0]['profile_background'] . '" name="image_src" id="image_src" />';
        echo $coverpic;
    }

    public function image() {

        $this->job_deactive_profile();

        $userid = $this->session->userdata('aileenuser');

        $config['upload_path'] = $this->config->item('job_bg_original_upload_path');
        $config['allowed_types'] = $this->config->item('job_bg_allowed_types');
        $config['file_name'] = $_FILES['image']['name'];

        //Load upload library and initialize configuration
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('image')) {

            $uploadData = $this->upload->data();
            $image = $uploadData['file_name'];
        } else {
            $image = '';
        }


        $data = array(
            'profile_background_main' => $image,
            'modified_date' => date('Y-m-d h:i:s', time())
        );


        $updatedata = $this->common->update_data($data, 'job_reg', 'user_id', $userid);
        $main_file = $this->config->item('job_bg_original_upload_path') . $uploadData['file_name'];

        if ($_SERVER['HTTP_HOST'] != "localhost") {
            if (isset($main_file)) {
                unlink($main_file);
            }
        }

        if ($updatedata) {
            echo $userid;
        } else {
            echo "welcome";
        }
        die();
    }

    public function ajax_designation() {

        $this->job_deactive_profile();

        $userid = $this->session->userdata('aileenuser');

        $data = array(
            'designation' => trim($_POST['designation'])
        );
        $updatedata = $this->common->update_data($data, 'job_reg', 'user_id', $userid);
    }

// cover pic end
//reactivate account start

    public function reactivate() {

        $userid = $this->session->userdata('aileenuser');
        $data = array(
            'status' => '1',
            'modified_date' => date('y-m-d h:i:s')
        );

        $updatdata = $this->common->update_data($data, 'job_reg', 'user_id', $userid);
        if ($updatdata) {

            redirect('job/home', refresh);
        } else {

            redirect('job/reactivate', refresh);
        }
    }

    public function job_work_delete() {
        $work_id = $_POST['work_id'];
        $certificate = $_POST['certificate'];

        $delete_data = $this->common->delete_data('job_add_workexp', 'work_id', $work_id);

        //FOR DELETE IMAGE AND PDF IN FOLDER START
        $path = 'uploads/job_work/main/' . $certificate;
        $path1 = 'uploads/job_work/thumbs/' . $certificate;

        echo 1;
        die();
    }

    public function job_edu_delete() {
        $grade_id = $_POST['grade_id'];
        $certificate = $_POST['certificate'];
        $delete_data = $this->common->delete_data('job_graduation', 'job_graduation_id', $grade_id);

        $path = 'uploads/job_education/main/' . $certificate;
        $path1 = 'uploads/job_education/thumbs/' . $certificate;

        unlink($path);
        unlink($path1);

        if ($delete_data) {
            echo 1;
        }
        die();
    }

//reactivate accont end 
//Ahi thi baki  
//add other_university into database start 
    public function job_other_university() {
        $other_university = $_POST['other_university'];
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        $contition_array = array('is_delete' => '0', 'university_name' => $other_university);
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
        $userdata = $this->data['userdata'] = $this->common->select_data_by_search('university', $search_condition, $contition_array, $data = 'count(*) as total', $sortby = 'university_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $count = $userdata[0]['total'];

        if ($other_university != NULL) {
            if ($count == 0) {
                $data = array(
                    'university_name' => $other_university,
                    'created_date' => date('Y-m-d h:i:s', time()),
                    'status' => 2,
                    'is_delete' => '0',
                    'is_other' => '1',
                    'user_id' => $userid
                );
                $insert_id = $this->common->insert_data_getid($data, 'university');
                if ($insert_id) {

                    $contition_array = array('is_delete' => '0', 'university_name !=' => "Other");
                    $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
                    $university = $this->data['university'] = $this->common->select_data_by_search('university', $search_condition, $contition_array, $data = '*', $sortby = 'university_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    if (count($university) > 0) {
                        $select = '<option value="" selected option disabled>Select your University</option>';

                        foreach ($university as $st) {
                            $select .= '<option value="' . $st['university_id'] . '"';
                            if ($st['university_name'] == $other_university) {
                                $select .= 'selected';
                            }
                            $select .= '>' . $st['university_name'] . '</option>';
                        }
                    }
//For Getting Other at end
                    $contition_array = array('is_delete' => '0', 'status' => 1, 'university_name' => "Other");
                    $university_otherdata = $this->common->select_data_by_condition('university', $contition_array, $data = '*', $sortby = 'university_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $select .= '<option value="' . $university_otherdata[0]['university_id'] . '">' . $university_otherdata[0]['university_name'] . '</option>';

                    //for getting university data in clone start
                    $select1 = '<option value="" selected option disabled>Select your University</option>';
                    foreach ($university as $st) {

                        $select1 .= '<option value="' . $st['university_id'] . '">' . $st['university_name'] . '</option>';
                    }
                    $select1 .= '<option value="' . $university_otherdata[0]['university_id'] . '">' . $university_otherdata[0]['university_name'] . '</option>';
                    //for getting university data in clone End
                }
            } else {
                $select .= 0;
            }
        } else {
            $select .= 1;
        }
        echo json_encode(array(
            "select" => $select,
            "select1" => $select1,
        ));
    }

//add other_university into database End 
//add other_degree into database start 
    public function job_other_degree() {
        $other_degree = $_POST['other_degree'];
        $other_stream = $_POST['other_stream'];

        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        $contition_array = array('is_delete' => '0', 'degree_name' => $other_degree);
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
        $userdata = $this->data['userdata'] = $this->common->select_data_by_search('degree', $search_condition, $contition_array, $data = '*', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $count = count($userdata);


        if ($other_degree != NULL) {
            if ($count == 0) {
                $data = array(
                    'degree_name' => $other_degree,
                    'created_date' => date('Y-m-d h:i:s', time()),
                    'status' => '2',
                    'is_delete' => '0',
                    'is_other' => '1',
                    'user_id' => $userid
                );
                $insert_id = $this->common->insert_data_getid($data, 'degree');
                $degree_id = $insert_id;

                $contition_array = array('is_delete' => '0', 'status' => '2', 'stream_name' => $other_stream, 'user_id' => $userid);
                $stream_data = $this->common->select_data_by_condition('stream', $contition_array, $data = '*', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                $count1 = count($stream_data);

                if ($count1 == 0) {
                    $data = array(
                        'stream_name' => $other_stream,
                        'degree_id' => $degree_id,
                        'created_date' => date('Y-m-d h:i:s', time()),
                        'status' => '2',
                        'is_delete' => '0',
                        'is_other' => '1',
                        'user_id' => $userid
                    );
                    $insert_id = $this->common->insert_data_getid($data, 'stream');
                } else {
                    $data = array(
                        'stream_name' => $other_stream,
                        'degree_id' => $degree_id,
                        'created_date' => date('Y-m-d h:i:s', time()),
                        'status' => '2',
                        'is_delete' => '0',
                        'is_other' => '1',
                        'user_id' => $userid
                    );
                    $updatedata = $this->common->update_data($data, 'stream', 'stream_id', $stream_data[0]['stream_id']);
                }
                if ($insert_id || $updatedata) {

                    $contition_array = array('is_delete' => '0', 'degree_name !=' => "Other");
                    $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
                    $degree = $this->data['degree'] = $this->common->select_data_by_search('degree', $search_condition, $contition_array, $data = '*', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    if (count($degree) > 0) {

                        $select = '<option value="" Selected option disabled="">Select your Degree</option>';

                        foreach ($degree as $st) {

                            $select .= '<option value="' . $st['degree_id'] . '"';
                            if ($st['degree_name'] == $other_degree) {
                                $select .= 'selected';
                            }
                            $select .= '>' . $st['degree_name'] . '</option>';
                        }
                    }
//For Getting Other at end
                    $contition_array = array('is_delete' => '0', 'status' => 1, 'degree_name' => "Other");
                    $degree_otherdata = $this->common->select_data_by_condition('degree', $contition_array, $data = '*', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $select .= '<option value="' . $degree_otherdata[0]['degree_id'] . '">' . $degree_otherdata[0]['degree_name'] . '</option>';

                    //for getting degree data in clone start
                    $select1 = '<option value="" Selected option disabled="">Select your Degree</option>';
                    foreach ($degree as $st) {

                        $select1 .= '<option value="' . $st['degree_id'] . '">' . $st['degree_name'] . '</option>';
                    }
                    $select1 .= '<option value="' . $degree_otherdata[0]['degree_id'] . '">' . $degree_otherdata[0]['degree_name'] . '</option>';
                    //for getting degree data in clone End
                    //for getting selected stream data start
                    $contition_array = array('is_delete' => '0', 'degree_id' => $degree_id);
                    $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
                    $stream = $this->data['stream'] = $this->common->select_data_by_search('stream', $search_condition, $contition_array, $data = '*', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $select2 = '<option value="" Selected option disabled="">Select your Stream</option>';
                    $select2 .= '<option value="' . $stream[0]['stream_id'] . '"';
                    if ($stream[0]['stream_name'] == $other_stream) {
                        $select2 .= 'selected';
                    }
                    $select2 .= '>' . $stream[0]['stream_name'] . '</option>';
                    //for getting selected stream data End         
                }
            } else {
                $select .= 0;
            }
        } else {
            $select .= 1;
        }

        echo json_encode(array(
            "select" => $select,
            "select1" => $select1,
            "select2" => $select2,
        ));
    }

//add other_degree into database End  
//add other_stream into database start 
    public function job_other_stream() {
        $other_stream = $_POST['other_stream'];
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        $contition_array = array('is_delete' => '0', 'stream_name' => $other_stream);
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
        $userdata = $this->data['userdata'] = $this->common->select_data_by_search('stream', $search_condition, $contition_array, $data = '*', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $count = count($userdata);

        if ($other_stream != NULL) {
            if ($count == 0) {
                $data = array(
                    'stream_name' => $other_stream,
                    'created_date' => date('Y-m-d h:i:s', time()),
                    'status' => '2',
                    'is_delete' => '0',
                    'is_other' => '1',
                    'user_id' => $userid
                );
                $insert_id = $this->common->insert_data_getid($data, 'stream');


                if ($insert_id) {

                    $contition_array = array('is_delete' => '0', 'stream_name !=' => "Other");
                    $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
                    $stream = $this->data['stream'] = $this->common->select_data_by_search('stream', $search_condition, $contition_array, $data = '*', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    if (count($stream) > 0) {
                        $select = '<option value="" selected option disabled="">Select your Stream</option>';

                        foreach ($stream as $st) {

                            $select .= '<option value="' . $st['stream_id'] . '"';
                            if ($st['stream_name'] == $other_stream) {
                                $select .= 'selected';
                            }
                            $select .= '>' . $st['stream_name'] . '</option>';
                        }
                    }
//For Getting Other at end
                    $contition_array = array('is_delete' => '0', 'status' => '1', 'stream_name' => "Other");
                    $stream_otherdata = $this->common->select_data_by_condition('stream', $contition_array, $data = '*', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $select .= '<option value="' . $stream_otherdata[0]['stream_id'] . '">' . $stream_otherdata[0]['stream_name'] . '</option>';
                }
            } else {
                $select .= 0;
            }
        } else {
            $select .= 1;
        }

        echo $select;
    }

//add other_degree into database End 
// create pdf start

    public function creat_pdf_primary($id = "", $seg = "") {

        $contition_array = array('edu_id' => $id, 'status' => '1');
        $pdf = $this->data['pdf'] = $this->common->select_data_by_condition('job_add_edu', $contition_array, $data = 'edu_certificate_primary', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($pdf[0]['edu_certificate_primary']) {
            if ($seg == 'primary') {
                $select = '<title>' . $pdf[0]['edu_certificate'] . '</title>';
                $select .= '<link rel="icon" href="' . base_url('assets/images/favicon.png') . '">';
                $select .= '<form action="' . base_url() . '/job/qualification/primary" method="post">';
                $select .= '<button type="submit">Back</button>';
                $select .= '</form>';
                echo $select;
            } else {
                $select = '<title>' . $pdf[0]['edu_certificate'] . '</title>';
                $select .= '<link rel="icon" href="' . base_url('assets/images/favicon.png') . '">';
                $select .= '<input action="action" type="button" value="Back" onclick="history.back();" /> <br/><br/>';
                echo $select;
            }

            echo '<embed src="' . base_url() . $this->config->item('job_edu_main_upload_path') . $pdf[0]['edu_certificate_primary'] . '"width="100%" height="100%">';
        }
    }

    public function creat_pdf_secondary($id = "", $seg = "") {

        $contition_array = array('edu_id' => $id, 'status' => '1');
        $pdf = $this->data['pdf'] = $this->common->select_data_by_condition('job_add_edu', $contition_array, $data = 'edu_certificate_secondary', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($pdf[0]['edu_certificate_secondary']) {
            if ($seg == 'secondary') {
                $select = '<title>' . $pdf[0]['edu_certificate'] . '</title>';
                $select .= '<link rel="icon" href="' . base_url('assets/images/favicon.png') . '">';
                $select .= '<form action="' . base_url() . '/job/qualification/secondary" method="post">';
                $select .= '<button type="submit">Back</button>';
                $select .= '</form>';
                echo $select;
            } else {
                $select = '<title>' . $pdf[0]['edu_certificate'] . '</title>';
                $select .= '<link rel="icon" href="' . base_url('assets/images/favicon.png') . '">';
                $select .= '<input action="action" type="button" value="Back" onclick="history.back();" /> <br/><br/>';
                echo $select;
            }

            echo '<embed src="' . base_url() . $this->config->item('job_edu_main_upload_path') . $pdf[0]['edu_certificate_secondary'] . '"width="100%" height="100%">';
        }
    }

    public function creat_pdf_higher_secondary($id = "", $seg = "") {

        $contition_array = array('edu_id' => $id, 'status' => '1');
        $pdf = $this->data['pdf'] = $this->common->select_data_by_condition('job_add_edu', $contition_array, $data = '  edu_certificate_higher_secondary', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($pdf[0]['edu_certificate_higher_secondary']) {
            if ($seg == 'higher-secondary') {
                $select = '<title>' . $pdf[0]['edu_certificate'] . '</title>';
                $select .= '<link rel="icon" href="' . base_url('assets/images/favicon.png') . '">';
                $select .= '<form action="' . base_url() . '/job/qualification/higher-secondary" method="post">';
                $select .= '<button type="submit">Back</button>';
                $select .= '</form>';
                echo $select;
            } else {
                $select = '<title>' . $pdf[0]['edu_certificate'] . '</title>';
                $select .= '<link rel="icon" href="' . base_url('assets/images/favicon.png') . '">';
                $select .= '<input action="action" type="button" value="Back" onclick="history.back();" /> <br/><br/>';
                echo $select;
            }

            echo '<embed src="' . base_url() . $this->config->item('job_edu_main_upload_path') . $pdf[0]['edu_certificate_higher_secondary'] . '"width="100%" height="100%">';
        }
    }

    public function creat_pdf_graduation($id = "", $seg = "") {

        $contition_array = array('job_graduation_id' => $id);
        $pdf = $this->data['pdf'] = $this->common->select_data_by_condition('job_graduation', $contition_array, $data = 'edu_certificate', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($pdf[0]['edu_certificate']) {
            if ($seg == 'graduation') {
                $select = '<title>' . $pdf[0]['edu_certificate'] . '</title>';
                $select .= '<link rel="icon" href="' . base_url('assets/images/favicon.png') . '">';
                echo $select;
            } else {
                $select = '<title>' . $pdf[0]['edu_certificate'] . '</title>';
                $select .= '<link rel="icon" href="' . base_url('assets/images/favicon.png') . '">';
                echo $select;
            }

            echo '<embed src="' . base_url() . $this->config->item('job_edu_main_upload_path') . $pdf[0]['edu_certificate'] . '"width="100%" height="100%">';
        }
    }

    public function creat_pdf_workexp($id = "") {

        $contition_array = array('work_id' => $id);
        $pdf = $this->data['pdf'] = $this->common->select_data_by_condition('job_add_workexp', $contition_array, $data = 'work_certificate', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $select = '<title>' . $pdf[0]['work_certificate'] . '</title>';
        $select .= '<link rel="icon" href="' . base_url('assets/images/favicon.png') . '">';
        $select .= '<input action="action" type="button" value="Back" onclick="history.back();" /> <br/><br/>';

        $select .= '<embed src="' . base_url() . $this->config->item('job_work_main_upload_path') . $pdf[0]['work_certificate'] . '"width="100%" height="100%">';
        echo $select;
    }

//create pdf end 
//DELETE PRIMARY CERIFICATE & PDF START
    public function delete_primary() {
        $id = $_POST['edu_id'];
        $certificate = $_POST['certificate'];

        $data = array(
            'edu_certificate_primary' => ''
        );

        $updatedata = $this->common->update_data($data, 'job_add_edu', 'edu_id', $id);

        //FOR DELETE IMAGE AND PDF IN FOLDER START
        $path = 'uploads/job_education/main/' . $certificate;
        $path1 = 'uploads/job_education/thumbs/' . $certificate;

        unlink($path);
        unlink($path1);
        //FOR DELETE IMAGE AND PDF IN FOLDER END
        echo 1;
        die();
    }

//DELETE PRIMARY CERIFICATE & PDF END
//DELETE SECONDARY CERIFICATE & PDF START
    public function delete_secondary() {
        $id = $_POST['edu_id'];
        $certificate = $_POST['certificate'];

        $data = array(
            'edu_certificate_secondary' => ''
        );

        $updatedata = $this->common->update_data($data, 'job_add_edu', 'edu_id', $id);

        //FOR DELETE IMAGE AND PDF IN FOLDER START
        $path = 'uploads/job_education/main/' . $certificate;
        $path1 = 'uploads/job_education/thumbs/' . $certificate;

        unlink($path);
        unlink($path1);
        //FOR DELETE IMAGE AND PDF IN FOLDER END
        echo 1;
        die();
    }

//DELETE SECONDARY CERIFICATE & PDF END
//DELETE HIGHER SECONDARY CERIFICATE & PDF START
    public function delete_higher_secondary() {
        $id = $_POST['edu_id'];
        $certificate = $_POST['certificate'];

        $data = array(
            'edu_certificate_higher_secondary' => ''
        );

        $updatedata = $this->common->update_data($data, 'job_add_edu', 'edu_id', $id);

        //FOR DELETE IMAGE AND PDF IN FOLDER START
        $path = 'uploads/job_education/main/' . $certificate;
        $path1 = 'uploads/job_education/thumbs/' . $certificate;

        unlink($path);
        unlink($path1);
        //FOR DELETE IMAGE AND PDF IN FOLDER END
        echo 1;
        die();
    }

//DELETE HIGHER SECONDARY CERIFICATE & PDF END
//DELETE GRADUATION CERIFICATE & PDF START
    public function delete_graduation() {
        $id = $_POST['edu_id'];
        $certificate = $_POST['certificate'];


        $data = array(
            'edu_certificate' => ''
        );

        $updatedata = $this->common->update_data($data, 'job_graduation', 'job_graduation_id', $id);

        //FOR DELETE IMAGE AND PDF IN FOLDER START
        $path = 'uploads/job_education/main/' . $certificate;
        $path1 = 'uploads/job_education/thumbs/' . $certificate;

        unlink($path);
        unlink($path1);
        //FOR DELETE IMAGE AND PDF IN FOLDER END
        echo 1;
        die();
    }

//DELETE GRADUATION CERIFICATE & PDF END
//DELETE WORK EXPERIENCE CERIFICATE & PDF START
    public function delete_workexp() {
        $id = $_POST['work_id'];
        $certificate = $_POST['certificate'];

        $data = array(
            'work_certificate' => ''
        );

        $updatedata = $this->common->update_data($data, 'job_add_workexp', 'work_id', $id);

        //FOR DELETE IMAGE AND PDF IN FOLDER START
        $path = 'uploads/job_work/main/' . $certificate;
        $path1 = 'uploads/job_work/thumbs/' . $certificate;

        unlink($path);
        unlink($path1);
        //FOR DELETE IMAGE AND PDF IN FOLDER END
        echo 1;
        die();
    }

//DELETE WORK EXPERIENCE CERIFICATE & PDF END
//THIS JOB REGISTRATION IS USED FOR FIRST TIME REGISTARTION VIEW START

    public function job_reg($postid = '') {


        $this->data['livepost'] = $this->uri->segment(3);
        // job aply wothout login start

        if ($postid != '') {
            //$this->job_apply_check();
            $this->job_deactive_profile();

            $notid = $this->db->select('user_id')->get_where('rec_post', array('post_id' => $postid))->row()->user_id;
            $userid = $this->session->userdata('aileenuser');

            $contition_array = array('post_id' => $postid, 'user_id' => $userid, 'is_delete' => '0');
            $userdata = $this->common->select_data_by_condition('job_apply', $contition_array, $data = 'app_id,count(*) as total', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $app_id = $userdata[0]['app_id'];

            if ($userdata[0]['total'] != 0) {

                $contition_array = array('job_delete' => '1');
                $jobdata = $this->common->select_data_by_condition('job_apply', $contition_array, $data = 'app_id', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $data = array(
                    'job_delete' => '0',
                    'modify_date' => date('Y-m-d h:i:s', time()),
                );


                $updatedata = $this->common->update_data($data, 'job_apply', 'app_id', $app_id);


                // insert notification

                $data = array(
                    'not_type' => '3',
                    'not_from_id' => $userid,
                    'not_to_id' => $notid,
                    'not_read' => '2',
                    'not_from' => '2',
                    'not_product_id' => $app_id,
                    'not_active' => '1'
                );

                $updatedata = $this->common->insert_data_getid($data, 'notification');
                // end notoification
            } else {

                $data = array(
                    'post_id' => $postid,
                    'user_id' => $userid,
                    'status' => '1',
                    'created_date' => date('Y-m-d h:i:s', time()),
                    'modify_date' => date('Y-m-d h:i:s', time()),
                    'is_delete' => '0',
                    'job_delete' => '0'
                );


                $insert_id = $this->common->insert_data_getid($data, 'job_apply');


                // insert notification

                $data = array(
                    'not_type' => '3',
                    'not_from_id' => $userid,
                    'not_to_id' => $notid,
                    'not_read' => '2',
                    'not_from' => '2',
                    'not_product_id' => $insert_id,
                    'not_active' => '1',
                    'not_created_date' => date('Y-m-d H:i:s')
                );

                $updatedata = $this->common->insert_data_getid($data, 'notification');
                //end notoification
            }
        }
        // job apply without login end
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        //Retrieve Data from main user registartion table start
        $this->data['job'] = $this->user_model->getUserSelectedData($userid, $select_data = 'u.first_name,u.last_name,ul.email');
//Retrieve Data from main user registartion table end
        //skill data fetch
        $contition_array = array('status' => 'publish');
        $jobtitle = $this->common->select_data_by_condition('job_title', $contition_array, $data = 'name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = 'name');

        foreach ($jobtitle as $key1 => $value1) {
            foreach ($value1 as $ke1 => $val1) {
                $title[] = $val1;
            }
        }
        foreach ($title as $key => $value) {
            $result1[$key]['label'] = $value;
            $result1[$key]['value'] = $value;
        }
        $this->data['jobtitle'] = array_values($result1);

        $contition_array = array('is_delete' => '0', 'status' => '1', 'industry_name !=' => "Others");
        if ($userid) {
            $search_condition = "((is_other = '1' AND user_id = $userid) OR (is_other = '0'))";
        } else {
            $search_condition = "(is_other = '0')";
        }
        $university_data = $this->data['industry'] = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = 'industry_id,industry_name', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('is_delete' => '0', 'industry_name' => "Others", 'is_other' => '0');
        $search_condition = "((status = '1'))";
        $this->data['other_industry'] = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = 'industry_id,industry_name', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userid) {
            $this->data['profile_login'] = "login";
        } else {
            $this->data['profile_login'] = "live";
        }
        $this->data['title'] = 'Register | Job Profile ' . TITLEPOSTFIX;
        if ($this->session->userdata('aileenuser')) {
            $userid = $this->session->userdata('aileenuser');
            $jobuser = $this->db->select('user_id')->get_where('job_reg', array('user_id' => $userid))->row()->user_id;
        }
        if ($jobuser) {
            redirect('job/home', refresh);
        } else {
            $this->load->view('job/job_reg', $this->data);
        }
    }

    public function job_insert() {

        if ($this->input->post('livepost')) {
            $poslivtid = $this->input->post('livepost');
        }
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        $firstname = $this->input->post('first_name');
        $lastname = $this->input->post('last_name');
        $email = $this->input->post('email');
        $fresher = $this->input->post('fresher');
        $expy = $this->input->post('experience_year');
        $expm = $this->input->post('experience_month');
        $industry = $this->input->post('industry');

        $jobtitle = $this->input->post('job_title');

        $skills = $this->input->post('skills');
        $skills = explode(',', $skills);

        $cities = $this->input->post('cities');
        $cities = explode(',', $cities);

        // job title start   
        if ($jobtitle != " ") {
            $contition_array = array('name' => $jobtitle);
            $jobdata = $this->common->select_data_by_condition('job_title', $contition_array, $data = 'title_id,name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
            if ($jobdata) {
                $jobtitle = $jobdata[0]['title_id'];
            } else {
                $forslug = $this->input->post('job_title');
                $data = array(
                    'name' => ucfirst($this->input->post('job_title')),
                    'slug' => $this->common->clean($forslug),
                    'status' => 'draft',
                );
                if ($userid) {
                    $jobtitle = $this->common->insert_data_getid($data, 'job_title');
                }
            }
        }

        // skills  start   

        if (count($skills) > 0) {

            foreach ($skills as $ski) {
                $contition_array = array('skill' => trim($ski), 'type' => '1');
                $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                if (!$skilldata) {
                    $contition_array = array('skill' => trim($ski), 'type' => '4');
                    $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                }

                if ($skilldata) {
                    $skill[] = $skilldata[0]['skill_id'];
                } else {
                    $data = array(
                        'skill' => trim($ski),
                        'status' => '1',
                        'type' => '4',
                        'user_id' => $userid,
                    );
                    if ($userid) {
                        $skill[] = $this->common->insert_data_getid($data, 'skill');
                    }
                }
            }
            $skills = implode(',', $skill);
        }

        // city  start   

        if (count($cities) > 0) {

            foreach ($cities as $cit) {
                $contition_array = array('city_name' => $cit);
                $citydata = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_id,city_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                if ($citydata) {
                    $city[] = $citydata[0]['city_id'];
                } else {
                    $data = array(
                        'city_name' => $cit,
                        'status' => '1',
                    );
                    if ($userid) {
                        $city[] = $this->common->insert_data_getid($data, 'cities');
                    }
                }
            }

            $city = implode(',', $city);
        }

        $data1 = array(
            'fname' => ucfirst($this->input->post('first_name')),
            'lname' => ucfirst($this->input->post('last_name')),
            'email' => $this->input->post('email'),
            'keyskill' => $skills,
            'work_job_title' => $jobtitle,
            'work_job_industry' => $this->input->post('industry'),
            'work_job_city' => $city,
            'exp_y' => $expy,
            'exp_m' => $expm,
            'experience' => $this->input->post('fresher'),
            'status' => '1',
            'is_delete' => '0',
            'created_date' => date('Y-m-d h:i:s', time()),
            'user_id' => $userid,
            'job_step' => '10',
            'slug' => $this->setcategory_slug($this->input->post('first_name') . '-' . $this->input->post('last_name'), 'slug', 'job_reg')
        );



        $contition_array = array('user_id' => $userid);
        $job = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if ($userid) {
            if ($job[0]['total'] != 0) {
                $insert_id = $this->common->update_data($data1, 'job_reg', 'user_id', $userid);
            } else {
                $insert_id = $this->common->insert_data_getid($data1, 'job_reg');
            }
        }
        if ($insert_id) {
            if ($poslivtid) {
                redirect('job/home/' . $poslivtid, 'refresh');
            } else {
                redirect('job/home', 'refresh');
            }
        } else {
            if ($poslivtid) {
                $postdata = $this->common->select_data_by_id('rec_post', 'post_id', $poslivtid, $data = 'user_id,post_id', $join_str = array());

                $cache_time = $this->db->get_where('job_title', array(
                            'title_id' => $postdata[0]['post_name']
                        ))->row()->name;

                if ($cache_time) {
                    $cache_time1 = $cache_time;
                } else {
                    $cache_time1 = $postdata[0]['post_name'];
                }

                if ($cache_time1 != '') {
                    $text = strtolower($this->common->clean($cache_time1));
                } else {
                    $text = '';
                }
                $cityname = $this->db->get_where('cities', array('city_id' => $postdata[0]['city']))->row()->city_name;

                if ($cityname != '') {
                    $cityname = '-vacancy-in-' . strtolower($this->common->clean($cityname));
                } else {
                    $cityname = '';
                }

                redirect('recruiter/jobpost/' . $text . $cityname . '-' . $post['user_id'] . '-' . $post['post_id']);
            } else {
                redirect('job/registration');
            }
        }
    }

//THIS JOB REGISTRATION IS USED FOR FIRST TIME REGISTARTION VIEW END
//THIS FUNCTION IS USED TO CHECK IF USER NOT REGISTER AND OPEN DIRECT URL THEN GO TO REGISTRATION PAGE START
    public function job_apply_check() {
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '0');
        $apply_step = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        if ($apply_step[0]['total'] == 0) {

            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $apply_step = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($apply_step[0]['job_step'] == "" || $apply_step[0]['job_step'] == "0") {

                redirect('job/registration');
            }
        }
    }

//Retrive all data of dergree,stream and university start
    public function ajax_data() {

        $userid = $this->session->userdata('aileenuser');
        // ajax for degree start

        if (isset($_POST["degree_id"]) && !empty($_POST["degree_id"])) {
            //Get all stream data
            $contition_array = array('is_delete' => '0', 'degree_id' => $_POST["degree_id"]);
            $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
            $stream = $this->data['stream'] = $this->common->select_data_by_search('stream', $search_condition, $contition_array, $data = '*', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            //Count total number of rows
            //Display stram list
            if (count($stream) > 0) {
                echo '<option value="">Select stream</option>';
                foreach ($stream as $st) {
                    echo '<option value="' . $st['stream_id'] . '">' . $st['stream_name'] . '</option>';
                }
            } else {
                echo '<option value="">Stream not available</option>';
                die();
            }
        }

        // ajax for degree end
    }

    //Retrive all data of dergree,stream and university start
//if user deactive profile then redirect to job/index untill active profile start
    public function job_deactive_profile() {

        $userid = $this->session->userdata('aileenuser');
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');

        $job_deactive = $this->data['job_deactive'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($job_deactive[0]['total'] != 0) {
            redirect('job/');
        }
    }

//if user deactive profile then redirect to job/index untill active profile End
//Get All data for search Start
    public function get_alldata($id = "") {

        //get search term
        $searchTerm = $_GET['term'];
        //$trimCharacters = ',';
        if (!empty($searchTerm)) {

            $contition_array = array('re_status' => '1', 're_step' => '3');
            $search_condition = "(re_comp_name LIKE '" . trim($searchTerm) . "%')";
            $results_recruiter = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array, $data = 're_comp_name', $sortby = 're_comp_name', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = 're_comp_name');

            $contition_array = array('status' => '1');
            $search_condition = "(other_skill LIKE '" . trim($searchTerm) . "%')";
            $results_post = $this->common->select_data_by_search('rec_post', $search_condition, $contition_array, $data = 'other_skill', $sortby = 'other_skill', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = 'other_skill');

            $contition_array = array('status' => '1', 'type' => '1');
            $search_condition = "(skill LIKE '" . trim($searchTerm) . "%')";
            $skill = $this->common->select_data_by_search('skill', $search_condition, $contition_array, $data = 'skill', $sortby = 'skill', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = 'skill');

            $contition_array = array('status' => 'publish');
            $search_condition = "(name LIKE '" . trim($searchTerm) . "%')";
            $jobtitle = $this->common->select_data_by_search('job_title', $search_condition, $contition_array, $data = 'name', $sortby = 'name', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = 'name');
        }

        $uni = array_merge($results_recruiter, $results_post, $skill, $jobtitle);

        foreach ($uni as $key => $value) {
            foreach ($value as $ke => $val) {
                if ($val != "") {


                    $trim_char = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $val);
                    $trimchar = trim($trim_char);
                    $result[] = strtolower($trimchar);
                }
            }
        }
        // foreach ($result as $key => $value) {
        //     $result1[$key]['value'] = $value;
        // }
        $result1 = array_values($result);
        $result2 = array_unique($result1);
        //echo "<pre>"; print_r($result2); die();
        echo json_encode($result2);
    }

//Get All data for search End
//Search Result Retrieve Start
    public function job_search() {


        $searchvalue = $this->uri->segment(1);
        // echo $searchvalue;die();

        if ($searchvalue == 'jobs') {
            // $this->all_post();
            $search_job = '';
            $search_place = '';
        } else {
            $skill = explode('jobs', $searchvalue);
            $location = explode('in-', $searchvalue);

            $search_job = trim($skill[0]);
            $search_job = trim($skill[0], '-');
            $search_place = $location[1];
        }
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        // search keyword insert into database start

        $this->data['keyword'] = $search_job;


        $cache_time = $this->db->get_where('cities', array('city_name' => $search_place))->row()->city_id;
        $this->data['keyword1'] = $search_place;


        $title = '';
        if (empty($search_job) && empty($search_place)) {
            $title = 'Find Latest Job Vacancies at Your Location';
        } elseif ($search_job && $search_place) {
            $title = $search_job . ' in ' . $search_place;
        } elseif ($search_job) {
            $title = $search_job;
        } elseif ($search_place) {
            $title = $search_place;
        }

        $this->data['title'] = $title . " - Job Profile - Aileensoul";
        $this->data['head'] = $this->load->view('head', $this->data, TRUE);



        //THIS CODE IS FOR WHEN USER NOT LOGIN AND GET SEARCH DATA START
        if ($this->session->userdata('aileenuser')) {
            $contition_array = array('user_id' => $this->session->userdata('aileenuser'), 'status' => '1', 'is_delete' => '0');
            $jobdata = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if ($jobdata) {
                $this->load->view('job/job_all_post1', $this->data);
            } else {
                $this->load->view('job/job_search_login', $this->data);
            }
        } else {
            $this->load->view('job/job_search_login', $this->data);
        }
        //THIS CODE IS FOR WHEN USER NOT LOGIN AND GET SEARCH DATA END
    }

// job search end     
//Search Result Retrieve End
//Get Job Seeker Name for title Start
    public function get_jobseeker_name($id = '') {

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'status' => '1', 'is_delete' => '0');
        $jobdata = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'fname,lname', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        return $jobseeker_name = $jobdata[0]['fname'] . ' ' . $jobdata[0]['lname'];
    }

//Get Job Seeker Name for title End
//GET JOB ALL POST DATA WITH AJAX START
    public function ajax_recommen_job() {

        $perpage = 5;
        $page = 1;

        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;

        if ($start < 0)
            $start = 0;
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

// job seeker detail

        $contition_array = array(
            'user_id' => $userid,
            'is_delete' => '0',
            'status' => '1'
        );
        $jobdata = $this->data['jobdata'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// post detail

        $contition_array = array(
            'is_delete' => '0',
            'status' => '1'
        );
        $postdata = $this->data['postdata'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data = '*', $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// for getting data from rec_post table for keyskill

        $work_job_skill = $jobdata[0]['keyskill'];
        $work_skill = explode(',', $work_job_skill);
        foreach ($work_skill as $skill) {
            $contition_array = array(
                'FIND_IN_SET("' . $skill . '",post_skill)!=' => '0',
                'is_delete' => '0',
                'status' => '1'
            );
            $data = $this->data['data'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data = '*', $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $recommendata[] = $data;
        }


// Retrieve data according to city match start

        $work_job_city = $jobdata[0]['work_job_city'];
        $work_city = explode(',', $work_job_city);

        foreach ($work_city as $city) {
            $data = '*';
            $contition_array = array(
                'FIND_IN_SET("' . $city . '",city)!=' => '0',
                'is_delete' => '0',
                'status' => '1'
            );
            $data1 = $this->data['data'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data, $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $recommendata_city[] = $data1;
        }

// Retrieve data according to city match End
// Retrieve data according to industry match start

        $work_job_industry = $jobdata[0]['work_job_industry'];
//        foreach ($postdata as $post) {
        $data = '*';
        $contition_array = array(
            'industry_type' => $work_job_industry,
            'is_delete' => '0',
            'status' => '1'
        );
        $data1 = $this->data['data'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data, $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $recommendata_industry[] = $data1;
//        }
// Retrieve data according to industry match End
// Retrieve data according to Job Title match start

        $work_job_title = $jobdata[0]['work_job_title'];

        foreach ($postdata as $post) {
            $data = '*';
            $contition_array = array(
                'post_name' => $work_job_title,
                'is_delete' => '0',
                'status' => '1'
            );
            $data1 = $this->data['data'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data, $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $recommendata_title[] = $data1;
        }

        $recskill = count(array_filter($recommendata));
        $reccity = count(array_filter($recommendata_city));
        $recindustry = count(array_filter($recommendata_industry));
        $rectitle = count(array_filter($recommendata_title));

// Retrieve data according to  Job Title match End

        if ($recskill != 0 && $reccity == 0 && $recindustry == 0 && $rectitle == 0) {

            $unique = $recommendata;
            $newArray = array_reduce($unique, 'array_merge', array());
            $qbc = array_unique($newArray, SORT_REGULAR);
            $qbc = array_filter($qbc);
        } elseif ($recskill == 0 && $reccity != 0 && $recindustry == 0 && $rectitle == 0) {

            $unique = $recommendata_city;
            $newArray = array_reduce($unique, 'array_merge', array());
            $qbc = array_unique($newArray, SORT_REGULAR);
            $qbc = array_filter($qbc);
        } elseif ($recskill == 0 && $reccity == 0 && $recindustry != 0 && $rectitle == 0) {
            $unique = $recommendata_industry;
            $newArray = array_reduce($unique, 'array_merge', array());
            $qbc = array_unique($newArray, SORT_REGULAR);
            $qbc = array_filter($qbc);
        } elseif ($recskill == 0 && $reccity == 0 && $recindustry == 0 && $rectitle != 0) {

            $unique = $recommendata_title;
            $newArray = array_reduce($unique, 'array_merge', array());
            $qbc = array_unique($newArray, SORT_REGULAR);
            $qbc = array_filter($qbc);
        } else {

            $unique = array_merge((array) $recommendata, (array) $recommendata_city, (array) $recommendata_industry, (array) $recommendata_title);

            $newArray = array_reduce($unique, 'array_merge', array());
            $qbc = array_unique($newArray, SORT_REGULAR);
            $qbc = array_filter($qbc);
        }

        $postdetail = $this->data['postdetail'] = $qbc;


        $postdetail1 = array_slice($postdetail, $start, $perpage);

        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($postdetail);
        }

        $return_html = '';
        $return_html .= '<input type = "hidden" class = "page_number" value = "' . $page . '" />';
        $return_html .= '<input type = "hidden" class = "total_record" value = "' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';

        if (count($postdetail) > 0) {
            foreach ($postdetail1 as $post) {
                $return_html .= '<div class="all-job-box" id="applypost' . $post['app_id'] . '">
                                    <div class="all-job-top">';

                $cache_time_1 = $this->db->get_where('recruiter', array(
                            'user_id' => $post['user_id']
                        ))->row()->comp_logo;

                $cache_time = $this->db->get_where('job_title', array(
                            'title_id' => $post['post_name']
                        ))->row()->name;
                if ($cache_time) {
                    $post_name = $cache_time;
                } else {
                    $post_name = $post['post_name'];
                }

                if ($post_name != '') {
                    $text = strtolower($this->common->clean($post_name));
                } else {
                    $text = '';
                }
                $cityname = $this->db->get_where('cities', array('city_id' => $post['city']))->row()->city_name;
                if ($cityname != '') {
                    $cityname = '-vacancy-in-' . strtolower($this->common->clean($cityname));
                } else {
                    $cityname = '';
                }
                $return_html .= '<div class="post-img">
                                            <a  title="' . $post_name . '" href="' . base_url() . 'recruiter/jobpost/' . $text . $cityname . '-' . $post['user_id'] . '-' . $post['post_id'] . '">';

                if ($cache_time_1) {
                    if (IMAGEPATHFROM == 'upload') {
                        if (!file_exists($this->config->item('rec_profile_thumb_upload_path') . $cache_time_1)) {
                            $return_html .= '<img src="' . base_url('assets/images/commen-img.png') . '">';
                        } else {
                            $return_html .= '<img src="' . REC_PROFILE_THUMB_UPLOAD_URL . $cache_time_1 . '">';
                        }
                    } else {
                        $filename = $this->config->item('rec_profile_thumb_upload_path') . $cache_time_1;
                        $s3 = new S3(awsAccessKey, awsSecretKey);
                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                        if ($info) {
                            $return_html .= '<img src="' . REC_PROFILE_THUMB_UPLOAD_URL . $cache_time_1 . '">';
                        } else {
                            $return_html .= '<img src="' . base_url('assets/images/commen-img.png') . '">';
                        }
                    }
                } else {
                    $return_html .= '<img src="' . base_url('assets/images/commen-img.png') . '">';
                }
                $return_html .= '</a>
                                        </div>';


                $cache_time1 = $this->db->get_where('recruiter', array(
                            'user_id' => $post['user_id']
                        ))->row()->re_comp_name;

                $cache_time2 = $this->db->get_where('recruiter', array(
                            'user_id' => $post['user_id']
                        ))->row()->rec_firstname;
                $cache_time3 = $this->db->get_where('recruiter', array(
                            'user_id' => $post['user_id']
                        ))->row()->rec_lastname;

                $return_html .= '<div class="job-top-detail">';
                $return_html .= '<h5><a href="' . base_url() . 'recruiter/jobpost/' . $text . $cityname . '-' . $post['user_id'] . '-' . $post['post_id'] . '">';
                $return_html .= $post_name;
                $return_html .= '</a></h5>';
                $return_html .= '<p><a href = "' . base_url() . 'recruiter/jobpost/' . $text . $cityname . '-' . $post['user_id'] . '-' . $post['post_id'] . '">';
                $return_html .= $cache_time1;
                $return_html .= '</a></p>';
                $return_html .= '<p><a href="' . base_url('recruiter/profile/' . $post['user_id']) . '">';
                $return_html .= ucwords($cache_time2) . " " . ucfirst($cache_time3);
                $return_html .= '</a></p>
            </div>
            </div>
            <div class="all-job-middle">
                <p class="pb5">
                    <span class="location">';
                $return_html .= '<span><img class="pr5" src="' . base_url('assets/images/location.png') . '">';
                $cityname = $this->db->get_where('cities', array('city_id' => $post['city']))->row()->city_name;
                $countryname = $this->db->get_where('countries', array('country_id' => $post['country']))->row()->country_name;
                if ($cityname || $countryname) {
                    if ($cityname) {
                        $return_html .= $cityname . ', ';
                    }
                    $return_html .= $countryname;
                }
                $return_html .= '      </span>
                    </span>';
                $return_html .= '<span class="exp">
                        <span><img class="pr5" src="' . base_url('assets/images/exp.png') . '">';

                if (($post['min_year'] != '0' || $post['max_year'] != '0') && ($post['fresher'] == 1)) {
                    $return_html .= $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year' . " " . "(Fresher can also apply)";
                } else {
                    if (($post['min_year'] != '0' || $post['max_year'] != '0')) {
                        $return_html .= $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year';
                    } else {
                        $return_html .= "Fresher";
                    }
                }


                $return_html .= '</span>
                    </span>
                </p>
                <p>';

                $rest = substr($post['post_description'], 0, 150);
                $return_html .= $rest;

                if (strlen($post['post_description']) > 150) {
                    $return_html .= '.....<a href="' . base_url() . 'recruiter/jobpost/' . $text . $cityname . '-' . $post['user_id'] . '-' . $post['post_id'] . '">Read more</a>';
                }
                $return_html .= '</p>

            </div>
            <div class="all-job-bottom">
                <span class="job-post-date"><b>Posted on: </b>';
                $return_html .= date('d-M-Y', strtotime($post['created_date']));
                $return_html .= '</span>
                <p class="pull-right">';

                $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
                $contition_array = array('post_id' => $post['post_id'], 'job_delete' => '0', 'user_id' => $userid);
                $jobapply = $this->data['jobsave'] = $this->common->select_data_by_condition('job_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');


                if ($jobapply) {
                    $return_html .= '<a href="javascript:void(0);" class="btn4  applied">Applied</a>';
                } else {
                    $contition_array = array(
                        'user_id' => $userid,
                        'job_save' => '2',
                        'post_id ' => $post['post_id'],
                        'job_delete' => '1'
                    );
                    $jobsave = $this->data['jobsave'] = $this->common->select_data_by_condition('job_apply', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    if ($jobsave) {
                        $return_html .= '<a href="javascript:void(0);" class="btn4 saved savedpost' . $post['post_id'] . '">Saved</a>';
                    } else {
                        $return_html .= '<a href="javascript:void(0);" id="' . $post['post_id'] . '" onClick="savepopup(' . $post['post_id'] . ')" class="btn4 savedpost' . $post['post_id'] . '">Save</a>';
                    }
                    $return_html .= '<a href="javascript:void(0);"  class= "btn4 applypost' . $post['post_id'] . '" onclick="applypopup(' . $post['post_id'] . ', ' . $post['user_id'] . ')">Apply</a>';
                }

                $return_html .= ' </p>

</div>
</div>';
            }
        } else {

            $return_html .= '<div class="art-img-nn">
    <div class="art_no_post_img">
        <img src="' . base_url('assets/img/job-no.png') . '">
    </div>
    <div class="art_no_post_text">
        No  Recommended Job Available.
    </div>
</div>';
        }

        echo $return_html;
    }

//GET JOB ALL POST DATA WITH AJAX END
//GET JOB SAVE DATA WITH AJAX START
    public function ajax_save_job() {

        $perpage = 5;
        $page = 1;

        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;

        if ($start < 0)
            $start = 0;


        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

// job seeker detail
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $jobdata = $this->data['jobdata'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// post detail
        $join_str[0]['table'] = 'job_apply';
        $join_str[0]['join_table_id'] = 'job_apply.post_id';
        $join_str[0]['from_table_id'] = 'rec_post.post_id';
        $join_str[0]['join_type'] = '';

        $contition_array = array('job_apply.job_delete' => '1', 'job_apply.user_id' => $userid, 'job_apply.job_save' => '2');
        $postdetail = $this->data['postdetail'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data = 'rec_post.*,job_apply.app_id,job_apply.user_id as userid', $sortby = 'job_apply.modify_date', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

        $postdetail1 = array_slice($postdetail, $start, $perpage);
        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($postdetail);
        }

        $return_html = '';
        $return_html .= '<input type = "hidden" class = "page_number" value = "' . $page . '" />';
        $return_html .= '<input type = "hidden" class = "total_record" value = "' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';

        if ($postdetail) {

            foreach ($postdetail1 as $post) {
                $return_html .= '<div class="all-job-box" id="postdata' . $post['app_id'] . '">
                                    <div class="all-job-top">';

                $cache_time_1 = $this->db->get_where('recruiter', array(
                            'user_id' => $post['user_id']
                        ))->row()->comp_logo;

                $cache_time = $this->db->get_where('job_title', array(
                            'title_id' => $post['post_name']
                        ))->row()->name;
                if ($cache_time) {
                    $post_name = $cache_time;
                } else {
                    $post_name = $post['post_name'];
                }
                if ($post_name != '') {
                    $text = strtolower($this->common->clean($post_name));
                } else {
                    $text = '';
                }
                $cityname = $this->db->get_where('cities', array('city_id' => $post['city']))->row()->city_name;
                if ($cityname != '') {
                    $cityname = '-vacancy-in-' . strtolower($this->common->clean($cityname));
                } else {
                    $cityname = '';
                }
                $return_html .= '<div class="post-img">
                                            <a href="' . base_url() . 'recruiter/jobpost/' . $text . $cityname . '-' . $post['user_id'] . '-' . $post['post_id'] . '">';
                if ($cache_time_1) {
                    if (IMAGEPATHFROM == 'upload') {
                        if (!file_exists($this->config->item('rec_profile_thumb_upload_path') . $cache_time)) {
                            $return_html .= '<img src="' . base_url('assets/images/commen-img.png') . '">';
                        } else {
                            $return_html .= '<img src="' . REC_PROFILE_THUMB_UPLOAD_URL . $cache_time_1 . '">';
                        }
                    } else {
                        $filename = $this->config->item('rec_profile_thumb_upload_path') . $cache_time_1;
                        $s3 = new S3(awsAccessKey, awsSecretKey);
                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                        if ($info) {
                            $return_html .= '<img src="' . REC_PROFILE_THUMB_UPLOAD_URL . $cache_time_1 . '">';
                        } else {
                            $return_html .= '<img src="' . base_url('assets/images/commen-img.png') . '">';
                        }
                    }
                } else {
                    $return_html .= '<img src="' . base_url('assets/images/commen-img.png') . '">';
                }
                $return_html .= '</a>
                                        </div>';


                $cache_time1 = $this->db->get_where('recruiter', array(
                            'user_id' => $post['user_id']
                        ))->row()->re_comp_name;

                $cache_time2 = $this->db->get_where('recruiter', array(
                            'user_id' => $post['user_id']
                        ))->row()->rec_firstname;
                $cache_time3 = $this->db->get_where('recruiter', array(
                            'user_id' => $post['user_id']
                        ))->row()->rec_lastname;

                $return_html .= '<div class="job-top-detail">';
                $return_html .= '<h5><a href="' . base_url() . 'recruiter/jobpost/' . $text . $cityname . '-' . $post['user_id'] . '-' . $post['post_id'] . '">';
                $return_html .= $post_name;
                $return_html .= '</a></h5>';
                $return_html .= '<p><a href = "' . base_url() . 'recruiter/jobpost/' . $text . $cityname . '-' . $post['user_id'] . '-' . $post['post_id'] . '">';
                $return_html .= $cache_time1;
                $return_html .= '</a></p>';
                $return_html .= '<p><a href="' . base_url('recruiter/profile/' . $post['user_id']) . '">';
                $return_html .= ucwords($cache_time2) . " " . ucfirst($cache_time3);
                $return_html .= '</a></p>
            </div>
            </div>
            <div class="all-job-middle">
                <p class="pb5">
                    <span class="location">';
                $return_html .= '<span><img class="pr5" src="' . base_url('assets/images/location.png') . '">';
                $cityname = $this->db->get_where('cities', array('city_id' => $post['city']))->row()->city_name;
                $countryname = $this->db->get_where('countries', array('country_id' => $post['country']))->row()->country_name;
                if ($cityname || $countryname) {
                    if ($cityname) {
                        $return_html .= $cityname . ', ';
                    }
                    $return_html .= $countryname;
                }
                $return_html .= '</span>
                    </span>';
                $return_html .= '<span class="exp">
                        <span><img class="pr5" src="' . base_url('assets/images/exp.png') . '">';

                if (($post['min_year'] != '0' || $post['max_year'] != '0') && ($post['fresher'] == 1)) {
                    $return_html .= $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year' . " " . "(Fresher can also apply)";
                } else {
                    if (($post['min_year'] != '0' || $post['max_year'] != '0')) {
                        $return_html .= $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year';
                    } else {
                        $return_html .= "Fresher";
                    }
                }


                $return_html .= '</span>
                    </span>
                </p>
                <p>';

                $rest = substr($post['post_description'], 0, 150);
                $return_html .= $rest;

                if (strlen($post['post_description']) > 150) {
                    $return_html .= '.....<a href="' . base_url() . 'recruiter/jobpost/' . $text . $cityname . '-' . $post['user_id'] . '-' . $post['post_id'] . '">Read more</a>';
                }
                $return_html .= '</p>

            </div>
            <div class="all-job-bottom">
                <span class="job-post-date"><b>Posted on: </b>';
                $return_html .= date('d-M-Y', strtotime($post['created_date']));
                $return_html .= '</span>
                <p class="pull-right">';

                $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
                $contition_array = array('post_id' => $post['post_id'], 'job_delete' => '0', 'user_id' => $userid);
                $jobsave = $this->data['jobsave'] = $this->common->select_data_by_condition('job_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');


                if ($jobsave[0]['job_save'] == 1) {
                    $return_html .= '<a href="javascript:void(0);" class="btn4 applied disabled">Applied</a>';
                } else {

                    $return_html .= '<a href="javascript:void(0);"  class= "btn4 applypost' . $post['post_id'] . '" onclick="applypopup(' . $post['post_id'] . ', ' . $post['app_id'] . ')">Apply</a>';
                    $return_html .= '<a href="javascript:void(0);" class="btn4 savedpost' . $post['post_id'] . '""  onClick="removepopup(' . $post['app_id'] . ')" >Remove</a>';
                }

                $return_html .= ' </p>

</div>
</div>';
            }
        } else {
            $return_html .= '<div class="art-img-nn">
    <div class="art_no_post_img">
        <img src="' . base_url('assets/img/job-no.png') . '">
    </div>
    <div class="art_no_post_text">
        No  Saved Job Available.
    </div>
</div>';
        }

        echo $return_html;
    }

//GET JOB SAVE DATA WITH AJAX END
//GET JOB APPLY DATA WITH AJAX START
    public function ajax_apply_job() {

        $perpage = 5;
        $page = 1;

        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;

        if ($start < 0)
            $start = 0;


        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        $join_str[0]['table'] = 'job_apply';
        $join_str[0]['join_table_id'] = 'job_apply.post_id';
        $join_str[0]['from_table_id'] = 'rec_post.post_id';
        $join_str[0]['join_type'] = '';
        $contition_array = array('job_apply.job_delete' => '0', 'rec_post.is_delete' => '0', 'job_apply.user_id' => $userid);

        $postdetail = $this->data['postdetail'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data = 'rec_post.*,job_apply.app_id,job_apply.user_id as userid,job_apply.modify_date', $sortby = 'job_apply.modify_date', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');


        $postdetail1 = array_slice($postdetail, $start, $perpage);
        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($postdetail);
        }

        $return_html = '';
        $return_html .= '<input type = "hidden" class = "page_number" value = "' . $page . '" />';
        $return_html .= '<input type = "hidden" class = "total_record" value = "' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';

        if (count($postdetail) != '0') {
            foreach ($postdetail1 as $post) {
                $return_html .= '<div class="all-job-box" id="removeapply' . $post['app_id'] . '">
                                    <div class="all-job-top">';

                $cache_time_1 = $this->db->get_where('recruiter', array(
                            'user_id' => $post['user_id']
                        ))->row()->comp_logo;
                $cache_time = $this->db->get_where('job_title', array(
                            'title_id' => $post['post_name']
                        ))->row()->name;
                if ($cache_time) {
                    $post_name = $cache_time;
                } else {
                    $post_name = $post['post_name'];
                }
                if ($post_name != '') {
                    $text = strtolower($this->common->clean($post_name));
                } else {
                    $text = '';
                }
                $cityname = $this->db->get_where('cities', array('city_id' => $post['city']))->row()->city_name;
                if ($cityname != '') {
                    $cityname = '-vacancy-in-' . strtolower($this->common->clean($cityname));
                } else {
                    $cityname = '';
                }

                $return_html .= '<div class="post-img">
                                            <a href="' . base_url() . 'recruiter/jobpost/' . $text . $cityname . '-' . $post['user_id'] . '-' . $post['post_id'] . '">';
                if ($cache_time_1) {
                    if (IMAGEPATHFROM == 'upload') {
                        if (!file_exists($this->config->item('rec_profile_thumb_upload_path') . $cache_time)) {
                            $return_html .= '<img src="' . base_url('assets/images/commen-img.png') . '">';
                        } else {
                            $return_html .= '<img src="' . REC_PROFILE_THUMB_UPLOAD_URL . $cache_time_1 . '">';
                        }
                    } else {
                        $filename = $this->config->item('rec_profile_thumb_upload_path') . $cache_time_1;
                        $s3 = new S3(awsAccessKey, awsSecretKey);
                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                        if ($info) {
                            $return_html .= '<img src="' . REC_PROFILE_THUMB_UPLOAD_URL . $cache_time_1 . '">';
                        } else {
                            $return_html .= '<img src="' . base_url('assets/images/commen-img.png') . '">';
                        }
                    }
                } else {
                    $return_html .= '<img src="' . base_url('assets/images/commen-img.png') . '">';
                }
                $return_html .= '</a>
                                        </div>';


                $cache_time1 = $this->db->get_where('recruiter', array(
                            'user_id' => $post['user_id']
                        ))->row()->re_comp_name;

                $cache_time2 = $this->db->get_where('recruiter', array(
                            'user_id' => $post['user_id']
                        ))->row()->rec_firstname;
                $cache_time3 = $this->db->get_where('recruiter', array(
                            'user_id' => $post['user_id']
                        ))->row()->rec_lastname;

                $return_html .= '<div class="job-top-detail">';
                $return_html .= '<h5><a href="' . base_url() . 'recruiter/jobpost/' . $text . $cityname . '-' . $post['user_id'] . '-' . $post['post_id'] . '">';
                $return_html .= $post_name;
                $return_html .= '</a></h5>';
                $return_html .= '<p><a href = "' . base_url() . 'recruiter/jobpost/' . $text . $cityname . '-' . $post['user_id'] . '-' . $post['post_id'] . '">';
                $return_html .= $cache_time1;
                $return_html .= '</a></p>';
                $return_html .= '<p><a href="' . base_url('recruiter/profile/' . $post['user_id']) . '">';
                $return_html .= ucwords($cache_time2) . " " . ucfirst($cache_time3);
                $return_html .= '</a></p>
            </div>
            </div>
            <div class="all-job-middle">
                <p class="pb5">
                    <span class="location">';
                $return_html .= '<span><img class="pr5" src="' . base_url('assets/images/location.png') . '">';
                $cityname = $this->db->get_where('cities', array('city_id' => $post['city']))->row()->city_name;
                $countryname = $this->db->get_where('countries', array('country_id' => $post['country']))->row()->country_name;
                if ($cityname || $countryname) {
                    if ($cityname) {
                        $return_html .= $cityname . ', ';
                    }
                    $return_html .= $countryname;
                }
                $return_html .= '</span>
                    </span>';
                $return_html .= '<span class="exp">
                        <span><img class="pr5" src="' . base_url('assets/images/exp.png') . '">';

                if (($post['min_year'] != '0' || $post['max_year'] != '0') && ($post['fresher'] == 1)) {
                    $return_html .= $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year' . " " . "(Fresher can also apply)";
                } else {
                    if (($post['min_year'] != '0' || $post['max_year'] != '0')) {
                        $return_html .= $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year';
                    } else {
                        $return_html .= "Fresher";
                    }
                }
                $return_html .= '</span>
                    </span>
                </p>
                <p>';

                $rest = substr($post['post_description'], 0, 150);
                $return_html .= $rest;

                if (strlen($post['post_description']) > 150) {
                    $return_html .= '.....<a href="' . base_url() . 'recruiter/jobpost/' . $text . $cityname . '-' . $post['user_id'] . '-' . $post['post_id'] . '">Read more</a>';
                }
                $return_html .= '</p>

            </div>
            <div class="all-job-bottom">
                <span class="job-post-date"><b>Posted on: </b>';
                $return_html .= date('d-M-Y', strtotime($post['created_date']));
                $return_html .= '</span>
                <p class="pull-right">';

                $return_html .= '<a href="javascript:void(0);"  class= "btn4" onclick="removepopup(' . $post['app_id'] . ')"">Remove</a>';
                $return_html .= ' </p>
</div>
</div>';
            }
        } else {
            $return_html .= '<div class="art-img-nn">
    <div class="art_no_post_img">
        <img src="' . base_url('assets/img/job-no.png') . '">
    </div>
    <div class="art_no_post_text">
        No  Applied Job Available.
    </div>
</div>';
        }
        echo $return_html;
    }

//GET JOB APPLY DATA WITH AJAX END
//GET SEARCH DATA WITH AJAX START
    public function ajax_job_search($searchkeyword = "", $searchplace = "") {

        $perpage = 5;
        $page = 1;

        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;

        if ($start < 0)
            $start = 0;


        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

// search keyword insert into database start


        $search_job = $_GET["skill"];
        $search_place = str_replace('-', ' ', trim($_GET["place"]));


        $cache_time = $this->db->get_where('cities', array('city_name' => $search_place))->row()->city_id;


        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $this->data['city'] = $city = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'city_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($this->session->userdata('aileenuser')) {

//Insert Search Data into database start
            $data = array(
                'search_keyword' => $search_job,
                'search_location' => $search_place,
                'user_location' => $city[0]['city_id'],
                'user_id' => $userid,
                'created_date' => date('Y-m-d h:i:s', time()),
                'status' => '1',
                'module' => '1'
            );
            $insert_id = $this->common->insert_data_getid($data, 'search_info');
//Insert Search Data into database End
        }

//Total Search All Start
// search keyword insert into database end
        if ($search_job == "" && $search_place == "") {
            $join_str[0]['table'] = 'recruiter';
            $join_str[0]['join_table_id'] = 'recruiter.user_id';
            $join_str[0]['from_table_id'] = 'rec_post.user_id';
            $join_str[0]['join_type'] = '';

            $data = 'post_id,post_name,post_last_date,post_description,post_skill,post_position,interview_process,min_sal,max_sal,max_year,,min_year,fresher,degree_name,industry_type,emp_type,rec_post.created_date,rec_post.user_id,recruiter.rec_firstname,recruiter.re_comp_name,recruiter.rec_lastname,recruiter.recruiter_user_image,recruiter.profile_background,recruiter.re_comp_profile,city,country,post_currency,salary_type';
            $contition_array = array('recruiter.re_status' => '1', 'recruiter.is_delete' => '0', 'status' => '1', 'rec_post.is_delete' => '0');
            $unique = $this->data['postdata'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data, $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
        } elseif ($search_job == "") {


            $contition_array = array('slug' => $search_place, 'state_id !=' => '0');
            $groupid = $this->common->select_data_by_condition('cities', $contition_array, $data = 'group_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            $contition_array = array('group_id' => $groupid[0]['group_id'], 'status' => '1');
            $citydata = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $city_names = array_column($citydata, 'city_id');

            $city_names = implode(',', $city_names);

            $contition_array = array('re_status' => '1', 'recruiter.user_id !=' => $userid, 'recruiter.re_step' => 3, 'rec_post.is_delete' => '0', 'rec_post.city !=' => '0');

            $join_str[0]['table'] = 'recruiter';
            $join_str[0]['join_table_id'] = 'recruiter.user_id';
            $join_str[0]['from_table_id'] = 'rec_post.user_id';
            $join_str[0]['join_type'] = '';
            $data = 'post_id,post_name,post_last_date,post_description,post_skill,post_position,interview_process,min_sal,max_sal,max_year,,min_year,fresher,degree_name,industry_type,emp_type,rec_post.created_date,rec_post.user_id,recruiter.rec_firstname,recruiter.re_comp_name,recruiter.rec_lastname,recruiter.recruiter_user_image,recruiter.profile_background,recruiter.re_comp_profile,city,country,post_currency,salary_type';
            $search_condition = "city IN ('$city_names')";
            $city_search = $this->data['results'] = $this->common->select_data_by_search('rec_post', $search_condition, $contition_array, $data, $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

            $contition_array = array('country_slug' => $search_place, 'status' => '1');
            $countryid = $this->common->select_data_by_condition('countries', $contition_array, $data = 'country_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $join_str[0]['table'] = 'recruiter';
            $join_str[0]['join_table_id'] = 'recruiter.user_id';
            $join_str[0]['from_table_id'] = 'rec_post.user_id';
            $join_str[0]['join_type'] = '';

            $data = 'post_id,post_name,post_last_date,post_description,post_skill,post_position,interview_process,min_sal,max_sal,max_year,,min_year,fresher,degree_name,industry_type,emp_type,rec_post.created_date,rec_post.user_id,recruiter.rec_firstname,recruiter.re_comp_name,recruiter.rec_lastname,recruiter.recruiter_user_image,recruiter.profile_background,recruiter.re_comp_profile,city,country,post_currency,salary_type';
            $contition_array = array('recruiter.re_status' => '1', 'recruiter.is_delete' => '0', 'status' => '1', 'rec_post.is_delete' => '0', 'rec_post.country' => $countryid[0]['country_id']);
            $country_search = $this->data['postdata'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data, $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

            $unique1 = array_merge((array) $country_search, (array) $city_search);
            foreach ($unique1 as $value) {
                $unique[$value['post_id']] = $value;
            }
        } elseif ($search_place == "") {

            //Search FOr Skill Start
            $temp = $this->db->get_where('skill', array('skill' => $search_job, 'status' => 1))->row()->skill_id;
            $contition_array = array('status' => '1', 'is_delete' => '0', 'user_id != ' => $userid, 'FIND_IN_SET("' . $temp . '", post_skill) != ' => '0');
            $results_skill = $this->common->select_data_by_condition('rec_post', $contition_array, $data = '*', $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            //Search FOr Skill End
            //Search FOr firstname,lastname,companyname,other_skill and concat(firstname,lastname) Start
            $join_str[0]['table'] = 'recruiter';
            $join_str[0]['join_table_id'] = 'recruiter.user_id';
            $join_str[0]['from_table_id'] = 'rec_post.user_id';
            $join_str[0]['join_type'] = '';


            $contition_array = array('recruiter.user_id !=' => $userid, 'recruiter.re_step' => '3', 'rec_post.is_delete' => '0', 'rec_post.status' => '1');

            $data = 'rec_post.post_name,rec_post.post_description,rec_post.post_skill,rec_post.post_position,rec_post.post_last_date,rec_post.min_year,rec_post.min_sal,rec_post.max_sal,rec_post.other_skill,rec_post.user_id,rec_post.post_id,rec_post.country,rec_post.city,rec_post.interview_process,rec_post.max_year,rec_post.created_date,rec_post.industry_type,rec_post.emp_type,rec_post.salary_type,rec_post.degree_name,rec_post.fresher,recruiter.re_comp_profile,rec_post.post_currency';

            $search_condition = "(rec_post.post_name LIKE '%$search_job%' or recruiter.re_comp_name LIKE '%$search_job%' or recruiter.rec_firstname LIKE '%$search_job%' or recruiter.rec_lastname LIKE '%$search_job%' or rec_post.other_skill LIKE '%$search_job%' or concat(
                    rec_firstname,' ',rec_lastname) LIKE '%$search_job%')";



            $results_all = $recpostdata['data'] = $this->common->select_data_by_search('rec_post', $search_condition, $contition_array, $data, $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
            //Search For firstname,lastname,companyname,other_skill and concat(firstname,lastname) End


            $join_str[0]['table'] = 'rec_post';
            $join_str[0]['join_table_id'] = 'rec_post.post_name';
            $join_str[0]['from_table_id'] = 'job_title.title_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('rec_post.user_id !=' => $userid, 'rec_post.is_delete' => '0', 'rec_post.status' => '1');
            $data = 'rec_post.post_name,rec_post.post_description,rec_post.post_skill,rec_post.post_position,rec_post.post_last_date,rec_post.min_year,rec_post.min_sal,rec_post.max_sal,rec_post.other_skill,rec_post.user_id,rec_post.post_id,rec_post.country,rec_post.city,rec_post.interview_process,rec_post.max_year,rec_post.created_date,rec_post.industry_type,rec_post.emp_type,rec_post.salary_type,rec_post.degree_name,rec_post.fresher,rec_post.post_currency';
            $search_condition = "(job_title.slug LIKE '%$search_job%')";
            $results_posttitleid = $recpostdata['data'] = $this->common->select_data_by_search('job_title', $search_condition, $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

            $unique1 = array_merge((array) $results_skill, (array) $results_all, (array) $results_posttitleid);

            $unique = array();
            foreach ($unique1 as $value) {

                $unique[$value['post_id']] = $value;
            }
        } else {
            $cache_time1 = $this->db->get_where('cities', array('city_name' => $search_place))->row()->city_id;

            //Search FOr Skill Start
            $temp = $this->db->get_where('skill', array('skill' => $search_job, 'status' => '1'))->row()->skill_id;
            $contition_array = array('status' => '1', 'is_delete' => '0', 'user_id != ' => $userid, 'city' => $cache_time1, 'FIND_IN_SET("' . $temp . '", post_skill) != ' => '0');
            $results_skill = $this->common->select_data_by_condition('rec_post', $contition_array, $data = '*', $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            //Search FOr Skill End
            //Search FOr firstname,lastname,companyname,other_skill and concat(firstname,lastname) Start
            $join_str[0]['table'] = 'recruiter';
            $join_str[0]['join_table_id'] = 'recruiter.user_id';
            $join_str[0]['from_table_id'] = 'rec_post.user_id';
            $join_str[0]['join_type'] = '';


            $contition_array = array('recruiter.user_id !=' => $userid, 'recruiter.re_step' => 3, 'rec_post.is_delete' => '0', 'rec_post.status' => '1', 'rec_post.city' => $cache_time1);

            $data = 'rec_post.post_name,rec_post.post_description,rec_post.post_skill,rec_post.post_position,rec_post.post_last_date,rec_post.min_year,rec_post.min_sal,rec_post.max_sal,rec_post.other_skill,rec_post.user_id,rec_post.post_id,rec_post.country,rec_post.city,rec_post.interview_process,rec_post.max_year,rec_post.created_date,rec_post.industry_type,rec_post.emp_type,rec_post.salary_type,rec_post.degree_name,rec_post.fresher,recruiter.re_comp_profile,rec_post.post_currency';

            $search_condition = "(rec_post.post_name LIKE '%$search_job%' or recruiter.re_comp_name LIKE '%$search_job%' or recruiter.rec_firstname LIKE '%$search_job%' or recruiter.rec_lastname LIKE '%$search_job%' or rec_post.other_skill LIKE '%$search_job%' or concat(
                    rec_firstname,' ',rec_lastname) LIKE '%$search_job%')";

            $results_all = $recpostdata['data'] = $this->common->select_data_by_search('rec_post', $search_condition, $contition_array, $data, $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
            //Search For firstname,lastname,companyname,other_skill and concat(firstname,lastname) End


            $join_str[0]['table'] = 'rec_post';
            $join_str[0]['join_table_id'] = 'rec_post.post_name';
            $join_str[0]['from_table_id'] = 'job_title.title_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('rec_post.user_id !=' => $userid, 'rec_post.is_delete' => '0', 'rec_post.status' => '1', 'rec_post.city' => $cache_time1);

            $data = 'rec_post.post_name,rec_post.post_description,rec_post.post_skill,rec_post.post_position,rec_post.post_last_date,rec_post.min_year,rec_post.min_sal,rec_post.max_sal,rec_post.other_skill,rec_post.user_id,rec_post.post_id,rec_post.country,rec_post.city,rec_post.interview_process,rec_post.max_year,rec_post.created_date,rec_post.industry_type,rec_post.emp_type,rec_post.salary_type,rec_post.degree_name,rec_post.fresher,rec_post.post_currency';

            $search_condition = "(job_title.slug LIKE '%$search_job%')";
            $results_posttitleid = $recpostdata['data'] = $this->common->select_data_by_search('job_title', $search_condition, $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

            $unique1 = array_merge($results_skill, $results_all, $results_posttitleid);

            $unique = array();
            foreach ($unique1 as $value) {

                $unique[$value['post_id']] = $value;
            }
        }
        $postdetail = $this->data['postdetail'] = $unique;

//Total Search All End

        $postdetail1 = array_slice($postdetail, $start, $perpage);
        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($postdetail);
        }

        $return_html = '';
        $return_html .= '<input type = "hidden" class = "page_number" value = "' . $page . '" />';
        $return_html .= '<input type = "hidden" class = "total_record" value = "' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';
        if (count($postdetail) > 0) {
            foreach ($postdetail1 as $post) {
                $return_html .= '<div class="all-job-box" id="postdata' . $post['post_id'] . '">
                                    <div class="all-job-top">';

                $cache_time_1 = $this->db->get_where('recruiter', array(
                            'user_id' => $post['user_id']
                        ))->row()->comp_logo;

                $cache_time = $this->db->get_where('job_title', array(
                            'title_id' => $post['post_name']
                        ))->row()->name;
                if ($cache_time) {
                    $post_name = $cache_time;
                } else {
                    $post_name = $post['post_name'];
                }
                if ($post_name != '') {
                    $text = strtolower($this->common->clean($post_name));
                } else {
                    $text = '';
                }
                $cityname = $this->db->get_where('cities', array('city_id' => $post['city']))->row()->city_name;
                if ($cityname != '') {
                    $cityname = '-vacancy-in-' . strtolower($this->common->clean($cityname));
                } else {
                    $cityname = '';
                }
                $return_html .= '<div class="post-img">
                                            <a href="' . base_url() . 'recruiter/jobpost/' . $text . $cityname . '-' . $post['user_id'] . '-' . $post['post_id'] . '">';
                if ($cache_time_1) {
                    if (IMAGEPATHFROM == 'upload') {
                        if (!file_exists($this->config->item('rec_profile_thumb_upload_path') . $cache_time)) {
                            $return_html .= '<img src="' . base_url('assets/images/commen-img.png') . '">';
                        } else {
                            $return_html .= '<img src="' . REC_PROFILE_THUMB_UPLOAD_URL . $cache_time_1 . '">';
                        }
                    } else {
                        $filename = $this->config->item('rec_profile_thumb_upload_path') . $cache_time_1;
                        $s3 = new S3(awsAccessKey, awsSecretKey);
                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                        if ($info) {
                            $return_html .= '<img src="' . REC_PROFILE_THUMB_UPLOAD_URL . $cache_time_1 . '">';
                        } else {
                            $return_html .= '<img src="' . base_url('assets/images/commen-img.png') . '">';
                        }
                    }
                } else {
                    $return_html .= '<img src="' . base_url('assets/images/commen-img.png') . '">';
                }
                $return_html .= '</a>
                                        </div>';


                $cache_time1 = $this->db->get_where('recruiter', array(
                            'user_id' => $post['user_id']
                        ))->row()->re_comp_name;

                $cache_time2 = $this->db->get_where('recruiter', array(
                            'user_id' => $post['user_id']
                        ))->row()->rec_firstname;
                $cache_time3 = $this->db->get_where('recruiter', array(
                            'user_id' => $post['user_id']
                        ))->row()->rec_lastname;

                $return_html .= '<div class="job-top-detail">';
                $return_html .= '<h5><a href="' . base_url() . 'recruiter/jobpost/' . $text . $cityname . '-' . $post['user_id'] . '-' . $post['post_id'] . '">';
                $return_html .= $post_name;
                $return_html .= '</a></h5>';
                $return_html .= '<p><a href = "' . base_url() . 'recruiter/jobpost/' . $text . $cityname . '-' . $post['user_id'] . '-' . $post['post_id'] . '">';
                $return_html .= $cache_time1;
                $return_html .= '</a></p>';
                $return_html .= '<p><a href="' . base_url('recruiter/profile/' . $post['user_id']) . '">';
                $return_html .= ucwords($cache_time2) . " " . ucfirst($cache_time3);
                $return_html .= '</a></p>
            </div>
            </div>
            <div class="all-job-middle">
                <p class="pb5">
                    <span class="location">';
                $return_html .= '<span><img class="pr5" src="' . base_url('assets/images/location.png') . '">';
                $cityname = $this->db->get_where('cities', array('city_id' => $post['city']))->row()->city_name;
                $countryname = $this->db->get_where('countries', array('country_id' => $post['country']))->row()->country_name;
                if ($cityname || $countryname) {
                    if ($cityname) {
                        $return_html .= $cityname . ', ';
                    }
                    $return_html .= $countryname;
                }
                $return_html .= '</span>
                    </span>';
                $return_html .= '<span class="exp">
                        <span><img class="pr5" src="' . base_url('assets/images/exp.png') . '">';

                if (($post['min_year'] != '0' || $post['max_year'] != '0') && ($post['fresher'] == 1)) {
                    $return_html .= $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year' . " " . "(Fresher can also apply)";
                } else {
                    if (($post['min_year'] != '0' || $post['max_year'] != '0')) {
                        $return_html .= $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year';
                    } else {
                        $return_html .= "Fresher";
                    }
                }


                $return_html .= '</span>
                    </span>
                </p>
                <p>';

                $rest = substr($post['post_description'], 0, 150);
                $return_html .= $rest;

                if (strlen($post['post_description']) > 150) {
                    $return_html .= '.....<a href="' . base_url() . 'recruiter/jobpost/' . $text . $cityname . '-' . $post['user_id'] . '-' . $post['post_id'] . '">Read more</a>';
                }
                $return_html .= '</p>

            </div>
            <div class="all-job-bottom">
                <span class="job-post-date"><b>Posted on: </b>';
                $return_html .= date('d-M-Y', strtotime($post['created_date']));
                $return_html .= '</span>
                <p class="pull-right">';
                $return_html .= '<input type="hidden" name="search" id="search" value="' . $keyword . '">';
                $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
                $contition_array = array('post_id' => $post['post_id'], 'job_delete' => '0', 'user_id' => $userid);
                $jobsave = $this->data['jobsave'] = $this->common->select_data_by_condition('job_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');


                if ($jobsave) {
                    $return_html .= '<a href="javascript:void(0);" class="btn4 button applied">Applied</a>';
                } else {

                    $return_html .= '<a href="javascript:void(0);"  class= "btn4 applypost' . $post['post_id'] . '"';
                    if ($this->session->userdata('aileenuser')) {
                        $return_html .= 'onclick="applypopup(' . $post['post_id'] . ', ' . $post['user_id'] . ')"';
                    } else {
                        $return_html .= 'onClick="create_profile_apply(' . $post['post_id'] . ')"';
                    }
                    $return_html .= '>Apply</a>';

                    $userid = $this->session->userdata('aileenuser');
                    $contition_array = array('user_id' => $userid, 'job_save' => '2', 'post_id ' => $post['post_id'], 'job_delete' => '1');
                    $jobsave = $this->data['jobsave'] = $this->common->select_data_by_condition('job_apply', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    if ($jobsave) {
                        $return_html .= '<a href="javascript:void(0);" class="btn4 saved savedpost' . $post['post_id'] . '">Saved</a>';
                    } else {

                        $return_html .= '<a href="javascript:void(0);" id="' . $post['post_id'] . '"';
                        if ($this->session->userdata('aileenuser')) {
                            $return_html .= 'onClick="savepopup(' . $post['post_id'] . ')" ';
                        } else {
                            $return_html .= 'onClick="login_profile()"';
                        }

                        if ($this->session->userdata('aileenuser')) {
                            $return_html .= 'class="btn4 savedpost' . $post['post_id'] . '">Save</a>';
                        }
                    }
                }

                $return_html .= ' </p>

</div>
</div>';
            }//foreach end
        }//if end
        else {
            $return_html .= '<div class="text-center rio">
                                                <h1 class="page-heading  product-listing" style="border:0px;margin-bottom: 11px;">Oops No Data Found.</h1>
                                                <p style="margin-left:4%;text-transform:none !important;border:0px;">We couldn' . "'" . 't find what you were looking for.</p>
                                                <ul>
                                                    <li style="text-transform:none !important; list-style: none;">Make sure you used the right keywords.</li>
                                                </ul>
                                            </div>';
        }

        echo $return_html;
    }

    //GET SEARCH DATA WITH AJAX END
    // CREATE SLUG START
    public function setcategory_slug($slugname, $filedname, $tablename, $notin_id = array()) {
        $slugname = $oldslugname = $this->create_slug($slugname);
        $i = 1;
        while ($this->comparecategory_slug($slugname, $filedname, $tablename, $notin_id) > 0) {
            $slugname = $oldslugname . '-' . $i;
            $i++;
        }return $slugname;
    }

    public function comparecategory_slug($slugname, $filedname, $tablename, $notin_id = array()) {
        $this->db->where($filedname, $slugname);
        if (isset($notin_id) && $notin_id != "" && count($notin_id) > 0 && !empty($notin_id)) {
            $this->db->where($notin_id);
        }
        $num_rows = $this->db->count_all_results($tablename);
        return $num_rows;
    }

    public function create_slug($string) {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower(stripslashes($string)));
        $slug = preg_replace('/[-]+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }

    // CREATE SLUG END
    public function ajax_recommen_job1() {

        $perpage = 5;
        $page = 1;

        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;

        if ($start < 0)
            $start = 0;
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        $userid = $this->session->userdata('aileenuser');


        //JOB CHANGES START
        // job seeker detail

        $contition_array = array(
            'user_id' => $userid,
            'is_delete' => '0',
            'status' => '1'
        );
        $jobdata = $this->data['jobdata'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'keyskill,work_job_title,work_job_industry,work_job_city', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $job_city = $jobdata[0]['work_job_city'];
        $job_title = $jobdata[0]['work_job_title'];
        $job_industry = $jobdata[0]['work_job_industry'];
        $job_skill = $jobdata[0]['keyskill'];

        // post detail
        // FETCH SKILL WISE JOB START
        $jobcity = explode(',', $jobdata[0]['work_job_city']);
        $jobcity = array_filter(array_map('trim', $jobcity));


        foreach ($jobcity as $city) {
            $contition_array = array('is_delete' => '0', 'status' => '1', 'FIND_IN_SET("' . $city . '", city) != ' => '0');
            $postdata = $this->common->select_data_by_condition('rec_post', $contition_array, $data = 'post_id', $sortby = 'post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if ($postdata) {
                $postlist[] = $postdata;
            }
        }
        $postlistarray = array_reduce($postlist, 'array_merge', array());

        foreach ($postlistarray as $postdata) {

            // FETCH SKILL WISE JOB START
            $job_skill = explode(',', $job_skill);
            $job_skill = array_filter(array_map('trim', $job_skill));
            $skillpost = array();

            foreach ($job_skill as $skill) {
                if ($skill != '') {
                    $contition_array = array('is_delete' => '0', 'status' => '1', 'FIND_IN_SET("' . $skill . '", post_skill) != ' => '0', 'post_id' => $postdata['post_id']);
                    $skillpost[] = $this->common->select_data_by_condition('rec_post', $contition_array, $data = 'post_id', $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                }
            }

            $skillaarray = array_reduce($skillpost, 'array_merge', array());

            // FETCH SKILL WISE JOB END
            // FETCH TITLE WISE JOB END
            $titlepost = array();
            $contition_array = array('is_delete' => '0', 'status' => '1', 'FIND_IN_SET("' . $job_title . '", post_name) != ' => '0', 'post_id' => $postdata['post_id']);
            $titlepost[] = $this->common->select_data_by_condition('rec_post', $contition_array, $data = 'post_id', $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $titlearray = array_reduce($titlepost, 'array_merge', array());
            // FETCH TITLE WISE JOB END
            // FETCH INDUSTERY WISE JOB END
            $indpost = array();
            $contition_array = array('is_delete' => '0', 'status' => '1', 'FIND_IN_SET("' . $job_industry . '", industry_type) != ' => '0', 'post_id' => $postdata['post_id']);
            $indpost[] = $this->common->select_data_by_condition('rec_post', $contition_array, $data = 'post_id', $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $indarray = array_reduce($indpost, 'array_merge', array());
            // FETCH INDUSTERY WISE JOB END

            $recommendata = array_merge((array) $titlearray, (array) $skillaarray, (array) $indarray);

            $recommendata[] = array_reduce($recommendata, 'array_merge', array());
            $newdata[] = array_unique($recommendata, SORT_REGULAR);
        }
        $recommanarray = array_reduce($newdata, 'array_merge', array());
        $postdetail = array_unique($recommanarray, SORT_REGULAR);

//JOB CHANGES END

        $postdetail1 = array_slice($postdetail, $start, $perpage);

        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($postdetail);
        }

        $return_html = '';
        $return_html .= '<input type = "hidden" class = "page_number" value = "' . $page . '" />';
        $return_html .= '<input type = "hidden" class = "total_record" value = "' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';

        if (count($postdetail) > 0) {
            foreach ($postdetail1 as $postdetaildata) {
                foreach ($postdetaildata as $post) {
                    $return_html .= '
                <div class="profile-job-post-detail clearfix" id="applypost' . $post['app_id'] . '">
                <div class = "profile-job-post-title clearfix">
                <div class = "profile-job-profile-button clearfix">
                <div class = "profile-job-details col-md-12 col-xs-12  padding_job_rs">
                <ul>
                        <li class="fr date_re">
                              Created Date :' . date('d-M-Y', strtotime($post['created_date'])) . '
                        </li>

                        <li>';

                    //FOR POSTTITLE CLICK URL THAT SEO WANT START
                    $cache_time = $this->db->get_where('job_title', array(
                                'title_id' => $post['post_name']
                            ))->row()->name;

                    if ($cache_time) {
                        $cache_time1 = $cache_time;
                    } else {
                        $cache_time1 = $post['post_name'];
                    }

                    $text = str_replace(" ", "-", $cache_time1);
                    $text = preg_replace("/[.!$#%()]+/i", "", $text);
                    $text = strtolower($text);

                    $cache_time1 = $this->db->get_where('cities', array('city_id' => $post['city']))->row()->city_name;

                    $cityname = str_replace(" ", "-", $cache_time1);
                    $cityname = preg_replace("/[.!$#%()]+/i", "", $cityname);
                    $cityname = strtolower($cityname);

                    $contition_array = array('user_id' => $post['user_id'], 're_status' => '1', 'is_delete' => '0');
                    $recrdata = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 're_comp_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $return_html .= '<a href="' . base_url('job/post-' . $post['post_id'] . '/' . $text . '-vacancy-in-' . $cityname) . '" title="' . $cache_time . '" class=" post_title">';
                    if ($cache_time) {
                        $return_html .= $cache_time;
                    } else {
                        $return_html .= $post['post_name'];
                    }
                    //FOR POSTTITLE CLICK URL THAT SEO WANT END

                    $return_html .= '</a></li><li>';
                    $cityname = $this->db->get_where('cities', array(
                                'city_id' => $post['city']
                            ))->row()->city_name;
                    $countryname = $this->db->get_where('countries', array(
                                'country_id' => $post['country']
                            ))->row()->country_name;
                    if ($countryname || $cityname) {
                        $return_html .= '<div class="fr lction">
                                 <p title="Location"><i class="fa fa-map-marker" aria-hidden="true"></i>';
                        if ($cityname) {
                            $return_html .= $cityname . ', ';
                        }

                        $return_html .= $countryname . '</p></div>';
                    }

                    $cache_time1 = $this->db->get_where('recruiter', array(
                                'user_id' => $post['user_id']
                            ))->row()->re_comp_name;
                    $return_html .= '<a class="job_companyname "  href="' . base_url('recruiter/profile/' . $post['user_id']) . '" title="' . $cache_time1 . '">';
                    $out = strlen($cache_time1) > 40 ? substr($cache_time1, 0, 40) . "..." : $cache_time1;
                    $return_html .= $out . '</a></li>';
                    $return_html .= '<li><a class="display_inline" title="Recruiter Name" href="' . base_url('recruiter/profile/' . $post['user_id']) . '">';
                    $cache_time = $this->db->get_where('recruiter', array(
                                'user_id' => $post['user_id']
                            ))->row()->rec_firstname;
                    $cache_time1 = $this->db->get_where('recruiter', array(
                                'user_id' => $post['user_id']
                            ))->row()->rec_lastname;
                    $return_html .= ucwords($cache_time) . "  " . ucwords($cache_time1) . '</a></li>';
                    $return_html .= '</ul></div></div>';
                    $return_html .= '<div class="profile-job-profile-menu">
                                       <ul class="clearfix">
                                          <li> <b> Skills</b> <span>';
                    $comma = ",";
                    $k = 0;
                    $aud = $post['post_skill'];
                    $aud_res = explode(',', $aud);
                    if (!$post['post_skill']) {
                        $return_html .= $post['other_skill'];
                    } else
                    if (!$post['other_skill']) {
                        foreach ($aud_res as $skill) {
                            if ($k != 0) {
                                $return_html .= $comma;
                            }

                            $cache_time = $this->db->get_where('skill', array(
                                        'skill_id' => $skill
                                    ))->row()->skill;
                            $return_html .= $cache_time;
                            $k++;
                        }
                    } else
                    if ($post['post_skill'] && $post['other_skill']) {
                        foreach ($aud_res as $skill) {
                            if ($k != 0) {
                                $return_html .= $comma;
                            }

                            $cache_time = $this->db->get_where('skill', array(
                                        'skill_id' => $skill
                                    ))->row()->skill;
                            $return_html .= $cache_time;
                            $k++;
                        }

                        $return_html .= ',' . $post['other_skill'];
                    }

                    $return_html .= '</span></li><li>
                                  <b>Job Description</b>
                              <span><p>';
                    if ($post['post_description']) {
                        $return_html .= '<pre>' . $this->common->make_links($post['post_description']) . '</pre>';
                    } else {
                        $return_html .= PROFILENA;
                    }

                    $return_html .= '</p></span></li>';
                    $return_html .= '<li><b>Interview Process</b>
                                                                    <span><pre>';
                    if ($post['interview_process']) {
                        $return_html .= $this->common->make_links($post['interview_process']);
                    } else {
                        $return_html .= PROFILENA;
                    }

                    $return_html .= '</pre></span></li>';
                    $return_html .= '<li><b>Required Experience</b><span><p title="Min - Max">';
                    if (($post['min_year'] != '0' || $post['max_year'] != '0') && ($post['fresher'] == 1)) {
                        $return_html .= $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year' . " , " . "Fresher can also apply.";
                    } else
                    if (($post['min_year'] != '0' || $post['max_year'] != '0')) {
                        $return_html .= $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year';
                    } else {
                        $return_html .= "Fresher";
                    }

                    $return_html .= '</p></span></li>';
                    $return_html .= '<li><b>Salary</b><span title="Min - Max">';
                    $currency = $this->db->get_where('currency', array(
                                'currency_id' => $post['post_currency']
                            ))->row()->currency_name;
                    if ($post['min_sal'] || $post['max_sal']) {
                        $return_html .= $post['min_sal'] . " - " . $post['max_sal'] . ' ' . $currency . ' ' . $post['salary_type'];
                    } else {
                        $return_html .= PROFILENA;
                    }

                    $return_html .= '</span></li>';
                    $return_html .= '<li><b>No of Position</b><span>' . $post['post_position'] . ' ' . 'Position</span></li>';
                    $return_html .= '<li><b>Industry Type</b> <span>';
                    $cache_time = $this->db->get_where('job_industry', array(
                                'industry_id' => $post['industry_type']
                            ))->row()->industry_name;
                    $return_html .= $cache_time . '</span></li>';
                    if ($post['degree_name'] != '' || $post['other_education'] != '') {
                        $return_html .= '<li> <b>Education Required</b> <span> ';
                        $comma = ", ";
                        $k = 0;
                        $edu = $post['degree_name'];
                        $edu_nm = explode(',', $edu);
                        if (!$post['degree_name']) {
                            $return_html .= $post['other_education'];
                        } else
                        if (!$post['other_education']) {
                            foreach ($edu_nm as $edun) {
                                if ($k != 0) {
                                    $return_html .= $comma;
                                }

                                $cache_time = $this->db->get_where('degree', array(
                                            'degree_id' => $edun
                                        ))->row()->degree_name;
                                $return_html .= $cache_time;
                                $k++;
                            }
                        } else
                        if ($post['degree_name'] && $post['other_education']) {
                            foreach ($edu_nm as $edun) {
                                if ($k != 0) {
                                    $return_html .= $comma;
                                }

                                $cache_time = $this->db->get_where('degree', array(
                                            'degree_id' => $edun
                                        ))->row()->degree_name;
                                $return_html .= $cache_time;
                                $k++;
                            }

                            $return_html .= "," . $post['other_education'];
                        }

                        $return_html .= '</span> </li>';
                    } else {
                        $return_html .= '<li><b>Education Required</b><span>' . PROFILENA . '</span></li>';
                    }

                    $return_html .= '<li><b>Employment Type</b><span>';
                    if ($post['emp_type'] != '') {
                        $return_html .= '<pre>' . $this->common->make_links($post['emp_type']) . '  Job</pre>';
                    } else {
                        $return_html .= PROFILENA;
                    }

                    $return_html .= '</span></li>';
                    $return_html .= '<li><b>Company Profile</b><span>';
                    $currency = $this->db->get_where('recruiter', array(
                                'user_id' => $post['user_id']
                            ))->row()->re_comp_profile;
                    if ($currency != '') {
                        $return_html .= '<pre>' . $this->common->make_links($currency) . '</pre>';
                    } else {
                        $return_html .= PROFILENA;
                    }

                    $return_html .= '</span></li>';
                    $return_html .= '</ul></div>';
                    $return_html .= '<div class="profile-job-profile-button clearfix">
                                                            <div class="profile-job-details col-md-12 col-xs-12">
                                                                <ul>';
                    $return_html .= '<li class="job_all_post last_date">Last Date :';
                    if ($post['post_last_date'] != "0000-00-00") {
                        $return_html .= date('d-M-Y', strtotime($post['post_last_date']));
                    } else {
                        $return_html .= PROFILENA;
                    }

                    $return_html .= '</li>';
                    $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
                    $contition_array = array(
                        'post_id' => $post['post_id'],
                        'job_delete' => 0,
                        'user_id' => $userid
                    );
                    $jobsave = $this->data['jobsave'] = $this->common->select_data_by_condition('job_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    if ($jobsave) {
                        $return_html .= '<a href="javascript:void(0);" class="button applied">Applied</a>';
                    } else {
                        $return_html .= '<li class="fr"><a href="javascript:void(0);"  class= "applypost' . $post['post_id'] . '  button" onclick="applypopup(' . $post['post_id'] . ', ' . $post['user_id'] . ')">Apply</a></li>';
                        $return_html .= '<li class="fr">';
                        $userid = $this->session->userdata('aileenuser');
                        $contition_array = array(
                            'user_id' => $userid,
                            'job_save' => '2',
                            'post_id ' => $post['post_id'],
                            'job_delete' => '1'
                        );
                        $jobsave = $this->data['jobsave'] = $this->common->select_data_by_condition('job_apply', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                        if ($jobsave) {
                            $return_html .= '<a class="button saved save_saved_btn">Saved</a>';
                        } else {
                            $return_html .= '<a title="Save" id="' . $post['post_id'] . '" onClick="savepopup(' . $post['post_id'] . ')" href="javascript:void(0);" class="savedpost' . $post['post_id'] . ' button save_saved_btn">Save</a>';
                        }

                        $return_html .= '</li>';
                    }
                    $return_html .= '</ul></div></div>';
                    $return_html .= '</div></div>';
                }//foreach ($postdetail1 as $post) end
            }//foreach ($postdetail as $post_key => $postdetail1) end
        }//if (count($postdetail) > 0) end
        else {

            $return_html .= '<div class="art-img-nn">
                                                    <div class="art_no_post_img">
                                                        <img src="' . base_url('assets/img/job-no.png') . '">
                                                    </div>
                                                    <div class="art_no_post_text">
                                                        No  Recommended Job Available.
                                                    </div>
                                                </div>';
        }//else end

        echo $return_html;
    }

    //GET JOB ALL POST DATA WITH AJAX END
    // JOB POST FETCH DATA START
    public function job_rec_data($string = "") {

        $userid = $this->session->userdata('aileenuser');


        //JOB CHANGES START
        // job seeker detail

        $contition_array = array(
            'user_id' => $userid,
            'is_delete' => '0',
            'status' => '1'
        );
        $jobdata = $this->data['jobdata'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'keyskill,work_job_title,work_job_industry,work_job_city', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $job_city = $jobdata[0]['work_job_city'];
        $job_title = $jobdata[0]['work_job_title'];
        $job_industry = $jobdata[0]['work_job_industry'];
        $job_skill = $jobdata[0]['keyskill'];

        // post detail
        // FETCH SKILL WISE JOB START
        $jobcity = explode(',', $jobdata[0]['work_job_city']);
        $jobcity = array_filter(array_map('trim', $jobcity));


        foreach ($jobcity as $city) {
            $contition_array = array('is_delete' => '0', 'status' => '1', 'FIND_IN_SET("' . $city . '", city) != ' => '0');
            $postdata = $this->common->select_data_by_condition('rec_post', $contition_array, $data = 'post_id', $sortby = 'post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if ($postdata) {
                $postlist[] = $postdata;
            }
        }
        $postlistarray = array_reduce($postlist, 'array_merge', array());

        foreach ($postlistarray as $postdata) {

            // FETCH SKILL WISE JOB START
            $job_skill = explode(',', $job_skill);
            $job_skill = array_filter(array_map('trim', $job_skill));
            $skillpost = array();

            foreach ($job_skill as $skill) {
                if ($skill != '') {
                    $contition_array = array('is_delete' => '0', 'status' => '1', 'FIND_IN_SET("' . $skill . '", post_skill) != ' => '0', 'post_id' => $postdata['post_id']);
                    $skillpost[] = $this->common->select_data_by_condition('rec_post', $contition_array, $data = 'post_id', $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                }
            }

            $skillaarray = array_reduce($skillpost, 'array_merge', array());

            // FETCH SKILL WISE JOB END
            // FETCH TITLE WISE JOB END
            $titlepost = array();
            $contition_array = array('is_delete' => '0', 'status' => '1', 'FIND_IN_SET("' . $job_title . '", post_name) != ' => '0', 'post_id' => $postdata['post_id']);
            $titlepost[] = $this->common->select_data_by_condition('rec_post', $contition_array, $data = 'post_id', $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $titlearray = array_reduce($titlepost, 'array_merge', array());
            // FETCH TITLE WISE JOB END
            // FETCH INDUSTERY WISE JOB END
            $indpost = array();
            $contition_array = array('is_delete' => '0', 'status' => '1', 'FIND_IN_SET("' . $job_industry . '", industry_type) != ' => '0', 'post_id' => $postdata['post_id']);
            $indpost[] = $this->common->select_data_by_condition('rec_post', $contition_array, $data = 'post_id', $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $indarray = array_reduce($indpost, 'array_merge', array());
            // FETCH INDUSTERY WISE JOB END

            $recommendata = array_merge((array) $titlearray, (array) $skillaarray, (array) $indarray);
            //echo '<pre>';  print_r($recommendata); die();
            $recommendata[] = array_reduce($recommendata, 'array_merge', array());
            $newdata[] = array_unique($recommendata, SORT_REGULAR);
        }
        $recommanarray = array_reduce($newdata, 'array_merge', array());
        $recommanarray = array_unique($recommanarray, SORT_REGULAR);

//JOB CHANGES END
    }

// RECRUITER RECOMMANDED FUNCTION END
// JOB POST FETCH DATA END
//FOR PROGRESSBAR COUNT COMMON FUNCTION START
    public function progressbar() {
        $userid = $this->session->userdata('aileenuser');
        //For Counting Profile data start
        $contition_array = array('user_id' => $userid, 'status' => '1', 'is_delete' => '0');

        $this->data['job_reg'] = $job_reg = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'fname,lname,email,experience,keyskill,work_job_title,work_job_industry,work_job_city,phnno,language,dob,gender,city_id,pincode,address,project_name,project_duration,project_description,training_as,training_duration,training_organization,progressbar', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = array());

        $count = 0;

        if ($job_reg[0]['fname'] != '') {
            $count++;
        }
        if ($job_reg[0]['lname'] != '') {
            $count++;
        }
        if ($job_reg[0]['email'] != '') {
            $count++;
        }
        if ($job_reg[0]['keyskill'] != '') {
            $count++;
        }

        if ($job_reg[0]['work_job_title'] != '') {
            $count++;
        }
        if ($job_reg[0]['work_job_industry'] != '') {
            $count++;
        }
        if ($job_reg[0]['work_job_city'] != '') {
            $count++;
        }
        if ($job_reg[0]['phnno'] != '') {
            $count++;
        }
        if ($job_reg[0]['language'] != '') {
            $count++;
        }
        if ($job_reg[0]['dob'] != '0000-00-00') {
            $count++;
        }
        if ($job_reg[0]['gender'] != '') {
            $count++;
        }
        if ($job_reg[0]['city_id'] != '0') {
            $count++;
        }
        if ($job_reg[0]['pincode'] != '') {
            $count++;
        }
        if ($job_reg[0]['address'] != '') {
            $count++;
        }
        if ($job_reg[0]['project_name'] != '') {
            $count++;
        }
        if ($job_reg[0]['project_duration'] != '') {
            $count++;
        }
        if ($job_reg[0]['project_description'] != '') {
            $count++;
        }
        if ($job_reg[0]['training_as'] != '') {
            $count++;
        }
        if ($job_reg[0]['training_duration'] != '') {
            $count++;
        }
        if ($job_reg[0]['training_organization'] != '') {
            $count++;
        }

        $contition_array = array('user_id' => $userid, 'status' => '1', 'is_delete' => '0');
        $this->data['job_add_edu'] = $job_add_edu = $this->common->select_data_by_condition('job_add_edu', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('user_id' => $userid);
        $this->data['jobgrad'] = $jobgrad = $this->common->select_data_by_condition('job_graduation', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        if ($job_add_edu[0]['board_primary'] != '' || $job_add_edu[0]['board_secondary'] != '' || $job_add_edu[0]['board_higher_secondary'] != '' || $jobgrad[0]['degree'] != '') {
            $count++;
        }
        if (($job_add_edu[0]['board_primary'] != '' && $job_add_edu[0]['edu_certificate_primary'] != '') || ($job_add_edu[0]['board_secondary'] != '' && $job_add_edu[0]['edu_certificate_secondary'] != '') || ($job_add_edu[0]['board_higher_secondary'] != '' && $job_add_edu[0]['edu_certificate_higher_secondary'] != '') || ($jobgrad[0]['degree'] != '' && $jobgrad[0]['grade'] != '' && $jobgrad[0]['edu_certificate'] != '')) {
            $count++;
        }


        $contition_array = array('user_id' => $userid, 'experience !=' => 'Fresher', 'status' => 1);
        $workdata = $this->common->select_data_by_condition('job_add_workexp', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        if (($job_reg[0]['experience'] != '' && $job_reg[0]['experience'] != 'Experience') || ($workdata[0]['experience_year'] != '' && $workdata[0]['companyemail'] != '' && $workdata[0]['companyphn'] != '' && $workdata[0]['work_certificate'] != '')) {
            $count++;
        }

        $count_profile = ($count * 100) / 23;
        $this->data['count_profile'] = $count_profile;
        $this->data['count_profile_value'] = ($count_profile / 100);

        if ($this->data['count_profile'] == 100) {
            if ($job_reg[0]['progressbar'] != 1) {
                $data = array(
                    'progressbar' => '0',
                    'modified_date' => date('Y-m-d h:i:s', time())
                );
                $updatedata = $this->common->update_data($data, 'job_reg', 'user_id', $userid);
            }
        } else {
            $data = array(
                'progressbar' => '0',
                'modified_date' => date('Y-m-d h:i:s', time())
            );
            $updatedata = $this->common->update_data($data, 'job_reg', 'user_id', $userid);
        }
    }

//FOR PROGRESSBAR COUNT COMMON FUNCTION END
//FOR RECRUITER POST STA RT
    public function post($id = "") {
        //echo $id;
        $user_id = $this->db->get_where('rec_post', array('post_id' => $id))->row()->user_id;

        $contition_array = array('user_id' => $user_id, 'is_delete' => '0', 're_status' => '1');
        $this->data['rec_data'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('user_id' => $user_id, 'is_delete' => '0', 'status' => '1', 'post_id' => $id);
        $rec_post = $this->data['rec_post'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data = 'post_id,post_name,city', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $cache_time = $this->db->get_where('job_title', array('title_id' => $rec_post[0]['post_name']))->row()->name;

        if ($cache_time) {
            $cache_time1 = $cache_time;
        } else {
            $cache_time1 = $rec_post[0]['post_name'];
        }


        $text = str_replace(" ", "-", $cache_time1);
        $text = preg_replace("/[.!$#%()]+/i", "", $text);
        $this->data['text'] = $text = strtolower($text);

        $cache_time2 = $this->db->get_where('cities', array('city_id' => $rec_post[0]['city']))->row()->city_name;

        $cityname = str_replace(" ", "-", $cache_time2);
        $cityname = preg_replace("/[.!$#%()]+/i", "", $cityname);
        $this->data['cityname'] = strtolower($cityname);

        $this->data['title'] = $cache_time1 . " Job Vacancy in " . $cache_time2 . " - Aileensoul.com";

        //THIS CODE IS FOR WHEN USER NOT LOGIN AND GET SEARCH DATA START
        if ($this->session->userdata('aileenuser')) {
            $this->load->view('job/recruiter_post', $this->data);
        } else {

            $this->load->view('job/recruiter_post_login', $this->data);
        }
        //THIS CODE IS FOR WHEN USER NOT LOGIN AND GET SEARCH DATA END
    }

//FOR RECRUITER POST END
// RECRUITER POST AJAX LAZZY LOADER DATA START
    public function ajax_rec_post() {

        $id = $_GET["id"];
        $postid = $_GET["postid"];
// LAZY LOADER CODE START
        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;

//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE START
        $contition_array = array('user_id' => $id, 're_status' => '0', 'is_delete' => '0');
        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE END


        $contition_array = array('user_id' => $id, 'is_delete' => '0', 're_status' => '0');
        $postdataone = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id,rec_firstname,rec_lastname,recruiter_user_image,profile_background,designation', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

        $limit = $perpage;
        $offset = $start;

        $join_str[0]['table'] = 'recruiter';
        $join_str[0]['join_table_id'] = 'recruiter.user_id';
        $join_str[0]['from_table_id'] = 'rec_post.user_id';
        $join_str[0]['join_type'] = '';

        $data = 'post_id,post_name,post_last_date,post_description,post_skill,post_position,interview_process,min_sal,max_sal,max_year,min_year,fresher,degree_name,industry_type,emp_type,rec_post.created_date,rec_post.user_id,recruiter.rec_firstname,recruiter.re_comp_name,recruiter.rec_lastname,recruiter.recruiter_user_image,recruiter.profile_background,recruiter.re_comp_profile,city,country';

        $contition_array = array('rec_post.user_id' => $id, 'rec_post.is_delete' => '0', 'rec_post.post_id' => $postid);
        $rec_postdata = $this->common->select_data_by_condition('rec_post', $contition_array, $data, $sortby = 'post_id', $orderby = 'desc', $limit, $offset, $join_str, $groupby = '');

        $rec_postdata1 = $this->common->select_data_by_condition('rec_post', $contition_array, $data, $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');


        $rec_post = "";

        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($rec_postdata1);
        }

        $rec_post .= '<input type = "hidden" class = "page_number" value = "' . $page . '" />';
        $rec_post .= '<input type = "hidden" class = "total_record" value = "' . $_GET["total_record"] . '" />';
        $rec_post .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';

// LAZY LOADER CODE END
        // code start
        $returnpage = $_GET['returnpage'];
        if (count($rec_postdata1) > 0) {


            $rec_post .= '<div class="profile-job-post-detail clearfix" id="removepost"' . $rec_postdata[0]['post_id'] . '">';
            $rec_post .= '<div class="profile-job-post-title clearfix">';
            $rec_post .= '<div class="profile-job-profile-button clearfix">';
            $rec_post .= '<div class="profile-job-details col-md-12">';
            $rec_post .= '<ul>';
            $rec_post .= '<li class="fr date_re">';
            $rec_post .= 'Created Date : ' . date('d-M-Y', strtotime($rec_postdata[0]['created_date'])) . '';
            $rec_post .= '</li>
                             <li class="">
                             <a class="post_title" href="javascript:void(0)" title="Post Title">';
            $cache_time = $this->db->get_where('job_title', array('title_id' => $rec_postdata[0]['post_name']))->row()->name;
            if ($cache_time) {
                $rec_post .= '' . $cache_time . '';
            } else {
                $rec_post .= '' . $rec_postdata[0]['post_name'] . '';
            }
            $rec_post .= '</a> </li><li>';
            $cityname = $this->db->get_where('cities', array('city_id' => $rec_postdata[0]['city']))->row()->city_name;
            $countryname = $this->db->get_where('countries', array('country_id' => $rec_postdata[0]['country']))->row()->country_name;
            if ($cityname || $countryname) {
                $rec_post .= '<div class="fr lction">';
                $rec_post .= '<p title="Location"><i class="fa fa-map-marker" aria-hidden="true"></i> ';

                if ($cityname) {
                    $rec_post .= '' . $cityname . ', ';
                }

                $rec_post .= '' . $countryname . '';
                $rec_post .= '</p>
                                                                            </div>';
            }

            $rec_post .= '<a class="display_inline" title="' . $rec_postdata[0]['re_comp_name'] . '" href="javascript:void(0)">';

            $out = strlen($rec_postdata[0]['re_comp_name']) > 40 ? substr($rec_postdata[0]['re_comp_name'], 0, 40) . "..." : $rec_postdata[0]['re_comp_name'];
            $rec_post .= '' . $out . '';
            $rec_post .= '</a></li>';
            $rec_post .= '<li class="fw"><a class="display_inline" title="Recruiter Name" href="javascript:void(0)">';
            $rec_post .= '' . ucfirst(strtolower($rec_postdata[0]['rec_firstname'])) . ' ' . ucfirst(strtolower($rec_postdata[0]['rec_lastname'])) . '</a></li>';
            $rec_post .= '</ul></div></div>';
            $rec_post .= '<div class="profile-job-profile-menu">';
            $rec_post .= '<ul class="clearfix"><li> <b> Skills</b> <span>';

            $comma = ", ";
            $k = 0;
            $aud = $rec_postdata[0]['post_skill'];
            $aud_res = explode(',', $aud);
            if (!$rec_postdata[0]['post_skill']) {
                $rec_post .= '' . $rec_postdata[0]['other_skill'] . '';
            } else if (!$rec_postdata[0]['other_skill']) {
                foreach ($aud_res as $skill) {
                    $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;
                    if ($cache_time != " ") {
                        if ($k != 0) {
                            $rec_post .= '' . $comma . '';
                        }
                        $rec_post .= '' . $cache_time . '';
                        $k++;
                    }
                }
            } else if ($rec_postdata[0]['post_skill'] && $rec_postdata[0]['other_skill']) {
                foreach ($aud_res as $skill) {
                    if ($k != 0) {
                        $rec_post .= '' . $comma . '';
                    }
                    $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;
                    $rec_post .= '' . $cache_time . '';
                    $k++;
                } $rec_post .= '","' . $rec_postdata[0]['other_skill'] . '';
            }

            $rec_post .= '</span>
                                                                </li>
                                                                <li><b>Job Description</b><span><pre>';
            $rec_post .= '' . $this->common->make_links($rec_postdata[0]['post_description']) . '</pre></span>';
            $rec_post .= '</li>
                                                                            <li><b>Interview Process</b><span>';
            if ($post['interview_process'] != '') {

                $rec_post .= '' . $this->common->make_links($rec_postdata[0]['interview_process']) . '';
            } else {
                $rec_post .= '' . PROFILENA . '';
            }

            $rec_post .= '</span></li>';


            $rec_post .= '<li>   <b>Required experience</b></li>
                                                                            <li><b>Salary</b><span title="Min - Max" >';
            $currency = $this->db->get_where('currency', array('currency_id' => $rec_postdata[0]['post_currency']))->row()->currency_name;
            if ($rec_postdata[0]['min_sal'] || $rec_postdata[0]['max_sal']) {
                $rec_post .= '' . $rec_postdata[0]['min_sal'] . " - " . $rec_postdata[0]['max_sal'] . ' ' . $currency . ' ' . $rec_postdata[0]['salary_type'] . '';
            } else {
                $rec_post .= '' . PROFILENA . '';
            }

            $rec_post .= '</span></li><li><b>No of Position</b><span>' . $rec_postdata[0]['post_position'] . ' ' . 'Position</span> </li>
                                                                            <li><b>Industry Type</b> <span>';

            $cache_time = $this->db->get_where('job_industry', array('industry_id' => $rec_postdata[0]['industry_type']))->row()->industry_name;
            $rec_post .= '' . $cache_time . '';

            $rec_post .= '</span> </li>';



            if ($rec_postdata[0]['degree_name'] != '' || $rec_postdata[0]['other_education'] != '') {

                $rec_post .= '<li> <b>Required education</b> <span>';
                $comma = ", ";
                $k = 0;
                $edu = $rec_postdata[0]['degree_name'];
                $edu_nm = explode(',', $edu);

                if (!$rec_postdata[0]['degree_name']) {

                    $rec_post .= '' . $rec_postdata[0]['other_education'] . '';
                } else if (!$rec_postdata[0]['other_education']) {
                    foreach ($edu_nm as $edun) {
                        if ($k != 0) {
                            $rec_post .= '' . $comma . '';
                        }
                        $cache_time = $this->db->get_where('degree', array('degree_id' => $edun))->row()->degree_name;


                        $rec_post .= '' . $cache_time . '';
                        $k++;
                    }
                } else if ($rec_postdata[0]['degree_name'] && $rec_postdata[0]['other_education']) {
                    foreach ($edu_nm as $edun) {
                        if ($k != 0) {
                            $rec_post .= '' . $comma . '';
                        }
                        $cache_time = $this->db->get_where('degree', array('degree_id' => $edun))->row()->degree_name;


                        $rec_post .= '' . $cache_time . '';
                        $k++;
                    } $rec_post .= '","' . $rec_postdata[0]['other_education'] . '';
                }


                $rec_post .= '</span>
                                                                            </li>';
            } else {

                $rec_post .= '<li><b>Required education</b><span>';
                $rec_post .= PROFILENA;
                $rec_post .= '</span>
                                                                            </li>';
            }
            $rec_post .= '<li><b>Employment Type</b><span>';
            if ($rec_postdata[0]['emp_type'] != '') {
                $rec_post .= '<pre>';
                $rec_post .= $this->common->make_links($rec_postdata[0]['emp_type']) . 'Job</pre>';
            } else {
                $rec_post .= PROFILENA;
            }
            $rec_post .= '</span></li><li><b>Company Profile</b><span>';
            if ($rec_postdata[0]['re_comp_profile'] != '') {
                $rec_post .= '<pre>';
                $rec_post .= $this->common->make_links($rec_postdata[0]['re_comp_profile']) . '</pre>';
            } else {
                $rec_post .= PROFILENA;
            }


            $rec_post .= '</span></li></ul></div>
                                                                    <div class="profile-job-profile-button clearfix">
                                                                        <div class="apply-btn fr">';

            $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

            $contition_array = array('post_id' => $rec_postdata[0]['post_id'], 'job_delete' => '0', 'user_id' => $userid);
            $jobapply = $this->data['jobsave'] = $this->common->select_data_by_condition('job_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($jobapply) {


                $rec_post .= '<a href="javascript:void(0);" class="button applied">Applied</a>';
            } else {


                $rec_post .= '<a href="javascript:void(0);"  class= "applypost' . $rec_postdata[0]['post_id'] . ' button"';

                if ($this->session->userdata('aileenuser')) {
                    $rec_post .= 'onclick="applypopup(' . $rec_postdata[0]['post_id'] . ',' . $rec_postdata[0]['user_id'] . ')"';
                } else {
                    $rec_post .= 'onClick="create_profile_apply()"';
                }

                $rec_post .= '>Apply</a>';

                $userid = $this->session->userdata('aileenuser');
                $contition_array = array('user_id' => $userid, 'job_save' => '2', 'post_id ' => $rec_postdata[0]['post_id'], 'job_delete' => '1');
                $jobsave = $this->data['jobsave'] = $this->common->select_data_by_condition('job_apply', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($jobsave) {

                    $rec_post .= '<a class="button saved">Saved</a>';
                } else {
                    $rec_post .= '<a id="' . $rec_postdata[0]['post_id'] . 'href="javascript:void(0);" class="savedpost' . $rec_postdata[0]['post_id'] . ' button"';

                    if ($this->session->userdata('aileenuser')) {
                        $rec_post .= 'onclick="savepopup(' . $rec_postdata[0]['post_id'] . ')"';
                    } else {
                        $rec_post .= 'onClick="login_profile_save()"';
                    }
                    $rec_post .= '>Save</a>';
                }
            }
            $rec_post .= '</div>
                                                                    </div>
                                                                </div>
                                                            </div>';
        } else {

            $rec_post .= '<div class="art-img-nn">
                                                                <div class="art_no_post_img">

                                                                    <img src="' . base_url('assets/img/job-no.png') . '">

                                                                </div>
                                                                <div class="art_no_post_text">
                                                                    No Job Available.
                                                                </div>
                                                            </div>';
        }

        echo $rec_post;
        // code end
    }

    // RECRUITER POST AJAX LAZZY LOADER DATA END
    //FOR RECRUITER POST START
    public function rec_profile($id = "") {

        $user_id = $this->db->get_where('rec_post', array('post_id' => $id))->row()->user_id;

        $contition_array = array('user_id' => $user_id, 'is_delete' => '0', 're_status' => '1');
        $this->data['rec_data'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('user_id' => $user_id, 'is_delete' => '0', 'status' => '1', 'post_id' => $id);
        $rec_post = $this->data['rec_post'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data = 'post_id,post_name,city', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $cache_time = $this->db->get_where('job_title', array('title_id' => $rec_post[0]['post_name']))->row()->name;

        if ($cache_time) {
            $cache_time1 = $cache_time;
        } else {
            $cache_time1 = $rec_post[0]['post_name'];
        }


        $text = str_replace(" ", "-", $cache_time1);
        $text = preg_replace("/[.!$#%()]+/i", "", $text);
        $this->data['text'] = $text = strtolower($text);

        $cache_time1 = $this->db->get_where('cities', array('city_id' => $rec_post[0]['city']))->row()->city_name;

        $cityname = str_replace(" ", "-", $cache_time1);
        $cityname = preg_replace("/[.!$#%()]+/i", "", $cityname);
        $this->data['cityname'] = strtolower($cityname);

        $this->load->view('job/recruiter_profile', $this->data);
    }

    //FOR RECRUITER POST END
    //add other_industry into database start 
    public function job_other_industry() {

        $other_industry = $_POST['other_industry'];
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');


        $contition_array = array('is_delete' => '0', 'status' => '1', 'industry_name' => $other_industry);
        $search_condition = "((is_other = '1' AND user_id = $userid) OR (is_other = '0'))";
        $userdata = $this->data['userdata'] = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = 'count(*) as total', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $count = $userdata[0]['total'];

        if ($other_industry != NULL) {
            if ($count == 0) {
                $data = array(
                    'industry_name' => $other_industry,
                    'created_date' => date('Y-m-d h:i:s', time()),
                    'status' => '1',
                    'is_delete' => '0',
                    'is_other' => '1',
                    'user_id' => $userid
                );
                $insert_id = $this->common->insert_data_getid($data, 'job_industry');
                if ($insert_id) {


                    $contition_array = array('is_delete' => '0', 'status' => '1', 'industry_name !=' => "Other");
                    $search_condition = "((is_other = '1' AND user_id = $userid) OR (is_other = '0'))";
                    $industry = $this->data['industry'] = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = '*', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


                    if (count($industry) > 0) {
                        $select = '<option value="" selected option disabled>Select Industry</option>';

                        foreach ($industry as $st) {
                            $select .= '<option value="' . $st['industry_id'] . '"';
                            if ($st['industry_name'] == $other_industry) {
                                $select .= 'selected';
                            }
                            $select .= '>' . $st['industry_name'] . '</option>';
                        }
                    }
                    //For Getting Other at end
                    $contition_array = array('is_delete' => '0', 'status' => '1', 'industry_name' => "Others");
                    $industry_otherdata = $this->data['industry_otherdata'] = $this->common->select_data_by_condition('job_industry', $contition_array, $data = '*', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');



                    $select .= '<option value="' . $industry_otherdata[0]['industry_id'] . '">' . $industry_otherdata[0]['industry_name'] . '</option>';
                }
            } else {
                $select .= 0;
            }
        } else {
            $select .= 1;
        }
        echo $select;
        die();
    }

    //add other_industry into database End 


    public function apply_email($notid) {

        $jobid = $this->session->userdata('aileenuser');
        $jobdata = $this->common->select_data_by_id('job_reg', 'user_id', $jobid, $data = 'job_user_image,fname,lname,slug', $join_str = array());
        $recemail = $this->common->select_data_by_id('recruiter', 'user_id', $notid, $data = 're_comp_email', $join_str = array());

        $email_html = '';
        $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td style="padding:5px;">';
        $filename = $this->config->item('job_profile_thumb_upload_path') . $jobdata[0]['job_user_image'];
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
        if ($jobdata[0]['job_user_image'] != '' && $info) {
            $email_html .= '<img src="' . JOB_PROFILE_THUMB_UPLOAD_URL . $jobdata[0]['job_user_image'] . '" width="50" height="50">';
        } else {
            $a = $jobdata[0]['fname'];
            $b = $jobdata[0]['lname'];
            $acr = substr($a, 0, 1);
            $bcr = substr($b, 0, 1);

            $email_html .= '<div class="post-img-div">';
            $email_html .= '' . ucwords($acr) . ucwords($bcr) . '';
            $email_html .= '</div>';
        }


        $email_html .= '</td>
                                                                    <td style="padding:5px;">
                                                                        <p>Job seeker<b> ' . ucwords($jobdata[0]['fname']) . ' ' . ucwords($jobdata[0]['lname']) . '</b> Applied on your jobpost.
                                                                            <span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                                                    </td>
                                                                    <td style="padding:5px;">
                                                                        <p><a class="btn" href="' . BASEURL . 'job/resume/' . $jobdata[0]['slug'] . '">view</a></p>
                                                                    </td>
                                                                </tr>
                                                            </table>';

        $subject = ucwords($jobdata[0]['fname']) . ' ' . ucwords($jobdata[0]['lname']) . ' Applied on your jobpost - Aileensoul.';
        $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $recemail[0]['re_comp_email']);
    }

    public function name_slug() {
        $this->db->select('title_id,name');
        $res = $this->db->get('job_title')->result();
        foreach ($res as $k => $v) {
            $data = array('slug' => $this->common->clean($v->name));
            $this->db->where('title_id', $v->title_id);
            $this->db->update('job_title', $data);
        }
        echo "yes";
    }

    public function country_slug() {
        $this->db->select('country_id,country_name');
        $res = $this->db->get('countries')->result();
        foreach ($res as $k => $v) {
            $data = array('country_slug' => $this->common->clean($v->country_name));
            $this->db->where('country_id', $v->country_id);
            $this->db->update('countries', $data);
        }
        echo "yes";
    }

    public function all_post($city = '') {

        $city = $_GET['city'];

        $this->data['title'] = 'Find Latest Job Vacancies at Your Location' . TITLEPOSTFIX;
        if ($city[0]['city']) {

            $cache_time = $this->db->get_where('cities', array('city_name' => $city))->row()->city_id;

            $join_str[0]['table'] = 'recruiter';
            $join_str[0]['join_table_id'] = 'recruiter.user_id';
            $join_str[0]['from_table_id'] = 'rec_post.user_id';
            $join_str[0]['join_type'] = '';

            $data = 'post_id,post_name,post_last_date,post_description,post_skill,post_position,interview_process,min_sal,max_sal,max_year,,min_year,fresher,degree_name,industry_type,emp_type,rec_post.created_date,rec_post.user_id,recruiter.rec_firstname,recruiter.re_comp_name,recruiter.rec_lastname,recruiter.recruiter_user_image,recruiter.profile_background,recruiter.re_comp_profile,city,country,post_currency,salary_type';
            $contition_array = array('city' => $cache_time, 'status' => '1', 'rec_post.is_delete' => '0');
            $this->data['postdata'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby);
        } else {
            //  echo "123";die();
            $join_str[0]['table'] = 'recruiter';
            $join_str[0]['join_table_id'] = 'recruiter.user_id';
            $join_str[0]['from_table_id'] = 'rec_post.user_id';
            $join_str[0]['join_type'] = '';

            $data = 'post_id,post_name,post_last_date,post_description,post_skill,post_position,interview_process,min_sal,max_sal,max_year,,min_year,fresher,degree_name,industry_type,emp_type,rec_post.created_date,rec_post.user_id,recruiter.rec_firstname,recruiter.re_comp_name,recruiter.rec_lastname,recruiter.recruiter_user_image,recruiter.profile_background,recruiter.re_comp_profile,city,country,post_currency,salary_type';
            $contition_array = array('status' => '1', 'rec_post.is_delete' => '0');
            $this->data['postdata'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data, $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
        }
        if ($this->session->userdata('aileenuser')) {
            $this->load->view('job/all_post', $this->data);
        } else {
            $this->load->view('job/all_post_login', $this->data);
        }
    }

    public function job_notification_count($to_id = '') {
        $contition_array = array('not_read' => '2', 'not_to_id' => $to_id, 'not_type !=' => '1', 'not_type !=' => '2');
        $result = $this->common->select_data_by_condition('notification', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $count = $result[0]['total'];
        return $count;
    }

    public function new_page() {

        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

// job seeker detail

        $contition_array = array(
            'user_id' => $userid,
            'is_delete' => '0',
            'status' => '1'
        );
        $jobdata = $this->data['jobdata'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// post detail

        $contition_array = array(
            'is_delete' => '0',
            'status' => '1'
        );
        $postdata = $this->data['postdata'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data = '*', $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// for getting data from rec_post table for keyskill

        $work_job_skill = $jobdata[0]['keyskill'];
        $work_skill = explode(',', $work_job_skill);
        foreach ($work_skill as $skill) {
            $contition_array = array(
                'FIND_IN_SET("' . $skill . '",post_skill)!=' => '0',
                'is_delete' => '0',
                'status' => '1'
            );
            $data = $this->data['data'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data = '*', $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $recommendata[] = $data;
        }


// Retrieve data according to city match start

        $work_job_city = $jobdata[0]['work_job_city'];
        $work_city = explode(',', $work_job_city);

        foreach ($work_city as $city) {
            $data = '*';
            $contition_array = array(
                'FIND_IN_SET("' . $city . '",city)!=' => '0',
                'is_delete' => '0',
                'status' => '1'
            );
            $data1 = $this->data['data'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data, $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $recommendata_city[] = $data1;
        }

// Retrieve data according to city match End
// Retrieve data according to industry match start

        $work_job_industry = $jobdata[0]['work_job_industry'];
//        foreach ($postdata as $post) {
        $data = '*';
        $contition_array = array(
            'industry_type' => $work_job_industry,
            'is_delete' => '0',
            'status' => '1'
        );
        $data1 = $this->data['data'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data, $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $recommendata_industry[] = $data1;
//        }
// Retrieve data according to industry match End
// Retrieve data according to Job Title match start

        $work_job_title = $jobdata[0]['work_job_title'];

        foreach ($postdata as $post) {
            $data = '*';
            $contition_array = array(
                'post_name' => $work_job_title,
                'is_delete' => '0',
                'status' => '1'
            );
            $data1 = $this->data['data'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data, $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $recommendata_title[] = $data1;
        }

        $recskill = count(array_filter($recommendata));
        $reccity = count(array_filter($recommendata_city));
        $recindustry = count(array_filter($recommendata_industry));
        $rectitle = count(array_filter($recommendata_title));

// Retrieve data according to  Job Title match End
//echo "<pre>";print_r($recommendata);die();

        if ($recskill != 0 && $reccity == 0 && $recindustry == 0 && $rectitle == 0) {

            $unique = $recommendata;
            $newArray = array_reduce($unique, 'array_merge', array());
            $qbc = array_unique($newArray, SORT_REGULAR);
            $qbc = array_filter($qbc);
        } elseif ($recskill == 0 && $reccity != 0 && $recindustry == 0 && $rectitle == 0) {

            $unique = $recommendata_city;
            $newArray = array_reduce($unique, 'array_merge', array());
            $qbc = array_unique($newArray, SORT_REGULAR);
            $qbc = array_filter($qbc);
        } elseif ($recskill == 0 && $reccity == 0 && $recindustry != 0 && $rectitle == 0) {
            $unique = $recommendata_industry;
            $newArray = array_reduce($unique, 'array_merge', array());
            $qbc = array_unique($newArray, SORT_REGULAR);
            $qbc = array_filter($qbc);
        } elseif ($recskill == 0 && $reccity == 0 && $recindustry == 0 && $rectitle != 0) {

            $unique = $recommendata_title;
            $newArray = array_reduce($unique, 'array_merge', array());
            $qbc = array_unique($newArray, SORT_REGULAR);
            $qbc = array_filter($qbc);
        } else {

            $unique = array_merge((array) $recommendata, (array) $recommendata_city, (array) $recommendata_industry, (array) $recommendata_title);

            $newArray = array_reduce($unique, 'array_merge', array());
            $qbc = array_unique($newArray, SORT_REGULAR);
            $qbc = array_filter($qbc);
        }

        $postdetail = $this->data['postdetail'] = $qbc;

        $this->load->view('job/job_new_page', $this->data);
    }

}
