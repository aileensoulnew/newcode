<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_table extends MY_Controller {

    public $data;

    public function __construct() {

        parent::__construct();
$this->load->library('S3');
        include('include.php');
    }

    public function index() {
        $contition_array = array();
        $users_data = $this->common->select_data_by_condition('user', $contition_array, $data = 'user_id,user_image,modified_date,edit_ip,profile_background,profile_background_main,user_email,user_password,is_delete,status,password_code', $sortby = '', $orderby = '', $limit = '1', $offset = '140000000000000000000000000', $join_str = array(), $groupby = '');
        foreach($users_data as $user){
            $insert_data['user_id'] = $user['user_id'];
            $insert_data['user_image'] = $user['user_image'];
            $insert_data['modify_date'] = $user['modified_date'];
            $insert_data['edit_ip'] = $user['edit_ip'];
            $insert_data['profile_background'] = $user['profile_background'];
            $insert_data['profile_background_main'] = $user['profile_background_main'];
            
            $insert_id = $this->common->insert_data_getid($insert_data, 'user_info');
            
            $insert_data1['user_id'] = $user['user_id'];
            $insert_data1['email'] = $user['user_email'];
            $insert_data1['password'] = $user['user_password'];
            $insert_data1['is_delete'] = $user['is_delete'];
            $insert_data1['status'] = $user['status'];
            $insert_data1['password_code'] = $user['password_code'];
            
            $insert_id = $this->common->insert_data_getid($insert_data1, 'user_login');
        }
    }
    
    public function message_timestamp() {
        $contition_array = array();
        $users_data = $this->common->select_data_by_condition('message', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        foreach($users_data as $user){
            $insert_data['user_id'] = $user['user_id'];
            $insert_data['user_image'] = $user['user_image'];
            $insert_data['modify_date'] = $user['modified_date'];
            $insert_data['edit_ip'] = $user['edit_ip'];
            $insert_data['profile_background'] = $user['profile_background'];
            $insert_data['profile_background_main'] = $user['profile_background_main'];
            
            $insert_id = $this->common->insert_data_getid($insert_data, 'user_info');
            
            $insert_data1['user_id'] = $user['user_id'];
            $insert_data1['email'] = $user['user_email'];
            $insert_data1['password'] = $user['user_password'];
            $insert_data1['is_delete'] = $user['is_delete'];
            $insert_data1['status'] = $user['status'];
            $insert_data1['password_code'] = $user['password_code'];
            
            $insert_id = $this->common->insert_data_getid($insert_data1, 'user_login');
        }
    }

}
