<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Search extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->lang->load('message', 'english');
        $this->load->library('S3');
        $this->load->model('common');

//        if (!$this->session->userdata('user_id')) {
//            redirect('login', 'refresh');
//        }

        include ('include.php');
        include ('business_include.php');
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $this->load->view('search/recommen_candidate', $this->data);
    }

    public function business_index() {
        $user_id = $this->session->userdata('user_id');
        $this->load->view('search/search_business', $this->data);
    }

    public function business_search() {

        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        $this->data['slug_id'] = $slug_id = $patient = $this->db->select('business_slug')->get_where('business_profile', array('user_id' => $userid))->row()->business_slug;
        if ($this->input->get('skills') == "" && $this->input->get('searchplace') == "") {
            redirect('business-profile/home', refresh);
        }
// code for insert search keyword in database start
        $search_business = trim($this->input->get('skills'));
        $this->data['keyword'] = $search_business;

        $search_place = trim($this->input->get('searchplace'));
        $cache_time = $this->db->get_where('cities', array('city_name' => $search_place))->row()->city_id;

        $this->data['keyword1'] = $search_place;
        $contition_array = array('business_profile.user_id' => $userid, 'business_profile.is_deleted' => '0', 'business_profile.status' => '1');
        $this->data['city'] = $city = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'city', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        if ($this->session->userdata('aileenuser')) {
            $data = array(
                'search_keyword' => $search_business,
                'search_location' => $search_place,
                'user_location' => $city[0]['city'],
                'user_id' => $userid,
                'created_date' => date('Y-m-d h:i:s', time()),
                'status' => '1',
                'module' => '5'
            );

            $insert_id = $this->common->insert_data_getid($data, 'search_info');
// code for insert search keyword in database end
        }
        if ($search_business == "") {
            $contition_array = array('city' => $cache_time, 'status' => '1', 'business_step' => '4');
            $business_profile = $this->data['results'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } elseif ($search_place == "") {
            $condition_array = array('business_profile.business_profile_id !=' => '', 'business_profile.status' => '1', 'business_profile.business_step' => '4', 'user_login.is_delete' => '0', 'user_login.status' => '1');

            $searchbusiness = $this->db->get_where('business_type', array('business_name' => $search_business))->row()->type_id;
            $searchbusiness1 = $this->db->get_where('industry_type', array('industry_name' => $search_business))->row()->industry_id;
            if ($searchbusiness1) {
                $search_condition = "(industriyal LIKE '%$searchbusiness1%')";
            } elseif ($searchbusiness) {
                $search_condition = "(business_type LIKE '%$searchbusiness%')";
            } else {
                $search_condition = "(company_name LIKE '%$search_business%' or contact_website LIKE '%$search_business%' or other_business_type LIKE '%$search_business%' or other_industrial LIKE '%$search_business%')";
            }

            $join_str[0]['table'] = 'user';
            $join_str[0]['join_table_id'] = 'user.user_id';
            $join_str[0]['from_table_id'] = 'business_profile.user_id';
            $join_str[0]['join_type'] = '';

            $join_str[1]['table'] = 'user_login';
            $join_str[1]['join_table_id'] = 'user_login.user_id';
            $join_str[1]['from_table_id'] = 'business_profile.user_id';
            $join_str[1]['join_type'] = '';

//   echo $search_condition; 
            $business_profile = $this->data['results'] = $this->common->select_data_by_search('business_profile', $search_condition, $condition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');


            $join_str[0]['table'] = 'business_profile';
            $join_str[0]['join_table_id'] = 'business_profile.user_id';
            $join_str[0]['from_table_id'] = 'business_profile_post.user_id';
            $join_str[0]['join_type'] = '';

            $condition_array = array('business_profile.business_step' => '4', 'business_profile_post.is_delete' => '0');
            $search_condition = "(business_profile_post.product_name LIKE '%$search_business%' or business_profile_post.product_description LIKE '%$search_business%')";

            $business_post = $post['data'] = $this->common->select_data_by_search('business_profile_post', $search_condition, $condition_array, $data = 'business_profile_post.*,business_profile.company_name,business_profile.industriyal,business_profile.business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        } else {
            $condition_array = array('business_profile.business_profile_id !=' => '', 'business_profile.status' => '1', 'business_profile.city' => $cache_time, 'business_profile.business_step' => '4', 'user_login.is_delete' => '0', 'user_login.status' => '1');
            $searchbusiness = $this->db->get_where('business_type', array('business_name' => $search_business))->row()->type_id;
            $searchbusiness1 = $this->db->get_where('industry_type', array('industry_name' => $search_business))->row()->industry_id;
            if ($searchbusiness1) {
                $search_condition = "(industriyal LIKE '%$searchbusiness1%')";
            } elseif ($searchbusiness) {
                $search_condition = "(business_type LIKE '%$searchbusiness%')";
            } else {
                $search_condition = "(company_name LIKE '%$search_business%' or contact_website LIKE '%$search_business%' or other_business_type LIKE '%$search_business%' or other_industrial LIKE '%$search_business%')";
            }

            $join_str[0]['table'] = 'user';
            $join_str[0]['join_table_id'] = 'user.user_id';
            $join_str[0]['from_table_id'] = 'business_profile.user_id';
            $join_str[0]['join_type'] = '';

            $join_str[1]['table'] = 'user_login';
            $join_str[1]['join_table_id'] = 'user_login.user_id';
            $join_str[1]['from_table_id'] = 'business_profile.user_id';
            $join_str[1]['join_type'] = '';

            $business_profile = $this->data['results'] = $this->common->select_data_by_search('business_profile', $search_condition, $condition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

            $join_str[0]['table'] = 'business_profile';
            $join_str[0]['join_table_id'] = 'business_profile.user_id';
            $join_str[0]['from_table_id'] = 'business_profile_post.user_id';
            $join_str[0]['join_type'] = '';

            $condition_array = array('business_profile.business_step' => '4', 'business_profile_post.is_delete' => '0');
            $search_condition = "(business_profile_post.product_name LIKE '%$search_business%' or business_profile_post.product_description LIKE '%$search_business%')";
            $business_post = $post['data'] = $this->common->select_data_by_search('business_profile_post', $search_condition, $condition_array, $data = 'business_profile_post.*,business_profile.company_name,business_profile.industriyal', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        }

        $this->data['is_business'] = $is_business = $this->db->get_where('business_profile', array('user_id' => $userid))->row()->business_profile_id;


        $this->data['description'] = $business_post;

        $this->data['profile'] = $business_profile;

        if ($is_business) {
            $this->data['business_left'] = $this->load->view('business_profile/business_left', $this->data, TRUE);
        }
        $title = '';
        if ($search_business && $search_place) {
            $title = $search_business . ' in ' . $search_place;
        } elseif ($search_business) {
            $title = $search_business;
        } elseif ($search_place) {
            $title = $search_place;
        }
        $this->data['title'] = $title . " | Business Profile - Aileensoul";

        $this->data['head'] = $this->load->view('head', $this->data, TRUE);



//THIS CODE IS FOR WHEN USER NOT LOGIN AND GET SEARCH DATA START
        if ($this->session->userdata('aileenuser')) {
            $this->load->view('business_profile/recommen_business', $this->data);
        } else {

            $this->load->view('business_profile/business_search_login', $this->data);
        }
//THIS CODE IS FOR WHEN USER NOT LOGIN AND GET SEARCH DATA END
    }

       public function ajax_business_search() {


        // $perpage = 4;
        // $page = 1;
        // if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
        //     $page = $_GET["page"];
        // }

        // $start = ($page - 1) * $perpage;
        // if ($start < 0)
        //     $start = 0;

        $business_login_slug = $this->data['business_login_slug'];

        $main_business_profile_id = $this->data['business_common_data'][0]['business_profile_id'];
        $main_city = $this->data['business_common_data'][0]['city'];
        $main_user_id = $this->data['business_common_data'][0]['user_id'];
        $main_business_user_image = $this->data['business_common_data'][0]['business_user_image'];
        $main_business_slug = $this->data['business_common_data'][0]['business_slug'];
        $main_company_name = $this->data['business_common_data'][0]['company_name'];
        $main_profile_background = $this->data['business_common_data'][0]['profile_background'];
        $main_state = $this->data['business_common_data'][0]['state'];
        $main_industriyal = $this->data['business_common_data'][0]['industriyal'];
        $main_other_industrial = $this->data['business_common_data'][0]['other_industrial'];


        $userid = $this->session->userdata('aileenuser');
        if ($this->input->get('skills') == "" && $this->input->get('searchplace') == "") {
            redirect('business-profile/home/', refresh);
        }
// code for insert search keyword in database start
        $search_business = trim($this->input->get('skills'));
        $this->data['keyword'] = $search_business;

        $search_place = trim($this->input->get('searchplace'));
        $cache_time = $this->db->get_where('cities', array('city_name' => $search_place))->row()->city_id;

        $this->data['keyword1'] = $search_place;
        $contition_array = array('business_profile.user_id' => $userid, 'business_profile.is_deleted' => '0', 'business_profile.status' => '1');
        $this->data['city'] = $city = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'city', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        if ($this->session->userdata('aileenuser')) {
            $data = array(
                'search_keyword' => $search_business,
                'search_location' => $search_place,
                'user_location' => $city[0]['city'],
                'user_id' => $userid,
                'created_date' => date('Y-m-d h:i:s', time()),
                'status' => '1',
                'module' => '5'
            );

            $insert_id = $this->common->insert_data_getid($data, 'search_info');
// code for insert search keyword in database end
        }

        $condition_array = array('business_profile_post.is_delete' => '0', 'business_profile_post.status' => '1', 'FIND_IN_SET ("' . $userid . '", delete_post) !=' => '0');
        $delete_postdata = $this->common->select_data_by_condition('business_profile_post', $condition_array, $data = 'GROUP_CONCAT(business_profile_post_id) as delete_post_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $delete_post_id = $delete_postdata[0]['delete_post_id'];
        $delete_post_id = str_replace(",", "','", $delete_post_id);


        if ($search_business == "") {
            $contition_array = array('city' => $cache_time, 'status' => '1', 'business_step' => '4', 'is_deleted' => '0');

             $business_profile = $this->data['results'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            //$business_profile = $this->common->select_data_by_search('business_profile', $search_condition, $condition_array, $data = '*', $sortby = '', $orderby = '', $limit = $perpage, $offset = $start, $join_str, $groupby = '');
            //$business_profile1 = $this->common->select_data_by_search('business_profile', $search_condition, $condition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');


        } elseif ($search_place == "") {
            $condition_array = array('business_profile_id !=' => '', 'business_profile.status' => '1', 'business_step' => '4', 'user_login.is_delete' => '0', 'user_login.status' => '1');
            $searchbusiness = $this->db->get_where('business_type', array('business_name' => $search_business))->row()->type_id;
            $searchbusiness1 = $this->db->get_where('industry_type', array('industry_name' => $search_business))->row()->industry_id;
            if ($searchbusiness1) {
                $search_condition = "(industriyal LIKE '%$searchbusiness1%')";
            } elseif ($searchbusiness) {
                $search_condition = "(business_type LIKE '%$searchbusiness%')";
            } else {
                $search_condition = "(company_name LIKE '%$search_business%' or contact_website LIKE '%$search_business%' or other_business_type LIKE '%$search_business%' or other_industrial LIKE '%$search_business%')";
            }
            $join_str[0]['table'] = 'user';
            $join_str[0]['join_table_id'] = 'user.user_id';
            $join_str[0]['from_table_id'] = 'business_profile.user_id';
            $join_str[0]['join_type'] = '';

            $join_str[1]['table'] = 'user_login';
            $join_str[1]['join_table_id'] = 'user_login.user_id';
            $join_str[1]['from_table_id'] = 'business_profile.user_id';
            $join_str[1]['join_type'] = '';
//   echo $search_condition; 
            $business_profile = $this->data['results'] = $this->common->select_data_by_search('business_profile', $search_condition, $condition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

           // $business_profile = $this->common->select_data_by_search('business_profile', $search_condition, $condition_array, $data = '*', $sortby = '', $orderby = '', $limit = $perpage, $offset = $start, $join_str, $groupby = '');
           // $business_profile1 = $this->common->select_data_by_search('business_profile', $search_condition, $condition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');


            $join_str[0]['table'] = 'business_profile';
            $join_str[0]['join_table_id'] = 'business_profile.user_id';
            $join_str[0]['from_table_id'] = 'business_profile_post.user_id';
            $join_str[0]['join_type'] = '';

            $condition_array = array('business_step' => '4', 'business_profile_post.is_delete' => '0');
            $search_condition = "(`business_profile_post_id` NOT IN ('$delete_post_id')) AND (business_profile_post.product_name LIKE '%$search_business%' or business_profile_post.product_description LIKE '%$search_business%')";

            $business_post = $post['data'] = $this->common->select_data_by_search('business_profile_post', $search_condition, $condition_array, $data = 'business_profile_post.*,business_profile.company_name,business_profile.industriyal,business_profile.business_profile_id,business_profile.business_user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        } else {
            $condition_array = array('business_profile.business_profile_id !=' => '', 'business_profile.status' => '1', 'business_profile.city' => $cache_time, 'business_profile.business_step' => '4', 'user_login.is_delete' => '0', 'user_login.status' => '1');
            $searchbusiness = $this->db->get_where('business_type', array('business_name' => $search_business))->row()->type_id;
            $searchbusiness1 = $this->db->get_where('industry_type', array('industry_name' => $search_business))->row()->industry_id;
            if ($searchbusiness1) {
                $search_condition = "(industriyal LIKE '%$searchbusiness1%')";
            } elseif ($searchbusiness) {
                $search_condition = "(business_type LIKE '%$searchbusiness%')";
            } else {
                $search_condition = "(company_name LIKE '%$search_business%' or contact_website LIKE '%$search_business%' or other_business_type LIKE '%$search_business%' or other_industrial LIKE '%$search_business%')";
            }

            $join_str[0]['table'] = 'user';
            $join_str[0]['join_table_id'] = 'user.user_id';
            $join_str[0]['from_table_id'] = 'business_profile.user_id';
            $join_str[0]['join_type'] = '';

            $join_str[1]['table'] = 'user_login';
            $join_str[1]['join_table_id'] = 'user_login.user_id';
            $join_str[1]['from_table_id'] = 'business_profile.user_id';
            $join_str[1]['join_type'] = '';

            $business_profile = $this->data['results'] = $this->common->select_data_by_search('business_profile', $search_condition, $condition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');


            //$business_profile = $this->common->select_data_by_search('business_profile', $search_condition, $condition_array, $data = '*', $sortby = '', $orderby = '', $limit = $perpage, $offset = $start, $join_str, $groupby = '');
          //  $business_profile1 = $this->common->select_data_by_search('business_profile', $search_condition, $condition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

            $join_str[0]['table'] = 'business_profile';
            $join_str[0]['join_table_id'] = 'business_profile.user_id';
            $join_str[0]['from_table_id'] = 'business_profile_post.user_id';
            $join_str[0]['join_type'] = '';

            $condition_array = array('business_step' => '4', 'business_profile_post.is_delete' => '0');
            $search_condition = "(`business_profile_post_id` NOT IN ('$delete_post_id')) AND (business_profile_post.product_name LIKE '%$search_business%' or business_profile_post.product_description LIKE '%$search_business%')";
            $business_post = $post['data'] = $this->common->select_data_by_search('business_profile_post', $search_condition, $condition_array, $data = 'business_profile_post.*,business_profile.company_name,business_profile.industriyal,business_profile.business_user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        }

        $this->data['is_business'] = $is_business = $this->db->get_where('business_profile', array('user_id' => $userid))->row()->business_profile_id;
        $description = $business_post;
        $profile = $business_profile;


         $return_html = '';
        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($business_profile1);
        }
       // echo "<pre>";  print_r(count($business_profile1)); die();
        // $return_html .= '<input type = "hidden" class = "page_number" value = "' . $page . '" />';
        // $return_html .= '<input type = "hidden" class = "total_record" value = "' . $_GET["total_record"] . '" />';
        // $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';


//$this->load->view('business_profile/recommen_business', $this->data);
//AJAX DATA
        //$return_html = '';
        if (count($profile) > 0 || count($description) > 0) {
            if ($profile) {

                
               // if($page  == 1){

                $return_html .= '<div class="profile-job-post-title-inside clearfix" style="">';
                $return_html .= '<div class="profile_search" style="background-color: white; margin-bottom: 10px; margin-top: 10px;"><h4 class="search_head">Profiles</h4><div class="inner_search">';

                            // }
                                                        
                foreach ($profile as $p) {
                    $return_html .= '<div class="profile-job-profile-button clearfix box_search_module">
                                                                    <div class="profile-job-post-location-name-rec">
                                                                        <div class="module_Ssearch" style="display: inline-block; float: left;">
                                                                            <div class="search_img" style="height: 110px; width: 108px;" >
                                                                                <a style=" " href="' . base_url('business-profile/dashboard/' . $p['business_slug']) . '" title="">';
                    if ($p['business_user_image'] != '') {
                        $return_html .= '<img src="' . BUS_PROFILE_MAIN_UPLOAD_URL . $p['business_user_image'] . '" alt="" > </a>';
                    } else {
                        $return_html .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="">
                                                                                    </a>';
                    }
                    $return_html .= '</div>
                                                                        </div>
                                                                        <div class="designation_rec">
                                                                            <ul>
                                                                                <li style="padding-top: 0px;">
                                                                                    <a  class="main_search_head" href="' . base_url('business-profile/dashboard/' . $p['business_slug']) . '" title="' . ucfirst(strtolower($p['company_name'])) . '">' . ucfirst(strtolower($p['company_name'])) . '</a>
                                                                                </li>
                                                                                <li style="display: block;">
                                                                                    <a  class="color-search" s title="">';

                    $cache_time = $this->db->get_where('industry_type', array('industry_id' => $p['industriyal']))->row()->industry_name;
                    if ($cache_time != '') {
                        $return_html .= $cache_time;
                    } else {
                        $return_html .= ucfirst($p['other_industrial']);
                    }
                    $return_html .= '</a>
                                                                                </li>
                                                                                <li style="display: block;">
                                                                                    <a title="" class="color-search">';

                    $cache_time = $this->db->get_where('business_type', array('type_id' => $p['business_type']))->row()->business_name;
                    if ($cache_time != '') {
                        $return_html .= $cache_time;
                    } else {
                        $return_html .= ucfirst($p['other_business_type']);
                    }
                    $return_html .= '</a>
                                                                                </li>
                                                                                <li style="display: block;">
                                                                                    <a title="" class="color-search">';

                    $cityname = $this->db->get_where('cities', array('city_id' => $p['city']))->row()->city_name;
                    $countryname = $this->db->get_where('countries', array('country_id' => $p['country']))->row()->country_name;
                    if ($cityname || $countryname) {
                        if ($cityname) {
                            $return_html .= $cityname;
                            $return_html .= ', ';
                        }
                        $return_html .= $countryname;
                    }

                    $return_html .= '</a>
                                                                                </li>
                                                                                <li style="display: block;">
                                                                                    <a title="" class="color-search websir-se" href="' . $p['contact_website'] . '" target="_blank">' . $p['contact_website'] . '</a>
                                                                                </li>
                                                                                <input type="hidden" name="search" id="search" value="' . $keyword . '">
                                                                            </ul>
                                                                        </div>';
                    $userid = $this->session->userdata('aileenuser');
                    if ($p['user_id'] != $userid) {
                        $return_html .= '<div class="fl search_button">
                                                                                <div class="fruser' . $p['business_profile_id'] . '">';
                        $status = $this->db->get_where('follow', array('follow_type' => '2', 'follow_from' => $main_business_profile_id, 'follow_to' => $p['business_profile_id']))->row()->follow_status;
                        if (($status == 0 || $status == " ") && ($is_business)) {
                            $return_html .= '<div id= "followdiv " class="user_btn">
                                                                                            <button id="follow' . $p['business_profile_id'] . '" onClick="followuser_two(' . $p['business_profile_id'] . ')">
                                                                                                Follow 
                                                                                            </button>
                                                                                        </div>';
                        } elseif ($status == 1 && $is_business) {
                            $return_html .= '<div id= "unfollowdiv"  class="user_btn" > 
                                                                                            <button class="bg_following" id="unfollow' . $p['business_profile_id'] . '" onClick="unfollowuser_two(' . $p['business_profile_id'] . ')">
                                                                                                Following 
                                                                                            </button>
                                                                                        </div>';
                        }
                        if ($is_business) {
                            $return_html .= '</div>
                                                                                <a href="' . base_url('chat/abc/5/5/' . $p['user_id']) . '"><button onclick="window.location.href = ' . base_url('chat/abc/5/5/' . $p['user_id']) . '"> Message</button></a>
                                                                            </div>';
                        }
                    }

                     //if($page  == 1){
                    $return_html .= '</div></div>';
                   // }
                }
            }
            $return_html .= '</div>
                                                </div>';
            if ($description) {
                $return_html .= '<div class="col-md-12 profile_search " style="float: left; background-color: white; margin-top: 10px; margin-bottom: 10px; padding:0px!important;">
                                                        <h4 class="search_head">Posts</h4>
                                                        <div class="inner_search search inner_search_2" style="float: left;">';
                foreach ($description as $p) {
                    if (($p['product_description']) || ($p['product_name'])) {

                        $post_business_user_image = $p['business_user_image'];
                        $post_company_name = $p['company_name'];
                        $post_business_profile_post_id = $p['business_profile_post_id'];
                        $post_product_name = $p['product_name'];
                        $post_product_image = $p['product_image'];
                        $post_product_description = $p['product_description'];
                        $post_business_likes_count = $p['business_likes_count'];
                        $post_business_like_user = $p['business_like_user'];
                        $post_created_date = $p['created_date'];
                        $post_posted_user_id = $p['posted_user_id'];
                        $post_business_slug = $p['business_slug'];
                        $post_industriyal = $p['industriyal'];
                        $post_user_id = $p['user_id'];
                        $post_category = $this->db->get_where('industry_type', array('industry_id' => $post_industriyal, 'status' => '1'))->row()->industry_name;
                        $post_other_industrial = $p['other_industrial'];

                        if ($post_posted_user_id) {
                            $posted_company_name = $this->db->get_where('business_profile', array('user_id' => $post_posted_user_id))->row()->company_name;
                            $posted_business_slug = $this->db->get_where('business_profile', array('user_id' => $post_posted_user_id, 'status' => '1'))->row()->business_slug;
                            $posted_category = $this->db->get_where('industry_type', array('industry_id' => $post_industriyal, 'status' => '1'))->row()->industry_name;
                            $posted_business_user_image = $this->db->get_where('business_profile', array('user_id' => $post_posted_user_id))->row()->business_user_image;
                        }

                        $return_html .= '<div id = "removepost' . $post_business_profile_post_id . '">
                        <div class = "col-md-12 col-sm-12 post-design-box">
                            <div class = "post_radius_box">
                                <div class = "post-design-top col-md-12" >
                            <div class = "post-design-pro-img">
                                <div id = "popup1" class = "overlay">
                                    <div class = "popup">
                                        <div class = "pop_content">
                                            Your Post is Successfully Saved.
                                            <p class = "okk">
                                                <a class = "okbtn" href = "#">Ok</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>';

                        if ($post_posted_user_id) {
                            if ($posted_business_user_image) {
                                $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $posted_business_slug) . '">';
                                $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $posted_business_user_image . '" name = "image_src" id = "image_src" />';
                                $return_html .= '</a>';
                            } else {
                                $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $posted_business_slug) . '">';
                                $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "No Image">';
                                $return_html .= '</a>';
                            }
                        } else {
                            if ($post_business_user_image) {
                                $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $post_business_slug) . '">';
                                $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $post_business_user_image . '" alt = "No Image1">';
                                $return_html .= '</a>';
                            } else {
                                $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $post_business_slug) . '">';
                                $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "No Image2">';
                                $return_html .= '</a>';
                            }
                        }
                        $return_html .= '</div>
                        <div class = "post-design-name fl col-xs-8 col-md-10">
                    <ul>';

                        $return_html .= '<li></li>';

                        if ($post_posted_user_id) {
                            $return_html .= '<li>
                            <div class = "else_post_d">
                                <div class = "post-design-product">
                                    <a class = "post_dot" href = "' . base_url('business-profile/dashboard/' . $posted_business_slug) . '">' . ucfirst(strtolower($posted_company_name)) . '</a>
<p class = "posted_with" > Posted With</p> <a class = "other_name name_business post_dot" href = "' . base_url('business-profile/dashboard/' . $post_business_slug) . '">' . ucfirst(strtolower($post_company_name)) . '</a>
<span role = "presentation" aria-hidden = "true"> · </span> <span class = "ctre_date">
' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($post_created_date))) . '
</span> </div></div>
</li>';
                        } else {
                            $return_html .= '<li>
                            <div class = "post-design-product">
                                <a class = "post_dot" href = "' . base_url('business-profile/dashboard/' . $post_business_slug) . '" title = "' . ucfirst(strtolower($post_company_name)) . '">
' . ucfirst(strtolower($post_company_name)) . '</a>
                    <span role = "presentation" aria-hidden = "true"> · </span>
<div class = "datespan"> <span class = "ctre_date" >
' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($post_created_date))) . '

</span></div>

</div>
</li>';
                        }

                        $return_html .= '<li>
<div class = "post-design-product">
<a class = "buuis_desc_a" href = "javascript:void(0);" title = "Category">';
                        if ($post_industriyal) {
                            $return_html .= ucfirst(strtolower($post_category));
                        } else {
                            $return_html .= ucfirst(strtolower($post_other_industrial));
                        }

                        $return_html .= '</a>
</div>
</li>

<li>
</li>
</ul>
</div>
<div class = "dropdown1">
<a onClick = "myFunction1(' . $post_business_profile_post_id . ')" class = "dropbtn_common  dropbtn1 fa fa-ellipsis-v">
</a>
<div id = "myDropdown' . $post_business_profile_post_id . '" class = "dropdown-content1 dropdown2_content">';

                        if ($post_posted_user_id != 0) {

                            if ($userid == $post_posted_user_id) {

                                $return_html .= '<a onclick = "user_postdelete(' . $post_business_profile_post_id . ')">
<i class = "fa fa-trash-o" aria-hidden = "true">
</i> Delete Post
</a>
<a id = "' . $post_business_profile_post_id . '" onClick = "editpost(this.id)">
<i class = "fa fa-pencil-square-o" aria-hidden = "true">
</i>Edit
</a>';
                            } else {

                                $return_html .= '<a onclick = "user_postdelete(' . $post_business_profile_post_id . ')">
<i class = "fa fa-trash-o" aria-hidden = "true">
</i> Delete Post
</a>';
                            }
                        } else {
                            if ($userid == $post_user_id) {
                                $return_html .= '<a onclick = "user_postdelete(' . $post_business_profile_post_id . ')">
<i class = "fa fa-trash-o" aria-hidden = "true">
</i> Delete Post
</a>
<a id = "' . $post_business_profile_post_id . '" onClick = "editpost(this.id)">
<i class = "fa fa-pencil-square-o" aria-hidden = "true">
</i>Edit
</a>';
                            } else {

                                $return_html .= '<a onclick = "user_postdeleteparticular(' . $post_business_profile_post_id . ')">
<i class = "fa fa-trash-o" aria-hidden = "true">
</i> Delete Post
</a>';
                            }
                        }

                        $return_html .= '</div>
</div>
<div class = "post-design-desc">
<div class = "ft-15 t_artd">
<div id = "editpostdata' . $post_business_profile_post_id . '" style = "display:block;">
<a>' . $this->common->make_links($post_product_name) . '</a>
</div>
<div id = "editpostbox' . $post_business_profile_post_id . '" style = "display:none;">


<input type = "text" class="productpostname" id = "editpostname' . $post_business_profile_post_id . '" name = "editpostname" placeholder = "Product Name" value = "' . $post_product_name . '" tabindex="' . $post_business_profile_post_id . '" onKeyDown = check_lengthedit(' . $post_business_profile_post_id . ');
onKeyup = check_lengthedit(' . $post_business_profile_post_id . ');
onblur = check_lengthedit(' . $post_business_profile_post_id . ');
>';

                        if ($post_product_name) {
                            $counter = $post_product_name;
                            $a = strlen($counter);

                            $return_html .= '<input size = 1 id = "text_num_' . $post_business_profile_post_id . '" class = "text_num" value = "' . (50 - $a) . '" name = text_num disabled>';
                        } else {
                            $return_html .= '<input size = 1 id = "text_num_' . $post_business_profile_post_id . '" class = "text_num" value = 50 name = text_num disabled>';
                        }
                        $return_html .= '</div>

</div>
<div id = "khyati' . $post_business_profile_post_id . '" style = "display:block;">';

                        $small = substr($post_product_description, 0, 180);
                        $return_html .= nl2br($this->common->make_links($small));
                        if (strlen($post_product_description) > 180) {
                            $return_html .= '... <span id = "kkkk" onClick = "khdiv(' . $post_business_profile_post_id . ')">View More</span>';
                        }

                        $return_html .= '</div>
<div id = "khyatii' . $post_business_profile_post_id . '" style = "display:none;">
' . $post_product_description . '</div>
<div id = "editpostdetailbox' . $post_business_profile_post_id . '" style = "display:none;">
<div contenteditable = "true" id = "editpostdesc' . $post_business_profile_post_id . '" class = "textbuis editable_text margin_btm" name = "editpostdesc" placeholder = "Description" tabindex="' . ($post_business_profile_post_id + 1) . '" onpaste = "OnPaste_StripFormatting(this, event);" onfocus="cursorpointer(' . $post_business_profile_post_id . ')">' . $post_product_description . '</div>
</div>
<div id = "editpostdetailbox' . $post_business_profile_post_id . '" style = "display:none;">
<div contenteditable = "true" id = "editpostdesc' . $post_business_profile_post_id . '" placeholder = "Product Description" class = "textbuis  editable_text" name = "editpostdesc" onpaste = "OnPaste_StripFormatting(this, event);">' . $post_product_description . '</div>
</div>
<button class = "fr" id = "editpostsubmit' . $post_business_profile_post_id . '" style = "display:none;margin: 5px 0; border-radius: 3px;" onClick = "edit_postinsert(' . $post_business_profile_post_id . ')">Save
</button>
</div>
</div>
<div class = "post-design-mid col-md-12 padding_adust" >
<div>';

                        $contition_array = array('post_id' => $post_business_profile_post_id, 'is_deleted' => '1', 'insert_profile' => '2');
                        $businessmultiimage = $this->common->select_data_by_condition('post_files', $contition_array, $data = 'file_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                        if (count($businessmultiimage) == 1) {

                            $allowed = array('jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg');
//$allowed = VALID_IMAGE;
                            $allowespdf = array('pdf');
                            $allowesvideo = array('mp4', 'webm', 'qt', 'mov', 'MP4');
                            $allowesaudio = array('mp3');
                            $filename = $businessmultiimage[0]['file_name'];
                            $ext = pathinfo($filename, PATHINFO_EXTENSION);
                            if (in_array($ext, $allowed)) {

                                $return_html .= '<div class = "one-image">';

                                $return_html .= '<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '">
</a>
</div>';
                            } elseif (in_array($ext, $allowespdf)) {

//                                 $return_html .= '<div>
// <a title = "click to open" href = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '"><div class = "pdf_img">
//     <embed src="' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" width="100%" height="450px" />
// </div>
// </a>
// </div>';


                                $return_html .= '<div>
<a title = "click to open" href = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" target="_blank"><div class = "pdf_img">
    <img src="' . base_url('assets/images/PDF.jpg') . '?ver=' . time() . '" alt="PDF.jpg">
</div>
</a>
</div>';
                            } elseif (in_array($ext, $allowesvideo)) {

                                $return_html .= '<div>
<video width = "100%" height = "350" controls>
<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" type = "video/mp4">
<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" type = "video/ogg">
Your browser does not support the video tag.
</video>
</div>';
                            } elseif (in_array($ext, $allowesaudio)) {

                                $return_html .= '<div class = "audio_main_div">
<div class = "audio_img">
<img src = "' . base_url('assets/images/music-icon.png') . '">
</div>
<div class = "audio_source">
<audio id = "audio_player" width = "100%" height = "100" controls>
<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" type = "audio/mp3">
<source src = "movie.ogg" type = "audio/ogg">
Your browser does not support the audio tag.
</audio>
</div>
<div class = "audio_mp3" id = "' . "postname" . $post_business_profile_post_id . '">
<p title = "' . $post_product_name . '">' . $post_product_name . '</p>
</div>
</div>';
                            }
                        } elseif (count($businessmultiimage) == 2) {

                            foreach ($businessmultiimage as $multiimage) {

                                $return_html .= '<div class = "two-images">
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img class = "two-columns" src = "' . BUS_POST_RESIZE1_UPLOAD_URL . $multiimage['file_name'] . '">
</a>
</div>';
                            }
                        } elseif (count($businessmultiimage) == 3) {

                            $return_html .= '<div class = "three-image-top" >
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img class = "three-columns" src = "' . BUS_POST_RESIZE4_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '">
</a>
</div>
<div class = "three-image" >

<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img class = "three-columns" src = "' . BUS_POST_RESIZE1_UPLOAD_URL . $businessmultiimage[1]['file_name'] . '">
</a>
</div>
<div class = "three-image" >
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img class = "three-columns" src = "' . BUS_POST_RESIZE1_UPLOAD_URL . $businessmultiimage[2]['file_name'] . '">
</a>
</div>';
                        } elseif (count($businessmultiimage) == 4) {

                            foreach ($businessmultiimage as $multiimage) {

                                $return_html .= '<div class = "four-image">
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img class = "breakpoint" src = "' . BUS_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name'] . '">
</a>
</div>';
                            }
                        } elseif (count($businessmultiimage) > 4) {

                            $i = 0;
                            foreach ($businessmultiimage as $multiimage) {

                                $return_html .= '<div class = "four-image">
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img src = "' . BUS_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name'] . '">
</a>
</div>';

                                $i++;
                                if ($i == 3)
                                    break;
                            }

                            $return_html .= '<div class = "four-image">
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img src = "' . BUS_POST_RESIZE2_UPLOAD_URL . $businessmultiimage[3]['file_name'] . '">
</a>
<a class = "text-center" href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<div class = "more-image" >
<span>View All (+
' . (count($businessmultiimage) - 4) . ')</span>

</div>

</a>
</div>';
                        }
                        $return_html .= '<div>
</div>
</div>
</div>
<div class = "post-design-like-box col-md-12">
<div class = "post-design-menu">
<ul class = "col-md-6 col-sm-6 col-xs-6">
<li class = "likepost' . $post_business_profile_post_id . '">
<a id = "' . $post_business_profile_post_id . '" class = "ripple like_h_w" onClick = "post_like(this.id)">';

                        $likeuser = $post_business_like_user;
                        $likeuserarray = explode(',', $likeuser);
                        if (!in_array($userid, $likeuserarray)) {

                            $return_html .= '<i class = "fa fa-thumbs-up fa-1x" aria-hidden = "true"></i>';
                        } else {
                            $return_html .= '<i class = "fa fa-thumbs-up fa-1x main_color" aria-hidden = "true"></i>';
                        }
                        $return_html .= '<span class = "like_As_count">';

                        if ($post_business_likes_count > 0) {
                            $return_html .= $post_business_likes_count;
                        }

                        $return_html .= '</span>
</a>
</li>
<li id = "insertcount' . $post_business_profile_post_id . '" style = "visibility:show">';

                        $contition_array = array('business_profile_post_id' => $post_business_profile_post_id, 'status' => '1', 'is_delete' => '0');
                        $commnetcount = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                        $return_html .= '<a onClick = "commentall(this.id)" id = "' . $post_business_profile_post_id . '" class = "ripple like_h_w">
<i class = "fa fa-comment-o" aria-hidden = "true">
</i>
</a>
</li>
</ul>
<ul class = "col-md-6 col-sm-6 col-xs-6 like_cmnt_count">
<li>
<div class = "like_count_ext">
<span class = "comment_count' . $post_business_profile_post_id . '" >';

                        if (count($commnetcount) > 0) {
                            $return_html .= count($commnetcount);
                            $return_html .= '<span> Comment</span>';
                        }
                        $return_html .= '</span>

</div>
</li>

<li>
<div class = "comnt_count_ext">
<span class = "comment_like_count' . $post_business_profile_post_id . '">';
                        if ($post_business_likes_count > 0) {
                            $return_html .= $post_business_likes_count;

                            $return_html .= '<span> Like</span>';
                        }
                        $return_html .= '</span>

</div></li>
</ul>
</div>
</div>';
                        if ($post_business_likes_count > 0) {

                            $return_html .= '<div class = "likeduserlist' . $post_business_profile_post_id . '">';

                            $likeuser = $post_business_like_user;
                            $countlike = $post_business_likes_count - 1;
                            $likelistarray = explode(',', $likeuser);
//                    foreach ($likelistarray as $key => $value) {
//                        $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
//                    }

                            $return_html .= '<a href = "javascript:void(0);" onclick = "likeuserlist(' . $post_business_profile_post_id . ')">';
                            $return_html .= '<div class = "like_one_other">';

                            /* if ($userid == $value) {
                              $return_html .= "You";
                              $return_html .= "&nbsp;";
                              } */

                            $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $likelistarray[0], 'status' => '1'))->row()->company_name;

                            if (in_array($userid, $likelistarray)) {
                                $return_html .= "You";
                                $return_html .= "&nbsp;";
                            } else {
                                $return_html .= ucfirst(strtolower($business_fname1));
                                $return_html .= "&nbsp;";
                            }
//                    echo count($likelistarray);
                            if (count($likelistarray) > 1) {
                                $return_html .= " and ";

                                $return_html .= $countlike;
                                $return_html .= "&nbsp;";
                                $return_html .= "others";
                            }
                            $return_html .= '</div>
</a>
</div>';
                        }

                        $return_html .= '<div class = "likeusername' . $post_business_profile_post_id . '" id = "likeusername' . $post_business_profile_post_id . '" style = "display:none">';

                        $likeuser = $post_business_like_user;
                        $countlike = $post_business_likes_count - 1;
                        $likelistarray = explode(', ', $likeuser);
//                foreach ($likelistarray as $key => $value) {
//                    $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
//                }
                        $return_html .= '<a href = "javascript:void(0);" onclick = "likeuserlist(' . $post_business_profile_post_id . ')">';

                        $likeuser = $post_business_like_user;
                        $countlike = $post_business_likes_count - 1;
                        $likelistarray = explode(', ', $likeuser);

                        $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => '1'))->row()->company_name;

                        $return_html .= '<div class = "like_one_other">';

                        $return_html .= ucfirst(strtolower($business_fname1));
                        $return_html .= "&nbsp;";

                        if (count($likelistarray) > 1) {

                            $return_html .= "and";

                            $return_html .= $countlike;
                            $return_html .= "&nbsp;";
                            $return_html .= "others";
                        }
                        $return_html .= '</div>
</a>
</div>

<div class = "art-all-comment col-md-12">
<div id = "fourcomment' . $post_business_profile_post_id . '" style = "display:none;">
</div>
<div id = "threecomment' . $post_business_profile_post_id . '" style = "display:block">
<div class = "insertcomment' . $post_business_profile_post_id . '">';

                        $contition_array = array('business_profile_post_id' => $post_business_profile_post_id, 'status' => '1');
                        $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = 'business_profile_post_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');
                        if ($businessprofiledata) {
                            foreach ($businessprofiledata as $rowdata) {
                                $companyname = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id']))->row()->company_name;

                                $slugname1 = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id'], 'status' => '1'))->row()->business_slug;

                                $return_html .= '<div class = "all-comment-comment-box">
<div class = "post-design-pro-comment-img">';
                                $business_userimage = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id'], 'status' => '1'))->row()->business_user_image;

                                if ($business_userimage) {
                                    $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $slugname1) . '">';

                                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {

                                        $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "">';
                                    } else {
                                        $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt = "">';
                                    }
                                    $return_html .= '</a>';
                                } else {
                                    $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $slugname1) . '">';

                                    $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = ""></a>';
                                }
                                $return_html .= '</div>
<div class = "comment-name"><a href="' . base_url() . 'business-profile/dashboard/' . $slugname1 . '">
<b title = "' . $companyname . '">';
                                $return_html .= $companyname;
                                $return_html .= '</br>';

                                $return_html .= '</b></a>
</div>
<div class = "comment-details" id = "showcomment' . $rowdata['business_profile_post_comment_id'] . '">';

                                $return_html .= '<div id = "lessmore' . $rowdata['business_profile_post_comment_id'] . '" style = "display:block;">';
                                $small = substr($rowdata['comments'], 0, 180);
                                $return_html .= nl2br($this->common->make_links($small));

                                if (strlen($rowdata['comments']) > 180) {
                                    $return_html .= '... <span id = "kkkk" onClick = "seemorediv(' . $rowdata['business_profile_post_comment_id'] . ')">See More</span>';
                                }
                                $return_html .= '</div>';
                                $return_html .= '<div id = "seemore' . $rowdata['business_profile_post_comment_id'] . '" style = "display:none;">';
                                $new_product_comment = $this->common->make_links($rowdata['comments']);
                                $return_html .= nl2br(htmlspecialchars_decode(htmlentities($new_product_comment, ENT_QUOTES, 'UTF-8')));
                                $return_html .= '</div>';
                                $return_html .= '</div>
<div class = "edit-comment-box">
<div class = "inputtype-edit-comment">
<div contenteditable = "true" class = "editable_text editav_2" name = "' . $rowdata['business_profile_post_comment_id'] . '" id = "editcomment' . $rowdata['business_profile_post_comment_id'] . '" placeholder = "Enter Your Comment " value = "" onkeyup = "commentedit(' . $rowdata['business_profile_post_comment_id'] . ')" onpaste = "OnPaste_StripFormatting(this, event);">' . $rowdata['comments'] . '</div>
<span class = "comment-edit-button"><button id = "editsubmit' . $rowdata['business_profile_post_comment_id'] . '" style = "display:none" onClick = "edit_comment(' . $rowdata['business_profile_post_comment_id'] . ')">Save</button></span>
</div>
</div>
<div class = "art-comment-menu-design">
<div class = "comment-details-menu" id = "likecomment1' . $rowdata['business_profile_post_comment_id'] . '">
<a id = "' . $rowdata['business_profile_post_comment_id'] . '" onClick = "comment_like1(this.id)">';

                                $userid = $this->session->userdata('aileenuser');
                                $contition_array = array('business_profile_post_comment_id' => $rowdata['business_profile_post_comment_id'], 'status' => '1');
                                $businesscommentlike = $this->data['businesscommentlike'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                $likeuserarray = explode(', ', $businesscommentlike[0]['business_comment_like_user']);
                                if (!in_array($userid, $likeuserarray)) {

                                    $return_html .= '<i class = "fa fa-thumbs-up" style = "color: #999;" aria-hidden = "true"></i>';
                                } else {
                                    $return_html .= '<i class = "fa fa-thumbs-up main_color" aria-hidden = "true">
</i>';
                                }
                                $return_html .= '<span>';

                                if ($rowdata['business_comment_likes_count']) {
                                    $return_html .= $rowdata['business_comment_likes_count'];
                                }

                                $return_html .= '</span></a></div>';
                                $userid = $this->session->userdata('aileenuser');
                                if ($rowdata['user_id'] == $userid) {

                                    $return_html .= '<span role = "presentation" aria-hidden = "true"> ·
</span>
<div class = "comment-details-menu">
<div id = "editcommentbox' . $rowdata['business_profile_post_comment_id'] . '" style = "display:block;">
<a id = "' . $rowdata['business_profile_post_comment_id'] . '" onClick = "comment_editbox(this.id)" class = "editbox">Edit
</a>
</div>
<div id = "editcancle' . $rowdata['business_profile_post_comment_id'] . '" style = "display:none;">
<a id = "' . $rowdata['business_profile_post_comment_id'] . '" onClick = "comment_editcancle(this.id)">Cancel
</a>
</div>
</div>';
                                }
                                $userid = $this->session->userdata('aileenuser');
                                $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $rowdata['business_profile_post_id'], 'status' => 1))->row()->user_id;
                                if ($rowdata['user_id'] == $userid || $business_userid == $userid) {

                                    $return_html .= '<span role = "presentation" aria-hidden = "true"> ·
</span>
<div class = "comment-details-menu">
<input type = "hidden" name = "post_delete" id = "post_delete' . $rowdata['business_profile_post_comment_id'] . '" value = "' . $rowdata['business_profile_post_id'] . '">
<a id = "' . $rowdata['business_profile_post_comment_id'] . '" onClick = "comment_delete(this.id)"> Delete
<span class = "insertcomment' . $rowdata['business_profile_post_comment_id'] . '">
</span>
</a>
</div>';
                                }
                                $return_html .= '<span role = "presentation" aria-hidden = "true"> ·
</span>
<div class = "comment-details-menu">
<p>';

                                $return_html .= $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($rowdata['created_date'])));
                                $return_html .= '</br>';

                                $return_html .= '</p>
</div>
</div>
</div>';
                            }
                        }
                        $return_html .= '</div>
</div>
</div>
<div class = "post-design-commnet-box col-md-12">
<div class = "post-design-proo-img hidden-mob">';

                        $userid = $this->session->userdata('aileenuser');
                        $business_userimage = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->business_user_image;
                        if ($business_userimage) {

                            if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {


                                $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "">';
                            } else {
                                $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt = "">';
                            }
                        } else {


                            $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "">';
                        }
                        $return_html .= '</div>

<div id = "content" class = "col-md-12  inputtype-comment cmy_2" >
<div contenteditable = "true" class = "edt_2 editable_text" name = "' . $post_business_profile_post_id . '" id = "post_comment' . $post_business_profile_post_id . '" placeholder = "Add a Comment ..." onClick = "entercomment(' . $post_business_profile_post_id . ')" onpaste = "OnPaste_StripFormatting(this, event);"></div>
<div class="mob-comment">       
                            <button id="' . $post_business_profile_post_id . '" onClick="insert_comment(this.id)"><img src="' . base_url('assets/img/send.png') . '">
                            </button>
                        </div>
</div>
' . form_error('post_comment') . '
<div class = "comment-edit-butn hidden-mob">
<button id = "' . $post_business_profile_post_id . '" onClick = "insert_comment(this.id)">Comment
</button>
</div>

</div>
</div>
</div></div>';
                    }
                }
            }
        } else {
            $return_html .= '<div class="text-center rio">
                <h1 class="page-heading  product-listing" style="border:0px;margin-bottom: 11px;">Oops No Data Found.</h1>
                <p style="text-transform:none !important;border:0px;margin-left:4%;">We couldn\'t find what you were looking for.</p>
                <ul class=" ">
                    <li style="text-transform:none !important; list-style: none;">Make sure you used the right keywords.</li>
                </ul>
            </div>';
        }
        echo $return_html;
    }


//freelancer hire search start
    public function freelancer_hire_index() {
        $user_id = $this->session->userdata('user_id');
        $this->load->view('freelancer_hire/freelancer_hire_search', $this->data);
    }

    public function freelancer_hire_search($searchkeyword = "", $searchplace = "") {

        $userid = $this->session->userdata('aileenuser');

        $searchkeyword = trim($this->input->get('skills'));
        $searchplace = trim($this->input->get('searchplace'));



        if ($searchplace == "" && $searchkeyword == "") {
            $searchkeyword = $this->uri->segment(3);
            $searchplace = $this->uri->segment(4);
            if ($searchkeyword == 0) {
                $searchkeyword == '';
            } elseif ($searchplace == 0) {
                $searchplace == '';
            }
            if ($searchplace == "" && $searchkeyword == "") {
                redirect('freelancer/recommen_candidate', refresh);
            }
        }
        $search_skill = $searchkeyword;
        $this->data['keyword'] = $search_skill;

        $search_place = $searchplace;
        $cache_time = $this->db->get_where('cities', array('city_name' => $search_place))->row()->city_id;
        $this->data['keyword1'] = $search_place;
        if ($userid) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $this->data['city'] = $city = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'city', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $data = array(
                'search_keyword' => $search_skill,
                'search_location' => $search_place,
                'user_location' => $city[0]['city'],
                'user_id' => $userid,
                'created_date' => date('Y-m-d h:i:s', time()),
                'status' => '1',
                'module' => '3'
            );

            $insert_id = $this->common->insert_data_getid($data, 'search_info');
        }

        $title = '';
        if ($searchkeyword && $search_place) {
            $title = $searchkeyword . ' in ' . $search_place;
        } elseif ($searchkeyword) {
            $title = $searchkeyword;
        } elseif ($search_place) {
            $title = $search_place;
        }
        $this->data['title'] = $title . " | Employer Profile - Aileensoul";
        $this->data['head'] = $this->load->view('head', $this->data, TRUE);
//THIS CODE IS FOR WHEN USER NOT LOGIN AND GET SEARCH DATA START
        if ($this->session->userdata('aileenuser')) {
            $userid = $this->session->userdata('aileenuser');
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1', 'free_hire_step' => '3');
            $free_hire_result = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'reg_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if ($free_hire_result) {
                $this->load->view('freelancer/freelancer_hire/recommen_freelancer_hire', $this->data);
            } else {
                $this->load->view('freelancer/freelancer_hire/hire_search', $this->data);
            }
        } else {
// $this->data['business_common_profile'] = $this->load->view('business_profile/business_common_profile', $this->data, true);
            $this->load->view('freelancer/freelancer_hire/hire_search', $this->data);
        }


// $this->load->view('freelancer/freelancer_hire/recommen_freelancer_hire', $this->data);
    }

//freelancer hire  search end 
//freelancer hire  ajax search start 
    public function ajax_freelancer_hire_search($searchkeyword = "", $searchplace = "") {
// echo "rrrrr";die();

        $userid = $this->session->userdata('aileenuser');

        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;
// echo $this->input->get('skills');

        $searchkeyword = $_GET["skill"];
        $searchplace = $_GET["place"];

        $search_skill = $searchkeyword;
        $search_place = $searchplace;


        $cache_time = $this->db->get_where('cities', array('city_name' => $search_place))->row()->city_id;

        if ($searchkeyword == "" || $this->uri->segment(3) == "0") {
            $contition_array = array('freelancer_post_city' => $cache_time, 'status' => '1', 'freelancer_post_reg.user_id !=' => $userid, 'free_post_step' => '7', 'is_delete' => '0');
            $unique = $this->data['results'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } elseif ($searchplace == "" || $this->uri->segment(4) == "0") {
//  echo "4444";die();
//echo $search_skill;die();
            $contition_array = array('status' => '1');
            $search_condition = "(skill LIKE '%$search_skill%')";
            $skillid = $this->common->select_data_by_search('skill', $search_condition, $contition_array, $data = 'skill_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
//            $values = array_map('array_pop', $skillid);
//            $imploded = implode(',', $values);
//            //echo $imploded;
//             $search  = "freelancer_post_area IN (".$imploded.")";
//    $this->db->where($search);
//    $result = $this->db->get('freelancer_post_reg')->result_array();
//    echo count($result);die();
//        
//echo '<pre>'; print_r($skillid); die();
            foreach ($skillid as $key => $value) {
                $contition_array = array('status' => '1', 'is_delete' => '0', 'free_post_step' => '7', 'user_id != ' => $userid, 'FIND_IN_SET("' . $value['skill_id'] . '", freelancer_post_area) != ' => '0');
                $candidate[] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_fullname, freelancer_post_username,freelancer_post_country, freelancer_post_city, freelancer_post_area,freelancer_post_field, freelancer_post_skill_description, freelancer_post_hourly, freelancer_post_ratestate, freelancer_post_fixed_rate, freelancer_post_work_hour, user_id, freelancer_post_user_image, designation, freelancer_post_otherskill, freelancer_post_exp_month, freelancer_post_exp_year,freelancer_apply_slug,freelancer_post_reg_id', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            }
//             echo "<pre>"; print_r($candidate); die();
            $candidate = array_reduce($candidate, 'array_merge', array());
// echo "<pre>"; print_r($candidate); die();
//            $candidate = array_unique($candidate, SORT_REGULAR);
//             echo "<pre>"; print_r($candidate); die();
// echo count($candidate);die();
//            $temp = $this->db->get_where('skill', array('skill' => $search_skill, 'status' => 1))->row()->skill_id;
//            $contition_array = array('status' => '1', 'is_delete' => '0', 'free_post_step' => 7, 'user_id != ' => $userid, 'FIND_IN_SET("' . $temp . '", freelancer_post_area) != ' => '0');
//            $candidate = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_fullname, freelancer_post_username, freelancer_post_city, freelancer_post_area, freelancer_post_skill_description, freelancer_post_hourly, freelancer_post_ratestate, freelancer_post_fixed_rate, freelancer_post_work_hour, user_id, freelancer_post_user_image, designation, freelancer_post_otherskill, freelancer_post_exp_month, freelancer_post_exp_year,freelancer_apply_slug', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
//            
            $category_temp = $this->db->get_where('category', array('category_name' => $search_skill, 'status' => '1'))->row()->category_id;

            $contition_array = array('freelancer_post_field' => $category_temp, 'user_id !=' => $userid, 'free_post_step' => '7', 'status' => '1');
            $fieldfound = $this->data['field'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_fullname, freelancer_post_username, freelancer_post_city, freelancer_post_area,freelancer_post_field, freelancer_post_skill_description, freelancer_post_hourly, freelancer_post_ratestate, freelancer_post_fixed_rate, freelancer_post_work_hour, user_id, freelancer_post_user_image, designation, freelancer_post_otherskill, freelancer_post_exp_month, freelancer_post_exp_year,freelancer_apply_slug,freelancer_post_reg_id,freelancer_post_country', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby);
//  echo "<pre>"; print_r($fieldfound); die();
            $contition_array = array('status' => '1', 'is_delete' => '0', 'user_id !=' => $userid, 'free_post_step' => '7');
            $search_condition = "(designation LIKE '%$search_skill%' or freelancer_post_otherskill LIKE '%$search_skill%' or freelancer_post_exp_month LIKE '%$search_skill%' or freelancer_post_exp_year LIKE '%$search_skill%')";
            $otherdata = $other['data'] = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'freelancer_post_fullname, freelancer_post_username, freelancer_post_city, freelancer_post_area,freelancer_post_field, freelancer_post_skill_description, freelancer_post_hourly, freelancer_post_ratestate, freelancer_post_fixed_rate, freelancer_post_work_hour, user_id, freelancer_post_user_image, designation, freelancer_post_otherskill, freelancer_post_exp_month, freelancer_post_exp_year,freelancer_apply_slug,freelancer_post_reg_id,freelancer_post_country', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
//  echo "<pre>"; print_r($otherdata); die();
            $new1 = array_merge((array) $candidate, (array) $fieldfound, (array) $otherdata);

//  echo "<pre>"; print_r($new1); die();
            $unique = array();
            foreach ($new1 as $value) {
                $unique[$value['freelancer_post_reg_id']] = $value;
            }
        } else {
//   echo "Both";

            $temp = $this->db->get_where('skill', array('skill' => $search_skill, 'status' => '1'))->row()->skill_id;
            $contition_array = array('status' => '1', 'is_delete' => '0', 'freelancer_post_city' => $cache_time, 'free_post_step' => '7', 'user_id != ' => $userid, 'FIND_IN_SET("' . $temp . '", freelancer_post_area) != ' => '0');
            $candidate = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_fullname, freelancer_post_username, freelancer_post_city,freelancer_post_country, freelancer_post_area,freelancer_post_field, freelancer_post_skill_description, freelancer_post_hourly, freelancer_post_ratestate, freelancer_post_fixed_rate, freelancer_post_work_hour, user_id, freelancer_post_user_image, designation, freelancer_post_otherskill, freelancer_post_exp_month, freelancer_post_exp_year,freelancer_apply_slug,freelancer_post_reg_id', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            $category_temp = $this->db->get_where('category', array('category_name' => $search_skill, 'status' => '1'))->row()->category_id;

            $contition_array = array('freelancer_post_field' => $category_temp, 'user_id !=' => $userid, 'free_post_step' => '7', 'status' => '1', 'freelancer_post_city' => $cache_time);
            $fieldfound = $this->data['field'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_fullname, freelancer_post_username, freelancer_post_city,freelancer_post_country, freelancer_post_area, freelancer_post_field,freelancer_post_skill_description, freelancer_post_hourly, freelancer_post_ratestate, freelancer_post_fixed_rate, freelancer_post_work_hour, user_id, freelancer_post_user_image, designation, freelancer_post_otherskill, freelancer_post_exp_month, freelancer_post_exp_year,freelancer_apply_slug,freelancer_post_reg_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby);

            $contition_array = array('status' => '1', 'is_delete' => '0', 'user_id !=' => $userid, 'free_post_step' => '7', 'freelancer_post_city' => $cache_time);
            $search_condition = "(designation LIKE '%$search_skill%' or freelancer_post_otherskill LIKE '%$search_skill%' or freelancer_post_exp_month LIKE '%$search_skill%' or freelancer_post_exp_year LIKE '%$search_skill%')";
            $otherdata = $other['data'] = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'freelancer_post_fullname, freelancer_post_username, freelancer_post_city,freelancer_post_country, freelancer_post_area,freelancer_post_field, freelancer_post_skill_description, freelancer_post_hourly, freelancer_post_ratestate, freelancer_post_fixed_rate, freelancer_post_work_hour, user_id, freelancer_post_user_image, designation, freelancer_post_otherskill, freelancer_post_exp_month, freelancer_post_exp_year,freelancer_apply_slug,freelancer_post_reg_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// $unique = array_merge($candidate, $fieldfound, $otherdata);
            $new1 = array_merge((array) $candidate, (array) $fieldfound, (array) $otherdata);

            $unique = array();
            foreach ($new1 as $value) {
                $unique[$value['freelancer_post_reg_id']] = $value;
            }
        }

        $return_html = '';
        $freelancerpostdata1 = array_slice($unique, $start, $perpage);

        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($unique);
        }
        $return_html .= '<input type = "hidden" class = "page_number" value = "' . $page . '" />';
        $return_html .= '<input type = "hidden" class = "total_record" value = "' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1', 'free_hire_step' => '3');
        $free_hire_result = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'reg_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if (count($unique) > 0) {
            foreach ($freelancerpostdata1 as $row) {
                $return_html .= '<div class="profile-job-post-detail clearfix search">
                                                        <div class="profile-job-post-title-inside clearfix">
                                                            <div class="profile-job-profile-button clearfix">
                                                                <div class="profile-job-post-location-name-rec">
                                                                    <div style="display: inline-block; float: left;">
                                                                        <div  class="buisness-profile-pic-candidate">';
                $post_fname = $row['freelancer_post_fullname'];
                $post_lname = $row['freelancer_post_username'];
                $sub_post_fname = substr($post_fname, 0, 1);
                $sub_post_lname = substr($post_lname, 0, 1);

                if ($row['freelancer_post_user_image']) {
                    if (IMAGEPATHFROM == 'upload') {
                        if (!file_exists($this->config->item('free_post_profile_main_upload_path') . $row['freelancer_post_user_image'])) {
                            if ($userid) {
                                if ($free_hire_result) {
                                    $return_html .= '<a href = "' . base_url('freelance-work/freelancer-details/' . $row['freelancer_apply_slug']) . '" title = "' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">';
                                } else {
                                    $return_html .= '<a href = "' . base_url('freelance-hire/registration') . '" title = "' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">';
                                }
                            } else {
                                $return_html .= '<a href = "javascript:void(0);" onclick="login_profile();" title = "' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">';
                            }
                            $return_html .= '<div class = "post-img-div">';
                            $return_html .= ucfirst(strtolower($sub_post_fname)) . ucfirst(strtolower($sub_post_lname));
                            $return_html .= '</div>
                </a>';
                        } else {
                            if ($userid) {
                                if ($free_hire_result) {
                                    $return_html .= '<a style="margin-right: 4px;" href="' . base_url('freelance-work/freelancer-details/' . $row['freelancer_apply_slug']) . '" title=" ' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">';
                                } else {
                                    $return_html .= '<a style="margin-right: 4px;" href="' . base_url('freelance-hire/registration') . '" title=" ' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">';
                                }
                            } else {
                                $return_html .= '<a style="margin-right: 4px;" href="javascript:void(0);" onclick="login_profile();" title=" ' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">';
                            }

                            $return_html .= '<img src="' . FREE_POST_PROFILE_THUMB_UPLOAD_URL . $row['freelancer_post_user_image'] . '" alt="' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '" > </a>';
                        }
                    } else {
                        $filename = $this->config->item('free_post_profile_main_upload_path') . $row['freelancer_post_user_image'];
                        $s3 = new S3(awsAccessKey, awsSecretKey);
                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                        if ($info) {
                            if ($userid) {
                                if ($free_hire_result) {
                                    $return_html .= '<a style="margin-right: 4px;" href="' . base_url('freelance-work/freelancer-details/' . $row['freelancer_apply_slug']) . '" title=" ' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">';
                                } else {
                                    $return_html .= '<a style="margin-right: 4px;" href="' . base_url('freelance-hire/registration') . '" title=" ' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">';
                                }
                            } else {
                                $return_html .= '<a style="margin-right: 4px;" href="javascript:void(0);" onclick="login_profile();" title=" ' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">';
                            }

                            $return_html .= '<img src="' . FREE_POST_PROFILE_THUMB_UPLOAD_URL . $row['freelancer_post_user_image'] . '" alt="' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '" > </a>';
                        } else {
                            if ($userid) {
                                if ($free_hire_result) {
                                    $return_html .= '<a href = "' . base_url('freelance-work/freelancer-details/' . $row['freelancer_apply_slug']) . '" title = "' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">';
                                } else {
                                    $return_html .= '<a href = "' . base_url('freelance-hire/registration') . '" title = "' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">';
                                }
                            } else {
                                $return_html .= '<a href = "javascript:void(0);" onclick="login_profile();" title = "' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">';
                            }

                            $return_html .= '<div class = "post-img-div">';
                            $return_html .= ucfirst(strtolower($sub_post_fname)) . ucfirst(strtolower($sub_post_lname));
                            $return_html .= '</div>
                </a>';
                        }
                    }
                } else {
                    if ($userid) {
                        if ($free_hire_result) {
                            $return_html .= '<a href = "' . base_url('freelance-work/freelancer-details/' . $row['freelancer_apply_slug']) . '" title = "' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">';
                        } else {
                            $return_html .= '<a href = "' . base_url('freelance-hire/registration') . '" title = "' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">';
                        }
                    } else {
                        $return_html .= '<a href = "javascript:void(0);" onclick="login_profile();" title = "' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">';
                    }

                    $return_html .= '<div class = "post-img-div">';
                    $return_html .= ucfirst(strtolower($sub_post_fname)) . ucfirst(strtolower($sub_post_lname));
                    $return_html .= '</div>
                </a>';
//                    $return_html .= '<a style="margin-right: 4px;" href="' . base_url('freelance-work/freelancer-details/' . $row['freelancer_apply_slug'] . '?page=freelancer_hire') . '" title="' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">';
//                    $return_html .= '<img src="' . base_url(NOIMAGE) . '" alt="' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '"> </a>';
                }
                $return_html .= '</div></div>
                                                                    <div class="designation_rec" style="float: left;">
                                                                        <ul>
                                                                            <li>';
                if ($userid) {
                    if ($free_hire_result) {
                        $return_html .= '<a style="margin-right: 4px;" href="' . base_url('freelance-work/freelancer-details/' . $row['freelancer_apply_slug']) . '" title="' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '"><h6>';
                        $return_html .= ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']);
                        $return_html .= '</h6>
                                                                                </a>
                                                                            </li>';
                    } else {
                        $return_html .= '<a style="margin-right: 4px;" href="' . base_url('freelance-hire/registration') . '" title="' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '"><h6>';
                        $return_html .= ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']);
                        $return_html .= '</h6>
                                                                                </a>
                                                                            </li>';
                    }
                } else {
                    $return_html .= '<a style="margin-right: 4px;" onclick="login_profile();" href="javascript:void(0);" title="' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '"><h6>';
                    $return_html .= ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']);
                    $return_html .= '</h6>
                    </a>';
                }
                $return_html .= '<li style="display: block;" ><a>';
                if ($row['designation']) {
                    $return_html .= $row['designation'];
                } else {
                    $return_html .= "Designation";
                }
                $return_html .= '</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>  
                                                        <div class="profile-job-post-title clearfix">
                                                            <div class="profile-job-profile-menu">
                                                                <ul class="clearfix"> 
                                                                <li><b>Field</b><span>';
                if ($row['freelancer_post_field']) {
                    $field_name = $this->db->get_where('category', array('category_id' => $row['freelancer_post_field']))->row()->category_name;
                    $return_html .= $field_name;
                } else {
                    $return_html .= PROFILENA;
                }

                $return_html .= '</li></span><li><b>Skills</b><span>';
                $aud = $row['freelancer_post_area'];
                $aud_res = explode(',', $aud);
                if (!$row['freelancer_post_area']) {
                    $return_html .= $row['freelancer_post_otherskill'];
                } elseif (!$row['freelancer_post_otherskill']) {
                    foreach ($aud_res as $skill) {
                        $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;
                        $skillsss[] = $cache_time;
                    }
                    $listskill = implode(', ', $skillsss);
                    $return_html .= $listskill;
                    unset($skillsss);
                } elseif ($row['freelancer_post_area'] && $row['freelancer_post_otherskill']) {
                    foreach ($aud_res as $skillboth) {
                        $cache_time = $this->db->get_where('skill', array('skill_id' => $skillboth))->row()->skill;
                        $skilldddd[] = $cache_time;
                    }
                    $listFinal = implode(', ', $skilldddd);
                    $return_html .= $listFinal . "," . $row['freelancer_post_otherskill'];
                    unset($skilldddd);
                }
                $return_html .= '  </span>    
                                                                    </li>';
                $cityname = $this->db->get_where('cities', array('city_id' => $row['freelancer_post_city']))->row()->city_name;
                $countryname = $this->db->select('country_name')->get_where('countries', array('country_id' => $row['freelancer_post_country']))->row()->country_name;
                $return_html .= '<li><b>Location</b><span>';
                if ($cityname || $countryname) {
                    if ($cityname) {
                        $return_html .= $cityname . ",";
                    }
                    if ($countryname) {
                        $return_html .= $countryname;
                    }
                }
                $return_html .= '</span></li>
                                                                    <li><b>Skill Description</b> <span> <p>';

                if ($row['freelancer_post_skill_description']) {
                    $return_html .= $row['freelancer_post_skill_description'];
                } else {
                    $return_html .= PROFILENA;
                }
                $return_html .= '</p></span>
                                                                    </li>
                                                                    <li><b>Avaiability</b><span>';
                if ($row['freelancer_post_work_hour']) {
                    $return_html .= $row['freelancer_post_work_hour'] . "  " . "Hours per week ";
                } else {
                    $return_html .= PROFILENA;
                }
                $return_html .= '</span>
                                                                    </li>
                                                                    <li><b>Rate Hourly</b> <span>';
                if ($row['freelancer_post_hourly']) {
                    $currency = $this->db->get_where('currency', array('currency_id' => $row['freelancer_post_ratestate']))->row()->currency_name;

                    if ($row['freelancer_post_fixed_rate'] == '1') {
                        $return_html .= $row['freelancer_post_hourly'] . "   " . $currency . " (Also work on fixed Rate)";
                    } else {
                        $return_html .= $row['freelancer_post_hourly'] . "   " . $currency;
                    }
                } else {
                    $return_html .= PROFILENA;
                }
                $return_html .= '</span>
                                                                    </li>
                                                                    <li><b>Total Experience</b>
                                                                        <span>';
                if ($row['freelancer_post_exp_year'] || $row['freelancer_post_exp_month']) {
                    if ($row['freelancer_post_exp_month'] == '12 month' && $row['freelancer_post_exp_year'] == '') {
                        $return_html .= "1 year";
                    } elseif ($row['freelancer_post_exp_month'] == '12 month' && $row['freelancer_post_exp_year'] == '0 year') {
                        $return_html .= "1 year";
                    } elseif ($row['freelancer_post_exp_month'] == '12 month' && $row['freelancer_post_exp_year'] != '') {
                        $year = explode(' ', $row['freelancer_post_exp_year']);
// echo $year;
                        $totalyear = $year[0] + 1;
                        $return_html .= $totalyear . " year";
                    } elseif ($row['freelancer_post_exp_year'] != '' && $row['freelancer_post_exp_month'] == '') {
                        $return_html .= $row['freelancer_post_exp_year'];
                    } elseif ($row['freelancer_post_exp_year'] != '' && $row['freelancer_post_exp_month'] == '0 month') {

                        $return_html .= $row['freelancer_post_exp_year'];
                    } else {

                        $return_html .= $row['freelancer_post_exp_year'] . ' ' . $row['freelancer_post_exp_month'];
                    }
                } else {
                    $return_html .= PROFILENA;
                }
                $return_html .= '</span>
                                                                    </li>';
                $return_html .= '<input type="hidden" name="search" id="search" value="' . $keyword . '">';
                $return_html .= '</ul>
                                                            </div>
                                                            <div class="profile-job-profile-button clearfix">
                                                                <div class="apply-btn fr">';
                if ($userid) {
                    $userid = $this->session->userdata('aileenuser');

                    $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1', 'free_hire_step' => '3');
                    $free_hire_result = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'reg_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    if ($free_hire_result) {
                        $contition_array = array('from_id' => $userid, 'to_id' => $row['user_id'], 'save_type' => '2');
                        $data = $this->common->select_data_by_condition('save', $contition_array, $data = 'status', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                        if ($userid != $row['user_id']) {
                            $return_html .= '<a href="' . base_url('chat/abc/3/4/' . $row['user_id']) . '">Message</a>';
                            if ($data[0]['status'] == 1 || $data[0]['status'] == '') {
                                $return_html .= '<input type="hidden" id="hideenuser' . $row['user_id'] . '" value= "' . $data[0]['save_id'] . '">';
                                $return_html .= '<a id="' . $row['user_id'] . '" onClick="savepopup(' . $row['user_id'] . ')" href="javascript:void(0);" class="saveduser' . $row['user_id'] . '">Save</a>';
                            } elseif ($data[0]['status'] == 2) {
                                $return_html .= '<a class="saved">Shortlisted</a>';
                            } else {
                                $return_html .= '<a class="saved">Saved </a>';
                            }
                        }
                    } else {
                        $return_html .= '<a href="' . base_url('freelance-hire/registration') . '"> Message </a>';
                        $return_html .= '<a href="' . base_url('freelance-hire/registration') . '"> Save </a>';
                    }
                } else {
                    $return_html .= '<a href="javascript:void(0);" onclick="login_profile();"> Message </a>';
                    $return_html .= '<a href="javascript:void(0);" onclick="login_profile();"> Save </a>';
                }
                $return_html .= '</div>
                                                            </div>
                                                        </div>
                                                    </div>';
            }
        } else {
            $return_html .= '<div class="text-center rio">
                                                <h1 style="margin-bottom:11px;" class="page-heading  product-listing" >';
            $return_html .= $this->lang->line("oops_no_data");
            $return_html .= '</h1><p style="margin-left:4%;">';
            $return_html .= $this->lang->line("couldn_find");
            $return_html .= '</p>
                                                <ul>
                                                    <li style="text-transform:none !important; list-style: none;">';
            $return_html .= $this->lang->line("right_keyword");
            $return_html .= '</li>
                                                </ul>
                                            </div>';
        }
        $return_html .= '<div class="col-md-1">
                                            </div>';
        echo $return_html;
    }

//freelancer hire ajax search end 
// freelancer post search start
    public function freelancer_post_index() {
        $user_id = $this->session->userdata('user_id');
        $this->load->view('freelancer_post/freelancer_post_search', $this->data);
    }

    public function freelancer_post_search() {

        $searchvalue = $this->uri->segment(1);
        if ($searchvalue == 'projects') {
            $search_skill = '';
            $search_place = '';
        } else {
            $skill = explode('project', $searchvalue);
            $location = explode('-in-', $searchvalue);


//             echo "<pre>";
//            print_r($search_skill_title);
//            die();
            $search_skill = trim($skill[0]);
            $search_skill = trim($skill[0], '-');
            $search_place = $location[1];

//            $search_skill_title= $search_skill;
            $search_skill_title = str_replace('-', ' ', $search_skill);
            $search_place_title = str_replace('-', ' ', $search_place);
        }

        $userid = $this->session->userdata('aileenuser');
        $this->data['keyword'] = $search_skill;
//        $search_skill = trim($this->input->get('skills'));
//        $this->data['keyword'] = $search_skill;
//        $search_place = trim($this->input->get('searchplace'));
// code for insert search keyword into database start
        $cache_time = $this->db->get_where('cities', array('city_name' => $search_place))->row()->city_id;
        $this->data['keyword1'] = $search_place;

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $this->data['city'] = $city = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_city', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userid) {
//echo "hi"; die();
            $data = array(
                'search_keyword' => $search_skill,
                'search_location' => $search_place,
                'user_location' => $city[0]['freelancer_post_city'],
                'user_id' => $userid,
                'created_date' => date('Y-m-d h:i:s', time()),
                'status' => '1',
                'module' => '4'
            );

//   echo"<pre>"; print_r($data); die();
            $insert_id = $this->common->insert_data_getid($data, 'search_info');
// code for insert search keyword into database end
        }
        $title = '';
        if (empty($search_skill_title) && empty($search_place_title)) {
            $title = 'Find Latest Projects at Your Location';
        } elseif ($search_skill_title && $search_place_title) {
            $title = $search_skill_title . ' in ' . $search_place_title;
        } elseif ($search_skill_title) {
            $title = $search_skill_title;
        } elseif ($search_place_title) {
            $title = $search_place_title;
        }

        $this->data['title'] = $title . " | Freelancer Profile - Aileensoul";
        $this->data['head'] = $this->load->view('head', $this->data, TRUE);

//THIS CODE IS FOR WHEN USER NOT LOGIN AND GET SEARCH DATA START
        if ($this->session->userdata('aileenuser')) {
            $userid = $this->session->userdata('aileenuser');
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1', 'free_post_step' => '7');
            $free_apply_result = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_reg_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if ($free_apply_result) {
                $this->load->view('freelancer/freelancer_post/recommen_freelancer_post', $this->data);
            } else {
                $this->load->view('freelancer/freelancer_post/apply_search', $this->data);
            }
        } else {
// $this->data['business_common_profile'] = $this->load->view('business_profile/business_common_profile', $this->data, true);
            $this->load->view('freelancer/freelancer_post/apply_search', $this->data);
        }

//$this->load->view('freelancer/freelancer_post/recommen_freelancer_post', $this->data);
    }

// freelancer post search end 

    public function ajax_freelancer_post_search() {
        
      
        $userid = $this->session->userdata('aileenuser');
        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;

        $search_skill = $_GET["skill"];
        $search_place = $_GET["place"];

//echo $search_skill;
// echo $search_place;die();
        $cache_time = $this->db->get_where('cities', array('city_name' => $search_place))->row()->city_id;
//$date = date('Y-m-d', time());
//'freelancer_post.post_last_date >=' => $date,
// code for insert search keyword into database end
        if ($search_skill == "" && $search_place == "") {

            $join_str[0]['table'] = 'freelancer_post';
            $join_str[0]['join_table_id'] = 'freelancer_post.user_id';
            $join_str[0]['from_table_id'] = 'freelancer_hire_reg.user_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('freelancer_post.status' => '1', 'freelancer_post.is_delete' => '0', 'freelancer_hire_reg.status' => '1', 'freelancer_hire_reg.is_delete' => '0', 'freelancer_hire_reg.user_id !=' => $userid, 'freelancer_hire_reg.free_hire_step' => '3');
            $new = $this->data['results'] = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = '*', $sortby = 'freelancer_post.created_date', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
        } elseif ($search_skill == "") {

//$contition_array = array('freelancer_post.city' => $search_place[0], 'freelancer_hire_reg.status' => '1');
            $join_str[0]['table'] = 'freelancer_post';
            $join_str[0]['join_table_id'] = 'freelancer_post.user_id';
            $join_str[0]['from_table_id'] = 'freelancer_hire_reg.user_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('freelancer_post.status' => '1', 'freelancer_post.is_delete' => '0', 'freelancer_hire_reg.city' => $cache_time, 'freelancer_hire_reg.status' => '1', 'freelancer_hire_reg.user_id !=' => $userid, 'freelancer_hire_reg.free_hire_step' => '3');
            $new = $this->data['results'] = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = '*', $sortby = 'freelancer_post.created_date', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
        } elseif ($search_place == "") {
//            echo $search_skill;die();

            $temp = $this->db->select('skill_id')->get_where('skill', array('skill_slug' => $search_skill, 'status' => '1', 'type' => '1'))->row()->skill_id;
            $contition_array = array('status' => '1', 'is_delete' => '0', 'user_id != ' => $userid, 'FIND_IN_SET("' . $temp . '", post_skill) != ' => '0');
            $freeskillpost = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data = '*', $sortby = 'freelancer_post.created_date', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $category_temp = $this->db->select('category_id')->get_where('category', array('category_slug' => $search_skill, 'status' => '1'))->row()->category_id;
//  echo $category_temp;die();
            $contition_array = array('post_field_req' => $category_temp, 'user_id !=' => $userid, 'status' => '1', 'is_delete' => '0');
            $fieldfound = $this->data['field'] = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data = '*', $sortby = 'freelancer_post.created_date', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby);
//  echo "<pre>"; print_r($fieldfound);die();
            $search_condition = "(post_slug LIKE '%$search_skill%' or post_other_skill LIKE '%$search_skill%' or post_est_time LIKE '%$search_skill%' or post_rate LIKE '%$search_skill%' or  post_exp_year LIKE '%$search_skill%' or  post_exp_month LIKE '%$search_skill%')";
            $contion_array = array('freelancer_post.user_id !=' => $userid, 'status' => '1', 'is_delete' => '0');
            $freeldata = $this->common->select_data_by_search('freelancer_post', $search_condition, $contion_array, $data = '*', $sortby = 'freelancer_post.created_date', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
//echo "<pre>";print_r($freeldata);die();
            $unique = array_merge((array) $freeskillpost, (array) $freeldata, (array) $fieldfound);
            $new = array();
            foreach ($unique as $value) {
                $new[$value['post_id']] = $value;
            }
        } else {



            $temp = $this->db->select('skill_id')->get_where('skill', array('skill_slug' => $search_skill, 'status' => '1'))->row()->skill_id;

            $join_str[0]['table'] = 'freelancer_hire_reg';
            $join_str[0]['join_table_id'] = 'freelancer_hire_reg.user_id';
            $join_str[0]['from_table_id'] = 'freelancer_post.user_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('freelancer_post.status' => '1', 'freelancer_post.is_delete' => '0', 'freelancer_hire_reg.city' => $cache_time, 'freelancer_post.user_id != ' => $userid, 'FIND_IN_SET("' . $temp . '", post_skill) != ' => '0');
            $freeskillpost = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data = '*', $sortby = 'freelancer_post.created_date', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
//  echo "<pre>"; print_r($freeskillpost);die();

            $join_str[0]['table'] = 'freelancer_hire_reg';
            $join_str[0]['join_table_id'] = 'freelancer_hire_reg.user_id';
            $join_str[0]['from_table_id'] = 'freelancer_post.user_id';
            $join_str[0]['join_type'] = '';

            $category_temp = $this->db->select('category_id')->get_where('category', array('category_slug' => $search_skill, 'status' => '1'))->row()->category_id;
            $contition_array = array('freelancer_post.post_field_req' => $category_temp, 'freelancer_post.user_id !=' => $userid, 'freelancer_post.status' => '1', 'freelancer_post.is_delete' => '0', 'freelancer_hire_reg.city' => $cache_time);
            $fieldfound = $this->data['field'] = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data = '*', $sortby = 'freelancer_post.created_date', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby);

//  echo "<pre>"; print_r($fieldfound);die();

            $join_str[0]['table'] = 'freelancer_hire_reg';
            $join_str[0]['join_table_id'] = 'freelancer_hire_reg.user_id';
            $join_str[0]['from_table_id'] = 'freelancer_post.user_id';
            $join_str[0]['join_type'] = '';


            $search_condition = "(freelancer_post.post_slug LIKE '%$search_skill%' or freelancer_post.post_other_skill LIKE '%$search_skill%' or freelancer_post.post_est_time LIKE '%$search_skill%' or freelancer_post.post_rate LIKE '%$search_skill%' or  freelancer_post.post_exp_year LIKE '%$search_skill%' or  freelancer_post.post_exp_month LIKE '%$search_skill%')";
            $contion_array = array('freelancer_hire_reg.city' => $cache_time, 'freelancer_post.user_id !=' => $userid, 'freelancer_post.status' => '1', 'freelancer_post.is_delete' => '0');
            $freeldata = $this->common->select_data_by_search('freelancer_post', $search_condition, $contion_array, $data = '*', $sortby = 'freelancer_post.created_date', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

            $unique = array_merge((array) $freeskillpost, (array) $freeldata, (array) $fieldfound);
            $new = array();
            foreach ($unique as $value) {
                $new[$value['post_id']] = $value;
            }
        }
// echo "<pre>";print_r($new);die();
        $this->data['freelancerhiredata'] = $new;
        $return_html = '';

        $freelancerhiredata1 = array_slice($new, $start, $perpage);
//  echo "<pre>";print_r($freelancerhiredata1);die();
        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($new);
        }

        $return_html .= '<input type = "hidden" class = "page_number" value = "' . $page . '" />';
        $return_html .= '<input type = "hidden" class = "total_record" value = "' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1', 'free_post_step' => '7');
        $free_work_result = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_reg_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
       
        if (count($new) > 0) {
// echo count($freelancerhiredata1);
            foreach ($freelancerhiredata1 as $post) {
                
                $userid = $this->session->userdata('aileenuser');
                $contition_array = array('user_id' => $userid, 'post_id' => $post['post_id'], 'job_delete' => '0');
                $jobdata = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if ($jobdata[0]['job_save'] != 2) {
                    $cache_time1 = $post['post_name'];
                    if ($cache_time1 != '') {
                        $text = strtolower($this->common->clean($cache_time1));
                    } else {
                        $text = '';
                    }


                    $city = $this->db->select('city')->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->city;
                    $cityname = $this->db->select('city_name')->get_where('cities', array('city_id' => $city))->row()->city_name;

                    if ($cityname != '') {
                        $cityname1 = '-vacancy-in-' . strtolower($this->common->clean($cityname));
                    } else {
                        $cityname1 = '';
                    }

                    $return_html .= '<div class="all-job-box" id="removeapply' . $post['post_id'] . '">
                                    <div class="all-job-top">';
                    $cache_time1 = $post['post_name'];

                    if ($cache_time1 != '') {
                        $text = strtolower($this->common->clean($cache_time1));
                    } else {
                        $text = '';
                    }
                    $city = $this->db->select('city')->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->city;
                    $cityname = $this->db->select('city_name')->get_where('cities', array('city_id' => $city))->row()->city_name;

                    if ($cityname != '') {
                        $cityname1 = '-vacancy-in-' . strtolower($this->common->clean($cityname));
                    } else {
                        $cityname1 = '';
                    }

                    $firstname = $this->db->select('fullname')->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->fullname;
                    $lastname = $this->db->select('username')->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->username;
                    $hireslug = $this->db->select('freelancer_hire_slug')->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->freelancer_hire_slug;


                    $return_html .= '<div class="job-top-detail">';
                    $return_html .= '<h5><a href="' . base_url('freelance-hire/project/' . $text . $cityname1 . '-' . $post['user_id'] . '-' . $post['post_id']) . ' ">';
                    $return_html .= $post['post_name'];
                    $return_html .= '</a></h5>';
                    if ($this->session->userdata('aileenuser')) {
                        if ($free_work_result) {
                            $return_html .= '<p><a href="' . base_url('freelance-hire/employer-details/' . $hireslug) . '">';
                            $return_html .= ucwords($firstname) . " " . ucwords($lastname);
                            $return_html .= '</a></p>';
                        } else {
                            $return_html .= '<p><a href="' . base_url('freelance-work/registartion') . '">';
                            $return_html .= ucwords($firstname) . " " . ucwords($lastname);
                            $return_html .= '</a></p>';
                        }
                    } else {
                        $return_html .= '<p><a href="javascript:void(0);">';
                        $return_html .= ucwords($firstname) . " " . ucwords($lastname);
                        $return_html .= '</a></p>';
                    }

                    $return_html .= ' </div>
            </div>
            <div class="all-job-middle">
                <p class="pb5">
                    <span class="location">';
                    $return_html .= '<span><img class="pr5" src="' . base_url('assets/images/location.png') . '">';
                    $country = $this->db->select('country')->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->country;
                    $countryname = $this->db->select('country_name')->get_where('countries', array('country_id' => $country))->row()->country_name;
                    if ($cityname || $countryname) {
                        if ($cityname) {
                            $return_html .= $cityname . ",";
                        }
                        $return_html .= $countryname;
                    }
                    $return_html .= '      </span>
                    </span>';
                    $return_html .= '<span class="exp">
                        <span><img class="pr5" src="' . base_url('assets/images/exp.png') . '">';

                    $comma = ", ";
                    $k = 0;
                    $aud = $post['post_skill'];
                    $aud_res = explode(',', $aud);
                    if (!$post['post_skill']) {

                        $return_html .= $post['post_other_skill'];
                    } else if (!$post['post_other_skill']) {

                        foreach ($aud_res as $skill) {
                            if ($k != 0) {
                                $return_html .= $comma;
                            }
                            $cache_time = $this->db->select('skill')->get_where('skill', array('skill_id' => $skill))->row()->skill;
                            $return_html .= $cache_time;
                            if ($k == 5) {
                                $etc = ",etc...";
                                $return_html .= $etc;
                                break;
                            }
                            $k++;
                        }
                    } else if ($post['post_skill'] && $post['post_other_skill']) {
                        foreach ($aud_res as $skill) {
                            if ($k != 0) {
                                $return_html .= $comma;
                            }
                            $cache_time = $this->db->select('skill')->get_where('skill', array('skill_id' => $skill))->row()->skill;
                            $return_html .= $cache_time;
                            if ($k == 5) {
                                $etc = ",etc...";
                                $return_html .= $etc;
                                break;
                            }
                            $k++;
                        }
                        if ($k < 5) {
                            $return_html .= "," . $post['post_other_skill'];
                        }
                    }


                    $return_html .= '</span>
                    </span>
                </p>
                <p>';

                    $rest = substr($post['post_description'], 0, 150);
                    $return_html .= $rest;

                    if (strlen($post['post_description']) > 150) {
                        $return_html .= '.....<a href="' . base_url('freelance-hire/project/' . $text . $cityname1 . '-' . $post['user_id'] . '-' . $post['post_id']) . ' ">Read more</a>';
                    }
                    $return_html .= '</p>

            </div>
            <div class="all-job-bottom">
                <span class="job-post-date"><b>Posted on: </b>';
                    $return_html .= trim(date('d-M-Y', strtotime($post['created_date'])));
                    $return_html .= '</span>
                <p class="pull-right">';
                    $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
                    if ($this->session->userdata('aileenuser')) {

                        if ($free_work_result) {
                            $contition_array = array('post_id' => $post['post_id'], 'job_delete' => '0', 'user_id' => $userid);
                            $freelancerapply1 = $this->data['freelancerapply'] = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                            if ($freelancerapply1) {
                                $return_html .= '<a href="javascript:void(0);" class="btn4 applied">Applied</a>';
                            } else {
                                $return_html .= '<a href="javascript:void(0);"  class= "btn4 applypost' . $post['post_id'] . '" onclick="applypopup(' . $post['post_id'] . ',' . $post['user_id'] . ')">Apply</a>';
                                $contition_array = array('user_id' => $userid, 'job_save' => '2', 'post_id ' => $post['post_id'], 'job_delete' => '1');
                                $data = $this->data['jobsave'] = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                if ($data) {
                                    $return_html .= '<a href="javascript:void(0);"  class= "btn4 saved savedpost' . $post['post_id'] . '">Saved</a>';
                                } else {
                                    $return_html .= '<a href="javascript:void(0);" id="' . $post['post_id'] . '"  onclick="savepopup(' . $post['post_id'] . ')" class= "btn4 savedpost' . $post['post_id'] . '">Save</a>';
                                }
                            }
                        } else {

                            $return_html .= '<a href="' . base_url('freelance-work/registration') . '"    class= "btn4 savedpost">Save</a>';

                            $return_html .= '<a href="' . base_url('freelance-work/registration') . '"  class= "btn4 applypost">Apply</a>';
                        }
                    } else {
                        $return_html .= '<a href="javascript:void(0);"  class= "btn4 applypost" onclick="create_profile_apply(' . $post['post_id'] . ');">Apply</a>';
                    }

                    $return_html .= ' </p>

</div>
</div>';
                }
            }
        } else {

            $return_html .= '<div class="text-center rio">
                                                <h1 style="margin-bottom:11px;" class="page-heading  product-listing" >';
            $return_html .= $this->lang->line("oops_no_data");
            $return_html .= '</h1><p style="margin-left:4%;">';
            $return_html .= $this->lang->line("couldn_find");
            $return_html .= '</p>
                                                <ul>
                                                    <li style="text-transform:none !important; list-style: none;">';
            $return_html .= $this->lang->line("right_keyword");
            $return_html .= '</li>
                                                </ul>
                                            </div>';
        }
        echo $return_html;
    }

    function text2link($text) {
        $text = preg_replace('/(((f|ht){1}t(p|ps){1}:\/\/)[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '<a href="\\1" target="_blank" rel="nofollow">\\1</a>', $text);
        $text = preg_replace('/([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '\\1<a href="http://\\2" target="_blank" rel="nofollow">\\2</a>', $text);
        $text = preg_replace('/([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})/i', '<a href="mailto:\\1" rel="nofollow" target="_blank">\\1</a>', $text);
        return $text;
    }

//AJAX BUSIENSS SEARCH WITHOUTL LOGIN START

    public function ajax_business_user_login_search() {

        $userid = $this->session->userdata('aileenuser');
        if ($this->input->get('skills') == "" && $this->input->get('searchplace') == "") {
            redirect('business-profile/home/', refresh);
        }
// code for insert search keyword in database start
        $search_business = trim($this->input->get('skills'));
        $this->data['keyword'] = $search_business;

        $search_place = trim($this->input->get('searchplace'));
        $cache_time = $this->db->get_where('cities', array('city_name' => $search_place))->row()->city_id;

        $this->data['keyword1'] = $search_place;
        $contition_array = array('business_profile.user_id' => $userid, 'business_profile.is_deleted' => '0', 'business_profile.status' => '1');
        $this->data['city'] = $city = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'city', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        if ($this->session->userdata('aileenuser')) {
            $data = array(
                'search_keyword' => $search_business,
                'search_location' => $search_place,
                'user_location' => $city[0]['city'],
                'user_id' => $userid,
                'created_date' => date('Y-m-d h:i:s', time()),
                'status' => '1',
                'module' => '5'
            );

            $insert_id = $this->common->insert_data_getid($data, 'search_info');
// code for insert search keyword in database end
        }
        if ($search_business == "") {
            $contition_array = array('city' => $cache_time, 'status' => '1', 'business_step' => '4');
            $business_profile = $this->data['results'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } elseif ($search_place == "") {
            $condition_array = array('business_profile_id !=' => '', 'business_profile.status' => '1', 'business_step' => '4');

            $searchbusiness = $this->db->get_where('business_type', array('business_name' => $search_business))->row()->type_id;
            $searchbusiness1 = $this->db->get_where('industry_type', array('industry_name' => $search_business))->row()->industry_id;
            if ($searchbusiness1) {
                $search_condition = "(industriyal LIKE '%$searchbusiness1%')";
            } elseif ($searchbusiness) {
                $search_condition = "(business_type LIKE '%$searchbusiness%')";
            } else {
                $search_condition = "(company_name LIKE '%$search_business%' or contact_website LIKE '%$search_business%' or other_business_type LIKE '%$search_business%' or other_industrial LIKE '%$search_business%')";
            }

//   echo $search_condition; 
            $business_profile = $this->data['results'] = $this->common->select_data_by_search('business_profile', $search_condition, $condition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $join_str[0]['table'] = 'business_profile';
            $join_str[0]['join_table_id'] = 'business_profile.user_id';
            $join_str[0]['from_table_id'] = 'business_profile_post.user_id';
            $join_str[0]['join_type'] = '';

            $condition_array = array('business_step' => '4', 'business_profile_post.is_delete' => '0');
            $search_condition = "(business_profile_post.product_name LIKE '%$search_business%' or business_profile_post.product_description LIKE '%$search_business%')";

            $business_post = $post['data'] = $this->common->select_data_by_search('business_profile_post', $search_condition, $condition_array, $data = 'business_profile_post.*,business_profile.company_name,business_profile.industriyal,business_profile.business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        } else {
            $condition_array = array('business_profile_id !=' => '', 'status' => '1', 'city' => $cache_time, 'business_step' => '4');
            $searchbusiness = $this->db->get_where('business_type', array('business_name' => $search_business))->row()->type_id;
            $searchbusiness1 = $this->db->get_where('industry_type', array('industry_name' => $search_business))->row()->industry_id;
            if ($searchbusiness1) {
                $search_condition = "(industriyal LIKE '%$searchbusiness1%')";
            } elseif ($searchbusiness) {
                $search_condition = "(business_type LIKE '%$searchbusiness%')";
            } else {
                $search_condition = "(company_name LIKE '%$search_business%' or contact_website LIKE '%$search_business%' or other_business_type LIKE '%$search_business%' or other_industrial LIKE '%$search_business%')";
            }
            $business_profile = $this->data['results'] = $this->common->select_data_by_search('business_profile', $search_condition, $condition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $join_str[0]['table'] = 'business_profile';
            $join_str[0]['join_table_id'] = 'business_profile.user_id';
            $join_str[0]['from_table_id'] = 'business_profile_post.user_id';
            $join_str[0]['join_type'] = '';

            $condition_array = array('business_step' => '4', 'business_profile_post.is_delete' => '0');
            $search_condition = "(business_profile_post.product_name LIKE '%$search_business%' or business_profile_post.product_description LIKE '%$search_business%')";
            $business_post = $post['data'] = $this->common->select_data_by_search('business_profile_post', $search_condition, $condition_array, $data = 'business_profile_post.*,business_profile.company_name,business_profile.industriyal', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        }

        $this->data['is_business'] = $is_business = $this->db->get_where('business_profile', array('user_id' => $userid))->row()->business_profile_id;

        $description = $business_post;
        $profile = $business_profile;

//$this->load->view('business_profile/recommen_business', $this->data);
//AJAX DATA
        $return_html = '';
        if (count($profile) > 0 || count($description) > 0) {
            if ($profile) {

                $return_html .= '<div class="profile-job-post-title-inside clearfix" style="">
                                                    <div class="profile_search" style="background-color: white; margin-bottom: 10px; margin-top: 10px;">
                                                        <h4 class="search_head">Profiles</h4>
                                                        <div class="inner_search">';
                foreach ($profile as $p) {
                    $return_html .= '<div class="profile-job-profile-button clearfix box_search_module">
                                                                    <div class="profile-job-post-location-name-rec">
                                                                        <div class="module_Ssearch" style="display: inline-block; float: left;">
                                                                            <div class="search_img" style="height: 110px; width: 108px;" >
                                                                                <a style="" href="javascript:void(0);" onClick="login_profile()" title="">';
                    if ($p['business_user_image'] != '') {
                        $return_html .= '<img src="' . BUS_PROFILE_MAIN_UPLOAD_URL . $p['business_user_image'] . '" alt="" > </a>';
                    } else {
                        $return_html .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="">
                                                                                    </a>';
                    }
                    $return_html .= '</div>
                                                                        </div>
                                                                        <div class="designation_rec">
                                                                            <ul>
                                                                                <li style="padding-top: 0px;">
                                                                                    <a  class="main_search_head" href="javascript:void(0);"  onClick="login_profile()" title="">' . ucfirst(strtolower($p['company_name'])) . '</a>
                                                                                </li>
                                                                                <li style="display: block;">
                                                                                    <a  class="color-search" s title="">';

                    $cache_time = $this->db->get_where('industry_type', array('industry_id' => $p['industriyal']))->row()->industry_name;
                    $return_html .= $cache_time;

                    $return_html .= '</a>
                                                                                </li>
                                                                                <li style="display: block;">
                                                                                    <a title="" class="color-search">';

                    $cache_time = $this->db->get_where('business_type', array('type_id' => $p['business_type']))->row()->business_name;
                    $return_html .= $cache_time;

                    $return_html .= '</a>
                                                                                </li>
                                                                                <li style="display: block;">
                                                                                    <a title="" class="color-search">';

                    $cityname = $this->db->get_where('cities', array('city_id' => $p['city']))->row()->city_name;
                    $countryname = $this->db->get_where('countries', array('country_id' => $p['country']))->row()->country_name;
                    if ($cityname || $countryname) {
                        if ($cityname) {
                            $return_html .= $cityname;
                            $return_html .= ', ';
                        }
                        $return_html .= $countryname;
                    }

                    $return_html .= '</a>
                                                                                </li>
                                                                                <li style="display: block;">
                                                                                    <a title="" class="color-search websir-se" href="' . $p['contact_website'] . '" target="_blank">' . $p['contact_website'] . '</a>
                                                                                </li>
                                                                                <input type="hidden" name="search" id="search" value="' . $keyword . '">
                                                                            </ul>
                                                                        </div>';
                    $userid = $this->session->userdata('aileenuser');
                    if ($p['user_id'] != $userid) {
                        $return_html .= '<div class="fl search_button">
                                                                                <div class="fruser' . $p['business_profile_id'] . '">';
                        $status = $this->db->get_where('follow', array('follow_type' => '2', 'follow_from' => $main_business_profile_id, 'follow_to' => $p['business_profile_id']))->row()->follow_status;
                        if ($status == 0 || $status == " ") {
                            $return_html .= '<div id= "followdiv " class="user_btn">
                                                                                            <button id="follow' . $p['business_profile_id'] . '" onClick="login_profile()">
                                                                                                Follow 
                                                                                            </button>
                                                                                        </div>';
                        } elseif ($status == 1) {
                            $return_html .= '<div id= "unfollowdiv"  class="user_btn" > 
                                                                                            <button class="bg_following" id="unfollow' . $p['business_profile_id'] . '" onClick="login_profile()">
                                                                                                Following 
                                                                                            </button>
                                                                                        </div>';
                        }
                        $return_html .= '</div>
                                                                                <button  href="javascript:void(0);"  onClick="login_profile()"> Message</button>
                                                                            </div>';
                    }
                    $return_html .= '</div>
                                                                </div>';
                }
            }
            $return_html .= '</div>
                                                </div>';
            if ($description) {
                $return_html .= '<div class="col-md-12 profile_search " style="float: left; background-color: white; margin-top: 10px; margin-bottom: 10px; padding:0px!important;">
                                                        <h4 class="search_head">Posts</h4>
                                                        <div class="inner_search search inner_search_2" style="float: left;">';
                foreach ($description as $p) {
                    if (($p['product_description']) || ($p['product_name'])) {
                        $return_html .= '<div class="col-md-12 col-sm-12 post-design-box" id="removepost5" style="box-shadow: none; ">
                                                                        <div class="post_radius_box">
                                                                            <div class="post-design-search-top col-md-12" style="background-color: none!important;">
                                                                                <div class="post-design-pro-img ">
                                                                                    <div id="popup1" class="overlay">
                                                                                        <div class="popup">
                                                                                            <div class="pop_content">
                                                                                                Your Post is Successfully Saved.
                                                                                                <p class="okk">
                                                                                                    <a class="okbtn" href="#">Ok
                                                                                                    </a>
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div id="popup25" class="overlay">
                                                                                        <div class="popup">
                                                                                            <div class="pop_content">
                                                                                                Are You Sure want to delete this post?.
                                                                                                <p class="okk">
                                                                                                    <a class="okbtn" id="5" onclick="remove_post(this.id)" href="#">Yes
                                                                                                    </a>
                                                                                                </p>
                                                                                                <p class="okk">
                                                                                                    <a class="cnclbtn" href="#">No
                                                                                                    </a>
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div id="popup55" class="overlay">
                                                                                        <div class="popup">
                                                                                            <div class="pop_content">
                                                                                                Are You Sure want to delete this post from your profile?.
                                                                                                <p class="okk">
                                                                                                    <a class="okbtn" id="5" onclick="del_particular_userpost(this.id)" href="#">OK
                                                                                                    </a>
                                                                                                </p>
                                                                                                <p class="okk">
                                                                                                    <a class="cnclbtn" href="#">Cancel
                                                                                                    </a>
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>';

                        $business_userimage = $this->db->get_where('business_profile', array('user_id' => $p['user_id'], 'status' => '1'))->row()->business_user_image;
                        $userimageposted = $this->db->get_where('business_profile', array('user_id' => $p['posted_user_id']))->row()->business_user_image;
                        $slugname = $this->db->get_where('business_profile', array('user_id' => $p['user_id'], 'status' => '1'))->row()->business_slug;
                        $slugnameposted = $this->db->get_where('business_profile', array('user_id' => $p['posted_user_id'], 'status' => '1'))->row()->business_slug;

                        if ($p['posted_user_id']) {

                            if ($userimageposted) {
                                $return_html .= '<a class="post_dot"  href="javascript:void(0);"  onClick="login_profile()" title="">
                                                                                                <img src="' . BUS_PROFILE_MAIN_UPLOAD_URL . $userimageposted . '" name="image_src" id="image_src" />
                                                                                            </a>';
                            } else {
                                $return_html .= '<a class="post_dot"  href="javascript:void(0);"  onClick="login_profile()" title="">
                                    <img  src="' . base_url(NOBUSIMAGE) . '"  alt="">';
                            }
                            $return_html .= '</a>';
                        } else {
                            if ($business_userimage) {
                                $return_html .= '<a class="post_dot"  href="javascript:void(0);"  onClick="login_profile()" title="">
                                    <img  src="' . BUS_PROFILE_MAIN_UPLOAD_URL . $business_userimage . '"  alt=""> </a>';
                            } else {
                                $return_html .= '<a class="post_dot"  href="javascript:void(0);"  onClick="login_profile()" title="">
                                    <img  src="' . base_url(NOBUSIMAGE) . '"  alt="">
                                </a>';
                            }
                        }

                        $return_html .= '</div>
                        <div class="post-design-name col-xs-8 fl col-md-10">
                            <ul>
                                <li>
                                </li>
                                <li>
                                    <div class="post-design-product">
                                        <a class="post_dot"  href="javascript:void(0);"  onClick="login_profile()" title="">' . ucfirst(strtolower($p['company_name'])) . '
                                        </a>
                                        <span role="presentation" aria-hidden="true"> · </span>
                                        <div class="datespan"> 
                                            <span style="font-weight: 400; font-size: 14px; color: #91949d; cursor: default;"> 
                        ' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($p['created_date']))) . '      
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="post-design-product">
                                        <a href="javascript:void(0);" style=" color: #000033; font-weight: 400; cursor: default;" title="">';

                        $cache_time = $this->db->get_where('industry_type', array('industry_id' => $p['industriyal']))->row()->industry_name;
                        $return_html .= $cache_time;

                        $return_html .= '</a>
                                    </div>
                                </li>
                                <li>
                                </li>
                            </ul>
                        </div>
                        <div class="post-design-desc">
                            <div>
                                <div id="editpostdata5" style="display:block;">
                                    <a style="margin-bottom: 0px; font-size: 16px">
                        ' . ucfirst(strtolower($p['product_name'])) . '
                                    </a>
                                </div>
                                <div id="editpostbox5" style="display:none;">
                                    <input type="text" id="editpostname5" name="editpostname" placeholder="Product Name" value="">
                                </div>
                            </div>
                            <div id="editpostdetails5" style="display:block;">
                                <span class="showmore"> ' . $this->common->make_links(ucfirst(strtolower($p['product_description']))) . '
                                </span>
                            </div>
                            <div id="editpostdetailbox5" style="display:none;">
                                <div contenteditable="true" id="editpostdesc5" placeholder="Product Description" class="textbuis  editable_text" name="editpostdesc"></div>
                            </div>
                            <button class="fr" id="editpostsubmit5" style="display:none;margin: 5px 0; border-radius: 3px;" onclick="edit_postinsert(5)">Save
                            </button>
                        </div>
                        </div>
                        <div class="post-design-mid col-md-12" style="border: none;">
                            <div>';

                        $contition_array = array('post_id' => $p['business_profile_post_id'], 'is_deleted' => '1', 'insert_profile' => '2');
                        $businessmultiimage = $this->data['businessmultiimage'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                        if (count($businessmultiimage) == 1) {

                            $allowed = array('gif', 'png', 'jpg');
                            $allowespdf = array('pdf');
                            $allowesvideo = array('mp4', 'webm');
                            $allowesaudio = array('mp3');
                            $filename = $businessmultiimage[0]['file_name'];
                            $ext = pathinfo($filename, PATHINFO_EXTENSION);
                            if (in_array($ext, $allowed)) {
                                $return_html .= '<div class="one-image" >
                                            <a  href="javascript:void(0);"  onClick="login_profile()">
                                                <img src="' . base_url($this->config->item('bus_post_main_upload_path') . $businessmultiimage[0]['file_name']) . '" > 
                                            </a>
                                        </div>';
                            } elseif (in_array($ext, $allowespdf)) {
                                $return_html .= '<div>
                                            <a title="click to open"  href="javascript:void(0);"  onClick="login_profile()">
                                                <div class="pdf_img">
                                                    <img src="' . base_url('assets/images/PDF.jpg') . '"">
                                                </div>
                                            </a>
                                        </div>';
                            } elseif (in_array($ext, $allowesvideo)) {
                                $return_html .= '<div>
                                            <video width="320" height="240" controls>
                                                <source src="' . base_url($this->config->item('bus_post_main_upload_path') . $businessmultiimage[0]['file_name']) . '" type="video/mp4">
                                                <source src="movie.ogg" type="video/ogg">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>';
                            } elseif (in_array($ext, $allowesaudio)) {
                                $return_html .= '<div>
                                            <audio width="120" height="100" controls>
                                                <source src="' . base_url($this->config->item('bus_post_main_upload_path') . $businessmultiimage[0]['file_name']) . '" type="audio/mp3">
                                                <source src="movie.ogg" type="audio/ogg">
                                                Your browser does not support the audio tag.
                                            </audio>
                                        </div>';
                            }
                        } elseif (count($businessmultiimage) == 2) {
                            foreach ($businessmultiimage as $multiimage) {
                                $return_html .= '<div class="two-images" >
                                            <a  href="javascript:void(0);"  onClick="login_profile()">
                                                <img class="two-columns" src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $multiimage['file_name']) . '" > 
                                            </a>
                                        </div>';
                            }
                        } elseif (count($businessmultiimage) == 3) {
                            $return_html .= '<div class="three-image-top">
                                        <a  href="javascript:void(0);"  onClick="login_profile()">
                                            <img class="three-columns" src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $businessmultiimage[0]['file_name']) . '"> 
                                        </a>
                                    </div>
                                    <div class="three-image" >
                                        <a  href="javascript:void(0);"  onClick="login_profile()">
                                            <img class="three-columns" src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $businessmultiimage[1]['file_name']) . '" > 
                                        </a>
                                    </div>
                                    <div class="three-image" >
                                        <a  href="javascript:void(0);"  onClick="login_profile()">
                                            <img class="three-columns" src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $businessmultiimage[2]['file_name']) . '" > 
                                        </a>
                                    </div>';
                        } elseif (count($businessmultiimage) == 4) {
                            foreach ($businessmultiimage as $multiimage) {
                                $return_html .= '<div class="four-image" >
                                            <a  href="javascript:void(0);"  onClick="login_profile()">
                                                <img class="breakpoint" src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $multiimage['file_name']) . '" > 
                                            </a>
                                        </div>';
                            }
                        } elseif (count($businessmultiimage) > 4) {
                            $i = 0;
                            foreach ($businessmultiimage as $multiimage) {
                                $return_html .= '<div>
                                            <div class="four-image" >
                                                <a  href="javascript:void(0);"  onClick="login_profile()">
                                                    <img src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $multiimage['file_name']) . '" > 
                                                </a>
                                            </div>
                                        </div>';

                                $i++;
                                if ($i == 3)
                                    break;
                            }

                            $return_html .= '<div>
                                        <div class="four-image" >
                                            <a  href="javascript:void(0);"  onClick="login_profile()">
                                                <img src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $businessmultiimage[3]['file_name']) . '"> 
                                            </a>
                                        </div>
                                        <div class="four-image" >
                                            <a  href="javascript:void(0);"  onClick="login_profile()"></a>
                                            <a  href="javascript:void(0);"  onClick="login_profile()">
                                                <span class="more-image"> View All  (+
                            ' . (count($businessmultiimage) - 4) . ')
                                                </span>
                                            </a>
                                        </div>
                                    </div>';
                        }
                        $return_html .= '<div>
                                </div>
                            </div>
                        </div>
                        <div class="post-design-like-box col-md-12">
                            <div class="post-design-menu">
                                <ul class="col-md-6">
                                    <li class="likepost' . $p['business_profile_post_id'] . '">
                                        <a class="ripple like_h_w" id="' . $p['business_profile_post_id'] . '"    href="javascript:void(0);"  onClick="login_profile()">';

                        $userid = $this->session->userdata('aileenuser');
                        $contition_array = array('business_profile_post_id' => $p['business_profile_post_id'], 'status' => '1');
                        $active = $this->data['active'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                        $likeuser = $this->data['active'][0]['business_like_user'];
                        $likeuserarray = explode(',', $active[0]['business_like_user']);
                        if (!in_array($userid, $likeuserarray)) {
                            $return_html .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true">
                                                </i>';
                        } else {
                            $return_html .= '<i class="fa fa-thumbs-up main_color" aria-hidden="true">
                                                </i>';
                        }
                        $return_html .= '<span style="display: none;">';
                        if ($p['business_likes_count'] > 0) {
                            $return_html .= $p['business_likes_count'];
                        }

                        $return_html .= '</span>
                        </a>
                        </li>
                        <li id="insertcount' . $p['business_profile_post_id'] . '" style="visibility:show">';
                        $contition_array = array('business_profile_post_id' => $p['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                        $commnetcount = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                        $return_html .= '<a class="ripple like_h_w"  href="javascript:void(0);"  onClick="login_profile()">
                                <i class="fa fa-comment-o" aria-hidden="true"> 
                                    <span style="display: none;">';
                        if (count($commnetcount) > 0) {
                            $return_html .= count($commnetcount);
                        }
                        $return_html .= '</span>
                                </i> 
                            </a>
                        </li>
                        </ul>';
                        $return_html .= '<ul class="col-md-6 like_cmnt_count">
                            <li>
                                <div class="like_count_ext">
                                    <span class="comment_count' . $p['business_profile_post_id'] . '" >';

                        if (count($commnetcount) > 0) {
                            $return_html .= count($commnetcount);

                            $return_html .= '<span> Comment</span>';
                        }

                        $return_html .= '</span> 
                                </div>
                            </li>
                            <li>
                                <div class="comnt_count_ext">
                                    <span class="comment_like_count' . $p['business_profile_post_id'] . '">';
                        if ($p['business_likes_count'] > 0) {
                            $return_html .= $p['business_likes_count'];
                            $return_html .= '<span> Like</span>';
                        }

                        $return_html .= '</span> 
                                </div>
                            </li>
                        </ul>
                        </div>
                        </div>';

                        if ($p['business_likes_count'] > 0) {

                            $return_html .= '<div class="likeduserlist1 likeduserlist' . $p['business_profile_post_id'] . '">';
                            $contition_array = array('business_profile_post_id' => $p['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                            $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                            $likeuser = $commnetcount[0]['business_like_user'];
                            $countlike = $commnetcount[0]['business_likes_count'] - 1;
                            $likelistarray = explode(',', $likeuser);
                            foreach ($likelistarray as $key => $value) {
                                $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => '1'))->row()->company_name;
                            }
                            $return_html .= '<a  href="javascript:void(0);"  onClick="login_profile()"e>';
                            $contition_array = array('business_profile_post_id' => $p['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                            $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                            $likeuser = $commnetcount[0]['business_like_user'];
                            $countlike = $commnetcount[0]['business_likes_count'] - 1;
                            $likelistarray = explode(',', $likeuser);

                            $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => '1'))->row()->company_name;
                            $return_html .= '<div class="like_one_other">';
                            $return_html .= ucfirst(strtolower($business_fname1));
                            $return_html .= "&nbsp;";
                            if (count($likelistarray) > 1) {
                                $return_html .= "and";
                                $return_html .= $countlike;
                                $return_html .= "&nbsp;";
                                $return_html .= "others";
                            }
                            $return_html .= '</div>';
                            $return_html .= '</a>
                            </div>';
                        }

                        $return_html .= '<div class="likeusername' . $p['business_profile_post_id'] . '" id="likeusername' . $p['business_profile_post_id'] . '" style="display:none">';
                        $contition_array = array('business_profile_post_id' => $p['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                        $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                        $likeuser = $commnetcount[0]['business_like_user'];
                        $countlike = $commnetcount[0]['business_likes_count'] - 1;
                        $likelistarray = explode(',', $likeuser);
                        foreach ($likelistarray as $key => $value) {
                            $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => '1'))->row()->company_name;
                        }

                        $return_html .= '<a  href="javascript:void(0);"  onClick="login_profile()">';
                        $contition_array = array('business_profile_post_id' => $p['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                        $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                        $likeuser = $commnetcount[0]['business_like_user'];
                        $countlike = $commnetcount[0]['business_likes_count'] - 1;
                        $likelistarray = explode(',', $likeuser);

                        $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => '1'))->row()->company_name;
                        $return_html .= '<div class="like_one_other">';

                        $return_html .= ucfirst(strtolower($business_fname1));
                        $return_html .= "&nbsp;";

                        if (count($likelistarray) > 1) {
                            $return_html .= "and";
                            $return_html .= $countlike;
                            $return_html .= "&nbsp;";
                            $return_html .= "others";
                        }
                        $return_html .= '</div>
                        </a>
                        </div>
                        <div class="art-all-comment col-md-12">
                            <div  id="fourcomment' . $p['business_profile_post_id'] . '" style="display:none;">
                            </div>
                            <div  id="threecomment' . $p['business_profile_post_id'] . '" style="display:block">
                                <div class="insertcomment' . $p['business_profile_post_id'] . '">';

                        $contition_array = array('business_profile_post_id' => $p['business_profile_post_id'], 'status' => '1');
                        $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = 'business_profile_post_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');
                        if ($businessprofiledata) {
                            foreach ($businessprofiledata as $pdata) {
                                $companyname = $this->db->get_where('business_profile', array('user_id' => $pdata['user_id']))->row()->company_name;

                                $return_html .= '<div class="all-comment-comment-box">
                                                <div class="post-design-pro-comment-img">';
                                $business_userimage = $this->db->get_where('business_profile', array('user_id' => $pdata['user_id'], 'status' => '1'))->row()->business_user_image;
                                if ($business_userimage) {
                                    $return_html .= '<img  src="' . BUS_PROFILE_MAIN_UPLOAD_URL . $business_userimage . '"  alt="">';
                                } else {
                                    $return_html .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="">';
                                }
                                $return_html .= '</div>
                                                <div class="comment-name">
                                                    <b title="' . $companyname . '">';
                                $return_html .= $companyname;
                                $return_html .= '</br>';

                                $return_html .= '</b>
                                                </div>
                                                <div class="comment-details" id= "showcomment' . $pdata['business_profile_post_comment_id'] . '">';
                                $return_html .= $this->common->make_links($pdata['comments']);
                                $return_html .= '</div>
                                                <div class="edit-comment-box">
                                                    <div class="inputtype-edit-comment">
                                                        <div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="' . $pdata['business_profile_post_comment_id'] . '"  id="editcomment' . $pdata['business_profile_post_comment_id'] . '" placeholder="Enter Your Comment " value= ""  onkeyup="commentedit(' . $pdata['business_profile_post_comment_id'] . ')">' . $pdata['comments'] . '</div>
                                                        <span class="comment-edit-button"><button id="editsubmit' . $pdata['business_profile_post_comment_id'] . '" style="display:none" onClick="edit_comment(' . $pdata['business_profile_post_comment_id'] . ')">Save</button></span>
                                                    </div>
                                                </div>
                                                <div class="art-comment-menu-design">
                                                    <div class="comment-details-menu" id="likecomment1' . $pdata['business_profile_post_comment_id'] . '">
                                                        <a id="' . $pdata['business_profile_post_comment_id'] . '"  href="javascript:void(0);"  onClick="login_profile()">';
                                $userid = $this->session->userdata('aileenuser');
                                $contition_array = array('business_profile_post_comment_id' => $pdata['business_profile_post_comment_id'], 'status' => '1');
                                $businesscommentlike = $this->data['businesscommentlike'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                $likeuserarray = explode(',', $businesscommentlike[0]['business_comment_like_user']);
                                if (!in_array($userid, $likeuserarray)) {
                                    $return_html .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true">
                                                                </i>';
                                } else {
                                    $return_html .= '<i clss="fa fa-thumbs-up" aria-hidden="true">
                                                                </i>';
                                }
                                $return_html .= '<span>';
                                if ($pdata['business_comment_likes_count']) {
                                    $return_html .= $pdata['business_comment_likes_count'];
                                }

                                $return_html .= '</span>';
                                $return_html .= '</a>
                                                    </div>';

                                $userid = $this->session->userdata('aileenuser');
                                if ($pdata['user_id'] == $userid) {

                                    $return_html .= '<span role="presentation" aria-hidden="true"> · 
                                                        </span>
                                                        <div class="comment-details-menu">
                                                            <div id="editcommentbox' . $pdata['business_profile_post_comment_id'] . '" style="display:block;">
                                                                <a id="' . $pdata['business_profile_post_comment_id'] . '"    href="javascript:void(0);"  onClick="login_profile()" class="editbox">Edit
                                                                </a>
                                                            </div>
                                                            <div id="editcancle' . $pdata['business_profile_post_comment_id'] . '" style="display:none;">
                                                                <a id="' . $pdata['business_profile_post_comment_id'] . '"  href="javascript:void(0);"  onClick="login_profile()">Cancel
                                                                </a>
                                                            </div>
                                                        </div>';
                                }

                                $userid = $this->session->userdata('aileenuser');
                                $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $pdata['business_profile_post_id'], 'status' => '1'))->row()->user_id;
                                if ($pdata['user_id'] == $userid || $business_userid == $userid) {

                                    $return_html .= '<span role="presentation" aria-hidden="true"> · 
                                                        </span>
                                                        <div class="comment-details-menu">
                                                            <input type="hidden" name="post_delete"  id="post_delete' . $pdata['business_profile_post_comment_id'] . '" value= "' . $pdata['business_profile_post_id'] . '">
                                                            <a id="' . $pdata['business_profile_post_comment_id'] . '"    href="javascript:void(0);"  onClick="login_profile()"> Delete
                                                                <span class="insertcomment' . $pdata['business_profile_post_comment_id'] . '">
                                                                </span>
                                                            </a>
                                                        </div>';
                                }
                                $return_html .= '<span role="presentation" aria-hidden="true"> · 
                                                    </span>
                                                    <div class="comment-details-menu">
                                                        <p>';
                                $return_html .= date('d-M-Y', strtotime($pdata['created_date']));
                                $return_html .= '</br>';

                                $return_html .= '</p>
                                                    </div>
                                                </div>
                                            </div>';
                            }
                        }

                        $return_html .= '</div>
                            </div>
                        </div>';
                        if ($is_business) {
                            $return_html .= '<div class="post-design-commnet-box col-md-12">
                            <div class="post-design-proo-img">';
                            $userid = $this->session->userdata('aileenuser');
                            $business_userimage = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->business_user_image;
                            $business_user = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->company_name;
                            if ($business_userimage) {
                                $return_html .= '<img  src="' . BUS_PROFILE_MAIN_UPLOAD_URL . $business_userimage . '"  alt="">';
                            } else {
                                $return_html .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="">';
                            }
                            $return_html .= '</div>
                            <div id="content" class="col-md-12 inputtype-comment cmy_2">
                                <div contenteditable="true" class="editable_text" name="' . $p['business_profile_post_id'] . '"  id="post_comment' . $p['business_profile_post_id'] . '" placeholder="Add a comment ..." onClick="entercomment(' . $p['business_profile_post_id'] . ')"></div>
                            </div>';
                            $return_html .= form_error('post_comment');
                            $return_html .= '<div class="comment-edit-butn">       
                                <button id="' . $p['business_profile_post_id'] . '" onClick="insert_comment(this.id)">Comment
                                </button>
                            </div>
                        </div>';
                        }
                        $return_html .= '</div>
                        </div>';
                    }
                }
            }
        } else {
            $return_html .= '<div class="text-center rio">
                <h1 class="page-heading  product-listing" style="border:0px;margin-bottom: 11px;">Oops No Data Found.</h1>
                <p style="text-transform:none !important;border:0px;">We couldn\'t find what you were looking for.</p>
                <ul class="padding_less_left">
                    <li style="text-transform:none !important; list-style: none;">Make sure you used the right keywords.</li>
                </ul>
            </div>';
        }
        echo $return_html;
    }

    public function business_profile_active_check() {

        $userid = $this->session->userdata('aileenuser');
        if (!$userid) {
            redirect('login');
        }
// IF USER DEACTIVE PROFILE THEN REDIRECT TO BUSINESS-PROFILE/INDEX UNTILL ACTIVE PROFILE START

        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_deleted' => '0');
        $business_deactive = $this->data['business_deactive'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = ' business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby);

        if ($business_deactive) {
            redirect('business-profile');
        }


// IF USER DEACTIVE PROFILE THEN REDIRECT TO BUSINESS-PROFILE/INDEX UNTILL ACTIVE PROFILE END
// DEACTIVATE PROFILE END
    }

    public function is_business_profile_register() {

        $userid = $this->session->userdata('aileenuser');
        $contition_array = array('user_id' => $userid, 'status' => '1', 'is_deleted' => '0');
        $business_check = $this->data['business_deactive'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = ' business_profile_id,business_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby);

        if ($business_check) {

            if ($business_check[0]['business_step'] == 1) {
                redirect('business-profile/contact-information', refresh);
            } else if ($business_check[0]['business_step'] == 2) {
                redirect('business-profile/description', refresh);
            } else if ($business_check[0]['business_step'] == 3) {
                redirect('business-profile/image', refresh);
            }
        } else {
            redirect('business-profile/business-information-update', refresh);
        }

// IF USER DEACTIVE PROFILE THEN REDIRECT TO BUSINESS-PROFILE/INDEX UNTILL ACTIVE PROFILE END
// DEACTIVATE PROFILE END
    }

// BUSIENSS PROFILE USER FOLLOWING COUNT START

    public function business_user_following_count($business_profile_id = '') {
        $userid = $this->session->userdata('aileenuser');
        if ($business_profile_id == '') {
            $business_profile_id = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->business_profile_id;
        }

        $contition_array = array('follow_from' => $business_profile_id, 'follow_status' => '1', 'follow_type' => '2', 'business_profile.status' => '1');

        $join_str_following[0]['table'] = 'follow';
        $join_str_following[0]['join_table_id'] = 'follow.follow_to';
        $join_str_following[0]['from_table_id'] = 'business_profile.business_profile_id';
        $join_str_following[0]['join_type'] = '';

        $bus_user_f_ing_count = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'count(*) as following_count', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str_following, $groupby = '');

        $following_count = $bus_user_f_ing_count[0]['following_count'];

        return $following_count;
    }

// BUSIENSS PROFILE USER FOLLOWING COUNT END
// BUSIENSS PROFILE USER FOLLOWER COUNT START

    public function business_user_follower_count($business_profile_id = '') {
        $userid = $this->session->userdata('aileenuser');
        if ($business_profile_id == '') {
            $business_profile_id = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->business_profile_id;
        }

        $contition_array = array('follow_to' => $business_profile_id, 'follow_status' => '1', 'follow_type' => '2', 'business_profile.status' => '1');

        $join_str_following[0]['table'] = 'follow';
        $join_str_following[0]['join_table_id'] = 'follow.follow_from';
        $join_str_following[0]['from_table_id'] = 'business_profile.business_profile_id';
        $join_str_following[0]['join_type'] = '';

        $bus_user_f_er_count = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'count(*) as follower_count', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str_following, $groupby = '');

        $follower_count = $bus_user_f_er_count[0]['follower_count'];

        return $follower_count;
    }

// BUSIENSS PROFILE USER FOLLOWER COUNT END
// 
    public function business_user_contacts_count($business_profile_id = '') {

        $userid = $this->session->userdata('aileenuser');
        if ($business_profile_id != '') {
            $userid = $this->db->get_where('business_profile', array('business_profile_id' => $business_profile_id, 'status' => '1'))->row()->user_id;
        }

        $contition_array = array('contact_type' => '2', 'contact_person.status' => 'confirm', 'business_profile.status' => '1');
        $search_condition = "((contact_from_id = ' $userid') OR (contact_to_id = '$userid'))";

        $join_str_contact[0]['table'] = 'business_profile';
        $join_str_contact[0]['join_table_id'] = 'business_profile.user_id';
        $join_str_contact[0]['from_table_id'] = 'contact_person.contact_from_id';
        $join_str_contact[0]['join_type'] = '';

        $contacts_count = $this->common->select_data_by_search('contact_person', $search_condition, $contition_array, $data = 'count(*) as contact_count', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str_contact, $groupby = '');

        $contacts_count = $contacts_count[0]['contact_count'];

        return $contacts_count;
    }

//AJAX BUSIENSS SEARCH WITHOUTL LOGIN START
}
