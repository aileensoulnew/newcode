<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email extends MY_Controller {

    public $data;
 

    public function __construct() {

      parent::__construct();

        if (!$this->session->userdata('aileen_admin')) 
        {
            redirect('login', 'refresh');
        }
   
        $this->load->model('email_model');
        // Get Site Information
        $this->data['title'] = 'Mail | Aileensoul';
        $this->data['module_name'] = 'Mailbox';
        $this->data['section_title'] = 'Mail';

         //Loadin Pagination Custome Config File
         $this->config->load('paging', TRUE);
         $this->paging = $this->config->item('paging');



        include('include.php');
        $adminid =  $this->session->userdata('aileen_admin');
   
       // echo $this->profile->thumb();
    }

public function compose($slug = "") 
{


   // echo $slug;die();
     //FOR GETTING ALL DATA STARt
    if($slug =='job')
    {
        
         $condition_array = array('emailid' => '1','email_status' => '1');
    }
     if($slug =='recruiter')
    {
         $condition_array = array('emailid' => '2','email_status' => '1');
    }
     if($slug =='freelancer')
    {
         $condition_array = array('emailid' => '3','email_status' => '1');
    }
     if($slug =='business')
    {
         $condition_array = array('emailid' => '4','email_status' => '1');
    }
     if($slug =='artistic')
    {
         $condition_array = array('emailid' => '5','email_status' => '1');
    }
    $this->data['email']  = $this->common->select_data_by_condition('emails_seo', $condition_array, $data='*', $short_by='', $order_by='', $limit, $offset, $join_str = array());

     $this->data['subject']  = $this->common->select_data_by_condition('emails_seo', $condition_array= array(), $data='*', $short_by='', $order_by='', $limit, $offset, $join_str = array());

    $this->data['slug']=$slug;
    //FOR GETTING ALL DATA END 
    $this->load->view('mail/compose',$this->data);
}

//LIST OF BLOG ADD BY ADMIN START
 public function compose_insert($slug = "") 
 {    
        $to_email= $_POST['toemail']; 
        $subject=$_POST['subjectmail']; 
        $msg= $_POST['compose'];


     $data = array(
                    'varsubject' => $subject,
                    'varmailformat' => $msg,
                    'timestamp' => date('Y-m-d H:i:s'),
                    'email_status' => '1'
                ); 

     if($slug =='job')
     {   
            
        $update = $this->common->update_data($data, 'emails_seo', 'emailid', 1);
     }

     if($slug =='recruiter')
     {
        
        $update = $this->common->update_data($data, 'emails_seo', 'emailid', 2);
     }

     if($slug =='freelancer')
     {
        
        $update = $this->common->update_data($data, 'emails_seo', 'emailid', 3);
     }

     if($slug =='business')
     {
        
        $update = $this->common->update_data($data, 'emails_seo', 'emailid', 4);
     }

     if($slug =='artistic')
     {
           
        $update = $this->common->update_data($data, 'emails_seo', 'emailid', 5);
     }
       

        $to_mail = explode(',',$to_email);

        
        foreach($to_mail as $mail)
        {   

            $mail = $this->email_model->sendEmail($app_name = '', $app_email = '', $mail , $subject, $msg);
          
        }
         redirect('email/compose/'.$slug, refresh);
}
//LIST OF BLOG ADD BY ADMIN END

}

?>