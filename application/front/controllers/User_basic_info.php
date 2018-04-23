<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_basic_info extends MY_Controller {

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

        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['title'] = "Basic Information | Aileensoul";
        $this->load->view('user_basic_info/index', $this->data);
    }

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
            if (is_array($_POST['jobTitle'] == '1')) {
                $jobTitleId = $_POST['jobTitle']['title_id'];
            } else {
                $designation = $this->data_model->findJobTitle($_POST['jobTitle']);
                if ($designation['title_id'] != '') {
                    $jobTitleId = $designation['title_id'];
                } else {
                    $data = array();
                    $data['name'] = $_POST['jobTitle'];
                    $data['created_date'] = date('Y-m-d H:i:s',time());
                    $data['modify_date'] = date('Y-m-d H:i:s',time());
                    $data['status'] = 'draft';
                    $data['slug'] =  $this->common->clean($_POST['jobTitle']);
                    $jobTitleId = $this->common->insert_data_getid($data, 'job_title');
                }
            }
            
            if (is_array($_POST['cityList'] == '1')) {
                $cityId = $_POST['cityList']['city_id'];
            } else {
                $city = $this->data_model->findCityList($_POST['cityList']);
                if ($city['city_id'] != '') {
                    $cityId = $city['city_id'];
                } else {
                    $data = array();
                    $data['city_name'] = $_POST['city_name'];
                    $data['state_id'] = '0';
                    $data['status'] = '2';
                    $data['group_id'] = '0';
                    $cityId = $this->common->insert_data_getid($data, 'cities');
                }
            }
            $data = array();
            $data['user_id'] = $userid;
            $data['designation'] = $_POST['jobTitle'];
            $data['field'] = $_POST['field'];
            $data['city'] = $_POST['city'];

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

    public function autocomplete() {

        $this->load->view('autoselecteasy', $this->data);
    }

}
