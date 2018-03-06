<?php

class Settings extends CI_Model {

    //get all settings details
    function getSettingDetails() {
        $this->db->select('setting_id,setting_name,setting_value');
        $this->db->where('setting_id !=', '8');
        return $this->db->get('settings')->result_array();
    }

    //get admin setting by id
    function getSettingById($setting_id) {
        $this->db->select('setting_id,setting_name,setting_value');
        $this->db->where('setting_id', $setting_id);
        return $this->db->get('settings')->result_array();
    }

    //update setting value
    function update_setting($setting_id, $setting_val) {
        $this->db->where('setting_id', $setting_id);
        if ($this->db->update('settings', $setting_val)) {
            return 1;
        } else {
            return 0;
        }
    }

    function getSemDetails() {
        $this->db->select('semid,semfieldname,semfieldvalue');
        return $this->db->get('sem')->result_array();
    }

    //get admin setting by id
    function getSemById($semid) {
        $this->db->select('semid,semfieldname,semfieldvalue');
        $this->db->where('semid', $semid);
        return $this->db->get('sem')->result_array();
    }

    //update setting value
    function update_sem($semid, $semfieldvalue) {
        $this->db->where('semid', $semid);
        if ($this->db->update('sem', $semfieldvalue)) {
            return 1;
        } else {
            return 0;
        }
    }

    function getSeoDetails() {
        $this->db->select('seoid,seofieldname,seofieldvalue');
        return $this->db->get('seo')->result_array();
    }

    //get admin setting by id
    function getSeoById($seoid) {
        $this->db->select('seoid,seofieldname,seofieldvalue');
        $this->db->where('seoid', $seoid);
        return $this->db->get('seo')->result_array();
    }

    //update setting value
    function update_seo($seoid, $seofieldvalue) {
        $this->db->where('seoid', $seoid);
        if ($this->db->update('seo', $seofieldvalue)) {
            return 1;
        } else {
            return 0;
        }
    }

   /* function getactivity_logs($log_by = '') {
        $this->db->select('activity_logs1.*,admin.admin_name');
        $this->db->from('activity_logs');
        $this->db->join('admin', 'activity_logs.log_by = admin.admin_id');
        $this->db->where('log_by IN (1,2,3)');
        $query = $this->db->get();

        return $query;
    } */

}
