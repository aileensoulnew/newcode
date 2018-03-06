<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
      
        if (!$this->session->userdata('aileen_admin')) {
            redirect('login', 'refresh');
        } else {
            $this->data['admin_id'] = $this->session->userdata('aileen_admin');
             // redirect('admin/dashboard', 'refresh');
        }

        
        $admin_id=$this->data['admin_id'];

        // echo  $admin_id; die();
        $condition_array=array('status' => 1);

        $this->data['loged_in_user']=$this->common->select_data_by_id('ailee_admin','admin_id',$admin_id,'admin_name','admin_image',$condition_array);
        
        
    }


}
