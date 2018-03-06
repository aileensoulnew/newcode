<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Business_profile extends MY_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('user_agent');
        $this->load->model('email_model');
        $this->lang->load('message', 'english');
        $this->load->helper('smiley');
        //AWS access info start
        $this->load->library('S3');
        //AWS access info end
        $userid = $this->session->userdata('aileenuser');
        include ('business_include.php');

        // FIX BUSINESS PROFILE NO POST DATA

        $this->data['no_business_post_html'] = '<div class="art_no_post_avl"><h3>Post</h3><div class="art-img-nn"><div class="art_no_post_img"><img src=' . base_url('assets/img/bui-no.png') . ' alt="bui-no.png"></div><div class="art_no_post_text">No Post Available.</div></div></div>';
        $this->data['no_business_contact_html'] = '<div class="art-img-nn"><div class="art_no_post_img"><img src="' . base_url('assets/img/No_Contact_Request.png') . '"></div><div class="art_no_post_text">No Contacts Available.</div></div>';
    }

    public function index() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'status' => '0');
        $businessdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id,business_slug,company_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if ($businessdata) {
            //$company_name = $this->get_company_name($businessdata[0]['business_slug']);
            $this->data['title'] = ucwords($businessdata[0]['company_name']). ' | Reactive | ' . ' Business Profile' . TITLEPOSTFIX;
            $this->load->view('business_profile/reactivate', $this->data);
        } else {
            $userid = $this->session->userdata('aileenuser');
// GET BUSINESS PROFILE DATA
            $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
            $userdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
// GET COUNTRY DATA
            $contition_array = array('status' => '1');
            $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = 'country_id,country_name', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
// GET STATE DATA
            $contition_array = array('status' => '1');
            $this->data['states'] = $this->common->select_data_by_condition('states', $contition_array, $data = 'state_id,state_name,country_id', $sortby = 'state_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
// GET CITY DATA
            $contition_array = array('status' => '1');
            $this->data['cities'] = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_id,city_name,state_id', $sortby = 'city_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if (count($userdata) > 0) {

                if ($userdata[0]['business_step'] == 1) {
                    redirect('business-profile/contact-information', refresh);
                } else if ($userdata[0]['business_step'] == 2) {
                    redirect('business-profile/description', refresh);
                } else if ($userdata[0]['business_step'] == 3) {
                    redirect('business-profile/image', refresh);
                } else if ($userdata[0]['business_step'] == 4) {
                    redirect('business-profile/home', refresh);
                } else if ($userdata[0]['business_step'] == 5) {
                    redirect('business-profile/home', refresh);
                }
            } else {
                //$this->load->view('business_profile/business_info', $this->data);
                redirect('business-profile/business-information', refresh);
                //redirect('business-profile/signup/business-registration', refresh);
            }
        }
    }

    public function minify_css() {
        $this->load->library('minify');
        $this->load->helper('url');
        $this->load->view('business_profile/minify_css');
    }

    public function minify_js() {
        $this->load->library('minify');
        $this->load->helper('url');
        $this->load->view('business_profile/minify_js');
    }

// BUSINESS PROFILE SLUG START

    public function setcategory_slug($slugname, $filedname, $tablename, $notin_id = array()) {
        $slugname = $oldslugname = $this->create_slug($slugname);
        $i = 1;
        while ($this->comparecategory_slug($slugname, $filedname, $tablename, $notin_id) > 0) {
            $slugname = $oldslugname . '-' . $i;
            $i++;
        }return $slugname;
    }

    public function comparecategory_slug($slugname, $filedname, $tablename, $notin_id = array()) {
        $this->db->where($filedname, $slugname);
        if (isset($notin_id) && $notin_id != "" && count($notin_id) > 0 && !empty($notin_id)) {
            $this->db->where($notin_id);
        }
        $num_rows = $this->db->count_all_results($tablename);
        return $num_rows;
    }

    public function create_slug($string) {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower(stripslashes($string)));
        $slug = preg_replace('/[-]+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }

    public function check_email() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $email = $this->input->post('email');
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $email1 = $userdata[0]['contact_email'];
        if ($email1) {
            $condition_array = array('is_deleted' => '0', 'user_id !=' => $userid, 'status' => '1', 'business_step' => '4');
            $check_result = $this->common->check_unique_avalibility('business_profile', 'contact_email', $email, '', '', $condition_array);
        } else {
            $condition_array = array('is_deleted' => '0', 'status' => '1', 'business_step' => '4');
            $check_result = $this->common->check_unique_avalibility('business_profile', 'contact_email', $email, '', '', $condition_array);
        }

        if ($check_result) {
            echo 'true';
            die();
        } else {
            echo 'false';
            die();
        }
    }

    public function business_profile_post() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

        $this->business_profile_active_check();
        $this->is_business_profile_register();

        // GET USER BUSINESS DATA FROM INCLUDE START
        $business_profile_id = $this->data['business_common_data'][0]['business_profile_id'];
        $industriyal = $this->data['business_common_data'][0]['industriyal'];
        $city = $this->data['business_common_data'][0]['city'];
        $state = $this->data['business_common_data'][0]['state'];
        $other_industrial = $this->data['business_common_data'][0]['other_industrial'];
        $business_type = $this->data['business_common_data'][0]['business_type'];
        // GET USER BUSINESS DATA FROM INCLUDE END
        // GET BUSINESS USER FOLLOWING LIST START
        $contition_array = array('follow_from' => $business_profile_id, 'follow_status' => '1', 'follow_type' => '2');
        $followdata = $this->common->select_data_by_condition('follow', $contition_array, $data = 'GROUP_CONCAT(follow_to) as follow_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = 'follow_from');
        $follow_list = $followdata[0]['follow_list'];
        $follow_list = str_replace(",", "','", $followdata[0]['follow_list']);
        // GET BUSINESS USER FOLLOWING LIST END
        // GET BUSINESS USER IGNORE LIST START
        $contition_array = array('user_from' => $business_profile_id, 'profile' => '2');
        $userdata = $this->common->select_data_by_condition('user_ignore', $contition_array, $data = 'GROUP_CONCAT(user_to) as user_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = 'user_from');
        $user_list = $followdata[0]['user_list'];
        $user_list = str_replace(",", "','", $userdata[0]['user_list']);
        // GET BUSINESS USER IGNORE LIST END
        //GET BUSINESS USER SUGGESTED USER LIST 
        $contition_array = array('is_deleted' => '0', 'status' => '1', 'user_id != ' => $userid, 'business_step' => '4');
        $search_condition = "business_profile_id NOT IN ('$follow_list') AND business_profile_id NOT IN ('$user_list')";
        //$userlistview = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'count(*) as total', $sortby = 'CASE WHEN (industriyal = ' . $industriyal . ') THEN business_profile_id END, CASE WHEN (city = ' . $city . ') THEN business_profile_id END, CASE WHEN (state = ' . $state . ') THEN business_profile_id END', $orderby = 'DESC', $limit = '3', $offset = '', $join_str_contact = array(), $groupby = '');
        $userlistview = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'count(*) as total', $sortby = 'CASE WHEN (industriyal = ' . $industriyal . ') THEN business_profile_id END, CASE WHEN (state = ' . $state . ') THEN business_profile_id END', $orderby = 'DESC', $limit = '3', $offset = '', $join_str_contact = array(), $groupby = '');

        $this->data['follow_user_suggest_count'] = $userlistview[0]['total'];

        /* COUNT FOR USER THREE LIST IN FOLLOW SUGGEST BOX */

        $this->data['title'] = 'Home | Business Profile' . TITLEPOSTFIX;
        $this->data['business_left'] = $this->load->view('business_profile/business_left', $this->data, true);

        $this->load->view('business_profile/business_profile_post', $this->data);
    }

    public function business_profile_manage_post($id = "") {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $this->data['slugid'] = $id;

// manage post start
        $userid = $this->session->userdata('aileenuser');

        if ($id == '' && $userid == '') {
            redirect('login');
        } elseif ($id == '' && $userid != '') {
            redirect('business-profile');
        }

        $user_name = $this->session->userdata('user_name');
        if ($userid) {
            $this->business_profile_active_check();
            $this->is_business_profile_register();
        }

        $business_main_slug = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->business_slug;
        $business_main_profile = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->business_profile_id;

        if ($id != '') {
            $contition_array = array('business_slug' => $id, 'is_deleted' => '0', 'status' => '1', 'business_step' => '4');
            $business_data = $this->data['business_data'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'user_id,business_profile_id,company_name,contact_email,contact_person,contact_mobile,contact_website,details,address,city,country', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {
            $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1', 'business_step' => '4');
            $business_data = $this->data['business_data'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'user_id,business_profile_id,company_name,contact_email,contact_person,contact_mobile,contact_website,details,address,city,country', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }
        if ($business_main_slug == $id) {
            $this->data['is_eligable_for_post'] = 1;
        } else {
            $other_user = $business_data[0]['business_profile_id'];
            $other_user_id = $business_data[0]['user_id'];

            $loginuser = $business_main_profile;
            $contition_array = array('follow_type' => '2', 'follow_status' => '1');
            $search_condition = "((follow_from  = '$loginuser' AND follow_to  = ' $other_user') OR (follow_from  = '$other_user' AND follow_to  = '$loginuser'))";
            $followperson = $this->common->select_data_by_search('follow', $search_condition, $contition_array, $data = 'count(*) as follow_count', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = '', $groupby = '');

            $contition_array = array('contact_type' => '2', 'status' => 'confirm');
            $search_condition = "((contact_from_id  = '$userid' AND contact_to_id = ' $other_user_id') OR (contact_from_id  = '$other_user_id' AND contact_to_id = '$userid'))";
            $contactperson = $this->common->select_data_by_search('contact_person', $search_condition, $contition_array, $data = 'count(*) as contact_count', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = '', $groupby = '');

            if ($followperson[0]['follow_count'] == 2 || $contactperson[0]['contact_count'] == 1) {
                $this->data['is_eligable_for_post'] = 1;
            }
        }

        $company_name = $this->get_company_name($id);
        $this->data['title'] = ucwords($company_name) .' | Dashboard' .  ' | Business Profile' . TITLEPOSTFIX;
//manage post end
        if (count($business_data) == 0) {
            $this->load->view('business_profile/notavalible');
        } else {
            if ($this->session->userdata('aileenuser')) {
                $this->load->view('business_profile/business_profile_manage_post', $this->data);
            } else {
                include ('business_profile_include.php');
                $this->data['business_common_profile'] = $this->load->view('business_profile/business_common_profile', $this->data, true);
                $this->load->view('business_profile/business_dashboard', $this->data);
            }
        }
// save post end       
    }

    public function business_profile_deletepost() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $id = $_POST["business_profile_post_id"];
        $data = array(
            'is_delete' => '1',
            'modify_date' => date('Y-m-d', time())
        );
        $updatdata = $this->common->update_data($data, 'business_profile_post', 'business_profile_post_id', $id);
        $dataimage = array(
            'is_deleted' => '0',
            'modify_date' => date('Y-m-d H:i:s', time())
        );
        $updatdata = $this->common->update_data($dataimage, 'post_files', 'post_id', $id);
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        $contition_array = array('user_id' => $userid, 'status' => '1', 'is_delete' => '0');
        $otherdata = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $datacount = count($otherdata);
        if ($datacount == 0) {
            $notvideo = 'Video Not Available';
            $notaudio = 'Audio Not Available';
            $notpdf = 'Pdf Not Available';
            $notphoto = 'Photo Not Available';
        }
        echo json_encode(
                array(
                    "notfound" => $notfound,
                    "notcount" => $datacount,
                    "notvideo" => $notvideo,
                    "notaudio" => $notaudio,
                    "notpdf" => $notpdf,
                    "notphoto" => $notphoto,
        ));
    }

    public function business_profile_deleteforpost() {
        $s3 = new S3(awsAccessKey, awsSecretKey);

        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        $id = $_POST["business_profile_post_id"];
        $data = array(
            'is_delete' => '1',
            'modify_date' => date('Y-m-d', time())
        );
        $updatdata = $this->common->update_data($data, 'business_profile_post', 'business_profile_post_id', $id);

        $dataimage = array(
            'is_deleted' => '0',
            'modify_date' => date('Y-m-d H:i:s', time())
        );
        $updatdata = $this->common->update_data($dataimage, 'post_files', 'post_id', $id);

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['businessdata'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $business_profile_id = $this->data['businessdata'][0]['business_profile_id'];

        $contition_array = array('follow_from' => $business_profile_id, 'follow_status' => '1', 'follow_type' => '2');
        $followerdata = $this->data['followerdata'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        foreach ($followerdata as $fdata) {

            $contition_array = array('business_profile_id' => $fdata['follow_to'], 'business_step' => '4');
            $this->data['business_data'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $business_userid = $this->data['business_data'][0]['user_id'];
            $contition_array = array('user_id' => $business_userid, 'status' => '1', 'is_delete' => '0');

            $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $followerabc[] = $this->data['business_profile_data'];
        }
        $userselectindustriyal = $this->data['businessdata'][0]['industriyal'];

        $contition_array = array('industriyal' => $userselectindustriyal, 'status' => '1', 'business_step' => '4');
        $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        foreach ($businessprofiledata as $fdata) {
            $contition_array = array('business_profile_post.user_id' => $fdata['user_id'], 'business_profile_post.status' => '1', 'business_profile_post.user_id !=' => $userid, 'is_delete' => '0');

            $this->data['business_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $industriyalabc[] = $this->data['business_data'];
        }
        $condition_array = array('user_id' => $userid, 'status' => '1', 'is_delete' => '0');

        $business_datauser = $this->data['business_datauser'] = $this->common->select_data_by_condition('business_profile_post', $condition_array, $data = '*', $sortby = 'business_profile_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $userabc[][] = $this->data['business_datauser'][0];

        if (count($industriyalabc) == 0 && count($business_datauser) != 0) {
            $unique = $userabc;
        } elseif (count($business_datauser) == 0 && count($industriyalabc) != 0) {
            $unique = $industriyalabc;
        } elseif (count($business_datauser) != 0 && count($industriyalabc) != 0) {
            $unique = array_merge($industriyalabc, $userabc);
        }

        if (count($followerabc) == 0 && count($unique) != 0) {
            $unique_user = $unique;
        } elseif (count($unique) == 0 && count($followerabc) != 0) {
            $unique_user = $followerabc;
        } else {
            $unique_user = array_merge($unique, $followerabc);
        }

        foreach ($unique_user as $ke => $arr) {
            foreach ($arr as $k => $v) {

                $postdata[] = $v;
            }
        }

        $postdata = array_unique($postdata, SORT_REGULAR);

        $new = array();
        foreach ($postdata as $value) {
            $new[$value['business_profile_post_id']] = $value;
        }

        $post = array();
        foreach ($new as $key => $row) {

            $post[$key] = $row['business_profile_post_id'];
        }
        array_multisort($post, SORT_DESC, $new);

        $otherdata = $new;

        if (count($otherdata) > 0) {
            foreach ($otherdata as $row) {
                $userid = $this->session->userdata('aileenuser');
                $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1');
                $businessdelete = $this->data['businessdelete'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $contition_array = array('user_id' => $row['user_id'], 'status' => '1');
                $businessdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $likeuserarray = explode(',', $businessdelete[0]['delete_post']);
                if (!in_array($userid, $likeuserarray)) {
                    
                } else {
                    $count[] = "abc";
                }
            }
        }

        if (count($otherdata) > 0) {
            if (count($count) == count($otherdata)) {

                $datacount = "count";
                $notfound = "";
            }
        } else {
            $datacount = "count";
        }

        echo json_encode(
                array(
                    "notfound" => $notfound,
                    "notcount" => $datacount,
        ));
    }

    public function business_profile_addpost() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $this->business_profile_active_check();
        $this->is_business_profile_register();


        $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['businessdata'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->load->view('business_profile/business_profile_addpost', $this->data);
    }

    public function business_profile_addpost_insert($id = "", $para = "") {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        $business_login_slug = $this->data['business_login_slug'];

        $this->business_profile_active_check();
        $this->is_business_profile_register();

        $contition_array = array('user_id' => $para, 'status' => '1');
        $this->data['businessdataposted'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($para == $userid || $para == '') {
            $data = array(
                'product_name' => $this->input->post('my_text'),
                'product_description' => $this->input->post('product_desc'),
                'created_date' => date('Y-m-d H:i:s', time()),
                'status' => '1',
                'is_delete' => '0',
                'user_id' => $userid
            );
        } else {
            $data = array(
                'product_name' => $this->input->post('my_text'),
                'product_description' => $this->input->post('product_desc'),
                'created_date' => date('Y-m-d H:i:s', time()),
                'status' => '1',
                'is_delete' => '0',
                'user_id' => $para,
                'posted_user_id' => $userid
            );
        }
//CHECK IF IMAGE POST THEN NAME AND DESCRIPTION IS BLANK THAT TIME POST NOT INSERT AT A TIME.
        if ($_FILES['postattach']['name'][0] != '') {
// CHECK FILE IS PROPER 
// if ($data['product_name'] != '' && $data['product_description'] != '') {
            if ($_FILES['postattach']['error'][0] != '1') {
                $insert_id = $this->common->insert_data_getid($data, 'business_profile_post');
            }
        } else {
            $insert_id = $this->common->insert_data_getid($data, 'business_profile_post');
        }

        $this->config->item('bus_post_main_upload_path');
        $config = array(
            'image_library' => 'gd',
            'upload_path' => $this->config->item('bus_post_main_upload_path'),
            'allowed_types' => $this->config->item('bus_post_main_allowed_types'),
            'overwrite' => true,
            'remove_spaces' => true);
        $images = array();
        $this->load->library('upload');

        $files = $_FILES;
        $count = count($_FILES['postattach']['name']);
        $title = time();

        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);

        if ($_FILES['postattach']['name'][0] != '') {

            for ($i = 0; $i < $count; $i++) {

                $_FILES['postattach']['name'] = $files['postattach']['name'][$i];
                $_FILES['postattach']['type'] = $files['postattach']['type'][$i];
                $_FILES['postattach']['tmp_name'] = $files['postattach']['tmp_name'][$i];
                $_FILES['postattach']['error'] = $files['postattach']['error'][$i];
                $_FILES['postattach']['size'] = $files['postattach']['size'][$i];

                $file_type = $_FILES['postattach']['type'];
                $file_type = explode('/', $file_type);
                $file_type = $file_type[0];
                if ($file_type == 'image') {
                    $file_type = 'image';
                } elseif ($file_type == 'audio') {
                    $file_type = 'audio';
                } elseif ($file_type == 'video') {
                    $file_type = 'video';
                } else {
                    $file_type = 'pdf';
                }

                if ($_FILES['postattach']['error'] == 0) {
                    $store = $_FILES['postattach']['name'];
                    $store_ext = explode('.', $store);
                    $store_ext = end($store_ext);
                    $fileName = 'file_' . $title . '_' . $this->random_string() . '.' . $store_ext;
                    $images[] = $fileName;
                    $config['file_name'] = $fileName;
                    $this->upload->initialize($config);
//                  $this->upload->do_upload();
                    $imgdata = $this->upload->data();

                    if ($this->upload->do_upload('postattach')) {
                        $upload_data = $response['result'][] = $this->upload->data();

                        if ($file_type == 'video') {
                            $uploaded_url = base_url() . $this->config->item('bus_post_main_upload_path') . $response['result'][$i]['file_name'];
                            exec("ffmpeg -i " . $uploaded_url . " -vcodec h264 -acodec aac -strict -2 " . $upload_data['file_path'] . $upload_data['raw_name'] . "1" . $upload_data['file_ext'] . "");
                            exec("ffmpeg -ss 00:00:05 -i " . $upload_data['full_path'] . " " . $upload_data['file_path'] . $upload_data['raw_name'] . "1" . ".png");
                            $fileName = $response['result'][$i]['file_name'] = $upload_data['raw_name'] . "1" . $upload_data['file_ext'];
                            unlink($this->config->item('bus_post_main_upload_path') . $upload_data['raw_name'] . "" . $upload_data['file_ext']);
                        }

                        $main_image_size = $_FILES['postattach']['size'];

                        if ($main_image_size > '1000000') {
                            $quality = "50%";
                        } elseif ($main_image_size > '50000' && $main_image_size < '1000000') {
                            $quality = "55%";
                        } elseif ($main_image_size > '5000' && $main_image_size < '50000') {
                            $quality = "60%";
                        } elseif ($main_image_size > '100' && $main_image_size < '5000') {
                            $quality = "65%";
                        } elseif ($main_image_size > '1' && $main_image_size < '100') {
                            $quality = "70%";
                        } else {
                            $quality = "100%";
                        }

                        /* RESIZE */

                        $business_profile_post_main[$i]['image_library'] = 'gd2';
                        $business_profile_post_main[$i]['source_image'] = $this->config->item('bus_post_main_upload_path') . $response['result'][$i]['file_name'];
                        $business_profile_post_main[$i]['new_image'] = $this->config->item('bus_post_main_upload_path') . $response['result'][$i]['file_name'];
                        $business_profile_post_main[$i]['quality'] = $quality;
                        $instanse10 = "image10_$i";
                        $this->load->library('image_lib', $business_profile_post_main[$i], $instanse10);
                        $this->$instanse10->watermark();

                        /* RESIZE */

                        $main_image = $this->config->item('bus_post_main_upload_path') . $response['result'][$i]['file_name'];
                        $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);

                        $post_poster = $response['result'][$i]['file_name'];
                        $post_poster1 = explode('.', $post_poster);
                        $post_poster2 = end($post_poster1);
                        $post_poster = str_replace($post_poster2, 'png', $post_poster);

                        $main_image1 = $this->config->item('bus_post_main_upload_path') . $post_poster;
                        $abc = $s3->putObjectFile($main_image1, bucket, $main_image1, S3::ACL_PUBLIC_READ);

                        $image_width = $response['result'][$i]['image_width'];
                        $image_height = $response['result'][$i]['image_height'];


                        if ($count == '3') {
                            /* RESIZE 4 */

                            $resize4_image_width = $this->config->item('bus_post_resize4_width');
                            $resize4_image_height = $this->config->item('bus_post_resize4_height');


                            if ($image_width > $image_height) {
                                $n_h1 = $resize4_image_height;
                                $image_ratio = $image_height / $n_h1;
                                $n_w1 = round($image_width / $image_ratio);
                            } else if ($image_width < $image_height) {
                                $n_w1 = $resize4_image_width;
                                $image_ratio = $image_width / $n_w1;
                                $n_h1 = round($image_height / $image_ratio);
                            } else {
                                $n_w1 = $resize4_image_width;
                                $n_h1 = $resize4_image_height;
                            }

                            $left = ($n_w1 / 2) - ($resize4_image_width / 2);
                            $top = ($n_h1 / 2) - ($resize4_image_height / 2);

                            $business_profile_post_resize4[$i]['image_library'] = 'gd2';
                            $business_profile_post_resize4[$i]['source_image'] = $this->config->item('bus_post_main_upload_path') . $response['result'][$i]['file_name'];
                            $business_profile_post_resize4[$i]['new_image'] = $this->config->item('bus_post_resize4_upload_path') . $response['result'][$i]['file_name'];
                            $business_profile_post_resize4[$i]['create_thumb'] = TRUE;
                            $business_profile_post_resize4[$i]['maintain_ratio'] = TRUE;
                            $business_profile_post_resize4[$i]['thumb_marker'] = '';
                            $business_profile_post_resize4[$i]['width'] = $n_w1;
                            $business_profile_post_resize4[$i]['height'] = $n_h1;
                            $business_profile_post_resize4[$i]['quality'] = "100%";
//                        $business_profile_post_resize4[$i]['x_axis'] = $left;
//                        $business_profile_post_resize4[$i]['y_axis'] = $top;
                            $instanse4 = "image4_$i";
                            //Loading Image Library
                            $this->load->library('image_lib', $business_profile_post_resize4[$i], $instanse4);
                            //Creating Thumbnail
                            $this->$instanse4->resize();
                            $this->$instanse4->clear();

                            $resize_image4 = $this->config->item('bus_post_resize4_upload_path') . $response['result'][$i]['file_name'];
                            $abc = $s3->putObjectFile($resize_image4, bucket, $resize_image4, S3::ACL_PUBLIC_READ);
                            /* RESIZE 4 */
                        }

                        $thumb_image_width = $this->config->item('bus_post_thumb_width');
                        $thumb_image_height = $this->config->item('bus_post_thumb_height');


                        if ($image_width > $image_height) {
                            $n_h = $thumb_image_height;
                            $image_ratio = $image_height / $n_h;
                            $n_w = round($image_width / $image_ratio);
                        } else if ($image_width < $image_height) {
                            $n_w = $thumb_image_width;
                            $image_ratio = $image_width / $n_w;
                            $n_h = round($image_height / $image_ratio);
                        } else {
                            $n_w = $thumb_image_width;
                            $n_h = $thumb_image_height;
                        }

                        $business_profile_post_thumb[$i]['image_library'] = 'gd2';
                        $business_profile_post_thumb[$i]['source_image'] = $this->config->item('bus_post_main_upload_path') . $response['result'][$i]['file_name'];
                        $business_profile_post_thumb[$i]['new_image'] = $this->config->item('bus_post_thumb_upload_path') . $response['result'][$i]['file_name'];
                        $business_profile_post_thumb[$i]['create_thumb'] = TRUE;
                        $business_profile_post_thumb[$i]['maintain_ratio'] = FALSE;
                        $business_profile_post_thumb[$i]['thumb_marker'] = '';
                        $business_profile_post_thumb[$i]['width'] = $n_w;
                        $business_profile_post_thumb[$i]['height'] = $n_h;
//                        $business_profile_post_thumb[$i]['master_dim'] = 'width';
                        $business_profile_post_thumb[$i]['quality'] = "100%";
                        $business_profile_post_thumb[$i]['x_axis'] = '0';
                        $business_profile_post_thumb[$i]['y_axis'] = '0';
                        $instanse = "image_$i";
                        //Loading Image Library
                        $this->load->library('image_lib', $business_profile_post_thumb[$i], $instanse);
                        $dataimage = $response['result'][$i]['file_name'];
                        //Creating Thumbnail
                        $this->$instanse->resize();

                        $thumb_image = $this->config->item('bus_post_thumb_upload_path') . $response['result'][$i]['file_name'];

                        $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);

                        if ($count == '2' || $count == '3') {
                            /* CROP 335 X 320 */
                            // reconfigure the image lib for cropping

                            $resized_image_width = $this->config->item('bus_post_resize1_width');
                            $resized_image_height = $this->config->item('bus_post_resize1_height');
                            if ($thumb_image_width < $resized_image_width) {
                                $resized_image_width = $thumb_image_width;
                            }
                            if ($thumb_image_height < $resized_image_height) {
                                $resized_image_height = $thumb_image_height;
                            }

                            $conf_new[$i] = array(
                                'image_library' => 'gd2',
                                'source_image' => $business_profile_post_thumb[$i]['new_image'],
                                'create_thumb' => FALSE,
                                'maintain_ratio' => FALSE,
                                'width' => $resized_image_width,
                                'height' => $resized_image_height
                            );

                            $conf_new[$i]['new_image'] = $this->config->item('bus_post_resize1_upload_path') . $response['result'][$i]['file_name'];

                            $left = ($n_w / 2) - ($resized_image_width / 2);
                            $top = ($n_h / 2) - ($resized_image_height / 2);

                            $conf_new[$i]['x_axis'] = $left;
                            $conf_new[$i]['y_axis'] = $top;

                            $instanse1 = "image1_$i";
                            //Loading Image Library
                            $this->load->library('image_lib', $conf_new[$i], $instanse1);
                            $dataimage = $response['result'][$i]['file_name'];
                            //Creating Thumbnail
                            $this->$instanse1->crop();

                            $resize_image = $this->config->item('bus_post_resize1_upload_path') . $response['result'][$i]['file_name'];

                            $abc = $s3->putObjectFile($resize_image, bucket, $resize_image, S3::ACL_PUBLIC_READ);
                            /* CROP 335 X 320 */
                        }
                        if ($count == '4' || $count > '4') {
                            /* CROP 335 X 245 */
                            // reconfigure the image lib for cropping

                            $resized_image_width = $this->config->item('bus_post_resize2_width');
                            $resized_image_height = $this->config->item('bus_post_resize2_height');
                            if ($thumb_image_width < $resized_image_width) {
                                $resized_image_width = $thumb_image_width;
                            }
                            if ($thumb_image_height < $resized_image_height) {
                                $resized_image_height = $thumb_image_height;
                            }


                            $conf_new1[$i] = array(
                                'image_library' => 'gd2',
                                'source_image' => $business_profile_post_thumb[$i]['new_image'],
                                'create_thumb' => FALSE,
                                'maintain_ratio' => FALSE,
                                'width' => $resized_image_width,
                                'height' => $resized_image_height
                            );

                            $conf_new1[$i]['new_image'] = $this->config->item('bus_post_resize2_upload_path') . $response['result'][$i]['file_name'];

                            $left = ($n_w / 2) - ($resized_image_width / 2);
                            $top = ($n_h / 2) - ($resized_image_height / 2);

                            $conf_new1[$i]['x_axis'] = $left;
                            $conf_new1[$i]['y_axis'] = $top;

                            $instanse2 = "image2_$i";
                            //Loading Image Library
                            $this->load->library('image_lib', $conf_new1[$i], $instanse2);
                            $dataimage = $response['result'][$i]['file_name'];
                            //Creating Thumbnail
                            $this->$instanse2->crop();

                            $resize_image1 = $this->config->item('bus_post_resize2_upload_path') . $response['result'][$i]['file_name'];

                            $abc = $s3->putObjectFile($resize_image1, bucket, $resize_image1, S3::ACL_PUBLIC_READ);

                            /* CROP 335 X 245 */
                        }
                        /* CROP 210 X 210 */
                        // reconfigure the image lib for cropping

                        $resized_image_width = $this->config->item('bus_post_resize3_width');
                        $resized_image_height = $this->config->item('bus_post_resize3_height');
                        if ($thumb_image_width < $resized_image_width) {
                            $resized_image_width = $thumb_image_width;
                        }
                        if ($thumb_image_height < $resized_image_height) {
                            $resized_image_height = $thumb_image_height;
                        }

                        $conf_new2[$i] = array(
                            'image_library' => 'gd2',
                            'source_image' => $business_profile_post_thumb[$i]['new_image'],
                            'create_thumb' => FALSE,
                            'maintain_ratio' => FALSE,
                            'width' => $resized_image_width,
                            'height' => $resized_image_height
                        );

                        $conf_new2[$i]['new_image'] = $this->config->item('bus_post_resize3_upload_path') . $response['result'][$i]['file_name'];

                        $left = ($n_w / 2) - ($resized_image_width / 2);
                        $top = ($n_h / 2) - ($resized_image_height / 2);

                        $conf_new2[$i]['x_axis'] = $left;
                        $conf_new2[$i]['y_axis'] = $top;

                        $instanse3 = "image3_$i";
                        //Loading Image Library
                        $this->load->library('image_lib', $conf_new2[$i], $instanse3);
                        $dataimage = $response['result'][$i]['file_name'];
                        //Creating Thumbnail
                        $this->$instanse3->crop();
                        $resize_image2 = $this->config->item('bus_post_resize3_upload_path') . $response['result'][$i]['file_name'];
                        $abc = $s3->putObjectFile($resize_image2, bucket, $resize_image2, S3::ACL_PUBLIC_READ);

                        /* CROP 210 X 210 */
                        $response['error'][] = $thumberror = $this->$instanse->display_errors();
                        $return['data'][] = $imgdata;
                        $return['status'] = "success";
                        $return['msg'] = sprintf($this->lang->line('success_item_added'), "Image", "uploaded");
                        $data1 = array(
                            'file_name' => $fileName,
                            'insert_profile' => '2',
                            'post_id' => $insert_id,
                            'is_deleted' => '1',
                            'post_format' => $file_type
                        );
                        //echo "<pre>"; print_r($data1);
                        $insert_id1 = $this->common->insert_data_getid($data1, 'post_files');
                        /* THIS CODE UNCOMMENTED AFTER SUCCESSFULLY WORKING : REMOVE IMAGE FROM UPLOAD FOLDER */

                        if ($_SERVER['HTTP_HOST'] != "localhost") {
                            if (isset($main_image)) {
                                unlink($main_image);
                            }
                            if (isset($thumb_image)) {
                                unlink($thumb_image);
                            }
                            if (isset($resize_image)) {
                                unlink($resize_image);
                            }
                            if (isset($resize_image1)) {
                                unlink($resize_image1);
                            }
                            if (isset($resize_image2)) {
                                unlink($resize_image2);
                            }
                            if (isset($resize_image4)) {
                                unlink($resize_image4);
                            }
                        }
                        /* THIS CODE UNCOMMENTED AFTER SUCCESSFULLY WORKING : REMOVE IMAGE FROM UPLOAD FOLDER */
                    } else {
                        echo $this->upload->display_errors();
                        exit;
                    }
                } else {
                    $this->session->set_flashdata('error', '<div class="col-md-7 col-sm-7 alert alert-danger1">Something went to wrong in uploded file.</div>');
                    exit;
                }
            } //die();
        }
// new code end
// return html

        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');
        $business_profile_id = $this->data['business_common_data'][0]['business_profile_id'];
        $city = $this->data['business_common_data'][0]['city'];
        $user_id = $this->data['business_common_data'][0]['user_id'];
        $business_user_image = $this->data['business_common_data'][0]['business_user_image'];
        $business_slug = $this->data['business_common_data'][0]['business_slug'];
        $company_name = $this->data['business_common_data'][0]['company_name'];
        $profile_background = $this->data['business_common_data'][0]['profile_background'];
        $state = $this->data['business_common_data'][0]['state'];
        $industriyal = $this->data['business_common_data'][0]['industriyal'];
        $other_industrial = $this->data['business_common_data'][0]['other_industrial'];

        /* SELF USER LIST START */
        $self_list = array($userid);
        /* SELF USER LIST END */

        /* FOLLOWER USER LIST START */
        $condition_array = array('follow_from' => $business_profile_id, 'follow_status' => '1', 'follow_type' => '2');
        $join_str[0]['table'] = 'business_profile';
        $join_str[0]['join_table_id'] = 'business_profile.business_profile_id';
        $join_str[0]['from_table_id'] = 'follow.follow_to';
        $join_str[0]['join_type'] = '';
        $followerdata = $this->data['followerdata'] = $this->common->select_data_by_condition('follow', $condition_array, $data = 'GROUP_CONCAT(user_id) as follow_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        $follower_list = $followerdata[0]['follow_list'];
        $follower_list = explode(',', $follower_list);
        /* FOLLOWER USER LIST END */

        /* INDUSTRIAL AND CITY WISE DATA START */
        $condition_array = array('business_profile.is_deleted' => '0', 'business_profile.status' => '1', 'business_profile.business_step' => '4');
        $search_condition = "(business_profile.industriyal = '$industriyal' AND business_profile.industriyal != 0) AND (business_profile.other_industrial = '$other_industrial' AND business_profile.other_industrial != '') OR (business_profile.city = '$city')";
        $data = "GROUP_CONCAT(user_id) as industry_city_user_list";
        $industrial_city_data = $this->common->select_data_by_search('business_profile', $search_condition, $condition_array, $data, $sortby = '', $orderby = 'DESC', $limit = '', $offset = '', $join_str_contact = array(), $groupby = '');
        $industrial_city_list = $industrial_city_data[0]['industry_city_user_list'];
        $industrial_city_list = explode(',', $industrial_city_list);
        /* INDUSTRIAL AND CITY WISE DATA END */

        $total_user_list = array_merge($self_list, $follower_list, $industrial_city_list);
        $total_user_list = array_unique($total_user_list, SORT_REGULAR);
        $total_user_list = implode(',', $total_user_list);
        $total_user_list = str_replace(",", "','", $total_user_list);

        $condition_array = array('business_profile_post.is_delete' => '0', 'business_profile_post.status' => '1', 'FIND_IN_SET ("' . $user_id . '", delete_post) !=' => '0');
        $delete_postdata = $this->common->select_data_by_condition('business_profile_post', $condition_array, $data = 'GROUP_CONCAT(business_profile_post_id) as delete_post_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $delete_post_id = $delete_postdata[0]['delete_post_id'];
        $delete_post_id = str_replace(",", "','", $delete_post_id);

        $condition_array = array('business_profile_post.is_delete' => '0', 'business_profile_post.status' => '1');
        $search_condition = "(`business_profile_post_id` NOT IN ('$delete_post_id') AND (business_profile_post.user_id IN ('$total_user_list'))) OR (posted_user_id ='$user_id')";
        $join_str[0]['table'] = 'business_profile';
        $join_str[0]['join_table_id'] = 'business_profile.user_id';
        $join_str[0]['from_table_id'] = 'business_profile_post.user_id';
        $join_str[0]['join_type'] = '';
        $data = "business_profile.business_user_image,business_profile.company_name,business_profile.industriyal,business_profile.business_slug,business_profile.other_industrial,business_profile.business_slug,business_profile_post.business_profile_post_id,business_profile_post.product_name,business_profile_post.product_description,business_profile_post.business_likes_count,business_profile_post.business_like_user,business_profile_post.created_date,business_profile_post.posted_user_id,business_profile.user_id";
        $business_profile_post = $this->common->select_data_by_search('business_profile_post', $search_condition, $condition_array, $data, $sortby = 'business_profile_post_id', $orderby = 'DESC', $limit = '1', $offset = '0', $join_str, $groupby = '');

        $return_html = '';
        $row = $business_profile_post[0];
        $post_business_user_image = $row['business_user_image'];
        $post_company_name = $row['company_name'];
        $post_business_profile_post_id = $row['business_profile_post_id'];
        $post_product_name = $row['product_name'];
        //$post_product_image = $row['product_image'];
        $post_product_description = $row['product_description'];
        $post_business_likes_count = $row['business_likes_count'];
        $post_business_like_user = $row['business_like_user'];
        $post_created_date = $row['created_date'];
        $post_posted_user_id = $row['posted_user_id'];
        $post_business_slug = $row['business_slug'];
        $post_industriyal = $row['industriyal'];
        $post_category = $this->db->get_where('industry_type', array('industry_id' => $post_industriyal, 'status' => '1'))->row()->industry_name;
        $post_other_industrial = $row['other_industrial'];
        $post_user_id = $row['user_id'];
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
                if (IMAGEPATHFROM == 'upload') {
                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $posted_business_user_image)) {
                        $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                    } else {
                        $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $posted_business_user_image . '" name = "image_src" id = "image_src" alt="'. $posted_business_user_image .'"/>';
                    }
                } else {
                    $filename = $this->config->item('bus_profile_thumb_upload_path') . $posted_business_user_image;
                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                    if (!$info) {
                        $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                    } else {
                        $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $posted_business_user_image . '" name = "image_src" id = "image_src" alt="'. $posted_business_user_image .'"/>';
                    }
                }

                $return_html .= '</a>';
            } else {
                $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $posted_business_slug) . '">';
                $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                $return_html .= '</a>';
            }
        } else {
            if ($post_business_user_image) {
                $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $post_business_slug) . '">';
                if (IMAGEPATHFROM == 'upload') {
                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $post_business_user_image)) {
                        $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                    } else {
                        $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $post_business_user_image . '" alt = "'. $post_business_user_image .'">';
                    }
                } else {
                    $filename = $this->config->item('bus_profile_thumb_upload_path') . $post_business_user_image;
                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                    if (!$info) {
                        $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                    } else {
                        $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $post_business_user_image . '" alt = "'. $post_business_user_image .'">';
                    }
                }
                $return_html .= '</a>';
            } else {
                $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $post_business_slug) . '">';
                $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
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
<div class = "dropdown1">';
        if ($id == 'manage') {
            $return_html .= '<a onClick = "myFunction1(' . $post_business_profile_post_id . ')" class = "dropbtn_common  dropbtn1 fa fa-ellipsis-v"></a>';
        } else {
            $return_html .= '<a onClick = "myFunction(' . $post_business_profile_post_id . ')" class = "dropbtn_common  dropbtn1 fa fa-ellipsis-v"></a>';
        }
        $return_html .= '<div id = "myDropdown' . $post_business_profile_post_id . '" class = "dropdown-content1 dropdown2_content">';

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
        $businessmultiimage = $this->common->select_data_by_condition('post_files', $contition_array, $data = 'file_name,post_files_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if (count($businessmultiimage) == 1) {

            $allowed = array('jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg');
//            $allowed = VALID_IMAGE;
            $allowespdf = array('pdf');
            $allowesvideo = array('mp4', 'webm', 'qt', 'mov', 'MP4');
            $allowesaudio = array('mp3');
            $filename = $businessmultiimage[0]['file_name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (in_array($ext, $allowed)) {

                $return_html .= '<div class = "one-image">';

                $return_html .= '<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" alt="'. $businessmultiimage[0]['file_name'] .'">
</a>
</div>';
            } elseif (in_array($ext, $allowespdf)) {

                /*    $return_html .= '<div>
                  <a title = "click to open" href = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '"><div class = "pdf_img">
                  <embed src="' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" width="100%" height="450px" />
                  </div>
                  </a>
                  </div>'; */
                $return_html .= '<div>
<a title = "click to open" href = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" target="_blank"><div class = "pdf_img">
    <img src="' . base_url('assets/images/PDF.jpg') . '" alt="PDF.jpg">
</div>
</a>
</div>';
            } elseif (in_array($ext, $allowesvideo)) {
                $post_poster = $businessmultiimage[0]['file_name'];
                $post_poster1 = explode('.', $post_poster);
                $post_poster2 = end($post_poster1);
                $post_poster = str_replace($post_poster2, 'png', $post_poster);

                if (IMAGEPATHFROM == 'upload') {
                    $return_html .= '<div>';
                    if (file_exists($this->config->item('bus_post_main_upload_path') . $post_poster)) {
                        $return_html .= '<video width = "100%" height = "350" id="show_video' . $businessmultiimage[0]['post_files_id'] . '" onplay="playtime(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ')" onClick="count_videouser(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ');" controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $return_html .= '<video width = "100%" height = "350" id="show_video' . $businessmultiimage[0]['post_files_id'] . '" onplay="playtime(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ')" onClick="count_videouser(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ');" controls>';
                    }
                    $return_html .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" type = "video/mp4">';
                    //$return_html .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" type = "video/ogg">';
                    $return_html .= 'Your browser does not support the video tag.';
                    $return_html .= '</video>';
                    $return_html .= '</div>';
                } else {
                    $filename = $this->config->item('bus_post_main_upload_path') . $post_poster;
                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                    $return_html .= '<div>';
                    if ($info) {
                        $return_html .= '<video width = "100%" height = "350" id="show_video' . $businessmultiimage[0]['post_files_id'] . '" onplay="playtime(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ')" onClick="count_videouser(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ');" controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $return_html .= '<video width = "100%" height = "350" id="show_video' . $businessmultiimage[0]['post_files_id'] . '" onplay="playtime(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ')" onClick="count_videouser(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ');" controls>';
                    }
                    $return_html .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" type = "video/mp4">';
                    //$return_html .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" type = "video/ogg">';
                    $return_html .= 'Your browser does not support the video tag.';
                    $return_html .= '</video>';
                    $return_html .= '</div>';
                }
            } elseif (in_array($ext, $allowesaudio)) {

                $return_html .= '<div class = "audio_main_div">
<div class = "audio_img">
<img src = "' . base_url('assets/images/music-icon.png') . '" alt="music-icon.png">
</div>
<div class = "audio_source">
<audio id = "audio_player" width = "100%" height = "100" controls>
<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" type = "audio/mp3">
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
<img class = "two-columns" src = "' . BUS_POST_RESIZE1_UPLOAD_URL . $multiimage['file_name'] . '" alt="'. $multiimage['file_name'] .'">
</a>
</div>';
            }
        } elseif (count($businessmultiimage) == 3) {

            $return_html .= '<div class = "three-image-top" >
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img class = "three-columns" src = "' . BUS_POST_RESIZE4_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" alt="'. $businessmultiimage[0]['file_name'] .'">
</a>
</div>
<div class = "three-image" >

<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img class = "three-columns" src = "' . BUS_POST_RESIZE1_UPLOAD_URL . $businessmultiimage[1]['file_name'] . '" alt="'. $businessmultiimage[1]['file_name'] .'">
</a>
</div>
<div class = "three-image" >
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img class = "three-columns" src = "' . BUS_POST_RESIZE1_UPLOAD_URL . $businessmultiimage[2]['file_name'] . '" alt="'. $businessmultiimage[2]['file_name'] .'">
</a>
</div>';
        } elseif (count($businessmultiimage) == 4) {

            foreach ($businessmultiimage as $multiimage) {

                $return_html .= '<div class = "four-image">
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img class = "breakpoint" src = "' . BUS_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name'] . '" alt="'. $multiimage['file_name'] .'">
</a>
</div>';
            }
        } elseif (count($businessmultiimage) > 4) {

            $i = 0;
            foreach ($businessmultiimage as $multiimage) {

                $return_html .= '<div class = "four-image">
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img src = "' . BUS_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name'] . '" alt="'. $multiimage['file_name'] .'">
</a>
</div>';

                $i++;
                if ($i == 3)
                    break;
            }

            $return_html .= '<div class = "four-image">
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img src = "' . BUS_POST_RESIZE2_UPLOAD_URL . $businessmultiimage[3]['file_name'] . '" alt="'. $businessmultiimage[3]['file_name'] .'">
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
        $likeuserarray = explode(',', $post_business_like_user);
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
<ul class = "col-md-6 col-sm-6 col-xs-6 like_cmnt_count">';

        $contition_array = array('post_id' => $row['business_profile_post_id'], 'insert_profile' => '2');
        $postformat = $this->common->select_data_by_condition('post_files', $contition_array, $data = 'post_format', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        //echo "<pre>"; print_r($postformat); die();
        if ($postformat[0]['post_format'] == 'video') {
            $return_html .= '<li id="viewvideouser' . $row['business_profile_post_id'] . '">';

            $contition_array = array('post_id' => $row['business_profile_post_id']);
            $userdata = $this->common->select_data_by_condition('showvideo', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $user_data = count($userdata);

            if ($user_data > 0) {

                $return_html .= '<div class="comnt_count_ext_a  comnt_count_ext2"><span>';

                $return_html .= $user_data . ' ' . 'Views';

                $return_html .= '</span></div></li>';
            }
        }

        $return_html .= '<li>
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

            $likeuser = $post_business_like_user;
            $countlike = $post_business_likes_count - 1;
            $likelistarray = explode(',', $likeuser);

            $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $likelistarray[0], 'status' => '1'))->row()->company_name;
            $return_html .= '<div class = "like_one_other">';
            $return_html .= '<a href = "javascript:void(0);" onclick = "likeuserlist(' . $post_business_profile_post_id . ')">';
            if (in_array($userid, $likelistarray)) {
                $return_html .= "You";
                $return_html .= "&nbsp;";
            } else {
                $return_html .= ucfirst($business_fname1);
                $return_html .= "&nbsp;";
            }

            if (count($likelistarray) > 1) {
                $return_html .= " and";

                $return_html .= $countlike;
                $return_html .= "&nbsp;";
                $return_html .= "others";
            }
            $return_html .= '</a></div>
</div>';
        }

        $return_html .= '<div class = "likeusername' . $post_business_profile_post_id . '" id = "likeusername' . $post_business_profile_post_id . '" style = "display:none">';
        $likeuser = $post_business_like_user;
        $countlike = $post_business_likes_count - 1;
        $likelistarray = explode(',', $likeuser);
//        foreach ($likelistarray as $key => $value) {
//            $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => '1'))->row()->company_name;
//        }

        $contition_array = array('business_profile_post_id' => $post_business_profile_post_id, 'status' => '1', 'is_delete' => '0');
        $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $likeuser = $post_business_like_user;
        $countlike = $post_business_likes_count - 1;
        $likelistarray = explode(',', $likeuser);

        $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => '1'))->row()->company_name;

        $return_html .= '<div class = "like_one_other">';
        $return_html .= '<a href = "javascript:void(0);" onclick = "likeuserlist(' . $post_business_profile_post_id . ')">';
        $return_html .= ucfirst($business_fname1);
        $return_html .= "&nbsp;";

        if (count($likelistarray) > 1) {

            $return_html .= "and";

            $return_html .= $countlike;
            $return_html .= "&nbsp;";
            $return_html .= "others";
        }
        $return_html .= '</a></div>
</div>

<div class = "art-all-comment col-md-12">
<div id = "fourcomment' . $post_business_profile_post_id . '" style = "display:none;">
</div>
<div id = "threecomment' . $post_business_profile_post_id . '" style = "display:block">
<div class = "hidebottomborder insertcomment' . $post_business_profile_post_id . '">';

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
                    if (IMAGEPATHFROM == 'upload') {
                        if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                            $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                        } else {
                            $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt = "'. $business_userimage . '">';
                        }
                    } else {
                        $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_userimage;
                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                        if (!$info) {
                            $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                        } else {
                            $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt = "'. $business_userimage .'">';
                        }
                    }
                    $return_html .= '</a>';
                } else {
                    $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $slugname1) . '">';

                    $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE"></a>';
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
                $likeuserarray = explode(',', $businesscommentlike[0]['business_comment_like_user']);
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

                $return_html .= '</span>
</a>
</div>';
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
                $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $rowdata['business_profile_post_id'], 'status' => '1'))->row()->user_id;
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
            if (IMAGEPATHFROM == 'upload') {
                if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                    $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                } else {
                    $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt = "'. $business_userimage .'">';
                }
            } else {
                $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_userimage;
                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                if (!$info) {
                    $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                } else {
                    $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt = "'. $business_userimage .'">';
                }
            }
        } else {
            $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
        }
        $return_html .= '</div>

<div id = "content" class = "col-md-12  inputtype-comment cmy_2" >
<div contenteditable = "true" class = "edt_2 editable_text" name = "' . $post_business_profile_post_id . '" id = "post_comment' . $post_business_profile_post_id . '" placeholder = "Add a Comment ..." onClick = "entercomment(' . $post_business_profile_post_id . ')" onpaste = "OnPaste_StripFormatting(this, event);"></div>
<div class="mob-comment">       
                            <button id="' . $post_business_profile_post_id . '" onClick="insert_comment(this.id)"><img src="' . base_url('assets/img/send.png') . '" alt="send.png">
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

        echo $return_html;
//    }
// return html         
    }

    public function business_profile_editpost($id) {
        $s3 = new S3(awsAccessKey, awsSecretKey);

        $this->business_profile_active_check();
        $this->is_business_profile_register();

        $contition_array = array('business_profile_post_id' => $id);
        $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->load->view('business_profile/business_profile_editpost', $this->data);
    }

    public function business_profile_editpost_insert($id) {
        $s3 = new S3(awsAccessKey, awsSecretKey);

        $this->business_profile_active_check();
        $this->is_business_profile_register();

        $editimage = $this->input->post('hiddenimg');

        $this->form_validation->set_rules('productname', 'Product name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('business_profile/business_profile_editpost');
        } else {


            $config['upload_path'] = $this->config->item('bus_post_main_upload_path');
            $config['allowed_types'] = $this->config->item('bus_post_main_allowed_types');

            $config['file_name'] = $_FILES['image']['name'];
            $config['upload_max_filesize'] = '40M';

//Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('image')) {
                $uploadData = $this->upload->data();

//Configuring Thumbnail 
                $business_post_thumb['image_library'] = 'gd2';
                $business_post_thumb['source_image'] = $config['upload_path'] . $uploadData['file_name'];
                $business_post_thumb['new_image'] = $this->config->item('user_thumb_upload_path') . $imgdata['file_name'];
                $business_post_thumb['create_thumb'] = TRUE;
                $business_post_thumb['maintain_ratio'] = TRUE;
                $business_post_thumb['thumb_marker'] = '';
                $business_post_thumb['width'] = $this->config->item('user_thumb_width');
//$user_thumb['height'] = $this->config->item('user_thumb_height');
                $business_post_thumb['height'] = 2;
                $business_post_thumb['master_dim'] = 'width';
                $business_post_thumb['quality'] = "100%";
                $business_post_thumb['x_axis'] = '0';
                $business_post_thumb['y_axis'] = '0';
//Loading Image Library
                $this->load->library('image_lib', $user_thumb);
                $dataimage = $imgdata['file_name'];
//Creating Thumbnail
                $this->image_lib->resize();
                $thumberror = $this->image_lib->display_errors();

                $picture = $uploadData['file_name'];
            } else {
                $picture = '';
            }


            if ($picture) {

                $data = array(
                    'product_name' => $this->input->post('productname'),
                    //'product_image' => $picture,
                    'product_description' => $this->input->post('description'),
                    'modify_date' => date('Y-m-d', time())
                );
            } else {
                $data = array(
                    'product_name' => $this->input->post('productname'),
                    //'product_image' => $this->input->post('hiddenimg'),
                    'product_description' => $this->input->post('description'),
                    'modify_date' => date('Y-m-d', time())
                );
            }

            $updatdata = $this->common->update_data($data, 'business_profile_post', 'business_profile_post_id', $id);

            if ($updatdata) {
                redirect('business-profile/dashboard', refresh);
            } else {
                $this->session->flashdata('error', 'Your data not inserted');
                redirect('business-profile/business-profile-editpost', refresh);
            }
        }
    }

    public function user_image_insert() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid);
        $business_slug = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $business_user_slug = $business_slug[0]['business_slug'];

        if ($this->input->post('cancel2')) {
            redirect('business-profile/home', refresh);
        } elseif ($this->input->post('cancel1')) {
            redirect('business-profile/business-profile-save-post', refresh);
        } elseif ($this->input->post('cancel3')) {
            redirect('business-profile/business-profile-addpost', refresh);
        } elseif ($this->input->post('cancel4')) {
            redirect('business-profile/details', refresh);
        } elseif ($this->input->post('cancel5')) {
            redirect('business-profile/dashboard', refresh);
        } elseif ($this->input->post('cancel6')) {
            redirect('business-profile/userlist', refresh);
        } elseif ($this->input->post('cancel7')) {
            redirect('business-profile/followers', refresh);
        } elseif ($this->input->post('cancel8')) {
            redirect('business-profile/following', refresh);
        }

        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);

        if (empty($_FILES['profilepic']['name'])) {
            $this->form_validation->set_rules('profilepic', 'Upload profilepic', 'required');
        } else {
            $user_image = '';
            $user['upload_path'] = $this->config->item('bus_profile_main_upload_path');
            $user['allowed_types'] = $this->config->item('bus_profile_main_allowed_types');
            $user['max_size'] = $this->config->item('bus_profile_main_max_size');
            $user['max_width'] = $this->config->item('bus_profile_main_max_width');
            $user['max_height'] = $this->config->item('bus_profile_main_max_height');
            $this->load->library('upload');
            $this->upload->initialize($user);
//Uploading Image
            $this->upload->do_upload('profilepic');
//Getting Uploaded Image File Data
            $imgdata = $this->upload->data();

            $main_image = $this->config->item('bus_profile_main_upload_path') . $imgdata['file_name'];
            $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);

            $imgerror = $this->upload->display_errors();
            if ($imgerror == '') {
//Configuring Thumbnail 
                $user_thumb['image_library'] = 'gd2';
                $user_thumb['source_image'] = $user['upload_path'] . $imgdata['file_name'];
                $user_thumb['new_image'] = $this->config->item('bus_profile_thumb_upload_path') . $imgdata['file_name'];
                $user_thumb['create_thumb'] = TRUE;
                $user_thumb['maintain_ratio'] = TRUE;
                $user_thumb['thumb_marker'] = '';
                $user_thumb['width'] = $this->config->item('bus_profile_thumb_width');
//$user_thumb['height'] = $this->config->item('user_thumb_height');
                $user_thumb['height'] = 2;
                $user_thumb['master_dim'] = 'width';
                $user_thumb['quality'] = "100%";
                $user_thumb['x_axis'] = '0';
                $user_thumb['y_axis'] = '0';
//Loading Image Library
                $this->load->library('image_lib', $user_thumb);
                $dataimage = $imgdata['file_name'];
//Creating Thumbnail
                $this->image_lib->resize();

                $thumb_image = $this->config->item('bus_profile_thumb_upload_path') . $imgdata['file_name'];
                $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);
                $thumberror = $this->image_lib->display_errors();
            } else {
                $thumberror = '';
            }
            if ($imgerror != '' || $thumberror != '') {
                $error[0] = $imgerror;
                $error[1] = $thumberror;
            } else {
                $error = array();
            }
            if ($error) {
                $this->session->set_flashdata('error', $error[0]);
                $redirect_url = site_url('business-profile');
                redirect($redirect_url, 'refresh');
            } else {

                $contition_array = array('user_id' => $userid);
                $user_reg_data = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $user_reg_prev_image = $user_reg_data[0]['business_user_image'];

                if ($user_reg_prev_image != '') {
                    $user_image_main_path = $this->config->item('bus_profile_main_upload_path');
                    $user_bg_full_image = $user_image_main_path . $user_reg_prev_image;
                    if (isset($user_bg_full_image)) {
                        unlink($user_bg_full_image);
                    }

                    $user_image_thumb_path = $this->config->item('bus_profile_thumb_upload_path');
                    $user_bg_thumb_image = $user_image_thumb_path . $user_reg_prev_image;
                    if (isset($user_bg_thumb_image)) {
                        unlink($user_bg_thumb_image);
                    }
                }

                $user_image = $imgdata['file_name'];
            }


            $data = array(
                'business_user_image' => $user_image,
                'modified_date' => date('Y-m-d', time())
            );


            $updatdata = $this->common->update_data($data, 'business_profile', 'user_id', $userid);

            if ($updatdata) {

                if ($_SERVER['HTTP_HOST'] != "localhost") {
                    if (isset($main_image)) {
                        unlink($main_image);
                    }
                    if (isset($thumb_image)) {
                        unlink($thumb_image);
                    }
                }
                if ($this->input->post('hitext') == 1) {
                    redirect('business-profile/business-profile-save-post', refresh);
                } elseif ($this->input->post('hitext') == 2) {
                    redirect('business-profile/home', refresh);
                } elseif ($this->input->post('hitext') == 3) {
                    redirect('business-profile/business-profile-addpost', refresh);
                } elseif ($this->input->post('hitext') == 4) {
                    redirect('business-profile/details', refresh);
                } elseif ($this->input->post('hitext') == 5) {
                    redirect('business-profile/dashboard', refresh);
                } elseif ($this->input->post('hitext') == 6) {
                    redirect('business-profile/userlist', refresh);
                } elseif ($this->input->post('hitext') == 7) {
                    redirect('business-profile/followers', refresh);
                } elseif ($this->input->post('hitext') == 8) {
                    redirect('business-profile/following', refresh);
                } elseif ($this->input->post('hitext') == 9) {
                    redirect('business-profile/photos', refresh);
                } elseif ($this->input->post('hitext') == 10) {
                    redirect('business-profile/videos', refresh);
                } elseif ($this->input->post('hitext') == 11) {
                    redirect('business-profile/audios', refresh);
                } elseif ($this->input->post('hitext') == 12) {
                    redirect('business-profile/pdf', refresh);
                } elseif ($this->input->post('hitext') == 13) {
                    if ($business_user_slug) {
                        redirect('business-profile/contacts/' . $business_user_slug, refresh);
                    } else {
                        redirect('business-profile/contacts/', refresh);
                    }
                }
            } else {
                $this->session->flashdata('error', 'Your data not inserted');
                redirect('business-profile/home', refresh);
            }
        }
    }

    public function user_image_insert_new() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid);
        $user_reg_data = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $user_reg_prev_image = $user_reg_data[0]['business_user_image'];

        if ($user_reg_prev_image != '') {
            $user_image_main_path = $this->config->item('bus_profile_main_upload_path');
            $user_bg_full_image = $user_image_main_path . $user_reg_prev_image;
            if (isset($user_bg_full_image)) {
                unlink($user_bg_full_image);
            }

            $user_image_thumb_path = $this->config->item('bus_profile_thumb_upload_path');
            $user_bg_thumb_image = $user_image_thumb_path . $user_reg_prev_image;
            if (isset($user_bg_thumb_image)) {
                unlink($user_bg_thumb_image);
            }
        }


        $data = $_POST['image'];
        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);
        $user_bg_path = $this->config->item('bus_profile_main_upload_path');
        $imageName = time() . '.png';
        $data = base64_decode($data);
        $file = $user_bg_path . $imageName;
        file_put_contents($user_bg_path . $imageName, $data);
        $success = file_put_contents($file, $data);
        $main_image = $user_bg_path . $imageName;
        $main_image_size = filesize($main_image);

        if ($main_image_size > '1000000') {
            $quality = "50%";
        } elseif ($main_image_size > '50000' && $main_image_size < '1000000') {
            $quality = "55%";
        } elseif ($main_image_size > '5000' && $main_image_size < '50000') {
            $quality = "60%";
        } elseif ($main_image_size > '100' && $main_image_size < '5000') {
            $quality = "65%";
        } elseif ($main_image_size > '1' && $main_image_size < '100') {
            $quality = "70%";
        } else {
            $quality = "100%";
        }

        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
        $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);

        $user_thumb_path = $this->config->item('bus_profile_thumb_upload_path');
        $user_thumb_width = $this->config->item('bus_profile_thumb_width');
        $user_thumb_height = $this->config->item('bus_profile_thumb_height');

        $upload_image = $user_bg_path . $imageName;

//        $thumb_image_uplode = $this->thumb_img_uplode($upload_image, $imageName, $user_thumb_path, $user_thumb_width, $user_thumb_height);

        $thumb_image = $user_thumb_path . $imageName;

        copy($main_image, $thumb_image);

        $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);

        $data = array(
            'business_user_image' => $imageName
        );

        $update = $this->common->update_data($data, 'business_profile', 'user_id', $userid);

        if ($update) {

            if ($_SERVER['HTTP_HOST'] != "localhost") {
                if (isset($main_image)) {
                    unlink($main_image);
                }
                if (isset($thumb_image)) {
                    unlink($thumb_image);
                }
            }

            $contition_array = array('user_id' => $userid, 'status' => '1', 'is_deleted' => '0');
            $businesspostdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
            $userimage .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $businesspostdata[0]['business_user_image'] . '" alt="'. $businesspostdata[0]['business_user_image'] .'" >';
            $userimage .= '<a class="cusome_upload" href="javascript:void(0);" onclick="updateprofilepopup();"><img src="' . base_url('assets/img/cam.png') . '" alt="cam.png">';
            $userimage .= $this->lang->line("update_profile_picture");
            $userimage .= '</a>';

            echo $userimage;
        } else {

            $this->session->flashdata('error', 'Your data not inserted');
            redirect('business-profile', refresh);
        }
    }

    public function business_resume($id = "") {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $this->data['slugid'] = $id;
        $userid = $this->session->userdata('aileenuser');
        if ($userid) {
            $this->business_profile_active_check();
            $this->is_business_profile_register();
        }
        if (!$this->session->userdata('aileenuser')) {
            include ('business_profile_include.php');
        }
        if ($id != '') {
            $contition_array = array('business_profile.business_slug' => $id, 'business_profile.is_deleted' => '0', 'business_profile.status' => '1', 'business_profile.business_step' => '4');
            $join_str[0]['table'] = 'countries';
            $join_str[0]['join_table_id'] = 'countries.country_id';
            $join_str[0]['from_table_id'] = 'business_profile.country';
            $join_str[0]['join_type'] = '';
            $join_str[1]['table'] = 'states';
            $join_str[1]['join_table_id'] = 'states.state_id';
            $join_str[1]['from_table_id'] = 'business_profile.state';
            $join_str[1]['join_type'] = '';
            $join_str[2]['table'] = 'cities';
            $join_str[2]['join_table_id'] = 'cities.city_id';
            $join_str[2]['from_table_id'] = 'business_profile.city';
            $join_str[2]['join_type'] = 'LEFT';
            $join_str[3]['table'] = 'business_type';
            $join_str[3]['join_table_id'] = 'business_type.type_id';
            $join_str[3]['from_table_id'] = 'business_profile.business_type';
            $join_str[3]['join_type'] = 'LEFT';
            $join_str[4]['table'] = 'industry_type';
            $join_str[4]['join_table_id'] = 'industry_type.industry_id';
            $join_str[4]['from_table_id'] = 'business_profile.industriyal';
            $join_str[4]['join_type'] = 'LEFT';
            $business_data = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile.company_name,countries.country_name,states.state_name,cities.city_name,business_profile.pincode,business_profile.address,business_profile.contact_person,business_profile.contact_mobile,business_profile.contact_email,business_profile.contact_website,business_type.business_name,industry_type.industry_name,business_profile.details,business_profile.other_business_type,business_profile.other_industrial', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        } else {
            $userid = $this->session->userdata('aileenuser');
            $contition_array = array('business_profile.user_id' => $userid, 'business_profile.is_deleted' => '0', 'business_profile.status' => '1', 'business_profile.business_step' => '4');
            $join_str[0]['table'] = 'countries';
            $join_str[0]['join_table_id'] = 'countries.country_id';
            $join_str[0]['from_table_id'] = 'business_profile.country';
            $join_str[0]['join_type'] = '';
            $join_str[1]['table'] = 'states';
            $join_str[1]['join_table_id'] = 'states.state_id';
            $join_str[1]['from_table_id'] = 'business_profile.state';
            $join_str[1]['join_type'] = '';
            $join_str[2]['table'] = 'cities';
            $join_str[2]['join_table_id'] = 'cities.city_id';
            $join_str[2]['from_table_id'] = 'business_profile.city';
            $join_str[2]['join_type'] = '';
            $join_str[3]['table'] = 'business_type';
            $join_str[3]['join_table_id'] = 'business_type.type_id';
            $join_str[3]['from_table_id'] = 'business_profile.business_type';
            $join_str[3]['join_type'] = 'LEFT';
            $join_str[4]['table'] = 'industry_type';
            $join_str[4]['join_table_id'] = 'industry_type.industry_id';
            $join_str[4]['from_table_id'] = 'business_profile.industriyal';
            $join_str[4]['join_type'] = 'LEFT';
            $business_data = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile.company_name,countries.country_name,states.state_name,cities.city_name,business_profile.pincode,business_profile.address,business_profile.contact_person,business_profile.contact_mobile,business_profile.contact_email,business_profile.contact_website,business_type.business_name,industry_type.industry_name,business_profile.details,business_profile.other_business_type,business_profile.other_industrial', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        }


        $this->data['business_data']['company_name'] = $business_data[0]['company_name'] == '' ? PROFILENA : $business_data[0]['company_name'];
        $this->data['business_data']['country_name'] = $business_data[0]['country_name'] == '' ? PROFILENA : $business_data[0]['country_name'];
        $this->data['business_data']['state_name'] = $business_data[0]['state_name'] == '' ? PROFILENA : $business_data[0]['state_name'];
        $this->data['business_data']['city_name'] = $business_data[0]['city_name'] == '' ? PROFILENA : $business_data[0]['city_name'];
        $this->data['business_data']['pincode'] = $business_data[0]['pincode'] == '' ? PROFILENA : $business_data[0]['pincode'];
        $this->data['business_data']['address'] = $business_data[0]['address'] == '' ? PROFILENA : $business_data[0]['address'];
        $this->data['business_data']['contact_person'] = $business_data[0]['contact_person'] == '' ? PROFILENA : $business_data[0]['contact_person'];
        $this->data['business_data']['contact_mobile'] = $business_data[0]['contact_mobile'] == '0' ? PROFILENA : $business_data[0]['contact_mobile'];
        $this->data['business_data']['contact_email'] = $business_data[0]['contact_email'] == '' ? PROFILENA : $business_data[0]['contact_email'];
        $this->data['business_data']['contact_website'] = $business_data[0]['contact_website'] == '' ? PROFILENA : $business_data[0]['contact_website'];
        $this->data['business_data']['business_type'] = $business_data[0]['business_name'] == '' ? PROFILENA : $business_data[0]['business_name'];
        if ($this->data['business_data']['business_type'] == '--') {
            $this->data['business_data']['business_type'] = $business_data[0]['other_business_type'];
        }
        $this->data['business_data']['industry_name'] = $business_data[0]['industry_name'] == '' ? PROFILENA : $business_data[0]['industry_name'];
        if ($this->data['business_data']['industry_name'] == '--') {
            $this->data['business_data']['industry_name'] = $business_data[0]['other_industrial'];
        }
        $this->data['business_data']['details'] = $business_data[0]['details'] == '' ? PROFILENA : $business_data[0]['details'];


// $slug_data this data come from include
        if ($id == $slug_data[0]['business_slug'] || $id == '') {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0');
            $this->data['busimagedata'] = $this->common->select_data_by_condition('bus_image', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {
            $contition_array = array('user_id' => $this->data['business_common_data'][0]['user_id'], 'is_delete' => '0');
            $this->data['busimagedata'] = $this->common->select_data_by_condition('bus_image', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }
        $company_name = $this->get_company_name($id);
        $this->data['title'] = ucwords($company_name) .' | Detail' .TITLEPOSTFIX;

//manage post end
        if (count($business_data) == 0) {
            $this->load->view('business_profile/notavalible');
        } else {
            if ($this->session->userdata('aileenuser')) {
                $this->load->view('business_profile/business_resume', $this->data);
            } else {
                $this->data['business_common_profile'] = $this->load->view('business_profile/business_common_profile', $this->data, true);
                $this->load->view('business_profile/business_details', $this->data);
            }
        }
    }

    public function business_user_post($id) {
        $s3 = new S3(awsAccessKey, awsSecretKey);

        $this->data['userid'] = $id;
        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['businessdata'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->data['usdata'] = $this->common->select_data_by_id('user', 'user_id', $id, $data = '*', $join_str = array());

        $contition_array = array('user_id' => $id);
        $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->load->view('business_profile/business_profile_manage_post', $this->data);
    }

//Business Profile Save Post Start
    public function business_profile_save() {
        $s3 = new S3(awsAccessKey, awsSecretKey);

        $id = $_POST['business_profile_post_id'];
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('post_id' => $id, 'user_id' => $userid, 'is_delete' => '0');
        $userdata = $this->common->select_data_by_condition('business_profile_save', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $save_id = $userdata[0]['save_id'];
        if ($userdata) {
            $contition_array = array('business_delete' => '1');
            $jobdata = $this->common->select_data_by_condition('business_profile_save', $contition_array, $data = 'save_id', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $data = array(
                'business_delete' => '0',
                'business_save' => '1'
            );
            $updatedata = $this->common->update_data($data, 'business_profile_save', 'save_id', $save_id);
            if ($updatedata) {
                $savepost .= '<i class="fa fa-bookmark" aria-hidden="true"></i>';
                $savepost .= 'Saved Post';
                echo $savepost;
            }
        } else {
            $data = array(
                'post_id' => $id,
                'user_id' => $userid,
                'created_date' => date('Y-m-d H:i:s', time()),
                'is_delete' => '0',
                'business_save' => '1',
                'business_delete' => '0'
            );
            $insert_id = $this->common->insert_data_getid($data, 'business_profile_save');
            if ($insert_id) {
                $savepost .= '<i class="fa fa-bookmark" aria-hidden="true"></i>';
                $savepost .= 'Saved Post';
                echo $savepost;
            }
        }
    }

//Business Profile Save Post End
//Business Profile Remove Save Post Start
    public function business_profile_delete($id) {
        $s3 = new S3(awsAccessKey, awsSecretKey);

        $id = $_POST['save_id'];
        $userid = $this->session->userdata('aileenuser');

        $data = array(
            'business_save' => '0',
            'business_delete' => '1',
            'modify_date' => date('Y-m-d h:i:s', time())
        );
        $updatedata = $this->common->update_data($data, 'business_profile_save', 'save_id', $id);
    }

//Business Profile Remove Save Post Start
//location automatic retrieve controller start
    public function location() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $json = [];

        $this->load->database('aileensoul');



        if (!empty($this->input->get("q"))) {
            $search_condition = "(city_name LIKE '" . trim($this->input->get("q")) . "%')";

            $tolist = $this->common->select_data_by_search('cities', $search_condition, $contition_array = array(), $data = 'city_id as id,city_name as text', $sortby = 'city_name', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
        }
        echo json_encode($tolist);
    }

//location automatic retrieve controller End
// user list of artistic users

    public function userlist($id = '') {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        $compnay_name = $this->get_company_name($id);
        $this->data['title'] = ucwords($compnay_name) . ' | All User' . ' | Business Profile ' . TITLEPOSTFIX;
        $this->data['business_left'] = $this->load->view('business_profile/business_left', $this->data, TRUE);
        $this->load->view('business_profile/business_userlist', $this->data);
    }

    public function ajax_userlist() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;

        $userid = $this->session->userdata('aileenuser');

        $artdata = $this->common->select_data_by_id('business_profile', 'user_id', $userid, $data = '*');
        $contition_array = array('user_id' => $userid);
        $artisticdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $limit = $perpage;
        $offset = $start;

        $contition_array = array('business_step' => '4', 'is_deleted' => '0', 'status' => '1', 'user_id !=' => $userid);
        $userlist = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = 'business_profile_id', $orderby = 'desc', $limit, $offset, $join_str = array(), $groupby = '');
        $userlist1 = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = 'business_profile_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
        $businessdata1 = $businessdata1 = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
// followers count
        $join_str[0]['table'] = 'follow';
        $join_str[0]['join_table_id'] = 'follow.follow_to';
        $join_str[0]['from_table_id'] = 'business_profile.business_profile_id';
        $join_str[0]['join_type'] = '';

        $contition_array = array('follow_to' => $artdata[0]['business_profile_id'], 'follow_status' => '1', 'follow_type' => '1');
        $followers = count($this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = ''));

// follow count end
// fllowing count
        $join_str[0]['table'] = 'follow';
        $join_str[0]['join_table_id'] = 'follow.follow_from';
        $join_str[0]['from_table_id'] = 'business_profile.business_profile_id';
        $join_str[0]['join_type'] = '';

        $contition_array = array('follow_from' => $artdata[0]['business_profile_id'], 'follow_status' => '1', 'follow_type' => '1', 'business_profile.business_step' => '4');
        $following = count($this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = ''));

//following end

        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($userlist1);
        }
        $return_html = '';
        $return_html .= '<input type="hidden" class="page_number" value="' . $page . '" />';
        $return_html .= '<input type="hidden" class="total_record" value="' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';


        foreach ($userlist as $user) {
            $return_html .= '<div class="job-contact-frnd ">
                                                <div class="profile-job-post-detail clearfix">
                                                    <div class="profile-job-post-title-inside clearfix">
                                                        <div class="profile-job-post-location-name">
                                                            <div class="user_lst"><ul>
                                                                    <li class="fl">
                                                                        <div class="follow-img">';
            if ($user['business_user_image'] != '') {
                $return_html .= '<a href="' . base_url('business-profile/dashboard/' . $user['business_slug']) . '">';
                if (IMAGEPATHFROM == 'upload') {
                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $user['business_user_image'])) {
                        $return_html .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                    } else {
                        $return_html .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $user['business_user_image'] . '" height="50px" width="50px" alt="'. $user['business_user_image'] .'" >';
                    }
                } else {
                    $filename = $this->config->item('bus_profile_thumb_upload_path') . $user['business_user_image'];
                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                    if (!$info) {
                        $return_html .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                    } else {
                        $return_html .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $user['business_user_image'] . '" height="50px" width="50px" alt="'. $user['business_user_image'] .'" >';
                    }
                }
                $return_html .= '</a>';
            } else {
                $return_html .= '<a href="' . base_url('business-profile/dashboard/' . $user['business_slug']) . '">
                                                                                    <img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">
                                                                                </a>';
            }
            $return_html .= '</div>
                                                                    </li>
                                                                    <li class="folle_text">
                                                                        <div class="">
                                                                            <div class="follow-li-text " style="padding: 0;">
                                                                                <a title="' . $user['company_name'] . '" href="' . base_url('business-profile/dashboard/' . $user['business_slug']) . '">' . $user['company_name'] . '</a>
                                                                            </div>
                                                                            <div>';
            $category = $this->db->get_where('industry_type', array('industry_id' => $user['industriyal'], 'status' => '1'))->row()->industry_name;
            $return_html .= '<a>';
            if ($category) {
                $return_html .= $category;
            } else {
                $return_html .= ucfirst($user['other_industrial']);
                //$return_html .= $user['other_industrial'];
            }
            $return_html .= '</a>
                                                                            </div>
                                                                    </li>
                                                                    <li class="fruser' . $user['business_profile_id'] . ' fr">';

            $status = $this->db->get_where('follow', array('follow_type' => 2, 'follow_from' => $artdata[0]['business_profile_id'], 'follow_to' => $user['business_profile_id']))->row()->follow_status;
            if ($status == 0 || $status == " ") {
                $return_html .= '<div id= "followdiv " class="user_btn">
                                                                                <button id="follow' . $user['business_profile_id'] . '" onClick="followuser(' . $user['business_profile_id'] . ')">
                                                                                   <span> Follow </span>
                                                                                </button></div>';
            } elseif ($status == 1) {
                $return_html .= '<div id= "unfollowdiv"  class="user_btn" > 
                                                                                <button class="bg_following" id="unfollow' . $user['business_profile_id'] . '" onClick="unfollowuser(' . $user['business_profile_id'] . ')">
                                                                                    <span>Following</span> 
                                                                                </button></div>';
            }
            $return_html .= '</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';
        }
        echo $return_html;
    }

    public function follow() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $this->business_profile_active_check();
        $this->is_business_profile_register();

//if user deactive profile then redirect to business_profile/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_deleted' => '0');

        $business_deactive = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($business_deactive) {
            redirect('business_profile/');
        }
//if user deactive profile then redirect to business_profile/index untill active profile End

        $business_id = $_POST["follow_to"];
        $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
        $artdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('business_profile_id' => $business_id, 'is_deleted' => '0', 'status' => '1', 'business_step' => '4');
        $busdatatoid = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'user_id,contact_email', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('follow_type' => '2', 'follow_from' => $artdata[0]['business_profile_id'], 'follow_to' => $business_id);
        $follow = $this->common->select_data_by_condition('follow', $contition_array, $data = 'follow_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($follow) {
            $data = array(
                'follow_type' => '2',
                'follow_from' => $artdata[0]['business_profile_id'],
                'follow_to' => $business_id,
                'follow_status' => '1',
            );
            $update = $this->common->update_data($data, 'follow', 'follow_id', $follow[0]['follow_id']);

// insert notification

            $contition_array = array('not_type' => '8', 'not_from_id' => $userid, 'not_to_id' => $busdatatoid[0]['user_id'], 'not_product_id' => $follow[0]['follow_id'], 'not_from' => '6');
            $busnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = 'not_read', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if ($busnotification[0]['not_read'] == 2) { //echo "hi"; die();
            } elseif ($busnotification[0]['not_read'] == 1) { //echo "hddi"; die();
                $datafollow = array(
                    'not_read' => '2',
                    'not_created_date' => date('Y-m-d H:i:s')
                );

                $where = array('not_type' => '8', 'not_from_id' => $userid, 'not_to_id' => $busdatatoid[0]['user_id'], 'not_product_id' => $follow[0]['follow_id'], 'not_from' => '6');
                $this->db->where($where);
                $updatdata = $this->db->update('notification', $datafollow);
            } else {

                $contition_array = array('follow_type' => '2', 'follow_from' => $artdata[0]['business_profile_id'], 'follow_status' => '1', 'follow_to' => $business_id);
                $follow_id = $this->common->select_data_by_condition('follow', $contition_array, $data = 'follow_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
// insert notification

                $data = array(
                    'not_type' => '8',
                    'not_from_id' => $userid,
                    'not_to_id' => $busdatatoid[0]['user_id'],
                    'not_read' => '2',
                    'not_product_id' => $follow_id[0]['follow_id'],
                    'not_from' => '6',
                    'not_created_date' => date('Y-m-d H:i:s'),
                    'not_active' => '1'
                );
                $insert_id = $this->common->insert_data_getid($data, 'notification');
                if ($insert_id) {
                    $email_html = '';
                    $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;"><img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $this->data['business_login_user_image'] . '" width="50" height="50" alt="'. $this->data['business_login_user_image'] .'"></td>
                                            <td style="padding:5px;">
						<p><b>' . $this->data['business_login_company_name'] . '</b> Started following you in business profile.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a class="btn" href="' . BASEURL . 'business-profile/details/' . $this->data['business_login_slug'] . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
                    $subject = $this->data['business_login_company_name'] . ' Started following you in Aileensoul.';

                    $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $busdatatoid[0]['contact_email']);
                }
            }

// end notification

            $contition_array = array('follow_type' => '2', 'follow_from' => $artdata[0]['business_profile_id'], 'follow_status' => '1');
            $followcount = $this->common->select_data_by_condition('follow', $contition_array, $data = 'follow_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if ($update) {
                $follow_html = '<div id="unfollowdiv" class="user_btn">';
                $follow_html .= '<button class= "bg_following" id="unfollow' . $business_id . '" onClick="unfollowuser(' . $business_id . ')">
                              <span>Following</span>
                      </button>';
                $follow_html .= '</div>';
                $datacount = '(' . count($followcount) . ')';

                // GET NOTIFICATION COUNT
                $to_id = $this->db->select('user_id')->get_where('business_profile', array('business_profile_id' => $business_id))->row()->user_id;
                $not_count = $this->business_notification_count($to_id);

                echo json_encode(
                        array(
                            "follow" => $follow_html,
                            "count" => $datacount,
                            "status" => 'success',
                            "notification" => array('notification_count' => $not_count, 'to_id' => $to_id),
                ));
            }
        } else {
            $data = array(
                'follow_type' => '2',
                'follow_from' => $artdata[0]['business_profile_id'],
                'follow_to' => $business_id,
                'follow_status' => '1',
            );
            $insertdata = $this->common->insert_data($data, 'follow');

            $contition_array = array('follow_type' => '2', 'follow_from' => $artdata[0]['business_profile_id'], 'follow_status' => '1', 'follow_to' => $business_id);
            $follow_id = $this->common->select_data_by_condition('follow', $contition_array, $data = 'follow_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
// insert notification

            $data = array(
                'not_type' => '8',
                'not_from_id' => $userid,
                'not_to_id' => $busdatatoid[0]['user_id'],
                'not_read' => '2',
                'not_product_id' => $follow_id[0]['follow_id'],
                'not_from' => '6',
                'not_created_date' => date('Y-m-d H:i:s'),
                'not_active' => '1'
            );

            $insert_id = $this->common->insert_data_getid($data, 'notification');
            if ($insert_id) {
                $email_html = '';
                $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;"><img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $this->data['business_login_user_image'] . '" width="50" height="50" alt="'. $this->data['business_login_user_image'] .'"></td>
                                            <td style="padding:5px;">
						<p><b>' . $this->data['business_login_company_name'] . '</b> Started following you in business profile.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a class="btn" href="' . BASEURL . 'business-profile/details/' . $this->data['business_login_slug'] . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
                $subject = $this->data['business_login_company_name'] . ' Started following you in Aileensoul.';
                $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $busdatatoid[0]['contact_email']);
            }
            $contition_array = array('follow_type' => '2', 'follow_from' => $artdata[0]['business_profile_id'], 'follow_status' => 1);
            $followcount = $this->common->select_data_by_condition('follow', $contition_array, $data = 'follow_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// end notification
            if ($insertdata) {
                $follow_html = '<div id="unfollowdiv" class="user_btn">';
                $follow_html .= '<button class="bg_following" id="unfollow' . $business_id . '" onClick="unfollowuser(' . $business_id . ')">
                               <span>Following</span>
                      </button>';
                $follow_html .= '</div>';

                $datacount = '(' . count($followcount) . ')';

                // GET NOTIFICATION COUNT
                $to_id = $this->db->select('user_id')->get_where('business_profile', array('business_profile_id' => $business_id))->row()->user_id;
                $not_count = $this->business_notification_count($to_id);

                echo json_encode(
                        array(
                            "follow" => $follow_html,
                            "count" => $datacount,
                            "status" => 'success',
                            "notification" => array('notification_count' => $not_count, 'to_id' => $to_id),
                ));
            }
        }
    }

    public function unfollow() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

//if user deactive profile then redirect to business_profile/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_deleted' => '0');
        $business_deactive = $this->data['business_deactive'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if ($business_deactive) {
            redirect('business_profile/');
        }
//if user deactive profile then redirect to business_profile/index untill active profile End

        $business_id = $_POST["follow_to"];
        $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
        $artdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $contition_array = array('follow_type' => '2', 'follow_from' => $artdata[0]['business_profile_id'], 'follow_to' => $business_id);
        $follow = $this->common->select_data_by_condition('follow', $contition_array, $data = 'follow_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if ($follow) {
            $data = array(
                'follow_type' => '2',
                'follow_from' => $artdata[0]['business_profile_id'],
                'follow_to' => $business_id,
                'follow_status' => '0',
            );
            $update = $this->common->update_data($data, 'follow', 'follow_id', $follow[0]['follow_id']);
            $contition_array = array('follow_type' => '2', 'follow_from' => $artdata[0]['business_profile_id'], 'follow_status' => '1');
            $followcount = $this->common->select_data_by_condition('follow', $contition_array, $data = 'follow_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if ($update) {
                $unfollow = '<div id="followdiv " class="user_btn">';
                $unfollow .= '<button id="follow' . $business_id . '" onClick="followuser(' . $business_id . ')">
                               <span>Follow </span>
                      </button>';
                $unfollow .= '</div>';
                $datacount = '(' . count($followcount) . ')';
                echo json_encode(
                        array(
                            "follow" => $unfollow,
                            "count" => $datacount,
                ));
            }
        }
    }

    public function business_home_follow_ignore() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        $business_profile_id = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->business_profile_id;
        $follow_to = $_POST['follow_to'];

        $insert_data['profile'] = '2';
        $insert_data['user_from'] = $business_profile_id;
        $insert_data['user_to'] = $follow_to;

        $insert_id = $this->common->insert_data_getid($insert_data, 'user_ignore');

        if ($insert_id) {

            // GET USER BUSINESS DATA START
            $contition_array = array('user_id' => $userid, 'status' => '1');
            $businessdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id, industriyal, city, state, other_industrial,business_type', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $business_profile_id = $businessdata[0]['business_profile_id'];
            $industriyal = $businessdata[0]['industriyal'];
            $city = $businessdata[0]['city'];
            $state = $businessdata[0]['state'];
            $other_industrial = $businessdata[0]['other_industrial'];
            $business_type = $businessdata[0]['business_type'];
            // GET USER BUSINESS DATA END
            // GET BUSINESS USER FOLLOWING LIST START
            $contition_array = array('follow_from' => $business_profile_id, 'follow_status' => '1', 'follow_type' => '2');
            $followdata = $this->common->select_data_by_condition('follow', $contition_array, $data = 'GROUP_CONCAT(follow_to) as follow_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = 'follow_from');
            $follow_list = $followdata[0]['follow_list'];
            $follow_list = str_replace(",", "','", $followdata[0]['follow_list']);
            // GET BUSINESS USER FOLLOWING LIST END
            // GET BUSINESS USER IGNORE LIST START
            $contition_array = array('user_from' => $business_profile_id, 'profile' => '2');
            $userdata = $this->common->select_data_by_condition('user_ignore', $contition_array, $data = 'GROUP_CONCAT(user_to) as user_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = 'user_from');
            $user_list = $followdata[0]['user_list'];
            $user_list = str_replace(",", "','", $userdata[0]['user_list']);
            // GET BUSINESS USER IGNORE LIST END
            //GET BUSINESS USER SUGGESTED USER LIST 
            $contition_array = array('is_deleted' => '0', 'status' => '1', 'user_id != ' => $userid, 'business_step' => '4');
            $search_condition = "business_profile_id NOT IN ('$follow_list') AND business_profile_id NOT IN ('$user_list')";

            //$userlistview = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'business_profile_id, company_name, business_slug, business_user_image, industriyal, city, state, other_industrial, business_type', $sortby = 'CASE WHEN (industriyal = ' . $industriyal . ') THEN business_profile_id END, CASE WHEN (city = ' . $city . ') THEN business_profile_id END, CASE WHEN (state = ' . $state . ') THEN business_profile_id END', $orderby = 'DESC', $limit = '', $offset = '', $join_str_contact = array(), $groupby = '');
            $userlistview = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'business_profile_id, company_name, business_slug, business_user_image, industriyal, city, state, other_industrial, business_type', $sortby = 'CASE WHEN (industriyal = ' . $industriyal . ') THEN business_profile_id END, CASE WHEN (state = ' . $state . ') THEN business_profile_id END', $orderby = 'DESC', $limit = '', $offset = '', $join_str_contact = array(), $groupby = '');

            $userlist = $userlistview[2];

            $third_user_html = '';
            if (count($userlistview) > 0) {
                //foreach ($userlistview as $userlist) {
                $userid = $this->session->userdata('aileenuser');
                $followfrom = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->business_profile_id;
                $contition_array = array('follow_to' => $userlist['business_profile_id'], 'follow_from' => $followfrom, 'follow_status' => '1', 'follow_type' => '2');
                $businessfollow = $this->data['businessfollow'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '1', $offset = '', $join_str = array(), $groupby = '');
                $category = $this->db->get_where('industry_type', array('industry_id' => $userlist['industriyal'], 'status' => '1'))->row()->industry_name;
                if (!$businessfollow) {

                    $third_user_html .= '<li class = "follow_box_ul_li fad' . $userlist['business_profile_id'] . '" id = "fad' . $userlist['business_profile_id'] . '">
      <div class = "contact-frnd-post follow_left_main_box"><div class = "profile-job-post-title-inside clearfix">
      <div class = " col-md-12 follow_left_box_main">
      <div class = "post-design-pro-img_follow">';
                    if ($userlist['business_user_image']) {
                        $third_user_html .= '<a href = "' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '" title = "' . ucfirst(strtolower($userlist['company_name'])) . '">';
                        if (IMAGEPATHFROM == 'upload') {
                            if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $userlist['business_user_image'])) {
                                $third_user_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                            } else {
                                $third_user_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $userlist['business_user_image'] . '" alt = "'. $userlist['business_user_image'] .'">';
                            }
                        } else {
                            $filename = $this->config->item('bus_profile_thumb_upload_path') . $userlist['business_user_image'];
                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                            if (!$info) {
                                $third_user_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                            } else {
                                $third_user_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $userlist['business_user_image'] . '" alt = "'. $userlist['business_user_image'] .'">';
                            }
                        }
                        $third_user_html .= '</a>';
                    } else {
                        $third_user_html .= '<a href = "' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '" title = "' . ucfirst($userlist['company_name']) . '">';
                        $third_user_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE"></a>';
                    }
                    $third_user_html .= '</div>
      <div class = "post-design-name_follow fl">
      <ul><li><div class = "post-design-product_follow">';
                    $third_user_html .= '<a href = "' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '" title = "' . ucfirst($userlist['company_name']) . '">
      <h6>' . ucfirst($userlist['company_name']) . '</h6>
      </a></div></li>';
                    $category = $this->db->get_where('industry_type', array('industry_id' => $userlist['industriyal'], 'status' => '1'))->row()->industry_name;
                    $third_user_html .= '<li>
      <div class = "post-design-product_follow_main" style = "display:block;">
      <a href = "' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '" title = "' . ucfirst($userlist['company_name']) . '">
      <p>';
                    if ($category) {
                        $third_user_html .= $category;
                    } else {
                        $third_user_html .= $userlist['other_industrial'];
                    }
                    $third_user_html .= '</p>
      </a></div></li></ul></div>
      <div class = "follow_left_box_main_btn">';
                    $third_user_html .= '<div class = "fr' . $userlist['business_profile_id'] . '">
      <button id = "followdiv' . $userlist['business_profile_id'] . '" onClick = "followuser(' . $userlist['business_profile_id'] . ')"><span>Follow</span>
      </button></div></div><span class = "Follow_close" id="Follow_close' . $userlist['business_profile_id'] . '" onClick = "followclose(' . $userlist['business_profile_id'] . ')">
      <i class = "fa fa-times" aria-hidden = "true"></i></span></div>
      </div></div></li>';
                }
            }
            // }

            echo $third_user_html;
        }
    }

    public function home_three_follow() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $this->business_profile_active_check();

        $business_id = $_POST["follow_to"];
        $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
        $artdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('business_profile_id' => $business_id, 'is_deleted' => '0', 'status' => '1', 'business_step' => '4');
        $busdatatoid = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'contact_email,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('follow_type' => '2', 'follow_from' => $artdata[0]['business_profile_id'], 'follow_to' => $business_id);
        $follow = $this->common->select_data_by_condition('follow', $contition_array, $data = 'follow_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $is_follow = 0;
        if ($follow) {
            $data = array(
                'follow_type' => '2',
                'follow_from' => $artdata[0]['business_profile_id'],
                'follow_to' => $business_id,
                'follow_status' => '1',
            );
            $update = $this->common->update_data($data, 'follow', 'follow_id', $follow[0]['follow_id']);

            // insert notification

            $contition_array = array('not_type' => '8', 'not_from_id' => $userid, 'not_to_id' => $busdatatoid[0]['user_id'], 'not_product_id' => $follow[0]['follow_id'], 'not_from' => '6');
            $busnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = 'not_read', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if ($busnotification[0]['not_read'] == 2) {
                
            } elseif ($busnotification[0]['not_read'] == 1) {
                $datafollow = array(
                    'not_read' => '2'
                );

                $where = array('not_type' => '8', 'not_from_id' => $userid, 'not_to_id' => $busdatatoid[0]['user_id'], 'not_product_id' => $follow[0]['follow_id'], 'not_from' => '6');
                $this->db->where($where);
                $updatdata = $this->db->update('notification', $datafollow);
            } else {
                $data = array(
                    'not_type' => '8',
                    'not_from_id' => $userid,
                    'not_to_id' => $busdatatoid[0]['user_id'],
                    'not_read' => '2',
                    'not_product_id' => $follow[0]['follow_id'],
                    'not_from' => '6',
                    'not_created_date' => date('Y-m-d H:i:s'),
                    'not_active' => '1'
                );

                $insert_id = $this->common->insert_data_getid($data, 'notification');
                if ($insert_id) {
                    $email_html = '';
                    $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;"><img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $this->data['business_login_user_image'] . '" width="50" height="50" alt="'. $this->data['business_login_user_image'] .'"></td>
                                            <td style="padding:5px;">
						<p><b>' . $this->data['business_login_company_name'] . '</b> Started following you in business profile.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a class="btn" href="' . BASEURL . 'business-profile/details/' . $this->data['business_login_slug'] . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';

                    $subject = $this->data['business_login_company_name'] . ' Started following you in Aileensoul.';
                    $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $busdatatoid[0]['contact_email']);
                }
            }
            // end notification

            if ($update) {

                $follow = '<div class="user_btn follow_btn_' . $business_id . '" id="unfollowdiv">';
                $follow .= '<button class="bg_following" id="unfollow' . $business_id . '" onClick="unfollowuser_two(' . $business_id . ')">
                              <span>Following</span>
                      </button>';
                $follow .= '</div>';
//                echo $follow;
                $is_follow = 1;
            }
        } else {
            $data = array(
                'follow_type' => '2',
                'follow_from' => $artdata[0]['business_profile_id'],
                'follow_to' => $business_id,
                'follow_status' => '1',
            );
            $insert = $this->common->insert_data($data, 'follow');

            // insert notification
            $contition_array = array('follow_type' => '2', 'follow_from' => $artdata[0]['business_profile_id'], 'follow_status' => '1', 'follow_to' => $business_id);
            $follow_id = $this->common->select_data_by_condition('follow', $contition_array, $data = 'follow_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $datanoti = array(
                'not_type' => '8',
                'not_from_id' => $userid,
                'not_to_id' => $busdatatoid[0]['user_id'],
                'not_read' => '2',
                'not_product_id' => $follow_id[0]['follow_id'],
                'not_from' => '6',
                'not_created_date' => date('Y-m-d H:i:s'),
                'not_active' => '1'
            );

            $insert_id = $this->common->insert_data_getid($datanoti, 'notification');
            if ($insert_id) {
                $email_html = '';
                $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;"><img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $this->data['business_login_user_image'] . '" width="50" height="50" alt="'. $this->data['business_login_user_image'] . '"></td>
                                            <td style="padding:5px;">
						<p><b>' . $this->data['business_login_company_name'] . '</b> Started following you in business profile.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a class="btn" href="' . BASEURL . 'business-profile/details/' . $this->data['business_login_slug'] . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
                $subject = $this->data['business_login_company_name'] . ' Started following you in Aileensoul.';

                $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $busdatatoid[0]['contact_email']);
            }

            // end notification
            if ($insert) {
                $follow = '<div class="user_btn follow_btn_' . $business_id . '" id="unfollowdiv">';
                $follow .= '<button class="bg_following" id="unfollow' . $business_id . '" onClick="unfollowuser_two(' . $business_id . ')"><span>Following</span></button>';
                $follow .= '</div>';
                $is_follow = 1;
            }
        }
        if ($is_follow == 1) {
            $third_user_html = $this->third_follow_user_data();
            $following_count = $this->business_user_following_count();

            // GET NOTIFICATION COUNT
            $to_id = $this->db->select('user_id')->get_where('business_profile', array('business_profile_id' => $business_id))->row()->user_id;
            $not_count = $this->business_notification_count($to_id);

            echo json_encode(
                    array(
                        'follow' => $follow,
                        'third_user' => $third_user_html,
                        'following_count' => $following_count,
                        'status' => 'success',
                        'notification' => array('notification_count' => $not_count, 'to_id' => $to_id),
            ));
        }
    }

    public function third_follow_user_data() {
        $s3 = new S3(awsAccessKey, awsSecretKey);

        $userid = $this->session->userdata('aileenuser');

        // GET USER BUSINESS DATA START
        $contition_array = array('user_id' => $userid, 'status' => '1');
        $businessdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id, industriyal, city, state, other_industrial,business_type', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $business_profile_id = $businessdata[0]['business_profile_id'];
        $industriyal = $businessdata[0]['industriyal'];
        $city = $businessdata[0]['city'];
        $state = $businessdata[0]['state'];
        $other_industrial = $businessdata[0]['other_industrial'];
        $business_type = $businessdata[0]['business_type'];
        // GET USER BUSINESS DATA END
        // GET BUSINESS USER FOLLOWING LIST START
        $contition_array = array('follow_from' => $business_profile_id, 'follow_status' => '1', 'follow_type' => '2');
        $followdata = $this->common->select_data_by_condition('follow', $contition_array, $data = 'GROUP_CONCAT(follow_to) as follow_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = 'follow_from');
        $follow_list = $followdata[0]['follow_list'];
        $follow_list = str_replace(",", "','", $followdata[0]['follow_list']);
        // GET BUSINESS USER FOLLOWING LIST END
        // GET BUSINESS USER IGNORE LIST START
        $contition_array = array('user_from' => $business_profile_id, 'profile' => '2');
        $userdata = $this->common->select_data_by_condition('user_ignore', $contition_array, $data = 'GROUP_CONCAT(user_to) as user_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = 'user_from');
        $user_list = $followdata[0]['user_list'];
        $user_list = str_replace(",", "','", $userdata[0]['user_list']);
        // GET BUSINESS USER IGNORE LIST END
        //GET BUSINESS USER SUGGESTED USER LIST 
        $contition_array = array('is_deleted' => '0', 'status' => '1', 'user_id != ' => $userid, 'business_step' => '4');
        $search_condition = "business_profile_id NOT IN ('$follow_list') AND business_profile_id NOT IN ('$user_list')";

        //$userlistview = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'business_profile_id, company_name, business_slug, business_user_image, industriyal, city, state, other_industrial, business_type', $sortby = 'CASE WHEN (industriyal = ' . $industriyal . ') THEN business_profile_id END, CASE WHEN (city = ' . $city . ') THEN business_profile_id END, CASE WHEN (state = ' . $state . ') THEN business_profile_id END', $orderby = 'DESC', $limit = '1', $offset = '2', $join_str_contact = array(), $groupby = '');
        $userlistview = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'business_profile_id, company_name, business_slug, business_user_image, industriyal, city, state, other_industrial, business_type', $sortby = 'CASE WHEN (industriyal = ' . $industriyal . ') THEN business_profile_id END, CASE WHEN (state = ' . $state . ') THEN business_profile_id END', $orderby = 'DESC', $limit = '1', $offset = '2', $join_str_contact = array(), $groupby = '');


        $third_user_html = '';
        if (count($userlistview) > 0) {
            foreach ($userlistview as $userlist) {
                $userid = $this->session->userdata('aileenuser');
                $followfrom = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->business_profile_id;
                $contition_array = array('follow_to' => $userlist['business_profile_id'], 'follow_from' => $followfrom, 'follow_status' => '1', 'follow_type' => '2');
                $businessfollow = $this->data['businessfollow'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '1', $offset = '', $join_str = array(), $groupby = '');
                $category = $this->db->get_where('industry_type', array('industry_id' => $userlist['industriyal'], 'status' => '1'))->row()->industry_name;
                if (!$businessfollow) {

                    $third_user_html .= '<li class = "follow_box_ul_li fad' . $userlist['business_profile_id'] . '" id = "fad' . $userlist['business_profile_id'] . '">
      <div class = "contact-frnd-post follow_left_main_box"><div class = "profile-job-post-title-inside clearfix">
      <div class = " col-md-12 follow_left_box_main">
      <div class = "post-design-pro-img_follow">';
                    if ($userlist['business_user_image']) {
                        $third_user_html .= '<a href = "' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '" title = "' . ucfirst(strtolower($userlist['company_name'])) . '">';
                        if (IMAGEPATHFROM == 'upload') {
                            if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $userlist['business_user_image'])) {
                                $third_user_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                            } else {
                                $third_user_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $userlist['business_user_image'] . '" alt = "'. $userlist['business_user_image'] .'">';
                            }
                        } else {
                            $filename = $this->config->item('bus_profile_thumb_upload_path') . $userlist['business_user_image'];
                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                            if (!$info) {
                                $third_user_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                            } else {
                                $third_user_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $userlist['business_user_image'] . '" alt = "'. $userlist['business_user_image'] .'">';
                            }
                        }
                        $third_user_html .= '</a>';
                    } else {
                        $third_user_html .= '<a href = "' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '" title = "' . ucfirst(strtolower($userlist['company_name'])) . '">';
                        $third_user_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE"></a>';
                    }
                    $third_user_html .= '</div>
      <div class = "post-design-name_follow fl">
      <ul><li><div class = "post-design-product_follow">';
                    $third_user_html .= '<a href = "' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '" title = "' . ucfirst(strtolower($userlist['company_name'])) . '">
      <h6>' . ucfirst(strtolower($userlist['company_name'])) . '</h6>
      </a></div></li>';
                    $category = $this->db->get_where('industry_type', array('industry_id' => $userlist['industriyal'], 'status' => '1'))->row()->industry_name;
                    $third_user_html .= '<li>
      <div class = "post-design-product_follow_main" style = "display:block;">
      <a href = "' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '" title = "' . ucfirst(strtolower($userlist['company_name'])) . '">
      <p>';
                    if ($category) {
                        $third_user_html .= $category;
                    } else {
                        $third_user_html .= $userlist['other_industrial'];
                    }
                    $third_user_html .= '</p>
      </a></div></li></ul></div>
      <div class = "follow_left_box_main_btn">';
                    $third_user_html .= '<div class = "fr' . $userlist['business_profile_id'] . '">
      <button id = "followdiv' . $userlist['business_profile_id'] . '" onClick = "followuser(' . $userlist['business_profile_id'] . ')"><span>Follow</span>
      </button></div></div><span class = "Follow_close" id="Follow_close' . $userlist['business_profile_id'] . '" onClick = "followclose(' . $userlist['business_profile_id'] . ')">
      <i class = "fa fa-times" aria-hidden = "true"></i></span></div>
      </div></div></li>';
                }
            }
        }

        return $third_user_html;
    }

    public function third_follow_ignore_user_data() {
        $s3 = new S3(awsAccessKey, awsSecretKey);

        $userid = $this->session->userdata('aileenuser');

        // GET USER BUSINESS DATA START
        $contition_array = array('user_id' => $userid, 'status' => '1');
        $businessdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id, industriyal, city, state, other_industrial,business_type', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $business_profile_id = $businessdata[0]['business_profile_id'];
        $industriyal = $businessdata[0]['industriyal'];
        $city = $businessdata[0]['city'];
        $state = $businessdata[0]['state'];
        $other_industrial = $businessdata[0]['other_industrial'];
        $business_type = $businessdata[0]['business_type'];
        // GET USER BUSINESS DATA END
        // GET BUSINESS USER FOLLOWING LIST START
        $contition_array = array('follow_from' => $business_profile_id, 'follow_status' => '1', 'follow_type' => '2');
        $followdata = $this->common->select_data_by_condition('follow', $contition_array, $data = 'GROUP_CONCAT(follow_to) as follow_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = 'follow_from');
        $follow_list = $followdata[0]['follow_list'];
        $follow_list = str_replace(",", "','", $followdata[0]['follow_list']);
        // GET BUSINESS USER FOLLOWING LIST END
        // GET BUSINESS USER IGNORE LIST START
        $contition_array = array('user_from' => $business_profile_id, 'profile' => '2');
        $userdata = $this->common->select_data_by_condition('user_ignore', $contition_array, $data = 'GROUP_CONCAT(user_to) as user_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = 'user_from');
        $user_list = $followdata[0]['user_list'];
        $user_list = str_replace(",", "','", $userdata[0]['user_list']);
        // GET BUSINESS USER IGNORE LIST END
        //GET BUSINESS USER SUGGESTED USER LIST 
        $contition_array = array('is_deleted' => '0', 'status' => '1', 'user_id != ' => $userid, 'business_step' => '4');
        $search_condition = "business_profile_id NOT IN ('$follow_list') AND business_profile_id NOT IN ('$user_list')";

        $userlistview = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'business_profile_id, company_name, business_slug, business_user_image, industriyal, city, state, other_industrial, business_type', $sortby = 'CASE WHEN (industriyal = ' . $industriyal . ') THEN business_profile_id END, CASE WHEN (city = ' . $city . ') THEN business_profile_id END, CASE WHEN (state = ' . $state . ') THEN business_profile_id END', $orderby = 'DESC', $limit = '1', $offset = '3', $join_str_contact = array(), $groupby = '');

        $third_user_html = '';
        if (count($userlistview) > 0) {
            foreach ($userlistview as $userlist) {
                $userid = $this->session->userdata('aileenuser');
                $followfrom = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->business_profile_id;
                $contition_array = array('follow_to' => $userlist['business_profile_id'], 'follow_from' => $followfrom, 'follow_status' => '1', 'follow_type' => '2');
                $businessfollow = $this->data['businessfollow'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '1', $offset = '', $join_str = array(), $groupby = '');
                $category = $this->db->get_where('industry_type', array('industry_id' => $userlist['industriyal'], 'status' => '1'))->row()->industry_name;
                if (!$businessfollow) {

                    $third_user_html .= '<li class = "follow_box_ul_li fad' . $userlist['business_profile_id'] . '" id = "fad' . $userlist['business_profile_id'] . '">
      <div class = "contact-frnd-post follow_left_main_box"><div class = "profile-job-post-title-inside clearfix">
      <div class = " col-md-12 follow_left_box_main">
      <div class = "post-design-pro-img_follow">';
                    if ($userlist['business_user_image']) {
                        $third_user_html .= '<a href = "' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '" title = "' . ucfirst(strtolower($userlist['company_name'])) . '">';
                        if (IMAGEPATHFROM == 'upload') {
                            if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $userlist['business_user_image'])) {
                                $third_user_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                            } else {
                                $third_user_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $userlist['business_user_image'] . '" alt = "'. $userlist['business_user_image'] .'">';
                            }
                        } else {
                            $filename = $this->config->item('bus_profile_thumb_upload_path') . $userlist['business_user_image'];
                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                            if (!$info) {
                                $third_user_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                            } else {
                                $third_user_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $userlist['business_user_image'] . '" alt = "'. $userlist['business_user_image'] . '">';
                            }
                        }
                        $third_user_html .= '</a>';
                    } else {
                        $third_user_html .= '<a href = "' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '" title = "' . ucfirst($userlist['company_name']) . '">';
                        $third_user_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE"></a>';
                    }
                    $third_user_html .= '</div>
      <div class = "post-design-name_follow fl">
      <ul><li><div class = "post-design-product_follow">';
                    $third_user_html .= '<a href = "' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '" title = "' . ucfirst($userlist['company_name']) . '">
      <h6>' . ucfirst($userlist['company_name']) . '</h6>
      </a></div></li>';
                    $category = $this->db->get_where('industry_type', array('industry_id' => $userlist['industriyal'], 'status' => '1'))->row()->industry_name;
                    $third_user_html .= '<li>
      <div class = "post-design-product_follow_main" style = "display:block;">
      <a href = "' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '" title = "' . ucfirst($userlist['company_name']) . '">
      <p>';
                    if ($category) {
                        $third_user_html .= $category;
                    } else {
                        $third_user_html .= $userlist['other_industrial'];
                    }
                    $third_user_html .= '</p>
      </a></div></li></ul></div>
      <div class = "follow_left_box_main_btn">';
                    $third_user_html .= '<div class = "fr' . $userlist['business_profile_id'] . '">
      <button id = "followdiv' . $userlist['business_profile_id'] . '" onClick = "followuser(' . $userlist['business_profile_id'] . ')"><span>Follow</span>
      </button></div></div><span class = "Follow_close" id="Follow_close' . $userlist['business_profile_id'] . '" onClick = "followclose(' . $userlist['business_profile_id'] . ')">
      <i class = "fa fa-times" aria-hidden = "true"></i></span></div>
      </div></div></li>';
                }
            }
        }

        echo $third_user_html;
    }

    public function follow_two() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        //if user deactive profile then redirect to business_profile/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_deleted' => '0');
        $business_deactive = $this->data['business_deactive'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if ($business_deactive) {
            redirect('business_profile/');
        }
        //if user deactive profile then redirect to business_profile/index untill active profile End

        $not_bus_profile_id = $business_id = $_POST["follow_to"];

        $is_listing = $_POST["is_listing"];

        $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
        $artdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('business_profile_id' => $business_id, 'is_deleted' => '0', 'status' => '1', 'business_step' => '4');
        $busdatatoid = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('follow_type' => '2', 'follow_from' => $artdata[0]['business_profile_id'], 'follow_to' => $business_id);
        $follow = $this->common->select_data_by_condition('follow', $contition_array, $data = 'follow_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        if ($follow) {
            $data = array(
                'follow_type' => '2',
                'follow_from' => $artdata[0]['business_profile_id'],
                'follow_to' => $business_id,
                'follow_status' => '1',
            );
            $update = $this->common->update_data($data, 'follow', 'follow_id', $follow[0]['follow_id']);

            // insert notification


            $contition_array = array('not_type' => '8', 'not_from_id' => $userid, 'not_to_id' => $busdatatoid[0]['user_id'], 'not_product_id' => $follow[0]['follow_id'], 'not_from' => '6');
            $busnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = 'not_read', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            //echo "<pre>"; print_r($busnotification); die();
            if ($busnotification[0]['not_read'] == 2) { //echo "hi"; die();
            } elseif ($busnotification[0]['not_read'] == 1) { //echo "hddi"; die();
                $datafollow = array(
                    'not_read' => '2'
                );

                $where = array('not_type' => '8', 'not_from_id' => $userid, 'not_to_id' => $busdatatoid[0]['user_id'], 'not_product_id' => $follow[0]['follow_id'], 'not_from' => '6');
                $this->db->where($where);
                $updatdata = $this->db->update('notification', $datafollow);
            } else {
                $data = array(
                    'not_type' => '8',
                    'not_from_id' => $userid,
                    'not_to_id' => $busdatatoid[0]['user_id'],
                    'not_read' => '2',
                    'not_product_id' => $follow[0]['follow_id'],
                    'not_from' => '6',
                    'not_created_date' => date('Y-m-d H:i:s'),
                    'not_active' => '1'
                );

                $insert_id = $this->common->insert_data_getid($data, 'notification');
                if ($insert_id) {
                    $email_html = '';
                    $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;"><img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $this->data['business_login_user_image'] . '" width="50" height="50" alt="'. $this->data['business_login_user_image']. '"></td>
                                            <td style="padding:5px;">
						<p><b>' . $this->data['business_login_company_name'] . '</b> Started following you in business profile.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a class="btn" href="' . BASEURL . 'business-profile/details/' . $this->data['business_login_slug'] . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
                    $subject = $this->data['business_login_company_name'] . ' Started following you in Aileensoul.';

                    $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $busdatatoid[0]['contact_email']);
                }
            }
            // end notification
            $follow_html = '';
            if ($update) {
                $follow_html .= '<div class="user_btn follow_btn_' . $business_id . '" id="unfollowdiv">';
                if ($is_listing == 1) {
                    $follow_html .= '<button class="bg_following" id="unfollow' . $business_id . '" onClick="unfollowuser_list_two(' . $business_id . ')">
                              <span>Following</span>
                      </button>';
                } else {
                    $follow_html .= '<button class="bg_following" id="unfollow' . $business_id . '" onClick="unfollowuser_two(' . $business_id . ')">
                              <span>Following</span>
                      </button>';
                }
                $follow_html .= '</div>';
                //echo $follow;
            }
        } else {
            $data = array(
                'follow_type' => '2',
                'follow_from' => $artdata[0]['business_profile_id'],
                'follow_to' => $business_id,
                'follow_status' => '1',
            );
            $insert = $this->common->insert_data($data, 'follow');

            // insert notification
            $contition_array = array('follow_type' => '2', 'follow_from' => $artdata[0]['business_profile_id'], 'follow_status' => 1, 'follow_to' => $business_id);
            $follow_id = $this->common->select_data_by_condition('follow', $contition_array, $data = 'follow_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $datanoti = array(
                'not_type' => '8',
                'not_from_id' => $userid,
                'not_to_id' => $busdatatoid[0]['user_id'],
                'not_read' => '2',
                'not_product_id' => $follow_id[0]['follow_id'],
                'not_from' => '6',
                'not_created_date' => date('Y-m-d H:i:s'),
                'not_active' => '1'
            );

            $insert_id = $this->common->insert_data_getid($datanoti, 'notification');
            if ($insert_id) {
                $email_html = '';
                $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;"><img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $this->data['business_login_user_image'] . '" width="50" height="50" alt="'. $this->data['business_login_user_image'] .'"></td>
                                            <td style="padding:5px;">
						<p><b>' . $this->data['business_login_company_name'] . '</b> Started following you in business profile.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a class="btn" href="' . BASEURL . 'business-profile/details/' . $this->data['business_login_slug'] . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
                $subject = $this->data['business_login_company_name'] . ' Started following you in Aileensoul.';

                $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $busdatatoid[0]['contact_email']);
            }
            // end notification
            $follow_html = '';
            if ($insert) {
                $follow_html .= '<div class="user_btn follow_btn_' . $business_id . '" id="unfollowdiv">';
                if ($is_listing == '1') {
                    $follow_html .= '<button class="bg_following" id="unfollow' . $business_id . '" onClick="unfollowuser_list_two(' . $business_id . ')"><span>Following</span></button>';
                } else {
                    $follow_html .= '<button class="bg_following" id="unfollow' . $business_id . '" onClick="unfollowuser_two(' . $business_id . ')"><span>Following</span></button>';
                }

                $follow .= '</div>';
                //echo $follow;
            }
        }
        $profile_slug = $_POST["profile_slug"];
        if ($profile_slug) {
            $business_id = $this->db->select('business_profile_id')->get_where('business_profile', array('business_slug' => $profile_slug))->row()->business_profile_id;
        }

        // GET NOTIFICATION COUNT
        $to_id = $this->db->select('user_id')->get_where('business_profile', array('business_profile_id' => $not_bus_profile_id))->row()->user_id;
        $not_count = $this->business_notification_count($to_id);


        echo json_encode(
                array("follow_html" => $follow_html,
                    "following_count" => $this->business_user_following_count($business_id),
                    "follower_count" => $this->business_user_follower_count($business_id),
                    "contacts_count" => $this->business_user_contacts_count(),
                    "status" => 'success',
                    "notification" => array('notification_count' => $not_count, 'to_id' => $to_id),
        ));
    }

    public function unfollow_two() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
//if user deactive profile then redirect to business_profile/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_deleted' => '0');
        $business_deactive = $this->data['business_deactive'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($business_deactive) {
            redirect('business_profile/');
        }
//if user deactive profile then redirect to business_profile/index untill active profile End

        $business_id = $_POST["follow_to"];
        $is_listing = $_POST["is_listing"];

        $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
        $artdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('follow_type' => '2', 'follow_from' => $artdata[0]['business_profile_id'], 'follow_to' => $business_id);
        $follow = $this->common->select_data_by_condition('follow', $contition_array, $data = 'follow_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($follow) {
            $data = array(
                'follow_type' => '2',
                'follow_from' => $artdata[0]['business_profile_id'],
                'follow_to' => $business_id,
                'follow_status' => '0',
            );
            $update = $this->common->update_data($data, 'follow', 'follow_id', $follow[0]['follow_id']);
            $unfollow = '';
            if ($update) {

                $unfollow .= '<div class="user_btn follow_btn_' . $business_id . '" id="followdiv">';
                if ($is_listing == 1) {
                    $unfollow .= '<button class="follow' . $business_id . '" onClick="followuser_list_two(' . $business_id . ')"><span>Follow</span></button>';
                } else {
                    $unfollow .= '<button class="follow' . $business_id . '" onClick="followuser_two(' . $business_id . ')"><span>Follow</span></button>';
                }
                $unfollow .= '</div>';
                //echo $unfollow;
            }
            $profile_slug = $_POST["profile_slug"];
            if ($profile_slug) {
                $business_id = $this->db->select('business_profile_id')->get_where('business_profile', array('business_slug' => $profile_slug))->row()->business_profile_id;
            }
            echo json_encode(
                    array("unfollow_html" => $unfollow,
                        "unfollowing_count" => $this->business_user_following_count($business_id),
                        "unfollower_count" => $this->business_user_follower_count($business_id),
                        "uncontacts_count" => $this->business_user_contacts_count(),
            ));
        }
    }

    public function unfollow_following() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $business_id = $_POST["follow_to"];
        $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
        $artdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('follow_type' => '2', 'follow_from' => $artdata[0]['business_profile_id'], 'follow_to' => $business_id);
        $follow = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($follow) {
            $data = array(
                'follow_type' => '2',
                'follow_from' => $artdata[0]['business_profile_id'],
                'follow_to' => $business_id,
                'follow_status' => '0',
            );
            $update = $this->common->update_data($data, 'follow', 'follow_id', $follow[0]['follow_id']);
            if ($update) {

                $contition_array = array('follow_from' => $artdata[0]['business_profile_id'], 'follow_status' => '1', 'follow_type' => '2');
                $followingotherdata = $this->data['followingotherdata'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $followingdatacount = count($followingotherdata);

                $unfollow = '<div>(';
                $unfollow .= '' . $followingdatacount . '';
                $unfollow .= ')</div>';

                if (count($followingotherdata) == 0) {
                    $notfound = ' <div class="art-img-nn">
                                    <div class="art_no_post_img">

                                        <img src="' . base_url('assets/img/icon_no_following.png') . '" alt="icon_no_following.png">

                                    </div>
                                    <div class="art_no_post_text">
                                        No Following Available.
                                    </div>
                                </div>';
                }
                echo json_encode(
                        array("unfollow" => $unfollow,
                            "notfound" => $notfound,
                            "notcount" => $followingdatacount,
                ));
            }
        }
    }

    public function followers($id = "") {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $this->data['slug_id'] = $id;

        $this->business_profile_active_check();
        $this->is_business_profile_register();

        $company_name = $this->get_company_name($id);
        $this->data['title'] = ucwords($company_name) . ' | Followers' . ' | Business Profile' . TITLEPOSTFIX;
        if ($company_name == '') {
            $this->load->view('business_profile/notavalible');
        } else {
            $this->load->view('business_profile/business_followers', $this->data);
        }
    }

    public function ajax_followers($id = "") {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;

        $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
        $artdata = $artisticdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $slugid = $artdata[0]['business_slug'];

        if ($id == $slug_id || $id == '') {
            $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
            $businessdata1 = $businessdata1 = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $join_str[0]['table'] = 'follow';
            $join_str[0]['join_table_id'] = 'follow.follow_from';
            $join_str[0]['from_table_id'] = 'business_profile.business_profile_id';
            $join_str[0]['join_type'] = '';

            $limit = $perpage;
            $offset = $start;

            $contition_array = array('follow_to' => $businessdata1[0]['business_profile_id'], 'follow_status' => '1', 'follow_type' => '2', 'business_profile.business_step' => '4', 'business_profile.status' => '1');
            $userlist = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit, $offset, $join_str, $groupby = '');
            $userlist1 = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        } else {
            $contition_array = array('business_slug' => $id, 'is_deleted' => '0', 'status' => '1', 'business_step' => '4');
            $businessdata1 = $businessdata1 = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $join_str[0]['table'] = 'follow';
            $join_str[0]['join_table_id'] = 'follow.follow_from';
            $join_str[0]['from_table_id'] = 'business_profile.business_profile_id';
            $join_str[0]['join_type'] = '';

            $limit = $perpage;
            $offset = $start;

            $contition_array = array('follow_to' => $businessdata1[0]['business_profile_id'], 'follow_status' => '1', 'follow_type' => '2', 'business_profile.business_step' => '4', 'business_profile.status' => '1');
            $userlist = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit, $offset, $join_str, $groupby = '');
            $userlist1 = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        }

        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($userlist1);
        }
        $return_html = '';
        $return_html .= '<input type="hidden" class="page_number" value="' . $page . '" />';
        $return_html .= '<input type="hidden" class="total_record" value="' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';

        if (count($userlist1) > 0) {
            foreach ($userlist as $user) {

                $return_html .= '<div class="job-contact-frnd ">
                                                    <div class="profile-job-post-detail clearfix">
                                                        <div class="profile-job-post-title-inside clearfix">
                                                            <div class="profile-job-post-location-name">
                                                                <div class="user_lst">
                                                                    <ul>
                                                                        <li class="fl">
                                                                            <div class="follow-img">';
                $followerimage = $this->db->get_where('business_profile', array('business_profile_id' => $user['follow_from']))->row()->business_user_image;
                $followername = $this->db->get_where('business_profile', array('business_profile_id' => $user['follow_from']))->row()->company_name;
                $followerslug = $this->db->get_where('business_profile', array('business_profile_id' => $user['follow_from']))->row()->business_slug;

                if ($followerimage != '') {
                    $return_html .= '<a href="' . base_url('business-profile/dashboard/' . $followerslug) . '">';
                    if (IMAGEPATHFROM == 'upload') {
                        if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $followerimage)) {
                            $return_html .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                        } else {
                            $return_html .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $followerimage . '" height="50px" width="50px" alt="'. $followerimage .'" >';
                        }
                    } else {
                        $filename = $this->config->item('bus_profile_thumb_upload_path') . $followerimage;
                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                        if (!$info) {
                            $return_html .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                        } else {
                            $return_html .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $followerimage . '" height="50px" width="50px" alt="'. $followerimage .'" >';
                        }
                    }

                    $return_html .= '</a>';
                } else {
                    $return_html .= '<a href="' . base_url('business-profile/dashboard/' . $followerslug) . '">
                                <img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">
                                                                                    </a>';
                }
                $return_html .= '</div>
                                                                        </li>
                                                                        <li class="folle_text">
                                                                            <div class="">
                                                                                <div class="follow-li-text " style="padding: 0;">
                                                                                    <a href="' . base_url('business-profile/dashboard/' . $followerslug) . '">' . ucfirst(strtolower($followername)) . '</a></div>
                                                                                <div>';
                $categoryid = $this->db->get_where('business_profile', array('business_profile_id' => $user['follow_from'], 'status' => '1'))->row()->industriyal;
                $category = $this->db->get_where('industry_type', array('industry_id' => $categoryid, 'status' => '1'))->row()->industry_name;
                $othercategory = $this->db->get_where('business_profile', array('business_profile_id' => $user['follow_from'], 'status' => '1'))->row()->other_industrial;

                $return_html .= '<a>';
                if ($category) {
                    $return_html .= $category;
                } else {
                    $return_html .= $othercategory;
                }

                $return_html .= '</a>
                                                                                </div>
                                                                        </li>
                                                                        <li class="fr" id ="frfollow' . $user['follow_from'] . '">';
                $contition_array = array('user_id' => $userid, 'status' => '1');
                $busdatauser = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


                $contition_array = array('follow_from' => $busdatauser[0]['business_profile_id'], 'follow_status' => '1', 'follow_type' => '2', 'follow_to' => $user['follow_from']);
                $status_list = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

                if (($status_list[0]['follow_status'] == 0 || $status_list[0]['follow_status'] == ' ' ) && $user['follow_from'] != $busdatauser[0]['business_profile_id']) {

                    $return_html .= '<div class="user_btn follow_btn_' . $user['follow_from'] . '" id= "followdiv">
                                                                                    <button id="follow' . $user['follow_from'] . '" onClick="followuser_list_two(' . $user['follow_from'] . ')"><span>Follow</span></button>
                                                                                </div>';
                } else if ($user['follow_from'] == $busdatauser[0]['business_profile_id']) {
                    
                } else {
                    $return_html .= '<div class="user_btn follow_btn_' . $user['follow_from'] . '" id= "unfollowdiv">
                                                                                    <button class="bg_following" id="unfollow' . $user['follow_from'] . '" onClick="unfollowuser_list_two(' . $user['follow_from'] . ')"><span>Following</span></button>
                                                                                </div>';
                }
                $return_html .= '</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';
            }
        } else {
            $return_html .= '<div class="art-img-nn" id= "art-blank">
                                                <div class="art_no_post_img">
                                                    <img src="' . base_url('assets/img/icon_no_follower.png') . '" alt="icon_no_follower.png">
                                                </div>
                                                <div class="art_no_post_text">
                                                    No Followers Available.
                                                </div>
                                            </div>';
        }

        echo $return_html;
    }

    public function following($id = "") {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $this->data['slug_id'] = $id;

        $this->business_profile_active_check();
        $this->is_business_profile_register();


        $company_name = $this->get_company_name($id);
        $this->data['title'] =  $company_name . ' | Following' .' | Business Profile' . TITLEPOSTFIX;
        if ($company_name == '') {
            $this->load->view('business_profile/notavalible');
        } else {
            $this->load->view('business_profile/business_following', $this->data);
        }
    }

    public function ajax_following($id = "") {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;

        $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
        $artdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $slugid = $artdata[0]['business_slug'];
        if ($id == $slug_id || $id == '') {

            $contition_array = array('user_id' => $userid, 'status' => '1', 'is_deleted' => '0');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $join_str[0]['table'] = 'follow';
            $join_str[0]['join_table_id'] = 'follow.follow_to';
            $join_str[0]['from_table_id'] = 'business_profile.business_profile_id';
            $join_str[0]['join_type'] = '';

            $limit = $perpage;
            $offset = $start;

            $contition_array = array('follow_to' => $businessdata1[0]['business_profile_id'], 'follow_status' => '1', 'follow_type' => '2', 'business_profile.business_step' => '4', 'business_profile.status' => '1', 'business_profile.is_deleted' => '0');
            $userlist = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit, $offset, $join_str, $groupby = '');
            $userlist1 = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        } else {

            $contition_array = array('business_slug' => $id, 'business_step' => '4', 'status' => '1', 'is_deleted' => '0');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $join_str[0]['table'] = 'follow';
            $join_str[0]['join_table_id'] = 'follow.follow_to';
            $join_str[0]['from_table_id'] = 'business_profile.business_profile_id';
            $join_str[0]['join_type'] = '';

            $limit = $perpage;
            $offset = $start;

            $contition_array = array('follow_from' => $businessdata1[0]['business_profile_id'], 'follow_status' => '1', 'follow_type' => '2', 'business_profile.business_step' => '4', 'business_profile.status' => '1', 'business_profile.is_deleted' => '0');
            $userlist = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit, $offset, $join_str, $groupby = '');
            $userlist1 = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        }
        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($userlist1);
        }
        $return_html = '';
        $return_html .= '<input type="hidden" class="page_number" value="' . $page . '" />';
        $return_html .= '<input type="hidden" class="total_record" value="' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';
        if (count($userlist1) > 0) {

            foreach ($userlist as $user) {
                $return_html .= '<div class = "job-contact-frnd" id = "removefollow' . $user['follow_to'] . '">
    <div class = "profile-job-post-detail clearfix">
        <div class = "profile-job-post-title-inside clearfix">
            <div class = "profile-job-post-location-name">
                <div class = "user_lst">
                    <ul>
                        <li class = "fl">
                            <div class = "follow-img">';

                $companyname = $this->db->get_where('business_profile', array('business_profile_id' => $user['follow_to']))->row()->company_name;
                $slug = $this->db->get_where('business_profile', array('business_profile_id' => $user['follow_to']))->row()->business_slug;
                if ($this->db->get_where('business_profile', array('business_profile_id' => $user['follow_to']))->row()->business_user_image != '') {
                    $return_html .= '<a href="' . base_url('business-profile/dashboard/' . $slug) . '" title="' . $companyname . '">';
                    $uimage = $this->db->get_where('business_profile', array('business_profile_id' => $user['follow_to']))->row()->business_user_image;
                    if (IMAGEPATHFROM == 'upload') {
                        if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $uimage)) {
                            $return_html .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                        } else {
                            $return_html .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $this->db->get_where('business_profile', array('business_profile_id' => $user['follow_to']))->row()->business_user_image . '" height="50px" width="50px" alt="" >';
                        }
                    } else {
                        $filename = $this->config->item('bus_profile_thumb_upload_path') . $uimage;
                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                        if (!$info) {
                            $return_html .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                        } else {
                            $return_html .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $this->db->get_where('business_profile', array('business_profile_id' => $user['follow_to']))->row()->business_user_image . '" height="50px" width="50px" alt="" >';
                        }
                    }
                    $return_html .= '</a>';
                } else {
                    $return_html .= '<a href="' . base_url('business-profile/dashboard/' . $slug) . '" title="' . $companyname . '">';

                    $return_html .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                }
                $return_html .= '</div>
                                    </li>
                                    <li class="folle_text">
                                        <div class="">
                                            <div class="follow-li-text" style="padding: 0;">
                                                <a title="' . $companyname . '" href="' . base_url('business-profile/dashboard/' . $slug) . '">' . $this->db->get_where('business_profile', array('business_profile_id' => $user['follow_to']))->row()->company_name . '</a></div>
                                            <div>';

                $categoryid = $this->db->get_where('business_profile', array('business_profile_id' => $user['follow_to'], 'status' => '1'))->row()->industriyal;
                $category = $this->db->get_where('industry_type', array('industry_id' => $categoryid, 'status' => '1'))->row()->industry_name;
                $othercategory = $this->db->get_where('business_profile', array('business_profile_id' => $user['follow_to'], 'status' => '1'))->row()->other_industrial;

                $return_html .= '<a>';
                if ($category) {
                    $return_html .= $category;
                } else {
                    $return_html .= $othercategory;
                }

                $return_html .= '</a>
                                            </div>
                                    </li>';
                $userid = $this->session->userdata('aileenuser');
                if ($businessdata1[0]['user_id'] == $userid) {
                    $return_html .= '<li class="fr fruser' . $user['follow_to'] . '">';

                    $contition_array = array('follow_from' => $businessdata1[0]['business_profile_id'], 'follow_status' => '1', 'follow_type' => '2', 'follow_to' => $user['follow_to']);
                    $status = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    if ($status[0]['follow_status'] == 1) {
                        $return_html .= '<div class="user_btn" id= "unfollowdiv">
                                            <button class="bg_following" id="unfollow' . $user['follow_to'] . '" onClick="unfollowuser_list(' . $user['follow_to'] . ')"><span>Following</span></button>
                                        </div>';
                    }
                    $return_html .= '</li>';
                } else {
                    $return_html .= '<li class="fruser' . $user['follow_to'] . ' fr">';

                    $contition_array = array('user_id' => $userid, 'status' => '1');
                    $busdatauser = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    $contition_array = array('follow_from' => $busdatauser[0]['business_profile_id'], 'follow_status' => '1', 'follow_type' => '2', 'follow_to' => $user['follow_to']);
                    $status_list = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    if (($status_list[0]['follow_status'] == 0 || $status_list[0]['follow_status'] == ' ' ) && $user['follow_to'] != $busdatauser[0]['business_profile_id']) {
                        $return_html .= '<div class="user_btn follow_btn_' . $user['follow_to'] . '" id= "followdiv">
                                            <button id="follow' . $user['follow_to'] . '" onClick="followuser_list_two(' . $user['follow_to'] . ')"><span>Follow</span></button>
                            </div>';
                    } else if ($user['follow_to'] == $busdatauser[0]['business_profile_id']) {
                        
                    } else {
                        $return_html .= '<div class="user_btn follow_btn_' . $user['follow_to'] . '" id= "unfollowdiv">
                                <button class="bg_following" id="unfollow"' . $user['follow_to'] . '" onClick = "unfollowuser_list_two(' . $user['follow_to'] . ')"><span>Following</span></button>
                                                    </div>';
                    }
                    $return_html .= '</li>';
                }
                $return_html .= '</ul>
                                                    </div>
                                                    </div>
                                                    </div>
                                                    </div>
                                                    </div>';
            }
        } else {

            $return_html .= '<div class = "art-img-nn">
                                                    <div class = "art_no_post_img">
                                                    <img src = "' . base_url('assets/img/icon_no_following.png') . '" alt="icon_no_following.png">
                                                    </div>
                                                    <div class = "art_no_post_text">
                                                    No Following Available.
                                                    </div>
                                                    </div>';
        }
        $return_html .= '<div class = "col-md-1">
                                                    </div>';

        echo $return_html;
    }

// end of user list
//deactivate user start
    public function deactivate() {
        $s3 = new S3(awsAccessKey, awsSecretKey);

        $id = $_POST['id'];

        $data = array(
            'status' => '0'
        );

        $update = $this->common->update_data($data, 'business_profile', 'user_id', $id);
    }

// deactivate user end

    public function image_upload_ajax() {
        $s3 = new S3(awsAccessKey, awsSecretKey);

        session_start();
        $session_uid = $this->session->userdata('aileenuser');
        include_once 'getExtension.php';

        $valid_formats = array('jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg');
        if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST" && isset($session_uid)) {
            $name = $_FILES['photoimg']['name'];
            $size = $_FILES['photoimg']['size'];

            if ($name) {
                $ext = $this->common->getExtension($name);
                if (in_array($ext, $valid_formats)) {
                    if ($size < (1024 * 1024)) {
                        $actual_image_name = time() . $session_uid . "." . $ext;
                        $tmp = $_FILES['photoimg']['tmp_name'];
                        $bgSave = '<div id = "uX' . $session_uid . '" class = "bgSave wallbutton blackButton">Save Cover</div>';
                        $config['upload_path'] = 'uploads/user_image/';
                        $config['allowed_types'] = array('jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg');
                        // $config['allowed_types'] = VALID_IMAGE;
                        $config['file_name'] = $_FILES['photoimg']['name'];

//Load upload library and initialize configuration
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);

                        if ($this->upload->do_upload('photoimg')) {
                            $uploadData = $this->upload->data();

                            $picture = $uploadData['file_name'];
                        } else {
                            $picture = '';
                        }


                        $data = array(
                            'profile_background' => $picture
                        );

                        $update = $this->common->update_data($data, 'business_profile', 'user_id', $session_uid);
                        if ($update) {
                            $path = base_url('uploads/user_image/');
                            echo $bgSave . '<img src = "' . $path . $picture . '" id = "timelineBGload" class = "headerimage ui-corner-all" style = "top:0px"/>';
                        } else {
                            echo "Fail upload folder with read access.";
                        }
                    } else
                        echo "Image file size max 1 MB";
                } else
                    echo "Invalid file format.";
            } else
                echo "Please select image..!";

            exit;
        }
    }

    public function image_saveBG_ajax() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        session_start();
        $session_uid = $this->session->userdata('aileenuser');

        if (isset($_POST['position']) && isset($session_uid)) {

            $position = $_POST['position'];

            $data = array(
                'profile_background_position' => $position
            );

            $update = $this->common->update_data($data, 'business_profile', 'user_id', $session_uid);
            if ($update) {

                echo $position;
            }
        }
    }

    function slug_script() {

        $this->db->select('business_profile_id, company_name');
        $res = $this->db->get('business_profile')->result();
        foreach ($res as $k => $v) {
            $data = array('business_slug' => $this->setcategory_slug($v->company_name, 'business_slug', 'business_profile'));
            $this->db->where('business_profile_id', $v->business_profile_id);
            $this->db->update('business_profile', $data);
        }
        echo "yes";
    }

// create pdf start

    public function creat_pdf1($id) {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $contition_array = array('business_profile_post_id' => $id, 'status' => '1');
        $this->data['businessdata'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $this->load->view('business_profile/business_pdfdispaly', $this->data);
    }

    public function creat_pdf($id) {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $contition_array = array('post_files_id' => $id, 'is_deleted' => '1');
        $this->data['busdata'] = $this->common->select_data_by_condition('post_files', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
//echo "<pre>"; print_r($this->data['artdata']); die();
        $this->load->view('business_profile/business_pdfdispaly', $this->data);
    }

//create pdf end
// cover pic controller

    public function ajaxpro() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

// REMOVE OLD IMAGE FROM FOLDER
        $contition_array = array('user_id' => $userid);
        $user_reg_data = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'profile_background, profile_background_main', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $user_reg_prev_image = $user_reg_data[0]['profile_background'];
        $user_reg_prev_main_image = $user_reg_data[0]['profile_background_main'];

        if ($user_reg_prev_image != '') {
            $user_image_main_path = $this->config->item('bus_bg_main_upload_path');
            $user_bg_full_image = $user_image_main_path . $user_reg_prev_image;
            if (isset($user_bg_full_image)) {
                unlink($user_bg_full_image);
            }

            $user_image_thumb_path = $this->config->item('bus_bg_thumb_upload_path');
            $user_bg_thumb_image = $user_image_thumb_path . $user_reg_prev_image;
            if (isset($user_bg_thumb_image)) {
                unlink($user_bg_thumb_image);
            }
        }
        if ($user_reg_prev_main_image != '') {
            $user_image_original_path = $this->config->item('bus_bg_original_upload_path');
            $user_bg_origin_image = $user_image_original_path . $user_reg_prev_main_image;
            if (isset($user_bg_origin_image)) {
                unlink($user_bg_origin_image);
            }
        }

        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);

// REMOVE OLD IMAGE FROM FOLDER
//        $data = $_POST['image'];
//        $user_bg_path = $this->config->item('bus_bg_main_upload_path');
//        $imageName = time() . '.png';
//        $base64string = $data;
//        file_put_contents($user_bg_path . $imageName, base64_decode(explode(',', $base64string)[1]));

        $data = $_POST['image'];
        $data = str_replace('data:image/png;base64,', '', $data);
        $data = str_replace(' ', '+', $data);
        $user_bg_path = $this->config->item('bus_bg_main_upload_path');
        $imageName = time() . '.png';
        $data = base64_decode($data);
        $file = $user_bg_path . $imageName;
        $success = file_put_contents($file, $data);

        $main_image = $user_bg_path . $imageName;
        $main_image_size = filesize($main_image);

        if ($main_image_size > '1000000') {
            $quality = "15%";
        } elseif ($main_image_size > '50000' && $main_image_size < '1000000') {
            $quality = "30%";
        } elseif ($main_image_size > '5000' && $main_image_size < '50000') {
            $quality = "40%";
        } elseif ($main_image_size > '100' && $main_image_size < '5000') {
            $quality = "45%";
        } elseif ($main_image_size > '1' && $main_image_size < '100') {
            $quality = "50%";
        } else {
            $quality = "100%";
        }
        /* RESIZE */

//        $business_profile_bg['image_library'] = 'gd2';
//        $business_profile_bg['source_image'] = $main_image;
//        $business_profile_bg['new_image'] = $main_image;
//        $business_profile_bg['quality'] = $quality;
//        $instanse_cover = "imagecover";
//        $this->load->library('image_lib', $business_profile_bg, $instanse_cover);
//        $this->$instanse_cover->watermark();

        /* RESIZE */

        $cover_image = $this->config->item('bus_bg_main_upload_path') . $imageName;
        $abc1 = $s3->putObjectFile($cover_image, bucket, $cover_image, S3::ACL_PUBLIC_READ);

        $user_thumb_path = $this->config->item('bus_bg_thumb_upload_path');
        $user_thumb_width = $this->config->item('bus_bg_thumb_width');
        $user_thumb_height = $this->config->item('bus_bg_thumb_height');

        $upload_image = $user_bg_path . $imageName;
        $thumb_image_uplode = $this->thumb_img_uplode($upload_image, $imageName, $user_thumb_path, $user_thumb_width, $user_thumb_height);

        $thumb_image = $user_thumb_path . $imageName;
//        $abc = $s3->putObjectFile($cover_image, bucket, $cover_image, S3::ACL_PUBLIC_READ);
        $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);

        $data = array(
            'profile_background' => $imageName
        );

        $update = $this->common->update_data($data, 'business_profile', 'user_id', $userid);

        if ($update) {
            if ($_SERVER['HTTP_HOST'] != "localhost") {
                if (isset($main_image)) {
                    unlink($main_image);
                }
                if (isset($thumb_image)) {
                    unlink($thumb_image);
                }
            }
        }

        $this->data['busdata'] = $this->common->select_data_by_id('business_profile', 'user_id', $userid, $data = 'profile_background', $join_str = array());

//      echo '<img src = "' . $this->data['busdata'][0]['profile_background'] . '" />';
        echo '<img id="image_src" name="image_src" src = "' . BUS_BG_MAIN_UPLOAD_URL . $this->data['busdata'][0]['profile_background'] . '" alt="'. $this->data['busdata'][0]['profile_background'] . '"/>';
    }

    public function imagedata() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $config['upload_path'] = $this->config->item('bus_bg_original_upload_path');
        $config['allowed_types'] = array('jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg');
        //$config['allowed_types'] = VALID_IMAGE;
        $config['file_name'] = $_FILES['image']['name'];

//Load upload library and initialize configuration
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload('image')) {
            $uploadData = $this->upload->data();
            $image = $uploadData['file_name'];
        } else {
            $image = '';
        }


        $data = array(
            'profile_background_main' => $image,
            'modified_date' => date('Y-m-d H:i:s', time())
        );


        $updatedata = $this->common->update_data($data, 'business_profile', 'user_id', $userid);

        if ($updatedata) {
            echo $userid;
        } else {
            echo "welcome";
        }
    }

// cover pic end
// busienss_profile like comment ajax start

    public function like_comment() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $post_id = $_POST["post_id"];
        $contition_array = array('business_profile_post_comment_id' => $_POST["post_id"], 'status' => '1');
        $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $business_comment_likes_count = $businessprofiledata[0]['business_comment_likes_count'];
        $likeuserarray = explode(',', $businessprofiledata[0]['business_comment_like_user']);

        if (!in_array($userid, $likeuserarray)) {
            $user_array = array_push($likeuserarray, $userid);

            if ($businessprofiledata[0]['business_comment_likes_count'] == 0) {
                $userid = implode('', $likeuserarray);
            } else {
                $userid = implode(', ', $likeuserarray);
            }

            $data = array(
                'business_comment_likes_count' => $business_comment_likes_count + 1,
                'business_comment_like_user' => $userid,
                'modify_date' => date('y-m-d h:i:s')
            );

            $updatdata = $this->common->update_data($data, 'business_profile_post_comment', 'business_profile_post_comment_id', $post_id);

// insert notification
            if ($businessprofiledata[0]['user_id'] == $userid) {
                
            } else {
                $contition_array = array('not_type' => '5', 'not_from_id' => $userid, 'not_to_id' => $businessprofiledata[0]['user_id'], 'not_product_id' => $post_id, 'not_from' => '6', 'not_img' => '3');
                $busnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if ($busnotification[0]['not_read'] == 2) {
                    
                } elseif ($busnotification[0]['not_read'] == 1) {

                    $datalike = array(
                        'not_read' => '2'
                    );

                    $where = array('not_type' => '5', 'not_from_id' => $userid, 'not_to_id' => $businessprofiledata[0]['user_id'], 'not_product_id' => $post_id, 'not_from' => '6', 'not_img' => '3');
                    $this->db->where($where);
                    $updatdata = $this->db->update('notification', $datalike);
                } else {

                    $datacmlike = array(
                        'not_type' => '5',
                        'not_from_id' => $userid,
                        'not_to_id' => $businessprofiledata[0]['user_id'],
                        'not_read' => '2',
                        'not_product_id' => $post_id,
                        'not_from' => '6',
                        'not_img' => '3',
                        'not_created_date' => date('Y-m-d H:i:s'),
                        'not_active' => '1'
                    );


                    $insert_id = $this->common->insert_data_getid($datacmlike, 'notification');
                    if ($insert_id) {

                        $to_email_id = $this->db->select('contact_email')->get_where('business_profile', array('user_id' => $businessprofiledata[0]['user_id']))->row()->contact_email;
                        $email_html = '';
                        $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;"><img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $this->data['business_login_user_image'] . '" width="50" height="50" alt="'. $this->data['business_login_user_image'] .'"></td>
                                            <td style="padding:5px;">
						<p><b>' . $this->data['business_login_company_name'] . '</b> like your comment in business profile.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a class="btn" href="' . BASEURL . 'notification/business-profile-post/' . $businessprofiledata[0]['	business_profile_post_id'] . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
                        $subject = $this->data['business_login_company_name'] . ' Like your comment in Aileensoul.';

                        $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $to_email_id);
                    }
                }
            }
// end notification


            $contition_array = array('business_profile_post_comment_id' => $_POST["post_id"], 'status' => '1');
            $businessprofiledata1 = $this->data['businessprofiledata1'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($updatdata) {


                $cmtlike1 = '<a id = "' . $businessprofiledata1[0]['business_profile_post_comment_id'] . '" onClick = "comment_like(this.id)">';
                $cmtlike1 .= ' <i class = "fa fa-thumbs-up" aria-hidden = "true">';
                $cmtlike1 .= '</i>';
                $cmtlike1 .= '<span> ';
                if ($businessprofiledata1[0]['business_comment_likes_count'] > 0) {
                    $cmtlike1 .= $businessprofiledata1[0]['business_comment_likes_count'] . '';
                }
                $cmtlike1 .= '</span>';
                $cmtlike1 .= '</a>';
                echo $cmtlike1;
            } else {
                
            }
        } else {

            foreach ($likeuserarray as $key => $val) {
                if ($val == $userid) {
                    $user_array = array_splice($likeuserarray, $key, 1);
                }
            }

            $data = array(
                'business_comment_likes_count' => $business_comment_likes_count - 1,
                'business_comment_like_user' => implode(', ', $likeuserarray),
                'modify_date' => date('y-m-d h:i:s')
            );


            $updatdata = $this->common->update_data($data, 'business_profile_post_comment', 'business_profile_post_comment_id', $post_id);
            $contition_array = array('business_profile_post_comment_id' => $_POST["post_id"], 'status' => '1');
            $businessprofiledata2 = $this->data['businessprofiledata2'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($updatdata) {

                $cmtlike1 = '<a id = "' . $businessprofiledata2[0]['business_profile_post_comment_id'] . '" onClick = "comment_like(this.id)">';
                $cmtlike1 .= '<i class = "fa fa-thumbs-up fa-1x" aria-hidden = "true">';
                $cmtlike1 .= '</i>';
                $cmtlike1 .= '<span>';
                if ($businessprofiledata2[0]['business_comment_likes_count'] > 0) {
                    $cmtlike1 .= $businessprofiledata2[0]['business_comment_likes_count'] . '';
                }
                $cmtlike1 .= '</span>';
                $cmtlike1 .= '</a>';
                echo $cmtlike1;
            } else {
                
            }
        }
    }

    public function like_comment1() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $post_id = $_POST['post_id'];
        $contition_array = array('business_profile_post_comment_id' => $_POST["post_id"], 'status' => '1');
        $bus_not_to_id = $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $business_comment_likes_count = $businessprofiledata[0]['business_comment_likes_count'];
        $likeuserarray = explode(',', $businessprofiledata[0]['business_comment_like_user']);

        if (!in_array($userid, $likeuserarray)) {
            $user_array = array_push($likeuserarray, $userid);

            if ($businessprofiledata[0]['business_comment_likes_count'] == 0) {
                $userid = implode('', $likeuserarray);
            } else {
                $userid = implode(', ', $likeuserarray);
            }

            $data = array(
                'business_comment_likes_count' => $business_comment_likes_count + 1,
                'business_comment_like_user' => $userid,
                'modify_date' => date('Y-m-d H:i:s')
            );

            $updatdata = $this->common->update_data($data, 'business_profile_post_comment', 'business_profile_post_comment_id', $post_id);
// insert notification
            if ($businessprofiledata[0]['user_id'] == $userid) {
                
            } else {

                $contition_array = array('not_type' => '5', 'not_from_id' => $userid, 'not_to_id' => $businessprofiledata[0]['user_id'], 'not_product_id' => $post_id, 'not_from' => '6', 'not_img' => '3');
                $busnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if ($busnotification[0]['not_read'] == 2) {
                    
                } elseif ($busnotification[0]['not_read'] == 1) {
                    $datalike = array(
                        'not_read' => '2'
                    );

                    $where = array('not_type' => '5', 'not_from_id' => $userid, 'not_to_id' => $businessprofiledata[0]['user_id'], 'not_product_id' => $post_id, 'not_from' => '6', 'not_img' => '3');
                    $this->db->where($where);
                    $updatdata = $this->db->update('notification', $datalike);
                } else {
                    $data = array(
                        'not_type' => '5',
                        'not_from_id' => $userid,
                        'not_to_id' => $businessprofiledata[0]['user_id'],
                        'not_read' => '2',
                        'not_product_id' => $post_id,
                        'not_from' => '6',
                        'not_img' => '3',
                        'not_created_date' => date('Y-m-d H:i:s'),
                        'not_active' => '1'
                    );

                    $insert_id = $this->common->insert_data_getid($data, 'notification');
                    if ($insert_id) {

                        $to_email_id = $this->db->select('contact_email')->get_where('business_profile', array('user_id' => $businessprofiledata[0]['user_id']))->row()->contact_email;
                        $email_html = '';
                        $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;"><img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $this->data['business_login_user_image'] . '" width="50" height="50" alt="'. $this->data['business_login_user_image'] .'"></td>
                                            <td style="padding:5px;">
						<p><b>' . $this->data['business_login_company_name'] . '</b> like your comment in business profile.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a class="btn" href="' . BASEURL . 'notification/business-profile-post/' . $businessprofiledata[0]['	business_profile_post_id'] . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
                        $subject = $this->data['business_login_company_name'] . ' Like your comment in Aileensoul.';

                        $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $to_email_id);
                    }
                }
            }
// end notification
            $contition_array = array('business_profile_post_comment_id' => $_POST["post_id"], 'status' => '1');
            $businessprofiledata1 = $this->data['businessprofiledata1'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($updatdata) {
                $cmtlike1 = '<a id = "' . $businessprofiledata1[0]['business_profile_post_comment_id'] . '" onClick = "comment_like1(this.id)">';
                $cmtlike1 .= '<i class = "fa fa-thumbs-up fa-1x main_color" aria-hidden = "true">';
                $cmtlike1 .= '</i>';
                $cmtlike1 .= '<span> ';
                if ($businessprofiledata1[0]['business_comment_likes_count'] > 0) {
                    $cmtlike1 .= $businessprofiledata1[0]['business_comment_likes_count'] . '';
                }
                $cmtlike1 .= '</span>';
                $cmtlike1 .= '</a>';
//                echo $cmtlike1;
                // GET NOTIFICATION COUNT
                $to_id = $bus_not_to_id[0]['user_id'];
                $not_count = $this->business_notification_count($to_id);

                echo json_encode(
                        array(
                            'comment_html' => $cmtlike1,
                            'status' => 'success',
                            'notification' => array('notification_count' => $not_count, 'to_id' => $to_id),
                ));
            } else {
                
            }
        } else {

            foreach ($likeuserarray as $key => $val) {
                if ($val == $userid) {
                    $user_array = array_splice($likeuserarray, $key, 1);
                }
            }

            $data = array(
                'business_comment_likes_count' => $business_comment_likes_count - 1,
                'business_comment_like_user' => implode(', ', $likeuserarray),
                'modify_date' => date('Y-m-d H:i:s')
            );


            $updatdata = $this->common->update_data($data, 'business_profile_post_comment', 'business_profile_post_comment_id', $post_id);
            $contition_array = array('business_profile_post_comment_id' => $_POST["post_id"], 'status' => '1');
            $businessprofiledata2 = $this->data['businessprofiledata2'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($updatdata) {

                $cmtlike1 = '<a id = "' . $businessprofiledata2[0]['business_profile_post_comment_id'] . '" onClick = "comment_like1(this.id)">';
                $cmtlike1 .= '<i class = "fa fa-thumbs-up fa-1x" aria-hidden = "true">';
                $cmtlike1 .= '</i>';

// $cmtlike1 .= '<i class = "fa fa-thumbs-up fa-1x main_color" aria-hidden = "true">';
// $cmtlike1 .= '</i>';
                $cmtlike1 .= '<span> ';
                if ($businessprofiledata2[0]['business_comment_likes_count'] > 0) {
                    $cmtlike1 .= $businessprofiledata2[0]['business_comment_likes_count'] . '';
                }
                $cmtlike1 .= '</span>';
                $cmtlike1 .= '</a>';
                //                echo $cmtlike1;
                // GET NOTIFICATION COUNT
                $to_id = $bus_not_to_id[0]['user_id'];
                $not_count = $this->business_notification_count($to_id);

                echo json_encode(
                        array(
                            'comment_html' => $cmtlike1,
                            'status' => 'success',
                            'notification' => array('notification_count' => $not_count, 'to_id' => $to_id),
                ));
            } else {
                
            }
        }
    }

// Business_profile comment like end 
//Business_profile comment delete start
    public function delete_comment() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $post_id = $_POST["post_id"];
        $post_delete = $_POST["post_delete"];

        $data = array(
            'status' => 0,
        );


        $updatdata = $this->common->update_data($data, 'business_profile_post_comment', 'business_profile_post_comment_id', $post_id);


        $contition_array = array('business_profile_post_id' => $post_delete, 'status' => '1');
        $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = 'business_profile_post_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('business_profile_post_id' => $post_delete, 'status' => '1');
        $buscmtcnt = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = 'business_profile_post_comment_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

//echo '<pre>'; print_r($businessprofiledata); die();
// khyati changes start
        if (count($businessprofiledata) > 0) {
            foreach ($businessprofiledata as $business_profile) {

                $companyname = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id']))->row()->company_name;
                $companyslug = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id']))->row()->business_slug;
                $business_userimage = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id'], 'status' => '1'))->row()->business_user_image;

                $cmtinsert .= '<div class="all-comment-comment-box">';
                $cmtinsert .= '<div class="post-design-pro-comment-img">';

                if ($business_userimage != '') {
                    $cmtinsert .= '<img  src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt="'. $business_userimage .'">  </div>';
                } else {
//                    $a = $companyname;
//                    $acr = substr($a, 0, 1);
//
//                    $cmtinsert .= '<div class="post-img-div">';
//                    $cmtinsert .= ucfirst($acr);
//                    $cmtinsert .= '</div>';
//
//                    $cmtinsert .= '</div>';

                    $cmtinsert .= '<img src="' . base_url() . NOBUSIMAGE . '" alt="NOBUSIMAGE"> </div>';
                }
                $cmtinsert .= '<div class="comment-name"><a href="' . base_url() . 'business-profile/dashboard/' . $companyslug . '"><b>' . $companyname . '</b></a>';
                $cmtinsert .= '</div>';
                $cmtinsert .= '<div class="comment-details" id= "showcomment' . $business_profile['business_profile_post_comment_id'] . '">';
                $cmtinsert .= $this->common->make_links($business_profile['comments']);
                $cmtinsert .= '</div>';
                $cmtinsert .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';
//$cmtinsert .= '<textarea type="text" class="textarea" name="' . $business_profile['business_profile_post_comment_id'] . '" id="editcomment' . $business_profile['business_profile_post_comment_id'] . '" style="display:none;resize: none;" onClick="commentedit(this.name)">' . $business_profile['comments'] . '</textarea>';
                $cmtinsert .= '<div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="' . $business_profile['business_profile_post_comment_id'] . '"  id="editcomment' . $business_profile['business_profile_post_comment_id'] . '" placeholder="Type Message ..." onkeyup="commentedit(' . $business_profile['business_profile_post_comment_id'] . ')" onclick="commentedit(' . $business_profile['business_profile_post_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $business_profile['comments'] . '</div>';
                $cmtinsert .= '<span class="comment-edit-button"><button id="editsubmit' . $business_profile['business_profile_post_comment_id'] . '" style="display:none" onClick="edit_comment(' . $business_profile['business_profile_post_comment_id'] . ')">Save</button></span>';
                $cmtinsert .= '</div></div>';
//                $cmtinsert .= '<input type="text" name="' . $business_profile['business_profile_post_comment_id'] . '" id="editcomment' . $business_profile['business_profile_post_comment_id'] . '"style="display:none;" value="' . $business_profile['comments'] . ' " onClick="commentedit(this.name)">';
//                $cmtinsert .= '<button id="editsubmit' . $business_profile['business_profile_post_comment_id'] . '" style="display:none;" onClick="edit_comment(' . $business_profile['business_profile_post_comment_id'] . ')">Comment</button><div class="art-comment-menu-design"> <div class="comment-details-menu" id="likecomment1' . $business_profile['business_profile_post_comment_id'] . '">';
                $cmtinsert .= '<div class="art-comment-menu-design"><div class="comment-details-menu" id="likecomment1' . $business_profile['business_profile_post_comment_id'] . '">';
                $cmtinsert .= '<a id="' . $business_profile['business_profile_post_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_like1(this.id)">';

                $userid = $this->session->userdata('aileenuser');
                $contition_array = array('business_profile_post_comment_id' => $business_profile['business_profile_post_comment_id'], 'status' => '1');
                $businesscommentlike = $this->data['businesscommentlike'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                $likeuserarray = explode(',', $businesscommentlike[0]['business_comment_like_user']);

                if (!in_array($userid, $likeuserarray)) {
                    $cmtinsert .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
                } else {
                    $cmtinsert .= '<i class="fa fa-thumbs-up" aria-hidden="true"></i>';
                }


                $cmtinsert .= '<span>';
                if ($business_profile['business_comment_likes_count'] > 0) {
                    $cmtinsert .= ' ' . $business_profile['business_comment_likes_count'];
                }
                $cmtinsert .= '</span>';
                $cmtinsert .= '</a></div>';


                $userid = $this->session->userdata('aileenuser');
                if ($business_profile['user_id'] == $userid) {

                    $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $cmtinsert .= '<div class="comment-details-menu">';


                    $cmtinsert .= '<div id="editcommentbox' . $business_profile['business_profile_post_comment_id'] . '"style="display:block;">';

                    $cmtinsert .= '<a id="' . $business_profile['business_profile_post_comment_id'] . '"';
                    $cmtinsert .= 'onClick="comment_editbox(this.id)">';
                    $cmtinsert .= 'Edit';
                    $cmtinsert .= '</a></div>';

                    $cmtinsert .= '<div id="editcancle' . $business_profile['business_profile_post_comment_id'] . '"style="display:none;">';

                    $cmtinsert .= '<a id="' . $business_profile['business_profile_post_comment_id'] . '"';
                    $cmtinsert .= 'onClick="comment_editcancle(this.id)">';
                    $cmtinsert .= 'Cancel';
                    $cmtinsert .= '</a></div>';

                    $cmtinsert .= '</div>';
                }




                $userid = $this->session->userdata('aileenuser');

                $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $business_profile['business_profile_post_id'], 'status' => '1'))->row()->user_id;


                if ($business_profile['user_id'] == $userid || $business_userid == $userid) {

                    $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $cmtinsert .= '<div class="comment-details-menu">';


                    $cmtinsert .= '<input type="hidden" name="post_delete"';
                    $cmtinsert .= 'id="post_delete' . $business_profile['business_profile_post_comment_id'] . '"';
                    $cmtinsert .= 'value= "' . $business_profile['business_profile_post_id'] . '">';
                    $cmtinsert .= '<a id="' . $business_profile['business_profile_post_comment_id'] . '"';
                    $cmtinsert .= 'onClick="comment_delete(this.id)">';
                    $cmtinsert .= 'Delete';
                    $cmtinsert .= '</a></div>';
                }

                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';
                $cmtinsert .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($business_profile['created_date']))) . '</p></div></div></div>';


// comment aount variable start
                $idpost = $business_profile['business_profile_post_id'];
                $cmtcount = '<a onClick="commentall(this.id)" id="' . $idpost . '">';
                $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
                $cmtcount .= ' ' . count($buscmtcnt) . '';
                $cmtcount .= '</i></a>';

// comment count variable end 
            }
            if (count($buscmtcnt) > 0) {
                $cntinsert .= '' . count($buscmtcnt) . '';
                $cntinsert .= '<span> Comment</span>';
            }
        } else {
            $idpost = $business_profile['business_profile_post_id'];
            $cmtcount = '<a onClick="commentall(this.id)" id="' . $idpost . '">';
            $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
            $cmtcount .= '</i></a>';
        }
        echo json_encode(
                array("comment" => $cmtinsert,
                    "count" => $cmtcount,
                    "comment_count" => $cntinsert
        ));
    }

//second page manage in manage post for function start

    public function delete_commenttwo() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $post_id = $_POST["post_id"];
        $post_delete = $_POST["post_delete"];

        $data = array(
            'status' => '0',
        );
        $updatdata = $this->common->update_data($data, 'business_profile_post_comment', 'business_profile_post_comment_id', $post_id);


        $contition_array = array('business_profile_post_id' => $post_delete, 'status' => '1');
        $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = 'business_profile_post_comment_id', $orderby = 'ASCdelete_commenttwo', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if (count($businessprofiledata) > 0) {
            foreach ($businessprofiledata as $business_profile) {

                $companyname = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id']))->row()->company_name;
                $companyslug = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id']))->row()->business_slug;
                $business_userimage = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id'], 'status' => '1'))->row()->business_user_image;

                $cmtinsert .= '<div class="all-comment-comment-box">';
                $cmtinsert .= '<div class="post-design-pro-comment-img">';
                if ($business_userimage != '') {
                    if (IMAGEPATHFROM == 'upload') {
                        if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                            $cmtinsert .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                        } else {
                            $cmtinsert .= '<img  src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt="'. $business_userimage .'">';
                        }
                    } else {
                        $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_userimage;
                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                        if (!$info) {
                            $cmtinsert .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                        } else {
                            $cmtinsert .= '<img  src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt="'. $business_userimage .'">';
                        }
                    }


                    $cmtinsert .= '</div>';
                } else {


                    $cmtinsert .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';

                    $cmtinsert .= '</div>';
                }
                $cmtinsert .= '<div class="comment-name"><b>' . $companyname . '</b>';
                $cmtinsert .= '</div>';
                $cmtinsert .= '<div class="comment-details" id="showcommenttwo' . $business_profile['business_profile_post_comment_id'] . '">';
                $cmtinsert .= $this->common->make_links($business_profile['comments']);
                $cmtinsert .= '</div>';
                $cmtinsert .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';
                $cmtinsert .= '<div contenteditable="true" style="display:none;
                                                    min-height:37px!important;
                                                    margin-top: 0px!important;
                                                    margin-left: 1.5%!important;
                                                    width: 81%;
                                                    " class="editable_text" name="' . $business_profile['business_profile_post_comment_id'] . '"  id="editcommenttwo' . $business_profile['business_profile_post_comment_id'] . '" placeholder="Type Message ..." onkeyup="commentedittwo(' . $business_profile['business_profile_post_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);
                                                    ">' . $business_profile['comments'] . '</div>';
                $cmtinsert .= '<span class="comment-edit-button"><button id="editsubmittwo' . $business_profile['business_profile_post_comment_id'] . '" style="display:none" onClick="edit_commenttwo(' . $business_profile['business_profile_post_comment_id'] . ')">Save</button></span>';
                $cmtinsert .= '</div></div>';

                $cmtinsert .= '<div class="art-comment-menu-design"><div class="comment-details-menu" id="likecomment1' . $business_profile['business_profile_post_comment_id'] . '">';
                $cmtinsert .= '<a id="' . $business_profile['business_profile_post_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_like1(this.id)">';

                $userid = $this->session->userdata('aileenuser');
                $contition_array = array('business_profile_post_comment_id' => $business_profile['business_profile_post_comment_id'], 'status' => '1');
                $businesscommentlike = $this->data['businesscommentlike'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                $likeuserarray = explode(',', $businesscommentlike[0]['business_comment_like_user']);

                if (!in_array($userid, $likeuserarray)) {
                    $cmtinsert .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
                } else {
                    $cmtinsert .= '<i class="fa fa-thumbs-up" aria-hidden="true"></i>';
                }

                $cmtinsert .= '<span>';
                if ($business_profile['business_comment_likes_count'] > 0) {
                    $cmtinsert .= ' ' . $business_profile['business_comment_likes_count'];
                }
                $cmtinsert .= '</span>';
                $cmtinsert .= '</a></div>';

                $userid = $this->session->userdata('aileenuser');
                if ($business_profile['user_id'] == $userid) {

                    $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $cmtinsert .= '<div class="comment-details-menu">';
                    $cmtinsert .= '<div id="editcommentboxtwo' . $business_profile['business_profile_post_comment_id'] . '"style="display:block;
                                                    ">';
                    $cmtinsert .= '<a id="' . $business_profile['business_profile_post_comment_id'] . '"';
                    $cmtinsert .= 'onClick="comment_editboxtwo(this.id)">';
                    $cmtinsert .= 'Edit';
                    $cmtinsert .= '</a></div>';
                    $cmtinsert .= '<div id="editcancletwo' . $business_profile['business_profile_post_comment_id'] . '"style="display:none;
                                                    ">';
                    $cmtinsert .= '<a id="' . $business_profile['business_profile_post_comment_id'] . '"';
                    $cmtinsert .= 'onClick="comment_editcancletwo(this.id)">';
                    $cmtinsert .= 'Cancel';
                    $cmtinsert .= '</a></div>';
                    $cmtinsert .= '</div>';
                }

                $userid = $this->session->userdata('aileenuser');
                $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $business_profile['business_profile_post_id'], 'status' => '1'))->row()->user_id;

                if ($business_profile['user_id'] == $userid || $business_userid == $userid) {
                    $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $cmtinsert .= '<div class="comment-details-menu">';
                    $cmtinsert .= '<input type="hidden" name="post_deletetwo"';
                    $cmtinsert .= 'id="post_deletetwo' . $business_profile['business_profile_post_comment_id'] . '"';
                    $cmtinsert .= 'value= "' . $business_profile['business_profile_post_id'] . '">';
                    $cmtinsert .= '<a id="' . $business_profile['business_profile_post_comment_id'] . '"';
                    $cmtinsert .= 'onClick="comment_deletetwo(this.id)">';
                    $cmtinsert .= 'Delete';
                    $cmtinsert .= '</a></div>';
                }

                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';
                $cmtinsert .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($business_profile['created_date']))) . '</p></div></div></div>';
// comment aount variable start
                $idpost = $business_profile['business_profile_post_id'];
                $cmtcount = '<a onClick="commentall1(this.id)" id="' . $idpost . '">';
                $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
                $cmtcount .= ' ' . count($businessprofiledata) . '';
                $cmtcount .= '</i></a>';

// comment count variable end 
            }

            if (count($businessprofiledata) > 0) {
                $cntinsert .= '' . count($businessprofiledata) . '';
                $cntinsert .= '<span> Comment</span>';
            }
        } else {
            $idpost = $business_profile['business_profile_post_id'];
            $cmtcount = '<a onClick="commentall1(this.id)" id="' . $idpost . '">';
            $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
            $cmtcount .= '</i></a>';
        }
        echo json_encode(
                array("comment" => $cmtinsert,
                    "count" => $cmtcount,
                    "comment_count" => $cntinsert,
                    "total_comment_count" => count($businessprofiledata),
        ));
    }

//Business_profile comment delete end     
// Business_profile post like start

    public function like_post() {
        $s3 = new S3(awsAccessKey, awsSecretKey);

        $userid = $this->session->userdata('aileenuser');

        $post_id = $_POST["post_id"];
        $contition_array = array('business_profile_post_id' => $_POST["post_id"], 'status' => '1');
        $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $business_likes_count = $businessprofiledata[0]['business_likes_count'];
        $likeuserarray = explode(',', $businessprofiledata[0]['business_like_user']);

        if (!in_array($userid, $likeuserarray)) {

            $user_array = array_push($likeuserarray, $userid);

            if ($businessprofiledata[0]['business_likes_count'] == 0) {
                $useridin = implode('', $likeuserarray);
            } else {
                $useridin = implode(',', $likeuserarray);
            }

            $data = array(
                'business_likes_count' => $business_likes_count + 1,
                'business_like_user' => $useridin,
                'modify_date' => date('Y-m-d H:i:s')
            );
            $updatdata = $this->common->update_data($data, 'business_profile_post', 'business_profile_post_id', $post_id);
// insert notification
            if ($businessprofiledata[0]['user_id'] == $userid || $businessprofiledata[0]['is_delete'] == '1') {
                
            } else {

                $contition_array = array('not_type' => '5', 'not_from_id' => $userid, 'not_to_id' => $businessprofiledata[0]['user_id'], 'not_product_id' => $post_id, 'not_from' => '6', 'not_img' => '2');
                $busnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if ($busnotification[0]['not_read'] == 2) {
                    
                } elseif ($busnotification[0]['not_read'] == 1) {

                    $datalike = array(
                        'not_read' => '2'
                    );

                    $where = array('not_type' => '5', 'not_from_id' => $userid, 'not_to_id' => $businessprofiledata[0]['user_id'], 'not_product_id' => $post_id, 'not_from' => '6', 'not_img' => '2');
                    $this->db->where($where);
                    $updatdata = $this->db->update('notification', $datalike);
                } else {

                    $datalike = array(
                        'not_type' => '5',
                        'not_from_id' => $userid,
                        'not_to_id' => $businessprofiledata[0]['user_id'],
                        'not_read' => '2',
                        'not_product_id' => $post_id,
                        'not_from' => '6',
                        'not_img' => '2',
                        'not_created_date' => date('Y-m-d H:i:s'),
                        'not_active' => '1'
                    );
                    $insert_id = $this->common->insert_data_getid($datalike, 'notification');

                    if ($insert_id) {

                        $to_email_id = $this->db->select('contact_email')->get_where('business_profile', array('user_id' => $businessprofiledata[0]['user_id']))->row()->contact_email;
                        $email_html = '';
                        $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;"><img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $this->data['business_login_user_image'] . '" width="50" height="50" alt="'. $this->data['business_login_user_image'] .'"></td>
                                            <td style="padding:5px;">
						<p><b>' . $this->data['business_login_company_name'] . '</b> like your post in business profile.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a class="btn" href="' . BASEURL . 'notification/business-profile-post/' . $post_id . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
                        // $businessprofiledata[0]['	business_profile_post_id']


                        $subject = $this->data['business_login_company_name'] . ' like your post in Aileensoul.';

                        $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $to_email_id);
                    }
                }
            }
// end notification

            $contition_array = array('business_profile_post_id' => $_POST["post_id"], 'status' => '1');
            $businessprofiledata1 = $this->data['businessprofiledata1'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($updatdata) {
                $cmtlike = '<li>';
                $cmtlike .= '<a id="' . $businessprofiledata1[0]['business_profile_post_id'] . '" class="ripple like_h_w" onClick="post_like(this.id)">';
                $cmtlike .= ' <i class="fa fa-thumbs-up main_color" aria-hidden="true">';
                $cmtlike .= '</i>';
                $cmtlike .= '<span class="like_As_count"> ';
                if ($businessprofiledata1[0]['business_likes_count'] > 0) {
                    $cmtlike .= $businessprofiledata1[0]['business_likes_count'] . '';
                }
                $cmtlike .= '</span>';
                $cmtlike .= '</a>';
                $cmtlike .= '</li>';

                $contition_array = array('business_profile_post_id' => $businessprofiledata1['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $likeuser = $commnetcount[0]['business_like_user'];
                $countlike = $commnetcount[0]['business_likes_count'] - 1;

                $likelistarray = explode(',', $likeuser);

                foreach ($likelistarray as $key => $value) {
                    $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => '1'))->row()->company_name;
                }

                $cmtlikeuser .= '<div class="like_one_other">';
                $cmtlikeuser .= ' <a href="javascript:void(0);
                                                    "  onclick="likeuserlist(' . $businessprofiledata1[0]['business_profile_post_id'] . ');
                                                    ">';

                $contition_array = array('business_profile_post_id' => $businessprofiledata1[0]['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $likeuser = $commnetcount[0]['business_like_user'];
                $countlike = $commnetcount[0]['business_likes_count'] - 1;

                $likelistarray = explode(',', $likeuser);
                $likelistarray = array_reverse($likelistarray);

                $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $likelistarray[0], 'status' => '1'))->row()->company_name;

                if ($userid == $likelistarray[0]) {
                    $cmtlikeuser .= 'You ';
                } else {
                    $cmtlikeuser .= '' . ucfirst($business_fname1) . '&nbsp;';
                }


                if (count($likelistarray) > 1) {

                    $cmtlikeuser .= ' and';
                    $cmtlikeuser .= ' ' . $countlike . ' others';
                }

                $cmtlikeuser .= '</a>';
                $cmtlikeuser .= '</div>';
                if ($commnetcount[0]['business_likes_count'] > 0) {
                    $like_user_count .= '' . $commnetcount[0]['business_likes_count'] . '';
                    $like_user_count .= '<span> Like</span>';
                }

                // GET NOTIFICATION COUNT
                $to_id = $businessprofiledata[0]['user_id'];
                $not_count = $this->business_notification_count($to_id);

                echo json_encode(
                        array("like" => $cmtlike,
                            "likeuser" => $cmtlikeuser,
                            "like_user_count" => $like_user_count,
                            "like_user_total_count" => $commnetcount[0]['business_likes_count'],
                            "status" => 'success',
                            "notification" => array('notification_count' => $not_count, 'to_id' => $to_id),
                ));
            } else {
                
            }
        } else {

            foreach ($likeuserarray as $key => $val) {
                if ($val == $userid) {
                    $user_array = array_splice($likeuserarray, $key, 1);
                }
            }

            $data = array(
                'business_likes_count' => $business_likes_count - 1,
                'business_like_user' => implode(',', $likeuserarray),
                'modify_date' => date('y-m-d h:i:s')
            );


            $updatdata = $this->common->update_data($data, 'business_profile_post', 'business_profile_post_id', $post_id);
            $contition_array = array('business_profile_post_id' => $_POST["post_id"], 'status' => '1');
            $businessprofiledata2 = $this->data['businessprofiledata2'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($updatdata) {

                $cmtlike = '<li>';
                $cmtlike .= '<a id="' . $businessprofiledata2[0]['business_profile_post_id'] . '" class="ripple like_h_w" onClick="post_like(this.id)">';
                $cmtlike .= '<i class="fa fa-thumbs-up" style="color: #999;" aria-hidden="true">';
                $cmtlike .= '</i>';
                $cmtlike .= '<span class="like_As_count">';
                if ($businessprofiledata2[0]['business_likes_count'] > 0) {
                    $cmtlike .= $businessprofiledata2[0]['business_likes_count'] . '';
                }
                $cmtlike .= '</span>';
                $cmtlike .= '</a>';
                $cmtlike .= '</li>';

                $contition_array = array('business_profile_post_id' => $businessprofiledata2['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $likeuser = $commnetcount[0]['business_like_user'];
                $countlike = $commnetcount[0]['business_likes_count'] - 1;

                $likelistarray = explode(',', $likeuser);
                $likelistarray = array_reverse($likelistarray);
                foreach ($likelistarray as $key => $value) {
                    $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => '1'))->row()->company_name;
                }

                $cmtlikeuser .= '<div class="like_one_other">';
                $cmtlikeuser .= '<a href="javascript:void(0);" class="ripple like_h_w" onclick="likeuserlist(' . $businessprofiledata2[0]['business_profile_post_id'] . ')">';
                $contition_array = array('business_profile_post_id' => $businessprofiledata2[0]['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $likeuser = $commnetcount[0]['business_like_user'];
                $countlike = $commnetcount[0]['business_likes_count'] - 1;

                $likelistarray = explode(',', $likeuser);

                $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $likelistarray[0], 'status' => '1'))->row()->company_name;

                $cmtlikeuser .= '' . ucfirst($business_fname1) . '&nbsp;';


                if (count($likelistarray) > 1) {

                    $cmtlikeuser .= 'and';
                    $cmtlikeuser .= ' ' . $countlike . ' others';
                }
                $cmtlikeuser .= '</a>';
                $cmtlikeuser .= '</div>';


                if ($commnetcount[0]['business_likes_count'] > 0) {
                    $like_user_count .= '' . $commnetcount[0]['business_likes_count'] . '';
                    $like_user_count .= '<span> Like</span>';
                }

                // GET NOTIFICATION COUNT
                $to_id = $businessprofiledata[0]['user_id'];
                $not_count = $this->business_notification_count($to_id);

                echo json_encode(
                        array("like" => $cmtlike,
                            "likeuser" => $cmtlikeuser,
                            "like_user_count" => $like_user_count,
                            "like_user_total_count" => $commnetcount[0]['business_likes_count'],
                            "status" => 'success',
                            "notification" => array('notification_count' => $not_count, 'to_id' => $to_id),
                ));
            } else {
                
            }
        }

//jsondata
    }

// business_profile post  like end
//business_profile comment insert start

    public function insert_commentthree() {
        $s3 = new S3(awsAccessKey, awsSecretKey);

        $userid = $this->session->userdata('aileenuser');

        $post_id = $_POST["post_id"];
        $post_comment = $_POST["comment"];

        $contition_array = array('business_profile_post_id' => $_POST["post_id"], 'status' => '1');
        $busdatacomment = $this->data['busdatacomment'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $data = array(
            'user_id' => $userid,
            'business_profile_post_id' => $post_id,
            'comments' => $post_comment,
            'created_date' => date('Y-m-d H:i:s', time()),
            'status' => '1',
            'is_delete' => '0'
        );


        $insert_id = $this->common->insert_data_getid($data, 'business_profile_post_comment');

// insert notification

        if ($busdatacomment[0]['user_id'] == $userid || $busdatacomment[0]['is_delete'] == '1') {
            
        } else {
            $notificationdata = array(
                'not_type' => '6',
                'not_from_id' => $userid,
                'not_to_id' => $busdatacomment[0]['user_id'],
                'not_read' => '2',
                'not_product_id' => $insert_id,
                'not_from' => '6',
                'not_img' => '1',
                'not_created_date' => date('Y-m-d H:i:s'),
                'not_active' => '1'
            );
            $insert_id_notification = $this->common->insert_data_getid($notificationdata, 'notification');

            if ($insert_id_notification) {

                $to_email_id = $this->db->select('contact_email')->get_where('business_profile', array('user_id' => $busdatacomment[0]['user_id']))->row()->contact_email;
                $email_html = '';
                $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;"><img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $this->data['business_login_user_image'] . '" width="50" height="50" alt="'. $this->data['business_login_user_image'] .'"></td>
                                            <td style="padding:5px;">
						<p><b>' . $this->data['business_login_company_name'] . '</b> is comment on your post in business profile.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a class="btn" href="' . BASEURL . 'notification/business-profile-post/' . $busdatacomment[0]['business_profile_post_id'] . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
                $subject = $this->data['business_login_company_name'] . ' is comment on your post in Aileensoul.';

                $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $to_email_id);
            }
        }
// end notification

        $contition_array = array('business_profile_post_id' => $_POST["post_id"], 'status' => '1');
        $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = 'business_profile_post_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('business_profile_post_id' => $_POST["post_id"], 'status' => '1');
        $buscmtcnt = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = 'business_profile_post_comment_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        foreach ($businessprofiledata as $business_profile) {
            $company_name = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id']))->row()->company_name;
            $companyslug = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id']))->row()->business_slug;
            $business_userimage = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id'], 'status' => '1'))->row()->business_user_image;
            $cmtinsert .= '<div class="all-comment-comment-box">';
            $cmtinsert .= '<div class="post-design-pro-comment-img">';
            if ($business_userimage != '') {
                if (IMAGEPATHFROM == 'upload') {
                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                        $cmtinsert .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                    } else {
                        $cmtinsert .= '<img  src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt="'. $business_userimage .'">';
                    }
                } else {
                    $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_userimage;
                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                    if (!$info) {
                        $cmtinsert .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                    } else {
                        $cmtinsert .= '<img  src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt="'. $business_userimage .'">';
                    }
                }
                $cmtinsert .= '</div>';
            } else {
                $cmtinsert .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                $cmtinsert .= '</div>';
            }
            $cmtinsert .= '<div class="comment-name"><a href="' . base_url() . 'business-profile/dashboard/' . $companyslug . '"><b>' . ucfirst($company_name) . '</b></a>';
            $cmtinsert .= '</div>';
            $cmtinsert .= '<div class="comment-details" id="showcomment' . $business_profile['business_profile_post_comment_id'] . '">';
            $cmtinsert .= $this->common->make_links($business_profile['comments']);
            $cmtinsert .= '</div>';

            $cmtinsert .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';
            $cmtinsert .= '<div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="' . $business_profile['business_profile_post_comment_id'] . '"  id="editcomment' . $business_profile['business_profile_post_comment_id'] . '" placeholder="Type Message ..." onkeyup="commentedit(' . $business_profile['business_profile_post_comment_id'] . ')" onclick="commentedit(' . $business_profile['business_profile_post_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $business_profile['comments'] . '</div>';
            $cmtinsert .= '<span class="comment-edit-button"><button id="editsubmit' . $business_profile['business_profile_post_comment_id'] . '" style="display:none" onClick="edit_comment(' . $business_profile['business_profile_post_comment_id'] . ')">Save</button></span>';
            $cmtinsert .= '</div></div>';

            $cmtinsert .= '<div class="art-comment-menu-design"><div class="comment-details-menu" id="likecomment1' . $business_profile['business_profile_post_comment_id'] . '">';
            $cmtinsert .= '<a id="' . $business_profile['business_profile_post_comment_id'] . '"';
            $cmtinsert .= 'onClick="comment_like1(this.id)">';

            $userid = $this->session->userdata('aileenuser');
            $contition_array = array('business_profile_post_comment_id' => $business_profile['business_profile_post_comment_id'], 'status' => '1');
            $businesscommentlike = $this->data['businesscommentlike'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $likeuserarray = explode(',', $businesscommentlike[0]['business_comment_like_user']);

            if (!in_array($userid, $likeuserarray)) {
                $cmtinsert .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
            } else {
                $cmtinsert .= '<i class="fa fa-thumbs-up" aria-hidden="true"></i>';
            }

            $cmtinsert .= '<span>';
            if ($business_profile['business_comment_likes_count'] > 0) {
                $cmtinsert .= ' ' . $business_profile['business_comment_likes_count'];
            }
            $cmtinsert .= '</span>';
            $cmtinsert .= '</a></div>';


            $userid = $this->session->userdata('aileenuser');
            if ($business_profile['user_id'] == $userid) {

                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';
                $cmtinsert .= '<div id="editcommentbox' . $business_profile['business_profile_post_comment_id'] . '"style="display:block;">';
                $cmtinsert .= '<a id="' . $business_profile['business_profile_post_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_editbox(this.id)" class="editbox">';
                $cmtinsert .= 'Edit';
                $cmtinsert .= '</a></div>';
                $cmtinsert .= '<div id="editcancle' . $business_profile['business_profile_post_comment_id'] . '"style="display:none;">';
                $cmtinsert .= '<a id="' . $business_profile['business_profile_post_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_editcancle(this.id)">';
                $cmtinsert .= 'Cancel';
                $cmtinsert .= '</a></div>';
                $cmtinsert .= '</div>';
            }

            $userid = $this->session->userdata('aileenuser');
            $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $business_profile['business_profile_post_id'], 'status' => '1'))->row()->user_id;
            if ($business_profile['user_id'] == $userid || $business_userid == $userid) {
                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';
                $cmtinsert .= '<input type="hidden" name="post_delete"';
                $cmtinsert .= 'id="post_delete' . $business_profile['business_profile_post_comment_id'] . '"';
                $cmtinsert .= 'value= "' . $business_profile['business_profile_post_id'] . '">';
                $cmtinsert .= '<a id="' . $business_profile['business_profile_post_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_delete(this.id)">';
                $cmtinsert .= 'Delete <span class="insertcomment' . $business_profile['business_profile_post_comment_id'] . '"></span>';
                $cmtinsert .= '</a></div>';
            }

            $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
            $cmtinsert .= '<div class="comment-details-menu">';
            $cmtinsert .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($business_profile['created_date']))) . '</p></div></div></div>';


// comment aount variable start
            $idpost = $business_profile['business_profile_post_id'];
            $cmtcount = '<a onClick="commentall(this.id)" id="' . $idpost . '">';
            $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
            $cmtcount .= ' ' . count($buscmtcnt) . '';
            $cmtcount .= '</i></a>';


            if (count($buscmtcnt) > 0) {
                $cntinsert .= '' . count($buscmtcnt) . '';
                $cntinsert .= '<span> Comment</span>';
            }

// comment count variable end 
        }

        // GET NOTIFICATION COUNT
        $to_id = $busdatacomment[0]['user_id'];
        $not_count = $this->business_notification_count($to_id);

        echo json_encode(
                array("comment" => $cmtinsert,
                    "count" => $cmtcount,
                    "comment_count" => $cntinsert,
                    "status" => 'success',
                    "notification" => array('notification_count' => $not_count, 'to_id' => $to_id),
        ));
    }

    public function insert_comment() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        $post_id = $_POST["post_id"];
        $post_comment = $_POST["comment"];

        $contition_array = array('business_profile_post_id' => $_POST["post_id"], 'status' => '1');
        $busdatacomment = $this->data['busdatacomment'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $data = array(
            'user_id' => $userid,
            'business_profile_post_id' => $post_id,
            'comments' => $post_comment,
            'created_date' => date('Y-m-d H:i:s', time()),
            'status' => '1',
            'is_delete' => '0'
        );

        $insert_id = $this->common->insert_data_getid($data, 'business_profile_post_comment');

// insert notification
        if ($busdatacomment[0]['user_id'] == $userid || $busdatacomment[0]['is_delete'] == '1') {
            
        } else {
            $notificationdata = array(
                'not_type' => '6',
                'not_from_id' => $userid,
                'not_to_id' => $busdatacomment[0]['user_id'],
                'not_read' => '2',
                'not_product_id' => $insert_id,
                'not_from' => '6',
                'not_img' => '1',
                'not_created_date' => date('Y-m-d H:i:s'),
                'not_active' => '1'
            );
            $insert_id_notification = $this->common->insert_data_getid($notificationdata, 'notification');

            if ($insert_id_notification) {

                $to_email_id = $this->db->select('contact_email')->get_where('business_profile', array('user_id' => $busdatacomment[0]['user_id']))->row()->contact_email;
                $email_html = '';
                $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;"><img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $this->data['business_login_user_image'] . '" width="50" height="50" alt="'. $this->data['business_login_user_image'] . '"></td>
                                            <td style="padding:5px;">
						<p><b>' . $this->data['business_login_company_name'] . '</b> is comment on your post in business profile.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a class="btn" href="' . BASEURL . 'notification/business-profile-post/' . $busdatacomment[0]['business_profile_post_id'] . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
                $subject = $this->data['business_login_company_name'] . ' is comment on your post in Aileensoul.';

                $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $to_email_id);
            }
        }
// end notification



        $contition_array = array('business_profile_post_id' => $_POST["post_id"], 'status' => '1');
        $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = 'business_profile_post_comment_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
// khyati changes start
        $cmtinsert = '<div class="hidebottombordertwo insertcommenttwo' . $post_id . '">';
        foreach ($businessprofiledata as $business_profile) {
            $company_name = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id']))->row()->company_name;
            $companyslug = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id']))->row()->business_slug;
            $business_userimage = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id'], 'status' => '1'))->row()->business_user_image;

            $cmtinsert .= '<div class="all-comment-comment-box">';
            $cmtinsert .= '<div class="post-design-pro-comment-img">';
            if ($business_userimage) {
                if (IMAGEPATHFROM == 'upload') {
                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                        $cmtinsert .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                    } else {
                        $cmtinsert .= '<img  src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt="'. $business_userimage .'">';
                    }
                } else {
                    $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_userimage;
                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                    if (!$info) {
                        $cmtinsert .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                    } else {
                        $cmtinsert .= '<img  src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt="'. $business_userimage .'">';
                    }
                }
                $cmtinsert .= '</div>';
            } else {


                $cmtinsert .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                $cmtinsert .= '</div>';
            }
            $cmtinsert .= '<div class="comment-name"><a href="' . base_url() . 'business-profile/dashboard/' . $companyslug . '"><b>' . ucfirst($company_name) . '</b></a>';
            $cmtinsert .= '</div>';
            $cmtinsert .= '<div class="comment-details" id= "showcommenttwo' . $business_profile['business_profile_post_comment_id'] . '" >';
            $cmtinsert .= $this->common->make_links($business_profile['comments']);
            $cmtinsert .= '</div>';
            $cmtinsert .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';
            $cmtinsert .= '<div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="' . $business_profile['business_profile_post_comment_id'] . '"  id="editcommenttwo' . $business_profile['business_profile_post_comment_id'] . '" placeholder="Type Message ..." onkeyup="commentedittwo(' . $business_profile['business_profile_post_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $business_profile['comments'] . '</div>';
            $cmtinsert .= '<span class="comment-edit-button"><button id="editsubmittwo' . $business_profile['business_profile_post_comment_id'] . '" style="display:none" onclick="edit_commenttwo(' . $business_profile['business_profile_post_comment_id'] . ')">Save</button></span>';
            $cmtinsert .= '</div></div>';
            $cmtinsert .= '<div class="art-comment-menu-design"><div class="comment-details-menu" id="likecomment1' . $business_profile['business_profile_post_comment_id'] . '">';
            $cmtinsert .= '<a id="' . $business_profile['business_profile_post_comment_id'] . '"';
            $cmtinsert .= 'onClick="comment_like1(this.id)">';

            $userid = $this->session->userdata('aileenuser');
            $contition_array = array('business_profile_post_comment_id' => $business_profile['business_profile_post_comment_id'], 'status' => '1');
            $businesscommentlike = $this->data['businesscommentlike'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $likeuserarray = explode(',', $businesscommentlike[0]['business_comment_like_user']);

            if (!in_array($userid, $likeuserarray)) {
                $cmtinsert .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
            } else {
                $cmtinsert .= '<i class="fa fa-thumbs-up" aria-hidden="true"></i>';
            }

            $cmtinsert .= '<span>';
            if ($business_profile['business_comment_likes_count'] > 0) {
                $cmtinsert .= ' ' . $business_profile['business_comment_likes_count'];
            }
            $cmtinsert .= '</span>';
            $cmtinsert .= '</a></div>';

            $userid = $this->session->userdata('aileenuser');
            if ($business_profile['user_id'] == $userid) {

                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';


                $cmtinsert .= '<div id="editcommentboxtwo' . $business_profile['business_profile_post_comment_id'] . '"style="display:block;">';

                $cmtinsert .= '<a id="' . $business_profile['business_profile_post_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_editboxtwo(this.id)">';
                $cmtinsert .= 'Edit';
                $cmtinsert .= '</a></div>';

                $cmtinsert .= '<div id="editcancletwo' . $business_profile['business_profile_post_comment_id'] . '"style="display:none;">';

                $cmtinsert .= '<a id="' . $business_profile['business_profile_post_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_editcancletwo(this.id)">';
                $cmtinsert .= 'Cancel';
                $cmtinsert .= '</a></div>';

                $cmtinsert .= '</div>';
            }




            $userid = $this->session->userdata('aileenuser');

            $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $business_profile['business_profile_post_id'], 'status' => '1'))->row()->user_id;


            if ($business_profile['user_id'] == $userid || $business_userid == $userid) {

                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';


                $cmtinsert .= '<input type="hidden" name="post_deletetwo"';
                $cmtinsert .= 'id="post_deletetwo' . $business_profile['business_profile_post_comment_id'] . '"';
                $cmtinsert .= 'value= "' . $business_profile['business_profile_post_id'] . '">';
                $cmtinsert .= '<a id="' . $business_profile['business_profile_post_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_deletetwo(this.id)">';
                $cmtinsert .= 'Delete';
                $cmtinsert .= '</a></div>';
            }

            $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
            $cmtinsert .= '<div class="comment-details-menu">';
            $cmtinsert .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($business_profile['created_date']))) . '</p></div></div></div>';


// comment aount variable start
            $idpost = $business_profile['business_profile_post_id'];
            $cmtcount = '<a onClick="commentall(this.id)" id="' . $idpost . '">';
            $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
            $cmtcount .= ' ' . count($businessprofiledata) . '';
            $cmtcount .= '</i></a>';



// comment count variable end 
        }
        if (count($businessprofiledata) > 0) {
            $cntinsert .= '' . count($businessprofiledata) . '';
            $cntinsert .= '<span> Comment</span>';
        }

        // GET NOTIFICATION COUNT
        $to_id = $busdatacomment[0]['user_id'];
        // $not_count = $this->business_notification_count($to_id);
        $not_count = $this->business_notification_count($to_id);


//        echo $cmtinsert;
        echo json_encode(
                array("comment" => $cmtinsert,
                    "count" => $cmtcount,
                    "comment_count" => $cntinsert,
                    "status" => 'success',
                    "notification" => array('notification_count' => $not_count, 'to_id' => $to_id),
        ));

// khyati chande 
    }

//business_profile comment insert end  
//business_profile comment edit start
    public function edit_comment_insert() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        $post_id = $_POST["post_id"];
        $post_comment = $_POST["comment"];

        $data = array(
            'comments' => $post_comment,
            'modify_date' => date('y-m-d h:i:s')
        );


        $updatdata = $this->common->update_data($data, 'business_profile_post_comment', 'business_profile_post_comment_id', $post_id);
        if ($updatdata) {

            $contition_array = array('business_profile_post_comment_id' => $_POST["post_id"], 'status' => '1');
            $businessprofiledata = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = 'comments', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $cmtlike = '<div>';
            $cmtlike .= $this->common->make_links($businessprofiledata[0]['comments']);
            $cmtlike .= '</div>';
            echo $cmtlike;
        }
    }

//business_profile like commnet ajax end 
// click on post after post open on new page start

    public function postnewpage($slug_id = '', $id = '') {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $this->business_profile_active_check();
        $this->is_business_profile_register();

        $this->data['post_id'] = $id;

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['businessdata'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('business_profile_post_id' => $id, 'status' => '1');
        $this->data['busienss_data'] = $busienss_data = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $company_name = $this->get_company_name($slug_id);
        $this->data['title'] = ucwords($company_name) . ' | Post Detail' . ' | Business Profile' . TITLEPOSTFIX;
        $this->data['business_left'] = $this->load->view('business_profile/business_left', $this->data, true);

        $this->load->view('business_profile/postnewpage', $this->data);
    }

// click on post after post open on new page end 
//edit post start

    public function edit_post_insert() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        $post_id = $_POST["business_profile_post_id"];
        $business_post = $_POST["product_name"];
        $business_description = $_POST["product_description"];
        $business_description = strip_tags($business_description); // THIS LINE ADD FOR REMOVE A LINK WHEN DISPLAY ANY WEBSITE @Ankit
        $data = array(
            'product_name' => $business_post,
            'product_description' => $business_description,
            'modify_date' => date('Y-m-d h:i:s')
        );

        $updatdata = $this->common->update_data($data, 'business_profile_post', 'business_profile_post_id', $post_id);
        if ($updatdata) {

            $contition_array = array('business_profile_post_id' => $_POST["business_profile_post_id"], 'status' => '1');
            $businessdata = $this->data['businessdata'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($this->data['businessdata'][0]['product_name']) {
                $editpost = '<a>';
                $editpost .= $businessdata[0]['product_name'] . "";
                $editpost .= '</a>';
            }
            if ($this->data['businessdata'][0]['product_description']) {
                $small = substr($businessdata[0]['product_description'], 0, 180);
                $editpostdes .= nl2br($this->common->make_links($small));
                if (strlen($businessdata[0]['product_description']) > 180) {
                    $editpostdes .= '...<span id="kkkk" onClick="khdiv(' . $_POST["business_profile_post_id"] . ')">View More</div>';
                }
            }

            $postname = '<p title="' . $businessdata[0]['product_name'] . '">' . $businessdata[0]['product_name'] . '</p>';
//echo $editpost;   echo $editpostdes;
            echo json_encode(
                    array("title" => $editpost,
                        "description" => $editpostdes,
                        "postname" => $postname));
        }
    }

//edit post end
//reactivate account start

    public function reactivate() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        $data = array(
            'status' => '1',
            'modified_date' => date('y-m-d h:i:s')
        );

        $updatdata = $this->common->update_data($data, 'business_profile', 'user_id', $userid);
        if ($updatdata) {
            redirect('business-profile/home', refresh);
        } else {
            $this->data['title'] = 'Reactive | ' . ' Business Profile' . TITLEPOSTFIX;
            $this->load->view('business_profile/reactivate', $this->data);
        }
    }

//reactivate accont end    
//delete post particular user start
    public function del_particular_userpost() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $post_id = $_POST['business_profile_post_id'];
        $contition_array = array('business_profile_post.business_profile_post_id' => $post_id, 'business_profile_post.status' => '1');

        $join_str[0]['table'] = 'business_profile';
        $join_str[0]['join_table_id'] = 'business_profile.user_id';
        $join_str[0]['from_table_id'] = 'business_profile_post.user_id';
        $join_str[0]['join_type'] = '';

        $businessdata = $this->data['businessdata'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = 'business_profile_post.delete_post,business_profile.business_profile_id,business_profile.industriyal', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

        $likeuserarray = explode(',', $businessdata[0]['delete_post']);
        $user_array = array_push($likeuserarray, $userid);

        if ($businessdata[0]['delete_post'] == 0) {
            $userid = implode('', $likeuserarray);
        } else {
            $userid = implode(',', $likeuserarray);
        }

        $data = array(
            'delete_post' => $userid,
            'modify_date' => date('Y-m-d H:i:s')
        );

        $updatdata = $this->common->update_data($data, 'business_profile_post', 'business_profile_post_id', $post_id);
        $business_profile_id = $businessdata[0]['business_profile_id'];

// for post count start
        $contition_array = array('follow_from' => $business_profile_id, 'follow_status' => '1', 'follow_type' => '2');
        $followerdata = $this->data['followerdata'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        foreach ($followerdata as $fdata) {
            $contition_array = array('business_profile_id' => $fdata['follow_to'], 'business_step' => '4');
            $this->data['business_data'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $business_userid = $this->data['business_data'][0]['user_id'];
            $contition_array = array('user_id' => $business_userid, 'status' => '1', 'is_delete' => '0');
            $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $followerabc[] = $this->data['business_profile_data'];
        }
//data fatch using follower end
//data fatch using industriyal start

        $userselectindustriyal = $businessdata[0]['industriyal'];
        $contition_array = array('industriyal' => $userselectindustriyal, 'status' => '1', 'business_step' => '4');
        $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        foreach ($businessprofiledata as $fdata) {
            $contition_array = array('business_profile_post.user_id' => $fdata['user_id'], 'business_profile_post.status' => '1', 'business_profile_post.user_id !=' => $userid, 'is_delete' => '0');
            $this->data['business_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $industriyalabc[] = $this->data['business_data'];
        }
//data fatch using industriyal end
//data fatch using login user last post start

        $condition_array = array('user_id' => $userid, 'status' => '1', 'is_delete' => '0');
        $business_datauser = $this->data['business_datauser'] = $this->common->select_data_by_condition('business_profile_post', $condition_array, $data = '*', $sortby = 'business_profile_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $userabc[][] = $this->data['business_datauser'][0];

//data fatch using login user last post end
//array merge and get unique value  

        if (count($industriyalabc) == 0 && count($business_datauser) != 0) {
            $unique = $userabc;
        } elseif (count($business_datauser) == 0 && count($industriyalabc) != 0) {
            $unique = $industriyalabc;
        } elseif (count($business_datauser) != 0 && count($industriyalabc) != 0) {
            $unique = array_merge($industriyalabc, $userabc);
        }

        if (count($followerabc) == 0 && count($unique) != 0) {
            $unique_user = $unique;
        } elseif (count($unique) == 0 && count($followerabc) != 0) {
            $unique_user = $followerabc;
        } else {
            $unique_user = array_merge($unique, $followerabc);
        }

        foreach ($unique_user as $ke => $arr) {
            foreach ($arr as $k => $v) {
                $postdata[] = $v;
            }
        }
        $postdata = array_unique($postdata, SORT_REGULAR);
        $new = array();
        foreach ($postdata as $value) {
            $new[$value['business_profile_post_id']] = $value;
        }
        $post = array();
        foreach ($new as $key => $row) {
            $post[$key] = $row['business_profile_post_id'];
        }
        array_multisort($post, SORT_DESC, $new);
        $otherdata = $new;
// for count end

        if (count($otherdata) > 0) {
            foreach ($otherdata as $row) {
                $userid = $this->session->userdata('aileenuser');
                $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1');
                $businessdelete = $this->data['businessdelete'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $contition_array = array('user_id' => $row['user_id'], 'status' => '1');
                $businessdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $likeuserarray = explode(',', $businessdelete[0]['delete_post']);
                if (!in_array($userid, $likeuserarray)) {
                    
                } else {
                    $count[] = "abc";
                }
            }
        }

//        if (count($otherdata) > 0) {
//            if (count($count) == count($otherdata)) {
//                $datacount = "count";
//                $notfound = '<div class="contact-frnd-post bor_none">';
//                $notfound .= '<div class="text-center rio">';
//                $notfound .= '<h4 class="page-heading  product-listing">No Data Found.</h4>';
//                $notfound .= '</div></div>';
//            }
//        } else {
//            $datacount = "count";
//            $notfound = '<div class="contact-frnd-post bor_none">';
//            $notfound .= '<div class="text-center rio">';
//            $notfound .= '<h4 class="page-heading  product-listing">No Data Found.</h4>';
//            $notfound .= '</div></div>';
//        }
        echo json_encode(
                array(
                    "notfound" => $notfound,
                    "notcount" => $datacount,
        ));
    }

//delete post particular user end  
//multiple image for manage user start


    public function business_photos($id) {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $this->business_profile_active_check();
        $this->is_business_profile_register();

        $contition_array = array('user_id' => $userid, 'status' => '1');

        $slug_data = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $slug_id = $slug_data[0]['business_slug'];
        if ($id == $slug_id || $id == '') {

            $contition_array = array('business_slug' => $slug_id, 'status' => '1', 'business_step' => '4');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $join_str[0]['table'] = 'post_files';
            $join_str[0]['join_table_id'] = 'post_files.post_id';
            $join_str[0]['from_table_id'] = 'business_profile_post.business_profile_post_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'insert_profile' => '2', 'status' => '1', 'is_delete' => '0');
            $data = 'business_profile_post_id, post_files_id, file_name';

            $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data, $sortby = 'post_files.created_date', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
        } else {

            $contition_array = array('business_slug' => $id, 'status' => '1', 'business_step' => '4');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $join_str[0]['table'] = 'post_files';
            $join_str[0]['join_table_id'] = 'post_files.post_id';
            $join_str[0]['from_table_id'] = 'business_profile_post.business_profile_post_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'insert_profile' => '2', 'status' => '1', 'is_delete' => '0');
            $data = 'business_profile_post_id, post_files_id, file_name';
            $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data, $sortby = 'post_files.created_date', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
        }
        $company_name = $this->get_company_name($slug_id);
        $this->data['title'] = ucwords($company_name) .' | Photo' .  ' | Business Profile' . TITLEPOSTFIX;

        $this->data['file_header'] = $this->load->view('business_profile/file_header', $this->data, true);
        $this->load->view('business_profile/business_photos', $this->data);
    }

//multiple iamge for manage user end   
//multiple video for manage user start


    public function business_videos($id) {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        $this->business_profile_active_check();
        $this->is_business_profile_register();

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $slug_data = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $slug_id = $slug_data[0]['business_slug'];
        if ($id == $slug_id || $id == '') {

            $contition_array = array('business_slug' => $slug_id, 'status' => '1', 'business_step' => '4');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'status' => '1', 'is_delete' => '0');
            $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {

            $contition_array = array('business_slug' => $id, 'status' => '1', 'business_step' => '4');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'status' => '1', 'is_delete' => '0');
            $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }
        $this->data['file_header'] = $this->load->view('business_profile/file_header', $this->data, true);
        $company_name = $this->get_company_name($slug_id);
        $this->data['title'] = ucwords($company_name) . ' | Video' . ' | Business Profile' . TITLEPOSTFIX;
        $this->load->view('business_profile/business_videos', $this->data);
    }

//multiple video for manage user end 
//multiple audio for manage user start


    public function business_audios($id) {
        $s3 = new S3(awsAccessKey, awsSecretKey);

        $userid = $this->session->userdata('aileenuser');
        $this->business_profile_active_check();
        $this->is_business_profile_register();

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $slug_data = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $slug_id = $slug_data[0]['business_slug'];
        if ($id == $slug_id || $id == '') {

            $contition_array = array('business_slug' => $slug_id, 'status' => '1', 'business_step' => '4');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'status' => '1', 'is_delete' => '0');
            $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {

            $contition_array = array('business_slug' => $id, 'status' => '1', 'business_step' => '4');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'status' => '1', 'is_delete' => '0');
            $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }
        $this->data['file_header'] = $this->load->view('business_profile/file_header', $this->data, true);
        $company_name = $this->get_company_name($slug_id);
        $this->data['title'] = ucwords($company_name) . ' | Audio' . ' | Business Profile' . TITLEPOSTFIX;
        $this->load->view('business_profile/business_audios', $this->data);
    }

//multiple audio for manage user end   
//multiple pdf for manage user start


    public function business_pdf($id) {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        $this->business_profile_active_check();
        $this->is_business_profile_register();

        $contition_array = array('user_id' => $userid, 'status' => '1', 'business_step' => '4');
        $slug_data = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $slug_id = $slug_data[0]['business_slug'];
        if ($id == $slug_id || $id == '') {

            $contition_array = array('business_slug' => $slug_id, 'status' => '1');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'status' => '1', 'is_delete' => '0');

            $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {

            $contition_array = array('business_slug' => $id, 'status' => '1', 'business_step' => '4');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'status' => '1', 'is_delete' => '0');
            $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }
        $this->data['file_header'] = $this->load->view('business_profile/file_header', $this->data, true);
        $company_name = $this->get_company_name($slug_id);
        $this->data['title'] = ucwords($company_name) . ' | PDF' . ' | Business Profile' . TITLEPOSTFIX;
        $this->load->view('business_profile/business_pdf', $this->data);
    }

//multiple pdf for manage user end 
//multiple images like start
    public function mulimg_like() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $post_image = $_POST['post_image_id'];
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('post_image_id' => $post_image, 'user_id' => $userid);
        $likeuser = $this->data['likeuser'] = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('post_files_id' => $post_image);
        $likeuserid = $this->data['likeuserid'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('business_profile_post_id' => $likeuserid[0]['post_id']);
        $likepostid = $this->data['likepostid'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if (!$likeuser) {
            $data = array(
                'post_image_id' => $post_image,
                'user_id' => $userid,
                'created_date' => date('Y-m-d H:i:s', time()),
                'is_unlike' => '0'
            );
            $insertdata = $this->common->insert_data_getid($data, 'bus_post_image_like');
// insert notification
            if ($likepostid[0]['user_id'] == $userid) {
                
            } else {

                $data = array(
                    'not_type' => '5',
                    'not_from_id' => $userid,
                    'not_to_id' => $likepostid[0]['user_id'],
                    'not_read' => '2',
                    'not_product_id' => $post_image,
                    'not_from' => '6',
                    'not_img' => '5',
                    'not_created_date' => date('Y-m-d H:i:s'),
                    'not_active' => '1'
                );

                $insert_id = $this->common->insert_data_getid($data, 'notification');

                if ($insert_id) {

                    $to_email_id = $this->db->select('contact_email')->get_where('business_profile', array('user_id' => $likepostid[0]['user_id']))->row()->contact_email;
                    $email_html = '';
                    $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;"><img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $this->data['business_login_user_image'] . '" width="50" height="50" alt="'. $this->data['business_login_user_image'] .'"></td>
                                            <td style="padding:5px;">
						<p><b>' . $this->data['business_login_company_name'] . '</b> is like your photo in business profile.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a class="btn" href="' . BASEURL . 'notification/business-profile-post-detail/' . $likepostid[0]['business_profile_post_id'] . '/' . $post_image . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
                    $subject = $this->data['business_login_company_name'] . ' is like your photo in Aileensoul.';

                    $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $to_email_id);
                }
            }
// end notification


            $contition_array = array('post_image_id' => $_POST["post_image_id"], 'is_unlike' => '0');
            $bdata1 = $this->data['bdata1'] = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($insertdata) {

                $imglike = '<li>';
                $imglike .= '<a id="' . $post_image . '" onClick="mulimg_like(this.id)">';
                $imglike .= ' <i class="fa fa-thumbs-up main_color" aria-hidden="true">';
                $imglike .= '</i>';
                $imglike .= '<span> ';
                $imglike .= '</span>';
                $imglike .= '</a>';
                $imglike .= '</li>';

                $contition_array = array('post_image_id' => $post_image, 'is_unlike' => '0');
                $commneteduser = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = 'post_image_like_id,post_image_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                $countlike = count($commneteduser) - 1;
                foreach ($commneteduser as $userdata) {
                    $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $userdata['user_id'], 'status' => '1'))->row()->company_name;
                }
                $imglikeuser .= '<div class="like_one_other_img">';
                $imglikeuser .= '<a href="javascript:void(0);"  onclick="likeuserlistimg(' . $post_image . ');">';

                $contition_array = array('post_image_id' => $post_image, 'is_unlike' => '0');
                $commneteduser = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = 'post_image_like_id,post_image_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $countlike = count($commneteduser) - 1;
                $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $commneteduser[0]['user_id'], 'status' => '1'))->row()->company_name;


                if ($userid == $commneteduser[0]['user_id']) {

                    $imglikeuser .= 'You ';
                } else {

                    $imglikeuser .= '' . ucfirst($business_fname1) . '&nbsp;';
                }

                if (count($commneteduser) > 1) {

                    $imglikeuser .= 'and';
                    $imglikeuser .= ' ' . $countlike . ' others';
                }
                $imglikeuser .= '</a>';
                $cmtlikeuser .= '</div>';
                $like_user_count = '<span class="comment_like_count">';
                if (count($commneteduser) > 0) {
                    $like_user_count .= '' . count($commneteduser) . '';
                    $like_user_count .= '</span>';
                    $like_user_count .= '<span> Like</span>';
                }

                // GET NOTIFICATION COUNT
                $to_id = $likepostid[0]['user_id'];
                $not_count = $this->business_notification_count($to_id);

                echo json_encode(
                        array("like" => $imglike,
                            "likeuser" => $imglikeuser,
                            "like_user_count" => $like_user_count,
                            "like_user_total_count" => count($commneteduser),
                            "status" => 'success',
                            "notification" => array('notification_count' => $not_count, 'to_id' => $to_id),
                ));
            }
        } else {

            if ($likeuser[0]['is_unlike'] == 0) {
                $data = array(
                    'modify_date' => date('Y-m-d', time()),
                    'is_unlike' => '1'
                );

                $this->db->where('post_image_id', $post_image);
                $this->db->where('user_id', $userid);
                $updatdata = $this->db->update('bus_post_image_like', $data);

                $contition_array = array('post_image_id' => $_POST["post_image_id"], 'is_unlike' => '0');
                $bdata2 = $this->data['bdata2'] = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($updatdata) {

                    $imglike1 = '<li>';
                    $imglike1 .= '<a id="' . $post_image . '" onClick="mulimg_like(this.id)">';
                    $imglike1 .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true">';
                    $imglike1 .= '</i>';
                    $imglike1 .= '<span>';
                    $imglike1 .= '</span>';
                    $imglike1 .= '</a>';
                    $imglike1 .= '</li>';

                    $contition_array = array('post_image_id' => $post_image, 'is_unlike' => '0');
                    $commneteduser = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = 'post_image_like_id,post_image_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    $countlike = count($commneteduser) - 1;
                    foreach ($commneteduser as $userdata) {
                        $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $userdata['user_id'], 'status' => '1'))->row()->company_name;
                    }

                    $imglikeuser1 .= '<div class="like_one_other_img">';
                    $imglikeuser1 .= '<a href="javascript:void(0);"  onclick="likeuserlistimg(' . $post_image . ');">';

                    $contition_array = array('post_image_id' => $post_image, 'is_unlike' => '0');
                    $commneteduser = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = 'post_image_like_id,post_image_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $countlike = count($commneteduser) - 1;
                    $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $commneteduser[0]['user_id'], 'status' => '1'))->row()->company_name;


                    if ($userid == $commneteduser[0]['user_id']) {

                        $imglikeuser1 .= 'You ';
                    } else {
                        $imglikeuser1 .= '' . ucfirst($business_fname1) . '&nbsp;';
                    }

                    if (count($commneteduser) > 1) {

                        $imglikeuser1 .= 'and';
                        $imglikeuser1 .= ' ' . $countlike . ' others';
                    }


                    $imglikeuser1 .= '</a>';
                    $imglikeuser1 .= '</div>';
// $like_user_count1 = count($commneteduser);

                    $like_user_count1 = '<span class="comment_like_count">';
                    if (count($commneteduser) > 0) {
                        $like_user_count1 .= '' . count($commneteduser) . '';
                        $like_user_count1 .= '</span>';
                        $like_user_count1 .= '<span> Like</span>';
                    }

                    $to_id = $likepostid[0]['user_id'];
                    $not_count = $this->business_notification_count($to_id);


                    echo json_encode(
                            array("like" => $imglike1,
                                "likeuser" => $imglikeuser1,
                                "like_user_count" => $like_user_count1,
                                "like_user_total_count" => count($commneteduser),
                                "status" => 'success',
                                "notification" => array('notification_count' => $not_count, 'to_id' => $to_id),
                    ));
                }
            } else {
                $data = array(
                    'modify_date' => date('Y-m-d', time()),
                    'is_unlike' => '0'
                );

                $this->db->where('post_image_id', $post_image);
                $this->db->where('user_id', $userid);
                $updatdata = $this->db->update('bus_post_image_like', $data);
// insert notification
                if ($likepostid[0]['user_id'] == $userid) {
                    
                } else {
                    $contition_array = array('not_type' => '5', 'not_from_id' => $userid, 'not_to_id' => $likepostid[0]['user_id'], 'not_product_id' => $post_image, 'not_from' => '6', 'not_img' => '5');
                    $busnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    if ($busnotification[0]['not_read'] == 2) {
                        
                    } elseif ($busnotification[0]['not_read'] == 1) {

                        $datalike = array(
                            'not_read' => '2'
                        );

                        $where = array('not_type' => '5', 'not_from_id' => $userid, 'not_to_id' => $likepostid[0]['user_id'], 'not_product_id' => $post_image, 'not_from' => '6', 'not_img' => '5');
                        $this->db->where($where);
                        $updatdata = $this->db->update('notification', $datalike);
                    } else {
                        $data = array(
                            'not_type' => '5',
                            'not_from_id' => $userid,
                            'not_to_id' => $likepostid[0]['user_id'],
                            'not_read' => '2',
                            'not_product_id' => $post_image,
                            'not_from' => '6',
                            'not_img' => '5',
                            'not_created_date' => date('Y-m-d H:i:s'),
                            'not_active' => '1'
                        );

                        $insert_id = $this->common->insert_data_getid($data, 'notification');

                        if ($insert_id) {

                            $to_email_id = $this->db->select('contact_email')->get_where('business_profile', array('user_id' => $likepostid[0]['user_id']))->row()->contact_email;
                            $email_html = '';
                            $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;"><img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $this->data['business_login_user_image'] . '" width="50" height="50" alt="'. $this->data['business_login_user_image'] .'"></td>
                                            <td style="padding:5px;">
						<p><b>' . $this->data['business_login_company_name'] . '</b> is like your photo in business profile.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a class="btn" href="' . BASEURL . 'notification/business-profile-post-detail/' . $likepostid[0]['business_profile_post_id'] . '/' . $post_image . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
                            $subject = $this->data['business_login_company_name'] . ' is like your photo in Aileensoul.';

                            $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $to_email_id);
                        }
                    }
                }
// end notification

                $contition_array = array('post_image_id' => $_POST["post_image_id"], 'is_unlike' => '0');
                $bdata2 = $this->data['bdata2'] = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($updatdata) {

                    $imglike1 = '<li>';
                    $imglike1 .= '<a id="' . $post_image . '" onClick="mulimg_like(this.id)">';
                    $imglike1 .= '<i class="fa fa-thumbs-up main_color" aria-hidden="true">';
                    $imglike1 .= '</i>';
                    $imglike1 .= '<span> ';
                    $imglike1 .= '</span>';
                    $imglike1 .= '</a>';
                    $imglike1 .= '</li>';

                    $contition_array = array('post_image_id' => $post_image, 'is_unlike' => '0');
                    $commneteduser = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = 'post_image_like_id,post_image_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    $countlike = count($commneteduser) - 1;
                    foreach ($commneteduser as $userdata) {
                        $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $userdata['user_id'], 'status' => '1'))->row()->company_name;
                    }
                    $imglikeuser1 .= '<div class="like_one_other_img">';
                    $imglikeuser1 .= '<a href="javascript:void(0);"  onclick="likeuserlistimg(' . $post_image . ');">';

                    $contition_array = array('post_image_id' => $post_image, 'is_unlike' => '0');
                    $commneteduser = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = 'post_image_like_id,post_image_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $countlike = count($commneteduser) - 1;
                    $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $commneteduser[0]['user_id'], 'status' => '1'))->row()->company_name;

                    if ($userid == $commneteduser[0]['user_id']) {
                        $imglikeuser1 .= 'You ';
                    } else {
                        $imglikeuser1 .= '' . ucfirst($business_fname1) . '&nbsp;';
                    }

                    if (count($commneteduser) > 1) {
                        $imglikeuser1 .= 'and';
                        $imglikeuser1 .= ' ' . $countlike . ' others';
                    }

                    $imglikeuser1 .= '</a>';
                    $imglikeuser1 .= '</div>';

                    $like_user_count1 = '<span class="comment_like_count">';
                    if (count($commneteduser) > 0) {
                        $like_user_count1 .= '' . count($commneteduser) . '';
                        $like_user_count1 .= '</span>';
                        $like_user_count1 .= '<span> Like</span>';
                    }

                    $to_id = $likepostid[0]['user_id'];
                    $not_count = $this->business_notification_count($to_id);


                    echo json_encode(
                            array("like" => $imglike1,
                                "likeuser" => $imglikeuser1,
                                "like_user_count" => $like_user_count1,
                                "status" => 'success',
                                "notification" => array('notification_count' => $not_count, 'to_id' => $to_id),
                    ));
                }
            }
        }
    }

//multiple iamges like end 
//multiple images comment strat

    public function pnmulimg_comment() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $post_image_id = $_POST["post_image_id"];
        $post_comment = $_POST["comment"];

        $contition_array = array('post_files_id' => $_POST["post_image_id"], 'is_deleted' => '1');
        $busimg = $this->data['busimg'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('business_profile_post_id' => $busimg[0]["post_id"], 'is_delete' => '0');
        $buspostid = $this->data['buspostid'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $data = array(
            'user_id' => $userid,
            'post_image_id' => $post_image_id,
            'comment' => $post_comment,
            'created_date' => date('Y-m-d H:i:s', time()),
            'is_delete' => '0'
        );
        $insert_id = $this->common->insert_data_getid($data, 'bus_post_image_comment');

// insert notification

        if ($buspostid[0]['user_id'] == $userid) {
            
        } else {
            $datanotification = array(
                'not_type' => '6',
                'not_from_id' => $userid,
                'not_to_id' => $buspostid[0]['user_id'],
                'not_read' => '2',
                'not_product_id' => $insert_id,
                'not_from' => '6',
                'not_img' => '4',
                'not_created_date' => date('Y-m-d H:i:s'),
                'not_active' => '1'
            );

            $insert_id_notification = $this->common->insert_data_getid($datanotification, 'notification');
            if ($insert_id_notification) {
                $to_email_id = $this->db->select('contact_email')->get_where('business_profile', array('user_id' => $buspostid[0]['user_id']))->row()->contact_email;
                $email_html = '';
                $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;"><img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $this->data['business_login_user_image'] . '" width="50" height="50" alt="'. $this->data['business_login_user_image'] .'"></td>
                                            <td style="padding:5px;">
						<p><b>' . $this->data['business_login_company_name'] . '</b> is comment on your photo in business profile.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a class="btn" href="' . BASEURL . 'notification/business-profile-post-detail/' . $buspostid[0]['business_profile_post_id'] . '/' . $post_image_id . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
                $subject = $this->data['business_login_company_name'] . ' is comment on your photo in Aileensoul.';

                $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $to_email_id);
            }
        }
// end notification


        $contition_array = array('post_image_id' => $post_image_id, 'is_delete' => '0');
        $businesscomment = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('post_image_id' => $post_image_id, 'is_delete' => '0');
        $buscmtcnt = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $cmtinsert .= '<div class="insertimgcommenttwo' . $post_image_id . '">';

        foreach ($businesscomment as $bus_comment) {
            $company_name = $this->db->get_where('business_profile', array('user_id' => $bus_comment['user_id']))->row()->company_name;
            $companyslug = $this->db->get_where('business_profile', array('user_id' => $bus_comment['user_id']))->row()->business_slug;
            $business_userimage = $this->db->get_where('business_profile', array('user_id' => $bus_comment['user_id'], 'status' => '1'))->row()->business_user_image;
            $cmtinsert .= '<div class="all-comment-comment-box">';
            $cmtinsert .= '<div class="post-design-pro-comment-img">';
            if ($business_userimage != '') {
                if (IMAGEPATHFROM == 'upload') {
                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                        $cmtinsert .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                    } else {
                        $cmtinsert .= '<img  src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt="'. $business_userimage .'">';
                    }
                } else {
                    $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_userimage;
                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                    if (!$info) {
                        $cmtinsert .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                    } else {
                        $cmtinsert .= '<img  src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt="'. $business_userimage .'">';
                    }
                }
                $cmtinsert .= '</div>';
            } else {

                $cmtinsert .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                $cmtinsert .= '</div>';
            }
            $cmtinsert .= '<div class="comment-name"><a href="' . base_url() . 'business-profile/dashboard/' . $companyslug . '"><b>' . $company_name . '</b></a>';
            $cmtinsert .= '</div>';

            $cmtinsert .= '<div class="comment-details" id= "imgshowcommenttwo' . $bus_comment['post_image_comment_id'] . '"" >';
            $cmtinsert .= $this->common->make_links($bus_comment['comment']);
            $cmtinsert .= '</div>';
            $cmtinsert .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';
            $cmtinsert .= '<div contenteditable="true" class= "editable_text" name="' . $bus_comment['post_image_comment_id'] . '" id="imgeditcommenttwo' . $bus_comment['post_image_comment_id'] . '" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" onkeyup="imgcommentedittwo(' . $bus_comment['post_image_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">';
            $cmtinsert .= $bus_comment['comment'];
            $cmtinsert .= '</div>';
            $cmtinsert .= '<span class="comment-edit-button"><button id="imgeditsubmittwo' . $bus_comment['post_image_comment_id'] . '" style="display:none;" onClick="imgedit_commenttwo(' . $bus_comment['post_image_comment_id'] . ')">Save</button></span>';
            $cmtinsert .= '</div></div>';
            $cmtinsert .= '<div class="art-comment-menu-design"> <div class="comment-details-menu" id="imglikecomment' . $bus_comment['post_image_comment_id'] . '">';
            $cmtinsert .= '<a id="' . $bus_comment['post_image_comment_id'] . '"';
            $cmtinsert .= 'onClick="imgcomment_like(this.id)">';

            $contition_array = array('post_image_comment_id' => $bus_comment['post_image_comment_id'], 'user_id' => $userid, 'is_unlike' => '0');

            $businesscommentlike1 = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if (count($businesscommentlike1) == 0) {
                $cmtinsert .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
            } else {

                $cmtinsert .= '<i class="fa fa-thumbs-up" aria-hidden="true"></i>';
            }

            $cmtinsert .= '<span>';

            $contition_array = array('post_image_comment_id' => $bus_comment['post_image_comment_id'], 'is_unlike' => '0');
            $mulcountlike = $this->data['mulcountlike'] = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            if (count($mulcountlike) > 0) {
                
            }
            $cmtinsert .= '</span>';
            $cmtinsert .= '</a></div>';

            $userid = $this->session->userdata('aileenuser');
            if ($bus_comment['user_id'] == $userid) {

                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';
                $cmtinsert .= '<div id="imgeditcommentboxtwo' . $bus_comment['post_image_comment_id'] . '"style="display:block;">';
                $cmtinsert .= '<a id="' . $bus_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="imgcomment_editboxtwo(this.id)" class="editbox">';
                $cmtinsert .= 'Edit';
                $cmtinsert .= '</a></div>';
                $cmtinsert .= '<div id="imgeditcancletwo' . $bus_comment['post_image_comment_id'] . '"style="display:none;">';
                $cmtinsert .= '<a id="' . $bus_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="imgcomment_editcancletwo(this.id)">';
                $cmtinsert .= 'Cancel';
                $cmtinsert .= '</a></div>';

                $cmtinsert .= '</div>';
            }
            $userid = $this->session->userdata('aileenuser');

            $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $bus_comment['post_image_id'], 'status' => '1'))->row()->user_id;
            if ($bus_comment['user_id'] == $userid || $business_userid == $userid) {
                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';
                $cmtinsert .= '<input type="hidden" name="imgpost_deletetwo"';
                $cmtinsert .= 'id="imgpost_deletetwo_' . $bus_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'value= "' . $bus_comment['post_image_id'] . '">';
                $cmtinsert .= '<a id="' . $bus_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="imgcomment_deletetwo(this.id)">';
                $cmtinsert .= 'Delete';
                $cmtinsert .= '</a></div>';
            }

            $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
            $cmtinsert .= '<div class="comment-details-menu">';
            $cmtinsert .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($bus_comment['created_date']))) . '</p></div></div></div>';

            $cmtcount = '<a onClick="imgcommentall(this.id)" id="' . $post_image_id . '">';
            $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
            $cmtcount .= ' ' . count($buscmtcnt) . '';
            $cmtcount .= '</i></a>';

// comment count variable end 

            $cntinsert = '<span class="comment_count" >';
            if (count($buscmtcnt) > 0) {
                $cntinsert .= '' . count($buscmtcnt) . '';
                $cntinsert .= '</span>';
                $cntinsert .= '<span> Comment</span>';
            }
        }

        $cmtinsert .= '</div>';


        // GET NOTIFICATION COUNT
        $to_id = $buspostid[0]['user_id'];
        $not_count = $this->business_notification_count($to_id);

        header('Content-type: application/json');
        echo json_encode(
                array("comment" => $cmtinsert,
                    "count" => $cmtcount,
                    "comment_count" => count($buscmtcnt),
                    "status" => 'success',
                    "notification" => array('notification_count' => $not_count, 'to_id' => $to_id),
        ));
    }

    public function pnmulimgcommentthree() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        $post_image_id = $_POST["post_image_id"];
        $post_comment = $_POST["comment"];

        $contition_array = array('post_files_id' => $_POST["post_image_id"], 'is_deleted' => '1');
        $busimg = $this->data['busimg'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('business_profile_post_id' => $busimg[0]["post_id"], 'is_delete' => '0');
        $buspostid = $this->data['buspostid'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $data = array(
            'user_id' => $userid,
            'post_image_id' => $post_image_id,
            'comment' => $post_comment,
            'created_date' => date('Y-m-d H:i:s', time()),
            'is_delete' => '0'
        );
        $insert_id = $this->common->insert_data_getid($data, 'bus_post_image_comment');

// insert notification

        if ($buspostid[0]['user_id'] == $userid) {
            
        } else {
            $datanotification = array(
                'not_type' => '6',
                'not_from_id' => $userid,
                'not_to_id' => $buspostid[0]['user_id'],
                'not_read' => '2',
                'not_product_id' => $insert_id,
                'not_from' => '6',
                'not_img' => '4',
                'not_created_date' => date('Y-m-d H:i:s'),
                'not_active' => '1'
            );
//echo "<pre>"; print_r($datanotification); die();
            $insert_id_notification = $this->common->insert_data_getid($datanotification, 'notification');
            if ($insert_id_notification) {
                $to_email_id = $this->db->select('contact_email')->get_where('business_profile', array('user_id' => $buspostid[0]['user_id']))->row()->contact_email;
                $email_html = '';
                $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;"><img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $this->data['business_login_user_image'] . '" width="50" height="50" alt="' . $this->data['business_login_user_image'] . '"></td>
                                            <td style="padding:5px;">
						<p><b>' . $this->data['business_login_company_name'] . '</b> is comment on your photo in business profile.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a class="btn" href="' . BASEURL . 'notification/business-profile-post-detail/' . $buspostid[0]['business_profile_post_id'] . '/' . $post_image_id . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
                $subject = $this->data['business_login_company_name'] . ' is comment on your photo in Aileensoul.';

                $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $to_email_id);
            }
        }
// end notification

        $contition_array = array('post_image_id' => $post_image_id, 'is_delete' => '0');
        $businesscomment = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('post_image_id' => $post_image_id, 'is_delete' => '0');
        $buscmtcnt = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        foreach ($businesscomment as $bus_comment) {

            $company_name = $this->db->get_where('business_profile', array('user_id' => $bus_comment['user_id']))->row()->company_name;
            $companyslug = $this->db->get_where('business_profile', array('user_id' => $bus_comment['user_id']))->row()->business_slug;
            $business_userimage = $this->db->get_where('business_profile', array('user_id' => $bus_comment['user_id'], 'status' => '1'))->row()->business_user_image;

            $cmtinsert .= '<div class="all-comment-comment-box">';
            $cmtinsert .= '<div class="post-design-pro-comment-img">';
            if ($business_userimage != '') {
                if (IMAGEPATHFROM == 'upload') {
                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                        $cmtinsert .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                    } else {
                        $cmtinsert .= '<img  src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt="'. $business_userimage .'">';
                    }
                } else {
                    $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_userimage;
                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                    if (!$info) {
                        $cmtinsert .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                    } else {
                        $cmtinsert .= '<img  src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt="'. $business_userimage . '">';
                    }
                }
                $cmtinsert .= '</div>';
            } else {
                $cmtinsert .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                $cmtinsert .= '</div>';
            }
            $cmtinsert .= '<div class="comment-name"><a href="' . base_url() . 'business-profile/dashboard/' . $companyslug . '"><b>' . $company_name . '</b></a>';
            $cmtinsert .= '</div>';

            $cmtinsert .= '<div class="comment-details" id= "imgshowcomment' . $bus_comment['post_image_comment_id'] . '"" >';
            $cmtinsert .= $this->common->make_links($bus_comment['comment']);
            $cmtinsert .= '</div>';
            $cmtinsert .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';
            $cmtinsert .= '<div contenteditable="true" class= "editable_text" name="' . $bus_comment['post_image_comment_id'] . '" id="imgeditcomment' . $bus_comment['post_image_comment_id'] . '"style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;"  onkeyup="imgcommentedit(' . $bus_comment['post_image_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">';
            $cmtinsert .= $bus_comment['comment'];
            $cmtinsert .= '</div>';
            $cmtinsert .= '<span class="comment-edit-button"><button id="imgeditsubmit' . $bus_comment['post_image_comment_id'] . '" style="display:none;" onClick="imgedit_comment(' . $bus_comment['post_image_comment_id'] . ')">Save</button></span>';
            $cmtinsert .= '</div></div>';
            $cmtinsert .= '<div class="art-comment-menu-design"> <div class="comment-details-menu" id="imglikecomment' . $bus_comment['post_image_comment_id'] . '">';

            $cmtinsert .= '<a id="' . $bus_comment['post_image_comment_id'] . '"';
            $cmtinsert .= 'onClick="imgcomment_like(this.id)">';

            $contition_array = array('post_image_comment_id' => $bus_comment['post_image_comment_id'], 'user_id' => $userid, 'is_unlike' => '0');
            $businesscommentlike1 = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if (count($businesscommentlike1) == 0) {
                $cmtinsert .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
            } else {

                $cmtinsert .= '<i class="fa fa-thumbs-up" aria-hidden="true"></i>';
            }

            $cmtinsert .= '<span>';

            $contition_array = array('post_image_comment_id' => $bus_comment['post_image_comment_id'], 'is_unlike' => '0');
            $mulcountlike = $this->data['mulcountlike'] = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            if (count($mulcountlike) > 0) {
//echo count($mulcountlike); 
            }
            $cmtinsert .= '</span>';
            $cmtinsert .= '</a></div>';

            $userid = $this->session->userdata('aileenuser');
            if ($bus_comment['user_id'] == $userid) {

                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';


                $cmtinsert .= '<div id="imgeditcommentbox' . $bus_comment['post_image_comment_id'] . '"style="display:block;">';

                $cmtinsert .= '<a id="' . $bus_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="imgcomment_editbox(this.id)">';
                $cmtinsert .= 'Edit';
                $cmtinsert .= '</a></div>';

                $cmtinsert .= '<div id="imgeditcancle' . $bus_comment['post_image_comment_id'] . '"style="display:none;">';

                $cmtinsert .= '<a id="' . $bus_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="imgcomment_editcancle(this.id)">';
                $cmtinsert .= 'Cancel';
                $cmtinsert .= '</a></div>';

                $cmtinsert .= '</div>';
            }
            $userid = $this->session->userdata('aileenuser');

            $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $bus_comment['post_image_id'], 'status' => '1'))->row()->user_id;


            if ($bus_comment['user_id'] == $userid || $business_userid == $userid) {


                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';
                $cmtinsert .= '<input type="hidden" name="imgpost_delete"';
                $cmtinsert .= 'id="imgpost_delete_' . $bus_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'value= "' . $bus_comment['post_image_id'] . '">';
                $cmtinsert .= '<a id="' . $bus_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="imgcomment_delete(this.id)">';
                $cmtinsert .= 'Delete';
                $cmtinsert .= '</a></div>';
            }

            $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
            $cmtinsert .= '<div class="comment-details-menu">';
            $cmtinsert .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($bus_comment['created_date']))) . '</p></div></div></div>';

            $cmtcount = '<a onClick="imgcommentall(this.id)" id="' . $post_image_id . '">';
            $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
            $cmtcount .= ' ' . count($buscmtcnt) . '';
            $cmtcount .= '</i></a>';

// comment count variable end 

            $cntinsert = '<span class="comment_count" >';
            if (count($buscmtcnt) > 0) {
                $cntinsert .= '' . count($buscmtcnt) . '';
                $cntinsert .= '</span>';
                $cntinsert .= '<span> Comment</span>';
            }
        }

// GET NOTIFICATION COUNT
        $to_id = $buspostid[0]['user_id'];
        $not_count = $this->business_notification_count($to_id);


        echo json_encode(
                array("comment" => $cmtinsert,
                    "count" => $cmtcount,
                    "comment_count" => $cntinsert,
                    "status" => 'success',
                    "notification" => array('notification_count' => $not_count, 'to_id' => $to_id),
        ));
    }

//multiple images comment end 
//multiple images comment like start
    public function mulimg_comment_like() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        $post_image_comment_id = $_POST["post_image_comment_id"];

        $contition_array = array('post_image_comment_id' => $post_image_comment_id, 'user_id' => $userid);
        $likecommentuser = $this->data['likecommentuser'] = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('post_image_comment_id' => $post_image_comment_id);
        $busimglike = $this->data['busimglike'] = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('post_files_id' => $busimglike[0]['post_image_id'], 'insert_profile' => '2');
        $buslikeimg = $this->data['buslikeimg'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('business_profile_post_id' => $buslikeimg[0]["post_id"]);
        $busimglikepost = $this->data['busimglikepost'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if (!$likecommentuser) {

            $data = array(
                'post_image_comment_id' => $post_image_comment_id,
                'user_id' => $userid,
                'created_date' => date('Y-m-d H:i:s', time()),
                'is_unlike' => '0'
            );

            $insertdata = $this->common->insert_data_getid($data, 'bus_comment_image_like');

// insert notification

            if ($busimglike[0]['user_id'] == $userid) {
                
            } else {
                $datanotification = array(
                    'not_type' => '5',
                    'not_from_id' => $userid,
                    'not_to_id' => $busimglike[0]['user_id'],
                    'not_read' => '2',
                    'not_product_id' => $post_image_comment_id,
                    'not_from' => '6',
                    'not_img' => '6',
                    'not_created_date' => date('Y-m-d H:i:s'),
                    'not_active' => '1'
                );
                $insert_id = $this->common->insert_data_getid($datanotification, 'notification');
                if ($insert_id) {
                    $to_email_id = $this->db->select('contact_email')->get_where('business_profile', array('user_id' => $busimglike[0]['user_id']))->row()->contact_email;
                    $email_html = '';
                    $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;"><img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $this->data['business_login_user_image'] . '" width="50" height="50" alt="'. $this->data['business_login_user_image'] .'"></td>
                                            <td style="padding:5px;">
						<p><b>' . $this->data['business_login_company_name'] . '</b> is like your comment of photo in business profile.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a class="btn" href="' . BASEURL . 'notification/business-profile-post-detail/' . $buslikeimg[0]['post_id'] . '/' . $busimglike[0]['post_image_id'] . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
                    $subject = $this->data['business_login_company_name'] . ' is like your comment of photo in Aileensoul.';

                    $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $to_email_id);
                }
            }
// end notification

            $contition_array = array('post_image_comment_id' => $_POST["post_image_comment_id"], 'is_unlike' => '0');
            $bdatacm = $this->data['bdatacm'] = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($insertdata) {
                $imglike .= '<a id="' . $post_image_comment_id . '" onClick="imgcomment_like(this.id)">';
                $imglike .= ' <i class="fa fa-thumbs-up main_color" aria-hidden="true">';
                $imglike .= '</i>';
                $imglike .= '<span> ';
                if (count($bdatacm) > 0) {
                    $imglike .= count($bdatacm) . '';
                }
                $imglike .= '</span>';
                $imglike .= '</a>';


                echo $imglike;
            }
        } else {

            if ($likecommentuser[0]['is_unlike'] == 0) {

                $data = array(
                    'modify_date' => date('Y-m-d', time()),
                    'is_unlike' => '1'
                );


                $where = array('post_image_comment_id' => $post_image_comment_id, 'user_id' => $userid);
                $this->db->where($where);
                $updatdata = $this->db->update('bus_comment_image_like ', $data);

                $contition_array = array('post_image_comment_id' => $post_image_comment_id, 'is_unlike' => '0');
                $bdata2 = $this->data['bdata2'] = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($updatdata) {
                    $imglike1 .= '<a id="' . $post_image_comment_id . '" onClick="imgcomment_like(this.id)">';
                    $imglike1 .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true">';
                    $imglike1 .= '</i>';
                    $imglike1 .= '<span>';
                    if (count($bdata2) > 0) {
                        $imglike1 .= count($bdata2) . '';
                    }
                    $imglike1 .= '</span>';
                    $imglike1 .= '</a>';


                    echo $imglike1;
                }
            } else {

                $data = array(
                    'modify_date' => date('Y-m-d', time()),
                    'is_unlike' => '0'
                );

                $where = array('post_image_comment_id' => $post_image_comment_id, 'user_id' => $userid);
                $this->db->where($where);
                $updatdata = $this->db->update('bus_comment_image_like ', $data);

// insert notification

                if ($busimglike[0]['user_id'] == $userid) {
                    
                } else {

                    $contition_array = array('not_type' => '5', 'not_from_id' => $userid, 'not_to_id' => $busimglike[0]['user_id'], 'not_product_id' => $post_image_comment_id, 'not_from' => '6', 'not_img' => '6');
                    $busnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    if ($busnotification[0]['not_read'] == 2) {
                        
                    } elseif ($busnotification[0]['not_read'] == 1) {

                        $datalike = array(
                            'not_read' => '2'
                        );

                        $where = array('not_type' => '5', 'not_from_id' => $userid, 'not_to_id' => $busimglike[0]['user_id'], 'not_product_id' => $post_image_comment_id, 'not_from' => '6', 'not_img' => '6');
                        $this->db->where($where);
                        $updatdata = $this->db->update('notification', $datalike);
                    } else {

                        $data = array(
                            'not_type' => '5',
                            'not_from_id' => $userid,
                            'not_to_id' => $busimglike[0]['user_id'],
                            'not_read' => '2',
                            'not_product_id' => $post_image_comment_id,
                            'not_from' => '6',
                            'not_img' => '6',
                            'not_created_date' => date('Y-m-d H:i:s'),
                            'not_active' => '1'
                        );
                        $insert_id = $this->common->insert_data_getid($data, 'notification');
                        if ($insert_id) {
                            $to_email_id = $this->db->select('contact_email')->get_where('business_profile', array('user_id' => $busimglike[0]['user_id']))->row()->contact_email;
                            $email_html = '';
                            $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;"><img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $this->data['business_login_user_image'] . '" width="50" height="50" alt="'. $this->data['business_login_user_image'] . '"></td>
                                            <td style="padding:5px;">
						<p><b>' . $this->data['business_login_company_name'] . '</b> is like your comment of photo in business profile.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a class="btn" href="' . BASEURL . 'notification/business-profile-post-detail/' . $buslikeimg[0]['post_id'] . '/' . $busimglike[0]['post_image_id'] . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
                            $subject = $this->data['business_login_company_name'] . ' is like your comment of photo in Aileensoul.';

                            $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $to_email_id);
                        }
                    }
                }
// end notification 


                $contition_array = array('post_image_comment_id' => $_POST["post_image_comment_id"], 'is_unlike' => '0');
                $bdata2 = $this->data['bdata2'] = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($updatdata) {

                    $imglike1 .= '<a id="' . $post_image_comment_id . '" onClick="imgcomment_like(this.id)">';
                    $imglike1 .= '<i class="fa fa-thumbs-up main_color" aria-hidden="true">';
                    $imglike1 .= '</i>';
                    $imglike1 .= '<span> ';
                    if (count($bdata2) > 0) {
                        $imglike1 .= count($bdata2) . '';
                    }
                    $imglike1 .= '</span>';
                    $imglike1 .= '</a>';

                    echo $imglike1;
                }
            }
        }
    }

    public function mulimg_comment_liketwo() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $post_image_comment_id = $_POST["post_image_comment_id"];

        $contition_array = array('post_image_comment_id' => $post_image_comment_id, 'user_id' => $userid);

        $likecommentuser = $this->data['likecommentuser'] = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('post_image_comment_id' => $post_image_comment_id);
        $busimglike = $this->data['busimglike'] = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
//echo "<pre>"; print_r($busimglike); die();


        $contition_array = array('post_files_id' => $busimglike[0]['post_image_id'], 'insert_profile' => '2');
        $buslikeimg = $this->data['buslikeimg'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('business_profile_post_id' => $buslikeimg[0]["post_id"]);
        $busimglikepost = $this->data['busimglikepost'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if (!$likecommentuser) {

            $data = array(
                'post_image_comment_id' => $post_image_comment_id,
                'user_id' => $userid,
                'created_date' => date('Y-m-d H:i:s', time()),
                'is_unlike' => '0'
            );
//echo "<pre>"; print_r($data); die();

            $insertdata = $this->common->insert_data_getid($data, 'bus_comment_image_like');


// insert notification

            if ($busimglike[0]['user_id'] == $userid) {
                
            } else {
                $datanotification = array(
                    'not_type' => '5',
                    'not_from_id' => $userid,
                    'not_to_id' => $busimglike[0]['user_id'],
                    'not_read' => '2',
                    'not_product_id' => $post_image_comment_id,
                    'not_from' => '6',
                    'not_img' => '6',
                    'not_created_date' => date('Y-m-d H:i:s'),
                    'not_active' => '1'
                );
//echo "<pre>"; print_r($datanotification); die();
                $insert_id = $this->common->insert_data_getid($datanotification, 'notification');
                if ($insert_id) {
                    $to_email_id = $this->db->select('contact_email')->get_where('business_profile', array('user_id' => $busimglike[0]['user_id']))->row()->contact_email;
                    $email_html = '';
                    $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;"><img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $this->data['business_login_user_image'] . '" width="50" height="50" alt="' . $this->data['business_login_user_image'] .'"></td>
                                            <td style="padding:5px;">
						<p><b>' . $this->data['business_login_company_name'] . '</b> is like your comment of photo in business profile.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a class="btn" href="' . BASEURL . 'notification/business-profile-post-detail/' . $buslikeimg[0]['post_id'] . '/' . $busimglike[0]['post_image_id'] . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
                    $subject = $this->data['business_login_company_name'] . ' is like your comment of photo in Aileensoul.';

                    $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $to_email_id);
                }
            }
// end notification

            $contition_array = array('post_image_comment_id' => $_POST["post_image_comment_id"], 'is_unlike' => '0');
            $bdatacm = $this->data['bdatacm'] = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if ($insertdata) {
                $imglike .= '<a id="' . $post_image_comment_id . '" onClick="imgcomment_liketwo(this.id)">';
                $imglike .= ' <i class="fa fa-thumbs-up" aria-hidden="true">';
                $imglike .= '</i>';
                $imglike .= '<span> ';
                if (count($bdatacm) > 0) {
                    $imglike .= count($bdatacm) . '';
                }
                $imglike .= '</span>';
                $imglike .= '</a>';


                echo $imglike;
            }
        } else {

            if ($likecommentuser[0]['is_unlike'] == 0) {

                $data = array(
                    'modify_date' => date('Y-m-d', time()),
                    'is_unlike' => '1'
                );


                $updatdata = $this->common->update_data($data, 'bus_comment_image_like', 'post_image_comment_id', $post_image_comment_id);

                $contition_array = array('post_image_comment_id' => $post_image_comment_id, 'is_unlike' => '0');
                $bdata2 = $this->data['bdata2'] = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');



                if ($updatdata) {


                    $imglike1 .= '<a id="' . $post_image_comment_id . '" onClick="imgcomment_liketwo(this.id)">';
                    $imglike1 .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true">';
                    $imglike1 .= '</i>';
                    $imglike1 .= '<span>';
                    if (count($bdata2) > 0) {
                        $imglike1 .= count($bdata2) . '';
                    }
                    $imglike1 .= '</span>';
                    $imglike1 .= '</a>';


                    echo $imglike1;
                }
            } else {

                $data = array(
                    'modify_date' => date('Y-m-d', time()),
                    'is_unlike' => '0'
                );

                $where = array('post_image_comment_id' => $post_image_comment_id, 'user_id' => $userid);
                $this->db->where($where);
                $updatdata = $this->db->update('bus_comment_image_like ', $data);



// insert notification

                if ($busimglike[0]['user_id'] == $userid) {
                    
                } else {

                    $contition_array = array('not_type' => '5', 'not_from_id' => $userid, 'not_to_id' => $busimglike[0]['user_id'], 'not_product_id' => $post_image_comment_id, 'not_from' => '6', 'not_img' => '6');
                    $busnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    if ($busnotification[0]['not_read'] == 2) {
                        
                    } elseif ($busnotification[0]['not_read'] == 1) {

                        $datalike = array(
                            'not_read' => '2'
                        );

                        $where = array('not_type' => '5', 'not_from_id' => $userid, 'not_to_id' => $busimglike[0]['user_id'], 'not_product_id' => $post_image_comment_id, 'not_from' => '6', 'not_img' => '6');
                        $this->db->where($where);
                        $updatdata = $this->db->update('notification', $datalike);
                    } else {
                        $datanotification = array(
                            'not_type' => '5',
                            'not_from_id' => $userid,
                            'not_to_id' => $busimglike[0]['user_id'],
                            'not_read' => '2',
                            'not_product_id' => $post_image_comment_id,
                            'not_from' => '6',
                            'not_img' => '6',
                            'not_created_date' => date('Y-m-d H:i:s'),
                            'not_active' => '1'
                        );

                        $insert_id = $this->common->insert_data_getid($datanotification, 'notification');
                        if ($insert_id) {
                            $to_email_id = $this->db->select('contact_email')->get_where('business_profile', array('user_id' => $busimglike[0]['user_id']))->row()->contact_email;
                            $email_html = '';
                            $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;"><img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $this->data['business_login_user_image'] . '" width="50" height="50" alt="'. $this->data['business_login_user_image'] .'"></td>
                                            <td style="padding:5px;">
						<p><b>' . $this->data['business_login_company_name'] . '</b> is like your comment of photo in business profile.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a class="btn" href="' . BASEURL . 'notification/business-profile-post-detail/' . $buslikeimg[0]['post_id'] . '/' . $busimglike[0]['post_image_id'] . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
                            $subject = $this->data['business_login_company_name'] . ' is like your comment of photo in Aileensoul.';

                            $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $to_email_id);
                        }
                    }
                }
// end notification

                $contition_array = array('post_image_comment_id' => $_POST["post_image_comment_id"], 'is_unlike' => '0');
                $bdata2 = $this->data['bdata2'] = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($updatdata) {


                    $imglike1 .= '<a id="' . $post_image_comment_id . '" onClick="imgcomment_liketwo(this.id)">';
                    $imglike1 .= '<i class="fa fa-thumbs-up" aria-hidden="true">';
                    $imglike1 .= '</i>';
                    $imglike1 .= '<span> ';
                    if (count($bdata2) > 0) {
                        $imglike1 .= count($bdata2) . '';
                    }
                    $imglike1 .= '</span>';
                    $imglike1 .= '</a>';


                    echo $imglike1;
                }
            }
        }
    }

//multiple images comemnt like end
//multiple images comment edit start
    public function mul_edit_com_insert() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $post_image_comment_id = $_POST["post_image_comment_id"];
        $post_comment = $_POST["comment"];

        $data = array(
            'comment' => $post_comment,
            'modify_date' => date('y-m-d h:i:s')
        );

        $updatdata = $this->common->update_data($data, 'bus_post_image_comment', 'post_image_comment_id', $post_image_comment_id);
        if ($updatdata) {

            $contition_array = array('post_image_comment_id' => $_POST["post_image_comment_id"], 'is_delete' => '0');
            $buseditdata = $this->data['buseditdata'] = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $cmtlike = '<div>';
            $cmtlike .= $this->common->make_links($buseditdata[0]['comment']) . "";
            $cmtlike .= '</div>';
            echo $cmtlike;
        }
    }

//multiple images comment edit end
//multiple images commnet delete start
    public function mul_delete_comment() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $post_image_comment_id = $_POST["post_image_comment_id"];
        $post_delete = $_POST["post_delete"];
        $data = array(
            'is_delete' => '1',
            'modify_date' => date('y-m-d h:i:s')
        );


        $updatdata = $this->common->update_data($data, 'bus_post_image_comment', 'post_image_comment_id', $post_image_comment_id);


        $contition_array = array('post_image_id' => $post_delete, 'is_delete' => '0');
        $businesscomment = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');

// count for comment
        $contition_array = array('post_image_id' => $post_delete, 'is_delete' => '0');
        $buscmtcnt = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

//echo "<pre>"; print_r($buscmtcnt); die();
        if (count($businesscomment) > 0) {
            foreach ($businesscomment as $bus_comment) {

                $company_name = $this->db->get_where('business_profile', array('user_id' => $bus_comment['user_id']))->row()->company_name;
                $company_slug = $this->db->get_where('business_profile', array('user_id' => $bus_comment['user_id']))->row()->business_slug;
                $business_userimage = $this->db->get_where('business_profile', array('user_id' => $bus_comment['user_id'], 'status' => '1'))->row()->business_user_image;

                $cmtinsert .= '<div class="all-comment-comment-box">';
                $cmtinsert .= '<div class="post-design-pro-comment-img">';
                if ($business_userimage != '') {
                    if (IMAGEPATHFROM == 'upload') {
                        if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                            $cmtinsert .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                        } else {
                            $cmtinsert .= '<img  src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt="'. $business_userimage .'">';
                        }
                    } else {
                        $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_userimage;
                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                        if (!$info) {
                            $cmtinsert .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                        } else {
                            $cmtinsert .= '<img  src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt="'. $business_userimage .'">';
                        }
                    }

                    $cmtinsert .= '</div>';
                } else {

                    $cmtinsert .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                    $cmtinsert .= '</div>';
                }
                $cmtinsert .= '<div class="comment-name"><a href="' . base_url() . 'business-profile/dashboard/' . $company_slug . '"><b>' . $company_name . '</b></a>';
                $cmtinsert .= '</div>';

                $cmtinsert .= '<div class="comment-details" id= "imgshowcomment' . $bus_comment['post_image_comment_id'] . '"" >';
                $cmtinsert .= $this->common->make_links($bus_comment['comment']);
                $cmtinsert .= '</div>';

                $cmtinsert .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';
                $cmtinsert .= '<div contenteditable="true" class="editable_text" name="' . $bus_comment['post_image_comment_id'] . '" id="imgeditcomment' . $bus_comment['post_image_comment_id'] . '"style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;"  onkeyup="imgcommentedit(' . $bus_comment['post_image_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">';
                $cmtinsert .= $bus_comment['comment'];
                $cmtinsert .= '</div>';
                $cmtinsert .= '<span class="comment-edit-button"><button id="imgeditsubmit' . $bus_comment['post_image_comment_id'] . '" style="display:none;" onClick="imgedit_comment(' . $bus_comment['post_image_comment_id'] . ')">Save</button></span>';
                $cmtinsert .= '</div></div>';
                $cmtinsert .= '<div class="art-comment-menu-design"> <div class="comment-details-menu" id="imglikecomment' . $bus_comment['post_image_comment_id'] . '">';

                $cmtinsert .= '<a id="' . $bus_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="imgcomment_like(this.id)">';

                $contition_array = array('post_image_comment_id' => $bus_comment['post_image_comment_id'], 'user_id' => $userid, 'is_unlike' => '0');
                $businesscommentlike1 = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if (count($businesscommentlike1) == 0) {
                    $cmtinsert .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
                } else {

                    $cmtinsert .= '<i class="fa fa-thumbs-up" aria-hidden="true"></i>';
                }

                $cmtinsert .= '<span> ';

                $contition_array = array('post_image_comment_id' => $bus_comment['post_image_comment_id'], 'is_unlike' => '0');
                $mulcountlike = $this->data['mulcountlike'] = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


                if (count($mulcountlike) > 0) {
                    echo count($mulcountlike);
                }
                $cmtinsert .= '</span>';
                $cmtinsert .= '</a></div>';

                $userid = $this->session->userdata('aileenuser');
                if ($bus_comment['user_id'] == $userid) {

                    $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $cmtinsert .= '<div class="comment-details-menu">';


                    $cmtinsert .= '<div id="imgeditcommentbox' . $bus_comment['post_image_comment_id'] . '"style="display:block;">';

                    $cmtinsert .= '<a id="' . $bus_comment['post_image_comment_id'] . '"';
                    $cmtinsert .= 'onClick="imgcomment_editbox(this.id)">';
                    $cmtinsert .= 'Edit';
                    $cmtinsert .= '</a></div>';

                    $cmtinsert .= '<div id="imgeditcancle' . $bus_comment['post_image_comment_id'] . '"style="display:none;">';

                    $cmtinsert .= '<a id="' . $bus_comment['post_image_comment_id'] . '"';
                    $cmtinsert .= 'onClick="imgcomment_editcancle(this.id)">';
                    $cmtinsert .= 'Cancel';
                    $cmtinsert .= '</a></div>';

                    $cmtinsert .= '</div>';
                }

                $userid = $this->session->userdata('aileenuser');

                $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $bus_comment['post_image_id'], 'status' => '1'))->row()->user_id;

                if ($bus_comment['user_id'] == $userid || $business_userid == $userid) {


                    $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $cmtinsert .= '<div class="comment-details-menu">';


                    $cmtinsert .= '<input type="hidden" name="imgpost_delete"';
// $cmtinsert .= 'id="imgpost_delete' . $bus_comment['post_image_comment_id'] . '"';
                    $cmtinsert .= 'id="imgpost_delete_' . $bus_comment['post_image_comment_id'] . '"';
                    $cmtinsert .= ' value= "' . $bus_comment['post_image_id'] . '">';
                    $cmtinsert .= '<a id="' . $bus_comment['post_image_comment_id'] . '"';
                    $cmtinsert .= 'onClick="imgcomment_delete(this.id)">';
                    $cmtinsert .= 'Delete';
                    $cmtinsert .= '</a></div>';
                }

                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';
                $cmtinsert .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($bus_comment['created_date']))) . '</p></div></div>';

                $cmtcount = '<a onClick="imgcommentall(this.id)" id="' . $bus_comment['post_image_id'] . '">';
                $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
                $cmtcount .= ' ' . count($buscmtcnt) . '';
                $cmtcount .= '</i></a>';

// comment count variable end 
                $cntinsert = '<span class="comment_count" >';
                if (count($buscmtcnt) > 0) {
                    $cntinsert .= '' . count($buscmtcnt) . '';
                    $cntinsert .= '</span>';
                    $cntinsert .= '<span> Comment</span>';
                }
            }
        } else {
            $idpost = $bus_comment['post_image_id'];
            $cmtcount = '<a onClick="imgcommentall(this.id)" id="' . $idpost . '">';
            $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
            $cmtcount .= '</i></a>';
        }
        echo json_encode(
                array("comment" => $cmtinsert,
                    "count" => $cmtcount,
                    "comment_count" => $cntinsert
        ));
    }

    public function mul_delete_commenttwo() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $post_image_comment_id = $_POST["post_image_comment_id"];
        $post_delete = $_POST["post_delete"];

        $data = array(
            'is_delete' => '1',
            'modify_date' => date('y-m-d h:i:s')
        );
        $updatdata = $this->common->update_data($data, 'bus_post_image_comment', 'post_image_comment_id', $post_image_comment_id);

        $contition_array = array('post_image_id' => $post_delete, 'is_delete' => '0');
        $businesscomment = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

//echo "<pre>"; print_r($businesscomment); die();
        if (count($businesscomment) > 0) {
            foreach ($businesscomment as $bus_comment) {
                $company_name = $this->db->get_where('business_profile', array('user_id' => $bus_comment['user_id']))->row()->company_name;
                $companyslug = $this->db->get_where('business_profile', array('user_id' => $bus_comment['user_id']))->row()->business_slug;
                $business_userimage = $this->db->get_where('business_profile', array('user_id' => $bus_comment['user_id'], 'status' => '1'))->row()->business_user_image;

                $cmtinsert .= '<div class="all-comment-comment-box">';
                $cmtinsert .= '<div class="post-design-pro-comment-img">';
                if ($business_userimage != '') {
                    if (IMAGEPATHFROM == 'upload') {
                        if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                            $cmtinsert .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                        } else {
                            $cmtinsert .= '<img  src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt="'. $business_userimage .'">';
                        }
                    } else {
                        $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_userimage;
                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                        if (!$info) {
                            $cmtinsert .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                        } else {
                            $cmtinsert .= '<img  src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt="'. $business_userimage .'">';
                        }
                    }
                    $cmtinsert .= '</div>';
                } else {
                    $cmtinsert .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                    $cmtinsert .= '</div>';
                }
                $cmtinsert .= '<div class="comment-name"><a href="' . base_url() . 'business-profile/dashboard/' . $companyslug . '"><b>' . $company_name . '</b></a>';
                $cmtinsert .= '</div>';

                $cmtinsert .= '<div class="comment-details" id= "imgshowcommenttwo' . $bus_comment['post_image_comment_id'] . '">';
                $cmtinsert .= $this->common->make_links($bus_comment['comment']);
                $cmtinsert .= '</div>';

                $cmtinsert .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';
//$cmtinsert .= '<textarea type="text" class="textarea" name="' . $business_profile['business_profile_post_comment_id'] . '" id="editcomment' . $business_profile['business_profile_post_comment_id'] . '" style="display:none;resize: none;" onClick="commentedit(this.name)">' . $business_profile['comments'] . '</textarea>';
                $cmtinsert .= '<div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="' . $bus_comment['post_image_comment_id'] . '"  id="imgeditcommenttwo' . $bus_comment['post_image_comment_id'] . '" placeholder="Type Message ..."  onkeyup="imgcommentedittwo(' . $bus_comment['post_image_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $bus_comment['comment'] . '</div>';
                $cmtinsert .= '<span class="comment-edit-button"><button id="imgeditsubmittwo' . $bus_comment['post_image_comment_id'] . '" style="display:none" onClick="imgedit_commenttwo(' . $bus_comment['post_image_comment_id'] . ')">Save</button></span>';
                $cmtinsert .= '</div></div>';

//            $cmtinsert .= '<input type="text" name="' . $bus_comment['post_image_comment_id'] . '" id="imgeditcommenttwo' . $bus_comment['post_image_comment_id'] . '"style="display:none;" value="' . $bus_comment['comment'] . ' " onClick="imgcommentedittwo(this.name)">';
//            $cmtinsert .= '<button id="imgeditsubmittwo' . $bus_comment['post_image_comment_id'] . '" style="display:none;" onClick="imgedit_commenttwo(' . $bus_comment['post_image_comment_id'] . ')">Comment</button><div class="art-comment-menu-design"> <div class="comment-details-menu" id="imglikecomment1' . $bus_comment['post_image_comment_id'] . '">';

                $cmtinsert .= '<div class="art-comment-menu-design"><div class="comment-details-menu" id="imglikecomment1' . $bus_comment['post_image_comment_id'] . '">';
                $cmtinsert .= '<a id="' . $bus_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="imgcomment_liketwo(this.id)">';

                $contition_array = array('post_image_comment_id' => $bus_comment['post_image_comment_id'], 'user_id' => $userid, 'is_unlike' => '0');
                $businesscommentlike1 = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if (count($businesscommentlike1) == 0) {
                    $cmtinsert .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
                } else {
                    $cmtinsert .= '<i class="fa fa-thumbs-up" aria-hidden="true"></i>';
                }

                $cmtinsert .= '<span> ';

                $contition_array = array('post_image_comment_id' => $bus_comment['post_image_comment_id'], 'is_unlike' => '0');
                $mulcountlike = $this->data['mulcountlike'] = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


                if (count($mulcountlike) > 0) {
                    $cmtinsert .= count($mulcountlike);
                }
                $cmtinsert .= '</span>';
                $cmtinsert .= '</a></div>';

                $userid = $this->session->userdata('aileenuser');
                if ($bus_comment['user_id'] == $userid) {

                    $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $cmtinsert .= '<div class="comment-details-menu">';


                    $cmtinsert .= '<div id="imgeditcommentboxtwo' . $bus_comment['post_image_comment_id'] . '"style="display:block;">';

                    $cmtinsert .= '<a id="' . $bus_comment['post_image_comment_id'] . '"';
                    $cmtinsert .= 'onClick="imgcomment_editboxtwo(this.id)">';
                    $cmtinsert .= 'Edit';
                    $cmtinsert .= '</a></div>';

                    $cmtinsert .= '<div id="imgeditcancletwo' . $bus_comment['post_image_comment_id'] . '"style="display:none;">';

                    $cmtinsert .= '<a id="' . $bus_comment['post_image_comment_id'] . '"';
                    $cmtinsert .= 'onClick="imgcomment_editcancletwo(this.id)">';
                    $cmtinsert .= 'Cancel';
                    $cmtinsert .= '</a></div>';

                    $cmtinsert .= '</div>';
                }
                $userid = $this->session->userdata('aileenuser');

                $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $bus_comment['post_image_id'], 'status' => '1'))->row()->user_id;


                if ($bus_comment['user_id'] == $userid || $business_userid == $userid) {


                    $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $cmtinsert .= '<div class="comment-details-menu">';


//$cmtinsert .= '<input type="hidden" name="post_deletetwo"';
//$cmtinsert .= ' id="post_deletetwo' . $bus_comment['post_image_comment_id'] . '"';
                    $cmtinsert .= '<input type="hidden" name="imgpost_delete1"';
                    $cmtinsert .= ' id="imgpost_deletetwo_' . $bus_comment['post_image_comment_id'] . '"';
                    $cmtinsert .= ' value= "' . $bus_comment['post_image_id'] . '">';
                    $cmtinsert .= ' <a id="' . $bus_comment['post_image_comment_id'] . '"';
                    $cmtinsert .= 'onClick="imgcomment_deletetwo(this.id)">';
                    $cmtinsert .= 'Delete';
                    $cmtinsert .= '</a></div>';
                }

                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';
                $cmtinsert .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($bus_comment['created_date']))) . '</p></div></div></div>';

// comment aount variable start
                $idpost = $bus_comment['post_image_id'];
                $cmtcount = '<a onClick="commentall1(this.id)" id="' . $idpost . '">';
                $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
                $cmtcount .= ' ' . count($businesscomment) . '';
                $cmtcount .= '</i></a>';

                $cntinsert = '<span class="comment_count" >';
                if (count($businesscomment) > 0) {
                    $cntinsert .= '' . count($businesscomment) . '';
                    $cntinsert .= '</span>';
                    $cntinsert .= '<span> Comment</span>';
                }
            }
        } else {
            $idpost = $bus_comment['post_image_id'];
            $cmtcount = '<a onClick="commentall1(this.id)" id="' . $idpost . '">';
            $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
            $cmtcount .= '</i></a>';
        }

//header('Content-type: application/json');
        echo json_encode(
                array("comment" => $cmtinsert,
                    "count" => $cmtcount,
                    "comment_count" => $cntinsert));
    }

//mulitple images commnet delete end  

    public function fourcomment($postid = '') {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $post_id = $_POST['bus_post_id'];

// html start

        $fourdata = '<div class="hidebottombordertwo insertcommenttwo' . $post_id . '">';

        $contition_array = array('business_profile_post_id' => $post_id, 'status' => '1');
        $busienssdata = $this->data['busienssdata'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = 'business_profile_post_comment_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($busienssdata) {
            foreach ($busienssdata as $rowdata) {

                $companyname = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id']))->row()->company_name;
                $companyslug = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id']))->row()->business_slug;
                $fourdata .= '<div class="all-comment-comment-box">';
                $fourdata .= '<div class="post-design-pro-comment-img">';

                $busienss_userimage = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id'], 'status' => '1'))->row()->business_user_image;

                if ($busienss_userimage) {
                    if (IMAGEPATHFROM == 'upload') {
                        if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $busienss_userimage)) {
                            $fourdata .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                        } else {
                            $fourdata .= '<img  src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $busienss_userimage . '"  alt="'. $busienss_userimage .'">';
                        }
                    } else {
                        $filename = $this->config->item('bus_profile_thumb_upload_path') . $busienss_userimage;
                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                        if (!$info) {
                            $fourdata .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                        } else {
                            $fourdata .= '<img  src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $busienss_userimage . '"  alt="'. $busienss_userimage .'">';
                        }
                    }
                } else {
                    $fourdata .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                }
                $fourdata .= '</div><div class="comment-name"><b>';
                $fourdata .= '<a href="' . base_url() . 'business-profile/dashboard/' . $companyslug . '">' . ucfirst($companyname) . '</br></b></a></div>';
                $fourdata .= '<div class="comment-details" id= "showcommenttwo' . $rowdata['business_profile_post_comment_id'] . '">';

                $fourdata .= '<div id= "lessmore' . $rowdata['business_profile_post_comment_id'] . '"  style="display:block;">';

                $small = substr($rowdata['comments'], 0, 180);

                $fourdata .= '' . nl2br($this->common->make_links($small)) . '';

// echo $this->common->make_links($small);

                if (strlen($rowdata['comments']) > 180) {
                    $fourdata .= '... <span id="kkkk" onClick="seemorediv(' . $rowdata['business_profile_post_comment_id'] . ')">See More</span>';
                }

                $fourdata .= '</div>';


                $fourdata .= '<div id= "seemore' . $rowdata['business_profile_post_comment_id'] . '"  style="display:none;">';

                $fourdata .= '' . $this->common->make_links($rowdata['comments']) . '</div></div>';
                $fourdata .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';
//$fourdata .= '<textarea type="text" class="textarea" name="' . $rowdata['business_profile_post_comment_id'] . '" id="editcommenttwo' . $rowdata['business_profile_post_comment_id'] . '" style="display:none; resize:none;" onClick="commentedittwo(this.name)">' . $rowdata['comments'] . '</textarea>';
                $fourdata .= '<div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="' . $rowdata['business_profile_post_comment_id'] . '"  id="editcommenttwo' . $rowdata['business_profile_post_comment_id'] . '" placeholder="Type Message ..."  onkeyup="commentedittwo(' . $rowdata['business_profile_post_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $rowdata['comments'] . '</div>';
                $fourdata .= '<span class="comment-edit-button"><button id="editsubmittwo' . $rowdata['business_profile_post_comment_id'] . '" style="display:none" onClick="edit_commenttwo(' . $rowdata['business_profile_post_comment_id'] . ')">Save</button></span>';

//$fourdata .= '<input type="text" name="' . $rowdata['business_profile_post_comment_id'] . '" id="editcommenttwo' . $rowdata['business_profile_post_comment_id'] . '" style="display:none" value="' . $rowdata['comments'] . '" onClick="commentedittwo(this.name)"></div>';
//
//$fourdata .= '<div class="col-md-2 comment-edit-button">';
//$fourdata .= '<button id="editsubmittwo' . $rowdata['business_profile_post_comment_id'] . '" style="display:none" onClick="edit_commenttwo(' . $rowdata['business_profile_post_comment_id'] . ')">Comment</button></div>';

                $fourdata .= '</div></div><div class="art-comment-menu-design">';
                $fourdata .= '<div class="comment-details-menu" id="likecomment' . $rowdata['business_profile_post_comment_id'] . '">';
                $fourdata .= '<a id="' . $rowdata['business_profile_post_comment_id'] . '"   onClick="comment_like(this.id)">';

                $userid = $this->session->userdata('aileenuser');
                $contition_array = array('business_profile_post_comment_id' => $rowdata['business_profile_post_comment_id'], 'status' => '1');
                $businesscommentlike = $this->data['businesscommentlike'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                $likeuserarray = explode(',', $businesscommentlike[0]['business_comment_like_user']);

                if (!in_array($userid, $likeuserarray)) {

                    $fourdata .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
                } else {

                    $fourdata .= '<i class="fa fa-thumbs-up" aria-hidden="true"></i>';
                }
                $fourdata .= '<span>';

                if ($rowdata['business_comment_likes_count'] > 0) {
                    $fourdata .= ' ' . $rowdata['business_comment_likes_count'] . '';
                }

                $fourdata .= '</span></a></div>';
                $userid = $this->session->userdata('aileenuser');
                if ($rowdata['user_id'] == $userid) {

                    $fourdata .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $fourdata .= '<div class="comment-details-menu">';

                    $fourdata .= '<div id="editcommentboxtwo' . $rowdata['business_profile_post_comment_id'] . '" style="display:block;">';
                    $fourdata .= '<a id="' . $rowdata['business_profile_post_comment_id'] . '"   onClick="comment_editboxtwo(this.id)" class="editbox">Edit
                                     </a>
                                     </div>';

                    $fourdata .= '<div id="editcancletwo' . $rowdata['business_profile_post_comment_id'] . '" style="display:none;">';
                    $fourdata .= '<a id="' . $rowdata['business_profile_post_comment_id'] . '" onClick="comment_editcancletwo(this.id)">Cancel</a></div></div>';
                }

                $userid = $this->session->userdata('aileenuser');
                $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $rowdata['business_profile_post_id'], 'status' => '1'))->row()->user_id;
                if ($rowdata['user_id'] == $userid || $business_userid == $userid) {

                    $fourdata .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $fourdata .= '<div class="comment-details-menu">';
                    $fourdata .= '<input type="hidden" name="post_delete"';
                    $fourdata .= 'id="post_deletetwo' . $rowdata['business_profile_post_comment_id'] . '"; value= "' . $rowdata['business_profile_post_id'] . '">';
                    $fourdata .= '<a id="' . $rowdata['business_profile_post_comment_id'] . '"onClick="comment_deletetwo(this.id)"> Delete<span class="insertcommenttwo' . $rowdata['business_profile_post_comment_id'] . '"></span></a></div>';
                }
                $fourdata .= '<span role="presentation" aria-hidden="true"> · </span>';
                $fourdata .= '<div class="comment-details-menu">';
//$fourdata .= '<p>' .  $bus_comment['created_date'] . '</br>';
//$fourdata .= '<p>' . date('Y-m-d H:i:s', strtotime($bus_comment['created_date'])) . '</br>';
                $fourdata .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($rowdata['created_date']))) . '</br>';

                $fourdata .= '</p></div></div></div>';
            }
        } else {
            $fourdata = 'No comments Available!!!';
        }
        $fourdata .= '</div>';

        echo $fourdata;
    }

    public function mulfourcomment($postid) {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $post_id = $_POST['bus_post_id'];

        $fourdata .= '<div class="insertcommenttwo' . $post_id . '">';

        $contition_array = array('post_image_id' => $post_id, 'is_delete' => '0');

        $busmulimage1 = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($busmulimage1) {
            foreach ($busmulimage1 as $rowdata) {

                $companyname = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id']))->row()->company_name;
                $companyslug = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id']))->row()->business_slug;

                $fourdata .= '<div class="all-comment-comment-box">';

                $fourdata .= '<div class="post-design-pro-comment-img">';

                $business_userimage = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id'], 'status' => '1'))->row()->business_user_image;

                if ($business_userimage != '') {
                    if (IMAGEPATHFROM == 'upload') {
                        if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                            $fourdata .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                        } else {
                            $fourdata .= '<img  src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '"  alt="'. $business_userimage .'">';
                        }
                    } else {
                        $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_userimage;
                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                        if (!$info) {
                            $fourdata .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                        } else {
                            $fourdata .= '<img  src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '"  alt="'. $business_userimage .'">';
                        }
                    }
                    $fourdata .= '</div>';
                } else {
                    $fourdata .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                    $fourdata .= '</div>';
                }
                $fourdata .= '<div class="comment-name"><a href="' . base_url() . 'business-profile/dashboard/' . $companyslug . '"><b>';
                $fourdata .= '' . ucfirst($companyname) . '</br>';
                $fourdata .= '</b></a></div>';
                $fourdata .= '<div class="comment-details" id= "showcommenttwo' . $rowdata['post_image_comment_id'] . '" style="display: block;">';
                $fourdata .= '' . $this->common->make_links($rowdata['comment']) . '</br> </div>';

                $fourdata .= '<div class="col-md-12"><div class="col-md-10">';

                $fourdata .= '<div contenteditable="true" class="editable_text" name="' . $rowdata['post_image_comment_id'] . '" id="editcommenttwo' . $rowdata['post_image_comment_id'] . '" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;"  onClick="commentedittwo(' . $rowdata['post_image_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">';
                $fourdata .= '' . $rowdata['comment'] . '</div>';

                $fourdata .= '</div>  <div class="col-md-2 comment-edit-button">';
                $fourdata .= '<button id="editsubmittwo' . $rowdata['post_image_comment_id'] . '" style="display:none" onClick="edit_commenttwo(' . $rowdata['post_image_comment_id'] . ')">Save</button></div> </div>';

                $fourdata .= '<div class="comment-details-menu" id="likecomment1' . $rowdata['post_image_comment_id'] . '">';

                $fourdata .= '<a id="' . $rowdata['post_image_comment_id'] . '"   onClick="imgcomment_liketwo(this.id)">';

                $userid = $this->session->userdata('aileenuser');
                $contition_array = array('post_image_comment_id' => $rowdata['post_image_comment_id'], 'user_id' => $userid, 'is_unlike' => '0');

                $businesscommentlike2 = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if (count($businesscommentlike2) == 0) {
                    $fourdata .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
                } else {
                    $fourdata .= '<i class="fa fa-thumbs-up" aria-hidden="true"></i>';
                }
                $fourdata .= '<span> ';

                $contition_array = array('post_image_comment_id' => $rowdata['post_image_comment_id'], 'is_unlike' => '0');
                $mulcountlike1 = $this->data['mulcountlike'] = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if (count($mulcountlike1) > 0) {
                    echo count($mulcountlike1);
                }


                $fourdata .= '</span></a></div>';
                $userid = $this->session->userdata('aileenuser');
                if ($rowdata['user_id'] == $userid) {

                    $fourdata .= '<div class="comment-details-menu">';
                    $fourdata .= '<div id="editcommentboxtwo' . $rowdata['post_image_comment_id'] . '" style="display:block;">';
                    $fourdata .= '<a id="' . $rowdata['post_image_comment_id'] . '"   onClick="comment_editboxtwo(this.id)" class="editbox">Edit
                                      </a>
                                      </div>';

                    $fourdata .= '<div id="editcancletwo' . $rowdata['post_image_comment_id'] . '" style="display:none;">';
                    $fourdata .= '<a id="' . $rowdata['post_image_comment_id'] . '" onClick="comment_editcancletwo(this.id)">Cancel </a></div>';

                    $fourdata .= '</div>';
                }

                $userid = $this->session->userdata('aileenuser');

                $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $rowdata['post_image_id'], 'status' => '1'))->row()->user_id;


                if ($rowdata['user_id'] == $userid || $business_userid == $userid) {

                    $fourdata .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $fourdata .= '<div class="comment-details-menu">';
                    $fourdata .= '<input type="hidden" name="post_deletetwo"';
                    $fourdata .= 'id="post_deletetwo' . $rowdata['post_image_comment_id'] . '" value= "' . $rowdata['post_image_id'] . '">';
                    $fourdata .= '<a id="' . $rowdata['post_image_comment_id'] . '"   onClick="comment_deletetwo(this.id)"> Delete<span class="insertcomment1' . $rowdata['post_image_comment_id'] . '">';
                    $fourdata .= '</span></a></div>';
                }

                $fourdata .= '<span role="presentation" aria-hidden="true"> · </span>';
                $fourdata .= '<div class="comment-details-menu">';
                $fourdata .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($rowdata['created_date']))) . '</br></p></div>';

                $fourdata .= '</div>';
            }
        }
        $fourdata .= '</div></div>';

        echo $fourdata;
    }

//postnews page controller start
//Business_profile comment delete start

    public function pnmulimagefourcomment() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $postid = $_POST['bus_img_id'];
        $mulimgfour = '<div class="insertimgcommenttwo' . $postid . '">';

        $contition_array = array('post_image_id' => $postid, 'is_delete' => '0');
        $busmulimage1 = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');



        if ($busmulimage1) {
            foreach ($busmulimage1 as $rowdata) {
                $companyname = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id']))->row()->company_name;
                $companyslug = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id'], 'status' => '1'))->row()->business_slug;

                $mulimgfour .= '<div class="all-comment-comment-box">';

                $mulimgfour .= '<div class="post-design-pro-comment-img">';

                $business_userimage = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id'], 'status' => '1'))->row()->business_user_image;
                if ($business_userimage != '') {
                    if (IMAGEPATHFROM == 'upload') {
                        if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                            $mulimgfour .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                        } else {
                            $mulimgfour .= '<img  src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '"  alt="'. $business_userimage .'">';
                        }
                    } else {
                        $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_userimage;
                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                        if (!$info) {
                            $mulimgfour .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                        } else {
                            $mulimgfour .= '<img  src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '"  alt="'. $business_userimage .'">';
                        }
                    }
                    $mulimgfour .= '</div>';
                } else {

                    $mulimgfour .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                    $mulimgfour .= '</div>';
                }
                $mulimgfour .= '<div class="comment-name"><a href="' . base_url() . 'business-profile/dashboard/' . $companyslug . '"><b>';
                $mulimgfour .= '' . ucfirst($companyname) . '</br></b></a></div>';
                $mulimgfour .= '<div class="comment-details" id="imgshowcommenttwo' . $rowdata['post_image_comment_id'] . '" style="display: block;">';


                $mulimgfour .= '' . $this->common->make_links($rowdata['comment']) . '</br></div>';


//                $mulimgfour .= '<div class="col-md-12"><div class="col-md-10">';
//                $mulimgfour .= '<input type="text" name="' . $rowdata['post_image_comment_id'] . '" id="imgeditcommenttwo' . $rowdata['post_image_comment_id'] . '" style="display: none;" value="' . $rowdata['comment'] . '" onkeyup="imgcommentedittwo(' . $rowdata['post_image_comment_id'] . ')">';
//
//                $mulimgfour .= '</div><div class="col-md-2 comment-edit-button">';
//                $mulimgfour .= '<button id="imgeditsubmittwo' . $rowdata['post_image_comment_id'] . '" style="display:none" onClick="imgedit_commenttwo(' . $rowdata['post_image_comment_id'] . ')">Save</button></div>';
//
//                $mulimgfour .= '</div>';

                $mulimgfour .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';
                $mulimgfour .= '<div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="' . $rowdata['post_image_comment_id'] . '"  id="imgeditcommenttwo' . $rowdata['post_image_comment_id'] . '" placeholder="Type Message ..." value= ""  onkeyup="imgcommentedittwo(' . $rowdata['post_image_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $rowdata['comment'] . '</div>';
                $mulimgfour .= '<span class="comment-edit-button"><button id="imgeditsubmittwo' . $rowdata['post_image_comment_id'] . '" style="display:none" onClick="imgedit_commenttwo(' . $rowdata['post_image_comment_id'] . ')">Save</button></span>';
                $mulimgfour .= '</div></div><div class="art-comment-menu-design">';
                $mulimgfour .= '<div class="comment-details-menu" id="imglikecomment1' . $rowdata['post_image_comment_id'] . '">';

                $mulimgfour .= '<a id="' . $rowdata['post_image_comment_id'] . '"   onClick="imgcomment_liketwo(this.id)">';

                $userid = $this->session->userdata('aileenuser');
                $contition_array = array('post_image_comment_id' => $rowdata['post_image_comment_id'], 'user_id' => $userid, 'is_unlike' => '0');

                $businesscommentlike2 = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
//echo "<pre>"; print_r($businesscommentlike); 
//echo count($businesscommentlike); 
                if (count($businesscommentlike2) == 0) {
                    $mulimgfour .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
                } else {
                    $mulimgfour .= '<i class="fa fa-thumbs-up" aria-hidden="true"></i>';
                }
                $mulimgfour .= '<span> ';

                $contition_array = array('post_image_comment_id' => $rowdata['post_image_comment_id'], 'is_unlike' => '0');
                $mulcountlike1 = $this->data['mulcountlike'] = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if (count($mulcountlike1) > 0) {
                    $mulimgfour .= count($mulcountlike1);
                }


                $mulimgfour .= '</span></a></div>';

                $userid = $this->session->userdata('aileenuser');
                if ($rowdata['user_id'] == $userid) {
                    $mulimgfour .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $mulimgfour .= '<div class="comment-details-menu">';

                    $mulimgfour .= '<div id="imgeditcommentboxtwo' . $rowdata['post_image_comment_id'] . '" style="display:block;">';
                    $mulimgfour .= '<a id="' . $rowdata['post_image_comment_id'] . '"   onClick="imgcomment_editboxtwo(this.id)" class="editbox">Edit</a></div>';

                    $mulimgfour .= '<div id="imgeditcancletwo' . $rowdata['post_image_comment_id'] . '" style="display:none;">';
                    $mulimgfour .= '<a id="' . $rowdata['post_image_comment_id'] . '" onClick="imgcomment_editcancletwo(this.id)">Cancel</a></div>';

                    $mulimgfour .= '</div>';
                }


                $userid = $this->session->userdata('aileenuser');

                $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $rowdata['post_image_id'], 'status' => '1'))->row()->user_id;

                if ($rowdata['user_id'] == $userid || $business_userid == $userid) {

                    $mulimgfour .= '<span role="presentation" aria-hidden="true"> · </span>
                                    <div class="comment-details-menu">';
                    $mulimgfour .= '<input type="hidden" name="imgpost_delete1"  id="imgpost_deletetwo_' . $rowdata['post_image_comment_id'] . '" value= "' . $rowdata['post_image_id'] . '">';
                    $mulimgfour .= '<a id="' . $rowdata['post_image_comment_id'] . '"   onClick="imgcomment_deletetwo(this.id)"> Delete<span class="imginsertcomment1' . $rowdata['post_image_comment_id'] . '"></span></a></div>';
                }


                $mulimgfour .= '<span role="presentation" aria-hidden="true"> · </span>
 <div class="comment-details-menu">';
                $mulimgfour .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($rowdata['created_date']))) . '</br></p></div></div></div>';
            }
        }
        $mulimgfour .= '</div>';

        echo $mulimgfour;
    }

//postnews page controller end

    public function likeuserlist() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $post_id = $_POST['post_id'];

        $contition_array = array('business_profile_post_id' => $post_id, 'status' => '1', 'is_delete' => '0');
        $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $likeuser = $commnetcount[0]['business_like_user'];
        $countlike = $commnetcount[0]['business_likes_count'] - 1;

        $likelistarray = explode(',', $likeuser);


        $modal = '<div class="modal-header">';
//     $modal .=   '<button type="button" class="close" data-dismiss="modal">&times;</button>';
        $modal .= '<h4 class="modal-title">';

        $modal .= '' . count($likelistarray) . ' Likes';

        $modal .= '</h4></div>';
        $modal .= '<div class="modal-body padding_less_right">';
        $modal .= '<div class="like_user_list">';
        $modal .= '<ul>';
        foreach ($likelistarray as $key => $value) {

            $bus_slug = $this->db->get_where('business_profile', array('user_id' => $value))->row()->business_slug;
            $business_fname = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => '1'))->row()->company_name;
            $bus_image = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => '1'))->row()->business_user_image;
            $bus_ind = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => '1'))->row()->industriyal;

            $bus_cat = $this->db->get_where('industry_type', array('industry_id' => $bus_ind, 'status' => '1'))->row()->industry_name;
            if ($bus_cat) {
                $category = $bus_cat;
            } else {
                $category = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => '1'))->row()->other_industrial;
            }
            $modal .= '<li>';
            $modal .= '<div class="like_user_listq">';
            $modal .= '<a href="' . base_url('business-profile/details/' . $bus_slug) . '" title="' . $business_fname1 . '" class="head_main_name" >';
            $modal .= '<div class="like_user_list_img">';
            if ($bus_image) {
                if (IMAGEPATHFROM == 'upload') {
                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $bus_image)) {
                        $modal .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                    } else {
                        $modal .= '<img  src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $bus_image . '"  alt="'. $bus_image .'">';
                    }
                } else {
                    $filename = $this->config->item('bus_profile_thumb_upload_path') . $bus_image;
                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                    if (!$info) {
                        $modal .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                    } else {
                        $modal .= '<img  src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $bus_image . '"  alt="'. $bus_image .'">';
                    }
                }
            } else {
                $modal .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
            }
            $modal .= '</div>';
            $modal .= '<div class="like_user_list_main_desc">';
            $modal .= '<div class="like_user_list_main_name">';
            $modal .= '' . ucfirst($business_fname) . '';
            $modal .= '</div></a>';
            $modal .= '<div class="like_user_list_current_work">';
            $modal .= '<span class="head_main_work">' . $category . '</span>';
            $modal .= '</div>';
            $modal .= '</div>';
            $modal .= '</div>';
            $modal .= '</li>';
        }
        $modal .= '</ul>';
        $modal .= '</div>';
        $modal .= '<div class="clearfix"></div>';
        $modal .= '</div>';
//  $modal .=  '<div class="modal-footer">';
// $modal .=  '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
//  $modal .=  '</div>';
//        echo '<div class="likeduser">';
//        echo '<div class="likeduser-title">User List</div>';
//        foreach ($likelistarray as $key => $value) {
//
//            $bus_slug = $this->db->get_where('business_profile', array('user_id' => $value))->row()->business_slug;
//
//            $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => '1'))->row()->company_name;
//            echo '<div class="likeuser_list"><a href="' . base_url('business-profile/details/' . $bus_slug) . '">';
//            echo ucwords($business_fname1);
//            echo '</a></div>';
//        }
//        echo '<div>';

        echo $modal;
    }

    public function imglikeuserlist() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $post_id = $_POST['post_id'];

        $contition_array = array('post_image_id' => $post_id, 'is_unlike' => '0');
        $commneteduser = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = 'user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $modal = '<div class="modal-header">';
        $modal .= '<h4 class="modal-title">';
        $modal .= '' . count($commneteduser) . ' Likes';
        $modal .= '</h4></div>';
        $modal .= '<div class="modal-body padding_less_right">';
        $modal .= '<div class="like_user_list">';
        $modal .= '<ul>';
        foreach ($commneteduser as $userlist) {

            $bus_slug = $this->db->get_where('business_profile', array('user_id' => $userlist['user_id']))->row()->business_slug;
            $business_fname = $this->db->get_where('business_profile', array('user_id' => $userlist['user_id'], 'status' => '1'))->row()->company_name;
            $bus_image = $this->db->get_where('business_profile', array('user_id' => $userlist['user_id'], 'status' => '1'))->row()->business_user_image;
            $bus_ind = $this->db->get_where('business_profile', array('user_id' => $userlist['user_id'], 'status' => '1'))->row()->industriyal;

            $bus_cat = $this->db->get_where('industry_type', array('industry_id' => $bus_ind, 'status' => '1'))->row()->industry_name;
            if ($bus_cat) {
                $category = $bus_cat;
            } else {
                $category = $this->db->get_where('business_profile', array('user_id' => $userlist['user_id'], 'status' => '1'))->row()->other_industrial;
            }
            $modal .= '<li>';
            $modal .= '<div class="like_user_listq">';
            $modal .= '<a href="' . base_url('business-profile/details/' . $bus_slug) . '" title="' . $business_fname1 . '" class="head_main_name" >';
            $modal .= '<div class="like_user_list_img">';
            if ($bus_image) {
                if (IMAGEPATHFROM == 'upload') {
                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $bus_image)) {
                        $modal .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                    } else {
                        $modal .= '<img  src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $bus_image . '"  alt="'. $bus_image .'">';
                    }
                } else {
                    $filename = $this->config->item('bus_profile_thumb_upload_path') . $bus_image;
                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                    if (!$info) {
                        $modal .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                    } else {
                        $modal .= '<img  src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $bus_image . '"  alt="'. $bus_image .'">';
                    }
                }
            } else {
                $modal .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
            }
            $modal .= '</div>';
            $modal .= '<div class="like_user_list_main_desc">';
            $modal .= '<div class="like_user_list_main_name">';
            $modal .= '' . ucfirst($business_fname) . '';
            $modal .= '</div></a>';
            $modal .= '<div class="like_user_list_current_work">';
            $modal .= '<span class="head_main_work">' . $category . '</span>';
            $modal .= '</div>';
            $modal .= '</div>';
            $modal .= '</div>';
            $modal .= '</li>';
        }
        $modal .= '</ul>';
        $modal .= '</div>';
        $modal .= '<div class="clearfix"></div>';
        $modal .= '</div>';

        echo $modal;

//        echo '<div class="likeduser">';
//        echo '<div class="likeduser-title">User List</div>';
//        foreach ($commneteduser as $userlist) {
//            $bus_slug = $this->db->get_where('business_profile', array('user_id' => $userlist['user_id']))->row()->business_slug;
//
//            $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $userlist['user_id'], 'status' => '1'))->row()->company_name;
//            echo '<div class="likeuser_list"><a href="' . base_url('business-profile/details/' . $bus_slug) . '">';
//            echo ucwords($business_fname1);
//            echo '</a></div>';
//        }
//        echo '<div>';
    }

    public function bus_img_delete() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $grade_id = $_POST['grade_id'];
        $delete_data = $this->common->delete_data('bus_image', 'bus_image_id', $grade_id);
        if ($delete_data) {
            echo 'ok';
        }
    }

    public function contact_person_query() {
        $s3 = new S3(awsAccessKey, awsSecretKey);

        $userid = $this->session->userdata('aileenuser');
        $to_id = $_POST['toid'];
        $status = $_POST['status'];


        $contition_array = array('contact_type' => '2');
        $search_condition = "((contact_to_id = '$to_id' AND contact_from_id = ' $userid') OR (contact_from_id = '$to_id' AND contact_to_id = '$userid'))";
        $contactperson = $this->common->select_data_by_search('contact_person', $search_condition, $contition_array, $data = 'status', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = '', $groupby = '');
        if ($contactperson[0]['status'] == $status) {
            echo 1;
        } else {
            echo 2;
        }
    }

    public function contact_person() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $to_id = $_POST['toid'];
        $userid = $this->session->userdata('aileenuser');
        $this->business_profile_active_check();
        $this->is_business_profile_register();

//if user deactive profile then redirect to business_profile/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_deleted' => '0');

        $business_deactive = $this->data['business_deactive'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($business_deactive) {
            redirect('business_profile/');
        }
//if user deactive profile then redirect to business_profile/index untill active profile End


        $contition_array = array('contact_type' => 2);
        $search_condition = "((contact_to_id = '$to_id' AND contact_from_id = ' $userid') OR (contact_from_id = '$to_id' AND contact_to_id = '$userid'))";
        $contactperson = $this->common->select_data_by_search('contact_person', $search_condition, $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = '', $groupby = '');



// $contition_array = array('contact_to_id' => $to_id, 'contact_from_id' => $userid);
// $contactperson = $this->common->select_data_by_condition('contact_person', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if ($contactperson) {

            $status = $contactperson[0]['status'];
            $contact_id = $contactperson[0]['contact_id'];

            if ($status == 'pending') {

                $data = array(
                    'modify_date' => date('Y-m-d H:i:s'),
                    'status' => 'cancel'
                );

//echo "<pre>"; print_r($data); die();
                $updatdata = $this->common->update_data($data, 'contact_person', 'contact_id', $contact_id);

                $contactdata = '<a href="#" onclick="return contact_person_query(' . $to_id . "," . "'" . 'cancel' . "'" . ');" style="cursor: pointer;">';
                $contactdata .= '<div><div class="add-contact"><div></div><div></div><div></div>
                                    <div><span class="cancel_req_busi"><img src="' . base_url('assets/img/icon_contact_add.png') . '" alt="icon_contact_add.png"></span></div>
                                    </div><div class="addtocont"><span class="ft-13"><i class="icon-user"></i>Add to contact </span></div></div>';
                $contactdata .= '</a>';
            } elseif ($status == 'cancel') {

                $data = array(
                    'contact_from_id' => $userid,
                    'contact_to_id' => $to_id,
                    'contact_type' => '2',
                    'created_date' => date('Y-m-d H:i:s'),
                    'status' => 'pending',
                    'not_read' => '2'
                );

                $updatdata = $this->common->update_data($data, 'contact_person', 'contact_id', $contact_id);
                $contactdata = '<a href="#" onclick="return contact_person_query(' . $to_id . "," . "'" . 'pending' . "'" . ');" style="cursor: pointer;">';
                $contactdata .= '<div class="cance_req_main_box"><div class="add-contact"><div></div><div></div><div></div>
                    <div><span class="cancel_req_busi"><img src="' . base_url('assets/img/icon_contact_cancel.png') . '" alt="icon_contact_cancel.png"></span></div>
                    </div><div class="addtocont"><span class="ft-13 cl_haed_s">Cancel request </span></div></div>';
                $contactdata .= '</a>';
            } elseif ($status == 'confirm') {
                $data = array(
                    'created_date' => date('Y-m-d H:i:s'),
                    'status' => 'cancel'
                );


                $updatdata = $this->common->update_data($data, 'contact_person', 'contact_id', $contact_id);
                $contactdata = '<a href="#" onclick="return contact_person_query(' . $to_id . "," . "'" . 'cancel' . "'" . ');" style="cursor: pointer;">';
                $contactdata .= '<div><div class="add-contact"><div></div><div></div><div></div>
                                <div><span class="cancel_req_busi"><img src="' . base_url('assets/img/icon_contact_add.png') . '" alt="icon_contact_add.png"></span></div>
                                </div><div class="addtocont"><span class="ft-13"><i class="icon-user"></i>Add to contact </span></div></div>';
                $contactdata .= '</a>';
            } elseif ($status == 'reject') {
                $data = array(
                    'contact_from_id' => $userid,
                    'contact_to_id' => $to_id,
                    'contact_type' => '2',
                    'created_date' => date('Y-m-d H:i:s'),
                    'status' => 'pending',
                    'not_read' => '2'
                );

                $updatdata = $this->common->update_data($data, 'contact_person', 'contact_id', $contact_id);
                $contactdata = '<a href="#" onclick="return contact_person_query(' . $to_id . "," . "'" . 'pending' . "'" . ');" style="cursor: pointer;">';
                $contactdata .= '<div class="cance_req_main_box"><div class="add-contact"><div></div><div></div><div></div>
                    <div><span class="cancel_req_busi">   <img src="' . base_url('assets/img/icon_contact_cancel.png') . '" alt="icon_contact_cancel.png"></span></div>
                    </div><div class="addtocont"><span class="ft-13 cl_haed_s">Cancel request </span></div></div>';
                $contactdata .= '</a>';
            }
        } else {
            $data = array(
                'contact_from_id' => $userid,
                'contact_to_id' => $to_id,
                'contact_type' => '2',
                'created_date' => date('Y-m-d H:i:s'),
                'status' => 'pending',
                'not_read' => '2'
            );

            $insert_id = $this->common->insert_data_getid($data, 'contact_person');
            if ($insert_id) {
                $to_email_id = $this->db->select('contact_email')->get_where('business_profile', array('user_id' => $to_id))->row()->contact_email;

                $email_html = '';
                $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;"><img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $this->data['business_login_user_image'] . '" width="50" height="50" alt="' . $this->data['business_login_user_image'] .'"></td>
                                            <td style="padding:5px;">
						<p><b>' . $this->data['business_login_company_name'] . '</b> send contact request in business profile.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a class="btn" href="' . BASEURL . 'business-profile/contact-list/' . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
                $subject = $this->data['business_login_company_name'] . ' send contact request you in Aileensoul.';

                $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $to_email_id);
            }

            $contactdata = '<a href="#" onclick="return contact_person_query(' . $to_id . "," . "'" . 'pending' . "'" . ');" style="cursor: pointer;">';
            $contactdata .= '<div class="cance_req_main_box"><div class="add-contact"><div></div><div></div><div></div>
                <div><span class="cancel_req_busi"><img src="' . base_url('assets/img/icon_contact_cancel.png') . '" alt="icon_contact_cancel.png"></span></div>
                </div><div class="addtocont"><span class="ft-13 cl_haed_s">Cancel request </span></div></div>';
            $contactdata .= '</a>';
        }

        //echo $contactdata;
        // GET NOTIFICATION COUNT
        $not_count = $this->business_contact_notification_count($to_id);

        echo json_encode(
                array(
                    "return_html" => $contactdata,
                    "status" => 'success',
                    "co_notification" => array('co_notification_count' => $not_count, 'co_to_id' => $to_id),
        ));
    }

    public function contact_notification() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('contact_to_id' => $userid, 'status' => 'pending');
        $contactperson_req = $this->common->select_data_by_condition('contact_person', $contition_array, $data = 'contact_id,contact_from_id,contact_to_id,contact_type,created_date,modify_date as action_date,status,contact_desc,not_read', $sortby = 'created_date', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $contition_array = array('contact_from_id' => $userid, 'status' => 'confirm');
        $contactperson_con = $this->common->select_data_by_condition('contact_person', $contition_array, $data = 'contact_id,contact_from_id,contact_to_id,contact_type,created_date,modify_date as action_date,status,contact_desc,not_read', $sortby = 'created_date', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $unique_user = array_merge($contactperson_req, $contactperson_con);
        $new = array();
        foreach ($unique_user as $value) {
            $new[$value['created_date']] = $value;
        }
        $post = array();
        foreach ($new as $key => $row) {
            $post[$key] = $row['created_date'];
        }
        array_multisort($post, SORT_DESC, $new);
        $contactperson = $new;

        foreach ($contactperson as $contact) {
            if ($contact['contact_to_id'] == $userid) {
                $contition_array = array('user_id' => $contact['contact_from_id'], 'status' => '1');
                $contactperson_from = $this->common->select_data_by_condition('user', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($contactperson_from) {
                    $busdata = $this->common->select_data_by_id('business_profile', 'user_id', $contact['contact_from_id'], $data = '*', $join_str = array());
                    $inddata = $this->common->select_data_by_id('industry_type', 'industry_id', $busdata[0]['industriyal'], $data = '*', $join_str = array());

                    $contactdata .= '<li>';
                    $contactdata .= '<div class="addcontact-left">';
                    $contactdata .= '<a href="' . base_url('business-profile/dashboard/' . $busdata[0]['business_slug']) . '">';
                    $contactdata .= '<div class="addcontact-pic">';

                    if ($busdata[0]['business_user_image']) {
                        if (IMAGEPATHFROM == 'upload') {
                            if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $busdata[0]['business_user_image'])) {
                                $contactdata .= '<img src="' . base_url() . NOBUSIMAGE . '" alt="NOBUSIMAGE">';
                            } else {

                                $contactdata .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $busdata[0]['business_user_image'] . '" alt="'. $busdata[0]['business_user_image'] .'">';
                            }
                        } else {
                            $filename = $this->config->item('bus_profile_thumb_upload_path') . $busdata[0]['business_user_image'];
                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                            if (!$info) {
                                $contactdata .= '<img src="' . base_url() . NOBUSIMAGE . '" alt="NOBUSIMAGE">';
                            } else {

                                $contactdata .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $busdata[0]['business_user_image'] . '" alt="'. $busdata[0]['business_user_image'] .'">';
                            }
                        }
                    } else {
                        /*    $a = $busdata[0]['company_name'];
                          $acr = substr($a, 0, 1);

                          $contactdata .= '<div class="post-img-div">';
                          $contactdata .= ucfirst(strtolower($acr));
                          $contactdata .= '</div>'; */
                        $contactdata .= '<img src="' . base_url() . NOBUSIMAGE . '" alt="NOBUSIMAGE">';
                    }
                    $contactdata .= '</div>';
                    $contactdata .= '<div class="addcontact-text">';
                    $contactdata .= '<span><b>' . ucfirst(strtolower($busdata[0]['company_name'])) . '</b></span>';
                    $contactdata .= '' . $inddata[0]['industry_name'] . '';
                    $contactdata .= '</div>';
                    $contactdata .= '</a>';
                    $contactdata .= '</div>';
                    $contactdata .= '<div class="addcontact-right">';
                    $contactdata .= '<a href="javascript:void(0);" class="add-left-true" onclick = "return contactapprove(' . $contact['contact_from_id'] . ',1);"><i class="fa fa-check" aria-hidden="true"></i></a>';
                    $contactdata .= '<a href="javascript:void(0);" class="add-right-true"  onclick = "return contactapprove(' . $contact['contact_from_id'] . ',0);"><i class="fa fa-times" aria-hidden="true"></i></a>';
                    $contactdata .= '</div>';
                    $contactdata .= '</li>';
                }
            } else {



                $contition_array = array('user_id' => $contact['contact_to_id'], 'status' => '1');
                $contactperson_to = $this->common->select_data_by_condition('user', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($contactperson_to) {
                    $busdata = $this->common->select_data_by_id('business_profile', 'user_id', $contact['contact_to_id'], $data = '*', $join_str = array());
                    $inddata = $this->common->select_data_by_id('industry_type', 'industry_id', $busdata[0]['industriyal'], $data = '*', $join_str = array());

                    $contactdata .= '<li>';
                    $contactdata .= '<div class="addcontact-left custome-approved-contact">';
                    $contactdata .= '<a href="' . base_url('business-profile/dashboard/' . $busdata[0]['business_slug']) . '">';
                    $contactdata .= '<div class="addcontact-pic">';

                    if ($busdata[0]['business_user_image']) {
                        if (IMAGEPATHFROM == 'upload') {
                            if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $busdata[0]['business_user_image'])) {
                                $contactdata .= '<img src="' . base_url() . NOBUSIMAGE . '" alt="NOBUSIMAGE">';
                            } else {
                                $contactdata .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $busdata[0]['business_user_image'] . '" alt="'. $busdata[0]['business_user_image'] .'">';
                            }
                        } else {
                            $filename = $this->config->item('bus_profile_thumb_upload_path') . $busdata[0]['business_user_image'];
                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                            if (!$info) {
                                $contactdata .= '<img src="' . base_url() . NOBUSIMAGE . '" alt="NOBUSIMAGE">';
                            } else {
                                $contactdata .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $busdata[0]['business_user_image'] . '" alt="'. $busdata[0]['business_user_image'] .'">';
                            }
                        }
                    } else {
//                        $a = $busdata[0]['company_name'];
//                        $acr = substr($a, 0, 1);
//
//                        $contactdata .= '<div class="post-img-div">';
//                        $contactdata .= ucfirst(strtolower($acr));
//                        $contactdata .= '</div>';
                        $contactdata .= '<img src="' . base_url() . NOBUSIMAGE . '" alt="NOBUSIMAGE">';
                    }
                    $contactdata .= '</div>';
                    $contactdata .= '<div class="addcontact-text_full">';
                    $contactdata .= '<span><b>' . ucfirst(strtolower($busdata[0]['company_name'])) . '</b> confirmed your contact request.</span>';
                    //$contactdata .= '' . $inddata[0]['industry_name'] . '';
                    $contactdata .= '<div class="data_noti_msg">';
                    $contactdata .= $this->time_elapsed_string($contact['action_date']);
                    $contactdata .= '</div>';
                    $contactdata .= '</div>';
                    $contactdata .= '</a>';
                    $contactdata .= '</div>';
                    $contactdata .= '</li>';
                }
            }
            //$contactdata .= '</ul>';
        }

        if ($contactperson) {
            $seeall = '<a class="fr" href="' . base_url() . 'business-profile/contact-list">See All</a>';
        } else {
            $seeall = '<div class="fw"><div class="art-img-nn">
                                                <div class="art_no_post_img">
                                                    <img src="' . base_url('assets/img/No_Contact_Request.png') . '" alt="No_Contact_Request.png">
                                                </div>
                                                <div class="art_no_post_text_c">
                                                    No Contact Request Available.
                                                </div>
                             </div></div>';
        }
        echo json_encode(
                array(
                    "contactdata" => $contactdata,
                    "seeall" => $seeall,
        ));
    }

    public function contact_approve() {
        $s3 = new S3(awsAccessKey, awsSecretKey);

        $toid = $_POST['toid'];
        $status = $_POST['status'];
        $userid = $this->session->userdata('aileenuser');
        //if user deactive profile then redirect to business_profile/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_deleted' => '0');
        $business_deactive = $this->data['business_deactive'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if ($business_deactive) {
            redirect('business-profile/');
        }
        //if user deactive profile then redirect to business_profile/index untill active profile End

        $contition_array = array('contact_from_id' => $toid, 'contact_to_id' => $userid, 'status' => 'pending');
        $person = $this->common->select_data_by_condition('contact_person', $contition_array, $data = 'contact_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $contactid = $person[0]['contact_id'];
        if ($status == 1) {
            $data = array(
                'modify_date' => date('Y-m-d H:i:s', time()),
                'status' => 'confirm',
                'not_read' => '2'
            );
            $updatdata = $this->common->update_data($data, 'contact_person', 'contact_id', $contactid);
        } else {
            $data = array(
                'modify_date' => date('Y-m-d H:i:s', time()),
                'status' => 'reject'
            );
            $updatdata = $this->common->update_data($data, 'contact_person', 'contact_id', $contactid);
        }

        $contition_array = array('contact_to_id' => $userid, 'status' => 'pending');
        $contactperson_req = $this->common->select_data_by_condition('contact_person', $contition_array, $data = 'contact_id,contact_from_id,contact_to_id,contact_type,created_date,modify_date as action_date,status,contact_desc,not_read', $sortby = 'created_date', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('contact_from_id' => $userid, 'status' => 'confirm');
        $contactperson_con = $this->common->select_data_by_condition('contact_person', $contition_array, $data = 'contact_id,contact_from_id,contact_to_id,contact_type,created_date,modify_date as action_date,status,contact_desc,not_read', $sortby = 'created_date', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $unique_user = array_merge($contactperson_req, $contactperson_con);

        $new = array();
        foreach ($unique_user as $value) {
            $new[$value['created_date']] = $value;
        }

        $post = array();

        foreach ($new as $key => $row) {

            $post[$key] = $row['created_date'];
        }
        array_multisort($post, SORT_DESC, $new);

        $contactperson = $new;

        if ($contactperson) {
            foreach ($contactperson as $contact) {
                $contactdata .= '<ul id="' . $contact['contact_id'] . '">';

                if ($contact['contact_to_id'] == $userid) {

                    $busdata = $this->common->select_data_by_id('business_profile', 'user_id', $contact['contact_from_id'], $data = '*', $join_str = array());
                    $inddata = $this->common->select_data_by_id('industry_type', 'industry_id', $busdata[0]['industriyal'], $data = '*', $join_str = array());

                    $contactdata .= '<li>';
                    //$contactdata .= '<div class="addcontact-left custome-approved-contact">';
                    $contactdata .= '<div class="addcontact-left">';
                    $contactdata .= '<a href="javascript:void(0);">';
                    $contactdata .= '<div class="addcontact-pic">';

                    if ($busdata[0]['business_user_image']) {
                        $contactdata .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $busdata[0]['business_user_image'] . '" alt="'. $busdata[0]['business_user_image'] .'">';
                    } else {
                        $contactdata .= '<img src="' . base_url(NOBUSIMAGE) . '" alt="NOBUSIMAGE">';
                    }
                    $contactdata .= '</div>';
                    $contactdata .= '<div class="addcontact-text_full">';
                    $contactdata .= '<span><b>' . $busdata[0]['company_name'] . '</b></span>';
                    $contactdata .= '' . $inddata[0]['industry_name'] . '';
                    $contactdata .= '</div>';
                    $contactdata .= '</a>';
                    $contactdata .= '</div>';
                    $contactdata .= '<div class="addcontact-right">';
                    $contactdata .= '<a href="javascript:void(0);" class="add-left-true" onclick = "return contactapprove(' . $contact['contact_from_id'] . ', 1);"><i class="fa fa-check" aria-hidden="true"></i></a>';
                    $contactdata .= '<a href="javascript:void(0);"  class="add-right-true" onclick = "return contactapprove(' . $contact['contact_from_id'] . ', 0);"><i class="fa fa-times" aria-hidden="true"></i></a>';
                    $contactdata .= '</div>';
                    $contactdata .= '</li>';
                } else {

                    $busdata = $this->common->select_data_by_id('business_profile', 'user_id', $contact['contact_to_id'], $data = '*', $join_str = array());


                    $inddata = $this->common->select_data_by_id('industry_type', 'industry_id', $busdata[0]['industriyal'], $data = '*', $join_str = array());

                    $contactdata .= '<li>';
                    $contactdata .= '<div class="addcontact-left custome-approved-contact">';
                    $contactdata .= '<a href="' . base_url('business-profile/dashboard/' . $busdata[0]['business_slug']) . '">';
                    $contactdata .= '<div class="addcontact-pic">';

                    if ($busdata[0]['business_user_image']) {
                        if (IMAGEPATHFROM == 'upload') {
                            if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $busdata[0]['business_user_image'])) {
                                $contactdata .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                            } else {
                                $contactdata .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $busdata[0]['business_user_image'] . '" alt="'. $busdata[0]['business_user_image'] . '">';
                            }
                        } else {
                            $filename = $this->config->item('bus_profile_thumb_upload_path') . $busdata[0]['business_user_image'];
                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                            if (!$info) {
                                $contactdata .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                            } else {
                                $contactdata .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $busdata[0]['business_user_image'] . '" alt="'. $busdata[0]['business_user_image'] .'">';
                            }
                        }
                    } else {
                        $contactdata .= '<img  src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                    }
                    $contactdata .= '</div>';
                    $contactdata .= '<div class="addcontact-text_full">';
                    $contactdata .= '<span><b>' . ucfirst(strtolower($busdata[0]['company_name'])) . '</b> confirmed your contact request.</span>';
//$contactdata .= '' . $inddata[0]['industry_name'] . '';
                    $contactdata .= '<div class="data_noti_msg">';
                    $contactdata .= $this->time_elapsed_string($contact['action_date']);
                    $contactdata .= '</div>';
                    $contactdata .= '</div>';
                    $contactdata .= '</a>';
                    $contactdata .= '</div>';
                    $contactdata .= '</li>';
                }
                $contactdata .= '</ul>';
            }
        } else {

//            $contactdata = '<ul>';
//            $contactdata .= '<li>';
//            $contactdata .= '<div class="addcontact-left">';
//            $contactdata .= '<a href="#">';
//            $contactdata .= '<div class="addcontact-text">';
//            $contactdata .= 'Not data available...';
//            $contactdata .= '</div>';
//            $contactdata .= '</a>';
//            $contactdata .= '</div>';
//            $contactdata .= '</div>';
//            $contactdata .= '</li>';
//            $contactdata .= '</ul>';

            $contactdata = '<div class="art-img-nn">
                                                <div class="art_no_post_img">
                                                    <img src="' . base_url('assets/img/No_Contact_Request.png') . '" alt="No_Contact_Request.png">
                                                </div>
                                                <div class="art_no_post_text_c">
                                                    No Contact Request Available
                                                </div>
                             </div>';
        }
//        echo $contactdata;

        $contition_array = array('contact_type' => '2', 'status' => 'confirm');
        $search_condition = "(contact_from_id = '$userid' OR contact_to_id = '$userid')";
        $contactpersonc = $this->common->select_data_by_search('contact_person', $search_condition, $contition_array, $data = '*', $sortby = 'contact_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = '', $groupby = '');
        $countdata = count($contactpersonc);
        $contactpersonc = $countdata;

        // GET NOTIFICATION COUNT
        $not_count = $this->business_contact_notification_count($toid);

        echo json_encode(
                array(
                    "contactdata" => $contactdata,
                    "contactcount" => $contactpersonc,
                    "status" => 'success',
                    "co_notification" => array('co_notification_count' => $not_count, 'co_to_id' => $toid),
        ));
    }

    public function contact_list() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        $this->business_profile_active_check();
        $this->is_business_profile_register();

        $bussdata = $this->common->select_data_by_id('business_profile', 'user_id', $userid, $data = '*', $join_str = array());

        $join_str[0]['table'] = 'business_profile';
        $join_str[0]['join_table_id'] = 'business_profile.user_id';
        $join_str[0]['from_table_id'] = 'contact_person.contact_from_id';
        $join_str[0]['join_type'] = '';

        $contition_array = array('contact_to_id' => $userid, 'contact_person.status' => 'pending');
        $friendlist_req = $this->data['friendlist_req'] = $this->common->select_data_by_condition('contact_person', $contition_array, $data = '*', $sortby = 'contact_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str, $groupby = '');

        $join_str[0]['table'] = 'business_profile';
        $join_str[0]['join_table_id'] = 'business_profile.user_id';
        $join_str[0]['from_table_id'] = 'contact_person.contact_to_id';
        $join_str[0]['join_type'] = '';

        $contition_array = array('contact_from_id' => $userid, 'contact_person.status' => 'confirm');
        $friendlist_con = $this->data['friendlist_con'] = $this->common->select_data_by_condition('contact_person', $contition_array, $data = '*', $sortby = strtotime('created_date'), $orderby = 'DESC', $limit = '', $offset = '', $join_str, $groupby = '');


        $this->data['friendlist'] = array_merge($friendlist_con, $friendlist_req);

        $company_name = $this->get_company_name($slug_id);
        $this->data['title'] = ucwords($company_name) . ' | Contact Request' . ' | Business Profile' . TITLEPOSTFIX;
        $this->load->view('business_profile/contact_list', $this->data);
    }

    public function ajax_contact_list() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $perpage = 9;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;

        $userid = $this->session->userdata('aileenuser');

        $bussdata = $this->common->select_data_by_id('business_profile', 'user_id', $userid, $data = '*', $join_str = array());

        $join_str[0]['table'] = 'business_profile';
        $join_str[0]['join_table_id'] = 'business_profile.user_id';
        $join_str[0]['from_table_id'] = 'contact_person.contact_from_id';
        $join_str[0]['join_type'] = '';

        $limit = $perpage;
        $offset = $start;

        $contition_array = array('contact_to_id' => $userid, 'contact_person.status' => 'pending');
        $friendlist_req = $this->common->select_data_by_condition('contact_person', $contition_array, $data = '*', $sortby = 'contact_id', $orderby = 'DESC', $limit, $offset, $join_str, $groupby = '');
        $friendlist_req1 = $this->common->select_data_by_condition('contact_person', $contition_array, $data = '*', $sortby = 'contact_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str, $groupby = '');

        $join_str[0]['table'] = 'business_profile';
        $join_str[0]['join_table_id'] = 'business_profile.user_id';
        $join_str[0]['from_table_id'] = 'contact_person.contact_to_id';
        $join_str[0]['join_type'] = '';

        $contition_array = array('contact_from_id' => $userid, 'contact_person.status' => 'confirm');
        $friendlist_con = $this->common->select_data_by_condition('contact_person', $contition_array, $data = '*', $sortby = 'contact_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str, $groupby = '');


        $friendlist = array_merge($friendlist_con, $friendlist_req);

        $return_html = '';

        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($friendlist_req1);
        }

        $return_html .= '<input type = "hidden" class = "page_number" value = "' . $page . '" />';
        $return_html .= '<input type = "hidden" class = "total_record" value = "' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';

        if ($friendlist_req) {
            foreach ($friendlist_req as $friend) {
                $inddata = $this->common->select_data_by_id('industry_type', 'industry_id', $friend['industriyal'], $data = '*', $join_str = array());


                $userid = $this->session->userdata('aileenuser');
                if ($friend['contact_to_id'] == $userid) {
                    $return_html .= '<li id="' . $friend['contact_from_id'] . '">
                                                    <div class="list-box">
                                                        <div class="profile-img">';
                    if ($friend['business_user_image'] != '') {
                        $return_html .= '<a href="' . base_url('business-profile/dashboard/' . $friend['business_slug']) . '">
                                                                    <img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $friend['business_user_image'] . '" alt="'. $friend['business_user_image'] .'">
                                                                </a>';
                    } else {
                        $return_html .= '<a href="' . base_url('business-profile/dashboard/' . $friend['business_slug']) . '">
                                                                    <img src="' . base_url(NOBUSIMAGE) . '" alt="NOBUSIMAGE"/>
                                                                </a>';
                    }
                    $return_html .= '</div>
                                                        <div class="profile-content">
                                                            <a  href="' . base_url('business-profile/dashboard/' . $friend['business_slug']) . '">
                                                                <div class="main_data_cq">   <span title="' . $friend['company_name'] . '" class="main_compny_name">' . $friend['company_name'] . '</span></div>
                                                                <div class="main_data_cq">';
                    if ($inddata[0]['industry_name']) {
                        $return_html .= '<span class="dc_cl_m"   title="' . $inddata[0]['industry_name'] . '">' . $inddata[0]['industry_name'] . '</span>';
                    } else {
                        $return_html .= '<span class="dc_cl_m"   title="' . $friend['other_industrial'] . '">' . $friend['other_industrial'] . '</span>';
                    }
                    $return_html .= '</div>
                                                            </a>
                                                            </span>

                                                        </div>
                                                        <div class="fw">
                                                            <p class="connect-link">
                                                                <a href="javascript:void(0);" class="cr-accept acbutton  ani" onclick = "return contactapprove1(' . $friend['contact_from_id'] . ', 1);"><span class="cr-accept1"><i class="fa fa-check" aria-hidden="true"></i>
                                                                    </span></a>
                                                                <a href="javascript:void(0);" class="cr-decline" onclick = "return contactapprove1(' . $friend['contact_from_id'] . ', 0);"><span class="cr-decline1"><i class="fa fa-times" aria-hidden="true"></i>
                                                                    </span></a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>';
                }
            }
        } else {

            $return_html .= '<li><div class="art-img-nn" id= "art-blank">
                                    <div class="art_no_post_img">

                                        <img src="' . base_url('assets/img/No_Contact_Request.png') . '" alt="No_Contact_Request.png">

                                    </div>
        <div class="art_no_post_text">
                                        No Contact Request Available
                                    </div>
                                    </div></li>';
        }
        echo $return_html;
    }

    public function contact_list_approve() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $toid = $_POST['toid'];
        $status = $_POST['status'];
        $userid = $this->session->userdata('aileenuser');

        //if user deactive profile then redirect to business_profile/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_deleted' => '0');

        $business_deactive = $this->data['business_deactive'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($business_deactive) {
            redirect('business_profile/');
        }
        //if user deactive profile then redirect to business_profile/index untill active profile End

        $contition_array = array('contact_from_id' => $toid, 'contact_to_id' => $userid, 'status' => 'pending');
        $person = $this->common->select_data_by_condition('contact_person', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $contactid = $person[0]['contact_id'];
        if ($status == 1) {
            $data = array(
                'modify_date' => date('Y-m-d', time()),
                'status' => 'confirm'
            );

            $updatdata = $this->common->update_data($data, 'contact_person', 'contact_id', $contactid);

            if ($updatdata) {

                $to_email_id = $this->db->select('contact_email')->get_where('business_profile', array('user_id' => $toid))->row()->contact_email;
                $email_html = '';
                $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;"><img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $this->data['business_login_user_image'] . '" width="50" height="50" alt="'. $this->data['business_login_user_image'] .'"></td>
                                            <td style="padding:5px;">
						<p><b>' . $this->data['business_login_company_name'] . '</b> is approved your contact request in business profile.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a class="btn" href="' . BASEURL . 'business-profile/contact-list/' . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
                $subject = $this->data['business_login_company_name'] . ' is approved your contact request in Aileensoul.';

                $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $to_email_id);
            }
        } else {

            $data = array(
                'modify_date' => date('Y-m-d', time()),
                'status' => 'reject'
            );

            $updatdata = $this->common->update_data($data, 'contact_person', 'contact_id', $contactid);
        }

        $contition_array = array('contact_to_id' => $userid, 'status' => 'pending');
        $contactperson = $this->common->select_data_by_condition('contact_person', $contition_array, $data = '*', $sortby = 'contact_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($contactperson) {
            foreach ($contactperson as $contact) {

                $busdata = $this->common->select_data_by_id('business_profile', 'user_id', $contact['contact_from_id'], $data = '*', $join_str = array());
                $inddata = $this->common->select_data_by_id('industry_type', 'industry_id', $busdata[0]['industriyal'], $data = '*', $join_str = array());
                //echo $busdata[0]['industriyal'];  echo '<pre>'; print_r($inddata); die();
                $contactdata .= '<li id="' . $contact['contact_from_id'] . '">';
                $contactdata .= '<div class="list-box">';
                $contactdata .= '<div class="profile-img">';
                if ($busdata[0]['business_user_image'] != '') {
                    if (IMAGEPATHFROM == 'upload') {
                        if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $busdata[0]['business_user_image'])) {
                            $contactdata .= '<img src="' . base_url() . NOBUSIMAGE . '" alt="NOBUSIMAGE">';
                        } else {
                            $contactdata .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $busdata[0]['business_user_image'] . '" alt="'. $busdata[0]['business_user_image'] . '">';
                        }
                    } else {
                        $filename = $this->config->item('bus_profile_thumb_upload_path') . $busdata[0]['business_user_image'];
                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                        if (!$info) {
                            $contactdata .= '<img src="' . base_url() . NOBUSIMAGE . '" alt="NOBUSIMAGE">';
                        } else {
                            $contactdata .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $busdata[0]['business_user_image'] . '" alt="'. $busdata[0]['business_user_image'] .'">';
                        }
                    }
                } else {
//                    $a = $busdata[0]['company_name'];
//                    $acr = substr($a, 0, 1);
//
//                    $contactdata .= '<div class="post-img-div">';
//                    $contactdata .= ucfirst(strtolower($acr));
//                    $contactdata .= '</div>';
                    $contactdata .= '<img src="' . base_url() . NOBUSIMAGE . '" alt="NOBUSIMAGE">';
                }

                $contactdata .= '</div>';
                $contactdata .= '<div class="profile-content">';
                $contactdata .= '<a href="' . base_url('business-profile/dashboard/' . $busdata[0]['business_slug']) . '">';
                $contactdata .= '<div class="main_data_cq">   <span title="' . $busdata[0]['company_name'] . '" class="main_compny_name">' . $busdata[0]['company_name'] . '</span></div>';
                $contactdata .= '<div class="main_data_cq"><span class="dc_cl_m" title="' . $inddata[0]['industry_name'] . '"> ' . $inddata[0]['industry_name'] . '</span></div>';
                $contactdata .= '</a></div>';
                $contactdata .= '<div class="fw"><p class="connect-link">';
                $contactdata .= '<a href="javascript:void(0);" class="cr-accept acbutton  ani" onclick = "return contactapprove1(' . $contact['contact_from_id'] . ',1);"><span class="cr-accept1"><i class="fa fa-check" aria-hidden="true"></i></span></a>';
                $contactdata .= '<a href="javascript:void(0);" class="cr-decline" onclick = "return contactapprove1(' . $contact['contact_from_id'] . ',0);"><span class="cr-decline1"><i class="fa fa-times" aria-hidden="true"></i></span></a>';
                $contactdata .= '</p>';
                $contactdata .= '</div>';
                $contactdata .= '</div>';
                $contactdata .= '</li>';
            }
        } else {
//            $contactdata = 'No contact request available...';
            $contactdata = '<li><div class="art-img-nn" id= "art-blank">
                                    <div class="art_no_post_img">

                                        <img src="' . base_url('assets/img/No_Contact_Request.png') . '" width="100" alt="No_Contact_Request.png">

                                    </div>
        <div class="art_no_post_text" style="font-size: 20px;">
                                        No Notifiaction Available.
                                    </div>
                                    </div></li>';
        }
        echo $contactdata;
    }

    public function bus_contact($id = "") {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $this->data['slug_id'] = $id;
        $company_name = $this->get_company_name($id);
        $this->data['title'] = ucwords($company_name) . ' | Contacts' . ' | Business Profile' . TITLEPOSTFIX;
        if ($company_name == '') {
            $this->load->view('business_profile/notavalible');
        } else {
            $this->load->view('business_profile/bus_contact', $this->data);
        }
    }

    public function ajax_bus_contact($id = "") {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $perpage = 5;
        $page = 1;
        $userid = $this->session->userdata('aileenuser');

        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;

        if ($id != '') {
            $business_user_id = $this->db->select('user_id')->get_where('business_profile', array('business_slug' => $id))->row()->user_id;
            $contition_array = array('contact_person.status' => 'confirm', 'contact_type' => '2');
            $search_condition = "(contact_to_id = '$business_user_id' OR contact_from_id = '$business_user_id')";
            $data = "contact_id,contact_from_id,contact_to_id,status";
            $contacts_user = $this->common->select_data_by_search('contact_person', $search_condition, $contition_array, $data, $sortby = 'contact_id', $orderby = 'DESC', $limit = $perpage, $offset = $start, $join_str = array(), $groupby = '');
            $contacts_user1 = $this->common->select_data_by_search('contact_person', $search_condition, $contition_array, $data, $sortby = 'contact_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {
            $business_user_id = $userid;
            $contition_array = array('contact_person.status' => 'confirm', 'contact_type' => '2');
            $search_condition = "(contact_to_id = '$userid' OR contact_from_id = '$userid')";
            $data = "contact_id,contact_from_id,contact_to_id,status";
            $contacts_user = $this->common->select_data_by_search('contact_person', $search_condition, $contition_array, $data, $sortby = 'contact_id', $orderby = 'DESC', $limit = $perpage, $offset = $start, $join_str = arrat(), $groupby = '');
            $contacts_user1 = $this->common->select_data_by_search('contact_person', $search_condition, $contition_array, $data, $sortby = 'contact_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }
        $return_html = '';
        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($contacts_user1);
        }
        $return_html .= '<input type = "hidden" class = "page_number" value = "' . $page . '" />';
        $return_html .= '<input type = "hidden" class = "total_record" value = "' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';
        if (count($contacts_user1) > 0) {
            foreach ($contacts_user as $user) {
                if ($user['contact_from_id'] == $business_user_id) {
                    $business_data = $this->db->select('company_name,industriyal,business_user_image,user_id,business_slug')->get_where('business_profile', array('user_id' => $user['contact_to_id']))->row();
                    $company_name = $business_data->company_name;
                    $industriyal = $business_data->industriyal;
                    $business_user_image = $business_data->business_user_image;
                    $user_id = $business_data->user_id;
                    $business_slug = $business_data->business_slug;
                } else {
                    $business_data = $this->db->select('company_name,industriyal,business_user_image,user_id,business_slug')->get_where('business_profile', array('user_id' => $user['contact_from_id']))->row();
                    $company_name = $business_data->company_name;
                    $industriyal = $business_data->industriyal;
                    $business_user_image = $business_data->business_user_image;
                    $user_id = $business_data->user_id;
                    $business_slug = $business_data->business_slug;
                }
                $user_industryal_name = $this->db->select('industry_name')->get_where('industry_type', array('industry_id' => $industriyal))->row()->industry_name;

                $this->db->select('status');
                $where = '((contact_to_id = ' . $userid . ' AND contact_from_id = ' . $user_id . ') OR (contact_from_id = ' . $userid . ' AND contact_to_id = ' . $user_id . '))';
                $this->db->where($where);
                $user_contact_status = $this->db->get('contact_person')->row()->status;

                $return_html .= '<div class="job-contact-frnd"><div class="profile-job-post-detail clearfix" id="removecontact' . $user_id . '">
    <div class="profile-job-post-title-inside clearfix">
        <div class="profile-job-post-location-name">
            <div class="user_lst">
                <ul>
                    <li class="fl">
                        <div class="follow-img">
                            <a href="' . base_url('business-profile/dashboard/' . $business_slug) . '">';
                if (IMAGEPATHFROM == 'upload') {
                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_user_image) || $business_user_image == '') {
                        $return_html .= '<img src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                    } else {
                        $return_html .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_user_image . '" height="50px" width="50px" alt="' . $company_name . '" >';
                    }
                } else {
                    $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_user_image;
                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                    if (!$info || $business_user_image == '') {
                        $return_html .= '<img src="' . base_url(NOBUSIMAGE) . '"  alt="NOBUSIMAGE">';
                    } else {
                        $return_html .= '<img src="' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_user_image . '" height="50px" width="50px" alt="' . $company_name . '" >';
                    }
                }

                $return_html .= '</a>
                        </div>
                    </li>
                    <li class="bui_bcon">
                        <div class="">
                            <div class="follow-li-text " style="padding: 0;">
                                <a href="' . base_url('business-profile/dashboard/' . $business_slug) . '">' . $company_name . '</a>
                            </div>
                            <div><a>' . $user_industryal_name . '</a>
                            </div>
                        </div>
                    </li>';
                if ($user_id == $userid) {
                    
                } else {
                    if ($user_contact_status == 'cancel') {
                        $return_html .= '<li class="fr">
                        <div class="user_btn" id="statuschange' . $user_id . '">
                            <button onclick="contact_person_menu(' . $user_id . ')" class="contact_user_list">
                                Add to contact
                            </button>
                        </div>
                    </li>';
                    } elseif ($user_contact_status == 'pending') {
                        $return_html .= '<li class="fr">
                        <div class="user_btn" id="statuschange' . $user_id . '">
                            <button onclick="contact_person_cancle(' . $user_id . ", 'pending'" . ')" class="contact_user_list">
                                Cancel request
                            </button>
                        </div>
                    </li>';
                    } else if ($user_contact_status == 'confirm') {
                        $return_html .= '<li class="fr">
                        <div class="user_btn cont_req" id="statuschange' . $user_id . '">
                            <button onclick="contact_person_cancle(' . $user_id . ", 'confirm'" . ')" class="contact_user_list">
                                In contacts
                            </button>
                        </div>
                    </li>';
                    } else if ($user_contact_status == 'reject') {
                        $return_html .= '<li class="fr">
                        <div class="user_btn" id="statuschange' . $user_id . '">
                            <button onclick="contact_person_menu(' . $user_id . ')" class="contact_user_list">
                                Add to contact
                            </button>
                        </div>
                    </li>';
                    } else {
                        $return_html .= '<li class="fr">
                        <div class="user_btn" id="statuschange' . $user_id . '">
                            <button onclick="contact_person_menu(' . $user_id . ')" class="contact_user_list">
                                Add to contact
                            </button>
                        </div>
                    </li>';
                    }
                }
                $return_html .= '</ul>
            </div>
        </div>
    </div>
</div></div>';
            }
        }
        echo $return_html;
    }

    public function removecontactuser() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $to_id = $_POST["contact_id"];
        $showdata = $_POST["showdata"];

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('contact_type' => '2');
        $search_condition = "((contact_to_id = ' $to_id' AND contact_from_id = ' $userid') OR (contact_from_id = ' $to_id' AND contact_to_id = '$userid'))";
        $contactperson = $this->common->select_data_by_search('contact_person', $search_condition, $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = '', $groupby = '');

        $contact_id = $contactperson[0]['contact_id'];
        $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
        $businessdata1 = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo $businessdata1[0]['business_slug']; die();

        $data = array(
            'modify_date' => date('Y-m-d H:i:s'),
            'status' => 'cancel'
        );

//echo "<pre>"; print_r($data); die();
        $updatdata = $this->common->update_data($data, 'contact_person', 'contact_id', $contact_id);

//$contactdata =  '<button>';
// for count list user start

        $contition_array = array('contact_person.status' => 'confirm', 'contact_type' => '2');
        $search_condition = "(contact_to_id = '$userid' OR contact_from_id = '$userid')";
        $unique_user = $this->common->select_data_by_search('contact_person', $search_condition, $contition_array, $data = '*', $sortby = 'contact_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = '', $groupby = '');

        $datacount = count($unique_user);
        $contactdata = '<button onClick = "contact_person_menu(' . $to_id . ')">';
        $contactdata .= ' Add to contact';
        $contactdata .= '</button>';


        if (count($unique_user) == 0) {
            $nomsg = ' <div class = "art-img-nn">
<div class = "art_no_post_img">

<img src = "' . base_url('assets/img/No_Contact_Request.png') . '" alt="No_Contact_Request.png">

</div>
<div class = "art_no_post_text">
No Contacts Available.
</div>
</div>
';
        }

        if ($showdata == $businessdata1[0]['business_slug']) {
            echo json_encode(
                    array("contactdata" => $contactdata,
                        "notfound" => '1',
                        "notcount" => $datacount,
                        "nomsg" => $nomsg,
            ));
        } else {
            echo json_encode(
                    array("contactdata" => $contactdata,
                        "notfound" => '2',
                        "notcount" => $datacount,
                        "nomsg" => $nomsg,
            ));
        }
    }

// for contact list function start


    public function contact_person_menu() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $to_id = $_POST['toid'];
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('contact_type' => '2');
        $search_condition = "((contact_to_id = ' $to_id' AND contact_from_id = ' $userid') OR (contact_from_id = ' $to_id' AND contact_to_id = '$userid'))";
        $contactperson = $this->common->select_data_by_search('contact_person', $search_condition, $contition_array, $data = 'status,contact_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = '', $groupby = '');
        if ($contactperson) {

            $status = $contactperson[0]['status'];
            $contact_id = $contactperson[0]['contact_id'];

            if ($status == 'pending') {
                $data = array(
                    'modify_date' => date('Y-m-d H:i:s'),
                    'status' => 'cancel'
                );

                $updatdata = $this->common->update_data($data, 'contact_person', 'contact_id', $contact_id);

                $contactdata = '<button class="contact_user_list" onClick = "contact_person_menu(' . $to_id . ')">';
                $contactdata .= ' Add to contact';
                $contactdata .= '</button>';
            } elseif ($status == 'cancel') {
                $data = array(
                    'contact_from_id' => $userid,
                    'contact_to_id' => $to_id,
                    'created_date' => date('Y-m-d H:i:s'),
                    'status' => 'pending',
                    'not_read' => '2'
                );
                $updatdata = $this->common->update_data($data, 'contact_person', 'contact_id', $contact_id);
                $contactdata = '<button onClick = "contact_person_cancle(' . $to_id . ", " . "'" . 'pending' . "'" . ')" class="contact_user_list">';
                $contactdata .= 'Cancel request';
                $contactdata .= '</button>';
            } elseif ($status == 'reject') {
                $data = array(
                    'created_date' => date('Y-m-d H:i:s'),
                    'status' => 'pending',
                    'not_read' => '2'
                );

                $updatdata = $this->common->update_data($data, 'contact_person', 'contact_id', $contact_id);
                $contactdata = '<button onClick = "contact_person_cancle(' . $to_id . ", " . "'" . 'pending' . "'" . ')" class="contact_user_list">';
                $contactdata .= 'Cancel request';
                $contactdata .= '</button>';
            }
        } else {

            $data = array(
                'contact_from_id' => $userid,
                'contact_to_id' => $to_id,
                'contact_type' => '2',
                'created_date' => date('Y-m-d H:i:s'),
                'status' => 'pending',
                'not_read' => '2'
            );

            $insert_id = $this->common->insert_data_getid($data, 'contact_person');

            $contactdata = '<button onClick = "contact_person_cancle(' . $to_id . ", " . "'" . 'pending' . "'" . ')" class="contact_user_list">';
            $contactdata .= 'Cancel request';
            $contactdata .= '</button>';
        }

        //echo $contactdata;
        // GET NOTIFICATION COUNT
        $not_count = $this->business_contact_notification_count($to_id);

        echo json_encode(
                array(
                    "return_html" => $contactdata,
                    "status" => 'success',
                    "co_notification" => array('co_notification_count' => $not_count, 'co_to_id' => $to_id),
        ));
    }

//contact list end
//conatct request count start

    public function contact_count() {
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('not_read' => '2');
        $search_condition = "((contact_to_id = '$userid' AND status = 'pending') OR (contact_from_id = '$userid' AND status = 'confirm'))";
        $contactperson = $this->common->select_data_by_search('contact_person', $search_condition, $contition_array, $data = 'count(*) as total', $sortby = 'contact_id', $orderby = '', $limit = '', $offset = '', $join_str = '', $groupby = '');

        $contactcount = $contactperson[0]['total'];
        echo $contactcount;
    }

    public function update_contact_count() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('not_read' => '2', 'contact_to_id' => $userid, 'status' => 'pending');
        $result_req = $this->common->select_data_by_condition('contact_person', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('not_read' => '2', 'contact_from_id' => $userid, 'status' => 'confirm');
        $result_con = $this->common->select_data_by_condition('contact_person', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $result = array_merge($result_req, $result_con);
        $data = array(
            'not_read' => '1'
        );

        foreach ($result as $cnt) {
            $updatedata = $this->common->update_data($data, 'contact_person', 'contact_id', $cnt['contact_id']);
        }
        $count = count($updatedata);
        echo $count;
    }

//contact request count end


    public function edit_more_insert() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $post_id = $_POST["business_profile_post_id"];

        $contition_array = array('business_profile_post_id' => $_POST["business_profile_post_id"], 'status' => '1');
        $businessdata = $this->data['businessdata'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($this->data['businessdata'][0]['product_description']) {

            $editpostdes .= nl2br($this->common->make_links($this->data['businessdata'][0]['product_description']));
        }
        echo json_encode(
                array(
                    "description" => $editpostdes
        ));
    }

    public function ajax_business_home_post() {
// return html

        $s3 = new S3(awsAccessKey, awsSecretKey);
        $business_login_slug = $this->data['business_login_slug'];
        $perpage = 4;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;

        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

        $business_profile_id = $this->data['business_common_data'][0]['business_profile_id'];
        $city = $this->data['business_common_data'][0]['city'];
        $user_id = $this->data['business_common_data'][0]['user_id'];
        $business_user_image = $this->data['business_common_data'][0]['business_user_image'];
        $business_slug = $this->data['business_common_data'][0]['business_slug'];
        $company_name = $this->data['business_common_data'][0]['company_name'];
        $profile_background = $this->data['business_common_data'][0]['profile_background'];
        $state = $this->data['business_common_data'][0]['state'];
        $industriyal = $this->data['business_common_data'][0]['industriyal'];
        $other_industrial = $this->data['business_common_data'][0]['other_industrial'];

        /* SELF USER LIST START */
        $self_list = array($userid);
        /* SELF USER LIST END */

        /* FOLLOWER USER LIST START */
        $condition_array = array('follow_from' => $business_profile_id, 'follow_status' => '1', 'follow_type' => '2');
        $join_str[0]['table'] = 'business_profile';
        $join_str[0]['join_table_id'] = 'business_profile.business_profile_id';
        $join_str[0]['from_table_id'] = 'follow.follow_to';
        $join_str[0]['join_type'] = '';
        $followerdata = $this->data['followerdata'] = $this->common->select_data_by_condition('follow', $condition_array, $data = 'GROUP_CONCAT(user_id) as follow_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        $follower_list = $followerdata[0]['follow_list'];
        $follower_list = explode(',', $follower_list);
        /* FOLLOWER USER LIST END */

        /* INDUSTRIAL AND CITY WISE DATA START */
        $condition_array = array('business_profile.is_deleted' => '0', 'business_profile.status' => '1', 'business_profile.business_step' => '4');
        $search_condition = "(business_profile.industriyal = '$industriyal' AND business_profile.industriyal != 0) AND (business_profile.other_industrial = '$other_industrial' AND business_profile.other_industrial != '') OR (business_profile.city = '$city')";
        $data = "GROUP_CONCAT(user_id) as industry_city_user_list";
        $industrial_city_data = $this->common->select_data_by_search('business_profile', $search_condition, $condition_array, $data, $sortby = '', $orderby = 'DESC', $limit = '', $offset = '', $join_str_contact = array(), $groupby = '');
        $industrial_city_list = $industrial_city_data[0]['industry_city_user_list'];
        $industrial_city_list = explode(',', $industrial_city_list);
        /* INDUSTRIAL AND CITY WISE DATA END */

        $total_user_list = array_merge($self_list, $follower_list, $industrial_city_list);
        $total_user_list = array_unique($total_user_list, SORT_REGULAR);
        $total_user_list = implode(',', $total_user_list);
        $total_user_list = str_replace(",", "','", $total_user_list);

        $condition_array = array('business_profile_post.is_delete' => '0', 'business_profile_post.status' => '1', 'FIND_IN_SET ("' . $user_id . '", delete_post) !=' => '0');
        $delete_postdata = $this->common->select_data_by_condition('business_profile_post', $condition_array, $data = 'GROUP_CONCAT(business_profile_post_id) as delete_post_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $delete_post_id = $delete_postdata[0]['delete_post_id'];
        $delete_post_id = str_replace(",", "','", $delete_post_id);

        $condition_array = array('business_profile_post.is_delete' => '0', 'business_profile_post.status' => '1');
        $search_condition = "`business_profile_post_id` NOT IN ('$delete_post_id') AND (business_profile_post.user_id IN ('$total_user_list')) OR (posted_user_id ='$user_id' AND is_delete=0)";
        $join_str[0]['table'] = 'business_profile';
        $join_str[0]['join_table_id'] = 'business_profile.user_id';
        $join_str[0]['from_table_id'] = 'business_profile_post.user_id';
        $join_str[0]['join_type'] = '';
        $data = "business_profile.business_user_image,business_profile.company_name,business_profile.industriyal,business_profile.business_slug,business_profile.other_industrial,business_profile.business_slug,business_profile_post.business_profile_post_id,business_profile_post.product_name,business_profile_post.product_description,business_profile_post.business_likes_count,business_profile_post.business_like_user,business_profile_post.created_date,business_profile_post.posted_user_id,business_profile.user_id";
        $business_profile_post = $this->common->select_data_by_search('business_profile_post', $search_condition, $condition_array, $data, $sortby = 'business_profile_post_id', $orderby = 'DESC', $limit = $perpage, $offset = $start, $join_str, $groupby = '');
        $business_profile_post1 = $this->common->select_data_by_search('business_profile_post', $search_condition, $condition_array, $data, $sortby = 'business_profile_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str, $groupby = '');

        $return_html = '';

        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($business_profile_post1);
        }

        $return_html .= '<input type = "hidden" class = "page_number" value = "' . $page . '" />';
        $return_html .= '<input type = "hidden" class = "total_record" value = "' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';

        if (count($business_profile_post1) > 0) {
            foreach ($business_profile_post as $row) {

                $post_business_user_image = $row['business_user_image'];
                $post_company_name = $row['company_name'];
                $post_business_profile_post_id = $row['business_profile_post_id'];
                $post_product_name = $row['product_name'];
                //$post_product_image = $row['product_image'];
                $post_product_description = $row['product_description'];
                $post_business_likes_count = $row['business_likes_count'];
                $post_business_like_user = $row['business_like_user'];
                $post_created_date = $row['created_date'];
                $post_posted_user_id = $row['posted_user_id'];
                $post_business_slug = $row['business_slug'];
                $post_industriyal = $row['industriyal'];
                $post_user_id = $row['user_id'];
                $post_category = $this->db->get_where('industry_type', array('industry_id' => $post_industriyal, 'status' => '1'))->row()->industry_name;
                $post_other_industrial = $row['other_industrial'];
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
                        if (IMAGEPATHFROM == 'upload') {
                            if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $posted_business_user_image)) {
                                $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                            } else {
                                $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $posted_business_user_image . '" name = "image_src" id = "image_src"  alt="'. $posted_business_user_image .'" />';
                            }
                        } else {
                            $filename = $this->config->item('bus_profile_thumb_upload_path') . $posted_business_user_image;
                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                            if (!$info) {
                                $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                            } else {
                                $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $posted_business_user_image . '" name = "image_src" id = "image_src" alt="'. $posted_business_user_image .'"/>';
                            }
                        }

                        $return_html .= '</a>';
                    } else {
                        $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $posted_business_slug) . '">';
                        $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                        $return_html .= '</a>';
                    }
                } else {
                    if ($post_business_user_image) {
                        $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $post_business_slug) . '">';
                        if (IMAGEPATHFROM == 'upload') {
                            if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $post_business_user_image)) {
                                $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                            } else {
                                $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $post_business_user_image . '" alt = "'. $post_business_user_image .'">';
                            }
                        } else {
                            $filename = $this->config->item('bus_profile_thumb_upload_path') . $post_business_user_image;
                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                            if (!$info) {
                                $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                            } else {
                                $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $post_business_user_image . '" alt = "'. $post_business_user_image .'">';
                            }
                        }

                        $return_html .= '</a>';
                    } else {
                        $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $post_business_slug) . '">';
                        $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
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
<span class = "ctre_date">
' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($post_created_date))) . '
</span> </div></div>
</li>';
                } else {
                    $return_html .= '<li>
                            <div class = "post-design-product">
                                <a class = "post_dot" href = "' . base_url('business-profile/dashboard/' . $post_business_slug) . '" title = "' . ucfirst(strtolower($post_company_name)) . '">
' . ucfirst($post_company_name) . '</a><div class = "datespan"> <span class = "ctre_date" >
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
<a onClick = "myFunction(' . $post_business_profile_post_id . ')" class = "dropbtn_common  dropbtn1 fa fa-ellipsis-v">
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
                $businessmultiimage = $this->common->select_data_by_condition('post_files', $contition_array, $data = 'file_name,post_files_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

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
<img src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" alt="'. $businessmultiimage[0]['file_name'] .'">
</a>
</div>';
                    } elseif (in_array($ext, $allowespdf)) {

                        /*    $return_html .= '<div>
                          <a title = "click to open" href = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '"><div class = "pdf_img">
                          <embed src="' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" width="100%" height="450px" />
                          </div>
                          </a>
                          </div>'; */
                        $return_html .= '<div>
<a title = "click to open" href = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" target="_blank"><div class = "pdf_img">
    <img src="' . base_url('assets/images/PDF.jpg') . '" alt="PDF.jpg">
</div>
</a>
</div>';
                    } elseif (in_array($ext, $allowesvideo)) {
                        $post_poster = $businessmultiimage[0]['file_name'];
                        $post_poster1 = explode('.', $post_poster);
                        $post_poster2 = end($post_poster1);
                        $post_poster = str_replace($post_poster2, 'png', $post_poster);


                        $return_html .= '<div>
<video width = "100%" height = "350" poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '" id="show_video' . $businessmultiimage[0]['post_files_id'] . '" onplay="playtime(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ')" onClick="count_videouser(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ');" controls playsinline webkit-playsinline>
<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" type = "video/mp4">
Your browser does not support the video tag.
</video>
</div>';
                    } elseif (in_array($ext, $allowesaudio)) {

                        $return_html .= '<div class = "audio_main_div">
<div class = "audio_img">
<img src = "' . base_url('assets/images/music-icon.png') . '" alt="music-icon.png">
</div>
<div class = "audio_source">
<audio id = "audio_player" width = "100%" height = "100" controls>
<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" type = "audio/mp3">
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
<img class = "two-columns" src = "' . BUS_POST_RESIZE1_UPLOAD_URL . $multiimage['file_name'] . '" alt="'. $multiimage['file_name'] .'">
</a>
</div>';
                    }
                } elseif (count($businessmultiimage) == 3) {

                    $return_html .= '<div class = "three-image-top" >
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img class = "three-columns" src = "' . BUS_POST_RESIZE4_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" alt="'. $businessmultiimage[0]['file_name'] .'">
</a>
</div>
<div class = "three-image" >

<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img class = "three-columns" src = "' . BUS_POST_RESIZE1_UPLOAD_URL . $businessmultiimage[1]['file_name'] . '" alt="'. $businessmultiimage[1]['file_name'] .'">
</a>
</div>
<div class = "three-image" >
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img class = "three-columns" src = "' . BUS_POST_RESIZE1_UPLOAD_URL . $businessmultiimage[2]['file_name'] . '" alt="'. $businessmultiimage[2]['file_name'] .'">
</a>
</div>';
                } elseif (count($businessmultiimage) == 4) {

                    foreach ($businessmultiimage as $multiimage) {

                        $return_html .= '<div class = "four-image">
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img class = "breakpoint" src = "' . BUS_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name'] . '" alt="'. $multiimage['file_name'] .'">
</a>
</div>';
                    }
                } elseif (count($businessmultiimage) > 4) {

                    $i = 0;
                    foreach ($businessmultiimage as $multiimage) {

                        $return_html .= '<div class = "four-image">
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img src = "' . BUS_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name'] . '" alt="'. $multiimage['file_name'] .'">
</a>
</div>';

                        $i++;
                        if ($i == 3)
                            break;
                    }

                    $return_html .= '<div class = "four-image">
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img src = "' . BUS_POST_RESIZE2_UPLOAD_URL . $businessmultiimage[3]['file_name'] . '" alt="'. $businessmultiimage[3]['file_name'] .'">
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
<ul class = "col-md-6 col-sm-6 col-xs-6 like_cmnt_count">';

                $contition_array = array('post_id' => $row['business_profile_post_id'], 'insert_profile' => '2');
                $postformat = $this->common->select_data_by_condition('post_files', $contition_array, $data = 'post_format', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                //echo "<pre>"; print_r($postformat); die();
                if ($postformat[0]['post_format'] == 'video') {
                    $return_html .= '<li id="viewvideouser' . $row['business_profile_post_id'] . '">';

                    $contition_array = array('post_id' => $row['business_profile_post_id']);
                    $userdata = $this->common->select_data_by_condition('bus_showvideo', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    $user_data = count($userdata);

                    if ($user_data > 0) {

                        $return_html .= '<div class="comnt_count_ext_a  comnt_count_ext2"><span>';

                        $return_html .= $user_data . ' ' . 'Views';

                        $return_html .= '</span></div></li>';
                    }
                }

                $return_html .= '<li>
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

                    $return_html .= '<div class = "like_one_other">';
                    $return_html .= '<a href = "javascript:void(0);" onclick = "likeuserlist(' . $post_business_profile_post_id . ')">';

                    $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $likelistarray[0], 'status' => '1'))->row()->company_name;

                    if (in_array($userid, $likelistarray)) {
                        $return_html .= "You";
                        $return_html .= "&nbsp;";
                    } else {
                        $return_html .= ucfirst($business_fname1);
                        $return_html .= "&nbsp;";
                    }
//                    echo count($likelistarray);
                    if (count($likelistarray) > 1) {
                        $return_html .= " and ";

                        $return_html .= $countlike;
                        $return_html .= "&nbsp;";
                        $return_html .= "others";
                    }
                    $return_html .= '</a></div>
</div>';
                }

                $return_html .= '<div class = "likeusername' . $post_business_profile_post_id . '" id = "likeusername' . $post_business_profile_post_id . '" style = "display:none">';

                $likeuser = $post_business_like_user;
                $countlike = $post_business_likes_count - 1;
                $likelistarray = explode(', ', $likeuser);


                $likeuser = $post_business_like_user;
                $countlike = $post_business_likes_count - 1;
                $likelistarray = explode(', ', $likeuser);

                $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => '1'))->row()->company_name;

                $return_html .= '<div class = "like_one_other">';
                $return_html .= '<a href = "javascript:void(0);" onclick = "likeuserlist(' . $post_business_profile_post_id . ')">';
                $return_html .= ucfirst($business_fname1);
                $return_html .= "&nbsp;";

                if (count($likelistarray) > 1) {

                    $return_html .= "and";

                    $return_html .= $countlike;
                    $return_html .= "&nbsp;";
                    $return_html .= "others";
                }
                $return_html .= '</a></div>
</div>

<div class = "art-all-comment col-md-12">
<div id = "fourcomment' . $post_business_profile_post_id . '" style = "display:none;">
</div>
<div id = "threecomment' . $post_business_profile_post_id . '" style = "display:block">
<div class = "hidebottomborder insertcomment' . $post_business_profile_post_id . '">';

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
                            if (IMAGEPATHFROM == 'upload') {
                                if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                                    $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                                } else {
                                    $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt = "'. $business_userimage .'">';
                                }
                            } else {
                                $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_userimage;
                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                if (!$info) {
                                    $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                                } else {
                                    $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt = "'. $business_userimage .'">';
                                }
                            }
                            $return_html .= '</a>';
                        } else {
                            $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $slugname1) . '">';

                            $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE"></a>';
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
<div contenteditable = "true" class = "editable_text editav_2" name = "' . $rowdata['business_profile_post_comment_id'] . '" id = "editcomment' . $rowdata['business_profile_post_comment_id'] . '" placeholder = "Enter Your Comment " value = "" onkeyup = "commentedit(' . $rowdata['business_profile_post_comment_id'] . ')" onclick="commentedit(' . $rowdata['business_profile_post_comment_id'] . ')" onpaste = "OnPaste_StripFormatting(this, event);">' . $rowdata['comments'] . '</div>
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

                        $return_html .= '</span>
</a>
</div>';
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
                        $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $rowdata['business_profile_post_id'], 'status' => '1'))->row()->user_id;
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
                    if (IMAGEPATHFROM == 'upload') {
                        if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                            $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                        } else {
                            $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt = "'. $business_userimage . '">';
                        }
                    } else {
                        $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_userimage;
                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                        if (!$info) {
                            $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                        } else {
                            $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt = "'. $business_userimage .'">';
                        }
                    }
                } else {


                    $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                }
                $return_html .= '</div>

<div id = "content" class = "col-md-12  inputtype-comment cmy_2" >
<div contenteditable = "true" class = "edt_2 editable_text" name = "' . $post_business_profile_post_id . '" id = "post_comment' . $post_business_profile_post_id . '" placeholder = "Add a Comment ..." onClick = "entercomment(' . $post_business_profile_post_id . ')" onpaste = "OnPaste_StripFormatting(this, event);"></div>
<div class="mob-comment">       
                            <button id="' . $post_business_profile_post_id . '" onClick="insert_comment(this.id)"><img src="' . base_url('assets/img/send.png') . '" alt="send.png">
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

        echo $return_html;
// return html        
    }

// ajax function start 

    public function ajax_business_home_three_user_list() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

        // GET USER BUSINESS DATA START
        $contition_array = array('user_id' => $userid, 'status' => '1');
        $businessdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id, industriyal, city, state, other_industrial,business_type', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $business_profile_id = $businessdata[0]['business_profile_id'];
        $industriyal = $businessdata[0]['industriyal'];
        $city = $businessdata[0]['city'];
        $state = $businessdata[0]['state'];
        $other_industrial = $businessdata[0]['other_industrial'];
        $business_type = $businessdata[0]['business_type'];
        // GET USER BUSINESS DATA END
        // GET BUSINESS USER FOLLOWING LIST START
        $contition_array = array('follow_from' => $business_profile_id, 'follow_status' => '1', 'follow_type' => '2');
        $followdata = $this->common->select_data_by_condition('follow', $contition_array, $data = 'GROUP_CONCAT(follow_to) as follow_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = 'follow_from');
        $follow_list = $followdata[0]['follow_list'];
        $follow_list = str_replace(",", "','", $followdata[0]['follow_list']);
        // GET BUSINESS USER FOLLOWING LIST END
        // GET BUSINESS USER IGNORE LIST START
        $contition_array = array('user_from' => $business_profile_id, 'profile' => '2');
        $userdata = $this->common->select_data_by_condition('user_ignore', $contition_array, $data = 'GROUP_CONCAT(user_to) as user_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = 'user_from');
        $user_list = $followdata[0]['user_list'];
        $user_list = str_replace(",", "','", $userdata[0]['user_list']);
        // GET BUSINESS USER IGNORE LIST END
        //GET BUSINESS USER SUGGESTED USER LIST 
        $contition_array = array('is_deleted' => '0', 'status' => '1', 'user_id != ' => $userid, 'business_step' => '4');
        //$search_condition = "((industriyal = '$industriyal') OR (city = '$city') OR (state = '$state')) AND business_profile_id NOT IN ('$follow_list') AND business_profile_id NOT IN ('$user_list')";
        $search_condition = "(business_profile_id NOT IN ('$follow_list') AND business_profile_id NOT IN ('$user_list'))";
        //$userlistview = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'business_profile_id, company_name, business_slug, business_user_image, industriyal, city, state, other_industrial, business_type', $sortby = 'CASE WHEN (industriyal = ' . $industriyal . ') THEN business_profile_id END, CASE WHEN (city = ' . $city . ') THEN business_profile_id END, CASE WHEN (state = ' . $state . ') THEN business_profile_id END', $orderby = 'DESC', $limit = '3', $offset = '0', $join_str_contact = array(), $groupby = '');
        $userlistview = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'business_profile_id, company_name, business_slug, business_user_image, industriyal, city, state, other_industrial, business_type', $sortby = 'CASE WHEN (industriyal = ' . $industriyal . ') THEN business_profile_id END, CASE WHEN (state = ' . $state . ') THEN business_profile_id END', $orderby = 'DESC', $limit = '3', $offset = '0', $join_str_contact = array(), $groupby = '');

        $return_html = '';
        $return_html .= '<ul class="home_three_follow_ul">';
        if (count($userlistview) > 0) {
            foreach ($userlistview as $userlist) {
                $userid = $this->session->userdata('aileenuser');
                $followfrom = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->business_profile_id;
                $contition_array = array('follow_to' => $userlist['business_profile_id'], 'follow_from' => $followfrom, 'follow_status' => '1', 'follow_type' => '2');
                $businessfollow = $this->data['businessfollow'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '1', $offset = '', $join_str = array(), $groupby = '');
                $category = $this->db->get_where('industry_type', array('industry_id' => $userlist['industriyal'], 'status' => '1'))->row()->industry_name;
                if (!$businessfollow) {

                    $return_html .= '<li class = "follow_box_ul_li fad' . $userlist['business_profile_id'] . '" id = "fad' . $userlist['business_profile_id'] . '">
      <div class = "contact-frnd-post follow_left_main_box"><div class = "profile-job-post-title-inside clearfix">
      <div class = " col-md-12 follow_left_box_main">
      <div class = "post-design-pro-img_follow">';
                    if ($userlist['business_user_image']) {
                        $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '" title = "' . ucfirst(strtolower($userlist['company_name'])) . '">';
                        if (IMAGEPATHFROM == 'upload') {
                            if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $userlist['business_user_image'])) {
                                $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt="NOBUSIMAGE">';
                            } else {
                                $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $userlist['business_user_image'] . '" alt = "'. $userlist['business_user_image'] . '">';
                            }
                        } else {
                            $filename = $this->config->item('bus_profile_thumb_upload_path') . $userlist['business_user_image'];
                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                            if (!$info) {
                                $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt="NOBUSIMAGE">';
                            } else {
                                $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $userlist['business_user_image'] . '" alt = "'. $userlist['business_user_image'] . '">';
                            }
                        }
                        $return_html .= '</a>';
                    } else {
                        $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '" title = "' . ucfirst(strtolower($userlist['company_name'])) . '">';
                        $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt="NOBUSIMAGE"></a>';
                    }
                    $return_html .= '</div>
      <div class = "post-design-name_follow fl">
      <ul><li><div class = "post-design-product_follow">';
                    $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '" title = "' . ucfirst($userlist['company_name']) . '">
      <h6>' . ucfirst($userlist['company_name']) . '</h6>
      </a></div></li>';
                    $category = $this->db->get_where('industry_type', array('industry_id' => $userlist['industriyal'], 'status' => '1'))->row()->industry_name;
                    $return_html .= '<li>
      <div class = "post-design-product_follow_main" style = "display:block;">
      <a href = "' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '" title = "' . ucfirst($userlist['company_name']) . '">
      <p>';
                    if ($category) {
                        $return_html .= $category;
                    } else {
                        $return_html .= $userlist['other_industrial'];
                    }
                    $return_html .= '</p>
      </a></div></li></ul></div>
      <div class = "follow_left_box_main_btn">';
                    $return_html .= '<div class = "fr' . $userlist['business_profile_id'] . '">
      <button id = "followdiv' . $userlist['business_profile_id'] . '" onClick = "followuser(' . $userlist['business_profile_id'] . ')"><span>Follow</span>
      </button></div></div><span class = "Follow_close" id="Follow_close' . $userlist['business_profile_id'] . '" onClick = "followclose(' . $userlist['business_profile_id'] . ')">
      <i class = "fa fa-times" aria-hidden = "true"></i></span></div>
      </div></div></li>';
                }
            }
        }
        echo $return_html;
    }

    public function bus_photos() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $id = $_POST['bus_slug'];
// manage post start
        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $slug_data = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $slug_id = $slug_data[0]['business_slug'];

        if ($id == $slug_id || $id == '') {

            $contition_array = array('business_slug' => $slug_id, 'status' => '1');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {

            $contition_array = array('business_slug' => $id, 'status' => '1', 'business_step' => '4');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }

        $join_str[0]['table'] = 'post_files';
        $join_str[0]['join_table_id'] = 'post_files.post_id';
        $join_str[0]['from_table_id'] = 'business_profile_post.business_profile_post_id';
        $join_str[0]['join_type'] = '';

        $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'business_profile_post.is_delete' => '0', 'post_files.insert_profile' => '2', 'post_format' => 'image');
        $businessimage = $this->data['businessimage'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = 'file_name', $sortby = 'post_files.created_date', $orderby = 'desc', $limit = '6', $offset = '', $join_str, $groupby = '');

        if ($businessimage) {
            $i = 0;
            foreach ($businessimage as $mi) {
                $fetch_result .= '<div class="image_profile">';
                $fetch_result .= '<img src="' . BUS_POST_RESIZE3_UPLOAD_URL . $mi['file_name'] . '" alt="' . $mi['file_name'] . '">';
                $fetch_result .= '</div>';

                $i++;
                if ($i == 6)
                    break;
            }
        } else {

//            $fetch_result .= '<div class="not_available">  <p>     Photos Not Available </p></div>';
        }

        $fetch_result .= '<div class = "dataconphoto"></div>';

        echo $fetch_result;
    }

    public function bus_videos_old() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $id = $_POST['bus_slug'];
// manage post start
        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $slug_data = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $slug_id = $slug_data[0]['business_slug'];

        if ($id == $slug_id || $id == '') {

            $contition_array = array('business_slug' => $slug_id, 'status' => '1');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {

            $contition_array = array('business_slug' => $id, 'status' => '1', 'business_step' => '4');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }

        $join_str[0]['table'] = 'post_files';
        $join_str[0]['join_table_id'] = 'post_files.post_id';
        $join_str[0]['from_table_id'] = 'business_profile_post.business_profile_post_id';
        $join_str[0]['join_type'] = '';

        $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'business_profile_post.is_delete' => '0', 'post_files.insert_profile' => '2', 'post_format' => 'video');
        $businessvideo = $this->data['businessvideo'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = 'file_name', $sortby = 'post_files.created_date', $orderby = 'desc', $limit = '6', $offset = '', $join_str, $groupby = '');

        if ($businessvideo) {
            $fetch_video .= '<tr>';

            if ($businessvideo[0]['file_name']) {

                $post_poster = $businessvideo[0]['file_name'];
                $post_poster1 = explode('.', $post_poster);
                $post_poster2 = end($post_poster1);
                $post_poster = str_replace($post_poster2, 'png', $post_poster);

                if (IMAGEPATHFROM == 'upload') {
                    $fetch_video .= '<td class = "image_profile">';
                    if (file_exists($this->config->item('bus_post_main_upload_path') . $post_poster)) {
                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[0]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                } else {
                    $fetch_video .= '<td class = "image_profile">';

                    $filename = $this->config->item('bus_profile_thumb_upload_path') . $posted_business_user_image;
                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                    if ($info) {
                        $postposter = $this->config->item('bus_post_main_upload_path') . $post_poster;
                        $this->data['postposter'] = $postposter = $s3->getObjectInfo(bucket, $postposter);
                        if ($postposter) {
                            $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                        } else {
                            $fetch_video .= '<video controls>';
                        }
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[0]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                }
            }

            if ($businessvideo[1]['file_name']) {
                $post_poster = $businessvideo[1]['file_name'];
                $post_poster1 = explode('.', $post_poster);
                $post_poster2 = end($post_poster1);
                $post_poster = str_replace($post_poster2, 'png', $post_poster);

                if (IMAGEPATHFROM == 'upload') {
                    $fetch_video .= '<td class = "image_profile">';
                    if (file_exists($this->config->item('bus_post_main_upload_path') . $post_poster)) {
                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[1]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                } else {
                    $fetch_video .= '<td class = "image_profile">';

                    $filename = $this->config->item('bus_profile_thumb_upload_path') . $posted_business_user_image;
                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                    if ($info) {

                        $postposter = $this->config->item('bus_post_main_upload_path') . $post_poster;
                        $this->data['postposter'] = $postposter = $s3->getObjectInfo(bucket, $postposter);
                        if ($postposter) {
                            $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                        } else {
                            $fetch_video .= '<video controls>';
                        }
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[1]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                }
            }
            if ($businessvideo[2]['file_name']) {

                $post_poster = $businessvideo[2]['file_name'];
                $post_poster1 = explode('.', $post_poster);
                $post_poster2 = end($post_poster1);
                $post_poster = str_replace($post_poster2, 'png', $post_poster);

                if (IMAGEPATHFROM == 'upload') {
                    $fetch_video .= '<td class = "image_profile">';
                    if (file_exists($this->config->item('bus_post_main_upload_path') . $post_poster)) {
                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[2]['file_name'] . '" type = "video/mp4">';
                    //$fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                } else {
                    $fetch_video .= '<td class = "image_profile">';

                    $filename = $this->config->item('bus_profile_thumb_upload_path') . $posted_business_user_image;
                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                    if ($info) {

                        $postposter = $this->config->item('bus_post_main_upload_path') . $post_poster;
                        $this->data['postposter'] = $postposter = $s3->getObjectInfo(bucket, $postposter);
                        if ($postposter) {
                            $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                        } else {
                            $fetch_video .= '<video controls>';
                        }
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[2]['file_name'] . '" type = "video/mp4">';
                    //$fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                }
            }
            $fetch_video .= '</tr>';
            $fetch_video .= '<tr>';

            if ($businessvideo[3]['file_name']) {

                $post_poster = $businessvideo[3]['file_name'];
                $post_poster1 = explode('.', $post_poster);
                $post_poster2 = end($post_poster1);
                $post_poster = str_replace($post_poster2, 'png', $post_poster);

                if (IMAGEPATHFROM == 'upload') {
                    $fetch_video .= '<td class = "image_profile">';
                    if (file_exists($this->config->item('bus_post_main_upload_path') . $post_poster)) {
                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[3]['file_name'] . '" type = "video/mp4">';
                    //$fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                } else {
                    $fetch_video .= '<td class = "image_profile">';

                    $filename = $this->config->item('bus_profile_thumb_upload_path') . $posted_business_user_image;
                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                    if ($info) {

                        $postposter = $this->config->item('bus_post_main_upload_path') . $post_poster;
                        $this->data['postposter'] = $postposter = $s3->getObjectInfo(bucket, $postposter);
                        if ($postposter) {

                            $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                        } else {
                            $fetch_video .= '<video controls>';
                        }
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[3]['file_name'] . '" type = "video/mp4">';
                    //$fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                }
            }
            if ($businessvideo[4]['file_name']) {

                $post_poster = $businessvideo[4]['file_name'];
                $post_poster1 = explode('.', $post_poster);
                $post_poster2 = end($post_poster1);
                $post_poster = str_replace($post_poster2, 'png', $post_poster);

                if (IMAGEPATHFROM == 'upload') {
                    $fetch_video .= '<td class = "image_profile">';
                    if (file_exists($this->config->item('bus_post_main_upload_path') . $post_poster)) {
                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[4]['file_name'] . '" type = "video/mp4">';
                    //$fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                } else {
                    $fetch_video .= '<td class = "image_profile">';

                    $filename = $this->config->item('bus_profile_thumb_upload_path') . $posted_business_user_image;
                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                    if ($info) {

                        $postposter = $this->config->item('bus_post_main_upload_path') . $post_poster;
                        $this->data['postposter'] = $postposter = $s3->getObjectInfo(bucket, $postposter);
                        if ($postposter) {

                            $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                        } else {
                            $fetch_video .= '<video controls>';
                        }
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[4]['file_name'] . '" type = "video/mp4">';
                    //$fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                }
            }
            if ($businessvideo[5]['file_name']) {

                $post_poster = $businessvideo[5]['file_name'];
                $post_poster1 = explode('.', $post_poster);
                $post_poster2 = end($post_poster1);
                $post_poster = str_replace($post_poster2, 'png', $post_poster);

                if (IMAGEPATHFROM == 'upload') {
                    $fetch_video .= '<td class = "image_profile">';
                    if (file_exists($this->config->item('bus_post_main_upload_path') . $post_poster)) {
                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[5]['file_name'] . '" type = "video/mp4">';
                    //$fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                } else {
                    $fetch_video .= '<td class = "image_profile">';

                    $filename = $this->config->item('bus_profile_thumb_upload_path') . $posted_business_user_image;
                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                    if ($info) {

                        $postposter = $this->config->item('bus_post_main_upload_path') . $post_poster;
                        $this->data['postposter'] = $postposter = $s3->getObjectInfo(bucket, $postposter);
                        if ($postposter) {

                            $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                        } else {
                            $fetch_video .= '<video controls>';
                        }
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[5]['file_name'] . '" type = "video/mp4">';
                    //$fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                }
            }
            $fetch_video .= '</tr>';
        } else {
            //$fetch_video .= '<div class = "not_available"> <p> Video Not Available </p></div>';
        }

        $fetch_video .= '<div class = "dataconvideo"></div>';


        echo $fetch_video;
    }

    public function bus_videos() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $id = $_POST['bus_slug'];
// manage post start
        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $slug_data = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $slug_id = $slug_data[0]['business_slug'];

        if ($id == $slug_id || $id == '') {

            $contition_array = array('business_slug' => $slug_id, 'status' => '1');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {

            $contition_array = array('business_slug' => $id, 'status' => '1', 'business_step' => '4');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }

        $join_str[0]['table'] = 'post_files';
        $join_str[0]['join_table_id'] = 'post_files.post_id';
        $join_str[0]['from_table_id'] = 'business_profile_post.business_profile_post_id';
        $join_str[0]['join_type'] = '';

        $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'business_profile_post.is_delete' => '0', 'post_files.insert_profile' => '2', 'post_format' => 'video');
        $businessvideo = $this->data['businessvideo'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = 'file_name', $sortby = 'post_files.created_date', $orderby = 'desc', $limit = '6', $offset = '', $join_str, $groupby = '');

        if ($businessvideo) {
            $fetch_video .= '<tr>';

            if ($businessvideo[0]['file_name']) {

                $post_poster = $businessvideo[0]['file_name'];
                $post_poster1 = explode('.', $post_poster);
                $post_poster2 = end($post_poster1);
                $post_poster = str_replace($post_poster2, 'png', $post_poster);

                if (IMAGEPATHFROM == 'upload') {
                    $fetch_video .= '<td class = "image_profile">';
                    if (file_exists($this->config->item('bus_post_main_upload_path') . $post_poster)) {
                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[0]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                } else {
                    $fetch_video .= '<td class = "image_profile">';

                    $postposter = $this->config->item('bus_post_main_upload_path') . $post_poster;
                    $this->data['postposter'] = $postposter = $s3->getObjectInfo(bucket, $postposter);
                    if ($postposter) {
                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }

                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[0]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                }
            }

            if ($businessvideo[1]['file_name']) {
                $post_poster = $businessvideo[1]['file_name'];
                $post_poster1 = explode('.', $post_poster);
                $post_poster2 = end($post_poster1);
                $post_poster = str_replace($post_poster2, 'png', $post_poster);

                if (IMAGEPATHFROM == 'upload') {
                    $fetch_video .= '<td class = "image_profile">';
                    if (file_exists($this->config->item('bus_post_main_upload_path') . $post_poster)) {
                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[1]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                } else {
                    $fetch_video .= '<td class = "image_profile">';

                    $postposter = $this->config->item('bus_post_main_upload_path') . $post_poster;
                    $this->data['postposter'] = $postposter = $s3->getObjectInfo(bucket, $postposter);
                    if ($postposter) {
                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }

                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[1]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                }
            }
            if ($businessvideo[2]['file_name']) {

                $post_poster = $businessvideo[2]['file_name'];
                $post_poster1 = explode('.', $post_poster);
                $post_poster2 = end($post_poster1);
                $post_poster = str_replace($post_poster2, 'png', $post_poster);

                if (IMAGEPATHFROM == 'upload') {
                    $fetch_video .= '<td class = "image_profile">';
                    if (file_exists($this->config->item('bus_post_main_upload_path') . $post_poster)) {
                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[2]['file_name'] . '" type = "video/mp4">';
                    //$fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                } else {
                    $fetch_video .= '<td class = "image_profile">';

                    $postposter = $this->config->item('bus_post_main_upload_path') . $post_poster;
                    $this->data['postposter'] = $postposter = $s3->getObjectInfo(bucket, $postposter);
                    if ($postposter) {
                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }

                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[2]['file_name'] . '" type = "video/mp4">';
                    //$fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                }
            }
            $fetch_video .= '</tr>';
            $fetch_video .= '<tr>';

            if ($businessvideo[3]['file_name']) {

                $post_poster = $businessvideo[3]['file_name'];
                $post_poster1 = explode('.', $post_poster);
                $post_poster2 = end($post_poster1);
                $post_poster = str_replace($post_poster2, 'png', $post_poster);

                if (IMAGEPATHFROM == 'upload') {
                    $fetch_video .= '<td class = "image_profile">';
                    if (file_exists($this->config->item('bus_post_main_upload_path') . $post_poster)) {
                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[3]['file_name'] . '" type = "video/mp4">';
                    //$fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                } else {
                    $fetch_video .= '<td class = "image_profile">';

                    $postposter = $this->config->item('bus_post_main_upload_path') . $post_poster;
                    $this->data['postposter'] = $postposter = $s3->getObjectInfo(bucket, $postposter);
                    if ($postposter) {

                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }

                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[3]['file_name'] . '" type = "video/mp4">';
                    //$fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                }
            }
            if ($businessvideo[4]['file_name']) {

                $post_poster = $businessvideo[4]['file_name'];
                $post_poster1 = explode('.', $post_poster);
                $post_poster2 = end($post_poster1);
                $post_poster = str_replace($post_poster2, 'png', $post_poster);

                if (IMAGEPATHFROM == 'upload') {
                    $fetch_video .= '<td class = "image_profile">';
                    if (file_exists($this->config->item('bus_post_main_upload_path') . $post_poster)) {
                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[4]['file_name'] . '" type = "video/mp4">';
                    //$fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                } else {
                    $fetch_video .= '<td class = "image_profile">';

                    $postposter = $this->config->item('bus_post_main_upload_path') . $post_poster;
                    $this->data['postposter'] = $postposter = $s3->getObjectInfo(bucket, $postposter);
                    if ($postposter) {

                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[4]['file_name'] . '" type = "video/mp4">';
                    //$fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                }
            }
            if ($businessvideo[5]['file_name']) {

                $post_poster = $businessvideo[5]['file_name'];
                $post_poster1 = explode('.', $post_poster);
                $post_poster2 = end($post_poster1);
                $post_poster = str_replace($post_poster2, 'png', $post_poster);

                if (IMAGEPATHFROM == 'upload') {
                    $fetch_video .= '<td class = "image_profile">';
                    if (file_exists($this->config->item('bus_post_main_upload_path') . $post_poster)) {
                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[5]['file_name'] . '" type = "video/mp4">';
                    //$fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                } else {
                    $fetch_video .= '<td class = "image_profile">';

                    $postposter = $this->config->item('bus_post_main_upload_path') . $post_poster;
                    $this->data['postposter'] = $postposter = $s3->getObjectInfo(bucket, $postposter);
                    if ($postposter) {

                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[5]['file_name'] . '" type = "video/mp4">';
                    //$fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                }
            }
            $fetch_video .= '</tr>';
        } else {
            //$fetch_video .= '<div class = "not_available"> <p> Video Not Available </p></div>';
        }

        $fetch_video .= '<div class = "dataconvideo"></div>';


        echo $fetch_video;
    }

    public function bus_audio() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $id = $_POST['bus_slug'];
// manage post start
        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $slug_data = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $slug_id = $slug_data[0]['business_slug'];

        if ($id == $slug_id || $id == '') {

            $contition_array = array('business_slug' => $slug_id, 'status' => '1');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {

            $contition_array = array('business_slug' => $id, 'status' => '1', 'business_step' => '4');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }

        $join_str[0]['table'] = 'post_files';
        $join_str[0]['join_table_id'] = 'post_files.post_id';
        $join_str[0]['from_table_id'] = 'business_profile_post.business_profile_post_id';
        $join_str[0]['join_type'] = '';

        $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'business_profile_post.is_delete' => '0', 'post_files.insert_profile' => '2', 'post_format' => 'audio');
        $businessaudio = $this->data['businessaudio'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = 'file_name', $sortby = 'post_files.created_date', $orderby = 'desc', $limit = '6', $offset = '', $join_str, $groupby = '');

        if ($businessaudio) {
            $fetchaudio .= '<tr>';

            if ($businessaudio[0]['file_name']) {
                //$fetchaudio .= '<td class = "image_profile">';
                $fetchaudio .= '<td class = "image_profile"><a href="' . base_url('business-profile/audios/' . $businessdata1[0]['business_slug']) . '"><img src = "' . base_url('assets/images/music-icon.png') . '" alt="music-icon.png"></a>';
                $fetchaudio .= '<audio controls>';

                $fetchaudio .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessaudio[0]['file_name'] . '" type = "audio/mp3">';
                //$fetchaudio .= '<source src = "movie.ogg" type = "audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</audio>';
                $fetchaudio .= '</td>';
            }

            if ($businessaudio[1]['file_name']) {
                $fetchaudio .= '<td class = "image_profile"><a href="' . base_url('business-profile/audios/' . $businessdata1[0]['business_slug']) . '"><img src = "' . base_url('assets/images/music-icon.png') . '" alt="music-icon.png"></a>';
                // $fetchaudio .= '<td class = "image_profile">';
                $fetchaudio .= '<audio controls>';
                $fetchaudio .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessaudio[1]['file_name'] . '" type = "audio/mp3">';
                //$fetchaudio .= '<source src = "movie.ogg" type = "audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</audio>';
                $fetchaudio .= '</td>';
            }
            if ($businessaudio[2]['file_name']) {
                $fetchaudio .= '<td class = "image_profile"><a href="' . base_url('business-profile/audios/' . $businessdata1[0]['business_slug']) . '"><img src = "' . base_url('assets/images/music-icon.png') . '" alt="music-icon.png"></a>';
                //$fetchaudio .= '<td class = "image_profile">';
                $fetchaudio .= '<audio controls>';
                $fetchaudio .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessaudio[2]['file_name'] . '" type = "audio/mp3">';
                //$fetchaudio .= '<source src = "movie.ogg" type = "audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</audio>';
                $fetchaudio .= '</td>';
            }
            $fetchaudio .= '</tr>';
            $fetchaudio .= '<tr>';

            if ($businessaudio[3]['file_name']) {
                $fetchaudio .= '<td class = "image_profile"><a href="' . base_url('business-profile/audios/' . $businessdata1[0]['business_slug']) . '"><img src = "' . base_url('assets/images/music-icon.png') . '" alt="music-icon.png"></a>';
                //$fetchaudio .= '<td class = "image_profile">';
                $fetchaudio .= '<audio controls>';
                $fetchaudio .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessaudio[3]['file_name'] . '" type = "audio/mp3">';
                //$fetchaudio .= '<source src = "movie.ogg" type = "audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</audio>';
                $fetchaudio .= '</td>';
            }
            if ($businessaudio[4]['file_name']) {
                $fetchaudio .= '<td class = "image_profile"><a href="' . base_url('business-profile/audios/' . $businessdata1[0]['business_slug']) . '"><img src = "' . base_url('assets/images/music-icon.png') . '" alt="music-icon.png"></a>';
                //$fetchaudio .= '<td class = "image_profile">';
                $fetchaudio .= '<audio controls>';
                $fetchaudio .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessaudio[4]['file_name'] . '" type = "audio/mp3">';
                //$fetchaudio .= '<source src = "movie.ogg" type = "audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</audio>';
                $fetchaudio .= '</td>';
            }
            if ($businessaudio[5]['file_name']) {
                $fetchaudio .= '<td class = "image_profile"><a href="' . base_url('business-profile/audios/' . $businessdata1[0]['business_slug']) . '"><img src = "' . base_url('assets/images/music-icon.png') . '" alt="music-icon.png"></a>';
                //$fetchaudio .= '<td class = "image_profile">';
                $fetchaudio .= '<audio controls>';
                $fetchaudio .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessaudio[5]['file_name'] . '" type = "audio/mp3">';
                //$fetchaudio .= '<source src = "movie.ogg" type = "audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</audio>';
                $fetchaudio .= '</td>';
            }
            $fetchaudio .= '</tr>';
        } else {
            //$fetchaudio .= '<div class = "not_available"> <p> Audio Not Available </p></div>';
        }
        $fetchaudio .= '<div class = "dataconaudio"></div>';
        echo $fetchaudio;
    }

    public function bus_pdf() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $id = $_POST['bus_slug'];
// manage post start
        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $slug_data = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $slug_id = $slug_data[0]['business_slug'];

        if ($id == $slug_id || $id == '') {

            $contition_array = array('business_slug' => $slug_id, 'status' => '1');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {

            $contition_array = array('business_slug' => $id, 'status' => '1', 'business_step' => '4');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }

        $join_str[0]['table'] = 'post_files';
        $join_str[0]['join_table_id'] = 'post_files.post_id';
        $join_str[0]['from_table_id'] = 'business_profile_post.business_profile_post_id';
        $join_str[0]['join_type'] = '';

        $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'business_profile_post.is_delete' => '0', 'post_files.insert_profile' => '2', 'post_format' => 'pdf');
        $businesspdf = $this->data['businessaudio'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = 'file_name', $sortby = 'post_files.created_date', $orderby = 'desc', $limit = '6', $offset = '', $join_str, $groupby = '');

        if ($businesspdf) {
            $i = 0;
            foreach ($businesspdf as $mi) {
                $fetch_pdf .= '<div class = "image_profile">';
                $fetch_pdf .= '<a href = "' . BUS_POST_MAIN_UPLOAD_URL . $mi['file_name'] . '" target="_blank"><div class = "pdf_img">';
                $fetch_pdf .= '<img src = "' . base_url('assets/images/PDF.jpg') . '" alt="PDF.jpg">';
                $fetch_pdf .= '</div></a>';
                $fetch_pdf .= '</div>';

                $i++;
                if ($i == 6)
                    break;
            }
        } else {
            
        }
        $fetch_pdf .= '<div class = "dataconpdf"></div>';
        echo $fetch_pdf;
    }

    public function ajax_business_dashboard_post($id = '') {
        $s3 = new S3(awsAccessKey, awsSecretKey);
// manage post start
        $business_login_slug = $this->data['business_login_slug'];
        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        $userid = $this->session->userdata('aileenuser');
        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;
        if ($id != '') {
            $bus_userid = $this->db->get_where('business_profile', array('business_slug' => $id, 'status' => '1'))->row()->user_id;
        } else {
            $bus_userid = $this->session->userdata('aileenuser');
        }
        $business_profile_id = $this->data['business_common_data'][0]['business_profile_id'];
        $city = $this->data['business_common_data'][0]['city'];
        $user_id = $this->data['business_common_data'][0]['user_id'];
        $business_user_image = $this->data['business_common_data'][0]['business_user_image'];
        $business_slug = $this->data['business_common_data'][0]['business_slug'];
        $company_name = $this->data['business_common_data'][0]['company_name'];
        $profile_background = $this->data['business_common_data'][0]['profile_background'];
        $state = $this->data['business_common_data'][0]['state'];
        $industriyal = $this->data['business_common_data'][0]['industriyal'];
        $other_industrial = $this->data['business_common_data'][0]['other_industrial'];

        /* SELF USER LIST START */
        $self_list = array($bus_userid);
        /* SELF USER LIST END */


        $total_user_list = $self_list;
        $total_user_list = array_unique($total_user_list, SORT_REGULAR);
        $total_user_list = implode(',', $total_user_list);
        $total_user_list = str_replace(",", "','", $total_user_list);

        $condition_array = array('business_profile_post.is_delete' => '0', 'business_profile_post.status' => '1', 'FIND_IN_SET ("' . $userid . '", delete_post) !=' => '0');
        $delete_postdata = $this->common->select_data_by_condition('business_profile_post', $condition_array, $data = 'GROUP_CONCAT(business_profile_post_id) as delete_post_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $delete_post_id = $delete_postdata[0]['delete_post_id'];
        $delete_post_id = str_replace(",", "','", $delete_post_id);

        $condition_array = array('business_profile_post.is_delete' => '0', 'business_profile_post.status' => '1');
        $search_condition = "`business_profile_post_id` NOT IN ('$delete_post_id') AND (business_profile_post.user_id IN ('$total_user_list')) OR (posted_user_id ='$user_id' AND is_delete=0)";
        $join_str[0]['table'] = 'business_profile';
        $join_str[0]['join_table_id'] = 'business_profile.user_id';
        $join_str[0]['from_table_id'] = 'business_profile_post.user_id';
        $join_str[0]['join_type'] = '';
        $data = "business_profile.business_user_image,business_profile.company_name,business_profile.industriyal,business_profile.business_slug,business_profile.other_industrial,business_profile.business_slug,business_profile_post.business_profile_post_id,business_profile_post.product_name,business_profile_post.product_description,business_profile_post.business_likes_count,business_profile_post.business_like_user,business_profile_post.created_date,business_profile_post.posted_user_id,business_profile.user_id";
        $business_profile_post = $this->common->select_data_by_search('business_profile_post', $search_condition, $condition_array, $data, $sortby = 'business_profile_post_id', $orderby = 'DESC', $limit = $perpage, $offset = $start, $join_str, $groupby = '');
        $business_profile_post1 = $this->common->select_data_by_search('business_profile_post', $search_condition, $condition_array, $data, $sortby = 'business_profile_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str, $groupby = '');

        $return_html = '';

        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($business_profile_post1);
        }

        $return_html .= '<input type = "hidden" class = "page_number" value = "' . $page . '" />';
        $return_html .= '<input type = "hidden" class = "total_record" value = "' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';

        if (count($business_profile_post1) > 0) {
            foreach ($business_profile_post as $row) {

                $post_business_user_image = $row['business_user_image'];
                $post_company_name = $row['company_name'];
                $post_business_profile_post_id = $row['business_profile_post_id'];
                $post_product_name = $row['product_name'];
                //$post_product_image = $row['product_image'];
                $post_product_description = $row['product_description'];
                $post_business_likes_count = $row['business_likes_count'];
                $post_business_like_user = $row['business_like_user'];
                $post_created_date = $row['created_date'];
                $post_posted_user_id = $row['posted_user_id'];
                $post_business_slug = $row['business_slug'];
                $post_industriyal = $row['industriyal'];
                $post_user_id = $row['user_id'];
                $post_category = $this->db->get_where('industry_type', array('industry_id' => $post_industriyal, 'status' => '1'))->row()->industry_name;
                $post_other_industrial = $row['other_industrial'];
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
                        if (IMAGEPATHFROM == 'upload') {
                            if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $posted_business_user_image)) {
                                $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                            } else {
                                $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $posted_business_user_image . '" name = "image_src" id = "image_src" alt="'. $posted_business_user_image .'"/>';
                            }
                        } else {
                            $filename = $this->config->item('bus_profile_thumb_upload_path') . $posted_business_user_image;
                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                            if (!$info) {
                                $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                            } else {
                                $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $posted_business_user_image . '" name = "image_src" id = "image_src" alt="'. $posted_business_user_image .'"/>';
                            }
                        }
                        $return_html .= '</a>';
                    } else {
                        $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $posted_business_slug) . '">';
                        $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                        $return_html .= '</a>';
                    }
                } else {
                    if ($post_business_user_image) {
                        $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $post_business_slug) . '">';
                        if (IMAGEPATHFROM == 'upload') {
                            if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $post_business_user_image)) {
                                $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                            } else {
                                $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $post_business_user_image . '" alt = "'. $post_business_user_image .'">';
                            }
                        } else {
                            $filename = $this->config->item('bus_profile_thumb_upload_path') . $post_business_user_image;
                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                            if (!$info) {
                                $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                            } else {
                                $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $post_business_user_image . '" alt = "'. $post_business_user_image .'">';
                            }
                        }
                        $return_html .= '</a>';
                    } else {
                        $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $post_business_slug) . '">';
                        $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
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
<span class = "ctre_date">
' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($post_created_date))) . '
</span> </div></div>
</li>';
                } else {
                    $return_html .= '<li>
                            <div class = "post-design-product">
                                <a class = "post_dot" href = "' . base_url('business-profile/dashboard/' . $post_business_slug) . '" title = "' . ucfirst(strtolower($post_company_name)) . '">
' . ucfirst($post_company_name) . '</a><div class = "datespan"> <span class = "ctre_date" >
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
<div class = "dropdown1">';
                $return_html .= '<a onClick = "myFunction1(' . $post_business_profile_post_id . ')" class = "dropbtn_common dropbtn1 fa fa-ellipsis-v"></a>';

                $return_html .= '<div id = "myDropdown' . $post_business_profile_post_id . '" class = "dropdown-content1 dropdown2_content">';
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
                $businessmultiimage = $this->common->select_data_by_condition('post_files', $contition_array, $data = 'file_name,post_files_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if (count($businessmultiimage) == 1) {

                    $allowed = array('jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg');
//                    $allowed = VALID_IMAGE;
                    $allowespdf = array('pdf');
                    $allowesvideo = array('mp4', 'webm', 'qt', 'mov', 'MP4');
                    $allowesaudio = array('mp3');
                    $filename = $businessmultiimage[0]['file_name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    if (in_array($ext, $allowed)) {

                        $return_html .= '<div class = "one-image">';

                        $return_html .= '<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" alt="'. $businessmultiimage[0]['file_name'] .'">
</a>
</div>';
                    } elseif (in_array($ext, $allowespdf)) {

                        /*    $return_html .= '<div>
                          <a title = "click to open" href = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '"><div class = "pdf_img">
                          <embed src="' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" width="100%" height="450px" />
                          </div>
                          </a>
                          </div>'; */
                        $return_html .= '<div>
<a title = "click to open" href = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" target="_blank"><div class = "pdf_img">
    <img src="' . base_url('assets/images/PDF.jpg') . '" alt="PDF.jpg">
</div>
</a>
</div>';
                    } elseif (in_array($ext, $allowesvideo)) {
                        $post_poster = $businessmultiimage[0]['file_name'];
                        $post_poster1 = explode('.', $post_poster);
                        $post_poster2 = end($post_poster1);
                        $post_poster = str_replace($post_poster2, 'png', $post_poster);

                        if (IMAGEPATHFROM == 'upload') {
                            $return_html .= '<div>';
                            if (file_exists($this->config->item('bus_post_main_upload_path') . $post_poster)) {
                                $return_html .= '<video width = "100%" height = "350" id="show_video' . $businessmultiimage[0]['post_files_id'] . '" onplay="playtime(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ')" onClick="count_videouser(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ');" controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                            } else {
                                $return_html .= '<video width = "100%" height = "350" id="show_video' . $businessmultiimage[0]['post_files_id'] . '" onplay="playtime(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ')" onClick="count_videouser(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ');" controls>';
                            }

                            $return_html .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" type = "video/mp4">';
                            $return_html .= 'Your browser does not support the video tag.';
                            $return_html .= '</video>';
                            $return_html .= '</div>';
                        } else {
                            $return_html .= '<div>';

                            $filename = $this->config->item('bus_post_main_upload_path') . $businessmultiimage[0]['file_name'];
                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                            if ($info) {
                                $return_html .= '<video width = "100%" height = "350" id="show_video' . $businessmultiimage[0]['post_files_id'] . '" onplay="playtime(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ')" onClick="count_videouser(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ');" controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                            } else {
                                $return_html .= '<video width = "100%" height = "350" id="show_video' . $businessmultiimage[0]['post_files_id'] . '" onplay="playtime(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ')" onClick="count_videouser(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ');" controls>';
                            }
                            $return_html .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" type = "video/mp4">';
                            $return_html .= 'Your browser does not support the video tag.';
                            $return_html .= '</video>';
                            $return_html .= '</div>';
                        }
                    } elseif (in_array($ext, $allowesaudio)) {

                        $return_html .= '<div class = "audio_main_div">
<div class = "audio_img">
<img src = "' . base_url('assets/images/music-icon.png') . '" alt="music-icon.png">
</div>
<div class = "audio_source">
<audio id = "audio_player" width = "100%" height = "100" controls>
<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" type = "audio/mp3">
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
<img class = "two-columns" src = "' . BUS_POST_RESIZE1_UPLOAD_URL . $multiimage['file_name'] . '" alt="'. $multiimage['file_name'] .'">
</a>
</div>';
                    }
                } elseif (count($businessmultiimage) == 3) {

                    $return_html .= '<div class = "three-image-top" >
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img class = "three-columns" src = "' . BUS_POST_RESIZE4_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" alt="'. $businessmultiimage[0]['file_name'] . '">
</a>
</div>
<div class = "three-image" >

<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img class = "three-columns" src = "' . BUS_POST_RESIZE1_UPLOAD_URL . $businessmultiimage[1]['file_name'] . '" alt="'. $businessmultiimage[1]['file_name'] .'">
</a>
</div>
<div class = "three-image" >
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img class = "three-columns" src = "' . BUS_POST_RESIZE1_UPLOAD_URL . $businessmultiimage[2]['file_name'] . '" alt="'. $businessmultiimage[2]['file_name'] . '">
</a>
</div>';
                } elseif (count($businessmultiimage) == 4) {

                    foreach ($businessmultiimage as $multiimage) {

                        $return_html .= '<div class = "four-image">
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img class = "breakpoint" src = "' . BUS_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name'] . '" alt="'. $multiimage['file_name'] . '">
</a>
</div>';
                    }
                } elseif (count($businessmultiimage) > 4) {

                    $i = 0;
                    foreach ($businessmultiimage as $multiimage) {

                        $return_html .= '<div class = "four-image">
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img src = "' . BUS_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name'] . '" alt="'. $multiimage['file_name'] .'">
</a>
</div>';

                        $i++;
                        if ($i == 3)
                            break;
                    }

                    $return_html .= '<div class = "four-image">
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img src = "' . BUS_POST_RESIZE2_UPLOAD_URL . $businessmultiimage[3]['file_name'] . '" alt="'. $businessmultiimage[3]['file_name'] . '">
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
<ul class = "col-md-6 col-sm-6 col-xs-6 like_cmnt_count">';
                $contition_array = array('post_id' => $row['business_profile_post_id'], 'insert_profile' => '2');
                $postformat = $this->common->select_data_by_condition('post_files', $contition_array, $data = 'post_format', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                //echo "<pre>"; print_r($postformat); die();
                if ($postformat[0]['post_format'] == 'video') {
                    $return_html .= '<li id="viewvideouser' . $row['business_profile_post_id'] . '">';

                    $contition_array = array('post_id' => $row['business_profile_post_id']);
                    $userdata = $this->common->select_data_by_condition('showvideo', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    $user_data = count($userdata);

                    if ($user_data > 0) {

                        $return_html .= '<div class="comnt_count_ext_a  comnt_count_ext2"><span>';

                        $return_html .= $user_data . ' ' . 'Views';

                        $return_html .= '</span></div></li>';
                    }
                }

                $return_html .= '<li>
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

                    $return_html .= '<div class = "like_one_other">';
                    $return_html .= '<a href = "javascript:void(0);" onclick = "likeuserlist(' . $post_business_profile_post_id . ')">';
                    $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $likelistarray[0], 'status' => '1'))->row()->company_name;

                    if (in_array($userid, $likelistarray)) {
                        $return_html .= "You";
                        $return_html .= "&nbsp;";
                    } else {
                        $return_html .= ucfirst($business_fname1);
                        $return_html .= "&nbsp;";
                    }
                    if (count($likelistarray) > 1) {
                        $return_html .= " and ";

                        $return_html .= $countlike;
                        $return_html .= "&nbsp;";
                        $return_html .= "others";
                    }
                    $return_html .= '</a></div>
</div>';
                }

                $return_html .= '<div class = "likeusername' . $post_business_profile_post_id . '" id = "likeusername' . $post_business_profile_post_id . '" style = "display:none">';

                $likeuser = $post_business_like_user;
                $countlike = $post_business_likes_count - 1;
                $likelistarray = explode(', ', $likeuser);

                $likeuser = $post_business_like_user;
                $countlike = $post_business_likes_count - 1;
                $likelistarray = explode(', ', $likeuser);

                $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => '1'))->row()->company_name;

                $return_html .= '<div class = "like_one_other">';
                $return_html .= '<a href = "javascript:void(0);" onclick = "likeuserlist(' . $post_business_profile_post_id . ')">';

                $return_html .= ucfirst($business_fname1);
                $return_html .= "&nbsp;";

                if (count($likelistarray) > 1) {

                    $return_html .= "and";

                    $return_html .= $countlike;
                    $return_html .= "&nbsp;";
                    $return_html .= "others";
                }
                $return_html .= '</a></div>
</div>

<div class = "art-all-comment col-md-12">
<div id = "fourcomment' . $post_business_profile_post_id . '" style = "display:none;">
</div>
<div id = "threecomment' . $post_business_profile_post_id . '" style = "display:block">
<div class = "hidebottomborder insertcomment' . $post_business_profile_post_id . '">';

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
                            if (IMAGEPATHFROM == 'upload') {
                                if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                                    $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                                } else {
                                    $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt = "'. $business_userimage .'">';
                                }
                            } else {
                                $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_userimage;
                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                if (!$info) {
                                    $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                                } else {
                                    $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt = "'. $business_userimage . '">';
                                }
                            }

                            $return_html .= '</a>';
                        } else {
                            $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $slugname1) . '">';

                            $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE"></a>';
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
<div contenteditable = "true" class = "editable_text editav_2" name = "' . $rowdata['business_profile_post_comment_id'] . '" id = "editcomment' . $rowdata['business_profile_post_comment_id'] . '" placeholder = "Enter Your Comment " value = "" onkeyup="commentedit(' . $rowdata['business_profile_post_comment_id'] . ')"  onclick="commentedit(' . $rowdata['business_profile_post_comment_id'] . ')" onpaste = "OnPaste_StripFormatting(this, event);">' . $rowdata['comments'] . '</div>
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

                        $return_html .= '</span>
</a>
</div>';
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
                        $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $rowdata['business_profile_post_id'], 'status' => '1'))->row()->user_id;
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
                    if (IMAGEPATHFROM == 'upload') {
                        if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                            $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                        } else {
                            $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt = "'. $business_userimage .'">';
                        }
                    } else {
                        $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_userimage;
                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                        if (!$info) {
                            $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                        } else {
                            $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '" alt = "'. $business_userimage .'">';
                        }
                    }
                } else {
                    $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                }
                $return_html .= '</div>

<div id = "content" class = "col-md-12  inputtype-comment cmy_2" >
<div contenteditable = "true" class = "edt_2 editable_text" name = "' . $post_business_profile_post_id . '" id = "post_comment' . $post_business_profile_post_id . '" placeholder = "Add a Comment ..." onClick = "entercomment(' . $post_business_profile_post_id . ')" onpaste = "OnPaste_StripFormatting(this, event);"></div>
<div class="mob-comment">       
                            <button id="' . $post_business_profile_post_id . '" onClick="insert_comment(this.id)"><img src="' . base_url('assets/img/send.png') . '" alt="send.png">
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

        echo $return_html;
    }

    public function check_post_available() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $post_id = $_POST['post_id'];

        $condition_array = array('business_profile_post_id' => $post_id);
        $profile_data = $this->common->select_data_by_condition('business_profile_post', $condition_array, $data = 'status,user_id,is_delete,posted_user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($profile_data[0]['status'] == '1' && $profile_data[0]['is_delete'] == '0') {
            $return = 1;

            $condition_array = array('user_id' => $profile_data[0]['user_id']);
            $user_data = $this->common->select_data_by_condition('user', $condition_array, $data = 'status,is_delete', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($user_data[0]['status'] == '1' && $user_data[0]['is_delete'] == '0') {
                $return = 1;
            } else {
                $return = 0;
            }
            if ($profile_data[0]['posted_user_id'] != '0') {
                $condition_array = array('user_id' => $profile_data[0]['posted_user_id']);
                $user_data = $this->common->select_data_by_condition('user', $condition_array, $data = 'status,is_delete', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($user_data[0]['status'] == '1' && $user_data[0]['is_delete'] == '0') {
                    $return = 1;
                } else {
                    $return = 0;
                }
            }
        } else {
            $return = 0;
        }
        echo $return;
    }

    public function check_post_comment_available() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $post_comment_id = $_POST['post_id'];

        $condition_array = array('business_profile_post_comment_id' => $post_comment_id);
        $post_comment_data = $this->common->select_data_by_condition('business_profile_post_comment', $condition_array, $data = 'status,user_id,is_delete,business_profile_post_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if ($post_comment_data[0]['status'] == 1 && $post_comment_data[0]['is_delete'] == 0) {
            $return = 1;

            $post_id = $post_comment_data[0]['business_profile_post_id'];

            $condition_array = array('business_profile_post_id' => $post_id);
            $profile_data = $this->common->select_data_by_condition('business_profile_post', $condition_array, $data = 'status,user_id,is_delete,posted_user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($profile_data[0]['status'] == '1' && $profile_data[0]['is_delete'] == '0') {
                $return = 1;

                $condition_array = array('user_id' => $profile_data[0]['user_id']);
                $user_data = $this->common->select_data_by_condition('user', $condition_array, $data = 'status,is_delete', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($user_data[0]['status'] == '1' && $user_data[0]['is_delete'] == '0') {
                    $return = 1;
                } else {
                    $return = 0;
                }
                if ($profile_data[0]['posted_user_id'] != '0') {
                    $condition_array = array('user_id' => $profile_data[0]['posted_user_id']);
                    $user_data = $this->common->select_data_by_condition('user', $condition_array, $data = 'status,is_delete', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    if ($user_data[0]['status'] == '1' && $user_data[0]['is_delete'] == '0') {
                        $return = 1;
                    } else {
                        $return = 0;
                    }
                }
            } else {
                $return = 0;
            }
        } else {
            $return = 0;
        }
        echo $return;
    }

    public function get_company_name($id = '') {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $contition_array = array('business_slug' => $id, 'is_deleted' => '0', 'status' => '1');
        $businessdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'company_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        return $company_name = $businessdata[0]['company_name'];
    }

    public function ajax_business_skill() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $term = $_GET['term'];
        $contition_array = array('status' => '1', 'is_deleted' => '0', 'business_step' => '4');
        $search_condition = "(company_name LIKE '" . trim($term) . "%' OR other_industrial LIKE '" . trim($term) . "%' OR other_business_type LIKE '" . trim($term) . "%')";
        $businessdata = $this->data['results'] = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'company_name,other_industrial,other_business_type', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
// GET BUSINESS TYPE
        $contition_array = array('status' => '1', 'is_delete' => '0');
        $search_condition = "(business_name LIKE '" . trim($term) . "%' )";
        $businesstype = $this->data['results'] = $this->common->select_data_by_search('business_type', $search_condition, $contition_array, $data = 'business_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
// GET INDUSTRIAL TYPE
        $contition_array = array('status' => '1', 'is_delete' => '0');
        $search_condition = "(industry_name LIKE '" . trim($term) . "%' )";
        $industrytype = $this->data['results'] = $this->common->select_data_by_search('industry_type', $search_condition, $contition_array, $data = 'industry_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
// GET PRODUCT
        $contition_array = array('status' => '1', 'is_delete' => '0');
        $search_condition = "(product_name LIKE '" . trim($term) . "%' OR product_description LIKE '" . trim($term) . "%')";
        $productdata = $this->data['results'] = $this->common->select_data_by_search('business_profile_post', $search_condition, $contition_array, $data = 'product_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $unique = array_merge($businessdata, $businesstype, $industrytype, $productdata);
        foreach ($unique as $key => $value) {
            foreach ($value as $ke => $val) {
                if ($val != "") {
                    $result[] = $val;
                }
            }
        }

        $results = array_unique($result);
        foreach ($results as $key => $value) {
            $result1[$key]['value'] = $value;
        }

        echo json_encode($result1);
    }

    public function ajax_location_data() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $term = $_GET['term'];
        if (!empty($term)) {
            $contition_array = array('status' => '1', 'state_id !=' => '0');
            $search_condition = "(city_name LIKE '" . trim($term) . "%')";
            $location_list = $this->common->select_data_by_search('cities', $search_condition, $contition_array, $data = 'city_name', $sortby = 'city_name', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = 'city_name');
            foreach ($location_list as $key1 => $value) {
                foreach ($value as $ke1 => $val1) {
                    $location[] = $val1;
                }
            }
            foreach ($location as $key => $value) {
                $city_data[$key]['value'] = $value;
            }
            echo json_encode($city_data);
        }
    }

    public function business_profile_active_check() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
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
        $s3 = new S3(awsAccessKey, awsSecretKey);
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
            //redirect('business-profile/business-information-update', refresh);
            redirect('business-profile/business-information', refresh);
        }

// IF USER DEACTIVE PROFILE THEN REDIRECT TO BUSINESS-PROFILE/INDEX UNTILL ACTIVE PROFILE END
// DEACTIVATE PROFILE END
    }

    // BUSIENSS PROFILE USER FOLLOWING COUNT START

    public function business_user_following_count($business_profile_id = '') {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        if ($business_profile_id == '') {
            $business_profile_id = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->business_profile_id;
        }

        $contition_array = array('follow_from' => $business_profile_id, 'follow_status' => '1', 'follow_type' => '2', 'business_profile.status' => '1', 'business_profile.is_deleted' => '0');

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
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        if ($business_profile_id == '') {
            $business_profile_id = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->business_profile_id;
        }

        $contition_array = array('follow_to' => $business_profile_id, 'follow_status' => '1', 'follow_type' => '2', 'business_profile.status' => '1', 'business_profile.is_deleted' => '0');

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
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        if ($business_profile_id != '') {
            $userid = $this->db->get_where('business_profile', array('business_profile_id' => $business_profile_id, 'status' => '1'))->row()->user_id;
        }

        $contition_array = array('contact_type' => '2', 'contact_person.status' => 'confirm', 'business_profile.status' => '1', 'business_profile.is_deleted' => '0');
        $search_condition = "((contact_from_id = ' $userid') OR (contact_to_id = '$userid'))";

        $join_str_contact[0]['table'] = 'business_profile';
        $join_str_contact[0]['join_table_id'] = 'business_profile.user_id';
        $join_str_contact[0]['from_table_id'] = 'contact_person.contact_from_id';
        $join_str_contact[0]['join_type'] = '';

        $contacts_count = $this->common->select_data_by_search('contact_person', $search_condition, $contition_array, $data = 'count(*) as contact_count', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str_contact, $groupby = '');
        $contacts_count = $contacts_count[0]['contact_count'];

        return $contacts_count;
    }

    public function mail_test() {
        $send_email = $this->email_model->test_email($subject = 'This is a testing mail', $templ = '', $to_email = 'ankit.aileensoul@gmail.com');
        //    $send_email = $this->email_model->send_email($subject = 'This is a testing mail', $templ = '', $to_email = 'ankit.aileensoul@gmail.com');
    }

//video show user count start

    public function showuser() {

        $userid = $this->session->userdata('aileenuser');
        $file_id = $_POST['file_id'];
        $post_id = $_POST['post_id'];

        $contition_array = array('business_profile_post_id' => $post_id);
        $postuploaduid = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = 'user_id,posted_user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($postuploaduid); die();
        $contition_array = array('post_files_id' => $file_id, 'user_id' => $userid, 'post_id' => $post_id);
        $existvideouser = $this->common->select_data_by_condition('bus_showvideo', $contition_array, $data = 'id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userid == $postuploaduid[0]['user_id'] || $userid == $postuploaduid[0]['posted_user_id']) {
            
        } else {
            if (!$existvideouser) {

                $data = array(
                    'post_files_id' => $file_id,
                    'user_id' => $userid,
                    'created_date' => date('Y-m-d H:i:s', time()),
                    'post_id' => $post_id,
                );
                $insert_id = $this->common->insert_data_getid($data, 'bus_showvideo');
            }
        }

        $contition_array = array('post_files_id' => $file_id);
        $userdata = $this->common->select_data_by_condition('bus_showvideo', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $user_data = count($userdata);

        $return_html = '';

        $return_html .= '<div class="comnt_count_ext_a  comnt_count_ext2"><span>';
        $return_html .= $user_data . ' ' . 'Views';
        $return_html .= '</sapn></div>';

        echo $return_html;
    }

    public function business_notification_count($to_id = '') {
        $contition_array = array('not_read' => '2', 'not_to_id' => $to_id, 'not_type !=' => '1', 'not_type !=' => '2');
        $result = $this->common->select_data_by_condition('notification', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $count = $result[0]['total'];
        return $count;
    }

    public function business_contact_notification_count($to_id = '') {
        $contition_array = array('not_read' => '2');
        $search_condition = "((contact_to_id = '$to_id' AND status = 'pending') OR (contact_from_id = '$to_id' AND status = 'confirm'))";
        $contactperson = $this->common->select_data_by_search('contact_person', $search_condition, $contition_array, $data = 'count(*) as total', $sortby = 'contact_id', $orderby = '', $limit = '', $offset = '', $join_str = '', $groupby = '');

        $contactcount = $contactperson[0]['total'];
        return $contactcount;
    }

}
