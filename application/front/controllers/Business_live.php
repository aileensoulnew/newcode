<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Business_live extends MY_Controller {

    public $data;

    public function __construct() {

        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('user_agent');
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('user_post_model');
        $this->load->model('data_model');
        $this->load->model('business_model');
        $this->load->library('S3');
        
        include ('main_profile_link.php');
    }

    public function index() {

        if($this->businees_profile_set==1){
            return redirect($this->businees_profile_link); 
        }
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
       
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['business_profile_link'] =  ($this->business_profile_set == 1)?$this->business_profile_link:base_url('business-profile/registration/business-information');
       

        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['search_banner'] = $this->load->view('business_live/search_banner', $this->data, TRUE);
        $this->data['title'] = "Business Profile | Aileensoul";
        $this->load->view('business_live/index', $this->data);
    }

    public function category() {
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
        $this->data['search_banner'] = $this->load->view('business_live/search_banner', $this->data, TRUE);
        $this->data['title'] = "Categories - Business Profile | Aileensoul";
        $this->load->view('business_live/category', $this->data);
    }

    public function categoryBusinessList($category = '') {
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
        $this->data['title'] = "Category - Business Profile | Aileensoul";
        $this->data['search_banner'] = $this->load->view('business_live/search_banner', $this->data, TRUE);
        $category_id = $this->db->select('industry_id')->get_where('industry_type', array('industry_slug' => $category))->row_array('industry_id');
        $this->data['category_id'] = $category_id['industry_id'];
        $this->load->view('business_live/categoryBusinessList', $this->data);
    }

    public function business_search() {
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
        $this->data['search_banner'] = $this->load->view('business_live/search_banner', $this->data, TRUE);
        $category_id = $this->db->select('industry_id')->get_where('industry_type', array('industry_slug' => $category))->row_array('industry_id');
        $this->data['category_id'] = $category_id['industry_id'];
        $this->data['q'] = $_GET['q'];
        $this->data['l'] = $_GET['l'];
        $this->load->view('business_live/search', $this->data);
    }

    public function businessCategory() {
        $limit = $_GET['limit'];
        $businessCategory = $this->business_model->businessCategory($limit);
        echo json_encode($businessCategory);
    }

    public function businessAllCategory() {
        $businessAllCategory = $this->business_model->businessAllCategory();
        echo json_encode($businessAllCategory);
    }

    public function otherCategoryCount() {
        $otherCategoryCount = $this->business_model->otherCategoryCount();
        echo $otherCategoryCount;
    }

    public function businessListByCategory($id = '0') {
        $businessListByCategory = $this->business_model->businessListByCategory($id);
        echo json_encode($businessListByCategory);
    }

    public function searchBusinessData() {
        $keyword = $_GET['q'];
        $city = $_GET['l'];
        $searchBusinessData = $this->business_model->searchBusinessData($keyword,$city);
        echo json_encode($searchBusinessData);
    }

    public function industry_slug() {

        $contition_array = array('industry_id !=' => '0');
        $inddata = $this->common->select_data_by_condition('industry_type', $contition_array, $data = 'industry_id,industry_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');

        foreach ($inddata as $k => $v) {
            $data = array('industry_slug' => strtolower($this->common->clean($v['industry_name'])));
            $insert_id = $this->common->update_data($data, 'industry_type', 'industry_id', $v['industry_id']);
        }
        echo "yes";
    }

}
