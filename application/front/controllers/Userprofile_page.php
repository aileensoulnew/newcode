<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Userprofile_page extends MY_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
        $this->load->library('S3');
        $this->load->library('form_validation');

        $this->load->model('user_model');
        $this->load->model('userprofile_model');
    }

    public function profile() {
        $this->load->view('userprofile/profiles', $this->data);
    }

    public function dashboard() {
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.user_slug,u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->load->view('userprofile/dashboard', $this->data);
    }

    public function details() {

        $this->load->view('userprofile/details', $this->data);
    }

    public function contacts() {
        $this->load->view('userprofile/contacts', $this->data);
    }

    public function followers() {
        $this->load->view('userprofile/followers', $this->data);
    }

    public function following() {
        $this->load->view('userprofile/following', $this->data);
    }

    public function questions() {
        $this->load->view('userprofile/questions', $this->data);
    }

    public function contact_request() {
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");

        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);

        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->load->view('userprofile/contact_request', $this->data);
    }

    public function pending_contact_request() {
        $userid = $this->session->userdata('aileenuser');
        $pendingContactRequest = $this->user_model->contact_request_pending($userid);
        echo json_encode($pendingContactRequest);
    }

    public function contactRequestNotification() {
        $userid = $this->session->userdata('aileenuser');
        $contactRequestNotification = $this->user_model->contact_request_accept($userid);
        echo json_encode($contactRequestNotification);
    }

    public function detail_data() {
        //$userid = $this->session->userdata('aileenuser');//old
        $user_slug = $_POST['u'];
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        $is_basicInfo = $this->data['is_basicInfo'] = $this->user_model->is_userBasicInfo($userid);
        if ($is_basicInfo == 0) {
            $detailsData = $this->data['detailsData'] = $this->user_model->getUserStudentData($userid, $data = "d.degree_name as Degree,u.university_name as University,c.city_name as City,CONCAT(UCASE(LEFT(usr.first_name,1)),LCASE(SUBSTRING(usr.first_name,2))) as first_name,usr.first_name as First name,CONCAT(UCASE(LEFT(usr.last_name,1)),LCASE(SUBSTRING(usr.last_name,2))) as last_name,usr.last_name as Last name,  CONCAT(CONCAT(UCASE(LEFT(usr.first_name,1)),LCASE(SUBSTRING(usr.first_name,2))) ,' ',CONCAT(UCASE(LEFT(usr.last_name,1)),LCASE(SUBSTRING(usr.last_name,2)))) as fullname , DATE_FORMAT(usr.user_dob, '%D %M %Y') as DOB");
        } else {
            $detailsData = $this->data['detailsData'] = $this->user_model->getUserProfessionData($userid, $data = "jt.name as Designation,CONCAT(UCASE(LEFT(usr.first_name,1)),LCASE(SUBSTRING(usr.first_name,2))) as first_name,CONCAT(UCASE(LEFT(usr.last_name,1)),LCASE(SUBSTRING(usr.last_name,2))) as last_name,it.industry_name as Industry,c.city_name as City, CONCAT(CONCAT(UCASE(LEFT(usr.first_name,1)),LCASE(SUBSTRING(usr.first_name,2))) ,' ',CONCAT(UCASE(LEFT(usr.last_name,1)),LCASE(SUBSTRING(usr.last_name,2)))) as fullname , usr.first_name as First name,usr.last_name as Last name,DATE_FORMAT(usr.user_dob, '%D %M %Y') as DOB");
        }

        echo json_encode($detailsData);
    }

    public function profiles_data() {
        $userid = $this->session->userdata('aileenuser');
        $profilesData = $this->data['profilesData'] = $this->userprofile_model->getdashboardata($userid, $data = "a.status as ap_status,a.art_step as ap_step,a.is_delete as ap_delete,r.re_status as rp_status,r.is_delete as rp_delete,r.re_step as rp_step,jr.is_delete as jp_delete,jr.status as jp_status,jr.job_step as jp_step,bp.status as bp_status,bp.is_deleted as bp_delete,bp.business_step as bp_step,fh.status as fh_status,fh.is_delete as fh_delete,fh.free_hire_step as fh_step,fp.status as fp_status,fp.is_delete as fp_delete,fp.free_post_step as fp_step");
        echo json_encode($profilesData);
    }

    public function followers_data() {
       
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        //$userid = $this->session->userdata('aileenuser');
        if (!empty($_GET["user_slug"]) && $_GET["user_slug"] != 'undefined')
        {
            $user_slug = $_GET["user_slug"];             
            $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        }
        else
        {            
            $userid = $this->session->userdata('aileenuser');
        }
        $login_user_id = $this->session->userdata('aileenuser');
        $followersData = $this->data['followersData'] = $this->userprofile_model->getFollowersData($userid, $data = "", $page,$login_user_id);
        echo json_encode($followersData);
    }

    public function contacts_data() {

        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
       
        if (!empty($_GET["user_slug"]) && $_GET["user_slug"] != 'undefined')
        {
            $user_slug = $_GET["user_slug"];             
            $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        }
        else
        {            
            $userid = $this->session->userdata('aileenuser');
        }
        $login_user_id = $this->session->userdata('aileenuser');
        $contactsData = $this->data['contactsData'] = $this->userprofile_model->getContactData($userid, $data = "", $page,$login_user_id);
        if (count($contactsData) == 0) {
            echo count($contactsData);
        } else {
            echo json_encode($contactsData);
        }
    }

    public function following_data() {
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }        
        if (!empty($_GET["user_slug"]) && $_GET["user_slug"] != 'undefined')
        {
            $user_slug = $_GET["user_slug"];             
            $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        }
        else
        {            
            $userid = $this->session->userdata('aileenuser');
        }
        $login_user_id = $this->session->userdata('aileenuser');
        
        $followingData = $this->data['followingData'] = $this->userprofile_model->getFollowingData($userid, $data = "", $page,$login_user_id);
        if (count($followingData) == 0) {
            echo count($followingData);
        } else {
            echo json_encode($followingData);
        }
    }

    public function vsrepeat() {
        $this->load->view('vsrepeat');
    }

    public function vsrepeat_data() {
        $this->db->select('first_name as name,user_id as id');
        $this->db->from('user');
        $this->db->limit('50');
        $query = $this->db->get();
        $data = $query->result_array();
        echo json_encode($data);
    }

    public function removeContacts() {
        $userid = $this->session->userdata('aileenuser');
        $id = $_POST['id'];
        $remove = $this->data['remove'] = $this->userprofile_model->userContactStatus($userid, $id);

        if (count($remove) != 0) {
            $data = array('status' => 'cancel');
            $insert_id = $this->common->update_data($data, 'user_contact', 'id', $remove['id']);
            $response = 1;
        } else {
            $response = 0;
        }
        $contactdata = $this->userprofile_model->getContactCount($userid);

        $removjson['response'] = $response;
        $removjson['contactcount'] = $contactdata[0]['total'];
        echo json_encode($removjson);
    }

    public function unfollowingContacts() {
        $userid = $this->session->userdata('aileenuser');
        $id = $_POST['to_id'];
        $follow = $this->userprofile_model->userFollowStatus($userid, $id);
        if (count($follow) != 0) {
            $data = array('status' => '0');
            $insert_id = $this->common->update_data($data, 'user_follow', 'id', $follow['id']);
            $response = 1;
            $html = '<a class="btn3 follow"  ng-click="follow_user(' . $id . ')">Follow</a>';
        } else {
            $response = 0;
            $html = '<a class="btn3 following"  ng-click="unfollow_user(' . $id . ')">Following</a>';
        }
        $followingdata = $this->userprofile_model->getFollowingCount($userid);

        $unfollowingjson['response'] = $response;
        $unfollowingjson['unfollowingcount'] = $followingdata[0]['total'];
        $unfollowingjson['follow_view'] = $html;

        echo json_encode($unfollowingjson);
    }

    public function addcontact() {
        $userid = $this->session->userdata('aileenuser');
        $contact_id = $_POST['contact_id'];
        $status = $_POST['status'];
        $id = $_POST['to_id'];
        $contact = $this->userprofile_model->userContactStatus($userid, $id);//Login user id,To user id

        if (count($contact) != 0) {
            $data = array(
                'status' => $status,
                'from_id' => $userid,
                'to_id' => $id,
                'modify_date' => date('Y-m-d H:i:s', time()));
            $insert_id = $this->common->update_data($data, 'user_contact', 'id', $contact['id']);
            $response = $status;
        } else {
            $data = array(
                'status' => $status,
                'from_id' => $userid,
                'to_id' => $id,
                'not_read' => '2',
                'created_date' => date('Y-m-d H:i:s', time()),
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $insert_id = $this->common->insert_data($data, 'user_contact');
            $response = $status;
        }
        echo $response;
    }

    public function addToContactNew() {
        $userid = $this->session->userdata('aileenuser');
        $contact_id = $_POST['contact_id'];
        $status = $_POST['status'];
        $id = $_POST['to_id'];
        $indexCon = $_POST['indexCon'];
        $contact = $this->userprofile_model->userContactStatus($userid, $id);

        if (count($contact) != 0) {
            $data = array('status' => $status, 'modify_date' => date('Y-m-d H:i:s', time()));
            $insert_id = $this->common->update_data($data, 'user_contact', 'id', $contact['id']);
            $response['status'] = $status;
        } else {
            $data = array(
                'status' => $status,
                'from_id' => $userid,
                'to_id' => $id,
                'not_read' => '2',
                'created_date' => date('Y-m-d H:i:s', time()),
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $insert_id = $this->common->insert_data($data, 'user_contact');
            $response['status'] = $status;
        }

        if($status == "cancel")
        {            
            $response['button'] = '<a class="btn3" ng-click="contact('. $contact_id.', \'pending\', '.$id.','.$indexCon.')">Add to contact</a>';
        }
        if($status == "pending")
        {            
            $response['button'] = '<a class="btn3" ng-click="contact('. $contact_id.', \'cancel\', '.$id.','.$indexCon.')">Request sent</a>';
        }
        echo json_encode($response);
    }

    public function addfollow() {
        $userid = $this->session->userdata('aileenuser');
        $follow_id = $_POST['follow_id'];
        $status = $_POST['status'];
        $id = $_POST['to_id'];
        $follow = $this->userprofile_model->userFollowStatus($userid, $id);

        if (count($follow) != 0) {
            $data = array('status' => $status);
            $insert_id = $this->common->update_data($data, 'user_follow', 'id', $follow['id']);
            $response = $status;
        } else {
            $data = array(
                'status' => $status,
                'follow_from' => $userid,
                'follow_to' => $id,
                'created_date' => $status,
            );
            $insert_id = $this->common->insert_data($data, 'user_follow');
            $response = $status;
        }
        echo $response;
    }

    public function follow_user() {
        $userid = $this->session->userdata('aileenuser');
        //$follow_id = $_POST['follow_id'];
        $id = $_POST['to_id'];
        $follow = $this->userprofile_model->userFollowStatus($userid, $id);

        if (count($follow) != 0) {
            $data = array('status' => '1');
            $insert_id = $this->common->update_data($data, 'user_follow', 'id', $follow['id']);
            //   $response = $status;

            $html = '<a class="btn3 following"  ng-click="unfollow_user(' . $id . ')">Following</a>';
        } else {
            $data = array(
                'status' => '1',
                'follow_from' => $userid,
                'follow_to' => $id,
                'created_date' => date("Y-m-d h:i:s"),
            );
            $insert_id = $this->common->insert_data($data, 'user_follow');
            // $response = $status;
            $html = '<a class="btn3 following"  ng-click="unfollow_user(' . $id . ')">Following</a>';
        }


        echo $html;
    }

    public function unfollow_user() {
        $userid = $this->session->userdata('aileenuser');
        //$follow_id = $_POST['follow_id'];
        $id = $_POST['to_id'];
        $follow = $this->userprofile_model->userFollowStatus($userid, $id);

        if (count($follow) != 0) {
            $data = array('status' => 0);
            $insert_id = $this->common->update_data($data, 'user_follow', 'id', $follow['id']);
            //   $response = $status;

            $html = '<a class="btn3 follow"  ng-click="follow_user(' . $id . ')">Follow</a>';
        } else {
            $data = array(
                'status' => 0,
                'follow_from' => $userid,
                'follow_to' => $id,
                'created_date' => $status,
            );
            $insert_id = $this->common->insert_data($data, 'user_follow');
            // $response = $status;
            $html = '<a class="btn3 follow"  ng-click="follow_user(' . $id . ')">Follow</a>';
        }


        echo $html;
    }

    //PROFILE PIC INSERT END  

    public function user_image_insert1() {
        $userid = $this->session->userdata('aileenuser');
        $userslug = $this->session->userdata('aileenuser_slug');
        $userdata = $this->user_model->getUserDataByslug($userslug, $data = 'ui.user_image,u.user_slug,u.user_id');

        $user_prev_image = $userdata['user_image'];

        if ($user_prev_image != '') {
            $user_image_main_path = $this->config->item('user_main_upload_path');
            $user_img_full_image = $user_image_main_path . $user_prev_image;
            if (isset($user_img_full_image)) {
                unlink($user_img_full_image);
            }

            $user_image_thumb_path = $this->config->item('user_thumb_upload_path');
            $user_bg_thumb_image = $user_image_thumb_path . $user_prev_image;
            if (isset($user_bg_thumb_image)) {
                unlink($user_bg_thumb_image);
            }
        }


        $data = $_POST['image'];
        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);
        $user_bg_path = $this->config->item('user_main_upload_path');
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


        /* RESIZE */
        $freelancer_hire_profile['image_library'] = 'gd2';
        $freelancer_hire_profile['source_image'] = $main_image;
        $freelancer_hire_profile['new_image'] = $main_image;
        $freelancer_hire_profile['quality'] = $quality;
        $instanse10 = "image10";
        $this->load->library('image_lib', $freelancer_hire_profile, $instanse10);
        /* RESIZE */

        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
        $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);

        $user_thumb_path = $this->config->item('user_thumb_upload_path');
        $user_thumb_width = $this->config->item('user_thumb_width');
        $user_thumb_height = $this->config->item('user_thumb_height');

        $upload_image = $user_bg_path . $imageName;

        $thumb_image_uplode = $this->thumb_img_uplode($upload_image, $imageName, $user_thumb_path, $user_thumb_width, $user_thumb_height);

        $thumb_image = $user_thumb_path . $imageName;
        $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);

        $data = array(
            'user_image' => $imageName
        );

        $update = $this->common->update_data($data, 'user_info', 'user_id', $userdata['user_id']);

        $insert_data = array();
        $insert_data['user_id'] = $userid;
        $insert_data['data_key'] = "profile_picture";
        $insert_data['data_value'] = $imageName;
        $insert_data['date'] = date('Y-m-d H:i:s', time());
        $inserted_id = $user_cover_id = $this->common->insert_data_getid($insert_data, 'user_profile_update');

        $insert_post_data = array();
        $insert_post_data['user_id'] = $userid;
        $insert_post_data['post_for'] = "profile_update";
        $insert_post_data['post_id'] = $inserted_id;
        $insert_post_data['status'] = 'publish';
        $insert_post_data['is_delete'] = '0';
        $insert_post_data['created_date'] = date('Y-m-d H:i:s', time());
        $inserted_id = $user_cover_id = $this->common->insert_data_getid($insert_post_data, 'user_post');

        if ($update) {
            $userdata = $this->user_model->getUserDataByslug($userslug, $data = 'ui.user_image');

            $userImageContent = '<a class="other-user-profile" hrerf="#" data-toggle="modal" data-target="#other-user-profile-img"><img src="' . USER_MAIN_UPLOAD_URL . $userdata['user_image'] . '"></a>';
            $userImageContent .= '<div class="upload-profile"><a class="cusome_upload" href="#" onclick="updateprofilepopup();" title="Update profile picture">
                            <img src="' . base_url('assets/n-images/cam.png') . '"  alt="CAMERAIMAGE">Update Profile Picture
                        </a>
                        <a data-toggle="modal" data-target="#view-profile-img" class="cusome_upload"  href="#">
                            <img src="'.base_url('assets/img/v-pic.png').'"  alt="CAMERAIMAGE">View
                        </a></div>';

            $this->session->set_userdata('aileenuser_userimage', $userdata['user_image']);
            $resData['userImageContent'] = $userImageContent;
            $resData['userProfilePicMain'] = USER_MAIN_UPLOAD_URL.$userdata['user_image'];
            $resData['userProfilePicThumb'] = USER_THUMB_UPLOAD_URL.$userdata['user_image'];

            echo json_encode($resData);
        } else {

            $this->session->flashdata('error', 'Your data not inserted');
            redirect(base_url().$userdata['user_slug'], refresh);
        }
    }

    // cover pic controller
    public function ajaxpro() {

        $userid = $this->session->userdata('aileenuser');
        $user_reg_data = $this->userprofile_model->getUserBackImage($userid);

        $user_reg_prev_image = $user_reg_data['profile_background'];
        $user_reg_prev_main_image = $user_reg_data['profile_background_main'];

        if ($user_reg_prev_image != '') {
            $user_image_main_path = $this->config->item('user_bg_main_upload_path');
            $user_bg_full_image = $user_image_main_path . $user_reg_prev_image;
            if (isset($user_bg_full_image)) {
                unlink($user_bg_full_image);
            }

            $user_image_thumb_path = $this->config->item('user_bg_thumb_upload_path');
            $user_bg_thumb_image = $user_image_thumb_path . $user_reg_prev_image;
            if (isset($user_bg_thumb_image)) {
                unlink($user_bg_thumb_image);
            }
        }
        if ($user_reg_prev_main_image != '') {
            $user_image_original_path = $this->config->item('user_bg_original_upload_path');
            $user_bg_origin_image = $user_image_original_path . $user_reg_prev_main_image;
            if (isset($user_bg_origin_image)) {
                unlink($user_bg_origin_image);
            }
        }


        $data = $_POST['image'];
        $data = str_replace('data:image/png;base64,', '', $data);
        $data = str_replace(' ', '+', $data);
        $user_bg_path = $this->config->item('user_bg_main_upload_path');
        $imageName = time() . '.png';
        $data = base64_decode($data);
        $file = $user_bg_path . $imageName;
        $success = file_put_contents($file, $data);

        //$this->thumb_img_uplode($file, $imageName, $user_bg_path, 1920, 500);

        $user_post_resize4['image_library'] = 'gd2';
        $user_post_resize4['source_image'] = $this->config->item('user_bg_main_upload_path') . $imageName;
        $user_post_resize4['new_image'] =  $this->config->item('user_bg_main_upload_path') . $imageName;
        $user_post_resize4['create_thumb'] = FALSE;
        $user_post_resize4['maintain_ratio'] = TRUE;
        $user_post_resize4['thumb_marker'] = '';
        $user_post_resize4['width'] = 1920;
        $user_post_resize4['height'] = 500;
        //$user_post_resize4['master_dim'] = width;
        $user_post_resize4['quality'] = "100%";
        $instanse4 = "image4";
        //Loading Image Library
        $this->load->library('image_lib', $user_post_resize4, $instanse4);
        //Creating Thumbnail
        $this->$instanse4->resize();
        //$this->$instanse4->clear();

        $main_image = $user_bg_path . $imageName;

        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
        if (IMAGEPATHFROM == 's3bucket') {
            $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);
        }

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

        $user_thumb_path = $this->config->item('user_bg_thumb_upload_path');
        $user_thumb_width = $this->config->item('user_bg_thumb_width');
        $user_thumb_height = $this->config->item('user_bg_thumb_height');

        $upload_image = $user_bg_path . $imageName;
        $thumb_image_uplode = $this->thumb_img_uplode($upload_image, $imageName, $user_thumb_path, $user_thumb_width, $user_thumb_height);

        $thumb_image = $user_thumb_path . $imageName;
        $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);

        $data = array(
            'profile_background' => $imageName
        );

        $update = $this->common->update_data($data, 'user_info', 'user_id', $userid);

        $insert_data = array();
        $insert_data['user_id'] = $userid;
        $insert_data['data_key'] = "cover_picture";
        $insert_data['data_value'] = $imageName;
        $insert_data['date'] = date('Y-m-d H:i:s', time());
        $inserted_id = $user_cover_id = $this->common->insert_data_getid($insert_data, 'user_profile_update');

        $insert_post_data = array();
        $insert_post_data['user_id'] = $userid;
        $insert_post_data['post_for'] = "cover_update";
        $insert_post_data['post_id'] = $inserted_id;
        $insert_post_data['status'] = 'publish';
        $insert_post_data['is_delete'] = '0';
        $insert_post_data['created_date'] = date('Y-m-d H:i:s', time());
        $inserted_id = $user_cover_id = $this->common->insert_data_getid($insert_post_data, 'user_post');

        $user_reg_data = $this->userprofile_model->getUserBackImage($userid);
        $user_reg_back_image = $user_reg_data['profile_background'];

//        echo '<img src = "' . $this->data['busdata'][0]['profile_background'] . '" />';
        $resdata['cover'] = '  <div class="bg-images"><a data-toggle="modal" data-target="#view-cover-img" class="cusome_upload" href="#"><img id="image_src" name="image_src" src = "' . USER_BG_MAIN_UPLOAD_URL . $user_reg_back_image . '" /></a></div>';
        $resdata['cover_image'] = USER_BG_MAIN_UPLOAD_URL . $user_reg_back_image;

        echo json_encode($resdata);
    }

    public function question_detail($question_id = '') {
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['question_id'] = $question_id;
        $this->data['title'] = "Question | Aileensoul";
        $this->load->view('userprofile/question_details', $this->data);
    }

    public function question_data() {
        $userid = $this->session->userdata('aileenuser');

        $question_id = $_GET['question'];
        $questionData = $this->userprofile_model->questionData($question_id, $userid);
        echo json_encode($questionData);
    }

    public function questions_list() {
        //$userid = $this->session->userdata('aileenuser');
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        if (!empty($_GET["user_slug"]) && $_GET["user_slug"] != 'undefined')
        {
            $user_slug = $_GET["user_slug"];             
            $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        }
        else
        {            
            $userid = $this->session->userdata('aileenuser');
        } 
        $questionList = $this->userprofile_model->questionList($userid, $data = "", $page);
        echo json_encode($questionList);
    }

    public function photos() {
        $this->load->view('userprofile/photos', $this->data);
    }

    public function photos_data() {
       
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        if (!empty($_GET["user_slug"]) && $_GET["user_slug"] != 'undefined')
        {
            $user_slug = $_GET["user_slug"];             
            $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        }
        else
        {            
            $userid = $this->session->userdata('aileenuser');
        }       

        $resdata['photosData'] = $this->data['photosData'] = $this->userprofile_model->getPhotosData($userid, $data = "", $page);
        if($page == 1)
        {            
            $resdata['allPhotosData'] = $this->userprofile_model->userAllPhotos($userid);
        }
        echo json_encode($resdata);
    }

    public function videos() {
        $this->load->view('userprofile/videos', $this->data);
    }

    public function videos_data() {
       
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        if (!empty($_GET["user_slug"]) && $_GET["user_slug"] != 'undefined')
        {
            $user_slug = $_GET["user_slug"];             
            $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        }
        else
        {            
            $userid = $this->session->userdata('aileenuser');
        }
        $resdata['videoData'] = $this->data['videosData'] = $this->userprofile_model->getVideosData($userid, $data = "", $page);
         if($page == 1)
        {            
            $resdata['allVideosData'] = $this->userprofile_model->userAllVideo($userid);
        }

        echo json_encode($resdata);
    }

    public function audios() {
        $this->load->view('userprofile/audio', $this->data);
    }

    public function audios_data() {
       
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        if (!empty($_GET["user_slug"]) && $_GET["user_slug"] != 'undefined')
        {
            $user_slug = $_GET["user_slug"];             
            $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        }
        else
        {            
            $userid = $this->session->userdata('aileenuser');
        }
        $audiosData = $this->data['audiosData'] = $this->userprofile_model->getAudiosData($userid, $data = "", $page);
        echo json_encode($audiosData);
    }

    public function pdf() {
        $this->load->view('userprofile/pdf', $this->data);
    }

    public function pdf_data() {
       
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        if (!empty($_GET["user_slug"]) && $_GET["user_slug"] != 'undefined')
        {
            $user_slug = $_GET["user_slug"];             
            $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        }
        else
        {            
            $userid = $this->session->userdata('aileenuser');
        }
        $pdfData = $this->data['pdfData'] = $this->userprofile_model->getPdfData($userid, $data = "", $page);
        echo json_encode($pdfData);
    }

    public function article() {
        $this->load->view('userprofile/article', $this->data);
    }

    public function get_post_desctiprion($post_id,$post_for)
    {
        echo $post_id,$post_for;
    }

}
