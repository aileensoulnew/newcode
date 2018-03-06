<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Freelancer_apply_model extends CI_Model {

    public function getfreelancerapplydata($user_id, $select_data) {
        $this->db->select($select_data)->from('freelancer_post_reg');
        $this->db->where(array('user_id' => $user_id, 'is_delete' => '0', 'status' => '1'));
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function getfreelancerapplypost($user_id, $select_data) {
        $select_data = "post_id,post_name,(SELECT  Count(uv.invite_id) As invitecount FROM ailee_user_invite as uv WHERE   (uv.post_id = fp.post_id) ) As ShortListedCount,(SELECT  Count(afa.app_id) As invitecount FROM ailee_freelancer_apply as afa WHERE (afa.post_id = fp.post_id) ) As AppliedCount,fp.created_date,post_rate,GROUP_CONCAT(DISTINCT(s.skill)) as post_skill,post_rating_type,currency_name as post_currency,ct.city_name as city,cr.country_name as country,post_description,post_field_req";
        $this->db->select($select_data)->from('freelancer_post fp,ailee_skill s');
        $this->db->join('job_title jt', 'jt.title_id = fp.post_name', 'left');
        $this->db->join('currency c', 'c.currency_id = fp.post_currency', 'left');
        $this->db->join('cities ct', 'ct.city_id = fp.city', 'left');
        $this->db->join('countries cr', 'cr.country_id = fp.country', 'left');
        $this->db->where('FIND_IN_SET(s.skill_id, fp.`post_skill`) !=', 0);
        $this->db->where(array('fp.is_delete' => '0', 'fp.status' => '1'));
        $this->db->group_by('fp.post_skill');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function searchFreelancerApplyData($keyword = '', $location = '', $time = '') {

        $keyword = str_replace('%20', ' ', $keyword);
        $location = str_replace('%20', ' ', $location);

        // $busCat = $this->findBusinesCategory($keyword);
        $this->db->select('post_id,post_name,(SELECT  Count(uv.invite_id) As invitecount FROM ailee_user_invite as uv WHERE   (uv.post_id = fp.post_id) ) As ShortListedCount,(SELECT  Count(afa.app_id) As invitecount FROM ailee_freelancer_apply as afa WHERE (afa.post_id = fp.post_id) ) As AppliedCount,fp.created_date,post_rate,GROUP_CONCAT(DISTINCT(s.skill)) as post_skill,post_rating_type,currency_name as post_currency,ct.city_name as city,cr.country_name as country,post_description,post_field_req')->from('freelancer_post fp,ailee_skill s');
        $this->db->join('cities ct', 'ct.city_id = fp.city', 'left');
        $this->db->join('countries cr', 'cr.country_id = fp.country', 'left');
        $this->db->join('states st', 'st.state_name = fp.state', 'left');
        $this->db->join('freelancer_hire_reg fhg', 'fhg.user_id = fp.user_id', 'left');
        $this->db->join('currency c', 'c.currency_id = fp.post_currency', 'left');
        $this->db->where('FIND_IN_SET(s.skill_id, fp.`post_skill`) !=', 0);
        if ($keyword != '' && $busCat == '') {
            $this->db->where("(fp.post_name LIKE '%$keyword%' OR fp.post_description LIKE '%$keyword%')");
        } elseif ($keyword != '' && $busCat != '') {
            $this->db->where("(fp.company_name LIKE '%$keyword%' OR fp.address LIKE '%$keyword%' OR fp.contact_person LIKE '%$keyword%' OR bp.contact_mobile LIKE '%$keyword%' OR bp.contact_email LIKE '%$keyword%' OR bp.contact_website LIKE '%$keyword%' OR bp.details LIKE '%$keyword%' OR bp.business_slug LIKE '%$keyword%' OR bp.other_business_type LIKE '%$keyword%' OR bp.other_industrial LIKE '%$keyword%' OR bp.industriyal = '$busCat')");
        }
        if ($location != '') {
            $this->db->where("(ct.city_name = '$location' OR cr.country_name = '$location' OR st.state_name = '$location')");
        }
        $this->db->where('fp.status', '1');
        $this->db->where('fp.is_delete', '0');
        $this->db->group_by('fp.post_skill');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }
    
    function freelancerCategory($limit = '') {
        $this->db->select('count(fp.post_id) as count,ji.industry_id,ji.industry_name,ji.industry_slug')->from('job_industry ji');
        $this->db->join('freelancer_post fp', 'fp.post_field_req = ji.industry_id', 'left');
        $this->db->where('ji.status', '1');
        $this->db->where('ji.is_delete', '0');
        $this->db->where('fp.status', '1');
        $this->db->where('fp.is_delete', '0');
        $this->db->group_by('fp.post_field_req');
        $this->db->order_by('count', 'desc');
        $this->db->limit($limit);
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

}
