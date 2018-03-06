<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Business_profile_registration extends MY_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('user_agent');
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('business_model');
        $this->load->model('user_post_model');
        
        $this->lang->load('message', 'english');
        $this->load->helper('smiley');
        //AWS access info start
        $this->load->library('S3');
        //AWS access info end

        $userid = $this->session->userdata('aileenuser');
            include ('business_include.php');

        // FIX BUSINESS PROFILE NO POST DATA

        $this->data['no_business_post_html'] = '<div class="art_no_post_avl"><h3>Business Post</h3><div class="art-img-nn"><div class="art_no_post_img"><img src=' . base_url('assets/img/bui-no.png') . '></div><div class="art_no_post_text">No Post Available.</div></div></div>';
        $this->data['no_business_contact_html'] = '<div class="art-img-nn"><div class="art_no_post_img"><img src="' . base_url('assets/img/No_Contact_Request.png') . '"></div><div class="art_no_post_text">No Contacts Available.</div></div>';
    }

    public function index() {
        
    }

    public function business_registration() {

        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $this->data['reg_uri'] = $reg_uri = $this->uri->segment(3);

        $contition_array = array('user_id' => $userid, 'status' => '0');
        $businessdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($businessdata) {
            $this->load->view('business_profile/reactivate', $this->data);
        } else {
            $userid = $this->session->userdata('aileenuser');
            // GET BUSINESS PROFILE DATA
            $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
            $userdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            //$this->load->view('business_profile/ng_business_registration_old', $this->data);
            if($userid){
            $this->data['profile_login'] = "login";
             }else{
            $this->data['profile_login'] = "live";
            }
            if(!$this->session->userdata('aileenuser')){
                $this->load->view('business_profile/ng_business_registration_live', $this->data);
            }else{
                $this->load->view('business_profile/ng_business_registration', $this->data);
            }
            
        }
    }

    public function business_information() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'status' => '0');
        $businessdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if ($businessdata) {
            $this->load->view('business_profile/reactivate', $this->data);
        } else {
            $userid = $this->session->userdata('aileenuser');
// GET BUSINESS PROFILE DATA
            $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
            $userdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if (count($userdata) > 0) {
                if ($userdata[0]['business_step'] == 1) {
                    redirect('business-profile/signup/contact-information', refresh);
                } else if ($userdata[0]['business_step'] == 2) {
                    redirect('business-profile/signup/description', refresh);
                } else if ($userdata[0]['business_step'] == 3) {
                    redirect('business-profile/signup/image', refresh);
                } else if ($userdata[0]['business_step'] == 4) {
                    redirect('business-profile/home', refresh);
                } else if ($userdata[0]['business_step'] == 5) {
                    redirect('business-profile/home', refresh);
                }
            } else {
                $this->load->view('business_profile/ng_business_info', $this->data);
            }
        }
    }

    public function getBusinessInformation() {
        $userid = $this->session->userdata('aileenuser');
        $this->business_profile_active_check();
        // GET BUSINESS PROFILE DATA
        $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'country,state,city,company_name,pincode,address,business_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        echo json_encode($userdata);
    }

    public function business_information_edit() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $this->business_profile_active_check();

// GET BUSINESS PROFILE DATA
        $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'country,state,city,company_name,pincode,address,business_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// GET COUNTRY DATA
        $contition_array = array('status' => '1');
        $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = 'country_id, country_name', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// GET STATE DATA
        $contition_array = array('status' => '1', 'country_id' => $userdata[0]['country']);
        $this->data['states'] = $this->common->select_data_by_condition('states', $contition_array, $data = 'state_id, state_name, country_id', $sortby = 'state_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// GET CITY DATA
        $contition_array = array('status' => '1', 'state_id' => $userdata[0]['state']);
        $this->data['cities'] = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_id, city_name, state_id', $sortby = 'city_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userdata) {
            $step = $userdata[0]['business_step'];

            if ($step == 1 || $step > 1) {

                $this->data['country1'] = $userdata[0]['country'];
                $this->data['state1'] = $userdata[0]['state'];
                $this->data['city1'] = $userdata[0]['city'];
                $this->data['companyname1'] = $userdata[0]['company_name'];
                $this->data['pincode1'] = $userdata[0]['pincode'];
                $this->data['address1'] = $userdata[0]['address'];
            }
        }
        $this->data['title'] = 'Business Profile' . TITLEPOSTFIX;
        $this->load->view('business_profile/ng_business_info_edit', $this->data);
    }

    public function getCountry() {
        $this->load->model('User_model');
        echo json_encode($this->User_model->getCountry());
    }

    public function getStateByCountryId() {

        $this->load->model('User_model');
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        if ($request->countryId != '') {
            $stateList = $this->User_model->getStateByCountryId($request->countryId);
            echo json_encode($stateList);
        }
    }

    public function getCityByStateId() {

        $this->load->model('User_model');
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        if ($request->stateId != '') {
            $cityList = $this->User_model->getCityByStateId($request->stateId);
            echo json_encode($cityList);
        } else {
            echo json_encode(array('status' => 'failure'));
        }
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

// BUSINESS PROFILE SLUG END

    public function ng_bus_info_insert() {

        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $errors = array();
        $data = array();

        $userdata = $this->user_model->getUserData($userid);
        // Getting posted data and decodeing json
        $_POST = json_decode(file_get_contents('php://input'), true);

        if (empty($_POST['companyname']))
            $errors['companyname'] = 'Companyname is required.';

        if (empty($_POST['country_id']))
            $errors['country'] = 'Country is required.';

        if (empty($_POST['state_id']))
            $errors['state'] = 'State is required.';

        if (empty($_POST['business_address']))
            $errors['business_address'] = 'Business address is required.';

        if (!empty($errors)) {
            $data['errors'] = $errors;
        } else {
            if ($_POST['busreg_step'] == '0' || $_POST['busreg_step'] == '') {
                $data['company_name'] = $_POST['companyname'];
                $data['country'] = $_POST['country_id'];
                $data['state'] = $_POST['state_id'];
                $data['city'] = $_POST['city_id'];
                $data['pincode'] = $_POST['pincode'];
                $data['address'] = $_POST['business_address'];
                $data['user_id'] = $userid;
                $data['business_slug'] = $this->setcategory_slug($data['company_name'], 'business_slug', 'business_profile');
                $data['created_date'] = date('Y-m-d H:i:s', time());
                $data['status'] = '1';
                $data['is_deleted'] = '0';
                $data['business_step'] = '1';

                $data['contact_person'] = $userdata['first_name'] .' '.$userdata['last_name'];
                $data['contact_email'] = $userdata['email'];

                $insert_id = $this->common->insert_data_getid($data, 'business_profile');
                if ($insert_id) {
                    $data['is_success'] = 1;
                } else {
                    $data['is_success'] = 0;
                }
            } else {
                $data['company_name'] = $_POST['companyname'];
                $data['country'] = $_POST['country_id'];
                $data['state'] = $_POST['state_id'];
                $data['city'] = $_POST['city_id'];
                $data['pincode'] = $_POST['pincode'];
                $data['address'] = $_POST['business_address'];
                $data['business_slug'] = $this->setcategory_slug($data['company_name'], 'business_slug', 'business_profile');
                $data['modified_date'] = date('Y-m-d H:i:s', time());
                $updatdata = $this->common->update_data($data, 'business_profile', 'user_id', $userid);
                if ($updatdata) {
                    $data['is_success'] = 1;
                } else {
                    $data['is_success'] = 0;
                }
            }
        }
// response back.
        echo json_encode($data);
    }

    public function contact_information() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        $this->business_profile_active_check();
// GET BUSINESS PROFILE DATA
        $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_step,contact_person,contact_mobile,contact_email,contact_website', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if ($userdata) {
            $step = $userdata[0]['business_step'];

            if ($step == 2 || $step > 2 || ($step >= 1 && $step <= 2)) {
                $this->data['contactname1'] = $userdata[0]['contact_person'];
                $this->data['contactmobile1'] = $userdata[0]['contact_mobile'];
                $this->data['contactemail1'] = $userdata[0]['contact_email'];
                $this->data['contactwebsite1'] = $userdata[0]['contact_website'];
            }
        }
        $this->data['title'] = 'Business Profile' . TITLEPOSTFIX;
        $this->load->view('business_profile/ng_contact_info', $this->data);
    }

    public function getContactInformation() {
        $userid = $this->session->userdata('aileenuser');
        $this->business_profile_active_check();
        // GET BUSINESS PROFILE DATA
        $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_step,contact_person,contact_mobile,contact_email,contact_website', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        echo json_encode($userdata);
    }

    public function ng_contact_info_insert() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $errors = array();
        $data = array();
        $_POST = json_decode(file_get_contents('php://input'), true);
        if (empty($_POST['contactname'])) {
            $errors['contactname'] = 'Person name is required.';
        }
        if (empty($_POST['contactmobile'])) {
            $errors['contactmobile'] = 'Mobile number is required.';
        } elseif (!is_numeric($_POST['contactmobile'])) {
            $errors['contactmobile'] = 'Mobile number should be numeric.';
        }
        if (empty($_POST['email'])) {
            $errors['email'] = 'Email id is required.';
        } elseif ($this->is_validate_email($_POST['email']) != '1') {
            $errors['email'] = 'Please enter valid email id.';
        }

        if (!empty($_POST['contactwebsite'])) {
            if ($this->is_validate_url($_POST['contactwebsite']) != '1') {
                $errors['contactwebsite'] = 'Please enter valid website.';
            }
        }

        if (!empty($errors)) {
            $data['errors'] = $errors;
        } else {
            $data['contact_person'] = $_POST['contactname'];
            $data['contact_mobile'] = $_POST['contactmobile'];
            $data['contact_email'] = $_POST['email'];
            $data['contact_website'] = $_POST['contactwebsite'];
            $data['modified_date'] = date('Y-m-d H:i:s', time());
            if ($_POST['busreg_step'] == '1') {
                $data['business_step'] = '2';
            }
            $updatdata = $this->common->update_data($data, 'business_profile', 'user_id', $userid);
            if ($updatdata) {
                $data['is_success'] = 1;
            } else {
                $data['is_success'] = 0;
            }
        }
// response back.
        echo json_encode($data);
    }

    public function description() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $this->business_profile_active_check();
        $this->load->model('User_model');
        $this->data['business_type'] = $this->User_model->getBusinessType();
        $this->data['category_list'] = $this->User_model->getCategory();
        $this->data['title'] = 'Business Profile' . TITLEPOSTFIX;
        $this->load->view('business_profile/ng_description', $this->data);
    }

    public function getDescription() {
        $userid = $this->session->userdata('aileenuser');
        $this->business_profile_active_check();
        // GET BUSINESS PROFILE DATA
        $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_type,industriyal,details,other_business_type,other_industrial,business_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        // GET INDUSTRIAL TYPE DATA
        $contition_array = array('status' => '1');
        $industriyaldata = $this->common->select_data_by_condition('industry_type', $contition_array, $data = '*', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        // GEY BUSINESS TYPE DATA
        $businesstypedata = $this->common->select_data_by_condition('business_type', $contition_array, $data = '*', $sortby = 'business_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        echo json_encode(array('userdata' => $userdata, 'business_type' => $businesstypedata, 'industriyaldata' => $industriyaldata));
    }

    public function ng_description_insert() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $this->business_profile_active_check();

        $errors = array();
        $data = array();
        $_POST = json_decode(file_get_contents('php://input'), true);
        if (empty($_POST['business_type']) && $_POST['business_type'] != '0') {
            $errors['business_type'] = 'Business type is required.';
        }
        if (empty($_POST['industriyal']) && $_POST['industriyal'] != '0') {
            $errors['industriyal'] = 'Industrial type is required.';
        }
        if (empty($_POST['business_details'])) {
            $errors['business_details'] = 'Business details is required.';
        }
        if ($_POST['business_type'] == '0') {
            if (empty($_POST['bustype'])) {
                $errors['bustype'] = 'Please enter other business type.';
            }
        }
        if ($_POST['industriyal'] == '0') {
            if (empty($_POST['indtype'])) {
                $errors['indtype'] = 'Please enter other industrial type.';
            }
        }

        if (!empty($errors)) {
            $data['errors'] = $errors;
        } else {
            $data['business_type'] = $_POST['business_type'];
            $data['industriyal'] = $_POST['industriyal'];
            if ($data['business_type'] == '0') {
                $data['other_business_type'] = $_POST['bustype'];
            } else {
                $data['other_business_type'] = '';
            }
            if ($data['industriyal'] == '0') {
                $data['other_industrial'] = $_POST['indtype'];
            } else {
                $data['other_industrial'] = '';
            }
            $data['details'] = $_POST['business_details'];
            $data['modified_date'] = date('Y-m-d H:i:s', time());
            if ($_POST['busreg_step'] == '2') {
                $data['business_step'] = '3';
            }
            $updatdata = $this->common->update_data($data, 'business_profile', 'user_id', $userid);
            if ($updatdata) {
                $data['is_success'] = 1;
            } else {
                $data['is_success'] = 0;
            }
        }
        echo json_encode($data);
    }

    public function image() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $this->business_profile_active_check();

        $this->data['title'] = 'Business Profile' . TITLEPOSTFIX;
        $this->load->view('business_profile/ng_image', $this->data);
    }

    public function getImage() {
        $userid = $this->session->userdata('aileenuser');
        $this->business_profile_active_check();
        // GET BUSINESS PROFILE DATA
        $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('user_id' => $userid, 'is_delete' => '0');
        $busimage = $this->common->select_data_by_condition('bus_image', $contition_array, $data = 'bus_image_id,image_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $return_html = '';
        if (count($busimage) > 0) {
            $y = 0;
            foreach ($busimage as $image) {
                $y = $y + 1;

                $return_html .= '<div class="job_work_edit_' . $image['bus_image_id'] . '" id="image_main">
                    <div class="img_bui_data"> 
                        <div class="edit_bui_img">
                            <img id="imageold" src="' . BUS_DETAIL_THUMB_UPLOAD_URL . $image['image_name'] . '" >
                        </div>
                        <div style="float: left;">
                            <div class="hs-submit full-width fl">
                                <a href="javascript:void(0);" class="click_close_icon" onclick="delete_bus_image(' . $image['bus_image_id'] . ');">
                                    <div class="bui_close">
                                        <label for="bui_img_delete"><i class="fa fa-times" aria-hidden="true"></i></label>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        }
        //echo $return_html;
        echo json_encode(array('business_step' => $userdata[0]['business_step'], 'busImageDetail' => $return_html));
    }

    public function bus_img_delete() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $image_id = $_POST['image_id'];
        $data = array(
            'is_delete' => '1'
        );
        $updatdata = $this->common->update_data($data, 'bus_image', 'bus_image_id', $image_id);
        if ($updatdata) {
            echo 'ok';
        }
    }

    public function ng_image_insert() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $this->business_profile_active_check();

        $errors = array();
        $data = array();
        $_POST = json_decode(file_get_contents('php://input'), true);

        $config = array(
            'upload_path' => $this->config->item('bus_profile_main_upload_path'),
            'max_size' => 1024 * 100,
            'allowed_types' => array('jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg')
        );

        $images = array();
        $this->load->library('upload');

        $files = $_FILES;
        $count = count($_FILES['image1']['name']);
        if ($count > 0) {
            $s3 = new S3(awsAccessKey, awsSecretKey);
            $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);

            for ($i = 0; $i < $count; $i++) {
                $_FILES['image1']['name'] = $files['image1']['name'][$i];
                $_FILES['image1']['type'] = $files['image1']['type'][$i];
                $_FILES['image1']['tmp_name'] = $files['image1']['tmp_name'][$i];
                $_FILES['image1']['error'] = $files['image1']['error'][$i];
                $_FILES['image1']['size'] = $files['image1']['size'][$i];

                $fileName = $_FILES['image1']['name'];
                $images[] = $fileName;
                $config['file_name'] = $fileName;

                $this->upload->initialize($config);
                $this->upload->do_upload();

                if ($this->upload->do_upload('image1')) {
                    $response['result'][] = $this->upload->data();
                    $main_image_size = $_FILES['image1']['size'];

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

                    $business_profile_detail_main[$i]['image_library'] = 'gd2';
                    $business_profile_detail_main[$i]['source_image'] = $this->config->item('bus_detail_main_upload_path') . $response['result'][$i]['file_name'];
                    $business_profile_detail_main[$i]['new_image'] = $this->config->item('bus_detail_main_upload_path') . $response['result'][$i]['file_name'];
                    $business_profile_detail_main[$i]['quality'] = $quality;
                    $instanse10 = "image10_$i";
                    $this->load->library('image_lib', $business_profile_detail_main[$i], $instanse10);
                    $this->$instanse10->watermark();

                    /* RESIZE */

                    $main_image = $this->config->item('bus_detail_main_upload_path') . $response['result'][$i]['file_name'];
                    $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);

                    $image_width = $response['result'][$i]['image_width'];
                    $image_height = $response['result'][$i]['image_height'];

                    $thumb_image_width = $this->config->item('bus_detail_thumb_width');
                    $thumb_image_height = $this->config->item('bus_detail_thumb_height');

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

                    $business_profile_detail_thumb[$i]['image_library'] = 'gd2';
                    $business_profile_detail_thumb[$i]['source_image'] = $this->config->item('bus_detail_main_upload_path') . $response['result'][$i]['file_name'];
                    $business_profile_detail_thumb[$i]['new_image'] = $this->config->item('bus_detail_thumb_upload_path') . $response['result'][$i]['file_name'];
                    $business_profile_detail_thumb[$i]['create_thumb'] = TRUE;
                    $business_profile_detail_thumb[$i]['maintain_ratio'] = FALSE;
                    $business_profile_detail_thumb[$i]['thumb_marker'] = '';
                    $business_profile_detail_thumb[$i]['width'] = $n_w;
                    $business_profile_detail_thumb[$i]['height'] = $n_h;
                    $business_profile_detail_thumb[$i]['quality'] = "100%";
                    $business_profile_detail_thumb[$i]['x_axis'] = '0';
                    $business_profile_detail_thumb[$i]['y_axis'] = '0';
                    $instanse = "image_$i";
                    //Loading Image Library
                    $this->load->library('image_lib', $business_profile_detail_thumb[$i], $instanse);
                    $dataimage = $response['result'][$i]['file_name'];
                    //Creating Thumbnail
                    $this->$instanse->resize();
                    /* CROP */
                    // reconfigure the image lib for cropping
                    $conf_new[$i] = array(
                        'image_library' => 'gd2',
                        'source_image' => $business_profile_detail_thumb[$i]['new_image'],
                        'create_thumb' => FALSE,
                        'maintain_ratio' => FALSE,
                        'width' => $thumb_image_width,
                        'height' => $thumb_image_height
                    );

                    $conf_new[$i]['new_image'] = $this->config->item('bus_detail_thumb_upload_path') . $response['result'][$i]['file_name'];

                    $left = ($n_w / 2) - ($thumb_image_width / 2);
                    $top = ($n_h / 2) - ($thumb_image_height / 2);

                    $conf_new[$i]['x_axis'] = $left;
                    $conf_new[$i]['y_axis'] = $top;

                    $instanse1 = "image1_$i";
                    //Loading Image Library
                    $this->load->library('image_lib', $conf_new[$i], $instanse1);
                    $dataimage = $response['result'][$i]['file_name'];
                    //Creating Thumbnail
                    $this->$instanse1->crop();

                    $resize_image = $this->config->item('bus_detail_thumb_upload_path') . $response['result'][$i]['file_name'];
                    $abc = $s3->putObjectFile($resize_image, bucket, $resize_image, S3::ACL_PUBLIC_READ);

                    /* CROP */

                    $response['error'][] = $thumberror = $this->$instanse->display_errors();
                    $return['data'][] = $imgdata;
                    $return['status'] = "success";
                    $return['msg'] = sprintf($this->lang->line('success_item_added'), "Image", "uploaded");

                    if ($_SERVER['HTTP_HOST'] != "localhost") {
                        if (isset($main_image)) {
                            unlink($main_image);
                        }
                        if (isset($resize_image)) {
                            unlink($resize_image);
                        }
                    }
                } else {
                    $dataimage = '';
                }
                if (count($response['error']) > 0) {
                    $data['errors'] = $errors;
                }
                if ($dataimage) {
                    $data = array(
                        'image_name' => $dataimage,
                        'user_id' => $userid,
                        'created_date' => date('Y-m-d H:i:s'),
                        'is_delete' => '0'
                    );
                    $insert_id = $this->common->insert_data_getid($data, 'bus_image');
                }

                if ($dataimage) {
                    $data = array(
                        'modified_date' => date('Y-m-d H:i:s', time()),
                        'business_step' => '4'
                    );
                    $updatdata = $this->common->update_data($data, 'business_profile', 'user_id', $userid);
                } else {
                    $data = array(
                        'modified_date' => date('Y-m-d H:i:s', time()),
                        'business_step' => '4'
                    );
                    $updatdata = $this->common->update_data($data, 'business_profile', 'user_id', $userid);
                }
            }
        } else {
            $data = array(
                'modified_date' => date('Y-m-d H:i:s', time()),
                'business_step' => '4'
            );
            $updatdata = $this->common->update_data($data, 'business_profile', 'user_id', $userid);
        }
        if ($updatdata) {
            $data['is_success'] = 1;
        } else {
            $data['is_success'] = 0;
        }

        echo json_encode($data);
    }

    public function get_company_name($id = '') {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $contition_array = array('business_slug' => $id, 'is_deleted' => '0', 'status' => '1');
        $businessdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'company_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        return $company_name = $businessdata[0]['company_name'];
    }

    public function business_home_follow_ignore() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        $business_profile_id = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->business_profile_id;
        $follow_to = $_POST['follow_to'];

        $insert_data['profile'] = '2';
        $insert_data['user_from'] = $business_profile_id;
        $insert_data['user_to'] = $follow_to;

        echo $insert_id = $this->common->insert_data_getid($insert_data, 'user_ignore');
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
            redirect('business-profile/registration/business-information', refresh);
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
    }

    public function reg_country() {
        $this->load->view('business_profile/khytai_business', $this->data);
    }

}
