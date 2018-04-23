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
         $this->load->model('user_post_model');
        $this->load->model('data_model');
        $this->load->library('S3');
        $this->load->helper('cookie');
        $this->load->model('logins');
        include ('main_profile_link.php');
        //include ('include.php');
    }

    //job seeker basic info controller start
    public function index() {
        if ($this->session->userdata('aileenuser')) {
            $userid = $this->session->userdata('aileenuser');
            $user_slug = $this->user_model->getUserSlugById($userid);
            $this->session->set_userdata('aileenuser_slug', $user_slug['user_slug']);
            $userslug = $this->session->userdata('aileenuser_slug');
            //redirect($userslug.'/profiles', 'refresh');
            $this->home();
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

    public function home()
    {
        $this->data['no_user_post_html'] = '<div class="user_no_post_avl"><h3>Feed</h3><div class="user-img-nn"><div class="user_no_post_img"><img src=' . base_url('assets/img/bui-no.png?ver=' . time()) . ' alt="bui-no.png"></div><div class="art_no_post_text">No Feed Available.</div></div></div>';
        $this->data['no_user_contact_html'] = '<div class="art-img-nn"><div class="art_no_post_img"><img src="' . base_url('assets/img/No_Contact_Request.png?ver=' . time()) . '"></div><div class="art_no_post_text">No Contacts Available.</div></div>';

        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.user_slug,u.first_name,u.last_name,ui.user_image");
        
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['title'] = "Opportunities | Aileensoul";
        $this->load->view('user_post/index', $this->data);
    }

}
