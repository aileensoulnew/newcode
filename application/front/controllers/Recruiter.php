<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Recruiter extends MY_Controller {

    public $data;
    public $my_variable;

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('job_model');
        $this->load->model('recruiter_model');
        $this->load->model('logins');
        $this->lang->load('message', 'english');
        $this->load->library('S3');
        include ('main_profile_link.php');
        include ('rec_include.php');

    }

    public function index() {
        $userid = $this->session->userdata('aileenuser');
//  CHECK HOW MUCH STEP FILL UP BY USE IN RECRUITER PROFILE START  
        // $this->recruiter_apply_check();
//  CHECK HOW MUCH STEP FILL UP BY USE IN RECRUITER PROFILE END  
// IF USER IS RELOGIN AFTER DEACTIVATE PROFILE IN RECRUITER THEN REACTIVATE PROFIEL CODE START    
        $contition_array = array('user_id' => $userid, 're_status' => '0');
        $reactivate = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
// IF USER IS RELOGIN AFTER DEACTIVATE PROFILE IN RECRUITER THEN REACTIVATE PROFIEL CODE END    

        if ($reactivate) {
            $this->load->view('recruiter/reactivate', $this->data);
        } else {


// RECRUITER USER STEP DETAIL FETCH CODE START
// RECRUITER USER STEP DETAIL FETCH CODE END

            if ($this->data['recdata']['re_step'] == 1) {
                redirect('recruiter/company-information', refresh);
            } else if ($this->data['recdata']['re_step'] == 3) {
                redirect('recruiter/home', refresh);
            } else if ($this->data['recdata']['re_step'] == 0) {
                redirect('recruiter/registration', refresh);
            } else {
                redirect('recruiter/registration', refresh);
            }
        }
    }

    public function recruiter_apply_check() {

        $userid = $this->session->userdata('aileenuser');

// REDIRECT USER TO REMAIN PROFILE START
        $contition_array = array('user_id' => $userid, 're_status' => '1', 'is_delete' => '0');
        $apply_step = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 're_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// REDIRECT USER TO REMAIN PROFILE END

        if (count($apply_step) >= 0) {
            if ($apply_step[0]['re_step'] == 1) {
                redirect('recruiter/registration');
            }
            if ($apply_step[0]['re_step'] == 0) {
                redirect('recruiter/registration');
            }
        } else {
            redirect('recruiter/registration');
        }
    }

// RECRUITER BASIC INFORMATION STEP START
    public function rec_basic_information() {
        $this->data['title'] = 'Basic Information | Edit Profile - Recruiter Profile - Aileensoul';
        $userid = $this->session->userdata('aileenuser');

//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE START
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');
        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE END
        if ($this->data['recdata']) {
            if ($this->data['recdata']['re_step'] == 1 || $this->data['recdata']['re_step'] > 1) {
                $this->data['firstname'] = $this->data['recdata']['rec_firstname'];
                $this->data['lastname'] = $this->data['recdata']['rec_lastname'];
                $this->data['email'] = $this->data['recdata']['rec_email'];
                $this->data['phone'] = $this->data['recdata']['rec_phone'];
            }
        }
        $this->load->view('recruiter/rec_basic_information', $this->data);
    }

// RECRUITER BASIC INFORMATION STEP END  
// RECRUITER BASIC INFORMATION INSERT STEP START  
    public function basic_information() {

        $this->data['title'] = 'Basic Information | Edit Profile - Recruiter Profile - Aileensoul';
        $userid = $this->session->userdata('aileenuser');

//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE START
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');
        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE END

        $this->form_validation->set_rules('first_name', 'first Name', 'required');
        $this->form_validation->set_rules('last_name', 'last Name', 'required');
        $this->form_validation->set_rules('email', ' EmailId', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {


            if ($this->data['recdata']) {

                if ($this->data['recdata']['re_step'] == 1 || $this->data['recdata']['re_step'] > 1) {
                    $this->data['firstname'] = $this->data['recdata']['rec_firstname'];
                    $this->data['lastname'] = $this->data['recdata']['rec_lastname'];
                    $this->data['email'] = $this->data['recdata']['rec_email'];
                    $this->data['phone'] = $this->data['recdata']['rec_phone'];
                }
            }


            $this->load->view('recruiter/rec_basic_information', $this->data);
        } else {
// IF USER AVAILABLE THEN UPDATE DATA START


            if ($this->data['recdata']) {

                $data = array(
                    'rec_firstname' => $this->input->post('first_name'),
                    'rec_lastname' => $this->input->post('last_name'),
                    'rec_email' => $this->input->post('email'),
                    'rec_phone' => $this->input->post('phoneno'),
                    're_status' => '1',
                    'is_delete' => '0',
                    'modify_date' => date('y-m-d h:i:s'),
                    'user_id' => $userid,
                    're_step' => $this->data['recdata']['re_step']
                );

                $insert_id = $this->common->update_data($data, 'recruiter', 'rec_id', $this->data['recdata']['rec_id']);

                if ($insert_id) {
                    redirect('recruiter/company-information', refresh);
                } else {
                    redirect('recruiter', refresh);
                }
            } else {
// IF USER NOT AVAILABLE THEN INSERT DATA START               
                $data = array(
                    'rec_firstname' => $this->input->post('first_name'),
                    'rec_lastname' => $this->input->post('last_name'),
                    'rec_email' => $this->input->post('email'),
                    'rec_phone' => $this->input->post('phoneno'),
                    're_status' => '1',
                    'is_delete' => '0',
                    'created_date' => date('y-m-d h:i:s'),
                    'user_id' => $userid,
                    're_step' => '1'
                );

                $insert_id = $this->common->insert_data_getid($data, 'recruiter');
                if ($insert_id) {
                    redirect('recruiter/company-information', refresh);
                } else {
                    redirect('recruiter', refresh);
                }
            }
        }
    }

// RECRUITER BASIC INFORMATION INSERT STEP END  
// RECRUITER CHECK EMAIL FUCNTION IN BSIC INFORMATION START
    public function check_email() {
        $email = $this->input->post('email');

        $userid = $this->session->userdata('aileenuser');

//if user deactive profile then redirect to recruiter/index untill active profile start
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');

        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
//if user deactive profile then redirect to recruiter/index untill active profile End


        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 're_status' => '1');
        $userdata = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $email1 = $userdata[0]['rec_email'];

        if ($email1) {
            $condition_array = array('is_delete' => '0', 'user_id !=' => $userid, 're_status' => '1');

            $check_result = $this->common->check_unique_avalibility('recruiter', 'rec_email', $email, '', '', $condition_array);
        } else {

            $condition_array = array('is_delete' => '0', 're_status' => '1');

            $check_result = $this->common->check_unique_avalibility('recruiter', 'rec_email', $email, '', '', $condition_array);
        }

        if ($check_result) {
            echo 'true';
            die();
        } else {
            echo 'false';
            die();
        }
    }

// RECRUITER CHECK EMAIL FUCNTION IN BSIC INFORMATION END  
// RECRUITER CHECK EMAIL FUCNTION IN COMPANY INFORMATION START  
    public function company_info_form() {
        $this->data['title'] = 'Company Information |  Edit Profile - Recruiter Profile - Aileensoul';
        $userid = $this->session->userdata('aileenuser');

//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE START
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');
        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE END
// FETCH RECRUITER DATA    
// FETCH COUNTRY DATA    
        $contition_array = array('status' => '1');
        $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = 'country_id,country_name', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// FETCH STATE DATA  
        $contition_array = array('status' => '1', 'country_id' => $this->data['recdata']['re_comp_country']);
        $this->data['states'] = $this->common->select_data_by_condition('states', $contition_array, $data = '*', $sortby = 'state_id,state_name,country_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// FETCH CITY DATA
        $contition_array = array('status' => '1', 'state_id' => $this->data['recdata']['re_comp_state']);
        $this->data['cities'] = $this->common->select_data_by_condition('cities', $contition_array, $data = '*', $sortby = 'city_name,city_id,state_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        if ($this->data['recdata']) {

            if ($this->data['recdata']['re_step'] == 3 || $this->data['recdata']['re_step'] > 3 || ($this->data['recdata']['re_step'] >= 1 && $this->data['recdata']['re_step'] <= 3)) {

                $this->data['rec_id'] = $this->data['recdata']['rec_id'];
                $this->data['compname'] = $this->data['recdata']['re_comp_name'];
                $this->data['compemail'] = $this->data['recdata']['re_comp_email'];
                $this->data['compnum'] = $this->data['recdata']['re_comp_phone'];
                $this->data['compweb'] = $this->data['recdata']['re_comp_site'];
                $this->data['country1'] = $this->data['recdata']['re_comp_country'];
                $this->data['state1'] = $this->data['recdata']['re_comp_state'];
                $this->data['city1'] = $this->data['recdata']['re_comp_city'];
                $this->data['compsector'] = $this->data['recdata']['re_comp_sector'];
                $this->data['comp_profile1'] = $this->data['recdata']['re_comp_profile'];
                $this->data['complogo1'] = $this->data['recdata']['comp_logo'];
            }
        }

        $this->load->view('recruiter/company_information', $this->data);
    }

// RECRUITER CHECK EMAIL FUCNTION IN COMPANY INFORMATION END  
// RECRUITER CHECK EMAIL FUCNTION IN COMPANY INFORMATION INSERT CODE START
    public function company_info_store() {

        $userid = $this->session->userdata('aileenuser');

//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE START
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');
        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE END


        $this->form_validation->set_rules('country', 'Country', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('comp_name', 'company Name', 'required');
        $this->form_validation->set_rules('comp_email', 'company email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            if ($this->data['recdata']) {
                $step = $this->data['recdata']['re_step'];

                if ($this->data['recdata']['re_step'] == 3 || $this->data['recdata']['re_step'] > 3 || ($this->data['recdata']['re_step'] >= 1 && $this->data['recdata']['re_step'] <= 3)) {
                    $this->data['compname'] = $this->data['recdata']['re_comp_name'];
                    $this->data['compemail'] = $this->data['recdata']['re_comp_email'];
                    $this->data['compnum'] = $this->data['recdata']['re_comp_phone'];
                    $this->data['compweb'] = $this->data['recdata']['re_comp_site'];
                    $this->data['compsector'] = $this->data['recdata']['re_comp_sector'];
                    $this->data['comp_profile1'] = $this->data['recdata']['re_comp_profile'];
                    $this->data['country1'] = $this->data['recdata']['re_comp_country'];
                    $this->data['state1'] = $this->data['recdata']['re_comp_state'];
                    $this->data['city1'] = $this->data['recdata']['re_comp_city'];
                    $this->data['complogo1'] = $this->data['recdata']['comp_logo'];
                }
            }
            $this->load->view('recruiter/company_information', $this->data);
        } else {

            $error = '';
            if ($_FILES['comp_logo']['name'] != '') {
                $logo = '';
                $job['upload_path'] = $this->config->item('rec_profile_main_upload_path');
                $job['allowed_types'] = $this->config->item('rec_profile_main_allowed_types');
                $job['max_size'] = $this->config->item('rec_profile_main_max_size');
                $job['max_width'] = $this->config->item('rec_profile_main_max_width');
                $job['max_height'] = $this->config->item('rec_profile_main_max_height');
                $this->load->library('upload');
                $this->upload->initialize($job);
//Uploading Image
                $this->upload->do_upload('comp_logo');
//Getting Uploaded Image File Data
                $imgdata = $this->upload->data();
                $imgerror = $this->upload->display_errors();

                if ($imgerror == '') {

//Configuring Thumbnail 
                    $job_thumb['image_library'] = 'gd2';
                    $job_thumb['source_image'] = $job['upload_path'] . $imgdata['file_name'];
                    $job_thumb['new_image'] = $this->config->item('rec_profile_thumb_upload_path') . $imgdata['file_name'];
                    $job_thumb['create_thumb'] = TRUE;
                    $job_thumb['maintain_ratio'] = TRUE;
                    $job_thumb['thumb_marker'] = '';
                    $job_thumb['width'] = $this->config->item('rec_profile_thumb_width');
                    $job_thumb['height'] = 2;
                    $job_thumb['master_dim'] = 'width';
                    $job_thumb['quality'] = "100%";
                    $job_thumb['x_axis'] = '0';
                    $job_thumb['y_axis'] = '0';
//Loading Image Library
                    $this->load->library('image_lib', $job_thumb);
                    $dataimage = $imgdata['file_name'];
//Creating Thumbnail

                    $main_image = $this->config->item('rec_profile_main_upload_path') . $imgdata['file_name'];
                    $thumb_image = $this->config->item('rec_profile_thumb_upload_path') . $imgdata['file_name'];


                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
                    $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);

                    //  echo $main_image;die();
                    // $thumb_image = $rec_image_thumb_path . $imageName;
                    copy($main_image, $thumb_image);
                    $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);

                    if ($_SERVER['HTTP_HOST'] != "localhost") {
                        if (isset($main_image)) {
                            unlink($main_image);
                        }
                        if (isset($thumb_image)) {
                            unlink($thumb_image);
                        }
                    }

                    $this->image_lib->resize();
                    $thumberror = $this->image_lib->display_errors();
                } else {
                    $thumberror = '';
                }
                if ($imgerror != '' || $thumberror != '') {
                    $error[0] = $imgerror;
                    $error[1] = $thumberror;
                } else {
                    $error = array();
                }
            }
            if ($error) {

                $this->session->set_flashdata('error', $error[0]);
                $redirect_url = site_url('recruiter');
                redirect($redirect_url, 'refresh');
            } else {

                $rec_reg_prev_image = $this->data['recdata']['comp_logo'];
                $logoimage = $_FILES['comp_logo']['name'];


                $image_hidden_primary = $this->input->post('image_hidden_logo');

                if ($rec_reg_prev_image != '') {
                    $rec_image_main_path = $this->config->item('rec_profile_main_upload_path');
                    $rec_bg_full_image = $rec_image_main_path . $rec_reg_prev_image;
                    if (isset($rec_bg_full_image)) {
//delete image from folder when user change image start
                        if ($image_hidden_primary == $rec_reg_prev_image && $logoimage != "") {

                            unlink($rec_bg_full_image);
                        }
//delete image from folder when user change image End
                    }

                    $rec_image_thumb_path = $this->config->item('rec_profile_thumb_upload_path');
                    $rec_bg_thumb_image = $rec_image_thumb_path . $rec_reg_prev_image;
                    if (isset($job_bg_thumb_image)) {
//delete image from folder when user change image Start
                        if ($image_hidden_primary == $rec_reg_prev_image && $logoimage != "") {
                            unlink($rec_bg_thumb_image);
                        }
//delete image from folder when user change image End
                    }
                }
                $logo = $imgdata['file_name'];
            }

            if ($this->data['recdata']) {
                $logoimage = $_FILES['comp_logo']['name'];
                if ($logoimage == "") {
                    $data = array(
                        'comp_logo' => $this->input->post('image_hidden_logo')
                    );
                } else {
                    $data = array(
                        'comp_logo' => $logo
                    );
                }
                $insert_id = $this->common->update_data($data, 'recruiter', 'user_id', $userid);
                $data = array(
                    're_comp_name' => $this->input->post('comp_name'),
                    're_comp_email' => $this->input->post('comp_email'),
                    're_comp_site' => $this->input->post('comp_site'),
                    're_comp_phone' => $this->input->post('comp_num'),
                    're_comp_sector' => trim($this->input->post('comp_sector')),
                    're_comp_profile' => trim($this->input->post('comp_profile')),
                    're_comp_country' => $this->input->post('country'),
                    're_comp_state' => $this->input->post('state'),
                    're_comp_city' => $this->input->post('city'),
                    're_step' => '3'
                );

                $insert_id = $this->common->update_data($data, 'recruiter', 'rec_id', $this->data['recdata']['rec_id']);

                if ($insert_id) {
                    redirect('recruiter/home', refresh);
                } else {
                    redirect('recruiter', refresh);
                }
            } else {
                $data = array(
                    're_comp_name' => $this->input->post('comp_name'), 're_comp_email' => $this->input->post('comp_email'),
                    're_comp_site' => $this->input->post('comp_site'),
                    're_comp_phone' => $this->input->post('comp_num'),
                    're_comp_sector' => trim($this->input->post('comp_sector')),
                    're_comp_profile' => trim($this->input->post('comp_profile')),
                    're_comp_country' => $this->input->post('country'),
                    're_comp_state' => $this->input->post('state'),
                    're_comp_city' => $this->input->post('city'),
                    'comp_logo' => $logo,
                    'is_delete' => '0',
                    're_status' => '1',
                    'created_date' => date('y-m-d h:i:s'),
                    're_step' => '3'
                );
                $insert_id = $this->common->update_data($data, 'recruiter', 'user_id', $userid);
                if ($insert_id) {
                    if ($this->data['recdata']['re_step'] == 3) {
                        redirect('recruiter/home', refresh);
                    } else {
                        redirect('recruiter/company-information', refresh);
                    }
                } else {
                    $this->session->flashdata('error', 'Sorry!! Your data not inserted');
                    redirect('recruiter', refresh);
                }
            }
        }
    }

// RECRUITER CHECK EMAIL FUCNTION IN COMPANY INFORMATION INSERT CODE END   
// RECRUITER CHECK EMAIL COMAPNY FUNCTION START   
    public function check_email_com() { //echo "hello"; die();
        $email = $this->input->post('comp_email');

        $userid = $this->session->userdata('aileenuser');


//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE START
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');
        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE END

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 're_status' => '1');
        $userdata = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $email1 = $userdata[0]['rec_email'];

        if ($email1) {
            $condition_array = array('is_delete' => '0', 'user_id !=' => $userid);

            $check_result = $this->common->check_unique_avalibility('recruiter', 'rec_email', $email, '', '', $condition_array);
        } else {

            $condition_array = array('is_delete' => '0');

            $check_result = $this->common->check_unique_avalibility('recruiter', 'rec_email', $email, '', '', $condition_array);
        }

        if ($check_result) {
            echo 'true';
            die();
        } else {
            echo 'false';
            die();
        }
    }

// RECRUITER CHECK EMAIL COMAPNY FUNCTION END   
// RECRUITER RECOMMANDED FUNCTION START
    public function recommen_candidate() {
        
        $this->data['title'] = 'Home | Recruiter Profile - Aileensoul';
        $userid = $this->session->userdata('aileenuser');
        $this->recruiter_apply_check();


//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE START
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');
        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE END
//FETCH RECRUITER DATA

        $this->load->view('recruiter/recommen_candidate', $this->data);
    }

// RECRUITER RECOMMANDED FUNCTION END
// RECRUITER ADD POST START
    public function add_post() {
        $this->data['title'] = 'Add Post | Recruiter Profile - Aileensoul';

        if ($this->session->userdata('aileenuser')) {

            $this->recruiter_apply_check();

            $userid = $this->session->userdata('aileenuser');

//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE START
            $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');
            $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
            if ($recruiter_deactive) {
                redirect('recruiter/');
            }
//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE END


            $contition_array = array('status' => '1');
            $this->data['currency'] = $this->common->select_data_by_condition('currency', $contition_array, $data = '*', $sortby = 'currency_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('is_delete' => '0', 'is_other' => '0', 'industry_name !=' => "Others");
            $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
            $industry = $this->data['industry'] = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = '*', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('is_delete' => '0', 'status' => '1', 'industry_name' => "Others");
            $this->data['industry_otherdata'] = $this->common->select_data_by_condition('job_industry', $contition_array, $data = '*', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');



            $contition_array = array('is_delete' => '0', 'degree_name !=' => "Other");
            $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
            $degree = $this->data['degree'] = $this->common->select_data_by_search('degree', $search_condition, $contition_array, $data = '*', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('is_delete' => '0', 'status' => '1', 'degree_name' => "Other");
            $this->data['degree_otherdata'] = $this->common->select_data_by_condition('degree', $contition_array, $data = '*', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('status' => '1');
            $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = '*', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('status' => '1', 'type' => '1');
            $this->data['skill'] = $this->common->select_data_by_condition('skill', $contition_array, $data = '*', $sortby = 'skill', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('status' => 'publish');
            $jobtitle = $this->common->select_data_by_condition('job_title', $contition_array, $data = 'name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

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

            $this->load->view('recruiter/add_post', $this->data);
        } else {
            $contition_array = array('status' => '1');
            $this->data['currency'] = $this->common->select_data_by_condition('currency', $contition_array, $data = '*', $sortby = 'currency_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('is_delete' => '0', 'is_other' => '0', 'industry_name !=' => "Others");
            $search_condition = "(status = '1')";
            $industry = $this->data['industry'] = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = '*', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            $contition_array = array('is_delete' => '0', 'status' => '1', 'industry_name' => "Others");
            $this->data['industry_otherdata'] = $this->common->select_data_by_condition('job_industry', $contition_array, $data = '*', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('is_delete' => '0', 'degree_name !=' => "Other");
            $search_condition = "(status = '1')";
            $degree = $this->data['degree'] = $this->common->select_data_by_search('degree', $search_condition, $contition_array, $data = '*', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('is_delete' => '0', 'status' => '1', 'degree_name' => "Other");
            $this->data['degree_otherdata'] = $this->common->select_data_by_condition('degree', $contition_array, $data = '*', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('status' => '1');
            $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = '*', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('status' => '1', 'type' => '1');
            $this->data['skill'] = $this->common->select_data_by_condition('skill', $contition_array, $data = '*', $sortby = 'skill', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('status' => 'publish');
            $jobtitle = $this->common->select_data_by_condition('job_title', $contition_array, $data = 'name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

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


            $this->load->view('recruiter/add_post_login', $this->data);
        }
    }

// RECRUITER ADD POST END
// RECRUITER ADD POST INSERT START

    public function add_post_store() {

        $this->recruiter_apply_check();

        $userid = $this->session->userdata('aileenuser');

//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE START
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');
        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE END


        $position = $this->input->post('position_no');
        $min_year = $this->input->post('minyear');
        $max_year = $this->input->post('maxyear');
        $fresher = $this->input->post('fresher');
        $industry = $this->input->post('industry');
        $emp_type = $this->input->post('emp_type');
        $post_Desc = $this->input->post('post_desc');
        $interview = $this->input->post('interview');
        $country = $this->input->post('country');
        $state = $this->input->post('state');
        $city = $this->input->post('city');
        $salary_type = $this->input->post('salary_type');
        $min_sal = $this->input->post('minsal');
        $max_sal = $this->input->post('maxsal');
        $currency = $this->input->post('currency');
        $bod = $this->input->post('last_date');
        $bod = str_replace('/', '-', $bod);


// job title start  

        $jobtitle = $this->input->post('post_name');
        if ($jobtitle != " ") {
            $contition_array = array('name' => trim($jobtitle));
            $jobdata = $this->common->select_data_by_condition('job_title', $contition_array, $data = 'title_id,name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
            if ($jobdata) {
                $jobtitle = $jobdata[0]['title_id'];
            } else {
                $data = array(
                    'name' => ucfirst($this->input->post('post_name')),
                    'slug' => $this->common->clean('post_name'),
                    'status' => 'draft',
                );
                $jobtitle = $this->common->insert_data_getid($data, 'job_title');
            }
        }

// skills  start   
        $skills = $this->input->post('skills');
        $skills = explode(',', $skills);
        if (count($skills) > 0) {

            foreach ($skills as $ski) {
                if ($ski != " ") {
                    $contition_array = array('skill' => trim($ski), 'type' => '1');
                    $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');

                    if (count($skilldata) == 0) {
                        $contition_array = array('skill' => trim($ski), 'type' => '4');

                        $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                    }
                    if ($skilldata) {
                        $skill1[] = $skilldata[0]['skill_id'];
                    } else {
                        $data = array(
                            'skill' => trim($ski),
                            'status' => '1',
                            'type' => '4',
                            'user_id' => $userid,
                        );
                        $skill1[] = $this->common->insert_data_getid($data, 'skill');
                    }
                }
            }
        }
        $skills = implode(',', $skill1);

// education data start

        $education = $this->input->post('education');
        $education = explode(',', $education);
        if (count($education) > 0) {

            foreach ($education as $educat) {
                if ($educat != " ") {
                    $contition_array = array('degree_name' => trim($educat), 'status' => '1', 'is_other' => '0');
                    $edudata = $this->common->select_data_by_condition('degree', $contition_array, $data = 'degree_id,degree_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');

                    if (count($edudata) == 0) {
                        $contition_array = array('degree_name' => trim($educat), 'status' => '2', 'is_other' => '1', 'user_id' => $userid);
                        $edudata = $this->common->select_data_by_condition('degree', $contition_array, $data = 'degree_id,degree_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                    }
                    if ($edudata) {
                        $edudata1[] = $edudata[0]['degree_id'];
                    } else {
                        $data = array(
                            'degree_name' => trim($educat),
                            'status' => '2',
                            'is_other' => '1',
                            'user_id' => $userid,
                            'created_date' => date('y-m-d h:i:s'),
                        );
                        $edudata1[] = $this->common->insert_data_getid($data, 'degree');
                    }
                }
            }
        }
        $edudata = implode(',', $edudata1);
// education data end

        $data = array(
            'post_name' => $jobtitle,
            'post_description' => trim($post_Desc),
            'post_skill' => $skills,
            'post_position' => $position,
            'post_last_date' => date('Y-m-d', strtotime($bod)),
            'country' => $country,
            'state' => $state,
            'city' => $city,
            'min_year' => $min_year,
            'max_year' => $max_year,
            'interview_process' => trim($interview),
            'industry_type' => $industry,
            'degree_name' => $edudata,
            'emp_type' => $emp_type,
            'fresher' => $fresher,
            'min_sal' => $min_sal,
            'max_sal' => $max_sal,
            'post_currency' => $currency,
            'salary_type' => $salary_type,
            'is_delete' => '0',
            'created_date' => date('y-m-d h:i:s'),
            'user_id' => $userid,
            'status' => '1',
        );

        $insert_id = $this->common->insert_data_getid($data, 'rec_post');


        if ($insert_id) {
            $this->session->set_flashdata('success', 'your post inserted successfully');
            redirect('recruiter/home', 'refresh');
        } else {
            $this->session->flashdata('error', 'Sorry!! Your data not inserted');
            redirect('recruiter', 'refresh');
        }
//}
    }

// RECRUITER ADD POST INSERT END
// RECRUITER POST START
    public function rec_post($id = "") {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        $recruiterdata = $this->common->select_data_by_id('recruiter', 'user_id', $userid, $data = 'user_id,designation,rec_firstname,rec_lastname', $join_str = array());
        $this->data['title'] = $this->data['recdata']['rec_firstname'] . ' ' . $this->data['recdata']['rec_lastname'] . ' | Post | Recruiter Profile - Aileensoul';

//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE START
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');
        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE END

        if ($id == $userid || $id == '') {

            $this->recruiter_apply_check();

            $contition_array = array('user_id' => $userid, 'is_delete' => '0');
            $this->data['postdataone'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id,rec_firstname,rec_lastname,recruiter_user_image,profile_background,designation,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        } else {


            $this->rec_avail_check($id);

            $contition_array = array('user_id' => $id, 'is_delete' => '0', 're_step' => '3');
            $this->data['postdataone'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id,rec_firstname,rec_lastname,recruiter_user_image,profile_background,designation,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        }

        if ($userid) {
            $this->load->view('recruiter/rec_post', $this->data);
        } else {
            redirect('login/');
        }
    }

// RECRUITER POST END
// RECRUITER EDIT POST START
    public function edit_post($id = "") {

        $this->data['title'] = 'Edit Post | Recruiter Profile - Aileensoul';

        $this->recruiter_apply_check();

        $userid = $this->session->userdata('aileenuser');

//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE START
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');
        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE END


        $contition_array = array('status' => '1', 'type' => '1');
        $this->data['skill'] = $this->common->select_data_by_condition('skill', $contition_array, $data = '*', $sortby = 'skill', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('status' => '1');
        $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = '*', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('status' => '1');
        $this->data['currency'] = $this->common->select_data_by_condition('currency', $contition_array, $data = '*', $sortby = 'currency_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('is_delete' => '0', 'is_other' => '0', 'industry_name !=' => "Others");
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
        $university_data = $this->data['industry'] = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = '*', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('is_delete' => '0', 'status' => '1', 'industry_name' => "Others");
        $this->data['industry_otherdata'] = $this->common->select_data_by_condition('job_industry', $contition_array, $data = '*', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('is_delete' => '0', 'degree_name !=' => "Other");
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
        $degree = $this->data['degree'] = $this->common->select_data_by_search('degree', $search_condition, $contition_array, $data = '*', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $postdatas = $this->data['postdata'] = $this->common->select_data_by_id('rec_post', 'post_id', $id, $data = '*', $join_str = array());
//Selected Job titlre fetch
        $contition_array = array('title_id' => $postdatas[0]['post_name']);
        $jobtitle = $this->common->select_data_by_condition('job_title', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->data['work_title'] = $jobtitle[0]['name'];

//Selected skill fetch
        $work_skill = explode(',', $postdatas[0]['post_skill']);

        foreach ($work_skill as $skill) {
            $contition_array = array('skill_id' => $skill);
            $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
            $detailes[] = $skilldata[0]['skill'];
        }

        $this->data['work_skill'] = implode(',', $detailes);

//Selected degree fetch

        $work_degree = explode(',', $postdatas[0]['degree_name']);


        foreach ($work_degree as $degree) {
            $contition_array = array('degree_id' => $degree);
            $degreedata = $this->common->select_data_by_condition('degree', $contition_array, $data = 'degree_id,degree_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
            $degreedetails[] = $degreedata[0]['degree_name'];
        }

        $this->data['degree_data'] = implode(',', $degreedetails);

//for getting state data
        $contition_array = array('status' => '1', 'country_id' => $postdatas[0]['country']);
        $this->data['states'] = $this->common->select_data_by_condition('states', $contition_array, $data = '*', $sortby = 'state_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

//for getting city data
        $contition_array = array('status' => '1', 'state_id' => $postdatas[0]['state']);
        $this->data['cities'] = $this->common->select_data_by_condition('cities', $contition_array, $data = '*', $sortby = 'city_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $skildata = explode(',', $this->data['postdata'][0]['post_skill']);

        $skildata = array_filter(array_map('trim', $skildata));

        $this->data['selectdata'] = $skildata;

        $skildata1 = explode(',', $this->data['postdata'][0]['degree_name']);
        $skildata1 = array_filter(array_map('trim', $skildata1));

        $this->data['selectdata1'] = $skildata1;

        $this->data['country1'] = $this->data['postdata'][0]['country'];
        $this->data['city1'] = $this->data['postdata'][0]['city'];

//jobtitle data fetch
        $contition_array = array('status' => 'publish');
        $jobtitle = $this->common->select_data_by_condition('job_title', $contition_array, $data = 'name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

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

        $this->load->view('recruiter/edit_post', $this->data);
    }

// RECRUITER EDIT POST END
// RECRUITER EDIT POST INSERT START
    public function update_post($id = "") {
        $this->recruiter_apply_check();

        $skill = $this->input->post('skills');

        $bod = $this->input->post('last_date');
        $bod = str_replace('/', '-', $bod);

        $education = $this->input->post('degree');
        $userid = $this->session->userdata('aileenuser');

//if user deactive profile then redirect to recruiter/index untill active profile start
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');
        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
//if user deactive profile then redirect to recruiter/index untill active profile End
        $this->form_validation->set_rules('post_name', 'Post Name', 'required');
        $this->form_validation->set_rules('post_desc', ' Description', 'required');
        $this->form_validation->set_rules('country', 'Country', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('currency', 'Currency', 'required');

// job title start  
        $jobtitle = $this->input->post('post_name');

        if ($jobtitle != " ") {
            $contition_array = array('name' => trim($jobtitle));
            $jobdata = $this->common->select_data_by_condition('job_title', $contition_array, $data = 'title_id,name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
            if ($jobdata) {
                $jobtitle = $jobdata[0]['title_id'];
            } else {
                $data = array(
                    'name' => ucfirst($this->input->post('post_name')),
                    'slug' => $this->common->clean('post_name'),
                    'status' => 'draft',
                );
                $jobtitle = $this->common->insert_data_getid($data, 'job_title');
            }
        }
// job title ENd
// skills  start   
        $skills = $this->input->post('skills');
        $skills = explode(',', $skills);
        if (count($skills) > 0) {

            foreach ($skills as $ski) {
                if ($ski != " ") {
                    $contition_array = array('skill' => trim($ski), 'type' => '4');
                    $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');

                    if (count($skilldata) == 0) {
                        $contition_array = array('skill' => trim($ski), 'type' => '4');

                        $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                    }

                    if ($skilldata) {
                        $skill1[] = $skilldata[0]['skill_id'];
                    } else {
                        $data = array(
                            'skill' => $ski,
                            'status' => '1',
                            'type' => '4',
                            'user_id' => $userid,
                        );
                        $skill1[] = $this->common->insert_data_getid($data, 'skill');
                    }
                }
            }
        }
        $skills = implode(',', $skill1);
// skills  End   
// education data start

        $education = $this->input->post('education');
        $education = explode(',', $education);
        if (count($education) > 0) {

            foreach ($education as $educat) {
                if ($educat != " ") {
                    $contition_array = array('degree_name' => trim($educat), 'status' => '1', 'is_other' => '0');
                    $edudata = $this->common->select_data_by_condition('degree', $contition_array, $data = 'degree_id,degree_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');

                    if (count($edudata) < 0) {
                        $contition_array = array('degree_name' => trim($educat), 'status' => '2', 'is_other' => '1', 'user_id' => $userid);
                        $edudata = $this->common->select_data_by_condition('degree', $contition_array, $data = 'degree_id,degree_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                    }
                    if ($edudata) {
                        $edudata1[] = $edudata[0]['degree_id'];
                    } else {
                        $data = array(
                            'degree_name' => trim($educat),
                            'status' => '2',
                            'is_other' => '1',
                            'user_id' => $userid,
                            'created_date' => date('y-m-d h:i:s'),
                        );
                        $edudata1[] = $this->common->insert_data_getid($data, 'degree');
                    }
                }
            }
        }
        $edudata = implode(',', $edudata1);
// education data end

        $data = array(
            'post_name' => $jobtitle,
            'post_description' => trim($this->input->post('post_desc')),
            'post_skill' => $skills,
            'post_position' => trim($this->input->post('position')),
            'post_last_date' => date('Y-m-d', strtotime($bod)),
            'country' => $this->input->post('country'),
            'state' => $this->input->post('state'),
            'city' => $this->input->post('city'),
            'min_year' => $this->input->post('minyear'),
            'max_year' => $this->input->post('maxyear'),
            'interview_process' => trim($this->input->post('interview')),
            'industry_type' => trim($this->input->post('industry')),
            'emp_type' => $this->input->post('emp_type'),
            'degree_name' => $edudata,
            'fresher' => $this->input->post('fresher'),
            'min_sal' => trim($this->input->post('minsal')),
            'max_sal' => trim($this->input->post('maxsal')),
            'post_currency' => $this->input->post('currency'),
            'salary_type' => $this->input->post('salary_type'),
            'modify_date' => date('y-m-d h:i:s')
        );
        $update = $this->common->update_data($data, 'rec_post', 'post_id', $id);

        if ($update) {
            $this->session->set_flashdata('success', 'your post updated successfully');
            redirect('recruiter/post', 'refresh');
        } else {
            $this->session->flashdata('error', 'Sorry!! Your data not inserted');
            redirect('recruiter', 'refresh');
        }
        $this->data['postdata'] = $this->common->select_data_by_id('rec_post', 'post_id', $id, $data = '*', $join_str = array());
        $this->load->view('recruiter/edit_post', $this->data);
    }

// RECRUITER EDIT POST INSERT END
//deactivate user start
    public function deactivate() {
        $this->recruiter_apply_check();

        $id = $_POST['id'];
        $data = array(
            're_status' => '0'
        );
        $update = $this->common->update_data($data, 'recruiter', 'user_id', $id);

        if ($update) {
            $this->session->set_flashdata('success', 'You are deactivate successfully.');
            redirect('profiles/' . $this->session->userdata('aileenuser_slug'), 'refresh');
        } else {
            $this->session->flashdata('error', 'Sorry!! Your are not deactivate!!');
            redirect('recruiter', 'refresh');
        }
    }

// deactivate user end
//reactivate account start

    public function reactivate() {



        $userid = $this->session->userdata('aileenuser');


        $data = array(
            're_status' => '1',
            'modify_date' => date('y-m-d h:i:s')
        );

        $updatdata = $this->common->update_data($data, 'recruiter', 'user_id', $userid);
        if ($updatdata) {

            redirect('recruiter/home', refresh);
        } else {

            redirect('recruiter/reactivate', refresh);
        }
    }

//reactivate account End
// RECRUITER POST CITY AJAX START
    public function ajax_data() {

        if (isset($_POST["country_id"]) && !empty($_POST["country_id"])) {
//Get all state data
            $contition_array = array('country_id' => $_POST["country_id"], 'status' => '1');
            $state = $this->data['states'] = $this->common->select_data_by_condition('states', $contition_array, $data = 'state_id,state_name', $sortby = 'state_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

//Count total number of rows
//Display states list
            if (count($state) > 0) {
                echo '<option value="">Select state</option>';
                foreach ($state as $st) {
                    echo '<option value="' . $st['state_id'] . '">' . $st['state_name'] . '</option>';
                }
            } else {
                echo '<option value="">State not available</option>';
            }
        }

        if (isset($_POST["state_id"]) && !empty($_POST["state_id"])) {
//Get all city data
            $contition_array = array('state_id' => $_POST["state_id"], 'status' => '1');
            $city = $this->data['city'] = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_id,city_name', $sortby = 'city_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

//Display cities list
            if (count($city) > 0) {
                echo '<option value="">Select city</option>';
                foreach ($city as $cit) {
                    echo '<option value="' . $cit['city_id'] . '">' . $cit['city_name'] . '</option>';
                }
            } else {
                echo '<option value="">City not available</option>';
            }
        }
    }

// RECRUITER POST CITY AJAX END
// RECRUITER SAVED CANDIDATE LIST START
    public function save_candidate() {
        $this->recruiter_apply_check();
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        $recruiterdata = $this->common->select_data_by_id('recruiter', 'user_id', $userid, $data = 'user_id,designation,rec_firstname,rec_lastname', $join_str = array());
        $this->data['title'] = $recruiterdata[0]['rec_firstname'] . ' ' . $recruiterdata[0]['rec_lastname'] . ' | Saved Candidate | Recruiter Profile - Aileensoul';


//if user deactive profile then redirect to recruiter/index untill active profile start
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');
        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($recruiter_deactive) {
            redirect('recruiter/');
        }

        $join_str1 = array(array(
                'join_type' => 'left',
                'table' => 'job_add_edu',
                'join_table_id' => 'save.to_id',
                'from_table_id' => 'job_add_edu.user_id'),
            array(
                'join_type' => 'left',
                'table' => 'job_reg',
                'join_table_id' => 'save.to_id',
                'from_table_id' => 'job_reg.user_id'),
            array(
                'join_type' => 'left',
                'table' => 'job_graduation',
                'join_table_id' => 'save.to_id',
                'from_table_id' => 'job_graduation.user_id')
        );

        $data = "job_reg.user_id as userid,job_reg.fname,job_reg.lname,job_reg.email,job_reg.phnno,job_reg.keyskill,job_reg.work_job_title,job_reg.work_job_industry,job_reg.work_job_city,job_reg.job_user_image,job_add_edu.*,job_graduation.*,save.status,save.save_id";
        $contition_array1 = array('save.from_id' => $userid, 'save.status' => '0', 'save.save_type' => '1');
        $recdata1 = $this->data['recdata1'] = $this->common->select_data_by_condition('save', $contition_array1, $data, $sortby = 'save_id', $orderby = 'desc', $limit = '', $offset = '', $join_str1, $groupby = '');

        foreach ($recdata1 as $ke => $arr) {
            $recdata2[] = $arr;
        }
        $new = array();
        foreach ($recdata2 as $value) {
            $new[$value['user_id']] = $value;
        }
        $this->data['savedata'] = $new;
        $this->load->view('recruiter/saved_candidate', $this->data);
    }

// RECRUITER SAVED CANDIDATE LIST END
// RECRUITER PROFILE START
    public function rec_profile($id = "") {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        $recruiterdata = $this->common->select_data_by_id('recruiter', 'user_id', $userid, $data = 'user_id,designation,rec_firstname,rec_lastname', $join_str = array());



//if user deactive profile then redirect to recruiter/index untill active profile start
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');

        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($recruiter_deactive) {
            redirect('recruiter/');
        }

        if ($id == $userid || $id == '') {
            $this->recruiter_apply_check();
        } else {
            $this->rec_avail_check($id);
        }

        $this->data['title'] = 'Recruiter ' . ucwords($this->data['recdata']['rec_firstname']) . ' ' . ucwords($this->data['recdata']['rec_lastname']) . ' from ' . ucwords($this->data['recdata']['re_comp_name']) . ' | Details | Recruiter Profile - Aileensoul';
        $this->data['reg_id'] = $id;
        if ($userid) {
            $this->load->view('recruiter/rec_profile', $this->data);
        } else {
            $this->load->view('recruiter/rec_liveprofile', $this->data);
        }
    }

// RECRUITER PROFILE END
// REMOVE POST START
    public function remove_post() {

        $this->recruiter_apply_check();

        $postid = $_POST['post_id'];
        $data = array(
            'is_delete' => '1',
            'modify_date' => date('y-m-d h:i:s')
        );

        $updatedata = $this->common->update_data($data, 'rec_post', 'post_id', $postid);
    }

// REMOVE POST END
// REMOVE CANDIDATE START
//Remove Save candidate by search controller start
    public function remove_candidate() {
        $this->recruiter_apply_check();

        $saveid = $_POST['save_id'];

        $userid = $this->session->userdata('aileenuser');

//if user deactive profile then redirect to recruiter/index untill active profile start
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');
        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
//if user deactive profile then redirect to recruiter/index untill active profile End

        $data = array(
            'status' => '1'
        );

        $updatedata = $this->common->update_data($data, 'save', 'save_id', $saveid);
    }

//REMOVE CANDIDATE END
//VIEW APPLIED LIST START
    public function view_apply_list($id = "") {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        $recruiterdata = $this->common->select_data_by_id('recruiter', 'user_id', $userid, $data = 'user_id,designation,rec_firstname,rec_lastname', $join_str = array());
        $this->data['title'] = $recruiterdata[0]['rec_firstname'] . ' ' . $recruiterdata[0]['rec_lastname'] . ' | Applied Candidate | Recruiter Profile - Aileensoul';

        $this->recruiter_apply_check();

        $userid = $this->session->userdata('aileenuser');

        $this->data['postid'] = $id;

        $join_str = array(
            array(
                'join_type' => 'left',
                'table' => 'job_add_edu',
                'join_table_id' => 'job_reg.user_id',
                'from_table_id' => 'job_add_edu.user_id'),
            array(
                'join_type' => '',
                'table' => 'job_apply',
                'join_table_id' => 'job_reg.user_id',
                'from_table_id' => 'job_apply.user_id'),
        );
        $contition_array = array('job_apply.post_id' => $id, 'job_reg.status' => '1', 'job_apply.job_delete' => '0', 'job_reg.job_step' => '10');

        $data = "job_reg.job_id,job_reg.user_id as userid,job_reg.fname,job_reg.lname,job_reg.email,job_reg.work_job_industry,job_reg.work_job_city,job_reg.work_job_title,job_reg.phnno,job_reg.keyskill,job_reg.experience,job_reg.slug,job_add_edu.*,job_reg.job_user_image";
        $userdata = $this->data['user_data'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = 'job_id');

        $this->load->view('recruiter/view_apply_list', $this->data);
    }

// VIEW APPLIED LIST END
// RECOMMANDED CANDIDATE AJAX LAZZY LOADER DATA START
    public function recommen_candidate_post($id = "") {

        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;

        $this->recruiter_apply_check();

        $userid = $this->session->userdata('aileenuser');

//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE START
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');
        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE END
//FETCH RECRUITER DATA
// FETCH RECRUITER POST    
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $recpostdata = $this->data['recpostdata'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data = 'post_id,post_skill,post_name,industry_type', $sortby = 'post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        foreach ($recpostdata as $postdata) {

            // FETCH SKILL WISE JOB START
            $recskill = explode(',', $postdata['post_skill']);
            $recskill = array_filter(array_map('trim', $recskill));
            foreach ($recskill as $othrd) {
                $skilluser = array();
                if ($othrd != '') {
                    $contition_array = array('status' => '1', 'is_delete' => '0', 'job_step' => '10', 'user_id != ' => $userid, 'FIND_IN_SET("' . $othrd . '", keyskill) != ' => '0');
                    $skilluser[] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_id', $sortby = 'job_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                }
            }

            $skillaarray = array_reduce($skilluser, 'array_merge', array());

            // FETCH SKILL WISE JOB END
            // FETCH TITLE WISE JOB END
            $titleuser = array();
            $contition_array = array('status' => '1', 'is_delete' => '0', 'job_step' => '10', 'user_id != ' => $userid, 'work_job_title' => $postdata['post_name']);
            $titleuser[] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_id', $sortby = 'job_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $titlearray = array_reduce($titleuser, 'array_merge', array());
            // FETCH TITLE WISE JOB END
            // FETCH INDUSTERY WISE JOB END
            $induser = array();
            $contition_array = array('status' => '1', 'is_delete' => '0', 'job_step' => '10', 'user_id != ' => $userid, 'work_job_industry' => $postdata['industry_type']);
            $induser[] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_id', $sortby = 'job_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $indarray = array_reduce($induser, 'array_merge', array());
            // FETCH INDUSTERY WISE JOB END

            $recommendata = array_merge((array) $titlearray, (array) $skillaarray, (array) $indarray);
            $recommendata[] = array_reduce($recommendata, 'array_merge', array());
            $newdata[] = array_unique($recommendata, SORT_REGULAR);
        }

        $recommanarray = array_reduce($newdata, 'array_merge', array());
        $recommanarray = array_unique($recommanarray, SORT_REGULAR);
        foreach ($recommanarray as $key => $candi) {
            foreach ($candi as $ke) {
                $join_str1 = array(
                    array(
                        'join_type' => 'left',
                        'table' => 'job_add_edu',
                        'join_table_id' => 'job_reg.user_id',
                        'from_table_id' => 'job_add_edu.user_id'),
                    array(
                        'join_type' => 'left',
                        'table' => 'job_graduation',
                        'join_table_id' => 'job_reg.user_id',
                        'from_table_id' => 'job_graduation.user_id')
                );
                $data = 'job_reg.user_id as iduser,job_reg.fname,job_reg.lname,job_reg.email,job_reg.phnno,job_reg.language,job_reg.keyskill,job_reg.experience,job_reg.job_user_image,job_reg.designation,job_reg.work_job_title,job_reg.work_job_industry,job_reg.work_job_city,job_reg.slug,job_add_edu.degree,job_add_edu.stream,job_add_edu.board_primary,job_add_edu.board_secondary,job_add_edu.board_higher_secondary,job_add_edu.percentage_primary,job_add_edu.percentage_secondary,job_add_edu.percentage_higher_secondary,job_graduation.*';
                $contition_array = array('job_reg.job_id' => $ke, 'job_reg.is_delete' => '0', 'job_reg.status' => '1', 'job_reg.job_step' => '10');
                $jobdata[] = $this->data['jobrec'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data, $sortby = 'job_id', $orderby = 'desc', $limit = '', $offset = '', $join_str1, $groupby = '');
            }
        }
        $jobdata = array_reduce($jobdata, 'array_merge', array());
        $candidatejob = $this->data['candidatejob'] = $jobdata;
        $tempArr = array_unique(array_column($candidatejob, 'iduser'));
        $candidatejob = array_intersect_key($candidatejob, $tempArr);

        $postdata = '';

        $candidatejob1 = array_slice($candidatejob, $start, $perpage);
        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($candidatejob);
        }

        $postdata .= '<input type = "hidden" class = "page_number" value = "' . $page . '" />';
        $postdata .= '<input type = "hidden" class = "total_record" value = "' . $_GET["total_record"] . '" />';
        $postdata .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';

        if ($candidatejob) {
            foreach ($candidatejob1 as $row) {

                $postdata .= '<div class="profile-job-post-detail clearfix">';
                $postdata .= '<div class = "profile-job-post-title-inside clearfix">';
                $postdata .= '<div class = "profile-job-profile-button clearfix">';
                $postdata .= '<div id = "popup1" class = "overlay">';
                $postdata .= '<div class = "popup">';
                $postdata .= '<div class = "pop_content">';
                $postdata .= 'Your User is Successfully Saved.';
                $postdata .= '<p class = "okk"><a class = "okbtn" href = "javascript:void(0)">Ok</a></p>';
                $postdata .= '</div>';
                $postdata .= '</div>';
                $postdata .= '</div>';
                $postdata .= '<div class = "profile-job-post-location-name-rec">';
                $postdata .= '<div style = "display: inline-block; float: left;">';
                $postdata .= '<div class = "buisness-profile-pic-candidate">';

                $imagee = $this->config->item('job_profile_thumb_upload_path') . $row['job_user_image'];

                if (file_exists($imagee) && $row['job_user_image'] != '') {

                    $postdata .= '<a href="' . base_url() . 'job/resume/' . $row['slug'] . '" title="' . $row['fname'] . ' ' . $row['lname'] . '">';
                    $postdata .= '<img src="' . JOB_PROFILE_THUMB_UPLOAD_URL . $row['job_user_image'] . '" alt="' . $row[0]['fname'] . ' ' . $row[0]['lname'] . '">';
                    $postdata .= '</a>';
                } else {


                    $a = $row['fname'];
                    $acr = substr($a, 0, 1);

                    $b = $row['lname'];
                    $acr1 = substr($b, 0, 1);

                    $postdata .= '<a href="' . base_url() . 'job/resume/' . $row['slug'] . '" title="' . $row['fname'] . ' ' . $row['lname'] . '">';
                    $postdata .= '<div class="post-img-profile">';
                    $postdata .= '' . ucfirst(strtolower($acr)) . ucfirst(strtolower($acr1)) . '';

                    $postdata .= '</div>';
                    $postdata .= '</a>';
                }

                $postdata .= '</div>';
                $postdata .= '</div>';

                $postdata .= '<div class="designation_rec fl">';
                $postdata .= '<ul>';
                $postdata .= '<li>';
                $postdata .= '<a  class="post_name" href="' . base_url() . 'job/resume/' . $row['slug'] . '" title="' . $row['fname'] . ' ' . $row['lname'] . '">';
                $postdata .= '' . ucfirst(strtolower($row['fname'])) . ' ' . ucfirst(strtolower($row['lname'])) . '</a>';
                $postdata .= '</li>';

                $postdata .= '<li style="display: block;">';
                $postdata .= '<a  class="post_designation" href="javascript:void(0)" title="' . $row['designation'] . '">';
                if ($row['designation']) {
                    $postdata .= '' . $row['designation'] . '';
                } else {
                    $postdata .= "Current Work";
                }
                $postdata .= '</a>';
                $postdata .= '</li>';
                $postdata .= '</ul>';
                $postdata .= '</div>';
                $postdata .= '</div>';
                $postdata .= '</div>';
                $postdata .= '</div>';

                $contition_array = array('user_id' => $row['iduser'], 'type' => '3', 'status' => '1');
                unset($other_skill);

                $other_skill = $this->common->select_data_by_condition('skill', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                $postdata .= '<div class="profile-job-post-title clearfix">';
                $postdata .= '<div class="profile-job-profile-menu">';
                $postdata .= '<ul class="clearfix">';

                if ($row['work_job_title']) {
                    $contition_array = array('title_id' => $row['work_job_title']);
                    $jobtitle = $this->common->select_data_by_condition('job_title', $contition_array, $data = 'name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    if ($jobtitle != "") {
                        $postdata .= '<li> <b> Job Title</b> <span>';
                        $postdata .= '' . $jobtitle[0]['name'] . '';
                        $postdata .= '</span>';
                        $postdata .= '</li>';
                    }
                }
                if ($row['keyskill']) {
                    $detailes = array();
                    $work_skill = explode(',', $row['keyskill']);
                    foreach ($work_skill as $skill) {
                        $contition_array = array('skill_id' => $skill);
                        $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                        $detailes[] = $skilldata[0]['skill'];
                    }
                    $postdata .= '<li> <b> Skills</b> <span>';
                    $postdata .= '' . implode(',', $detailes) . '';
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                }
                if ($row['work_job_industry']) {
                    $contition_array = array('industry_id' => $row['work_job_industry']);
                    $industry = $this->common->select_data_by_condition('job_industry', $contition_array, $data = 'industry_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    $postdata .= '<li> <b> Industry</b> <span>';
                    $postdata .= '' . $industry[0]['industry_name'] . '';
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                }

                if ($row['work_job_city']) {
                    $cities = array();
                    $work_city = explode(',', $row['work_job_city']);
                    foreach ($work_city as $city) {
                        $contition_array = array('city_id' => $city);
                        $citydata = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_id,city_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                        if ($citydata) {
                            $cities[] = $citydata[0]['city_name'];
                        }
                    }
                    $postdata .= '<li> <b> Preferred Cites</b> <span>';
                    $postdata .= '' . implode(',', $cities) . '';
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                }
                $contition_array = array('user_id' => $row['iduser'], 'experience' => 'Experience', 'status' => '1');
                $experiance = $this->common->select_data_by_condition('job_add_workexp', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if ($experiance[0]['experience_year'] != '') {
                    $total_work_year = 0;
                    $total_work_month = 0;
                    foreach ($experiance as $work1) {
                        $total_work_year += $work1['experience_year'];
                        $total_work_month += $work1['experience_month'];
                    }
                    $postdata .= '<li> <b> Total Experience</b>';
                    $postdata .= '<span>';
                    if ($total_work_month == '12 month' && $total_work_year == '0 year') {
                        $postdata .= '1 year';
                    } else {
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
                        $postdata .= '' . $year . '';
                        $postdata .= '&nbsp';
                        $postdata .= 'Year';
                        $postdata .= '&nbsp';
                        if ($total_work_month != 0) {
                            $postdata .= '' . $total_work_month . '';
                            $postdata .= '&nbsp';
                            $postdata .= 'Month';
                        }
                    }
                    $postdata .= '</li>';
                } else {

                    if ($row[0]['experience'] == 'Experience') {
                        $postdata .= '<li> <b> Total Experience</b>';
                        if ($row[0]['exp_y'] != " " && $row[0]['exp_m'] != " ") {
                            if ($row[0]['exp_m'] == '12 month' && $row[0]['exp_y'] == '0 year') {
                                $postdata .= "1 year";
                            } else {

                                if ($row[0]['exp_y'] != '0 year') {
                                    $postdata .= $row[0]['exp_y'];
                                }
                                if ($row[0]['exp_m'] != '0 month') {
                                    $postdata .= ' ' . $row[0]['exp_m'];
                                }
                            }
                        }
                    }
                    if ($row['experience'] == 'Fresher') {
                        $postdata .= '<li> <b> Total Experience</b>';
                        $postdata .= '<span>' . $row['experience'] . '</span>';
                        $postdata .= '</li>';
                    } //if complete
                }//else complete

                if ($row['board_primary'] && $row['board_secondary'] && $row['board_higher_secondary'] && $row['degree']) {
                    $postdata .= '<li>';
                    $postdata .= '<b>Degree</b><span>';
                    $cache_time = $this->db->get_where('degree', array('degree_id' => $row['degree']))->row()->degree_name;
                    if ($cache_time) {
                        $postdata .= '' . $cache_time . '';
                    } else {
                        $postdata .= '' . PROFILENA . '';
                    }
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                    $postdata .= '<li><b>Stream</b>';
                    $postdata .= '<span>';
                    $cache_time = $this->db->get_where('stream', array('stream_id' => $row['stream']))->row()->stream_name;
                    if ($cache_time) {
                        $postdata .= '' . $cache_time . '';
                    } else {
                        $postdata .= '' . PROFILENA . '';
                    }
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                } elseif ($row['board_secondary'] && $row['board_higher_secondary'] && $row['degree']) {
                    $postdata .= '<li>';
                    $postdata .= '<b>Degree</b><span>';
                    $cache_time = $this->db->get_where('degree', array('degree_id' => $row['degree']))->row()->degree_name;
                    if ($cache_time) {
                        $postdata .= '' . $cache_time . '';
                    } else {
                        $postdata .= '' . PROFILENA . '';
                    }

                    $postdata .= '</span>';
                    $postdata .= '</li>';
                    $postdata .= '<li><b>Stream</b>';
                    $postdata .= '<span>';

                    $cache_time = $this->db->get_where('stream', array('stream_id' => $row['stream']))->row()->stream_name;
                    if ($cache_time) {
                        $postdata .= '' . $cache_time . '';
                    } else {
                        $postdata .= '' . PROFILENA . '';
                    }
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                } elseif ($row['board_higher_secondary'] && $row['degree']) {

                    $postdata .= '<li>';
                    $postdata .= '<b>Degree</b><span>';
                    $cache_time = $this->db->get_where('degree', array('degree_id' => $row['degree']))->row()->degree_name;
                    if ($cache_time) {
                        $postdata .= '' . $cache_time . '';
                    } else {
                        $postdata .= '' . PROFILENA . '';
                    }
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                    $postdata .= '<li><b>Stream</b>';
                    $postdata .= '<span>';
                    $cache_time = $this->db->get_where('stream', array('stream_id' => $row['stream']))->row()->stream_name;
                    if ($cache_time) {
                        $postdata .= '' . $cache_time . '';
                    } else {
                        $postdata .= '' . PROFILENA . '';
                    }
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                } else if ($row['board_secondary'] && $row['degree']) {
                    $postdata .= '<li>';
                    $postdata .= '<b>Degree</b><span>';
                    $cache_time = $this->db->get_where('degree', array('degree_id' => $row['degree']))->row()->degree_name;
                    if ($cache_time) {
                        $postdata .= '' . $cache_time . '';
                    } else {
                        $postdata .= '' . PROFILENA . '';
                    }

                    $postdata .= '</span>';
                    $postdata .= '</li>';
                    $postdata .= '<li><b>Stream</b>';
                    $postdata .= '<span>';
                    $cache_time = $this->db->get_where('stream', array('stream_id' => $row['stream']))->row()->stream_name;
                    if ($cache_time) {
                        $postdata .= '' . $cache_time . '';
                    } else {
                        $postdata .= '' . PROFILENA . '';
                    }
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                } elseif ($row['board_primary'] && $row['degree']) {
                    $postdata .= '<li>';
                    $postdata .= '<b>Degree</b><span>';
                    $cache_time = $this->db->get_where('degree', array('degree_id' => $row['degree']))->row()->degree_name;
                    if ($cache_time) {
                        $postdata .= '' . $cache_time . '';
                    } else {
                        $postdata .= '' . PROFILENA . '';
                    }
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                    $postdata .= '<li><b>Stream</b>';
                    $postdata .= '<span>';
                    $cache_time = $this->db->get_where('stream', array('stream_id' => $row['stream']))->row()->stream_name;
                    if ($cache_time) {
                        $postdata .= '' . $cache_time . '';
                    } else {
                        $postdata .= '' . PROFILENA . '';
                    }
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                } elseif ($row['board_primary'] && $row['board_secondary'] && $row['board_higher_secondary']) {
                    $postdata .= '<li><b>Board of Higher Secondary</b>';
                    $postdata .= '<span>';
                    $postdata .= '' . $row['board_higher_secondary'] . '';
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                    $postdata .= '<li><b>Percentage of Higher Secondary</b>';
                    $postdata .= '<span>';
                    $postdata .= '' . $row['percentage_higher_secondary'] . '';
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                } elseif ($row['board_secondary'] && $row['board_higher_secondary']) {
                    $postdata .= '<li><b>Board of Higher Secondary</b>';
                    $postdata .= '<span>';
                    $postdata .= '' . $row['board_higher_secondary'] . '';
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                    $postdata .= '<li><b>Percentage of Higher Secondary</b>';
                    $postdata .= '<span>';
                    $postdata .= '' . $row['percentage_higher_secondary'] . '';
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                } elseif ($row['board_primary'] && $row['board_higher_secondary']) {


                    $postdata .= '<li><b>Board of Higher Secondary</b>';
                    $postdata .= '<span>';
                    $postdata .= '' . $row['board_higher_secondary'] . '';
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                    $postdata .= '<li><b>Percentage of Higher Secondary</b>';
                    $postdata .= '<span>';
                    $postdata .= '' . $row['percentage_higher_secondary'] . '';
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                } elseif ($row['board_primary'] && $row['board_secondary']) {

                    $postdata .= '<li><b>Board of Secondary</b>';
                    $postdata .= '<span>';
                    $postdata .= '' . $row['board_secondary'] . '';
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                    $postdata .= '<li><b>Percentage of Secondary</b>';
                    $postdata .= '<span>';
                    $postdata .= '' . $row['percentage_secondary'] . '';
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                } elseif ($row['degree']) {
                    $postdata .= '<li>';
                    $postdata .= '<b>Degree</b><span>';
                    $cache_time = $this->db->get_where('degree', array('degree_id' => $row['degree']))->row()->degree_name;
                    if ($cache_time) {
                        $postdata .= '' . $cache_time . '';
                    } else {
                        $postdata .= '' . PROFILENA . '';
                    }

                    $postdata .= '</span>';
                    $postdata .= '</li>';
                    $postdata .= '<li><b>Stream</b>';
                    $postdata .= '<span>';
                    $cache_time = $this->db->get_where('stream', array('stream_id' => $row['stream']))->row()->stream_name;
                    if ($cache_time) {
                        $postdata .= '' . $cache_time . '';
                    } else {
                        $postdata .= '' . PROFILENA . '';
                    }
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                } elseif ($row['board_higher_secondary']) {

                    $postdata .= '<li><b>Board of Higher Secondary</b>';
                    $postdata .= '<span>';
                    $postdata .= '' . $row['board_higher_secondary'] . '';
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                    $postdata .= '<li><b>Percentage of Higher Secondary</b>';
                    $postdata .= '<span>';
                    $postdata .= '' . $row['percentage_higher_secondary'] . '';
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                } elseif ($row['board_secondary']) {

                    $postdata .= '<li><b>Board of Secondary</b>';
                    $postdata .= '<span>';
                    $postdata .= '' . $row['board_secondary'] . '';
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                    $postdata .= '<li><b>Percentage of Secondary</b>';
                    $postdata .= '<span>';
                    $postdata .= '' . $row['percentage_secondary'] . '';
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                } elseif ($row['board_primary']) {

                    $postdata .= '<li><b>Board of Primary</b>';
                    $postdata .= '<span>';
                    $postdata .= '' . $row['board_primary'] . '';
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                    $postdata .= '<li><b>Percentage of Primary</b>';
                    $postdata .= '<span>';
                    $postdata .= '' . $row['percentage_primary'] . '';
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                }
                $postdata .= '<li><b>E-mail</b><span>';
                if ($row['email']) {
                    $postdata .= '' . $row['email'] . '';
                } else {
                    $postdata .= '' . PROFILENA . '';
                }
                $postdata .= '</span>';
                $postdata .= '</li>';

                if ($row['phnno']) {
                    $postdata .= '<li><b>Mobile Number</b><span>';
                    $postdata .= '' . $row['phnno'] . '';
                    $postdata .= '</span>';
                    $postdata .= '</li>';
                }
                $postdata .= '</ul>';
                $postdata .= '</div>';
                $postdata .= '<div class="profile-job-profile-button clearfix">';
                $postdata .= '<div class="apply-btn fr">';
                $userid = $this->session->userdata('aileenuser');
                $contition_array = array('from_id' => $userid, 'to_id' => $row['iduser'], 'save_type' => 1, 'status' => '0');
                $data = $this->common->select_data_by_condition('save', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($userid != $row['iduser']) {
                    if (!$data) {

                        $postdata .= '<a title="Message" href="' . base_url() . 'chat/abc/2/1/' . $row['iduser'] . '">Message</a>';


                        $postdata .= '<input type="hidden" id="hideenuser' . $row['iduser'] . '" value= "' . $data[0]['save_id'] . '">';

                        $postdata .= '<a title="Save" id="' . $row['iduser'] . '" onClick="savepopup(' . $row['iduser'] . ')" href="javascript:void(0);" class="saveduser' . $row['iduser'] . '">Save</a>';
                    } else {
                        $postdata .= '<a href="' . base_url() . 'chat/abc/2/1/' . $row['iduser'] . '">Message</a>';
                        $postdata .= '<a class="saved">Saved</a>';
                    }
                }

                $postdata .= '</div> </div>';

                $postdata .= '</div>';
                $postdata .= '</div>';
            }
        } elseif ($recpostdata == NULL) {
            $postdata .= '<div class="text-center rio" style="border: none;">';
            $postdata .= '<div class="no-post-title">';
            $postdata .= '<h4 class="page-heading  product-listing" style="border:0px;">Lets create your job post.</h4>';
            $postdata .= '<h4 class="page-heading  product-listing" style="border:0px;"> It will takes only few minutes.</h4>';
            $postdata .= '</div>';
            $postdata .= '<div  class="add-post-button add-post-custom">';
            $postdata .= '<a title="Post a Job" class="btn btn-3 btn-3b"  href="' . base_url() . 'recruiter/add-post"><i class="fa fa-plus" aria-hidden="true"></i>  Post a Job</a>';
            $postdata .= '</div>';
            $postdata .= '</div>';
        } else {
            $postdata .= '<div class="art-img-nn">';
            $postdata .= '    <div class="art_no_post_img">';
            $postdata .= '<img src="' . base_url() . 'assets/img/job-no1.png" alt="nojobimage">';

            $postdata .= '</div>';
            $postdata .= '<div class="art_no_post_text">';
            $postdata .= 'No Recommended  Candidate  Available.';
            $postdata .= '</div>';
            $postdata .= '</div>';
        }
        $postdata .= '<div class="col-md-1">';
        $postdata .= '</div>';
        echo $postdata;
    }

// RECOMMANDED CANDIDATE AJAX LAZZY LOADER DATA START
// RECRUITER POST AJAX LAZZY LOADER DATA START
    public function ajax_rec_post() {

        $id = $_GET["id"];

// LAZY LOADER CODE START
        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;

        $userid = $this->session->userdata('aileenuser');

//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE START
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');
        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE END

        if ($id == $userid || $id == '') {
            $this->recruiter_apply_check();

            $contition_array = array('user_id' => $userid, 'is_delete' => '0');
            $postdataone = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id,rec_firstname,rec_lastname,recruiter_user_image,profile_background,designation', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

            $limit = $perpage;
            $offset = $start;

            $join_str[0]['table'] = 'recruiter';
            $join_str[0]['join_table_id'] = 'recruiter.user_id';
            $join_str[0]['from_table_id'] = 'rec_post.user_id';
            $join_str[0]['join_type'] = '';

            $data = 'post_id,post_name,post_last_date,post_description,post_skill,post_position,interview_process,min_sal,max_sal,max_year,,min_year,fresher,degree_name,industry_type,emp_type,rec_post.created_date,rec_post.user_id,recruiter.rec_firstname,recruiter.re_comp_name,recruiter.rec_lastname,recruiter.recruiter_user_image,recruiter.profile_background,recruiter.re_comp_profile,city,country,post_currency,salary_type';

            $contition_array = array('rec_post.user_id' => $userid, 'rec_post.is_delete' => '0');
            $rec_postdata = $this->common->select_data_by_condition('rec_post', $contition_array, $data, $sortby = 'post_id', $orderby = 'desc', $limit, $offset, $join_str, $groupby = '');
            $rec_postdata1 = $this->common->select_data_by_condition('rec_post', $contition_array, $data, $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
        } else {
            $this->rec_avail_check($id);

            $contition_array = array('user_id' => $id, 'is_delete' => '0', 're_step' => '3');
            $postdataone = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id,rec_firstname,rec_lastname,recruiter_user_image,profile_background,designation', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

            $limit = $perpage;
            $offset = $start;

            $join_str[0]['table'] = 'recruiter';
            $join_str[0]['join_table_id'] = 'recruiter.user_id';
            $join_str[0]['from_table_id'] = 'rec_post.user_id';
            $join_str[0]['join_type'] = '';

            $data = 'post_id,post_name,post_last_date,post_description,post_skill,post_position,interview_process,min_sal,max_sal,max_year,min_year,fresher,degree_name,industry_type,emp_type,rec_post.created_date,rec_post.user_id,recruiter.rec_firstname,recruiter.re_comp_name,recruiter.rec_lastname,recruiter.recruiter_user_image,recruiter.profile_background,recruiter.re_comp_profile,city,country,post_currency,salary_type';
            $contition_array = array('rec_post.user_id' => $id, 'rec_post.is_delete' => '0', 'recruiter.re_step' => '3');
            $rec_postdata = $this->common->select_data_by_condition('rec_post', $contition_array, $data, $sortby = 'post_id', $orderby = 'desc', $limit, $offset, $join_str, $groupby = '');
            $rec_postdata1 = $this->common->select_data_by_condition('rec_post', $contition_array, $data, $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
        }

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
            if ($userid != $id && $id != '') {

                if (count($rec_postdata) != '') {
                    foreach ($rec_postdata as $post) {
                        $rec_post .= '<div class="all-job-box" id="removepost"' . $post['post_id'] . '">
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

                        $rec_post .= '<div class="post-img">
                            
                                            <a href="' . base_url() . 'recruiter/jobpost/' . $text . $cityname . '-' . $post['user_id'] . '-' . $post['post_id'] . '">';
                        if ($cache_time_1) {

                            if (IMAGEPATHFROM == 'upload') {

                                if (!file_exists($this->config->item('rec_profile_thumb_upload_path') . $cache_time_1)) {

                                    $rec_post .= '<img src="' . base_url('assets/images/commen-img.png') . '" alt="commonimage">';
                                } else {
                                    $rec_post .= '<img src="' . REC_PROFILE_THUMB_UPLOAD_URL . $cache_time_1 . '" alt="' . $cache_time . '">';
                                }
                            } else {
                                //  $rec_post .= '<img src="' . $this->config->item('rec_profile_thumb_upload_path') . $cache_time_1 . '" alt="' . $cache_time_1 . '">';
                                $filename = $this->config->item('rec_profile_thumb_upload_path') . $cache_time_1;
                                $s3 = new S3(awsAccessKey, awsSecretKey);
                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                if ($info) {
                                    $rec_post .= '<img src="' . REC_PROFILE_THUMB_UPLOAD_URL . $cache_time_1 . '" alt="' . $cache_time . '">';
                                } else {
                                    $rec_post .= '<img src="' . base_url('assets/images/commen-img.png') . '" alt="commonimage">';
                                }
                            }
                        } else {

                            $rec_post .= '<img src="' . base_url('assets/images/commen-img.png') . '" alt="commonimage">';
                        }
                        $rec_post .= '</a>';
                        if ($this->session->userdata('aileenuser') == $post['user_id']) {
                            $rec_post .= '<div class="cus-profile" >
    <img src="' . base_url() . 'assets/img/cam.png" title="Upload Company Logo" alt="cameraimage">
    </div>';
                        }
                        $rec_post .= '</div>';


                        $cache_time1 = $this->db->get_where('recruiter', array(
                                    'user_id' => $post['user_id']
                                ))->row()->re_comp_name;

                        $cache_time2 = $this->db->get_where('recruiter', array(
                                    'user_id' => $post['user_id']
                                ))->row()->rec_firstname;
                        $cache_time3 = $this->db->get_where('recruiter', array(
                                    'user_id' => $post['user_id']
                                ))->row()->rec_lastname;
                        $cityname = $this->db->get_where('cities', array('city_id' => $post['city']))->row()->city_name;
                        $countryname = $this->db->get_where('countries', array('country_id' => $post['country']))->row()->country_name;
                        $rec_post .= '<div class="job-top-detail">';
                        $rec_post .= '<h5><a href="' . base_url() . 'recruiter/jobpost/' . $text . $cityname . '-' . $post['user_id'] . '-' . $post['post_id'] . '">';
                        $rec_post .= $post_name;
                        $rec_post .= '</a></h5>';
                        $rec_post .= '<p><a href = "' . base_url() . 'recruiter/jobpost/' . $text . $cityname . '-' . $post['user_id'] . '-' . $post['post_id'] . '">';
                        $rec_post .= $cache_time1;
                        $rec_post .= '</a></p>';
                        $rec_post .= '<p><a href="' . base_url('recruiter/profile/' . $post['user_id']) . '">';
                        $rec_post .= ucwords($cache_time2) . " " . ucfirst($cache_time3);
                        $rec_post .= '</a></p>
            </div>
            </div>
            <div class="all-job-middle">
                <p class="pb5">
                    <span class="location">';
                        $rec_post .= '<span><img class="pr5" src="' . base_url('assets/images/location.png') . '" alt="locationimage">';
                        if ($cityname || $countryname) {
                            if ($cityname) {
                                $rec_post .= $cityname . ', ';
                            }
                            $rec_post .= $countryname;
                        }
                        $rec_post .= '      </span>
                    </span>';
                        $rec_post .= '<span class="exp">
                        <span><img class="pr5" src="' . base_url('assets/images/exp.png') . '" alt="experienceimage">';

                        if (($post['min_year'] != '0' || $post['max_year'] != '0') && ($post['fresher'] == 1)) {
                            $rec_post .= $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year' . " " . "(Fresher can also apply)";
                        } else {
                            if (($post['min_year'] != '0' || $post['max_year'] != '0')) {
                                $rec_post .= $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year';
                            } else {
                                $rec_post .= "Fresher";
                            }
                        }


                        $rec_post .= '</span>
                    </span>
                </p>
                <p>';

                        $rest = substr($post['post_description'], 0, 150);
                        $rec_post .= $rest;

                        if (strlen($post['post_description']) > 150) {
                            $rec_post .= '.....<a href="' . base_url() . 'recruiter/jobpost/' . $text . $cityname . '-' . $post['user_id'] . '-' . $post['post_id'] . '">Read more</a>';
                        }
                        $rec_post .= '</p>

            </div>
            <div class="all-job-bottom">
                <span class="job-post-date"><b>Posted on:</b>';
                        $rec_post .= date('d-M-Y', strtotime($post['created_date']));
                        $rec_post .= '</span>
                <p class="pull-right">';

                        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

                        $contition_array = array('post_id' => $post['post_id'], 'job_delete' => '0', 'user_id' => $userid);
                        $jobapply = $this->data['jobsave'] = $this->common->select_data_by_condition('job_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');


                        if ($jobapply) {
                            $rec_post .= '<a href="javascript:void(0);" class="btn4 button applied">Applied</a>';
                        } else {
                            $contition_array = array(
                                'user_id' => $userid,
                                'job_save' => '2',
                                'post_id ' => $post['post_id'],
                                'job_delete' => '1'
                            );
                            $jobsave = $this->data['jobsave'] = $this->common->select_data_by_condition('job_apply', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                            if ($jobsave) {
                                $rec_post .= '<a href="javascript:void(0);" class="btn4 saved savedpost' . $post['post_id'] . '">Saved</a>';
                            } else {
                                $rec_post .= '<a href="javascript:void(0);" id="' . $post['post_id'] . '" onClick="savepopup(' . $post['post_id'] . ')" class="btn4 savedpost' . $post['post_id'] . '">Save</a>';
                            }
                            $rec_post .= '<a href="javascript:void(0);"  class= "btn4 applypost' . $post['post_id'] . '" onclick="applypopup(' . $post['post_id'] . ', ' . $post['user_id'] . ')">Apply</a>';
                        }

                        $rec_post .= ' </p>

</div>
</div>';
                    }
                } else {
                    
                }
            } else {

                if (count($rec_postdata) != '') {

                    foreach ($rec_postdata as $post) {

                        $rec_post .= '<div class="all-job-box" id="removepost"' . $post['post_id'] . '">
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

//                        $rec_post .= '<div class="post-img">
//                                            <a href="' . base_url() . 'recruiter/jobpost/' . $text . $cityname . '-' . $post['user_id'] . '-' . $post['post_id'] . '">';
//                        if ($cache_time_1) {
//                            $rec_post .= '<img src="' . base_url($this->config->item('rec_profile_thumb_upload_path') . $cache_time_1) . '" alt=' . $cache_time_1 . '>';
//                        } else {
//                            $rec_post .= '<img src="' . base_url('assets/images/commen-img.png') . '" alt="commonimage">';
//                        }
//                        $rec_post .= '</a>
//                                        </div>';

                        $rec_post .= '<div class="post-img">
                            
                                            <a href="javascript:void(0);"  title="Upload Company Logo">';
                        if ($cache_time_1) {

                            if (IMAGEPATHFROM == 'upload') {

                                if (!file_exists($this->config->item('rec_profile_thumb_upload_path') . $cache_time_1)) {

                                    $rec_post .= '<img src="' . base_url('assets/images/commen-img.png') . '" alt="commonimage">';
                                } else {
                                    $rec_post .= '<img src="' . REC_PROFILE_THUMB_UPLOAD_URL . $cache_time_1 . '" alt="' . $cache_time . '">';
                                }
                            } else {
                                //  $rec_post .= '<img src="' . $this->config->item('rec_profile_thumb_upload_path') . $cache_time_1 . '" alt="' . $cache_time_1 . '">';
                                $filename = $this->config->item('rec_profile_thumb_upload_path') . $cache_time_1;
                                $s3 = new S3(awsAccessKey, awsSecretKey);
                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                if ($info) {
                                    $rec_post .= '<img src="' . REC_PROFILE_THUMB_UPLOAD_URL . $cache_time_1 . '" alt="' . $cache_time . '">';
                                } else {
                                    $rec_post .= '<img src="' . base_url('assets/images/commen-img.png') . '" alt="commonimage">';
                                }
                            }
                        } else {

                            $rec_post .= '<img src="' . base_url('assets/images/commen-img.png') . '" alt="commonimage">';
                        }
                        $rec_post .= '</a>
                            <div class="cus-profile" onclick="upload_company_logo(' . $post['user_id'] . ');">
    <img src="' . base_url() . 'assets/img/cam.png" title="Upload Company Logo" alt="cameraimage">
    </div>
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
                        $city_name = $this->db->get_where('cities', array('city_id' => $post['city']))->row()->city_name;
                        $countryname = $this->db->get_where('countries', array('country_id' => $post['country']))->row()->country_name;
                        $rec_post .= '<div class="job-top-detail">';
                        $rec_post .= '<h5><a href="' . base_url() . 'recruiter/jobpost/' . $text . $cityname . '-' . $post['user_id'] . '-' . $post['post_id'] . '">';
                        $rec_post .= $post_name;
                        $rec_post .= '</a></h5>';
                        $rec_post .= '<p><a href = "' . base_url() . 'recruiter/jobpost/' . $text . $cityname . '-' . $post['user_id'] . '-' . $post['post_id'] . '">';
                        $rec_post .= $cache_time1;
                        $rec_post .= '</a></p>';
                        $rec_post .= '<p><a href="' . base_url('recruiter/profile/' . $post['user_id']) . '">';
                        $rec_post .= ucwords($cache_time2) . " " . ucfirst($cache_time3);
                        $rec_post .= '</a></p>
            </div>
            </div>
            <div class="all-job-middle">
                <p class="pb5">
                    <span class="location">';
                        $rec_post .= '<span><img class="pr5" src="' . base_url('assets/images/location.png') . '" alt="location">';
                        if ($city_name || $countryname) {
                            if ($cityname) {
                                $rec_post .= $city_name . ', ';
                            }
                            $rec_post .= $countryname;
                        }
                        $rec_post .= '      </span>
                    </span>';
                        $rec_post .= '<span class="exp">
                        <span><img class="pr5" src="' . base_url('assets/images/exp.png') . '" alt="experience">';

                        if (($post['min_year'] != '0' || $post['max_year'] != '0') && ($post['fresher'] == 1)) {
                            $rec_post .= $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year' . " " . "(Fresher can also apply)";
                        } else {
                            if (($post['min_year'] != '0' || $post['max_year'] != '0')) {
                                $rec_post .= $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year';
                            } else {
                                $rec_post .= "Fresher";
                            }
                        }


                        $rec_post .= '</span>
                    </span>
                </p>
                <p>';

                        $rest = substr($post['post_description'], 0, 150);
                        $rec_post .= $rest;

                        if (strlen($post['post_description']) > 150) {
                            $rec_post .= '.....<a href="' . base_url() . 'recruiter/jobpost/' . $text . $cityname . '-' . $post['user_id'] . '-' . $post['post_id'] . '" target="blank();">Read more</a>';
                        }
                        $rec_post .= '</p>

            </div>
            <div class="all-job-bottom">
                <span class="job-post-date"><b>Posted on:</b>';
                        $rec_post .= date('d-M-Y', strtotime($post['created_date']));
                        $rec_post .= '</span>
                <p class="pull-right">';

                        $rec_post .= '<a title="Remove" href="javascript:void(0);" class="btn4" onclick="removepopup(' . $post['post_id'] . ')">Remove</a>';
                        $rec_post .= '<a title="Edit" href="' . base_url() . 'recruiter/edit-post/' . $post['post_id'] . '" class="btn4">Edit</a>';
                        $join_str[0]['table'] = 'job_reg';
                        $join_str[0]['join_table_id'] = 'job_reg.user_id';
                        $join_str[0]['from_table_id'] = 'job_apply.user_id';
                        $join_str[0]['join_type'] = '';

                        $condition_array = array('post_id' => $post['post_id'], 'job_apply.job_delete' => '0', 'job_reg.status' => '1', 'job_reg.is_delete' => '0', 'job_reg.job_step' => '10');
                        $data = "job_apply.*,job_reg.job_id";
                        $apply_candida = $this->common->select_data_by_condition('job_apply', $condition_array, $data, $short_by = '', $order_by = '', $limit, $offset, $join_str, $groupby = '');
                        $countt = count($apply_candida);

                        $rec_post .= '<a title="Applied Candidate" href="' . base_url() . 'recruiter/apply-list/' . $post['post_id'] . '" class="btn4">Applied  Candidate :' . $countt . '</a>';
                        $rec_post .= '</p> </div> </div>';
                    }
                } else {
                    
                }
            }
            $no_post = '';
            $no_post = "dataavl";
        } else {


            $no_post = '';
            $no_post = "nodata";
            $rec_post .= '<div class="art-img-nn">
                                            <div class="art_no_post_img">

                                                <img src="' . base_url('assets/img/job-no.png') . '" alt="noimage">

                                            </div>
                                            <div class="art_no_post_text">
                                                No  Post Available.
                                            </div>
                                        </div>';
        }

        echo json_encode(
                array(
                    "postdata" => $rec_post,
                    "nopostvar" => $no_post,
        ));

        //echo $rec_post;
    }

// RECRUITER POST AJAX LAZZY LOADER DATA END
// RECRUITER SEARCH START
    public function recruiter_search($searchkeyword = " ", $searchplace = " ") {

        if ($this->input->get('search_submit')) {
            $searchkeyword = $this->input->get('skills');
            $searchplace = $this->input->get('searchplace');
        } else {
            if ($this->uri->segment(3) == "0") {
                $searchplace = urldecode($searchplace);
                $searchkeyword = "";
            } else if ($this->uri->segment(4) == "0") {
                $searchkeyword = urldecode($searchkeyword);
                $searchplace = "";
            } else {
                $searchkeyword = urldecode($searchkeyword);
                $searchplace = urldecode($searchplace);
            }
        }
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        if ($searchkeyword == "" && $searchplace == "") {
            redirect('recruiter/home', refresh);
        }

        $rec_search = trim($searchkeyword, ' ');
        $this->data['keyword'] = $rec_search;
        $search_place = $searchplace;
        $this->data['key_place'] = $searchplace;
        $cache_time = $this->db->get_where('cities', array('city_name' => $search_place))->row()->city_id;
        $this->data['keyword1'] = $search_place;



        //RECRUITER SEARCH END 1-9


        $title = '';
        if ($searchkeyword && $search_place) {
            $title = ucfirst($searchkeyword) . ' in ' . ucfirst($search_place);
        } elseif ($search_place) {
            $title = ucfirst($search_place);
        } elseif ($searchkeyword) {
            $title = ucfirst($searchkeyword);
        }

        $this->data['title'] = $title . " | Recruiter Profile - Aileensoul";

        $this->data['head'] = $this->load->view('head', $this->data, TRUE);

        //THIS CODE IS FOR WHEN USER NOT LOGIN AND GET SEARCH DATA START
        if ($this->session->userdata('aileenuser')) {
            $contition_array = array('user_id' => $this->session->userdata('aileenuser'), 'is_delete' => '0', 're_status' => '1');
            $recruiter = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if ($recruiter) {
                // echo "5555"; die();
                $this->load->view('recruiter/recommen_candidate1', $this->data);
            } else {
                // echo "999";die();
                $this->load->view('recruiter/rec_search_login', $this->data);
            }
        } else {

            $this->load->view('recruiter/rec_search_login', $this->data);
        }
        //THIS CODE IS FOR WHEN USER NOT LOGIN AND GET SEARCH DATA END
    }

//recrutier search end
// RECRUITER SEARCH END
//RECRUITER SEARCH AJAX START
    public function recruiter_search_candidate() {

        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;
//        if ($this->session->userdata('aileenuser')) {
//            $this->recruiter_apply_check();
//        }
        $userid = $this->session->userdata('aileenuser');

        $searchkeyword = trim($_GET["skill"]);
        $searchplace = trim($_GET["place"]);

        $rec_search = trim($searchkeyword, ' ');
        $search_place = $searchplace;


//if user deactive profile then redirect to recruiter/index untill active profile start
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');
        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
//if user deactive profile then redirect to recruiter/index untill active profile End
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 're_status' => '1');
        $this->data['city'] = $city = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 're_comp_city', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $data = array(
            'search_keyword' => $rec_search,
            'search_location' => $search_place,
            'user_location' => $city[0]['re_comp_city'],
            'user_id' => $userid,
            'created_date' => date('Y-m-d h:i:s', time()),
            'status' => '1',
            'module' => '2'
        );
        $insert_id = $this->common->insert_data_getid($data, 'search_info');
        //insert search keyword into database end
        //RECRUITER SEARCH START 1-9
        if ($searchkeyword == "" || $this->uri->segment(3) == "0") {
            $contition_array = array('city_name' => $searchplace, 'status' => '1');
            $citydata = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
            $join_str1 = array(
                array(
                    'join_type' => 'left',
                    'table' => 'job_add_edu',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_add_edu.user_id'),
                array(
                    'join_type' => 'left',
                    'table' => 'job_graduation',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_graduation.user_id')
            );
            $data = 'job_id,job_reg.user_id as iduser,job_reg.fname,job_reg.lname,job_reg.email,job_reg.phnno,job_reg.language,job_reg.keyskill,job_reg.experience,job_reg.job_user_image,job_reg.designation,job_reg.work_job_title,job_reg.work_job_industry,job_reg.work_job_city,job_reg.slug,job_add_edu.degree,job_add_edu.stream,job_add_edu.board_primary,job_add_edu.board_secondary,job_add_edu.board_higher_secondary,job_add_edu.percentage_primary,job_add_edu.percentage_secondary,job_add_edu.percentage_higher_secondary,job_graduation.*';
            $contition_array = array('job_reg.status' => '1', 'job_reg.is_delete' => '0', 'job_step' => '10', 'job_reg.user_id != ' => $userid, 'FIND_IN_SET("' . $citydata[0]['city_id'] . '",work_job_city) !=' => '0');
            $jobcity_data = $this->common->select_data_by_condition('job_reg', $contition_array, $data, $sortby = 'job_id', $orderby = 'desc', $limit = '', $offset = '', $join_str1, $groupby = '');
            $unique = $jobcity_data;
        } elseif ($searchplace == "" || $this->uri->segment(4) == "0") {

//JOB TITILE DATA START
            $contition_array = array('status' => 'publish');
            $search_condition = "(name LIKE '%$searchkeyword%')";
            $jobtitledata = $this->common->select_data_by_search('job_title', $search_condition, $contition_array = array(), $data = 'GROUP_CONCAT(title_id) as title_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $job_list = $jobtitledata[0]['title_list'];
            $job_list = str_replace(",", "','", $jobtitledata[0]['title_list']);
            //JOB TITILE DATA END
            //SKILL DATA START
            $contition_array = array('status' => '1');
            $search_condition = "(skill LIKE '%$searchkeyword%')";
            $skilldata = $this->common->select_data_by_search('skill', $search_condition, $contition_array, $data = 'GROUP_CONCAT(skill_id) as skill_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $skill_list = $skilldata[0]['skill_list'];

            //INDUSTRY DATA START
            $contition_array = array('is_delete' => '0', 'status' => '1');
            $search_condition = "((industry_name LIKE '%$searchkeyword%') OR (industry_name LIKE '%$searchkeyword%' AND user_id = '$userid'))";
            $inddata = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = 'GROUP_CONCAT(industry_id) as industry_list ', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $ind_list = $inddata[0]['industry_list'];
            $ind_list = str_replace(",", "','", $inddata[0]['industry_list']);
            //INDUSTRY DATA END
            $data = 'job_id,job_reg.user_id as iduser,job_reg.fname,job_reg.lname,job_reg.email,job_reg.phnno,job_reg.language,job_reg.keyskill,job_reg.experience,job_reg.job_user_image,job_reg.designation,job_reg.work_job_title,job_reg.work_job_industry,job_reg.work_job_city,job_reg.slug,job_add_edu.degree,job_add_edu.stream,job_add_edu.board_primary,job_add_edu.board_secondary,job_add_edu.board_higher_secondary,job_add_edu.percentage_primary,job_add_edu.percentage_secondary,job_add_edu.percentage_higher_secondary,job_graduation.*';

            $join_str1 = array(
                array(
                    'join_type' => 'left',
                    'table' => 'job_add_edu',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_add_edu.user_id'),
                array(
                    'join_type' => 'left',
                    'table' => 'job_graduation',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_graduation.user_id')
            );
            if ($ind_list) {
                $contition_array = array('job_reg.status' => '1', 'job_reg.is_delete' => '0', 'job_step' => '10', 'job_reg.user_id != ' => $userid);
                $search_condition = "( job_reg.work_job_industry IN ('$ind_list'))";
                $jobind_data = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data1, $sortby = 'job_id', $orderby = 'desc', $limit = '', $offset = '', $join_str1, $groupby = '');
            }
            if ($job_list) {
                $contition_array = array('job_reg.status' => '1', 'job_reg.is_delete' => '0', 'job_step' => '10', 'job_reg.user_id != ' => $userid);
                $search_condition = "( job_reg.work_job_title IN ('$job_list'))";
                $jobtitle_data = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data, $sortby = 'job_id', $orderby = 'desc', $limit = '', $offset = '', $join_str1, $groupby = '');
            }
            if ($skill_list) {
                $skill_list = explode(",", $skill_list);
                foreach ($skill_list as $ski) {
                    $contition_array = array('job_reg.status' => '1', 'job_reg.is_delete' => '0', 'job_step' => '10', 'job_reg.user_id != ' => $userid, 'FIND_IN_SET("' . $ski . '", keyskill) != ' => '0');
                    $jobskill_data[] = $this->common->select_data_by_condition('job_reg', $contition_array, $data, $sortby = 'job_id', $orderby = 'desc', $limit = '', $offset = '', $join_str1, $groupby = '');


//25-9 SKILL RESULT END FOR RECRUITER
                }
                $job_data = $jobskill_data;
                $job_data = array_reduce($job_data, 'array_merge', array());
                $job_data = array_unique($job_data, SORT_REGULAR);
            }
            $unique = array_merge((array) $jobtitle_data, (array) $job_data, (array) $jobind_data);
        } else {

//25-9 SKILL RESULT START FOR RECRUITER
            $contition_array = array('city_name' => $searchplace, 'status' => '1');
            $citydata = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
            //echo '<pre>'; print_r($citydata); die();
            //JOB TITILE DATA START
            $contition_array = array('status' => 'publish');
            $search_condition = "(name LIKE '%$searchkeyword%')";
            $jobtitledata = $this->common->select_data_by_search('job_title', $search_condition, $contition_array = array(), $data = 'GROUP_CONCAT(title_id) as title_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $job_list = $jobtitledata[0]['title_list'];
            $job_list = str_replace(",", "','", $jobtitledata[0]['title_list']);
            //JOB TITLE DATA END
            //SKILL DATA START
            $contition_array = array('status' => '1');
            $search_condition = "(skill LIKE '%$searchkeyword%')";
            $skilldata = $this->common->select_data_by_search('skill', $search_condition, $contition_array, $data = 'GROUP_CONCAT(skill_id) as skill_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $skill_list = $skilldata[0]['skill_list'];
            //SKILL DATA END
            //INDUSTRY DATA START
            $contition_array = array('is_delete' => '0', 'status' => '1');
            $search_condition = "((industry_name LIKE '%$searchkeyword%') OR (industry_name LIKE '%$searchkeyword%' AND user_id = '$userid'))";
            $inddata = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = 'GROUP_CONCAT(industry_id) as industry_list ', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $ind_list = $inddata[0]['industry_list'];
            $ind_list = str_replace(",", "','", $inddata[0]['industry_list']);
            //INDUSTRY DATA END


            $join_str1 = array(
                array(
                    'join_type' => 'left',
                    'table' => 'job_add_edu',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_add_edu.user_id'),
                array(
                    'join_type' => 'left',
                    'table' => 'job_graduation',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_graduation.user_id')
            );
            $data = 'job_id,job_reg.user_id as iduser,job_reg.fname,job_reg.lname,job_reg.email,job_reg.phnno,job_reg.language,job_reg.keyskill,job_reg.experience,job_reg.job_user_image,job_reg.designation,job_reg.work_job_title,job_reg.work_job_industry,job_reg.work_job_city,job_reg.slug,job_add_edu.degree,job_add_edu.stream,job_add_edu.board_primary,job_add_edu.board_secondary,job_add_edu.board_higher_secondary,job_add_edu.percentage_primary,job_add_edu.percentage_secondary,job_add_edu.percentage_higher_secondary,job_graduation.*';
            $contition_array = array('job_reg.status' => '1', 'job_reg.is_delete' => '0', 'job_step' => '10', 'job_reg.user_id != ' => $userid, 'FIND_IN_SET("' . $citydata[0]['city_id'] . '", work_job_city) != ' => '0');
            $search_condition = "( job_reg.work_job_industry IN ('$ind_list'))";
            $jobind_data = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data, $sortby = 'job_id', $orderby = 'desc', $limit = '', $offset = '', $join_str1, $groupby = '');


            $contition_array = array('job_reg.status' => '1', 'job_reg.is_delete' => '0', 'job_step' => '10', 'job_reg.user_id != ' => $userid, 'FIND_IN_SET("' . $citydata[0]['city_id'] . '", work_job_city) != ' => '0');
            $search_condition = "( job_reg.work_job_title IN ('$job_list'))";
            $jobtitle_data = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data, $sortby = 'job_id', $orderby = 'desc', $limit = '', $offset = '', $join_str1, $groupby = '');

            $skill_list = explode(",", $skill_list);
            foreach ($skill_list as $ski) {
                $contition_array = array('job_reg.status' => '1', 'job_reg.is_delete' => '0', 'job_step' => '10', 'job_reg.user_id != ' => $userid, 'FIND_IN_SET("' . $ski . '", keyskill) != ' => '0', 'FIND_IN_SET("' . $citydata[0]['city_id'] . '", work_job_city) != ' => '0');
                $jobskill_data[] = $this->common->select_data_by_condition('job_reg', $contition_array, $data, $sortby = 'job_id', $orderby = 'desc', $limit = '', $offset = '', $join_str1, $groupby = '');
//25-9 SKILL RESULT END FOR RECRUITER
            }
            $job_data = $jobskill_data;
            $job_data = array_reduce($job_data, 'array_merge', array());
            $job_data = array_unique($job_data, SORT_REGULAR);

            $unique = array_merge((array) $jobtitle_data, (array) $job_data, (array) $jobind_data);
        }

        $postdetail = $this->data['postdetail'] = $unique;
        //$postdetail = array_unique($postdetail, SORT_REGULAR);
        $tempArr = array_unique(array_column($postdetail, 'iduser'));
        $postdetail = array_intersect_key($postdetail, $tempArr);

        $searchdata1 = array_slice($postdetail, $start, $perpage);
        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($postdetail);
        }



        $return_html .= '<input type = "hidden" class = "page_number" value = "' . $page . '" />';
        $return_html .= '<input type = "hidden" class = "total_record" value = "' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';
        $contition_array = array('user_id' => $this->session->userdata('aileenuser'), 'is_delete' => '0', 're_status' => '1');
        $recruiter = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if ($postdetail) {

            foreach ($searchdata1 as $p) {
                $return_html .= '<div class="profile-job-post-detail clearfix ">             
                                    <div class="profile-job-post-title-inside clearfix">
                                        <div class="profile-job-profile-button clearfix">
                                            <div class="profile-job-post-location-name-rec">
                                                <div style="display: inline-block; float: left;">
                                                    <div  class="buisness-profile-pic-candidate ">';

                $imageee = $this->config->item('job_profile_thumb_upload_path') . $p['job_user_image'];

                $image_ori = $p['job_user_image'];
                $filename = $this->config->item('job_profile_thumb_upload_path') . $p['job_user_image'];
                $s3 = new S3(awsAccessKey, awsSecretKey);
                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                if ($info && $p['job_user_image'] != '') {
                    if ($this->session->userdata('aileenuser')) {
                        if ($recruiter) {
                            $return_html .= '<a href="' . base_url('job/resume/' . $p['slug'] . '') . '" title="' . $p['fname'] . ' ' . $p['lname'] . '"> 
                                    <img src="' . JOB_PROFILE_THUMB_UPLOAD_URL . $p['job_user_image'] . '" alt="' . $p[0]['fname'] . ' ' . $p[0]['lname'] . '">
                                    </a>';
                        } else {
                            $return_html .= '<a href="' . base_url('recruiter/registration') . '" title="' . $p['fname'] . ' ' . $p['lname'] . '"> 
                                    <img src="' . JOB_PROFILE_THUMB_UPLOAD_URL . $p['job_user_image'] . '" alt="' . $p[0]['fname'] . ' ' . $p[0]['lname'] . '">
                                    </a>';
                        }
                    }
                    // $return_html .= '<a href="' . base_url('job/resume/' . $p['slug'] . '') . '" title="' . $p['fname'] . ' ' . $p['lname'] . '"> 
                    //                 <img src="' . JOB_PROFILE_THUMB_UPLOAD_URL . $p['job_user_image'] . '" alt="' . $p[0]['fname'] . ' ' . $p[0]['lname'] . '">
                    //                 </a>';
                } else {

                    $a = $p['fname'];
                    $acr = substr($a, 0, 1);
                    $b = $p['lname'];
                    $acr1 = substr($b, 0, 1);
                    if ($this->session->userdata('aileenuser')) {
                        if ($recruiter) {
                            $return_html .= '<a href="' . base_url('job/resume/' . $p['slug'] . '') . '" title="' . $p['fname'] . ' ' . $p['lname'] . '">';
                        } else {
                            $return_html .= '<a href="' . base_url('recruiter/registration') . '" title="' . $p['fname'] . ' ' . $p['lname'] . '">';
                        }
                    }

                    $return_html .= '<div class="post-img-profile">' . ucfirst(strtolower($acr)) . ucfirst(strtolower($acr1)) . '</div>';
                    $return_html .= '</a>';
                }
                $return_html .= '</div></div>';

                $return_html .= '<div class="designation_rec" style="float: left;">
                                    <ul>
                                        <li>';
                if ($this->session->userdata('aileenuser')) {
                    if ($recruiter) {
                        $return_html .= '<a style="font-size: 19px;font-weight: 600;" class="post_name" href="' . base_url('job/resume/' . $p['slug'] . '') . '">';
                    } else {
                        $return_html .= '<a style="font-size: 19px;font-weight: 600;" class="post_name" href="' . base_url('recruiter/registration') . '">';
                    }
                } else {
                    $return_html .= '<a style="font-size: 19px;font-weight: 600;" class="post_name" href="javascript:void(0)" onClick="login_profile()">';
                }


                $return_html .= ucfirst(strtolower($p['fname'])) . ' ' . ucfirst(strtolower($p['lname'])) .
                        '</a></li>';

                $return_html .= ' <li style="display: block;"><a href="javascript:void(0)" class="post_designation">';

                if ($p['designation']) {
                    $return_html .= $p['designation'];
                } else {
                    $return_html .= "Designation";
                }
                $return_html .= '</a></li>';
                $return_html .= '</ul></div>';
                $return_html .= '</div></div></div>';

                $return_html .= '<div class="profile-job-post-title clearfix search1">
                                    <div class="profile-job-profile-menu  search ">
                                        <ul class="clearfix">';

                if ($p['work_job_title']) {
                    $contition_array = array('title_id' => $p['work_job_title']);
                    $jobtitle = $this->common->select_data_by_condition('job_title', $contition_array, $data = 'name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $return_html .= '<li><b>Job Title</b><span>' . $jobtitle[0]['name'] . '</span></li>';
                }
                if ($p['keyskill']) {
                    $jobskil = array();
                    $return_html .= '<li><b>Skills</b><span>';

                    $work_skill = explode(',', $p['keyskill']);
                    foreach ($work_skill as $skill) {
                        $contition_array = array('skill_id' => $skill);
                        $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                        $jobskil[] = $skilldata[0]['skill'];
                    }
                    $return_html .= implode(',', $jobskil) . '</span></li>';
                }
                if ($p['work_job_industry']) {
                    $contition_array = array('industry_id' => $p['work_job_industry']);
                    $industry = $this->common->select_data_by_condition('job_industry', $contition_array, $data = 'industry_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $return_html .= '<li> <b> Industry</b> <span>' . $industry[0]['industry_name'] . '</span></li>';
                }
                if ($p['work_job_city']) {
                    $work_city = explode(',', $p['work_job_city']);
                    $cities2 = array();
                    foreach ($work_city as $city) {
                        $contition_array = array('city_id' => $city);
                        $citydata1 = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_id,city_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                        if ($citydata1) {
                            $cities2[] = $citydata1[0]['city_name'];
                        }
                    }
                    $return_html .= '<li> <b> Preferred Cites</b> <span>' . implode(',', $cities2) . '</span></li>';
                }

                $contition_array = array('user_id' => $p['iduser'], 'experience' => 'Experience', 'status' => '1');
                $experiance = $this->common->select_data_by_condition('job_add_workexp', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($experiance[0]['experience_year'] != '') {

                    $total_work_year = 0;
                    $total_work_month = 0;
                    foreach ($experiance as $work1) {
                        $total_work_year += $work1['experience_year'];
                        $total_work_month += $work1['experience_month'];
                    }

                    $return_html .= '<li> <b> Total Experience</b><span>';

                    if ($total_work_month == '12 month' && $total_work_year == '0 year') {
                        $return_html .= '1 year';
                    } else {
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
                        if ($year != 0) {
                            $return_html .= $year . ' Year';
                        }
                        $return_html .= '&nbsp';
                        if ($total_work_month != 0) {
                            $return_html .= $total_work_month . ' Month';
                        }
                    }

                    $return_html .= '</span></li>';
                } else {
                    if ($p[0]['experience'] == 'Experience') {
                        $postdata .= '<li> <b> Total Experience</b>';
                        if ($p[0]['exp_y'] != " " && $p[0]['exp_m'] != " ") {
                            if ($p[0]['exp_m'] == '12 month' && $p[0]['exp_y'] == '0 year') {
                                $postdata .= "1 year";
                            } else {

                                if ($p[0]['exp_y'] != '0 year') {
                                    $postdata .= $p[0]['exp_y'];
                                }
                                if ($p[0]['exp_m'] != '0 month') {
                                    $postdata .= ' ' . $p[0]['exp_m'];
                                }
                            }
                        }
                    }
                    if ($p['experience'] == 'Fresher') {
                        $return_html .= '<li> <b> Total Experience</b><span>' . $p['experience'] . '</span></li>';
                    } //if complete
                }//else complete

                if ($p['board_primary'] && $p['board_secondary'] && $p['board_higher_secondary'] && $p['degree']) {
                    $return_html .= '<li><b>Degree</b><span>';
                    $cache_time = $this->db->get_where('degree', array('degree_id' => $p['degree']))->row()->degree_name;
                    if ($cache_time) {
                        $return_html .= $cache_time;
                    } else {
                        $return_html .= PROFILENA;
                    }
                    $return_html .= '</span></li>';

                    $return_html .= '<li><b>Stream</b><span>';
                    $cache_time = $this->db->get_where('stream', array('stream_id' => $p['stream']))->row()->stream_name;
                    if ($cache_time) {
                        $return_html .= $cache_time;
                    } else {
                        $return_html .= PROFILENA;
                    }

                    $return_html .= '</span></li>';
                } elseif ($p['board_secondary'] && $p['board_higher_secondary'] && $p['degree']) {
                    $return_html .= '<li><b>Degree</b><span>';
                    $cache_time = $this->db->get_where('degree', array('degree_id' => $p['degree']))->row()->degree_name;
                    if ($cache_time) {
                        $return_html .= $cache_time;
                    } else {
                        $return_html .= PROFILENA;
                    }
                    $return_html .= '</span></li>';

                    $return_html .= '<li><b>Stream</b><span>';
                    $cache_time = $this->db->get_where('stream', array('stream_id' => $p['stream']))->row()->stream_name;
                    if ($cache_time) {
                        $return_html .= $cache_time;
                    } else {
                        $return_html .= PROFILENA;
                    }
                    $return_html .= '</span></li>';
                } elseif ($p['board_higher_secondary'] && $p['degree']) {
                    $return_html .= '<li><b>Degree</b><span>';
                    $cache_time = $this->db->get_where('degree', array('degree_id' => $p['degree']))->row()->degree_name;
                    if ($cache_time) {
                        $return_html .= $cache_time;
                    } else {
                        $return_html .= PROFILENA;
                    }
                    $return_html .= '</span></li>';

                    $return_html .= '<li><b>Stream</b><span>';
                    $cache_time = $this->db->get_where('stream', array('stream_id' => $p['stream']))->row()->stream_name;
                    if ($cache_time) {
                        $return_html .= $cache_time;
                    } else {
                        $return_html .= PROFILENA;
                    }
                    $return_html .= '</span></li>';
                } else if ($p['board_secondary'] && $p['degree']) {
                    $return_html .= '<li><b>Degree</b><span>';
                    $cache_time = $this->db->get_where('degree', array('degree_id' => $p['degree']))->row()->degree_name;
                    if ($cache_time) {
                        $return_html .= $cache_time;
                    } else {
                        $return_html .= PROFILENA;
                    }
                    $return_html .= '</span></li><li><b>Stream</b><span>';
                    $cache_time = $this->db->get_where('stream', array('stream_id' => $p['stream']))->row()->stream_name;
                    if ($cache_time) {
                        $return_html .= $cache_time;
                    } else {
                        $return_html .= PROFILENA;
                    }
                    $return_html .= '</span></li>';
                } elseif ($p['board_primary'] && $p['degree']) {
                    $return_html .= '<li><b>Degree</b><span>';
                    $cache_time = $this->db->get_where('degree', array('degree_id' => $p['degree']))->row()->degree_name;
                    if ($cache_time) {
                        $return_html .= $cache_time;
                    } else {
                        $return_html .= PROFILENA;
                    }
                    $return_html .= '</span></li>';

                    $return_html .= '<li><b>Stream</b><span>';
                    $cache_time = $this->db->get_where('stream', array('stream_id' => $p['stream']))->row()->stream_name;
                    if ($cache_time) {
                        $return_html .= $cache_time;
                    } else {
                        $return_html .= PROFILENA;
                    }
                    $return_html .= '</span></li>';
                } elseif ($p['board_primary'] && $p['board_secondary'] && $p['board_higher_secondary']) {
                    $return_html .= '<li><b>Board of Higher Secondary</b>';
                    $return_html .= '<span>' . $p['board_higher_secondary'] . '</span></li>';

                    $return_html .= '<li><b>Percentage of Higher Secondary</b><span>' . $p['percentage_higher_secondary'] . '</span></li>';
                } elseif ($p['board_secondary'] && $p['board_higher_secondary']) {
                    $return_html .= '<li><b>Board of Higher Secondary</b><span>' . $p['board_higher_secondary'] . '</span></li>';
                    $return_html .= '<li><b>Percentage of Higher Secondary</b><span>' . $p['percentage_higher_secondary'] . '</span></li>';
                } elseif ($p['board_primary'] && $p['board_higher_secondary']) {

                    $return_html .= '<li><b>Board of Higher Secondary</b><span>' . $p['board_higher_secondary'] . '</span></li>';
                    $return_html .= '<li><b>Percentage of Higher Secondary</b><span>' . $p['percentage_higher_secondary'] . '</span></li>';
                } elseif ($p['board_primary'] && $p['board_secondary']) {
                    $return_html .= '<li><b>Board of Secondary</b><span>' . $p['board_secondary'] . '</span></li>';
                    $return_html .= '<li><b>Percentage of Secondary</b><span>' . $p['percentage_secondary'] . '</span></li>';
                } elseif ($p['degree']) {
                    $return_html .= '<li><b>Degree</b><span>';
                    $cache_time = $this->db->get_where('degree', array('degree_id' => $p['degree']))->row()->degree_name;
                    if ($cache_time) {
                        $return_html .= $cache_time;
                    } else {
                        $return_html .= PROFILENA;
                    }
                    $return_html .= '</span></li>';

                    $return_html .= '<li><b>Stream</b><span>';
                    $cache_time = $this->db->get_where('stream', array('stream_id' => $p['stream']))->row()->stream_name;
                    if ($cache_time) {
                        $return_html .= $cache_time;
                    } else {
                        $return_html .= PROFILENA;
                    }
                    $return_html .= '</span></li>';
                } elseif ($p['board_higher_secondary']) {
                    $return_html .= '<li><b>Board of Higher Secondary</b><span>' . $p['board_higher_secondary'] . '</span></li>';
                    $return_html .= '<li><b>Percentage of Higher Secondary</b><span>' . $p['percentage_higher_secondary'] . '</span></li>';
                } elseif ($p['board_secondary']) {

                    $return_html .= '<li><b>Board of Secondary</b><span>' . $p['board_secondary'] . '</span></li>';
                    $return_html .= '<li><b>Percentage of Secondary</b><span>' . $p['percentage_secondary'] . '</span></li>';
                } elseif ($p['board_primary']) {
                    $return_html .= '<li><b>Board of Primary</b><span>' . $p['board_primary'] . '</span></li>';
                    $return_html .= '<li><b>Percentage of Primary</b><span>' . $p['percentage_primary'] . '</span></li>';
                }

                if ($this->session->userdata('aileenuser')) {

                    $return_html .= '<li><b>E-mail</b><span>';
                    if ($p['email']) {
                        $return_html .= $p['email'];
                    } else {
                        $return_html .= PROFILENA;
                    }
                    $return_html .= '</span></li>';
                } else {

                    $return_html .= '<li><b>E-mail</b><span class="text_blur">';
                    if ($p['email']) {
                        $return_html .= $p['email'];
                    } else {
                        $return_html .= PROFILENA;
                    }
                    $return_html .= '</span></li>';
                }

                if ($this->session->userdata('aileenuser')) {
                    if ($p['phnno']) {
                        $return_html .= '<li><b>Mobile Number</b><span>' . $p['phnno'] . '</span></li>';
                    }
                } else {

                    if ($p['phnno']) {
                        $return_html .= '<li><b>Mobile Number</b><span class="text_blur">' . $p['phnno'] . '</span></li>';
                    }
                }
                $return_html .= '<input type="hidden" name="search" id="search" value="' . $keyword . '">
                                    <input type="hidden" name="search" id="search1" value="' . $keyword1 . '">';

                $return_html .= '</ul></div>';

                $return_html .= '<div class="profile-job-profile-button clearfix">
                                    <div class="apply-btn fr">';

                $userid = $this->session->userdata('aileenuser');
                $contition_array = array('from_id' => $userid, 'to_id' => $p['iduser'], 'save_type' => '1', 'status' => '0');
                $data = $this->common->select_data_by_condition('save', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($userid != $p['iduser']) {
                    if (!$data) {
                        if ($this->session->userdata('aileenuser')) {
                            if ($recruiter) {
                                $return_html .= '<a href="' . base_url('chat/abc/2/1/' . $p['iduser']) . '">';
                            } else {
                                $return_html .= '<a href="' . base_url('recruiter/registration') . '">';
                            }
                        } else {
                            $return_html .= '<a href="javascript:void(0)" onClick="login_profile()">';
                        }
                        $return_html .= 'Message</a>';
                        $return_html .= '<input type="hidden" id="hideenuser' . $p['job_id'] . '" value= "' . $p['job_id'] . '">';
                        $return_html .= '<a id="' . $p['iduser'] . '"';
                        if ($this->session->userdata('aileenuser')) {
                            if ($recruiter) {
                                $return_html .= 'onClick="savepopup(' . $p['iduser'] . ',' . $p['job_id'] . ')"';
                            } else {
                                $return_html .= 'onClick=""';
                            }
                        } else {
                            $return_html .= 'onClick="login_profile()"';
                        }
                        $return_html .= 'href="javascript:void(0);" class="saveduser' . $p['job_id'] . '">Save</a>';
                    } else {
                        $return_html .= '<a title="Message" href="' . base_url('chat/abc/2/1/' . $p['iduser']) . '">Message</a> 
                                        <a class="saved">Saved </a>';
                    }
                }
                $return_html .= '</div></div>';

                $return_html .= '</div></div>';
            }//for loop end
        }//if end
        else {
            $return_html .= '<div class="text-center rio">
                                <h1 class="page-heading  product-listing" style="border:0px;margin-bottom: 11px;">Oops No Data Found.</h1>
                                    <p style="margin-left:4%;text-transform:none !important;border:0px;">We couldn' . "'" . 't find what you were looking for.</p>
                                        <ul>
                                            <li style="text-transform:none !important; list-style: none;">Make sure you used the right keywords.
                                            </li>
                                        </ul>
                            </div>';
        } //else end                                     

        echo $return_html;
    }

//RECRUITER SEARCH AJAX END
// RECRUITER GET LOCATION START
    public function get_location($id = "") {

        //get search term
        $searchTerm = $_GET['term'];

        if (!empty($searchTerm)) {
            $search_condition = "(city_name LIKE '" . trim($searchTerm) . "%')";
            $citylist = $this->common->select_data_by_search('cities', $search_condition, $contition_array = array(), $data = 'city_id as id,city_name as text', $sortby = 'city_name', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = 'city_name');
        }
        foreach ($citylist as $key => $value) {

            $citydata[$key]['value'] = $value['text'];
        }

        $cdata = array_values($citydata);
        echo json_encode($cdata);
    }

// RECRUITER GET LOCATION END
    public function get_job_tile($id = "") {
        $userid = $this->session->userdata('aileenuser');
        //get search term
        $searchTerm = $_GET['term'];

        if (!empty($searchTerm)) {

// JOB REGISTRATION DATA START (designation)
            $contition_array = array('status' => '1', 'is_delete' => '0');
            $search_condition = "(designation LIKE '" . trim($searchTerm) . "%')";
            $designation = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'designation', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = 'designation');
// JOB REGISTRATION DATA END  (designation)
// DEGREE DATA START
            $contition_array = array('status' => '1');
            $search_condition = "(degree_name LIKE '" . trim($searchTerm) . "%')";
            $degreedata = $this->common->select_data_by_search('degree', $search_condition, $contition_array, $data = 'degree_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = 'degree_name');
// DEGREE DATA END
// STREAM DATA START
            $contition_array = array('status' => '1');
            $search_condition = "(stream_name LIKE '" . trim($searchTerm) . "%')";
            $streamdata = $this->common->select_data_by_search('stream', $search_condition, $contition_array, $data = 'stream_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = 'stream_name');
// STREAM DATA END
// SKILL DATA START
            $contition_array = array('status' => '1', 'type' => '1');
            $search_condition = "(skill LIKE '" . trim($searchTerm) . "%')";
            $skilldata = $this->common->select_data_by_search('skill', $search_condition, $contition_array, $data = 'skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = 'skill');
// SKILL DATA END
//MERGE DATA START
            $uni = array_merge($designation, $degreedata, $streamdata, $skilldata);
//MERGE DATA END
        }
        foreach ($uni as $key => $value) {
            foreach ($value as $ke => $val) {
                if ($val != "") {
                    $result[] = $val;
                }
            }
        }
        foreach ($result as $key => $value) {

            $result1[$key]['value'] = $value;
        }

        $all_data = array_values($result1);
        echo json_encode($all_data);
    }

    public function ajax_saved_candidate() {

        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        // echo $page;
        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;

        $this->recruiter_apply_check();

        $userid = $this->session->userdata('aileenuser');

//if user deactive profile then redirect to recruiter/index untill active profile start
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');
        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
//if user deactive profile then redirect to recruiter/index untill active profile End

        $recruiterdata = $this->common->select_data_by_id('recruiter', 'user_id', $userid, $data = 'user_id,designation,rec_lastname,rec_firstname', $join_str = array());

        $join_str1 = array(array(
                'join_type' => 'left',
                'table' => 'job_add_edu',
                'join_table_id' => 'save.to_id',
                'from_table_id' => 'job_add_edu.user_id'),
            array(
                'join_type' => 'left',
                'table' => 'job_reg',
                'join_table_id' => 'save.to_id',
                'from_table_id' => 'job_reg.user_id'),
            array(
                'join_type' => 'left',
                'table' => 'job_graduation',
                'join_table_id' => 'save.to_id',
                'from_table_id' => 'job_graduation.user_id')
        );


        $data = "job_reg.user_id as userid,job_reg.fname,job_reg.lname,job_reg.email,job_reg.slug,job_reg.designation,job_reg.phnno,job_reg.keyskill,job_reg.work_job_title,job_reg.work_job_industry,job_reg.work_job_city,job_reg.job_user_image,job_add_edu.*,job_graduation.*,save.status,save.save_id,save.to_id";
        $contition_array1 = array('save.from_id' => $userid, 'save.status' => '0', 'save.save_type' => '1');
        $recdata1 = $this->common->select_data_by_condition('save', $contition_array1, $data, $sortby = 'save_id', $orderby = 'desc', $limit = '', $offset = '', $join_str1, $groupby = '');
        foreach ($recdata1 as $ke => $arr) {
            $recdata2[] = $arr;
        }

        $new = array();
        foreach ($recdata2 as $value) {

            $new[$value['userid']] = $value;
        }

        $savedata = $new;


        $return_html = " ";
        $savedata1 = array_slice($savedata, $start, $perpage);
        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($savedata);
        }

        $return_html = '';
        $return_html .= '<input type = "hidden" class = "page_number" value = "' . $page . '" />';
        $return_html .= '<input type = "hidden" class = "total_record" value = "' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';
        if (count($savedata) > 0) {
            foreach ($savedata1 as $rec) {

                $userid = $this->session->userdata('aileenuser');
                $contition_array = array('from_id' => $userid, 'save_id' => $rec['save_id']);
                $userdata = $this->common->select_data_by_condition('save', $contition_array, $data = 'status,save_id', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($userdata[0]['status'] != 1) {
                    $return_html .= '<div class="profile-job-post-detail clearfix" id="removeuser' . $userdata[0]['save_id'] . '">';
                    $return_html .= '<div class="profile-job-post-title-inside clearfix">
                             <div class="profile-job-profile-button clearfix">
                                 <div class="profile-job-post-location-name-rec">
                                <div style="display: inline-block; float: left;">
                                 <div class="buisness-profile-pic-candidate" >';


                    $imageee = $this->config->item('job_profile_thumb_upload_path') . $rec['job_user_image'];
                    if ($rec['job_user_image'] != '') {
                        $return_html .= '<a href="' . base_url() . 'job/resume/' . $rec['slug'] . '" title="' . $this->db->get_where('job_reg', array('user_id' => $rec['to_id']))->row()->fname . ' ' . $this->db->get_where('job_reg', array('user_id' => $rec['to_id']))->row()->lname . '">';
                        $return_html .= '<img src="' . JOB_PROFILE_THUMB_UPLOAD_URL . $rec['job_user_image'] . '" alt="' . $this->db->get_where('job_reg', array('user_id' => $rec['to_id']))->row()->fname . ' ' . $this->db->get_where('job_reg', array('user_id' => $rec['to_id']))->row()->lname . '"></a>';
                    } else {

                        $return_html .= '<a href="' . base_url() . 'job/resume/' . $rec['slug'] . '" title="' . $this->db->get_where('job_reg', array('user_id' => $rec['to_id']))->row()->fname . ' ' . $this->db->get_where('job_reg', array('user_id' => $rec['to_id']))->row()->lname . '">';

                        $a = $rec['fname'];
                        $acr = substr($a, 0, 1);
                        $b = $rec['lname'];
                        $acr1 = substr($b, 0, 1);
                        $return_html .= '<div class="post-img-profile">';
                        $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($acr1));

                        $return_html .= '</div>';
                    }
                    $return_html .= '</div>
                                                                </div>
                                                                <div class="designation_rec_1 fl ">
                                                                    <ul>
                                                                        <li>';

                    $return_html .= '<a class="post_name"  href="' . base_url() . 'job/resume/' . $rec['slug'] . '" title="' . $rec['fname'] . ' ' . $rec['lname'] . '">';
                    $return_html .= $rec['fname'] . ' ' . $rec['lname'] . '</a>';
                    $return_html .= '</li><li style="display: block;">
                                    <a class="post_designation"  href="javascript:void(0)" title="' . $rec['designation'] . '">';
                    if ($rec['designation']) {

                        $return_html .= $rec['designation'];
                    } else {

                        $return_html .= 'Designation';
                    }

                    $return_html .= '</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="profile-job-post-title clearfix">

                                                        <div class="profile-job-profile-menu">
                                                            <ul class="clearfix">';


                    if ($rec['work_job_title']) {
                        $contition_array = array('title_id' => $rec['work_job_title']);
                        $jobtitle = $this->common->select_data_by_condition('job_title', $contition_array, $data = 'name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                        $return_html .= '<li> <b> Job Title</b> <span>';
                        $return_html .= $jobtitle[0]['name'];
                        $return_html .= '</span>
                                </li>';
                    }
                    if ($rec['keyskill']) {
                        $detailes = array();
                        $work_skill = explode(',', $rec['keyskill']);
                        foreach ($work_skill as $skill) {
                            $contition_array = array('skill_id' => $skill);
                            $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                            $detailes[] = $skilldata[0]['skill'];
                        }

                        $return_html .= '<li> <b> Skills</b> <span>'
                                . implode(',', $detailes) .
                                '</span>
                                                                    </li>';
                    }
                    if ($rec['work_job_industry']) {
                        $contition_array = array('industry_id' => $rec['work_job_industry']);
                        $industry = $this->common->select_data_by_condition('job_industry', $contition_array, $data = 'industry_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                        $return_html .= '<li> <b> Industry</b> <span>';
                        $return_html .= $industry[0]['industry_name'];
                        $return_html .= '</span>
                                                                    </li>';
                    }

                    if ($rec['work_job_city']) {
                        $cities = array();
                        $work_city = explode(',', $rec['work_job_city']);
                        foreach ($work_city as $city) {
                            $contition_array = array('city_id' => $city);
                            $citydata = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_id,city_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                            if ($citydata) {
                                $cities[] = $citydata[0]['city_name'];
                            }
                        }

                        $return_html .= '<li> <b> Preferred Cites</b> <span>';
                        $return_html .= implode(',', $cities);
                        $return_html .= '</span>
                                                                    </li>';
                    }

                    $contition_array = array('user_id' => $rec['userid'], 'experience' => 'Experience', 'status' => '1');
                    $experiance = $this->common->select_data_by_condition('job_add_workexp', $contition_array, $data = 'experience_year,experience_month', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


                    if ($experiance[0]['experience_year'] != '') {

                        $total_work_year = 0;
                        $total_work_month = 0;
                        foreach ($experiance as $work1) {

                            $total_work_year += $work1['experience_year'];
                            $total_work_month += $work1['experience_month'];
                        }

                        $return_html .= '<li> <b> Total Experience</b>
                                                                        <span>';

                        if ($total_work_month == '12 month' && $total_work_year == '0 year') {
                            $return_html .= '"1 year"';
                        } else {
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
                            $return_html .= $year;
                            $return_html .= ' Year ';
                            if ($total_work_month != 0) {
                                $return_html .= $total_work_month . ' Month';
                            }
                        }

                        $return_html .= '</span>
                                                                    </li>';
                    } else {

                        if ($rec[0]['experience'] == 'Experience') {
                            $postdata .= '<li> <b> Total Experience</b>';
                            if ($rec[0]['exp_y'] != " " && $rec[0]['exp_m'] != " ") {
                                if ($rec[0]['exp_m'] == '12 month' && $rec[0]['exp_y'] == '0 year') {
                                    $postdata .= "1 year";
                                } else {

                                    if ($rec[0]['exp_y'] != '0 year') {
                                        $postdata .= $rec[0]['exp_y'];
                                    }
                                    if ($rec[0]['exp_m'] != '0 month') {
                                        $postdata .= ' ' . $rec[0]['exp_m'];
                                    }
                                }
                            }
                        }
                        if ($rec['experience'] == 'Fresher') {

                            $return_html .= '<li> <b> Total Experience</b>
                                                                            <span>' . $rec['experience'] . '</span>
                                                                        </li>';
                        } //if complete
                    }//else complete

                    if ($rec['board_primary'] && $rec['board_secondary'] && $rec['board_higher_secondary'] && $rec['degree']) {
                        $return_html .= '<li>
                                                                        <b>Degree</b><span>';
                        $cache_time = $this->db->get_where('degree', array('degree_id' => $rec['degree']))->row()->degree_name;
                        if ($cache_time) {
                            $return_html .= $cache_time;
                        } else {
                            $return_html .= PROFILENA;
                        }


                        $return_html .= '</span>
                                                                    </li>
                                                                    <li><b>Stream</b>
                                                                        <span>';
                        $cache_time = $this->db->get_where('stream', array('stream_id' => $rec['stream']))->row()->stream_name;
                        if ($cache_time) {
                            $return_html .= $cache_time;
                        } else {
                            $return_html .= PROFILENA;
                        }
                        $return_html .= '</span>
                                                                    </li>';
                    } elseif ($rec['board_secondary'] && $rec['board_higher_secondary'] && $rec['degree']) {

                        $return_html .= '<li>
                                                                        <b>Degree</b><span>';
                        $cache_time = $this->db->get_where('degree', array('degree_id' => $rec['degree']))->row()->degree_name;
                        if ($cache_time) {
                            $return_html .= $cache_time;
                        } else {
                            $return_html .= PROFILENA;
                        }

                        $return_html .= '</span>
                                                                    </li>
                                                                    <li><b>Stream</b>
                                                                        <span>';

                        $cache_time = $this->db->get_where('stream', array('stream_id' => $rec['stream']))->row()->stream_name;
                        if ($cache_time) {
                            $return_html .= $cache_time;
                        } else {
                            $return_html .= PROFILENA;
                        }

                        $return_html .= '</span>
                                                                    </li>';
                    } elseif ($row['board_higher_secondary'] && $rec['degree']) {


                        $return_html .= '<li>
                                                                        <b>Degree</b><span>';

                        $cache_time = $this->db->get_where('degree', array('degree_id' => $rec['degree']))->row()->degree_name;
                        if ($cache_time) {
                            $return_html .= $cache_time;
                        } else {
                            $return_html .= PROFILENA;
                        }


                        $return_html .= '</span>
                                                                    </li>
                                                                    <li><b>Stream</b>
                                                                        <span>';

                        $cache_time = $this->db->get_where('stream', array('stream_id' => $rec['stream']))->row()->stream_name;
                        if ($cache_time) {
                            $return_html .= $cache_time;
                        } else {
                            $return_html .= PROFILENA;
                        }

                        $return_html .= '</span>
                                                                    </li>';
                    } else if ($rec['board_secondary'] && $rec['degree']) {

                        $return_html .= '<li>
                                                                        <b>Degree</b><span>';

                        $cache_time = $this->db->get_where('degree', array('degree_id' => $rec['degree']))->row()->degree_name;
                        if ($cache_time) {
                            $return_html .= $cache_time;
                        } else {
                            $return_html .= PROFILENA;
                        }


                        $return_html .= '</span>
                                                                    </li>
                                                                    <li><b>Stream</b>
                                                                        <span>';

                        $cache_time = $this->db->get_where('stream', array('stream_id' => $rec['stream']))->row()->stream_name;
                        if ($cache_time) {
                            $return_html .= $cache_time;
                        } else {
                            $return_html .= PROFILENA;
                        }

                        $return_html .= '</span>
                                                                    </li>';
                    } elseif ($rec['board_primary'] && $rec['degree']) {
                        $return_html .= '<li>
                                                                        <b>Degree</b><span>';

                        $cache_time = $this->db->get_where('degree', array('degree_id' => $rec['degree']))->row()->degree_name;
                        if ($cache_time) {
                            $return_html .= $cache_time;
                        } else {
                            $return_html .= PROFILENA;
                        }


                        $return_html .= '</span>
                                                                    </li>
                                                                    <li><b>Stream</b>
                                                                        <span>';

                        $cache_time = $this->db->get_where('stream', array('stream_id' => $rec['stream']))->row()->stream_name;
                        if ($cache_time) {
                            $return_html .= $cache_time;
                        } else {
                            $return_html .= PROFILENA;
                        }

                        $return_html .= '</span>
                                                                    </li>';
                    } elseif ($rec['board_primary'] && $rec['board_secondary'] && $rec['board_higher_secondary']) {
                        $return_html .= '<li><b>Board of Higher Secondary</b>
                                                                        <span>' .
                                $rec['board_higher_secondary'] .
                                '</span>
                                                                    </li>
                                                                    <li><b>Percentage of Higher Secondary</b>
                                                                        <span>';
                        $return_html .= $rec['percentage_higher_secondary'];
                        $return_html .= '</span>
                                     </li>';
                    } elseif ($rec['board_secondary'] && $rec['board_higher_secondary']) {
                        $return_html .= '<li><b>Board of Higher Secondary</b>
                                                                        <span>' .
                                $rec['board_higher_secondary'] .
                                '</span>
                                                                    </li>
                                                                    <li><b>Percentage of Higher Secondary</b>
                                                                        <span>' .
                                $rec['percentage_higher_secondary'] .
                                '</span>
                                                                    </li>';
                    } elseif ($rec['board_primary'] && $rec['board_higher_secondary']) {


                        $return_html .= '<li><b>Board of Higher Secondary</b>
                                                                        <span>' .
                                $rec['board_higher_secondary'] .
                                '</span>
                                                                    </li>
                                                                    <li><b>Percentage of Higher Secondary</b>
                                                                        <span>' .
                                $rec['percentage_higher_secondary'] .
                                '</span>
                                                                    </li>';
                    } elseif ($rec['board_primary'] && $rec['board_secondary']) {

                        $return_html .= '<li><b>Board of Secondary</b>
                                                                        <span>'
                                . $rec['board_secondary'] .
                                '</span>
                                                                    </li>
                                                                    <li><b>Percentage of Secondary</b>
                                                                        <span>' .
                                $rec['percentage_secondary'] .
                                '</span>
                                                                    </li>';
                    } elseif ($rec['degree']) {

                        $return_html .= '<li>
                                                                        <b>Degree</b><span>';



                        $cache_time = $this->db->get_where('degree', array('degree_id' => $rec['degree']))->row()->degree_name;
                        if ($cache_time) {
                            $return_html .= $cache_time;
                        } else {
                            $return_html .= PROFILENA;
                        }


                        $return_html .= '</span>
                                                                    </li>
                                                                    <li><b>Stream</b>
                                                                        <span>';

                        $cache_time = $this->db->get_where('stream', array('stream_id' => $rec['stream']))->row()->stream_name;
                        if ($cache_time) {
                            $return_html .= $cache_time;
                        } else {
                            $return_html .= PROFILENA;
                        }

                        $return_html .= '</span>
                                                                    </li>';
                    } elseif ($rec['board_higher_secondary']) {

                        $return_html .= '<li><b>Board of Higher Secondary</b>
                                                                        <span>' .
                                $rec['board_higher_secondary'] .
                                '</span>
                                                                    </li>
                                                                    <li><b>Percentage of Higher Secondary</b>
                                                                        <span>' .
                                $rec['percentage_higher_secondary'] .
                                '</span>
                                                                    </li>';
                    } elseif ($rec['board_secondary']) {

                        $return_html .= '<li><b>Board of Secondary</b>
                                                                        <span>'
                                . $rec['board_secondary'] . '
                                                                        </span>
                                                                    </li>
                                                                    <li><b>Percentage of Secondary</b>
                                                                        <span>' .
                                $rec['percentage_secondary'] .
                                '</span>
                                                                    </li>';
                    } elseif ($rec['board_primary']) {

                        $return_html .= '<li><b>Board of Primary</b>
                                                                        <span>' .
                                $rec['board_primary'] .
                                '</span>
                                                                    </li>
                                                                    <li><b>Percentage of Primary</b>
                                                                        <span>' .
                                $rec['percentage_primary'] .
                                '</span>
                                                                    </li>';
                    }

                    $return_html .= '<li><b>E-mail</b><span>';

                    if ($rec['email']) {
                        $return_html .= $rec['email'];
                    } else {
                        $return_html .= PROFILENA;
                    }
                    $return_html .= '</span>
                                                                </li>';


                    if ($rec['phnno']) {

                        $return_html .= '<li><b>Mobile Number</b><span>'
                                . $rec['phnno'] .
                                '</span>
                                                                    </li>';
                    }



                    $return_html .= '</ul>
                                                        </div>
                                                        <div class="profile-job-profile-button clearfix">
                                                            <div class="apply-btn fr" >';
                    $userid = $this->session->userdata('aileenuser');
                    if ($userid != $rec['userid']) {

                        $return_html .= '<a title="Message" href="' . base_url() . 'chat/abc/2/1/' . $rec['userid'] . '">Message</a>';

                        $return_html .= '<a title="Remove" href="javascript:void(0);" class="button" onclick="removepopup(' . $rec['save_id'] . ')">Remove</a>';
                    }

                    $return_html .= '</div>

                                                        </div>
                                                    </div>
                                                </div>';
                }
            }
        } else {

            $return_html .= '<div class="art-img-nn">
                                        <div class="art_no_post_img">

                                            <img src="' . base_url() . 'assets/img/job-no1.png" alt="noimage">

                                        </div>
                                        <div class="art_no_post_text">
                                            No Saved Candidate  Available.
                                        </div>
                                    </div>';
        }
        echo $return_html;
    }

//COVAER PIC START
// cover pic controller

    public function ajaxpro() {

        $this->recruiter_apply_check();

        $userid = $this->session->userdata('aileenuser');

        //if user deactive profile then redirect to recruiter/index untill active profile start
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');

        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
        //if user deactive profile then redirect to recruiter/index untill active profile End


        $contition_array = array('user_id' => $userid);
        $rec_reg_data = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'profile_background', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $rec_reg_prev_image = $rec_reg_data[0]['profile_background'];
        $rec_reg_prev_main_image = $rec_reg_data[0]['profile_background_main'];

        if ($rec_reg_prev_image != '') {
            $rec_image_main_path = $this->config->item('rec_bg_main_upload_path');
            $rec_bg_full_image = $rec_image_main_path . $rec_reg_prev_image;
            if (isset($rec_bg_full_image)) {
                unlink($rec_bg_full_image);
            }

            $rec_image_thumb_path = $this->config->item('rec_bg_thumb_upload_path');
            $rec_bg_thumb_image = $rec_image_thumb_path . $rec_reg_prev_image;
            if (isset($rec_bg_thumb_image)) {
                unlink($rec_bg_thumb_image);
            }
        }
        if ($rec_reg_prev_main_image != '') {
            $rec_image_original_path = $this->config->item('rec_bg_original_upload_path');
            $rec_bg_origin_image = $rec_image_original_path . $rec_reg_prev_main_image;
            if (isset($rec_bg_origin_image)) {
                unlink($rec_bg_origin_image);
            }
        }

        $data = $_POST['image'];
        $data = str_replace('data:image/png;base64,', '', $data);
        $data = str_replace(' ', '+', $data);
        $user_bg_path = $this->config->item('rec_bg_main_upload_path');
        $imageName = time() . '.png';
        $data = base64_decode($data);
        $file = $user_bg_path . $imageName;
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


        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
        $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);

        $user_thumb_path = $this->config->item('rec_bg_thumb_upload_path');
        $user_thumb_width = $this->config->item('rec_bg_thumb_width');
        $user_thumb_height = $this->config->item('rec_bg_thumb_height');

        $upload_image = $user_bg_path . $imageName;
        $thumb_image_uplode = $this->thumb_img_uplode($upload_image, $imageName, $user_thumb_path, $user_thumb_width, $user_thumb_height);

        $thumb_image = $user_thumb_path . $imageName;
        $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);


        $data = array(
            'profile_background' => $imageName
        );

        $update = $this->common->update_data($data, 'recruiter', 'user_id', $userid);
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
        $this->data['reccdata'] = $this->common->select_data_by_id('recruiter', 'user_id', $userid, $data = '*', $join_str = array());

        $coverpic = '<img  src="' . REC_BG_THUMB_UPLOAD_URL . $this->data['reccdata'][0]['profile_background'] . '" name="image_src" id="image_src" alt="' . $this->data['reccdata'][0]['profile_background'] . '" />';
        echo $coverpic;
    }

    public function image() {

        $this->recruiter_apply_check();

        $userid = $this->session->userdata('aileenuser');

        //if user deactive profile then redirect to recruiter/index untill active profile start
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');

        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
        //if user deactive profile then redirect to recruiter/index untill active profile End


        $config['upload_path'] = $this->config->item('rec_bg_original_upload_path');
        $config['allowed_types'] = $this->config->item('rec_bg_allowed_types');
        $config['file_name'] = $_FILES['image']['name'];

        //Load upload library and initialize configuration
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('image')) {
// changes 21-11 unlink image 
            $main_image = $this->config->item('rec_bg_original_upload_path') . $_FILES['image']['name'];
            if ($_SERVER['HTTP_HOST'] != "localhost") {
                if (isset($main_image)) {
                    unlink($main_image);
                }
            }
            // changes 21-11 unlink image 
            $uploadData = $this->upload->data();
            $image = $uploadData['file_name'];
        } else {
            $image = '';
        }


        $data = array(
            'profile_background_main' => $image,
            'modify_date' => date('Y-m-d h:i:s', time())
        );

        $updatedata = $this->common->update_data($data, 'recruiter', 'user_id', $userid);

        if ($updatedata) {
            echo $userid;
        } else {
            echo "welcome";
        }
    }

//COVAER PIC END
    // RECRUITER AVAILABLE CHECK START
    public function rec_avail_check($userid = " ") {
        $contition_array = array('user_id' => $userid, 'is_delete' => '1');
        $availuser = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if (count($availuser) > 0) {
            redirect('recruiter/noavailable');
        }
    }

    // RECRUITER AVAILABLE CHECK END

    public function noavailable() {

        $this->load->view('recruiter/notavalible', $this->data);
    }

    // SAVE SEARCH USER START
    public function save_search_user() {

        $this->recruiter_apply_check();

        $id = $_POST['user_id'];


        $save_id = $_POST['save_id'];



        $userid = $this->session->userdata('aileenuser');

        //if user deactive profile then redirect to recruiter/index untill active profile start
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');

        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
        //if user deactive profile then redirect to recruiter/index untill active profile End
        $contition_array = array('from_id' => $userid, 'to_id' => $id, 'save_id' => $save_id);
        $userdata = $this->common->select_data_by_condition('save', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userdata) {
            $data = array(
                'status' => '0',
                'modify_date' => date('Y-m-d H:i:s')
            );


            $updatedata = $this->common->update_data($data, 'save', 'save_id', $save_id);

            if ($updatedata) {

                $saveuser = 'Saved';
                echo $saveuser;
            }
        } else {


            $contition_array = array('from_id' => $userid, 'to_id' => $id, 'status' => '0', 'save_type' => '1');
            $user_data = $this->common->select_data_by_condition('save', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if ($user_data) {

                if ($user_data) {

                    $saveuser = 'Saved';
                    echo $saveuser;
                }
            } else {

                $data = array(
                    'from_id' => $userid,
                    'to_id' => $id,
                    'status' => '0',
                    'save_type' => '1',
                    'created_date' => date('Y-m-d H:i:s'),
                    'modify_date' => date('Y-m-d H:i:s')
                );

                $insert_id = $this->common->insert_data($data, 'save');


                if ($insert_id) {

                    $saveuser = 'Saved';
                    echo $saveuser;
                }
            }
        }
    }

    // SAVE SEARCH USER END
    //PROFILE PIC INSERT START
    public function user_image_insert() {

        $this->recruiter_apply_check();

        $userid = $this->session->userdata('aileenuser');

        //if user deactive profile then redirect to recruiter/index untill active profile start
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');

        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
        //if user deactive profile then redirect to recruiter/index untill active profile End


        if ($this->input->post('cancel1')) {
            redirect('recruiter/post', refresh);
        } elseif ($this->input->post('cancel2')) {
            redirect('recruiter/profile', refresh);
        } elseif ($this->input->post('cancel3')) {
            redirect('recruiter/save-candidate', refresh);
        } elseif ($this->input->post('cancel4')) {
            redirect('recruiter/add-post', refresh);
        }

        if (empty($_FILES['profilepic']['name'])) {
            $this->form_validation->set_rules('profilepic', 'Upload profilepic', 'required');
        } else {


            $recruiter_image = '';
            $recruiter['upload_path'] = $this->config->item('rec_profile_main_upload_path');
            $recruiter['allowed_types'] = $this->config->item('rec_profile_main_allowed_types');
            $recruiter['max_size'] = $this->config->item('rec_profile_main_max_size');
            $recruiter['max_width'] = $this->config->item('rec_profile_main_max_width');
            $recruiter['max_height'] = $this->config->item('rec_profile_main_max_height');
            $this->load->library('upload');
            $this->upload->initialize($recruiter);
            //Uploading Image
            $this->upload->do_upload('profilepic');
            //Getting Uploaded Image File Data
            $imgdata = $this->upload->data();
            $imgerror = $this->upload->display_errors();
            if ($imgerror == '') {
                //Configuring Thumbnail 
                $recruiter_thumb['image_library'] = 'gd2';
                $recruiter_thumb['source_image'] = $recruiter['upload_path'] . $imgdata['file_name'];
                $recruiter_thumb['new_image'] = $this->config->item('rec_profile_thumb_upload_path') . $imgdata['file_name'];
                $recruiter_thumb['create_thumb'] = TRUE;
                $recruiter_thumb['maintain_ratio'] = TRUE;
                $recruiter_thumb['thumb_marker'] = '';
                $recruiter_thumb['width'] = $this->config->item('rec_profile_thumb_width');
                $recruiter_thumb['height'] = 2;
                $recruiter_thumb['master_dim'] = 'width';
                $recruiter_thumb['quality'] = "100%";
                $recruiter_thumb['x_axis'] = '0';
                $recruiter_thumb['y_axis'] = '0';
                //Loading Image Library
                $this->load->library('image_lib', $recruiter_thumb);
                $dataimage = $imgdata['file_name'];
                //Creating Thumbnail
                $this->image_lib->resize();
                $thumberror = $this->image_lib->display_errors();
                $main_image = $this->config->item('rec_profile_main_upload_path') . $imgdata['file_name'];
                $thumb_image = $this->config->item('rec_profile_thumb_upload_path') . $imgdata['file_name'];
                if ($_SERVER['HTTP_HOST'] != "localhost") {
                    if (isset($main_image)) {
                        unlink($main_image);
                    }

                    if (isset($thumb_image)) {
                        unlink($thumb_image);
                    }
                }
            } else {

                $thumberror = '';
            }
            if ($imgerror != '' || $thumberror != '') {


                $error[0] = $imgerror;
                $error[1] = $thumberror;
            } else {


                $error = array();
            }
            if ($error) {

                $this->session->set_flashdata('error', $error[0]);
                $redirect_url = site_url('recruiter');
                redirect($redirect_url, 'refresh');
            } else {

                $recruiter_reg_prev_image = $this->data['recdata']['recruiter_user_image'];


                if ($recruiter_reg_prev_image != '') {
                    $recruiter_image_main_path = $this->config->item('rec_profile_main_upload_path');
                    $recruiter_bg_full_image = $recruiter_image_main_path . $recruiter_reg_prev_image;
                    if (isset($recruiter_bg_full_image)) {
                        unlink($recruiter_bg_full_image);
                    }

                    $recruiter_image_thumb_path = $this->config->item('rec_profile_thumb_upload_path');
                    $recruiter_bg_thumb_image = $recruiter_image_thumb_path . $recruiter_reg_prev_image;
                    if (isset($recruiter_bg_thumb_image)) {
                        unlink($recruiter_bg_thumb_image);
                    }
                }

                $recruiter_image = $imgdata['file_name'];
            }


            $data = array(
                'recruiter_user_image' => $recruiter_image,
                'modify_date' => date('Y-m-d', time())
            );


            $updatdata = $this->common->update_data($data, 'recruiter', 'user_id', $userid);

            if ($updatdata) {

                $contition_array = array('user_id' => $userid, 're_status' => '1', 'is_delete' => '0');
                $recruiter_reg_data = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'recruiter_user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

                $userimage .= '<img src="' . base_url($this->config->item('rec_profile_thumb_upload_path') . $recruiter_reg_data[0]['recruiter_user_image']) . '" alt="" >';
                $userimage .= '<a href="javascript:void(0);" onclick="updateprofilepopup();"><i class="fa fa-camera" aria-hidden="true"></i>';
                $userimage .= 'Update Profile Picture';
                $userimage .= '</a>';
                echo $userimage;
            } else {
                $this->session->flashdata('error', 'Your data not inserted');
                redirect('recruiter/post', refresh);
            }
        }
    }

    //PROFILE PIC INSERT END  

    public function user_image_insert1() {
        $userid = $this->session->userdata('aileenuser');
        $user_reg_prev_image = $this->data['recdata']['recruiter_user_image'];

        if ($user_reg_prev_image != '') {
            $user_image_main_path = $this->config->item('rec_profile_main_upload_path');
            $user_bg_full_image = $user_image_main_path . $user_reg_prev_image;
            if (isset($user_bg_full_image)) {
                unlink($user_bg_full_image);
            }

            $user_image_thumb_path = $this->config->item('rec_profile_profile_thumb_upload_path');
            $user_bg_thumb_image = $user_image_thumb_path . $user_reg_prev_image;
            if (isset($user_bg_thumb_image)) {
                unlink($user_bg_thumb_image);
            }
        }


        $data = $_POST['image'];
        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);
        $user_bg_path = $this->config->item('rec_profile_main_upload_path');
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
        $freelancer_hire_profile['image_library'] = 'gd2';
        $freelancer_hire_profile['source_image'] = $main_image;
        $freelancer_hire_profile['new_image'] = $main_image;
        $freelancer_hire_profile['quality'] = $quality;
        $instanse10 = "image10";
        $this->load->library('image_lib', $freelancer_hire_profile, $instanse10);
        /* RESIZE */

        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
        $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);

        $user_thumb_path = $this->config->item('rec_profile_thumb_upload_path');
        $user_thumb_width = $this->config->item('rec_profile_thumb_width');
        $user_thumb_height = $this->config->item('rec_profile_thumb_height');

        $upload_image = $user_bg_path . $imageName;

        $thumb_image_uplode = $this->thumb_img_uplode($upload_image, $imageName, $user_thumb_path, $user_thumb_width, $user_thumb_height);

        $thumb_image = $user_thumb_path . $imageName;
        $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);

        $data = array(
            'recruiter_user_image' => $imageName
        );

        $update = $this->common->update_data($data, 'recruiter', 'user_id', $userid);

        if ($update) {

            $contition_array = array('user_id' => $userid, 're_status' => '1', 'is_delete' => '0');
            $recruiterpostdata = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'recruiter_user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
            $userimage .= '<img src="' . base_url() . $this->config->item('rec_profile_thumb_upload_path') . $recruiterpostdata[0]['recruiter_user_image'] . '" alt="" >';
            $userimage .= '<a class="cusome_upload" title="Update profile pictuure" href="javascript:void(0);" onclick="updateprofilepopup();"><img src="http://localhost/aileensoul-new/assets/img/cam.png" alt="cameraimage"> Update Profile Picture</a>';

            echo $userimage;
        } else {

            $this->session->flashdata('error', 'Your data not inserted');
            redirect('recruiter/profile', refresh);
        }
    }

    public function aasort(&$array, $key) {
        $sorter = array();
        $ret = array();
        reset($array);

        foreach ($array as $ii => $va) {

            $sorter[$ii] = $va[$key];
        }

        arsort($sorter);

        foreach ($sorter as $ii => $va) {

            $ret[$ii] = $array[$ii];
        }

        return $array = $ret;
    }

    public function invite_user() {

        $this->recruiter_apply_check();

        $postid = $_POST['post_id'];
        $invite_user = $_POST['invited_user'];

        $userid = $this->session->userdata('aileenuser');

        //if user deactive profile then redirect to recruiter/index untill active profile start
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');

        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
        //if user deactive profile then redirect to recruiter/index untill active profile End

        $data = array(
            'user_id' => $userid,
            'post_id' => $postid,
            'invite_user_id' => $invite_user,
            'profile' => "recruiter"
        );
        $insert_id = $this->common->insert_data_getid($data, 'user_invite');

        if ($insert_id) {
            $data = array(
                'not_type' => '4',
                'not_from_id' => $userid,
                'not_to_id' => $invite_user,
                'not_read' => '2',
                'not_status' => '0',
                'not_product_id' => $insert_id,
                'not_from' => '1',
                "not_active" => '1',
                'not_created_date' => date('y-m-d h:i:s'),
            );
            $insert_not = $this->common->insert_data_getid($data, 'notification');

            $jobemail = $this->db->get_where('job_reg', array('user_id' => $invite_user, 'status' => '1'))->row()->email;
            $jobid = $this->session->userdata('aileenuser');
            $recdata = $this->common->select_data_by_id('recruiter', 'user_id', $userid, $data = 'recruiter_user_image,rec_firstname,rec_lastname,re_comp_name', $join_str = array());
            if ($insert_not) {
                $email_html = '';
                $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                             <td style="padding-left: 15px;padding-top: 12px;padding-bottom: 8px;">
                                            <img src="' . REC_PROFILE_THUMB_UPLOAD_URL . $recdata[0]['recruiter_user_image'] . '" width="50" height="50"></td>
                                            <td style="padding:0px;">
						<p style="padding-bottom:5px;padding-top:6px;"><b>' . ucwords($recdata[0]['rec_firstname']) . ' ' . ucwords($recdata[0]['rec_lastname']) . '</b> From ' . ucwords($recdata[0]['re_comp_name']) . 'Invited you for an interview.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;padding-bottom:15px;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a class="btn" href="' . BASEURL . 'notification/recruiter_post/' . $postid . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';

                $subject = $recdata[0]['re_comp_name'] . ' invited for an interview - Aileensoul.';

                $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $jobemail);
            }
            // GET NOTIFICATION COUNT
            $not_count = $this->recruiter_notification_count($invite_user);

            echo json_encode(
                    array(
                        "status" => 'invited',
                        "notification" => array('notification_count' => $not_count, 'to_id' => $invite_user),
            ));
        } else {
            echo 'error';
        }
    }

//reactivate accont end 
    public function recruiter_data($data = "") {
        $this->load->view('recruiter/recruiter_data', $this->data);
    }

//AJAX DESIGNATION START
    public function ajax_designation() {

        $this->recruiter_apply_check();

        $userid = $this->session->userdata('aileenuser');
        //if user deactive profile then redirect to recruiter/index untill active profile start
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');

        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
        //if user deactive profile then redirect to recruiter/index untill active profile End
        $data = array(
            'designation' => $_POST['designation']
        );
        $updatedata = $this->common->update_data($data, 'recruiter', 'user_id', $userid);
        if ($updatedata) {
            echo 'ok';
        } else {
            echo 'error';
        }
    }

//AJAX DESIGNATION END
    // RECRUITER NEW DATA START 19-9
    // RECRUITER RECOMMANDED FUNCTION START
    public function recommen_new_data() {
        $this->recruiter_apply_check();

        $userid = $this->session->userdata('aileenuser');

//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE START
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');
        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE END
//FETCH RECRUITER DATA
// FETCH RECRUITER POST    
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $recpostdata = $this->data['recpostdata'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data = 'post_id,post_skill,post_name,industry_type', $sortby = 'post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        foreach ($recpostdata as $postdata) {

            // FETCH SKILL WISE JOB START
            $recskill = explode(',', $postdata['post_skill']);
            $recskill = array_filter(array_map('trim', $recskill));
            foreach ($recskill as $othrd) {
                $skilluser = array();
                if ($othrd != '') {
                    $contition_array = array('status' => '1', 'is_delete' => '0', 'job_step' => '10', 'user_id != ' => $userid, 'FIND_IN_SET("' . $othrd . '", keyskill) != ' => '0');
                    $skilluser[] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_id', $sortby = 'job_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                }
            }

            $skillaarray = array_reduce($skilluser, 'array_merge', array());

            // FETCH SKILL WISE JOB END
            // FETCH TITLE WISE JOB END
            $titleuser = array();
            $contition_array = array('status' => '1', 'is_delete' => '0', 'job_step' => '10', 'user_id != ' => $userid, 'work_job_title' => $postdata['post_name']);
            $titleuser[] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_id', $sortby = 'job_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $titlearray = array_reduce($titleuser, 'array_merge', array());
            // FETCH TITLE WISE JOB END
            // FETCH INDUSTERY WISE JOB END
            $induser = array();
            $contition_array = array('status' => '1', 'is_delete' => '0', 'job_step' => '10', 'user_id != ' => $userid, 'work_job_industry' => $postdata['industry_type']);
            $induser[] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_id', $sortby = 'job_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $indarray = array_reduce($induser, 'array_merge', array());
            // FETCH INDUSTERY WISE JOB END

            $recommendata = array_merge((array) $titlearray, (array) $skillaarray, (array) $indarray);
            $recommendata[] = array_reduce($recommendata, 'array_merge', array());
            $newdata[] = array_unique($recommendata, SORT_REGULAR);
        }

        $recommanarray = array_reduce($newdata, 'array_merge', array());
        $recommanarray = array_unique($recommanarray, SORT_REGULAR);

        foreach ($recommanarray as $key => $candi) {
            foreach ($candi as $ke) {
                $join_str1 = array(
                    array(
                        'join_type' => 'left',
                        'table' => 'job_add_edu',
                        'join_table_id' => 'job_reg.user_id',
                        'from_table_id' => 'job_add_edu.user_id'),
                    array(
                        'join_type' => 'left',
                        'table' => 'job_graduation',
                        'join_table_id' => 'job_reg.user_id',
                        'from_table_id' => 'job_graduation.user_id')
                );
                $data = 'job_reg.user_id as iduser,job_reg.fname,job_reg.lname,job_reg.email,job_reg.phnno,job_reg.language,job_reg.keyskill,job_reg.experience,job_reg.job_user_image,job_reg.designation,job_reg.work_job_title,job_reg.work_job_industry,job_reg.work_job_city,job_reg.slug,job_add_edu.degree,job_add_edu.stream,job_add_edu.board_primary,job_add_edu.board_secondary,job_add_edu.board_higher_secondary,job_add_edu.percentage_primary,job_add_edu.percentage_secondary,job_add_edu.percentage_higher_secondary';
                $contition_array = array('job_reg.job_id' => $ke, 'job_reg.is_delete' => '0', 'job_reg.status' => '1', 'job_reg.job_step' => '10');
                $jobdata[] = $this->data['jobrec'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data, $sortby = 'job_id', $orderby = 'desc', $limit = '', $offset = '', $join_str1, $groupby = '');
            }
        }
        $jobdata = array_reduce($jobdata, 'array_merge', array());
        $this->data['candidatejob'] = $jobdata;
        $this->load->view('recruiter/recommen_candidate', $this->data);
    }

    //RECRUITER NEW DATA END 19-9

    public function rec_search_new() {

        $userid = $this->session->userdata('aileenuser');

        $searchkeyword = trim($_GET["skills"]);
        $searchplace = trim($_GET["searchplace"]);

        if ($searchkeyword == "" || $this->uri->segment(3) == "0") {
            $contition_array = array('city_name' => $searchplace, 'status' => '1');
            $citydata = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
            $join_str1 = array(
                array(
                    'join_type' => 'left',
                    'table' => 'job_add_edu',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_add_edu.user_id'),
                array(
                    'join_type' => 'left',
                    'table' => 'job_graduation',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_graduation.user_id')
            );
            $data = 'job_id,job_reg.user_id as iduser,job_reg.fname,job_reg.lname,job_reg.email,job_reg.phnno,job_reg.language,job_reg.keyskill,job_reg.experience,job_reg.job_user_image,job_reg.designation,job_reg.work_job_title,job_reg.work_job_industry,job_reg.work_job_city,job_reg.slug,job_add_edu.degree,job_add_edu.stream,job_add_edu.board_primary,job_add_edu.board_secondary,job_add_edu.board_higher_secondary,job_add_edu.percentage_primary,job_add_edu.percentage_secondary,job_add_edu.percentage_higher_secondary';
            $contition_array = array('job_reg.status' => '1', 'job_reg.is_delete' => '0', 'job_step' => '10', 'job_reg.user_id != ' => $userid, 'FIND_IN_SET("' . $citydata[0]['city_id'] . '",work_job_city) !=' => '0');
            $jobcity_data = $this->common->select_data_by_condition('job_reg', $contition_array, $data, $sortby = 'job_id', $orderby = 'desc', $limit = '', $offset = '', $join_str1, $groupby = '');
            $unique = $jobcity_data;
        } elseif ($searchplace == "" || $this->uri->segment(4) == "0") {

//JOB TITILE DATA START
            $contition_array = array('status' => 'publish');
            $search_condition = "(name LIKE '%$searchkeyword%')";
            $jobtitledata = $this->common->select_data_by_search('job_title', $search_condition, $contition_array = array(), $data = 'GROUP_CONCAT(title_id) as title_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $job_list = $jobtitledata[0]['title_list'];
            $job_list = str_replace(",", "','", $jobtitledata[0]['title_list']);
            //JOB TITILE DATA END
            //SKILL DATA START
            $contition_array = array('status' => '1');
            $search_condition = "(skill LIKE '%$searchkeyword%')";
            $skilldata = $this->common->select_data_by_search('skill', $search_condition, $contition_array, $data = 'GROUP_CONCAT(skill_id) as skill_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $skill_list = $skilldata[0]['skill_list'];
            //SKILL DATA END
            //INDUSTRY DATA START
            $contition_array = array('is_delete' => '0', 'status' => '1');
            $search_condition = "((industry_name LIKE '%$searchkeyword%') OR (industry_name LIKE '%$searchkeyword%' AND user_id = '$userid'))";
            $inddata = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = 'GROUP_CONCAT(industry_id) as industry_list ', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $ind_list = $inddata[0]['industry_list'];
            $ind_list = str_replace(",", "','", $inddata[0]['industry_list']);
            //INDUSTRY DATA END

            $join_str1 = array(
                array(
                    'join_type' => 'left',
                    'table' => 'job_add_edu',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_add_edu.user_id'),
                array(
                    'join_type' => 'left',
                    'table' => 'job_graduation',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_graduation.user_id')
            );
            $data = 'job_id,job_reg.user_id as iduser,job_reg.fname,job_reg.lname,job_reg.email,job_reg.phnno,job_reg.language,job_reg.keyskill,job_reg.experience,job_reg.job_user_image,job_reg.designation,job_reg.work_job_title,job_reg.work_job_industry,job_reg.work_job_city,job_reg.slug,job_add_edu.degree,job_add_edu.stream,job_add_edu.board_primary,job_add_edu.board_secondary,job_add_edu.board_higher_secondary,job_add_edu.percentage_primary,job_add_edu.percentage_secondary,job_add_edu.percentage_higher_secondary';

            $contition_array = array('job_reg.status' => '1', 'job_reg.is_delete' => '0', 'job_step' => '10', 'job_reg.user_id != ' => $userid);
            $search_condition = "( job_reg.work_job_industry IN ('$ind_list'))";
            $jobind_data = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data, $sortby = 'job_id', $orderby = 'desc', $limit = '', $offset = '', $join_str1, $groupby = '');


            $contition_array = array('job_reg.status' => '1', 'job_reg.is_delete' => '0', 'job_step' => '10', 'job_reg.user_id != ' => $userid);
            $search_condition = "( job_reg.work_job_title IN ('$job_list'))";
            $jobtitle_data = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data, $sortby = 'job_id', $orderby = 'desc', $limit = '', $offset = '', $join_str1, $groupby = '');

            $skill_list = explode(",", $skill_list);
            foreach ($skill_list as $ski) {
                $contition_array = array('job_reg.status' => '1', 'job_reg.is_delete' => '0', 'job_step' => '10', 'job_reg.user_id != ' => $userid, 'FIND_IN_SET("' . $ski . '", keyskill) != ' => '0');
                $jobskill_data[] = $this->common->select_data_by_condition('job_reg', $contition_array, $data, $sortby = 'job_id', $orderby = 'desc', $limit = '', $offset = '', $join_str1, $groupby = '');


//25-9 SKILL RESULT END FOR RECRUITER
            }
            $job_data = $jobskill_data;
            $job_data = array_reduce($job_data, 'array_merge', array());
            $job_data = array_unique($job_data, SORT_REGULAR);

            $unique = array_merge((array) $jobtitle_data, (array) $job_data, (array) $jobind_data);
        } else {


//25-9 SKILL RESULT START FOR RECRUITER
            $contition_array = array('city_name' => $searchplace, 'status' => '1');
            $citydata = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
            //JOB TITILE DATA START
            $contition_array = array('status' => 'publish');
            $search_condition = "(name LIKE '%$searchkeyword%')";
            $jobtitledata = $this->common->select_data_by_search('job_title', $search_condition, $contition_array = array(), $data = 'GROUP_CONCAT(title_id) as title_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $job_list = $jobtitledata[0]['title_list'];
            $job_list = str_replace(",", "','", $jobtitledata[0]['title_list']);
            //JOB TITLE DATA END
            //SKILL DATA START
            $contition_array = array('status' => '1');
            $search_condition = "(skill LIKE '%$searchkeyword%')";
            $skilldata = $this->common->select_data_by_search('skill', $search_condition, $contition_array, $data = 'GROUP_CONCAT(skill_id) as skill_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $skill_list = $skilldata[0]['skill_list'];
            //SKILL DATA END
            //INDUSTRY DATA START
            $contition_array = array('is_delete' => '0', 'status' => '1');
            $search_condition = "((industry_name LIKE '%$searchkeyword%') OR (industry_name LIKE '%$searchkeyword%' AND user_id = '$userid'))";
            $inddata = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = 'GROUP_CONCAT(industry_id) as industry_list ', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $ind_list = $inddata[0]['industry_list'];
            $ind_list = str_replace(",", "','", $inddata[0]['industry_list']);
            //INDUSTRY DATA END


            $join_str1 = array(
                array(
                    'join_type' => 'left',
                    'table' => 'job_add_edu',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_add_edu.user_id'),
                array(
                    'join_type' => 'left',
                    'table' => 'job_graduation',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_graduation.user_id')
            );
            $data = 'job_id,job_reg.user_id as iduser,job_reg.fname,job_reg.lname,job_reg.email,job_reg.phnno,job_reg.language,job_reg.keyskill,job_reg.experience,job_reg.job_user_image,job_reg.designation,job_reg.work_job_title,job_reg.work_job_industry,job_reg.work_job_city,job_reg.slug,job_add_edu.degree,job_add_edu.stream,job_add_edu.board_primary,job_add_edu.board_secondary,job_add_edu.board_higher_secondary,job_add_edu.percentage_primary,job_add_edu.percentage_secondary,job_add_edu.percentage_higher_secondary';
            $contition_array = array('job_reg.status' => '1', 'job_reg.is_delete' => '0', 'job_step' => '10', 'job_reg.user_id != ' => $userid, 'FIND_IN_SET("' . $citydata[0]['city_id'] . '", work_job_city) != ' => '0');
            $search_condition = "( job_reg.work_job_industry IN ('$ind_list'))";
            $jobind_data = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data, $sortby = 'job_id', $orderby = 'desc', $limit = '', $offset = '', $join_str1, $groupby = '');


            $contition_array = array('job_reg.status' => '1', 'job_reg.is_delete' => '0', 'job_step' => '10', 'job_reg.user_id != ' => $userid, 'FIND_IN_SET("' . $citydata[0]['city_id'] . '", work_job_city) != ' => '0');
            $search_condition = "( job_reg.work_job_title IN ('$job_list'))";
            $jobtitle_data = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data, $sortby = 'job_id', $orderby = 'desc', $limit = '', $offset = '', $join_str1, $groupby = '');

            $skill_list = explode(",", $skill_list);
            foreach ($skill_list as $ski) {
                $contition_array = array('job_reg.status' => '1', 'job_reg.is_delete' => '0', 'job_step' => '10', 'job_reg.user_id != ' => $userid, 'FIND_IN_SET("' . $ski . '", keyskill) != ' => '0', 'FIND_IN_SET("' . $citydata[0]['city_id'] . '", work_job_city) != ' => '0');
                $jobskill_data[] = $this->common->select_data_by_condition('job_reg', $contition_array, $data, $sortby = 'job_id', $orderby = 'desc', $limit = '', $offset = '', $join_str1, $groupby = '');
//25-9 SKILL RESULT END FOR RECRUITER
            }
            $job_data = $jobskill_data;
            $job_data = array_reduce($job_data, 'array_merge', array());
            $job_data = array_unique($job_data, SORT_REGULAR);

            $unique = array_merge((array) $jobtitle_data, (array) $job_data, (array) $jobind_data);
        }
    }

    public function other_industry_live() {
        $other_industry = $_POST['other_industry'];
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        $contition_array = array('is_delete' => '0', 'industry_name' => $other_industry);
        $search_condition = "(status = '1')";
        $userdata = $this->data['userdata'] = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = '*', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $count = count($userdata);

        if ($other_industry != NULL) {
            if ($count == 0) {

                $contition_array = array('is_delete' => '0', 'industry_name !=' => "Other");
                $search_condition = "(status = '1')";
                $university = $this->data['university'] = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = '*', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if (count($university) > 0) {
                    $select = '<option value="" selected option disabled>Select your Industry</option>';
                    foreach ($university as $st) {
                        $select .= '<option value="' . $st['industry_id'] . '"';
//                            if ($st['industry_name'] == $other_industry) {
//                                $select .= 'selected';
//                            }
                        $select .= '>' . $st['industry_name'] . '</option>';
                    }
                }
//For Getting Other at end
                $select .= '<option value="' . $other_industry . '" selected>' . $other_industry . '</option>';
                $contition_array = array('is_delete' => '0', 'status' => '1', 'industry_name' => "Other");
                $university_otherdata = $this->common->select_data_by_condition('job_industry', $contition_array, $data = '*', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                $select .= '<option value="' . $university_otherdata[0]['industry_id'] . '">' . $university_otherdata[0]['industry_name'] . '</option>';
//                }
            } else {
                $select .= 0;
            }
        } else {
            $select .= 1;
        }
        echo json_encode(array(
            "select" => $select,
        ));
    }

    public function recruiter_other_industry() {
        $other_industry = $_POST['other_industry'];
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        $contition_array = array('is_delete' => '0', 'industry_name' => $other_industry);
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
        $userdata = $this->data['userdata'] = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = '*', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $count = count($userdata);

        if ($other_industry != NULL) {
            if ($count == 0) {
                $data = array(
                    'industry_name' => $other_industry,
                    'created_date' => date('Y-m-d h:i:s', time()),
                    'status' => '2',
                    'is_delete' => '0',
                    'is_other' => '1',
                    'user_id' => $userid
                );
                $insert_id = $this->common->insert_data_getid($data, 'job_industry');
                if ($insert_id) {

                    $contition_array = array('is_delete' => '0', 'industry_name !=' => "Other");
                    $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
                    $university = $this->data['university'] = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = '*', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    if (count($university) > 0) {
                        $select = '<option value="" selected option disabled>Select your Industry</option>';
                        foreach ($university as $st) {
                            $select .= '<option value="' . $st['industry_id'] . '"';
                            if ($st['industry_name'] == $other_industry) {
                                $select .= 'selected';
                            }
                            $select .= '>' . $st['industry_name'] . '</option>';
                        }
                    }
//For Getting Other at end
                    $contition_array = array('is_delete' => '0', 'status' => '1', 'industry_name' => "Other");
                    $university_otherdata = $this->common->select_data_by_condition('job_industry', $contition_array, $data = '*', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    $select .= '<option value="' . $university_otherdata[0]['industry_id'] . '">' . $university_otherdata[0]['industry_name'] . '</option>';
                }
            } else {
                $select .= 0;
            }
        } else {
            $select .= 1;
        }
        echo json_encode(array(
            "select" => $select,
        ));
    }

//add other_industry into database start 
//    public function recruiter_other_industry1() {
//
//        $other_industry = $_POST['other_industry'];
//        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
//
//
//        $contition_array = array('is_delete' => '0', 'status' => '1', 'industry_name' => $other_industry);
//        $search_condition = "((is_other = '1' AND user_id = $userid) OR (is_other = '0'))";
//        $userdata = $this->data['userdata'] = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = 'count(*) as total', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
//        $count = $userdata[0]['total'];
//
//        if ($other_industry != NULL) {
//            if ($count == 0) {
//                $data = array(
//                    'industry_name' => $other_industry,
//                    'created_date' => date('Y-m-d h:i:s', time()),
//                    'status' => '2',
//                    'is_delete' => '0',
//                    'is_other' => '1',
//                    'user_id' => $userid
//                );
//                $insert_id = $this->common->insert_data_getid($data, 'job_industry');
//                if ($insert_id) {
//
//
//                    $contition_array = array('is_delete' => '0', 'is_other' => '0', 'industry_name !=' => "Others");
//                    $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
//                    $industry = $this->data['industry'] = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = '*', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
//
//                    if (count($industry) > 0) {
//                        $select = '<option value="" selected option disabled>Select Industry</option>';
//
//                        foreach ($industry as $st) {
//                            $select .= '<option value="' . $st['industry_id'] . '"';
//                            if ($st['industry_name'] == $other_industry) {
//                                $select .= 'selected';
//                            }
//                            $select .= '>' . $st['industry_name'] . '</option>';
//                        }
//                    }
////For Getting Other at end
//                    $contition_array = array('is_delete' => '0', 'status' => '1', 'industry_name' => "Others");
//                    $industry_otherdata = $this->data['industry_otherdata'] = $this->common->select_data_by_condition('job_industry', $contition_array, $data = '*', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
//
//                    $select .= '<option value="' . $industry_otherdata[0]['industry_id'] . '">' . $industry_otherdata[0]['industry_name'] . '</option>';
//                }
//            } else {
//                $select .= 0;
//            }
//        } else {
//            $select .= 1;
//        }
//        echo json_encode(array(
//            "select" => $select,
//        ));
//    }
//add other_industry into database End 

    public function live_post($userid = '', $postid = '', $posttitle = '') {

        $segment3 = explode('-', $this->uri->segment(3));
        $slugdata = array_reverse($segment3);
        $postid = $slugdata[0];
        $this->data['recliveid'] = $userid = $slugdata[1];

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 're_status' => '1');
        $data = "rec_id,rec_firstname,rec_lastname,rec_email,re_status,rec_phone,re_comp_name,re_comp_email,re_comp_site,re_comp_country,re_comp_state,re_comp_city,user_id,re_comp_profile,re_comp_sector,	re_comp_activities,re_step,re_comp_phone,recruiter_user_image,profile_background,profile_background_main,designation,comp_logo";
        $recdata = $this->data['recdata'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $join_str[0]['table'] = 'recruiter';
        $join_str[0]['join_table_id'] = 'recruiter.user_id';
        $join_str[0]['from_table_id'] = 'rec_post.user_id';
        $join_str[0]['join_type'] = '';

        $data = 'post_id,post_name,post_last_date,post_description,post_skill,post_position,interview_process,min_sal,max_sal,max_year,,min_year,fresher,degree_name,industry_type,emp_type,rec_post.created_date,rec_post.user_id,recruiter.rec_firstname,recruiter.re_comp_name,recruiter.rec_lastname,recruiter.recruiter_user_image,recruiter.profile_background,recruiter.re_comp_profile,city,country,post_currency,salary_type';
        $contition_array = array('post_id' => $postid, 'status' => '1', 'rec_post.is_delete' => '0', 'rec_post.user_id' => $userid);
        $this->data['postdata'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');


        $cache_time = $this->db->get_where('job_title', array(
                    'title_id' => $this->data['postdata'][0]['post_name']
                ))->row()->name;

        if ($cache_time) {
            $cache_time1 = $cache_time;
        } else {
            $cache_time1 = $this->data['postdata'][0]['post_name'];
        }

        if ($cache_time1 != '') {
            $text = strtolower($this->common->clean($cache_time1));
        } else {
            $text = '';
        }


        $cityname = $this->db->get_where('cities', array('city_id' => $this->data['postdata'][0]['city']))->row()->city_name;
        if ($cityname != '') {
            $cityname = '-vacancy-in-' . strtolower($this->common->clean($cityname));
        } else {
            $cityname = '';
        }
        if ($this->data['postdata'][0]['post_id'] != '') {
            $url = $text . $cityname . '-' . $this->data['postdata'][0]['user_id'] . '-' . $this->data['postdata'][0]['post_id'];
        } else {
            $url = '';
        }
        $segment3 = array_splice($segment3, 0, -2);
        $segment3 = implode(' ', $segment3);
        $segment3 = ucfirst($segment3);

        $this->data['title'] = $segment3 . ' - Aileensoul';

        $contition_array = array('post_id !=' => $postid, 'status' => '1', 'rec_post.is_delete' => '0', 'post_name' => $this->data['postdata'][0]['post_name']);
        $this->data['recommandedpost'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

        if ($url == $this->uri->segment(3)) {
            if ($this->session->userdata('aileenuser')) {
                $this->load->view('job/rec_post', $this->data);
            } else {
                $this->load->view('job/rec_post_login', $this->data);
            }
        } else {
            redirect('recruiter/jobpost/' . $url, refresh);
        }
    }

    //DELETE LOGO START
    public function delete_logo() {
        $id = $_POST['id'];
        $logo = $_POST['logo'];

        $data = array(
            'comp_logo' => ''
        );

        $updatedata = $this->common->update_data($data, 'recruiter', 'rec_id', $id);

        //FOR DELETE IMAGE AND PDF IN FOLDER START
        $path = 'uploads/recruiter_profile/main/' . $logo;
        $path1 = 'uploads/recruiter_profile/thumbs/' . $logo;

        unlink($path);
        unlink($path1);
        //FOR DELETE IMAGE AND PDF IN FOLDER END
        echo 1;
        die();
    }

//DELETE LOGO END
//LIVE LOCATION START
    public function postlocation() {

        $segment3 = explode('-', $this->uri->segment(1));
        $slugdata = array_reverse($segment3);
        $postid = $slugdata[0];
        $city_id = $this->db->select('city_id')->get_where('cities', array('city_name' => $postid))->row()->city_id;

        $this->data['recliveid'] = $userid = $slugdata[1];

        $join_str[0]['table'] = 'recruiter';
        $join_str[0]['join_table_id'] = 'recruiter.user_id';
        $join_str[0]['from_table_id'] = 'rec_post.user_id';
        $join_str[0]['join_type'] = '';

        $data = 'post_id,post_name,post_last_date,post_description,post_skill,post_position,interview_process,min_sal,max_sal,max_year,,min_year,fresher,degree_name,industry_type,emp_type,rec_post.created_date,rec_post.user_id,recruiter.rec_firstname,recruiter.re_comp_name,recruiter.rec_lastname,recruiter.recruiter_user_image,recruiter.profile_background,recruiter.re_comp_profile,city,country,post_currency,salary_type';
        $contition_array = array('rec_post.city' => $city_id, 'status' => '1', 'rec_post.is_delete' => '0');
        $this->data['postdata'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

        $cityname = $this->db->get_where('cities', array('city_id' => $this->data['postdata'][0]['city']))->row()->city_name;
        $this->data['title'] = 'Job in ' . $cityname . ' - Aileensoul';

        $this->load->view('recruiter/rec_location_login', $this->data);
    }

//LIVE LOCATION END

    public function rec_reg() {
        $this->data['title'] = 'Register | Recruiter Profile - Aileensoul';
        $userid = $this->session->userdata('aileenuser');

//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE START
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');
        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if ($recruiter_deactive) {
            redirect('recruiter/');
        }

// FETCH COUNTRY DATA    
        $contition_array = array('status' => '1');
        $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = 'country_id,country_name', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// FETCH STATE DATA  
        $contition_array = array('status' => '1', 'country_id' => $this->data['recdata']['re_comp_country']);
        $this->data['states'] = $this->common->select_data_by_condition('states', $contition_array, $data = '*', $sortby = 'state_id,state_name,country_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// FETCH CITY DATA
        $contition_array = array('status' => '1', 'state_id' => $this->data['recdata']['re_comp_state']);
        $this->data['cities'] = $this->common->select_data_by_condition('cities', $contition_array, $data = '*', $sortby = 'city_name,city_id,state_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($this->session->userdata('aileenuser')) {
            $userid = $this->session->userdata('aileenuser');
            $recuser = $this->db->select('user_id')->get_where('recruiter', array('user_id' => $userid))->row()->user_id;
        }
        if ($recuser) {
            redirect('recruiter/home', refresh);
        } else {
            $this->load->view('recruiter/rec_reg', $this->data);
        }
    }

    public function reg_insert() {

        $userid = $this->session->userdata('aileenuser');

//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE START
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');
        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
//IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE END
        //IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE END

        $this->form_validation->set_rules('first_name', 'first Name', 'required');
        $this->form_validation->set_rules('last_name', 'last Name', 'required');
        $this->form_validation->set_rules('email', ' EmailId', 'required|valid_email');
        $this->form_validation->set_rules('country', 'Country', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('comp_name', 'company Name', 'required');
        $this->form_validation->set_rules('comp_email', 'company email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {

// FETCH COUNTRY DATA    
            $contition_array = array('status' => '1');
            $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = 'country_id,country_name', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// FETCH STATE DATA  
            $contition_array = array('status' => '1', 'country_id' => $this->data['recdata']['re_comp_country']);
            $this->data['states'] = $this->common->select_data_by_condition('states', $contition_array, $data = '*', $sortby = 'state_id,state_name,country_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// FETCH CITY DATA
            $contition_array = array('status' => '1', 'state_id' => $this->data['recdata']['re_comp_state']);
            $this->data['cities'] = $this->common->select_data_by_condition('cities', $contition_array, $data = '*', $sortby = 'city_name,city_id,state_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->load->view('recruiter/rec_reg', $this->data);
        } else {

            $data = array(
                'rec_firstname' => $this->input->post('first_name'),
                'rec_lastname' => $this->input->post('last_name'),
                'rec_email' => $this->input->post('email'),
                'user_id' => $userid,
                're_comp_name' => $this->input->post('comp_name'),
                're_comp_email' => $this->input->post('comp_email'),
                're_comp_phone' => $this->input->post('comp_num'),
                're_comp_profile' => trim($this->input->post('comp_profile')),
                're_comp_country' => $this->input->post('country'),
                're_comp_state' => $this->input->post('state'),
                're_comp_city' => $this->input->post('city'),
                'created_date' => date('y-m-d h:i:s'),
                're_status' => '1',
                'is_delete' => '0',
                're_step' => '3'
            );


            $insert_id = $this->common->insert_data_getid($data, 'recruiter');
            if ($this->input->post('segment') == 'live-post') {
                $segment = $this->input->post('segment');

                $contition_array = array('status' => '1', 'is_delete' => '0', 'user_id' => $userid);
                $temp = $this->common->select_data_by_condition('rec_post_login', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if (is_numeric($temp[0]['industry_type'])) {
                    $industrydata = $temp[0]['industry_type'];
                } else {
                    $data = array(
                        'industry_name' => $temp[0]['industry_type'],
                        'created_date' => date('Y-m-d h:i:s', time()),
                        'status' => '2',
                        'is_delete' => '0',
                        'is_other' => '1',
                        'user_id' => $userid
                    );
                    $insert_id = $this->common->insert_data_getid($data, 'job_industry');
                    if ($insert_id) {
                        $contition_array = array('is_delete' => '0', 'industry_name' => $temp[0]['industry_type']);
                        $search_condition = "(is_other = '1' AND user_id = $userid)";
                        $industrydata = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = 'industry_id', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                        $industrydata = $industrydata[0]['industry_id'];
                    }
                }

                $data = array(
                    'post_name' => $temp[0]['post_name'],
                    'post_description' => $temp[0]['post_description'],
                    'post_skill' => $temp[0]['post_skill'],
                    'post_position' => $temp[0]['post_position'],
                    'post_last_date' => $temp[0]['post_last_date'],
                    'country' => $temp[0]['country'],
                    'state' => $temp[0]['state'],
                    'city' => $temp[0]['city'],
                    'min_year' => $temp[0]['min_year'],
                    'max_year' => $temp[0]['max_year'],
                    'interview_process' => $temp[0]['interview_process'],
                    'industry_type' => $industrydata,
                    'degree_name' => $temp[0]['degree_name'],
                    'emp_type' => $temp[0]['emp_type'],
                    'fresher' => $temp[0]['fresher'],
                    'min_sal' => $temp[0]['min_sal'],
                    'max_sal' => $temp[0]['max_sal'],
                    'post_currency' => $temp[0]['post_currency'],
                    'salary_type' => $temp[0]['salary_type'],
                    'is_delete' => '0',
                    'created_date' => date('y-m-d h:i:s'),
                    'user_id' => $userid,
                    'status' => '1',
                );
                $insert_id = $this->common->insert_data_getid($data, 'rec_post');

                $data = array(
                    'is_delete' => '1',
                    'status' => '0',
                    'modify_date' => date('y-m-d h:i:s')
                );

                $updatdata = $this->common->update_data($data, 'rec_post_login', 'post_id', $temp[0][post_id]);
            }
            if ($insert_id) {

                $datavl = "ok";
                echo json_encode(
                        array(
                            "okmsg" => $datavl,
                            "segment" => $segment,
                ));
            } else {
                $this->session->flashdata('error', 'Sorry!! Your data not inserted');
                redirect('recruiter', refresh);
            }
        }
    }

    public function abc() {
        $this->load->view('test/index');
    }

    public function recruiter_notification_count($to_id = '') {
        $contition_array = array('not_read' => '2', 'not_to_id' => $to_id, 'not_type !=' => '1', 'not_type !=' => '2');
        $result = $this->common->select_data_by_condition('notification', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $count = $result[0]['total'];
        return $count;
    }

    public function add_post_login() {

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('status' => '1');
        $this->data['currency'] = $this->common->select_data_by_condition('currency', $contition_array, $data = '*', $sortby = 'currency_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('is_delete' => '0', 'is_other' => '0', 'industry_name !=' => "Others");
        $search_condition = "(status = '1')";
        $industry = $this->data['industry'] = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = '*', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        $contition_array = array('is_delete' => '0', 'status' => '1', 'industry_name' => "Others");
        $this->data['industry_otherdata'] = $this->common->select_data_by_condition('job_industry', $contition_array, $data = '*', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('is_delete' => '0', 'degree_name !=' => "Other");
        $search_condition = "(status = '1')";
        $degree = $this->data['degree'] = $this->common->select_data_by_search('degree', $search_condition, $contition_array, $data = '*', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('is_delete' => '0', 'status' => '1', 'degree_name' => "Other");
        $this->data['degree_otherdata'] = $this->common->select_data_by_condition('degree', $contition_array, $data = '*', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('status' => '1');
        $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = '*', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('status' => '1', 'type' => '1');
        $this->data['skill'] = $this->common->select_data_by_condition('skill', $contition_array, $data = '*', $sortby = 'skill', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('status' => 'publish');
        $jobtitle = $this->common->select_data_by_condition('job_title', $contition_array, $data = 'name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

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


        $this->load->view('recruiter/add_post_login', $this->data);
    }

    public function add_post_insert() {

        $userid = $this->session->userdata('aileenuser');

        $jobtitle = $this->input->post('post_name');
        $skills = $this->input->post('skills');
        $position = $this->input->post('position');
        $minyear = $this->input->post('minyear');
        $maxyear = $this->input->post('maxyear');
        $fresher = $this->input->post('fresher');
        $industry = $this->input->post('industry');
        $emp_type = $this->input->post('emp_type');
        $education = $this->input->post('education');
        $post_desc = $this->input->post('post_desc');
        $interview = $this->input->post('interview');
        $country = $this->input->post('country');
        $state = $this->input->post('state');
        $city = $this->input->post('city');
        $salary_type = $this->input->post('salary_type');
        $lastdate = $this->input->post('datepicker');
        $minsal = $this->input->post('minsal');
        $maxsal = $this->input->post('maxsal');
        $currency = $this->input->post('currency');

        if ($jobtitle != " ") {
            $contition_array = array('name' => trim($jobtitle));
            $jobdata = $this->common->select_data_by_condition('job_title', $contition_array, $data = 'title_id,name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
            if ($jobdata) {
                $jobtitle = $jobdata[0]['title_id'];
            } else {
                $data = array(
                    'name' => ucfirst($this->input->post('post_name')),
                    'slug' => $this->common->clean('post_name'),
                    'status' => 'draft',
                );
                $jobtitle = $this->common->insert_data_getid($data, 'job_title');
            }
        }

        $skills = explode(',', $skills);
        if (count($skills) > 0) {

            foreach ($skills as $ski) {
                if ($ski != " ") {
                    $contition_array = array('skill' => trim($ski), 'type' => '1');
                    $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');

                    if (count($skilldata) == 0) {
                        $contition_array = array('skill' => trim($ski), 'type' => '4');

                        $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                    }
                    if ($skilldata) {
                        $skill1[] = $skilldata[0]['skill_id'];
                    } else {
                        $data = array(
                            'skill' => trim($ski),
                            'status' => '1',
                            'type' => '4',
                            'user_id' => $userid,
                        );
                        $skill1[] = $this->common->insert_data_getid($data, 'skill');
                    }
                }
            }
        }
        $skills = implode(',', $skill1);

        $education = explode(',', $education);
        if (count($education) > 0) {

            foreach ($education as $educat) {
                if ($educat != " ") {
                    $contition_array = array('degree_name' => trim($educat), 'status' => '1', 'is_other' => '0');
                    $edudata = $this->common->select_data_by_condition('degree', $contition_array, $data = 'degree_id,degree_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');

                    if (count($edudata) == 0) {
                        $contition_array = array('degree_name' => trim($educat), 'status' => '2', 'is_other' => '1', 'user_id' => $userid);
                        $edudata = $this->common->select_data_by_condition('degree', $contition_array, $data = 'degree_id,degree_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                    }
                    if ($edudata) {
                        $edudata1[] = $edudata[0]['degree_id'];
                    } else {
                        $data = array(
                            'degree_name' => trim($educat),
                            'status' => '2',
                            'is_other' => '1',
                            'user_id' => $userid,
                            'created_date' => date('y-m-d h:i:s'),
                        );
                        $edudata1[] = $this->common->insert_data_getid($data, 'degree');
                    }
                }
            }
        }
        $edudata = implode(',', $edudata1);

        $data = array(
            'post_name' => $jobtitle,
            'post_description' => trim($post_desc),
            'post_skill' => $skills,
            'post_position' => $position,
            'post_last_date' => date('Y-m-d', strtotime($lastdate)),
            'country' => $country,
            'state' => $state,
            'city' => $city,
            'min_year' => $minyear,
            'max_year' => $maxyear,
            'interview_process' => trim($interview),
            'industry_type' => $industry,
            'degree_name' => $edudata,
            'emp_type' => $emp_type,
            'fresher' => $fresher,
            'min_sal' => $minsal,
            'max_sal' => $maxsal,
            'post_currency' => $currency,
            'salary_type' => $salary_type,
            'is_delete' => '0',
            'created_date' => date('y-m-d h:i:s'),
            'user_id' => $userid,
            'status' => '1',
        );

        $insert_id = $this->common->insert_data_getid($data, 'rec_post');

        if ($insert_id) {
            $data = "ok";
            echo json_encode(
                    array(
                        "data" => $data,
                        "id" => $userid,
            ));
        } else {
            $data = "notok";

            echo json_encode(
                    array(
                        "data" => $data,
                        "id" => $userid,
            ));
        }
    }

    public function add_post_added() {

        $userid = $this->session->userdata('aileenuser');

        $jobtitle = $this->input->post('post_name');
        $skills = $this->input->post('skills');
        $position = $this->input->post('position');
        $minyear = $this->input->post('minyear');
        $maxyear = $this->input->post('maxyear');
        $fresher = $this->input->post('fresher');
        $industry = $this->input->post('industry');
        $emp_type = $this->input->post('emp_type');
        $education = $this->input->post('education');
        $post_desc = $this->input->post('post_desc');
        $interview = $this->input->post('interview');
        $country = $this->input->post('country');
        $state = $this->input->post('state');
        $city = $this->input->post('city');
        $salary_type = $this->input->post('salary_type');
        $lastdate = $this->input->post('datepicker');
        $minsal = $this->input->post('minsal');
        $maxsal = $this->input->post('maxsal');
        $currency = $this->input->post('currency');





        if ($jobtitle != " ") {
            $contition_array = array('name' => trim($jobtitle));
            $jobdata = $this->common->select_data_by_condition('job_title', $contition_array, $data = 'title_id,name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
            if ($jobdata) {
                $jobtitle = $jobdata[0]['title_id'];
            } else {
                $data = array(
                    'name' => ucfirst($this->input->post('post_name')),
                    'slug' => $this->common->clean('post_name'),
                    'status' => 'draft',
                );
                $jobtitle = $this->common->insert_data_getid($data, 'job_title');
            }
        }

        $skills = explode(',', $skills);
        if (count($skills) > 0) {

            foreach ($skills as $ski) {
                if ($ski != " ") {
                    $contition_array = array('skill' => trim($ski), 'type' => '1');
                    $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');

                    if (count($skilldata) == 0) {
                        $contition_array = array('skill' => trim($ski), 'type' => '4');

                        $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                    }
                    if ($skilldata) {
                        $skill1[] = $skilldata[0]['skill_id'];
                    } else {
                        $data = array(
                            'skill' => trim($ski),
                            'status' => '1',
                            'type' => '4',
                            'user_id' => $userid,
                        );
                        $skill1[] = $this->common->insert_data_getid($data, 'skill');
                    }
                }
            }
        }
        $skills = implode(',', $skill1);

        $education = explode(',', $education);
        if (count($education) > 0) {

            foreach ($education as $educat) {
                if ($educat != " ") {
                    $contition_array = array('degree_name' => trim($educat), 'status' => '1', 'is_other' => '0');
                    $edudata = $this->common->select_data_by_condition('degree', $contition_array, $data = 'degree_id,degree_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');

                    if (count($edudata) == 0) {
                        $contition_array = array('degree_name' => trim($educat), 'status' => '2', 'is_other' => '1', 'user_id' => $userid);
                        $edudata = $this->common->select_data_by_condition('degree', $contition_array, $data = 'degree_id,degree_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                    }
                    if ($edudata) {
                        $edudata1[] = $edudata[0]['degree_id'];
                    } else {
                        $data = array(
                            'degree_name' => trim($educat),
                            'status' => '2',
                            'is_other' => '1',
                            'user_id' => $userid,
                            'created_date' => date('y-m-d h:i:s'),
                        );
                        $edudata1[] = $this->common->insert_data_getid($data, 'degree');
                    }
                }
            }
        }
        $edudata = implode(',', $edudata1);

        $data = array(
            'post_name' => $jobtitle,
            'post_description' => trim($post_desc),
            'post_skill' => $skills,
            'post_position' => $position,
            'post_last_date' => date('Y-m-d', strtotime($lastdate)),
            'country' => $country,
            'state' => $state,
            'city' => $city,
            'min_year' => $minyear,
            'max_year' => $maxyear,
            'interview_process' => trim($interview),
            'industry_type' => $industry,
            'degree_name' => $edudata,
            'emp_type' => $emp_type,
            'fresher' => $fresher,
            'min_sal' => $minsal,
            'max_sal' => $maxsal,
            'post_currency' => $currency,
            'salary_type' => $salary_type,
            'is_delete' => '0',
            'created_date' => date('y-m-d h:i:s'),
            'user_id' => $userid,
            'status' => '1',
        );

        $insert_id = $this->common->insert_data_getid($data, 'rec_post_login');

        $data = "ok";
        echo json_encode(
                array(
                    "data" => $data,
        ));
    }

    public function get_degree($id = "") {


        //get search term
        $searchTerm = $_GET['term'];
        if (!empty($searchTerm)) {

            $contition_array = array('is_delete' => '0', 'degree_name !=' => "Other");
            $search_condition = "((status = '1')) AND (degree_name LIKE '" . trim($searchTerm) . "%')";
            $degree = $this->data['degree'] = $this->common->select_data_by_search('degree', $search_condition, $contition_array, $data = 'degree_name as text', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }
        foreach ($degree as $key => $value) {
            $degreedata[$key]['value'] = $value['text'];
        }

        $cdata = array_values($degreedata);
        echo json_encode($cdata);
    }

    public function city_group() {

        $contition_array = array('state_id !=' => '0', 'status' => '1');
        $citydata = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_id,city_name', $sortby = '', $orderby = '', $limit = '5000', $offset = '45000', $join_str5 = '', $groupby = '');

        foreach ($citydata as $cityid) {
            $data = array(
                'group_id' => $cityid['city_id']
            );

            $insert_id = $this->common->update_data($data, 'cities', 'city_id', $cityid['city_id']);
        }
        echo "yes";
    }

    public function city_slug() {

        $contition_array = array('state_id !=' => '0', 'status' => '1');
        $citydata = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_id,city_name', $sortby = '', $orderby = '', $limit = '50', $offset = '0', $join_str5 = '', $groupby = '');

        foreach ($citydata as $k => $v) {
            $data = array('slug' => $this->common->clean($v['city_name']));
            $insert_id = $this->common->update_data($data, 'cities', 'city_id', $v['city_id']);
        }
        echo "yes";
    }

    public function rec_check_login() {
        $email_login = $this->input->post('email_login');
        $password_login = $this->input->post('password_login');

        $result = $this->user_model->getUserByEmail($email_login);
        $userinfo = $this->logins->check_login($email_login, $password_login);
        if (count($userinfo) > 0) {
            if ($userinfo['status'] == "2") {
                echo 'Sorry, user is Inactive.';
            } else {
                $this->session->set_userdata('aileenuser', $userinfo[0]['user_id']);
                $this->session->set_userdata('aileenuser_slug', $userinfo[0]['user_slug']);
                $is_data = 'ok';
            }
        } else if ($email_login == $result['user_email']) {
            $is_data = 'password';
            $id = $result['user_id'];
        } else {
            $is_data = 'email';
        }
        $rec_result = $this->recruiter_model->CheckRecruiterAvailable($id);
        $rec = 0;
        if ($rec_result['total'] > 0) {
            $rec = 1;
        }
        echo json_encode(
                array(
                    "data" => $is_data, "id" => $id, "is_rec" => $rec
        ));
    }

    public function company_logo() {
        $userid = $this->session->userdata('aileenuser');
        $temp = $_FILES["companylogo"]["name"];
        $temporary = explode(".", $_FILES["companylogo"]["name"]);

        $error = '';
        if ($_FILES['companylogo']['name'] != '') {
            $logo = '';
            $job['upload_path'] = $this->config->item('rec_profile_main_upload_path');
            $job['allowed_types'] = $this->config->item('rec_profile_main_allowed_types');
            $job['max_size'] = $this->config->item('rec_profile_main_max_size');
            $job['max_width'] = $this->config->item('rec_profile_main_max_width');
            $job['max_height'] = $this->config->item('rec_profile_main_max_height');
            $this->load->library('upload');
            $this->upload->initialize($job);
//Uploading Image
            $this->upload->do_upload('companylogo');
//Getting Uploaded Image File Data
            $imgdata = $this->upload->data();
            $imgerror = $this->upload->display_errors();

            if ($imgerror == '') {

//Configuring Thumbnail 
                $job_thumb['image_library'] = 'gd2';
                $job_thumb['source_image'] = $job['upload_path'] . $imgdata['file_name'];
                $job_thumb['new_image'] = $this->config->item('rec_profile_thumb_upload_path') . $imgdata['file_name'];
                $job_thumb['create_thumb'] = TRUE;
                $job_thumb['maintain_ratio'] = TRUE;
                $job_thumb['thumb_marker'] = '';
                $job_thumb['width'] = $this->config->item('rec_profile_thumb_width');
                $job_thumb['height'] = 2;
                $job_thumb['master_dim'] = 'width';
                $job_thumb['quality'] = "100%";
                $job_thumb['x_axis'] = '0';
                $job_thumb['y_axis'] = '0';
//Loading Image Library
                $this->load->library('image_lib', $job_thumb);
                $dataimage = $imgdata['file_name'];
//Creating Thumbnail

                $main_image = $this->config->item('rec_profile_main_upload_path') . $imgdata['file_name'];
                $thumb_image = $this->config->item('rec_profile_thumb_upload_path') . $imgdata['file_name'];


                $s3 = new S3(awsAccessKey, awsSecretKey);
                $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
                $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);

                //  echo $main_image;die();
                // $thumb_image = $rec_image_thumb_path . $imageName;
                copy($main_image, $thumb_image);
                $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);

                if ($_SERVER['HTTP_HOST'] != "localhost") {
                    if (isset($main_image)) {
                        unlink($main_image);
                    }
                    if (isset($thumb_image)) {
                        unlink($thumb_image);
                    }
                }

                $this->image_lib->resize();
                $thumberror = $this->image_lib->display_errors();
            } else {
                $thumberror = '';
            }
            if ($imgerror != '' || $thumberror != '') {
                $error[0] = $imgerror;
                $error[1] = $thumberror;
            } else {
                $error = array();
            }

            $logoimage = $_FILES['companylogo']['name'];
            if ($logoimage != "") {
                $data = array(
                    'comp_logo' => $_FILES['companylogo']['name']
                );
            } else {
                $data = array(
                    'comp_logo' => ''
                );
            }

            $insert_id = $this->common->update_data($data, 'recruiter', 'user_id', $userid);
            if ($insert_id) {
                $data = "sucess";
                // echo $data;

                $contition_array = array('user_id' => $userid, 're_status' => '1', 'is_delete' => '0');
                $recruiterpostdata = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'comp_logo', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
                $userimage .= '<a href="javascript:void(0);" onclick="upload_company_logo();" title="Upload Company Logo"><img src="' . REC_PROFILE_THUMB_UPLOAD_URL . $recruiterpostdata[0]['comp_logo'] . '" alt="" ></a>';
                // $userimage .= '<a href="javascript:void(0);" onclick="upload_company_logo(' . $post['user_id'] . ');" title="Upload Company Logo">Update Profile Picture</a>';
                echo $userimage;
            } else {
                $data = "error";
                echo $data;
            }
        } else {
            $contition_array = array('user_id' => $userid, 're_status' => '1', 'is_delete' => '0');
            $recruiterpostdata = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'comp_logo', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
            $userimage .= '<a href="javascript:void(0);" onclick="upload_company_logo();" title="Upload Company Logo"><img src="' . REC_PROFILE_THUMB_UPLOAD_URL . $recruiterpostdata[0]['comp_logo'] . '" alt="" ></a>';
            echo $userimage;
        }
    }

}
