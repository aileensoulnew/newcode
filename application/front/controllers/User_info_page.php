<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_info_page extends MY_Controller {

    public $data;

    public function __construct() {

        parent::__construct();
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('data_model');
        $this->load->library('S3');
    }

    public function index() {
        
    }

    public function basic_profile() {
        $this->load->view('user_info/basic_info', $this->data);
    }

    public function educational_profile() {
        $this->load->view('user_info/educational_info', $this->data);
    }

}
