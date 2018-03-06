<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contact_us extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //AWS access info start
        $this->load->library('S3');
        $this->load->library('form_validation');
        $this->load->model('email_model');
        //AWS access info end
        include ('include.php');
    }

    public function index() {
        
        $this->data['title'] = 'Contact Us - Aileensoul';
        $contition_array = array('site_id' => '1');
        $this->data['cnt'] = $this->common->select_data_by_condition('site_settings', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->data['login_header'] = $this->load->view('login_header', $this->data,TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data,TRUE);
        $this->load->view('contact/contact_us', $this->data);
    }

     public function contact_us_insert() {

        $name = $_POST['contact_name'];
        $contactlast_name = $_POST['contactlast_name'];
        $email = $_POST['contact_email'];
        $subject = $_POST['contact_subject'];
        $message = $_POST['contact_message'];

        $toemail = "dshah1341@gmail.com";
        $touser =  $_POST['contact_email']; 

        $this->form_validation->set_rules('contact_name', 'contact name', 'required');
        $this->form_validation->set_rules('contactlast_name', 'contact name', 'required');

        $this->form_validation->set_rules('contact_email', 'contact email', 'required|valid_email');
        $this->form_validation->set_rules('contact_subject', 'contact subject', 'required');
        $this->form_validation->set_rules('contact_message', 'contact message', 'required');


        $data = array(
            'contact_name' => $name,
            'contact_lastname' => $contactlast_name,
            'contact_email' => $email,
            'contact_subject' => $subject,
            'contact_message' => $message,
            //'created_date' =>date('Y-m-d h:m:s', time()),
            'created_date' =>date('Y-m-d h:i:s', time()),
            'is_delete' => '0'
        );
        $insert_id = $this->common->insert_data_getid($data, 'contact_us');
        if ($insert_id) {

                    $email_html = '';

                    $email_html .= '<table  width="100%" cellpadding="0" cellspacing="0" style="font-family:arial;font-size:13px;">
                    <tr><td style="padding-left:20px;">Hi admin!<br><br>
                         <p style="padding-left:70px;"> You have recevied a new message  from user  while you were away..</p><br></td></tr>';
                     $email_html .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
                     $email_html .= 'The user message detail follows:';
                     $email_html .= '</td></tr>';
                     $email_html .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
                     $email_html .= '<b>Name</b> :'. $name .' '. $contactlast_name;
                     $email_html .= '<br></td></tr>';
                     $email_html .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
                     $email_html .= '<b>Email-Address</b> : '. $email;
                     $email_html .= '</td></tr>';
                     $email_html .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
                     $email_html .= '<b>Message</b> : '. $message;
                     $email_html .= '</td></tr>';
                     $email_html .= '</tr></table>';

                    $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $toemail);


                    $email_user = '';
                     $email_user .= '<table  width="100%" cellpadding="0" cellspacing="0" style="font-family:arial;font-size:13px;">
                    <tr><td style="padding-left:20px;">Thank you for contacting us.<br><br> <p style="padding-left:0px;"> Your Message has been  received and will be reviewed by the aileensoul team. We appreciate your assistance in making aileensoul better.</p></td></tr>';
                     $email_user .= '<tr><td style="padding-bottom: 5px;padding-left:20px;">';
                     $email_user .= 'Thanks & regards,';
                      $email_user .= '<br></td></tr>';
                       $email_user .= '<tr><td style="padding-bottom: 5px;padding-left:20px;">';
                     $email_user .= 'Aileensoul team.';
                      $email_user .= '</td></tr>';
                     $email_user .= '</table>';

                     $send_user = $this->email_model->send_email($subject = $subject, $templ = $email_user, $to_email = $touser);

            echo "ok";
        }
    }

}
