<?php
$this->load->model('user_post_model');

$userid = $this->session->userdata('aileenuser');
$this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = 'u.first_name,u.last_name,ul.email,ui.user_image,u.user_id,ui.profile_background,ui.profile_background_main');
// notification count 

$contition_array = array('not_read' => '2', 'not_to_id' => $userid, 'not_type !=' => '1', 'not_type !=' => '2');
$result = $this->common->select_data_by_condition('notification', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
$this->data['user_notification_count'] = $count = $result[0]['total'];
// freelancer hire detail

// freelancer post detail
$select_data ='freelancer_post_fullname,freelancer_post_username,freelancer_post_user_image,profile_background,profile_background_main,designation,freelancer_apply_slug,free_post_step,user_id,progressbar';
$this->data['freepostdata'] = $this->freelancer_apply_model->getfreelancerapplydata($userid, $select_data);

//echo "<pre>"; print_r($this->data['freepostdata']);die();

$this->data['header'] = $this->load->view('header', $this->data, true);
$this->data['footer'] = $this->load->view('footer', $this->data, true);
$this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
$this->data['left_footer'] = $this->load->view('leftfooter', $this->data, TRUE);

$this->data['freelancer_post_search'] = $this->load->view('freelancer/freelancer_post/freelancer_post_search', $this->data, true);
$this->data['freelancer_hire_search'] = $this->load->view('freelancer/freelancer_hire/freelancer_hire_search', $this->data, true);
$this->data['freelancer_hire_header2_border'] = $this->load->view('freelancer/freelancer_hire/freelancer_hire_header2_border', $this->data, true);
//$this->data['freelancer_post_header2_border'] = $this->load->view('freelancer/freelancer_post/freelancer_post_header2_border', $this->data, true);

// Start - code needed for new header
$this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
$this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
$this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
$this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
$this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
$this->data['header_inner_profile'] = $this->load->view('header_inner_profile', $this->data, true);
$this->data['freelancer_post_header2'] = $this->load->view('freelancer/freelancer_post/freelancer_post_header2_new', $this->data, true);
// Start - code needed for new header



if ($this->uri->segment(2) == 'freelancer-details') {
    if (is_numeric($this->uri->segment(3))) {
        $id = $this->uri->segment(3);
    } else {
        $id = $category = $this->db->select('user_id')->get_where('freelancer_post_reg', array('freelancer_apply_slug' => $this->uri->segment(3), 'status' => '1'))->row()->user_id;
    }
    
    $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
    $data = "freelancer_post_fullname,freelancer_post_username,freelancer_post_field";
    $freelancerdata = $this->data['freelancerdata'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

    $fieldname1 = $this->data['fieldname1'] = $this->db->select('category_name')->get_where('category', array('category_id' => $this->data['freelancerdata'][0]['freelancer_post_field']))->row()->category_name;
    
}

$this->data['head'] = $this->load->view('head', $this->data, true);
?>