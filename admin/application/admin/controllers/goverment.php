<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Goverment extends MY_Controller {

    public $data;
 

    public function __construct() {

      parent::__construct();

        if (!$this->session->userdata('aileen_admin')) 
        {
            redirect('login', 'refresh');
        }
   
    
         //Loadin Pagination Custome Config File
         $this->config->load('paging', TRUE);
         $this->paging = $this->config->item('paging');
         include('include.php');
         $adminid =  $this->session->userdata('aileen_admin');
   
       // echo $this->profile->thumb();
    }


 public function add_gov_category() 
 {

        $this->data['title'] = 'Goverment Job Category| Aileensoul';
        $this->data['module_name'] = 'Goverment Job Category';
        $this->data['section_title'] = 'Goverment Job Category';

        $this->load->view('goverment/add_gov_category', $this->data);
}


public function add_gov_category_insert() 
 {
        //echo "<pre>"; print_r($this->input->post()); die();

         $config = array(
            'upload_path' => $this->config->item('gov_cat_main_upload_path'),
            'max_size' => 2500000000000,
            'allowed_types' => $this->config->item('gov_cat_main_allowed_types'),
            'file_name' => $_FILES['cat_image']['name']
               
        );

        //Load upload library and initialize configuration
        $images = array();
        $files = $_FILES;

        //echo "<pre>"; print_r($files); die();
        $this->load->library('upload');

            $fileName = $_FILES['cat_image']['name'];
            $images[] = $fileName;
            $config['file_name'] = $fileName;

         $this->upload->initialize($config);
        $this->upload->do_upload();  
        if($this->upload->do_upload('cat_image')){ 
        
         $data = array(
                'name' => trim($this->input->post('gov_name')),
                'image' => $fileName,
                'status' => $this->input->post('status'),
                'created_date' => date('Y-m-d H:i:s', time()),
                'is_delete' => '0'
            );

            $insert_id = $this->common->insert_data_getid($data, 'gov_category');

         }


            if ($insert_id) {
                $this->session->set_flashdata('success', 'Category inserted successfully');
                 redirect('goverment/add_gov_category');
            } else {
                $this->session->flashdata('error', 'Sorry!! Your data not inserted');
                redirect('goverment/add_gov_category');
            }

           
}

public function check_category()
{

        $category = trim($_POST['gov_name']);
        $contition_array = array('name' => $category);
         $checkvalue = $this->common->select_data_by_condition('gov_category', $contition_array, $data = 'id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
         if($checkvalue){
            echo 'false'; die();
         }else{
            echo 'true'; die();
         }

}

public function view_gov_category(){


        $this->data['title'] = 'Goverment Job Category List| Aileensoul';
        $this->data['module_name'] = 'Goverment Job Category List';
        $this->data['section_title'] = 'Goverment Job Category List';


         $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $sortby = $this->uri->segment(3);

            $orderby = $this->uri->segment(4);

        } else {

            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

            $sortby = 'id';

            $orderby = 'asc';

        }
  
        $this->data['offset'] = $offset;

       $data='id,name,image,created_date,modified_date,status,is_delete';
       $contition_array = array('is_delete' => '0');
        $this->data['category'] = $this->common->select_data_by_condition('gov_category', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str = array(), $groupby = '');
// This is userd for pagination offset and limoi End

      //echo "<pre>";print_r($this->data['users'] );die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['base_url'] = site_url("goverment/view_gov_category/" . $short_by . "/" . $order_by);

        } else {

            $this->paging['base_url'] = site_url("goverment/view_gov_category/");

        }

        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['uri_segment'] = 5;

        } else {

            $this->paging['uri_segment'] = 3;

        }
        //This if and else use for asc and desc while click on any field End


        $contition_array = array( 'is_delete =' => '0');
        $this->paging['total_rows'] = count($this->common->select_data_by_condition('gov_category', $contition_array, 'id'));

        $this->data['total_rows'] = $this->paging['total_rows'];

        $this->data['limit'] = $limit;

        $this->pagination->initialize($this->paging);

        $this->data['search_keyword'] = '';

 
        $this->load->view('goverment/view_gov_category', $this->data);

}


//Delete category with ajax Start
public function delete_category() 
{
     $id = $_POST['id'];
      $data = array(
            'is_delete' => '1'
        );

        $update = $this->common->update_data($data, 'gov_category', 'id', $id);
        die();
}
//Delete category with ajax End



public function category_search() 
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

            $sortby = 'id';

            $orderby = 'asc';

        }
  
        $this->data['offset'] = $offset;
        
          $data='id,name,image,created_date,modified_date,status';
           $search_condition = "(name LIKE '%$search_keyword%')";
            $contition_array = array('is_delete' => '0');
            $this->data['category'] = $this->common->select_data_by_search('gov_category', $search_condition, $contition_array,$data, $sortby, $orderby, $limit, $offset);
 //echo "<pre>";print_r( $this->data['users']);die();
// This is userd for pagination offset and limoi End

       // echo "<pre>";print_r($this->userdata['users'] );die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['base_url'] = site_url("goverment/category_search/" . $sortby . "/" . $orderby);

            } else {

                $this->paging['base_url'] = site_url("goverment/category_search/");

            }



            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['uri_segment'] = 5;

            } else {

                $this->paging['uri_segment'] = 3;

            }

            $this->paging['total_rows'] = count($this->common->select_data_by_search('gov_category', $search_condition, $contition_array, 'id'));

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

            $sortby = 'id';

            $orderby = 'asc';

        }
  
        $this->data['offset'] = $offset;
        
          $data='id,name,image,created_date,modified_date,status';
           $search_condition = "(name LIKE '%$search_keyword%')";
            $contition_array = array('is_delete' => '0');
            $this->data['category'] = $this->common->select_data_by_search('gov_category', $search_condition, $contition_array,$data, $sortby, $orderby, $limit, $offset);
 //echo "<pre>";print_r( $this->data['users']);die();
// This is userd for pagination offset and limoi End

       // echo "<pre>";print_r($this->userdata['users'] );die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['base_url'] = site_url("goverment/category_search/" . $sortby . "/" . $orderby);

            } else {

                $this->paging['base_url'] = site_url("goverment/category_search/");

            }



            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['uri_segment'] = 5;

            } else {

                $this->paging['uri_segment'] = 3;

            }

            $this->paging['total_rows'] = count($this->common->select_data_by_search('gov_category', $search_condition, $contition_array, 'id'));

            //for record display

            $this->data['total_rows'] = $this->paging['total_rows'];

            $this->data['limit'] = $limit;

            $this->pagination->initialize($this->paging);
    }

        $this->load->view('goverment/view_gov_category', $this->data);
}

//clear search is used for unset session start
public function clear_categorysearch() 
{ 
  
    if ($this->session->userdata('user_search_keyword')) 
    {
          
            $this->session->unset_userdata('user_search_keyword');
              
             redirect('goverment/view_gov_category','refresh');          
    } 
}
//clear search is used for unset session End



 public function edit_gov_category($id) 
 {

        $this->data['title'] = 'Goverment Edit Job Category| Aileensoul';
        $this->data['module_name'] = 'Goverment Edit Job Category';
        $this->data['section_title'] = 'Goverment Edit Job Category';

       $data='id,name,image,created_date,modified_date,status,is_delete';
       $contition_array = array('id' => $id);
        $this->data['category'] = $this->common->select_data_by_condition('gov_category', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str = array(), $groupby = '');

        $this->data['id'] = $id;

        //echo "<pre>"; print_r($this->data['category']); die();

        $this->load->view('goverment/edit_gov_category', $this->data);
}


public function edit_gov_category_insert($id) 
 {
        //echo "<pre>"; print_r($this->input->post()); die();

        if (empty($_FILES['cat_image']['name'])) {
           $fileName= $this->input->post('old_image');
           
        } else {

            $config = array(
            'upload_path' => $this->config->item('gov_cat_main_upload_path'),
            'max_size' => 2500000000000,
            'allowed_types' => $this->config->item('gov_cat_main_allowed_types'),
            'file_name' => $_FILES['cat_image']['name']
               
        );

        //Load upload library and initialize configuration
        $images = array();
        $files = $_FILES;

        //echo "<pre>"; print_r($files); die();
        $this->load->library('upload');

            $fileName = $_FILES['cat_image']['name'];
            $images[] = $fileName;
            $config['file_name'] = $fileName;

         $this->upload->initialize($config);
         $this->upload->do_upload('cat_image');  

        }        
         $data = array(
                'name' => $this->input->post('gov_name'),
                'image' => trim($fileName),
                'status' => $this->input->post('status'),
                'modified_date' => date('Y-m-d H:i:s', time()),
            );
//echo "<pre>"; print_r($data); die();
            $updatdata = $this->common->update_data($data, 'gov_category', 'id', $id);

            if ($updatdata) {
                $this->session->set_flashdata('success', 'Category updated successfully');
                 redirect('goverment/view_gov_category');
            } else {
                $this->session->flashdata('error', 'Sorry!! Your data not inserted');
                redirect('goverment/edit_gov_category/'.$id);
            }
           
}

public function add_gov_post() 
 {

        $this->data['title'] = 'Goverment Job Post| Aileensoul';
        $this->data['module_name'] = 'Goverment Job Post';
        $this->data['section_title'] = 'Goverment Job Post';

         $contition_array = array('status' => '1', 'is_delete' => '0');
         $this->data['job_category'] = $this->common->select_data_by_condition('gov_category', $contition_array, $data = 'id,name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');  

        $this->load->view('goverment/add_gov_post', $this->data);
}



public function add_gov_post_insert() 
 {
        //echo "<pre>"; print_r($this->input->post()); die();

       $date = $this->input->post('selday');
       $month = $this->input->post('selmonth');
       $year = $this->input->post('selyear');
       $last_date = $year . '-' . $month . '-' . $date;


         $config = array(
            'upload_path' => $this->config->item('gov_post_main_upload_path'),
            'max_size' => 2500000000000,
            'allowed_types' => $this->config->item('gov_post_main_allowed_types'),
            'file_name' => $_FILES['post_image']['name']
               
        );

        //Load upload library and initialize configuration
        $images = array();
        $files = $_FILES;

        //echo "<pre>"; print_r($files); die();
        $this->load->library('upload');

            $fileName = $_FILES['post_image']['name'];
            $images[] = $fileName;
            $config['file_name'] = $fileName;

         $this->upload->initialize($config);
        $this->upload->do_upload();     
        if ($this->upload->do_upload('post_image')) {

             $response['result']= $this->upload->data();
                $gov_post_thumb['image_library'] = 'gd2';
                $gov_post_thumb['source_image'] = $this->config->item('gov_post_main_upload_path') . $response['result']['file_name'];
                $gov_post_thumb['new_image'] = $this->config->item('gov_post_thumb_upload_path') . $response['result']['file_name'];
                $gov_post_thumb['create_thumb'] = TRUE;
                $gov_post_thumb['maintain_ratio'] = TRUE;
                $gov_post_thumb['thumb_marker'] = '';
                $gov_post_thumb['width'] = $this->config->item('gov_post_thumb_width');
                $gov_post_thumb['height'] = 2;
                $gov_post_thumb['master_dim'] = 'width';
                $gov_post_thumb['quality'] = "100%";
                $gov_post_thumb['x_axis'] = '0';
                $gov_post_thumb['y_axis'] = '0';
                $instanse = "image_$i";
                //Loading Image Library
                $this->load->library('image_lib', $gov_post_thumb, $instanse);
                $dataimage = $response['result']['file_name'];

               // echo "<pre>"; print_r($dataimage); die();

                //Creating Thumbnail
                $this->$instanse->resize();
                $response['error'][] = $thumberror = $this->$instanse->display_errors();
                
                
                $return['data'][] = $this->upload->data();
                $return['status'] = "success";
                $return['msg'] = sprintf($this->lang->line('success_item_added'), "Image", "uploaded");
        } 


         $data = array(
                'title' => trim($this->input->post('post_title')),
                'category_id' => $this->input->post('category'),
                'post_name' => trim($this->input->post('postname')),
                'no_vacancies' => trim($this->input->post('novacan')),
                'pay_scale' => trim($this->input->post('payscale')),
                'job_location' => trim($this->input->post('jobloc')),
                'req_exp' => trim($this->input->post('reqexp')),
                'post_image' => trim($dataimage),
                'sector' => trim($this->input->post('gov_sector')),
                'eligibility' => trim($this->input->post('gov_elg')),
                'last_date' => $last_date,
                'description' => $this->input->post('gov_des'),
                'apply_link' => trim($this->input->post('gov_link')),
                'status' => $this->input->post('status'),
                'created_date' => date('Y-m-d H:i:s', time()),
                'is_delete' => '0'
            );

            $insert_id = $this->common->insert_data_getid($data, 'gov_post');


            if ($insert_id) {
                $this->session->set_flashdata('success', 'Job Post inserted successfully');
                 redirect('goverment/add_gov_post');
            } else {
                $this->session->flashdata('error', 'Sorry!! Your data not inserted');
                redirect('goverment/add_gov_post');
            }

           
}


public function view_gov_post(){


        $this->data['title'] = 'Goverment Job Post List| Aileensoul';
        $this->data['module_name'] = 'Goverment Job Post List';
        $this->data['section_title'] = 'Goverment Job Post List';


         $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $sortby = $this->uri->segment(3);

            $orderby = $this->uri->segment(4);

        } else {

            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

            $sortby = 'id';

            $orderby = 'asc';

        }
  
        $this->data['offset'] = $offset;

       $data='id,title,category_id,post_name,no_vacancies,pay_scale,job_location,req_exp,post_image,sector,eligibility,last_date,description,apply_link,created_date,modified_date,status';
       $contition_array = array('is_delete' => '0');
        $this->data['post'] = $this->common->select_data_by_condition('gov_post', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str = array(), $groupby = '');
// This is userd for pagination offset and limoi End

      //echo "<pre>";print_r($this->data['users'] );die();

        //This if and else use for asc and desc while click on any field start
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['base_url'] = site_url("goverment/view_gov_post/" . $short_by . "/" . $order_by);

        } else {

            $this->paging['base_url'] = site_url("goverment/view_gov_post/");

        }

        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $this->paging['uri_segment'] = 5;

        } else {

            $this->paging['uri_segment'] = 3;

        }
        //This if and else use for asc and desc while click on any field End


        $contition_array = array( 'is_delete =' => '0');
        $this->paging['total_rows'] = count($this->common->select_data_by_condition('gov_post', $contition_array, 'id'));

        $this->data['total_rows'] = $this->paging['total_rows'];

        $this->data['limit'] = $limit;

        $this->pagination->initialize($this->paging);

        $this->data['search_keyword'] = '';

 
        $this->load->view('goverment/view_gov_post', $this->data);

}


//Delete category with ajax Start
public function delete_post() 
{
     $id = $_POST['id'];
      $data = array(
            'is_delete' => '1'
        );

        $update = $this->common->update_data($data, 'gov_post', 'id', $id);
        die();
}
//Delete category with ajax End



public function post_search() 
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

            $sortby = 'id';

            $orderby = 'asc';

        }
  
        $this->data['offset'] = $offset;
        
          $data='id,title,category_id,post_name,no_vacancies,pay_scale,job_location,req_exp,sector,eligibility,last_date,description,apply_link,created_date,modified_date,status';
           $search_condition = "(title LIKE '%$search_keyword%')";
            $contition_array = array('is_delete' => '0');
            $this->data['post'] = $this->common->select_data_by_search('gov_post', $search_condition, $contition_array,$data, $sortby, $orderby, $limit, $offset);

        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['base_url'] = site_url("goverment/post_search/" . $sortby . "/" . $orderby);

            } else {

                $this->paging['base_url'] = site_url("goverment/post_search/");

            }



            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['uri_segment'] = 5;

            } else {

                $this->paging['uri_segment'] = 3;

            }

            $this->paging['total_rows'] = count($this->common->select_data_by_search('gov_post', $search_condition, $contition_array, 'id'));

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

            $sortby = 'id';

            $orderby = 'asc';

        }
  
        $this->data['offset'] = $offset;
        
          $data='id,title,category_id,post_name,no_vacancies,pay_scale,job_location,req_exp,sector,eligibility,last_date,description,apply_link,created_date,modified_date,status';
           $search_condition = "(title LIKE '%$search_keyword%')";
            $contition_array = array('is_delete' => '0');
            $this->data['post'] = $this->common->select_data_by_search('gov_post', $search_condition, $contition_array,$data, $sortby, $orderby, $limit, $offset);
 
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['base_url'] = site_url("goverment/post_search/" . $sortby . "/" . $orderby);

            } else {

                $this->paging['base_url'] = site_url("goverment/post_search/");

            }



            if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

                $this->paging['uri_segment'] = 5;

            } else {

                $this->paging['uri_segment'] = 3;

            }

            $this->paging['total_rows'] = count($this->common->select_data_by_search('gov_post', $search_condition, $contition_array, 'id'));

            $this->data['total_rows'] = $this->paging['total_rows'];

            $this->data['limit'] = $limit;

            $this->pagination->initialize($this->paging);
    }

        $this->load->view('goverment/view_gov_post', $this->data);
}

//clear search is used for unset session start
public function clear_postsearch() 
{ 
  
    if ($this->session->userdata('user_search_keyword')) 
    {
          
            $this->session->unset_userdata('user_search_keyword');
              
             redirect('goverment/view_gov_post','refresh');          
    } 
}
//clear search is used for unset session End



public function edit_gov_post($id) 
 {

        $this->data['title'] = 'Goverment Edit Job Post| Aileensoul';
        $this->data['module_name'] = 'Goverment Edit Job Post';
        $this->data['section_title'] = 'Goverment Edit Job Post';

       $data='id,title,category_id,post_name,no_vacancies,pay_scale,job_location,req_exp,post_image,sector,eligibility,last_date,description,apply_link,created_date,modified_date,status';
       $contition_array = array('id' => $id);
        $this->data['post'] = $this->common->select_data_by_condition('gov_post', $contition_array, $data, $sortby, $orderby, $limit, $offset, $join_str = array(), $groupby = '');

        $this->data['id'] = $id;


        $contition_array = array('status' => '1', 'is_delete' => '0');
         $this->data['job_category'] = $this->common->select_data_by_condition('gov_category', $contition_array, $data = 'id,name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');  


        //echo "<pre>"; print_r($this->data['category']); die();

        $this->load->view('goverment/edit_gov_post', $this->data);
}
public function edit_gov_post_insert($id ='') 
 {
        $date = $this->input->post('selday');
        $month = $this->input->post('selmonth');
        $year = $this->input->post('selyear');
        $last_date = $year . '-' . $month . '-' . $date;
        
        if (empty($_FILES['post_image']['name'])) {
         
           $gov_image= $this->input->post('old_image');
          // echo $userimage;die();
           
        } else {
       
             $gov_image = '';
            $user['upload_path'] = $this->config->item('gov_post_main_upload_path');
            $user['allowed_types'] = $this->config->item('gov_post_main_allowed_types');
            $user['max_size'] = $this->config->item('gov_post_main_max_size');
            $user['max_width'] = $this->config->item('gov_post_main_max_width');
            $user['max_height'] = $this->config->item('gov_post_main_max_height');
            $this->load->library('upload');
            $this->upload->initialize($user);
            //Uploading Image
            $this->upload->do_upload('post_image');
            //Getting Uploaded Image File Data
            $imgdata = $this->upload->data();
            $imgerror = $this->upload->display_errors();
          
            
             if ($imgerror == '') {
               
                //Configuring Thumbnail 
                $gov_thumb['image_library'] = 'gd2';
                $gov_thumb['source_image'] = $user['upload_path'] . $imgdata['file_name'];
                $gov_thumb['new_image'] = $this->config->item('gov_post_thumb_upload_path') . $imgdata['file_name'];
                $gov_thumb['create_thumb'] = TRUE;
                $gov_thumb['maintain_ratio'] = TRUE;
                $gov_thumb['thumb_marker'] = '';
                $gov_thumb['width'] = $this->config->item('gov_post_thumb_width');
                //$user_thumb['height'] = $this->config->item('user_thumb_height');
                $gov_thumb['height'] = 2;
                $gov_thumb['master_dim'] = 'width';
                $gov_thumb['quality'] = "100%";
                $gov_thumb['x_axis'] = '0';
                $gov_thumb['y_axis'] = '0';
                //Loading Image Library
                $this->load->library('image_lib', $gov_thumb);
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
                $redirect_url = site_url('goverment/edit_gov_post/'.$id);
                redirect($redirect_url, 'refresh');
            } else {
                $gov_image = $imgdata['file_name'];
            }
            
   
        
        }   
        
        $data = array(
                'title' => $this->input->post('post_title'),
                'category_id' => $this->input->post('category'),
                'post_name' => $this->input->post('postname'),
                'no_vacancies' => $this->input->post('novacan'),
                'pay_scale' => $this->input->post('payscale'),
                'job_location' => $this->input->post('jobloc'),
                'req_exp' => $this->input->post('reqexp'),
                'post_image' => $gov_image,
                'sector' => $this->input->post('gov_sector'),
                'eligibility' => $this->input->post('gov_elg'),
                'last_date' => $last_date,
                'description' => $this->input->post('gov_des'),
                'apply_link' => $this->input->post('gov_link'),
                'status' => $this->input->post('status'),
                'created_date' => date('Y-m-d H:i:s', time()),
                'is_delete' => '0',
                'modified_date'=> date('Y-m-d H:i:s', time())
            );
        
        
      //  echo "<pre>"; print_r($this->input->post()); die();
         

            $updatdata = $this->common->update_data($data, 'gov_post', 'id', $id);

            if ($updatdata) {
                $this->session->set_flashdata('success', 'Category updated successfully');
                 redirect('goverment/view_gov_post');
            } else {
                $this->session->flashdata('error', 'Sorry!! Your data not inserted');
                redirect('goverment/edit_gov_post/'.$id);
            }
           
}


}

