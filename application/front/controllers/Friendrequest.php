<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Friendrequest extends MY_Controller {

    public $data;

    
    public function __construct() 
    {
        parent::__construct(); 
        //AWS access info start
        $this->load->library('S3');
        //AWS access info end
        // if ($this->session->userdata('aileensoul_front') == '') {
        //     redirect('login', 'refresh');
        // }   
        include ('include.php');
        
    }

    //notification & friend request page start
    public function index()
    {
            $userid  = $this->session->userdata('aileenuser');
            //echo $userid; die();
            //$contition_array = array('user_id' => $userid, 'is_delete' => 0, 'status' => 1);
           $contition_array = array('is_delete' => '0','status' => '1');
              //echo $contition_array; die();

            $this->data['friend'] = $this->common->select_data_by_condition('user', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

          

         // echo "<pre>";print_r($this->data['friend']);echo "</pre>";exit;

               $this->load->view('friendrequest/index',$this->data);
          

           
               //$this->load->view('job/index',$this->jobdata);
            

           //$this->load->view('job/index'); 
            
    }
     //notification & friend request page End


     //friend request send with add button from friend request page start
    public function friendrequest_addfriend_insert($id) 
     { 
   
        //echo $id;
       //die();
        $userid = $this->session->userdata('aileenuser');
        
         // echo "<pre>";print_r($this->data['friend']);echo "</pre>";exit;

           
        //echo $userid; die();
        
            $data_notification = array(
                 
                 'not_type' => 1,
                 'not_from_id' => $userid,
                 'not_to_id' => $id,
                 'not_read' => 2
                 
        ); 
          //echo "<pre>"; print_r($data_notification);
            $insert_id_notification=   $this->common->insert_data_getid($data_notification,'notification'); 


      $data_relation = array(
      'relation_from_id'   => $userid,
      'relation_to_id'      => $id,
      'relation_create_date' =>date('Y-m-d h:i:s',time()),
      'relation_status' => 2
    );    
           //echo "<pre>"; print_r($data_relation); die();

    
       //for update data if user cancel request and then again click on add friend button start
       $search_condition = "(relation_from_id = " . $userid. " AND relation_to_id = " .  $id . " ) ";
        
        $friend_id = $this->common->select_data_by_search('relation', $search_condition, $contition_array = array(), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array());
         //for update data if user cancel request and then again click on add friend button End


      //echo "<pre>"; print_r($friend_id);die();

      //For check first time relation_status is null or not .. if null then insert otherwise update
      if($friend_id[0]['relation_status']=='')
      {
        
          $insert_id_relation=   $this->common->insert_data_getid($data_relation,'relation'); 
      }
      else
      {
          $updatedata_relation =   $this->common->update_data($data_relation,'relation','relation_id',$friend_id[0]['relation_id']);
      }
   
      //for redirect page
        if( $insert_id_notification && $insert_id_relation)
        { 
              //redirect('Friendrequest/index',$this->data);

               redirect('friendrequest/index', 'refresh');
          
        }
        elseif ($insert_id_notification &&  $updatedata_relation)
        { 
              //redirect('Friendrequest/index',$this->data);

               redirect('friendrequest/index', 'refresh');
          
        }
       else
        {
                $this->session->flashdata('error','Sorry!! Your data not inserted');
               redirect('friendrequest/index', 'refresh', $this->data);
        }
      
      
    }
    //friend request send with add button from friend request page end

     //friend request confirm with confirm button from dashboard page start
    public function friendrequest_confirm_insert($id) 
     { 
   
     // echo $id;
       //die();
        $userid = $this->session->userdata('aileenuser');
        
         // echo "<pre>";print_r($this->data['friend']);echo "</pre>";exit;

           
        //echo $userid; die();
        
            $data_notification = array(
                 
                 'not_type' => 1,
                 'not_from_id' => $userid,
                 'not_to_id' => $id,
                 'not_read' => 2
                
        ); 
           //echo "<pre>"; print_r($data_notification);exit;
          $insert_id_notification=  $this->common->insert_data_getid($data_notification,'notification'); 

        $data_relation = array(
      'relation_status' => 1
    );    
          
        //second method to retrieve all data from table start
       $search_condition = "(relation_to_id = " . $userid. " AND relation_from_id = " .  $id . " ) ";
        
        $friend_id = $this->common->select_data_by_search('relation', $search_condition, $contition_array = array(), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array());
      //echo "<pre>"; print_r($friend_id[0]['relation_id']);
         //second method to retrieve all data from table end

         
           $updatedata_relation =   $this->common->update_data($data_relation,'relation','relation_id',$friend_id[0]['relation_id']);

 //echo "<pre>"; print_r($this->data['friend']); die();

        if( $insert_id_notification && $updatedata_relation)
        { 
              //redirect('Friendrequest/index',$this->data);

               redirect('friendrequest/index', 'refresh');
          
        }
       else
        {
                $this->session->flashdata('error','Sorry!! Your data not inserted');
               redirect('friendrequest/index', 'refresh', $this->data);
        }
      
      
    }
    //friend request confirm with confirm button from dashboard page end

     //friend request delete with delete button from dashboard page start
    public function friendrequest_delete_insert($id) 
     { 
   
       // echo $id;
       // die();
        $userid = $this->session->userdata('aileenuser');
        
         // echo "<pre>";print_r($this->data['friend']);echo "</pre>";exit;

           
        //echo $userid; die();
        
        $data_relation = array(
      'relation_status' => 3
    );    
         // echo "<pre>"; print_r($data_relation); die();

         //second method to retrieve all data from table start
       $search_condition = "(relation_to_id = " . $userid. " AND relation_from_id = " .  $id . " ) ";
        
        $friend_id = $this->common->select_data_by_search('relation', $search_condition, $contition_array = array(), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array());
      //echo "<pre>"; print_r($friend_id[0]['relation_id']);die();
         //second method to retrieve all data from table end
           
    
            $updatedata_relation =   $this->common->update_data($data_relation,'relation','relation_id',$friend_id[0]['relation_id']);

        if($updatedata_relation)
        { 
              //redirect('Friendrequest/index',$this->data);

               redirect('friendrequest/index', 'refresh');
          
        }
       else
        {
                $this->session->flashdata('error','Sorry!! Your data not inserted');
               redirect('friendrequest/index', 'refresh', $this->data);
        }
      
      
    }
    //friend request delete with delete button from dashboard page end

    //friend request cancel with cancel button from friend request page start
    public function friendrequest_cancel_update($id) 
     { 
   
       //echo $id;
       // die();
        $userid = $this->session->userdata('aileenuser');
        //echo $userid;die();
        
         // echo "<pre>";print_r($this->data['friend']);echo "</pre>";exit;

           
        //echo $userid; die();
        
        $data_relation = array(
      'relation_status' => 3
    );    
        //echo "<pre>"; print_r($data_relation); die();

         //second method to retrieve all data from table start
       $search_condition = "(relation_from_id = " . $userid. " AND relation_to_id = " .  $id . " ) ";
        
        $friend_id = $this->common->select_data_by_search('relation', $search_condition, $contition_array = array(), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array());
      //echo "<pre>"; print_r($friend_id);die();
         //second method to retrieve all data from table end
           
    
            $updatedata_relation =   $this->common->update_data($data_relation,'relation','relation_id',$friend_id[0]['relation_id']);

        if($updatedata_relation)
        { 
              //redirect('Friendrequest/index',$this->data);

               redirect('friendrequest/index', 'refresh');
          
        }
       else
        {
                $this->session->flashdata('error','Sorry!! Your data not inserted');
               redirect('friendrequest/index', 'refresh', $this->data);
        }
      
      
    }
    //friend request cancel with cancel button from friend request page end
  
}