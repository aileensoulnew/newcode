<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Search_keyword extends CI_Controller {

    public $data;

    public function __construct() {

        parent::__construct();

        if (!$this->session->userdata('aileen_admin')) {

            redirect('login', 'refresh');
        }

        // Get Site Information
        $this->data['title'] = 'Search keyword Management | Aileensoul';
        $this->data['module_name'] = 'Search keyword Management';

        //Loadin Pagination Custome Config File
        $this->config->load('paging', TRUE);
        $this->paging = $this->config->item('paging');

        include('include.php');
    }

    public function job() {
        // This is userd for pagination offset and limoi start
          $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $sortby = $this->uri->segment(3);

            $orderby = $this->uri->segment(4);

        } else {

            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

            $sortby = 'keyword_id';

            $orderby = 'desc';

        }
        $module=$_GET['module'];
       // echo $module;die();
        $this->data['offset'] = $offset;

            

      
       
//       if($module==1){
//           $contition_array = array('search_info.status' => '1','search_info.module'=>'1');
//           $this->data['module']=1;
//       }elseif ($module==2) {
//            $contition_array = array('search_info.status' => '1','search_info.module'=>'2');
//            $this->data['module']=2;
//        }elseif ($module==3) {
//            $contition_array = array('search_info.status' => '1','search_info.module'=>'3');
//            $this->data['module']=3;
//        }elseif ($module==4) {
//            $contition_array = array('search_info.status' => '1','search_info.module'=>'4');
//            $this->data['module']=4;
//        }elseif($module==5){
//            $contition_array = array('search_info.status' => '1','search_info.module'=>'5');
//            $this->data['module']=5;
//        }else{
//            $contition_array = array('search_info.status' => '1','search_info.module'=>'6');
//            $this->data['module']=6;
//        }
        
        $join_str[0]['table'] = 'user';
            $join_str[0]['join_table_id'] = 'user.user_id';
            $join_str[0]['from_table_id'] = 'search_info.user_id';
            $join_str[0]['join_type'] = '';
        
        $contition_array = array('search_info.status' => '1','search_info.module'=>'1');
        $data='search_info.keyword_id,search_info.created_date,search_info.search_keyword,search_info.search_location,search_info.user_id as search_userid,search_info.user_location,search_info.created_date,user.first_name,user.last_name,user.user_email';
        $this->data['users'] = $this->common->select_data_by_condition('search_info', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str, $groupby = '');
        $this->data['module']=1;
// This is userd for pagination offset and limoi End

  //    echo "<pre>";print_r($this->data['users']);
//      echo count($this->data['users']);
//      die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['base_url'] = site_url("search_keyword/job/" . $short_by . "/" . $order_by);

        } else {

            $this->paging['base_url'] = site_url("search_keyword/job/");

        }

        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['uri_segment'] = 5;

        } else {

            $this->paging['uri_segment'] = 3;

        }
        //This if and else use for asc and desc while click on any field End

//        if($module==1){
//           $contition_array = array('search_info.status' => '1','search_info.module'=>'1');
//       }elseif ($module==2) {
//            $contition_array = array('search_info.status' => '1','search_info.module'=>'2');
//        }elseif ($module==3) {
//            $contition_array = array('search_info.status' => '1','search_info.module'=>'3');
//        }elseif ($module==4) {
//            $contition_array = array('search_info.status' => '1','search_info.module'=>'4');
//        }elseif($module==5){
//            $contition_array = array('search_info.status' => '1','search_info.module'=>'5');
//        }else{
//            $contition_array = array('search_info.status' => '1','search_info.module'=>'6');
//        }

       // $contition_array = array( 'status =' => '1','module'=>'1');
        $contition_array = array('search_info.status' => '1','search_info.module'=>'1');
        $this->paging['total_rows'] = count($this->common->select_data_by_condition('search_info', $contition_array, 'keyword_id'));
       // echo $this->paging['total_rows'];die();
        $this->data['total_rows'] = $this->paging['total_rows'];

        $this->data['limit'] = $limit;

        $this->pagination->initialize($this->paging);

        $this->data['search_keyword'] = '';


        $this->load->view('search/index', $this->data);
        
    }
    public function rec() {
        // This is userd for pagination offset and limoi start
          $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $sortby = $this->uri->segment(3);

            $orderby = $this->uri->segment(4);

        } else {

            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

            $sortby = 'keyword_id';

            $orderby = 'desc';

        }
        $module=$_GET['module'];
       // echo $module;die();
        $this->data['offset'] = $offset;


        $join_str[0]['table'] = 'user';
            $join_str[0]['join_table_id'] = 'user.user_id';
            $join_str[0]['from_table_id'] = 'search_info.user_id';
            $join_str[0]['join_type'] = '';
        
        $contition_array = array('search_info.status' => '1','search_info.module'=>'2');
        $data='search_info.keyword_id,search_info.created_date,search_info.search_keyword,search_info.search_location,search_info.user_id as search_userid,search_info.user_location,search_info.created_date,user.first_name,user.last_name,user.user_email';
        $this->data['users'] = $this->common->select_data_by_condition('search_info', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str, $groupby = '');
        $this->data['module']=2;
// This is userd for pagination offset and limoi End

  //    echo "<pre>";print_r($this->data['users']);
//      echo count($this->data['users']);
//      die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['base_url'] = site_url("search_keyword/rec/" . $short_by . "/" . $order_by);

        } else {

            $this->paging['base_url'] = site_url("search_keyword/rec/");

        }

        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['uri_segment'] = 5;

        } else {

            $this->paging['uri_segment'] = 3;

        }
        //This if and else use for asc and desc while click on any field End

        $contition_array = array('search_info.status' => '1','search_info.module'=>'2');
        $this->paging['total_rows'] = count($this->common->select_data_by_condition('search_info', $contition_array, 'keyword_id'));
       // echo $this->paging['total_rows'];die();
        $this->data['total_rows'] = $this->paging['total_rows'];

        $this->data['limit'] = $limit;

        $this->pagination->initialize($this->paging);

        $this->data['search_keyword'] = '';


        $this->load->view('search/index', $this->data);
        
    }
    public function freelancer_hire() {
        // This is userd for pagination offset and limoi start
          $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $sortby = $this->uri->segment(3);

            $orderby = $this->uri->segment(4);

        } else {

            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

            $sortby = 'keyword_id';

            $orderby = 'desc';

        }
        $module=$_GET['module'];
       // echo $module;die();
        $this->data['offset'] = $offset;


        $join_str[0]['table'] = 'user';
            $join_str[0]['join_table_id'] = 'user.user_id';
            $join_str[0]['from_table_id'] = 'search_info.user_id';
            $join_str[0]['join_type'] = '';
        
        $contition_array = array('search_info.status' => '1','search_info.module'=>'3');
        $data='search_info.keyword_id,search_info.created_date,search_info.search_keyword,search_info.search_location,search_info.user_id as search_userid,search_info.user_location,search_info.created_date,user.first_name,user.last_name,user.user_email';
        $this->data['users'] = $this->common->select_data_by_condition('search_info', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str, $groupby = '');
        $this->data['module']=3;
// This is userd for pagination offset and limoi End

  //    echo "<pre>";print_r($this->data['users']);
//      echo count($this->data['users']);
//      die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['base_url'] = site_url("search_keyword/freelancer_hire/" . $short_by . "/" . $order_by);

        } else {

            $this->paging['base_url'] = site_url("search_keyword/freelancer_hire/");

        }

        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['uri_segment'] = 5;

        } else {

            $this->paging['uri_segment'] = 3;

        }
        //This if and else use for asc and desc while click on any field End

        $contition_array = array('search_info.status' => '1','search_info.module'=>'3');
        $this->paging['total_rows'] = count($this->common->select_data_by_condition('search_info', $contition_array, 'keyword_id'));
       // echo $this->paging['total_rows'];die();
        $this->data['total_rows'] = $this->paging['total_rows'];

        $this->data['limit'] = $limit;

        $this->pagination->initialize($this->paging);

        $this->data['search_keyword'] = '';


        $this->load->view('search/index', $this->data);
        
    }
    public function freelancer_apply() {
        // This is userd for pagination offset and limoi start
          $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $sortby = $this->uri->segment(3);

            $orderby = $this->uri->segment(4);

        } else {

            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

            $sortby = 'keyword_id';

            $orderby = 'desc';

        }
        $module=$_GET['module'];
       // echo $module;die();
        $this->data['offset'] = $offset;


        $join_str[0]['table'] = 'user';
            $join_str[0]['join_table_id'] = 'user.user_id';
            $join_str[0]['from_table_id'] = 'search_info.user_id';
            $join_str[0]['join_type'] = '';
        
        $contition_array = array('search_info.status' => '1','search_info.module'=>'4');
        $data='search_info.keyword_id,search_info.created_date,search_info.search_keyword,search_info.search_location,search_info.user_id as search_userid,search_info.user_location,search_info.created_date,user.first_name,user.last_name,user.user_email';
        $this->data['users'] = $this->common->select_data_by_condition('search_info', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str, $groupby = '');
        $this->data['module']=4;
// This is userd for pagination offset and limoi End

  //    echo "<pre>";print_r($this->data['users']);
//      echo count($this->data['users']);
//      die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['base_url'] = site_url("search_keyword/freelancer_apply/" . $short_by . "/" . $order_by);

        } else {

            $this->paging['base_url'] = site_url("search_keyword/freelancer_apply/");

        }

        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['uri_segment'] = 5;

        } else {

            $this->paging['uri_segment'] = 3;

        }
        //This if and else use for asc and desc while click on any field End

        $contition_array = array('search_info.status' => '1','search_info.module'=>'4');
        $this->paging['total_rows'] = count($this->common->select_data_by_condition('search_info', $contition_array, 'keyword_id'));
       // echo $this->paging['total_rows'];die();
        $this->data['total_rows'] = $this->paging['total_rows'];

        $this->data['limit'] = $limit;

        $this->pagination->initialize($this->paging);

        $this->data['search_keyword'] = '';


        $this->load->view('search/index', $this->data);
        
    }
    public function business() {
        // This is userd for pagination offset and limoi start
          $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $sortby = $this->uri->segment(3);

            $orderby = $this->uri->segment(4);

        } else {

            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

            $sortby = 'keyword_id';

            $orderby = 'desc';

        }
        $module=$_GET['module'];
       // echo $module;die();
        $this->data['offset'] = $offset;


        $join_str[0]['table'] = 'user';
            $join_str[0]['join_table_id'] = 'user.user_id';
            $join_str[0]['from_table_id'] = 'search_info.user_id';
            $join_str[0]['join_type'] = '';
        
        $contition_array = array('search_info.status' => '1','search_info.module'=>'5');
        $data='search_info.keyword_id,search_info.created_date,search_info.search_keyword,search_info.search_location,search_info.user_id as search_userid,search_info.user_location,search_info.created_date,user.first_name,user.last_name,user.user_email';
        $this->data['users'] = $this->common->select_data_by_condition('search_info', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str, $groupby = '');
        $this->data['module']=5;
// This is userd for pagination offset and limoi End

  //    echo "<pre>";print_r($this->data['users']);
//      echo count($this->data['users']);
//      die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['base_url'] = site_url("search_keyword/business/" . $short_by . "/" . $order_by);

        } else {

            $this->paging['base_url'] = site_url("search_keyword/business/");

        }

        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['uri_segment'] = 5;

        } else {

            $this->paging['uri_segment'] = 3;

        }
        //This if and else use for asc and desc while click on any field End

        $contition_array = array('search_info.status' => '1','search_info.module'=>'5');
        $this->paging['total_rows'] = count($this->common->select_data_by_condition('search_info', $contition_array, 'keyword_id'));
       // echo $this->paging['total_rows'];die();
        $this->data['total_rows'] = $this->paging['total_rows'];

        $this->data['limit'] = $limit;

        $this->pagination->initialize($this->paging);

        $this->data['search_keyword'] = '';


        $this->load->view('search/index', $this->data);
        
    }
    public function artistic() {
        // This is userd for pagination offset and limoi start
          $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $sortby = $this->uri->segment(3);

            $orderby = $this->uri->segment(4);

        } else {

            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

            $sortby = 'keyword_id';

            $orderby = 'desc';

        }
        $module=$_GET['module'];
       // echo $module;die();
        $this->data['offset'] = $offset;


        $join_str[0]['table'] = 'user';
            $join_str[0]['join_table_id'] = 'user.user_id';
            $join_str[0]['from_table_id'] = 'search_info.user_id';
            $join_str[0]['join_type'] = '';
        
        $contition_array = array('search_info.status' => '1','search_info.module'=>'4');
        $data='search_info.keyword_id,search_info.created_date,search_info.search_keyword,search_info.search_location,search_info.user_id as search_userid,search_info.user_location,search_info.created_date,user.first_name,user.last_name,user.user_email';
        $this->data['users'] = $this->common->select_data_by_condition('search_info', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str, $groupby = '');
        $this->data['module']=6;
// This is userd for pagination offset and limoi End

  //    echo "<pre>";print_r($this->data['users']);
//      echo count($this->data['users']);
//      die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['base_url'] = site_url("search_keyword/artist/" . $short_by . "/" . $order_by);

        } else {

            $this->paging['base_url'] = site_url("search_keyword/artist/");

        }

        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['uri_segment'] = 5;

        } else {

            $this->paging['uri_segment'] = 3;

        }
        //This if and else use for asc and desc while click on any field End

        $contition_array = array('search_info.status' => '1','search_info.module'=>'6');
        $this->paging['total_rows'] = count($this->common->select_data_by_condition('search_info', $contition_array, 'keyword_id'));
       // echo $this->paging['total_rows'];die();
        $this->data['total_rows'] = $this->paging['total_rows'];

        $this->data['limit'] = $limit;

        $this->pagination->initialize($this->paging);

        $this->data['search_keyword'] = '';


        $this->load->view('search/index', $this->data);
        
    }

}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

