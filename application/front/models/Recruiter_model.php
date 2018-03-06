<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Recruiter_model extends CI_Model {
 
    public function getRecruiterByUserid($user_id = '') {
        $this->db->select("r.rec_id,r.rec_firstname,r.rec_lastname,r.rec_email,r.re_status,r.rec_phone,r.re_comp_name,r.re_comp_email,r.re_comp_site,r.re_comp_country,r.re_comp_state,r.re_comp_city,r.user_id,r.re_comp_profile,r.re_comp_sector,r.re_comp_activities,r.re_step,r.re_comp_phone,r.recruiter_user_image,r.profile_background,r.profile_background_main,r.designation,r.comp_logo")->from("recruiter r");
        $this->db->where(array('r.user_id' => $user_id,'is_delete' => '0', 're_status' => '1'));
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }
    
    
     public function getRecruiterCompanyname($user_id = '') {
        $this->db->select("r.re_comp_name")->from("recruiter r");
        $this->db->where(array('r.user_id' => $user_id,'is_delete' => '0', 're_status' => '1'));
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }
    
    public function getRecruiterPostById($post_id = '',$user_id = '') {
        $this->db->select("rp.post_name,rp.max_year,rp.min_year,rp.fresher,rp.city,rp.state")->from("rec_post rp");
        $this->db->where(array('rp.post_id' => $post_id, 'rp.status' => '1', 'rp.is_delete' => '0', 'rp.user_id' => $user_id));
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }
    
     public function getRecruiterWhere($table_name = '',$where = '',$fieldvalue = '') {
       return $this->db->get_where($table_name, $where)->row_array()->$fieldvalue; 
    }
    
    public function CheckRecruiterAvailable($user_id = '') {
       $this->db->select("count(*) as total")->from("recruiter r");
        $this->db->where(array('r.user_id' => $user_id, 'r.re_status' => '1', 'r.is_delete' => '0', 'r.re_step' => '3'));
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array; 
    }
   
}
