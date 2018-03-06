<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Advertise_with_us extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //AWS access info start
        $this->load->library('S3');
        //AWS access info end
        $this->load->library('form_validation');
        $this->load->model('email_model');

        include ('include.php');
    }

    public function index() {
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->load->view('advertise_with_us/index', $this->data);
    }

    public function advertise_insert() {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        $toemail = "dshah1341@gmail.com";
        //$toemail = "ankit.aileensoul@gmail.com";
        $touser = $_POST['email'];
        $data = array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'message' => $message,
            'created_date' => date('Y-m-d H:i:s', time()),
            'status' => '1'
        );
        $insert_id = $this->common->insert_data_getid($data, 'advertise_with_us');
        if ($insert_id) {
            
            $subject = 'Advertise enquiry in Aileensoul.com';
            
            // email send to admin
            $email_html = '';
            $email_html .= '<table  width="100%" cellpadding="0" cellspacing="0" style="font-family:arial;font-size:13px;">
                    <tr><td style="padding-left:20px;">Hi admin!<br><br>
                         <p style="padding-left:70px;"> You have recevied a new advertise enquiry  from user  while you were away..</p><br></td></tr>';
            $email_html .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
            $email_html .= 'The user detail follows:';
            $email_html .= '</td></tr>';
            $email_html .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
            $email_html .= '<b>Name</b> :' . $firstname . ' ' . $lastname;
            $email_html .= '<br></td></tr>';
            $email_html .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
            $email_html .= '<b>Email-Address</b> : ' . $feedback_email;
            $email_html .= '</td></tr>';
            $email_html .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
            $email_html .= '<b>Message</b> : ' . $message;
            $email_html .= '</td></tr>';

            $email_html .= '</tr></table>';

            $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $toemail);

            // email send to user

//
//            $email_user = '';
//            $email_user .= '<table  width="100%" cellpadding="0" cellspacing="0" style="font-family:arial;font-size:13px;">
//                    <tr><td style="padding-left:20px;">Thank you. Your Feedback is important for us.!!<br><br>
//                         <p style="padding-left:0px; padding-bottom: 20px;"> Your Message has been  received and will be reviewed by the aileensoul team. We appreciate your assistance in making the aileensoul better.</p><br></td></tr>';
//            $email_user .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
//            $email_user .= 'Thanks & regards,';
//            $email_user .= '<br></td></tr>';
//            $email_user .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
//            $email_user .= 'Aileensoul team.';
//            $email_user .= '</td></tr>';
//            $email_user .= '</table>';
//
//            $send_user = $this->email_model->send_email($subject = $subject, $templ = $email_user, $to_email = $touser);

            echo 'ok';
        }
    }

}
