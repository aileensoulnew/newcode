<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Contact_us extends CI_Controller {

    public $data;

public function __construct()
{
  
        parent::__construct();

        if (!$this->session->userdata('aileen_admin')) 
        {
           
            redirect('login', 'refresh');
        }
   
        // Get Site Information
        $this->data['title'] = 'Contact Us | Aileensoul';
        $this->data['module_name'] = 'Contact us Management';

         //Loadin Pagination Custome Config File
         $this->config->load('paging', TRUE);
         $this->paging = $this->config->item('paging');
     
        include('include.php');

}
    public function user() {

       // This is userd for pagination offset and limoi start
          $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $sortby = $this->uri->segment(3);

            $orderby = $this->uri->segment(4);

        } else {

            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

            $sortby = 'contact_id';

            $orderby = 'desc';

        }
  
        $this->data['offset'] = $offset;

       $data='contact_id,contact_name,contact_lastname,contact_email,contact_subject,contact_message,created_date';
       $contition_array = array('is_delete' => 0);
        $this->data['users'] = $this->common->select_data_by_condition('contact_us', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str = array(), $groupby = '');
// This is userd for pagination offset and limoi End

      //echo "<pre>";print_r($this->data['users'] );die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['base_url'] = site_url("contact_us/user" . $short_by . "/" . $order_by);

        } else {

            $this->paging['base_url'] = site_url("contact_us/user");

        }

        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['uri_segment'] = 5;

        } else {

            $this->paging['uri_segment'] = 3;

        }
        //This if and else use for asc and desc while click on any field End


        $contition_array = array( 'is_delete =' => '0');
        $this->paging['total_rows'] = count($this->common->select_data_by_condition('contact_us', $contition_array, 'contact_id'));

        $this->data['total_rows'] = $this->paging['total_rows'];

        $this->data['limit'] = $limit;

        $this->pagination->initialize($this->paging);

        $this->data['search_keyword'] = '';
        
        $this->load->view('contact_us/index', $this->data);
    }

//view function is used for view details of user Start
public function profile($id) 
{
  
    //FOR GETTING ALL DATA OF JOB_REG
     $contition_array = array('contact_id' => $id);           
    $this->data['user'] = $this->common->select_data_by_condition('contact_us', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

    $this->load->view('contact_us/profile',$this->data);
}
//view function is used for view profile of user End

//clear search is used for unset session start
public function clear_search() 
{ 
  
    if ($this->session->userdata('user_search_keyword')) 
    {
          
            $this->session->unset_userdata('user_search_keyword');
              
             redirect('contact_us/user','refresh');          
    } 
}
//clear search is used for unset session End


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

            $sortby = 'contact_id';

            $orderby = 'desc';

        }
  
        $this->data['offset'] = $offset;
        
          $data='contact_id,contact_name,contact_lastname,contact_email,contact_subject,contact_message,created_date,is_delete';
           $search_condition = "(contact_name LIKE '%$search_keyword%' OR contact_email LIKE '%$search_keyword%')";
            $contition_array = array('is_delete' => '0');
            $this->data['users'] = $this->common->select_data_by_search('contact_us', $search_condition, $contition_array,$data, $sortby, $orderby, $limit, $offset);
 //echo "<pre>";print_r( $this->data['users']);die();
// This is userd for pagination offset and limoi End

       // echo "<pre>";print_r($this->userdata['users'] );die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['base_url'] = site_url("contact_us/search/" . $sortby . "/" . $orderby);

            } else {

                $this->paging['base_url'] = site_url("contact_us/search/");

            }



            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['uri_segment'] = 5;

            } else {

                $this->paging['uri_segment'] = 3;

            }

            $this->paging['total_rows'] = count($this->common->select_data_by_search('contact_us', $search_condition, $contition_array, 'contact_id'));

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

            $sortby = 'contact_id';

            $orderby = 'desc';

        }
  
        $this->data['offset'] = $offset;
        
          $data='contact_id,contact_name,contact_lastname,contact_email,contact_subject,contact_message,created_date,is_delete';
           $search_condition = "(contact_name LIKE '%$search_keyword%' OR contact_email LIKE '%$search_keyword%')";
            $contition_array = array('is_delete' => '0');
            $this->data['users'] = $this->common->select_data_by_search('contact_us', $search_condition, $contition_array,$data, $sortby, $orderby, $limit, $offset);
 //echo "<pre>";print_r( $this->data['users']);die();
// This is userd for pagination offset and limoi End

       // echo "<pre>";print_r($this->userdata['users'] );die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['base_url'] = site_url("contact_us/search/" . $sortby . "/" . $orderby);

            } else {

                $this->paging['base_url'] = site_url("contact_us/search/");

            }



            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['uri_segment'] = 5;

            } else {

                $this->paging['uri_segment'] = 3;

            }

            $this->paging['total_rows'] = count($this->common->select_data_by_search('contact_us', $search_condition, $contition_array, 'contact_id'));

            //for record display

            $this->data['total_rows'] = $this->paging['total_rows'];

            $this->data['limit'] = $limit;

            $this->pagination->initialize($this->paging);
    }

        $this->load->view('contact_us/index', $this->data);
}

//Delete feedback with ajax Start
public function delete_user() 
{
     $contact_id = $_POST['contact_id'];
      $data = array(
            'is_delete' => '1'
        );

        $update = $this->common->update_data($data, 'contact_us', 'contact_id', $contact_id);
}
//Delete feedback with ajax End

}
