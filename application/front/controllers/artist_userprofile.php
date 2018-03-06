<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Artist_userprofile extends CI_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('user_agent');
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->lang->load('message', 'english');
        $this->load->helper('smiley');
        //AWS access info start
        $this->load->library('S3');
        //AWS access info end

        $userid = $this->session->userdata('aileenuser');
        include ('artistic_include.php');

        $this->data['no_artistic_post_html'] = '<div class="art_no_post_avl"><h3>Artistic Post</h3><div class="art-img-nn"><div class="art_no_post_img"><img src=' . base_url('assets/img/art-no.png') . '></div><div class="art_no_post_text">No Post Available.</div></div></div>';
    }

   public function index() {
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'status' => '0');
        $artdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if ($artdata) {

            $this->load->view('artist/reactivate', $this->data);
        } else {

            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $artdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $this->data['art'] = $this->common->select_data_by_condition('user', $contition_array, $data = 'user_id,first_name,last_name,user_email', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if (count($artdata) > 0) {
                if ($artdata[0]['art_step'] == '1') {
                    redirect('artist/artistic-address', refresh);
                } else if ($artdata[0]['art_step'] == '2') {
                    redirect('artist/artistic-information', refresh);
                } else if ($artdata[0]['art_step'] == '3') { //echo "123"; die();
                    redirect('artist/artistic-portfolio', refresh);
                } else if ($artdata[0]['art_step'] == '4') {
                    redirect('artist/home', refresh);
                }
            } else {
                $this->load->view('artist/art_basic_information', $this->data);
            }
        }
    }

    public function artistic_user_photos() {

         $id = $_POST['art_id'];
        // manage post start
        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');


        $contition_array = array('user_id' => $id, 'status' => '1', 'art_step' => '4');
        $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
      
        $contition_array = array('user_id' => $artisticdata[0]['user_id']);
        $artimage = $this->data['artimage'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = 'art_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');



        foreach ($artimage as $val) {

            $contition_array = array('post_id' => $val['art_post_id'], 'is_deleted' => '1', 'insert_profile' => '1');
            $artmultiimage = $this->data['artmultiimage'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = 'post_files_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            $multipleimage[] = $artmultiimage;
        }
        $allowed = array('jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg');

        foreach ($multipleimage as $mke => $mval) {

                            foreach ($mval as $mke1 => $mval1) {
                                $ext = pathinfo($mval1['file_name'], PATHINFO_EXTENSION);

                                if (in_array($ext, $allowed)) {
                                    $singlearray[] = $mval1;
                                }
                            }
                        }

        if ($singlearray) {
            $i = 0;
            foreach ($singlearray as $mi) {
                $fetch_result .= '<div class="image_profile">';
                $fetch_result .= '<img src="' . ART_POST_THUMB_UPLOAD_URL . $mi['file_name'] . '" alt="img1">';
                $fetch_result .= '</div>';

                $i++;
                if ($i == 6)
                    break;
            }
        } else {

        }

        $fetch_result .= '<div class="dataconphoto"></div>';

        echo $fetch_result;
    }

    public function artistic_user_videos() {

        $s3 = new S3(awsAccessKey, awsSecretKey);
        $id = $_POST['art_id'];
        // manage post start       
        $contition_array = array('user_id' => $id, 'status' => '1', 'art_step' => '4');
        $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

       $contition_array = array('user_id' => $artisticdata[0]['user_id']);
       $artimage = $this->data['artimage'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = 'art_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        foreach ($artimage as $val) {
           $contition_array = array('post_id' => $val['art_post_id'], 'is_deleted' => '1', 'insert_profile' => '1', 'post_format' => 'video');
           $artmultivideo = $this->data['artmultivideo'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = 'post_files_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $multiplevideo[] = $artmultivideo;
        }

        $singlearray1 = array_reduce($multiplevideo, 'array_merge', array());

        if ($singlearray1) {
            $fetch_video .= '<tr>';

            if ($singlearray1[0]['file_name']) {

                $post_poster = $singlearray1[0]['file_name'];
                $post_poster1 = explode('.', $post_poster);
                $post_poster2 = end($post_poster1);
                $post_poster = str_replace($post_poster2, 'png', $post_poster);
        
                if (IMAGEPATHFROM == 'upload') {
                    $fetch_video .= '<td class = "image_profile">';
                    if (file_exists(ART_POST_MAIN_UPLOAD_URL . $post_poster)) {
                        $fetch_video .= '<video controls poster="' . ART_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . ART_POST_MAIN_UPLOAD_URL . $singlearray1[0]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                }
                else {
                    $fetch_video .= '<td class = "image_profile">';

                     $filename = $this->config->item('art_post_main_upload_path') . $singlearray1[0]['file_name'];
                     $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                    if ($info) { 

                      $postposter = $this->config->item('art_post_main_upload_path') . $post_poster;
                       $this->data['postposter'] = $postposter = $s3->getObjectInfo(bucket, $postposter);

                        if($postposter){
                        $fetch_video .= '<video controls poster="' . ART_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                       }else{
                        $fetch_video .= '<video controls>';
                       }
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . ART_POST_MAIN_UPLOAD_URL . $singlearray1[0]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                }

            }

            if ($singlearray1[1]['file_name']) {
                $post_poster = $singlearray1[1]['file_name'];
                $post_poster1 = explode('.', $post_poster);
                $post_poster2 = end($post_poster1);
                $post_poster = str_replace($post_poster2, 'png', $post_poster);

                if (IMAGEPATHFROM == 'upload') {
                    $fetch_video .= '<td class = "image_profile">';
                    if (file_exists(ART_POST_MAIN_UPLOAD_URL . $post_poster)) {
                        $fetch_video .= '<video controls poster="' . ART_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . ART_POST_MAIN_UPLOAD_URL . $singlearray1[1]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                } else {
                    $fetch_video .= '<td class = "image_profile">';

                    $filename = $this->config->item('art_post_main_upload_path') . $singlearray1[1]['file_name'];
                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                    if ($info) {
                       $postposter = $this->config->item('art_post_main_upload_path') . $post_poster;
                       $this->data['postposter'] = $postposter = $s3->getObjectInfo(bucket, $postposter);

                        if($postposter){
                        $fetch_video .= '<video controls poster="' . ART_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                       }else{
                        $fetch_video .= '<video controls>';
                       }
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . ART_POST_MAIN_UPLOAD_URL . $singlearray1[1]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                }
            }
            if ($singlearray1[2]['file_name']) {
                $post_poster = $singlearray1[2]['file_name'];
                $post_poster1 = explode('.', $post_poster);
                $post_poster2 = end($post_poster1);
                $post_poster = str_replace($post_poster2, 'png', $post_poster);

                if (IMAGEPATHFROM == 'upload') {
                    $fetch_video .= '<td class = "image_profile">';
                    if (file_exists(ART_POST_MAIN_UPLOAD_URL . $post_poster)) {
                        $fetch_video .= '<video controls poster="' . ART_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . ART_POST_MAIN_UPLOAD_URL . $singlearray1[2]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                } else {
                    $fetch_video .= '<td class = "image_profile">';

                    $filename = $this->config->item('art_post_main_upload_path') . $singlearray1[2]['file_name'];
                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                    if ($info) {
                       $postposter = $this->config->item('art_post_main_upload_path') . $post_poster;
                       $this->data['postposter'] = $postposter = $s3->getObjectInfo(bucket, $postposter);

                        if($postposter){
                        $fetch_video .= '<video controls poster="' . ART_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                       }else{
                        $fetch_video .= '<video controls>';
                       }
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . ART_POST_MAIN_UPLOAD_URL . $singlearray1[2]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                }
            }
            $fetch_video .= '</tr>';
            $fetch_video .= '<tr>';

            if ($singlearray1[3]['file_name']) {
                $post_poster = $singlearray1[3]['file_name'];
                $post_poster1 = explode('.', $post_poster);
                $post_poster2 = end($post_poster1);
                $post_poster = str_replace($post_poster2, 'png', $post_poster);

                if (IMAGEPATHFROM == 'upload') {
                    $fetch_video .= '<td class = "image_profile">';
                    if (file_exists(ART_POST_MAIN_UPLOAD_URL . $post_poster)) {
                        $fetch_video .= '<video controls poster="' . ART_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . ART_POST_MAIN_UPLOAD_URL . $singlearray1[3]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                } else {
                    $fetch_video .= '<td class = "image_profile">';

                    $filename = $this->config->item('art_post_main_upload_path') . $singlearray1[3]['file_name'];
                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                    if ($info) {
                       $postposter = $this->config->item('art_post_main_upload_path') . $post_poster;
                       $this->data['postposter'] = $postposter = $s3->getObjectInfo(bucket, $postposter);

                        if($postposter){
                        $fetch_video .= '<video controls poster="' . ART_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                       }else{
                        $fetch_video .= '<video controls>';
                       }
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . ART_POST_MAIN_UPLOAD_URL . $singlearray1[3]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                }
            }
            if ($singlearray1[4]['file_name']) {
                $post_poster = $singlearray1[4]['file_name'];
                $post_poster1 = explode('.', $post_poster);
                $post_poster2 = end($post_poster1);
                $post_poster = str_replace($post_poster2, 'png', $post_poster);

                if (IMAGEPATHFROM == 'upload') {
                    $fetch_video .= '<td class = "image_profile">';
                    if (file_exists(ART_POST_MAIN_UPLOAD_URL . $post_poster)) {
                        $fetch_video .= '<video controls poster="' . ART_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . ART_POST_MAIN_UPLOAD_URL . $singlearray1[4]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                } else {
                    $fetch_video .= '<td class = "image_profile">';

                    $filename = $this->config->item('art_post_main_upload_path') . $singlearray1[4]['file_name'];
                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                    if ($info) {
                        $postposter = $this->config->item('art_post_main_upload_path') . $post_poster;
                       $this->data['postposter'] = $postposter = $s3->getObjectInfo(bucket, $postposter);

                        if($postposter){
                        $fetch_video .= '<video controls poster="' . ART_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                       }else{
                        $fetch_video .= '<video controls>';
                       }
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . ART_POST_MAIN_UPLOAD_URL . $singlearray1[4]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                }
            }
            if ($singlearray1[5]['file_name']) {
                $post_poster = $singlearray1[5]['file_name'];
                $post_poster1 = explode('.', $post_poster);
                $post_poster2 = end($post_poster1);
                $post_poster = str_replace($post_poster2, 'png', $post_poster);

                if (IMAGEPATHFROM == 'upload') {
                    $fetch_video .= '<td class = "image_profile">';
                    if (file_exists(ART_POST_MAIN_UPLOAD_URL . $post_poster)) {
                        $fetch_video .= '<video controls poster="' . ART_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . ART_POST_MAIN_UPLOAD_URL . $singlearray1[5]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                } else {
                    $fetch_video .= '<td class = "image_profile">';

                    $filename = $this->config->item('art_post_main_upload_path') . $singlearray1[5]['file_name'];
                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                    if ($info) {
                        $postposter = $this->config->item('art_post_main_upload_path') . $post_poster;
                       $this->data['postposter'] = $postposter = $s3->getObjectInfo(bucket, $postposter);

                        if($postposter){
                        $fetch_video .= '<video controls poster="' . ART_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                       }else{
                        $fetch_video .= '<video controls>';
                       }
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . ART_POST_MAIN_UPLOAD_URL . $singlearray1[5]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= '<source src = "movie.ogg" type = "video/ogg">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                }
            }
            $fetch_video .= '</tr>';
        } else {

        }

        $fetch_video .= '<div class="dataconvideo"></div>';


        echo $fetch_video;
    }

    public function artistic_user_audio() {

        $id = $_POST['art_id'];
        // manage post start
        
            $contition_array = array('user_id' => $id, 'status' => '1', 'art_step' => '4');
            $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
    
         $contition_array = array('user_id' => $artisticdata[0]['user_id']);
         $artimage = $this->data['artimage'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = 'art_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        foreach ($artimage as $val) {

            $contition_array = array('post_id' => $val['art_post_id'], 'is_deleted' => '1', 'insert_profile' => '1');
            $artmultiaudio = $this->data['artmultiaudio'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = 'post_files_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            $multipleaudio[] = $artmultiaudio;
        }

        $allowesaudio = array('mp3');

        foreach ($multipleaudio as $mke => $mval) {

                                foreach ($mval as $mke1 => $mval1) {
                                    $ext = pathinfo($mval1['file_name'], PATHINFO_EXTENSION);

                                    if (in_array($ext, $allowesaudio)) {
                                        $singlearray2[] = $mval1;
                                    }
                                }
            }

        if ($singlearray2) {
            $fetchaudio .= '<tr>';

            if ($singlearray2[0]['file_name']) {
                $fetchaudio .= '<td class="image_profile">';
                $fetchaudio .= '<audio  controls>';

                $fetchaudio .= '<source src="' . ART_POST_MAIN_UPLOAD_URL . $singlearray2[0]['file_name'] . '" type="audio/mp3">';
                $fetchaudio .= '<source src="movie.ogg" type="audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</audio>';
                $fetchaudio .= '</td>';
            }

            if ($singlearray2[1]['file_name']) {
                $fetchaudio .= '<td class="image_profile">';
                $fetchaudio .= '<audio  controls>';
                $fetchaudio .= '<source src="' . ART_POST_MAIN_UPLOAD_URL . $singlearray2[1]['file_name'] . '" type="audio/mp3">';
                $fetchaudio .= '<source src="movie.ogg" type="audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</audio>';
                $fetchaudio .= '</td>';
            }
            if ($singlearray2[2]['file_name']) {
                $fetchaudio .= '<td class="image_profile">';
                $fetchaudio .= '<audio  controls>';
                $fetchaudio .= '<source src="' . ART_POST_MAIN_UPLOAD_URL . $singlearray2[2]['file_name'] . '" type="audio/mp3">';
                $fetchaudio .= '<source src="movie.ogg" type="audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</audio>';
                $fetchaudio .= '</td>';
            }
            $fetchaudio .= '</tr>';
            $fetchaudio .= '<tr>';

            if ($singlearray2[3]['file_name']) {
                $fetchaudio .= '<td class="image_profile">';
                $fetchaudio .= '<audio  controls>';
                $fetchaudio .= '<source src="' . ART_POST_MAIN_UPLOAD_URL . $singlearray2[3]['file_name'] . '" type="audio/mp3">';
                $fetchaudio .= '<source src="movie.ogg" type="audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</audio>';
                $fetchaudio .= '</td>';
            }
            if ($singlearray2[4]['file_name']) {
                $fetchaudio .= '<td class="image_profile">';
                $fetchaudio .= '<audio  controls>';
                $fetchaudio .= '<source src="' . ART_POST_MAIN_UPLOAD_URL . $singlearray2[4]['file_name'] . '" type="audio/mp3">';
                $fetchaudio .= '<source src="movie.ogg" type="audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</audio>';
                $fetchaudio .= '</td>';
            }
            if ($singlearray2[5]['file_name']) {
                $fetchaudio .= '<td class="image_profile">';
                $fetchaudio .= '<audio  controls>';
                $fetchaudio .= '<source src="' . ART_POST_MAIN_UPLOAD_URL . $singlearray2[5]['file_name'] . '" type="audio/mp3">';
                $fetchaudio .= '<source src="movie.ogg" type="audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</audio>';
                $fetchaudio .= '</td>';
            }
            $fetchaudio .= '</tr>';
        } else {
           
        }
        $fetchaudio .= '<div class="dataconaudio"></div>';
        echo $fetchaudio;
    }

    public function artistic_user_pdf() {
       $id = $_POST['art_id'];
        
            $contition_array = array('user_id' => $id, 'status' => '1', 'art_step' => '4');
            $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('user_id' => $artisticdata[0]['user_id']);
        $artimage = $this->data['artimage'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = 'art_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        foreach ($artimage as $val) {

                                $contition_array = array('post_id' => $val['art_post_id'], 'is_deleted' => '1', 'insert_profile' => '1');
                                $artmultipdf = $this->data['artmultipdf'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = 'post_files_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                                $multiplepdf[] = $artmultipdf;
                            }

        $allowespdf = array('pdf');
         foreach ($multiplepdf as $mke => $mval) {

                                foreach ($mval as $mke1 => $mval1) {
                                    $ext = pathinfo($mval1['file_name'], PATHINFO_EXTENSION);

                                    if (in_array($ext, $allowespdf)) {
                                        $singlearray3[] = $mval1;
                                    }
                                }
                            }

        if ($singlearray3) {

            $i = 0;
            foreach ($singlearray3 as $mi) {

                $fetch_pdf .= '<div class="image_profile">';
                $fetch_pdf .= '<a href="'.ART_POST_MAIN_UPLOAD_URL . $mi['file_name'].'"><div class = "pdf_img">';
                 $fetch_pdf .= '<img src = "' . base_url('assets/images/PDF.jpg') . '" style = "height: 50%; width: 50%;">';
                $fetch_pdf .= '</div></a>';
                $fetch_pdf .= '</div>';

                $i++;
                if ($i == 6)
                    break;
            }
        } else {
            
        }
        $fetch_pdf .= '<div class="dataconpdf"></div>';
        echo $fetch_pdf;
    }

    public function artistic_user_dashboard_post($id = '') {
      
      $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;

            $contition_array = array('user_id' => $id, 'status' => '1', 'art_step' => '4');
            $artisticdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('user_id' => $id, 'status' => '1', 'is_delete' => '0');
            $artsdata = $this->common->select_data_by_condition('art_post', $contition_array, $data, $sortby = 'art_post_id', $orderby = 'DESC', $limit, $offset, $join_str = array(), $groupby = '');

        $return_html = '';

        $artsdata1 = array_slice($artsdata, $start, $perpage);

        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($artsdata);
        }

        $return_html .= '<input type = "hidden" class = "page_number" value = "' . $page . '" />';
        $return_html .= '<input type = "hidden" class = "total_record" value = "' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';
        if (count($artsdata) > 0) {

            foreach ($artsdata1 as $row) {
                $contition_array = array('user_id' => $row['user_id'], 'status' => '1');
                $artisticdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $return_html .= '<div id = "removepost' . $row['art_post_id'] . '">
<div class = "profile-job-post-detail clearfix">
<div class = "post-design-box">
<div class = "post-design-top col-md-12" >
<div class = "post-design-pro-img">';
                $userid = $this->session->userdata('aileenuser');
                $userimage = $this->db->select('art_user_image')->get_where('art_reg', array('user_id' => $row['user_id']))->row()->art_user_image;
                $userimageposted = $this->db->select('art_user_image')->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->art_user_image;

                $firstname = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $row['user_id']))->row()->art_name;
                $lastname = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $row['user_id']))->row()->art_lastname;

                $slug = $this->db->select('slug')->get_where('art_reg', array('user_id' => $row['user_id']))->row()->slug;

                $firstnameposted = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->art_name;
                $lastnameposted = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->art_lastname;
                $slugposted = $this->db->select('slug')->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->slug;

                if ($row['posted_user_id']) {

                    if (IMAGEPATHFROM == 'upload') {
                        if($userimageposted){
                        if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $userimageposted)) {
                                       
                                        $return_html .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "">';
                                        
                                     } else { 
                                        $return_html .= '<img src="'. ART_PROFILE_THUMB_UPLOAD_URL . $userimageposted.'" alt="" >';
                                    }
                                 }else{
                                        $return_html .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "">';

                                 }
                                } else{
                    
                    $filename = $this->config->item('art_profile_thumb_upload_path') . $userimageposted;
                      $s3 = new S3(awsAccessKey, awsSecretKey);
                     $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);

                        if ($info) {

                             $return_html .= '<a  class="post_dot" title="'.ucfirst(strtolower($firstnameposted)) . ' ' . ucfirst(strtolower($lastnameposted)).'" href = "javascript:void(0)" target="_blank" onclick="login_profile();">';
                            $return_html .= '<img src = "' . ART_PROFILE_THUMB_UPLOAD_URL . $userimageposted . '" name = "image_src" id = "image_src" />';       
                            $return_html .= '</a>';

                        } else {

                             $return_html .= '<a  class="post_dot" title="'.ucfirst(strtolower($firstnameposted)) . ' ' . ucfirst(strtolower($lastnameposted)).'" href = "javascript:void(0)" target="_blank" onclick="login_profile();">';
                            $return_html .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "">';                                    
                             $return_html .= '</a>';
                        }
                     }
                } else {
                    
                    if (IMAGEPATHFROM == 'upload') {

                        $return_html .= '<a  class="post_dot" href = "javascript:void(0)" target="_blank" onclick="login_profile();">';

                        if($userimage){
                        if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $userimage)) {
                                       
                                        $return_html .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "">';
                                        
                                     } else { 
                                        $return_html .= '<img src="'. ART_PROFILE_THUMB_UPLOAD_URL . $userimage.'" alt="" >';
                                    }
                                 }else{
                                    $return_html .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "">';

                                 }
                               $return_html .= '<a>';  
                                } else{

                    $filename = $this->config->item('art_profile_thumb_upload_path') . $userimage;
                      $s3 = new S3(awsAccessKey, awsSecretKey);
                     $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);

                        if ($info) {

                             $return_html .= '<a  class="post_dot" title="'.ucfirst(strtolower($firstname)). ' ' . ucfirst(strtolower($lastname)).'"  href ="javascript:void(0)" target="_blank" onclick="login_profile();">';

                            $return_html .= '<img src = "' . ART_PROFILE_THUMB_UPLOAD_URL . $userimage . '" name = "image_src" id = "image_src" />';
                              
                            $return_html .= '</a>';
                        } else {

                             $return_html .= '<a  class="post_dot" title="'.ucfirst(strtolower($firstname)). ' ' . ucfirst(strtolower($lastname)).'"  href = "javascript:void(0)" target="_blank" onclick="login_profile();">';
                            $return_html .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "">';   

                            $return_html .= '</a>';
                        }
                     }
                   
                }
                $return_html .= '</div>
<div class = "post-design-name fl col-xs-8 col-md-10">
<ul>';
                $firstname = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $row['user_id']))->row()->art_name;
                $lastname = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $row['user_id']))->row()->art_lastname;

                 $slug = $this->db->select('slug')->get_where('art_reg', array('user_id' => $row['user_id']))->row()->slug;


               $firstnameposted = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->art_name;
               $lastnameposted = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->art_lastname;

               $slugposted = $this->db->select('slug')->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->slug;
                                                              
              $designation = $this->db->select('designation')->get_where('art_reg', array('user_id' => $row['user_id']))->row()->designation;

                if ($row['posted_user_id']) {
                    $return_html .= '<li>
<div class = "else_post_d">
<div class = "post-design-product">
<a style = "max-width: 40%;" class = "post_dot" title = "' . ucfirst(strtolower($firstnameposted)) .'&nbsp;'. ucfirst(strtolower($lastnameposted)) . '" href = "javascript:void(0)" target="_blank" onclick="login_profile();">' . ucfirst(strtolower($firstnameposted)). '&nbsp;' .ucfirst(strtolower($lastnameposted)).  '</a>
<p class = "posted_with" > Posted With</p>
<a class = "other_name post_dot" href = "javascript:void(0)" target="_blank" onclick="login_profile();">' .ucfirst(strtolower($firstname)).'&nbsp;'.ucfirst(strtolower($lastname)).'</a>
<span role = "presentation" aria-hidden = "true"> · </span> <span class = "ctre_date">' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($row['created_date']))) . '</span>
</div></div>
</li>';
                } else {
                    $return_html .= '<li><div class = "post-design-product"><a class = "post_dot" title = "' . ucfirst(strtolower($firstname)) .'&nbsp;'.ucfirst(strtolower($lastname)).'" href = "javascript:void(0)" target="_blank" onclick="login_profile();">'.ucfirst(strtolower($firstname)) . ' ' . ucfirst(strtolower($lastname)).'</a>
<span role = "presentation" aria-hidden = "true"> · </span>
<div class = "datespan">
<span class = "ctre_date">' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($row['created_date']))) . '</span>
</div>
</div>
</li>';
                }
                
                $return_html .= '<li><div class = "post-design-product"> <a class = "buuis_desc_a" title = "Designation">';

                if ($designation) {
                    $return_html .= ucfirst(strtolower($designation));
                } else {
                    $return_html .= 'Current Work.';
                }

                $return_html .= '</a> </div>
</li>
<li>
</li>
</ul>
</div>';

 if($userid == $row['posted_user_id'] || $row['user_id'] == $userid){

 $return_html .= '<div class = "dropdown2">
<a  href = "javascript:void(0)" target="_blank" onclick="login_profile();" class = " dropbtn2 fa fa-ellipsis-v"></a>
<div id = "myDropdown' . $row['art_post_id'] . '" class = "dropdown-content2 ">';
                if ($row['posted_user_id'] != 0) {
                    if ($this->session->userdata('aileenuser') == $row['posted_user_id']) {
                        $return_html .= '<a onclick = "deleteownpostmodel(' . $row['art_post_id'] . ')">
<i class = "fa fa-trash-o" aria-hidden = "true">
</i> Delete Post
</a>
<a id = "' . $row['art_post_id'] . '" href = "javascript:void(0)" target="_blank" onclick="login_profile();">
<i class = "fa fa-pencil-square-o" aria-hidden = "true">
</i>Edit
</a>';
                    } else {
                        $return_html .= '<a href = "javascript:void(0)" target="_blank" onclick="login_profile();">
<i class = "fa fa-trash-o" aria-hidden = "true">
</i> Delete Post
</a>';

                    }
                } else {
                    if ($this->session->userdata('aileenuser') == $row['user_id']) {
                        $return_html .= '<a href = "javascript:void(0)" target="_blank" onclick="login_profile();"><i class = "fa fa-trash-o" aria-hidden = "true"></i> Delete Post</a>
<a id = "' . $row['art_post_id'] . '" href = "javascript:void(0)" target="_blank" onclick="login_profile();"><i class = "fa fa-pencil-square-o" aria-hidden = "true"></i>Edit</a>';
                    } else {
                        
                    }
                }
                $return_html .= '</div>
</div>';
       }    
                if ($row['art_post'] || $row['art_description']) {
                    $return_html .= '<div class = "post-design-desc ">';
                }
                $return_html .= '<div class = "ft-15 t_artd">
<div id = "editpostdata' . $row['art_post_id'] . '" style = "display:block;">
<a id="editpostval' . $row['art_post_id'].'">' . $this->common->make_links($row['art_post']) . '</a>
</div>
<div id = "editpostbox' . $row['art_post_id'] . '" style = "display:none;">
<input type = "text" class="my_text" id = "editpostname' . $row['art_post_id'] . '" name = "editpostname" placeholder = "Title" value = "' . $row['art_post'] . '" onKeyDown = check_lengthedit(' . $row['art_post_id'] . ') onKeyup = check_lengthedit(' . $row['art_post_id'] . ');
onblur = check_lengthedit(' . $row['art_post_id'] . ')>';
                if ($row['art_post']) {
                    $counter = $row['art_post'];
                    $a = strlen($counter);
                    $return_html .= '<input size = 1 id = "text_num_' . $row['art_post_id'] . '" class = "text_num" value = "' . (50 - $a) . '" name = text_num disabled="disabled">';
                } else {
                    $return_html .= '<input size = 1 id = "text_num_' . $row['art_post_id'] . '" class = "text_num" value = 50 name = text_num disabled="disabled">';
                }
                $return_html .= '</div>
</div>
<div id = "khyati' . $row['art_post_id'] . '" style = "display:block;">';

                                       $num_words = 29;
                                       $words = array();
                                       $words = explode(" ",  $row['art_description'], $num_words);
                                       $shown_string = "";
                                       
                                       if(count($words) == 29){
                                       $words[28] ='... <span id="kkkk" onClick="khdiv(' . $row['art_post_id'] . ')">View More</span>';
                                       }
                                       
                                       $shown_string = implode(" ", $words);
                                       $return_html .= $this->common->make_links($shown_string);
                


                $return_html .= '</div>
<div id = "khyatii' . $row['art_post_id'] . '" style = "display:none;">';
                $return_html .= $this->common->make_links($row['art_description']);
                $return_html .= '</div>
<div id = "editpostdetailbox' . $row['art_post_id'] . '" style = "display:none;">
<div contenteditable = "true" id = "editpostdesc' . $row['art_post_id'] . '" class = "textbuis editable_text" placeholder = "Description" name = "editpostdesc" onpaste = "OnPaste_StripFormatting(this, event);" onfocus="return cursorpointer(' . $row['art_post_id'] . ');">' . $row['art_description'] . '</div>
</div><button class = "fr" id = "editpostsubmit' . $row['art_post_id'] . '" style="display:none; margin: 5px 0;" onClick="edit_postinsert(' . $row['art_post_id'] . ')">Save</button>
</div> ';
                if ($row['art_post'] || $row['art_description']) {
                    $return_html .= '</div>';
                }
                $return_html .= '<div class="post-design-mid col-md-12" >  
    <div class="mange_post_image">';

                $contition_array = array('post_id' => $row['art_post_id'], 'is_deleted' => '1', 'insert_profile' => '1');
                $artmultiimage = $this->data['artmultiimage'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if (count($artmultiimage) == 1) {

                    $allowed = array('jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg');
                    $allowespdf = array('pdf');
                    $allowesvideo = array('mp4', 'webm','MP4');
                    $allowesaudio = array('mp3');
                    $filename = $artmultiimage[0]['file_name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    if (in_array($ext, $allowed)) {
                        $return_html .= '<a href = "javascript:void(0)" target="_blank" onclick="login_profile();"><div class="one-image">
           <img src = "' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '">
        </div></a>';
                    } elseif (in_array($ext, $allowespdf)) {

                         $return_html .= '<div>
<a title = "click to open" href = "javascript:void(0)" target="_blank" onclick="login_profile();"><div class = "pdf_img">
    <img src="' . base_url('assets/images/PDF.jpg') . '" alt="PDF">
</div>
</a>
</div>';

                    } elseif (in_array($ext, $allowesvideo)) {


                            $post_poster = $artmultiimage[0]['file_name'];
                            $post_poster1 = explode('.', $post_poster);
                            $post_poster2 = end($post_poster1);
                            $post_poster = str_replace($post_poster2, 'png', $post_poster);

                            if (IMAGEPATHFROM == 'upload') {
                                $return_html .= '<div>';
                                if (file_exists(ART_POST_MAIN_UPLOAD_URL . $post_poster)) {
                                    $return_html .= '<video width = "100%" height = "350" controls poster="' . ART_POST_MAIN_UPLOAD_URL . $post_poster . '" id="show_video'.$artmultiimage[0]['post_files_id'].'" onplay="login_profile();" onClick="login_profile();">';
                                } else {
                                    $return_html .= '<video width = "100%" height = "350" controls id="show_video'.$artmultiimage[0]['post_files_id'].'"  onClick="login_profile();" onplay="login_profile();">';
                                }
                                $return_html .= '<source src = "' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '" type = "video/mp4">';
                                $return_html .= '<source src = "' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '" type = "video/ogg">';
                                $return_html .= 'Your browser does not support the video tag.';
                                $return_html .= '</video>';
                                $return_html .= '</div>';
                            } else {
                                $return_html .= '<div>';
                                $filename = $this->config->item('art_post_main_upload_path') . $artmultiimage[0]['file_name'];
                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                if ($info) {
                                    $return_html .= '<video width = "100%" height = "350" controls poster="' . ART_POST_MAIN_UPLOAD_URL . $post_poster . '" id="show_video'.$artmultiimage[0]['post_files_id'].'" onplay="login_profile();" onClick="login_profile();">';
                                } else {
                                    $return_html .= '<video width = "100%" height = "350" controls id="show_video'.$artmultiimage[0]['post_files_id'].'" onplay="login_profile();" onClick="login_profile();">';
                                }
                                $return_html .= '<source src = "' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '" type = "video/mp4">';
                                $return_html .= '<source src = "' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '" type = "video/ogg">';
                                $return_html .= 'Your browser does not support the video tag.';
                                $return_html .= '</video>';
                                $return_html .= '</div>';
                            }

                    } elseif (in_array($ext, $allowesaudio)) {
                        $return_html .= '<div class="audio_main_div">
            <div class="audio_img">
                <img src="' . base_url('assets/images/music-icon.png') . '">  
            </div>
            <div class="audio_source">
                <audio  controls>
                    <source src = "' . ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name'] . '" type = "audio/mp3">
                    <source src="movie.ogg" type="audio/ogg">
                    Your browser does not support the audio tag.
                </audio>
            </div> </div>';
            
       
                    }
                } elseif (count($artmultiimage) == 2) {
                    foreach ($artmultiimage as $multiimage) {
                        $return_html .= ' <a href = "javascript:void(0)" target="_blank" onclick="login_profile();"><div  class="two-images" >
             <img class = "two-columns" src = "' . ART_POST_RESIZE1_UPLOAD_URL . $multiimage['file_name'] . '">
        </div> </a>';
                    }
                } elseif (count($artmultiimage) == 3) {
                    $return_html .= '<a href = "javascript:void(0)" target="_blank" onclick="login_profile();"><div class="three-imag-top" >
            <img class = "three-columns" src = "' . ART_POST_RESIZE4_UPLOAD_URL . $artmultiimage[0]['file_name'] . '">
        </div>
        <div class="three-image" >
           <img class = "three-columns" src = "' . ART_POST_RESIZE1_UPLOAD_URL . $artmultiimage[1]['file_name'] . '">
        </div>
        <div class="three-image" >
            <img class = "three-columns" src = "' . ART_POST_RESIZE1_UPLOAD_URL . $artmultiimage[2]['file_name'] . '">
        </div></a>';
                } elseif (count($artmultiimage) == 4) {

                    foreach ($artmultiimage as $multiimage) {
                        $return_html .= ' <a href = "javascript:void(0)" target="_blank" onclick="login_profile();"><div class="four-image">
            <img class = "breakpoint" src = "' . ART_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name'] . '">
        </div></a>';
                    }
                } elseif (count($artmultiimage) > 4) {

                    $i = 0;
                    foreach ($artmultiimage as $multiimage) {
                        $return_html .= '<div class="four-image">
            <a href = "javascript:void(0)" target="_blank" onclick="login_profile();">
            <img class = "breakpoint" src = "' . ART_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name'] . '">
            </a>
        </div>';
                        $i++;
                        if ($i == 3)
                            break;
                    }
                    $return_html .= '<div class="four-image">
            <a href = "javascript:void(0)" target="_blank" onclick="login_profile();">
           <img src = "' . ART_POST_RESIZE2_UPLOAD_URL . $artmultiimage[3]['file_name'] . '">
             </a>
            <a href = "javascript:void(0)" target="_blank" onclick="login_profile();">
                <div class="more-image" >
                    <span> View All (+' . (count($artmultiimage) - 4) . ')
                    </span></div>
            </a>
        </div>';
                }
                $return_html .= '<div>
        </div>
    </div>
</div>
<div class="post-design-like-box col-md-12">
    <div class="post-design-menu">
        <ul class="col-md-6">
            <li class="likepost' . $row['art_post_id'] . '">
                <a class="ripple like_h_w"  href = "javascript:void(0)" target="_blank" onclick="login_profile();">';
                $userid = $this->session->userdata('aileenuser');
                $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1');
                $artlike = $this->data['artlike'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $likeuser = $this->data['artlike'][0]['art_like_user'];
                $likeuserarray = explode(',', $artlike[0]['art_like_user']);

                $return_html .= '<i class="fa fa-thumbs-up" style="color: #999;" aria-hidden="true"></i>';
               
                $return_html .= '<span class="like_As_count">';
                
                $return_html .= '</span>
                </a>
            </li>

            <li id="insertcount' . $row['art_post_id'] . '" style="visibility:show">';
                $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1', 'is_delete' => '0');
                $commnetcount = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $return_html .= '<a title="Comment" class="ripple like_h_w"  href = "javascript:void(0)" target="_blank" onclick="login_profile();"><i class="fa fa-comment-o" aria-hidden="true">';
                $return_html .= '</i> 
                </a>
            </li> 
        </ul>
        <ul class="col-md-6 like_cmnt_count">';

   $contition_array = array('post_id' => $row['art_post_id'], 'insert_profile' => '1');
   $postformat = $this->common->select_data_by_condition('post_files', $contition_array, $data = 'post_format', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    //echo "<pre>"; print_r($postformat); die();
                    if($postformat[0]['post_format'] == 'video'){
                    $return_html .= '<li id="viewvideouser'.$row['art_post_id'].'">';

                    $contition_array = array('post_id' => $row['art_post_id'], 'insert_profile' => '1');
   $userdata = $this->common->select_data_by_condition('showvideo', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
    $user_data = count($userdata); 

                    if($user_data > 0){

                     $return_html .= '<div class="comnt_count_ext_a  comnt_count_ext2"><span>';

                    $return_html .= $user_data . ' '. 'Views'; 

                    $return_html .= '</span></div></li>';
                      }

                   }

           $return_html .= '<li>
                <div class="like_cmmt_space comnt_count_ext_a like_count_ext'.$row['art_post_id'].'">
                    <span class="comment_count">';
                if (count($commnetcount) > 0) {
                    $return_html .= count($commnetcount);
                    $return_html .= '</span>';
                    $return_html .= '<span> Comment</span>';
                }
                

                $return_html .= '</div>
            </li>

            <li>
                <div class="comnt_count_ext_a comnt_count_ext' . $row['art_post_id'].'">
                    <span class="comment_like_count"> ';
                if ($row['art_likes_count'] > 0) {
                    $return_html .= $row['art_likes_count'];
                     $return_html .= '</span>'; 
                    $return_html .= '<span> Like</span>';
                }
               
                 $return_html .=  '</div>
            </li>
        </ul>
    </div>
</div>';
                
                $return_html .= '<div class="likeduserlist1 likeusername'. $row['art_post_id'].'" id="likeusername'. $row['art_post_id'].'" style="display:block">';
    
                    $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1', 'is_delete' => '0');
                    $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    $likeuser = $commnetcount[0]['art_like_user'];
                    $countlike = $commnetcount[0]['art_likes_count'] - 1;
                    $likelistarray = explode(',', $likeuser);
                    foreach ($likelistarray as $key => $value) {
                        $art_fname1 = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $value, 'status' => '1'))->row()->art_name;
                        $art_lname1 = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $value, 'status' => '1'))->row()->art_lastname;
                    }
                   
                    $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1', 'is_delete' => '0');
                    $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $likeuser = $commnetcount[0]['art_like_user'];
                    $countlike = $commnetcount[0]['art_likes_count'] - 1;
                    $likelistarray = explode(',', $likeuser);

                  $art_fname = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => '1'))->row()->art_name;
                 $art_lname = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => '1'))->row()->art_lastname;

                    $return_html .= '<div class="like_one_other">';

                     $return_html .= '<a href = "javascript:void(0)" target="_blank" onclick="login_profile();">';

                        $return_html .= ucfirst(strtolower($art_fname)).' '.ucfirst(strtolower($art_lname));
                        $return_html .= "&nbsp;";
                   
                    if (count($likelistarray) > 1) {
                        $return_html .= "and".' ';
                        $return_html .= $countlike;
                        $return_html .= "&nbsp;";
                        $return_html .= "others";
                    }
                    $return_html .= '</a></div>
   
</div>';
               


$return_html .= '<div class="art-all-comment col-md-12" style="display:none !important;">
    <div id="fourcomment' . $row['art_post_id'] . '" style="display:none;">
    </div>
    <div  id="threecomment' . $row['art_post_id'] . '" style="display:block">
        <div class="hidebottomborder insertcomment' . $row['art_post_id'] . '">';
                $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1');
                $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = 'artistic_post_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');

                if ($artdata) {
                    foreach ($artdata as $rowdata) {
                        $artname = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->art_name;

                        $artlastname = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->art_lastname;

                         $artslug = $this->db->select('slug')->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->slug;

                        $return_html .= '<div class="all-comment-comment-box">
                <div class="post-design-pro-comment-img">';
                 $return_html .= '<a href = "javascript:void(0)" target="_blank" onclick="login_profile();">';

                        $art_userimage = $this->db->select('art_user_image')->get_where('art_reg', array('user_id' => $rowdata['user_id'], 'status' => '1'))->row()->art_user_image; 

                        if (IMAGEPATHFROM == 'upload') {
                            if($art_userimage){
                        if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                                       
                                        $return_html .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "">';
                                        
                                     } else { 
                                        $return_html .= '<img src="'. ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage.'" alt="" >';
                                    }
                                 }else{
                                    $return_html .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "">';

                                 }
                                } else{


                       $filename = $this->config->item('art_profile_thumb_upload_path') . $art_userimage;
                      $s3 = new S3(awsAccessKey, awsSecretKey);
                     $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);

                            if ($info) {

                                $return_html .= '<img  src="' . ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage . '"  alt="">';

                            } else {
                                
                            $return_html .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "">';   
                            }
                       }

                        $return_html .= '</a>';
                        $return_html .= '</div>
                <div class="comment-name">';
                 $return_html .= '<a href = "javascript:void(0)" target="_blank" onclick="login_profile();">

                    <b>';
                        $return_html .= ucfirst(strtolower($artname)).' '.ucfirst(strtolower($artlastname));
                        $return_html .= '</b>';
                         $return_html .= '</br>';

                $return_html .= '</a></div>
                <div class="comment-details" id= "showcomment' . $rowdata['artistic_post_comment_id'] . '">
                    <div id="lessmore' . $rowdata['artistic_post_comment_id'] . '" style="display:block;">';
                        $small = substr($rowdata['comments'], 0, 180);
                        $return_html .= $this->common->make_links($small);

                        if (strlen($rowdata['comments']) > 180) {
                            $return_html .= '... <span id="kkkk" onClick="seemorediv(' . $rowdata['artistic_post_comment_id'] . ')">View More</span>';
                        }
                        $return_html .= '</div>

                    <div id="seemore' . $rowdata['artistic_post_comment_id'] . '" style="display:none;">';
                        $new_product_comment = $this->common->make_links($rowdata['comments']);
                        $return_html .= nl2br(htmlspecialchars_decode(htmlentities($new_product_comment, ENT_QUOTES, 'UTF-8')));
                        $return_html .= '</div>
                </div>
                <div class="edit-comment-box">
                    <div class="inputtype-edit-comment">

                         <div contenteditable="true"  style="display:none" class="editable_text editav_2 custom-edit" name="'. $rowdata['artistic_post_comment_id'] .'"  id="editcomment' . $rowdata['artistic_post_comment_id'] . '" placeholder="Add a Comment" value= ""  onkeyup="commentedit(' . $rowdata['artistic_post_comment_id'] . ')" onpaste="OnPaste_StripFormatting(this, event);">' . $rowdata['comments'] . '</div>

                        <span class="comment-edit-button"><button id="editsubmit' . $rowdata['artistic_post_comment_id'] . '" style="display:none" onClick="edit_comment(' . $rowdata['artistic_post_comment_id'] . ')">Save</button></span>
                    </div>
                </div>
                <div class="art-comment-menu-design"> 
                    <div class="comment-details-menu" id="likecomment1' . $rowdata['artistic_post_comment_id'] . '">
                        <a id="' . $rowdata['artistic_post_comment_id'] . '"  href = "javascript:void(0)" target="_blank" onclick="login_profile();">';
                        $userid = $this->session->userdata('aileenuser');
                        $contition_array = array('artistic_post_comment_id' => $rowdata['artistic_post_comment_id'], 'status' => '1');
                        $artcommentlike = $this->data['artcommentlike'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                        $likeuserarray = explode(',', $artcommentlike[0]['artistic_comment_like_user']);
                        if (!in_array($userid, $likeuserarray)) {
                            $return_html .= '<i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i> ';
                        } else {
                            $return_html .= '<i class="fa fa-thumbs-up main_color" aria-hidden="true"></i>';
                        }
                        $return_html .= '<span>';
                        if ($rowdata['artistic_comment_likes_count']) {
                            $return_html .= $rowdata['artistic_comment_likes_count'];
                        }
                        $return_html .= '</span>
                        </a>
                    </div>';

                        $userid = $this->session->userdata('aileenuser');
                        if ($rowdata['user_id'] == $userid) {
                            $return_html .= '<span role="presentation" aria-hidden="true"> · </span>
                    <div class="comment-details-menu">
                        <div id="editcommentbox' . $rowdata['artistic_post_comment_id'] . '" style="display:block;">
                            <a id="' . $rowdata['artistic_post_comment_id'] . '" href = "javascript:void(0)" target="_blank" onclick="login_profile();" class="editbox">Edit
                            </a>
                        </div>
                        <div id="editcancle' . $rowdata['artistic_post_comment_id'] . '" style="display:none;">
                            <a id="' . $rowdata['artistic_post_comment_id'] . '"  href = "javascript:void(0)" target="_blank" onclick="login_profile();">Cancel
                            </a>
                        </div>
                    </div>';
                        }
                        $userid = $this->session->userdata('aileenuser');
                        $art_userid = $this->db->select('user_id')->get_where('art_post', array('art_post_id' => $rowdata['art_post_id'], 'status' => '1'))->row()->user_id;
                        if ($rowdata['user_id'] == $userid || $art_userid == $userid) {
                            $return_html .= '<span role="presentation" aria-hidden="true"> · </span>
                    <div class="comment-details-menu">
                        <input type="hidden" name="post_delete"  id="post_delete' . $rowdata['artistic_post_comment_id'] . '" value= "' . $rowdata['art_post_id'] . '">
                        <a id="' . $rowdata['artistic_post_comment_id'] . '"   href = "javascript:void(0)" target="_blank" onclick="login_profile();"> Delete<span class="insertcomment' . $rowdata['artistic_post_comment_id'] . '">
                            </span>
                        </a>
                    </div>';
                        }
                        $return_html .= '<span role="presentation" aria-hidden="true"> · </span>
                    <div class="comment-details-menu">
                        <p>';

                        $return_html .= $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($rowdata['created_date'])));
                        $return_html .= '</br>';
                        $return_html .= '</p></div>
                </div></div>';
                    }
                }
                $return_html .= '</div>
    </div>
</div>
</div>
</div> </div>';
            }
        } else {
            $return_html .= '<div class="art_no_post_avl" id="no_post_avl">
                                <h3> Post</h3>
                                <div class="art-img-nn">
                                    <div class="art_no_post_img">

                                        <img src="' . base_url('assets/img/art-no.png') . '">

                                    </div>
                                    <div class="art_no_post_text">
                                        No Post Available.
                                    </div>
                                </div>
                            </div> ';
        }
        $return_html .= '<div class="nofoundpost">
</div>';
        echo $return_html;
    }
   
}
