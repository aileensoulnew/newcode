<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Job_profile extends MY_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
         $this->load->library('form_validation');
        //AWS access info start
        $this->load->library('S3');
        //AWS access info end
        $this->load->model('user_model');
        include ('include.php');
    }

    public function index() { 
      
       $contition_array = array('status' => 1);
      $this->data['countries'] =  $this->common->select_data_by_condition('countries', $contition_array, $data = '*', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
      
        $this->load->view('job_profile/index', $this->data);
    }

     public function ajax_data() { 
    
       if(isset($_POST["country_id"]) && !empty($_POST["country_id"])){ 
    //Get all state data
       	 $contition_array = array('country_id' => $_POST["country_id"] , 'status' => '1');
     $state =  $this->data['states'] =  $this->common->select_data_by_condition('states', $contition_array, $data = '*', $sortby = 'state_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
   
    //Count total number of rows
   
    
    //Display states list
    if(count($state) > 0){
        echo '<option value="">Select state</option>';
     foreach($state as $st){
            echo '<option value="'.$st['state_id'].'">'.$st['state_name'].'</option>';
     
        }
    }else{
        echo '<option value="">State not available</option>';
    }
}

if(isset($_POST["state_id"]) && !empty($_POST["state_id"])){
    //Get all city data
     $contition_array = array('state_id' => $_POST["state_id"] , 'status' => 1);
     $city =  $this->data['city'] =  $this->common->select_data_by_condition('cities', $contition_array, $data = '*', $sortby = 'city_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
    
    
    //Display cities list
    if(count($city) > 0){
        echo '<option value="">Select city</option>';
        foreach($city as $cit){
            echo '<option value="'.$cit['city_id'].'">'.$cit['city_name'].'</option>';
        }
    }else{
        echo '<option value="">City not available</option>';
    }
    }


}

}