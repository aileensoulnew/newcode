<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Freelancer_apply extends CI_Controller {

    public $data;

    public function __construct() {

        parent::__construct();

        if (!$this->session->userdata('aileen_admin')) {

            redirect('login', 'refresh');
        }

        // Get Site Information
        $this->data['title'] = 'Freelancer Apply Management | Aileensoul';
        $this->data['module_name'] = 'Freelancer Apply Management';

        //Loadin Pagination Custome Config File
        $this->config->load('paging', TRUE);
        $this->paging = $this->config->item('paging');

        include('include.php');
    }

//for list of all user start
    public function user() {

// This is userd for pagination offset and limoi start
        $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $sortby = $this->uri->segment(3);

            $orderby = $this->uri->segment(4);
        } else {

            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

            $sortby = 'freelancer_post_reg_id';

            $orderby = 'desc';
        }

        $this->data['offset'] = $offset;

        $data = 'freelancer_post_reg_id,freelancer_post_fullname,freelancer_post_username,freelancer_post_email,freelancer_post_phoneno,freelancer_post_country,freelancer_post_state,freelancer_post_city,user_id,status,created_date,modify_date,is_delete,freelancer_post_user_image';
        $contition_array = array('is_delete' => '0');
        $this->data['users'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str = array(), $groupby = '');
// This is userd for pagination offset and limoi End
        //echo "<pre>";print_r($this->data['users'] );die();
        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['base_url'] = site_url("freelancer_apply/user/" . $short_by . "/" . $order_by);
        } else {

            $this->paging['base_url'] = site_url("freelancer_apply/user/");
        }

        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['uri_segment'] = 5;
        } else {

            $this->paging['uri_segment'] = 3;
        }
        //This if and else use for asc and desc while click on any field End


        $contition_array = array('is_delete =' => '0');
        $this->paging['total_rows'] = count($this->common->select_data_by_condition('freelancer_post_reg', $contition_array, 'freelancer_post_reg_id'));

        $this->data['total_rows'] = $this->paging['total_rows'];

        $this->data['limit'] = $limit;

        $this->pagination->initialize($this->paging);

        $this->data['search_keyword'] = '';


        $this->load->view('freelancer_apply/index', $this->data);
    }

//for list of all user End
//deactivate user with ajax Start
    public function deactive_user() {

        $freelancer_post_reg_id = $_POST['freelancer_post_reg_id'];
        $data = array(
            'status' => 0
        );

        $update = $this->common->update_data($data, 'freelancer_post_reg', 'freelancer_post_reg_id', $freelancer_post_reg_id);

        $select = '<td id= "active(' . $freelancer_post_reg_id . ')">';
        $select .= '<button class="btn btn-block btn-success btn-sm"    onClick="active_user(' . $freelancer_post_reg_id . ')">
                              Deactive
                      </button>';
        $select .= '</td>';

        echo $select;
        die();
    }

//deactivate user with ajax End
//activate user with ajax Start
    public function active_user() {
        $freelancer_post_reg_id = $_POST['freelancer_post_reg_id'];
        $data = array(
            'status' => 1
        );

        $update = $this->common->update_data($data, 'freelancer_post_reg', 'freelancer_post_reg_id', $freelancer_post_reg_id);

        $select = '<td id= "active(' . $freelancer_post_reg_id . ')">';
        $select = '<button class="btn btn-block btn-primary btn-sm"   onClick="deactive_user(' . $freelancer_post_reg_id . ')">
                              Active
                      </button>';
        $select .= '</td>';

        echo $select;

        die();
    }

//activate user with ajax End
//Delete user with ajax Start
    public function delete_user() {
        $freelancer_post_reg_id = $_POST['freelancer_post_reg_id'];
        $data = array(
            'is_delete' => 1
        );

        $update = $this->common->update_data($data, 'freelancer_post_reg', 'freelancer_post_reg_id', $freelancer_post_reg_id);
        die();
    }

//Delete user with ajax End

    public function search() {

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

                $sortby = 'freelancer_post_reg_id';

                $orderby = 'asc';
            }

            $this->data['offset'] = $offset;

            $data = 'freelancer_post_reg_id,freelancer_post_fullname,freelancer_post_username,freelancer_post_email,freelancer_post_phoneno,freelancer_post_country,freelancer_post_state,freelancer_post_city,user_id,status,created_date,modify_date,is_delete,freelancer_post_user_image';
            $search_condition = "(freelancer_post_fullname LIKE '%$search_keyword%' OR freelancer_post_email LIKE '%$search_keyword%')";
            $contition_array = array('is_delete' => '0');
            $this->data['users'] = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data, $sortby, $orderby, $limit, $offset);
            //echo "<pre>";print_r( $this->data['users']);die();
// This is userd for pagination offset and limoi End
            // echo "<pre>";print_r($this->userdata['users'] );die();
            //This if and else use for asc and desc while click on any field start
            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['base_url'] = site_url("freelancer_apply/search/" . $sortby . "/" . $orderby);
            } else {

                $this->paging['base_url'] = site_url("freelancer_apply/search/");
            }



            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['uri_segment'] = 5;
            } else {

                $this->paging['uri_segment'] = 3;
            }

            $this->paging['total_rows'] = count($this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, 'freelancer_post_reg_id'));

            //for record display

            $this->data['total_rows'] = $this->paging['total_rows'];

            $this->data['limit'] = $limit;

            $this->pagination->initialize($this->paging);
        } else if ($this->session->userdata('user_search_keyword')) {//echo "jii"; die();
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

                $sortby = 'freelancer_post_reg_id';

                $orderby = 'asc';
            }

            $this->data['offset'] = $offset;

            $data = 'freelancer_post_reg_id,freelancer_post_fullname,freelancer_post_username,freelancer_post_email,freelancer_post_phoneno,freelancer_post_country,freelancer_post_state,freelancer_post_city,user_id,status,created_date,modify_date,is_delete,freelancer_post_user_image';
            $search_condition = "(freelancer_post_fullname LIKE '%$search_keyword%' OR freelancer_post_email LIKE '%$search_keyword%')";
            $contition_array = array('is_delete' => '0');
            $this->data['users'] = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data, $sortby, $orderby, $limit, $offset);
            //echo "<pre>";print_r( $this->data['users']);die();
// This is userd for pagination offset and limoi End
            // echo "<pre>";print_r($this->userdata['users'] );die();
            //This if and else use for asc and desc while click on any field start
            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['base_url'] = site_url("freelancer_apply/search/" . $sortby . "/" . $orderby);
            } else {

                $this->paging['base_url'] = site_url("freelancer_apply/search/");
            }



            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['uri_segment'] = 5;
            } else {

                $this->paging['uri_segment'] = 3;
            }

            $this->paging['total_rows'] = count($this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, 'freelancer_post_reg_id'));

            //for record display

            $this->data['total_rows'] = $this->paging['total_rows'];

            $this->data['limit'] = $limit;

            $this->pagination->initialize($this->paging);
        }

        $this->load->view('freelancer_apply/index', $this->data);
    }

//clear search is used for unset session start
    public function clear_search() {

        if ($this->session->userdata('user_search_keyword')) {

            $this->session->unset_userdata('user_search_keyword');

            redirect('freelancer_apply/user', 'refresh');
        }
    }

//clear search is used for unset session End
//profile function is used for view profile of user Start
    public function profile($id) {
        
        $userid = $this->db->get_where('freelancer_post_reg', array('freelancer_post_reg_id' => $id))->row()->user_id;

        //FOR GETTING ALL DATA OF Freelancer apply reg
        $contition_array = array('freelancer_post_reg_id' => $id, 'is_delete' => '0');
        $data = 'freelancer_post_reg_id,freelancer_post_fullname,freelancer_post_username,freelancer_post_skypeid,freelancer_post_email,freelancer_post_phoneno,freelancer_post_country,freelancer_post_state,freelancer_post_city,freelancer_post_pincode,freelancer_post_field,freelancer_post_area,freelancer_post_skill_description,freelancer_post_hourly,freelancer_post_ratestate,freelancer_post_fixed_rate,freelancer_post_job_type,freelancer_post_work_hour,freelancer_post_degree,freelancer_post_stream,freelancer_post_univercity,freelancer_post_collage,freelancer_post_percentage,freelancer_post_passingyear,freelancer_post_portfolio_attachment,freelancer_post_portfolio,user_id,freelancer_post_user_image,designation,freelancer_post_exp_month,freelancer_post_exp_year';
        $this->data['users'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

      

        $this->load->view('freelancer_apply/edit', $this->data);
    }

//view function is used for view profile of user End
}

/* End of file job.php 

/* Location: ./application/controllers/job.php */