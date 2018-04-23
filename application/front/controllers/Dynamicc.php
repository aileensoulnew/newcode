<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Dynamicc extends MY_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
         $this->load->library('form_validation');
// if ($this->session->userdata('aileensoul_front') == '') {
//             redirect('login', 'refresh');
//         }
         //AWS access info start
        $this->load->library('S3');
        //AWS access info end
        
        include ('include.php');
        include ('test_include.php');
    }
    
    public function index(){
    
        $this->load->view('dynamic/dy_basic',$this->data);
    }
    
    public function contact_dynamic(){
       
        $this->load->view('dynamic/dy_contact',$this->data);
    }
    
     public function dynamic(){
    
        $this->load->view('dynamic/dy_basic',$this->data);
    }
}


