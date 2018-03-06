<?php

$userid = $this->session->userdata('aileenuser');
$this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = 'u.first_name,u.last_name,ul.email,ui.user_image,u.user_id,ui.profile_background,ui.profile_background_main');

$select_data = 'profile_background,username,fullname,freelancer_hire_user_image,profile_background,profile_background_main,designation,freelancer_hire_slug,free_hire_step';
$this->data['freehiredata'] = $this->freelancer_hire_model->getfreelancerhiredata($userid, $select_data);

$this->data['header'] = $this->load->view('header', $this->data, true);
$this->data['footer'] = $this->load->view('footer', $this->data, true);
$this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
$this->data['left_footer'] = $this->load->view('leftfooter', $this->data, TRUE);

$this->data['freelancer_post_search'] = $this->load->view('freelancer/freelancer_post/freelancer_post_search', $this->data, true);
$this->data['freelancer_hire_search'] = $this->load->view('freelancer/freelancer_hire/freelancer_hire_search', $this->data, true);
//$this->data['freelancer_hire_header2_border'] = $this->load->view('freelancer/freelancer_hire/freelancer_hire_header2_border', $this->data, true);
// Start - code needed for new header
$this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
$this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
$this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
$this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
$this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
$this->data['header_inner_profile'] = $this->load->view('header_inner_profile', $this->data, true);
$this->data['freelancer_hire_header2'] = $this->load->view('freelancer/freelancer_hire/freelancer_hire_header2_new', $this->data, true);
// Start - code needed for new header
$this->data['freelancer_post_header2'] = $this->load->view('freelancer/freelancer_post/freelancer_post_header2_new', $this->data, true);

//$this->data['freelancer_post_header2_border'] = $this->load->view('freelancer/freelancer_post/freelancer_post_header2_border', $this->data, true);
if ($this->uri->segment(2) == 'project') {
    $segment3 = explode('-', $this->uri->segment(3));
    $slugdata = array_reverse($segment3);
    $postid = $slugdata[0];
    $this->data['recliveid'] = $userid = $slugdata[1];
    $this->data['postid'] = $postid;

    $select_data = 'fp.post_id,fp.post_name,fp.post_field_req,fp.post_description,fp.user_id,fp.post_currency,fp.post_rate';
    $this->data['projectdata'] = $this->freelancer_hire_model->getprojectdatabypostid($postid, $userid, $select_data);

    $fieldname = $this->data['fieldname'] = $this->db->select('category_name')->get_where('category', array('category_id' => $this->data['projectdata'][0]['post_field_req']))->row()->category_name;
    $currencyname = $this->data['currencyname'] = $this->db->select('currency_name')->get_where('currency', array('currency_id' => $this->data['projectdata'][0]['post_currency']))->row()->currency_name;
}

if ($this->uri->segment(2) == 'employer-details') {
    if (is_numeric($this->uri->segment(3))) {
        $id = $this->uri->segment(3);
    } else {
        $id = $category = $this->db->select('user_id')->get_where('freelancer_hire_reg', array('freelancer_hire_slug' => $this->uri->segment(3), 'status' => '1'))->row()->user_id;
    }

    $select_data = 'username,fullname';
    $employerdata = $this->data['employerdata'] = $this->freelancer_hire_model->getfreelancerhiredata($id, $select_data);
}
$this->data['head'] = $this->load->view('head', $this->data, true);
?>

