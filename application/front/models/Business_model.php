<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Business_model extends CI_Model {

    function businessCategory($limit = '') {
        $this->db->select('count(bp.business_profile_id) as count,industry_id,industry_name,industry_slug')->from('industry_type it');
        $this->db->join('business_profile bp', 'bp.industriyal = it.industry_id', 'left');
        $this->db->where('it.status', '1');
        $this->db->where('it.is_delete', '0');
        $this->db->where('bp.status', '1');
        $this->db->where('bp.is_deleted', '0');
        $this->db->where('bp.business_step', '4');
        $this->db->group_by('bp.industriyal');
        $this->db->order_by('count', 'desc');
        $this->db->limit($limit);
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function businessAllCategory() {
        $this->db->select('count(bp.business_profile_id) as count,industry_id,industry_name,industry_slug')->from('industry_type it');
        $this->db->join('business_profile bp', 'bp.industriyal = it.industry_id', 'left');
        $this->db->where('it.status', '1');
        $this->db->where('it.is_delete', '0');
        $this->db->where('bp.status', '1');
        $this->db->where('bp.is_deleted', '0');
        $this->db->where('bp.business_step', '4');
        $this->db->group_by('bp.industriyal');
        $this->db->order_by('count', 'desc');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function otherCategoryCount() {
        $this->db->select('count(bp.business_profile_id) as count')->from('business_profile bp');
        $this->db->where('bp.industriyal', '0');
        $this->db->where('bp.status', '1');
        $this->db->where('bp.is_deleted', '0');
        $this->db->where('bp.business_step', '4');
        $this->db->group_by('bp.industriyal');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['count'];
    }

    function businessListByCategory($id = '0') {
        $this->db->select('bp.business_user_image,bp.profile_background,bp.business_slug,bp.other_industrial,bp.company_name,bp.country,bp.city,bp.details,bp.contact_website,it.industry_name,ct.city_name as city,cr.country_name as country')->from('business_profile bp');
        $this->db->join('industry_type it', 'it.industry_id = bp.industriyal', 'left');
        $this->db->join('cities ct', 'ct.city_id = bp.city', 'left');
        $this->db->join('countries cr', 'cr.country_id = bp.country', 'left');
        $this->db->where('bp.industriyal', $id);
        $this->db->where('bp.status', '1');
        $this->db->where('bp.is_deleted', '0');
        $this->db->where('bp.business_step', '4');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function isBusinessAvailable($id = '') {
        $this->db->select('count(*) as total')->from('business_profile bp');
        $this->db->where('bp.user_id', $id);
        $this->db->where('bp.business_step', '4');
        $this->db->where('bp.is_deleted', '0');
        $this->db->where('bp.status', '1');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    function findBusinesCategory($keyword=''){
        $this->db->select('industry_id')->from('industry_type it');
        if ($keyword != '') {
            $this->db->where("(it.industry_name LIKE '%$keyword%')");
        }
        $this->db->where('it.status', '1');
        $this->db->where('it.is_delete', '0');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['industry_id'];
    }
    
    function searchBusinessData($keyword = '', $location = '') {
        $keyword = str_replace('%20', ' ', $keyword);
        $location = str_replace('%20', ' ', $location);
        
        $busCat = $this->findBusinesCategory($keyword);
        
        $this->db->select('bp.business_user_image,bp.profile_background,bp.business_slug,bp.other_industrial,bp.company_name,bp.country,bp.city,bp.details,bp.contact_website,it.industry_name,ct.city_name as city,cr.country_name as country')->from('business_profile bp');
        $this->db->join('industry_type it', 'it.industry_id = bp.industriyal', 'left');
        $this->db->join('cities ct', 'ct.city_id = bp.city', 'left');
        $this->db->join('countries cr', 'cr.country_id = bp.country', 'left');
        $this->db->join('states s', 's.state_name = bp.state', 'left');
        if ($keyword != '' && $busCat == '') {
            $this->db->where("(bp.company_name LIKE '%$keyword%' OR bp.address LIKE '%$keyword%' OR bp.contact_person LIKE '%$keyword%' OR bp.contact_mobile LIKE '%$keyword%' OR bp.contact_email LIKE '%$keyword%' OR bp.contact_website LIKE '%$keyword%' OR bp.details LIKE '%$keyword%' OR bp.business_slug LIKE '%$keyword%' OR bp.other_business_type LIKE '%$keyword%' OR bp.other_industrial LIKE '%$keyword%')");
        }elseif ($keyword != '' && $busCat != '') {
            $this->db->where("(bp.company_name LIKE '%$keyword%' OR bp.address LIKE '%$keyword%' OR bp.contact_person LIKE '%$keyword%' OR bp.contact_mobile LIKE '%$keyword%' OR bp.contact_email LIKE '%$keyword%' OR bp.contact_website LIKE '%$keyword%' OR bp.details LIKE '%$keyword%' OR bp.business_slug LIKE '%$keyword%' OR bp.other_business_type LIKE '%$keyword%' OR bp.other_industrial LIKE '%$keyword%' OR bp.industriyal = '$busCat')");
        }
        if ($location != '') {
            $this->db->where("(ct.city_name = '$location' OR cr.country_name = '$location' OR s.state_name = '$location')");
        }
        $this->db->where('bp.status', '1');
        $this->db->where('bp.is_deleted', '0');
        $this->db->where('bp.business_step', '4');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function business_followers($follow_to = '', $sortby = '', $orderby = '', $limit = '', $offset = '') {
        $this->db->select('*')->from('business_profile bp');
        $this->db->join('user_login ul', 'ul.user_id = bp.user_id');
        $this->db->join('follow f', 'f.follow_from = bp.business_profile_id');
        $this->db->where('f.follow_to', $follow_to);
        $this->db->where('f.follow_status', '1');
        $this->db->where('f.follow_type', '2');
        $this->db->where('bp.business_step', '4');
        $this->db->where('bp.is_deleted', '0');
        $this->db->where('bp.status', '1');
        $this->db->where('ul.status', '1');
        $this->db->where('ul.is_delete', '0');
        if ($orderby != '') {
            $this->db->order_by($sortby, $orderby);
        }
        if ($limit != '') {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function business_following($follow_from = '', $sortby = '', $orderby = '', $limit = '', $offset = '') {
        $this->db->select('*')->from('business_profile bp');
        $this->db->join('user_login ul', 'ul.user_id = bp.user_id');
        $this->db->join('follow f', 'f.follow_to = bp.business_profile_id');
        $this->db->where('f.follow_from', $follow_from);
        $this->db->where('f.follow_status', '1');
        $this->db->where('f.follow_type', '2');
        $this->db->where('bp.business_step', '4');
        $this->db->where('bp.is_deleted', '0');
        $this->db->where('bp.status', '1');
        $this->db->where('ul.status', '1');
        $this->db->where('ul.is_delete', '0');
        if ($orderby != '') {
            $this->db->order_by($sortby, $orderby);
        }
        if ($limit != '') {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function business_userlist($user_id = '', $sortby = '', $orderby = '', $limit = '', $offset = '') {
        $this->db->select('*')->from('business_profile bp');
        $this->db->join('user_login ul', 'ul.user_id = bp.user_id');
        $this->db->where('bp.user_id !=', $user_id);
        $this->db->where('bp.business_step', '4');
        $this->db->where('bp.is_deleted', '0');
        $this->db->where('bp.status', '1');
        $this->db->where('ul.status', '1');
        $this->db->where('ul.is_delete', '0');
        if ($orderby != '') {
            $this->db->order_by($sortby, $orderby);
        }
        if ($limit != '') {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function getBusinessPostComment($post_id = '', $sortby = '', $orderby = '', $limit = '') {
        $this->db->select('bppc.*')->from('business_profile_post_comment bppc');
        $this->db->join('user_login ul', 'ul.user_id = bppc.user_id');
        $this->db->where('business_profile_post_id', $post_id);
        $this->db->where('bppc.status', '1');
        $this->db->where('bppc.is_delete', '0');
        $this->db->where('ul.is_delete', '0');
        $this->db->where('ul.status', '1');
        if ($orderby != '') {
            $this->db->order_by($sortby, $orderby);
        }
        if ($limit != '') {
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function getBusinessLikeComment($post_id = '') {
        $this->db->select('bppc.*')->from('business_profile_post_comment bppc');
        $this->db->join('user_login ul', 'ul.user_id = bppc.user_id');
        $this->db->where('business_profile_post_comment_id', $post_id);
        $this->db->where('bppc.status', '1');
        $this->db->where('bppc.is_delete', '0');
        $this->db->where('ul.is_delete', '0');
        $this->db->where('ul.status', '1');
        if ($orderby != '') {
            $this->db->order_by($sortby, $orderby);
        }
        if ($limit != '') {
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function getBusinessCommentData($post_id = '', $select_data = '') {
        $this->db->select($select_data)->from('business_profile_post_comment bppc');
        $this->db->join('user_login ul', 'ul.user_id = bppc.user_id');
        $this->db->where('business_profile_post_comment_id', $post_id);
        $this->db->where('bppc.status', '1');
        $this->db->where('bppc.is_delete', '0');
        $this->db->where('ul.is_delete', '0');
        $this->db->where('ul.status', '1');
        if ($orderby != '') {
            $this->db->order_by($sortby, $orderby);
        }
        if ($limit != '') {
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function getBusinessDataBySlug($business_slug = '', $select_data = '*') {
        $this->db->select($select_data)->from('business_profile');
        $this->db->where("business_slug='$business_slug'");
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    function getBusinessTypeName($business_type = '') {
        $business_name = $this->db->select('business_name')->get_where('business_type', array('type_id' => $business_type, 'status' => '1', 'is_delete' => '0'))->row('business_name');
        return $business_name;
    }

    function getIndustriyalName($industriyal = '') {
        $industriyal_name = $this->db->select('industry_name')->get_where('industry_type', array('industry_id' => $industriyal, 'status' => '1', 'is_delete' => '0'))->row('industry_name');
        return $industriyal_name;
    }

}
