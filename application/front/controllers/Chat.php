<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Chat extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper('smiley');

        if (!$this->session->userdata('aileenuser')) {
            redirect('login', 'refresh');
        }
        
        //AWS access info start
        $this->load->library('S3');
        //AWS access info end

        include('include.php');
    }

    public function index($message_from_profile = '', $message_to_profile = '') {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        // from job
        if ($message_from_profile == 2) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $message_from_profile_id = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_id,fname,lname', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_id[0]['job_id'];
            $this->data['message_from_profile'] = 1;
            $this->data['message_to_profile'] = 2;

            $this->data['logfname'] = $message_from_profile_id[0]['fname'];
            $this->data['loglname'] = $message_from_profile_id[0]['lname'];
        }

        // from recruiter
        if ($message_from_profile == 1) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 're_status' => '1');
            $message_from_profile_id = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id,rec_firstname,rec_lastname', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_id[0]['rec_id'];
            $this->data['message_from_profile'] = 2;
            $this->data['message_to_profile'] = 1;

            $this->data['logfname'] = $message_from_profile_id[0]['rec_firstname'];
            $this->data['loglname'] = $message_from_profile_id[0]['rec_lastname'];
        }

        // from freelancer hire
        if ($message_from_profile == 3) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $message_from_profile_id = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'reg_id,fullname,username', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_id[0]['reg_id'];
            $this->data['message_from_profile'] = 3;
            $this->data['message_to_profile'] = 4;

            $this->data['logfname'] = $message_from_profile_id[0]['fullname'];
            $this->data['loglname'] = $message_from_profile_id[0]['username'];
        }

        // from freelancer post
        if ($message_from_profile == 4) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $message_from_profile_id = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_reg_id,freelancer_post_fullname,freelancer_post_username', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_id[0]['freelancer_post_reg_id'];
            $this->data['message_from_profile'] = 4;
            $this->data['message_to_profile'] = 3;

            $this->data['logfname'] = $message_from_profile_id[0]['freelancer_post_fullname'];
            $this->data['loglname'] = $message_from_profile_id[0]['freelancer_post_username'];
        }

        // from business
        if ($message_from_profile == 5) {
            $contition_array = array('user_id' => $userid, 'business_profile.is_deleted' => '0', 'status' => '1');
            $message_from_profile_id = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id,company_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_id[0]['business_profile_id'];
            $this->data['message_from_profile'] = $this->data['message_to_profile'] = 5;

            $this->data['logfname'] = $message_from_profile_id[0]['company_name'];
            $this->data['loglname'] = $message_from_profile_id[0]['company_name'];
        }

        // from artistic
        if ($message_from_profile == 6) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $message_from_profile_id = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_name,art_lastname', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_id[0]['art_id'];
            $this->data['message_from_profile'] = $this->data['message_to_profile'] = 6;

            $this->data['logfname'] = $message_from_profile_id[0]['art_name'];
            $this->data['loglname'] = $message_from_profile_id[0]['art_lastname'];
        }

        // last message user fetch

        $contition_array = array('id !=' => '');
        $search_condition = "(message_from = '$userid' OR message_to = '$userid') AND (message_from_profile_id = ' $message_from_profile_id' OR message_to_profile_id = '$message_from_profile_id')";
        $lastuser = $this->common->select_data_by_search('messages', $search_condition, $contition_array, $data = 'messages.message_from,message_to,id', $sortby = 'id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = '', $groupby = '');

        if ($lastuser[0]['message_from'] == $userid && $lastuser[0]['message_from_profile_id'] == $this->data['message_from_profile_id']) {
            $lstusr = $this->data['lstusr'] = $lastuser[0]['message_to'];
        } else {
            $lstusr = $this->data['lstusr'] = $lastuser[0]['message_from'];
        }

// last user first name last name
        if ($lstusr) {

            // from job
            if ($message_from_profile == 1) {
                $contition_array = array('user_id' => $lstusr, 'is_delete' => '0', 'status' => '1');
                $lastuser = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_id,fname,lname', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                $message_from_profile_id = $this->data['message_from_profile_id'] = $lastuser[0]['job_id'];
                $this->data['message_from_profile'] = $this->data['message_to_profile'] = 6;
                $this->data['lstfname'] = $lastuser[0]['fname'];
                $this->data['loglname'] = $lastuser[0]['lname'];
                // slected user chat to
                $contition_array = array('is_delete' => '0', 'status' => '1');

                $join_str1[0]['table'] = 'messages';
                $join_str1[0]['join_table_id'] = 'messages.message_to';
                $join_str1[0]['from_table_id'] = 'job_reg.user_id';
                $join_str1[0]['join_type'] = '';

                $search_condition = "(message_from = '$lstusr' OR message_to = '$lstusr') AND (message_from_profile_id = '$message_from_profile_id' OR message_to_profile_id = '$message_from_profile_id') AND (message_to != '$userid')";
                $seltousr = $this->common->select_data_by_search('job_reg1', $search_condition, $contition_array, $data = 'messages.id,message_to,fname,job_user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');


                // slected user chat from


                $contition_array = array('is_delete' => '0', 'status' => '1');

                $join_str2[0]['table'] = 'messages';
                $join_str2[0]['join_table_id'] = 'messages.message_from';
                $join_str2[0]['from_table_id'] = 'job_reg.user_id';
                $join_str2[0]['join_type'] = '';

                $search_condition = "(((message_from = '$lstusr' OR message_to = '$lstusr') && (message_from = '$message_from_profile_id' OR message_to = '$message_from_profile_id')) && ((message_from != '$userid')))";
                $selfromusr = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,fname,job_user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');

                $selectuser = array_merge($seltousr, $selfromusr);
                $selectuser = $this->aasort($selectuser, "id");
            }

            // from recruiter
            if ($message_from_profile == 2) {
                $contition_array = array('user_id' => $lstusr, 'is_delete' => '0', 're_status' => '1');
                $lastuser = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id,rec_firstname,rec_lastname', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                $message_from_profile_id = $this->data['message_from_profile_id'] = $lastuser[0]['rec_id'];
                $this->data['lstfname'] = $lastuser[0]['rec_firstname'];
                $this->data['loglname'] = $lastuser[0]['rec_lastname'];

                // slected user chat to
                $contition_array = array('is_delete' => '0', 'status' => '1');

                $join_str1[0]['table'] = 'messages';
                $join_str1[0]['join_table_id'] = 'messages.message_to';
                $join_str1[0]['from_table_id'] = 'recruiter.user_id';
                $join_str1[0]['join_type'] = '';

                $search_condition = "(((message_from = '$lstusr' OR message_to = '$lstusr') && (message_from = '$message_from_profile_id' OR message_to = '$message_from_profile_id')) && (message_to != '$userid'))";

                $seltousr = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array, $data = 'messages.id,message_to,rec_firstname,rec_user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');


                // slected user chat from


                $contition_array = array('is_delete' => '0', 'status' => '1');

                $join_str2[0]['table'] = 'messages';
                $join_str2[0]['join_table_id'] = 'messages.message_from';
                $join_str2[0]['from_table_id'] = 'recruiter.user_id';
                $join_str2[0]['join_type'] = '';



                $search_condition = "(((message_from = '$lstusr' OR message_to = '$lstusr') && (message_from = '$message_from_profile_id' OR message_to = '$message_from_profile_id')) && (message_from != '$userid'))";

                $selfromusr = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array, $data = 'messages.id,message_from,rec_firstname,rec_user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');


                $selectuser = array_merge($seltousr, $selfromusr);
                $selectuser = $this->aasort($selectuser, "id");
            }

            // from freelancer hire
            if ($message_from_profile == 3) {
                $contition_array = array('user_id' => $lstusr, 'is_delete' => '0', 'status' => '1');
                $lastuser = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'reg_id,fullname,username', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                $message_from_profile_id = $this->data['message_from_profile_id'] = $lastuser[0]['reg_id'];
                $this->data['lstfname'] = $lastuser[0]['fullname'];
                $this->data['loglname'] = $lastuser[0]['username'];

                // slected user chat to
                $contition_array = array('is_delete' => '0', 'status' => '1');

                $join_str1[0]['table'] = 'messages';
                $join_str1[0]['join_table_id'] = 'messages.message_to';
                $join_str1[0]['from_table_id'] = 'freelancer_hire_reg.user_id';
                $join_str1[0]['join_type'] = '';

                $search_condition = "(((message_from = '$lstusr' OR message_to = '$lstusr') && (message_from = '$message_from_profile_id' OR message_to = '$message_from_profile_id')) && (message_to != '$userid'))";

                $seltousr = $this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,fullname,freelancer_hire_user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');


                // slected user chat from


                $contition_array = array('is_delete' => '0', 'status' => '1');

                $join_str2[0]['table'] = 'messages';
                $join_str2[0]['join_table_id'] = 'messages.message_from';
                $join_str2[0]['from_table_id'] = 'freelancer_hire_reg.user_id';
                $join_str2[0]['join_type'] = '';



                $search_condition = "(((message_from = '$lstusr' OR message_to = '$lstusr') && (message_from = '$message_from_profile_id' OR message_to = '$message_from_profile_id')) && (message_from != '$userid'))";

                $selfromusr = $this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,fullname,freelancer_hire_user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');


                $selectuser = array_merge($seltousr, $selfromusr);
                $selectuser = $this->aasort($selectuser, "id");
            }

            // from freelancer post
            if ($message_from_profile == 4) {
                $contition_array = array('user_id' => $lstusr, 'is_delete' => '0', 'status' => '1');
                $lastuser = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_reg_id,freelancer_post_fullname,freelancer_post_username', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                $message_from_profile_id = $this->data['message_from_profile_id'] = $lastuser[0]['freelancer_post_reg_id'];
                $this->data['lstfname'] = $lastuser[0]['freelancer_post_fullname'];
                $this->data['loglname'] = $lastuser[0]['freelancer_post_username'];

                // slected user chat to
                $contition_array = array('is_delete' => '0', 'status' => '1');

                $join_str1[0]['table'] = 'messages';
                $join_str1[0]['join_table_id'] = 'messages.message_to';
                $join_str1[0]['from_table_id'] = 'freelancer_post_reg.user_id';
                $join_str1[0]['join_type'] = '';

                $search_condition = "(((message_from = '$lstusr' OR message_to = '$lstusr') && (message_from = '$message_from_profile_id' OR message_to = '$message_from_profile_id')) && (message_to != '$userid'))";

                $seltousr = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,freelancer_post_fullname,freelancer_post_user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');


                // slected user chat from


                $contition_array = array('is_delete' => '0', 'status' => '1');

                $join_str2[0]['table'] = 'messages';
                $join_str2[0]['join_table_id'] = 'messages.message_from';
                $join_str2[0]['from_table_id'] = 'freelancer_post_reg.user_id';
                $join_str2[0]['join_type'] = '';



                $search_condition = "(((message_from = '$lstusr' OR message_to = '$lstusr') && (message_from = '$message_from_profile_id' OR message_to = '$message_from_profile_id')) && (message_from != '$userid'))";

                $selfromusr = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,freelancer_post_fullname,freelancer_post_user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');


                $selectuser = array_merge($seltousr, $selfromusr);
                $selectuser = $this->aasort($selectuser, "id");
            }

            // from business
            if ($message_from_profile == 5) {
                $contition_array = array('user_id' => $lstusr, 'business_profile.is_deleted' => '0', 'status' => '1');
                $lastuser = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id,company_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                $message_from_profile_id = $this->data['message_from_profile_id'] = $lastuser[0]['business_profile_id'];
                $this->data['lstfname'] = $lastuser[0]['company_name'];
                $this->data['lstlname'] = $lastuser[0]['company_name'];

                // slected user chat to
                $contition_array = array('business_profile.is_deleted' => '0', 'status' => '1');

                $join_str1[0]['table'] = 'messages';
                $join_str1[0]['join_table_id'] = 'messages.message_to';
                $join_str1[0]['from_table_id'] = 'business_profile.user_id';
                $join_str1[0]['join_type'] = '';

                $search_condition = "(((message_from = '$lstusr' OR message_to = '$lstusr') && (message_from = '$message_from_profile_id' OR message_to = '$message_from_profile_id')) && (message_to != '$userid'))";

                $seltousr = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'messages.id,message_to,company_name,business_user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');


                // slected user chat from


                $contition_array = array('business_profile.is_deleted' => '0', 'status' => '1');

                $join_str2[0]['table'] = 'messages';
                $join_str2[0]['join_table_id'] = 'messages.message_from';
                $join_str2[0]['from_table_id'] = 'business_profile.user_id';
                $join_str2[0]['join_type'] = '';



                $search_condition = "(((message_from = '$lstusr' OR message_to = '$lstusr') && (message_from = '$message_from_profile_id' OR message_to = '$message_from_profile_id')) && (message_from != '$userid'))";

                $selfromusr = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'messages.id,message_from,company_name,business_user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');


                $selectuser = array_merge($seltousr, $selfromusr);
                $selectuser = $this->aasort($selectuser, "id");
            }

            // from artistic
            if ($message_from_profile == 6) {
                $contition_array = array('user_id' => $lstusr, 'is_delete' => '0', 'status' => '1');
                $lastuser = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_name,art_lastname', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                $message_from_profile_id = $this->data['message_from_profile_id'] = $lastuser[0]['art_id'];
                $this->data['lstfname'] = $lastuser[0]['art_name'];
                $this->data['lstlname'] = $lastuser[0]['art_lastname'];

                // slected user chat to
                $contition_array = array('is_deleted' => '0', 'status' => '1');

                $join_str1[0]['table'] = 'messages';
                $join_str1[0]['join_table_id'] = 'messages.message_to';
                $join_str1[0]['from_table_id'] = 'art_reg.user_id';
                $join_str1[0]['join_type'] = '';

                $search_condition = "(((message_from = '$lstusr' OR message_to = '$lstusr') && (message_from = '$message_from_profile_id' OR message_to = '$message_from_profile_id')) && (message_to != '$userid'))";

                $seltousr = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,art_name,art_user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');


                // slected user chat from


                $contition_array = array('is_deleted' => '0', 'status' => '1');

                $join_str2[0]['table'] = 'messages';
                $join_str2[0]['join_table_id'] = 'messages.message_from';
                $join_str2[0]['from_table_id'] = 'art_reg.user_id';
                $join_str2[0]['join_type'] = '';



                $search_condition = "(((message_from = '$lstusr' OR message_to = '$lstusr') && (message_from = '$message_from_profile_id' OR message_to = '$message_from_profile_id')) && (message_from != '$userid'))";

                $selfromusr = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,art_name,art_user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');


                $selectuser = array_merge($seltousr, $selfromusr);
                $selectuser = $this->aasort($selectuser, "id");
            }
//            $lastuser = $this->common->select_data_by_id('user', 'user_id', $lstusr, $data = 'first_name,last_name');
//
//            $this->data['lstfname'] = $lastuser[0]['first_name'];
//            $this->data['lstlname'] = $lastuser[0]['last_name'];
        }
        //khyati changes starrt 20-4
        // khyati 24-4 start 
// replace name of message_to in user_id in select user



        $return_arraysel = array();
        $i = 0;
        foreach ($selectuser as $k => $sel_list) {
            $return = array();
            $return = $sel_list;

            if ($sel_list['message_to']) {

                $return['user_id'] = $sel_list['message_to'];
                $return['first_name'] = $sel_list['first_name'];
                $return['user_image'] = $sel_list['user_image'];
                $return['message'] = $sel_list['message'];

                unset($return['message_to']);
            } else {

                $return['user_id'] = $sel_list['message_from'];
                $return['first_name'] = $sel_list['first_name'];
                $return['user_image'] = $sel_list['user_image'];
                $return['message'] = $sel_list['message'];


                unset($return['message_from']);
            }
            array_push($return_arraysel, $return);
            $i++;
            if ($i == 1)
                break;
        }


        // khyati 24-4 end 
        // message to user



        $contition_array = array('is_delete' => '0', 'status' => '1', 'message_to !=' => $userid);

        $join_str3[0]['table'] = 'messages';
        $join_str3[0]['join_table_id'] = 'messages.message_to';
        $join_str3[0]['from_table_id'] = 'user_info.user_id';
        $join_str3[0]['join_type'] = '';
        
        $join_str3[0]['table'] = 'user';
        $join_str3[0]['join_table_id'] = 'user.user_id';
        $join_str3[0]['from_table_id'] = 'user_info.user_id';
        $join_str3[0]['join_type'] = '';

        $search_condition = "((message_from = '$userid') && (message_to != '$lstusr'))";

        $tolist = $this->common->select_data_by_search('user_info', $search_condition, $contition_array, $data = 'messages.id,message_to,first_name,user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str3, $groupby = '');



// uniq array of tolist  
        foreach ($tolist as $k => $v) {
            foreach ($tolist as $key => $value) {
                if ($k != $key && $v['message_to'] == $value['message_to']) {
                    unset($tolist[$k]);
                }
            }
        }

        // replace name of message_to in user_id

        $return_arrayto = array();

        foreach ($tolist as $to_list) {
            if ($to_list['message_to'] != $lstusr) {
                $return = array();
                $return = $to_list;

                $return['user_id'] = $to_list['message_to'];
                $return['first_name'] = $to_list['first_name'];
                $return['user_image'] = $to_list['user_image'];
                $return['message'] = $to_list['message'];

                unset($return['message_to']);
                array_push($return_arrayto, $return);
            }
        }

        // message from user
        $contition_array = array('is_delete' => '0', 'status' => '1', 'message_from !=' => $userid);

        $join_str4[0]['table'] = 'messages';
        $join_str4[0]['join_table_id'] = 'messages.message_from';
        $join_str4[0]['from_table_id'] = 'user_info.user_id';
        $join_str4[0]['join_type'] = '';
        
        $join_str4[0]['table'] = 'user';
        $join_str4[0]['join_table_id'] = 'user.user_id';
        $join_str4[0]['from_table_id'] = 'user_info.user_id';
        $join_str4[0]['join_type'] = '';

        $search_condition = "((message_to = '$userid') && (message_from != '$lstusr'))";


        $fromlist = $this->common->select_data_by_search('user_info', $search_condition, $contition_array, $data = 'messages.id,messages.message_from,first_name,user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str4, $groupby = '');


        // uniq array of fromlist  
        foreach ($fromlist as $k => $v) {
            foreach ($fromlist as $key => $value) {
                if ($k != $key && $v['message_from'] == $value['message_from']) {
                    unset($fromlist[$k]);
                }
            }
        }

// replace name of message_to in user_id

        $return_arrayfrom = array();

        foreach ($fromlist as $from_list) {
            if ($to_list['message_from'] != $lstusr) {
                $return = array();
                $return = $from_list;

                $return['user_id'] = $from_list['message_from'];
                $return['first_name'] = $from_list['first_name'];
                $return['user_image'] = $from_list['user_image'];
                $return['message'] = $from_list['message'];


                unset($return['message_from']);
                array_push($return_arrayfrom, $return);
            }
        }

        $userlist = array_merge($return_arrayto, $return_arrayfrom);



        // uniq array of fromlist  
        foreach ($userlist as $k => $v) {
            foreach ($userlist as $key => $value) {
                if ($k != $key && $v['user_id'] == $value['user_id']) {
                    unset($userlist[$k]);
                }
            }
        }

        $userlist = $this->aasort($userlist, "id");

        $this->data['userlist'] = array_merge($return_arraysel, $userlist);
        // khyati changes end 20-4
// smily start
        $smileys = _get_smiley_array();
        $this->data['smiley_table'] = $smileys;
// smily end
//die();
        $this->load->view('chat', $this->data);
    }

    public function abc($message_from_profile = '', $message_to_profile = '', $id = '', $not_id = '') {


        $this->data['id'] = $id;
        $this->chat_search($id, $message_from_profile, $message_to_profile);
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        if ($id == $userid) {
            redirect('chat/noavailable');
        }
        // update notification read code start
        if ($not_id) {
            $data = array(
                'not_active' => 2
            );

            $updatedata = $this->common->update_data($data, 'notification', 'not_id', $not_id);
        }
        // update notification read code end 
        // from job
        if ($message_from_profile == 1) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $message_from_profile_data = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_id,fname,lname,job_user_image,designation,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_data[0]['job_id'];

            $this->data['message_from_profile'] = 1;
            $this->data['message_to_profile'] = 2;

            // last user etail start
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 're_status' => '1');
            $last_user_data = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id,rec_firstname,rec_lastname,recruiter_user_image,designation,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->data['last_user_data']['user_profile_id'] = $last_user_data[0]['rec_id'];
            $this->data['last_user_data']['first_name'] = $last_user_data[0]['rec_firstname'];
            $this->data['last_user_data']['last_name'] = $last_user_data[0]['rec_lastname'];

            $user_image = FCPATH . 'uploads/recruiter_profile/thumbs/' . $last_user_data[0]['recruiter_user_image'];
            if ($last_user_data[0]['recruiter_user_image'] && (file_exists($user_image)) == 1) {
                $this->data['last_user_data']['user_image'] = base_url() . 'uploads/recruiter_profile/thumbs/' . $last_user_data[0]['recruiter_user_image'];
            } else {
                $a = $last_user_data[0]['rec_firstname'];
                $b = $last_user_data[0]['rec_lastname'];
                $acr = substr($a, 0, 1);
                $bcr = substr($b, 0, 1);
                $this->data['last_user_data']['user_image_char'] = $acr . $bcr;
            }
            $this->data['last_user_data']['user_designation'] = $last_user_data[0]['designation'] == '' ? 'Designation' : $last_user_data[0]['designation'];
            // last user detail end
        }
        if ($message_to_profile == 1) {
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $message_to_profile_data = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_id,fname,lname,job_user_image,designation,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['message_to_profile_id'] = $message_to_profile_data[0]['job_id'];
        }

        // from recruiter
        if ($message_from_profile == 2) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 're_status' => '1');
            $message_from_profile_data = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id,rec_firstname,rec_lastname,recruiter_user_image,designation,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_data[0]['rec_id'];


            $this->data['message_from_profile'] = 2;
            $this->data['message_to_profile'] = 1;



            // last user detail start
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $last_user_data = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_id,fname,lname,job_user_image,designation,user_id,designation', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->data['last_user_data']['user_profile_id'] = $last_user_data[0]['rec_id'];
            $this->data['last_user_data']['first_name'] = $last_user_data[0]['fname'];
            $this->data['last_user_data']['last_name'] = $last_user_data[0]['lname'];
            $user_image = FCPATH . 'uploads/job_profile/thumbs/' . $last_user_data[0]['job_user_image'];
            if ($last_user_data[0]['job_user_image'] && (file_exists($user_image)) == 1) {
                $this->data['last_user_data']['user_image'] = base_url() . 'uploads/job_profile/thumbs/' . $last_user_data[0]['job_user_image'];
            } else {
                $a = $last_user_data[0]['fname'];
                $b = $last_user_data[0]['lname'];
                $acr = substr($a, 0, 1);
                $bcr = substr($b, 0, 1);
                $this->data['last_user_data']['user_image_char'] = $acr . $bcr;
            }
            //echo $last_user_data[0]['designation']; die();
            $this->data['last_user_data']['user_designation'] = $last_user_data[0]['designation'] == '' ? 'Current Work' : $last_user_data[0]['designation'];

            // last user detail end
        }


        if ($message_to_profile == 2) {
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 're_status' => '1');
            $message_to_profile_id = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id,rec_firstname,rec_lastname,recruiter_user_image,designation,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['message_to_profile_id'] = $message_to_profile_id[0]['rec_id'];
        }

        // from freelancer hire
        if ($message_from_profile == 3) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $message_from_profile_id = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'reg_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_id[0]['reg_id'];


            $this->data['message_from_profile'] = 3;
            $this->data['message_to_profile'] = 4;

            // last user detail start
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $last_user_data = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_reg_id,freelancer_post_username,freelancer_post_fullname,freelancer_post_user_image,user_id,designation', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->data['last_user_data']['user_profile_id'] = $last_user_data[0]['freelancer_post_reg_id'];
            $this->data['last_user_data']['first_name'] = $last_user_data[0]['freelancer_post_fullname'];
            $this->data['last_user_data']['last_name'] = $last_user_data[0]['freelancer_post_username'];
            $user_image = FCPATH . 'uploads/freelancer_post_profile/thumbs/' . $last_user_data[0]['freelancer_post_user_image'];
            if ($last_user_data[0]['freelancer_post_user_image'] && (file_exists($user_image)) == 1) {
                $this->data['last_user_data']['user_image'] = base_url() . 'uploads/freelancer_post_profile/thumbs/' . $last_user_data[0]['freelancer_post_user_image'];
            } else {
                $a = $last_user_data[0]['freelancer_post_fullname'];
                $b = $last_user_data[0]['freelancer_post_username'];
                $acr = substr($a, 0, 1);
                $bcr = substr($b, 0, 1);
                $this->data['last_user_data']['user_image_char'] = $acr . $bcr;
            }
            $this->data['last_user_data']['user_designation'] = $last_user_data[0]['designation'] == '' ? 'Designation' : $last_user_data[0]['designation'];

            // last user detail end
        }

        if ($message_to_profile == 3) {
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $message_to_profile_id = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'reg_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['message_to_profile_id'] = $message_to_profile_id[0]['reg_id'];
        }
        // from freelancer post
        if ($message_from_profile == 4) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $message_from_profile_id = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_reg_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_id[0]['freelancer_post_reg_id'];


            $this->data['message_from_profile'] = 4;
            $this->data['message_to_profile'] = 3;



            // last user detail start
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $last_user_data = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'reg_id,username,fullname,freelancer_hire_user_image,user_id,designation', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->data['last_user_data']['user_profile_id'] = $last_user_data[0]['rec_id'];
            $this->data['last_user_data']['first_name'] = $last_user_data[0]['fullname'];
            $this->data['last_user_data']['last_name'] = $last_user_data[0]['username'];
            $user_image = FCPATH . 'uploads/freelancer_hire_profile/thumbs/' . $last_user_data[0]['freelancer_hire_user_image'];
            if ($last_user_data[0]['freelancer_hire_user_image'] && (file_exists($user_image)) == 1) {
                $this->data['last_user_data']['user_image'] = base_url() . 'uploads/freelancer_hire_profile/thumbs/' . $last_user_data[0]['freelancer_hire_user_image'];
            } else {
                $a = $last_user_data[0]['fullname'];
                $b = $last_user_data[0]['username'];
                $acr = substr($a, 0, 1);
                $bcr = substr($b, 0, 1);
                $this->data['last_user_data']['user_image_char'] = $acr . $bcr;
            }
            $this->data['last_user_data']['user_designation'] = $last_user_data[0]['designation'] == '' ? 'Current Work' : $last_user_data[0]['designation'];

            // last user detail end
        }

        if ($message_to_profile == 4) {
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $message_to_profile_id = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_reg_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['message_to_profile_id'] = $message_to_profile_id[0]['freelancer_post_reg_id'];
        }
        // from business
        if ($message_from_profile == 5) {
            $contition_array = array('user_id' => $userid, 'business_profile.is_deleted' => '0', 'status' => '1');
            $message_from_profile_id = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_id[0]['business_profile_id'];

            $this->data['message_from_profile'] = $this->data['message_to_profile'] = 5;
            // last user detail start
            $contition_array = array('user_id' => $id, 'business_profile.is_deleted' => '0', 'status' => '1');
            $last_user_data = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id,company_name,business_user_image,user_id,industriyal,other_industrial', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->data['last_user_data']['user_profile_id'] = $last_user_data[0]['business_profile_id'];
            $this->data['last_user_data']['first_name'] = $last_user_data[0]['company_name'];
            $user_image = FCPATH . 'uploads/business_profile/thumbs/' . $last_user_data[0]['business_user_image'];
            if ($last_user_data[0]['business_user_image'] && (file_exists($user_image)) == 1) {
                $this->data['last_user_data']['user_image'] = base_url() . 'uploads/business_profile/thumbs/' . $last_user_data[0]['business_user_image'];
            } else {
                $a = $last_user_data[0]['company_name'];
                $acr = substr($a, 0, 1);
                $this->data['last_user_data']['user_image_char'] = $acr;
            }

            $category = $this->db->get_where('industry_type', array('industry_id' => $last_user_data[0]['industriyal'], 'status' => 1))->row()->industry_name;
            $this->data['last_user_data']['user_designation'] = $category == '' ? $last_user_data[0]['other_industrial'] : $category;

            // last user detail end
        }

        if ($message_to_profile == 5) {
            $contition_array = array('user_id' => $id, 'business_profile.is_deleted' => '0', 'status' => '1');
            $message_to_profile_id = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['message_to_profile_id'] = $message_to_profile_id[0]['business_profile_id'];
        }
        // from artistic
        if ($message_from_profile == 6) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $message_from_profile_id = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_id[0]['art_id'];


            $this->data['message_from_profile'] = $this->data['message_to_profile'] = 6;

            // last user detail start
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $last_user_data = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_name,art_lastname,art_user_image,user_id,designation', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->data['last_user_data']['user_profile_id'] = $last_user_data[0]['art_id'];
            $this->data['last_user_data']['first_name'] = $last_user_data[0]['art_name'];
            $this->data['last_user_data']['last_name'] = $last_user_data[0]['art_lastname'];
            $user_image = FCPATH . 'uploads/artistic_profile/thumbs/' . $last_user_data[0]['art_user_image'];
            if ($last_user_data[0]['art_user_image'] && (file_exists($user_image)) == 1) {
                $this->data['last_user_data']['user_image'] = base_url() . 'uploads/artistic_profile/thumbs/' . $last_user_data[0]['art_user_image'];
            } else {
                $a = $last_user_data[0]['art_name'];
                $b = $last_user_data[0]['art_lastname'];
                $acr = substr($a, 0, 1);
                $bcr = substr($b, 0, 1);
                $this->data['last_user_data']['user_image_char'] = $acr . $bcr;
            }

            $this->data['last_user_data']['user_designation'] = $last_user_data[0]['designation'] == '' ? 'Current Work' : $last_user_data[0]['designation'];

            // last user detail end
        }

        if ($message_to_profile == 6) {
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $message_to_profile_id = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['message_to_profile_id'] = $message_to_profile_id[0]['art_id'];
        }

        // last user if $id is null
        $contition_array = array('id !=' => '');
        $search_condition = "(message_from = '$userid' OR message_to = '$userid') AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";
        $lastchat = $this->common->select_data_by_search('messages', $search_condition, $contition_array, $data = 'messages.message_from,message_to,id', $sortby = 'id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = '', $groupby = '');

        if ($id) {
            $toid = $this->data['toid'] = $id;
        } elseif ($lastchat[0]['message_from'] == $userid) {
            $toid = $this->data['toid'] = $lastchat[0]['message_to'];
        } else {
            $toid = $this->data['toid'] = $lastchat[0]['message_from'];
        }

        //20-7@nkit
        if ($message_from_profile == 1) {
            $loginuser = $this->common->select_data_by_id('job_reg', 'user_id', $userid, $data = 'fname as first_name,lname as last_name,user_id');
        }

        if ($message_from_profile == 2) {
            $loginuser = $this->common->select_data_by_id('recruiter', 'user_id', $userid, $data = 'rec_firstname as first_name,rec_lastname as last_name,user_id');
        }

        if ($message_from_profile == 3) {
            $loginuser = $this->common->select_data_by_id('freelancer_hire_reg', 'user_id', $userid, $data = 'username as last_name,fullname as first_name,user_id');
        }

        if ($message_from_profile == 4) {
            $loginuser = $this->common->select_data_by_id('freelancer_post_reg', 'user_id', $userid, $data = 'freelancer_post_fullname as first_name,freelancer_post_username as last_name,user_id');
        }

        if ($message_from_profile == 5) {
            $loginuser = $this->common->select_data_by_id('business_profile', 'user_id', $userid, $data = 'company_name as first_name,user_id');
        }

        if ($message_from_profile == 6) {
            $loginuser = $this->common->select_data_by_id('art_reg', 'user_id', $userid, $data = 'art_name as first_name,art_lastname as last_name,user_id');
        }


        $this->data['logfname'] = $loginuser[0]['first_name'];
        $this->data['loglname'] = $loginuser[0]['last_name'];

        // last message user fetch

        $contition_array = array('id !=' => '');
        $search_condition = "(message_from = '$id' OR message_to = '$id')  AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";
        $lastuser = $this->common->select_data_by_search('messages', $search_condition, $contition_array, $data = 'messages.message_from,message_to,id', $sortby = 'id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = '', $groupby = '');

        if ($lastuser[0]['message_from'] == $userid) {
            $lstusr = $this->data['lstusr'] = $lastuser[0]['message_to'];
        } else {
            $lstusr = $this->data['lstusr'] = $lastuser[0]['message_from'];
        }

        // last user first name last name
        if ($lstusr) {

            //20-7@nkit
            if ($message_from_profile == 1) {
                $lastuser = $this->common->select_data_by_id('job_reg', 'user_id', $lstusr, $data = 'fname as first_name,lname as last_name,user_id');
            }

            if ($message_from_profile == 2) {
                $lastuser = $this->common->select_data_by_id('recruiter', 'user_id', $lstusr, $data = 'rec_firstname as first_name,rec_lastname as last_name,user_id');
            }

            if ($message_from_profile == 3) {
                $lastuser = $this->common->select_data_by_id('freelancer_hire_reg', 'user_id', $lstusr, $data = 'username as last_name,fullname as first_name,user_id');
            }

            if ($message_from_profile == 4) {
                $lastuser = $this->common->select_data_by_id('freelancer_post_reg', 'user_id', $lstusr, $data = 'freelancer_post_fullname as first_name,freelancer_post_username as last_name,user_id');
            }

            if ($message_from_profile == 5) {
                $lastuser = $this->common->select_data_by_id('business_profile', 'user_id', $lstusr, $data = 'company_name as first_name,user_id');
            }

            if ($message_from_profile == 6) {
                $lastuser = $this->common->select_data_by_id('art_reg', 'user_id', $lstusr, $data = 'art_name as first_name,art_lastname as last_name,user_id');
            }

//            $lastuser = $this->common->select_data_by_id('user', 'user_id', $lstusr, $data = 'first_name,last_name');

            $this->data['lstfname'] = $lastuser[0]['first_name'];
            $this->data['lstlname'] = $lastuser[0]['last_name'];
        }
        // slected user chat to

        $contition_array = array('is_delete' => '0', 'status' => '1');
        $search_condition = "((message_from = '$id' OR message_to = '$id') && (message_to != '$userid'))  AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";

        //20-7-2017@nkit
        if ($message_from_profile == 1) {
            $join_str1[0]['table'] = 'messages';
            $join_str1[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str1[0]['from_table_id'] = 'job_reg.job_id';
            $join_str1[0]['join_type'] = '';

            $seltousr = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,fname as first_name,lname as last_name,job_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
        }
        if ($message_from_profile == 2) {
            $join_str1[0]['table'] = 'messages';
            $join_str1[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str1[0]['from_table_id'] = 'recruiter.rec_id';
            $join_str1[0]['join_type'] = '';
            $contition_array = array('is_delete' => '0', 're_status' => '1');
            $seltousr = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array, $data = 'messages.id,message_to,rec_firstname as first_name,rec_lastname as last_name,recruiter_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
        }
        if ($message_from_profile == 3) {
            $join_str1[0]['table'] = 'messages';
            $join_str1[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str1[0]['from_table_id'] = 'freelancer_hire_reg.reg_id';
            $join_str1[0]['join_type'] = '';

            $seltousr = $this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,username as last_name,fullname as first_name,freelancer_hire_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
        }
        if ($message_from_profile == 4) {
            $join_str1[0]['table'] = 'messages';
            $join_str1[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str1[0]['from_table_id'] = 'freelancer_post_reg.freelancer_post_reg_id';
            $join_str1[0]['join_type'] = '';

            $seltousr = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,freelancer_post_fullname as first_name,freelancer_post_username as last_name,freelancer_post_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
        }
        if ($message_from_profile == 5) {
            $join_str1[0]['table'] = 'messages';
            $join_str1[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str1[0]['from_table_id'] = 'business_profile.business_profile_id';
            $join_str1[0]['join_type'] = '';
            $contition_array = array('business_profile.is_deleted' => '0', 'status' => '1');
            $seltousr = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'messages.id,message_to,company_name as first_name,business_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
        }
        if ($message_from_profile == 6) {
            $join_str1[0]['table'] = 'messages';
            $join_str1[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str1[0]['from_table_id'] = 'art_reg.art_id';
            $join_str1[0]['join_type'] = '';

            $seltousr = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,art_name as first_name,art_lastname as last_name,art_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
        }

        // slected user chat from

        $contition_array = array('is_delete' => '0', 'status' => '1');
        $search_condition = "((message_from = '$id' OR message_to = '$id') && (message_from != '$userid')) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";

        //20-7-2017@nkit
        if ($message_from_profile == 1) {
            $join_str2[0]['table'] = 'messages';
            $join_str2[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str2[0]['from_table_id'] = 'job_reg.job_id';
            $join_str2[0]['join_type'] = '';

            $selfromusr = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,fname as first_name,lname as last_name,job_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
        }
        if ($message_from_profile == 2) {
            $join_str2[0]['table'] = 'messages';
            $join_str2[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str2[0]['from_table_id'] = 'recruiter.rec_id';
            $join_str2[0]['join_type'] = '';
            $contition_array = array('is_delete' => '0', 're_status' => '1');
            $selfromusr = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array, $data = 'messages.id,message_from,rec_firstname as first_name,rec_lastname as last_name,recruiter_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
        }
        if ($message_from_profile == 3) {
            $join_str2[0]['table'] = 'messages';
            $join_str2[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str2[0]['from_table_id'] = 'freelancer_hire_reg.reg_id';
            $join_str2[0]['join_type'] = '';

            $selfromusr = $this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,username as last_name,fullname as first_name,freelancer_hire_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
        }
        if ($message_from_profile == 4) {
            $join_str2[0]['table'] = 'messages';
            $join_str2[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str2[0]['from_table_id'] = 'freelancer_post_reg.freelancer_post_reg_id';
            $join_str2[0]['join_type'] = '';

            $selfromusr = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,freelancer_post_fullname as first_name,freelancer_post_username as last_name,freelancer_post_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
        }
        if ($message_from_profile == 5) {
            $join_str2[0]['table'] = 'messages';
            $join_str2[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str2[0]['from_table_id'] = 'business_profile.business_profile_id';
            $join_str2[0]['join_type'] = '';
            $contition_array = array('business_profile.is_deleted' => '0', 'status' => '1');
            $selfromusr = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'messages.id,message_from,company_name as first_name,business_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
        }
        if ($message_from_profile == 6) {
            $join_str2[0]['table'] = 'messages';
            $join_str2[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str2[0]['from_table_id'] = 'art_reg.art_id';
            $join_str2[0]['join_type'] = '';

            $selfromusr = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,art_name as first_name,art_lastname as last_name,art_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
        }

        $selectuser = array_merge($seltousr, $selfromusr);
        $selectuser = $this->aasort($selectuser, "id");

        // replace name of message_to in user_id in select user

        $return_arraysel = array();
        $i = 0;
        foreach ($selectuser as $k => $sel_list) {
            $return = array();
            $return = $sel_list;

            if ($sel_list['message_to']) {
                if ($sel_list['message_to'] == $id) {
                    $return['user_id'] = $sel_list['message_to'];
                    $return['first_name'] = $sel_list['first_name'];
                    $return['last_name'] = $sel_list['last_name'];
                    $return['user_image'] = $sel_list['user_image'];
                    $return['message'] = $sel_list['message'];

                    unset($return['message_to']);

                    $i++;
                    if ($i == 1)
                        break;
                }
            }else {
                if ($sel_list['message_from'] == $id) {
                    $return['user_id'] = $sel_list['message_from'];
                    $return['first_name'] = $sel_list['first_name'];
                    $return['last_name'] = $sel_list['last_name'];
                    $return['user_image'] = $sel_list['user_image'];
                    $return['message'] = $sel_list['message'];

                    $i++;
                    if ($i == 1)
                        break;
                }

                unset($return['message_from']);
            }
        } array_push($return_arraysel, $return);

        // message to user
        $contition_array = array('is_delete' => '0', 'status' => '1', 'message_to !=' => $userid);
        $search_condition = "((message_from = '$userid') && (message_to != '$id')) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";

        //20-7-2017@nkit
        if ($message_from_profile == 2) {
            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str3[0]['from_table_id'] = 'job_reg.job_id';
            $join_str3[0]['join_type'] = '';

            $tolist = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,fname as first_name,lname as last_name,job_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
        }
        if ($message_from_profile == 1) {
            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str3[0]['from_table_id'] = 'recruiter.rec_id';
            $join_str3[0]['join_type'] = '';
            $contition_array = array('is_delete' => '0', 're_status' => '1');
            $tolist = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array, $data = 'messages.id,message_to,rec_firstname as first_name,rec_lastname as last_name,recruiter_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
        }
        if ($message_from_profile == 4) {
            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str3[0]['from_table_id'] = 'freelancer_hire_reg.reg_id';
            $join_str3[0]['join_type'] = '';

            $tolist = $this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,username as last_name,fullname as first_name,freelancer_hire_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
        }
        if ($message_from_profile == 3) {
            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str3[0]['from_table_id'] = 'freelancer_post_reg.freelancer_post_reg_id';
            $join_str3[0]['join_type'] = '';

            $tolist = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,freelancer_post_fullname as first_name,freelancer_post_username as last_name,freelancer_post_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
        }
        if ($message_from_profile == 5) {
            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str3[0]['from_table_id'] = 'business_profile.business_profile_id';
            $join_str3[0]['join_type'] = '';
            $contition_array = array('business_profile.is_deleted' => '0', 'status' => '1');
            $tolist = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'messages.id,message_to,company_name as first_name,business_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
        }
        if ($message_from_profile == 6) {
            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str3[0]['from_table_id'] = 'art_reg.art_id';
            $join_str3[0]['join_type'] = '';

            $tolist = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,art_name as first_name,art_lastname as last_name,art_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
        }

        // uniq array of tolist  
        foreach ($tolist as $k => $v) {
            foreach ($tolist as $key => $value) {

                if ($k != $key && $v['message_to'] == $value['message_to']) {
                    unset($tolist[$k]);
                }
            }
        }

        // replace name of message_to in user_id

        $return_arrayto = array();
        foreach ($tolist as $to_list) {
            if ($to_list['message_to'] != $id) {
                $return = array();
                $return = $to_list;

                $return['user_id'] = $to_list['message_to'];
                $return['first_name'] = $to_list['first_name'];
                $return['last_name'] = $to_list['last_name'];
                $return['user_image'] = $to_list['user_image'];
                $return['message'] = $to_list['message'];

                unset($return['message_to']);
                array_push($return_arrayto, $return);
            }
        }

        // message from user
        $contition_array = array('is_delete' => '0', 'status' => '1', 'message_from !=' => $userid);
        $search_condition = "((message_to = '$userid') && (message_from != '$id')) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";

        //20-7-2017@nkit
        if ($message_from_profile == 1) {
            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str4[0]['from_table_id'] = 'job_reg.job_id';
            $join_str4[0]['join_type'] = '';

            $fromlist = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,fname as first_name,lname as last_name,job_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
        }
        if ($message_from_profile == 2) {
            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str4[0]['from_table_id'] = 'recruiter.rec_id';
            $join_str4[0]['join_type'] = '';
            $contition_array = array('is_delete' => '0', 're_status' => '1');
            $fromlist = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array, $data = 'messages.id,message_from,rec_firstname as first_name,rec_lastname as last_name,recruiter_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
        }
        if ($message_from_profile == 3) {
            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str4[0]['from_table_id'] = 'freelancer_hire_reg.reg_id';
            $join_str4[0]['join_type'] = '';

            $fromlist = $this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,username as last_name,fullname as first_name,freelancer_hire_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
        }
        if ($message_from_profile == 4) {
            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str4[0]['from_table_id'] = 'freelancer_post_reg.freelancer_post_reg_id';
            $join_str4[0]['join_type'] = '';

            $fromlist = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,freelancer_post_fullname as first_name,freelancer_post_username as last_name,freelancer_post_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
        }
        if ($message_from_profile == 5) {
            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str4[0]['from_table_id'] = 'business_profile.business_profile_id';
            $join_str4[0]['join_type'] = '';
            $contition_array = array('business_profile.is_deleted' => '0', 'status' => '1');
            $fromlist = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'messages.id,message_from,company_name as first_name,business_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
        }
        if ($message_from_profile == 6) {
            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str4[0]['from_table_id'] = 'art_reg.art_id';
            $join_str4[0]['join_type'] = '';

            $fromlist = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,art_name as first_name,art_lastname as last_name,art_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
        }

        // uniq array of fromlist  
        foreach ($fromlist as $k => $v) {
            foreach ($fromlist as $key => $value) {
                if ($k != $key && $v['message_from'] == $value['message_from']) {
                    unset($fromlist[$k]);
                }
            }
        }

// replace name of message_to in user_id

        $return_arrayfrom = array();

        foreach ($fromlist as $from_list) {
            if ($from_list['message_from'] != $id) {
                $return = array();
                $return = $from_list;

                $return['user_id'] = $from_list['message_from'];
                $return['first_name'] = $from_list['first_name'];
                $return['last_name'] = $from_list['last_name'];
                $return['user_image'] = $from_list['user_image'];
                $return['message'] = $from_list['message'];

                unset($return['message_from']);
                array_push($return_arrayfrom, $return);
            }
        }

        $userlist = array_merge($return_arrayto, $return_arrayfrom);

        // uniq array of fromlist  
        foreach ($userlist as $k => $v) {
            foreach ($userlist as $key => $value) {
                if ($k != $key && $v['user_id'] == $value['user_id']) {
                    if ($v['id'] < $value['id']) {
                        unset($userlist[$k]);
                    }
                }
            }
        }
        $userlist = $this->aasort($userlist, "id");

        if ($return_arraysel[0] == '') {
            $return_arraysel = array();
        }

//echo '<pre>';print_r($userlist);
//echo '<pre>';print_r($return_arraysel); die();
        $this->data['userlist'] = array_merge($return_arraysel, $userlist);

//echo '<pre>'; print_r($this->data['userlist']); die();
        // khytai changes 22-4 end
// smily start
        $smileys = _get_smiley_array();
        $this->data['smiley_table'] = $smileys;
// smily end
        // khytai changes end 22-4

        if (!empty($_SERVER['HTTP_USER_AGENT'])) {
            $useragent = $_SERVER['HTTP_USER_AGENT'];
            if (preg_match('@(iPad|iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)@', $useragent)) {
                $this->load->view('mobile/mobile_chat_one', $this->data);
            } else {
                $this->load->view('chat2', $this->data);
            }
        }

//      echo   $width = '<script>document.write(screen.width); </script>';
//       echo $width = 1024;
//       //echo $size = 767 ;
//          if ($width <= 767) {echo "ih"; die(); 
//         $this->load->view('mobile/mobile_chat_one', $this->data);       
//          }else{ echo "hello"; die();
//        $this->load->view('chat2', $this->data);
//          }
    }

    public function user_list($id) {
        $userid = $this->session->userdata('aileenuser');
        $usrsearchdata = trim($_POST['search_user']);

        if ($usrsearchdata != "") {
            // message to user
            $contition_array = array('is_delete' => '0', 'status' => '1', 'message_to !=' => $userid);

            $join_str5[0]['table'] = 'messages';
            $join_str5[0]['join_table_id'] = 'messages.message_to';
            $join_str5[0]['from_table_id'] = 'user_info.user_id';
            $join_str5[0]['join_type'] = '';
            
            $join_str5[0]['table'] = 'user';
            $join_str5[0]['join_table_id'] = 'user.user_id';
            $join_str5[0]['from_table_id'] = 'user_info.user_id';
            $join_str5[0]['join_type'] = '';


            $search_condition = "(first_name LIKE '" . trim($usrsearchdata) . "%')";

            $tolist = $this->common->select_data_by_search('user_info', $search_condition, $contition_array, $data = 'message_to,first_name,user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5, $groupby = '');

            // uniq array of tolist  
            foreach ($tolist as $k => $v) {
                foreach ($tolist as $key => $value) {
                    if ($k != $key && $v['message_to'] == $value['message_to']) {
                        unset($tolist[$k]);
                    }
                }
            }

            // replace name of message_to in user_id

            $return_arrayto = array();

            foreach ($tolist as $to_list) {

                $return = array();
                $return = $to_list;

                $return['user_id'] = $to_list['message_to'];
                $return['first_name'] = $to_list['first_name'];
                $return['user_image'] = $to_list['user_image'];

                unset($return['message_to']);
                array_push($return_arrayto, $return);
            }


            // message from user
            $contition_array = array('is_delete' => '0', 'status' => '1', 'message_from !=' => $userid);

            $join_str6[0]['table'] = 'messages';
            $join_str6[0]['join_table_id'] = 'messages.message_from';
            $join_str6[0]['from_table_id'] = 'user_info.user_id';
            $join_str6[0]['join_type'] = '';
            
            $join_str6[0]['table'] = 'user';
            $join_str6[0]['join_table_id'] = 'user.user_id';
            $join_str6[0]['from_table_id'] = 'user_info.user_id';
            $join_str6[0]['join_type'] = '';

            $search_condition = "(first_name LIKE '$usrsearchdata%')";

            $fromlist = $this->common->select_data_by_search('user_info', $search_condition, $contition_array, $data = 'messages.message_from,first_name,user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str6, $groupby = '');

            // uniq array of fromlist  
            foreach ($fromlist as $k => $v) {
                foreach ($fromlist as $key => $value) {
                    if ($k != $key && $v['message_from'] == $value['message_from']) {
                        unset($fromlist[$k]);
                    }
                }
            }

// replace name of message_to in user_id

            $return_arrayfrom = array();

            foreach ($fromlist as $from_list) {

                $return = array();
                $return = $from_list;

                $return['user_id'] = $from_list['message_from'];
                $return['first_name'] = $from_list['first_name'];
                $return['user_image'] = $from_list['user_image'];

                unset($return['message_from']);
                array_push($return_arrayfrom, $return);
            }

            $userlist = array_merge($return_arrayto, $return_arrayfrom);

            // uniq array of fromlist  
            foreach ($userlist as $k => $v) {
                foreach ($userlist as $key => $value) {
                    if ($k != $key && $v['user_id'] == $value['user_id']) {
                        unset($userlist[$k]);
                    }
                }
            }
            //echo '<pre>'; print_r($userlist); die();
            if ($userlist) {

                foreach ($userlist as $user) {
                    $usrsrch .= '<li class="clearfix">';

                    if ($user['user_image']) {
                        $usrsrch .= ' <div class="chat_heae_img">';
                        $usrsrch .= '<img src="' . base_url($this->config->item('user_thumb_upload_path') . $user['user_image']) . '" alt="avatar" height="50px" weight="50px" />';
                        $usrsrch .= '</div>';
                    } else {
                        $usrsrch .= ' <div class="chat_heae_img">';
                        $usrsrch .= '<img src="' . base_url(NOIMAGE) . '" alt="" height="50px" weight="50px">';
                        $usrsrch .= '</div>';
                    }

                    $usrsrch .= '<div class="about">';
                    $usrsrch .= '<div class="name">';
                    $usrsrch .= '<a href="' . base_url() . 'chat/abc/' . $user['user_id'] . '">' . $user['first_name'] . ' ' . $user['last_name'] . '<br></a>';
                    $usrsrch .= '</div><div class="status">Current Work</div></div></li>';
                }
            } else {

                $usrsrch .= '<div class="notac_a">No user available.. !!</div>';
            }
        } else {

            // 17-5-2017
            //$usrsrch .= '<div class="notac_a">No user available.. !!</div>';

            $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

            $loginuser = $this->common->select_data_by_id('user', 'user_id', $userid, $data = 'first_name,last_name');

            $this->data['logfname'] = $loginuser[0]['first_name'];
            $this->data['loglname'] = $loginuser[0]['last_name'];

            // last message user fetch

            $contition_array = array('id !=' => '');

            $search_condition = "(message_from = '$userid' OR message_to = '$userid')";

            $lastuser = $this->common->select_data_by_search('messages', $search_condition, $contition_array, $data = 'messages.message_from,message_to,id', $sortby = 'id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = '', $groupby = '');

            if ($lastuser[0]['message_from'] == $userid) {

                $lstusr = $this->data['lstusr'] = $lastuser[0]['message_to'];
            } else {

                $lstusr = $this->data['lstusr'] = $lastuser[0]['message_from'];
            }

// last user first name last name
            if ($lstusr) {
                $lastuser = $this->common->select_data_by_id('user', 'user_id', $lstusr, $data = 'first_name,last_name');

                $this->data['lstfname'] = $lastuser[0]['first_name'];
                $this->data['lstlname'] = $lastuser[0]['last_name'];
            }
            //khyati changes starrt 20-4
            // khyati 24-4 start 
            // slected user chat to


            $contition_array = array('is_delete' => '0', 'status' => '1');

            $join_str1[0]['table'] = 'messages';
            $join_str1[0]['join_table_id'] = 'messages.message_to';
            $join_str1[0]['from_table_id'] = 'user_info.user_id';
            $join_str1[0]['join_type'] = '';
            
            $join_str1[0]['table'] = 'user';
            $join_str1[0]['join_table_id'] = 'user.user_id';
            $join_str1[0]['from_table_id'] = 'user_info.user_id';
            $join_str1[0]['join_type'] = '';

            $search_condition = "((message_from = '$lstusr' OR message_to = '$lstusr') && (message_to != '$userid'))";

            $seltousr = $this->common->select_data_by_search('user_info', $search_condition, $contition_array, $data = 'messages.id,message_to,first_name,user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');


            // slected user chat from


            $contition_array = array('is_delete' => '0', 'status' => '1');

            $join_str2[0]['table'] = 'messages';
            $join_str2[0]['join_table_id'] = 'messages.message_from';
            $join_str2[0]['from_table_id'] = 'user_info.user_id';
            $join_str2[0]['join_type'] = '';
            
            $join_str2[0]['table'] = 'user';
            $join_str2[0]['join_table_id'] = 'user.user_id';
            $join_str2[0]['from_table_id'] = 'user_info.user_id';
            $join_str2[0]['join_type'] = '';


            $search_condition = "((message_from = '$lstusr' OR message_to = '$lstusr') && (message_from != '$userid'))";

            $selfromusr = $this->common->select_data_by_search('user_info', $search_condition, $contition_array, $data = 'messages.id,message_from,first_name,user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');


            $selectuser = array_merge($seltousr, $selfromusr);
            $selectuser = $this->aasort($selectuser, "id");


// replace name of message_to in user_id in select user

            $return_arraysel = array();
            $i = 0;
            foreach ($selectuser as $k => $sel_list) {
                $return = array();
                $return = $sel_list;

                if ($sel_list['message_to']) {

                    $return['user_id'] = $sel_list['message_to'];
                    $return['first_name'] = $sel_list['first_name'];
                    $return['user_image'] = $sel_list['user_image'];
                    $return['message'] = $sel_list['message'];

                    unset($return['message_to']);
                } else {

                    $return['user_id'] = $sel_list['message_from'];
                    $return['first_name'] = $sel_list['first_name'];
                    $return['user_image'] = $sel_list['user_image'];
                    $return['message'] = $sel_list['message'];


                    unset($return['message_from']);
                }
                array_push($return_arraysel, $return);
                $i++;
                if ($i == 1)
                    break;
            }


            // khyati 24-4 end 
            // message to user



            $contition_array = array('is_delete' => '0', 'status' => '1', 'message_to !=' => $userid);

            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to';
            $join_str3[0]['from_table_id'] = 'user_info.user_id';
            $join_str3[0]['join_type'] = '';
            
            $join_str3[0]['table'] = 'user';
            $join_str3[0]['join_table_id'] = 'user.user_id';
            $join_str3[0]['from_table_id'] = 'user_info.user_id';
            $join_str3[0]['join_type'] = '';

            $search_condition = "((message_from = '$userid') && (message_to != '$lstusr'))";

            $tolist = $this->common->select_data_by_search('user_info', $search_condition, $contition_array, $data = 'messages.id,message_to,first_name,user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str3, $groupby = '');



// uniq array of tolist  
            foreach ($tolist as $k => $v) {
                foreach ($tolist as $key => $value) {
                    if ($k != $key && $v['message_to'] == $value['message_to']) {
                        unset($tolist[$k]);
                    }
                }
            }

            // replace name of message_to in user_id

            $return_arrayto = array();

            foreach ($tolist as $to_list) {
                if ($to_list['message_to'] != $lstusr) {
                    $return = array();
                    $return = $to_list;

                    $return['user_id'] = $to_list['message_to'];
                    $return['first_name'] = $to_list['first_name'];
                    $return['user_image'] = $to_list['user_image'];
                    $return['message'] = $to_list['message'];

                    unset($return['message_to']);
                    array_push($return_arrayto, $return);
                }
            }

            // message from user
            $contition_array = array('is_delete' => '0', 'status' => '1', 'message_from !=' => $userid);

            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from';
            $join_str4[0]['from_table_id'] = 'user_info.user_id';
            $join_str4[0]['join_type'] = '';
            
            $join_str4[0]['table'] = 'user';
            $join_str4[0]['join_table_id'] = 'user.user_id';
            $join_str4[0]['from_table_id'] = 'user_info.user_id';
            $join_str4[0]['join_type'] = '';
            
            $search_condition = "((message_to = '$userid') && (message_from != '$lstusr'))";
            $fromlist = $this->common->select_data_by_search('user_info', $search_condition, $contition_array, $data = 'messages.id,messages.message_from,first_name,user_image,message', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str4, $groupby = '');

            // uniq array of fromlist  
            foreach ($fromlist as $k => $v) {
                foreach ($fromlist as $key => $value) {
                    if ($k != $key && $v['message_from'] == $value['message_from']) {
                        unset($fromlist[$k]);
                    }
                }
            }

// replace name of message_to in user_id

            $return_arrayfrom = array();

            foreach ($fromlist as $from_list) {
                if ($to_list['message_from'] != $lstusr) {
                    $return = array();
                    $return = $from_list;

                    $return['user_id'] = $from_list['message_from'];
                    $return['first_name'] = $from_list['first_name'];
                    $return['user_image'] = $from_list['user_image'];
                    $return['message'] = $from_list['message'];


                    unset($return['message_from']);
                    array_push($return_arrayfrom, $return);
                }
            }

            $userlist = array_merge($return_arrayto, $return_arrayfrom);



            // uniq array of fromlist  
            foreach ($userlist as $k => $v) {
                foreach ($userlist as $key => $value) {
                    if ($k != $key && $v['user_id'] == $value['user_id']) {
                        unset($userlist[$k]);
                    }
                }
            }

            $userlist = $this->aasort($userlist, "id");

            $userdata = array_merge($return_arraysel, $userlist);



            if (count($userdata) > 0) {
                foreach ($userdata as $user) {
                    $usrsrch .= '<a href="' . base_url() . 'chat/abc/' . $user['user_id'] . '">';
                    $usrsrch .= '<li class="clearfix">';
                    if ($user['user_image']) {
                        $usrsrch .= '<div class="chat_heae_img">';
                        $usrsrch .= '<img src="' . base_url($this->config->item('user_thumb_upload_path') . $user['user_image']) . '" alt="" >';
                        $usrsrch .= '</div>';
                    } else {
                        $usrsrch .= '<div class="chat_heae_img">';
                        $usrsrch .= '<img src="' . base_url(NOIMAGE) . '" alt="" >';
                        $usrsrch .= '</div>';
                    }
                    $usrsrch .= '<div class="about">';
                    $usrsrch .= '<div class="name">';
                    $usrsrch .= '' . $user['first_name'] . ' ' . $user['last_name'] . '<br> </div>';
                    $usrsrch .= '<div class="status' . $user['user_id'] . '" style=" width: 240px;    max-height: 19px;
    color: #003;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis; ">';
                    $usrsrch .= '' . str_replace('\\', '', $user['message']) . '';
                    $usrsrch .= '</div>';
                    $usrsrch .= '</div>';
                    $usrsrch .= '</li>';
                    $usrsrch .= '</a>';
                }
            } else {
                $usrsrch .= 'No user available...';
            }
            // 17-5-2017 end
        }

        echo $usrsrch;
    }

    //khyati 22-4 changes start 


    public function userlisttwo($message_from_profile = '', $message_to_profile = '') {

        $userid = $this->session->userdata('aileenuser');
        $usrsearchdata = trim($_POST['search_user']);
        $usrid = trim($_POST['user']);

        // from job
        if ($message_from_profile == 1) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $message_from_profile_id = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_id[0]['job_id'];
            $this->data['message_from_profile'] = 1;
            $this->data['message_to_profile'] = 2;
        }

        if ($message_to_profile == 1) {
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $message_to_profile_id = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['message_to_profile_id'] = $message_to_profile_id[0]['job_id'];
        }

        // from recruiter
        if ($message_from_profile == 2) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 're_status' => '1');
            $message_from_profile_id = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_id[0]['rec_id'];
            $this->data['message_from_profile'] = 2;
            $this->data['message_to_profile'] = 1;
        }


        if ($message_to_profile == 2) {
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 're_status' => '1');
            $message_to_profile_id = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['message_to_profile_id'] = $message_to_profile_id[0]['rec_id'];
        }

        // from freelancer hire
        if ($message_from_profile == 3) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $message_from_profile_id = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'reg_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_id[0]['reg_id'];
            $this->data['message_from_profile'] = 3;
            $this->data['message_to_profile'] = 4;
        }

        if ($message_to_profile == 3) {
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $message_to_profile_id = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'reg_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['message_to_profile_id'] = $message_to_profile_id[0]['reg_id'];
        }
        // from freelancer post
        if ($message_from_profile == 4) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $message_from_profile_id = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_reg_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_id[0]['freelancer_post_reg_id'];
            $this->data['message_from_profile'] = 4;
            $this->data['message_to_profile'] = 3;
        }

        if ($message_to_profile == 4) {
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $message_to_profile_id = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_reg_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['message_to_profile_id'] = $message_to_profile_id[0]['freelancer_post_reg_id'];
        }
        // from business
        if ($message_from_profile == 5) {
            $contition_array = array('user_id' => $userid, 'business_profile.is_deleted' => '0', 'status' => '1');
            $message_from_profile_id = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_id[0]['business_profile_id'];
            $this->data['message_from_profile'] = $this->data['message_to_profile'] = 5;
        }

        if ($message_to_profile == 5) {
            $contition_array = array('user_id' => $id, 'business_profile.is_deleted' => '0', 'status' => '1');
            $message_to_profile_id = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['message_to_profile_id'] = $message_to_profile_id[0]['business_profile_id'];
        }
        // from artistic
        if ($message_from_profile == 6) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $message_from_profile_id = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_id[0]['art_id'];
            $this->data['message_from_profile'] = $this->data['message_to_profile'] = 6;
        }

        if ($message_to_profile == 6) {
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $message_to_profile_id = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['message_to_profile_id'] = $message_to_profile_id[0]['art_id'];
        }

        if ($usrsearchdata != "") {
            // FOR JOB 

            if ($message_from_profile == 2) {
                // message to user
                $contition_array = array('is_delete' => '0', 'status' => '1', 'message_to !=' => $userid);

                $join_str7[0]['table'] = 'messages';
                $join_str7[0]['join_table_id'] = 'messages.message_to_profile_id';
                $join_str7[0]['from_table_id'] = 'job_reg.job_id';
                $join_str7[0]['join_type'] = '';


                $search_condition = "((fname LIKE '" . trim($usrsearchdata) . "%') AND (message_to !='" . $usrid . "' )) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";
                $tolist = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'message_to,fname as first_name,lname as last_name,job_user_image as user_image,user_id,message', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str7, $groupby = '');
            }

            // FOR RECRUITER

            if ($message_from_profile == 1) {
                // message to user
                $contition_array = array('is_delete' => '0', 're_status' => '1', 'message_to !=' => $userid);

                $join_str7[0]['table'] = 'messages';
                $join_str7[0]['join_table_id'] = 'messages.message_to_profile_id';
                $join_str7[0]['from_table_id'] = 'recruiter.rec_id';
                $join_str7[0]['join_type'] = '';

                $search_condition = "((rec_firstname LIKE '" . trim($usrsearchdata) . "%') AND (message_to !='" . $usrid . "' )) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";
                $tolist = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array, $data = 'message_to,rec_firstname as first_name,rec_lastname as last_name,recruiter_user_image as user_image,user_id,message', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str7, $groupby = '');
            }

            // FOR FREELANCER HIRE POST 

            if ($message_from_profile == 4) {
                // message to user
                $contition_array = array('is_delete' => '0', 'status' => '1', 'message_to !=' => $userid);

                $join_str7[0]['table'] = 'messages';
                $join_str7[0]['join_table_id'] = 'messages.message_to_profile_id';
                $join_str7[0]['from_table_id'] = 'freelancer_hire_reg.reg_id';
                $join_str7[0]['join_type'] = '';

                $search_condition = "((fullname LIKE '" . trim($usrsearchdata) . "%') AND (message_to !='" . $usrid . "' )) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";
                $tolist = $this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array, $data = 'message_to,fullname as first_name,username as last_name,freelancer_hire_user_image as user_image,user_id,message', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str7, $groupby = '');
            }

            // FOR FREELANCER POST APPLY

            if ($message_from_profile == 3) {
                // message to user
                $contition_array = array('is_delete' => '0', 'status' => '1', 'message_to !=' => $userid);

                $join_str7[0]['table'] = 'messages';
                $join_str7[0]['join_table_id'] = 'messages.message_to_profile_id';
                $join_str7[0]['from_table_id'] = 'freelancer_post_reg.freelancer_post_reg_id';
                $join_str7[0]['join_type'] = '';

                $search_condition = "((freelancer_post_fullname LIKE '" . trim($usrsearchdata) . "%') AND (message_to !='" . $usrid . "' )) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";
                $tolist = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'message_to,freelancer_post_fullname as first_name,freelancer_post_username as last_name,freelancer_post_user_image as user_image,user_id,message', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str7, $groupby = '');
            }

            // FOR BUSINESS

            if ($message_from_profile == 5) {
                // message to user
                $contition_array = array('business_profile.is_deleted' => '0', 'status' => '1', 'message_to !=' => $userid);

                $join_str7[0]['table'] = 'messages';
                $join_str7[0]['join_table_id'] = 'messages.message_to_profile_id';
                $join_str7[0]['from_table_id'] = 'business_profile.business_profile_id';
                $join_str7[0]['join_type'] = '';

                $search_condition = "((company_name LIKE '" . trim($usrsearchdata) . "%') AND (message_to !='" . $usrid . "' )) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";
                $tolist = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'message_to,company_name as first_name,business_user_image as user_image,message,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str7, $groupby = '');
            }

            // FOR ARTISTIC

            if ($message_from_profile == 6) {
                // message to user
                $contition_array = array('is_delete' => '0', 'status' => '1', 'message_to !=' => $userid);

                $join_str7[0]['table'] = 'messages';
                $join_str7[0]['join_table_id'] = 'messages.message_to_profile_id';
                $join_str7[0]['from_table_id'] = 'art_reg.art_id';
                $join_str7[0]['join_type'] = '';

                $search_condition = "((art_name LIKE '" . trim($usrsearchdata) . "%') AND (message_to !='" . $usrid . "' )) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";
                $tolist = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = 'message_to,art_name as first_name,art_lastname as last_name,art_user_image as user_image,user_id,message', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str7, $groupby = '');
            }
//echo '<pre>'; print_r($tolist); die();
            // message to user
//            $contition_array = array('is_delete' => '0', 'status' => '1', 'message_to !=' => $userid);
//
//            $join_str7[0]['table'] = 'messages';
//            $join_str7[0]['join_table_id'] = 'messages.message_to';
//            $join_str7[0]['from_table_id'] = 'user.user_id';
//            $join_str7[0]['join_type'] = '';
//
//
//            $search_condition = "((first_name LIKE '" . trim($usrsearchdata) . "%') AND (message_to !='" . $usrid . "' )) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id)";
//            $tolist = $this->common->select_data_by_search('user', $search_condition, $contition_array, $data = 'message_to,first_name,user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str7, $groupby = '');
            // uniq array of tolist  
            foreach ($tolist as $k => $v) {
                foreach ($tolist as $key => $value) {
                    if ($k != $key && $v['message_to'] == $value['message_to']) {
                        unset($tolist[$k]);
                    }
                }
            }

            // replace name of message_to in user_id

            $return_arrayto = array();

            foreach ($tolist as $to_list) {

                $return = array();
                $return = $to_list;

                $return['user_id'] = $to_list['message_to'];
                $return['first_name'] = $to_list['first_name'];
                $return['last_name'] = $to_list['last_name'];
                $return['user_image'] = $to_list['user_image'];
                $return['message'] = $to_list['message'];

                unset($return['message_to']);
                array_push($return_arrayto, $return);
            }


            // message from user
            $contition_array = array('is_delete' => '0', 'status' => '1', 'message_from !=' => $userid);
            if ($message_from_profile == 2) {
                $join_str4[0]['table'] = 'messages';
                $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
                $join_str4[0]['from_table_id'] = 'job_reg.job_id';
                $join_str4[0]['join_type'] = '';

                $search_condition = "((fname LIKE '" . trim($usrsearchdata) . "%') AND (message_from !='" . $usrid . "' )) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";

                $fromlist = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,fname as first_name,lname as last_name,job_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
            }
            if ($message_from_profile == 1) {
                $join_str4[0]['table'] = 'messages';
                $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
                $join_str4[0]['from_table_id'] = 'recruiter.rec_id';
                $join_str4[0]['join_type'] = '';
                $contition_array = array('is_delete' => '0', 're_status' => '1');

                $search_condition = "((rec_firstname LIKE '" . trim($usrsearchdata) . "%') AND (message_from !='" . $usrid . "' )) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";

                $fromlist = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array, $data = 'messages.id,message_from,rec_firstname as first_name,rec_lastname as last_name,recruiter_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
            }
            if ($message_from_profile == 4) {
                $join_str4[0]['table'] = 'messages';
                $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
                $join_str4[0]['from_table_id'] = 'freelancer_hire_reg.reg_id';
                $join_str4[0]['join_type'] = '';

                $search_condition = "((username LIKE '" . trim($usrsearchdata) . "%') AND (message_from !='" . $usrid . "' )) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";

                $fromlist = $this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,username as last_name,fullname as first_name,freelancer_hire_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
            }
            if ($message_from_profile == 3) {
                $join_str4[0]['table'] = 'messages';
                $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
                $join_str4[0]['from_table_id'] = 'freelancer_post_reg.freelancer_post_reg_id';
                $join_str4[0]['join_type'] = '';

                $search_condition = "((freelancer_post_fullname LIKE '" . trim($usrsearchdata) . "%') AND (message_from !='" . $usrid . "' )) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";

                $fromlist = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,freelancer_post_fullname as first_name,freelancer_post_username as last_name,freelancer_post_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
            }
            if ($message_from_profile == 5) {
                $join_str4[0]['table'] = 'messages';
                $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
                $join_str4[0]['from_table_id'] = 'business_profile.business_profile_id';
                $join_str4[0]['join_type'] = '';
                $contition_array = array('business_profile.is_deleted' => '0', 'status' => '1');

                $search_condition = "((company_name LIKE '" . trim($usrsearchdata) . "%') AND (message_from !='" . $usrid . "' )) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";

                $fromlist = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'messages.id,message_from,company_name as first_name,business_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
            }
            if ($message_from_profile == 6) {
                $join_str4[0]['table'] = 'messages';
                $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
                $join_str4[0]['from_table_id'] = 'art_reg.art_id';
                $join_str4[0]['join_type'] = '';

                $search_condition = "((art_name LIKE '" . trim($usrsearchdata) . "%') AND (message_from !='" . $usrid . "' )) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";

                $fromlist = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,art_name as first_name,art_lastname as last_name,art_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
            }



            // uniq array of fromlist  
            foreach ($fromlist as $k => $v) {
                foreach ($fromlist as $key => $value) {
                    if ($k != $key && $v['message_from'] == $value['message_from']) {
                        unset($fromlist[$k]);
                    }
                }
            }

// replace name of message_to in user_id

            $return_arrayfrom = array();

            foreach ($fromlist as $from_list) {

                $return = array();
                $return = $from_list;

                $return['user_id'] = $from_list['message_from'];
                $return['first_name'] = $from_list['first_name'];
                $return['last_name'] = $from_list['last_name'];
                $return['user_image'] = $from_list['user_image'];
                $return['message'] = $from_list['message'];


                unset($return['message_from']);
                array_push($return_arrayfrom, $return);
            }



            $userlist = array_merge($return_arrayto, $return_arrayfrom);


            // uniq array of fromlist  
            foreach ($userlist as $k => $v) {
                foreach ($userlist as $key => $value) {
                    if ($v['user_id'] != $userid) {
                        if ($k != $key && $v['user_id'] == $value['user_id']) {
                            unset($userlist[$k]);
                        }
                    } else {
                        $userlist = array();
                    }
                }
            }

            if ($userlist) {

                foreach ($userlist as $user) {
                    $usrsrch .= '<a href="' . base_url() . 'chat/abc/' . $message_from_profile . '/' . $message_to_profile . '/' . $user['user_id'] . '">';
                    $usrsrch .= '<li class="clearfix">';

                    if ($message_from_profile == 2) {
                        $image_path = FCPATH . 'uploads/job_profile/thumbs/' . $user['user_image'];
                        $user_image = FCPATH . 'uploads/job_profile/thumbs/' . $user['user_image'];
                    }
                    if ($message_from_profile == 1) {
                        $image_path = FCPATH . 'uploads/recruiter_profile/thumbs/' . $user['user_image'];
                        $user_image = base_url() . 'uploads/recruiter_profile/thumbs/' . $user['user_image'];
                    }
                    if ($message_from_profile == 4) {
                        $image_path = FCPATH . 'uploads/freelancer_hire_profile/thumbs/' . $user['user_image'];
                        $user_image = base_url() . 'uploads/freelancer_hire_profile/thumbs/' . $user['user_image'];
                    }
                    if ($message_from_profile == 3) {
                        $image_path = FCPATH . 'uploads/freelancer_post_profile/thumbs/' . $user['user_image'];
                        $user_image = base_url() . 'uploads/freelancer_post_profile/thumbs/' . $user['user_image'];
                    }
                    if ($message_from_profile == 5) {
                        $image_path = FCPATH . 'uploads/business_profile/thumbs/' . $user['user_image'];
                        $user_image = base_url() . 'uploads/business_profile/thumbs/' . $user['user_image'];
                    }
                    if ($message_from_profile == 6) {
                        $image_path = FCPATH . 'uploads/artistic_profile/thumbs/' . $user['user_image'];
                        $user_image = base_url() . 'uploads/artistic_profile/thumbs/' . $user['user_image'];
                    }
                    if ($user['user_image'] && (file_exists($image_path)) == 1) {

                        $usrsrch .= '    <div class="chat_heae_img">';

                        $usrsrch .= '<img src="' . $user_image . '" alt="' . $user['first_name'] . '" height="50px" weight="50px" />';
                        $usrsrch .= '</div>';
                    } else {
                        $a = $user['first_name'];
                        $b = $user['last_name'];
                        $acr = substr($a, 0, 1);
                        $bcr = substr($b, 0, 1);

                        $usrsrch .= '<div class="post-img-div">';
                        $usrsrch .= '' . ucwords($acr) . ucwords($bcr) . '';
                        $usrsrch .= '</div>';
                    }

                    $usrsrch .= '<div class="about">';
                    $usrsrch .= '<div class="name">';


                    $username = substr($user['first_name'] . ' ' . $user['last_name'], 0, 25);
                    $usrsrch .= '' . $username . '';
                    if (strlen($user['first_name'] . $user['last_name']) > 15) {
                        $usrsrch .= ' ...';
                    }
                    $usrsrch .= '<br>';
                    $usrsrch .= '</div><div class="status" style=" width: 240px;
    color: #003;    max-height: 20px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
">';
                    $message = str_replace('\\r', '', $user['message']);
                    $message = preg_replace('[^(<br( \/)?>)*|(<br( \/)?>)*$]', '', $message);
                    $message = str_replace('\\t', '', $message);
                    $message = str_replace('\\', '', $message);
                    $message = str_replace('%26amp;', '&', $message);
                    $message = str_replace('%26gt;', '>', $message);
                    $message = str_replace('%26lt;', '<', $message);

                    $usrsrch .= '' . $message . '';
                    $usrsrch .= '</div></div></li></a>';
                }
            } else {

                $usrsrch .= '<div class="notac_a">No user available.. !!</div>';
            }
        } else {

            // 17-5-2017 start
            $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

            // last user if $id is null
            $contition_array = array('id !=' => '');
            $search_condition = "(message_from = '$userid' OR message_to = '$userid') AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";
            $lastchat = $this->common->select_data_by_search('messages', $search_condition, $contition_array, $data = 'messages.message_from,message_to,id', $sortby = 'id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = '', $groupby = '');

            if ($id) {
                $toid = $this->data['toid'] = $id;
            } elseif ($lastchat[0]['message_from'] == $userid) {
                $toid = $this->data['toid'] = $lastchat[0]['message_to'];
            } else {
                $toid = $this->data['toid'] = $lastchat[0]['message_from'];
            }

            // khyati 22-4 changes end

            if ($message_from_profile == 1) {
                $loginuser = $this->common->select_data_by_id('job_reg', 'user_id', $userid, $data = 'fname as first_name,lname as last_name,user_id');
            }

            if ($message_from_profile == 2) {
                $loginuser = $this->common->select_data_by_id('recruiter', 'user_id', $userid, $data = 'rec_firstname as first_name,rec_lastname as last_name,user_id');
            }

            if ($message_from_profile == 3) {
                $loginuser = $this->common->select_data_by_id('freelancer_hire_reg', 'user_id', $userid, $data = 'username as last_name,fullname as first_name,user_id');
            }

            if ($message_from_profile == 4) {
                $loginuser = $this->common->select_data_by_id('freelancer_post_reg', 'user_id', $userid, $data = 'freelancer_post_fullname as first_name,freelancer_post_username as last_name,user_id');
            }

            if ($message_from_profile == 5) {
                $loginuser = $this->common->select_data_by_id('business_profile', 'user_id', $userid, $data = 'company_name as first_name,user_id');
            }

            if ($message_from_profile == 6) {
                $loginuser = $this->common->select_data_by_id('art_reg', 'user_id', $userid, $data = 'art_name as first_name,art_lastname as last_name,user_id');
            }

//            $loginuser = $this->common->select_data_by_id('user', 'user_id', $userid, $data = 'first_name,last_name');

            $this->data['logfname'] = $loginuser[0]['first_name'];
            $this->data['loglname'] = $loginuser[0]['last_name'];

            // last message user fetch

            $contition_array = array('id !=' => '');
            $search_condition = "(message_from = '$id' OR message_to = '$id') AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";
            $lastuser = $this->common->select_data_by_search('messages', $search_condition, $contition_array, $data = 'messages.message_from,message_to,id', $sortby = 'id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = '', $groupby = '');

            if ($lastuser[0]['message_from'] == $userid) {
                $lstusr = $this->data['lstusr'] = $lastuser[0]['message_to'];
            } else {
                $lstusr = $this->data['lstusr'] = $lastuser[0]['message_from'];
            }
            // last user first name last name
            if ($lstusr) {

                if ($message_from_profile == 1) {
                    $lastuser = $this->common->select_data_by_id('job_reg', 'user_id', $lstusr, $data = 'fname as first_name,lname as last_name,user_id');
                }

                if ($message_from_profile == 2) {
                    $lastuser = $this->common->select_data_by_id('recruiter', 'user_id', $lstusr, $data = 'rec_firstname as first_name,rec_lastname as last_name,user_id');
                }

                if ($message_from_profile == 3) {
                    $lastuser = $this->common->select_data_by_id('freelancer_hire_reg', 'user_id', $lstusr, $data = 'username as last_name,fullname as first_name,user_id');
                }

                if ($message_from_profile == 4) {
                    $lastuser = $this->common->select_data_by_id('freelancer_post_reg', 'user_id', $lstusr, $data = 'freelancer_post_fullname as first_name,freelancer_post_username as last_name,user_id');
                }

                if ($message_from_profile == 5) {
                    $lastuser = $this->common->select_data_by_id('business_profile', 'user_id', $lstusr, $data = 'company_name as first_name,user_id');
                }

                if ($message_from_profile == 6) {
                    $lastuser = $this->common->select_data_by_id('art_reg', 'user_id', $lstusr, $data = 'art_name as first_name,art_lastname as last_name,user_id');
                }

//                $lastuser = $this->common->select_data_by_id('user', 'user_id', $lstusr, $data = 'first_name,last_name');
                $this->data['lstfname'] = $lastuser[0]['first_name'];
                $this->data['lstlname'] = $lastuser[0]['last_name'];
            }
            //khyati changes starrt 20-4
            // slected user chat to

            $contition_array = array('is_delete' => '0', 'status' => '1');
            $search_condition = "((message_from = '$id' OR message_to = '$id') && (message_to != '$userid')) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";

            if ($message_from_profile == 1) {
                $join_str1[0]['table'] = 'messages';
                $join_str1[0]['join_table_id'] = 'messages.message_to_profile_id';
                $join_str1[0]['from_table_id'] = 'job_reg.job_id';
                $join_str1[0]['join_type'] = '';

                $seltousr = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,fname as first_name,lname as last_name,job_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
            }
            if ($message_from_profile == 2) {
                $join_str1[0]['table'] = 'messages';
                $join_str1[0]['join_table_id'] = 'messages.message_to_profile_id';
                $join_str1[0]['from_table_id'] = 'recruiter.rec_id';
                $join_str1[0]['join_type'] = '';
                $contition_array = array('is_delete' => '0', 're_status' => '1');
                $seltousr = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array, $data = 'messages.id,message_to,rec_firstname as first_name,rec_lastname as last_name,recruiter_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
            }
            if ($message_from_profile == 3) {
                $join_str1[0]['table'] = 'messages';
                $join_str1[0]['join_table_id'] = 'messages.message_to_profile_id';
                $join_str1[0]['from_table_id'] = 'freelancer_hire_reg.reg_id';
                $join_str1[0]['join_type'] = '';

                $seltousr = $this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,username as last_name,fullname as first_name,freelancer_hire_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
            }
            if ($message_from_profile == 4) {
                $join_str1[0]['table'] = 'messages';
                $join_str1[0]['join_table_id'] = 'messages.message_to_profile_id';
                $join_str1[0]['from_table_id'] = 'freelancer_post_reg.freelancer_post_reg_id';
                $join_str1[0]['join_type'] = '';

                $seltousr = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,freelancer_post_fullname as first_name,freelancer_post_username as last_name,freelancer_post_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
            }
            if ($message_from_profile == 5) {
                $join_str1[0]['table'] = 'messages';
                $join_str1[0]['join_table_id'] = 'messages.message_to_profile_id';
                $join_str1[0]['from_table_id'] = 'business_profile.business_profile_id';
                $join_str1[0]['join_type'] = '';
                $contition_array = array('business_profile.is_deleted' => '0', 'status' => '1');
                $seltousr = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'messages.id,message_to,company_name as first_name,business_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
            }
            if ($message_from_profile == 6) {
                $join_str1[0]['table'] = 'messages';
                $join_str1[0]['join_table_id'] = 'messages.message_to_profile_id';
                $join_str1[0]['from_table_id'] = 'art_reg.art_id';
                $join_str1[0]['join_type'] = '';

                $seltousr = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,art_name as first_name,art_lastname as last_name,art_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
            }

            // slected user chat from

            $contition_array = array('is_delete' => '0', 'status' => '1');
            $search_condition = "((message_from = '$id' OR message_to = '$id') && (message_from != '$userid')) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";

            //20-7-2017@nkit
            if ($message_from_profile == 1) {
                $join_str2[0]['table'] = 'messages';
                $join_str2[0]['join_table_id'] = 'messages.message_from_profile_id';
                $join_str2[0]['from_table_id'] = 'job_reg.job_id';
                $join_str2[0]['join_type'] = '';

                $selfromusr = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,fname as first_name,lname as last_name,job_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
            }
            if ($message_from_profile == 2) {
                $join_str2[0]['table'] = 'messages';
                $join_str2[0]['join_table_id'] = 'messages.message_from_profile_id';
                $join_str2[0]['from_table_id'] = 'recruiter.rec_id';
                $join_str2[0]['join_type'] = '';
                $contition_array = array('is_delete' => '0', 're_status' => '1');
                $selfromusr = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array, $data = 'messages.id,message_from,rec_firstname as first_name,rec_lastname as last_name,recruiter_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
            }
            if ($message_from_profile == 3) {
                $join_str2[0]['table'] = 'messages';
                $join_str2[0]['join_table_id'] = 'messages.message_from_profile_id';
                $join_str2[0]['from_table_id'] = 'freelancer_hire_reg.reg_id';
                $join_str2[0]['join_type'] = '';

                $selfromusr = $this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,username as last_name,fullname as first_name,freelancer_hire_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
            }
            if ($message_from_profile == 4) {
                $join_str2[0]['table'] = 'messages';
                $join_str2[0]['join_table_id'] = 'messages.message_from_profile_id';
                $join_str2[0]['from_table_id'] = 'freelancer_post_reg.freelancer_post_reg_id';
                $join_str2[0]['join_type'] = '';

                $selfromusr = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,freelancer_post_fullname as first_name,freelancer_post_username as last_name,freelancer_post_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
            }
            if ($message_from_profile == 5) {
                $join_str2[0]['table'] = 'messages';
                $join_str2[0]['join_table_id'] = 'messages.message_from_profile_id';
                $join_str2[0]['from_table_id'] = 'business_profile.business_profile_id';
                $join_str2[0]['join_type'] = '';
                $contition_array = array('business_profile.is_deleted' => '0', 'status' => '1');
                $selfromusr = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'messages.id,message_from,company_name as first_name,business_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
            }
            if ($message_from_profile == 6) {
                $join_str2[0]['table'] = 'messages';
                $join_str2[0]['join_table_id'] = 'messages.message_from_profile_id';
                $join_str2[0]['from_table_id'] = 'art_reg.art_id';
                $join_str2[0]['join_type'] = '';

                $selfromusr = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,art_name as first_name,art_lastname as last_name,art_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
            }


            $selectuser = array_merge($seltousr, $selfromusr);
            $selectuser = $this->aasort($selectuser, "id");

            // replace name of message_to in user_id in select user

            $return_arraysel = array();
            $i = 0;
            foreach ($selectuser as $k => $sel_list) {
                $return = array();
                $return = $sel_list;

                if ($sel_list['message_to']) {

                    $return['user_id'] = $sel_list['message_to'];
                    $return['first_name'] = $sel_list['first_name'];
                    $return['last_name'] = $sel_list['last_name'];
                    $return['user_image'] = $sel_list['user_image'];
                    $return['message'] = $sel_list['message'];

                    unset($return['message_to']);
                } else {

                    $return['user_id'] = $sel_list['message_from'];
                    $return['first_name'] = $sel_list['first_name'];
                    $return['last_name'] = $sel_list['last_name'];
                    $return['user_image'] = $sel_list['user_image'];
                    $return['message'] = $sel_list['message'];


                    unset($return['message_from']);
                }
                array_push($return_arraysel, $return);
                $i++;
                if ($i == 1)
                    break;
            }
            // message to user
            $contition_array = array('is_delete' => '0', 'status' => '1', 'message_to !=' => $userid);
            $search_condition = "((message_from = '$userid') && (message_to != '$id')) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";

            if ($message_from_profile == 2) {
                $join_str3[0]['table'] = 'messages';
                $join_str3[0]['join_table_id'] = 'messages.message_to_profile_id';
                $join_str3[0]['from_table_id'] = 'job_reg.job_id';
                $join_str3[0]['join_type'] = '';

                $tolist = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,fname as first_name,lname as last_name,job_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
            }
            if ($message_from_profile == 1) {
                $join_str3[0]['table'] = 'messages';
                $join_str3[0]['join_table_id'] = 'messages.message_to_profile_id';
                $join_str3[0]['from_table_id'] = 'recruiter.rec_id';
                $join_str3[0]['join_type'] = '';
                $contition_array = array('is_delete' => '0', 're_status' => '1');
                $tolist = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array, $data = 'messages.id,message_to,rec_firstname as first_name,rec_lastname as last_name,recruiter_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
            }
            if ($message_from_profile == 4) {
                $join_str3[0]['table'] = 'messages';
                $join_str3[0]['join_table_id'] = 'messages.message_to_profile_id';
                $join_str3[0]['from_table_id'] = 'freelancer_hire_reg.reg_id';
                $join_str3[0]['join_type'] = '';

                $tolist = $this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,username as last_name,fullname as first_name,freelancer_hire_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
            }
            if ($message_from_profile == 3) {
                $join_str3[0]['table'] = 'messages';
                $join_str3[0]['join_table_id'] = 'messages.message_to_profile_id';
                $join_str3[0]['from_table_id'] = 'freelancer_post_reg.freelancer_post_reg_id';
                $join_str3[0]['join_type'] = '';

                $tolist = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,freelancer_post_fullname as first_name,freelancer_post_username as last_name,freelancer_post_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
            }
            if ($message_from_profile == 5) {
                $join_str3[0]['table'] = 'messages';
                $join_str3[0]['join_table_id'] = 'messages.message_to_profile_id';
                $join_str3[0]['from_table_id'] = 'business_profile.business_profile_id';
                $join_str3[0]['join_type'] = '';
                $contition_array = array('business_profile.is_deleted' => '0', 'status' => '1');
                $tolist = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'messages.id,message_to,company_name as first_name,business_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
            }
            if ($message_from_profile == 6) {
                $join_str3[0]['table'] = 'messages';
                $join_str3[0]['join_table_id'] = 'messages.message_to_profile_id';
                $join_str3[0]['from_table_id'] = 'art_reg.art_id';
                $join_str3[0]['join_type'] = '';

                $tolist = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,art_name as first_name,art_lastname as last_name,art_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
            }

            // uniq array of tolist  
            foreach ($tolist as $k => $v) {
                foreach ($tolist as $key => $value) {

                    if ($k != $key && $v['message_to'] == $value['message_to']) {
                        unset($tolist[$k]);
                    }
                }
            }

            // replace name of message_to in user_id

            $return_arrayto = array();

            foreach ($tolist as $to_list) {
                if ($to_list['message_to'] != $id) {
                    $return = array();
                    $return = $to_list;

                    $return['user_id'] = $to_list['message_to'];
                    $return['first_name'] = $to_list['first_name'];
                    $return['user_image'] = $to_list['user_image'];
                    $return['message'] = $to_list['message'];

                    unset($return['message_to']);
                    array_push($return_arrayto, $return);
                }
            }

            // message from user
            $contition_array = array('is_delete' => '0', 'status' => '1', 'message_from !=' => $userid);
            $search_condition = "((message_to = '$userid') && (message_from != '$id')) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";

            if ($message_from_profile == 2) {
                $join_str4[0]['table'] = 'messages';
                $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
                $join_str4[0]['from_table_id'] = 'job_reg.job_id';
                $join_str4[0]['join_type'] = '';

                $fromlist = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,fname as first_name,lname as last_name,job_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
            }
            if ($message_from_profile == 1) {
                $join_str4[0]['table'] = 'messages';
                $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
                $join_str4[0]['from_table_id'] = 'recruiter.rec_id';
                $join_str4[0]['join_type'] = '';
                $contition_array = array('is_delete' => '0', 're_status' => '1');
                $fromlist = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array, $data = 'messages.id,message_from,rec_firstname as first_name,rec_lastname as last_name,recruiter_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
            }
            if ($message_from_profile == 4) {
                $join_str4[0]['table'] = 'messages';
                $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
                $join_str4[0]['from_table_id'] = 'freelancer_hire_reg.reg_id';
                $join_str4[0]['join_type'] = '';

                $fromlist = $this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,username as last_name,fullname as first_name,freelancer_hire_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
            }
            if ($message_from_profile == 3) {
                $join_str4[0]['table'] = 'messages';
                $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
                $join_str4[0]['from_table_id'] = 'freelancer_post_reg.freelancer_post_reg_id';
                $join_str4[0]['join_type'] = '';

                $fromlist = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,freelancer_post_fullname as first_name,freelancer_post_username as last_name,freelancer_post_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
            }
            if ($message_from_profile == 5) {
                $join_str4[0]['table'] = 'messages';
                $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
                $join_str4[0]['from_table_id'] = 'business_profile.business_profile_id';
                $join_str4[0]['join_type'] = '';
                $contition_array = array('business_profile.is_deleted' => '0', 'status' => '1');
                $fromlist = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'messages.id,message_from,company_name as first_name,business_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
            }
            if ($message_from_profile == 6) {
                $join_str4[0]['table'] = 'messages';
                $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
                $join_str4[0]['from_table_id'] = 'art_reg.art_id';
                $join_str4[0]['join_type'] = '';

                $fromlist = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,art_name as first_name,art_lastname as last_name,art_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
            }

            // uniq array of fromlist  
            foreach ($fromlist as $k => $v) {
                foreach ($fromlist as $key => $value) {
                    if ($k != $key && $v['message_from'] == $value['message_from']) {
                        unset($fromlist[$k]);
                    }
                }
            }
            // replace name of message_to in user_id

            $return_arrayfrom = array();

            foreach ($fromlist as $from_list) {
                if ($from_list['message_from'] != $id) {
                    $return = array();
                    $return = $from_list;

                    $return['user_id'] = $from_list['message_from'];
                    $return['first_name'] = $from_list['first_name'];
                    $return['last_name'] = $from_list['last_name'];
                    $return['user_image'] = $from_list['user_image'];
                    $return['message'] = $from_list['message'];

                    unset($return['message_from']);
                    array_push($return_arrayfrom, $return);
                }
            }

            $userlist = array_merge($return_arrayto, $return_arrayfrom);

            // uniq array of fromlist  
            foreach ($userlist as $k => $v) {
                foreach ($userlist as $key => $value) {
                    if ($k != $key && $v['user_id'] == $value['user_id']) {
                        unset($userlist[$k]);
                    }
                }
            }

            $userlist = $this->aasort($userlist, "id");
            $userlist = array_merge($return_arraysel, $userlist);
            if (in_array($toid, $userlist)) {
                foreach ($userlist as $user) {
                    $usrsrch .= '<li class="clearfix">';
                    if ($user['user_id'] == $toid) {
                        $usrsrch .= 'active';
                    }
                    $usrsrch .= '">';

                    if ($message_from_profile == 2) {
                        $image_path = FCPATH . 'uploads/job_profile/thumbs/' . $user['user_image'];
                        $user_image = base_url() . 'uploads/job_profile/thumbs/' . $user['user_image'];
                    }
                    if ($message_from_profile == 1) {
                        $image_path = FCPATH . 'uploads/recruiter_profile/thumbs/' . $user['user_image'];
                        $user_image = base_url() . 'uploads/recruiter_profile/thumbs/' . $user['user_image'];
                    }
                    if ($message_from_profile == 4) {
                        $image_path = FCPATH . 'uploads/freelancer_hire_profile/thumbs/' . $user['user_image'];
                        $user_image = base_url() . 'uploads/freelancer_hire_profile/thumbs/' . $user['user_image'];
                    }
                    if ($message_from_profile == 3) {
                        $image_path = FCPATH . 'uploads/freelancer_post_profile/thumbs/' . $user['user_image'];
                        $user_image = base_url() . 'uploads/freelancer_post_profile/thumbs/' . $user['user_image'];
                    }
                    if ($message_from_profile == 5) {
                        $image_path = FCPATH . 'uploads/business_profile/thumbs/' . $user['user_image'];
                        $user_image = base_url() . 'uploads/business_profile/thumbs/' . $user['user_image'];
                    }
                    if ($message_from_profile == 6) {
                        $image_path = FCPATH . 'uploads/artistic_profile/thumbs/' . $user['user_image'];
                        $user_image = base_url() . 'uploads/artistic_profile/thumbs/' . $user['user_image'];
                    }
                    if ($user['user_image'] && (file_exists($image_path)) == 1) {

                        $usrsrch .= '<div class="chat_heae_img">';
                        $usrsrch .= '<img src="' . $user_image . '" alt="' . $user['first_name'] . '" height="50px" weight="50px">';
                        $usrsrch .= '</div>';
                    } else {
                        $a = $user['first_name'];
                        $b = $user['last_name'];
                        $acr = substr($a, 0, 1);
                        $bcr = substr($b, 0, 1);

                        $usrsrch .= '<div class="post-img-div">';
                        $usrsrch .= '' . ucwords($acr) . ucwords($bcr) . '';
                        $usrsrch .= '</div>';
                    }
                    $usrsrch .= '<div class="about">';
                    $usrsrch .= '<div class="name">';
                    $usrsrch .= '<a href="' . base_url() . 'chat/abc/' . $message_from_profile . '/' . $message_to_profile . '/' . $user['user_id'] . '">';
//                    $usrsrch .= '<a href="' . base_url() . 'chat/abc/' . $user['user_id'] . '/' . $message_from_profile . '/' . $message_to_profile . '">'; 
                    $username = substr($user['first_name'] . ' ' . $user['last_name'], 0, 25);
                    $usrsrch .= '' . $username . '';
                    if (strlen($user['first_name'] . ' ' . $user['last_name']) > 15) {
                        $usrsrch .= ' ...';
                    }

                    $usrsrch .= '<br></a> </div>';
                    $usrsrch .= '<div class="status' . $user['user_id'] . '" style=" width: 240px;    max-height: 20px;
    color: #003;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
">';
                    $usrsrch .= '' . str_replace('\\', '', $user['message']) . '';
                    $usrsrch .= '</div>';
                    $usrsrch .= '</div>';
                    $usrsrch .= '</li>';
                }
            } else {

                if ($message_from_profile == 2) {
                    $lstusrdata = $this->common->select_data_by_id('job_reg', 'user_id', $toid, $data = 'fname as first_name,lname as last_name,user_id,job_user_image as user_image');
                }
                if ($message_from_profile == 1) {
                    $lstusrdata = $this->common->select_data_by_id('recruiter', 'user_id', $toid, $data = 'rec_firstname as first_name,rec_lastname as last_name,user_id,recruiter_user_image as user_image');
                }
                if ($message_from_profile == 4) {
                    $lstusrdata = $this->common->select_data_by_id('freelancer_hire_reg', 'user_id', $toid, $data = 'username as last_name,fullname as first_name,user_id,freelancer_hire_user_image as user_image');
                }
                if ($message_from_profile == 3) {
                    $lstusrdata = $this->common->select_data_by_id('freelancer_post_reg', 'user_id', $toid, $data = 'freelancer_post_fullname as first_name,freelancer_post_username as last_name,user_id,freelancer_post_user_image as user_image');
                }
                if ($message_from_profile == 5) {
                    $lstusrdata = $this->common->select_data_by_id('business_profile', 'user_id', $toid, $data = 'company_name as first_name,user_id,business_user_image as user_image');
                }
                if ($message_from_profile == 6) {
                    $lstusrdata = $this->common->select_data_by_id('art_reg', 'user_id', $toid, $data = 'art_name as first_name,art_lastname as last_name,user_id,art_user_image as user_image');
                }

                if ($lstusrdata) {
                    $usrsrch .= '<li class="clearfix ';
                    if ($lstusrdata[0]['user_id'] == $toid) {
                        $usrsrch .= 'active';
                    } $usrsrch .= '">';

                    if ($message_from_profile == 2) {
                        $image_path = FCPATH . 'uploads/job_profile/thumbs/' . $lstusrdata[0]['user_image'];
                        $user_image = base_url() . 'uploads/job_profile/thumbs/' . $lstusrdata[0]['user_image'];
                    }
                    if ($message_from_profile == 1) {
                        $image_path = FCPATH . 'uploads/recruiter_profile/thumbs/' . $lstusrdata[0]['user_image'];
                        $user_image = base_url() . 'uploads/recruiter_profile/thumbs/' . $lstusrdata[0]['user_image'];
                    }
                    if ($message_from_profile == 4) {
                        $image_path = FCPATH . 'uploads/freelancer_hire_profile/thumbs/' . $lstusrdata[0]['user_image'];
                        $user_image = base_url() . 'uploads/freelancer_hire_profile/thumbs/' . $lstusrdata[0]['user_image'];
                    }
                    if ($message_from_profile == 3) {
                        $image_path = FCPATH . 'uploads/freelancer_post_profile/thumbs/' . $lstusrdata[0]['user_image'];
                        $user_image = base_url() . 'uploads/freelancer_post_profile/thumbs/' . $lstusrdata[0]['user_image'];
                    }
                    if ($message_from_profile == 5) {
                        $image_path = FCPATH . 'uploads/business_profile/thumbs/' . $lstusrdata[0]['user_image'];
                        $user_image = base_url() . 'uploads/business_profile/thumbs/' . $lstusrdata[0]['user_image'];
                    }
                    if ($message_from_profile == 6) {
                        $image_path = FCPATH . 'uploads/artistic_profile/thumbs/' . $lstusrdata[0]['user_image'];
                        $user_image = base_url() . 'uploads/artistic_profile/thumbs/' . $lstusrdata[0]['user_image'];
                    }
                    if ($user_image && (file_exists($image_path)) == 1) {
                        $usrsrch .= '<div class="chat_heae_img">';
                        $usrsrch .= '<img src="' . $user_image . '" alt="' . $lstusrdata[0]['first_name'] . '" height="50px" weight="50px">';
                        $usrsrch .= '</div>';
                    } else {
                        $a = $lstusrdata[0]['first_name'];
                        $b = $lstusrdata[0]['last_name'];
                        $acr = substr($a, 0, 1);
                        $bcr = substr($b, 0, 1);

                        $usrsrch .= '<div class="post-img-div">';
                        $usrsrch .= '' . ucwords($acr) . ucwords($bcr) . '';
                        $usrsrch .= '</div>';
                    }
                    $usrsrch .= '<div class="about">';
                    $usrsrch .= '<div class="name">';
                    $usrsrch .= '<a href="' . base_url() . 'chat/abc/' . $message_from_profile . '/' . $message_to_profile . '/' . $lstusrdata[0]['user_id'] . '">';
                    //     $usrsrch .= '<a href="' . base_url() . 'chat/abc/' . $lstusrdata[0]['user_id'] . '/' . $message_from_profile . '/' . $message_to_profile . '">' . $lstusrdata[0]['first_name'] . ' ' . $lstusrdata[0]['last_name'] . '<br></a> </div>';
                    $usrsrch .= '<div class="status' . $lstusrdata[0]['user_id'] . '" style=" width: 240px;    max-height: 20px;
    color: #003;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
">';
                    $search_condition = "((message_from = '$userid' AND message_to = '$toid') OR (message_to = '$userid' AND message_from = '$toid'))";
                    $contition_array = array('id !=' => '');
                    $messages = $this->common->select_data_by_search('messages', $search_condition, $contition_array, $data = '*', $sortby = 'id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = '', $groupby = '');


                    $usrsrch .= '' . str_replace('\\', '', $messages[0]['message']) . '';

                    $usrsrch .= '</div>
          </div>
        </li>';
                }
                foreach ($userlist as $user) {
                    if ($user['user_id'] != $toid) {
                        $usrsrch .= '<a href="' . base_url() . 'chat/abc/' . $message_from_profile . '/' . $message_to_profile . '/' . $user['user_id'] . '">';
                        //    $usrsrch .= '<a href="' . base_url() . 'chat/abc/' . $user['user_id'] . '/' . $message_from_profile . '/' . $message_to_profile . '">';
                        $usrsrch = '<li class="clearfix">';
                        if ($user['user_id'] == $toid) {
                            $usrsrch .= 'class ="active"';
                        }

                        $usrsrch .= '<div class="chat_heae_img">';
                        if ($message_from_profile == 2) {
                            $image_path = FCPATH . 'uploads/job_profile/thumbs/' . $user['user_image'];
                            $user_image = base_url() . 'uploads/job_profile/thumbs/' . $user['user_image'];
                        }
                        if ($message_from_profile == 1) {
                            $image_path = FCPATH . 'uploads/recruiter_profile/thumbs/' . $user['user_image'];
                            $user_image = base_url() . 'uploads/recruiter_profile/thumbs/' . $user['user_image'];
                        }
                        if ($message_from_profile == 4) {
                            $image_path = FCPATH . 'uploads/freelancer_hire_profile/thumbs/' . $user['user_image'];
                            $user_image = base_url() . 'uploads/freelancer_hire_profile/thumbs/' . $user['user_image'];
                        }
                        if ($message_from_profile == 3) {
                            $image_path = FCPATH . 'uploads/freelancer_post_profile/thumbs/' . $user['user_image'];
                            $user_image = base_url() . 'uploads/freelancer_post_profile/thumbs/' . $user['user_image'];
                        }
                        if ($message_from_profile == 5) {
                            $image_path = FCPATH . 'uploads/business_profile/thumbs/' . $user['user_image'];
                            $user_image = base_url() . 'uploads/business_profile/thumbs/' . $user['user_image'];
                        }
                        if ($message_from_profile == 6) {
                            $image_path = FCPATH . 'uploads/artistic_profile/thumbs/' . $user['user_image'];
                            $user_image = base_url() . 'uploads/artistic_profile/thumbs/' . $user['user_image'];
                        }
                        if ($user_image && (file_exists($image_path)) == 1) {
                            $usrsrch .= '<img src="' . $user_image . '" alt="' . $user['user_image'] . '" height="50px" weight="50px">';
                            $usrsrch .= '</div>';
                        } else {
                            $a = $user['first_name'];
                            $b = $user['last_name'];
                            $acr = substr($a, 0, 1);
                            $bcr = substr($b, 0, 1);

                            $usrsrch .= '<div class="post-img-div">';
                            $usrsrch .= '' . ucwords($acr) . ucwords($bcr) . '';
                            $usrsrch .= '</div>';
                        }
                        $usrsrch .= '<div class="about">';
                        $usrsrch .= '<div class="name">';
                        $usrsrch .= '' . $user['first_name'] . ' ' . $user['last_name'] . '<br></div>';
                        $usrsrch .= '<div class="status' . $user['user_id'] . '" style=" width: 240px;
    color: #003;    max-height: 20px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
">';
                        $usrsrch .= '' . str_replace('\\', '', $user['message']) . '';
                        $usrsrch .= '</div>';
                        $usrsrch .= '</div>';
                        $usrsrch .= '</li></a>';
                    }
                }
            }
        }

        echo $usrsrch;
    }

    //khyati 22-4 changes end 
    //  sort an array start
    // khyati changes start 7-4
    public function aasort(&$array, $key) {
        $sorter = array();
        $ret = array();
        reset($array);

        foreach ($array as $ii => $va) {

            $sorter[$ii] = $va[$key];
        }

        arsort($sorter);

        foreach ($sorter as $ii => $va) {

            $ret[$ii] = $array[$ii];
        }

        return $array = $ret;
    }

    public function scroll(&$array, $key) {
        $this->load->view('scroll');
    }

    public function chat_search($id, $message_from_profile, $message_to_profile) {
        // search result script start 
        // search code for job
        if ($message_from_profile == 1) {
            // code for search
            $contition_array = array('re_status' => '1');
            $results_recruiter = $this->data['results'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 're_comp_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

            $contition_array = array('status' => '1');
            $results_post = $this->data['results'] = $this->common->select_data_by_condition('rec_post', $contition_array, $data = 'post_name,other_skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

            $contition_array = array('status' => '1', 'type' => '1');
            $skill = $this->data['results'] = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
            $uni = array_merge($results_recruiter, $results_post, $skill);

            foreach ($uni as $key => $value) {
                foreach ($value as $ke => $val) {
                    if ($val != "") {
                        $result[] = $val;
                    }
                }
            }
            $results = array_unique($result);
            foreach ($results as $key => $value) {
                $result1[$key]['label'] = $value;
                $result1[$key]['value'] = $value;
            }
            $contition_array = array('status' => '1');
            $location_list = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

            foreach ($location_list as $key1 => $value1) {
                foreach ($value1 as $ke1 => $val1) {
                    $location[] = $val1;
                }
            }

            foreach ($location as $key => $value) {
                $loc[$key]['label'] = $value;
                $loc[$key]['value'] = $value;
            }

            $this->data['city_data'] = array_values($loc);
            $this->data['demo'] = array_values($result1);
        }

        // search code for recruiter
        if ($message_from_profile == 2) {
            //code for search
            $contition_array = array('status' => '1', 'user_id' => $userid);
            $edudata = $this->data['edudata'] = $this->common->select_data_by_condition('job_add_edu', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

            $contition_array = array('status' => '1', 'is_delete' => '0');
            $recdata = $this->data['results'] = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'other_skill,designation', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

            $contition_array = array('status' => '1');
            $jobdata = $this->data['results'] = $this->common->select_data_by_condition('job_add_workexp', $contition_array, $data = 'jobtitle', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

            $contition_array = array('status' => '1');
            $degreedata = $this->data['results'] = $this->common->select_data_by_condition('degree', $contition_array, $data = 'degree_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

            $contition_array = array('status' => '1');
            $streamdata = $this->data['results'] = $this->common->select_data_by_condition('stream', $contition_array, $data = 'stream_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

            $contition_array = array('status' => '1', 'type' => '1');
            $skill = $this->data['results'] = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

            $uni = array_merge($recdata, $jobdata, $degreedata, $streamdata, $skill, $edudata);
            foreach ($uni as $key => $value) {
                foreach ($value as $ke => $val) {
                    if ($val != "") {
                        $result[] = $val;
                    }
                }
            }
            foreach ($result as $key => $value) {
                $result1[$key]['label'] = $value;
                $result1[$key]['value'] = $value;
            }

            $this->data['demo'] = array_values($result1);
            $contition_array = array('status' => '1');

            $cty = $this->data['cty'] = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
            foreach ($cty as $key => $value) {
                foreach ($value as $ke => $val) {
                    if ($val != "") {
                        $resu[] = $val;
                    }
                }
            }
            $resul = array_unique($resu);
            foreach ($resul as $key => $value) {
                $res[$key]['label'] = $value;
                $res[$key]['value'] = $value;
            }

            $this->data['city_data'] = array_values($res);
        }

        // search code for freelancer hire
        if ($message_from_profile == 3) {
            // code for search
            $contition_array = array('status' => '1', 'is_delete' => '0');

            $field = $this->data['results'] = $this->common->select_data_by_condition('category', $contition_array, $data = 'category_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);


            $contition_array = array('status' => '1', 'is_delete' => '0');

            $freelancer_postdata = $this->data['results'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_otherskill,designation', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
            // echo "<pre>"; print_r($results_recruiter);die();

            $contition_array = array('status' => '1', 'type' => '1');

            $skill = $this->data['skill'] = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

            $unique = array_merge($field, $skill, $freelancer_postdata);
            // echo count($unique);
            // $this->data['demo']=$unique;


            foreach ($unique as $key => $value) {
                foreach ($value as $ke => $val) {
                    if ($val != "") {


                        $result[] = $val;
                    }
                }
            }
            $results = array_unique($result);
            foreach ($results as $key => $value) {

                $result1[$key]['label'] = $value;
                $result1[$key]['value'] = $value;
            }
            // echo "<pre>"; print_r($result1);die();


            $contition_array = array('status' => '1');
            $location_list = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);


            foreach ($location_list as $key1 => $value1) {
                foreach ($value1 as $ke1 => $val1) {
                    $location[] = $val1;
                }
            }
            //echo "<pre>"; print_r($location);die();
            foreach ($location as $key => $value) {
                $loc[$key]['label'] = $value;
                $loc[$key]['value'] = $value;
            }

            //echo "<pre>"; print_r($loc);die();
            //echo "<pre>"; print_r($loc);die();
            // echo "<pre>"; print_r($result1);die();

            $this->data['city_data'] = array_values($loc);

            $this->data['demo'] = array_values($result1);
        }
        // search code for freelancer post
        if ($message_from_profile == 4) {
            //code for search
            $contition_array = array('status' => '1', 'is_delete' => '0', 'free_post_step' => 7);

            $freelancer_postdata = $this->data['results'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'designation,freelancer_post_otherskill', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
            // echo "<pre>"; print_r($freelancer_postdata);die();

            $contition_array = array('status' => '1', 'type' => '1');

            $skill = $this->data['results'] = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);


            $contition_array = array('status' => '1');

            $results_post = $this->data['results'] = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data = 'post_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

            $contition_array = array('status' => '1', 'is_delete' => '0');

            $field = $this->data['results'] = $this->common->select_data_by_condition('category', $contition_array, $data = 'category_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

            $uni = array_merge($skill, $freelancer_postdata, $field, $results_post);
            // echo count($unique);
            // $this->data['demo']=$uni;

            foreach ($uni as $key => $value) {
                foreach ($value as $ke => $val) {
                    if ($val != "") {


                        $result[] = $val;
                    }
                }
            }
            $results = array_unique($result);
            foreach ($results as $key => $value) {
                $result1[$key]['label'] = $value;
                $result1[$key]['value'] = $value;
            }


            $contition_array = array('status' => '1');
            $location_list = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);


            foreach ($location_list as $key1 => $value1) {
                foreach ($value1 as $ke1 => $val1) {
                    $location[] = $val1;
                }
            }
            //echo "<pre>"; print_r($location);die();
            foreach ($location as $key => $value) {
                $loc[$key]['label'] = $value;
                $loc[$key]['value'] = $value;
            }

            //echo "<pre>"; print_r($loc);die();

            $this->data['city_data'] = array_values($loc);


            $this->data['demo'] = array_values($result1);
        }
        // search code for business profile
        if ($message_from_profile == 5) {
            // code for search
            $contition_array = array('status' => '1', 'business_profile.is_deleted' => '0', 'business_step' => 4);


            $businessdata = $this->data['results'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'company_name,other_industrial,other_business_type', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
            // echo "<pre>";print_r($businessdata);die();


            $contition_array = array('status' => '1', 'is_delete' => '0');


            $businesstype = $this->data['results'] = $this->common->select_data_by_condition('business_type', $contition_array, $data = 'business_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
            // echo "<pre>";print_r($businesstype);

            $contition_array = array('status' => '1', 'is_delete' => '0');


            $industrytype = $this->data['results'] = $this->common->select_data_by_condition('industry_type', $contition_array, $data = 'industry_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
            // echo "<pre>";print_r($industrytype);die();
            $unique = array_merge($businessdata, $businesstype, $industrytype);
            foreach ($unique as $key => $value) {
                foreach ($value as $ke => $val) {
                    if ($val != "") {


                        $result[] = $val;
                    }
                }
            }

            $results = array_unique($result);
            foreach ($results as $key => $value) {
                $result1[$key]['label'] = $value;
                $result1[$key]['value'] = $value;
            }

            $contition_array = array('status' => '1');
            $citiesss = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);


            foreach ($citiesss as $key1) {

                $location[] = $key1['city_name'];
            }
            // echo "<pre>"; print_r($location);die();
            foreach ($location as $key => $value) {
                $loc[$key]['label'] = $value;
                $loc[$key]['value'] = $value;
            }

            //echo "<pre>"; print_r($loc);die();
            // echo "<pre>"; print_r($loc);
            // echo "<pre>"; print_r($result1);die();

            $this->data['city_data'] = $loc;
            $this->data['demo'] = array_values($result1);
        }
        // search code for artistic
        if ($message_from_profile == 6) {

            // code for search
            $contition_array = array('status' => '1', 'is_delete' => '0', 'art_step' => 4);


            $artdata = $this->data['results'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_name,art_lastname,designation,other_skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);


            $return_array = array();
            //  //echo  $return_array;

            foreach ($artdata as $get) {
                $return = array();
                $return = $get;


                $return['firstname'] = $get['art_name'] . " " . $get['art_lastname'];
                unset($return['art_name']);
                unset($return['art_lastname']);

                array_push($return_array, $return);
                //echo $returnarray; 
            }

            // $contition_array = array('status' => '1');
            // $artpost= $this->data['results'] =  $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

            $contition_array = array('status' => '1', 'type' => '2');

            $artpost = $this->data['results'] = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
            // echo "<pre>"; print_r($artpost);die();


            $uni = array_merge($return_array, $artpost);
            //   echo count($unique);


            foreach ($uni as $key => $value) {
                foreach ($value as $ke => $val) {
                    if ($val != "") {


                        $result[] = $val;
                    }
                }
            }
            $results = array_unique($result);
            foreach ($results as $key => $value) {
                $result1[$key]['label'] = $value;
                $result1[$key]['value'] = $value;
            }

            $this->data['demo'] = array_values($result1);

            $contition_array = array('status' => '1');


            $cty = $this->data['cty'] = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);


            foreach ($cty as $key => $value) {
                foreach ($value as $ke => $val) {
                    if ($val != "") {


                        $resu[] = $val;
                    }
                }
            }
            $resul = array_unique($resu);
            foreach ($resul as $key => $value) {
                $res[$key]['label'] = $value;
                $res[$key]['value'] = $value;
            }

            $this->data['city_data'] = array_values($res);
        }
    }

    public function userajax($message_from_profile = '', $message_to_profile = '', $id = '', $not_id = '') {

        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        // update notification read code end 
        // from job
        if ($message_from_profile == 1) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $message_from_profile_data = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_id,fname,lname,job_user_image,designation,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_data[0]['job_id'];

            $this->data['message_from_profile'] = 1;
            $this->data['message_to_profile'] = 2;

            // last user etail start
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 're_status' => '1');
            $last_user_data = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id,rec_firstname,rec_lastname,recruiter_user_image,designation,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->data['last_user_data']['user_profile_id'] = $last_user_data[0]['rec_id'];
            $this->data['last_user_data']['first_name'] = $last_user_data[0]['rec_firstname'];
            $this->data['last_user_data']['last_name'] = $last_user_data[0]['rec_lastname'];

           $filename = $this->config->item('rec_profile_thumb_upload_path') . $last_user_data[0]['recruiter_user_image'];
                         $s3 = new S3(awsAccessKey, awsSecretKey);
                      $user_image = $s3->getObjectInfo(bucket, $filename);
            if ($last_user_data[0]['recruiter_user_image'] && $user_image) {
                $this->data['last_user_data']['user_image'] =  REC_PROFILE_THUMB_UPLOAD_URL . $last_user_data[0]['recruiter_user_image'];
            
            } else {
                $a = $last_user_data[0]['rec_firstname'];
                $b = $last_user_data[0]['rec_lastname'];
                $acr = substr($a, 0, 1);
                $bcr = substr($b, 0, 1);
                $this->data['last_user_data']['user_image_char'] = $acr . $bcr;
            }
            $this->data['last_user_data']['user_designation'] = $last_user_data[0]['designation'] == '' ? 'Designation' : $last_user_data[0]['designation'];
            // last user detail end
        }
        if ($message_to_profile == 1) {
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $message_to_profile_data = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_id,fname,lname,job_user_image,designation,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['message_to_profile_id'] = $message_to_profile_data[0]['job_id'];
        }

        // from recruiter
        if ($message_from_profile == 2) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 're_status' => '1');
            $message_from_profile_data = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id,rec_firstname,rec_lastname,recruiter_user_image,designation,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_data[0]['rec_id'];


            $this->data['message_from_profile'] = 2;
            $this->data['message_to_profile'] = 1;



            // last user detail start
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $last_user_data = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_id,fname,lname,job_user_image,designation,user_id,designation', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->data['last_user_data']['user_profile_id'] = $last_user_data[0]['rec_id'];
            $this->data['last_user_data']['first_name'] = $last_user_data[0]['fname'];
            $this->data['last_user_data']['last_name'] = $last_user_data[0]['lname'];
           
            $filename = $this->config->item('job_profile_thumb_upload_path') . $last_user_data[0]['job_user_image'];
            $s3 = new S3(awsAccessKey, awsSecretKey);
            $user_image = $s3->getObjectInfo(bucket, $filename);
            
            if ($last_user_data[0]['job_user_image'] && $user_image) {
                $this->data['last_user_data']['user_image'] =  JOB_PROFILE_THUMB_UPLOAD_URL . $last_user_data[0]['job_user_image'];
           
                } else {
                $a = $last_user_data[0]['fname'];
                $b = $last_user_data[0]['lname'];
                $acr = substr($a, 0, 1);
                $bcr = substr($b, 0, 1);
                $this->data['last_user_data']['user_image_char'] = $acr . $bcr;
            }
            //echo $last_user_data[0]['designation']; die();
            $this->data['last_user_data']['user_designation'] = $last_user_data[0]['designation'] == '' ? 'Current Work' : $last_user_data[0]['designation'];

            // last user detail end
        }


        if ($message_to_profile == 2) {
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 're_status' => '1');
            $message_to_profile_id = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id,rec_firstname,rec_lastname,recruiter_user_image,designation,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['message_to_profile_id'] = $message_to_profile_id[0]['rec_id'];
        }

        // from freelancer hire
        if ($message_from_profile == 3) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $message_from_profile_id = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'reg_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_id[0]['reg_id'];


            $this->data['message_from_profile'] = 3;
            $this->data['message_to_profile'] = 4;

            // last user detail start
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $last_user_data = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_reg_id,freelancer_post_username,freelancer_post_fullname,freelancer_post_user_image,user_id,designation', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->data['last_user_data']['user_profile_id'] = $last_user_data[0]['freelancer_post_reg_id'];
            $this->data['last_user_data']['first_name'] = $last_user_data[0]['freelancer_post_fullname'];
            $this->data['last_user_data']['last_name'] = $last_user_data[0]['freelancer_post_username'];
            $user_image = FCPATH . 'uploads/freelancer_post_profile/thumbs/' . $last_user_data[0]['freelancer_post_user_image'];
            if ($last_user_data[0]['freelancer_post_user_image'] && (file_exists($user_image)) == 1) {
                $this->data['last_user_data']['user_image'] = base_url() . 'uploads/freelancer_post_profile/thumbs/' . $last_user_data[0]['freelancer_post_user_image'];
            } else {
                $a = $last_user_data[0]['freelancer_post_fullname'];
                $b = $last_user_data[0]['freelancer_post_username'];
                $acr = substr($a, 0, 1);
                $bcr = substr($b, 0, 1);
                $this->data['last_user_data']['user_image_char'] = $acr . $bcr;
            }
            $this->data['last_user_data']['user_designation'] = $last_user_data[0]['designation'] == '' ? 'Designation' : $last_user_data[0]['designation'];

            // last user detail end
        }

        if ($message_to_profile == 3) {
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $message_to_profile_id = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'reg_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['message_to_profile_id'] = $message_to_profile_id[0]['reg_id'];
        }
        // from freelancer post
        if ($message_from_profile == 4) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $message_from_profile_id = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_reg_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_id[0]['freelancer_post_reg_id'];


            $this->data['message_from_profile'] = 4;
            $this->data['message_to_profile'] = 3;



            // last user detail start
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $last_user_data = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'reg_id,username,fullname,freelancer_hire_user_image,user_id,designation', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->data['last_user_data']['user_profile_id'] = $last_user_data[0]['rec_id'];
            $this->data['last_user_data']['first_name'] = $last_user_data[0]['fullname'];
            $this->data['last_user_data']['last_name'] = $last_user_data[0]['username'];
            $user_image = FCPATH . 'uploads/freelancer_hire_profile/thumbs/' . $last_user_data[0]['freelancer_hire_user_image'];
            if ($last_user_data[0]['freelancer_hire_user_image'] && (file_exists($user_image)) == 1) {
                $this->data['last_user_data']['user_image'] = base_url() . 'uploads/freelancer_hire_profile/thumbs/' . $last_user_data[0]['freelancer_hire_user_image'];
            } else {
                $a = $last_user_data[0]['fullname'];
                $b = $last_user_data[0]['username'];
                $acr = substr($a, 0, 1);
                $bcr = substr($b, 0, 1);
                $this->data['last_user_data']['user_image_char'] = $acr . $bcr;
            }
            $this->data['last_user_data']['user_designation'] = $last_user_data[0]['designation'] == '' ? 'Current Work' : $last_user_data[0]['designation'];

            // last user detail end
        }

        if ($message_to_profile == 4) {
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $message_to_profile_id = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_reg_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['message_to_profile_id'] = $message_to_profile_id[0]['freelancer_post_reg_id'];
        }
        // from business
        if ($message_from_profile == 5) {
            $contition_array = array('user_id' => $userid, 'business_profile.is_deleted' => '0', 'status' => '1');
            $message_from_profile_id = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_id[0]['business_profile_id'];

            $this->data['message_from_profile'] = $this->data['message_to_profile'] = 5;
            // last user detail start
            $contition_array = array('user_id' => $id, 'business_profile.is_deleted' => '0', 'status' => '1');
            $last_user_data = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id,company_name,business_user_image,user_id,industriyal,other_industrial', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->data['last_user_data']['user_profile_id'] = $last_user_data[0]['business_profile_id'];
            $this->data['last_user_data']['first_name'] = $last_user_data[0]['company_name'];
            $user_image = FCPATH . 'uploads/business_profile/thumbs/' . $last_user_data[0]['business_user_image'];
            if ($last_user_data[0]['business_user_image'] && (file_exists($user_image)) == 1) {
                $this->data['last_user_data']['user_image'] = base_url() . 'uploads/business_profile/thumbs/' . $last_user_data[0]['business_user_image'];
            } else {
                $a = $last_user_data[0]['company_name'];
                $acr = substr($a, 0, 1);
                $this->data['last_user_data']['user_image_char'] = $acr;
            }

            $category = $this->db->get_where('industry_type', array('industry_id' => $last_user_data[0]['industriyal'], 'status' => 1))->row()->industry_name;
            $this->data['last_user_data']['user_designation'] = $category == '' ? $last_user_data[0]['other_industrial'] : $category;

            // last user detail end
        }

        if ($message_to_profile == 5) {
            $contition_array = array('user_id' => $id, 'business_profile.is_deleted' => '0', 'status' => '1');
            $message_to_profile_id = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['message_to_profile_id'] = $message_to_profile_id[0]['business_profile_id'];
        }
        // from artistic
        if ($message_from_profile == 6) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $message_from_profile_id = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_id[0]['art_id'];


            $this->data['message_from_profile'] = $this->data['message_to_profile'] = 6;

            // last user detail start
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $last_user_data = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_name,art_lastname,art_user_image,user_id,designation', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->data['last_user_data']['user_profile_id'] = $last_user_data[0]['art_id'];
            $this->data['last_user_data']['first_name'] = $last_user_data[0]['art_name'];
            $this->data['last_user_data']['last_name'] = $last_user_data[0]['art_lastname'];
            $user_image = FCPATH . 'uploads/artistic_profile/thumbs/' . $last_user_data[0]['art_user_image'];
            if ($last_user_data[0]['art_user_image'] && (file_exists($user_image)) == 1) {
                $this->data['last_user_data']['user_image'] = base_url() . 'uploads/artistic_profile/thumbs/' . $last_user_data[0]['art_user_image'];
            } else {
                $a = $last_user_data[0]['art_name'];
                $b = $last_user_data[0]['art_lastname'];
                $acr = substr($a, 0, 1);
                $bcr = substr($b, 0, 1);
                $this->data['last_user_data']['user_image_char'] = $acr . $bcr;
            }

            $this->data['last_user_data']['user_designation'] = $last_user_data[0]['designation'] == '' ? 'Current Work' : $last_user_data[0]['designation'];

            // last user detail end
        }

        if ($message_to_profile == 6) {
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $message_to_profile_id = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['message_to_profile_id'] = $message_to_profile_id[0]['art_id'];
        }

        // last user if $id is null
        $contition_array = array('id !=' => '');
        $search_condition = "(message_from = '$userid' OR message_to = '$userid') AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";
        $lastchat = $this->common->select_data_by_search('messages', $search_condition, $contition_array, $data = 'messages.message_from,message_to,id', $sortby = 'id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = '', $groupby = '');

        //20-7@nkit
        if ($message_from_profile == 1) {
            $loginuser = $this->common->select_data_by_id('job_reg', 'user_id', $userid, $data = 'fname as first_name,lname as last_name,user_id');
        }

        if ($message_from_profile == 2) {
            $loginuser = $this->common->select_data_by_id('recruiter', 'user_id', $userid, $data = 'rec_firstname as first_name,rec_lastname as last_name,user_id');
        }

        if ($message_from_profile == 3) {
            $loginuser = $this->common->select_data_by_id('freelancer_hire_reg', 'user_id', $userid, $data = 'username as last_name,fullname as first_name,user_id');
        }

        if ($message_from_profile == 4) {
            $loginuser = $this->common->select_data_by_id('freelancer_post_reg', 'user_id', $userid, $data = 'freelancer_post_fullname as first_name,freelancer_post_username as last_name,user_id');
        }

        if ($message_from_profile == 5) {
            $loginuser = $this->common->select_data_by_id('business_profile', 'user_id', $userid, $data = 'company_name as first_name,user_id');
        }

        if ($message_from_profile == 6) {
            $loginuser = $this->common->select_data_by_id('art_reg', 'user_id', $userid, $data = 'art_name as first_name,art_lastname as last_name,user_id');
        }


        $this->data['logfname'] = $loginuser[0]['first_name'];
        $this->data['loglname'] = $loginuser[0]['last_name'];


        // slected user chat to
//        $contition_array = array('is_delete' => '0', 'status' => '1');
//        $search_condition = "((message_from = '$id' OR message_to = '$id') && (message_to != '$userid'))  AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";
//
////        //20-7-2017@nkit
//        if ($message_from_profile == 1) {
//            $join_str1[0]['table'] = 'messages';
//            $join_str1[0]['join_table_id'] = 'messages.message_to_profile_id';
//            $join_str1[0]['from_table_id'] = 'job_reg.job_id';
//            $join_str1[0]['join_type'] = '';
//
//            $seltousr = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,fname as first_name,lname as last_name,job_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
//        }
//        if ($message_from_profile == 2) {
//            $join_str1[0]['table'] = 'messages';
//            $join_str1[0]['join_table_id'] = 'messages.message_to_profile_id';
//            $join_str1[0]['from_table_id'] = 'recruiter.rec_id';
//            $join_str1[0]['join_type'] = '';
//            $contition_array = array('is_delete' => '0', 're_status' => '1');
//            $seltousr = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array, $data = 'messages.id,message_to,rec_firstname as first_name,rec_lastname as last_name,recruiter_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
//        }
//        if ($message_from_profile == 3) {
//            $join_str1[0]['table'] = 'messages';
//            $join_str1[0]['join_table_id'] = 'messages.message_to_profile_id';
//            $join_str1[0]['from_table_id'] = 'freelancer_hire_reg.reg_id';
//            $join_str1[0]['join_type'] = '';
//
//            $seltousr = $this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,username as last_name,fullname as first_name,freelancer_hire_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
//        }
//        if ($message_from_profile == 4) {
//            $join_str1[0]['table'] = 'messages';
//            $join_str1[0]['join_table_id'] = 'messages.message_to_profile_id';
//            $join_str1[0]['from_table_id'] = 'freelancer_post_reg.freelancer_post_reg_id';
//            $join_str1[0]['join_type'] = '';
//
//            $seltousr = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,freelancer_post_fullname as first_name,freelancer_post_username as last_name,freelancer_post_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
//        }
//        if ($message_from_profile == 5) {
//            $join_str1[0]['table'] = 'messages';
//            $join_str1[0]['join_table_id'] = 'messages.message_to_profile_id';
//            $join_str1[0]['from_table_id'] = 'business_profile.business_profile_id';
//            $join_str1[0]['join_type'] = '';
//            $contition_array = array('business_profile.is_deleted' => '0', 'status' => '1');
//            $seltousr = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'messages.id,message_to,company_name as first_name,business_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
//        }
//        if ($message_from_profile == 6) {
//            $join_str1[0]['table'] = 'messages';
//            $join_str1[0]['join_table_id'] = 'messages.message_to_profile_id';
//            $join_str1[0]['from_table_id'] = 'art_reg.art_id';
//            $join_str1[0]['join_type'] = '';
//
//            $seltousr = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,art_name as first_name,art_lastname as last_name,art_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
//        }
        // slected user chat from
//        $contition_array = array('is_delete' => '0', 'status' => '1');
//        $search_condition = "((message_from = '$id' OR message_to = '$id') && (message_from != '$userid')) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";
//
////        //20-7-2017@nkit
//        if ($message_from_profile == 1) {
//            $join_str2[0]['table'] = 'messages';
//            $join_str2[0]['join_table_id'] = 'messages.message_from_profile_id';
//            $join_str2[0]['from_table_id'] = 'job_reg.job_id';
//            $join_str2[0]['join_type'] = '';
//
//            $selfromusr = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,fname as first_name,lname as last_name,job_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
//        }
//        if ($message_from_profile == 2) {
//            $join_str2[0]['table'] = 'messages';
//            $join_str2[0]['join_table_id'] = 'messages.message_from_profile_id';
//            $join_str2[0]['from_table_id'] = 'recruiter.rec_id';
//            $join_str2[0]['join_type'] = '';
//            $contition_array = array('is_delete' => '0', 're_status' => '1');
//            $selfromusr = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array, $data = 'messages.id,message_from,rec_firstname as first_name,rec_lastname as last_name,recruiter_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
//        }
//        if ($message_from_profile == 3) {
//            $join_str2[0]['table'] = 'messages';
//            $join_str2[0]['join_table_id'] = 'messages.message_from_profile_id';
//            $join_str2[0]['from_table_id'] = 'freelancer_hire_reg.reg_id';
//            $join_str2[0]['join_type'] = '';
//
//            $selfromusr = $this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,username as last_name,fullname as first_name,freelancer_hire_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
//        }
//        if ($message_from_profile == 4) {
//            $join_str2[0]['table'] = 'messages';
//            $join_str2[0]['join_table_id'] = 'messages.message_from_profile_id';
//            $join_str2[0]['from_table_id'] = 'freelancer_post_reg.freelancer_post_reg_id';
//            $join_str2[0]['join_type'] = '';
//
//            $selfromusr = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,freelancer_post_fullname as first_name,freelancer_post_username as last_name,freelancer_post_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
//        }
//        if ($message_from_profile == 5) {
//            $join_str2[0]['table'] = 'messages';
//            $join_str2[0]['join_table_id'] = 'messages.message_from_profile_id';
//            $join_str2[0]['from_table_id'] = 'business_profile.business_profile_id';
//            $join_str2[0]['join_type'] = '';
//            $contition_array = array('business_profile.is_deleted' => '0', 'status' => '1');
//            $selfromusr = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'messages.id,message_from,company_name as first_name,business_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
//        }
//        if ($message_from_profile == 6) {
//            $join_str2[0]['table'] = 'messages';
//            $join_str2[0]['join_table_id'] = 'messages.message_from_profile_id';
//            $join_str2[0]['from_table_id'] = 'art_reg.art_id';
//            $join_str2[0]['join_type'] = '';
//
//            $selfromusr = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,art_name as first_name,art_lastname as last_name,art_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
//        }

        $selectuser = array_merge($seltousr, $selfromusr);
        $selectuser = $this->aasort($selectuser, "id");

        // replace name of message_to in user_id in select user
//
        $return_arraysel = array();
        $i = 0;
        foreach ($selectuser as $k => $sel_list) {
            $return = array();
            $return = $sel_list;

            if ($sel_list['message_to']) {
                if ($sel_list['message_to'] == $id) {
                    $return['user_id'] = $sel_list['message_to'];
                    $return['first_name'] = $sel_list['first_name'];
                    $return['last_name'] = $sel_list['last_name'];
                    $return['user_image'] = $sel_list['user_image'];
                    $return['message'] = $sel_list['message'];

                    unset($return['message_to']);

                    $i++;
                    if ($i == 1)
                        break;
                }
            }else {
                if ($sel_list['message_from'] == $id) {
                    $return['user_id'] = $sel_list['message_from'];
                    $return['first_name'] = $sel_list['first_name'];
                    $return['last_name'] = $sel_list['last_name'];
                    $return['user_image'] = $sel_list['user_image'];
                    $return['message'] = $sel_list['message'];

                    $i++;
                    if ($i == 1)
                        break;
                }

                unset($return['message_from']);
            }
        } array_push($return_arraysel, $return);

        // message to user
        $contition_array = array('is_delete' => '0', 'status' => '1', 'message_to !=' => $userid);
        $search_condition = "((message_from = '$userid')) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";

//        //20-7-2017@nkit
        if ($message_from_profile == 2) {
            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str3[0]['from_table_id'] = 'job_reg.job_id';
            $join_str3[0]['join_type'] = '';

            $tolist = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,fname as first_name,lname as last_name,job_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
        }
        if ($message_from_profile == 1) {
            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str3[0]['from_table_id'] = 'recruiter.rec_id';
            $join_str3[0]['join_type'] = '';
            $contition_array = array('is_delete' => '0', 're_status' => '1');
            $tolist = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array, $data = 'messages.id,message_to,rec_firstname as first_name,rec_lastname as last_name,recruiter_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
        }
        if ($message_from_profile == 4) {
            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str3[0]['from_table_id'] = 'freelancer_hire_reg.reg_id';
            $join_str3[0]['join_type'] = '';

            $tolist = $this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,username as last_name,fullname as first_name,freelancer_hire_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
        }
        if ($message_from_profile == 3) {
            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str3[0]['from_table_id'] = 'freelancer_post_reg.freelancer_post_reg_id';
            $join_str3[0]['join_type'] = '';

            $tolist = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,freelancer_post_fullname as first_name,freelancer_post_username as last_name,freelancer_post_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
        }
        if ($message_from_profile == 5) {
            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str3[0]['from_table_id'] = 'business_profile.business_profile_id';
            $join_str3[0]['join_type'] = '';
            $contition_array = array('business_profile.is_deleted' => '0', 'status' => '1');
            $tolist = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'messages.id,message_to,company_name as first_name,business_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
        }
        if ($message_from_profile == 6) {
            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str3[0]['from_table_id'] = 'art_reg.art_id';
            $join_str3[0]['join_type'] = '';

            $tolist = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,art_name as first_name,art_lastname as last_name,art_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
        }

        // uniq array of tolist  
        foreach ($tolist as $k => $v) {
            foreach ($tolist as $key => $value) {

                if ($k != $key && $v['message_to'] == $value['message_to']) {
                    unset($tolist[$k]);
                }
            }
        }

        // replace name of message_to in user_id

        $return_arrayto = array();
        foreach ($tolist as $to_list) {

            $return = array();
            $return = $to_list;

            $return['user_id'] = $to_list['message_to'];
            $return['first_name'] = $to_list['first_name'];
            $return['last_name'] = $to_list['last_name'];
            $return['user_image'] = $to_list['user_image'];
            $return['message'] = $to_list['message'];

            unset($return['message_to']);
            array_push($return_arrayto, $return);
        }

        // message from user
        $contition_array = array('is_delete' => '0', 'status' => '1', 'message_from !=' => $userid);
        $search_condition = "((message_to = '$userid')) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";

        //20-7-2017@nkit
        if ($message_from_profile == 2) {
            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str4[0]['from_table_id'] = 'job_reg.job_id';
            $join_str4[0]['join_type'] = '';

            $fromlist = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,fname as first_name,lname as last_name,job_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
        }
        if ($message_from_profile == 1) {
            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str4[0]['from_table_id'] = 'recruiter.rec_id';
            $join_str4[0]['join_type'] = '';
            $contition_array = array('is_delete' => '0', 're_status' => '1');
            $fromlist = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array, $data = 'messages.id,message_from,rec_firstname as first_name,rec_lastname as last_name,recruiter_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
        }
        if ($message_from_profile == 4) {
            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str4[0]['from_table_id'] = 'freelancer_hire_reg.reg_id';
            $join_str4[0]['join_type'] = '';

            $fromlist = $this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,username as last_name,fullname as first_name,freelancer_hire_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
        }
        if ($message_from_profile == 3) {
            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str4[0]['from_table_id'] = 'freelancer_post_reg.freelancer_post_reg_id';
            $join_str4[0]['join_type'] = '';

            $fromlist = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,freelancer_post_fullname as first_name,freelancer_post_username as last_name,freelancer_post_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
        }
        if ($message_from_profile == 5) {
            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str4[0]['from_table_id'] = 'business_profile.business_profile_id';
            $join_str4[0]['join_type'] = '';
            $contition_array = array('business_profile.is_deleted' => '0', 'status' => '1');
            $fromlist = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'messages.id,message_from,company_name as first_name,business_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
        }
        if ($message_from_profile == 6) {
            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str4[0]['from_table_id'] = 'art_reg.art_id';
            $join_str4[0]['join_type'] = '';

            $fromlist = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,art_name as first_name,art_lastname as last_name,art_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
        }

        // uniq array of fromlist  
        foreach ($fromlist as $k => $v) {
            foreach ($fromlist as $key => $value) {
                if ($k != $key && $v['message_from'] == $value['message_from']) {
                    unset($fromlist[$k]);
                }
            }
        }

// replace name of message_to in user_id

        $return_arrayfrom = array();

        foreach ($fromlist as $from_list) {

            $return = array();
            $return = $from_list;

            $return['user_id'] = $from_list['message_from'];
            $return['first_name'] = $from_list['first_name'];
            $return['last_name'] = $from_list['last_name'];
            $return['user_image'] = $from_list['user_image'];
            $return['message'] = $from_list['message'];

            unset($return['message_from']);
            array_push($return_arrayfrom, $return);
        }



        $userlist = array_merge($return_arrayto, $return_arrayfrom);


        // uniq array of fromlist  
        foreach ($userlist as $k => $v) {
            foreach ($userlist as $key => $value) {
                if ($k != $key && $v['user_id'] == $value['user_id']) {
                    if ($v['id'] < $value['id']) {
                        unset($userlist[$k]);
                    }
                }
            }
        }
        $userlist = $this->aasort($userlist, "id");

        if ($return_arraysel[0] == '') {
            $return_arraysel = array();
        }

        $width = " <script>document.write(screen.width); </script>";

        if (!empty($_SERVER['HTTP_USER_AGENT'])) {
            $useragent = $_SERVER['HTTP_USER_AGENT'];
            if (preg_match('@(iPad|iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)@', $useragent)) {
                $function = "mobile_chat_two";
            } else {
                $function = "abc";
            }
        }

        $userlist = $this->data['userlist'] = array_merge($return_arraysel, $userlist);
        $userlist = $this->aasort($userlist, "id");

        foreach ($userlist as $user) {   
            if ($user['user_id'] != $toid) {

                $usrsrch .= '<a href="' . base_url() . 'chat/' . $function . '/' . $message_from_profile . '/' . $message_to_profile . '/' . $user['user_id'] . '">';
                $usrsrch .= '<li class="clearfix';
                if ($user['user_id'] == $id) {
                    $usrsrch .= ' active';
                }
                $usrsrch .= '">';

                $usrsrch .= '<div class="chat_heae_img">';
                if ($message_from_profile == 2) {
                    
                    $filename = $this->config->item('job_profile_thumb_upload_path') . $user['user_image'];
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $this->data['image_path'] = $image_path = $s3->getObjectInfo(bucket, $filename);
                         
               //     $image_path = FCPATH . 'uploads/job_profile/thumbs/' . $user['user_image'];
                    $user_image =  JOB_PROFILE_THUMB_UPLOAD_URL . $user['user_image'];
                }
                if ($message_from_profile == 1) {
                    $filename = $this->config->item('rec_profile_thumb_upload_path') . $user['user_image'];
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $this->data['image_path'] = $image_path = $s3->getObjectInfo(bucket, $filename);
                    
                   // $image_path = FCPATH . 'uploads/recruiter_profile/thumbs/' . $user['user_image'];
                    $user_image =  REC_PROFILE_THUMB_UPLOAD_URL . $user['user_image'];
                }
                if ($message_from_profile == 4) {
                    $image_path = FCPATH . 'uploads/freelancer_hire_profile/thumbs/' . $user['user_image'];
                    $user_image = base_url() . 'uploads/freelancer_hire_profile/thumbs/' . $user['user_image'];
                }
                if ($message_from_profile == 3) {
                    $image_path = FCPATH . 'uploads/freelancer_post_profile/thumbs/' . $user['user_image'];
                    $user_image = base_url() . 'uploads/freelancer_post_profile/thumbs/' . $user['user_image'];
                }
                if ($message_from_profile == 5) {
                    $image_path = FCPATH . 'uploads/business_profile/thumbs/' . $user['user_image'];
                    $user_image = base_url() . 'uploads/business_profile/thumbs/' . $user['user_image'];
                }
                if ($message_from_profile == 6) {
                    $image_path = FCPATH . 'uploads/artistic_profile/thumbs/' . $user['user_image'];
                    $user_image = base_url() . 'uploads/artistic_profile/thumbs/' . $user['user_image'];
                }

                if ($user['user_image'] && (file_exists($image_path)) == 1) {
                    $usrsrch .= '<img src="' . $user_image . '" alt="' . $user['user_image'] . '" height="50px" weight="50px">';
                    //$usrsrch .= '</div>';
                } else if($message_from_profile == 5){
                    
                    $usrsrch .= '<img src="' . base_url(NOBUSIMAGE) . '" alt="' . $user['user_image'] . '" height="50px" weight="50px">';                    
                }
                else {
                    $a = $user['first_name'];
                    $b = $user['last_name'];
                    $acr = substr($a, 0, 1);
                    $bcr = substr($b, 0, 1);

                    $usrsrch .= '<div class="post-img-div">';
                    $usrsrch .= '' . ucwords($acr) . ucwords($bcr) . '';
                    $usrsrch .= '</div>';
                }
                $usrsrch .= '</div>';
                $usrsrch .= '<div class="about">';
                $usrsrch .= '<div class="name">';
                $usrsrch .= '' . $user['first_name'] . ' ' . $user['last_name'] . '<br></div>';
                $usrsrch .= '<div class="status' . $user['user_id'] . '" style=" width: 240px;
    color: #003;    max-height: 20px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
">';
                $message = $user['message'];
                $message = preg_replace('[^(<br( \/)?>)*|(<br( \/)?>)*$]', '', $message);
                $message = str_replace('%26amp;', '&', $message);
                $message = str_replace('%26gt;', '>', $message);
                $message = str_replace('%26lt;', '<', $message);
                $usrsrch .= '' . str_replace('\\', '', $message) . '';
                $usrsrch .= '</div>';
                $usrsrch .= '</div>';
                $usrsrch .= '</li></a>';
            }
        }


        // notification message start 

        foreach ($userlist as $msg) {

            if ($message_from_profile == 2) {
                $filename = $this->config->item('job_profile_thumb_upload_path') . $msg['user_image'];
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $this->data['image_path'] = $image_path = $s3->getObjectInfo(bucket, $filename);
                         
               //     $image_path = FCPATH . 'uploads/job_profile/thumbs/' . $user['user_image'];
                    $user_image =  JOB_PROFILE_THUMB_UPLOAD_URL . $msg['user_image'];
                $profile_url = base_url() . 'job/job_printpreview/' . $id . '?page=recruiter';
            }

            if ($message_from_profile == 1) {
                $filename = $this->config->item('rec_profile_thumb_upload_path') . $msg['user_image'];
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $this->data['image_path'] = $image_path = $s3->getObjectInfo(bucket, $filename);
                    
                   // $image_path = FCPATH . 'uploads/recruiter_profile/thumbs/' . $user['user_image'];
                    $user_image =  REC_PROFILE_THUMB_UPLOAD_URL . $msg['user_image'];
                $profile_url = base_url() . 'recruiter/rec_profile/' . $id . '?page=job';
            }
            if ($message_from_profile == 4) {
                $image_path = FCPATH . 'uploads/freelancer_hire_profile/thumbs/' . $msg['user_image'];
                $user_image = base_url() . 'uploads/freelancer_hire_profile/thumbs/' . $msg['user_image'];
                $profile_url = base_url() . 'freelancer/freelancer_post_profile/' . $id . '?page=freelancer_hire';
            }
            if ($message_from_profile == 3) {
                $image_path = FCPATH . 'uploads/freelancer_post_profile/thumbs/' . $msg['user_image'];
                $user_image = base_url() . 'uploads/freelancer_post_profile/thumbs/' . $msg['user_image'];
                $profile_url = base_url() . 'freelancer/freelancer_hire_profile/' . $id . '?page=freelancer_post';
            }
            if ($message_from_profile == 5) {
                $image_path = FCPATH . 'uploads/business_profile/thumbs/' . $msg['user_image'];
                $user_image = base_url() . 'uploads/business_profile/thumbs/' . $msg['user_image'];
                $busdata = $this->common->select_data_by_id('business_profile', 'user_id', $id, $data = 'business_slug');
                $profile_url = base_url() . 'business-profile/dashboard/' . $busdata[0]['business_slug'];
            }
            if ($message_from_profile == 6) {
                $image_path = FCPATH . 'uploads/artistic_profile/thumbs/' . $msg['user_image'];
                $user_image = base_url() . 'uploads/artistic_profile/thumbs/' . $msg['user_image'];
                $profile_url = base_url() . 'artist/art_manage_post/' . $id;
            }


            $contition_array = array('not_product_id' => $msg['id'], 'not_type' => "2");
            $data = array(' notification.*');
            $not = $this->common->select_data_by_condition('notification', $contition_array, $data, $sortby = 'not_id', $orderby = 'desc', $limit = '', $offset = '', $join_str = "", $groupby = '');
            $notmsg .= '<li class="';
            if ($not[0]['not_active'] == 1 && ($this->uri->segment(3) != $msg['user_id'])) {
                $notmsg .= 'active2';
            }else{
                $notmsg .= 'active';
                
            }
            $notmsg .= '">';
            $notmsg .= '<a href="' . base_url() . 'chat/abc/' . $message_from_profile . '/' . $message_to_profile . '/' . $msg['user_id'] . '/' . $not[0]['not_id'] . '" class="clearfix msg_dot" style="padding:0px!important;">';
//            $notmsg .= '<a href="' . base_url() . 'chat/abc/' . $msg['user_id'] . '/' . $message_from_profile . '/' . $message_to_profile . '/' . $not[0]['not_id'] . '" class="clearfix msg_dot" style="padding:0px!important;">';
            $notmsg .= '<div class="notification-database"><div class="notification-pic">';


            if ($msg['user_image'] && (file_exists($image_path)) == 1) {
                $notmsg .= '<img src="' . $user_image . '" >';
            } else {
                $a = $msg['first_name'];
                $b = $msg['last_name'];
                $acr = substr($a, 0, 1);
                $bcr = substr($b, 0, 1);
                if($message_from_profile != 5){ 
                $notmsg .= '<div class="post-img-div">';
                $notmsg .= '' . ucwords($acr) . ucwords($bcr) . '';
                $notmsg .= '</div>';
                }else{
                $notmsg .= '<img src="'. base_url() . NOBUSIMAGE .  '">';
                }
            }

            $notmsg .= '</div><div class="notification-data-inside">';
            $notmsg .= '<h6>' . ucwords($msg['first_name']) . ' ' . ucwords($msg['last_name']) . '</h6>';
            //       $notmsg .= '<h6>' . ucwords($msg['first_name']) . '</h6>';
            $notmsg .= '<div class="msg_desc_a">';

            $message = str_replace('\\r', '', $msg['message']);
            $message = preg_replace('[^(<br( \/)?>)*|(<br( \/)?>)*$]', '', $message);
            $message = str_replace('\\t', '', $message);
            $message = str_replace('\\', '', $message);
            $message = str_replace('%26amp;', '&', $message);
            $message = str_replace('%26gt;', '>', $message);
            $message = str_replace('%26lt;', '<', $message);

            $notmsg .= '' . $message . '';
            $notmsg .= '</div><div class="data_noti_msg"><span class="day-text2">' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($not[0]['not_created_date']))) . '</span></div>';
//            $notmsg .= '</div><div class="data_noti_msg"><span class="day-text2">'. $not[0]['not_created_date'] . '</span></div>';
            $notmsg .= '</div></div></a></li>';
        }
        $notmsg .= '</div>';

        if ($userlist) {
            $seeall = '<a href="' . base_url() . 'chat/abc/' . $message_from_profile . '/' . $message_to_profile . '/' . $userlist[0]['user_id'] . '" >See All</a>';
        } else {
            $seeall = '<div class="fw">
  <div class="art-img-nn">
                                                <div class="art_no_post_img">
                                                    <img src="' . base_url() . 'assets/img/icon_no_message.png">
                                                </div>
                                                <div class="art_no_post_text_c">
                                                    No Messages Available.
                                                </div>
                             </div></div>';
        }
        echo json_encode(
                array(
                    "leftbar" => $usrsrch,
                    "headertwo" => $notmsg,
                    "seeall" => $seeall,
        ));
    }

    public function noavailable() {

        $this->load->view('notavalible', $this->data);
    }

    public function mobile_chat_two($message_from_profile = '', $message_to_profile = '', $id = '', $not_id = '') {
        $this->data['id'] = $id;
        $this->chat_search($id, $message_from_profile, $message_to_profile);
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        if ($id == $userid) {
            redirect('chat/noavailable');
        }
        // update notification read code start
        if ($not_id) {
            $data = array(
                'not_active' => 2
            );

            $updatedata = $this->common->update_data($data, 'notification', 'not_id', $not_id);
        }
        // update notification read code end 
        // from job
        if ($message_from_profile == 1) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $message_from_profile_data = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_id,fname,lname,job_user_image,designation,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_data[0]['job_id'];

            $this->data['message_from_profile'] = 1;
            $this->data['message_to_profile'] = 2;

            // last user etail start
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 're_status' => '1');
            $last_user_data = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id,rec_firstname,rec_lastname,recruiter_user_image,designation,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->data['last_user_data']['user_profile_id'] = $last_user_data[0]['rec_id'];
            $this->data['last_user_data']['first_name'] = $last_user_data[0]['rec_firstname'];
            $this->data['last_user_data']['last_name'] = $last_user_data[0]['rec_lastname'];

            $user_image = FCPATH . 'uploads/recruiter_profile/thumbs/' . $last_user_data[0]['recruiter_user_image'];
            if ($last_user_data[0]['recruiter_user_image'] && (file_exists($user_image)) == 1) {
                $this->data['last_user_data']['user_image'] = base_url() . 'uploads/recruiter_profile/thumbs/' . $last_user_data[0]['recruiter_user_image'];
            } else {
                $a = $last_user_data[0]['rec_firstname'];
                $b = $last_user_data[0]['rec_lastname'];
                $acr = substr($a, 0, 1);
                $bcr = substr($b, 0, 1);
                $this->data['last_user_data']['user_image_char'] = $acr . $bcr;
            }
            $this->data['last_user_data']['user_designation'] = $last_user_data[0]['designation'] == '' ? 'Designation' : $last_user_data[0]['designation'];
            // last user detail end
        }
        if ($message_to_profile == 1) {
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $message_to_profile_data = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_id,fname,lname,job_user_image,designation,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['message_to_profile_id'] = $message_to_profile_data[0]['job_id'];
        }

        // from recruiter
        if ($message_from_profile == 2) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 're_status' => '1');
            $message_from_profile_data = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id,rec_firstname,rec_lastname,recruiter_user_image,designation,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_data[0]['rec_id'];


            $this->data['message_from_profile'] = 2;
            $this->data['message_to_profile'] = 1;



            // last user detail start
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $last_user_data = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'job_id,fname,lname,job_user_image,designation,user_id,designation', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->data['last_user_data']['user_profile_id'] = $last_user_data[0]['rec_id'];
            $this->data['last_user_data']['first_name'] = $last_user_data[0]['fname'];
            $this->data['last_user_data']['last_name'] = $last_user_data[0]['lname'];
            $user_image = FCPATH . 'uploads/job_profile/thumbs/' . $last_user_data[0]['job_user_image'];
            if ($last_user_data[0]['job_user_image'] && (file_exists($user_image)) == 1) {
                $this->data['last_user_data']['user_image'] = base_url() . 'uploads/job_profile/thumbs/' . $last_user_data[0]['job_user_image'];
            } else {
                $a = $last_user_data[0]['fname'];
                $b = $last_user_data[0]['lname'];
                $acr = substr($a, 0, 1);
                $bcr = substr($b, 0, 1);
                $this->data['last_user_data']['user_image_char'] = $acr . $bcr;
            }
            //echo $last_user_data[0]['designation']; die();
            $this->data['last_user_data']['user_designation'] = $last_user_data[0]['designation'] == '' ? 'Current Work' : $last_user_data[0]['designation'];

            // last user detail end
        }


        if ($message_to_profile == 2) {
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 're_status' => '1');
            $message_to_profile_id = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id,rec_firstname,rec_lastname,recruiter_user_image,designation,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['message_to_profile_id'] = $message_to_profile_id[0]['rec_id'];
        }

        // from freelancer hire
        if ($message_from_profile == 3) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $message_from_profile_id = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'reg_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_id[0]['reg_id'];


            $this->data['message_from_profile'] = 3;
            $this->data['message_to_profile'] = 4;

            // last user detail start
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $last_user_data = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_reg_id,freelancer_post_username,freelancer_post_fullname,freelancer_post_user_image,user_id,designation', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->data['last_user_data']['user_profile_id'] = $last_user_data[0]['freelancer_post_reg_id'];
            $this->data['last_user_data']['first_name'] = $last_user_data[0]['freelancer_post_fullname'];
            $this->data['last_user_data']['last_name'] = $last_user_data[0]['freelancer_post_username'];
            $user_image = FCPATH . 'uploads/freelancer_post_profile/thumbs/' . $last_user_data[0]['freelancer_post_user_image'];
            if ($last_user_data[0]['freelancer_post_user_image'] && (file_exists($user_image)) == 1) {
                $this->data['last_user_data']['user_image'] = base_url() . 'uploads/freelancer_post_profile/thumbs/' . $last_user_data[0]['freelancer_post_user_image'];
            } else {
                $a = $last_user_data[0]['freelancer_post_fullname'];
                $b = $last_user_data[0]['freelancer_post_username'];
                $acr = substr($a, 0, 1);
                $bcr = substr($b, 0, 1);
                $this->data['last_user_data']['user_image_char'] = $acr . $bcr;
            }
            $this->data['last_user_data']['user_designation'] = $last_user_data[0]['designation'] == '' ? 'Designation' : $last_user_data[0]['designation'];

            // last user detail end
        }

        if ($message_to_profile == 3) {
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $message_to_profile_id = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'reg_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['message_to_profile_id'] = $message_to_profile_id[0]['reg_id'];
        }
        // from freelancer post
        if ($message_from_profile == 4) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $message_from_profile_id = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_reg_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_id[0]['freelancer_post_reg_id'];


            $this->data['message_from_profile'] = 4;
            $this->data['message_to_profile'] = 3;



            // last user detail start
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $last_user_data = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'reg_id,username,fullname,freelancer_hire_user_image,user_id,designation', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->data['last_user_data']['user_profile_id'] = $last_user_data[0]['rec_id'];
            $this->data['last_user_data']['first_name'] = $last_user_data[0]['fullname'];
            $this->data['last_user_data']['last_name'] = $last_user_data[0]['username'];
            $user_image = FCPATH . 'uploads/freelancer_hire_profile/thumbs/' . $last_user_data[0]['freelancer_hire_user_image'];
            if ($last_user_data[0]['freelancer_hire_user_image'] && (file_exists($user_image)) == 1) {
                $this->data['last_user_data']['user_image'] = base_url() . 'uploads/freelancer_hire_profile/thumbs/' . $last_user_data[0]['freelancer_hire_user_image'];
            } else {
                $a = $last_user_data[0]['fullname'];
                $b = $last_user_data[0]['username'];
                $acr = substr($a, 0, 1);
                $bcr = substr($b, 0, 1);
                $this->data['last_user_data']['user_image_char'] = $acr . $bcr;
            }
            $this->data['last_user_data']['user_designation'] = $last_user_data[0]['designation'] == '' ? 'Current Work' : $last_user_data[0]['designation'];

            // last user detail end
        }

        if ($message_to_profile == 4) {
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $message_to_profile_id = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_reg_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['message_to_profile_id'] = $message_to_profile_id[0]['freelancer_post_reg_id'];
        }
        // from business
        if ($message_from_profile == 5) {
            $contition_array = array('user_id' => $userid, 'business_profile.is_deleted' => '0', 'status' => '1');
            $message_from_profile_id = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_id[0]['business_profile_id'];

            $this->data['message_from_profile'] = $this->data['message_to_profile'] = 5;
            // last user detail start
            $contition_array = array('user_id' => $id, 'business_profile.is_deleted' => '0', 'status' => '1');
            $last_user_data = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id,company_name,business_user_image,user_id,industriyal,other_industrial', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->data['last_user_data']['user_profile_id'] = $last_user_data[0]['business_profile_id'];
            $this->data['last_user_data']['first_name'] = $last_user_data[0]['company_name'];
            $user_image = FCPATH . 'uploads/business_profile/thumbs/' . $last_user_data[0]['business_user_image'];
            if ($last_user_data[0]['business_user_image'] && (file_exists($user_image)) == 1) {
                $this->data['last_user_data']['user_image'] = base_url() . 'uploads/business_profile/thumbs/' . $last_user_data[0]['business_user_image'];
            } else {
                $a = $last_user_data[0]['company_name'];
                $acr = substr($a, 0, 1);
                $this->data['last_user_data']['user_image_char'] = $acr;
            }

            $category = $this->db->get_where('industry_type', array('industry_id' => $last_user_data[0]['industriyal'], 'status' => 1))->row()->industry_name;
            $this->data['last_user_data']['user_designation'] = $category == '' ? $last_user_data[0]['other_industrial'] : $category;

            // last user detail end
        }

        if ($message_to_profile == 5) {
            $contition_array = array('user_id' => $id, 'business_profile.is_deleted' => '0', 'status' => '1');
            $message_to_profile_id = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['message_to_profile_id'] = $message_to_profile_id[0]['business_profile_id'];
        }
        // from artistic
        if ($message_from_profile == 6) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $message_from_profile_id = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $message_from_profile_id = $this->data['message_from_profile_id'] = $message_from_profile_id[0]['art_id'];


            $this->data['message_from_profile'] = $this->data['message_to_profile'] = 6;

            // last user detail start
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $last_user_data = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_name,art_lastname,art_user_image,user_id,designation', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $this->data['last_user_data']['user_profile_id'] = $last_user_data[0]['art_id'];
            $this->data['last_user_data']['first_name'] = $last_user_data[0]['art_name'];
            $this->data['last_user_data']['last_name'] = $last_user_data[0]['art_lastname'];
            $user_image = FCPATH . 'uploads/artistic_profile/thumbs/' . $last_user_data[0]['art_user_image'];
            if ($last_user_data[0]['art_user_image'] && (file_exists($user_image)) == 1) {
                $this->data['last_user_data']['user_image'] = base_url() . 'uploads/artistic_profile/thumbs/' . $last_user_data[0]['art_user_image'];
            } else {
                $a = $last_user_data[0]['art_name'];
                $b = $last_user_data[0]['art_lastname'];
                $acr = substr($a, 0, 1);
                $bcr = substr($b, 0, 1);
                $this->data['last_user_data']['user_image_char'] = $acr . $bcr;
            }

            $this->data['last_user_data']['user_designation'] = $last_user_data[0]['designation'] == '' ? 'Current Work' : $last_user_data[0]['designation'];

            // last user detail end
        }

        if ($message_to_profile == 6) {
            $contition_array = array('user_id' => $id, 'is_delete' => '0', 'status' => '1');
            $message_to_profile_id = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['message_to_profile_id'] = $message_to_profile_id[0]['art_id'];
        }

        // last user if $id is null
        $contition_array = array('id !=' => '');
        $search_condition = "(message_from = '$userid' OR message_to = '$userid') AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";
        $lastchat = $this->common->select_data_by_search('messages', $search_condition, $contition_array, $data = 'messages.message_from,message_to,id', $sortby = 'id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = '', $groupby = '');

        if ($id) {
            $toid = $this->data['toid'] = $id;
        } elseif ($lastchat[0]['message_from'] == $userid) {
            $toid = $this->data['toid'] = $lastchat[0]['message_to'];
        } else {
            $toid = $this->data['toid'] = $lastchat[0]['message_from'];
        }

        //20-7@nkit
        if ($message_from_profile == 1) {
            $loginuser = $this->common->select_data_by_id('job_reg', 'user_id', $userid, $data = 'fname as first_name,lname as last_name,user_id');
        }

        if ($message_from_profile == 2) {
            $loginuser = $this->common->select_data_by_id('recruiter', 'user_id', $userid, $data = 'rec_firstname as first_name,rec_lastname as last_name,user_id');
        }

        if ($message_from_profile == 3) {
            $loginuser = $this->common->select_data_by_id('freelancer_hire_reg', 'user_id', $userid, $data = 'username as last_name,fullname as first_name,user_id');
        }

        if ($message_from_profile == 4) {
            $loginuser = $this->common->select_data_by_id('freelancer_post_reg', 'user_id', $userid, $data = 'freelancer_post_fullname as first_name,freelancer_post_username as last_name,user_id');
        }

        if ($message_from_profile == 5) {
            $loginuser = $this->common->select_data_by_id('business_profile', 'user_id', $userid, $data = 'company_name as first_name,user_id');
        }

        if ($message_from_profile == 6) {
            $loginuser = $this->common->select_data_by_id('art_reg', 'user_id', $userid, $data = 'art_name as first_name,art_lastname as last_name,user_id');
        }


        $this->data['logfname'] = $loginuser[0]['first_name'];
        $this->data['loglname'] = $loginuser[0]['last_name'];

        // last message user fetch

        $contition_array = array('id !=' => '');
        $search_condition = "(message_from = '$id' OR message_to = '$id')  AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";
        $lastuser = $this->common->select_data_by_search('messages', $search_condition, $contition_array, $data = 'messages.message_from,message_to,id', $sortby = 'id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = '', $groupby = '');

        if ($lastuser[0]['message_from'] == $userid) {
            $lstusr = $this->data['lstusr'] = $lastuser[0]['message_to'];
        } else {
            $lstusr = $this->data['lstusr'] = $lastuser[0]['message_from'];
        }

        // last user first name last name
        if ($lstusr) {

            //20-7@nkit
            if ($message_from_profile == 1) {
                $lastuser = $this->common->select_data_by_id('job_reg', 'user_id', $lstusr, $data = 'fname as first_name,lname as last_name,user_id');
            }

            if ($message_from_profile == 2) {
                $lastuser = $this->common->select_data_by_id('recruiter', 'user_id', $lstusr, $data = 'rec_firstname as first_name,rec_lastname as last_name,user_id');
            }

            if ($message_from_profile == 3) {
                $lastuser = $this->common->select_data_by_id('freelancer_hire_reg', 'user_id', $lstusr, $data = 'username as last_name,fullname as first_name,user_id');
            }

            if ($message_from_profile == 4) {
                $lastuser = $this->common->select_data_by_id('freelancer_post_reg', 'user_id', $lstusr, $data = 'freelancer_post_fullname as first_name,freelancer_post_username as last_name,user_id');
            }

            if ($message_from_profile == 5) {
                $lastuser = $this->common->select_data_by_id('business_profile', 'user_id', $lstusr, $data = 'company_name as first_name,user_id');
            }

            if ($message_from_profile == 6) {
                $lastuser = $this->common->select_data_by_id('art_reg', 'user_id', $lstusr, $data = 'art_name as first_name,art_lastname as last_name,user_id');
            }

//            $lastuser = $this->common->select_data_by_id('user', 'user_id', $lstusr, $data = 'first_name,last_name');

            $this->data['lstfname'] = $lastuser[0]['first_name'];
            $this->data['lstlname'] = $lastuser[0]['last_name'];
        }
        // slected user chat to

        $contition_array = array('is_delete' => '0', 'status' => '1');
        $search_condition = "((message_from = '$id' OR message_to = '$id') && (message_to != '$userid'))  AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";

        //20-7-2017@nkit
        if ($message_from_profile == 1) {
            $join_str1[0]['table'] = 'messages';
            $join_str1[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str1[0]['from_table_id'] = 'job_reg.job_id';
            $join_str1[0]['join_type'] = '';

            $seltousr = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,fname as first_name,lname as last_name,job_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
        }
        if ($message_from_profile == 2) {
            $join_str1[0]['table'] = 'messages';
            $join_str1[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str1[0]['from_table_id'] = 'recruiter.rec_id';
            $join_str1[0]['join_type'] = '';
            $contition_array = array('is_delete' => '0', 're_status' => '1');
            $seltousr = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array, $data = 'messages.id,message_to,rec_firstname as first_name,rec_lastname as last_name,recruiter_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
        }
        if ($message_from_profile == 3) {
            $join_str1[0]['table'] = 'messages';
            $join_str1[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str1[0]['from_table_id'] = 'freelancer_hire_reg.reg_id';
            $join_str1[0]['join_type'] = '';

            $seltousr = $this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,username as last_name,fullname as first_name,freelancer_hire_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
        }
        if ($message_from_profile == 4) {
            $join_str1[0]['table'] = 'messages';
            $join_str1[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str1[0]['from_table_id'] = 'freelancer_post_reg.freelancer_post_reg_id';
            $join_str1[0]['join_type'] = '';

            $seltousr = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,freelancer_post_fullname as first_name,freelancer_post_username as last_name,freelancer_post_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
        }
        if ($message_from_profile == 5) {
            $join_str1[0]['table'] = 'messages';
            $join_str1[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str1[0]['from_table_id'] = 'business_profile.business_profile_id';
            $join_str1[0]['join_type'] = '';
            $contition_array = array('business_profile.is_deleted' => '0', 'status' => '1');
            $seltousr = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'messages.id,message_to,company_name as first_name,business_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
        }
        if ($message_from_profile == 6) {
            $join_str1[0]['table'] = 'messages';
            $join_str1[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str1[0]['from_table_id'] = 'art_reg.art_id';
            $join_str1[0]['join_type'] = '';

            $seltousr = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,art_name as first_name,art_lastname as last_name,art_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str1, $groupby = '');
        }

        // slected user chat from

        $contition_array = array('is_delete' => '0', 'status' => '1');
        $search_condition = "((message_from = '$id' OR message_to = '$id') && (message_from != '$userid')) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";

        //20-7-2017@nkit
        if ($message_from_profile == 1) {
            $join_str2[0]['table'] = 'messages';
            $join_str2[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str2[0]['from_table_id'] = 'job_reg.job_id';
            $join_str2[0]['join_type'] = '';

            $selfromusr = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,fname as first_name,lname as last_name,job_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
        }
        if ($message_from_profile == 2) {
            $join_str2[0]['table'] = 'messages';
            $join_str2[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str2[0]['from_table_id'] = 'recruiter.rec_id';
            $join_str2[0]['join_type'] = '';
            $contition_array = array('is_delete' => '0', 're_status' => '1');
            $selfromusr = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array, $data = 'messages.id,message_from,rec_firstname as first_name,rec_lastname as last_name,recruiter_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
        }
        if ($message_from_profile == 3) {
            $join_str2[0]['table'] = 'messages';
            $join_str2[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str2[0]['from_table_id'] = 'freelancer_hire_reg.reg_id';
            $join_str2[0]['join_type'] = '';

            $selfromusr = $this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,username as last_name,fullname as first_name,freelancer_hire_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
        }
        if ($message_from_profile == 4) {
            $join_str2[0]['table'] = 'messages';
            $join_str2[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str2[0]['from_table_id'] = 'freelancer_post_reg.freelancer_post_reg_id';
            $join_str2[0]['join_type'] = '';

            $selfromusr = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,freelancer_post_fullname as first_name,freelancer_post_username as last_name,freelancer_post_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
        }
        if ($message_from_profile == 5) {
            $join_str2[0]['table'] = 'messages';
            $join_str2[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str2[0]['from_table_id'] = 'business_profile.business_profile_id';
            $join_str2[0]['join_type'] = '';
            $contition_array = array('business_profile.is_deleted' => '0', 'status' => '1');
            $selfromusr = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'messages.id,message_from,company_name as first_name,business_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
        }
        if ($message_from_profile == 6) {
            $join_str2[0]['table'] = 'messages';
            $join_str2[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str2[0]['from_table_id'] = 'art_reg.art_id';
            $join_str2[0]['join_type'] = '';

            $selfromusr = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,art_name as first_name,art_lastname as last_name,art_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'DESC', $limit = '', $offset = '', $join_str2, $groupby = '');
        }

        $selectuser = array_merge($seltousr, $selfromusr);
        $selectuser = $this->aasort($selectuser, "id");

        // replace name of message_to in user_id in select user

        $return_arraysel = array();
        $i = 0;
        foreach ($selectuser as $k => $sel_list) {
            $return = array();
            $return = $sel_list;

            if ($sel_list['message_to']) {
                if ($sel_list['message_to'] == $id) {
                    $return['user_id'] = $sel_list['message_to'];
                    $return['first_name'] = $sel_list['first_name'];
                    $return['last_name'] = $sel_list['last_name'];
                    $return['user_image'] = $sel_list['user_image'];
                    $return['message'] = $sel_list['message'];

                    unset($return['message_to']);

                    $i++;
                    if ($i == 1)
                        break;
                }
            }else {
                if ($sel_list['message_from'] == $id) {
                    $return['user_id'] = $sel_list['message_from'];
                    $return['first_name'] = $sel_list['first_name'];
                    $return['last_name'] = $sel_list['last_name'];
                    $return['user_image'] = $sel_list['user_image'];
                    $return['message'] = $sel_list['message'];

                    $i++;
                    if ($i == 1)
                        break;
                }

                unset($return['message_from']);
            }
        } array_push($return_arraysel, $return);

        // message to user
        $contition_array = array('is_delete' => '0', 'status' => '1', 'message_to !=' => $userid);
        $search_condition = "((message_from = '$userid') && (message_to != '$id')) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";

        //20-7-2017@nkit
        if ($message_from_profile == 2) {
            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str3[0]['from_table_id'] = 'job_reg.job_id';
            $join_str3[0]['join_type'] = '';

            $tolist = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,fname as first_name,lname as last_name,job_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
        }
        if ($message_from_profile == 1) {
            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str3[0]['from_table_id'] = 'recruiter.rec_id';
            $join_str3[0]['join_type'] = '';
            $contition_array = array('is_delete' => '0', 're_status' => '1');
            $tolist = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array, $data = 'messages.id,message_to,rec_firstname as first_name,rec_lastname as last_name,recruiter_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
        }
        if ($message_from_profile == 4) {
            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str3[0]['from_table_id'] = 'freelancer_hire_reg.reg_id';
            $join_str3[0]['join_type'] = '';

            $tolist = $this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,username as last_name,fullname as first_name,freelancer_hire_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
        }
        if ($message_from_profile == 3) {
            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str3[0]['from_table_id'] = 'freelancer_post_reg.freelancer_post_reg_id';
            $join_str3[0]['join_type'] = '';

            $tolist = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,freelancer_post_fullname as first_name,freelancer_post_username as last_name,freelancer_post_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
        }
        if ($message_from_profile == 5) {
            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str3[0]['from_table_id'] = 'business_profile.business_profile_id';
            $join_str3[0]['join_type'] = '';
            $contition_array = array('business_profile.is_deleted' => '0', 'status' => '1');
            $tolist = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'messages.id,message_to,company_name as first_name,business_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
        }
        if ($message_from_profile == 6) {
            $join_str3[0]['table'] = 'messages';
            $join_str3[0]['join_table_id'] = 'messages.message_to_profile_id';
            $join_str3[0]['from_table_id'] = 'art_reg.art_id';
            $join_str3[0]['join_type'] = '';

            $tolist = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = 'messages.id,message_to,art_name as first_name,art_lastname as last_name,art_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str3, $groupby = '');
        }

        // uniq array of tolist  
        foreach ($tolist as $k => $v) {
            foreach ($tolist as $key => $value) {

                if ($k != $key && $v['message_to'] == $value['message_to']) {
                    unset($tolist[$k]);
                }
            }
        }

        // replace name of message_to in user_id

        $return_arrayto = array();
        foreach ($tolist as $to_list) {
            if ($to_list['message_to'] != $id) {
                $return = array();
                $return = $to_list;

                $return['user_id'] = $to_list['message_to'];
                $return['first_name'] = $to_list['first_name'];
                $return['last_name'] = $to_list['last_name'];
                $return['user_image'] = $to_list['user_image'];
                $return['message'] = $to_list['message'];

                unset($return['message_to']);
                array_push($return_arrayto, $return);
            }
        }

        // message from user
        $contition_array = array('is_delete' => '0', 'status' => '1', 'message_from !=' => $userid);
        $search_condition = "((message_to = '$userid') && (message_from != '$id')) AND ((message_from_profile = $message_from_profile AND message_to_profile = $message_to_profile) OR (message_from_profile = $message_to_profile AND message_to_profile = $message_from_profile)) AND (message_from_profile_id = $message_from_profile_id OR message_to_profile_id = $message_from_profile_id) AND is_message_from_delete != $userid AND is_message_to_delete != $userid";

        //20-7-2017@nkit
        if ($message_from_profile == 1) {
            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str4[0]['from_table_id'] = 'job_reg.job_id';
            $join_str4[0]['join_type'] = '';

            $fromlist = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,fname as first_name,lname as last_name,job_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
        }
        if ($message_from_profile == 2) {
            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str4[0]['from_table_id'] = 'recruiter.rec_id';
            $join_str4[0]['join_type'] = '';
            $contition_array = array('is_delete' => '0', 're_status' => '1');
            $fromlist = $this->common->select_data_by_search('recruiter', $search_condition, $contition_array, $data = 'messages.id,message_from,rec_firstname as first_name,rec_lastname as last_name,recruiter_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
        }
        if ($message_from_profile == 3) {
            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str4[0]['from_table_id'] = 'freelancer_hire_reg.reg_id';
            $join_str4[0]['join_type'] = '';

            $fromlist = $this->common->select_data_by_search('freelancer_hire_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,username as last_name,fullname as first_name,freelancer_hire_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
        }
        if ($message_from_profile == 4) {
            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str4[0]['from_table_id'] = 'freelancer_post_reg.freelancer_post_reg_id';
            $join_str4[0]['join_type'] = '';

            $fromlist = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,freelancer_post_fullname as first_name,freelancer_post_username as last_name,freelancer_post_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
        }
        if ($message_from_profile == 5) {
            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str4[0]['from_table_id'] = 'business_profile.business_profile_id';
            $join_str4[0]['join_type'] = '';
            $contition_array = array('business_profile.is_deleted' => '0', 'status' => '1');
            $fromlist = $this->common->select_data_by_search('business_profile', $search_condition, $contition_array, $data = 'messages.id,message_from,company_name as first_name,business_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
        }
        if ($message_from_profile == 6) {
            $join_str4[0]['table'] = 'messages';
            $join_str4[0]['join_table_id'] = 'messages.message_from_profile_id';
            $join_str4[0]['from_table_id'] = 'art_reg.art_id';
            $join_str4[0]['join_type'] = '';

            $fromlist = $this->common->select_data_by_search('art_reg', $search_condition, $contition_array, $data = 'messages.id,message_from,art_name as first_name,art_lastname as last_name,art_user_image as user_image ,message,user_id', $sortby = 'messages.id', $orderby = 'ASC', $limit = '', $offset = '', $join_str4, $groupby = '');
        }

        // uniq array of fromlist  
        foreach ($fromlist as $k => $v) {
            foreach ($fromlist as $key => $value) {
                if ($k != $key && $v['message_from'] == $value['message_from']) {
                    unset($fromlist[$k]);
                }
            }
        }

// replace name of message_to in user_id

        $return_arrayfrom = array();

        foreach ($fromlist as $from_list) {
            if ($from_list['message_from'] != $id) {
                $return = array();
                $return = $from_list;

                $return['user_id'] = $from_list['message_from'];
                $return['first_name'] = $from_list['first_name'];
                $return['last_name'] = $from_list['last_name'];
                $return['user_image'] = $from_list['user_image'];
                $return['message'] = $from_list['message'];

                unset($return['message_from']);
                array_push($return_arrayfrom, $return);
            }
        }

        $userlist = array_merge($return_arrayto, $return_arrayfrom);

        // uniq array of fromlist  
        foreach ($userlist as $k => $v) {
            foreach ($userlist as $key => $value) {
                if ($k != $key && $v['user_id'] == $value['user_id']) {
                    if ($v['id'] < $value['id']) {
                        unset($userlist[$k]);
                    }
                }
            }
        }
        $userlist = $this->aasort($userlist, "id");

        if ($return_arraysel[0] == '') {
            $return_arraysel = array();
        }

//echo '<pre>';print_r($userlist);
//echo '<pre>';print_r($return_arraysel); die();
        $this->data['userlist'] = array_merge($return_arraysel, $userlist);

//echo '<pre>'; print_r($this->data['userlist']); die();
        // khytai changes 22-4 end
// smily start
        $smileys = _get_smiley_array();
        $this->data['smiley_table'] = $smileys;
// smily end
        // khytai changes end 22-4
        $this->load->view('mobile/mobile_chat_two', $this->data);
    }

}
