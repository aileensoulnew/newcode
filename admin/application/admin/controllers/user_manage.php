<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_manage extends CI_Controller {

    public $data;

    public function __construct() {

        parent::__construct();

        if (!$this->session->userdata('aileen_admin')) {
            redirect('login', 'refresh');
        }

        // Get Site Information
        $this->data['title'] = 'User Management | Aileensoul';
        $this->data['module_name'] = 'User Management';

        //Loadin Pagination Custome Config File
        $this->config->load('paging', TRUE);
        $this->paging = $this->config->item('paging');

        include('include.php');
    }

//for list of all user start
    public function user() {
        // This is userd for pagination offset and limoi start
          $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $sortby = $this->uri->segment(3);

            $orderby = $this->uri->segment(4);

        } else {

            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

            $sortby = 'user_id';

            $orderby = 'desc';

        }
  
        $this->data['offset'] = $offset;

       $data='user_id,first_name ,last_name ,user_email ,user_dob ,user_gender,user_image,status ,created_date,modified_date';
       $contition_array = array('is_delete' => '0');
        $this->data['users'] = $this->common->select_data_by_condition('user', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str = array(), $groupby = '');
// This is userd for pagination offset and limoi End

      //echo "<pre>";print_r($this->data['users'] );die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['base_url'] = site_url("user_manage/user/" . $short_by . "/" . $order_by);

        } else {

            $this->paging['base_url'] = site_url("user_manage/user/");

        }

        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['uri_segment'] = 5;

        } else {

            $this->paging['uri_segment'] = 3;

        }
        //This if and else use for asc and desc while click on any field End


        $contition_array = array( 'is_delete =' => '0');
        $this->paging['total_rows'] = count($this->common->select_data_by_condition('user', $contition_array, 'user_id'));

        $this->data['total_rows'] = $this->paging['total_rows'];

        $this->data['limit'] = $limit;

        $this->pagination->initialize($this->paging);

        $this->data['search_keyword'] = '';

        
        $this->load->view('users/index', $this->data);
    }
    //activate user with ajax Start
public function active_user() 
{
     $user_id = $_POST['user_id'];
      $data = array(
            'status' => '1'
        );
        $update = $this->common->update_data($data, 'user', 'user_id', $user_id);

        $select = '<td id= "active(' . $user_id . ')">';
        $select = '<button class="btn btn-block btn-primary btn-sm"   onClick="deactive_user(' .  $user_id . ')">
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
     $user_id = $_POST['user_id'];
      $data = array(
            'status' => '0'
        );

        $update = $this->common->update_data($data, 'user', 'user_id', $user_id);

         $select = '<td id= "active(' . $user_id . ')">';
         $select .= '<button class="btn btn-block btn-success btn-sm"    onClick="active_user(' .  $user_id . ')">
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
  
     $user_id = $_POST['user_id'];
      $data = array(
            'is_delete' => '1'
        );
       $data1 = array(
            'is_deleted' => '1'
        );

        $update = $this->common->update_data($data, 'user', 'user_id', $user_id);
        $update1 = $this->common->update_data($data, 'recruiter', 'user_id', $user_id);
        $update2 = $this->common->update_data($data, 'rec_post', 'user_id', $user_id);
        $update3 = $this->common->update_data($data, 'job_add_edu', 'user_id', $user_id);
        $update4 = $this->common->update_data($data, 'job_add_workexp', 'user_id', $user_id);
        $update5 = $this->common->update_data($data, 'job_apply', 'user_id', $user_id);
        $update6 = $this->common->update_data($data, 'job_graduation', 'user_id', $user_id);
        $update7 = $this->common->update_data($data, 'job_reg', 'user_id', $user_id);
        $update8 = $this->common->update_data($data, 'university', 'user_id', $user_id);
        $update9 = $this->common->update_data($data, 'job_industry', 'user_id', $user_id);
        $update10 = $this->common->update_data($data, 'stream', 'user_id', $user_id);
        $update11 = $this->common->update_data($data, 'degree', 'user_id', $user_id);
        $update12 = $this->common->update_data($data1, 'business_profile', 'user_id', $user_id);
        $update13 = $this->common->update_data($data, 'business_profile_post', 'user_id', $user_id);
        $update14 = $this->common->update_data($data, 'business_profile_post_comment', 'user_id', $user_id);
        $update15 = $this->common->update_data($data, 'business_profile_save', 'user_id', $user_id);
        $update16 = $this->common->update_data($data, 'bus_comment_image_like', 'user_id', $user_id);
        $update17 = $this->common->update_data($data, 'bus_post_image_comment', 'user_id', $user_id);
        $update18 = $this->common->update_data($data, 'bus_post_image_like', 'user_id', $user_id);
        $update19 = $this->common->update_data($data, 'artistic_post_comment', 'user_id', $user_id);
        $update20 = $this->common->update_data($data, 'art_comment_image_like', 'user_id', $user_id);
        $update21 = $this->common->update_data($data, 'art_post', 'user_id', $user_id);
        $update22 = $this->common->update_data($data, 'art_post_image_comment', 'user_id', $user_id);
        $update23 = $this->common->update_data($data, 'art_post_image_like', 'user_id', $user_id);
        $update24 = $this->common->update_data($data, 'art_reg', 'user_id', $user_id);
        $update25 = $this->common->update_data($data, 'art_post_save', 'user_id', $user_id);
        $update26 = $this->common->update_data($data, 'freelancer_apply', 'user_id', $user_id);
        $update27 = $this->common->update_data($data, 'freelancer_hire_reg', 'user_id', $user_id);
        $update28 = $this->common->update_data($data, 'freelancer_post', 'user_id', $user_id);
        $update29 = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $user_id);
        die();
}
//Delete user with ajax End

public function search(){
    
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

            $sortby = 'user_id';

            $orderby = 'asc';

        }
  
        $this->data['offset'] = $offset;
        
          $data='user_id,first_name ,last_name ,user_email ,user_dob ,user_gender,user_image,status ,created_date,modified_date';
           $search_condition = "(first_name LIKE '%$search_keyword%' OR user_email LIKE '%$search_keyword%')";
            $contition_array = array('is_delete' => '0');
            $this->data['users'] = $this->common->select_data_by_search('user', $search_condition, $contition_array,$data, $sortby, $orderby, $limit, $offset);
 //echo "<pre>";print_r( $this->data['users']);die();
// This is userd for pagination offset and limoi End

       // echo "<pre>";print_r($this->userdata['users'] );die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['base_url'] = site_url("user_manage/search/" . $sortby . "/" . $orderby);

            } else {

                $this->paging['base_url'] = site_url("user_manage/search/");

            }



            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['uri_segment'] = 5;

            } else {

                $this->paging['uri_segment'] = 3;

            }

            $this->paging['total_rows'] = count($this->common->select_data_by_search('user', $search_condition, $contition_array, 'user_id'));

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

            $sortby = 'user_id';

            $orderby = 'asc';

        }
  
        $this->data['offset'] = $offset;
        
          $data='user_id,first_name ,last_name ,user_email ,user_dob ,user_gender,user_image,status ,created_date,modified_date';
           $search_condition = "(first_name LIKE '%$search_keyword%' OR user_email LIKE '%$search_keyword%')";
            $contition_array = array('is_delete' => '0');
            $this->data['users'] = $this->common->select_data_by_search('user', $search_condition, $contition_array,$data, $sortby, $orderby, $limit, $offset);
 //echo "<pre>";print_r( $this->data['users']);die();
// This is userd for pagination offset and limoi End

       // echo "<pre>";print_r($this->userdata['users'] );die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['base_url'] = site_url("user_manage/search/" . $sortby . "/" . $orderby);

            } else {

                $this->paging['base_url'] = site_url("user_manage/search/");

            }



            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['uri_segment'] = 5;

            } else {

                $this->paging['uri_segment'] = 3;

            }

            $this->paging['total_rows'] = count($this->common->select_data_by_search('user', $search_condition, $contition_array, 'user_id'));

            //for record display

            $this->data['total_rows'] = $this->paging['total_rows'];

            $this->data['limit'] = $limit;

            $this->pagination->initialize($this->paging);
    }

        $this->load->view('users/index', $this->data);
    
}

//clear search is used for unset session start
public function clear_search() 
{ 
    if ($this->session->userdata('user_search_keyword')) 
    {
          
            $this->session->unset_userdata('user_search_keyword');
              
             redirect('user_manage/user','refresh');          
    } 
}
//clear search is used for unset session End


public function edit($user_id){
   
   $data='user_id,first_name ,last_name ,user_email ,user_dob ,user_gender,user_image'; 
    $contition_array = array('is_delete' => '0','user_id' => $user_id);
     $user_data=$this->data['users'] = $this->common->select_data_by_condition('user', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str, $groupby);
     $dob=$user_data[0]['user_dob'];
     $dob_final=explode('-',$dob);
     $this->data['year']=$dob_final[0];
     $this->data['month']=$dob_final[1];
     $day = $this->data['day'] = $dob_final[2];
    $this->load->view('users/edit', $this->data); 
    
}
public function edit_insert($id){
    
     $date = $this->input->post('select_day');
      $month = $this->input->post('select_month');
      $year = $this->input->post('select_year');
      $dob = $year . '-' . $month . '-' . $date;
      
      
       if (empty($_FILES['profilepic']['name'])) {
         
           $user_image= $this->input->post('image_name');
          // echo $userimage;die();
           
        } else {
         
            $user_image = '';
            $user['upload_path'] = $this->config->item('user_main_upload_path');
            $user['allowed_types'] = $this->config->item('user_main_allowed_types');
            $user['max_size'] = $this->config->item('user_main_max_size');
            $user['max_width'] = $this->config->item('user_main_max_width');
            $user['max_height'] = $this->config->item('user_main_max_height');
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
                $user_thumb['new_image'] = $this->config->item('user_thumb_insert_upload_path') . $imgdata['file_name'];
                $user_thumb['create_thumb'] = TRUE;
                $user_thumb['maintain_ratio'] = TRUE;
                $user_thumb['thumb_marker'] = '';
                $user_thumb['width'] = $this->config->item('user_thumb_width');
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
                $redirect_url = site_url('user_manage/edit/'.$id);
                redirect($redirect_url, 'refresh');
            } else {
                $user_image = $imgdata['file_name'];
            }

            $data = array(
            'first_name' => trim($this->input->post('first_name')),
            'last_name' => trim($this->input->post('last_name')),
            'user_email' => trim($this->input->post('user_email')),
            'user_dob' => $dob,
            'user_gender' => $this->input->post('gender'),
            'user_image' => $user_image,
            'modified_date' => date('Y-m-d', time()),
        );

          //  echo "<pre>"; print_r($data);die();
            $updatdata = $this->common->update_data($data, 'user', 'user_id', $id);

            if ($updatdata) {
               
                 redirect('user_manage/user', refresh);
               
            } else {
               
                $this->session->flashdata('error', 'Your data not inserted');
                redirect('user_manage/edit/'.$id, refresh);
            }
        
      
    
         
    
    
    
}







}



}
