<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Artistic extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->model('email_model');
        $this->data['title'] = "Aileensoul";
        
         $this->load->helper('smiley');
          $this->data['login_header'] = $this->load->view('login_header', $this->data,TRUE);
        $this->load->library('S3');

        // $this->load->library('minify');
        // $this->load->helper('url');

        // if (!$this->session->userdata('aileenuser')) {
        //     redirect('login', 'refresh');
        // }

       //This function is there only one time users slug created after remove it start
        // $this->db->select('art_id,art_name,art_lastname');
        // $res = $this->db->get('art_reg')->result();
        // foreach ($res as $k => $v) {
        //     $data = array('slug' => $this->setcategory_slug($v->art_name."-". $v->art_lastname, 'slug', 'art_reg'));
        //     $this->db->where('art_id', $v->art_id);
        //     $this->db->update('art_reg', $data);
        //  }
        //This function is there only one time users slug created after remove it End

        include ('include.php');
    }

    public function index() {
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'status' => '0');
        $artdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if ($artdata) {

            $this->load->view('artistic/reactivate', $this->data);
        } else {

            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $artdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $this->data['art'] = $this->common->select_data_by_condition('user', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            if (count($artdata) > 0) {

                if ($artdata[0]['art_step'] == 1) {
                    redirect('artistic/artistic-address', refresh);
                } else if ($artdata[0]['art_step'] == 2) {
                    redirect('artistic/artistic-information', refresh);
                } else if ($artdata[0]['art_step'] == 3) { //echo "123"; die();
                    redirect('artistic/artistic-portfolio', refresh);
                } else if ($artdata[0]['art_step'] == 4) {
                    redirect('artistic/home', refresh);
                }
            } else {
                $this->load->view('artistic/art_basic_information', $this->data);
            }
        }
    }

    public function comment() {
        $this->load->view('artistic/comment');
    }

    public function abc() {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $contition_array = array('status' => '1', 'type' => '2');
        $this->data['skill'] = $this->common->select_data_by_condition('skill', $contition_array, $data = '*', $sortby = 'skill', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        $contition_array = array('status' => '1', 'user_id' => $userid);
        $this->data['artistic'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $skildata = explode(',', $this->data['artistic'][0]['art_skill']);
        $this->data['selectdata'] = $skildata;
        $this->load->view('artistic/abc', $this->data);
    }


    // ARTISTICS PROFILE SLUG START

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

// ARTISTICS PROFILE SLUG END

    public function art_basic_information_update() {
        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userdata) {
            $step = $userdata[0]['art_step'];

            if ($step == 1 || $step > 1) {
                $this->data['firstname1'] = $userdata[0]['art_name'];
                $this->data['lastname1'] = $userdata[0]['art_lastname'];
                $this->data['email1'] = strtolower($userdata[0]['art_email']);
                $this->data['phoneno1'] = $userdata[0]['art_phnno'];
            }
        }

        $this->data['title'] = 'Artistic Profile'.TITLEPOSTFIX;
        $this->load->view('artistic/art_basic_information', $this->data);
    }

    public function art_basic_information_insert() { 

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End


        $this->form_validation->set_rules('firstname', 'Please Enter Your Name', 'required');

        $this->form_validation->set_rules('email', 'Please Enter Your EmailId', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('artistic/art_basic_information');
        }


        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        if ($userdata) {
            $data = array(
                'art_name' => strtolower($this->input->post('firstname')),
                'art_lastname' => strtolower($this->input->post('lastname')),
                'art_email' => $this->input->post('email'),
                'art_phnno' => $this->input->post('phoneno'),
                'modified_date' => date('Y-m-d', time()),
                'slug' => $this->setcategory_slug($this->input->post('firstname') . '-' . $this->input->post('lastname'), 'slug', 'art_reg')
            );

            $updatdata = $this->common->update_data($data, 'art_reg', 'user_id', $userid);

            if ($updatdata) {
                $this->session->set_flashdata('success', 'Basic Information updated successfully');
                redirect('artistic/art_address', refresh);
            } else {
                $this->session->flashdata('error', 'Sorry!! Your data not inserted');
                redirect('artistic/art_basic_information_insert', refresh);
            }
        } else {
            $data = array(
                'art_name' => strtolower($this->input->post('firstname')),
                'art_lastname' => strtolower($this->input->post('lastname')),
                'art_email' => $this->input->post('email'),
                'art_phnno' => $this->input->post('phoneno'),
                'user_id' => $userid,
                'created_date' => date('Y-m-d H:i:s', time()),
                'status' => 1,
                'is_delete' => 0,
                'art_step' => 1,
                'slug' => $this->setcategory_slug($this->input->post('firstname') . '-' . $this->input->post('lastname'), 'slug', 'art_reg')
            );



            $insert_id = $this->common->insert_data_getid($data, 'art_reg');
            if ($insert_id) {


                $this->session->set_flashdata('success', 'Basic Information updated successfully');
                redirect('artistic/art_address', refresh);
            } else {
                $this->session->flashdata('error', 'Sorry!! Your data not inserted');
                redirect('artistic/art_basic_information_insert', refresh);
            }
        }
    }

//check mail start
    public function check_email() {


        $email = $this->input->post('email');

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $email1 = $userdata[0]['art_email'];


        if ($email1) {
            $condition_array = array('is_delete' => '0', 'user_id !=' => $userid, 'status' => '1' , 'art_step' => 4);

            $check_result = $this->common->check_unique_avalibility('art_reg', 'art_email', $email, '', '', $condition_array);
        } else {

            $condition_array = array('is_delete' => '0', 'status' => '1');

            $check_result = $this->common->check_unique_avalibility('art_reg', 'art_email', $email, '', '', $condition_array);
        }

        if ($check_result) {
            echo 'true';
            die();
        } else {
            echo 'false';
            die();
        }
    }

//check mail end


    public function art_address() {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $contition_array = array('status' => 1);
        $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = '*', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


$contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        //for getting state data
        $contition_array = array('status' => 1,'country_id' => $userdata[0]['art_country']);
        $this->data['states'] = $this->common->select_data_by_condition('states', $contition_array, $data = '*', $sortby = 'state_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //for getting city data
        $contition_array = array('status' => 1,'state_id'=> $userdata[0]['art_state']);
       $this->data['cities'] = $this->common->select_data_by_condition('cities', $contition_array, $data = '*', $sortby = 'city_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');



        

        if ($userdata) {
            $step = $userdata[0]['art_step'];

            if ($step == 2 || $step > 2 || ($step >= 1 && $step <= 2)) {
                $this->data['country1'] = $userdata[0]['art_country'];
                $this->data['state1'] = $userdata[0]['art_state'];
                $this->data['city1'] = $userdata[0]['art_city'];
                $this->data['pincode1'] = $userdata[0]['art_pincode'];
                //$this->data['address1'] = $userdata[0]['art_address'];
            }
        }
        $this->data['title'] = 'Artistic Profile'.TITLEPOSTFIX; 
        $this->load->view('artistic/art_address', $this->data);
    }

    public function ajax_data() {

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

    public function art_address_insert() {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End


        if ($this->input->post('next')) {

            $this->form_validation->set_rules('country', 'Country', 'required');
            $this->form_validation->set_rules('state', 'State', 'required');
            //$this->form_validation->set_rules('address', 'Address', 'required');
            $this->form_validation->set_rules('pincode', 'Pincode', 'numeric');
           // echo $this->input->post('pincode');die();
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('artistic/art_address');
            } else {


                $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
                $artuserdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if ($artuserdata[0]['art_step'] == 4) {

                    $data = array(
                        'art_country' => $this->input->post('country'),
                        'art_state' => $this->input->post('state'),
                        'art_city' => $this->input->post('city'),
                        //'art_address' => $this->input->post('address'),
                        'art_pincode' => $this->input->post('pincode'),
                        'modified_date' => date('Y-m-d', time())
                            //'art_step' => 2
                    );
                } else {

                    $data = array(
                        'art_country' => $this->input->post('country'),
                        'art_state' => $this->input->post('state'),
                        'art_city' => $this->input->post('city'),
                        //'art_address' => $this->input->post('address'),
                        'art_pincode' => $this->input->post('pincode'),
                        'modified_date' => date('Y-m-d', time()),
                        'art_step' => 2
                    );
                }
                $updatdata = $this->common->update_data($data, 'art_reg', 'user_id', $userid);


                if ($updatdata) {
                    $this->session->set_flashdata('success', 'Address updated successfully');
                    redirect('artistic/art_information', refresh);
                } else {
                    $this->session->flashdata('error', 'Your data not inserted');
                    redirect('artistic/art_address', refresh);
                }
            }
        }
    }

    public function art_information() {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $work_skill = explode(',', $userdata[0]['art_skill']); 
        
    
        foreach($work_skill as $skill){
     $contition_array = array('skill_id' => $skill);
     $skilldata = $this->common->select_data_by_condition('skill',$contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
     $detailes[] = $skilldata[0]['skill'];
  } 

   $this->data['work_skill'] = implode(',', $detailes); 

        $contition_array = array('status' => 1, 'type' => 2);
        $this->data['skill'] = $this->common->select_data_by_condition('skill', $contition_array, $data = '*', $sortby = 'skill', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        if ($userdata) {
            $step = $userdata[0]['art_step'];

            if ($step == 3 || ($step >= 1 && $step <= 3) || $step > 3) {
                $this->data['artname1'] = $userdata[0]['art_yourart'];
                $this->data['desc_art1'] = $userdata[0]['art_desc_art'];
                $this->data['inspire1'] = $userdata[0]['art_inspire'];
                $this->data['skills1'] = $userdata[0]['art_skill'];
                $this->data['otherskill1'] = $userdata[0]['other_skill'];
            }
        }

        $skildata = explode(',', $userdata[0]['art_skill']);
        $this->data['selectdata'] = $skildata;
        //echo "<pre>"; print_r( $this->data['selectdata']); die();
        $this->data['title'] = 'Artistic Profile'.TITLEPOSTFIX;

        $this->load->view('artistic/art_information', $this->data);
    }

    public function art_information_insert() {
        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End
      //  $skill = $this->input->post('skills');
        //$otherskill = $this->input->post('other_skill');

          $skills = $this->input->post('skills');
          $skills = explode(',',$skills); 

          if(count($skills) > 0){ 
          
          foreach($skills as $ski){
            if($ski != ' '){
     $contition_array = array('skill' => $ski,'type' => 6);
     //$search_condition = "(skill LIKE '" . trim($searchTerm) . "%')";
     $skilldata = $this->common->select_data_by_condition('skill',$contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
     if($skilldata){
         $skill[] = $skilldata[0]['skill_id'];
           }else{
                 $data = array(
                    'skill' => $ski,
                    'status' => '1',
                    'type' => 3,
                    'user_id' => $userid,
                 );
      $skill[] = $this->common->insert_data_getid($data, 'skill');
           }
          }
        }
          
          $skills = implode(',',$skill); 
      }



        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $artuserdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if ($artuserdata[0]['art_step'] == 4) {

            $data = array(
                'art_yourart' => $this->input->post('artname'),
                //'other_skill' => $this->input->post('other_skill'),
                'art_skill' => $skills,
                'art_desc_art' => $this->input->post('desc_art'),
                'art_inspire' => $this->input->post('inspire'),
                'modified_date' => date('Y-m-d', time()),
                    //'art_step' => 3
            );
        } else {

            $data = array(
                'art_yourart' => $this->input->post('artname'),
                //'other_skill' => $this->input->post('other_skill'),
                'art_skill' => $skills,
                'art_desc_art' => $this->input->post('desc_art'),
                'art_inspire' => $this->input->post('inspire'),
                'modified_date' => date('Y-m-d', time()),
                'art_step' => 3
            );
        }

        $updatdata = $this->common->update_data($data, 'art_reg', 'user_id', $userid);

        $skilldata = $this->common->select_data_by_id('skill', 'skill', $otherskill, $data = '*', $join_str = array());
        if ($skilldata || $otherskill == "") {
            
        } else {
            $data1 = array(
                'skill' => $this->input->post('other_skill'),
                'type' => 2,
                'status' => 1
            );

            $insertid = $this->common->insert_data_getid($data1, 'skill');
        }



        if ($updatdata) {
            $this->session->set_flashdata('success', 'Information updated successfully');
            redirect('artistic/art_portfolio', refresh);
        } else {
            $this->session->flashdata('error', 'Your data not inserted');
            redirect('artistic/art_information', refresh);
        }
    }

    public function art_portfolio() {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->data['userdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userdata) {
            $step = $userdata[0]['art_step'];

            if ($step == 4 || ($step >= 1 && $step <= 4) || $step > 4) {
                $this->data['bestofmine1'] = $userdata[0]['art_bestofmine'];
                $this->data['achievmeant1'] = $userdata[0]['art_achievement'];
                $this->data['art_portfolio1'] = $userdata[0]['art_portfolio'];
            }
        }

        $this->data['title'] = 'Artistic Profile'.TITLEPOSTFIX;
    

        $this->load->view('artistic/art_portfolio', $this->data);
    }

    // public function art_portfolio_insert() {
    //     $userid = $this->session->userdata('aileenuser');
    //     //echo "<pre>"; print_r($_POST); die();
    //     //best of mine image upload code start
    //     $contition_array = array('user_id' => $userid);
    //     $art_reg_data = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_bestofmine', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
    //     $art_bestofmine = $art_reg_data[0]['art_bestofmine']; 
    //     if ($art_bestofmine != '') {
    //         $art_pdf_path = 'uploads/art_images/';
    //         $art_pdf = $art_pdf_path . $art_bestofmine;
    //         if (isset($art_pdf)) {
    //             unlink($art_pdf);
    //         }
    //     }
    //     $config['upload_path'] = 'uploads/art_images/';
    //     $config['allowed_types'] = 'pdf';
    //     $config['file_name'] = $_FILES['bestofmine']['name'];
    //     $config['upload_max_filesize'] = '40M';
    //     //Load upload library and initialize configuration
    //     $this->load->library('upload', $config);
    //     $this->upload->initialize($config);
    //     if ($this->upload->do_upload('bestofmine')) {
    //         $uploadData = $this->upload->data();
    //         $picture = $uploadData['file_name'];
    //     } else {
    //         $picture = '';
    //     }
    //     //best of mine image upload code End
    //     // //Achievement image upload code start
    //     // $config['upload_path'] = 'uploads/art_images/';
    //     // $config['allowed_types'] = 'jpg|jpeg|png|gif|mp4|3gp|pdf|mp3';
    //     // $config['file_name'] = $_FILES['achievmeant']['name'];
    //     // $config['upload_max_filesize'] = '40M';
    //     // //Load upload library and initialize configuration
    //     // $this->load->library('upload', $config);
    //     // $this->upload->initialize($config);
    //     // if ($this->upload->do_upload('achievmeant')) {
    //     //     $uploadData = $this->upload->data();
    //     //     $picture_achiev = $uploadData['file_name'];
    //     // } else {
    //     //     $picture_achiev = '';
    //     // }
    //     // //Achievement image upload code End
    //         $data = array(
    //             'art_bestofmine' => $picture,
    //             'art_portfolio' => $_POST('artportfolio'),
    //             'modified_date' => date('Y-m-d', time()),
    //             'art_step' => 4
    //         );
    //    echo "<pre>"; print_r($data); die();
    //     $updatdata = $this->common->update_data($data, 'art_reg', 'user_id', $userid);
    //     if ($updatdata) {
    //         $this->session->set_flashdata('success', 'Portfolio updated successfully');
    //         redirect('artistic/artistic_profile', refresh);
    //     } else {
    //         $this->session->flashdata('error', 'Your data not inserted');
    //         redirect('artistic/art_portfolio', refresh);
    //     }
    // }


    public function art_portfolio_insert() {
 //echo "<pre>"; print_r($_FILES); 
 // echo "<pre>"; print_r($_POST); die();


        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End
        $artportfolio = $_POST['artportfolio'];
         $bestmine = $_POST['bestmine'];
        
        // $bestofmine = $_POST['bestofmine']; 
        //best of mine image upload code start
//echo "<pre>"; print_r($artportfolio); die();
    

        $contition_array = array('user_id' => $userid);
        $art_reg_data = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_bestofmine', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $art_bestofmine = $art_reg_data[0]['art_bestofmine'];

        if ($art_bestofmine != '') {
            $art_pdf_path = $this->config->item('art_portfolio_main_upload_path');
            $art_pdf = $art_pdf_path . $art_bestofmine;
            if (isset($art_pdf)) {
                unlink($art_pdf);
            }
        }


         $config = array(
            'upload_path' => $this->config->item('art_portfolio_main_upload_path'),
            'max_size' => 2500000000000,
            'allowed_types' => $this->config->item('art_portfolio_main_allowed_types'),
            'file_name' => $_FILES['bestofmine']['name']
               
        );

        // echo "<pre>"; print_r($config); die();

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
           // echo "hi"; die();

            // $uploadData = $this->upload->data();

            // $picture = $uploadData['file_name'];

             $response['result']= $this->upload->data();
            // echo "<pre>"; print_r($response['result']); die();
                $art_post_thumb['image_library'] = 'gd2';
                $art_post_thumb['source_image'] = $this->config->item('art_portfolio_main_upload_path') . $response['result']['file_name'];
                $art_post_thumb['new_image'] = $this->config->item('art_portfolio_thumb_upload_path') . $response['result']['file_name'];
                $art_post_thumb['create_thumb'] = TRUE;
                $art_post_thumb['maintain_ratio'] = TRUE;
                $art_post_thumb['thumb_marker'] = '';
                $art_post_thumb['width'] = $this->config->item('art_portfolio_thumb_width');
                //$product_thumb[$i]['height'] = $this->config->item('product_thumb_height');
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

      
        } 

        else {

            $dataimage = $bestmine;
        }

       //echo "<pre>"; print_r($dataimage); die();

        //if ($dataimage) {
            $data = array(
                'art_bestofmine' => $dataimage,
                'art_portfolio' => $artportfolio,
                'modified_date' => date('Y-m-d', time()),
                'art_step' => 4
            );


            $updatdata = $this->common->update_data($data, 'art_reg', 'user_id', $userid);
       // } 
        //    if ($artportfolio) {


        //     $data = array(
        //         //'art_bestofmine' => $picture,
        //         'art_portfolio' => $artportfolio,
        //         'modified_date' => date('Y-m-d', time()),
        //         'art_step' => 4
        //     );


        //     $updatdata = $this->common->update_data($data, 'art_reg', 'user_id', $userid);
        // }

    }

    public function art_post() { //echo"ff"; die();

        $user_name = $this->session->userdata('user_name');


        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $contition_array = array('user_id' => $userid, 'status' => '1', 'art_step' => '4');
        $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($this->data['artisticdata']); die();
        $artregid = $this->data['artisticdata'][0]['art_id'];


//userlist for followdata strat
        $likeuserarray = explode(',', $this->data['artisticdata'][0]['art_skill']);
        //echo "<pre>"; print_r($likeuserarray); die();
        $contition_array = array('is_delete' => 0, 'status' => 1, 'user_id !=' => $userid , 'art_step' => 4);
        $userlist = $this->data['userlist'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = 'art_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


//using skill user     
        foreach ($userlist as $row) {

            $userlistarray = explode(',', $row['art_skill']);
            //echo "<pre>"; print_r($likeuserarray);
            //echo "<pre>"; print_r($userlistarray); 
            if (array_intersect($likeuserarray, $userlistarray)) {
                $usernamelist[] = $row;
            }
        }


        $this->data['userlistview1'] = $usernamelist;
        //echo "<pre>"; print_r($this->data['userlistview1']); die();
//using city user     

        $artregcity = $this->data['artisticdata'][0]['art_city'];
        foreach ($userlist as $rowcity) {

            $userlistarray1 = explode(',', $rowcity['art_skill']);
            if (array_intersect($likeuserarray, $userlistarray1)) {
                
            } else {

                if ($artregcity == $rowcity['art_city']) {
                    $userlistcity[] = $rowcity;
                }
            }
        }

        $this->data['userlistview2'] = $userlistcity;
        // echo "<pre>"; print_r($this->data['userlistview2']); die();
//using state user     

        $contition_array = array('is_delete' => 0, 'status' => 1, 'user_id !=' => $userid, 'art_city !=' => $artregcity , 'art_step' => 4);
        $userlist3 = $this->data['userlist3'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = 'art_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        $artregstate = $this->data['artisticdata'][0]['art_state'];
        foreach ($userlist3 as $rowstate) {

            $userlistarray2 = explode(',', $rowstate['art_skill']);
            if (array_intersect($likeuserarray, $userlistarray2)) {
                
            } else {

                if ($artregstate == $rowstate['art_state']) {
                    $userliststate[] = $rowstate;
                }
            }
        }


        $this->data['userlistview3'] = $userliststate;

        //echo "<pre>"; print_r($this->data['userlistview3']); die();
//using last3 user     
        $contition_array = array('is_delete' => 0, 'status' => 1, 'user_id !=' => $userid, 'art_city !=' => $artregcity, 'art_state !=' => $artregstate , 'art_step' => 4);
        $userlastview = $this->data['userlastview'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = 'art_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $userlistarray4 = explode(',', $userlastview['art_skill']);
        if (array_intersect($likeuserarray, $userlistarray4)) {
            
        } else {
            $this->data['userlistview4'] = $userlastview;
        }
        //echo"<pre>"; print_r($this->data['userlistview4']); die();
//userlist for followdata end
// data fatch using follower start

        $contition_array = array('follow_from' => $artregid, 'follow_status' => '1', 'follow_type' => '1');
        $followerdata1 = $this->data['followerdata1'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($this->data['followerdata']); die();


        foreach ($followerdata1 as $fdata) {

            $user_id = $this->db->get_where('art_reg', array('art_id' => $fdata['follow_to'], 'status' => '1'))->row()->user_id;


            $contition_array = array('art_post.user_id' => $user_id, 'art_post.status' => '1', 'art_post.user_id !=' => $userid, 'art_post.is_delete' => '0');
            $this->data['art_data'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            $followerabc[] = $this->data['art_data'];
        }

        //echo "<pre>"; print_r($followerabc); die();
//data fatch using follower end
//data fatch using skill start

        $userselectskill = $this->data['artisticdata'][0]['art_skill'];
        //echo  $userselectskill; die();
        $contition_array = array('art_skill' => $userselectskill, 'status' => '1' , 'art_step' => 4);
        $skilldata = $this->data['skilldata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($this->data['skilldata']); die();

        foreach ($skilldata as $fdata) {


            $contition_array = array('art_post.user_id' => $fdata['user_id'], 'art_post.status' => '1', 'art_post.user_id !=' => $userid, 'art_post.is_delete' => '0');

            $this->data['art_data'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $skillabc[] = $this->data['art_data'];
        }


//data fatch using skill end
//data fatch using login user last post start
        $contition_array = array('art_post.user_id' => $userid, 'art_post.status' => '1', 'art_post.is_delete' => '0');

        $art_userdata = $this->data['art_userdata'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = 'art_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if (count($art_userdata) > 0) {
            $userabc[][] = $this->data['art_userdata'][0];
        } else {
            $userabc[] = $this->data['art_userdata'][0];
        }
        //echo "<pre>"; print_r($userabc); die();
        //echo "<pre>"; print_r($skillabc);  die();
//data fatch using login user last post end
//echo count($skillabc);
//echo count($userabc);
//echo count($unique);
//echo count($followerabc); 


        if (count($skillabc) == 0 && count($userabc) != 0) {
            $unique = $userabc;
        } elseif (count($userabc) == 0 && count($skillabc) != 0) {
            $unique = $skillabc;
        } elseif (count($userabc) != 0 && count($skillabc) != 0) {
            $unique = array_merge($skillabc, $userabc);
        }

        //echo "<pre>"; print_r($userabc); die();
        //echo count($followerabc);  echo count($unique); die();

        if (count($followerabc) == 0 && count($unique) != 0) {
            $unique_user = $unique;
        } elseif (count($unique) == 0 && count($followerabc) != 0) {

            $unique_user = $followerabc;
        } elseif (count($unique) != 0 && count($followerabc) != 0) {
            $unique_user = array_merge($unique, $followerabc);
        }


        // foreach ($unique_user as $k => $v) { 
        //     foreach ($unique_user as $key => $value) {
        //         foreach ($value as $datak => $datav) {
        //             // echo "<pre>"; print_r($k); 
        //             // echo "<pre>"; print_r($datak); 
        //             // echo "<pre>"; print_r($v['user_id']); 
        //             // echo "<pre>"; print_r($datav['user_id']); die(); 
        //             if ($k != $datak && $v['user_id'] == $datav['user_id']) {
        //                 unset($unique_user[$k]);
        //             }
        //         }
        //     }
        // }  
        //echo "<pre>"; print_r($unique); die();

        foreach ($unique_user as $key1 => $val1) {
            foreach ($val1 as $ke => $va) {

                $qbc[] = $va;
            }
        }


        $qbc = array_unique($qbc, SORT_REGULAR);
        //echo "<pre>"; print_r($qbc); die();
        // sorting start

        $post = array();

        //$i =0;
        foreach ($qbc as $key => $row) {
            $post[$key] = $row['art_post_id'];
            //  $qbc[$i]['created_date'] = $this->time_elapsed_string(date('Y-m-d H:i:s', strtotime($row['created_date'])));
            //$i++;
        }

        array_multisort($post, SORT_DESC, $qbc);
        $this->data['finalsorting'] = $qbc;
       
        if(!$this->data['artisticdata']){ 
        redirect('artistic/');
       }else{ //echo "123456789"; die();
       $this->data['left_artistic'] =  $this->load->view('artistic/left_artistic', $this->data, true);
      
       $artistic_name = $this->get_artistic_name($id);
      $this->data['title'] = $artistic_name.TITLEPOSTFIX;

        $this->load->view('artistic/art_post', $this->data);
       
       }
    }

    public function art_manage_post($id = "") {

        $userid = $this->session->userdata('aileenuser');

        

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End
        $user_name = $this->session->userdata('user_name');

        $contition_array = array('user_id' => $userid, 'status' => '1');
            $artisticslug = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($id == $userid || $id == '' || $id == $artisticslug[0]['slug']) {

            $contition_array = array('user_id' => $userid, 'status' => '1');
            $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['artid'] = $userid;

            $this->data['userdata'] = $this->common->select_data_by_id('user', 'user_id', $userid, $data = '*', $join_str = array());

        } else {

            $contition_array = array('slug' => $id, 'status' => '1' , 'art_step' => 4);
            $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->data['artid'] = $id;

            $this->data['userdata'] = $this->common->select_data_by_id('user', 'user_id', $id, $data = '*', $join_str = array());

        }
        //echo "<pre>"; print_r($this->data['artsdata']); die();
        

       if(!$this->data['artisticdata'] && !$this->data['artsdata']){ //echo "22222222"; die();
      
      $this->load->view('artistic/notavalible');  
             
       }
        else if($this->data['artisticdata'][0]['art_step'] != 4){   //echo "hii"; die();
        
       redirect('artistic/');
         
       }
       else{
        $this->data['artistic_common'] = $this->load->view('artistic/artistic_common', $this->data, true);
        $artistic_name = $this->get_artistic_name($id);
      $this->data['title'] = $artistic_name.TITLEPOSTFIX;
      $this->load->view('artistic/art_manage_post', $this->data);
       }
    }

    public function art_addpost() {
        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End
        $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $this->load->view('artistic/art_addpost', $this->data);
    }

// khyati changes start
    //public function art_post_insert($id,$para) {
    public function art_post_insert($id = '', $para = '') {
        //echo'<pre>'; print_r($_FILES); die();
        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

//echo '<pre>'; print_r($_POST); die();

        if ($para == $userid || $para == '') {
            $data = array(
                'art_post' => $this->input->post('my_text'),
                'art_description' => $this->input->post('product_desc'),
                'created_date' => date('Y-m-d H:i:s', time()),
                'status' => 1,
                'is_delete' => 0,
                'user_id' => $userid
            );
        } else {

            $data = array(
                'art_post' => $this->input->post('my_text'),
                'art_description' => $this->input->post('product_desc'),
                'created_date' => date('Y-m-d H:i:s', time()),
                'status' => 1,
                'is_delete' => 0,
                'user_id' => $para,
                'posted_user_id' => $userid
            );
        }

        $insert_id = $this->common->insert_data_getid($data, 'art_post');
    

       $config = array(
            'upload_path' => $this->config->item('art_post_main_upload_path'),
            'allowed_types' => $this->config->item('art_post_main_allowed_types'),
            'max_size' => $this->config->item('art_post_main_max_size')
        );
        $images = array();
        $this->load->library('upload');

        $files = $_FILES;
        $count = count($_FILES['postattach']['name']);

        //S3 BUCKET ACCESS START
         $s3 = new S3(awsAccessKey, awsSecretKey);
         $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
         //S3 BUCKET ACCESS START

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

            $store = $_FILES['postattach']['name'];
            $store_ext = explode('.', $store);
            $store_ext = end($store_ext);
            $fileName = 'file_' . $title . '_' . $this->random_string() . '.' . $store_ext;
            $images[] = $fileName;
            $config['file_name'] = $fileName;
            $this->upload->initialize($config);
          
             if ($this->upload->do_upload('postattach')) {

                $response['result'][] = $this->upload->data();
                
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

                    $artistic_post_main[$i]['image_library'] = 'gd2';
                    $artistic_post_main[$i]['source_image'] = $this->config->item('art_post_main_upload_path') . $response['result'][$i]['file_name'];
                    $artistic_post_main[$i]['new_image'] = $this->config->item('art_post_main_upload_path') . $response['result'][$i]['file_name'];
                    $artistic_post_main[$i]['quality'] = $quality;
                  
                    $instanse10 = "image10_$i";
                    $this->load->library('image_lib', $artistic_post_main[$i], $instanse10);
                    $this->$instanse10->watermark();
                    //$this->image_lib->clear();
                  //$this->$instanse10->clear();
                 
              // }
//}
                    /* RESIZE */

                        $main_image = $this->config->item('art_post_main_upload_path') . $response['result'][$i]['file_name'];
                        $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);

                        $image_width = $response['result'][$i]['image_width'];
                        $image_height = $response['result'][$i]['image_height'];

                        /* RESIZE4 */

                       // $resize4_image_width = $this->config->item('art_post_resize4_width');
                       //  $resize4_image_height = $this->config->item('art_post_resize4_height');

                       //  $n_w1 = $image_width;
                       //  $n_h1 = $image_height;


                       //  $conf_new4[$i] = array(
                       //      'image_library' => 'gd2',
                       //      'source_image' => $artistic_post_main[$i]['new_image'],
                       //      'create_thumb' => FALSE,
                       //      'maintain_ratio' => FALSE,
                       //      'width' => $resize4_image_width,
                       //      'height' => $resize4_image_height
                       //  );

                       //  $conf_new4[$i]['new_image'] = $this->config->item('art_post_resize4_upload_path') . $response['result'][$i]['file_name'];

                       //  $left = ($n_w1 / 2) - ($resize4_image_width / 2);
                       //  $top = ($n_h1 / 2) - ($resize4_image_height / 2);

                       //  $conf_new4[$i]['x_axis'] = $left;
                       //  $conf_new4[$i]['y_axis'] = $top;

                       //  $instanse4 = "image4_$i";
                       //  //Loading Image Library
                       //  $this->load->library('image_lib', $conf_new4[$i], $instanse4);
                       //  $dataimage = $response['result'][$i]['file_name'];
                       //  //Creating Thumbnail
                       //  $this->$instanse4->crop();

                       //  $resize_image4 = $this->config->item('art_post_resize4_upload_path') . $response['result'][$i]['file_name'];

                       //  $abc = $s3->putObjectFile($resize_image4, bucket, $resize_image4, S3::ACL_PUBLIC_READ);

                        /* RESIZE4 */
                         if ($count == '3') {
                            /* RESIZE 4 */

                            $resize4_image_width = $this->config->item('art_post_resize4_width');
                            $resize4_image_height = $this->config->item('art_post_resize4_height');


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

                            $artistic_profile_post_resize4[$i]['image_library'] = 'gd2';
                            $artistic_profile_post_resize4[$i]['source_image'] = $this->config->item('art_post_main_upload_path') . $response['result'][$i]['file_name'];
                            $artistic_profile_post_resize4[$i]['new_image'] = $this->config->item('art_post_resize4_upload_path') . $response['result'][$i]['file_name'];
                            $artistic_profile_post_resize4[$i]['create_thumb'] = TRUE;
                            $artistic_profile_post_resize4[$i]['maintain_ratio'] = TRUE;
                            $artistic_profile_post_resize4[$i]['thumb_marker'] = '';
                            $artistic_profile_post_resize4[$i]['width'] = $n_w1;
                            $artistic_profile_post_resize4[$i]['height'] = $n_h1;
                            $artistic_profile_post_resize4[$i]['quality'] = "100%";
//                        $business_profile_post_resize4[$i]['x_axis'] = $left;
//                        $business_profile_post_resize4[$i]['y_axis'] = $top;
                            $instanse4 = "image4_$i";
                            //Loading Image Library
                            $this->load->library('image_lib', $artistic_profile_post_resize4[$i], $instanse4);
                            //Creating Thumbnail
                            $this->$instanse4->resize();
                            $this->$instanse4->clear();

                            /* RESIZE 4 */
                        }

                        $thumb_image_width = $this->config->item('art_post_thumb_width');
                        $thumb_image_height = $this->config->item('art_post_thumb_height');


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

                        $artistic_post_thumb[$i]['image_library'] = 'gd2';
                        $artistic_post_thumb[$i]['source_image'] = $this->config->item('art_post_main_upload_path') . $response['result'][$i]['file_name'];
                        $artistic_post_thumb[$i]['new_image'] = $this->config->item('art_post_thumb_upload_path') . $response['result'][$i]['file_name'];
                        $artistic_post_thumb[$i]['create_thumb'] = TRUE;
                        $artistic_post_thumb[$i]['maintain_ratio'] = FALSE;
                        $artistic_post_thumb[$i]['thumb_marker'] = '';
                        $artistic_post_thumb[$i]['width'] = $n_w;
                        $artistic_post_thumb[$i]['height'] = $n_h;
//                        $business_profile_post_thumb[$i]['master_dim'] = 'width';
                        $artistic_post_thumb[$i]['quality'] = "100%";
                        $artistic_post_thumb[$i]['x_axis'] = '0';
                        $artistic_post_thumb[$i]['y_axis'] = '0';
                        $instanse = "image_$i";
                        //Loading Image Library
                        $this->load->library('image_lib', $artistic_post_thumb[$i], $instanse);
                        $dataimage = $response['result'][$i]['file_name'];
                        //Creating Thumbnail
                        $this->$instanse->resize();

                        $thumb_image = $this->config->item('art_post_thumb_upload_path') . $response['result'][$i]['file_name'];

                        $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);

                        /* CROP 335 X 320 */
                        // reconfigure the image lib for cropping

                        $resized_image_width = $this->config->item('art_post_resize1_width');
                        $resized_image_height = $this->config->item('art_post_resize1_height');
                        if ($thumb_image_width < $resized_image_width) {
                            $resized_image_width = $thumb_image_width;
                        }
                        if ($thumb_image_height < $resized_image_height) {
                            $resized_image_height = $thumb_image_height;
                        }

                        $conf_new[$i] = array(
                            'image_library' => 'gd2',
                            'source_image' => $artistic_post_thumb[$i]['new_image'],
                            'create_thumb' => FALSE,
                            'maintain_ratio' => FALSE,
                            'width' => $resized_image_width,
                            'height' => $resized_image_height
                        );

                        $conf_new[$i]['new_image'] = $this->config->item('art_post_resize1_upload_path') . $response['result'][$i]['file_name'];

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

                        $resize_image = $this->config->item('art_post_resize1_upload_path') . $response['result'][$i]['file_name'];

                        $abc = $s3->putObjectFile($resize_image, bucket, $resize_image, S3::ACL_PUBLIC_READ);
                        /* CROP 335 X 320 */


                        /* CROP 335 X 245 */
                        // reconfigure the image lib for cropping

                        $resized_image_width = $this->config->item('art_post_resize2_width');
                        $resized_image_height = $this->config->item('art_post_resize2_height');
                        if ($thumb_image_width < $resized_image_width) {
                            $resized_image_width = $thumb_image_width;
                        }
                        if ($thumb_image_height < $resized_image_height) {
                            $resized_image_height = $thumb_image_height;
                        }


                        $conf_new1[$i] = array(
                            'image_library' => 'gd2',
                            'source_image' => $artistic_post_thumb[$i]['new_image'],
                            'create_thumb' => FALSE,
                            'maintain_ratio' => FALSE,
                            'width' => $resized_image_width,
                            'height' => $resized_image_height
                        );

                        $conf_new1[$i]['new_image'] = $this->config->item('art_post_resize2_upload_path') . $response['result'][$i]['file_name'];

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

                        $resize_image1 = $this->config->item('art_post_resize2_upload_path') . $response['result'][$i]['file_name'];

                        $abc = $s3->putObjectFile($resize_image1, bucket, $resize_image1, S3::ACL_PUBLIC_READ);

                        /* CROP 335 X 245 */

                        /* CROP 210 X 210 */
                        // reconfigure the image lib for cropping

                        $resized_image_width = $this->config->item('art_post_resize3_width');
                        $resized_image_height = $this->config->item('art_post_resize3_height');
                        if ($thumb_image_width < $resized_image_width) {
                            $resized_image_width = $thumb_image_width;
                        }
                        if ($thumb_image_height < $resized_image_height) {
                            $resized_image_height = $thumb_image_height;
                        }


                        $conf_new2[$i] = array(
                            'image_library' => 'gd2',
                            'source_image' => $artistic_post_thumb[$i]['new_image'],
                            'create_thumb' => FALSE,
                            'maintain_ratio' => FALSE,
                            'width' => $resized_image_width,
                            'height' => $resized_image_height
                        );

                        $conf_new2[$i]['new_image'] = $this->config->item('art_post_resize3_upload_path') . $response['result'][$i]['file_name'];

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

                        $resize_image2 = $this->config->item('art_post_resize3_upload_path') . $response['result'][$i]['file_name'];
                        $abc = $s3->putObjectFile($resize_image2, bucket, $resize_image2, S3::ACL_PUBLIC_READ);

                        /* CROP 210 X 210 */

                        $response['error'][] = $thumberror = $this->$instanse->display_errors();

                        $return['data'][] = $imgdata;
                        $return['status'] = "success";
                        $return['msg'] = sprintf($this->lang->line('success_item_added'), "Image", "uploaded");

                        $data1 = array(
                            'file_name' => $fileName,
                            'insert_profile' => '1',
                            'post_id' => $insert_id,
                            'is_deleted' => '1',
                            'post_format' => $file_type,
                            'created_date' => date('Y-m-d H:i:s', time())
                        );

                        //echo "<pre>"; print_r($data1);
                        $insert_id1 = $this->common->insert_data_getid($data1, 'post_files');
                       
                    } else {
                        echo $this->upload->display_errors();
                        exit;
                    }
           //      }
           //       else {
           //          $this->session->set_flashdata('error', '<div class="col-md-7 col-sm-7 alert alert-danger1">Something went to wrong in uploded file.</div>');
           //          exit;
           //      }
            //} //die();
        }

//new code end

        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

        $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($artistic_deactive) {
            redirect('artistic/');
        }

       $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $artregid = $this->data['artisticdata'][0]['art_id'];


          $contition_array = array('follow_from' => $artregid, 'follow_status' => '1', 'follow_type' => '1');
        $followerdata = $this->data['followerdata'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        foreach ($followerdata as $fdata) {
            $contition_array = array('art_id' => $fdata['follow_to'], 'art_step' => 4);
            $this->data['art_data'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $art_userid = $this->data['art_data'][0]['user_id'];

            $contition_array = array('user_id' => $art_userid, 'status' => '1', 'is_delete' => '0');
            $this->data['art_data'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $followerabc[] = $this->data['art_data'];
        }
        $userselectskill = $this->data['artisticdata'][0]['art_skill'];
       

       $contition_array = array('art_skill' => $userselectskill, 'status' => '1' , 'art_step' => 4);
        $skilldata = $this->data['skilldata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        foreach ($skilldata as $fdata) {
            $contition_array = array('art_post.user_id' => $fdata['user_id'], 'art_post.status' => '1', 'art_post.user_id !=' => $userid, 'art_post.is_delete' => '0');

             $this->data['art_data'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $skillabc[] = $this->data['art_data'];
        }

       $contition_array = array('art_post.user_id' => $userid, 'art_post.status' => '1', 'art_post.is_delete' => '0');
        $art_userdata = $this->data['art_userdata'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = 'art_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

         if (count($art_userdata) > 0) {
            $userabc[][] = $this->data['art_userdata'][0];
        } else {
            $userabc[] = $this->data['art_userdata'][0];
        }


         if (count($skillabc) == 0 && count($userabc) != 0) {
            $unique = $userabc;
        } elseif (count($userabc) == 0 && count($skillabc) != 0) {
            $unique = $skillabc;
        } elseif (count($userabc) != 0 && count($skillabc) != 0) {
            $unique = array_merge($skillabc, $userabc);
        }

        if (count($followerabc) == 0 && count($unique) != 0) {
            $unique_user = $unique;
        } elseif (count($unique) == 0 && count($followerabc) != 0) {

            $unique_user = $followerabc;
        } elseif (count($unique) != 0 && count($followerabc) != 0) {
            $unique_user = array_merge($unique, $followerabc);
        }

       foreach ($unique_user as $key1 => $val1) {
            foreach ($val1 as $ke => $va) {

                $qbc[] = $va;
            }
        }

        $qbc = array_unique($qbc, SORT_REGULAR);
        $post = array();

       
        foreach ($qbc as $key => $row) {
            $post[$key] = $row['art_post_id'];
            //  $qbc[$i]['created_date'] = $this->time_elapsed_string(date('Y-m-d H:i:s', strtotime($row['created_date'])));
            //$i++;
        }

        
        array_multisort($post, SORT_DESC, $qbc);
        $finalsorting = $qbc;

        $row = $finalsorting[0];

        //foreach ($businessprofiledatapost as $row) {
        $userid = $this->session->userdata('aileenuser');
         $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1');
                $artdelete = $this->data['artdelete'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

         $contition_array = array('user_id' => $row['user_id'], 'status' => '1');
         $artdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $likeuserarray = explode(',', $artdelete[0]['delete_post']);
        
        if (!in_array($userid, $likeuserarray)) {

                    $return_html .= '<div id="removepost' . $row['art_post_id'] . '">
                    <div class="col-md-12 col-sm-12 post-design-box">
                        <div  class="post_radius_box">  
                            <div class="post-design-top col-md-12" >  
                                <div class="post-design-pro-img">';

                    $art_userimage = $this->db->get_where('art_reg', array('user_id' => $row['user_id'], 'status' => 1))->row()->art_user_image;
                    $userimageposted = $this->db->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->art_user_image;

                    $firstnameposted = $this->db->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->art_name;
                    $lastnameposted = $this->db->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->art_lastname;

                     $firstname = $this->db->get_where('art_reg', array('user_id' => $row['user_id']))->row()->art_name;
                           
                    $lastname = $this->db->get_where('art_reg', array('user_id' => $row['user_id']))->row()->art_lastname;

                     $posted_slug = $this->db->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->slug;


                    
                    if ($row['posted_user_id']) {

                        if ($userimageposted) {
                            $return_html .= '<a href="' . base_url('artistic/dashboard/' . $posted_slug) . '">';

                            if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $userimageposted)) {
                                                                $a = $firstnameposted;
                                                                $acr = substr($a, 0, 1);
                                                                $b = $lastnameposted;
                                                                $bcr = substr($b, 0, 1);

                                    $return_html .=  '<div class="post-img-div">';
                                    $return_html .=  ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                    $return_html .=  '</div>'; 

                                }else{
                            $return_html .=  '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $userimageposted . '" name="image_src" id="image_src" />';

                                }

                            $return_html .=  '</a>';
                        } else {
                            $return_html .= '<a href="' . base_url('artistic/dashboard/' . $posted_slug) . '">';
                                                
                                                                $a = $firstnameposted;
                                                                $acr = substr($a, 0, 1);
                                                                $b = $lastnameposted;
                                                                $bcr = substr($b, 0, 1);

                                    $return_html .=  '<div class="post-img-div">';
                                    $return_html .=  ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                    $return_html .=  '</div>'; 

                            $return_html .=  '</a>';
                        }
                    } else {
                        if ($art_userimage) {
                            $return_html .= '<a href="' . base_url('artistic/dashboard/' . $row['slug']) . '">';

                            if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                                                                $a = $firstname;
                                                                $acr = substr($a, 0, 1);
                                                                $b = $lastname;
                                                                $bcr = substr($b, 0, 1);

                                    $return_html .=  '<div class="post-img-div">';
                                    $return_html .=  ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                    $return_html .=  '</div>'; 

                                }else{

                            $return_html .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage . '"  alt="">';

                                }
                            $return_html .= '</a>';


                        } else {
                            $return_html .= '<a href="' . base_url('artistic/dashboard/' . $row['slug']) . '">';

                                                                $a = $firstname;
                                                                $acr = substr($a, 0, 1);
                                                                $b = $lastname;
                                                                $bcr = substr($b, 0, 1);

                                    $return_html .=  '<div class="post-img-div">';
                                    $return_html .=  ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                    $return_html .=  '</div>'; 
                                                
                            $return_html .= '</a>';
                        }
                    }
                    $return_html .= '</div>
                                <div class="post-design-name fl col-xs-8 col-md-10">
                                    <ul>';
                   

                   
                   $designation = $this->db->get_where('art_reg', array('user_id' => $row['user_id']))->row()->designation;
                           
                           
                    $userskill = $this->db->get_where('art_reg', array('user_id' => $row['user_id']))->row()->art_skill;

                     $posted_slug = $this->db->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->slug;
                           
                           
                           $aud = $userskill;
                           $aud_res = explode(',', $aud);
                           foreach ($aud_res as $skill) {
                           
                               $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;
                               $skill1[] = $cache_time;
                           }
                           $listFinal = implode(', ', $skill1);


                    
                    $return_html .= '<li>
                                        </li>';
                    if ($row['posted_user_id']) {
                        $return_html .= '<li>
                                                <div class="else_post_d">
                                                    <div class="post-design-product">
                                                        <a class="post_dot" href="' . base_url('artistic/dashboard/' . $posted_slug) . '">' . ucwords($firstnameposted) .' '. ucwords($lastnameposted) . '</a>
                                                        <p class="posted_with" > Posted With</p> <a class="post_dot1 padding_less_left"  href="' . base_url('artistic/dashboard/' . $row['slug']) . '">' . ucwords($firstname) .' '. ucwords($lastname) . '</a>
                                                        <span role="presentation" aria-hidden="true"> · </span> <span class="ctre_date">
                                        ' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($row['created_date']))) . '  
                                                        </span> </div></div>
                                            </li>';
                        $category = $this->db->get_where('industry_type', array('industry_id' => $businessdata[0]['industriyal'], 'status' => 1))->row()->industry_name;
                    } else {
                        $return_html .= '<li>
                                                <div class="post-design-product">
                                                    <a class="post_dot"  href="' . base_url('artistic/dashboard/' . $row['slug']) . '" title="' . ucwords($firstname) .' '. ucwords($lastname) . '">
                    ' . ucwords($firstname) .' '.ucwords($lastname). '</a>
                                                    <span role="presentation" aria-hidden="true"> · </span>
                                                    <div class="datespan"> <span class="ctre_date" > 
                    ' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($row['created_date']))) . '

                                                        </span></div>

                                                </div>
                                            </li>';
                    }
                   


                    $return_html .= '<li>
                                            <div class="post-design-product">
                                                <a class="buuis_desc_a" href="javascript:void(0);"  title="Category">';
                    if ($designation) {
                        $return_html .= ucwords($designation);
                    } else {
                        $return_html .= 'Current Work';
                    }

                    $return_html .= '</a>
                                            </div>
                                        </li>

                                        <li>
                                        </li> 
                                    </ul> 
                                </div>  
                                <div class="dropdown2">
                                    <a onClick="myFunction1(' . $row['art_post_id'] . ')" class=" dropbtn2 fa fa-ellipsis-v">
                                    </a>
                                    <div id="myDropdown' . $row['art_post_id'] . '" class=" dropdown2_content">';

                    if ($row['posted_user_id'] != 0) {

                        if ($this->session->userdata('aileenuser') == $row['posted_user_id']) {

                            $return_html .= '<a onclick="deleteownpostmodel(' . $row['art_post_id'] . ')">
                                                    <span class="h4-img h2-srrt">
                                                    </span> Delete Post
                                                </a>
                                                <a id="' . $row['art_post_id'] . '" onClick="editpost(this.id)">
                                                    <span class="h3-img h2-srrt">
                                                    </span>Edit
                                                </a>';
                        } else {

                            $return_html .= '<a onclick="deleteownpostmodel(' . $row['art_post_id'] . ')">
                                                    <span class="h4-img h2-srrt">
                                                    </span> Delete Post
                                                </a>
                                                <a href="' . base_url('artistic/artistic_contactperson/' . $row['posted_user_id']) . '">
                                                    <span class="h2-img h2-srrt">
                                                    </span> Contact Person </a>';
                        }
                    } else {
                        if ($this->session->userdata('aileenuser') == $row['user_id']) {
                            $return_html .= '<a onclick="deleteownpostmodel(' . $row['art_post_id'] . ')">
                                                    <span class="h4-img h2-srrt"></span> Delete Post
                                                </a>
                                                <a id="' . $row['art_post_id'] . '" onClick="editpost(this.id)">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true">
                                                    </i>Edit
                                                </a>';
                        } else {
                            $return_html .= '<a onclick="deletepostmodel(' . $row['art_post_id'] . ')">
                                                    <span class="h4-img h2-srrt">
                                                    </span> Delete Post
                                                </a>

                                                <a href="' . base_url('artistic/artistic_contactperson/' . $row['user_id']) . '">
                                                    <span class="h2-img h2-srrt"></span>Contact Person
                                                </a>';
                        }
                    }

                    $return_html .= '</div>
                                </div>
                                <div class="post-design-desc">
                                    <div class="ft-15 t_artd">
                                        <div id="editpostdata' . $row['art_post_id'] . '" style="display:block;">
                                            <a id="editpostval' . $row['art_post_id'].'">' . $this->common->make_links($row['art_post']) . '</a>
                                        </div>
                                        <div id="editpostbox' . $row['art_post_id'] . '" style="display:none;">
                                            
                                            
                                            <input type="text" class="my_text" id="editpostname' . $row['art_post_id'] . '" name="editpostname" placeholder="Product Name" value="' . $row['art_post'] . '" onKeyDown=check_lengthedit('.$row['art_post_id'].'); onKeyup=check_lengthedit('.$row['art_post_id'].'); onblur=check_lengthedit('.$row['art_post_id'].');>';

                                             if ($row['art_post']) {
                                                                            $counter = $row['art_post'];
                                                                            $a = strlen($counter);

                                      $return_html .= '<input size=1 id="text_num" class="text_num" value="'.(50 - $a).'" name=text_num disabled="disabled">';

                                      } else {
                                       $return_html .= '<input size=1 id="text_num" class="text_num" value=50 name=text_num disabled="disabled">';

                                         } 
                                       $return_html .= '</div>

                                    </div>                    
                                    <div id="khyati' . $row['art_post_id'] . '" style="display:block;">';

                    $num_words = 29;
                                       $words = array();
                                       $words = explode(" ",  $row['art_description'], $num_words);
                                       $shown_string = "";
                                       
                                       if(count($words) == 29){
                                       $words[28] ='... <span id="kkkk" onClick="khdiv(' . $row['art_post_id'] . ')">View More</span>';
                                       }
                                       
                                       $shown_string = implode(" ", $words);
                                       $return_html .= $this->common->make_links($shown_string);

                    $return_html .= '</div>
                                    <div id="khyatii' . $row['art_post_id'] . '" style="display:none;">
                                        ' . $this->common->make_links($row['art_description']) . '</div>
                                    <div id="editpostdetailbox' . $row['art_post_id'] . '" style="display:none;">
                                        <div  contenteditable="true" id="editpostdesc' . $row['art_post_id'] . '"  class="textbuis editable_text margin_btm" name="editpostdesc" placeholder="Description" onpaste="OnPaste_StripFormatting(this, event);" onfocus="return cursorpointer('.$row['art_post_id'].');">' . $row['art_description'] . '</div>
                                    </div>
                                    
                                    <button class="fr" id="editpostsubmit' . $row['art_post_id'] . '" style="display:none; margin-right: 4px; border-radius: 3px;" onClick="edit_postinsert(' . $row['art_post_id'] . ')">Save
                                    </button>
                                </div> 
                            </div>
                            <div class="post-design-mid col-md-12" >
                                <div>';

                    $contition_array = array('post_id' => $row['art_post_id'], 'is_deleted' => '1', 'insert_profile' => '1');
                    $artmultiimage = $this->data['artmultiimage'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    if (count($artmultiimage) == 1) {

                        $allowed = array('jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg');
                        $allowespdf = array('pdf');
                        $allowesvideo = array('mp4', 'webm', 'MP4');
                        $allowesaudio = array('mp3');
                        $filename = $artmultiimage[0]['file_name'];
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                        if (in_array($ext, $allowed)) {

                            $return_html .= '<div class="one-image">';
                            $return_html .= '<a href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '">
                                                    <img src = "' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '">
                                                </a>
                                            </div>';
                        } elseif (in_array($ext, $allowespdf)) {
                            $return_html .= '<div><a href="'.base_url($this->config->item('art_post_main_upload_path') . $artmultiimage[0]['file_name']).'">

                                                <div class="pdf_img">
                                                       <embed src="' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '" width="100%" height="450px" />
                                                    </div>
                                                </a>
                                            </div>';
                        } elseif (in_array($ext, $allowesvideo)) {
                            $return_html .= '<div>
                                                <video width="100%" height="350" controls>
                                                    <source src = "' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '" type = "video/mp4">
                                                     <source src = "' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '" type = "video/ogg">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>';
                        } elseif (in_array($ext, $allowesaudio)) {
                            $return_html .= '<div class="audio_main_div">
                                                <div class="audio_img">
                                                    <img src="' . base_url('images/music-icon.png') . '">  
                                                </div>
                                                <div class="audio_source">
                                                    <audio controls>
                                                        <source src = "' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '" type = "audio/mp3">
                                                        <source src="movie.ogg" type="audio/ogg">
                                                        Your browser does not support the audio tag.
                                                    </audio>
                                                </div></div>';
                                                // <div class="audio_mp3" id="'."postname" . $row['art_post_id'].'">
                                                //     <p title="'.$row['art_post'].'">'.$row['art_post'].'</p>
                                                // </div>
                                            
                        }
                    } elseif (count($artmultiimage) == 2) {

                        foreach ($artmultiimage as $multiimage) {

                            $return_html .= '<div  class="two-images">
                                                <a href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '">
                                                     <img class = "two-columns" src = "' . ART_POST_RESIZE1_UPLOAD_URL . $multiimage['file_name'] . '">
                                                </a>
                                            </div>';
                        }
                    } elseif (count($artmultiimage) == 3) {
                        $return_html .= '<div class="three-image-top" >
                                            <a href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '">

                                                <img class = "three-columns" src = "' . ART_POST_RESIZE4_UPLOAD_URL . $artmultiimage[0]['file_name'] . '">
                                            </a>
                                        </div>
                                        <div class="three-image" >

                                            <a href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '">
                                                <img class = "three-columns" src = "' . ART_POST_RESIZE1_UPLOAD_URL . $artmultiimage[1]['file_name'] . '">
 
                                            </a>
                                        </div>
                                        <div class="three-image" >
                                            <a href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '">
                                                <img class = "three-columns" src = "' . ART_POST_RESIZE1_UPLOAD_URL . $artmultiimage[2]['file_name'] . '"> 
                                            </a>
                                        </div>';
                    } elseif (count($artmultiimage) == 4) {

                        foreach ($artmultiimage as $multiimage) {

                            $return_html .= '<div class="four-image">
                                                <a href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '">
                                                     <img class = "breakpoint" src = "' . ART_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name'] . '">
                                                </a>
                                            </div>';
                        }
                    } elseif (count($artmultiimage) > 4) {

                        $i = 0;
                        foreach ($artmultiimage as $multiimage) {

                            $return_html .= '<div class="four-image">
                                                <a href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '">
                                                    <img src = "' . ART_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name'] . '">
                                                </a>
                                            </div>';

                            $i++;
                            if ($i == 3)
                                break;
                        }

                        $return_html .= '<div class="four-image">
                                            <a href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '">
                                                <img src = "' . ART_POST_RESIZE2_UPLOAD_URL . $artmultiimage[3]['file_name'] . '"> 
                                            </a>
                                            <a class="text-center" href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '" >
                                                <div class="more-image" >
                                                    <span>View All (+
                     ' . (count($artmultiimage) - 4) . ')</span>

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
                                    <ul class="col-md-6">
                                        <li class="likepost' . $row['art_post_id'] . '">
                                            <a id="' . $row['art_post_id'] . '" class="ripple like_h_w"  onClick="post_like(this.id)">';

                    $userid = $this->session->userdata('aileenuser');
                    $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1');
                    $artlike = $this->data['artlike'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    $likeuserarray = explode(',', $artlike[0]['art_like_user']);
                    if (!in_array($userid, $likeuserarray)) {

                        $return_html .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
                    } else {
                        $return_html .= '<i class="fa fa-thumbs-up fa-1x main_color" aria-hidden="true"></i>';
                    }
                    $return_html .= '<span class="like_As_count">';

                    if ($row['art_likes_count'] > 0) {
                        $return_html .= $row['art_likes_count'];
                    }

                    $return_html .= '</span>
                                            </a>
                                        </li>
                                        <li id="insertcount' . $row['art_post_id'] . '" style="visibility:show">';

                     $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1', 'is_delete' => '0');
                    $commnetcount = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $return_html .= '<a onClick = "commentall(this.id)" id = "' . $row['art_post_id'] . '" class = "ripple like_h_w">
                    <i class = "fa fa-comment-o" aria-hidden = "true">
                    </i>
                    </a>
                    </li>
                    </ul>
                    <ul class = "col-md-6 like_cmnt_count">
                    <li>
                    <div class = "like_cmmt_space comnt_count_ext_a like_count_ext'.$row['art_post_id'].'">
                    <span class = "comment_count">';

                    if (count($commnetcount) > 0) {
                        $return_html .= count($commnetcount);
                        $return_html .= '<span> Comment</span>';
                    }
                    $return_html .= '</span> 

                    </div>
                    </li>

                    <li>
                        <div class="comnt_count_ext_a  comnt_count_ext'. $row['art_post_id'].'">
                            <span class="comment_like_count">';
                    if ($row['art_likes_count'] > 0) {
                        $return_html .= $row['art_likes_count'];

                        $return_html .= '<span> Like</span>';
                    }
                    $return_html .= '</span> 

                        </div></li>
                    </ul>
                    </div>
                    </div>';

                    if ($row['art_likes_count'] > 0) {

                        $return_html .= '<div class="likeduserlist' . $row['art_post_id'] . '">';

                        $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1', 'is_delete' => '0');
                        $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                        $likeuser = $commnetcount[0]['art_like_user'];
                        $countlike = $commnetcount[0]['art_likes_count'] - 1;
                        $likelistarray = explode(',', $likeuser);

                        foreach ($likelistarray as $key => $value) {
                            $art_fname1 = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => 1))->row()->art_name;
                            $art_lname1 = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => 1))->row()->art_lastname;
                         }

                        $return_html .= '<a href="javascript:void(0);"  onclick="likeuserlist(' . $row['art_post_id'] . ')">';

                         $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1', 'is_delete' => '0');
                        $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                        $likeuser = $commnetcount[0]['art_like_user'];
                        $countlike = $commnetcount[0]['art_likes_count'] - 1;
                           
                           $likelistarray = explode(',', $likeuser);
                           $likelistarray = array_reverse($likelistarray);

                        $art_fname = $this->db->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => 1))->row()->art_name;
                        $art_lname = $this->db->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => 1))->row()->art_lastname;

                        $return_html .= '<div class="like_one_other">';

                        if (in_array($userid, $likelistarray)) {
                            $return_html .= "You";
                            $return_html .= "&nbsp;";
                        } else {
                            $return_html .= ucwords($art_fname);
                            $return_html .= "&nbsp;";
                            $return_html .= ucwords($art_lname);
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

                    $return_html .= '<div class="likeusername' . $row['art_post_id'] . '" id="likeusername' . $row['art_post_id'] . '" style="display:none">';
                    $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1', 'is_delete' => '0');
                    $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $likeuser = $commnetcount[0]['art_like_user'];
                    $countlike = $commnetcount[0]['art_likes_count'] - 1;
                    $likelistarray = explode(',', $likeuser);

                    foreach ($likelistarray as $key => $value) {
                        $art_fname1 = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => 1))->row()->art_name;
                        $art_lname1 = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => 1))->row()->art_lastname;
                    }
                    $return_html .= '<a href="javascript:void(0);"  onclick="likeuserlist(' . $row['art_post_id'] . ')">';

                    $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1', 'is_delete' => '0');
                    $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                           $likeuser = $commnetcount[0]['art_like_user'];
                           $countlike = $commnetcount[0]['art_likes_count'] - 1;
                           
                           $likelistarray = explode(',', $likeuser);
                           $likelistarray = array_reverse($likelistarray);

                   $art_fname = $this->db->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => 1))->row()->art_name;
                   $art_lname = $this->db->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => 1))->row()->art_lastname;

                    $return_html .= '<div class="like_one_other">';

                    $return_html .= ucwords($art_fname);
                    $return_html .= "&nbsp;";
                    $return_html .= ucwords($art_lname);
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
                        <div  id="fourcomment' . $row['art_post_id'] . '" style="display:none;">
                        </div>
                        <div id="threecomment' . $row['art_post_id'] . '" style="display:block">
                            <div class="hidebottomborder insertcomment' . $row['art_post_id'] . '">';

                   $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1');
                   $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = 'artistic_post_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');

                    if ($artdata) {
                        foreach ($artdata as $rowdata) {
                            $artname = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->art_name;
                            $artlastname = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->art_lastname;
                             $artslug = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->slug;

                            $return_html .= '<div class="all-comment-comment-box">
                                            <div class="post-design-pro-comment-img">';
                            $return_html .= '<a href="' . base_url('artistic/dashboard/' . $artslug) . '">';
                          $art_userimage = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id'], 'status' => 1))->row()->art_user_image;

                            if ($art_userimage) {
                                
                                if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                                                                $a = $artname;
                                                                $acr = substr($a, 0, 1);
                                                                $b = $artlastname;
                                                                $bcr = substr($b, 0, 1);

                                    $return_html .=  '<div class="post-img-div">';
                                    $return_html .=  ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                    $return_html .=  '</div>'; 

                                }else{

                                $return_html .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage . '"  alt="">';
                                  } 

                            } else {
                                $return_html .= '<a href="' . base_url('artistic/dashboard/' . $artslug) . '">';
                                          
                                                                $a = $artname;
                                                                $acr = substr($a, 0, 1);
                                                                $b = $artlastname;
                                                                $bcr = substr($b, 0, 1);

                                    $return_html .=  '<div class="post-img-div">';
                                    $return_html .=  ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                    $return_html .=  '</div>'; 

                                  
                            }
                                $return_html .= '</a>';
                            
                            $return_html .= '</div>
                                            <div class="comment-name">';
                                            $return_html .= '<a href="' . base_url('artistic/dashboard/' . $artslug) . '">
                                                <b title="' . ucfirst(strtolower($artname)) .' '.ucfirst(strtolower($artlastname)).'">';
                            $return_html .= $artname;
                            $return_html .= ' ';
                            $return_html .= $artlastname;

                            $return_html .= '</br>';

                            $return_html .= '</b></a>
                                            </div>
                                            <div class="comment-details" id="showcomment' . $rowdata['artistic_post_comment_id'] . '">';

                            $return_html .= '<div id="lessmore' . $rowdata['artistic_post_comment_id'] . '" style="display:block;">';
                            $small = substr($rowdata['comments'], 0, 180);
                            $return_html .= $this->common->make_links($small);

                            if (strlen($rowdata['comments']) > 180) {
                                $return_html .= '... <span id="kkkk" onClick="seemorediv(' . $rowdata['artistic_post_comment_id'] . ')">view More</span>';
                            }
                            $return_html .= '</div>';
                            $return_html .= '<div id="seemore' . $rowdata['artistic_post_comment_id'] . '" style="display:none;">';
                            $new_product_comment = $this->common->make_links($rowdata['comments']);
                            $return_html .= nl2br(htmlspecialchars_decode(htmlentities($new_product_comment, ENT_QUOTES, 'UTF-8')));
                            $return_html .= '</div>';
                            $return_html .= '</div>
                                            <div class="edit-comment-box">
                                                <div class="inputtype-edit-comment">
                                                    <div contenteditable="true" style="display:none" class="editable_text editav_2 custom-edit" name="' . $rowdata['artistic_post_comment_id'] . '"  id="editcomment' . $rowdata['artistic_post_comment_id'] . '" placeholder="Enter Your Comment " value= ""  onkeyup="commentedit(' . $rowdata['artistic_post_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $rowdata['comments'] . '</div>
                                                    <span class="comment-edit-button"><button id="editsubmit' . $rowdata['artistic_post_comment_id'] . '" style="display:none" onClick="edit_comment(' . $rowdata['artistic_post_comment_id'] . ')">Save</button></span>
                                                </div>
                                            </div>
                                            <div class="art-comment-menu-design"> 
                                                <div class="comment-details-menu" id="likecomment1' . $rowdata['artistic_post_comment_id'] . '">
                                                    <a id="' . $rowdata['artistic_post_comment_id'] . '" onClick="comment_like1(this.id)">';

                            $userid = $this->session->userdata('aileenuser');
                            $contition_array = array('artistic_post_comment_id' => $rowdata['artistic_post_comment_id'], 'status' => '1');
                            $artcommentlike = $this->data['artcommentlike'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                            $likeuserarray = explode(',', $artcommentlike[0]['artistic_comment_like_user']);
                            if (!in_array($userid, $likeuserarray)) {

                                $return_html .= '<i class="fa fa-thumbs-up fa-1x"  aria-hidden="true"></i>';
                            } else {
                                $return_html .= '<i class="fa fa-thumbs-up fa-1x main_color" aria-hidden="true">
                                                            </i>';
                            }
                            $return_html .= '<span>';

                            if ($rowdata['artistic_comment_likes_count']) {
                                $return_html .= $rowdata['artistic_comment_likes_count'];
                            }

                            $return_html .= '</span>
                                                    </a>
                                                </div>';
                            $userid = $this->session->userdata('aileenuser');
                            if ($rowdata['user_id'] == $userid) {

                                $return_html .= '<span role="presentation" aria-hidden="true"> · 
                                                    </span>
                                                    <div class="comment-details-menu">
                                                        <div id="editcommentbox' . $rowdata['artistic_post_comment_id'] . '" style="display:block;">
                                                            <a id="' . $rowdata['artistic_post_comment_id'] . '"   onClick="comment_editbox(this.id)" class="editbox">Edit
                                                            </a>
                                                        </div>
                                                        <div id="editcancle' . $rowdata['artistic_post_comment_id'] . '" style="display:none;">
                                                            <a id="' . $rowdata['artistic_post_comment_id'] . '" onClick="comment_editcancle(this.id)">Cancel
                                                            </a>
                                                        </div>
                                                    </div>';
                            }
                            $userid = $this->session->userdata('aileenuser');
                            $art_userid = $this->db->get_where('art_post', array('art_post_id' => $rowdata['art_post_id'], 'status' => 1))->row()->user_id;
                            
                            if ($rowdata['user_id'] == $userid || $art_userid == $userid) {

                                $return_html .= '<span role="presentation" aria-hidden="true"> · 
                                                    </span>
                                                    <div class="comment-details-menu">
                                                        <input type="hidden" name="post_delete"  id="post_delete' . $rowdata['artistic_post_comment_id'] . '" value= "' . $rowdata['artistic_post_comment_id'] . '">
                                                        <a id="' . $rowdata['artistic_post_comment_id'] . '"   onClick="comment_delete(this.id)"> Delete
                                                            <span class="insertcomment' . $rowdata['artistic_post_comment_id'] . '">
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
                        <div class="post-design-proo-img hidden-mob">';

                         $art_slug = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->slug;

                         $return_html .= '<a href="' . base_url('artistic/dashboard/' . $art_slug) . '">';

                    $userid = $this->session->userdata('aileenuser');
                    $art_userimage = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->art_user_image;
                     $art_userfn = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->art_name;
                      $art_userln = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->art_lastname;

                    if ($art_userimage) {

                        if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                                                                $a = $art_userfn;
                                                                $acr = substr($a, 0, 1);
                                                                $b = $art_userln;
                                                                $bcr = substr($b, 0, 1);

                                    $return_html .=  '<div class="post-img-div">';
                                    $return_html .=  ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                    $return_html .=  '</div>'; 

                                }else{
                        $return_html .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage . '"  alt="">';

                           }
                    } else {
                                                                $a = $art_userfn;
                                                                $acr = substr($a, 0, 1);
                                                                $b = $art_userln;
                                                                $bcr = substr($b, 0, 1);

                                    $return_html .=  '<div class="post-img-div">';
                                    $return_html .=  ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                    $return_html .=  '</div>'; 
                    }
                    $return_html .= '</a></div>

                        <div id="content" class="col-md-12  inputtype-comment cmy_2" >
                            <div contenteditable="true" class="edt_2 editable_text" name="' . $row['art_post_id'] . '"  id="post_comment' . $row['art_post_id'] . '" placeholder="Add a Comment ..." onClick="entercomment(' . $row['art_post_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);"></div>
                      
                      ' . form_error('post_comment') . ' 
                        <div class="mob-comment">       
                            <button id="' . $row['art_post_id'] . '" onClick="insert_comment(this.id)"><img src="../img/send.png">
                            </button>
                        </div>
                          </div>
                        <div class=" comment-edit-butn hidden-mob" >   
                           <button  id="'.$row['art_post_id'].'" onClick="insert_comment(this.id)">Comment</button> 
                        </div>

                    </div>
                    </div>
                    </div></div>';
                
        echo $return_html;
      }
    }

    // khyati changes end

    public function art_editpost($id) {
        $contition_array = array('art_post_id' => $id);
        $this->data['artdata'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('status' => 1, 'type' => 2);
        $this->data['skill1'] = $this->common->select_data_by_condition('skill', $contition_array, $data = '*', $sortby = 'skill', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        $skildata = explode(',', $this->data['artdata'][0]['art_category']);

        $this->data['selectdata'] = $skildata;
        $this->load->view('artistic/art_editpost', $this->data);
    }

    public function art_editpost_insert($id) {


        $skill = $this->input->post('skills');
        $skillname = $this->input->post('other_skill');


        $this->form_validation->set_rules('postname', 'Post name', 'required');

        $this->form_validation->set_rules('description', 'Post description', 'required');


        if ($this->form_validation->run() == FALSE) {
            $this->load->view('artistic/art_editpost');
        } else {

            $config['upload_path'] = 'uploads/art_images/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|mp4|3gp|pdf';

            $config['file_name'] = $_FILES['postattach']['name'];
            $config['upload_max_filesize'] = '40M';


            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('postattach')) {
                $uploadData = $this->upload->data();

                $picture = $uploadData['file_name'];
            } else {
                $picture = '';
            }

            if ($picture) {
                $data = array(
                    'art_post' => $this->input->post('postname'),
                    'art_category' => implode(',', $skill),
                    'other_skill' => $this->input->post('other_skill'),
                    'art_description' => $this->input->post('description'),
                    'art_attachment' => $picture,
                    'modifiled_date' => date('Y-m-d', time())
                );
            } else {
                $data = array(
                    'art_post' => $this->input->post('postname'),
                    'art_category' => implode(',', $skill),
                    'other_skill' => $this->input->post('other_skill'),
                    'art_description' => $this->input->post('description'),
                    'art_attachment' => $this->input->post('hiddenimg'),
                    'modifiled_date' => date('Y-m-d', time())
                );
            }

            $updatdata = $this->common->update_data($data, 'art_post', 'art_post_id', $id);

            $skilldata = $this->common->select_data_by_id('skill', 'skill', $skillname, $data = '*', $join_str = array());

            if ($skilldata || $skillname == "") {
                
            } else {
                $data1 = array(
                    'skill' => $this->input->post('other_skill'),
                );

                $insertid = $this->common->update_data($data1, 'skill', 'skill', $skillname);
            }
            if ($updatdata) {
                redirect('artistic/dashboard', refresh);
            } else {
                $this->session->flashdata('error', 'Your data not inserted');
                redirect('artistic/art_editpost', refresh);
            }
        }
    }

    public function art_deletepost() {

        $id = $_POST['art_post_id'];

         $condition_array = array('art_post_id' => $id);
        $profile_data = $this->common->select_data_by_condition('art_post', $condition_array, $data = 'status,user_id,is_delete,posted_user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($profile_data); die();
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

        // echo  $dataavl; die();
         if($return == 0){
            
           $datavl = "notavl";
            echo json_encode(
                        array(
                            "notavlpost" => $datavl,
                           
                ));

         }else{

        $data = array(
            'is_delete' => 1,
            'modifiled_date' => date('Y-m-d', time())
        );


        $updatdata = $this->common->update_data($data, 'art_post', 'art_post_id', $id);

        $data = array(
            'is_deleted' => 0,
            'modify_date' => date('Y-m-d', time())
        );


        $updatdata = $this->common->update_data($data, 'post_files', 'post_id', $id);


        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');


$contition_array = array('user_id' => $userid, 'status' => 1, 'is_delete' => '0');
$otherdata = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

$datacount = count($otherdata);



        if (count($otherdata) == 0) {
                    $notfound = '<div class="art_no_post_avl" id="no_post_avl">
         <h3> Post</h3>
          <div class="art-img-nn">
         <div class="art_no_post_img">

           <img src="'.base_url('img/art-no.png').'">
        
         </div>
         <div class="art_no_post_text">
           No Post Available.
         </div>
          </div>
       </div>';

                    $notvideo = 'Video Not Available';
                    $notaudio = 'Audio Not Available';
                    $notpdf = 'Pdf Not Available';
                    $notphoto = 'Photo Not Available';
                }

                // echo $notfound;
                // echo $datacount;
                // echo $notvideo;
                // echo $notaudio;
                // echo $notpdf;
                // echo $notphoto; die();

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

    }


    public function art_delete_post() {

         $id = $_POST['art_post_id'];

         $userid = $this->session->userdata('aileenuser');
        $condition_array = array('art_post_id' => $id);
        $profile_data = $this->common->select_data_by_condition('art_post', $condition_array, $data = 'status,user_id,is_delete,posted_user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($profile_data); die();
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

        // echo  $dataavl; die();
         if($return == 0){
            
           $datavl = "notavl";
            echo json_encode(
                        array(
                            "notavlpost" => $datavl,
                           
                ));

         }else{
        

        $data = array(
            'is_delete' => 1,
            'modifiled_date' => date('Y-m-d', time())
        );


        $updatdata = $this->common->update_data($data, 'art_post', 'art_post_id', $id);

        $data = array(
            'is_deleted' => 0,
            'modify_date' => date('Y-m-d', time())
        );


        $updatdata = $this->common->update_data($data, 'post_files', 'post_id', $id);


        $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($this->data['artisticdata']); die();
        $artregid = $this->data['artisticdata'][0]['art_id'];


         $contition_array = array('follow_from' => $artregid, 'follow_status' => '1', 'follow_type' => '1');
        $followerdata1 = $this->data['followerdata1'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($this->data['followerdata']); die();


        foreach ($followerdata1 as $fdata) {

            $user_id = $this->db->get_where('art_reg', array('art_id' => $fdata['follow_to'], 'status' => '1'))->row()->user_id;


            $contition_array = array('art_post.user_id' => $user_id, 'art_post.status' => '1', 'art_post.user_id !=' => $userid, 'art_post.is_delete' => '0');
            $this->data['art_data'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            $followerabc[] = $this->data['art_data'];
        }

        //echo "<pre>"; print_r($followerabc); die();
//data fatch using follower end
//data fatch using skill start

        $userselectskill = $this->data['artisticdata'][0]['art_skill'];
        //echo  $userselectskill; die();
        $contition_array = array('art_skill' => $userselectskill, 'status' => '1' , 'art_step' => 4);
        $skilldata = $this->data['skilldata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($this->data['skilldata']); die();

        foreach ($skilldata as $fdata) {


            $contition_array = array('art_post.user_id' => $fdata['user_id'], 'art_post.status' => '1', 'art_post.user_id !=' => $userid, 'art_post.is_delete' => '0');

            $this->data['art_data'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $skillabc[] = $this->data['art_data'];
        }


//data fatch using skill end
//data fatch using login user last post start
        $contition_array = array('art_post.user_id' => $userid, 'art_post.status' => '1', 'art_post.is_delete' => '0');

        $art_userdata = $this->data['art_userdata'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = 'art_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if (count($art_userdata) > 0) {
            $userabc[][] = $this->data['art_userdata'][0];
        } else {
            $userabc[] = $this->data['art_userdata'][0];
        }
        //echo "<pre>"; print_r($userabc); die();
        //echo "<pre>"; print_r($skillabc);  die();
//data fatch using login user last post end
//echo count($skillabc);
//echo count($userabc);
//echo count($unique);
//echo count($followerabc); 


        if (count($skillabc) == 0 && count($userabc) != 0) {
            $unique = $userabc;
        } elseif (count($userabc) == 0 && count($skillabc) != 0) {
            $unique = $skillabc;
        } elseif (count($userabc) != 0 && count($skillabc) != 0) {
            $unique = array_merge($skillabc, $userabc);
        }

        //echo "<pre>"; print_r($userabc); die();
        //echo count($followerabc);  echo count($unique); die();

        if (count($followerabc) == 0 && count($unique) != 0) {
            $unique_user = $unique;
        } elseif (count($unique) == 0 && count($followerabc) != 0) {

            $unique_user = $followerabc;
        } elseif (count($unique) != 0 && count($followerabc) != 0) {
            $unique_user = array_merge($unique, $followerabc);
        }



        foreach ($unique_user as $key1 => $val1) {
            foreach ($val1 as $ke => $va) {

                $qbc[] = $va;
            }
        }


        $qbc = array_unique($qbc, SORT_REGULAR);
        //echo "<pre>"; print_r($qbc); die();
        // sorting start

        $post = array();

        //$i =0;
        foreach ($qbc as $key => $row) {
            $post[$key] = $row['art_post_id'];
         }

        array_multisort($post, SORT_DESC, $qbc);
        // echo '<pre>';
        // print_r($qbc);
        // exit;
        $otherdata = $qbc;


         if (count($otherdata) > 0) { 
             foreach ($otherdata as $row) {
                 //  echo '<pre>'; print_r($finalsorting); die();
                 $userid = $this->session->userdata('aileenuser');
         
                 $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1');
                 $artdelete = $this->data['artdelete'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
         
                 $likeuserarray = explode(',', $artdelete[0]['delete_post']);
         
                 if (!in_array($userid, $likeuserarray)) {}else{

                    $count[] = "abc";
                 }

                  }
  } 
//echo count($otherdata); die();
  if(count($otherdata) > 0){ 
          if(count($count) == count($otherdata)){ 
        
                    $datacount = "count";


                    $notfound = '<div class="art_no_post_avl" id="no_post_avl">
         <h3> Post</h3>
          <div class="art-img-nn">
         <div class="art_no_post_img">

           <img src="'.base_url('img/art-no.png').'">
        
         </div>
         <div class="art_no_post_text">
           No Post Available.
         </div>
          </div>
       </div>';
                
            } }else{ 

                    $datacount = "count";

                    $notfound = '<div class="art_no_post_avl" id="no_post_avl">
         <h3> Post</h3>
          <div class="art-img-nn">
         <div class="art_no_post_img">

           <img src="'.base_url('img/art-no.png').'">
        
         </div>
         <div class="art_no_post_text">
           No Post Available.
         </div>
          </div>
       </div>';
                
            }

            echo json_encode(
                        array(
                            "notfound" => $notfound,
                            "notcount" => $datacount,
                ));


   }

    }




    public function artistic_contactperson($id) {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End
        $contition_array = array('user_id' => $id , 'art_step' => 4);
        $this->data['contactperson'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

             $contition_array = array('status' => '1', 'is_delete' => '0' , 'art_step' => 4);


        $artdata = $this->data['results'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_name,art_lastname,designation,other_skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);


        $return_array = array();
        //echo  $return_array;

        foreach ($artdata as $get) {
            $return = array();
            $return = $get;


            $return['firstname'] = $get['art_name'] . " " . $get['art_lastname'];
            unset($return['art_name']);
            unset($return['art_lastname']);

            array_push($return_array, $return);
            //echo $returnarray; 
        }

        // $contition_array = array('status' => '1');
        // $artpost= $this->data['results'] =  $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        $contition_array = array('status' => '1', 'type' => '2');

        $artpost = $this->data['results'] = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        // echo "<pre>"; print_r($artpost);die();


        $uni = array_merge($return_array, $artpost);
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

        $this->load->view('artistic/artistic_contactperson', $this->data);
    }

    public function artistic_contactperson_query($id) {


        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $contition_array = array('user_id' => $id ,'art_step' => 4);
        $this->data['contactperson'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        $email = $this->input->post('email');

        $toemail = $this->input->post('toemail');
        $userdata = $this->common->select_data_by_id('user', 'user_id', $userid, $data = '*', $join_str = array());

        $msg = 'Hey !' . " " . $this->data['contactperson'][0]['art_name'] . "<br/>" .
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
            'contact_type' => 1,
            'created_date' => date('Y-m-d H:i:s', time()),
            'status' => 'contact_person',
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
            'not_active' => 1,
            'not_created_date' => date('Y-m-d H:i:s')
        );

        $insert_id = $this->common->insert_data_getid($data, 'notification');

        if ($insertdata) {

            redirect('artistic/home', refresh);
        } else {
            $this->session->flashdata('error', 'Your data not inserted');
            redirect('artistic/artistic_contactperson/' . $id, refresh);
        }
//insert contact person notifiaction end           
    }

    public function art_user_post($id) {

        $this->data['userid'] = $id;
        $user_name = $this->session->userdata('user_name');


        $this->data['usdata'] = $this->common->select_data_by_id('user', 'user_id', $id, $data = '*', $join_str = array());


        $contition_array = array('user_id' => $id);
        $this->data['artdata'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->load->view('artistic/art_manage_post', $this->data);
    }

    public function user_image_insert() {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End


        if ($this->input->post('cancel1')) {
            redirect('artistic/home', refresh);
        } elseif ($this->input->post('cancel2')) {
            redirect('artistic/art_savepost', refresh);
        } elseif ($this->input->post('cancel3')) {
            redirect('artistic/art_addpost', refresh);
        } elseif ($this->input->post('cancel4')) {
            redirect('artistic/artistic_profile', refresh);
        } elseif ($this->input->post('cancel5')) {
            redirect('artistic/dashboard', refresh);
        } elseif ($this->input->post('cancel6')) {
            redirect('artistic/userlist', refresh);
        } elseif ($this->input->post('cancel7')) {
            redirect('artistic/following', refresh);
        } elseif ($this->input->post('cancel8')) {
            redirect('artistic/followers', refresh);
        }

        if (empty($_FILES['profilepic']['name'])) {
            $this->form_validation->set_rules('profilepic', 'Upload profilepic', 'required');
        } else {
//            $config['upload_path'] = 'uploads/art_images/';
//            $config['allowed_types'] = 'jpg|jpeg|png|gif|mp4|3gp|mpeg|mpg|mpe|qt|mov|avi|pdf';
//
//            $config['file_name'] = $_FILES['profilepic']['name'];
//
//            $this->load->library('upload', $config);
//            $this->upload->initialize($config);
//
//            if ($this->upload->do_upload('profilepic')) {
//                $uploadData = $this->upload->data();
//
//                $picture = $uploadData['file_name'];
//            } else {
//                $picture = '';
//            }

            $user_image = '';
            $user['upload_path'] = $this->config->item('art_profile_main_upload_path');
            $user['allowed_types'] = $this->config->item('art_profile_main_allowed_types');
            $user['max_size'] = $this->config->item('art_profile_main_max_size');
            $user['max_width'] = $this->config->item('art_profile_main_max_width');
            $user['max_height'] = $this->config->item('art_profile_main_max_height');
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
                $user_thumb['new_image'] = $this->config->item('art_profile_thumb_upload_path') . $imgdata['file_name'];
                $user_thumb['create_thumb'] = TRUE;
                $user_thumb['maintain_ratio'] = TRUE;
                $user_thumb['thumb_marker'] = '';
                $user_thumb['width'] = $this->config->item('art_profile_thumb_width');
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
                $redirect_url = site_url('artistic');
                redirect($redirect_url, 'refresh');
            } else {

                $contition_array = array('user_id' => $userid);
                $user_reg_data = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $user_reg_prev_image = $user_reg_data[0]['art_user_image'];

                if ($user_reg_prev_image != '') {
                    $user_image_main_path = $this->config->item('art_profile_main_upload_path');
                    $user_bg_full_image = $user_image_main_path . $user_reg_prev_image;
                    if (isset($user_bg_full_image)) {
                        unlink($user_bg_full_image);
                    }

                    $user_image_thumb_path = $this->config->item('art_profile_thumb_upload_path');
                    $user_bg_thumb_image = $user_image_thumb_path . $user_reg_prev_image;
                    if (isset($user_bg_thumb_image)) {
                        unlink($user_bg_thumb_image);
                    }
                }

                $user_image = $imgdata['file_name'];
            }

            $data = array(
                'art_user_image' => $user_image,
                'modified_date' => date('Y-m-d', time())
            );


            $updatdata = $this->common->update_data($data, 'art_reg', 'user_id', $userid);

            if ($updatdata) {
                if ($this->input->post('hitext') == 1) {
                    redirect('artistic/home', refresh);
                } elseif ($this->input->post('hitext') == 2) {
                    redirect('artistic/art_savepost', refresh);
                } elseif ($this->input->post('hitext') == 3) {
                    redirect('artistic/art_addpost', refresh);
                } elseif ($this->input->post('hitext') == 4) {
                    redirect('artistic/artistic_profile', refresh);
                } elseif ($this->input->post('hitext') == 5) {
                    redirect('artistic/dashboard', refresh);
                } elseif ($this->input->post('hitext') == 6) {
                    redirect('artistic/userlist', refresh);
                } elseif ($this->input->post('hitext') == 7) {
                    redirect('artistic/following', refresh);
                } elseif ($this->input->post('hitext') == 8) {
                    redirect('artistic/followers', refresh);
                } elseif ($this->input->post('hitext') == 9) {
                    redirect('artistic/art_photos', refresh);
                } elseif ($this->input->post('hitext') == 10) {
                    redirect('artistic/art_videos', refresh);
                } elseif ($this->input->post('hitext') == 11) {
                    redirect('artistic/art_audios', refresh);
                } elseif ($this->input->post('hitext') == 12) {
                    redirect('artistic/art_pdf', refresh);
                }
            } else {
                $this->session->flashdata('error', 'Your data not inserted');
                redirect('artistic/home', refresh);
            }
        }
    }

    public function artistic_profile($id = "") {


        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End
        $this->data['id'] = $id;

        $contition_array = array('user_id' => $userid, 'status' => '1');
            $artslug = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($id == $userid || $id == '' || $id == $artslug[0]['slug']) {

            $contition_array = array('user_id' => $userid, 'status' => '1');
            $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {

            $contition_array = array('slug' => $id, 'status' => '1' , 'art_step' => 4);
            $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }

        if($this->data['artisticdata']){

            $artistic_name = $this->get_artistic_name($id);
      $this->data['title'] = $artistic_name.TITLEPOSTFIX;
            $this->data['artistic_common'] = $this->load->view('artistic/artistic_common', $this->data, true);
        $this->load->view('artistic/artistic_profile', $this->data);
       }else if(!$this->data['artisticdata'] && $id != $userid){

        $this->load->view('artistic/notavalible');  

       }
        else if(!$this->data['artisticdata'] && ($id == $userid || $id == "")){
       redirect('artistic/');
       }
    }

//keyskill automatic retrieve cobtroller start
    public function keyskill() {
        $json = [];
        $where = "type='2' AND status='1'";



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
//location automatic retrieve cobtroller start
    public function location() {
        $json = [];

        $this->load->database('aileensoul');


        if (!empty($this->input->get("q"))) {
     $search_condition = "(city_name LIKE '" . trim($this->input->get("q")) . "%')";

     $tolist = $this->common->select_data_by_search('cities', $search_condition,$contition_array = array(), $data = 'city_id as id,city_name as text', $sortby = 'city_name', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
   
//echo '<pre>'; print_r($tolist); die();
     }
      
        echo json_encode($tolist);
        }

//location automatic retrieve cobtroller End
// user list of artistic users

    public function userlist() {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End
        $artdata = $this->data['artdata'] = $this->common->select_data_by_id('art_reg', 'user_id', $userid, $data = '*');

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if($this->data['artisticdata']){
       $this->data['left_artistic'] =  $this->load->view('artistic/left_artistic', $this->data, true);
       $artistic_name = $this->get_artistic_name($id);
      $this->data['title'] = $artistic_name.TITLEPOSTFIX;
        $this->load->view('artistic/artistic_userlist', $this->data);
        }else{
       redirect('artistic/');
       }
    }


public function ajax_userlist() {

        $perpage = 7;
       $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
           $page = $_GET["page"];
       }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;

        $userid = $this->session->userdata('aileenuser');

        $artdata = $this->common->select_data_by_id('art_reg', 'user_id', $userid, $data = '*');
        $contition_array = array('user_id' => $userid);
        $artisticdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $limit = $perpage;
        $offset = $start;

        $contition_array = array('art_step' => 4, 'is_delete' => 0, 'status' => 1, 'user_id !=' => $userid);
        $userlist = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = 'art_id', $orderby = 'DESC', $limit, $offset, $join_str = array(), $groupby = '');
        $userlist1 = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = 'art_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('user_id' => $userid, 'is_delete' => 0, 'status' => 1);
        $artisticdata1 = $artisticdata1 = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
// followers count
        $join_str[0]['table'] = 'follow';
        $join_str[0]['join_table_id'] = 'follow.follow_to';
        $join_str[0]['from_table_id'] = 'art_reg.art_id';
        $join_str[0]['join_type'] = '';

        $contition_array = array('follow_to' => $artdata[0]['art_id'], 'follow_status' => 1, 'follow_type' => 1, 'art_reg.art_step' => 4);
        $followers = count($this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = ''));

// follow count end
// fllowing count
        $join_str[0]['table'] = 'follow';
        $join_str[0]['join_table_id'] = 'follow.follow_from';
        $join_str[0]['from_table_id'] = 'art_reg.art_id';
        $join_str[0]['join_type'] = '';

        $contition_array = array('follow_from' => $artdata[0]['art_id'], 'follow_status' => 1, 'follow_type' => 1, 'art_reg.art_step' => 4);
        $following = count($this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = ''));

//following end

        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($userlist1);
        }
        $return_html = '';
        $return_html .= '<input type="hidden" class="page_number" value="' . $page . '" />';
        $return_html .= '<input type="hidden" class="total_record" value="' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';


        foreach ($userlist as $user) {
            $return_html .= '
                                                <div class="profile-job-post-detail clearfix">
                                                    <div class="profile-job-post-title-inside clearfix">
                                                        <div class="profile-job-post-location-name">
                                                            <div class="user_lst"><ul>
                                                                <li class="fl padding_less_left">
                                                                        <div class="follow-img">';
            if ($user['art_user_image'] != '') {
                $return_html .= '<a href="' . base_url('artistic/dashboard/' . $user['slug']) . '">';
                if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $user['art_user_image'])) {
                                            $a = $user['art_name'];
                                            $acr = substr($a, 0, 1);
                                            $b = $user['art_lastname'];
                                            $bcr = substr($b, 0, 1);
                    $return_html .=  '<div class="post-img-userlist">';
                    $return_html .=    ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                    $return_html .= '</div>'; 

                } else {

                    $return_html .= '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $user['art_user_image'] . '" height="50px" width="50px" alt="" >';
                }
                $return_html .= '</a>';
            } else {
                $return_html .= '<a href="' . base_url('artistic/dashboard/' . $user['slug']) . '">';
                                            $a = $user['art_name'];
                                            $acr = substr($a, 0, 1);
                                            $b = $user['art_lastname'];
                                            $bcr = substr($b, 0, 1);
                    $return_html .=  '<div class="post-img-userlist">';
                    $return_html .=    ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                    $return_html .= '</div>';   

                $return_html .=   '</a>';
            }
            $return_html .= '</div>
                                        </li>
                                                <li class="folle_text">
                                                     <div class="">
                                                     <div class="follow-li-text " style="padding: 0;">
                                                <a title="' . ucfirst(strtolower($user['art_name'])) .'&nbsp;'. ucfirst(strtolower($user['art_lastname'])) . '" href="' . base_url('artistic/dashboard/' . $user['slug']) . '">' . ucfirst(strtolower($user['art_name'])) .'&nbsp;'. ucfirst(strtolower($user['art_lastname'])) .'</a>
                                                                            </div>
                                                                            <div>';
            
            $return_html .= '<a>';
            if ($user['designation']) {
                $return_html .= ucfirst(strtolower($user['designation']));
            } else {
                $return_html .= 'Current Work';
            }
            $return_html .= '</a>
                                                                            </div>
                                                                    </li>
                                                                    <li class="fruser' . $user['art_id'] . ' fr">';

            $status = $this->db->get_where('follow', array('follow_type' => 1, 'follow_from' => $artdata[0]['art_id'], 'follow_to' => $user['art_id']))->row()->follow_status;
            if ($status == 0 || $status == " ") {
                $return_html .= '<div id= "followdiv " class="user_btn">
                                                                                <button id="follow' . $user['art_id'] . '" onClick="followuser(' . $user['art_id'] . ')">
                                                                                  <span> Follow </span>
                                                                                </button></div>';
            } elseif ($status == 1) {
                $return_html .= '<div id= "unfollowdiv"  class="user_btn" > 
                                                                                <button class="bg_following" id="unfollow' . $user['art_id'] . '" onClick="unfollowuser(' . $user['art_id'] . ')">
                                                                                 <span>   Following </span>
                                                                                </button></div>';
            }
            $return_html .= '</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            ';
        }
        echo $return_html;
    }



    public function follow() { //echo "2"; die();
        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $art_id = $_POST["follow_to"];

        $artdata = $this->common->select_data_by_id('art_reg', 'user_id', $userid, $data = '*');

        $contition_array = array('follow_type' => 1, 'follow_from' => $artdata[0]['art_id'], 'follow_to' => $art_id);
        $follow = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        //  echo "<pre>"; print_r($follow); die();

        $contition_array = array('art_id' => $art_id, 'status' => 1, 'is_delete' => 0 ,'art_step' => 4);
        $followuserid = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');



            // insert notification


            $contition_array = array('not_type' => 8, 'not_from_id' => $userid, 'not_to_id' => $followuserid[0]['user_id'], 'not_product_id' => $follow[0]['follow_id'], 'not_from' => 3);
            $artnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            //echo "<pre>"; print_r($artnotification); die();
                if ($artnotification[0]['not_read'] == 2) {//echo "11"; die();
                    
                } elseif ($artnotification[0]['not_read'] == 1) {//echo "22"; die();

                    $datafollow = array(
                        'not_read' => 2,
                        'not_created_date' => date('Y-m-d H:i:s')

                    );

                    $where = array('not_type' => 8, 'not_from_id' => $userid, 'not_to_id' => $followuserid[0]['user_id'], 'not_product_id' => $follow[0]['follow_id'], 'not_from' => 3);
                    $this->db->where($where);
                    $updatdata = $this->db->update('notification', $datafollow);
                } 

//             $data = array(
//                 'not_type' => 8,
//                 'not_from_id' => $userid,
//                 'not_to_id' => $followuserid[0]['user_id'],
//                 'not_read' => 2,
//                 'not_product_id' => $follow[0]['follow_id'],
//                 'not_from' => 3,
//                 'not_active' => 1,
//                 'not_created_date' => date('Y-m-d H:i:s')
//             );
// //echo '<pre>'; print_r($data); die();
//             $insert_id = $this->common->insert_data_getid($data, 'notification');
            // end notoification


        if ($follow) {
            $data = array(
                'follow_type' => 1,
                'follow_from' => $artdata[0]['art_id'],
                'follow_to' => $art_id,
                'follow_status' => 1,
            );
            $update = $this->common->update_data($data, 'follow', 'follow_id', $follow[0]['follow_id']);



       $contition_array = array('follow_type' => 1, 'follow_from' => $artdata[0]['art_id'], 'follow_status' => 1);
        $followcount = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($update) {


                $follow = '<div id= "unfollowdiv" class="user_btn">';
                $follow .= '<button class="bg_following" id="unfollow' . $art_id . '" onClick="unfollowuser(' . $art_id . ')">
                           <span>    Following </span>
                      </button>';
                $follow .= '</div>';
                
               $datacount = '('.count($followcount).')';


                 echo json_encode(
                        array(
                            "follow" => $follow,
                            "count" => $datacount,
                ));
            }
        } else {
            $data = array(
                'follow_type' => 1,
                'follow_from' => $artdata[0]['art_id'],
                'follow_to' => $art_id,
                'follow_status' => 1,
            );
            $insert = $this->common->insert_data_getid($data, 'follow');

            // insert notification

            $data = array(
                'not_type' => 8,
                'not_from_id' => $userid,
                'not_to_id' => $followuserid[0]['user_id'],
                'not_read' => 2,
                'not_product_id' => $insert,
                'not_from' => 3,
                'not_active' => 1,
                'not_created_date' => date('Y-m-d H:i:s')
            );

            $insert_id = $this->common->insert_data_getid($data, 'notification');
            // end notoification


        $contition_array = array('follow_type' => 1, 'follow_from' => $artdata[0]['art_id'], 'follow_status' => 1);
        $followcount = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($insert) {

                $follow = '<div id= "unfollowdiv" class="user_btn">';
                $follow .= '<button class="bg_following" id="unfollow' . $art_id . '" onClick="unfollowuser(' . $art_id . ')">
                             <span>  Following </span>
                      </button>';
                $follow .= '</div>';

                $datacount = '('.count($followcount).')';


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

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $art_id = $_POST["follow_to"];

        $artdata = $this->common->select_data_by_id('art_reg', 'user_id', $userid, $data = '*');

        $contition_array = array('follow_type' => 1, 'follow_from' => $artdata[0]['art_id'], 'follow_to' => $art_id);

        $follow = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');




        if ($follow) {
            $data = array(
                'follow_type' => 1,
                'follow_from' => $artdata[0]['art_id'],
                'follow_to' => $art_id,
                'follow_status' => 0,
            );
            $update = $this->common->update_data($data, 'follow', 'follow_id', $follow[0]['follow_id']);



            $contition_array = array('follow_type' => 1, 'follow_from' => $artdata[0]['art_id'], 'follow_status' => 1);

            $followcount = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            

            if ($update) {


                $unfollow = '<div id= "followdiv" class="user_btn"><button id="follow' . $art_id . '" onClick="followuser(' . $art_id . ')">
                             <span>  Follow </span>
                      </button></div>';

                $datacount = '('.count($followcount).')';
                //$datacount = 1;


                 echo json_encode(
                        array(
                            "follow" => $unfollow,
                            "count" => $datacount,
                ));


            }
        }
    }


public function follow_home() { //echo "2"; die();
        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $art_id = $_POST["follow_to"];

        $artdata = $this->common->select_data_by_id('art_reg', 'user_id', $userid, $data = '*');

        $contition_array = array('follow_type' => 1, 'follow_from' => $artdata[0]['art_id'], 'follow_to' => $art_id);
        $follow = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        //  echo "<pre>"; print_r($follow); die();

        $contition_array = array('art_id' => $art_id, 'status' => 1, 'is_delete' => 0 ,'art_step' => 4);
        $followuserid = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');



            // insert notification


            $contition_array = array('not_type' => 8, 'not_from_id' => $userid, 'not_to_id' => $followuserid[0]['user_id'], 'not_product_id' => $follow[0]['follow_id'], 'not_from' => 3);
            $artnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            //echo "<pre>"; print_r($artnotification); die();
                if ($artnotification[0]['not_read'] == 2) {//echo "11"; die();
                    
                } elseif ($artnotification[0]['not_read'] == 1) {//echo "22"; die();

                    $datafollow = array(
                        'not_read' => 2,
                        'not_created_date' => date('Y-m-d H:i:s')

                    );

                    $where = array('not_type' => 8, 'not_from_id' => $userid, 'not_to_id' => $followuserid[0]['user_id'], 'not_product_id' => $follow[0]['follow_id'], 'not_from' => 3);
                    $this->db->where($where);
                    $updatdata = $this->db->update('notification', $datafollow);
                } 

        if ($follow) {
            $data = array(
                'follow_type' => 1,
                'follow_from' => $artdata[0]['art_id'],
                'follow_to' => $art_id,
                'follow_status' => 1,
            );
            $update = $this->common->update_data($data, 'follow', 'follow_id', $follow[0]['follow_id']);



       $contition_array = array('follow_type' => 1, 'follow_from' => $artdata[0]['art_id'], 'follow_status' => 1);
        $followcount = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($update) {


                $follow = '<div id="unfollowdiv">';
                /*  $follow = '<button id="unfollow' . $art_id.'" onClick="unfollowuser('.$art_id.')"><span><span>Following</span></span></button>';
                  $follow .= '</div>'; */
                $follow .= '<button class="bg_following" id="unfollow' . $art_id . '" onClick="unfollowuser(' . $art_id . ')"><span>Following</span></button>';
                $follow .= '</div>';
                
               $datacount = '('.count($followcount).')';
                $is_follow = 1;

                //  echo json_encode(
                //         array(
                //             "follow" => $follow,
                //             "count" => $datacount,
                // ));
            }
        } else {
            $data = array(
                'follow_type' => 1,
                'follow_from' => $artdata[0]['art_id'],
                'follow_to' => $art_id,
                'follow_status' => 1,
            );
            $insert = $this->common->insert_data_getid($data, 'follow');

            // insert notification

            $data = array(
                'not_type' => 8,
                'not_from_id' => $userid,
                'not_to_id' => $followuserid[0]['user_id'],
                'not_read' => 2,
                'not_product_id' => $insert,
                'not_from' => 3,
                'not_active' => 1,
                'not_created_date' => date('Y-m-d H:i:s')
            );

            $insert_id = $this->common->insert_data_getid($data, 'notification');
            // end notoification


        $contition_array = array('follow_type' => 1, 'follow_from' => $artdata[0]['art_id'], 'follow_status' => 1);
        $followcount = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($insert) {

               $follow = '<div id="unfollowdiv">';
                /*  $follow = '<button id="unfollow' . $art_id.'" onClick="unfollowuser('.$art_id.')"><span><span>Following</span></span></button>';
                  $follow .= '</div>'; */
                $follow .= '<button class="bg_following" id="unfollow' . $art_id . '" onClick="unfollowuser(' . $art_id . ')"><span>Following</span></button>';
                $follow .= '</div>';

                $datacount = '('.count($followcount).')';
                 $is_follow = 1;

            }
        }

        if ($is_follow == 1) {
            $third_user_html = $this->third_follow_user_data();
        echo json_encode(
                        array(
                            "follow" => $follow,
                            "count" => $datacount,
                            "third_user" => $third_user_html,
                ));
        }
    }


     public function third_follow_user_data(){
        
        $userid = $this->session->userdata('aileenuser');
        
        // GET USER ARTISTIC DATA START
            $contition_array = array('user_id' => $userid, 'status' => '1');
            $artisticdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_name,art_lastname,art_user_image,art_skill,art_city,art_state, slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

          $art_id = $artisticdata[0]['art_id'];
          $art_skill = $artisticdata[0]['art_skill'];
          $city = $artisticdata[0]['art_city'];
          $state = $artisticdata[0]['art_state'];
            // GET USER ARTISTIC DATA END
            // GET ARTISTIC USER FOLLOWING LIST START
            $contition_array = array('follow_from' => $art_id, 'follow_status' => 1, 'follow_type' => 1);
            $followdata = $this->common->select_data_by_condition('follow', $contition_array, $data = 'GROUP_CONCAT(follow_to) as follow_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = 'follow_from');
            $follow_list = $followdata[0]['follow_list'];
            $follow_list = str_replace(",", "','", $followdata[0]['follow_list']);
            // GET ARTISTIC USER FOLLOWING LIST END
            // GET ARTISTIC USER IGNORE LIST START
            $contition_array = array('user_from' => $art_id, 'profile' => 1);
            $userdata = $this->common->select_data_by_condition('user_ignore', $contition_array, $data = 'GROUP_CONCAT(user_to) as user_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = 'user_from');
            $user_list = $followdata[0]['user_list'];
            $user_list = str_replace(",", "','", $userdata[0]['user_list']);
            // GET ARTISTIC USER IGNORE LIST END
            //GET ARTISTIC USER SUGGESTED USER LIST 
            $contition_array = array('is_delete' => 0, 'status' => 1, 'user_id != ' => $userid, 'art_step' => 4);
        $search_condition = "((art_skill IN ('$art_skill')) OR (art_city = '$city') OR (art_state = '$state')) AND art_id NOT IN ('$follow_list') AND art_id NOT IN ('$user_list')";

        $userlistview = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = 'art_id, art_name, art_lastname, art_user_image, art_skill, art_city, art_state, user_id, slug', $sortby = 'CASE WHEN (art_city = ' . $city . ') THEN art_id END, CASE WHEN (art_state = ' . $state . ') THEN art_id END', $orderby = 'DESC', $limit = '1', $offset = '3', $join_str_contact = array(), $groupby = '');

            $third_user_html = '';
            if (count($userlistview) > 0) {
               foreach ($userlistview as $userlist) {
                $userid = $this->session->userdata('aileenuser');
                $followfrom = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->art_id;
                $contition_array = array('follow_to' => $userlist['art_id'], 'follow_from' => $followfrom, 'follow_status' => '1', 'follow_type' => '1');
                $artfollow = $this->data['artfollow'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '1', $offset = '', $join_str = array(), $groupby = '');
                    if (!$artfollow) {

                        $third_user_html .= '<li class="follow_box_ul_li fad' . $userlist['art_id'] . '" id = "fad' . $userlist['art_id'] . '">
                                                <div class="contact-frnd-post follow_left_main_box"><div class="profile-job-post-title-inside clearfix">
                                                                    <div class=" col-md-12 follow_left_box_main">                   
                                                                        <div class="post-design-pro-img_follow">';
                    if ($userlist['art_user_image']) {

                        $third_user_html .= '<a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucfirst(strtolower($userlist['art_name'])) . ucfirst(strtolower($userlist['art_lastname'])) . '">';

                        if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $userlist['art_user_image'])) {
                                                                $a = $userlist['art_name'];
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userlist['art_lastname'];
                                                                $bcr = substr($b, 0, 1);

                                  $third_user_html .= '<div class="post-img-div">';
                                  $third_user_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                  $third_user_html .= '</div>'; 

                                    }else{

                        $third_user_html .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $userlist['art_user_image'] . '"  alt="">';

                        }
                        $third_user_html .= '</a>';

                    } else {
                        $third_user_html .= '<a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucwords($userlist['art_name']) . '">';
                                                                                    
                                                                $a = $userlist['art_name'];
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userlist['art_lastname'];
                                                                $bcr = substr($b, 0, 1);

                                  $third_user_html .= '<div class="post-img-div">';
                                  $third_user_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                  $third_user_html .= '</div>'; 

                         $third_user_html .= '</a>';
                    }
                    $third_user_html .= '</div>
                                <div class="post-design-name_follow fl">
                                     <ul><li>
                                    <div class="post-design-product_follow">';
                    $third_user_html .= '<a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucfirst(strtolower($userlist['art_name'])) . ucfirst(strtolower($userlist['art_lastname'])) .'">
                            <h6>' . ucfirst(strtolower($userlist['art_name'])) . ucfirst(strtolower($userlist['art_lastname'])) . '</h6>
                            </a> 
                            </div>
                        </li>';
                    
                    $third_user_html .= '<li>
                        <div class="post-design-product_follow_main" style="display:block;">
                           <a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucfirst(strtolower($userlist['art_name'])) .' '. ucfirst(strtolower($userlist['art_lastname'])) . '">
                    <p>';
                    if ($userlist['designation']) {
                        $third_user_html .= $userlist['designation'];
                    } else {
                        $third_user_html .= 'Current Work';
                    }

                    $third_user_html .= '</p>
                                     </a>
                                    </div>
                                    </li>
                                    </ul> 
                                    </div>  
                            <div class="follow_left_box_main_btn">';
                    $third_user_html .= '<div class="fr' . $userlist['art_id'] . '">
                            <button id="followdiv' . $userlist['art_id'] . '" onClick="followuser(' . $userlist['art_id'] . ')"><span>Follow</span>
                            </button>
                            </div>
                            </div>
                            <span class="Follow_close" onClick="followclose(' . $userlist['art_id'] . ')">
                            <i class="fa fa-times" aria-hidden="true">
                            </i>
                        </span>
                        </div>
                </div></div></li>';
                    }
                }
            }
            
            return $third_user_html;
    }
    public function third_follow_ignore_user_data(){
        
        $userid = $this->session->userdata('aileenuser');
        
        // GET USER ARTISTIC DATA START
            $contition_array = array('user_id' => $userid, 'status' => '1');
            $artisticdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_name,art_lastname,art_user_image,art_skill,art_city,art_state, slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $art_id = $artisticdata[0]['art_id'];
            $art_skill = $artisticdata[0]['art_skill'];
            $city = $artisticdata[0]['art_city'];
             $state = $artisticdata[0]['art_state'];
            // GET USER ARTISTIC DATA END
            // GET ARTISTIC USER FOLLOWING LIST START
            $contition_array = array('follow_from' => $art_id, 'follow_status' => 1, 'follow_type' => 1);
            $followdata = $this->common->select_data_by_condition('follow', $contition_array, $data = 'GROUP_CONCAT(follow_to) as follow_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = 'follow_from');
            $follow_list = $followdata[0]['follow_list'];
            $follow_list = str_replace(",", "','", $followdata[0]['follow_list']);
            // GET ARTISTIC USER FOLLOWING LIST END
            // GET ARTISTIC USER IGNORE LIST START
            $contition_array = array('user_from' => $art_id, 'profile' => 1);
            $userdata = $this->common->select_data_by_condition('user_ignore', $contition_array, $data = 'GROUP_CONCAT(user_to) as user_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = 'user_from');
            $user_list = $followdata[0]['user_list'];
            $user_list = str_replace(",", "','", $userdata[0]['user_list']);
            // GET ARTISTIC USER IGNORE LIST END
            //GET ARTISTIC USER SUGGESTED USER LIST 
            $contition_array = array('is_delete' => 0, 'status' => 1, 'user_id != ' => $userid, 'art_step' => 4);
        $search_condition = "((art_skill IN ('$art_skill')) OR (art_city = '$city') OR (art_state = '$state')) AND art_id NOT IN ('$follow_list') AND art_id NOT IN ('$user_list')";

        $userlistview = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = 'art_id, art_name, art_lastname, art_user_image, art_skill, art_city, art_state, user_id, slug', $sortby = 'CASE WHEN (art_city = ' . $city . ') THEN art_id END, CASE WHEN (art_state = ' . $state . ') THEN art_id END', $orderby = 'DESC', $limit = '1', $offset = '3', $join_str_contact = array(), $groupby = '');
        //echo "<pre>"; print_r($userlistview); die();

            $third_user_html = '';
            if (count($userlistview) > 0) {
                foreach ($userlistview as $userlist) {
                    $userid = $this->session->userdata('aileenuser');
                $followfrom = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->art_id;
                $contition_array = array('follow_to' => $userlist['art_id'], 'follow_from' => $followfrom, 'follow_status' => '1', 'follow_type' => '1');
                $artfollow = $this->data['artfollow'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '1', $offset = '', $join_str = array(), $groupby = '');

                    if (!$artfollow) {

                        $third_user_html .= '<li class="follow_box_ul_li fad' . $userlist['art_id'] . '" id = "fad' . $userlist['art_id'] . '">
                                                <div class="contact-frnd-post follow_left_main_box"><div class="profile-job-post-title-inside clearfix">
                                                                    <div class=" col-md-12 follow_left_box_main">                   
                                                                        <div class="post-design-pro-img_follow">';
                    if ($userlist['art_user_image']) {

                        $third_user_html .= '<a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucfirst(strtolower($userlist['art_name'])) .' ' .ucfirst(strtolower($userlist['art_lastname'])) . '">';

                        if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $userlist['art_user_image'])) {
                                                                $a = $userlist['art_name'];
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userlist['art_lastname'];
                                                                $bcr = substr($b, 0, 1);

                                  $third_user_html .= '<div class="post-img-div">';
                                  $third_user_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                  $third_user_html .= '</div>'; 

                                    }else{

                        $third_user_html .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $userlist['art_user_image'] . '"  alt="">';

                        }
                        $third_user_html .= '</a>';

                    } else {
                        $third_user_html .= '<a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucwords($userlist['art_name']) . '">';
                                                                                    
                                                                $a = $userlist['art_name'];
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userlist['art_lastname'];
                                                                $bcr = substr($b, 0, 1);

                                  $third_user_html .= '<div class="post-img-div">';
                                  $third_user_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                  $third_user_html .= '</div>'; 

                         $third_user_html .= '</a>';
                    }
                    $third_user_html .= '</div>
                                <div class="post-design-name_follow fl">
                                     <ul><li>
                                    <div class="post-design-product_follow">';
                    $third_user_html .= '<a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucfirst(strtolower($userlist['art_name'])) .' ' .ucfirst(strtolower($userlist['art_lastname'])) .'">
                            <h6>' . ucfirst(strtolower($userlist['art_name'])) .' '. ucfirst(strtolower($userlist['art_lastname'])) . '</h6>
                            </a> 
                            </div>
                        </li>';
                    
                    $third_user_html .= '<li>
                        <div class="post-design-product_follow_main" style="display:block;">
                           <a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucfirst(strtolower($userlist['art_name'])) .' '. ucfirst(strtolower($userlist['art_lastname'])) . '">
                    <p>';
                    if ($userlist['designation']) {
                        $third_user_html .= $userlist['designation'];
                    } else {
                        $third_user_html .= 'Current Work';
                    }

                    $third_user_html .= '</p>
                                     </a>
                                    </div>
                                    </li>
                                    </ul> 
                                    </div>  
                            <div class="follow_left_box_main_btn">';
                    $third_user_html .= '<div class="fr' . $userlist['art_id'] . '">
                            <button id="followdiv' . $userlist['art_id'] . '" onClick="followuser(' . $userlist['art_id'] . ')"><span>Follow</span>
                            </button>
                            </div>
                            </div>
                            <span class="Follow_close" onClick="followclose(' . $userlist['art_id'] . ')">
                            <i class="fa fa-times" aria-hidden="true">
                            </i>
                        </span>
                        </div>
                </div></div></li>';
                    }
                }
            }
            
            echo $third_user_html;
    }


 public function artistic_home_follow_ignore() {
        $userid = $this->session->userdata('aileenuser');
        $art_id = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->art_id;
        $follow_to = $_POST['follow_to'];

        $insert_data['profile'] = '1';
        $insert_data['user_from'] = $art_id;
        $insert_data['user_to'] = $follow_to;

        $insert_id = $this->common->insert_data_getid($insert_data, 'user_ignore');

         // GET USER ARTISTIC DATA START
        if($insert_id){
            $contition_array = array('user_id' => $userid, 'status' => '1');
            $artisticdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_name,art_lastname,art_user_image,art_skill,art_city,art_state, slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $art_id = $artisticdata[0]['art_id'];
            $art_skill = $artisticdata[0]['art_skill'];
            $city = $artisticdata[0]['art_city'];
             $state = $artisticdata[0]['art_state'];
            // GET USER ARTISTIC DATA END
            // GET ARTISTIC USER FOLLOWING LIST START
            $contition_array = array('follow_from' => $art_id, 'follow_status' => 1, 'follow_type' => 1);
            $followdata = $this->common->select_data_by_condition('follow', $contition_array, $data = 'GROUP_CONCAT(follow_to) as follow_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = 'follow_from');
            $follow_list = $followdata[0]['follow_list'];
            $follow_list = str_replace(",", "','", $followdata[0]['follow_list']);
            // GET ARTISTIC USER FOLLOWING LIST END
            // GET ARTISTIC USER IGNORE LIST START
            $contition_array = array('user_from' => $art_id, 'profile' => 1);
            $userdata = $this->common->select_data_by_condition('user_ignore', $contition_array, $data = 'GROUP_CONCAT(user_to) as user_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = 'user_from');
            $user_list = $followdata[0]['user_list'];
            $user_list = str_replace(",", "','", $userdata[0]['user_list']);
            // GET ARTISTIC USER IGNORE LIST END
            //GET ARTISTIC USER SUGGESTED USER LIST 
            $contition_array = array('is_delete' => 0, 'status' => 1, 'user_id != ' => $userid, 'art_step' => 4);
        $search_condition = "((art_skill IN ('$art_skill')) OR (art_city = '$city') OR (art_state = '$state')) AND art_id NOT IN ('$follow_list') AND art_id NOT IN ('$user_list')";

        $userlistview = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = 'art_id, art_name, art_lastname, art_user_image, art_skill, art_city, art_state, user_id, slug', $sortby = 'CASE WHEN (art_city = ' . $city . ') THEN art_id END, CASE WHEN (art_state = ' . $state . ') THEN art_id END', $orderby = 'DESC', $limit = '1', $offset = '3', $join_str_contact = array(), $groupby = '');
        //echo "<pre>"; print_r($userlistview); die();

            $third_user_html = '';
            if (count($userlistview) > 0) {
                foreach ($userlistview as $userlist) {
                    $userid = $this->session->userdata('aileenuser');
                $followfrom = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->art_id;
                $contition_array = array('follow_to' => $userlist['art_id'], 'follow_from' => $followfrom, 'follow_status' => '1', 'follow_type' => '1');
                $artfollow = $this->data['artfollow'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '1', $offset = '', $join_str = array(), $groupby = '');

                    if (!$artfollow) {

                        $third_user_html .= '<li class="follow_box_ul_li fad' . $userlist['art_id'] . '" id = "fad' . $userlist['art_id'] . '">
                                                <div class="contact-frnd-post follow_left_main_box"><div class="profile-job-post-title-inside clearfix">
                                                                    <div class=" col-md-12 follow_left_box_main">                   
                                                                        <div class="post-design-pro-img_follow">';
                    if ($userlist['art_user_image']) {

                        $third_user_html .= '<a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucfirst(strtolower($userlist['art_name'])) .' ' .ucfirst(strtolower($userlist['art_lastname'])) . '">';

                        if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $userlist['art_user_image'])) {
                                                                $a = $userlist['art_name'];
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userlist['art_lastname'];
                                                                $bcr = substr($b, 0, 1);

                                  $third_user_html .= '<div class="post-img-div">';
                                  $third_user_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                  $third_user_html .= '</div>'; 

                                    }else{

                        $third_user_html .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $userlist['art_user_image'] . '"  alt="">';

                        }
                        $third_user_html .= '</a>';

                    } else {
                        $third_user_html .= '<a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucwords($userlist['art_name']) . '">';
                                                                                    
                                                                $a = $userlist['art_name'];
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userlist['art_lastname'];
                                                                $bcr = substr($b, 0, 1);

                                  $third_user_html .= '<div class="post-img-div">';
                                  $third_user_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                  $third_user_html .= '</div>'; 

                         $third_user_html .= '</a>';
                    }
                    $third_user_html .= '</div>
                                <div class="post-design-name_follow fl">
                                     <ul><li>
                                    <div class="post-design-product_follow">';
                    $third_user_html .= '<a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucfirst(strtolower($userlist['art_name'])) .' ' .ucfirst(strtolower($userlist['art_lastname'])) .'">
                            <h6>' . ucfirst(strtolower($userlist['art_name'])) .' '. ucfirst(strtolower($userlist['art_lastname'])) . '</h6>
                            </a> 
                            </div>
                        </li>';
                    
                    $third_user_html .= '<li>
                        <div class="post-design-product_follow_main" style="display:block;">
                           <a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucfirst(strtolower($userlist['art_name'])) .' '. ucfirst(strtolower($userlist['art_lastname'])) . '">
                    <p>';
                    if ($userlist['designation']) {
                        $third_user_html .= $userlist['designation'];
                    } else {
                        $third_user_html .= 'Current Work';
                    }

                    $third_user_html .= '</p>
                                     </a>
                                    </div>
                                    </li>
                                    </ul> 
                                    </div>  
                            <div class="follow_left_box_main_btn">';
                    $third_user_html .= '<div class="fr' . $userlist['art_id'] . '">
                            <button id="followdiv' . $userlist['art_id'] . '" onClick="followuser(' . $userlist['art_id'] . ')"><span>Follow</span>
                            </button>
                            </div>
                            </div>
                            <span class="Follow_close" onClick="followclose(' . $userlist['art_id'] . ')">
                            <i class="fa fa-times" aria-hidden="true">
                            </i>
                        </span>
                        </div>
                </div></div></li>';
                    }
                }
            }
            
            echo $third_user_html;
         }

    }

    public function follow_two() {
        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $art_id = $_POST["follow_to"];

        $artdata = $this->common->select_data_by_id('art_reg', 'user_id', $userid, $data = '*');

        $contition_array = array('follow_type' => 1, 'follow_from' => $artdata[0]['art_id'], 'follow_to' => $art_id);
        $follow = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        //  echo "<pre>"; print_r($follow); die();

        $contition_array = array('art_id' => $art_id, 'status' => 1, 'is_delete' => 0 ,'art_step' => 4);
        $followuserid = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($follow) {
            $data = array(
                'follow_type' => 1,
                'follow_from' => $artdata[0]['art_id'],
                'follow_to' => $art_id,
                'follow_status' => 1,
            );
            $update = $this->common->update_data($data, 'follow', 'follow_id', $follow[0]['follow_id']);

            // insert notification


            $contition_array = array('not_type' => 8, 'not_from_id' => $userid, 'not_to_id' => $followuserid[0]['user_id'], 'not_product_id' => $follow[0]['follow_id'], 'not_from' => 3);
            $artnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if ($artnotification[0]['not_read'] == 2) {
                    
                } elseif ($artnotification[0]['not_read'] == 1) {

                    $datafollow = array(
                        'not_read' => 2,
                        'not_created_date' => date('Y-m-d H:i:s')

                    );

                    $where = array('not_type' => 8, 'not_from_id' => $userid, 'not_to_id' => $followuserid[0]['user_id'], 'not_product_id' => $follow[0]['follow_id'], 'not_from' => 3);
                    $this->db->where($where);
                    $updatdata = $this->db->update('notification', $datafollow);
                } 

            // $data = array(
            //     'not_type' => 8,
            //     'not_from_id' => $artdata[0]['art_id'],
            //     'not_to_id' => $art_id,
            //     'not_read' => 2,
            //     'not_product_id' => $follow[0]['follow_id'],
            //     'not_from' => 3,
            //     'not_active' => 1,
            //     'not_created_date' => date('Y-m-d H:i:s')
            // );

            // $insert_id = $this->common->insert_data_getid($data, 'notification');
            // end notoification


            if ($update) {


                $follow = '<div id="unfollowdiv">';
                /*  $follow = '<button id="unfollow' . $art_id.'" onClick="unfollowuser('.$art_id.')"><span><span>Following</span></span></button>';
                  $follow .= '</div>'; */
                $follow .= '<button class="bg_following" id="unfollow' . $art_id . '" onClick="unfollowuser(' . $art_id . ')"><span>Following</span></button>';
                $follow .= '</div>';
                echo $follow;
            }
        } else {
            $data = array(
                'follow_type' => 1,
                'follow_from' => $artdata[0]['art_id'],
                'follow_to' => $art_id,
                'follow_status' => 1,
            );
            $insert = $this->common->insert_data_getid($data, 'follow');

            // insert notification

            $data = array(
                'not_type' => 8,
                'not_from_id' => $artdata[0]['art_id'],
                'not_to_id' => $art_id,
                'not_read' => 2,
                'not_product_id' => $insert,
                'not_from' => 3,
                'not_active' => 1,
                'not_created_date' => date('Y-m-d H:i:s')
            );

            $insert_id = $this->common->insert_data_getid($data, 'notification');
            // end notoification

            if ($insert) {

                $follow = '<div id="unfollowdiv">';
                /*  $follow = '<button id="unfollow' . $art_id.'" onClick="unfollowuser('.$art_id.')"><span><span>Following</span></span></button>';
                  $follow .= '</div>'; */
                $follow .= '<button class="bg_following" id="unfollow' . $art_id . '" onClick="unfollowuser(' . $art_id . ')"><span>Following</span></button>';
                $follow .= '</div>';
                echo $follow;
            }
        }
    }



public function followtwo() {
        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $art_id = $_POST["follow_to"];

        $artdata = $this->common->select_data_by_id('art_reg', 'user_id', $userid, $data = '*');

        $contition_array = array('follow_type' => 1, 'follow_from' => $artdata[0]['art_id'], 'follow_to' => $art_id);
        $follow = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        //  echo "<pre>"; print_r($follow); die();
        $contition_array = array('art_id' => $art_id, 'status' => 1, 'is_delete' => 0 ,'art_step' => 4);
        $followuserid = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($follow) {
            $data = array(
                'follow_type' => 1,
                'follow_from' => $artdata[0]['art_id'],
                'follow_to' => $art_id,
                'follow_status' => 1,
            );
            $update = $this->common->update_data($data, 'follow', 'follow_id', $follow[0]['follow_id']);

            // insert notification


            $contition_array = array('not_type' => 8, 'not_from_id' => $userid, 'not_to_id' => $followuserid[0]['user_id'], 'not_product_id' => $follow[0]['follow_id'], 'not_from' => 3);
            $artnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if ($artnotification[0]['not_read'] == 2) {
                    
                } elseif ($artnotification[0]['not_read'] == 1) {

                    $datafollow = array(
                        'not_read' => 2,
                        'not_created_date' => date('Y-m-d H:i:s')

                    );

                    $where = array('not_type' => 8, 'not_from_id' => $userid, 'not_to_id' => $followuserid[0]['user_id'], 'not_product_id' => $follow[0]['follow_id'], 'not_from' => 3);
                    $this->db->where($where);
                    $updatdata = $this->db->update('notification', $datafollow);
                } 

            // $data = array(
            //     'not_type' => 8,
            //     'not_from_id' => $artdata[0]['art_id'],
            //     'not_to_id' => $art_id,
            //     'not_read' => 2,
            //     'not_product_id' => $follow[0]['follow_id'],
            //     'not_from' => 3,
            //     'not_active' => 1,
            //     'not_created_date' => date('Y-m-d H:i:s')
            // );

            // $insert_id = $this->common->insert_data_getid($data, 'notification');
            // end notoification

        $contition_array = array('follow_type' => 1, 'follow_from' => $artdata[0]['art_id'], 'follow_status' => 1);
        $followcount = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($update) {


                $follow = '<div class=" user_btn follow_btn_'.$art_id.'" id="unfollowdiv">';
                /*  $follow = '<button id="unfollow' . $art_id.'" onClick="unfollowuser('.$art_id.')"><span><span>Following</span></span></button>';
                  $follow .= '</div>'; */
                $follow .= '<button class="bg_following" id="unfollow' . $art_id . '" onClick="unfollowuser_two(' . $art_id . ')"><span>Following</span></button>';
                $follow .= '</div>';

                $datacount = '('.count($followcount).')';


                
                 echo json_encode(
                        array(
                            "follow" => $follow,
                            "count" => $datacount,
                ));

            }
        } else {
            $data = array(
                'follow_type' => 1,
                'follow_from' => $artdata[0]['art_id'],
                'follow_to' => $art_id,
                'follow_status' => 1,
            );
            $insert = $this->common->insert_data_getid($data, 'follow');

            // insert notification

            $data = array(
                'not_type' => 8,
                'not_from_id' => $artdata[0]['art_id'],
                'not_to_id' => $art_id,
                'not_read' => 2,
                'not_product_id' => $insert,
                'not_from' => 3,
                'not_active' => 1,
                'not_created_date' => date('Y-m-d H:i:s')
            );

            $insert_id = $this->common->insert_data_getid($data, 'notification');
            // end notoification


             $contition_array = array('follow_type' => 1, 'follow_from' => $artdata[0]['art_id'], 'follow_status' => 1);
        $followcount = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($insert) {

                $follow = '<div class=" user_btn follow_btn_'.$art_id.'" id="unfollowdiv">';
                /*  $follow = '<button id="unfollow' . $art_id.'" onClick="unfollowuser('.$art_id.')"><span><span>Following</span></span></button>';
                  $follow .= '</div>'; */
                $follow .= '<button class="bg_following" id="unfollow' . $art_id . '" onClick="unfollowuser_two(' . $art_id . ')"><span>Following</span></button>';
                $follow .= '</div>';

                $datacount = '('.count($followcount).')';

                echo json_encode(
                        array(
                            "follow" => $follow,
                            "count" => $datacount,
                ));
            }
        }
    }


    public function unfollow_two() {
        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $art_id = $_POST["follow_to"];

        $artdata = $this->common->select_data_by_id('art_reg', 'user_id', $userid, $data = '*');

        $contition_array = array('follow_type' => 1, 'follow_from' => $artdata[0]['art_id'], 'follow_to' => $art_id);

        $follow = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        if ($follow) {
            $data = array(
                'follow_type' => 1,
                'follow_from' => $artdata[0]['art_id'],
                'follow_to' => $art_id,
                'follow_status' => 0,
            );
            $update = $this->common->update_data($data, 'follow', 'follow_id', $follow[0]['follow_id']);
            if ($update) {


                /*  $unfollow = '<div><button id="follow' . $art_id.'" onClick="followuser('.$art_id.')">
                  Follow
                  </button></div>'; */
                $unfollow = '<div id="followdiv">';
                $unfollow .= '<button id="follow'.$art_id.'" onClick="followuser(' . $art_id . ')">
                             <span>  Follow </span>
                      </button></div>';

                echo $unfollow;
            }
        }
    }


    public function unfollowtwo() { //echo "hii"; die();
        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $art_id = $_POST["follow_to"]; 

        $artdata = $this->common->select_data_by_id('art_reg', 'user_id', $userid, $data = '*');

        $contition_array = array('follow_type' => 1, 'follow_from' => $artdata[0]['art_id'], 'follow_to' => $art_id);

        $follow = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        //echo "<pre>"; print_r($follow); die();

        if ($follow) {
            $data = array(
                'follow_type' => 1,
                'follow_from' => $artdata[0]['art_id'],
                'follow_to' => $art_id,
                'follow_status' => 0,
            );
            $update = $this->common->update_data($data, 'follow', 'follow_id', $follow[0]['follow_id']);

            $contition_array = array('follow_type' => 1, 'follow_from' => $artdata[0]['art_id'], 'follow_status' => 1);
        $followcount = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($update) {


                /*  $unfollow = '<div><button id="follow' . $art_id.'" onClick="followuser('.$art_id.')">
                 <span>Follow</span>
                  </button></div>'; */
                $unfollow = '<div class=" user_btn follow_btn_'.$art_id.'" id="followdiv">';
                $unfollow .= '<button id="follow'.$art_id.'" onClick="followuser_two(' . $art_id . ')">
                              <span>Follow</span> 
                      </button></div>';

                $datacount = '('.count($followcount).')';


                
                 echo json_encode(
                        array(
                            "follow" => $unfollow,
                            "count" => $datacount,
                ));
            }
        }
    }

    public function unfollow_following() {
        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $art_id = $_POST["follow_to"];

        $artdata = $this->common->select_data_by_id('art_reg', 'user_id', $userid, $data = '*');

        $contition_array = array('follow_type' => 1, 'follow_from' => $artdata[0]['art_id'], 'follow_to' => $art_id);

        $follow = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        if ($follow) { //echo "falguni"; die();
            $data = array(
                'follow_type' => 1,
                'follow_from' => $artdata[0]['art_id'],
                'follow_to' => $art_id,
                'follow_status' => 0,
            );
            $update = $this->common->update_data($data, 'follow', 'follow_id', $follow[0]['follow_id']);


            if ($update) {




                $contition_array = array('follow_from' => $artdata[0]['art_id'], 'follow_status' => '1', 'follow_type' => '1');
                $followingotherdata = $this->data['followingotherdata'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $followingdatacount = count($followingotherdata);

               // $unfollow = '<div>(';
                $unfollow .= '(' . $followingdatacount . ')';
               // $unfollow .= ')</div>';


                if (count($followingotherdata) == 0) {
                    $notfound = '<div class="art-img-nn">
         <div class="art_no_post_img">

           <img src="'.base_url('img/icon_no_following.png').'">
        
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

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

            $contition_array = array('user_id' => $userid, 'status' => '1', 'is_delete' => '0');
            $artslug = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        if ($id == $userid || $id == '' || $id == $artslug[0]['slug']) {

            $contition_array = array('user_id' => $userid, 'status' => '1', 'is_delete' => '0');
            $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {


            $contition_array = array('slug' => $id, 'status' => '1', 'is_delete' => '0', 'art_step' => 4);
            $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        }


        if($this->data['artisticdata']){
            $artistic_name = $this->get_artistic_name($id);
      $this->data['title'] = $artistic_name.TITLEPOSTFIX;
        $this->data['artistic_common'] = $this->load->view('artistic/artistic_common', $this->data, true);
        $this->load->view('artistic/art_followers', $this->data);
       }else if(!$this->data['artisticdata'] && $id != $userid){

        $this->load->view('artistic/notavalible');  

       }
        else if(!$this->data['artisticdata'] && ($id == $userid || $id == "")){
       redirect('artistic/');
       }
    }



    public function ajax_followers($id = "") {
        $userid = $this->session->userdata('aileenuser');
        //$id = $_POST['slug_id'];
        //echo $id; die();
        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;

        
        if ($id == $userid || $id == '') {
            $contition_array = array('user_id' => $userid, 'is_delete' => 0, 'status' => 1);
            $artisticdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $artdata = $this->common->select_data_by_id('art_reg', 'user_id', $userid, $data = '*');

            $join_str[0]['table'] = 'follow';
            $join_str[0]['join_table_id'] = 'follow.follow_to';
            $join_str[0]['from_table_id'] = 'art_reg.art_id';
            $join_str[0]['join_type'] = '';



            $limit = $perpage;
            $offset = $start;

            $contition_array = array('follow_to' => $artdata[0]['art_id'], 'follow_status' => 1, 'follow_type' => 1, 'art_reg.art_step' => 4, 'follow_status' => 1);
            $userlist = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit, $offset, $join_str, $groupby = '');
            //echo "<pre>"; print_r($userlist); die();
            $userlist1 = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        } else {
            $contition_array = array('user_id' => $id, 'is_delete' => 0, 'status' => 1, 'art_step' => 4);
            $artisticdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $artdata = $this->common->select_data_by_id('art_reg', 'user_id', $id, $data = '*');


            $join_str[0]['table'] = 'follow';
            $join_str[0]['join_table_id'] = 'follow.follow_to';
            $join_str[0]['from_table_id'] = 'art_reg.art_id';
            $join_str[0]['join_type'] = '';

            $limit = $perpage;
            $offset = $start;

            $contition_array = array('follow_to' => $artdata[0]['art_id'], 'follow_status' => 1, 'follow_type' => 1, 'art_reg.art_step' => 4, 'follow_status' => 1,);
            $userlist = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit, $offset, $join_str, $groupby = '');
            $userlist1 = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
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


                 $contition_array = array('art_id' => $user['follow_from'], 'status' => '1');
              $artaval = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if($artaval){

                $return_html .= '
                                                    <div class="profile-job-post-detail clearfix">
                                                        <div class="profile-job-post-title-inside clearfix">
                                                            <div class="profile-job-post-location-name">
                                                                <div class="user_lst">
                                                                    <ul>
                                                                        <li class="fl">
                                                                            <div class="follow-img">';
                 $followerid =  $this->db->get_where('art_reg',array('art_id' => $user['follow_from']))->row()->user_id;
                 $followerslug =  $this->db->get_where('art_reg',array('art_id' => $user['follow_from']))->row()->slug;

                $followerimage = $this->db->get_where('art_reg', array('art_id' => $user['follow_from']))->row()->art_user_image;
                $followername =  $this->db->get_where('art_reg',array('art_id' => $user['follow_from']))->row()->art_name;
                $art_lastname =  $this->db->get_where('art_reg',array('art_id' => $user['follow_from']))->row()->art_lastname;
                 $designation =  $this->db->get_where('art_reg',array('art_id' => $user['follow_from']))->row()->designation;

                if ($followerimage != '') {
                    $return_html .= '<a href="' . base_url('artistic/dashboard/' . $followerslug) . '">';
                    if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $followerimage)) {

                                                                $a = $followername;
                                                                $acr = substr($a, 0, 1);
                                                                $b = $art_lastname;
                                                                $bcr = substr($b, 0, 1);

                        $return_html .= '<div class="post-img-userlist">';
                        $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                        $return_html .= '</div>';

                    } else {
                        $return_html .= '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $followerimage . '" height="50px" width="50px" alt="" >';
                    }
                    $return_html .= '</a>';
                } else {
                    $return_html .= '<a href="' . base_url('artistic/dashboard/' . $followerslug) . '">';
                                                                $a = $followername;
                                                                $acr = substr($a, 0, 1);
                                                                $b = $art_lastname;
                                                                $bcr = substr($b, 0, 1);

                        $return_html .= '<div class="post-img-userlist">';
                        $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                        $return_html .= '</div>';
                        $return_html .= '</a>';
                }
                $return_html .= '</div>
                                                                        </li>
                                                                        <li class="folle_text">
                                                                            <div class="">
                                                                                <div class="follow-li-text " style="padding: 0;">
                                                                                    <a href="' . base_url('artistic/dashboard/' . $followerslug) . '">' . ucfirst(strtolower($followername)) .'&nbsp;'.ucfirst(strtolower($art_lastname)). '</a></div>
                                                                                <div>';
                
                $return_html .= '<a>';
                if ($designation) {
                    $return_html .= ucfirst(strtolower($designation));
                } else {
                    $return_html .= 'Current Work';
                }

                $return_html .= '</a>
                                                                                </div>
                                                                        </li>
                                                                        <li class="fr" id ="frfollow' . $user['follow_from'] . '">';
                $contition_array = array('user_id' => $userid, 'status' => '1');
                $artisticdatauser = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                
            
                $contition_array = array('follow_from' => $artisticdatauser[0]['art_id'], 'follow_status' => 1, 'follow_type' => 1, 'follow_to' => $user['follow_from']);
                $status_list = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
                
                if (($status_list[0]['follow_status'] == 0 || $status_list[0]['follow_status'] == ' ' ) && $user['follow_from'] != $artisticdatauser[0]['art_id']) {

                    $return_html .= '<div class="user_btn follow_btn_' . $user['follow_from'] . '" id= "followdiv">
                                                                                    <button id="follow' . $user['follow_from'] . '" onClick="followuser_two(' . $user['follow_from'] . ')"><span>Follow</span></button>
                                                                                </div>';
                } else if ($user['follow_from'] == $artisticdatauser[0]['art_id']) {
                    
                } else {
                    $return_html .= '<div class="user_btn follow_btn_' . $user['follow_from'] . '" id= "unfollowdiv">
                                        <button class="bg_following" id="unfollow' . $user['follow_from'] . '" onClick="unfollowuser_two(' . $user['follow_from'] . ')"><span>Following</span></button>
                                                                                </div>';
                }
                $return_html .= '</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                ';
            } }
        } else {
            $return_html .= '<div class="art-img-nn" id= "art-blank" style="display: block">
                                                <div class="art_no_post_img">
                                                    <img src="' . base_url('img/icon_no_follower.png') . '">
                                                </div>
                                                <div class="art_no_post_text">
                                                    No Followers Available.
                                                </div>
                                            </div>';
        }

        echo $return_html;
    }


    public function following($id = "") {

        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End
  $contition_array = array('user_id' => $userid, 'status' => '1', 'is_delete' => '0');
            $artslug = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($id == $userid || $id == '' || $id == $artslug[0]['slug']) {


            $artdata = $this->common->select_data_by_id('art_reg', 'user_id', $userid, $data = '*');

            $contition_array = array('user_id' => $userid, 'status' => '1');
            $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            $join_str[0]['table'] = 'follow';
            $join_str[0]['join_table_id'] = 'follow.follow_from';
            $join_str[0]['from_table_id'] = 'art_reg.art_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('follow_from' => $artdata[0]['art_id'], 'follow_status' => 1, 'follow_type' => 1 ,'art_reg.art_step' => 4);

            $this->data['userlist'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        } else {


            $artdata = $this->common->select_data_by_id('art_reg', 'slug', $id, $data = '*');

            $contition_array = array('slug' => $id, 'status' => '1','art_step' => 4);
            $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            $join_str[0]['table'] = 'follow';
            $join_str[0]['join_table_id'] = 'follow.follow_from';
            $join_str[0]['from_table_id'] = 'art_reg.art_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('follow_from' => $artdata[0]['art_id'], 'follow_status' => 1, 'follow_type' => 1,'art_reg.art_step' => 4);

            $this->data['userlist'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        }

        if($this->data['artisticdata']){
            $artistic_name = $this->get_artistic_name($id);
      $this->data['title'] = $artistic_name.TITLEPOSTFIX;
        $this->data['artistic_common'] = $this->load->view('artistic/artistic_common', $this->data, true);

        $this->load->view('artistic/art_following', $this->data);
       }else if(!$this->data['artisticdata'] && $id != $userid){

        $this->load->view('artistic/notavalible');  

       }
        else if(!$this->data['artisticdata'] && ($id == $userid || $id == "")){
       redirect('artistic/');
       }
    }

// end of user lidt


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
        //$id = $_POST['slug_id'];

        $contition_array = array('user_id' => $userid, 'is_delete' => 0, 'status' => 1);
        $artdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        //$slugid = $artdata[0]['business_slug'];
        if ($id == $userid || $id == '') { //echo "1"; die();

            $artdata = $this->common->select_data_by_id('art_reg', 'user_id', $userid, $data = '*');

            $contition_array = array('user_id' => $userid, 'status' => '1');
            $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $join_str[0]['table'] = 'follow';
            $join_str[0]['join_table_id'] = 'follow.follow_from';
            $join_str[0]['from_table_id'] = 'art_reg.art_id';
            $join_str[0]['join_type'] = '';

           $limit = $perpage;
           $offset = $start;

            $contition_array = array('follow_from' => $artdata[0]['art_id'], 'follow_status' => 1, 'follow_type' => 1, 'art_reg.art_step' => 4);
            $userlist = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit, $offset, $join_str, $groupby = '');
            $userlist1 = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
        } else { //echo "16"; die();

            $artdata = $this->common->select_data_by_id('art_reg', 'user_id', $id, $data = '*');

            $contition_array = array('user_id' => $id, 'art_step' => 4);
            $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $join_str[0]['table'] = 'follow';
            $join_str[0]['join_table_id'] = 'follow.follow_from';
            $join_str[0]['from_table_id'] = 'art_reg.art_id';
            $join_str[0]['join_type'] = '';

           $limit = $perpage;
            $offset = $start;

            $contition_array = array('follow_from' => $artdata[0]['art_id'], 'follow_status' => 1, 'follow_type' => 1, 'art_reg.art_step' => 4);
            $userlist = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit, $offset, $join_str, $groupby = '');
           $userlist1 = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
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
                $return_html .= '
    <div class = "profile-job-post-detail clearfix" id = "removefollow' . $user['follow_to'] . '">
        <div class = "profile-job-post-title-inside clearfix">
            <div class = "profile-job-post-location-name">
                <div class = "user_lst">
                    <ul>
                        <li class = "fl padding_les_left rsp"">
                            <div class = "follow-img">';

               $art_name =  $this->db->get_where('art_reg',array('art_id' => $user['follow_to']))->row()->art_name;
                $art_id =  $this->db->get_where('art_reg',array('art_id' => $user['follow_to']))->row()->user_id;

                 $art_slug =  $this->db->get_where('art_reg',array('art_id' => $user['follow_to']))->row()->slug;

                $art_lastname =  $this->db->get_where('art_reg',array('art_id' => $user['follow_to']))->row()->art_lastname;

                 $designation =  $this->db->get_where('art_reg',array('art_id' => $user['follow_to']))->row()->designation;
                 $art_image = $this->db->get_where('art_reg',array('art_id' => $user['follow_to']))->row()->art_user_image;

                if ($art_image != '') {
                    $return_html .= '<a href="' . base_url('artistic/dashboard/' . $art_slug) . '" title="' . ucfirst(strtolower($art_name)) .' '. ucfirst(strtolower($art_lastname)) .'">';
                    $uimage = $this->db->get_where('art_reg', array('art_id' => $user['follow_to']))->row()->art_user_image;
                    if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $uimage)) {

                                                                $a = $art_name;
                                                                $acr = substr($a, 0, 1);
                                                                $b = $art_lastname;
                                                                $bcr = substr($b, 0, 1);

                        $return_html .= '<div class="post-img-userlist">';
                        $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)) ;
                        $return_html .= '</div> ';

                    } else {
                        $return_html .= '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $this->db->get_where('art_reg', array('art_id' => $user['follow_to']))->row()->art_user_image . '" height="50px" width="50px" alt="" >';
                    }
                    $return_html .= '</a>';
                } else {
                    $return_html .= '<a href="' . base_url('artistic/dashboard/' . $art_slug) . '" title="' . ucfirst(strtolower($art_name)).' '. ucfirst(strtolower($art_lastname)) .'">';

                                                                $a = $art_name;
                                                                $acr = substr($a, 0, 1);
                                                                $b = $art_lastname;
                                                                $bcr = substr($b, 0, 1);

                        $return_html .= '<div class="post-img-userlist">';
                        $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)) ;
                        $return_html .= '</div> ';

                }
                $return_html .= '</div>
                                    </li>
                                    <li class="folle_text">
                                        <div class="">
                                            <div class="follow-li-text" style="padding: 0;">
                                                <a title="' .ucfirst(strtolower($art_name)) .'&nbsp;'.ucfirst(strtolower($art_lastname)). '" href="' . base_url('artistic/dashboard/' . $art_slug) . '">' . ucfirst(strtolower($art_name)) .'&nbsp;'. ucfirst(strtolower($art_lastname)) . '</a></div>
                                            <div>';

                $return_html .= '<a>';
                if ($designation) {
                    $return_html .= ucfirst(strtolower($designation));
                } else {
                    $return_html .= 'Current Work';
                }

                $return_html .= '</a>
                                            </div>
                                    </li>';
                $userid = $this->session->userdata('aileenuser');
                if ($artisticdata[0]['user_id'] == $userid) {
                    $return_html .= '<li class="fr fruser' . $user['follow_to'] . '">';

                    $contition_array = array('follow_from' => $artisticdata[0]['art_id'], 'follow_status' => 1, 'follow_type' => 1, 'follow_to' => $user['follow_to']);
                    $status = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    if ($status[0]['follow_status'] == 1) {
                        $return_html .= '<div class="user_btn" id= "unfollowdiv">
                                            <button class="bg_following" id="unfollow' . $user['follow_to'] . '" onClick="unfollowuser_list(' . $user['follow_to'] . ')"><span>Following</span></button>
                                        </div>';
                    }
                    $return_html .= '</li>';
                } else {
                    $return_html .= '<li class="fr" id ="frfollow' . $user['follow_to'].'">';

                    $contition_array = array('user_id' => $userid, 'status' => '1');
                    $artisticdatauser = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    $contition_array = array('follow_from' => $artisticdatauser[0]['art_id'], 'follow_status' => 1, 'follow_type' => 1, 'follow_to' => $user['follow_to']);
                    $status_list = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    if (($status_list[0]['follow_status'] == 0 || $status_list[0]['follow_status'] == ' ' ) && $user['follow_to'] != $artisticdatauser[0]['art_id']) {
                        $return_html .= '<div class="user_btn follow_btn_' . $user['follow_to'] . '" id= "followdiv">
                                            <button id="<?php
                                                    echo "follow"' . $user['follow_to'] . '" onClick="followuser_two(' . $user['follow_to'] . ')"><span>Follow</span></button>
                            </div>';
                    } else if ($user['follow_to'] == $artisticdatauser[0]['art_id']) {
                        
                    } else {
                        $return_html .= '<div class="user_btn follow_btn_' . $user['follow_to'] . '" id= "unfollowdiv">
                                <button class="bg_following" id="unfollow"' . $user['follow_to'] . '" onClick = "unfollowuser_two(' . $user['follow_to'] . ')"><span>Following</span></button>
                                                    </div>';
                    }
                    $return_html .= '</li>';
                }
                $return_html .= '</ul>
                                                    </div>
                                                    </div>
                                                    </div>
                                                    </div>
                                                    ';
            }
        } else {

            $return_html .= '<div class = "art-img-nn">
                                                    <div class = "art_no_post_img">
                                                    <img src = "' . base_url('img/icon_no_following.png') . '">
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


    //deactivate user start
    public function deactivate() {

        $id = $_POST['id'];
        $data = array(
            'status' => 0
        );

        $update = $this->common->update_data($data, 'art_reg', 'user_id', $id);

        // if ($update) {
        //     $this->session->set_flashdata('success', 'You are deactivate successfully.');
        //     redirect('dashboard', 'refresh');
        // } else {
        //     $this->session->flashdata('error', 'Sorry!! Your are not deactivate!!');
        //     redirect('artistic', 'refresh');
        // }
    }

// deactivate user end
//Artistic Profile Save Post Start
    public function artistic_save() {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $id = $_POST['art_post_id'];

        $contition_array = array('post_id' => $id, 'user_id' => $userid, 'is_delete' => 0);
        $userdata = $this->common->select_data_by_condition('art_post_save', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $save_id = $userdata[0]['save_id'];

        if ($userdata) {

            $contition_array = array('post_delete' => 1);
            $jobdata = $this->common->select_data_by_condition('art_post_save', $contition_array, $data = 'save_id', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $data = array(
                'post_delete' => 0,
                'post_save' => 1,
                'modify_date' => date('Y-m-d h:i:s', time())
            );


            $updatedata = $this->common->update_data($data, 'art_post_save', 'save_id', $save_id);


            if ($updatedata) {

                //$savepost = '<div> Saved Post </div>';
                $savepost .= '<i class="fa fa-bookmark" aria-hidden="true"></i>';
                $savepost .= 'Saved Post';
                //$savepost .= '</a>';      
                echo $savepost;
            }
        } else {

            $data = array(
                'post_id' => $id,
                'user_id' => $userid,
                'created_date' => date('Y-m-d H:i:s', time()),
                'is_delete' => 0,
                'post_save' => 1,
                'post_delete' => 0
            );


            $insert_id = $this->common->insert_data_getid($data, 'art_post_save');
            if ($insert_id) {

                //$savepost = '<div> Saved Post </div>';
                $savepost .= '<i class="fa fa-bookmark" aria-hidden="true"></i>';
                $savepost .= 'Saved Post';
                echo $savepost;
            }
        }
    }

    //Artistic Profile Save Post End
//Artistic Profile Save Post shown Start 
    public function art_savepost($id) {

        //artistic save post data start
        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End


        $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $join_str[0]['table'] = 'user';
        $join_str[0]['join_table_id'] = 'user.user_id';
        $join_str[0]['from_table_id'] = 'art_post.user_id';
        $join_str[0]['join_type'] = '';

        $data = 'art_post.*,user.first_name,user.last_name';

        $this->data['art_data'] = $this->common->select_data_by_condition('art_post', $contition_array = array(), $data, $sortby = 'art_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str, $groupby = '');

        //artistic save post data end
        //artistic manage post data start

        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

        if ($id == $userid || $id == '') {

            $contition_array = array('user_id' => $userid, 'status' => '1');
            $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->data['userdata'] = $this->common->select_data_by_id('user', 'user_id', $userid, $data = '*', $join_str = array());

            $contition_array = array('user_id' => $userid, 'is_delete' => '0');
            $this->data['artsdata'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = 'art_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {

            $contition_array = array('user_id' => $id, 'status' => '1','art_step' => 4);
            $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            $this->data['userdata'] = $this->common->select_data_by_id('user', 'user_id', $id, $data = '*', $join_str = array());

            $contition_array = array('user_id' => $id);
            $this->data['artsdata'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }

//artistics mange post data end

        $this->load->view('artistic/art_savepost', $this->data);
    }

//Artistic Profile Save Post shown End
//Artistic  Profile Remove Save Post Start
    public function art_remove_save() {

        $id = $_POST['save_id'];
        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $data = array(
            'post_save' => 0,
            'post_delete' => 1,
            'modify_date' => date('Y-m-d h:i:s', time())
        );

        $updatedata = $this->common->update_data($data, 'art_post_save', 'save_id', $id);


        // if($updatedata){ 
        //                 //echo $removepost; 
        // }
    }

//Artistic Profile Remove Save Post Start


    public function image_upload_ajax() {

        include 'db.php';

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
                        $bgSave = '<div id="uX' . $session_uid . '" class="bgSave wallbutton blackButton">Save Cover</div>';


// khyati start


                        $config['upload_path'] = 'uploads/user_image/';
                        $config['allowed_types'] = 'jpg|jpeg|png|gif|mp4|3gp|mpeg|mpg|mpe|qt|mov|avi|pdf';
                        $config['file_name'] = $_FILES['photoimg']['name'];
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

                        $update = $this->common->update_data($data, 'art_reg', 'user_id', $session_uid);
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

            $update = $this->common->update_data($data, 'art_reg', 'user_id', $session_uid);
            if ($update) {

                echo $position;
            }
        }
    }

    // khyati change end 15 2 
//enter designation start

    public function art_designation() {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $data = array(
            'designation' => $this->input->post('designation'),
            'modified_date' => date('Y-m-d', time())
        );


        $updatdata = $this->common->update_data($data, 'art_reg', 'user_id', $userid);

        if ($updatdata) {

            if ($this->input->post('hitext') == 1) {
                redirect('artistic/home', refresh);
            } elseif ($this->input->post('hitext') == 2) {
                redirect('artistic/art_addpost', refresh);
            } elseif ($this->input->post('hitext') == 3) {
                redirect('artistic/artistic_profile', refresh);
            } elseif ($this->input->post('hitext') == 4) {
                redirect('artistic/art_savepost', refresh);
            } elseif ($this->input->post('hitext') == 5) {
                redirect('artistic/dashboard', refresh);
            } elseif ($this->input->post('hitext') == 6) {
                redirect('artistic/followers', refresh);
            } elseif ($this->input->post('hitext') == 7) {
                redirect('artistic/following', refresh);
            } elseif ($this->input->post('hitext') == 8) {
                redirect('artistic/userlist', refresh);
            }
        } else {
            $this->session->flashdata('error', 'Your data not inserted');
            redirect('artistic/home', refresh);
        }

        //}
    }

//designation end
// create pdf start

    public function creat_pdf($id) {

        $contition_array = array('post_files_id' => $id, 'is_deleted' => '1');
        $this->data['artdata'] = $this->common->select_data_by_condition('post_files', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        //echo "<pre>"; print_r($this->data['artdata']); die();
        $this->load->view('artistic/art_pdfdispaly', $this->data);
    }

//create pdf end
    // create pdf start

    public function creat_pdf1($id) {
        //echo $id ; die();
        $contition_array = array('art_id' => $id, 'status' => '1');
        $this->data['artregdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        //echo "<pre>"; print_r($this->data['artregdata']); die();
        $this->load->view('artistic/art_pdfdispaly', $this->data);
    }

//create pdf end
// Artistic comments like start


    public function like_comment() {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End
        $post_id = $_POST["post_id"];

        $contition_array = array('artistic_post_comment_id' => $_POST["post_id"], 'status' => '1');
        $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $condition_array = array('art_post_id' =>  $artdata[0]['art_post_id']);
        $profile_data = $this->common->select_data_by_condition('art_post', $condition_array, $data = 'status,user_id,is_delete,posted_user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($profile_data); die();
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

        // echo  $dataavl; die();
         if($return == 0){

            $cmtlike1 = 'notavl';
            echo $cmtlike1;
         }else{
        

        $contition_array = array('artistic_post_comment_id' => $_POST["post_id"], 'status' => '1');
        $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $artistic_comment_likes_count = $artdata[0]['artistic_comment_likes_count'];
        $likeuserarray = explode(',', $artdata[0]['artistic_comment_like_user']);

        if (!in_array($userid, $likeuserarray)) {

            $user_array = array_push($likeuserarray, $userid);

            if ($artdata[0]['artistic_comment_likes_count'] == 0) {
                $userid = implode('', $likeuserarray);
            } else {
                $userid = implode(',', $likeuserarray);
            }

            $data = array(
                'artistic_comment_likes_count' => $artistic_comment_likes_count + 1,
                'artistic_comment_like_user' => $userid,
                'modify_date' => date('y-m-d h:i:s')
            );


            $updatdata = $this->common->update_data($data, 'artistic_post_comment', 'artistic_post_comment_id', $post_id);

            // insert notification

            if ($artdata[0]['user_id'] == $userid) {
                
            } else {

                $contition_array = array('not_type' => 5, 'not_from_id' => $userid, 'not_to_id' => $artdata[0]['user_id'], 'not_product_id' => $post_id, 'not_from' => 3, 'not_img' => 3);
                $artnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if ($artnotification[0]['not_read'] == 2) {
                    
                } elseif ($artnotification[0]['not_read'] == 1) {

                    $datalike = array(
                        'not_read' => 2
                    );

                    $where = array('not_type' => 5, 'not_from_id' => $userid, 'not_to_id' => $artdata[0]['user_id'], 'not_product_id' => $post_id, 'not_from' => 3, 'not_img' => 3);
                    $this->db->where($where);
                    $updatdata = $this->db->update('notification', $datalike);
                } else {

                    $data = array(
                        'not_type' => 5,
                        'not_from_id' => $userid,
                        'not_to_id' => $artdata[0]['user_id'],
                        'not_read' => 2,
                        'not_product_id' => $post_id,
                        'not_from' => 3,
                        'not_img' => 3,
                        'not_active' => 1,
                        'not_created_date' => date('Y-m-d H:i:s')
                    );

                    $insert_id = $this->common->insert_data_getid($data, 'notification');
                }
            }
            // end notoification


            $contition_array = array('artistic_post_comment_id' => $_POST["post_id"], 'status' => '1');
            $artdata1 = $this->data['artdata1'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($updatdata) {

                //$cmtlike1 = '<div>';
                $cmtlike1 = '<a id="' . $artdata1[0]['artistic_post_comment_id'] . '" onClick="comment_like(this.id)">';
                $cmtlike1 .= ' <i class="fa fa-thumbs-up main_color" aria-hidden="true">';
                $cmtlike1 .= '</i>';
                $cmtlike1 .= '<span> ';

                if ($artdata1[0]['artistic_comment_likes_count'] > 0) {
                    $cmtlike1 .= $artdata1[0]['artistic_comment_likes_count'] . '';
                }
                $cmtlike1 .= '</span>';
                $cmtlike1 .= '</a>';
                //$cmtlike1 .= '</div>';
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
                'artistic_comment_likes_count' => $artistic_comment_likes_count - 1,
                'artistic_comment_like_user' => implode(',', $likeuserarray),
                'modify_date' => date('y-m-d h:i:s')
            );

            $updatdata = $this->common->update_data($data, 'artistic_post_comment', 'artistic_post_comment_id', $post_id);
            $contition_array = array('artistic_post_comment_id' => $_POST["post_id"], 'status' => '1');
            $artdata2 = $this->data['artdata2'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($updatdata) {


                //$cmtlike1 = '<div>';
                $cmtlike1 = '<a id="' . $artdata2[0]['artistic_post_comment_id'] . '" onClick="comment_like(this.id)">';
                $cmtlike1 .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true">';
                $cmtlike1 .= '</i>';
                $cmtlike1 .= '<span>';
                if ($artdata2[0]['artistic_comment_likes_count']) {
                    $cmtlike1 .= $artdata2[0]['artistic_comment_likes_count'] . '';
                }
                $cmtlike1 .= '</span>';
                $cmtlike1 .= '</a>';
                //$cmtlike1 .= '</div>';
                echo $cmtlike1;
            } else {
                
            }
        }
       }
    }

    public function like_comment1() {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End
        $post_id = $_POST["post_id"];

        $contition_array = array('artistic_post_comment_id' => $_POST["post_id"], 'status' => '1');
        $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        $condition_array = array('art_post_id' =>  $artdata[0]['art_post_id']);
        $profile_data = $this->common->select_data_by_condition('art_post', $condition_array, $data = 'status,user_id,is_delete,posted_user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($profile_data); die();
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

       // echo  $return; die();
         if($return == 0){
            
           $datavl = "notavl";
            echo  $datavl;

         }else{
        

        $contition_array = array('artistic_post_comment_id' => $_POST["post_id"], 'status' => '1');
        $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $artistic_comment_likes_count = $artdata[0]['artistic_comment_likes_count'];
        $likeuserarray = explode(',', $artdata[0]['artistic_comment_like_user']);

        if (!in_array($userid, $likeuserarray)) {

            $user_array = array_push($likeuserarray, $userid);

            if ($artdata[0]['artistic_comment_likes_count'] == 0) {
                $useridcl = implode('', $likeuserarray);
            } else {
                $useridcl = implode(',', $likeuserarray);
            }

            $data = array(
                'artistic_comment_likes_count' => $artistic_comment_likes_count + 1,
                'artistic_comment_like_user' => $useridcl,
                'modify_date' => date('y-m-d h:i:s')
            );


            $updatdata = $this->common->update_data($data, 'artistic_post_comment', 'artistic_post_comment_id', $post_id);


            // insert notification

            if ($artdata[0]['user_id'] == $userid) {
                
            } else {


                $contition_array = array('not_type' => 5, 'not_from_id' => $userid, 'not_to_id' => $artdata[0]['user_id'], 'not_product_id' => $post_id, 'not_from' => 3, 'not_img' => 3);
                $artnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if ($artnotification[0]['not_read'] == 2) {
                    
                } elseif ($artnotification[0]['not_read'] == 1) {

                    $datalike = array(
                        'not_read' => 2
                    );

                    $where = array('not_type' => 5, 'not_from_id' => $userid, 'not_to_id' => $artdata[0]['user_id'], 'not_product_id' => $post_id, 'not_from' => 3, 'not_img' => 3);
                    $this->db->where($where);
                    $updatdata = $this->db->update('notification', $datalike);
                } else {
                    $data = array(
                        'not_type' => 5,
                        'not_from_id' => $userid,
                        'not_to_id' => $artdata[0]['user_id'],
                        'not_read' => 2,
                        'not_product_id' => $post_id,
                        'not_from' => 3,
                        'not_img' => 3,
                        'not_active' => 1,
                        'not_created_date' => date('Y-m-d H:i:s')
                    );

                    $insert_id = $this->common->insert_data_getid($data, 'notification');
                }
            }
            // end notoification


            $contition_array = array('artistic_post_comment_id' => $_POST["post_id"], 'status' => '1');
            $artdata1 = $this->data['artdata1'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($updatdata) {

                //$cmtlike1 = '<div>';
                $cmtlike1 = '<a id="' . $artdata1[0]['artistic_post_comment_id'] . '" onClick="comment_like1(this.id)">';
                $cmtlike1 .= ' <i class="fa fa-thumbs-up main_color" aria-hidden="true">';
                $cmtlike1 .= '</i>';
                $cmtlike1 .= '<span> ';

                if ($artdata1[0]['artistic_comment_likes_count'] > 0) {
                    $cmtlike1 .= $artdata1[0]['artistic_comment_likes_count'] . '';
                }
                $cmtlike1 .= '</span>';
                $cmtlike1 .= '</a>';
                //$cmtlike1 .= '</div>';
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
                'artistic_comment_likes_count' => $artistic_comment_likes_count - 1,
                'artistic_comment_like_user' => implode(',', $likeuserarray),
                'modify_date' => date('y-m-d h:i:s')
            );

            $updatdata = $this->common->update_data($data, 'artistic_post_comment', 'artistic_post_comment_id', $post_id);
            $contition_array = array('artistic_post_comment_id' => $_POST["post_id"], 'status' => '1');
            $artdata2 = $this->data['artdata2'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($updatdata) {


                //$cmtlike1 = '<div>';
                $cmtlike1 = '<a id="' . $artdata2[0]['artistic_post_comment_id'] . '" onClick="comment_like1(this.id)">';
                $cmtlike1 .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true">';
                $cmtlike1 .= '</i>';
                $cmtlike1 .= '<span>';
                if ($artdata2[0]['artistic_comment_likes_count']) {
                    $cmtlike1 .= $artdata2[0]['artistic_comment_likes_count'] . '';
                }
                $cmtlike1 .= '</span>';
                $cmtlike1 .= '</a>';
                //$cmtlike1 .= '</div>';
                echo $cmtlike1;
            } else {
                
            }
        }

      }
    }

// Artistic comment like end 
//Artistic comment delete start
    public function delete_comment() {
        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End
        $post_id = $_POST["post_id"];


        $contition_array = array('artistic_post_comment_id' => $_POST["post_id"], 'status' => '1');
        $artdatacom = $this->data['artdatacom'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $condition_array = array('art_post_id' => $artdatacom[0]['art_post_id']);
        $profile_data = $this->common->select_data_by_condition('art_post', $condition_array, $data = 'status,user_id,is_delete,posted_user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($profile_data); die();
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

        // echo  $dataavl; die();
         if($return == 0){
            
           $datavl = "notavl";
            echo json_encode(
                        array(
                            "notavlpost" => $datavl,
                           
                ));

         }else{
        

        $post_delete = $_POST["post_delete"];

        $data = array(
            'status' => 0,
        );

        $updatdata = $this->common->update_data($data, 'artistic_post_comment', 'artistic_post_comment_id', $post_id);

        $contition_array = array('art_post_id' => $post_delete, 'status' => '1');
        $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = 'artistic_post_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');
//echo '<pre>'; print_r($artdata); die();
        // all count of commnet 

        $contition_array = array('art_post_id' => $_POST["post_delete"], 'status' => '1');
        $allcomnt = $this->data['allcomnt'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = 'artistic_post_comment_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// khyati changes start
        if (count($artdata) > 0) {
            foreach ($artdata as $art) {

                $artname = $this->db->get_where('art_reg', array('user_id' => $art['user_id'], 'status' => 1))->row()->art_name;
                $artlastname = $this->db->get_where('art_reg', array('user_id' => $art['user_id']))->row()->art_lastname;
                $art_userimage = $this->db->get_where('art_reg', array('user_id' => $art['user_id'], 'status' => 1))->row()->art_user_image;

                 $art_slug = $this->db->get_where('art_reg', array('user_id' => $art['user_id'], 'status' => 1))->row()->slug;

                $cmtinsert .= '<div class="all-comment-comment-box">';
                $cmtinsert .= '<div class="post-design-pro-comment-img">';
                $cmtinsert .= '<a href="' . base_url('artistic/dashboard/' . $art_slug . '') . '">';


                if($art_userimage){





if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                            $a = $artname;
                            $acr = substr($a, 0, 1);
                            $b = $artlastname;
                            $bcr = substr($b, 0, 1);

                                $cmtinsert .= '<div class="post-img-div">';
                                $cmtinsert .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                                $cmtinsert .=  '</div>';


                        } else {

                $cmtinsert .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage . '" alt="">';

                    }

                  // $cmtinsert .= '</div>';
                  }else{

                          $a = $artname;
                            $acr = substr($a, 0, 1);
                            $b = $artlastname;
                            $bcr = substr($b, 0, 1);

                    $cmtinsert .= '<div class="post-img-div">';
                    $cmtinsert .=  ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                    $cmtinsert .=  '</div>';


                    
                  }
                   $cmtinsert .= '</a>';
                   $cmtinsert .= '</div>';


                $cmtinsert .= '<div class="comment-name">';
                $cmtinsert .= '<a href="' . base_url('artistic/dashboard/' .  $art_slug . '') . '">

                <b>' . ucfirst(strtolower($artname)) . '&nbsp;' . ucfirst(strtolower($artlastname)) . '</b></a>';
                $cmtinsert .= '</div>';
               
                $cmtinsert .= '<div class="comment-details" id="showcomment' . $art['artistic_post_comment_id'] . '" >';
                $cmtinsert .= $this->common->make_links($art['comments']);
                $cmtinsert .= '</div>';
                $cmtinsert .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';

//              $cmtinsert .= '<textarea  name="' . $art['artistic_post_comment_id'] . '" id="editcomment' . $art['artistic_post_comment_id'] . '" style="display:none" onClick="commentedit(this.name)">';
//              $cmtinsert .= '' . $art['comments'] . '';
//              $cmtinsert .= '</textarea>';

                $cmtinsert .= '<div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="' . $art['artistic_post_comment_id'] . '"  id="editcomment' . $art['artistic_post_comment_id'] . '" placeholder="Type Message ..." value= ""  onkeyup="commentedit(' . $art['artistic_post_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $art['comments'] . '</div>';
                $cmtinsert .= '<span class="comment-edit-button"><button id="editsubmit' . $art['artistic_post_comment_id'] . '" style="display:none" onClick="edit_comment(' . $art['artistic_post_comment_id'] . ')">Save</button></span>';
                $cmtinsert .= '</div></div>';

//              $cmtinsert .= '<button id="editsubmit' . $art['artistic_post_comment_id'] . '" style="display:none" onClick="edit_comment(' . $art['artistic_post_comment_id'] . ')">Comment</button><div class="art-comment-menu-design"> <div class="comment-details-menu" id="likecomment1' . $art['artistic_post_comment_id'] . '">';

                $cmtinsert .= '<div class="art-comment-menu-design"><div class="comment-details-menu" id="likecomment1' . $art['artistic_post_comment_id'] . '">';
                $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_like1(this.id)">';

                $userid = $this->session->userdata('aileenuser');
                $contition_array = array('artistic_post_comment_id' => $art['artistic_post_comment_id'], 'status' => '1');
                $artcommentlike = $this->data['artcommentlike'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                $likeuserarray = explode(',', $artcommentlike[0]['artistic_comment_like_user']);

                if (!in_array($userid, $likeuserarray)) {


                    $cmtinsert .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
                } else {
                    $cmtinsert .= '<i class="fa fa-thumbs-up main_color" aria-hidden="true"></i>';
                }
                $cmtinsert .= '<span> ';

                if ($art['artistic_comment_likes_count'] > 0) {
                    $cmtinsert .= '' . $art['artistic_comment_likes_count'];
                }
                $cmtinsert .= '</span>';
                $cmtinsert .= '</a></div>';

                $userid = $this->session->userdata('aileenuser');
                if ($art['user_id'] == $userid) {
                    $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $cmtinsert .= '<div class="comment-details-menu">';
                    $cmtinsert .= '<div id="editcommentbox' . $art['artistic_post_comment_id'] . '" style="display:block;">';
                    $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '"';
                    $cmtinsert .= 'onClick="comment_editbox(this.id)">';
                    $cmtinsert .= 'Edit';
                    $cmtinsert .= '</a></div>';
                    $cmtinsert .= '<div id="editcancle' . $art['artistic_post_comment_id'] . '" style="display:none;">';
                    $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '" onClick="comment_editcancle(this.id)">Cancel  </a></div>';
                    $cmtinsert .= '</div>';
                }

                $userid = $this->session->userdata('aileenuser');
                $art_userid = $this->db->get_where('art_post', array('art_post_id' => $art['art_post_id'], 'status' => 1))->row()->user_id;
                if ($art['user_id'] == $userid || $art_userid == $userid) {

                    $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $cmtinsert .= '<div class="comment-details-menu">';
                    $cmtinsert .=  '<input type="hidden" name="post_delete"';
                    $cmtinsert .=  'id="post_delete' . $art['artistic_post_comment_id'] . '" value= "' . $art['art_post_id'] . '">';
                    $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '"   onClick="comment_delete(this.id)"> Delete';
                    $cmtinsert .= '<span class="insertcomment' . $art['artistic_post_comment_id'] . '"></span>';
                    $cmtinsert .=  '</a></div>';
 
                }
                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';
                $cmtinsert .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($art['created_date']))) . '</p></div></div></div>';

                $cmtcount = '<a onclick="commentall(this.id)" id="' . $art['art_post_id'] . '">';
                $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">' .
                        count($allcomnt) . '</i></a>';
                
                $cntinsert =  '<span class="comment_count" >';
                          if (count($allcomnt) > 0) {
           $cntinsert .= '' . count($allcomnt) . ''; 
           $cntinsert .=   '</span>'; 
           $cntinsert .=  '<span> Comment</span>';
                                }
            }
        } else {
//            $cmtcount = '<a onClick="commentall(this.id)" id="' . $art['art_post_id'] . '">';
//            $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
//            $cmtcount .= '</i></a>';
            $cmtcount = '';
        }
        echo json_encode(
                array("comment" => $cmtinsert,
                    "count" => $cmtcount,
                    "commentcount" => $cntinsert));

      }
    }



public function delete_comment_postnewpage() {
        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End
        $post_id = $_POST["post_id"];
        $post_delete = $_POST["post_delete"];

        $data = array(
            'status' => 0,
        );

        $updatdata = $this->common->update_data($data, 'artistic_post_comment', 'artistic_post_comment_id', $post_id);

        $contition_array = array('art_post_id' => $post_delete, 'status' => '1');
        $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = 'artistic_post_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');
//echo '<pre>'; print_r($artdata); die();
        // all count of commnet 

        $contition_array = array('art_post_id' => $_POST["post_delete"], 'status' => '1');
        $allcomnt = $this->data['allcomnt'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = 'artistic_post_comment_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// khyati changes start
        if (count($artdata) > 0) {
            foreach ($artdata as $art) {

                $artname = $this->db->get_where('art_reg', array('user_id' => $art['user_id'], 'status' => 1))->row()->art_name;
                $artlastname = $this->db->get_where('art_reg', array('user_id' => $art['user_id']))->row()->art_lastname;
                $art_userimage = $this->db->get_where('art_reg', array('user_id' => $art['user_id'], 'status' => 1))->row()->art_user_image;
                $art_slug = $this->db->get_where('art_reg', array('user_id' => $art['user_id'], 'status' => 1))->row()->slug;

                $cmtinsert .= '<div class="all-comment-comment-box">';
                $cmtinsert .= '<div class="post-design-pro-comment-img">';
                $cmtinsert .= '<a href="' . base_url('artistic/dashboard/' . $art_slug . '') . '">';

                if($art_userimage){

if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                            $a = $artname;
                            $acr = substr($a, 0, 1);
                            $b = $artlastname;
                            $bcr = substr($b, 0, 1);

                                $cmtinsert .= '<div class="post-img-div">';
                                $cmtinsert .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                                $cmtinsert .=  '</div>';


                        } else {

                $cmtinsert .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage . '" alt="">';

                    }

                  }else{

                          $a = $artname;
                            $acr = substr($a, 0, 1);
                            $b = $artlastname;
                            $bcr = substr($b, 0, 1);

                    $cmtinsert .= '<div class="post-img-div">';
                    $cmtinsert .=  ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                    $cmtinsert .=  '</div>';


                    

                  }
                $cmtinsert .= '</a>';
                  $cmtinsert .= '</div>';


                $cmtinsert .= '<div class="comment-name">';
                $cmtinsert .= '<a href="' . base_url('artistic/dashboard/' . $art_slug . '') . '">
                <b>' . ucfirst(strtolower($artname)) . '&nbsp;' . ucfirst(strtolower($artlastname)) . '</b></a>';
                $cmtinsert .= '</div>';
                $cmtinsert .= '<div class="comment-details" id="showcomment' . $art['artistic_post_comment_id'] . '" >';
                $cmtinsert .= $this->common->make_links($art['comments']);
                $cmtinsert .= '</div>';
                $cmtinsert .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';

//              $cmtinsert .= '<textarea  name="' . $art['artistic_post_comment_id'] . '" id="editcomment' . $art['artistic_post_comment_id'] . '" style="display:none" onClick="commentedit(this.name)">';
//              $cmtinsert .= '' . $art['comments'] . '';
//              $cmtinsert .= '</textarea>';

                $cmtinsert .= '<div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="' . $art['artistic_post_comment_id'] . '"  id="editcomment' . $art['artistic_post_comment_id'] . '" placeholder="Type Message ..." value= ""  onkeyup="commentedit(' . $art['artistic_post_comment_id'] .','.$post_delete.')" onpaste="OnPaste_StripFormatting(this, event);">' . $art['comments'] . '</div>';
                $cmtinsert .= '<span class="comment-edit-button"><button id="editsubmit' . $art['artistic_post_comment_id'] . '" style="display:none" onClick="edit_comment(' . $art['artistic_post_comment_id'] .','.$post_delete.')">Save</button></span>';
                $cmtinsert .= '</div></div>';

//              $cmtinsert .= '<button id="editsubmit' . $art['artistic_post_comment_id'] . '" style="display:none" onClick="edit_comment(' . $art['artistic_post_comment_id'] . ')">Comment</button><div class="art-comment-menu-design"> <div class="comment-details-menu" id="likecomment1' . $art['artistic_post_comment_id'] . '">';

                $cmtinsert .= '<div class="art-comment-menu-design"><div class="comment-details-menu" id="likecomment1' . $art['artistic_post_comment_id'] . '">';
                $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_like1(this.id)">';

                $userid = $this->session->userdata('aileenuser');
                $contition_array = array('artistic_post_comment_id' => $art['artistic_post_comment_id'], 'status' => '1');
                $artcommentlike = $this->data['artcommentlike'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                $likeuserarray = explode(',', $artcommentlike[0]['artistic_comment_like_user']);

                if (!in_array($userid, $likeuserarray)) {


                    $cmtinsert .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
                } else {
                    $cmtinsert .= '<i class="fa fa-thumbs-up main_color" aria-hidden="true"></i>';
                }
                $cmtinsert .= '<span> ';

                if ($art['artistic_comment_likes_count'] > 0) {
                    $cmtinsert .= '' . $art['artistic_comment_likes_count'];
                }
                $cmtinsert .= '</span>';
                $cmtinsert .= '</a></div>';

                $userid = $this->session->userdata('aileenuser');
                if ($art['user_id'] == $userid) {
                    $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $cmtinsert .= '<div class="comment-details-menu">';
                    $cmtinsert .= '<div id="editcommentbox' . $art['artistic_post_comment_id'] . '" style="display:block;">';
                    $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '"';
                    $cmtinsert .= 'onClick="comment_editbox(this.id,'.$post_delete.')">';
                    $cmtinsert .= 'Edit';
                    $cmtinsert .= '</a></div>';
                    $cmtinsert .= '<div id="editcancle' . $art['artistic_post_comment_id'] . '" style="display:none;">';
                    $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '" onClick="comment_editcancle(this.id,'.$post_delete.')">Cancel  </a></div>';
                    $cmtinsert .= '</div>';
                }

                $userid = $this->session->userdata('aileenuser');
                $art_userid = $this->db->get_where('art_post', array('art_post_id' => $art['art_post_id'], 'status' => 1))->row()->user_id;
                if ($art['user_id'] == $userid || $art_userid == $userid) {

                    $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $cmtinsert .= '<div class="comment-details-menu">';
                    $cmtinsert .=  '<input type="hidden" name="post_delete"';
                    $cmtinsert .=  'id="post_delete' . $art['artistic_post_comment_id'] . '" value= "' . $art['art_post_id'] . '">';
                    $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '"   onClick="comment_delete(this.id)"> Delete';
                    $cmtinsert .= '<span class="insertcomment' . $art['artistic_post_comment_id'] . '"></span>';
                    $cmtinsert .=  '</a></div>';
 
                }
                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';
                $cmtinsert .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($art['created_date']))) . '</p></div></div></div>';

                $cmtcount = '<a onclick="commentall(this.id)" id="' . $art['art_post_id'] . '">';
                $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">' .
                        count($allcomnt) . '</i></a>';
                
                $cntinsert =  '<span class="comment_count" >';
                          if (count($allcomnt) > 0) {
           $cntinsert .= '' . count($allcomnt) . ''; 
           $cntinsert .=   '</span>'; 
           $cntinsert .=  '<span> Comment</span>';
                                }
            }
        } else {
//            $cmtcount = '<a onClick="commentall(this.id)" id="' . $art['art_post_id'] . '">';
//            $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
//            $cmtcount .= '</i></a>';
            $cmtcount = '';
        }
        echo json_encode(
                array("comment" => $cmtinsert,
                    "count" => $cmtcount,
                    "commentcount" => $cntinsert));
    }


    public function delete_commenttwo() {
        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End
        $post_id = $_POST["post_id"];
         $contition_array = array('artistic_post_comment_id' => $_POST["post_id"], 'status' => '1');
        $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $condition_array = array('art_post_id' => $artdata[0]['art_post_id']);
        $profile_data = $this->common->select_data_by_condition('art_post', $condition_array, $data = 'status,user_id,is_delete,posted_user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($profile_data); die();
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

        // echo  $dataavl; die();
         if($return == 0){
            
           $datavl = "notavl";
            echo json_encode(
                        array(
                            "notavlpost" => $datavl,
                           
                ));

         }else{
        
        $post_delete = $_POST["post_delete"];

        $data = array(
            'status' => 0,
        );

        $updatdata = $this->common->update_data($data, 'artistic_post_comment', 'artistic_post_comment_id', $post_id);


        $contition_array = array('art_post_id' => $post_delete, 'status' => '1');
        $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = 'artistic_post_comment_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
//echo '<pre>'; print_r($artdata); die();
// khyati changes start
        if (count($artdata) > 0) {
            foreach ($artdata as $art) {

                $artname = $this->db->get_where('art_reg', array('user_id' => $art['user_id'], 'status' => 1))->row()->art_name;

                $artlastname = $this->db->get_where('art_reg', array('user_id' => $art['user_id']))->row()->art_lastname;
                $artslug = $this->db->get_where('art_reg', array('user_id' => $art['user_id']))->row()->slug;


                $art_userimage = $this->db->get_where('art_reg', array('user_id' => $art['user_id'], 'status' => 1))->row()->art_user_image;

                $cmtinsert .= '<div class="all-comment-comment-box">';
                $cmtinsert .= '<div class="post-design-pro-comment-img">';
                $cmtinsert .= '<a href="' . base_url('artistic/dashboard/' . $artslug . '') . '">';

                if($art_userimage){

                    if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                            $a = $artname;
                            $acr = substr($a, 0, 1);
                            $b = $artlastname;
                            $bcr = substr($b, 0, 1);

                                $cmtinsert .= '<div class="post-img-div">';
                                $cmtinsert .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                                $cmtinsert .=  '</div>';


                        } else {


                $cmtinsert .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL. $art_userimage . '" alt="">';

                    }

                  
                }else{


                         $a = $artname;
                            $acr = substr($a, 0, 1);
                            $b = $artlastname;
                            $bcr = substr($b, 0, 1);

                    $cmtinsert .= '<div class="post-img-div">';
                    $cmtinsert .=  ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                    $cmtinsert .=  '</div>';  

                }
                $cmtinsert .= '</a>';
                $cmtinsert .= '</div>';
                $cmtinsert .= '<div class="comment-name">';
                $cmtinsert .= '<a href="' . base_url('artistic/dashboard/' . $artslug . '') . '">

                <b>' . ucfirst(strtolower($artname)) . '&nbsp;' . ucfirst(strtolower($artlastname)) . '</b></a>';
                $cmtinsert .= '</div>';
                
                $cmtinsert .= '<div class="comment-details" id= "showcommenttwo' . $art['artistic_post_comment_id'] . '" >';
                $cmtinsert .= $this->common->make_links($art['comments']);
                $cmtinsert .= '</div>';

                $cmtinsert .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';
//            $cmtinsert .= '<textarea  name="' . $art['artistic_post_comment_id'] . '" id="editcommenttwo' . $art['artistic_post_comment_id'] . '" style="display:none" onClick="commentedittwo(this.name)">';
//            $cmtinsert .= '' . $art['comments'] . '';
//            $cmtinsert .= '</textarea>';
                $cmtinsert .= '<div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="' . $art['artistic_post_comment_id'] . '"  id="editcommenttwo' . $art['artistic_post_comment_id'] . '" placeholder="Type Message ..." value= ""  onkeyup="commentedittwo(' . $art['artistic_post_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $art['comments'] . '</div>';
                //$cmtinsert .= '<button id="editsubmittwo' . $art['artistic_post_comment_id'] . '" style="display:none" onClick="edit_commenttwo(' . $art['artistic_post_comment_id'] . ')">Comment</button><div class="art-comment-menu-design"> <div class="comment-details-menu" id="likecomment1' . $art['artistic_post_comment_id'] . '">';
                $cmtinsert .= '<span class="comment-edit-button"><button id="editsubmittwo' . $art['artistic_post_comment_id'] . '" style="display:none" onClick="edit_commenttwo(' . $art['artistic_post_comment_id'] . ')">Save</button></span>';
                $cmtinsert .= '</div></div>';

                $cmtinsert .= '<div class="art-comment-menu-design"><div class="comment-details-menu" id="likecomment1' . $art['artistic_post_comment_id'] . '">';
                $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_like1(this.id)">';

                $userid = $this->session->userdata('aileenuser');
                $contition_array = array('artistic_post_comment_id' => $art['artistic_post_comment_id'], 'status' => '1');
                $artcommentlike = $this->data['artcommentlike'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                $likeuserarray = explode(',', $artcommentlike[0]['artistic_comment_like_user']);

                if (!in_array($userid, $likeuserarray)) {


                    $cmtinsert .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
                } else {
                    $cmtinsert .= '<i class="fa fa-thumbs-up main_color" aria-hidden="true"></i>';
                }
                $cmtinsert .= '<span> ';

                if ($art['artistic_comment_likes_count'] > 0) {
                    $cmtinsert .= '' . $art['artistic_comment_likes_count'];
                }
                $cmtinsert .= '</span>';
                $cmtinsert .= '</a></div>';

                $userid = $this->session->userdata('aileenuser');
                if ($art['user_id'] == $userid) {

                    $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $cmtinsert .= '<div class="comment-details-menu">';


                    $cmtinsert .= '<div id="editcommentboxtwo' . $art['artistic_post_comment_id'] . '" style="display:block;">';
                    $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '"';
                    $cmtinsert .= 'onClick="comment_editboxtwo(this.id)">';
                    $cmtinsert .= 'Edit';
                    $cmtinsert .= '</a></div>';
                    $cmtinsert .= '<div id="editcancletwo' . $art['artistic_post_comment_id'] . '" style="display:none;">';
                    $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '" onClick="comment_editcancletwo(this.id)">Cancel  </a></div>';

                    $cmtinsert .= '</div>';
                }

                $userid = $this->session->userdata('aileenuser');

                $art_userid = $this->db->get_where('art_post', array('art_post_id' => $art['art_post_id'], 'status' => 1))->row()->user_id;

                if ($art['user_id'] == $userid || $art_userid == $userid) {
                    $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $cmtinsert .= '<div class="comment-details-menu">';
                    $cmtinsert .= '<input type="hidden" name="post_delete"';
                    $cmtinsert .= 'id="post_deletetwo"';
                    $cmtinsert .= 'value= "' . $art['art_post_id'] . '">';

                    $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '"';
                    $cmtinsert .= 'onClick="comment_deletetwo(this.id)">';
                    $cmtinsert .= 'Delete';
                    $cmtinsert .= '</a></div>';
                }
                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';
                $cmtinsert .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($art['created_date']))) . '</p></div></div></div>';

                // comment aount variable start
                $idpost = $art['art_post_id'];
                $cmtcount = '<a onClick="commentall1(this.id)" id="' . $idpost . '">';
                $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
                $cmtcount .= ' ' . count($artdata) . '';
                $cmtcount .= '</i></a>';
                
           $cntinsert =  '<span class="comment_count" >';
                          if (count($artdata) > 0) {
           $cntinsert .= '' . count($artdata) . ''; 
           $cntinsert .=   '</span>'; 
           $cntinsert .=  '<span> Comment</span>';
                                }
            }
        } else {
//            $idpost = $art['art_post_id'];
//            $cmtcount = '<a onClick="commentall1(this.id)" id="' . $idpost . '">';
//            $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
//            $cmtcount .= '</i></a>';
            $cmtcount .= '';
        }
        //echo $cmtinsert;
        echo json_encode(
                array("comment" => $cmtinsert,
                    "count" => $cmtcount,
                    "commentcount" => $cntinsert));

       }
    }


public function delete_commenttwo_postnewpage() {
        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End
        $post_id = $_POST["post_id"];
        $post_delete = $_POST["post_delete"];

        $data = array(
            'status' => 0,
        );

        $updatdata = $this->common->update_data($data, 'artistic_post_comment', 'artistic_post_comment_id', $post_id);


        $contition_array = array('art_post_id' => $post_delete, 'status' => '1');
        $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = 'artistic_post_comment_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
//echo '<pre>'; print_r($artdata); die();
// khyati changes start
        if (count($artdata) > 0) {
            foreach ($artdata as $art) {

                $artname = $this->db->get_where('art_reg', array('user_id' => $art['user_id'], 'status' => 1))->row()->art_name;

                $artlastname = $this->db->get_where('art_reg', array('user_id' => $art['user_id']))->row()->art_lastname;

                  $artslug = $this->db->get_where('art_reg', array('user_id' => $art['user_id']))->row()->slug;

                $art_userimage = $this->db->get_where('art_reg', array('user_id' => $art['user_id'], 'status' => 1))->row()->art_user_image;

                $cmtinsert .= '<div class="all-comment-comment-box">';
                $cmtinsert .= '<div class="post-design-pro-comment-img">';
                $cmtinsert .= '<a href="' . base_url('artistic/dashboard/' . $artslug . '') . '">';

                if($art_userimage){

                    if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                            $a = $artname;
                            $acr = substr($a, 0, 1);
                            $b = $artlastname;
                            $bcr = substr($b, 0, 1);

                                $cmtinsert .= '<div class="post-img-div">';
                                $cmtinsert .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                                $cmtinsert .=  '</div>';


                        } else {


                $cmtinsert .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage . '" alt="">';

                    }

                  
                }else{


                          $a = $artname;
                            $acr = substr($a, 0, 1);
                            $b = $artlastname;
                            $bcr = substr($b, 0, 1);

                    $cmtinsert .= '<div class="post-img-div">';
                    $cmtinsert .=  ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                    $cmtinsert .=  '</div>';
                   
                }
                  $cmtinsert .= '</a>';

                $cmtinsert .= '</div>';

                $cmtinsert .= '<div class="comment-name">';
                $cmtinsert .= '<a href="' . base_url('artistic/dashboard/' . $artslug . '') . '">

                <b>' . ucfirst(strtolower($artname)) . '&nbsp;' . ucfirst(strtolower($artlastname)) . '</b></a>';
                $cmtinsert .= '</div>';
              
                $cmtinsert .= '<div class="comment-details" id= "showcommenttwo' . $art['artistic_post_comment_id'] . '" >';
                $cmtinsert .= $this->common->make_links($art['comments']);
                $cmtinsert .= '</div>';

                $cmtinsert .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';
//            $cmtinsert .= '<textarea  name="' . $art['artistic_post_comment_id'] . '" id="editcommenttwo' . $art['artistic_post_comment_id'] . '" style="display:none" onClick="commentedittwo(this.name)">';
//            $cmtinsert .= '' . $art['comments'] . '';
//            $cmtinsert .= '</textarea>';
                $cmtinsert .= '<div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="' . $art['artistic_post_comment_id'] . '"  id="editcommenttwo' . $art['artistic_post_comment_id'] . '" placeholder="Type Message ..." value= ""  onkeyup="commentedittwo(' . $art['artistic_post_comment_id'] .','.$post_delete.')" onpaste="OnPaste_StripFormatting(this, event);">' . $art['comments'] . '</div>';
                //$cmtinsert .= '<button id="editsubmittwo' . $art['artistic_post_comment_id'] . '" style="display:none" onClick="edit_commenttwo(' . $art['artistic_post_comment_id'] . ')">Comment</button><div class="art-comment-menu-design"> <div class="comment-details-menu" id="likecomment1' . $art['artistic_post_comment_id'] . '">';
                $cmtinsert .= '<span class="comment-edit-button"><button id="editsubmittwo' . $art['artistic_post_comment_id'] . '" style="display:none" onClick="edit_commenttwo(' . $art['artistic_post_comment_id'] .','.$post_delete.')">Save</button></span>';
                $cmtinsert .= '</div></div>';

                $cmtinsert .= '<div class="art-comment-menu-design"><div class="comment-details-menu" id="likecomment1' . $art['artistic_post_comment_id'] . '">';
                $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_like1(this.id)">';

                $userid = $this->session->userdata('aileenuser');
                $contition_array = array('artistic_post_comment_id' => $art['artistic_post_comment_id'], 'status' => '1');
                $artcommentlike = $this->data['artcommentlike'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                $likeuserarray = explode(',', $artcommentlike[0]['artistic_comment_like_user']);

                if (!in_array($userid, $likeuserarray)) {


                    $cmtinsert .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
                } else {
                    $cmtinsert .= '<i class="fa fa-thumbs-up main_color" aria-hidden="true"></i>';
                }
                $cmtinsert .= '<span> ';

                if ($art['artistic_comment_likes_count'] > 0) {
                    $cmtinsert .= '' . $art['artistic_comment_likes_count'];
                }
                $cmtinsert .= '</span>';
                $cmtinsert .= '</a></div>';

                $userid = $this->session->userdata('aileenuser');
                if ($art['user_id'] == $userid) {

                    $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $cmtinsert .= '<div class="comment-details-menu">';


                    $cmtinsert .= '<div id="editcommentboxtwo' . $art['artistic_post_comment_id'] . '" style="display:block;">';
                    $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '"';
                    $cmtinsert .= 'onClick="comment_editboxtwo(this.id,'.$post_delete.')">';
                    $cmtinsert .= 'Edit';
                    $cmtinsert .= '</a></div>';
                    $cmtinsert .= '<div id="editcancletwo' . $art['artistic_post_comment_id'] . '" style="display:none;">';
                    $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '" onClick="comment_editcancletwo(this.id,'.$post_delete.')">Cancel  </a></div>';

                    $cmtinsert .= '</div>';
                }

                $userid = $this->session->userdata('aileenuser');

                $art_userid = $this->db->get_where('art_post', array('art_post_id' => $art['art_post_id'], 'status' => 1))->row()->user_id;

                if ($art['user_id'] == $userid || $art_userid == $userid) {
                    $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $cmtinsert .= '<div class="comment-details-menu">';
                    $cmtinsert .= '<input type="hidden" name="post_delete"';
                    $cmtinsert .= 'id="post_deletetwo"';
                    $cmtinsert .= 'value= "' . $art['art_post_id'] . '">';

                    $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '"';
                    $cmtinsert .= 'onClick="comment_deletetwo(this.id)">';
                    $cmtinsert .= 'Delete';
                    $cmtinsert .= '</a></div>';
                }
                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';
                $cmtinsert .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($art['created_date']))) . '</p></div></div></div>';

                // comment aount variable start
                $idpost = $art['art_post_id'];
                $cmtcount = '<a onClick="commentall1(this.id)" id="' . $idpost . '">';
                $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
                $cmtcount .= ' ' . count($artdata) . '';
                $cmtcount .= '</i></a>';
                
           $cntinsert =  '<span class="comment_count" >';
                          if (count($artdata) > 0) {
           $cntinsert .= '' . count($artdata) . ''; 
           $cntinsert .=   '</span>'; 
           $cntinsert .=  '<span> Comment</span>';
                                }
            }
        } else {
//            $idpost = $art['art_post_id'];
//            $cmtcount = '<a onClick="commentall1(this.id)" id="' . $idpost . '">';
//            $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
//            $cmtcount .= '</i></a>';
            $cmtcount .= '';
        }
        //echo $cmtinsert;
        echo json_encode(
                array("comment" => $cmtinsert,
                    "count" => $cmtcount,
                    "commentcount" => $cntinsert));
    }

//Artistic comment delete end
// artistics post like start

    public function like_post() {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End
        $post_id = $_POST["post_id"];


         $condition_array = array('art_post_id' => $post_id);
        $profile_data = $this->common->select_data_by_condition('art_post', $condition_array, $data = 'status,user_id,is_delete,posted_user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($profile_data); die();
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

        // echo  $dataavl; die();
         if($return == 0){
            
           $datavl = "notavl";
            echo json_encode(
                        array(
                            "notavlpost" => $datavl,
                           
                ));

         }else{
        

        $contition_array = array('art_post_id' => $_POST["post_id"], 'status' => '1');
        $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $art_likes_count = $artdata[0]['art_likes_count'];
        $likeuserarray = explode(',', $artdata[0]['art_like_user']);

        if (!in_array($userid, $likeuserarray)) {

            $user_array = array_push($likeuserarray, $userid);

            if ($artdata[0]['art_likes_count'] == 0) {
                $useridin = implode('', $likeuserarray);
            } else {
                $useridin = implode(',', $likeuserarray);
            }

            $data = array(
                'art_likes_count' => $art_likes_count + 1,
                'art_like_user' => $useridin,
                'modifiled_date' => date('y-m-d h:i:s')
            );


            $updatdata = $this->common->update_data($data, 'art_post', 'art_post_id', $post_id);



            // insert notification

            if ($artdata[0]['user_id'] == $userid || $artdata[0]['is_delete'] == '1') {
                
            } else {

                $contition_array = array('not_type' => 5, 'not_from_id' => $userid, 'not_to_id' => $artdata[0]['user_id'], 'not_product_id' => $post_id, 'not_from' => 3, 'not_img' => 2);
                $artnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if ($artnotification[0]['not_read'] == 2) {
                    
                } elseif ($artnotification[0]['not_read'] == 1) {

                    $datalike = array(
                        'not_read' => 2
                    );

                    $where = array('not_type' => 5, 'not_from_id' => $userid, 'not_to_id' => $artdata[0]['user_id'], 'not_product_id' => $post_id, 'not_from' => 3, 'not_img' => 2);
                    $this->db->where($where);
                    $updatdata = $this->db->update('notification', $datalike);
                } else {

                    $data = array(
                        'not_type' => 5,
                        'not_from_id' => $userid,
                        'not_to_id' => $artdata[0]['user_id'],
                        'not_read' => 2,
                        'not_product_id' => $post_id,
                        'not_from' => 3,
                        'not_img' => 2,
                        'not_active' => 1,
                        'not_created_date' => date('Y-m-d H:i:s')
                    );

                    $insert_id = $this->common->insert_data_getid($data, 'notification');
                }
            }
            // end notoification



            $contition_array = array('art_post_id' => $_POST["post_id"], 'status' => '1');
            $artdata1 = $this->data['artdata1'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($updatdata) {

                $cmtlike = '<li>';
                $cmtlike .= '<a id="' . $artdata1[0]['art_post_id'] . '" class="ripple like_h_w" onClick="post_like(this.id)">';
                $cmtlike .= ' <i class="fa fa-thumbs-up fa-1x main_color" aria-hidden="true">';
                $cmtlike .= '</i>';
                $cmtlike .= '<span class="like_As_count"> ';
                if ($artdata1[0]['art_likes_count'] > 0) {
                    $cmtlike .= $artdata1[0]['art_likes_count'] . '';
                }
                $cmtlike .= '</span>';
                $cmtlike .= '</a>';
                $cmtlike .= '</li>';

                //popup box start like user name
//         $cmtlikeuser .= '<div id=popuplike' . $artdata1[0]['art_post_id'].' class="overlay">';
//         $cmtlikeuser .= '<div class="popup">';
//         $cmtlikeuser .= '<div class="pop_content">';

                $contition_array = array('art_post_id' => $artdata1[0]['art_post_id'], 'status' => '1', 'is_delete' => '0');
                $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $likeuser = $commnetcount[0]['art_like_user'];
                //echo "<pre>"; print_r($likeuser); die();
                $countlike = $commnetcount[0]['art_likes_count'] - 1;

                //$likelistarray = explode(',', $likeuser);
                //   $likelistarray = array_reverse($likelistarray);

                foreach ($likelistarray as $key => $value) {
                    $art_fname1 = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => 1))->row()->art_name;
                    $art_lname1 = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => 1))->row()->art_lastname;
//      $cmtlikeuser .= '<a href="'.base_url('artistic/art_manage_post/'.$value).'">';
//
//       $cmtlikeuser .= '' . ucwords($art_fname1) . '' . ucwords($art_lname1) . '&nbsp;';
//
//      $cmtlikeuser .= '</a>';
                }
//         $cmtlikeuser .= '<p class="okk"><a class="cnclbtn" href="#">Cancel</a></p>';
//         $cmtlikeuser .= '</div>';
//         $cmtlikeuser .= '</div>';
//         $cmtlikeuser .= '</div>';
                //popup box end like user name
//            $cmtlikeuser .= '<a href=#popuplike'. $artdata1[0]['art_post_id'].'>';
             $cmtlikeuser .= '<div class="like_one_other">';

                $cmtlikeuser .= ' <a href="javascript:void(0);"  onclick="likeuserlist(' . $artdata1[0]['art_post_id'] . ');">';
                $contition_array = array('art_post_id' => $artdata1[0]['art_post_id'], 'status' => '1', 'is_delete' => '0');
                $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $likeuser = $commnetcount[0]['art_like_user'];
                $countlike = $commnetcount[0]['art_likes_count'] - 1;

                $likelistarray = explode(',', $likeuser);
                //echo '<pre>'; print_r($likelistarray); die();

                $likelistarray = array_reverse($likelistarray);
                //echo '<pre>'; print_r($likelistarray); die();

              $art_fname = $this->db->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => 1))->row()->art_name;

              $art_lname = $this->db->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => 1))->row()->art_lastname;

                //$cmtlikeuser .= '<div class="fl" style=" padding-left: 22px;" >';
             

                if (in_array($userid, $likelistarray)) { 
                    $cmtlikeuser .= 'You &nbsp';
                } else { 
                    $cmtlikeuser .= '' . ucfirst(strtolower($art_fname)) . '&nbsp;' . ucfirst(strtolower($art_lname)) . '&nbsp;';
                }
             

                if (count($likelistarray) > 1) {

                    // $cmtlikeuser .= '<div class="fl" style="padding-right: 5px;">';
                    $cmtlikeuser .= 'and';
                    // $cmtlikeuser .= '</div>';
                    // $cmtlikeuser .= '<div style="padding-left: 5px;">';
                    $cmtlikeuser .= ' ' . $countlike . ' others';
                    // $cmtlikeuser .= '</div>';
                }

                $cmtlikeuser .= '</a>';
                   $cmtlikeuser .= '</div>';


               // $like_user_count = $commnetcount[0]['art_likes_count'];
                
               $like_count = $commnetcount[0]['art_likes_count'];
             $like_user_count =  '<span class="comment_like_count">'; 
               if ($commnetcount[0]['art_likes_count'] > 0) { 
              $like_user_count .= '' . $commnetcount[0]['art_likes_count'] . ''; 
              $like_user_count .=     '</span>'; 
              $like_user_count .= '<span> Like</span>';
               }
              
                echo json_encode(
                        array("like" => $cmtlike,
                            "likeuser" => $cmtlikeuser,
                            "likecount" => $like_count,
                            "like_user_count" => $like_user_count));
            }
        } else {

            $contition_array = array('art_post_id' => $_POST["post_id"], 'status' => '1');
            $artdata1 = $this->data['artdata1'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            foreach ($likeuserarray as $key => $val) {
                if ($val == $userid) { //echo $key;
                    $user_array = array_splice($likeuserarray, $key, 1);
                }
            }
            $data = array(
                'art_likes_count' => $art_likes_count - 1,
                'art_like_user' => implode(',', $likeuserarray),
                'modifiled_date' => date('y-m-d h:i:s')
            );


            $updatdata = $this->common->update_data($data, 'art_post', 'art_post_id', $post_id);
            $contition_array = array('art_post_id' => $_POST["post_id"], 'status' => '1');
            $artdata2 = $this->data['artdata2'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($updatdata) {


                $cmtlike = '<li>';

                $cmtlike .= '<a id="' . $artdata2[0]['art_post_id'] . '" class="ripple like_h_w" onClick="post_like(this.id)">';

//                $cmtlike .= ' <i class="fa fa-thumbs-o-up fa-1x" aria-hidden="true">';
                $cmtlike .= '<i class="fa fa-thumbs-up" style="color: #999;" aria-hidden="true">';
                $cmtlike .= '</i>';

                $cmtlike .= '<span class="like_As_count">';
                if ($artdata2[0]['art_likes_count'] > 0) {
                    $cmtlike .= $artdata2[0]['art_likes_count'] . '';
                }
                $cmtlike .= '</span>';
                $cmtlike .= '</a>';
                $cmtlike .= '</li>';

                //popup box start like user name
//         $cmtlikeuser .= '<div id=popuplike' . $artdata1[0]['art_post_id'].' class="overlay"';
//         $cmtlikeuser .= '<div class="popup">';
//         $cmtlikeuser .= '<div class="pop_content2">';

                $contition_array = array('art_post_id' => $artdata1[0]['art_post_id'], 'status' => '1', 'is_delete' => '0');
                $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $likeuser = $commnetcount[0]['art_like_user'];
                $countlike = $commnetcount[0]['art_likes_count'] - 1;

               // $likelistarray = explode(',', $likeuser);
                //  $likelistarray = array_reverse($likelistarray);
//        echo '<pre>';
//        print_r($likelistarray);
//        exit;

                foreach ($likelistarray as $key => $value) {

                    $art_fname1 = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => 1))->row()->art_name;

                    $art_lname1 = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => 1))->row()->art_lastname;

//      $cmtlikeuser .= '<a href="'.base_url('artistic/art_manage_post/'.$value).'">';
//
//       $cmtlikeuser .= '' . ucwords($art_fname1) . '' . ucwords($art_lname1) . '&nbsp;';
//
//      $cmtlikeuser .= '</a>';
                }
//         $cmtlikeuser .= '<p class="okk"><a class="cnclbtn" href="#">Cancel</a></p>';
//         $cmtlikeuser .= '</div>';
//         $cmtlikeuser .= '</div>';
//         $cmtlikeuser .= '</div>';
                //popup box end like user name
//            $cmtlikeuser .= '<a href=#popuplike'. $artdata1[0]['art_post_id'].'>';
               $cmtlikeuser .= '<div class="like_one_other">';
               $cmtlikeuser .= ' <a href="javascript:void(0);"  onclick="likeuserlist(' . $artdata1[0]['art_post_id'] . ');">';

                $contition_array = array('art_post_id' => $artdata1[0]['art_post_id'], 'status' => '1', 'is_delete' => '0');
                $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $likeuser = $commnetcount[0]['art_like_user'];
                $countlike = $commnetcount[0]['art_likes_count'] - 1;

                $likelistarray = explode(',', $likeuser);
                $likelistarray = array_reverse($likelistarray);
               // echo '<pre>'; print_r($likelistarray); die();
                //echo "<pre>"; print_r( $likelistarray); die();
                $art_fname = $this->db->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => 1))->row()->art_name;
                $art_lname = $this->db->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => 1))->row()->art_lastname;

                //$cmtlikeuser .= '<div class="fl" style=" padding-left: 22px;" >';
                 if (in_array($userid, $likelistarray)) { //echo "123"; die();
                    $cmtlikeuser .= 'You &nbsp';
                } else { //echo "12f3"; die();
                    $cmtlikeuser .= '' . ucfirst(strtolower($art_fname)) . '&nbsp;' . ucfirst(strtolower($art_lname)) . '&nbsp;';
                }
             

                if (count($likelistarray) > 1) {

                    // $cmtlikeuser .= '<div class="fl" style="padding-right: 5px;">';
                    $cmtlikeuser .= 'and';
                    // $cmtlikeuser .= '</div>';
                    // $cmtlikeuser .= '<div style="padding-left: 5px;">';
                    $cmtlikeuser .= ' ' . $countlike . ' others';
                    // $cmtlikeuser .= '</div>';
                }

                $cmtlikeuser .= '</a>';
                   $cmtlikeuser .= '</div>';

              
               
             $like_count = $commnetcount[0]['art_likes_count'];
             $like_user_count =  '<span class="comment_like_count">'; 
               if ($commnetcount[0]['art_likes_count'] > 0) { 
              $like_user_count .= '' . $commnetcount[0]['art_likes_count'] . ''; 
              $like_user_count .=     '</span>'; 
              $like_user_count .= '<span> Like</span>';
                 }
                                                                      

                echo json_encode(
                        array("like" => $cmtlike,
                            "likeuser" => $cmtlikeuser,
                             "likecount" => $like_count,
                            "like_user_count" => $like_user_count));
            }
        }

       }
    }

// artistics post  like end
//artistic comment insert start

    public function insert_comment() {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $post_id = $_POST["post_id"];

        $condition_array = array('art_post_id' => $id);
        $profile_data = $this->common->select_data_by_condition('art_post', $condition_array, $data = 'status,user_id,is_delete,posted_user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($profile_data); die();
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

        // echo  $dataavl; die();
         if($return == 0){
            
           $datavl = "notavl";
            echo json_encode(
                        array(
                            "notavlpost" => $datavl,
                           
                ));

         }else{
        
        $post_comment = $_POST["comment"];

        $contition_array = array('art_post_id' => $_POST["post_id"], 'status' => '1');
        $artdatacomment = $this->data['artdatacomment'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $data = array(
            'user_id' => $userid,
            'art_post_id' => $post_id,
            'comments' => $post_comment,
            'created_date' => date('Y-m-d H:i:s', time()),
            'status' => 1,
            'is_delete' => 0
        );



        $insert_id = $this->common->insert_data_getid($data, 'artistic_post_comment');


        // insert notification

        if ($artdatacomment[0]['user_id'] == $userid || $artdatacomment[0]['is_delete'] == '1') {
            
        } else {
            $data = array(
                'not_type' => 6,
                'not_from_id' => $userid,
                'not_to_id' => $artdatacomment[0]['user_id'],
                'not_read' => 2,
                'not_product_id' => $insert_id,
                'not_from' => 3,
                'not_img' => 1,
                'not_active' => 1,
                'not_created_date' => date('Y-m-d H:i:s')
            );

            $insert_id = $this->common->insert_data_getid($data, 'notification');
        }
        // end notoification



        $contition_array = array('art_post_id' => $_POST["post_id"], 'status' => '1');
        $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = 'artistic_post_comment_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// khyati changes start
        $cmtinsert = '<div  class="hidebottombordertwo insertcommenttwo' . $post_id . '">';
        foreach ($artdata as $art) {

            $artname = $this->db->get_where('art_reg', array('user_id' => $art['user_id'], 'status' => 1))->row()->art_name;

            $artlastname = $this->db->get_where('art_reg', array('user_id' => $art['user_id']))->row()->art_lastname;

            $artslug = $this->db->get_where('art_reg', array('user_id' => $art['user_id']))->row()->slug;


            $art_userimage = $this->db->get_where('art_reg', array('user_id' => $art['user_id'], 'status' => 1))->row()->art_user_image;

            $cmtinsert .= '<div class="all-comment-comment-box">';
            $cmtinsert .= '<div class="post-design-pro-comment-img">';
            $cmtinsert .= '<a href="' . base_url('artistic/dashboard/' . $artslug . '') . '">';

            if($art_userimage){

                if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                            $a = $artname;
                            $acr = substr($a, 0, 1);
                            $b = $artlastname;
                            $bcr = substr($b, 0, 1);

                                $cmtinsert .= '<div class="post-img-div">';
                                $cmtinsert .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                                $cmtinsert .=  '</div>';


                        } else {

            $cmtinsert .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage . '" alt="">';

                }

            }else{


                         $a = $artname;
                            $acr = substr($a, 0, 1);
                            $b = $artlastname;
                            $bcr = substr($b, 0, 1);


                    $cmtinsert .= '<div class="post-img-div">';
                    $cmtinsert .=  ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                    $cmtinsert .=  '</div>';


                   

            }
              $cmtinsert .= '</a>';
              $cmtinsert .=  '</div>';


            $cmtinsert .= '<div class="comment-name">';
            $cmtinsert .= '<a href="' . base_url('artistic/dashboard/' . $artslug . '') . '">
            <b>' . ucfirst(strtolower($artname)) . '&nbsp;' . ucfirst(strtolower($artlastname)) . '</b></a>';
            $cmtinsert .= '</div>';
            $cmtinsert .= '<div class="comment-details" id= "showcommenttwo' . $art['artistic_post_comment_id'] . '" >';
            $cmtinsert .= $this->common->make_links($art['comments']);
            $cmtinsert .= '</div>';
            $cmtinsert .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';
//            $cmtinsert .= '<textarea  name="' . $art['artistic_post_comment_id'] . '" id="editcommenttwo' . $art['artistic_post_comment_id'] . '" style="display:none" onClick="commentedittwo(this.name)">';
//            $cmtinsert .= '' . $art['comments'] . '';
//            $cmtinsert .= '</textarea>';
            $cmtinsert .= '<div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="' . $art['artistic_post_comment_id'] . '"  id="editcommenttwo' . $art['artistic_post_comment_id'] . '" placeholder="Type Message ..." value= ""  onkeyup="commentedittwo(' . $art['artistic_post_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $art['comments'] . '</div>';
            $cmtinsert .= '<span class="comment-edit-button"><button id="editsubmittwo' . $art['artistic_post_comment_id'] . '" style="display:none" onclick="edit_commenttwo(' . $art['artistic_post_comment_id'] . ')">Save</button></span>';
            $cmtinsert .= '</div></div>';

//            $cmtinsert .= '<button id="editsubmittwo' . $art['artistic_post_comment_id'] . '" style="display:none" onClick="edit_commenttwo(' . $art['artistic_post_comment_id'] . ')">Comment</button><div class="art-comment-menu-design"> <div class="comment-details-menu" id="likecomment1' . $art['artistic_post_comment_id'] . '">';
            $cmtinsert .= '<div class="art-comment-menu-design"><div class="comment-details-menu" id="likecomment1' . $art['artistic_post_comment_id'] . '">';
            $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '"';
            $cmtinsert .= 'onClick="comment_like1(this.id)">';



            $userid = $this->session->userdata('aileenuser');
            $contition_array = array('artistic_post_comment_id' => $art['artistic_post_comment_id'], 'status' => '1');
            $artcommentlike = $this->data['artcommentlike'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $likeuserarray = explode(',', $artcommentlike[0]['artistic_comment_like_user']);

            if (!in_array($userid, $likeuserarray)) {


                $cmtinsert .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
            } else {
                $cmtinsert .= '<i class="fa fa-thumbs-up" aria-hidden="true"></i>';
            }
            $cmtinsert .= '<span>';

            if ($art['artistic_comment_likes_count'] > 0) {
                $cmtinsert .= ' ' . $art['artistic_comment_likes_count'];
            }
            $cmtinsert .= '</span>';
            $cmtinsert .= '</a></div>';

            $userid = $this->session->userdata('aileenuser');
            if ($art['user_id'] == $userid) {
                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';


                $cmtinsert .= '<div id="editcommentboxtwo' . $art['artistic_post_comment_id'] . '" style="display:block;">';
                $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_editboxtwo(this.id)">';
                $cmtinsert .= 'Edit';
                $cmtinsert .= '</a></div>';
                $cmtinsert .= '<div id="editcancletwo' . $art['artistic_post_comment_id'] . '" style="display:none;">';
                $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '" onClick="comment_editcancletwo(this.id)">Cancel  </a></div>';

                $cmtinsert .= '</div>';
            }

            $userid = $this->session->userdata('aileenuser');

            $art_userid = $this->db->get_where('art_post', array('art_post_id' => $art['art_post_id'], 'status' => 1))->row()->user_id;

            if ($art['user_id'] == $userid || $art_userid == $userid) {
                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';

                $cmtinsert .= '<input type="hidden" name="post_deletetwo"';
                $cmtinsert .= 'id="post_deletetwo"';
                $cmtinsert .= 'value= "' . $art['art_post_id'] . '">';

                $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_deletetwo(this.id)">';
                $cmtinsert .= 'Delete';
                $cmtinsert .= '</a></div>';
            }
            $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
            $cmtinsert .= '<div class="comment-details-menu">';
            $cmtinsert .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($art['created_date']))) . '</p></div></div></div>';


            // comment aount variable start
//            $idpost = $art['art_post_id'];
//            $cmtcount = '<a onClick="commentall(this.id)" id="' . $idpost . '">';
//            $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
//            $cmtcount .= ' ' . count($artdata) . '';
//            $cmtcount .= '</i></a>';
//            
             $cntinsert =  '<span class="comment_count" >';
     if (count($artdata) > 0) {
           $cntinsert .= '' . count($artdata) . ''; 
           $cntinsert .=   '</span>'; 
           $cntinsert .=  '<span> Comment</span>';
        
           }
        }
        //echo $cmtinsert;
        echo json_encode(
                array("comment" => $cmtinsert,
                    "comment" => $cmtinsert,
                    "commentcount" => $cntinsert));
      }
        // khyati chande 
    }




public function insert_comment_postnewpage() {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $post_id = $_POST["post_id"];
        $post_comment = $_POST["comment"];

        $contition_array = array('art_post_id' => $_POST["post_id"], 'status' => '1');
        $artdatacomment = $this->data['artdatacomment'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $data = array(
            'user_id' => $userid,
            'art_post_id' => $post_id,
            'comments' => $post_comment,
            'created_date' => date('Y-m-d H:i:s', time()),
            'status' => 1,
            'is_delete' => 0
        );



        $insert_id = $this->common->insert_data_getid($data, 'artistic_post_comment');


        // insert notification

        if ($artdatacomment[0]['user_id'] == $userid || $artdatacomment[0]['is_delete'] == '1') {
            
        } else {
            $data = array(
                'not_type' => 6,
                'not_from_id' => $userid,
                'not_to_id' => $artdatacomment[0]['user_id'],
                'not_read' => 2,
                'not_product_id' => $insert_id,
                'not_from' => 3,
                'not_img' => 1,
                'not_active' => 1,
                'not_created_date' => date('Y-m-d H:i:s')
            );

            $insert_id = $this->common->insert_data_getid($data, 'notification');
        }
        // end notoification



        $contition_array = array('art_post_id' => $_POST["post_id"], 'status' => '1');
        $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = 'artistic_post_comment_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// khyati changes start
        $cmtinsert = '<div class="hidebottombordertwo insertcommenttwo' . $post_id . '">';
        foreach ($artdata as $art) {

            $artname = $this->db->get_where('art_reg', array('user_id' => $art['user_id'], 'status' => 1))->row()->art_name;

            $artlastname = $this->db->get_where('art_reg', array('user_id' => $art['user_id']))->row()->art_lastname;

            $artslug = $this->db->get_where('art_reg', array('user_id' => $art['user_id']))->row()->slug;


            $art_userimage = $this->db->get_where('art_reg', array('user_id' => $art['user_id'], 'status' => 1))->row()->art_user_image;

            $cmtinsert .= '<div class="all-comment-comment-box">';
            $cmtinsert .= '<div class="post-design-pro-comment-img">';
            $cmtinsert .= '<a href="' . base_url('artistic/dashboard/' . $artslug . '') . '">';


            if($art_userimage){

                if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                            $a = $artname;
                            $acr = substr($a, 0, 1);
                            $b = $artlastname;
                            $bcr = substr($b, 0, 1);

                                $cmtinsert .= '<div class="post-img-div">';
                                $cmtinsert .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                                $cmtinsert .=  '</div>';


                        } else {

            $cmtinsert .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage . '" alt="">';

                }

             
            }else{


                         $a = $artname;
                            $acr = substr($a, 0, 1);
                            $b = $artlastname;
                            $bcr = substr($b, 0, 1);


                    $cmtinsert .= '<div class="post-img-div">';
                    $cmtinsert .=  ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                    $cmtinsert .=  '</div>';    

            }
              $cmtinsert .= '</a>';
             $cmtinsert .=  '</div>';

            $cmtinsert .= '<div class="comment-name">';
            $cmtinsert .= '<a href="' . base_url('artistic/dashboard/' . $artslug . '') . '">
            <b>' . ucfirst(strtolower($artname)) . '&nbsp;' . ucfirst(strtolower($artlastname)) . '</b></a>';
            $cmtinsert .= '</div>';
           
            $cmtinsert .= '<div class="comment-details" id= "showcommenttwo' . $art['artistic_post_comment_id'] . '" >';
            $cmtinsert .= $this->common->make_links($art['comments']);
            $cmtinsert .= '</div>';
            $cmtinsert .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';
//            $cmtinsert .= '<textarea  name="' . $art['artistic_post_comment_id'] . '" id="editcommenttwo' . $art['artistic_post_comment_id'] . '" style="display:none" onClick="commentedittwo(this.name)">';
//            $cmtinsert .= '' . $art['comments'] . '';
//            $cmtinsert .= '</textarea>';
            $cmtinsert .= '<div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="' . $art['artistic_post_comment_id'] . '"  id="editcommenttwo' . $art['artistic_post_comment_id'] . '" placeholder="Type Message ..." value= ""  onkeyup="commentedittwo(' . $art['artistic_post_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $art['comments'] . '</div>';
            $cmtinsert .= '<span class="comment-edit-button"><button id="editsubmittwo' . $art['artistic_post_comment_id'] . '" style="display:none" onclick="edit_commenttwo(' . $art['artistic_post_comment_id'] . ')">Save</button></span>';
            $cmtinsert .= '</div></div>';

//            $cmtinsert .= '<button id="editsubmittwo' . $art['artistic_post_comment_id'] . '" style="display:none" onClick="edit_commenttwo(' . $art['artistic_post_comment_id'] . ')">Comment</button><div class="art-comment-menu-design"> <div class="comment-details-menu" id="likecomment1' . $art['artistic_post_comment_id'] . '">';
            $cmtinsert .= '<div class="art-comment-menu-design"><div class="comment-details-menu" id="likecomment1' . $art['artistic_post_comment_id'] . '">';
            $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '"';
            $cmtinsert .= 'onClick="comment_like1(this.id)">';



            $userid = $this->session->userdata('aileenuser');
            $contition_array = array('artistic_post_comment_id' => $art['artistic_post_comment_id'], 'status' => '1');
            $artcommentlike = $this->data['artcommentlike'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $likeuserarray = explode(',', $artcommentlike[0]['artistic_comment_like_user']);

            if (!in_array($userid, $likeuserarray)) {


                $cmtinsert .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
            } else {
                $cmtinsert .= '<i class="fa fa-thumbs-up" aria-hidden="true"></i>';
            }
            $cmtinsert .= '<span>';

            if ($art['artistic_comment_likes_count'] > 0) {
                $cmtinsert .= ' ' . $art['artistic_comment_likes_count'];
            }
            $cmtinsert .= '</span>';
            $cmtinsert .= '</a></div>';

            $userid = $this->session->userdata('aileenuser');
            if ($art['user_id'] == $userid) {
                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';


                $cmtinsert .= '<div id="editcommentboxtwo' . $art['artistic_post_comment_id'] . '" style="display:block;">';
                $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_editboxtwo(this.id)">';
                $cmtinsert .= 'Edit';
                $cmtinsert .= '</a></div>';
                $cmtinsert .= '<div id="editcancletwo' . $art['artistic_post_comment_id'] . '" style="display:none;">';
                $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '" onClick="comment_editcancletwo(this.id)">Cancel  </a></div>';

                $cmtinsert .= '</div>';
            }

            $userid = $this->session->userdata('aileenuser');

            $art_userid = $this->db->get_where('art_post', array('art_post_id' => $art['art_post_id'], 'status' => 1))->row()->user_id;

            if ($art['user_id'] == $userid || $art_userid == $userid) {
                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';

                $cmtinsert .= '<input type="hidden" name="post_deletetwo"';
                $cmtinsert .= 'id="post_deletetwo"';
                $cmtinsert .= 'value= "' . $art['art_post_id'] . '">';

                $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_deletetwo(this.id)">';
                $cmtinsert .= 'Delete';
                $cmtinsert .= '</a></div>';
            }
            $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
            $cmtinsert .= '<div class="comment-details-menu">';
            $cmtinsert .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($art['created_date']))) . '</p></div></div></div>';


            // comment aount variable start
//            $idpost = $art['art_post_id'];
//            $cmtcount = '<a onClick="commentall(this.id)" id="' . $idpost . '">';
//            $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
//            $cmtcount .= ' ' . count($artdata) . '';
//            $cmtcount .= '</i></a>';
//            
             $cntinsert =  '<span class="comment_count" >';
     if (count($artdata) > 0) {
           $cntinsert .= '' . count($artdata) . ''; 
           $cntinsert .=   '</span>'; 
           $cntinsert .=  '<span> Comment</span>';
        
           }
        }
        //echo $cmtinsert;
        echo json_encode(
                array("comment" => $cmtinsert,
                    "comment" => $cmtinsert,
                    "commentcount" => $cntinsert));
        // khyati chande 
    }
    public function insert_commentthree() {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

    $post_id = $_POST["post_id"];


    $condition_array = array('art_post_id' => $post_id);
        $profile_data = $this->common->select_data_by_condition('art_post', $condition_array, $data = 'status,user_id,is_delete,posted_user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($profile_data); die();
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

        // echo  $dataavl; die();
         if($return == 0){
            
           $datavl = "notavl";
            echo json_encode(
                        array(
                            "notavlpost" => $datavl,
                           
                ));

         }else{
        
      $post_comment = $_POST["comment"];
//die();

        $contition_array = array('art_post_id' => $_POST["post_id"], 'status' => '1');
        $artdatacomment = $this->data['artdatacomment'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $data = array(
            'user_id' => $userid,
            'art_post_id' => $post_id,
            'comments' => $post_comment,
            'created_date' => date('Y-m-d H:i:s', time()),
            'status' => 1,
            'is_delete' => 0
        );



        $insert_id = $this->common->insert_data_getid($data, 'artistic_post_comment');

        // insert notification

        if ($artdatacomment[0]['user_id'] == $userid || $artdatacomment[0]['is_delete'] == '1') {
            
        } else {
            $notificationdata = array(
                'not_type' => 6,
                'not_from_id' => $userid,
                'not_to_id' => $artdatacomment[0]['user_id'],
                'not_read' => 2,
                'not_product_id' => $insert_id,
                'not_from' => 3,
                'not_img' => 1,
                'not_active' => 1,
                'not_created_date' => date('Y-m-d H:i:s')
            );
            //echo "<pre>"; print_r($notificationdata); 
            $insert_id_notification = $this->common->insert_data_getid($notificationdata, 'notification');
        }
        // end notoification



        $contition_array = array('art_post_id' => $_POST["post_id"], 'status' => '1');
        $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = 'artistic_post_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($artdata); die();
        // all count of commnet 

        $contition_array = array('art_post_id' => $_POST["post_id"], 'status' => '1');
        $allcomnt = $this->data['allcomnt'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = 'artistic_post_comment_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        // echo '<pre>'; print_r($artdata); die();            
// khyati changes start

        foreach ($artdata as $art) {

            $artname = $this->db->get_where('art_reg', array('user_id' => $art['user_id'], 'status' => 1))->row()->art_name;

            $artlastname = $this->db->get_where('art_reg', array('user_id' => $art['user_id']))->row()->art_lastname;

             $artslug = $this->db->get_where('art_reg', array('user_id' => $art['user_id']))->row()->slug;



            $art_userimage = $this->db->get_where('art_reg', array('user_id' => $art['user_id'], 'status' => 1))->row()->art_user_image;

            $cmtinsert .= '<div class="all-comment-comment-box">';
            $cmtinsert .= '<div class="post-design-pro-comment-img">';
            $cmtinsert .= '<a href="' . base_url('artistic/dashboard/' . $artslug . '') . '">';

            if($art_userimage){


                if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                            $a = $artname;
                            $acr = substr($a, 0, 1);
                            $b = $artlastname;
                            $bcr = substr($b, 0, 1);

                                $cmtinsert .= '<div class="post-img-div">';
                                $cmtinsert .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                                $cmtinsert .=  '</div>';


                        } else {

            $cmtinsert .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage . '" alt="">';

                  }

            }else{
 
                           $a = $artname;
                            $acr = substr($a, 0, 1);
                            $b = $artlastname;
                            $bcr = substr($b, 0, 1);
                    $cmtinsert .= '<div class="post-img-div">';
                    $cmtinsert .=  ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                    $cmtinsert .=  '</div>';      
            }
             $cmtinsert .= '</a>';
            $cmtinsert .= '</div>';
            $cmtinsert .= '<div class="comment-name">';
            $cmtinsert .= '<a href="' . base_url('artistic/dashboard/' . $artslug . '') . '">

            <b>' . ucfirst(strtolower($artname)) . '&nbsp;' . ucfirst(strtolower($artlastname)) . '</b></a>';
            $cmtinsert .= '</div>';
           
            $cmtinsert .= '<div class="comment-details" id= "showcomment' . $art['artistic_post_comment_id'] . '" >';
            $cmtinsert .= $this->common->make_links($art['comments']);
            $cmtinsert .= '</div>';
            $cmtinsert .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';
            $cmtinsert .= '<div contenteditable="true" class="editable_text"  name="' . $art['artistic_post_comment_id'] . '" id="editcomment' . $art['artistic_post_comment_id'] . '" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" onkeyup="commentedit(' . $art['artistic_post_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">';
            $cmtinsert .= '' . $art['comments'] . '';
            $cmtinsert .= '</div>';
            $cmtinsert .= '<span class="comment-edit-button"><button id="editsubmit' . $art['artistic_post_comment_id'] . '" style="display:none" onClick="edit_comment(' . $art['artistic_post_comment_id'] . ')">Save</button></span>';
            $cmtinsert .= '</div></div>';

            $cmtinsert .= '<div class="art-comment-menu-design"><div class="comment-details-menu" id="likecomment1' . $art['artistic_post_comment_id'] . '">';
            $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '"';
            $cmtinsert .= 'onClick="comment_like1(this.id)">';



            $userid = $this->session->userdata('aileenuser');
            $contition_array = array('artistic_post_comment_id' => $art['artistic_post_comment_id'], 'status' => '1');
            $artcommentlike = $this->data['artcommentlike'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $likeuserarray = explode(',', $artcommentlike[0]['artistic_comment_like_user']);

            if (!in_array($userid, $likeuserarray)) {


                $cmtinsert .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
            } else {
                $cmtinsert .= '<i class="fa fa-thumbs-up" aria-hidden="true"></i>';
            }
            $cmtinsert .= '<span>';

            if ($art['artistic_comment_likes_count'] > 0) {
                $cmtinsert .= ' ' . $art['artistic_comment_likes_count'];
            }
            $cmtinsert .= '</span>';
            $cmtinsert .= '</a></div>';

            $userid = $this->session->userdata('aileenuser');
            if ($art['user_id'] == $userid) {

                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';
                $cmtinsert .= '<div id="editcommentbox' . $art['artistic_post_comment_id'] . '" style="display:block;">';
                $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_editbox(this.id)">';
                $cmtinsert .= 'Edit';
                $cmtinsert .= '</a></div>';
                $cmtinsert .= '<div id="editcancle' . $art['artistic_post_comment_id'] . '" style="display:none;">';
                $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '" onClick="comment_editcancle(this.id)">Cancel  </a></div>';

                $cmtinsert .= '</div>';
            }

            $userid = $this->session->userdata('aileenuser');
            $art_userid = $this->db->get_where('art_post', array('art_post_id' => $art['art_post_id'], 'status' => 1))->row()->user_id;

            if ($art['user_id'] == $userid || $art_userid == $userid) {

                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';
                
   $cmtinsert .=  '<input type="hidden" name="post_delete"';
   $cmtinsert .=  'id="post_delete' . $art['artistic_post_comment_id'] . '" value= "' . $art['art_post_id'] . '">';
   $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '"   onClick="comment_delete(this.id)"> Delete';
   $cmtinsert .= '<span class="insertcomment' . $art['artistic_post_comment_id'] . '"></span>';
   $cmtinsert .=  '</a></div>';
 
            }

            $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
            $cmtinsert .= '<div class="comment-details-menu">';
            $cmtinsert .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($art['created_date']))) . '</p></div></div></div>';
//          $cntinsert .= '<a onclick="commentall(this.id)" id="' . $art['art_post_id'] . '">';
 //          $cntinsert .= '<i class="fa fa-comment-o" aria-hidden="true">' .
//                    count($allcomnt) . '</i>';
            
          $cntinsert =  '<span class="comment_count" >';
     if (count($allcomnt) > 0) {
           $cntinsert .= '' . count($allcomnt) . ''; 
           $cntinsert .=   '</span>'; 
           $cntinsert .=  '<span> Comment</span>';
        
           }
       }
        echo json_encode(
                array("count" => $cntinsert,
                    "comment" => $cmtinsert,
                    "commentcount" => $cntinsert));

        // khyati chande 
       }
    }

//artistic comment insert end  
//artistic comment edit start
    public function edit_comment_insert() {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $post_id = $_POST["post_id"];

        $contition_array = array('artistic_post_comment_id' => $_POST["post_id"], 'status' => '1');
        $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $condition_array = array('art_post_id' => $artdata[0]['art_post_id']);
        $profile_data = $this->common->select_data_by_condition('art_post', $condition_array, $data = 'status,user_id,is_delete,posted_user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($profile_data); die();
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

        // echo  $dataavl; die();
         if($return == 0){
             $cmtlike = 'notavl';
            echo $cmtlike;

         }else{
        

        $post_comment = $_POST["comment"];

        $data = array(
            'comments' => $post_comment,
            'modify_date' => date('y-m-d h:i:s')
        );

        $updatdata = $this->common->update_data($data, 'artistic_post_comment', 'artistic_post_comment_id', $post_id);
        if ($updatdata) {

            $contition_array = array('artistic_post_comment_id' => $_POST["post_id"], 'status' => '1');
            $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            // $cmtlike = '<div>';
            $cmtlike = $this->common->make_links($artdata[0]['comments']) . "<br>";
            //   $cmtlike .= '</div>';
            echo $cmtlike;
        }
      }
    }

//artistic comment edit end 
// cover pic controller

    public function ajaxpro() {
        $userid = $this->session->userdata('aileenuser');

         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }

// REMOVE OLD IMAGE FROM FOLDER
        $contition_array = array('user_id' => $userid);
        $user_reg_data = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'profile_background,profile_background_main', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $user_reg_prev_image = $user_reg_data[0]['profile_background'];
        $user_reg_prev_main_image = $user_reg_data[0]['profile_background_main'];

        if ($user_reg_prev_image != '') {
            $user_image_main_path = $this->config->item('art_bg_main_upload_path');
            $user_bg_full_image = $user_image_main_path . $user_reg_prev_image;
            if (isset($user_bg_full_image)) {
                unlink($user_bg_full_image);
            }

            $user_image_thumb_path = $this->config->item('art_bg_thumb_upload_path');
            $user_bg_thumb_image = $user_image_thumb_path . $user_reg_prev_image;
            if (isset($user_bg_thumb_image)) {
                unlink($user_bg_thumb_image);
            }
        }
        if ($user_reg_prev_main_image != '') {
            $user_image_original_path = $this->config->item('art_bg_original_upload_path');
            $user_bg_origin_image = $user_image_original_path . $user_reg_prev_main_image;
            if (isset($user_bg_origin_image)) {
                unlink($user_bg_origin_image);
            }
        }



        $data = $_POST['image'];
        $data = str_replace('data:image/png;base64,', '', $data);
        $data = str_replace(' ', '+', $data);
        $user_bg_path = $this->config->item('art_bg_main_upload_path');
        $imageName = time() . '.png';
        $data = base64_decode($data);
        $file = $user_bg_path . $imageName;
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

        //  /* RESIZE */
        // $artistic_bg['image_library'] = 'gd2';
        // $artistic_bg['source_image'] = $main_image;
        // $artistic_bg['new_image'] = $main_image;
        // $artistic_bg['quality'] = $quality;
        // $instanse10 = "image10";
        // $this->load->library('image_lib', $artistic_bg, $instanse10);
        // $this->$instanse10->watermark();
        // /* RESIZE */


        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
        $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);

        $user_thumb_path = $this->config->item('art_bg_thumb_upload_path');
        $user_thumb_width = $this->config->item('art_bg_thumb_width');
        $user_thumb_height = $this->config->item('art_bg_thumb_height');

        $upload_image = $user_bg_path . $imageName;
        $thumb_image_uplode = $this->thumb_img_uplode($upload_image, $imageName, $user_thumb_path, $user_thumb_width, $user_thumb_height);

        $thumb_image = $user_thumb_path . $imageName;
        $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);

        $data = array(
            'profile_background' => $imageName
        );

        $update = $this->common->update_data($data, 'art_reg', 'user_id', $userid);
        $this->data['artdata'] = $this->common->select_data_by_id('art_reg', 'user_id', $userid, $data = '*', $join_str = array());

//        echo '<img src = "' . $this->data['busdata'][0]['profile_background'] . '" />';
        $coverpic =  '<img id="image_src" name="image_src" src = "' . ART_BG_MAIN_UPLOAD_URL . $this->data['artdata'][0]['profile_background'] . '" />';

        echo $coverpic;
    }

    public function image() {
        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $config['upload_path'] = $this->config->item('art_bg_original_upload_path');
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


        $updatedata = $this->common->update_data($data, 'art_reg', 'user_id', $userid);

        if ($updatedata) {
            echo $userid;
        } else {
            echo "welcome";
        }
    }

    // cover pic end
// click on post after post open on new page start
    public function postnewpage($id = '') {
        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End
        $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('art_post_id' => $id, 'status' => '1', 'is_delete' => '0');
        $this->data['art_data'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($this->data['art_data']);die();

        


        if($this->data['artisticdata']){
            $artistic_name = $this->get_artistic_name($id);
      $this->data['title'] = $artistic_name.TITLEPOSTFIX;
            $this->data['left_artistic'] =  $this->load->view('artistic/left_artistic', $this->data, true);
        $this->load->view('artistic/postnewpage', $this->data);
    }
       else {
       redirect('artistic/');

        }
    }

// click on post after post open on new page end
//edit post start

    public function edit_post_insert() {

        $userid = $this->session->userdata('aileenuser');

        //echo "<pre>"; print_r($_POST); die();

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $post_id = $_POST["art_post_id"];
        $art_post = $_POST["art_post"];
       $art_description = $_POST["art_description"]; 


               $condition_array = array('art_post_id' => $post_id);
        $profile_data = $this->common->select_data_by_condition('art_post', $condition_array, $data = 'status,user_id,is_delete,posted_user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($profile_data); die();
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

        // echo  $dataavl; die();
         if($return == 0){
            
           $datavl = "notavl";
            echo json_encode(
                        array(
                            "notavlpost" => $datavl,
                           
                ));

         }else{
        

        $data = array(
            'art_post' => $art_post,
            'art_description' => $art_description,
            'modifiled_date' => date('y-m-d h:i:s')
        );

        $updatdata = $this->common->update_data($data, 'art_post', 'art_post_id', $post_id);
        if ($updatdata) {

            $contition_array = array('art_post_id' => $_POST["art_post_id"], 'status' => '1');
            $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            //echo "<pre>"; print_r($artdata); die();
            if ($this->data['artdata'][0]['art_post']) {
                $editpost = '<div><a class="ft-15 t_artd">';
                $editpost .= $this->common->make_links($artdata[0]['art_post']) . "<br>";
                $editpost .= '</a></div>';
            }
            if ($this->data['artdata'][0]['art_description']) {

                                       $num_words = 29;
                                       $words = array();
                                       $words = explode(" ",  $artdata[0]['art_description'], $num_words);
                                       $shown_string = "";
                                       
                                       if(count($words) == 29){
                                       $words[28] ='... <span id="kkkk" onClick="khdiv(' . $_POST["art_post_id"] . ')">View More</span>';
                                       }
                                       
                                       $shown_string = implode(" ", $words);
                                       $editpostdes .= $this->common->make_links($shown_string);
            
              
                }

                $postname = '<p title="'.$artdata[0]['art_post'].'">'.$artdata[0]['art_post'].'</p>';
            //echo $editpost;   echo $editpostdes;
            echo json_encode(
                    array("title" => $editpost,
                        "description" => $editpostdes,
                        "postname" => $postname));
        }
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

        $updatdata = $this->common->update_data($data, 'art_reg', 'user_id', $userid);
        if ($updatdata) {

            redirect('artistic/home', refresh);
        } else {

            redirect('artistic/reactivate', refresh);
        }
    }

//reactivate accont end 
//delete post particular user start
    public function del_particular_userpost() {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $post_id = $_POST['art_post_id'];

        $contition_array = array('art_post_id' => $post_id, 'status' => '1');
        $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $likeuserarray = explode(',', $artdata[0]['delete_post']);

        $user_array = array_push($likeuserarray, $userid);

        if ($artdata[0]['delete_post'] == 0) {
            $userid = implode('', $likeuserarray);
        } else {
            $userid = implode(',', $likeuserarray);
        }

        $data = array(
            'delete_post' => $userid,
            'modifiled_date' => date('y-m-d h:i:s')
        );

        $updatdata = $this->common->update_data($data, 'art_post', 'art_post_id', $post_id);




         $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($this->data['artisticdata']); die();
        $artregid = $this->data['artisticdata'][0]['art_id'];


         $contition_array = array('follow_from' => $artregid, 'follow_status' => '1', 'follow_type' => '1');
        $followerdata1 = $this->data['followerdata1'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($this->data['followerdata']); die();


        foreach ($followerdata1 as $fdata) {

            $user_id = $this->db->get_where('art_reg', array('art_id' => $fdata['follow_to'], 'status' => '1'))->row()->user_id;


            $contition_array = array('art_post.user_id' => $user_id, 'art_post.status' => '1', 'art_post.user_id !=' => $userid, 'art_post.is_delete' => '0');
            $this->data['art_data'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            $followerabc[] = $this->data['art_data'];
        }

        //echo "<pre>"; print_r($followerabc); die();
//data fatch using follower end
//data fatch using skill start

        $userselectskill = $this->data['artisticdata'][0]['art_skill'];
        //echo  $userselectskill; die();
        $contition_array = array('art_skill' => $userselectskill, 'status' => '1' , 'art_step' => 4);
        $skilldata = $this->data['skilldata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($this->data['skilldata']); die();

        foreach ($skilldata as $fdata) {


            $contition_array = array('art_post.user_id' => $fdata['user_id'], 'art_post.status' => '1', 'art_post.user_id !=' => $userid, 'art_post.is_delete' => '0');

            $this->data['art_data'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $skillabc[] = $this->data['art_data'];
        }


//data fatch using skill end
//data fatch using login user last post start
        $contition_array = array('art_post.user_id' => $userid, 'art_post.status' => '1', 'art_post.is_delete' => '0');

        $art_userdata = $this->data['art_userdata'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = 'art_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if (count($art_userdata) > 0) {
            $userabc[][] = $this->data['art_userdata'][0];
        } else {
            $userabc[] = $this->data['art_userdata'][0];
        }
        //echo "<pre>"; print_r($userabc); die();
        //echo "<pre>"; print_r($skillabc);  die();
//data fatch using login user last post end
//echo count($skillabc);
//echo count($userabc);
//echo count($unique);
//echo count($followerabc); 


        if (count($skillabc) == 0 && count($userabc) != 0) {
            $unique = $userabc;
        } elseif (count($userabc) == 0 && count($skillabc) != 0) {
            $unique = $skillabc;
        } elseif (count($userabc) != 0 && count($skillabc) != 0) {
            $unique = array_merge($skillabc, $userabc);
        }

        //echo "<pre>"; print_r($userabc); die();
        //echo count($followerabc);  echo count($unique); die();

        if (count($followerabc) == 0 && count($unique) != 0) {
            $unique_user = $unique;
        } elseif (count($unique) == 0 && count($followerabc) != 0) {

            $unique_user = $followerabc;
        } elseif (count($unique) != 0 && count($followerabc) != 0) {
            $unique_user = array_merge($unique, $followerabc);
        }



        foreach ($unique_user as $key1 => $val1) {
            foreach ($val1 as $ke => $va) {

                $qbc[] = $va;
            }
        }


        $qbc = array_unique($qbc, SORT_REGULAR);
        //echo "<pre>"; print_r($qbc); die();
        // sorting start

        $post = array();

        //$i =0;
        foreach ($qbc as $key => $row) {
            $post[$key] = $row['art_post_id'];
         }

        array_multisort($post, SORT_DESC, $qbc);
        // echo '<pre>';
        // print_r($qbc);
        // exit;
        $otherdata = $qbc;


         if (count($otherdata) > 0) { 
             foreach ($otherdata as $row) {
                 //  echo '<pre>'; print_r($finalsorting); die();
                 $userid = $this->session->userdata('aileenuser');
         
                 $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1');
                 $artdelete = $this->data['artdelete'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
         
                 $likeuserarray = explode(',', $artdelete[0]['delete_post']);
         
                 if (!in_array($userid, $likeuserarray)) {}else{

                    $count[] = "abc";
                 }

                  }
  } 
//echo count($otherdata); die();
  if(count($otherdata) > 0){ 
          if(count($count) == count($otherdata)){ 
        
                    $datacount = "count";


                    $notfound = '<div class="contact-frnd-post bor_none">';
                    $notfound .= '<div class="text-center rio">';
                    $notfound .= '<h4 class="page-heading  product-listing">No post Found.</h4>';
                    $notfound .= '</div></div>';
                
            } }else{ 

                    $datacount = "count";

                    $notfound = '<div class="contact-frnd-post bor_none">';
                    $notfound .= '<div class="text-center rio">';
                    $notfound .= '<h4 class="page-heading  product-listing">No post Found.</h4>';
                    $notfound .= '</div></div>';
                
            }

            echo json_encode(
                        array(
                            "notfound" => $notfound,
                            "notcount" => $datacount,
                ));

    }

//delete post particular user end  
//multiple images for user start


    public function art_photos($id = "") {


        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End
        $contition_array = array('user_id' => $userid, 'status' => '1');
        $artisticslug = $this->data['artisticslug'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($id == $userid || $id == '' || $id == $artisticslug[0]['slug']) {

            $contition_array = array('user_id' => $userid, 'status' => '1');

            $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            //  echo "<pre>"; print_r($artisticdata); die();



            $contition_array = array('user_id' => $userid, 'is_delete' => '0');

             $artisticpost = $this->data['artisticdatapost'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            //echo "<pre>"; print_r($artisticpost); die();

             foreach ($artisticpost as $value) {
                
            
            $contition_array = array('insert_profile' => 1, 'is_deleted' => '1', 'post_id' => $value['art_post_id']);

            $art_data = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $a_d[] =  $art_data;
           }

           foreach ($a_d as $key_ad => $value_ad) {
               foreach ($value_ad as $art_fn => $v) {

          // echo "<pre>"; print_r($art_fn);  

          // echo "<pre>"; print_r($v); 


                $art_data[] = $v;
                   
               }
           }//die();

           $art_data = array_unique($art_data, SORT_REGULAR);

           $this->data['artistic_data'] = $art_data; 

            //echo "<pre>"; print_r($art_data); die();



        } else {

           $contition_array = array('slug' => $id, 'status' => '1');

            $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            //  echo "<pre>"; print_r($artisticdata); die();



            $contition_array = array('user_id' => $id, 'is_delete' => '0');

             $artisticpost = $this->data['artisticdatapost'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            //echo "<pre>"; print_r($artisticpost); die();

             foreach ($artisticpost as $value) {
                
            
            $contition_array = array('insert_profile' => 1, 'is_deleted' => '1', 'post_id' => $value['art_post_id']);

            $art_data = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $a_d[] =  $art_data;
           }

           foreach ($a_d as $key_ad => $value_ad) {
               foreach ($value_ad as $art_fn => $v) {

          // echo "<pre>"; print_r($art_fn);  

          // echo "<pre>"; print_r($v); 


                $art_data[] = $v;
                   
               }
           }//die();

           $art_data = array_unique($art_data, SORT_REGULAR);

           $this->data['artistic_data'] = $art_data; 
        }


        if($this->data['artisticdata']){
        $this->data['artistic_common'] = $this->load->view('artistic/artistic_common', $this->data, true);
        $artistic_name = $this->get_artistic_name($id);
      $this->data['title'] = $artistic_name.TITLEPOSTFIX;
        $this->load->view('artistic/art_photos', $this->data);
       }else if(!$this->data['artisticdata'] && $id != $userid){

        $this->load->view('artistic/notavalible');  

       }
        else if(!$this->data['artisticdata'] && ($id == $userid || $id == "")){
       redirect('artistic/');
       }
    }

//multiple images for user end   
//multiple videos for user start


    public function art_videos($id) {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End
         $contition_array = array('user_id' => $userid, 'status' => '1');
        $artisticslug = $this->data['artisticslug'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($id == $userid || $id == '' || $id == $artisticslug[0]['slug']) {

            $contition_array = array('user_id' => $userid, 'status' => '1');
            $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            //echo "<pre>"; print_r($artisticdata); die();
            $contition_array = array('user_id' => $artisticdata[0]['user_id'], 'status' => 1, 'is_delete' => '0');

            $this->data['artistic_data'] = $this->common->select_data_by_condition('art_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {

            $contition_array = array('slug' => $id, 'status' => '1','art_step' => 4);
            $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('user_id' => $artisticdata[0]['user_id'], 'status' => 1, 'is_delete' => '0');

            $this->data['artistic_data'] = $this->common->select_data_by_condition('art_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }

        

        if($this->data['artisticdata']){
        $this->data['artistic_common'] = $this->load->view('artistic/artistic_common', $this->data, true);
        $artistic_name = $this->get_artistic_name($id);
      $this->data['title'] = $artistic_name.TITLEPOSTFIX;
        $this->load->view('artistic/art_videos', $this->data);
         }else if(!$this->data['artisticdata'] && $id != $userid){

        $this->load->view('artistic/notavalible');  

       }
        else if(!$this->data['artisticdata'] && ($id == $userid || $id == "")){
       redirect('artistic/');
       }
    }

//multiple videos for user end 
//multiple audios for user start


    public function art_audios($id) {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End
        $contition_array = array('user_id' => $userid, 'status' => '1');
        $artisticslug = $this->data['artisticslug'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($id == $userid || $id == '' || $id == $artisticslug[0]['slug']) {

            $contition_array = array('user_id' => $userid, 'status' => '1');
            $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            //echo "<pre>"; print_r($artisticdata); die();
            $contition_array = array('user_id' => $artisticdata[0]['user_id'], 'status' => 1, 'is_delete' => '0');

            $this->data['artistic_data'] = $this->common->select_data_by_condition('art_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {

            $contition_array = array('slug' => $id, 'status' => '1','art_step' => 4);
            $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('user_id' => $artisticdata[0]['user_id'], 'status' => 1, 'is_delete' => '0');

            $this->data['artistic_data'] = $this->common->select_data_by_condition('art_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }




        if($this->data['artisticdata']){
        $this->data['artistic_common'] = $this->load->view('artistic/artistic_common', $this->data, true);
        $artistic_name = $this->get_artistic_name($id);
      $this->data['title'] = $artistic_name.TITLEPOSTFIX;
        $this->load->view('artistic/art_audios', $this->data);
        }else if(!$this->data['artisticdata'] && $id != $userid){

        $this->load->view('artistic/notavalible');  

       }
        else if(!$this->data['artisticdata'] && ($id == $userid || $id == "")){
       redirect('artistic/');
       }
    }

//multiple audios for user end  
//multiple pdf for user start


    public function art_pdf($id) {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

       $contition_array = array('user_id' => $userid, 'status' => '1');
        $artisticslug = $this->data['artisticslug'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        if ($id == $userid || $id == '' || $id ==  $artisticslug[0]['slug']) {

            $contition_array = array('user_id' => $userid, 'status' => '1');
            $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
           //echo "<pre>"; print_r($artisticdata); die();
            $contition_array = array('user_id' => $artisticdata[0]['user_id'], 'status' => 1, 'is_delete' => '0');

            $this->data['artistic_data'] = $this->common->select_data_by_condition('art_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else { 

            $contition_array = array('slug' => $id, 'status' => '1','art_step' => 4);
            $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('user_id' => $artisticdata[0]['user_id'], 'status' => 1, 'is_delete' => '0');

            $this->data['artistic_data'] = $this->common->select_data_by_condition('art_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }

        if($this->data['artisticdata']){ 
        $this->data['artistic_common'] = $this->load->view('artistic/artistic_common', $this->data, true);
        $artistic_name = $this->get_artistic_name($id);
      $this->data['title'] = $artistic_name.TITLEPOSTFIX;    
        $this->load->view('artistic/art_pdf', $this->data);
       }else if(!$this->data['artisticdata'] && $id != $userid){

        $this->load->view('artistic/notavalible');  

       }
        else if(!$this->data['artisticdata'] && ($id == $userid || $id == "")){
       redirect('artistic/');
       }
    }

//multiple pdf for user end    
    // khyati 9-5 multiple images like start
    public function like_postimg() { //echo "hii"; die();
        //$id = $_POST['save_id'];
        $post_image = $_POST['post_image_id'];
        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End


        $contition_array = array('post_image_id' => $post_image, 'user_id' => $userid);

        $likeuser = $this->data['likeuser'] = $this->common->select_data_by_condition('art_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
//echo '<pre>'; print_r($likeuser); die();
        $contition_array = array('post_files_id' => $post_image);

        $likeuserid = $this->data['likeuserid'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $contition_array = array('art_post_id' => $likeuserid[0]['post_id']);

        $likepostid = $this->data['likepostid'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        if (!$likeuser) { //echo 1; die();
            $data = array(
                'post_image_id' => $post_image,
                'user_id' => $userid,
                'created_date' => date('Y-m-d H:i:s', time()),
                'is_unlike' => 0
            );
//echo "<pre>"; print_r($data); die();

            $insertdata = $this->common->insert_data_getid($data, 'art_post_image_like');


            // insert notification

            if ($likepostid[0]['user_id'] == $userid) {
                
            } else {
                $data = array(
                    'not_type' => 5,
                    'not_from_id' => $userid,
                    'not_to_id' => $likepostid[0]['user_id'],
                    'not_read' => 2,
                    'not_product_id' => $post_image,
                    'not_from' => 3,
                    'not_img' => 5,
                    'not_active' => 1,
                    'not_created_date' => date('Y-m-d H:i:s')
                );

                $insert_id = $this->common->insert_data_getid($data, 'notification');
            }
            // end notoification

            $contition_array = array('post_image_id' => $_POST["post_image_id"], 'is_unlike' => '0');
            $bdata1 = $this->data['bdata1'] = $this->common->select_data_by_condition('art_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($insertdata) {

                $imglike = '<li>';
                $imglike .= '<a id="' . $post_image . '" class="ripple like_h_w" onClick="post_likeimg(this.id)">';
                $imglike .= ' <i class="fa fa-thumbs-up main_color" aria-hidden="true">';
                $imglike .= '</i>';
                $imglike .= '<span id="popup"> ';
                if (count($bdata1) > 0) {
                   // $imglike .= count($bdata1) . '';
                }
                $imglike .= '</span>';
                $imglike .= '</a>';
                $imglike .= '</li>';

                 $contition_array = array('post_image_id' => $post_image, 'is_unlike' => '0');
                    $commnetcount = $this->common->select_data_by_condition('art_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    foreach ($commnetcount as $comment) {
                        $art_fname1 = $this->db->get_where('art_reg', array('user_id' => $comment['user_id'], 'status' => 1))->row()->art_name;
                        $art_lname1 = $this->db->get_where('art_reg', array('user_id' => $comment['user_id'], 'status' => 1))->row()->art_lastname;
                    }
                       $cmtlikeuser .= '<div class="like_one_other">';

                 
                    $cmtlikeuser .= '<a href="javascript:void(0);"  class="likeuserlist1" onclick="likeuserlistimg(' . $post_image . ')">';

                    $contition_array = array('post_image_id' => $post_image, 'is_unlike' => '0');
                    $commnetcount = $this->common->select_data_by_condition('art_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


                    $art_fname = $this->db->get_where('art_reg', array('user_id' => $commnetcount[0]['user_id'], 'status' => 1))->row()->art_name;
                    $art_lname = $this->db->get_where('art_reg', array('user_id' => $commnetcount[0]['user_id'], 'status' => 1))->row()->art_lastname;

                    if ($userid == $commnetcount[0]['user_id']) {

                        $cmtlikeuser .= 'You &nbsp';
                    } else {
                        $cmtlikeuser .= '' . ucfirst(strtolower($art_fname)) . '';
                        $cmtlikeuser .= '&nbsp;';
                        $cmtlikeuser .= '' . ucfirst(strtolower($art_lname)) . '';
                        $cmtlikeuser .= '&nbsp;';
                    }
                    if (count($commnetcount) > 1) {
                        $cmtlikeuser .= 'and ';
                        $cmtlikeuser .= ' ' . count($commnetcount) - 1 . '';
                        $cmtlikeuser .= '&nbsp;';
                        $cmtlikeuser .= 'others';
                    }
                    
                    

                   
                    $cmtlikeuser .= '</a>';
                     $cmtlikeuser .= '</div>';
                     $like_user_count =  '<span class="comment_like_count">'; 
               if (count($commnetcount) > 0) { 
              $like_user_count .= '' . count($commnetcount) . ''; 
              $like_user_count .=     '</span>'; 
              $like_user_count .= '<span> Like</span>';
               }
              
              
                    //    echo "123456789"; die();           
                //    $like_user_count = count($commnetcount);
                    echo json_encode(
                            array("like" => $imglike,
                                "likeuser" => $cmtlikeuser,
                                "like_user_count" => $like_user_count));
                    //10-5 user list end               
            }
        } else {

            if ($likeuser[0]['is_unlike'] == 0) {

                $data = array(
                    'modify_date' => date('Y-m-d', time()),
                    'is_unlike' => 1
                );


                $updatdata = $this->common->update_data($data, 'art_post_image_like', 'post_image_like_id', $likeuser[0]['post_image_like_id']);

                $contition_array = array('post_image_id' => $_POST["post_image_id"], 'is_unlike' => '0');
                $bdata2 = $this->data['bdata2'] = $this->common->select_data_by_condition('art_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');



                if ($updatdata) {

                    $imglike1 = '<li>';
                    $imglike1 .= '<a id="' . $post_image . '" class="ripple like_h_w" onClick="post_likeimg(this.id)">';
                    $imglike1 .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true">';
                    $imglike1 .= '</i>';
                    $imglike1 .= '<span id="popup">';
                    if (count($bdata2) > 0) {
                        //$imglike1 .= count($bdata2) . '';
                    }
                    $imglike1 .= '</span>';
                    $imglike1 .= '</a>';
                    $imglike1 .= '</li>';

                    //10-5 user list start

                    $contition_array = array('post_image_id' => $post_image, 'is_unlike' => '0');
                    $commnetcount = $this->common->select_data_by_condition('art_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    foreach ($commnetcount as $comment) {
                        $art_fname1 = $this->db->get_where('art_reg', array('user_id' => $comment['user_id'], 'status' => 1))->row()->art_name;
                        $art_lname1 = $this->db->get_where('art_reg', array('user_id' => $comment['user_id'], 'status' => 1))->row()->art_lastname;
                    }
                       $cmtlikeuser .= '<div class="like_one_other">';

                 
                    $cmtlikeuser .= '<a href="javascript:void(0);"  class="likeuserlist1" onclick="likeuserlistimg(' . $post_image . ')">';

                    $contition_array = array('post_image_id' => $post_image, 'is_unlike' => '0');
                    $commnetcount = $this->common->select_data_by_condition('art_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


                    $art_fname = $this->db->get_where('art_reg', array('user_id' => $commnetcount[0]['user_id'], 'status' => 1))->row()->art_name;
                    $art_lname = $this->db->get_where('art_reg', array('user_id' => $commnetcount[0]['user_id'], 'status' => 1))->row()->art_lastname;

                    if ($userid == $commnetcount[0]['user_id']) {

                        $cmtlikeuser .= 'You &nbsp';
                    } else {
                        $cmtlikeuser .= '' . ucfirst(strtolower($art_fname)) . '';
                        $cmtlikeuser .= '&nbsp;';
                        $cmtlikeuser .= '' . ucfirst(strtolower($art_lname)) . '';
                        $cmtlikeuser .= '&nbsp;';
                    }
                    if (count($commnetcount) > 1) {
                        $cmtlikeuser .= 'and ';
                        $cmtlikeuser .= ' ' . count($commnetcount) - 1 . '';
                        $cmtlikeuser .= '&nbsp;';
                        $cmtlikeuser .= 'others';
                    }
                    
                    

                   
                    $cmtlikeuser .= '</a>';
                     $cmtlikeuser .= '</div>';
                     $like_user_count =  '<span class="comment_like_count">'; 
               if (count($commnetcount) > 0) { 
              $like_user_count .= '' . count($commnetcount) . ''; 
              $like_user_count .=     '</span>'; 
              $like_user_count .= '<span> Like</span>';
               }
              
              
                    //    echo "123456789"; die();           
                //    $like_user_count = count($commnetcount);
                    echo json_encode(
                            array("like" => $imglike1,
                                "likeuser" => $cmtlikeuser,
                                "like_user_count" => $like_user_count));
                    //10-5 user list end               
                    // echo $imglike1;
                }
            } else {

                $data = array(
                    'modify_date' => date('Y-m-d', time()),
                    'is_unlike' => 0
                );


                $updatdata = $this->common->update_data($data, 'art_post_image_like', 'post_image_id', $post_image);


                // insert notification

                if ($likepostid[0]['user_id'] == $userid) {
                    
                } else {


                    $contition_array = array('not_type' => 5, 'not_from_id' => $userid, 'not_to_id' => $likepostid[0]['user_id'], 'not_product_id' => $post_image_id, 'not_from' => 3, 'not_img' => 5);
                    $artnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    if ($artnotification[0]['not_read'] == 2) {
                        
                    } elseif ($artnotification[0]['not_read'] == 1) {

                        $datalike = array(
                            'not_read' => 2
                        );

                        $where = array('not_type' => 5, 'not_from_id' => $userid, 'not_to_id' => $likepostid[0]['user_id'], 'not_product_id' => $post_image_id, 'not_from' => 3, 'not_img' => 5);
                        $this->db->where($where);
                        $updatdata = $this->db->update('notification', $datalike);
                    } else {


                        $data = array(
                            'not_type' => 5,
                            'not_from_id' => $userid,
                            'not_to_id' => $likepostid[0]['user_id'],
                            'not_read' => 2,
                            'not_product_id' => $post_image,
                            'not_from' => 3,
                            'not_img' => 5,
                            'not_active' => 1,
                            'not_created_date' => date('Y-m-d H:i:s')
                        );

                        $insert_id = $this->common->insert_data_getid($data, 'notification');
                    }
                }
                // end notoification


                $contition_array = array('post_image_id' => $_POST["post_image_id"], 'is_unlike' => '0');
                $bdata2 = $this->data['bdata2'] = $this->common->select_data_by_condition('art_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');



                if ($updatdata) {

                    $imglike1 = '<li>';
                    $imglike1 .= '<a id="' . $post_image . '" class="ripple like_h_w" onClick="post_likeimg(this.id)">';
                    $imglike1 .= '<i class="fa fa-thumbs-up main_color" aria-hidden="true">';
                    $imglike1 .= '</i>';
                    $imglike1 .= '<span  id="popup"> ';
                    if (count($bdata2) > 0) {
                       // $imglike1 .= count($bdata2) . '';
                    }
                    $imglike1 .= '</span>';
                    $imglike1 .= '</a>';
                    $imglike1 .= '</li>';

                    //10-5 user list start

                    $contition_array = array('post_image_id' => $post_image, 'is_unlike' => '0');
                    $commnetcount = $this->common->select_data_by_condition('art_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    //       echo '<pre>'; print_r($commnetcount); die();                                     
                    foreach ($commnetcount as $comment) {
                        $art_fname1 = $this->db->get_where('art_reg', array('user_id' => $comment['user_id'], 'status' => 1))->row()->art_name;
                        $art_lname1 = $this->db->get_where('art_reg', array('user_id' => $comment['user_id'], 'status' => 1))->row()->art_lastname;
                    }
      $cmtlikeuser .= '<div class="like_one_other">';

                    $cmtlikeuser .= '<a href="javascript:void(0);" class="likeuserlist1" onclick="likeuserlistimg(' . $post_image . ')">';

                    $contition_array = array('post_image_id' => $post_image, 'is_unlike' => '0');
                    $commnetcount = $this->common->select_data_by_condition('art_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    //echo "hehehe";   echo '<pre>'; echo count($commnetcount); print_r($commnetcount); die();         
                    $art_fname = $this->db->get_where('art_reg', array('user_id' => $commnetcount[0]['user_id'], 'status' => 1))->row()->art_name;
                    $art_lname = $this->db->get_where('art_reg', array('user_id' => $commnetcount[0]['user_id'], 'status' => 1))->row()->art_lastname;

              
                    if ($userid == $commnetcount[0]['user_id']) {
                        $cmtlikeuser .= 'You';
                    } else {
                        $cmtlikeuser .= '' . ucfirst(strtolower($art_fname)) . '';
                        $cmtlikeuser .= '&nbsp;';
                        $cmtlikeuser .= '' . ucfirst(strtolower($art_lname)) . '';
                        $cmtlikeuser .= '&nbsp;';
                    }
                    if (count($commnetcount) > 1) {
                        $cmtlikeuser .= 'and ';
                        $cmtlikeuser .= ' ' . count($commnetcount) - 1 . '';
                        $cmtlikeuser .= '&nbsp;';
                        $cmtlikeuser .= 'others';
                    }

                   
                    $cmtlikeuser .= '</a>';
                     $cmtlikeuser .= '</div>';
                    //  echo $cmtlikeuser; die();  
               $like_user_count =  '<span class="comment_like_count">'; 
               if (count($commnetcount) > 0) { 
              $like_user_count .= '' . count($commnetcount) . ''; 
              $like_user_count .=     '</span>'; 
              $like_user_count .= '<span> Like</span>';
               }
              
                   // $like_user_count = count($commnetcount);
                    echo json_encode(
                            array("like" => $imglike1,
                                "likeuser" => $cmtlikeuser,
                                "like_user_count" => $like_user_count));
                    //10-5 user list end
                    //    echo $imglike1;
                }
            }
        }
    }

//multiple iamges like end 
//multiple 9-5 images comment strat

    public function insert_commentthreeimg() {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $post_image_id = $_POST["post_image_id"];
        $post_comment = $_POST["comment"];


        //$contition_array = array('post_image_id' => $_POST["post_image_id"], 'is_unlike' => '0');
        $contition_array = array('post_files_id' => $_POST["post_image_id"], 'is_deleted' => '1');
        $artimg = $this->data['artimg'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('art_post_id' => $artimg[0]["post_id"], 'is_delete' => 0);
        $artpostid = $this->data['artpostid'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($artpostid); die();

        $data = array(
            'user_id' => $userid,
            'post_image_id' => $post_image_id,
            'comment' => $post_comment,
            'created_date' => date('Y-m-d H:i:s', time()),
            'is_delete' => 0
        );
        $insert_id = $this->common->insert_data_getid($data, 'art_post_image_comment');

        // insert notification

        if ($artpostid[0]['user_id'] == $userid) {
            
        } else {
            $datanotification = array(
                'not_type' => 6,
                'not_from_id' => $userid,
                'not_to_id' => $artpostid[0]['user_id'],
                'not_read' => 2,
                'not_product_id' => $insert_id,
                'not_from' => 3,
                'not_img' => 4,
                'not_active' => 1,
                'not_created_date' => date('Y-m-d H:i:s')
            );
            //echo "<pre>"; print_r($datanotification); die();
            $insert_id_notification = $this->common->insert_data_getid($datanotification, 'notification');
        }
        // end notoification

        $contition_array = array('post_image_id' => $post_image_id, 'is_delete' => '0');
        $artcomment = $this->common->select_data_by_condition('art_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');

        // count of artcomment

        $contition_array = array('post_image_id' => $post_image_id, 'is_delete' => '0');
        $artcont = $this->common->select_data_by_condition('art_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        // echo "<pre>"; print_r($artcont); die();
        foreach ($artcomment as $art_comment) {


            $art_name = $this->db->get_where('art_reg', array('user_id' => $art_comment['user_id']))->row()->art_name;

            $art_lastname = $this->db->get_where('art_reg', array('user_id' => $art_comment['user_id']))->row()->art_lastname;

            $art_slug = $this->db->get_where('art_reg', array('user_id' => $art_comment['user_id']))->row()->slug;

            $art_userimage = $this->db->get_where('art_reg', array('user_id' => $art_comment['user_id'], 'status' => 1))->row()->art_user_image;

            $cmtinsert = '<div class="all-comment-comment-box">';
            $cmtinsert .= '<div class="post-design-pro-comment-img">';
            $cmtinsert .= '<a href="' . base_url('artistic/dashboard/' . $art_slug . '') . '">';

            if($art_userimage){

                if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                            $a = $art_name;
                            $acr = substr($a, 0, 1);
                            $b = $art_lastname;
                            $bcr = substr($b, 0, 1);

                                $cmtinsert .= '<div class="post-img-div">';
                                $cmtinsert .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                                $cmtinsert .=  '</div>';


                        } else {

            $cmtinsert .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage . '" alt="">'; 

                }

             
             }else{

               //$cmtinsert .= '<img  src="' . base_url(NOIMAGE) . '" alt="">  </div>';  


                           $a = $art_name;
                            $acr = substr($a, 0, 1);
                            $b = $art_lastname;
                            $bcr = substr($b, 0, 1);

                    $cmtinsert .= '<div class="post-img-div">';
                    $cmtinsert .=  ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                    $cmtinsert .=  '</div>';


                   
             }
              $cmtinsert .= '</a>';
              $cmtinsert .=  '</div>';

            $cmtinsert .= '<div class="comment-name">';
            $cmtinsert .= '<a href="' . base_url('artistic/dashboard/' . $art_slug . '') . '">

            <b>' . ucfirst(strtolower($art_name)) .' '.ucfirst(strtolower($art_lastname)). '</b></a>';
            $cmtinsert .= '</div>';
            

            $cmtinsert .= '<div class="comment-details" id= "showcommentimg' . $art_comment['post_image_comment_id'] . '"" >';
            $cmtinsert .= $this->common->make_links($art_comment['comment']);
            $cmtinsert .= '</div>';
            $cmtinsert .= '<div contenteditable="true" class="editable_text" style="width:75%; display:none;" name="' . $art_comment['post_image_comment_id'] . '" id="editcommentimg' . $art_comment['post_image_comment_id'] . '"style="display:none;" onkeyup="commenteditimg(' . $art_comment['post_image_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">';

            $cmtinsert .= '' . $art_comment['comment'] . '';
            $cmtinsert .= '</div>';

            $cmtinsert .= '<button id="editsubmitimg' . $art_comment['post_image_comment_id'] . '" style="display:none; margin-left:15px;" onClick="edit_commentimg(' . $art_comment['post_image_comment_id'] . ')">Comment</button><div class="art-comment-menu-design"> <div class="comment-details-menu" id="likecommentimg' . $art_comment['post_image_comment_id'] . '">';

            $cmtinsert .= '<a id="' . $art_comment['post_image_comment_id'] . '"';
            $cmtinsert .= 'onClick="comment_likeimg(this.id)">';

            $contition_array = array('post_image_comment_id' => $art_comment['post_image_comment_id'], 'user_id' => $userid, 'is_unlike' => 0);

            $artcommentlike1 = $this->common->select_data_by_condition('art_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if (count($artcommentlike1) == 0) {
                $cmtinsert .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
            } else {

                $cmtinsert .= '<i class="fa fa-thumbs-up" aria-hidden="true"></i>';
            }

            $cmtinsert .= '<span> ';

            $contition_array = array('post_image_comment_id' => $art_comment['post_image_comment_id'], 'is_unlike' => '0');
            $mulcountlike = $this->data['mulcountlike'] = $this->common->select_data_by_condition('art_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            if (count($mulcountlike) > 0) {
                //echo count($mulcountlike); 
            }
            $cmtinsert .= '</span>';
            $cmtinsert .= '</a></div>';

            $userid = $this->session->userdata('aileenuser');
            if ($art_comment['user_id'] == $userid) {

                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';


                $cmtinsert .= '<div id="editcommentboximg' . $art_comment['post_image_comment_id'] . '"style="display:block;">';

                $cmtinsert .= '<a id="' . $art_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_editboximg(this.id,'.$post_image_id.')">';
                $cmtinsert .= 'Edit';
                $cmtinsert .= '</a></div>';

                $cmtinsert .= '<div id="editcancleimg' . $art_comment['post_image_comment_id'] . '"style="display:none;">';

                $cmtinsert .= '<a id="' . $art_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_editcancleimg(this.id,'.$post_image_id.')">';
                $cmtinsert .= 'Cancel';
                $cmtinsert .= '</a></div>';

                $cmtinsert .= '</div>';
            }
            $userid = $this->session->userdata('aileenuser');


            $userid = $this->session->userdata('aileenuser');

            $art_userid = $this->db->get_where('art_post', array('art_post_id' => $art_comment['post_image_id'], 'status' => 1))->row()->user_id;


            if ($art_comment['user_id'] == $userid || $art_userid == $userid) {


                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';


                $cmtinsert .= '<input type="hidden" name="post_deleteimg"';
                $cmtinsert .= 'id="post_deleteimg' . $art_comment['post_image_comment_id'] . '"';
                //$cmtinsert .= 'id="post_deleteimg"';
                $cmtinsert .= 'value= "' . $art_comment['post_image_id'] . '">';
                $cmtinsert .= '<a id="' . $art_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_deleteimg(this.id)">';
                $cmtinsert .= 'Delete';
                $cmtinsert .= '</a></div>';
            }

            $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
            $cmtinsert .= '<div class="comment-details-menu">';
            $cmtinsert .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($art_comment['created_date']))) . '</p></div></div></div>';


            if (count($artcont) > 1) {
                // comment aount variable start
                $cmtcount = '<a onClick="commentallimg(this.id)" id="' . $post_image_id . '">';
                $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
                $cmtcount .= ' ' . count($artcont) . '';
                $cmtcount .= '</i></a>';
            }
            // comment count variable end 
            
             $cntinsert =  '<span class="comment_count" >';
     if (count($artcont) > 0) {
           $cntinsert .= '' . count($artcont) . ''; 
           $cntinsert .=   '</span>'; 
           $cntinsert .=  '<span> Comment</span>';
        
           }
        }
        //   echo $cmtinsert;
        echo json_encode(
                array("comment" => $cmtinsert,
                    "count" => $cmtcount,
                    "commentcount" => $cntinsert));
    }


     public function insert_commentthree_postnewpage() {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

    $post_id = $_POST["post_id"];
      $post_comment = $_POST["comment"];
//die();

        $contition_array = array('art_post_id' => $_POST["post_id"], 'status' => '1');
        $artdatacomment = $this->data['artdatacomment'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $data = array(
            'user_id' => $userid,
            'art_post_id' => $post_id,
            'comments' => $post_comment,
            'created_date' => date('Y-m-d H:i:s', time()),
            'status' => 1,
            'is_delete' => 0
        );



        $insert_id = $this->common->insert_data_getid($data, 'artistic_post_comment');

        // insert notification

        if ($artdatacomment[0]['user_id'] == $userid || $artdatacomment[0]['is_delete'] == '1') {
            
        } else {
            $notificationdata = array(
                'not_type' => 6,
                'not_from_id' => $userid,
                'not_to_id' => $artdatacomment[0]['user_id'],
                'not_read' => 2,
                'not_product_id' => $insert_id,
                'not_from' => 3,
                'not_img' => 1,
                'not_active' => 1,
                'not_created_date' => date('Y-m-d H:i:s')
            );
            //echo "<pre>"; print_r($notificationdata); 
            $insert_id_notification = $this->common->insert_data_getid($notificationdata, 'notification');
        }
        // end notoification



        $contition_array = array('art_post_id' => $_POST["post_id"], 'status' => '1');
        $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = 'artistic_post_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($artdata); die();
        // all count of commnet 

        $contition_array = array('art_post_id' => $_POST["post_id"], 'status' => '1');
        $allcomnt = $this->data['allcomnt'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = 'artistic_post_comment_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        // echo '<pre>'; print_r($artdata); die();            
// khyati changes start

        foreach ($artdata as $art) {

            $artname = $this->db->get_where('art_reg', array('user_id' => $art['user_id'], 'status' => 1))->row()->art_name;

            $artlastname = $this->db->get_where('art_reg', array('user_id' => $art['user_id']))->row()->art_lastname;

             $artslug = $this->db->get_where('art_reg', array('user_id' => $art['user_id']))->row()->slug;

            $art_userimage = $this->db->get_where('art_reg', array('user_id' => $art['user_id'], 'status' => 1))->row()->art_user_image;

            $cmtinsert .= '<div class="all-comment-comment-box">';
            $cmtinsert .= '<div class="post-design-pro-comment-img">';
            $cmtinsert .= '<a href="' . base_url('artistic/dashboard/' . $artslug . '') . '">';

            if($art_userimage){


                if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                            $a = $artname;
                            $acr = substr($a, 0, 1);
                            $b = $artlastname;
                            $bcr = substr($b, 0, 1);

                                $cmtinsert .= '<div class="post-img-div">';
                                $cmtinsert .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                                $cmtinsert .=  '</div>';


                        } else {

            $cmtinsert .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage . '" alt="">';

                  }
             

            }else{

             
                         $a = $artname;
                            $acr = substr($a, 0, 1);
                            $b = $artlastname;
                            $bcr = substr($b, 0, 1);

                    $cmtinsert .= '<div class="post-img-div">';
                    $cmtinsert .=  ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                    $cmtinsert .=  '</div>';
                    
            }

              $cmtinsert .= '</a>';
             $cmtinsert .= '</div>';


            $cmtinsert .= '<div class="comment-name">';
            $cmtinsert .= '<a href="' . base_url('artistic/dashboard/' . $artslug . '') . '">

            <b>' . ucfirst(strtolower($artname)) . '&nbsp;' . ucfirst(strtolower($artlastname)) . '</b></a>';
            $cmtinsert .= '</div>';
            $cmtinsert .= '<div class="comment-details" id= "showcomment' . $art['artistic_post_comment_id'] . '" >';
            $cmtinsert .= $this->common->make_links($art['comments']);
            $cmtinsert .= '</div>';
            $cmtinsert .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';
            $cmtinsert .= '<div contenteditable="true" class="editable_text"  name="' . $art['artistic_post_comment_id'] . '" id="editcomment' . $art['artistic_post_comment_id'] . '" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" onkeyup="commentedit(' . $art['artistic_post_comment_id'] .','.$post_id.')" onpaste="OnPaste_StripFormatting(this, event);">';
            $cmtinsert .= '' . $art['comments'] . '';
            $cmtinsert .= '</div>';
            $cmtinsert .= '<span class="comment-edit-button"><button id="editsubmit' . $art['artistic_post_comment_id'] . '" style="display:none" onClick="edit_comment(' . $art['artistic_post_comment_id'] .','.$post_id.')">Save</button></span>';
            $cmtinsert .= '</div></div>';
            //$cmtinsert .= '<button id="editsubmit' . $art['artistic_post_comment_id'] . '" style="display:none" onClick="edit_comment(' . $art['artistic_post_comment_id'] . ')">Comment</button><div class="art-comment-menu-design"> <div class="comment-details-menu" id="likecomment1' . $art['artistic_post_comment_id'] . '">';

            $cmtinsert .= '<div class="art-comment-menu-design"><div class="comment-details-menu" id="likecomment1' . $art['artistic_post_comment_id'] . '">';
            $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '"';
            $cmtinsert .= 'onClick="comment_like1(this.id)">';



            $userid = $this->session->userdata('aileenuser');
            $contition_array = array('artistic_post_comment_id' => $art['artistic_post_comment_id'], 'status' => '1');
            $artcommentlike = $this->data['artcommentlike'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $likeuserarray = explode(',', $artcommentlike[0]['artistic_comment_like_user']);

            if (!in_array($userid, $likeuserarray)) {


                $cmtinsert .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
            } else {
                $cmtinsert .= '<i class="fa fa-thumbs-up" aria-hidden="true"></i>';
            }
            $cmtinsert .= '<span>';

            if ($art['artistic_comment_likes_count'] > 0) {
                $cmtinsert .= ' ' . $art['artistic_comment_likes_count'];
            }
            $cmtinsert .= '</span>';
            $cmtinsert .= '</a></div>';

            $userid = $this->session->userdata('aileenuser');
            if ($art['user_id'] == $userid) {

                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';
                $cmtinsert .= '<div id="editcommentbox' . $art['artistic_post_comment_id'] . '" style="display:block;">';
                $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_editbox(this.id,'.$post_id.')">';
                $cmtinsert .= 'Edit';
                $cmtinsert .= '</a></div>';
                $cmtinsert .= '<div id="editcancle' . $art['artistic_post_comment_id'] . '" style="display:none;">';
                $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '" onClick="comment_editcancle(this.id,'.$post_id.')">Cancel  </a></div>';

                $cmtinsert .= '</div>';
            }

            $userid = $this->session->userdata('aileenuser');
            $art_userid = $this->db->get_where('art_post', array('art_post_id' => $art['art_post_id'], 'status' => 1))->row()->user_id;

            if ($art['user_id'] == $userid || $art_userid == $userid) {

                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';
                
   $cmtinsert .=  '<input type="hidden" name="post_delete"';
   $cmtinsert .=  'id="post_delete' . $art['artistic_post_comment_id'] . '" value= "' . $art['art_post_id'] . '">';
   $cmtinsert .= '<a id="' . $art['artistic_post_comment_id'] . '"   onClick="comment_delete(this.id)"> Delete';
   $cmtinsert .= '<span class="insertcomment' . $art['artistic_post_comment_id'] . '"></span>';
   $cmtinsert .=  '</a></div>';
 
            }

            $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
            $cmtinsert .= '<div class="comment-details-menu">';
            $cmtinsert .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($art['created_date']))) . '</p></div></div></div>';
//          $cntinsert .= '<a onclick="commentall(this.id)" id="' . $art['art_post_id'] . '">';
 //          $cntinsert .= '<i class="fa fa-comment-o" aria-hidden="true">' .
//                    count($allcomnt) . '</i>';
            
          $cntinsert =  '<span class="comment_count" >';
     if (count($allcomnt) > 0) {
           $cntinsert .= '' . count($allcomnt) . ''; 
           $cntinsert .=   '</span>'; 
           $cntinsert .=  '<span> Comment</span>';
        
           }
       }
        echo json_encode(
                array("count" => $cntinsert,
                    "comment" => $cmtinsert,
                    "commentcount" => $cntinsert));

        // khyati chande 
    }


    public function mulimg_comment() {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $post_image_id = $_POST["post_image_id"];
        $post_comment = $_POST["comment"];


        $contition_array = array('post_files_id' => $_POST["post_image_id"], 'is_deleted' => '1');
        $artimg = $this->data['artimg'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('art_post_id' => $artimg[0]["post_id"], 'is_delete' => 0);
        $artpostid = $this->data['artpostid'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        $data = array(
            'user_id' => $userid,
            'post_image_id' => $post_image_id,
            'comment' => $post_comment,
            'created_date' => date('Y-m-d H:i:s', time()),
            'is_delete' => 0
        );
        $insert_id = $this->common->insert_data_getid($data, 'art_post_image_comment');

        // insert notification

        if ($artpostid[0]['user_id'] == $userid) {
            
        } else {
            $datanotification = array(
                'not_type' => 6,
                'not_from_id' => $userid,
                'not_to_id' => $artpostid[0]['user_id'],
                'not_read' => 2,
                'not_product_id' => $insert_id,
                'not_from' => 3,
                'not_img' => 4,
                'not_active' => 1,
                'not_created_date' => date('Y-m-d H:i:s')
            );

            $insert_id_notification = $this->common->insert_data_getid($datanotification, 'notification');
        }
        // end notoification

        $contition_array = array('post_image_id' => $post_image_id, 'is_delete' => '0');
        $artcomment = $this->common->select_data_by_condition('art_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        foreach ($artcomment as $art_comment) {


            $art_name = $this->db->get_where('art_reg', array('user_id' => $art_comment['user_id']))->row()->art_name;
            $art_lastname = $this->db->get_where('art_reg', array('user_id' => $art_comment['user_id']))->row()->art_lastname;

             $art_slug = $this->db->get_where('art_reg', array('user_id' => $art_comment['user_id']))->row()->slug;


            $art_userimage = $this->db->get_where('art_reg', array('user_id' => $art_comment['user_id'], 'status' => 1))->row()->art_user_image;

            $cmtinsert .= '<div class="all-comment-comment-box">';
            $cmtinsert .= '<div class="post-design-pro-comment-img">';
            $cmtinsert .= '<a href="' . base_url('artistic/dashboard/' . $art_slug . '') . '">';

            $cmtinsert .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage . '" alt=""> </a> </div>';
            $cmtinsert .= '<div class="comment-name">';
            $cmtinsert .= '<a href="' . base_url('artistic/dashboard/' . $art_slug . '') . '">

            <b>' . ucfirst(strtolower($art_name)) .' '.ucfirst(strtolower($art_lastname)). '</b></a>';
            $cmtinsert .= '</div>';
            

            $cmtinsert .= '<div class="comment-details" id= "showcommenttwo' . $art_comment['post_image_comment_id'] . '"" >';
            $cmtinsert .= $this->common->make_links($art_comment['comment']);
            $cmtinsert .= '</div>';
            $cmtinsert .= '<div contenteditable="true"   class="editable_text" name="' . $art_comment['post_image_comment_id'] . '" id="editcommenttwo' . $art_comment['post_image_comment_id'] . '"style="display:none;" onkeyup="commentedittwo(' . $art_comment['post_image_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">';

            $cmtinsert .= '' . $art_comment['comment'] . '';
            $cmtinsert .= '</div>';

            $cmtinsert .= '<button id="editsubmittwo' . $art_comment['post_image_comment_id'] . '" style="display:none;" onClick="edit_commenttwo(' . $art_comment['post_image_comment_id'] . ')">Comment</button><div class="art-comment-menu-design"> <div class="comment-details-menu" id="likecommentone' . $art_comment['post_image_comment_id'] . '">';

            $cmtinsert .= '<a id="' . $art_comment['post_image_comment_id'] . '"';
            $cmtinsert .= 'onClick="comment_liketwo(this.id)">';

            $contition_array = array('post_image_comment_id' => $art_comment['post_image_comment_id'], 'user_id' => $userid, 'is_unlike' => 0);

            $artcommentlike1 = $this->common->select_data_by_condition('art_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if (count($artcommentlike1) == 0) {
                $cmtinsert .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
            } else {

                $cmtinsert .= '<i class="fa fa-thumbs-up" aria-hidden="true"></i>';
            }

            $cmtinsert .= '<span> ';

            $contition_array = array('post_image_comment_id' => $art_comment['post_image_comment_id'], 'is_unlike' => '0');
            $mulcountlike = $this->data['mulcountlike'] = $this->common->select_data_by_condition('art_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            if (count($mulcountlike) > 0) {
                $cmtinsert .= '' . count($mulcountlikeuser) . '';
            }
            $cmtinsert .= '</span>';
            $cmtinsert .= '</a></div>';

            $userid = $this->session->userdata('aileenuser');
            if ($art_comment['user_id'] == $userid) {

                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';


                $cmtinsert .= '<div id="editcommentboxtwo' . $art_comment['post_image_comment_id'] . '"style="display:block;">';

                $cmtinsert .= '<a id="' . $art_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_editboxtwo(this.id)">';
                $cmtinsert .= 'Edit';
                $cmtinsert .= '</a></div>';

                $cmtinsert .= '<div id="editcancletwo' . $art_comment['post_image_comment_id'] . '"style="display:none;">';

                $cmtinsert .= '<a id="' . $art_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_editcancletwo(this.id)">';
                $cmtinsert .= 'Cancel';
                $cmtinsert .= '</a></div>';

                $cmtinsert .= '</div>';
            }
            $userid = $this->session->userdata('aileenuser');


            $userid = $this->session->userdata('aileenuser');

            $art_userid = $this->db->get_where('art_post', array('art_post_id' => $art_comment['post_image_id'], 'status' => 1))->row()->user_id;


            if ($art_comment['user_id'] == $userid || $art_userid == $userid) {


                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';


                $cmtinsert .= '<input type="hidden" name="post_deletetwo"';
                $cmtinsert .= 'id="post_deletetwo' . $art_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'value= "' . $art_comment['post_image_id'] . '">';
                $cmtinsert .= '<a id="' . $art_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_deletetwo(this.id)">';
                $cmtinsert .= 'Delete';
                $cmtinsert .= '</a></div>';
            }

            $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
            $cmtinsert .= '<div class="comment-details-menu">';
            $cmtinsert .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($art_comment['created_date']))) . '</p></div></div></div>';
        }
        echo $cmtinsert;
    }

//multiple images comment end 
//multiple 9-5 images comment like start
    public function like_commentimg1() {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End
        $post_image_comment_id = $_POST["post_image_comment_id"];

        $contition_array = array('post_image_comment_id' => $post_image_comment_id, 'user_id' => $userid);

        $likecommentuser = $this->data['likecommentuser'] = $this->common->select_data_by_condition('art_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        $contition_array = array('post_image_comment_id' => $post_image_comment_id);
        $artimglike = $this->data['artimglike'] = $this->common->select_data_by_condition('art_post_image_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('post_files_id' => $artimglike[0]['post_image_id'], 'insert_profile' => '1');
        $artlikeimg = $this->data['artlikeimg'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('art_post_id' => $artlikeimg[0]["post_id"]);
        $artimglikepost = $this->data['artimglikepost'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($artimglikepost); die();

        if (!$likecommentuser) {

            $data = array(
                'post_image_comment_id' => $post_image_comment_id,
                'user_id' => $userid,
                'created_date' => date('Y-m-d H:i:s', time()),
                'is_unlike' => 0
            );
//echo "<pre>"; print_r($data); die();

            $insertdata = $this->common->insert_data_getid($data, 'art_comment_image_like');


            // insert notification

            if ($artimglike[0]['user_id'] == $userid) {
                
            } else {
                $data = array(
                    'not_type' => 5,
                    'not_from_id' => $userid,
                    'not_to_id' => $artimglike[0]['user_id'],
                    'not_read' => 2,
                    'not_product_id' => $post_image_comment_id,
                    'not_from' => 3,
                    'not_img' => 6,
                    'not_active' => 1,
                    'not_created_date' => date('Y-m-d H:i:s')
                );
                //echo "<pre>"; print_r($data); die();
                $insert_id = $this->common->insert_data_getid($data, 'notification');
            }
            // end notoification


            $contition_array = array('post_image_comment_id' => $_POST["post_image_comment_id"], 'is_unlike' => '0');
            $adatacm = $this->data['adatacm'] = $this->common->select_data_by_condition('art_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($insertdata) {


                $imglike .= '<a id="' . $post_image_comment_id . '" onClick="comment_likeimg(this.id)">';
                $imglike .= ' <i class="fa fa-thumbs-up main_color" aria-hidden="true">';
                $imglike .= '</i>';
                $imglike .= '<span> ';
                if (count($adatacm) > 0) {
                    $imglike .= count($adatacm) . '';
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
                $updatdata = $this->db->update('art_comment_image_like ', $data);

                $contition_array = array('post_image_comment_id' => $post_image_comment_id, 'is_unlike' => '0');
                $cdata2 = $this->data['adata2'] = $this->common->select_data_by_condition('art_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');



                if ($updatdata) {



                    $imglike1 .= '<a id="' . $post_image_comment_id . '" onClick="comment_likeimg(this.id)">';
                    $imglike1 .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true">';
                    $imglike1 .= '</i>';
                    $imglike1 .= '<span>';
                    if (count($cdata2) > 0) {
                        $imglike1 .= count($cdata2) . '';
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


                //$updatdata = $this->common->update_data($data, 'art_comment_image_like', 'post_image_comment_id', $post_image_comment_id);
                $where = array('post_image_comment_id' => $post_image_comment_id, 'user_id' => $userid);
                $this->db->where($where);
                $updatdata = $this->db->update('art_comment_image_like ', $data);

                // insert notification

                if ($artimglike[0]['user_id'] == $userid) {
                    
                } else {

                    $contition_array = array('not_type' => 5, 'not_from_id' => $userid, 'not_to_id' => $artimglike[0]['user_id'], 'not_product_id' => $post_image_comment_id, 'not_from' => 3, 'not_img' => 6);
                    $artnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    if ($artnotification[0]['not_read'] == 2) {
                        
                    } elseif ($artnotification[0]['not_read'] == 1) {

                        $datalike = array(
                            'not_read' => 2
                        );

                        $where = array('not_type' => 5, 'not_from_id' => $userid, 'not_to_id' => $artimglike[0]['user_id'], 'not_product_id' => $post_image_comment_id, 'not_from' => 3, 'not_img' => 6);
                        $this->db->where($where);
                        $updatdata = $this->db->update('notification', $datalike);
                    } else {
                        $data = array(
                            'not_type' => 5,
                            'not_from_id' => $userid,
                            'not_to_id' => $artimglike[0]['user_id'],
                            'not_read' => 2,
                            'not_product_id' => $post_image_comment_id,
                            'not_from' => 3,
                            'not_img' => 6,
                            'not_active' => 1,
                            'not_created_date' => date('Y-m-d H:i:s')
                        );
                        //echo "<pre>"; print_r($data); die();
                        $insert_id = $this->common->insert_data_getid($data, 'notification');
                    }
                }
                // end notoification



                $contition_array = array('post_image_comment_id' => $_POST["post_image_comment_id"], 'is_unlike' => '0');
                $bdata2 = $this->data['bdata2'] = $this->common->select_data_by_condition('art_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');



                if ($updatdata) {


                    $imglike1 .= '<a id="' . $post_image_comment_id . '" onClick="comment_likeimg(this.id)">';
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

    public function mulimg_comment_like1() {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $post_image_comment_id = $_POST["post_image_comment_id"];

        $contition_array = array('post_image_comment_id' => $post_image_comment_id, 'user_id' => $userid);

        $likecommentuser = $this->data['likecommentuser'] = $this->common->select_data_by_condition('art_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('post_image_comment_id' => $post_image_comment_id);
        $artimglike = $this->data['artimglike'] = $this->common->select_data_by_condition('art_post_image_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('post_files_id' => $artimglike[0]['post_image_id'], 'insert_profile' => '1');
        $artlikeimg = $this->data['artlikeimg'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('art_post_id' => $artlikeimg[0]["post_id"]);
        $artimglikepost = $this->data['artimglikepost'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        if (!$likecommentuser) {

            $data = array(
                'post_image_comment_id' => $post_image_comment_id,
                'user_id' => $userid,
                'created_date' => date('Y-m-d H:i:s', time()),
                'is_unlike' => 0
            );
//echo "<pre>"; print_r($data); die();

            $insertdata = $this->common->insert_data_getid($data, 'art_comment_image_like');


            // insert notification

            if ($artimglike[0]['user_id'] == $userid) {
                
            } else {
                $data = array(
                    'not_type' => 5,
                    'not_from_id' => $userid,
                    'not_to_id' => $artimglike[0]['user_id'],
                    'not_read' => 2,
                    'not_product_id' => $insertdata,
                    'not_from' => 3,
                    'not_img' => 6,
                    'not_active' => 1,
                    'not_created_date' => date('Y-m-d H:i:s')
                );
                //echo "<pre>"; print_r($data); die();
                $insert_id = $this->common->insert_data_getid($data, 'notification');
            }
            // end notoification

            $contition_array = array('post_image_comment_id' => $_POST["post_image_comment_id"], 'is_unlike' => '0');
            $bdatacm = $this->data['bdatacm'] = $this->common->select_data_by_condition('art_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($insertdata) {


                $imglike .= '<a id="' . $post_image_comment_id . '" onClick="comment_liketwo(this.id)">';
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
                $updatdata = $this->db->update('art_comment_image_like ', $data);

                $contition_array = array('post_image_comment_id' => $post_image_comment_id, 'is_unlike' => '0');
                $bdata2 = $this->data['bdata2'] = $this->common->select_data_by_condition('art_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');



                if ($updatdata) {


                    $imglike1 .= '<a id="' . $post_image_comment_id . '" onClick="comment_liketwo(this.id)">';
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
                $updatdata = $this->db->update('art_comment_image_like ', $data);


                // insert notification

                if ($artimglike[0]['user_id'] == $userid) {
                    
                } else {

                    $contition_array = array('not_type' => 5, 'not_from_id' => $userid, 'not_to_id' => $artimglike[0]['user_id'], 'not_product_id' => $post_image_comment_id, 'not_from' => 3, 'not_img' => 6);
                    $artnotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    if ($artnotification[0]['not_read'] == 2) {
                        
                    } elseif ($artnotification[0]['not_read'] == 1) {

                        $datalike = array(
                            'not_read' => 2
                        );

                        $where = array('not_type' => 5, 'not_from_id' => $userid, 'not_to_id' => $artimglike[0]['user_id'], 'not_product_id' => $post_image_comment_id, 'not_from' => 3, 'not_img' => 6);
                        $this->db->where($where);
                        $updatdata = $this->db->update('notification', $datalike);
                    } else {
                        $data = array(
                            'not_type' => 5,
                            'not_from_id' => $userid,
                            'not_to_id' => $artimglike[0]['user_id'],
                            'not_read' => 2,
                            'not_product_id' => $post_image_comment_id,
                            'not_from' => 3,
                            'not_img' => 6,
                            'not_active' => 1,
                            'not_created_date' => date('Y-m-d H:i:s')
                        );
                        //echo "<pre>"; print_r($data); die();
                        $insert_id = $this->common->insert_data_getid($data, 'notification');
                    }
                }
                // end notoification

                $contition_array = array('post_image_comment_id' => $_POST["post_image_comment_id"], 'is_unlike' => '0');
                $bdata2 = $this->data['bdata2'] = $this->common->select_data_by_condition('art_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');



                if ($updatdata) {


                    $imglike1 .= '<a id="' . $post_image_comment_id . '" onClick="comment_liketwo(this.id)">';
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
//business_profile 9-5 comment edit start
    public function edit_comment_insertimg() {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End


        $post_image_comment_id = $_POST["post_image_comment_id"];
        $post_comment = $_POST["comment"];

        $data = array(
            'comment' => $post_comment,
            'modify_date' => date('y-m-d h:i:s')
        );


        $updatdata = $this->common->update_data($data, 'art_post_image_comment', 'post_image_comment_id', $post_image_comment_id);
        if ($updatdata) {

            $contition_array = array('post_image_comment_id' => $_POST["post_image_comment_id"], 'is_delete' => '0');
            $arteditdata = $this->data['arteditdata'] = $this->common->select_data_by_condition('art_post_image_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $cmtlike = '<div>';
            $cmtlike .= $this->common->make_links($arteditdata[0]['comment']) . "<br>";
            $cmtlike .= '</div>';
            echo $cmtlike;
        }
    }

//business_profile comment edit end
    //multiple images 9-5  commnet delete start
    public function delete_commentimg() {
        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $post_image_comment_id = $_POST["post_image_comment_id"];
        $post_delete = $_POST["post_delete"];

        $data = array(
            'is_delete' => 1,
            'modify_date' => date('y-m-d h:i:s')
        );


        $updatdata = $this->common->update_data($data, 'art_post_image_comment', 'post_image_comment_id', $post_image_comment_id);


        $contition_array = array('post_image_id' => $post_delete, 'is_delete' => '0');
        $artcomment = $this->common->select_data_by_condition('art_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');

        // count of artcomment

        $contition_array = array('post_image_id' => $post_delete, 'is_delete' => '0');
        $artcont = $this->common->select_data_by_condition('art_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //   echo "<pre>"; print_r($artcont); die();
        foreach ($artcomment as $art_comment) {


            $art_name = $this->db->get_where('art_reg', array('user_id' => $art_comment['user_id']))->row()->art_name;

            $art_lname = $this->db->get_where('art_reg', array('user_id' => $art_comment['user_id']))->row()->art_lastname;

            $art_slug = $this->db->get_where('art_reg', array('user_id' => $art_comment['user_id']))->row()->slug;


            $art_userimage = $this->db->get_where('art_reg', array('user_id' => $art_comment['user_id'], 'status' => 1))->row()->art_user_image;

            $cmtinsert .= '<div class="all-comment-comment-box">';
            $cmtinsert .= '<div class="post-design-pro-comment-img">';
            $cmtinsert .= '<a href="' . base_url('artistic/dashboard/' . $art_slug . '') . '">';


            if($art_userimage){

                if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                            $a = $art_name;
                            $acr = substr($a, 0, 1);
                            $b = $art_lname;
                            $bcr = substr($b, 0, 1);

                                $cmtinsert .= '<div class="post-img-div">';
                                $cmtinsert .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                                $cmtinsert .=  '</div>';


                        } else {
            $cmtinsert .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL. $art_userimage . '" alt="">';

                   }
            

           }else{

            //$cmtinsert .= '<img  src="' . base_url(NOIMAGE) . '" alt="">  </div>';

                           $a = $art_name;
                            $acr = substr($a, 0, 1);
                            $b = $art_lname;
                            $bcr = substr($b, 0, 1);

                    $cmtinsert .= '<div class="post-img-div">';
                    $cmtinsert .= ucfirst(strtolower($acr)) .ucfirst(strtolower($bcr)); 
                    $cmtinsert .=  '</div>';
                    
           }
            $cmtinsert .= '</a>';
           $cmtinsert .= '</div>';

            $cmtinsert .= '<div class="comment-name">';
            $cmtinsert .= '<a href="' . base_url('artistic/dashboard/' . $art_slug . '') . '">

            <b>' . ucfirst(strtolower($art_name)) .' '.ucfirst(strtolower($art_lname)). '</b></a>';
            $cmtinsert .= '</div>';
           

            $cmtinsert .= '<div class="comment-details" id= "showcommentimg' . $art_comment['post_image_comment_id'] . '">';
            $cmtinsert .= $art_comment['comment'];
            $cmtinsert .= '</div>';
            $cmtinsert .= '<div contenteditable="true"   class="editable_text" name="' . $art_comment['post_image_comment_id'] . '" id="editcommentimg' . $art_comment['post_image_comment_id'] . '"style="display:none;    width: 81%;
    min-height: 37px !important;
    margin-top: 0px !important;
    margin-left: 1.5% !important;" onkeyup="commenteditimg(' . $art_comment['post_image_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">';

            $cmtinsert .= '' . $this->common->make_links($art_comment['comment']) . '';
            $cmtinsert .= '</div>';

            $cmtinsert .= '<button id="editsubmitimg' . $art_comment['post_image_comment_id'] . '" style="display:none; margin-left:15px;" onClick="edit_commentimg(' . $art_comment['post_image_comment_id'] . ')">Comment</button><div class="art-comment-menu-design"> <div class="comment-details-menu" id="likecommentimg' . $art_comment['post_image_comment_id'] . '">';

            $cmtinsert .= '<a id="' . $art_comment['post_image_comment_id'] . '"';
            $cmtinsert .= 'onClick="comment_likeimg(this.id)">';

            $contition_array = array('post_image_comment_id' => $art_comment['post_image_comment_id'], 'user_id' => $userid, 'is_unlike' => 0);

            $artcommentlike1 = $this->common->select_data_by_condition('art_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if (count($artcommentlike1) == 0) {
                $cmtinsert .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
            } else {

                $cmtinsert .= '<i class="fa fa-thumbs-up" aria-hidden="true"></i>';
            }

            $cmtinsert .= '<span> ';

            $contition_array = array('post_image_comment_id' => $art_comment['post_image_comment_id'], 'is_unlike' => '0');
            $mulcountlike = $this->data['mulcountlike'] = $this->common->select_data_by_condition('art_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            if (count($mulcountlike) > 0) {
                echo count($mulcountlike);
            }
            $cmtinsert .= '</span>';
            $cmtinsert .= '</a></div>';

            $userid = $this->session->userdata('aileenuser');
            if ($art_comment['user_id'] == $userid) {

                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';


                $cmtinsert .= '<div id="editcommentboximg' . $art_comment['post_image_comment_id'] . '"style="display:block;">';

                $cmtinsert .= '<a id="' . $art_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_editboximg(this.id,'.$post_delete.')">';
                $cmtinsert .= 'Edit';
                $cmtinsert .= '</a></div>';

                $cmtinsert .= '<div id="editcancleimg' . $art_comment['post_image_comment_id'] . '"style="display:none;">';

                $cmtinsert .= '<a id="' . $art_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_editcancleimg(this.id,'.$post_delete.')">';
                $cmtinsert .= 'Cancel';
                $cmtinsert .= '</a></div>';

                $cmtinsert .= '</div>';
            }
            $userid = $this->session->userdata('aileenuser');


            $userid = $this->session->userdata('aileenuser');

            $art_userid = $this->db->get_where('art_post', array('art_post_id' => $art_comment['post_image_id'], 'status' => 1))->row()->user_id;


            if ($art_comment['user_id'] == $userid || $art_userid == $userid) {


                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';


                $cmtinsert .= '<input type="hidden" name="post_deleteimg"';
                // $cmtinsert .= 'id="post_deleteimg' . $art_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'id="post_deleteimg"';
                $cmtinsert .= 'value= "' . $art_comment['post_image_id'] . '">';
                $cmtinsert .= '<a id="' . $art_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_deleteimg(this.id)">';
                $cmtinsert .= 'Delete';
                $cmtinsert .= '</a></div>';
            }

            $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
            $cmtinsert .= '<div class="comment-details-menu">';
            $cmtinsert .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($art_comment['created_date']))) . '</p></div></div></div>';

            if (count($artcont) > 1) {
                // comment aount variable start
                $cmtcount = '<a onClick="commentallimg(this.id)" id="' . $art_comment['post_image_id'] . '">';
                $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
                $cmtcount .= ' ' . count($artcont) . '';
                $cmtcount .= '</i></a>';
            }
            // comment count variable end 
            
            
             $cntinsert =  '<span class="comment_count" >';
     if (count($artcont) > 0) {
           $cntinsert .= '' . count($artcont) . ''; 
           $cntinsert .=   '</span>'; 
           $cntinsert .=  '<span> Comment</span>';
        
           }
        }
        //   echo $cmtinsert;
        echo json_encode(
                array("comment" => $cmtinsert,
                    "count" => $cmtcount,
                    "commentcount" => $cntinsert,
                    ));
    }
    
    

// changes done 9-5
    public function delete_commenttwoimg() {
        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $post_image_comment_id = $_POST["post_image_comment_id"];
        $post_delete = $_POST["post_delete"];

        $data = array(
            'is_delete' => 1,
            'modify_date' => date('y-m-d h:i:s')
        );

        $updatdata = $this->common->update_data($data, 'art_post_image_comment', 'post_image_comment_id', $post_image_comment_id);


        $contition_array = array('post_image_id' => $post_delete, 'is_delete' => '0');
        $artcomment = $this->common->select_data_by_condition('art_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //   echo "<pre>"; print_r($artcomment); die();
        if (count($artcomment) > 0) {
            foreach ($artcomment as $art_comment) {

                $art_name = $this->db->get_where('art_reg', array('user_id' => $art_comment['user_id']))->row()->art_name;
                $art_lastname = $this->db->get_where('art_reg', array('user_id' => $art_comment['user_id']))->row()->art_lastname;

                $art_slug = $this->db->get_where('art_reg', array('user_id' => $art_comment['user_id']))->row()->slug;

                $art_userimage = $this->db->get_where('art_reg', array('user_id' => $art_comment['user_id'], 'status' => 1))->row()->art_user_image;

                $cmtinsert .= '<div class="all-comment-comment-box">';
               
                $cmtinsert .= '<div class="post-design-pro-comment-img">';
                 $cmtinsert .= '<a href="' . base_url('artistic/dashboard/' . $art_slug . '') . '">';

                if($art_userimage){

                    if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                            $a = $art_name;
                            $acr = substr($a, 0, 1);
                            $b = $art_lastname;
                            $bcr = substr($b, 0, 1);

                                $cmtinsert .= '<div class="post-img-div">';
                                $cmtinsert .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                                $cmtinsert .=  '</div>';


                        } else {

                $cmtinsert .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage . '" alt="">';

                     }
               

               }else{

                //$cmtinsert .= '<img  src="' . base_url(NOIMAGE) . '" alt="">  </div>';

                            $a = $art_name;
                            $acr = substr($a, 0, 1);
                            $b = $art_lastname;
                            $bcr = substr($b, 0, 1);

                    $cmtinsert .= '<div class="post-img-div">';
                    $cmtinsert .=  ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                    $cmtinsert .=  '</div>';
                   
               }
                $cmtinsert .= '</a>';
                $cmtinsert .= '</div>';

                $cmtinsert .= '<div class="comment-name">';
                 $cmtinsert .= '<a href="' . base_url('artistic/dashboard/' . $art_slug . '') . '">

                <b>' . ucfirst(strtolower($art_name)) .' '.ucfirst(strtolower($art_lastname)). '</b></a>';
                $cmtinsert .= '</div>';
                
                $cmtinsert .= '<div class="comment-details" id= "showcommentimgtwo' . $art_comment['post_image_comment_id'] . '">';
                $cmtinsert .= $this->common->make_links($art_comment['comment']);
                $cmtinsert .= '</div>';
                $cmtinsert .= '<div contenteditable="true" class="editable_text" name="' . $art_comment['post_image_comment_id'] . '" id="editcommentimgtwo' . $art_comment['post_image_comment_id'] . '"style="display:none;    width: 81%;
    min-height: 37px !important;
    margin-top: 0px !important;
    margin-left: 1.5% !important; margin-right10px;" onkeyup="commenteditimgtwo(' . $art_comment['post_image_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">';

                $cmtinsert .= '' . $art_comment['comment'] . '';
                $cmtinsert .= '</div>';

                $cmtinsert .= '<button id="editsubmitimgtwo' . $art_comment['post_image_comment_id'] . '" style="display:none; margin-left:15px;" onClick="edit_commentimgtwo(' . $art_comment['post_image_comment_id'] . ')">Comment</button><div class="art-comment-menu-design"> <div class="comment-details-menu" id="likecommentimg' . $art_comment['post_image_comment_id'] . '">';

                $cmtinsert .= '<a id="' . $art_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_likeimg(this.id)">';

                $contition_array = array('post_image_comment_id' => $art_comment['post_image_comment_id'], 'user_id' => $userid, 'is_unlike' => 0);

                $artcommentlike1 = $this->common->select_data_by_condition('art_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if (count($artcommentlike1) == 0) {
                    $cmtinsert .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
                } else {

                    $cmtinsert .= '<i class="fa fa-thumbs-up" aria-hidden="true"></i>';
                }

                $cmtinsert .= '<span> ';

                $contition_array = array('post_image_comment_id' => $art_comment['post_image_comment_id'], 'is_unlike' => '0');
                $mulcountlike = $this->data['mulcountlike'] = $this->common->select_data_by_condition('art_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


                if (count($mulcountlike) > 0) {
                    $cmtinsert .= '' . count($mulcountlike) . '';
                }
                $cmtinsert .= '</span>';
                $cmtinsert .= '</a></div>';

                $userid = $this->session->userdata('aileenuser');
                if ($art_comment['user_id'] == $userid) {

                    $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $cmtinsert .= '<div class="comment-details-menu">';


                    $cmtinsert .= '<div id="editcommentboximgtwo' . $art_comment['post_image_comment_id'] . '"style="display:block;">';

                    $cmtinsert .= '<a id="' . $art_comment['post_image_comment_id'] . '"';
                    $cmtinsert .= 'onClick="comment_editboximgtwo(this.id,'.$post_delete.')">';
                    $cmtinsert .= 'Edit';
                    $cmtinsert .= '</a></div>';

                    $cmtinsert .= '<div id="editcancleimgtwo' . $art_comment['post_image_comment_id'] . '"style="display:none;">';

                    $cmtinsert .= '<a id="' . $art_comment['post_image_comment_id'] . '"';
                    $cmtinsert .= 'onClick="comment_editcancleimgtwo(this.id,'.$post_delete.')">';
                    $cmtinsert .= 'Cancel';
                    $cmtinsert .= '</a></div>';

                    $cmtinsert .= '</div>';
                }
                $userid = $this->session->userdata('aileenuser');


                $userid = $this->session->userdata('aileenuser');

                $art_userid = $this->db->get_where('art_post', array('art_post_id' => $art_comment['post_image_id'], 'status' => 1))->row()->user_id;


                if ($art_comment['user_id'] == $userid || $art_userid == $userid) {


                    $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $cmtinsert .= '<div class="comment-details-menu">';


                    $cmtinsert .= '<input type="hidden" name="post_deleteimgtwo"';
                    //$cmtinsert .= 'id="post_deleteimgtwo' . $art_comment['post_image_comment_id'] . '"';
                    $cmtinsert .= 'id="post_deleteimgtwo"';
                    $cmtinsert .= 'value= "' . $art_comment['post_image_id'] . '">';
                    $cmtinsert .= '<a id="' . $art_comment['post_image_comment_id'] . '"';
                    $cmtinsert .= 'onClick="comment_deleteimgtwo(this.id)">';
                    $cmtinsert .= 'Delete';
                    $cmtinsert .= '</a></div>';
                }

                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';
                $cmtinsert .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($art_comment['created_date']))) . '</p></div></div></div>';

                // comment aount variable start
                $idpost = $art['art_post_id'];
                $cmtcount = '<a onClick="commentallimg(this.id)" id="' . $post_delete . '">';
                $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
                $cmtcount .= ' ' . count($artcomment) . '';
                $cmtcount .= '</i></a>';
            }
        } else {

            $cmtcount = '<a onClick="commentallimg(this.id)" id="' . $post_delete . '">';
            $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
            $cmtcount .= '</i></a>';
        }
        
         $cntinsert =  '<span class="comment_count" >';
     if (count($artcomment) > 0) {
           $cntinsert .= '' . count($artcomment) . ''; 
           $cntinsert .=   '</span>'; 
           $cntinsert .=  '<span> Comment</span>';
        
           }
        //echo $cmtinsert;
        echo json_encode(
                array("comment" => $cmtinsert,
                    "count" => $cmtcount,
                    "commentcount" => $cntinsert
                    ));
    }

    //mulitple images commnet delete end 
    // khyati 17-4 changes start

    public function fourcomment($postid) {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        //$post_id =  $postid; 
        $post_id = $_POST['art_post_id'];

        // html start
        $condition_array = array('art_post_id' => $post_id);
        $profile_data = $this->common->select_data_by_condition('art_post', $condition_array, $data = 'status,user_id,is_delete,posted_user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($profile_data); die();
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

        // echo  $dataavl; die();
         if($return == 0){
        
           $fourdata = 'notavl';
      
        echo $fourdata;


         }else{
        

        $contition_array = array('art_post_id' => $post_id, 'status' => '1');
        $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = 'artistic_post_comment_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $fourdata = '<div class="hidebottombordertwo insertcommenttwo' . $post_id . '">';

        if ($artdata) {
            foreach ($artdata as $rowdata) {

                $artname = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->art_name;
                $artlastname = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->art_lastname;
                 $artslug = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->slug;

                $fourdata .= '<div class="all-comment-comment-box">';
                $fourdata .= '<div class="post-design-pro-comment-img">';
                $fourdata .= '<a href="' . base_url('artistic/dashboard/' . $artslug . '') . '">';
                
                $art_userimage = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id'], 'status' => 1))->row()->art_user_image;
                if ($art_userimage) {

                    
                    if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                            $a = $artname;
                            $acr = substr($a, 0, 1);
                            $b = $artlastname;
                            $bcr = substr($b, 0, 1);

                                $fourdata .= '<div class="post-img-div">';
                                $fourdata .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                                $fourdata .=  '</div>';


                        } else {
                    $fourdata .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage . '"  alt="">';
                    }

                    
                } else {


                    //
                          $a = $artname;
                            $acr = substr($a, 0, 1);
                            $b = $artlastname;
                            $bcr = substr($b, 0, 1);

                    $fourdata .= '<div class="post-img-div">';
                    $fourdata .=  ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                    $fourdata .=  '</div>';


                    
                    //$fourdata .= '<img src="' . base_url(NOIMAGE) . '" alt=""></div>';

                }
                $fourdata .= '</a>';
                $fourdata .= '</div>';

                $fourdata .= '<div class="comment-name">';
                $fourdata .= '<a href="' . base_url('artistic/dashboard/' . $artslug . '') . '">';

                $fourdata .= '<b>' . ucfirst(strtolower($artname)) . '&nbsp' . ucfirst(strtolower($artlastname)) . '</b></br></a> </div>';
                
                $fourdata .= '<div class="comment-details" id= "showcommenttwo' . $rowdata['artistic_post_comment_id'] . '">';

                $fourdata .= '<div id= "lessmore' . $rowdata['artistic_post_comment_id'] . '"  style="display:block;">';

                    $small = substr($rowdata['comments'], 0, 180);

                $fourdata .= '' . $this->common->make_links($small) . '';

                    // echo $this->common->make_links($small);

                     if (strlen($rowdata['comments']) > 180) {
                         $fourdata .= '... <span id="kkkk" onClick="seemorediv(' . $rowdata['artistic_post_comment_id'] . ')">View More</span>';
                        }

                $fourdata .= '</div>';


                $fourdata .= '<div id= "seemore' . $rowdata['artistic_post_comment_id'] . '"  style="display:none;">';

                $fourdata .= '' . $this->common->make_links($rowdata['comments']) . '</div></div>';

//                $fourdata .= '<textarea  name="' . $rowdata['artistic_post_comment_id'] . '" id="editcommenttwo' . $rowdata['artistic_post_comment_id'] . '" style="display:none" onClick="commentedittwo(this.name)">';
//                $fourdata .= '' . $rowdata['comments'] . '';
//                $fourdata .= '</textarea>';
                $fourdata .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';
                $fourdata .= '<div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="' . $rowdata['artistic_post_comment_id'] . '"  id="editcommenttwo' . $rowdata['artistic_post_comment_id'] . '" placeholder="Type Message ..." value= ""  onkeyup="commentedittwo(' . $rowdata['artistic_post_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $rowdata['comments'] . '</div>';
                $fourdata .= '<span class="comment-edit-button"><button id="editsubmittwo' . $rowdata['artistic_post_comment_id'] . '" style="display:none" onClick="edit_commenttwo(' . $rowdata['artistic_post_comment_id'] . ')">Save</button></span>';
//                $fourdata .= '<input type="text" name="' . $rowdata['artistic_post_comment_id'] . '" id="editcommenttwo' . $rowdata['artistic_post_comment_id'] . '" style="display:none" value="' . $rowdata['comments'] . '"  onClick="commentedittwo(this.name)">';
//                $fourdata .= '<button id="editsubmittwo' . $rowdata['artistic_post_comment_id'] . '" style="display:none" onClick="edit_commenttwo(' . $rowdata['artistic_post_comment_id'] . ')">Comment</button>';
                $fourdata .= '</div></div><div class="art-comment-menu-design">';
                $fourdata .= '<div class="comment-details-menu" id="likecomment' . $rowdata['artistic_post_comment_id'] . '">';
                $fourdata .= '<a id="' . $rowdata['artistic_post_comment_id'] . '"   onClick="comment_like(this.id)">';

                $userid = $this->session->userdata('aileenuser');
                $contition_array = array('artistic_post_comment_id' => $rowdata['artistic_post_comment_id'], 'status' => '1');
                $artcommentlike = $this->data['artcommentlike'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                $likeuserarray = explode(',', $artcommentlike[0]['artistic_comment_like_user']);

                if (!in_array($userid, $likeuserarray)) {
                    $fourdata .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
                } else {
                    $fourdata .= '<i class="fa fa-thumbs-up main_color" aria-hidden="true"></i>';
                }

                $fourdata .= '<span> ';
                if ($rowdata['artistic_comment_likes_count']) {
                    $fourdata .= '' . $rowdata['artistic_comment_likes_count'] . '';
                }
                $fourdata .= '</span></a></div>';

                $userid = $this->session->userdata('aileenuser');
                if ($rowdata['user_id'] == $userid) {

                    $fourdata .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $fourdata .= '<div class="comment-details-menu">';
                    $fourdata .= '<div id="editcommentboxtwo' . $rowdata['artistic_post_comment_id'] . '" style="display:block;">';
                    $fourdata .= '<a id="' . $rowdata['artistic_post_comment_id'] . '"   onClick="comment_editboxtwo(this.id)" class="editbox">Edit</a> </div>';
                    $fourdata .= '<div id="editcancletwo' . $rowdata['artistic_post_comment_id'] . '" style="display:none;">';
                    $fourdata .= '<a id="' . $rowdata['artistic_post_comment_id'] . '" onClick="comment_editcancletwo(this.id)">Cancel</a></div></div>';
                }
                $userid = $this->session->userdata('aileenuser');
                $art_userid = $this->db->get_where('art_post', array('art_post_id' => $rowdata['art_post_id'], 'status' => 1))->row()->user_id;
                if ($rowdata['user_id'] == $userid || $art_userid == $userid) {
                    $fourdata .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $fourdata .= '<div class="comment-details-menu">';
                    $fourdata .= '<input type="hidden" name="post_delete"  id="post_deletetwo" value= "' . $rowdata['art_post_id'] . '">';
                    $fourdata .= '<a id="' . $rowdata['artistic_post_comment_id'] . '"';
                    //$fourdata .= 'onClick="comment_deletetwo(this.id)"> Delete <span class="insertcommenttwo' . $rowdata['artistic_post_comment_id'] . '">';
                    $fourdata .= 'onClick="comment_deletetwo(this.id)"> Delete';
                    $fourdata .= '</span> </a> </div>';
                }
                $fourdata .= '<span role="presentation" aria-hidden="true"> · </span>';
                $fourdata .= '<div class="comment-details-menu">  <p>';
                $fourdata .= '' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($rowdata['created_date']))) . '</br></p></div>';
                $fourdata .= '</div></div>';
            }
        } else {
            $fourdata = 'No comments Available!!!</div>';
        }
        echo $fourdata;

       }
    }

    // khyati 9-5 changes end 


    public function fourcommentimg($postid) {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End
        //$post_id =  $postid; 
        $image_id = $_POST['art_post_id'];

        // html start

        $contition_array = array('post_image_id' => $image_id, 'is_delete' => '0');

        $artmulimage1 = $this->common->select_data_by_condition('art_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        // echo '<pre>'; print_r($artmulimage1); die();

        $fourdata = '<div class="hidebottombordertwo insertcommentimgtwo' . $image_id . '">';


        foreach ($artmulimage1 as $rowdata) {

            $artname = $this->db->get_where('art_reg', array('user_id' => $userid))->row()->art_name;


            $artlastname = $this->db->get_where('art_reg', array('user_id' => $userid))->row()->art_lastname;
            $artslug = $this->db->get_where('art_reg', array('user_id' => $userid))->row()->slug;



            $fourdata .= '<div class="all-comment-comment-box">';
            $fourdata .= '<div class="post-design-pro-comment-img">';
            $fourdata .= '<a href="' . base_url('artistic/dashboard/' . $artslug . '') . '">';

            $art_userimage = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id'], 'status' => 1))->row()->art_user_image;

            if($art_userimage){

                if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                            $a = $artname;
                            $acr = substr($a, 0, 1);
                            $b = $artlastname;
                            $bcr = substr($b, 0, 1);

                                $fourdata .= '<div class="post-img-div">';
                                $fourdata .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                                $fourdata .=  '</div>';


                        } else {

            $fourdata .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage . '"  alt="">';

                }

          
            }else{

             

                          $a = $artname;
                            $acr = substr($a, 0, 1);
                            $b = $artlastname;
                            $bcr = substr($b, 0, 1);

                    $fourdata .= '<div class="post-img-div">';
                    $fourdata .=  ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                    $fourdata .=  '</div>';
                    
            }
              $fourdata .= '</a>';  
              $fourdata .=  '</div>';

            $fourdata .= '<div class="comment-name">';
            $fourdata .= '<a href="' . base_url('artistic/dashboard/' . $artslug . '') . '">';

            $fourdata .= '<b>' . ucfirst(strtolower($artname)) . '&nbsp' . ucfirst(strtolower($artlastname)) . '</b></br> </a></div>';
            
            $fourdata .= '<div class="comment-details" id= "showcommentimgtwo' . $rowdata['post_image_comment_id'] . '">';
            $fourdata .= '' . $this->common->make_links($rowdata['comment']) . '</br></div>';

            $fourdata .= '<div contenteditable="true" class="editable_text" name="' . $rowdata['post_image_comment_id'] . '" id="editcommentimgtwo' . $rowdata['post_image_comment_id'] . '" style="display:none  ;  width: 81%;
    min-height: 37px !important;
    margin-top: 0px !important;
    margin-left: 1.5% !important; margin-right10px;"  onClick="commenteditimgtwo(' . $rowdata['post_image_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">';

            $fourdata .= '' . $rowdata['comment'] . '';
            $fourdata .= '</div>';

            $fourdata .= '<button id="editsubmitimgtwo' . $rowdata['post_image_comment_id'] . '" style="display:none; margin-left:15px;" onClick="edit_commentimgtwo(' . $rowdata['post_image_comment_id'] . ')">Comment</button>';

            $fourdata .= '<div class="art-comment-menu-design">';
            $fourdata .= '<div class="comment-details-menu" id="likecommentimg' . $rowdata['post_image_comment_id'] . '">';
            $fourdata .= '<a id="' . $rowdata['post_image_comment_id'] . '"   onClick="comment_likeimgtwo(this.id)">';

            $userid = $this->session->userdata('aileenuser');
            $contition_array = array('post_image_comment_id' => $rowdata['post_image_comment_id'], 'user_id' => $userid, 'is_unlike' => 0);
            $artcommentlike = $this->data['artcommentlike'] = $this->common->select_data_by_condition('art_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            if (count($artcommentlike) == 0) {
                $fourdata .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
            } else {
                $fourdata .= '<i class="fa fa-thumbs-up main_color" aria-hidden="true"></i>';
            }


            $contition_array = array('post_image_comment_id' => $rowdata['post_image_comment_id'], 'is_unlike' => '0');
            $mulcountlikeuser = $this->data['mulcountlikeuser'] = $this->common->select_data_by_condition('art_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            $fourdata .= '<span>';
            if ($mulcountlikeuser) {
                $fourdata .= ' ' . count($mulcountlikeuser) . '';
            }

            $fourdata .= '</span></a></div>';

            $userid = $this->session->userdata('aileenuser');
            if ($rowdata['user_id'] == $userid) {

                $fourdata .= '<span role="presentation" aria-hidden="true"> · </span>';
                $fourdata .= '<div class="comment-details-menu">';
                $fourdata .= '<div id="editcommentboximgtwo' . $rowdata['post_image_comment_id'] . '" style="display:block;">';
                $fourdata .= '<a id="' . $rowdata['post_image_comment_id'] . '"   onClick="comment_editboximgtwo(this.id,'.$image_id.')">Edit</a> </div>';
                $fourdata .= '<div id="editcancleimgtwo' . $rowdata['post_image_comment_id'] . '" style="display:none;">';
                $fourdata .= '<a id="' . $rowdata['post_image_comment_id'] . '" onClick="comment_editcancleimgtwo(this.id,'.$image_id.')">Cancel</a></div></div>';
            }
            $userid = $this->session->userdata('aileenuser');
            $art_userid = $this->db->get_where('art_post', array('art_post_id' => $rowdata['art_post_id'], 'status' => 1))->row()->user_id;
            if ($rowdata['user_id'] == $userid || $art_userid == $userid) {

                $fourdata .= '<span role="presentation" aria-hidden="true"> · </span>';
                $fourdata .= '<div class="comment-details-menu">';


                //   $fourdata .= '<input type="hidden" name="post_deleteimgtwo"  id="post_deleteimgtwo' . $rowdata['post_image_comment_id'] . '" value= "' . $rowdata['post_image_id'] . '">';
                $fourdata .= '<input type="hidden" name="post_deleteimgtwo"  id="post_deleteimgtwo" value= "' . $rowdata['post_image_id'] . '">';
                $fourdata .= '<a id="' . $rowdata['post_image_comment_id'] . '"';
                //$fourdata .= 'onClick="comment_deletetwo(this.id)"> Delete <span class="insertcommenttwo' . $rowdata['post_image_comment_id'] . '">';
                $fourdata .= 'onClick="comment_deleteimgtwo(this.id)"> Delete';
                $fourdata .= '</span> </a> </div>';
            }
            $fourdata .= '<span role="presentation" aria-hidden="true"> · </span>';
            $fourdata .= '<div class="comment-details-menu">  <p>';
            $fourdata .= '' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($rowdata['created_date']))) . '</br></p></div>';
            $fourdata .= '</div></div>';
        }

        echo $fourdata;
    }

    public function deletepdf() {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $contition_array = array('user_id' => $userid);
        $art_reg_data = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_bestofmine', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $art_bestofmine = $art_reg_data[0]['art_bestofmine'];

        if ($art_bestofmine != '') {
            $art_pdf_path = 'uploads/art_images/';
            $art_pdf = $art_pdf_path . $art_bestofmine;
            if (isset($art_pdf)) {
                unlink($art_pdf);
            }
        }

        $data = array(
            'art_bestofmine' => ''
        );

        $update = $this->common->update_data($data, 'art_reg', 'user_id', $userid);
        echo 'ok';
    }

    public function likeuserlistimg() {
        $post_id = $_POST['post_id'];

        $contition_array = array('post_image_id' => $post_id, 'is_unlike' => '0');
        $commnetcount = $this->common->select_data_by_condition('art_post_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        
           $modal =    '<div class="modal-header">';
       $modal .=   '<button type="button" class="close" data-dismiss="modal">&times;</button>';
       $modal .=   '<h4 class="modal-title">';
       
       $modal .=    '' . count($commnetcount) . ' Likes';
       
       $modal .= '</h4></div>';
       $modal .= '<div class="modal-body padding_less_right">';
       $modal .=     '<div class="like_user_list">';
       $modal .=     '<ul>';
          foreach ($commnetcount as $comment) {
             
     $art_name1 = $this->db->get_where('art_reg', array('user_id' => $comment['user_id'], 'status' => 1))->row()->art_name;

     $art_lastname = $this->db->get_where('art_reg', array('user_id' => $comment['user_id'], 'status' => 1))->row()->art_lastname;

     $designation = $this->db->get_where('art_reg', array('user_id' => $comment['user_id'], 'status' => 1))->row()->designation;
     $art_image = $this->db->get_where('art_reg', array('user_id' => $comment['user_id'], 'status' => 1))->row()->art_user_image;
   
       $modal .=  '<li>';
       $modal .=  '<div class="like_user_listq">';
       $modal .=  '<a href="' . base_url('artistic/artistic_profile/' . $value) . '" title="' . $art_name1 . '" class="head_main_name" >';
       $modal .=  '<div class="like_user_list_img">';
       
       
         if ($art_image) {

            if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_image)) {
                            $a = $art_name1;
                            $acr = substr($a, 0, 1);
                            $b = $art_lastname;
                            $bcr = substr($b, 0, 1);

                                $modal .= '<div class="post-img-div">';
                                $modal .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                                $modal .=  '</div>';


                        } else {

                    $modal .= '<img  src="' .ART_PROFILE_THUMB_UPLOAD_URL . $art_image . '"  alt="">';
                       }

                } else {

                           $a = $art_name1;
                            $acr = substr($a, 0, 1);
                            $b = $art_lastname;
                            $bcr = substr($b, 0, 1);

                    $modal .= '<div class="post-img-div">';
                    $modal .=  ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                    $modal .=  '</div>';
                    //$cmtinsert .= '</div>';

                    //$modal .= '<img src="' . base_url(NOIMAGE) . '" alt="">';
                }
       $modal .=  '</div>';
       $modal .=  '<div class="like_user_list_main_desc">';
       $modal .=  '<div class="like_user_list_main_name">';
       $modal .=  '' . ucfirst(strtolower($art_name1)) .' '.ucfirst(strtolower($art_lastname)). '';
       $modal .=  '</div></a>';
       $modal .=  '<div class="like_user_list_current_work">';


       if($designation){
       $modal .=  '<span class="head_main_work">' . $designation . '</span>';
        }else{
       $modal .=  '<span class="head_main_work">Current work</span>';

        }

       $modal .=  '</div>';
       $modal .=  '</div>';
       $modal .=  '</div>';
       $modal .=  '</li>';
            }
       $modal .=  '</ul>';
       $modal .=  '</div>';
       $modal .=  '<div class="clearfix"></div>';
       $modal .=  '</div>';
       $modal .=  '<div class="modal-footer">';
       $modal .=  '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
       $modal .=  '</div>';
      
       echo $modal;
//        echo '<div class="likeduser">';
//        echo '<div class="likeduser-title">User List</div>';
//        foreach ($commnetcount as $comment) {
//            $art_name1 = $this->db->get_where('art_reg', array('user_id' => $comment['user_id'], 'status' => 1))->row()->art_name;
//            echo '<div class="likeuser_list"><a href="' . base_url('artistic/artistic_profile/' . $comment['user_id']) . '">';
//            echo ucwords($art_name1);
//            echo '</a></div>';
//        }
//        echo '<div>';
    }

    public function likeuserlist() {
       $post_id = $_POST['post_id'];

        $contition_array = array('art_post_id' => $post_id, 'status' => '1', 'is_delete' => '0');
        $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
       
        $likeuser = $commnetcount[0]['art_like_user'];
        $countlike = $commnetcount[0]['art_likes_count'] - 1;

        $likelistarray = explode(',', $likeuser);
        // $likelistarray = array_reverse($likelistarray);
   
        
         $modal =    '<div class="modal-header">';
    //   $modal .=   '<button type="button" class="close" data-dismiss="modal">&times;</button>';
       $modal .=   '<h4 class="modal-title">';
       
       $modal .=    '' . count($likelistarray) . ' Likes';
       
       $modal .= '</h4></div>';
       $modal .= '<div class="modal-body padding_less_right">';
       $modal .=     '<div class="like_user_list">';
       $modal .=     '<ul>';
          foreach ($likelistarray as $key => $value) {
             
     $art_name1 = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => 1))->row()->art_name;
     $art_lastname = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => 1))->row()->art_lastname;
     $designation = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => 1))->row()->designation;
     $art_image = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => 1))->row()->art_user_image;
   
       $modal .=  '<li>';
       $modal .=  '<div class="like_user_listq">';
       $modal .=  '<a href="' . base_url('artistic/artistic_profile/' . $value) . '" title="' . $art_name1 . '" class="head_main_name" >';
       $modal .=  '<div class="like_user_list_img">';
       
       
         if ($art_image) {

            if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_image)) {
                            $a = $art_name1;
                            $acr = substr($a, 0, 1);
                            $b = $art_lastname;
                            $bcr = substr($b, 0, 1);

                                $modal .= '<div class="post-img-div">';
                                $modal .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                                $modal .=  '</div>';


                        } else {

                    $modal .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $art_image . '"  alt="">';

                     }
                } else {


                    //$modal .= '<img src="' . base_url(NOIMAGE) . '" alt="">';

                         $a = $art_name1;
                            $acr = substr($a, 0, 1);
                            $b = $art_lastname;
                            $bcr = substr($b, 0, 1);

                    $modal .= '<div class="post-img-div">';
                    $modal .=  ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                    $modal .=  '</div>';


                    //$cmtinsert .= '</div>';

                }
       $modal .=  '</div>';
       $modal .=  '<div class="like_user_list_main_desc">';
       $modal .=  '<div class="like_user_list_main_name">';
       $modal .=  '' . ucfirst(strtolower($art_name1)) .' '.ucfirst(strtolower($art_lastname)) .'';
       $modal .=  '</div></a>';
       $modal .=  '<div class="like_user_list_current_work">';

       if($designation){
       $modal .=  '<span class="head_main_work">' . $designation . '</span>';
        }else{
       $modal .=  '<span class="head_main_work">Current work</span>';

        }

       $modal .=  '</div>';
       $modal .=  '</div>';
       $modal .=  '</div>';
       $modal .=  '</li>';
            }
       $modal .=  '</ul>';
       $modal .=  '</div>';
       $modal .=  '<div class="clearfix"></div>';
       $modal .=  '</div>';
      // $modal .=  '<div class="modal-footer">';
//$modal .=  '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
      // $modal .=  '</div>';
      
       echo $modal;
//        echo '<div class="likeduser">';
//        echo '<div class="likeduser-title">User List</div>';
//        foreach ($likelistarray as $key => $value) {
//            $art_name1 = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => 1))->row()->art_name;
//            echo '<div class="likeuser_list"><a href="' . base_url('artistic/artistic_profile/' . $value) . '">';
//            echo ucwords($art_name1);
//            echo '</a></div>';
//        }
//        echo '<div>';
    }

    // khyati changes start 19-5
    public function insert_commentimg() {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $post_image_id = $_POST["post_image_id"];
        $post_comment = $_POST["comment"];


        //$contition_array = array('post_image_id' => $_POST["post_image_id"], 'is_unlike' => '0');
        $contition_array = array('post_files_id' => $_POST["post_image_id"], 'is_deleted' => '1');
        $artimg = $this->data['artimg'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('art_post_id' => $artimg[0]["post_id"], 'is_delete' => 0);
        $artpostid = $this->data['artpostid'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($artpostid); die();

        $data = array(
            'user_id' => $userid,
            'post_image_id' => $post_image_id,
            'comment' => $post_comment,
            'created_date' => date('Y-m-d H:i:s', time()),
            'is_delete' => 0
        );
        $insert_id = $this->common->insert_data_getid($data, 'art_post_image_comment');

        // insert notification

        if ($artpostid[0]['user_id'] == $userid) {
            
        } else {
            $datanotification = array(
                'not_type' => 6,
                'not_from_id' => $userid,
                'not_to_id' => $artpostid[0]['user_id'],
                'not_read' => 2,
                'not_product_id' => $insert_id,
                'not_from' => 3,
                'not_img' => 4,
                'not_active' => 1,
                'not_created_date' => date('Y-m-d H:i:s')
            );
            //echo "<pre>"; print_r($datanotification); die();
            $insert_id_notification = $this->common->insert_data_getid($datanotification, 'notification');
        }
        // end notoification

        $contition_array = array('post_image_id' => $post_image_id, 'is_delete' => '0');
        $artcomment = $this->common->select_data_by_condition('art_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        // count of artcomment

        $contition_array = array('post_image_id' => $post_image_id, 'is_delete' => '0');
        $artcont = $this->common->select_data_by_condition('art_post_image_comment', $contition_array, $data = '*', $sortby = 'post_image_comment_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $cmtinsert = '<div class="hidebottombordertwo insertcommentimgtwo' . $post_image_id . '">';
        //echo "<pre>"; print_r($artcomment); die();
        foreach ($artcomment as $art_comment) {

            $art_name = $this->db->get_where('art_reg', array('user_id' => $art_comment['user_id']))->row()->art_name;

            $art_lastname = $this->db->get_where('art_reg', array('user_id' => $art_comment['user_id']))->row()->art_lastname;

            $art_slug = $this->db->get_where('art_reg', array('user_id' => $art_comment['user_id']))->row()->slug;

            $art_userimage = $this->db->get_where('art_reg', array('user_id' => $art_comment['user_id'], 'status' => 1))->row()->art_user_image;

            $cmtinsert .= '<div class="all-comment-comment-box">';
            $cmtinsert .= '<div class="post-design-pro-comment-img">';
            $cmtinsert .= '<a href="' . base_url('artistic/dashboard/' . $art_slug . '') . '">';

            if($art_userimage){

                if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                            $a = $art_name;
                            $acr = substr($a, 0, 1);
                            $b = $art_lastname;
                            $bcr = substr($b, 0, 1);

                                $cmtinsert .= '<div class="post-img-div">';
                                $cmtinsert .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                                $cmtinsert .=  '</div>';


                        } else {
            $cmtinsert .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage . '" alt="">';

                    }
             
            }else{


           // $cmtinsert .= '<img  src="' . base_url(NOIMAGE) . '" alt="">  </div>';


                          $a = $art_name;
                            $acr = substr($a, 0, 1);
                            $b = $art_lastname;
                            $bcr = substr($b, 0, 1);

                    $cmtinsert .= '<div class="post-img-div">';
                    $cmtinsert .=  ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                    $cmtinsert .=  '</div>';
                    

            }
            $cmtinsert .= '</a>';
            $cmtinsert .= '</div>';

            $cmtinsert .= '<div class="comment-name">';
            $cmtinsert .= '<a href="' . base_url('artistic/dashboard/' . $art_slug . '') . '">

            <b>' . ucfirst(strtolower($art_name)) .' '.ucfirst(strtolower($art_lastname)). '</b></a>';
            $cmtinsert .= '</div>';
            

            $cmtinsert .= '<div class="comment-details" id= "showcommentimgtwo' . $art_comment['post_image_comment_id'] . '"" >';
            $cmtinsert .= $this->common->make_links($art_comment['comment']);
            $cmtinsert .= '</div>';
            $cmtinsert .= '<div contenteditable="true" class="editable_text" name="' . $art_comment['post_image_comment_id'] . '" id="editcommentimgtwo' . $art_comment['post_image_comment_id'] . '"style="display:none;    width: 81%;
    min-height: 37px !important;
    margin-top: 0px !important;
    margin-left: 1.5% !important ;" onkeyup="commenteditimgtwo(' . $art_comment['post_image_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">';

            $cmtinsert .= '' . $art_comment['comment'] . '';
            $cmtinsert .= '</div>';

            $cmtinsert .= '<button id="editsubmitimgtwo' . $art_comment['post_image_comment_id'] . '" style="display:none; margin-left:15px;" onClick="edit_commentimgtwo(' . $art_comment['post_image_comment_id'] . ')">Comment</button><div class="art-comment-menu-design"> <div class="comment-details-menu" id="likecommentimg' . $art_comment['post_image_comment_id'] . '">';

            $cmtinsert .= '<a id="' . $art_comment['post_image_comment_id'] . '"';
            $cmtinsert .= 'onClick="comment_likeimgtwo(this.id)">';

            $contition_array = array('post_image_comment_id' => $art_comment['post_image_comment_id'], 'user_id' => $userid, 'is_unlike' => 0);

            $artcommentlike1 = $this->common->select_data_by_condition('art_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if (count($artcommentlike1) == 0) {
                $cmtinsert .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
            } else {

                $cmtinsert .= '<i class="fa fa-thumbs-up" aria-hidden="true"></i>';
            }

            $cmtinsert .= '<span> ';

            $contition_array = array('post_image_comment_id' => $art_comment['post_image_comment_id'], 'is_unlike' => '0');
            $mulcountlike = $this->data['mulcountlike'] = $this->common->select_data_by_condition('art_comment_image_like', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            if (count($mulcountlike) > 0) {
                //echo count($mulcountlike); 
            }
            $cmtinsert .= '</span>';
            $cmtinsert .= '</a></div>';

            $userid = $this->session->userdata('aileenuser');
            if ($art_comment['user_id'] == $userid) {

                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';


                $cmtinsert .= '<div id="editcommentboximgtwo' . $art_comment['post_image_comment_id'] . '"style="display:block;">';

                $cmtinsert .= '<a id="' . $art_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_editboximgtwo(this.id,'.$post_image_id.')">';
                $cmtinsert .= 'Edit';
                $cmtinsert .= '</a></div>';

                $cmtinsert .= '<div id="editcancleimgtwo' . $art_comment['post_image_comment_id'] . '"style="display:none;">';

                $cmtinsert .= '<a id="' . $art_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_editcancleimgtwo(this.id,'.$post_image_id.')">';
                $cmtinsert .= 'Cancel';
                $cmtinsert .= '</a></div>';

                $cmtinsert .= '</div>';
            }
            $userid = $this->session->userdata('aileenuser');


            $userid = $this->session->userdata('aileenuser');

            $art_userid = $this->db->get_where('art_post', array('art_post_id' => $art_comment['post_image_id'], 'status' => 1))->row()->user_id;


            if ($art_comment['user_id'] == $userid || $art_userid == $userid) {


                $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
                $cmtinsert .= '<div class="comment-details-menu">';


                $cmtinsert .= '<input type="hidden" name="post_deleteimgtwo"';
                // $cmtinsert .= 'id="post_deleteimg' . $art_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'id="post_deleteimgtwo"';
                $cmtinsert .= 'value= "' . $art_comment['post_image_id'] . '">';
                $cmtinsert .= '<a id="' . $art_comment['post_image_comment_id'] . '"';
                $cmtinsert .= 'onClick="comment_deleteimgtwo(this.id)">';
                $cmtinsert .= 'Delete';
                $cmtinsert .= '</a></div>';
            }

            $cmtinsert .= '<span role="presentation" aria-hidden="true"> · </span>';
            $cmtinsert .= '<div class="comment-details-menu">';
            $cmtinsert .= '<p>' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($art_comment['created_date']))) . '</p></div></div></div>';


            if (count($artcont) > 1) {
                // comment aount variable start
                $cmtcount = '<a onClick="commentallimg(this.id)" id="' . $post_image_id . '">';
                $cmtcount .= '<i class="fa fa-comment-o" aria-hidden="true">';
                $cmtcount .= ' ' . count($artcont) . '';
                $cmtcount .= '</i></a>';
            }
            // comment count variable end 
            
              $cntinsert =  '<span class="comment_count" >';
     if (count($artcont) > 0) {
           $cntinsert .= '' . count($artcont) . ''; 
           $cntinsert .=   '</span>'; 
           $cntinsert .=  '<span> Comment</span>';
        
           }
        }
        $cmtinsert .= '</div>';
        //   echo $cmtinsert;
        echo json_encode(
                array("comment" => $cmtinsert,
                    "count" => $cmtcount,
                    "commentcount" => $cntinsert
                    ));
    }

    // khyati changes end 19-5
    
    
      public function edit_more_insert() {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        $post_id = $_POST["art_post_id"];
       

       
      

            $contition_array = array('art_post_id' => $_POST["art_post_id"], 'status' => '1');
            $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            
            if ($this->data['artdata'][0]['art_description']) {
//              
                   
                    $editpostdes .= $this->data['artdata'][0]['art_description'];
            }
            //echo $editpost;   echo $editpostdes;
            echo json_encode(
                    array(
                        "description" => $editpostdes
                    ));
        
    }
  
    // chat functions start
    
     public function art_chat() {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        $loginuser = $this->common->select_data_by_id('user', 'user_id', $userid, $data = 'first_name,last_name');

        $this->data['logfname'] = $loginuser[0]['first_name'];
        $this->data['loglname'] = $loginuser[0]['last_name'];

        // last message user fetch

        $contition_array = array('id !=' => '');
        $search_condition = "(message_from = '$userid' OR message_to = '$userid')";

        $lastuser = $this->common->select_data_by_search('messages', $search_condition, $contition_array, $data = 'messages.message_from,message_to,id', $sortby = 'id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = '', $groupby = '');
        if ($lastuser[0]['message_from'] == $userid) {

            $lstusr = $this->data['lstusr'] = $lastuser[0]['message_to'];
        } else {

            $lstusr = $this->data['lstusr'] = $lastuser[0]['message_from'];
        }

// last user first name last name
        if ($lstusr) {
            $lastuser = $this->common->select_data_by_id('user', 'user_id', $lstusr, $data = 'first_name,last_name');

            $this->data['lstfname'] = $lastuser[0]['first_name'];
            $this->data['lstlname'] = $lastuser[0]['last_name'];
        }
        //khyati changes starrt 20-4
        // khyati 24-4 start 
        // slected user chat to


        $contition_array = array('is_delete' => '0', 'status' => '1');

        $join_str1[0]['table'] = 'messages';
        $join_str1[0]['join_table_id'] = 'messages.message_to';
        $join_str1[0]['from_table_id'] = 'user.user_id';
        $join_str1[0]['join_type'] = '';

        $search_condition = "((message_from = '$lstusr' OR message_to = '$lstusr') && (message_to != '$userid'))";

        $seltousr = $this->common->select_data_by_search('user', $search_condition, $contition_array, $data = 'messages.id,message_to,first_name,user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');


        // slected user chat from


        $contition_array = array('is_delete' => '0', 'status' => '1');

        $join_str2[0]['table'] = 'messages';
        $join_str2[0]['join_table_id'] = 'messages.message_from';
        $join_str2[0]['from_table_id'] = 'user.user_id';
        $join_str2[0]['join_type'] = '';



        $search_condition = "((message_from = '$lstusr' OR message_to = '$lstusr') && (message_from != '$userid'))";

        $selfromusr = $this->common->select_data_by_search('user', $search_condition, $contition_array, $data = 'messages.id,message_from,first_name,user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');


        $selectuser = array_merge($seltousr, $selfromusr);
        $selectuser = $this->aasort($selectuser, "id");


// replace name of message_to in user_id in select user

        $return_arraysel = array();
        $i = 0;
        foreach ($selectuser as $k => $sel_list) {
            $return = array();
            $return = $sel_list;

            if ($sel_list['message_to']) {

                $return['user_id'] = $sel_list['message_to'];
                $return['first_name'] = $sel_list['first_name'];
                $return['user_image'] = $sel_list['user_image'];
                $return['message'] = $sel_list['message'];

                unset($return['message_to']);
            } else {

                $return['user_id'] = $sel_list['message_from'];
                $return['first_name'] = $sel_list['first_name'];
                $return['user_image'] = $sel_list['user_image'];
                $return['message'] = $sel_list['message'];


                unset($return['message_from']);
            }
            array_push($return_arraysel, $return);
            $i++;
            if ($i == 1)
                break;
        }


        // khyati 24-4 end 
        // message to user



        $contition_array = array('is_delete' => '0', 'status' => '1', 'message_to !=' => $userid);

        $join_str3[0]['table'] = 'messages';
        $join_str3[0]['join_table_id'] = 'messages.message_to';
        $join_str3[0]['from_table_id'] = 'user.user_id';
        $join_str3[0]['join_type'] = '';

        $search_condition = "((message_from = '$userid') && (message_to != '$lstusr'))";

        $tolist = $this->common->select_data_by_search('user', $search_condition, $contition_array, $data = 'messages.id,message_to,first_name,user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str3, $groupby = '');



// uniq array of tolist  
        foreach ($tolist as $k => $v) {
            foreach ($tolist as $key => $value) {
                if ($k != $key && $v['message_to'] == $value['message_to']) {
                    unset($tolist[$k]);
                }
            }
        }

        // replace name of message_to in user_id

        $return_arrayto = array();

        foreach ($tolist as $to_list) {
            if ($to_list['message_to'] != $lstusr) {
                $return = array();
                $return = $to_list;

                $return['user_id'] = $to_list['message_to'];
                $return['first_name'] = $to_list['first_name'];
                $return['user_image'] = $to_list['user_image'];
                $return['message'] = $to_list['message'];

                unset($return['message_to']);
                array_push($return_arrayto, $return);
            }
        }

        // message from user
        $contition_array = array('is_delete' => '0', 'status' => '1', 'message_from !=' => $userid);

        $join_str4[0]['table'] = 'messages';
        $join_str4[0]['join_table_id'] = 'messages.message_from';
        $join_str4[0]['from_table_id'] = 'user.user_id';
        $join_str4[0]['join_type'] = '';

        $search_condition = "((message_to = '$userid') && (message_from != '$lstusr'))";


        $fromlist = $this->common->select_data_by_search('user', $search_condition, $contition_array, $data = 'messages.id,messages.message_from,first_name,user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str4, $groupby = '');


        // uniq array of fromlist  
        foreach ($fromlist as $k => $v) {
            foreach ($fromlist as $key => $value) {
                if ($k != $key && $v['message_from'] == $value['message_from']) {
                    unset($fromlist[$k]);
                }
            }
        }

// replace name of message_to in user_id

        $return_arrayfrom = array();

        foreach ($fromlist as $from_list) {
            if ($to_list['message_from'] != $lstusr) {
                $return = array();
                $return = $from_list;

                $return['user_id'] = $from_list['message_from'];
                $return['first_name'] = $from_list['first_name'];
                $return['user_image'] = $from_list['user_image'];
                $return['message'] = $from_list['message'];


                unset($return['message_from']);
                array_push($return_arrayfrom, $return);
            }
        }

        $userlist = array_merge($return_arrayto, $return_arrayfrom);



        // uniq array of fromlist  
        foreach ($userlist as $k => $v) {
            foreach ($userlist as $key => $value) {
                if ($k != $key && $v['user_id'] == $value['user_id']) {
                    unset($userlist[$k]);
                }
            }
        }

        $userlist = $this->aasort($userlist, "id");

        $this->data['userlist'] = array_merge($return_arraysel, $userlist);
        // khyati changes end 20-4
// smily start
        $smileys = _get_smiley_array();
        $this->data['smiley_table'] = $smileys;
// smily end
//die();
        $this->load->view('artistic/art_chat', $this->data);
    }

   public function art_chat_user($id) {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $message_from_profile_id = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $this->data['message_from_profile_id'] = $message_from_profile_id[0]['art_id'];
        $this->data['message_from_profile'] = $this->data['message_to_profile'] = 5;

        $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
        $message_to_profile_id = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $this->data['message_to_profile_id'] = $message_to_profile_id[0]['art_id'];

        // last user if $id is null
        $contition_array = array('id !=' => '');
        $search_condition = "(message_from = '$userid' OR message_to = '$userid')";
        $lastchat = $this->common->select_data_by_search('messages', $search_condition, $contition_array, $data = 'messages.message_from,message_to,id', $sortby = 'id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = '', $groupby = '');

        if ($id) {
            $toid = $this->data['toid'] = $id;
        } elseif ($lastchat[0]['message_from'] == $userid) {
            $toid = $this->data['toid'] = $lastchat[0]['message_to'];
        } else {
            $toid = $this->data['toid'] = $lastchat[0]['message_from'];
        }

        $loginuser = $this->common->select_data_by_id('user', 'user_id', $userid, $data = 'first_name,last_name');

        $this->data['logfname'] = $loginuser[0]['first_name'];
        $this->data['loglname'] = $loginuser[0]['last_name'];

        // last message user fetch
        $contition_array = array('id !=' => '');
        $search_condition = "(message_from = '$id' OR message_to = '$id')";
        $lastuser = $this->common->select_data_by_search('messages', $search_condition, $contition_array, $data = 'messages.message_from,message_to,id', $sortby = 'id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = '', $groupby = '');

        if ($lastuser[0]['message_from'] == $userid) {
            $lstusr = $this->data['lstusr'] = $lastuser[0]['message_to'];
        } else {
            $lstusr = $this->data['lstusr'] = $lastuser[0]['message_from'];
        }
        // last user first name last name

        if ($lstusr) {
            $lastuser = $this->common->select_data_by_id('user', 'user_id', $lstusr, $data = 'first_name,last_name');

            $this->data['lstfname'] = $lastuser[0]['first_name'];
            $this->data['lstlname'] = $lastuser[0]['last_name'];
        }
        // slected user chat to

        $contition_array = array('is_delete' => '0', 'status' => '1');

        $join_str1[0]['table'] = 'messages';
        $join_str1[0]['join_table_id'] = 'messages.message_to';
        $join_str1[0]['from_table_id'] = 'user.user_id';
        $join_str1[0]['join_type'] = '';

        $search_condition = "((message_from = '$id' OR message_to = '$id') && (message_to != '$userid'))";
        $seltousr = $this->common->select_data_by_search('user', $search_condition, $contition_array, $data = 'messages.id,message_to,first_name,user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');

        // slected user chat from

        $contition_array = array('is_delete' => '0', 'status' => '1');

        $join_str2[0]['table'] = 'messages';
        $join_str2[0]['join_table_id'] = 'messages.message_from';
        $join_str2[0]['from_table_id'] = 'user.user_id';
        $join_str2[0]['join_type'] = '';

        $search_condition = "((message_from = '$id' OR message_to = '$id') && (message_from != '$userid'))";
        $selfromusr = $this->common->select_data_by_search('user', $search_condition, $contition_array, $data = 'messages.id,message_from,first_name,user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');

        $selectuser = array_merge($seltousr, $selfromusr);
        $selectuser = $this->aasort($selectuser, "id");

        // replace name of message_to in user_id in select user

        $return_arraysel = array();
        $i = 0;
        foreach ($selectuser as $k => $sel_list) {
            $return = array();
            $return = $sel_list;

            if ($sel_list['message_to']) {
                if ($sel_list['message_to'] == $id) {
                    $return['user_id'] = $sel_list['message_to'];
                    $return['first_name'] = $sel_list['first_name'];
                    $return['user_image'] = $sel_list['user_image'];
                    $return['message'] = $sel_list['message'];

                    unset($return['message_to']);

                    $i++;
                    if ($i == 1)
                        break;
                }
            }else {
                if ($sel_list['message_from'] == $id) {
                    $return['user_id'] = $sel_list['message_from'];
                    $return['first_name'] = $sel_list['first_name'];
                    $return['user_image'] = $sel_list['user_image'];
                    $return['message'] = $sel_list['message'];

                    $i++;
                    if ($i == 1)
                        break;
                }

                unset($return['message_from']);
            }
        } array_push($return_arraysel, $return);

        // message to user
        $contition_array = array('is_delete' => '0', 'status' => '1', 'message_to !=' => $userid);

        $join_str3[0]['table'] = 'messages';
        $join_str3[0]['join_table_id'] = 'messages.message_to';
        $join_str3[0]['from_table_id'] = 'user.user_id';
        $join_str3[0]['join_type'] = '';

        $search_condition = "((message_from = '$userid') && (message_to != '$id'))";
        $tolist = $this->common->select_data_by_search('user', $search_condition, $contition_array, $data = 'messages.id,message_to,first_name,user_image,message', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');

        // uniq array of tolist  
        foreach ($tolist as $k => $v) {
            foreach ($tolist as $key => $value) {
                if ($k != $key && $v['message_to'] == $value['message_to']) {
                    unset($tolist[$k]);
                }
            }
        }

        // replace name of message_to in user_id

        $return_arrayto = array();
        foreach ($tolist as $to_list) {
            if ($to_list['message_to'] != $id) {
                $return = array();
                $return = $to_list;

                $return['user_id'] = $to_list['message_to'];
                $return['first_name'] = $to_list['first_name'];
                $return['user_image'] = $to_list['user_image'];
                $return['message'] = $to_list['message'];

                unset($return['message_to']);
                array_push($return_arrayto, $return);
            }
        }

        // message from user
        $contition_array = array('is_delete' => '0', 'status' => '1', 'message_from !=' => $userid);

        $join_str4[0]['table'] = 'messages';
        $join_str4[0]['join_table_id'] = 'messages.message_from';
        $join_str4[0]['from_table_id'] = 'user.user_id';
        $join_str4[0]['join_type'] = '';

        $search_condition = "((message_to = '$userid') && (message_from != '$id'))";
        $fromlist = $this->common->select_data_by_search('user', $search_condition, $contition_array, $data = 'messages.id,messages.message_from,first_name,user_image,message', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');

        // uniq array of fromlist  
        foreach ($fromlist as $k => $v) {
            foreach ($fromlist as $key => $value) {
                if ($k != $key && $v['message_from'] == $value['message_from']) {
                    unset($fromlist[$k]);
                }
            }
        }

        // replace name of message_to in user_id

        $return_arrayfrom = array();
        foreach ($fromlist as $from_list) {
            if ($from_list['message_from'] != $id) {
                $return = array();
                $return = $from_list;

                $return['user_id'] = $from_list['message_from'];
                $return['first_name'] = $from_list['first_name'];
                $return['user_image'] = $from_list['user_image'];
                $return['message'] = $from_list['message'];

                unset($return['message_from']);
                array_push($return_arrayfrom, $return);
            }
        }

        $userlist = array_merge($return_arrayto, $return_arrayfrom);

        // uniq array of fromlist  
        foreach ($userlist as $k => $v) {
            foreach ($userlist as $key => $value) {
                if ($k != $key && $v['user_id'] == $value['user_id']) {
                    if ($v['id'] < $value['id']) {
                        unset($userlist[$k]);
                    }
                }
            }
        }

        $userlist = $this->aasort($userlist, "id");

        if ($return_arraysel[0] == '') {
            $return_arraysel = array();
        }
        $this->data['userlist'] = array_merge($return_arraysel, $userlist);

// smily start
        $smileys = _get_smiley_array();
        $this->data['smiley_table'] = $smileys;
// smily end

        $this->load->view('artistic/art_chat_user', $this->data);
    }
    public function user_list($id) {
        $userid = $this->session->userdata('aileenuser');
        $usrsearchdata = trim($_POST['search_user']);

        if ($usrsearchdata != "") {
            // message to user
            $contition_array = array('is_delete' => '0', 'status' => '1', 'message_to !=' => $userid);

            $join_str5[0]['table'] = 'messages';
            $join_str5[0]['join_table_id'] = 'messages.message_to';
            $join_str5[0]['from_table_id'] = 'user.user_id';
            $join_str5[0]['join_type'] = '';


            $search_condition = "(first_name LIKE '" . trim($usrsearchdata) . "%')";

            $tolist = $this->common->select_data_by_search('user', $search_condition, $contition_array, $data = 'message_to,first_name,user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5, $groupby = '');

            // uniq array of tolist  
            foreach ($tolist as $k => $v) {
                foreach ($tolist as $key => $value) {
                    if ($k != $key && $v['message_to'] == $value['message_to']) {
                        unset($tolist[$k]);
                    }
                }
            }

            // replace name of message_to in user_id

            $return_arrayto = array();

            foreach ($tolist as $to_list) {

                $return = array();
                $return = $to_list;

                $return['user_id'] = $to_list['message_to'];
                $return['first_name'] = $to_list['first_name'];
                $return['user_image'] = $to_list['user_image'];

                unset($return['message_to']);
                array_push($return_arrayto, $return);
            }


            // message from user
            $contition_array = array('is_delete' => '0', 'status' => '1', 'message_from !=' => $userid);

            $join_str6[0]['table'] = 'messages';
            $join_str6[0]['join_table_id'] = 'messages.message_from';
            $join_str6[0]['from_table_id'] = 'user.user_id';
            $join_str6[0]['join_type'] = '';

            $search_condition = "(first_name LIKE '$usrsearchdata%')";

            $fromlist = $this->common->select_data_by_search('user', $search_condition, $contition_array, $data = 'messages.message_from,first_name,user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str6, $groupby = '');

            // uniq array of fromlist  
            foreach ($fromlist as $k => $v) {
                foreach ($fromlist as $key => $value) {
                    if ($k != $key && $v['message_from'] == $value['message_from']) {
                        unset($fromlist[$k]);
                    }
                }
            }

// replace name of message_to in user_id

            $return_arrayfrom = array();

            foreach ($fromlist as $from_list) {

                $return = array();
                $return = $from_list;

                $return['user_id'] = $from_list['message_from'];
                $return['first_name'] = $from_list['first_name'];
                $return['user_image'] = $from_list['user_image'];

                unset($return['message_from']);
                array_push($return_arrayfrom, $return);
            }

            $userlist = array_merge($return_arrayto, $return_arrayfrom);

            // uniq array of fromlist  
            foreach ($userlist as $k => $v) {
                foreach ($userlist as $key => $value) {
                    if ($k != $key && $v['user_id'] == $value['user_id']) {
                        unset($userlist[$k]);
                    }
                }
            }
            //echo '<pre>'; print_r($userlist); die();
            if ($userlist) {

                foreach ($userlist as $user) {
                    $usrsrch = '<li class="clearfix">';

                    if ($user['user_image']) {
                        $usrsrch .= ' <div class="chat_heae_img">';
                        $usrsrch .= '<img src="' . base_url($this->config->item('user_thumb_upload_path') . $user['user_image']) . '" alt="avatar" height="50px" weight="50px" />';
                        $usrsrch .= '</div>';
                    } else {
                        $usrsrch .= ' <div class="chat_heae_img">';


                       // $usrsrch .= '<img src="' . base_url(NOIMAGE) . '" alt="" height="50px" weight="50px">';


                          $a = $user['first_name'];
                          $words = explode(" ", $a);
                          foreach ($words as $w) {
                            $acronym = $w[0];
                            }
                          
                          $b = $user['last_name'];
                          $words = explode(" ", $b);
                          foreach ($words as $w) {
                            $acronym1 = $w[0];
                            }

                    $usrsrch .= '<div class="post-img-div">';
                    $usrsrch .=  ucfirst(strtolower($acronym)) . ucfirst(strtolower($acronym1)); 
                    $usrsrch .=  '</div>';


                    //$cmtinsert .= '</div>';

                        $usrsrch .= '</div>';
                    }

                    $usrsrch .= '<div class="about">';
                    $usrsrch .= '<div class="name">';
                    $usrsrch .= '<a href="' . base_url() . 'chat/abc/' . $user['user_id'] . '">' . $user['first_name'] . ' ' . $user['last_name'] . '<br></a>';
                    $usrsrch .= '</div><div class="status">Current Work</div></div></li>';
                }
            } else {

                $usrsrch .= '<div class="notac_a">No user available.. !!</div>';
            }
        } else {

            // 17-5-2017
            //$usrsrch .= '<div class="notac_a">No user available.. !!</div>';

            $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

            $loginuser = $this->common->select_data_by_id('user', 'user_id', $userid, $data = 'first_name,last_name');

            $this->data['logfname'] = $loginuser[0]['first_name'];
            $this->data['loglname'] = $loginuser[0]['last_name'];

            // last message user fetch

            $contition_array = array('id !=' => '');

            $search_condition = "(message_from = '$userid' OR message_to = '$userid')";

            $lastuser = $this->common->select_data_by_search('messages', $search_condition, $contition_array, $data = 'messages.message_from,message_to,id', $sortby = 'id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = '', $groupby = '');

            if ($lastuser[0]['message_from'] == $userid) {

                $lstusr = $this->data['lstusr'] = $lastuser[0]['message_to'];
            } else {

                $lstusr = $this->data['lstusr'] = $lastuser[0]['message_from'];
            }

// last user first name last name
            if ($lstusr) {
                $lastuser = $this->common->select_data_by_id('user', 'user_id', $lstusr, $data = 'first_name,last_name');

                $this->data['lstfname'] = $lastuser[0]['first_name'];
                $this->data['lstlname'] = $lastuser[0]['last_name'];
            }
            //khyati changes starrt 20-4
            // khyati 24-4 start 
            // slected user chat to


            $contition_array = array('is_delete' => '0', 'status' => '1');

            $join_str1[0]['table'] = 'messages';
            $join_str1[0]['join_table_id'] = 'messages.message_to';
            $join_str1[0]['from_table_id'] = 'user.user_id';
            $join_str1[0]['join_type'] = '';

            $search_condition = "((message_from = '$lstusr' OR message_to = '$lstusr') && (message_to != '$userid'))";

            $seltousr = $this->common->select_data_by_search('user', $search_condition, $contition_array, $data = 'messages.id,message_to,first_name,user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');


            // slected user chat from


            $contition_array = array('is_delete' => '0', 'status' => '1');

            $join_str2[0]['table'] = 'messages';
            $join_str2[0]['join_table_id'] = 'messages.message_from';
            $join_str2[0]['from_table_id'] = 'user.user_id';
            $join_str2[0]['join_type'] = '';



            $search_condition = "((message_from = '$lstusr' OR message_to = '$lstusr') && (message_from != '$userid'))";

            $selfromusr = $this->common->select_data_by_search('user', $search_condition, $contition_array, $data = 'messages.id,message_from,first_name,user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');


            $selectuser = array_merge($seltousr, $selfromusr);
            $selectuser = $this->aasort($selectuser, "id");


// replace name of message_to in user_id in select user

            $return_arraysel = array();
            $i = 0;
            foreach ($selectuser as $k => $sel_list) {
                $return = array();
                $return = $sel_list;

                if ($sel_list['message_to']) {

                    $return['user_id'] = $sel_list['message_to'];
                    $return['first_name'] = $sel_list['first_name'];
                    $return['user_image'] = $sel_list['user_image'];
                    $return['message'] = $sel_list['message'];

                    unset($return['message_to']);
                } else {

                    $return['user_id'] = $sel_list['message_from'];
                    $return['first_name'] = $sel_list['first_name'];
                    $return['user_image'] = $sel_list['user_image'];
                    $return['message'] = $sel_list['message'];


                    unset($return['message_from']);
                }
                array_push($return_arraysel, $return);
                $i++;
                if ($i == 1)
                    break;
            }


            // khyati 24-4 end 
            // message to user



            $contition_array = array('is_delete' => '0', 'status' => '1', 'message_to !=' => $userid);

            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to';
            $join_str3[0]['from_table_id'] = 'user.user_id';
            $join_str3[0]['join_type'] = '';

            $search_condition = "((message_from = '$userid') && (message_to != '$lstusr'))";

            $tolist = $this->common->select_data_by_search('user', $search_condition, $contition_array, $data = 'messages.id,message_to,first_name,user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str3, $groupby = '');



// uniq array of tolist  
            foreach ($tolist as $k => $v) {
                foreach ($tolist as $key => $value) {
                    if ($k != $key && $v['message_to'] == $value['message_to']) {
                        unset($tolist[$k]);
                    }
                }
            }

            // replace name of message_to in user_id

            $return_arrayto = array();

            foreach ($tolist as $to_list) {
                if ($to_list['message_to'] != $lstusr) {
                    $return = array();
                    $return = $to_list;

                    $return['user_id'] = $to_list['message_to'];
                    $return['first_name'] = $to_list['first_name'];
                    $return['user_image'] = $to_list['user_image'];
                    $return['message'] = $to_list['message'];

                    unset($return['message_to']);
                    array_push($return_arrayto, $return);
                }
            }

            // message from user
            $contition_array = array('is_delete' => '0', 'status' => '1', 'message_from !=' => $userid);

            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from';
            $join_str4[0]['from_table_id'] = 'user.user_id';
            $join_str4[0]['join_type'] = '';

            $search_condition = "((message_to = '$userid') && (message_from != '$lstusr'))";


            $fromlist = $this->common->select_data_by_search('user', $search_condition, $contition_array, $data = 'messages.id,messages.message_from,first_name,user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str4, $groupby = '');


            // uniq array of fromlist  
            foreach ($fromlist as $k => $v) {
                foreach ($fromlist as $key => $value) {
                    if ($k != $key && $v['message_from'] == $value['message_from']) {
                        unset($fromlist[$k]);
                    }
                }
            }

// replace name of message_to in user_id

            $return_arrayfrom = array();

            foreach ($fromlist as $from_list) {
                if ($to_list['message_from'] != $lstusr) {
                    $return = array();
                    $return = $from_list;

                    $return['user_id'] = $from_list['message_from'];
                    $return['first_name'] = $from_list['first_name'];
                    $return['user_image'] = $from_list['user_image'];
                    $return['message'] = $from_list['message'];


                    unset($return['message_from']);
                    array_push($return_arrayfrom, $return);
                }
            }

            $userlist = array_merge($return_arrayto, $return_arrayfrom);



            // uniq array of fromlist  
            foreach ($userlist as $k => $v) {
                foreach ($userlist as $key => $value) {
                    if ($k != $key && $v['user_id'] == $value['user_id']) {
                        unset($userlist[$k]);
                    }
                }
            }

            $userlist = $this->aasort($userlist, "id");

            $userdata = array_merge($return_arraysel, $userlist);



            if (count($userdata) > 0) {
                foreach ($userdata as $user) {
                    $usrsrch .= '<a href="' . base_url() . 'chat/abc/' . $user['user_id'] . '">';
                    $usrsrch .= '<li class="clearfix">';
                    if ($user['user_image']) {
                        $usrsrch .= '<div class="chat_heae_img">';
                        $usrsrch .= '<img src="' . base_url($this->config->item('user_thumb_upload_path') . $user['user_image']) . '" alt="" >';
                        $usrsrch .= '</div>';
                    } else {
                        $usrsrch .= '<div class="chat_heae_img">';

                       // $usrsrch .= '<img src="' . base_url(NOIMAGE) . '" alt="" >';
                          $a = $user['first_name'];
                          $words = explode(" ", $a);
                          foreach ($words as $w) {
                            $acronym = $w[0];
                            }
                          
                          $b = $user['last_name'];
                          $words = explode(" ", $b);
                          foreach ($words as $w) {
                            $acronym1 = $w[0];
                            }

                    $usrsrch .= '<div class="post-img-div">';
                    $usrsrch .=  ucfirst(strtolower($acronym)) . ucfirst(strtolower($acronym1)); 
                    $usrsrch .=  '</div>';
                    //$usrsrch .= '</div>';

                        $usrsrch .= '</div>';
                    }
                    $usrsrch .= '<div class="about">';
                    $usrsrch .= '<div class="name">';
                    $usrsrch .= '' . $user['first_name'] . ' ' . $user['last_name'] . '<br> </div>';
                    $usrsrch .= '<div class="status' . $user['user_id'] . '" style=" width: 145px;    max-height: 19px;
    color: #003;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis; ">';
                    $usrsrch .= '' . $user['message'] . '';
                    $usrsrch .= '</div>';
                    $usrsrch .= '</div>';
                    $usrsrch .= '</li>';
                    $usrsrch .= '</a>';
                }
            } else {
                $usrsrch .= 'No user available...';
            }
            // 17-5-2017 end
        }

        echo $usrsrch;
    }

    //khyati 22-4 changes start 


    public function userlisttwo($id = '') {
        $userid = $this->session->userdata('aileenuser');
        $usrsearchdata = trim($_POST['search_user']);
        $usrid = trim($_POST['user']);

        if ($usrsearchdata != "") {
            // message to user
            $contition_array = array('is_delete' => '0', 'status' => '1', 'message_to !=' => $userid);

            $join_str7[0]['table'] = 'messages';
            $join_str7[0]['join_table_id'] = 'messages.message_to';
            $join_str7[0]['from_table_id'] = 'user.user_id';
            $join_str7[0]['join_type'] = '';


            $search_condition = "((first_name LIKE '" . trim($usrsearchdata) . "%') AND (message_to !='" . $usrid . "' ))";

            $tolist = $this->common->select_data_by_search('user', $search_condition, $contition_array, $data = 'message_to,first_name,user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str7, $groupby = '');

            // uniq array of tolist  
            foreach ($tolist as $k => $v) {
                foreach ($tolist as $key => $value) {
                    if ($k != $key && $v['message_to'] == $value['message_to']) {
                        unset($tolist[$k]);
                    }
                }
            }

            // replace name of message_to in user_id

            $return_arrayto = array();

            foreach ($tolist as $to_list) {

                $return = array();
                $return = $to_list;

                $return['user_id'] = $to_list['message_to'];
                $return['first_name'] = $to_list['first_name'];
                $return['user_image'] = $to_list['user_image'];

                unset($return['message_to']);
                array_push($return_arrayto, $return);
            }


            // message from user
            $contition_array = array('is_delete' => '0', 'status' => '1', 'message_from !=' => $userid);

            $join_str[0]['table'] = 'messages';
            $join_str[0]['join_table_id'] = 'messages.message_from';
            $join_str[0]['from_table_id'] = 'user.user_id';
            $join_str[0]['join_type'] = '';

            $search_condition = "((first_name LIKE '" . trim($usrsearchdata) . "%') AND (message_from !='" . $usrid . "' ))";

            $fromlist = $this->common->select_data_by_search('user', $search_condition, $contition_array, $data = 'messages.message_from,first_name,user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

            // uniq array of fromlist  
            foreach ($fromlist as $k => $v) {
                foreach ($fromlist as $key => $value) {
                    if ($k != $key && $v['message_from'] == $value['message_from']) {
                        unset($fromlist[$k]);
                    }
                }
            }

// replace name of message_to in user_id

            $return_arrayfrom = array();

            foreach ($fromlist as $from_list) {

                $return = array();
                $return = $from_list;

                $return['user_id'] = $from_list['message_from'];
                $return['first_name'] = $from_list['first_name'];
                $return['user_image'] = $from_list['user_image'];

                unset($return['message_from']);
                array_push($return_arrayfrom, $return);
            }

            $userlist = array_merge($return_arrayto, $return_arrayfrom);

            // uniq array of fromlist  
            foreach ($userlist as $k => $v) {
                foreach ($userlist as $key => $value) {
                    if ($k != $key && $v['user_id'] == $value['user_id']) {
                        unset($userlist[$k]);
                    }
                }
            }
            //echo '<pre>'; print_r($userlist); die();
            if ($userlist) {

                foreach ($userlist as $user) {
                    $usrsrch = '<li class="clearfix">';

                    if ($user['user_image']) {
                        $usrsrch .= '    <div class="chat_heae_img">';
                        $usrsrch .= '<img src="' . base_url($this->config->item('user_thumb_upload_path') . $user['user_image']) . '" alt="avatar" height="50px" weight="50px" />';
                        $usrsrch .= '</div>';
                    } else {
                        $usrsrch .= '    <div class="chat_heae_img">';

                       
                        //$usrsrch .= '<img src="' . base_url(NOIMAGE) . '" alt="" height="50px" weight="50px">';
                          $a = $user['first_name'];
                          $words = explode(" ", $a);
                          foreach ($words as $w) {
                            $acronym = $w[0];
                            }
                          
                          $b =  $user['last_name'];
                          $words = explode(" ", $b);
                          foreach ($words as $w) {
                            $acronym1 = $w[0];
                            }

                    $usrsrch .= '<div class="post-img-div">';
                    $usrsrch .=  ucfirst(strtolower($acronym)) . ucfirst(strtolower($acronym1)); 
                    $usrsrch .=  '</div>';
                   // $cmtinsert .= '</div>';


                        $usrsrch .= '</div>';
                    }

                    $usrsrch .= '<div class="about">';
                    $usrsrch .= '<div class="name">';
                    $usrsrch .= '<a href="' . base_url() . 'chat/abc/' . $user['user_id'] . '">' . $user['first_name'] . '<br></a>';
                    $usrsrch .= '</div><div class="status">Current Work</div></div></li>';
                }
            } else {

                $usrsrch .= '<div class="notac_a">No user available.. !!</div>';
            }
        } else {

            // 17-5-2017 start
            $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

            // last user if $id is null

            $contition_array = array('id !=' => '');

            $search_condition = "(message_from = '$userid' OR message_to = '$userid')";

            $lastchat = $this->common->select_data_by_search('messages', $search_condition, $contition_array, $data = 'messages.message_from,message_to,id', $sortby = 'id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = '', $groupby = '');

            if ($id) {

                $toid = $this->data['toid'] = $id;
            } elseif ($lastchat[0]['message_from'] == $userid) {

                $toid = $this->data['toid'] = $lastchat[0]['message_to'];
            } else {

                $toid = $this->data['toid'] = $lastchat[0]['message_from'];
            }

            // khyati 22-4 changes end

            $loginuser = $this->common->select_data_by_id('user', 'user_id', $userid, $data = 'first_name,last_name');

            $this->data['logfname'] = $loginuser[0]['first_name'];
            $this->data['loglname'] = $loginuser[0]['last_name'];

            // last message user fetch

            $contition_array = array('id !=' => '');

            $search_condition = "(message_from = '$id' OR message_to = '$id')";

            $lastuser = $this->common->select_data_by_search('messages', $search_condition, $contition_array, $data = 'messages.message_from,message_to,id', $sortby = 'id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = '', $groupby = '');

            if ($lastuser[0]['message_from'] == $userid) {

                $lstusr = $this->data['lstusr'] = $lastuser[0]['message_to'];
            } else {

                $lstusr = $this->data['lstusr'] = $lastuser[0]['message_from'];
            }

// last user first name last name
            if ($lstusr) {
                $lastuser = $this->common->select_data_by_id('user', 'user_id', $lstusr, $data = 'first_name,last_name');

                $this->data['lstfname'] = $lastuser[0]['first_name'];
                $this->data['lstlname'] = $lastuser[0]['last_name'];
            }
            //khyati changes starrt 20-4
            // slected user chat to


            $contition_array = array('is_delete' => '0', 'status' => '1');

            $join_str1[0]['table'] = 'messages';
            $join_str1[0]['join_table_id'] = 'messages.message_to';
            $join_str1[0]['from_table_id'] = 'user.user_id';
            $join_str1[0]['join_type'] = '';



            $search_condition = "((message_from = '$id' OR message_to = '$id') && (message_to != '$userid'))";

            $seltousr = $this->common->select_data_by_search('user', $search_condition, $contition_array, $data = 'messages.id,message_to,first_name,user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');


            // slected user chat from


            $contition_array = array('is_delete' => '0', 'status' => '1');

            $join_str2[0]['table'] = 'messages';
            $join_str2[0]['join_table_id'] = 'messages.message_from';
            $join_str2[0]['from_table_id'] = 'user.user_id';
            $join_str2[0]['join_type'] = '';



            $search_condition = "((message_from = '$id' OR message_to = '$id') && (message_from != '$userid'))";

            $selfromusr = $this->common->select_data_by_search('user', $search_condition, $contition_array, $data = 'messages.id,message_from,first_name,user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');


            $selectuser = array_merge($seltousr, $selfromusr);
            $selectuser = $this->aasort($selectuser, "id");


// replace name of message_to in user_id in select user

            $return_arraysel = array();
            $i = 0;
            foreach ($selectuser as $k => $sel_list) {
                $return = array();
                $return = $sel_list;

                if ($sel_list['message_to']) {

                    $return['user_id'] = $sel_list['message_to'];
                    $return['first_name'] = $sel_list['first_name'];
                    $return['user_image'] = $sel_list['user_image'];
                    $return['message'] = $sel_list['message'];

                    unset($return['message_to']);
                } else {

                    $return['user_id'] = $sel_list['message_from'];
                    $return['first_name'] = $sel_list['first_name'];
                    $return['user_image'] = $sel_list['user_image'];
                    $return['message'] = $sel_list['message'];


                    unset($return['message_from']);
                }
                array_push($return_arraysel, $return);
                $i++;
                if ($i == 1)
                    break;
            }

            // message to user
            $contition_array = array('is_delete' => '0', 'status' => '1', 'message_to !=' => $userid);

            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to';
            $join_str3[0]['from_table_id'] = 'user.user_id';
            $join_str3[0]['join_type'] = '';

            $search_condition = "((message_from = '$userid') && (message_to != '$id'))";

            $tolist = $this->common->select_data_by_search('user', $search_condition, $contition_array, $data = 'messages.id,message_to,first_name,user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str3, $groupby = '');

            // uniq array of tolist  
            foreach ($tolist as $k => $v) {
                foreach ($tolist as $key => $value) {

                    if ($k != $key && $v['message_to'] == $value['message_to']) {
                        unset($tolist[$k]);
                    }
                }
            }

            // replace name of message_to in user_id

            $return_arrayto = array();

            foreach ($tolist as $to_list) {
                if ($to_list['message_to'] != $id) {
                    $return = array();
                    $return = $to_list;

                    $return['user_id'] = $to_list['message_to'];
                    $return['first_name'] = $to_list['first_name'];
                    $return['user_image'] = $to_list['user_image'];
                    $return['message'] = $to_list['message'];


                    unset($return['message_to']);
                    array_push($return_arrayto, $return);
                }
            }

            // message from user
            $contition_array = array('is_delete' => '0', 'status' => '1', 'message_from !=' => $userid);

            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from';
            $join_str4[0]['from_table_id'] = 'user.user_id';
            $join_str4[0]['join_type'] = '';

            $search_condition = "((message_to = '$userid') && (message_from != '$id'))";

            $fromlist = $this->common->select_data_by_search('user', $search_condition, $contition_array, $data = 'messages.id,messages.message_from,first_name,user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str4, $groupby = '');


            // uniq array of fromlist  
            foreach ($fromlist as $k => $v) {
                foreach ($fromlist as $key => $value) {
                    if ($k != $key && $v['message_from'] == $value['message_from']) {
                        unset($fromlist[$k]);
                    }
                }
            }

// replace name of message_to in user_id

            $return_arrayfrom = array();

            foreach ($fromlist as $from_list) {
                if ($from_list['message_from'] != $id) {
                    $return = array();
                    $return = $from_list;

                    $return['user_id'] = $from_list['message_from'];
                    $return['first_name'] = $from_list['first_name'];
                    $return['user_image'] = $from_list['user_image'];
                    $return['message'] = $from_list['message'];


                    unset($return['message_from']);
                    array_push($return_arrayfrom, $return);
                }
            }



            $userlist = array_merge($return_arrayto, $return_arrayfrom);


            // uniq array of fromlist  
            foreach ($userlist as $k => $v) {
                foreach ($userlist as $key => $value) {
                    if ($k != $key && $v['user_id'] == $value['user_id']) {
                        unset($userlist[$k]);
                    }
                }
            }


            $userlist = $this->aasort($userlist, "id");

            $userlist = array_merge($return_arraysel, $userlist);
            //echo '<pre>'; print_r($userlist); die();
            if (in_array($toid, $userlist)) {
                foreach ($userlist as $user) {
                    $usrsrch .= '<li class="clearfix">';
                    if ($user['user_id'] == $toid) {
                        $usrsrch .= 'active';
                    }
                    $usrsrch .= '">';
                    if ($user['user_image']) {
                        $usrsrch .= '<div class="chat_heae_img">';
                        $usrsrch .= '<img src="' . base_url($this->config->item('user_thumb_upload_path') . $user['user_image']) . '" alt="" height="50px" weight="50px">';
                        $usrsrch .= '</div>';
                    } else {

                        $usrsrch .= '<div class="chat_heae_img">';


                        //$usrsrch .= '<img src="' . base_url(NOIMAGE) . '" alt="" height="30px" weight="30px">';

                          $a = $user['first_name'];
                          $words = explode(" ", $a);
                          foreach ($words as $w) {
                            $acronym = $w[0];
                            }
                          
                          $b = $user['last_name'];
                          $words = explode(" ", $b);
                          foreach ($words as $w) {
                            $acronym1 = $w[0];
                            }

                    $usrsrch .= '<div class="post-img-div">';
                    $usrsrch .=  ucfirst(strtolower($acronym)) . ucfirst(strtolower($acronym1)); 
                    $usrsrch .=  '</div>';
                    //$cmtinsert .= '</div>';

                        $usrsrch .= '</div>';
                    }
                    $usrsrch .= '<div class="about">';
                    $usrsrch .= '<div class="name">';
                    $usrsrch .= '<a href="' . base_url() . 'chat/abc/' . $user['user_id'] . '">' . $user['first_name'] . ' ' . $user['last_name'] . '<br></a> </div>';
                    $usrsrch .= '<div class="status' . $user['user_id'] . '" style=" width: 145px;    max-height: 25px;
    color: #003;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
">';
                    $usrsrch .= '' . $user['message'] . '';
                    $usrsrch .= '</div>';
                    $usrsrch .= '</div>';
                    $usrsrch .= '</li>';
                }
            } else {

                $lstusrdata = $this->common->select_data_by_id('user', 'user_id', $toid, $data = '*');


                if ($lstusrdata) {

                    $usrsrch .= '<li class="clearfix ';
                    if ($lstusrdata[0]['user_id'] == $toid) {
                        $usrsrch .= 'active';
                    } $usrsrch .= '">';
                    if ($lstusrdata[0]['user_image']) {
                        $usrsrch .= '<div class="chat_heae_img">';
                        $usrsrch .= '<img src="' . base_url($this->config->item('user_thumb_upload_path') . $lstusrdata[0]['user_image']) . '" alt="" height="50px" weight="50px">';
                        $usrsrch .= '</div>';
                    } else {
                        $usrsrch .= '<div class="chat_heae_img">';

                          $a = $lstusrdata[0]['first_name'];
                          $words = explode(" ", $a);
                          foreach ($words as $w) {
                            $acronym = $w[0];
                            }
                          
                          $b = $lstusrdata[0]['last_name'];
                          $words = explode(" ", $b);
                          foreach ($words as $w) {
                            $acronym1 = $w[0];
                            }

                    $usrsrch .= '<div class="post-img-div">';
                    $usrsrch .=  ucfirst(strtolower($acronym)) . ucfirst(strtolower($acronym1)); 
                    $usrsrch .=  '</div>';
                    //$cmtinsert .= '</div>';
                       // $usrsrch .= '<img src="' . base_url(NOIMAGE) . '" alt="" height="50px" weight="50px">';

                        $usrsrch .= '</div>';
                    }
                    $usrsrch .= '<div class="about">';
                    $usrsrch .= '<div class="name">';
                    $usrsrch .= '<a href="' . base_url() . 'chat/abc/' . $lstusrdata[0]['user_id'] . '">' . $lstusrdata[0]['first_name'] . ' ' . $lstusrdata[0]['last_name'] . '<br></a> </div>';
                    $usrsrch .= '<div class="status' . $lstusrdata[0]['user_id'] . '" style=" width: 145px;    max-height: 25px;
    color: #003;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
">';
                    $search_condition = "((message_from = '$userid' AND message_to = '$toid') OR (message_to = '$userid' AND message_from = '$toid'))";
                    $contition_array = array('id !=' => '');
                    $messages = $this->common->select_data_by_search('messages', $search_condition, $contition_array, $data = '*', $sortby = 'id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = '', $groupby = '');


                    $usrsrch .= '' . $messages[0]['message'] . '';

                    $usrsrch .= '</div>
          </div>
        </li>';
                }
                foreach ($userlist as $user) {
                    if ($user['user_id'] != $toid) {

                        $usrsrch .= '<a href="' . base_url() . 'chat/abc/' . $user['user_id'] . '">';
                        $usrsrch .= '<li class="clearfix">';
                        if ($user['user_id'] == $toid) {
                            $usrsrch .= 'class ="active"';
                        }
                        if ($user['user_image']) {
                            $usrsrch .= '<div class="chat_heae_img">';
                            $usrsrch .= '<img src="' . base_url($this->config->item('user_thumb_upload_path') . $user['user_image']) . '" alt="" height="50px" weight="50px">';
                            $usrsrch .= '</div>';
                        } else {
                            $usrsrch .= '<div class="chat_heae_img">';


                            //$usrsrch .= '<img src="' . base_url(NOIMAGE) . '" alt="" height="50px" weight="50px">';

                            $a = $user['first_name'];
                          $words = explode(" ", $a);
                          foreach ($words as $w) {
                            $acronym = $w[0];
                            }
                          
                          $b = $user['last_name'];
                          $words = explode(" ", $b);
                          foreach ($words as $w) {
                            $acronym1 = $w[0];
                            }

                    $usrsrch .= '<div class="post-img-div">';
                    $usrsrch .=  ucfirst(strtolower($acronym)) . ucfirst(strtolower($acronym1)); 
                    $usrsrch .=  '</div>';

                        $usrsrch .= '</div>';
                        }
                        $usrsrch .= '<div class="about">';
                        $usrsrch .= '<div class="name">';
                        $usrsrch .= '' . $user['first_name'] . ' ' . $user['last_name'] . '<br></div>';
                        $usrsrch .= '<div class="status' . $user['user_id'] . '" style=" width: 145px;
    color: #003;    max-height: 25px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
">';
                        $usrsrch .= '' . $user['message'] . '';
                        $usrsrch .= '</div>';
                        $usrsrch .= '</div>';
                        $usrsrch .= '</li></a>';
                    }
                }
            }
            // 17-5-2017 end
        }

        echo $usrsrch;
    }

    //khyati 22-4 changes end 
    //  sort an array start
    // khyati changes start 7-4
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


// userlist fatch using ajax start



     public function art_home_three_user_listold() {

        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

        // GET BUSINESS DATA
        $contition_array = array('user_id' => $userid, 'status' => '1');
        $artdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_name,art_lastname,art_user_image,profile_background,art_skill,art_city,art_state', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $art_profile_id = $artdata[0]['art_id'];

        // GET USER LIST IN LEFT SIDE
        $contition_array = array('is_delete' => 0, 'status' => 1, 'user_id !=' => $userid, 'art_step' => 4);
        $userlist = $userlist = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_name,art_lastname,art_user_image,art_skill,art_city,art_state', $sortby = 'art_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        // GET INDUSTRIAL WISE DATA
       $likeuserarray = explode(',', $artdata[0]['art_skill']);

        foreach ($userlist as $rowcategory) {

            $userlistarray = explode(',', $rowcategory['art_skill']);

            if (array_intersect($likeuserarray, $userlistarray)) {
                $userlistcategory[] = $rowcategory;
            }
        }
        $userlistview1 = $userlistcategory;
        // GET INDUSTRIAL WISE DATA
        // GET CITY WISE DATA
        $artregcity = $artdata[0]['art_city'];

        foreach ($userlist2 as $rowcity) {

        $userlistarray1 = explode(',', $rowcity['art_skill']);
            if (array_intersect($likeuserarray, $userlistarray1)) {
                
            } else {

                if ($artregcity == $rowcity['art_city']) {
                    $userlistcity[] = $rowcity;
                }
            }
        }
        $userlistview2 = $userlistcity;
        // GET CITY WISE DATA
        // GET STATE WISE DATA
        $artregstate = $artdata[0]['art_state'];
        $contition_array = array('is_delete' => 0, 'status' => 1, 'user_id !=' => $userid, 'art_city !=' => $artregcity,'art_step' => 4);
        $userlist3 = $this->common->select_data_by_condition('art_reg', $contition_array, $data ='*', $sortby = 'art_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        foreach ($userlist3 as $rowstate) {
             $userlistarray2 = explode(',', $rowstate['art_skill']);
            if (array_intersect($likeuserarray, $userlistarray2)) {
                
            } else {

                if ($artregstate == $rowstate['art_state']) {
                    $userliststate[] = $rowstate;
                }
            }
        }
        $userlistview3 = $userliststate;
        // GET STATE WISE DATA
        // GET 3 USER
         $contition_array = array('is_delete' => 0, 'status' => 1, 'user_id !=' => $userid, 'art_city !=' => $artregcity, 'art_state !=' => $artregstate , 'art_step' => 4);
        $userlastview = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = 'art_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

       $userlistarray4 = explode(',', $userlastview['art_skill']);
        if (array_intersect($likeuserarray, $userlistarray4)) {
            
        } else {
            $userlistview4 = $userlastview;
        }

        $return_html = '';
        $return_html .= '<ul>';
        if ($userlistview1 > 0) {
            foreach ($userlistview1 as $userlist) {
                $userid = $this->session->userdata('aileenuser');
                 $userid = $this->session->userdata('aileenuser');
                              
                                      $followfrom = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->art_id;
                              
                              
                                      $contition_array = array('follow_to' => $userlist['art_id'], 'follow_from' => $followfrom, 'follow_status' => '1', 'follow_type' => '1');
                                      $artfollow = $this->data['artfollow'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
               
                if (!$artfollow) {

                    $return_html .= '<li class="follow_box_ul_li fad' . $userlist['art_id'] . '" id="fad' . $userlist['art_id'] . '">
                                                <div class="contact-frnd-post follow_left_main_box"><div class="profile-job-post-title-inside clearfix">
                                                                    <div class=" col-md-12 follow_left_box_main">                   
                                                                        <div class="post-design-pro-img_follow">';
                    if ($userlist['art_user_image']) {

                        $return_html .= '<a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucfirst(strtolower($userlist['art_name'])) . ucfirst(strtolower($userlist['art_lastname'])) . '">';

                        if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $userlist['art_user_image'])) {
                                                                $a = $userlist['art_name'];
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userlist['art_lastname'];
                                                                $bcr = substr($b, 0, 1);

                                  $return_html .= '<div class="post-img-div">';
                                  $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                  $return_html .= '</div>'; 

                                    }else{

                        $return_html .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $userlist['art_user_image'] . '"  alt="">';

                        }
                        $return_html .= '</a>';


                    } else {
                        $return_html .= '<a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucwords($userlist['art_name']) . '">';
                                                                                    
                                                                $a = $userlist['art_name'];
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userlist['art_lastname'];
                                                                $bcr = substr($b, 0, 1);

                                  $return_html .= '<div class="post-img-div">';
                                  $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                  $return_html .= '</div>'; 

                         $return_html .= '</a>';
                    }
                    $return_html .= '</div>
                                                                        <div class="post-design-name_follow fl">
                                                                            <ul>
                                                                                <li>
                                                                                    <div class="post-design-product_follow">';
                    $return_html .= '<a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucfirst(strtolower($userlist['art_name'])) . ucfirst(strtolower($userlist['art_lastname'])) .'">
                                                <h6>' . ucfirst(strtolower($userlist['art_name'])) . ucfirst(strtolower($userlist['art_lastname'])) . '</h6>
                                                                                        </a> 
                                                                                    </div>
                                                                                </li>';
                    
                    $return_html .= '<li>
                                                                                    <div class="post-design-product_follow_main" style="display:block;">
                                                                                        <a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucfirst(strtolower($userlist['art_name'])) .' '. ucfirst(strtolower($userlist['art_lastname'])) . '">
                                                                                            <p>';
                    if ($userlist['designation']) {
                        $return_html .= $userlist['designation'];
                    } else {
                        $return_html .= 'Current Work';
                    }

                    $return_html .= '</p>
                                                                                        </a>
                                                                                    </div>
                                                                                </li>
                                                                            </ul> 
                                                                        </div>  
                                                                        <div class="follow_left_box_main_btn">';
                    $return_html .= '<div class="fr' . $userlist['art_id'] . '">
                                                                                <button id="followdiv' . $userlist['art_id'] . '" onClick="followuser(' . $userlist['art_id'] . ')"><span>Follow</span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <span class="Follow_close" onClick="followclose(' . $userlist['art_id'] . ')">
                                                                            <i class="fa fa-times" aria-hidden="true">
                                                                            </i>
                                                                        </span>
                                                                    </div>
                                                                </div></div></li>';
                }
            }
        }
        if ($userlistview2 > 0) {
            foreach ($userlistview2 as $userlist) {
                $userid = $this->session->userdata('aileenuser');
                $followfrom = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->art_id;
                              
                              
                $contition_array = array('follow_to' => $userlist['art_id'], 'follow_from' => $followfrom, 'follow_status' => '1', 'follow_type' => '1');
                $artfollow = $this->data['artfollow'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                              
                if (!$artfollow) {
                    $return_html .= '<li class="follow_box_ul_li">
                                                <div class="contact-frnd-post follow_left_main_box"><div class="profile-job-post-title-inside clearfix">
                                                                    <div class="col-md-12 follow_left_box_main" id="fad' . $userlist['art_id'] . '">                   
                                                                        <div class="post-design-pro-img_follow">';
                    if ($userlist['art_user_image']) {
                        $return_html .= '<a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucfirst(strtolower($userlist['art_name'])).' '. ucfirst(strtolower($userlist['art_lastname'])) . '">';

                        if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $userlist['art_user_image'])) {
                                                                $a = $userlist['art_name'];
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userlist['art_lastname'];
                                                                $bcr = substr($b, 0, 1);


                                $return_html .= '<div class="post-img-div">';

                                $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                              $return_html .= '</div>';

                            }else{                          

                        $return_html .= '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $userlist['art_user_image'] . '"  alt="">';
                        }

                        $return_html .= '</a>';


                    } else {
                        $return_html .= '<a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucfirst(strtolower($userlist['art_name'])).' ' .ucfirst(strtolower($userlist['art_lastname'])) . '">';
                                                                $a = $userlist['art_name'];
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userlist['art_lastname'];
                                                                $bcr = substr($b, 0, 1);


                              $return_html .= '<div class="post-img-div">';

                              $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                              $return_html .= '</div>';

                              $return_html .=  '</a>';
                    }
                    $return_html .= '</div>';
                    $return_html .= '<div class="post-design-name_follow fl">
                                                                            <ul>
                                                                                <li>
                                                                                    <div class="post-design-product_follow">
                                                                                        <a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucfirst(strtolower($userlist['art_name'])).' '.ucfirst(strtolower($userlist['art_lastname'])) . '">
                                                                                            <h6>' .ucfirst(strtolower($userlist['art_name'])).' ' .ucfirst(strtolower($userlist['art_lastname'])) .'</h6>
                                                                                        </a> 
                                                                                    </div>
                                                                                </li>';
                   
                    $return_html .= '<li>
                                                                                    <div class="post-design-product_follow_main" style="display:block;">
                                                                                        <a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucfirst(strtolower($userlist['art_name'])).' ' .ucfirst(strtolower($userlist['art_lastname'])) .'">
                                                                                            <p>';
                    if ($userlist['designation']) {
                        $return_html .= $userlist['designation'];
                    } else {
                        $return_html .= 'Current Work';
                    }

                    $return_html .= '</p>
                                                                                        </a>
                                                                                    </div>
                                                                                </li>
                                                                            </ul> 
                                                                        </div>  
                                                                        <div class="follow_left_box_main_btn">
                                                                            <div class="fr' . $userlist['art_id'] . '">
                                                                                <button id="followdiv' . $userlist['art_id'] . '" onClick="followuser(' . $userlist['art_id'] . ')"><span>Follow</span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <span class="Follow_close" onClick="followclose(' . $userlist['art_id'] . ')">
                                                                            <i class="fa fa-times" aria-hidden="true">
                                                                            </i>
                                                                        </span>
                                                                    </div>
                                                                </div></div></li>';
                }
            }
        }
        if ($userlistview3 > 0) {
            foreach ($userlistview3 as $userlist) {
                $userid = $this->session->userdata('aileenuser');
                 $followfrom = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->art_id;
                              
                              
                $contition_array = array('follow_to' => $userlist['art_id'], 'follow_from' => $followfrom, 'follow_status' => '1', 'follow_type' => '1');
                $artfollow = $this->data['artfollow'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if (!$artfollow) {

                    $return_html .= '<li class="follow_box_ul_li">
                                                <div class="contact-frnd-post follow_left_main_box"><div class="profile-job-post-title-inside clearfix">
                                                                    <div class="col-md-12 follow_left_box_main" id="fad' . $userlist['art_id'] . '">                   
                                                                        <div class="post-design-pro-img_follow">
                                                                            <a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '">';
                    if ($userlist['art_user_image'] != '') {

                        if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $userlist['art_user_image'])) {
                                                                $a = $userlist['art_name'];
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userlist['art_lastname'];
                                                                $bcr = substr($b, 0, 1);
                                     $return_html .= '<div class="post-img-div">';
                                    $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                    $return_html .= '</div>';

                            }else{
                        $return_html .= '<img  src="' .ART_PROFILE_THUMB_UPLOAD_URL . $userlist['art_user_image'] . '"  alt="">';

                            }

                    } else {
                        $a = $userlist['art_name'];
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userlist['art_lastname'];
                                                                $bcr = substr($b, 0, 1);
                                     $return_html .= '<div class="post-img-div">';
                                    $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                    $return_html .= '</div>';
                    }
                    $return_html .= '</a>
                                                                        </div>
                                                                        <div class="post-design-name_follow fl">
                                                                            <ul>
                                                                                <li>
                                                                                    <div class="post-design-product_follow">
                                                                                        <a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '">
                                                                                            <h6>' . ucwords($userlist['art_name']) .' '.ucwords($userlist['art_lastname']) .'</h6>
                                                                                        </a> 
                                                                                    </div>
                                                                                </li>';
                   
                    $return_html .= '<li>
                                                                                    <div class="post-design-product_follow_main" style="display:block;">
                                                                                        <a><p>';
                    if ($userlist['designation']) {
                        $return_html .= $userlist['designation'];
                    } else {
                        $return_html .= 'Current Work';
                    }
                    $return_html .= '</p>
                                                                                        </a>
                                                                                    </div>
                                                                                </li>
                                                                            </ul> 
                                                                        </div>  
                                                                        <div class="follow_left_box_main_btn">
                                                                            <div class="fr' . $userlist['art_id'] . '">
                                                                                <button id="followdiv' . $userlist['art_id'] . '" onClick="followuser(' . $userlist['art_id'] . ')"><span>Follow</span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <span class="Follow_close" onClick="followclose(' . $userlist['art_id'] . ')">
                                                                            <i class="fa fa-times" aria-hidden="true">
                                                                            </i>
                                                                        </span>
                                                                    </div>
                                                                </div></div></li>';
                }
            }
        }
        if ($userlistview4 > 0) {
            foreach ($userlistview4 as $userlist) {
                $userid = $this->session->userdata('aileenuser');
                 $followfrom = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->art_id;
                              
                              
                $contition_array = array('follow_to' => $userlist['art_id'], 'follow_from' => $followfrom, 'follow_status' => '1', 'follow_type' => '1');
                $artfollow = $this->data['artfollow'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if (!$artfollow) {

                    $return_html .= '<li class="follow_box_ul_li">
                                                <div class="contact-frnd-post follow_left_main_box"><div class="profile-job-post-title-inside clearfix">
                                                                    <div class=" col-md-12 follow_left_box_main" id="fad' . $userlist['art_id'] . '">                   
                                                                        <div class="post-design-pro-img_follow">';
                    if ($userlist['art_user_image']) {
                        $return_html .= '<a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucwords($userlist['art_name']) .' '. ucwords($userlist['art_lastname']) . '">';
                    if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $userlist['art_user_image'])) {       
                                                                $a = $userlist['art_name'];
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userlist['art_lastname'];
                                                                $bcr = substr($b, 0, 1);
                                     $return_html .= '<div class="post-img-div">';
                                    $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                    $return_html .= '</div>';
                                }else{
                          $return_html .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $userlist['art_user_image'] . '"  alt="">';
                              }

                            $return_html .= '</a>';

                    } else {
                        $return_html .= '<a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucwords($userlist['art_name']) . ' ' .ucwords($userlist['art_lastname']) . '">';
                                                                $a = $userlist['art_name'];
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userlist['art_lastname'];
                                                                $bcr = substr($b, 0, 1);
                                     $return_html .= '<div class="post-img-div">';
                                    $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                    $return_html .= '</div>';
                                   $return_html .= '</a>';
                    }
                    $return_html .= '</div>
                                                                        <div class="post-design-name_follow fl">
                                                                            <ul>
                                                                                <li>
                                                                                    <div class="post-design-product_follow">
                                                                                        <a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '">
                                                                                            <h6>' . ucfirst(strtolower($userlist['art_name'])).' ' . ucfirst(strtolower($userlist['art_lastname'])) .'</h6>
                                                                                        </a> 
                                                                                    </div>
                                                                                </li>';
                  
                    $return_html .= '<li>
                                                                                    <div class="post-design-product_follow_main" style="display:block;">
                                                                                        <a><p>';
                    if ($userlist['designation']) {
                        $return_html .= $userlist['designation'];
                    } else {
                        $return_html .= 'Current Work';
                    }

                    $return_html .= '</p>
                                                                                        </a>
                                                                                    </div>
                                                                                </li>
                                                                            </ul> 
                                                                        </div>  
                                                                        <div class="follow_left_box_main_btn">
                                                                            <div class="fr' . $userlist['art_id'] . '">
                                                                                <button id="followdiv' . $userlist['art_id'] . '" onClick="followuser(' . $userlist['art_id'] . ')"><span>Follow</span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <span class="Follow_close" onClick="followclose(' . $userlist['art_id'] . ')">
                                                                            <i class="fa fa-times" aria-hidden="true">
                                                                            </i>
                                                                        </span>
                                                                    </div>
                                                                </div></div></li>';
                }
            }
        }

        $return_html .= '</ul>';


        echo $return_html;
    }



 public function art_home_cellphone_user_list() {

        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

        // GET BUSINESS DATA
        $contition_array = array('user_id' => $userid, 'status' => '1');
        $artdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_name,art_lastname,art_user_image,profile_background,art_skill,art_city,art_state', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $art_profile_id = $artdata[0]['art_id'];

        // GET USER LIST IN LEFT SIDE
        $contition_array = array('is_delete' => 0, 'status' => 1, 'user_id !=' => $userid, 'art_step' => 4);
        $userlist = $userlist = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_name,art_lastname,art_user_image,art_skill,art_city,art_state', $sortby = 'art_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        // GET INDUSTRIAL WISE DATA
       $likeuserarray = explode(',', $artdata[0]['art_skill']);

        foreach ($userlist as $rowcategory) {

            $userlistarray = explode(',', $rowcategory['art_skill']);

            if (array_intersect($likeuserarray, $userlistarray)) {
                $userlistcategory[] = $rowcategory;
            }
        }
        $userlistview1 = $userlistcategory;
        // GET INDUSTRIAL WISE DATA
        // GET CITY WISE DATA
        $artregcity = $artdata[0]['art_city'];

        foreach ($userlist2 as $rowcity) {

        $userlistarray1 = explode(',', $rowcity['art_skill']);
            if (array_intersect($likeuserarray, $userlistarray1)) {
                
            } else {

                if ($artregcity == $rowcity['art_city']) {
                    $userlistcity[] = $rowcity;
                }
            }
        }
        $userlistview2 = $userlistcity;
        // GET CITY WISE DATA
        // GET STATE WISE DATA
        $artregstate = $artdata[0]['art_state'];
        $contition_array = array('is_delete' => 0, 'status' => 1, 'user_id !=' => $userid, 'art_city !=' => $artregcity,'art_step' => 4);
        $userlist3 = $this->common->select_data_by_condition('art_reg', $contition_array, $data ='*', $sortby = 'art_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        foreach ($userlist3 as $rowstate) {
             $userlistarray2 = explode(',', $rowstate['art_skill']);
            if (array_intersect($likeuserarray, $userlistarray2)) {
                
            } else {

                if ($artregstate == $rowstate['art_state']) {
                    $userliststate[] = $rowstate;
                }
            }
        }
        $userlistview3 = $userliststate;
        // GET STATE WISE DATA
        // GET 3 USER
         $contition_array = array('is_delete' => 0, 'status' => 1, 'user_id !=' => $userid, 'art_city !=' => $artregcity, 'art_state !=' => $artregstate , 'art_step' => 4);
        $userlastview = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = 'art_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

       $userlistarray4 = explode(',', $userlastview['art_skill']);
        if (array_intersect($likeuserarray, $userlistarray4)) {
            
        } else {
            $userlistview4 = $userlastview;
        }

        $return_html = '';
        $return_html .= '<ul>';
        if ($userlistview1 > 0) {
            foreach ($userlistview1 as $userlist) {
                $userid = $this->session->userdata('aileenuser');
                 $userid = $this->session->userdata('aileenuser');
                              
                                      $followfrom = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->art_id;
                              
                              
                                      $contition_array = array('follow_to' => $userlist['art_id'], 'follow_from' => $followfrom, 'follow_status' => '1', 'follow_type' => '1');
                                      $artfollow = $this->data['artfollow'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
               
                if (!$artfollow) {

                    $return_html .= '<li class="follow_box_ul_li">
                                                <div class="contact-frnd-post follow_left_main_box"><div class="profile-job-post-title-inside clearfix">
                                                                    <div class=" col-md-12 follow_left_box_main" id="fadcell' . $userlist['art_id'] . '">                   
                                                                        <div class="post-design-pro-img_follow">';
                    if ($userlist['art_user_image']) {

                        $return_html .= '<a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucfirst(strtolower($userlist['art_name'])) . ucfirst(strtolower($userlist['art_lastname'])) . '">';

                        if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $userlist['art_user_image'])) {
                                                                $a = $userlist['art_name'];
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userlist['art_lastname'];
                                                                $bcr = substr($b, 0, 1);

                                  $return_html .= '<div class="post-img-div">';
                                  $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                  $return_html .= '</div>'; 

                                    }else{

                        $return_html .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $userlist['art_user_image'] . '"  alt="">';

                        }
                        $return_html .= '</a>';


                    } else {
                        $return_html .= '<a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucwords($userlist['art_name']) . '">';
                                                                                    
                                                                $a = $userlist['art_name'];
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userlist['art_lastname'];
                                                                $bcr = substr($b, 0, 1);

                                  $return_html .= '<div class="post-img-div">';
                                  $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                  $return_html .= '</div>'; 

                         $return_html .= '</a>';
                    }
                    $return_html .= '</div>
                                                                        <div class="post-design-name_follow fl">
                                                                            <ul>
                                                                                <li>
                                                                                    <div class="post-design-product_follow">';
                    $return_html .= '<a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucfirst(strtolower($userlist['art_name'])) . ucfirst(strtolower($userlist['art_lastname'])) .'">
                                                <h6>' . ucfirst(strtolower($userlist['art_name'])) . ucfirst(strtolower($userlist['art_lastname'])) . '</h6>
                                                                                        </a> 
                                                                                    </div>
                                                                                </li>';
                    
                    $return_html .= '<li>
                                                                                    <div class="post-design-product_follow_main" style="display:block;">
                                                                                        <a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucfirst(strtolower($userlist['art_name'])) .' '. ucfirst(strtolower($userlist['art_lastname'])) . '">
                                                                                            <p>';
                    if ($userlist['designation']) {
                        $return_html .= $userlist['designation'];
                    } else {
                        $return_html .= 'Current Work';
                    }

                    $return_html .= '</p>
                                                                                        </a>
                                                                                    </div>
                                                                                </li>
                                                                            </ul> 
                                                                        </div>  
                                                                        <div class="follow_left_box_main_btn">';
                    $return_html .= '<div class="fr' . $userlist['art_id'] . '">
                                                                                <button id="followdiv' . $userlist['art_id'] . '" onClick="followusercell(' . $userlist['art_id'] . ')"><span>Follow</span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <span class="Follow_close" onClick="followclosecell(' . $userlist['art_id'] . ')">
                                                                            <i class="fa fa-times" aria-hidden="true">
                                                                            </i>
                                                                        </span>
                                                                    </div>
                                                                </div></div></li>';
                }
            }
        }
        if ($userlistview2 > 0) {
            foreach ($userlistview2 as $userlist) {
                $userid = $this->session->userdata('aileenuser');
                $followfrom = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->art_id;
                              
                              
                $contition_array = array('follow_to' => $userlist['art_id'], 'follow_from' => $followfrom, 'follow_status' => '1', 'follow_type' => '1');
                $artfollow = $this->data['artfollow'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                              
                if (!$artfollow) {
                    $return_html .= '<li class="follow_box_ul_li">
                                                <div class="contact-frnd-post follow_left_main_box"><div class="profile-job-post-title-inside clearfix">
                                                                    <div class="col-md-12 follow_left_box_main" id="fadcell' . $userlist['art_id'] . '">                   
                                                                        <div class="post-design-pro-img_follow">';
                    if ($userlist['art_user_image']) {
                        $return_html .= '<a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucfirst(strtolower($userlist['art_name'])).' '. ucfirst(strtolower($userlist['art_lastname'])) . '">';

                        if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $userlist['art_user_image'])) {
                                                                $a = $userlist['art_name'];
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userlist['art_lastname'];
                                                                $bcr = substr($b, 0, 1);


                                $return_html .= '<div class="post-img-div">';

                                $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                              $return_html .= '</div>';

                            }else{                          

                        $return_html .= '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $userlist['art_user_image'] . '"  alt="">';
                        }

                        $return_html .= '</a>';


                    } else {
                        $return_html .= '<a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucfirst(strtolower($userlist['art_name'])).' ' .ucfirst(strtolower($userlist['art_lastname'])) . '">';
                                                                $a = $userlist['art_name'];
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userlist['art_lastname'];
                                                                $bcr = substr($b, 0, 1);


                              $return_html .= '<div class="post-img-div">';

                              $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                              $return_html .= '</div>';

                              $return_html .=  '</a>';
                    }
                    $return_html .= '</div>';
                    $return_html .= '<div class="post-design-name_follow fl">
                                                                            <ul>
                                                                                <li>
                                                                                    <div class="post-design-product_follow">
                                                                                        <a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucfirst(strtolower($userlist['art_name'])).' '.ucfirst(strtolower($userlist['art_lastname'])) . '">
                                                                                            <h6>' .ucfirst(strtolower($userlist['art_name'])).' ' .ucfirst(strtolower($userlist['art_lastname'])) .'</h6>
                                                                                        </a> 
                                                                                    </div>
                                                                                </li>';
                   
                    $return_html .= '<li>
                                                                                    <div class="post-design-product_follow_main" style="display:block;">
                                                                                        <a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucfirst(strtolower($userlist['art_name'])).' ' .ucfirst(strtolower($userlist['art_lastname'])) .'">
                                                                                            <p>';
                    if ($userlist['designation']) {
                        $return_html .= $userlist['designation'];
                    } else {
                        $return_html .= 'Current Work';
                    }

                    $return_html .= '</p>
                                                                                        </a>
                                                                                    </div>
                                                                                </li>
                                                                            </ul> 
                                                                        </div>  
                                                                        <div class="follow_left_box_main_btn">
                                                                            <div class="fr' . $userlist['art_id'] . '">
                                                                                <button id="followdiv' . $userlist['art_id'] . '" onClick="followusercell(' . $userlist['art_id'] . ')"><span>Follow</span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <span class="Follow_close" onClick="followclosecell(' . $userlist['art_id'] . ')">
                                                                            <i class="fa fa-times" aria-hidden="true">
                                                                            </i>
                                                                        </span>
                                                                    </div>
                                                                </div></div></li>';
                }
            }
        }
        if ($userlistview3 > 0) {
            foreach ($userlistview3 as $userlist) {
                $userid = $this->session->userdata('aileenuser');
                 $followfrom = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->art_id;
                              
                              
                $contition_array = array('follow_to' => $userlist['art_id'], 'follow_from' => $followfrom, 'follow_status' => '1', 'follow_type' => '1');
                $artfollow = $this->data['artfollow'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if (!$artfollow) {

                    $return_html .= '<li class="follow_box_ul_li">
                                                <div class="contact-frnd-post follow_left_main_box"><div class="profile-job-post-title-inside clearfix">
                                                                    <div class="col-md-12 follow_left_box_main" id="fadcell' . $userlist['art_id'] . '">                   
                                                                        <div class="post-design-pro-img_follow">
                                                                            <a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '">';
                    if ($userlist['art_user_image'] != '') {

                        if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $userlist['art_user_image'])) {
                                                                $a = $userlist['art_name'];
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userlist['art_lastname'];
                                                                $bcr = substr($b, 0, 1);
                                     $return_html .= '<div class="post-img-div">';
                                    $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                    $return_html .= '</div>';

                            }else{
                        $return_html .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $userlist['art_user_image'] . '"  alt="">';

                            }

                    } else {
                        $a = $userlist['art_name'];
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userlist['art_lastname'];
                                                                $bcr = substr($b, 0, 1);
                                     $return_html .= '<div class="post-img-div">';
                                    $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                    $return_html .= '</div>';
                    }
                    $return_html .= '</a>
                                                                        </div>
                                                                        <div class="post-design-name_follow fl">
                                                                            <ul>
                                                                                <li>
                                                                                    <div class="post-design-product_follow">
                                                                                        <a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '">
                                                                                            <h6>' . ucwords($userlist['art_name']) .' '.ucwords($userlist['art_lastname']) .'</h6>
                                                                                        </a> 
                                                                                    </div>
                                                                                </li>';
                   
                    $return_html .= '<li>
                                                                                    <div class="post-design-product_follow_main" style="display:block;">
                                                                                        <a><p>';
                    if ($userlist['designation']) {
                        $return_html .= $userlist['designation'];
                    } else {
                        $return_html .= 'Current Work';
                    }
                    $return_html .= '</p>
                                                                                        </a>
                                                                                    </div>
                                                                                </li>
                                                                            </ul> 
                                                                        </div>  
                                                                        <div class="follow_left_box_main_btn">
                                                                            <div class="fr' . $userlist['art_id'] . '">
                                                                                <button id="followdiv' . $userlist['art_id'] . '" onClick="followusercell(' . $userlist['art_id'] . ')"><span>Follow</span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <span class="Follow_close" onClick="followclosecell(' . $userlist['art_id'] . ')">
                                                                            <i class="fa fa-times" aria-hidden="true">
                                                                            </i>
                                                                        </span>
                                                                    </div>
                                                                </div></div></li>';
                }
            }
        }
        if ($userlistview4 > 0) {
            foreach ($userlistview4 as $userlist) {
                $userid = $this->session->userdata('aileenuser');
                 $followfrom = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->art_id;
                              
                              
                $contition_array = array('follow_to' => $userlist['art_id'], 'follow_from' => $followfrom, 'follow_status' => '1', 'follow_type' => '1');
                $artfollow = $this->data['artfollow'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if (!$artfollow) {

                    $return_html .= '<li class="follow_box_ul_li">
                                                <div class="contact-frnd-post follow_left_main_box"><div class="profile-job-post-title-inside clearfix">
                                                                    <div class=" col-md-12 follow_left_box_main" id="fadcell' . $userlist['art_id'] . '">                   
                                                                        <div class="post-design-pro-img_follow">';
                    if ($userlist['art_user_image']) {
                        $return_html .= '<a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucwords($userlist['art_name']) .' '. ucwords($userlist['art_lastname']) . '">';
                    if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $userlist['art_user_image'])) {       
                                                                $a = $userlist['art_name'];
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userlist['art_lastname'];
                                                                $bcr = substr($b, 0, 1);
                                     $return_html .= '<div class="post-img-div">';
                                    $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                    $return_html .= '</div>';
                                }else{
                          $return_html .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $userlist['art_user_image'] . '"  alt="">';
                              }

                            $return_html .= '</a>';

                    } else {
                        $return_html .= '<a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucwords($userlist['art_name']) . ' ' .ucwords($userlist['art_lastname']) . '">';
                                                                $a = $userlist['art_name'];
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userlist['art_lastname'];
                                                                $bcr = substr($b, 0, 1);
                                     $return_html .= '<div class="post-img-div">';
                                    $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                    $return_html .= '</div>';
                                   $return_html .= '</a>';
                    }
                    $return_html .= '</div>
                                                                        <div class="post-design-name_follow fl">
                                                                            <ul>
                                                                                <li>
                                                                                    <div class="post-design-product_follow">
                                                                                        <a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '">
                                                                                            <h6>' . ucfirst(strtolower($userlist['art_name'])).' ' . ucfirst(strtolower($userlist['art_lastname'])) .'</h6>
                                                                                        </a> 
                                                                                    </div>
                                                                                </li>';
                  
                    $return_html .= '<li>
                                                                                    <div class="post-design-product_follow_main" style="display:block;">
                                                                                        <a><p>';
                    if ($userlist['designation']) {
                        $return_html .= $userlist['designation'];
                    } else {
                        $return_html .= 'Current Work';
                    }

                    $return_html .= '</p>
                                                                                        </a>
                                                                                    </div>
                                                                                </li>
                                                                            </ul> 
                                                                        </div>  
                                                                        <div class="follow_left_box_main_btn">
                                                                            <div class="fr' . $userlist['art_id'] . '">
                                                                                <button id="followdiv' . $userlist['art_id'] . '" onClick="followusercell(' . $userlist['art_id'] . ')"><span>Follow</span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <span class="Follow_close" onClick="followclosecell(' . $userlist['art_id'] . ')">
                                                                            <i class="fa fa-times" aria-hidden="true">
                                                                            </i>
                                                                        </span>
                                                                    </div>
                                                                </div></div></li>';
                }
            }
        }

        $return_html .= '</ul>';


        echo $return_html;
    }

public function art_home_three_user_list() {

        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

        // GET USER BUSINESS DATA START
        $contition_array = array('user_id' => $userid, 'status' => '1');
        $artisticdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_name,art_lastname,art_user_image,art_skill,art_city,art_state, slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

       $art_id = $artisticdata[0]['art_id'];
        $art_skill = $artisticdata[0]['art_skill'];
        $city = $artisticdata[0]['art_city'];
       $state = $artisticdata[0]['art_state'];
      
        // GET USER ARTISTIC DATA END
        // GET ARTISTIC USER FOLLOWING LIST START
        $contition_array = array('follow_from' => $art_id, 'follow_status' => 1, 'follow_type' => 1);
        $followdata = $this->common->select_data_by_condition('follow', $contition_array, $data = 'GROUP_CONCAT(follow_to) as follow_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = 'follow_from');
        $follow_list = $followdata[0]['follow_list'];
        $follow_list = str_replace(",", "','", $followdata[0]['follow_list']);
        // GET ARTISTIC USER FOLLOWING LIST END
        // GET ARTISTIC USER IGNORE LIST START
        $contition_array = array('user_from' => $art_id, 'profile' => 1);
        $userdata = $this->common->select_data_by_condition('user_ignore', $contition_array, $data = 'GROUP_CONCAT(user_to) as user_list', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = 'user_from');
        $user_list = $followdata[0]['user_list'];
        $user_list = str_replace(",", "','", $userdata[0]['user_list']);
        // GET ARTISTIC USER IGNORE LIST END
        //GET ARTISTIC USER SUGGESTED USER LIST 
        $contition_array = array('is_delete' => 0, 'status' => 1, 'user_id != ' => $userid, 'art_step' => 4);
//        $search_condition = "((art_skill IN ('$art_skill')) OR (art_city = '$city') OR (art_state = '$state')) AND art_id NOT IN ('$follow_list') AND art_id NOT IN ('$user_list')";
        $search_condition = "art_id NOT IN ('$follow_list') AND art_id NOT IN ('$user_list')";
        $userlistview = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = 'art_id, art_name, art_lastname, art_user_image, art_skill, art_city, art_state, user_id, slug', $sortby =' CASE WHEN (art_city = ' . $city . ') THEN art_id END, CASE WHEN (art_state = ' . $state . ') THEN art_id END', $orderby = 'DESC', $limit = '3', $offset = '', $join_str_contact = array(), $groupby = '');
//echo '<pre>'; print_r($userlistview); die();
        $return_html = '';
        $return_html .= '<ul class="home_three_follow_ul">';
        if (count($userlistview) > 0) {
            foreach ($userlistview as $userlist) {
                $userid = $this->session->userdata('aileenuser');
                $followfrom = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->art_id;
                $contition_array = array('follow_to' => $userlist['art_id'], 'follow_from' => $followfrom, 'follow_status' => '1', 'follow_type' => '1');
                $artfollow = $this->data['artfollow'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '1', $offset = '', $join_str = array(), $groupby = '');
              
                if (!$artfollow) {

  $return_html .= '<li class="follow_box_ul_li fad' . $userlist['art_id'] . '" id = "fad' . $userlist['art_id'] . '">
                                                <div class="contact-frnd-post follow_left_main_box"><div class="profile-job-post-title-inside clearfix">
                                                                    <div class=" col-md-12 follow_left_box_main" id="fad' . $userlist['art_id'] . '">                   
                                                                        <div class="post-design-pro-img_follow">';
                    if ($userlist['art_user_image']) {

                        $return_html .= '<a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucfirst(strtolower($userlist['art_name'])) . ' '.ucfirst(strtolower($userlist['art_lastname'])) . '">';

                        if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $userlist['art_user_image'])) {
                                                                $a = $userlist['art_name'];
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userlist['art_lastname'];
                                                                $bcr = substr($b, 0, 1);

                                  $return_html .= '<div class="post-img-div">';
                                  $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                  $return_html .= '</div>'; 

                                    }else{

                        $return_html .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $userlist['art_user_image'] . '"  alt="">';

                        }
                        $return_html .= '</a>';

                    } else {
                        $return_html .= '<a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucwords($userlist['art_name']) . '">';
                                                                                    
                                                                $a = $userlist['art_name'];
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userlist['art_lastname'];
                                                                $bcr = substr($b, 0, 1);

                                  $return_html .= '<div class="post-img-div">';
                                  $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                  $return_html .= '</div>'; 

                         $return_html .= '</a>';
                    }
                    $return_html .= '</div>
                                <div class="post-design-name_follow fl">
                                     <ul><li>
                                    <div class="post-design-product_follow">';
                    $return_html .= '<a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucfirst(strtolower($userlist['art_name'])) .' ' .ucfirst(strtolower($userlist['art_lastname'])) .'">
                            <h6>' . ucfirst(strtolower($userlist['art_name'])) .' ' . ucfirst(strtolower($userlist['art_lastname'])) . '</h6>
                            </a> 
                            </div>
                        </li>';
                    
                    $return_html .= '<li>
                        <div class="post-design-product_follow_main" style="display:block;">
                           <a href="' . base_url('artistic/dashboard/' . $userlist['slug']) . '" title="' . ucfirst(strtolower($userlist['art_name'])) .' '. ucfirst(strtolower($userlist['art_lastname'])) . '">
                    <p>';
                    if ($userlist['designation']) {
                        $return_html .= $userlist['designation'];
                    } else {
                        $return_html .= 'Current Work';
                    }

                    $return_html .= '</p>
                                     </a>
                                    </div>
                                    </li>
                                    </ul> 
                                    </div>  
                            <div class="follow_left_box_main_btn">';
                    $return_html .= '<div class="fr' . $userlist['art_id'] . '">
                            <button id="followdiv' . $userlist['art_id'] . '" onClick="followuser(' . $userlist['art_id'] . ')"><span>Follow</span>
                            </button>
                            </div>
                            </div>
                            <span class="Follow_close" onClick="followclose(' . $userlist['art_id'] . ')">
                            <i class="fa fa-times" aria-hidden="true">
                            </i>
                        </span>
                        </div>
                </div></div></li>';
                }
            }
        }
        echo $return_html;
    }

// userlist fatch using aajx end


// all post fatch using aajx start


public function art_home_post() {
        // return html

        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;

        //$page_id = $_POST['page'];

        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

       $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($artistic_deactive) {
            redirect('artistic/');
        }
       


         $contition_array = array('user_id' => $userid, 'status' => '1');
        $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($this->data['artisticdata']); die();
        $artregid = $this->data['artisticdata'][0]['art_id'];


        $contition_array = array('follow_from' => $artregid, 'follow_status' => '1', 'follow_type' => '1');
        $followerdata = $this->data['followerdata'] = $this->common->select_data_by_condition('follow', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        foreach ($followerdata as $fdata) {

            $contition_array = array('art_id' => $fdata['follow_to'], 'art_step' => 4);
            $this->data['art_data'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $art_userid = $this->data['art_data'][0]['user_id'];

            $contition_array = array('user_id' => $art_userid, 'status' => '1', 'is_delete' => '0');
            $this->data['art_data'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $followerabc[] = $this->data['art_data'];
        }

        $userselectskill = $this->data['artisticdata'][0]['art_skill'];

         $contition_array = array('art_skill' => $userselectskill, 'status' => '1' , 'art_step' => 4);
        $skilldata = $this->data['skilldata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        foreach ($skilldata as $fdata) {
            $contition_array = array('art_post.user_id' => $fdata['user_id'], 'art_post.status' => '1', 'art_post.user_id !=' => $userid, 'art_post.is_delete' => '0');

             $this->data['art_data'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $skillabc[] = $this->data['art_data'];
        }

        $contition_array = array('art_post.user_id' => $userid, 'art_post.status' => '1', 'art_post.is_delete' => '0');
        $art_userdata = $this->data['art_userdata'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = 'art_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if (count($art_userdata) > 0) {
            $userabc[] = $this->data['art_userdata'];
        } else {
            $userabc[] = $this->data['art_userdata'];
        }

       // echo "<pre>"; print_r($userabc); die();

        if (count($skillabc) == 0 && count($userabc) != 0) {
            $unique = $userabc;
        } elseif (count($userabc) == 0 && count($skillabc) != 0) {
            $unique = $skillabc;
        } elseif (count($userabc) != 0 && count($skillabc) != 0) {
            $unique = array_merge($skillabc, $userabc);
        }

        if (count($followerabc) == 0 && count($unique) != 0) {
            $unique_user = $unique;
        } elseif (count($unique) == 0 && count($followerabc) != 0) {

            $unique_user = $followerabc;
        } elseif (count($unique) != 0 && count($followerabc) != 0) {
            $unique_user = array_merge($unique, $followerabc);
        }

        foreach ($unique_user as $key1 => $val1) {
            foreach ($val1 as $ke => $va) {

                $qbc[] = $va;
            }
        }


        $qbc = array_unique($qbc, SORT_REGULAR);
        $post = array();

        //$i =0;
        foreach ($qbc as $key => $row) {
            $post[$key] = $row['art_post_id'];
            //  $qbc[$i]['created_date'] = $this->time_elapsed_string(date('Y-m-d H:i:s', strtotime($row['created_date'])));
            //$i++;
        }
       
        array_multisort($post, SORT_DESC, $qbc);
        $finalsorting = $qbc;
        $return_html = '';
        //echo "<pre>"; print_r($finalsorting); die();

        $finalsorting1 = array_slice($finalsorting, $start, $perpage);


        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($finalsorting);
        }

        $return_html .= '<input type = "hidden" class = "page_number" value = "' . $page . '" />';
        $return_html .= '<input type = "hidden" class = "total_record" value = "' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';

       // echo count($finalsorting1);  echo count($finalsorting); die();

        if (count($finalsorting) > 0) {
            //$row = $businessprofiledatapost[0];

            foreach ($finalsorting1 as $row) {
                $userid = $this->session->userdata('aileenuser');
                $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1');
                $artdelete = $this->data['artdelete'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $contition_array = array('user_id' => $row['user_id'], 'status' => '1');
                $artdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $likeuserarray = explode(',', $artdelete[0]['delete_post']);


                if (!in_array($userid, $likeuserarray)) {

                    $return_html .= '<div id="removepost' . $row['art_post_id'] . '">
                    <div class="col-md-12 col-sm-12 post-design-box">
                        <div  class="post_radius_box">  
                            <div class="post-design-top col-md-12" >  
                                <div class="post-design-pro-img">';

                    $art_userimage = $this->db->get_where('art_reg', array('user_id' => $row['user_id'], 'status' => 1))->row()->art_user_image;
                    $userimageposted = $this->db->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->art_user_image;

                     $userfn = $this->db->get_where('art_reg', array('user_id' => $row['user_id'], 'status' => 1))->row()->art_name;
                        $userln = $this->db->get_where('art_reg', array('user_id' => $row['user_id'], 'status' => 1))->row()->art_lastname;
                        $slug = $this->db->get_where('art_reg', array('user_id' => $row['user_id'], 'status' => 1))->row()->slug;
                      

                        $userimagefn = $this->db->get_where('art_reg', array('user_id' => $row['posted_user_id'], 'status' => 1))->row()->art_name;
                        $userimageln = $this->db->get_where('art_reg', array('user_id' => $row['posted_user_id'], 'status' => 1))->row()->art_lastname;
                        $userslug = $this->db->get_where('art_reg', array('user_id' => $row['posted_user_id'], 'status' => 1))->row()->slug;


                    
                    if ($row['posted_user_id']) {

                        if ($userimageposted) {
                            $return_html .= '<a href="' . base_url('artistic/dashboard/' . $userslug) . '">';

                            if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $userimageposted)) {
                                                                $a = $userimagefn;
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userimageln;
                                                                $bcr = substr($b, 0, 1);
                                                                
                            $return_html .= '<div class="post-img-div">';
                            $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)) ;
                            $return_html .= '</div>'; 

                                                            } else { 

                            $return_html .=  '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $userimageposted . '" name="image_src" id="image_src" />';
                            }
                            $return_html .=  '</a>';

                        } else {

                            $return_html .= '<a href="' . base_url('artistic/dashboard/' . $userslug) . '">';

                                                                $a = $userimagefn;
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userimageln;
                                                                $bcr = substr($b, 0, 1);
                                                                
                            $return_html .= '<div class="post-img-div">';
                            $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)) ;
                            $return_html .= '</div>'; 

                           $return_html .= '</a>';
                        }
                    } else {
                        if ($art_userimage) {
                            $return_html .= '<a href="' . base_url('artistic/dashboard/' . $slug) . '">';

                            if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                                                                $a = $userfn;
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userln;
                                                                $bcr = substr($b, 0, 1);
                                                               
                                $return_html .= '<div class="post-img-div">';
                                $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                $return_html .= '</div>'; 
                                                                
                                                            } else { 

                           $return_html .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage . '"  alt="">';

                            }
                            $return_html .= '</a>';
                        } else {
                            $return_html .= '<a href="' . base_url('artistic/dashboard/' . $slug) . '">';
                                                $a = $userfn;
                                                                $acr = substr($a, 0, 1);
                                                                $b = $userln;
                                                                $bcr = substr($b, 0, 1);
                                                               
                                $return_html .= '<div class="post-img-div">';
                                $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                $return_html .= '</div>'; 
                                           $return_html .=  '</a>';
                        }
                    }
                    $return_html .= '</div>
                                <div class="post-design-name fl col-xs-8 col-md-10">
                                    <ul>';
                    $firstname = $this->db->get_where('art_reg', array('user_id' => $row['user_id']))->row()->art_name;
                           
                    $lastname = $this->db->get_where('art_reg', array('user_id' => $row['user_id']))->row()->art_lastname;

                     $slug = $this->db->get_where('art_reg', array('user_id' => $row['user_id']))->row()->slug;

                    $firstnameposted = $this->db->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->art_name;
                    $lastnameposted = $this->db->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->art_lastname;

                   
                   $designation = $this->db->get_where('art_reg', array('user_id' => $row['user_id']))->row()->designation;
                           
                           
                    $userskill = $this->db->get_where('art_reg', array('user_id' => $row['user_id']))->row()->art_skill;
                           
                           
                           $aud = $userskill;
                           $aud_res = explode(',', $aud);
                           foreach ($aud_res as $skill) {
                           
                               $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;
                               $skill1[] = $cache_time;
                           }
                           $listFinal = implode(', ', $skill1);


                    $firstnameposted = $this->db->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->art_name;
                    $lastnameposted = $this->db->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->art_lastname;

                    $slugposted = $this->db->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->slug;


                    $return_html .= '<li>
                                        </li>';
                    if ($row['posted_user_id']) {
                        $return_html .= '<li>
                                                <div class="else_post_d">
                                                    <div class="post-design-product">
                                                        <a class="post_dot" href="' . base_url('artistic/dashboard/' . $slugposted) . '">' . ucfirst(strtolower($firstnameposted)) .' '. ucfirst(strtolower($lastnameposted)) . '</a>
                                                        <p class="posted_with" > Posted With</p> <a class="post_dot1 padding_less_left"  href="' . base_url('artistic/dashboard/' . $slug) . '">' . ucfirst(strtolower($firstname)) .' '. ucfirst(strtolower($lastname)) . '</a>
                                                        <span role="presentation" aria-hidden="true"> · </span> <span class="ctre_date">
                                        ' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($row['created_date']))) . '  
                                                        </span> </div></div>
                                            </li>';
                        $category = $this->db->get_where('industry_type', array('industry_id' => $businessdata[0]['industriyal'], 'status' => 1))->row()->industry_name;
                    } else {
                        $return_html .= '<li>
                                                <div class="post-design-product">
                                                    <a class="post_dot"  href="' . base_url('artistic/dashboard/' . $slug) . '" title="' . ucfirst(strtolower($firstname)) .' '. ucfirst(strtolower($lastname)) . '">
                    ' . ucfirst(strtolower($firstname)) .' '.ucfirst(strtolower($lastname)). '</a>
                                                    <span role="presentation" aria-hidden="true"> · </span>
                                                    <div class="datespan"> <span class="ctre_date" > 
                    ' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($row['created_date']))) . '

                                                        </span></div>

                                                </div>
                                            </li>';
                    }
                   


                    $return_html .= '<li>
                                            <div class="post-design-product">
                                                <a class="buuis_desc_a" href="javascript:void(0);"  title="Category">';
                    if ($designation) {
                        $return_html .= ucwords($designation);
                    } else {
                        $return_html .= 'Current Work';
                    }

                    $return_html .= '</a>
                                            </div>
                                        </li>

                                        <li>
                                        </li> 
                                    </ul> 
                                </div>  
                                <div class="dropdown2">
                                    <a  onClick="myFunction1(' . $row['art_post_id'] . ')" class=" dropbtn2 fa fa-ellipsis-v">
                                    </a>
                                    <div id="myDropdown' . $row['art_post_id'] . '" class="dropdown-content2 ">';

                    if ($row['posted_user_id'] != 0) {

                        if ($this->session->userdata('aileenuser') == $row['posted_user_id']) {

                            $return_html .= '<a onclick="deleteownpostmodel(' . $row['art_post_id'] . ')">
                                                    <span class="h4-img h2-srrt">
                                                    </span> Delete Post
                                                </a>
                                                <a id="' . $row['art_post_id'] . '" onClick="editpost(this.id)">
                                                    <span class="h3-img h2-srrt">
                                                    </span>Edit
                                                </a>';
                        } else {

                            $return_html .= '<a onclick="deleteownpostmodel(' . $row['art_post_id'] . ')">
                                                    <span class="h4-img h2-srrt">
                                                    </span> Delete Post
                                                </a>';
                                                // <a href="' . base_url('artistic/artistic_contactperson/' . $row['posted_user_id']) . '">
                                                //     <span class="h2-img h2-srrt">
                                                //     </span> Contact Person </a>';
                        }
                    } else {
                        if ($this->session->userdata('aileenuser') == $row['user_id']) {
                            $return_html .= '<a onclick="deleteownpostmodel(' . $row['art_post_id'] . ')">
                                                    <span class="h4-img h2-srrt"></span> Delete Post
                                                </a>
                                                <a id="' . $row['art_post_id'] . '" onClick="editpost(this.id)">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true">
                                                    </i>Edit
                                                </a>';
                        } else {
                            $return_html .= '<a onclick="deletepostmodel(' . $row['art_post_id'] . ')">
                                                    <span class="h4-img h2-srrt">
                                                    </span> Delete Post
                                                </a>';

                                                // <a href="' . base_url('artistic/artistic_contactperson/' . $row['user_id']) . '">
                                                //     <span class="h2-img h2-srrt"></span>Contact Person
                                                // </a>';
                        }
                    }

                    $return_html .= '</div>
                                </div>
                                <div class="post-design-desc">
                                    <div class="ft-15 t_artd">
                                        <div id="editpostdata' . $row['art_post_id'] . '" style="display:block;">
                                            <a id="editpostval' . $row['art_post_id'].'">' . $this->common->make_links($row['art_post']) . '</a>
                                        </div>
                                        <div id="editpostbox' . $row['art_post_id'] . '" style="display:none;">
                                            
                                            
                                            <input type="text" class="my_text" id="editpostname' . $row['art_post_id'] . '" name="editpostname" placeholder="Product Name" value="' . $row['art_post'] . '" onKeyDown=check_lengthedit('.$row['art_post_id'].'); onKeyup=check_lengthedit('.$row['art_post_id'].'); onblur=check_lengthedit('.$row['art_post_id'].');>';

                                             if ($row['art_post']) {
                                                                            $counter = $row['art_post'];
                                                                            $a = strlen($counter);

                                      $return_html .= '<input size=1 id="text_num" class="text_num" tabindex="-500" value="'.(50 - $a).'" name=text_num disabled="disabled">';

                                      } else {
                                       $return_html .= '<input size=1 id="text_num" class="text_num" tabindex="-501" value=50 name=text_num disabled="disabled">';

                                         } 
                                       $return_html .= '</div>

                                    </div>                    
                                    <div id="khyati' . $row['art_post_id'] . '" style="display:block;">';

                                       $num_words = 29;
                                       $words = array();
                                       $words = explode(" ",  $row['art_description'], $num_words);
                                       $shown_string = "";
                                       
                                       if(count($words) == 29){
                                       $words[28] ='... <span id="kkkk" onClick="khdiv(' . $row['art_post_id'] . ')">View More</span>';
                                       }
                                       
                                       $shown_string = implode(" ", $words);
                                       $return_html .= $this->common->make_links($shown_string);


                    // $small = substr($row['art_description'], 0, 180);
                    // $return_html .= $this->common->make_links($small);
                    // if (strlen($row['art_description']) > 180) {
                    //     $return_html .= '... <span id="kkkk" onClick="khdiv(' . $row['art_post_id'] . ')">View More</span>';
                    // }

                    $return_html .= '</div>
                                    <div id="khyatii' . $row['art_post_id'] . '" style="display:none;">
                                        ' . $this->common->make_links($row['art_description']) . '</div>
                                    <div id="editpostdetailbox' . $row['art_post_id'] . '" style="display:none;">
                                        <div  contenteditable="true" id="editpostdesc' . $row['art_post_id'] . '"  class="textbuis editable_text margin_btm" name="editpostdesc" placeholder="Description" onpaste="OnPaste_StripFormatting(this, event);" onfocus="return cursorpointer(' . $row['art_post_id'] . ');">' . $row['art_description'] . '</div>
                                    </div>
                                    
                                    <button class="fr" id="editpostsubmit' . $row['art_post_id'] . '" style="display:none; margin-right: 5px; border-radius: 3px;" onClick="edit_postinsert(' . $row['art_post_id'] . ')">Save
                                    </button>
                                </div> 
                            </div>
                            <div class="post-design-mid col-md-12" >
                                <div>';

                    $contition_array = array('post_id' => $row['art_post_id'], 'is_deleted' => '1', 'insert_profile' => '1');
                    $artmultiimage = $this->data['artmultiimage'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    if (count($artmultiimage) == 1) {

                        $allowed = array('jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg');
                        $allowespdf = array('pdf');
                        $allowesvideo = array('mp4', 'webm', 'MP4');
                        $allowesaudio = array('mp3');
                        $filename = $artmultiimage[0]['file_name'];
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                        if (in_array($ext, $allowed)) {

                            $return_html .= '<div class="one-image">';
                            $return_html .= '<a href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '">
                                                    <img src = "' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '">

                                                </a>
                                            </div>';
                        } elseif (in_array($ext, $allowespdf)) {
                            $return_html .= '<div><a href="'.base_url($this->config->item('art_post_main_upload_path') . $artmultiimage[0]['file_name']).'">

                            <a href="'.base_url($this->config->item('art_post_main_upload_path') . $artmultiimage[0]['file_name']).'">

                                               <div class="pdf_img">

                                                         <embed src="' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '" width="100%" height="450px" />
                                                    </div>
                                                </a>
                                            </div>';
                        } elseif (in_array($ext, $allowesvideo)) {
                            $return_html .= '<div>
                                                <video width="100%" height="350" controls>

                                             
                                                <source src="' . base_url($this->config->item('art_post_main_upload_path') . $artmultiimage[0]['file_name']) . '" type="video/mp4">
                                                    <source src="' . base_url($this->config->item('art_post_main_upload_path') . $artmultiimage[0]['file_name']) . '" type="video/ogg">

                                                    
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>';

                                               // <source src = "' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '" type = "video/mp4">
                                               //  <source src = "' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '" type = "video/ogg">

                        } elseif (in_array($ext, $allowesaudio)) {
                            $return_html .= '<div class="audio_main_div">
                                                <div class="audio_img">
                                                    <img src="' . base_url('images/music-icon.png') . '">  
                                                </div>
                                                <div class="audio_source">
                                                    <audio controls>
                                                    <source src = "' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '" type = "audio/mp3">

                                                        <source src="movie.ogg" type="audio/ogg">
                                                        Your browser does not support the audio tag.
                                                    </audio>
                                                </div></div>';
                                                // <div class="audio_mp3" id="'."postname" . $row['art_post_id'].'">
                                                //     <p title="'.$row['art_post'].'">'.$row['art_post'].'</p>
                                                // </div>
                                            
                        }
                    } elseif (count($artmultiimage) == 2) {

                        foreach ($artmultiimage as $multiimage) {

                            $return_html .= '<div  class="two-images">
                                                <a href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '">

                                                <img class = "two-columns" src = "' . ART_POST_RESIZE1_UPLOAD_URL . $multiimage['file_name'] . '">
                                                </a>
                                            </div>';
                        }
                    } elseif (count($artmultiimage) == 3) {
                        // $return_html .= '<div class="three-image-top" >
                        //                     <a href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '">

                        //                         <img class="three-columns" src="' . base_url($this->config->item('art_post_thumb_upload_path') . $artmultiimage[0]['file_name']) . '"> 
                        //                     </a>
                        //                 </div>
                        //                 <div class="three-image" >

                        //                     <a href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '">
                        //                         <img class="three-columns" src="' . base_url($this->config->item('art_post_thumb_upload_path') . $artmultiimage[1]['file_name']) . '"> 
                        //                     </a>
                        //                 </div>
                        //                 <div class="three-image" >
                        //                     <a href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '">
                        //                         <img class="three-columns" src="' . base_url($this->config->item('art_post_thumb_upload_path') . $artmultiimage[2]['file_name']) . '"> 
                        //                     </a>
                        //                 </div>';

                                         $return_html .= '<div class = "three-image-top" >
<a href = "' . base_url('artistic/post-detail/' . $row['art_post_id']) . '">
<img class = "three-columns" src = "' . ART_POST_RESIZE4_UPLOAD_URL . $artmultiimage[0]['file_name'] . '">
</a>
</div>
<div class = "three-image" >

<a href = "' . base_url('artistic/post-detail/' . $row['business_profile_post_id']) . '">
<img class = "three-columns" src = "' . ART_POST_RESIZE1_UPLOAD_URL . $artmultiimage[1]['file_name'] . '">
</a>
</div>
<div class = "three-image" >
<a href = "' . base_url('artistic/post-detail/' . $row['business_profile_post_id']) . '">
<img class = "three-columns" src = "' . ART_POST_RESIZE1_UPLOAD_URL . $artmultiimage[2]['file_name'] . '">
</a>
</div>';
                    } elseif (count($artmultiimage) == 4) {

                        foreach ($artmultiimage as $multiimage) {

                            $return_html .= '<div class="four-image">
                                                <a href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '">
                                                    <img class = "breakpoint" src = "' . ART_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name'] . '">
                                                </a>
                                            </div>';
                        }
                    } elseif (count($artmultiimage) > 4) {

                        $i = 0;
                        foreach ($artmultiimage as $multiimage) {

                            $return_html .= '<div class="four-image">
                                                <a href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '">
                                                   
                                                    <img src = "' . ART_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name'] . '">
                                                </a>
                                            </div>';

                            $i++;
                            if ($i == 3)
                                break;
                        }

                        $return_html .= '<div class="four-image">
                                            <a href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '">
                                                
                                            <img src = "' . ART_POST_RESIZE2_UPLOAD_URL . $artmultiimage[3]['file_name'] . '">

                                            </a>
                                            <a class="text-center" href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '" >
                                                <div class="more-image" >
                                                    <span>View All (+
                     ' . (count($artmultiimage) - 4) . ')</span>

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
                                    <ul class="col-md-6">
                                        <li class="likepost' . $row['art_post_id'] . '">
                                            <a id="' . $row['art_post_id'] . '" class="ripple like_h_w"  onClick="post_like(this.id)">';

                    $userid = $this->session->userdata('aileenuser');
                    $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1');
                    $artlike = $this->data['artlike'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    $likeuserarray = explode(',', $artlike[0]['art_like_user']);
                    if (!in_array($userid, $likeuserarray)) {

                        $return_html .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
                    } else {
                        $return_html .= '<i class="fa fa-thumbs-up fa-1x main_color" aria-hidden="true"></i>';
                    }
                    $return_html .= '<span>';

                   // if ($row['art_likes_count'] > 0) {
                        //$return_html .= $row['art_likes_count'];
                    //}

                    $return_html .= '</span>
                                            </a>
                                        </li>
                                        <li id="insertcount' . $row['art_post_id'] . '" style="visibility:show">';

                     $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1', 'is_delete' => '0');
                    $commnetcount = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $return_html .= '<a onClick = "commentall(this.id)" id = "' . $row['art_post_id'] . '" class = "ripple like_h_w">
                    <i class = "fa fa-comment-o" aria-hidden = "true">
                    </i>
                    </a>
                    </li>
                    </ul>
                    <ul class = "col-md-6 like_cmnt_count">
                    <li>
                    <div class = "like_cmmt_space comnt_count_ext_a like_count_ext'.$row['art_post_id'].'">
                    <span class = "comment_count">';

                    if (count($commnetcount) > 0) {
                        $return_html .= count($commnetcount);
                        $return_html .= '<span> Comment</span>';
                    }
                    $return_html .= '</span> 

                    </div>
                    </li>

                    <li>
                        <div class="comnt_count_ext_a  comnt_count_ext'. $row['art_post_id'].'">
                            <span class="comment_like_count">';
                    if ($row['art_likes_count'] > 0) {
                        $return_html .= $row['art_likes_count'];

                        $return_html .= '<span> Like</span>';
                    }
                    $return_html .= '</span> 

                        </div></li>
                    </ul>
                    </div>
                    </div>';

                    if ($row['art_likes_count'] > 0) {

                        $return_html .= '<div class="likeduserlist' . $row['art_post_id'] . '">';

                        $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1', 'is_delete' => '0');
                        $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                        $likeuser = $commnetcount[0]['art_like_user'];
                        $countlike = $commnetcount[0]['art_likes_count'] - 1;
                        $likelistarray = explode(',', $likeuser);

                        foreach ($likelistarray as $key => $value) {
                            $art_fname1 = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => 1))->row()->art_name;
                            $art_lname1 = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => 1))->row()->art_lastname;
                         }

                        $return_html .= '<a href="javascript:void(0);"  onclick="likeuserlist(' . $row['art_post_id'] . ')">';

                         $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1', 'is_delete' => '0');
                        $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                        $likeuser = $commnetcount[0]['art_like_user'];
                        $countlike = $commnetcount[0]['art_likes_count'] - 1;
                           
                           $likelistarray = explode(',', $likeuser);
                           $likelistarray = array_reverse($likelistarray);

                        $art_fname = $this->db->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => 1))->row()->art_name;
                        $art_lname = $this->db->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => 1))->row()->art_lastname;

                        $return_html .= '<div class="like_one_other">';

                        if (in_array($userid, $likelistarray)) {
                            $return_html .= "You";
                            $return_html .= "&nbsp;";
                        } else {
                            $return_html .= ucwords($art_fname);
                            $return_html .= "&nbsp;";
                            $return_html .= ucwords($art_lname);
                            $return_html .= "&nbsp;";

                        }

                        if (count($likelistarray) > 1) {
                            $return_html .= " and".' ';

                            $return_html .= $countlike;
                            $return_html .= "&nbsp;";
                            $return_html .= "others";
                        }
                        $return_html .= '</div>
                            </a>
                        </div>';
                    }

                    $return_html .= '<div class="likeusername' .$row['art_post_id']. '" id="likeusername' . $row['art_post_id'] . '" style="display:none">';
                    $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1', 'is_delete' => '0');
                    $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $likeuser = $commnetcount[0]['art_like_user'];
                    $countlike = $commnetcount[0]['art_likes_count'] - 1;
                    $likelistarray = explode(',', $likeuser);

                    foreach ($likelistarray as $key => $value) {
                        $art_fname1 = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => 1))->row()->art_name;
                        $art_lname1 = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => 1))->row()->art_lastname;
                    }
                    $return_html .= '<a href="javascript:void(0);"  onclick="likeuserlist(' . $row['art_post_id'] . ')">';

                    $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1', 'is_delete' => '0');
                    $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                           $likeuser = $commnetcount[0]['art_like_user'];
                           $countlike = $commnetcount[0]['art_likes_count'] - 1;
                           
                           $likelistarray = explode(',', $likeuser);
                           $likelistarray = array_reverse($likelistarray);

                   $art_fname = $this->db->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => 1))->row()->art_name;
                   $art_lname = $this->db->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => 1))->row()->art_lastname;

                    $return_html .= '<div class="like_one_other">';

                    $return_html .= ucwords($art_fname);
                    $return_html .= "&nbsp;";
                    $return_html .= ucwords($art_lname);
                    $return_html .= "&nbsp;";

                    if (count($likelistarray) > 1) {

                        $return_html .= "and".' ';

                        $return_html .= $countlike;
                        $return_html .= "&nbsp;";
                        $return_html .= "others";
                    }
                    $return_html .= '</div>
                        </a>
                    </div>

                    <div class="art-all-comment col-md-12">
                        <div  id="fourcomment' . $row['art_post_id'] . '" style="display:none;">
                        </div>
                        <div id="threecomment' . $row['art_post_id'] . '" style="display:block">
                            <div class="hidebottomborder insertcomment' . $row['art_post_id'] . '">';

                   $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1');
                   $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = 'artistic_post_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');

                    if ($artdata) {
                        foreach ($artdata as $rowdata) {
                            $artname = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->art_name;
                            $artlastname = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->art_lastname;
                            $artslug = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->slug;

                            $return_html .= '<div class="all-comment-comment-box">
                                            <div class="post-design-pro-comment-img">';
                            $return_html .= '<a href="' . base_url('artistic/dashboard/' . $artslug) . '">';
                          $art_userimage = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id'], 'status' => 1))->row()->art_user_image;

                            if ($art_userimage) {
                                

                                if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                                                                $a = $artname;
                                                                $acr = substr($a, 0, 1);
                                                                $b = $artlastname;
                                                                $bcr = substr($b, 0, 1);
                                                                
                                $return_html .= '<div class="post-img-div">';
                                $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                 $return_html .= '</div>'; 
                                                                
                                                            } else { 

                                $return_html .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage . '"  alt="">';
                                        }

                                
                            } else {
                                
                                                                $a = $artname;
                                                                $acr = substr($a, 0, 1);
                                                                $b = $artlastname;
                                                                $bcr = substr($b, 0, 1);
                                                                
                                $return_html .= '<div class="post-img-div">';
                                $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                 $return_html .= '</div>'; 
                                                                
                                                           
                                
                            }

                            $return_html .= '</a>';
                            $return_html .= '</div>
                                            <div class="comment-name">';
                            $return_html .= '<a href="' . base_url('artistic/dashboard/' . $artslug) . '">

                                                <b title="' . ucfirst(strtolower($artname)) .' '.ucfirst(strtolower($artlastname)).'">';
                            $return_html .= ucfirst(strtolower($artname));
                            $return_html .= ' ';
                            $return_html .= ucfirst(strtolower($artlastname));

                            $return_html .= '</br>';

                            $return_html .= '</b></a>
                                            </div>
                                            <div class="comment-details" id="showcomment' . $rowdata['artistic_post_comment_id'] . '">';

                            $return_html .= '<div id="lessmore' . $rowdata['artistic_post_comment_id'] . '" style="display:block;">';
                            $small = substr($rowdata['comments'], 0, 180);
                            $return_html .= $this->common->make_links($small);

                            if (strlen($rowdata['comments']) > 180) {
                                $return_html .= '... <span id="kkkk" onClick="seemorediv(' . $rowdata['artistic_post_comment_id'] . ')">view More</span>';
                            }
                            $return_html .= '</div>';
                            $return_html .= '<div id="seemore' . $rowdata['artistic_post_comment_id'] . '" style="display:none;">';
                            $new_product_comment = $this->common->make_links($rowdata['comments']);
                            $return_html .= nl2br(htmlspecialchars_decode(htmlentities($new_product_comment, ENT_QUOTES, 'UTF-8')));
                            $return_html .= '</div>';
                            $return_html .= '</div>
                                            <div class="edit-comment-box">
                                                <div class="inputtype-edit-comment">
                                                    <div contenteditable="true" style="display:none" class="editable_text editav_2 custom-edit" name="' . $rowdata['artistic_post_comment_id'] . '"  id="editcomment' . $rowdata['artistic_post_comment_id'] . '" placeholder="Enter Your Comment " value= ""  onkeyup="commentedit(' . $rowdata['artistic_post_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $rowdata['comments'] . '</div>
                                                    <span class="comment-edit-button"><button id="editsubmit' . $rowdata['artistic_post_comment_id'] . '" style="display:none" onClick="edit_comment(' . $rowdata['artistic_post_comment_id'] . ')">Save</button></span>
                                                </div>
                                            </div>
                                            <div class="art-comment-menu-design"> 
                                                <div class="comment-details-menu" id="likecomment1' . $rowdata['artistic_post_comment_id'] . '">
                                                    <a id="' . $rowdata['artistic_post_comment_id'] . '" onClick="comment_like1(this.id)">';

                            $userid = $this->session->userdata('aileenuser');
                            $contition_array = array('artistic_post_comment_id' => $rowdata['artistic_post_comment_id'], 'status' => '1');
                            $artcommentlike = $this->data['artcommentlike'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                            $likeuserarray = explode(',', $artcommentlike[0]['artistic_comment_like_user']);
                            if (!in_array($userid, $likeuserarray)) {

                                $return_html .= '<i class="fa fa-thumbs-up fa-1x"  aria-hidden="true"></i>';
                            } else {
                                $return_html .= '<i class="fa fa-thumbs-up fa-1x main_color" aria-hidden="true">
                                                            </i>';
                            }
                            $return_html .= '<span>';

                            if ($rowdata['artistic_comment_likes_count']) {
                                $return_html .= $rowdata['artistic_comment_likes_count'];
                            }

                            $return_html .= '</span>
                                                    </a>
                                                </div>';
                            $userid = $this->session->userdata('aileenuser');
                            if ($rowdata['user_id'] == $userid) {

                                $return_html .= '<span role="presentation" aria-hidden="true"> · 
                                                    </span>
                                                    <div class="comment-details-menu">
                                                        <div id="editcommentbox' . $rowdata['artistic_post_comment_id'] . '" style="display:block;">
                                                            <a id="' . $rowdata['artistic_post_comment_id'] . '"   onClick="comment_editbox(this.id)" class="editbox">Edit
                                                            </a>
                                                        </div>
                                                        <div id="editcancle' . $rowdata['artistic_post_comment_id'] . '" style="display:none;">
                                                            <a id="' . $rowdata['artistic_post_comment_id'] . '" onClick="comment_editcancle(this.id)">Cancel
                                                            </a>
                                                        </div>
                                                    </div>';
                            }
                            $userid = $this->session->userdata('aileenuser');
                            $art_userid = $this->db->get_where('art_post', array('art_post_id' => $rowdata['art_post_id'], 'status' => 1))->row()->user_id;
                            
                            if ($rowdata['user_id'] == $userid || $art_userid == $userid) {

                                $return_html .= '<span role="presentation" aria-hidden="true"> · 
                                                    </span>
                                                    <div class="comment-details-menu">
                                                        <input type="hidden" name="post_delete"  id="post_delete' . $rowdata['artistic_post_comment_id'] . '" value= "' . $rowdata['art_post_id'] . '">
                                                        <a id="' . $rowdata['artistic_post_comment_id'] . '"   onClick="comment_delete(this.id)"> Delete
                                                            <span class="insertcomment' . $rowdata['artistic_post_comment_id'] . '">
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
                        <div class="post-design-proo-img hidden-mob">';

                         $art_slug = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->slug;

                        $return_html .= '<a href="' . base_url('artistic/dashboard/' . $art_slug) . '">';

                    $userid = $this->session->userdata('aileenuser');
                    $art_userimage = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->art_user_image;

                    $art_fn = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->art_name;
                    $art_ln = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->art_lastname;

                    if ($art_userimage) {

                        if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                                                                $a = $art_fn;
                                                                $acr = substr($a, 0, 1);
                                                                $b = $art_ln;
                                                                $bcr = substr($b, 0, 1);
                                                               
                                $return_html .= '<div class="post-img-div">';
                                $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                $return_html .= '</div>'; 
                                                                
                                                            } else { 

                        $return_html .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage . '"  alt="">';
                            }

                    } else {
                                                                $a = $art_fn;
                                                                $acr = substr($a, 0, 1);
                                                                $b = $art_ln;
                                                                $bcr = substr($b, 0, 1);
                                                               
                                $return_html .= '<div class="post-img-div">';
                                $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                $return_html .= '</div>'; 
                    }
                    $return_html .= '</a></div>

                        <div id="content" class="col-md-12  inputtype-comment cmy_2" >
                            <div contenteditable="true" class="edt_2 editable_text" name="' . $row['art_post_id'] . '"  id="post_comment' . $row['art_post_id'] . '" placeholder="Add a Comment ..." onClick="entercomment(' . $row['art_post_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);"></div>
                      
                      ' . form_error('post_comment') . ' 
                        <div class="mob-comment">       
                            <button id="' . $row['art_post_id'] . '" onClick="insert_comment(this.id)"><img src="../img/send.png">
                            </button>
                        </div>  </div>
                        <div class=" comment-edit-butn hidden-mob" >   
                           <button  id="'.$row['art_post_id'].'" onClick="insert_comment(this.id)">Comment</button> 
                        </div>

                    </div>
                    </div>
                    </div></div>';
                } else {
                    $count[] = "abc";
                }
            }
        }
        if (count($finalsorting) > 0) {
            if (count($count) == count($finalsorting)) {
                $return_html .= ' <div class="art_no_post_avl" id="no_post_avl">
                                           <h3>Artistic Post</h3>
                              <div class="art-img-nn">
                               <div class="art_no_post_img">

                               <img src="'.base_url('img/art-no.png').'">
        
                                </div>
                                  <div class="art_no_post_text">
                                    No Post Available.
                                    </div>
                                   </div>
                                </div>';
            }
        } else {
            $return_html .= '<div class="art_no_post_avl" id="no_post_avl"><h3>Artistic Post</h3>
                              <div class="art-img-nn">
                               <div class="art_no_post_img">

                                     <img src="'.base_url('img/art-no.png').'">
        
                                    </div>
                                        <div class="art_no_post_text">
                                     No Post Available.
                                 </div>
                                  </div></div>';
        }
        echo $return_html;
        // return html        
    }

// all post fatch using aajx end
 


//photos video audio pdf fatch using ajax art_manage_post start


 public function artistic_photos() {

        $id = $_POST['art_id'];
        // manage post start
        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');


       if ($id == $userid || $id == '') {
            $contition_array = array('user_id' => $userid, 'status' => '1');
            $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {
            $contition_array = array('user_id' => $id, 'status' => '1', 'art_step' => 4);
            $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }



        $contition_array = array('user_id' => $artisticdata[0]['user_id']);
        $artimage = $this->data['artimage'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = 'art_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');



        foreach ($artimage as $val) {



            $contition_array = array('post_id' => $val['art_post_id'], 'is_deleted' => '1', 'insert_profile' => '1');
            $artmultiimage = $this->data['artmultiimage'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = 'post_files_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            $multipleimage[] = $artmultiimage;
        }
        $allowed = array('jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg');

        foreach ($multipleimage as $mke => $mval) {

                            foreach ($mval as $mke1 => $mval1) {
                                $ext = pathinfo($mval1['file_name'], PATHINFO_EXTENSION);

                                if (in_array($ext, $allowed)) {
                                    $singlearray[] = $mval1;
                                }
                            }
                        }

        if ($singlearray) {
            $i = 0;
            foreach ($singlearray as $mi) {
                $fetch_result .= '<div class="image_profile">';
                $fetch_result .= '<img src="' . ART_POST_THUMB_UPLOAD_URL . $mi['file_name'] . '" alt="img1">';
                $fetch_result .= '</div>';

                $i++;
                if ($i == 6)
                    break;
            }
        } else {

           // $fetch_result .= '<div class="not_available">  <p>     Photos Not Available </p></div>';
        }

        $fetch_result .= '<div class="dataconphoto"></div>';

        echo $fetch_result;
    }

    public function artistic_videos() {

        $id = $_POST['art_id'];
        // manage post start
        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

    

         if ($id == $userid || $id == '') {
            $contition_array = array('user_id' => $userid, 'status' => '1');
            $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {
            $contition_array = array('user_id' => $id, 'status' => '1', 'art_step' => 4);
            $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }

       $contition_array = array('user_id' => $artisticdata[0]['user_id']);
       $artimage = $this->data['artimage'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = 'art_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        foreach ($artimage as $val) {



           $contition_array = array('post_id' => $val['art_post_id'], 'is_deleted' => '1', 'insert_profile' => '1');
           $artmultivideo = $this->data['artmultivideo'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = 'post_files_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $multiplevideo[] = $artmultivideo;
        }

        $allowesvideo = array('mp4', '3gp', 'avi', 'ogg', '3gp', 'webm', 'MP4');

        
        foreach ($multiplevideo as $mke => $mval) {

                                foreach ($mval as $mke1 => $mval1) {
                                    $ext = pathinfo($mval1['file_name'], PATHINFO_EXTENSION);

                                    if (in_array($ext, $allowesvideo)) {
                                        $singlearray1[] = $mval1;
                                    }
                                }
        }

        if ($singlearray1) {
            $fetch_video .= '<tr>';

            if ($singlearray1[0]['file_name']) {
                $fetch_video .= '<td class="image_profile">';
                $fetch_video .= '<video controls>';

                $fetch_video .= '<source src="' . ART_POST_MAIN_UPLOAD_URL . $singlearray1[0]['file_name'] . '" type="video/mp4">';
                $fetch_video .= '<source src="movie.ogg" type="video/ogg">';
                $fetch_video .= 'Your browser does not support the video tag.';
                $fetch_video .= '</video>';
                $fetch_video .= '</td>';
            }

            if ($singlearray1[1]['file_name']) {
                $fetch_video .= '<td class="image_profile">';
                $fetch_video .= '<video  controls>';
                $fetch_video .= '<source src="' . ART_POST_MAIN_UPLOAD_URL . $singlearray1[1]['file_name'] . '" type="video/mp4">';
                $fetch_video .= '<source src="movie.ogg" type="video/ogg">';
                $fetch_video .= 'Your browser does not support the video tag.';
                $fetch_video .= '</video>';
                $fetch_video .= '</td>';
            }
            if ($singlearray1[2]['file_name']) {
                $fetch_video .= '<td class="image_profile">';
                $fetch_video .= '<video  controls>';
                $fetch_video .= '<source src="' . ART_POST_MAIN_UPLOAD_URL . $singlearray1[2]['file_name'] . '" type="video/mp4">';
                $fetch_video .= '<source src="movie.ogg" type="video/ogg">';
                $fetch_video .= 'Your browser does not support the video tag.';
                $fetch_video .= '</video>';
                $fetch_video .= '</td>';
            }
            $fetch_video .= '</tr>';
            $fetch_video .= '<tr>';

            if ($singlearray1[3]['file_name']) {
                $fetch_video .= '<td class="image_profile">';
                $fetch_video .= '<video  controls>';
                $fetch_video .= '<source src="' . ART_POST_MAIN_UPLOAD_URL . $singlearray1[3]['file_name'] . '" type="video/mp4">';
                $fetch_video .= '<source src="movie.ogg" type="video/ogg">';
                $fetch_video .= 'Your browser does not support the video tag.';
                $fetch_video .= '</video>';
                $fetch_video .= '</td>';
            }
            if ($singlearray1[4]['file_name']) {
                $fetch_video .= '<td class="image_profile">';
                $fetch_video .= '<video  controls>';
                $fetch_video .= '<source src="' . ART_POST_MAIN_UPLOAD_URL . $singlearray1[4]['file_name'] . '" type="video/mp4">';
                $fetch_video .= '<source src="movie.ogg" type="video/ogg">';
                $fetch_video .= 'Your browser does not support the video tag.';
                $fetch_video .= '</video>';
                $fetch_video .= '</td>';
            }
            if ($singlearray1[5]['file_name']) {
                $fetch_video .= '<td class="image_profile">';
                $fetch_video .= '<video  controls>';
                $fetch_video .= '<source src="' . ART_POST_MAIN_UPLOAD_URL . $singlearray1[5]['file_name'] . '" type="video/mp4">';
                $fetch_video .= '<source src="movie.ogg" type="video/ogg">';
                $fetch_video .= 'Your browser does not support the video tag.';
                $fetch_video .= '</video>';
                $fetch_video .= '</td>';
            }
            $fetch_video .= '</tr>';
        } else {


            //$fetch_video .= '<div class="not_available">  <p>     Video Not Available </p></div>';
        }

        $fetch_video .= '<div class="dataconvideo"></div>';


        echo $fetch_video;
    }

    public function artistic_audio() {

        $id = $_POST['art_id'];
        // manage post start
        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

       
       if ($id == $userid || $id == '') {
            $contition_array = array('user_id' => $userid, 'status' => '1');
            $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {
            $contition_array = array('user_id' => $id, 'status' => '1', 'art_step' => 4);
            $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }

         $contition_array = array('user_id' => $artisticdata[0]['user_id']);
         $artimage = $this->data['artimage'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = 'art_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        foreach ($artimage as $val) {



            $contition_array = array('post_id' => $val['art_post_id'], 'is_deleted' => '1', 'insert_profile' => '1');
            $artmultiaudio = $this->data['artmultiaudio'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = 'post_files_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            $multipleaudio[] = $artmultiaudio;
        }

        $allowesaudio = array('mp3');

        foreach ($multipleaudio as $mke => $mval) {

                                foreach ($mval as $mke1 => $mval1) {
                                    $ext = pathinfo($mval1['file_name'], PATHINFO_EXTENSION);

                                    if (in_array($ext, $allowesaudio)) {
                                        $singlearray2[] = $mval1;
                                    }
                                }
            }

        if ($singlearray2) {
            $fetchaudio .= '<tr>';

            if ($singlearray2[0]['file_name']) {
                $fetchaudio .= '<td class="image_profile">';
                $fetchaudio .= '<audio  controls>';

                $fetchaudio .= '<source src="' . ART_POST_MAIN_UPLOAD_URL . $singlearray2[0]['file_name'] . '" type="audio/mp3">';
                $fetchaudio .= '<source src="movie.ogg" type="audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</audio>';
                $fetchaudio .= '</td>';
            }

            if ($singlearray2[1]['file_name']) {
                $fetchaudio .= '<td class="image_profile">';
                $fetchaudio .= '<audio  controls>';
                $fetchaudio .= '<source src="' . ART_POST_MAIN_UPLOAD_URL . $singlearray2[1]['file_name'] . '" type="audio/mp3">';
                $fetchaudio .= '<source src="movie.ogg" type="audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</audio>';
                $fetchaudio .= '</td>';
            }
            if ($singlearray2[2]['file_name']) {
                $fetchaudio .= '<td class="image_profile">';
                $fetchaudio .= '<audio  controls>';
                $fetchaudio .= '<source src="' . ART_POST_MAIN_UPLOAD_URL . $singlearray2[2]['file_name'] . '" type="audio/mp3">';
                $fetchaudio .= '<source src="movie.ogg" type="audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</audio>';
                $fetchaudio .= '</td>';
            }
            $fetchaudio .= '</tr>';
            $fetchaudio .= '<tr>';

            if ($singlearray2[3]['file_name']) {
                $fetchaudio .= '<td class="image_profile">';
                $fetchaudio .= '<audio  controls>';
                $fetchaudio .= '<source src="' . ART_POST_MAIN_UPLOAD_URL . $singlearray2[3]['file_name'] . '" type="audio/mp3">';
                $fetchaudio .= '<source src="movie.ogg" type="audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</audio>';
                $fetchaudio .= '</td>';
            }
            if ($singlearray2[4]['file_name']) {
                $fetchaudio .= '<td class="image_profile">';
                $fetchaudio .= '<audio  controls>';
                $fetchaudio .= '<source src="' . ART_POST_MAIN_UPLOAD_URL . $singlearray2[4]['file_name'] . '" type="audio/mp3">';
                $fetchaudio .= '<source src="movie.ogg" type="audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</audio>';
                $fetchaudio .= '</td>';
            }
            if ($singlearray2[5]['file_name']) {
                $fetchaudio .= '<td class="image_profile">';
                $fetchaudio .= '<audio  controls>';
                $fetchaudio .= '<source src="' . ART_POST_MAIN_UPLOAD_URL . $singlearray2[5]['file_name'] . '" type="audio/mp3">';
                $fetchaudio .= '<source src="movie.ogg" type="audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</audio>';
                $fetchaudio .= '</td>';
            }
            $fetchaudio .= '</tr>';
        } else {
            //$fetchaudio .= '<div class="not_available">  <p>   Audio Not Available </p></div>';
        }
        $fetchaudio .= '<div class="dataconaudio"></div>';
        echo $fetchaudio;
    }

   public function artistic_pdf() {
        $id = $_POST['art_id'];
        
        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

        

        if ($id == $userid || $id == '') {
            $contition_array = array('user_id' => $userid, 'status' => '1');
            $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {
            $contition_array = array('user_id' => $id, 'status' => '1', 'art_step' => 4);
            $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }

        $contition_array = array('user_id' => $artisticdata[0]['user_id']);
        $artimage = $this->data['artimage'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = 'art_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        foreach ($artimage as $val) {

                                $contition_array = array('post_id' => $val['art_post_id'], 'is_deleted' => '1', 'insert_profile' => '1');
                                $artmultipdf = $this->data['artmultipdf'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = 'post_files_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                $multiplepdf[] = $artmultipdf;
                            }

        $allowespdf = array('pdf');
         foreach ($multiplepdf as $mke => $mval) {

                                foreach ($mval as $mke1 => $mval1) {
                                    $ext = pathinfo($mval1['file_name'], PATHINFO_EXTENSION);

                                    if (in_array($ext, $allowespdf)) {
                                        $singlearray3[] = $mval1;
                                    }
                                }
                            }

        if ($singlearray3) {

            $i = 0;
            foreach ($singlearray3 as $mi) {

                $fetch_pdf .= '<div class="image_profile">';
                // $fetch_pdf .= '<a href="' . base_url('artistic/creat_pdf/' . $mi['post_files_id']) . '"><div class="pdf_img">';
                $fetch_pdf .= '<a href="'.ART_POST_MAIN_UPLOAD_URL . $mi['file_name'].'">';
                $fetch_pdf .= '<embed src="' . ART_POST_MAIN_UPLOAD_URL . $mi['file_name'] . '" width="100%" height="450px" />';
                $fetch_pdf .= '</div></a>';
                $fetch_pdf .= '</div>';

                $i++;
                if ($i == 6)
                    break;
            }
        } else {
            //$fetch_pdf .= '<div class="not_available">  <p> Pdf Not Available </p></div>';
        }
        $fetch_pdf .= '<div class="dataconpdf"></div>';
        echo $fetch_pdf;
    }
 // dashboard post using ajax strat

 public function artistic_dashboard_post($id = '') {
// manage post start

        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;


       // $id = $_GET['slug'];
        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

        $contition_array = array('user_id' => $userid, 'status' => '1');
            $artisticslug = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        if ($id == $userid || $id == '' || $id == $artisticslug[0]['slug']) {
            $contition_array = array('user_id' => $userid, 'status' => '1');
            $artisticdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

           // $limit = $perpage;
          //  $offset = $start;

            $contition_array = array('user_id' => $userid, 'status' => 1, 'is_delete' => '0');
            $artsdata = $this->common->select_data_by_condition('art_post', $contition_array, $data, $sortby = 'art_post_id', $orderby = 'DESC', $limit, $offset, $join_str = array(), $groupby = '');
            // $artsdata1 = $this->common->select_data_by_condition('art_post', $contition_array, $data, $sortby = 'art_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            //echo "<pre>"; print_r($artsdata); die();
        } else {
            $contition_array = array('slug' => $id, 'status' => '1', 'art_step' => 4);
            $artisticdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

          // $limit = $perpage;
           // $offset = $start;

            $contition_array = array('user_id' => $id, 'status' => 1, 'is_delete' => '0');
            $artsdata = $this->common->select_data_by_condition('art_post', $contition_array, $data, $sortby = 'art_post_id', $orderby = 'DESC', $limit, $offset, $join_str = array(), $groupby = '');
            // $artsdata1 = $this->common->select_data_by_condition('art_post', $contition_array, $data, $sortby = 'art_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }

        $return_html = '';

        $artsdata1 = array_slice($artsdata, $start, $perpage);
        //echo "<pre>"; print_r($artsdata1);  count($artsdata1); 
        //echo count($artsdata); die();

        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($artsdata);
        }

        $return_html .= '<input type = "hidden" class = "page_number" value = "' . $page . '" />';
        $return_html .= '<input type = "hidden" class = "total_record" value = "' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';
        if (count($artsdata) > 0) {

            foreach ($artsdata1 as $row) {
                $contition_array = array('user_id' => $row['user_id'], 'status' => '1');
                $artisticdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $return_html .= '<div id = "removepost' . $row['art_post_id'] . '">
<div class = "profile-job-post-detail clearfix">
<div class = "post-design-box">
<div class = "post-design-top col-md-12" >
<div class = "post-design-pro-img">';
                $userid = $this->session->userdata('aileenuser');
                $userimage = $this->db->get_where('art_reg', array('user_id' => $row['user_id']))->row()->art_user_image;
                $userimageposted = $this->db->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->art_user_image;

                $firstname = $this->db->get_where('art_reg', array('user_id' => $row['user_id']))->row()->art_name;
                $lastname = $this->db->get_where('art_reg', array('user_id' => $row['user_id']))->row()->art_lastname;

                $slug = $this->db->get_where('art_reg', array('user_id' => $row['user_id']))->row()->slug;

                $firstnameposted = $this->db->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->art_name;
                $lastnameposted = $this->db->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->art_lastname;
                $slugposted = $this->db->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->slug;

                if ($row['posted_user_id']) {
                    if ($userimageposted) {

                        if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $userimageposted)) {

                             $a = $firstnameposted;
                             $acr = substr($a, 0, 1);
                             $b = $lastnameposted;
                             $bcr = substr($b, 0, 1);

                             $return_html .= '<a  class="post_dot" title="'.ucfirst(strtolower($firstnameposted)) . ' ' . ucfirst(strtolower($lastnameposted)).'" href="'.base_url('artistic/dashboard/' . $slugposted).'">';

                            $return_html .= '<div class="post-img-div">';
                            $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                            $return_html .= '</div> ';
                            $return_html .= '</a>';

                        } else {

                             $return_html .= '<a  class="post_dot" title="'.ucfirst(strtolower($firstnameposted)) . ' ' . ucfirst(strtolower($lastnameposted)).'" href="'.base_url('artistic/dashboard/' . $slugposted).'">';
                            $return_html .= '<img src = "' . ART_PROFILE_THUMB_UPLOAD_URL . $userimageposted . '" name = "image_src" id = "image_src" />';
                             $return_html .= '</a>';
                        }
                    } else {


                             $a = $firstnameposted;
                             $acr = substr($a, 0, 1);
                             $b = $lastnameposted;
                             $bcr = substr($b, 0, 1);

                             $return_html .= '<a  class="post_dot" title="'.ucfirst(strtolower($firstnameposted)). ' ' . ucfirst(strtolower($lastnameposted)).'" href="'.base_url('artistic/dashboard/' . $slugposted).'">';

                            $return_html .= '<div class="post-img-div">';
                            $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                            $return_html .= '</div> ';
                            $return_html .= '</a>';
                    }
                } else {
                    if ($userimage) {

                        if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $userimage)) {


                             $a = $firstname;
                             $acr = substr($a, 0, 1);
                             $b = $lastname;
                             $bcr = substr($b, 0, 1);

                             $return_html .= '<a  class="post_dot" title="'.ucfirst(strtolower($firstname)). ' ' . ucfirst(strtolower($lastname)).'" href="'.base_url('artistic/dashboard/' . $slug).'">';

                            $return_html .= '<div class="post-img-div">';
                            $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                            $return_html .= '</div>';
                            $return_html .= '</a>';
                        } else {

                             $return_html .= '<a  class="post_dot" title="'.ucfirst(strtolower($firstname)). ' ' . ucfirst(strtolower($lastname)).'" href="'.base_url('artistic/dashboard/' . $slug).'">';
                            $return_html .= '<img src = "' . ART_PROFILE_THUMB_UPLOAD_URL . $userimage . '" name = "image_src" id = "image_src" />';
                            $return_html .= '</a>';
                        }
                    } else {


                             $a = $firstname;
                             $acr = substr($a, 0, 1);
                             $b = $lastname;
                             $bcr = substr($b, 0, 1);

                             $return_html .= '<a  class="post_dot" title="'.ucfirst(strtolower($firstname)). ' ' . ucfirst(strtolower($lastname)).'" href="'.base_url('artistic/dashboard/' . $slug).'">';

                            $return_html .= '<div class="post-img-div">';
                            $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                            $return_html .= '</div>';
                            $return_html .= '</a>';
                    }
                }
                $return_html .= '</div>
<div class = "post-design-name fl col-xs-8 col-md-10">
<ul>';
                $firstname = $this->db->get_where('art_reg', array('user_id' => $row['user_id']))->row()->art_name;
                $lastname = $this->db->get_where('art_reg', array('user_id' => $row['user_id']))->row()->art_lastname;

                 $slug = $this->db->get_where('art_reg', array('user_id' => $row['user_id']))->row()->slug;


               $firstnameposted = $this->db->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->art_name;
               $lastnameposted = $this->db->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->art_lastname;

               $slugposted = $this->db->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->slug;
                                                              
              $designation = $this->db->get_where('art_reg', array('user_id' => $row['user_id']))->row()->designation;

                if ($row['posted_user_id']) {
                    $return_html .= '<li>
<div class = "else_post_d">
<div class = "post-design-product">
<a style = "max-width: 40%;" class = "post_dot" title = "' . ucfirst(strtolower($firstnameposted)) .'&nbsp;'. ucfirst(strtolower($lastnameposted)) . '" href = "' . base_url('artistic/dashboard/' . $slugposted) . '">' . ucfirst(strtolower($firstnameposted)). '&nbsp;' .ucfirst(strtolower($lastnameposted)).  '</a>
<p class = "posted_with" > Posted With</p>
<a class = "other_name post_dot" href = "' . base_url('artistic/details/' . $slug) . '">' .ucfirst(strtolower($firstname)).'&nbsp;'.ucfirst(strtolower($lastname)).'</a>
<span role = "presentation" aria-hidden = "true"> · </span> <span class = "ctre_date">' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($row['created_date']))) . '</span>
</div></div>
</li>';
                } else {
                    $return_html .= '<li><div class = "post-design-product"><a class = "post_dot" title = "' . ucfirst(strtolower($firstname)) .'&nbsp;'.ucfirst(strtolower($lastname)).'" href = "'.base_url('business-profile/dashboard/'. $slug).'">'.ucfirst(strtolower($firstname)) . ' ' . ucfirst(strtolower($lastname)).'</a>
<span role = "presentation" aria-hidden = "true"> · </span>
<div class = "datespan">
<span class = "ctre_date">' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($row['created_date']))) . '</span>
</div>
</div>
</li>';
                }
                
                $return_html .= '<li><div class = "post-design-product"> <a class = "buuis_desc_a" title = "Designation">';

                if ($designation) {
                    $return_html .= ucfirst(strtolower($designation));
                } else {
                    $return_html .= 'Current Work.';
                }

                $return_html .= '</a> </div>
</li>
<li>
</li>
</ul>
</div>';

 if($userid == $row['posted_user_id'] || $row['user_id'] == $userid){

 $return_html .= '<div class = "dropdown2">
<a  onClick="myFunction1(' . $row['art_post_id'] . ')" class = " dropbtn2 fa fa-ellipsis-v"></a>
<div id = "myDropdown' . $row['art_post_id'] . '" class = "dropdown-content2 ">';
                if ($row['posted_user_id'] != 0) {
                    if ($this->session->userdata('aileenuser') == $row['posted_user_id']) {
                        $return_html .= '<a onclick = "deleteownpostmodel(' . $row['art_post_id'] . ')">
<i class = "fa fa-trash-o" aria-hidden = "true">
</i> Delete Post
</a>
<a id = "' . $row['art_post_id'] . '" onClick = "editpost(this.id)">
<i class = "fa fa-pencil-square-o" aria-hidden = "true">
</i>Edit
</a>';
                    } else {
                        $return_html .= '<a onclick = "deleteownpostmodel(' . $row['art_post_id'] . ')">
<i class = "fa fa-trash-o" aria-hidden = "true">
</i> Delete Post
</a>';
// $return_html .= '<a href = "' . base_url('business-profile/business-profile-contactperson/' . $row['posted_user_id'] . '') . '">
// <i class = "fa fa-user" aria-hidden = "true">
// </i> Contact Person
// </a>';
                    }
                } else {
                    if ($this->session->userdata('aileenuser') == $row['user_id']) {
                        $return_html .= '<a onclick = "deleteownpostmodel(' . $row['art_post_id'] . ')"><i class = "fa fa-trash-o" aria-hidden = "true"></i> Delete Post</a>
<a id = "' . $row['art_post_id'] . '" onClick = "editpost(this.id)"><i class = "fa fa-pencil-square-o" aria-hidden = "true"></i>Edit</a>';
                    } else {
                        // $return_html .= '<a href = "' . base_url('business-profile/business-profile-contactperson/' . $row['user_id'] . '') . '"><i class = "fa fa-user" aria-hidden = "true"></i> Contact Person</a>';
                    }
                }
                $return_html .= '</div>
</div>';
       }    
                if ($row['art_post'] || $row['art_description']) {
                    $return_html .= '<div class = "post-design-desc ">';
                }
                $return_html .= '<div class = "ft-15 t_artd">
<div id = "editpostdata' . $row['art_post_id'] . '" style = "display:block;">
<a id="editpostval' . $row['art_post_id'].'">' . $this->common->make_links($row['art_post']) . '</a>
</div>
<div id = "editpostbox' . $row['art_post_id'] . '" style = "display:none;">
<input type = "text" class="my_text" id = "editpostname' . $row['art_post_id'] . '" name = "editpostname" placeholder = "Title" value = "' . $row['art_post'] . '" onKeyDown = check_lengthedit(' . $row['art_post_id'] . ') onKeyup = check_lengthedit(' . $row['art_post_id'] . ');
onblur = check_lengthedit(' . $row['art_post_id'] . ')>';
                if ($row['art_post']) {
                    $counter = $row['art_post'];
                    $a = strlen($counter);
                    $return_html .= '<input size = 1 id = "text_num_' . $row['art_post_id'] . '" class = "text_num" value = "' . (50 - $a) . '" name = text_num disabled="disabled">';
                } else {
                    $return_html .= '<input size = 1 id = "text_num_' . $row['art_post_id'] . '" class = "text_num" value = 50 name = text_num disabled="disabled">';
                }
                $return_html .= '</div>
</div>
<div id = "khyati' . $row['art_post_id'] . '" style = "display:block;">';

                                       $num_words = 29;
                                       $words = array();
                                       $words = explode(" ",  $row['art_description'], $num_words);
                                       $shown_string = "";
                                       
                                       if(count($words) == 29){
                                       $words[28] ='... <span id="kkkk" onClick="khdiv(' . $row['art_post_id'] . ')">View More</span>';
                                       }
                                       
                                       $shown_string = implode(" ", $words);
                                       $return_html .= $this->common->make_links($shown_string);
                // $small = substr($row['art_description'], 0, 180);
                // $return_html .= $this->common->make_links($small);
                // if (strlen($row['art_description']) > 180) {
                //     $return_html .= '... <span id = "kkkk" onClick = "khdiv(' . $row['art_post_id'] . ')">View More</span>';
                // }


                $return_html .= '</div>
<div id = "khyatii' . $row['art_post_id'] . '" style = "display:none;">';
                $return_html .= $this->common->make_links($row['art_description']);
                $return_html .= '</div>
<div id = "editpostdetailbox' . $row['art_post_id'] . '" style = "display:none;">
<div contenteditable = "true" id = "editpostdesc' . $row['art_post_id'] . '" class = "textbuis editable_text" placeholder = "Description" name = "editpostdesc" onpaste = "OnPaste_StripFormatting(this, event);" onfocus="return cursorpointer(' . $row['art_post_id'] . ');">' . $row['art_description'] . '</div>
</div><button class = "fr" id = "editpostsubmit' . $row['art_post_id'] . '" style="display:none; margin: 5px 0;" onClick="edit_postinsert(' . $row['art_post_id'] . ')">Save</button>
</div> ';
                if ($row['art_post'] || $row['art_description']) {
                    $return_html .= '</div>';
                }
                $return_html .= '<div class="post-design-mid col-md-12" >  
    <div class="mange_post_image">';

                $contition_array = array('post_id' => $row['art_post_id'], 'is_deleted' => '1', 'insert_profile' => '1');
                $artmultiimage = $this->data['artmultiimage'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if (count($artmultiimage) == 1) {

                    $allowed = array('jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg');
                    $allowespdf = array('pdf');
                    $allowesvideo = array('mp4', 'webm','MP4');
                    $allowesaudio = array('mp3');
                    $filename = $artmultiimage[0]['file_name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    if (in_array($ext, $allowed)) {
                        $return_html .= '<div class="one-image">
            <a href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '">

           <img src = "' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '">

             </a>
        </div>';
                    } elseif (in_array($ext, $allowespdf)) {

                        $return_html .= '<div><a href="'.base_url($this->config->item('art_post_main_upload_path') . $artmultiimage[0]['file_name']).'"> 

           <div class="pdf_img">
                   <embed src="' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '" width="100%" height="450px" />
                </div></a>
        </div>';
                    } elseif (in_array($ext, $allowesvideo)) {
                        $return_html .= '<div>
            <video class="video" width="100%" height="350" controls>

                 <source src = "' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '" type = "video/mp4">

                <source src="movie.ogg" type="video/ogg">
                Your browser does not support the video tag.
            </video>
        </div>';
                    } elseif (in_array($ext, $allowesaudio)) {
                        $return_html .= '<div class="audio_main_div">
            <div class="audio_img">
                <img src="' . base_url('images/music-icon.png') . '">  
            </div>
            <div class="audio_source">
                <audio  controls>
                    <source src = "' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '" type = "audio/mp3">
                    <source src="movie.ogg" type="audio/ogg">
                    Your browser does not support the audio tag.
                </audio>
            </div> </div>';
            // <div class="audio_mp3" id="postname' . $row['art_post_id'] . '">
            //     <p title="' . $row['art_post'] . '">' . $row['art_post'] . '</p>
            // </div>
       
                    }
                } elseif (count($artmultiimage) == 2) {
                    foreach ($artmultiimage as $multiimage) {
                        $return_html .= '<div  class="two-images" >
            <a href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '">
             <img class = "two-columns" src = "' . ART_POST_RESIZE1_UPLOAD_URL . $multiimage['file_name'] . '">
             </a>
        </div>';
                    }
                } elseif (count($artmultiimage) == 3) {
                    $return_html .= '<div class="three-imag-top" >
            <a href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '">
            <img class = "three-columns" src = "' . ART_POST_RESIZE4_UPLOAD_URL . $artmultiimage[0]['file_name'] . '">
            </a>
        </div>
        <div class="three-image" >
            <a href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '">
           <img class = "three-columns" src = "' . ART_POST_RESIZE1_UPLOAD_URL . $artmultiimage[1]['file_name'] . '">
            </a>
        </div>
        <div class="three-image" >
            <a href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '">
            <img class = "three-columns" src = "' . ART_POST_RESIZE1_UPLOAD_URL . $artmultiimage[2]['file_name'] . '">
            </a>
        </div>';
                } elseif (count($artmultiimage) == 4) {

                    foreach ($artmultiimage as $multiimage) {
                        $return_html .= '<div class="four-image">
            <a href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '">
            <img class = "breakpoint" src = "' . ART_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name'] . '">
             </a>
        </div>';
                    }
                } elseif (count($artmultiimage) > 4) {

                    $i = 0;
                    foreach ($artmultiimage as $multiimage) {
                        $return_html .= '<div class="four-image">
            <a href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '">
            <img class = "breakpoint" src = "' . ART_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name'] . '">
            </a>
        </div>';
                        $i++;
                        if ($i == 3)
                            break;
                    }
                    $return_html .= '<div class="four-image">
            <a href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '">
           <img src = "' . ART_POST_RESIZE2_UPLOAD_URL . $artmultiimage[3]['file_name'] . '">
             </a>
            <a href="' . base_url('artistic/post-detail/' . $row['art_post_id']) . '">
                <div class="more-image" >
                    <span> View All (+' . (count($artmultiimage) - 4) . ')
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
            <li class="likepost' . $row['art_post_id'] . '">
                <a class="ripple like_h_w" id="' . $row['art_post_id'] . '"   onClick="post_like(this.id)">';
                $userid = $this->session->userdata('aileenuser');
                $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1');
                $artlike = $this->data['artlike'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $likeuser = $this->data['artlike'][0]['art_like_user'];
                $likeuserarray = explode(',', $artlike[0]['art_like_user']);

                if (!in_array($userid, $likeuserarray)) {
                    $return_html .= '<i class="fa fa-thumbs-up" style="color: #999;" aria-hidden="true"></i>';
                } else {
                    $return_html .= '<i class="fa fa-thumbs-up fa-1x main_color" aria-hidden="true"></i>';
                }

                $return_html .= '<span class="like_As_count">';
                // if ($row['business_likes_count'] > 0) {
                //     $return_html .= $row['business_likes_count'];
                // }
                $return_html .= '</span>
                </a>
            </li>

            <li id="insertcount' . $row['art_post_id'] . '" style="visibility:show">';
                $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1', 'is_delete' => '0');
                $commnetcount = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $return_html .= '<a title="Comment" class="ripple like_h_w" onClick="commentall(this.id)" id="' . $row['art_post_id'] . '"><i class="fa fa-comment-o" aria-hidden="true">';
                $return_html .= '</i> 
                </a>
            </li> 
        </ul>
        <ul class="col-md-6 like_cmnt_count">
            <li>
                <div class="like_cmmt_space comnt_count_ext_a like_count_ext'.$row['art_post_id'].'">
                    <span class="comment_count">';
                if (count($commnetcount) > 0) {
                    $return_html .= count($commnetcount);
                    $return_html .= '</span>';
                    $return_html .= '<span> Comment</span>';
                }
                

                $return_html .= '</div>
            </li>

            <li>
                <div class="comnt_count_ext_a comnt_count_ext' . $row['art_post_id'].'">
                    <span class="comment_like_count"> ';
                if ($row['art_likes_count'] > 0) {
                    $return_html .= $row['art_likes_count'];
                     $return_html .= '</span>'; 
                    $return_html .= '<span> Like</span>';
                }
               
                 $return_html .=  '</div>
            </li>
        </ul>
    </div>
</div>';
                // if ($row['business_likes_count'] > 0) {
                //     $return_html .= '<div class="likeduserlist1 likeduserlist' . $row['business_profile_post_id'] . '">';
                $return_html .= '<div class="likeduserlist1 likeusername'. $row['art_post_id'].'" id="likeusername'. $row['art_post_id'].'" style="display:block">';
    
                    $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1', 'is_delete' => '0');
                    $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    $likeuser = $commnetcount[0]['art_like_user'];
                    $countlike = $commnetcount[0]['art_likes_count'] - 1;
                    $likelistarray = explode(',', $likeuser);
                    foreach ($likelistarray as $key => $value) {
                        $art_fname1 = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => 1))->row()->art_name;
                        $art_lname1 = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => 1))->row()->art_lastname;
                    }
                    $return_html .= '<a href="javascript:void(0);"  onclick="likeuserlist(' . $row['art_post_id'] . ');">';
                    $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1', 'is_delete' => '0');
                    $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $likeuser = $commnetcount[0]['art_like_user'];
                    $countlike = $commnetcount[0]['art_likes_count'] - 1;
                    $likelistarray = explode(',', $likeuser);

                  $art_fname = $this->db->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => 1))->row()->art_name;
                 $art_lname = $this->db->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => 1))->row()->art_lastname;

                    $return_html .= '<div class="like_one_other">';
                    if (in_array($userid, $likelistarray)) {
                        $return_html .= "You";
                        $return_html .= "&nbsp;";
                    } else {
                        $return_html .= ucfirst(strtolower($art_fname)).' '.ucfirst(strtolower($art_lname));
                        $return_html .= "&nbsp;";
                    }
                    if (count($likelistarray) > 1) {
                        $return_html .= "and".' ';
                        $return_html .= $countlike;
                        $return_html .= "&nbsp;";
                        $return_html .= "others";
                    }
                    $return_html .= '</div>
    </a>
</div>';
                //}


$return_html .= '<div class="art-all-comment col-md-12">
    <div id="fourcomment' . $row['art_post_id'] . '" style="display:none;">
    </div>
    <div  id="threecomment' . $row['art_post_id'] . '" style="display:block">
        <div class="hidebottomborder insertcomment' . $row['art_post_id'] . '">';
                $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1');
                $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = 'artistic_post_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');

                if ($artdata) {
                    foreach ($artdata as $rowdata) {
                        $artname = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->art_name;

                        $artlastname = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->art_lastname;

                         $artslug = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->slug;

                        $return_html .= '<div class="all-comment-comment-box">
                <div class="post-design-pro-comment-img">';
                 $return_html .= '<a href="'.base_url('artistic/dashboard/' . $artslug . '').'">';

                        $art_userimage = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id'], 'status' => 1))->row()->art_user_image; 

                        if ($art_userimage) {

                            if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {

                                $a = $artname;
                                $acr = substr($a, 0, 1);
                                $b = $artlastname;
                                $bcr = substr($b, 0, 1);
                               
                                $return_html .= ' <div class="post-img-div">';
                                $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                $return_html .= '</div> ';

                            } else {
                                
                                $return_html .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage . '"  alt="">';
                            }
                        } else {


                                $a = $artname;
                                $acr = substr($a, 0, 1);
                                $b = $artlastname;
                                $bcr = substr($b, 0, 1);

                                
                                $return_html .= ' <div class="post-img-div">';
                                $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                $return_html .= '</div> ';
                        }

                        $return_html .= '</a>';
                        $return_html .= '</div>
                <div class="comment-name">';
                 $return_html .= '<a href="'.base_url('artistic/dashboard/' . $artslug . '').'">

                    <b>';
                        $return_html .= ucfirst(strtolower($artname)).' '.ucfirst(strtolower($artlastname));
                        $return_html .= '</b>';
                         $return_html .= '</br>';

                $return_html .= '</a></div>
                <div class="comment-details" id= "showcomment' . $rowdata['artistic_post_comment_id'] . '">
                    <div id="lessmore' . $rowdata['artistic_post_comment_id'] . '" style="display:block;">';
                        $small = substr($rowdata['comments'], 0, 180);
                        $return_html .= $this->common->make_links($small);

                        if (strlen($rowdata['comments']) > 180) {
                            $return_html .= '... <span id="kkkk" onClick="seemorediv(' . $rowdata['artistic_post_comment_id'] . ')">View More</span>';
                        }
                        $return_html .= '</div>

                    <div id="seemore' . $rowdata['artistic_post_comment_id'] . '" style="display:none;">';
                        $new_product_comment = $this->common->make_links($rowdata['comments']);
                        $return_html .= nl2br(htmlspecialchars_decode(htmlentities($new_product_comment, ENT_QUOTES, 'UTF-8')));
                        $return_html .= '</div>
                </div>
                <div class="edit-comment-box">
                    <div class="inputtype-edit-comment">

                         <div contenteditable="true"  style="display:none" class="editable_text editav_2 custom-edit" name="'. $rowdata['artistic_post_comment_id'] .'"  id="editcomment' . $rowdata['artistic_post_comment_id'] . '" placeholder="Add a Comment" value= ""  onkeyup="commentedit(' . $rowdata['artistic_post_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $rowdata['comments'] . '</div>

                        <span class="comment-edit-button"><button id="editsubmit' . $rowdata['artistic_post_comment_id'] . '" style="display:none" onClick="edit_comment(' . $rowdata['artistic_post_comment_id'] . ')">Save</button></span>
                    </div>
                </div>
                <div class="art-comment-menu-design"> 
                    <div class="comment-details-menu" id="likecomment1' . $rowdata['artistic_post_comment_id'] . '">
                        <a id="' . $rowdata['artistic_post_comment_id'] . '" onClick="comment_like1(this.id)">';
                        $userid = $this->session->userdata('aileenuser');
                        $contition_array = array('artistic_post_comment_id' => $rowdata['artistic_post_comment_id'], 'status' => '1');
                        $artcommentlike = $this->data['artcommentlike'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                        $likeuserarray = explode(',', $artcommentlike[0]['artistic_comment_like_user']);
                        if (!in_array($userid, $likeuserarray)) {
                            $return_html .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i> ';
                        } else {
                            $return_html .= '<i class="fa fa-thumbs-up main_color" aria-hidden="true"></i>';
                        }
                        $return_html .= '<span>';
                        if ($rowdata['artistic_comment_likes_count']) {
                            $return_html .= $rowdata['artistic_comment_likes_count'];
                        }
                        $return_html .= '</span>
                        </a>
                    </div>';

                        $userid = $this->session->userdata('aileenuser');
                        if ($rowdata['user_id'] == $userid) {
                            $return_html .= '<span role="presentation" aria-hidden="true"> · </span>
                    <div class="comment-details-menu">
                        <div id="editcommentbox' . $rowdata['artistic_post_comment_id'] . '" style="display:block;">
                            <a id="' . $rowdata['artistic_post_comment_id'] . '"   onClick="comment_editbox(this.id)" class="editbox">Edit
                            </a>
                        </div>
                        <div id="editcancle' . $rowdata['artistic_post_comment_id'] . '" style="display:none;">
                            <a id="' . $rowdata['artistic_post_comment_id'] . '" onClick="comment_editcancle(this.id)">Cancel
                            </a>
                        </div>
                    </div>';
                        }
                        $userid = $this->session->userdata('aileenuser');
                        $art_userid = $this->db->get_where('art_post', array('art_post_id' => $rowdata['art_post_id'], 'status' => 1))->row()->user_id;
                        if ($rowdata['user_id'] == $userid || $art_userid == $userid) {
                            $return_html .= '<span role="presentation" aria-hidden="true"> · </span>
                    <div class="comment-details-menu">
                        <input type="hidden" name="post_delete"  id="post_delete' . $rowdata['artistic_post_comment_id'] . '" value= "' . $rowdata['art_post_id'] . '">
                        <a id="' . $rowdata['artistic_post_comment_id'] . '"   onClick="comment_delete(this.id)"> Delete<span class="insertcomment' . $rowdata['artistic_post_comment_id'] . '">
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
    <div class="post-design-proo-img hidden-mob"> ';

    $art_slug = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->slug;

                        $return_html .= '<a href="' . base_url('artistic/dashboard/' . $art_slug) . '">';

                $userid = $this->session->userdata('aileenuser');
                $art_userimage = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->art_user_image;
                $art_name = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->art_name;
                $art_lastname = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->art_lastname;


                
                if ($art_userimage) {

                    if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {

                        $a = $art_name;
                        $acr = substr($a, 0, 1);
                        $b = $art_lastname;
                        $bcr = substr($b, 0, 1);

                        $return_html .= '<div class="post-img-div">';
                        $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                        $return_html .= '</div> ';

                    } else {

                        $return_html .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage . '"  alt="">';
                    }
                } else {


                         $a = $art_name;
                        $acr = substr($a, 0, 1);
                        $b = $art_lastname;
                        $bcr = substr($b, 0, 1);


                        $return_html .= '<div class="post-img-div">';
                        $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                        $return_html .= '</div> ';
                }
                $return_html .= '</a></div>
    <div id="content" class="col-md-12  inputtype-comment cmy_2" >
        <div contenteditable="true" class="editable_text edt_2" name="' . $row['art_post_id'] . '"  id="post_comment' . $row['art_post_id'] . '" placeholder="Add a Comment...." onClick="entercomment(' . $row['art_post_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);"></div>
          <div class="mob-comment">       
                            <button id="' . $row['art_post_id'] . '" onClick="insert_comment(this.id)"><img src="' . base_url('img/send.png') . '">
                            </button>
                        </div>
    </div>';
                $return_html .= form_error('post_comment');
                $return_html .= '<div class="comment-edit-butn  hidden-mob">       
        <button id="' . $row['art_post_id'] . '" onClick="insert_comment(this.id)">Comment</button></div>
</div>
</div>
</div> </div>';
            }
        } else {
            $return_html .= '<div class="art_no_post_avl" id="no_post_avl">
                                <h3> Post</h3>
                                <div class="art-img-nn">
                                    <div class="art_no_post_img">

                                        <img src="' . base_url('img/art-no.png') . '">

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


 public function postnewpage_fourcomment($postid) {

        $userid = $this->session->userdata('aileenuser');

         //if user deactive profile then redirect to artistic/index untill active profile start
         $contition_array = array('user_id'=> $userid,'status' => '0','is_delete'=> '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if($artistic_deactive)
        {
             redirect('artistic/');
        }
     //if user deactive profile then redirect to artistic/index untill active profile End

        //$post_id =  $postid; 
        $post_id = $_POST['art_post_id'];

        // html start

        $contition_array = array('art_post_id' => $post_id, 'status' => '1');
        $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = 'artistic_post_comment_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $fourdata = '<div class="hidebottombordertwo insertcommenttwo' . $post_id . '">';

        if ($artdata) {
            foreach ($artdata as $rowdata) {

                $artname = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->art_name;
                $artlastname = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->art_lastname;

                $artslug = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->slug;


                $fourdata .= '<div class="all-comment-comment-box">';
                
                $fourdata .= '<div class="post-design-pro-comment-img">';
                $fourdata .= '<a href="' . base_url('artistic/dashboard/' . $artslug . '') . '">';
                $art_userimage = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id'], 'status' => 1))->row()->art_user_image;
                if ($art_userimage) {

                    
                    if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                            $a = $artname;
                            $acr = substr($a, 0, 1);
                            $b = $artlastname;
                            $bcr = substr($b, 0, 1);

                                $fourdata .= '<div class="post-img-div">';
                                $fourdata .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                                $fourdata .=  '</div>';


                        } else {
                    $fourdata .= '<img  src="' .ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage . '"  alt="">';
                    }

                    
                } else {


                    //
                          $a = $artname;
                            $acr = substr($a, 0, 1);
                            $b = $artlastname;
                            $bcr = substr($b, 0, 1);

                    $fourdata .= '<div class="post-img-div">';
                    $fourdata .=  ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)); 
                    $fourdata .=  '</div>';


                    
                    //$fourdata .= '<img src="' . base_url(NOIMAGE) . '" alt=""></div>';

                }
                 $fourdata .= '</a>';
                $fourdata .= '</div>';

                $fourdata .= '<div class="comment-name">';
                $fourdata .= '<a href="' . base_url('artistic/dashboard/' . $artslug . '') . '">';

                $fourdata .= '<b>' . ucfirst(strtolower($artname)) . '&nbsp' . ucfirst(strtolower($artlastname)) . '</b></br></a> </div>';
               
                $fourdata .= '<div class="comment-details" id= "showcommenttwo' . $rowdata['artistic_post_comment_id'] . '">';

                $fourdata .= '<div id= "lessmore' . $rowdata['artistic_post_comment_id'] . '"  style="display:block;">';

                    $small = substr($rowdata['comments'], 0, 180);

                $fourdata .= '' . $this->common->make_links($small) . '';

                    // echo $this->common->make_links($small);

                     if (strlen($rowdata['comments']) > 180) {
                         $fourdata .= '... <span id="kkkk" onClick="seemorediv(' . $rowdata['artistic_post_comment_id'] . ')">See More</span>';
                        }

                $fourdata .= '</div>';


                $fourdata .= '<div id= "seemore' . $rowdata['artistic_post_comment_id'] . '"  style="display:none;">';

                $fourdata .= '' . $this->common->make_links($rowdata['comments']) . '</div></div>';

//                $fourdata .= '<textarea  name="' . $rowdata['artistic_post_comment_id'] . '" id="editcommenttwo' . $rowdata['artistic_post_comment_id'] . '" style="display:none" onClick="commentedittwo(this.name)">';
//                $fourdata .= '' . $rowdata['comments'] . '';
//                $fourdata .= '</textarea>';
                $fourdata .= '<div class="edit-comment-box"><div class="inputtype-edit-comment">';
                $fourdata .= '<div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="' . $rowdata['artistic_post_comment_id'] . '"  id="editcommenttwo' . $rowdata['artistic_post_comment_id'] . '" placeholder="Type Message ..." value= ""  onkeyup="commentedittwo(' . $rowdata['artistic_post_comment_id'] .','.$post_id.')" onpaste="OnPaste_StripFormatting(this, event);">' . $rowdata['comments'] . '</div>';
                $fourdata .= '<span class="comment-edit-button"><button id="editsubmittwo' . $rowdata['artistic_post_comment_id'] . '" style="display:none" onClick="edit_commenttwo(' . $rowdata['artistic_post_comment_id'] .','.$post_id.')">Save</button></span>';
//                $fourdata .= '<input type="text" name="' . $rowdata['artistic_post_comment_id'] . '" id="editcommenttwo' . $rowdata['artistic_post_comment_id'] . '" style="display:none" value="' . $rowdata['comments'] . '"  onClick="commentedittwo(this.name)">';
//                $fourdata .= '<button id="editsubmittwo' . $rowdata['artistic_post_comment_id'] . '" style="display:none" onClick="edit_commenttwo(' . $rowdata['artistic_post_comment_id'] . ')">Comment</button>';
                $fourdata .= '</div></div><div class="art-comment-menu-design">';
                $fourdata .= '<div class="comment-details-menu" id="likecomment' . $rowdata['artistic_post_comment_id'] . '">';
                $fourdata .= '<a id="' . $rowdata['artistic_post_comment_id'] . '"   onClick="comment_like(this.id)">';

                $userid = $this->session->userdata('aileenuser');
                $contition_array = array('artistic_post_comment_id' => $rowdata['artistic_post_comment_id'], 'status' => '1');
                $artcommentlike = $this->data['artcommentlike'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                $likeuserarray = explode(',', $artcommentlike[0]['artistic_comment_like_user']);

                if (!in_array($userid, $likeuserarray)) {
                    $fourdata .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>';
                } else {
                    $fourdata .= '<i class="fa fa-thumbs-up main_color" aria-hidden="true"></i>';
                }

                $fourdata .= '<span> ';
                if ($rowdata['artistic_comment_likes_count']) {
                    $fourdata .= '' . $rowdata['artistic_comment_likes_count'] . '';
                }
                $fourdata .= '</span></a></div>';

                $userid = $this->session->userdata('aileenuser');
                if ($rowdata['user_id'] == $userid) {

                    $fourdata .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $fourdata .= '<div class="comment-details-menu">';
                    $fourdata .= '<div id="editcommentboxtwo' . $rowdata['artistic_post_comment_id'] . '" style="display:block;">';
                    $fourdata .= '<a id="' . $rowdata['artistic_post_comment_id'] . '"   onClick="comment_editboxtwo(this.id,'.$post_id.')" class="editbox">Edit</a> </div>';
                    $fourdata .= '<div id="editcancletwo' . $rowdata['artistic_post_comment_id'] . '" style="display:none;">';
                    $fourdata .= '<a id="' . $rowdata['artistic_post_comment_id'] . '" onClick="comment_editcancletwo(this.id,'.$post_id.')">Cancel</a></div></div>';
                }
                $userid = $this->session->userdata('aileenuser');
                $art_userid = $this->db->get_where('art_post', array('art_post_id' => $rowdata['art_post_id'], 'status' => 1))->row()->user_id;
                if ($rowdata['user_id'] == $userid || $art_userid == $userid) {
                    $fourdata .= '<span role="presentation" aria-hidden="true"> · </span>';
                    $fourdata .= '<div class="comment-details-menu">';
                    $fourdata .= '<input type="hidden" name="post_delete"  id="post_deletetwo" value= "' . $rowdata['art_post_id'] . '">';
                    $fourdata .= '<a id="' . $rowdata['artistic_post_comment_id'] . '"';
                    //$fourdata .= 'onClick="comment_deletetwo(this.id)"> Delete <span class="insertcommenttwo' . $rowdata['artistic_post_comment_id'] . '">';
                    $fourdata .= 'onClick="comment_deletetwo(this.id)"> Delete';
                    $fourdata .= '</span> </a> </div>';
                }
                $fourdata .= '<span role="presentation" aria-hidden="true"> · </span>';
                $fourdata .= '<div class="comment-details-menu">  <p>';
                $fourdata .= '' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($rowdata['created_date']))) . '</br></p></div>';
                $fourdata .= '</div></div>';
            }
        } else {
            $fourdata = 'No comments Available!!!</div>';
        }
        echo $fourdata;
    }

    // for search function start

     public function artistic_search_keyword($id = "") {
       
        $searchTerm = $_GET['term'];
        if (!empty($searchTerm)) {
        
       
       $contition_array = array('status' => '1', 'is_delete' => '0', 'art_step' => '4');
        $search_condition = "(art_name LIKE '" . trim($searchTerm) . "%' OR art_lastname LIKE '" . trim($searchTerm) . "%' OR designation LIKE '" . trim($searchTerm) . "%'OR other_skill LIKE '" . trim($searchTerm) . "%')";
        $artistic_postdata = $this->common->select_data_by_search('art_reg', $search_condition,$contition_array, $data = 'art_name,art_lastname,designation,other_skill', $sortby = 'art_name,art_lastname,designation,other_skill', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = 'art_name,art_lastname,designation,other_skill');

        $contition_array = array('status' => '1', 'type' => '2');
        $search_condition = "(skill LIKE '" . trim($searchTerm) . "%')";
        $skill = $this->common->select_data_by_search('skill', $search_condition, $contition_array, $data = 'skill', $sortby = 'skill', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = 'skill');
        }
        $unique = array_merge($skill, $artistic_postdata);
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
        $result1 = array_values($result1);

        echo json_encode($result1);
    }
public function artistic_search_city($id = "") {
    $searchTerm = $_GET['term'];
     if (!empty($searchTerm)) {
        $contition_array = array('status' => '1', 'state_id !=' => '0');
        $search_condition = "(city_name LIKE '" . trim($searchTerm) . "%')";
        $location_list = $this->common->select_data_by_search('cities', $search_condition,$contition_array, $data = 'city_name', $sortby = 'city_name', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = 'city_name');
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
   
 

 // profile image uplaod usingajax start

   public function profilepic1(){


         $userid = $this->session->userdata('aileenuser');

        $config = array(
            'upload_path' => $this->config->item('art_profile_main_upload_path'),
            'max_size' => $this->config->item('art_profile_main_max_size'),
            'allowed_types' => $this->config->item('art_profile_main_allowed_types'),
            'file_name' => $_FILES['profilepic']['name']
               
        );


        $images = array();
        

        $files = $_FILES;
       
        $this->load->library('upload');

            $fileName = $_FILES['image']['name'];
            $images[] = $fileName;
            $config['file_name'] = $fileName;

         $this->upload->initialize($config);
        $this->upload->do_upload();

            
        if ($this->upload->do_upload('image')) {
           // echo "hi"; die();

            // $uploadData = $this->upload->data();

            // $picture = $uploadData['file_name'];

             $response['result']= $this->upload->data();
            // echo "<pre>"; print_r($response['result']); die();
                $art_post_thumb['image_library'] = 'gd2';
                $art_post_thumb['source_image'] = $this->config->item('art_profile_main_upload_path') . $response['result']['file_name'];
                $art_post_thumb['new_image'] = $this->config->item('art_profile_thumb_upload_path') . $response['result']['file_name'];
                $art_post_thumb['create_thumb'] = TRUE;
                $art_post_thumb['maintain_ratio'] = TRUE;
                $art_post_thumb['thumb_marker'] = '';
                $art_post_thumb['width'] = $this->config->item('art_profile_thumb_width');
                //$product_thumb[$i]['height'] = $this->config->item('product_thumb_height');
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

      
        } 

       

  //      //echo "<pre>"; print_r($dataimage); die();

        //if ($dataimage) {
            $data = array(
                'art_user_image' => $dataimage,
                'modified_date' => date('Y-m-d', time())
               
            );

            $updatdata = $this->common->update_data($data, 'art_reg', 'user_id', $userid);


      $contition_array = array('user_id'=> $userid,'status' => '1','is_delete'=> '0');

        $artistic_user = $this->data['artistic_user'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);


        //echo "<pre>"; print_r($artistic_user); die();
            $userimage .= '<img src="'.ART_PROFILE_THUMB_UPLOAD_URL . $artistic_user[0]['art_user_image'].'" alt="" >';

            $userimage.= '<a href="javascript:void(0);" onclick="updateprofilepopup();"><i class="fa fa-camera" aria-hidden="true"></i> Update Profile Picture</a>';

            echo  $userimage;
           

    }



    public function profilepic() {
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'status' => '1', 'is_delete'=> '0');
        $user_reg_data = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $user_reg_prev_image = $user_reg_data[0]['art_user_image'];

        if ($user_reg_prev_image != '') {
            $user_image_main_path = $this->config->item('art_profile_main_upload_path');
            $user_bg_full_image = $user_image_main_path . $user_reg_prev_image;
            if (isset($user_bg_full_image)) {
                unlink($user_bg_full_image);
            }

            $user_image_thumb_path = $this->config->item('art_profile_thumb_upload_path');
            $user_bg_thumb_image = $user_image_thumb_path . $user_reg_prev_image;
            if (isset($user_bg_thumb_image)) {
                unlink($user_bg_thumb_image);
            }
        }


        $data = $_POST['image'];
        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);
        $user_bg_path = $this->config->item('art_profile_main_upload_path');
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


        // /* RESIZE */
        // $artistic_profile['image_library'] = 'gd2';
        // $artistic_profile['source_image'] =  $main_image;
        // $artistic_profile['new_image'] =  $main_image;
        // $artistic_profile['quality'] = $quality;
        // $instanse10 = "image10";
        // $this->load->library('image_lib', $artistic_profile, $instanse10);
        // $this->$instanse10->watermark();
        // /* RESIZE */

        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
        $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);

        $user_thumb_path = $this->config->item('art_profile_thumb_upload_path');
        $user_thumb_width = $this->config->item('art_profile_thumb_width');
        $user_thumb_height = $this->config->item('art_profile_thumb_height');

        $upload_image = $user_bg_path . $imageName;

        $thumb_image_uplode = $this->thumb_img_uplode($upload_image, $imageName, $user_thumb_path, $user_thumb_width, $user_thumb_height);

        $thumb_image = $user_thumb_path . $imageName;
        $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);

        $data = array(
            'art_user_image' => $imageName,
            'modified_date' => date('Y-m-d', time())
        );

        $update = $this->common->update_data($data, 'art_reg', 'user_id', $userid);
        //  echo "11111";die();

        if ($update) {

            $contition_array = array('user_id' => $userid, 'status' => '1', 'is_delete' => '0');
            $artistic_user = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
            $userimage .= '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $artistic_user[0]['art_user_image'] . '" alt="" >';
            $userimage .= '<a href="javascript:void(0);" onclick="updateprofilepopup();"><i class="fa fa-camera" aria-hidden="true"></i>';
            $userimage .= 'Update Profile Picture';
            $userimage .= '</a>';

            echo $userimage;
        }
    }
//Get artistic Name for title Start
public function get_artistic_name($id=''){

        $userid = $this->session->userdata('aileenuser');
       
        $contition_array = array('user_id' => $userid, 'status' => '1', 'is_delete' => '0');
        $artdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_name,art_lastname', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
       
        return $artistic_name = $artdata[0]['art_name'].' '.$artdata[0]['art_lastname'];    
    }
//Get Job Seeker Name for title End


    //for search code start

    public function search() {
        //echo "test sucessfull";
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');


        $contition_array = array('user_id' => $userid, 'status' => '1', 'art_step' => '4');
        $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        
        if ($this->input->get('searchplace') == "" && $this->input->get('skills') == "") {
            redirect('artistic/art_post', refresh);

            // $abc[] = $results;
            // $this->data['falguni'] = 1;        
        }

//         // Retrieve the posted search term.
//        //echo "<pre>";print_r($_POST);die();
        $searchskill = trim($this->input->get('skills'));
        $this->data['keyword'] = $searchskill;


        // echo $searchskill; die();
        //$searchskill = explode(',',$search_skill);
        //echo"<pre>";print_r($searchskill);die();
        $search_place = trim($this->input->get('searchplace'));
//insert search keyword into data base code start

        $cache_time = $this->db->get_where('cities', array('city_name' => $search_place))->row()->city_id;

        $this->data['keyword1'] = $search_place;

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $this->data['city'] = $city = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_city', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        //echo "hi"; die();
        if($this->session->userdata('aileenuser')){
        $data = array(
            'search_keyword' => $searchskill,
            'search_location' => $search_place,
            'user_location' => $city[0]['art_city'],
            'user_id' => $userid,
            'created_date' => date('Y-m-d h:i:s', time()),
            'status' => 1,
            'module'=>'6'
        );

        // echo"<pre>"; print_r($data); die();

        $insert_id = $this->common->insert_data_getid($data, 'search_info');
       }
//insert search keyword into data base code end

        if ($searchskill == "") {
            $contition_array = array('art_city' => $cache_time, 'status' => '1', 'art_step' => 4);
            $new = $this->data['results'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } elseif ($search_place == "") {


            // $temp = $this->db->get_where('skill', array('skill' => $search_skill, 'status' => 1, 'type' => '2'))->row()->skill_id;

             $contition_array = array('status' => 1, 'type' => '2');

            $search_condition = "(skill LIKE '%$searchskill%')";
            // echo $search_condition;
            $temp = $this->common->select_data_by_search('skill', $search_condition, $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            //echo "<pre>"; print_r($temp); die();

            foreach ($temp as $keytemp => $valuetemp) {
               
          
            $contition_array = array('status' => '1', 'is_delete' => '0', 'art_step' => 4,  'FIND_IN_SET("' . $valuetemp['skill_id'] . '", art_skill) != ' => '0');
            $artskill[] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            }
            //echo "<pre>"; print_r($artskillpost); die();
            $artskillpost = array_reduce($artskill, 'array_merge', array());
            //$artskillpost = array_unique($result, SORT_REGULAR);                

            //echo "<pre>"; print_r($artskillpost); die();
            

            $contition_array = array('art_reg.is_delete' => '0', 'art_reg.status' => '1', 'art_step' => 4);

            $search_condition = "(designation LIKE '%$searchskill%' or other_skill LIKE '%$searchskill%' or art_name LIKE '%$searchskill%' or art_lastname LIKE '%$searchskill%' or art_yourart LIKE '%$searchskill%' or concat(art_name,' ',art_lastname) LIKE '%$searchskill%')";
            // echo $search_condition;
            $otherdata = $other['data'] = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            //echo "<pre>"; print_r($otherdata); die();

            foreach ($otherdata as $postdata) { //echo "<pre>"; print_r($postdata); die();
               
            $join_str[0]['table'] = 'art_reg';
            $join_str[0]['join_table_id'] = 'art_reg.user_id';
            $join_str[0]['from_table_id'] = 'art_post.user_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('art_post.is_delete' => '0', 'art_post.user_id' => $postdata['user_id']);

            $artpostone[] = $this->data['artpostone'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = 'art_post_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str, $groupby = '');
            //echo "<pre>"; print_r($artpostone); die();

            }
            foreach ($artpostone as $keyone => $valueone) {
               
               foreach ($valueone as $keytwo => $valuetwo) {
                   $posttwo[] = $valuetwo;
               }
            } 
            //echo "<pre>"; print_r($posttwo); die();

            $join_str[0]['table'] = 'art_reg';
            $join_str[0]['join_table_id'] = 'art_reg.user_id';
            $join_str[0]['from_table_id'] = 'art_post.user_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('art_reg.art_step' => 4, 'art_post.is_delete' => '0','art_reg.is_delete' => '0', 'art_reg.status' => '1');

            $search_condition = "(art_post.art_post LIKE '%$searchskill%' or art_post.art_description LIKE '%$searchskill%' or art_post.other_skill LIKE '%$searchskill%' or art_reg.designation LIKE '%$searchskill%' or art_reg.other_skill LIKE '%$searchskill%')";


            $artposttwo = $artpostdata['data'] = $this->common->select_data_by_search('art_post', $search_condition, $contition_array, $data = 'art_post.*,art_reg.*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

                 $unique = array_merge($artskillpost, $otherdata);
                 $new = array_unique($unique, SORT_REGULAR);
                // echo "<pre>"; print_r($new); die();

                if (count($artposttwo) == 0) {
                    $uniquedata = $posttwo;
                } else {
                    $uniquedata = array_merge($artposttwo, $posttwo);
                }
                $artpost = array_unique($uniquedata, SORT_REGULAR);                
//echo "<pre>"; print_r($artpost); die();

        } else {
            // echo "both";


             $temp = $this->db->get_where('skill', array('skill' => $search_skill, 'status' => 1, 'type' => '2'))->row()->skill_id;
            $contition_array = array('status' => '1', 'is_delete' => '0', 'art_city' => $cache_time, 'art_step' => 4,  'FIND_IN_SET("' . $temp . '", art_skill) != ' => '0');
            $artskillpost = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            

            

            $contition_array = array('is_delete' => '0', 'status' => '1', 'art_city' => $cache_time, 'art_step' => 4);

            $search_condition = "(designation LIKE '%$searchskill%' or other_skill LIKE '%$searchskill%' or art_name LIKE '%$searchskill%' or art_lastname LIKE '%$searchskill%'or concat(art_name,' ',art_lastname) LIKE '%$searchskill%')";

            $otherdata = $other['data'] = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
             //echo "<pre>"; print_r($otherdata); die();

            foreach ($otherdata as $postdata) { //echo "<pre>"; print_r($postdata); die();
               
            $join_str[0]['table'] = 'art_reg';
            $join_str[0]['join_table_id'] = 'art_reg.user_id';
            $join_str[0]['from_table_id'] = 'art_post.user_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('art_post.is_delete' => '0', 'art_post.user_id' => $postdata['user_id']);

            $artpostone[] = $this->data['artpostone'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = 'art_post_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str, $groupby = '');
            //echo "<pre>"; print_r($artpostone); die();

            }
            foreach ($artpostone as $keyone => $valueone) {
               
               foreach ($valueone as $keytwo => $valuetwo) {
                   $posttwo[] = $valuetwo;
               }
            } 


            $join_str[0]['table'] = 'art_reg';
            $join_str[0]['join_table_id'] = 'art_reg.user_id';
            $join_str[0]['from_table_id'] = 'art_post.user_id';
            $join_str[0]['join_type'] = '';

            $search_condition = "(art_post.art_post LIKE '%$searchskill%' or art_post.art_description LIKE '%$searchskill%' or art_post.other_skill LIKE '%$searchskill%')";


            $contition_array = array('art_reg.art_city' => $cache_time, 'art_reg.art_step' => 4, 'art_post.is_delete' => '0');
            $artposttwo = $artpostdata['data'] = $this->common->select_data_by_search('art_post', $search_condition, $contition_array, $data = 'art_post.*,art_reg.art_name,art_reg.art_lastname,art_reg.art_user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
            // echo "<pre>"; print_r($artpost);

           

           
                $unique = array_merge($artskillpost, $otherdata);
              

                $new = array_unique($unique, SORT_REGULAR);

                if (count($artposttwo) == 0) {
                    $uniquedata = $posttwo;
                } else {
                    $uniquedata = array_merge($artposttwo, $posttwo);
                }
                $artpost = array_unique($uniquedata, SORT_REGULAR);  

        }


        $this->data['artuserdata'] = $new;

        $this->data['artpostdata'] = $artpost;

              $title = '';
        if ($searchskill) {
            $title .= $searchskill;
        }
        if ($searchskill && $search_place) {
            $title .= ' Art in ';
        }
        if ($search_place) {
            $title .= $search_place;
        }
        $this->data['title'] = "$title | Aileensoul";
        $this->data['head'] = $this->load->view('head', $this->data, TRUE);
         $this->data['left_artistic'] =  $this->load->view('artistic/left_artistic', $this->data, true);
        
          if ($this->session->userdata('aileenuser')) { //echo "h1"; die();
        $this->load->view('artistic/recommen_candidate', $this->data);
        }else{ //echo "h145"; die();
            $this->load->view('artistic/user_search', $this->data);

        }
       
    }



    public function ajax_artistic_search() {

        
   $this->data['userid'] = $userid = $this->session->userdata('aileenuser');


        $contition_array = array('user_id' => $userid, 'status' => '1', 'art_step' => '4');
       $artdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        
        if ($this->input->get('searchplace') == "" && $this->input->get('skills') == "") {
            redirect('artistic/art_post', refresh);

            // $abc[] = $results;
            // $this->data['falguni'] = 1;        
        }

//         // Retrieve the posted search term.
//        //echo "<pre>";print_r($_POST);die();
        $searchskill = strtolower(trim($this->input->get('skills')));
        $this->data['keyword'] = $searchskill;


        // echo $searchskill; die();
        //$searchskill = explode(',',$search_skill);
        //echo"<pre>";print_r($searchskill);die();
        $search_place = trim($this->input->get('searchplace'));
//insert search keyword into data base code start

        $cache_time = $this->db->get_where('cities', array('city_name' => $search_place))->row()->city_id;

        $this->data['keyword1'] = $search_place;

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $this->data['city'] = $city = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_city', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        //echo "hi"; die();
        $data = array(
            'search_keyword' => $searchskill,
            'search_location' => $search_place,
            'user_location' => $city[0]['art_city'],
            'user_id' => $userid,
            'created_date' => date('Y-m-d h:i:s', time()),
            'status' => 1,
            'module'=>'6'
        );

        // echo"<pre>"; print_r($data); die();

        $insert_id = $this->common->insert_data_getid($data, 'search_info');
//insert search keyword into data base code end

        if ($searchskill == "") {
            $contition_array = array('art_city' => $cache_time, 'status' => '1', 'art_step' => 4);
            $new = $this->data['results'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } elseif ($search_place == "") {


            $contition_array = array('status' => 1, 'type' => '2');

            $search_condition = "(skill LIKE '%$searchskill%')";
            // echo $search_condition;
            $temp = $this->common->select_data_by_search('skill', $search_condition, $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            //echo "<pre>"; print_r($temp); die();

            foreach ($temp as $keytemp => $valuetemp) {
               
          
            $contition_array = array('status' => '1', 'is_delete' => '0', 'art_step' => 4,  'FIND_IN_SET("' . $valuetemp['skill_id'] . '", art_skill) != ' => '0');
            $artskill[] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            }
            //echo "<pre>"; print_r($artskillpost); die();
            $artskillpost = array_reduce($artskill, 'array_merge', array());
            
        
            $contition_array = array('art_reg.is_delete' => '0', 'art_reg.status' => '1', 'art_step' => 4);

            $search_condition = "(art_name LIKE '%$searchskill%' or art_lastname LIKE '%$searchskill%' or designation LIKE '%$searchskill%' or other_skill LIKE '%$searchskill%' or  art_yourart LIKE '%$searchskill%' or concat(art_name,' ',art_lastname) LIKE '%$searchskill%')";
            // echo $search_condition;
            $othercom = $other['data'] = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
           // echo "<pre>"; print_r($othercom); die();

            foreach ($othercom as $keydata => $valuedata) {

                $concatedata = $valuedata['art_name']. ' '.$valuedata['art_lastname'];
                //echo $concatedata; 

               if($valuedata['art_name'] == $searchskill || $valuedata['art_lastname'] == $searchskill || $concatedata == $searchskill || $valuedata['art_yourart'] == $searchskill)
               {
                $varfoune[] = $valuedata; 
               }else{
                $varfoune2[] = $valuedata; 
               }
            }
            if($varfoune){

                $otherdata = $varfoune;

            }elseif($varfoune2){
                $otherdata = $varfoune2;

            }else{
            $otherdata = array_merge($varfoune, $varfoune2);

            }
            //echo "<pre>"; print_r($otherdata); die();
            


            foreach ($otherdata as $postdata) { //echo "<pre>"; print_r($postdata); die();
               
            $join_str[0]['table'] = 'art_reg';
            $join_str[0]['join_table_id'] = 'art_reg.user_id';
            $join_str[0]['from_table_id'] = 'art_post.user_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('art_post.is_delete' => '0', 'art_post.user_id' => $postdata['user_id']);

            $artpostone[] = $this->data['artpostone'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = 'art_post.*, art_reg.art_id, art_reg.art_name, art_reg.art_lastname, art_reg.art_email, art_reg.art_user_image, art_reg.designation, art_reg.user_id', $sortby = 'art_post_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str, $groupby = '');
           

            }//echo "<pre>"; print_r($artpostone); die();
            foreach ($artpostone as $keyone => $valueone) {
               
               foreach ($valueone as $keytwo => $valuetwo) {
                   $posttwo[] = $valuetwo;
               }
            } 
            //echo "<pre>"; print_r($posttwo); die();

            $join_str[0]['table'] = 'art_reg';
            $join_str[0]['join_table_id'] = 'art_reg.user_id';
            $join_str[0]['from_table_id'] = 'art_post.user_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('art_reg.art_step' => 4, 'art_post.is_delete' => '0','art_reg.is_delete' => '0', 'art_reg.status' => '1');

            $search_condition = "(art_post.art_post LIKE '%$searchskill%' or art_post.art_description LIKE '%$searchskill%' or art_post.other_skill LIKE '%$searchskill%' or art_reg.designation LIKE '%$searchskill%' or art_reg.other_skill LIKE '%$searchskill%')";


            $artposttwo = $artpostdata['data'] = $this->common->select_data_by_search('art_post', $search_condition, $contition_array, $data = 'art_post.*,art_reg.*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

                 
                 if($artskillpost){
                 $unique = array_merge($artskillpost, $otherdata);
                }else{
                    $unique = $otherdata;
                }
                 //echo "<pre>"; print_r($unique); die();
                 $new = array_unique($unique, SORT_REGULAR);


                if (count($artposttwo) == 0) {
                    $uniquedata = $posttwo;
                } else if(count($posttwo) == 0){
                    $uniquedata = $artposttwo;

                }else{
                    $uniquedata = array_merge($artposttwo, $posttwo);
                }
                
                $artpost = array_unique($uniquedata, SORT_REGULAR);                
//echo "<pre>"; print_r($artpost); die();

        } else {
            // echo "both";


             $temp = $this->db->get_where('skill', array('skill' => $search_skill, 'status' => 1, 'type' => '2'))->row()->skill_id;
            $contition_array = array('status' => '1', 'is_delete' => '0', 'art_city' => $cache_time, 'art_step' => 4,  'FIND_IN_SET("' . $temp . '", art_skill) != ' => '0');
            $artskillpost = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            

            

            $contition_array = array('is_delete' => '0', 'status' => '1', 'art_city' => $cache_time, 'art_step' => 4);

            $search_condition = "(designation LIKE '%$searchskill%' or other_skill LIKE '%$searchskill%' or art_name LIKE '%$searchskill%' or art_lastname LIKE '%$searchskill%'or concat(art_name,' ',art_lastname) LIKE '%$searchskill%')";

            $othercom = $other['data'] = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
             //echo "<pre>"; print_r($otherdata); die();


            foreach ($othercom as $keydata => $valuedata) {

                $concatedata = $valuedata['art_name']. ' '.$valuedata['art_lastname'];
                //echo $concatedata; 

               if($valuedata['art_name'] == $searchskill || $valuedata['art_lastname'] == $searchskill || $concatedata == $searchskill || $valuedata['art_yourart'] == $searchskill)
               {
                $varfoune[] = $valuedata; 
               }else{
                $varfoune2[] = $valuedata; 
               }
            }
            if($varfoune){

                $otherdata = $varfoune;

            }elseif($varfoune2){
                $otherdata = $varfoune2;

            }else{
            $otherdata = array_merge($varfoune, $varfoune2);

            }


            foreach ($otherdata as $postdata) { //echo "<pre>"; print_r($postdata); die();
               
            $join_str[0]['table'] = 'art_reg';
            $join_str[0]['join_table_id'] = 'art_reg.user_id';
            $join_str[0]['from_table_id'] = 'art_post.user_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('art_post.is_delete' => '0', 'art_post.user_id' => $postdata['user_id']);

            $artpostone[] = $this->data['artpostone'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = 'art_post.*, art_reg.art_id, art_reg.art_name, art_reg.art_lastname, art_reg.art_email, art_reg.art_user_image, art_reg.designation, art_reg.user_id', $sortby = 'art_post_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str, $groupby = '');
            //echo "<pre>"; print_r($artpostone); die();

            }
            foreach ($artpostone as $keyone => $valueone) {
               
               foreach ($valueone as $keytwo => $valuetwo) {
                   $posttwo[] = $valuetwo;
               }
            } 


            $join_str[0]['table'] = 'art_reg';
            $join_str[0]['join_table_id'] = 'art_reg.user_id';
            $join_str[0]['from_table_id'] = 'art_post.user_id';
            $join_str[0]['join_type'] = '';

            $search_condition = "(art_post.art_post LIKE '%$searchskill%' or art_post.art_description LIKE '%$searchskill%' or art_post.other_skill LIKE '%$searchskill%')";


            $contition_array = array('art_reg.art_city' => $cache_time, 'art_reg.art_step' => 4, 'art_post.is_delete' => '0');
            $artposttwo = $artpostdata['data'] = $this->common->select_data_by_search('art_post', $search_condition, $contition_array, $data = 'art_post.*,art_reg.art_name,art_reg.art_lastname,art_reg.art_user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
            // echo "<pre>"; print_r($artpost);

           

           
               if($artskillpost){
                 $unique = array_merge($artskillpost, $otherdata);
                }else{
                    $unique = $otherdata;
                }
              

                $new = array_unique($unique, SORT_REGULAR);

                if (count($artposttwo) == 0) {
                    $uniquedata = $posttwo;
                } else {
                    $uniquedata = array_merge($artposttwo, $posttwo);
                }
                $artpost = array_unique($uniquedata, SORT_REGULAR);  

        }


        $artuserdata = $this->data['artuserdata'] = $new;

        $artpostdata = $this->data['artpostdata'] = $artpost;

        //AJAX DATA
        $return_html = '';
        
                $return_html .= '<div class="profile-job-post-title-inside clearfix" style="">';


                     // user list start 
                      if (count($artuserdata) > 0)
                          { 
                        $return_html .= '<div class="profile_search" style="background-color: white; margin-bottom: 10px; margin-top: 10px;">
                           <h4 class="search_head">Profiles</h4>
                           <div class="inner_search">';
      
                              foreach ($artuserdata as $key) {
                                if($key['art_id']){

                             $return_html .=  '<div class="profile-job-profile-button clearfix box_search_module">
                                 <div class="profile-job-post-location-name-rec">
                                    <div class="module_Ssearch" style="display: inline-block; float: left;">
                                       <div class="search_img" style="height: 110px; width: 108px;">';
                                          if($key['art_user_image']){
                           $return_html .= '<img src="'.ART_PROFILE_THUMB_UPLOAD_URL . $key['art_user_image'].'" alt=" ">';
                                 }else{
                           
                                             $a = $key['art_name'];
                                              $acr = substr($a, 0, 1);
                                              $b = $key['art_lastname'];
                                              $bcr = substr($b, 0, 1);
                                       
                                     $return_html .=  '<div class="post-img-profile">';
                                             $return_html .=  ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                         $return_html .=  '</div>';
                                       }
                                       $return_html .= '</div>
                                    </div>
                                    <div class="designation_rec">
                                       <ul>
                                          <li >
                                             <a style="  font-size: 19px;font-weight: 600;" href="'.base_url('artistic/dashboard/' . $key['slug'] . '').'" title="'.$key['art_name'].' '.$key['art_lastname'].'">'.ucfirst(strtolower($key['art_name'])).' '.ucfirst(strtolower($key['art_lastname'])).'</a>
                                          </li>
                                          <li style="display: block;">
                                             <a  class="color-search" href="'.base_url('artistic/dashboard/' . $key['slug'] . '').'">';
                                                 if($key['designation']){
                                                    $return_html .= $key['designation'];
                                                } else{
                                                   $return_html .= 'Current work';
                                                } 
                                             $return_html .= '</a>
                                          </li>
                                          <li style="display: block;">';
                                                            
                                                   $aud = $key['art_skill'];
                                                   $aud_res = explode(',', $aud);
                                                   $skill1 = array();
                                                   foreach ($aud_res as $skdata) {
                                                     $cache_time = $this->db->get_where('skill', array('skill_id' => $skdata))->row()->skill;
                                                     $skill1[] = $cache_time;
                                                     }
                                                  $listFinal = implode(', ', $skill1);
                                                  if($listFinal && $key['other_skill']){ 

                                                     $return_html .= $listFinal . ',' . $key['other_skill'];
                                                  }
                                                       elseif(!$listFinal){ 

                                                      $return_html .= $key['other_skill']; 

                                                  }else if(!$key['other_skill']){
                                                   $return_html .= $listFinal;  
                                                }    
     
                                         $return_html .=  '</li>
                                          <li style="display: block;">
                                             <a  class="color-search" href="">';
                                              $country = $this->db->get_where('countries', array('country_id' => $key['art_country']))->row()->country_name;
                                               $city = $this->db->get_where('cities', array('city_id' => $key['art_city']))->row()->city_name;
                                                
                                              if(!$country){ 
                                               $return_html .= $city;
                                                 }else if(!$city){ 
                                               $return_html .= $country;
                                              }else{
                                                $return_html .= $city.",".$country;
                                                } 
                        $return_html .= '</a>
                                          </li>
                                          <li style="display: block;">
                                             <a title="" class="color-search websir-se" href="" target="_blank"> </a>
                                          </li>
                                          <input type="hidden" name="search" id="search" value="zalak">
                                       </ul>
                                    </div>';

                                 // follow meassge div start 
                                   
                            $userid = $this->session->userdata('aileenuser');
                            if($key['user_id'] == $userid){}else{
                                    $return_html .= '<div class="fl search_button">
                                       <div class="fruser' . $key['art_id'].'">';

                                         $status  =  $this->db->get_where('follow',array('follow_type' => 1, 'follow_from' => $artdata[0]['art_id'], 'follow_to'=>$key['art_id'] ))->row()->follow_status; 
                                            if($status == 0 || $status == " "){

                                 $return_html .= '<div id="followdiv " class="user_btn">
                                            <button id="follow' . $key['art_id'].'" onClick="followuser('.$key['art_id'].')">
                                            <span>Follow</span> 
                                             </button>
                                          </div>';
                                           } elseif($status == 1){ 

                                          $return_html .= '<div id= "unfollowdiv"  class="user_btn" > 
                                         <button class="bg_following" id="unfollow' . $key['art_id'].'" onClick="unfollowuser('.$key['art_id'].') ">
                                       <span>   Following </span>
                                        </button></div>';

                                           }
                                       $return_html .= '</div>
                                       <a href = "' . base_url('chat/abc/6/6/' . $key['user_id']) .'"> Message</a>
                                    </div>';
                                    }
                                   // follow meassge div end 
                                 $return_html .=  '</div>
                              </div>';

                               } } 
                           $return_html .= '</div>
                        </div>';
                         }
                          // user list end 

                           // user post start 

                    if($artpostdata){

                       $return_html .= '<div class="col-md-12 profile_search " style="float: left; background-color: white; margin-top: 10px; margin-bottom: 10px; padding:0px!important;">
                           <h4 class="search_head">Posts</h4>
                           <div class="inner_search search inner_search_2" style="float: left;">';

                           // loop start for post 
                           foreach ($artpostdata as $key) {
                             
                              $return_html .= '<div id="removepost'. $key['art_post_id'].'">
                              <div class="col-md-12 col-sm-12 post-design-box"  style="box-shadow: none; ">
                                 <div class="post_radius_box">
                                    <div class="post-design-search-top col-md-12" style="background-color: none!important;">
                                       <div class="post-design-pro-img ">
                                            
                                          <a class="post_dot" href="'.base_url('artistic/dashboard/' . $key['slug'] . '').'" title="'.$key['art_name'].' '.$key['art_lastname'].'">';
                                           if($key['art_user_image']){

                                            $return_html .= '<img src="'. ART_PROFILE_THUMB_UPLOAD_URL . $key['art_user_image'].'" alt="">';
                                                   }else{
                                                   
                                                    $a = $key['art_name'];
                                                    $acr = substr($a, 0, 1);
                                                    $b = $key['art_lastname'];
                                                    $bcr = substr($b, 0, 1);
                                                   
                                            $return_html .= '<div class="post-img-div">
                                                    '.ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)).'
                                                    </div>';
                                           }
                                        $return_html .= '</a>
                                       </div>
                                       <div class="post-design-name col-xs-8 fl col-md-10">
                                          <ul>
                                             <li>
                                             </li>
                                           
                                             <li>
                                                <div class="post-design-product">
                                                   <a class="post_dot" href="'.base_url('artistic/dashboard/' . $key['slug'] . '').'" title="'.$key['art_name'].' '.$key['art_lastname'].'" >'.ucfirst(strtolower($key['art_name'])).' '.ucfirst(strtolower($key['art_lastname'])).'
                                                   </a>
                                                   <span role="presentation" aria-hidden="true"> · </span>
                                                   <div class="datespan"> 
                                                      <span style="font-weight: 400; font-size: 14px; color: #91949d; cursor: default;">'; 
                                                $return_html .= $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($key['created_date'])));  
                                                     $return_html .= '</span>
                                                   </div>
                                                </div>
                                             </li>
                                             <li>
                                                <div class="post-design-product" id="editpostdata' . $key['art_post_id'].'" >
                                                   <a href="javascript:void(0);" style=" color: #000033; font-weight: 400; cursor: default;" title="" id="editpostval' . $key['art_post_id'].'">';
                                                   $return_html .= $this->common->make_links($key['art_post']);
                                                   $return_html .= '</a>
                                                </div>
                                             </li>
                                             <li>
                                             </li>
                                          </ul>
                                       </div>
                                       <div class="dropdown1">
                                               <a  class="  dropbtn1 fa fa-ellipsis-v"></a>
                                                  <div id="myDropdown'.$key['art_post_id'].'" class="dropdown-content1 ">';
                                                            
                                                            if ($key['posted_user_id'] != 0) {

                                                            if ($this->session->userdata('aileenuser') == $key['posted_user_id']) {
                                                                       
                                            $return_html .= '<a id="'.$key['art_post_id'].'" onClick="deleteownpostmodel(this.id)"><span class="h4-img h2-srrt"></span>Delete Post</a>
                                                          <a id="'.$key['art_post_id'].'" onClick="editpost(this.id)"><span class="h3-img h2-srrt"></span>Edit</a>';

                                                           } else {
                                            $return_html .= '<a id="'.$key['art_post_id'].'" onClick="deletepostmodel(this.id)"><span class="h4-img h2-srrt"></span>Delete Post</a>';
                                                           } }else{
                                                          
                                                              $userid = $this->session->userdata('aileenuser');
                                                                if ($key['user_id'] == $userid) {
                                                 $return_html .= '<a id="'.$key['art_post_id'].'" onClick="deleteownpostmodel(this.id)"><span class="h4-img h2-srrt"></span>Delete Post</a>
                                                                 <a id="'.$key['art_post_id'].'" onClick="editpost(this.id)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</a>';
                                                                     } else { 
                                                                   $return_html .=  '<a id="'.$key['art_post_id'].'" onClick="deletepostmodel(this.id)"><span class="h4-img h2-srrt"></span>Delete Post</a>';
                                                                    } } 
                                               $return_html .= '</div>
                                            </div> 
                                       <div class="post-design-desc">
                                          <div>

                                             <div id="editpostbox'. $key['art_post_id'].'" style="display:none;">
                                                        <input type="text" class="my_text" id="editpostname'. $key['art_post_id'].'" name="editpostname" placeholder="Title" value="'.$key['art_post'].'" onKeyDown=check_lengthedit('.$key['art_post_id'].'); onKeyup=check_lengthedit('.$key['art_post_id'].'); onblur=check_lengthedit('.$key['art_post_id'].'); >';
                                                         
                                                              if ($key['art_post']) {
                                                                $counter = $key['art_post'];
                                                                $a = strlen($counter);
                                                                  
                                            $return_html .= '<input size=1 id="text_num_'.$key['art_post_id'].'" class="text_num" tabindex="-500" value="'.(50 - $a).'" name=text_num disabled="disabled">';
                                                                } else { 
                                            $return_html .= '<input size=1 id="text_num_'.$key['art_post_id'].'" class="text_num" tabindex="-501" value=50 name=text_num disabled="disabled">'; 
                                                              } 
                                            $return_html .= '</div>
                                          </div>
                                          <div id="khyati'. $key['art_post_id'].'" style="display:block;">';
                                            
                                              $num_words = 29;
                                       $words = array();
                                       $words = explode(" ",  $key['art_description'], $num_words);
                                       $shown_string = "";
                                       
                                       if(count($words) == 29){
                                       $words[28] ='... <span id="kkkk" onClick="khdiv(' . $key['art_post_id'] . ')">View More</span>';
                                       }
                                       
                                       $shown_string = implode(" ", $words);
                                       $return_html .= $this->common->make_links($shown_string);

                                          $return_html .= '</div>
                                          <div id="khyatii'. $key['art_post_id'].'" style="display:none;">';
                                          
                                         $return_html .= $this->common->make_links($key['art_description']);
                                           
                                        $return_html .= '</div>

                                          <div id="editpostdetailbox'. $key['art_post_id'].'" style="display:none;">      
                                                   <div contenteditable="true" id="editpostdesc'. $key['art_post_id'].'" placeholder="Product Description" class="textbuis  editable_text" name="editpostdesc" onfocus="return cursorpointer('.$key['art_post_id'].');">'.$key['art_description'].'</div>                  
                                          </div>
                                          <button class="fr" id="editpostsubmit'. $key['art_post_id'].'" style="display:none;margin: 5px 0; border-radius: 3px;" onclick="edit_postinsert('.$key['art_post_id'].')">Save
                                          </button>
                                       </div>
                                    </div>';

                                     // middel section start bphotos video audio pdf 
                                    $return_html .= '<div class="post-design-mid col-md-12" style="border: none;">
                                        <div>                                               
                                        <div class="mange_post_image">';
                                            
                                            $contition_array = array('post_id' => $key['art_post_id'], 'is_deleted' => '1', 'insert_profile' => '1');
                                            $artmultiimage = $this->data['artmultiimage'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                           
                                            if (count($artmultiimage) == 1) {
                                                
                                                $allowed = array('jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg');
                                                $allowespdf = array('pdf');
                                                $allowesvideo = array('mp4', '3gp', 'avi','MP4');
                                                $allowesaudio = array('mp3');
                                                $filename = $artmultiimage[0]['file_name'];
                                                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                          if (in_array($ext, $allowed)) {
                                                             
           $return_html .= '<div class="one-image" >
             <a href="'.base_url('artistic/post-detail/' . $key['art_post_id']).'">

             <img src = "' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '">

              </a>
          </div>';
           } elseif (in_array($ext, $allowespdf)) {                                                
            $return_html .= '<div>
            <a href="'.base_url('artistic/creat-pdf/' . $artmultiimage[0]['post_files_id']).'"><div class="pdf_img">
                <embed src="' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '" width="100%" height="450px" />
                    </div></a>
                    </div>';
                   } elseif (in_array($ext, $allowesvideo)) { 
                  $return_html .= '<div class="video_post">
                        <video width="100%" height="55%" controls>
                         <source src = "' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '" type = "video/mp4">
                        <source src="movie.ogg" type="video/ogg">
                        Your browser does not support the video tag.
                         </video>
                    </div>';                                    
                 } elseif (in_array($ext, $allowesaudio)) {                                          
                        $return_html .= '<div>
                        <audio width="120" height="100" controls>
                   <source src = "' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '" type = "audio/mp3">

                    <source src="movie.ogg" type="audio/ogg">
                        Your browser does not support the audio tag.
                      </audio>
                    </div>';
                 } 
                   } elseif (count($artmultiimage) == 2) { 
                                               
                                                foreach ($artmultiimage as $multiimage) {
                                                                                                  
                    $return_html .= '<div class="two-images">
                                                        <a href="'.base_url('artistic/post-detail/' . $key['art_post_id']).'>
                                                        <img class = "two-columns" src = "' . ART_POST_RESIZE1_UPLOAD_URL . $multiimage['file_name'] . '">
                                                         </a>
                                                    </div>';                                                    
                                                 } 
                                             } elseif (count($artmultiimage) == 3) { 
            $return_html .= '<div class="three-image-top">
                                                    <a href="'.base_url('artistic/post-detail/' . $key['art_post_id']).'">
                                                   <img class = "three-columns" src = "' . ART_POST_RESIZE4_UPLOAD_URL . $artmultiimage[0]['file_name'] . '">
                                                     </a>
                                                </div>
                                               <div class="three-image">
                                                    <a href="'.base_url('artistic/post-detail/' . $key['art_post_id']) .'">
                                                   <img class = "three-columns" src = "' . ART_POST_RESIZE1_UPLOAD_URL . $artmultiimage[1]['file_name'] . '">
                                                     </a>
                                                </div>
                                              <div class="three-image">
                                                    <a href="'.base_url('artistic/post-detail/' . $key['art_post_id']) .'">
                                                   <img class = "three-columns" src = "' . ART_POST_RESIZE1_UPLOAD_URL . $artmultiimage[2]['file_name'] . '">
                                                     </a>
                                                </div>';
                                             } elseif (count($artmultiimage) == 4) { 
                                               
                                                foreach ($artmultiimage as $multiimage) {
                                                                                                     
                    $return_html .= '<div class="four-image">
                                                        <a href="'.base_url('artistic/post-detail/' . $key['art_post_id']).'">
                                                         <img class = "breakpoint" src = "' . ART_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name'] . '">
                                                        </a>
                                                   </div>';                                                   
                                                } 
                                            } elseif (count($artmultiimage) > 4) { 
                                                
                                                $i = 0;
                                                foreach ($artmultiimage as $multiimage) {
                                                                                                       
                $return_html .= '<div class="four-image">
                                                            <a href="'.base_url('artistic/post-detail/' . $key['art_post_id']).'">
                                                             <img src = "' . ART_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name'] . '">
                                                             </a>
                                                        </div>';                                             
                                                   
                                                    $i++;
                                                    if ($i == 3)
                                                        break;
                                                }
                                                
                $return_html .= '<div class="four-image">
                                                        <a href="'.base_url('artistic/post-detail/' . $key['art_post_id']).'"><img src="'.base_url($this->config->item('art_post_thumb_upload_path') .$artmultiimage[3]['file_name']).'" > </a>
                                                        <a href="'.base_url('artistic/post-detail/' . $key['art_post_id']).'" >
                                                    <div class="more-image" >
                                                <span>
                                                     View All (+'.(count($artmultiimage) - 4).')
                                                 </span></div>
                                             </a>
                                               </div>';
                                             } 
                                        $return_html .= '</div>                                                            
                                            </div>
                                    </div>';

                                    // middel section end photos video audio pdf 


                    $return_html .= '<div class="post-design-like-box col-md-12">
                                       <div class="post-design-menu">
                                          <ul class="col-md-6">
                                             <li class="likepost' . $key['art_post_id'].'">
                                                <a class="ripple like_h_w" id="'.$key['art_post_id'].'" onClick="post_like(this.id)">';
                                              
                                                   $userid = $this->session->userdata('aileenuser');
                                                   $contition_array = array('art_post_id' => $key['art_post_id'], 'status' => '1');
                                                   $artlike = $this->data['artlike'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                    $likeuserarray = explode(',', $artlike[0]['art_like_user']);
                                                      if (!in_array($userid, $likeuserarray)) { 
                    $return_html .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true">
                                                </i>';
                                                 } else {
                                               $return_html .= '<i class="fa fa-thumbs-up main_color" aria-hidden="true"></i>';
                                                } 
                                              $return_html .= '<span style="display: none;">
                                                </span>
                                                </a>
                                             </li>
                                             <li id="insertcount' . $key['art_post_id'].'" style="visibility:show">';
                                              
                                                        $contition_array = array('art_post_id' => $key['art_post_id'], 'status' => '1', 'is_delete' => '0');
                                                        $commnetcount = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                        
                                               $return_html .= '<a class="ripple like_h_w" onClick="commentall(this.id)" id="'.$key['art_post_id'].'">
                                                <i class="fa fa-comment-o" aria-hidden="true"> 
                                                <span style="display: none;"></span>
                                                </i> 
                                                </a>
                                             </li>
                                          </ul>
                                          <ul class="col-md-6 like_cmnt_count">
                                             <li>
                                                <div class="like_count_ext   comment_count'.$key['art_post_id'].'">
                                                   <span class="comment_count">';
                                                    
                                                      if (count($commnetcount) > 0) {
                                                      $return_html .= count($commnetcount);  
                                                  $return_html .='</span> 
                                                   <span> Comment</span>';
                                                       }
                                     $return_html .= '</div>
                                             </li>
                                             <li>
                                                <div class="comnt_count_ext_a comnt_count_ext'. $key['art_post_id'].'">
                                                   <span class="comment_like_count">'; 
                                                  
                                                      if ($key['art_likes_count'] > 0) { 
                                                        $return_html .= $key['art_likes_count']; 
                                                     $return_html .= '</span> 
                                                     <span> Like</span>';
                                                       } 
                                    $return_html .= '</div>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>';
                                    
                                        if ($key['art_likes_count'] > 0) {
                                            
                                    $return_html .= '<div class="likeduserlist'.$key['art_post_id'] .'">';
                                               
                                                $contition_array = array('art_post_id' => $key['art_post_id'], 'status' => '1', 'is_delete' => '0');
                                                $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                $likeuser = $commnetcount[0]['art_like_user'];
                                                $countlike = $commnetcount[0]['art_likes_count'] - 1;
                                                $likelistarray = explode(',', $likeuser);
                                              
                                                foreach ($likelistarray as $key1 => $value) {
                                                    $art_fname1 = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => 1))->row()->art_name;
                                                    $art_lname1 = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => 1))->row()->art_lastname;
                                                   
                                                } 
                                                                                                                
                                                    $contition_array = array('art_post_id' => $key['art_post_id'], 'status' => '1', 'is_delete' => '0');
                                                    $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                                    $likeuser = $commnetcount[0]['art_like_user'];
                                                    $countlike = $commnetcount[0]['art_likes_count'] - 1;

                                                    $likelistarray = explode(',', $likeuser);
                                                    $likelistarray = array_reverse($likelistarray);
                                                    $art_fname = $this->db->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => 1))->row()->art_name;
                                                    $art_lname = $this->db->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => 1))->row()->art_lastname;
                                                   
                                                   $return_html .= '<div class="like_one_other">
                                                    <a href="javascript:void(0);"  onclick="likeuserlist('.$key['art_post_id'].')">';
                                                        
                                                       $return_html .=ucfirst(strtolower($art_fname));
                                                        $return_html .= '&nbsp;';
                                                        $return_html .= ucfirst(strtolower($art_lname));
                                                        $return_html .= '&nbsp;';
                                                       
                                                        if (count($likelistarray) > 1) {
                                                            $return_html .= 'and'.' ';
                                                           $return_html .= $countlike;
                                                            $return_html .= '&nbsp;';
                                                            $return_html .= 'others';
                                                        }
                                                       
                                                        $return_html .= '</a>
                                                    </div>                                               
                                            </div>';
                                            
                                        }
                                        

                                   $return_html .= '<div class="likeusername'. $key['art_post_id'].'" id="likeusername'. $key['art_post_id'].'" style="display:none">';
                                    
                                            $contition_array = array('art_post_id' => $key['art_post_id'], 'status' => '1', 'is_delete' => '0');
                                            $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                            $likeuser = $commnetcount[0]['art_like_user'];
                                            $countlike = $commnetcount[0]['art_likes_count'] - 1;
                                            $likelistarray = explode(',', $likeuser);
                                         
                                            foreach ($likelistarray as $key2 => $value) {
                                                $art_fname1 = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => 1))->row()->art_name;
                                                $art_lname1 = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => 1))->row()->art_lastname;
                                                
                                             } 
                                                                                                                           
                                                $contition_array = array('art_post_id' => $key['art_post_id'], 'status' => '1', 'is_delete' => '0');
                                                $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                                $likeuser = $commnetcount[0]['art_like_user'];
                                                $countlike = $commnetcount[0]['art_likes_count'] - 1;

                                                $likelistarray = explode(',', $likeuser);
                                                $likelistarray = array_reverse($likelistarray);
                                                $art_fname = $this->db->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => 1))->row()->art_name;
                                                $art_lname = $this->db->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => 1))->row()->art_lastname;
                                              
                                     $return_html .= '<a href="javascript:void(0);" onclick="likeuserlist('.$key['art_post_id'].');">
                                          <div class="like_one_other">';
                                             
                                                    $return_html .= ucfirst(strtolower($art_fname));
                                                    $return_html .= '&nbsp;';
                                                    $return_html .= ucfirst(strtolower($art_lname));
                                                    $return_html .= '&nbsp;';
                                                   
                                                    if (count($likelistarray) > 1) {
                                                        $return_html .= 'and'.' ';
                                                       $return_html .= $countlike;
                                                        $return_html .= '&nbsp;';
                                                        $return_html .= 'others';
                                                    }
                                                         
                                 $return_html .= '</div>
                                       </a>
                                    </div>
                                    <div class="art-all-comment col-md-12">
                                       <div id="fourcomment'. $key['art_post_id'].'" style="display:none;">
                                       </div>
                                       <div id="threecomment'. $key['art_post_id'].'" style="display:block">
                                        <div class="hidebottomborder insertcomment'. $key['art_post_id'].'">';
                                             
                                                    $contition_array = array('art_post_id' => $key['art_post_id'], 'status' => '1');
                                                    $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = 'artistic_post_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');
    
                                                    if ($artdata) {
                                                        foreach ($artdata as $rowdata) {
                                                            $artname = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->art_name;
                                                            $artlastname = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->art_lastname;

                                                            $artslug = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->slug;
                                                            
                                                $return_html .= '<div class="all-comment-comment-box">
                                                        <div class="post-design-pro-comment-img">';
                                                        $return_html .= '<a href="' . base_url('artistic/dashboard/' . $artslug . '') . '">';
                                                          
                                                              $art_userimage = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id'], 'status' => 1))->row()->art_user_image;
                                                                 
                                                       if ($art_userimage) { 
                                                         
                                                          $return_html .= '<img  src="'.ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage.'"  alt="">';
                                                                 } else { 
                                                                
                                                                $a = $artname;
                                                                $acr = substr($a, 0, 1);
                                                                $b = $artlastname;
                                                                $bcr = substr($b, 0, 1);
                                                                
                                            $return_html .= '<div class="post-img-profile">';
                                                
                                                                    $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)) ;
                                                                    
                                            $return_html .= '</div>';
                                                               }
                                            $return_html .= '</a>';
                                            $return_html .= '</div>
                                                        <div class="comment-name">';
                                                           $return_html .= '<a href="' . base_url('artistic/dashboard/' . $artslug . '') . '">';
                                                         $return_html .= '<b>';

                                                          $return_html .= ucfirst(strtolower($artname));
                                                         $return_html .= '&nbsp;';
                                                          $return_html .= ucfirst(strtolower($artlastname));
                                                          $return_html .= '</b></br></a></div>
                                                          <div class="comment-details" id="showcomment'. $rowdata['artistic_post_comment_id'].'">'.$this->common->make_links($rowdata['comments']).'</div>';

                                $return_html .= '<div class="edit-comment-box">
                                                    <div class="inputtype-edit-comment">
                                                          <div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="'.$rowdata['artistic_post_comment_id'].'"  id="editcomment'.$rowdata['artistic_post_comment_id'].'" placeholder="Enter Your Comment " value= ""  onkeyup="commentedit('.$rowdata['artistic_post_comment_id'].')">'.$rowdata['comments'].'</div>';

                                             // div problem strat here in button imporatnt note
                                 $return_html .= '<span class="comment-edit-button"><button id="editsubmit' . $rowdata['artistic_post_comment_id'].'" style="display:none" onClick="edit_comment('.$rowdata['artistic_post_comment_id'].')">Save</button></span>
                                                                    </div>
                                                                </div>
                                                                    <div class="art-comment-menu-design"> 
                                                                    <div class="comment-details-menu" id="likecomment1' . $rowdata['artistic_post_comment_id'].'">
                                                                        <a id="'.$rowdata['artistic_post_comment_id'].'"   onClick="comment_like1(this.id)">';

                                                                          
                                                                            $userid = $this->session->userdata('aileenuser');
                                                                            $contition_array = array('artistic_post_comment_id' => $rowdata['artistic_post_comment_id'], 'status' => '1');
                                                                            $artcommentlike = $this->data['artcommentlike'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                                            $likeuserarray = explode(',', $artcommentlike[0]['artistic_comment_like_user']);

                                                                            if (!in_array($userid, $likeuserarray)) {
                                                                               

                                            $return_html .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>'; 
                                                                             } else {
                                                                              
                                            $return_html .= '<i class="fa fa-thumbs-up main_color" aria-hidden="true"></i>';
                                                                             }
                                                                           
                                            $return_html .= '<span>';
                                                                                
                                                                                if ($rowdata['artistic_comment_likes_count'] > 0) {
                                                                                   $return_html .= $rowdata['artistic_comment_likes_count'];
                                                                                }
                                                                                
                                             $return_html .= '</span>
                                                                        </a>
                                                                    </div>';
                                                                    
                                                                    $userid = $this->session->userdata('aileenuser');
                                                                    if ($rowdata['user_id'] == $userid) {
                                                                        
                                        $return_html .= '<span role="presentation" aria-hidden="true"> · </span>
                                                                        <div class="comment-details-menu">
                                                                            <div id="editcommentbox'. $rowdata['artistic_post_comment_id'].'" style="display:block;">
                                                                                <a id="'.$rowdata['artistic_post_comment_id'].'" onClick="comment_editbox(this.id)" class="editbox">Edit
                                                                                </a>
                                                                            </div>
                                                                            <div id="editcancle' . $rowdata['artistic_post_comment_id'].'" style="display:none;">
                                                                                <a id="'.$rowdata['artistic_post_comment_id'].'" onClick="comment_editcancle(this.id)">Cancel
                                                                                </a>
                                                                            </div>
                                                                        </div>';
                                                                    } 
                                                                   
                                                                    $userid = $this->session->userdata('aileenuser');
                                                                    $art_userid = $this->db->get_where('art_post', array('art_post_id' => $rowdata['art_post_id'], 'status' => 1))->row()->user_id;

                                                                    if ($rowdata['user_id'] == $userid || $art_userid == $userid) {
                                                                        
                                        $return_html .= '<span role="presentation" aria-hidden="true"> · </span>
                                                                        <div class="comment-details-menu">
                                                                            <input type="hidden" name="post_delete"  id="post_delete'. $rowdata['artistic_post_comment_id'].'" value= "'.$rowdata['art_post_id'].'">
                                                                            <a id="'.$rowdata['artistic_post_comment_id'].'"   onClick="comment_delete(this.id)"> Delete<span class="insertcomment' . $rowdata['artistic_post_comment_id'].'">
                                                                                </span>
                                                                            </a>
                                                                        </div>';
                                                                 }
                                        $return_html .= '<span role="presentation" aria-hidden="true"> · </span>
                                                                    <div class="comment-details-menu">
                                                                        <p>'; 
                                                                                                                     
                                                                  $return_html .= $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($rowdata['created_date'])));
                                                                            $return_html .= '</br>';
                                                                            
                                        $return_html .= '</p></div></div>
                                                  </div>'; 
                                                 } }
                                          $return_html .= '</div>
                                       </div>
                                    </div>
                                    <div class="post-design-commnet-box col-md-12">';
                                     
                                            $userid = $this->session->userdata('aileenuser');
                                            $art_userimage = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->art_user_image;

                                            $art_name = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->art_name;
                                            $art_lastname = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->art_lastname;
                                           
                                      $return_html .= '<div class="post-design-proo-img hidden-mob">';

                                      $art_slug = $this->db->get_where('art_reg', array('user_id' => $userid, 'status' => 1))->row()->slug;

                        $return_html .= '<a href="' . base_url('artistic/dashboard/' . $art_slug) . '">';

                                           if ($art_userimage) { 
                                    $return_html .= '<img src="'.ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage.'" name="image_src" id="image_src" />';
                                                   
                                                } else {
                                                    
                                                      
                                                                $a = $art_name;
                                                                $acr = substr($a, 0, 1);
                                                                 $b = $art_lastname;
                                                                $bcr = substr($b, 0, 1);
                                                               
                                        $return_html .= '<div class="post-img-profile">';
                                        $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                        $return_html .= '</div>';
                                                    
                                                }
                                                
                                      $return_html .= '</a></div>
                                       <div id="content" class="col-md-12 inputtype-comment cmy_2">
                                          <div contenteditable="true" style="min-height:37px !important; margin-top: 0px!important" class="editable_text" name="'.$key['art_post_id'].'" id="post_comment'. $key['art_post_id'].'" placeholder="Type Message ..." onclick="entercomment('.$key['art_post_id'].')"></div>
                                       </div>';
                                        $return_html .= form_error('post_comment');
                                      $return_html .= '<div class="comment-edit-butn">       
                                           <button id="'.$key['art_post_id'].'" onClick="insert_comment(this.id)">Comment</button> 
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              </div>';
                               }
                               //loop end for post 
                           $return_html .= '</div>
                        </div>';
                         }
                        // user post end 

                           // no data avaloble code  start
                        if(count($artuserdata) == 0 && count($artpostdata) == 0){
                        $return_html .= '<div class="profile_search" style="background-color: white; margin-bottom: 10px; margin-top: 10px; border-top: 1px solid #d9d9d9;"> <div class="inner_search"><div class="text-center rio">
                                                <h1 class="page-heading  product-listing" style="border:0px;margin-bottom: 11px;">Oops No Data Found.</h1>
                                                <p style="text-transform:none !important;border:0px;">We could not find what you were looking for.</p>
                                                <ul class="padding_less_left">
                                                    <li style="text-transform:none !important; list-style: none;">Make sure you used the right keywords.</li>
                                                </ul>
                         </div></div></div>';
                          }
                     //no data avaloble code  start


                $return_html .= '</div>';
                echo $return_html;
    }



    public function ajax_user_search() { //echo "hii"; die();

        //echo $_GET['skills']; die();
   //$this->data['userid'] = $userid = $this->session->userdata('aileenuser');


        // $contition_array = array('user_id' => $userid, 'status' => '1', 'art_step' => '4');
        // $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        
        if ($this->input->get('searchplace') == "" && $this->input->get('skills') == "") {
            redirect('artistic/art_post', refresh);

            // $abc[] = $results;
            // $this->data['falguni'] = 1;        
        }

//         // Retrieve the posted search term.
//        //echo "<pre>";print_r($_POST);die();
        $searchskill = trim($this->input->get('skills'));
        $this->data['keyword'] = $searchskill;


         //echo $searchskill; die();
        //$searchskill = explode(',',$search_skill);
        //echo"<pre>";print_r($searchskill);die();
        $search_place = trim($this->input->get('searchplace'));
//insert search keyword into data base code start

        $cache_time = $this->db->get_where('cities', array('city_name' => $search_place))->row()->city_id;

        $this->data['keyword1'] = $search_place;

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $this->data['city'] = $city = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_city', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


      
//insert search keyword into data base code end

        if ($searchskill == "") {
            $contition_array = array('art_city' => $cache_time, 'status' => '1', 'art_step' => 4);
            $new = $this->data['results'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } elseif ($search_place == "") {


            //  $temp = $this->db->get_where('skill', array('skill' => $search_skill, 'status' => 1, 'type' => '2'))->row()->skill_id;
            // $contition_array = array('status' => '1', 'is_delete' => '0', 'art_step' => 4, 'user_id != ' => $userid, 'FIND_IN_SET("' . $temp . '", art_skill) != ' => '0');
            // $artskillpost = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');


             $contition_array = array('status' => 1, 'type' => '2');

            $search_condition = "(skill LIKE '%$searchskill%')";
            // echo $search_condition;
            $temp = $this->common->select_data_by_search('skill', $search_condition, $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            //echo "<pre>"; print_r($temp); die();

            foreach ($temp as $keytemp => $valuetemp) {
               
          
            $contition_array = array('status' => '1', 'is_delete' => '0', 'art_step' => 4,  'FIND_IN_SET("' . $valuetemp['skill_id'] . '", art_skill) != ' => '0');
            $artskill[] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            }
            //echo "<pre>"; print_r($artskillpost); die();
            $artskillpost = array_reduce($artskill, 'array_merge', array());
            
            

            $contition_array = array('art_reg.is_delete' => '0', 'art_reg.status' => '1', 'art_step' => 4);

            $search_condition = "(designation LIKE '%$searchskill%' or other_skill LIKE '%$searchskill%' or art_name LIKE '%$searchskill%' or art_lastname LIKE '%$searchskill%' or art_yourart LIKE '%$searchskill%' or concat(art_name,' ',art_lastname) LIKE '%$searchskill%')";
            // echo $search_condition;
            $otherdata = $other['data'] = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            //echo "<pre>"; print_r($otherdata); die();

            foreach ($otherdata as $postdata) { //echo "<pre>"; print_r($postdata); die();
               
            $join_str[0]['table'] = 'art_reg';
            $join_str[0]['join_table_id'] = 'art_reg.user_id';
            $join_str[0]['from_table_id'] = 'art_post.user_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('art_post.is_delete' => '0', 'art_post.user_id' => $postdata['user_id']);

            $artpostone[] = $this->data['artpostone'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = 'art_post_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str, $groupby = '');
            //echo "<pre>"; print_r($artpostone); die();

            }
            foreach ($artpostone as $keyone => $valueone) {
               
               foreach ($valueone as $keytwo => $valuetwo) {
                   $posttwo[] = $valuetwo;
               }
            } 
            //echo "<pre>"; print_r($posttwo); die();

            $join_str[0]['table'] = 'art_reg';
            $join_str[0]['join_table_id'] = 'art_reg.user_id';
            $join_str[0]['from_table_id'] = 'art_post.user_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('art_reg.art_step' => 4, 'art_post.is_delete' => '0','art_reg.is_delete' => '0', 'art_reg.status' => '1');

            $search_condition = "(art_post.art_post LIKE '%$searchskill%' or art_post.art_description LIKE '%$searchskill%' or art_post.other_skill LIKE '%$searchskill%' or art_reg.designation LIKE '%$searchskill%' or art_reg.other_skill LIKE '%$searchskill%')";


            $artposttwo = $artpostdata['data'] = $this->common->select_data_by_search('art_post', $search_condition, $contition_array, $data = 'art_post.*,art_reg.*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

                 
                 if($artskillpost){
                 $unique = array_merge($artskillpost, $otherdata);
                }else{
                    $unique = $otherdata;
                }
                 //echo "<pre>"; print_r($unique); die();
                 $new = array_unique($unique, SORT_REGULAR);


                if (count($artposttwo) == 0) {
                    $uniquedata = $posttwo;
                } else {
                    $uniquedata = array_merge($artposttwo, $posttwo);
                }
                $artpost = array_unique($uniquedata, SORT_REGULAR);                
//echo "<pre>"; print_r($artpost); die();

        } else {
            // echo "both";


             $temp = $this->db->get_where('skill', array('skill' => $search_skill, 'status' => 1, 'type' => '2'))->row()->skill_id;
            $contition_array = array('status' => '1', 'is_delete' => '0', 'art_city' => $cache_time, 'art_step' => 4,  'FIND_IN_SET("' . $temp . '", art_skill) != ' => '0');
            $artskillpost = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            

            

            $contition_array = array('is_delete' => '0', 'status' => '1', 'art_city' => $cache_time, 'art_step' => 4);

            $search_condition = "(designation LIKE '%$searchskill%' or other_skill LIKE '%$searchskill%' or art_name LIKE '%$searchskill%' or art_lastname LIKE '%$searchskill%'or concat(art_name,' ',art_lastname) LIKE '%$searchskill%')";

            $otherdata = $other['data'] = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
             //echo "<pre>"; print_r($otherdata); die();

            foreach ($otherdata as $postdata) { //echo "<pre>"; print_r($postdata); die();
               
            $join_str[0]['table'] = 'art_reg';
            $join_str[0]['join_table_id'] = 'art_reg.user_id';
            $join_str[0]['from_table_id'] = 'art_post.user_id';
            $join_str[0]['join_type'] = '';

            $contition_array = array('art_post.is_delete' => '0', 'art_post.user_id' => $postdata['user_id']);

            $artpostone[] = $this->data['artpostone'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = 'art_post_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str, $groupby = '');
            //echo "<pre>"; print_r($artpostone); die();

            }
            foreach ($artpostone as $keyone => $valueone) {
               
               foreach ($valueone as $keytwo => $valuetwo) {
                   $posttwo[] = $valuetwo;
               }
            } 


            $join_str[0]['table'] = 'art_reg';
            $join_str[0]['join_table_id'] = 'art_reg.user_id';
            $join_str[0]['from_table_id'] = 'art_post.user_id';
            $join_str[0]['join_type'] = '';

            $search_condition = "(art_post.art_post LIKE '%$searchskill%' or art_post.art_description LIKE '%$searchskill%' or art_post.other_skill LIKE '%$searchskill%')";


            $contition_array = array('art_reg.art_city' => $cache_time, 'art_reg.art_step' => 4, 'art_post.is_delete' => '0');
            $artposttwo = $artpostdata['data'] = $this->common->select_data_by_search('art_post', $search_condition, $contition_array, $data = 'art_post.*,art_reg.art_name,art_reg.art_lastname,art_reg.art_user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
            // echo "<pre>"; print_r($artpost);

           

           
               if($artskillpost){
                 $unique = array_merge($artskillpost, $otherdata);
                }else{
                    $unique = $otherdata;
                }
              

                $new = array_unique($unique, SORT_REGULAR);

                if (count($artposttwo) == 0) {
                    $uniquedata = $posttwo;
                } else {
                    $uniquedata = array_merge($artposttwo, $posttwo);
                }
                $artpost = array_unique($uniquedata, SORT_REGULAR);  

        }


        $artuserdata = $this->data['artuserdata'] = $new;

        $artpostdata = $this->data['artpostdata'] = $artpost;

        //AJAX DATA
        $return_html = '';
        
                $return_html .= '<div class="profile-job-post-title-inside clearfix" style="">';


                     // user list start 
                      if (count($artuserdata) > 0)
                          { 
                        $return_html .= '<div class="profile_search" style="background-color: white; margin-bottom: 10px; margin-top: 10px;">
                           <h4 class="search_head">Profiles</h4>
                           <div class="inner_search">';
      
                              foreach ($artuserdata as $key) {
                                if($key['art_id']){

                             $return_html .=  '<div class="profile-job-profile-button clearfix box_search_module">
                                 <div class="profile-job-post-location-name-rec">
                                    <div class="module_Ssearch" style="display: inline-block; float: left;">
                                       <div class="search_img" style="height: 110px; width: 108px;">';
                                          if($key['art_user_image']){
                           $return_html .= '<img src="'.ART_PROFILE_THUMB_UPLOAD_URL . $key['art_user_image'].'" alt=" ">';
                                 }else{
                           
                                             $a = $key['art_name'];
                                              $acr = substr($a, 0, 1);
                                              $b = $key['art_lastname'];
                                              $bcr = substr($b, 0, 1);
                                       
                                     $return_html .=  '<div class="post-img-profile">';
                                             $return_html .=  ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr));
                                         $return_html .=  '</div>';
                                       }
                                       $return_html .= '</div>
                                    </div>
                                    <div class="designation_rec" style="    float: left;
                                       width: 60%;
                                       padding-top: 10px; padding-bottom: 10px;">
                                       <ul>
                                          <li style="padding-top: 0px;">
                                             <a style="  font-size: 19px;font-weight: 600;" href="'.base_url('artistic/dashboard/' . $key['slug'] . '').'" title="'.$key['art_name'].' '.$key['art_lastname'].'">'.ucfirst(strtolower($key['art_name'])).' '.ucfirst(strtolower($key['art_lastname'])).'</a>
                                          </li>
                                          <li style="display: block;">
                                             <a  class="color-search" href="'.base_url('artistic/dashboard/' . $key['slug'] . '').'">';
                                                 if($key['designation']){
                                                    $return_html .= $key['designation'];
                                                } else{
                                                   $return_html .= 'Current work';
                                                } 
                                             $return_html .= '</a>
                                          </li>
                                          <li style="display: block;">';
                                                            
                                                   $aud = $key['art_skill'];
                                                   $aud_res = explode(',', $aud);
                                                   $skill1 = array();
                                                   foreach ($aud_res as $skdata) {
                                                     $cache_time = $this->db->get_where('skill', array('skill_id' => $skdata))->row()->skill;
                                                     $skill1[] = $cache_time;
                                                     }
                                                  $listFinal = implode(', ', $skill1);
                                                  if($listFinal && $key['other_skill']){ 

                                                     $return_html .= $listFinal . ',' . $key['other_skill'];
                                                  }
                                                       elseif(!$listFinal){ 

                                                      $return_html .= $key['other_skill']; 

                                                  }else if(!$key['other_skill']){
                                                   $return_html .= $listFinal;  
                                                }    
     
                                         $return_html .=  '</li>
                                          <li style="display: block;">
                                             <a  class="color-search" href="">';
                                              $country = $this->db->get_where('countries', array('country_id' => $key['art_country']))->row()->country_name;
                                               $city = $this->db->get_where('cities', array('city_id' => $key['art_city']))->row()->city_name;
                                                
                                              if(!$country){ 
                                               $return_html .= $city;
                                                 }else if(!$city){ 
                                               $return_html .= $country;
                                              }else{
                                                $return_html .= $city.",".$country;
                                                } 
                        $return_html .= '</a>
                                          </li>
                                          <li style="display: block;">
                                             <a title="" class="color-search websir-se" href="" target="_blank"> </a>
                                          </li>
                                          <input type="hidden" name="search" id="search" value="zalak">
                                       </ul>
                                    </div>';

                                 // follow meassge div start 
                                   
                            $userid = $this->session->userdata('aileenuser');
                            if($key['user_id'] == $userid){}else{
                                    $return_html .= '<div class="fl search_button">
                                       <div class="fruser' . $key['art_id'].'">';

                                         $status  =  $this->db->get_where('follow',array('follow_type' => 1, 'follow_from' => $artdata[0]['art_id'], 'follow_to'=>$key['art_id'] ))->row()->follow_status; 
                                            if($status == 0 || $status == " "){

                                 $return_html .= '<div id="followdiv " class="user_btn">
                                            <button id="follow' . $key['art_id'].'" onClick="login_profile();">
                                            <span>Follow</span> 
                                             </button>
                                          </div>';
                                           } elseif($status == 1){ 

                                          $return_html .= '<div id= "unfollowdiv"  class="user_btn" > 
                                         <button class="bg_following" id="unfollow' . $key['art_id'].'" onClick="login_profile();">
                                         <span> Following </span>
                                        </button></div>';

                                           }
                                       $return_html .= '</div>
                                       <a href="javascript:void(0);" onclick="login_profile();"> Message</a>
                                    </div>';
                                    }
                                   // follow meassge div end 
                                 $return_html .=  '</div>
                              </div>';

                               } } 
                           $return_html .= '</div>
                        </div>';
                         }
                          // user list end 

                           // user post start 

                    if($artpostdata){

                       $return_html .= '<div class="col-md-12 profile_search " style="float: left; background-color: white; margin-top: 10px; margin-bottom: 10px; padding:0px!important;">
                           <h4 class="search_head">Posts</h4>
                           <div class="inner_search search inner_search_2" style="float: left;">';

                           // loop start for post 
                           foreach ($artpostdata as $key) {
                             
                              $return_html .= '<div id="removepost'. $key['art_post_id'].'">
                              <div class="col-md-12 col-sm-12 post-design-box"  style="box-shadow: none; ">
                                 <div class="post_radius_box">
                                    <div class="post-design-search-top col-md-12" style="background-color: none!important;">
                                       <div class="post-design-pro-img ">
                                            
                                          <a class="post_dot" href="'.base_url('artistic/dashboard/' . $key['slug'] . '').'" title="'.$key['art_name'].' '.$key['art_lastname'].'">';
                                           if($key['art_user_image']){

                                            $return_html .= '<img src="'. ART_PROFILE_THUMB_UPLOAD_URL . $key['art_user_image'].'" alt="">';
                                                   }else{
                                                   
                                                    $a = $key['art_name'];
                                                    $acr = substr($a, 0, 1);
                                                    $b = $key['art_lastname'];
                                                    $bcr = substr($b, 0, 1);
                                                   
                                            $return_html .= '<div class="post-img-div">
                                                    '.ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)).'
                                                    </div>';
                                           }
                                        $return_html .= '</a>
                                       </div>
                                       <div class="post-design-name col-xs-8 fl col-md-10">
                                          <ul>
                                             <li>
                                             </li>
                                           
                                             <li>
                                                <div class="post-design-product">
                                                   <a class="post_dot" href="'.base_url('artistic/dashboard/' . $key['slug'] . '').'" title="'.$key['art_name'].' '.$key['art_lastname'].'" >'.ucfirst(strtolower($key['art_name'])).' '.ucfirst(strtolower($key['art_lastname'])).'
                                                   </a>
                                                   <span role="presentation" aria-hidden="true"> · </span>
                                                   <div class="datespan"> 
                                                      <span style="font-weight: 400; font-size: 14px; color: #91949d; cursor: default;">'; 
                                                $return_html .= $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($key['created_date'])));  
                                                     $return_html .= '</span>
                                                   </div>
                                                </div>
                                             </li>
                                             <li>
                                                <div class="post-design-product" id="editpostdata' . $key['art_post_id'].'" >
                                                   <a href="javascript:void(0);" style=" color: #000033; font-weight: 400; cursor: default;" title="" id="editpostval' . $key['art_post_id'].'">';
                                                   $return_html .= $this->common->make_links($key['art_post']);
                                                   $return_html .= '</a>
                                                </div>
                                             </li>
                                             <li>
                                             </li>
                                          </ul>
                                       </div>
                                       <div class="dropdown1">
                                               <a href="javascript:void(0);" onclick="login_profile();" class="  dropbtn1 fa fa-ellipsis-v"></a>
                                                  <div id="myDropdown'.$key['art_post_id'].'" class="dropdown-content1 ">';
                                                            
                                                            if ($key['posted_user_id'] != 0) {

                                                            if ($this->session->userdata('aileenuser') == $key['posted_user_id']) {
                                                                       
                                            $return_html .= '<a id="'.$key['art_post_id'].'" onClick="deleteownpostmodel(this.id)"><span class="h4-img h2-srrt"></span>Delete Post</a>
                                                          <a id="'.$key['art_post_id'].'" onClick="editpost(this.id)"><span class="h3-img h2-srrt"></span>Edit</a>';

                                                           } else {
                                            $return_html .= '<a id="'.$key['art_post_id'].'" onClick="deletepostmodel(this.id)"><span class="h4-img h2-srrt"></span>Delete Post</a>';
                                                           } }else{
                                                          
                                                              $userid = $this->session->userdata('aileenuser');
                                                                if ($key['user_id'] == $userid) {
                                                 $return_html .= '<a id="'.$key['art_post_id'].'" onClick="deleteownpostmodel(this.id)"><span class="h4-img h2-srrt"></span>Delete Post</a>
                                                                 <a id="'.$key['art_post_id'].'" onClick="editpost(this.id)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</a>';
                                                                     } else { 
                                                                   $return_html .=  '<a id="'.$key['art_post_id'].'" onClick="deletepostmodel(this.id)"><span class="h4-img h2-srrt"></span>Delete Post</a>';
                                                                    } } 
                                               $return_html .= '</div>
                                            </div> 
                                       <div class="post-design-desc">
                                          <div>

                                             <div id="editpostbox'. $key['art_post_id'].'" style="display:none;">
                                                        <input type="text" class="my_text" id="editpostname'. $key['art_post_id'].'" name="editpostname" placeholder="Title" value="'.$key['art_post'].'" onKeyDown=check_lengthedit('.$key['art_post_id'].'); onKeyup=check_lengthedit('.$key['art_post_id'].'); onblur=check_lengthedit('.$key['art_post_id'].'); >';
                                                         
                                                              if ($key['art_post']) {
                                                                $counter = $key['art_post'];
                                                                $a = strlen($counter);
                                                                  
                                            $return_html .= '<input size=1 id="text_num_'.$key['art_post_id'].'" class="text_num" tabindex="-500" value="'.(50 - $a).'" name=text_num disabled="disabled">';
                                                                } else { 
                                            $return_html .= '<input size=1 id="text_num_'.$key['art_post_id'].'" class="text_num" tabindex="-501" value=50 name=text_num disabled="disabled">'; 
                                                              } 
                                            $return_html .= '</div>
                                          </div>
                                          <div id="khyati'. $key['art_post_id'].'" style="display:block;">';
                                            
                                              $num_words = 29;
                                       $words = array();
                                       $words = explode(" ",  $key['art_description'], $num_words);
                                       $shown_string = "";
                                       
                                       if(count($words) == 29){
                                       $words[28] ='... <span id="kkkk" onClick="khdiv(' . $key['art_post_id'] . ')">View More</span>';
                                       }
                                       
                                       $shown_string = implode(" ", $words);
                                       $return_html .= $this->common->make_links($shown_string);
                                          $return_html .= '</div>
                                          <div id="khyatii'. $key['art_post_id'].'" style="display:none;">';
                                          
                                         $return_html .= $this->common->make_links($key['art_description']);
                                           
                                        $return_html .= '</div>

                                          <div id="editpostdetailbox'. $key['art_post_id'].'" style="display:none;">      
                                                   <div contenteditable="true" id="editpostdesc'. $key['art_post_id'].'" placeholder="Product Description" class="textbuis  editable_text" name="editpostdesc" onfocus="return cursorpointer('.$key['art_post_id'].');">'.$key['art_description'].'</div>                  
                                          </div>
                                          <button class="fr" id="editpostsubmit'. $key['art_post_id'].'" style="display:none;margin: 5px 0; border-radius: 3px;" onclick="edit_postinsert('.$key['art_post_id'].')">Save
                                          </button>
                                       </div>
                                    </div>';

                                     // middel section start bphotos video audio pdf 
                                    $return_html .= '<div class="post-design-mid col-md-12" style="border: none;">
                                        <div>                                               
                                        <div class="mange_post_image">';
                                            
                                            $contition_array = array('post_id' => $key['art_post_id'], 'is_deleted' => '1', 'insert_profile' => '1');
                                            $artmultiimage = $this->data['artmultiimage'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                           
                                            if (count($artmultiimage) == 1) {
                                                
                                                $allowed = array('jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg');
                                                $allowespdf = array('pdf');
                                                $allowesvideo = array('mp4', '3gp', 'avi','MP4');
                                                $allowesaudio = array('mp3');
                                                $filename = $artmultiimage[0]['file_name'];
                                                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                          if (in_array($ext, $allowed)) {
                                                             
           $return_html .= '<div class="one-image" >
             <a href="javascript:void(0);" onclick="login_profile();">
            <img src = "' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '">
              </a>
          </div>';
           } elseif (in_array($ext, $allowespdf)) {                                                
            $return_html .= '<div>
            <a href="javascript:void(0);" onclick="login_profile();"><div class="pdf_img">
               <embed src="' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '" width="100%" height="450px" />
                    </div></a>
                    </div>';
                   } elseif (in_array($ext, $allowesvideo)) { 
                  $return_html .= '<div class="video_post">
                        <video width="100%" height="55%" controls>
                         <source src = "' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '" type = "video/mp4">
                        <source src="movie.ogg" type="video/ogg">
                        Your browser does not support the video tag.
                         </video>
                    </div>';                                    
                 } elseif (in_array($ext, $allowesaudio)) {                                          
                        $return_html .= '<div>
                        <audio width="120" height="100" controls>
                    <source src = "' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '" type = "audio/mp3">
                    <source src="movie.ogg" type="audio/ogg">
                        Your browser does not support the audio tag.
                      </audio>
                    </div>';
                 } 
                   } elseif (count($artmultiimage) == 2) { 
                                               
                                                foreach ($artmultiimage as $multiimage) {
                                                                                                  
                    $return_html .= '<div class="two-images">
                                                        <a href="javascript:void(0);" onclick="login_profile();">
                                                       <img class = "two-columns" src = "' . ART_POST_RESIZE1_UPLOAD_URL . $multiimage['file_name'] . '">
                                                         </a>
                                                    </div>';                                                    
                                                 } 
                                             } elseif (count($artmultiimage) == 3) { 
            $return_html .= '<div class="three-image-top">
                                                    <a href="javascript:void(0);" onclick="login_profile();">
                                                    <img class = "three-columns" src = "' . ART_POST_RESIZE4_UPLOAD_URL . $artmultiimage[0]['file_name'] . '">
                                                     </a>
                                                </div>
                                               <div class="three-image">
                                                    <a href="javascript:void(0);" onclick="login_profile();">
                                                    <img class = "three-columns" src = "' . ART_POST_RESIZE1_UPLOAD_URL . $artmultiimage[1]['file_name'] . '">
                                                     </a>
                                                </div>
                                              <div class="three-image">
                                                    <a href="javascript:void(0);" onclick="login_profile();">
                                                    <img class = "three-columns" src = "' . ART_POST_RESIZE1_UPLOAD_URL . $artmultiimage[2]['file_name'] . '">
                                                    </a>
                                                </div>';
                                             } elseif (count($artmultiimage) == 4) { 
                                               
                                                foreach ($artmultiimage as $multiimage) {
                                                                                                     
                    $return_html .= '<div class="four-image">
                                                        <a href="javascript:void(0);" onclick="login_profile();">
                                                        <img class = "breakpoint" src = "' . ART_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name'] . '">
                                                        </a>
                                                   </div>';                                                   
                                                } 
                                            } elseif (count($artmultiimage) > 4) { 
                                                
                                                $i = 0;
                                                foreach ($artmultiimage as $multiimage) {
                                                                                                       
                $return_html .= '<div class="four-image">
                                                            <a href="javascript:void(0);" onclick="login_profile();">
                                                            <img src = "' . ART_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name'] . '">
                                                             </a>
                                                        </div>';                                             
                                                   
                                                    $i++;
                                                    if ($i == 3)
                                                        break;
                                                }
                                                
                $return_html .= '<div class="four-image">
                                                        <a href="javascript:void(0);" onclick="login_profile();">
                                                        <img src = "' . ART_POST_RESIZE2_UPLOAD_URL . $artmultiimage[3]['file_name'] . '">
                                                        </a>
                                                        <a href="'.base_url('artistic/post-detail/' . $key['art_post_id']).'" >
                                                    <div class="more-image" >
                                                <span>
                                                     View All (+'.(count($artmultiimage) - 4).')
                                                 </span></div>
                                             </a>
                                               </div>';
                                             } 
                                        $return_html .= '</div>                                                            
                                            </div>
                                    </div>';

                                    // middel section end photos video audio pdf 


                    $return_html .= '<div class="post-design-like-box col-md-12">
                                       <div class="post-design-menu">
                                          <ul class="col-md-6">
                                             <li class="likepost' . $key['art_post_id'].'">
                                                <a href="javascript:void(0);" onclick="login_profile();">';
                                              
                                                   $userid = $this->session->userdata('aileenuser');
                                                   $contition_array = array('art_post_id' => $key['art_post_id'], 'status' => '1');
                                                   $artlike = $this->data['artlike'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                    $likeuserarray = explode(',', $artlike[0]['art_like_user']);
                                                      if (!in_array($userid, $likeuserarray)) { 
                    $return_html .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true">
                                                </i>';
                                                 } else {
                                               $return_html .= '<i class="fa fa-thumbs-up main_color" aria-hidden="true"></i>';
                                                } 
                                              $return_html .= '<span style="display: none;">
                                                </span>
                                                </a>
                                             </li>
                                             <li id="insertcount' . $key['art_post_id'].'" style="visibility:show">';
                                              
                                                        $contition_array = array('art_post_id' => $key['art_post_id'], 'status' => '1', 'is_delete' => '0');
                                                        $commnetcount = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                        
                                               $return_html .= '<a class="ripple like_h_w" href="javascript:void(0);" onclick="login_profile();">
                                                <i class="fa fa-comment-o" aria-hidden="true"> 
                                                <span style="display: none;"></span>
                                                </i> 
                                                </a>
                                             </li>
                                          </ul>
                                          <ul class="col-md-6 like_cmnt_count">
                                             <li>
                                                <div class="like_count_ext">
                                                   <span class="comment_count">';
                                                    
                                                      if (count($commnetcount) > 0) {
                                                      $return_html .= count($commnetcount);  
                                                  $return_html .='</span> 
                                                   <span> Comment</span>';
                                                       }
                                     $return_html .= '</div>
                                             </li>
                                             <li>
                                                <div class="comnt_count_ext_a comnt_count_ext'. $key['art_post_id'].'">
                                                   <span class="comment_like_count">'; 
                                                  
                                                      if ($key['art_likes_count'] > 0) { 
                                                        $return_html .= $key['art_likes_count']; 
                                                     $return_html .= '</span> 
                                                     <span> Like</span>';
                                                       } 
                                    $return_html .= '</div>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>';
                                    
                                        if ($key['art_likes_count'] > 0) {
                                            
                                    $return_html .= '<div class="likeduserlist'.$key['art_post_id'] .'">';
                                               
                                                $contition_array = array('art_post_id' => $key['art_post_id'], 'status' => '1', 'is_delete' => '0');
                                                $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                $likeuser = $commnetcount[0]['art_like_user'];
                                                $countlike = $commnetcount[0]['art_likes_count'] - 1;
                                                $likelistarray = explode(',', $likeuser);
                                              
                
                                                                                                                
                                                    $contition_array = array('art_post_id' => $key['art_post_id'], 'status' => '1', 'is_delete' => '0');
                                                    $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                                    $likeuser = $commnetcount[0]['art_like_user'];
                                                    $countlike = $commnetcount[0]['art_likes_count'] - 1;

                                                    $likelistarray = explode(',', $likeuser);
                                                    $likelistarray = array_reverse($likelistarray);
                                                    $art_fname = $this->db->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => 1))->row()->art_name;
                                                    $art_lname = $this->db->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => 1))->row()->art_lastname;
                                                   
                                                   $return_html .= '<div class="like_one_other">
                                                    <a  href="javascript:void(0);" onclick="login_profile();">';
                                                        
                                                       $return_html .=ucfirst(strtolower($art_fname));
                                                        $return_html .= '&nbsp;';
                                                        $return_html .= ucfirst(strtolower($art_lname));
                                                        $return_html .= '&nbsp;';
                                                       
                                                        if (count($likelistarray) > 1) {
                                                           $return_html .= 'and'.' ';
                                                            $return_html .= $countlike;
                                                            $return_html .= '&nbsp;';
                                                            $return_html .= 'others';
                                                        }
                                                       
                                                        $return_html .= '</a>
                                                    </div>                                               
                                            </div>';
                                            
                                        }
                                        

                                   $return_html .= '<div class="likeusername'. $key['art_post_id'].'" id="likeusername'. $key['art_post_id'].'" style="display:none">';
                                    
                                            $contition_array = array('art_post_id' => $key['art_post_id'], 'status' => '1', 'is_delete' => '0');
                                            $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                            $likeuser = $commnetcount[0]['art_like_user'];
                                            $countlike = $commnetcount[0]['art_likes_count'] - 1;
                                            $likelistarray = explode(',', $likeuser);
                                         
                                            foreach ($likelistarray as $key2 => $value) {
                                                $art_fname1 = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => 1))->row()->art_name;
                                                $art_lname1 = $this->db->get_where('art_reg', array('user_id' => $value, 'status' => 1))->row()->art_lastname;
                                                
                                             } 
                                                                                                                           
                                                $contition_array = array('art_post_id' => $key['art_post_id'], 'status' => '1', 'is_delete' => '0');
                                                $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                                $likeuser = $commnetcount[0]['art_like_user'];
                                                $countlike = $commnetcount[0]['art_likes_count'] - 1;

                                                $likelistarray = explode(',', $likeuser);
                                                $likelistarray = array_reverse($likelistarray);
                                                $art_fname = $this->db->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => 1))->row()->art_name;
                                                $art_lname = $this->db->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => 1))->row()->art_lastname;
                                              
                                     $return_html .= '<a href="javascript:void(0);" onclick="login_profile();">
                                          <div class="like_one_other">';
                                             
                                                    $return_html .= ucfirst(strtolower($art_fname));
                                                    $return_html .= '&nbsp;';
                                                    $return_html .= ucfirst(strtolower($art_lname));
                                                    $return_html .= '&nbsp;';
                                                   
                                                    if (count($likelistarray) > 1) {
                                                        $return_html .= 'and'.' ';
                                                       $return_html .= $countlike;
                                                        $return_html .= '&nbsp;';
                                                        $return_html .= 'others';
                                                    }
                                                         
                                 $return_html .= '</div>
                                       </a>
                                    </div>
                                    <div class="art-all-comment col-md-12">
                                       <div id="fourcomment'. $key['art_post_id'].'" style="display:none;">
                                       </div>
                                       <div id="threecomment'. $key['art_post_id'].'" style="display:block">
                                        <div class="hidebottomborder insertcomment'. $key['art_post_id'].'">';
                                             
                                                    $contition_array = array('art_post_id' => $key['art_post_id'], 'status' => '1');
                                                    $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = 'artistic_post_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');
    
                                                    if ($artdata) {
                                                        foreach ($artdata as $rowdata) {
                                                            $artname = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->art_name;
                                                            $artlastname = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->art_lastname;

                                                            $artslug = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->slug;
                                                            
                                                $return_html .= '<div class="all-comment-comment-box">
                                                        <div class="post-design-pro-comment-img">';
                                                         $return_html .= '<a href="' . base_url('artistic/dashboard/' . $artslug . '') . '">';
                                                          
                                                              $art_userimage = $this->db->get_where('art_reg', array('user_id' => $rowdata['user_id'], 'status' => 1))->row()->art_user_image;
                                                                 
                                                       if ($art_userimage) { 
                                                          $return_html .= '<img  src="'. ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage.'"  alt="">';
                                                                 } else { 
                                                                
                                                                $a = $artname;
                                                                $acr = substr($a, 0, 1);
                                                                $b = $artlastname;
                                                                $bcr = substr($b, 0, 1);
                                                                
                                            $return_html .= '<div class="post-img-profile">';
                                                                    $return_html .= ucfirst(strtolower($acr)) . ucfirst(strtolower($bcr)) ;
                                            $return_html .= '</div>';
                                                               }
                                            $return_html .= '</a></div>
                                                        <div class="comment-name">';
                                                         $return_html .= '<a href="' . base_url('artistic/dashboard/' . $artslug . '') . '">
                                                            <b title="'.ucfirst(strtolower($artname)).'&nbsp;'.ucfirst(strtolower($artlastname)).'>';
                                                          
                                                          $return_html .= ucfirst(strtolower($artname));
                                                         $return_html .= '&nbsp;';
                                                          $return_html .= ucfirst(strtolower($artlastname));
                                                          $return_html .= '</b></br></a></div>
                                                          <div class="comment-details" id="showcomment'. $rowdata['artistic_post_comment_id'].'">'.$this->common->make_links($rowdata['comments']).'</div>';

                                $return_html .= '<div class="edit-comment-box">
                                                    <div class="inputtype-edit-comment">
                                                          <div contenteditable="true" style="display:none; min-height:37px !important; margin-top: 0px!important; margin-left: 1.5% !important; width: 81%;" class="editable_text" name="'.$rowdata['artistic_post_comment_id'].'"  id="editcomment'.$rowdata['artistic_post_comment_id'].'" placeholder="Enter Your Comment " value= ""  onkeyup="commentedit('.$rowdata['artistic_post_comment_id'].')">'.$rowdata['comments'].'</div>';

                                             // div problem strat here in button imporatnt note
                                 $return_html .= '<span class="comment-edit-button"><button id="editsubmit' . $rowdata['artistic_post_comment_id'].'" style="display:none" onClick="edit_comment('.$rowdata['artistic_post_comment_id'].')">Save</button></span>
                                                                    </div>
                                                                </div>
                                                                    <div class="art-comment-menu-design"> 
                                                                    <div class="comment-details-menu" id="likecomment1' . $rowdata['artistic_post_comment_id'].'">
                                                                        <a href="javascript:void(0);" onclick="login_profile();">';

                                                                          
                                                                            $userid = $this->session->userdata('aileenuser');
                                                                            $contition_array = array('artistic_post_comment_id' => $rowdata['artistic_post_comment_id'], 'status' => '1');
                                                                            $artcommentlike = $this->data['artcommentlike'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                                            $likeuserarray = explode(',', $artcommentlike[0]['artistic_comment_like_user']);

                                                                            if (!in_array($userid, $likeuserarray)) {
                                                                               

                                            $return_html .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>'; 
                                                                             } else {
                                                                              
                                            $return_html .= '<i class="fa fa-thumbs-up main_color" aria-hidden="true"></i>';
                                                                             }
                                                                           
                                            $return_html .= '<span>';
                                                                                
                                                                                if ($rowdata['artistic_comment_likes_count'] > 0) {
                                                                                   $return_html .= $rowdata['artistic_comment_likes_count'];
                                                                                }
                                                                                
                                             $return_html .= '</span>
                                                                        </a>
                                                                    </div>';
                                                                    
                                                                    $userid = $this->session->userdata('aileenuser');
                                                                    if ($rowdata['user_id'] == $userid) {
                                                                        
                                        $return_html .= '<span role="presentation" aria-hidden="true"> · </span>
                                                                        <div class="comment-details-menu">
                                                                            <div id="editcommentbox'. $rowdata['artistic_post_comment_id'].'" style="display:block;">
                                                                                <a id="'.$rowdata['artistic_post_comment_id'].' ?>" onClick="comment_editbox(this.id)" class="editbox">Edit
                                                                                </a>
                                                                            </div>
                                                                            <div id="editcancle' . $rowdata['artistic_post_comment_id'].'" style="display:none;">
                                                                                <a id="'.$rowdata['artistic_post_comment_id'].'" onClick="comment_editcancle(this.id)">Cancel
                                                                                </a>
                                                                            </div>
                                                                        </div>';
                                                                    } 
                                                                   
                                                                    $userid = $this->session->userdata('aileenuser');
                                                                    $art_userid = $this->db->get_where('art_post', array('art_post_id' => $rowdata['art_post_id'], 'status' => 1))->row()->user_id;

                                                                    if ($rowdata['user_id'] == $userid || $art_userid == $userid) {
                                                                        
                                        $return_html .= '<span role="presentation" aria-hidden="true"> · </span>
                                                                        <div class="comment-details-menu">
                                                                            <input type="hidden" name="post_delete"  id="post_delete'. $rowdata['artistic_post_comment_id'].'" value= "'.$rowdata['art_post_id'].'">
                                                                            <a id="'.$rowdata['artistic_post_comment_id'].'"   onClick="comment_delete(this.id)"> Delete<span class="insertcomment' . $rowdata['artistic_post_comment_id'].'">
                                                                                </span>
                                                                            </a>
                                                                        </div>';
                                                                 }
                                        $return_html .= '<span role="presentation" aria-hidden="true"> · </span>
                                                                    <div class="comment-details-menu">
                                                                        <p>'; 
                                                                                                                       
                                                                  $return_html .= date('d-M-Y', strtotime($rowdata['created_date']));
                                                                            $return_html .= '</br>';
                                                                            
                                        $return_html .= '</p></div></div>
                                                  </div>'; 
                                                 } }
                                          $return_html .= '</div>
                                       </div>
                                    </div>
                                    
                                       
                                 </div>
                              </div>
                              </div>';
                               }
                               //loop end for post 
                           $return_html .= '</div>
                        </div>';
                         }
                        // user post end 

                           // no data avaloble code  start
                        if(count($artuserdata) == 0 && count($artpostdata) == 0){
                        $return_html .= '<div class="profile_search" style="background-color: white; margin-bottom: 10px; margin-top: 10px; border-top: 1px solid #d9d9d9;"> <div class="inner_search"><div class="text-center rio">
                                                <h1 class="page-heading  product-listing" style="border:0px;margin-bottom: 11px;">Oops No Data Found.</h1>
                                                <p style="text-transform:none !important;border:0px;">We could not find what you were looking for.</p>
                                                <ul class="padding_less_left">
                                                    <li style="text-transform:none !important; list-style: none;">Make sure you used the right keywords.</li>
                                                </ul>
                         </div></div></div>';
                          }
                     //no data avaloble code  start


                $return_html .= '</div>';
                echo $return_html;
    }



 public function check_post_available($id) {
       

        $condition_array = array('art_post_id' => $id);
        $profile_data = $this->common->select_data_by_condition('art_post', $condition_array, $data = 'status,user_id,is_delete,posted_user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //echo "<pre>"; print_r($profile_data); die();
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

}
