<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Freelancer extends MY_Controller {

    public $data;

    public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('freelancer_apply_model');
        $this->lang->load('message', 'english');
        $this->load->library('S3');
        include ('main_profile_link.php');
        include ('freelancer_include.php');
        $this->data['aileenuser_id'] = $this->session->userdata('aileenuser');

       
    }

    public function index() {
        $userid = $this->session->userdata('aileenuser');
       
        $this->data['title'] = "Freelance | Aileensoul";
        $this->data['freelance_hire_link'] = $this->freelance_hire_profile_link ;
        $this->data['freelance_apply_profile_link'] = $this->freelance_hire_profile_link ;
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->load->view('freelancer/freelancer_main', $this->data);
    }

    public function freelancer_post() {

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'status' => '0');
        $freelancerpostdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if ($freelancerpostdata) {

            $this->load->view('freelancer/freelancer_post/reactivate', $this->data);
        } else {

            $userid = $this->session->userdata('aileenuser');

            $contition_array = array('user_id' => $userid, 'status' => '1', 'is_delete' => '0');
            $jobdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($jobdata[0]['free_post_step'] == 1) {
                redirect('freelance-work/address-information', refresh);
            } else if ($jobdata[0]['free_post_step'] == 2) {
                redirect('freelance-work/professional-information', refresh);
            } else if ($jobdata[0]['free_post_step'] == 3) {
                redirect('freelance-work/rate', refresh);
            } else if ($jobdata[0]['free_post_step'] == 4) {
                redirect('freelance-work/avability', refresh);
            } else if ($jobdata[0]['free_post_step'] == 5) {
                redirect('freelance-work/education', refresh);
            } else if ($jobdata[0]['free_post_step'] == 6) {
                redirect('freelance-work/portfolio', refresh);
            } else if ($jobdata[0]['free_post_step'] == 7) {
                redirect('freelance-work/home', refresh);
            } else {
                redirect('freelance-work/registration', refresh);
            }
        }
    }

    //freelancer workexp first  info page controller start

    public function freelancer_post_basic_information($postid = '') {
        if ($postid != '') {
            $this->data['livepostid'] = $postid;
        }
        $userid = $this->session->userdata('aileenuser');
        //code for check user deactivate start
        $this->freelancer_apply_deactivate_check();
        //code for check user deactivate end
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_fullname,freelancer_post_username,freelancer_post_email,freelancer_post_skypeid,freelancer_post_phoneno,free_post_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userdata) {
            $step = $userdata[0]['free_post_step'];

            if ($step == 1 || $step > 1) {

                $this->data['firstname1'] = $userdata[0]['freelancer_post_fullname'];
                $this->data['lastname1'] = $userdata[0]['freelancer_post_username'];
                $this->data['email1'] = $userdata[0]['freelancer_post_email'];
                $this->data['skypeid1'] = $userdata[0]['freelancer_post_skypeid'];
                $this->data['phoneno1'] = $userdata[0]['freelancer_post_phoneno'];
            }
        }

        $this->data['title'] = "Basic Information | Edit Profile - Freelancer Profile" . TITLEPOSTFIX;
        $this->load->view('freelancer/freelancer_post/freelancer_post_basic_information', $this->data);
    }


//FREELANCER_APPLY POST_BASIC_INFORMATION PAGE DATA INSERT START
    public function freelancer_post_basic_information_insert() {


        if ($this->input->post('livepostid')) {
            $postid = trim($this->input->post('livepostid'));
        }

        $userid = $this->session->userdata('aileenuser');


        $this->form_validation->set_rules('firstname', 'Full Name', 'required');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'EmailId', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('freelancer/freelancer_post/freelancer_post_basic_information');
        } else {

            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $userdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'free_post_step,freelancer_post_fullname,freelancer_post_username,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $first_lastname = trim($this->input->post('firstname')) . " " . trim($this->input->post('lastname'));

            if ($userdata) {
                if ($userdata[0]['free_post_step'] == 7) {
                    $data = array(
                        'free_post_step' => '7'
                    );
                    $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                } else if ($userdata[0]['free_post_step'] > 1) {
                    $data = array(
                        'free_post_step' => $userdata[0]['free_post_step']
                    );
                    $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                } else {
                    $data = array(
                        'free_post_step' => '1'
                    );
                    $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                }

                $data = array(
                    'freelancer_post_fullname' => trim($this->input->post('firstname')),
                    'freelancer_post_username' => trim($this->input->post('lastname')),
                    'freelancer_post_skypeid' => trim($this->input->post('skypeid')),
                    'freelancer_post_email' => trim($this->input->post('email')),
                    'freelancer_post_phoneno' => trim($this->input->post('phoneno')),
                    'freelancer_apply_slug' => $this->setcategory_slug($first_lastname, 'freelancer_apply_slug', 'freelancer_post_reg'),
                    'user_id' => $userid,
                    'modify_date' => date('Y-m-d', time())
                );

                $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                if ($updatedata) {
                    if ($postid) {
                        redirect('freelance-work/address-information/' . $postid, refresh);
                    } else {
                        redirect('freelance-work/address-information', refresh);
                    }
                } else {
                    if ($postid) {
                        redirect('freelance-work/basic-information/' . $postid, refresh);
                    } else {
                        redirect('freelance-work/basic-information', refresh);
                    }
                }
            } else {

                $data = array(
                    'freelancer_post_fullname' => trim($this->input->post('firstname')),
                    'freelancer_post_username' => trim($this->input->post('lastname')),
                    'freelancer_post_skypeid' => trim($this->input->post('skypeid')),
                    'freelancer_post_email' => trim($this->input->post('email')),
                    'freelancer_post_phoneno' => trim($this->input->post('phoneno')),
                    'freelancer_apply_slug' => $this->setcategory_slug($first_lastname, 'freelancer_apply_slug', 'freelancer_post_reg'),
                    'user_id' => $userid,
                    'created_date' => date('Y-m-d', time()),
                    'status' => '1',
                    'is_delete' => '0',
                    'free_post_step' => '1'
                );

                $insert_id = $this->common->insert_data_getid($data, 'freelancer_post_reg');
                if ($insert_id) {
                    if ($postid) {
                        redirect('freelance-work/address-information/' . $postid, refresh);
                    } else {
                        redirect('freelance-work/address-information', refresh);
                    }
                } else {
                    if ($postid) {
                        redirect('freelance-work/basic-information/' . $postid, refresh);
                    } else {
                        redirect('freelance-work/basic-information', refresh);
                    }
                }
            }
        }
    }

//FREELANCER_APPLY POST_BASIC_INFORMATION PAGE DATA INSERT END
    // FREELANCER_HIRE SLUG START
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

// FREELANCER HIRE SLUG END

    function slug_script() {

        $this->db->select('freelancer_post_reg_id,freelancer_post_fullname,freelancer_post_username');
        $res = $this->db->get('freelancer_post_reg')->result();
        foreach ($res as $k => $v) {
            $data = array('freelancer_apply_slug' => $this->setcategory_slug($v->freelancer_post_fullname . " " . $v->freelancer_post_username, 'freelancer_apply_slug', 'freelancer_post_reg'));
            $this->db->where('freelancer_post_reg_id', $v->freelancer_post_reg_id);
            $this->db->update('freelancer_post_reg', $data);
        }
        echo "yes";
    }

//CHECK EMAIL AVAIBILITY OF FREELANCER_APPLY START 
    public function check_email() {

        $email = trim($this->input->post('email'));
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $email1 = $userdata[0]['freelancer_post_email'];
        if ($email1) {
            $condition_array = array('is_delete' => '0', 'user_id !=' => $userid, 'status' => '1');
            $check_result = $this->common->check_unique_avalibility('freelancer_post_reg', 'freelancer_post_email', $email, '', '', $condition_array);
        } else {
            $condition_array = array('is_delete' => '0');
            $check_result = $this->common->check_unique_avalibility('freelancer_post_reg', 'freelancer_post_email', $email, '', '', $condition_array);
        }

        if ($check_result) {
            echo 'true';
            die();
        } else {
            echo 'false';
            die();
        }
    }

//CHECK EMAIL AVAIBILITY OF FREELANCER_APPLY END
//FREELANCER_APPLY USER DEACTIAVTE CHECK START
    public function freelancer_apply_deactivate_check() {
        $userid = $this->session->userdata('aileenuser');
        //IF USER DEACTIVATE PROFILE THEN REDIRECT TO freelancer/freelancer_post/freelancer_post_basic_information START
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');
        $freelancerpost_deactive = $this->data['freelancerpost_deactive'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if ($freelancerpost_deactive) {
            redirect('freelance-work');
        }
        //IF USER DEACTIVATE PROFILE THEN REDIRECT TO freelancer/freelancer_post/freelancer_post_basic_information END  
    }
//FREELANCER_APPLY USER DEACTIAVTE CHECK START
//FREELANCER_APPLY ADDRESS PAGE START
    public function freelancer_post_address_information($postid = '') {

        if ($postid != '') {
            $this->data['livepostid'] = $postid;
        }

        $userid = $this->session->userdata('aileenuser');
        //code for check user deactivate start
        $this->freelancer_apply_deactivate_check();
        //code for check user deactivate end
        // code for display page start
        $this->freelancer_apply_check();
        // code for display page end
        $contition_array = array('status' => '1');
        $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = 'country_id,country_name', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        //USER DATA FETCH
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_country,freelancer_post_state,freelancer_post_city,freelancer_post_pincode,free_post_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //FOR GETTING STATE DATA
        $contition_array = array('status' => '1', 'country_id' => $userdata[0]['freelancer_post_country']);
        $this->data['states'] = $this->common->select_data_by_condition('states', $contition_array, $data = 'state_id,state_name', $sortby = 'state_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //FOR GETTING CITY DATA 
        $contition_array = array('status' => '1', 'state_id' => $userdata[0]['freelancer_post_state']);
        $this->data['cities'] = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_id,city_name', $sortby = 'city_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if ($userdata) {
            $step = $userdata[0]['free_post_step'];
            if ($step == 2 || $step > 2 || ($step >= 1 && $step <= 2)) {
                $this->data['country1'] = $userdata[0]['freelancer_post_country'];
                $this->data['state1'] = $userdata[0]['freelancer_post_state'];
                $this->data['city1'] = $userdata[0]['freelancer_post_city'];
                $this->data['pincode1'] = $userdata[0]['freelancer_post_pincode'];
            }
        }
        $this->data['title'] = "Address Information | Edit Profile - Freelancer Profile" . TITLEPOSTFIX;
        $this->load->view('freelancer/freelancer_post/freelancer_post_address_information', $this->data);
    }

//FREELANCER_APPLY ADDRESS PAGE END
//FUNCTION FOR GET DATA OF STATE AND CITY START
    public function ajax_data() {
        // ajax for degree start
        if (isset($_POST["degree_id"]) && !empty($_POST["degree_id"])) {
            //Get all state data
            $contition_array = array('degree_id' => $_POST["degree_id"], 'status' => '1');
            $stream = $this->data['stream'] = $this->common->select_data_by_condition('stream', $contition_array, $data = '*', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            //Count total number of rows
            //Display states list
            if (count($stream) > 0) {
                echo '<option value="">Select stream</option>';
                foreach ($stream as $st) {
                    echo '<option value="' . $st['stream_id'] . '">' . $st['stream_name'] . '</option>';
                }
            } else {
                echo '<option value="">Stream not available</option>';
            }
        }

        // ajax for degree end
        // ajax for country start
        if (isset($_POST["country_id"]) && !empty($_POST["country_id"])) {
            //Get all state data
            $contition_array = array('country_id' => $_POST["country_id"], 'status' => '1');
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
        // ajax for country end
        // ajax for state start
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
                echo '<option value="0">City not available</option>';
            }
        }
        // ajax for state end
    }

//FUNCTION FOR GET DATA OF STATE AND CITY END
//FREELANCER_APPLY ADDRESS INFORMATION INSERT CODE START
    public function freelancer_post_address_information_insert() {
        $userid = $this->session->userdata('aileenuser');

        if ($this->input->post('livepostid')) {
            $postid = trim($this->input->post('livepostid'));
        }

       // if ($this->input->post('next')) {
            $this->form_validation->set_rules('country', 'Country', 'required');
            $this->form_validation->set_rules('state', 'State', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('freelancer/freelancer_post/freelancer_post_address_information');
            } else {
                $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
                $userdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if ($userdata[0]['free_post_step'] == 7) {
                    $data = array(
                        'free_post_step' => '7'
                    );
                    $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                } else if ($userdata[0]['free_post_step'] > 2) {
                    $data = array(
                        'free_post_step' => $userdata[0]['free_post_step']
                    );
                    $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                } else {
                    $data = array(
                        'free_post_step' => '2'
                    );
                    $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                }
                $data = array(
                    'freelancer_post_country' => trim($this->input->post('country')),
                    'freelancer_post_state' => trim($this->input->post('state')),
                    'freelancer_post_city' => trim($this->input->post('city')),
                    'freelancer_post_pincode' => trim($this->input->post('pincode')),
                    'modify_date' => date('Y-m-d', time())
                );
                $updatdata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                if ($updatdata) {
                    if ($postid) {
                        redirect('freelance-work/professional-information/' . $postid, refresh);
                    } else {
                        redirect('freelance-work/professional-information', refresh);
                    }
                } else {
                    if ($postid) {
                        redirect('freelance-work/address-information/' . $postid, refresh);
                    } else {
                        redirect('freelance-work/address-information', refresh);
                    }
                }
            }
       // }
    }

//FREELANCER_APPLY ADDRESS INFORMATION INSERT CODE END
//FREELANCER_APPLY POST_PROFESSIONAL_INFORMATION PAGE START
//freelancer professional page controller Start
    public function freelancer_post_professional_information($postid = '') {
        if ($postid != '') {
            $this->data['livepostid'] = $postid;
        }

        $userid = $this->session->userdata('aileenuser');
        //code for check user deactivate start
        $this->freelancer_apply_deactivate_check();
        //code for check user deactivate end
// code for display page start
        $this->freelancer_apply_check();
        // code for display page end

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->data['postdata'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_field,freelancer_post_area,freelancer_post_otherskill,freelancer_post_skill_description,freelancer_post_exp_year,freelancer_post_exp_month,free_post_step,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        //Retrieve skill data Start
        $skill_know = explode(',', $userdata[0]['freelancer_post_area']);
        foreach ($skill_know as $sk) {
            $contition_array = array('skill_id' => $sk, 'status' => '1');
            $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
            $detailes[] = $skilldata[0]['skill'];
        }
        $this->data['skill_2'] = implode(',', $detailes);
        //Retrieve skill data End

        $contition_array = array('status' => '1', 'is_other' => '0');
        $this->data['category'] = $this->common->select_data_by_condition('category', $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //for getting univesity data Start
        $contition_array = array('is_delete' => '0', 'category_name !=' => "Other");
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
        $this->data['category_data'] = $this->common->select_data_by_search('category', $search_condition, $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('is_delete' => '0', 'status' => '1', 'category_name' => "Other");
        $this->data['category_otherdata'] = $this->common->select_data_by_condition('category', $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        //for getting univesity data End
        $contition_array = array('status' => '1', 'type' => '1');
        $this->data['skill1'] = $this->common->select_data_by_condition('skill', $contition_array, $data = '*', $sortby = 'skill', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userdata) {
            $step = $userdata[0]['free_post_step'];
            if ($step == 3 || ($step >= 1 && $step <= 3) || $step > 3) {
                $this->data['fields_req1'] = $userdata[0]['freelancer_post_field'];
                $this->data['area1'] = $userdata[0]['freelancer_post_area'];
                $this->data['otherskill1'] = $userdata[0]['freelancer_post_otherskill'];
                $this->data['skill_description1'] = $userdata[0]['freelancer_post_skill_description'];
                $this->data['experience_year1'] = $userdata[0]['freelancer_post_exp_year'];
                $this->data['experience_month1'] = $userdata[0]['freelancer_post_exp_month'];
            }
        }
        $this->data['title'] = "Professional Information | Edit Profile - Freelancer Profile" . TITLEPOSTFIX;
        $this->load->view('freelancer/freelancer_post/freelancer_post_professional_information', $this->data);
    }

//FREELANCER_APPLY POST_PROFESSIONAL_INFORMATION PAGE START
//FREELANCER_APPLY POST_PROFESSIONAL_INFORMATION INSERT DATA START
    public function freelancer_post_professional_information_insert() {
        if ($this->input->post('livepostid')) {
            $postid = trim($this->input->post('livepostid'));
        }

        $userid = $this->session->userdata('aileenuser');
        $skill1 = $this->input->post('skills');
        $skills = explode(',', $skill1);

        //if ($this->input->post('next')) {
            $this->form_validation->set_rules('field', 'Field', 'required');
            $this->form_validation->set_rules('skill_description', 'Skill Description', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('freelancer/freelancer_post/freelancer_post_professional_information');
            } else {

                $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
                $userdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($userdata[0]['free_post_step'] == 7) {
                    $data = array(
                        'free_post_step' => '7'
                    );
                    $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                } else if ($userdata[0]['free_post_step'] > 3) {
                    $data = array(
                        'free_post_step' => $userdata[0]['free_post_step']
                    );

                    $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                } else {
                    $data = array(
                        'free_post_step' => '3'
                    );
                    $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                }
                if (count($skills) > 0) {
                    foreach ($skills as $ski) {
                        if ($ski != " ") {
                            $contition_array = array('skill' => trim($ski), 'type' => '1');
                            $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                            if (count($skilldata) < 0) {
                                $contition_array = array('skill' => trim($ski), 'type' => '5');
                                $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                            }
                            if ($skilldata) {
                                $skill[] = $skilldata[0]['skill_id'];
                            } else {
                                $data = array(
                                    'skill' => trim($ski),
                                    'status' => '1',
                                    'type' => '5',
                                    'user_id' => $userid,
                                );
                                $skill[] = $this->common->insert_data_getid($data, 'skill');
                            }
                        }
                    }
                    $skill = array_unique($skill, SORT_REGULAR);
                    $skills = implode(',', $skill);
                }
                $data = array(
                    'freelancer_post_field' => trim($this->input->post('field')),
                    'freelancer_post_area' => $skills,
                    'freelancer_post_otherskill' => trim($this->input->post('otherskill')),
                    'freelancer_post_skill_description' => trim($this->input->post('skill_description')),
                    'freelancer_post_exp_month' => trim($this->input->post('experience_month')),
                    'freelancer_post_exp_year' => trim($this->input->post('experience_year')),
                    'modify_date' => date('Y-m-d', time())
                );
                $updatdata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                if ($updatdata) {
                    if ($postid) {
                        redirect('freelance-work/rate/' . $postid, refresh);
                    } else {
                        redirect('freelance-work/rate', refresh);
                    }
                } else {
                    if ($postid) {
                        redirect('freelance-work/rate/' . $postid, refresh);
                    } else {
                        redirect('freelance-work/rate', refresh);
                    }
                }
            }
        //}
    }

//FREELANCER_APPLY POST_PROFESSIONAL_INFORMATION INSERT DATA END
//FREELANCER_APPLY RATE PAGE START
//freelancer rate page controller Start 
    public function freelancer_post_rate($postid = '') {

        if ($postid != '') {
            $this->data['livepostid'] = $postid;
        }
        $userid = $this->session->userdata('aileenuser');
//code for check user deactivate start
        $this->freelancer_apply_deactivate_check();
        //code for check user deactivate end
// code for display page start
        $this->freelancer_apply_check();
        // code for display page end
        $contition_array = array('status' => '1', 'is_delete' => '0');
        $this->data['currency'] = $this->common->select_data_by_condition('currency', $contition_array, $data = '*', $sortby = 'currency_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_hourly,freelancer_post_ratestate,freelancer_post_fixed_rate,free_post_step,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userdata) {
            $step = $userdata[0]['free_post_step'];
            if ($step == 4 || ($step >= 1 && $step <= 4) || $step > 4) {
                $this->data['hourly1'] = $userdata[0]['freelancer_post_hourly'];
                $this->data['currency1'] = $userdata[0]['freelancer_post_ratestate'];
                $this->data['fixed_rate1'] = $userdata[0]['freelancer_post_fixed_rate'];
            }
        }
        $this->data['title'] = "Rate | Edit Profile - Freelancer Profile" . TITLEPOSTFIX;
        $this->load->view('freelancer/freelancer_post/freelancer_post_rate', $this->data);
    }

//FREELANCER_APPLY RATE PAGE END
//FREELANCER_APPLY RATE PAGE DATA INSERT START
    public function freelancer_post_rate_insert() {
        if ($this->input->post('livepostid')) {
            $postid = trim($this->input->post('livepostid'));
        }
        $userid = $this->session->userdata('aileenuser');

       // if ($this->input->post('next')) {
            if ($this->input->post('fixed_rate') == 1) {
                $data = array(
                    'freelancer_post_fixed_rate' => trim($this->input->post('fixed_rate')),
                );
            } else {
                $data = array(
                    'freelancer_post_fixed_rate' => '0',
                );
            }
            $updatdata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);

            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $userdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if ($userdata[0]['free_post_step'] == 7) {
                $data = array(
                    'free_post_step' => '7'
                );
                $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
            } else if ($userdata[0]['free_post_step'] > 4) {
                $data = array(
                    'free_post_step' => $userdata[0]['free_post_step']
                );
                $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
            } else {
                $data = array(
                    'free_post_step' => '4'
                );
                $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
            }
            $data = array(
                'freelancer_post_hourly' => trim($this->input->post('hourly')),
                'freelancer_post_ratestate' => trim($this->input->post('state')),
                'modify_date' => date('Y-m-d', time())
            );
            $updatdata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
            if ($updatdata) {
                // $this->session->set_flashdata('success', 'Rate information updated successfully');
                if ($postid) {
                    redirect('freelance-work/avability/' . $postid, refresh);
                } else {
                    redirect('freelance-work/avability', refresh);
                }
            } else {
                //  $this->session->flashdata('error', 'Your data not inserted');
                if ($postid) {
                    redirect('freelance-work/rate/' . $postid, refresh);
                } else {
                    redirect('freelance-work/rate', refresh);
                }
            }
       // }
    }

//FREELANCER_APPLY RATE PAGE DATA INSERT END
//FREELANCER_APPLY AVABILITY PAGE START
//freelancer avability page controller Start
    public function freelancer_post_avability($postid = '') {
        if ($postid != '') {
            $this->data['livepostid'] = $postid;
        }
        $userid = $this->session->userdata('aileenuser');
//code for check user deactivate start
        $this->freelancer_apply_deactivate_check();
        //code for check user deactivate end
        // code for display page start
        $this->freelancer_apply_check();
        // code for display page end
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_job_type,freelancer_post_work_hour,free_post_step,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if ($userdata) {
            $step = $userdata[0]['free_post_step'];

            if ($step == 5 || ($step >= 1 && $step <= 5) || $step > 5) {

                $this->data['job_type1'] = $userdata[0]['freelancer_post_job_type'];
                $this->data['work_hour1'] = $userdata[0]['freelancer_post_work_hour'];
            }
        }
        $this->data['title'] = "Avability | Edit Profile - Freelancer Profile" . TITLEPOSTFIX;
        $this->load->view('freelancer/freelancer_post/freelancer_post_avability', $this->data);
    }

//FREELANCER_APPLY AVABILITY PAGE END
//FREELANCER_APPLY AVABILITY PAGE DATA INSERT START
    public function freelancer_post_avability_insert() {
        if ($this->input->post('livepostid')) {
            $postid = trim($this->input->post('livepostid'));
        }
        $userid = $this->session->userdata('aileenuser');
        if ($this->input->post('previous')) {
            redirect('freelancer/freelancer_post_rate', refresh);
        }

        //if ($this->input->post('next')) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $userdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if ($userdata[0]['free_post_step'] == 7) {
                $data = array(
                    'free_post_step' => '7'
                );
                $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
            } else if ($userdata[0]['free_post_step'] > 5) {
                $data = array(
                    'free_post_step' => $userdata[0]['free_post_step']
                );
                $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
            } else {
                $data = array(
                    'free_post_step' => '5'
                );
                $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
            }
            $data = array(
                'freelancer_post_job_type' => trim($this->input->post('job_type')),
                'freelancer_post_work_hour' => trim($this->input->post('work_hour')),
                'modify_date' => date('Y-m-d', time())
            );

            $updatdata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
            if ($updatdata) {
                if ($postid) {
                    redirect('freelance-work/education/' . $postid, refresh);
                } else {
                    redirect('freelance-work/education', refresh);
                }
            } else {
                if ($postid) {
                    redirect('freelance-work/avability/' . $postid, refresh);
                } else {
                    redirect('freelance-work/avability', refresh);
                }
            }
      //  }
    }

//FREELANCER_APPLY AVABILITY PAGE DATA INSERT END
//FREELANCER_APPLY EDUCATION PAGE START
    public function freelancer_post_education($postid = '') {

        if ($postid != '') {
            $this->data['livepostid'] = $postid;
        }

        $userid = $this->session->userdata('aileenuser');
//code for check user deactivate start
        $this->freelancer_apply_deactivate_check();
        //code for check user deactivate end
// code for display page start
        $this->freelancer_apply_check();
        // code for display page end
        //for getting degree data Strat
        $contition_array = array('is_delete' => '0', 'degree_name !=' => "Other");
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
        $degree_data = $this->data['degree_data'] = $this->common->select_data_by_search('degree', $search_condition, $contition_array, $data = '*', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('status' => '1', 'is_delete' => '0', 'degree_name' => "Other");
        $this->data['degree_otherdata'] = $this->common->select_data_by_condition('degree', $contition_array, $data = '*', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        //for getting degree data End
        //For getting all Stream Strat
        $contition_array = array('is_delete' => '0', 'stream_name !=' => "Other");
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1')) AND stream_name != 'Others'";
        $stream_alldata = $this->data['stream_alldata'] = $this->common->select_data_by_search('stream', $search_condition, $contition_array, $data = '*', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = 'stream_name');


        $contition_array = array('status' => '1', 'is_delete' => '0', 'stream_name' => "Other");
        $stream_otherdata = $this->data['stream_otherdata'] = $this->common->select_data_by_condition('stream', $contition_array, $data = '*', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = 'stream_name');
        //For getting all Stream End
        //for getting univesity data Start
        $contition_array = array('is_delete' => '0', 'university_name !=' => "Other");
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
        $university_data = $this->data['university_data'] = $this->common->select_data_by_search('university', $search_condition, $contition_array, $data = '*', $sortby = 'university_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('is_delete' => '0', 'status' => '1', 'university_name' => "Other");
        $this->data['university_otherdata'] = $this->common->select_data_by_condition('university', $contition_array, $data = '*', $sortby = 'university_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        //for getting univesity data End
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_degree,freelancer_post_stream,freelancer_post_univercity,freelancer_post_collage,freelancer_post_percentage,freelancer_post_passingyear,free_post_step,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userdata) {
            $step = $userdata[0]['free_post_step'];
            if ($step == 6 || ($step >= 1 && $step <= 6) || $step > 6) {
                $this->data['degree1'] = $userdata[0]['freelancer_post_degree'];
                $this->data['stream1'] = $userdata[0]['freelancer_post_stream'];
                $this->data['university1'] = $userdata[0]['freelancer_post_univercity'];
                $this->data['college1'] = $userdata[0]['freelancer_post_collage'];
                $this->data['percentage1'] = $userdata[0]['freelancer_post_percentage'];
                $this->data['pass_year1'] = $userdata[0]['freelancer_post_passingyear'];
            }
        }
        $this->data['title'] = "Eduction | Edit Profile - Freelancer Profile" . TITLEPOSTFIX;
        $this->load->view('freelancer/freelancer_post/freelancer_post_education', $this->data);
    }

//FREELANCER_APPLY EDUCATION PAGE END
//ADD OTHER UNIVERSITY INTO DATABASE START
    public function freelancer_other_university() {
        $other_university = $_POST['other_university'];
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        $contition_array = array('is_delete' => '0', 'university_name' => $other_university);
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
        $userdata = $this->data['userdata'] = $this->common->select_data_by_search('university', $search_condition, $contition_array, $data = '*', $sortby = 'university_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $count = count($userdata);

        if ($other_university != NULL) {
            if ($count == 0) {
                $data = array(
                    'university_name' => $other_university,
                    'created_date' => date('Y-m-d h:i:s', time()),
                    'status' => '2',
                    'is_delete' => '0',
                    'is_other' => '1',
                    'user_id' => $userid
                );
                $insert_id = $this->common->insert_data_getid($data, 'university');
                if ($insert_id) {

                    $contition_array = array('is_delete' => '0', 'university_name !=' => "Other");
                    $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
                    $university = $this->data['university'] = $this->common->select_data_by_search('university', $search_condition, $contition_array, $data = '*', $sortby = 'university_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    if (count($university) > 0) {
                        $select = '<option value="" selected option disabled>Select your University</option>';
                        foreach ($university as $st) {
                            $select .= '<option value="' . $st['university_id'] . '"';
                            if ($st['university_name'] == $other_university) {
                                $select .= 'selected';
                            }
                            $select .= '>' . $st['university_name'] . '</option>';
                        }
                    }
//For Getting Other at end
                    $contition_array = array('is_delete' => '0', 'status' => '1', 'university_name' => "Other");
                    $university_otherdata = $this->common->select_data_by_condition('university', $contition_array, $data = '*', $sortby = 'university_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    $select .= '<option value="' . $university_otherdata[0]['university_id'] . '">' . $university_otherdata[0]['university_name'] . '</option>';
                }
            } else {
                $select .= 0;
            }
        } else {
            $select .= 1;
        }
        echo json_encode(array(
            "select" => $select,
        ));
    }

//ADD OTHER UNIVERSITY INTO DATABASE END
//FREELANCER_APPLY EDUCATION PAGE DATA INSERT START
    public function freelancer_post_education_insert() {

        if ($this->input->post('livepostid')) {
            $postid = trim($this->input->post('livepostid'));
        }

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if ($userdata[0]['free_post_step'] == 7) {
            $data = array(
                'free_post_step' => '7'
            );
            $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
        } else if ($userdata[0]['free_post_step'] > 6) {
            $data = array(
                'free_post_step' => $userdata[0]['free_post_step']
            );
            $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
        } else {
            $data = array(
                'free_post_step' => '6'
            );
            $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
        }
        $data = array(
            'freelancer_post_degree' => trim($this->input->post('degree')),
            'freelancer_post_stream' => trim($this->input->post('stream')),
            'freelancer_post_univercity' => trim($this->input->post('university')),
            'freelancer_post_collage' => trim($this->input->post('college')),
            'freelancer_post_percentage' => trim($this->input->post('percentage')),
            'freelancer_post_passingyear' => trim($this->input->post('passingyear')),
            'modify_date' => date('Y-m-d', time())
        );
        $updatdata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
        if ($updatdata) {
            // $this->session->set_flashdata('success', 'Education information updated successfully');
            if ($postid) {
                redirect('freelance-work/portfolio/' . $postid, refresh);
            } else {
                redirect('freelance-work/portfolio', refresh);
            }
        } else {
            // $this->session->flashdata('error', 'Your data not inserted');
            if ($postid) {
                redirect('freelance-work/education/' . $postid, refresh);
            } else {
                redirect('freelance-work/education', refresh);
            }
        }
    }

//FREELANCER_APPLY EDUCATION PAGE DATA INSERT END
//FREELANCER_APPLY PORTFOLIO PAGE START
    public function freelancer_post_portfolio($postid = '') {
        if ($postid != '') {
            $this->data['livepostid'] = $postid;
        }

        $userid = $this->session->userdata('aileenuser');
//code for check user deactivate start
        $this->freelancer_apply_deactivate_check();
        //code for check user deactivate end
// code for display page start
        $this->freelancer_apply_check();
// code for display page end
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_portfolio,freelancer_post_portfolio_attachment,free_post_step,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $this->data['free_post_step'] = $userdata[0]['free_post_step'];
        if ($userdata) {
            $step = $userdata[0]['free_post_step'];
            if ($step == 7 || ($step >= 1 && $step <= 7) || $step > 7) {
                $this->data['portfolio1'] = $userdata[0]['freelancer_post_portfolio'];
                $this->data['portfolio_attachment1'] = $userdata[0]['freelancer_post_portfolio_attachment'];
            }
        }
        $this->data['title'] = "Portfolio | Edit Profile - Freelancer Profile" . TITLEPOSTFIX;
        $this->load->view('freelancer/freelancer_post/freelancer_post_portfolio', $this->data);
    }

//FREELANCER_APPLY PORTFOLIO PAGE END
//FREELANCER_APPLY PORTFOLIO PAGE DATA INSERT START
    public function freelancer_post_portfolio_insert($postliveid = '') {

        $portfolio = $_POST['portfolio'];
        $userid = $this->session->userdata('aileenuser');
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');

        $userdatacon = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $portfolio = trim($_POST['portfolio']);
        $image_hidden_portfolio = $_POST['image_hidden_portfolio'];
        $config = array(
            'upload_path' => $this->config->item('free_portfolio_main_upload_path'),
            'max_size' => 2500000000000,
            'allowed_types' => $this->config->item('free_portfolio_main_allowed_types'),
            'file_name' => $_FILES['freelancer_post_portfolio_attachment']['name']
        );
        //Load upload library and initialize configuration
        $images = array();
        $files = $_FILES;

        $this->load->library('upload');

        $fileName = $_FILES['image']['name'];
        $images[] = $fileName;
        $config['file_name'] = $fileName;

        $this->upload->initialize($config);
        $this->upload->do_upload();
        if ($this->upload->do_upload('image')) {

            $response['result'] = $this->upload->data();
            $art_post_thumb['image_library'] = 'gd2';
            $art_post_thumb['source_image'] = $this->config->item('free_portfolio_main_upload_path') . $response['result']['file_name'];
            $art_post_thumb['new_image'] = $this->config->item('free_portfolio_thumb_upload_path') . $response['result']['file_name'];
            $art_post_thumb['create_thumb'] = TRUE;
            $art_post_thumb['maintain_ratio'] = TRUE;
            $art_post_thumb['thumb_marker'] = '';
            $art_post_thumb['width'] = $this->config->item('art_portfolio_thumb_width');
            $art_post_thumb['height'] = 2;
            $art_post_thumb['master_dim'] = 'width';
            $art_post_thumb['quality'] = "100%";
            $art_post_thumb['x_axis'] = '0';
            $art_post_thumb['y_axis'] = '0';
            $instanse = "image_$i";
            //Loading Image Library
            $this->load->library('image_lib', $art_post_thumb, $instanse);
            $dataimage = $response['result']['file_name'];

            //Creating Thumbnail
            $this->$instanse->resize();
            $response['error'][] = $thumberror = $this->$instanse->display_errors();
            $return['data'][] = $this->upload->data();
            $return['status'] = "success";
            $return['msg'] = sprintf($this->lang->line('success_item_added'), "Image", "uploaded");
        } else {
            $dataimage = $image_hidden_portfolio;
        }
        $data = array(
            'freelancer_post_portfolio_attachment' => $dataimage,
            'freelancer_post_portfolio' => $portfolio,
            'modify_date' => date('Y-m-d', time()),
            'free_post_step' => '7'
        );
        $updatdata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
    }

//FREELANCER_APPLY PORTFOLIO PAGE DATA INSERT END


    public function text2link($text) {
        $text = preg_replace('/(((f|ht){1}t(p|ps){1}:\/\/)[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '<a href="\\1" target="_blank" rel="nofollow">\\1</a>', $text);
        $text = preg_replace('/([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '\\1<a href="http://\\2" target="_blank" rel="nofollow">\\2</a>', $text);
        $text = preg_replace('/([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})/i', '<a href="mailto:\\1" rel="nofollow" target="_blank">\\1</a>', $text);
        return $text;
    }


    public function aasort(&$array, $key) {
        $sorter = array();
        $ret = array();
        reset($array);

        foreach ($array as $ii => $va) {
            $sorter[$ii] = $va[$key];
        }

        arsort($sorter);

        foreach ($sorter as $ii => $va) {

            $ret[$ii] = $array[$ii];
        }

        return $array = $ret;
    }

    public function ajax_dataforcity() {

        if (isset($_POST["country_id"]) && !empty($_POST["country_id"])) {
            //Get all state data
            $contition_array = array('country_id' => $_POST["country_id"], 'status' => '1');
            $state = $this->data['states'] = $this->common->select_data_by_condition('states', $contition_array, $data = '*', $sortby = 'state_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            //Count total number of rows
            //Display states list
            if (count($state) > 0) {
                echo '<option value = "">Select state</option>';
                foreach ($state as $st) {
                    echo '<option value = "' . $st['state_id'] . '">' . $st['state_name'] . '</option>';
                }
            } else {
                echo '<option value = "">State not available</option>';
            }
        }

        if (isset($_POST["state_id"]) && !empty($_POST["state_id"])) {
            //Get all city data
            $contition_array = array('state_id' => $_POST["state_id"], 'status' => '1');
            $city = $this->data['city'] = $this->common->select_data_by_condition('cities', $contition_array, $data = '*', $sortby = 'city_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            //Display cities list
            if (count($city) > 0) {
                echo '<option value = "">Select city</option>';
                foreach ($city as $cit) {
                    echo '<option value = "' . $cit['city_id'] . '">' . $cit['city_name'] . '</option>';
                }
            } else {
                echo '<option value = "">City not available</option>';
            }
        }
    }

        //FREELANCER_APPLY HOME PAGE START
    public function freelancer_apply_post($id = "") {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        //code for check user deactivate start
        $this->freelancer_apply_deactivate_check();
        //code for check user deactivate end
        // code for display page start
        $this->freelancer_apply_check();
        // code for display page end
        $this->progressbar();
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1', 'free_post_step' => '7');
        $freelancerdata = $this->data['freelancerdata'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->data['title'] = 'Home | Freelancer Profile' . TITLEPOSTFIX;
        $this->load->view('freelancer/freelancer_post/post_apply', $this->data);
    }

//FREELANCER_APPLY HOME PAGE END
//AJAX FREELANCER_APPLY HOME PAGE START
    public function ajax_freelancer_apply_post() {
        $userid = $this->session->userdata('aileenuser');
        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $freelancerdata = $this->data['freelancerdata'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $freelancer_post_area = $freelancerdata[0]['freelancer_post_area'];
        $post_reg_skill = explode(',', $freelancer_post_area);
        foreach ($post_reg_skill as $key => $value) {
            $contition_array = array('is_delete' => '0', 'status' => '1', 'user_id !=' => $userid, 'FIND_IN_SET("' . $value . '",post_skill)!=' => '0');
            $freelancer_post_data = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data = '*', $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if ($freelancer_post_data) {
                $freedata[] = $freelancer_post_data;
            }
        }
        //        TO CHANGE ARRAY OF ARRAY TO ARRAY START
        $final_post = array_reduce($freedata, 'array_merge', array());
        //        TO CHANGE ARRAY OF ARRAY TO ARRAY END
        // change the order to decending           
        rsort($final_post);
        //RECOMMEN PROJECT BY FIELD START
        $contition_array = array('status' => '1', 'is_delete' => '0', 'user_id != ' => $userid, 'post_field_req' => $freelancerdata[0]['freelancer_post_field']);
        $freelancer_post_field = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data = '*', $sortby = 'post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $all_post = array_merge((array) $final_post, (array) $freelancer_post_field);
        $unique = array_unique($all_post, SORT_ASC);

        $postdetail = array_slice($unique, $start, $perpage);

        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($unique);
        }
        $return_html = '';
        $return_html .= '<input type = "hidden" class = "page_number" value = "' . $page . '" />';
        $return_html .= '<input type = "hidden" class = "total_record" value = "' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';


        if (count($unique) > 0) {
            foreach ($postdetail as $post) {

                $return_html .= '<div class="all-job-box" id="removeapply' . $post['post_id'] . '">
                                    <div class="all-job-top">';
                $cache_time1 = $post['post_name'];

                if ($cache_time1 != '') {
                    $text = strtolower($this->common->clean($cache_time1));
                } else {
                    $text = '';
                }

                $city = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->city;
                $cityname = $this->db->get_where('cities', array('city_id' => $city))->row()->city_name;

                if ($cityname != '') {
                    $cityname1 = '-vacancy-in-' . strtolower($this->common->clean($cityname));
                } else {
                    $cityname1 = '';
                }

                $firstname = $this->db->select('fullname')->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->fullname;
                $lastname = $this->db->select('username')->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->username;
                $hireslug = $this->db->select('freelancer_hire_slug')->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->freelancer_hire_slug;


                $return_html .= '<div class="job-top-detail">';
                $return_html .= '<h5><a title ="' . $post['post_name'] . '" href="' . base_url('freelance-hire/project/' . $text . $cityname1 . '-' . $post['user_id'] . '-' . $post['post_id']) . ' ">';
                $return_html .= $post['post_name'];
                $return_html .= '</a></h5>';
                $return_html .= '<p><a title = "' . ucwords($firstname) . " " . ucwords($lastname) . '" href="' . base_url('freelance-hire/employer-details/' . $hireslug) . '">';
                $return_html .= ucwords($firstname) . " " . ucwords($lastname);
                $return_html .= '</a></p>
            </div>
            </div>
            <div class="all-job-middle">
                <p class="pb5">
                    <span class="location">';
                $return_html .= '<span><img alt= "location" class="pr5" src="' . base_url('assets/images/location.png') . '">';
                $city = $this->db->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->city;
                $cityname = $this->db->get_where('cities', array('city_id' => $city))->row()->city_name;
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
                        <span><img alt= "skill" class="pr5" src="' . base_url('assets/images/exp.png') . '">';

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
                    $return_html .= '.....<a href="' . base_url('freelance-hire/project/' . $text . $cityname1 . '-' . $post['user_id'] . '-' . $post['post_id']) . ' " title = "Read more">Read more</a>';
                }
                $return_html .= '</p>

            </div>
            <div class="all-job-bottom">
                <span class="job-post-date"><b>Posted on: </b>';
                $return_html .= trim(date('d-M-Y', strtotime($post['created_date'])));
                $return_html .= '</span>
                <p class="pull-right">';

                $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
                $contition_array = array('post_id' => $post['post_id'], 'job_delete' => '0', 'user_id' => $userid);
                $freelancerapply1 = $this->data['freelancerapply'] = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($freelancerapply1) {
                    $return_html .= '<a title="Applied" href="javascript:void(0);" class="btn4  applied">Applied</a>';
                } else {
                    $return_html .= '<a title = "Apply" href="javascript:void(0);"  class= "btn4 applypost' . $post['post_id'] . '" onclick="applypopup(' . $post['post_id'] . ' , ' . $post['user_id'] . ')">Apply</a>';
                    $userid = $this->session->userdata('aileenuser');
                    $contition_array = array('user_id' => $userid, 'job_save' => '2', 'post_id ' => $post['post_id'], 'job_delete' => '1');
                    $data = $this->data['jobsave'] = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    if ($data) {
                        $return_html .= '<a title = "Saved" href="javascript:void(0);" class="btn4 saved savedpost' . $post['post_id'] . '">Saved</a>';
                    } else {
                        $return_html .= '<a title = "Save" href="javascript:void(0);" id="' . $post['post_id'] . '" onClick="savepopup(' . $post['post_id'] . ')" class="btn4 savedpost' . $post['post_id'] . '">Save</a>';
                    }
                }

                $return_html .= ' </p>

</div>
</div>';
            }
        } else {
            $return_html .= '<div class="art-img-nn">
                                                <div class="art_no_post_img">

                                                    <img alt="No recommended projects" src="../assets/img/free-no1.png">

                                                </div>
                                                <div class="art_no_post_text">';
            $return_html .= $this->lang->line("no_recommen_project");
            $return_html .= ' </div>
                                            </div>';
        }
        echo $return_html;
    }

//AJAX FREELANCER_APPLY HOME PAGE END
//FREELANCER_APPLY CHECK USER IS REGISTERD START
    public function freelancer_apply_check() {
        $userid = $this->session->userdata('aileenuser');
        $contition_array = array('user_id' => $userid, 'status' => '1', 'is_delete' => '0');

        $apply_step = $this->data['apply_step'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'free_post_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if (count($apply_step) > 0) {
            if ($apply_step[0]['free_post_step'] == 1) {
                if ($this->uri->segment(2) == 'address-information') {
                    
                } else {
                    redirect('freelancer/freelancer_post/freelancer_post_address_information');
                }
            } elseif ($apply_step[0]['free_post_step'] == 2) {
                // echo "222";die();
                if ($this->uri->segment(2) == 'professional-information') {
                    
                } elseif ($this->uri->segment(2) == 'address-information') {
                    
                } else {
                    redirect('freelancer/freelancer_post/freelancer_post_professional_information');
                }
            } elseif ($apply_step[0]['free_post_step'] == 3) {
                if ($this->uri->segment(2) == 'rate') {
                    
                } elseif ($this->uri->segment(2) == 'professional-information') {
                    
                } elseif ($this->uri->segment(2) == 'address-information') {
                    
                } else {
                    redirect('freelancer/freelancer_post/freelancer_post_rate');
                }
            } elseif ($apply_step[0]['free_post_step'] == 4) {
                if ($this->uri->segment(2) == 'avability') {
                    
                } elseif ($this->uri->segment(2) == 'rate') {
                    
                } elseif ($this->uri->segment(2) == 'professional-information') {
                    
                } elseif ($this->uri->segment(2) == 'address-information') {
                    
                } else {
                    redirect('freelancer/freelancer_post/freelancer_post_avability');
                }
            } elseif ($apply_step[0]['free_post_step'] == 5) {
                if ($this->uri->segment(2) == 'education') {
                    
                } elseif ($this->uri->segment(2) == 'avability') {
                    
                } elseif ($this->uri->segment(2) == 'rate') {
                    
                } elseif ($this->uri->segment(2) == 'professional-information') {
                    
                } elseif ($this->uri->segment(2) == 'address-information') {
                    
                } else {
                    redirect('freelancer/freelancer_post/freelancer_post_education');
                }
            } elseif ($apply_step[0]['free_post_step'] == 6) {
                if ($this->uri->segment(2) == 'portfolio') {
                    
                } elseif ($this->uri->segment(2) == 'education') {
                    
                } elseif ($this->uri->segment(2) == 'avability') {
                    
                } elseif ($this->uri->segment(2) == 'rate') {
                    
                } elseif ($this->uri->segment(2) == 'professional-information') {
                    
                } elseif ($this->uri->segment(2) == 'address-information') {
                    
                } else {
                    redirect('freelancer/freelancer_post/freelancer_post_portfolio');
                }
            } else {
                
            }
        } else {
            redirect('freelance-work');
        }
    }

//FREELANCER_APPLY CHECK USER IS REGISTERD END
    

//Freelancer Job All Post controller end
//FREELANCER_APPLY APPLY TO PROJECT START
    public function apply_insert() {
        $id = $_POST['post_id'];
        $para = $_POST['allpost'];
        $notid = $_POST['userid'];

        $userid = $this->session->userdata('aileenuser');
        $this->data['jobdata'] = $postdtaa = $this->common->select_data_by_id('freelancer_post', 'post_id', $id, $data = 'user_id', $join_str = array());
        if ($postdtaa[0]['user_id'] == $userid) {

            $this->session->set_flashdata('error', 'You can not apply on your own post');
        } else {
            $contition_array = array('post_id' => $id, 'user_id' => $userid, 'is_delete' => '0');
            $userdata = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('user_id' => $userid);
            $hiredata = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'email', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $app_id = $userdata[0]['app_id'];

            if ($userdata) {

                $contition_array = array('job_delete' => '1');
                $jobdata = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = 'app_id', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $data = array(
                    'job_delete' => '0',
                    'job_save' => '3',
                    'modify_date' => date('Y-m-d h:i:s', time())
                );

                $updatedata = $this->common->update_data($data, 'freelancer_apply', 'app_id', $app_id);
                $data = array(
                    'not_type' => '3',
                    'not_from_id' => $userid,
                    'not_to_id' => $notid,
                    'not_read' => '2',
                    'not_from' => '4',
                    'not_product_id' => $app_id,
                    "not_active" => '1',
                    'not_created_date' => date('Y-m-d H:i:s')
                );
                $updatedata = $this->common->insert_data_getid($data, 'notification');
                // end notoification
                if ($updatedata) {
                    if ($para == 'all') {
                        // apply mail start
                        $this->apply_email($notid);

                        $applypost = 'Applied';
                    }
                }
                // GET NOTIFICATION COUNT
                $not_count = $this->freelancer_notification_count($notid);

                echo json_encode(
                        array(
                            "status" => 'Applied',
                            "notification" => array('notification_count' => $not_count, 'to_id' => $notid),
                ));
            } else {

                $data = array(
                    'post_id' => $id,
                    'user_id' => $userid,
                    'status' => '1',
                    'created_date' => date('Y-m-d h:i:s', time()),
                    'modify_date' => date('Y-m-d h:i:s', time()),
                    'is_delete' => '0',
                    'job_delete' => '0',
                    'job_save' => '3'
                );
                $insert_id = $this->common->insert_data_getid($data, 'freelancer_apply');
                // insert notification
                $data = array(
                    'not_type' => '3',
                    'not_from_id' => $userid,
                    'not_to_id' => $notid,
                    'not_read' => '2',
                    'not_from' => '4',
                    'not_product_id' => $insert_id,
                    "not_active" => '1',
                    'not_created_date' => date('Y-m-d H:i:s')
                );

                $insert_id = $this->common->insert_data_getid($data, 'notification');
                // end notoification
                if ($insert_id) {
                    $this->apply_email($notid);
                    $applypost = 'Applied';
                }
                // GET NOTIFICATION COUNT
                $not_count = $this->freelancer_notification_count($notid);

                echo json_encode(
                        array(
                            "status" => 'Applied',
                            "notification" => array('notification_count' => $not_count, 'to_id' => $notid),
                ));
            }
            $this->session->set_flashdata('success', 'Applied Sucessfully ......');
        }
    }

//FREELANCER_APPLY APPLY TO PROJECT START
//FREELANCER_APPLY APPLIED ON POST(PROJECTS) START
    public function freelancer_applied_post() {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
//code for check user deactivate start
        $this->freelancer_apply_deactivate_check();
        //code for check user deactivate end
        // code for display page start
        $this->freelancer_apply_check();
        // code for display page end
        $this->progressbar();
// job seeker detail
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $jobdata = $this->data['jobdata'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $join_str[0]['table'] = 'freelancer_apply';
        $join_str[0]['join_table_id'] = 'freelancer_apply.post_id';
        $join_str[0]['from_table_id'] = 'freelancer_post.post_id';
        $join_str[0]['join_type'] = '';

        $contition_array = array('freelancer_apply.job_delete' => '0', 'freelancer_apply.user_id' => $userid);
        $postdata = $this->data['postdata'] = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data = 'freelancer_post.*, freelancer_apply.app_id, freelancer_apply.user_id as userid, freelancer_apply.modify_date, freelancer_apply.created_date ', $sortby = 'freelancer_apply.modify_date', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

        $this->data['title'] = ucfirst($jobdata[0]['freelancer_post_fullname']) . " " . ucfirst($jobdata[0]['freelancer_post_username']) . " | Applied Projects | Freelancer Profile" . TITLEPOSTFIX;
        $this->load->view('freelancer/freelancer_post/freelancer_applied_post', $this->data);
    }

//FREELANCER_APPLY APPLIED ON POST(PROJECTS) START
// AJAX FREELANCER_APPLY APLLIED ON POST(PROJECT) START
    public function ajax_freelancer_applied_post() {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;


        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $jobdata = $this->data['jobdata'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $join_str[0]['table'] = 'freelancer_apply';
        $join_str[0]['join_table_id'] = 'freelancer_apply.post_id';
        $join_str[0]['from_table_id'] = 'freelancer_post.post_id';
        $join_str[0]['join_type'] = '';
        $limit = $perpage;
        $offset = $start;
        $contition_array = array('freelancer_apply.job_delete' => '0', 'freelancer_apply.user_id' => $userid);
        $postdata = $this->data['postdata'] = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data = 'freelancer_post.*, freelancer_apply.app_id, freelancer_apply.user_id as userid, freelancer_apply.modify_date, freelancer_apply.created_date ', $sortby = 'freelancer_apply.modify_date', $orderby = 'desc', $limit, $offset, $join_str, $groupby = '');
        $postdata1 = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data = 'freelancer_post.*, freelancer_apply.app_id, freelancer_apply.user_id as userid, freelancer_apply.modify_date, freelancer_apply.created_date ', $sortby = 'freelancer_apply.modify_date', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($postdata1);
        }
        $return_html = '';
        $return_html .= '<input type="hidden" class="page_number" value="' . $page . '" />';
        $return_html .= '<input type="hidden" class="total_record" value="' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';
        if (count($postdata1) > 0) {
            foreach ($postdata as $post) {

                $return_html .= '<div class="all-job-box" id="removeapply' . $post['app_id'] . '">
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
                $return_html .= '<h5><a title = "' . $post['post_name'] . '" href="' . base_url('freelance-hire/project/' . $text . $cityname1 . '-' . $post['user_id'] . '-' . $post['post_id']) . ' ">';
                $return_html .= $post['post_name'];
                $return_html .= '</a></h5>';
                $return_html .= '<p><a title = "' . ucwords($firstname) . " " . ucwords($lastname) . '" href="' . base_url('freelance-hire/employer-details/' . $hireslug) . '">';
                $return_html .= ucwords($firstname) . " " . ucwords($lastname);
                $return_html .= '</a></p>
            </div>
            </div>
            <div class="all-job-middle">
                <p class="pb5">
                    <span class="location">';
                $return_html .= '<span><img alt= "location" class="pr5" src="' . base_url('assets/images/location.png') . '">';
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
                        <span><img alt="skill" class="pr5" src="' . base_url('assets/images/exp.png') . '">';

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
                    $return_html .= '.....<a href="' . base_url('freelance-hire/project/' . $text . $cityname1 . '-' . $post['user_id'] . '-' . $post['post_id']) . ' " title = "Read more">Read more</a>';
                }
                $return_html .= '</p>

            </div>
            <div class="all-job-bottom">
                <span class="job-post-date"><b>Posted on: </b>';
                $return_html .= trim(date('d-M-Y', strtotime($post['created_date'])));
                $return_html .= '</span>
                <p class="pull-right">';

                $return_html .= '<a title = "Remove" href="javascript:void(0);" class="btn4" onclick="removepopup(' . $post['app_id'] . ')">Remove</a>';

                $return_html .= ' </p>

</div>
</div>';
            }
        } else {
            $return_html .= '<div class="art-img-nn">
                                                <div class="art_no_post_img">

                                                    <img alt= "No applied Projects" src="../assets/img/free-no1.png">

                                                </div>
                                                <div class="art_no_post_text">';
            $return_html .= $this->lang->line("no_applied_projects");
            $return_html .= '</div>
                                            </div>';
        }
        echo $return_html;
    }

// AJAX FREELANCER_APPLY APLLIED ON POST(PROJECT) END
    //FREELANCER_APPLY REMOVE FROM APPLIED AND SAVE LIST START
    public function freelancer_delete_apply() {
        $id = $_POST['app_id'];
        $para = $_POST['para'];

        $userid = $this->session->userdata('aileenuser');

        $data = array(
            'job_delete' => '1',
            'job_save' => '3',
            'modify_date' => date('Y-m-d h:i:s', time())
        );

        $updatedata = $this->common->update_data($data, 'freelancer_apply', 'app_id', $id);
    }

//FREELANCER_APPLY REMOVE FROM APPLIED AND SAVE LIST END
    public function save_insert() {
        $id = $_POST['post_id'];
        $userid = $this->session->userdata('aileenuser');
        $contition_array = array('post_id' => $id, 'user_id' => $userid, 'is_delete' => '0');
        $userdata = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $app_id = $userdata[0]['app_id'];
        if ($userdata) {
            $contition_array = array('job_delete' => '1');
            $jobdata = $this->common->select_data_by_condition('freelancer_apply', $contition_array = array(), $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $data = array(
                'job_delete' => '0',
                'job_save' => '1'
            );

            $updatedata = $this->common->update_data($data, 'freelancer_apply', 'app_id', $app_id);
            if ($updatedata) {
                $savepost = 'Applied post';
                echo $savepost;
            }
        } else {
            $data = array(
                'post_id' => $id,
                'user_id' => $userid,
                'status' => '1',
                'created_date' => date('Y-m-d h:i:s', time()),
                'is_delete' => '0',
                'job_delete' => '0',
                'job_save' => '1'
            );

            $insert_id = $this->common->insert_data_getid($data, 'freelancer_apply');
            if ($insert_id) {
                $savepost = 'Applied Post';
                echo $savepost;
            }
        }
    }


    public function save_user() {
        $id = $_POST['post_id'];
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('post_id' => $id, 'user_id' => $userid, 'is_delete' => '0');
        $userdata = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = 'post_id', $orderby = 'asc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $app_id = $userdata[0]['app_id'];
        if ($userdata) {
            $contition_array = array('job_delete' => '0');
            $jobdata = $this->common->select_data_by_condition('freelancer_apply', $contition_array = array(), $data = '*', $sortby = 'post_id', $orderby = 'asc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $data = array(
                'job_delete' => '1',
                'job_save' => '2',
                'modify_date' => date('Y-m-d h:i:s', time())
            );

            $updatedata = $this->common->update_data($data, 'freelancer_apply', 'app_id', $app_id);
            if ($updatedata) {

                $savepost = 'Saved';
            }
            echo $savepost;
        } else {

            $data = array(
                'post_id' => $id,
                'user_id' => $userid,
                'status' => '1',
                'created_date' => date('Y-m-d h:i:s', time()),
                'modify_date' => date('Y-m-d h:i:s', time()),
                'is_delete' => '0',
                'job_delete' => '1',
                'job_save' => '2'
            );

            $insert_id = $this->common->insert_data_getid($data, 'freelancer_apply');
            if ($insert_id) {

                $savepost = 'Saved';
            } echo $savepost;
        }
    }


//FREELANCER_APPLY SAVE POST(PROJECT) START
    public function freelancer_save_post() {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
//code for check user deactivate start
        $this->freelancer_apply_deactivate_check();
        //code for check user deactivate end
// code for display page start
        $this->freelancer_apply_check();
// code for display page end
        $this->progressbar();
// job seeker detail
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1', 'free_post_step' => '7');
        $jobdata = $this->data['jobdata'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_fullname,freelancer_post_username', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->data['title'] = ucfirst($jobdata[0]['freelancer_post_fullname']) . " " . ucfirst($jobdata[0]['freelancer_post_username']) . " | Saved Projects | Freelancer Profile " . TITLEPOSTFIX;
        $this->load->view('freelancer/freelancer_post/freelancer_save_post', $this->data);
    }

//FREELANCER_APPLY SAVE POST(PROJECT) END
//Freelancer Save Post Controller End
//AJAX_FREELANCER_APPLY SAVE POST(PROJECT) START
    public function ajax_freelancer_save_post() {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;

// job seeker detail
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $jobdata = $this->data['jobdata'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// post detail
        $join_str[0]['table'] = 'freelancer_post';
        $join_str[0]['join_table_id'] = 'freelancer_post.post_id';
        $join_str[0]['from_table_id'] = 'freelancer_apply.post_id';
        $join_str[0]['join_type'] = '';

        $limit = $perpage;
        $offset = $start;

        $contition_array = array('freelancer_apply.job_delete' => '1', 'freelancer_apply.user_id' => $userid, 'freelancer_apply.job_save' => '2');
        $postdetail = $this->data['postdetail'] = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = 'freelancer_apply.app_id, freelancer_post.post_id, freelancer_post.user_id, freelancer_post.created_date, freelancer_post.post_name, freelancer_post.post_field_req, freelancer_post.post_est_time, freelancer_post.post_skill, freelancer_post.post_exp_month, freelancer_post.post_exp_year, freelancer_post.post_other_skill, freelancer_post.post_description, freelancer_post.post_rate, freelancer_post.post_last_date, freelancer_post.post_currency, freelancer_post.post_rating_type, freelancer_post.country, freelancer_post.city', $sortby = 'freelancer_apply.modify_date', $orderby = 'desc', $limit, $offset, $join_str, $groupby = '');
        $postdetail1 = $this->data['postdetail'] = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = 'freelancer_apply.app_id, freelancer_post.post_id, freelancer_post.user_id, freelancer_post.created_date, freelancer_post.post_name, freelancer_post.post_field_req, freelancer_post.post_est_time, freelancer_post.post_skill, freelancer_post.post_exp_month, freelancer_post.post_exp_year, freelancer_post.post_other_skill, freelancer_post.post_description, freelancer_post.post_rate, freelancer_post.post_last_date, freelancer_post.post_currency, freelancer_post.post_rating_type, freelancer_post.country, freelancer_post.city', $sortby = 'freelancer_apply.modify_date', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($postdetail1);
        }
        $return_html = '';
        $return_html .= '<input type="hidden" class="page_number" value="' . $page . '" />';
        $return_html .= '<input type="hidden" class="total_record" value="' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';

        if (count($postdetail1) > 0) {
            foreach ($postdetail as $post) {
                $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
                $contition_array = array('post_id' => $post['post_id'], 'job_delete' => '0', 'user_id' => $userid);
                $freelancerapply1 = $this->data['freelancerapply'] = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if ($freelancerapply1) {
                    
                } else {

                    $return_html .= '<div class="all-job-box" id="postdata' . $post['app_id'] . '">
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
                    $return_html .= '<h5><a title = "' . $post['post_name'] . '" href="' . base_url('freelance-hire/project/' . $text . $cityname1 . '-' . $post['user_id'] . '-' . $post['post_id']) . ' ">';
                    $return_html .= $post['post_name'];
                    $return_html .= '</a></h5>';
                    $return_html .= '<p><a title = "' . ucwords($firstname) . " " . ucwords($lastname) . '" href="' . base_url('freelance-hire/employer-details/' . $hireslug) . '">';
                    $return_html .= ucwords($firstname) . " " . ucwords($lastname);
                    $return_html .= '</a></p>
            </div>
            </div>
            <div class="all-job-middle">
                <p class="pb5">
                    <span class="location">';
                    $return_html .= '<span><img alt= "location" class="pr5" src="' . base_url('assets/images/location.png') . '">';
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
                        <span><img alt= "skill" class="pr5" src="' . base_url('assets/images/exp.png') . '">';

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
                        $return_html .= '.....<a href="' . base_url('freelance-hire/project/' . $text . $cityname1 . '-' . $post['user_id'] . '-' . $post['post_id']) . ' " title="Read more">Read more</a>';
                    }
                    $return_html .= '</p>

            </div>
            <div class="all-job-bottom">
                <span class="job-post-date"><b>Posted on: </b>';
                    $return_html .= trim(date('d-M-Y', strtotime($post['created_date'])));
                    $return_html .= '</span>
                <p class="pull-right">';

                    $return_html .= '<a title = "Remove" href="javascript:void(0);" class="btn4" onclick="removepopup(' . $post['app_id'] . ')">Remove</a>';
                    $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
                    $contition_array = array('post_id' => $post['post_id'], 'job_delete' => '0', 'user_id' => $userid);
                    $freelancerapply1 = $this->data['freelancerapply'] = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    if ($freelancerapply1) {
                        
                    } else {
                        $return_html .= '<a title="Apply" href="javascript:void(0);"  class= "btn4" onclick="applypopup(' . $post['post_id'] . ',' . $post['app_id'] . ')">Apply</a>';
                    }

                    $return_html .= ' </p>

</div>
</div>';
                }
            }
        } else {
            $return_html .= '<div class="art-img-nn">
                                                <div class="art_no_post_img">

                                                    <img alt= "No Saved Projects" src="../assets/img/free-no1.png">

                                                </div>
                                                <div class="art_no_post_text">';
            $return_html .= $this->lang->line("no_saved_project");
            $return_html .= '</div>
                                            </div>';
        }
        echo $return_html;
    }

//AJAX_FREELANCER_APPLY SAVE POST(PROJECT) END

    //FREELANCER_APPLY PROFILE PIC INSERT START
    public function user_image_add1() {
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid);
        $user_reg_data = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $user_reg_prev_image = $user_reg_data[0]['freelancer_post_user_image'];

        if ($user_reg_prev_image != '') {
            $user_image_main_path = $this->config->item('free_post_profile_main_upload_path');
            $user_bg_full_image = $user_image_main_path . $user_reg_prev_image;
            if (isset($user_bg_full_image)) {
                unlink($user_bg_full_image);
            }

            $user_image_thumb_path = $this->config->item('free_post_profile_thumb_upload_path');
            $user_bg_thumb_image = $user_image_thumb_path . $user_reg_prev_image;
            if (isset($user_bg_thumb_image)) {
                unlink($user_bg_thumb_image);
            }
        }


        $data = $_POST['image'];
        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);
        $user_bg_path = $this->config->item('free_post_profile_main_upload_path');
        $data = base64_decode($data);
        $imageName = time() . '.png';
        $file = $user_bg_path . $imageName;
        file_put_contents($user_bg_path . $imageName, $data);
        $success = file_put_contents($file, $data);
        $main_image = $user_bg_path . $imageName;
        $main_image_size = filesize($main_image);

        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
        $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);

        $user_thumb_path = $this->config->item('free_post_profile_thumb_upload_path');
        $user_thumb_width = $this->config->item('free_post_profile_thumb_width');
        $user_thumb_height = $this->config->item('free_post_profile_thumb_height');

        $thumb_image = $user_thumb_path . $imageName;
        copy($main_image, $thumb_image);
        $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);

        $data = array(
            'freelancer_post_user_image' => $imageName
        );

        $update = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
        if ($_server['HTTP_HOST'] != 'localhost') {
            if (isset($main_image)) {
                unlink($main_image);
            }
            if (isset($thumb_image)) {
                unlink($thumb_image);
            }
        }
        if ($update) {

            $contition_array = array('user_id' => $userid, 'status' => '1', 'is_delete' => '0');
            $freelancerpostdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
            $userimage .= '<img src="' . FREE_POST_PROFILE_MAIN_UPLOAD_URL . $freelancerpostdata[0]['freelancer_post_user_image'] . '" alt="User Image" >';
            $userimage .= '<a title = "update profile pic" href="javascript:void(0);" onclick="updateprofilepopup();" class="cusome_upload"><img alt="Upload profile pic" src="' . base_url('../assets/img/cam.png') . '">';
            $userimage .= $this->lang->line("update_profile_picture");
            $userimage .= '</a>';

            echo $userimage;
        } else {

            $this->session->flashdata('error', 'Your data not inserted');
            redirect('freelance-work/home', refresh);
        }
    }

//FREELANCER_APPLY PROFILE PIC INSERT END

    //FREELANCER_APPLY PORTFOLIO UPLOAD PDF START
    public function pdf($id) {
        $this->data['title'] =   "PDF | Freelancer Profile" . TITLEPOSTFIX;
        $contition_array = array('user_id' => $id, 'status' => '1');
        $this->data['freelancerdata'] = $freelancerdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $this->load->view('freelancer/freelancer_post/freelancer_pdf', $this->data);
    }

//FREELANCER_APPLY PORTFOLIO UPLOAD PDF END

//FREELANCER_APPLY PROFILE PAGE START
    public function freelancer_post_profile($id) {
        if (is_numeric($id)) {
            
        } else {
            $id = $this->db->select('user_id')->get_where('freelancer_post_reg', array('freelancer_apply_slug' => $id, 'status' => 1))->row()->user_id;
        }
        $userid = $this->session->userdata('aileenuser');

//code for check user deactivate start
        $this->freelancer_apply_deactivate_check();
        //code for check user deactivate end
        if ($id == $userid || $id == '') {
            // code for display page start
            $this->freelancer_apply_check();
            // code for display page end

            $this->progressbar();

            $contition_array = array('user_id' => $userid, 'status' => '1', 'free_post_step' => '7');
            $apply_data = $this->data['freelancerpostdata'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_fullname, freelancer_post_username, freelancer_post_skypeid, freelancer_post_email, freelancer_post_phoneno, freelancer_post_country, freelancer_post_state, freelancer_post_city,freelancer_post_pincode, freelancer_post_field, freelancer_post_area, freelancer_post_skill_description, freelancer_post_hourly, freelancer_post_ratestate, freelancer_post_fixed_rate, freelancer_post_job_type, freelancer_post_work_hour, freelancer_post_degree, freelancer_post_stream, freelancer_post_univercity, freelancer_post_collage, freelancer_post_percentage, freelancer_post_passingyear, freelancer_post_portfolio_attachment, freelancer_post_portfolio, user_id, freelancer_post_user_image, designation, freelancer_post_otherskill, freelancer_post_exp_month, freelancer_post_exp_year', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {
            $contition_array = array('user_id' => $id, 'free_post_step' => '7', 'status' => '1');
            $apply_data = $this->data['freelancerpostdata'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_fullname, freelancer_post_username, freelancer_post_skypeid, freelancer_post_email, freelancer_post_phoneno, freelancer_post_country, freelancer_post_state, freelancer_post_city, freelancer_post_pincode, freelancer_post_field, freelancer_post_area, freelancer_post_skill_description, freelancer_post_hourly, freelancer_post_ratestate, freelancer_post_fixed_rate, freelancer_post_job_type, freelancer_post_work_hour, freelancer_post_degree, freelancer_post_stream, freelancer_post_univercity, freelancer_post_collage, freelancer_post_percentage, freelancer_post_passingyear, freelancer_post_portfolio_attachment, freelancer_post_portfolio, user_id, freelancer_post_user_image,  designation, freelancer_post_otherskill, freelancer_post_exp_month, freelancer_post_exp_year', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }

        $this->data['title'] = ucfirst($apply_data[0]['freelancer_post_fullname']) . " " . ucfirst($apply_data[0]['freelancer_post_username']) . " | Details | Freelancer Profile" . TITLEPOSTFIX;
        $this->load->view('freelancer/freelancer_post/freelancer_post_profile', $this->data);
    }

//FREELANCER_APPLY PROFILE PAGE END

//FREELANCER_APPLY DEACTIVATE START
    public function deactivate() {

        $id = $_POST['id'];
        $data = array(
            'status' => '0'
        );
        $update = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $id);
    }

//FREELANCER_APPLY DEACTIVATE END


//FREELANCER_APPLY COVER PIC START
    public function ajaxpro_work() {
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid);
        $user_reg_data = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'profile_background_main', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $user_reg_prev_image = $user_reg_data[0]['profile_background'];
        $user_reg_prev_main_image = $user_reg_data[0]['profile_background_main'];

        if ($user_reg_prev_image != '') {
            $user_image_main_path = $this->config->item('free_post_bg_main_upload_path');
            $user_bg_full_image = $user_image_main_path . $user_reg_prev_image;
            if (isset($user_bg_full_image)) {
                unlink($user_bg_full_image);
            }

            $user_image_thumb_path = $this->config->item('free_post_bg_thumb_upload_path');
            $user_bg_thumb_image = $user_image_thumb_path . $user_reg_prev_image;
            if (isset($user_bg_thumb_image)) {
                unlink($user_bg_thumb_image);
            }
        }
        if ($user_reg_prev_main_image != '') {
            $user_image_original_path = $this->config->item('free_post_bg_original_upload_path');
            $user_bg_origin_image = $user_image_original_path . $user_reg_prev_main_image;
            if (isset($user_bg_origin_image)) {
                unlink($user_bg_origin_image);
            }
        }


        $data = $_POST['image'];
        $data = str_replace('data:image/png;base64,', '', $data);
        $data = str_replace(' ', '+', $data);
        $user_bg_path = $this->config->item('free_post_bg_main_upload_path');
        $imageName = time() . '.png';
        $data = base64_decode($data);
        $file = $user_bg_path . $imageName;
        $success = file_put_contents($file, $data);

        $main_image = $user_bg_path . $imageName;

        $main_image_size = filesize($main_image);

        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
        $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);

        $user_thumb_path = $this->config->item('free_post_bg_thumb_upload_path');
        $user_thumb_width = $this->config->item('free_post_bg_thumb_width');
        $user_thumb_height = $this->config->item('free_post_bg_thumb_height');

        $upload_image = $user_bg_path . $imageName;

        $thumb_image_uplode = $this->thumb_img_uplode($upload_image, $imageName, $user_thumb_path, $user_thumb_width, $user_thumb_height);

        $thumb_image = $user_thumb_path . $imageName;
        $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);

        $data = array(
            'profile_background' => $imageName
        );

        $update = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);

        if ($_SERVER['HTTP_HOST'] != 'localhost') {
            if (isset($main_image)) {
                unlink($main_image);
            }
            if (isset($thumb_image)) {
                unlink($thumb_image);
            }
            if (isset($upload_image)) {
                unlink($upload_image);
            }
        }


        $this->data['jobdata'] = $this->common->select_data_by_id('freelancer_post_reg', 'user_id', $userid, $data = 'profile_background', $join_str = array());
        $coverpic = '<img alt="User Image" src="' . FREE_POST_BG_MAIN_UPLOAD_URL . $this->data['jobdata'][0]['profile_background'] . '" name="image_src" id="image_src" />';
        echo $coverpic;
    }

    public function image_work() {
        $userid = $this->session->userdata('aileenuser');

        $config['upload_path'] = $this->config->item('free_post_bg_original_upload_path');
        $config['allowed_types'] = $this->config->item('free_post_bg_main_allowed_types');

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
            'modify_date ' => date('Y-m-d h:i:s', time())
        );

        $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);

        if ($updatedata) {
            echo $userid;
        } else {
            echo "welcome";
        }
    }

//FREELANCER_APPLY COVER PIC START
//FREELANCER_APPLY DESIGNATION START
    public function designation() {
        $userid = $this->session->userdata('aileenuser');

        $data = array(
            'designation' => trim($this->input->post('designation')),
            'modify_date' => date('Y-m-d', time())
        );

        $updatdata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);

        if ($updatdata) {

            if ($this->input->post('hitext') == 1) {
                redirect('freelancer/freelancer_post_profile', refresh);
            } elseif ($this->input->post('hitext') == 2) {
                redirect('freelancer/freelancer_save_post', refresh);
            } elseif ($this->input->post('hitext') == 3) {
                redirect('freelancer/freelancer_applied_post', refresh);
            }
        } else {
            $this->session->flashdata('error', 'Your data not inserted');
            redirect('freelancer/post_apply', refresh);
        }
    }

//FREELANCER_APPLY DESIGNATION END
    //FREELANCER_APPLY REACTIVATE PROFILE STRAT
    public function reactivate() {

        $userid = $this->session->userdata('aileenuser');
        $data = array(
            'status' => 1,
            'modify_date' => date('y-m-d h:i:s')
        );

        $updatdata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
        if ($updatdata) {

            redirect('freelance-work/home', refresh);
        } else {

            redirect('freelancer/reactivate', refresh);
        }
    }

//FREELANCER_APPLY REACTIVATE PROFILE END
//FREELANCER_HIRE INVITE FREELANCER OF APLLIED START
    public function free_invite_user() {
        $postid = $_POST['post_id'];
        $invite_user = $_POST['invited_user'];
        //echo $invite_user;die();
        $userid = $this->session->userdata('aileenuser');
        $data = array(
            'user_id' => $userid,
            'post_id' => $postid,
            'invite_user_id' => $invite_user,
            'profile' => "freelancer"
        );
        $insert_id = $this->common->insert_data_getid($data, 'user_invite');
        $applydata = $this->common->select_data_by_id('freelancer_post_reg', 'user_id', $invite_user, $data = 'freelancer_post_email');
        $projectdata = $this->common->select_data_by_id('freelancer_post', 'post_id', $postid, $data = 'post_name');

        if ($insert_id) {
            $data = array(
                'not_type' => '4',
                'not_from_id' => $userid,
                'not_to_id' => $invite_user,
                'not_read' => '2',
                'not_status' => '0',
                'not_product_id' => $insert_id,
                'not_from' => '5',
                "not_active" => '1',
                'not_created_date' => date('Y-m-d H:i:s')
            );
            $insert_id = $this->common->insert_data_getid($data, 'notification');
            // GET NOTIFICATION COUNT
            $not_count = $this->freelancer_notification_count($invite_user);

            echo json_encode(
                    array(
                        "status" => 'Selected',
                        "notification" => array('notification_count' => $not_count, 'to_id' => $invite_user),
            ));

            if ($insert_id) {
                $word = 'Selected';
                $this->selectemail_user($invite_user, $postid, $word);
            }
        } else {
            echo 'error';
        }
    }

//FREELANCER_HIRE INVITE FREELANCER OF APLLIED END
//FREELANCER_APPLY DELETE PDF OF PORTFOLIO START
    public function deletepdf() {
        $userid = $this->session->userdata('aileenuser');
        //code for check user deactivate start
        $this->freelancer_apply_deactivate_check();
        //code for check user deactivate end

        $contition_array = array('user_id' => $userid);
        $free_reg_data = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $freeportfolio = $free_reg_data[0]['freelancer_post_portfolio_attachment'];

        if ($freeportfolio != '') {
            $free_pdf_path = 'uploads/freelancer_post_portfolio/main';
            $free_pdf = $free_pdf_path . $freeportfolio;
            if (isset($free_pdf)) {
                unlink($free_pdf);
            }
        }

        $data = array(
            'freelancer_post_portfolio_attachment' => ''
        );

        $update = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
        echo 'ok';
    }

//FREELANCER_APPLY DELETE PDF OF PORTFOLIO END

//FREELANCER_HIRE SEARCH CITY FOR AUTO COMPLETE START
    public function freelancer_search_city($id = "") {
        $searchTerm = $_GET['term'];
        if (!empty($searchTerm)) {
            $contition_array = array('status' => '1', 'state_id !=' => '0');
            $search_condition = "(city_name LIKE '" . trim($searchTerm) . "%')";
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

//FREELANCER_HIRE SEARCH CITY FOR AUTO COMPLETE END
//FREELANCER_APPLY SEARCH KEYWORD FOR AUTO COMPLETE START
    public function freelancer_apply_search_keyword($id = "") {
        $searchTerm = $_GET['term'];
        if (!empty($searchTerm)) {
            $contition_array = array('status' => '1', 'is_delete' => '0', 'free_post_step' => '7');
            $search_condition = "(designation LIKE '" . trim($searchTerm) . "%')";
            $freelancer_postdata = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'designation', $sortby = 'designation', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = 'designation');

            $contition_array = array('status' => '1', 'type' => '1');
            $search_condition = "(skill LIKE '" . trim($searchTerm) . "%')";
            $skill = $this->common->select_data_by_search('skill', $search_condition, $contition_array, $data = 'skill', $sortby = 'skill', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = 'skill');

            $contition_array = array('status' => '1');
            $search_condition = "(post_name LIKE '" . trim($searchTerm) . "%')";
            $results_post = $this->common->select_data_by_search('freelancer_post', $search_condition, $contition_array, $data = 'post_name', $sortby = 'post_name', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = 'post_name');
            //$this->data['results'] = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data = 'post_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

            $contition_array = array('status' => '1', 'is_delete' => '0');
            $search_condition = "(category_name LIKE '" . trim($searchTerm) . "%')";
            $field = $this->common->select_data_by_search('category', $search_condition, $contition_array, $data = 'category_name', $sortby = 'category_name', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = 'category_name');
        }
        $uni = array_merge((array) $skill, (array) $freelancer_postdata, (array) $field, (array) $results_post);
        foreach ($uni as $key => $value) {
            foreach ($value as $ke => $val) {
                if ($val != "") {
                    $result[] = $val;
                }
            }
        }
        foreach ($result as $key => $value) {
            $result1[$key]['value'] = $value;
        }
        $result1 = array_values($result);
        echo json_encode($result1);
    }

//FREELANCER_APPLY SEARCH KEYWORD FOR AUTO COMPLETE END
    public function get_skill($id = "") {

        //get search term
        $searchTerm = $_GET['term'];
        if (!empty($searchTerm)) {
            $contition_array = array('status' => '1', 'type' => '1');
            $search_condition = "(skill LIKE '" . trim($searchTerm) . "%')";
            $citylist = $this->common->select_data_by_search('skill', $search_condition, $contition_array, $data = 'skill as text', $sortby = 'skill', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = 'skill');
        }
        foreach ($citylist as $key => $value) {
            $citydata[$key]['value'] = $value['text'];
        }

        $cdata = array_values($citydata);
        echo json_encode($cdata);
    }

//FREELANCER_APPLY OTHER DEGREE ADD START
    public function freelancer_other_degree() {
        $other_degree = $_POST['other_degree'];
        $other_stream = $_POST['other_stream'];

        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        $contition_array = array('is_delete' => '0', 'degree_name' => $other_degree);
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
        $userdata = $this->data['userdata'] = $this->common->select_data_by_search('degree', $search_condition, $contition_array, $data = '*', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $count = count($userdata);

        if ($other_degree != NULL) {
            if ($count == 0) {
                $data = array(
                    'degree_name' => $other_degree,
                    'created_date' => date('Y-m-d h:i:s', time()),
                    'status' => '2',
                    'is_delete' => '0',
                    'is_other' => '1',
                    'user_id' => $userid
                );
                $insert_id = $this->common->insert_data_getid($data, 'degree');
                $degree_id = $insert_id;

                $contition_array = array('is_delete' => '0', 'status' => '2', 'stream_name' => $other_stream, 'user_id' => $userid);
                $stream_data = $this->common->select_data_by_condition('stream', $contition_array, $data = '*', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                $count1 = count($stream_data);

                if ($count1 == 0) {
                    $data = array(
                        'stream_name' => $other_stream,
                        'degree_id' => $degree_id,
                        'created_date' => date('Y-m-d h:i:s', time()),
                        'status' => '2',
                        'is_delete' => '0',
                        'is_other' => '1',
                        'user_id' => $userid
                    );
                    $insert_id = $this->common->insert_data_getid($data, 'stream');
                } else {
                    $data = array(
                        'stream_name' => $other_stream,
                        'degree_id' => $degree_id,
                        'created_date' => date('Y-m-d h:i:s', time()),
                        'status' => '2',
                        'is_delete' => '0',
                        'is_other' => '1',
                        'user_id' => $userid
                    );
                    $updatedata = $this->common->update_data($data, 'stream', 'stream_id', $stream_data[0]['stream_id']);
                }
                if ($insert_id || $updatedata) {

                    $contition_array = array('is_delete' => '0', 'degree_name !=' => "Other");
                    $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
                    $degree = $this->data['degree'] = $this->common->select_data_by_search('degree', $search_condition, $contition_array, $data = '*', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    if (count($degree) > 0) {

                        $select = '<option value="" Selected option disabled="">Select your Degree</option>';

                        foreach ($degree as $st) {

                            $select .= '<option value="' . $st['degree_id'] . '"';
                            if ($st['degree_name'] == $other_degree) {
                                $select .= 'selected';
                            }
                            $select .= '>' . $st['degree_name'] . '</option>';
                        }
                    }
//For Getting Other at end
                    $contition_array = array('is_delete' => '0', 'status' => '1', 'degree_name' => "Other");
                    $degree_otherdata = $this->common->select_data_by_condition('degree', $contition_array, $data = '*', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $select .= '<option value="' . $degree_otherdata[0]['degree_id'] . '">' . $degree_otherdata[0]['degree_name'] . '</option>';

                    //for getting selected stream data start
                    $contition_array = array('is_delete' => '0', 'degree_id' => $degree_id);
                    $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
                    $stream = $this->data['stream'] = $this->common->select_data_by_search('stream', $search_condition, $contition_array, $data = '*', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $select2 = '<option value="" Selected option disabled="">Select your Stream</option>';
                    $select2 .= '<option value="' . $stream[0]['stream_id'] . '"';
                    if ($stream[0]['stream_name'] == $other_stream) {
                        $select2 .= 'selected';
                    }
                    $select2 .= '>' . $stream[0]['stream_name'] . '</option>';
                    //for getting selected stream data End         
                }
            } else {
                $select .= 0;
            }
        } else {
            $select .= 1;
        }

        echo json_encode(array(
            "select" => $select,
            "select2" => $select2,
        ));
    }

//FREELANCER_APPLY OTHER DEGREE ADD START
//FREELANCER_APPLY OTHER STREAM START
    public function freelancer_other_stream() {
        $other_stream = $_POST['other_stream'];
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        $contition_array = array('is_delete' => '0', 'stream_name' => $other_stream);
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
        $userdata = $this->data['userdata'] = $this->common->select_data_by_search('stream', $search_condition, $contition_array, $data = '*', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $count = count($userdata);

        if ($other_stream != NULL) {
            if ($count == 0) {
                $data = array(
                    'stream_name' => $other_stream,
                    'created_date' => date('Y-m-d h:i:s', time()),
                    'status' => '2',
                    'is_delete' => '0',
                    'is_other' => '1',
                    'user_id' => $userid
                );
                $insert_id = $this->common->insert_data_getid($data, 'stream');


                if ($insert_id) {

                    $contition_array = array('is_delete' => '0', 'stream_name !=' => "Other");
                    $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
                    $stream = $this->data['stream'] = $this->common->select_data_by_search('stream', $search_condition, $contition_array, $data = '*', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    if (count($stream) > 0) {
                        $select = '<option value="" selected option disabled="">Select your Stream</option>';

                        foreach ($stream as $st) {

                            $select .= '<option value="' . $st['stream_id'] . '"';
                            if ($st['stream_name'] == $other_stream) {
                                $select .= 'selected';
                            }
                            $select .= '>' . $st['stream_name'] . '</option>';
                        }
                    }
//For Getting Other at end
                    $contition_array = array('is_delete' => '0', 'status' => '1', 'stream_name' => "Other");
                    $stream_otherdata = $this->common->select_data_by_condition('stream', $contition_array, $data = '*', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $select .= '<option value="' . $stream_otherdata[0]['stream_id'] . '">' . $stream_otherdata[0]['stream_name'] . '</option>';
                }
            } else {
                $select .= 0;
            }
        } else {
            $select .= 1;
        }

        echo $select;
    }

//FREELANCER_APPLY OTHER STREAM END
//FREELANCER_APPLY  OTHER FIELD START
    public function freelancer_other_field() {

        $other_field = $_POST['other_field'];

        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        $contition_array = array('is_delete' => '0', 'category_name' => $other_field);
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
        $userdata = $this->data['userdata'] = $this->common->select_data_by_search('category', $search_condition, $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $count = count($userdata);

        if ($other_field != NULL) {
            if ($count == 0) {
                $data = array(
                    'category_name' => $other_field,
                    'created_date' => date('Y-m-d h:i:s', time()),
                    'status' => '2',
                    'is_delete' => '0',
                    'is_other' => '1',
                    'user_id' => $userid,
                    'category_slug' => $this->common->clean($other_field)
                );
                $insert_id = $this->common->insert_data_getid($data, 'category');
                if ($insert_id) {
                    $contition_array = array('is_delete' => '0', 'category_name !=' => "Other");
                    $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
                    $category = $this->data['category'] = $this->common->select_data_by_search('category', $search_condition, $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    if (count($category) > 0) {
                        $select = '<option value="" selected option disabled>Select your field</option>';
                        foreach ($category as $st) {
                            $select .= '<option value="' . $st['category_id'] . '"';
                            if ($st['category_name'] == $other_field) {
                                $select .= 'selected';
                            }
                            $select .= '>' . $st['category_name'] . '</option>';
                        }
                    }
//For Getting Other at end
                    $contition_array = array('is_delete' => '0', 'status' => '1', 'category_name' => "Other");
                    $category_otherdata = $this->common->select_data_by_condition('category', $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    $select .= '<option value="' . $category_otherdata[0]['category_id'] . '">' . $category_otherdata[0]['category_name'] . '</option>';
                }
            } else {
                $select .= 0;
            }
        } else {
            $select .= 1;
        }


        echo json_encode(array(
            "select" => $select,
        ));
    }

//FREELANCER_APPLY BOTH OTHER FIELD END

    //FREELANCER APPLY AS APPLIED ON POST SEND MAIL START
    public function apply_email($notid) {

        $userid = $this->session->userdata('aileenuser');
        $applydata = $this->common->select_data_by_id('freelancer_post_reg', 'user_id', $userid, $data = 'freelancer_post_fullname,freelancer_post_username,freelancer_post_user_image,freelancer_apply_slug', $join_str = array());
        $hiremail = $this->common->select_data_by_id('freelancer_hire_reg', 'user_id', $notid, $data = 'email', $join_str = array());

        $email_html = '';
        $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;">';
        if ($applydata[0]['freelancer_post_user_image'] == '') {
            $fname = $applydata[0]['freelancer_post_fullname'];
            $lname = $applydata[0]['freelancer_post_username'];
            $sub_fname = substr($fname, 0, 1);
            $sub_lname = substr($lname, 0, 1);
            $email_html .= '<div class="post-img-div">' . ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)) . '</div></td>';
        } else {
            $email_html .= '<img alt="User Image" src="' . FREE_POST_PROFILE_THUMB_UPLOAD_URL . $applydata[0]['freelancer_post_user_image'] . '" width="60" height="60"></td>';
        }
        $email_html .= '<td style="padding:5px;">
						<p>Freelancer <b>' . $applydata[0]['freelancer_post_fullname'] . " " . $applydata[0]['freelancer_post_username'] . '</b> Applied on your Project.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a title = "View Detail" class="btn" href="' . BASEURL . 'freelance-work/freelancer-details/' . $applydata[0]['freelancer_apply_slug'] . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
        $subject = $applydata[0]['freelancer_post_fullname'] . " " . $applydata[0]['freelancer_post_username'] . ' Applied on your Project.';

        $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $hiremail[0]['email']);
        // mail end  
    }

//FREELANCER APPLY AS APPLIED ON POST SEND MAIL END
    public function selectemail_user($select_user = '', $post_id = '', $word = '') {
        $invite_user = $select_user;
        $postid = $post_id;
        $writting_word = $word;
        $userid = $this->session->userdata('aileenuser');
        $applydata = $this->common->select_data_by_id('freelancer_post_reg', 'user_id', $invite_user, $data = 'freelancer_post_email');
        $projectdata = $this->common->select_data_by_id('freelancer_post', 'post_id', $postid, $data = 'post_name');
        $email_html = '';
        $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;">';
        if ($this->data['freehiredata'][0]['freelancer_hire_user_image']) {
            $email_html .= '<img alt="User Image" src="' . FREE_HIRE_PROFILE_THUMB_UPLOAD_URL . $this->data['freehiredata'][0]['freelancer_hire_user_image'] . '" width="60" height="60"></td>';
        } else {
            $fname = $this->data['freehiredata'][0]['fullname'];
            $lname = $this->data['freehiredata'][0]['username'];
            $sub_fname = substr($fname, 0, 1);
            $sub_lname = substr($lname, 0, 1);
            $email_html .= '<div class="post-img-div">
                          ' . ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)) . '</div> </td>';
        }
        $email_html .= '<td style="padding:5px;">
						<p>Employer <b>' . $this->data['freehiredata'][0]['fullname'] . " " . $this->data['freehiredata'][0]['username'] . " " . $writting_word . '</b> you for ' . $projectdata[0]["post_name"] . ' project in freelancer profile.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a title= "View Detail" class="btn" href="' . BASEURL . 'notification/freelance-hire/' . $postid . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
        $subject = $this->data['freehiredata'][0]['fullname'] . " " . $this->data['freehiredata'][0]['username'] . " " . $writting_word . ' you for ' . $projectdata[0]["post_name"] . ' project in Aileensoul.';

        $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $applydata[0]['freelancer_post_email']);
        $email_html = '';
        $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;">';
        if ($this->data['freehiredata'][0]['freelancer_hire_user_image']) {
            $email_html .= '<img alt = "User Image" src="' . FREE_HIRE_PROFILE_THUMB_UPLOAD_URL . $this->data['freehiredata'][0]['freelancer_hire_user_image'] . '" width="60" height="60"></td>';
        } else {
            $fname = $this->data['freehiredata'][0]['fullname'];
            $lname = $this->data['freehiredata'][0]['username'];
            $sub_fname = substr($fname, 0, 1);
            $sub_lname = substr($lname, 0, 1);
            $email_html .= '<div class="post-img-div">
                          ' . ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)) . '</div> </td>';
        }
        $email_html .= '<td style="padding:5px;">
						<p>Employer <b>' . $this->data['freehiredata'][0]['fullname'] . " " . $this->data['freehiredata'][0]['username'] . " " . $writting_word . '</b>  you for ' . $projectdata[0]["post_name"] . ' project in freelancer profile.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a title = "View Detail" class="btn" href="' . BASEURL . 'notification/freelance-hire/' . $postid . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
        $subject = $this->data['freehiredata'][0]['fullname'] . " " . $this->data['freehiredata'][0]['username'] . " " . $writting_word . ' you for ' . $projectdata[0]["post_name"] . ' project in Aileensoul.';

        $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $applydata[0]['freelancer_post_email']);
    }



    //FREELANCER APPLY NEW REGISTATION PROFILE START
    public function registation($postid = '') {

        $contition_array = array('status' => '1');
        $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = 'country_id,country_name', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('status' => '1', 'is_other' => '0');
        $this->data['category'] = $this->common->select_data_by_condition('category', $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('is_delete' => '0', 'category_name !=' => "Other");
        $search_condition = "( status = '1')";
        $this->data['category_data'] = $this->common->select_data_by_search('category', $search_condition, $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('is_delete' => '0', 'status' => '1', 'category_name' => "Other");
        $this->data['category_otherdata'] = $this->common->select_data_by_condition('category', $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        $contition_array = array('status' => '1', 'type' => '1');
        $this->data['skill1'] = $this->common->select_data_by_condition('skill', $contition_array, $data = '*', $sortby = 'skill', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $this->data['title'] = "Registration | Freelancer Profile" . TITLEPOSTFIX;
        if ($this->session->userdata('aileenuser')) {
            $userid = $this->session->userdata('aileenuser');
            $hireuser = $this->db->select('user_id')->get_where('freelancer_post_reg', array('user_id' => $userid))->row()->user_id;
        }
        if ($hireuser) {
            redirect('freelance-work/home', refresh);
        } else {
            $this->load->view('freelancer/freelancer_post/registation', $this->data);
        }
    }

    //FREELANCER APPLY NEW REGISTATION PROFILE END
    //FREELANCER APPLY NEW REGISTATION INSERT START

    public function registation_insert($postliveid = '') {
         //echo $postliveid;die();




        $userid = $this->session->userdata('aileenuser');
        $skill1 = $this->input->post('skills');
        $skills = explode(',', $skill1);

        $this->form_validation->set_rules('firstname', 'Full Name', 'required');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'EmailId', 'required|valid_email');
        $this->form_validation->set_rules('country', 'country', 'required');
        $this->form_validation->set_rules('state', 'state', 'required');
        $this->form_validation->set_rules('field', 'Field', 'required');
        $this->form_validation->set_rules('skills', 'skill', 'required');
        if (empty($this->input->post('experience_month')) && empty($this->input->post('experience_year'))) {
            $this->form_validation->set_rules('experiance', 'Experiance', 'required');
        }

        if ($this->form_validation->run() == FALSE) {
            $contition_array = array('status' => '1');
            $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = 'country_id,country_name', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('status' => '1', 'is_other' => '0');
            $this->data['category'] = $this->common->select_data_by_condition('category', $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('is_delete' => '0', 'category_name !=' => "Other");
            $search_condition = "( status = '1')";
            $this->data['category_data'] = $this->common->select_data_by_search('category', $search_condition, $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('is_delete' => '0', 'status' => '1', 'category_name' => "Other");
            $this->data['category_otherdata'] = $this->common->select_data_by_condition('category', $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            $contition_array = array('status' => '1', 'type' => '1');
            $this->data['skill1'] = $this->common->select_data_by_condition('skill', $contition_array, $data = '*', $sortby = 'skill', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['title'] = "Registration | Freelancer Profile" . TITLEPOSTFIX;
            $this->load->view('freelancer/freelancer_post/registation', $this->data);
        } else {

            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $userdata1 = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if ($userdata1) {
                redirect('freelance-work/home', refresh);
            } else {
                if (count($skills) > 0) {
                    foreach ($skills as $ski) {
                        if ($ski != " ") {
                            $contition_array = array('skill' => trim($ski), 'type' => '1');
                            $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                            if (count($skilldata) < 0) {
                                $contition_array = array('skill' => trim($ski), 'type' => '5');
                                $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                            }
                            if ($skilldata) {
                                $skill[] = $skilldata[0]['skill_id'];
                            } else {
                                $data = array(
                                    'skill' => trim($ski),
                                    'status' => '1',
                                    'type' => '5',
                                    'user_id' => $userid,
                                );
                                $skill[] = $this->common->insert_data_getid($data, 'skill');
                            }
                        }
                    }
                    $skill = array_unique($skill, SORT_REGULAR);
                    $skills = implode(',', $skill);
                }

                $first_lastname = trim($this->input->post('firstname')) . " " . trim($this->input->post('lastname'));

                $data = array(
                    'freelancer_post_fullname' => trim($this->input->post('firstname')),
                    'freelancer_post_username' => trim($this->input->post('lastname')),
                    'freelancer_post_email' => trim($this->input->post('email')),
                    'freelancer_post_country' => trim($this->input->post('country')),
                    'freelancer_post_state' => trim($this->input->post('state')),
                    'freelancer_post_city' => trim($this->input->post('city')),
                    'freelancer_post_field' => trim($this->input->post('field')),
                    'freelancer_post_area' => $skills,
                    'freelancer_post_exp_month' => trim($this->input->post('experience_month')),
                    'freelancer_post_exp_year' => trim($this->input->post('experience_year')),
                    'freelancer_apply_slug' => $this->setcategory_slug($first_lastname, 'freelancer_apply_slug', 'freelancer_post_reg'),
                    'user_id' => $userid,
                    'created_date' => date('Y-m-d', time()),
                    'status' => '1',
                    'is_delete' => '0',
                    'free_post_step' => '7'
                );
                $insert_id = $this->common->insert_data_getid($data, 'freelancer_post_reg');

                if ($insert_id) {

                    if ($postliveid) {
                        $id = trim($postliveid);

                        $userid = $this->session->userdata('aileenuser');
                        $notid = $this->db->select('user_id')->get_where('freelancer_post', array('post_id' => $id))->row()->user_id;

                        $contition_array = array('post_id' => $id, 'user_id' => $userid, 'is_delete' => '0');
                        $userdata = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                        if ($userid == $notid) {

                            $this->session->flashdata('error', 'you can not apply on your own post');
                        } else {
                            if ($userdata) {
                                
                            } else {
                                $data = array(
                                    'post_id' => $id,
                                    'user_id' => $userid,
                                    'status' => '1',
                                    'created_date' => date('Y-m-d h:i:s', time()),
                                    'modify_date' => date('Y-m-d h:i:s', time()),
                                    'is_delete' => '0',
                                    'job_delete' => '0',
                                    'job_save' => '3'
                                );
                                $insert_id = $this->common->insert_data_getid($data, 'freelancer_apply');
                                // insert notification
                                $data = array(
                                    'not_type' => '3',
                                    'not_from_id' => $userid,
                                    'not_to_id' => $notid,
                                    'not_read' => '2',
                                    'not_from' => '4',
                                    'not_product_id' => $insert_id,
                                    "not_active" => '1',
                                    'not_created_date' => date('Y-m-d H:i:s')
                                );

                                $insert_id = $this->common->insert_data_getid($data, 'notification');
                                // end notoification
                                if ($insert_id) {
                                    $this->apply_email($notid);
                                    $applypost = 'Applied';
                                }
                                // echo $applypost;
                            }
                        }
                    }

                    if ($postliveid) {
                        $this->session->set_flashdata('success', 'Applied Sucessfully ......');
                        redirect('freelance-work/home/live-post/', refresh);
                        
                    } else {
                        redirect('freelance-work/home', refresh);
                    }
                } else {

                    //   $this->session->flashdata('error', 'Sorry!! Your data not inserted');
                    if ($postliveid) {
                        $this->session->flashdata('error', 'Sorry!! Your data not inserted');
                        redirect('freelance-work/registation' . $postliveid, refresh);
                    } else {
                        redirect('freelance-work/registation', refresh);
                    }
                }
            }
        }
    }

    //FREELANCER APPLY NEW REGISTATION INSERT END
    //CHECK FOR MAIL DESIGNING START
    public function email_view() {
        $userid = 140;
        $notid = 103;
        $postuser = $this->common->select_data_by_id('freelancer_post_reg', 'user_id', $userid, $data = 'freelancer_post_fullname,freelancer_post_username,freelancer_post_user_image,freelancer_apply_slug', $join_str = array());

        $hireuser = $this->common->select_data_by_id('freelancer_hire_reg', 'user_id', $notid, $data = 'email', $join_str = array());

        // apply mail start
        $email_html = '';
        $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;">';
        if ($postuser[0]['freelancer_post_user_image'] == '') {
            $fname = $postuser[0]['freelancer_post_fullname'];
            $lname = $postuser[0]['freelancer_post_username'];
            $sub_fname = substr($fname, 0, 1);
            $sub_lname = substr($lname, 0, 1);
            $email_html .= '<div class="post-img-div">' . ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)) . '</div></td>';
        } else {
            $email_html .= '<img alt="User Image" src="' . FREE_POST_PROFILE_THUMB_UPLOAD_URL . $postuser[0]['freelancer_post_user_image'] . '" width="60" height="60"></td>';
        }
        $email_html .= '<td style="padding:5px;">
						<p>Freelancer <b>' . $postuser[0]['freelancer_post_fullname'] . " " . $postuser[0]['freelancer_post_username'] . '</b> Applied on your Project.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a title="View Detail" class="btn" href="' . BASEURL . 'freelance-work/freelancer-details/' . $postuser[0]['freelancer_apply_slug'] . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';

        $this->data['templ'] = $email_html;
        $this->load->view('email_view', $this->data);
    }

//CHECK FOR MAIL DESIGNING END
    public function session() {
        if ($this->session->userdata('searchkeyword')) {
            $this->session->unset_userdata('searchkeyword');
        }
        if ($this->session->userdata('searchplace')) {
            $this->session->unset_userdata('searchplace');
        }
        $keyword = $_POST['keyword'];
        $keyword1 = $_POST['keyword1'];
        $this->session->set_userdata('searchkeyword', $keyword);
        $this->session->set_userdata('searchplace', $keyword1);
        // $data='yes';
        echo "yes";
    }

    //FOR FREELANCER APPLY PROGRESSBAR START
    public function progressbar() {
        $userid = $this->session->userdata('aileenuser');
        $contition_array = array('user_id' => $userid, 'status' => '1', 'is_delete' => '0');
        $this->data['apply_reg'] = $apply_reg = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_fullname,freelancer_post_username,freelancer_post_skypeid,freelancer_post_email,freelancer_post_phoneno,freelancer_post_country,freelancer_post_state,freelancer_post_city,freelancer_post_pincode,freelancer_post_field,freelancer_post_area,freelancer_post_skill_description,freelancer_post_hourly,freelancer_post_ratestate,freelancer_post_fixed_rate,freelancer_post_job_type,freelancer_post_work_hour,freelancer_post_degree,freelancer_post_stream,freelancer_post_univercity,freelancer_post_collage,freelancer_post_percentage,freelancer_post_passingyear,freelancer_post_portfolio_attachment,freelancer_post_portfolio,freelancer_post_exp_month,freelancer_post_exp_year,progressbar', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = array());

        if ($apply_reg > 0) {
            $notEmpty = 0;
            $totalField = 26;

            foreach ($apply_reg as $row) {
                $notEmpty += ($row['freelancer_post_fullname'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_username'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_skypeid'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_email'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_phoneno'] != 0) ? 1 : 0;
                $notEmpty += ($row['freelancer_post_country'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_state'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_city'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_pincode'] != 0) ? 1 : 0;
                $notEmpty += ($row['freelancer_post_field'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_area'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_skill_description'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_hourly'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_ratestate'] != '') ? 1 : 0;
                // $notEmpty += ($row['freelancer_post_fixed_rate'] != 0) ? 1 : 0;
                $notEmpty += ($row['freelancer_post_job_type'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_work_hour'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_degree'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_stream'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_univercity'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_collage'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_percentage'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_passingyear'] != '') ? 1 : 0;
                //  $notEmpty += ($row['freelancer_post_eduaddress'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_portfolio_attachment'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_portfolio'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_exp_month'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_exp_year'] != '') ? 1 : 0;
                //do with all field
            }

            $percentage = $notEmpty / $totalField * 100;
        }

        $this->data['count_profile'] = $percentage;
        $this->data['count_profile_value'] = ($percentage / 100);


        if ($this->data['count_profile'] == 100) {
            if ($apply_reg[0]['progressbar'] != 1) {
                $data = array(
                    'progressbar' => '0',
                    'modify_date' => date('Y-m-d h:i:s', time())
                );
                $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
            }
        } else {
            $data = array(
                'progressbar' => '0',
                'modify_date' => date('Y-m-d h:i:s', time())
            );
            $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
        }
    }

    //FOR FREELANCER APPLY PROGRESSBAR END
    public function post_slug() {
        $this->db->select('post_id,post_name');
        $res = $this->db->get('freelancer_post')->result();
        foreach ($res as $k => $v) {
            $data = array('post_slug' => $this->common->clean($v->post_name));
            $this->db->where('post_id', $v->post_id);
            $this->db->update('freelancer_post', $data);
        }
        echo "yes";
    }

    public function category_slug() {
        $this->db->select('category_id,category_name');
        $res = $this->db->get('category')->result();
        foreach ($res as $k => $v) {
            $data = array('category_slug' => $this->common->clean($v->category_name));
            $this->db->where('category_id', $v->category_id);
            $this->db->update('category', $data);
        }
        echo "yes";
    }

    public function skill_slug() {
        $this->db->select('skill_id,skill');
        $res = $this->db->get('skill')->result();
        foreach ($res as $k => $v) {
            $data = array('skill_slug' => $this->common->clean($v->skill));
            $this->db->where('skill_id', $v->skill_id);
            $this->db->update('skill', $data);
        }
        echo "yes";
    }

    public function freelancer_notification_count($to_id = '') {
        $contition_array = array('not_read' => '2', 'not_to_id' => $to_id, 'not_type !=' => '1', 'not_type !=' => '2');
        $result = $this->common->select_data_by_condition('notification', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $count = $result[0]['total'];
        return $count;
    }

//function user when live link and login start
   

}
