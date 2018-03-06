<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Advertise_with_us extends CI_Controller {

    public $data;

    public function __construct() {

        parent::__construct();

        if (!$this->session->userdata('aileen_admin')) {

            redirect('login', 'refresh');
        }

        // Get Site Information
        $this->data['title'] = 'Advertise | Aileensoul';
        $this->data['module_name'] = 'Advertise Management';

        //Loadin Pagination Custome Config File
        $this->config->load('paging', TRUE);
        $this->paging = $this->config->item('paging');

        include('include.php');
    }

    public function index() {

        // This is userd for pagination offset and limoi start
        $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {
            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;
            $sortby = $this->uri->segment(3);
            $orderby = $this->uri->segment(4);
        } else {
            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;
            $sortby = 'id';
            $orderby = 'desc';
        }

        $this->data['offset'] = $offset;

        $data = '*';
        $contition_array = array();
        $this->data['advertise_with_us'] = $this->common->select_data_by_condition('advertise_with_us', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str = array(), $groupby = '');

        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {
            $this->paging['base_url'] = site_url("advertise_with_us/" . $short_by . "/" . $order_by);
        } else {
            $this->paging['base_url'] = site_url("advertise_with_us/");
        }

        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {
            $this->paging['uri_segment'] = 5;
        } else {
            $this->paging['uri_segment'] = 3;
        }
        //This if and else use for asc and desc while click on any field End


        $contition_array = array();
        $this->paging['total_rows'] = count($this->common->select_data_by_condition('advertise_with_us', $contition_array, 'id'));

        $this->data['total_rows'] = $this->paging['total_rows'];
        $this->data['limit'] = $limit;
        $this->pagination->initialize($this->paging);
        $this->data['search_keyword'] = '';
        $this->load->view('advertise_with_us/index', $this->data);
    }

}
