<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Business_profile extends MY_Controller {

    public $data;

    public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->model('email_model');
        $this->lang->load('message', 'english');
        include ('include.php');

// DEACTIVATE PROFILE START

        $userid = $this->session->userdata('aileenuser');

// IF USER DEACTIVE PROFILE THEN REDIRECT TO BUSINESS-PROFILE/INDEX UNTILL ACTIVE PROFILE START

        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_deleted' => '0');
        $business_deactive = $this->data['business_deactive'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '	business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($business_deactive) {
            redirect('business-profile/');
        }
// IF USER DEACTIVE PROFILE THEN REDIRECT TO BUSINESS-PROFILE/INDEX UNTILL ACTIVE PROFILE END
// DEACTIVATE PROFILE END
// CODE FOR SECOND HEADER SEARCH START

        $contition_array = array('status' => '1', 'is_deleted' => '0', 'business_step' => 4);
        $businessdata = $this->data['results'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'company_name,other_industrial,other_business_type', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

// GET BUSINESS TYPE
        $contition_array = array('status' => '1', 'is_delete' => '0');
        $businesstype = $this->data['results'] = $this->common->select_data_by_condition('business_type', $contition_array, $data = 'business_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

// GET INDUSTRIAL TYPE
        $contition_array = array('status' => '1', 'is_delete' => '0');
        $industrytype = $this->data['results'] = $this->common->select_data_by_condition('industry_type', $contition_array, $data = 'industry_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        $unique = array_merge($businessdata, $businesstype, $industrytype);
        foreach ($unique as $key => $value) {
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

// GET LOCATION DATA
        $contition_array = array('status' => '1');
        $location_list = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        foreach ($location_list as $key1 => $value1) {
            foreach ($value1 as $ke1 => $val1) {
                $location[] = $val1;
            }
        }

        foreach ($location as $key => $value) {
            $loc[$key]['label'] = $value;
            $loc[$key]['value'] = $value;
        }

        $this->data['city_data'] = array_values($loc);

        $this->data['demo'] = array_values($result1);

// CODE FOR SECOND HEADER SEARCH END
    }

    public function index() {

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

// GET COUNTRY DATA
            $contition_array = array('status' => 1);
            $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = 'country_id,country_name', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// GET STATE DATA
            $contition_array = array('status' => 1);
            $this->data['states'] = $this->common->select_data_by_condition('states', $contition_array, $data = 'state_id,state_name,country_id', $sortby = 'state_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// GET CITY DATA
            $contition_array = array('status' => 1);
            $this->data['cities'] = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_id,city_name,state_id', $sortby = 'city_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if (count($userdata) > 0) {

                if ($userdata[0]['business_step'] == 1) {
                    redirect('business-profile/contact-information', refresh);
                } else if ($userdata[0]['business_step'] == 2) {
                    redirect('business-profile/description', refresh);
                } else if ($userdata[0]['business_step'] == 3) {
                    redirect('business-profile/image', refresh);
                } else if ($userdata[0]['business_step'] == 4) {
//redirect('business_profile/addmore', refresh);
                    redirect('business-profile/home', refresh);
                } else if ($userdata[0]['business_step'] == 5) {
                    redirect('business-profile/home', refresh);
                }
            } else {
                $this->load->view('business_profile/business_info', $this->data);
            }
        }
    }

    public function ajax_data() {

//dependentacy industrial and sub industriyal start
        if (isset($_POST["industry_id"]) && !empty($_POST["industry_id"])) {
//Get all state data
            $contition_array = array('industry_id' => $_POST["industry_id"], 'status' => 1);
            $subindustriyaldata = $this->data['subindustriyaldata'] = $this->common->select_data_by_condition('sub_industry_type', $contition_array, $data = '*', $sortby = 'sub_industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


//Count total number of rows
//Display sub industiyal list
            if (count($subindustriyaldata) > 0) {
                echo '<option value="">Select Sub Industrial</option>';
                foreach ($subindustriyaldata as $st) {
                    echo '<option value="' . $st['sub_industry_id'] . '">' . $st['sub_industry_name'] . '</option>';
                }
            } else {
                echo '<option value="">Subindustriyal not available</option>';
            }
        }

// dependentacy industrial and sub industriyal end  


        if (isset($_POST["country_id"]) && !empty($_POST["country_id"])) {
//Get all state data
            $contition_array = array('country_id' => $_POST["country_id"], 'status' => 1);
            $state = $this->data['states'] = $this->common->select_data_by_condition('states', $contition_array, $data = '*', $sortby = 'state_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

//Count total number of rows
//Display states list
            if (count($state) > 0) {
                echo '<option value="">Select state</option>';
                foreach ($state as $st) {
                    echo '<option value="' . $st['state_id'] . '">' . $st['state_name'] . '</option>';
                }
            } else {
                echo '<option value="">State not available</option>';
            }
        }

        if (isset($_POST["state_id"]) && !empty($_POST["state_id"])) {
//Get all city data
            $contition_array = array('state_id' => $_POST["state_id"], 'status' => 1);
            $city = $this->data['city'] = $this->common->select_data_by_condition('cities', $contition_array, $data = '*', $sortby = 'city_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


//Display cities list
            if (count($city) > 0) {
                echo '<option value="">Select city</option>';
                foreach ($city as $cit) {
                    echo '<option value="' . $cit['city_id'] . '">' . $cit['city_name'] . '</option>';
                }
            } else {
                echo '<option value="">City not available</option>';
            }
        }
    }

    public function business_information_update() {
        $userid = $this->session->userdata('aileenuser');

// GET BUSINESS PROFILE DATA
        $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'country,state,city,company_name,pincode,address,business_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// GET COUNTRY DATA
        $contition_array = array('status' => 1);
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

        $this->load->view('business_profile/business_info', $this->data);
    }

//business automatic retrieve controller start
    public function business() {
        $json = [];

        if (!empty($this->input->get("q"))) {
            $this->db->like('skill', $this->input->get("q"));
            $query = $this->db->select('skill_id as id,skill as text')
                    ->limit(10)
                    ->get("skill");
            $json = $query->result();
        }

        echo json_encode($json);
    }

//business automatic retrieve controller End
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

    public function business_information_insert() {

        $userid = $this->session->userdata('aileenuser');

        if ($this->input->post('next')) {

            $this->form_validation->set_rules('companyname', 'Company Name', 'required');
            $this->form_validation->set_rules('country', 'Country', 'required');
            $this->form_validation->set_rules('state', 'state', 'required');
            $this->form_validation->set_rules('business_address', 'Address', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('business_profile/business_info');
            }

// GET DATA BY ID ONLY

            $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
            $userdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $companyname = $this->input->post('companyname');

            if ($userdata) {
                $data = array(
                    'company_name' => $this->input->post('companyname'),
                    'country' => $this->input->post('country'),
                    'state' => $this->input->post('state'),
                    'city' => $this->input->post('city'),
                    'pincode' => $this->input->post('pincode'),
                    'address' => $this->input->post('business_address'),
                    'user_id' => $userid,
                    'business_slug' => $this->setcategory_slug($companyname, 'business_slug', 'business_profile'),
                    'modified_date' => date('Y-m-d', time()),
                    'status' => 1,
                    'is_deleted' => 0
                );

                $updatdata = $this->common->update_data($data, 'business_profile', 'user_id', $userid);
                if ($updatdata) {

                    $this->session->set_flashdata('success', 'Business information updated successfully');
                    redirect('business-profile/contact-information', refresh);
                } else {
                    $this->session->flashdata('error', 'Sorry!! Your data not inserted');
                    redirect('business-profile', refresh);
                }
            } else {

                $data = array(
                    'company_name' => $this->input->post('companyname'),
                    'country' => $this->input->post('country'),
                    'state' => $this->input->post('state'),
                    'city' => $this->input->post('city'),
                    'pincode' => $this->input->post('pincode'),
                    'address' => $this->input->post('business_address'),
                    'user_id' => $userid,
                    'business_slug' => $this->setcategory_slug($companyname, 'business_slug', 'business_profile'),
                    'created_date' => date('Y-m-d H:i:s', time()),
                    'status' => 1,
                    'is_deleted' => 0,
                    'business_step' => 1
                );



                $insert_id = $this->common->insert_data_getid($data, 'business_profile');
                if ($insert_id) {


                    $this->session->set_flashdata('success', 'Business information updated successfully');
                    redirect('business-profile/contact-information', refresh);
                } else {
                    $this->session->flashdata('error', 'Sorry!! Your data not inserted');
                    redirect('business-profile', refresh);
                }
            }
        }
    }

    public function contact_information() {

        $userid = $this->session->userdata('aileenuser');

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

        $this->load->view('business_profile/contact_info', $this->data);
    }

    public function contact_information_insert() {
        $userid = $this->session->userdata('aileenuser');

        if ($this->input->post('previous')) {
            redirect('business-profile', refresh);
        }

        $this->form_validation->set_rules('contactname', 'Contact person', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');


        if ($this->form_validation->run() == FALSE) {
            $this->load->view('business_profile/contact_info');
        } else {

            $contition_array = array('user_id' => $userid, 'status' => '1');
            $userdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($userdata[0]['business_step'] == 4) {
                $data = array(
                    'contact_person' => $this->input->post('contactname'),
                    'contact_mobile' => $this->input->post('contactmobile'),
                    'contact_email' => $this->input->post('email'),
                    'contact_website' => $this->input->post('contactwebsite'),
                    'modified_date' => date('Y-m-d', time()),
                        //'business_step' => 2
                );
            } else {
                $data = array(
                    'contact_person' => $this->input->post('contactname'),
                    'contact_mobile' => $this->input->post('contactmobile'),
                    'contact_email' => $this->input->post('email'),
                    'contact_website' => $this->input->post('contactwebsite'),
                    'modified_date' => date('Y-m-d', time()),
                    'business_step' => 2
                );
            }
            $updatdata = $this->common->update_data($data, 'business_profile', 'user_id', $userid);

            if ($updatdata) {
                $this->session->set_flashdata('success', 'Contact information updated successfully');
                redirect('business-profile/description', refresh);
            } else {
                $this->session->flashdata('error', 'Your data not inserted');
                redirect('business-profile/contact-information', refresh);
            }
        }
    }

    public function check_email() {
        $email = $this->input->post('email');
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $email1 = $userdata[0]['contact_email'];
        if ($email1) {
            $condition_array = array('is_deleted' => '0', 'user_id !=' => $userid, 'status' => '1', 'business_step' => 4);
            $check_result = $this->common->check_unique_avalibility('business_profile', 'contact_email', $email, '', '', $condition_array);
        } else {
            $condition_array = array('is_deleted' => '0', 'status' => '1', 'business_step' => 4);
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

    public function description() {

        $userid = $this->session->userdata('aileenuser');

// GET BUSINESS PROFILE DATA
        $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_type,industriyal,subindustriyal,details,other_business_type,other_industrial', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// GET INDUSTRIAL TYPE DATA
        $contition_array = array('status' => 1);
        $this->data['industriyaldata'] = $this->common->select_data_by_condition('industry_type', $contition_array, $data = '*', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// GEY BUSINESS TYPE DATA
        $this->data['businesstypedata'] = $this->common->select_data_by_condition('business_type', $contition_array, $data = '*', $sortby = 'business_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userdata) {
            $step = $userdata[0]['business_step'];

            if ($step == 3 || ($step >= 1 && $step <= 3) || $step > 3) {
                $this->data['business_type1'] = $userdata[0]['business_type'];
                $this->data['industriyal1'] = $userdata[0]['industriyal'];
                $this->data['subindustriyal1'] = $userdata[0]['subindustriyal'];
                $this->data['business_details1'] = $userdata[0]['details'];
                $this->data['other_business'] = $userdata[0]['other_business_type'];
                $this->data['other_industry'] = $userdata[0]['other_industrial'];
            }
        }
        $this->load->view('business_profile/description', $this->data);
    }

    public function description_insert() {

        $userid = $this->session->userdata('aileenuser');

        if ($this->input->post('next')) {

            $this->form_validation->set_rules('business_type', 'Business Type', 'required');
            $this->form_validation->set_rules('industriyal', 'Industriyal', 'required');

            $this->form_validation->set_rules('business_details', 'Details', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('business_profile/description');
            } else {

                $contition_array = array('user_id' => $userid, 'status' => '1');
                $userdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($userdata[0]['business_step'] == 4) {
                    $data = array(
                        'business_type' => $this->input->post('business_type'),
                        'industriyal' => $this->input->post('industriyal'),
                        'subindustriyal' => $this->input->post('subindustriyal'),
                        'other_business_type' => $this->input->post('bustype'),
                        'other_industrial' => $this->input->post('indtype'),
                        'details' => $this->input->post('business_details'),
                        'modified_date' => date('Y-m-d', time()),
                            //'business_step' => 3
                    );
                } else {
                    $data = array(
                        'business_type' => $this->input->post('business_type'),
                        'industriyal' => $this->input->post('industriyal'),
                        'subindustriyal' => $this->input->post('subindustriyal'),
                        'other_business_type' => $this->input->post('bustype'),
                        'other_industrial' => $this->input->post('indtype'),
                        'details' => $this->input->post('business_details'),
                        'modified_date' => date('Y-m-d', time()),
                        'business_step' => 3
                    );
                }
                $updatdata = $this->common->update_data($data, 'business_profile', 'user_id', $userid);

                if ($updatdata) {
                    $this->session->set_flashdata('success', 'Description updated successfully');
                    redirect('business-profile/image', refresh);
                } else {
                    $this->session->flashdata('error', 'Your data not inserted');
                    redirect('business-profile/description', refresh);
                }
            }
        }
    }

    public function image() {

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userdata) {
            $step = $userdata[0]['business_step'];

            if ($step == 4 || ($step >= 1 && $step <= 4) || $step > 4) {
                $contition_array = array('user_id' => $userid, 'is_delete' => '0');
                $this->data['busimage'] = $this->common->select_data_by_condition('bus_image', $contition_array, $data = 'image_id,image_name,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            }
        }
        $this->load->view('business_profile/image', $this->data);
    }

    public function image_insert() {

        $userdata = $this->session->userdata();
        $userid = $this->session->userdata('aileenuser');

// GET USER BUSINESS STEP AND SLUG
        $contition_array = array('user_id' => $userid, 'status' => '1', 'is_deleted' => '0');
        $busin_step_slug = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_step,business_slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        $business_slug = $busin_step_slug[0]['business_slug'];

        $count1 = count($this->input->post('filedata'));

        for ($x = 0; $x < $count1; $x++) {
            if ($_POST['filedata'][$x] == 'old') {

                $data = array(
                    'image_name' => $_POST['filename'][$x],
                );
                $updatdata = $this->common->update_data($data, 'bus_image', 'image_id', $_POST['imageid'][$x]);
            }

            if ($_POST['filedata'][$x]) {
                $data = array(
                    'modified_date' => date('Y-m-d', time()),
                    'business_step' => 4
                );

                $updatdata = $this->common->update_data($data, 'business_profile', 'user_id', $userid);
            } else {
                $data = array(
                    'modified_date' => date('Y-m-d', time()),
                    'business_step' => 4
                );

                $updatdata = $this->common->update_data($data, 'business_profile', 'user_id', $userid);
            }
        }
        $contition_array = array('user_id' => $userid, 'is_delete' => '0');
        $userdatacon = $this->common->select_data_by_condition('bus_image', $contition_array, $data = 'image_id, image_name, user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($this->input->post('next') || $this->input->post('submit')) {

            $config = array(
                'upload_path' => $this->config->item('bus_profile_main_upload_path'),
                'max_size' => 1024 * 100,
                'allowed_types' => 'gif|jpeg|jpg|png'
            );
            $images = array();
            $this->load->library('upload');

            $files = $_FILES;
            $count = count($_FILES['image1']['name']);

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
                    $business_profile_post_thumb[$i]['image_library'] = 'gd2';
                    $business_profile_post_thumb[$i]['source_image'] = $this->config->item('bus_profile_main_upload_path') . $response['result'][$i]['file_name'];
                    $business_profile_post_thumb[$i]['new_image'] = $this->config->item('bus_profile_thumb_upload_path') . $response['result'][$i]['file_name'];
                    $business_profile_post_thumb[$i]['create_thumb'] = TRUE;
                    $business_profile_post_thumb[$i]['maintain_ratio'] = TRUE;
                    $business_profile_post_thumb[$i]['thumb_marker'] = '';
                    $business_profile_post_thumb[$i]['width'] = $this->config->item('bus_profile_thumb_width');
                    $business_profile_post_thumb[$i]['height'] = 2;
                    $business_profile_post_thumb[$i]['master_dim'] = 'width';
                    $business_profile_post_thumb[$i]['quality'] = "100%";
                    $business_profile_post_thumb[$i]['x_axis'] = '0';
                    $business_profile_post_thumb[$i]['y_axis'] = '0';
                    $instanse = "image_$i";
//Loading Image Library
                    $this->load->library('image_lib', $business_profile_post_thumb[$i], $instanse);
                    $dataimage = $response['result'][$i]['file_name'];
//Creating Thumbnail
                    $this->$instanse->resize();
                    $response['error'][] = $thumberror = $this->$instanse->display_errors();

                    $return['data'][] = $imgdata;
                    $return['status'] = "success";
                    $return['msg'] = sprintf($this->lang->line('success_item_added'), "Image", "uploaded");
                } else {
                    $dataimage = '';
                }

                if ($dataimage) {
                    $data = array(
                        'image_name' => $dataimage,
                        'user_id' => $userid,
                        'created_date' => date('Y-m-d H:i:s'),
                        'is_delete' => 0
                    );

                    $insert_id = $this->common->insert_data_getid($data, 'bus_image');
                }

                if ($dataimage) {
                    $data = array(
                        'modified_date' => date('Y-m-d', time()),
                        'business_step' => 4
                    );
                    $updatdata = $this->common->update_data($data, 'business_profile', 'user_id', $userid);
                } else {
                    $data = array(
                        'modified_date' => date('Y-m-d', time()),
                        'business_step' => 4
                    );
                    $updatdata = $this->common->update_data($data, 'business_profile', 'user_id', $userid);
                }
            }

            if ($updatdata) {
                $this->session->set_flashdata('success', 'Image updated successfully');
                if ($busin_step_slug[0]['business_step'] == 4) {
                    if ($business_slug != '') {
                        redirect('business-profile/details/' . $business_slug, refresh);
                    } else {
                        redirect('business-profile/details', refresh);
                    }
                } else {
                    redirect('business-profile/home', refresh);
                }
            } else {
                $this->session->flashdata('error', 'Your data not inserted');
                redirect('business-profile/image', refresh);
            }
        }
    }

    public function addmore() {
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_step,addmore', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userdata) {
            $step = $userdata[0]['business_step'];

            if ($step == 5 || ($step >= 1 && $step <= 5) || $step > 5) {
                $this->data['addmore1'] = $userdata[0]['addmore'];
            }
        }

        $this->load->view('business_profile/addmore', $this->data);
    }

    public function addmore_insert() {
        $userid = $this->session->userdata('aileenuser');

        $data = array(
            'addmore' => $this->input->post('addmore'),
            'modified_date' => date('Y-m-d', time()),
            'business_step' => 5
        );

        $updatdata = $this->common->update_data($data, 'business_profile', 'user_id', $userid);

        if ($updatdata) {
            redirect('business-profile/business-profile-post', refresh);
        } else {
            $this->session->flashdata('error', 'Your data not inserted');
            redirect('business-profile/addmore', refresh);
        }
    }

    public function business_profile_post() {

        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

// GET BUSINESS DATA
        $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['businessdata'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id,company_name,business_slug,business_user_image,profile_background,industriyal,city,state,other_industrial', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $business_profile_id = $this->data['businessdata'][0]['business_profile_id'];

// GET USER LIST IN LEFT SIDE
        $contition_array = array('is_deleted' => 0, 'status' => 1, 'user_id !=' => $userid, 'business_step' => 4);
        $userlist = $this->data['userlist'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id,company_name,business_slug,business_user_image,industriyal,city,state,other_industrial', $sortby = 'business_profile_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// GET INDUSTRIAL WISE DATA
        $industriyal = $this->data['businessdata'][0]['industriyal'];
        foreach ($userlist as $rowcategory) {

            if ($industriyal == $rowcategory['industriyal']) {
                $userlistcategory[] = $rowcategory;
            }
        }
        $this->data['userlistview1'] = $userlistcategory;
// GET INDUSTRIAL WISE DATA
// GET CITY WISE DATA
        $businessregcity = $this->data['businessdata'][0]['city'];

        $contition_array = array('is_deleted' => 0, 'status' => 1, 'user_id !=' => $userid, 'industriyal !=' => $industriyal, 'business_step' => 4);
        $userlist2 = $this->data['userlist2'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id,company_name,business_slug,business_user_image,industriyal,city,state,other_industrial', $sortby = 'business_profile_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        foreach ($userlist2 as $rowcity) {
            if ($businessregcity == $rowcity['city']) {
                $userlistcity[] = $rowcity;
            }
        }
        $this->data['userlistview2'] = $userlistcity;
// GET CITY WISE DATA
// GET STATE WISE DATA
        $businessregstate = $this->data['businessdata'][0]['state'];
        $contition_array = array('is_deleted' => 0, 'status' => 1, 'user_id !=' => $userid, 'industriyal !=' => $industriyal, 'city !=' => $businessregcity, 'business_step' => 4);
        $userlist3 = $this->data['userlist3'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id,company_name,business_slug,business_user_image,industriyal,city,state', $sortby = 'business_profile_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        foreach ($userlist3 as $rowstate) {
            if ($businessregstate == $rowstate['state']) {
                $userliststate[] = $rowstate;
            }
        }
        $this->data['userlistview3'] = $userliststate;
// GET STATE WISE DATA
// GET 3 USER
        $contition_array = array('is_deleted' => 0, 'status' => 1, 'user_id !=' => $userid, 'industriyal !=' => $industriyal, 'city !=' => $businessregcity, 'state !=' => $businessregstate, 'business_step' => 4);
        $userlastview = $this->data['userlastview'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = 'business_profile_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->data['userlistview4'] = $userlastview;

// GET FOLLOWER DATA 

        $contition_array = array('follow_from' => $business_profile_id, 'follow_status' => '1', 'follow_type' => '2');
        $followerdata = $this->data['followerdata'] = $this->common->select_data_by_condition('follow', $contition_array, $data = 'follow_id,follow_type,follow_from,follow_to', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        foreach ($followerdata as $fdata) {

            $contition_array = array('business_profile_id' => $fdata['follow_to'], 'business_step' => 4);
            $this->data['business_data'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $business_userid = $this->data['business_data'][0]['user_id'];
            $contition_array = array('user_id' => $business_userid, 'status' => '1', 'is_delete' => '0');

            $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $followerabc[] = $this->data['business_profile_data'];
        }
        $userselectindustriyal = $this->data['businessdata'][0]['industriyal'];

// GET INDUSTRIAL DATA START
        $contition_array = array('industriyal' => $userselectindustriyal, 'status' => '1', 'business_step' => 4);
        $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        foreach ($businessprofiledata as $fdata) {
            $contition_array = array('business_profile_post.user_id' => $fdata['user_id'], 'business_profile_post.status' => '1', 'business_profile_post.user_id !=' => $userid, 'is_delete' => '0');
            $this->data['business_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $industriyalabc[] = $this->data['business_data'];
        }
// GET INDUSTRIAL DATA END
// GET LOGIN USER LAST POST START

        $condition_array = array('user_id' => $userid, 'status' => '1', 'is_delete' => '0');

        $business_datauser = $this->data['business_datauser'] = $this->common->select_data_by_condition('business_profile_post', $condition_array, $data = '*', $sortby = 'business_profile_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $userabc[][] = $this->data['business_datauser'][0];

// GET LOGIN USER LAST POST END
// ARRAY MERGE AND GET UNIQUE VALUE 

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

        $this->data['businessprofiledatapost'] = $new;
        $this->data['business_left'] = $this->load->view('business_profile/business_left', $this->data, true);
        $this->load->view('business_profile/business_profile_post', $this->data);
    }

    public function business_profile_manage_post($id = "") {

        $this->data['slugid'] = $id;

// manage post start
        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['slug_data'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $slug_id = $this->data['slug_data'][0]['business_slug'];
        if ($id == $slug_id || $id == '') {

            $contition_array = array('business_slug' => $slug_id, 'status' => '1');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'status' => 1, 'is_delete' => '0');
            $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data, $sortby = 'business_profile_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {

            $contition_array = array('business_slug' => $id, 'status' => '1', 'business_step' => 4);
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'status' => 1, 'is_delete' => '0');
            $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data, $sortby = 'business_profile_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }

//manage post end
        if ($this->session->userdata('aileenuser')) {
            $this->load->view('business_profile/business_profile_manage_post', $this->data);
        } else {
            $this->data['business_common_profile'] = $this->load->view('business_profile/business_common_profile', $this->data, true);
            $this->load->view('business_profile/business_dashboard', $this->data);
        }

// save post end       
    }

    public function business_profile_deletepost() {

        $id = $_POST["business_profile_post_id"];
//echo $id; die();
        $data = array(
            'is_delete' => 1,
            'modify_date' => date('Y-m-d', time())
        );


        $updatdata = $this->common->update_data($data, 'business_profile_post', 'business_profile_post_id', $id);

        $dataimage = array(
            'is_deleted' => 0,
            'modify_date' => date('Y-m-d', time())
        );

//echo "<pre>"; print_r($dataimage); die();
        $updatdata = $this->common->update_data($dataimage, 'post_files', 'post_id', $id);

        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');


        $contition_array = array('user_id' => $userid, 'status' => 1, 'is_delete' => '0');
        $otherdata = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $datacount = count($otherdata);



        if (count($otherdata) == 0) {
            $notfound = '<div class="contact-frnd-post bor_none">';
            $notfound .= '<div class="text-center rio">';
            $notfound .= '<h4 class="page-heading  product-listing">No Following Found.</h4>';
            $notfound .= '</div></div>';

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



        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        $id = $_POST["business_profile_post_id"];
//echo $id; die();
        $data = array(
            'is_delete' => 1,
            'modify_date' => date('Y-m-d', time())
        );

//echo "<pre>"; print_r($data); die();
        $updatdata = $this->common->update_data($data, 'business_profile_post', 'business_profile_post_id', $id);

        $dataimage = array(
            'is_deleted' => 0,
            'modify_date' => date('Y-m-d', time())
        );

//echo "<pre>"; print_r($dataimage); die();
        $updatdata = $this->common->update_data($dataimage, 'post_files', 'post_id', $id);

// for post count start



        $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['businessdata'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

//echo "<pre>"; print_r($this->data['businessdata']); die(); 

        $business_profile_id = $this->data['businessdata'][0]['business_profile_id'];




        $contition_array = array('follow_from' => $business_profile_id, 'follow_status' => '1', 'follow_type' => '2');

        $followerdata = $this->data['followerdata'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

//echo "<pre>" ; print_r($this->data['followerdata']); die();

        foreach ($followerdata as $fdata) {

            $contition_array = array('business_profile_id' => $fdata['follow_to'], 'business_step' => 4);

            $this->data['business_data'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// echo "<pre>" ; print_r($this->data['business_data']); die();

            $business_userid = $this->data['business_data'][0]['user_id'];
//echo $business_userid; die();
            $contition_array = array('user_id' => $business_userid, 'status' => '1', 'is_delete' => '0');

            $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

//echo "<pre>"; print_r($this->data['business_profile_data']) ; die();

            $followerabc[] = $this->data['business_profile_data'];
        }
//echo "<pre>" ; print_r($followerabc); die();
//data fatch using follower end
//data fatch using industriyal start

        $userselectindustriyal = $this->data['businessdata'][0]['industriyal'];

        $contition_array = array('industriyal' => $userselectindustriyal, 'status' => '1', 'business_step' => 4);
        $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
// echo "<pre>"; print_r( $businessprofiledata); die();



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

//echo "<pre>"; print_r($unique); die();

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

        if (count($otherdata) > 0) {
            if (count($count) == count($otherdata)) {

                $datacount = "count";


                $notfound = ' <div class="art-img-nn">
                                    <div class="art_no_post_img">

                                        <img src="' . base_url('assets/img/bui-no.png') . '">

                                    </div>
                                    <div class="art_no_post_text">
                                        No Following Available.
                                    </div>
                                </div>';
            }
        } else {

            $datacount = "count";

            $notfound = ' <div class="art-img-nn">
                                    <div class="art_no_post_img">

                                        <img src="' . base_url('assets/img/bui-no.png') . '">

                                    </div>
                                    <div class="art_no_post_text">
                                        No Following Available.
                                    </div>
                                </div>';
        }

        echo json_encode(
                array(
                    "notfound" => $notfound,
                    "notcount" => $datacount,
        ));
    }

    public function business_profile_addpost() {
        $userid = $this->session->userdata('aileenuser');


        $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['businessdata'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->load->view('business_profile/business_profile_addpost', $this->data);
    }

    public function business_profile_addpost_insert($id = "", $para = "") {

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $para, 'status' => '1');
        $this->data['businessdataposted'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($para == $userid || $para == '') {
            $data = array(
                'product_name' => $this->input->post('my_text'),
                'product_description' => $this->input->post('product_desc'),
                'created_date' => date('Y-m-d H:i:s', time()),
                'status' => 1,
                'is_delete' => 0,
                'user_id' => $userid
            );
        } else {
            $data = array(
                'product_name' => $this->input->post('my_text'),
                'product_description' => $this->input->post('product_desc'),
                'created_date' => date('Y-m-d H:i:s', time()),
                'status' => 1,
                'is_delete' => 0,
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
        $config = array(
            'upload_path' => $this->config->item('bus_post_main_upload_path'),
            'allowed_types' => $this->config->item('bus_post_main_allowed_types'),
            'overwrite' => true,
            'remove_spaces' => true);
        $images = array();
        $this->load->library('upload');

        $files = $_FILES;
        $count = count($_FILES['postattach']['name']);
        $title = time();

        if ($_FILES['postattach']['name'][0] != '') {

            for ($i = 0; $i < $count; $i++) {

                $_FILES['postattach']['name'] = $files['postattach']['name'][$i];
                $_FILES['postattach']['type'] = $files['postattach']['type'][$i];
                $_FILES['postattach']['tmp_name'] = $files['postattach']['tmp_name'][$i];
                $_FILES['postattach']['error'] = $files['postattach']['error'][$i];
                $_FILES['postattach']['size'] = $files['postattach']['size'][$i];


                if ($_FILES['postattach']['error'] == 0) {

                    $store = $_FILES['postattach']['name'];

                    $store_ext = explode('.', $store);
                    $store_ext = end($store_ext);

                    $fileName = 'file_' . $title . '_' . $this->random_string() . '.' . $store_ext;

                    $images[] = $fileName;
                    $config['file_name'] = $fileName;

                    $this->upload->initialize($config);
                    $this->upload->do_upload();

                    $imgdata = $this->upload->data();

                    if ($this->upload->do_upload('postattach')) {

                        $response['result'][] = $this->upload->data();
                        $business_profile_post_thumb[$i]['image_library'] = 'gd2';
                        $business_profile_post_thumb[$i]['source_image'] = $this->config->item('bus_post_main_upload_path') . $response['result'][$i]['file_name'];
                        $business_profile_post_thumb[$i]['new_image'] = $this->config->item('bus_post_thumb_upload_path') . $response['result'][$i]['file_name'];
                        $business_profile_post_thumb[$i]['create_thumb'] = TRUE;
                        $business_profile_post_thumb[$i]['maintain_ratio'] = TRUE;
                        $business_profile_post_thumb[$i]['thumb_marker'] = '';
                        $business_profile_post_thumb[$i]['width'] = $this->config->item('bus_post_thumb_width');
//$product_thumb[$i]['height'] = $this->config->item('product_thumb_height');
                        $business_profile_post_thumb[$i]['height'] = 2;
                        $business_profile_post_thumb[$i]['master_dim'] = 'width';
                        $business_profile_post_thumb[$i]['quality'] = "100%";
                        $business_profile_post_thumb[$i]['x_axis'] = '0';
                        $business_profile_post_thumb[$i]['y_axis'] = '0';
                        $instanse = "image_$i";
//Loading Image Library
                        $this->load->library('image_lib', $business_profile_post_thumb[$i], $instanse);
                        $dataimage = $response['result'][$i]['file_name'];
//Creating Thumbnail
                        $this->$instanse->resize();
                        $response['error'][] = $thumberror = $this->$instanse->display_errors();

                        $return['data'][] = $imgdata;
                        $return['status'] = "success";
                        $return['msg'] = sprintf($this->lang->line('success_item_added'), "Image", "uploaded");

                        $data1 = array(
                            'image_name' => $fileName,
                            'image_type' => 2,
                            'post_id' => $insert_id,
                            'is_deleted' => 1
                        );
                        $insert_id1 = $this->common->insert_data_getid($data1, 'post_files');
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

        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_deleted' => '0');
        $business_deactive = $this->data['business_deactive'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($business_deactive) {
            redirect('business-profile/');
        }
        $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['businessdata'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $business_profile_id = $this->data['businessdata'][0]['business_profile_id'];
        $contition_array = array('is_deleted' => 0, 'status' => 1, 'user_id !=' => $userid, 'business_step' => 4);
        $userlist = $this->data['userlist'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = 'business_profile_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $industriyal = $this->data['businessdata'][0]['industriyal'];
        foreach ($userlist as $rowcategory) {
            if ($industriyal == $rowcategory['industriyal']) {
                $userlistcategory[] = $rowcategory;
            }
        }

        $this->data['userlistview1'] = $userlistcategory;

        $businessregcity = $this->data['businessdata'][0]['city'];
        $contition_array = array('is_deleted' => 0, 'status' => 1, 'user_id !=' => $userid, 'industriyal !=' => $industriyal, 'business_step' => 4);
        $userlist2 = $this->data['userlist2'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = 'business_profile_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        foreach ($userlist2 as $rowcity) {
            if ($businessregcity == $rowcity['city']) {
                $userlistcity[] = $rowcity;
            }
        }

        $this->data['userlistview2'] = $userlistcity;

        $businessregstate = $this->data['businessdata'][0]['state'];

        $contition_array = array('is_deleted' => 0, 'status' => 1, 'user_id !=' => $userid, 'industriyal !=' => $industriyal, 'city !=' => $businessregcity, 'business_step' => 4);
        $userlist3 = $this->data['userlist3'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = 'business_profile_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        foreach ($userlist3 as $rowstate) {
            if ($businessregstate == $rowstate['state']) {
                $userliststate[] = $rowstate;
            }
        }
        $this->data['userlistview3'] = $userliststate;

        $contition_array = array('is_deleted' => 0, 'status' => 1, 'user_id !=' => $userid, 'industriyal !=' => $industriyal, 'city !=' => $businessregcity, 'state !=' => $businessregstate, 'business_step' => 4);
        $userlastview = $this->data['userlastview'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = 'business_profile_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        $this->data['userlistview4'] = $userlastview;

        $contition_array = array('follow_from' => $business_profile_id, 'follow_status' => '1', 'follow_type' => '2');
        $followerdata = $this->data['followerdata'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        foreach ($followerdata as $fdata) {
            $contition_array = array('business_profile_id' => $fdata['follow_to'], 'business_step' => 4);
            $this->data['business_data'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $business_userid = $this->data['business_data'][0]['user_id'];
            $contition_array = array('user_id' => $business_userid, 'status' => '1', 'is_delete' => '0');
            $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $followerabc[] = $this->data['business_profile_data'];
        }
        $userselectindustriyal = $this->data['businessdata'][0]['industriyal'];

        $contition_array = array('industriyal' => $userselectindustriyal, 'status' => '1', 'business_step' => 4);
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
        $businessprofiledatapost = $new;

        $row = $businessprofiledatapost[0];

//foreach ($businessprofiledatapost as $row) {
        $userid = $this->session->userdata('aileenuser');
        $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1');
        $businessdelete = $this->data['businessdelete'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('user_id' => $row['user_id'], 'status' => '1');
        $businessdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $likeuserarray = explode(',', $businessdelete[0]['delete_post']);
        if (!in_array($userid, $likeuserarray)) {

            $return_html = '<div id="removepost' . $row['business_profile_post_id'] . '">
                    <div class="col-md-12 col-sm-12 post-design-box">
                        <div  class="post_radius_box">  
                            <div class="post-design-top col-md-12" >  
                                <div class="post-design-pro-img"> 
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
                                    </div>';

            $companyname = $this->db->get_where('business_profile', array('user_id' => $row['user_id'], 'status' => 1))->row()->company_name;

            $companynameposted = $this->db->get_where('business_profile', array('user_id' => $row['posted_user_id']))->row()->company_name;

            $business_userimage = $this->db->get_where('business_profile', array('user_id' => $row['user_id'], 'status' => 1))->row()->business_user_image;
            $userimageposted = $this->db->get_where('business_profile', array('user_id' => $row['posted_user_id']))->row()->business_user_image;

            $slugname = $this->db->get_where('business_profile', array('user_id' => $row['user_id'], 'status' => 1))->row()->business_slug;
            $slugnameposted = $this->db->get_where('business_profile', array('user_id' => $row['posted_user_id'], 'status' => 1))->row()->business_slug;
            if ($row['posted_user_id']) {

                if ($userimageposted) {
                    $return_html .= '<a href="' . base_url('business-profile/dashboard/' . $slugnameposted) . '">';

                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $userimageposted)) {
                        $a = $companynameposted;
                        $acr = substr($a, 0, 1);

                        $return_html .= '<div class="post-img-div">';
                        $return_html .= ucfirst(strtolower($acr));
                        $return_html .= '</div>';
                    } else {

                        $return_html .= '<img src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $userimageposted) . '" name="image_src" id="image_src" />';
                    }

                    $return_html .= '</a>';
                } else {
                    $return_html .= '<a href="' . base_url('business-profile/dashboard/' . $slugnameposted) . '">';
                    $a = $companynameposted;
                    $acr = substr($a, 0, 1);

                    $return_html .= '<div class="post-img-div">';
                    $return_html .= ucfirst(strtolower($acr));
                    $return_html .= '</div>';

                    $return_html .= '</a>';
                }
            } else {
                if ($business_userimage) {
                    $return_html .= '<a href="' . base_url('business-profile/dashboard/' . $slugname) . '">';


                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                        $a = $companyname;
                        $acr = substr($a, 0, 1);

                        $return_html .= '<div class="post-img-div">';
                        $return_html .= ucfirst(strtolower($acr));
                        $return_html .= '</div>';
                    } else {
                        $return_html .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) . '"  alt="">';
                    }

                    $return_html .= '</a>';
                } else {
                    $return_html .= '<a href="' . base_url('business-profile/dashboard/' . $slugname) . '">';

                    $a = $companyname;
                    $acr = substr($a, 0, 1);

                    $return_html .= '<div class="post-img-div">';
                    $return_html .= ucfirst(strtolower($acr));
                    $return_html .= '</div>';

                    $return_html .= '</a>';
                }
            }
            $return_html .= '</div>
<div class="post-design-name fl col-md-10">
    <ul>';
            $companyname = $this->db->get_where('business_profile', array('user_id' => $row['user_id'], 'status' => 1))->row()->company_name;
            $slugname = $this->db->get_where('business_profile', array('user_id' => $row['user_id'], 'status' => 1))->row()->business_slug;
            $categoryid = $this->db->get_where('business_profile', array('user_id' => $row['user_id'], 'status' => 1))->row()->industriyal;
            $category = $this->db->get_where('industry_type', array('industry_id' => $categoryid, 'status' => 1))->row()->industry_name;

            $companynameposted = $this->db->get_where('business_profile', array('user_id' => $row['posted_user_id']))->row()->company_name;
            $slugnameposted = $this->db->get_where('business_profile', array('user_id' => $row['posted_user_id'], 'status' => 1))->row()->business_slug;

            $return_html .= '<li>
        </li>';
            if ($row['posted_user_id']) {
                $return_html .= '<li>
            <div class="else_post_d">
                <div class="post-design-product">
                    <a class="post_dot_2" href="' . base_url('business-profile/dashboard/' . $slugnameposted) . '">' . ucfirst(strtolower($companynameposted)) . '</a>
                    <p class="posted_with" > Posted With</p> <a class="other_name name_business post_dot_2"  href="' . base_url('business_profile/business_profile_manage_post/' . $slugname) . '">' . ucfirst(strtolower($companyname)) . '</a>
                    <span role="presentation" aria-hidden="true"> · </span> <span class="ctre_date">
                        ' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($row['created_date']))) . '  
                    </span> </div></div>
        </li>';
                $category = $this->db->get_where('industry_type', array('industry_id' => $businessdata[0]['industriyal'], 'status' => 1))->row()->industry_name;
            } else {
                $return_html .= '<li>
            <div class="post-design-product">
                <a class="post_dot"  href="' . base_url('business-profile/dashboard/' . $slugname) . '" title="' . ucfirst(strtolower($companyname)) . '">
                    ' . ucfirst(strtolower($companyname)) . '</a>
                <span role="presentation" aria-hidden="true"> · </span>
                <div class="datespan"> <span class="ctre_date" > 
                        ' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($row['created_date']))) . '

                    </span></div>

            </div>
        </li>';
            }
            $category = $this->db->get_where('industry_type', array('industry_id' => $businessdata[0]['industriyal'], 'status' => 1))->row()->industry_name;


            $return_html .= '<li>
            <div class="post-design-product">
                <a class="buuis_desc_a" href="javascript:void(0);"  title="Category">';
            if ($category) {
                $return_html .= ucfirst(strtolower($category));
            } else {
                $return_html .= ucfirst(strtolower($businessdata[0]['other_industrial']));
            }

            $return_html .= '</a>
            </div>
        </li>

        <li>
        </li> 
    </ul> 
</div>  
<div class="dropdown1">
    <a onClick="myFunction(' . $row['business_profile_post_id'] . ')" class="dropbtn1 dropbtn1 fa fa-ellipsis-v">
    </a>
    <div id="myDropdown' . $row['business_profile_post_id'] . '" class="dropdown-content1">';

            if ($row['posted_user_id'] != 0) {

                if ($this->session->userdata('aileenuser') == $row['posted_user_id']) {

                    $return_html .= '<a onclick="user_postdelete(' . $row['business_profile_post_id'] . ')">
            <i class="fa fa-trash-o" aria-hidden="true">
            </i> Delete Post
        </a>
        <a id="' . $row['business_profile_post_id'] . '" onClick="editpost(this.id)">
            <i class="fa fa-pencil-square-o" aria-hidden="true">
            </i>Edit
        </a>';
                } else {

                    $return_html .= '<a onclick="user_postdelete(' . $row['business_profile_post_id'] . ')">
            <i class="fa fa-trash-o" aria-hidden="true">
            </i> Delete Post
        </a>
        <a href="' . base_url('business-profile/business-profile-contactperson/' . $row['posted_user_id']) . '">
            <i class="fa fa-user" aria-hidden="true">
            </i> Contact Person </a>';
                }
            } else {
                if ($this->session->userdata('aileenuser') == $row['user_id']) {
                    $return_html .= '<a onclick="user_postdelete(' . $row['business_profile_post_id'] . ')">
            <i class="fa fa-trash-o" aria-hidden="true">
            </i> Delete Post
        </a>
        <a id="' . $row['business_profile_post_id'] . '" onClick="editpost(this.id)">
            <i class="fa fa-pencil-square-o" aria-hidden="true">
            </i>Edit
        </a>';
                } else {
                    $return_html .= '<a onclick="user_postdeleteparticular(' . $row['business_profile_post_id'] . ')">
            <i class="fa fa-trash-o" aria-hidden="true">
            </i> Delete Post
        </a>

        <a href="' . base_url('business-profile/business-profile-contactperson/' . $row['user_id']) . '">
            <i class="fa fa-user" aria-hidden="true">
            </i> Contact Person
        </a>';
                }
            }

            $return_html .= '</div>
</div>
<div class="post-design-desc">
    <div class="ft-15 t_artd">
        <div id="editpostdata' . $row['business_profile_post_id'] . '" style="display:block;">
            <a>' . $this->common->make_links($row['product_name']) . '</a>
        </div>
        <div id="editpostbox' . $row['business_profile_post_id'] . '" style="display:none;">
            <input type="text" id="editpostname' . $row['business_profile_post_id'] . '" name="editpostname" placeholder="Product Name" value="' . $row['product_name'] . '" onKeyDown=check_lengthedit(' . $row['business_profile_post_id'] . '); onKeyup=check_lengthedit(' . $row['business_profile_post_id'] . '); onblur=check_lengthedit(' . $row['business_profile_post_id'] . ');>';


            if ($row['product_name']) {
                $counter = $row['product_name'];
                $a = strlen($counter);

                $return_html .= '<input size=1 id="text_num" class="text_num" value="' . (50 - $a) . '" name=text_num readonly>';
            } else {

                $return_html .= '<input size=1 id="text_num" class="text_num" value=50 name=text_num readonly>';
            }

            $return_html .= '</div>
    </div>                    
    <div id="khyati' . $row['business_profile_post_id'] . '" style="display:block;">';

            $small = substr($row['product_description'], 0, 180);
            $return_html .= $this->common->make_links($small);
            if (strlen($row['product_description']) > 180) {
                $return_html .= '... <span id="kkkk" onClick="khdiv(' . $row['business_profile_post_id'] . ')">View More</span>';
            }

            $return_html .= '</div>
    <div id="khyatii' . $row['business_profile_post_id'] . '" style="display:none;">
        ' . $row['product_description'] . '</div>
    <div id="editpostdetailbox' . $row['business_profile_post_id'] . '" style="display:none;">
        <div  contenteditable="true" id="editpostdesc' . $row['business_profile_post_id'] . '"  class="textbuis editable_text margin_btm" name="editpostdesc" placeholder="Description" onpaste="OnPaste_StripFormatting(this, event);" >' . $row['product_description'] . '</div>
    </div>
    <div id="editpostdetailbox' . $row['business_profile_post_id'] . '" style="display:none;">
        <div contenteditable="true" id="editpostdesc' . $row['business_profile_post_id'] . '" placeholder="Product Description" class="textbuis  editable_text"  name="editpostdesc" onpaste="OnPaste_StripFormatting(this, event);">' . $row['product_description'] . '</div>                  
    </div>
    <button class="fr" id="editpostsubmit' . $row['business_profile_post_id'] . '" style="display:none;margin: 5px 0; border-radius: 3px;" onClick="edit_postinsert(' . $row['business_profile_post_id'] . ')">Save
    </button>
</div> 
</div>
<div class="post-design-mid col-md-12 padding_adust" >
    <div>';

            $contition_array = array('post_id' => $row['business_profile_post_id'], 'is_deleted' => '1', 'image_type' => '2');
            $businessmultiimage = $this->data['businessmultiimage'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if (count($businessmultiimage) == 1) {

                $allowed = array('gif', 'PNG', 'jpg', 'jpeg');
                $allowespdf = array('pdf');
                $allowesvideo = array('mp4', 'webm');
                $allowesaudio = array('mp3');
                $filename = $businessmultiimage[0]['image_name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if (in_array($ext, $allowed)) {

                    $return_html .= '<div class="one-image">';
                    $return_html .= '<a href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '">
                <img src="' . base_url($this->config->item('bus_post_main_upload_path') . $businessmultiimage[0]['image_name']) . '"> 
            </a>
        </div>';
                } elseif (in_array($ext, $allowespdf)) {
                    $return_html .= '<div>
            <a title="click to open" href="' . base_url('business_profile/creat-pdf/' . $businessmultiimage[0]['image_id']) . '"><div class="pdf_img">
                    <img src="' . base_url('assets/images/PDF.jpg') . '" style="height: 100%; width: 100%;">
                </div>
            </a>
        </div>';
                } elseif (in_array($ext, $allowesvideo)) {
                    $return_html .= '<div>
            <video width="100%" height="350" controls>
                <source src="' . base_url($this->config->item('bus_post_main_upload_path') . $businessmultiimage[0]['image_name']) . '" type="video/mp4">
                <source src="' . base_url($this->config->item('bus_post_main_upload_path') . $businessmultiimage[0]['image_name']) . '" type="video/ogg">
                Your browser does not support the video tag.
            </video>
        </div>';
                } elseif (in_array($ext, $allowesaudio)) {
                    $return_html .= '<div class="audio_main_div">
            <div class="audio_img">
                <img src="' . base_url('assets/images/music-icon.png') . '">  
            </div>
            <div class="audio_source">
                <audio id="audio_player" width="100%" height="100" controls>
                    <source src="' . base_url($this->config->item('bus_post_main_upload_path') . $businessmultiimage[0]['image_name']) . '" type="audio/mp3">
                    <source src="movie.ogg" type="audio/ogg">
                    Your browser does not support the audio tag.
                </audio>
            </div>
            <div class="audio_mp3" id="' . "postname" . $row['business_profile_post_id'] . '">
                 <p title="' . $row['product_name'] . '">' . $row['product_name'] . '</p>
            </div>
        </div>';
                }
            } elseif (count($businessmultiimage) == 2) {

                foreach ($businessmultiimage as $multiimage) {

                    $return_html .= '<div  class="two-images">
            <a href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '">
                <img class="two-columns" src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $multiimage['image_name']) . '" style="width: 100%; height: 100%;"> 
            </a>
        </div>';
                }
            } elseif (count($businessmultiimage) == 3) {
                $return_html .= '<div class="three-image-top" >
            <a href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '">
                <img class="three-columns" src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $businessmultiimage[0]['image_name']) . '" style="width: 100%; height:100%; "> 
            </a>
        </div>
        <div class="three-image" >

            <a href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '">
                <img class="three-columns" src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $businessmultiimage[1]['image_name']) . '" style="width: 100%; height:100%; "> 
            </a>
        </div>
        <div class="three-image" >
            <a href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '">
                <img class="three-columns" src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $businessmultiimage[2]['image_name']) . '" style="width: 100%; height:100%; "> 
            </a>
        </div>';
            } elseif (count($businessmultiimage) == 4) {

                foreach ($businessmultiimage as $multiimage) {

                    $return_html .= '<div class="four-image">
            <a href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '">
                <img class="breakpoint" src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $multiimage['image_name']) . '" style="width: 100%; height: 100%;"> 
            </a>
        </div>';
                }
            } elseif (count($businessmultiimage) > 4) {

                $i = 0;
                foreach ($businessmultiimage as $multiimage) {

                    $return_html .= '<div class="four-image">
            <a href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '">
                <img src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $multiimage['image_name']) . '" style="width: 100%; height: 100%;"> 
            </a>
        </div>';

                    $i++;
                    if ($i == 3)
                        break;
                }

                $return_html .= '<div class="four-image">
            <a href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '">
                <img src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $businessmultiimage[3]['image_name']) . '" style="width: 100%; height: 100%;"> 
            </a>
            <a class="text-center" href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '" >
                <div class="more-image" >
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
<div class="post-design-like-box col-md-12">
    <div class="post-design-menu">
        <ul class="col-md-6 col-sm-6 col-xs-6">
            <li class="likepost' . $row['business_profile_post_id'] . '">
                <a id="' . $row['business_profile_post_id'] . '" class="ripple like_h_w"  onClick="post_like(this.id)">';

            $userid = $this->session->userdata('aileenuser');
            $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1');
            $active = $this->data['active'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $likeuser = $this->data['active'][0]['business_like_user'];
            $likeuserarray = explode(',', $active[0]['business_like_user']);
            if (!in_array($userid, $likeuserarray)) {

                $return_html .= '<i class="fa fa-thumbs-up" style="color: #999;" aria-hidden="true"></i>';
            } else {
                $return_html .= '<i class="fa fa-thumbs-up fa-1x main_color" aria-hidden="true"></i>';
            }
            $return_html .= '<span class="like_As_count">';

            if ($row['business_likes_count'] > 0) {
                $return_html .= $row['business_likes_count'];
            }

            $return_html .= '</span>
                </a>
            </li>
            <li id="insertcount' . $row['business_profile_post_id'] . '" style="visibility:show">';

            $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
            $commnetcount = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $return_html .= '<a onClick = "commentall(this.id)" id = "' . $row['business_profile_post_id'] . '" class = "ripple like_h_w">
                    <i class = "fa fa-comment-o" aria-hidden = "true">
                    </i>
                </a>
            </li>
        </ul>
        <ul class = "col-md-6 col-sm-6 col-xs-6 like_cmnt_count">
            <li>
                <div class = "like_count_ext">
                    <span class = "comment_count' . $row['business_profile_post_id'] . '" >';

            if (count($commnetcount) > 0) {
                $return_html .= count($commnetcount);
                $return_html .= '<span> Comment</span>';
            }
            $return_html .= '</span> 

                </div>
            </li>

            <li>
                <div class="comnt_count_ext">
                    <span class="comment_like_count' . $row['business_profile_post_id'] . '">';
            if ($row['business_likes_count'] > 0) {
                $return_html .= $row['business_likes_count'];

                $return_html .= '<span> Like</span>';
            }
            $return_html .= '</span> 

                </div></li>
        </ul>
    </div>
</div>';

            if ($row['business_likes_count'] > 0) {

                $return_html .= '<div class="likeduserlist' . $row['business_profile_post_id'] . '">';

                $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                $likeuser = $commnetcount[0]['business_like_user'];
                $countlike = $commnetcount[0]['business_likes_count'] - 1;
                $likelistarray = explode(',', $likeuser);
                foreach ($likelistarray as $key => $value) {
                    $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
                }

                $return_html .= '<a href="javascript:void(0);"  onclick="likeuserlist(' . $row['business_profile_post_id'] . ')">';
                $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $likeuser = $commnetcount[0]['business_like_user'];
                $countlike = $commnetcount[0]['business_likes_count'] - 1;
                $likelistarray = explode(',', $likeuser);

                $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
                $return_html .= '<div class="like_one_other">';

                if ($userid == $value) {
                    $return_html .= "You";
                    $return_html .= "&nbsp;";
                } else {
                    $return_html .= ucfirst(strtolower($business_fname1));
                    $return_html .= "&nbsp;";
                }

                if (count($likelistarray) > 1) {
                    $return_html .= " and";

                    $return_html .= $countlike;
                    $return_html .= "&nbsp;";
                    $return_html .= "others";
                }
                $return_html .= '</div>
    </a>
</div>';
            }

            $return_html .= '<div class="likeusername' . $row['business_profile_post_id'] . '" id="likeusername' . $row['business_profile_post_id'] . '" style="display:none">';
            $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
            $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $likeuser = $commnetcount[0]['business_like_user'];
            $countlike = $commnetcount[0]['business_likes_count'] - 1;
            $likelistarray = explode(',', $likeuser);
            foreach ($likelistarray as $key => $value) {
                $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
            }
            $return_html .= '<a href="javascript:void(0);"  onclick="likeuserlist(' . $row['business_profile_post_id'] . ')">';
            $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
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
    <div  id="fourcomment' . $row['business_profile_post_id'] . '" style="display:none;">
    </div>
    <div id="threecomment' . $row['business_profile_post_id'] . '" style="display:block">
        <div class="insertcomment' . $row['business_profile_post_id'] . '">';

            $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1');
            $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = 'business_profile_post_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');
            if ($businessprofiledata) {
                foreach ($businessprofiledata as $rowdata) {
                    $companyname = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id']))->row()->company_name;

                    $slugname1 = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id'], 'status' => 1))->row()->business_slug;

                    $return_html .= '<div class="all-comment-comment-box">
                <div class="post-design-pro-comment-img">';
                    $business_userimage = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id'], 'status' => 1))->row()->business_user_image;

                    if ($business_userimage) {
                        $return_html .= '<a href="' . base_url('business-profile/dashboard/' . $slugname1) . '">';

                        if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                            $a = $companyname;
                            $acr = substr($a, 0, 1);

                            $return_html .= '<div class="post-img-div">';
                            $return_html .= ucfirst(strtolower($acr));
                            $return_html .= '</div>';
                        } else {

                            $return_html .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) . '"  alt="">';
                        }
                        $return_html .= '</a>';
                    } else {
                        $return_html .= '<a href="' . base_url('business-profile/dashboard/' . $slugname1) . '">';
                        $a = $companyname;
                        $acr = substr($a, 0, 1);

                        $return_html .= '<div class="post-img-div">';
                        $return_html .= ucfirst(strtolower($acr));
                        $return_html .= '</div>';
                        $return_html .= '</a>';
                    }
                    $return_html .= '</div>
                <div class="comment-name">
                    <b title="' . $companyname . '">';
                    $return_html .= $companyname;
                    $return_html .= '</br>';

                    $return_html .= '</b>
                </div>
                <div class="comment-details" id="showcomment' . $rowdata['business_profile_post_comment_id'] . '">';
                    $new_product_comment = $this->common->make_links($rowdata['comments']);
                    $return_html .= nl2br(htmlspecialchars_decode(htmlentities($new_product_comment, ENT_QUOTES, 'UTF-8')));

                    $return_html .= '</div>
                <div class="edit-comment-box">
                    <div class="inputtype-edit-comment">
                        <div contenteditable="true" class="editable_text editav_2" name="' . $rowdata['business_profile_post_comment_id'] . '"  id="editcomment' . $rowdata['business_profile_post_comment_id'] . '" placeholder="Enter Your Comment " value= ""  onkeyup="commentedit(' . $rowdata['business_profile_post_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $rowdata['comments'] . '</div>
                        <span class="comment-edit-button"><button id="editsubmit' . $rowdata['business_profile_post_comment_id'] . '" style="display:none" onClick="edit_comment(' . $rowdata['business_profile_post_comment_id'] . ')">Save</button></span>
                    </div>
                </div>
                <div class="art-comment-menu-design"> 
                    <div class="comment-details-menu" id="likecomment1' . $rowdata['business_profile_post_comment_id'] . '">
                        <a id="' . $rowdata['business_profile_post_comment_id'] . '" onClick="comment_like1(this.id)">';

                    $userid = $this->session->userdata('aileenuser');
                    $contition_array = array('business_profile_post_comment_id' => $rowdata['business_profile_post_comment_id'], 'status' => '1');
                    $businesscommentlike = $this->data['businesscommentlike'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    $likeuserarray = explode(',', $businesscommentlike[0]['business_comment_like_user']);
                    if (!in_array($userid, $likeuserarray)) {

                        $return_html .= '<i class="fa fa-thumbs-up" style="color: #999;" aria-hidden="true"></i>';
                    } else {
                        $return_html .= '<i class="fa fa-thumbs-up main_color" aria-hidden="true">
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

                        $return_html .= '<span role="presentation" aria-hidden="true"> · 
                    </span>
                    <div class="comment-details-menu">
                        <div id="editcommentbox' . $rowdata['business_profile_post_comment_id'] . '" style="display:block;">
                            <a id="' . $rowdata['business_profile_post_comment_id'] . '"   onClick="comment_editbox(this.id)" class="editbox">Edit
                            </a>
                        </div>
                        <div id="editcancle' . $rowdata['business_profile_post_comment_id'] . '" style="display:none;">
                            <a id="' . $rowdata['business_profile_post_comment_id'] . '" onClick="comment_editcancle(this.id)">Cancel
                            </a>
                        </div>
                    </div>';
                    }
                    $userid = $this->session->userdata('aileenuser');
                    $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $rowdata['business_profile_post_id'], 'status' => 1))->row()->user_id;
                    if ($rowdata['user_id'] == $userid || $business_userid == $userid) {

                        $return_html .= '<span role="presentation" aria-hidden="true"> · 
                    </span>
                    <div class="comment-details-menu">
                        <input type="hidden" name="post_delete"  id="post_delete' . $rowdata['business_profile_post_comment_id'] . '" value= "' . $rowdata['business_profile_post_id'] . '">
                        <a id="' . $rowdata['business_profile_post_comment_id'] . '"   onClick="comment_delete(this.id)"> Delete
                            <span class="insertcomment' . $rowdata['business_profile_post_comment_id'] . '">
                            </span>
                        </a>
                    </div>';
                    }
                    $return_html .= '<span role="presentation" aria-hidden="true"> · 
                    </span>
                    <div class="comment-details-menu">
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
<div class="post-design-commnet-box col-md-12">
    <div class="post-design-proo-img">';

            $userid = $this->session->userdata('aileenuser');
            $business_userimage = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => 1))->row()->business_user_image;
            if ($business_userimage) {

                if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                    $a = $companyname;
                    $acr = substr($a, 0, 1);

                    $return_html .= '<div class="post-img-div">';
                    $return_html .= ucfirst(strtolower($acr));
                    $return_html .= '</div>';
                } else {
                    $return_html .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) . '"  alt="">';
                }
            } else {
                $a = $companyname;
                $acr = substr($a, 0, 1);

                $return_html .= '<div class="post-img-div">';
                $return_html .= ucfirst(strtolower($acr));
                $return_html .= '</div>';
            }
            $return_html .= '</div>

    <div id="content" class="col-md-12  inputtype-comment cmy_2" >
        <div contenteditable="true" class="edt_2 editable_text" name="' . $row['business_profile_post_id'] . '"  id="post_comment' . $row['business_profile_post_id'] . '" placeholder="Add a Comment ..." onClick="entercomment(' . $row['business_profile_post_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);"></div>
    </div>
    ' . form_error('post_comment') . ' 
    <div class="comment-edit-butn">       
        <button id="' . $row['business_profile_post_id'] . '" onClick="insert_comment(this.id)">Comment
        </button>
    </div>

</div>
</div>
</div></div>';
            echo $return_html;
        }
//    }
// return html         
    }

    public function business_profile_editpost($id) {
        $contition_array = array('business_profile_post_id' => $id);
        $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->load->view('business_profile/business_profile_editpost', $this->data);
    }

    public function business_profile_editpost_insert($id) {


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
                    'product_image' => $picture,
                    'product_description' => $this->input->post('description'),
                    'modify_date' => date('Y-m-d', time())
                );
            } else {
                $data = array(
                    'product_name' => $this->input->post('productname'),
                    'product_image' => $this->input->post('hiddenimg'),
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

//business_profile_contactperson start


    public function business_profile_contactperson($id) {

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $id, 'status' => '1', 'business_step' => 4);
        $this->data['contactperson'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->load->view('business-profile/business_profile_contactperson', $this->data);
    }

//business_profile_contactperson _query

    public function business_profile_contactperson_query($id) {
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $id, 'business_step' => 4);
        $this->data['contactperson'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $email = $this->input->post('email');
        $toemail = $this->input->post('toemail');

        $userdata = $this->common->select_data_by_id('user', 'user_id', $userid, $data = '*', $join_str = array());

        $msg = 'Hey !' . " " . $this->data['contactperson'][0]['contact_person'] . "<br/>" .
                $msg .= $userdata[0]['first_name'] . $userdata[0]['last_name'] . '(' . $userdata[0]['user_email'] . ')' . ',';
        $msg .= 'this person wants to contact with you!!';
        $msg .= "<br>";
        $msg .= $this->input->post('msg');
        $from = 'raval.khyati13@gmail.com';
        $subject = "contact message";

        $mail = $this->email_model->do_email($msg, $subject, $toemail, $from);

//insert contact start
        $data = array(
            'contact_from_id' => $userid,
            'contact_to_id' => $id,
            'contact_type' => 2,
            'created_date' => date('Y-m-d H:i:s', time()),
            'status' => 'query',
//'is_delete' => $userid,
            'contact_desc' => $this->input->post('msg')
        );


        $insertdata = $this->common->insert_data_getid($data, 'contact_person');


//insert contact person end 
//insert contact person notification start


        $data = array(
            'not_type' => 7,
            'not_from_id' => $userid,
            'not_to_id' => $id,
            'not_read' => 2,
            'not_product_id' => $insertdata,
            'not_from' => 3,
            'not_created_date' => date('Y-m-d H:i:s'),
            'not_active' => 1
        );

        $insert_id = $this->common->insert_data_getid($data, 'notification');

        if ($insertdata) {

            $this->session->set_flashdata('success', 'contacted successfully');
            redirect('business-profile/home', 'refresh');
        } else {
            $this->session->flashdata('error', 'Your data not inserted');
            redirect('business-profile/business-profile-contactperson/' . $id, refresh);
        }
//insert contact person notifiaction end   
    }

    public function business_profile_save_post() {
        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

        $contition_array = array('user_id' => $userid);
        $this->data['businessdata'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('user_id' => $userid);
        $savedata = $this->data['savedata'] = $this->common->select_data_by_condition('business_profile_save', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        foreach ($savedata as $savepost) {

            $savepostid = $savepost['post_id'];

            $contition_array = array('business_profile_post_id' => $savepostid, 'status' => '1');
            $this->data['business_post_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $businesssavepost[] = $this->data['business_post_data'];
        }

        $this->data['business_profile_data'] = $businesssavepost;
        $this->load->view('business_profile/business_profile_save_post', $this->data);
    }

    public function user_image_insert() {
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

    public function business_resume($id = "") {
        $userid = $this->session->userdata('aileenuser');
// $this->data['slug_data'] this data come from include
        if ($id == $this->data['slug_data'][0]['business_slug'] || $id == '') {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0');
            $this->data['busimagedata'] = $this->common->select_data_by_condition('bus_image', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {
            $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'is_delete' => '0');
            $this->data['busimagedata'] = $this->common->select_data_by_condition('bus_image', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }


//manage post end
        if ($this->session->userdata('aileenuser')) {
            $this->load->view('business_profile/business_resume', $this->data);
        } else {
            $this->data['business_common_profile'] = $this->load->view('business_profile/business_common_profile', $this->data, true);
            $this->load->view('business_profile/business_details', $this->data);
        }
    }

    public function business_user_post($id) {

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

        $id = $_POST['business_profile_post_id'];
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('post_id' => $id, 'user_id' => $userid, 'is_delete' => 0);
        $userdata = $this->common->select_data_by_condition('business_profile_save', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $save_id = $userdata[0]['save_id'];
        if ($userdata) {
            $contition_array = array('business_delete' => 1);
            $jobdata = $this->common->select_data_by_condition('business_profile_save', $contition_array, $data = 'save_id', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $data = array(
                'business_delete' => 0,
                'business_save' => 1
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
                'is_delete' => 0,
                'business_save' => 1,
                'business_delete' => 0
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

        $id = $_POST['save_id'];
        $userid = $this->session->userdata('aileenuser');

        $data = array(
            'business_save' => 0,
            'business_delete' => 1,
            'modify_date' => date('Y-m-d h:i:s', time())
        );
        $updatedata = $this->common->update_data($data, 'business_profile_save', 'save_id', $id);
    }

//Business Profile Remove Save Post Start
//location automatic retrieve controller start
    public function location() {
        $json = [];

        $this->load->database('aileensoul');



        if (!empty($this->input->get("q"))) {
            $search_condition = "(city_name LIKE '" . trim($this->input->get("q")) . "%')";

            $tolist = $this->common->select_data_by_search('cities', $search_condition, $contition_array = array(), $data = 'city_id as id,city_name as text', $sortby = 'city_name', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = '');

//echo '<pre>'; print_r($tolist); die();
        }
//  echo json_encode($tolist);
        echo json_encode($tolist);
    }

//location automatic retrieve controller End
// user list of artistic users

    public function userlist() {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        $artdata = $this->data['artdata'] = $this->common->select_data_by_id('business_profile', 'user_id', $userid, $data = '*');
        $contition_array = array('user_id' => $userid);
        $this->data['artisticdata'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('business_step' => 4, 'is_deleted' => 0, 'status' => 1, 'user_id !=' => $userid);
        $this->data['userlist'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('user_id' => $userid, 'is_deleted' => 0, 'status' => 1);
        $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
// followers count
        $join_str[0]['table'] = 'follow';
        $join_str[0]['join_table_id'] = 'follow.follow_to';
        $join_str[0]['from_table_id'] = 'business_profile.business_profile_id';
        $join_str[0]['join_type'] = '';
        $contition_array = array('follow_to' => $artdata[0]['business_profile_id'], 'follow_status' => 1, 'follow_type' => 1);
        $this->data['followers'] = count($this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = ''));

// follow count end
// fllowing count
        $join_str[0]['table'] = 'follow';
        $join_str[0]['join_table_id'] = 'follow.follow_from';
        $join_str[0]['from_table_id'] = 'business_profile.business_profile_id';
        $join_str[0]['join_type'] = '';

        $contition_array = array('follow_from' => $artdata[0]['business_profile_id'], 'follow_status' => 1, 'follow_type' => 1, 'business_profile.business_step' => 4);
        $this->data['following'] = count($this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = ''));

//following end

        $this->load->view('business_profile/business_userlist', $this->data);
    }

    public function follow() {
        $userid = $this->session->userdata('aileenuser');

//if user deactive profile then redirect to business_profile/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_deleted' => '0');

        $business_deactive = $this->data['business_deactive'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($business_deactive) {
            redirect('business_profile/');
        }
//if user deactive profile then redirect to business_profile/index untill active profile End

        $business_id = $_POST["follow_to"];

        $contition_array = array('user_id' => $userid, 'is_deleted' => 0, 'status' => 1);

        $artdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        $contition_array = array('business_profile_id' => $business_id, 'is_deleted' => 0, 'status' => 1, 'business_step' => 4);

        $busdatatoid = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        $contition_array = array('follow_type' => 2, 'follow_from' => $artdata[0]['business_profile_id'], 'follow_to' => $business_id);
        $follow = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        if ($follow) {
            $data = array(
                'follow_type' => 2,
                'follow_from' => $artdata[0]['business_profile_id'],
                'follow_to' => $business_id,
                'follow_status' => 1,
            );
            $update = $this->common->update_data($data, 'follow', 'follow_id', $follow[0]['follow_id']);

// insert notification



            $contition_array = array('not_type' => 8, 'not_from_id' => $userid, 'not_to_id' => $busdatatoid[0]['user_id'], 'not_product_id' => $follow[0]['follow_id'], 'not_from' => 6);
            $busnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
//echo "<pre>"; print_r($busnotification); die();
            if ($busnotification[0]['not_read'] == 2) { //echo "hi"; die();
            } elseif ($busnotification[0]['not_read'] == 1) { //echo "hddi"; die();
                $datafollow = array(
                    'not_read' => 2
                );

                $where = array('not_type' => 8, 'not_from_id' => $userid, 'not_to_id' => $busdatatoid[0]['user_id'], 'not_product_id' => $follow[0]['follow_id'], 'not_from' => 6);
                $this->db->where($where);
                $updatdata = $this->db->update('notification', $datafollow);
            } else {
                $data = array(
                    'follow_type' => 2,
                    'follow_from' => $artdata[0]['business_profile_id'],
                    'follow_to' => $business_id,
                    'follow_status' => 1,
                );
                $insertdata = $this->common->insert_data($data, 'follow');

                $contition_array = array('follow_type' => 2, 'follow_from' => $artdata[0]['business_profile_id'], 'follow_status' => 1, 'follow_to' => $business_id);
                $follow_id = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
// insert notification

                $data = array(
                    'not_type' => 8,
                    'not_from_id' => $userid,
                    'not_to_id' => $busdatatoid[0]['user_id'],
                    'not_read' => 2,
                    'not_product_id' => $follow_id[0]['follow_id'],
                    'not_from' => 6,
                    'not_created_date' => date('Y-m-d H:i:s'),
                    'not_active' => 1
                );
                $insert_id = $this->common->insert_data_getid($data, 'notification');
            }


// $data = array(
//     'not_type' => 8,
//     'not_from_id' => $userid,
//     'not_to_id' => $busdatatoid[0]['user_id'],
//     'not_read' => 2,
//     'not_product_id' => $follow[0]['follow_id'],
//     'not_from' => 6,
//     'not_created_date' => date('Y-m-d H:i:s'),
//     'not_active' => 1
// );
// $insert_id = $this->common->insert_data_getid($data, 'notification');
// end notoification

            $contition_array = array('follow_type' => 2, 'follow_from' => $artdata[0]['business_profile_id'], 'follow_status' => 1);
            $followcount = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($update) {

                $follow = '<div id="unfollowdiv" class="user_btn">';
                $follow .= '<button class= "bg_following" id="unfollow' . $business_id . '" onClick="unfollowuser(' . $business_id . ')">
                              Following
                      </button>';
                $follow .= '</div>';

                $datacount = '(' . count($followcount) . ')';

                echo json_encode(
                        array(
                            "follow" => $follow,
                            "count" => $datacount,
                ));
            }
        } else {   //echo "hii"; die();
            $data = array(
                'follow_type' => 2,
                'follow_from' => $artdata[0]['business_profile_id'],
                'follow_to' => $business_id,
                'follow_status' => 1,
            );
            $insertdata = $this->common->insert_data($data, 'follow');


            $contition_array = array('follow_type' => 2, 'follow_from' => $artdata[0]['business_profile_id'], 'follow_status' => 1, 'follow_to' => $business_id);
            $follow_id = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
// insert notification

            $data = array(
                'not_type' => 8,
                'not_from_id' => $userid,
                'not_to_id' => $busdatatoid[0]['user_id'],
                'not_read' => 2,
                'not_product_id' => $follow_id[0]['follow_id'],
                'not_from' => 6,
                'not_created_date' => date('Y-m-d H:i:s'),
                'not_active' => 1
            );

            $insert_id = $this->common->insert_data_getid($data, 'notification');
            $contition_array = array('follow_type' => 2, 'follow_from' => $artdata[0]['business_profile_id'], 'follow_status' => 1);
            $followcount = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// end notoification
            if ($insertdata) {
                $follow = '<div id="unfollowdiv" class="user_btn">';
                $follow .= '<button class="bg_following" id="unfollow' . $business_id . '" onClick="unfollowuser(' . $business_id . ')">
                               Following
                      </button>';
                $follow .= '</div>';

                $datacount = '(' . count($followcount) . ')';

                echo json_encode(
                        array(
                            "follow" => $follow,
                            "count" => $datacount,
                ));
            }
        }
    }

    public function unfollow() {
        $userid = $this->session->userdata('aileenuser');

//if user deactive profile then redirect to business_profile/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_deleted' => '0');

        $business_deactive = $this->data['business_deactive'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($business_deactive) {
            redirect('business_profile/');
        }
//if user deactive profile then redirect to business_profile/index untill active profile End

        $business_id = $_POST["follow_to"];

        $contition_array = array('user_id' => $userid, 'is_deleted' => 0, 'status' => 1);

        $artdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('follow_type' => 2, 'follow_from' => $artdata[0]['business_profile_id'], 'follow_to' => $business_id);

        $follow = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        if ($follow) {
            $data = array(
                'follow_type' => 2,
                'follow_from' => $artdata[0]['business_profile_id'],
                'follow_to' => $business_id,
                'follow_status' => 0,
            );
            $update = $this->common->update_data($data, 'follow', 'follow_id', $follow[0]['follow_id']);


            $contition_array = array('follow_type' => 2, 'follow_from' => $artdata[0]['business_profile_id'], 'follow_status' => 1);

            $followcount = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($update) {

                $unfollow = '<div id="followdiv " class="user_btn">';
//    $unfollow .= '<button style="margin-top: 7px;" id="follow' . $business_id . '" onClick="followuser(' . $business_id . ')">
                $unfollow .= '<button id="follow' . $business_id . '" onClick="followuser(' . $business_id . ')">
                               Follow 
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

    public function follow_two() {
        $userid = $this->session->userdata('aileenuser');

//if user deactive profile then redirect to business_profile/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_deleted' => '0');

        $business_deactive = $this->data['business_deactive'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($business_deactive) {
            redirect('business_profile/');
        }
//if user deactive profile then redirect to business_profile/index untill active profile End

        $business_id = $_POST["follow_to"];

        $contition_array = array('user_id' => $userid, 'is_deleted' => 0, 'status' => 1);

        $artdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('business_profile_id' => $business_id, 'is_deleted' => 0, 'status' => 1, 'business_step' => 4);

        $busdatatoid = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('follow_type' => 2, 'follow_from' => $artdata[0]['business_profile_id'], 'follow_to' => $business_id);
        $follow = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        if ($follow) {
            $data = array(
                'follow_type' => 2,
                'follow_from' => $artdata[0]['business_profile_id'],
                'follow_to' => $business_id,
                'follow_status' => 1,
            );
            $update = $this->common->update_data($data, 'follow', 'follow_id', $follow[0]['follow_id']);

// insert notification


            $contition_array = array('not_type' => 8, 'not_from_id' => $userid, 'not_to_id' => $busdatatoid[0]['user_id'], 'not_product_id' => $follow[0]['follow_id'], 'not_from' => 6);
            $busnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
//echo "<pre>"; print_r($busnotification); die();
            if ($busnotification[0]['not_read'] == 2) { //echo "hi"; die();
            } elseif ($busnotification[0]['not_read'] == 1) { //echo "hddi"; die();
                $datafollow = array(
                    'not_read' => 2
                );

                $where = array('not_type' => 8, 'not_from_id' => $userid, 'not_to_id' => $busdatatoid[0]['user_id'], 'not_product_id' => $follow[0]['follow_id'], 'not_from' => 6);
                $this->db->where($where);
                $updatdata = $this->db->update('notification', $datafollow);
            } else {


                $data = array(
                    'not_type' => 8,
                    'not_from_id' => $userid,
                    'not_to_id' => $busdatatoid[0]['user_id'],
                    'not_read' => 2,
                    'not_product_id' => $follow[0]['follow_id'],
                    'not_from' => 6,
                    'not_created_date' => date('Y-m-d H:i:s'),
                    'not_active' => 1
                );

                $insert_id = $this->common->insert_data_getid($data, 'notification');
            }
// end notoification

            if ($update) {

                $follow = '<div class="user_btn follow_btn_' . $business_id . '" id="unfollowdiv">';
                $follow .= '<button class="bg_following" id="unfollow' . $business_id . '" onClick="unfollowuser_two(' . $business_id . ')">
                              Following
                      </button>';
                $follow .= '</div>';
                echo $follow;
            }
        } else {
            $data = array(
                'follow_type' => 2,
                'follow_from' => $artdata[0]['business_profile_id'],
                'follow_to' => $business_id,
                'follow_status' => 1,
            );
            $insert = $this->common->insert_data($data, 'follow');

// insert notification
            $contition_array = array('follow_type' => 2, 'follow_from' => $artdata[0]['business_profile_id'], 'follow_status' => 1, 'follow_to' => $business_id);
            $follow_id = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            $datanoti = array(
                'not_type' => 8,
                'not_from_id' => $userid,
                'not_to_id' => $busdatatoid[0]['user_id'],
                'not_read' => 2,
                'not_product_id' => $follow_id[0]['follow_id'],
                'not_from' => 6,
                'not_created_date' => date('Y-m-d H:i:s'),
                'not_active' => 1
            );

            $insert_id = $this->common->insert_data_getid($datanoti, 'notification');
// end notoification
            if ($insert) {
                $follow = '<div class="user_btn follow_btn_' . $business_id . '" id="unfollowdiv">';
// $follow = '<button id="unfollow' . $business_id . '" onClick="unfollowuser(' . $business_id . ')">
//                Following
//       </button>';
                $follow .= '<button class="bg_following" id="unfollow' . $business_id . '" onClick="unfollowuser_two(' . $business_id . ')"><span>Following</span></button>';
                $follow .= '</div>';
                echo $follow;
            }
        }
    }

    public function unfollow_two() {
        $userid = $this->session->userdata('aileenuser');
//if user deactive profile then redirect to business_profile/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_deleted' => '0');

        $business_deactive = $this->data['business_deactive'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($business_deactive) {
            redirect('business_profile/');
        }
//if user deactive profile then redirect to business_profile/index untill active profile End

        $business_id = $_POST["follow_to"];

        $contition_array = array('user_id' => $userid, 'is_deleted' => 0, 'status' => 1);

        $artdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('follow_type' => 2, 'follow_from' => $artdata[0]['business_profile_id'], 'follow_to' => $business_id);

        $follow = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        if ($follow) {
            $data = array(
                'follow_type' => 2,
                'follow_from' => $artdata[0]['business_profile_id'],
                'follow_to' => $business_id,
                'follow_status' => 0,
            );
            $update = $this->common->update_data($data, 'follow', 'follow_id', $follow[0]['follow_id']);
            if ($update) {

                $unfollow = '<div class="user_btn follow_btn_' . $business_id . '" id="followdiv">';
// $follow = '<button id="unfollow' . $business_id . '" onClick="unfollowuser(' . $business_id . ')">
//                Following
//       </button>';
                $unfollow .= '<button class="follow' . $business_id . '" onClick="followuser_two(' . $business_id . ')">Follow</button>';
                $unfollow .= '</div>';
                echo $unfollow;
            }
        }
    }

    public function unfollow_following() {
        $userid = $this->session->userdata('aileenuser');

        $business_id = $_POST["follow_to"];
        $contition_array = array('user_id' => $userid, 'is_deleted' => 0, 'status' => 1);
        $artdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('follow_type' => 2, 'follow_from' => $artdata[0]['business_profile_id'], 'follow_to' => $business_id);
        $follow = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($follow) {
            $data = array(
                'follow_type' => 2,
                'follow_from' => $artdata[0]['business_profile_id'],
                'follow_to' => $business_id,
                'follow_status' => 0,
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

                                        <img src="' . base_url('assets/img/bui-no.png') . '">

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
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'is_deleted' => 0, 'status' => 1);
        $artdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $slugid = $artdata[0]['business_slug'];

        if ($id == $slug_id || $id == '') {

            $contition_array = array('user_id' => $userid, 'is_deleted' => 0, 'status' => 1);
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $join_str[0]['table'] = 'follow';
            $join_str[0]['join_table_id'] = 'follow.follow_to';
            $join_str[0]['from_table_id'] = 'business_profile.business_profile_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('follow_to' => $businessdata1[0]['business_profile_id'], 'follow_status' => 1, 'follow_type' => 2, 'business_profile.business_step' => 4);

            $this->data['userlist'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        } else {

            $contition_array = array('business_slug' => $id, 'is_deleted' => 0, 'status' => 1, 'business_step' => 4);

            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $join_str[0]['table'] = 'follow';
            $join_str[0]['join_table_id'] = 'follow.follow_to';
            $join_str[0]['from_table_id'] = 'business_profile.business_profile_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('follow_to' => $businessdata1[0]['business_profile_id'], 'follow_status' => 1, 'follow_type' => 2, 'business_profile.business_step' => 4);

            $this->data['userlist'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        }

        $this->load->view('business_profile/business_followers', $this->data);
    }

    public function following($id = "") {
        $this->data['slug_id'] = $id;
        $this->load->view('business_profile/business_following', $this->data);
    }

    public function ajax_following($id = "") {
        $userid = $this->session->userdata('aileenuser');
        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;


        $contition_array = array('user_id' => $userid, 'is_deleted' => 0, 'status' => 1);
        $artdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $slugid = $artdata[0]['business_slug'];
        if ($id == $slug_id || $id == '') {

            $contition_array = array('user_id' => $userid);
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $join_str[0]['table'] = 'follow';
            $join_str[0]['join_table_id'] = 'follow.follow_from';
            $join_str[0]['from_table_id'] = 'business_profile.business_profile_id';
            $join_str[0]['join_type'] = '';

            $limit = $perpage;
            $offset = $start;

            $contition_array = array('follow_from' => $businessdata1[0]['business_profile_id'], 'follow_status' => 1, 'follow_type' => 2, 'business_profile.business_step' => 4);
            $userlist = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit, $offset, $join_str, $groupby = '');
            $userlist1 = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        } else {
            $contition_array = array('business_slug' => $id, 'business_step' => 4);
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $join_str[0]['table'] = 'follow';
            $join_str[0]['join_table_id'] = 'follow.follow_from';
            $join_str[0]['from_table_id'] = 'business_profile.business_profile_id';
            $join_str[0]['join_type'] = '';

            $limit = $perpage;
            $offset = $start;

            $contition_array = array('follow_from' => $businessdata1[0]['business_profile_id'], 'follow_status' => 1, 'follow_type' => 2, 'business_profile.business_step' => 4);
            $userlist = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit, $offset, $join_str, $groupby = '');
            $userlist1 = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        }
        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($userlist);
        }
        $return_html = '';
        $return_html .= '<input type="hidden" class="page_number" value="' . $page . '" />';
        $return_html .= '<input type="hidden" class="total_record" value="' . $_GET["total_record"] . '" />';
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
                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $uimage)) {
                        $a = $companyname;
                        $acr = substr($a, 0, 1);
                        $return_html .= '<div class="post-img-userlist">';
                        $return_html .= ucfirst(strtolower($acr));
                        $return_html .= '</div>';
                    } else {
                        $return_html .= '<img src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $this->db->get_where('business_profile', array('business_profile_id' => $user['follow_to']))->row()->business_user_image) . '" height="50px" width="50px" alt="" >';
                    }
                    $return_html .= '</a>';
                } else {
                    $return_html .= '<a href="' . base_url('business-profile/dashboard/' . $slug) . '" title="' . $companyname . '">';
                    $a = $companyname;
                    $acr = substr($a, 0, 1);
                    $return_html .= '<div class="post-img-userlist">';
                    $return_html .= ucfirst(strtolower($acr));
                    $return_html .= '</div>';
                }
                $return_html .= '</div>
                </li>
                <li class="folle_text">
                    <div class="">
                        <div class="follow-li-text" style="padding: 0;">
                            <a title="' . $companyname . '" href="' . base_url('business-profile/dashboard/' . $slug) . '">' . $this->db->get_where('business_profile', array('business_profile_id' => $user['follow_to']))->row()->company_name . '</a></div>
                        <div>';

                $categoryid = $this->db->get_where('business_profile', array('business_profile_id' => $user['follow_to'], 'status' => 1))->row()->industriyal;
                $category = $this->db->get_where('industry_type', array('industry_id' => $categoryid, 'status' => 1))->row()->industry_name;
                $othercategory = $this->db->get_where('business_profile', array('business_profile_id' => $user['follow_to'], 'status' => 1))->row()->other_industrial;

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

                    $contition_array = array('follow_from' => $businessdata1[0]['business_profile_id'], 'follow_status' => 1, 'follow_type' => 2, 'follow_to' => $user['follow_to']);
                    $status = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    if ($status[0]['follow_status'] == 1) {
                        $return_html .= '<div class="user_btn" id= "unfollowdiv">
                                <button class="bg_following" id="unfollow"' . $user['follow_to'] . '" onClick="unfollowuser_list(' . $user['follow_to'] . ')"><span>Following</span></button>
                            </div>';
                    }
                    $return_html .= '</li>';
                } else {
                    $return_html .= '<li class="fr">';

                    $contition_array = array('user_id' => $userid, 'status' => '1');
                    $busdatauser = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    $contition_array = array('follow_from' => $busdatauser[0]['business_profile_id'], 'follow_status' => 1, 'follow_type' => 2, 'follow_to' => $user['follow_to']);
                    $status_list = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    if (($status_list[0]['follow_status'] == 0 || $status_list[0]['follow_status'] == ' ' ) && $user['follow_to'] != $busdatauser[0]['business_profile_id']) {
                        $return_html .= '<div class="user_btn follow_btn_' . $user['follow_to'] . '" id= "followdiv">
                                <button id="<?php echo "follow"' . $user['follow_to'] . '" onClick="followuser_two(' . $user['follow_to'] . ')">Follow</button>
                            </div>';
                    } else if ($user['follow_to'] == $busdatauser[0]['business_profile_id']) {
                        
                    } else {
                        $return_html .= '<div class="user_btn_f follow_btn_' . $user['follow_to'] . '" id= "unfollowdiv">
                                <button id="unfollow"' . $user['follow_to'] . '" onClick="unfollowuser_two(' . $user['follow_to'] . ')"><span>Following</span></button>
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

            $return_html .= '<div class="art-img-nn">
                <div class="art_no_post_img">
                    <img src="' . base_url('assets/img/bui-no.png') . '">
                </div>
                <div class="art_no_post_text">
                    No Following Available.
                </div>
            </div>';
        }
        $return_html .= '<div class="col-md-1">
</div>';

        echo $return_html;
    }

// end of user list
//deactivate user start
    public function deactivate() {

        $id = $_POST['id'];

        $data = array(
            'status' => 0
        );

        $update = $this->common->update_data($data, 'business_profile', 'user_id', $id);
    }

// deactivate user end

    public function image_upload_ajax() {

        session_start();
        $session_uid = $this->session->userdata('aileenuser');
        include_once 'getExtension.php';

        $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
        if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST" && isset($session_uid)) {
            $name = $_FILES['photoimg']['name'];
            $size = $_FILES['photoimg']['size'];

            if ($name) {
                $ext = $this->common->getExtension($name);
                if (in_array($ext, $valid_formats)) {
                    if ($size < (1024 * 1024)) {
                        $actual_image_name = time() . $session_uid . "." . $ext;
                        $tmp = $_FILES['photoimg']['tmp_name'];
                        $bgSave = '<div id="uX' . $session_uid . '" class="bgSave wallbutton blackButton">Save Cover</div>';
                        $config['upload_path'] = 'uploads/user_image/';
                        $config['allowed_types'] = 'jpg|jpeg|png|gif|mp4|3gp|mpeg|mpg|mpe|qt|mov|avi|pdf';

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
                            echo $bgSave . '<img src="' . $path . $picture . '"  id="timelineBGload" class="headerimage ui-corner-all" style="top:0px"/>';
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

        $this->db->select('business_profile_id,company_name');
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

        $contition_array = array('business_profile_post_id' => $id, 'status' => '1');
        $this->data['businessdata'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $this->load->view('business_profile/business_pdfdispaly', $this->data);
    }

    public function creat_pdf($id) {

        $contition_array = array('image_id' => $id, 'is_deleted' => '1');
        $this->data['busdata'] = $this->common->select_data_by_condition('post_files', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
//echo "<pre>"; print_r($this->data['artdata']); die();
        $this->load->view('business_profile/business_pdfdispaly', $this->data);
    }

//create pdf end
// cover pic controller

    public function ajaxpro() {
        $userid = $this->session->userdata('aileenuser');

// REMOVE OLD IMAGE FROM FOLDER
        $contition_array = array('user_id' => $userid);
        $user_reg_data = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'profile_background,profile_background_main', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

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

// REMOVE OLD IMAGE FROM FOLDER
        $data = $_POST['image'];
        $user_bg_path = $this->config->item('bus_bg_main_upload_path');
        $imageName = time() . '.png';
        $base64string = $data;
        file_put_contents($user_bg_path . $imageName, base64_decode(explode(',', $base64string)[1]));

        $user_thumb_path = $this->config->item('bus_bg_thumb_upload_path');
        $user_thumb_width = $this->config->item('bus_bg_thumb_width');
        $user_thumb_height = $this->config->item('bus_bg_thumb_height');

        $upload_image = $user_bg_path . $imageName;
        $thumb_image_uplode = $this->thumb_img_uplode($upload_image, $imageName, $user_thumb_path, $user_thumb_width, $user_thumb_height);

        $data = array(
            'profile_background' => $imageName
        );

        $update = $this->common->update_data($data, 'business_profile', 'user_id', $userid);
        $this->data['busdata'] = $this->common->select_data_by_id('business_profile', 'user_id', $userid, $data = '*', $join_str = array());

        echo '<img src="' . $this->data['busdata'][0]['profile_background'] . '" />';
    }

    public function imagedata() {
        $userid = $this->session->userdata('aileenuser');

        $config['upload_path'] = $this->config->item('bus_bg_original_upload_path');
        $config['allowed_types'] = 'jpg|jpeg|png|gif';

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
            'modified_date' => date('Y-m-d h:i:s', time())
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

        $userid = $this->session->userdata('aileenuser');

        $post_id = $_POST["post_id"];
        $contition_array = array('business_profile_post_comment_id' => $_POST["post_id"], 'status' => '1');
        $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $business_comment_likes_count = $businessprofiledata[0]['business_comment_likes_count'];
        $likeuserarray = explode(',', $businessprofiledata[0]['business_comment_like_user']);

        if (!in_array($userid, $likeuserarray)) { //echo "falguni"; die();
            $user_array = array_push($likeuserarray, $userid);

            if ($businessprofiledata[0]['business_comment_likes_count'] == 0) {
                $userid = implode('', $likeuserarray);
            } else {
                $userid = implode(',', $likeuserarray);
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

                $contition_array = array('not_type' => 5, 'not_from_id' => $userid, 'not_to_id' => $businessprofiledata[0]['user_id'], 'not_product_id' => $post_id, 'not_from' => 6, 'not_img' => 3);
                $busnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if ($busnotification[0]['not_read'] == 2) {
                    
                } elseif ($busnotification[0]['not_read'] == 1) {

                    $datalike = array(
                        'not_read' => 2
                    );

                    $where = array('not_type' => 5, 'not_from_id' => $userid, 'not_to_id' => $businessprofiledata[0]['user_id'], 'not_product_id' => $post_id, 'not_from' => 6, 'not_img' => 3);
                    $this->db->where($where);
                    $updatdata = $this->db->update('notification', $datalike);
                } else {

                    $datacmlike = array(
                        'not_type' => 5,
                        'not_from_id' => $userid,
                        'not_to_id' => $businessprofiledata[0]['user_id'],
                        'not_read' => 2,
                        'not_product_id' => $post_id,
                        'not_from' => 6,
                        'not_img' => 3,
                        'not_created_date' => date('Y-m-d H:i:s'),
                        'not_active' => 1
                    );


                    $insert_id = $this->common->insert_data_getid($datacmlike, 'notification');
                }
            }
// end notoification


            $contition_array = array('business_profile_post_comment_id' => $_POST["post_id"], 'status' => '1');
            $businessprofiledata1 = $this->data['businessprofiledata1'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($updatdata) {


                $cmtlike1 = '<a id="' . $businessprofiledata1[0]['business_profile_post_comment_id'] . '" onClick="comment_like(this.id)">';
                $cmtlike1 .= ' <i class="fa fa-thumbs-up" aria-hidden="true">';
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
                'business_comment_like_user' => implode(',', $likeuserarray),
                'modify_date' => date('y-m-d h:i:s')
            );


            $updatdata = $this->common->update_data($data, 'business_profile_post_comment', 'business_profile_post_comment_id', $post_id);
            $contition_array = array('business_profile_post_comment_id' => $_POST["post_id"], 'status' => '1');
            $businessprofiledata2 = $this->data['businessprofiledata2'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($updatdata) {

                $cmtlike1 = '<a id="' . $businessprofiledata2[0]['business_profile_post_comment_id'] . '" onClick="comment_like(this.id)">';
                $cmtlike1 .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true">';
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
                $userid = implode(',', $likeuserarray);
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

                $contition_array = array('not_type' => 5, 'not_from_id' => $userid, 'not_to_id' => $businessprofiledata[0]['user_id'], 'not_product_id' => $post_id, 'not_from' => 6, 'not_img' => 3);
                $busnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if ($busnotification[0]['not_read'] == 2) {
                    
                } elseif ($busnotification[0]['not_read'] == 1) {

                    $datalike = array(
                        'not_read' => 2
                    );

                    $where = array('not_type' => 5, 'not_from_id' => $userid, 'not_to_id' => $businessprofiledata[0]['user_id'], 'not_product_id' => $post_id, 'not_from' => 6, 'not_img' => 3);
                    $this->db->where($where);
                    $updatdata = $this->db->update('notification', $datalike);
                } else {

                    $data = array(
                        'not_type' => 5,
                        'not_from_id' => $userid,
                        'not_to_id' => $businessprofiledata[0]['user_id'],
                        'not_read' => 2,
                        'not_product_id' => $post_id,
                        'not_from' => 6,
                        'not_img' => 3,
                        'not_created_date' => date('Y-m-d H:i:s'),
                        'not_active' => 1
                    );

                    $insert_id = $this->common->insert_data_getid($data, 'notification');
                }
            }
// end notoification
            $contition_array = array('business_profile_post_comment_id' => $_POST["post_id"], 'status' => '1');
            $businessprofiledata1 = $this->data['businessprofiledata1'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($updatdata) {
                $cmtlike1 = '<a id="' . $businessprofiledata1[0]['business_profile_post_comment_id'] . '" onClick="comment_like1(this.id)">';
                $cmtlike1 .= '<i class="fa fa-thumbs-up fa-1x main_color" aria-hidden="true">';
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
                'business_comment_like_user' => implode(',', $likeuserarray),
                'modify_date' => date('y-m-d h:i:s')
            );


            $updatdata = $this->common->update_data($data, 'business_profile_post_comment', 'business_profile_post_comment_id', $post_id);
            $contition_array = array('business_profile_post_comment_id' => $_POST["post_id"], 'status' => '1');
            $businessprofiledata2 = $this->data['businessprofiledata2'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($updatdata) {

                $cmtlike1 = '<a id="' . $businessprofiledata2[0]['business_profile_post_comment_id'] . '" onClick="comment_like1(this.id)">';
                $cmtlike1 .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true">';
                $cmtlike1 .= '</i>';

// $cmtlike1 .= '<i class="fa fa-thumbs-up fa-1x main_color" aria-hidden="true">';
// $cmtlike1 .= '</i>';
                $cmtlike1 .= '<span> ';
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

// Business_profile comment like end 
//Business_profile comment delete start
    public function delete_comment() {
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

                $business_userimage = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id'], 'status' => 1))->row()->business_user_image;

                $cmtinsert .= '<div class="all-comment-comment-box">';
                $cmtinsert .= '<div class="post-design-pro-comment-img">';

                if ($business_userimage != '') {

                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                        $a = $companyname;
                        $acr = substr($a, 0, 1);

                        $cmtinsert .= '<div class="post-img-div">';
                        $cmtinsert .= ucfirst(strtolower($acr));
                        $cmtinsert .= '</div>';
                    } else {

                        $cmtinsert .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) . '" alt="">';
                    }

                    $cmtinsert .= '</div>';
                } else {
                    $a = $companyname;
                    $acr = substr($a, 0, 1);

                    $cmtinsert .= '<div class="post-img-div">';
                    $cmtinsert .= ucfirst(strtolower($acr));
                    $cmtinsert .= '</div>';

                    $cmtinsert .= '</div>';
                }
                $cmtinsert .= '<div class="comment-name"><b>' . $companyname . '</b>';
                $cmtinsert .= '</div>';
                $cmtinsert .= '<div class="comment-details" id= "showcomment' . $business_profile['business_profile_post_comment_id'] . '"" >';
                $cmtinsert .= $this->common->make_links($business_profile['comments']);
                $cmtinsert .= '</div>';
                $cmtinsert .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';
//$cmtinsert .= '<textarea type="text" class="textarea" name="' . $business_profile['business_profile_post_comment_id'] . '" id="editcomment' . $business_profile['business_profile_post_comment_id'] . '" style="display:none;resize: none;" onClick="commentedit(this.name)">' . $business_profile['comments'] . '</textarea>';
                $cmtinsert .= '<div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="' . $business_profile['business_profile_post_comment_id'] . '"  id="editcomment' . $business_profile['business_profile_post_comment_id'] . '" placeholder="Type Message ..." onkeyup="commentedit(' . $business_profile['business_profile_post_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $business_profile['comments'] . '</div>';
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

                $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $business_profile['business_profile_post_id'], 'status' => 1))->row()->user_id;


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
        $userid = $this->session->userdata('aileenuser');

        $post_id = $_POST["post_id"];
        $post_delete = $_POST["post_delete"];

        $data = array(
            'status' => 0,
        );
        $updatdata = $this->common->update_data($data, 'business_profile_post_comment', 'business_profile_post_comment_id', $post_id);


        $contition_array = array('business_profile_post_id' => $post_delete, 'status' => '1');
        $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = 'business_profile_post_comment_id', $orderby = 'ASCdelete_commenttwo', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if (count($businessprofiledata) > 0) {
            foreach ($businessprofiledata as $business_profile) {

                $companyname = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id']))->row()->company_name;

                $business_userimage = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id'], 'status' => 1))->row()->business_user_image;

                $cmtinsert .= '<div class="all-comment-comment-box">';
                $cmtinsert .= '<div class="post-design-pro-comment-img">';
                if ($business_userimage != '') {

                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                        $a = $companyname;
                        $acr = substr($a, 0, 1);

                        $cmtinsert .= '<div class="post-img-div">';
                        $cmtinsert .= ucfirst(strtolower($acr));
                        $cmtinsert .= '</div>';
                    } else {
                        $cmtinsert .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) . '" alt="">';
                    }

                    $cmtinsert .= '</div>';
                } else {
                    $a = $companyname;
                    $acr = substr($a, 0, 1);

                    $cmtinsert .= '<div class="post-img-div">';
                    $cmtinsert .= ucfirst(strtolower($acr));
                    $cmtinsert .= '</div>';

                    $cmtinsert .= '</div>';
                }
                $cmtinsert .= '<div class="comment-name"><b>' . $companyname . '</b>';
                $cmtinsert .= '</div>';
                $cmtinsert .= '<div class="comment-details" id="showcommenttwo' . $business_profile['business_profile_post_comment_id'] . '">';
                $cmtinsert .= $this->common->make_links($business_profile['comments']);
                $cmtinsert .= '</div>';
                $cmtinsert .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';
                $cmtinsert .= '<div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="' . $business_profile['business_profile_post_comment_id'] . '"  id="editcommenttwo' . $business_profile['business_profile_post_comment_id'] . '" placeholder="Type Message ..." onkeyup="commentedittwo(' . $business_profile['business_profile_post_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $business_profile['comments'] . '</div>';
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
                $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $business_profile['business_profile_post_id'], 'status' => 1))->row()->user_id;

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
                'modify_date' => date('y-m-d h:i:s')
            );
            $updatdata = $this->common->update_data($data, 'business_profile_post', 'business_profile_post_id', $post_id);
// insert notification
            if ($businessprofiledata[0]['user_id'] == $userid || $businessprofiledata[0]['is_delete'] == '1') {
                
            } else {

                $contition_array = array('not_type' => 5, 'not_from_id' => $userid, 'not_to_id' => $businessprofiledata[0]['user_id'], 'not_product_id' => $post_id, 'not_from' => 6, 'not_img' => 2);
                $busnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if ($busnotification[0]['not_read'] == 2) {
                    
                } elseif ($busnotification[0]['not_read'] == 1) {

                    $datalike = array(
                        'not_read' => 2
                    );

                    $where = array('not_type' => 5, 'not_from_id' => $userid, 'not_to_id' => $businessprofiledata[0]['user_id'], 'not_product_id' => $post_id, 'not_from' => 6, 'not_img' => 2);
                    $this->db->where($where);
                    $updatdata = $this->db->update('notification', $datalike);
                } else {

                    $datalike = array(
                        'not_type' => 5,
                        'not_from_id' => $userid,
                        'not_to_id' => $businessprofiledata[0]['user_id'],
                        'not_read' => 2,
                        'not_product_id' => $post_id,
                        'not_from' => 6,
                        'not_img' => 2,
                        'not_created_date' => date('Y-m-d H:i:s'),
                        'not_active' => 1
                    );
                    $insert_id = $this->common->insert_data_getid($datalike, 'notification');
                }
            }
// end notoification

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
                    $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
                }

                $cmtlikeuser .= '<div class="like_one_other">';
                $cmtlikeuser .= ' <a href="javascript:void(0);"  onclick="likeuserlist(' . $businessprofiledata1[0]['business_profile_post_id'] . ');">';

                $contition_array = array('business_profile_post_id' => $businessprofiledata1[0]['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $likeuser = $commnetcount[0]['business_like_user'];
                $countlike = $commnetcount[0]['business_likes_count'] - 1;

                $likelistarray = explode(',', $likeuser);
                $likelistarray = array_reverse($likelistarray);

                $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $likelistarray[0], 'status' => 1))->row()->company_name;

                if ($userid == $likelistarray[0]) {
                    $cmtlikeuser .= 'You ';
                } else {
                    $cmtlikeuser .= '' . ucfirst(strtolower($business_fname1)) . '&nbsp;';
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
                echo json_encode(
                        array("like" => $cmtlike,
                            "likeuser" => $cmtlikeuser,
                            "like_user_count" => $like_user_count,
                            "like_user_total_count" => $commnetcount[0]['business_likes_count']));
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
                    $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
                }

                $cmtlikeuser .= '<div class="like_one_other">';
                $cmtlikeuser .= '<a href="javascript:void(0);" class="ripple like_h_w" onclick="likeuserlist(' . $businessprofiledata2[0]['business_profile_post_id'] . ')">';
                $contition_array = array('business_profile_post_id' => $businessprofiledata2[0]['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $likeuser = $commnetcount[0]['business_like_user'];
                $countlike = $commnetcount[0]['business_likes_count'] - 1;

                $likelistarray = explode(',', $likeuser);

                $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $likelistarray[0], 'status' => 1))->row()->company_name;

                $cmtlikeuser .= '' . ucfirst(strtolower($business_fname1)) . '&nbsp;';


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
                echo json_encode(
                        array("like" => $cmtlike,
                            "likeuser" => $cmtlikeuser,
                            "like_user_count" => $like_user_count,
                            "like_user_total_count" => $commnetcount[0]['business_likes_count']
                ));
            } else {
                
            }
        }

//jsondata
    }

// business_profile post  like end
//business_profile comment insert start

    public function insert_commentthree() {

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
            'status' => 1,
            'is_delete' => 0
        );


        $insert_id = $this->common->insert_data_getid($data, 'business_profile_post_comment');

// insert notification

        if ($busdatacomment[0]['user_id'] == $userid || $busdatacomment[0]['is_delete'] == '1') {
            
        } else {
            $notificationdata = array(
                'not_type' => 6,
                'not_from_id' => $userid,
                'not_to_id' => $busdatacomment[0]['user_id'],
                'not_read' => 2,
                'not_product_id' => $insert_id,
                'not_from' => 6,
                'not_img' => 1,
                'not_created_date' => date('Y-m-d H:i:s'),
                'not_active' => 1
            );
            $insert_id_notification = $this->common->insert_data_getid($notificationdata, 'notification');
        }
// end notoification

        $contition_array = array('business_profile_post_id' => $_POST["post_id"], 'status' => '1');
        $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = 'business_profile_post_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('business_profile_post_id' => $_POST["post_id"], 'status' => '1');
        $buscmtcnt = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = 'business_profile_post_comment_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        foreach ($businessprofiledata as $business_profile) {
            $company_name = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id']))->row()->company_name;
            $business_userimage = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id'], 'status' => 1))->row()->business_user_image;
            $cmtinsert .= '<div class="all-comment-comment-box">';
            $cmtinsert .= '<div class="post-design-pro-comment-img">';
            if ($business_userimage != '') {

                if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                    $a = $company_name;
                    $acr = substr($a, 0, 1);

                    $cmtinsert .= '<div class="post-img-div">';
                    $cmtinsert .= ucfirst(strtolower($acr));
                    $cmtinsert .= '</div>';
                } else {
                    $cmtinsert .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) . '" alt="">';
                }

                $cmtinsert .= '</div>';
            } else {
                $a = $company_name;
                $acr = substr($a, 0, 1);

                $cmtinsert .= '<div class="post-img-div">';
                $cmtinsert .= ucfirst(strtolower($acr));
                $cmtinsert .= '</div>';
                $cmtinsert .= '</div>';
            }
            $cmtinsert .= '<div class="comment-name"><b>' . ucfirst(strtolower($company_name)) . '</b>';
            $cmtinsert .= '</div>';
            $cmtinsert .= '<div class="comment-details" id="showcomment' . $business_profile['business_profile_post_comment_id'] . '">';
            $cmtinsert .= $this->common->make_links($business_profile['comments']);
            $cmtinsert .= '</div>';

            $cmtinsert .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';
            $cmtinsert .= '<div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="' . $business_profile['business_profile_post_comment_id'] . '"  id="editcomment' . $business_profile['business_profile_post_comment_id'] . '" placeholder="Type Message ..." onkeyup="commentedit(' . $business_profile['business_profile_post_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $business_profile['comments'] . '</div>';
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
            $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $business_profile['business_profile_post_id'], 'status' => 1))->row()->user_id;
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
        echo json_encode(
                array("comment" => $cmtinsert,
                    "count" => $cmtcount,
                    "comment_count" => $cntinsert));
    }

    public function insert_comment() {

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
            'status' => 1,
            'is_delete' => 0
        );

        $insert_id = $this->common->insert_data_getid($data, 'business_profile_post_comment');

// insert notification
        if ($busdatacomment[0]['user_id'] == $userid || $busdatacomment[0]['is_delete'] == '1') {
            
        } else {
            $notificationdata = array(
                'not_type' => 6,
                'not_from_id' => $userid,
                'not_to_id' => $busdatacomment[0]['user_id'],
                'not_read' => 2,
                'not_product_id' => $insert_id,
                'not_from' => 6,
                'not_img' => 1,
                'not_created_date' => date('Y-m-d H:i:s'),
                'not_active' => 1
            );
            $insert_id_notification = $this->common->insert_data_getid($notificationdata, 'notification');
        }
// end notoification



        $contition_array = array('business_profile_post_id' => $_POST["post_id"], 'status' => '1');
        $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = 'business_profile_post_comment_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
// khyati changes start
        $cmtinsert = '<div class="insertcommenttwo' . $post_id . '">';
        foreach ($businessprofiledata as $business_profile) {
            $company_name = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id']))->row()->company_name;
            $business_userimage = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id'], 'status' => 1))->row()->business_user_image;

            $cmtinsert .= '<div class="all-comment-comment-box">';
            $cmtinsert .= '<div class="post-design-pro-comment-img">';
            if ($business_userimage) {

                if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                    $a = $company_name;
                    $acr = substr($a, 0, 1);

                    $cmtinsert .= '<div class="post-img-div">';
                    $cmtinsert .= ucfirst(strtolower($acr));
                    $cmtinsert .= '</div>';
                } else {

                    $cmtinsert .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) . '" alt="">';
                }

                $cmtinsert .= '</div>';
            } else {
                $a = $company_name;
                $acr = substr($a, 0, 1);

                $cmtinsert .= '<div class="post-img-div">';
                $cmtinsert .= ucfirst(strtolower($acr));
                $cmtinsert .= '</div>';
                $cmtinsert .= '</div>';
            }
            $cmtinsert .= '<div class="comment-name"><b>' . ucfirst(strtolower($company_name)) . '</b>';
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

            $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $business_profile['business_profile_post_id'], 'status' => 1))->row()->user_id;


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

//        echo $cmtinsert;
        echo json_encode(
                array("comment" => $cmtinsert,
                    "count" => $cmtcount,
                    "comment_count" => $cntinsert));

// khyati chande 
    }

//business_profile comment insert end  
//business_profile comment edit start
    public function edit_comment_insert() {

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
            $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $cmtlike = '<div>';
            $cmtlike .= $this->common->make_links($businessprofiledata[0]['comments']);
            $cmtlike .= '</div>';
            echo $cmtlike;
        }
    }

//business_profile like commnet ajax end 
// click on post after post open on new page start

    public function postnewpage($id) {

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['businessdata'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('business_profile_post_id' => $id, 'status' => '1');
        $this->data['busienss_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->data['business_left'] = $this->load->view('business_profile/business_left', $this->data, true);
        $this->load->view('business_profile/postnewpage', $this->data);
    }

// click on post after post open on new page end 
//edit post start

    public function edit_post_insert() {

        $userid = $this->session->userdata('aileenuser');
        $post_id = $_POST["business_profile_post_id"];
        $business_post = $_POST["product_name"];
        $business_description = $_POST["product_description"];

        $data = array(
            'product_name' => $business_post,
            'product_description' => $business_description,
            'modify_date' => date('y-m-d h:i:s')
        );

        $updatdata = $this->common->update_data($data, 'business_profile_post', 'business_profile_post_id', $post_id);
        if ($updatdata) {

            $contition_array = array('business_profile_post_id' => $_POST["business_profile_post_id"], 'status' => '1');
            $businessdata = $this->data['businessdata'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($this->data['businessdata'][0]['product_name']) {
                $editpost = '<div><a style="margin-bottom: 0px; font-size: 17px ; color:black;">';
                $editpost .= $businessdata[0]['product_name'] . "";
                $editpost .= '</a></div>';
            }
            if ($this->data['businessdata'][0]['product_description']) {
                $small = substr($businessdata[0]['product_description'], 0, 180);
                $editpostdes .= $this->common->make_links($small);
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

        $userid = $this->session->userdata('aileenuser');
        $data = array(
            'status' => 1,
            'modified_date' => date('y-m-d h:i:s')
        );

        $updatdata = $this->common->update_data($data, 'business_profile', 'user_id', $userid);
        if ($updatdata) {
            redirect('business-profile/home', refresh);
        } else {

            $this->load->view('business_profile/reactivate', $this->data);
        }
    }

//reactivate accont end    
//delete post particular user start
    public function del_particular_userpost() {

        $userid = $this->session->userdata('aileenuser');
        $post_id = $_POST['business_profile_post_id'];
        $contition_array = array('business_profile_post_id' => $post_id, 'status' => '1');
        $businessdata = $this->data['businessdata'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $likeuserarray = explode(',', $businessdata[0]['delete_post']);
        $user_array = array_push($likeuserarray, $userid);

        if ($businessdata[0]['delete_post'] == 0) {
            $userid = implode('', $likeuserarray);
        } else {
            $userid = implode(',', $likeuserarray);
        }

        $data = array(
            'delete_post' => $userid,
            'modify_date' => date('y-m-d h:i:s')
        );

        $updatdata = $this->common->update_data($data, 'business_profile_post', 'business_profile_post_id', $post_id);
        $business_profile_id = $this->data['businessdata'][0]['business_profile_id'];

// for post count start
        $contition_array = array('follow_from' => $business_profile_id, 'follow_status' => '1', 'follow_type' => '2');
        $followerdata = $this->data['followerdata'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        foreach ($followerdata as $fdata) {
            $contition_array = array('business_profile_id' => $fdata['follow_to'], 'business_step' => 4);
            $this->data['business_data'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $business_userid = $this->data['business_data'][0]['user_id'];
            $contition_array = array('user_id' => $business_userid, 'status' => '1', 'is_delete' => '0');
            $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $followerabc[] = $this->data['business_profile_data'];
        }
//data fatch using follower end
//data fatch using industriyal start

        $userselectindustriyal = $this->data['businessdata'][0]['industriyal'];
        $contition_array = array('industriyal' => $userselectindustriyal, 'status' => '1', 'business_step' => 4);
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

        if (count($otherdata) > 0) {
            if (count($count) == count($otherdata)) {
                $datacount = "count";
                $notfound = '<div class="contact-frnd-post bor_none">';
                $notfound .= '<div class="text-center rio">';
                $notfound .= '<h4 class="page-heading  product-listing">No Following Found.</h4>';
                $notfound .= '</div></div>';
            }
        } else {
            $datacount = "count";
            $notfound = '<div class="contact-frnd-post bor_none">';
            $notfound .= '<div class="text-center rio">';
            $notfound .= '<h4 class="page-heading  product-listing">No Following Found.</h4>';
            $notfound .= '</div></div>';
        }
        echo json_encode(
                array(
                    "notfound" => $notfound,
                    "notcount" => $datacount,
        ));
    }

//delete post particular user end  
//multiple image for manage user start


    public function business_photos($id) {

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'status' => '1');

        $this->data['slug_data'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $slug_id = $this->data['slug_data'][0]['business_slug'];
        if ($id == $slug_id || $id == '') {

            $contition_array = array('business_slug' => $slug_id, 'status' => '1', 'business_step' => 4);
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $join_str[0]['table'] = 'post_files';
            $join_str[0]['join_table_id'] = 'post_image.post_id';
            $join_str[0]['from_table_id'] = 'business_profile_post.business_profile_post_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'image_type' => 2, 'status' => 1, 'is_delete' => '0');
            $data = 'business_profile_post_id, image_id, image_name';

            $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        } else {

            $contition_array = array('business_slug' => $id, 'status' => '1', 'business_step' => 4);
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $join_str[0]['table'] = 'post_files';
            $join_str[0]['join_table_id'] = 'post_image.post_id';
            $join_str[0]['from_table_id'] = 'business_profile_post.business_profile_post_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'image_type' => 2, 'status' => 1, 'is_delete' => '0');
            $data = 'business_profile_post_id, image_id, image_name';
            $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        }
        $this->data['file_header'] = $this->load->view('business_profile/file_header', $this->data, true);
        $this->load->view('business_profile/business_photos', $this->data);
    }

//multiple iamge for manage user end   
//multiple video for manage user start


    public function business_videos($id) {
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['slug_data'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $slug_id = $this->data['slug_data'][0]['business_slug'];
        if ($id == $slug_id || $id == '') {

            $contition_array = array('business_slug' => $slug_id, 'status' => '1', 'business_step' => 4);
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'status' => 1, 'is_delete' => '0');

            $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {

            $contition_array = array('business_slug' => $id, 'status' => '1', 'business_step' => 4);
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'status' => 1, 'is_delete' => '0');

            $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }
        $this->data['file_header'] = $this->load->view('business_profile/file_header', $this->data, true);
        $this->load->view('business_profile/business_videos', $this->data);
    }

//multiple video for manage user end 
//multiple audio for manage user start


    public function business_audios($id) {


        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['slug_data'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $slug_id = $this->data['slug_data'][0]['business_slug'];
        if ($id == $slug_id || $id == '') {

            $contition_array = array('business_slug' => $slug_id, 'status' => '1', 'business_step' => 4);
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'status' => 1, 'is_delete' => '0');

            $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {

            $contition_array = array('business_slug' => $id, 'status' => '1', 'business_step' => 4);
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'status' => 1, 'is_delete' => '0');

            $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }
        $this->data['file_header'] = $this->load->view('business_profile/file_header', $this->data, true);
        $this->load->view('business_profile/business_audios', $this->data);
    }

//multiple audio for manage user end   
//multiple pdf for manage user start


    public function business_pdf($id) {

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'status' => '1', 'business_step' => 4);
        $this->data['slug_data'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $slug_id = $this->data['slug_data'][0]['business_slug'];
        if ($id == $slug_id || $id == '') {

            $contition_array = array('business_slug' => $slug_id, 'status' => '1');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'status' => 1, 'is_delete' => '0');

            $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {

            $contition_array = array('business_slug' => $id, 'status' => '1', 'business_step' => 4);
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'status' => 1, 'is_delete' => '0');

            $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }
        $this->data['file_header'] = $this->load->view('business_profile/file_header', $this->data, true);
        $this->load->view('business_profile/business_pdf', $this->data);
    }

//multiple pdf for manage user end 
//multiple images like start
    public function mulimg_like() {
        $post_image = $_POST['post_image_id'];
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('post_image_id' => $post_image, 'user_id' => $userid);
        $likeuser = $this->data['likeuser'] = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('image_id' => $post_image);
        $likeuserid = $this->data['likeuserid'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('business_profile_post_id' => $likeuserid[0]['post_id']);
        $likepostid = $this->data['likepostid'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if (!$likeuser) {
            $data = array(
                'post_image_id' => $post_image,
                'user_id' => $userid,
                'created_date' => date('Y-m-d H:i:s', time()),
                'is_unlike' => 0
            );
            $insertdata = $this->common->insert_data_getid($data, 'bus_post_image_like');
// insert notification
            if ($likepostid[0]['user_id'] == $userid) {
                
            } else {

                $data = array(
                    'not_type' => 5,
                    'not_from_id' => $userid,
                    'not_to_id' => $likepostid[0]['user_id'],
                    'not_read' => 2,
                    'not_product_id' => $post_image,
                    'not_from' => 6,
                    'not_img' => 5,
                    'not_created_date' => date('Y-m-d H:i:s'),
                    'not_active' => 1
                );

                $insert_id = $this->common->insert_data_getid($data, 'notification');
            }
// end notoification


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
                    $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $userdata['user_id'], 'status' => 1))->row()->company_name;
                }
                $imglikeuser .= '<div class="like_one_other_img">';
                $imglikeuser .= '<a href="javascript:void(0);"  onclick="likeuserlistimg(' . $post_image . ');">';

                $contition_array = array('post_image_id' => $post_image, 'is_unlike' => '0');
                $commneteduser = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = 'post_image_like_id,post_image_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $countlike = count($commneteduser) - 1;
                $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $commneteduser[0]['user_id'], 'status' => 1))->row()->company_name;


                if ($userid == $commneteduser[0]['user_id']) {

                    $imglikeuser .= 'You ';
                } else {

                    $imglikeuser .= '' . ucfirst(strtolower($business_fname1)) . '&nbsp;';
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
                echo json_encode(
                        array("like" => $imglike,
                            "likeuser" => $imglikeuser,
                            "like_user_count" => $like_user_count,
                            "like_user_total_count" => count($commneteduser),
                ));
            }
        } else {

            if ($likeuser[0]['is_unlike'] == 0) {
                $data = array(
                    'modify_date' => date('Y-m-d', time()),
                    'is_unlike' => 1
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
                        $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $userdata['user_id'], 'status' => 1))->row()->company_name;
                    }

                    $imglikeuser1 .= '<div class="like_one_other_img">';
                    $imglikeuser1 .= '<a href="javascript:void(0);"  onclick="likeuserlistimg(' . $post_image . ');">';

                    $contition_array = array('post_image_id' => $post_image, 'is_unlike' => '0');
                    $commneteduser = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = 'post_image_like_id,post_image_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $countlike = count($commneteduser) - 1;
                    $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $commneteduser[0]['user_id'], 'status' => 1))->row()->company_name;


                    if ($userid == $commneteduser[0]['user_id']) {

                        $imglikeuser1 .= 'You ';
                    } else {
                        $imglikeuser1 .= '' . ucfirst(strtolower($business_fname1)) . '&nbsp;';
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

                    echo json_encode(
                            array("like" => $imglike1,
                                "likeuser" => $imglikeuser1,
                                "like_user_count" => $like_user_count1,
                                "like_user_total_count" => count($commneteduser),
                    ));
                }
            } else {
                $data = array(
                    'modify_date' => date('Y-m-d', time()),
                    'is_unlike' => 0
                );

                $this->db->where('post_image_id', $post_image);
                $this->db->where('user_id', $userid);
                $updatdata = $this->db->update('bus_post_image_like', $data);
// insert notification
                if ($likepostid[0]['user_id'] == $userid) {
                    
                } else {
                    $contition_array = array('not_type' => 5, 'not_from_id' => $userid, 'not_to_id' => $likepostid[0]['user_id'], 'not_product_id' => $post_image, 'not_from' => 6, 'not_img' => 5);
                    $busnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    if ($busnotification[0]['not_read'] == 2) {
                        
                    } elseif ($busnotification[0]['not_read'] == 1) {

                        $datalike = array(
                            'not_read' => 2
                        );

                        $where = array('not_type' => 5, 'not_from_id' => $userid, 'not_to_id' => $likepostid[0]['user_id'], 'not_product_id' => $post_image, 'not_from' => 6, 'not_img' => 5);
                        $this->db->where($where);
                        $updatdata = $this->db->update('notification', $datalike);
                    } else {


                        $data = array(
                            'not_type' => 5,
                            'not_from_id' => $userid,
                            'not_to_id' => $likepostid[0]['user_id'],
                            'not_read' => 2,
                            'not_product_id' => $post_image,
                            'not_from' => 6,
                            'not_img' => 5,
                            'not_created_date' => date('Y-m-d H:i:s'),
                            'not_active' => 1
                        );

                        $insert_id = $this->common->insert_data_getid($data, 'notification');
                    }
                }
// end notoification

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
                        $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $userdata['user_id'], 'status' => 1))->row()->company_name;
                    }
                    $imglikeuser1 .= '<div class="like_one_other_img">';
                    $imglikeuser1 .= '<a href="javascript:void(0);"  onclick="likeuserlistimg(' . $post_image . ');">';

                    $contition_array = array('post_image_id' => $post_image, 'is_unlike' => '0');
                    $commneteduser = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = 'post_image_like_id,post_image_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $countlike = count($commneteduser) - 1;
                    $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $commneteduser[0]['user_id'], 'status' => 1))->row()->company_name;

                    if ($userid == $commneteduser[0]['user_id']) {
                        $imglikeuser1 .= 'You ';
                    } else {
                        $imglikeuser1 .= '' . ucfirst(strtolower($business_fname1)) . '&nbsp;';
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

                    echo json_encode(
                            array("like" => $imglike1,
                                "likeuser" => $imglikeuser1,
                                "like_user_count" => $like_user_count1));
                }
            }
        }
    }

//multiple iamges like end 
//multiple images comment strat

    public function mulimg_commentthree() {

        $userid = $this->session->userdata('aileenuser');

        $post_image_id = $_POST["post_image_id"];
        $post_comment = $_POST["comment"];

        $contition_array = array('image_id' => $_POST["post_image_id"], 'is_deleted' => '1');
        $busimg = $this->data['busimg'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('business_profile_post_id' => $busimg[0]["post_id"], 'is_delete' => 0);
        $buspostid = $this->data['buspostid'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $data = array(
            'user_id' => $userid,
            'post_image_id' => $post_image_id,
            'comment' => $post_comment,
            'created_date' => date('Y-m-d H:i:s', time()),
            'is_delete' => 0
        );
        $insert_id = $this->common->insert_data_getid($data, 'bus_post_image_comment');

// insert notification

        if ($buspostid[0]['user_id'] == $userid) {
            
        } else {
            $datanotification = array(
                'not_type' => 6,
                'not_from_id' => $userid,
                'not_to_id' => $buspostid[0]['user_id'],
                'not_read' => 2,
                'not_product_id' => $insert_id,
                'not_from' => 6,
                'not_img' => 4,
                'not_created_date' => date('Y-m-d H:i:s'),
                'not_active' => 1
            );
            $insert_id_notification = $this->common->insert_data_getid($datanotification, 'notification');
        }
// end notoification

        $contition_array = array('post_image_id' => $post_image_id, 'is_delete' => '0');
        $businesscomment = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');
// count for comment
        $contition_array = array('post_image_id' => $post_image_id, 'is_delete' => '0');
        $buscmtcnt = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        foreach ($businesscomment as $bus_comment) {
            $company_name = $this->db->get_where('business_profile', array('user_id' => $bus_comment['user_id']))->row()->company_name;
            $business_userimage = $this->db->get_where('business_profile', array('user_id' => $bus_comment['user_id'], 'status' => 1))->row()->business_user_image;

            $cmtinsert .= '<div class="post-design-pro-comment-img">';
            if ($business_userimage != '') {

                if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                    $a = $company_name;
                    $acr = substr($a, 0, 1);

                    $cmtinsert .= '<div class="post-img-div">';
                    $cmtinsert .= ucfirst(strtolower($acr));
                    $cmtinsert .= '</div>';
                } else {

                    $cmtinsert .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) . '" alt="">';
                }

                $cmtinsert .= '</div>';
            } else {
                $a = $company_name;
                $acr = substr($a, 0, 1);

                $cmtinsert .= '<div class="post-img-div">';
                $cmtinsert .= ucfirst(strtolower($acr));
                $cmtinsert .= '</div>';
                $cmtinsert .= '</div>';
            }
            $cmtinsert .= '<div class="comment-name"><b>' . $company_name . '</b>';
            $cmtinsert .= '</div>';

            $cmtinsert .= '<div class="comment-details" id= "showcomment' . $bus_comment['post_image_comment_id'] . '"" >';
            $cmtinsert .= $this->common->make_links($bus_comment['comment']);
            $cmtinsert .= '</div>';
            $cmtinsert .= '<div contenteditable="true" class="editable_text" name="' . $bus_comment['post_image_comment_id'] . '" id="editcomment' . $bus_comment['post_image_comment_id'] . '" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" onClick="commentedit(' . $bus_comment['post_image_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">';
            $cmtinsert .= $bus_comment['comment'];
            $cmtinsert .= '</div>';

            $cmtinsert .= '<button id="editsubmit' . $bus_comment['post_image_comment_id'] . '" style="display:none;" onClick="edit_comment(' . $bus_comment['post_image_comment_id'] . ')">Save</button><div class="art-comment-menu-design"> <div class="comment-details-menu" id="likecomment' . $bus_comment['post_image_comment_id'] . '">';
            $cmtinsert .= '<a id="' . $bus_comment['post_image_comment_id'] . '"';
            $cmtinsert .= 'onClick="imgcomment_like(this.id)">';

            $contition_array = array('post_image_comment_id' => $bus_comment['post_image_comment_id'], 'user_id' => $userid, 'is_unlike' => 0);
            $businesscommentlike1 = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if (count($businesscommentlike1) == 0) {
                $cmtinsert .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
            } else {
                $cmtinsert .= '<i class="fa fa-thumbs-up main_color" aria-hidden="true"></i>';
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
                $cmtinsert .= '<div id="editcommentbox' . $bus_comment['post_image_comment_id'] . '"style="display:block;">';
                $cmtinsert .= '<a id="' . $bus_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_editbox(this.id)">';
                $cmtinsert .= 'Edit';
                $cmtinsert .= '</a></div>';
                $cmtinsert .= '<div id="editcancle' . $bus_comment['post_image_comment_id'] . '"style="display:none;">';
                $cmtinsert .= '<a id="' . $bus_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_editcancle(this.id)">';
                $cmtinsert .= 'Cancel';
                $cmtinsert .= '</a></div>';

                $cmtinsert .= '</div>';
            }
            $userid = $this->session->userdata('aileenuser');
            $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $bus_comment['post_image_id'], 'status' => 1))->row()->user_id;

            if ($bus_comment['user_id'] == $userid || $business_userid == $userid) {

                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';
                $cmtinsert .= '<input type="hidden" name="post_delete"';
                $cmtinsert .= 'id="post_delete' . $bus_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'value= "' . $bus_comment['post_image_id'] . '">';
                $cmtinsert .= '<a id="' . $bus_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_delete(this.id)">';
                $cmtinsert .= 'Delete';
                $cmtinsert .= '</a></div>';
            }

            $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
            $cmtinsert .= '<div class="comment-details-menu">';
            $cmtinsert .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($bus_comment['created_date']))) . '</p></div></div>';

// comment aount variable start
// $idpost = $business_profile['business_profile_post_id'];
            $cmtcount = '<a onClick="commentall(this.id)" id="' . $post_image_id . '">';
            $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
            $cmtcount .= ' ' . count($buscmtcnt) . '';
            $cmtcount .= '</i></a>';

// comment count variable end 
        }
        echo json_encode(
                array("comment" => $cmtinsert,
                    "count" => $cmtcount,
                    "comment_count" => count($buscmtcnt)
        ));
    }

    public function mulimg_comment() {

        $userid = $this->session->userdata('aileenuser');

        $post_image_id = $_POST["post_image_id"];
        $post_comment = $_POST["comment"];

        $contition_array = array('image_id' => $_POST["post_image_id"], 'is_deleted' => '1');
        $busimg = $this->data['busimg'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('business_profile_post_id' => $busimg[0]["post_id"], 'is_delete' => 0);
        $buspostid = $this->data['buspostid'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $data = array(
            'user_id' => $userid,
            'post_image_id' => $post_image_id,
            'comment' => $post_comment,
            'created_date' => date('Y-m-d H:i:s', time()),
            'is_delete' => 0
        );
        $insert_id = $this->common->insert_data_getid($data, 'bus_post_image_comment');

// insert notification

        if ($buspostid[0]['user_id'] == $userid) {
            
        } else {
            $datanotification = array(
                'not_type' => 6,
                'not_from_id' => $userid,
                'not_to_id' => $buspostid[0]['user_id'],
                'not_read' => 2,
                'not_product_id' => $insert_id,
                'not_from' => 6,
                'not_img' => 4,
                'not_created_date' => date('Y-m-d H:i:s'),
                'not_active' => 1
            );

            $insert_id_notification = $this->common->insert_data_getid($datanotification, 'notification');
        }
// end notoification

        $contition_array = array('post_image_id' => $post_image_id, 'is_delete' => '0');
        $businesscomment = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
// count for comment
        $contition_array = array('post_image_id' => $post_image_id, 'is_delete' => '0');
        $buscmtcnt = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        foreach ($businesscomment as $bus_comment) {
            $company_name = $this->db->get_where('business_profile', array('user_id' => $bus_comment['user_id']))->row()->company_name;
            $business_userimage = $this->db->get_where('business_profile', array('user_id' => $bus_comment['user_id'], 'status' => 1))->row()->business_user_image;
            $cmtinsert .= '<div class="post-design-pro-comment-img">';
            if ($business_userimage != '') {

                if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                    $a = $company_name;
                    $acr = substr($a, 0, 1);

                    $cmtinsert .= '<div class="post-img-div">';
                    $cmtinsert .= ucfirst(strtolower($acr));
                    $cmtinsert .= '</div>';
                } else {

                    $cmtinsert .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) . '" alt="">';
                }
                $cmtinsert .= '</div>';
            } else {
                $a = $company_name;
                $acr = substr($a, 0, 1);

                $cmtinsert .= '<div class="post-img-div">';
                $cmtinsert .= ucfirst(strtolower($acr));
                $cmtinsert .= '</div></div>';
            }
            $cmtinsert .= '<div class="comment-name"><b>' . $company_name . '</b>';
            $cmtinsert .= '</div>';

            $cmtinsert .= '<div class="comment-details" id= "showcomment' . $bus_comment['post_image_comment_id'] . '"" >';
            $cmtinsert .= $this->common->make_links($bus_comment['comment']);
            $cmtinsert .= '</div>';
            $cmtinsert .= '<div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="' . $bus_comment['post_image_comment_id'] . '"  id="editcomment' . $bus_comment['post_image_comment_id'] . '" placeholder="Type Message ..."  onkeyup="commentedittwo(' . $bus_comment['post_image_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $bus_comment['comment'] . '</div>';
            $cmtinsert .= '<button id="editsubmit' . $bus_comment['post_image_comment_id'] . '" style="display:none;" onClick="edit_commenttwo(' . $bus_comment['post_image_comment_id'] . ')">Save</button><div class="art-comment-menu-design"> <div class="comment-details-menu" id="likecomment' . $bus_comment['post_image_comment_id'] . '">';

            $cmtinsert .= '<a id="' . $bus_comment['post_image_comment_id'] . '"';
            $cmtinsert .= 'onClick="imgcomment_liketwo(this.id)">';

            $contition_array = array('post_image_comment_id' => $bus_comment['post_image_comment_id'], 'user_id' => $userid, 'is_unlike' => 0);

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
                $cmtinsert .= '<div id="editcommentbox' . $bus_comment['post_image_comment_id'] . '"style="display:block;">';
                $cmtinsert .= '<a id="' . $bus_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_editbox(this.id)">';
                $cmtinsert .= 'Edit';
                $cmtinsert .= '</a></div>';
                $cmtinsert .= '<div id="editcancle' . $bus_comment['post_image_comment_id'] . '"style="display:none;">';
                $cmtinsert .= '<a id="' . $bus_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_editcancle(this.id)">';
                $cmtinsert .= 'Cancel';
                $cmtinsert .= '</a></div>';
                $cmtinsert .= '</div>';
            }
            $userid = $this->session->userdata('aileenuser');
            $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $bus_comment['post_image_id'], 'status' => 1))->row()->user_id;
            if ($bus_comment['user_id'] == $userid || $business_userid == $userid) {

                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';
                $cmtinsert .= '<input type="hidden" name="post_deletetwo"';
                $cmtinsert .= 'id="post_deletetwo' . $bus_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'value= "' . $bus_comment['post_image_id'] . '">';
                $cmtinsert .= '<a id="' . $bus_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_delete(this.id)">';
                $cmtinsert .= 'Delete';
                $cmtinsert .= '</a></div>';
            }

            $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
            $cmtinsert .= '<div class="comment-details-menu">';
            $cmtinsert .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($bus_comment['created_date']))) . '</p></div></div>';

// comment aount variable start
            $cmtcount = '<a onClick="commentall(this.id)" id="' . $post_image_id . '">';
            $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
            $cmtcount .= ' ' . count($buscmtcnt) . '';
            $cmtcount .= '</i></a>';

// comment count variable end 
        }
        echo json_encode(
                array("comment" => $cmtinsert,
                    "count" => $cmtcount,
                    "comment_count" => count($buscmtcnt)
        ));
    }

    public function pnmulimg_comment() {

        $userid = $this->session->userdata('aileenuser');

        $post_image_id = $_POST["post_image_id"];
        $post_comment = $_POST["comment"];

        $contition_array = array('image_id' => $_POST["post_image_id"], 'is_deleted' => '1');
        $busimg = $this->data['busimg'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('business_profile_post_id' => $busimg[0]["post_id"], 'is_delete' => 0);
        $buspostid = $this->data['buspostid'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $data = array(
            'user_id' => $userid,
            'post_image_id' => $post_image_id,
            'comment' => $post_comment,
            'created_date' => date('Y-m-d H:i:s', time()),
            'is_delete' => 0
        );
        $insert_id = $this->common->insert_data_getid($data, 'bus_post_image_comment');

// insert notification

        if ($buspostid[0]['user_id'] == $userid) {
            
        } else {
            $datanotification = array(
                'not_type' => 6,
                'not_from_id' => $userid,
                'not_to_id' => $buspostid[0]['user_id'],
                'not_read' => 2,
                'not_product_id' => $insert_id,
                'not_from' => 6,
                'not_img' => 4,
                'not_created_date' => date('Y-m-d H:i:s'),
                'not_active' => 1
            );

            $insert_id_notification = $this->common->insert_data_getid($datanotification, 'notification');
        }
// end notoification


        $contition_array = array('post_image_id' => $post_image_id, 'is_delete' => '0');
        $businesscomment = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('post_image_id' => $post_image_id, 'is_delete' => '0');
        $buscmtcnt = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $cmtinsert .= '<div class="insertimgcommenttwo' . $post_image_id . '">';

        foreach ($businesscomment as $bus_comment) {
            $company_name = $this->db->get_where('business_profile', array('user_id' => $bus_comment['user_id']))->row()->company_name;
            $business_userimage = $this->db->get_where('business_profile', array('user_id' => $bus_comment['user_id'], 'status' => 1))->row()->business_user_image;
            $cmtinsert .= '<div class="all-comment-comment-box">';
            $cmtinsert .= '<div class="post-design-pro-comment-img">';
            if ($business_userimage != '') {

                if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                    $a = $company_name;
                    $acr = substr($a, 0, 1);

                    $cmtinsert .= '<div class="post-img-div">';
                    $cmtinsert .= ucfirst(strtolower($acr));
                    $cmtinsert .= '</div>';
                } else {

                    $cmtinsert .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) . '" alt="">';
                }

                $cmtinsert .= '</div>';
            } else {
                $a = $company_name;
                $acr = substr($a, 0, 1);

                $cmtinsert .= '<div class="post-img-div">';
                $cmtinsert .= ucfirst(strtolower($acr));
                $cmtinsert .= '</div>';
                $cmtinsert .= '</div>';
            }
            $cmtinsert .= '<div class="comment-name"><b>' . $company_name . '</b>';
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

            $contition_array = array('post_image_comment_id' => $bus_comment['post_image_comment_id'], 'user_id' => $userid, 'is_unlike' => 0);

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

            $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $bus_comment['post_image_id'], 'status' => 1))->row()->user_id;
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
        header('Content-type: application/json');
        echo json_encode(
                array("comment" => $cmtinsert,
                    "count" => $cmtcount,
                    "comment_count" => count($buscmtcnt)
        ));
    }

    public function pnmulimgcommentthree() {

        $userid = $this->session->userdata('aileenuser');
        $post_image_id = $_POST["post_image_id"];
        $post_comment = $_POST["comment"];

        $contition_array = array('image_id' => $_POST["post_image_id"], 'is_deleted' => '1');
        $busimg = $this->data['busimg'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('business_profile_post_id' => $busimg[0]["post_id"], 'is_delete' => 0);
        $buspostid = $this->data['buspostid'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $data = array(
            'user_id' => $userid,
            'post_image_id' => $post_image_id,
            'comment' => $post_comment,
            'created_date' => date('Y-m-d H:i:s', time()),
            'is_delete' => 0
        );
        $insert_id = $this->common->insert_data_getid($data, 'bus_post_image_comment');

// insert notification

        if ($buspostid[0]['user_id'] == $userid) {
            
        } else {
            $datanotification = array(
                'not_type' => 6,
                'not_from_id' => $userid,
                'not_to_id' => $buspostid[0]['user_id'],
                'not_read' => 2,
                'not_product_id' => $insert_id,
                'not_from' => 6,
                'not_img' => 4,
                'not_created_date' => date('Y-m-d H:i:s'),
                'not_active' => 1
            );
//echo "<pre>"; print_r($datanotification); die();
            $insert_id_notification = $this->common->insert_data_getid($datanotification, 'notification');
        }
// end notoification

        $contition_array = array('post_image_id' => $post_image_id, 'is_delete' => '0');
        $businesscomment = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('post_image_id' => $post_image_id, 'is_delete' => '0');
        $buscmtcnt = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        foreach ($businesscomment as $bus_comment) {

            $company_name = $this->db->get_where('business_profile', array('user_id' => $bus_comment['user_id']))->row()->company_name;
            $business_userimage = $this->db->get_where('business_profile', array('user_id' => $bus_comment['user_id'], 'status' => 1))->row()->business_user_image;

            $cmtinsert .= '<div class="all-comment-comment-box">';
            $cmtinsert .= '<div class="post-design-pro-comment-img">';
            if ($business_userimage != '') {


                if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                    $a = $company_name;
                    $acr = substr($a, 0, 1);

                    $cmtinsert .= '<div class="post-img-div">';
                    $cmtinsert .= ucfirst(strtolower($acr));
                    $cmtinsert .= '</div>';
                } else {
                    $cmtinsert .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) . '" alt="">';
                }
                $cmtinsert .= '</div>';
            } else {
                $a = $company_name;
                $acr = substr($a, 0, 1);

                $cmtinsert .= '<div class="post-img-div">';
                $cmtinsert .= ucfirst(strtolower($acr));
                $cmtinsert .= '</div>';
                $cmtinsert .= '</div>';
            }
            $cmtinsert .= '<div class="comment-name"><b>' . $company_name . '</b>';
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

            $contition_array = array('post_image_comment_id' => $bus_comment['post_image_comment_id'], 'user_id' => $userid, 'is_unlike' => 0);

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

            $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $bus_comment['post_image_id'], 'status' => 1))->row()->user_id;


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
        echo json_encode(
                array("comment" => $cmtinsert,
                    "count" => $cmtcount,
                    "comment_count" => $cntinsert
        ));
    }

//multiple images comment end 
//multiple images comment like start
    public function mulimg_comment_like() {

        $userid = $this->session->userdata('aileenuser');
        $post_image_comment_id = $_POST["post_image_comment_id"];

        $contition_array = array('post_image_comment_id' => $post_image_comment_id, 'user_id' => $userid);
        $likecommentuser = $this->data['likecommentuser'] = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('post_image_comment_id' => $post_image_comment_id);
        $busimglike = $this->data['busimglike'] = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('image_id' => $busimglike[0]['post_image_id'], 'image_type' => '2');
        $buslikeimg = $this->data['buslikeimg'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('business_profile_post_id' => $buslikeimg[0]["post_id"]);
        $busimglikepost = $this->data['busimglikepost'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if (!$likecommentuser) {

            $data = array(
                'post_image_comment_id' => $post_image_comment_id,
                'user_id' => $userid,
                'created_date' => date('Y-m-d H:i:s', time()),
                'is_unlike' => 0
            );

            $insertdata = $this->common->insert_data_getid($data, 'bus_comment_image_like');

// insert notification

            if ($busimglike[0]['user_id'] == $userid) {
                
            } else {
                $datanotification = array(
                    'not_type' => 5,
                    'not_from_id' => $userid,
                    'not_to_id' => $busimglike[0]['user_id'],
                    'not_read' => 2,
                    'not_product_id' => $post_image_comment_id,
                    'not_from' => 6,
                    'not_img' => 6,
                    'not_created_date' => date('Y-m-d H:i:s'),
                    'not_active' => 1
                );
                $insert_id = $this->common->insert_data_getid($datanotification, 'notification');
            }
// end notoification

            $contition_array = array('post_image_comment_id' => $_POST["post_image_comment_id"], 'is_unlike' => '0');
            $bdatacm = $this->data['bdatacm'] = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($insertdata) {
                $imglike .= '<a id="' . $post_image_comment_id . '" onClick="imgcomment_like(this.id)">';
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
                    'is_unlike' => 1
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
                    'is_unlike' => 0
                );

                $where = array('post_image_comment_id' => $post_image_comment_id, 'user_id' => $userid);
                $this->db->where($where);
                $updatdata = $this->db->update('bus_comment_image_like ', $data);

// insert notification

                if ($busimglike[0]['user_id'] == $userid) {
                    
                } else {

                    $contition_array = array('not_type' => 5, 'not_from_id' => $userid, 'not_to_id' => $busimglike[0]['user_id'], 'not_product_id' => $post_image_comment_id, 'not_from' => 6, 'not_img' => 6);
                    $busnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    if ($busnotification[0]['not_read'] == 2) {
                        
                    } elseif ($busnotification[0]['not_read'] == 1) {

                        $datalike = array(
                            'not_read' => 2
                        );

                        $where = array('not_type' => 5, 'not_from_id' => $userid, 'not_to_id' => $busimglike[0]['user_id'], 'not_product_id' => $post_image_comment_id, 'not_from' => 6, 'not_img' => 6);
                        $this->db->where($where);
                        $updatdata = $this->db->update('notification', $datalike);
                    } else {

                        $data = array(
                            'not_type' => 5,
                            'not_from_id' => $userid,
                            'not_to_id' => $busimglike[0]['user_id'],
                            'not_read' => 2,
                            'not_product_id' => $post_image_comment_id,
                            'not_from' => 6,
                            'not_img' => 6,
                            'not_created_date' => date('Y-m-d H:i:s'),
                            'not_active' => 1
                        );
                        $insert_id = $this->common->insert_data_getid($data, 'notification');
                    }
                }
// end notoification 


                $contition_array = array('post_image_comment_id' => $_POST["post_image_comment_id"], 'is_unlike' => '0');
                $bdata2 = $this->data['bdata2'] = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($updatdata) {

                    $imglike1 .= '<a id="' . $post_image_comment_id . '" onClick="imgcomment_like(this.id)">';
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

    public function mulimg_comment_liketwo() {

        $userid = $this->session->userdata('aileenuser');

        $post_image_comment_id = $_POST["post_image_comment_id"];

        $contition_array = array('post_image_comment_id' => $post_image_comment_id, 'user_id' => $userid);

        $likecommentuser = $this->data['likecommentuser'] = $this->common->select_data_by_condition('bus_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('post_image_comment_id' => $post_image_comment_id);
        $busimglike = $this->data['busimglike'] = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
//echo "<pre>"; print_r($busimglike); die();


        $contition_array = array('image_id' => $busimglike[0]['post_image_id'], 'image_type' => '2');
        $buslikeimg = $this->data['buslikeimg'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('business_profile_post_id' => $buslikeimg[0]["post_id"]);
        $busimglikepost = $this->data['busimglikepost'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if (!$likecommentuser) {

            $data = array(
                'post_image_comment_id' => $post_image_comment_id,
                'user_id' => $userid,
                'created_date' => date('Y-m-d H:i:s', time()),
                'is_unlike' => 0
            );
//echo "<pre>"; print_r($data); die();

            $insertdata = $this->common->insert_data_getid($data, 'bus_comment_image_like');


// insert notification

            if ($busimglike[0]['user_id'] == $userid) {
                
            } else {
                $datanotification = array(
                    'not_type' => 5,
                    'not_from_id' => $userid,
                    'not_to_id' => $busimglike[0]['user_id'],
                    'not_read' => 2,
                    'not_product_id' => $post_image_comment_id,
                    'not_from' => 6,
                    'not_img' => 6,
                    'not_created_date' => date('Y-m-d H:i:s'),
                    'not_active' => 1
                );
//echo "<pre>"; print_r($datanotification); die();
                $insert_id = $this->common->insert_data_getid($datanotification, 'notification');
            }
// end notoification

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
                    'is_unlike' => 1
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
                    'is_unlike' => 0
                );

                $where = array('post_image_comment_id' => $post_image_comment_id, 'user_id' => $userid);
                $this->db->where($where);
                $updatdata = $this->db->update('bus_comment_image_like ', $data);



// insert notification

                if ($busimglike[0]['user_id'] == $userid) {
                    
                } else {

                    $contition_array = array('not_type' => 5, 'not_from_id' => $userid, 'not_to_id' => $busimglike[0]['user_id'], 'not_product_id' => $post_image_comment_id, 'not_from' => 6, 'not_img' => 6);
                    $busnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    if ($busnotification[0]['not_read'] == 2) {
                        
                    } elseif ($busnotification[0]['not_read'] == 1) {

                        $datalike = array(
                            'not_read' => 2
                        );

                        $where = array('not_type' => 5, 'not_from_id' => $userid, 'not_to_id' => $busimglike[0]['user_id'], 'not_product_id' => $post_image_comment_id, 'not_from' => 6, 'not_img' => 6);
                        $this->db->where($where);
                        $updatdata = $this->db->update('notification', $datalike);
                    } else {
                        $datanotification = array(
                            'not_type' => 5,
                            'not_from_id' => $userid,
                            'not_to_id' => $busimglike[0]['user_id'],
                            'not_read' => 2,
                            'not_product_id' => $post_image_comment_id,
                            'not_from' => 6,
                            'not_img' => 6,
                            'not_created_date' => date('Y-m-d H:i:s'),
                            'not_active' => 1
                        );

                        $insert_id = $this->common->insert_data_getid($datanotification, 'notification');
                    }
                }
// end notoification


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
        $userid = $this->session->userdata('aileenuser');

        $post_image_comment_id = $_POST["post_image_comment_id"];
        $post_delete = $_POST["post_delete"];
        $data = array(
            'is_delete' => 1,
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
                $business_userimage = $this->db->get_where('business_profile', array('user_id' => $bus_comment['user_id'], 'status' => 1))->row()->business_user_image;

                $cmtinsert .= '<div class="all-comment-comment-box">';
                $cmtinsert .= '<div class="post-design-pro-comment-img">';
                if ($business_userimage != '') {

                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                        $a = $company_name;
                        $acr = substr($a, 0, 1);

                        $cmtinsert .= '<div class="post-img-div">';
                        $cmtinsert .= ucfirst(strtolower($acr));
                        $cmtinsert .= '</div>';
                    } else {

                        $cmtinsert .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) . '" alt="">';
                    }
                    $cmtinsert .= '</div>';
                } else {
                    $a = $company_name;
                    $acr = substr($a, 0, 1);

                    $cmtinsert .= '<div class="post-img-div">';
                    $cmtinsert .= ucfirst(strtolower($acr));
                    $cmtinsert .= '</div>';
                    $cmtinsert .= '</div>';
                }
                $cmtinsert .= '<div class="comment-name"><b>' . $company_name . '</b>';
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

                $contition_array = array('post_image_comment_id' => $bus_comment['post_image_comment_id'], 'user_id' => $userid, 'is_unlike' => 0);
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

                $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $bus_comment['post_image_id'], 'status' => 1))->row()->user_id;

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
        $userid = $this->session->userdata('aileenuser');

        $post_image_comment_id = $_POST["post_image_comment_id"];
        $post_delete = $_POST["post_delete"];

        $data = array(
            'is_delete' => 1,
            'modify_date' => date('y-m-d h:i:s')
        );

        $updatdata = $this->common->update_data($data, 'bus_post_image_comment', 'post_image_comment_id', $post_image_comment_id);


        $contition_array = array('post_image_id' => $post_delete, 'is_delete' => '0');
        $businesscomment = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

//echo "<pre>"; print_r($businesscomment); die();
        if (count($businesscomment) > 0) {
            foreach ($businesscomment as $bus_comment) {
                $company_name = $this->db->get_where('business_profile', array('user_id' => $bus_comment['user_id']))->row()->company_name;
                $business_userimage = $this->db->get_where('business_profile', array('user_id' => $bus_comment['user_id'], 'status' => 1))->row()->business_user_image;

                $cmtinsert .= '<div class="all-comment-comment-box">';
                $cmtinsert .= '<div class="post-design-pro-comment-img">';
                if ($business_userimage != '') {

                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                        $a = $company_name;
                        $acr = substr($a, 0, 1);

                        $cmtinsert .= '<div class="post-img-div">';
                        $cmtinsert .= ucfirst(strtolower($acr));
                        $cmtinsert .= '</div>';
                    } else {
                        $cmtinsert .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) . '" alt="">';
                    }
                    $cmtinsert .= '</div>';
                } else {
                    $a = $company_name;
                    $acr = substr($a, 0, 1);

                    $cmtinsert .= '<div class="post-img-div">';
                    $cmtinsert .= ucfirst(strtolower($acr));
                    $cmtinsert .= '</div>';
                    $cmtinsert .= '</div>';
                }
                $cmtinsert .= '<div class="comment-name"><b>' . $company_name . '</b>';
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

                $contition_array = array('post_image_comment_id' => $bus_comment['post_image_comment_id'], 'user_id' => $userid, 'is_unlike' => 0);

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

                $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $bus_comment['post_image_id'], 'status' => 1))->row()->user_id;


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

        $userid = $this->session->userdata('aileenuser');

        $post_id = $_POST['bus_post_id'];

// html start

        $fourdata = '<div class="insertcommenttwo' . $post_id . '">';

        $contition_array = array('business_profile_post_id' => $post_id, 'status' => '1');
        $busienssdata = $this->data['busienssdata'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = 'business_profile_post_comment_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($busienssdata) {
            foreach ($busienssdata as $rowdata) {

                $companyname = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id']))->row()->company_name;

                $fourdata .= '<div class="all-comment-comment-box">';
                $fourdata .= '<div class="post-design-pro-comment-img">';

                $busienss_userimage = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id'], 'status' => 1))->row()->business_user_image;

                if ($busienss_userimage) {

                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $busienss_userimage)) {
                        $a = $companyname;
                        $acr = substr($a, 0, 1);

                        $fourdata .= '<div class="post-img-div">';
                        $fourdata .= ucfirst(strtolower($acr));
                        $fourdata .= '</div>';
                    } else {
                        $fourdata .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $busienss_userimage) . '"  alt="">';
                    }
                } else {
                    $a = $companyname;
                    $acr = substr($a, 0, 1);

                    $fourdata .= '<div class="post-img-div">';
                    $fourdata .= ucfirst(strtolower($acr));
                    $fourdata .= '</div>';
                }
                $fourdata .= '</div><div class="comment-name"><b>';
                $fourdata .= '' . ucfirst(strtolower($companyname)) . '</br></b></div>';
                $fourdata .= '<div class="comment-details" id= "showcommenttwo' . $rowdata['business_profile_post_comment_id'] . '">';

                $fourdata .= '<div id= "lessmore' . $rowdata['business_profile_post_comment_id'] . '"  style="display:block;">';

                $small = substr($rowdata['comments'], 0, 180);

                $fourdata .= '' . $this->common->make_links($small) . '';

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
                $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $rowdata['business_profile_post_id'], 'status' => 1))->row()->user_id;
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

        $userid = $this->session->userdata('aileenuser');

        $post_id = $_POST['bus_post_id'];

        $fourdata .= '<div class="insertcommenttwo' . $post_id . '">';

        $contition_array = array('post_image_id' => $post_id, 'is_delete' => '0');

        $busmulimage1 = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($busmulimage1) {
            foreach ($busmulimage1 as $rowdata) {

                $companyname = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id']))->row()->company_name;


                $fourdata .= '<div class="all-comment-comment-box">';

                $fourdata .= '<div class="post-design-pro-comment-img">';

                $business_userimage = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id'], 'status' => 1))->row()->business_user_image;

                if ($business_userimage != '') {

                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                        $a = $companyname;
                        $acr = substr($a, 0, 1);

                        $fourdata .= '<div class="post-img-div">';
                        $fourdata .= ucfirst(strtolower($acr));
                        $fourdata .= '</div>';
                    } else {
                        $fourdata .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) . '"  alt="">';
                    }
                    $fourdata .= '</div>';
                } else {
                    $a = $companyname;
                    $acr = substr($a, 0, 1);

                    $fourdata .= '<div class="post-img-div">';
                    $fourdata .= ucfirst(strtolower($acr));
                    $fourdata .= '</div>';
                    $fourdata .= '</div>';
                }
                $fourdata .= '<div class="comment-name"><b>';
                $fourdata .= '' . ucfirst(strtolower($companyname)) . '</br>';
                $fourdata .= '</b></div>';
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
                $contition_array = array('post_image_comment_id' => $rowdata['post_image_comment_id'], 'user_id' => $userid, 'is_unlike' => 0);

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

                $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $rowdata['post_image_id'], 'status' => 1))->row()->user_id;


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

    public function pnfourcomment($postid) {

        $userid = $this->session->userdata('aileenuser');
        $post_id = $_POST['bus_post_id'];

        $fourdata = '<div class="insertcommenttwo' . $post_id . '">';

        $contition_array = array('business_profile_post_id' => $post_id, 'status' => '1');
        $busienssdata = $this->data['busienssdata'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = 'business_profile_post_comment_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($busienssdata) {
            foreach ($busienssdata as $rowdata) {

                $companyname = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id']))->row()->company_name;

                $fourdata .= '<div class="all-comment-comment-box">';
                $fourdata .= '<div class="post-design-pro-comment-img">';

                $busienss_userimage = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id'], 'status' => 1))->row()->business_user_image;

                if ($busienss_userimage) {

                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $busienss_userimage)) {
                        $a = $companyname;
                        $acr = substr($a, 0, 1);

                        $fourdata .= '<div class="post-img-div">';
                        $fourdata .= ucfirst(strtolower($acr));
                        $fourdata .= '</div>';
                    } else {
                        $fourdata .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $busienss_userimage) . '"  alt="">';
                    }
                } else {
                    $a = $companyname;
                    $acr = substr($a, 0, 1);

                    $fourdata .= '<div class="post-img-div">';
                    $fourdata .= ucfirst(strtolower($acr));
                    $fourdata .= '</div>';
                }
                $fourdata .= '</div><div class="comment-name"><b>';
                $fourdata .= '' . ucfirst(strtolower($companyname)) . '</br></b></div>';
                $fourdata .= '<div class="comment-details" id= "showcommenttwo' . $rowdata['business_profile_post_comment_id'] . '">';
                $fourdata .= '' . $this->common->make_links($rowdata['comments']) . '</div>';
                $fourdata .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';
                $fourdata .= '<div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="' . $rowdata['business_profile_post_comment_id'] . '"  id="editcommenttwo' . $rowdata['business_profile_post_comment_id'] . '" placeholder="Type Message ..." onkeyup="commentedittwo(' . $rowdata['business_profile_post_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $rowdata['comments'] . '</div>';
                $fourdata .= '<span class="comment-edit-button"><button id="editsubmittwo' . $rowdata['business_profile_post_comment_id'] . '" style="display:none" onClick="edit_commenttwo(' . $rowdata['business_profile_post_comment_id'] . ')">Save</button></span>';
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
                $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $rowdata['business_profile_post_id'], 'status' => 1))->row()->user_id;
                if ($rowdata['user_id'] == $userid || $business_userid == $userid) {


                    $fourdata .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $fourdata .= '<div class="comment-details-menu">';
                    $fourdata .= '<input type="hidden" name="post_delete"';
                    $fourdata .= 'id="post_deletetwo' . $rowdata['business_profile_post_comment_id'] . '"; value= "' . $rowdata['business_profile_post_id'] . '">';
                    $fourdata .= '<a id="' . $rowdata['business_profile_post_comment_id'] . '"onClick="comment_deletetwo(this.id)"> Delete<span class="insertcommenttwo' . $rowdata['business_profile_post_comment_id'] . '"></span></a></div>';
                }
                $fourdata .= '<span role="presentation" aria-hidden="true"> · </span>';
                $fourdata .= '<div class="comment-details-menu">';
                $fourdata .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($rowdata['created_date']))) . '</br>';

                $fourdata .= '</p></div></div></div>';
            }
        }
        $fourdata .= '</div>';

        echo $fourdata;
    }

    public function pninsert_commentthree() {

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
            'status' => 1,
            'is_delete' => 0
        );


        $insert_id = $this->common->insert_data_getid($data, 'business_profile_post_comment');

// insert notification

        if ($busdatacomment[0]['user_id'] == $userid) {
            
        } else {
            $notificationdata = array(
                'not_type' => 6,
                'not_from_id' => $userid,
                'not_to_id' => $busdatacomment[0]['user_id'],
                'not_read' => 2,
                'not_product_id' => $insert_id,
                'not_from' => 6,
                'not_img' => 1,
                'not_created_date' => date('Y-m-d H:i:s'),
                'not_active' => 1
            );
//echo "<pre>"; print_r($notificationdata); 
            $insert_id_notification = $this->common->insert_data_getid($notificationdata, 'notification');
        }
// end notoification

        $contition_array = array('business_profile_post_id' => $_POST["post_id"], 'status' => '1');
        $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = 'business_profile_post_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');
//echo "<pre>"; print_r($businessprofiledata); die();

        $contition_array = array('business_profile_post_id' => $_POST["post_id"], 'status' => '1');
        $buscmtcnt = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = 'business_profile_post_comment_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
// khyati changes start

        foreach ($businessprofiledata as $business_profile) {

            $company_name = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id']))->row()->company_name;

            $business_userimage = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id'], 'status' => 1))->row()->business_user_image;

// $cmtinsert = '<div class="all-comment-comment-box">';

            $cmtinsert .= '<div class="all-comment-comment-box">';
            $cmtinsert .= '<div class="post-design-pro-comment-img">';
            if ($business_userimage != '') {

                if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                    $a = $company_name;
                    $acr = substr($a, 0, 1);

                    $cmtinsert .= '<div class="post-img-div">';
                    $cmtinsert .= ucfirst(strtolower($acr));
                    $cmtinsert .= '</div>';
                } else {
                    $cmtinsert .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) . '" alt="">';
                }
                $cmtinsert .= '</div>';
            } else {
                $a = $company_name;
                $acr = substr($a, 0, 1);

                $cmtinsert .= '<div class="post-img-div">';
                $cmtinsert .= ucfirst(strtolower($acr));
                $cmtinsert .= '</div></div>';
            }
            $cmtinsert .= '<div class="comment-name"><b>' . ucfirst(strtolower($company_name)) . '</b>';
            $cmtinsert .= '</div>';
            $cmtinsert .= '<div class="comment-details" id="showcomment' . $business_profile['business_profile_post_comment_id'] . '">';
            $cmtinsert .= $this->common->make_links($business_profile['comments']);
            $cmtinsert .= '</div>';

            $cmtinsert .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';
//$cmtinsert .= '<textarea type="text" class="textarea" name="' . $business_profile['business_profile_post_comment_id'] . '" id="editcomment' . $business_profile['business_profile_post_comment_id'] . '" style="display:none;resize: none;" onClick="commentedit(this.name)">' . $business_profile['comments'] . '</textarea>';
            $cmtinsert .= '<div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="' . $business_profile['business_profile_post_comment_id'] . '"  id="editcomment' . $business_profile['business_profile_post_comment_id'] . '" placeholder="Type Message ..." onkeyup="commentedit(' . $business_profile['business_profile_post_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $business_profile['comments'] . '</div>';
            $cmtinsert .= '<span class="comment-edit-button"><button id="editsubmit' . $business_profile['business_profile_post_comment_id'] . '" style="display:none" onClick="edit_comment(' . $business_profile['business_profile_post_comment_id'] . ')">Save</button></span>';
            $cmtinsert .= '</div></div>';
//$cmtinsert .= '<input type="text" name="' . $business_profile['business_profile_post_comment_id'] . '" id="editcomment' . $business_profile['business_profile_post_comment_id'] . '"style="display:none;" value="' . $business_profile['comments'] . ' " onClick="commentedit(this.name)">';
//$cmtinsert .= '<button id="editsubmit' . $business_profile['business_profile_post_comment_id'] . '" style="display:none;" onClick="edit_comment(' . $business_profile['business_profile_post_comment_id'] . ')">Comment</button><div class="art-comment-menu-design"> <div class="comment-details-menu" id="likecomment1' . $business_profile['business_profile_post_comment_id'] . '">';

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

            $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $business_profile['business_profile_post_id'], 'status' => 1))->row()->user_id;


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

// comment count variable end 
            if (count($buscmtcnt) > 0) {
                $cntinsert .= '' . count($buscmtcnt) . '';
                $cntinsert .= '<span> Comment</span>';
            }
        }
        echo json_encode(
                array("comment" => $cmtinsert,
                    "count" => $cmtcount,
                    "comment_count" => $cntinsert
        ));
// khyati chande 
    }

    public function pninsert_comment() {

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
            'status' => 1,
            'is_delete' => 0
        );



        $insert_id = $this->common->insert_data_getid($data, 'business_profile_post_comment');


// insert notification

        if ($busdatacomment[0]['user_id'] == $userid) {
            
        } else {
            $notificationdata = array(
                'not_type' => 6,
                'not_from_id' => $userid,
                'not_to_id' => $busdatacomment[0]['user_id'],
                'not_read' => 2,
                'not_product_id' => $insert_id,
                'not_from' => 6,
                'not_img' => 1,
                'not_created_date' => date('Y-m-d H:i:s'),
                'not_active' => 1
            );
//echo "<pre>"; print_r($notificationdata); 
            $insert_id_notification = $this->common->insert_data_getid($notificationdata, 'notification');
        }
// end notoification



        $contition_array = array('business_profile_post_id' => $_POST["post_id"], 'status' => '1');
        $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = 'business_profile_post_comment_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
//echo "<pre>"; print_r($businessprofiledata); die();
// khyati changes start
        $cmtinsert = '<div class="insertcommenttwo' . $post_id . '">';
        foreach ($businessprofiledata as $business_profile) {
            $company_name = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id']))->row()->company_name;
            $business_userimage = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id'], 'status' => 1))->row()->business_user_image;

            $cmtinsert .= '<div class="all-comment-comment-box">';
            $cmtinsert .= '<div class="post-design-pro-comment-img">';
            if ($business_userimage != '') {

                if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                    $a = $companynameposted;
                    $acr = substr($a, 0, 1);

                    $cmtinsert .= '<div class="post-img-div">';
                    $cmtinsert .= ucfirst(strtolower($acr));
                    $cmtinsert .= '</div>';
                } else {
                    $cmtinsert .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) . '" alt="">';
                }
                $cmtinsert .= '</div>';
            } else {
                $a = $company_name;
                $acr = substr($a, 0, 1);

                $cmtinsert .= '<div class="post-img-div">';
                $cmtinsert .= ucfirst(strtolower($acr));
                $cmtinsert .= '</div></div>';
            }
            $cmtinsert .= '<div class="comment-name"><b>' . ucfirst(strtolower($company_name)) . '</b>';
            $cmtinsert .= '</div>';
            $cmtinsert .= '<div class="comment-details" id= "showcommenttwo' . $business_profile['business_profile_post_comment_id'] . '" >';
            $cmtinsert .= $this->common->make_links($business_profile['comments']);
            $cmtinsert .= '</div>';
            $cmtinsert .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';
            $cmtinsert .= '<div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="' . $business_profile['business_profile_post_comment_id'] . '"  id="editcommenttwo' . $business_profile['business_profile_post_comment_id'] . '" placeholder="Type Message ..."  onkeyup="commentedittwo(' . $business_profile['business_profile_post_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $business_profile['comments'] . '</div>';
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

            $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $business_profile['business_profile_post_id'], 'status' => 1))->row()->user_id;


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
// comment count variable end 
        }
        if (count($businessprofiledata) > 0) {
            $cntinsert .= '' . count($businessprofiledata) . '';
            $cntinsert .= '<span> Comment</span>';
        }

//        echo $cmtinsert;
        echo json_encode(
                array("comment" => $cmtinsert,
                    "count" => $cmtcount,
                    "comment_count" => $cntinsert
        ));

// khyati chande 
    }

//Business_profile comment delete start
    public function pndelete_comment() {
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

// khyati changes start
        if (count($businessprofiledata) > 0) {
            foreach ($businessprofiledata as $business_profile) {

                $companyname = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id']))->row()->company_name;

                $business_userimage = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id'], 'status' => 1))->row()->business_user_image;

                $cmtinsert .= '<div class="all-comment-comment-box">';
                $cmtinsert .= '<div class="post-design-pro-comment-img">';

                if ($business_userimage != '') {

                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                        $a = $companyname;
                        $acr = substr($a, 0, 1);

                        $cmtinsert .= '<div class="post-img-div">';
                        $cmtinsert .= ucfirst(strtolower($acr));
                        $cmtinsert .= '</div>';
                    } else {
                        $cmtinsert .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) . '" alt="">';
                    }
                    $cmtinsert .= '</div>';
                } else {
                    $a = $companyname;
                    $acr = substr($a, 0, 1);

                    $cmtinsert .= '<div class="post-img-div">';
                    $cmtinsert .= ucfirst(strtolower($acr));
                    $cmtinsert .= '</div></div>';
                }
                $cmtinsert .= '<div class="comment-name"><b>' . $companyname . '</b>';
                $cmtinsert .= '</div>';
                $cmtinsert .= '<div class="comment-details" id= "showcomment' . $business_profile['business_profile_post_comment_id'] . '"" >';
                $cmtinsert .= $this->common->make_links($business_profile['comments']);
                $cmtinsert .= '</div>';
                $cmtinsert .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';
                $cmtinsert .= '<div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="' . $business_profile['business_profile_post_comment_id'] . '"  id="editcomment' . $business_profile['business_profile_post_comment_id'] . '" placeholder="Type Message ..." onkeyup="commentedit(' . $business_profile['business_profile_post_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $business_profile['comments'] . '</div>';
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

                $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $business_profile['business_profile_post_id'], 'status' => 1))->row()->user_id;


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
        } else {
            $idpost = $business_profile['business_profile_post_id'];
            $cmtcount = '<a onClick="commentall(this.id)" id="' . $idpost . '">';
            $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
            $cmtcount .= '</i></a>';
        }
        echo json_encode(
                array("comment" => $cmtinsert,
                    "count" => $cmtcount,
                    "comment_count" => count($buscmtcnt)
        ));
    }

    public function pndelete_commenttwo() {
        $userid = $this->session->userdata('aileenuser');

        $post_id = $_POST["post_id"];
        $post_delete = $_POST["post_delete"];

        $data = array(
            'status' => 0,
        );
        $updatdata = $this->common->update_data($data, 'business_profile_post_comment', 'business_profile_post_comment_id', $post_id);


        $contition_array = array('business_profile_post_id' => $post_delete, 'status' => '1');
        $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = 'business_profile_post_comment_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// echo '<pre>'; print_r($businessprofiledata); die();
// khyati changes start
        if (count($businessprofiledata) > 0) {
            foreach ($businessprofiledata as $business_profile) {

                $companyname = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id']))->row()->company_name;

                $business_userimage = $this->db->get_where('business_profile', array('user_id' => $business_profile['user_id'], 'status' => 1))->row()->business_user_image;

                $cmtinsert .= '<div class="all-comment-comment-box">';
                $cmtinsert .= '<div class="post-design-pro-comment-img">';
                if ($business_userimage != '') {

                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                        $a = $companyname;
                        $acr = substr($a, 0, 1);

                        $cmtinsert .= '<div class="post-img-div">';
                        $cmtinsert .= ucfirst(strtolower($acr));
                        $cmtinsert .= '</div>';
                    } else {
                        $cmtinsert .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) . '" alt="">';
                    }
                    $cmtinsert .= '</div>';
                } else {
                    $a = $companyname;
                    $acr = substr($a, 0, 1);

                    $cmtinsert .= '<div class="post-img-div">';
                    $cmtinsert .= ucfirst(strtolower($acr));
                    $cmtinsert .= '</div></div>';
                }
                $cmtinsert .= '<div class="comment-name"><b>' . $companyname . '</b>';
                $cmtinsert .= '</div>';
                $cmtinsert .= '<div class="comment-details" id="showcommenttwo' . $business_profile['business_profile_post_comment_id'] . '">';
                $cmtinsert .= $this->common->make_links($business_profile['comments']);
                $cmtinsert .= '</div>';
                $cmtinsert .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';
//$cmtinsert .= '<textarea type="text" class="textarea" name="' . $business_profile['business_profile_post_comment_id'] . '" id="editcommenttwo' . $business_profile['business_profile_post_comment_id'] . '" style="display:none;resize: none;" onClick="commentedittwo(this.name)">' . $business_profile['comments'] . '</textarea>';
                $cmtinsert .= '<div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="' . $business_profile['business_profile_post_comment_id'] . '"  id="editcommenttwo' . $business_profile['business_profile_post_comment_id'] . '" placeholder="Type Message ..." onkeyup="commentedittwo(' . $business_profile['business_profile_post_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $business_profile['comments'] . '</div>';
                $cmtinsert .= '<span class="comment-edit-button"><button id="editsubmittwo' . $business_profile['business_profile_post_comment_id'] . '" style="display:none" onClick="edit_commenttwo(' . $business_profile['business_profile_post_comment_id'] . ')">Save</button></span>';
                $cmtinsert .= '</div></div>';
//                $cmtinsert .= '<input type="text" name="' . $business_profile['business_profile_post_comment_id'] . '" id="editcommenttwo' . $business_profile['business_profile_post_comment_id'] . '"style="display:none;" value="' . $business_profile['comments'] . ' " onClick="commentedittwo(this.name)">';
//                $cmtinsert .= '<button id="editsubmittwo' . $business_profile['business_profile_post_comment_id'] . '" style="display:none;" onClick="edit_commenttwo(' . $business_profile['business_profile_post_comment_id'] . ')">Comment</button><div class="art-comment-menu-design"> <div class="comment-details-menu" id="likecomment1' . $business_profile['business_profile_post_comment_id'] . '">';

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

                $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $business_profile['business_profile_post_id'], 'status' => 1))->row()->user_id;


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
        } else {
            $idpost = $business_profile['business_profile_post_id'];
            $cmtcount = '<a onClick="commentall1(this.id)" id="' . $idpost . '">';
            $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
            $cmtcount .= '</i></a>';
        }
        echo json_encode(
                array("comment" => $cmtinsert,
                    "count" => $cmtcount,
                    "comment_count" => count($businessprofiledata)
        ));
    }

    public function pnmulimagefourcomment() {

        $postid = $_POST['bus_img_id'];
        $mulimgfour = '<div class="insertimgcommenttwo' . $postid . '">';

        $contition_array = array('post_image_id' => $postid, 'is_delete' => '0');
        $busmulimage1 = $this->common->select_data_by_condition('bus_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');



        if ($busmulimage1) {
            foreach ($busmulimage1 as $rowdata) {
                $companyname = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id']))->row()->company_name;


                $mulimgfour .= '<div class="all-comment-comment-box">';

                $mulimgfour .= '<div class="post-design-pro-comment-img">';

                $business_userimage = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id'], 'status' => 1))->row()->business_user_image;
                if ($business_userimage != '') {

                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                        $a = $companyname;
                        $acr = substr($a, 0, 1);

                        $mulimgfour .= '<div class="post-img-div">';
                        $mulimgfour .= ucfirst(strtolower($acr));
                        $mulimgfour .= '</div>';
                    } else {

                        $mulimgfour .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) . '"  alt="">';
                    }

                    $mulimgfour .= '</div>';
                } else {
                    $a = $companyname;
                    $acr = substr($a, 0, 1);

                    $mulimgfour .= '<div class="post-img-div">';
                    $mulimgfour .= ucfirst(strtolower($acr));
                    $mulimgfour .= '</div>';
                    $mulimgfour .= '</div>';
                }
                $mulimgfour .= '<div class="comment-name"><b>';
                $mulimgfour .= '' . ucfirst(strtolower($companyname)) . '</br></b></div>';
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
                $contition_array = array('post_image_comment_id' => $rowdata['post_image_comment_id'], 'user_id' => $userid, 'is_unlike' => 0);

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

                $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $rowdata['post_image_id'], 'status' => 1))->row()->user_id;

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
            $business_fname = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
            $bus_image = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->business_user_image;
            $bus_ind = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->industriyal;

            $bus_cat = $this->db->get_where('industry_type', array('industry_id' => $bus_ind, 'status' => 1))->row()->industry_name;
            if ($bus_cat) {
                $category = $bus_cat;
            } else {
                $category = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->other_industrial;
            }
            $modal .= '<li>';
            $modal .= '<div class="like_user_listq">';
            $modal .= '<a href="' . base_url('business_profile/business_resume/' . $bus_slug) . '" title="' . $business_fname1 . '" class="head_main_name" >';
            $modal .= '<div class="like_user_list_img">';
            if ($bus_image) {

                if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $bus_image)) {
                    $a = $business_fname;
                    $acr = substr($a, 0, 1);

                    $modal .= '<div class="post-img-div">';
                    $modal .= ucfirst(strtolower($acr));
                    $modal .= '</div>';
                } else {
                    $modal .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $bus_image) . '"  alt="">';
                }
            } else {
                $a = $business_fname;
                $acr = substr($a, 0, 1);

                $modal .= '<div class="post-img-div">';
                $modal .= ucfirst(strtolower($acr));
                $modal .= '</div>';
            }
            $modal .= '</div>';
            $modal .= '<div class="like_user_list_main_desc">';
            $modal .= '<div class="like_user_list_main_name">';
            $modal .= '' . ucfirst(strtolower($business_fname)) . '';
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
//            $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
//            echo '<div class="likeuser_list"><a href="' . base_url('business_profile/business_resume/' . $bus_slug) . '">';
//            echo ucwords($business_fname1);
//            echo '</a></div>';
//        }
//        echo '<div>';

        echo $modal;
    }

    public function imglikeuserlist() {
        $post_id = $_POST['post_id'];

        $contition_array = array('post_image_id' => $post_id, 'is_unlike' => '0');
        $commneteduser = $this->common->select_data_by_condition('bus_post_image_like', $contition_array, $data = 'user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $modal = '<div class="modal-header">';
        $modal .= '<button type="button" class="close" data-dismiss="modal">&times;</button>';
        $modal .= '<h4 class="modal-title">';

        $modal .= '' . count($commneteduser) . ' Likes';

        $modal .= '</h4></div>';
        $modal .= '<div class="modal-body padding_less_right">';
        $modal .= '<div class="like_user_list">';
        $modal .= '<ul>';
        foreach ($commneteduser as $userlist) {

            $bus_slug = $this->db->get_where('business_profile', array('user_id' => $userlist['user_id']))->row()->business_slug;
            $business_fname = $this->db->get_where('business_profile', array('user_id' => $userlist['user_id'], 'status' => 1))->row()->company_name;
            $bus_image = $this->db->get_where('business_profile', array('user_id' => $userlist['user_id'], 'status' => 1))->row()->business_user_image;
            $bus_ind = $this->db->get_where('business_profile', array('user_id' => $userlist['user_id'], 'status' => 1))->row()->industriyal;

            $bus_cat = $this->db->get_where('industry_type', array('industry_id' => $bus_ind, 'status' => 1))->row()->industry_name;
            if ($bus_cat) {
                $category = $bus_cat;
            } else {
                $category = $this->db->get_where('business_profile', array('user_id' => $userlist['user_id'], 'status' => 1))->row()->other_industrial;
            }
            $modal .= '<li>';
            $modal .= '<div class="like_user_listq">';
            $modal .= '<a href="' . base_url('business_profile/business_resume/' . $bus_slug) . '" title="' . $business_fname1 . '" class="head_main_name" >';
            $modal .= '<div class="like_user_list_img">';
            if ($bus_image) {

                if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $bus_image)) {
                    $a = $business_fname;
                    $acr = substr($a, 0, 1);

                    $modal .= '<div class="post-img-div">';
                    $modal .= ucfirst(strtolower($acr));
                    $modal .= '</div>';
                } else {

                    $modal .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $bus_image) . '"  alt="">';
                }
            } else {
                $a = $business_fname;
                $acr = substr($a, 0, 1);

                $modal .= '<div class="post-img-div">';
                $modal .= ucfirst(strtolower($acr));
                $modal .= '</div>';
            }
            $modal .= '</div>';
            $modal .= '<div class="like_user_list_main_desc">';
            $modal .= '<div class="like_user_list_main_name">';
            $modal .= '' . ucfirst(strtolower($business_fname)) . '';
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
        $modal .= '<div class="modal-footer">';
        $modal .= '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
        $modal .= '</div>';



        echo $modal;

//        echo '<div class="likeduser">';
//        echo '<div class="likeduser-title">User List</div>';
//        foreach ($commneteduser as $userlist) {
//            $bus_slug = $this->db->get_where('business_profile', array('user_id' => $userlist['user_id']))->row()->business_slug;
//
//            $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $userlist['user_id'], 'status' => 1))->row()->company_name;
//            echo '<div class="likeuser_list"><a href="' . base_url('business_profile/business_resume/' . $bus_slug) . '">';
//            echo ucwords($business_fname1);
//            echo '</a></div>';
//        }
//        echo '<div>';
    }

    public function bus_img_delete() {
        $grade_id = $_POST['grade_id'];
        $delete_data = $this->common->delete_data('bus_image', 'image_id', $grade_id);
        if ($delete_data) {
            echo 'ok';
        }
    }

    public function contact_person() {
        $to_id = $_POST['toid'];
        $userid = $this->session->userdata('aileenuser');

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

                $contactdata = '<a href="#" onclick="return contact_person(' . $to_id . ');" style="cursor: pointer;">';
                $contactdata .= '<div>   
                                                            <div class="add-contact">
                                                             <div></div>
                                                            <div></div>
                                                            <div></div>
                                                            <div><span class="cancel_req_busi">   <img src="' . base_url('assets/img/icon_contact_add.png') . '"></span></div>

                                                            </div>
                                                            

                                                            <div class="addtocont">
                                                    <span class="ft-13"><i class="icon-user"></i>
                                                       Add to contact </span>
                                                    </div> 

                                                </div>';
                $contactdata .= '</a>';
            } elseif ($status == 'cancel') {
                $data = array(
                    'contact_from_id' => $userid,
                    'contact_to_id' => $to_id,
                    'contact_type' => 2,
                    'created_date' => date('Y-m-d H:i:s'),
                    'status' => 'pending',
                    'not_read' => 2
                );


                $updatdata = $this->common->update_data($data, 'contact_person', 'contact_id', $contact_id);
                $contactdata = '<a href="#" onclick="return contact_person_model(' . $to_id . "," . "'" . 'pending' . "'" . ');" style="cursor: pointer;">';
                $contactdata .= '<div class="cance_req_main_box">   
                                                            <div class="add-contact">
                                                             <div></div>
                                                            <div></div>
                                                            <div></div>
                                                            <div>
                                                         <span class="cancel_req_busi"><img src="' . base_url('assets/img/icon_contact_cancel.png') . '"></span>
                                                            </div>

                                                            </div>
                                                            

                                                            <div class="addtocont">
                                                    <span class="ft-13 cl_haed_s">
                                                      Cancel request </span>
                                                    </div> 

                                                </div>
';
                $contactdata .= '</a>';
            } elseif ($status == 'confirm') {
                $data = array(
                    'created_date' => date('Y-m-d H:i:s'),
                    'status' => 'cancel'
                );


                $updatdata = $this->common->update_data($data, 'contact_person', 'contact_id', $contact_id);
                $contactdata = '<a href="#" onclick="return contact_person(' . $to_id . ');" style="cursor: pointer;">';
                $contactdata .= '<div>   
                                                            <div class="add-contact">
                                                             <div></div>
                                                            <div></div>
                                                            <div></div>
                                                            <div><span class="cancel_req_busi"><img src="' . base_url('assets/img/icon_contact_add.png') . '"></span></div>

                                                            </div>
                                                            

                                                            <div class="addtocont">
                                                    <span class="ft-13"><i class="icon-user"></i>
                                                       Add to contact </span>
                                                    </div> 

                                                </div>';
                $contactdata .= '</a>';
            } elseif ($status == 'reject') {
                $data = array(
                    'contact_from_id' => $userid,
                    'contact_to_id' => $to_id,
                    'contact_type' => 2,
                    'created_date' => date('Y-m-d H:i:s'),
                    'status' => 'pending',
                    'not_read' => 2
                );

                $updatdata = $this->common->update_data($data, 'contact_person', 'contact_id', $contact_id);
                $contactdata = '<a href="#" onclick="return contact_person_model(' . $to_id . "," . "'" . 'pending' . "'" . ');" style="cursor: pointer;">';
                $contactdata .= '<div class="cance_req_main_box">   
                                                            <div class="add-contact">
                                                             <div></div>
                                                            <div></div>
                                                            <div></div>
                                                            <div>
                                                         <span class="cancel_req_busi">   <img src="' . base_url('assets/img/icon_contact_cancel.png') . '"></span>
                                                            </div>

                                                            </div>
                                                            

                                                            <div class="addtocont">
                                                    <span class="ft-13 cl_haed_s">
                                                      Cancel request </span>
                                                    </div> 

                                                </div>';
                $contactdata .= '</a>';
            }
        } else {

            $data = array(
                'contact_from_id' => $userid,
                'contact_to_id' => $to_id,
                'contact_type' => 2,
                'created_date' => date('Y-m-d H:i:s'),
                'status' => 'pending',
                'not_read' => 2
            );

// echo "<pre>"; print_r($data); die();

            $insert_id = $this->common->insert_data_getid($data, 'contact_person');

            $contactdata = '<a href="#" onclick="return contact_person_model(' . $to_id . "," . "'" . 'pending' . "'" . ');" style="cursor: pointer;">';
            $contactdata .= '<div class="cance_req_main_box">   
                                                            <div class="add-contact">
                                                             <div></div>
                                                            <div></div>
                                                            <div></div>
                                                            <div>
                                                         <span class="cancel_req_busi"><img src="' . base_url('assets/img/icon_contact_cancel.png') . '"></span>
                                                            </div>

                                                            </div>
                                                            

                                                            <div class="addtocont">
                                                    <span class="ft-13 cl_haed_s">
                                                      Cancel request </span>
                                                    </div> 

                                                </div>';
            $contactdata .= '</a>';
        }

        echo $contactdata;
    }

    public function contact_notification() {

        $userid = $this->session->userdata('aileenuser');

//if user deactive profile then redirect to business_profile/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_deleted' => '0');

        $business_deactive = $this->data['business_deactive'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($business_deactive) {
            redirect('business_profile/');
        }
//if user deactive profile then redirect to business_profile/index untill active profile End

        $contition_array = array('contact_to_id' => $userid, 'status' => 'pending');
        $contactperson_req = $this->common->select_data_by_condition('contact_person', $contition_array, $data = '*', $sortby = 'contact_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('contact_from_id' => $userid, 'status' => 'confirm');
        $contactperson_con = $this->common->select_data_by_condition('contact_person', $contition_array, $data = '*', $sortby = 'contact_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        $unique_user = array_merge($contactperson_req, $contactperson_con);


        $new = array();
        foreach ($unique_user as $value) {
            $new[$value['contact_id']] = $value;
        }

        $post = array();

        foreach ($new as $key => $row) {

            $post[$key] = $row['contact_id'];
        }
        array_multisort($post, SORT_DESC, $new);

        $contactperson = $new;

//echo "<pre>"; print_r($contactperson); die();


        if ($contactperson) {
            foreach ($contactperson as $contact) {


//echo $busdata[0]['industriyal'];  echo '<pre>'; print_r($inddata); die();
                $contactdata .= '<ul id="' . $contact['contact_id'] . '">';

                if ($contact['contact_to_id'] == $userid) {


                    $contition_array = array('user_id' => $contact['contact_from_id'], 'status' => '1');
                    $contactperson_from = $this->common->select_data_by_condition('user', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    if ($contactperson_from) {


                        $busdata = $this->common->select_data_by_id('business_profile', 'user_id', $contact['contact_from_id'], $data = '*', $join_str = array());
                        $inddata = $this->common->select_data_by_id('industry_type', 'industry_id', $busdata[0]['industriyal'], $data = '*', $join_str = array());

                        $contactdata .= '<li>';
                        $contactdata .= '<div class="addcontact-left">';
                        $contactdata .= '<a href="' . base_url('business_profile/business_profile_manage_post/' . $busdata[0]['business_slug']) . '">';
                        $contactdata .= '<div class="addcontact-pic">';

                        if ($busdata[0]['business_user_image']) {

                            if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $busdata[0]['business_user_image'])) {
                                $a = $busdata[0]['company_name'];
                                $acr = substr($a, 0, 1);

                                $contactdata .= '<div class="post-img-div">';
                                $contactdata .= ucfirst(strtolower($acr));
                                $contactdata .= '</div>';
                            } else {

                                $contactdata .= '<img src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $busdata[0]['business_user_image']) . '">';
                            }
                        } else {
                            $a = $busdata[0]['company_name'];
                            $acr = substr($a, 0, 1);

                            $contactdata .= '<div class="post-img-div">';
                            $contactdata .= ucfirst(strtolower($acr));
                            $contactdata .= '</div>';
                        }
                        $contactdata .= '</div>';
                        $contactdata .= '<div class="addcontact-text">';
                        $contactdata .= '<span><b>' . ucfirst(strtolower($busdata[0]['company_name'])) . '</b></span>';
                        $contactdata .= '' . $inddata[0]['industry_name'] . '';
                        $contactdata .= '</div>';
                        $contactdata .= '</a>';
                        $contactdata .= '</div>';
                        $contactdata .= '<div class="addcontact-right">';
                        $contactdata .= '<a href="#"  onclick = "return contactapprove(' . $contact['contact_from_id'] . ', 1);"><i class="fa fa-check" aria-hidden="true"></i></a>';
                        $contactdata .= '<a href="#"  onclick = "return contactapprove(' . $contact['contact_from_id'] . ', 0);"><i class="fa fa-times" aria-hidden="true"></i></a>';
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
                        $contactdata .= '<div class="addcontact-left">';
                        $contactdata .= '<a href="' . base_url('business_profile/business_profile_manage_post/' . $busdata[0]['business_slug']) . '">';
                        $contactdata .= '<div class="addcontact-pic">';

                        if ($busdata[0]['business_user_image']) {

                            if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $busdata[0]['business_user_image'])) {
                                $a = $busdata[0]['company_name'];
                                $acr = substr($a, 0, 1);

                                $contactdata .= '<div class="post-img-div">';
                                $contactdata .= ucfirst(strtolower($acr));
                                $contactdata .= '</div>';
                            } else {

                                $contactdata .= '<img src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $busdata[0]['business_user_image']) . '">';
                            }
                        } else {
                            $a = $busdata[0]['company_name'];
                            $acr = substr($a, 0, 1);

                            $contactdata .= '<div class="post-img-div">';
                            $contactdata .= ucfirst(strtolower($acr));
                            $contactdata .= '</div>';
                        }
                        $contactdata .= '</div>';
                        $contactdata .= '<div class="addcontact-text">';
                        $contactdata .= '<span><b>' . ucfirst(strtolower($busdata[0]['company_name'])) . '</b> confirmed your contact request</span>';
//$contactdata .= '' . $inddata[0]['industry_name'] . '';
                        $contactdata .= '</div>';
                        $contactdata .= '</a>';
                        $contactdata .= '</div>';
                        $contactdata .= '</li>';
                    }
                }
                $contactdata .= '</ul>';
            }
        } else {

            $contactdata = '<ul>';
            $contactdata .= '<li>';
            $contactdata .= '<div class="addcontact-left">';
            $contactdata .= '<a href="#">';
            $contactdata .= '<div class="addcontact-text">';
            $contactdata .= 'No Contact Request available...';
            $contactdata .= '</div>';
            $contactdata .= '</a>';
            $contactdata .= '</div>';
            $contactdata .= '</div>';
            $contactdata .= '</li>';
            $contactdata .= '</ul>';
        }
        echo $contactdata;
    }

    public function contact_approve() {

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
                'status' => 'confirm',
                'not_read' => 2
            );

            $updatdata = $this->common->update_data($data, 'contact_person', 'contact_id', $contactid);
        } else {

            $data = array(
                'modify_date' => date('Y-m-d', time()),
                'status' => 'reject'
            );

            $updatdata = $this->common->update_data($data, 'contact_person', 'contact_id', $contactid);
        }

        $contition_array = array('contact_to_id' => $userid, 'status' => 'pending');
        $contactperson_req = $this->common->select_data_by_condition('contact_person', $contition_array, $data = '*', $sortby = 'contact_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        $contition_array = array('contact_from_id' => $userid, 'status' => 'confirm');
        $contactperson_con = $this->common->select_data_by_condition('contact_person', $contition_array, $data = '*', $sortby = 'contact_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $unique_user = array_merge($contactperson_req, $contactperson_con);

        $new = array();
        foreach ($unique_user as $value) {
            $new[$value['contact_id']] = $value;
        }

        $post = array();

        foreach ($new as $key => $row) {

            $post[$key] = $row['contact_id'];
        }
        array_multisort($post, SORT_DESC, $new);

        $contactperson = $new;


        if ($contactperson) {
            foreach ($contactperson as $contact) {


//echo $busdata[0]['industriyal'];  echo '<pre>'; print_r($inddata); die();
                $contactdata .= '<ul id="' . $contact['contact_id'] . '">';

                if ($contact['contact_to_id'] == $userid) {


                    $busdata = $this->common->select_data_by_id('business_profile', 'user_id', $contact['contact_from_id'], $data = '*', $join_str = array());
                    $inddata = $this->common->select_data_by_id('industry_type', 'industry_id', $busdata[0]['industriyal'], $data = '*', $join_str = array());


                    $contactdata .= '<li>';
                    $contactdata .= '<div class="addcontact-left">';
                    $contactdata .= '<a href="#">';
                    $contactdata .= '<div class="addcontact-pic">';

                    if ($busdata[0]['business_user_image']) {
                        $contactdata .= '<img src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $busdata[0]['business_user_image']) . '">';
                    } else {
                        $contactdata .= '<img src="' . base_url(WHITEIMAGE) . '">';
                    }
                    $contactdata .= '</div>';
                    $contactdata .= '<div class="addcontact-text">';
                    $contactdata .= '<span><b>' . $busdata[0]['company_name'] . '</b></span>';
                    $contactdata .= '' . $inddata[0]['industry_name'] . '';
                    $contactdata .= '</div>';
                    $contactdata .= '</a>';
                    $contactdata .= '</div>';
                    $contactdata .= '<div class="addcontact-right">';
                    $contactdata .= '<a href="#" class="add-left-true" onclick = "return contactapprove(' . $contact['contact_from_id'] . ', 1);"><i class="fa fa-check" aria-hidden="true"></i></a>';
                    $contactdata .= '<a href="#"  class="add-right-true" onclick = "return contactapprove(' . $contact['contact_from_id'] . ', 0);"><i class="fa fa-times" aria-hidden="true"></i></a>';
                    $contactdata .= '</div>';
                    $contactdata .= '</li>';
                } else {

                    $busdata = $this->common->select_data_by_id('business_profile', 'user_id', $contact['contact_to_id'], $data = '*', $join_str = array());


                    $inddata = $this->common->select_data_by_id('industry_type', 'industry_id', $busdata[0]['industriyal'], $data = '*', $join_str = array());

                    $contactdata .= '<li>';
                    $contactdata .= '<div class="addcontact-left">';
                    $contactdata .= '<a href="' . base_url('business_profile/business_profile_manage_post/' . $busdata[0]['business_slug']) . '">';
                    $contactdata .= '<div class="addcontact-pic">';

                    if ($busdata[0]['business_user_image']) {

                        if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $busdata[0]['business_user_image'])) {
                            $a = $busdata[0]['company_name'];
                            $acr = substr($a, 0, 1);

                            $contactdata .= '<div class="post-img-div">';
                            $contactdata .= ucfirst(strtolower($acr));
                            $contactdata .= '</div>';
                        } else {

                            $contactdata .= '<img src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $busdata[0]['business_user_image']) . '">';
                        }
                    } else {
                        $a = $busdata[0]['company_name'];
                        $acr = substr($a, 0, 1);

                        $contactdata .= '<div class="post-img-div">';
                        $contactdata .= ucfirst(strtolower($acr));
                        $contactdata .= '</div>';
                    }
                    $contactdata .= '</div>';
                    $contactdata .= '<div class="addcontact-text">';
                    $contactdata .= '<span><b>' . ucfirst(strtolower($busdata[0]['company_name'])) . '</b> confirmed your contact request</span>';
//$contactdata .= '' . $inddata[0]['industry_name'] . '';
                    $contactdata .= '</div>';
                    $contactdata .= '</a>';
                    $contactdata .= '</div>';
                    $contactdata .= '</li>';
                }
                $contactdata .= '</ul>';
            }
        } else {

            $contactdata = '<ul>';
            $contactdata .= '<li>';
            $contactdata .= '<div class="addcontact-left">';
            $contactdata .= '<a href="#">';
            $contactdata .= '<div class="addcontact-text">';
            $contactdata .= 'Not data available...';
            $contactdata .= '</div>';
            $contactdata .= '</a>';
            $contactdata .= '</div>';
            $contactdata .= '</div>';
            $contactdata .= '</li>';
            $contactdata .= '</ul>';
        }
        echo $contactdata;
    }

    public function contact_list() {

        $userid = $this->session->userdata('aileenuser');

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
        $friendlist_con = $this->data['friendlist_con'] = $this->common->select_data_by_condition('contact_person', $contition_array, $data = '*', $sortby = 'contact_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str, $groupby = '');


        $this->data['friendlist'] = array_merge($friendlist_con, $friendlist_req);

        $this->load->view('business_profile/contact_list', $this->data);
    }

    public function contact_list_approve() {

        $toid = $_POST['toid'];
        $status = $_POST['status'];
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('contact_from_id' => $toid, 'contact_to_id' => $userid, 'status' => 'pending');
        $person = $this->common->select_data_by_condition('contact_person', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $contactid = $person[0]['contact_id'];
        if ($status == 1) {
            $data = array(
                'modify_date' => date('Y-m-d', time()),
                'status' => 'confirm'
            );

            $updatdata = $this->common->update_data($data, 'contact_person', 'contact_id', $contactid);
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
                $contactdata .= '<li id="' . $friend['contact_from_id'] . '">';
                $contactdata .= '<div class="list-box">';
                $contactdata .= '<div class="profile-img">';
                if ($busdata[0]['business_user_image'] != '') {

                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $busdata[0]['business_user_image'])) {
                        $a = $busdata[0]['company_name'];
                        $acr = substr($a, 0, 1);

                        $contactdata .= '<div class="post-img-div">';
                        $contactdata .= ucfirst(strtolower($acr));
                        $contactdata .= '</div>';
                    } else {

                        $contactdata .= '<img src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $busdata[0]['business_user_image']) . '">';
                    }
                } else {
                    $a = $busdata[0]['company_name'];
                    $acr = substr($a, 0, 1);

                    $contactdata .= '<div class="post-img-div">';
                    $contactdata .= ucfirst(strtolower($acr));
                    $contactdata .= '</div>';
                }

                $contactdata .= '</div>';
                $contactdata .= '<div class="profile-content">';
                $contactdata .= '<a href="' . base_url('business_profile/business_profile_manage_post/' . $busdata[0]['business_slug']) . '">';
                $contactdata .= '<h5>' . $busdata[0]['company_name'] . '</h5>';
                $contactdata .= '<p>' . $inddata[0]['industry_name'] . '</p>';
                $contactdata .= '</a>';
                $contactdata .= '<p class="connect-link">';
                $contactdata .= '<a href="#" onclick = "return contactapprove(' . $contact['contact_from_id'] . ', 1);"><i class="fa fa-check" aria-hidden="true"></i></a>';
                $contactdata .= '<a href="#" onclick = "return contactapprove(' . $contact['contact_from_id'] . ', 0);"><i class="fa fa-times" aria-hidden="true"></i></a>';
                $contactdata .= '</p>';
                $contactdata .= '</div>';
                $contactdata .= '</div>';
                $contactdata .= '</li>';
            }
        } else {
            $contactdata = 'No contacts available...';
        }
        echo $contactdata;
    }

    public function bus_contact($id = "") {

        $this->data['login'] = $login = $this->session->userdata('aileenuser');
        $contition_array = array('user_id' => $login, 'is_deleted' => 0, 'status' => 1);

        $contition_array = array('user_id' => $login, 'status' => '1');
        $this->data['slug_data'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $slug_id = $this->data['slug_data'][0]['business_slug'];


        if ($id == $slug_id || $id == '') {

            $this->data['busuid'] = $busuid = $this->session->userdata('aileenuser');

            $contition_array = array('user_id' => $busuid, 'is_deleted' => 0, 'status' => 1);

            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $slugid = $businessdata1[0]['business_slug'];

            $contition_array = array('contact_person.status' => 'confirm', 'contact_type' => 2);

            $search_condition = "(contact_to_id = '$busuid' OR contact_from_id = '$busuid')";

            $this->data['unique_user'] = $unique_user = $this->common->select_data_by_search('contact_person', $search_condition, $contition_array, $data = '*', $sortby = 'contact_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = '', $groupby = '');
        } else {


            $contition_array = array('business_slug' => $id, 'is_deleted' => 0, 'status' => 1, 'business_step' => 4);

            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $busuid = $this->data['busuid'] = $businessdata1[0]['user_id'];

            $contition_array = array('contact_person.status' => 'confirm', 'contact_type' => 2);

            $search_condition = "(contact_to_id = '$busuid' OR contact_from_id = '$busuid')";

            $this->data['unique_user'] = $unique_user = $this->common->select_data_by_search('contact_person', $search_condition, $contition_array, $data = '*', $sortby = 'contact_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = '', $groupby = '');

//   echo '<pre>'; print_r($unique_user); die();
        }

        $contition_array = array('status' => '1', 'is_deleted' => '0', 'business_step' => 4);


        $businessdata = $this->data['results'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'company_name,other_industrial,other_business_type', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
// echo "<pre>";print_r($businessdata);die();


        $contition_array = array('status' => '1', 'is_delete' => '0');


        $businesstype = $this->data['results'] = $this->common->select_data_by_condition('business_type', $contition_array, $data = 'business_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
// echo "<pre>";print_r($businesstype);

        $contition_array = array('status' => '1', 'is_delete' => '0');


        $industrytype = $this->data['results'] = $this->common->select_data_by_condition('industry_type', $contition_array, $data = 'industry_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
// echo "<pre>";print_r($industrytype);die();
        $unique = array_merge($businessdata, $businesstype, $industrytype);
        foreach ($unique as $key => $value) {
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

        $contition_array = array('status' => '1');
        $citiesss = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);


        foreach ($citiesss as $key1) {

            $location[] = $key1['city_name'];
        }
// echo "<pre>"; print_r($location);die();
        foreach ($location as $key => $value) {
            $loc[$key]['label'] = $value;
            $loc[$key]['value'] = $value;
        }

//echo "<pre>"; print_r($loc);die();
// echo "<pre>"; print_r($loc);
// echo "<pre>"; print_r($result1);die();

        $this->data['city_data'] = $loc;
        $this->data['demo'] = array_values($result1);



//echo "<pre>"; print_r($unique_user); die();
        $this->load->view('business_profile/bus_contact', $this->data);
    }

    public function removecontactuser() {


        $to_id = $_POST["contact_id"];
        $showdata = $_POST["showdata"];

        $userid = $this->session->userdata('aileenuser');


        $contition_array = array('contact_type' => 2);

        $search_condition = "((contact_to_id = ' $to_id' AND contact_from_id = ' $userid') OR (contact_from_id = ' $to_id' AND contact_to_id = '$userid'))";

        $contactperson = $this->common->select_data_by_search('contact_person', $search_condition, $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = '', $groupby = '');

        $contact_id = $contactperson[0]['contact_id'];

        $contition_array = array('user_id' => $userid, 'is_deleted' => 0, 'status' => 1);

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

        $contition_array = array('contact_person.status' => 'confirm', 'contact_type' => 2);

        $search_condition = "(contact_to_id = '$userid' OR contact_from_id = '$userid')";

        $unique_user = $this->common->select_data_by_search('contact_person', $search_condition, $contition_array, $data = '*', $sortby = 'contact_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = '', $groupby = '');

        $datacount = count($unique_user);
//for count list user end

        $contactdata = '<button onClick="contact_person_menu(' . $to_id . ')">';

        $contactdata .= ' Add to contact';
        $contactdata .= '</button>';


        if (count($unique_user) == 0) {
            $nomsg = ' <div class="art-img-nn">
                                    <div class="art_no_post_img">

                                        <img src="' . base_url('assets/img/bui-no.png') . '">

                                    </div>
                                    <div class="art_no_post_text">
                                        No Contacts Available.
                                    </div>
                                </div>
                            ';
        }


        if ($showdata == $businessdata1[0]['business_slug']) {
            echo json_encode(
                    array("contactdata" => $contactdata,
                        "notfound" => 1,
                        "notcount" => $datacount,
                        "nomsg" => $nomsg,
            ));
        } else {
            echo json_encode(
                    array("contactdata" => $contactdata,
                        "notfound" => 2,
                        "notcount" => $datacount,
                        "nomsg" => $nomsg,
            ));
        }
    }

// for contact list function start


    public function contact_person_menu() {

        $to_id = $_POST['toid'];
        $userid = $this->session->userdata('aileenuser');


        $contition_array = array('contact_type' => 2);

        $search_condition = "((contact_to_id = ' $to_id' AND contact_from_id = ' $userid') OR (contact_from_id = ' $to_id' AND contact_to_id = '$userid'))";

        $contactperson = $this->common->select_data_by_search('contact_person', $search_condition, $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = '', $groupby = '');

        if ($contactperson) {

            $status = $contactperson[0]['status'];
            $contact_id = $contactperson[0]['contact_id'];

            if ($status == 'pending') {
                $data = array(
                    'modify_date' => date('Y-m-d H:i:s'),
                    'status' => 'cancel'
                );

                $updatdata = $this->common->update_data($data, 'contact_person', 'contact_id', $contact_id);

                $contactdata = '<button onClick="contact_person_menu(' . $to_id . ')">';
                $contactdata .= ' Add to contact';
                $contactdata .= '</button>';
            } elseif ($status == 'cancel') {
                $data = array(
                    'created_date' => date('Y-m-d H:i:s'),
                    'status' => 'pending',
                    'not_read' => 2
                );


                $updatdata = $this->common->update_data($data, 'contact_person', 'contact_id', $contact_id);

                $contactdata = '<button onClick="contact_person_cancle(' . $to_id . "," . "'" . 'pending' . "'" . ')">';


                $contactdata .= 'Cancel request';
                $contactdata .= '</button>';
            } elseif ($status == 'reject') {
                $data = array(
                    'created_date' => date('Y-m-d H:i:s'),
                    'status' => 'pending',
                    'not_read' => 2
                );


                $updatdata = $this->common->update_data($data, 'contact_person', 'contact_id', $contact_id);

                $contactdata = '<button onClick="contact_person_cancle(' . $to_id . "," . "'" . 'pending' . "'" . ')">';


                $contactdata .= 'Cancel request';
                $contactdata .= '</button>';
            }
        } else {

            $data = array(
                'contact_from_id' => $userid,
                'contact_to_id' => $to_id,
                'contact_type' => 2,
                'created_date' => date('Y-m-d H:i:s'),
                'status' => 'pending',
                'not_read' => 2
            );

// echo "<pre>"; print_r($data); die();

            $insert_id = $this->common->insert_data_getid($data, 'contact_person');

            $contactdata = '<button onClick="contact_person_cancle(' . $to_id . "," . "'" . 'pending' . "'" . ')">';
            $contactdata .= 'Cancel request';
            $contactdata .= '</button>';
        }

        echo $contactdata;
    }

//contact list end
//conatct request count start

    public function contact_count() {

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('contact_to_id' => $userid, 'status' => 'pending', 'not_read' => '2');
        $contactperson_req = $this->common->select_data_by_condition('contact_person', $contition_array, $data = '*', $sortby = 'contact_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('contact_from_id' => $userid, 'status' => 'confirm', 'not_read' => '2');
        $contactperson_con = $this->common->select_data_by_condition('contact_person', $contition_array, $data = '*', $sortby = 'contact_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $unique_user = array_merge($contactperson_req, $contactperson_con);

        $contactcount = count($unique_user);

        echo $contactcount;
    }

    public function update_contact_count() {
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('not_read' => 2, 'contact_to_id' => $userid, 'status' => 'pending');
        $result_req = $this->common->select_data_by_condition('contact_person', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('not_read' => 2, 'contact_from_id' => $userid, 'status' => 'confirm');
        $result_con = $this->common->select_data_by_condition('contact_person', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $result = array_merge($result_req, $result_con);
        $data = array(
            'not_read' => 1
        );

        foreach ($result as $cnt) {
            $updatedata = $this->common->update_data($data, 'contact_person', 'contact_id', $cnt['contact_id']);
        }
        $count = count($updatedata);
        echo $count;
    }

//contact request count end


    public function edit_more_insert() {

        $userid = $this->session->userdata('aileenuser');

        $post_id = $_POST["business_profile_post_id"];

        $contition_array = array('business_profile_post_id' => $_POST["business_profile_post_id"], 'status' => '1');
        $businessdata = $this->data['businessdata'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($this->data['businessdata'][0]['product_description']) {

            $editpostdes .= $this->data['businessdata'][0]['product_description'];
        }
        echo json_encode(
                array(
                    "description" => $editpostdes
        ));
    }

    public function business_home_post() {
// return html

        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;

        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_deleted' => '0');
        $business_deactive = $this->data['business_deactive'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($business_deactive) {
            redirect('business-profile/');
        }
        $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['businessdata'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $business_profile_id = $this->data['businessdata'][0]['business_profile_id'];
        $contition_array = array('is_deleted' => 0, 'status' => 1, 'user_id !=' => $userid, 'business_step' => 4);
        $userlist = $this->data['userlist'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = 'business_profile_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $industriyal = $this->data['businessdata'][0]['industriyal'];
        foreach ($userlist as $rowcategory) {
            if ($industriyal == $rowcategory['industriyal']) {
                $userlistcategory[] = $rowcategory;
            }
        }

        $this->data['userlistview1'] = $userlistcategory;

        $businessregcity = $this->data['businessdata'][0]['city'];
        $contition_array = array('is_deleted' => 0, 'status' => 1, 'user_id !=' => $userid, 'industriyal !=' => $industriyal, 'business_step' => 4);
        $userlist2 = $this->data['userlist2'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = 'business_profile_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        foreach ($userlist2 as $rowcity) {
            if ($businessregcity == $rowcity['city']) {
                $userlistcity[] = $rowcity;
            }
        }

        $this->data['userlistview2'] = $userlistcity;

        $businessregstate = $this->data['businessdata'][0]['state'];

        $contition_array = array('is_deleted' => 0, 'status' => 1, 'user_id !=' => $userid, 'industriyal !=' => $industriyal, 'city !=' => $businessregcity, 'business_step' => 4);
        $userlist3 = $this->data['userlist3'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = 'business_profile_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        foreach ($userlist3 as $rowstate) {
            if ($businessregstate == $rowstate['state']) {
                $userliststate[] = $rowstate;
            }
        }
        $this->data['userlistview3'] = $userliststate;

        $contition_array = array('is_deleted' => 0, 'status' => 1, 'user_id !=' => $userid, 'industriyal !=' => $industriyal, 'city !=' => $businessregcity, 'state !=' => $businessregstate, 'business_step' => 4);
        $userlastview = $this->data['userlastview'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = 'business_profile_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        $this->data['userlistview4'] = $userlastview;

        $contition_array = array('follow_from' => $business_profile_id, 'follow_status' => '1', 'follow_type' => '2');
        $followerdata = $this->data['followerdata'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        foreach ($followerdata as $fdata) {
            $contition_array = array('business_profile_id' => $fdata['follow_to'], 'business_step' => 4);
            $this->data['business_data'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $business_userid = $this->data['business_data'][0]['user_id'];
            $contition_array = array('user_id' => $business_userid, 'status' => '1', 'is_delete' => '0');
            $this->data['business_profile_data'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $followerabc[] = $this->data['business_profile_data'];
        }
        $userselectindustriyal = $this->data['businessdata'][0]['industriyal'];

        $contition_array = array('industriyal' => $userselectindustriyal, 'status' => '1', 'business_step' => 4);
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
        $businessprofiledatapost = $new;
        $return_html = '';

        $businessprofiledatapost1 = array_slice($businessprofiledatapost, $start, $perpage);

        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($businessprofiledatapost1);
        }

        $return_html .= '<input type="hidden" class="page_number" value="' . $page . '" />';
        $return_html .= '<input type="hidden" class="total_record" value="' . $_GET["total_record"] . '" />';

        if (count($businessprofiledatapost) > 0) {
//$row = $businessprofiledatapost[0];

            foreach ($businessprofiledatapost1 as $row) {
                $userid = $this->session->userdata('aileenuser');
                $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1');
                $businessdelete = $this->data['businessdelete'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $contition_array = array('user_id' => $row['user_id'], 'status' => '1');
                $businessdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $likeuserarray = explode(',', $businessdelete[0]['delete_post']);


                if (!in_array($userid, $likeuserarray)) {

                    $return_html .= '<div id="removepost' . $row['business_profile_post_id'] . '">
                    <div class="col-md-12 col-sm-12 post-design-box">
                        <div  class="post_radius_box">  
                            <div class="post-design-top col-md-12" >  
                                <div class="post-design-pro-img"> 
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
                                    </div>';


                    $companyname = $this->db->get_where('business_profile', array('user_id' => $row['user_id'], 'status' => 1))->row()->company_name;

                    $companynameposted = $this->db->get_where('business_profile', array('user_id' => $row['posted_user_id']))->row()->company_name;

                    $business_userimage = $this->db->get_where('business_profile', array('user_id' => $row['user_id'], 'status' => 1))->row()->business_user_image;
                    $userimageposted = $this->db->get_where('business_profile', array('user_id' => $row['posted_user_id']))->row()->business_user_image;

                    $slugname = $this->db->get_where('business_profile', array('user_id' => $row['user_id'], 'status' => 1))->row()->business_slug;
                    $slugnameposted = $this->db->get_where('business_profile', array('user_id' => $row['posted_user_id'], 'status' => 1))->row()->business_slug;
                    if ($row['posted_user_id']) {

                        if ($userimageposted) {
                            $return_html .= '<a href="' . base_url('business_profile/business_profile_manage_post/' . $slugnameposted) . '">';

                            if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $userimageposted)) {
                                $a = $companynameposted;
                                $acr = substr($a, 0, 1);

                                $return_html .= '<div class="post-img-div">';
                                $return_html .= ucfirst(strtolower($acr));
                                $return_html .= '</div>';
                            } else {
                                $return_html .= '<img src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $userimageposted) . '" name="image_src" id="image_src" />';
                            }

                            $return_html .= '</a>';
                        } else {
                            $return_html .= '<a href="' . base_url('business_profile/business_profile_manage_post/' . $slugnameposted) . '">';


                            $a = $companynameposted;
                            $acr = substr($a, 0, 1);

                            $return_html .= '<div class="post-img-div">';
                            $return_html .= ucfirst(strtolower($acr));
                            $return_html .= '</div>';

                            $return_html .= '</a>';
                        }
                    } else {
                        if ($business_userimage) {
                            $return_html .= '<a href="' . base_url('business_profile/business_profile_manage_post/' . $slugname) . '">';

                            if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                                $a = $companyname;
                                $acr = substr($a, 0, 1);

                                $return_html .= '<div class="post-img-div">';
                                $return_html .= ucfirst(strtolower($acr));
                                $return_html .= '</div>';
                            } else {
                                $return_html .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) . '"  alt="">';
                            }
                            $return_html .= '</a>';
                        } else {
                            $return_html .= '<a href="' . base_url('business_profile/business_profile_manage_post/' . $slugname) . '">';

                            $a = $companyname;
                            $acr = substr($a, 0, 1);

                            $return_html .= '<div class="post-img-div">';
                            $return_html .= ucfirst(strtolower($acr));
                            $return_html .= '</div>';

                            $return_html .= '</a>';
                        }
                    }
                    $return_html .= '</div>
                                <div class="post-design-name fl col-md-10">
                                    <ul>';
                    $companyname = $this->db->get_where('business_profile', array('user_id' => $row['user_id'], 'status' => 1))->row()->company_name;
                    $slugname = $this->db->get_where('business_profile', array('user_id' => $row['user_id'], 'status' => 1))->row()->business_slug;
                    $categoryid = $this->db->get_where('business_profile', array('user_id' => $row['user_id'], 'status' => 1))->row()->industriyal;
                    $category = $this->db->get_where('industry_type', array('industry_id' => $categoryid, 'status' => 1))->row()->industry_name;

                    $companynameposted = $this->db->get_where('business_profile', array('user_id' => $row['posted_user_id']))->row()->company_name;
                    $slugnameposted = $this->db->get_where('business_profile', array('user_id' => $row['posted_user_id'], 'status' => 1))->row()->business_slug;

                    $return_html .= '<li>
                                        </li>';
                    if ($row['posted_user_id']) {
                        $return_html .= '<li>
                                                <div class="else_post_d">
                                                    <div class="post-design-product">
                                                        <a class="post_dot_2" href="' . base_url('business_profile/business_profile_manage_post/' . $slugnameposted) . '">' . ucfirst(strtolower($companynameposted)) . '</a>
                                                        <p class="posted_with" > Posted With</p> <a class="other_name name_business post_dot_2"  href="' . base_url('business_profile/business_profile_manage_post/' . $slugname) . '">' . ucfirst(strtolower($companyname)) . '</a>
                                                        <span role="presentation" aria-hidden="true"> · </span> <span class="ctre_date">
                                        ' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($row['created_date']))) . '  
                                                        </span> </div></div>
                                            </li>';
                        $category = $this->db->get_where('industry_type', array('industry_id' => $businessdata[0]['industriyal'], 'status' => 1))->row()->industry_name;
                    } else {
                        $return_html .= '<li>
                                                <div class="post-design-product">
                                                    <a class="post_dot"  href="' . base_url('business_profile/business_profile_manage_post/' . $slugname) . '" title="' . ucfirst(strtolower($companyname)) . '">
                    ' . ucfirst(strtolower($companyname)) . '</a>
                                                    <span role="presentation" aria-hidden="true"> · </span>
                                                    <div class="datespan"> <span class="ctre_date" > 
                    ' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($row['created_date']))) . '

                                                        </span></div>

                                                </div>
                                            </li>';
                    }
                    $category = $this->db->get_where('industry_type', array('industry_id' => $businessdata[0]['industriyal'], 'status' => 1))->row()->industry_name;


                    $return_html .= '<li>
                                            <div class="post-design-product">
                                                <a class="buuis_desc_a" href="javascript:void(0);"  title="Category">';
                    if ($category) {
                        $return_html .= ucfirst(strtolower($category));
                    } else {
                        $return_html .= ucfirst(strtolower($businessdata[0]['other_industrial']));
                    }

                    $return_html .= '</a>
                                            </div>
                                        </li>

                                        <li>
                                        </li> 
                                    </ul> 
                                </div>  
                                <div class="dropdown1">
                                    <a onClick="myFunction(' . $row['business_profile_post_id'] . ')" class="dropbtn1 dropbtn1 fa fa-ellipsis-v">
                                    </a>
                                    <div id="myDropdown' . $row['business_profile_post_id'] . '" class="dropdown-content1">';

                    if ($row['posted_user_id'] != 0) {

                        if ($this->session->userdata('aileenuser') == $row['posted_user_id']) {

                            $return_html .= '<a onclick="user_postdelete(' . $row['business_profile_post_id'] . ')">
                                                    <i class="fa fa-trash-o" aria-hidden="true">
                                                    </i> Delete Post
                                                </a>
                                                <a id="' . $row['business_profile_post_id'] . '" onClick="editpost(this.id)">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true">
                                                    </i>Edit
                                                </a>';
                        } else {

                            $return_html .= '<a onclick="user_postdelete(' . $row['business_profile_post_id'] . ')">
                                                    <i class="fa fa-trash-o" aria-hidden="true">
                                                    </i> Delete Post
                                                </a>
                                                <a href="' . base_url('business_profile/business_profile_contactperson/' . $row['posted_user_id']) . '">
                                                    <i class="fa fa-user" aria-hidden="true">
                                                    </i> Contact Person </a>';
                        }
                    } else {
                        if ($this->session->userdata('aileenuser') == $row['user_id']) {
                            $return_html .= '<a onclick="user_postdelete(' . $row['business_profile_post_id'] . ')">
                                                    <i class="fa fa-trash-o" aria-hidden="true">
                                                    </i> Delete Post
                                                </a>
                                                <a id="' . $row['business_profile_post_id'] . '" onClick="editpost(this.id)">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true">
                                                    </i>Edit
                                                </a>';
                        } else {
                            $return_html .= '<a onclick="user_postdeleteparticular(' . $row['business_profile_post_id'] . ')">
                                                    <i class="fa fa-trash-o" aria-hidden="true">
                                                    </i> Delete Post
                                                </a>

                                                <a href="' . base_url('business_profile/business_profile_contactperson/' . $row['user_id']) . '">
                                                    <i class="fa fa-user" aria-hidden="true">
                                                    </i> Contact Person
                                                </a>';
                        }
                    }

                    $return_html .= '</div>
                                </div>
                                <div class="post-design-desc">
                                    <div class="ft-15 t_artd">
                                        <div id="editpostdata' . $row['business_profile_post_id'] . '" style="display:block;">
                                            <a>' . $this->common->make_links($row['product_name']) . '</a>
                                        </div>
                                        <div id="editpostbox' . $row['business_profile_post_id'] . '" style="display:none;">
                                            
                                            
                                            <input type="text" id="editpostname' . $row['business_profile_post_id'] . '" name="editpostname" placeholder="Product Name" value="' . $row['product_name'] . '" onKeyDown=check_lengthedit(' . $row['business_profile_post_id'] . '); onKeyup=check_lengthedit(' . $row['business_profile_post_id'] . '); onblur=check_lengthedit(' . $row['business_profile_post_id'] . ');>';

                    if ($row['product_name']) {
                        $counter = $row['product_name'];
                        $a = strlen($counter);

                        $return_html .= '<input size=1 id="text_num" class="text_num" value="' . (50 - $a) . '" name=text_num readonly>';
                    } else {
                        $return_html .= '<input size=1 id="text_num" class="text_num" value=50 name=text_num readonly>';
                    }
                    $return_html .= '</div>

                                    </div>                    
                                    <div id="khyati' . $row['business_profile_post_id'] . '" style="display:block;">';

                    $small = substr($row['product_description'], 0, 180);
                    $return_html .= $small;
                    if (strlen($row['product_description']) > 180) {
                        $return_html .= '... <span id="kkkk" onClick="khdiv(' . $row['business_profile_post_id'] . ')">View More</span>';
                    }

                    $return_html .= '</div>
                                    <div id="khyatii' . $row['business_profile_post_id'] . '" style="display:none;">
                                        ' . $row['product_description'] . '</div>
                                    <div id="editpostdetailbox' . $row['business_profile_post_id'] . '" style="display:none;">
                                        <div  contenteditable="true" id="editpostdesc' . $row['business_profile_post_id'] . '"  class="textbuis editable_text margin_btm" name="editpostdesc" placeholder="Description" onpaste="OnPaste_StripFormatting(this, event);">' . $row['product_description'] . '</div>
                                    </div>
                                    <div id="editpostdetailbox' . $row['business_profile_post_id'] . '" style="display:none;">
                                        <div contenteditable="true" id="editpostdesc' . $row['business_profile_post_id'] . '" placeholder="Product Description" class="textbuis  editable_text"  name="editpostdesc" onpaste="OnPaste_StripFormatting(this, event);">' . $row['product_description'] . '</div>                  
                                    </div>
                                    <button class="fr" id="editpostsubmit' . $row['business_profile_post_id'] . '" style="display:none;margin: 5px 0; border-radius: 3px;" onClick="edit_postinsert(' . $row['business_profile_post_id'] . ')">Save
                                    </button>
                                </div> 
                            </div>
                            <div class="post-design-mid col-md-12 padding_adust" >
                                <div>';

                    $contition_array = array('post_id' => $row['business_profile_post_id'], 'is_deleted' => '1', 'image_type' => '2');
                    $businessmultiimage = $this->data['businessmultiimage'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    if (count($businessmultiimage) == 1) {

                        $allowed = array('gif', 'PNG', 'jpg', 'jpeg');
                        $allowespdf = array('pdf');
                        $allowesvideo = array('mp4', 'webm');
                        $allowesaudio = array('mp3');
                        $filename = $businessmultiimage[0]['image_name'];
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                        if (in_array($ext, $allowed)) {

                            $return_html .= '<div class="one-image">';
                            $return_html .= '<a href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '">
                                                    <img src="' . base_url($this->config->item('bus_post_main_upload_path') . $businessmultiimage[0]['image_name']) . '"> 
                                                </a>
                                            </div>';
                        } elseif (in_array($ext, $allowespdf)) {
                            $return_html .= '<div>
                                                <a title="click to open" href="' . base_url('business_profile/creat_pdf/' . $businessmultiimage[0]['image_id']) . '"><div class="pdf_img">
                                                        <img src="' . base_url('assets/images/PDF.jpg') . '" style="height: 100%; width: 100%;">
                                                    </div>
                                                </a>
                                            </div>';
                        } elseif (in_array($ext, $allowesvideo)) {
                            $return_html .= '<div>
                                                <video width="100%" height="350" controls>
                                                    <source src="' . base_url($this->config->item('bus_post_main_upload_path') . $businessmultiimage[0]['image_name']) . '" type="video/mp4">
                                                    <source src="' . base_url($this->config->item('bus_post_main_upload_path') . $businessmultiimage[0]['image_name']) . '" type="video/ogg">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>';
                        } elseif (in_array($ext, $allowesaudio)) {
                            $return_html .= '<div class="audio_main_div">
                                                <div class="audio_img">
                                                    <img src="' . base_url('assets/images/music-icon.png') . '">  
                                                </div>
                                                <div class="audio_source">
                                                    <audio id="audio_player" width="100%" height="100" controls>
                                                        <source src="' . base_url($this->config->item('bus_post_main_upload_path') . $businessmultiimage[0]['image_name']) . '" type="audio/mp3">
                                                        <source src="movie.ogg" type="audio/ogg">
                                                        Your browser does not support the audio tag.
                                                    </audio>
                                                </div>
                                                <div class="audio_mp3" id="' . "postname" . $row['business_profile_post_id'] . '">
                                                    <p title="' . $row['product_name'] . '">' . $row['product_name'] . '</p>
                                                </div>
                                            </div>';
                        }
                    } elseif (count($businessmultiimage) == 2) {

                        foreach ($businessmultiimage as $multiimage) {

                            $return_html .= '<div  class="two-images">
                                                <a href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '">
                                                    <img class="two-columns" src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $multiimage['image_name']) . '" style="width: 100%; height: 100%;"> 
                                                </a>
                                            </div>';
                        }
                    } elseif (count($businessmultiimage) == 3) {
                        $return_html .= '<div class="three-image-top" >
                                            <a href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '">
                                                <img class="three-columns" src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $businessmultiimage[0]['image_name']) . '" style="width: 100%; height:100%; "> 
                                            </a>
                                        </div>
                                        <div class="three-image" >

                                            <a href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '">
                                                <img class="three-columns" src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $businessmultiimage[1]['image_name']) . '" style="width: 100%; height:100%; "> 
                                            </a>
                                        </div>
                                        <div class="three-image" >
                                            <a href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '">
                                                <img class="three-columns" src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $businessmultiimage[2]['image_name']) . '" style="width: 100%; height:100%; "> 
                                            </a>
                                        </div>';
                    } elseif (count($businessmultiimage) == 4) {

                        foreach ($businessmultiimage as $multiimage) {

                            $return_html .= '<div class="four-image">
                                                <a href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '">
                                                    <img class="breakpoint" src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $multiimage['image_name']) . '" style="width: 100%; height: 100%;"> 
                                                </a>
                                            </div>';
                        }
                    } elseif (count($businessmultiimage) > 4) {

                        $i = 0;
                        foreach ($businessmultiimage as $multiimage) {

                            $return_html .= '<div class="four-image">
                                                <a href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '">
                                                    <img src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $multiimage['image_name']) . '" style="width: 100%; height: 100%;"> 
                                                </a>
                                            </div>';

                            $i++;
                            if ($i == 3)
                                break;
                        }

                        $return_html .= '<div class="four-image">
                                            <a href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '">
                                                <img src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $businessmultiimage[3]['image_name']) . '" style="width: 100%; height: 100%;"> 
                                            </a>
                                            <a class="text-center" href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '" >
                                                <div class="more-image" >
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
                            <div class="post-design-like-box col-md-12">
                                <div class="post-design-menu">
                                    <ul class="col-md-6 col-sm-6 col-xs-6">
                                        <li class="likepost' . $row['business_profile_post_id'] . '">
                                            <a id="' . $row['business_profile_post_id'] . '" class="ripple like_h_w"  onClick="post_like(this.id)">';

                    $userid = $this->session->userdata('aileenuser');
                    $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1');
                    $active = $this->data['active'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    $likeuser = $this->data['active'][0]['business_like_user'];
                    $likeuserarray = explode(',', $active[0]['business_like_user']);
                    if (!in_array($userid, $likeuserarray)) {

                        $return_html .= '<i class="fa fa-thumbs-up" style="color: #999;" aria-hidden="true"></i>';
                    } else {
                        $return_html .= '<i class="fa fa-thumbs-up fa-1x main_color" aria-hidden="true"></i>';
                    }
                    $return_html .= '<span class="like_As_count">';

                    if ($row['business_likes_count'] > 0) {
                        $return_html .= $row['business_likes_count'];
                    }

                    $return_html .= '</span>
                                            </a>
                                        </li>
                                        <li id="insertcount' . $row['business_profile_post_id'] . '" style="visibility:show">';

                    $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                    $commnetcount = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $return_html .= '<a onClick = "commentall(this.id)" id = "' . $row['business_profile_post_id'] . '" class = "ripple like_h_w">
                    <i class = "fa fa-comment-o" aria-hidden = "true">
                    </i>
                    </a>
                    </li>
                    </ul>
                    <ul class = "col-md-6 col-sm-6 col-xs-6 like_cmnt_count">
                    <li>
                    <div class = "like_count_ext">
                    <span class = "comment_count' . $row['business_profile_post_id'] . '" >';

                    if (count($commnetcount) > 0) {
                        $return_html .= count($commnetcount);
                        $return_html .= '<span> Comment</span>';
                    }
                    $return_html .= '</span> 

                    </div>
                    </li>

                    <li>
                        <div class="comnt_count_ext">
                            <span class="comment_like_count' . $row['business_profile_post_id'] . '">';
                    if ($row['business_likes_count'] > 0) {
                        $return_html .= $row['business_likes_count'];

                        $return_html .= '<span> Like</span>';
                    }
                    $return_html .= '</span> 

                        </div></li>
                    </ul>
                    </div>
                    </div>';

                    if ($row['business_likes_count'] > 0) {

                        $return_html .= '<div class="likeduserlist' . $row['business_profile_post_id'] . '">';

                        $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                        $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                        $likeuser = $commnetcount[0]['business_like_user'];
                        $countlike = $commnetcount[0]['business_likes_count'] - 1;
                        $likelistarray = explode(',', $likeuser);
                        foreach ($likelistarray as $key => $value) {
                            $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
                        }

                        $return_html .= '<a href="javascript:void(0);"  onclick="likeuserlist(' . $row['business_profile_post_id'] . ')">';
                        $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                        $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                        $likeuser = $commnetcount[0]['business_like_user'];
                        $countlike = $commnetcount[0]['business_likes_count'] - 1;
                        $likelistarray = explode(',', $likeuser);

                        $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
                        $return_html .= '<div class="like_one_other">';

                        if ($userid == $value) {
                            $return_html .= "You";
                            $return_html .= "&nbsp;";
                        } else {
                            $return_html .= ucfirst(strtolower($business_fname1));
                            $return_html .= "&nbsp;";
                        }

                        if (count($likelistarray) > 1) {
                            $return_html .= " and";

                            $return_html .= $countlike;
                            $return_html .= "&nbsp;";
                            $return_html .= "others";
                        }
                        $return_html .= '</div>
                            </a>
                        </div>';
                    }

                    $return_html .= '<div class="likeusername' . $row['business_profile_post_id'] . '" id="likeusername' . $row['business_profile_post_id'] . '" style="display:none">';
                    $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                    $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    $likeuser = $commnetcount[0]['business_like_user'];
                    $countlike = $commnetcount[0]['business_likes_count'] - 1;
                    $likelistarray = explode(',', $likeuser);
                    foreach ($likelistarray as $key => $value) {
                        $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
                    }
                    $return_html .= '<a href="javascript:void(0);"  onclick="likeuserlist(' . $row['business_profile_post_id'] . ')">';
                    $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
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
                        <div  id="fourcomment' . $row['business_profile_post_id'] . '" style="display:none;">
                        </div>
                        <div id="threecomment' . $row['business_profile_post_id'] . '" style="display:block">
                            <div class="insertcomment' . $row['business_profile_post_id'] . '">';

                    $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1');
                    $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = 'business_profile_post_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');
                    if ($businessprofiledata) {
                        foreach ($businessprofiledata as $rowdata) {
                            $companyname = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id']))->row()->company_name;

                            $slugname1 = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id'], 'status' => 1))->row()->business_slug;

                            $return_html .= '<div class="all-comment-comment-box">
                                            <div class="post-design-pro-comment-img">';
                            $business_userimage = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id'], 'status' => 1))->row()->business_user_image;

                            if ($business_userimage) {
                                $return_html .= '<a href="' . base_url('business_profile/business_profile_manage_post/' . $slugname1) . '">';

                                if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                                    $a = $companyname;
                                    $acr = substr($a, 0, 1);

                                    $return_html .= '<div class="post-img-div">';
                                    $return_html .= ucfirst(strtolower($acr));
                                    $return_html .= '</div>';
                                } else {
                                    $return_html .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) . '"  alt="">';
                                }
                                $return_html .= '</a>';
                            } else {
                                $return_html .= '<a href="' . base_url('business_profile/business_profile_manage_post/' . $slugname1) . '">';
                                $a = $companyname;
                                $acr = substr($a, 0, 1);

                                $return_html .= '<div class="post-img-div">';
                                $return_html .= ucfirst(strtolower($acr));
                                $return_html .= '</div></a>';
                            }
                            $return_html .= '</div>
                                            <div class="comment-name">
                                                <b title="' . $companyname . '">';
                            $return_html .= $companyname;
                            $return_html .= '</br>';

                            $return_html .= '</b>
                                            </div>
                                            <div class="comment-details" id="showcomment' . $rowdata['business_profile_post_comment_id'] . '">';

                            $return_html .= '<div id="lessmore' . $rowdata['business_profile_post_comment_id'] . '" style="display:block;">';
                            $small = substr($rowdata['comments'], 0, 180);
                            $return_html .= $this->common->make_links($small);

                            if (strlen($rowdata['comments']) > 180) {
                                $return_html .= '... <span id="kkkk" onClick="seemorediv(' . $rowdata['business_profile_post_comment_id'] . ')">See More</span>';
                            }
                            $return_html .= '</div>';
                            $return_html .= '<div id="seemore' . $rowdata['business_profile_post_comment_id'] . '" style="display:none;">';
                            $new_product_comment = $this->common->make_links($rowdata['comments']);
                            $return_html .= nl2br(htmlspecialchars_decode(htmlentities($new_product_comment, ENT_QUOTES, 'UTF-8')));
                            $return_html .= '</div>';
                            $return_html .= '</div>
                                            <div class="edit-comment-box">
                                                <div class="inputtype-edit-comment">
                                                    <div contenteditable="true" class="editable_text editav_2" name="' . $rowdata['business_profile_post_comment_id'] . '"  id="editcomment' . $rowdata['business_profile_post_comment_id'] . '" placeholder="Enter Your Comment " value= ""  onkeyup="commentedit(' . $rowdata['business_profile_post_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $rowdata['comments'] . '</div>
                                                    <span class="comment-edit-button"><button id="editsubmit' . $rowdata['business_profile_post_comment_id'] . '" style="display:none" onClick="edit_comment(' . $rowdata['business_profile_post_comment_id'] . ')">Save</button></span>
                                                </div>
                                            </div>
                                            <div class="art-comment-menu-design"> 
                                                <div class="comment-details-menu" id="likecomment1' . $rowdata['business_profile_post_comment_id'] . '">
                                                    <a id="' . $rowdata['business_profile_post_comment_id'] . '" onClick="comment_like1(this.id)">';

                            $userid = $this->session->userdata('aileenuser');
                            $contition_array = array('business_profile_post_comment_id' => $rowdata['business_profile_post_comment_id'], 'status' => '1');
                            $businesscommentlike = $this->data['businesscommentlike'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                            $likeuserarray = explode(',', $businesscommentlike[0]['business_comment_like_user']);
                            if (!in_array($userid, $likeuserarray)) {

                                $return_html .= '<i class="fa fa-thumbs-up" style="color: #999;" aria-hidden="true"></i>';
                            } else {
                                $return_html .= '<i class="fa fa-thumbs-up main_color" aria-hidden="true">
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

                                $return_html .= '<span role="presentation" aria-hidden="true"> · 
                                                    </span>
                                                    <div class="comment-details-menu">
                                                        <div id="editcommentbox' . $rowdata['business_profile_post_comment_id'] . '" style="display:block;">
                                                            <a id="' . $rowdata['business_profile_post_comment_id'] . '"   onClick="comment_editbox(this.id)" class="editbox">Edit
                                                            </a>
                                                        </div>
                                                        <div id="editcancle' . $rowdata['business_profile_post_comment_id'] . '" style="display:none;">
                                                            <a id="' . $rowdata['business_profile_post_comment_id'] . '" onClick="comment_editcancle(this.id)">Cancel
                                                            </a>
                                                        </div>
                                                    </div>';
                            }
                            $userid = $this->session->userdata('aileenuser');
                            $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $rowdata['business_profile_post_id'], 'status' => 1))->row()->user_id;
                            if ($rowdata['user_id'] == $userid || $business_userid == $userid) {

                                $return_html .= '<span role="presentation" aria-hidden="true"> · 
                                                    </span>
                                                    <div class="comment-details-menu">
                                                        <input type="hidden" name="post_delete"  id="post_delete' . $rowdata['business_profile_post_comment_id'] . '" value= "' . $rowdata['business_profile_post_id'] . '">
                                                        <a id="' . $rowdata['business_profile_post_comment_id'] . '"   onClick="comment_delete(this.id)"> Delete
                                                            <span class="insertcomment' . $rowdata['business_profile_post_comment_id'] . '">
                                                            </span>
                                                        </a>
                                                    </div>';
                            }
                            $return_html .= '<span role="presentation" aria-hidden="true"> · 
                                                </span>
                                                <div class="comment-details-menu">
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
                    <div class="post-design-commnet-box col-md-12">
                        <div class="post-design-proo-img">';

                    $userid = $this->session->userdata('aileenuser');
                    $business_userimage = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => 1))->row()->business_user_image;
                    if ($business_userimage) {

                        if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                            $a = $companyname;
                            $acr = substr($a, 0, 1);

                            $return_html .= '<div class="post-img-div">';
                            $return_html .= ucfirst(strtolower($acr));
                            $return_html .= '</div>';
                        } else {
                            $return_html .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) . '"  alt="">';
                        }
                    } else {
                        $a = $companyname;
                        $acr = substr($a, 0, 1);

                        $return_html .= '<div class="post-img-div">';
                        $return_html .= ucfirst(strtolower($acr));
                        $return_html .= '</div>';
                    }
                    $return_html .= '</div>

                        <div id="content" class="col-md-12  inputtype-comment cmy_2" >
                            <div contenteditable="true" class="edt_2 editable_text" name="' . $row['business_profile_post_id'] . '"  id="post_comment' . $row['business_profile_post_id'] . '" placeholder="Add a Comment ..." onClick="entercomment(' . $row['business_profile_post_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);"></div>
                        </div>
                      ' . form_error('post_comment') . ' 
                        <div class="comment-edit-butn">       
                            <button id="' . $row['business_profile_post_id'] . '" onClick="insert_comment(this.id)">Comment
                            </button>
                        </div>

                    </div>
                    </div>
                    </div></div>';
                } else {
                    $count[] = "abc";
                }
            }
        }
        if (count($businessprofiledatapost) > 0) {
            if (count($count) == count($businessprofiledatapost)) {
                $return_html .= '<div class="contact-frnd-post bor_none">
                                        <div class="text-center rio">
                                            <h4 class="page-heading  product-listing" >No Post Found.</h4>
                                        </div>
                                    </div>';
            }
        } else {
            $return_html .= '<div class="contact-frnd-post bor_none">
                                    <div class="text-center rio">
                                        <h4 class="page-heading  product-listing" >No Post Found.</h4>
                                    </div>
                                </div>';
        }
        echo $return_html;
// return html        
    }

    public function business_home_three_user_list() {

        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

// GET BUSINESS DATA
        $contition_array = array('user_id' => $userid, 'status' => '1');
        $businessdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id,company_name,business_slug,business_user_image,profile_background,industriyal,city,state,other_industrial', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $business_profile_id = $businessdata[0]['business_profile_id'];

// GET USER LIST IN LEFT SIDE
        $contition_array = array('is_deleted' => 0, 'status' => 1, 'user_id !=' => $userid, 'business_step' => 4);
        $userlist = $userlist = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id,company_name,business_slug,business_user_image,industriyal,city,state,other_industrial', $sortby = 'business_profile_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// GET INDUSTRIAL WISE DATA
        $industriyal = $businessdata[0]['industriyal'];
        foreach ($userlist as $rowcategory) {

            if ($industriyal == $rowcategory['industriyal']) {
                $userlistcategory[] = $rowcategory;
            }
        }
        $userlistview1 = $userlistcategory;
// GET INDUSTRIAL WISE DATA
// GET CITY WISE DATA
        $businessregcity = $businessdata[0]['city'];

        $contition_array = array('is_deleted' => 0, 'status' => 1, 'user_id !=' => $userid, 'industriyal !=' => $industriyal, 'business_step' => 4);
        $userlist2 = $this->data['userlist2'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id,company_name,business_slug,business_user_image,industriyal,city,state,other_industrial', $sortby = 'business_profile_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        foreach ($userlist2 as $rowcity) {
            if ($businessregcity == $rowcity['city']) {
                $userlistcity[] = $rowcity;
            }
        }
        $userlistview2 = $userlistcity;
// GET CITY WISE DATA
// GET STATE WISE DATA
        $businessregstate = $businessdata[0]['state'];
        $contition_array = array('is_deleted' => 0, 'status' => 1, 'user_id !=' => $userid, 'industriyal !=' => $industriyal, 'city !=' => $businessregcity, 'business_step' => 4);
        $userlist3 = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id,company_name,business_slug,business_user_image,industriyal,city,state,other_industrial', $sortby = 'business_profile_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        foreach ($userlist3 as $rowstate) {
            if ($businessregstate == $rowstate['state']) {
                $userliststate[] = $rowstate;
            }
        }
        $userlistview3 = $userliststate;
// GET STATE WISE DATA
// GET 3 USER
        $contition_array = array('is_deleted' => 0, 'status' => 1, 'user_id !=' => $userid, 'industriyal !=' => $industriyal, 'city !=' => $businessregcity, 'state !=' => $businessregstate, 'business_step' => 4);
        $userlastview = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = 'business_profile_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $userlistview4 = $userlastview;

        $return_html = '';
        $return_html .= '<ul>
                                            <li class="follow_box_ul_li">
                                                <div class="contact-frnd-post follow_left_main_box">';
        if ($userlistview1 > 0) {
            foreach ($userlistview1 as $userlist) {
                $userid = $this->session->userdata('aileenuser');
                $followfrom = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => 1))->row()->business_profile_id;
                $contition_array = array('follow_to' => $userlist['business_profile_id'], 'follow_from' => $followfrom, 'follow_status' => '1', 'follow_type' => '2');
                $businessfollow = $this->data['businessfollow'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '1', $offset = '', $join_str = array(), $groupby = '');
                $category = $this->db->get_where('industry_type', array('industry_id' => $userlist['industriyal'], 'status' => 1))->row()->industry_name;
                if (!$businessfollow) {

                    $return_html .= '<div class="profile-job-post-title-inside clearfix">
                                                                    <div class=" col-md-12 follow_left_box_main" id="fad' . $userlist['business_profile_id'] . '">                   
                                                                        <div class="post-design-pro-img_follow">';
                    if ($userlist['business_user_image']) {

                        $return_html .= '<a href="' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '" title="' . ucfirst(strtolower($userlist['company_name'])) . '">';

                        if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $userlist['business_user_image'])) {
                            $a = $userlist['company_name'];
                            $acr = substr($a, 0, 1);

                            $return_html .= '<div class="post-img-div">';
                            $return_html .= ucfirst(strtolower($acr));
                            $return_html .= '</div>';
                        } else {
                            $return_html .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $userlist['business_user_image']) . '"  alt="">';
                        }

                        $return_html .= '</a>';
                    } else {
                        $return_html .= '<a href="' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '" title="' . ucfirst(strtolower($userlist['company_name'])) . '">';
                        $a = $userlist['company_name'];
                        $acr = substr($a, 0, 1);

                        $return_html .= '<div class="post-img-div">';
                        $return_html .= ucfirst(strtolower($acr));
                        $return_html .= '</div></a>';
                    }
                    $return_html .= '</div>
                                                                        <div class="post-design-name_follow fl">
                                                                            <ul>
                                                                                <li>
                                                                                    <div class="post-design-product_follow">';
                    $return_html .= '<a href="' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '" title="' . ucfirst(strtolower($userlist['company_name'])) . '">
                                                                                            <h6>' . ucfirst(strtolower($userlist['company_name'])) . '</h6>
                                                                                        </a> 
                                                                                    </div>
                                                                                </li>';
                    $category = $this->db->get_where('industry_type', array('industry_id' => $userlist['industriyal'], 'status' => 1))->row()->industry_name;
                    $return_html .= '<li>
                                                                                    <div class="post-design-product_follow_main" style="display:block;">
                                                                                        <a href="' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '" title="' . ucfirst(strtolower($userlist['company_name'])) . '">
                                                                                            <p>';
                    if ($category) {
                        $return_html .= $category;
                    } else {
                        $return_html .= $userlist['other_industrial'];
                    }

                    $return_html .= '</p>
                                                                                        </a>
                                                                                    </div>
                                                                                </li>
                                                                            </ul> 
                                                                        </div>  
                                                                        <div class="follow_left_box_main_btn">';
                    $return_html .= '<div class="fr' . $userlist['business_profile_id'] . '">
                                                                                <button id="followdiv' . $userlist['business_profile_id'] . '" onClick="followuser_two(' . $userlist['business_profile_id'] . ')">Follow
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <span class="Follow_close" onClick="followclose(' . $userlist['business_profile_id'] . ')">
                                                                            <i class="fa fa-times" aria-hidden="true">
                                                                            </i>
                                                                        </span>
                                                                    </div>
                                                                </div>';
                }
            }
        }
        if ($userlistview2 > 0) {
            foreach ($userlistview2 as $userlist) {
                $userid = $this->session->userdata('aileenuser');
                $followfrom = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => 1))->row()->business_profile_id;
                $category = $this->db->get_where('industry_type', array('industry_id' => $userlist['industriyal'], 'status' => 1))->row()->industry_name;
                $contition_array = array('follow_to' => $userlist['business_profile_id'], 'follow_from' => $followfrom, 'follow_status' => '1', 'follow_type' => '2');
                $businessfollow = $this->data['businessfollow'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '1', $offset = '', $join_str = array(), $groupby = '');
                if (!$businessfollow) {
                    $return_html .= '<div class="profile-job-post-title-inside clearfix">
                                                                    <div class="col-md-12 follow_left_box_main" id="fad' . $userlist['business_profile_id'] . '">                   
                                                                        <div class="post-design-pro-img_follow">';
                    if ($userlist['business_user_image']) {
                        $return_html .= '<a href="' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '" title="' . ucfirst(strtolower($userlist['company_name'])) . '">';

                        if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $userlist['business_user_image'])) {
                            $a = $userlist['company_name'];
                            $acr = substr($a, 0, 1);

                            $return_html .= '<div class="post-img-div">';
                            $return_html .= ucfirst(strtolower($acr));
                            $return_html .= '</div>';
                        } else {

                            $return_html .= '<img src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $userlist['business_user_image']) . '"  alt="">';
                        }

                        $return_html .= '</a>';
                    } else {
                        $return_html .= '<a href="' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '" title="' . ucfirst(strtolower($userlist['company_name'])) . '">';
                        $a = $userlist['company_name'];
                        $acr = substr($a, 0, 1);

                        $return_html .= '<div class="post-img-div">';
                        $return_html .= ucfirst(strtolower($acr));
                        $return_html .= '</div></a>';
                    }
                    $return_html .= '</div>';
                    $return_html .= '<div class="post-design-name_follow fl">
                                                                            <ul>
                                                                                <li>
                                                                                    <div class="post-design-product_follow">
                                                                                        <a href="' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '" title="' . ucfirst(strtolower($userlist['company_name'])) . '">
                                                                                            <h6>' . ucfirst(strtolower($userlist['company_name'])) . '</h6>
                                                                                        </a> 
                                                                                    </div>
                                                                                </li>';
                    $category = $this->db->get_where('industry_type', array('industry_id' => $userlist['industriyal'], 'status' => 1))->row()->industry_name;
                    $return_html .= '<li>
                                                                                    <div class="post-design-product_follow_main" style="display:block;">
                                                                                        <a href="' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '" title="' . ucfirst(strtolower($userlist['company_name'])) . '">
                                                                                            <p>';
                    if ($category) {
                        $return_html .= $category;
                    } else {
                        $return_html .= $userlist['other_industrial'];
                    }

                    $return_html .= '</p>
                                                                                        </a>
                                                                                    </div>
                                                                                </li>
                                                                            </ul> 
                                                                        </div>  
                                                                        <div class="follow_left_box_main_btn">
                                                                            <div class="fr' . $userlist['business_profile_id'] . '">
                                                                                <button id="followdiv' . $userlist['business_profile_id'] . '" onClick="followuser_two(' . $userlist['business_profile_id'] . ')">Follow
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <span class="Follow_close" onClick="followclose(' . $userlist['business_profile_id'] . ')">
                                                                            <i class="fa fa-times" aria-hidden="true">
                                                                            </i>
                                                                        </span>
                                                                    </div>
                                                                </div>';
                }
            }
        }
        if ($userlistview3 > 0) {
            foreach ($userlistview3 as $userlist) {
                $userid = $this->session->userdata('aileenuser');
                $followfrom = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => 1))->row()->business_profile_id;
                $category = $this->db->get_where('industry_type', array('industry_id' => $userlist['industriyal'], 'status' => 1))->row()->industry_name;
                $contition_array = array('follow_to' => $userlist['business_profile_id'], 'follow_from' => $followfrom, 'follow_status' => '1', 'follow_type' => '2');
                $buisnessfollow = $this->data['buisnessfollow'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '1', $offset = '', $join_str = array(), $groupby = '');
                if (!$buisnessfollow) {

                    $return_html .= '<div class="profile-job-post-title-inside clearfix">
                                                                    <div class="col-md-12 follow_left_box_main" id="fad' . $userlist['business_profile_id'] . '">                   
                                                                        <div class="post-design-pro-img_follow">
                                                                            <a href="' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '">';
                    if ($userlist['business_user_image'] != '') {

                        if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $userlist['business_user_image'])) {
                            $a = $userlist['company_name'];
                            $acr = substr($a, 0, 1);

                            $return_html .= '<div class="post-img-div">';
                            $return_html .= ucfirst(strtolower($acr));
                            $return_html .= '</div>';
                        } else {

                            $return_html .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $userlist['business_user_image']) . '"  alt="">';
                        }
                    } else {
                        $a = $userlist['company_name'];
                        $acr = substr($a, 0, 1);

                        $return_html .= '<div class="post-img-div">';
                        $return_html .= ucfirst(strtolower($acr));
                        $return_html .= '</div>';
                    }
                    $return_html .= '</a>
                                                                        </div>
                                                                        <div class="post-design-name_follow fl">
                                                                            <ul>
                                                                                <li>
                                                                                    <div class="post-design-product_follow">
                                                                                        <a href="' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '">
                                                                                            <h6>' . ucfirst(strtolower($userlist['company_name'])) . '</h6>
                                                                                        </a> 
                                                                                    </div>
                                                                                </li>';
                    $category = $this->db->get_where('industry_type', array('industry_id' => $userlist['industriyal'], 'status' => 1))->row()->industry_name;
                    $return_html .= '<li>
                                                                                    <div class="post-design-product_follow_main" style="display:block;">
                                                                                        <a><p>';
                    if ($category) {
                        $return_html .= $category;
                    } else {
                        $return_html .= $userlist['other_industrial'];
                    }
                    $return_html .= '</p>
                                                                                        </a>
                                                                                    </div>
                                                                                </li>
                                                                            </ul> 
                                                                        </div>  
                                                                        <div class="follow_left_box_main_btn">
                                                                            <div class="fr' . $userlist['business_profile_id'] . '">
                                                                                <button id="followdiv' . $userlist['business_profile_id'] . '" onClick="followuser_two(' . $userlist['business_profile_id'] . ')">Follow
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <span class="Follow_close" onClick="followclose(' . $userlist['business_profile_id'] . ')">
                                                                            <i class="fa fa-times" aria-hidden="true">
                                                                            </i>
                                                                        </span>
                                                                    </div>
                                                                </div>';
                }
            }
        }
        if ($userlistview4 > 0) {
            foreach ($userlistview4 as $userlist) {
                $userid = $this->session->userdata('aileenuser');
                $followfrom = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => 1))->row()->business_profile_id;
                $category = $this->db->get_where('industry_type', array('industry_id' => $userlist['industriyal'], 'status' => 1))->row()->industry_name;
                $contition_array = array('follow_to' => $userlist['business_proifle_id'], 'follow_from' => $followfrom, 'follow_status' => '1', 'follow_type' => '2');
                $businessfollow = $this->data['businessfollow'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if (!$businessfollow) {

                    $return_html .= '<div class="profile-job-post-title-inside clearfix">
                                                                    <div class=" col-md-12 follow_left_box_main" id="fad' . $userlist['business_profile_id'] . '">                   
                                                                        <div class="post-design-pro-img_follow">';
                    if ($userlist['business_user_image']) {
                        $return_html .= '<a href="' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '" title="' . ucfirst(strtolower($userlist['company_name'])) . '">';

                        if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $userlist['business_user_image'])) {
                            $a = $userlist['company_name'];
                            $acr = substr($a, 0, 1);

                            $return_html .= '<div class="post-img-div">';
                            $return_html .= ucfirst(strtolower($acr));
                            $return_html .= '</div>';
                        } else {
                            $return_html .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $userlist['business_user_image']) . '"  alt="">';
                        }

                        $return_html .= '</a>';
                    } else {
                        $return_html .= '<a href="' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '" title="' . ucfirst(strtolower($userlist['company_name'])) . '">';
                        $a = $userlist['company_name'];
                        $acr = substr($a, 0, 1);

                        $return_html .= '<div class="post-img-div">';
                        $return_html .= ucfirst(strtolower($acr));
                        $return_html .= '</div></a>';
                    }
                    $return_html .= '</div>
                                                                        <div class="post-design-name_follow fl">
                                                                            <ul>
                                                                                <li>
                                                                                    <div class="post-design-product_follow">
                                                                                        <a href="' . base_url('business-profile/dashboard/' . $userlist['business_slug']) . '">
                                                                                            <h6>' . ucfirst(strtolower($userlist['company_name'])) . '</h6>
                                                                                        </a> 
                                                                                    </div>
                                                                                </li>';
                    $category = $this->db->get_where('industry_type', array('industry_id' => $userlist['industriyal'], 'status' => 1))->row()->industry_name;
                    $return_html .= '<li>
                                                                                    <div class="post-design-product_follow_main" style="display:block;">
                                                                                        <a><p>';
                    if ($category) {
                        $return_html .= $category;
                    } else {
                        $return_html .= $userlist['other_industrial'];
                    }

                    $return_html .= '</p>
                                                                                        </a>
                                                                                    </div>
                                                                                </li>
                                                                            </ul> 
                                                                        </div>  
                                                                        <div class="follow_left_box_main_btn">
                                                                            <div class="fr' . $userlist['business_profile_id'] . '">
                                                                                <button id="followdiv' . $userlist['business_profile_id'] . '" onClick="followuser_two(' . $userlist['business_profile_id'] . ')">Follow
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <span class="Follow_close" onClick="followclose(' . $userlist['business_profile_id'] . ')">
                                                                            <i class="fa fa-times" aria-hidden="true">
                                                                            </i>
                                                                        </span>
                                                                    </div>
                                                                </div>';
                }
            }
        }

        $return_html .= '</div>
                                            </li>
                                        </ul>';


        echo $return_html;
    }

// ajax function start 8-7 khyati change start


    public function bus_photos() {

        $id = $_POST['bus_slug'];
// manage post start
        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

//if user deactive profile then redirect to business_profile/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_deleted' => '0');

        $business_deactive = $this->data['business_deactive'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($business_deactive) {
            redirect('business_profile/');
        }
//if user deactive profile then redirect to business_profile/index untill active profile End

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['slug_data'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $slug_id = $this->data['slug_data'][0]['business_slug'];

        if ($id == $slug_id || $id == '') {

            $contition_array = array('business_slug' => $slug_id, 'status' => '1');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {

            $contition_array = array('business_slug' => $id, 'status' => '1', 'business_step' => 4);
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }



        $contition_array = array('user_id' => $businessdata1[0]['user_id']);
        $businessimage = $this->data['businessimage'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = 'business_profile_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        foreach ($businessimage as $val) {
            $contition_array = array('post_id' => $val['business_profile_post_id'], 'is_deleted' => '1', 'image_type' => '2');
            $busmultiimage = $this->data['busmultiimage'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = 'post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $multipleimage[] = $busmultiimage;
        }
        $allowed = array('jpg', 'jpeg', 'PNG', 'gif', 'png', 'psd', 'bmp', 'tiff', 'iff', 'xbm', 'webp');

        foreach ($multipleimage as $mke => $mval) {

            foreach ($mval as $mke1 => $mval1) {
                $ext = pathinfo($mval1['image_name'], PATHINFO_EXTENSION);

                if (in_array($ext, $allowed)) {
                    $singlearray[] = $mval1;
                }
            }
        }
        if ($singlearray) {
            $i = 0;
            foreach ($singlearray as $mi) {
                $fetch_result .= '<div class="image_profile">';
                $fetch_result .= '<img src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $mi['image_name']) . '" alt="img1">';
                $fetch_result .= '</div>';

                $i++;
                if ($i == 6)
                    break;
            }
        } else {

            $fetch_result .= '<div class="not_available">  <p>     Photos Not Available </p></div>';
        }

        $fetch_result .= '<div class="dataconphoto"></div>';

        echo $fetch_result;
    }

    public function bus_user_photos() {

        echo $id = $_POST['bus_slug'];
        exit;

        $contition_array = array('business_slug' => $id, 'status' => '1', 'business_step' => 4);
        $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('user_id' => $businessdata1[0]['user_id']);
        $businessimage = $this->data['businessimage'] = $this->common->select_data_by_condition('business_profile_post1', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        echo '<pre>';
        print_r($businessimage);
        exit;

        foreach ($businessimage as $val) {
            $contition_array = array('post_id' => $val['business_profile_post_id'], 'is_deleted' => '1', 'image_type' => '2');
            $busmultiimage = $this->data['busmultiimage'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = 'post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $multipleimage[] = $busmultiimage;
        }
        $allowed = array('jpg', 'jpeg', 'PNG', 'gif', 'png', 'psd', 'bmp', 'tiff', 'iff', 'xbm', 'webp');

        foreach ($multipleimage as $mke => $mval) {

            foreach ($mval as $mke1 => $mval1) {
                $ext = pathinfo($mval1['image_name'], PATHINFO_EXTENSION);

                if (in_array($ext, $allowed)) {
                    $singlearray[] = $mval1;
                }
            }
        }
        if ($singlearray) {
            $i = 0;
            foreach ($singlearray as $mi) {
                $fetch_result .= '<div class="image_profile">';
                $fetch_result .= '<img src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $mi['image_name']) . '" alt="img1">';
                $fetch_result .= '</div>';

                $i++;
                if ($i == 6)
                    break;
            }
        } else {

            $fetch_result .= '<div class="not_available">  <p>     Photos Not Available </p></div>';
        }

        $fetch_result .= '<div class="dataconphoto"></div>';

        echo $fetch_result;
    }

    public function bus_videos() {

        $id = $_POST['bus_slug'];
// manage post start
        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

//if user deactive profile then redirect to business_profile/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_deleted' => '0');

        $business_deactive = $this->data['business_deactive'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($business_deactive) {
            redirect('business_profile/');
        }
//if user deactive profile then redirect to business_profile/index untill active profile End

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['slug_data'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $slug_id = $this->data['slug_data'][0]['business_slug'];

        if ($id == $slug_id || $id == '') {

            $contition_array = array('business_slug' => $slug_id, 'status' => '1');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {

            $contition_array = array('business_slug' => $id, 'status' => '1', 'business_step' => 4);
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }


        $contition_array = array('user_id' => $businessdata1[0]['user_id']);
        $busvideo = $this->data['busvideo'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        foreach ($busvideo as $val) {



            $contition_array = array('post_id' => $val['business_profile_post_id'], 'is_deleted' => '1', 'image_type' => '2');
            $busmultivideo = $this->data['busmultivideo'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = 'post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $multiplevideo[] = $busmultivideo;
        }

        $allowesvideo = array('mp4', 'webm');

        foreach ($multiplevideo as $mke => $mval) {

            foreach ($mval as $mke1 => $mval1) {
                $ext = pathinfo($mval1['image_name'], PATHINFO_EXTENSION);

                if (in_array($ext, $allowesvideo)) {
                    $singlearray1[] = $mval1;
                }
            }
        }
        if ($singlearray1) {
            $fetch_video .= '<tr>';

            if ($singlearray1[0]['image_name']) {
                $fetch_video .= '<td class="image_profile">';
                $fetch_video .= '<video controls>';

                $fetch_video .= '<source src="' . base_url($this->config->item('bus_post_main_upload_path') . $singlearray1[0]['image_name']) . '" type="video/mp4">';
                $fetch_video .= '<source src="movie.ogg" type="video/ogg">';
                $fetch_video .= 'Your browser does not support the video tag.';
                $fetch_video .= '</video>';
                $fetch_video .= '</td>';
            }

            if ($singlearray1[1]['image_name']) {
                $fetch_video .= '<td class="image_profile">';
                $fetch_video .= '<video  controls>';
                $fetch_video .= '<source src="' . base_url($this->config->item('bus_post_main_upload_path') . $singlearray1[1]['image_name']) . '" type="video/mp4">';
                $fetch_video .= '<source src="movie.ogg" type="video/ogg">';
                $fetch_video .= 'Your browser does not support the video tag.';
                $fetch_video .= '</video>';
                $fetch_video .= '</td>';
            }
            if ($singlearray1[2]['image_name']) {
                $fetch_video .= '<td class="image_profile">';
                $fetch_video .= '<video  controls>';
                $fetch_video .= '<source src="' . base_url($this->config->item('bus_post_main_upload_path') . $singlearray1[2]['image_name']) . '" type="video/mp4">';
                $fetch_video .= '<source src="movie.ogg" type="video/ogg">';
                $fetch_video .= 'Your browser does not support the video tag.';
                $fetch_video .= '</video>';
                $fetch_video .= '</td>';
            }
            $fetch_video .= '</tr>';
            $fetch_video .= '<tr>';

            if ($singlearray1[3]['image_name']) {
                $fetch_video .= '<td class="image_profile">';
                $fetch_video .= '<video  controls>';
                $fetch_video .= '<source src="' . base_url($this->config->item('bus_post_main_upload_path') . $singlearray1[3]['image_name']) . '" type="video/mp4">';
                $fetch_video .= '<source src="movie.ogg" type="video/ogg">';
                $fetch_video .= 'Your browser does not support the video tag.';
                $fetch_video .= '</video>';
                $fetch_video .= '</td>';
            }
            if ($singlearray1[4]['image_name']) {
                $fetch_video .= '<td class="image_profile">';
                $fetch_video .= '<video  controls>';
                $fetch_video .= '<source src="' . base_url($this->config->item('bus_post_main_upload_path') . $singlearray1[4]['image_name']) . '" type="video/mp4">';
                $fetch_video .= '<source src="movie.ogg" type="video/ogg">';
                $fetch_video .= 'Your browser does not support the video tag.';
                $fetch_video .= '</video>';
                $fetch_video .= '</td>';
            }
            if ($singlearray1[5]['image_name']) {
                $fetch_video .= '<td class="image_profile">';
                $fetch_video .= '<video  controls>';
                $fetch_video .= '<source src="' . base_url($this->config->item('bus_post_main_upload_path') . $singlearray1[5]['image_name']) . '" type="video/mp4">';
                $fetch_video .= '<source src="movie.ogg" type="video/ogg">';
                $fetch_video .= 'Your browser does not support the video tag.';
                $fetch_video .= '</video>';
                $fetch_video .= '</td>';
            }
            $fetch_video .= '</tr>';
        } else {


            $fetch_video .= '<div class="not_available">  <p>     Video Not Available </p></div>';
        }

        $fetch_video .= '<div class="dataconvideo"></div>';


        echo $fetch_video;
    }

    public function bus_audio() {

        $id = $_POST['bus_slug'];
// manage post start
        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

//if user deactive profile then redirect to business_profile/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_deleted' => '0');

        $business_deactive = $this->data['business_deactive'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($business_deactive) {
            redirect('business_profile/');
        }
//if user deactive profile then redirect to business_profile/index untill active profile End

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['slug_data'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $slug_id = $this->data['slug_data'][0]['business_slug'];

        if ($id == $slug_id || $id == '') {

            $contition_array = array('business_slug' => $slug_id, 'status' => '1');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {

            $contition_array = array('business_slug' => $id, 'status' => '1', 'business_step' => 4);
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }


        $contition_array = array('user_id' => $businessdata1[0]['user_id']);
        $busaudio = $this->data['busaudio'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        foreach ($busaudio as $val) {



            $contition_array = array('post_id' => $val['business_profile_post_id'], 'is_deleted' => '1', 'image_type' => '2');
            $busmultiaudio = $this->data['busmultiaudio'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = 'post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $multipleaudio[] = $busmultiaudio;
        }

        $allowesaudio = array('mp3');

        foreach ($multipleaudio as $mke => $mval) {

            foreach ($mval as $mke1 => $mval1) {
                $ext = pathinfo($mval1['image_name'], PATHINFO_EXTENSION);

                if (in_array($ext, $allowesaudio)) {
                    $singlearray2[] = $mval1;
                }
            }
        }
        if ($singlearray2) {
            $fetchaudio .= '<tr>';

            if ($singlearray2[0]['image_name']) {
                $fetchaudio .= '<td class="image_profile">';
                $fetchaudio .= '<video  controls>';

                $fetchaudio .= '<source src="' . base_url($this->config->item('bus_post_main_upload_path') . $singlearray2[0]['image_name']) . '" type="audio/mp3">';
                $fetchaudio .= '<source src="movie.ogg" type="audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</video>';
                $fetchaudio .= '</td>';
            }

            if ($singlearray2[1]['image_name']) {
                $fetchaudio .= '<td class="image_profile">';
                $fetchaudio .= '<video  controls>';
                $fetchaudio .= '<source src="' . base_url($this->config->item('bus_post_main_upload_path') . $singlearray2[1]['image_name']) . '" type="audio/mp3">';
                $fetchaudio .= '<source src="movie.ogg" type="audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</video>';
                $fetchaudio .= '</td>';
            }
            if ($singlearray2[2]['image_name']) {
                $fetchaudio .= '<td class="image_profile">';
                $fetchaudio .= '<video  controls>';
                $fetchaudio .= '<source src="' . base_url($this->config->item('bus_post_main_upload_path') . $singlearray2[2]['image_name']) . '" type="audio/mp3">';
                $fetchaudio .= '<source src="movie.ogg" type="audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</video>';
                $fetchaudio .= '</td>';
            }
            $fetchaudio .= '</tr>';
            $fetchaudio .= '<tr>';

            if ($singlearray2[3]['image_name']) {
                $fetchaudio .= '<td class="image_profile">';
                $fetchaudio .= '<video  controls>';
                $fetchaudio .= '<source src="' . base_url($this->config->item('bus_post_main_upload_path') . $singlearray2[3]['image_name']) . '" type="audio/mp3">';
                $fetchaudio .= '<source src="movie.ogg" type="audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</video>';
                $fetchaudio .= '</td>';
            }
            if ($singlearray2[4]['image_name']) {
                $fetchaudio .= '<td class="image_profile">';
                $fetchaudio .= '<video  controls>';
                $fetchaudio .= '<source src="' . base_url($this->config->item('bus_post_main_upload_path') . $singlearray2[4]['image_name']) . '" type="audio/mp3">';
                $fetchaudio .= '<source src="movie.ogg" type="audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</video>';
                $fetchaudio .= '</td>';
            }
            if ($singlearray2[5]['image_name']) {
                $fetchaudio .= '<td class="image_profile">';
                $fetchaudio .= '<video  controls>';
                $fetchaudio .= '<source src="' . base_url($this->config->item('bus_post_main_upload_path') . $singlearray2[5]['image_name']) . '" type="audio/mp3">';
                $fetchaudio .= '<source src="movie.ogg" type="audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</video>';
                $fetchaudio .= '</td>';
            }
            $fetchaudio .= '</tr>';
        } else {
            $fetchaudio .= '<div class="not_available">  <p>   Audio Not Available </p></div>';
        }
        $fetchaudio .= '<div class="dataconaudio"></div>';
        echo $fetchaudio;
    }

    public function bus_pdf() {
        $id = $_POST['bus_slug'];
// manage post start
        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['slug_data'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $slug_id = $this->data['slug_data'][0]['business_slug'];
        if ($id == $slug_id || $id == '') {
            $contition_array = array('business_slug' => $slug_id, 'status' => '1');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {
            $contition_array = array('business_slug' => $id, 'status' => '1', 'business_step' => 4);
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }
        $contition_array = array('user_id' => $businessdata1[0]['user_id']);
        $businessimage = $this->data['businessimage'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        foreach ($businessimage as $val) {
            $contition_array = array('post_id' => $val['business_profile_post_id'], 'is_deleted' => '1', 'image_type' => '2');
            $busmultipdf = $this->data['busmultipdf'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = 'post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $multiplepdf[] = $busmultipdf;
        }
        $allowed = array('pdf');
        foreach ($multiplepdf as $mke => $mval) {

            foreach ($mval as $mke1 => $mval1) {
                $ext = pathinfo($mval1['image_name'], PATHINFO_EXTENSION);

                if (in_array($ext, $allowed)) {
                    $singlearray3[] = $mval1;
                }
            }
        }

        if ($singlearray3) {

            $i = 0;
            foreach ($singlearray3 as $mi) {

                $fetch_pdf .= '<div class="image_profile">';
                $fetch_pdf .= '<a href="' . base_url('business_profile/creat_pdf/' . $singlearray3[0]['image_id']) . '"><div class="pdf_img">';
                $fetch_pdf .= '<img src="' . base_url('assets/images/PDF.jpg') . '" style="height: 100%; width: 100%;">';
                $fetch_pdf .= '</div></a>';
                $fetch_pdf .= '</div>';

                $i++;
                if ($i == 6)
                    break;
            }
        } else {
            $fetch_pdf .= '<div class="not_available">  <p> Pdf Not Available </p></div>';
        }
        $fetch_pdf .= '<div class="dataconpdf"></div>';
        echo $fetch_pdf;
    }

    public function business_dashboard_post($id = '') {
// manage post start
        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $slug_data = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $slug_id = $slug_data[0]['business_slug'];
        if ($id == $slug_id || $id == '') {
            $contition_array = array('business_slug' => $slug_id, 'status' => '1');
            $businessdata1 = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'status' => 1, 'is_delete' => '0');
            $business_profile_data = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data, $sortby = 'business_profile_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {
            $contition_array = array('business_slug' => $id, 'status' => '1', 'business_step' => 4);
            $businessdata1 = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'status' => 1, 'is_delete' => '0');
            $business_profile_data = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data, $sortby = 'business_profile_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }

        $return_html = '';

        if (count($business_profile_data) > 0) {
            foreach ($business_profile_data as $row) {
                $contition_array = array('user_id' => $row['user_id'], 'status' => '1');
                $businessdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $return_html .= '<div id="removepost' . $row['business_profile_post_id'] . '">
                    <div class="">
                        <div class="post-design-box">
                            <div class="post-design-top col-md-12" >  
                                <div class="post-design-pro-img">';
                $userid = $this->session->userdata('aileenuser');
                $userimage = $this->db->get_where('business_profile', array('user_id' => $row['user_id']))->row()->business_user_image;

                $userimageposted = $this->db->get_where('business_profile', array('user_id' => $row['posted_user_id']))->row()->business_user_image;

                $usernameposted = $this->db->get_where('business_profile', array('user_id' => $row['posted_user_id']))->row()->company_name;

                $username = $this->db->get_where('business_profile', array('user_id' => $row['user_id']))->row()->company_name;

                $userimageposted = $this->db->get_where('business_profile', array('user_id' => $row['posted_user_id']))->row()->business_user_image;
                if ($row['posted_user_id']) {
                    if ($userimageposted) {

                        if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $userimageposted)) {
                            $a = $usernameposted;
                            $acr = substr($a, 0, 1);

                            $return_html .= '<div class="post-img-div">';
                            $return_html .= ucfirst(strtolower($acr));
                            $return_html .= '</div>';
                        } else {

                            $return_html .= '<img src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $userimageposted) . '" name="image_src" id="image_src" />';
                        }
                    } else {
                        $a = $usernameposted;
                        $acr = substr($a, 0, 1);

                        $return_html .= '<div class="post-img-div">';
                        $return_html .= ucfirst(strtolower($acr));
                        $return_html .= '</div>';
                    }
                } else {
                    if ($userimage) {

                        if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $userimage)) {
                            $a = $username;
                            $acr = substr($a, 0, 1);

                            $return_html .= '<div class="post-img-div">';
                            $return_html .= ucfirst(strtolower($acr));
                            $return_html .= '</div>';
                        } else {

                            $return_html .= '<img src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $userimage) . '" name="image_src" id="image_src" />';
                        }
                    } else {
                        $a = $username;
                        $acr = substr($a, 0, 1);

                        $return_html .= '<div class="post-img-div">';
                        $return_html .= ucfirst(strtolower($acr));
                        $return_html .= '</div>';
                    }
                }
                $return_html .= '</div>
                                <div class="post-design-name fl col-xs-8 col-md-10">
                                    <ul>';
                $companyname = $this->db->get_where('business_profile', array('user_id' => $row['user_id']))->row()->company_name;
                $slugname = $this->db->get_where('business_profile', array('user_id' => $row['user_id'], 'status' => 1))->row()->business_slug;
                $categoryid = $this->db->get_where('business_profile', array('user_id' => $row['user_id'], 'status' => 1))->row()->industriyal;
                $category = $this->db->get_where('industry_type', array('industry_id' => $categoryid, 'status' => 1))->row()->industry_name;
                $companynameposted = $this->db->get_where('business_profile', array('user_id' => $row['posted_user_id']))->row()->company_name;
                $slugnameposted = $this->db->get_where('business_profile', array('user_id' => $row['posted_user_id'], 'status' => 1))->row()->business_slug;
                if ($row['posted_user_id']) {
                    $return_html .= '<li>
                                                <div class="else_post_d">
                                                    <div class="post-design-product">
                                                        <a style="max-width: 40%;" class="post_dot" title="' . ucfirst(strtolower($companynameposted)) . '" href="' . base_url('business_profile/business_profile_manage_post/' . $slugnameposted) . '">' . ucfirst(strtolower($companynameposted)) . '</a>
                                                        <p class="posted_with" > Posted With</p>
                                                        <a class="other_name post_dot" href="' . base_url('business-profile/details/' . $slugname) . '">' . ucfirst(strtolower($companyname)) . '</a>
                                                        <span role="presentation" aria-hidden="true"> · </span> <span class="ctre_date">' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($row['created_date']))) . '</span> 
                                                    </div></div>
                                            </li>';
                } else {
                    $return_html .= '<li><div class="post-design-product"><a class="post_dot" title="' . ucfirst(strtolower($companyname)) . '" href="' . base_url('business_profile/business_profile_manage_post/' . $slugname) . '">' . ucfirst(strtolower($companyname)) . '</a>
                                                    <span role="presentation" aria-hidden="true"> · </span>
                                                    <div class="datespan"> 
                                                        <span class="ctre_date">' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($row['created_date']))) . '</span> 
                                                    </div>
                                                </div>
                                            </li>';
                }
                $category = $this->db->get_where('industry_type', array('industry_id' => $businessdata[0]['industriyal'], 'status' => 1))->row()->industry_name;
                $return_html .= '<li><div class="post-design-product">   <a class="buuis_desc_a"  title="Category">';

                if ($category) {
                    $return_html .= ucfirst(strtolower($category));
                } else {
                    $return_html .= ucfirst(strtolower($businessdata[0]['other_industrial']));
                }

                $return_html .= '</a> </div>
</li>
<li>
</li>
</ul>
</div>
<div class = "dropdown1">
<a onClick = "myFunction1(' . $row['business_profile_post_id'] . ')" class = "dropbtn1 dropbtn1 fa fa-ellipsis-v"></a>
<div id = "myDropdown' . $row['business_profile_post_id'] . '" class = "dropdown-content2">';
                if ($row['posted_user_id'] != 0) {
                    if ($this->session->userdata('aileenuser') == $row['posted_user_id']) {
                        $return_html .= '<a onclick="user_postdelete(' . $row['business_profile_post_id'] . ')">
    <i class="fa fa-trash-o" aria-hidden="true">
    </i> Delete Post
</a>
<a id="' . $row['business_profile_post_id'] . '" onClick="editpost(this.id)">
    <i class="fa fa-pencil-square-o" aria-hidden="true">
    </i>Edit
</a>';
                    } else {
                        $return_html .= '<a onclick="user_postdelete(' . $row['business_profile_post_id'] . ')">
    <i class="fa fa-trash-o" aria-hidden="true">
    </i> Delete Post
</a>
<a href="' . base_url('business-profile/business-profile-contactperson/' . $row['posted_user_id'] . '') . '">
    <i class="fa fa-user" aria-hidden="true">
    </i> Contact Person
</a>';
                    }
                } else {
                    if ($this->session->userdata('aileenuser') == $row['user_id']) {
                        $return_html .= '<a onclick="user_postdelete(' . $row['business_profile_post_id'] . ')"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete Post</a>
<a id="' . $row['business_profile_post_id'] . '" onClick="editpost(this.id)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</a>';
                    } else {
                        $return_html .= '<a href="' . base_url('business-profile/business-profile-contactperson/' . $row['user_id'] . '') . '"><i class="fa fa-user" aria-hidden="true"></i> Contact Person</a>';
                    }
                }
                $return_html .= '</div>
</div>';
                if ($row['product_name'] || $row['product_description']) {
                    $return_html .= '<div class="post-design-desc ">';
                }
                $return_html .= '<div class="ft-15 t_artd">
        <div id="editpostdata' . $row['business_profile_post_id'] . '" style="display:block;">
            <a>' . $this->common->make_links($row['product_name']) . '</a>
        </div>
        <div id="editpostbox' . $row['business_profile_post_id'] . '" style="display:none;">
            <input type="text" id="editpostname' . $row['business_profile_post_id'] . '" name="editpostname" placeholder="Product Name" value="' . $row['product_name'] . '" onKeyDown=check_lengthedit(' . $row['business_profile_post_id'] . ') onKeyup=check_lengthedit(' . $row['business_profile_post_id'] . '); onblur=check_lengthedit(' . $row['business_profile_post_id'] . ')>';
                if ($row['product_name']) {
                    $counter = $row['product_name'];
                    $a = strlen($counter);
                    $return_html .= '<input size=1 id="text_num" class="text_num" value="' . (50 - $a) . '" name=text_num readonly>';
                } else {
                    $return_html .= '<input size=1 id="text_num" class="text_num" value=50 name=text_num readonly>';
                }
                $return_html .= '</div>
    </div>
    <div id="khyati' . $row['business_profile_post_id'] . '" style="display:block;">';
                $small = substr($row['product_description'], 0, 180);
                $return_html .= $this->common->make_links($small);
                if (strlen($row['product_description']) > 180) {
                    $return_html .= '... <span id="kkkk" onClick="khdiv(' . $row['business_profile_post_id'] . ')">View More</span>';
                }
                $return_html .= '</div>
    <div id="khyatii' . $row['business_profile_post_id'] . '" style="display:none;">';
                $return_html .= $row['product_description'];
                $return_html .= '</div>
    <div id="editpostdetailbox' . $row['business_profile_post_id'] . '" style="display:none;">
        <div contenteditable="true" id="editpostdesc' . $row['business_profile_post_id'] . '" placeholder="Product Description" class="textbuis editable_text" placeholder="Description of Your Product"  name="editpostdesc" onpaste="OnPaste_StripFormatting(this, event);">' . $row['product_description'] . '</div>
    </div>
    <button class="fr" id="editpostsubmit"' . $row['business_profile_post_id'] . '" style="display:none;margin: 5px 0;" onClick="edit_postinsert(' . $row['business_profile_post_id'] . ')">Save</button>
</div> ';
                if ($row['product_name'] || $row['product_description']) {
                    $return_html .= '</div>';
                }
                $return_html .= '<div class="post-design-mid col-md-12" >  
    <div class="mange_post_image">';

                $contition_array = array('post_id' => $row['business_profile_post_id'], 'is_deleted' => '1', 'image_type' => '2');
                $businessmultiimage = $this->data['businessmultiimage'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if (count($businessmultiimage) == 1) {

                    $allowed = array('jpg', 'jpeg', 'PNG', 'gif', 'png', 'psd', 'bmp', 'tiff', 'iff', 'xbm', 'webp');
                    $allowespdf = array('pdf');
                    $allowesvideo = array('mp4', 'webm');
                    $allowesaudio = array('mp3');
                    $filename = $businessmultiimage[0]['image_name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    if (in_array($ext, $allowed)) {
                        $return_html .= '<div class="one-image">
            <a href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '"><img src="' . base_url($this->config->item('bus_post_main_upload_path') . $businessmultiimage[0]['image_name']) . '"> </a>
        </div>';
                    } elseif (in_array($ext, $allowespdf)) {

                        $return_html .= '<div>
            <a href="' . base_url('business-profile/creat-pdf/' . $businessmultiimage[0]['image_id']) . '"><div class="pdf_img">
                    <img src="' . base_url('assets/images/PDF.jpg') . '" style="height: 100%; width: 100%;">
                </div></a>
        </div>';
                    } elseif (in_array($ext, $allowesvideo)) {
                        $return_html .= '<div>
            <video class="video" width="100%" height="350" controls>
                <source src="' . base_url($this->config->item('bus_post_main_upload_path') . $businessmultiimage[0]['image_name']) . '" type="video/mp4">
                <source src="movie.ogg" type="video/ogg">
                Your browser does not support the video tag.
            </video>
        </div>';
                    } elseif (in_array($ext, $allowesaudio)) {
                        $return_html .= '<div class="audio_main_div">
            <div class="audio_img">
                <img src="' . base_url('assets/images/music-icon.png') . '">  
            </div>
            <div class="audio_source">
                <audio  controls>
                    <source src="' . base_url($this->config->item('bus_post_main_upload_path') . $businessmultiimage[0]['image_name']) . '" type="audio/mp3">
                    <source src="movie.ogg" type="audio/ogg">
                    Your browser does not support the audio tag.
                </audio>
            </div>
            <div class="audio_mp3" id="postname' . $row['business_profile_post_id'] . '">
                <p title="' . $row['product_name'] . '">' . $row['product_name'] . '</p>
            </div>
        </div>';
                    }
                } elseif (count($businessmultiimage) == 2) {
                    foreach ($businessmultiimage as $multiimage) {
                        $return_html .= '<div  class="two-images" >
            <a href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '"><img class="two-columns" src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $multiimage['image_name']) . '" style="width: 100%; height: 100%;"> </a>
        </div>';
                    }
                } elseif (count($businessmultiimage) == 3) {
                    $return_html .= '<div class="three-imag-top" >
            <a href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '"><img class="three-columns" src="' . base_url($this->config->item('bus_post_main_upload_path') . $businessmultiimage[0]['image_name']) . '" style="width: 100%; height:100%; "> </a>
        </div>
        <div class="three-image" >
            <a href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '"><img class="three-columns" src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $businessmultiimage[1]['image_name']) . '" style="width: 100%; height:100%; "> </a>
        </div>
        <div class="three-image" >
            <a href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '"><img class="three-columns" src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $businessmultiimage[2]['image_name']) . '" style="width: 100%; height:100%; "> </a>
        </div>';
                } elseif (count($businessmultiimage) == 4) {

                    foreach ($businessmultiimage as $multiimage) {
                        $return_html .= '<div class="four-image">
            <a href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '"><img class="breakpoint" src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $multiimage['image_name']) . '" style="width: 100%; height: 100%;"> </a>
        </div>';
                    }
                } elseif (count($businessmultiimage) > 4) {

                    $i = 0;
                    foreach ($businessmultiimage as $multiimage) {
                        $return_html .= '<div class="four-image">
            <a href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '"><img src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $multiimage['image_name']) . '" > </a>
        </div>';
                        $i++;
                        if ($i == 3)
                            break;
                    }
                    $return_html .= '<div class="four-image">
            <a href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '"><img src="' . base_url($this->config->item('bus_post_thumb_upload_path') . $businessmultiimage[3]['image_name']) . '" style=" width: 100%; height: 100%;"> </a>
            <a href="' . base_url('business-profile/post-detail/' . $row['business_profile_post_id']) . '">
                <div class="more-image" >
                    <span> View All (+' . (count($businessmultiimage) - 4) . ')
                    </span></div>
            </a>
        </div>';
                }
                $return_html .= '<div>
        </div>
    </div>
</div>
<div class="post-design-like-box col-md-12">
    <div class="post-design-menu">
        <ul class="col-md-6">
            <li class="likepost' . $row['business_profile_post_id'] . '">
                <a class="ripple like_h_w" id="' . $row['business_profile_post_id'] . '"   onClick="post_like(this.id)">';
                $userid = $this->session->userdata('aileenuser');
                $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1');
                $active = $this->data['active'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $likeuser = $this->data['active'][0]['business_like_user'];
                $likeuserarray = explode(',', $active[0]['business_like_user']);

                if (!in_array($userid, $likeuserarray)) {
                    $return_html .= '<i class="fa fa-thumbs-up" style="color: #999;" aria-hidden="true"></i>';
                } else {
                    $return_html .= '<i class="fa fa-thumbs-up main_color fa-1x" aria-hidden="true"></i>';
                }

                $return_html .= '<span class="like_As_count">';
                if ($row['business_likes_count'] > 0) {
                    $return_html .= $row['business_likes_count'];
                }
                $return_html .= '</span>
                </a>
            </li>

            <li id="insertcount' . $row['business_profile_post_id'] . '" style="visibility:show">';
                $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                $commnetcount = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $return_html .= '<a class="ripple like_h_w" onClick="commentall(this.id)" id="' . $row['business_profile_post_id'] . '"><i class="fa fa-comment-o" aria-hidden="true">';
                $return_html .= '</i> 
                </a>
            </li> 
        </ul>
        <ul class="col-md-6 like_cmnt_count">
            <li>
                <div class="like_count_ext">
                    <span class="comment_count' . $row['business_profile_post_id'] . '">';
                if (count($commnetcount) > 0) {
                    $return_html .= count($commnetcount);
                    $return_html .= '<span> Comment</span>';
                }
                $return_html .= '</span> 

                </div>
            </li>

            <li>
                <div class="comnt_count_ext">
                    <span class="comment_like_count' . $row['business_profile_post_id'] . '"> ';
                if ($row['business_likes_count'] > 0) {
                    $return_html .= $row['business_likes_count'];
                    $return_html .= '<span> Like</span>';
                }
                $return_html .= '</span> 
                </div>
            </li>
        </ul>
    </div>
</div>';
                if ($row['business_likes_count'] > 0) {
                    $return_html .= '<div class="likeduserlist1 likeduserlist' . $row['business_profile_post_id'] . '">';
                    $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                    $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    $likeuser = $commnetcount[0]['business_like_user'];
                    $countlike = $commnetcount[0]['business_likes_count'] - 1;
                    $likelistarray = explode(',', $likeuser);
                    foreach ($likelistarray as $key => $value) {
                        $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
                    }
                    $return_html .= '<a href="javascript:void(0);"  onclick="likeuserlist(' . $row['business_profile_post_id'] . ');">';
                    $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                    $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $likeuser = $commnetcount[0]['business_like_user'];
                    $countlike = $commnetcount[0]['business_likes_count'] - 1;
                    $likelistarray = explode(',', $likeuser);

                    $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
                    $return_html .= '<div class="like_one_other">';
                    if ($userid == $value) {
                        $return_html .= "You";
                        $return_html .= "&nbsp;";
                    } else {
                        $return_html .= ucfirst(strtolower($business_fname1));
                        $return_html .= "&nbsp;";
                    }
                    if (count($likelistarray) > 1) {
                        $return_html .= "and";
                        $return_html .= $countlike;
                        $return_html .= "&nbsp;";
                        $return_html .= "others";
                    }
                    $return_html .= '</div>
    </a>
</div>';
                }

                $return_html .= '<div  class="likeduserlist1  likeusername' . $row['business_profile_post_id'] . '" id="likeusername' . $row['business_profile_post_id'] . '" style="display:none">';
                $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
                $commnetcount = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                $likeuser = $commnetcount[0]['business_like_user'];
                $countlike = $commnetcount[0]['business_likes_count'] - 1;
                $likelistarray = explode(',', $likeuser);
                foreach ($likelistarray as $key => $value) {
                    $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => 1))->row()->company_name;
                }
                $return_html .= '<a href="javascript:void(0);"  onclick="likeuserlist(' . $row['business_profile_post_id'] . ');">';
                $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1', 'is_delete' => '0');
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
    <div id="fourcomment' . $row['business_profile_post_id'] . '" style="display:none;">
    </div>
    <div  id="threecomment' . $row['business_profile_post_id'] . '" style="display:block">
        <div class="insertcomment' . $row['business_profile_post_id'] . '">';
                $contition_array = array('business_profile_post_id' => $row['business_profile_post_id'], 'status' => '1');
                $businessprofiledata = $this->data['businessprofiledata'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = 'business_profile_post_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');

                if ($businessprofiledata) {
                    foreach ($businessprofiledata as $rowdata) {
                        $companyname = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id']))->row()->company_name;
                        $return_html .= '<div class="all-comment-comment-box">
                <div class="post-design-pro-comment-img">';
                        $business_userimage = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id'], 'status' => 1))->row()->business_user_image;
                        if ($business_userimage) {

                            if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                                $a = $companyname;
                                $acr = substr($a, 0, 1);

                                $return_html .= '<div class="post-img-div">';
                                $return_html .= ucfirst(strtolower($acr));
                                $return_html .= '</div>';
                            } else {

                                $return_html .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) . '"  alt="">';
                            }
                        } else {
                            $a = $companyname;
                            $acr = substr($a, 0, 1);

                            $return_html .= '<div class="post-img-div">';
                            $return_html .= ucfirst(strtolower($acr));
                            $return_html .= '</div>';
                        }
                        $return_html .= '</div>
                <div class="comment-name">
                    <b>';
                        $return_html .= ucfirst(strtolower($companyname));
                        $return_html .= '</br>';

                        $return_html .= '</b>
                </div>
                <div class="comment-details" id= "showcomment' . $rowdata['business_profile_post_comment_id'] . '">
                    <div id="lessmore' . $rowdata['business_profile_post_comment_id'] . '" style="display:block;">';
                        $small = substr($rowdata['comments'], 0, 180);
                        $return_html .= $this->common->make_links($small);

                        if (strlen($rowdata['comments']) > 180) {
                            $return_html .= '... <span id="kkkk" onClick="seemorediv(' . $rowdata['business_profile_post_comment_id'] . ')">See More</span>';
                        }
                        $return_html .= '</div>

                    <div id="seemore' . $rowdata['business_profile_post_comment_id'] . '" style="display:none;">';
                        $new_product_comment = $this->common->make_links($rowdata['comments']);
                        $return_html .= nl2br(htmlspecialchars_decode(htmlentities($new_product_comment, ENT_QUOTES, 'UTF-8')));
                        $return_html .= '</div>
                </div>
                <div class="edit-comment-box">
                    <div class="inputtype-edit-comment">
                        <div contenteditable="true"  class="editable_text editav_2" name="' . $rowdata['business_profile_post_comment_id'] . '"  id="editcomment"' . $rowdata['business_profile_post_comment_id'] . '" placeholder="Add a Commnet Comment" value= ""  onkeyup="commentedit(' . $rowdata['business_profile_post_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $rowdata['comments'] . '</div>
                        <span class="comment-edit-button"><button id="editsubmit' . $rowdata['business_profile_post_comment_id'] . '" style="display:none" onClick="edit_comment(' . $rowdata['business_profile_post_comment_id'] . ')">Save</button></span>
                    </div>
                </div>
                <div class="art-comment-menu-design"> 
                    <div class="comment-details-menu" id="likecomment1' . $rowdata['business_profile_post_comment_id'] . '">
                        <a id="' . $rowdata['business_profile_post_comment_id'] . '" onClick="comment_like1(this.id)">';
                        $userid = $this->session->userdata('aileenuser');
                        $contition_array = array('business_profile_post_comment_id' => $rowdata['business_profile_post_comment_id'], 'status' => '1');
                        $businesscommentlike = $this->data['businesscommentlike'] = $this->common->select_data_by_condition('business_profile_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                        $likeuserarray = explode(',', $businesscommentlike[0]['business_comment_like_user']);
                        if (!in_array($userid, $likeuserarray)) {
                            $return_html .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i> ';
                        } else {
                            $return_html .= '<i class="fa fa-thumbs-up main_color" aria-hidden="true"></i>';
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
                            $return_html .= '<span role="presentation" aria-hidden="true"> · </span>
                    <div class="comment-details-menu">
                        <div id="editcommentbox' . $rowdata['business_profile_post_comment_id'] . '" style="display:block;">
                            <a id="' . $rowdata['business_profile_post_comment_id'] . '"   onClick="comment_editbox(this.id)" class="editbox">Edit
                            </a>
                        </div>
                        <div id="editcancle' . $rowdata['business_profile_post_comment_id'] . '" style="display:none;">
                            <a id="' . $rowdata['business_profile_post_comment_id'] . '" onClick="comment_editcancle(this.id)">Cancel
                            </a>
                        </div>
                    </div>';
                        }
                        $userid = $this->session->userdata('aileenuser');
                        $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $rowdata['business_profile_post_id'], 'status' => 1))->row()->user_id;
                        if ($rowdata['user_id'] == $userid || $business_userid == $userid) {
                            $return_html .= '<span role="presentation" aria-hidden="true"> · </span>
                    <div class="comment-details-menu">
                        <input type="hidden" name="post_delete"  id="post_delete' . $rowdata['business_profile_post_comment_id'] . '" value= "' . $rowdata['business_profile_post_id'] . '">
                        <a id="' . $rowdata['business_profile_post_comment_id'] . '"   onClick="comment_delete(this.id)"> Delete<span class="insertcomment' . $rowdata['business_profile_post_comment_id'] . '">
                            </span>
                        </a>
                    </div>';
                        }
                        $return_html .= '<span role="presentation" aria-hidden="true"> · </span>
                    <div class="comment-details-menu">
                        <p>';

                        $return_html .= $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($rowdata['created_date'])));
                        $return_html .= '</br>';
                        $return_html .= '</p></div>
                </div></div>';
                    }
                }
                $return_html .= '</div>
    </div>
</div>
<div class="post-design-commnet-box col-md-12">
    <div class="post-design-proo-img"> ';

                $userid = $this->session->userdata('aileenuser');
                $business_userimage = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => 1))->row()->business_user_image;

                $business_username = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => 1))->row()->company_name;

                if ($business_userimage) {

                    if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                        $a = $business_username;
                        $acr = substr($a, 0, 1);

                        $return_html .= '<div class="post-img-div">';
                        $return_html .= ucfirst(strtolower($acr));
                        $return_html .= '</div>';
                    } else {

                        $return_html .= '<img  src="' . base_url($this->config->item('bus_profile_thumb_upload_path') . $business_userimage) . '"  alt="">';
                    }
                } else {
                    $a = $business_username;
                    $acr = substr($a, 0, 1);

                    $return_html .= '<div class="post-img-div">';
                    $return_html .= ucfirst(strtolower($acr));
                    $return_html .= '</div>';
                }
                $return_html .= '</div>
    <div id="content" class="col-md-12  inputtype-comment cmy_2" >
        <div contenteditable="true" class="editable_text edt_2" name="' . $row['business_profile_post_id'] . '"  id="post_comment' . $row['business_profile_post_id'] . '" placeholder="Add a Comment... " onClick="entercomment(' . $row['business_profile_post_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);"></div>
    </div>';
                $return_html .= form_error('post_comment');
                $return_html .= '<div class="comment-edit-butn">       
        <button id="' . $row['business_profile_post_id'] . '" onClick="insert_comment(this.id)">Comment</button></div>
</div>
</div>
</div> </div>';
            }
        } else {
            $return_html .= '<div class="art_no_post_avl">
                                <h3> Post</h3>
                                <div class="art-img-nn">
                                    <div class="art_no_post_img">

                                        <img src="' . base_url('assets/img/bui-no.png') . '">

                                    </div>
                                    <div class="art_no_post_text">
                                        No Post Available.
                                    </div>
                                </div>
                            </div> ';
        }
        $return_html .= '<div class="nofoundpost">
</div>';
        echo $return_html;
    }

}
