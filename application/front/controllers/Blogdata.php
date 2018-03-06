<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blogdata extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //AWS access info start
        $this->load->library('S3');
        //AWS access info end
        include ('include.php');
        $this->config->load('paging', TRUE);
        $this->paging = $this->config->item('paging');
    }

    //MAIN INDEX PAGE START   
    public function index($slug = '') {
//                $data = '*';
//                $contition_array = array('status' => 'publish');
//                $this->data['blog_detail'] = $this->common->select_data_by_condition('blog', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str = array(), $groupby = '');

        $this->load->view('blogdata/index', $this->data);
    }

    public function bloglist() {

        $data = json_decode(file_get_contents("php://input"), TRUE);
        $limit = $data['rowperpage'];
        $offset = $data['row'];

        $data = 'id,title,created_date,blog_slug,description,image';
        //FOR GETTING ALL DATA

        $condition_array = array('status' => 'publish');
        $this->data['blog_detail'] = $this->common->select_data_by_condition('blog', $condition_array, $data, $short_by = 'id', $order_by = 'desc', $limit, $offset, $join_str = array());

        $response_arr = $this->data['blog_detail'];
        if (count($response_arr) > 0) {
            echo json_encode($response_arr);
        }
    }

    public function blogdatas() {
        $this->load->view('blogdata/bloglist', $this->data);
    }

}
