<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');
class Freelancer_hire extends CI_Controller {

    public $data;
    
    public function __construct()
{

        parent::__construct();

        if (!$this->session->userdata('aileen_admin')) 
        {
            redirect('login', 'refresh');
        }
   
        // Get Site Information
        $this->data['title'] = 'Freelancer Hire Management | Aileensoul';
        $this->data['module_name'] = 'Freelancer Hire Management';

         //Loadin Pagination Custome Config File
         $this->config->load('paging', TRUE);
         $this->paging = $this->config->item('paging');
     
        include('include.php');
        

}

 //for list of all user start
public function user() 
{
       
// This is userd for pagination offset and limoi start
          $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $sortby = $this->uri->segment(3);

            $orderby = $this->uri->segment(4);

        } else {

            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

            $sortby = 'reg_id';

            $orderby = 'desc';

        }
  
        $this->data['offset'] = $offset;

       $data='reg_id,username,fullname,email,phone,country,state,city,status,created_date,modified_date,freelancer_hire_user_image';
       $contition_array = array('is_delete' => '0');
        $this->data['users'] = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str = array(), $groupby = '');
// This is userd for pagination offset and limoi End

//      echo "<pre>";print_r($this->data['users'] );
//      echo count($this->data['users']);die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['base_url'] = site_url("freelancer_hire/user/" . $short_by . "/" . $order_by);

        } else {

            $this->paging['base_url'] = site_url("freelancer_hire/user/");

        }

        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['uri_segment'] = 5;

        } else {

            $this->paging['uri_segment'] = 3;

        }
        //This if and else use for asc and desc while click on any field End

        $contition_array = array( 'is_delete =' => '0');
        $this->paging['total_rows'] = count($this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, 'reg_id'));
        $this->data['total_rows'] = $this->paging['total_rows'];
        $this->data['limit'] = $limit;
        $this->pagination->initialize($this->paging);
        $this->data['search_keyword'] = '';
        
        $this->load->view('freelancer_hire/index', $this->data);
    
}   
  //activate user with ajax Start
public function active_user() 
{
     $reg_id = $_POST['reg_id'];
      $data = array(
            'status' => 1
        );

        $update = $this->common->update_data($data, 'freelancer_hire_reg', 'reg_id', $reg_id);

        $select = '<td id= "active(' . $reg_id . ')">';
        $select = '<button class="btn btn-block btn-primary btn-sm"   onClick="deactive_user(' .  $reg_id . ')">
                              Active
                      </button>';
        $select .= '</td>';

        echo $select;

        die();
}
//activate user with ajax End  
    
//deactivate user with ajax Start
public function deactive_user() 
{
     $reg_id = $_POST['reg_id'];
      $data = array(
            'status' => 0
        );

        $update = $this->common->update_data($data, 'freelancer_hire_reg', 'reg_id', $reg_id);

         $select = '<td id= "active(' . $reg_id . ')">';
         $select .= '<button class="btn btn-block btn-success btn-sm"    onClick="active_user(' .  $reg_id . ')">
                              Deactive
                      </button>';
        $select .= '</td>';

        echo $select;
         die();
}
//deactivate user with ajax End
//Delete user with ajax Start
public function delete_user() 
{
     $reg_id = $_POST['reg_id'];
      $data = array(
            'is_delete' => 1
        );

        $update = $this->common->update_data($data, 'freelancer_hire_reg', 'reg_id', $reg_id);
        die();
}
//Delete user with ajax End
    
    public function search() 
{ 

      if ($this->input->post('search_keyword')) {//echo "222"; die();

          $this->data['search_keyword'] = $search_keyword = trim($this->input->post('search_keyword'));

         $this->session->set_userdata('user_search_keyword', $search_keyword);
    
        $this->data['user_search_keyword'] = $this->session->userdata('user_search_keyword');
      
       
             // This is userd for pagination offset and limoi start
          $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $sortby = $this->uri->segment(3);

            $orderby = $this->uri->segment(4);

        } else {

            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

            $sortby = 'reg_id';

            $orderby = 'asc';

        }
  
        $this->data['offset'] = $offset;
        
          $data='reg_id,username,fullname,email,phone,country,state,city,status,created_date,modified_date,freelancer_hire_user_image';
           $search_condition = "(username LIKE '%$search_keyword%' OR email LIKE '%$search_keyword%')";
            $contition_array = array('is_delete' => '0');
            $this->data['users'] = $this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array,$data, $sortby, $orderby, $limit, $offset);
 //echo "<pre>";print_r( $this->data['users']);die();
// This is userd for pagination offset and limoi End

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['base_url'] = site_url("freelancer_hire/search/" . $sortby . "/" . $orderby);

            } else {

                $this->paging['base_url'] = site_url("freelancer_hire/search/");

            }



            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['uri_segment'] = 5;

            } else {

                $this->paging['uri_segment'] = 3;

            }

            $this->paging['total_rows'] = count($this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array, 'reg_id'));

            //for record display

            $this->data['total_rows'] = $this->paging['total_rows'];

            $this->data['limit'] = $limit;

            $this->pagination->initialize($this->paging);

    }
    else if ($this->session->userdata('user_search_keyword')) {//echo "jii"; die();
            $this->data['search_keyword'] = $search_keyword = trim($this->session->userdata('user_search_keyword'));

// echo "<pre>";print_r($search_keyword);die();
              // This is userd for pagination offset and limoi start
          $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $sortby = $this->uri->segment(3);

            $orderby = $this->uri->segment(4);

        } else {

            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

            $sortby = 'reg_id';

            $orderby = 'asc';

        }
  
        $this->data['offset'] = $offset;
        
          $data='reg_id,username,fullname,email,phone,country,state,city,status,created_date,modified_date,freelancer_hire_user_image';
           $search_condition = "(username LIKE '%$search_keyword%' OR email LIKE '%$search_keyword%')";
            $contition_array = array('is_delete' => '0');
            $this->data['users'] = $this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array,$data, $sortby, $orderby, $limit, $offset);
 //echo "<pre>";print_r( $this->data['users']);die();
// This is userd for pagination offset and limoi End

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['base_url'] = site_url("freelancer_hire/search/" . $sortby . "/" . $orderby);

            } else {

                $this->paging['base_url'] = site_url("freelancer_hire/search/");

            }



            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['uri_segment'] = 5;

            } else {

                $this->paging['uri_segment'] = 3;

            }

            $this->paging['total_rows'] = count($this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array, 'reg_id'));

            //for record display

            $this->data['total_rows'] = $this->paging['total_rows'];

            $this->data['limit'] = $limit;

            $this->pagination->initialize($this->paging);
    }

        $this->load->view('freelancer_hire/index', $this->data);
}

//clear search is used for unset session start
public function clear_search() 
{ 
  
    if ($this->session->userdata('user_search_keyword')) 
    {
          
            $this->session->unset_userdata('user_search_keyword');
              
             redirect('freelancer_hire/user','refresh');          
    } 
}
//clear search is used for unset session End
    
// edit page for freelancer_hire user start
public function edit($reg_id){
   $data='reg_id,username ,fullname ,email ,skyupid ,phone,country,state,city,pincode,professional_info,freelancer_hire_user_image'; 
    $contition_array = array('is_delete' => '0','reg_id' => $reg_id);
     $user_data=$this->data['users'] = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str, $groupby);
     
     //for getting country data
     $contition_array = array('status' => 1);
        $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = '*', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        
        //for getting state data
        $contition_array = array('status' => 1, 'country_id' => $user_data[0]['country']);
        $this->data['states'] = $this->common->select_data_by_condition('states', $contition_array, $data = '*', $sortby = 'state_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //for getting city data
        $contition_array = array('status' => 1, 'state_id' => $user_data[0]['state']);
        $this->data['cities'] = $this->common->select_data_by_condition('cities', $contition_array, $data = '*', $sortby = 'city_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

     
    $this->load->view('freelancer_hire/edit', $this->data); 
}
//edit page for freelancer_hire user end


    public function ajax_data() {
//ajax data for category and subcategory start

        if (isset($_POST["category_id"]) && !empty($_POST["category_id"])) {
            //Get all state data
            $contition_array = array('category_id' => $_POST["category_id"], 'status' => 1);
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
 
public function edit_insert($id){
    
    
    if (empty($_FILES['profilepic']['name'])) {
         
           $user_image= $this->input->post('image_name');
          // echo $userimage;die();
           
        } else {
         
            $user_image = '';
            $user['upload_path'] = $this->config->item('free_hire_profile_main_upload_path');
            $user['allowed_types'] = $this->config->item('free_hire_profile_main_allowed_types');
            $user['max_size'] = $this->config->item('free_hire_profile_main_max_size');
            $user['max_width'] = $this->config->item('free_hire_profile_main_max_width');
            $user['max_height'] = $this->config->item('free_hire_profile_main_max_height');
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
                $user_thumb['new_image'] = $this->config->item('free_hire_profile_thumb_insert_path') . $imgdata['file_name'];
                $user_thumb['create_thumb'] = TRUE;
                $user_thumb['maintain_ratio'] = TRUE;
                $user_thumb['thumb_marker'] = '';
                $user_thumb['width'] = $this->config->item('free_hire_profile_thumb_width');
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
                $redirect_url = site_url('freelancer_hire/edit/'.$id);
                redirect($redirect_url, 'refresh');
            } else {
                $user_image = $imgdata['file_name'];
            }
    
}

 $data = array(
            'username' => trim($this->input->post('first_name')),
            'fullname' => trim($this->input->post('last_title')),
            'email' => trim($this->input->post('email_edit')),
            'skyupid' => trim($this->input->post('skype_id')),
            'phone' => $this->input->post('phoneno'),
            'country' =>$this->input->post('country'),
            'state' => $this->input->post('state'),
         'city' => trim($this->input->post('city')),
         'pincode' => trim($this->input->post('pincode_no')),
         'professional_info' => trim($this->input->post('professional_info')),
         'freelancer_hire_user_image'=>$user_image,
        );
     //echo "<pre>"; print_r($data);die();
      $updatdata = $this->common->update_data($data, 'freelancer_hire_reg', 'reg_id', $id);
            if ($updatdata) {
                 redirect('freelancer_hire/user', refresh);
            } else {
                $this->session->flashdata('error', 'Your data not inserted');
                redirect('freelancer_hire/edit/'.$id, refresh);
            }

}

public function project() 
{
      $date=date('Y-m-d', time()); 
// This is userd for pagination offset and limoi start
          $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $sortby = $this->uri->segment(3);

            $orderby = $this->uri->segment(4);

        } else {

            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

            $sortby = 'post_id';

            $orderby = 'desc';

        }
  
        $this->data['offset'] = $offset;

        $join_str[0]['table'] = 'freelancer_hire_reg';
        $join_str[0]['join_table_id'] = 'freelancer_hire_reg.user_id';
        $join_str[0]['from_table_id'] = 'freelancer_post.user_id';
        $join_str[0]['join_type'] = '';
        
       $data='freelancer_post.post_id,freelancer_post.post_name,freelancer_post.post_field_req,freelancer_post.post_skill,freelancer_post.post_exp_month,freelancer_post.post_exp_year,freelancer_post.created_date,freelancer_post.modify_date,freelancer_post.country,freelancer_post.state,freelancer_post.city,freelancer_post.user_id,freelancer_hire_reg.username,freelancer_hire_reg.fullname,freelancer_post.status';
       $contition_array = array('freelancer_post.is_delete' => '0','freelancer_post.post_last_date >='=>$date,'freelancer_post.status' => '1');
        $this->data['users'] = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str, $groupby = '');
// This is userd for pagination offset and limoi End

      //echo "<pre>";print_r($this->data['users'] );die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['base_url'] = site_url("freelancer_hire/project/" . $short_by . "/" . $order_by);

        } else {

            $this->paging['base_url'] = site_url("freelancer_hire/project/");

        }

        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['uri_segment'] = 5;

        } else {

            $this->paging['uri_segment'] = 3;

        }
        //This if and else use for asc and desc while click on any field End

        $contition_array = array( 'is_delete =' => '0','post_last_date >='=>$date);
        $this->paging['total_rows'] = count($this->common->select_data_by_condition('freelancer_post', $contition_array, 'post_id'));
        $this->data['total_rows'] = $this->paging['total_rows'];
        $this->data['limit'] = $limit;
        $this->pagination->initialize($this->paging);
        $this->data['search_keyword'] = '';
        
        $this->load->view('freelancer_hire/post', $this->data);
    
}

public function post_profile($id=''){
    $date=date('Y-m-d', time());
    $contition_array = array('is_delete' => '0','post_id' => $id,'status'=>'1','post_last_date >='=>$date);
     $post_data=$this->data['post_data'] = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data='*', $sortby, $orderby, $limit, $offset, $join_str, $groupby);
     
     $contition_array = array('type' => '1','status'=>'1');
     $skill_data=$this->data['skill'] = $this->common->select_data_by_condition('skill', $contition_array, $data='*', $sortby, $orderby, $limit, $offset, $join_str, $groupby);
   // echo "<pre>";print_r($post_data);die();
    $this->load->view('freelancer_hire/view_post', $this->data);
    
}

}