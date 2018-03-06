<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_model extends CI_Model {


    function add_message($message, $userid, $id, $message_from_profile, $message_from_profile_id, $message_to_profile, $message_to_profile_id) {

        date_default_timezone_set('Asia/Kolkata');
        $data1 = array(
            'message' => (string) $message,
          //  'nickname' => (string) $nickname,
            'message_from' => (string) $userid,
            'message_to' => (string) $id,
            'message_from_profile' => (int) $message_from_profile,
            'message_from_profile_id' => (int) $message_from_profile_id,
            'message_to_profile' => (int) $message_to_profile,
            'message_to_profile_id' => (int) $message_to_profile_id,
           // 'guid' => (string) $guid,
            'timestamp' => time() + 92,
        );

        $this->db->insert('messages', $data1);
        $msg_insert_id = $this->db->insert_id();

        if ($message_from_profile == 1) {
            $not_from = 2;
        } elseif ($message_from_profile == 2) {
            $not_from = 1;
        } elseif ($message_from_profile == 3) {
            $not_from = 5;
        } elseif ($message_from_profile == 4) {
            $not_from = 4;
        } elseif ($message_from_profile == 5) {
            $not_from = 6;
        } else {
            $not_from = 3;
        }
 if($this->uri->segment(3) == $id){
     $not_active = 1;
 }else{
     $not_active = 1;
 } //echo "hiii"; die();
        $data2 = array(
            'not_type' => '2',
            'not_from_id' => $userid,
            'not_to_id' => $id,
            'not_read' => '2',
            'not_img' => '0',
            'not_active' => $not_active,
            'not_from' => $not_from,
            'not_product_id' => $msg_insert_id,
            'not_created_date' => date('Y-m-d H:i:s'),
        );

        $this->db->insert('notification', $data2);
    }

    function get_messages($timestamp, $userid, $id, $message_from_profile, $message_to_profile, $message_from_profile_id, $message_to_profile_id) {
        // khyati start 
         $this->db->select("messages.*,user.first_name,user.last_name")->from("messages");
         $this->db->join('user', 'user.user_id = messages.message_from', 'left');
        $this->db->where('timestamp >', $timestamp);
        $where = '((message_from="' . $userid . '" AND message_to ="' . $id . '") OR (message_to="' . $userid . '" AND message_from ="' . $id . '")) AND ((message_from_profile = "' . $message_from_profile . '" AND message_to_profile ="' . $message_to_profile . '" ) OR (message_from_profile = "' . $message_to_profile . '" AND message_to_profile ="' . $message_from_profile . '" )) AND ((message_from_profile_id="' . $message_from_profile_id . '"AND message_to_profile_id ="' . $message_to_profile_id . '") OR (message_to_profile_id="' . $message_from_profile_id . '" AND message_from_profile_id ="' . $message_to_profile_id . '"))';
        $where .= 'AND is_message_from_delete !="' . $userid . '" AND is_message_to_delete !="' . $userid . '"';
        $this->db->where($where);

        // khyati end
        //$this->db->where('message_from', $userid);
        //$this->db->where('message_to', $id);
        $this->db->order_by('timestamp', 'DESC');
        //	$this->db->limit(10); 
        $query = $this->db->get();
        
        return array_reverse($query->result_array());
    }
    
    function last_messages($timestamp, $userid, $id, $message_from_profile, $message_to_profile, $message_from_profile_id, $message_to_profile_id) {
        // khyati start 
        
        //$this->db->where('timestamp >', $timestamp);
        $where = '((message_from="' . $userid . '" AND message_to ="' . $id . '") OR (message_to="' . $userid . '" AND message_from ="' . $id . '")) AND ((message_from_profile = "' . $message_from_profile . '" AND message_to_profile ="' . $message_to_profile . '" ) OR (message_from_profile = "' . $message_to_profile . '" AND message_to_profile ="' . $message_from_profile . '" )) AND ((message_from_profile_id="' . $message_from_profile_id . '"AND message_to_profile_id ="' . $message_to_profile_id . '") OR (message_to_profile_id="' . $message_from_profile_id . '" AND message_from_profile_id ="' . $message_to_profile_id . '"))';
        $where .= 'AND is_message_from_delete !="' . $userid . '" AND is_message_to_delete !="' . $userid . '"';
        $this->db->where($where);

        // khyati end
        //$this->db->where('message_from', $userid);
        //$this->db->where('message_to', $id);
        $this->db->order_by('timestamp', 'DESC');
        	$this->db->limit(1); 
        $query = $this->db->get('messages');
      //  echo $this->db->last_query();
        //die();
        return array_reverse($query->result_array());
    }

}
