<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('email_model');
        $this->load->model('user_model');
        //AWS access info start
        $this->load->library('S3');
        //AWS access info end
        include('include.php');

        //This function is there only one time users slug created after remove it start
//         $this->db->select('user_id,first_name,last_name');
//         $res = $this->db->get('user')->result();
//         foreach ($res as $k => $v) {
//             $data = array('user_slug' => $this->setuser_slug($v->first_name."-". $v->last_name, 'use_slug', 'user'));
//             $this->db->where('user_id', $v->user_id);
//             $this->db->update('user', $data);
//          }
        //This function is there only one time users slug created after remove it End
    }

    //Show main registratin page insert Start
    public function index() {
     
        $this->load->view('registration/registration', $this->data);
    }

    public function verify($id = " ") {

        $user = $this->common->select_data_by_id('user', 'user_id', $id, '*', '');

        $data = array(
            'user_verify' => '1',
            'modified_date' => date('Y-m-d h:i:s', time())
        );
       
        $updatedata = $this->common->update_data($data, 'user', 'user_id', $id);
        if ($updatedata) {
            $this->session->set_userdata('aileenuser', $id);
            $this->session->set_userdata('aileenuser_slug', $user[0]['user_slug']);
            redirect('profiles/' . $this->session->userdata('aileenuser_slug'), 'refresh');
        }
    }

    public function reg_insert() {
         
        $date = $this->input->post('selday');
        $month = $this->input->post('selmonth');
        $year = $this->input->post('selyear');

        $dob = $year . '-' . $month . '-' . $date;

        if ($this->session->userdata('fbuser')) {
            $this->session->unset_userdata('fbuser');
        }

        //form validation rule for registration

        $ip = $this->input->ip_address();

        $this->form_validation->set_rules('first_name', 'Firstname', 'required');
        $this->form_validation->set_rules('last_name', 'Lastname', 'required');
        $this->form_validation->set_rules('email_reg', 'Store  email', 'required|valid_email');
        $this->form_validation->set_rules('password_reg', 'Password', 'trim|required');
        $this->form_validation->set_rules('selday', 'date', 'required');
        $this->form_validation->set_rules('selmonth', 'month', 'required');
        $this->form_validation->set_rules('selyear', 'year', 'required');
        $this->form_validation->set_rules('selgen', 'Gender', 'required');



        $email_reg = $this->input->post('email_reg');
       
        $userdata = $this->user_model->getUserByEmail($email_reg);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('registration/registration');
        } else {

            if ($userdata) {
                
            } else {

                $user_data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'user_dob' => $dob,
                    'user_gender' => $this->input->post('selgen'),
                    'user_agree' => '1',
                    'created_date' => date('Y-m-d h:i:s', time()),
                    'verify_date' => date('Y-m-d h:i:s', time()),
                    'user_verify' => '0',
                    'user_slider' => '1',
                    'user_slug' => $this->setuser_slug($this->input->post('first_name') . '-' . $this->input->post('last_name'), 'user_slug', 'user'),
                );


                $user_insert = $this->common->insert_data_getid($user_data, 'user');
                if ($user_insert) {
                    $user_login_data = array(
                        'email' => strtolower($this->input->post('email_reg')),
                        'password' => md5($this->input->post('password_reg')),
                        'is_delete' => '0',
                        'status' => '1',
                        'user_id' => $user_insert,
                    );
                    $user_login_insert = $this->common->insert_data_getid($user_login_data, 'user_login');
              
                    $user_info_data = array(
                        'user_id' => $user_insert,
                    );
                    $user_info_insert = $this->common->insert_data_getid($user_info_data, 'user_info');
              
                    
                }
            }
        }
         $is_userBasicInfo = $this->user_model->is_userBasicInfo($user_insert);
        
        $is_userStudentInfo = $this->user_model->is_userStudentInfo($user_insert);
        //for getting last insrert id
        if ($user_insert) { 
            $user_slug = $this->user_model->getUserSlugById($user_insert);
            $this->session->set_userdata('aileenuser', $user_insert);
            $this->session->set_userdata('aileenuser_slug', $user_slug['user_slug']);
            $datavl = "ok";
            echo json_encode(
                    array(
                        "okmsg" => $datavl,
                        "userid" => $user_insert,
                        "is_userBasicInfo"=>$is_userBasicInfo,
                        "is_userStudentInfo"=>$is_userStudentInfo,
                        "userslug" => $user_slug['user_slug'],
            ));
        } else {
            $this->session->flashdata('error', 'Sorry!! Your data not inserted');
            redirect('registration', 'refresh');
        }
    }

    public function sendmail() {

        $user_id = $_POST['userid'];
        if ($user_id) {
            $contition_array = array('user_id' => $user_id);
            $userdata = $this->common->select_data_by_condition('user', $contition_array, $data = 'user_email,first_name,last_name,user_id,user_gender,user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $gender = $userdata[0]['user_gender'];
            $toemail = $userdata[0]['user_email'];
            $fname = $userdata[0]['first_name'];
            $lname = $userdata[0]['last_name'];

            $msg = '<tr>
                             <td style="text-align:center; padding-top:15px;">';
            if ($userdata[0]['user_image']) {
                $msg .= '<img src="' . base_url($this->config->item('user_thumb_upload_path') . $userdata[0]['user_image']) . '">';
            } else {

                if ($gender == 'F') {
                    $msg .= '<img src="' . base_url(FNOIMAGE) . '">';
                } else {
                    $msg .= '<img src="' . base_url(MNOIMAGE) . '">';
                }
            }
            $msg .= '</td>
                              </tr>
                            <tr>
                               <td style="text-align:center; padding:10px 0 30px; font-size:15px;">';
            $msg .= '<p style="margin:0;">Hi,' . ucwords($fname) . ' ' . ucwords($lname) . '</p>
                            <p style="padding:25px 0 ; margin:0;">Verify your email address.</p>
                             <p><a class="btn" href="' . base_url() . 'registration/verify/' . $user_id . '">Verify</a></p>
                              </td>
                              </tr>';
            echo "<pre>";
            print_r($msg);
            die();

            $subject = "Welcome to aileensoul";

            $mail = $this->email_model->sendEmail($app_name = '', $app_email = '', $toemail, $subject, $msg);

            //$mail = $this->email_model->do_email($msg, $subject, $toemail, $from);
        }
    }

    //Show main registratin page insert End
//Registrtaion email already exist checking controller start

    public function check_email() {
        $email_reg = $this->input->post('email_reg');

        $condition_array = array('is_delete' => '0', 'status' => '1');
        $check_result = $this->common->check_unique_avalibility('user_login', 'email', $email_reg, '', '', $condition_array);

        if ($check_result) {
            echo 'true';
            die();
        } else {
            echo 'false';
            die();
        }
    }

   
    
//Change Password Controller Start
    public function changepassword() {
        $this->data['title'] = 'Setting | Change Password  - Aileensoul';
        $this->load->view('registration/changepassword', $this->data);
    }

    public function changepassword_insert() {   
        $userid = $this->session->userdata('aileenuser'); 
        $this->form_validation->set_rules('oldpassword', 'Old Password', 'required');
        $this->form_validation->set_rules('password1', 'Password', 'trim|required');
        $this->form_validation->set_rules('password2', 'Confirm Password', 'trim|required|matches[password1]');

        $oldpassword = $this->input->post('oldpassword');
        $newpassword = $this->input->post('password1');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('registration/changepassword');
        } else {
            
            $result = $this->user_model->getUserPassword($userid,md5($oldpassword));

            if ($result) {

                if ($result[0]['user_password'] == md5($newpassword)) {
                    $data = array(
                        'error_message1' => 'Your old password and new password are same'
                    );
                    $this->load->view('registration/changepassword', $data);
                } else {
                    $data = array(
                        'password' => md5($newpassword)
                    );

                    $updatdata = $this->common->update_data($data, 'user_login', 'user_id', $userid);
                    if ($updatdata) {

                        redirect('profiles/' . $this->session->userdata('aileenuser_slug'), 'refresh');
                        $this->session->flashdata('success', 'Update Successfully!!');
                    } else {
                        $this->session->flashdata('error', 'Your Password not Edited');
                        redirect('registration/changepassword', 'refresh');
                    }
                }
            } else {
                $data = array(
                    'error_message1' => 'Your old password does not match'
                );
                $this->load->view('registration/changepassword', $data);
            }
        }
    }

//Change Password Controller End
    // khyati strat

    public function res_mail() {

        $userid = $this->session->userdata('aileenuser');
        $userdata = $this->common->select_data_by_id('user', 'user_id', $userid, $data = '*', $join_str = array());

        $email = $userdata[0]['user_email'];
        $username = $userdata[0]['user_name'];
        $firstname = $userdata[0]['first_name'];
        $lastname = $userdata[0]['last_name'];
        $gender = $userdata[0]['user_gender'];

        $data = array(
            'user_verify' => '2',
            'verify_date' => date('Y-m-d', time())
        );

        $updatdata = $this->common->update_data($data, 'user', 'user_id', $userid);


        $to_email = $email;
        //echo $toemail; die();


        $msg = '<tr>
              <td style="text-align:center; padding-top:15px;">';
        if ($userdata[0]['user_image']) {
            $msg .= '<img src="' . base_url($this->config->item('user_thumb_upload_path') . $userdata[0]['user_image']) . '">';
        } else {

            if ($gender == 'F') {
                $msg .= '<img src="' . base_url(FNOIMAGE) . '">';
            } else {
                $msg .= '<img src="' . base_url(MNOIMAGE) . '">';
            }
        }
        $msg .= '</td>
            </tr>
            <tr>
              <td style="text-align:center; padding:10px 0 30px; font-size:15px;">';
        $msg .= '<p style="margin:0;">Hi,' . ucwords($firstname) . ucwords($lastname) . '</p>
                <p style="padding:25px 0 ; margin:0;">Aileensoul has send you verification mail for verify your account successfully.</p>
                <p><a class="btn" href="' . base_url() . 'registration/verify/' . $userid . '">verify account</a></p>
              </td>
            </tr>';

        // $msg = "Hey !" . $username ."<br/>"; 
        // $msg .=  " " . $firstname . " " . $lastname . ",";
        // $msg .= "Click hear to verify your account";
        // $msg .= "<br>"; 
        // $msg .= "<a href='".base_url()."/registration/verify/" . $userid . "'>click here</a>"; 
        // echo $msg; die();
        $subject = "Aileensoul account verification link";

        $mail = $this->email_model->sendEmail($app_name = '', $app_email = '', $to_email, $subject, $msg);

        $allowedgmail = 'gmail.com';
        $allowedyahoo = 'yahoo.com';
        $hotmail = 'hotmail.com';
        $outlook = 'outlook.com';
        $rediff = 'rediffmail.com';
        $zoho = 'zoho.com';
        $mail = 'mail.com';
        $gmx = 'gmx.com';
        $gmx1 = 'gmx.us';
        $mailchimp = 'mailchimp.com';



        //  $comapremaill[] = $email; 
        // foreach($comapremaill as $key => $value) { 
        if (strpos($to_email, $allowedgmail) !== false) {

            $usermail = 'https://accounts.google.com/';
        } elseif (strpos($toemail, $allowedyahoo) !== false) {
            $usermail = 'https://login.yahoo.com/';
        } elseif (strpos($toemail, $hotmail) !== false) {
            $usermail = 'https://outlook.live.com/';
        } elseif (strpos($toemail, $outlook) !== false) {
            $usermail = 'https://outlook.live.com/';
        } elseif (strpos($toemail, $rediff) !== false) {
            $usermail = 'https://mypage.rediff.com/login/';
        } elseif (strpos($toemail, $zoho) !== false) {
            $usermail = 'https://www.zoho.com/mail/login.html';
        } elseif (strpos($toemail, $mail) !== false) {
            $usermail = 'https://www.mail.com/int/';
        } elseif (strpos($toemail, $gmx) !== false || strpos($value, $gmx1) !== false) {
            $usermail = 'https://www.gmx.com/';
        } elseif (strpos($toemail, $mailchimp) !== false) {
            $usermail = 'https://login.mailchimp.com/';
        }

        //    }
        echo $usermail;
    }

    // khjyati end
    // public function mailredirect()
    // { 
    //     redirect('artist/art_post', 'refresh'); die();
    //   $user_email =  $_POST["user_email"];
    //    $allowedgmail = 'gmail.com';
    //    $allowedyahoo = 'yahoo.com';
    //    $hotmail = 'hotmail.com';
    //    $outlook = 'outlook.com';
    //      $comapremaill[] = $user_email; 
    //      foreach($comapremaill as $key => $value) { 
    //         if (strpos($value, $allowedgmail) !== false) {   
    //               $usermail = $allowedgmail;    
    //            } 
    //          }
    //          echo $usermail; 
    // }

    public function flogin() {
        //echo '<pre>'; print_r($_POST); die();

        if ($this->input->post('id')) {

            $fbid = $this->input->post('id');

            $fbdata = $this->common->select_data_by_id('user', 'fb_id', $fbid, $data = '*', $join_str = array());

            if ($this->input->post('gender') == "female") {
                $gender = "F";
            } else {
                $gender = "M";
            }

            if ($fbdata) {
                $data = array(
                    'fb_id' => $this->input->post('id'),
                    'user_email' => $this->input->post('email'),
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'user_gender' => $gender,
                    'modified_date' => date('Y-m-d', time())
                );

                $updatdata = $this->common->update_data($data, 'user', 'fb_id', $fbid);

                $this->session->set_userdata('fbuser', $fbdata[0]['user_id']);
            } else {

                $data = array(
                    'fb_id' => $this->input->post('id'),
                    'user_email' => $this->input->post('email'),
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'user_gender' => $gender,
                    'modified_date' => date('Y-m-d', time())
                );


                $insert_id = $this->common->insert_data_getid($data, 'user');

                $this->session->set_userdata('fbuser', $insert_id);
            }
        }

        echo "yes";
    }

    // for old password match start

    public function check_password() {

        $oldpassword = md5($this->input->post('oldpassword'));

        $userid = $this->session->userdata('aileenuser');
        $userdata  = $this->user_model->getUserPasswordById($userid);
     
        if ($userdata['password'] == $oldpassword) {
            echo 'true';
            die();
        } else {
            echo 'false';
            die();
        }
    }

    // CREATE SLUG START
    public function setuser_slug($slugname, $filedname, $tablename, $notin_id = array()) {
        $slugname = $oldslugname = $this->create_slug($slugname);
        $i = 1;
        while ($this->compareuser_slug($slugname, $filedname, $tablename, $notin_id) > 0) {
            $slugname = $oldslugname . '-' . $i;
            $i++;
        }return $slugname;
    }

    public function compareuser_slug($slugname, $filedname, $tablename, $notin_id = array()) {
        $this->db->where($filedname, $slugname);
        if (isset($notin_id) && $notin_id != "" && count($notin_id) > 0 && !empty($notin_id)) {
            $this->db->where($notin_id);
        }
        $num_rows = $this->db->count_all_results($tablename);
        return $num_rows;
    }

    public function create_slug($string) {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower(stripslashes($string)));
        $slug = preg_replace('/[-]+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }

}
