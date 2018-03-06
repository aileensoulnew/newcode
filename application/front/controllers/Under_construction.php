<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Under_construction extends CI_Controller {

   

    public function __construct() 
    {
        parent::__construct();
        //AWS access info start
        $this->load->library('S3');
        //AWS access info end
        include ('include.php'); 
    }
        
    public function index()
    { 
        $this->load->view('under_construction/index', $this->data);
     
    }

  }