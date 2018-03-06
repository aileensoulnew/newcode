<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Introduction extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //AWS access info start
        $this->load->library('S3');
        //AWS access info end
        include ('include.php');
    }

    public function index() {
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $profile = $this->check_profile();
        $this->load->view('introduction/business_profile', $this->data);
    }

    public function job_profile() {
        $this->data['title'] = 'Job Profile  - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $profile = $this->check_profile();
        $this->data['is_profile'] = $profile;
        $this->load->view('introduction/job_profile', $this->data);
    }

    public function recruiter_profile() {
        $this->data['title'] = 'Recruiter Profile - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $profile = $this->check_profile();
        $this->data['is_profile'] = $profile;
        $this->load->view('introduction/recruiter_profile', $this->data);
    }

    public function freelance_profile() {
         $this->data['title'] = 'Freelance Profile - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $profile = $this->check_profile();
        $this->data['is_profile'] = $profile;
        $this->load->view('introduction/freelance_profile', $this->data);
    }

    public function business_profile() {
         $this->data['title'] = 'Business Profile  - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $profile = $this->check_profile();
        $this->data['is_profile'] = $profile;
        $this->load->view('introduction/business_profile', $this->data);
    }

    public function artistic_profile() {
         $this->data['title'] = 'Artistic Profile - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $profile = $this->check_profile();
        $this->data['is_profile'] = $profile;
        $this->load->view('introduction/artistic_profile', $this->data);
    }

    public function check_profile() {
        
        $userid = $this->session->userdata('aileenuser');
        
        $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1', 'business_step' => '4');
        $business_result = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $business = 0;
        if ($business_result[0]['total'] > 0) {
            $business = 1;
        }

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1', 'free_post_step' => '7');
        $free_work_result = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $free_work = 0;
        if ($free_work_result[0]['total'] > 0) {
            $free_work = 1;
        }

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1', 'free_hire_step' => '3');
        $free_hire_result = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $free_hire = 0;
        if ($free_hire_result[0]['total'] > 0) {
            $free_hire = 1;
        }

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1', 'art_step' => '4');
        $artistic_result = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $artistic = 0;
        if ($artistic_result[0]['total'] > 0) {
            $artistic = 1;
        }
        
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1', 'job_step' => '10');
        $job_result = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $job = 0;
        if ($job_result[0]['total'] > 0) {
            $job = 1;
        }
        
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 're_status' => '1', 're_step' => '3');
        $recruiter_result = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $recruiter = 0;
        if ($recruiter_result[0]['total'] > 0) {
            $recruiter = 1;
        }
        
        $return_array = array();
        $return_array['is_business']= $business;
        $return_array['is_job']= $job;
        $return_array['is_recruiter']= $recruiter;
        $return_array['is_freelance_hire']= $free_hire;
        $return_array['is_freelance_apply']= $free_work;
        $return_array['is_artistic']= $artistic;
        return $return_array;
    }

}
