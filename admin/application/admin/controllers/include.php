<?php
//$adminid =  $this->session->userdata('admin_id');

$adminid =  $this->session->userdata('aileen_admin');

$user_data = $this->common->select_data_by_id('admin', 'admin_id', $this->data['user_id'], $data = '*', $join_str = array());

$this->data['admin_id'] = $this->data['user_id'];
$this->data['admin_username'] = $user_data[0]['admin_username'];
$this->data['admin_email'] = $user_data[0]['admin_email'];
$this->data['admin_name'] = $user_data[0]['admin_name'];
$this->data['admin_image'] = $user_data[0]['admin_image'];

// // for request notification

// $contition_array = array('notification.not_type' => 1, 'notification.not_to' => 1, 'notification.not_to_id' => $this->data['admin_id'], 'notification.not_read' => 2);
// $join_str = array(array(
//         'join_type' => '',
//         'table' => 'relation',
//         'join_table_id' => 'notification.not_product_id',
//         'from_table_id' => 'relation.relation_id')
// );
// $data = array('notification.*', 'relation.*');
// $req_not = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str);


// //$req_not = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str);
// //
// //echo '<pre>';
// //print_r($req_not);
// //exit;


// // for message notification

// $contition_array = array('notification.not_type' => 3, 'notification.not_to' => '1', 'notification.not_to_id' => $this->data['admin_id'], 'notification.not_read' => 2, 'notification.not_from' => 1);
// $join_str = array(array(
//         'join_type' => '',
//         'table' => 'message',
//         'join_table_id' => 'notification.not_product_id',
//         'from_table_id' => 'message.message_id'),
//     array(
//         'join_type' => '',
//         'table' => 'admin',
//         'join_table_id' => 'notification.not_from_id',
//         'from_table_id' => 'admin.admin_id')
// );
// $data = array('notification.*',' message.*',' admin.admin_id as user_id', 'admin.admin_name as user_name', 'admin.admin_image as user_image');
// $admin_message = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str);


// $contition_array = array('notification.not_type' => 3, 'notification.not_to' => '1', 'notification.not_to_id' => $this->data['admin_id'], 'notification.not_read' => 2, 'notification.not_from' => 2);
// $join_str = array(array(
//         'join_type' => '',
//         'table' => 'message',
//         'join_table_id' => 'notification.not_product_id',
//         'from_table_id' => 'message.message_id'),
//     array(
//         'join_type' => '',
//         'table' => 'company',
//         'join_table_id' => 'notification.not_from_id',
//         'from_table_id' => 'company.company_id')
// );
// $data = array('notification.*',' message.*',' company.company_id as user_id', 'company.company_name as user_name', 'company.company_image as user_image');
// $company_message = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str);



// $contition_array = array('notification.not_type' => 3, 'notification.not_to' => '1', 'notification.not_to_id' => $this->data['admin_id'], 'notification.not_read' => 2, 'notification.not_from' => 3);
// $join_str = array(array(
//         'join_type' => '',
//         'table' => 'message',
//         'join_table_id' => 'notification.not_product_id',
//         'from_table_id' => 'message.message_id'),
//     array(
//         'join_type' => '',
//         'table' => 'client',
//         'join_table_id' => 'notification.not_from_id',
//         'from_table_id' => 'client.client_id')
// );


// $data = array('notification.*',' message.*',' client.client_id as user_id', 'client.client_name as user_name', 'client.client_image as user_image');
// $client_message = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str);

// $this->data['message_notification'] = $message_notification = array_merge($admin_message,$company_message,$client_message);
// $this->data['message_notification_count'] = $message_notification_count = count($message_notification);

//echo '<pre>';
//print_r($message_notification);
//exit;

// for message notification
   
  

  		$this->data['header'] = $this->load->view('header', $this->data);
        $this->data['leftmenu'] = $this->load->view('leftmenu', $this->data);
        $this->data['footer'] = $this->load->view('footer', $this->data,true);


        $this->load->model('common');

?>
