<?php
// Inside application/controllers/MyCustom404Ctrl.php
class My404Page extends CI_Controller  {
    public function __construct() {
        parent::__construct();
        //AWS access info start
        $this->load->library('S3');
        //AWS access info end
        $this->load->library('form_validation');
        $this->load->model('email_model');

        include ('include.php');
    }
    public function index(){
        $this->output->set_status_header('404');
        // Make sure you actually have some view file named 404.php
        $this->load->view('404');
    }
}
