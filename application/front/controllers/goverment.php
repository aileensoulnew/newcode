<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Goverment extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->model('email_model');
        $this->data['title'] = "Aileensoul";
        $this->load->helper('smiley');
        $this->data['login_header'] = $this->load->view('login_header', $this->data,TRUE);
        $this->load->library('S3');

        include ('include.php');
    }

    public function postdetails($id) { 
        $userid = $this->session->userdata('aileenuser');


        $contition_array = array('status' => '1', 'is_delete' => '0');
         $this->data['govjob_category'] = $govjob_category = $this->common->select_data_by_condition('gov_category', $contition_array, $data = 'id,name,image', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('id' => $id, 'status' => '1', 'is_delete' => '0');
         $this->data['govjob_post'] = $govjob_post = $this->common->select_data_by_condition('gov_post', $contition_array, $data = 'id,title,category_id,post_name,no_vacancies,pay_scale,job_location,req_exp,post_image,sector,eligibility,last_date,description,apply_link,created_date', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        $this->load->view('goverment/gov_post_details', $this->data);     
    }

    public function allpost() { 
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('status' => '1', 'is_delete' => '0');
         $this->data['govjob_category'] = $govjob_category = $this->common->select_data_by_condition('gov_category', $contition_array, $data = 'id,name,image', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->load->view('goverment/gov_all_post', $this->data);     
    }

    public function allpostdetail($id) { 
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('status' => '1', 'is_delete' => '0');
         $this->data['govjob_category'] = $govjob_category = $this->common->select_data_by_condition('gov_category', $contition_array, $data = 'id,name,image', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

         $contition_array = array('category_id' => $id, 'status' => '1', 'is_delete' => '0');
         $this->data['govjob_post'] = $govjob_post = $this->common->select_data_by_condition('gov_post', $contition_array, $data = 'id,title,category_id,post_name,no_vacancies,pay_scale,job_location,req_exp,post_image,sector,eligibility,last_date,description,apply_link,created_date', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $this->load->view('goverment/gov_all_post_detail', $this->data);     
    }
    
    public function user_slug() { 
               $this->db->select('user_id,first_name,last_name');
         $res = $this->db->get('user')->result();
         foreach ($res as $k => $v) {
             $data = array('user_slug' => $this->setuser_slug($v->first_name."-". $v->last_name, 'user_slug', 'user'));
             $this->db->where('user_id', $v->user_id);
             $this->db->update('user', $data);
          }
          
          
    }
    
    // CREATE SLUG START
    public function setuser_slug($slugname, $filedname, $tablename, $notin_id = array()) {
        $slugname = $oldslugname = $this->create_slug($slugname);
        $i = 1;
        while ($this->compareuser_slug($slugname, $filedname, $tablename, $notin_id) > 0) {
            $slugname = $oldslugname . '-' . $i;
            $i++;
        }return $slugname;
    }

    public function compareuser_slug($slugname, $filedname, $tablename, $notin_id = array()) {
        $this->db->where($filedname, $slugname);
        if (isset($notin_id) && $notin_id != "" && count($notin_id) > 0 && !empty($notin_id)) {
            $this->db->where($notin_id);
        }
        $num_rows = $this->db->count_all_results($tablename);
        return $num_rows;
    }

    public function create_slug($string) {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower(stripslashes($string)));
        $slug = preg_replace('/[-]+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }
    
}