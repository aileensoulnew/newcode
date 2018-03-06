<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Message extends MY_Controller {

    public $data;

    public function __construct() {
        parent::__construct();

        $this->load->helper('smiley');

        //AWS access info start
        $this->load->library('S3');
        //AWS access info end
        $this->load->model('business_model');
        $this->load->model('message_model');
        include('business_include.php');
    }

    public function index() {
        $this->load->view('message/index');
    }

    public function business_profile($business_slug = '') {
        $business_profile_id = $this->data['business_login_profile_id'];
        $user_data = $this->business_model->getBusinessDataBySlug($business_slug, $select_data = "business_profile_id,company_name,business_user_image,other_business_type,other_industrial,business_type,industriyal,business_slug");
        $this->data['user_data'] = $user_data;
        if ($user_data['business_type'] != '' || $user_data['business_type'] != 'null') {
            $this->data['user_data']['business_type'] = $this->business_model->getBusinessTypeName($user_data['business_type']);
        }
        if ($user_data['industriyal'] != '' || $user_data['industriyal'] != 'null') {
            $this->data['user_data']['industriyal'] = $this->business_model->getIndustriyalName($user_data['industriyal']);
        }
        $this->data['user_data']['chat'] = $this->message_model->getBusinessChat($business_profile_id, $user_data['business_profile_id']);
        $this->load->view('message/business_profile', $this->data);
    }

    public function getBusinessUserChatList() {
        $business_profile_id = $this->data['business_login_profile_id'];
        $user_data = $this->message_model->getBusinessUserChatList($business_profile_id);
        echo json_encode($user_data);
    }

    public function getBusinessUserChatSearchList() {
        $search_key = $_POST['search_key'];
        $business_profile_id = $this->data['business_login_profile_id'];
        if ($search_key) {
            $user_data = $this->message_model->getBusinessUserChatSearchList($business_profile_id, $search_key);
        } else {
            $user_data = $this->message_model->getBusinessUserChatList($business_profile_id);
        }
        echo json_encode($user_data);
    }

    public function getBusinessUserChat() {
        $business_profile_id = $this->data['business_login_profile_id'];

        $business_slug = $_POST['business_slug'];
        $user_data = $this->business_model->getBusinessDataBySlug($business_slug, $select_data = "business_profile_id,company_name,business_user_image,other_business_type,other_industrial,business_type,industriyal,business_slug");
        if ($user_data['business_type'] != '' || $user_data['business_type'] != 'null') {
            $user_data['business_type'] = $this->business_model->getBusinessTypeName($user_data['business_type']);
        }
        if ($user_data['industriyal'] != '' || $user_data['industriyal'] != 'null') {
            $user_data['industriyal'] = $this->business_model->getIndustriyalName($user_data['industriyal']);
        }
        $user_data['chat'] = $this->message_model->getBusinessChat($business_profile_id, $user_data['business_profile_id']);
        echo json_encode($user_data);
    }

    public function businessSingleMessageInsert() {
        $userid = $this->session->userdata('aileenuser');

        $message = $_POST['message'];
        $message_from = $userid;
        $message_to = $_POST['user_id'];
        $message_from_profile = '5';
        $message_from_profile_id = $this->data['business_login_profile_id'];
        $message_to_profile = '5';
        $message_to_profile_id = $_POST['business_profile_id'];

//        $insert_message = $this->message_model->add_message($message, $message_from, $message_to, $message_from_profile, $message_from_profile_id, $message_to_profile, $message_to_profile_id);
        $insert_message = $this->message_model->add_message($message, $message_file='', $message_file_type='', $message_file_size='', $message_from, $message_to, $message_from_profile, $message_from_profile_id, $message_to_profile, $message_to_profile_id);
        if ($insert_message) {
            echo json_encode(array('result' => 'success'));
        } else {
            echo json_encode(array('result' => 'fail'));
        }
    }

    public function businessMessageInsert() {
        $userid = $this->session->userdata('aileenuser');

        $business_slug = $_POST['business_slug'];
        $user_data = $this->business_model->getBusinessDataBySlug($business_slug, $select_data = "business_profile_id,user_id");

        $message = $_POST['message'];
        $message_file = '';
        $message_file_type = '';
        $message_file_size = '';
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
    }

    public function business_file_upload() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        $business_login_slug = $this->data['business_login_slug'];

        $this->business_profile_active_check();
        $this->is_business_profile_register();

        $config = array(
            'image_library' => 'gd',
            'upload_path' => $this->config->item('bus_message_main_upload_path'),
            'allowed_types' => $this->config->item('bus_message_main_allowed_types'),
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
                            $uploaded_url = base_url() . $this->config->item('bus_message_main_upload_path') . $response['result']['file_name'];
                            exec("ffmpeg -i " . $uploaded_url . " -vcodec h264 -acodec aac -strict -2 " . $upload_data['file_path'] . $upload_data['raw_name'] . "1" . $upload_data['file_ext'] . "");
                            exec("ffmpeg -ss 00:00:05 -i " . $upload_data['full_path'] . " " . $upload_data['file_path'] . $upload_data['raw_name'] . "1" . ".png");
                            $fileName = $response['result']['file_name'] = $upload_data['raw_name'] . "1" . $upload_data['file_ext'];
                            unlink($this->config->item('bus_message_main_upload_path') . $upload_data['raw_name'] . "" . $upload_data['file_ext']);
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

                        $business_profile_message_main['image_library'] = 'gd2';
                        $business_profile_message_main['source_image'] = $this->config->item('bus_message_main_upload_path') . $response['result']['file_name'];
                        $business_profile_message_main['new_image'] = $this->config->item('bus_message_main_upload_path') . $response['result']['file_name'];
                        $business_profile_message_main['quality'] = $quality;
                        $instanse10 = "image10";
                        $this->load->library('image_lib', $business_profile_message_main, $instanse10);
                        $this->$instanse10->watermark();

                        /* RESIZE */

                        $main_image = $this->config->item('bus_message_main_upload_path') . $response['result']['file_name'];
                        $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);

                        $post_poster = $response['result']['file_name'];
                        $post_poster1 = explode('.', $post_poster);
                        $post_poster2 = end($post_poster1);
                        $post_poster = str_replace($post_poster2, 'png', $post_poster);

                        $main_image1 = $this->config->item('bus_message_main_upload_path') . $post_poster;
                        $abc = $s3->putObjectFile($main_image1, bucket, $main_image1, S3::ACL_PUBLIC_READ);

                        $image_width = $response['result']['image_width'];
                        $image_height = $response['result']['image_height'];


                        $business_profile_message_thumb['image_library'] = 'gd2';
                        $business_profile_message_thumb['source_image'] = $this->config->item('bus_message_main_upload_path') . $response['result']['file_name'];
                        $business_profile_message_thumb['new_image'] = $this->config->item('bus_message_thumb_upload_path') . $response['result']['file_name'];
                        $business_profile_message_thumb['create_thumb'] = TRUE;
                        $business_profile_message_thumb['maintain_ratio'] = FALSE;
                        $business_profile_message_thumb['thumb_marker'] = '';
                        $business_profile_message_thumb['width'] = $n_w;
                        $business_profile_message_thumb['height'] = $n_h;
//                        $business_profile_message_thumb['master_dim'] = 'width';
                        $business_profile_message_thumb['quality'] = "100%";
                        $business_profile_message_thumb['x_axis'] = '0';
                        $business_profile_message_thumb['y_axis'] = '0';
                        $instanse = "image";
                        //Loading Image Library
                        $this->load->library('image_lib', $business_profile_message_thumb, $instanse);
                        $dataimage = $response['result']['file_name'];
                        //Creating Thumbnail
                        $this->$instanse->resize();

                        $thumb_image = $this->config->item('bus_message_thumb_upload_path') . $response['result']['file_name'];
                        $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);

                        $business_slug = $_POST['business_slug'];
                        $user_data = $this->business_model->getBusinessDataBySlug($business_slug, $select_data = "business_profile_id,user_id");

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
    public function businessmessageDelete(){
        $message_id = $_POST['message_id'];
        $message_for = $_POST['message_for'];
        $business_profile_id = $this->data['business_login_profile_id'];
        $delete_data = $this->message_model->businessMessageData($message_for,$business_profile_id,$message_id);
        if ($delete_data) {
            echo json_encode(array('result' => 'success'));
        } else {
            echo json_encode(array('result' => 'fail'));
        }
    }
    
    public function allMessageDelete(){
        $business_profile_id = $this->data['business_login_profile_id'];
        $business_to_profile_id = $_POST['business_to_profile_id'];
        $deleteData = $this->message_model->allMessageDelete($business_profile_id, $business_to_profile_id);
        if ($deleteData) {
            echo json_encode(array('result' => 'success'));
        } else {
            echo json_encode(array('result' => 'fail'));
        }
    }
    
    public function recruiter_profile() {
        $this->load->view('message/recruiter_profile');
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
            //redirect('business-profile/registration/business-information-update', refresh);
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
        //    $send_email = $this->email_model->send_email($subject = 'This is a testing mail', $templ = '', $to_email = 'ankit.aileensoul@gmail.com');
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
