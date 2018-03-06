<?php

Class Sitefunction extends CI_Model
{

    public function Method($method, $url)
    {
        if ($this->input->server('REQUEST_METHOD') != strtoupper($method)) {
            return redirect(base_url() . $url);
        } else {
            return true;
        }
    }

    public function AjaxMethod($method)
    {
        if ($this->input->server('REQUEST_METHOD') != strtoupper($method)) {
            return false;
        } else {
            return true;
        }
    }

    /* User Start Session */
    public function Is_Shop_Logged_In()
    {
        $current = $this->session->userdata('is_shop_logged_in');
        if (empty($current) && $current == "") {
            redirect('/shop/login', 'refresh');
        }
    }

    public function Not_Shop_Logged_In()
    {
        $current = $this->session->userdata('is_shop_logged_in');
        if (isset($current) && $current != "") {
            redirect('/', 'refresh');
        }
    }

    /* User End Session */
    public function CheckAlredyDb($table, $fieldname, $value)
    {
        $this->db->where($fieldname, $value);
        $res = $this->db->get($table)->num_rows();
        return $res;
    }

    public function getIdWiseData($table, $fieldname, $id,$select = '*')
    {
        $this->db->select($select);
        $this->db->where($fieldname, $id);
        $res = $this->db->get($table)->row();
        return $res;
    }

    public function insert_data($data, $tablename)
    {
        if ($this->db->insert($tablename, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    // update database
    public function update_data($data, $tablename, $contition_array = array())
    {
        if (count($contition_array) != 0) {
            $this->db->where($contition_array);
        }
        if ($this->db->update($tablename, $data)) {
            //echo $this->db->last_query();die();
            return true;
        } else {
            return false;
        }
    }

    public function delete_data($tablename, $columnname, $columnid)
    {
        $this->db->where($columnname, $columnid);
        if ($this->db->delete($tablename)) {
            return true;
        } else {
            return false;
        }
    }

    public function SelectResults($table,$select = '*')
    {
        $this->db->select($select);
        $res = $this->db->get($table)->result();
        return $res;
    }

    public function getIdWiseDataResults($table, $fieldname, $id,$select = '*')
    {
        $this->db->select($select);
        $this->db->where($fieldname, $id);
        $res = $this->db->get($table)->result();
        return $res;
    }

    public function getMultiSelectWhere($data,$table,$select='*'){
        $this->db->select($select);
        if(count($data) > 0 && $data != "" && isset($data)){
            foreach ($data as $k => $v){
                $this->db->where($k,$v);
            }
        }
        return $this->db->get($table)->row();
    }

    public function getMultiSelectWhereNumRow($data,$table,$select='*'){
        $this->db->select($select);
        if(count($data) > 0 && $data != "" && isset($data)){
            foreach ($data as $k => $v){
                $this->db->where($k,$v);
            }
        }
        return $this->db->get($table)->num_rows();
    }

    public function SetPermission(){

        $check_db = "delete";
        $login_user_id = "2";
        $module_name = "1";

        $get_userinfo = $this->getIdWiseData('shop', 'shop_id', $login_user_id);
        $user_role = $get_userinfo->shop_role;

        $shop_permission = $this->getIdWiseData('shop_permission', 'shop_role_id', $user_role);

        $permission = $shop_permission->permission;

        $explode_permission = explode(',',$permission);

        if(count($explode_permission) > 0){
            if(in_array($check_db,$explode_permission)){
                echo "yes";
            }else{
                echo "no";
            }
        }else{
            echo "no";
        }
        die();
    }
}

?>