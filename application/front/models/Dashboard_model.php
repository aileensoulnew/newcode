<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
    
    function getUserBackImage($user_id = '') {
        $this->db->select("profile_background,profile_background_main")->from("user_info");
        $this->db->where("user_id", $user_id);
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }
    
    function getUserProfileImage($user_id = '') {
        $this->db->select("user_image")->from("user_info");
        $this->db->where("user_id", $user_id);
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    function jobRegData($user_id = '') {
        $this->db->select("job_step,status")->from("job_reg");
        $this->db->where("user_id", $user_id);
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }
    
    function recRegData($user_id = '') {
        $this->db->select("re_step,re_status")->from("recruiter");
        $this->db->where("user_id", $user_id);
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }
    
    function hireRegData($user_id = '') {
        $this->db->select("free_hire_step,status")->from("freelancer_hire_reg");
        $this->db->where("user_id", $user_id);
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }
    
    function workRegData($user_id = '') {
        $this->db->select("free_post_step,status")->from("freelancer_post_reg");
        $this->db->where("user_id", $user_id);
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }
    
    function busRegData($user_id = '') {
        $this->db->select("business_step,status")->from("business_profile");
        $this->db->where("user_id", $user_id);
        $this->db->where("is_deleted", '0');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }
    
    function artRegData($user_id = '') {
        $this->db->select("art_step,status")->from("art_reg");
        $this->db->where("user_id", $user_id);
        $this->db->where("is_delete", '0');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

}
