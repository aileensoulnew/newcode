<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_info extends MY_Controller {

    public $data;

    public function __construct() {

        parent::__construct();
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('data_model');
        $this->load->library('S3');
    }
    
    public function index() {
        $userid = $this->session->userdata('aileenuser');
        $userdata = $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['title'] = "Basic Information | Aileensoul";
        $this->load->view('user_info/index', $this->data);
    }

//    public function index() {
//        $userid = $this->session->userdata('aileenuser');
//        $userdata = $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
//        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
//        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
//        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
//        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
//        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
//        $this->data['title'] = "Basic Information | Aileensoul";
//        $this->load->view('user_basic_info/index', $this->data);
//    }

    public function ng_basic_info_insert() {
        $userid = $this->session->userdata('aileenuser');

        $errors = array();
        $data = array();

        $_POST = json_decode(file_get_contents('php://input'), true);

        if (empty($_POST['jobTitle']))
            $errors['jobTitle'] = 'Job title is required.';

        if (empty($_POST['cityList']))
            $errors['cityList'] = 'City is required.';

        if (empty($_POST['field']))
            $errors['field'] = 'Field is required.';

        if ($_POST['field'] == '0') {
            if (empty($_POST['otherField']))
                $errors['otherField'] = 'Other field is required.';
        }
        if (!empty($errors)) {
            $data['errors'] = $errors;
        } else {
            if (is_array($_POST['jobTitle'])) {
                $jobTitleId = $_POST['jobTitle']['title_id'];
            } else {
                $designation = $this->data_model->findJobTitle($_POST['jobTitle']);
                if ($designation['title_id'] != '') {
                    $jobTitleId = $designation['title_id'];
                } else {
                    $data = array();
                    $data['name'] = $_POST['jobTitle'];
                    $data['created_date'] = date('Y-m-d H:i:s', time());
                    $data['modify_date'] = date('Y-m-d H:i:s', time());
                    $data['status'] = 'draft';
                    $data['slug'] = $this->common->clean($_POST['jobTitle']);
                    $jobTitleId = $this->common->insert_data_getid($data, 'job_title');
                }
            }

            if (is_array($_POST['cityList'])) {
                $cityId = $_POST['cityList']['city_id'];
            } else {
                $city = $this->data_model->findCityList($_POST['cityList']);
                if ($city['city_id'] != '') {
                    $cityId = $city['city_id'];
                } else {
                    $data = array();
                    $data['city_name'] = $_POST['cityList'];
                    $data['state_id'] = '0';
                    $data['status'] = '2';
                    $data['group_id'] = '0';
                    $cityId = $this->common->insert_data_getid($data, 'cities');
                }
            }
            $data = array();
            $data['user_id'] = $userid;
            $data['designation'] = $jobTitleId;
            $data['field'] = $_POST['field'];
            $data['city'] = $cityId;

            $insert_id = $this->common->insert_data_getid($data, 'user_profession');
            if ($insert_id) {
                $data['is_success'] = 1;
            } else {
                $data['is_success'] = 0;
            }
        }
// response back.
        echo json_encode($data);
    }

    public function ng_student_info_insert() {
        $userid = $this->session->userdata('aileenuser');

        $errors = array();
        $data = array();

        $_POST = json_decode(file_get_contents('php://input'), true);
        
        if (empty($_POST['currentStudy']))
            $errors['currentStudy'] = 'Current study is required.';

        if (empty($_POST['cityList']))
            $errors['cityList'] = 'City is required.';

        if (empty($_POST['universityName']))
            $errors['universityName'] = 'University name is required.';

        if (!empty($errors)) {
            $data['errors'] = $errors;
        } else {
            if (is_array($_POST['currentStudy'])) {
                $degreeId = $_POST['currentStudy']['degree_id'];
            } else {
                $degree = $this->data_model->findDegreeList($_POST['currentStudy']);
                if ($degree['degree_id'] != '') {
                    $degreeId = $degree['degree_id'];
                } else {
                    $data = array();
                    $data['degree_name'] = $_POST['currentStudy'];
                    $data['created_date'] = date('Y-m-d H:i:s', time());
                    $data['modify_date'] = date('Y-m-d H:i:s', time());
                    $data['status'] = '2';
                    $data['is_delete'] = '0';
                    $data['is_other'] = '1';
                    $data['user_id'] = $userid;
                    $degreeId = $this->common->insert_data_getid($data, 'degree');
                }
            }

            if (is_array($_POST['cityList'])) {
                $cityId = $_POST['cityList']['city_id'];
            } else {
                $city = $this->data_model->findCityList($_POST['cityList']);
                if ($city['city_id'] != '') {
                    $cityId = $city['city_id'];
                } else {
                    $data = array();
                    $data['city_name'] = $_POST['cityList'];
                    $data['state_id'] = '0';
                    $data['status'] = '2';
                    $data['group_id'] = '0';
                    $cityId = $this->common->insert_data_getid($data, 'cities');
                }
            }
            
            if (is_array($_POST['universityName'])) {
                $universityId = $_POST['universityName']['university_id'];
            } else {
                $university = $this->data_model->findUniversityList($_POST['universityName']);
                if ($university['university_id'] != '') {
                    $universityId = $university['university_id'];
                } else {
                    $data = array();
                    $data['university_name'] = $_POST['universityName'];
                    $data['created_date'] = date('Y-m-d H:i:s',time());
                    $data['status'] = '2';
                    $data['is_delete'] = '0';
                    $data['is_other'] = '1';
                    $universityId = $this->common->insert_data_getid($data, 'university');
                }
            }
            
            $data = array();
            $data['user_id'] = $userid;
            $data['current_study'] = $degreeId;
            $data['city'] = $cityId;
            $data['university_name'] = $universityId;

            $insert_id = $this->common->insert_data_getid($data, 'user_student');
            if ($insert_id) {
                $data['is_success'] = 1;
            } else {
                $data['is_success'] = 0;
            }
        }
// response back.
        echo json_encode($data);
    }

    public function autocomplete() {

        $this->load->view('autoselecteasy', $this->data);
    }

}
