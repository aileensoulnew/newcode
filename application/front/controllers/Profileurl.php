<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Profileurl extends CI_Controller {

   

    public function __construct() 
    {
        parent::__construct();

         $this->load->library('form_validation');
         $this->load->model('email_model');
         //AWS access info start
        $this->load->library('S3');
        //AWS access info end
        include ('include.php');
    }

    public function user($userid = " ")
    { 
 

        if($userid != ''){
         $contition_array = array('business_slug' => $userid, 'status' => '1');
             $this->data['businessdata'] =  $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

           //  echo '<pre>'; print_r($this->data['businessdata']); die();
           }
           
         $this->load->view('business_profile/profilleurl', $this->data);
       }

    
             
    

}