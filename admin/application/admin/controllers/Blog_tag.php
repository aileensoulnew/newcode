<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blog_tag extends CI_Controller {

    public $data;

    public function __construct() {


        parent::__construct();

        if (!$this->session->userdata('aileen_admin')) 
        {
            redirect('login', 'refresh');
        }
   
         // Get Site Information
        $this->data['title'] = 'Blog Tag | Aileensoul';
        $this->data['module_name'] = 'Blog Tag';
        $this->data['section_title'] = 'Blog Tag';

         //Loadin Pagination Custome Config File
         $this->config->load('paging', TRUE);
         $this->paging = $this->config->item('paging');
        
        include('include.php');
    }

    public function blog_list() {

        $this->load->view('blog_tag/list', $this->data);
    }
    //add new product


      public function add() {
          $adminid =  $this->session->userdata('aileen_admin');
       
    

        $this->load->view('blog_tag/add', $this->data);
    }


    public function tag_add() {
        $adminid =  $this->session->userdata('aileen_admin');
       
        $data = array(
                    'name' => $this->input->post('name'),
                    'created_date' => date('Y-m-d H:i:s'),
                    'status' => 'publish'
                );
                // echo "<pre>"; print_r($data); die(); 
                $insert_id = $this->common->insert_data_getid($data, 'blog_tag');
               
               if ($insert_id) {

                    $this->session->set_flashdata('success', 'Tag name inserted successfully');
                    redirect('blog_tag/blog_list', refresh);
                } else {
                    $this->session->flashdata('error', 'Sorry!! Your data not inserted');
                    redirect('blog_tag/tag_add', refresh);
                }


        $this->load->view('blog_tag/add', $this->data);
    }


}

?>