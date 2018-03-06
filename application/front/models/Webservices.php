<?php

Class Webservices extends CI_Model {

//login user
    function check_login($useremail, $userpassword) {
        $this->db->select("user_id,name,email,phone,dob,status,image");
        $this->db->where("email", "$useremail");
        $this->db->where("password", "$userpassword");
       // $this->db->where("status", "1");
        $this->db->from("users");
        $this->db->limit(1);

        $query = $this->db->get();
//echo $this->db->last_query();die();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return array();
        }
    }

// check email id
    function chkemail($id, $email) {
        if ($id != 0) {
            $option = array('user_id !=' => $id, 'email' => $email);
        } else {
            $option = array('email' => $email);
        }
         $this->db->select('user_id,name,email,phone,dob,status');
        $query = $this->db->get_where('users', $option);
        if ($query->num_rows() > 0) {
           return $query->result_array();
        } else {
            return 'new';
        }
    }

//This function get all records from table by name
    function getallrecordbytablename($tablename, $data, $conditionarray = '', $limit = '', $offset = '', $sortby = '', $orderby = '') {

//$this->db->order_by($sortby, $orderby);
//Setting Limit for Paging
        if ($limit != '' && $offset == 0) {
            $this->db->limit($limit);
        } else if ($limit != '' && $offset != 0) {
            $this->db->limit($limit, $offset);
        }

//Executing Query
        $this->db->select($data);
        $this->db->from($tablename);
        if ($conditionarray != '') {
            $this->db->where($conditionarray);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }
    
//This function get all open record count
    
    function get_open_request_count($condition)
    {
        $this->db->select('COUNT(requestid) as count,maincategoryuniqid');
        $this->db->where($condition);
        $this->db->from('request');
        $this->db->group_by('maincategoryuniqid');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

// insert database
    function insert_data($data, $tablename) {
        if ($this->db->insert($tablename, $data)) {
            return true;
        } else {
            return false;
        }
    }

// insert database return id
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
    function select_database_id($tablename, $columnname, $columnid, $data = '*', $condition_array = array()) {
        $this->db->select($data);
        $this->db->where($columnname, $columnid);
        if (!empty($condition_array)) {
            $this->db->where($condition_array);
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

// change status
    function change_status($data, $tablename, $columnname, $columnid) {
        $this->db->where($columnname, $columnid);
        if ($this->db->update($tablename, $data)) {
            return true;
        } else {
            return false;
        }
    }

//get all record 
    function get_all_record($tablename, $data = '*', $sortby = '', $orderby = '') {
        $this->db->select($data);
        $this->db->from($tablename);
//$this->db->where('status','Enable');
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

    
    // select data using multiple conditions
    function select_data_by_condition($tablename, $contition_array = array(), $data = '*', $join_str = array()) {

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

        $this->db->where($contition_array);
        
        $query = $this->db->get($tablename);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
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
    function select_data_by_upcoming($tablename, $contition_array = array(), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array()) {
        
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
    
    
    
     function select_data_by_message($tablename, $search_condition, $contition_array = array(), $data = '*',$group_by = '', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str=array()) {
        $this->db->select($data);        
        if (!empty($join_str)) {
            foreach ($join_str as $join) {                
                $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
            }
        }
       
         $this->db->group_by($group_by); 
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
// update database
    function update_cancel_data($data, $tablename, $columnname1, $columnid1,$columnname2,$columnid2) {
        $this->db->where($columnname1, $columnid1);
          $this->db->where($columnname2, $columnid2);
        if ($this->db->update($tablename, $data)) {
            return true;
        } else {
            return false;
        }
    }
    
     function update_data_by_condition($tablename, $contition_array = array(), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '') {
        
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

        $this->db->group_by($groupby);
        $query = $this->db->get($tablename);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

}
