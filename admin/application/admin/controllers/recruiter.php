<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Recruiter extends CI_Controller {

    public $data;

public function __construct()
{

        parent::__construct();

        if (!$this->session->userdata('aileen_admin')) 
        {
            redirect('login', 'refresh');
        }
   
        // Get Site Information
        $this->data['title'] = 'Recruiter Management | Aileensoul';
        $this->data['module_name'] = 'Recruiter Management';

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

            $sortby = 'rec_id';

            $orderby = 'desc';

        }
  
        $this->data['offset'] = $offset;

       $data='rec_id,rec_firstname,rec_lastname,rec_email,rec_phone,re_comp_country,re_comp_state,re_comp_city,re_status,created_date,modify_date,recruiter_user_image';
       $contition_array = array('is_delete' => '0');
        $this->data['users'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str = array(), $groupby = '');
// This is userd for pagination offset and limoi End

      //echo "<pre>";print_r($this->data['users'] );die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['base_url'] = site_url("recruiter/user/" . $short_by . "/" . $order_by);

        } else {

            $this->paging['base_url'] = site_url("recruiter/user/");

        }

        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['uri_segment'] = 5;

        } else {

            $this->paging['uri_segment'] = 3;

        }
        //This if and else use for asc and desc while click on any field End


        $contition_array = array( 'is_delete =' => '0');
        $this->paging['total_rows'] = count($this->common->select_data_by_condition('recruiter', $contition_array, 'rec_id'));

        $this->data['total_rows'] = $this->paging['total_rows'];

        $this->data['limit'] = $limit;

        $this->pagination->initialize($this->paging);

        $this->data['search_keyword'] = '';


        $this->load->view('recruiter/user', $this->data);
}
//for list of all user End

//deactivate user with ajax Start
public function deactive_user() 
{
     $rec_id = $_POST['rec_id'];
      $data = array(
            're_status' => 0
        );

        $update = $this->common->update_data($data, 'recruiter', 'rec_id', $rec_id);

         $select = '<td id= "active(' . $rec_id . ')">';
         $select .= '<button class="btn btn-block btn-success btn-sm"    onClick="active_user(' .  $rec_id . ')">
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
     $rec_id = $_POST['rec_id'];
      $data = array(
            're_status' => 1
        );

        $update = $this->common->update_data($data, 'recruiter', 'rec_id', $rec_id);

        $select = '<td id= "active(' . $rec_id . ')">';
        $select = '<button class="btn btn-block btn-primary btn-sm"   onClick="deactive_user(' .  $rec_id . ')">
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
     $rec_id = $_POST['rec_id'];
      $data = array(
            'is_delete' => 1
        );

        $update = $this->common->update_data($data, 'recruiter', 'rec_id', $rec_id);
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

            $sortby = 'rec_id';

            $orderby = 'asc';

        }
  
        $this->data['offset'] = $offset;
        
         $data='rec_id,rec_firstname,rec_lastname,rec_email,rec_phone,re_comp_country,re_comp_state,re_comp_city,re_status,created_date,modify_date,recruiter_user_image';
           $search_condition = "(rec_firstname LIKE '%$search_keyword%' OR rec_email LIKE '%$search_keyword%')";
            $contition_array = array('is_delete' => '0');
            $this->data['users'] = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array,$data, $sortby, $orderby, $limit, $offset);
 
// This is userd for pagination offset and limoi End


        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['base_url'] = site_url("recruiter/search/" . $sortby . "/" . $orderby);

            } else {

                $this->paging['base_url'] = site_url("recruiter/search/");

            }



            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['uri_segment'] = 5;

            } else {

                $this->paging['uri_segment'] = 3;

            }

            $this->paging['total_rows'] = count($this->common->select_data_by_search('recruiter', $search_condition, $contition_array, 'rec_id'));

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

            $sortby = 'rec_id';

            $orderby = 'asc';

        }
  
        $this->data['offset'] = $offset;

         $data='rec_id,rec_firstname,rec_lastname,rec_email,rec_phone,re_comp_country,re_comp_state,re_comp_city,re_status,created_date,modify_date,recruiter_user_image';
           $search_condition = "(rec_firstname LIKE '%$search_keyword%' OR rec_email LIKE '%$search_keyword%')";
            $contition_array = array('is_delete' => '0');
            $this->data['users'] = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array,$data, $sortby, $orderby, $limit, $offset);
        
// This is userd for pagination offset and limoi End

       // echo "<pre>";print_r($this->userdata['users'] );die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['base_url'] = site_url("recruiter/search/" . $sortby . "/" . $orderby);

            } else {

                $this->paging['base_url'] = site_url("recruiter/search/");

            }



            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['uri_segment'] = 5;

            } else {

                $this->paging['uri_segment'] = 3;

            }

            $this->paging['total_rows'] = count($this->common->select_data_by_search('recruiter', $search_condition, $contition_array, 'rec_id'));

            //for record display

            $this->data['total_rows'] = $this->paging['total_rows'];

            $this->data['limit'] = $limit;

            $this->pagination->initialize($this->paging);
    }

        $this->load->view('recruiter/user', $this->data);
}

//clear search is used for unset session start
public function clear_search() 
{ 
  
    if ($this->session->userdata('user_search_keyword')) 
    {
          
            $this->session->unset_userdata('user_search_keyword');
              
             redirect('recruiter/user','refresh');          
    } 
}
//clear search is used for unset session End

//view function is used for view profile of user Start
public function profile($id) 
{
    $userid = $this->db->get_where('recruiter', array('rec_id' => $id))->row()->user_id;

    //FOR GETTING ALL DATA OF JOB_REG
     $contition_array = array('rec_id' => $id, 'is_delete' => '0');           
    $this->data['user'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

    $this->load->view('recruiter/profile',$this->data);
}
//view function is used for view profile of user End

//for list of all user post start
public function post() 
{
   
// This is userd for pagination offset and limoi start
          $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $sortby = $this->uri->segment(3);

            $orderby = $this->uri->segment(4);

        } else {

            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

            $sortby = 'post_id';

            $orderby = 'desc';

        }
  
        $this->data['offset'] = $offset;

        $join_str[0]['table'] = 'recruiter';
        $join_str[0]['join_table_id'] = 'recruiter.user_id';
        $join_str[0]['from_table_id'] = 'rec_post.user_id';
        $join_str[0]['join_type'] = '';

        $data='recruiter.rec_firstname,recruiter.rec_lastname,rec_post.post_id,rec_post.post_name,rec_post.min_year,rec_post.max_year,rec_post.fresher,rec_post.country,rec_post.state,rec_post.city,rec_post.status,rec_post.created_date,rec_post.modify_date';
       
       $contition_array = array('rec_post.is_delete' => '0');

       $this->data['users'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str, $groupby = '');
// This is userd for pagination offset and limoi End
   
        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['base_url'] = site_url("recruiter/post/" . $short_by . "/" . $order_by);

        } else {

            $this->paging['base_url'] = site_url("recruiter/post/");

        }

        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['uri_segment'] = 5;

        } else {

            $this->paging['uri_segment'] = 3;

        }
        //This if and else use for asc and desc while click on any field End


        $contition_array = array( 'is_delete =' => '0');
        $this->paging['total_rows'] = count($this->common->select_data_by_condition('rec_post', $contition_array, 'post_id'));

        $this->data['total_rows'] = $this->paging['total_rows'];

        $this->data['limit'] = $limit;

        $this->pagination->initialize($this->paging);

        $this->data['search_keyword'] = '';


        $this->load->view('recruiter/post', $this->data);
}
//for list of all user post End

//deactivate Recruiter Post with ajax Start
public function deactive_post() 
{
     $post_id = $_POST['post_id'];
      $data = array(
            'status' => 0
        );

        $update = $this->common->update_data($data, 'rec_post', 'post_id', $post_id);

         $select = '<td id= "active(' . $post_id . ')">';
         $select .= '<button class="btn btn-block btn-success btn-sm"    onClick="active_post(' .  $post_id . ')">
                              Deactive
                      </button>';
        $select .= '</td>';

        echo $select;
         die();
}
//deactivate Recruiter Post with ajax End

//activate Recruiter Post with ajax Start
public function active_post() 
{
     $post_id = $_POST['post_id'];
      $data = array(
            'status' => 1
        );

        $update = $this->common->update_data($data, 'rec_post', 'post_id', $post_id);

        $select = '<td id= "active(' . $post_id . ')">';
        $select = '<button class="btn btn-block btn-primary btn-sm"   onClick="deactive_post(' .  $post_id . ')">
                              Active
                      </button>';
        $select .= '</td>';

        echo $select;

        die();
}
//activate Recruiter Post with ajax End

//Delete Recruiter Post with ajax Start
public function delete_post() 
{
     $post_id = $_POST['post_id'];
      $data = array(
            'is_delete' => 1
        );

        $update = $this->common->update_data($data, 'rec_post', 'post_id', $post_id);
        die();
}
//Delete Recruiter Post with ajax End

//Search Recruiter post Start
public function search_post() 
{ 

      if ($this->input->post('search_keyword')) {
//echo "jj";die();
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

            $sortby = 'post_id';

            $orderby = 'asc';

        }
  
        $this->data['offset'] = $offset;

        $join_str[0]['table'] = 'recruiter';
        $join_str[0]['join_table_id'] = 'recruiter.user_id';
        $join_str[0]['from_table_id'] = 'rec_post.user_id';
        $join_str[0]['join_type'] = '';

      $data='recruiter.rec_firstname,recruiter.rec_lastname,rec_post.post_id,rec_post.post_name,rec_post.min_month,rec_post.min_year,rec_post.max_month,rec_post.max_year,rec_post.fresher,rec_post.country,rec_post.state,rec_post.city,rec_post.status,rec_post.created_date,rec_post.modify_date';
       
        $contition_array = array('rec_post.is_delete' => '0');
       $search_condition = "(rec_firstname LIKE '%$search_keyword%' OR post_name LIKE '%$search_keyword%')";

        $this->data['users'] = $this->common->select_data_by_search('rec_post', $search_condition, $contition_array,$data, $sortby , $orderby , $limit , $offset , $join_str, $groupby);
 //echo '<pre>'; print_r($this->data['users']); die();
// This is userd for pagination offset and limoi End


        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['base_url'] = site_url("recruiter/search_post/" . $sortby . "/" . $orderby);

            } else {

                $this->paging['base_url'] = site_url("recruiter/search_post/");

            }



            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['uri_segment'] = 5;

            } else {

                $this->paging['uri_segment'] = 3;

            }

            $this->paging['total_rows'] = count($this->data['users']);

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

            $sortby = 'post_id';

            $orderby = 'asc';

        }
  
        $this->data['offset'] = $offset;

        $join_str[0]['table'] = 'recruiter';
        $join_str[0]['join_table_id'] = 'recruiter.user_id';
        $join_str[0]['from_table_id'] = 'rec_post.user_id';
        $join_str[0]['join_type'] = '';

      $data='recruiter.rec_firstname,recruiter.rec_lastname,rec_post.post_id,rec_post.post_name,rec_post.min_month,rec_post.min_year,rec_post.max_month,rec_post.max_year,rec_post.fresher,rec_post.country,rec_post.state,rec_post.city,rec_post.status,rec_post.created_date,rec_post.modify_date';
       
         $contition_array = array('rec_post.is_delete' => '0');
       $search_condition = "(rec_firstname LIKE '%$search_keyword%' OR post_name LIKE '%$search_keyword%')";

        $this->data['users'] = $this->common->select_data_by_search('rec_post', $search_condition, $contition_array,$data, $sortby , $orderby , $limit , $offset , $join_str, $groupby);
      
// This is userd for pagination offset and limoi End

       // echo "<pre>";print_r($this->userdata['users'] );die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['base_url'] = site_url("recruiter/search_post/" . $sortby . "/" . $orderby);

            } else {

                $this->paging['base_url'] = site_url("recruiter/search_post/");

            }



            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['uri_segment'] = 5;

            } else {

                $this->paging['uri_segment'] = 3;

            }

             $this->paging['total_rows'] = count($this->data['users']);

            //for record display

            $this->data['total_rows'] = $this->paging['total_rows'];

            $this->data['limit'] = $limit;

            $this->pagination->initialize($this->paging);
    }
      $this->load->view('recruiter/post', $this->data);
}

//Search Recruiter post End

//clear search POST is used for unset session start
public function clear_search_post() 
{ 
  
    if ($this->session->userdata('user_search_keyword')) 
    {
          
            $this->session->unset_userdata('user_search_keyword');
              
             redirect('recruiter/post','refresh');          
    } 
}
//clear search POST is used for unset session End

public function post_profile($id=''){
    //echo "fff";die();
   // $data='reg_id,username ,fullname ,email ,skyupid ,phone,country,state,city,pincode,professional_info,freelancer_hire_user_image'; 
    $contition_array = array('is_delete' => '0','post_id' => $id,'status'=>'1');
     $post_data=$this->data['post_data'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data='*', $sortby, $orderby, $limit, $offset, $join_str, $groupby);
     
     $contition_array = array('type' => '1','status'=>'1');
     $skill_data=$this->data['skill'] = $this->common->select_data_by_condition('skill', $contition_array, $data='*', $sortby, $orderby, $limit, $offset, $join_str, $groupby);
   // echo "<pre>";print_r($post_data);die();
    $this->load->view('recruiter/view_post', $this->data);
}

}

/* End of file recruiter.php 

/* Location: ./application/controllers/recruiter.php */