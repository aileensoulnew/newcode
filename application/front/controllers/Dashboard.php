<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public $data;

    public function __construct() {

        parent::__construct();
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('dashboard_model');
        $this->load->library('S3');
        $this->data['title'] = "Grow Business Network | Hiring | Search Jobs | Freelance Work | Artistic | It's Free";

        //    include('include.php');
    }

    public function index($id = " ") {
       
        $userid = $this->session->userdata('aileenuser');
        $userdata = $this->data['userdata'] = $this->user_model->getUserData($userid);


        $this->data['head'] = $this->load->view('head', $this->data, TRUE);
        $this->data['header'] = $this->load->view('header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);

        $this->load->library('form_validation');

        if ($userdata['user_slider'] == 1) {
            $data = array(
                'user_slider' => '0'
            );
            $updatdata = $this->common->update_data($data, 'user', 'user_id', $userid);
            $data = array(
                'modify_date' => date('Y-m-d H:i:s', time())
            );

            $updatdata = $this->common->update_data($data, 'user_info', 'user_id', $userid);
        }
        $this->data['job'] = $this->dashboard_model->jobRegData($userid);
        $recrdata = $this->data['recrdata'] = $this->dashboard_model->recRegData($userid);
        $hiredata = $this->data['hiredata'] = $this->dashboard_model->hireRegData($userid);
        $workdata = $this->data['workdata'] = $this->dashboard_model->workRegData($userid);
        $this->data['busdata'] = $this->dashboard_model->busRegData($userid);
        $this->data['artdata'] = $this->dashboard_model->artRegData($userid);

        $this->data['title'] = 'Profiles  - Aileensoul';
        $this->load->view('dashboard/cover', $this->data);
    }

    public function logout() {

        //PROGRESSBAR JOB START
        $userid = $this->session->userdata('aileenuser');
        $this->progressbar();
        if ($this->data['count_profile'] == 100) {
            $data = array(
                'progressbar' => '1',
                'modified_date' => date('Y-m-d H:i:s', time())
            );

            $updatedata = $this->common->update_data($data, 'job_reg', 'user_id', $userid);
        } else {
            $data = array(
                'progressbar' => '0',
                'modified_date' => date('Y-m-d H:i:s', time())
            );

            $updatedata = $this->common->update_data($data, 'job_reg', 'user_id', $userid);
        }
        //PROGRESSBAR JOB END
        if ($this->session->userdata('searchkeyword')) {
            $this->session->unset_userdata('searchkeyword');
        }
        if ($this->session->userdata('searchplace')) {
            $this->session->unset_userdata('searchplace');
        }
        //LOGOUT START       
        if ($this->session->userdata('aileenuser')) {


            $this->session->unset_userdata('aileenuser');
            $this->session->unset_userdata('aileenuser_slug');
            $this->session->unset_userdata('aileenuser_fullname');
            $this->clear_all_cache();
            $this->session->sess_destroy();
            redirect(base_url(), 'refresh');
        }
        //LOGOUT END  
    }

    /**
     * Clears all cache from the cache directory
     */
    public function clear_all_cache() {
        $CI = & get_instance();
        $path = $CI->config->item('cache_path');

        $cache_path = ($path == '') ? APPPATH . 'cache/' : $path;

        $handle = opendir($cache_path);
        while (($file = readdir($handle)) !== FALSE) {
            //Leave the directory protection alone
            if ($file != '.htaccess' && $file != 'index.html') {
                @unlink($cache_path . '/' . $file);
            }
        }
        closedir($handle);
    }

// cover pic controller
    public function ajaxpro() {

        $userid = $this->session->userdata('aileenuser');
        $user_reg_data = $this->dashboard_model->getUserBackImage($userid);

        $user_reg_prev_image = $user_reg_data['profile_background'];
        $user_reg_prev_main_image = $user_reg_data['profile_background_main'];

        if ($user_reg_prev_image != '') {
            $user_image_main_path = $this->config->item('user_bg_main_upload_path');
            $user_bg_full_image = $user_image_main_path . $user_reg_prev_image;
            if (isset($user_bg_full_image)) {
                unlink($user_bg_full_image);
            }

            $user_image_thumb_path = $this->config->item('user_bg_thumb_upload_path');
            $user_bg_thumb_image = $user_image_thumb_path . $user_reg_prev_image;
            if (isset($user_bg_thumb_image)) {
                unlink($user_bg_thumb_image);
            }
        }
        if ($user_reg_prev_main_image != '') {
            $user_image_original_path = $this->config->item('user_bg_original_upload_path');
            $user_bg_origin_image = $user_image_original_path . $user_reg_prev_main_image;
            if (isset($user_bg_origin_image)) {
                unlink($user_bg_origin_image);
            }
        }


        $data = $_POST['image'];
        $data = str_replace('data:image/png;base64,', '', $data);
        $data = str_replace(' ', '+', $data);
        $user_bg_path = $this->config->item('user_bg_main_upload_path');
        $imageName = time() . '.png';
        $data = base64_decode($data);
        $file = $user_bg_path . $imageName;
        $success = file_put_contents($file, $data);

        $main_image = $user_bg_path . $imageName;
        $main_image_size = filesize($main_image);

        if ($main_image_size > '1000000') {
            $quality = "50%";
        } elseif ($main_image_size > '50000' && $main_image_size < '1000000') {
            $quality = "55%";
        } elseif ($main_image_size > '5000' && $main_image_size < '50000') {
            $quality = "60%";
        } elseif ($main_image_size > '100' && $main_image_size < '5000') {
            $quality = "65%";
        } elseif ($main_image_size > '1' && $main_image_size < '100') {
            $quality = "70%";
        } else {
            $quality = "100%";
        }

        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
        $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);

        $user_thumb_path = $this->config->item('user_bg_thumb_upload_path');
        $user_thumb_width = $this->config->item('user_bg_thumb_width');
        $user_thumb_height = $this->config->item('user_bg_thumb_height');

        $upload_image = $user_bg_path . $imageName;
        $thumb_image_uplode = $this->thumb_img_uplode($upload_image, $imageName, $user_thumb_path, $user_thumb_width, $user_thumb_height);

        $thumb_image = $user_thumb_path . $imageName;
        $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);

        $data = array(
            'profile_background' => $imageName
        );

        $update = $this->common->update_data($data, 'user_info', 'user_id', $userid);

        $user_reg_data = $this->dashboard_model->getUserBackImage($userid);
        $user_reg_back_image = $user_reg_data['profile_background'];

//        echo '<img src = "' . $this->data['busdata'][0]['profile_background'] . '" />';
        $coverpic = '  <div class="bg-images"><img id="image_src" name="image_src" src = "' . USER_BG_MAIN_UPLOAD_URL . $user_reg_back_image . '" /></div>';

        echo $coverpic;
    }

    public function image() {
        $userid = $this->session->userdata('aileenuser');

        $config['upload_path'] = $this->config->item('user_bg_original_upload_path');
        $config['allowed_types'] = $this->config->item('user_bg_allowed_types');
        $config['file_name'] = $_FILES['image']['name'];

        //Load upload library and initialize configuration
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('image')) {

            $uploadData = $this->upload->data();
            $image = $uploadData['file_name'];
        } else {
            $image = '';
        }


        $data = array(
            'profile_background_main' => $image,
            'modify_date' => date('Y-m-d H:i:s', time())
        );

        $updatedata = $this->common->update_data($data, 'user_info', 'user_id', $userid);
        if ($updatedata) {
            echo $userid;
        } else {
            echo "welcome";
        }
    }

    // cover pic end
// resend email for account verify start

    public function resendverifyaccount() {
        $userid = $this->session->userdata('aileenuser');
        $userdata = $this->common->select_data_by_id('user', 'user_id', $userid, $data = '*', $join_str = array());

        $email = $userdata[0]['user_email'];
        $toemail = "ankit.aileensoul@gmail.com";

        $msg = "Hey !" . $userdata[0]['user_name'] . "<br/>";
        $msg = "hi falgui";
        $subject = "Verify Your Account";

        $mail = $this->email_model->do_email($msg, $subject, $toemail, $from);

        if ($mail) {
            echo "hello";
            die();
        }
    }
    public function closever() {

        $userid = $this->session->userdata('aileenuser');
        $data = array(
            'verify_date' => date('Y-m-d h:i:s', time()),
            'user_verify' => '2'
        );

        $updatedata = $this->common->update_data($data, 'user', 'user_id', $userid);
    }

    // profile image uplaod usingajax start

    public function profilepic() {
        $userid = $this->session->userdata('aileenuser');

        $user_reg_data = $this->dashboard_model->getUserProfileImage($userid);
        $user_reg_prev_image = $user_reg_data['user_image'];

        if ($user_reg_prev_image != '') {
            $user_image_main_path = $this->config->item('user_main_upload_path');
            $user_bg_full_image = $user_image_main_path . $user_reg_prev_image;
            if (isset($user_bg_full_image)) {
                unlink($user_bg_full_image);
            }

            $user_image_thumb_path = $this->config->item('user_thumb_upload_path');
            $user_bg_thumb_image = $user_image_thumb_path . $user_reg_prev_image;
            if (isset($user_bg_thumb_image)) {
                unlink($user_bg_thumb_image);
            }
        }


        $data = $_POST['image'];
        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);
        $user_bg_path = $this->config->item('user_main_upload_path');
        $imageName = time() . '.png';
        $data = base64_decode($data);
        $file = $user_bg_path . $imageName;
        file_put_contents($user_bg_path . $imageName, $data);
        $success = file_put_contents($file, $data);
        $main_image = $user_bg_path . $imageName;
        $main_image_size = filesize($main_image);

        if ($main_image_size > '1000000') {
            $quality = "50%";
        } elseif ($main_image_size > '50000' && $main_image_size < '1000000') {
            $quality = "55%";
        } elseif ($main_image_size > '5000' && $main_image_size < '50000') {
            $quality = "60%";
        } elseif ($main_image_size > '100' && $main_image_size < '5000') {
            $quality = "65%";
        } elseif ($main_image_size > '1' && $main_image_size < '100') {
            $quality = "70%";
        } else {
            $quality = "100%";
        }

        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
        $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);

        $user_thumb_path = $this->config->item('user_thumb_upload_path');
        $user_thumb_width = $this->config->item('user_thumb_width');
        $user_thumb_height = $this->config->item('user_thumb_height');

        $upload_image = $user_bg_path . $imageName;

        $thumb_image_uplode = $this->thumb_img_uplode($upload_image, $imageName, $user_thumb_path, $user_thumb_width, $user_thumb_height);

        $thumb_image = $user_thumb_path . $imageName;
        $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);

        $data = array(
            'user_image' => $imageName,
            'modify_date' => date('Y-m-d H:i:s', time())
        );

        $update = $this->common->update_data($data, 'user_info', 'user_id', $userid);

        if ($update) {

            $user_reg_data = $this->dashboard_model->getUserProfileImage($userid);
            $user_reg_prev_image = $user_reg_data['user_image'];

            $userimage = '<img src="' . USER_THUMB_UPLOAD_URL . $user_reg_prev_image . '" alt="User Image" >';
            $userimage .= ' <a class="upload-profile" href="javascript:void(0);" onclick="updateprofilepopup();">
                                                <img src="' . base_url('assets/img/cam.png?ver=' . time()) . '">Update Profile Picture</a>';
        }

        $userimagehead = '<img class="img-circle" height="50" width="50" alt="Smiley face" src="' . USER_THUMB_UPLOAD_URL . $user_reg_prev_image . '" alt="" >';

        echo json_encode(
                array(
                    "uimage" => $userimage,
                    "uimagehead" => $userimagehead,
        ));
    }

//FOR PROGRESSBAR COUNT COMMON FUNCTION START
    public function progressbar() {
        $userid = $this->session->userdata('aileenuser');
        //For Counting Profile data start
        $contition_array = array('user_id' => $userid, 'status' => '1', 'is_delete' => '0');

        $job_reg = $this->common->select_data_by_condition('job_reg', $contition_array, $data = 'fname,lname,email,experience,keyskill,work_job_title,work_job_industry,work_job_city,phnno,language,dob,gender,city_id,pincode,address,project_name,project_duration,project_description,training_as,training_duration,training_organization', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = array());

        $count = 0;

        if ($job_reg[0]['fname'] != '') {
            $count++;
        }
        if ($job_reg[0]['lname'] != '') {
            $count++;
        }
        if ($job_reg[0]['email'] != '') {
            $count++;
        }
        if ($job_reg[0]['keyskill'] != '') {
            $count++;
        }

        if ($job_reg[0]['work_job_title'] != '') {
            $count++;
        }
        if ($job_reg[0]['work_job_industry'] != '') {
            $count++;
        }
        if ($job_reg[0]['work_job_city'] != '') {
            $count++;
        }
        if ($job_reg[0]['phnno'] != '') {
            $count++;
        }
        if ($job_reg[0]['language'] != '') {
            $count++;
        }
        if ($job_reg[0]['dob'] != '0000-00-00') {
            $count++;
        }
        if ($job_reg[0]['gender'] != '') {
            $count++;
        }
        if ($job_reg[0]['city_id'] != '0') {
            $count++;
        }
        if ($job_reg[0]['pincode'] != '') {
            $count++;
        }
        if ($job_reg[0]['address'] != '') {
            $count++;
        }
        if ($job_reg[0]['project_name'] != '') {
            $count++;
        }
        if ($job_reg[0]['project_duration'] != '') {
            $count++;
        }
        if ($job_reg[0]['project_description'] != '') {
            $count++;
        }
        if ($job_reg[0]['training_as'] != '') {
            $count++;
        }
        if ($job_reg[0]['training_duration'] != '') {
            $count++;
        }
        if ($job_reg[0]['training_organization'] != '') {
            $count++;
        }

        $contition_array = array('user_id' => $userid, 'status' => '1', 'is_delete' => '0');
        $job_add_edu = $this->common->select_data_by_condition('job_add_edu', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('user_id' => $userid);
        $jobgrad = $this->common->select_data_by_condition('job_graduation', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        if ($job_add_edu[0]['board_primary'] != '' || $job_add_edu[0]['board_secondary'] != '' || $job_add_edu[0]['board_higher_secondary'] != '' || $jobgrad[0]['degree'] != '') {
            $count++;
        }
        if (($job_add_edu[0]['board_primary'] != '' && $job_add_edu[0]['edu_certificate_primary'] != '') || ($job_add_edu[0]['board_secondary'] != '' && $job_add_edu[0]['edu_certificate_secondary'] != '') || ($job_add_edu[0]['board_higher_secondary'] != '' && $job_add_edu[0]['edu_certificate_higher_secondary'] != '') || ($jobgrad[0]['degree'] != '' && $jobgrad[0]['grade'] != '' && $jobgrad[0]['edu_certificate'] != '')) {
            $count++;
        }


        $contition_array = array('user_id' => $userid, 'experience !=' => 'Fresher', 'status' => '1');
        $workdata = $this->common->select_data_by_condition('job_add_workexp', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        if (($job_reg[0]['experience'] != '' && $job_reg[0]['experience'] != 'Experience') || ($workdata[0]['experience_year'] != '' && $workdata[0]['companyemail'] != '' && $workdata[0]['companyphn'] != '' && $workdata[0]['work_certificate'] != '')) {
            $count++;
        }

        $count_profile = ($count * 100) / 23;
        $this->data['count_profile'] = $count_profile;
        $this->data['count_profile_value'] = ($count_profile / 100);
    }

//FOR PROGRESSBAR COUNT COMMON FUNCTION END

    public function header_all_dropdown_list() {
        $return_html = '<ul><li> <div class="all-down"> <a href="' . base_url('artist') . '"> <div class="all-img"> <img alt="artist-profile" src="' . base_url('assets/img/i5.jpg') . '"> </div><div class="text-all"> Artistic Profile </div></a> </div></li><li> <div class="all-down"> <a href="' . base_url('business-profile') . '"> <div class="all-img"> <img alt="business-profile" src="' . base_url('assets/img/i4.jpg') . '"> </div><div class="text-all"> Business Profile </div></a> </div></li><li><div class="all-down"> <a href="' . base_url('job') . '"> <div class="all-img"> <img alt="job-profile" src="' . base_url('assets/img/i1.jpg') . '"> </div><div class="text-all"> Job Profile </div></a> </div></li><li> <div class="all-down"> <a href="' . base_url('recruiter') . '"> <div class="all-img"> <img alt="Recruiter-profile" src="' . base_url('assets/img/i2.jpg') . '"> </div><div class="text-all"> Recruiter Profile </div></a> </div></li><li> <div class="all-down"> <a href="' . base_url('freelance') . '"> <div class="all-img"> <img alt="Freelance-profile" src="' . base_url('assets/img/i3.jpg') . '"> </div><div class="text-all"> Freelance Profile </div></a> </div></li></ul>';

        echo json_encode(array('return_html' => $return_html));
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
