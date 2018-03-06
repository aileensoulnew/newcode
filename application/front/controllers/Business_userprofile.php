<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Business_userprofile extends CI_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('user_agent');
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('business_model');
        $this->lang->load('message', 'english');
        $this->load->helper('smiley');
        //AWS access info start
        $this->load->library('S3');
        //AWS access info end

        $userid = $this->session->userdata('aileenuser');
        include ('business_profile_include.php');

        // FIX BUSINESS PROFILE NO POST DATA

        $this->data['no_business_post_html'] = '<div class="art_no_post_avl"><h3>Business Post</h3><div class="art-img-nn"><div class="art_no_post_img"><img src=' . base_url('assets/img/bui-no.png') . '></div><div class="art_no_post_text">No Post Available.</div></div></div>';
        $this->data['no_business_contact_html'] = '<div class="art-img-nn"><div class="art_no_post_img"><img src="' . base_url('assets/img/No_Contact_Request.png') . '"></div><div class="art_no_post_text">No Contacts Available.</div></div>';
    }

    public function index() {

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'status' => '0');
        $businessdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if ($businessdata) {
            $this->load->view('business_profile/reactivate', $this->data);
        } else {
            $userid = $this->session->userdata('aileenuser');
// GET BUSINESS PROFILE DATA
            $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
            $userdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// GET COUNTRY DATA
            $contition_array = array('status' => '1');
            $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = 'country_id,country_name', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// GET STATE DATA
            $contition_array = array('status' => '1');
            $this->data['states'] = $this->common->select_data_by_condition('states', $contition_array, $data = 'state_id,state_name,country_id', $sortby = 'state_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

// GET CITY DATA
            $contition_array = array('status' => '1');
            $this->data['cities'] = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_id,city_name,state_id', $sortby = 'city_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if (count($userdata) > 0) {

                if ($userdata[0]['business_step'] == 1) {
                    redirect('business-profile/contact-information', refresh);
                } else if ($userdata[0]['business_step'] == 2) {
                    redirect('business-profile/description', refresh);
                } else if ($userdata[0]['business_step'] == 3) {
                    redirect('business-profile/image', refresh);
                } else if ($userdata[0]['business_step'] == 4) {
                    redirect('business-profile/home', refresh);
                } else if ($userdata[0]['business_step'] == 5) {
                    redirect('business-profile/home', refresh);
                }
            } else {
                $this->load->view('business_profile/business_info', $this->data);
            }
        }
    }

    public function ajax_business_dashboard_post($id = '') {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $business_login_slug = $this->data['business_login_slug'];
        $userid = $this->session->userdata('aileenuser');
        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;
        if ($id != '') {
            $bus_userid = $this->db->get_where('business_profile', array('business_slug' => $id, 'status' => '1'))->row()->user_id;
        } else {
            $bus_userid = $this->session->userdata('aileenuser');
        }
        $business_profile_id = $this->data['business_common_data'][0]['business_profile_id'];
        $city = $this->data['business_common_data'][0]['city'];
        $user_id = $this->data['business_common_data'][0]['user_id'];
        $business_user_image = $this->data['business_common_data'][0]['business_user_image'];
        $business_slug = $this->data['business_common_data'][0]['business_slug'];
        $company_name = $this->data['business_common_data'][0]['company_name'];
        $profile_background = $this->data['business_common_data'][0]['profile_background'];
        $state = $this->data['business_common_data'][0]['state'];
        $industriyal = $this->data['business_common_data'][0]['industriyal'];
        $other_industrial = $this->data['business_common_data'][0]['other_industrial'];

        /* SELF USER LIST START */
        $self_list = array($bus_userid);
        /* SELF USER LIST END */


        $total_user_list = $self_list;
        $total_user_list = array_unique($total_user_list, SORT_REGULAR);
        $total_user_list = implode(',', $total_user_list);
        $total_user_list = str_replace(",", "','", $total_user_list);

        $condition_array = array('business_profile_post.is_delete' => '0', 'business_profile_post.status' => '1', 'FIND_IN_SET ("' . $userid . '", delete_post) !=' => '0');
        $delete_postdata = $this->common->select_data_by_condition('business_profile_post', $condition_array, $data = 'GROUP_CONCAT(business_profile_post_id) as delete_post_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $delete_post_id = $delete_postdata[0]['delete_post_id'];
        $delete_post_id = str_replace(",", "','", $delete_post_id);

        $condition_array = array('business_profile_post.is_delete' => '0', 'business_profile_post.status' => '1');
        $search_condition = "`business_profile_post_id` NOT IN ('$delete_post_id') AND (business_profile_post.user_id IN ('$total_user_list')) OR (posted_user_id ='$user_id' AND is_delete=0)";
        $join_str[0]['table'] = 'business_profile';
        $join_str[0]['join_table_id'] = 'business_profile.user_id';
        $join_str[0]['from_table_id'] = 'business_profile_post.user_id';
        $join_str[0]['join_type'] = '';
        $data = "business_profile.business_user_image,business_profile.company_name,business_profile.industriyal,business_profile.business_slug,business_profile.other_industrial,business_profile.business_slug,business_profile_post.business_profile_post_id,business_profile_post.product_name,business_profile_post.product_description,business_profile_post.business_likes_count,business_profile_post.business_like_user,business_profile_post.created_date,business_profile_post.posted_user_id,business_profile.user_id";
        $business_profile_post = $this->common->select_data_by_search('business_profile_post', $search_condition, $condition_array, $data, $sortby = 'business_profile_post_id', $orderby = 'DESC', $limit = $perpage, $offset = $start, $join_str, $groupby = '');
        $business_profile_post1 = $this->common->select_data_by_search('business_profile_post', $search_condition, $condition_array, $data, $sortby = 'business_profile_post_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str, $groupby = '');

        $return_html = '';

        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($business_profile_post1);
        }

        $return_html .= '<input type = "hidden" class = "page_number" value = "' . $page . '" />';
        $return_html .= '<input type = "hidden" class = "total_record" value = "' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';

        if (count($business_profile_post1) > 0) {
            foreach ($business_profile_post as $row) {

                $post_business_user_image = $row['business_user_image'];
                $post_company_name = $row['company_name'];
                $post_business_profile_post_id = $row['business_profile_post_id'];
                $post_product_name = $row['product_name'];
                $post_product_description = $row['product_description'];
                $post_business_likes_count = $row['business_likes_count'];
                $post_business_like_user = $row['business_like_user'];
                $post_created_date = $row['created_date'];
                $post_posted_user_id = $row['posted_user_id'];
                $post_business_slug = $row['business_slug'];
                $post_industriyal = $row['industriyal'];
                $post_user_id = $row['user_id'];
                $post_category = $this->db->get_where('industry_type', array('industry_id' => $post_industriyal, 'status' => '1'))->row()->industry_name;
                $post_other_industrial = $row['other_industrial'];
                if ($post_posted_user_id) {
                    $posted_company_name = $this->db->get_where('business_profile', array('user_id' => $post_posted_user_id))->row()->company_name;
                    $posted_business_slug = $this->db->get_where('business_profile', array('user_id' => $post_posted_user_id, 'status' => '1'))->row()->business_slug;
                    $posted_category = $this->db->get_where('industry_type', array('industry_id' => $post_industriyal, 'status' => '1'))->row()->industry_name;
                    $posted_business_user_image = $this->db->get_where('business_profile', array('user_id' => $post_posted_user_id))->row()->business_user_image;
                }

                $return_html .= '<div id = "removepost' . $post_business_profile_post_id . '">
                        <div class = "col-md-12 col-sm-12 post-design-box">
                            <div class = "post_radius_box">
                                <div class = "post-design-top col-md-12" >
                            <div class = "post-design-pro-img">
                                <div id = "popup1" class = "overlay">
                                    <div class = "popup">
                                        <div class = "pop_content">
                                            Your Post is Successfully Saved.
                                            <p class = "okk">
                                                <a class = "okbtn" href = "#">Ok</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>';


                if ($post_posted_user_id) {

                    if ($posted_business_user_image) {
                        $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $posted_business_slug) . '">';
                        if (IMAGEPATHFROM == 'upload') {
                            if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $posted_business_user_image)) {
                                $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                            } else {
                                $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $posted_business_user_image . '?ver=' . time() . '" name = "image_src" id = "image_src" alt="' . $posted_business_user_image . '"/>';
                            }
                        } else {
                            $filename = $this->config->item('bus_profile_thumb_upload_path') . $posted_business_user_image;
                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                            if (!$info) {
                                $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                            } else {
                                $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $posted_business_user_image . '?ver=' . time() . '" name = "image_src" id = "image_src" alt="' . $posted_business_user_image . '"/>';
                            }
                        }
                        $return_html .= '</a>';
                    } else {
                        $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $posted_business_slug) . '">';
                        $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                        $return_html .= '</a>';
                    }
                } else {
                    if ($post_business_user_image) {
                        $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $post_business_slug) . '">';
                        if (IMAGEPATHFROM == 'upload') {
                            if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $post_business_user_image)) {
                                $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                            } else {
                                $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $post_business_user_image . '?ver=' . time() . '" alt = "' . $post_business_user_image . '">';
                            }
                        } else {
                            $filename = $this->config->item('bus_profile_thumb_upload_path') . $post_business_user_image;
                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                            if (!$info) {
                                $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                            } else {
                                $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $post_business_user_image . '?ver=' . time() . '" alt = "' . $post_business_user_image . '">';
                            }
                        }
                        $return_html .= '</a>';
                    } else {
                        $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $post_business_slug) . '">';
                        $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                        $return_html .= '</a>';
                    }
                }
                $return_html .= '</div>
                        <div class = "post-design-name fl col-xs-8 col-md-10">
                    <ul>';

                $return_html .= '<li></li>';

                if ($post_posted_user_id) {
                    $return_html .= '<li>
                            <div class = "else_post_d">
                                <div class = "post-design-product">
                                    <a class = "post_dot" href = "' . base_url('business-profile/dashboard/' . $posted_business_slug) . '">' . ucfirst(strtolower($posted_company_name)) . '</a>
<p class = "posted_with" > Posted With</p> <a class = "other_name name_business post_dot" href = "' . base_url('business-profile/dashboard/' . $post_business_slug) . '">' . ucfirst(strtolower($post_company_name)) . '</a>
<span class = "ctre_date">
' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($post_created_date))) . '
</span> </div></div>
</li>';
                } else {
                    $return_html .= '<li>
                            <div class = "post-design-product">
                                <a class = "post_dot" href = "' . base_url('business-profile/dashboard/' . $post_business_slug) . '" title = "' . ucfirst(strtolower($post_company_name)) . '">
' . ucfirst($post_company_name) . '</a><div class = "datespan"> <span class = "ctre_date" >
' . $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($post_created_date))) . '

</span></div>

</div>
</li>';
                }

                $return_html .= '<li>
<div class = "post-design-product">
<a class = "buuis_desc_a" href = "javascript:void(0);" title = "Category">';
                if ($post_industriyal) {
                    $return_html .= ucfirst(strtolower($post_category));
                } else {
                    $return_html .= ucfirst(strtolower($post_other_industrial));
                }

                $return_html .= '</a>
</div>
</li>

<li>
</li>
</ul>
</div>
<div class = "dropdown1">';
                $return_html .= '<a onClick = "myFunction1(' . $post_business_profile_post_id . ')" class = "dropbtn_common dropbtn1 fa fa-ellipsis-v"></a>';

                $return_html .= '<div id = "myDropdown' . $post_business_profile_post_id . '" class = "dropdown-content1 dropdown2_content">';
                if ($post_posted_user_id != 0) {
                    if ($userid == $post_posted_user_id) {
                        $return_html .= '<a onclick = "user_postdelete(' . $post_business_profile_post_id . ')">
<i class = "fa fa-trash-o" aria-hidden = "true">
</i> Delete Post
</a>
<a id = "' . $post_business_profile_post_id . '" onClick = "editpost(this.id)">
<i class = "fa fa-pencil-square-o" aria-hidden = "true">
</i>Edit
</a>';
                    } else {
                        $return_html .= '<a onclick = "user_postdelete(' . $post_business_profile_post_id . ')">
<i class = "fa fa-trash-o" aria-hidden = "true">
</i> Delete Post
</a>';
                    }
                } else {
                    if ($userid == $post_user_id) {
                        $return_html .= '<a onclick = "user_postdelete(' . $post_business_profile_post_id . ')">
<i class = "fa fa-trash-o" aria-hidden = "true">
</i> Delete Post
</a>
<a id = "' . $post_business_profile_post_id . '" onClick = "editpost(this.id)">
<i class = "fa fa-pencil-square-o" aria-hidden = "true">
</i>Edit
</a>';
                    } else {
                        $return_html .= '<a onclick = "user_postdeleteparticular(' . $post_business_profile_post_id . ')">
<i class = "fa fa-trash-o" aria-hidden = "true">
</i> Delete Post
</a>';
                    }
                }

                $return_html .= '</div>
</div>
<div class = "post-design-desc">
<div class = "ft-15 t_artd">
<div id = "editpostdata' . $post_business_profile_post_id . '" style = "display:block;">
<a>' . $this->common->make_links($post_product_name) . '</a>
</div>
<div id = "editpostbox' . $post_business_profile_post_id . '" style = "display:none;">


<input type = "text" class="productpostname" id = "editpostname' . $post_business_profile_post_id . '" name = "editpostname" placeholder = "Product Name" value = "' . $post_product_name . '" tabindex="' . $post_business_profile_post_id . '" onKeyDown = check_lengthedit(' . $post_business_profile_post_id . ');
onKeyup = check_lengthedit(' . $post_business_profile_post_id . ');
onblur = check_lengthedit(' . $post_business_profile_post_id . ');
>';

                if ($post_product_name) {
                    $counter = $post_product_name;
                    $a = strlen($counter);

                    $return_html .= '<input size = 1 id = "text_num_' . $post_business_profile_post_id . '" class = "text_num" value = "' . (50 - $a) . '" name = text_num disabled>';
                } else {
                    $return_html .= '<input size = 1 id = "text_num_' . $post_business_profile_post_id . '" class = "text_num" value = 50 name = text_num disabled>';
                }
                $return_html .= '</div>

</div>
<div id = "khyati' . $post_business_profile_post_id . '" style = "display:block;">';

                $small = substr($post_product_description, 0, 180);
                $return_html .= nl2br($this->common->make_links($small));
                if (strlen($post_product_description) > 180) {
                    $return_html .= '... <span id = "kkkk" onClick = "khdiv(' . $post_business_profile_post_id . ')">View More</span>';
                }

                $return_html .= '</div>
<div id = "khyatii' . $post_business_profile_post_id . '" style = "display:none;">
' . $post_product_description . '</div>
<div id = "editpostdetailbox' . $post_business_profile_post_id . '" style = "display:none;">
<div contenteditable = "true" id = "editpostdesc' . $post_business_profile_post_id . '" class = "textbuis editable_text margin_btm" name = "editpostdesc" placeholder = "Description" tabindex="' . ($post_business_profile_post_id + 1) . '" onpaste = "OnPaste_StripFormatting(this, event);" onfocus="cursorpointer(' . $post_business_profile_post_id . ')">' . $post_product_description . '</div>
</div>
<div id = "editpostdetailbox' . $post_business_profile_post_id . '" style = "display:none;">
<div contenteditable = "true" id = "editpostdesc' . $post_business_profile_post_id . '" placeholder = "Product Description" class = "textbuis  editable_text" name = "editpostdesc" onpaste = "OnPaste_StripFormatting(this, event);">' . $post_product_description . '</div>
</div>
<button class = "fr" id = "editpostsubmit' . $post_business_profile_post_id . '" style = "display:none;margin: 5px 0; border-radius: 3px;" onClick = "edit_postinsert(' . $post_business_profile_post_id . ')">Save
</button>
</div>
</div>
<div class = "post-design-mid col-md-12 padding_adust" >
<div>';
                $contition_array = array('post_id' => $post_business_profile_post_id, 'is_deleted' => '1', 'insert_profile' => '2');
                $businessmultiimage = $this->common->select_data_by_condition('post_files', $contition_array, $data = 'file_name,post_files_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if (count($businessmultiimage) == 1) {

                    $allowed = array('jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg');
                    $allowespdf = array('pdf');
                    $allowesvideo = array('mp4', 'webm', 'qt', 'mov', 'MP4');
                    $allowesaudio = array('mp3');
                    $filename = $businessmultiimage[0]['file_name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    if (in_array($ext, $allowed)) {

                        $return_html .= '<div class = "one-image">';

                        $return_html .= '<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '?ver=' . time() . '" alt="' . $businessmultiimage[0]['file_name'] . '">
</a>
</div>';
                    } elseif (in_array($ext, $allowespdf)) {

                        $return_html .= '<div>
<a title = "click to open" href = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" target="_blank"><div class = "pdf_img">
    <img src="' . base_url('assets/images/PDF.jpg') . '?ver=' . time() . '" alt="PDF.jpg">
</div>
</a>
</div>';
                    } elseif (in_array($ext, $allowesvideo)) {
                        $post_poster = $businessmultiimage[0]['file_name'];
                        $post_poster1 = explode('.', $post_poster);
                        $post_poster2 = end($post_poster1);
                        $post_poster = str_replace($post_poster2, 'png', $post_poster);

                        if (IMAGEPATHFROM == 'upload') {
                            $return_html .= '<div>';
                            if (file_exists($this->config->item('bus_post_main_upload_path') . $post_poster)) {
                                $return_html .= '<video width = "100%" height = "350" id="show_video' . $businessmultiimage[0]['post_files_id'] . '" onplay="playtime(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ')" onClick="count_videouser(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ');" controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                            } else {
                                $return_html .= '<video width = "100%" height = "350" id="show_video' . $businessmultiimage[0]['post_files_id'] . '" onplay="playtime(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ')" onClick="count_videouser(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ');" controls>';
                            }

                            $return_html .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" type = "video/mp4">';
                            $return_html .= 'Your browser does not support the video tag.';
                            $return_html .= '</video>';
                            $return_html .= '</div>';
                        } else {
                            $return_html .= '<div>';

                            $filename = $this->config->item('bus_post_main_upload_path') . $businessmultiimage[0]['file_name'];
                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                            if ($info) {
                                $return_html .= '<video width = "100%" height = "350" id="show_video' . $businessmultiimage[0]['post_files_id'] . '" onplay="playtime(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ')" onClick="count_videouser(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ');" controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                            } else {
                                $return_html .= '<video width = "100%" height = "350" id="show_video' . $businessmultiimage[0]['post_files_id'] . '" onplay="playtime(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ')" onClick="count_videouser(' . $businessmultiimage[0]['post_files_id'] . ',' . $post_business_profile_post_id . ');" controls>';
                            }
                            $return_html .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" type = "video/mp4">';
                            $return_html .= 'Your browser does not support the video tag.';
                            $return_html .= '</video>';
                            $return_html .= '</div>';
                        }
                    } elseif (in_array($ext, $allowesaudio)) {

                        $return_html .= '<div class = "audio_main_div">
<div class = "audio_img">
<img src = "' . base_url('assets/images/music-icon.png') . '?ver=' . time() . '" alt="music-icon.png">
</div>
<div class = "audio_source">
<audio id = "audio_player" width = "100%" height = "100" controls>
<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" type = "audio/mp3">
Your browser does not support the audio tag.
</audio>
</div>
<div class = "audio_mp3" id = "' . "postname" . $post_business_profile_post_id . '">
<p title = "' . $post_product_name . '">' . $post_product_name . '</p>
</div>
</div>';
                    }
                } elseif (count($businessmultiimage) == 2) {

                    foreach ($businessmultiimage as $multiimage) {

                        $return_html .= '<div class = "two-images">
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img class = "two-columns" src = "' . BUS_POST_RESIZE1_UPLOAD_URL . $multiimage['file_name'] . '" alt="' . $multiimage['file_name'] . '">
</a>
</div>';
                    }
                } elseif (count($businessmultiimage) == 3) {

                    $return_html .= '<div class = "three-image-top" >
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img class = "three-columns" src = "' . BUS_POST_RESIZE4_UPLOAD_URL . $businessmultiimage[0]['file_name'] . '" alt="' . $businessmultiimage[0]['file_name'] . '">
</a>
</div>
<div class = "three-image" >

<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img class = "three-columns" src = "' . BUS_POST_RESIZE1_UPLOAD_URL . $businessmultiimage[1]['file_name'] . '" alt="' . $businessmultiimage[1]['file_name'] . '">
</a>
</div>
<div class = "three-image" >
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img class = "three-columns" src = "' . BUS_POST_RESIZE1_UPLOAD_URL . $businessmultiimage[2]['file_name'] . '" alt="' . $businessmultiimage[2]['file_name'] . '">
</a>
</div>';
                } elseif (count($businessmultiimage) == 4) {

                    foreach ($businessmultiimage as $multiimage) {

                        $return_html .= '<div class = "four-image">
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img class = "breakpoint" src = "' . BUS_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name'] . '" alt="' . $multiimage['file_name'] . '">
</a>
</div>';
                    }
                } elseif (count($businessmultiimage) > 4) {

                    $i = 0;
                    foreach ($businessmultiimage as $multiimage) {

                        $return_html .= '<div class = "four-image">
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img src = "' . BUS_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name'] . '?ver=' . time() . '" alt="' . $multiimage['file_name'] . '">
</a>
</div>';

                        $i++;
                        if ($i == 3)
                            break;
                    }

                    $return_html .= '<div class = "four-image">
<a href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<img src = "' . BUS_POST_RESIZE2_UPLOAD_URL . $businessmultiimage[3]['file_name'] . '?ver=' . time() . '" alt="' . $businessmultiimage[3]['file_name'] . '">
</a>
<a class = "text-center" href = "' . base_url('business-profile/post-detail/' . $business_login_slug . '/' . $post_business_profile_post_id) . '">
<div class = "more-image" >
<span>View All (+
' . (count($businessmultiimage) - 4) . ')</span>

</div>

</a>
</div>';
                }
                $return_html .= '<div>
</div>
</div>
</div>
<div class = "post-design-like-box col-md-12">
<div class = "post-design-menu">
<ul class = "col-md-6 col-sm-6 col-xs-6">
<li class = "likepost' . $post_business_profile_post_id . '">
<a id = "' . $post_business_profile_post_id . '" class = "ripple like_h_w" onClick = "post_like(this.id)">';

                $likeuser = $post_business_like_user;
                $likeuserarray = explode(',', $likeuser);
                if (!in_array($userid, $likeuserarray)) {

                    $return_html .= '<i class = "fa fa-thumbs-up fa-1x" aria-hidden = "true"></i>';
                } else {
                    $return_html .= '<i class = "fa fa-thumbs-up fa-1x main_color" aria-hidden = "true"></i>';
                }
                $return_html .= '<span class = "like_As_count">';

                if ($post_business_likes_count > 0) {
                    $return_html .= $post_business_likes_count;
                }

                $return_html .= '</span>
</a>
</li>
<li id = "insertcount' . $post_business_profile_post_id . '" style = "visibility:show">';
                $commnetcount = $this->business_model->getBusinessPostComment($post_id = $post_business_profile_post_id, $sortby = '', $orderby = '', $limit = '');
                $return_html .= '<a onClick = "commentall(this.id)" id = "' . $post_business_profile_post_id . '" class = "ripple like_h_w">
<i class = "fa fa-comment-o" aria-hidden = "true">
</i>
</a>
</li>
</ul>
<ul class = "col-md-6 col-sm-6 col-xs-6 like_cmnt_count">';
                $contition_array = array('post_id' => $row['business_profile_post_id'], 'insert_profile' => '2');
                $postformat = $this->common->select_data_by_condition('post_files', $contition_array, $data = 'post_format', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if ($postformat[0]['post_format'] == 'video') {
                    $return_html .= '<li id="viewvideouser' . $row['business_profile_post_id'] . '">';

                    $contition_array = array('post_id' => $row['business_profile_post_id']);
                    $userdata = $this->common->select_data_by_condition('showvideo', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    $user_data = count($userdata);

                    if ($user_data > 0) {
                        $return_html .= '<div class="comnt_count_ext_a  comnt_count_ext2"><span>';
                        $return_html .= $user_data . ' ' . 'Views';
                        $return_html .= '</span></div></li>';
                    }
                }

                $return_html .= '<li>
<div class = "like_count_ext">
<span class = "comment_count' . $post_business_profile_post_id . '" >';

                if (count($commnetcount) > 0) {
                    $return_html .= count($commnetcount);
                    $return_html .= '<span> Comment</span>';
                }
                $return_html .= '</span>

</div>
</li>

<li>
<div class = "comnt_count_ext">
<span class = "comment_like_count' . $post_business_profile_post_id . '">';
                if ($post_business_likes_count > 0) {
                    $return_html .= $post_business_likes_count;

                    $return_html .= '<span> Like</span>';
                }
                $return_html .= '</span>

</div></li>
</ul>
</div>
</div>';
                if ($post_business_likes_count > 0) {

                    $return_html .= '<div class = "likeduserlist' . $post_business_profile_post_id . '">';

                    $likeuser = $post_business_like_user;
                    $countlike = $post_business_likes_count - 1;
                    $likelistarray = explode(',', $likeuser);

                    $return_html .= '<div class = "like_one_other">';
                    $return_html .= '<a href = "javascript:void(0);" onclick = "likeuserlist(' . $post_business_profile_post_id . ')">';
                    $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $likelistarray[0], 'status' => '1'))->row()->company_name;

                    if (in_array($userid, $likelistarray)) {
                        $return_html .= "You";
                        $return_html .= "&nbsp;";
                    } else {
                        $return_html .= ucfirst($business_fname1);
                        $return_html .= "&nbsp;";
                    }
                    if (count($likelistarray) > 1) {
                        $return_html .= " and ";

                        $return_html .= $countlike;
                        $return_html .= "&nbsp;";
                        $return_html .= "others";
                    }
                    $return_html .= '</a></div>
</div>';
                }

                $return_html .= '<div class = "likeusername' . $post_business_profile_post_id . '" id = "likeusername' . $post_business_profile_post_id . '" style = "display:none">';

                $likeuser = $post_business_like_user;
                $countlike = $post_business_likes_count - 1;
                $likelistarray = explode(', ', $likeuser);

                $likeuser = $post_business_like_user;
                $countlike = $post_business_likes_count - 1;
                $likelistarray = explode(', ', $likeuser);

                $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => '1'))->row()->company_name;

                $return_html .= '<div class = "like_one_other">';
                $return_html .= '<a href = "javascript:void(0);" onclick = "likeuserlist(' . $post_business_profile_post_id . ')">';

                $return_html .= ucfirst($business_fname1);
                $return_html .= "&nbsp;";

                if (count($likelistarray) > 1) {

                    $return_html .= "and";

                    $return_html .= $countlike;
                    $return_html .= "&nbsp;";
                    $return_html .= "others";
                }
                $return_html .= '</a></div>
</div>

<div class = "art-all-comment col-md-12">
<div id = "fourcomment' . $post_business_profile_post_id . '" style = "display:none;">
</div>
<div id = "threecomment' . $post_business_profile_post_id . '" style = "display:block">
<div class = "hidebottomborder insertcomment' . $post_business_profile_post_id . '">';
                $businessprofiledata = $this->data['businessprofiledata'] = $this->business_model->getBusinessPostComment($post_id = $post_business_profile_post_id, $sortby = 'business_profile_post_comment_id', $orderby = 'DESC', $limit = '1');
                if ($businessprofiledata) {
                    foreach ($businessprofiledata as $rowdata) {
                        $companyname = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id']))->row()->company_name;

                        $slugname1 = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id'], 'status' => '1'))->row()->business_slug;

                        $return_html .= '<div class = "all-comment-comment-box">
<div class = "post-design-pro-comment-img">';
                        $business_userimage = $this->db->get_where('business_profile', array('user_id' => $rowdata['user_id'], 'status' => '1'))->row()->business_user_image;

                        if ($business_userimage) {
                            $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $slugname1) . '">';
                            if (IMAGEPATHFROM == 'upload') {
                                if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                                    $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                                } else {
                                    $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '?ver=' . time() . '" alt = "' . $business_userimage . '">';
                                }
                            } else {
                                $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_userimage;
                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                if (!$info) {
                                    $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                                } else {
                                    $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '?ver=' . time() . '" alt = "' . $business_userimage . '">';
                                }
                            }

                            $return_html .= '</a>';
                        } else {
                            $return_html .= '<a href = "' . base_url('business-profile/dashboard/' . $slugname1) . '">';

                            $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE"></a>';
                        }
                        $return_html .= '</div>
<div class = "comment-name"><a href="' . base_url() . 'business-profile/dashboard/' . $slugname1 . '">
<b title = "' . $companyname . '">';
                        $return_html .= $companyname;
                        $return_html .= '</br>';

                        $return_html .= '</b></a>
</div>
<div class = "comment-details" id = "showcomment' . $rowdata['business_profile_post_comment_id'] . '">';

                        $return_html .= '<div id = "lessmore' . $rowdata['business_profile_post_comment_id'] . '" style = "display:block;">';
                        $small = substr($rowdata['comments'], 0, 180);
                        $return_html .= nl2br($this->common->make_links($small));

                        if (strlen($rowdata['comments']) > 180) {
                            $return_html .= '... <span id = "kkkk" onClick = "seemorediv(' . $rowdata['business_profile_post_comment_id'] . ')">See More</span>';
                        }
                        $return_html .= '</div>';
                        $return_html .= '<div id = "seemore' . $rowdata['business_profile_post_comment_id'] . '" style = "display:none;">';
                        $new_product_comment = $this->common->make_links($rowdata['comments']);
                        $return_html .= nl2br(htmlspecialchars_decode(htmlentities($new_product_comment, ENT_QUOTES, 'UTF-8')));
                        $return_html .= '</div>';
                        $return_html .= '</div>
<div class = "edit-comment-box">
<div class = "inputtype-edit-comment">
<div contenteditable = "true" class = "editable_text editav_2" name = "' . $rowdata['business_profile_post_comment_id'] . '" id = "editcomment' . $rowdata['business_profile_post_comment_id'] . '" placeholder = "Enter Your Comment " value = "" onkeyup="commentedit(' . $rowdata['business_profile_post_comment_id'] . ')"  onclick="commentedit(' . $rowdata['business_profile_post_comment_id'] . ')" onpaste = "OnPaste_StripFormatting(this, event);">' . $rowdata['comments'] . '</div>
<span class = "comment-edit-button"><button id = "editsubmit' . $rowdata['business_profile_post_comment_id'] . '" style = "display:none" onClick = "edit_comment(' . $rowdata['business_profile_post_comment_id'] . ')">Save</button></span>
</div>
</div>
<div class = "art-comment-menu-design">
<div class = "comment-details-menu" id = "likecomment1' . $rowdata['business_profile_post_comment_id'] . '">
<a id = "' . $rowdata['business_profile_post_comment_id'] . '" onClick = "comment_like1(this.id)">';

                        $businesscommentlike = $this->data['businesscommentlike'] = $this->business_model->getBusinessLikeComment($post_id = $rowdata['business_profile_post_comment_id']);
                        $likeuserarray = explode(', ', $businesscommentlike[0]['business_comment_like_user']);
                        if (!in_array($userid, $likeuserarray)) {

                            $return_html .= '<i class = "fa fa-thumbs-up" style = "color: #999;" aria-hidden = "true"></i>';
                        } else {
                            $return_html .= '<i class = "fa fa-thumbs-up main_color" aria-hidden = "true">
</i>';
                        }
                        $return_html .= '<span>';

                        if ($rowdata['business_comment_likes_count']) {
                            $return_html .= $rowdata['business_comment_likes_count'];
                        }

                        $return_html .= '</span>
</a>
</div>';
                        $userid = $this->session->userdata('aileenuser');
                        if ($rowdata['user_id'] == $userid) {

                            $return_html .= '<span role = "presentation" aria-hidden = "true"> ·
</span>
<div class = "comment-details-menu">
<div id = "editcommentbox' . $rowdata['business_profile_post_comment_id'] . '" style = "display:block;">
<a id = "' . $rowdata['business_profile_post_comment_id'] . '" onClick = "comment_editbox(this.id)" class = "editbox">Edit
</a>
</div>
<div id = "editcancle' . $rowdata['business_profile_post_comment_id'] . '" style = "display:none;">
<a id = "' . $rowdata['business_profile_post_comment_id'] . '" onClick = "comment_editcancle(this.id)">Cancel
</a>
</div>
</div>';
                        }
                        $userid = $this->session->userdata('aileenuser');
                        $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $rowdata['business_profile_post_id'], 'status' => '1'))->row()->user_id;
                        if ($rowdata['user_id'] == $userid || $business_userid == $userid) {

                            $return_html .= '<span role = "presentation" aria-hidden = "true"> ·
</span>
<div class = "comment-details-menu">
<input type = "hidden" name = "post_delete" id = "post_delete' . $rowdata['business_profile_post_comment_id'] . '" value = "' . $rowdata['business_profile_post_id'] . '">
<a id = "' . $rowdata['business_profile_post_comment_id'] . '" onClick = "comment_delete(this.id)"> Delete
<span class = "insertcomment' . $rowdata['business_profile_post_comment_id'] . '">
</span>
</a>
</div>';
                        }
                        $return_html .= '<span role = "presentation" aria-hidden = "true"> ·
</span>
<div class = "comment-details-menu">
<p>';

                        $return_html .= $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($rowdata['created_date'])));
                        $return_html .= '</br>';

                        $return_html .= '</p>
</div>
</div>
</div>';
                    }
                }
                $return_html .= '</div>
</div>
</div>
<div class = "post-design-commnet-box col-md-12">
<div class = "post-design-proo-img hidden-mob">';

                $userid = $this->session->userdata('aileenuser');
                $business_userimage = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->business_user_image;
                if ($business_userimage) {
                    if (IMAGEPATHFROM == 'upload') {
                        if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_userimage)) {
                            $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                        } else {
                            $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '?ver=' . time() . '" alt = "' . $business_userimage . '">';
                        }
                    } else {
                        $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_userimage;
                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                        if (!$info) {
                            $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                        } else {
                            $return_html .= '<img src = "' . BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage . '?ver=' . time() . '" alt = "' . $business_userimage . '">';
                        }
                    }
                } else {
                    $return_html .= '<img src = "' . base_url(NOBUSIMAGE) . '" alt = "NOBUSIMAGE">';
                }
                $return_html .= '</div>

<div id = "content" class = "col-md-12  inputtype-comment cmy_2" >
<div contenteditable = "true" class = "edt_2 editable_text" name = "' . $post_business_profile_post_id . '" id = "post_comment' . $post_business_profile_post_id . '" placeholder = "Add a Comment ..." onClick = "entercomment(' . $post_business_profile_post_id . ')" onpaste = "OnPaste_StripFormatting(this, event);"></div>
<div class="mob-comment">       
                            <button id="' . $post_business_profile_post_id . '" onClick="insert_comment(this.id)"><img src="' . base_url('assets/img/send.png') . '?ver=' . time() . '" alt="send.png">
                            </button>
                        </div>
</div>
' . form_error('post_comment') . '
<div class = "comment-edit-butn hidden-mob">
<button id = "' . $post_business_profile_post_id . '" onClick = "insert_comment(this.id)">Comment
</button>
</div>

</div>
</div>
</div></div>';
            }
        }

        echo $return_html;
    }

    public function bus_photos() {

        $id = $_POST['bus_slug'];
// manage post start
        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $slug_data = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $slug_id = $slug_data[0]['business_slug'];

        if ($id == $slug_id || $id == '') {

            $contition_array = array('business_slug' => $slug_id, 'status' => '1');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {

            $contition_array = array('business_slug' => $id, 'status' => '1', 'business_step' => '4');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }

        $join_str[0]['table'] = 'post_files';
        $join_str[0]['join_table_id'] = 'post_files.post_id';
        $join_str[0]['from_table_id'] = 'business_profile_post.business_profile_post_id';
        $join_str[0]['join_type'] = '';

        $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'business_profile_post.is_delete' => '0', 'post_files.insert_profile' => '2', 'post_format' => 'image');
        $businessimage = $this->data['businessimage'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = 'file_name', $sortby = 'post_files.created_date', $orderby = 'desc', $limit = '6', $offset = '', $join_str, $groupby = '');

        if ($businessimage) {
            $i = 0;
            foreach ($businessimage as $mi) {
                $fetch_result .= '<div class="image_profile">';
                $fetch_result .= '<img src="' . BUS_POST_RESIZE3_UPLOAD_URL . $mi['file_name'] . '?ver=' . time() . '" alt="' . $mi['file_name'] . '">';
                $fetch_result .= '</div>';

                $i++;
                if ($i == 6)
                    break;
            }
        } else {
            
        }

        $fetch_result .= '<div class = "dataconphoto"></div>';

        echo $fetch_result;
    }

    public function bus_videos() {

        $id = $_POST['bus_slug'];
// manage post start
        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $slug_data = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $slug_id = $slug_data[0]['business_slug'];

        if ($id == $slug_id || $id == '') {

            $contition_array = array('business_slug' => $slug_id, 'status' => '1');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {

            $contition_array = array('business_slug' => $id, 'status' => '1', 'business_step' => '4');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }

        $join_str[0]['table'] = 'post_files';
        $join_str[0]['join_table_id'] = 'post_files.post_id';
        $join_str[0]['from_table_id'] = 'business_profile_post.business_profile_post_id';
        $join_str[0]['join_type'] = '';

        $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'business_profile_post.is_delete' => '0', 'post_files.insert_profile' => '2', 'post_format' => 'video');
        $businessvideo = $this->data['businessvideo'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = 'file_name', $sortby = 'post_files.created_date', $orderby = 'desc', $limit = '6', $offset = '', $join_str, $groupby = '');

        if ($businessvideo) {
            $fetch_video .= '<tr>';

            if ($businessvideo[0]['file_name']) {

                $post_poster = $businessvideo[0]['file_name'];
                $post_poster1 = explode('.', $post_poster);
                $post_poster2 = end($post_poster1);
                $post_poster = str_replace($post_poster2, 'png', $post_poster);

                if (IMAGEPATHFROM == 'upload') {
                    $fetch_video .= '<td class = "image_profile">';
                    if (file_exists($this->config->item('bus_post_main_upload_path') . $post_poster)) {
                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[0]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                } else {
                    $fetch_video .= '<td class = "image_profile">';

                    $postposter = $this->config->item('bus_post_main_upload_path') . $post_poster;
                    $this->data['postposter'] = $postposter = $s3->getObjectInfo(bucket, $postposter);
                    if ($postposter) {
                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }

                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[0]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                }
            }

            if ($businessvideo[1]['file_name']) {
                $post_poster = $businessvideo[1]['file_name'];
                $post_poster1 = explode('.', $post_poster);
                $post_poster2 = end($post_poster1);
                $post_poster = str_replace($post_poster2, 'png', $post_poster);

                if (IMAGEPATHFROM == 'upload') {
                    $fetch_video .= '<td class = "image_profile">';
                    if (file_exists($this->config->item('bus_post_main_upload_path') . $post_poster)) {
                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[1]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                } else {
                    $fetch_video .= '<td class = "image_profile">';

                    $postposter = $this->config->item('bus_post_main_upload_path') . $post_poster;
                    $this->data['postposter'] = $postposter = $s3->getObjectInfo(bucket, $postposter);
                    if ($postposter) {
                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }

                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[1]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                }
            }
            if ($businessvideo[2]['file_name']) {

                $post_poster = $businessvideo[2]['file_name'];
                $post_poster1 = explode('.', $post_poster);
                $post_poster2 = end($post_poster1);
                $post_poster = str_replace($post_poster2, 'png', $post_poster);

                if (IMAGEPATHFROM == 'upload') {
                    $fetch_video .= '<td class = "image_profile">';
                    if (file_exists($this->config->item('bus_post_main_upload_path') . $post_poster)) {
                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[2]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                } else {
                    $fetch_video .= '<td class = "image_profile">';

                    $postposter = $this->config->item('bus_post_main_upload_path') . $post_poster;
                    $this->data['postposter'] = $postposter = $s3->getObjectInfo(bucket, $postposter);
                    if ($postposter) {
                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }

                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[2]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                }
            }
            $fetch_video .= '</tr>';
            $fetch_video .= '<tr>';

            if ($businessvideo[3]['file_name']) {

                $post_poster = $businessvideo[3]['file_name'];
                $post_poster1 = explode('.', $post_poster);
                $post_poster2 = end($post_poster1);
                $post_poster = str_replace($post_poster2, 'png', $post_poster);

                if (IMAGEPATHFROM == 'upload') {
                    $fetch_video .= '<td class = "image_profile">';
                    if (file_exists($this->config->item('bus_post_main_upload_path') . $post_poster)) {
                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[3]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                } else {
                    $fetch_video .= '<td class = "image_profile">';

                    $postposter = $this->config->item('bus_post_main_upload_path') . $post_poster;
                    $this->data['postposter'] = $postposter = $s3->getObjectInfo(bucket, $postposter);
                    if ($postposter) {

                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }

                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[3]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                }
            }
            if ($businessvideo[4]['file_name']) {

                $post_poster = $businessvideo[4]['file_name'];
                $post_poster1 = explode('.', $post_poster);
                $post_poster2 = end($post_poster1);
                $post_poster = str_replace($post_poster2, 'png', $post_poster);

                if (IMAGEPATHFROM == 'upload') {
                    $fetch_video .= '<td class = "image_profile">';
                    if (file_exists($this->config->item('bus_post_main_upload_path') . $post_poster)) {
                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[4]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                } else {
                    $fetch_video .= '<td class = "image_profile">';

                    $postposter = $this->config->item('bus_post_main_upload_path') . $post_poster;
                    $this->data['postposter'] = $postposter = $s3->getObjectInfo(bucket, $postposter);
                    if ($postposter) {

                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[4]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                }
            }
            if ($businessvideo[5]['file_name']) {

                $post_poster = $businessvideo[5]['file_name'];
                $post_poster1 = explode('.', $post_poster);
                $post_poster2 = end($post_poster1);
                $post_poster = str_replace($post_poster2, 'png', $post_poster);

                if (IMAGEPATHFROM == 'upload') {
                    $fetch_video .= '<td class = "image_profile">';
                    if (file_exists($this->config->item('bus_post_main_upload_path') . $post_poster)) {
                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[5]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                } else {
                    $fetch_video .= '<td class = "image_profile">';

                    $postposter = $this->config->item('bus_post_main_upload_path') . $post_poster;
                    $this->data['postposter'] = $postposter = $s3->getObjectInfo(bucket, $postposter);
                    if ($postposter) {

                        $fetch_video .= '<video controls poster="' . BUS_POST_MAIN_UPLOAD_URL . $post_poster . '">';
                    } else {
                        $fetch_video .= '<video controls>';
                    }
                    $fetch_video .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessvideo[5]['file_name'] . '" type = "video/mp4">';
                    $fetch_video .= 'Your browser does not support the video tag.';
                    $fetch_video .= '</video>';
                    $fetch_video .= '</td>';
                }
            }
            $fetch_video .= '</tr>';
        } else {
            
        }

        $fetch_video .= '<div class = "dataconvideo"></div>';
        echo $fetch_video;
    }

    public function bus_audio() {

        $id = $_POST['bus_slug'];
// manage post start
        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $slug_data = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $slug_id = $slug_data[0]['business_slug'];

        if ($id == $slug_id || $id == '') {

            $contition_array = array('business_slug' => $slug_id, 'status' => '1');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {

            $contition_array = array('business_slug' => $id, 'status' => '1', 'business_step' => '4');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }

        $join_str[0]['table'] = 'post_files';
        $join_str[0]['join_table_id'] = 'post_files.post_id';
        $join_str[0]['from_table_id'] = 'business_profile_post.business_profile_post_id';
        $join_str[0]['join_type'] = '';

        $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'business_profile_post.is_delete' => '0', 'post_files.insert_profile' => '2', 'post_format' => 'audio');
        $businessaudio = $this->data['businessaudio'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = 'file_name', $sortby = 'post_files.created_date', $orderby = 'desc', $limit = '6', $offset = '', $join_str, $groupby = '');

        if ($businessaudio) {
            $fetchaudio .= '<tr>';

            if ($businessaudio[0]['file_name']) {
                $fetchaudio .= '<td class = "image_profile"><a href="' . base_url('business-profile/audios/' . $businessdata1[0]['business_slug']) . '"><img src = "' . base_url('assets/images/music-icon.png') . '?ver=' . time() . '" alt="music-icon.png"></a>';
                $fetchaudio .= '<audio controls>';
                $fetchaudio .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessaudio[0]['file_name'] . '" type = "audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</audio>';
                $fetchaudio .= '</td>';
            }

            if ($businessaudio[1]['file_name']) {
                $fetchaudio .= '<td class = "image_profile"><a href="' . base_url('business-profile/audios/' . $businessdata1[0]['business_slug']) . '"><img src = "' . base_url('assets/images/music-icon.png') . '?ver=' . time() . '" alt="music-icon.png"></a>';
                $fetchaudio .= '<audio controls>';
                $fetchaudio .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessaudio[1]['file_name'] . '" type = "audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</audio>';
                $fetchaudio .= '</td>';
            }
            if ($businessaudio[2]['file_name']) {
                $fetchaudio .= '<td class = "image_profile"><a href="' . base_url('business-profile/audios/' . $businessdata1[0]['business_slug']) . '"><img src = "' . base_url('assets/images/music-icon.png') . '?ver=' . time() . '" alt="music-icon.png"></a>';
                $fetchaudio .= '<audio controls>';
                $fetchaudio .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessaudio[2]['file_name'] . '" type = "audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</audio>';
                $fetchaudio .= '</td>';
            }
            $fetchaudio .= '</tr>';
            $fetchaudio .= '<tr>';

            if ($businessaudio[3]['file_name']) {
                $fetchaudio .= '<td class = "image_profile"><a href="' . base_url('business-profile/audios/' . $businessdata1[0]['business_slug']) . '"><img src = "' . base_url('assets/images/music-icon.png') . '?ver=' . time() . '" alt="music-icon.png"></a>';
                $fetchaudio .= '<audio controls>';
                $fetchaudio .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessaudio[3]['file_name'] . '" type = "audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</audio>';
                $fetchaudio .= '</td>';
            }
            if ($businessaudio[4]['file_name']) {
                $fetchaudio .= '<td class = "image_profile"><a href="' . base_url('business-profile/audios/' . $businessdata1[0]['business_slug']) . '"><img src = "' . base_url('assets/images/music-icon.png') . '?ver=' . time() . '" alt="music-icon.png"></a>';
                $fetchaudio .= '<audio controls>';
                $fetchaudio .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessaudio[4]['file_name'] . '" type = "audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</audio>';
                $fetchaudio .= '</td>';
            }
            if ($businessaudio[5]['file_name']) {
                $fetchaudio .= '<td class = "image_profile"><a href="' . base_url('business-profile/audios/' . $businessdata1[0]['business_slug']) . '"><img src = "' . base_url('assets/images/music-icon.png') . '?ver=' . time() . '" alt="music-icon.png"></a>';
                $fetchaudio .= '<audio controls>';
                $fetchaudio .= '<source src = "' . BUS_POST_MAIN_UPLOAD_URL . $businessaudio[5]['file_name'] . '" type = "audio/mp3">';
                $fetchaudio .= 'Your browser does not support the audio tag.';
                $fetchaudio .= '</audio>';
                $fetchaudio .= '</td>';
            }
            $fetchaudio .= '</tr>';
        } else {
            
        }
        $fetchaudio .= '<div class = "dataconaudio"></div>';
        echo $fetchaudio;
    }

    public function bus_pdf() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $id = $_POST['bus_slug'];

        $userid = $this->session->userdata('aileenuser');
        $user_name = $this->session->userdata('user_name');

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $slug_data = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $slug_id = $slug_data[0]['business_slug'];

        if ($id == $slug_id || $id == '') {

            $contition_array = array('business_slug' => $slug_id, 'status' => '1');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {

            $contition_array = array('business_slug' => $id, 'status' => '1', 'business_step' => '4');
            $businessdata1 = $this->data['businessdata1'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }

        $join_str[0]['table'] = 'post_files';
        $join_str[0]['join_table_id'] = 'post_files.post_id';
        $join_str[0]['from_table_id'] = 'business_profile_post.business_profile_post_id';
        $join_str[0]['join_type'] = '';

        $contition_array = array('user_id' => $businessdata1[0]['user_id'], 'business_profile_post.is_delete' => '0', 'post_files.insert_profile' => '2', 'post_format' => 'pdf');
        $businesspdf = $this->data['businessaudio'] = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = 'file_name', $sortby = 'post_files.created_date', $orderby = 'desc', $limit = '6', $offset = '', $join_str, $groupby = '');

        if ($businesspdf) {
            $i = 0;
            foreach ($businesspdf as $mi) {
                $fetch_pdf .= '<div class = "image_profile">';
                $fetch_pdf .= '<a href = "' . BUS_POST_MAIN_UPLOAD_URL . $mi['file_name'] . '" target="_blank"><div class = "pdf_img">';
                $fetch_pdf .= '<img src = "' . base_url('assets/images/PDF.jpg') . '?ver=' . time() . '" alt="PDF.jpg">';
                $fetch_pdf .= '</div></a>';
                $fetch_pdf .= '</div>';

                $i++;
                if ($i == 6)
                    break;
            }
        } else {
            
        }
        $fetch_pdf .= '<div class = "dataconpdf"></div>';
        echo $fetch_pdf;
    }

    

    public function business_profile_active_check() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        if (!$userid) {
            redirect('login');
        }
        // IF USER DEACTIVE PROFILE THEN REDIRECT TO BUSINESS-PROFILE/INDEX UNTILL ACTIVE PROFILE START

        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_deleted' => '0');
        $business_deactive = $this->data['business_deactive'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = ' business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby);

        if ($business_deactive) {
            redirect('business-profile');
        }


// IF USER DEACTIVE PROFILE THEN REDIRECT TO BUSINESS-PROFILE/INDEX UNTILL ACTIVE PROFILE END
// DEACTIVATE PROFILE END
    }

    public function is_business_profile_register() {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        $contition_array = array('user_id' => $userid, 'status' => '1', 'is_deleted' => '0');
        $business_check = $this->data['business_deactive'] = $this->common->select_data_by_condition('business_profile', $contition_array, $data = ' business_profile_id,business_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby);

        if ($business_check) {

            if ($business_check[0]['business_step'] == 1) {
                redirect('business-profile/contact-information', refresh);
            } else if ($business_check[0]['business_step'] == 2) {
                redirect('business-profile/description', refresh);
            } else if ($business_check[0]['business_step'] == 3) {
                redirect('business-profile/image', refresh);
            }
        } else {
            redirect('business-profile/registration/business-information', refresh);
        }

// IF USER DEACTIVE PROFILE THEN REDIRECT TO BUSINESS-PROFILE/INDEX UNTILL ACTIVE PROFILE END
// DEACTIVATE PROFILE END
    }

    // BUSIENSS PROFILE USER FOLLOWING COUNT START

    public function business_user_following_count($business_profile_id = '') {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        if ($business_profile_id == '') {
            $business_profile_id = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->business_profile_id;
        }

        $contition_array = array('follow_from' => $business_profile_id, 'follow_status' => '1', 'follow_type' => '2', 'business_profile.status' => '1', 'business_profile.is_deleted' => '0');

        $join_str_following[0]['table'] = 'follow';
        $join_str_following[0]['join_table_id'] = 'follow.follow_to';
        $join_str_following[0]['from_table_id'] = 'business_profile.business_profile_id';
        $join_str_following[0]['join_type'] = '';

        $bus_user_f_ing_count = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'count(*) as following_count', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str_following, $groupby = '');

        $following_count = $bus_user_f_ing_count[0]['following_count'];

        return $following_count;
    }

    // BUSIENSS PROFILE USER FOLLOWING COUNT END
    // BUSIENSS PROFILE USER FOLLOWER COUNT START

    public function business_user_follower_count($business_profile_id = '') {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        if ($business_profile_id == '') {
            $business_profile_id = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->business_profile_id;
        }

        $contition_array = array('follow_to' => $business_profile_id, 'follow_status' => '1', 'follow_type' => '2', 'business_profile.status' => '1', 'business_profile.is_deleted' => '0');

        $join_str_following[0]['table'] = 'follow';
        $join_str_following[0]['join_table_id'] = 'follow.follow_from';
        $join_str_following[0]['from_table_id'] = 'business_profile.business_profile_id';
        $join_str_following[0]['join_type'] = '';

        $bus_user_f_er_count = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'count(*) as follower_count', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str_following, $groupby = '');

        $follower_count = $bus_user_f_er_count[0]['follower_count'];

        return $follower_count;
    }

    // BUSIENSS PROFILE USER FOLLOWER COUNT END

    public function business_user_contacts_count($business_profile_id = '') {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        if ($business_profile_id != '') {
            $userid = $this->db->get_where('business_profile', array('business_profile_id' => $business_profile_id, 'status' => '1'))->row()->user_id;
        }

        $contition_array = array('contact_type' => '2', 'contact_person.status' => 'confirm', 'business_profile.status' => '1', 'business_profile.is_deleted' => '0');
        $search_condition = "((contact_from_id = ' $userid') OR (contact_to_id = '$userid'))";

        $join_str_contact[0]['table'] = 'business_profile';
        $join_str_contact[0]['join_table_id'] = 'business_profile.user_id';
        $join_str_contact[0]['from_table_id'] = 'contact_person.contact_from_id';
        $join_str_contact[0]['join_type'] = '';

        $contacts_count = $this->common->select_data_by_search('contact_person', $search_condition, $contition_array, $data = 'count(*) as contact_count', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str_contact, $groupby = '');

        $contacts_count = $contacts_count[0]['contact_count'];

        return $contacts_count;
    }

}
