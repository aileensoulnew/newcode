<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_post_model extends CI_Model {

    public function getContactSuggetion($user_id = '', $detailsdata = '') {

        if ($detailsdata == "student") {

            $this->db->select("u.user_slug,u.user_id,u.first_name,u.last_name,u.user_gender,ui.user_image,d.degree_name")->from("user u");
            $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
            $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
            $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
            $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
            $this->db->where('u.user_id !=', $user_id);
            $this->db->where('u.user_id NOT IN (select from_id from ailee_user_contact where to_id=' . $user_id . ')', NULL, FALSE);
            $this->db->where('u.user_id NOT IN (select to_id from ailee_user_contact where from_id=' . $user_id . ')', NULL, FALSE);
            $condition = '(us.current_study = (select us.current_study from ailee_user_student where user_id=' . $user_id . ') AND us.city = (select us.city from ailee_user_student where user_id=' . $user_id . '))';
            $this->db->where($condition);
            $this->db->order_by('us.current_study', 'asc');
          //  $this->db->order_by('us.city', 'asc');

            $this->db->limit('30');
            $query = $this->db->get();            
            return $result_array = $query->result_array();
        } else {
            $this->db->select("u.user_slug,u.user_id,u.first_name,u.last_name,u.user_gender,ui.user_image,jt.name as title_name")->from("user u");
            $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
            $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
            $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
            $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
            $this->db->where('u.user_id !=', $user_id);
            $this->db->where('u.user_id NOT IN (select from_id from ailee_user_contact where to_id=' . $user_id . ')', NULL, FALSE);
            $this->db->where('u.user_id NOT IN (select to_id from ailee_user_contact where from_id=' . $user_id . ')', NULL, FALSE);
            $condition = '(up.designation = (select up.designation from ailee_user_profession where user_id=' . $user_id . ') OR up.city = (select up.city from ailee_user_profession where user_id=' . $user_id . ') OR up.field = (select up.field from ailee_user_profession where user_id=' . $user_id . '))';
            $this->db->where($condition);
            $this->db->group_by("u.user_id");
            $this->db->order_by('up.designation', 'asc');
            $this->db->order_by('up.field', 'asc');
            $this->db->order_by('up.city', 'asc');
            $this->db->limit('30');
            $query = $this->db->get();
            $result_array = $query->result_array();
            //print_r($this->db->last_query());die;
            return $result_array;
        }
    }

    public function getContactAllSuggetion($user_id = '', $start='') {
        
        $this->db->select("u.user_id,CONCAT(u.first_name,' ',u.last_name) as fullname,u.user_gender,u.user_slug,ui.user_image,jt.name as title_name,d.degree_name")->from("user u");
        $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
        $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
        $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
        $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
        $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
        $this->db->where('u.user_id !=', $user_id);
        $this->db->where('u.user_id NOT IN (select from_id from ailee_user_contact where to_id=' . $user_id . ')', NULL, FALSE);
        $this->db->where('u.user_id NOT IN (select to_id from ailee_user_contact where from_id=' . $user_id . ')', NULL, FALSE);
        // $this->db->order_by('u.user_id', 'DESC');
        $this->db->order_by('up.designation', 'asc');
        $this->db->order_by('up.field', 'asc');
        $this->db->order_by('up.city', 'asc');
        $this->db->order_by('us.city', 'asc');
        $this->db->limit($start['offset']);
        //echo $this->db->last_query();
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function checkContact($user_id = '', $to_user_id = '') {
        $this->db->select("count(*) as total,id,status")->from("user_contact uc");
        $this->db->where('(from_id =' . $user_id . ' and to_id =' . $to_user_id . ') OR ( to_id =' . $user_id . ' AND from_id =' . $to_user_id . ')');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

//    public function get_jobtitle($search){
//        $this->db->select("name")->from("job_title jt");
//        $this->db->where('status','publish');
//        $this->db->like('name',$search);
//        $query = $this->db->get();
//        $result_array = $query->result_array();
//        return $result_array;
//    }
    public function get_jobtitle() {
        $this->db->select("name")->from("job_title jt");
        $this->db->where('status', 'publish');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_location() {
        $this->db->select("city_name")->from("cities c");
        $this->db->where('status', '1');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_category() {
        $this->db->select("name")->from("tags t");
        $this->db->where('status', 'publish');
        $this->db->where('is_delete', '0');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function is_likepost($userid = '', $post_id = '') {
        $this->db->select("upl.id,upl.is_like")->from("user_post_like upl");
        $this->db->join('user_login ul', 'ul.user_id = upl.user_id', 'left');
        $this->db->where('upl.user_id', $userid);
        $this->db->where('upl.post_id', $post_id);
        $this->db->where('ul.status', '1');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function likepost_count($post_id = '') {
        $this->db->select("COUNT(*) as like_count")->from("user_post_like upl");
        $this->db->join('user_login ul', 'ul.user_id = upl.user_id', 'left');
        $this->db->where('upl.post_id', $post_id);
        $this->db->where('ul.status', '1');
        $this->db->where('is_like', '1');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['like_count'];
    }

    public function is_userlikePost($user_id = '', $post_id = '') {
        $this->db->select("COUNT(*) as like_count")->from("user_post_like upl");
        $this->db->join('user_login ul', 'ul.user_id = upl.user_id', 'left');
        $this->db->where('upl.post_id', $post_id);
        $this->db->where('upl.user_id', $user_id);
        $this->db->where('ul.status', '1');
        $this->db->where('is_like', '1');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['like_count'];
    }

    public function postLikeData($post_id = '') {
        $this->db->select("CONCAT(u.first_name,' ',u.last_name) as username")->from("user_post_like upl");
        $this->db->join('user u', 'u.user_id = upl.user_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = upl.user_id', 'left');
        $this->db->where('upl.post_id', $post_id);
        $this->db->where('upl.is_like', '1');
        $this->db->where('ul.status', '1');
        $this->db->order_by('upl.id', 'desc');
        $this->db->limit('1');
        $query = $this->db->get();
        return $post_like_data = $query->row_array();
    }

    public function postCommentCount($post_id = '') {
        $this->db->select("COUNT(upc.id) as comment_count")->from("user_post_comment upc");
        $this->db->join('user_login ul', 'ul.user_id = upc.user_id', 'left');
        $this->db->where('upc.post_id', $post_id);
        $this->db->where('ul.status', '1');
        $this->db->where('upc.is_delete', '0');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['comment_count'];
    }

    public function postCommentData($post_id = '',$user_id = '') {
        $this->db->select("u.user_slug,u.user_gender,upc.user_id as commented_user_id,CONCAT(u.first_name,' ',u.last_name) as username, ui.user_image,upc.id as comment_id,upc.comment,upc.created_date")->from("user_post_comment upc");//UNIX_TIMESTAMP(STR_TO_DATE(upc.created_date, '%Y-%m-%d %H:%i:%s')) as created_date
        $this->db->join('user u', 'u.user_id = upc.user_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = upc.user_id', 'left');
        $this->db->join('user_info ui', 'ui.user_id = upc.user_id', 'left');
        $this->db->where('upc.post_id', $post_id);
        $this->db->where('ul.status', '1');
        $this->db->where('upc.is_delete', '0');
        $this->db->order_by('upc.id', 'desc');
        $this->db->limit('1');
        $query = $this->db->get();
        $post_comment_data = $query->result_array();
        foreach ($post_comment_data as $key => $value) {
            $post_comment_data[$key]['comment_time_string'] = $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($post_comment_data[$key]['created_date'])));
            $post_comment_data[$key]['is_userlikePostComment'] = $this->is_userlikePostComment($user_id, $value['comment_id']);
            $post_comment_data[$key]['postCommentLikeCount'] = $this->postCommentLikeCount($value['comment_id']) == '0' ? '' : $this->postCommentLikeCount($value['comment_id']);
        }
        return $post_comment_data;
    }

    public function viewAllComment($post_id = '', $user_id = '') {
        $this->db->select("u.user_slug,u.user_gender,upc.user_id as commented_user_id,CONCAT(u.first_name,' ',u.last_name) as username, ui.user_image,upc.id as comment_id,upc.comment,upc.created_date")->from("user_post_comment upc");//UNIX_TIMESTAMP(STR_TO_DATE(upc.created_date, '%Y-%m-%d %H:%i:%s')) as created_date
        $this->db->join('user u', 'u.user_id = upc.user_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = upc.user_id', 'left');
        $this->db->join('user_info ui', 'ui.user_id = upc.user_id', 'left');
        $this->db->where('upc.post_id', $post_id);
        $this->db->where('ul.status', '1');
        $this->db->where('upc.is_delete', '0');
        $this->db->order_by('upc.id', 'asc');
        $query = $this->db->get();
        $post_comment_data = $query->result_array();
        foreach ($post_comment_data as $key => $value) {
            $post_comment_data[$key]['comment_time_string'] = $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($post_comment_data[$key]['created_date'])));
            $post_comment_data[$key]['is_userlikePostComment'] = $this->is_userlikePostComment($user_id, $value['comment_id']);
            $post_comment_data[$key]['postCommentLikeCount'] = $this->postCommentLikeCount($value['comment_id']) == '0' ? '' : $this->postCommentLikeCount($value['comment_id']);
        }
        return $post_comment_data;
    }

    public function userlikePostCommentData($user_id = '', $comment_id = '') {
        $this->db->select("upcl.id,upcl.is_like")->from("user_post_comment_like upcl");
        $this->db->join('user_login ul', 'ul.user_id = upcl.user_id', 'left');
        $this->db->where('upcl.comment_id', $comment_id);
        $this->db->where('upcl.user_id', $user_id);
        $this->db->where('ul.status', '1');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function is_userlikePostComment($user_id = '', $comment_id = '') {
        $this->db->select("COUNT(upcl.id) as like_count")->from("user_post_comment_like upcl");
        $this->db->join('user_login ul', 'ul.user_id = upcl.user_id', 'left');
        $this->db->where('upcl.comment_id', $comment_id);
        $this->db->where('upcl.user_id', $user_id);
        $this->db->where('ul.status', '1');
        $this->db->where('is_like', '1');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['like_count'];
    }

    public function postCommentLikeCount($comment_id = '') {
        $this->db->select("COUNT(upcl.id) as like_count")->from("user_post_comment_like upcl");
        $this->db->join('user_login ul', 'ul.user_id = upcl.user_id', 'left');
        $this->db->where('upcl.comment_id', $comment_id);
        $this->db->where('ul.status', '1');
        $this->db->where('is_like', '1');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['like_count'];
    }

    public function userPostCount($user_id) {
        
        $getUserProfessionData = $this->user_model->getUserProfessionData($user_id, $select_data = 'field');
        $getUserStudentData = $this->user_model->getUserStudentData($user_id, $select_data = 'current_study');

        $getSameFieldProUser = $this->user_model->getSameFieldProUser($getUserProfessionData['field']);
        $getSameFieldStdUser = $this->user_model->getSameFieldStdUser($getUserStudentData['current_study']);

        $getDeleteUserPost = $this->deletePostUser($user_id);
        $this->db->select("COUNT(up.id) as post_count")->from("user_post up");
        if ($getUserProfessionData && $getSameFieldProUser) {
            $this->db->where('up.user_id IN (' . $getSameFieldProUser . ')');
        } elseif ($getUserStudentData && $getSameFieldStdUser) {
            $this->db->where('up.user_id IN (' . $getSameFieldStdUser . ')');
        }
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['post_count'];
    }

    public function userPostCountBySlug($user_slug = '') {
        $user_id = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');


        $getUserProfessionData = $this->user_model->getUserProfessionData($user_id, $select_data = 'field');
        $getUserStudentData = $this->user_model->getUserStudentData($user_id, $select_data = 'current_study');

        $getSameFieldProUser = $this->user_model->getSameFieldProUser($getUserProfessionData['field']);
        $getSameFieldStdUser = $this->user_model->getSameFieldStdUser($getUserStudentData['current_study']);

        $getDeleteUserPost = $this->deletePostUser($user_id);
        $this->db->select("COUNT(up.id) as post_count")->from("user_post up");
        if ($getUserProfessionData && $getSameFieldProUser) {
            $this->db->where('up.user_id IN (' . $getSameFieldProUser . ')');
        } elseif ($getUserStudentData && $getSameFieldStdUser) {
            $this->db->where('up.user_id IN (' . $getSameFieldStdUser . ')');
        }
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['post_count'];
    }

    public function getPostUserId($post_id = '') {
        $this->db->select("user_id")->from("user_post up");
        //$this->db->where('up.post_id', $post_id);
        $this->db->where('up.id', $post_id);//Pratik Change
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['user_id'];
    }

    public function deletePostUser($user_id = '') {
        $this->db->select("GROUP_CONCAT(CONCAT('''', `post_id`, '''' )) AS group_post")->from("user_post_delete upd");
        $this->db->where("upd.user_id", $user_id);
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['group_post'];
    }

    public function userPost($user_id = '', $page = '') {
        $limit = '5';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $getUserProfessionData = $this->user_model->getUserProfessionData($user_id, $select_data = 'field');
        $getUserStudentData = $this->user_model->getUserStudentData($user_id, $select_data = 'current_study');

        $getSameFieldProUser = $this->user_model->getSameFieldProUser($getUserProfessionData['field']);
        $getSameFieldStdUser = $this->user_model->getSameFieldStdUser($getUserStudentData['current_study']);

        $getDeleteUserPost = $this->deletePostUser($user_id);

        $result_array = array();
        $this->db->select("up.id,up.user_id,up.post_for,up.created_date,up.post_id")->from("user_post up");//UNIX_TIMESTAMP(STR_TO_DATE(up.created_date, '%Y-%m-%d %H:%i:%s')) as created_date
        if ($getUserProfessionData && $getSameFieldProUser) {
            $this->db->where('up.user_id IN (' . $getSameFieldProUser . ')');
        } elseif ($getUserStudentData && $getSameFieldStdUser) {
            $this->db->where('up.user_id IN (' . $getSameFieldStdUser . ')');
        }
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $this->db->order_by('up.id', 'desc');
        if ($limit != '') {
            $this->db->limit($limit,$start);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        $user_post = $query->result_array();

        foreach ($user_post as $key => $value) {
            $user_post[$key]['time_string'] = $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($user_post[$key]['created_date'])));
            $result_array[$key]['post_data'] = $user_post[$key];

            $this->db->select("count(*) as file_count")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $total_post_files = $query->row_array('file_count');
            $result_array[$key]['post_data']['total_post_files'] = $total_post_files['file_count'];

            $this->db->select("u.user_id,u.user_slug,u.first_name,u.last_name,u.user_gender,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user u");
            $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
            $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
            $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
            $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
            $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
            $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
            $this->db->where('u.user_id', $value['user_id']);
            $query = $this->db->get();
            $user_data = $query->row_array();
            $result_array[$key]['user_data'] = $user_data;

            if ($value['post_for'] == 'opportunity') {
                $this->db->select("uo.post_id,GROUP_CONCAT(DISTINCT(jt.name)) as opportunity_for,GROUP_CONCAT(DISTINCT(c.city_name)) as location,uo.opportunity,it.industry_name as field")->from("user_opportunity uo, ailee_job_title jt, ailee_cities c");
                $this->db->join('industry_type it', 'it.industry_id = uo.field', 'left');
                $this->db->where('uo.id', $value['post_id']);
                $this->db->where('FIND_IN_SET(jt.title_id, uo.`opportunity_for`) !=', 0);
                $this->db->where('FIND_IN_SET(c.city_id, uo.`location`) !=', 0);
                $this->db->group_by('uo.opportunity_for', 'uo.location');
                $query = $this->db->get();
                $opportunity_data = $query->row_array();
                $result_array[$key]['opportunity_data'] = $opportunity_data;
            } elseif ($value['post_for'] == 'simple') {
                $this->db->select("usp.description")->from("user_simple_post usp");
                $this->db->where('usp.id', $value['post_id']);
                $query = $this->db->get();
                $simple_data = $query->row_array();
                $result_array[$key]['simple_data'] = $simple_data;
            } elseif ($value['post_for'] == 'question') {
                $this->db->select("uaq.*,GROUP_CONCAT(DISTINCT(t.name)) as category,it.industry_name as field")->from("user_ask_question uaq, ailee_tags t");
                $this->db->join('industry_type it', 'it.industry_id = uaq.field', 'left');
                $this->db->where('uaq.id', $value['post_id']);
                $this->db->where('FIND_IN_SET(t.id, uaq.`category`) !=', 0);
                $this->db->group_by('uaq.category');
                $query = $this->db->get();
                $question_data = $query->row_array();
                $result_array[$key]['question_data'] = $question_data;
            } elseif ($value['post_for'] == 'profile_update') {
                $this->db->select("upu.*")->from("user_profile_update upu");
                $this->db->where('upu.id', $value['post_id']);
                $query = $this->db->get();
                $profile_update = $query->row_array();
                $result_array[$key]['profile_update'] = $profile_update;
            } elseif ($value['post_for'] == 'cover_update') {
                $this->db->select("upu.*")->from("user_profile_update upu");
                $this->db->where('upu.id', $value['post_id']);
                $query = $this->db->get();
                $cover_update = $query->row_array();
                $result_array[$key]['cover_update'] = $cover_update;
            }
            $this->db->select("upf.file_type,upf.filename")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $post_file_data = $query->result_array();
            $result_array[$key]['post_file_data'] = $post_file_data;

            $post_like_data = $this->postLikeData($value['id']);
            $post_like_count = $this->likepost_count($value['id']);
            $result_array[$key]['post_like_count'] = $post_like_count;
            $result_array[$key]['is_userlikePost'] = $this->is_userlikePost($user_id, $value['id']);
            if ($post_like_count > 1) {
                $result_array[$key]['post_like_data'] = $post_like_data['username'] . ' and ' . ($post_like_count - 1) . ' other';
            } elseif ($post_like_count == 1) {
                $result_array[$key]['post_like_data'] = $post_like_data['username'];
            }
            $result_array[$key]['post_comment_count'] = $this->postCommentCount($value['id']);
            $result_array[$key]['post_comment_data'] = $postCommentData = $this->postCommentData($value['id'],$user_id);

            foreach ($postCommentData as $key1 => $value1) {
                $result_array[$key]['post_comment_data'][$key1]['is_userlikePostComment'] = $this->is_userlikePostComment($user_id, $value1['comment_id']);
                $result_array[$key]['post_comment_data'][$key1]['postCommentLikeCount'] = $this->postCommentLikeCount($value1['comment_id']) == '0' ? '' : $this->postCommentLikeCount($value1['comment_id']);
            }

            $result_array[$key]['page_data']['page'] = $page;
            $result_array[$key]['page_data']['total_record'] = $this->userPostCount($user_id);
             $result_array[$key]['page_data']['perpage_record'] = $limit;
        }
//        echo '<pre>';
//        print_r($result_array);
//        exit;
        return $result_array;
    }

    public function userDashboardPost($user_id = '', $page = '') {
        $limit = '5';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $getDeleteUserPost = $this->deletePostUser($user_id);
        $result_array = array();
        $this->db->select("up.id,up.user_id,up.post_for,up.created_date,up.post_id")->from("user_post up");//UNIX_TIMESTAMP(STR_TO_DATE(up.created_date, '%Y-%m-%d %H:%i:%s')) as created_date
        $this->db->where('user_id', $user_id);
        $this->db->where('up.status', 'publish');
        $this->db->where('up.post_for != ', 'question');
        $this->db->where('up.is_delete', '0');
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->order_by('up.id', 'desc');
        if ($limit != '') {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get();
        $user_post = $query->result_array();

        foreach ($user_post as $key => $value) {
            $user_post[$key]['time_string'] = $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($user_post[$key]['created_date'])));
            $result_array[$key]['post_data'] = $user_post[$key];

            $this->db->select("count(*) as file_count")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $total_post_files = $query->row_array('file_count');
            $result_array[$key]['post_data']['total_post_files'] = $total_post_files['file_count'];

            $this->db->select("u.user_id,u.user_slug,u.user_gender,u.first_name,u.last_name,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user u");
            $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
            $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
            $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
            $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
            $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
            $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
            $this->db->where('u.user_id', $value['user_id']);
            $query = $this->db->get();
            $user_data = $query->row_array();
            $result_array[$key]['user_data'] = $user_data;

            if ($value['post_for'] == 'opportunity') {
                $this->db->select("uo.post_id,GROUP_CONCAT(DISTINCT(jt.name)) as opportunity_for,GROUP_CONCAT(DISTINCT(c.city_name)) as location,uo.opportunity,it.industry_name as field")->from("user_opportunity uo, ailee_job_title jt, ailee_cities c");
                $this->db->join('industry_type it', 'it.industry_id = uo.field', 'left');
                $this->db->where('uo.id', $value['post_id']);
                $this->db->where('FIND_IN_SET(jt.title_id, uo.`opportunity_for`) !=', 0);
                $this->db->where('FIND_IN_SET(c.city_id, uo.`location`) !=', 0);
                $this->db->group_by('uo.opportunity_for', 'uo.location');
                $query = $this->db->get();
                $opportunity_data = $query->row_array();
                $opportunity_data['opportunity'] = nl2br($this->common->make_links($opportunity_data['opportunity']));
                $result_array[$key]['opportunity_data'] = $opportunity_data;
            } elseif ($value['post_for'] == 'simple') {
                $this->db->select("usp.description")->from("user_simple_post usp");
                $this->db->where('usp.id', $value['post_id']);
                $query = $this->db->get();
                $simple_data = $query->row_array();
                $simple_data['description'] = $this->common->make_links(nl2br($simple_data['description']));//nl2br($this->common->make_links($simple_data['description']));
                $result_array[$key]['simple_data'] = $simple_data;
            } elseif ($value['post_for'] == 'question') {
                $this->db->select("uaq.*,IF(uaq.category != '', GROUP_CONCAT(DISTINCT(t.name)) , '') as category,it.industry_name as field")->from("user_ask_question uaq, ailee_tags t");
                $this->db->join('industry_type it', 'it.industry_id = uaq.field', 'left');
                $this->db->where('uaq.id', $value['post_id']);
                //$this->db->where('FIND_IN_SET(t.id, uaq.`category`) !=', 0);
                $this->db->where("IF(uaq.category != '', FIND_IN_SET(t.id, uaq.category) != 0 , '1')");
                $this->db->group_by('uaq.category');
                $query = $this->db->get();                
                $question_data = $query->row_array();
                $question_data['description'] = nl2br($this->common->make_links($question_data['description']));
                $result_array[$key]['question_data'] = $question_data;
            } elseif ($value['post_for'] == 'profile_update') {
                $this->db->select("upu.*")->from("user_profile_update upu");
                $this->db->where('upu.id', $value['post_id']);
                $query = $this->db->get();
                $profile_update = $query->row_array();
                $result_array[$key]['profile_update'] = $profile_update;
            } elseif ($value['post_for'] == 'cover_update') {
                $this->db->select("upu.*")->from("user_profile_update upu");
                $this->db->where('upu.id', $value['post_id']);
                $query = $this->db->get();
                $cover_update = $query->row_array();
                $result_array[$key]['cover_update'] = $cover_update;
            }
            $this->db->select("upf.file_type,upf.filename")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $post_file_data = $query->result_array();
            $result_array[$key]['post_file_data'] = $post_file_data;

            $post_like_data = $this->postLikeData($value['id']);
            $post_like_count = $this->likepost_count($value['id']);
            $result_array[$key]['post_like_count'] = $post_like_count;
            $result_array[$key]['is_userlikePost'] = $this->is_userlikePost($user_id, $value['id']);
            if ($post_like_count > 1) {
                $result_array[$key]['post_like_data'] = $post_like_data['username'] . ' and ' . ($post_like_count - 1) . ' other';
            } elseif ($post_like_count == 1) {
                $result_array[$key]['post_like_data'] = $post_like_data['username'];
            }
            $result_array[$key]['post_comment_count'] = $this->postCommentCount($value['id']);
            $result_array[$key]['post_comment_data'] = $postCommentData = $this->postCommentData($value['id'],$user_id);

            foreach ($postCommentData as $key1 => $value1) {
                $result_array[$key]['post_comment_data'][$key1]['is_userlikePostComment'] = $this->is_userlikePostComment($user_id, $value1['comment_id']);
                $result_array[$key]['post_comment_data'][$key1]['postCommentLikeCount'] = $this->postCommentLikeCount($value1['comment_id']) == '0' ? '' : $this->postCommentLikeCount($value1['comment_id']);
            }

            $result_array[$key]['page_data']['page'] = $page;
            $result_array[$key]['page_data']['total_record'] = $this->userPostCount($user_id);
            $result_array[$key]['page_data']['perpage_record'] = $limit;
        }
       // echo '<pre>';
       // print_r($result_array);
       // exit;
        return $result_array;
    }

    public function userDashboardImage($user_id = '') {
        $getDeleteUserPost = $this->deletePostUser($user_id);

        $sql = "SELECT main.* FROM (SELECT upf.post_id,upf.filename,'image' as filetype,up.created_date FROM ailee_user_post_file upf 
                LEFT JOIN ailee_user_post up ON up.id = upf.post_id 
                LEFT JOIN ailee_user_profile_update upu ON upu.id = up.post_id 
                WHERE upf.file_type = 'image' AND up.user_id = $user_id AND up.status = 'publish' AND up.is_delete = '0' 
                UNION
                SELECT up.id,upu.data_value as filename,upu.data_key as filetype,up.created_date FROM ailee_user_profile_update upu 
                LEFT JOIN ailee_user_post up ON upu.id = up.post_id 
                WHERE upu.user_id = $user_id AND ( up.post_for = 'profile_update' OR up.post_for = 'cover_update') AND up.status = 'publish' AND up.is_delete = '0'
                ) as main ";
        if ($getDeleteUserPost) {
            $sql .= "WHERE main.post_id NOT IN ($getDeleteUserPost) ";
        }
        $sql .= "ORDER BY main.created_date DESC LIMIT 6";
        

        $query = $this->db->query($sql);
        /*$this->db->select('upf.filename,upu.data_key,upu.data_value')->from('user_post_file upf');
        $this->db->join('user_post up', 'up.id = upf.post_id', 'left');
        $this->db->join('user_profile_update upu', 'upu.id = up.post_id', 'left');
        $this->db->where('upf.file_type', 'image');
        if($user_id != "")
        {
            $this->db->where('up.user_id', $user_id);
        }
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $this->db->order_by('upf.id', 'desc');
        $this->db->limit('6');
        $query = $this->db->get();
        echo $this->db->last_query();exit;*/
        $userDashboardImage = $query->result_array();
        //$result_array['userDashboardImage'] = $userDashboardImage;
        return $userDashboardImage;
    }

    public function userDashboardImageAll($user_id = '') {
        $getDeleteUserPost = $this->deletePostUser($user_id);
        
        $sql = "SELECT main.* FROM (SELECT upf.post_id,upf.filename,'image' as filetype,up.created_date FROM ailee_user_post_file upf 
                LEFT JOIN ailee_user_post up ON up.id = upf.post_id 
                LEFT JOIN ailee_user_profile_update upu ON upu.id = up.post_id 
                WHERE upf.file_type = 'image' AND up.user_id = $user_id AND up.status = 'publish' AND up.is_delete = '0' 
                UNION
                SELECT up.id,upu.data_value as filename,upu.data_key as filetype,up.created_date FROM ailee_user_profile_update upu 
                LEFT JOIN ailee_user_post up ON upu.id = up.post_id 
                WHERE upu.user_id = $user_id AND ( up.post_for = 'profile_update' OR up.post_for = 'cover_update') AND up.status = 'publish' AND up.is_delete = '0'
                ) as main ";
        if ($getDeleteUserPost) {
            $sql .= "WHERE main.post_id NOT IN ($getDeleteUserPost) ";
        }
        $sql .= "ORDER BY main.created_date DESC";

        $query = $this->db->query($sql);

        $userDashboardImage = $query->result_array();
        //$result_array['userDashboardImageAll'] = $userDashboardImage;
        return $userDashboardImage;
    }

    public function userDashboardVideo($user_id = '') {
        $getDeleteUserPost = $this->deletePostUser($user_id);
        $this->db->select('filename')->from('user_post_file upf');
        $this->db->join('user_post up', 'up.id = upf.post_id', 'left');
        $this->db->where('upf.file_type', 'video');
        if($user_id != "")
        {
            $this->db->where('up.user_id', $user_id);
        }
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $this->db->order_by('upf.id', 'desc');
        $this->db->limit('6');
        $query = $this->db->get();
        $userDashboardVideo = $query->result_array();
        //$result_array['userDashboardVideo'] = $userDashboardVideo;
        return $userDashboardVideo;
    }

    public function userDashboardVideoAll($user_id = '') {
        $getDeleteUserPost = $this->deletePostUser($user_id);
        $this->db->select('filename')->from('user_post_file upf');
        $this->db->join('user_post up', 'up.id = upf.post_id', 'left');
        $this->db->where('upf.file_type', 'video');
        if($user_id != "")
        {
            $this->db->where('up.user_id', $user_id);
        }
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $this->db->order_by('upf.id', 'desc');        
        $query = $this->db->get();
        $userDashboardVideoAll = $query->result_array();
        //$result_array['userDashboardVideo'] = $userDashboardVideo;
        return $userDashboardVideoAll;
    }

    public function userDashboardAudio($user_id = '') {
        $getDeleteUserPost = $this->deletePostUser($user_id);
        $this->db->select("upf.filename,up.id,up.post_for,IF(usp.description = 'undefined','',IFNULL(usp.description,'')) as description,IF(uo.opportunity = 'undefined','',IFNULL(uo.opportunity,'')) as opportunity")->from('user_post_file upf');
        $this->db->join('user_post up', 'up.id = upf.post_id', 'left');
        $this->db->join('user_simple_post usp', 'up.id = usp.post_id', 'left');
        $this->db->join('user_opportunity uo', 'up.id = uo.post_id', 'left');
        $this->db->where('upf.file_type', 'audio');
        if($user_id != "")
        {
            $this->db->where('up.user_id', $user_id);
        }
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $this->db->order_by('upf.id', 'desc');
        $this->db->limit('6');
        $query = $this->db->get();
        $userDashboardAudio = $query->result_array();
        //$result_array['userDashboardAudio'] = $userDashboardAudio;
        return $userDashboardAudio;
    }

    public function userDashboardAudioAll($user_id = '') {
        $getDeleteUserPost = $this->deletePostUser($user_id);
        $this->db->select("upf.filename,up.id,up.post_for,IF(usp.description = 'undefined','',IFNULL(usp.description,'')) as description,IF(uo.opportunity = 'undefined','',IFNULL(uo.opportunity,'')) as opportunity")->from('user_post_file upf');
        $this->db->join('user_post up', 'up.id = upf.post_id', 'left');
        $this->db->join('user_simple_post usp', 'up.id = usp.post_id', 'left');
        $this->db->join('user_opportunity uo', 'up.id = uo.post_id', 'left');
        $this->db->where('upf.file_type', 'audio');
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        if($user_id != "")
        {
            $this->db->where('up.user_id', $user_id);
        }
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->order_by('upf.id', 'desc');        
        $query = $this->db->get();
        $userDashboardAudioAll = $query->result_array();
        
        return $userDashboardAudioAll;
    }

    public function userDashboardPdf($user_id = '') {
        $getDeleteUserPost = $this->deletePostUser($user_id);
        $this->db->select("upf.filename,up.id,up.post_for,IF(usp.description = 'undefined','',IFNULL(usp.description,'')) as description,IF(uo.opportunity = 'undefined','',IFNULL(uo.opportunity,'')) as opportunity")->from('user_post_file upf');
        $this->db->join('user_post up', 'up.id = upf.post_id', 'left');
        $this->db->join('user_simple_post usp', 'up.id = usp.post_id', 'left');
        $this->db->join('user_opportunity uo', 'up.id = uo.post_id', 'left');;
        $this->db->where('upf.file_type', 'pdf');
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        if($user_id != "")
        {
            $this->db->where('up.user_id', $user_id);
        }
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->order_by('upf.id', 'desc');
        $this->db->limit('6');
        $query = $this->db->get();
        $userDashboardPdf = $query->result_array();
        $result_array['userDashboardPdf'] = $userDashboardPdf;
        return $result_array;
    }

    public function simplePost($post_id = '') {
        $this->db->select('description')->from('user_simple_post usp');
        $this->db->where('usp.post_id', $post_id);
        $query = $this->db->get();
        $userSimplePost = $query->row_array();
        return $userSimplePost;
    }

    public function opportunityPost($post_id = '') {
        $this->db->select("uo.post_id,field,GROUP_CONCAT(DISTINCT(jt.name)) as opportunity_for,GROUP_CONCAT(DISTINCT(c.city_name)) as location,uo.opportunity")->from("user_opportunity uo, ailee_job_title jt, ailee_cities c");
        $this->db->where('uo.post_id', $post_id);
        $this->db->where('FIND_IN_SET(jt.title_id, uo.`opportunity_for`) !=', 0);
        $this->db->where('FIND_IN_SET(c.city_id, uo.`location`) !=', 0);
        $this->db->group_by('uo.opportunity_for', 'uo.location');
        $query = $this->db->get();
        $opportunity_data = $query->row_array();
        return $opportunity_data;
    }

    public function askQuestionPost($post_id = '') {
        $this->db->select("question,description,category,field,GROUP_CONCAT(DISTINCT(tg.name)) as tag_name")->from("user_ask_question uaq, ailee_tags tg");
        $this->db->where('uaq.post_id', $post_id);
        $this->db->where('FIND_IN_SET(tg.id, uaq.`category`) !=', 0);
        $this->db->group_by('uaq.category');
        $query = $this->db->get();
        $userAskPost = $query->row_array();
        return $userAskPost;
    }

    public function GetQuestionCategoryName($categoryId = '') {
        $this->db->select("GROUP_CONCAT(DISTINCT(t.name)) as category")->from("ailee_tags t");
        $this->db->where('FIND_IN_SET(t.id,"' . $categoryId . '") !=', 0);
        $query = $this->db->get();
        $category = $query->row_array();
        return $category;
    }

    public function GetLocationName($city_id = '') {
        $this->db->select("GROUP_CONCAT(DISTINCT(c.city_name)) as location")->from("ailee_cities c");
        $this->db->where('FIND_IN_SET(c.city_id,"' . $city_id . '") !=', 0);
        $query = $this->db->get();
        $location = $query->row_array();
        return $location;
    }

    public function GetJobTitleName($job_title_id = '') {
        $this->db->select("GROUP_CONCAT(DISTINCT(jt.name)) as opportunity_for")->from("ailee_job_title jt");
        $this->db->where('FIND_IN_SET(jt.title_id,"' . $job_title_id . '") !=', 0);
        $query = $this->db->get();
        $title = $query->row_array();
        return $title;
    }

    public function GetIndustryFieldName($ask_field = '') {
        $this->db->select("it.industry_name as field")->from("industry_type it");
        $this->db->where('it.industry_id', $ask_field);
        $query = $this->db->get();
        $field = $query->row_array();
        return $field;
    }

    public function searchData($userid = '', $searchKeyword = '') {
        $checkKeywordCity = $this->data_model->findCityList($searchKeyword);
        if ($checkKeywordCity['city_id'] != '') {
            $keywordCity = $checkKeywordCity['city_id'];
        }
        $checkKeywordJobTitle = $this->data_model->findJobTitle($searchKeyword);
        if ($checkKeywordJobTitle['title_id'] != '') {
            $keywordJobTitle = $checkKeywordJobTitle['title_id'];
        }
        $checkKeywordFieldList = $this->data_model->findFieldList($searchKeyword);
        if ($checkKeywordFieldList['industry_id'] != '') {
            $keywordFieldList = $checkKeywordFieldList['industry_id'];
        }

        $checkKeywordUniversityList = $this->data_model->findUniversityList($searchKeyword);
        if ($checkKeywordUniversityList['university_id'] != '') {
            $keywordUniversityList = $checkKeywordUniversityList['university_id'];
        }
        $checkKeywordDegreeList = $this->data_model->findDegreeList($searchKeyword);
        if ($checkKeywordDegreeList['degree_id'] != '') {
            $keywordDegreeList = $checkKeywordDegreeList['degree_id'];
        }

        $this->db->select("u.user_id,u.first_name,u.last_name,CONCAT(u.first_name,' ',u.last_name) as fullname,u.user_slug,ui.user_image,jt.name as title_name,d.degree_name,it.industry_name,up.city as profession_city,us.city as student_city,d.degree_name,un.university_name")->from("user u");
        $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
        $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
        $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
        $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
        $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
        $this->db->join('industry_type it', 'it.industry_id = up.field', 'left');
        $this->db->join('university un', 'un.university_name = us.university_name', 'left');

//        if ($keywordCity) {
//            $this->db->where('up.city', $keywordCity);
//            $this->db->or_where('us.city', $keywordCity);
//        } else if ($keywordJobTitle) {
//            $this->db->where('up.designation', $keywordJobTitle);
//        } else if ($keywordFieldList) {
//            $this->db->where('up.field', $keywordFieldList);
//        } else if ($keywordUniversityList) {
//            $this->db->where('us.university_name', $keywordUniversityList);
//        } else if ($keywordDegreeList) {
//            $this->db->where('us.current_study', $keywordDegreeList);
//        } else {
//            $this->db->or_like('u.first_name', $searchKeyword);
//            $this->db->or_like('u.last_name', $searchKeyword);
//        }


        $this->db->where("u.first_name Like '%$searchKeyword%' OR u.last_name Like '%$searchKeyword%' OR up.city = '$keywordCity' OR us.city = '$keywordCity' OR up.designation = '$keywordJobTitle'"
                . " OR up.field = '$keywordFieldList' OR us.university_name = '$keywordUniversityList' OR us.current_study = '$keywordDegreeList'");
        $query = $this->db->get();

        $searchProfileData = $query->result_array();
        foreach ($searchProfileData as $key => $value) {
            $is_userBasicInfo = $this->user_model->is_userBasicInfo($value['user_id']);
            if ($is_userBasicInfo) {
                $searchProfileData[$key]['city'] = $this->data_model->getCityName($value['profession_city']);
                $state_id = $this->data_model->getStateIdByCityId($value['profession_city']);
                $searchProfileData[$key]['country'] = $this->data_model->getCountryByStateId($state_id);
            } else {
                $searchProfileData[$key]['city'] = $this->data_model->getCityName($value['student_city']);
                $state_id = $this->data_model->getStateIdByCityId($value['student_city']);
                $searchProfileData[$key]['country'] = $this->data_model->getCountryByStateId($state_id);
            }
            $contact_detail = $this->db->select('from_id,to_id,status,not_read')->from('user_contact')->where('(from_id =' . $value['user_id'] . ' AND to_id =' . $userid . ') OR (to_id =' . $value['user_id'] . ' AND from_id =' . $userid . ')')->get()->row_array();
            $searchProfileData[$key]['contact_from_id'] = $contact_detail['from_id'];
            $searchProfileData[$key]['contact_to_id'] = $contact_detail['to_id'];
            $searchProfileData[$key]['contact_status'] = $contact_detail['status'];
            $searchProfileData[$key]['contact_not_read'] = $contact_detail['not_read'];

            $follow_detail = $this->db->select('follow_from,follow_to,status')->from('user_follow')->where('(follow_from =' . $value['user_id'] . ' AND follow_to =' . $userid . ') OR (follow_to =' . $value['user_id'] . ' AND follow_from =' . $userid . ')')->get()->row_array();
            $searchProfileData[$key]['follow_from'] = $follow_detail['follow_from'];
            $searchProfileData[$key]['follow_to'] = $follow_detail['follow_to'];
            $searchProfileData[$key]['follow_status'] = $follow_detail['status'];
        }

        $searchData['profile'] = $searchProfileData;


        $searchPostData = array();
        $getDeleteUserPost = $this->deletePostUser($userid);

        $this->db->select("up.id,up.user_id,up.post_for,UNIX_TIMESTAMP(STR_TO_DATE(up.created_date, '%Y-%m-%d %H:%i:%s')) as created_date,up.post_id")->from("user_post up");
        $this->db->join('user_opportunity uo', 'uo.post_id = up.id', 'left');
        $this->db->join('user_simple_post usp', 'usp.post_id = up.id', 'left');
        $this->db->join('user_ask_question uaq', 'uaq.post_id = up.id', 'left');
        $this->db->where("(FIND_IN_SET('" . $keywordJobTitle . "',uo.opportunity_for) OR FIND_IN_SET('" . $keywordCity . "',uo.location) OR uo.opportunity LIKE '%$searchKeyword%' OR uo.field = '$keywordFieldList' OR usp.description LIKE '%$searchKeyword%'"
                . " OR uaq.question LIKE '%$searchKeyword%' OR uaq.description LIKE '%$searchKeyword%' OR uaq.field = '$keywordFieldList')");

        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->order_by('up.id', 'desc');
        $query = $this->db->get();
        $user_post = $query->result_array();

//        echo '<pre>';
//        print_r($user_post);
//        exit;

        /*
          $this->db->select("up.id,up.user_id,up.post_for,UNIX_TIMESTAMP(STR_TO_DATE(up.created_date, '%Y-%m-%d %H:%i:%s')) as created_date,up.post_id")->from("user_post up");
          $this->db->where('up.status', 'publish');
          $this->db->where('up.is_delete', '0');
          $this->db->order_by('up.id', 'desc');
          if ($limit != '') {
          $this->db->limit($limit, $start);
          }
          $query = $this->db->get();
          $user_post = $query->result_array();
         */
        foreach ($user_post as $key => $value) {
            $searchPostData[$key]['post_data'] = $user_post[$key];

            $this->db->select("count(*) as file_count")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $total_post_files = $query->row_array('file_count');
            $searchPostData[$key]['post_data']['total_post_files'] = $total_post_files['file_count'];

            $this->db->select("u.user_id,u.user_slug,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user u");
            $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
            $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
            $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
            $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
            $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
            $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
            $this->db->where('u.user_id', $value['user_id']);
            $query = $this->db->get();
            $user_data = $query->row_array();
            $searchPostData[$key]['user_data'] = $user_data;

            if ($value['post_for'] == 'opportunity') {
                $this->db->select("uo.post_id,GROUP_CONCAT(DISTINCT(jt.name)) as opportunity_for,GROUP_CONCAT(DISTINCT(c.city_name)) as location,uo.opportunity,it.industry_name as field")->from("user_opportunity uo, ailee_job_title jt, ailee_cities c");
                $this->db->join('industry_type it', 'it.industry_id = uo.field', 'left');
                $this->db->where('uo.id', $value['post_id']);
                $this->db->where('FIND_IN_SET(jt.title_id, uo.`opportunity_for`) !=', 0);
                $this->db->where('FIND_IN_SET(c.city_id, uo.`location`) !=', 0);
                $this->db->group_by('uo.opportunity_for', 'uo.location');
                $query = $this->db->get();
                $opportunity_data = $query->row_array();
                $searchPostData[$key]['opportunity_data'] = $opportunity_data;
            } elseif ($value['post_for'] == 'simple') {
                $this->db->select("usp.description")->from("user_simple_post usp");
                $this->db->where('usp.id', $value['post_id']);
                $query = $this->db->get();
                $simple_data = $query->row_array();
                $searchPostData[$key]['simple_data'] = $simple_data;
            } elseif ($value['post_for'] == 'question') {
                $this->db->select("uaq.*,GROUP_CONCAT(DISTINCT(t.name)) as category,it.industry_name as field")->from("user_ask_question uaq, ailee_tags t");
                $this->db->join('industry_type it', 'it.industry_id = uaq.field', 'left');
                $this->db->where('uaq.id', $value['post_id']);
                $this->db->where('FIND_IN_SET(t.id, uaq.`category`) !=', 0);
                $this->db->group_by('uaq.category');
                $query = $this->db->get();
                $question_data = $query->row_array();
                $searchPostData[$key]['question_data'] = $question_data;
            }
            $this->db->select("upf.file_type,upf.filename")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $post_file_data = $query->result_array();
            $searchPostData[$key]['post_file_data'] = $post_file_data;

            $post_like_data = $this->postLikeData($value['id']);
            $post_like_count = $this->likepost_count($value['id']);
            $searchPostData[$key]['post_like_count'] = $post_like_count;
            $searchPostData[$key]['is_userlikePost'] = $this->is_userlikePost($user_id, $value['id']);
            if ($post_like_count > 1) {
                $searchPostData[$key]['post_like_data'] = $post_like_data['username'] . ' and ' . ($post_like_count - 1) . ' other';
            } elseif ($post_like_count == 1) {
                $searchPostData[$key]['post_like_data'] = $post_like_data['username'];
            }
            $searchPostData[$key]['post_comment_count'] = $this->postCommentCount($value['id']);
            $searchPostData[$key]['post_comment_data'] = $postCommentData = $this->postCommentData($value['id'],$user_id);

            foreach ($postCommentData as $key1 => $value1) {
                $searchPostData[$key]['post_comment_data'][$key1]['is_userlikePostComment'] = $this->is_userlikePostComment($user_id, $value1['comment_id']);
                $searchPostData[$key]['post_comment_data'][$key1]['postCommentLikeCount'] = $this->postCommentLikeCount($value1['comment_id']) == '0' ? '' : $this->postCommentLikeCount($value1['comment_id']);
            }

            $searchPostData[$key]['page_data']['page'] = $page;
            $searchPostData[$key]['page_data']['total_record'] = $this->userPostCount($user_id);
            $searchPostData[$key]['page_data']['perpage_record'] = $limit;
        }

        $searchData['post'] = $searchPostData;

        return $searchData;
    }
    
    
    public function getLikeUserList($post_id = '') {
        $this->db->select("upl.id,upl.post_id,upl.user_id,upl.modify_date,u.user_slug,u.user_gender,u.first_name,u.last_name,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user_post_like upl");
        $this->db->join('user u', 'u.user_id = upl.user_id', 'left');
        $this->db->join('user_info ui', 'ui.user_id = upl.user_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = upl.user_id', 'left');
        $this->db->join('user_profession up', 'up.user_id = upl.user_id', 'left');
        $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
        $this->db->join('user_student us', 'us.user_id = upl.user_id', 'left');
        $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
        $this->db->where('upl.post_id',$post_id);
        $this->db->where('upl.is_like','1');
        $this->db->order_by('upl.id', 'DESC');
        $query = $this->db->get();
        $result_array = $query->result_array();
        foreach ($result_array as $key => $value) {
            $result_array[$key]['time_string'] = $this->common->time_elapsed_string($value['modify_date']);    
        }
        return $result_array;
    }

    public function getQuestionDataFromId($post_id)
    {
        $this->db->select("uaq.*,IF(uaq.category != '', GROUP_CONCAT(DISTINCT(t.name)) , '') as category,it.industry_name as field")->from("user_ask_question uaq, ailee_tags t");
        $this->db->join('industry_type it', 'it.industry_id = uaq.field', 'left');
        $this->db->where('uaq.post_id', $post_id);
        //$this->db->where('FIND_IN_SET(t.id, uaq.`category`) !=', 0);
        $this->db->where("IF(uaq.category != '', FIND_IN_SET(t.id, uaq.category) != 0 , '1')");
        $this->db->group_by('uaq.category');
        $query = $this->db->get();                
        $question_data = $query->row_array();
        $question_data['description'] = nl2br($this->common->make_links($question_data['description']));
        return $question_data;
    }

}
