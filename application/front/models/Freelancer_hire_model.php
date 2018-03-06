<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Freelancer_hire_model extends CI_Model {

    public function getfreelancerhiredata($user_id = '', $select_data = '') {
        $this->db->select($select_data)->from('freelancer_hire_reg');
        $this->db->where(array('user_id' => $user_id, 'is_delete' => '0', 'status' => '1'));
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function getprojectdatabypostid($postid = '', $userid = '', $selectdata = '') {
        $this->db->select($selectdata)->from("freelancer_post fp");
        $this->db->join('freelancer_hire_reg fr', 'fp.user_id = fr.user_id', 'left');
        $this->db->where(array('fp.post_id' => $postid, 'fp.is_delete' => '0', 'fr.user_id' => $userid, 'fr.status' => '1', 'fr.free_hire_step' => '3'));
        $query = $this->db->get();
//       $result_array = $query->row_array();
        return $query->result_array();
    }

    public function checkfreelanceruser($user_id = '') {
        $this->db->select("freelancer_hire_slug")->from("freelancer_hire_reg");
        $this->db->where(array('user_id' => $user_id, 'status' => '0', 'is_delete' => '0'));
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function getCountry() {
        $this->db->select('country_id,country_name')->from('countries');
        $this->db->order_by("country_name", "ASC");
        $this->db->where(array('status' => '1'));
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getprojectlivedatabyuserid($userid = '') {
        $this->db->select('*')->from("freelancer_post_live pl");
        $this->db->where(array('status' => '1', 'is_delete' => '0', 'user_id' => $userid));
        $query = $this->db->get();
//       $result_array = $query->row_array();
        return $query->result_array();
    }

    function insert_data($data, $tablename) {
        if ($this->db->insert($tablename, $data)) {
            return true;
        } else {
            return false;
        }
    }

    function insert_data_getid($data, $tablename) {
        if ($this->db->insert($tablename, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function select_data_by_search($tablename, $search_condition, $condition_array = array(), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $group_by = '') {
        $this->db->select($data);

        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
            }
        }
        $this->db->where($condition_array);
        $this->db->where($search_condition);

        if ($limit != '' && $offset == 0) {
            $this->db->limit($limit);
        } elseif ($limit != '' && $offset != 0) {
            $this->db->limit($limit, $offset);
        }

        if ($sortby != '' && $orderby != '') {
            $this->db->order_by($sortby, $orderby);
        }
        $this->db->group_by($group_by);
        $query = $this->db->get($tablename);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function update_data($data, $tablename, $columnname, $columnid) {
        $this->db->where($columnname, $columnid);
        if ($this->db->update($tablename, $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function clean($string) {
        $string = str_replace(' ', '-', $string);
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        return preg_replace('/-+/', '-', $string);
    }

    function select_data_by_condition($tablename, $condition_array = array(), $data = '*', $sort_by = '', $order_by = '', $limit = '', $offset = '', $join_str = array(), $group_by = '') {
        $this->db->simple_query('SET SESSION group_concat_max_len=15000');
        $this->db->select($data);
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                if ($join['type'] == '') {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }

        if(!empty($having)){
            $this->db->having($having);
        }
        
        if ($sort_by != '' && $order_by != '') {
            $this->db->$order_by($sort_by, $order_by);
        }
        if ($limit != '' && $offset == 0) {
            $this->db->limit($limit);
        } else if ($limit != '' && $offset != 0) {
            $this->db->limit($limit, $offset);
        }
        if ($group_by) {
            $this->db->group_by($group_by);
        }

        $query = $this->db->get($tablename);

        if ($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }

}
