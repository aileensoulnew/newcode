<?php 
$this->load->model('user_post_model');

// user detail
$userid = $this->session->userdata('aileenuser');
$this->data['userdata'] = $this->user_model->getUserData($userid);

$contition_array = array('not_read' => '2', 'not_to_id' => $userid, 'not_type !=' => '1', 'not_type !=' => '2');
$result = $this->common->select_data_by_condition('notification', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
$this->data['user_notification_count'] = $count = $result[0]['total'];


// job detail
$contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
$this->data['jobdata'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

if($this->uri->segment(1) == 'job' && $this->uri->segment(2) == 'resume'){
 $contition_array = array('slug' => $this->uri->segment(3), 'is_delete' => '0', 'status' => '1');
$jobdescription = $this->data['jobdescription'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'fname,lname', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');   

$this->data['fdescname'] = $fdescname = $jobdescription[0]['fname'];
$this->data['ldescname'] = $ldescname = $jobdescription[0]['lname'];

}


$this->data['head'] = $this->load->view('head', $this->data, true);
$this->data['header'] = $this->load->view('header', $this->data, true);
$this->data['footer'] = $this->load->view('footer', $this->data, true);
$this->data['left_footer'] = $this->load->view('leftfooter', $this->data,TRUE);

// Start Job
$this->data['job_left'] = $this->load->view('job/job_left', $this->data, true);
$this->data['job_search'] = $this->load->view('job/job_search', $this->data, true);
$this->data['job_menubar'] = $this->load->view('job/menubar', $this->data, true);
//$this->data['job_header2_border'] = $this->load->view('job/job_header2_border', $this->data, true);
// Start - code needed for new header
$this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
$this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
$this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
$this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
$this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
$this->data['header_inner_profile'] = $this->load->view('header_inner_profile', $this->data, true);
$this->data['job_header2'] = $this->load->view('job/job_header2', $this->data, true);
// Start - code needed for new header
$this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
// End Job
// Start Recruiter
?>
