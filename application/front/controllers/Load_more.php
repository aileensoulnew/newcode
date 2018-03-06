<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Load_more extends CI_Controller {

    public $data;

    public function __construct() {
        parent::__construct();

        //AWS access info start
        $this->load->library('S3');
        //AWS access info end
        if ($this->session->userdata('aileenuser')) {
            redirect('profiles/' . $this->session->userdata('aileenuser_slug'), 'refresh');
        }

        $this->load->library('form_validation');
        $this->load->model('logins');
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('business_model');
        $this->load->model('job_model');
        $this->load->model('recruiter_model');
        $this->load->model('freelancer_hire_model');
        $this->load->model('freelancer_apply_model');
    }

//    public function index() {
//
//        $this->load->view('loadmore/index', $this->data);
//    }
    
    public function dataaaaa() {

        $this->load->view('loadmore/index', $this->data);
    }
   
}

/* End of file welcome.php *//* Location: ./application/controllers/welcome.php */