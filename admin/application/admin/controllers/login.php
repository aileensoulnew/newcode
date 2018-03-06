<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public $data;

    public function __construct()
     {
        parent::__construct();
        $this->load->model('logins');
  
    }

    public function index() 
    { 

        $this->load->view('Login/index');
    }

    public function authenticate() {  
        $admin_email = $this->input->post('admin_email');
         $admin_password = $this->input->post('admin_password');

        if ($admin_email != '' && $admin_password != '') 
        {
            $admin_check = $this->logins->check_authentication($admin_email, $admin_password);
        
            if (count($admin_check) > 0 && $admin_check != 0) 
            {
                $this->session->set_userdata('aileen_admin', $admin_check[0]['admin_id']);
                
                redirect('dashboard', 'refresh');
            
            } 
            else
             {
                $this->session->set_flashdata('error', '<div class="alert alert-danger">Please Enter Valid Credential.</div>');
                redirect('login', 'refresh');
            }
        } 
        else 
        {
            $this->session->set_flashdata('error', '<div class="alert alert-danger">Please Enter Valid Login Detail.</div>');
            redirect('login', 'refresh');
        }
    }

}

// /* End of file login.php */
// /* Location: ./application/controllers/login.php */