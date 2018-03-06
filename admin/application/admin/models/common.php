<?php

class Common extends CI_Model {

    // insert database
    function insert_data($data, $tablename) {
        if ($this->db->insert($tablename, $data)) {
            return true;
        } else {
            return false;
        }
    }

    // insert database
    function insert_data_getid($data, $tablename) {
        if ($this->db->insert($tablename, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    // update database
    function update_data($data, $tablename, $columnname, $columnid) {
        $this->db->where($columnname, $columnid);
        if ($this->db->update($tablename, $data)) {
            return true;
        } else {
            return false;
        }
    }

    // select data using colum id
    function select_data_by_id($tablename, $columnname, $columnid, $data = '*', $join_str = array()) {
       if($data!='*')
       
        $this->db->select($data);
       
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                if ($join['join_type'] == '') {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }
        $this->db->where($columnname, $columnid);
        $query = $this->db->get($tablename);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    // select data using multiple conditions
    function select_data_by_condition($tablename, $contition_array = array(), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array()) {
        
        //print_r($join_str);
        //die();
        
        $this->db->select($data);

        if (!empty($join_str)) {
           // pre($join_str);
            foreach ($join_str as $join) {
                if ($join['join_type'] == '') {
                $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                }
                else{
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }

        $this->db->where($contition_array);
        if(!empty($having)){
            $this->db->having($having);
        }
        //Setting Limit for Paging
        if ($limit != '' && $offset == 0) {
            $this->db->limit($limit);
        } else if ($limit != '' && $offset != 0) {
            $this->db->limit($limit, $offset);
        }
        //order by query
        if ($sortby != '' && $orderby != '') {
            $this->db->order_by($sortby, $orderby);
        }

        
        $query = $this->db->get($tablename);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    // select data using multiple conditions and search keyword
    function select_data_by_search($tablename, $search_condition, $contition_array = array(), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str=array()) {
        $this->db->select($data);        
        if (!empty($join_str)) {
            foreach ($join_str as $join) {                
                $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
            }
        }
       

        $this->db->where($contition_array);
        $this->db->where($search_condition);
        //Setting Limit for Paging
        if ($limit != '' && $offset == 0) {
            $this->db->limit($limit);
        } else if ($limit != '' && $offset != 0) {
            $this->db->limit($limit, $offset);
        }
        //order by query
        if ($sortby != '' && $orderby != '') {
            $this->db->order_by($sortby, $orderby);
        }
        
        $query = $this->db->get($tablename);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    // delete data
    function delete_data($tablename, $columnname, $columnid) {
        $this->db->where($columnname, $columnid);
        if ($this->db->delete($tablename)) {
            return true;
        } else {
            return false;
        }
    }

    // check unique avaliblity
    function check_unique_avalibility($tablename, $columname1, $columnid1_value, $columname2, $columnid2_value, $condition_array = array()) {
        // if edit than $columnid2_value use

        if ($columnid2_value != '') {
            $this->db->where($columname2 . " !=", $columnid2_value);//in this line make space between " and !=
        }

        if (!empty($condition_array)) {
            $this->db->where($condition_array);
        }

        $this->db->where($columname1, $columnid1_value);
        $query = $this->db->get($tablename);
        if ($query->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    //get all record 
    function get_all_record($tablename, $data = '*', $sortby = '', $orderby = '') {
        $this->db->select($data);
        $this->db->from($tablename);
        $this->db->where('status', 'Enable');
        if ($sortby != '' && $orderby != "") {
            $this->db->order_by($sortby, $orderby);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    //table records count
    function get_count_of_table($table) {
        $query = $this->db->count_all($table);
        return $query;
    }

    //Function for getting all Settings
    function get_all_setting($sortby = 'settingid', $orderby = 'ASC') {
        //Ordering Data
        $this->db->order_by($sortby, $orderby);

        //Executing Query
        $query = $this->db->get('setting');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    //Getting setting value for editing By id
    function get_setting_byid($intid) {
        $query = $this->db->get_where('setting', array('settingid' => $intid));

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    //Getting setting value By id
    function get_setting_value($id) {
        $query = $this->db->get_where('setting', array('settingid' => $id,));
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return nl2br(($result[0]['settingfieldvalue']));
        } else {
            return false;
        }
    }

    //Getting setting field name By id
    function get_setting_fieldname($intid) {
        $query = $this->db->get_where('setting', array('settingid' => $intid));

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return ($result[0]['settingfieldname']);
        } else {
            return false;
        }
    }
    
    function get_data_csv($tablename='') {
        $query = $this->db->get($tablename);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    function insert_csv($tablename,$data) {
        $this->db->insert($tablename, $data);
    }
    function select_data_in($tablename, $in_field,$array1, $data = '*') {
        $this->db->select($data);
        $this->db->where_in($in_field,$array1);
        $query = $this->db->get($tablename);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }
    
    function twoDto1D($tarr){
        $oned_arr=array();
        foreach($tarr as $arr){
           foreach($arr as $value1){
            array_push($oned_arr, $value1);
           }
        }
       
        if(!empty($oned_arr)){
            return $oned_arr;
        }else{
            return array();
        }
    }
    
    function candidate_all_data()
    {
        $this->db->select('*');
        $this->db->from('candidate c');
        $this->db->join('candidate_detail cd', 'c.candidate_id = cd.candidate_id','left');
        $this->db->join('candidate_qualification cq', 'c.candidate_id = cq.candidate_id','left');
        $this->db->join('candidate_speciality csp', 'c.candidate_id = csp.candidate_id','left');
        $this->db->join('candidate_subscription csu', 'c.candidate_id = csu.candidate_id','left');
        $this->db->join('candidate_work cw', 'c.candidate_id = cw.candidate_id','left');
        $this->db->group_by('c.candidate_id');
        $query = $this->db->get();
        echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }
    
     function create_unique_url($string,$table,$field,$key=NULL,$value=NULL)
    {
        $t =& get_instance();
        $slug = url_title($string);
        $slug = strtolower($slug);
        $i = 0;
        $params = array ();
        $params[$field] = $slug;

        if($key)$params["$key !="] = $value;

        while ($t->db->where($params)->get($table)->num_rows())
        {  
            if (!preg_match ('/-{1}[0-9]+$/', $slug ))
                $slug .= '-' . ++$i;
            else
                $slug = preg_replace ('/[0-9]+$/', ++$i, $slug );

            $params [$field] = $slug;
        }  
        return $slug;  
    }


    function make_links($text, $class='content_link', $target='_blank'){ 
         return preg_replace('!((http\:\/\/|ftp\:\/\/|https\:\/\/)|www\.)([-a-zA-Z?-??-?0-9\~\!\@\#\$\%\^\&\*\(\)_\-\=\+\\\/\?\.\:\;\'\,]*)?!ism','<a href="//$3" class="' . $class . '" target="'.$target.'">$1$3</a>', 
             $text);
     }
    
}
