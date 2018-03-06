<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_post extends MY_Controller {

    public $data;

    public function __construct() {

        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('user_agent');
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('user_post_model');
        $this->load->model('data_model');
        $this->load->library('S3');

        $this->data['no_user_post_html'] = '<div class="user_no_post_avl"><h3>Feed</h3><div class="user-img-nn"><div class="user_no_post_img"><img src=' . base_url('assets/img/bui-no.png?ver=' . time()) . ' alt="bui-no.png"></div><div class="art_no_post_text">No Feed Available.</div></div></div>';
        $this->data['no_user_contact_html'] = '<div class="art-img-nn"><div class="art_no_post_img"><img src="' . base_url('assets/img/No_Contact_Request.png?ver=' . time()) . '"></div><div class="art_no_post_text">No Contacts Available.</div></div>';
        // $this->data['header_all_profile'] = '<div class="dropdown-title"> Profiles <a href="profile.html" title="All" class="pull-right">All</a> </div><div id="abody" class="as"> <ul> <li> <div class="all-down"> <a href="'. base_url("artist/").'"> <div class="all-img"> <img src="' . base_url('assets/n-images/i5.jpg') . '"> </div><div class="text-all"> Artistic Profile </div></a> </div></li><li> <div class="all-down"> <a href="'. base_url("business-profile/").'"> <div class="all-img"> <img src="' . base_url('assets/n-images/i4.jpg') . '"> </div><div class="text-all"> Business Profile </div></a> </div></li><li> <div class="all-down"> <a href="'. base_url("job/").'"> <div class="all-img"> <img src="' . base_url('assets/n-images/i1.jpg') . '"> </div><div class="text-all"> Job Profile </div></a> </div></li><li> <div class="all-down"> <a href="'. base_url("recruiter/").'"> <div class="all-img"> <img src="' . base_url('assets/n-images/i2.jpg') . '"> </div><div class="text-all"> Recruiter Profile </div></a> </div></li><li> <div class="all-down"> <a href="'. base_url("freelance/").'"> <div class="all-img"> <img src="' . base_url('assets/n-images/i3.jpg') . '"> </div><div class="text-all"> Freelance Profile </div></a> </div></li></ul> </div>';
         include ('main_profile_link.php');
    }

    public function index() {

        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.user_slug,u.first_name,u.last_name,ui.user_image");
        
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['title'] = "Opportunities | Aileensoul";
        $this->load->view('user_post/index', $this->data);
    }

    public function getContactSuggetion() {

        $userid = $this->session->userdata('aileenuser');
        $is_basicInfo = $this->data['is_basicInfo'] = $this->user_model->is_userBasicInfo($userid);
        if ($is_basicInfo == 0) {
            $detailsData = "student";
        } else {
            $detailsData = "profession";
        }
        $user_data = $this->user_post_model->getContactSuggetion($userid, $detailsData);
        echo json_encode($user_data);
    }

    public function getContactAllSuggetion() {
        $offset = $this->input->post();
        $userid = $this->session->userdata('aileenuser');
        $user_data = $this->user_post_model->getContactAllSuggetion($userid, $offset);
        echo json_encode($user_data);
    }

    public function addToContact() {
        $userid = $this->session->userdata('aileenuser');
        $to_user_id = $_POST['user_id'];
        $return_data = array();
        $checkContactData = $this->user_post_model->checkContact($userid, $to_user_id);
        if ($checkContactData['total'] == '0') {
            $data = array();
            $data['from_id'] = $userid;
            $data['to_id'] = $to_user_id;
            $data['created_date'] = date('Y-m-d H:i:s', time());
            $data['modify_date'] = date('Y-m-d H:i:s', time());
            $data['status'] = 'pending';
            $data['not_read'] = '2';
            $user_contact = $this->common->insert_data_getid($data, 'user_contact');
            if ($user_contact) {
                $return_data['status'] = 'pending';
                $return_data['message'] = '1';
            } else {
                $return_data['status'] = '';
                $return_data['message'] = '0';
            }
        } else {
            if ($checkContactData['status'] == 'reject' || $checkContactData['status'] == 'cancel') {
                $data = array();
                $data['modify_date'] = date('Y-m-d H:i:s', time());
                $data['status'] = 'pending';
                $data['not_read'] = '2';
                $user_contact = $this->common->update_data($data, 'user_contact', 'id', $checkContactData['id']);
                $return_data['status'] = 'pending';
                $return_data['message'] = '1';
            } elseif ($checkContactData['status'] == 'block') {
                $return_data['status'] = 'block';
                $return_data['message'] = '0';
            } elseif ($checkContactData['status'] == 'pending') {
                $return_data['status'] = 'pending';
                $return_data['message'] = '1';
            } else {
                $return_data['status'] = '';
                $return_data['message'] = '0';
            }
        }
        echo json_encode($return_data);
    }

    public function get_jobtitle() {
        $job_title = $this->user_post_model->get_jobtitle();
        echo json_encode($job_title);
    }

    public function get_location() {
        $location = $this->user_post_model->get_location();
        echo json_encode($location);
    }

    public function get_category() {
        $category = $this->user_post_model->get_category();
        echo json_encode($category);
    }

    public function postCommentInsert() {
        $userid = $this->session->userdata('aileenuser');
        $post_id = $_POST['post_id'];
        $comment = $_POST['comment'];

        $data = array();
        $data['user_id'] = $userid;
        $data['post_id'] = $post_id;
        $data['comment'] = $comment;
        $data['created_date'] = date('Y-m-d H:i:s', time());
        $data['modify_date'] = date('Y-m-d H:i:s', time());
        $data['is_delete'] = '0';
        $postComentId = $this->common->insert_data_getid($data, 'user_post_comment');
        $return_data = array();
        if ($postComentId) {
            $return_data['message'] = '1';
            $return_data['comment_data'] = $this->user_post_model->postCommentData($post_id);
            $return_data['comment_data'][0]['is_userlikePostComment'] = '0';
            $return_data['comment_data'][0]['postCommentLikeCount'] = '';
            $return_data['comment_count'] = $this->user_post_model->postCommentCount($post_id);
        } else {
            $return_data['message'] = '0';
        }
        echo json_encode($return_data);
    }

    public function deletePostComment() {
        $comment_id = $_POST['comment_id'];
        $post_id = $_POST['post_id'];

        $update_data = array();
        $update_data['modify_date'] = date('Y-m-d H:i:s', time());
        $update_data['is_delete'] = '1';
        $update_post = $this->common->update_data($update_data, 'user_post_comment', 'id', $comment_id);
        if ($update_post) {
            $return_data = array();
            $return_data['message'] = 1;
            $return_data['comment_data'] = $this->user_post_model->postCommentData($post_id);
            $return_data['comment_count'] = $this->user_post_model->postCommentCount($post_id);
        } else {
            $return_data['message'] = '0';
        }
        echo json_encode($return_data);
    }

    public function likePostComment() {
        $userid = $this->session->userdata('aileenuser');
        $comment_id = $_POST['comment_id'];
        $post_id = $_POST['post_id'];

        $userlikePostCommentData = $this->user_post_model->userlikePostCommentData($userid, $comment_id);

        $return_array = array();
        if ($userlikePostCommentData['id'] != '') {
            if ($userlikePostCommentData['is_like'] == '1') {
                $data = array();
                $data['is_like'] = '0';
                $data['modify_date'] = date('Y-m-d H:i:s', time());
                $updatedata = $this->common->update_data($data, 'user_post_comment_like', 'id', $userlikePostCommentData['id']);
                if ($updatedata) {
                    $return_array['message'] = '1';
                    $return_array['is_newLike'] = '0';
                    $return_array['is_oldLike'] = '1';
                    $return_array['commentLikeCount'] = $this->user_post_model->postCommentLikeCount($comment_id) == '0' ? '' : $this->user_post_model->postCommentLikeCount($comment_id);
                }
            } else {
                $data = array();
                $data['is_like'] = '1';
                $data['modify_date'] = date('Y-m-d H:i:s', time());
                $updatedata = $this->common->update_data($data, 'user_post_comment_like', 'id', $userlikePostCommentData['id']);
                if ($updatedata) {
                    $return_array['message'] = '1';
                    $return_array['is_newLike'] = '1';
                    $return_array['is_oldLike'] = '0';
                    $return_array['commentLikeCount'] = $this->user_post_model->postCommentLikeCount($comment_id) == '0' ? '' : $this->user_post_model->postCommentLikeCount($comment_id);
                }
            }
        } else {
            $data = array();
            $data['user_id'] = $userid;
            $data['comment_id'] = $comment_id;
            $data['created_date'] = date('Y-m-d H:i:s', time());
            $data['modify_date'] = date('Y-m-d H:i:s', time());
            $data['is_like'] = '1';
            $like_post_comment = $this->common->insert_data_getid($data, 'user_post_comment_like');
            if ($like_post_comment) {
                $return_array['message'] = '1';
                $return_array['is_newLike'] = '1';
                $return_array['is_oldLike'] = '0';
                $return_array['commentLikeCount'] = $this->user_post_model->postCommentLikeCount($comment_id) == '0' ? '' : $this->user_post_model->postCommentLikeCount($comment_id);
            } else {
                $return_array['message'] = '0';
                $return_array['is_newLike'] = '0';
                $return_array['is_oldLike'] = '0';
            }
        }
        echo json_encode($return_array);
    }

    public function postCommentUpdate() {
        $comment_id = $_POST['comment_id'];
        $comment = $_POST['comment'];

        $data = array();
        $data['comment'] = $comment;
        $data['modify_date'] = date('Y-m-d H:i:s', time());
        $updatedata = $this->common->update_data($data, 'user_post_comment', 'id', $comment_id);
        if ($updatedata) {
            $return_array = array();
            $return_array['message'] = 1;
            echo json_encode($return_array);
        }
    }

    public function viewLastComment() {
        $userid = $this->session->userdata('aileenuser');
        $post_id = $_POST['post_id'];
        $return_data = array();
        $return_data['comment_data'] = $this->user_post_model->postCommentData($post_id,$userid);
        echo json_encode($return_data);
    }

    public function viewAllComment() {
        $userid = $this->session->userdata('aileenuser');
        $post_id = $_POST['post_id'];
        $return_data = array();
        $return_data['all_comment_data'] = $this->user_post_model->viewAllComment($post_id,$userid);
        echo json_encode($return_data);
    }

    public function getUserPost() {
        $userid = $this->session->userdata('aileenuser');
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        $post_data = $this->user_post_model->userPost($userid, $page);
        echo json_encode($post_data);
    }

    public function getUserDashboardPost() {
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        $user_slug = $_GET["user_slug"];
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        $post_data = $this->user_post_model->userDashboardPost($userid, $page);
        echo json_encode($post_data);
    }

    public function getUserDashboardImage() {
        $user_slug = $_GET["user_slug"];
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        $post_image_data = $this->user_post_model->userDashboardImage($userid);
        echo json_encode($post_image_data);
    }

    public function getUserDashboardVideo() {
        $user_slug = $_GET["user_slug"];
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        $post_video_data = $this->user_post_model->userDashboardVideo($userid);
        echo json_encode($post_video_data);
    }

    public function getUserDashboardAudio() {
        $user_slug = $_GET["user_slug"];
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        $post_audio_data = $this->user_post_model->userDashboardAudio($userid);
        echo json_encode($post_audio_data);
    }

    public function getUserDashboardPdf() {
        $user_slug = $_GET["user_slug"];
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        $post_pdf_data = $this->user_post_model->userDashboardPdf($userid);
        echo json_encode($post_pdf_data);
    }

    public function deletePost() {
        $userid = $this->session->userdata('aileenuser');
        $post_id = $_POST['post_id'];

        $getPostUserId = $this->user_post_model->getPostUserId($post_id);

        $data = array();
        if ($userid == $getPostUserId) {
            $data['is_delete'] = '1';
            $updatedata = $this->common->update_data($data, 'user_post', 'id', $post_id);
        } else {
            $data['post_id'] = $post_id;
            $data['user_id'] = $userid;
            $data['delete_date'] = date('Y-m-d H:i:s', time());
            $deleteId = $this->common->insert_data_getid($data, 'user_post_delete');
        }

        if ($updatedata || $deleteId) {
            $return_array = array();
            $return_array['message'] = 1;
            echo json_encode($return_array);
        }
    }

    public function likePost() {
        $userid = $this->session->userdata('aileenuser');
        $post_id = $_POST['post_id'];

        $is_likepost = $this->user_post_model->is_likepost($userid, $post_id);

        if ($is_likepost['id'] != '') {
            if ($is_likepost['is_like'] == '1') {
                $data = array();
                $data['is_like'] = '0';
                $data['modify_date'] = date('Y-m-d H:i:s', time());
                $updatedata = $this->common->update_data($data, 'user_post_like', 'id', $is_likepost['id']);
                if ($updatedata) {
                    $return_array['message'] = '1';
                    $return_array['is_newLike'] = '0';
                    $return_array['is_oldLike'] = '1';
                    $return_array['likePost_count'] = $this->likePost_count($post_id);
                    $postLikeData = $this->user_post_model->postLikeData($post_id);
                    if ($return_array['likePost_count'] > 1) {
                        $return_array['post_like_data'] = $postLikeData['username'] . ' and ' . ($return_array['likePost_count'] - 1) . ' other';
                    } elseif ($return_array['likePost_count'] == 1) {
                        $return_array['post_like_data'] = $postLikeData['username'];
                    }
                }
            } else {
                $data = array();
                $data['is_like'] = '1';
                $data['modify_date'] = date('Y-m-d H:i:s', time());
                $updatedata = $this->common->update_data($data, 'user_post_like', 'id', $is_likepost['id']);
                if ($updatedata) {
                    $return_array['message'] = '1';
                    $return_array['is_newLike'] = '1';
                    $return_array['is_oldLike'] = '0';
                    $return_array['likePost_count'] = $this->likePost_count($post_id);
                    $postLikeData = $this->user_post_model->postLikeData($post_id);
                    if ($return_array['likePost_count'] > 1) {
                        $return_array['post_like_data'] = $postLikeData['username'] . ' and ' . ($return_array['likePost_count'] - 1) . ' other';
                    } elseif ($return_array['likePost_count'] == 1) {
                        $return_array['post_like_data'] = $postLikeData['username'];
                    }
                }
            }
        } else {
            $insert_data = array();
            $insert_data['user_id'] = $userid;
            $insert_data['post_id'] = $post_id;
            $insert_data['created_date'] = date('Y-m-d H:i:s', time());
            $insert_data['modify_date'] = date('Y-m-d H:i:s', time());
            $insert_data['is_like'] = '1';
            $user_post_like_id = $this->common->insert_data_getid($insert_data, 'user_post_like');
            $return_array = array();
            if ($user_post_like_id != '') {
                $return_array['message'] = '1';
                $return_array['is_newLike'] = '1';
                $return_array['is_oldLike'] = '0';
                $return_array['likePost_count'] = $this->likePost_count($post_id);
                $postLikeData = $this->user_post_model->postLikeData($post_id);
                if ($return_array['likePost_count'] > 1) {
                    $return_array['post_like_data'] = $postLikeData['username'] . ' and ' . ($return_array['likePost_count'] - 1) . ' other';
                } elseif ($return_array['likePost_count'] == 1) {
                    $return_array['post_like_data'] = $postLikeData['username'];
                }
            } else {
                $return_array['message'] = '0';
                $return_array['likePost_count'] = $this->likePost_count($post_id);
                $return_array['post_like_data'] = '';
            }
        }
        echo json_encode($return_array);
    }

    public function likePost_count($post_id = '') {
        $userid = $this->session->userdata('aileenuser');

        $likepost_count = $this->user_post_model->likepost_count($post_id);
        return $likepost_count;
    }

    public function post_opportunity() {
       
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
      
        
        $description = $_POST['description'] == 'undefined' ? '' : $_POST['description'];
        $field = $_POST['field'];
        $job_title = json_decode($_POST['job_title'], TRUE);
        $location = json_decode($_POST['location'], TRUE);
        $post_for = $_POST['post_for'];
        $question = $_POST['question'];
        $description = $_POST['description'];
        $other_field = $_POST['other_field'] == 'undefined' ? '' : $_POST['other_field'];
        $weblink = $_POST['weblink'] == 'undefined' ? '' : $_POST['weblink'];
        $is_anonymously = $_POST['is_anonymously'] == 'undefined' ? '0' : '1';
        $category = json_decode($_POST['category'], TRUE);


        $error = '';
        if ($post_for == 'opportunity') {
            if ($description == '') {
                $error = 1;
            } elseif ($field == '') {
                $error = 1;
            } elseif ($job_title[0]['name'] == '') {
                $error = 1;
            } elseif ($location[0]['city_name'] == '') {
                $error = 1;
            }
        }

        if ($post_for == 'question') {
            $ask_question = $question;
            $ask_description = $description;
            $ask_field = $field;
            $ask_category = $category;
            $ask_weblink = $weblink;

            if ($ask_question == '') {
                $error = 1;
            } elseif ($ask_field == '') {
                $error = 1;
            }
        }

        if ($error != '1') {
            if ($post_for == 'opportunity') {
                foreach ($job_title as $title) {
                    $designation = $this->data_model->findJobTitle($title['name']);
                    if ($designation['title_id'] != '') {
                        $jobTitleId = $designation['title_id'];
                    } else {
                        $data = array();
                        $data['name'] = $title['name'];
                        $data['created_date'] = date('Y-m-d H:i:s', time());
                        $data['modify_date'] = date('Y-m-d H:i:s', time());
                        $data['status'] = 'draft';
                        $data['slug'] = $this->common->clean($title['name']);
                        $jobTitleId = $this->common->insert_data_getid($data, 'job_title');
                    }
                    $job_title_id .= $jobTitleId . ',';
                }
                $job_title_id = trim($job_title_id, ',');
                foreach ($location as $loc) {
                    $city = $this->data_model->findCityList($loc['city_name']);
                    if ($city['city_id'] != '') {
                        $cityId = $city['city_id'];
                    } else {
                        $data = array();
                        $data['city_name'] = $loc['city_name'];
                        $data['state_id'] = '0';
                        $data['status'] = '2';
                        $data['group_id'] = '0';
                        $cityId = $this->common->insert_data_getid($data, 'cities');
                    }
                    $city_id .= $cityId . ',';
                }
                $city_id = trim($city_id, ',');
            } elseif ($post_for == 'question') {
                foreach ($ask_category as $ask) {
                    $asked = $this->data_model->findCategory($ask['name']);
                    if ($asked['id'] != '') {
                        $categoryId .= $asked['id'] . ',';
                    } else {
                        $data = array();
                        $data['name'] = $ask['name'];
                        $data['created_date'] = date('Y-m-d H:i:s', time());
                        $data['modify_date'] = date('Y-m-d H:i:s', time());
                        $data['user_id'] = $userid;
                        $data['status'] = 'draft';
                        $categorysId = $this->common->insert_data_getid($data, 'tags');
                        $categoryId .= $categorysId . ',';
                    }
                }
                $categoryId = trim($categoryId, ',');
            }
            $this->config->item('user_post_main_upload_path');
            $config = array(
                'image_library' => 'gd',
                'upload_path' => $this->config->item('user_post_main_upload_path'),
                'allowed_types' => $this->config->item('user_post_main_allowed_types'),
                'overwrite' => true,
                'remove_spaces' => true);

            $images = array();
            $this->load->library('upload');

            $files = $_FILES;
            $count = count($_FILES['postfiles']['name']);
            $title = time();

            $insert_data = array();
            $insert_data['user_id'] = $userid;
            if ($post_for == 'opportunity') {
                $insert_data['post_for'] = 'opportunity';
            } elseif ($post_for == 'simple') {
                $insert_data['post_for'] = 'simple';
            } elseif ($post_for == 'question') {
                $insert_data['post_for'] = 'question';
            }
            $insert_data['post_id'] = '';
            $insert_data['created_date'] = date('Y-m-d H:i:s', time());
            $insert_data['status'] = 'publish';
            $insert_data['is_delete'] = '0';

            $user_post_id = $this->common->insert_data_getid($insert_data, 'user_post');

            if ($post_for == 'opportunity') {
                $insert_data = array();
                $insert_data['post_id'] = $user_post_id;
                $insert_data['opportunity_for'] = $job_title_id;
                $insert_data['location'] = $city_id;
                $insert_data['opportunity'] = $description;
                $insert_data['field'] = $field;
                $insert_data['modify_date'] = date('Y-m-d H:i:s', time());

                $inserted_id = $user_opportunity_id = $this->common->insert_data_getid($insert_data, 'user_opportunity');
            } elseif ($post_for == 'simple') {
                $insert_data = array();
                $insert_data['post_id'] = $user_post_id;
                $insert_data['description'] = $description;
                $insert_data['modify_date'] = date('Y-m-d H:i:s', time());
                $inserted_id = $user_simple_id = $this->common->insert_data_getid($insert_data, 'user_simple_post');
            } elseif ($post_for == 'question') {
                $insert_data = array();
                $insert_data['post_id'] = $user_post_id;
                $insert_data['question'] = $ask_question;
                $insert_data['description'] = $ask_description;
                $insert_data['category'] = $categoryId;
                $insert_data['field'] = $ask_field;
                $insert_data['link'] = $ask_weblink;
                $insert_data['is_anonymously'] = $is_anonymously;
                $insert_data['modify_date'] = date('Y-m-d H:i:s', time());
                $inserted_id = $user_simple_id = $this->common->insert_data_getid($insert_data, 'user_ask_question');
            }
            $update_data = array();
            $update_data['post_id'] = $inserted_id;
            $update_post = $this->common->update_data($update_data, 'user_post', 'id', $user_post_id);

            $s3 = new S3(awsAccessKey, awsSecretKey);
            $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);

            if ($_FILES['postfiles']['name'][0] != '') {

                for ($i = 0; $i < $count; $i++) {

                    $_FILES['postfiles']['name'] = $files['postfiles']['name'][$i];
                    $_FILES['postfiles']['type'] = $files['postfiles']['type'][$i];
                    $_FILES['postfiles']['tmp_name'] = $files['postfiles']['tmp_name'][$i];
                    $_FILES['postfiles']['error'] = $files['postfiles']['error'][$i];
                    $_FILES['postfiles']['size'] = $files['postfiles']['size'][$i];

                    $file_type = $_FILES['postfiles']['type'];
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

                    if ($_FILES['postfiles']['error'] == 0) {
                        $store = $_FILES['postfiles']['name'];
                        $store_ext = explode('.', $store);
                        $store_ext = end($store_ext);
                        $fileName = 'file_' . $title . '_' . $this->random_string() . '.' . $store_ext;
                        $images[] = $fileName;
                        $config['file_name'] = $fileName;
                        $this->upload->initialize($config);
                        $imgdata = $this->upload->data();

                        if ($this->upload->do_upload('postfiles')) {
                            $upload_data = $response['result'][] = $this->upload->data();

                            if ($file_type == 'video') {
                                $uploaded_url = base_url() . $this->config->item('user_post_main_upload_path') . $response['result'][$i]['file_name'];
                                exec("ffmpeg -i " . $uploaded_url . " -vcodec h264 -acodec aac -strict -2 " . $upload_data['file_path'] . $upload_data['raw_name'] . "1" . $upload_data['file_ext'] . "");
                                exec("ffmpeg -ss 00:00:05 -i " . $upload_data['full_path'] . " " . $upload_data['file_path'] . $upload_data['raw_name'] . "1" . ".png");
                                //$fileName = $response['result'][$i]['file_name'] = $upload_data['raw_name'] . "1" . $upload_data['file_ext'];
                                $fileName = $response['result'][$i]['file_name'] = $upload_data['raw_name'] . "" . $upload_data['file_ext'];
                                if (IMAGEPATHFROM == 's3bucket') {
                                    unlink($this->config->item('user_post_main_upload_path') . $upload_data['raw_name'] . "" . $upload_data['file_ext']);
                                }
                            }

                            $main_image_size = $_FILES['postfiles']['size'];

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

                            $user_post_main[$i]['image_library'] = 'gd2';
                            $user_post_main[$i]['source_image'] = $this->config->item('user_post_main_upload_path') . $response['result'][$i]['file_name'];
                            $user_post_main[$i]['new_image'] = $this->config->item('user_post_main_upload_path') . $response['result'][$i]['file_name'];
                            $user_post_main[$i]['quality'] = $quality;
                            $instanse10 = "image10_$i";
                            $this->load->library('image_lib', $user_post_main[$i], $instanse10);
                            $this->$instanse10->watermark();

                            /* RESIZE */

                            $main_image = $this->config->item('user_post_main_upload_path') . $response['result'][$i]['file_name'];
                            if (IMAGEPATHFROM == 's3bucket') {
                                $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);
                            }

                            $post_poster = $response['result'][$i]['file_name'];
                            $post_poster1 = explode('.', $post_poster);
                            $post_poster2 = end($post_poster1);
                            $post_poster = str_replace($post_poster2, 'png', $post_poster);

                            $main_image1 = $this->config->item('user_post_main_upload_path') . $post_poster;
                            if (IMAGEPATHFROM == 's3bucket') {
                                $abc = $s3->putObjectFile($main_image1, bucket, $main_image1, S3::ACL_PUBLIC_READ);
                            }
                            $image_width = $response['result'][$i]['image_width'];
                            $image_height = $response['result'][$i]['image_height'];


                            if ($count == '3') {
                                /* RESIZE 4 */

                                $resize4_image_width = $this->config->item('user_post_resize4_width');
                                $resize4_image_height = $this->config->item('user_post_resize4_height');


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

                                $user_post_resize4[$i]['image_library'] = 'gd2';
                                $user_post_resize4[$i]['source_image'] = $this->config->item('user_post_main_upload_path') . $response['result'][$i]['file_name'];
                                $user_post_resize4[$i]['new_image'] = $this->config->item('user_post_resize4_upload_path') . $response['result'][$i]['file_name'];
                                $user_post_resize4[$i]['create_thumb'] = TRUE;
                                $user_post_resize4[$i]['maintain_ratio'] = TRUE;
                                $user_post_resize4[$i]['thumb_marker'] = '';
                                $user_post_resize4[$i]['width'] = $n_w1;
                                $user_post_resize4[$i]['height'] = $n_h1;
                                $user_post_resize4[$i]['quality'] = "100%";
                                $instanse4 = "image4_$i";
                                //Loading Image Library
                                $this->load->library('image_lib', $user_post_resize4[$i], $instanse4);
                                //Creating Thumbnail
                                $this->$instanse4->resize();
                                $this->$instanse4->clear();

                                $resize_image4 = $this->config->item('user_post_resize4_upload_path') . $response['result'][$i]['file_name'];
                                if (IMAGEPATHFROM == 's3bucket') {
                                    $abc = $s3->putObjectFile($resize_image4, bucket, $resize_image4, S3::ACL_PUBLIC_READ);
                                }
                                /* RESIZE 4 */
                            }

                            $thumb_image_width = $this->config->item('user_post_thumb_width');
                            $thumb_image_height = $this->config->item('user_post_thumb_height');


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

                            $user_post_thumb[$i]['image_library'] = 'gd2';
                            $user_post_thumb[$i]['source_image'] = $this->config->item('user_post_main_upload_path') . $response['result'][$i]['file_name'];
                            $user_post_thumb[$i]['new_image'] = $this->config->item('user_post_thumb_upload_path') . $response['result'][$i]['file_name'];
                            $user_post_thumb[$i]['create_thumb'] = TRUE;
                            $user_post_thumb[$i]['maintain_ratio'] = FALSE;
                            $user_post_thumb[$i]['thumb_marker'] = '';
                            $user_post_thumb[$i]['width'] = $n_w;
                            $user_post_thumb[$i]['height'] = $n_h;
                            $user_post_thumb[$i]['quality'] = "100%";
                            $user_post_thumb[$i]['x_axis'] = '0';
                            $user_post_thumb[$i]['y_axis'] = '0';
                            $instanse = "image_$i";
                            //Loading Image Library
                            $this->load->library('image_lib', $user_post_thumb[$i], $instanse);
                            $dataimage = $response['result'][$i]['file_name'];
                            //Creating Thumbnail
                            $this->$instanse->resize();

                            $thumb_image = $this->config->item('user_post_thumb_upload_path') . $response['result'][$i]['file_name'];
                            if (IMAGEPATHFROM == 's3bucket') {
                                $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);
                            }
                            if ($count == '2' || $count == '3') {
                                /* CROP 335 X 320 */
                                // reconfigure the image lib for cropping

                                $resized_image_width = $this->config->item('user_post_resize1_width');
                                $resized_image_height = $this->config->item('user_post_resize1_height');
                                if ($thumb_image_width < $resized_image_width) {
                                    $resized_image_width = $thumb_image_width;
                                }
                                if ($thumb_image_height < $resized_image_height) {
                                    $resized_image_height = $thumb_image_height;
                                }

                                $conf_new[$i] = array(
                                    'image_library' => 'gd2',
                                    'source_image' => $user_post_thumb[$i]['new_image'],
                                    'create_thumb' => FALSE,
                                    'maintain_ratio' => FALSE,
                                    'width' => $resized_image_width,
                                    'height' => $resized_image_height
                                );

                                $conf_new[$i]['new_image'] = $this->config->item('user_post_resize1_upload_path') . $response['result'][$i]['file_name'];

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

                                $resize_image = $this->config->item('user_post_resize1_upload_path') . $response['result'][$i]['file_name'];
                                if (IMAGEPATHFROM == 's3bucket') {
                                    $abc = $s3->putObjectFile($resize_image, bucket, $resize_image, S3::ACL_PUBLIC_READ);
                                }
                                /* CROP 335 X 320 */
                            }
                            if ($count == '4' || $count > '4') {
                              
                                /* CROP 335 X 245 */
                                // reconfigure the image lib for cropping

                                $resized_image_width = $this->config->item('user_post_resize2_width');
                                $resized_image_height = $this->config->item('user_post_resize2_height');
                                if ($thumb_image_width < $resized_image_width) {
                                    $resized_image_width = $thumb_image_width;
                                }
                                if ($thumb_image_height < $resized_image_height) {
                                    $resized_image_height = $thumb_image_height;
                                }


                                $conf_new1[$i] = array(
                                    'image_library' => 'gd2',
                                    'source_image' => $user_post_thumb[$i]['new_image'],
                                    'create_thumb' => FALSE,
                                    'maintain_ratio' => FALSE,
                                    'width' => $resized_image_width,
                                    'height' => $resized_image_height
                                );

                                $conf_new1[$i]['new_image'] = $this->config->item('user_post_resize2_upload_path') . $response['result'][$i]['file_name'];

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

                                $resize_image1 = $this->config->item('user_post_resize2_upload_path') . $response['result'][$i]['file_name'];
                                if (IMAGEPATHFROM == 's3bucket') {
                                    $abc = $s3->putObjectFile($resize_image1, bucket, $resize_image1, S3::ACL_PUBLIC_READ);
                                }

                                /* CROP 335 X 245 */
                            }
                            /* CROP 210 X 210 */
                            // reconfigure the image lib for cropping

                            $resized_image_width = $this->config->item('user_post_resize3_width');
                            $resized_image_height = $this->config->item('user_post_resize3_height');
                            if ($thumb_image_width < $resized_image_width) {
                                $resized_image_width = $thumb_image_width;
                            }
                            if ($thumb_image_height < $resized_image_height) {
                                $resized_image_height = $thumb_image_height;
                            }

                            $conf_new2[$i] = array(
                                'image_library' => 'gd2',
                                'source_image' => $user_post_thumb[$i]['new_image'],
                                'create_thumb' => FALSE,
                                'maintain_ratio' => FALSE,
                                'width' => $resized_image_width,
                                'height' => $resized_image_height
                            );

                            $conf_new2[$i]['new_image'] = $this->config->item('user_post_resize3_upload_path') . $response['result'][$i]['file_name'];

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
                            $resize_image2 = $this->config->item('user_post_resize3_upload_path') . $response['result'][$i]['file_name'];
                            if (IMAGEPATHFROM == 's3bucket') {
                                $abc = $s3->putObjectFile($resize_image2, bucket, $resize_image2, S3::ACL_PUBLIC_READ);
                            }

                            /* CROP 210 X 210 */
                            $response['error'][] = $thumberror = $this->$instanse->display_errors();
                            $return['data'][] = $imgdata;
                            $return['status'] = "success";
                            $return['msg'] = sprintf($this->lang->line('success_item_added'), "Image", "uploaded");

                            $insert_data = array();
                            $insert_data['post_id'] = $user_post_id;
                            $insert_data['file_type'] = $file_type;
                            $insert_data['filename'] = $fileName;
                            $insert_data['modify_date'] = date('Y-m-d H:i:s', time());

                            $insert_post_id = $this->common->insert_data_getid($insert_data, 'user_post_file');
                            /* THIS CODE UNCOMMENTED AFTER SUCCESSFULLY WORKING : REMOVE IMAGE FROM UPLOAD FOLDER */

                            if ($_SERVER['HTTP_HOST'] != "localhost") {
                                if (isset($main_image)) {
                                    unlink($main_image);
                                }
                                if (isset($thumb_image)) {
                                    unlink($thumb_image);
                                }
                                if (isset($resize_image)) {
                                    unlink($resize_image);
                                }
                                if (isset($resize_image1)) {
                                    unlink($resize_image1);
                                }
                                if (isset($resize_image2)) {
                                    unlink($resize_image2);
                                }
                                if (isset($resize_image4)) {
                                    unlink($resize_image4);
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
                }
            }

            $post_data = $this->user_post_model->userPost($userid, $start = '0', $limit = '1');
            //  echo count($post_data); '<pre>'; print_r($post_data); die();
            echo json_encode($post_data);
        }
    }

    public function getPostData() {
        $post_id = $_POST['post_id'];
        $post_for = $_POST['post_for'];

        if ($post_for == 'simple') {
            $post_data = $this->user_post_model->simplePost($post_id);
        } else if ($post_for == 'opportunity') {
            $post_data = $this->user_post_model->opportunityPost($post_id);

            $post_opp = explode(',', $post_data['opportunity_for']);
            $post_opp_loc = explode(',', $post_data['location']);

            foreach ($post_opp as $key => $value) {
                $opprtunity[$key]['name'] = $value;
            }

            foreach ($post_opp_loc as $key => $value) {
                $location[$key]['city_name'] = $value;
            }
//            $post_data['opportunity_for'] = json_encode($opprtunity);
//            $post_data['location'] = json_encode($location);
            $post_data['opportunity_for'] = $opprtunity;
            $post_data['location'] = $location;
//            echo '<pre>';
//            print_r($opprtunity);
//            print_r($location);
//            print_r($post_data);
//            exit;
        } else {
            $post_data = $this->user_post_model->askQuestionPost($post_id);

            $post_ask_que = explode(',', $post_data['tag_name']);

            foreach ($post_ask_que as $key => $value) {
                $tagname[$key]['name'] = $value;
            }

            // $post_data['tag_name'] = json_encode($tagname);
            $post_data['tag_name'] = $tagname;
        }
        echo json_encode($post_data);
    }

    public function edit_post_opportunity() {
        $userid = $this->session->userdata('aileenuser');
        $post_id = $_POST['post_id'];
        $post_for = $_POST['post_for'];

        if ($post_for == 'simple') {
            $description = $_POST['description'];

            $update_data = array();
            $update_data['description'] = $description;
            $update_data['modify_date'] = date('Y-m-d H:i:s', time());
            $update_post_data = $this->common->update_data($update_data, 'user_simple_post', 'post_id', $post_id);
        } else if ($post_for == 'opportunity') {

            $opp_desc = $_POST['description'];
            $opp_field = $_POST['field'];
            $job_title = json_decode($_POST['job_title'], TRUE);
            $location = json_decode($_POST['location'], TRUE);

            foreach ($job_title as $title) {
                $designation = $this->data_model->findJobTitle($title['name']);
                if ($designation['title_id'] != '') {
                    $jobTitleId = $designation['title_id'];
                } else {
                    $data = array();
                    $data['name'] = $title['name'];
                    $data['created_date'] = date('Y-m-d H:i:s', time());
                    $data['modify_date'] = date('Y-m-d H:i:s', time());
                    $data['status'] = 'draft';
                    $data['slug'] = $this->common->clean($title['name']);
                    $jobTitleId = $this->common->insert_data_getid($data, 'job_title');
                }
                $job_title_id .= $jobTitleId . ',';
            }
            $job_title_id = trim($job_title_id, ',');

            foreach ($location as $loc) {
                $city = $this->data_model->findCityList($loc['city_name']);
                if ($city['city_id'] != '') {
                    $cityId = $city['city_id'];
                } else {
                    $data = array();
                    $data['city_name'] = $loc['city_name'];
                    $data['state_id'] = '0';
                    $data['status'] = '2';
                    $data['group_id'] = '0';
                    $cityId = $this->common->insert_data_getid($data, 'cities');
                }
                $city_id .= $cityId . ',';
            }
            $city_id = trim($city_id, ',');

            $opportunity_location = $this->user_post_model->GetLocationName($city_id);
            $opportunity_title = $this->user_post_model->GetJobTitleName($job_title_id);
            $opportunity_field = $this->user_post_model->GetIndustryFieldName($opp_field);


            $update_data = array();
            $update_data['opportunity_for'] = $job_title_id;
            $update_data['location'] = $city_id;
            $update_data['opportunity'] = $opp_desc;
            $update_data['field'] = $opp_field;
            $update_data['modify_date'] = date('Y-m-d H:i:s', time());
            $update_post_data = $this->common->update_data($update_data, 'user_opportunity', 'post_id', $post_id);
        } else if ($post_for == 'question') {
            $ask_que = $_POST['question'];
            $ask_desc = $_POST['description'];
            $ask_field = $_POST['field'];
            $ask_other_field = $_POST['other_field'];
            $ask_web_link = $_POST['weblink'];
            $ask_category = json_decode($_POST['category'], TRUE);

            foreach ($ask_category as $ask) {
                $asked = $this->data_model->findCategory($ask['name']);
                if ($asked['id'] != '') {
                    $categoryId .= $asked['id'] . ',';
                } else {
                    $data = array();
                    $data['name'] = $ask['name'];
                    $data['created_date'] = date('Y-m-d H:i:s', time());
                    $data['modify_date'] = date('Y-m-d H:i:s', time());
                    $data['user_id'] = $userid;
                    $data['status'] = 'draft';
                    $categorysId = $this->common->insert_data_getid($data, 'tags');
                    $categoryId .= $categorysId . ',';
                }
            }
            $categoryId = trim($categoryId, ',');

            $question_category = $this->user_post_model->GetQuestionCategoryName($categoryId);
            $question_field = $this->user_post_model->GetIndustryFieldName($ask_field);

            $update_data = array();
            $update_data['question'] = $ask_que;
            $update_data['description'] = $ask_desc;
            $update_data['category'] = $categoryId;
            $update_data['field'] = $ask_field;
            $update_data['modify_date'] = date('Y-m-d H:i:s', time());
            $update_post_data = $this->common->update_data($update_data, 'user_ask_question', 'post_id', $post_id);
        }

        if ($update_post_data) {
            if ($post_for == 'opportunity') {
                $updatedata = array(
                    'response' => 1,
                    'opp_location' => $opportunity_location['location'],
                    'opp_opportunity_for' => $opportunity_title['opportunity_for'],
                    'opp_field' => $opportunity_field['field'],
                );
            } else if ($post_for == 'simple') {
                $updatedata = array(
                    'response' => 1,
                    'sim_description' => $description,
                );
            } else if ($post_for == 'question') {
                $updatedata = array(
                    'response' => 1,
                    'ask_question' => $ask_que,
                    'ask_description' => $ask_desc,
                    'ask_field' => $question_field['field'],
                    'ask_category' => $question_category['category'],
                );
            }
        } else {
            $updatedata = array(
                'response' => 0,
            );
        }

        echo json_encode($updatedata);
    }

    public function search() {
        $q = $_GET['q'];

        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['search_keyword'] = $q;

        $this->load->view('user_post/search', $this->data);
    }

    public function searchData() {
        $userid = $this->session->userdata('aileenuser');
        $searchKeyword = $_POST['searchKeyword'];
        $searchData = $this->user_post_model->searchData($userid,$searchKeyword);
        echo json_encode($searchData);
    }
    
    public function likeuserlist() {
        $userid = $this->session->userdata('aileenuser');
        $post_id = $_POST['post_id'];
        $userListData = $this->user_post_model->getLikeUserList($post_id);

        $data = array(
            'countlike' => count($userListData),
            'likeuserlist' => $userListData
        );
        echo json_encode($data);
    }

}
