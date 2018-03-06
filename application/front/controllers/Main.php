<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends CI_Controller {

    public $data;

    public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->model('email_model');
        $this->load->model('main_model');
        $this->load->model('user_model');
        $this->load->library('S3');
        $this->load->helper('cookie');
        $this->load->model('logins');
        //include ('include.php');
    }

    //job seeker basic info controller start
    public function index() {
        if ($this->session->userdata('aileenuser')) {
            $userid = $this->session->userdata('aileenuser');
            $user_slug = $this->user_model->getUserSlugById($userid);
            $this->session->set_userdata('aileenuser_slug', $user_slug['user_slug']);
            $userslug = $this->session->userdata('aileenuser_slug');
            redirect('profiles/' . $userslug, 'refresh');
        } else {
            $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
            $ipaddress = trim($this->input->ip_address());
            $date = date('Y-m-d');
            $uservisit = $this->main_model->checkUserVisitor($ipaddress, $date);
            if ($uservisit['total'] == '0') {
                $data = array(
                    'ip' => $ipaddress,
                    'insert_date' => date('Y-m-d H:i:s', time()),
                );
                $insertid = $this->common->insert_data_getid($data, 'user_visit');
            }
            $this->load->view('main', $this->data);
        }
    }

    public function terms_condition() {
        $this->data['title'] = 'Terms and Condition - Aileensoul';
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data,TRUE);
        $this->load->view('termcondition', $this->data);
    }

    public function privacy_policy() {
        $this->data['title'] = 'Privacy Policy - Aileensoul';
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data,TRUE);
        $this->load->view('privacypolicy', $this->data);
    }

    public function website_disclaimer() {
        $this->load->view('websitedisclaimer', $this->data);
    }
    
    public function demoeight($id = "") {
      $this->load->view('demoeight', $this->data);
    }
    
    public function demoeightang($id = "") {
      $this->load->view('demoangulareight', $this->data);
    }

}
