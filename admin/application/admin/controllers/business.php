<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Business extends CI_Controller {

    public $data;

public function __construct()
{
  
        parent::__construct();

        if (!$this->session->userdata('aileen_admin')) 
        {
           
            redirect('login', 'refresh');
        }
   
        // Get Site Information
        $this->data['title'] = 'Business Management | Aileensoul';
        $this->data['module_name'] = 'Business Management';

         //Loadin Pagination Custome Config File
         $this->config->load('paging', TRUE);
         $this->paging = $this->config->item('paging');
     
        include('include.php');

}

//for list of all user start
public function user() 
{
  
//This is userd for pagination offset and limoi start
          $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $sortby = $this->uri->segment(3);

            $orderby = $this->uri->segment(4);

        } else {

            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

            $sortby = 'business_profile_id';

            $orderby = 'desc';

        }
  
        $this->data['offset'] = $offset;

       $data='business_profile_id,contact_person,company_name,contact_email,country ,state,city,created_date,modified_date ,status,is_deleted';
       $contition_array = array('is_deleted' => '0');
        $this->data['users'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str = array(), $groupby = '');
// This is userd for pagination offset and limoi End


        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['base_url'] = site_url("business/user/" . $short_by . "/" . $order_by);

        } else {

            $this->paging['base_url'] = site_url("business/user/");

        }

        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['uri_segment'] = 5;

        } else {

            $this->paging['uri_segment'] = 3;

        }
        //This if and else use for asc and desc while click on any field End


        $contition_array = array( 'is_deleted =' => '0');
        $this->paging['total_rows'] = count($this->common->select_data_by_condition('business_profile', $contition_array, 'business_profile_id'));

        $this->data['total_rows'] = $this->paging['total_rows'];

        $this->data['limit'] = $limit;

        $this->pagination->initialize($this->paging);

        $this->data['search_keyword'] = '';


        $this->load->view('business/user',$this->data);
}
//for list of all user End

//deactivate user with ajax Start
public function deactive_user() 
{
     $business_profile_id = $_POST['business_profile_id'];
      $data = array(
            'status' => 0
        );

        $update = $this->common->update_data($data, 'business_profile', 'business_profile_id', $business_profile_id);

         $select = '<td id= "active(' . $business_profile_id . ')">';
         $select .= '<button class="btn btn-block btn-success btn-sm"    onClick="active_user(' .  $business_profile_id . ')">
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
     $business_profile_id = $_POST['business_profile_id'];
      $data = array(
            'status' => 1
        );

        $update = $this->common->update_data($data, 'business_profile', 'business_profile_id', $business_profile_id);

        $select = '<td id= "active(' . $business_profile_id . ')">';
        $select = '<button class="btn btn-block btn-primary btn-sm"   onClick="deactive_user(' .  $business_profile_id . ')">
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
     $business_profile_id = $_POST['business_profile_id'];
      $data = array(
            'is_deleted' => 1
        );

        $update = $this->common->update_data($data, 'business_profile', 'business_profile_id', $business_profile_id);
        die();
}
//Delete user with ajax End

public function search() 
{ 

      if ($this->input->post('search_keyword')) {

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

            $sortby = 'business_profile_id';

            $orderby = 'asc';

        }
  
        $this->data['offset'] = $offset;
        
          $data='business_profile_id,contact_person,company_name,contact_email,country ,state,city,business_profile_image,created_date,modified_date ,status,is_deleted';
           $search_condition = "(company_name LIKE '%$search_keyword%' OR contact_email LIKE '%$search_keyword%')";
            $contition_array = array('is_deleted' => '0');
            $this->data['users'] = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array,$data, $sortby, $orderby, $limit, $offset);
 
// This is userd for pagination offset and limoi End

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['base_url'] = site_url("business/search/" . $sortby . "/" . $orderby);

            } else {

                $this->paging['base_url'] = site_url("business/search/");

            }



            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['uri_segment'] = 5;

            } else {

                $this->paging['uri_segment'] = 3;

            }

            $this->paging['total_rows'] = count($this->common->select_data_by_search('business_profile', $search_condition, $contition_array, 'business_profile_id'));

            //for record display

            $this->data['total_rows'] = $this->paging['total_rows'];

            $this->data['limit'] = $limit;

            $this->pagination->initialize($this->paging);

    }
    else if ($this->session->userdata('user_search_keyword')) {
            $this->data['search_keyword'] = $search_keyword = trim($this->session->userdata('user_search_keyword'));

              // This is userd for pagination offset and limoi start
          $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $sortby = $this->uri->segment(3);

            $orderby = $this->uri->segment(4);

        } else {

            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

            $sortby = 'business_profile_id';

            $orderby = 'asc';

        }
  
        $this->data['offset'] = $offset;
        
           $data='business_profile_id,contact_person,company_name,contact_email,country ,state,city,business_profile_image,created_date,modified_date ,status,is_deleted';
           $search_condition = "(company_name LIKE '%$search_keyword%' OR contact_email LIKE '%$search_keyword%')";
            $contition_array = array('is_deleted' => '0');
            $this->data['users'] = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array,$data, $sortby, $orderby, $limit, $offset);
// This is userd for pagination offset and limoi End


        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['base_url'] = site_url("business/search/" . $sortby . "/" . $orderby);

            } else {

                $this->paging['base_url'] = site_url("business/search/");

            }



            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['uri_segment'] = 5;

            } else {

                $this->paging['uri_segment'] = 3;

            }

            $this->paging['total_rows'] = count($this->common->select_data_by_search('business_profile', $search_condition, $contition_array, 'business_profile_id'));

            //for record display

            $this->data['total_rows'] = $this->paging['total_rows'];

            $this->data['limit'] = $limit;

            $this->pagination->initialize($this->paging);
    }

        $this->load->view('business/user', $this->data);
}

//clear search is used for unset session start
public function clear_search() 
{ 
  
    if ($this->session->userdata('user_search_keyword')) 
    {
          
            $this->session->unset_userdata('user_search_keyword');
              
             redirect('business/user','refresh');          
    } 
}
//clear search is used for unset session End

//view function is used for view profile of user Start
public function profile($id) 
{
  
    $userid = $this->db->get_where('business_profile', array('business_profile_id' => $id))->row()->$user_id ;

    //FOR GETTING ALL DATA OF BUSINESS PROFILE
     $contition_array = array('business_profile_id' => $id, 'is_deleted' => '0');           
    $this->data['user'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = ''); 

    $this->load->view('business/profile',$this->data);
}
//view function is used for view profile of user End


}


/* End of file business.php 

/* Location: ./application/controllers/business.php */