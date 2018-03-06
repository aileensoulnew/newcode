<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Userprofile_model extends CI_Model {

    public function getdashboardata($user_id = '', $select_data = '') {
        $this->db->select($select_data)->from("user u");
        $this->db->join('art_reg a', 'a.user_id = u.user_id', 'left');
        $this->db->join('recruiter r', 'r.user_id = u.user_id', 'left');
        $this->db->join('job_reg jr', 'jr.user_id = u.user_id', 'left');
        $this->db->join('business_profile bp', 'bp.user_id = u.user_id', 'left');
        $this->db->join('freelancer_post_reg fp', 'fp.user_id = u.user_id', 'left');
        $this->db->join('freelancer_hire_reg fh', 'fh.user_id = u.user_id', 'left');
        $this->db->where("u.user_id =" . $user_id);
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function getContactData($user_id = '', $select_data = '', $page = '') {
        $limit = '6';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $where = "((from_id = '" . $user_id . "' OR to_id = '" . $user_id . "'))";

        $this->db->select("uc.id,u.user_id,u.first_name,u.last_name,ui.user_image,jt.name as title_name,d.degree_name,u.user_slug")->from("user_contact  uc");
        $this->db->join('user u', 'u.user_id = (CASE WHEN uc.from_id=' . $user_id . ' THEN uc.to_id ELSE uc.from_id END)', 'left');
        $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
        $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
        $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
        $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
        $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
        $this->db->where('u.user_id !=', $user_id);
        $this->db->where('uc.status', 'confirm');
        $this->db->where($where);
        $this->db->order_by("uc.id", "DESC");
        if ($limit != '') {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get();
        $result_array = $query->result_array();
        $total_record = $this->getContactCount($user_id, $select_data = '');

        $page_array['page'] = $page;
        $page_array['total_record'] = $total_record[0]['total'];
        $page_array['perpage_record'] = $limit;

        $data = array(
            'contactrecord' => $result_array,
            'pagedata' => $page_array
        );
        return $data;
        //  return $result_array;
    }

    public function getFollowersData($user_id = '', $select_data = '', $page = '') {

        $limit = '10';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $where = "((uf.follow_to = '" . $user_id . "'))";

        $this->db->select("u.user_id,u.first_name,u.last_name,ui.user_image,jt.name as title_name,d.degree_name,u.user_slug")->from("user_follow  uf");
        $this->db->join('user u', 'u.user_id = uf.follow_from', 'left');
        $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
        $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
        $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
        $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
        $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
//        $this->db->where('u.user_id !=', $user_id);
        $this->db->where('uf.status', '1');
        $this->db->where($where);
        $this->db->order_by("uf.id", "DESC");

        $query = $this->db->get();
        $result_array = $query->result_array();
        $user_follow_array = array();
       // echo $this->db->last_query();die;
        // echo '<pre>'; print_r($result_array); die();
        $new_follow_array = array();
        foreach ($result_array as $result) {
            $condition = "((uf.follow_from = '" . $user_id . "' AND uf.follow_to = '" . $result['user_id'] . "'))";
            $this->db->select("uf.id as follow_user_id")->from("user_follow uf");
            $this->db->where('uf.status', '1');
            $this->db->where($condition);
            $querry = $this->db->get();
            $result_query = $querry->result_array();
            $result['follow_user_id'] = $result_query[0]['follow_user_id'];

            array_push($new_follow_array, $result);
        }
        $total_record = $this->getFollowerCount($user_id, $select_data = '');
        $page_array['page'] = $page;
        $page_array['total_record'] = $total_record[0]['total'];
        $page_array['perpage_record'] = $limit;

        $data = array(
            'followerrecord' => $new_follow_array,
            'pagedata' => $page_array
        );
        return $data;
        // return $new_follow_array;
    }

    public function getFollowingData($user_id = '', $select_data = '', $page = '') {

        $limit = '10';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;
        $where = "((uf.follow_from = '" . $user_id . "'))";
        $this->db->select("u.user_id,u.first_name,u.last_name,ui.user_image,jt.name as title_name,d.degree_name,u.user_slug")->from("user_follow  uf");
        $this->db->join('user u', 'u.user_id = uf.follow_to', 'left');
        $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
        $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
        $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
        $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
        $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
//        $this->db->where('u.user_id !=', $user_id);
        $this->db->where('uf.status', '1');
        $this->db->where($where);
        $this->db->order_by("uf.id", "DESC");

        $query = $this->db->get();
        $result_array = $query->result_array();
        $total_record = $this->getFollowingCount($user_id, $select_data = '');
        $page_array['page'] = $page;
        $page_array['total_record'] = $total_record[0]['total'];
        $page_array['perpage_record'] = $limit;

        $data = array(
            'followingrecord' => $result_array,
            'pagedata' => $page_array
        );
        return $data;
        // return $result_array;
    }

    public function userContactStatus($user_id = '', $id = '') {
        $this->db->select("uc.status,uc.id")->from("user_contact as uc");
        $where = "((from_id = '" . $user_id . "' AND to_id = '" . $id . "') OR (from_id = '" . $id . "' AND to_id = '" . $user_id . "'))";
        $this->db->where($where);
        $this->db->order_by("uc.id", "DESC");
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function userFollowStatus($user_id = '', $id = '') {
        $this->db->select("uf.status,uf.id")->from("user_follow as uf");
        $where = "((follow_from = '" . $user_id . "' AND follow_to = '" . $id . "'))";
        $this->db->where($where);
        $this->db->order_by("uf.id", "DESC");
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    function getUserBackImage($user_id = '') {
        $this->db->select("profile_background,profile_background_main")->from("user_info");
        $this->db->where("user_id", $user_id);
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function getContactCount($user_id = '', $select_data = '') {

        $where = "((from_id = '" . $user_id . "' OR to_id = '" . $user_id . "'))";

        $this->db->select("count(*) as total")->from("user_contact  uc");
        $this->db->where('uc.status', 'confirm');
        $this->db->where($where);
        $this->db->order_by("uc.id", "DESC");
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function getFollowingCount($user_id = '', $select_data = '') {
        $where = "((uf.follow_from = '" . $user_id . "'))";
        $this->db->select("count(*) as total")->from("user_follow  uf");
        $this->db->where('uf.status', '1');
        $this->db->where($where);
        $this->db->order_by("uf.id", "DESC");
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function getFollowerCount($user_id = '', $select_data = '') {
        $where = "((uf.follow_to = '" . $user_id . "'))";
        $this->db->select("count(*) as total")->from("user_follow  uf");
        $this->db->where('uf.status', '1');
        $this->db->where($where);
        $this->db->order_by("uf.id", "DESC");
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function userDashboardPost($user_id = '', $page = '') {
        $limit = '4';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $result_array = array();
        $this->db->select("up.id,up.user_id,up.post_for,UNIX_TIMESTAMP(STR_TO_DATE(up.created_date, '%Y-%m-%d %H:%i:%s')) as created_date,up.post_id")->from("user_post up");
        $this->db->where('user_id', $user_id);
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $this->db->order_by('up.id', 'desc');
        if ($limit != '') {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get();
        $user_post = $query->result_array();

        foreach ($user_post as $key => $value) {
            $result_array[$key]['post_data'] = $user_post[$key];

            $this->db->select("count(*) as file_count")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $total_post_files = $query->row_array('file_count');
            $result_array[$key]['post_data']['total_post_files'] = $total_post_files['file_count'];

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
            $result_array[$key]['post_comment_data'] = $postCommentData = $this->postCommentData($value['id']);

            foreach ($postCommentData as $key1 => $value1) {
                $result_array[$key]['post_comment_data'][$key1]['is_userlikePostComment'] = $this->is_userlikePostComment($user_id, $value1['comment_id']);
                $result_array[$key]['post_comment_data'][$key1]['postCommentLikeCount'] = $this->postCommentLikeCount($value1['comment_id']) == '0' ? '' : $this->postCommentLikeCount($value1['comment_id']);
            }
        }

        $page_array['page'] = $page;
        $page_array['total_record'] = $this->userPostCount($user_id);
        $page_array['perpage_record'] = $limit;

        $data = array(
            'postrecord' => $result_array,
            'pagedata' => $page_array
        );
        return $data;
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

    public function postCommentData($post_id = '') {
        $this->db->select("u.user_slug,CONCAT(u.first_name,' ',u.last_name) as username, ui.user_image,upc.id as comment_id,upc.comment,UNIX_TIMESTAMP(STR_TO_DATE(upc.created_date, '%Y-%m-%d %H:%i:%s')) as created_date")->from("user_post_comment upc");
        $this->db->join('user u', 'u.user_id = upc.user_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = upc.user_id', 'left');
        $this->db->join('user_info ui', 'ui.user_id = upc.user_id', 'left');
        $this->db->where('upc.post_id', $post_id);
        $this->db->where('ul.status', '1');
        $this->db->where('upc.is_delete', '0');
        $this->db->order_by('upc.id', 'desc');
        $this->db->limit('1');
        $query = $this->db->get();
        return $post_comment_data = $query->result_array();
    }

    public function userPostCount($user_id = '') {
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

    public function deletePostUser($user_id = '') {
        $this->db->select("GROUP_CONCAT(CONCAT('''', `post_id`, '''' )) AS group_post")->from("user_post_delete upd");
        $this->db->where("upd.user_id", $user_id);
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['group_post'];
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

    public function questionData($question_id = '', $user_id = '') {
        $getDeleteUserPost = $this->deletePostUser($user_id);

        $result_array = array();
        $this->db->select("up.id,up.user_id,up.post_for,UNIX_TIMESTAMP(STR_TO_DATE(up.created_date, '%Y-%m-%d %H:%i:%s')) as created_date,up.post_id")->from("user_post up");
        if ($getUserProfessionData && $getSameFieldProUser) {
            $this->db->where('up.user_id IN (' . $getSameFieldProUser . ')');
        } elseif ($getUserStudentData && $getSameFieldStdUser) {
            $this->db->where('up.user_id IN (' . $getSameFieldStdUser . ')');
        }
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->join('user_ask_question uaq', 'uaq.post_id = up.id', 'left');
        $this->db->where('uaq.id', $question_id);
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $query = $this->db->get();
        $user_post = $query->result_array();

        foreach ($user_post as $key => $value) {
            $result_array[$key]['post_data'] = $user_post[$key];

            $this->db->select("count(*) as file_count")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $total_post_files = $query->row_array('file_count');
            $result_array[$key]['post_data']['total_post_files'] = $total_post_files['file_count'];

            $this->db->select("u.user_id,u.user_slug,u.first_name,u.last_name,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user u");
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

            $this->db->select("uaq.*,GROUP_CONCAT(DISTINCT(t.name)) as category,it.industry_name as field")->from("user_ask_question uaq, ailee_tags t");
            $this->db->join('industry_type it', 'it.industry_id = uaq.field', 'left');
            $this->db->where('uaq.id', $value['post_id']);
            $this->db->where('FIND_IN_SET(t.id, uaq.`category`) !=', 0);
            $this->db->group_by('uaq.category');
            $query = $this->db->get();
            $question_data = $query->row_array();
            $result_array[$key]['question_data'] = $question_data;

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
            $result_array[$key]['post_comment_data'] = $postCommentData = $this->postCommentData($value['id']);

            foreach ($postCommentData as $key1 => $value1) {
                $result_array[$key]['post_comment_data'][$key1]['is_userlikePostComment'] = $this->is_userlikePostComment($user_id, $value1['comment_id']);
                $result_array[$key]['post_comment_data'][$key1]['postCommentLikeCount'] = $this->postCommentLikeCount($value1['comment_id']) == '0' ? '' : $this->postCommentLikeCount($value1['comment_id']);
            }

            $result_array[$key]['page_data']['page'] = $page;
            $result_array[$key]['page_data']['total_record'] = $this->userPostCount($user_id);
        }
        return $result_array;
    }

    public function questionList($user_id = '') {
        $result_array = array();
        $this->db->select("up.id,up.user_id,up.post_for,UNIX_TIMESTAMP(STR_TO_DATE(up.created_date, '%Y-%m-%d %H:%i:%s')) as created_date,up.post_id")->from("user_post up");
        if ($getUserProfessionData && $getSameFieldProUser) {
            $this->db->where('up.user_id IN (' . $getSameFieldProUser . ')');
        } elseif ($getUserStudentData && $getSameFieldStdUser) {
            $this->db->where('up.user_id IN (' . $getSameFieldStdUser . ')');
        }
        $this->db->join('user_ask_question uaq', 'uaq.post_id = up.id', 'left');
        $this->db->where('up.user_id', $user_id);
        $this->db->where('up.status', 'publish');
        $this->db->where('up.post_for', 'question');
        $this->db->where('up.is_delete', '0');
        $query = $this->db->get();
        $user_post = $query->result_array();

        foreach ($user_post as $key => $value) {
            $result_array[$key]['post_data'] = $user_post[$key];

            $this->db->select("count(*) as file_count")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $total_post_files = $query->row_array('file_count');
            $result_array[$key]['post_data']['total_post_files'] = $total_post_files['file_count'];

            $this->db->select("u.user_id,u.user_slug,u.first_name,u.last_name,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user u");
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

            $this->db->select("uaq.*,GROUP_CONCAT(DISTINCT(t.name)) as category,it.industry_name as field")->from("user_ask_question uaq, ailee_tags t");
            $this->db->join('industry_type it', 'it.industry_id = uaq.field', 'left');
            $this->db->where('uaq.id', $value['post_id']);
            $this->db->where('FIND_IN_SET(t.id, uaq.`category`) !=', 0);
            $this->db->group_by('uaq.category');
            $query = $this->db->get();
            $question_data = $query->row_array();
            $result_array[$key]['question_data'] = $question_data;

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

}
