<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();


        //    $this->output->cache(1);
        //$this->output->enable_profiler(TRUE);
//COMMENT BY KHYATI 02/12/2017 START
//        $segment_check = $this->uri->segment(2);
//
//        $segment_dynamicpost = substr($segment_check, 0, strrpos($segment_check, "-"));
//
//        if ($segment_dynamicpost) {
//
//            $segment2 = $segment_dynamicpost;
//        } else {
//            $segment2 = $this->uri->segment(2);
//        }
//COMMENT BY KHYATI 02/12/2017 START
        $segment2 = $this->uri->segment(2);
//        jobs live link start
        $jobs = array('0' => 'jobs');
        $jobin = explode('-', $this->uri->segment(1));
        $jobsearchresult = array_intersect((array) $jobs, (array) $jobin);
        if (count($jobsearchresult) > 0) {
            $segment2 = $this->uri->segment(1);
            $segjobloc = $this->uri->segment(1);
        }
        //jobs live link end
//freelancer search live link start
        $projects = array('0' => 'project');
        $projectin = explode('-', $this->uri->segment(1));
        $freelancersearchresult = array_intersect((array) $projects, (array) $projectin);
        if (count($freelancersearchresult) > 0) {
            $segment2 = $this->uri->segment(1);
            $segfreelancerloc = $this->uri->segment(1);
        }

//freelancer search live link end  
        $segment2_names = array('search', 'dashboard', 'details', 'execute_search', 'ajax_user_search', 'ajax_job_search', 'ajax_freelancer_hire_search', 'ajax_freelancer_post_search', 'recruiter_search_candidate', 'business_search', 'ajax_business_user_login_search', 'post', 'ajax_rec_post', 'jobpost', 'project', 'postlocation', $segjobloc, $segfreelancerloc, 'add-post', 'ajax_data', 'get_skill', 'get_degree', 'add-projects', 'profile', 'registration', 'business-information', 'contact-information', 'description', 'image', 'business_registration', 'freelancer-details', 'resume', 'employer-details', 'hire_login', 'rec_check_login','other_filed_live','other_industry_live');

        $segment1 = $this->uri->segment(1);

        $segment1_names = array('job', 'business-profile', 'freelance-hire', 'artist', 'search', 'freelance-work', 'recruiter', 'business_userprofile', $segjobloc, $segfreelancerloc, 'job_profile', 'general', 'projects', 'freelancer_hire');

       //  $actual_link = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];  //code commit by pallavi not working
       // $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";  // code for only http
       $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; // code for both http and https
        //  echo $actual_link;die();
        $actual_link = base64_encode(str_replace('index.php/', '', $actual_link));
        //  echo $actual_link; die();

        if ((!in_array($segment2, $segment2_names)) || (!in_array($segment1, $segment1_names))) {
            if (!$this->session->userdata('aileenuser')) {
                redirect('login?redirect_url=' . $actual_link, 'refresh');
            } else {
                $this->data['userid'] = $this->session->userdata('aileenuser');
            }
        }

        ini_set('gd.jpeg_ignore_warning', 1);

        $user_id = $this->data['userid'];
        $condition_array = array();
        $this->data['loged_in_user'] = $this->common->select_data_by_id('user_info', 'user_id', $user_id, 'user_image', $condition_array);
        date_default_timezone_set('Asia/Calcutta');
    }

    public function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'y<span class="year_mobile">ear</span>',
            'm' => 'm<span class="month_mobile">onth</span>',
            'w' => 'w<span class="week_mobile">eek</span>',
            'd' => 'd<span class="day_mobile">ay</span>',
            'h' => 'h<span class="hour_mobile">our</span>',
            'i' => 'm<span class="minute_mobile">inute</span>',
            's' => 's<span class="second_mobile">econd</span>',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full)
            $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public function random_string($length = 5, $allowed_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890') {
        $allowed_chars_len = strlen($allowed_chars);

        if ($allowed_chars_len == 1) {
            return str_pad('', $length, $allowed_chars);
        } else {
            $result = '';

            while (strlen($result) < $length) {
                $result .= substr($allowed_chars, rand(0, $allowed_chars_len), 1);
            } // while

            return $result;
        }
    }

    public function cwUpload($field_name = '', $target_folder = '', $file_name = '', $thumb = FALSE, $thumb_folder = '', $thumb_width = '', $thumb_height = '') {
        //folder path setup
        $target_path = $target_folder;
        $thumb_path = $thumb_folder;

        //file name setup
        $filename_err = explode(".", $_FILES[$field_name]['name']);
        $filename_err_count = count($filename_err);
        $file_ext = $filename_err[$filename_err_count - 1];
        if ($file_name != '') {
            $fileName = $file_name . '.' . $file_ext;
        } else {
            $fileName = $_FILES[$field_name]['name'];
        }

        //upload image path
        $upload_image = $target_path . basename($fileName);

        //upload image
        if (move_uploaded_file($_FILES[$field_name]['tmp_name'], $upload_image)) {
            //thumbnail creation
            if ($thumb == TRUE) {
                $thumbnail = $thumb_path . $fileName;
                list($width, $height) = getimagesize($upload_image);
                $thumb_create = imagecreatetruecolor($thumb_width, $thumb_height);
                switch ($file_ext) {
                    case 'jpg':
                        $source = imagecreatefromjpeg($upload_image);
                        break;
                    case 'jpeg':
                        $source = imagecreatefromjpeg($upload_image);
                        break;
                    case 'png':
                        $source = imagecreatefrompng($upload_image);
                        break;
                    case 'gif':
                        $source = imagecreatefromgif($upload_image);
                        break;
                    default:
                        $source = imagecreatefromjpeg($upload_image);
                }
                imagecopyresized($thumb_create, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);
                switch ($file_ext) {
                    case 'jpg' || 'jpeg':
                        imagejpeg($thumb_create, $thumbnail, 100);
                        break;
                    case 'png':
                        imagepng($thumb_create, $thumbnail, 100);
                        break;
                    case 'gif':
                        imagegif($thumb_create, $thumbnail, 100);
                        break;
                    default:
                        imagejpeg($thumb_create, $thumbnail, 100);
                }
            }

            return $fileName;
        } else {
            return false;
        }
    }

    public function thumb_img_uplode($upload_image = '', $file_name = '', $thumb_folder = '', $thumb_width = '', $thumb_height = '') {

        $thumbnail = $thumb_folder . $file_name;
        list($width, $height) = getimagesize($upload_image);
        $thumb_create = imagecreatetruecolor($thumb_width, $thumb_height);
        $white = imagecolorallocate($thumb_create, 255, 255, 255);
        imagefill($thumb_create, 0, 0, $white);
        $file_ext = 'png';

        switch ($file_ext) {
            case 'jpg':
                $source = imagecreatefromjpeg($upload_image);
                break;
            case 'jpeg':
                $source = imagecreatefromjpeg($upload_image);
                break;
            case 'png':
                $source = imagecreatefrompng($upload_image);
                break;
            case 'gif':
                $source = imagecreatefromgif($upload_image);
                break;
            default:
                $source = imagecreatefromjpeg($upload_image);
        }


        imagecopyresized($thumb_create, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);
        switch ($file_ext) {
            case 'jpg' || 'jpeg':
                imagejpeg($thumb_create, $thumbnail, 100);
                break;
            case 'png':
                imagepng($thumb_create, $thumbnail, 100);
                break;
            case 'gif':
                imagegif($thumb_create, $thumbnail, 100);
                break;
            default:
                imagejpeg($thumb_create, $thumbnail, 100);
        }
    }

    public function is_validate_name($name = '') {
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function is_validate_email($email = '') {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function is_validate_url($url = '') {
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $url)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
