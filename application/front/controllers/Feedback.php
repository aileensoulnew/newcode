<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Feedback extends CI_Controller {

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
        $this->load->view('feedback/feedback', $this->data);
    }

    public function feedback_insert() {
        $feedback_firstname = $_POST['feedback_firstname'];
        $feedback_lastname = $_POST['feedback_lastname'];
        $feedback_email = $_POST['feedback_email'];
        $subject = $_POST['feedback_subject'];
        $message = $_POST['feedback_message'];
        $toemail = "dshah1341@gmail.com";
        $touser =  $_POST['feedback_email'];       

        $data = array(
            'first_name' => $feedback_firstname,
            'last_name' => $feedback_lastname,
            'user_email' => $feedback_email,
            'subject' => $subject,
            'description' => $message,
            'created_date' => date('Y-m-d H:i:s', time()),
            'is_delete' => '0'
        );
        $insert_id = $this->common->insert_data_getid($data, 'feedback');
        if ($insert_id) {

            // email send to admin
                     $email_html = '';
                     $email_html .= '<table  width="100%" cellpadding="0" cellspacing="0" style="font-family:arial;font-size:13px;">
                    <tr><td style="padding-left:20px;">Hi admin!<br><br>
                         <p style="padding-left:70px;"> You have recevied a new feedback  from user  while you were away..</p><br></td></tr>';
                     $email_html .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
                     $email_html .= 'The user feedback detail follows:';
                     $email_html .= '</td></tr>';
                     $email_html .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
                     $email_html .= '<b>Name</b> :'. $feedback_firstname .' '. $feedback_lastname;
                     $email_html .= '<br></td></tr>';
                     $email_html .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
                     $email_html .= '<b>Email-Address</b> : '. $feedback_email;
                     $email_html .= '</td></tr>';
                     $email_html .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
                     $email_html .= '<b>Message</b> : '. $message;
                     $email_html .= '</td></tr>';

                     $email_html .= '</tr></table>';

                     $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $toemail);

            // email send to user


                     $email_user = '';
                     $email_user .= '<table  width="100%" cellpadding="0" cellspacing="0" style="font-family:arial;font-size:13px;">
                    <tr><td style="padding-left:20px;">Thank you. Your Feedback is important for us.!!<br><br>
                         <p style="padding-left:0px; padding-bottom: 20px;"> Your Message has been  received and will be reviewed by the aileensoul team. We appreciate your assistance in making the aileensoul better.</p><br></td></tr>';                    
                     $email_user .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
                     $email_user .= 'Thanks & regards,';
                      $email_user .= '<br></td></tr>';
                       $email_user .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
                     $email_user .= 'Aileensoul team.';
                      $email_user .= '</td></tr>';
                     $email_user .= '</table>';

                     $send_user = $this->email_model->send_email($subject = $subject, $templ = $email_user, $to_email = $touser);

            echo "ok";
        }
    }

    public function test(){



                    $email_html = '';
                    $templ = '';

                    $templ .= '<table  width="100%" cellpadding="0" cellspacing="0" style="font-family:arial;font-size:13px;">
                    <tr><td style="padding-left:20px;">Thank you.. Your Feedback is important for us..!!<br><br>
                         <p style="padding-left:0px;"> Your Message has been  received and will be reviewed by the aileensoul team.</p><br></td></tr>';
                      $templ .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
                     $templ .= 'we appreciate your assistance in making the aileensoul better..';
                      $templ .= '</td></tr>';
                     $templ .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
                     $templ .= 'Thanks & regards,';
                      $templ .= '<br></td></tr>';
                       $templ .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
                     $templ .= 'Aileensoul team.';
                      $templ .= '</td></tr>';
                    
                    $templ .= '</table>';


                    $email_html .= '<!DOCTYPE html><html><head><title>Aileensoul Notification Mail</title>
            <style>
            body{font-family:arial;}
            p{margin:0;}h3{margin:0;}
            .post-img-div, .post-img-profile{color: #fff;
width: 60px;
background: -moz-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #3bb0ac), color-stop(56%, #1b8ab9), color-stop(100%, #1b8ab9));
background: -webkit-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%);
background: -o-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%);
background: -ms-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%);
background: linear-gradient(354deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#3bb0ac", endColorstr="#1b8ab9",GradientType=0 );
padding: 21px 0;
text-align: center;
text-transform: uppercase;
line-height: 1;}
            .btn{
    background: -moz-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); /* ff3.6+ */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #3bb0ac), color-stop(56%, #1b8ab9), color-stop(100%, #1b8ab9)); /* safari4+,chrome */
    background: -webkit-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); /* safari5.1+,chrome10+ */
    background: -o-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); /* opera 11.10+ */
    background: -ms-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); /* ie10+ */
    background: linear-gradient(354deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); /* w3c */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#3bb0ac", endColorstr="#1b8ab9",GradientType=0 ); /* ie6-9 */
    font-size:16px;
    color:#fff;
    padding:10px 25px;
    text-decoration:none;
                border-radius:5px;
  }
  .btn:hover{/*opacity:0.8;*/}
</style></head>
<body>
  <div style="max-width:600px; margin:0 auto; background:#f4f4f4; padding:30px;">
    <table width="100%" style="background:#fff" cellpadding="0" cellspacing="0">
      <tr><td style="border-bottom:1px solid #ddd;">
                        <table width="100%" cellpadding="0" cellspacing="0">
            <tr><td style="text-align:center"><h2>
            <a style="color:#1b8ab9; text-decoration:none; font-size:23px;" href="https://www.aileensoul.com/" target="_blank"><img src="https://www.aileensoul.com/assets/images/favicon.png" style="   vertical-align: middle;" /> <span class="sitename">Aileensoul</span></a>
            </h2></td></tr></table>
      </td></tr>
      <tr><td style="border-bottom:1px solid #ddd;">
      <table width="100%" cellpadding="0" cellspacing="0">
                            <tr><td style="padding:10px 0 30px; font-size:15px;">' . $templ . '</td></tr>
                        </table>
      </td></tr>
      <tr><td style="padding:25px 0px;">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr><td style="text-align:center; vertical-align:top; padding:0 10px;" width="20%"><img src="https://www.aileensoul.com/assets/img/m1.png"><h3 style="font-size:13px;">Job Profile</h3><p style="font-size:11px;">Find best job options and connect with recruiters.</p></td>
        <td style="text-align:center; vertical-align:top; padding:0 10px;" width="20%"><img src="https://www.aileensoul.com/assets/img/m2.png"><h3 style="font-size:13px;">Recruiter Profile</h3><p style="font-size:11px;">Hire quality employees here.</p></td>
        <td style="text-align:center; vertical-align:top; padding:0 10px;" width="20%"><img src="https://www.aileensoul.com/assets/img/m3.png"><h3 style="font-size:13px; ">Freelance Profile</h3><p style="font-size:11px;">Hire freelancers and also find freelance work.</p></td>
                                <td style="text-align:center; vertical-align:top; padding:0 10px;" width="20%"><img src="https://www.aileensoul.com/assets/img/m4.png"><h3 style="font-size:13px;">Business Profile</h3><p style="font-size:11px;">Grow your business network.</p></td>
        <td style="text-align:center; vertical-align:top; padding:0 10px;" width="20%"><img src="https://www.aileensoul.com/assets/img/m5.png"><h3 style="font-size:13px;">Artistic Profile</h3><p style="font-size:11px;">Show your art & talent to the world.</p></td>
                            </tr>
      </table>
      </td></tr>
    </table>
                <table width="100%" cellpadding="0" cellspacing="0">
                <tr><td style="text-align:center; padding:10px 0;"><b>It\'s FREE Platform For Everyone</b></td></tr>
                </table>
  </div></body></html>';

  echo "<pre>"; print_r($email_html); die();

    }

}
