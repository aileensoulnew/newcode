<?php

// user detail
$userid = $this->data['user_id'] = $this->session->userdata('aileenuser');

// USERDATA USE FOR HEADER NAME AND IMAGE START
 $this->load->model('user_model');
 $this->load->model('recruiter_model');
 $this->load->model('job_model');
 $this->load->model('user_post_model');

// user detail
$this->data['userdata'] = $this->user_model->getUserData($userid);

$contition_array = array('not_read' => '2', 'not_to_id' => $userid, 'not_type !=' => '1', 'not_type !=' => '2');
$result = $this->common->select_data_by_condition('notification', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
$this->data['user_notification_count'] = $count = $result[0]['total'];


$this->data['header'] = $this->load->view('header', $this->data, true);
$this->data['head_message'] = $this->load->view('head_message', $this->data, true);
$this->data['footer'] = $this->load->view('footer', $this->data, true);
$this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
$this->data['rec_search'] = $this->load->view('recruiter/rec_search', $this->data, true);
$this->data['left_footer'] = $this->load->view('leftfooter', $this->data, TRUE);
$this->data['recruiter_header2_border'] = $this->load->view('recruiter/recruiter_header2_border', $this->data, true);

// Start - code needed for new header
$this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
$this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
$this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
$this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
$this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
$this->data['header_inner_profile'] = $this->load->view('header_inner_profile', $this->data, true);
$this->data['recruiter_header2'] = $this->load->view('recruiter/recruiter_header2', $this->data, true);
// Start - code needed for new header
// recruiter detail
// Start Job
$this->data['job_left'] = $this->load->view('job/job_left', $this->data, true);
$this->data['job_search'] = $this->load->view('job/job_search', $this->data, true);
$this->data['job_menubar'] = $this->load->view('job/menubar', $this->data, true);
$this->data['job_header2'] = $this->load->view('job/job_header2', $this->data, true);
//$this->data['job_header2_border'] = $this->load->view('job/job_header2_border', $this->data, true);
// End Job

$id = $this->uri->segment(3);


if (($id == $userid || $id == '') || $this->uri->segment(2) == 'edit-post' || $this->uri->segment(2) == 'apply-list' || $this->uri->segment(2) == 'recruiter_profile') {
    $recdata = $this->data['recdata'] = $this->recruiter_model->getRecruiterByUserid($userid);
} else {
    $recdata = $this->data['recdata'] = $this->recruiter_model->getRecruiterByUserid($id);
}


if ($this->uri->segment(2) == 'jobpost') {

    $segment3 = explode('-', $this->uri->segment(3));
    $slugdata = array_reverse($segment3);
    $postid = $slugdata[0];
    $this->data['recliveid'] = $userid = $slugdata[1];

    
    $recdata[] = $this->recruiter_model->getRecruiterCompanyname($userid);

    $postdata[] = $this->recruiter_model->getRecruiterPostById($postid,$userid);
   
    if (($postdata[0]['min_year'] != '0' || $postdata[0]['max_year'] != '0') && ($postdata[0]['fresher'] == 1)) {
        $exp_descp = $this->data['exp_descp'] = $postdata[0]['min_year'] . ' to ' . $postdata[0]['max_year'] . ' Years';
    } else {
        if (($postdata[0]['min_year'] != '0' || $postdata[0]['max_year'] != '0')) {
            $exp_descp = $this->data['exp_descp'] = $postdata[0]['min_year'] . ' to ' . $postdata[0]['max_year'] . ' Years';
        } else {
            $exp_descp = $this->data['exp_descp'] = "Fresher";
        }
    }

    //$exp_title = $this->recruiter_model->getRecruiterWhere($table_name = 'job_title',$where = array('title_id' => $postdata['post_name']),$fieldvalue = 'name');
    $exp_title = $this->data['exp_title'] = $this->db->get_where('job_title', array('title_id' => $postdata[0]['post_name']))->row()->name;
   // $state_name = $this->data['state_name'] = $this->recruiter_model->getRecruiterWhere($table_name = 'states',$where = array('state_id' => $postdata[0]['state']),$fieldvalue = 'state_name');
    $state_name = $this->data['state_name'] = $this->db->get_where('states', array('state_id' => $postdata[0]['state']))->row()->state_name;
  //  $city_name = $this->data['city_name'] = $this->recruiter_model->getRecruiterWhere($table_name = 'cities',$where = array('city_id' => $postdata[0]['city']),$fieldvalue = 'city_name');
    $city_name = $this->data['city_name'] = $this->db->get_where('cities', array('city_id' => $postdata[0]['city']))->row()->city_name;
    
}

if ($this->uri->segment(2) == 'profile') { 
    $contition_array = array('user_id' => $this->uri->segment(3), 'is_delete' => '0', 're_status' => '1');
    $data = "re_comp_name,re_comp_city,re_comp_state,rec_firstname,rec_lastname";
    $recdescdata = $this->data['recdescdata'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
    
     $statedesc_name = $this->data['statedesc_name'] = $this->db->get_where('states', array('state_id' => $recdescdata[0]['re_comp_state']))->row()->state_name;
    $citydesc_name = $this->data['citydesc_name'] = $this->db->get_where('cities', array('city_id' => $recdescdata[0]['re_comp_city']))->row()->city_name;
}

$this->data['head'] = $this->load->view('head', $this->data, true);
