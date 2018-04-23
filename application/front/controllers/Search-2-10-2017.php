<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Search extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->lang->load('message', 'english');
        //AWS access info start
        $this->load->library('S3');
        //AWS access info end
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
                'status' => 1,
                'module' => '5'
            );

            $insert_id = $this->common->insert_data_getid($data, 'search_info');
            // code for insert search keyword in database end
        }
        if ($search_business == "") {
            $contition_array = array('city' => $cache_time, 'status' => '1', 'business_step' => 4);
            $business_profile = $this->data['results'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } elseif ($search_place == "") {
            $condition_array = array('business_profile_id !=' => '', 'business_profile.status' => '1', 'business_step' => 4);

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

            $condition_array = array('business_step' => 4, 'business_profile_post.is_delete' => '0');
            $search_condition = "(business_profile_post.product_name LIKE '%$search_business%' or business_profile_post.product_description LIKE '%$search_business%')";

            $business_post = $post['data'] = $this->common->select_data_by_search('business_profile_post', $search_condition, $condition_array, $data = 'business_profile_post.*,business_profile.company_name,business_profile.industriyal,business_profile.business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        } else {
            $condition_array = array('business_profile_id !=' => '', 'status' => '1', 'city' => $cache_time, 'business_step' => 4);
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

            $condition_array = array('business_step' => 4, 'business_profile_post.is_delete' => '0');
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
        if ($search_business) {
            $title .= $search_business;
        }
        if ($search_business && $search_place) {
            $title .= ' Business in ';
        }
        if ($search_place) {
            $title .= $search_place;
        }
        $this->data['title'] = "$title | Aileensoul";

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
                'status' => 1,
                'module' => '5'
            );

            $insert_id = $this->common->insert_data_getid($data, 'search_info');
            // code for insert search keyword in database end
        }
        if ($search_business == "") {
            $contition_array = array('city' => $cache_time, 'status' => '1', 'business_step' => 4);
            $business_profile = $this->data['results'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } elseif ($search_place == "") {
            $condition_array = array('business_profile_id !=' => '', 'business_profile.status' => '1', 'business_step' => 4);

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

            $condition_array = array('business_step' => 4, 'business_profile_post.is_delete' => '0');
            $search_condition = "(business_profile_post.product_name LIKE '%$search_business%' or business_profile_post.product_description LIKE '%$search_business%')";

            $business_post = $post['data'] = $this->common->select_data_by_search('business_profile_post', $search_condition, $condition_array, $data = 'business_profile_post.*,business_profile.company_name,business_profile.industriyal,business_profile.business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        } else {
            $condition_array = array('business_profile_id !=' => '', 'status' => '1', 'city' => $cache_time, 'business_step' => 4);
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

            $condition_array = array('business_step' => 4, 'business_profile_post.is_delete' => '0');
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
                        $status = $this->db->get_where('follow', array('follow_type' => 2, 'follow_from' => $main_business_profile_id, 'follow_to' => $p['business_profile_id']))->row()->follow_status;
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
                        if($is_business){
                        $return_html .= '</div>
                                                                                <a href="' . base_url('chat/abc/5/5/' . $p['user_id']) . '"><button onclick="window.location.href = ' . base_url('chat/abc/5/5/' . $p['user_id']) . '"> Message</button></a>
                                                                            </div>';
                        }
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

                        $business_userimage = $this->db->get_where('business_profile', array('user_id' => $p['user_id'], 'status' => 1))->row()->business_user_image;
                        $userimageposted = $this->db->get_where('business_profile', array('user_id' => $p['posted_user_id']))->row()->business_user_image;
                        $slugname = $this->db->get_where('business_profile', array('user_id' => $p['user_id'], 'status' => 1))->row()->business_slug;
                        $slugnameposted = $this->db->get_where('business_profile', array('user_id' => $p['posted_user_id'], 'status' => 1))->row()->business_slug;
                        if ($p['posted_user_id']) {

                            if ($userimageposted) {
                                $return_html .= '<a class="post_dot" href="' . base_url('business-profile/dashboard/' . $slugnameposted) . '" title="">
                                                                                                <img src="' . BUS_PROFILE_MAIN_UPLOAD_URL . $userimageposted . '" name="image_src" id="image_src" />
                                                                                            </a>';
                            } else {
                                $return_html .= '<a class="post_dot" href="' . base_url('business-profile/dashboard/' . $slugnameposted) . '" title="">
                                    <img  src="' . base_url(NOBUSIMAGE) . '"  alt="">';
                            }
                            $return_html .= '</a>';
                        } else {
                            if (file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) && $business_userimage) {
                                $return_html .= '<a class="post_dot" href="' . base_url('business-profile/dashboard/' . $slugname) . '" title="">
                                    <img  src="' . BUS_PROFILE_MAIN_UPLOAD_URL . $business_userimage . '"  alt=""> </a>';
                            } else {
                                $return_html .= '<a class="post_dot" href="' . base_url('business-profile/dashboard/' . $slugname) . '" title="">
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
                                        <a class="post_dot" href="' . base_url('business-profile/dashboard/' . $slugname) . '" title="">' . ucfirst(strtolower($p['company_name'])) . '
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
                            $allowesvideo = array('mp4', 'webm', 'mov', 'MP4');
                            $allowesaudio = array('mp3');
                            $filename = $businessmultiimage[0]['file_name'];
                            $ext = pathinfo($filename, PATHINFO_EXTENSION);
                            if (in_array($ext, $allowed)) {
                                $return_html .= '<div class="one-image" >
                                            <a href="' . base_url('business_profile/postnewpage/' . $p['business_profile_post_id']) . '">
                                                <img src="' . base_url($this->config->item('bus_post_main_upload_path') . $businessmultiimage[0]['file_name']) . '" > 
                                            </a>
                                        </div>';
                            } elseif (in_array($ext, $allowespdf)) {
                                $return_html .= '<div>
                                            <a title="click to open" href="' . base_url('business_profile/creat_pdf/' . $businessmultiimage[0]['post_files_id']) . '">
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
                                            <a href="' . base_url('business_profile/postnewpage/' . $p['business_profile_post_id']) . '">
                                                <img class="two-columns" src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $multiimage['file_name']) . '" > 
                                            </a>
                                        </div>';
                            }
                        } elseif (count($businessmultiimage) == 3) {
                            $return_html .= '<div class="three-image-top">
                                        <a href="' . base_url('business_profile/postnewpage/' . $p['business_profile_post_id']) . '">
                                            <img class="three-columns" src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $businessmultiimage[0]['file_name']) . '"> 
                                        </a>
                                    </div>
                                    <div class="three-image" >
                                        <a href="' . base_url('business_profile/postnewpage/' . $p['business_profile_post_id']) . '">
                                            <img class="three-columns" src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $businessmultiimage[1]['file_name']) . '" > 
                                        </a>
                                    </div>
                                    <div class="three-image" >
                                        <a href="' . base_url('business_profile/postnewpage/' . $p['business_post_id']) . '">
                                            <img class="three-columns" src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $businessmultiimage[2]['file_name']) . '" > 
                                        </a>
                                    </div>';
                        } elseif (count($businessmultiimage) == 4) {
                            foreach ($businessmultiimage as $multiimage) {
                                $return_html .= '<div class="four-image" >
                                            <a href="' . base_url('business_profile/postnewpage/' . $p['business_profile_post_id']) . '">
                                                <img class="breakpoint" src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $multiimage['file_name']) . '" > 
                                            </a>
                                        </div>';
                            }
                        } elseif (count($businessmultiimage) > 4) {
                            $i = 0;
                            foreach ($businessmultiimage as $multiimage) {
                                $return_html .= '<div>
                                            <div class="four-image" >
                                                <a href="' . base_url('business_profile/postnewpage/' . $p['business_profile_post_id']) . '">
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
                                            <a href="' . base_url('business_profile/postnewpage/' . $p['business_profile_post_id']) . '">
                                                <img src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $businessmultiimage[3]['file_name']) . '"> 
                                            </a>
                                        </div>
                                        <div class="four-image" >
                                            <a href="' . base_url('business_profile/postnewpage/' . $p['business_profile_post_id']) . '" ></a>
                                            <a href="' . base_url('business_profile/postnewpage/' . $p['business_profile_post_id']) . '" >
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
                                        <a class="ripple like_h_w" id="' . $p['business_profile_post_id'] . '"   onClick="post_like(this.id)">';

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
                        $return_html .= '<a class="ripple like_h_w" onClick="commentall(this.id)" id="' . $p['business_profile_post_id'] . '">
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
                                $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
                            }
                            $return_html .= '<a href="javascript:void(0);"  onclick="likeuserlist(' . $p['business_profile_post_id'] . ');">';
                            $contition_array = array('business_profile_post_id' => $p['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                            $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                            $likeuser = $commnetcount[0]['business_like_user'];
                            $countlike = $commnetcount[0]['business_likes_count'] - 1;
                            $likelistarray = explode(',', $likeuser);

                            $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
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
                            $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
                        }

                        $return_html .= '<a href="javascript:void(0);"  onclick="likeuserlist(' . $p['business_profile_post_id'] . ');">';
                        $contition_array = array('business_profile_post_id' => $p['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                        $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                        $likeuser = $commnetcount[0]['business_like_user'];
                        $countlike = $commnetcount[0]['business_likes_count'] - 1;
                        $likelistarray = explode(',', $likeuser);

                        $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
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
                                $business_userimage = $this->db->get_where('business_profile', array('user_id' => $pdata['user_id'], 'status' => 1))->row()->business_user_image;
                                if (file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) && $business_userimage) {
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
                                                        <a id="' . $pdata['business_profile_post_comment_id'] . '" onClick="comment_like1(this.id)">';
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
                                                                <a id="' . $pdata['business_profile_post_comment_id'] . '"   onClick="comment_editbox(this.id)" class="editbox">Edit
                                                                </a>
                                                            </div>
                                                            <div id="editcancle' . $pdata['business_profile_post_comment_id'] . '" style="display:none;">
                                                                <a id="' . $pdata['business_profile_post_comment_id'] . '" onClick="comment_editcancle(this.id)">Cancel
                                                                </a>
                                                            </div>
                                                        </div>';
                                }

                                $userid = $this->session->userdata('aileenuser');
                                $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $pdata['business_profile_post_id'], 'status' => 1))->row()->user_id;
                                if ($pdata['user_id'] == $userid || $business_userid == $userid) {

                                    $return_html .= '<span role="presentation" aria-hidden="true"> · 
                                                        </span>
                                                        <div class="comment-details-menu">
                                                            <input type="hidden" name="post_delete"  id="post_delete' . $pdata['business_profile_post_comment_id'] . '" value= "' . $pdata['business_profile_post_id'] . '">
                                                            <a id="' . $pdata['business_profile_post_comment_id'] . '"   onClick="comment_delete(this.id)"> Delete
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
                        if($is_business){
                        $return_html .= '<div class="post-design-commnet-box col-md-12">
                            <div class="post-design-proo-img">';
                        $userid = $this->session->userdata('aileenuser');
                        $business_userimage = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => 1))->row()->business_user_image;
                        $business_user = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => 1))->row()->company_name;
                        if (file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) && $business_userimage) {
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

//recrutier search start

    public function recruiter_index() {

        $user_id = $this->session->userdata('user_id');
        $this->load->view('recruiter/rec_search', $this->data);
    }

    public function recruiter_search($searchkeyword = " ", $searchplace = " ") {

        if ($this->input->get('search_submit')) {
// echo "hhh";die();
            $searchkeyword = $this->input->get('skills');
            $searchplace = $this->input->get('searchplace');
        } else {
// echo "kkk";die();
            if ($this->uri->segment(3) == "0") {

                $searchplace = urldecode($searchplace);
                $searchkeyword = "";
            } else if ($this->uri->segment(4) == "0") {

                $searchkeyword = urldecode($searchkeyword);
                $searchplace = "";
            } else {


                $searchkeyword = urldecode($searchkeyword);
                $searchplace = urldecode($searchplace);
            }
        }

// echo "<pre>"; print_r($_POST);die();

        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');


        if ($searchkeyword == "" && $searchplace == "") {
            redirect('recruiter/recommen_candidate', refresh);
        }


        //echo "string";    echo $searchkeyword; die();

        $rec_search = trim($searchkeyword, ' ');


        //trim($searchkeyword);
        //echo $rec_search; die();


        $this->data['keyword'] = $rec_search;

        $search_place = $searchplace;
        $this->data['key_place'] = $searchplace;


        //insert search keyword into database start

        $cache_time = $this->db->get_where('cities', array('city_name' => $search_place))->row()->city_id;

        $this->data['keyword1'] = $search_place;
        // print_r($searchplace); 
        // print_r($cache_time); 
        // die();



        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 're_status' => '1');
        $this->data['city'] = $city = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 're_comp_city', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        //echo "hi"; die();
        $data = array(
            'search_keyword' => $rec_search,
            'search_location' => $search_place,
            'user_location' => $city[0]['re_comp_city'],
            'user_id' => $userid,
            'created_date' => date('Y-m-d h:i:s', time()),
            'status' => 1,
            'module' => '2'
        );

        //echo"<pre>"; print_r($data); die();

        $insert_id = $this->common->insert_data_getid($data, 'search_info');
        //insert search keyword into database end

        if ($searchkeyword == "" || $this->uri->segment(3) == "0") {
            //echo "skill search";die();
            $join_str = array(array(
                    'join_type' => 'left',
                    'table' => 'job_add_edu',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_add_edu.user_id'),
                array(
                    'join_type' => 'left',
                    'table' => 'job_graduation',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_graduation.user_id')
            );
            $contition_array = array('job_reg.city_id' => $cache_time, 'job_reg.status' => '1', 'job_reg.user_id !=' => $userid, 'job_reg.job_step' => 10);

            $unique = $this->data['results'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_reg.*,job_reg.user_id as iduser,job_add_edu.*,job_graduation.*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
            // echo "<pre>"; print_r($unique);die();
        } elseif ($searchplace == "" || $this->uri->segment(4) == "0") {
            // echo "Place Search";die();
            // echo "<pre>"; print_r($rec_search);die();

            $contition_array = array('is_delete' => '0', 'status' => '1');


            $search_condition = "(skill LIKE '%$rec_search%')";
            // echo $search_condition;die();

            $skilldata = $artdata['data'] = $this->common->select_data_by_search('skill', $search_condition, $contition_array = array(), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            // echo "<pre>"; print_r($skilldata);  die();

            $join_str = array(array(
                    'join_type' => 'left',
                    'table' => 'job_add_edu',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_add_edu.user_id'),
                array(
                    'join_type' => 'left',
                    'table' => 'job_graduation',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_graduation.user_id')
            );
            $contition_array = array('job_reg.status' => '1', 'job_reg.user_id !=' => $userid, 'job_reg.job_step' => 10);
            $jobdata = $userdata['data'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_reg.*,job_reg.user_id as iduser,job_add_edu.*,job_graduation.*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
            //  echo "<pre>"; print_r($jobdata); die();

            foreach ($skilldata as $key) {
                $id = $key['skill_id'];
                // echo $id; echo "<br>";
                foreach ($jobdata as $postskill) {
                    $skill = explode(',', $postskill['keyskill']);

                    //  echo "<pre>"; print_r($skill);

                    if (in_array($id, $skill)) {
                        // echo "Match found"; echo "</br>";
                        // echo $postskill['post_id'];
                        $jobskillpost[] = $postskill;
                    }
                }
            }

            // die();
            //echo "<pre>"; print_r($jobskillpost); die();
            $this->data['rec_skill'] = $jobskillpost;
            // echo "<pre>"; print_r( $this->data['rec_skill']); die();

            $join_str = array(array(
                    'join_type' => 'left',
                    'table' => 'job_add_edu',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_add_edu.user_id'),
                array(
                    'join_type' => 'left',
                    'table' => 'job_graduation',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_graduation.user_id')
            );

            $contition_array1 = array('job_add_edu.pass_year' => $rec_search, 'job_reg.job_step' => 10);

            $yeardata = $userdata['data'] = $this->common->select_data_by_condition('job_reg', $contition_array1, $data = 'job_reg.*,job_reg.user_id as iduser,job_add_edu.*,job_graduation.*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

            // echo "<pre>"; print_r($yeardata); die();

            $join_str = array(array(
                    'join_type' => 'left',
                    'table' => 'job_add_edu',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_add_edu.user_id'),
                array(
                    'join_type' => 'left',
                    'table' => 'job_graduation',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_graduation.user_id')
            );

            $contition_array2 = array('job_reg.gender' => $rec_search, 'job_reg.user_id !=' => $userid, 'job_reg.job_step' => 10);

            $genderdata = $userdata['data'] = $this->common->select_data_by_condition('job_reg', $contition_array2, $data = 'job_reg.*,job_reg.user_id as iduser,job_add_edu.*,job_graduation.*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');


            // echo "<pre>"; print_r($genderdata);

            $contition_array = array('status' => '1', 'user_id !=' => $userid);


            $recdata = $this->data['results'] = $this->common->select_data_by_condition('job_add_workexp', $contition_array, $data = 'sum(experience_year),user_id,sum(experience_month)', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby = 'user_id');


            // echo "<pre>"; print_r($recdata); die();


            foreach ($recdata as $rec) {

                $rec_search = str_replace(' ', '', $rec_search);

                //  echo "<pre>"; print_r($rec_search);



                $y = 0;
                for ($i = 0; $i <= $y; $i++) {
                    if ($rec['sum(experience_month)'] >= 12) {
                        $rec['sum(experience_year)'] = $rec['sum(experience_year)'] + 1;
                        $rec['sum(experience_month)'] = $rec['sum(experience_month)'] - 12;
                        $y++;
                    } else {
                        $y = 0;
                    }
                    $rec['sum(experience_year)'] = $rec['sum(experience_year)'] . 'year';
                    $rec['sum(experience_month)'] = $rec['sum(experience_month)'] . 'month';


                    // echo "<pre>"; print_r($rec['sum(experience_year)']);
                    // echo "<pre>"; print_r($rec['sum(experience_month)']);



                    if (($rec['sum(experience_year)'] == '0year') && (strcmp($rec['sum(experience_month)'], $rec_search) == 0)) {


//echo "string";
                        $join_str = array(array(
                                'join_type' => '',
                                'table' => 'job_add_edu',
                                'join_table_id' => 'job_reg.user_id',
                                'from_table_id' => 'job_add_edu.user_id'),
                            array(
                                'join_type' => '',
                                'table' => 'job_add_workexp',
                                'join_table_id' => 'job_reg.user_id',
                                'from_table_id' => 'job_add_workexp.user_id'),
                            array(
                                'join_type' => 'left',
                                'table' => 'job_graduation',
                                'join_table_id' => 'job_reg.user_id',
                                'from_table_id' => 'job_graduation.user_id')
                        );

                        $contition_array = array('job_reg.user_id' => $rec['user_id'], 'job_reg.job_step' => 10);

                        $resul[] = $jobprofiledata['data'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_reg.*,job_reg.user_id as iduser,job_add_edu.*,job_graduation.*,job_add_workexp.*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
                    } elseif (strcmp($rec['sum(experience_year)'], $rec_search) == 0) {



                        $join_str = array(array(
                                'join_type' => '',
                                'table' => 'job_add_edu',
                                'join_table_id' => 'job_reg.user_id',
                                'from_table_id' => 'job_add_edu.user_id'),
                            array(
                                'join_type' => '',
                                'table' => 'job_add_workexp',
                                'join_table_id' => 'job_reg.user_id',
                                'from_table_id' => 'job_add_workexp.user_id'),
                            array(
                                'join_type' => 'left',
                                'table' => 'job_graduation',
                                'join_table_id' => 'job_reg.user_id',
                                'from_table_id' => 'job_graduation.user_id')
                        );

                        $contition_array = array('job_reg.user_id' => $rec['user_id'], 'job_reg.job_step' => 10);

                        $resul[] = $jobprofiledata['data'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_reg.*,job_reg.user_id as iduser,job_add_edu.*,job_graduation.*,job_add_workexp.*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
                    } else {
                        $resul[] = array();
                    }
                }
            }


            foreach ($resul as $key => $value) {


                foreach ($value as $va) {


                    $result4[] = $va;
                }
            }
            $new3 = array();


            foreach ($result4 as $ke => $arr) {

                /// foreach ($arr as $valu) {




                $new3[$arr['user_id']] = $arr;

                //  }
            }


            // echo "<pre>"; print_r($new3);  die();

            $join_str = array(array(
                    'join_type' => '',
                    'table' => 'job_add_edu',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_add_edu.user_id'),
                array(
                    'join_type' => '',
                    'table' => 'job_add_workexp',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_add_workexp.user_id'),
                array(
                    'join_type' => 'left',
                    'table' => 'job_graduation',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_graduation.user_id')
            );
            $search_condition = "(job_add_workexp.jobtitle LIKE '%$rec_search%')";
            $contition_array = array('job_reg.user_id !=' => $userid, 'job_reg.job_step' => 10);

            $results1 = $jobprofiledata['data'] = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'job_reg.*,job_reg.user_id as iduser,job_add_edu.*,job_graduation.*,job_add_workexp.*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');


//echo "<pre>"; print_r($results1); die();
//echo "<pre>"; print_r($results1); die();

            $join_str = array(array(
                    'join_type' => '',
                    'table' => 'job_add_edu',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_add_edu.user_id'),
                array(
                    'join_type' => 'left',
                    'table' => 'job_graduation',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_graduation.user_id')
            );

            $contition_array = array('job_reg.designation' => $rec_search, 'job_reg.user_id !=' => $userid, 'job_reg.job_step' => 10);

            $jobdata = $userdata['data'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_reg.*,job_reg.user_id as iduser,job_add_edu.*,job_graduation.*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

            //echo "<pre>"; print_r($jobdata); die();
            $join_str = array(array(
                    'join_type' => 'left',
                    'table' => 'job_add_edu',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_add_edu.user_id'),
                array(
                    'join_type' => 'left',
                    'table' => 'job_graduation',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_graduation.user_id')
            );

            $contition_array = array('job_reg.other_skill' => $rec_search, 'job_reg.user_id !=' => $userid, 'job_reg.job_step' => 10);

            $jobdata = $userdata['data'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_reg.*,job_reg.user_id as iduser,job_add_edu.*,job_graduation.*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
            // echo "<pre>"; print_r($designationdata); die();
// ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd

            $recsearch1 = $this->db->get_where('stream', array('stream_name' => $rec_search))->row()->stream_id;

            if ($recsearch1 != "") {
                // echo "pallavi";die();

                $join_str = array(array(
                        'join_type' => 'left',
                        'table' => 'job_add_edu',
                        'join_table_id' => 'job_reg.user_id',
                        'from_table_id' => 'job_add_edu.user_id'),
                    array(
                        'join_type' => 'left',
                        'table' => 'job_graduation',
                        'join_table_id' => 'job_reg.user_id',
                        'from_table_id' => 'job_graduation.user_id')
                );

                $contition_array = array('job_graduation.stream' => $recsearch1, 'job_reg.user_id !=' => $userid, 'job_reg.job_step' => 10, 'job_reg.status' => '1');


                $yeardata = $userdata['data'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_reg.*,job_reg.user_id as iduser,job_add_edu.*,job_graduation.*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
            }


            // echo "<pre>"; print_r($streamdata); die();

            $recsearch = $this->db->get_where('degree', array('degree_name' => $rec_search))->row()->degree_id;

            //echo "<pre>"; print_r($recsearch); 

            if ($recsearch != "") {

                $join_str = array(array(
                        'join_type' => 'left',
                        'table' => 'job_add_edu',
                        'join_table_id' => 'job_reg.user_id',
                        'from_table_id' => 'job_add_edu.user_id'),
                    array(
                        'join_type' => 'left',
                        'table' => 'job_graduation',
                        'join_table_id' => 'job_reg.user_id',
                        'from_table_id' => 'job_graduation.user_id')
                );


                $contition_array = array('job_graduation.degree' => $recsearch, 'job_reg.user_id !=' => $userid, 'job_reg.job_step' => 10, 'job_reg.status' => '1');

                $yeardata = $userdata['data'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_reg.*,job_reg.user_id as iduser,job_add_edu.*,job_graduation.*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
            }

            // echo "<pre>"; print_r($yeardata); 
            // die();
            //echo "<pre>"; print_r($degreedata); 


            foreach ($jobskillpost as $ke => $arr) {

                $postdata1[] = $arr;
            }
            // echo "string";  echo '<pre>'; print_r($postdata1); die();

            $new1 = array();
            foreach ($postdata1 as $value) {
                //echo "skill & place both serach";die();
                $new1[$value['job_id']] = $value;
            }

            // echo '<pre>'; print_r($new1); die();
            // echo count($new1); die();

            if (count($new1) == 0) {


                // echo "pallavidsd";
                // echo "<pre>"; print_r($results1); die();

                $unique = array_merge($yeardata, $genderdata, $results1, $new3, $jobdata);
                // echo count($unique) . "<br>"; die();
                //echo "<pre>"; print_r($unique); die();
            } else {




                ///echo "vaghela";
                $unique = array_merge($new1, $yeardata, $genderdata, $results1, $new3, $jobdata);

                //  echo "<pre>"; print_r($unique); die();
            }
        } else {

            //echo "Skill & Place  Search";die();

            $contition_array = array('is_delete' => '0', 'status' => '1');


            $results = array_unique($result);
            foreach ($results as $key => $value) {
                $result1[$key]['label'] = $value;
                $result1[$key]['value'] = $value;
            }

            $search_condition = "(skill LIKE '%$rec_search%')";

            $skilldata = $artdata['data'] = $this->common->select_data_by_search('skill', $search_condition, $contition_array = array(), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            // echo "<pre>"; print_r($artdata['data']);


            $join_str = array(array(
                    'join_type' => 'left',
                    'table' => 'job_add_edu',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_add_edu.user_id'),
                array(
                    'join_type' => 'left',
                    'table' => 'job_graduation',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_graduation.user_id')
            );
            $contition_array = array('job_reg.status' => '1', 'job_reg.city_id' => $cache_time, 'job_reg.user_id !=' => $userid, 'job_reg.job_step' => 10);
            $jobdata = $userdata['data'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_reg.*,job_reg.user_id as iduser,job_add_edu.*,job_graduation.*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
            //  echo "<pre>"; print_r($jobdata); die();



            $this->data['demo'] = array_values($result1);
            foreach ($skilldata as $key) {
                $id = $key['skill_id'];
                // echo $id; echo "<br>";
                foreach ($jobdata as $postskill) {
                    $skill = explode(',', $postskill['keyskill']);



                    if (in_array($id, $skill)) {
                        // echo "Match found"; echo "</br>";
                        // echo $postskill['post_id'];
                        $jobskillpost[] = $postskill;
                    }
                }
            }




            //echo "<pre>"; print_r($jobskillpost); die();
            $this->data['rec_skill'] = $jobskillpost;
            //echo "<pre>"; print_r($jobskillpost);  die();





            $join_str = array(array(
                    'join_type' => 'left',
                    'table' => 'job_add_edu',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_add_edu.user_id'),
                array(
                    'join_type' => 'left',
                    'table' => 'job_graduation',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_graduation.user_id')
            );

            $contition_array1 = array('job_add_edu.pass_year' => $rec_search, 'job_reg.user_id !=' => $userid, 'job_reg.job_step' => 10);

            $adddata = $userdata['data'] = $this->common->select_data_by_condition('job_reg', $contition_array1, $data = 'job_reg.*,job_reg.user_id as iduser,job_add_edu.*,job_graduation.*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

            // echo "<pre>"; print_r($yeardata); die();

            $join_str = array(array(
                    'join_type' => 'left',
                    'table' => 'job_add_edu',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_add_edu.user_id'),
                array(
                    'join_type' => 'left',
                    'table' => 'job_graduation',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_graduation.user_id')
            );
            $contition_array = array('job_reg.designation' => $rec_search, 'job_reg.user_id !=' => $userid, 'job_reg.job_step' => 10);

            $jobdata = $userdata['data'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_reg.*,job_reg.user_id as iduser,job_add_edu.*,job_graduation.*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');




            $join_str = array(array(
                    'join_type' => 'left',
                    'table' => 'job_add_edu',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_add_edu.user_id'),
                array(
                    'join_type' => 'left',
                    'table' => 'job_graduation',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_graduation.user_id')
            );
            $contition_array2 = array('job_reg.gender' => $rec_search, 'job_reg.city_id' => $cache_time, 'job_reg.user_id !=' => $userid, 'job_reg.job_step' => 10);

            $genderdata = $userdata['data'] = $this->common->select_data_by_condition('job_reg', $contition_array2, $data = 'job_reg.*,job_reg.user_id as iduser,job_add_edu.*,job_graduation.*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

            //  echo "<pre>"; print_r($genderdata); die();


            $contition_array = array('status' => '1', 'user_id !=' => $userid);


            $recdata = $this->data['results'] = $this->common->select_data_by_condition('job_add_workexp', $contition_array, $data = 'sum(experience_year),user_id,sum(experience_month)', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby = 'user_id');


            foreach ($recdata as $rec) {

                $rec_search = str_replace(' ', '', $rec_search);



                $y = 0;
                for ($i = 0; $i <= $y; $i++) {
                    if ($rec['sum(experience_month)'] >= 12) {
                        $rec['sum(experience_year)'] = $rec['sum(experience_year)'] + 1;
                        $rec['sum(experience_month)'] = $rec['sum(experience_month)'] - 12;
                        $y++;
                    } else {
                        $y = 0;
                    }
                    $rec['sum(experience_year)'] = $rec['sum(experience_year)'] . 'year';
                    $rec['sum(experience_month)'] = $rec['sum(experience_month)'] . 'month';


                    if (($rec['sum(experience_year)'] == '0year') && (strcmp($rec['sum(experience_month)'], $rec_search) == 0)) {


//echo "string";
                        $join_str = array(array(
                                'join_type' => '',
                                'table' => 'job_add_edu',
                                'join_table_id' => 'job_reg.user_id',
                                'from_table_id' => 'job_add_edu.user_id'),
                            array(
                                'join_type' => '',
                                'table' => 'job_add_workexp',
                                'join_table_id' => 'job_reg.user_id',
                                'from_table_id' => 'job_add_workexp.user_id'),
                            array(
                                'join_type' => 'left',
                                'table' => 'job_graduation',
                                'join_table_id' => 'job_reg.user_id',
                                'from_table_id' => 'job_graduation.user_id')
                        );

                        $contition_array = array('job_reg.user_id' => $rec['user_id'], 'job_reg.job_step' => 10);

                        $resul[] = $jobprofiledata['data'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_reg.*,job_reg.user_id as iduser,job_add_edu.*,job_graduation.*,job_add_workexp.*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
                    } elseif (strcmp($rec['sum(experience_year)'], $rec_search) == 0) {


//echo "string11";
                        $join_str = array(array(
                                'join_type' => '',
                                'table' => 'job_add_edu',
                                'join_table_id' => 'job_reg.user_id',
                                'from_table_id' => 'job_add_edu.user_id'),
                            array(
                                'join_type' => '',
                                'table' => 'job_add_workexp',
                                'join_table_id' => 'job_reg.user_id',
                                'from_table_id' => 'job_add_workexp.user_id'),
                            array(
                                'join_type' => 'left',
                                'table' => 'job_graduation',
                                'join_table_id' => 'job_reg.user_id',
                                'from_table_id' => 'job_graduation.user_id')
                        );

                        $contition_array = array('job_reg.user_id' => $rec['user_id'], 'job_reg.job_step' => 10);

                        $resul[] = $jobprofiledata['data'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_reg.*,job_reg.user_id as iduser,job_add_edu.*,job_graduation.*,job_add_workexp.*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
                    } else {
                        $resul[] = array();
                    }
                }
            }

            foreach ($resul as $key => $value) {


                foreach ($value as $va) {


                    $result4[] = $va;
                }
            }
            $new3 = array();


            foreach ($result4 as $ke => $arr) {

                /// foreach ($arr as $valu) {




                $new3[$arr['user_id']] = $arr;

                //  }
            }


            $join_str = array(array(
                    'join_type' => '',
                    'table' => 'job_add_edu',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_add_edu.user_id'),
                array(
                    'join_type' => '',
                    'table' => 'job_add_workexp',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_add_workexp.user_id'),
                array(
                    'join_type' => 'left',
                    'table' => 'job_graduation',
                    'join_table_id' => 'job_reg.user_id',
                    'from_table_id' => 'job_graduation.user_id')
            );
            $search_condition = "(job_add_workexp.jobtitle LIKE '%$rec_search%')";
            $contition_array = array('job_reg.user_id !=' => $userid, 'job_reg.job_step' => 10);

            $results1 = $jobprofiledata['data'] = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'job_reg.*,job_reg.user_id as iduser,job_add_edu.*,job_graduation.*,job_add_workexp.*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');


//echo "<pre>"; print_r($results1); die();



            $recsearch1 = $this->db->get_where('stream', array('stream_name' => $rec_search))->row()->stream_id;

            if ($recsearch1 != "") {
                // echo "pallavi";die();

                $join_str = array(array(
                        'join_type' => 'left',
                        'table' => 'job_add_edu',
                        'join_table_id' => 'job_reg.user_id',
                        'from_table_id' => 'job_add_edu.user_id'),
                    array(
                        'join_type' => 'left',
                        'table' => 'job_graduation',
                        'join_table_id' => 'job_reg.user_id',
                        'from_table_id' => 'job_graduation.user_id')
                );

                $contition_array = array('job_add_edu.stream' => $recsearch1, 'job_reg.user_id !=' => $userid, 'job_reg.job_step' => 10);


                $adddata = $userdata['data'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_reg.*,job_reg.user_id as iduser,job_add_edu.*,job_graduation.*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
            }


            //echo "<pre>"; print_r($adddata); die();

            $recsearch = $this->db->get_where('degree', array('degree_name' => $rec_search))->row()->degree_id;

            if ($recsearch != "") {

                $join_str = array(array(
                        'join_type' => 'left',
                        'table' => 'job_add_edu',
                        'join_table_id' => 'job_reg.user_id',
                        'from_table_id' => 'job_add_edu.user_id'),
                    array(
                        'join_type' => 'left',
                        'table' => 'job_graduation',
                        'join_table_id' => 'job_reg.user_id',
                        'from_table_id' => 'job_graduation.user_id')
                );
                $contition_array = array('job_add_edu.degree' => $recsearch, 'job_reg.user_id !=' => $userid, 'job_reg.job_step' => 10);


                $adddata = $userdata['data'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_reg.*,job_reg.user_id as iduser,job_add_edu.*,job_graduation.*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
            }
            // echo "<pre>"; print_r($adddata); die();


            foreach ($jobskillpost as $ke => $arr) {

                $postdata1[] = $arr;
            }

            $new1 = array();
            foreach ($postdata1 as $value) {
                //echo "hi";
                $new1[$value['job_id']] = $value;
            }

            // echo '<pre>'; print_r($new1); die();

            if (count($new1) == 0) {
                $unique = array_merge($adddata, $genderdata, $results1, $new3, $jobdata);
                // echo count($unique) . "<br>"; die();
                // echo "<pre>"; print_r($unique); die();
            } else {

                //echo "hi"; die();
                $unique = array_merge($new1, $adddata, $genderdata, $results1, $new3, $jobdata);
            }
            // echo "<pre>"; print_r($unique); die();
        }


        // echo "<pre>"; print_r($unique); die();

        foreach ($unique as $ke => $arr) {

            $skildataa[] = $arr;
        }
//echo "<pre>";print_r($postdata);
        $new11 = array();
        foreach ($skildataa as $value) {
            $new11[$value['user_id']] = $value;
        }

        $this->data['postdetail'] = $new11;
        //  echo "<pre>"; print_r($new11); die();

        $contition_array = array('status' => '1', 'is_delete' => '0', 'job_step' => 10);


        $recdata = $this->data['results'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'other_skill,designation', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        // echo "<pre>"; print_r($recdata); die();
        $contition_array = array('status' => '1');

        $jobdata1 = $this->data['results'] = $this->common->select_data_by_condition('job_add_workexp', $contition_array, $data = 'jobtitle', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);


        $contition_array = array('status' => '1');

        $degreedata = $this->data['results'] = $this->common->select_data_by_condition('degree', $contition_array, $data = 'degree_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);


        $contition_array = array('status' => '1');

        $streamdata = $this->data['results'] = $this->common->select_data_by_condition('stream', $contition_array, $data = 'stream_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);


        $contition_array = array('status' => '1', 'type' => '1');

        $skill = $this->data['results'] = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        // echo "<pre>"; print_r($artpost);die();


        $uni = array_merge($recdata, $jobdata1, $degreedata, $streamdata, $skill);
        //   echo count($unique);


        foreach ($uni as $key => $value) {
            foreach ($value as $ke => $val) {
                if ($val != "") {


                    $result[] = $val;
                }
            }
        }
        $results = array_unique($result);
        foreach ($results as $key => $value) {
            $result1[$key]['label'] = $value;
            $result1[$key]['value'] = $value;
        }
//echo '<pre>'; print_r($result1); die();

        $this->data['demo'] = array_values($result1);

        $contition_array = array('status' => '1');


        $cty = $this->data['cty'] = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);


        foreach ($cty as $key => $value) {
            foreach ($value as $ke => $val) {
                if ($val != "") {


                    $resu[] = $val;
                }
            }
        }
        $resul = array_unique($resu);
        foreach ($resul as $key => $value) {
            $res[$key]['label'] = $value;
            $res[$key]['value'] = $value;
        }

        $this->data['de'] = array_values($res);

        // echo "<pre>"; print_r($this->data['de']);die();
        // echo "<pre>"; print_r($this->data['postdetail']); die();

        $title = '';
        if ($searchkeyword) {
            $title .= $searchkeyword;
        }
        if ($searchkeyword && $search_place) {
            $title .= ' Job Seeker in ';
        }
        if ($search_place) {
            $title .= $search_place;
        }
        $this->data['title'] = "$title | Aileensoul";
        $this->data['head'] = $this->load->view('head', $this->data, TRUE);

        $this->load->view('recruiter/recommen_candidate1', $this->data);
    }

//recrutier search end
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
                'status' => 1,
                'module' => '3'
            );

            $insert_id = $this->common->insert_data_getid($data, 'search_info');
        }

        $title = '';
        if ($searchkeyword) {
            $title .= 'Hire ';
            $title .= $searchkeyword;
        }
        if ($searchkeyword && $search_place) {
            $title .= ' Freelancer in ';
        }
        if ($search_place) {
            $title .= $search_place;
        }
        $this->data['title'] = "$title | Aileensoul";
        $this->data['head'] = $this->load->view('head', $this->data, TRUE);
        //THIS CODE IS FOR WHEN USER NOT LOGIN AND GET SEARCH DATA START
        if ($this->session->userdata('aileenuser')) {
            $userid = $this->session->userdata('aileenuser');
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => 1, 'free_hire_step' => 3);
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
            $contition_array = array('freelancer_post_city' => $cache_time, 'status' => '1', 'freelancer_post_reg.user_id !=' => $userid, 'free_post_step' => 7);
            $unique = $this->data['results'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } elseif ($searchplace == "" || $this->uri->segment(4) == "0") {

            $contition_array = array('status' => '1', 'type' => '1');
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
//echo '<pre>'; print_r($result); die();
            foreach ($skillid as $key => $value) {
                $contition_array = array('status' => '1', 'is_delete' => '0', 'free_post_step' => 7, 'user_id != ' => $userid, 'FIND_IN_SET("' . $value['skill_id'] . '", freelancer_post_area) != ' => '0');
                $candidate[] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_fullname, freelancer_post_username, freelancer_post_city, freelancer_post_area,freelancer_post_field, freelancer_post_skill_description, freelancer_post_hourly, freelancer_post_ratestate, freelancer_post_fixed_rate, freelancer_post_work_hour, user_id, freelancer_post_user_image, designation, freelancer_post_otherskill, freelancer_post_exp_month, freelancer_post_exp_year,freelancer_apply_slug,freelancer_post_reg_id', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            }
            //  echo "<pre>"; print_r($candidate); die();
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

            $contition_array = array('freelancer_post_field' => $category_temp, 'user_id !=' => $userid, 'free_post_step' => 7, 'status' => '1');
            $fieldfound = $this->data['field'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_fullname, freelancer_post_username, freelancer_post_city, freelancer_post_area,freelancer_post_field, freelancer_post_skill_description, freelancer_post_hourly, freelancer_post_ratestate, freelancer_post_fixed_rate, freelancer_post_work_hour, user_id, freelancer_post_user_image, designation, freelancer_post_otherskill, freelancer_post_exp_month, freelancer_post_exp_year,freelancer_apply_slug,freelancer_post_reg_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby);

            $contition_array = array('status' => '1', 'is_delete' => '0', 'user_id !=' => $userid, 'free_post_step' => 7);
            $search_condition = "(designation LIKE '%$search_skill%' or freelancer_post_otherskill LIKE '%$search_skill%' or freelancer_post_exp_month LIKE '%$search_skill%' or freelancer_post_exp_year LIKE '%$search_skill%')";
            $otherdata = $other['data'] = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'freelancer_post_fullname, freelancer_post_username, freelancer_post_city, freelancer_post_area,freelancer_post_field, freelancer_post_skill_description, freelancer_post_hourly, freelancer_post_ratestate, freelancer_post_fixed_rate, freelancer_post_work_hour, user_id, freelancer_post_user_image, designation, freelancer_post_otherskill, freelancer_post_exp_month, freelancer_post_exp_year,freelancer_apply_slug,freelancer_post_reg_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $new1 = array_merge(array($candidate), array($fieldfound), array($otherdata));
            $candidate_11 = array_reduce($new1, 'array_merge', array());

            $unique = array();
            foreach ($candidate_11 as $value) {
                $unique[$value['freelancer_post_reg_id']] = $value;
            }
        } else {
            //   echo "Both";

            $temp = $this->db->get_where('skill', array('skill' => $search_skill, 'status' => 1))->row()->skill_id;
            $contition_array = array('status' => '1', 'is_delete' => '0', 'freelancer_post_city' => $cache_time, 'free_post_step' => 7, 'user_id != ' => $userid, 'FIND_IN_SET("' . $temp . '", freelancer_post_area) != ' => '0');
            $candidate = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_fullname, freelancer_post_username, freelancer_post_city, freelancer_post_area,freelancer_post_field, freelancer_post_skill_description, freelancer_post_hourly, freelancer_post_ratestate, freelancer_post_fixed_rate, freelancer_post_work_hour, user_id, freelancer_post_user_image, designation, freelancer_post_otherskill, freelancer_post_exp_month, freelancer_post_exp_year,freelancer_apply_slug,freelancer_post_reg_id', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            $category_temp = $this->db->get_where('category', array('category_name' => $search_skill, 'status' => '1'))->row()->category_id;

            $contition_array = array('freelancer_post_field' => $category_temp, 'user_id !=' => $userid, 'free_post_step' => 7, 'status' => '1', 'freelancer_post_city' => $cache_time);
            $fieldfound = $this->data['field'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_fullname, freelancer_post_username, freelancer_post_city, freelancer_post_area, freelancer_post_field,freelancer_post_skill_description, freelancer_post_hourly, freelancer_post_ratestate, freelancer_post_fixed_rate, freelancer_post_work_hour, user_id, freelancer_post_user_image, designation, freelancer_post_otherskill, freelancer_post_exp_month, freelancer_post_exp_year,freelancer_apply_slug,freelancer_post_reg_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby);

            $contition_array = array('status' => '1', 'is_delete' => '0', 'user_id !=' => $userid, 'free_post_step' => 7, 'freelancer_post_city' => $cache_time);
            $search_condition = "(designation LIKE '%$search_skill%' or freelancer_post_otherskill LIKE '%$search_skill%' or freelancer_post_exp_month LIKE '%$search_skill%' or freelancer_post_exp_year LIKE '%$search_skill%')";
            $otherdata = $other['data'] = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'freelancer_post_fullname, freelancer_post_username, freelancer_post_city, freelancer_post_area,freelancer_post_field, freelancer_post_skill_description, freelancer_post_hourly, freelancer_post_ratestate, freelancer_post_fixed_rate, freelancer_post_work_hour, user_id, freelancer_post_user_image, designation, freelancer_post_otherskill, freelancer_post_exp_month, freelancer_post_exp_year,freelancer_apply_slug,freelancer_post_reg_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            // $unique = array_merge($candidate, $fieldfound, $otherdata);
            $new1 = array_merge($candidate, $fieldfound, $otherdata);

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

        if (count($unique) > 0) {
            foreach ($freelancerpostdata1 as $row) {
                $return_html .= '<div class="profile-job-post-detail clearfix search">
                                                        <div class="profile-job-post-title-inside clearfix">
                                                            <div class="profile-job-profile-button clearfix">
                                                                <div class="profile-job-post-location-name-rec">
                                                                    <div style="display: inline-block; float: left;">
                                                                        <div  class="buisness-profile-pic-candidate">';
                if ($row['freelancer_post_user_image']) {
                    $return_html .= '<a style="margin-right: 4px;" href="' . base_url('freelancer-work/freelancer-details/' . $row['freelancer_apply_slug'] . '?page=freelancer_hire') . '" title=" ' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">';
                    $return_html .= '<img src="' . FREE_POST_PROFILE_THUMB_UPLOAD_URL . $row['freelancer_post_user_image'] . '" alt="' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '" > </a>';
                } else {
                    $return_html .= '<a href = "' . base_url('freelancer-work/freelancer-details/' . $row['freelancer_apply_slug'] . '?page=freelancer_hire') . '" title = "' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">';
                    $post_fname = $row['freelancer_post_fullname'];
                    $post_lname = $row['freelancer_post_username'];
                    $sub_post_fname = substr($post_fname, 0, 1);
                    $sub_post_lname = substr($post_lname, 0, 1);
                    $return_html .= '<div class = "post-img-div">';
                    $return_html .= ucfirst(strtolower($sub_post_fname)) . ucfirst(strtolower($sub_post_lname));
                    $return_html .= '</div>
                </a>';
//                    $return_html .= '<a style="margin-right: 4px;" href="' . base_url('freelancer-work/freelancer-details/' . $row['freelancer_apply_slug'] . '?page=freelancer_hire') . '" title="' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">';
//                    $return_html .= '<img src="' . base_url(NOIMAGE) . '" alt="' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '"> </a>';
                }
                $return_html .= '</div></div>
                                                                    <div class="designation_rec" style="float: left;">
                                                                        <ul>
                                                                            <li>';
                if ($userid) {
                    $return_html .= '<a style="margin-right: 4px;" href="' . base_url('freelancer-work/freelancer-details/' . $row['freelancer_apply_slug'] . '?page=freelancer_hire') . '" title="' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '"><h6>';
                    $return_html .= ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']);
                    $return_html .= '</h6>
                                                                                </a>
                                                                            </li>';
                } else {
                    $return_html .= '<a style="margin-right: 4px;" onclick="login_profile();" href="javascript:void(0);" title="' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '"><h6>';
                    $return_html .= ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']);
                    $return_html .= '</h6>
                    </a>';
                }
                $return_html .= '<li style="display: block;" ><a href="#">';
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
                 if($row['freelancer_post_field']){
                    $field_name = $this->db->get_where('category', array('category_id' => $row['freelancer_post_field']))->row()->category_name;
                    $return_html .= $field_name;
                }
                else{
                    $return_html .= PROFILENA;
                }
                
                  $return_html .='</li></span><li><b>Skills</b><span>';
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
                $return_html .= '<li><b>Location</b><span>';
                if ($cityname) {
                    $return_html .= $cityname;
                } else {
                    $return_html .= PROFILENA;
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

                    $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => 1, 'free_hire_step' => 3);
                    $free_hire_result = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'reg_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    if ($free_hire_result) {
                        $contition_array = array('from_id' => $userid, 'to_id' => $row['user_id'], 'save_type' => 2, 'status' => '0');
                        $data = $this->common->select_data_by_condition('save', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                        if ($userid != $row['user_id']) {
                            $return_html .= '<a href="' . base_url('chat/abc/3/4/' . $row['user_id']) . '">Message</a>';
                            if (!$data) {
                                $return_html .= '<input type="hidden" id="hideenuser' . $row['user_id'] . '" value= "' . $data[0]['save_id'] . '">';
                                $return_html .= '<a id="' . $row['user_id'] . '" onClick="savepopup(' . $row['user_id'] . ')" href="javascript:void(0);" class="saveduser' . $row['user_id'] . '">Save</a>';
                            } else {
                                $return_html .= '<a class="saved">Saved </a>';
                            }
                        }
                    } else {
                        $return_html .= '<a href="' . base_url('freelancer-hire/basic-information') . '"> Message </a>';
                        $return_html .= '<a href="' . base_url('freelancer-hire/basic-information') . '"> Save </a>';
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
                                                <h1 class="page-heading  product-listing" >';
            $return_html .= $this->lang->line("oops_no_data");
            $return_html .= '</h1><p>';
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
        $userid = $this->session->userdata('aileenuser');
        if ($this->input->get('searchplace') == "" && $this->input->get('skills') == "") {
            redirect('freelancer/freelancer_apply_post', refresh);
        }
        $search_skill = trim($this->input->get('skills'));
        $this->data['keyword'] = $search_skill;
        $search_place = trim($this->input->get('searchplace'));
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
                'status' => 1,
                'module' => '4'
            );

            //   echo"<pre>"; print_r($data); die();
            $insert_id = $this->common->insert_data_getid($data, 'search_info');
// code for insert search keyword into database end
        }
        $title = '';
        if ($search_skill) {
            $title .= $search_skill;
        }
        if ($search_skill && $search_place) {
            $title .= ' Freelancer in ';
        }
        if ($search_place) {
            $title .= $search_place;
        }
        $this->data['title'] = "$title | Aileensoul";
        $this->data['head'] = $this->load->view('head', $this->data, TRUE);

        //THIS CODE IS FOR WHEN USER NOT LOGIN AND GET SEARCH DATA START
        if ($this->session->userdata('aileenuser')) {
            $userid = $this->session->userdata('aileenuser');
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => 1, 'free_post_step' => 7);
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
        if ($search_skill == "") {

//$contition_array = array('freelancer_post.city' => $search_place[0], 'freelancer_hire_reg.status' => '1');
            $join_str[0]['table'] = 'freelancer_post';
            $join_str[0]['join_table_id'] = 'freelancer_post.user_id';
            $join_str[0]['from_table_id'] = 'freelancer_hire_reg.user_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('freelancer_post.city' => $cache_time, 'freelancer_hire_reg.status' => '1', 'freelancer_hire_reg.user_id !=' => $userid, 'freelancer_hire_reg.free_hire_step' => 3);
            $new = $this->data['results'] = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

            //echo "<pre>"; print_r($unique);die();
        } elseif ($search_place == "") {

            $temp = $this->db->get_where('skill', array('skill' => $search_skill, 'status' => 1, 'type' => '1'))->row()->skill_id;
            $contition_array = array('status' => '1', 'is_delete' => '0', 'user_id != ' => $userid, 'FIND_IN_SET("' . $temp . '", post_skill) != ' => '0');
            $freeskillpost = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $category_temp = $this->db->get_where('category', array('category_name' => $search_skill, 'status' => '1'))->row()->category_id;
            $contition_array = array('post_field_req' => $category_temp, 'user_id !=' => $userid, 'status' => '1', 'city' => $cache_time);
            $fieldfound = $this->data['field'] = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby);

            $search_condition = "(post_name LIKE '%$search_skill%' or post_other_skill LIKE '%$search_skill%' or post_est_time LIKE '%$search_skill%' or post_rate LIKE '%$search_skill%' or  post_exp_year LIKE '%$search_skill%' or  post_exp_month LIKE '%$search_skill%')";
            $contion_array = array('freelancer_post.user_id !=' => $userid);
            $freeldata = $this->common->select_data_by_search('freelancer_post', $search_condition, $contion_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            //echo "<pre>";print_r($freeldata);die();
            $unique = array_merge($freeskillpost, $freeldata, $fieldfound);
            $new = array();
            foreach ($unique as $value) {
                $new[$value['post_id']] = $value;
            }
        } else {

            $temp = $this->db->get_where('skill', array('skill' => $search_skill, 'status' => 1, 'type' => '1'))->row()->skill_id;
            $contition_array = array('status' => '1', 'is_delete' => '0', 'city' => $cache_time, 'user_id != ' => $userid, 'FIND_IN_SET("' . $temp . '", post_skill) != ' => '0');
            $freeskillpost = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $category_temp = $this->db->get_where('category', array('category_name' => $search_skill, 'status' => '1'))->row()->category_id;
            // echo $category_temp;die();
            $contition_array = array('post_field_req' => $category_temp, 'user_id !=' => $userid, 'status' => '1', 'is_delete' => 0, 'city' => $cache_time);
            $fieldfound = $this->data['field'] = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby);

            //  echo "<pre>"; print_r($fieldfound);die();
            $search_condition = "(post_name LIKE '%$search_skill%' or post_other_skill LIKE '%$search_skill%' or post_est_time LIKE '%$search_skill%' or post_rate LIKE '%$search_skill%' or  post_exp_year LIKE '%$search_skill%' or  post_exp_month LIKE '%$search_skill%')";
            $contion_array = array('city' => $cache_time, 'freelancer_post.user_id !=' => $userid);
            $freeldata = $this->common->select_data_by_search('freelancer_post', $search_condition, $contion_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $unique = array_merge($freeskillpost, $freeldata, $fieldfound);
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

        if (count($new) > 0) {
            // echo count($freelancerhiredata1);
            foreach ($freelancerhiredata1 as $post) {

                $userid = $this->session->userdata('aileenuser');
                $contition_array = array('user_id' => $userid, 'post_id' => $post['post_id'], 'job_delete' => 0);
                $jobdata = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if ($jobdata[0]['job_save'] != 2) {
                    $return_html .= '<div class="job-post-detail clearfix search">
                                                        <div class="job-contact-frnd ">';
                    $return_html .= '<div class="profile-job-post-detail clearfix" id="removeapply' . $post['post_id'] . '">';
                    $return_html .= '<div class="profile-job-post-title-inside clearfix">
                                                                    <div class="profile-job-post-title clearfix  margin_btm" >
                                                                        <div class="profile-job-profile-button clearfix">
                                                                            <div class="profile-job-details col-md-12">
                                                                                <ul>
                                                                                    <li class="fr">';

                    $return_html .= $this->lang->line("created_date");
                    $return_html .= ':';
                    $return_html .= trim(date('d-M-Y', strtotime($post['created_date'])));
                    $return_html .= ' </li>
                                                                                    <li>';

                    $return_html .= '<a href="#" title="Post Title" class="post_title " >';
                    $return_html .= ucwords($this->text2link($post['post_name']));
                    $return_html .= '</a> </li>';

                    $firstname = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->fullname;
                    $lastname = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->username;
                    $hireslug = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id'], 'status' => 1))->row()->freelancer_hire_slug;
                    $return_html .= '<li>';
                    if ($userid) {
                        $return_html .= '<a class="display_inline" title="' . ucwords($firstname) . " " . ucwords($lastname) . '" href="' . base_url('freelancer-hire/employer-details/' . $hireslug . '?page=freelancer_post') . '">';
                        $return_html .= ucwords($firstname) . " " . ucwords($lastname);
                        $return_html .= '</a>';
                    } else {
                        $return_html .= '<a class="display_inline" title="' . ucwords($firstname) . " " . ucwords($lastname) . '" href="javascript:void(0);" onclick="login_profile();"> ';
                        $return_html .= ucwords($firstname) . " " . ucwords($lastname);
                        $return_html .= '</a>';
                    }
                    $cityname = $this->db->get_where('cities', array('city_id' => $post['city']))->row()->city_name;
                    $countryname = $this->db->get_where('countries', array('country_id' => $post['country']))->row()->country_name;
                    if ($cityname || $countryname) {
                        $return_html .= '<div class="fr lction">
                                                 <p><span title="Location">
                                                     <i class="fa fa-map-marker" aria-hidden="true"></i>';
                        if ($cityname) {
                            $return_html .= $cityname . ",";
                        }
                        $return_html .= $countryname;
                        $return_html .= '';
                    }
                    $return_html .= '</span>
                                           </p>
                                              </div>';

                    $return_html .= '</li>
                                          </ul>
                                             </div>
                                                 </div>
                                                     <div class="profile-job-profile-menu">
                                                        <ul class="clearfix">
                                                                <li> <b>';
                    $return_html .= $this->lang->line("field");
                    $return_html .= '</b> 
                                        <span>';
                    $return_html .= $this->db->get_where('category', array('category_id' => $post['post_field_req']))->row()->category_name;
                    $return_html .= '</span>
                                          </li>
                                              <li> <b>';
                    $return_html .= $this->lang->line("skill");
                    $return_html .= '</b> <span>';

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
                            $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;
                            $return_html .= $cache_time;
                            $k++;
                        }
                    } else if ($post['post_skill'] && $post['post_other_skill']) {
                        foreach ($aud_res as $skill) {
                            if ($k != 0) {
                                $return_html .= $comma;
                            }
                            $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;
                            $return_html .= $cache_time;
                            $k++;
                        } $return_html .= "," . $post['post_other_skill'];
                    }

                    $return_html .= '</span>
                                                                                <li><b>';
                    $return_html .= $this->lang->line("project_description");
                    $return_html .= '</b><span><p>';

                    if ($post['post_description']) {
                        $return_html .= $this->text2link($post['post_description']);
                    } else {
                        $return_html .= PROFILENA;
                    }
                    $return_html .= '</p></span>
                                                </li>
                                                  <li><b>';
                    $return_html .= $this->lang->line("rate");
                    $return_html .= '</b><span>';

                    if ($post['post_rate']) {
                        $return_html .= $post['post_rate'];
                        $return_html .= "&nbsp";
                        $return_html .= $this->db->get_where('currency', array('currency_id' => $post['post_currency']))->row()->currency_name;
                        $return_html .= "&nbsp";
                        if ($post['post_rating_type'] == 1) {
                            $return_html .= "Hourly";
                        } else {
                            $return_html .= "Fixed";
                        }
                    } else {
                        $return_html .= PROFILENA;
                    }
                    $return_html .= '</span>
                                           </li>
                                              <li>
                                                 <b>';
                    $return_html .= $this->lang->line("required_experiance");
                    $return_html .= '</b>
                                         <span>';

                    if ($post['post_exp_month'] || $post['post_exp_year']) {
                        if ($post['post_exp_year']) {
                            $return_html .= $post['post_exp_year'];
                        }
                        if ($post['post_exp_month']) {
                            if ($post['post_exp_year'] == '0') {
                                $return_html .= 0;
                            }
                            $return_html .= ".";
                            $return_html .= $post['post_exp_month'];
                        } else {
                            $return_html .= "." . "0";
                        }
                        $return_html .= " Year";
                    } else {
                        $return_html .= PROFILENA;
                    }

                    $return_html .= ' </span>
                                           </li>
                                              <li><b>';
                    $return_html .= $this->lang->line("estimated_time");
                    $return_html .= '</b><span> ';

                    if ($post['post_est_time']) {
                        $return_html .= $post['post_est_time'];
                    } else {
                        $return_html .= PROFILENA;
                    }
                    $return_html .= '</span>
                                          </li>
                                            </ul>
                                              </div>
                                                 <div class="profile-job-profile-button clearfix">
                                                   <div class="profile-job-details col-md-12">
                                                     <ul><li class="job_all_post last_date">';
                    $return_html .= $this->lang->line("last_date");
                    $return_html .= ':';

                    if ($post['post_last_date']) {
                        $return_html .= date('d-M-Y', strtotime($post['post_last_date']));
                    } else {
                        $return_html .= PROFILENA;
                    }

                    $return_html .= '</li>';
                    $return_html .= '<input type="hidden" name="search" id="search" value="' . $keyword . '">';
                    $return_html .= ' <li class=fr>';

                    $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
                    if ($userid) {

                        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => 1, 'free_post_step' => 7);
                        $free_work_result = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_reg_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                        if ($free_work_result) {
                            $contition_array = array('post_id' => $post['post_id'], 'job_delete' => 0, 'user_id' => $userid);
                            $freelancerapply1 = $this->data['freelancerapply'] = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                            if ($freelancerapply1) {

                                $return_html .= '<a href="javascript:void(0);" class="button applied">';
                                $return_html .= $this->lang->line("applied");
                                $return_html .= '</a>';
                            } else {


                                $return_html .= '<a href="javascript:void(0);"  class= "applypost' . $post['post_id'] . '  button" onclick="applypopup(' . $post['post_id'] . ',' . $post['user_id'] . ')">';
                                $return_html .= $this->lang->line("apply");
                                $return_html .= ' </a>
                                                                                        </li> 
                                                                                        <li>';

                                $userid = $this->session->userdata('aileenuser');

                                $contition_array = array('user_id' => $userid, 'job_save' => '2', 'post_id ' => $post['post_id'], 'job_delete' => '1');
                                $data = $this->data['jobsave'] = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                if ($data) {

                                    $return_html .= '<a class="saved  button savedpost' . $post['post_id'] . '">';
                                    $return_html .= $this->lang->line("saved");
                                    $return_html .= '</a>';
                                } else {
                                    $return_html .= ' <a id="' . $post['post_id'] . '" onClick="savepopup(' . $post['post_id'] . ')" href="javascript:void(0);" class="savedpost' . $post['post_id'] . ' button">';
                                    $return_html .= $this->lang->line("save");
                                    $return_html .= '</a>';
                                }
                            }
                        } else {
                            $return_html .= '<a href="' . base_url('freelancer-work/basic-information') . '"  class= "applypost button">';
                            $return_html .= $this->lang->line("apply");
                            $return_html .= ' </a>';

                            $return_html .= ' <a href="' . base_url('freelancer-work/basic-information') . '" class="savedpost button">';
                            $return_html .= $this->lang->line("save");
                            $return_html .= '</a>';
                        }
                    } else {
                        $return_html .= '<a href="javascript:void(0);"  class= "applypost button" onclick="login_profile();">';
                        $return_html .= $this->lang->line("apply");
                        $return_html .= ' </a> </li> <li>';

                        $return_html .= ' <a id="" onClick="login_profile();" class="savedpost button">';
                        $return_html .= $this->lang->line("save");
                        $return_html .= '</a>';
                    }
                    $return_html .= ' </li>                        
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>';
                }
            }
        } else {

            $return_html .= '<div class="text-center rio">
                                                <h1 class="page-heading  product-listing" >';
            $return_html .= $this->lang->line("oops_no_data");
            $return_html .= '</h1><p>';
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

    public function job_search() {

        $userid = $this->session->userdata('aileenuser');
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        if ($this->input->get('searchplace') == "" && $this->input->get('skills') == "") {
            redirect('job/job_all_post', refresh);
        }
        ;

        // search keyword insert into database start

        $search_job = trim($this->input->get('skills'));
        $this->data['keyword'] = $search_job;
        $search_place = trim($this->input->get('searchplace'));

        $cache_time = $this->db->get_where('cities', array('city_name' => $search_place))->row()->city_id;
        $this->data['keyword1'] = $search_place;

        $date = date('Y-m-d', time());


        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $this->data['city'] = $city = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'city_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //Insert Search Data into database start
        $data = array(
            'search_keyword' => $search_job,
            'search_location' => $search_place,
            'user_location' => $city[0]['city_id'],
            'user_id' => $userid,
            'created_date' => date('Y-m-d h:i:s', time()),
            'status' => 1,
            'module' => '1'
        );
        $insert_id = $this->common->insert_data_getid($data, 'search_info');
//Insert Search Data into database End
//Total Search All Start
        // search keyword insert into database end
        if ($search_job == "") {
            $contition_array = array('city' => $cache_time, 're_status' => '1', 'recruiter.user_id !=' => $userid, 'recruiter.re_step' => 3, 'post_last_date >=' => $date, 'rec_post.is_delete' => 0);

            $join_str[0]['table'] = 'recruiter';
            $join_str[0]['join_table_id'] = 'recruiter.user_id';
            $join_str[0]['from_table_id'] = 'rec_post.user_id';
            $join_str[0]['join_type'] = '';

            $unique = $this->data['results'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby);
        } elseif ($search_place == "") {
            //Search FOr Skill Start
            $temp = $this->db->get_where('skill', array('skill' => $search_job, 'status' => 1))->row()->skill_id;
            $contition_array = array('status' => '1', 'is_delete' => '0', 'user_id != ' => $userid, 'post_last_date >=' => $date, 'FIND_IN_SET("' . $temp . '", post_skill) != ' => '0');
            $results_skill = $this->common->select_data_by_condition('rec_post', $contition_array, $data = '*', $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
//echo "<pre>";print_r($results_skill);die();
            //Search FOr Skill End
            //Search FOr firstname,lastname,companyname,other_skill and concat(firstname,lastname) Start
            $join_str[0]['table'] = 'recruiter';
            $join_str[0]['join_table_id'] = 'recruiter.user_id';
            $join_str[0]['from_table_id'] = 'rec_post.user_id';
            $join_str[0]['join_type'] = '';


            $contition_array = array('recruiter.user_id !=' => $userid, 'recruiter.re_step' => 3, 'post_last_date >=' => $date, 'rec_post.is_delete' => 0, 'rec_post.status' => '1');

            $data = 'rec_post.post_name,rec_post.post_description,rec_post.post_skill,rec_post.post_position,rec_post.post_last_date,rec_post.min_month,rec_post.min_year,rec_post.min_sal,rec_post.max_sal,rec_post.other_skill,rec_post.user_id,rec_post.post_id,rec_post.country,rec_post.city,rec_post.interview_process,rec_post.max_month,rec_post.max_year,rec_post.created_date,rec_post.industry_type,rec_post.emp_type,rec_post.salary_type,rec_post.degree_name';

            $search_condition = "(rec_post.post_name LIKE '%$search_job%' or recruiter.re_comp_name LIKE '%$search_job%' or recruiter.rec_firstname LIKE '%$search_job%' or recruiter.rec_lastname LIKE '%$search_job%' or rec_post.other_skill LIKE '%$search_job%' or concat(
                    rec_firstname,' ',rec_lastname) LIKE '%$search_job%')";

            $results_all = $recpostdata['data'] = $this->common->select_data_by_search('rec_post', $search_condition, $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
            //Search For firstname,lastname,companyname,other_skill and concat(firstname,lastname) End


            $join_str[0]['table'] = 'rec_post';
            $join_str[0]['join_table_id'] = 'rec_post.post_name';
            $join_str[0]['from_table_id'] = 'job_title.title_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('rec_post.user_id !=' => $userid, 'post_last_date >=' => $date, 'rec_post.is_delete' => 0, 'rec_post.status' => '1');

            $data = 'rec_post.post_name,rec_post.post_description,rec_post.post_skill,rec_post.post_position,rec_post.post_last_date,rec_post.min_month,rec_post.min_year,rec_post.min_sal,rec_post.max_sal,rec_post.other_skill,rec_post.user_id,rec_post.post_id,rec_post.country,rec_post.city,rec_post.interview_process,rec_post.max_month,rec_post.max_year,rec_post.created_date,rec_post.industry_type,rec_post.emp_type,rec_post.salary_type,rec_post.degree_name';

            $search_condition = "(job_title.name LIKE '%$search_job%')";
            $results_posttitleid = $recpostdata['data'] = $this->common->select_data_by_search('job_title', $search_condition, $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

            $unique1 = array_merge($results_skill, $results_all, $results_posttitleid);

            $unique = array();
            foreach ($unique1 as $value) {

                $unique[$value['post_id']] = $value;
            }
        } else {

            $cache_time1 = $this->db->get_where('cities', array('city_name' => $search_place))->row()->city_id;

            //Search FOr Skill Start
            $temp = $this->db->get_where('skill', array('skill' => $search_job, 'status' => 1))->row()->skill_id;
            $contition_array = array('status' => '1', 'is_delete' => '0', 'user_id != ' => $userid, 'city' => $cache_time1, 'post_last_date >=' => $date, 'FIND_IN_SET("' . $temp . '", post_skill) != ' => '0');
            $results_skill = $this->common->select_data_by_condition('rec_post', $contition_array, $data = '*', $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            //Search FOr Skill End
            //Search FOr firstname,lastname,companyname,other_skill and concat(firstname,lastname) Start
            $join_str[0]['table'] = 'recruiter';
            $join_str[0]['join_table_id'] = 'recruiter.user_id';
            $join_str[0]['from_table_id'] = 'rec_post.user_id';
            $join_str[0]['join_type'] = '';


            $contition_array = array('recruiter.user_id !=' => $userid, 'recruiter.re_step' => 3, 'post_last_date >=' => $date, 'rec_post.is_delete' => 0, 'rec_post.status' => '1', 'rec_post.city' => $cache_time1);

            $data = 'rec_post.post_name,rec_post.post_description,rec_post.post_skill,rec_post.post_position,rec_post.post_last_date,rec_post.min_month,rec_post.min_year,rec_post.min_sal,rec_post.max_sal,rec_post.other_skill,rec_post.user_id,rec_post.post_id,rec_post.country,rec_post.city,rec_post.interview_process,rec_post.max_month,rec_post.max_year,rec_post.created_date,rec_post.industry_type,rec_post.emp_type,rec_post.salary_type,rec_post.degree_name';

            $search_condition = "(rec_post.post_name LIKE '%$search_job%' or recruiter.re_comp_name LIKE '%$search_job%' or recruiter.rec_firstname LIKE '%$search_job%' or recruiter.rec_lastname LIKE '%$search_job%' or rec_post.other_skill LIKE '%$search_job%' or concat(
                    rec_firstname,' ',rec_lastname) LIKE '%$search_job%')";

            $results_all = $recpostdata['data'] = $this->common->select_data_by_search('rec_post', $search_condition, $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
            //Search For firstname,lastname,companyname,other_skill and concat(firstname,lastname) End


            $join_str[0]['table'] = 'rec_post';
            $join_str[0]['join_table_id'] = 'rec_post.post_name';
            $join_str[0]['from_table_id'] = 'job_title.title_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('rec_post.user_id !=' => $userid, 'post_last_date >=' => $date, 'rec_post.is_delete' => 0, 'rec_post.status' => '1', 'rec_post.city' => $cache_time1);

            $data = 'rec_post.post_name,rec_post.post_description,rec_post.post_skill,rec_post.post_position,rec_post.post_last_date,rec_post.min_month,rec_post.min_year,rec_post.min_sal,rec_post.max_sal,rec_post.other_skill,rec_post.user_id,rec_post.post_id,rec_post.country,rec_post.city,rec_post.interview_process,rec_post.max_month,rec_post.max_year,rec_post.created_date,rec_post.industry_type,rec_post.emp_type,rec_post.salary_type,rec_post.degree_name';

            $search_condition = "(job_title.name LIKE '%$search_job%')";
            $results_posttitleid = $recpostdata['data'] = $this->common->select_data_by_search('job_title', $search_condition, $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

            $unique1 = array_merge($results_skill, $results_all, $results_posttitleid);

            $unique = array();
            foreach ($unique1 as $value) {

                $unique[$value['post_id']] = $value;
            }
        }
        $this->data['postdetail'] = $unique;
//Total Search All End

        $title = '';
        if ($search_job) {
            $title .= $search_job;
        }
        if ($search_job && $search_place) {
            $title .= ' Job Opening in ';
        }
        if ($search_place) {
            $title .= $search_place;
        }
        $this->data['title'] = "$title | Aileensoul";
        $this->data['head'] = $this->load->view('head', $this->data, TRUE);

        $this->load->view('job/job_all_post1', $this->data);
    }

// job search end     


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
                'status' => 1,
                'module' => '5'
            );

            $insert_id = $this->common->insert_data_getid($data, 'search_info');
            // code for insert search keyword in database end
        }
        if ($search_business == "") {
            $contition_array = array('city' => $cache_time, 'status' => '1', 'business_step' => 4);
            $business_profile = $this->data['results'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } elseif ($search_place == "") {
            $condition_array = array('business_profile_id !=' => '', 'business_profile.status' => '1', 'business_step' => 4);

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

            $condition_array = array('business_step' => 4, 'business_profile_post.is_delete' => '0');
            $search_condition = "(business_profile_post.product_name LIKE '%$search_business%' or business_profile_post.product_description LIKE '%$search_business%')";

            $business_post = $post['data'] = $this->common->select_data_by_search('business_profile_post', $search_condition, $condition_array, $data = 'business_profile_post.*,business_profile.company_name,business_profile.industriyal,business_profile.business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        } else {
            $condition_array = array('business_profile_id !=' => '', 'status' => '1', 'city' => $cache_time, 'business_step' => 4);
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

            $condition_array = array('business_step' => 4, 'business_profile_post.is_delete' => '0');
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
                        $status = $this->db->get_where('follow', array('follow_type' => 2, 'follow_from' => $main_business_profile_id, 'follow_to' => $p['business_profile_id']))->row()->follow_status;
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

                        $business_userimage = $this->db->get_where('business_profile', array('user_id' => $p['user_id'], 'status' => 1))->row()->business_user_image;
                        $userimageposted = $this->db->get_where('business_profile', array('user_id' => $p['posted_user_id']))->row()->business_user_image;
                        $slugname = $this->db->get_where('business_profile', array('user_id' => $p['user_id'], 'status' => 1))->row()->business_slug;
                        $slugnameposted = $this->db->get_where('business_profile', array('user_id' => $p['posted_user_id'], 'status' => 1))->row()->business_slug;
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
                            if (file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) && $business_userimage) {
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
                                $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
                            }
                            $return_html .= '<a  href="javascript:void(0);"  onClick="login_profile()"e>';
                            $contition_array = array('business_profile_post_id' => $p['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                            $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                            $likeuser = $commnetcount[0]['business_like_user'];
                            $countlike = $commnetcount[0]['business_likes_count'] - 1;
                            $likelistarray = explode(',', $likeuser);

                            $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
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
                            $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
                        }

                        $return_html .= '<a  href="javascript:void(0);"  onClick="login_profile()">';
                        $contition_array = array('business_profile_post_id' => $p['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                        $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                        $likeuser = $commnetcount[0]['business_like_user'];
                        $countlike = $commnetcount[0]['business_likes_count'] - 1;
                        $likelistarray = explode(',', $likeuser);

                        $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
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
                                $business_userimage = $this->db->get_where('business_profile', array('user_id' => $pdata['user_id'], 'status' => 1))->row()->business_user_image;
                                if (file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) && $business_userimage) {
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
                                $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $pdata['business_profile_post_id'], 'status' => 1))->row()->user_id;
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
                        if($is_business){
                        $return_html .= '<div class="post-design-commnet-box col-md-12">
                            <div class="post-design-proo-img">';
                        $userid = $this->session->userdata('aileenuser');
                        $business_userimage = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => 1))->row()->business_user_image;
                        $business_user = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => 1))->row()->company_name;
                        if (file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) && $business_userimage) {
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
            $business_profile_id = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => 1))->row()->business_profile_id;
        }

        $contition_array = array('follow_from' => $business_profile_id, 'follow_status' => '1', 'follow_type' => '2', 'business_profile.status' => 1);

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
            $business_profile_id = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => 1))->row()->business_profile_id;
        }

        $contition_array = array('follow_to' => $business_profile_id, 'follow_status' => '1', 'follow_type' => '2', 'business_profile.status' => 1);

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
            $userid = $this->db->get_where('business_profile', array('business_profile_id' => $business_profile_id, 'status' => 1))->row()->user_id;
        }

        $contition_array = array('contact_type' => 2, 'contact_person.status' => 'confirm', 'business_profile.status' => 1);
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
