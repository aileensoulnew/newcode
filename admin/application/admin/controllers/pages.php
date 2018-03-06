<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pages extends CI_Controller {

    public $data;

    public function __construct() {

        parent::__construct();

        if (!$this->session->userdata('aileen_admin')) {
            redirect('login', 'refresh');
        }

        // Get Site Information
        $this->data['title'] = 'Pages Management | Aileensoul';
        $this->data['module_name'] = 'Pages Management';

        //Loadin Pagination Custome Config File
        $this->config->load('paging', TRUE);
        $this->paging = $this->config->item('paging');

        include('include.php');
    }

    //LIST OF ALL PAGES START
    public function page() {

        // This is userd for pagination offset and limoi start
        $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $sortby = $this->uri->segment(3);

            $orderby = $this->uri->segment(4);
        } else {

            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

            $sortby = 'page_id';

            $orderby = 'desc';
        }

        $this->data['offset'] = $offset;

         $data='page_id, page_name ,page_title ,timestamp';
        //$contition_array = array('page_status' => '1');
        $this->data['pages'] = $this->common->select_data_by_condition('pages', $contition_array = array(), $data, $sortby, $orderby, $limit, $offset, $join_str = array(), $groupby = '');
// This is userd for pagination offset and limoi End
        //echo "<pre>";print_r($this->data['pages'] );die();
        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['base_url'] = site_url("pages/page/" . $short_by . "/" . $order_by);
        } else {

            $this->paging['base_url'] = site_url("pages/page/");
        }

        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['uri_segment'] = 5;
        } else {

            $this->paging['uri_segment'] = 3;
        }
        //This if and else use for asc and desc while click on any field End


      //  $contition_array = array('page_status =' => '1');
        $this->paging['total_rows'] = count($this->common->select_data_by_condition('pages', $contition_array = array(), 'page_id'));

        $this->data['total_rows'] = $this->paging['total_rows'];

        $this->data['limit'] = $limit;

        $this->pagination->initialize($this->paging);

        $this->data['search_keyword'] = '';
        $this->load->view('pages/index', $this->data);
    }

    //LIST OF ALL PAGES END
    
   public function edit($id){
       
     $data='page_id,page_name ,page_title ,short_description ,page_description ,seo_title,seo_keywords,seo_description'; 
    $contition_array = array('page_id' => $id);
    $this->data['page'] = $this->common->select_data_by_condition('pages', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str, $groupby);
    $this->load->view('pages/edit', $this->data); 
       
   }
   public function edit_insert($id){
       
       $data = array(
            'page_name' => trim($this->input->post('page_name')),
            'page_title' => trim($this->input->post('page_title')),
            'short_description' => trim($this->input->post('short_description')),
            'page_description' => trim($this->input->post('description')),
            'seo_title' => trim($this->input->post('seo_title')),
            'seo_keywords' =>trim($this->input->post('seo_keyword')),
            'seo_description' => trim($this->input->post('seo_description')),
            'timestamp' =>date('Y-m-d', time()),
        );
      // echo "<pre>"; print_r($data);die();
       
       $updatdata = $this->common->update_data($data, 'pages', 'page_id', $id);

            if ($updatdata) {
               
                 redirect('pages/page', refresh);
               
            } else {
               
                $this->session->flashdata('error', 'Your data not inserted');
                redirect('pages/edit/'.$id, refresh);
            }
       
       
   }
   
   public function search(){
    
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

            $sortby = 'page_id';

            $orderby = 'asc';

        }
  
        $this->data['offset'] = $offset;
        
          $data='page_id, page_name ,page_title ,timestamp';
           $search_condition = "(page_name LIKE '%$search_keyword%' OR page_title LIKE '%$search_keyword%')";
           // $contition_array = array('is_delete' => '0');
            $this->data['pages'] = $this->common->select_data_by_search('pages', $search_condition, $contition_array=array(),$data, $sortby, $orderby, $limit, $offset);
 //echo "<pre>";print_r( $this->data['users']);die();
// This is userd for pagination offset and limoi End

       // echo "<pre>";print_r($this->userdata['users'] );die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['base_url'] = site_url("pages/search/" . $sortby . "/" . $orderby);

            } else {

                $this->paging['base_url'] = site_url("pages/search/");

            }



            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['uri_segment'] = 5;

            } else {

                $this->paging['uri_segment'] = 3;

            }

            $this->paging['total_rows'] = count($this->common->select_data_by_search('pages', $search_condition, $contition_array, 'page_id'));

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

            $sortby = 'page_id';

            $orderby = 'asc';

        }
  
        $this->data['offset'] = $offset;
        
          $data='page_id, page_name ,page_title ,timestamp';
           $search_condition = "(page_name LIKE '%$search_keyword%' OR page_title LIKE '%$search_keyword%')";
           
            $this->data['users'] = $this->common->select_data_by_search('user', $search_condition, $contition_array=array(),$data, $sortby, $orderby, $limit, $offset);
 //echo "<pre>";print_r( $this->data['users']);die();
// This is userd for pagination offset and limoi End

       // echo "<pre>";print_r($this->userdata['users'] );die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['base_url'] = site_url("pages/search/" . $sortby . "/" . $orderby);

            } else {

                $this->paging['base_url'] = site_url("pages/search/");

            }



            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['uri_segment'] = 5;

            } else {

                $this->paging['uri_segment'] = 3;

            }

            $this->paging['total_rows'] = count($this->common->select_data_by_search('pages', $search_condition, $contition_array=array(), 'page_id'));

            //for record display

            $this->data['total_rows'] = $this->paging['total_rows'];

            $this->data['limit'] = $limit;

            $this->pagination->initialize($this->paging);
    }

        $this->load->view('pages/index', $this->data);
    
}

//clear search is used for unset session start
public function clear_search() 
{ 
    if ($this->session->userdata('user_search_keyword')) 
    {
          
            $this->session->unset_userdata('user_search_keyword');
              
             redirect('pages/page','refresh');          
    } 
}
//clear search is used for unset session End


   
   
   
}
