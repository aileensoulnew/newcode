<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Job extends CI_Controller {

    public $data;

public function __construct()
{
  
        parent::__construct();

        if (!$this->session->userdata('aileen_admin')) 
        {
           
            redirect('login', 'refresh');
        }
   
        // Get Site Information
        $this->data['title'] = 'Job Management | Aileensoul';
        $this->data['module_name'] = 'Job Management';

         //Loadin Pagination Custome Config File
         $this->config->load('paging', TRUE);
         $this->paging = $this->config->item('paging');
     
        include('include.php');

}

//for list of all user start
public function user() 
{
   
// This is userd for pagination offset and limoi start
          $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $sortby = $this->uri->segment(3);

            $orderby = $this->uri->segment(4);

        } else {

            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

            $sortby = 'job_id';

            $orderby = 'asc';

        }
  
        $this->data['offset'] = $offset;

       $data='job_id,fname,lname,email,phnno,gender,country_id,state_id,city_id,status,created_date,modified_date,job_user_image';
       $contition_array = array('is_delete' => '0');
        $this->data['users'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str = array(), $groupby = '');
// This is userd for pagination offset and limoi End

      //echo "<pre>";print_r($this->data['users'] );die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['base_url'] = site_url("job/user/" . $short_by . "/" . $order_by);

        } else {

            $this->paging['base_url'] = site_url("job/user/");

        }

        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['uri_segment'] = 5;

        } else {

            $this->paging['uri_segment'] = 3;

        }
        //This if and else use for asc and desc while click on any field End


        $contition_array = array( 'is_delete =' => '0');
        $this->paging['total_rows'] = count($this->common->select_data_by_condition('job_reg', $contition_array, 'job_id'));

        $this->data['total_rows'] = $this->paging['total_rows'];

        $this->data['limit'] = $limit;

        $this->pagination->initialize($this->paging);

        $this->data['search_keyword'] = '';


        $this->load->view('job/user', $this->data);
}
//for list of all user End

//deactivate user with ajax Start
public function deactive_user() 
{
     $job_id = $_POST['job_id'];
      $data = array(
            'status' => 0
        );

        $update = $this->common->update_data($data, 'job_reg', 'job_id', $job_id);

         $select = '<td id= "active(' . $job_id . ')">';
         $select .= '<button class="btn btn-block btn-success btn-sm"    onClick="active_user(' .  $job_id . ')">
                              Deactive
                      </button>';
        $select .= '</td>';

        echo $select;
         die();
}
//deactivate user with ajax End

//activate user with ajax Start
public function active_user() 
{
     $job_id = $_POST['job_id'];
      $data = array(
            'status' => 1
        );

        $update = $this->common->update_data($data, 'job_reg', 'job_id', $job_id);

        $select = '<td id= "active(' . $job_id . ')">';
        $select = '<button class="btn btn-block btn-primary btn-sm"   onClick="deactive_user(' .  $job_id . ')">
                              Active
                      </button>';
        $select .= '</td>';

        echo $select;

        die();
}
//activate user with ajax End

//Delete user with ajax Start
public function delete_user() 
{
     $job_id = $_POST['job_id'];
      $data = array(
            'is_delete' => 1
        );

        $update = $this->common->update_data($data, 'job_reg', 'job_id', $job_id);
        die();
}
//Delete user with ajax End

public function search() 
{ 

      if ($this->input->post('search_keyword')) {//echo "222"; die();

          $this->data['search_keyword'] = $search_keyword = trim($this->input->post('search_keyword'));

         $this->session->set_userdata('user_search_keyword', $search_keyword);
    
        $this->data['user_search_keyword'] = $this->session->userdata('user_search_keyword');
      
       
             // This is userd for pagination offset and limoi start
          $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $sortby = $this->uri->segment(3);

            $orderby = $this->uri->segment(4);

        } else {

            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

            $sortby = 'job_id';

            $orderby = 'asc';

        }
  
        $this->data['offset'] = $offset;
        
          $data='job_id,fname,lname,email,phnno,gender,country_id,state_id,city_id,status,created_date,modified_date,job_user_image';
           $search_condition = "(fname LIKE '%$search_keyword%' OR email LIKE '%$search_keyword%')";
            $contition_array = array('is_delete' => '0');
            $this->data['users'] = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array,$data, $sortby, $orderby, $limit, $offset);
 //echo "<pre>";print_r( $this->data['users']);die();
// This is userd for pagination offset and limoi End

       // echo "<pre>";print_r($this->userdata['users'] );die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['base_url'] = site_url("job/search/" . $sortby . "/" . $orderby);

            } else {

                $this->paging['base_url'] = site_url("job/search/");

            }



            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['uri_segment'] = 5;

            } else {

                $this->paging['uri_segment'] = 3;

            }

            $this->paging['total_rows'] = count($this->common->select_data_by_search('job_reg', $search_condition, $contition_array, 'job_id'));

            //for record display

            $this->data['total_rows'] = $this->paging['total_rows'];

            $this->data['limit'] = $limit;

            $this->pagination->initialize($this->paging);

    }
    else if ($this->session->userdata('user_search_keyword')) {//echo "jii"; die();
            $this->data['search_keyword'] = $search_keyword = trim($this->session->userdata('user_search_keyword'));

// echo "<pre>";print_r($search_keyword);die();
              // This is userd for pagination offset and limoi start
          $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $sortby = $this->uri->segment(3);

            $orderby = $this->uri->segment(4);

        } else {

            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

            $sortby = 'job_id';

            $orderby = 'asc';

        }
  
        $this->data['offset'] = $offset;
        
          $data='job_id,fname,lname,email,phnno,gender,country_id,state_id,city_id,status,created_date,modified_date,job_user_image';
           $search_condition = "(fname LIKE '%$search_keyword%' OR email LIKE '%$search_keyword%')";
            $contition_array = array('is_delete' => '0');
            $this->data['users'] = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array,$data, $sortby, $orderby, $limit, $offset);
 //echo "<pre>";print_r( $this->data['users']);die();
// This is userd for pagination offset and limoi End

       // echo "<pre>";print_r($this->userdata['users'] );die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['base_url'] = site_url("job/search/" . $sortby . "/" . $orderby);

            } else {

                $this->paging['base_url'] = site_url("job/search/");

            }



            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['uri_segment'] = 5;

            } else {

                $this->paging['uri_segment'] = 3;

            }

            $this->paging['total_rows'] = count($this->common->select_data_by_search('job_reg', $search_condition, $contition_array, 'job_id'));

            //for record display

            $this->data['total_rows'] = $this->paging['total_rows'];

            $this->data['limit'] = $limit;

            $this->pagination->initialize($this->paging);
    }

        $this->load->view('job/user', $this->data);
}

//clear search is used for unset session start
public function clear_search() 
{ 
  
    if ($this->session->userdata('user_search_keyword')) 
    {
          
            $this->session->unset_userdata('user_search_keyword');
              
             redirect('job/user','refresh');          
    } 
}
//clear search is used for unset session End

//view function is used for view profile of user Start
public function profile($id) 
{
  
    $userid = $this->db->get_where('job_reg', array('job_id' => $id))->row()->user_id;

    //FOR GETTING ALL DATA OF JOB_REG
     $contition_array = array('job_id' => $id, 'is_delete' => '0');           
    $this->data['user'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

    //FOR GETTING OTHER SKILL    
      $data="skill_id,skill";
      $contition_array = array('user_id' => $userid, 'type' => 3, 'status' => 1);
      $this->data['other_skill'] = $this->common->select_data_by_condition('skill', $contition_array,$data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

      //for getting data job_add_edu table
      $contition_array = array('user_id' => $userid, 'status' => '1');
      $data = '*';
      $this->data['job_edu'] = $this->common->select_data_by_condition('job_add_edu', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str, $groupby);

      //FOR GETTING DATA OF JOB GRADUATION TABLE
       $contition_array = array('user_id' => $userid);
       $data = '*';
       $this->data['job_graduation'] = $this->common->select_data_by_condition('job_graduation', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str, $groupby);

        //for getting data of job_add_workexp table
        $contition_array = array('user_id' => $userid, 'status' => '1');
        $data = '*';
        $this->data['job_work'] = $this->common->select_data_by_condition('job_add_workexp', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str, $groupby);
        

    $this->load->view('job/profile',$this->data);
}
//view function is used for view profile of user End


}

/* End of file job.php 

/* Location: ./application/controllers/job.php */