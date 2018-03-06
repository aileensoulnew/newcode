<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Freelancer_apply_live extends MY_Controller {

    public $data;

    public function __construct() {

        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('user_agent');
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('user_post_model');
        $this->load->model('data_model');
        $this->load->model('artistic_model');
        $this->load->model('freelancer_apply_model');
        $this->load->library('S3');

        $this->data['no_user_post_html'] = '<div class="user_no_post_avl"><h3>Feed</h3><div class="user-img-nn"><div class="user_no_post_img"><img src=' . base_url('assets/img/bui-no.png?ver=' . time()) . ' alt="bui-no.png"></div><div class="art_no_post_text">No Feed Available.</div></div></div>';
        $this->data['no_user_contact_html'] = '<div class="art-img-nn"><div class="art_no_post_img"><img src="' . base_url('assets/img/No_Contact_Request.png?ver=' . time()) . '"></div><div class="art_no_post_text">No Contacts Available.</div></div>';
        // $this->data['header_all_profile'] = '<div class="dropdown-title"> Profiles <a href="profile.html" title="All" class="pull-right">All</a> </div><div id="abody" class="as"> <ul> <li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i5.jpg') . '"> </div><div class="text-all"> Artistic Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i4.jpg') . '"> </div><div class="text-all"> Business Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i1.jpg') . '"> </div><div class="text-all"> Job Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i2.jpg') . '"> </div><div class="text-all"> Recruiter Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i3.jpg') . '"> </div><div class="text-all"> Freelance Profile </div></a> </div></li></ul> </div>';

        include ('main_profile_link.php');
    }

    public function index() {
    

            $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['artist_profile_link'] =  ($this->artist_profile_set == 1)?$this->artist_profile_link:base_url('artist/registration');
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);

        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['search_banner'] = $this->load->view('freelancer_apply_live/search_banner', $this->data, TRUE);
        $this->data['title'] = "Search Freelance | Aileensoul";
    

        $this->load->view('freelancer_apply_live/freelancer_apply_live', $this->data);
    }

    public function freelancer_apply_live_post() {
        $postdata = $this->freelancer_apply_model->getfreelancerapplypost();
        echo json_encode($postdata);
    }

    public function freelancer_apply_search() {
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['title'] = "Search - Business Profile | Aileensoul";
        $this->data['search_banner'] = $this->load->view('freelancer_apply_live/search_banner', $this->data, TRUE);
        $category_id = $this->db->select('industry_id')->get_where('industry_type', array('industry_slug' => $category))->row_array('industry_id');
        $this->data['category_id'] = $category_id['industry_id'];
        $this->data['q'] = $_GET['q'];
        $this->data['l'] = $_GET['l'];
        $this->load->view('freelancer_apply_live/search', $this->data);
    }

    public function searchFreelancerApplyData() {
        $keyword = $_GET['q'];
        $city = $_GET['l'];
        $time = $_GET['t'];
        $searchFreelancerApplyData = $this->freelancer_apply_model->searchFreelancerApplyData($keyword, $city, $time);
        echo json_encode($searchFreelancerApplyData);
    }
    
    public function freelancerCategory() {
        $limit = $_GET['limit'];
        $freelancerCategory = $this->freelancer_apply_model->freelancerCategory($limit);
        echo json_encode($freelancerCategory);
        
    }
    
    public function categoryFreelancerList($cat_slug = ""){
        echo 123; die();
    }
}