<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Freelancer_hire extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('user_post_model');
        
        $this->load->model('freelancer_hire_model');
        $this->lang->load('message', 'english');
        //AWS access info start
        $this->load->library('S3');
        //AWS access info end
        include ('main_profile_link.php');
        include ('freelancer_hire_include.php');
        $this->data['aileenuser_id'] = $this->session->userdata('aileenuser');
        
         
    }

    public function freelancer_hire() {
     
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image,ul.email");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
            $contition_array = array('status' => '1');
        $this->data['freelance_hire_link'] =  ($this->artist_profile_set == 1)?$this->artist_profile_link:base_url('artist/registration');
        $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = 'country_id,country_name', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        // FETCH STATE DATA  
        $contition_array = array('status' => '1', 'country_id' => $this->data['recdata']['re_comp_country']);
        $this->data['states'] = $this->common->select_data_by_condition('states', $contition_array, $data = '*', $sortby = 'state_id,state_name,country_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        // FETCH CITY DATA
        $contition_array = array('status' => '1', 'state_id' => $this->data['recdata']['re_comp_state']);
        $this->data['cities'] = $this->common->select_data_by_condition('cities', $contition_array, $data = '*', $sortby = 'city_name,city_id,state_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['search_banner'] = $this->load->view('freelancer_hire_live/search_banner', $this->data, TRUE);
        $this->data['title'] = "Recruiter Profile | Aileensoul";
        
        $this->load->view('freelancer_hire_live/index', $this->data);
    }
    
    public function freelancer_hire_old() {

        $userid = $this->session->userdata('aileenuser');

        $freelancerhiredata = $this->freelancer_hire_model->checkfreelanceruser($userid);

        if ($freelancerhiredata) {
            $this->load->view('freelancer/freelancer_hire/reactivate', $this->data);
        } else {
            $userid = $this->session->userdata('aileenuser');

            $select_data = 'free_hire_step';
            $jobdata = $this->freelancer_hire_model->getfreelancerhiredata($userid, $select_data);

            if (count($jobdata) > 0) {
                if ($jobdata['free_hire_step'] == 1) {
                    redirect('freelance-hire/address-information', refresh);
                } else if ($jobdata['free_hire_step'] == 2) {
                    redirect('freelance-hire/professional-information', refresh);
                } else if ($jobdata['free_hire_step'] == 3) {
                    redirect('freelance-hire/home', refresh);
                }
            } else {
                redirect('freelance-hire/registration', refresh);
                // $this->load->view('freelancer/freelancer_hire/freelancer_hire_basic_info', $this->data);
            }
        }
    }

    //FREELANCER HIRE NEW REGISTRATION PROFILE START
    public function hire_registation($postid = '') {

        $this->data['countries'] = $this->freelancer_hire_model->getCountry();
        $this->data['title'] = "Registration | Employer Profile" . TITLEPOSTFIX;

        if ($this->session->userdata('aileenuser')) {
            $userid = $this->session->userdata('aileenuser');
            $hireuser = $this->db->select('user_id')->get_where('freelancer_hire_reg', array('user_id' => $userid))->row()->user_id;
        }

        if ($hireuser) {
            redirect('freelance-hire/home', refresh);
        } else {
             $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['title'] = "Opportunities | Aileensoul";
            $this->load->view('freelancer_hire_live/index', $this->data);
        }
    }

    //FREELANCER HIRE NEW REGISTRATION PROFILE END
    public function hire_registation_insert() {
        $userid = $this->session->userdata('aileenuser');

        $this->form_validation->set_rules('firstname', 'Full Name', 'required');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required');
        $this->form_validation->set_rules('email_reg1', 'EmailId', 'required|valid_email');
        $this->form_validation->set_rules('country', 'country', 'required');
        $this->form_validation->set_rules('state', 'state', 'required');

        if ($this->form_validation->run() == FALSE) {
            $contition_array = array('status' => 1);
            $this->data['countries'] = $this->freelancer_hire_model->getCountry();
            $this->data['title'] = "Registration | Employer Profile" . TITLEPOSTFIX;
            $this->load->view('freelancer/freelancer_hire/hire_registration', $this->data);
        } else {
            $first_lastname = trim($this->input->post('firstname')) . " " . trim($this->input->post('lastname'));
            $data = array(
                'fullname' => trim($this->input->post('firstname')),
                'username' => trim($this->input->post('lastname')),
                'email' => trim($this->input->post('email_reg1')),
                'freelancer_hire_slug' => $this->setcategory_slug($first_lastname, 'freelancer_hire_slug', 'freelancer_hire_reg'),
                'phone' => trim($this->input->post('phoneno')),
                'country' => trim($this->input->post('country')),
                'state' => trim($this->input->post('state')),
                'city' => trim($this->input->post('city')),
                'professional_info' => trim($this->input->post('professional_info')),
                'status' => '1',
                'is_delete' => '0',
                'created_date' => date('Y-m-d h:i:s'),
                'user_id' => $userid,
                'free_hire_step' => '3'
            );
            $insert_id1 = $this->freelancer_hire_model->insert_data($data, 'freelancer_hire_reg');
            if ($this->input->post('segment') == 'live-post') {
                $segment = $this->input->post('segment');
                $temp = $this->freelancer_hire_model->getprojectlivedatabyuserid($userid);

                if (is_numeric($temp[0]['post_field_req'])) {
                    $fielddata = $temp[0]['post_field_req'];
                } else {
                    $data = array(
                        'category_name' => $temp[0]['post_field_req'],
                        'created_date' => date('Y-m-d h:i:s', time()),
                        'status' => '2',
                        'is_delete' => '0',
                        'is_other' => '2',
                        'user_id' => $userid,
                        'category_slug' => $this->freelancer_hire_model->clean($temp[0]['post_field_req'])
                    );
                    $insert_id = $this->freelancer_hire_model->insert_data_getid($data, 'category');
                    if ($insert_id) {
                        $contition_array = array('is_delete' => '0', 'category_name' => $temp[0]['post_field_req']);
                        $search_condition = "(is_other = '2' AND user_id = $userid)";
                        $fielddata = $this->freelancer_hire_model->select_data_by_search('category', $search_condition, $contition_array, $data = 'category_id', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                        $fielddata =$fielddata[0]['category_id'];
                    }
                }

                $data = array(
                    'post_name' => $temp[0]['post_name'],
                    'post_description' => $temp[0]['post_description'],
                    'post_field_req' => $fielddata,
                    'post_skill' => $temp[0]['post_skill'],
                    'post_other_skill' => $temp[0]['post_other_skill'],
                    'post_est_time' => $temp[0]['post_est_time'],
                    'post_rate' => $temp[0]['post_rate'],
                    'post_currency' => $temp[0]['post_currency'],
                    'post_rating_type' => $temp[0]['post_rating_type'],
                    'post_exp_month' => $temp[0]['post_exp_month'],
                    'post_exp_year' => $temp[0]['post_exp_year'],
                    'post_last_date' => $temp[0]['post_last_date'],
                    'post_slug' => $temp[0]['post_name'],
                    'user_id' => $userid,
                    'created_date' => date('Y-m-d', time()),
                    'status' => '1',
                    'is_delete' => '0',
                );


                $insert_id = $this->freelancer_hire_model->insert_data_getid($data, 'freelancer_post');

                $data = array(
                    'is_delete' => '1',
                    'status' => '0',
                    'modify_date' => date('y-m-d h:i:s')
                );

                $updatdata = $this->freelancer_hire_model->update_data($data, 'freelancer_post_live', 'post_id', $temp[0][post_id]);
            }


            if ($insert_id1) {
                // if ($this->input->post('segment') == 'live-post') {
                //     $this->session->set_flashdata('error', 'Your project successfully posted');
                  
                //   //  $this->load->view('freelancer/freelancer_hire/recommen_candidate', $this->data);
                //     redirect('freelance-hire/home', refresh);
                // } else {
                //     redirect('freelance-hire/add-projects?page=professional', refresh);
                // }
                redirect('freelance-hire/home', refresh);
            } else {
                redirect('freelance-hire', refresh);
            }
        }
    }

    public function freelancer_hire_basic_info() {
        $userid = $this->session->userdata('aileenuser');
        //check user deactivate start
        $this->freelancer_hire_deactivate_check();
        //check user deactivate end

        $select_data = 'fullname,username,email,skyupid,phone,user_id,free_hire_step';
        $userdata = $this->freelancer_hire_model->getfreelancerhiredata($userid, $select_data);

        if ($userdata) {
            $step = $userdata['free_hire_step'];
            if ($step == 1 || $step > 1) {
                $this->data['firstname1'] = $userdata['fullname'];
                $this->data['lastname1'] = $userdata['username'];
                $this->data['email1'] = $userdata['email'];
                $this->data['skypeid1'] = $userdata['skyupid'];
                $this->data['phoneno1'] = $userdata['phone'];
            }
        }

//for search start
        $this->freelancer_hire_search();
//for search end
        $this->data['title'] = "Basic Information | Employer Profile" . TITLEPOSTFIX;
        $this->load->view('freelancer/freelancer_hire/freelancer_hire_basic_info', $this->data);
    }

    public function freelancer_hire_basic_info_insert() {
        $userid = $this->session->userdata('aileenuser');
        $this->form_validation->set_rules('fname', 'Please Enter Your first Name', 'required');
        $this->form_validation->set_rules('lname', 'Please Enter Your last name', 'required');
        $this->form_validation->set_rules('email', 'Please Enter Your email', 'required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('freelancer/freelancer_hire/freelancer_hire_basic_info');
        } else {
            $contition_array = array('user_id' => $userid, 'status' => '1');
            $userdata = $this->freelancer_hire_model->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $first_lastname = trim($this->input->post('fname')) . " " . trim($this->input->post('lname'));
            if ($userdata) {
                $data = array(
                    'fullname' => trim($this->input->post('fname')),
                    'username' => trim($this->input->post('lname')),
                    'email' => trim($this->input->post('email')),
                    'freelancer_hire_slug' => $this->setcategory_slug($first_lastname, 'freelancer_hire_slug', 'freelancer_hire_reg'),
                    'skyupid' => trim($this->input->post('skyupid')),
                    'phone' => trim($this->input->post('phone')),
                    'modified_date' => date('Y-m-d h:i:s')
                );
                $updatedata = $this->freelancer_hire_model->update_data($data, 'freelancer_hire_reg', 'user_id', $userid);
                if ($updatedata) {
                    // $this->session->set_flashdata('success', 'Basic information updated successfully');
                    redirect('freelance-hire/address-information', refresh);
                } else {
                    //  $this->session->flashdata('error', 'Your data not inserted');
                    redirect('freelance-hire/basic-information', refresh);
                }
            } else {
                $data = array(
                    'fullname' => trim($this->input->post('fname')),
                    'username' => trim($this->input->post('lname')),
                    'email' => trim($this->input->post('email')),
                    'freelancer_hire_slug' => $this->setcategory_slug($first_lastname, 'freelancer_hire_slug', 'freelancer_hire_reg'),
                    'skyupid' => trim($this->input->post('skyupid')),
                    'phone' => trim($this->input->post('phone')),
                    'status' => '1',
                    'is_delete' => '0',
                    'created_date' => date('Y-m-d h:i:s'),
                    'user_id' => $userid,
                    'free_hire_step' => '1'
                );
                $insert_id = $this->freelancer_hire_model->insert_data($data, 'freelancer_hire_reg');
                if ($insert_id) {
                    //   $this->session->set_flashdata('success', 'Basic information updated successfully');
                    redirect('freelance-hire/address-information', refresh);
                } else {
                    //   $this->session->flashdata('error', 'Sorry!! Your data not inserted');
                    redirect('freelance-hire/basic-information', refresh);
                }
            }
        }
    }

// freelancer_hire profile slug start

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

    // freelancer_hire profile slug end
    function slug_script() {

        $this->db->select('reg_id,username,fullname');
        $res = $this->db->get('freelancer_hire_reg')->result();
        foreach ($res as $k => $v) {
            $data = array('freelancer_hire_slug' => $this->setcategory_slug($v->username . " " . fullname, 'freelancer_hire_slug', 'freelancer_hire_reg'));
            $this->db->where('reg_id', $v->reg_id);
            $this->db->update('freelancer_hire_reg', $data);
        }
        echo "yes";
    }

//check email avilibity start
    public function check_email() {

        $email = trim($this->input->post('email'));

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $email1 = $userdata[0]['email'];

        if ($email1) {

            $condition_array = array('is_delete' => '0', 'user_id !=' => $userid, 'status' => '1');

            $check_result = $this->common->check_unique_avalibility('freelancer_hire_reg', 'email', $email, '', '', $condition_array);
        } else {

            $condition_array = array('is_delete' => '0', 'status' => '1');

            $check_result = $this->common->check_unique_avalibility('freelancer_hire_reg', 'email', $email, '', '', $condition_array);
        }

        if ($check_result) {
            echo 'true';
            die();
        } else {
            echo 'false';
            die();
        }
    }

// check email end



    public function freelancer_hire_address_info() {
        $userid = $this->session->userdata('aileenuser');
        //if user deactive profile then redirect to freelancer_hire/freelancer_hire/freelancer_hire_basic_info  start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');
        $freelancerhire_deactive = $this->data['freelancerhire_deactive'] = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if ($freelancerhire_deactive) {
            redirect('freelancer_hire/freelancer_hire/freelancer_hire_basic_info');
        }
//if user deactive profile then redirect to freelancer_hire/freelancer_hire/freelancer_hire_basic_info  End
        // code for display page start
        $this->freelancer_hire_check();
        // code for display page end
        $contition_array = array('status' => '1');
        $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = '*', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'country,state,city,pincode,user_id,free_hire_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        //for getting state data
        $contition_array = array('status' => '1', 'country_id' => $userdata[0]['country']);
        $this->data['states'] = $this->common->select_data_by_condition('states', $contition_array, $data = '*', $sortby = 'state_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //for getting city data
        $contition_array = array('status' => '1', 'state_id' => $userdata[0]['state']);
        $this->data['cities'] = $this->common->select_data_by_condition('cities', $contition_array, $data = '*', $sortby = 'city_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userdata) {
            $step = $userdata[0]['free_hire_step'];

            if ($step == 2 || $step > 2 || ($step >= 1 && $step <= 2)) {
                $this->data['country1'] = $userdata[0]['country'];
                $this->data['state1'] = $userdata[0]['state'];
                $this->data['city1'] = $userdata[0]['city'];
                $this->data['pincode1'] = $userdata[0]['pincode'];
            }
        }

// code for search start
        $this->freelancer_hire_search();
// code for search end
        $this->data['title'] = "Address information | Employer Profile" . TITLEPOSTFIX;
        $this->load->view('freelancer/freelancer_hire/freelancer_hire_address_info', $this->data);
    }

    public function ajax_data() {
//ajax data for category and subcategory start

        if (isset($_POST["category_id"]) && !empty($_POST["category_id"])) {
            //Get all state data
            $contition_array = array('category_id' => $_POST["category_id"], 'status' => '1');
            $subcategory = $this->data['subcategory'] = $this->common->select_data_by_condition('sub_category', $contition_array, $data = '*', $sortby = 'sub_category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            //Count total number of rows
            //Display states list
            if (count($subcategory) > 0) {
                echo '<option value="">Select Area of Requirement</option>';
                foreach ($subcategory as $st) {
                    echo '<option value="' . $st['sub_category_id'] . '">' . $st['sub_category_name'] . '</option>';
                }
            } else {
                echo '<option value="">Area of Requirement not available</option>';
            }
        }



//ajax data for category and subcategory end 
        //ajax data for country and state and city
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

        if (isset($_POST["state_id"]) && !empty($_POST["state_id"])) {
            //Get all city data
            $contition_array = array('state_id' => $_POST["state_id"], 'status' => '1');
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

//FREELANCER_HIRE CHECK USER IS REGISTERD START
    public function freelancer_hire_check() {
          
        $userid = $this->session->userdata('aileenuser');
        $contition_array = array('user_id' => $userid, 'status' => '1', 'is_delete' => '0');
        $hire_step = $this->data['hire_step'] = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'free_hire_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        // echo $this->uri->segment(2); exit;

        if (count($hire_step) > 0) {
            if ($hire_step[0]['free_hire_step'] == '1') {
                if ($this->uri->segment(2) == 'address-information') {
                    
                } else {
                    redirect('freelance-hire/address-information');
                }
            } elseif ($hire_step[0]['free_hire_step'] == '2') {
                if ($this->uri->segment(2) == 'professional-information') {
                    
                } elseif ($this->uri->segment(2) == 'address-information') {
                    
                } else {
                    redirect('freelance-hire/professional-information');
                }
            }
        } else {
            redirect('freelance-hire/registration');
        }
    }

    //FREELANCER_HIRE CHECK USER IS REGISTERD END

    public function freelancer_hire_address_info_insert() {

        $userid = $this->session->userdata('aileenuser');



        //if ($this->input->post('next')) {


        $this->form_validation->set_rules('country', 'Please Enter Your country', 'required');
        $this->form_validation->set_rules('state', 'Please Enter Your state', 'required');


        if ($this->form_validation->run() == FALSE) {

            $this->load->view('freelancer/freelancer_hire/freelancer_hire_address_info');
        } else {
            //echo "hhh";
            $contition_array = array('user_id' => $userid, 'status' => '1', 'free_hire_step' => '3');
            $userdata = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if ($userdata) {
                $data = array(
                    'country' => trim($this->input->post('country')),
                    'state' => trim($this->input->post('state')),
                    'city' => trim($this->input->post('city')),
                    'pincode' => trim($this->input->post('pincode')),
                    'modified_date' => date('Y-m-d h:i:s')
                );
                $updatdata = $this->common->update_data($data, 'freelancer_hire_reg', 'user_id', $userid);
                if ($updatdata) {

                    //  $this->session->set_flashdata('success', 'Address information updated successfully');
                    redirect('freelance-hire/professional-information', refresh);
                } else {

                    // $this->session->flashdata('error', 'Sorry!! Your data not inserted');
                    redirect('freelance-hire/address-information', refresh);
                }
            } else {
                
            }



            $data = array(
                'country' => trim($this->input->post('country')),
                'state' => trim($this->input->post('state')),
                'city' => trim($this->input->post('city')),
                'pincode' => trim($this->input->post('pincode')),
                'modified_date' => date('Y-m-d h:i:s'),
                'user_id' => $userid,
                'free_hire_step' => '2'
            );



            $updatdata = $this->common->update_data($data, 'freelancer_hire_reg', 'user_id', $userid);


            if ($updatdata) {

                //   $this->session->set_flashdata('success', 'Address information updated successfully');
                redirect('freelance-hire/professional-information', refresh);
            } else {

                //  $this->session->flashdata('error', 'Sorry!! Your data not inserted');
                redirect('freelance-hire/address-information', refresh);
            }
        }
        //}
    }

    public function freelancer_hire_professional_info() {
        $userid = $this->session->userdata('aileenuser');
//if user deactive profile then redirect to freelancer_hire/freelancer_hire/freelancer_hire_basic_info  start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');
        $freelancerhire_deactive = $this->data['freelancerhire_deactive'] = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if ($freelancerhire_deactive) {
            redirect('freelancer_hire/freelancer_hire/freelancer_hire_basic_info');
        }
//if user deactive profile then redirect to freelancer_hire/freelancer_hire/freelancer_hire_basic_info  End
        // code for display page start
        $this->freelancer_hire_check();
        // code for display page end
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'free_hire_step,professional_info', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if ($userdata) {
            $step = $userdata[0]['free_hire_step'];

            if ($step == 3 || ($step >= 1 && $step <= 3) || $step > 3) {
                $this->data['professional_info1'] = $userdata[0]['professional_info'];
            }
        }
// code for search start
        $this->freelancer_hire_search();
// code for search end
        $this->data['title'] = "Professional Information | Employer Profile" . TITLEPOSTFIX;
        $this->load->view('freelancer/freelancer_hire/freelancer_hire_professional_info', $this->data);
    }

    public function freelancer_hire_professional_info_insert() {

        $userid = $this->session->userdata('aileenuser');
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');





        // if ($this->input->post('next')) {
//            $this->form_validation->set_rules('professional_info', ' Please Enter Your professional info', 'required');
//            if ($this->form_validation->run() == FALSE) {
//
//                $this->load->view('freelancer/freelancer_hire/freelancer_hire_professional_info');
//            } else {

        $data = array(
            'professional_info' => trim($this->input->post('professional_info')),
            'modified_date' => date('Y-m-d h:i:s'),
            'user_id' => $userid,
            'free_hire_step' => '3'
        );



        $updatdata = $this->common->update_data($data, 'freelancer_hire_reg', 'user_id', $userid);


        if ($updatdata) {

//                    $this->session->set_flashdata('success', 'professional information updated successfully');

            if ($userdata[0]['free_hire_step'] == 3) {
                redirect('freelance-hire/employer-details', refresh);
            } else {
                redirect('freelance-hire/add-projects?page=professional', refresh);
            }
        } else {

            $this->session->flashdata('error', 'Sorry!! Your data not inserted');
            redirect('freelance-hire/professional-information', refresh);
        }
        // }
        // }
    }

    //keyskill automatic retrieve cobtroller start
    public function keyskill() {
        $json = [];
        $where = "type='1' AND status='1'";

        if (!empty($this->input->get("q"))) {
            $this->db->like('skill', $this->input->get("q"));
            $query = $this->db->select('skill_id as id,skill as text')
                    ->where($where)
                    ->limit(10)
                    ->get("skill");
            $json = $query->result();
        }


        echo json_encode($json);
    }

//keyskill automatic retrieve cobtroller End
    //reactivate account start

    public function reactivate() {

        $userid = $this->session->userdata('aileenuser');
        $data = array(
            'status' => '1',
            'modified_date' => date('y-m-d h:i:s')
        );
        $data1 = array(
            'status' => '1',
            'modify_date' => date('y-m-d h:i:s')
        );

        $updatdata = $this->common->update_data($data, 'freelancer_hire_reg', 'user_id', $userid);
        $update = $this->common->update_data($data1, 'freelancer_post', 'user_id', $userid);
        if ($update && $updatdata) {

            redirect('freelance-hire/home', refresh);
        } else {

            redirect('freelancer_hire/reactivate', refresh);
        }
    }

//reactivate accont end
    public function freelancer_hire_search() {
        $contition_array = array('status' => '1', 'is_delete' => '0');
        $field = $this->data['results'] = $this->common->select_data_by_condition('category', $contition_array, $data = 'category_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        $contition_array = array('status' => '1', 'is_delete' => '0', 'free_post_step' => '7');
        $freelancer_postdata = $this->data['results'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_otherskill,designation', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        $contition_array = array('status' => '1', 'type' => '1');
        $skill = $this->data['skill'] = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        $unique = array_merge($field, $skill, $freelancer_postdata);
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
        $location_list = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        foreach ($location_list as $key1 => $value) {
            foreach ($value as $ke1 => $val1) {
                $location[] = $val1;
            }
        }
        foreach ($location as $key => $value) {
            $loc[$key]['label'] = $value;
            $loc[$key]['value'] = $value;
        }
        $this->data['city_data'] = array_values($loc);
        $this->data['demo'] = array_values($result1);
    }

    //FREELANCER_HIRE HOME PAGE START
    //FREELANCER_HIRE DEACTIVATE CHECK START
    public function freelancer_hire_deactivate_check() {
        $userid = $this->session->userdata('aileenuser');
//if user deactive profile then redirect to freelancer_hire/freelancer_hire/freelancer_hire_basic_info  start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');
        $freelancerhire_deactive = $this->data['freelancerhire_deactive'] = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if ($freelancerhire_deactive) {
            redirect('freelance-hire');
        }
//if user deactive profile then redirect to freelancer_hire/freelancer_hire/freelancer_hire_basic_info  End
    }

//FREELANCER_HIRE DEACTIVATE CHECK END


    public function recommen_candidate() {
        $userid = $this->session->userdata('aileenuser');

        //check user deactivate start
        $this->freelancer_hire_deactivate_check();
        //check user deactivate end
        // code for display page start
        $this->freelancer_hire_check();
        // code for display page end
        $this->data['title'] = 'Home | Employer Profile' . TITLEPOSTFIX;
        $this->load->view('freelancer/freelancer_hire/recommen_candidate', $this->data);
    }

//FREELANCER_HIRE HOME PAGE END
//AJAX FREELANCER_HIRE HOME PAGE START
    public function ajax_recommen_candidate() {


        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $freelancerhiredata = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data = '*', $sortby = 'post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if (count($freelancerhiredata) <= 0) {
            $return_html .= '<div class="text-center rio" style="border: none;">';
            $return_html .= '<div class="no-post-title">';
            $return_html .= '<h4 class="page-heading  product-listing" style="border:0px;">Lets create your project.</h4>';
            $return_html .= '<h4 class="page-heading  product-listing" style="border:0px;"> It will takes only few minutes.</h4>';
            $return_html .= '</div>';
            $return_html .= '<div  class="add-post-button add-post-custom">';
            $return_html .= '<a title="Post Project" class="btn btn-3 btn-3b"  href="' . base_url() . 'freelance-hire/add-projects"><i class="fa fa-plus" aria-hidden="true"></i>  Post Project</a>';
            $return_html .= '</div>';
            $return_html .= '</div>';
            echo $return_html;
        } else {
            foreach ($freelancerhiredata as $frdata) {

                $post_skill_data = $frdata['post_skill'];
                $postuserarray = explode(',', $frdata['post_skill']);

                $all_candidate = array();
                foreach ($postuserarray as $skill_find) {

                    $contition_array = array('status' => '1', 'is_delete' => '0', 'free_post_step' => '7', 'user_id != ' => $userid, 'FIND_IN_SET("' . $skill_find . '", freelancer_post_area) != ' => '0');
                    $all_candidate[] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_reg_id,freelancer_post_fullname, freelancer_post_username,freelancer_post_field, freelancer_post_city, freelancer_post_area, freelancer_post_skill_description, freelancer_post_hourly, freelancer_post_ratestate, freelancer_post_fixed_rate, freelancer_post_work_hour, user_id, freelancer_post_user_image, designation, freelancer_post_otherskill, freelancer_post_exp_month, freelancer_post_exp_year,freelancer_apply_slug,freelancer_post_country', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                }
                //        TO CHANGE ARRAY OF ARRAY TO ARRAY START
                $final_candidate = array_reduce($all_candidate, 'array_merge', array());
                //        TO CHANGE ARRAY OF ARRAY TO ARRAY END
                // change the order to decending           
                rsort($final_candidate);
                $pqr[] = $final_candidate;

                $contition_array = array('status' => '1', 'is_delete' => '0', 'free_post_step' => '7', 'user_id != ' => $userid, 'freelancer_post_field' => $frdata['post_field_req']);
                $freelancerpostfield[] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_reg_id,freelancer_post_fullname, freelancer_post_username,freelancer_post_field, freelancer_post_city, freelancer_post_area, freelancer_post_skill_description, freelancer_post_hourly, freelancer_post_ratestate, freelancer_post_fixed_rate, freelancer_post_work_hour, user_id, freelancer_post_user_image, designation, freelancer_post_otherskill, freelancer_post_exp_month, freelancer_post_exp_year,freelancer_apply_slug,freelancer_post_country', $sortby = '', $orderby = 'asc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            }
            // die();
//        TO CHANGE ARRAY OF ARRAY TO ARRAY START
            $final_candidate = array_reduce($pqr, 'array_merge', array());
            $final_field = array_reduce($freelancerpostfield, 'array_merge', array());
//        TO CHANGE ARRAY OF ARRAY TO ARRAY END

            $applyuser_merge = array_merge((array) $final_candidate, (array) $final_field);
            $unique = array_unique($applyuser_merge, SORT_REGULAR);

            $candidatefreelancer = $unique;
            $candidatefreelancer1 = array_slice($candidatefreelancer, $start, $perpage);

            if (empty($_GET["total_record"])) {
                $_GET["total_record"] = count($candidatefreelancer);
            }

            $return_html = '';

            $return_html .= '<input type = "hidden" class = "page_number" value = "' . $page . '" />';
            $return_html .= '<input type = "hidden" class = "total_record" value = "' . $_GET["total_record"] . '" />';
            $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';

            if (count($candidatefreelancer) > 0) {
                foreach ($candidatefreelancer1 as $row) {
                    $return_html .= '<div class = "profile-job-post-detail clearfix">
                <div class = "profile-job-post-title-inside clearfix">
                <div class = "profile-job-profile-button clearfix">
                <div class = "profile-job-post-location-name-rec">
                <div class = "fl" style = "display: inline-block;">
                <div class = "buisness-profile-pic-candidate">';
                    $post_fname = $row['freelancer_post_fullname'];
                    $post_lname = $row['freelancer_post_username'];
                    $sub_post_fname = substr($post_fname, 0, 1);
                    $sub_post_lname = substr($post_lname, 0, 1);
                    if ($row['freelancer_post_user_image']) {
                        if (IMAGEPATHFROM == 'upload') {
                            if (!file_exists($this->config->item('free_post_profile_main_upload_path') . $row['freelancer_post_user_image'])) {
                                $return_html .= '<a href = "' . base_url('freelance-work/freelancer-details/' . $row['freelancer_apply_slug']) . '" title = "' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">';
                                $return_html .= '<div class = "post-img-div">';
                                $return_html .= ucfirst(strtolower($sub_post_fname)) . ucfirst(strtolower($sub_post_lname));
                                $return_html .= '</div>
                                 </a>';
                            } else {
                                $return_html .= '<a href = "' . base_url('freelance-work/freelancer-details/' . $row['freelancer_apply_slug']) . '" title = "' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">
                <img src = "' . FREE_POST_PROFILE_THUMB_UPLOAD_URL . $row['freelancer_post_user_image'] . '" alt = " ' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">
                </a>';
                            }
                        } else {
                            $filename = $this->config->item('free_post_profile_main_upload_path') . $row['freelancer_post_user_image'];
                            $s3 = new S3(awsAccessKey, awsSecretKey);
                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                            if ($info) {
                                $return_html .= '<a href = "' . base_url('freelance-work/freelancer-details/' . $row['freelancer_apply_slug']) . '" title = "' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">
                <img src = "' . FREE_POST_PROFILE_THUMB_UPLOAD_URL . $row['freelancer_post_user_image'] . '" alt = " ' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">
                </a>';
                            } else {
                                $return_html .= '<a href = "' . base_url('freelance-work/freelancer-details/' . $row['freelancer_apply_slug']) . '" title = "' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">';
                                $return_html .= '<div class = "post-img-div">';
                                $return_html .= ucfirst(strtolower($sub_post_fname)) . ucfirst(strtolower($sub_post_lname));
                                $return_html .= '</div>
                </a>';
                            }
                        }
                    } else {
                        $return_html .= '<a href = "' . base_url('freelance-work/freelancer-details/' . $row['freelancer_apply_slug']) . '" title = "' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">';
                        $return_html .= '<div class = "post-img-div">';
                        $return_html .= ucfirst(strtolower($sub_post_fname)) . ucfirst(strtolower($sub_post_lname));
                        $return_html .= '</div>
                </a>';
                    }
                    $return_html .= '</div>
                </div>
                <div class = "designation_rec fl">
                <ul>
                <li>
                <a href = " ' . base_url('freelance-work/freelancer-details/' . $row['freelancer_apply_slug']) . '" title = "' . ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '">
                <h6>';
                    $return_html .= ucwords($row['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']);
                    $return_html .= '</h6>
                </a>
                </li>
                <li style = "display: block;" >';
                    $return_html .= '<a href = "JavaScript:Void(0);" title = "' . ucwords($row['designation']) . '">';
                    if ($row['designation']) {
                        $return_html .= $row['designation'];
                    } else {
                        $return_html .= $this->lang->line("designation");
                    }
                    $return_html .= '</a></li>
                </ul>
                </div>
                </div>
                </div>
                </div> <div class = "profile-job-post-title clearfix">
                <div class = "profile-job-profile-menu">
                <ul class = "clearfix">
                <li><b>';
                    $return_html .= $this->lang->line("field");
                    $return_html .= '</b><span>';
                    if ($row['freelancer_post_field']) {
                        $field_name = $this->db->select('category_name')->get_where('category', array('category_id' => $row['freelancer_post_field']))->row()->category_name;
                        $return_html .= $field_name;
                    } else {
                        $return_html .= PROFILENA;
                    }

                    $return_html .= '</li></span><li><b>';
                    $return_html .= $this->lang->line("skill");
                    $return_html .= '</b><span>';
                    $aud = $row['freelancer_post_area'];
                    // echo $aud;
                    $aud_res = explode(',', $aud);
                    //echo "<pre>";print_r($aud_res);die();
                    if (!$row['freelancer_post_area']) {
                        $return_html .= $row['freelancer_post_otherskill'];
                    } elseif (!$row['freelancer_post_otherskill']) {
                        foreach ($aud_res as $skill) {
                            $cache_time = $this->db->select('skill')->get_where('skill', array('skill_id' => $skill))->row()->skill;
                            $skillsss[] = $cache_time;
                        }
                        $listskill = implode(', ', $skillsss);
                        $return_html .= $listskill;
                        unset($skillsss);
                    } elseif ($row['freelancer_post_area'] && $row['freelancer_post_otherskill']) {
                        foreach ($aud_res as $skillboth) {
                            $cache_time = $this->db->select('skill')->get_where('skill', array('skill_id' => $skillboth))->row()->skill;
                            $skilldddd[] = $cache_time;
                        }
                        $listFinal = implode(', ', $skilldddd);
                        $return_html .= $listFinal . "," . $row['freelancer_post_otherskill'];
                        unset($skilldddd);
                    }

                    $return_html .= '</span>
                </li>';
                    $cityname = $this->db->select('city_name')->get_where('cities', array('city_id' => $row['freelancer_post_city']))->row()->city_name;
                    $countryname = $this->db->select('country_name')->get_where('countries', array('country_id' => $row['freelancer_post_country']))->row()->country_name;
                    $return_html .= '<li><b>';
                    $return_html .= $this->lang->line("location");
                    $return_html .= '</b><span>';
                    if ($cityname || $countryname) {
                        if ($cityname) {
                            $return_html .= $cityname . ",";
                        }
                        if ($countryname) {
                            $return_html .= $countryname;
                        }
                    }
                    $return_html .= '</span></li>
                <li><b>';
                    $return_html .= $this->lang->line("skill_description");
                    $return_html .= '</b><span><p>';
                    if ($row['freelancer_post_skill_description']) {
                        $return_html .= $row['freelancer_post_skill_description'];
                    } else {
                        $return_html .= PROFILENA;
                    }
                    $return_html .= '</p></span>
                </li>
                <li><b>';
                    $return_html .= $this->lang->line("avaiability");
                    $return_html .= '</b><span>';
                    if ($row['freelancer_post_work_hour']) {
                        $return_html .= $row['freelancer_post_work_hour'] . "  " . $this->lang->line("hours_per_week");
                        ;
                    } else {
                        $return_html .= PROFILENA;
                    }
                    $return_html .= '</span>
                </li>
                <li><b>';
                    $return_html .= $this->lang->line("rate_hourly");
                    $return_html .= '</b> <span>';
                    if ($row['freelancer_post_hourly']) {
                        $currency = $this->db->select('currency_name')->get_where('currency', array('currency_id' => $row['freelancer_post_ratestate']))->row()->currency_name;
                        if ($row['freelancer_post_fixed_rate'] == '1') {
                            $return_html .= $row['freelancer_post_hourly'] . "   " . $currency . "  (Also work on fixed Rate) ";
                        } else {
                            $return_html .= $row['freelancer_post_hourly'] . "   " . $currency . "  " . $rate_type;
                        }
                    } else {
                        $return_html .= PROFILENA;
                    }

                    $return_html .= '</span>
                </li>
                <li><b>';
                    $return_html .= $this->lang->line("total_experiance");
                    $return_html .= '</b>
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
                            $return_html .= $totalyear . $this->lang->line("year");
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
                </li>
                </ul>
                </div>
                <div class = "profile-job-profile-button clearfix">
                <div class = "apply-btn fr">';
                    $userid = $this->session->userdata('aileenuser');
                    $contition_array = array('from_id' => $userid, 'to_id' => $row['user_id'], 'save_type' => '2');
                    $data = $this->common->select_data_by_condition('save', $contition_array, $data = 'status', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    if ($userid != $row['user_id']) {
                        $return_html .= '<a href = " ' . base_url('chat/abc/3/4/' . $row['user_id']) . '" title="Message">';
                        $return_html .= $this->lang->line("message");
                        $return_html .= '</a>';
                        if ($data[0]['status'] == 1 || $data[0]['status'] == '') {
                            $return_html .= '<input type = "hidden" id = "hideenuser' . $row['user_id'] . '" value = "' . $data[0]['save_id'] . '">';
                            $return_html .= '<a title = "save" id = "' . $row['user_id'] . '" onClick = "savepopup(' . $row['user_id'] . ')" href = "javascript:void(0);" class = "saveduser' . $row['user_id'] . '">';

                            $return_html .= $this->lang->line("save");
                            $return_html .= '</a>';
                        } elseif ($data[0]['status'] == 2) {

                            $return_html .= '<a title ="Shortlisted" class = "saved">';
                            $return_html .= 'Shortlisted';
                            $return_html .= '</a>';
                        } else {

                            $return_html .= '<a title="Saved" class = "saved">';
                            $return_html .= $this->lang->line("saved");
                            $return_html .= '</a>';
                        }
                    }

                    $return_html .= ' </div>
                </div>
                </div>
                </div>';
                }
            } else {
                $return_html .= '<div class="art-img-nn">
                                                <div class="art_no_post_img">

                                                    <img alt="No freelancer" src="../assets/img/free-no1.png">

                                                </div>
                                                <div class="art_no_post_text">';
                $return_html .= $this->lang->line("no_freelancer_found");
                $return_html .= ' </div>
                                            </div>';
            }
            echo $return_html;
        }
    }

//AJAX FREELANCER_HIRE HOME PAGE END
    //FREELANCER_HIRE_PROFILE PAGE START
    public function freelancer_hire_profile($id = "") {
        if (is_numeric($id)) {
            
        } else {
            $id = $this->db->select('user_id')->get_where('freelancer_hire_reg', array('freelancer_hire_slug' => $id, 'status' => '1'))->row()->user_id;
        }
        $userid = $this->session->userdata('aileenuser');
        //check user deactivate start
        $this->freelancer_hire_deactivate_check();
        //check user deactivate end
        if ($id == $userid || $id == '') {
            // code for display page start
            $this->freelancer_hire_check();
            // code for display page end
            $contition_array = array('user_id' => $userid, 'status' => '1');
            $hire_data = $this->data['freelancerhiredata'] = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'username, fullname, email, skyupid, phone, country, state, city, pincode, professional_info, freelancer_hire_user_image, profile_background, user_id,designation', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {
            $contition_array = array('user_id' => $id, 'status' => '1', 'free_hire_step' => '3');
            $hire_data = $this->data['freelancerhiredata'] = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'username, fullname, email, skyupid, phone, country, state, city, pincode, professional_info, freelancer_hire_user_image, profile_background, user_id,designation', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }
        $this->data['title'] = ucfirst($hire_data[0]['fullname']) . " " . ucfirst($hire_data[0]['username']) . " | Details | Employer Profile" . TITLEPOSTFIX;
        $this->load->view('freelancer/freelancer_hire/freelancer_hire_profile', $this->data);
    }

//FREELANCER_HIRE_PROFILE PAGE END
    //FREELANCER_HIRE POST(PROJECT) PAGE START
    public function freelancer_hire_post($id = "") {
        if (is_numeric($id)) {
            
        } else {
            $id = $this->db->select('')->select('user_id')->get_where('freelancer_hire_reg', array('freelancer_hire_slug' => $id, 'status' => '1'))->row()->user_id;
        }
        $userid = $this->session->userdata('aileenuser');
        //check user deactivate start
        $this->freelancer_hire_deactivate_check();
        //check user deactivate end
        if ($id == '') {
            // code for display page start
            $this->freelancer_hire_check();
            // code for display page end
            $contition_array = array('is_delete' => '0', 'user_id' => $userid, 'status' => '1', 'free_hire_step' => '3');
            $data = 'username,fullname,designation,freelancer_hire_user_image,user_id';
            $hire_data = $this->data['freelancr_user_data'] = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        } else {
            $userid = $id;
            $contition_array = array('is_delete' => '0', 'user_id' => $userid, 'status' => '1', 'free_hire_step' => '3');
            $data = 'username,fullname,designation,freelancer_hire_user_image,user_id';
            $hire_data = $this->data['freelancr_user_data'] = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        }
        $this->data['title'] = ucfirst($hire_data[0]['fullname']) . " " . ucfirst($hire_data[0]['username']) . " | Projects | Employer Profile " . TITLEPOSTFIX;
        $this->load->view('freelancer/freelancer_hire/freelancer_hire_post', $this->data);
    }

//FREELANCER_HIRE POST(PROJECT) PAGE END
//AJAX DATA FOR FREELANCER_HIRE POST(PROJECT) PAGE START
    public function ajax_freelancer_hire_post($id = "", $retur = "") {

        $userid = $this->session->userdata('aileenuser');
        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;
        if ($id == 'null') {

            $join_str[0]['table'] = 'freelancer_hire_reg';
            $join_str[0]['join_table_id'] = 'freelancer_hire_reg.user_id';
            $join_str[0]['from_table_id'] = 'freelancer_post.user_id';
            $join_str[0]['join_type'] = '';

            $limit = $perpage;
            $offset = $start;

            $contition_array = array('freelancer_post.is_delete' => '0', 'freelancer_hire_reg.user_id' => $userid, 'freelancer_hire_reg.status' => '1', 'freelancer_hire_reg.free_hire_step' => '3');
            $data = 'freelancer_post.post_id,freelancer_post.post_name,freelancer_post.post_field_req,freelancer_post.post_est_time,freelancer_post.post_skill,freelancer_post.post_other_skill,freelancer_post.post_rate,freelancer_post.post_last_date,freelancer_post.post_description,freelancer_post.user_id,freelancer_post.created_date,freelancer_post.post_currency,freelancer_post.post_rating_type,freelancer_post.post_exp_month,freelancer_post.post_exp_year,freelancer_hire_reg.username,freelancer_hire_reg.fullname,freelancer_hire_reg.designation,freelancer_hire_reg.freelancer_hire_user_image,freelancer_hire_reg.country,freelancer_hire_reg.city';
            $postdata = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data, $sortby = 'freelancer_post.post_id', $orderby = 'desc', $limit, $offset, $join_str, $groupby = '');
            $postdata1 = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data, $sortby = 'freelancer_post.post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
        } else {
            if (is_numeric($id)) {
                
            } else {
                $id = $category = $this->db->select('user_id')->get_where('freelancer_hire_reg', array('freelancer_hire_slug' => $id, 'status' => '1'))->row()->user_id;
            }

            $userid = $id;
            $join_str[0]['table'] = 'freelancer_hire_reg';
            $join_str[0]['join_table_id'] = 'freelancer_hire_reg.user_id';
            $join_str[0]['from_table_id'] = 'freelancer_post.user_id';
            $join_str[0]['join_type'] = '';

            $limit = $perpage;
            $offset = $start;

            $contition_array = array('freelancer_post.is_delete' => '0', 'freelancer_hire_reg.user_id' => $userid, 'freelancer_hire_reg.status' => '1', 'freelancer_hire_reg.free_hire_step' => '3');
            $data = 'freelancer_post.post_id,freelancer_post.post_name,freelancer_post.post_field_req,freelancer_post.post_est_time,freelancer_post.post_skill,freelancer_post.post_other_skill,freelancer_post.post_rate,freelancer_post.post_last_date,freelancer_post.post_description,freelancer_post.user_id,freelancer_post.created_date,freelancer_post.post_currency,freelancer_post.post_rating_type,freelancer_post.post_exp_month,freelancer_post.post_exp_year,freelancer_hire_reg.username,freelancer_hire_reg.fullname,freelancer_hire_reg.designation,freelancer_hire_reg.freelancer_hire_user_image,freelancer_hire_reg.country,freelancer_hire_reg.city';
            $postdata = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data, $sortby = 'freelancer_post.post_id', $orderby = 'desc', $limit, $offset, $join_str, $groupby = '');
            $postdata1 = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data, $sortby = 'freelancer_post.post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
        }

        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($postdata1);
        }

        $return_html = '';
        $return_html .= '<input type="hidden" class="page_number" value="' . $page . '" />';
        $return_html .= '<input type="hidden" class="total_record" value="' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';

        if (count($postdata1) > 0) {
            foreach ($postdata as $post) {
                $userid = $this->session->userdata('aileenuser');
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
                $return_html .= '<h5><a title="' . $post['post_name'] . '" href="' . base_url('freelance-hire/project/' . $text . $cityname1 . '-' . $post['user_id'] . '-' . $post['post_id']) . ' ">';
                $return_html .= $post['post_name'];
                $return_html .= '</a></h5>';
                $return_html .= '<p><a title="' . ucwords($firstname) . " " . ucwords($lastname) . '" href="' . base_url('freelance-hire/employer-details/' . $hireslug) . '">';
                $return_html .= ucwords($firstname) . " " . ucwords($lastname);
                $return_html .= '</a></p>
            </div>
            </div>
            <div class="all-job-middle">
                <p class="pb5">
                    <span class="location">';
                $return_html .= '<span><img alt="location" class="pr5" src="' . base_url('assets/images/location.png') . '">';
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
                    $return_html .= '.....<a title="Read more" href="' . base_url('freelance-hire/project/' . $text . $cityname1 . '-' . $post['user_id'] . '-' . $post['post_id']) . ' ">Read more</a>';
                }
                $return_html .= '</p>

            </div>
            <div class="all-job-bottom">
                <span class="job-post-date"><b>Posted on: </b>';
                $return_html .= trim(date('d-M-Y', strtotime($post['created_date'])));
                $return_html .= '</span>
                <p class="pull-right">';
                if ($retur == '' && $id == 'null') {
                    $return_html .= '<a title="Remove" href="javascript:void(0);" class="btn4" onclick="removepopup(' . $post['post_id'] . ')">Remove</a>';
                    $return_html .= '<a title="Edit" href="' . base_url('freelance-hire/edit-projects/' . $post['post_id']) . '" class="btn4")">Edit</a>';

                    $join_str[0]['table'] = 'freelancer_post_reg';
                    $join_str[0]['join_table_id'] = 'freelancer_post_reg.user_id';
                    $join_str[0]['from_table_id'] = 'freelancer_apply.user_id';
                    $join_str[0]['join_type'] = '';

                    $contition_array = array('freelancer_post_reg.status' => '1', 'freelancer_apply.post_id' => $post['post_id'], 'freelancer_apply.is_delete ' => '0');
                    $apply_count = $this->data['results'] = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = 'freelancer_apply.user_id', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
                    $return_html .= '<a title="Applied Persons" href="' . base_url('freelance-hire/freelancer-applied/' . $post['post_id']) . '" class="btn4" >Applied Persons:';
                    $return_html .= count($apply_count);
                    $return_html .= '</a>';

                    $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
                    $join_str = array(array(
                            'join_type' => '',
                            'table' => 'freelancer_apply',
                            'join_table_id' => 'freelancer_post_reg.user_id',
                            'from_table_id' => 'freelancer_apply.user_id'),
                        array(
                            'join_type' => '',
                            'table' => 'save',
                            'join_table_id' => 'freelancer_post_reg.user_id',
                            'from_table_id' => 'save.to_id')
                    );

                    $contition_array = array('freelancer_apply.post_id' => $post['post_id'], 'freelancer_apply.is_delete' => '0', 'save.from_id' => $userid, 'save.save_type' => '2', 'save.status' => '2', 'freelancer_post_reg.status' => '1');
                    $data = 'freelancer_post_reg.user_id';
                    $shortlist = $this->data['shortlist'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data, $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
                    $return_html .= '<a title="Shortlisted Persons" href="' . base_url('freelance-hire/freelancer-shortlisted/' . $post['post_id']) . '" class="btn4">Shortlisted Persons:';
                    $return_html .= count($shortlist);
                    $return_html .= '</a>';
                } else {
                    $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
                    $contition_array = array('post_id' => $post['post_id'], 'job_delete' => '0', 'user_id' => $userid);
                    $freelancerapply1 = $this->data['freelancerapply'] = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    if ($freelancerapply1) {
                        $return_html .= '<a title="Applied"  href="javascript:void(0);" class="btn4 applied">Applied</a>';
                    } else {
                        if (is_numeric($this->uri->segment(3))) {
                            $id = $this->uri->segment(3);
                        } else {
                            $id = $this->db->select('user_id')->get_where('freelancer_hire_reg', array('freelancer_hire_slug' => $this->uri->segment(3), 'status' => '1'))->row()->user_id;
                        }

                        $return_html .= '<input type="hidden" id="allpost' . $post['post_id'] . '" value="all">';
                        $return_html .= '<input type="hidden" id="userid' . $post['post_id'] . '" value="' . $post['user_id'] . '">';
                        $return_html .= '<a title ="Apply" href="javascript:void(0);" class="btn4 applypost' . $post['post_id'] . '" onclick="applypopup(' . $post['post_id'] . ',' . $id . ')">Apply</a>';

                        $userid = $this->session->userdata('aileenuser');
                        $contition_array = array('user_id' => $userid, 'job_save' => '2', 'post_id ' => $post['post_id'], 'job_delete' => '1');
                        $data = $this->data['jobsave'] = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                        if ($data) {
                            $return_html .= '<a title = "Saved" href="javascript:void(0);" class="btn4 savedpost' . $post['post_id'] . '" >Saved</a>';
                        } else {
                            $return_html .= '<input type="hidden" name="saveuser"  id="saveuser" value= "' . $data[0]['save_id'] . '">';
                            $return_html .= '<a title="Save" id="' . $post['post_id'] . '" href="javascript:void(0);" class="btn4 savedpost' . $post['post_id'] . '" onClick="savepopup(' . $post['post_id'] . ')">Save</a>';
                        }
                    }
                }

                $return_html .= ' </p>

</div>
</div>';
            }
        } else {
            $return_html .= '<div class="art-img-nn">
                                                <div class="art_no_post_img">

                                                    <img alt="No Projects" src="../assets/img/free-no1.png">

                                                </div>
                                                <div class="art_no_post_text">';
            $return_html .= $this->lang->line("no_post");
            $return_html .= ' </div>
                                            </div>';
        }

        echo $return_html;
    }

//AJAX DATA FOR FREELANCER_HIRE POST(PROJECT) PAGE START
    //FREELANCER_HIRE SAVE USER(FREELACER) START
    public function freelancer_save() {
        $userid = $this->session->userdata('aileenuser');
        //check user deactivate start
        $this->freelancer_hire_deactivate_check();
        //check user deactivate end
        // code for display page start
        $this->freelancer_hire_check();
        // code for display page end
        $contition_array = array('is_delete' => '0', 'user_id' => $userid, 'status' => '1', 'free_hire_step' => '3');
        $data = 'username,fullname,designation,freelancer_hire_user_image,user_id';
        $hire_data = $this->data['freelancr_user_data'] = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

        $this->data['title'] = ucfirst($hire_data[0]['fullname']) . " " . ucfirst($hire_data[0]['username']) . " | Saved Freelancer | Employer Profile" . TITLEPOSTFIX;
        $this->load->view('freelancer/freelancer_hire/freelancer_save', $this->data);
    }

//FREELANCER_HIRE SAVE USER(FREELACER) END
//AJAX FREELANCER_HIRE SAVE USER(FREELACER) START
    public function ajax_freelancer_save() {
        $userid = $this->session->userdata('aileenuser');

        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;


        $join_str[0]['table'] = 'freelancer_post_reg';
        $join_str[0]['join_table_id'] = 'freelancer_post_reg.user_id';
        $join_str[0]['from_table_id'] = 'save.to_id';
        $join_str[0]['join_type'] = '';

        $limit = $perpage;
        $offset = $start;

        $contition_array = array('save.status' => '0', 'freelancer_post_reg.is_delete' => '0', 'freelancer_post_reg.status' => '1', 'save.from_id' => $userid, 'save.save_type' => '2');
        $postdata = $this->common->select_data_by_condition('save', $contition_array, $data = 'freelancer_post_reg.freelancer_post_user_image, freelancer_post_reg.user_id, freelancer_post_reg.freelancer_post_fullname, freelancer_post_reg.freelancer_post_username, freelancer_post_reg.designation, freelancer_post_reg.freelancer_apply_slug,freelancer_post_reg.freelancer_post_area, freelancer_post_reg.freelancer_post_otherskill,freelancer_post_reg.freelancer_post_country, freelancer_post_reg.freelancer_post_city, freelancer_post_reg.freelancer_post_skill_description, freelancer_post_reg.freelancer_post_work_hour, freelancer_post_reg.freelancer_post_hourly, freelancer_post_reg.freelancer_post_ratestate, freelancer_post_reg.freelancer_post_fixed_rate, freelancer_post_reg.freelancer_post_exp_year, freelancer_post_reg.freelancer_post_exp_month,freelancer_post_reg.freelancer_post_field, save.save_id', $sortby = 'save_id', $orderby = 'desc', $limit, $offset, $join_str, $groupby = '');
        $postdata1 = $this->common->select_data_by_condition('save', $contition_array, $data = 'freelancer_post_reg.freelancer_post_user_image, freelancer_post_reg.user_id, freelancer_post_reg.freelancer_post_fullname, freelancer_post_reg.freelancer_post_username, freelancer_post_reg.designation,freelancer_post_reg.freelancer_apply_slug, freelancer_post_reg.freelancer_post_area, freelancer_post_reg.freelancer_post_otherskill,freelancer_post_reg.freelancer_post_country, freelancer_post_reg.freelancer_post_city, freelancer_post_reg.freelancer_post_skill_description, freelancer_post_reg.freelancer_post_work_hour, freelancer_post_reg.freelancer_post_hourly, freelancer_post_reg.freelancer_post_ratestate, freelancer_post_reg.freelancer_post_fixed_rate, freelancer_post_reg.freelancer_post_exp_year, freelancer_post_reg.freelancer_post_exp_month,freelancer_post_reg.freelancer_post_field, save.save_id', $sortby = 'save_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($postdata1);
        }
        $return_html = '';
        $return_html .= '<input type="hidden" class="page_number" value="' . $page . '" />';
        $return_html .= '<input type="hidden" class="total_record" value="' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';
        if (count($postdata1) > 0) {
            foreach ($postdata as $rec) {
                $return_html .= '<div class="job-contact-frnd">';
                $return_html .= '<div id="removeapply' . $rec['save_id'] . '">';
                $return_html .= '<div class="profile-job-post-detail clearfix">
                            <div class="profile-job-post-title-inside clearfix">
                                <div class="profile-job-profile-button clearfix">
                                    <div class="profile-job-post-location-name-rec">
                                        <div style="display: inline-block; float: left;">
                                            <div  class="buisness-profile-pic-candidate">';
                if ($rec['freelancer_post_user_image']) {
                    $return_html .= '<a href="' . base_url('freelancer/freelancer_post_profile/' . $rec['freelancer_apply_slug']) . '" title="' . ucwords($rec['freelancer_post_fullname']) . ' ' . ucwords($rec['freelancer_post_username']) . '">
                                                        <img src="' . FREE_POST_PROFILE_THUMB_UPLOAD_URL . $rec['freelancer_post_user_image'] . '" alt="' . ucwords($rec['freelancer_post_fullname']) . ' ' . ucwords($row['freelancer_post_username']) . '"></a>';
                } else {
                    $return_html .= '<a href="' . base_url('freelance-work/freelancer-details/' . $rec['freelancer_apply_slug']) . '" title="' . ucwords($rec['freelancer_post_fullname']) . ' ' . ucwords($rec['freelancer_post_username']) . '">';
                    $post_fname = $rec['freelancer_post_fullname'];
                    $post_lname = $rec['freelancer_post_username'];
                    $sub_post_fname = substr($post_fname, 0, 1);
                    $sub_post_lname = substr($post_lname, 0, 1);
                    $return_html .= '<div class = "post-img-div">';
                    $return_html .= ucfirst(strtolower($sub_post_fname)) . ucfirst(strtolower($sub_post_lname));
                    $return_html .= '</div> </a>';
                }
                $return_html .= '</div>
                                        </div>

                                        <div class="designation_rec" style="float: left;">
                                            <ul>
                                                <li>
                                                    <a  class="post_name" href="' . base_url('freelance-work/freelancer-details/' . $rec['freelancer_apply_slug']) . '" title="' . ucwords($rec['freelancer_post_fullname']) . ' ' . ucwords($rec['freelancer_post_username']) . '">
                                                        ' . ucwords($rec['freelancer_post_fullname']) . ' ' . ucwords($rec['freelancer_post_username']) . '</a></li>
                                                <li style="display: block;"> <a>';
                if ($rec['designation']) {
                    $return_html .= $rec['designation'];
                } else {
                    $return_html .= "Designation";
                }
                $return_html .= '</a> </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            <div class="profile-job-post-title clearfix">
                                <div class="profile-job-profile-menu">
                                    <ul class="clearfix">
                                    <li><b>';
                $return_html .= $this->lang->line("field");
                $return_html .= '</b><span>';
                if ($rec['freelancer_post_field']) {
                    $field_name = $this->db->select('category_name')->get_where('category', array('category_id' => $rec['freelancer_post_field']))->row()->category_name;
                    $return_html .= $field_name;
                } else {
                    $return_html .= PROFILENA;
                }

                $return_html .= '</li></span><li><b>';

                $return_html .= $this->lang->line("skill");
                $return_html .= '</b><span>';
                $comma = " , ";
                $k = 0;
                $aud = $rec['freelancer_post_area'];
                $aud_res = explode(',', $aud);
                if (!$rec['freelancer_post_area']) {
                    $return_html .= $rec['freelancer_post_otherskill'];
                } else if (!$rec['freelancer_post_otherskill']) {
                    foreach ($aud_res as $skill) {
                        if ($k != 0) {
                            $return_html .= $comma;
                        }
                        $cache_time = $this->db->select('skill')->get_where('skill', array('skill_id' => $skill))->row()->skill;
                        $return_html .= $cache_time;
                        $k++;
                    }
                } else if ($rec['freelancer_post_area'] && $rec['freelancer_post_otherskill']) {
                    foreach ($aud_res as $skill) {
                        if ($k != 0) {
                            $return_html .= $comma;
                        }
                        $cache_time = $this->db->select('skill')->get_where('skill', array('skill_id' => $skill))->row()->skill;
                        $return_html .= $cache_time;
                        $k++;
                    }
                    $return_html .= "," . $rec['freelancer_post_otherskill'];
                }
                $return_html .= ' </span>
                                        </li>';
                $cityname = $this->db->select('city_name')->get_where('cities', array('city_id' => $rec['freelancer_post_city']))->row()->city_name;
                $countryname = $this->db->select('country_name')->get_where('countries', array('country_id' => $rec['freelancer_post_country']))->row()->country_name;
                $return_html .= '<li><b>';
                $return_html .= $this->lang->line("location");
                $return_html .= '</b><span>';

                if ($cityname || $countryname) {
                    if ($cityname) {
                        $return_html .= $cityname . ",";
                    }
                    if ($countryname) {
                        $return_html .= $countryname;
                    }
                }
                $return_html .= '</span></li>
                                        <li><b>';
                $return_html .= $this->lang->line("skill_description");
                $return_html .= '</b><span><p>';
                if ($rec['freelancer_post_skill_description']) {
                    $return_html .= $rec['freelancer_post_skill_description'];
                } else {
                    $return_html .= PROFILENA;
                }
                $return_html .= '</p></span>
                                        </li>
                                        <li><b>';
                $return_html .= $this->lang->line("avaiability");
                $return_html .= '</b><span>';

                if ($rec['freelancer_post_work_hour']) {
                    $return_html .= $rec['freelancer_post_work_hour'] . "  " . "Hours per week ";
                } else {
                    $return_html .= PROFILENA;
                }
                $return_html .= '</span>
                                        </li>
                                        <li><b>';
                $return_html .= $this->lang->line("rate");
                $return_html .= '</b><span>';
                if ($rec['freelancer_post_hourly']) {
                    $currency = $this->db->select('currency_name')->get_where('currency', array('currency_id' => $rec['freelancer_post_ratestate']))->row()->currency_name;
                    if ($rec['freelancer_post_fixed_rate'] == '1') {
                        $rate_type = 'Fixed';
                    } else {
                        $rate_type = 'Hourly';
                    }
                    $return_html .= $rec['freelancer_post_hourly'] . "   " . $currency . "  " . $rate_type;
                } else {
                    $return_html .= PROFILENA;
                }
                $return_html .= '</span>
                                        </li>
                                        <li><b>';
                $return_html .= $this->lang->line("total_experiance");
                $return_html .= '</b><span>';
                if ($rec['freelancer_post_exp_year'] || $rec['freelancer_post_exp_month']) {
                    if ($rec['freelancer_post_exp_month'] == '12 month' && $rec['freelancer_post_exp_year'] == '') {
                        $return_html .= "1 year";
                    } elseif ($rec['freelancer_post_exp_month'] == '12 month' && $rec['freelancer_post_exp_year'] == '0 year') {
                        $return_html .= "1 year";
                    } elseif ($rec['freelancer_post_exp_month'] == '12 month' && $rec['freelancer_post_exp_year'] != '') {
                        $year = explode(' ', $rec['freelancer_post_exp_year']);
                        $totalyear = $year[0] + 1;
                        $return_html .= $totalyear . " year";
                    } elseif ($rec['freelancer_post_exp_year'] != '' && $rec['freelancer_post_exp_month'] == '') {
                        $return_html .= $rec['freelancer_post_exp_year'];
                    } elseif ($rec['freelancer_post_exp_year'] != '' && $rec['freelancer_post_exp_month'] == '0 month') {

                        $return_html .= $rec['freelancer_post_exp_year'];
                    } else {

                        $return_html .= $rec['freelancer_post_exp_year'] . ' ' . $rec['freelancer_post_exp_month'];
                    }
                } else {
                    $return_html .= PROFILENA;
                }
                $return_html .= '</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="profile-job-profile-button clearfix">
                                    <div class="apply-btn fr">';
                $userid = $this->session->userdata('aileenuser');
                if ($userid != $rec['user_id']) {
                    $return_html .= '<a title = "Message" href="' . base_url('chat/abc/3/4/' . $rec['user_id']) . '">';
                    $return_html .= $this->lang->line("message");
                    $return_html .= '</a>';
                    $return_html .= '<a title = "Remove" href="javascript:void(0);" class="button" onclick="removepopup(' . $rec['save_id'] . ')">';
                    $return_html .= $this->lang->line("remove");
                    $return_html .= '</a>';
                }
                $return_html .= '</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        } else {
            $return_html .= '<div class="art-img-nn">
                                                <div class="art_no_post_img">
                                                    <img alt="No Saved freelancer" src="../assets/img/free-no1.png">
                                                </div>
                                                <div class="art_no_post_text">';
            $return_html .= $this->lang->line("no_saved_freelancer");
            $return_html .= ' </div>
                                            </div>';
        }
        echo $return_html;
    }

//AJAX FREELANCER_HIRE SAVE USER(FREELACER) END
    //FREELANCER_HIRE PROFILE PIC INSERT START
    public function user_image_insert1() {
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid);
        $user_reg_data = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'freelancer_hire_user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $user_reg_prev_image = $user_reg_data[0]['freelancer_hire_user_image'];

        if ($user_reg_prev_image != '') {
            $user_image_main_path = $this->config->item('free_hire_profile_main_upload_path');
            $user_bg_full_image = $user_image_main_path . $user_reg_prev_image;
            if (isset($user_bg_full_image)) {
                unlink($user_bg_full_image);
            }

            $user_image_thumb_path = $this->config->item('free_hire_profile_thumb_upload_path');
            $user_bg_thumb_image = $user_image_thumb_path . $user_reg_prev_image;
            if (isset($user_bg_thumb_image)) {
                unlink($user_bg_thumb_image);
            }
        }


        $data = $_POST['image'];
        $data = str_replace('data:image/png;base64,', '', $data);
        $data = str_replace(' ', '+', $data);
        $user_bg_path = $this->config->item('free_hire_profile_main_upload_path');
        $imageName = time() . '.png';
        $data = base64_decode($data);
        $main_image = $user_bg_path . $imageName;
        $success = file_put_contents($main_image, $data);
        $main_image_size = filesize($main_image);

        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
        $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);

        $user_thumb_path = $this->config->item('free_hire_profile_thumb_upload_path');
        $user_thumb_width = $this->config->item('free_hire_profile_thumb_width');
        $user_thumb_height = $this->config->item('free_hire_profile_thumb_height');

        $upload_image = $user_bg_path . $imageName;

        $thumb_image = $user_thumb_path . $imageName;
        copy($main_image, $thumb_image);
        $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);

        $data = array(
            'freelancer_hire_user_image' => $imageName
        );

        $update = $this->common->update_data($data, 'freelancer_hire_reg', 'user_id', $userid);

        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            if (isset($upload_image)) {
                unlink($upload_image);
            }
            if (isset($thumb_image)) {
                unlink($thumb_image);
            }
        }

        if ($update) {

            $contition_array = array('user_id' => $userid, 'status' => '1', 'is_delete' => '0');
            $freelancerpostdata = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'freelancer_hire_user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
            $userimage .= '<img src="' . FREE_HIRE_PROFILE_MAIN_UPLOAD_URL . $freelancerpostdata[0]['freelancer_hire_user_image'] . '" alt="User Image" >';
            $userimage .= '<a title = "update profile pic" href="javascript:void(0);" onclick="updateprofilepopup();" class="cusome_upload"><img alt="Upload profile pic"  src="' . base_url('../assets/img/cam.png') . '">';
            $userimage .= $this->lang->line("update_profile_picture");
            $userimage .= '</a>';

            echo $userimage;
        } else {

            $this->session->flashdata('error', 'Your data not inserted');
            redirect('freelance-hire/projects', refresh);
        }
    }

//FREELANCER_HIRE PROFILE PIC INSERT END
    //FREELANCER_HIRE COVER PIC STRAT
    public function ajaxpro_hire() {
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid);
        $user_reg_data = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'profile_background,profile_background_main', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $user_reg_prev_image = $user_reg_data[0]['profile_background'];
        $user_reg_prev_main_image = $user_reg_data[0]['profile_background_main'];

        if ($user_reg_prev_image != '') {
            $user_image_main_path = $this->config->item('free_hire_bg_main_upload_path');
            $user_bg_full_image = $user_image_main_path . $user_reg_prev_image;
            if (isset($user_bg_full_image)) {
                unlink($user_bg_full_image);
            }

            $user_image_thumb_path = $this->config->item('free_hire_bg_thumb_upload_path');
            $user_bg_thumb_image = $user_image_thumb_path . $user_reg_prev_image;
            if (isset($user_bg_thumb_image)) {
                unlink($user_bg_thumb_image);
            }
        }
        if ($user_reg_prev_main_image != '') {
            $user_image_original_path = $this->config->item('free_hire_bg_original_upload_path');
            $user_bg_origin_image = $user_image_original_path . $user_reg_prev_main_image;
            if (isset($user_bg_origin_image)) {
                unlink($user_bg_origin_image);
            }
        }


        $data = $_POST['image'];
        $data = str_replace('data:image/png;base64,', '', $data);
        $data = str_replace(' ', '+', $data);

        $user_bg_path = $this->config->item('free_hire_bg_main_upload_path');
        $imageName = time() . '.png';
        $data = base64_decode($data);

        $file = $user_bg_path . $imageName;
        $success = file_put_contents($file, $data);

        $main_image = $user_bg_path . $imageName;
        $main_image_size = filesize($main_image);

        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
        $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);

        $user_thumb_path = $this->config->item('free_hire_bg_thumb_upload_path');
        $user_thumb_width = $this->config->item('free_hire_bg_thumb_width');
        $user_thumb_height = $this->config->item('free_hire_bg_thumb_height');

        $upload_image = $user_bg_path . $imageName;

        $thumb_image_uplode = $this->thumb_img_uplode($upload_image, $imageName, $user_thumb_path, $user_thumb_width, $user_thumb_height);

        $thumb_image = $user_thumb_path . $imageName;
        $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);

        $data = array(
            'profile_background' => $imageName
        );

        $update = $this->common->update_data($data, 'freelancer_hire_reg', 'user_id', $userid);

        if ($_server['HTTP_HOST'] != 'localhost') {
            if (isset($main_image)) {
                unlink($main_image);
            }
            if (isset($thumb_image)) {
                unlink($thumb_image);
            }
            if (isset($user_bg_origin_image)) {
                unlink($user_bg_origin_image);
            }
        }

        $this->data['jobdata'] = $this->common->select_data_by_id('freelancer_hire_reg', 'user_id', $userid, $data = 'profile_background', $join_str = array());
        $coverpic = '<img alt="User Image" id="image_src" name="image_src" src = "' . FREE_HIRE_BG_MAIN_UPLOAD_URL . $this->data['jobdata'][0]['profile_background'] . '" />';

        echo $coverpic;
    }

    public function image_hire() {

        $userid = $this->session->userdata('aileenuser');

        $config['upload_path'] = $this->config->item('free_hire_bg_original_upload_path');
        $config['allowed_types'] = $this->config->item('free_hire_bg_main_allowed_types');

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

        $updatedata = $this->common->update_data($data, 'freelancer_hire_reg', 'user_id', $userid);

        if ($updatedata) {
            echo $userid;
        } else {
            echo "welcome";
        }
    }

//FREELANCER_HIRE COVER PIC END
//FREELANCER_HIRE ADD POST(PROJECT) START
    public function freelancer_add_post() {
        if ($this->session->userdata('aileenuser')) {
            $userid = $this->session->userdata('aileenuser');
            //check user deactivate start
            $this->freelancer_hire_deactivate_check();
            //check user deactivate end
// code for display page start
            $this->freelancer_hire_check();
// code for display page end
            $contition_array = array('status' => '1');
            $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = '*', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            //for getting univesity data Start
            $contition_array = array('is_delete' => '0', 'category_name !=' => "Other");
            $search_condition = "((is_other = '2' AND user_id = $userid) OR (status = '1'))";
            $this->data['category_data'] = $this->common->select_data_by_search('category', $search_condition, $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('is_delete' => '0', 'status' => '1', 'category_name' => "Other");
            $this->data['category_otherdata'] = $this->common->select_data_by_condition('category', $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            //for getting univesity data End
            $contition_array = array('status' => '1');
            $this->data['currency'] = $this->common->select_data_by_condition('currency', $contition_array, $data = '*', $sortby = 'currency_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('is_delete' => '0', 'user_id' => $userid, 'status' => '1', 'free_hire_step' => '3');
            $data = 'username,fullname';
            $hire_data = $this->data['freelancr_user_data'] = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

            $this->data['title'] = 'Post Project | Employer Profile - Aileensoul';
            $this->load->view('freelancer/freelancer_hire/freelancer_add_post', $this->data);
        } else {

            $contition_array = array('status' => '1');
            $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = '*', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            //for getting univesity data Start
            $contition_array = array('is_delete' => '0', 'category_name !=' => "Other");
            $search_condition = "(status = '1')";
            $this->data['category_data'] = $this->common->select_data_by_search('category', $search_condition, $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('is_delete' => '0', 'status' => '1', 'category_name' => "Other");
            $this->data['category_otherdata'] = $this->common->select_data_by_condition('category', $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            //for getting univesity data End
            $contition_array = array('status' => '1');
            $this->data['currency'] = $this->common->select_data_by_condition('currency', $contition_array, $data = '*', $sortby = 'currency_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->data['title'] = 'Post Project | Employer Profile - Aileensoul';
            $this->load->view('freelancer/freelancer_hire/freelancer_add_post_live', $this->data);
        }
    }

//FREELANCER_HIRE ADD POST(PROJECT) END
    //FREELANCER_HIRE ADD POST(PROJECT) DATA INSERT START
    public function freelancer_add_post_insert() {
        $userid = $this->session->userdata('aileenuser');
        $skills = $this->input->post('skills');
        $skills = explode(',', $skills);

        $this->form_validation->set_rules('post_name', 'Project Title', 'required');
        $this->form_validation->set_rules('post_desc', 'Project description', 'required');
        $this->form_validation->set_rules('fields_req', 'Field ', 'required');
        $this->form_validation->set_rules('skills', 'Skill', 'required');
        // $this->form_validation->set_rules('latdate', 'Last date ', 'required');
//        $this->form_validation->set_rules('rate', 'Rate', 'required');
//        $this->form_validation->set_rules('currency', 'Currency', 'required');
        $this->form_validation->set_rules('rating', 'Work type', 'required');

        if ($this->form_validation->run() == FALSE) {

            $contition_array = array('status' => '1');
            $this->data['category'] = $this->common->select_data_by_condition('category', $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('status' => '1');
            $this->data['currency'] = $this->common->select_data_by_condition('currency', $contition_array, $data = '*', $sortby = 'currency_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('user_id' => $userid, 'status' => '1');
            $this->data['freelancerdata'] = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->load->view('freelancer/freelancer_hire/freelancer_add_post', $this->data);
        } else {
            $datereplace = $this->input->post('last_date');
            $lastdate = str_replace('/', '-', $datereplace);

            //skill code start
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
            //skill code end
            $post_name = trim($this->input->post('post_name'));
            $data = array(
                'post_name' => trim($this->input->post('post_name')),
                'post_description' => trim($this->input->post('post_desc')),
                'post_field_req' => trim($this->input->post('fields_req')),
                'post_skill' => $skills,
                'post_other_skill' => trim($this->input->post('other_skill')),
                'post_est_time' => trim($this->input->post('est_time')),
                'post_rate' => trim($this->input->post('rate')),
                'post_currency' => trim($this->input->post('currency')),
                'post_rating_type' => trim($this->input->post('rating')),
                'post_exp_month' => trim($this->input->post('month')),
                'post_exp_year' => trim($this->input->post('year')),
                'post_last_date' => $lastdate,
                'post_slug' => $this->common->clean($post_name),
                'user_id' => $userid,
                'created_date' => date('Y-m-d', time()),
                'status' => '1',
                'is_delete' => '0'
            );

            $insert_id = $this->common->insert_data_getid($data, 'freelancer_post');
            if ($insert_id) {
                redirect('freelance-hire/home', refresh);
            } else {
                $this->session->flashdata('error', 'Sorry!!Your data not inserted');
                redirect('freelance-hire/freelancer_add_post', refresh);
            }
        }
    }

//FREELANCER_HIRE ADD POST(PROJECT) DATA INSERT END
    //FREELANCER_HIRE EDIT POST(PROJECT) PAGE START
    public function freelancer_edit_post($id) {
        $userid = $this->session->userdata('aileenuser');
        //check user deactivate start
        $this->freelancer_hire_deactivate_check();
        //check user deactivate end
        // code for display page start
        $this->freelancer_hire_check();
        // code for display page end

        $contition_array = array('post_id' => $id, 'is_delete' => '0');
        $userdata = $this->data['freelancerpostdata'] = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //for getting univesity data Start
        $contition_array = array('is_delete' => '0', 'category_name !=' => "Other");
        $search_condition = "((is_other = '2' AND user_id = $userid) OR (status = '1'))";
        $this->data['category_data'] = $this->common->select_data_by_search('category', $search_condition, $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('is_delete' => '0', 'status' => '1', 'category_name' => "Other");
        $this->data['category_otherdata'] = $this->common->select_data_by_condition('category', $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //for getting univesity data End

        $contition_array = array('status' => '1', 'type' => '1');
        $this->data['skill1'] = $this->common->select_data_by_condition('skill', $contition_array, $data = '*', $sortby = 'skill', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('status' => '1');
        $this->data['currency'] = $this->common->select_data_by_condition('currency', $contition_array, $data = '*', $sortby = 'currency_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

//Retrieve skill data Start

        $skill_know = explode(',', $userdata[0]['post_skill']);
        foreach ($skill_know as $lan) {
            $contition_array = array('skill_id' => $lan, 'status' => '1');
            $languagedata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
            $detailes[] = $languagedata[0]['skill'];
        }

        $this->data['skill_2'] = implode(',', $detailes);
        //Retrieve skill data End
        $contition_array = array('is_delete' => '0', 'user_id' => $userid, 'status' => '1', 'free_hire_step' => '3');
        $data = 'username,fullname';
        $hire_data = $this->data['freelancr_user_data'] = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        $this->data['title'] = ucfirst($hire_data[0]['fullname']) . " " . ucfirst($hire_data[0]['username']) . TITLEPOSTFIX;

        $this->load->view('freelancer/freelancer_hire/freelancer_edit_post', $this->data);
    }

//FREELANCER_HIRE EDIT POST(PROJECT) PAGE END
//FREELANCER_HIRE EDIT POST(PROJECT) PAGE DATA INSERT START
    public function freelancer_edit_post_insert($id) {

        $userid = $this->session->userdata('aileenuser');
        $skills = $this->input->post('skills');
        $skills = explode(',', $skills);

        $this->form_validation->set_rules('post_name', 'Project Title', 'required');
        $this->form_validation->set_rules('post_desc', 'Project description', 'required');
        $this->form_validation->set_rules('fields_req', 'Field ', 'required');
        $this->form_validation->set_rules('skills', 'Skill', 'required');
       // $this->form_validation->set_rules('latdate', 'Last date ', 'required');
       // $this->form_validation->set_rules('rate', 'Rate', 'required');
        //$this->form_validation->set_rules('currency', 'Currency', 'required');
        $this->form_validation->set_rules('rating', 'Work type', 'required');


        if ($this->form_validation->run() == FALSE) {

            $contition_array = array('post_id' => $id, 'is_delete' => '0');
            $userdata = $this->data['freelancerpostdata'] = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            //for getting univesity data Start
            $contition_array = array('is_delete' => '0', 'category_name !=' => "Other");
            $search_condition = "((is_other = '2' AND user_id = $userid) OR (status = '1'))";
            $this->data['category_data'] = $this->common->select_data_by_search('category', $search_condition, $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('is_delete' => '0', 'status' => '1', 'category_name' => "Other");
            $this->data['category_otherdata'] = $this->common->select_data_by_condition('category', $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            //for getting univesity data End

            $contition_array = array('status' => '1', 'type' => '1');
            $this->data['skill1'] = $this->common->select_data_by_condition('skill', $contition_array, $data = '*', $sortby = 'skill', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('status' => '1');
            $this->data['currency'] = $this->common->select_data_by_condition('currency', $contition_array, $data = '*', $sortby = 'currency_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

//Retrieve skill data Start

            $skill_know = explode(',', $userdata[0]['post_skill']);
            foreach ($skill_know as $lan) {
                $contition_array = array('skill_id' => $lan, 'status' => '1');
                $languagedata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                $detailes[] = $languagedata[0]['skill'];
            }

            $this->data['skill_2'] = implode(',', $detailes);
            //Retrieve skill data End
            $contition_array = array('is_delete' => '0', 'user_id' => $userid, 'status' => '1', 'free_hire_step' => '3');
            $data = 'username,fullname';
            $hire_data = $this->data['freelancr_user_data'] = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

            $this->load->view('freelancer/freelancer_hire/freelancer_edit_post', $this->data);
        } else {

            $datereplace = $this->input->post('last_date');
            $lastdate = str_replace('/', '-', $datereplace);
            // skills  start   
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
            $post_name = trim($this->input->post('post_name'));
            $data = array(
                'post_name' => trim($this->input->post('post_name')),
                'post_description' => trim($this->input->post('post_desc')),
                'post_field_req' => trim($this->input->post('fields_req')),
                'post_skill' => $skills,
                'post_other_skill' => trim($this->input->post('other_skill')),
                'post_est_time' => trim($this->input->post('est_time')),
                'post_rate' => trim($this->input->post('rate')),
                'post_currency' => trim($this->input->post('currency')),
                'post_rating_type' => trim($this->input->post('rating')),
                'post_exp_month' => trim($this->input->post('month')),
                'post_exp_year' => trim($this->input->post('year')),
                'post_last_date' => $lastdate,
                'post_slug' => $this->common->clean($post_name),
                'modify_date' => date('Y-m-d', time()),
            );

            $updatdata = $this->common->update_data($data, 'freelancer_post', 'post_id', $id);
            if ($updatdata) {
                redirect('freelance-hire/projects', refresh);
            } else {
                $this->session->flashdata('error', 'Sorry!!Your data not inserted');
                redirect('freelancer/freelancer_edit_post', refresh);
            }
        }
    }

//FREELANCER_HIRE EDIT POST(PROJECT) PAGE DATA INSERT END
    //FREELANCER_HIRE DEACTIVATE START
    public function deactivate_hire() {
        $id = $_POST['id'];
        $data = array(
            'status' => '0'
        );
        $update = $this->common->update_data($data, 'freelancer_hire_reg', 'user_id', $id);
        $update = $this->common->update_data($data, 'freelancer_post', 'user_id', $id);
    }

//FREELANCER_HIRE DEACTIVATE END
    //FREELANCER_HIRE APPLIED POERSON LIST START
    public function freelancer_apply_list($id) {
        $userid = $this->session->userdata('aileenuser');
//check user deactivate start
        $this->freelancer_hire_deactivate_check();
        //check user deactivate end
// code for display page start
        $this->freelancer_hire_check();
        // code for display page end

        $contition_array = array('is_delete' => '0', 'user_id' => $userid, 'status' => '1', 'free_hire_step' => '3');
        $data = 'username,fullname';
        $hire_data = $this->data['freelancr_user_data'] = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

        $this->data['postid'] = $id;
        $join_str[0]['table'] = 'freelancer_apply';
        $join_str[0]['join_table_id'] = 'freelancer_apply.user_id';
        $join_str[0]['from_table_id'] = 'freelancer_post_reg.user_id';
        $join_str[0]['join_type'] = '';
        $contition_array = array('freelancer_apply.post_id' => $id, 'freelancer_apply.is_delete' => '0', 'freelancer_post_reg.status' => '1');
        $data = 'freelancer_post_reg.user_id, freelancer_post_reg.freelancer_apply_slug, freelancer_post_reg.freelancer_post_fullname, freelancer_post_reg.freelancer_post_username, freelancer_post_reg.designation, freelancer_post_reg.freelancer_post_area, freelancer_post_reg.freelancer_post_otherskill,freelancer_post_reg.freelancer_post_country, freelancer_post_reg.freelancer_post_city, freelancer_post_reg.freelancer_post_skill_description, freelancer_post_reg.freelancer_post_work_hour, freelancer_post_reg.freelancer_post_hourly, freelancer_post_reg.freelancer_post_ratestate, freelancer_post_reg.freelancer_post_fixed_rate, freelancer_post_reg.freelancer_post_exp_year, freelancer_post_reg.freelancer_post_exp_month, freelancer_post_reg.freelancer_post_user_image';
        $postdata = $this->data['postdata'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data, $sortby = 'freelancer_apply.modify_date', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

        $this->data['title'] = ucfirst($hire_data[0]['fullname']) . " " . ucfirst($hire_data[0]['username']) . " | Applied Freelancers | Employer Profile" . TITLEPOSTFIX;
        $this->load->view('freelancer/freelancer_hire/freelancer_apply_list', $this->data);
    }

//FREELANCER_HIRE APPLIED POERSON LIST END
    //FREELANCER HIRE POST LIVE LINK START
    public function live_post($userid = '', $postid = '', $posttitle = '') {
        $segment3 = explode('-', $this->uri->segment(3));

        $slugdata = array_reverse($segment3);
        $postid = $slugdata[0];
        $this->data['recliveid'] = $userid = $slugdata[1];
        $this->data['postid'] = $postid;

        $contition_array = array('is_delete' => '0', 'user_id' => $userid, 'status' => '1', 'free_hire_step' => '3');
        $data = 'username,fullname,designation,freelancer_hire_user_image,user_id,profile_background';
        $hire_data = $this->data['freelancr_user_data'] = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

        $join_str[0]['table'] = 'freelancer_hire_reg';
        $join_str[0]['join_table_id'] = 'freelancer_hire_reg.user_id';
        $join_str[0]['from_table_id'] = 'freelancer_post.user_id';
        $join_str[0]['join_type'] = '';

        $contition_array = array('post_id' => $postid, 'freelancer_post.is_delete' => '0', 'freelancer_hire_reg.user_id' => $userid, 'freelancer_hire_reg.status' => '1', 'freelancer_hire_reg.free_hire_step' => '3');
        $data = 'freelancer_post.post_id,freelancer_post.post_name,freelancer_post.post_field_req,freelancer_post.post_est_time,freelancer_post.post_skill,freelancer_post.post_other_skill,freelancer_post.post_rate,freelancer_post.post_last_date,freelancer_post.post_description,freelancer_post.user_id,freelancer_post.created_date,freelancer_post.post_currency,freelancer_post.post_rating_type,freelancer_post.post_exp_month,freelancer_post.post_exp_year,freelancer_hire_reg.username,freelancer_hire_reg.fullname,freelancer_hire_reg.designation,freelancer_hire_reg.freelancer_hire_user_image,freelancer_hire_reg.country,freelancer_hire_reg.city';
        $this->data['postdata'] = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data, $sortby = 'freelancer_post.post_id', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');


        $city = $this->db->select('city')->get_where('freelancer_hire_reg', array('user_id' => $userid))->row()->city;
        $cityname = $this->db->select('city_name')->get_where('cities', array('city_id' => $city))->row()->city_name;

        $cache_time1 = $this->data['postdata'][0]['post_name'];
        if ($cache_time1 != '') {
            $text = strtolower($this->common->clean($cache_time1));
        } else {
            $text = '';
        }

        if ($cityname != '') {
            $cityname1 = '-vacancy-in-' . strtolower($this->common->clean($cityname));
        } else {
            $cityname1 = '';
        }

        $postname = $text . $cityname1;
        $segment3 = array_splice($segment3, 0, -2);
        $original = implode('-', $segment3);
        $url = $postname . '-' . $userid . '-' . $postid;




        $contition_array = array('post_id !=' => $postid, 'freelancer_post.is_delete' => '0', 'freelancer_hire_reg.user_id' => $userid, 'freelancer_hire_reg.status' => '1', 'freelancer_hire_reg.free_hire_step' => '3', 'freelancer_post.post_name' => $this->data['postdata'][0]['post_name']);
        $this->data['recommandedpost'] = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');


        $join_str = array(array(
                'join_type' => '',
                'table' => 'freelancer_apply',
                'join_table_id' => 'freelancer_post_reg.user_id',
                'from_table_id' => 'freelancer_apply.user_id'),
            array(
                'join_type' => '',
                'table' => 'save',
                'join_table_id' => 'freelancer_post_reg.user_id',
                'from_table_id' => 'save.to_id')
        );

        $contition_array = array('freelancer_apply.post_id' => $postid, 'freelancer_apply.is_delete' => '0', 'save.from_id' => $userid, 'save.save_type' => '2', 'save.status' => '2');
        $data = 'freelancer_post_reg.user_id, freelancer_post_reg.freelancer_apply_slug, freelancer_post_reg.freelancer_post_fullname, freelancer_post_reg.freelancer_post_username, freelancer_post_reg.designation,freelancer_post_reg.freelancer_post_user_image,freelancer_post_reg.freelancer_apply_slug';
        $shortlist = $this->data['shortlist'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data, $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

        $segment3 = explode('-', $this->uri->segment(3));
        $segment3 = array_splice($segment3, 0, -2);
        $segment3 = implode(' ', $segment3);
        $segment3 = ucfirst($segment3);

        $this->data['title'] = $segment3 . TITLEPOSTFIX;

        if ($this->session->userdata('aileenuser')) {
            $this->load->view('freelancer/freelancer_post/hire_project', $this->data);
        } else {
            if ($postname == $original) {
                $this->load->view('freelancer/freelancer_post/hire_project_live', $this->data);
            } else {
                if ($this->data['postdata']) {
                    redirect('freelance-hire/project/' . $url, refresh);
                } else {
                    $this->data['title'] = 'Content Not Avaible - Aileensoul';
                    $this->load->view('freelancer/freelancer_post/hire_project_live', $this->data);
                }
            }
        }
    }

//FREELANCER HIRE POST LIVE LINK END
    // FREELANCER HIRE SHORTLISTED CANDIDATE PAGE START
    public function freelancer_shortlist_list($post_id = '') {

        $userid = $this->session->userdata('aileenuser');
//check user deactivate start
        $this->freelancer_hire_deactivate_check();
        //check user deactivate end
// code for display page start
        $this->freelancer_hire_check();
        // code for display page end
        $contition_array = array('is_delete' => '0', 'user_id' => $userid, 'status' => '1', 'free_hire_step' => '3');
        $data = 'username,fullname';
        $hire_data = $this->data['freelancr_user_data'] = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        $join_str = array(array(
                'join_type' => '',
                'table' => 'freelancer_apply',
                'join_table_id' => 'freelancer_post_reg.user_id',
                'from_table_id' => 'freelancer_apply.user_id'),
            array(
                'join_type' => '',
                'table' => 'save',
                'join_table_id' => 'freelancer_post_reg.user_id',
                'from_table_id' => 'save.to_id')
        );
        $this->data['postid'] = $post_id;
        $contition_array = array('freelancer_apply.post_id' => $post_id, 'freelancer_apply.is_delete' => '0', 'save.from_id' => $userid, 'save.save_type' => '2', 'save.status' => '2', 'freelancer_post_reg.status' => '1');
        $data = 'freelancer_post_reg.user_id, freelancer_post_reg.freelancer_apply_slug, freelancer_post_reg.freelancer_post_fullname, freelancer_post_reg.freelancer_post_username, freelancer_post_reg.designation, freelancer_post_reg.freelancer_post_area, freelancer_post_reg.freelancer_post_otherskill, freelancer_post_reg.freelancer_post_city, freelancer_post_reg.freelancer_post_skill_description, freelancer_post_reg.freelancer_post_work_hour, freelancer_post_reg.freelancer_post_hourly, freelancer_post_reg.freelancer_post_ratestate, freelancer_post_reg.freelancer_post_fixed_rate, freelancer_post_reg.freelancer_post_exp_year, freelancer_post_reg.freelancer_post_exp_month, freelancer_post_reg.freelancer_post_user_image';
        $shortlist = $this->data['shortlist'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data, $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

        $this->data['title'] = ucfirst($hire_data[0]['fullname']) . " " . ucfirst($hire_data[0]['username']) . " | Shortlisted Freelancers | Employer Profile" . TITLEPOSTFIX;
        $this->load->view('freelancer/freelancer_hire/freelancer_shortlist', $this->data);
    }

    // FREELANCER HIRE SHORTLISTED CANDIDATE PAGE END
    public function add_post_added() {
        $userid = $this->session->userdata('aileenuser');

        $postname = $this->input->post('post_name');
        $post_desc = $this->input->post('post_desc');
        $skills = $this->input->post('skill');
        $field = $this->input->post('field');
        $year = $this->input->post('year');
        $month = $this->input->post('month');
        $est_time = $this->input->post('est_time');
        $last_date = $this->input->post('last_date');
        $rate = $this->input->post('rate');
        $currency = $this->input->post('currency');
        $worktype = $this->input->post('Worktype');

        $skills = explode(',', $skills);
        //skill code start
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
        //skill code end

        $data = array(
            'post_name' => trim($postname),
            'post_description' => trim($post_desc),
            'post_field_req' => trim($field),
            'post_skill' => $skills,
            'post_est_time' => trim($est_time),
            'post_rate' => trim($rate),
            'post_currency' => trim($currency),
            'post_rating_type' => trim($worktype),
            'post_exp_month' => trim($month),
            'post_exp_year' => trim($year),
            'post_last_date' => $last_date,
            'user_id' => $userid,
            'created_date' => date('Y-m-d', time()),
            'status' => '1',
            'is_delete' => '0'
        );
        $insert_id = $this->common->insert_data_getid($data, 'freelancer_post_live');
        $data = "ok";
        echo json_encode(
                array(
                    "data" => $data,
        ));
    }

    public function add_project_login() {
        $userid = $this->session->userdata('aileenuser');
        $postname = $this->input->post('post_name');
        $post_desc = $this->input->post('post_desc');
        $skills = $this->input->post('skill');
        $field = $this->input->post('field');
        $year = $this->input->post('year');
        $month = $this->input->post('month');
        $est_time = $this->input->post('est_time');
        $last_date = $this->input->post('last_date');
        $rate = $this->input->post('rate');
        $currency = $this->input->post('currency');
        $worktype = $this->input->post('Worktype');

        $skills = explode(',', $skills);
        //skill code start
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
        //skill code end

        $data = array(
            'post_name' => trim($postname),
            'post_description' => trim($post_desc),
            'post_field_req' => trim($field),
            'post_skill' => $skills,
            'post_est_time' => trim($est_time),
            'post_rate' => trim($rate),
            'post_currency' => trim($currency),
            'post_rating_type' => trim($worktype),
            'post_exp_month' => trim($month),
            'post_exp_year' => trim($year),
            'post_last_date' => $last_date,
            'post_slug' => trim($postname),
            'user_id' => $userid,
            'created_date' => date('Y-m-d', time()),
            'status' => '1',
            'is_delete' => '0'
        );

        $insert_id = $this->common->insert_data_getid($data, 'freelancer_post');

        if ($insert_id) {
            $data = "ok";
            echo json_encode(
                    array(
                        "data" => $data,
                        "id" => $userid,
            ));
        } else {
            $data = "notok";

            echo json_encode(
                    array(
                        "data" => $data,
                        "id" => $userid,
            ));
        }
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

    public function other_filed_live() {
        $other_field = $_POST['other_field'];
        $contition_array = array('is_delete' => '0', 'category_name' => $other_field);
        $search_condition = "(status = '1')";
        $userdata = $this->data['userdata'] = $this->common->select_data_by_search('category', $search_condition, $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $count = count($userdata);

        if ($other_field != NULL) {
            if ($count == 0) {

                $contition_array = array('is_delete' => '0', 'category_name !=' => "Other");
                $search_condition = "(status = '1')";
                $category = $this->data['category'] = $this->common->select_data_by_search('category', $search_condition, $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if (count($category) > 0) {
                    $select = '<option value="" selected option disabled>Select your field</option>';
                    foreach ($category as $st) {
                        $select .= '<option value="' . $st['category_id'] . '"';
//                            if ($st['category_name'] == $other_field) {
//                                $select .= 'selected';
//                            }
                        $select .= '>' . $st['category_name'] . '</option>';
                    }
                }
//For Getting Other at end
                $select .= '<option value="' . $other_field . '" selected>' . $other_field . '</option>';
                $contition_array = array('is_delete' => '0', 'status' => '1', 'category_name' => "Other");
                $category_otherdata = $this->common->select_data_by_condition('category', $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                $select .= '<option value="' . $category_otherdata[0]['category_id'] . '">' . $category_otherdata[0]['category_name'] . '</option>';
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

    //FREELANCER_HIRE  OTHER FIELD START
    public function freelancer_hire_other_field() {

        $other_field = $_POST['other_field'];

        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        $contition_array = array('is_delete' => '0', 'category_name' => $other_field);
        $search_condition = "((is_other = '2' AND user_id = $userid) OR (status = '1'))";
        $userdata = $this->data['userdata'] = $this->common->select_data_by_search('category', $search_condition, $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $count = count($userdata);

        if ($other_field != NULL) {
            if ($count == 0) {
                $data = array(
                    'category_name' => $other_field,
                    'created_date' => date('Y-m-d h:i:s', time()),
                    'status' => '2',
                    'is_delete' => '0',
                    'is_other' => '2',
                    'user_id' => $userid,
                    'category_slug' => $this->common->clean($other_field)
                );
                $insert_id = $this->common->insert_data_getid($data, 'category');
                if ($insert_id) {
                    $contition_array = array('is_delete' => '0', 'category_name !=' => "Other");
                    $search_condition = "((is_other = '2' AND user_id = $userid) OR (status = '1'))";
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

//FREELANCER_HIRE BOTH OTHER END
    //FREELANCER HIRE SAVE FOR SHORTLISTED CANDIDATE START
    public function shortlist_user($post_id = '', $saveuserid = '') {
        $post_id = $_POST['post_id'];
        $saveuser_id = $_POST['user_id'];
        $word = 'Shortlisted';
        $userid = $this->session->userdata('aileenuser');
        //this condition for prevent dublicate entry of save
        $contition_array = array('from_id' => $userid, 'to_id' => $saveuser_id, 'save_type' => '2');
        $usershortlist = $this->common->select_data_by_condition('save', $contition_array, $data = 'save_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $save_id = $usershortlist[0]['save_id'];
        if ($usershortlist) {

            $data = array(
                'status' => '2',
                'post_id' => $post_id,
                'modify_date' => date('Y-m-d', time())
            );

            $updatedata = $this->common->update_data($data, 'save', 'save_id', $save_id);
            $data = array(
                'not_type' => '9',
                'not_from_id' => $userid,
                'not_to_id' => $saveuser_id,
                'not_read' => '2',
                'not_from' => '5',
                'not_product_id' => $save_id,
                "not_active" => '1',
                'not_created_date' => date('Y-m-d H:i:s')
            );
            $insertnotification = $this->common->insert_data_getid($data, 'notification');



            if ($updatedata) {
                $this->selectemail_user($saveuser_id, $post_id, $word);
                $saveuser = 'shortlisted';
                // GET NOTIFICATION COUNT
                $not_count = $this->freelancer_notification_count($saveuser_id);

                echo json_encode(
                        array(
                            "status" => 'shortlisted',
                            "notification" => array('notification_count' => $not_count, 'to_id' => $saveuser_id),
                ));
            }
        } else {
            $data = array(
                'from_id' => $userid,
                'to_id' => $saveuser_id,
                'status' => '2',
                'save_type' => '2',
                'post_id' => $post_id,
                'created_date' => date('Y-m-d', time())
            );
            $insert_id = $this->common->insert_data($data, 'save');

            $contition_array = array('from_id' => $userid, 'to_id' => $saveuser_id, 'save_type' => '2');
            $usersave = $this->common->select_data_by_condition('save', $contition_array, $data = 'save_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $save_id = $usersave[0]['save_id'];

            $data = array(
                'not_type' => '9',
                'not_from_id' => $userid,
                'not_to_id' => $saveuser_id,
                'not_read' => '2',
                'not_from' => '5',
                'not_product_id' => $save_id,
                "not_active" => '1',
                'not_created_date' => date('Y-m-d H:i:s')
            );
            $insertnotification = $this->common->insert_data_getid($data, 'notification');

            if ($insert_id) {
                $this->selectemail_user($saveuser_id, $post_id, $word);
                $saveuser = 'shortlisted';
                // GET NOTIFICATION COUNT
                $not_count = $this->freelancer_notification_count($saveuser_id);

                echo json_encode(
                        array(
                            "status" => 'shortlisted',
                            "notification" => array('notification_count' => $not_count, 'to_id' => $saveuser_id),
                ));
            }
        }
    }

//FREELANCER HIRE SAVE FOR SHORTLISTED CANDIDATE END
    //FREELANCER_HIRE SEARCH KEYWORD FOR AUTO COMPLETE START
    public function freelancer_hire_search_keyword($id = "") {

        $searchTerm = $_GET['term'];
        if (!empty($searchTerm)) {
            $contition_array = array('status' => '1', 'is_delete' => '0');
            $search_condition = "(category_name LIKE '" . trim($searchTerm) . "%')";
            $field = $this->common->select_data_by_search('category', $search_condition, $contition_array, $data = 'category_name', $sortby = 'category_name', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = 'category_name');

            $contition_array = array('status' => '1', 'is_delete' => '0', 'free_post_step' => '7');
            $search_condition = "(designation LIKE '" . trim($searchTerm) . "%')";
            $freelancer_postdata = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'designation', $sortby = 'designation', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = 'designation');

            $contition_array = array('status' => '1', 'type' => '1');
            $search_condition = "(skill LIKE '" . trim($searchTerm) . "%')";
            $skill = $this->common->select_data_by_search('skill', $search_condition, $contition_array, $data = 'skill', $sortby = 'skill', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = 'skill');
        }
        $unique = array_merge((array) $field, (array) $skill, (array) $freelancer_postdata);
        foreach ($unique as $key => $value) {
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

//FREELANCER_HIRE SEARCH KEYWORD FOR AUTO COMPLETE END
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
    //FREELANCER_HIRE DESIGNATION START
    public function hire_designation() {

        $userid = $this->session->userdata('aileenuser');


        $data = array(
            'designation' => trim($this->input->post('designation')),
            'modified_date' => date('Y-m-d', time())
        );
        $updatdata = $this->common->update_data($data, 'freelancer_hire_reg', 'user_id', $userid);
    }

//FREELANCER_HIRE DESIGNATION END
    //FREELANCER_HIRE REMOVE POST(PROJECT) STRAT
    public function remove_post() {
        $postid = $_POST['post_id'];
        $data = array(
            'is_delete' => '1',
            'modify_date' => date('y-m-d h:i:s')
        );

        $updatedata = $this->common->update_data($data, 'freelancer_post', 'post_id', $postid);
    }

//FREELANCER_HIRE REMOVE POST(PROJECT) END
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

    public function save_user1($id, $save_id) {
        $id = $_POST['user_id'];
        $save_id = $_POST['save_id'];

        $userid = $this->session->userdata('aileenuser');

        //this condition for prevent dublicate entry of save
        $contition_array = array('from_id' => $userid, 'to_id' => $id, 'status' => '0', 'save_type' => '2');
        $usersearchdata = $this->common->select_data_by_condition('save', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if ($usersearchdata) {
            $saveuser = 'Saved';
            echo $saveuser;
        } else {
            $contition_array = array('from_id' => $userid, 'to_id' => $id, 'save_id' => $save_id);
            $userdata = $this->common->select_data_by_condition('save', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($userdata) {
                $data = array(
                    'status' => 0
                );

                $updatedata = $this->common->update_data($data, 'save', 'save_id', $save_id);
                if ($updatedata) {
                    $saveuser = 'Saved';
                    echo $saveuser;
                }
            } else {
                $data = array(
                    'from_id' => $userid,
                    'to_id' => $id,
                    'status' => '0',
                    'save_type' => '2'
                );

                $insert_id = $this->common->insert_data($data, 'save');
                if ($insert_id) {
                    $saveuser = 'Saved';
                    echo $saveuser;
                }
            }
        }
    }

    //FREELANCER_HIRE REMOVE SAVED FREELANCER START
    public function remove_save() {
        $saveid = $_POST['save_id'];

        $userid = $this->session->userdata('aileenuser');
        $data = array(
            'status' => '1'
        );
        $updatedata = $this->common->update_data($data, 'save', 'save_id', $saveid);
    }

//FREELANCER_HIRE REMOVE SAVED FREELANCER END
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
        if ($this->data['freehiredata']['freelancer_hire_user_image']) {
            $email_html .= '<img alt="User Image" src="' . FREE_HIRE_PROFILE_THUMB_UPLOAD_URL . $this->data['freehiredata'][0]['freelancer_hire_user_image'] . '" width="60" height="60"></td>';
        } else {
            $fname = $this->data['freehiredata']['fullname'];
            $lname = $this->data['freehiredata']['username'];
            $sub_fname = substr($fname, 0, 1);
            $sub_lname = substr($lname, 0, 1);
            $email_html .= '<div class="post-img-div">
                          ' . ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)) . '</div> </td>';
        }
        $email_html .= '<td style="padding:5px;">
						<p>Employer <b>' . $this->data['freehiredata']['fullname'] . " " . $this->data['freehiredata']['username'] . " " . $writting_word . '</b> you for ' . $projectdata[0]["post_name"] . ' project in freelancer profile.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a title= "View Detail" class="btn" href="' . BASEURL . 'notification/freelance-hire/' . $postid . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
        $subject = $this->data['freehiredata']['fullname'] . " " . $this->data['freehiredata']['username'] . " " . $writting_word . ' you for ' . $projectdata[0]["post_name"] . ' project in Aileensoul.';

        $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $applydata[0]['freelancer_post_email']);
        $email_html = '';
        $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;">';
        if ($this->data['freehiredata'][0]['freelancer_hire_user_image']) {
            $email_html .= '<img alt = "User Image" src="' . FREE_HIRE_PROFILE_THUMB_UPLOAD_URL . $this->data['freehiredata'][0]['freelancer_hire_user_image'] . '" width="60" height="60"></td>';
        } else {
            $fname = $this->data['freehiredata']['fullname'];
            $lname = $this->data['freehiredata']['username'];
            $sub_fname = substr($fname, 0, 1);
            $sub_lname = substr($lname, 0, 1);
            $email_html .= '<div class="post-img-div">
                          ' . ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)) . '</div> </td>';
        }
        $email_html .= '<td style="padding:5px;">
						<p>Employer <b>' . $this->data['freehiredata']['fullname'] . " " . $this->data['freehiredata']['username'] . " " . $writting_word . '</b>  you for ' . $projectdata[0]["post_name"] . ' project in freelancer profile.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a title = "View Detail" class="btn" href="' . BASEURL . 'notification/freelance-hire/' . $postid . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
        $subject = $this->data['freehiredata']['fullname'] . " " . $this->data['freehiredata']['username'] . " " . $writting_word . ' you for ' . $projectdata[0]["post_name"] . ' project in Aileensoul.';

        $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $applydata[0]['freelancer_post_email']);
    }

}
