<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rmessage extends MY_Controller {

    public $data;

    public function __construct() {
        parent::__construct();

        $this->load->helper('smiley');

        //AWS access info start
        $this->load->library('S3');
        //AWS access info end
        $this->load->model('recruiter_model');
        $this->load->model('message_model');
        $this->load->model('rmessage_model');
        include('rec_include.php');
    }

    public function index() {
        $this->load->view('message/index');
    }
    
    public function recruiter_profile($job_slug = '') { 
    $this->data['recruiter_profile_id'] =    $recruiter_profile_id = $this->data['recdata'][0]['rec_id'];  
        $user_data = $this->recruiter_model->getJobDataBySlug($job_slug, $select_data = "job_id,fname,lname,slug,designation");
        $this->data['user_data'] = $user_data;
       
      
//        if ($user_data['business_type'] != '' || $user_data['business_type'] != 'null') {
//            $this->data['user_data']['business_type'] = $this->business_model->getBusinessTypeName($user_data['business_type']);
//        }
//        if ($user_data['industriyal'] != '' || $user_data['industriyal'] != 'null') {
//            $this->data['user_data']['industriyal'] = $this->business_model->getIndustriyalName($user_data['industriyal']);
//        }
        $this->data['user_data']['chat'] = $this->rmessage_model->getJObChat($recruiter_profile_id, $user_data['job_id']);
        $this->load->view('message/recruiter_profile', $this->data);
    }
    
    public function recruiterMessageInsert() {
        $userid = $this->session->userdata('aileenuser');

        $job_slug = $_POST['job_slug'];
//        $user_data = $this->recruiter_model->getBusinessDataBySlug($business_slug, $select_data = "business_profile_id,user_id");
        $user_data = $this->recruiter_model->getJobDataBySlug($job_slug, $select_data = "job_id,user_id");

        $message = $_POST['message'];
        $message_file = '';
        $message_file_type = '';
        $message_file_size = '';
        $message_from = $userid;
        $message_to = $user_data['user_id'];
        $message_from_profile = '2';
        $message_from_profile_id = $this->data['recdata'][0]['rec_id'];
        $message_to_profile = '1';
        $message_to_profile_id = $user_data['job_id'];

        $insert_message = $this->message_model->add_message($message, $message_file, $message_file_type, $message_file_size, $message_from, $message_to, $message_from_profile, $message_from_profile_id, $message_to_profile, $message_to_profile_id);

      //  $last_chat = $this->message_model->getBusinessLastMessage($message_from_profile_id, $user_data['business_profile_id']);
        $last_chat = $this->rmessage_model->getRecruiterLastMessage($message_from_profile_id, $user_data['job_id']);
echo '<pre>'; print_r($last_chat); die();
        if ($insert_message) {
            echo json_encode($last_chat);
        } else {
            echo json_encode(array('result' => 'fail'));
        }
    }
    
    public function getRecruiterUserChatList() {
        $recruiter_profile_id = $this->data['recdata'][0]['rec_id'];
        $user_data = $this->rmessage_model->getRecruiterUserChatList($recruiter_profile_id);
        echo json_encode($user_data);
    }
public function getRecruiterUserChat() {
//        $business_profile_id = $this->data['business_login_profile_id'];
     $recruiter_profile_id = $this->data['recdata'][0]['rec_id'];

        $job_slug = $_POST['job_slug'];
        $user_data = $this->recruiter_model->getJobDataBySlug($job_slug, $select_data = "job_id,fname,lname,job_user_image,slug,designation");
        
        $user_data['chat'] = $this->rmessage_model->getRecruiterChat($recruiter_profile_id, $user_data['job_id']);
        echo json_encode($user_data);
    }
    
    public function recruitermessageDelete(){
        $message_id = $_POST['message_id'];
        $message_for = $_POST['message_for'];
        $recruiter_profile_id = $this->data['recdata'][0]['rec_id'];
        $delete_data = $this->rmessage_model->recruiterMessageData($message_for,$recruiter_profile_id,$message_id);
        if ($delete_data) {
            echo json_encode(array('result' => 'success'));
        } else {
            echo json_encode(array('result' => 'fail'));
        }
    }
    
    public function allMessageDelete(){
             $recruiter_profile_id = $this->data['recdata'][0]['rec_id'];
        $job_profile_id = $_POST['business_to_profile_id'];
        $deleteData = $this->message_model->allMessageDelete($business_profile_id, $business_to_profile_id);
        if ($deleteData) {
            echo json_encode(array('result' => 'success'));
        } else {
            echo json_encode(array('result' => 'fail'));
        }
    }
    public function getRecruiterUserChatSearchList() {
        $search_key = $_POST['search_key'];
        $recruiter_profile_id = $this->data['recdata'][0]['rec_id'];
        if ($search_key) {
            $user_data = $this->rmessage_model->getRecruiterUserChatSearchList($recruiter_profile_id, $search_key);
        } else {
            $user_data = $this->rmessage_model->getRecruiterUserChatList($recruiter_profile_id);
        }
        echo json_encode($user_data);
    }
    
        public function recruiter_file_upload() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        $recruiter_login_slug = $this->data['recdata'][0]['rec_id'];

        $this->business_profile_active_check();
        $this->is_business_profile_register();

        $config = array(
            'image_library' => 'gd',
            'upload_path' => $this->config->item('rec_message_main_upload_path'),
            'allowed_types' => $this->config->item('rec_message_main_allowed_types'),
            'overwrite' => true,
            'remove_spaces' => true);
        $images = array();
        $this->load->library('upload');

        $files = $_FILES;
        $count = count($_FILES['file']['name']);
        $title = time();
        
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);

        if ($_FILES['file']['name'] != '') {
            //for ($i = 0; $i < $count; $i++) {
                $_FILES['file']['name'] = $files['file']['name'];
                $_FILES['file']['type'] = $files['file']['type'];
                $_FILES['file']['tmp_name'] = $files['file']['tmp_name'];
                $_FILES['file']['error'] = $files['file']['error'];
                $_FILES['file']['size'] = $files['file']['size'];

                
                $file_type = $_FILES['file']['type'];
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

                if ($_FILES['file']['error'] == 0) {
                    $store = $_FILES['file']['name'];
                    $store_ext = explode('.', $store);
                    $store_ext = end($store_ext);
                    $fileName = 'file_' . $title . '_' . $this->random_string() . '.' . $store_ext;
                    $images[] = $fileName;
                    $config['file_name'] = $fileName;
                    $this->upload->initialize($config);
//                  $this->upload->do_upload();
                    $imgdata = $this->upload->data();

                    if ($this->upload->do_upload('file')) {
                        $upload_data = $response['result'] = $this->upload->data();

                        if ($file_type == 'video') {
                            $uploaded_url = base_url() . $this->config->item('rec_message_main_upload_path') . $response['result']['file_name'];
                            exec("ffmpeg -i " . $uploaded_url . " -vcodec h264 -acodec aac -strict -2 " . $upload_data['file_path'] . $upload_data['raw_name'] . "1" . $upload_data['file_ext'] . "");
                            exec("ffmpeg -ss 00:00:05 -i " . $upload_data['full_path'] . " " . $upload_data['file_path'] . $upload_data['raw_name'] . "1" . ".png");
                            $fileName = $response['result']['file_name'] = $upload_data['raw_name'] . "1" . $upload_data['file_ext'];
                            unlink($this->config->item('rec_message_main_upload_path') . $upload_data['raw_name'] . "" . $upload_data['file_ext']);
                        }

                        $main_image_size = $_FILES['file']['size'];

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

                        $recruiter_profile_message_main['image_library'] = 'gd2';
                        $recruiter_profile_message_main['source_image'] = $this->config->item('rec_message_main_upload_path') . $response['result']['file_name'];
                        $recruiter_profile_message_main['new_image'] = $this->config->item('rec_message_main_upload_path') . $response['result']['file_name'];
                        $recruiter_profile_message_main['quality'] = $quality;
                        $instanse10 = "image10";
                        $this->load->library('image_lib', $recruiter_profile_message_main, $instanse10);
                        $this->$instanse10->watermark();

                        /* RESIZE */

                        $main_image = $this->config->item('rec_message_main_upload_path') . $response['result']['file_name'];
                        $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);

                        $post_poster = $response['result']['file_name'];
                        $post_poster1 = explode('.', $post_poster);
                        $post_poster2 = end($post_poster1);
                        $post_poster = str_replace($post_poster2, 'png', $post_poster);

                        $main_image1 = $this->config->item('rec_message_main_upload_path') . $post_poster;
                        $abc = $s3->putObjectFile($main_image1, bucket, $main_image1, S3::ACL_PUBLIC_READ);

                        $image_width = $response['result']['image_width'];
                        $image_height = $response['result']['image_height'];


                        $recruiter_profile_message_thumb['image_library'] = 'gd2';
                        $recruiter_profile_message_thumb['source_image'] = $this->config->item('rec_message_main_upload_path') . $response['result']['file_name'];
                        $recruiter_profile_message_thumb['new_image'] = $this->config->item('rec_message_thumb_upload_path') . $response['result']['file_name'];
                        $recruiter_profile_message_thumb['create_thumb'] = TRUE;
                        $recruiter_profile_message_thumb['maintain_ratio'] = FALSE;
                        $recruiter_profile_message_thumb['thumb_marker'] = '';
                        $recruiter_profile_message_thumb['width'] = $n_w;
                        $recruiter_profile_message_thumb['height'] = $n_h;
//                        $business_profile_message_thumb['master_dim'] = 'width';
                        $recruiter_profile_message_thumb['quality'] = "100%";
                        $recruiter_profile_message_thumb['x_axis'] = '0';
                        $recruiter_profile_message_thumb['y_axis'] = '0';
                        $instanse = "image";
                        //Loading Image Library
                        $this->load->library('image_lib', $recruiter_profile_message_thumb, $instanse);
                        $dataimage = $response['result']['file_name'];
                        //Creating Thumbnail
                        $this->$instanse->resize();

                        $thumb_image = $this->config->item('rec_message_thumb_upload_path') . $response['result']['file_name'];
                        $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);

                        $job_slug = $_POST['slug'];
                        $user_data = $this->recruiter_model->getJobDataBySlug($job_slug, $select_data = "job_id,user_id");

                        $message = '';
                        $message_file = $fileName;
                        $message_file_type = $file_type;
                        $message_file_size = $main_image_size;
                        $message_from = $userid;
                        $message_to = $user_data['user_id'];
                        $message_from_profile = '5';
                        $message_from_profile_id = $this->data['business_login_profile_id'];
                        $message_to_profile = '5';
                        $message_to_profile_id = $user_data['business_profile_id'];

                        $insert_message = $this->message_model->add_message($message, $message_file, $message_file_type, $message_file_size, $message_from, $message_to, $message_from_profile, $message_from_profile_id, $message_to_profile, $message_to_profile_id);
                        $last_chat = $this->message_model->getBusinessLastMessage($message_from_profile_id, $user_data['business_profile_id']);
                        if ($insert_message) {
                            echo json_encode($last_chat);
                        } else {
                            echo json_encode(array('result' => 'fail'));
                        }


                        /* THIS CODE UNCOMMENTED AFTER SUCCESSFULLY WORKING : REMOVE IMAGE FROM UPLOAD FOLDER */

                        if ($_SERVER['HTTP_HOST'] != "localhost") {
                            if (isset($main_image)) {
                                unlink($main_image);
                            }
                            if (isset($thumb_image)) {
                                unlink($thumb_image);
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
            //} //die();
        }
    }
}
