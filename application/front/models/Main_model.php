<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main_model extends CI_Model {

    function checkUserVisitor($ip = '', $date = '') {
        $this->db->select("count(*) as total")->from("user_visit");
        $this->db->where("ip", $ip);
        $this->db->where('insert_date BETWEEN "'. date('Y-m-d H:i:s', strtotime($date)). '" and "'. date('Y-m-d H:i:s', strtotime('+ 1 days')).'"');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

}
