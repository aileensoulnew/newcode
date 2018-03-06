<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function send_email($subject = '', $templ = '', $to_email = '') {
        $this->load->library('email');

        $email_html = '';
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
		padding:8px 20px;
		text-decoration:none;
                border-radius:3px;
	}
	.btn:hover{/*opacity:0.8;*/}
    .description_table img { width:50px !important; height:50px !important;}
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
			<table width="100%" cellpadding="0" cellspacing="0" class="description_table">
                            <tr><td style="padding:5px;padding-left: 10px;padding-top: 21px;} font-size:15px;">' . $templ . '</td></tr>
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
//        </table>
//        <table width="100%" cellpadding="0" cellspacing="0">
//			<tr><td style="text-align:center; padding:10px 0;"><a style="color:#505050; padding:5px 15px; text-decoration:none;" href="#">Unsubscribe</a>|<a style="color:#505050; padding:5px 15px; text-decoration:none;" href="#">Help</a></td></tr>
//		</table>
//</div></body></html>';


        $config['protocol'] = 'sendmail';
        $config['smtp_host'] = 'smtpout.secureserver.net';
        $config['smtp_user'] = 'noreply@aileensoul.com';
        $config['smtp_pass'] = 'aileensoul@123';
        $config['smtp_port'] = '465';
        $config['smtp_timeout'] = 5;
        $config['smtp_keepalive'] = ''; 
        $config['smtp_crypto'] = '';
        $config['wordwrap'] = '1';
        $config['mailtype'] = 'html';
        $config['charset'] = 'UTF-8';
        $config['newline'] = '\r\n';

        //$this->email->initialize($config);
        $this->email->from('noreply@aileensoul.com', 'Aileensoul');
        $this->email->to($to_email);
        $this->email->bcc('dm.aileensoul@gmail.com');
        $this->email->subject($subject);
        $this->email->message($email_html);
        $this->email->set_mailtype("html");


        if ($this->email->send()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function sendEmail($app_name = '', $app_email = '', $to_email = '', $subject = '', $mail_body = '', $cc = '', $bcc = '') {

//echo "<pre>"; print_r($to_email); die();
        //Loading E-mail Class
        $this->load->library('email');

        $emailsetting = $this->common->select_data_by_condition('email_settings', array(), '*');
        //echo '<pre>';        print_r($emailsetting); die();
        $mail_html = '<!DOCTYPE html>
<html>
<head>
<title>Mail</title>
<style>
    p{margin:0;}
    h3{margin:0;}
    .btn{
        background: -moz-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); 
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #3bb0ac), color-stop(56%, #1b8ab9), color-stop(100%, #1b8ab9));
        background: -webkit-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); 
        background: -o-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); 
        background: -ms-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); 
        background: linear-gradient(354deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); 
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#3bb0ac", endColorstr="#1b8ab9",GradientType=0 );
        font-size:16px;
           color:#fff;
      padding: 7px 12px;
    text-decoration: none;
    font-family: arial;
    letter-spacing: 1px;
    }
    .btn:hover{}
</style>
</head>
<body>
    <div style="max-width:600px; margin:0 auto; background:#f4f4f4; padding:30px;">
        <table width="100%" style="background:#fff" cellpadding="0" cellspacing="0">
            <tr>
                <td style="border-bottom:1px solid #ddd;">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="text-align:center">
                                <h2>
                                    <a style="color:#1b8ab9; text-decoration:none; font-size:23px;" href="https://www.aileensoul.com/">Aileensoul</a>
                                </h2>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td style="border-bottom:1px solid #ddd;">
                    <table width="100%" cellpadding="0" cellspacing="0">';
        $mail_html .= $mail_body;
        $mail_html .= '</table>
                </td>
            </tr>
            <tr>
                <td style="padding:25px 0px;">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="text-align:center; padding:0 10px;" width="20%">
                                <img src="https://www.aileensoul.com/assets/img/m1.png">
                                <h3 style="font-size:13px; font-family:arial;">Job Profile</h3>
                                <p style="font-size:9px;">Find best job options and connect with recruiters.</p>
                            </td>
                            <td style="text-align:center; padding:0 10px;" width="20%">
                                <img src="https://www.aileensoul.com/assets/img/m2.png">
                                <h3 style="font-size:13px; font-family:arial;">Recruiter Profile</h3>
                                <p style="font-size:9px;">Hire quality employees here.</p>
                            </td>
                            <td style="text-align:center; padding:0 10px;" width="20%">
                                <img src="https://www.aileensoul.com/assets/img/m3.png">
                                <h3 style="font-size:13px; font-family:arial; ">Freelance Profile</h3>
                                <p style="font-size:9px;">Hire freelancers and also find freelance work.</p>
                            </td>
                            <td style="text-align:center; padding:0 10px;" width="20%">
                                <img src="https://www.aileensoul.com/assets/img/m4.png">
                                <h3 style="font-size:13px; font-family:arial;">Business Profile</h3>
                                <p style="font-size:9px;">Grow your business network.</p>
                            </td>
                            <td style="text-align:center; padding:0 10px;" width="20%">
                                <img src="https://www.aileensoul.com/assets/img/m5.png">
                                <h3 style="font-size:13px; font-family:arial;">Artistic Profile</h3>
                                <p style="font-size:9px;">Show your art & talent to the world.</p>
                            </td>
                        </tr>
                    
                    </table>
                </td>
            </tr>
        </table>
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td style="text-align:center; padding:10px 0;"> 
                    <a style="color:#505050; padding:5px 15px; text-decoration:none;" href="#">Unsubscribe</a>|
                    <a style="color:#505050; padding:5px 15px; text-decoration:none;" href="#">Help</a></td>
            </tr>
        </table>
    </div>
</body>
</html>';

        //   echo $mail_html; 
        //Loading E-mail Class
//         $config['protocol'] = "smtp";
//         $config['smtp_host'] = $emailsetting[0]['host_name'];
//         $config['smtp_port'] = $emailsetting[0]['out_going_port'];
//         $config['smtp_user'] = $emailsetting[0]['user_name'];
//         $config['smtp_pass'] = $emailsetting[0]['password'];
//         $config['smtp_rec_email'] = $emailsetting[0]['receiver_email'];
//         $config['charset'] = "utf-8";
//         $config['mailtype'] = "html";
//         $config['newline'] = "\r\n";

        $config['protocol'] = "SMTP";
        //$config['smtp_host'] = "email-smtp.us-west-2.amazonaws.com";
        $config['smtp_host'] = "Smtp.gmail.com";
        //$config['smtp_port'] = "465";
        $config['smtp_port'] = "25";
        $config['smtp_user'] = "noreply@aileensoul.com";
        $config['smtp_pass'] = "aileensoul@123";
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";

//         $this->email->initialize($config);
//         $this->email->from($config['smtp_user'], $app_name);
//          $this->email->cc($cc);
//         $this->email->bcc($bcc);
        //    $this->email->cc($cc);
//         $this->email->subject($subject);
//         $this->email->message(html_entity_decode($mail_body));
        //$to = "falguni.aileensoul@gmail.com";
        //$sub = "khytiii";
        //$this->email->from('aileensoul@gmail.com', 'Aileensoul');
        $this->email->from('noreply@aileensoul.com', 'Aileensoul');

        $this->email->to($to_email);
        //$this->email->reply_to('no-replay@aileensoul.com', 'Explendid Videos');
        $this->email->subject($subject);
        $this->email->message($mail_html);
        $this->email->set_mailtype("html");
        $this->email->send();

//echo '<pre>'; print_r($this->email->print_debugger()); die();
        if ($this->email->send()) {
            //echo "111"; die();
            return true;
        } else {  //echo "222"; die();
            return FALSE;
        }
    }

    function do_email($msg = NULL, $sub = NULL, $to = NULL, $from = NULL, $attachment_url = NULL) {
        //echo $msg; echo "<br/>";
        //   echo $sub;  echo "<br/>";
        //   echo $to; echo "<br/>";
        //   echo $from; die();
        $this->load->library('email');
        /* THIS CODE IS COMMENTED */

//        $config['protocol'] = "SMTP";
//        $config['smtp_host'] = "SMTP.gmail.com";
//        $config['smtp_port'] = "465";
//        $config['smtp_user'] = "aileensoftsolution@gmail.com";
//        $config['smtp_pass'] = "xyz123456";
//        $config['charset'] = "utf-8";
//        $config['mailtype'] = "html";
//        $config['newline'] = "\r\n";

        /* THIS CODE IS COMMENTED */

        $config['protocol'] = "SMTP";
        $config['smtp_host'] = "Smtp.gmail.com";
        $config['smtp_port'] = "25";
        $config['smtp_user'] = "noreply@aileensoul.com";
        $config['smtp_pass'] = "aileensoul@123";
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";

        $this->email->initialize($config);

        // $system_name    =   $this->db->get_where('settings' , array('type' => 'system_name'))->row()->description;
        // if ($from == NULL)
        //     $from       =   $this->db->get_where('settings' , array('type' => 'system_email'))->row()->description;
        $system_name = "aileensoul";
        // attachment
        //if ($attachment_url != NULL)
        //  $this->email->attach( $attachment_url );

        $this->email->from('aileensoul@gmail.com', 'Aileensoul');
        $this->email->to($to);
        $this->email->reply_to('no-replay@aileensoul.com', 'Explendid Videos');
        $this->email->subject($sub);
        $this->email->message($msg);
        $this->email->send();

        //echo $this->email->print_debugger(); die();
    }

    function test_email($subject = '', $templ = '', $to_email = '') {
        $this->load->library('email');

        $email_html = 'This is test mail from smtp';

        $config['useragent'] = 'CodeIgniter';
        $config['protocol'] = 'sendmail';
        $config['smtp_host'] = 'smtpout.secureserver.net';
        $config['smtp_user'] = 'noreply@aileensoul.com';
        $config['smtp_pass'] = 'aileensoul@123';
        $config['smtp_port'] = '465';
        $config['smtp_timeout'] = 5;
        $config['smtp_keepalive'] = ''; 
        $config['smtp_crypto'] = '';
        $config['wordwrap'] = '1';
        $config['mailtype'] = 'html';
        $config['charset'] = 'UTF-8';
        $config['newline'] = '\r\n';
        
        $this->email->initialize($config);
        $this->email->from('noreply@aileensoul.com', 'Aileensoul');
        $this->email->to($to_email);
        $this->email->bcc('dm.aileensoul@gmail.com');
        $this->email->subject($subject);
        $this->email->message($email_html);
        $this->email->set_mailtype("html");

        echo '<pre>';
        print_r($this->email);
        exit;
        if ($this->email->send()) {
            return TRUE;
        } else {
            echo '<pre>';
            print_r($this->email->print_debugger());
            return FALSE;
        }
    }

}
