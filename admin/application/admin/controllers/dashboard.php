<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends MY_Controller {
  
    public $data;

    public function __construct() {
 
      parent::__construct();

        if (!$this->session->userdata('aileen_admin')) 
        {
            redirect('login', 'refresh');
        }
        
        // Get Site Information
        $this->data['title'] = 'Dashboard | Aileensoul';
        $this->data['section_title'] = 'Dashboard';

        include('include.php');


    }
 public function index()
     {
        $adminid =  $this->session->userdata('aileen_admin');
     
        //For Count Job Register User Data
        $condition_array = array('is_delete' => '0','job_step'=>'10');
        $data="job_id";
        $this->data['job_list'] = $get_users = $this->common->select_data_by_condition('job_reg', $condition_array, $data, $short_by, $order_by, $limit, $offset, $join_str = array());

        //For Count Recruiter Register User Data
        $condition_array = array('is_delete' => '0','re_step' =>'3');
        $data="rec_id";
        $this->data['recruiter_list'] = $get_users = $this->common->select_data_by_condition('recruiter', $condition_array, $data, $short_by, $order_by, $limit, $offset, $join_str = array());
        
        //For count User Data
        $condition_array = array('is_delete' => '0');
        $data="user.user_id";
        $join_str[0]['table'] = 'user_login ul';
        $join_str[0]['join_table_id'] = 'ul.user_id';
        $join_str[0]['from_table_id'] = 'user.user_id';
        $join_str[0]['join_type'] = '';
        $this->data['user_list'] = $get_users = $this->common->select_data_by_condition('user', $condition_array, $data, $short_by, $order_by, $limit, $offset, $join_str);
        
        //For Count Freelancer hire Register User Data
        $condition_array = array('is_delete' => '0','free_hire_step' =>'3');
        $data="reg_id";
        $this->data['freelancer_hire_list'] = $get_users = $this->common->select_data_by_condition('freelancer_hire_reg', $condition_array, $data, $short_by, $order_by, $limit, $offset, $join_str = array());

        
        // For pages Data
        $data="page_id";
        $this->data['pages_list'] = $get_users = $this->common->select_data_by_condition('ailee_pages', $condition_array=array(), $data, $short_by, $order_by, $limit, $offset, $join_str = array());
       
        //For Count Freelancer apply Register User Data
        $condition_array = array('is_delete' => '0','free_post_step'=>'7');
        $data="freelancer_post_reg_id";
        $this->data['freelancer_apply_list'] = $get_users = $this->common->select_data_by_condition('freelancer_post_reg', $condition_array, $data, $short_by, $order_by, $limit, $offset, $join_str = array());

        //For Count Business Register User Data
        $condition_array = array('is_deleted' => '0','business_step' => '4');
        $data="business_profile_id";
        $this->data['business_list'] = $get_users = $this->common->select_data_by_condition('business_profile', $condition_array, $data, $short_by, $order_by, $limit, $offset, $join_str = array());
        
        //For Count Artistic Register User Data
        $condition_array = array('is_delete' => '0','art_step' =>'4');
        $data="art_id";
        $this->data['artistic_list'] = $get_users = $this->common->select_data_by_condition('art_reg', $condition_array, $data, $short_by, $order_by, $limit, $offset, $join_str = array());


        $date = date('Y-m-d');

        $contition_array = array('insert_date' => $date);
        $user_visit = $this->common->select_data_by_condition('user_visit', $contition_array, $data = 'id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $this->data['count_visit'] = count($user_visit);
        
        
        $this->load->view('dashboard/index',$this->data);


        // print_r($this->data['art_list']);die();
    }

    //logout user
    public function logout() {

        
        // $this->session->set_userdata('aileen_admin', $admin_check[0]['admin_id']);

        if ($this->session->userdata('aileen_admin')) {
            

            $this->session->unset_userdata('aileen_admin');

            redirect('login', 'refresh');
        }
    }

    
    

    public function change_password() {

 
        if($this->input->post('old_pass')){
            
            $user_id = ($this->session->userdata('dollarbid_admin'));
            $old_password=$this->input->post('old_pass');
            $new_password=  $this->input->post('new_pass');
          
            $admin_old_password = $this->common->select_data_by_id('admin','admin_id',1,'admin_password');
            $admin_password = $admin_old_password[0]['admin_password'];

            if($admin_password == md5($old_password)){
                $update_array=array('admin_password'=> md5($new_password));
                $update_result=  $this->common->update_data($update_array,'admin','admin_id',1);
                if($update_result){
                    $this->session->set_flashdata('success','Your password is successfully changed.');
                    redirect('dashboard/change_password','refresh');
                }
                else{
                    $this->session->set_flashdata('error','Error Occurred. Try Again!');
                    redirect('dashboard/change_password','refresh');
                }
            }
            else{
                $this->session->set_flashdata('error','Old password does not match');
                redirect('dashboard/change_password','refresh');
            }
        }
        
        $this->data['module_name'] = 'Dashboard';
        $this->data['section_title'] = 'Change Password';
        $this->load->view('dashboard/change_password', $this->data);
    }

    
    //check old password
    public function check_old_pass() {
        if ($this->input->is_ajax_request() && $this->input->post('old_pass')) {
            $user_id = ($this->session->userdata('dollarbid_admin'));

            $old_pass = $this->input->post('old_pass');
            $check_result = $this->common->select_data_by_id('user','user_id',$user_id,'password');
            if ($check_result[0]['password'] === md5($old_pass)) {
                echo 'true';
                die();
            } else {
                echo 'false';
                die();
            }
        }
    }
    
}

?>