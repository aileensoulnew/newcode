<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Job_live extends MY_Controller {

    public $data;

    public function __construct() {

        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('user_agent');
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('user_post_model');
        $this->load->model('data_model');
        $this->load->model('job_model');
        $this->load->library('S3');

        $this->data['no_user_post_html'] = '<div class="user_no_post_avl"><h3>Feed</h3><div class="user-img-nn"><div class="user_no_post_img"><img src=' . base_url('assets/img/bui-no.png?ver=' . time()) . ' alt="bui-no.png"></div><div class="art_no_post_text">No Feed Available.</div></div></div>';
        $this->data['no_user_contact_html'] = '<div class="art-img-nn"><div class="art_no_post_img"><img src="' . base_url('assets/img/No_Contact_Request.png?ver=' . time()) . '"></div><div class="art_no_post_text">No Contacts Available.</div></div>';
        // $this->data['header_all_profile'] = '<div class="dropdown-title"> Profiles <a href="profile.html" title="All" class="pull-right">All</a> </div><div id="abody" class="as"> <ul> <li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i5.jpg') . '"> </div><div class="text-all"> Artistic Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i4.jpg') . '"> </div><div class="text-all"> Business Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i1.jpg') . '"> </div><div class="text-all"> Job Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i2.jpg') . '"> </div><div class="text-all"> Recruiter Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i3.jpg') . '"> </div><div class="text-all"> Freelance Profile </div></a> </div></li></ul> </div>';
        include ('main_profile_link.php');
    }

    public function index() {
        if($this->job_profile_set ==1){
            redirect( $this->job_profile_link);
        }
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['job_profile_link'] =  ($this->job_profile_set == 1)?$this->job_profile_link:base_url('job/registration');
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['search_banner'] = $this->load->view('job_live/search_banner', $this->data, TRUE);
        $this->data['title'] = "Job Profile | Aileensoul";
        $this->load->view('job_live/index', $this->data);
    }

    public function category($category_slug = '') {
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
        $this->data['search_banner'] = $this->load->view('job_live/search_banner', $this->data, TRUE);
        $category_id = $this->db->select('ji.industry_id')->get_where('job_industry ji', array('industry_slug' => $category_slug))->row_array('ji.industry_id');
        $this->data['category_id'] = $category_id['industry_id'];
        $this->data['title'] = "Categories - Artist Profile | Aileensoul";
        $this->load->view('job_live/category', $this->data);
    }
    
    public function skill($skill_slug = '') {
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
        $this->data['search_banner'] = $this->load->view('job_live/search_banner', $this->data, TRUE);
        $skill_id = $this->db->select('s.skill_id')->get_where('skill s', array('skill_slug' => $skill_slug))->row_array('s.skill_id');
        $this->data['skill_id'] = $skill_id['skill_id'];
        $this->data['title'] = "Skills - Artist Profile | Aileensoul";
        $this->load->view('job_live/skill', $this->data);
    }
    
    public function company($company_id = '') {
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
        $this->data['search_banner'] = $this->load->view('job_live/search_banner', $this->data, TRUE);
        $this->data['company_id'] = $company_id;
        $this->data['title'] = "Companies - Artist Profile | Aileensoul";
        $this->load->view('job_live/company', $this->data);
    }
    
    public function city($city_slug = '') {
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
        $this->data['search_banner'] = $this->load->view('job_live/search_banner', $this->data, TRUE);
        $city_id = $this->db->select('c.city_id')->get_where('cities c', array('slug' => $city_slug))->row_array('c.city_id');
        $this->data['city_id'] = $city_id['city_id'];
        $this->data['title'] = "Cities - Artist Profile | Aileensoul";
        $this->load->view('job_live/city', $this->data);
    }

    public function job_search() {
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
        $this->data['title'] = "Opportunities | Aileensoul";
        $this->data['search_banner'] = $this->load->view('job_live/search_banner', $this->data, TRUE);
        $this->data['q'] = $_GET['q'];
        $this->data['l'] = $_GET['l'];
        $this->data['w'] = $_GET['w'];
        $this->load->view('job_live/search', $this->data);
    }

    public function jobCategory() {
        $limit = $_GET['limit'];
        $jobCategory = $this->job_model->jobCategory($limit);
        echo json_encode($jobCategory);
    }

    public function jobAllCategory() {
        $jobAllCategory = $this->job_model->jobAllCategory();
        echo json_encode($jobAllCategory);
    }

    public function otherCategoryCount() {
        $otherCategoryCount = $this->job_model->otherCategoryCount();
        echo $otherCategoryCount;
    }

    public function jobListByCategory($id = '0') {
        $jobListByCategory = $this->job_model->jobListByCategory($id);
        echo json_encode($jobListByCategory);
    }

    public function jobCity() {
        $limit = $_GET['limit'];
        $jobCity = $this->job_model->jobCity($limit);
        echo json_encode($jobCity);
    }

    public function jobCompany() {
        $limit = $_GET['limit'];
        $jobCompany = $this->job_model->jobCompany($limit);
        echo json_encode($jobCompany);
    }

    public function jobSkill() {
        $limit = $_GET['limit'];
        $jobSkill = $this->job_model->jobSkill($limit);
        echo json_encode($jobSkill);
    }

    public function latestJob() {
        $latestJob = $this->job_model->latestJob();
        echo json_encode($latestJob);
    }

    public function applyJobFilter() {
        $posting_period = implode(',', $_POST['posting_period']);
        $experience = implode(',', $_POST['experience']);
        $category = implode(',', $_POST['category']);
        $location = implode(',', $_POST['location']);
        $company = implode(',', $_POST['company']);
        $skill = implode(',', $_POST['skill']);

        $job_filter = $this->job_model->applyJobFilter($posting_period, $experience, $category, $location, $company, $skill);
        echo json_encode($job_filter);
    }

    public function searchJobData() {
        $keyword = $_GET['q'];
        $city = $_GET['l'];
        $work = $_GET['w'];

        $searchJobData = $this->job_model->searchJobData($keyword, $city, $work);
        echo json_encode($searchJobData);
    }

    public function job_category_slug() {
        $contition_array = array();
        $jobCatData = $this->common->select_data_by_condition('job_industry', $contition_array, $data = 'industry_id,industry_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');

        foreach ($jobCatData as $k => $v) {
            $data = array('industry_slug' => strtolower($this->common->clean($v['industry_name'])));
            $insert_id = $this->common->update_data($data, 'job_industry', 'industry_id', $v['industry_id']);
        }
        echo "yes";
    }

}
