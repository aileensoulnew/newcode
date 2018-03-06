<?php

class Logins extends CI_Model {

    function check_authentication($admin_email, $admin_password) {
        $this->db->select('*');
        $this->db->where(array('admin_email' => $admin_email, 'admin_password' => md5($admin_password)));
        $result = $this->db->get('admin')->result_array();

        if (!empty($result)) {
            if ($result[0]['admin_email'] == $admin_email && $result[0]['admin_password'] == md5($admin_password)) {
                return $result;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

}
