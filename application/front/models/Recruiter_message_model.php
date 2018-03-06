<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Recruiter_message_model extends CI_Model {

    function getJObDataBySlug($job_slug='',$select_data='*'){ 
        $this->db->select($select_data)->from('job_reg');
        $this->db->where("slug='$job_slug'");
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }
    
    function getBusinessUserChatList($business_profile_id = '') {
        $this->db->select("max(m.id) as max_id")->from("messages m");
        //$this->db->where("m.message_from_profile_id='" . $business_profile_id . "' OR m.message_to_profile_id='" . $business_profile_id . "' AND m.is_deleted = '0' and m.message_from_profile = '5' AND m.message_to_profile = '5'");
        $this->db->where("((m.message_from_profile_id='" . $business_profile_id . "') OR (m.message_to_profile_id='" . $business_profile_id . "')) AND m.message_from_profile = '5' AND m.message_to_profile = '5' AND (CASE WHEN (m.message_from_profile_id = '$business_profile_id') THEN (m.is_message_from_delete = '0' AND m.is_deleted = '0') WHEN (m.message_to_profile_id = '$business_profile_id') THEN (m.is_message_to_delete = '0' AND m.is_deleted = '0') END)");
        $this->db->group_by("(CASE WHEN m.message_from_profile_id ='" . $business_profile_id . "' THEN m.message_to_profile_id ELSE m.message_from_profile_id END)");
        $query1 = $this->db->get();
        $result_array1 = $query1->result_array();

        $this->db->select("b.business_profile_id,b.company_name,b.business_user_image,b.business_slug,b.user_id,m.message,m.id,m.message_file_type")->from("business_profile  b");
        $this->db->join('messages m', 'b.business_profile_id = (CASE WHEN m.message_from_profile_id=' . $business_profile_id . ' THEN m.message_to_profile_id ELSE m.message_from_profile_id END)');
        $this->db->where("m.id IN (" . implode(',', array_column($result_array1, 'max_id')) . ")");
        $this->db->order_by("m.id", "DESC");
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }
    
//     function getBusinessTypeName($business_type=''){
//        $business_name = $this->db->select('business_name')->get_where('business_type',array('type_id' => $business_type, 'status'=> '1', 'is_delete' => '0'))->row('business_name');
//        return $business_name;
//    }
    
//    function getIndustriyalName($industriyal=''){
//        $industriyal_name = $this->db->select('industry_name')->get_where('industry_type',array('industry_id' => $industriyal, 'status'=> '1', 'is_delete' => '0'))->row('industry_name');
//        return $industriyal_name;
//    }
    
    public function getRecruiterUserChat() {
        $recruiter_profile_id = $this->data['recruiter_login_profile_id'];

        $recruiter_id = $_POST['recruiter_id'];
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

}
