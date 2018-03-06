<?php

class Logins extends CI_Model {

    function check_login($user_name, $user_password) {

        $this->db->select("user_id,email,password,status");
        $this->db->where("email", $user_name);
      //  $this->db->where("password", md5($user_password));
        $this->db->where('is_delete', '0');
        $this->db->from("user_login");
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $result = $query->row_array();
            return $result;
        } else {
            return array();
        }
    }

    function artistic_check_login($user_name, $user_password) {
        $this->db->select("user_id,email,password,status");
        $this->db->where("email", $user_name);
        $this->db->where("password", md5($user_password));
        $this->db->where('is_delete', '0');
        $this->db->from("user_login");
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $result = $query->row_array();
            return $result;
        } else {
            return array();
        }
    }

  function getLoginData($email_login = '') {
        $this->db->select("u.user_id,u.first_name,u.last_name,u.user_dob,u.user_gender,u.user_agree,u.created_date,u.verify_date,u.user_verify,u.user_slider,u.user_slug,ui.user_image,ui.modify_date,ui.edit_ip,ui.profile_background,ui.profile_background_main,ul.email,ul.password,ul.is_delete,ul.status,ul.password_code")->from("user u");
        $this->db->join('user_info ui', 'ui.user_id = u.user_id','left');
        $this->db->join('user_login ul', 'ul.user_id = u.user_id','left');
        $this->db->where(array('ul.email' => $email_login,'ul.is_delete' => '0'));
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

}
