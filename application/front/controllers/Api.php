<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //AWS access info start
        $this->load->library('S3');
        //AWS access info end
        $this->load->model('Chat_model');
        $this->load->model('common');
    }

    public function send_message($id = '', $message_from_profile = '', $message_from_profile_id = '', $message_to_profile = '', $message_to_profile_id = '') {
        $directions = json_decode($_POST['json'], true);

        $userid = $this->session->userdata('aileenuser');

       $message = $directions['message']; 
        //$this->input->post('message', null);
        //$message = $this->common->make_links($message);
        $message = str_replace('"', '', $message);
        //$message = str_replace('"', '', $message);
       // $nickname = $directions['nickname'];
        //$nickname = $this->input->post('nickname', '');
        $guid = $directions['guid'];
        //$guid = $this->input->post('guid', '');
        $id = $directions['toid'];
        //$id = $this->input->post('toid');
        $message_from_profile = $directions['message_from_profile'];
        //$message_from_profile = $this->input->post('message_from_profile');
        $message_to_profile = $directions['message_to_profile'];
        //$message_to_profile = $this->input->post('message_to_profile');
        $message_to_profile_id = $directions['message_to_profile_id'];
        //$message_to_profile_id = $this->input->post('message_to_profile_id');
        $message_from_profile_id = $directions['message_from_profile_id'];
        //$message_from_profile_id = $this->input->post('message_from_profile_id');

//        $this->Chat_model->add_message($message, $nickname, $guid, $userid, $id, $message_from_profile, $message_from_profile_id, $message_to_profile, $message_to_profile_id);
      
        $this->Chat_model->add_message($message,$userid, $id, $message_from_profile, $message_from_profile_id, $message_to_profile, $message_to_profile_id);
        $this->_setOutput($message);
    }

    public function get_messages($id = '', $message_from_profile = '', $message_to_profile = '', $message_from_profile_id = '', $message_to_profile_id = '') {
        $userid = $this->session->userdata('aileenuser');

        $timestamp = $this->input->get('timestamp', null);

        $messages = $this->Chat_model->get_messages($timestamp, $userid, $id, $message_from_profile, $message_to_profile, $message_from_profile_id, $message_to_profile_id);
        $i = 0;
        foreach ($messages as $mes) {
            
            $message = preg_replace( '[^(<br( \/)?>)*|(<br( \/)?>)*$]', '', $mes['message']);
            if (preg_match('/<img/', $message)) {
                $messages[$i]['message'] = str_replace("\\", "",$message);
            } else {
                $messages_new = $this->common->make_links($message);
                $messages[$i]['message'] = nl2br(htmlspecialchars_decode(htmlentities($messages_new, ENT_QUOTES, 'UTF-8')));
            }
            $i++;
        }

        $this->_setOutput($messages);
    }

    public function delete_messages($message_from_profile = '', $message_to_profile = '', $message_for = '', $message_id = '') {
        $userid = $this->session->userdata('aileenuser');
        $timestamp = $this->input->get('timestamp', null);

        if ($message_from_profile == $message_for) {
            $data = array('is_message_from_delete' => $userid);
        } else {
            $data = array('is_message_to_delete' => $userid);
        }

        $update_data = $this->common->update_data($data, 'messages', 'id', $message_id);
    }

    public function delete_history() {

        $userid = $this->session->userdata('aileenuser');
        $timestamp = $this->input->post('timestamp');
        $id = $this->input->post('id');
        $message_from_profile = $this->input->post('message_from_profile');
        $message_to_profile = $this->input->post('message_to_profile');
        $message_from_profile_id = $this->input->post('message_from_profile_id');
        $message_to_profile_id = $this->input->post('message_to_profile_id');

        //$this->db->where('timestamp >', $timestamp);
        $where = '((message_from="' . $userid . '" AND message_to ="' . $id . '") OR (message_to="' . $userid . '" AND message_from ="' . $id . '")) AND ((message_from_profile = "' . $message_from_profile . '" AND message_to_profile ="' . $message_to_profile . '" ) OR (message_from_profile = "' . $message_to_profile . '" AND message_to_profile ="' . $message_from_profile . '" )) AND ((message_from_profile_id="' . $message_from_profile_id . '"AND message_to_profile_id ="' . $message_to_profile_id . '") OR (message_to_profile_id="' . $message_from_profile_id . '" AND message_from_profile_id ="' . $message_to_profile_id . '"))';
        $where .= 'AND is_message_from_delete !="' . $userid . '" AND is_message_to_delete !="' . $userid . '"';
        $this->db->where($where);
        $this->db->order_by('timestamp', 'DESC');
        $query = $this->db->get('messages');
        //echo $this->db->last_query();

        $mes_data = array_reverse($query->result_array());

        foreach ($mes_data as $data) {
            if ($message_from_profile == $data['message_from_profile']) {
                $update_data = array('is_message_from_delete' => $userid);
            } else {
                $update_data = array('is_message_to_delete' => $userid);
            }
            $update_data1 = $this->common->update_data($update_data, 'messages', 'id', $data['id']);
        }

        $messages = $this->Chat_model->last_messages($timestamp, $userid, $id, $message_from_profile, $message_to_profile, $message_from_profile_id, $message_to_profile_id);


        if (preg_match('/<img/', $messages[0]['message'])) {
            $messages = str_replace("\\", "", $messages[0]['message']);
        } else {
            $messages_new = $this->common->make_links($messages[0]['message']);
            $messages = nl2br(htmlspecialchars_decode(htmlentities($messages_new, ENT_QUOTES, 'UTF-8')));
        }



        if ($update_data1) {
            echo json_encode(
                    array(
                        "history" => 1,
                        "message" => $messages
            ));
        } else {
            echo json_encode(
                    array(
                        "history" => 2,
                        "message" => $messages,
            ));
        }
    }

    public function last_messages($id = '', $message_from_profile = '', $message_to_profile = '', $message_from_profile_id = '', $message_to_profile_id = '') {
        $userid = $this->session->userdata('aileenuser');
        $timestamp = $this->input->post('timestamp');
        $id = $this->input->post('id');
        $message_from_profile = $this->input->post('message_from_profile');
        $message_to_profile = $this->input->post('message_to_profile');
        $message_from_profile_id = $this->input->post('message_from_profile_id');
        $message_to_profile_id = $this->input->post('message_to_profile_id');

        $messages = $this->Chat_model->last_messages($timestamp, $userid, $id, $message_from_profile, $message_to_profile, $message_from_profile_id, $message_to_profile_id);

        echo '<pre>';
        print_r($messages);
        die();
        if (preg_match('/<img/', $messages[0]['message'])) {
            $messages = str_replace("\\", "", $messages[0]['message']);
        } else {
            $messages_new = $this->common->make_links($messages[0]['message']);
            $messages = nl2br(htmlspecialchars_decode(htmlentities($messages_new, ENT_QUOTES, 'UTF-8')));
        }


        echo $messages;
    }

    public function get_click_messages($id = '', $message_from_profile = '', $message_to_profile = '', $message_from_profile_id = '', $message_to_profile_id = '') {
        $userid = $this->session->userdata('aileenuser');
        $timestamp = $this->input->get('timestamp', null);
        $messages = $this->Chat_model->get_messages1($timestamp, $userid, $id, $message_from_profile, $message_to_profile, $message_from_profile_id, $message_to_profile_id);
   
        $i = 0;
        foreach ($messages as $mes) {
            if (preg_match('/<img/', $mes['message'])) {
                $messages[$i]['message'] = str_replace("\\", "", $mes['message']);
            } else {
                $messages_new = $this->common->make_links($mes['message']);
                $messages[$i]['message'] = nl2br(htmlspecialchars_decode(htmlentities($messages_new, ENT_QUOTES, 'UTF-8')));
            }
            $i++;
        }

        $this->_setOutput($messages);
    }

    private function _setOutput($data) {
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');

        echo json_encode($data);
    }

}
